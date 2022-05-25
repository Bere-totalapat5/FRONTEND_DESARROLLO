#!/usr/bin/python
# -*- coding: utf-8 -*-

verbose = 1
en_pruebas = 1
sin_conciliar = 0

import os,sys
if os.access("/tmp/facturando",os.R_OK):
    print "No continúa la facturación, hay otro proceso activo"
    sys.exit(0)
f = open("/tmp/facturando","wb")
f.write("facturando")
f.close()

def do_exit(exit_mode=0):
    db.commit()
    db.close()
    os.unlink("/tmp/facturando")
    sys.exit(exit_mode)


pruebas_ids = [

    1305734654047,
    1305734654048,
    1358438736522,
    1358438934155,
    1358439166133,
    1358439543360,
    1358439756993,
    1358439846978,
    1358440056863,
    1358440143820,
    1358440226837,
    1358440315718,
    1359142099938,
    1364729204720,
    1369011403720,
    1389374342001,
    1389374342002,
    1389374342003,
    1389374342004,
    1389374342005,
    1389374342006,
    1389374342007,
    1389374342008,
    1389374342009,
    1389374342010,
    1389374342011,
    1389374342012,
    1389374342013,
    1389374342014,
    1389374342015,
    1389374342016,
    1389374342017,
    1389374342018,
    1389374342019,
    1389374342020,
    1389374342021,
    1389374342022,
    1389374342023,
    1389374342024,
    1389374342025,
    1389374342026,
    1389374342027,
    1389374342028,
    1389374342029,
    1389374342030,
    1389374342031,
    1389374342032,
    1389374342033,
    1389374342034,
    1389374342035,
    1389975060128,
    1389977472870,
    1389977580855,
    1389977665486,
    1389977747229,
    1389977820916,
    1389977898683,
    1389977974476,
    1389978044964,
    1389978180244,
    1389978248371,
    1389978806934,
    1389979041207,
    1389979776033,
    1389979887175,
    1389980140942,
    1389980260268,
    1389980411966,
    1389980839812,
    1389981892877,
    ]

import xml.etree.ElementTree as ET
import MySQLdb
from base64 import b64encode, b64decode
from time import strptime, strftime, localtime, time, asctime, ctime, mktime
import datetime
import pycurl

domilicios_fact = {
    "SICOR":u'''NIÑOS HÉROES,NO.EXT.132,COL.DOCTORES,DELEGACIÓN CUAUHTÉMOC,DISTRITO FEDERAL,MÉXICO,C.P.06720''',
    "NH":u'''NIÑOS HÉROES,NO.EXT.132,COL.DOCTORES,DELEGACIÓN CUAUHTÉMOC,DISTRITO FEDERAL,MÉXICO,C.P.06720''',
    "FS":u'''FRAY SERVANDO TERESA DE MIER,NO.EXT.132,NO.INT.PLANTA BAJA,COL.OBRERA,DELEGACIÓN CUAUHTÉMOC,DISTRITO FEDERAL,MÉXICO,C.P.06090''',
    "RP":u'''RÍO DE LA PLATA,NO.EXT.48,NO.INT.PLANTA BAJA,COL.CUAUHTÉMOC,DELEGACIÓN CUAUHTÉMOC,DISTRITO FEDERAL,MÉXICO,C.P.06500''',
    "PJ":u'''AV PLAZA JUÁREZ,NO.EXT.8,NO.INT.PLANTA BAJA,COL.CENTRO,DELEGACIÓN CUAUHTÉMOC,DISTRITO FEDERAL,MÉXICO,C.P.06010''',
    "CB":u'''DR.CLAUDIO BERNARD,NO.EXT.60,NO.INT.PLANTA BAJA,COL.DOCTORES,DELEGACIÓN CUAUHTÉMOC,DISTRITO FEDERAL,MÉXICO,C.P.06720''',
    "SULL":u'''SULLIVAN,NO.EXT.133,PLANTA BAJA,COL. SAN RAFAEL,DELEGACIÓN CUAUHTÉMOC,DISTRITO FEDERAL,MÉXICO,C.P.06470''',
}

