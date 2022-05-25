#! python
# -*- coding: utf-8 -*-

import os, re, datetime
try:
    from hashlib import md5
except:
    from md5 import md5
    
from zipfile import ZipFile
from base64 import b64encode


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
inicio=NAD(date('%s')),
vencimiento=DATE_ADD(NAD(date('%s'),INTERVAL((duracion*periodos)-1) DAY)),
conciliado='T'
WHERE id_saldo_usuario=%s
"""


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
    sth_findsu = """SELECT s.id_saldo_usuario
FROM saldo_usuario s
LEFT OUTER JOIN buzon_santander bs ON (s.id_saldo_usuario=bs.aplicado)
WHERE ref_larga = '%s'
AND bs.aplicado IS NULL"""

    sth_concilia = """INSERT INTO conciliacion (id_susicor,id_deposito,id_usuario)
    VALUES(%s,%s,99999)"""

    sth_aplicado = """UPDATE buzon_santander SET aplicado=%s WHERE linehash='%s'"""

    for k, v in Zdir.items():
        (order, cnv, cta, ts, co, folio, signo, importe, ref, desc, suc, ln, archid) = v
        try:
            estatus = ''
            if ref and desc in ("DEP CHEQ N CGO","DEP EN EFECTIV"):
                estatus = 'cobrado'
            else:
                print "Unknow estatus desc [%s] %d" % (desc,co)
                cursor.execute( sth_i % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k))
                continue
            ref = ref.ljust(30)
            buzon_id = 0
            id_saldo_usuario = 0
            cursor.execute( sth_findsu % (ref,))
            if cursor.rowcount > 0:
                (id_saldo_usuario,) = cursor.fetchone()
                cursor.execute( sth_ic % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k, id_saldo_usuario))
                buzon_id = cursor.lastrowid
                if buzon_id:
                    cursor.execute( sth_concilia % (id_saldo_usuario, buzon_id))
                cursor.execute( sth_upd_saldo_usuario % (ts,ts,id_saldo_usuario))

            else:
                print "Ref:",ref,"not found."
                cursor.execute( sth_i % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k))
                continue

        except Exception,e :
            print "SQL Error buzon:", e
            print "r_Z:", sth_i % (cnv,cta,ts,co,folio,signo,importe,ref,desc,suc, archid, k)

