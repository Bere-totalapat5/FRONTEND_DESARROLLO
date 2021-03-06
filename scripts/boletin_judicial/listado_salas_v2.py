#! python3
# -*- coding: utf-8 -*-

import sys
fecha = ""
try:
    fecha = sys.argv[1]
except:
    pass

if (not fecha):
    print("Falta parámetro de fecha")
    sys.exit(1)

import re
import os
import types
from collections import deque
from datetime import datetime,timedelta
# from time import strftime, strptime, localtime, time

dow = ('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')
mon = ('',"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
       "Agosto","Septiembre","Octubre","Noviembre","Diciembre")

def wout( ov ):
    while '  ' in ov:
        ov = ov.replace('  ',' ')
    ov.replace("\n","")
    return ov + "\n"

mabrev = {
    ""                       : "",
    "PENAL"                  : "Penal",
    "CIVIL"                  : "Civ.",
    "FAMILIAR"               : "Fam.",
    "MERCANTIL"              : "Merc.",
    "PAZ CIVIL"              : "Paz Civ.",
    "PAZ MERCANTIL"          : "Paz Merc.",
    "ORAL CIVIL"             : "Oral Civ.",
    "ORAL MERCANTIL"         : "Oral Merc.",
    "CUANTÍA MENOR CIVIL"    : "C.M. Civ.",
    "CUANTÍA MENOR MERCANTIL": "C.M. Merc."
}
tjabrev = {
    "Actos prejudiciales"             : "Act. Perj. %",
    "Arbitraje comercial"             : "Arb. Com. %",
    "Concurso voluntario y necesario" : "Conc. Vol.",
    "Contraversias de arrendamiento"  : "Controv. Arr.",
    "Controversias del orden familiar": "Controv. %",
    "Convencional o preferente"       : "Conv. o Pref. %",
    "Ejecutivo"                       : "Ejec. %",
    "Especial de fianzas"             : "Esp. Fian.",
    "Especial Hipotecario"            : "Esp. Hip.",
    "Especial"                        : "Esp. %",
    "Exhorto"                         : "Exh. %",
    "Exhortos"                        : "Exh. %",
    "Extinción de dominio"            : "Ext. Dom.",
    "Inmatriculación Judicial"        : "Inmat. Jud.",
    "Juicio arbitral"                 : "J. Arb.",
    "Jurisdicción voluntaria"         : "Juris. Vol. %",
    "Medios preparatorios"            : "Med. Prep. %",
    "Oral"                            : "Oral %",
    "Ordinario civil"                 : "Ord. Civ. %",
    "Ordinario"                       : "Ord. %",
    "Providencias precautorias"       : "Prov. Prec. %",
    "Quiebra"                         : "Quiebra",
    "Sucesorio"                       : "Suc.",
    "Suspensión de pagos"             : "Susp. Pagos",
    "Tercerías"                       : "Ter. %",
    "Venta de prenda"                 : "Vta. Prenda %",
    "Vía de apremio"                  : "Vía Aprem %",
    "Vía ejecutiva"                   : "Vía Ejec.",
    "Vía especial"                    : "Vía Esp.",
    "Juicio especial de levantamiento de acta": "Esp. Lev. Acta",
    "Juicio especial de pérdida de la patria potestad": "Esp. Pérd. P.P.",
    "Pago de daños culposos causados por motivos del transito de vehiculo": "Pago daños Veh. %",
    "Ejecución de garantías otorgadas mediante prenda sin transmisión de posesión y fideicomiso de garantía (procedimiento extrajudicial)": "Ejec. Gar. Prenda Extrajud. %",
    "Ejecución de garantías otorgadas mediante prenda sin transmisión de posesión y fideicomiso de garantía (procedimiento judicial)": "Ejec. Gar. Prenda Jud. %",
    "Ejecución de sentencias dictadas en el extranjero": "Ejec. Sent. Extranjero %",
    "Ejecución de sentencias dictadas en el extranjero, derivadas de juicios": "Ejec. Sent. Extranjero Juicio %",
    "Especial de cancelación y reposición de titulos de crédito": "Esp. Canc. y Rep. %",
}