expediciones_fact = {
    "SICOR":{"calle":u'NIÑOS HÉROES',
             "noExterior":u"132",
             "colonia":u"DOCTORES",
             "municipio":u"DELEGACIÓN CUAUHTÉMOC",
             "estado":u"DISTRITO FEDERAL",
             "pais":u"MÉXICO",
             "codigoPostal":u"06720"},
    "NH":{"calle":u'NIÑOS HÉROES',
          "noExterior":u"132",
          "colonia":u"DOCTORES",
          "municipio":u"DELEGACIÓN CUAUHTÉMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06720"},
    "FS":{"calle":u'FRAY SERVANDO TERESA DE MIER',
          "noExterior":u"32",
          "noInterior":u"PLANTA BAJA",
          "colonia":u"OBRERA",
          "municipio":u"DELEGACIÓN CUAUHTÉMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06090"},
    "RP":{"calle":u'RÍO DE LA PLATA',
          "noExterior":u"48",
          "noInterior":u"PLANTA BAJA",
          "colonia":u"CUAUHTÉMOC",
          "municipio":u"DELEGACIÓN CUAUHTÉMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06500"},
    "PJ":{"calle":u'AV. JUÁREZ',
          "noExterior":u"8",
          "noInterior":u"PLANTA BAJA",
          "colonia":u"CENTRO",
          "municipio":u"DELEGACIÓN CUAUHTÉMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06010"},
    "CB":{"calle":u'DR. CLAUDIO BERNARD',
          "noExterior":u"60",
          "noInterior":u"PLANTA BAJA",
          "colonia":u"DOCTORES",
          "municipio":u"DELEGACIÓN CUAUHTÉMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06720"},
    "SULL":{"calle":u'SULLIVAN',
          "noExterior":u"133",
          "colonia":u"SAN RAFAEL",
          "municipio":u"DELEGACIÓN CUAUHTÉMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06470"},
    }

ejecutivos_fact = {
    "default":["SICOR","SICOR",51],
    "grcarlosalberto":["PJ","MODPJ005",31],
    "sgmariojuanluis":["PJ","MODPJ004",31],
    "mlelizabethsara":["NH","DERF0005",33],
    "francisca.leon":["NH","MODNH001",33],
    "francisco.manrique":["FS","MODFS004",29],
    "enriqueta.mata":["CB","DERF0010",32],
    "nancy.mendoza":["CB","MODCB001",32],
    "adriana.castaneda":["RP","MODRP002",47],
    "luz.ramirez":["NH","DERF0006",33],
    "venta":["NH","VENTA",33]
}

emisor = {
    "nombre":"TRIBUNAL SUPERIOR DE JUSTICIA DEL DISTRITO FEDERAL",
    "rfc":"TSJ5501014L8"
}


sth_getfacturacion = """SELECT `comprobante`, `RFC`, `nombre`,
`calle`, `numero_exterior`, `numero_interior`, `colonia`, `localidad`,
`referencia`, `municipio`, `codigo_postal`, `estado`, `pais`,
`correo`, `serie`, `folio`
FROM facturacion
WHERE id_saldo_usuario=%s
"""

sth_infoventa = """SELECT s.id_paquete, s.periodos, s.adicionales, s.total,
s.operador, u.usuario, p.precio, p.precio_extra
FROM saldo_usuario s
LEFT OUTER JOIN usuarios u ON ( u.id_usuario = s.operador ) 
JOIN paquete p ON ( p.id_paquete = s.id_paquete )
WHERE s.id_saldo_usuario=%s"""

# id_paquete	noIdentificacion	descripcion	valorUnitario

claves_fac = {
    1:[u"SICOR001",u"SICOR SERV. BÁSICO SUSCRIPCION MENSUAL",300.00 ],
    2:[u"SICOR002",u"SICOR SERV. AVISOS SUSCRIPCION MENSUAL",400.00 ],
    3:[u"SICOR003",u"SICOR SERV. INTEGRAL SUSCRIPCION MENSUAL",600.00 ],
    11:[u"SICOR008",u"SICOR PAQUETE INTEGRAL UNITARIO",120.00 ],    
    12:[u"SICOR009",u"SICOR PAQUETE INTEGRAL I",300.00 ],
    13:[u"SICOR010",u"SICOR PAQUETE INTEGRAL II",400.00 ],
    14:[u"SICOR011",u"SICOR PAQUETE INTEGRAL III",600.00 ],
    15:[u"SICOR031",u"SICOR PAQUETE ALTO CONSUMO",0.00 ],
    30:[u"SICOR032",u"SICOR PAQUETE PROMOCIONAL GRATUITO",0.00 ],
    31:[u"SICOR033",u"SICOR PAQUETE PRUEBA DE CREDITO",0.02 ],
    32:[u"SICOR034",u"SICOR PAQUETE PRUEBA ECONOMICA",1.00 ],
    20:[u"SICOR035",u"SICOR CAMBIO DE CONTRASEÑA",1.00 ],
    }

