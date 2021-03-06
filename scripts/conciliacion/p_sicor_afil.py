#! python
# -*- coding: utf-8 -*-

import re
try:
    from hashlib import md5
except:
    from md5 import md5

from base64 import b64encode
from datetime import date, datetime

verbose = 1


afil_header = (
    'tipo_tc',
    'tarjeta',
    'importe',
    'codigo1',
    'codigo2',
    'codigo3',
    'num_autorizacion',
    'concepto',
    'fecha',
    'hora',
    'visamc'
    )
afil_header_types = (
    's',
    's',
    'f',
    's',
    's',
    's',
    'i',
    's',
    's',
    's',
    's'
    )

def to_date( s ):
    date_parse = re.compile(r"""
    (?P<fecha_a>\d{4})-
    (?P<fecha_m>\d{2})-
    (?P<fecha_d>\d{2})
    """, re.X)

    m = date_parse.match(s)
    if m:
        return date( int(m.group('fecha_a')),
                     int(m.group('fecha_m')),
                     int(m.group('fecha_d')) )
    else:
        print "Fecha invalida:", s
        return ''

def to_datetime( s ):
    date_parse = re.compile(r"""
    (?P<fecha_a>\d{4})-
    (?P<fecha_m>\d{2})-
    (?P<fecha_d>\d{2}).
    (?P<fecha_H>\d{2}).
    (?P<fecha_M>\d{2}).
    (?P<fecha_S>\d{2})
    """, re.X)

    m = date_parse.match(s)
    if m:
        return datetime( int(m.group('fecha_a')),
                         int(m.group('fecha_m')),
                         int(m.group('fecha_d')),
                         int(m.group('fecha_H')),
                         int(m.group('fecha_M')),
                         int(m.group('fecha_S')),
                         0 )
    else:
        print "Fecha-Hora invalida:", s
        #raise
        return ''

sth_i = """INSERT INTO afil (
tipo_tc,
tarjeta,
num_autorizacion,
importe,
fecha_operacion,
visamc,
cuenta,
id_archivo,
linehash
)
VALUES (
'%s',
'%s',
%s,
%s,
'%s',
'%s',
'%s',
%s,
'%s'
)"""

sth_ic="""INSERT INTO afil (
tipo_tc,
tarjeta,
num_autorizacion,
importe,
fecha_operacion,
visamc,
cuenta,
id_archivo,
aplicado,
linehash
)
VALUES (
'%s',
'%s',
%s,
%s,
'%s',
'%s',
'%s',
%s,
%s,
'%s'
)"""

sth_findsu = """SELECT su.id_saldo_usuario, su.padre, p.duracion, p.id_paquete, su.inicio
FROM saldo_usuario su
JOIN paquete p USING (id_paquete)
LEFT OUTER JOIN afil a ON (su.id_saldo_usuario = a.aplicado)
WHERE su.tarjeta = %s
AND su.operacion = %s
AND su.forma_pago = '%s'
AND su.total = %s
AND a.aplicado IS NULL
"""

sth_upd_saldo_usuario = """
UPDATE saldo_usuario
SET
conciliado='T',
activo='S',
inicio=%s,
vencimiento=%s
WHERE id_saldo_usuario=%s
"""

sth_vencimiento_padre = """SELECT max(vencimiento) AS vencimiento
FROM  saldo_usuario 
WHERE (padre=%s OR id_saldo_usuario=%s)
  AND activo='S'
  AND id_saldo_usuario < %s"""

sth_all_vencimiento_padre = """SELECT id_saldo_usuario, padre, vencimiento, activo
FROM  saldo_usuario 
WHERE (padre=%s OR id_saldo_usuario=%s)
  AND id_saldo_usuario < %s"""

sth_filename_for_hashline = """SELECT p.path, f.filename, f.mtime
FROM files f, paths p
WHERE f.path_no = p.path_no
  AND f.id_file = %s"""


sth_aplicado = """UPDATE afil SET aplicado=%s WHERE ....."""

onumeric = re.compile('[^\d.-]')

def hashline_conocido(hashval, cursor):
    r = ""
    cursor.execute( """SELECT id_archivo FROM afil WHERE linehash='%s' """ % (hashval,))
    if cursor.rowcount > 0:
        (archivo_id,) = cursor.fetchone()
        cursor.execute( sth_filename_for_hashline % (archivo_id,))
        if cursor.rowcount > 0:
            (p, f, mt) = cursor.fetchone()
            r= "Path: %s / %s, %s" % (p, f, str(mt))
    return r
    