def prepara_entrada(tipo,juicio,materia,pub,toca,alias,especial,pon,acdos):
    # Abrev. juicio - materia
    if juicio in tjabrev:
        r = tjabrev[ juicio ]
        if "%" in r:
            r = r.replace("%", mabrev[ materia ])
    else:
        r = juicio + " " + mabrev[materia]
    # Toca
    r += " T. " + toca
    if tipo == 'acuerdo':
        if int(acdos) > 1:
            r += " " + acdos + " Acdos."
        else:
            r += " Acdo."
    elif tipo == 'sentencia':
        if int(acdos) > 1:
            r += " " + acdos + " Sents."
        else:
            r += " Sent."
        if pon:
            r += " Pon. " + pon
    elif tipo == 'audiencia':
        if int(acdos) > 1:
            r += " " + acdos + " Auds."
        else:
            r += " Aud."
    # publicar_en
    if pub:
        upub = pub.upper()
        if upub in ('EXPEDIENTE','TOCA'):
            pass
        elif upub == "CUADERNO DE AMAPARO":
            r += " Cuad. Amp."
        elif upub == "CUADERNO DE CONSTANCIAS":
            r += " Cuad. de Const."
        elif upub == "CUADERNO DE AMAPARO: DEMANDADO":
            r += " Cuad. Amp. Dem."
        elif upub == "CUADERNO DE AMAPARO: ACTOR":
            r += " Cuad. Amp. Act."
        elif 'CONSTANCIA' in upub:
            r += " Const."
        elif 'EXPEDIENTILLO' in upub:
            r += " en Expdllo."
        elif 'CUADERNILLO' in upub:
            r += " en Cuadernillo."
        else:
            r += " en " + pub
    if not r.endswith('.'):
        r += "."
    if alias:
        r += " " + alias
    if not r.endswith('.'):
        r += "."
    if especial:
        if especial == "no publicado":
            r += " No Publ."
        elif especial == "mal publicado":
            r += " Mal Publ."
    return r

from tempfile import mkdtemp
mytdir = mkdtemp(prefix='listado_',dir="/var/www/public_html/temporales72")

import MySQLdb
dbd = MySQLdb.connect(db="sibjdf",read_default_file="~/.my.cnf",
                     unix_socket="/var/run/mysqld/mysqld.sock")
cursor   = dbd.cursor()

fecha_arc = fecha

qry = '''SELECT PAD('%s')''' % (fecha,)
cursor.execute( qry )
if cursor.rowcount > 0:
    fecha = str(cursor.fetchone()[0])
#print("Got fecha=%s" % (str(fecha),)) 
try:
    f = datetime.strptime(fecha, "%Y-%m-%d")
    fpub = "del " + str(f.day) + " de " + mon[ f.month ] + " del " + str(f.year)
except Exception as e:
    print("Error en fecha (" + fecha + ") ")
    print(str(e))
    sys.exit(1)

qry = '''SELECT NAD('%s')''' % (fecha,)
cursor.execute( qry )
if cursor.rowcount > 0:
    fecha_qry = str(cursor.fetchone()[0])
listado   = "listado_salas_bj_" + fecha_qry + "_completo.txt"

# todas las salas
qry = '''SELECT j.codigo, j.nombre, a.autoridad, a.titulo
FROM juzgado j
LEFT JOIN autoridad a ON j.codigo = a.juzgado
WHERE j.codigo IN ('1SC','2SC','3SC','4SC','5SC','6SC','7SC','8SC','9SC','10SC','1SF','2SF','3SF','4SF','5SF')
  AND a.secretaria = 'A'
ORDER BY j.orden'''
all_juzgados = deque([])
juzgado_nombres   = {}
juzgado_autoridad = {}

cursor.execute( qry )
if cursor.rowcount > 0:
    for tuple in cursor.fetchall():
        juzgado_nombres[ tuple[0] ] = tuple[1].upper().replace("  "," ")
        if "Secretario" in tuple[3]:
            juzgado_autoridad[ tuple[0] ] = (tuple[2],"EL SECRETARIO DE ACUERDOS")
        else:
            juzgado_autoridad[ tuple[0] ] = (tuple[2],"LA SECRETARIA DE ACUERDOS")
        all_juzgados.append( tuple[0] )
        if 0: print (all_juzgados)
else:
    print("Error en clave de juzgado")
    sys.exit(1)

        
