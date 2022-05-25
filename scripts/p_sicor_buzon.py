#! python
# -*- coding: utf-8 -*-

import os, re, datetime
try:
    from hashlib import md5
except:
    from md5 import md5
    
from zipfile import ZipFile
from base64 import b64encode

verbose = 1

gs = re.compile('(\d{11})(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{3})\.(.{3})')

zip_line = re.compile(r"""
(?P<convenio>.{4})
(?P<referencia>.{40})
(?P<importe>.{14})
(?P<cuenta>.{16})
(?P<folio_operacion>.{9})
(?P<fecha_movimiento_a>.{4})
(?P<fecha_movimiento_m>.{2})
(?P<fecha_movimiento_d>.{2})
(?P<hora_movimiento_h>.{2})
(?P<hora_movimiento_m>.{2})
(?P<signo>.{1})
(?P<codigo_operacion>.{4})
(?P<descripcion>.{15})
(?P<centro_operac>.{4})
""", re.X)

txt_line = re.compile(r"""
(?P<cuenta>.{16})
(?P<fecha_movimiento_m>.{2})
(?P<fecha_movimiento_d>.{2})
(?P<fecha_movimiento_a>.{4})
(?P<hora_movimiento_h>.{2})
(?P<hora_movimiento_m>.{2})
(?P<sucursal>.{4})
(?P<codigo_operacion>.{4})
(?P<descripcion>.{40})
(?P<signo>.{1})
(?P<importe>.{14})
(?P<saldo>.{14})
(?P<referencia>.{8})
(?P<concepto>.{40})
""", re.X)

Zdir = {}
Tdir = {}
order = 0

def ctimestamp(Y,m,d,H,M):
    # (Y, m, d, H, M) = [ (int) x for x in (Y, m, d, H, M) ]
    # print "datetime:", Y, m, d, H, M
    (Y, m, d, H, M) = map(int, (Y, m, d, H, M))
    return datetime.datetime(Y, m, d, H, M, 0, 0)

def process_T(k, g, ln, archid):
    global Tdir, order
    ts = ctimestamp(g.group('fecha_movimiento_a'),
                    g.group('fecha_movimiento_m'),
                    g.group('fecha_movimiento_d'),
                    g.group('hora_movimiento_h'),
                    g.group('hora_movimiento_m'))

    cta = str(int(g.group('cuenta')))
    suc = int( g.group('sucursal') )
    co = int( g.group('codigo_operacion') )
    desc = str(g.group('descripcion')).strip()
    signo = g.group('signo')
    importe = float( g.group('importe') ) / 100.0
    saldo = float(g.group('saldo')) / 100.0
    ref = str(g.group('referencia')).strip()
    concepto = str(g.group('concepto')).strip()
    order += 1
    Tdir[ k ] = (order, cta, ts, suc, co, signo, importe, saldo, ref, desc, concepto, ln, archid)
    return

def process_Z(k, g, ln, archid):
    global Zdir, order
    try:
        ts = ctimestamp(g.group('fecha_movimiento_a'),
                        g.group('fecha_movimiento_m'),
                        g.group('fecha_movimiento_d'),
                        g.group('hora_movimiento_h'),
                        g.group('hora_movimiento_m'))
        cnv = str(int(g.group('convenio')))
        ref = str(g.group('referencia')).strip()
        importe = float( g.group('importe') ) / 100.0
        cta = str(int(g.group('cuenta')))
        folio = int(g.group('folio_operacion'))
        signo = g.group('signo')
        co = int( g.group('codigo_operacion') )
        desc = str(g.group('descripcion')).strip()
        suc = int(g.group('centro_operac'))
        order += 1
        Zdir[ k ] = (order, cnv, cta, ts, co, folio, signo, importe, ref, desc, suc, ln, archid)
    except Exception, e:
        print "e Z:", e
    return

sth_zvisited = """SELECT linehash FROM buzon_santander
WHERE DATE_SUB(CURDATE(),INTERVAL 60 DAY) <= fecha_proceso"""

sth_upd_saldo_usuario = """
UPDATE saldo_usuario
SET
conciliado='T',
activo='S',
inicio=date('%s'),
vencimiento=DATE_ADD(date('%s'), INTERVAL (( %s * periodos)+5) DAY)
WHERE id_saldo_usuario=%s
"""

sth_anul = """SELECT id_buzon_santander
 FROM buzon_santander
WHERE folio=%s
  AND centro_oper=%s
  AND signo='+'
ORDER BY fecha_hora DESC
LIMIT 1"""

sth_set_anul = """UPDATE buzon_santander
SET aplicado=NULL
WHERE id_buzon_santander=%s
"""

