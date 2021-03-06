#! python3
# -*- coding: utf-8 -*-
this_config="sicor"

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

tags = {
    "start"  :"",
    "end"    :"\n",
    "body"   :"",
    "body_"  :"\n",
    "elsec"  :"",
    "elsec_" :"\n",
    "sala"   :"\n",
    "sala_"  :"\n",
    "sec"    :"",
    "sec_"   :"\n",
    "titacu" :"",
    "titacu_":"\n",
    "titsen" :"",
    "titsen_":"\n"
}

ptags = {
    "start"  :'<html><head><meta charset="UTF-8"></head><body>\n',
    "end"    :"</body></html>\n",
    "body"   :"<P> ",
    "body_"   :"</P>\n",
    "sala"   :"\n<H3 class='juzgado'>",
    "sala_"  :"</H3>\n",
    "elsec"  :"<h6 class='Firma'>",
    "elsec_" :"</br>\n",
    "sec"    :"",
    "sec_"   :"</h6>\n<p class='Fin_secretaria' />\n",
    "titsen" :"<h5 class='tipo'>",
    "titsen_":"</h5>\n",
    "titacu" :"<H4 class='secretaria'>",
    "titacu_":"</H4>\n"
}

if len(sys.argv) > 2:
    if sys.argv[2] == "lo":
        tags = ptags
    elif sys.argv[2] == "vp":
        tags = ptags
        css_style = """body{font-family:'Arial Narrow',Arial,sans-serif;-webkit-column-count:2;-moz-column-count:2;column-count:2;-webkit-column-gap:1.2em;-moz-column-gap:1.2em;column-gap:1.2em;text-align:justify;}H3.Juzgado,H4.SECRETARIA{text-transform:uppercase !important;font-family:Arial,sans-serif;}H4.SECRETARIA{font-family:"Arial Narrow",Arial,sans-serif;}P{padding-left:1.2em;text-indent:-1.2em;margin:0;font-size:9pt;}H5.TIPO{text-transform:uppercase;margin:0;font-size:9pt;font-family:Arial,sans-serif;}H6.FIRMA{text-transform:uppercase;font-weight:normal;margin-top:0.8em;font-family:Arial,sans-serif;}"""
        tags["start"] = '<html><head><meta charset="UTF-8"><style>'+css_style+'</style></head><body>\n'

codigoeq = """IN ('1SC','2SC','3SC','4SC','5SC','6SC','7SC','8SC','9SC','10SC','1SF','2SF','3SF','4SF','5SF')"""
if len(sys.argv) > 3 and sys.argv[3] in ('1SC','2SC','3SC','4SC','5SC','6SC','7SC','8SC','9SC','10SC','1SF','2SF','3SF','4SF','5SF','SC100'):
    codigoeq = """= '%s'""" % sys.argv[3]

def tag(t,s):
    tend = t + "_"
    if t in tags and tend in tags:
        if not s.endswith(" "):
            s += " "
        s = tags[t] + s + tags[ tend ]
    return s

def wout( ov ):
    if ov:
        while '  ' in ov:
            ov = ov.replace('  ',' ')
        ov.replace("\n","")
    return tag("body",ov)