def parse_afil( pathname, id_arc, cursor ):
    global verbose
    line_num = 0
    #
    # El num de cta. de la AFILIACION no se encuentra en el archivo,
    # se tendr?? que tomar del nombre
    #
    if pathname.find('7227588') > 0:
        cuenta = 7227588
        forma_pago = 'credito'
    elif pathname.find('7233873') > 0:
        cuenta = 7233873
        forma_pago = 'terminal'
    else:
        print 'No se encontr?? un n??m de cuenta v??lido en:', pathname
        return
    print "# 1"
    if verbose: print "cuenta=", cuenta
    f = open( pathname, "rb")
    for line in f:
        line_num += 1
        ##
        key = md5( line )
        m8 = b64encode( key.digest() )[:22]
        prev = hashline_conocido(m8,cursor)
        if prev:
            print "Hashline previa:", prev, m8
            continue
        ##
        fields = line.split(";")
        l = len(fields)
        print "# 2"
        duracion = 30
        if verbose: print {'pathname':pathname,'line_num':line_num,'fields':fields}
        finicio = """NAD(DATE_ADD(DATE(FROM_UNIXTIME(id_saldo_usuario/1000)), INTERVAL 2 DAY))"""
        fvenci = """DATE_ADD(NAD(DATE_ADD(DATE(FROM_UNIXTIME(id_saldo_usuario/1000)), INTERVAL 2 DAY)),INTERVAL (( %s *periodos)+6)-1 DAY)""" % (duracion,)
        try:
            i = 0
            v = {}
            for fn in afil_header:
                if afil_header_types[i] == 'i':
                    fields[i] = onumeric.sub('', fields[i] )
                    v[fn] = int( fields[i].strip() )
                elif afil_header_types[i] == 'f':
                    fields[i] = onumeric.sub('', fields[i] )
                    v[fn] = float( fields[i].strip() )
                elif afil_header_types[i] == 's':
                    v[fn] = fields[i].strip()
                elif afil_header_types[i] == 'd':
                    v[fn] = to_date( fields[i] )
                i += 1
            print "# 3"
            if verbose: print "v:", v
            fecha_operacion = to_datetime( v['fecha']+" "+v['hora'] )
            #
            # Busca registro en saldo_usuario para aplicar
            #
            tc4 = int( v['tarjeta'][-4:] )
            print "# 4"
            afil_id = 0
            if verbose: print "findsu",sth_findsu % (tc4, v['num_autorizacion'],forma_pago,v['importe'])
            cursor.execute(sth_findsu % (tc4, v['num_autorizacion'],forma_pago,v['importe']))
            if cursor.rowcount > 0:
                (id_saldo_usuario,padre,duracion,id_paquete,inicio_paquete) = cursor.fetchone()
                print "\n\nid_saldo_usuario =",id_saldo_usuario
                finicio = """NAD(DATE_ADD(DATE(FROM_UNIXTIME(id_saldo_usuario/1000)), INTERVAL 2 DAY))"""
                fvenci = """DATE_ADD(NAD(DATE_ADD(DATE(FROM_UNIXTIME(id_saldo_usuario/1000)), INTERVAL 2 DAY)),INTERVAL ( %s *periodos)-1 DAY)""" % (duracion,)
                if padre:
                    if id_paquete == 40: # Paquetes adicionales
                        finicio = """inicio"""
                        fvenci  = """vencimiento"""
                    else:
                        fvenci = """DATE_ADD(NAD(DATE_ADD(DATE(FROM_UNIXTIME(id_saldo_usuario/1000)), INTERVAL 2 DAY)),INTERVAL ( %s *periodos)-1 DAY)""" % (duracion,)

                    cursor.execute(sth_vencimiento_padre % (padre,padre,id_saldo_usuario))
                    if cursor.rowcount > 0:
                        (vencimiento,) = cursor.fetchone()
                        if verbose: print "id_saldo_usuario=",
                        if verbose: print id_saldo_usuario,"padre=",padre,
                        if verbose: print "vencimiento=",vencimiento
                        fpago = date.fromtimestamp( id_saldo_usuario / 1000.0 )
                        if verbose: print "fpago=",vencimiento
                        if id_paquete == 40: # Paquetes adicionales
                            if fpago > inicio_paquete:
                                finicio = """NAD(DATE_ADD(DATE(FROM_UNIXTIME(id_saldo_usuario/1000)), INTERVAL 2 DAY))"""
                        else:
                            if vencimiento and fpago < vencimiento:
                                finicio = """DATE_ADD(DATE('%s'), INTERVAL 1 DAY)""" % (vencimiento,)
                                fvenci  = """DATE_ADD( DATE_ADD(DATE('%s'), INTERVAL 1 DAY),INTERVAL ( %s *periodos)-1 DAY)""" % (vencimiento,duracion)
                    else:
                        print "Error: No se encontr?? al padre(%s) de id_saldo_usuario=%s" % (padre,id_saldo_usuario)
                    if not vencimiento:
                        print "Error: vencimiento is None"
                        cursor.execute(sth_all_vencimiento_padre %
                                       (padre,padre,id_saldo_usuario))
                        for (i,p,v,a) in cursor.fetchall():
                            print "id=%d p=%d v=%s a=%s" % (i,p,v,a)
                else: # no tiene padre, no es renovaci??n
                    pass
                    
                print "# 5"
                print "sth_ic", sth_ic % (v['tipo_tc'],v['tarjeta'],
                                            v['num_autorizacion'],v['importe'],
                                            fecha_operacion,v['visamc'],
                                            cuenta,id_arc,id_saldo_usuario,m8)
                cursor.execute( sth_ic % (v['tipo_tc'],v['tarjeta'],
                                          v['num_autorizacion'],v['importe'],
                                          fecha_operacion,v['visamc'],
                                          cuenta,id_arc,id_saldo_usuario,m8))
                afil_id = cursor.lastrowid
                cursor.execute( sth_upd_saldo_usuario % (finicio,fvenci,id_saldo_usuario))
                if afil_id:
                    print "# 6"
            else:
                # No encontro el registro para conciliar
                print "# 7 Error: No encontr?? el registro para conciliar"
                if verbose: print "sth_i", sth_i  % (v['tipo_tc'],v['tarjeta'],
                                          v['num_autorizacion'],v['importe'],
                                          fecha_operacion,v['visamc'],
                                          cuenta,id_arc,m8)
                cursor.execute( sth_i  % (v['tipo_tc'],v['tarjeta'],
                                          v['num_autorizacion'],v['importe'],
                                          fecha_operacion,v['visamc'],
                                          cuenta,id_arc,m8))
                v['cuenta'] = cuenta
                print "No se aplic??:", pathname, line_num, "registro:", v
        except Exception, e:
            print "# 8"
            print "Error:", e
            print "Linea inval. -- file:", pathname, line_num, "line:", line_num
    f.close()