"""
CREATE TABLE depositos_anulados_pend (
  folio       bigint(20) NOT NULL,
  centro_oper smallint(6)  NOT NULL
) ENGINE=InnoDB ;

CREATE INDEX bs_folio_suc ON buzon_santander (folio,centro_oper);
"""

sth_ins_anulpend = """
INSERT INTO depositos_anulados_pend (folio,centro_oper)
VALUES (%s,%s)
"""

sth_del_anulpend = """
DELETE FROM depositos_anulados_pend
WHERE folio=%s
  AND centro_oper=%s
"""

sth_get_anulpend = """
SELECT bs.id_buzon_santander, bs.folio, bs.centro_oper
FROM buzon_santander bs
INNER JOIN depositos_anulados_pend a ON (a.folio=bs.folio AND a.centro_oper=bs.centro_oper)
WHERE bs.signo='+' AND aplicado IS NOT NULL
"""

sth_find_anulpend = """
SELECT 1 FROM depositos_anulados_pend
WHERE folio=%s
  AND centro_oper=%s
"""

"""
Criterios para las Fechas de Inicio y Vencimiento de los paquetes de servicio
referenciados

Los periodos tienen una duración de 30 días. Exceptuando los paquetes
pagados entre el 15 y 28 de Enero de 2013
en la que la duración del periodo será de 4
días naturales.

La fecha de inicio corresponde a la fecha en la que se recibe el pago

La fecha de vencimiento corresponde al num de periodos adquiridos
por la duracion del periodo.

Se agregan 6 días a la fecha de vencimiento 

Para los pagos realizados en el periodo vacacional decembrino
que corre del día 15 de diciembre 2012 al 6 de enero de 2013,
la fecha de inicio será el 7-Ene-2013

# No: Todos los paquetes adquiridos antes del día 1-Feb, tendrán vencimiento
# el 31-Ene a más tardar.

Poner campo activo en S cuando se recibió el pago, asegurar que la
cancelacion le devuelve el N.

"""

F15dic12 = datetime.datetime(2012, 12, 15, 0, 0, 0, 0)
F07ene13 = datetime.datetime(2013, 01, 07, 0, 0, 0, 0)
F15ene13 = datetime.datetime(2013, 01, 15, 0, 0, 0, 0)
F28ene13 = datetime.datetime(2013, 01, 28, 23, 59, 59, 0)

sth_fpadre = """SELECT vencimiento
FROM saldo_usuario
WHERE id_saldo_usuario=%s"""

def fecha_vigencia(t, v):
    dur = 30
    if verbose > 1: print "FGot",t,
    if t > F15dic12 and t < F07ene13:
        t = F07ene13
    elif t > F15ene13 and t < F28ene13:
        dur = 4
    if v:
        t = v + datetime.timedelta(days=1)
    if verbose > 1: print "Send",t,dur
    return (t,dur)