mabrev = {
    ""                                : "",
    "PENAL"                           : "Penal",
    "CIVIL"                           : "Civ.",
    "FAMILIAR"                        : "Fam.",
    "MERCANTIL"                       : "Merc.",
    "PAZ CIVIL"                       : "Paz Civ.",
    "PAZ MERCANTIL"                   : "Paz Merc.",
    "ORAL CIVIL"                      : "Oral Civ.",
    "ORAL MERCANTIL"                  : "Oral Merc.",
    "CUANTÍA MENOR CIVIL"             : "C.M. Civ.",
    "CUANTÍA MENOR MERCANTIL"         : "C.M. Merc."
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
    "Vía de apremio"                  : "Vía Aprem. %",
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

tipo_expediente = {
    "toca"			              : "Toca",
    "amparo_directo"		      : "Cuaderno de Amparo directo",
    "amparo_indirecto"		      : "Cuaderno de Amparo indirecto",
    "amparo_exploratorio"	      : "Cuaderno de Amparo exploratorio",
    "expedientillo"		          : "Expedientillo",
    "expedientillo_no_corresponde": "Expedientillo que no corresponde"
}
    
def prepara_entrada(tipo,juicio,materia,pub,toca,anotacion,tipo_expediente,cuaderno,especial,fecha_especial,pon,acdos):
    # Abrev. juicio - materia
    if juicio in tjabrev:
        r = tjabrev[ juicio ]
        if "%" in r:
            r = r.replace("%", mabrev[ materia ])
    else:
        r = juicio + " " + mabrev[materia]
    # Toca
    r += " T. " + toca
    if anotacion: anotacion = anotacion.strip()
    if cuaderno:  cuaderno  = cuaderno.strip()
    if pub:       pub       = pub.strip()
    if anotacion:
        r += " " + anotacion

    if tipo_expediente in ("amparo_directo","amparo_indirecto","amparo_exploratorio"):
        r += " Cuad. Amp."
        if cuaderno:
            r+= " " + cuaderno + ","
    elif tipo_expediente in ("expedientillo","expedientillo_no_corresponde"):
        r += " Expdllo."
    if not (r.endswith('.') or r.endswith(",")):
        r += "."

    if tipo == 'acuerdo':
        if int(acdos) > 1:
            r += " " + acdos + " Acdos."
        else:
            r += " 1 Acdo."
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
    if pub and tipo_expediente == "toca":
        upub = pub.upper()
        if upub in ('EXPEDIENTE','TOCA'):
            pass
        elif upub == "CUADERNO DE CONSTANCIAS":
            r += " en Cuad. de Const."
        elif upub == "CUADERNO DE AMAPARO: DEMANDADO":
            r += " en Cuad. Amp. Dem."
        elif upub == "CUADERNO DE AMAPARO: ACTOR":
            r += " Cuad. Amp. Act."
        elif "CUADERNO DE AMAPARO" in upub:
            r += " en Cuad. Amp."
            if cuaderno:
                r+= " " + cuaderno + ","
        elif 'CONSTANCIA' in upub:
            r += " Const."
        elif 'EXPEDIENTILLO' in upub:
            r += " en Expdllo."
        elif 'CUADERNILLO' in upub:
            r += " en Cuadernillo."
        else:
            r += " en " + pub
    if not (r.endswith('.') or r.endswith(",")):
        r += "."
    if especial:
        if especial == "no publicado":
            r += " No Publ."
        elif especial == "mal publicado":
            r += " Mal Publ."
        if fecha_especial:
            try:
                f = datetime.strptime(str(fecha_especial), "%Y-%m-%d")
                fspec = str(f.day) + " de " + mon[ f.month ]
                # 28 de febrero
                r += " del " + fspec
            except:
                r += " del " + str(fecha_especial)
                pass
    return r

import configparser
config = configparser.ConfigParser({this_config:{
            'rootdir'      : '/var/www/depjud2',
            'inc_dir'      : '/var/www/php-inc',
            'scripts_dir'  : '/var/www/scripts',
            'web_path'     : 'http://depjud.poderjudicialdf.gob.mx',
            'index_dir'    : '/var/www/public_html',
            'static_dir'   : '/var/www/static',
            'temp_dir'     : '/var/www/public_html/temporales',
            'temp_dir'     : '/var/www/public_html/temporales',
            'plantillas'   :  '/var/www/php-inc/reportes/PLANTILLAS',
            'santander_ok' : 'true',
            'debug_sql'    : 'false',
            'is_production': 'true',
            'pdf_server'   : 'http://o2u:9180'}
                                    })

config.readfp(open('/etc/php/skills_depot.ini',"r", encoding='utf-8'))
q      = re.compile(r'"')
dblspc = re.compile(r'\s\s+')

from tempfile import mkdtemp

DB_host_edictos = "localhost"
#DB_port        = config.get(this_config,'db_port')
DB_host         = q.sub('',config.get(this_config,'DB_host'))
DB_user         = q.sub('',config.get(this_config,'DB_user'))
DB_passwd       = q.sub('',config.get(this_config,'DB_pass'))
DB_name         = q.sub('',config.get(this_config,'DB_name'))
temp_dir        = q.sub('',config.get(this_config,'temp_dir'))
index_dir       = q.sub('',config.get(this_config,'index_dir'))
scripts_dir     = q.sub('',config.get(this_config,'scripts_dir'))

mytdir = mkdtemp(prefix='listado_',dir=temp_dir)

import MySQLdb
dbd = MySQLdb.connect( host=DB_host,
                       db=DB_name,
                       user=DB_user,
                       passwd=DB_passwd,
                       charset="utf8",
                       connect_timeout=4 )

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
qry = '''SELECT
juzgado,
j.nombre,
IF(r_titulo IS NULL, titulo, r_titulo) titulo,
IF(r_autoridad IS NULL, autoridad, r_autoridad) responsable
FROM autoridad
JOIN juzgado j ON j.codigo = autoridad.juzgado
WHERE juzgado %s
ORDER BY j.orden
''' % (codigoeq,)

all_juzgados = deque([])
juzgado_nombres   = {}
juzgado_autoridad = {}

cursor.execute( qry )
if cursor.rowcount > 0:
    for (clv,nomjz,titulo,responsable) in cursor.fetchall():
        juzgado_nombres[ clv ]   = nomjz
        juzgado_autoridad[ clv ] = (responsable,titulo)
        all_juzgados.append( clv )
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
	CONCAT_WS('-', j.toca, j.anio_toca, LPAD(j.asunto_toca,3,'0')) AS tocat,
	a.anotacion,
    j.tipo_expediente,
    j.cuaderno,
    a.especial,
    a.fecha_especial,
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
      j.juzgado ''' + codigoeq + '''
  AND a.estatus = 30 -- ESTATUS_FIRMADO_Y_APROBADO
  AND a.activacion='%s'
-- GROUP BY j.toca, j.anio_toca, j.asunto_toca
GROUP BY z.orden, a.tipo, j.toca, j.anio_toca, j.asunto_toca, a.publicar_en, a.especial, j.tipo_expediente
ORDER BY z.orden, a.tipo, actores, tocat
''' 
cursor.execute( qry % (fecha_qry))
# print( qry )
if cursor.rowcount < 1:
    print( "Error: No hay publicaciones para: %s" % (fecha,))
    sys.exit(1)

jz_  = ""
ac_  = ""
tp_  = ""
ov   = ""
tc_  = ""
toca_= ""

with open(os.path.join(mytdir, listado),"wt", encoding='utf-8') as f:
    f.write(tags["start"])
    for tuple in cursor.fetchall():
        t2 = [ str(x) if x else "" for x in tuple ]
        (jz,tipo,tc,act,ter,juicio,materia,concepto,pub,toca,anotacion,tipo_expediente,cuaderno,especial,fecha_especial,pon,acdos,vis) = t2
        # f.write("\n"+"\t".join(("--",jz,tipo,tc,act,ter,juicio,materia,concepto,pub,toca,anotacion,tipo_expediente,cuaderno,especial,pon,acdos,vis,"\n")))
        if jz != jz_:
            # -- flush_??
            if ov: f.write(wout(ov))
            if jz_:
                f.write( tag("elsec",juzgado_autoridad[ jz_ ][1]) +  tag("sec",juzgado_autoridad[ jz_ ][0]))
            ov  = ""
            tp_ = ""
            ac_ = ""
            jz_nvo = all_juzgados.popleft()
            while all_juzgados and jz_nvo != jz:
                f.write(tag("sala",juzgado_nombres[ jz_nvo ]) + tag("body", "No hay publicaciones %s" % (fpub,)))
                jz_nvo = all_juzgados.popleft()
            f.write(tag("sala",juzgado_nombres[ jz ]))
        if tipo != tp_:
            if ov: f.write(wout(ov))
            ov  = ""
            if tipo == 'acuerdo':
                t = "Acuerdos " + fpub
                f.write( tag("titacu",t.upper()))
            elif tipo == 'sentencia':
                f.write( tag("titsen","SENTENCIAS"))
            elif tipo == 'audiencia':
                f.write( tag("titsen","AUDIENCIAS"))
        if tc == tc_ or act == ac_:
            ov  += ", " + prepara_entrada(tipo,juicio,materia,pub,toca,anotacion,tipo_expediente,cuaderno,especial,fecha_especial,pon,acdos)
        else:
            # -- flush_??
            if ov: f.write(wout(ov))
            if vis == 'secreto':
                ov = 'Secreto.'
            else:
                ov = act
                if ter:
                    ov += " Tercero: " + ter
            ov  += " " + prepara_entrada(tipo,juicio,materia,pub,toca,anotacion,tipo_expediente,cuaderno,especial,fecha_especial,pon,acdos)

        # fin
        jz_  = jz
        ac_  = act
        tp_  = tipo
        tc_  = tc
        toca_= toca
    # fin de qry
    #-- flush_??
    if ov: f.write(wout(ov))
    if jz_:
        f.write( tag("elsec",juzgado_autoridad[ jz_ ][1]) +  tag("sec",juzgado_autoridad[ jz_ ][0]))
    while all_juzgados:
        jz_nvo = all_juzgados.popleft()
        f.write(tag("sala",juzgado_nombres[ jz_nvo ]) + tag("body", "No hay publicaciones %s" % (fpub,)))
    f.write(tags["end"])

#if vp:
if len(sys.argv) > 2 and sys.argv[2] == "vp":
    # filtrado con may / min
    file_in  = os.path.join(mytdir, listado)
    file_out = file_in.replace(".txt",".html")
    tname    = file_in.replace(".txt",".out")
    import subprocess
    try:
        f = open(tname,"wt",encoding='utf-8')
        o = open(file_out,"wb")
        cmd = ["/usr/bin/python3",os.path.join(scripts_dir,"boletin_judicial/acentua_boletin_mp.py"),file_in]
        oproc = subprocess.Popen(cmd,
                                 stdout=o,
                                 stderr=subprocess.PIPE,
                                 env={'PATH': '/usr/bin:/bin',
                                      'LANG': 'en_US.UTF-8}'})
        (stdoutdata, stderrdata) = oproc.communicate()
    except Exception as e:
        f.write("Error (e):" + str(e))
        f.write("\n\nstdout:\n" + stdoutdata.decode())
        f.write("\n\nstderr:\n" + stderrdata.decode())
        print("Error html: " + tname)
        sys.exit(1)
    #toproc = str(type(oproc))
    #f.write("type:\n"     + toproc + "\n")
    # if stderrdata or (oproc and toproc=="<class 'subprocess.Popen'>") and oproc.wait() != 0:
    if oproc.wait() != 0 or stderrdata:
        sname = tname
        f.write("\n\nstdout file: " + file_out + "\n")
        f.write("\n\nstderr:\n" + stderrdata.decode())
        f.close()
        print( "Error 17 al acentuar: " + tname )
        sys.exit(1)
    else:
        f.close()
        o.close()
        os.remove(tname)
        if False:
            f = open(file_out,"wt",encoding='utf-8')
            f.write(stdoutdata.decode())
            f.close()
    del oproc
    print("OK " + file_out.replace(index_dir,""))
else:
    print("OK " + os.path.join(mytdir,listado).replace(index_dir,""))
