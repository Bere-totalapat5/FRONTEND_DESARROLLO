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
    "SICOR":u'''NIÑOS HÉROES, NO. EXT.132, COL. DOCTORES DELEGACIÓN CUAHTEMOC, DISTRITO FEDERAL, MÉXICO, C.P. 06720''',
    "NH":u'''NIÑOS HÉROES, NO. EXT.132, NO. INT. PLANTA BAJA, COL. DOCTORES DELEGACIÓN CUAHTEMOC, DISTRITO FEDERAL, MÉXICO, C.P. 06720''',
    "FS":u'''FRAY SERVANDO TERESA DE MIER, NO.EXT.32, NO.INT. PLANTA BAJA, COL. OBRERA DELEGACIÓN CUAUHTEMOC, DISTRITO FEDERAL, MÉXICO, C.P. 06090''',
    "RP":u'''RÍO DE LA PLATA, NO. EXT.  48 NO. INT. PLANTA BAJA, COL. CUAUHTEMOC, DISTRITO FEDERAL, MÉXICO, C.P. 06500''',
    "PJ":u'''AV. JUÁREZ, NO. EXT. 8, NO. INT. PLANTA BAJA, COL. CENTRO DELEGAIÓN CUAHTEMOC, DISTRITO FEDERAL, MÉXICO, C.P. 06010''',
    "CB":u'''DR. CLAUDIO BERNARD, NO. EXT. 60, NO. INT. PLANTA BAJA, COL. DOCTORES DELEGACIÓN CUAHTEMOC, DISTRITO FEDERAL, MÉXICO, C.P. 06720''',
    "SULL":u'''SULLIVAN, NO. EXT. 133, PLANTA BAJA, COL. SAN RAFAEL, DELEGACIÓN CUAUHTÉMOC, DISTRITO FEDERAL, MÉXICO, C.P. 06470''',
}

expediciones_fact = {
    "SICOR":{"calle":u'NIÑOS HÉROES',
             "noExterior":u"132",
             "colonia":u"DOCTORES",
             "municipio":u"DELEGACIÓN CUAHTEMOC",
             "estado":u"DISTRITO FEDERAL",
             "pais":u"MÉXICO",
             "codigoPostal":u"06720"},
    "NH":{"calle":u'NIÑOS HÉROES',
          "noExterior":u"132",
          "colonia":u"DOCTORES",
          "municipio":u"DELEGACIÓN CUAHTEMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06720"},
    "FS":{"calle":u'FRAY SERVANDO TERESA DE MIER',
          "noExterior":u"32",
          "colonia":u"OBRERA",
          "municipio":u"DELEGACIÓN CUAHTEMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06090"},
    "RP":{"calle":u'RÍO DE LA PLATA',
          "noExterior":u"48",
          "colonia":u"CUAUHTEMOC",
          "municipio":u"DELEGACIÓN CUAHTEMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06500"},
    "PJ":{"calle":u'AV. JUÁREZ',
          "noExterior":u"8",
          "colonia":u"CENTRO",
          "municipio":u"DELEGACIÓN CUAHTEMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06010"},
    "CB":{"calle":u'DR. CLAUDIO BERNARD',
          "noExterior":u"60",
          "colonia":u"DOCTORES",
          "municipio":u"DELEGACIÓN CUAHTEMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06720"},
    "SULL":{"calle":u'SULLIVAN',
          "noExterior":u"133",
          "colonia":u"SAN RAFAEL",
          "municipio":u"DELEGACIÓN CUAHTEMOC",
          "estado":u"DISTRITO FEDERAL",
          "pais":u"MÉXICO",
          "codigoPostal":u"06470"},
    }