qry = '''SELECT
j.juzgado,
a.tipo,
CONCAT_WS('-', j.toca, j.anio_toca) AS tc,
CONCAT(COALESCE(TRIM(p1.nombre),''), ' VS. ', COALESCE(TRIM(p2.nombre),'')) AS actores,
COALESCE(TRIM(p3.nombre),'') AS terceria,
	cj.juicio, 
	cj.materia, 
	a.concepto, 
	a.publicar_en,
	CONCAT_WS('-', j.toca, j.anio_toca, LPAD(j.asunto_toca,3,'0')) AS toca,
	j.alias,
    a.especial,
    CONCAT(j.secretaria) AS pon,
COUNT(*) AS acuerdos,
a.visibilidad
FROM acuerdo a
LEFT JOIN juicio j                  ON j.id_juicio=a.id_juicio
LEFT JOIN juzgado z                 ON j.juzgado=z.codigo
LEFT OUTER JOIN catalogo_juicios cj ON cj.id_catalogo_juicios=j.id_catalogo_juicios
LEFT OUTER JOIN juicio_partes jp    ON jp.id_juicio=j.id_juicio
LEFT OUTER JOIN parte p1  ON p1.id_parte=jp.id_parte1
LEFT OUTER JOIN parte p2  ON p2.id_parte=jp.id_parte2
LEFT OUTER JOIN parte p3  ON p3.id_parte=jp.id_parte3
WHERE
      j.juzgado IN ('1SC','2SC','3SC','4SC','5SC','6SC','7SC','8SC','9SC','10SC','1SF','2SF','3SF','4SF','5SF')
  AND a.estatus = 30 -- ESTATUS_FIRMADO_Y_APROBADO
  AND a.activacion='%s'
GROUP BY j.toca, j.anio_toca, j.asunto_toca
ORDER BY z.orden,a.tipo, actores, toca
'''
cursor.execute( qry % (fecha_qry))
# print( qry )
if cursor.rowcount < 1:
    print( "Error: No hay publicaciones para: %s" % (fecha,))
    sys.exit(1)

jz_  = ""
tp_  = ""
act_ = ""
ov   = ""
tc_  = ""
toca_= ""

with open(os.path.join(mytdir, listado),"wt", encoding='utf-8') as f:
    for tuple in cursor.fetchall():
        t2 = [ str(x) if x else "" for x in tuple ]
        (jz,tipo,tc,act,ter,juicio,materia,concepto,pub,toca,alias,especial,pon,acdos,vis) = t2
        # f.write("\t".join(("--",jz,tipo,tc,act,ter,juicio,materia,concepto,pub,toca,alias,especial,pon,acdos,vis,"\n")))
        if jz != jz_:
            # -- flush_??
            if ov: f.write(wout(ov))
            if jz_:
                f.write( juzgado_autoridad[ jz_ ][1] + "\n" +  juzgado_autoridad[ jz_ ][0] + "\n")
            ov  = ""
            tp_ = ""
            jz_nvo = all_juzgados.popleft()
            while all_juzgados and jz_nvo != jz:
                f.write("\n" +  juzgado_nombres[ jz_nvo ] + "\nNo hay publicaciones %s\n" % (fpub,))
                jz_nvo = all_juzgados.popleft()
            f.write("\n" +  juzgado_nombres[ jz ] + "\n")
        if tipo != tp_:
            if ov: f.write(wout(ov))
            ov  = ""
            if tipo == 'acuerdo':
                t = "Acuerdos " + fpub + "\n"
                f.write( t.upper() )
            elif tipo == 'sentencia':
                f.write( "SENTENCIAS\n" )
            elif tipo == 'audiencia':
                f.write( "AUDIENCIAS\n" )
        if tc == tc_:
            ov  += ", " + prepara_entrada(tipo,juicio,materia,pub,toca,alias,especial,pon,acdos)
        else:
            # -- flush_??
            if ov: f.write(wout(ov))
            if vis == 'secreto':
                ov = '(secreto) '
            else:
                ov = act
                if ter:
                    ov += " Tercero: " + ter
            ov  += " " + prepara_entrada(tipo,juicio,materia,pub,toca,alias,especial,pon,acdos)

        # fin
        jz_  = jz
        act_ = act
        tp_  = tipo
        tc_  = tc
        toca_= toca
    # fin de qry
    #-- flush_??
    if ov: f.write(wout(ov))
    if jz_:
        f.write( juzgado_autoridad[ jz_ ][1] + "\n" +  juzgado_autoridad[ jz_ ][0] + "\n")
    while all_juzgados:
        jz_nvo = all_juzgados.popleft()
        f.write("\n" +  juzgado_nombres[ jz_nvo ] + "\nNo hay publicaciones %s\n" % (fpub,))

print("OK " + os.path.join(mytdir,listado)[20:])