def parse_buzon( pathname, id_arc, cursor ):
    global Zdir, Tdir, sth_zvisited
    Zdir = {}
    Tdir = {}
    order = 0
    ya = set()
    if 1: print 'Z:',pathname
    try:
        cursor.execute( sth_zvisited )
        for (t,) in cursor.fetchall():
            ya.add(t)
    except Exception, e:
        print "Error Z:",e

    (root, fname) = os.path.split( pathname )
    m = gs.match(fname)
    if m:
        (act,y,m,d,H,M,r,e) = m.groups()
    else:
        print "invalid filename(2):", fname
        return ''
    line_num = 0
    if e == "zip":
        z = ZipFile( pathname,'r')
        for zname in z.namelist():
            # print "zname:", zname
            f = z.open( zname, "r")
            for line in f:
                line_num += 1
                key = md5( line )
                m8 = b64encode( key.digest() )[:22]
                if 1: print "verbose Z", m8, line[:-1]
                if m8 in ya:
                    continue
                ya.add( m8 )
                m = zip_line.match(line)
                # print m.groups()
                if m:
                    try:
                        process_Z( m8, m, line_num, id_arc )
                    except Exception, e:
                        print "error Z:", e, m.groups()
                        print pathname, line_num, m.group('importe'), m.groupdict()
                        pass
                else:
                    print "invalid line:", pathname, ":" , line.strip(r'\n')
    elif e == "txt":
        f = open( pathname, "rb")
        for line in f:
            line_num += 1
            key = md5.new( line ).digest()
            if Tdir.has_key( key ):
                continue
            m = txt_line.match(line)
            if m:
                try:
                    process_T( key, m, line_num, id_arc )
                except:
                    print "error T:", m.groups()
                    print pathname, line_num, "\n", line, m.groupdict()
                    pass
            else:
                print "invalid line:", pathname, ":" , line.strip(r'\n')


    sth_i = """INSERT INTO buzon_santander (
        convenio,
        cuenta,
        fecha_hora,
        cod_oper,
        folio,
        signo,
        importe,
        referencia_santander,
        descripcion,
        centro_oper,
        id_archivo,
        linehash) VALUES ( %s, %s, '%s', %s, %s, '%s', %s, '%s', '%s', %s, %s, '%s')"""

    sth_ic = """INSERT INTO buzon_santander (
        convenio,
        cuenta,
        fecha_hora,
        cod_oper,
        folio,
        signo,
        importe,
        referencia_santander,
        descripcion,
        centro_oper,
        id_archivo,
        linehash,
        aplicado) VALUES ( %s, %s, '%s', %s, %s, '%s', %s, '%s', '%s', %s, %s, '%s', %s)"""

    #sth_findsu = """SELECT id_saldo_usuario FROM saldo_usuario WHERE ref_larga LIKE '%%%s%%'"""
    sth_findsu = """SELECT s.id_saldo_usuario,padre
FROM saldo_usuario s
LEFT OUTER JOIN buzon_santander bs ON (s.id_saldo_usuario=bs.aplicado)
WHERE s.ref_larga='%s'
AND bs.aplicado IS NULL"""

    sth_concilia = """INSERT INTO conciliacion (id_susicor,id_deposito,id_usuario)
    VALUES(%s,%s,99999)"""

    sth_aplicado = """UPDATE buzon_santander SET aplicado=%s WHERE linehash='%s'"""

    allitems = []
    for k, v in Zdir.items():
        vl = [ x for x in v ]
        vl.insert(0,k)
        allitems.append(vl)
    # l.sort(key=lambda x: float(x[1]))
    allitems.sort(key=lambda x: x[3])
    for v in allitems:
        (k,order, cnv, cta, ts, co, folio, signo, importe, ref, desc, suc, ln, archid) = v
        
        estatus = ''
        if ref and desc in ("DEP CHEQ N CGO","DEP EN EFECTIV"): # 0005, 0000
            estatus = 'cobrado'
            ref = ref.ljust(30)
            #buzon_id = 0
            id_saldo_usuario = 0
            padre = 0
            try:
                go_ahead = True
                cursor.execute(sth_find_anulpend % (folio,suc))
                if cursor.rowcount > 0:
                    go_ahead = False
                    print "Anul:",ref,"en",suc,"con folio",folio
                else:
                    cursor.execute( sth_findsu % (ref,))
                if go_ahead and cursor.rowcount > 0:
                    (id_saldo_usuario,padre) = cursor.fetchone()
                    vencim = None
                    if padre:
                        cursor.execute( sth_fpadre % (padre,))
                        if cursor.rowcount > 0:
                            (vencim,) = cursor.fetchone()
                    cursor.execute( sth_ic % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k, id_saldo_usuario))
                    # buzon_id = cursor.lastrowid
                    # if buzon_id:
                    #     cursor.execute( sth_concilia % (id_saldo_usuario, buzon_id))
                    (ts,duracion) = fecha_vigencia(ts,vencim)
                    if verbose: print sth_upd_saldo_usuario % (ts,ts,duracion,id_saldo_usuario)
                    cursor.execute( sth_upd_saldo_usuario % (ts,ts,duracion,id_saldo_usuario))
                else:
                    print "Ref:",ref,"not found."
                    cursor.execute( sth_i % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k))
            except Exception,e :
                print "SQL Error buzon:", e
                print "r_Z:", sth_i % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k)
        elif desc in ("AN DEP EFECTIV",): # 5500
            print "Anulación"
            try:
                cursor.execute( sth_i % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k))
                cursor.execute( sth_ins_anulpend  % (folio,suc))
            except Exception,e :
                print "SQL Error buzon:", e
                print "r_Z:", sth_i % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k)
        else:
            print "Unknow estatus desc [%s] %d" % (desc,co)
            try:
                cursor.execute( sth_i % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k))
            except Exception,e :
                print "SQL Error buzon:", e
                print "r_Z:", sth_i % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k)

    # check for anuls
    """ ANUL
    Si el ANUL llega antes que el DEPOSITO
    - verificar por centro de operación y folio,
    el tipo de op=5500 es ANUL y siempre es negativo.

    Esto debe disparar la búsqueda de la operación correspondiente
    si la encuentra, la pone en pendientes de ANULAR

    Al terminar toda la vuelta, verifica si hay operaciones anulables
    y si las encontramos, borramos el pendiente.
    """

    cursor.execute(sth_get_anulpend)
    if cursor.rowcount > 0:
        allcases = cursor.fetchall()
        for (id_b, folio,suc) in allcases:
            print "Anulando:", id_b
            cursor.execute( sth_set_anul % (id_b,))
            #cursor.execute( sth_ins_anulpend % (folio,suc))