ejecutivos_fact = {
    "default":["SICOR","SICOR"],
    "grcarlosalberto":["PJ","MODPJ005"],
    "sgmariojuanluis":["PJ","MODPJ004"],
    "mlelizabethsara":["NH","DERF0005"],
    "francisca.leon":["NH","MODNH001"],
    "francisco.manrique":["FS","MODFS004"],
    "enriqueta.mata":["CB","DERF0010"],
    "nancy.mendoza":["CB","MODCB001"],
    "adriana.castaneda":["RP","MODRP002"],
    "luz.ramirez":["NH","DERF0006"],
    "venta":["NH","VENTA"]
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
    [u"SICOR012",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN E",30.00 ],
    [u"SICOR013",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN F",25.00 ],
    [u"SICOR014",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN G",20.00 ],
    [u"SICOR015",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN H",15.00 ],
    [u"SICOR016",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN I",10.00 ],
    [u"SICOR017",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN J",5.00 ],
    [u"SICOR037",u"SICOR EXPEDIENTE ADICIONAL POR VOLUMEN Z",0.01 ],
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
    "calle":u"NIÑOS HEROES",
    "noExterior":u"132",
    "colonia":u"COL. DOCTORES",
    "localidad":u"MEXICO",
    "municipio":u"DELEGACIÓN CUAUHTEMOC",
    "codigoPostal":u"06720",
    "estado":u"DISTRITO FEDERAL",
    "pais":u"MEXICO"
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
LEFT OUTER JOIN buzon_santander bs ON (bs.aplicado = f.id_saldo_usuario )
LEFT OUTER JOIN afil            a  ON (a.aplicado  = f.id_saldo_usuario )
WHERE codeID IS NULL
  AND su.id_usuario IN (""" + inpruebas + """)
  AND f.comprobante IN ('Factura','Recibo')
  AND (a.aplicado IS NOT NULL or bs.aplicado IS NOT NULL)
ORDER BY id_saldo_usuario"""
        if verbose > 1: print faltan
    else:
        faltan = """SELECT f.id_saldo_usuario
FROM facturacion f
LEFT OUTER JOIN buzon_santander bs ON (bs.aplicado = f.id_saldo_usuario )
LEFT OUTER JOIN afil            a  ON (a.aplicado  = f.id_saldo_usuario )
WHERE codeID IS NULL
  AND comprobante IN ('Factura','Recibo')
  AND (a.aplicado IS NOT NULL or bs.aplicado IS NOT NULL)
ORDER BY id_saldo_usuario"""

    cursor.execute(faltan)
    factyrecs = []
    if cursor.rowcount > 0:
        for (i,) in cursor.fetchall():
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
        if adicionales < 1: adicionales = 1
        if periodos    < 1: periodos    = 1
        precio_paq = resto / (adicionales * periodos)
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
                "cantidad":'%d' % adicionales,
                "importe":'%.2f' % resto,
                }
        conceptos.append( {"concepto":concepto} )

    if no_facturar:
        print "Exepción NO_FACTURAR"
        cursor.execute( sth_updfacturacion % ("1001", "No facturar",
                                              "", "", "", "", IdSaldoUsuario ))
        continue

    modulo = ""
    expedicion = ""
    fusuario = "SICOR"
    c = open("Certificado_TSJ5501014L8.txt","rb")
    certificado = "".join(c.readlines())
    c.close()
    factotal = total

    if ejecutivo and ejecutivos_fact.has_key(ejecutivo):
        (modulo, fusuario) =  ejecutivos_fact[ejecutivo]

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
        esuprueba = "SELECT id_usuario FROM saldo_usuario WHERE id_saldo_usuario=%s"
        cursor.execute(esuprueba,IdSaldoUsuario)
        (idusuario ,) = cursor.fetchone()
        print "Probando",idusuario,"----",
        if idusuario in pruebas_ids:
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
        if verbose: print "Hay serie/folio", serie,"/",folio
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

    if tipo_comprobante == "Factura":
        tipoTransaccion="1"
        docType=1
        documento=1
        URL = "http://184.172.110.242:9025/ws_cer.asmx"
        
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
        c = ET.SubElement(r,"cfdi:Impuestos")
    elif tipo_comprobante == "Recibo":
        tipoTransaccion="1"
        docType=2
        documento=2
        URL = "http://184.172.110.242:9035/ws_cer.asmx"

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
	<idSucursal>1</idSucursal>
	<usuario>%s</usuario>
	<doctoSustituye></doctoSustituye>
	<emailCte>%s</emailCte>
      </MessageAttr>
    </ws_recibirDatosInterface_TSJ>
  </soap:Body>
</soap:Envelope>
''' % (RFC,tipoTransaccion,XML64,docType,documento,fusuario,reccorreo)
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
        r = requests.post("http://184.172.110.242:9055/ws_cer.asmx", headers=headers, data=x)
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
        data = b64decode(xmlf)
        f.write(data)
        f.close()
        elem = ET.fromstring(data)
        serie = elem.attrib["serie"]
        folio = elem.attrib["folio"]
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

"""
TRUNCATE TABLE folioscfdi;
insert into folioscfdi(serie)VALUES('SICOR');
insert into folioscfdi(serie)VALUES('MODPJ');
insert into folioscfdi(serie)VALUES('MODNH');
insert into folioscfdi(serie)VALUES('MODFS');
insert into folioscfdi(serie)VALUES('MODCB');
insert into folioscfdi(serie)VALUES('MODRP');
insert into folioscfdi(serie)VALUES('MODSULL');

update folioscfdi set utlrecibo=0;

update folioscfdi set ultfolio=1   where serie='SICOR';
update folioscfdi set ultfolio=498 where serie='MODPJ';
update folioscfdi set ultfolio=508 where serie='MODNH';
update folioscfdi set ultfolio=212 where serie='MODFS';
update folioscfdi set ultfolio=376 where serie='MODCB';
update folioscfdi set ultfolio=21  where serie='MODRP';
update folioscfdi set ultfolio=0   where serie='MODSULL';


plantillas 2014
periodos vacionacionales
recalcular vigencias
"""

# recibo
"""<?xml version="1.0" encoding="UTF-8"?>
<Recibo xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        version="1.0"
        serie="A"
        folio="66268"
        fecha="2013-12-18T17:05:01" 
	formaDePago="PAGO EN UNA SOLA EXHIBICION"
        subTotal="10"
        TipoCambio="1"
        Moneda="MXN"
        total="10" 
	metodoDePago="EFECTIVO"
        tipoDeComprobante="ingreso" 
	LugarExpedicion="DISTRITO FEDERAL"
        NumCtaPago="1234">
  <Emisor rfc="TSJ5501014L8"
          nombre="TRIBUNAL SUPERIOR DE JUSTICIA DEL DISTRITO FEDERAL">
    <DomicilioFiscal calle="NIÑOS HEROES"
                     noExterior="132"
                     noInterior="123"
                     colonia="DOCTORES"
                     localidad="DISTRITO FEDERAL" 
                     referencia="ref"
                     municipio="DELEGACION CUAUHTEMOC"
                     estado="DISTRITO FEDERAL"
                     pais="MEXICO"
                     codigoPostal="06720" />
    <ExpedidoEn calle="NIÑOS HEROES"
                noExterior="132"
                noInterior="123"
                colonia="DOCTORES"
                localidad="DISTRITO FEDERAL" 
		referencia="ref"
                municipio="DELEGACION CUAUHTEMOC"
                estado="DISTRITO FEDERAL"
                pais="MEXICO"
                codigoPostal="06720" />
    <RegimenFiscal Regimen="PERSONAS MORALES CON FINES NO LUCRATIVOS" />
  </Emisor>
  <Receptor nombre="Alicia"
            materno="Lopez"
            paterno="Ortega" >
    <Domicilio calle="ALDAMA"
               noExterior="44444"
               noInterior="123"
               colonia="CUAUHTEMOC"
               localidad="DF" 
               referencia="ref"
               municipio="JUAREZ"
               estado="DISTRITO FEDERAL"
               pais="MÉXICO"
               codigoPostal="44445" />
  </Receptor>
  <Conceptos>
    <Concepto cantidad="2"
              unidad="PIEZA"
              descripcion="MODULO DE MEDIACION PRIVADA"
              valorUnitario="5"
              importe="10"
              noIdentificacion="1" />
  </Conceptos>
  <Impuestos />
</Recibo>"""

"""
SELECT
IF(ISNULL(su.ref_larga), su.id_saldo_usuario, su.ref_larga) 'Referencia',
FROM_UNIXTIME(su.id_saldo_usuario/1000) 'Fecha de registro SICOR',
su.inicio_anterior 'Inicio anterior',su.inicio 'Fecha inicio', su.vencimiento 'Fecha término',
IF(su.forma_pago='credito', 'Internet', IF(su.forma_pago='referenciado', 'Depósito', 'Terminal')) 'Forma de pago',
su.operacion 'No. de autorización',
pa.nombre 'Paquete Anterior',
p.nombre 'Paquete Nuevo',
su.periodos 'Meses contratados',
IF(su.id_paquete=11 , su.adicionales, 
    IF(su.id_paquete=40 AND ro.id_paquete=11 , su.adicionales, '')) 'Exp. $30',
IF(su.id_paquete=12 OR su.id_paquete=13, su.adicionales, 
    IF(su.id_paquete=40 AND (ro.id_paquete=12 OR ro.id_paquete=13) , su.adicionales, '')) 'Exp. $25',
        IF( !ISNULL(su.id_paquete_anterior) AND su.adicionales<51, su.adicionales, 
    IF( ((su.id_paquete=40 AND ro.id_paquete=14) OR su.id_paquete=14) AND su.adicionales<51, su.adicionales, '') ) 'Exp. $20',
IF( !ISNULL(su.id_paquete_anterior) AND (su.adicionales>50 AND su.adicionales<101), su.adicionales, 
    IF( ((su.id_paquete=40 AND ro.id_paquete=14) OR su.id_paquete=14) AND (su.adicionales>50 AND su.adicionales<101) , su.adicionales,'') ) 'Exp. $15',
IF( !ISNULL(su.id_paquete_anterior) AND (su.adicionales>100 AND su.adicionales<201), su.adicionales, 
    IF( ((su.id_paquete=40 AND ro.id_paquete=14) OR su.id_paquete=14) AND (su.adicionales>100 AND su.adicionales<151) , su.adicionales, '') ) 'Exp. $10',
IF( !ISNULL(su.id_paquete_anterior) AND su.adicionales>200, su.adicionales, 
    IF( ((su.id_paquete=40 AND ro.id_paquete=14) OR su.id_paquete=14) AND su.adicionales>150, su.adicionales,'') ) 'Exp. $5',
CONCAT('$', IF(ISNULL(su.id_paquete_anterior), p.precio * su.periodos,pa.precio*su.periodos)) 'Costo Paquetes',
CONCAT('$', su.total - IF(ISNULL(su.id_paquete_anterior), p.precio * su.periodos,pa.precio*su.periodos)) 'Costo Adicionales',
CONCAT('$',su.total) 'Monto total pagado',
su.recibo 'No. de factura',    
IF(su.id_paquete=40, 'Adicionales', IF(su.padre=0,'Nuevo','Renovación')) 'Tipo de Compra',
IF(ISNULL(ro.ref_larga), ro.id_saldo_usuario, ro.ref_larga) 'Referencia Original'
FROM saldo_usuario su
LEFT JOIN paquete p ON p.id_paquete=su.id_paquete
LEFT JOIN paquete pa ON pa.id_paquete=su.id_paquete_anterior
LEFT JOIN saldo_usuario ro ON su.padre=ro.id_saldo_usuario
WHERE su.activo='S'

"""
