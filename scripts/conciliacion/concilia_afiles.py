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
inicio=NAD(DATE_ADD(DATE( ???  ), INTERVAL 3 DAY)),
vencimiento=DATE_ADD(NAD(DATE_ADD(DATE('%s'), INTERVAL 3 DAY)),INTERVAL ((30*periodos)+5) DAY)
WHERE id_saldo_usuario=%s
"""

sth_aplicado = """UPDATE afil SET aplicado=%s WHERE id=%s"""


# sth_concilia = """INSERT INTO conciliacion (id_susicor,id_deposito,id_usuario)
#     VALUES(%s,%s,99999)"""

sth_aplicado = """UPDATE afil SET aplicado=%s WHERE ....."""

onumeric = re.compile('[^\d.-]')

    if pathname.find('7227588') > 0:
        cuenta = 7227588
        forma_pago = 'credito'
    elif pathname.find('7233873') > 0:
        cuenta = 7233873
        forma_pago = 'terminal'
    else:
        print 'No se encontró un núm de cuenta válido en:', pathname
        return
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
                print "No se aplicó:", pathname, line_num, "registro:", v
        except Exception, e:
            print "# 8"
            print "Error:", e
            print "Linea inval. -- file:", pathname, line_num, "line:", line_num
    f.close()

