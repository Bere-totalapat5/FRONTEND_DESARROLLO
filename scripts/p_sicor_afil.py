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

sth_findsu = """SELECT su.id_saldo_usuario FROM saldo_usuario su
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
inicio=NAD(DATE_ADD(DATE('%s'), INTERVAL 3 DAY)),
vencimiento=DATE_ADD(NAD(DATE_ADD(DATE('%s'), INTERVAL 3 DAY)),INTERVAL ((30*periodos)+5) DAY)
WHERE id_saldo_usuario=%s
"""

sth_concilia = """INSERT INTO conciliacion (id_susicor,id_deposito,id_usuario)
    VALUES(%s,%s,99999)"""

sth_aplicado = """UPDATE afil SET aplicado=%s WHERE ....."""

onumeric = re.compile('[^\d.-]')

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
        ##
        fields = line.split(";")
        l = len(fields)
        print "# 2"
        if verbose: print {'pathname':pathname,'line_num':line_num,'fields':fields}
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
                (id_saldo_usuario,) = cursor.fetchone()
                print "# 5"
                if verbose: print "sth_ic", sth_ic % (v['tipo_tc'],v['tarjeta'],
                                            v['num_autorizacion'],v['importe'],
                                            fecha_operacion,v['visamc'],
                                            cuenta,id_arc,id_saldo_usuario,m8)
                cursor.execute( sth_ic % (v['tipo_tc'],v['tarjeta'],
                                          v['num_autorizacion'],v['importe'],
                                          fecha_operacion,v['visamc'],
                                          cuenta,id_arc,id_saldo_usuario,m8))
                afil_id = cursor.lastrowid
                cursor.execute( sth_upd_saldo_usuario % (fecha_operacion,fecha_operacion,id_saldo_usuario))
                if afil_id:
                    print "# 6"
                    # if verbose: print "sth_concilia", sth_concilia % (id_saldo_usuario, afil_id)
                    # cursor.execute( sth_concilia % (id_saldo_usuario, afil_id))
            
            else:
                # No encontro el registro para conciliar
                print "# 7"
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