claves_adic = [ 
    [u"SICOR012",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN E",30.00, 100],
    [u"SICOR013",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN F",25.00, 101],
    [u"SICOR014",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN G",20.00, 102],
    [u"SICOR015",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN H",15.00, 103],
    [u"SICOR016",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN I",10.00, 104],
    [u"SICOR017",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN J",5.00,  105],
    [u"SICOR037",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN Z",0.01,  106],
    ]

# Depósito o TC / AFIL

sth_getpago = """SELECT fecha_hora, cuenta, 'E' as formapago
FROM buzon_santander
WHERE aplicado = %s
UNION
SELECT fecha_operacion, cuenta, 'C' as formapago
FROM afil
WHERE aplicado = %s
"""

domiciliofiscal = {
    "calle":u"NIÑOS HÉROES",
    "noExterior":u"132",
    "colonia":u"DOCTORES",
    "localidad":u"MÉXICO",
    "municipio":u"DELEGACIÓN CUAUHTÉMOC",
    "codigoPostal":u"06720",
    "estado":u"DISTRITO FEDERAL",
    "pais":u"MÉXICO"
    }
regimenfiscal = {
    "Regimen":u"PERSONAS MORALES CON FINES NO LUCRATIVOS",
    }


sth_updfacturacion = """UPDATE facturacion SET
codeID='%s',
message='%s',
noCertificadoSAT='%s',
UUID='%s',
FechaTimbrado='%s',
FechaFactura='%s',
ultintento=NOW()
WHERE id_saldo_usuario=%s
"""


sth_insfacturacion = """INSERT INTO facturacion(id_saldo_usuario,
comprobante,nombre,calle,numero_exterior,numero_interior,colonia,
localidad,referencia,municipio,codigo_postal,estado,pais,correo,
codeID,message,serie,folio,FechaFactura,UUID,
FechaTimbrado,ultintento
) VALUES (%s,
'Recibo','%s','%s','%s','%s','%s',
'%s','%s','%s','%s','%s','%s','%s',
'%s','%s','%s','%s','%s','%s',
'%s',NOW())"""

RFC= "TSJ5501014L8"

def insert_attributes(c,n):
    try:
        for k,v in n.items():
            if verbose >1: print "k:",k,"v:",v.encode('utf-8')
            try:
                c.set(k,v)
            except UnicodeEncodeError:
                c.set(k,v.decode("UTF-8"))
            pass
    except Exception as e:
        print "XML Error:", "---", e
    except:
        pass

def tdump(level,e):
    if e is None:
        return
    try:
        chld = e.getchildren()
    except:
        chld = None
        pass
    print level,"\t" * level, "e:", e.tag, e.text.encode('utf-8')
    if e.attrib:
        for k,v in e.attrib.items():
            print "\t" * (level+1), "\tattrib:",k,"=",v.encode("utf-8")
    print "\t" * level,"chld:",chld
    for c in e:
        try:
            if c is not None: tdump(level+1,c)
        except:
            pass
    return

def test(debug_type, debug_msg):
    print "debug(%d): %s" % (debug_type, debug_msg)

def write_response(data):
    f = open(fname,"ab")
    f.write(data)
    f.close()

# db = MySQLdb.connect(db="sibjdf", 
#                      read_default_file="~mdragon/.my.cnf",
#                      unix_socket="/var/run/mysqld/mysqld.sock")
db = MySQLdb.connect(db="sibjdf",user="sicor",passwd="SdbmjHjBq2p3Qsw4",
                     charset='utf8')
db.autocommit(True)
cursor   = db.cursor()

try:
    factyrecs = sys.argv[1:]
except:
    pass

"""SELECT id_saldo_usuario
FROM facturacion
WHERE codeID IS NULL
  AND comprobante IN ('Factura','Recibo')
ORDER BY id_saldo_usuario"""

"SELECT id_usuario FROM saldo_usuario WHERE id_saldo_usuario=%s"

if not factyrecs:
    if en_pruebas:
        inpruebas = ",".join([str(x) for x in pruebas_ids])
        faltan = """SELECT f.id_saldo_usuario
FROM facturacion f
JOIN saldo_usuario su              ON (su.id_saldo_usuario = f.id_saldo_usuario)
JOIN usuarios u                    ON (su.id_usuario = u.id_usuario)
JOIN buzon_santander bs            ON (bs.aplicado = f.id_saldo_usuario )
WHERE f.codeID IS NULL
  AND u.gratuito = 'prueba'
  AND f.comprobante IN ('Factura','Recibo')
ORDER BY id_saldo_usuario DESC"""
        if verbose > 1: print faltan
    else:
        faltan = """SELECT f.id_saldo_usuario
FROM facturacion f
JOIN saldo_usuario su              ON (su.id_saldo_usuario = f.id_saldo_usuario)
JOIN usuarios u                    ON (su.id_usuario = u.id_usuario)
LEFT OUTER JOIN buzon_santander bs ON (bs.aplicado = f.id_saldo_usuario )
LEFT OUTER JOIN afil            a  ON (a.aplicado  = f.id_saldo_usuario )
WHERE f.codeID IS NULL
  AND u.gratuito = 'regular'
  AND comprobante IN ('Factura','Recibo')
  AND (a.aplicado IS NOT NULL or bs.aplicado IS NOT NULL)
ORDER BY id_saldo_usuario"""

    cursor.execute(faltan)
    factyrecs = []
    if cursor.rowcount > 0:
        for (i,) in cursor.fetchall():
            print i
            factyrecs.append(i)

for IdSaldoUsuario in factyrecs:
    no_facturar = 0
    print "\n\n\n--------", IdSaldoUsuario
    if not IdSaldoUsuario:
        print "ERROR: No se definió la compra"
        continue


    mtime = localtime(float( int(IdSaldoUsuario) / 1000 ))
    if verbose > 1: print mtime

    fdir = "/san/files/facturas/" + strftime('%Y/%m/%d',mtime)
    try:
        os.makedirs( fdir )
    except:
        pass
    fact_dir = fdir + "/"

    if verbose > 1: print fdir

    cursor.execute( sth_getfacturacion, IdSaldoUsuario)
    if cursor.rowcount > 0:
        no_hay_facturacion = False
        try:
            (tipo_comprobante, recrfc, recnombre, reccalle,
             recnoExterior, recnoInterior, reccolonia, reclocalidad, recreferencia,
             recmunicipio, reccodigoPostal, recestado, recpais, reccorreo,
             recserie, recfolio) = cursor.fetchone()
        except Exception as e:
            print "SQL Error:", IdSaldoUsuario, "no se obtuvo respuesta"
            # print "SQL Error:", e
            continue
    else: # considerar como recibo
        no_hay_facturacion = True
        (tipo_comprobante, recrfc, recnombre, reccalle,
         recnoExterior, recnoInterior, reccolonia, reclocalidad, recreferencia,
         recmunicipio, reccodigoPostal, recestado, recpais, reccorreo,
         recserie, recfolio) = ("Recibo", "", "DESCONOCIDO", "DESCONOCIDO",
                                "", "", "DESCONOCIDO", "DESCONOCIDO", "",
                                "DESCONOCIDO", "00000", "DESCONOCIDO", "DESCONOCIDO",
                                "DESCONOCIDO", None, None)

    receptor =  {}
    domicilio = {}
    if recnombre:     receptor['nombre'] = recnombre
    if recrfc:        receptor["rfc"] = recrfc

    if reccalle:        domicilio["calle"] = reccalle
    if recnoExterior:   domicilio["noExterior"] = recnoExterior
    if recnoInterior:   domicilio["noInterior"] = recnoInterior
    if recreferencia:   domicilio["referencia"] = recreferencia
    if reccolonia:      domicilio["colonia"] = reccolonia
    if reclocalidad:    domicilio["localidad"] = reclocalidad
    if recmunicipio:    domicilio["municipio"] = recmunicipio
    if reccodigoPostal: domicilio["codigoPostal"] = "%05d" % int(reccodigoPostal)
    if recestado:       domicilio["estado"] = recestado
    if recpais:         domicilio["pais"] = recpais

    if not recrfc:
        tipo_comprobante = "Recibo"

    if verbose > 1:
        print "Domicilio", str(domicilio).encode('utf-8')

    cursor.execute( sth_infoventa, IdSaldoUsuario)
    if cursor.rowcount > 0:
        (id_paquete, periodos, adicionales, total,
         operador, ejecutivo, precio, precio_extra ) = cursor.fetchone()
    else:
        print "Error en infoventa"
        continue

    # precio = float(precio) * 1.00
    # precio_extra = float(precio_extra) * 1.00
    # adicionales = int(adicionales) * 1
    # total = float(total) * 1.0

    if id_paquete in ( 15, 30, 31, 32, 20): #pruebas
        no_facturar = 1
    
    importe = precio * periodos
    if claves_fac.has_key( id_paquete ):
        concepto = {
            "noIdentificacion":claves_fac[ id_paquete ][0],
            "descripcion":claves_fac[ id_paquete ][1],
            "unidad":u"SERVICIO",
            "valorUnitario":'%.2f' % claves_fac[ id_paquete ][2],
            "cantidad":'%d' % periodos,
            "importe":'%.2f' % importe,
            }
        conceptos = [{"concepto":concepto},]
    else:
        conceptos = []

    if total > importe: # or id_paquete == 40:
        resto = total - importe
        adicionales = int(adicionales)
        periodos    = int(periodos)
        if adicionales < 1: adicionales = 1
        if periodos    < 1: periodos    = 1
        # if id_paquete == 40:
        #     adicionales = periodos * adicionales
        #     periodos = 1
        unidades = adicionales * periodos 
        precio_paq = resto / unidades
        adic = [x for x in claves_adic if x[2] == precio_paq]
        if verbose > 1: print "pp,rst,adic,prds,PAQ",precio_paq, resto, adicionales, periodos, adic
        if adic:
            a=adic[0]
        else:
            a= [u"SICOR066",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN VAR",0]
            no_facturar = 1
        concepto = {
                "noIdentificacion": a[0],
                "descripcion": a[1],
                "unidad":u"SERVICIO",
                "valorUnitario":'%.2f' % precio_paq,
                "cantidad":'%d' % unidades,
                "importe":'%.2f' % resto,
                }
        conceptos.append( {"concepto":concepto} )

    # update ventas
    del_ventas = """DELETE FROM ventas WHERE id_saldo_usuario=%s"""
    ins_ventas = """INSERT INTO ventas (id_saldo_usuario,id_paquete,preciounit,cantidad) VALUES (%s,%s,%s,%s)"""
    try:
        cursor.execute( del_ventas % (IdSaldoUsuario,) )
    except:
        pass
    for linea in conceptos:
        if linea["concepto"]:
            idPaquete = 0
            n = linea["concepto"]
            nid = n["noIdentificacion"]
            # print nid,
            for x in claves_adic:
                if x[0] == nid:
                    idPaquete = x[3]
                    # print x
                    break
            if not idPaquete:
                for k,v in claves_fac.items():
                    if v[0] == nid:
                        idPaquete = k
                        # print v
                        break

            cursor.execute( ins_ventas % (IdSaldoUsuario,idPaquete,
                                          n["valorUnitario"],
                                          n["cantidad"]))

    if no_facturar:
        print "Exepción NO_FACTURAR"
        cursor.execute( sth_updfacturacion % ("1001", "No facturar",
                                              "", "", "", "", IdSaldoUsuario ))
        continue

    # ------------------------------------------------------------------------

    modulo = ""
    expedicion = ""
    fusuario = "SICOR"
    fsucursal = 51
    c = open("Certificado_TSJ5501014L8.txt","rb")
    certificado = "".join(c.readlines())
    c.close()
    factotal = total

    if ejecutivo and ejecutivos_fact.has_key(ejecutivo):
        (modulo, fusuario, fsucursal) =  ejecutivos_fact[ejecutivo]

    if modulo:
        serie = u"MOD" + modulo
    else:
        modulo = u"SICOR"
        serie = modulo

    if tipo_comprobante == "Factura":
        sth_getultfolio = """SELECT ultfolio
    FROM folioscfdi
    WHERE serie=%s
    """
        sth_incultfolio = """UPDATE folioscfdi
    SET  ultfolio=ultfolio+1
    WHERE serie=%s
    """
    else:
        sth_getultfolio = """SELECT ultrecibo
    FROM folioscfdi
    WHERE serie=%s
    """
        sth_incultfolio = """UPDATE folioscfdi
    SET  ultrecibo=ultrecibo+1
    WHERE serie=%s
    """
    sth_updfolio = """UPDATE facturacion
    SET serie='%s', folio='%s'
    WHERE id_saldo_usuario=%s"""


    # db.commit()

    if en_pruebas:
        esuprueba = """SELECT s.id_usuario, u.gratuito
        FROM saldo_usuario s, usuarios u
        WHERE s.id_saldo_usuario=%s
          AND u.id_usuario=s.id_usuario"""
        cursor.execute(esuprueba,IdSaldoUsuario)
        (idusuario,gratuito) = cursor.fetchone()
        print "Probando",idusuario,"----",gratuito,
        if gratuito == "prueba":
            print "OK"
        else:
            print "no es de pruebas."
            continue

    fpago = ""
    cursor.execute( sth_getpago % (IdSaldoUsuario, IdSaldoUsuario))
    try:
        (fpago,cuenta,formapago) = cursor.fetchone()
        l = datetime.datetime.now()
        lim = l - datetime.timedelta(hours=70)
        f = fpago
        if verbose:
            print "Pago:",fpago,cuenta,formapago
            print "l,f,lim",l,f,lim
        
        if f > l: # fecha en el futuro
            fpago = l
        elif f < lim: # demasiado antigua
            fpago = lim
        else:
            fpago = f
        fecha_factura = strftime("%Y-%m-%dT%H:%M:%S",fpago.timetuple())
        FechaFactura =  strftime("%Y-%m-%d %H:%M:%S",fpago.timetuple())
    except:
        if en_pruebas and sin_conciliar:
            print "OK"
            fpago = localtime(3600 * 24 * 3 + float( int(IdSaldoUsuario) / 1000 ))
            ahora = mktime(localtime())
            tfactura = mktime(fpago)
            if verbose: print "tfactura=",tfactura,"> ahora=",ahora
            fpago = localtime( min(ahora,tfactura) )
            fecha_factura = strftime("%Y-%m-%dT%H:%M:%S",fpago)
            FechaFactura = strftime("%Y-%m-%d %H:%M:%S",fpago)
            cuenta = 65502919118
            formapago = 'E'
        else:
            fpago = ""
        pass

    if not fpago:
        print "ERROR: Esta compra no ha sido pagada", IdSaldoUsuario
        continue

    if recfolio:
        serie = recserie
        folio = recfolio
        if verbose: print tipo_comprobante, "-- serie/folio", serie,"/",folio
    else:
        cursor.execute( sth_getultfolio, serie )
        if cursor.rowcount > 0:
            try:
                (folio,) = cursor.fetchone()
                cursor.execute( sth_incultfolio, serie )
                folio += 1
                cursor.execute( sth_updfolio % (serie,folio,IdSaldoUsuario))
                if verbose: print "Upd", sth_updfolio % (serie,folio,IdSaldoUsuario)
            except Exception as e:
                print "SQL Error:", "---", e
                folio = 999999
                pass
        else:
            print "Error: no se encontró el folio para la serie:",serie
            continue

    # pendientes de obtener por clacones
    metodoDePago = {
        'E':u"EFECTIVO",
        'C':u"TARJETA DE CRÉDITO O DÉBITO",
        'H':u"CHEQUE",
        'T':u"TRANSFERENCIA ELECTRÓNICA"
        }[formapago]

    cuenta=str(cuenta)
    cuenta=u"NO IDENTIFICADO"

    comprobante = {
        "xmlns:cfdi":"http://www.sat.gob.mx/cfd/3",
        "xmlns:xsi":"http://www.w3.org/2001/XMLSchema-instance",
        "xsi:schemaLocation":"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd",
        "version":"3.2",
        "tipoDeComprobante":"ingreso",
        "NumCtaPago":cuenta,
        "noCertificado":"00001000000201037497",
        "Moneda":"MXN",
        "LugarExpedicion":domilicios_fact[modulo],
        "fecha":fecha_factura,
        "folio":'%07d' % int(folio),
        "serie":serie,
        "sello":"",
        "certificado":certificado,
        "metodoDePago":metodoDePago,
        "formaDePago":u"PAGO EN UNA SOLA EXHIBICIÓN",
        "subTotal":'%.2f' % factotal,
        "total":'%.2f' % factotal,
        }

    recibo = {
        "folio":'%07d' % int(folio),
        "serie":serie,
        "xmlns:xsi":"http://www.w3.org/2001/XMLSchema-instance",
        "version":"1.0",
        "LugarExpedicion":domilicios_fact[modulo],
        "fecha":fecha_factura,
        "formaDePago":u"PAGO EN UNA SOLA EXHIBICIÓN",
        "tipoDeComprobante":u"ingreso",
        "metodoDePago":metodoDePago,
        "Moneda":"MXN",
        "NumCtaPago":cuenta,
        "subTotal":'%.2f' % factotal,
        "total":'%.2f' % factotal,
        }
    #  TipoCambio="1"


    expedidoen = expediciones_fact[modulo]

    empty_list = []
    e = {}
    ppp = {}
    foliobancario = {"folioBanc":str(IdSaldoUsuario)}

    if tipo_comprobante == "Factura":
        tipoTransaccion="1"    # 1: Emisión, 2:Cancelación 
        docType=1              # 1: XML                    
        documento=1            # 1: CFDI Factura, 2: Recibo
        addic_factura = ""    

        URL = "http://184.172.110.242:11102/ws_cer.asmx"
        r = ET.Element("cfdi:Comprobante")
        insert_attributes(r,comprobante)
        c = ET.SubElement(r,"cfdi:Emisor")
        insert_attributes(c,emisor)
        c2 = ET.SubElement(c,"cfdi:DomicilioFiscal")
        insert_attributes(c2,domiciliofiscal)
        c2 = ET.SubElement(c,"cfdi:ExpedidoEn")
        insert_attributes(c2,expedidoen)
        c2 = ET.SubElement(c,"cfdi:RegimenFiscal")
        insert_attributes(c2,regimenfiscal)
        c = ET.SubElement(r,"cfdi:Receptor")
        insert_attributes(c,receptor)
        c2 = ET.SubElement(c,"cfdi:Domicilio")
        insert_attributes(c2,domicilio)
        c = ET.SubElement(r,"cfdi:Conceptos")
        for linea in conceptos:
            if linea["concepto"]:
                n = linea["concepto"]
                c2 = ET.SubElement(c,"cfdi:Concepto")
                insert_attributes(c2,n)
        c = ET.SubElement(r,"cfdi:FoliosBancarios")
        c2 = ET.SubElement(c,"cfdi:FolioBancario")
        insert_attributes(c2,foliobancario)
        c = ET.SubElement(r,"cfdi:Impuestos")
    elif tipo_comprobante == "Recibo":
        tipoTransaccion="1"    # 1: Emisión, 2:Cancelación 
        docType=2              # 1: CFDI Factura 2: Recibo
        documento=2            # 1: CFDI Factura, 2: Recibo, 3: Nómina

        URL = "http://184.172.110.242:11101/ws_cer.asmx"        
        addic_factura = ""
        otros = """
        <idSucursalEmisor></idSucursalEmisor>
        <noEmpleado></noEmpleado>
        <noExpediente></noExpediente>"""
        r = ET.Element("Recibo")
        insert_attributes(r,recibo)
        c = ET.SubElement(r,"Emisor")
        insert_attributes(c,emisor)
        c2 = ET.SubElement(c,"DomicilioFiscal")
        insert_attributes(c2,domiciliofiscal)
        c2 = ET.SubElement(c,"ExpedidoEn")
        insert_attributes(c2,expedidoen)
        c2 = ET.SubElement(c,"RegimenFiscal")
        insert_attributes(c2,regimenfiscal)
        c = ET.SubElement(r,"Receptor")
        if receptor.has_key("rfc"):
            del receptor["rfc"]
        insert_attributes(c,receptor)
        c2 = ET.SubElement(c,"Domicilio")
        insert_attributes(c2,domicilio)
        c = ET.SubElement(r,"Conceptos")
        for linea in conceptos:
            if linea["concepto"]:
                n = linea["concepto"]
                c2 = ET.SubElement(c,"Concepto")
                insert_attributes(c2,n)
        c = ET.SubElement(r,"FoliosBancarios")
        c2 = ET.SubElement(c,"FolioBancario")
        insert_attributes(c2,foliobancario)
        c = ET.SubElement(r,"Impuestos")
    else:
        print "tipo de comprobante inválido",tipo_comprobante
        continue

    if not reccorreo:
        reccorreo = ""

    ppp =  ET.tostring(r, encoding="UTF-8", method="xml")
    ppp =  ppp.replace("\n","\r\n")
    # # print ppp
    # import xml.dom.minidom
    # xml = xml.dom.minidom.parseString(ppp)
    # to_ofile = xml.toprettyxml(indent='  ').encode("UTF-8")
    ofile = open( fact_dir  + "acertifac_" + str(IdSaldoUsuario) + "_fact.xml","wb")
    # ofile.write( to_ofile )
    ofile.write(ppp)
    ofile.close()

    XML64 = b64encode(ppp)
    fname = fact_dir + "certifacresponse_"+str(IdSaldoUsuario)+".dat"
    if os.access(fname,os.R_OK):
        try:
            os.unlink(fname)
        except:
            pass
    x  = '''<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <ws_recibirDatosInterface_TSJ xmlns="http://tempuri.org/">
      <RFC>%s</RFC>
      <tipoTransaccion>%s</tipoTransaccion>
      <XML64>%s</XML64>
      <docType>%d</docType>
      <Documento>%d</Documento>
      <MessageAttr>
	<idSucursal>%s</idSucursal>%s
	<usuario>%s</usuario>
	<doctoSustituye></doctoSustituye>
	<emailCte>%s</emailCte>
      </MessageAttr>
    </ws_recibirDatosInterface_TSJ>
  </soap:Body>
</soap:Envelope>
''' % (RFC,tipoTransaccion,XML64,docType,documento,
       fsucursal,addic_factura,fusuario,reccorreo)
    ofile = open( fact_dir  + "acertifac_" + str(IdSaldoUsuario) + "_soap.xml","wb")
    ofile.write(x)
    ofile.close()

    if 0 and en_pruebas and verbose:
        print "\n",x,"\n"

    lngth = str(len(x))

    if 0:
        headers = {
            "Content-Type": "text/xml; charset=utf-8",
            "Content-Length": lngth,
            "SOAPAction": "http://tempuri.org/ws_recibirDatosInterface_TSJ"
            }
        import requests
        r = requests.post(URL, headers=headers, data=x)
        print r.status_code
        print r.headers
        print r.content

    curlheaders = [
        "Content-Type: text/xml; charset=utf-8",
        "Content-Length: " + lngth,
        "SOAPAction: http://tempuri.org/ws_recibirDatosInterface_TSJ",
        "Expect: "
        ]

    c = pycurl.Curl()
    c.setopt(c.URL, URL)
    c.setopt(c.POSTFIELDS, x.encode('utf-8'))
    c.setopt(c.POST, 1)
    c.setopt(c.HTTPHEADER, curlheaders)
    #c.setopt(c.VERBOSE, 1)
    #c.setopt(pycurl.DEBUGFUNCTION, test)
    c.setopt(c.WRITEFUNCTION, write_response)
    try:
        f = open(fname,"wb")
        f.write("")
        f.close()
        c.perform()
    except Exception as e:
        print "CURL ERROR:", e
        continue
    c.close()

    tree = ET.parse(fname)
    elem = tree.getroot()
    # elem = elem.find('{http://schemas.xmlsoap.org/soap/envelope/}Body')
    # elem = elem.find('{http://tempuri.org/}ws_recibirDatosInterfaceResponse')
    # elem = elem.find('{http://tempuri.org/}ws_recibirDatosInterfaceResult')

    nsd = '{http://schemas.xmlsoap.org/soap/envelope/}Body/' + \
          '{http://tempuri.org/}ws_recibirDatosInterface_TSJResponse/' + \
          '{http://tempuri.org/}ws_recibirDatosInterface_TSJResult/'

    # print "elem=",elem

    codeID  = elem.findtext(nsd + "{http://tempuri.org/}codeID")
    message = elem.findtext(nsd + "{http://tempuri.org/}message")
    pdff    = elem.findtext(nsd + "{http://tempuri.org/}pdf")
    xmlf    = elem.findtext(nsd + "{http://tempuri.org/}xml")

    if not message: message=""
    if not pdff:    pdff=""
    if not xmlf:    xmlf=""

    if verbose:
        print "codeID  ",codeID
        try:
            print "message ",message.encode('utf-8')
            print "pdff    ",len(pdff)
            print "xmlf    ",len(xmlf)
        except:
            pass
    else:
        print "codeID=",codeID,
        try:
            print "message=",message.encode('utf-8')
        except:
            pass

    if pdff:
        f = open(fact_dir + "factura_"+str(IdSaldoUsuario)+".pdf","wb")
        data = b64decode(pdff)
        f.write(data)
        f.close()

    tree = None
    if xmlf:
        f = open(fact_dir + "factura_"+str(IdSaldoUsuario)+".xml","wb")
        try:
            data = b64decode(xmlf)
        except Exception as e:
            print "base64 decode error:",e
            data = ""
        f.write(data)
        f.close()
        try:
            elem = ET.fromstring(data)
            serie = elem.attrib["serie"]
            folio = elem.attrib["folio"]
        except Exception as e:
            print "XML error:",e
            serie = ""
            folio = ""
    else:
        elem = None
        serie = ""
        folio = ""

    # tdump(1,elem)
    # print "=" * 66

    nsd = '{http://www.sat.gob.mx/cfd/3}Complemento/' + \
          '{http://www.sat.gob.mx/TimbreFiscalDigital}TimbreFiscalDigital/'

    try:
        e = elem.find('{http://www.sat.gob.mx/cfd/3}Complemento/' + \
                      '{http://www.sat.gob.mx/TimbreFiscalDigital}TimbreFiscalDigital')
        # tdump(1,e)

        UUID             = e.attrib["UUID"]
        noCertificadoSAT = e.attrib["noCertificadoSAT"]
        FechaTimbrado    = e.attrib["FechaTimbrado"].replace("T"," ")
    except:
        UUID             = ""
        noCertificadoSAT = ""
        FechaTimbrado    = "0000-00-00 00:00:00"
        pass

    if not FechaTimbrado:
        FechaTimbrado    = "0000-00-00 00:00:00"

    if verbose:
        m =  sth_updfacturacion % (codeID,message,noCertificadoSAT, UUID,
                                     FechaTimbrado,FechaFactura,IdSaldoUsuario )
        print m.encode('utf-8')
        del m

    if no_hay_facturacion:
        cursor.execute( sth_insfacturacion,
                        IdSaldoUsuario, recnombre, reccalle, recnoExterior,
                        recnoInterior, reccolonia, reclocalidad, recreferencia,
                        recmunicipio, reccodigoPostal, recestado, recpais, reccorreo,
                        codeID,db.escape_string(message.encode('utf-8')),serie,folio,FechaFactura,UUID,FechaTimbrado)
    else:
        cursor.execute( sth_updfacturacion % (codeID,
                                              db.escape_string(message.encode('utf-8')),
                                              noCertificadoSAT, UUID,
                                              FechaTimbrado,FechaFactura,
                                              IdSaldoUsuario ))
    db.commit()


do_exit(0)
