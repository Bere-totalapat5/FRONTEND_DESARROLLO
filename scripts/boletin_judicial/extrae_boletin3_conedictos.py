#!/usr/bin/python3
# -*- coding: utf-8 -*-
this_config="boletin_judicial"

import sys, getopt, locale
from bs4 import BeautifulSoup
try:
    locale.setlocale( locale.LC_ALL, 'es_MX.UTF-8' )
except:
    locale.setlocale( locale.LC_ALL, 'en_US.utf8' )

class Options:
    def __init__(self, args):
        self.fecha = None
        self.debug = False
        self.doquery = False
        self.verbose = 0

        ### Get options from the commandline
        try:
            opts, args = getopt.getopt(args, 'edvhf:',
                                       ['execute-query', 'debug', 'verbose','help', 'fecha='] )
        except getopt.error as exc:
            print('extrae_boletin3: %s no se comprende.' % str(exc))
            sys.exit(255)

        for opt, arg in opts:
            if opt in ['-h', '--help']:
                # self.usage()
                print('-f|--fecha YYYY-MM-DD -d|--debug -v|--verbose')
                # self.help()
                sys.exit(1)
            elif opt in ['-v', '--verbose']:
                self.verbose += 1
            elif opt in ['-d','--debug']:
                self.debug = True
            elif opt in ['-e','--execute-query']:
                self.doquery = True
            elif opt in ['-f', '--fecha']:
                self.fecha = arg

op = Options(sys.argv[1:])
if op.fecha:
    if op.verbose: print('extrae_boletin3: preparando el Boletín Judicial del', op.fecha)
    pass
else:
    print('extrae_boletin3: se requiere una fecha, en formato YYYY-MM-DD')
    sys.exit(255)

import re
import os
import types
from datetime import datetime,timedelta, date
# from time import strftime, strptime, localtime, time


#from MySQL_python 
import MySQLdb
import configparser
env = os.environ

config = configparser.ConfigParser({this_config:{
            'rootdir': '/var/www/depjud2',
            'inc_dir': '/var/www/php-inc',
            'scripts_dir': '/var/www/scripts',
            'web_path': 'http://depjud.poderjudicialdf.gob.mx',
            'index_dir': '/var/www/public_html',
            'static_dir': '/var/www/static',
            'temp_dir': '/var/www/public_html/temporales',
            'wdir': '/var/www/public_html/temporales',
            'plantillas':  '/var/www/php-inc/reportes/PLANTILLAS',
            'santander_ok': 'true',
            'debug_sql': 'false',
            'is_production': 'true',
            'pdf_server': 'http://o2u:9180'}
                                    })

config.readfp(open('/etc/php/skills_depot.ini'))
q      = re.compile(r'"')
dblspc = re.compile(r'\s\s+')

DB_host_edictos = "localhost"
#DB_port        = config.get(this_config,'db_port')
DB_host         = q.sub('',config.get(this_config,'DB_host'))
DB_user         = q.sub('',config.get(this_config,'DB_user'))
DB_passwd       = q.sub('',config.get(this_config,'DB_pass'))
DB_name         = q.sub('',config.get(this_config,'DB_name'))

# def do_exit(exit_mode=0):
#     db.commit()
#     elapsed = (time() - start_time) or 1e-6
#     efic = (tfiles + tdirs)/elapsed
#     print "\n\nElapsed: %.4f secs. %d files. %d dirs." % (elapsed, tfiles, tdirs)
#     print "    %.4f rows/sec." % (efic,)
#     print "    %.4f dirs/sec.\n" % (tdirs/elapsed,)                             
#     db.close()
#     sys.exit(exit_mode)

try:
    dbd = MySQLdb.connect( host=DB_host,
                           db=DB_name,
                           user=DB_user,
                           passwd=DB_passwd,
                           charset="utf8",
                           connect_timeout=4 )
    # # [boletin_judicial]
    # db_host="localhost"
    # db_user="root"
    # db_passwd="UGE0MTV3MHJkLgo"
    # db_name="sibjdf"

    # dbd = MySQLdb.connect(host=db_host,db=db_name,
    #                   user=db_user,passwd=db_passwd)
    cursor      = dbd.cursor()
    cursor.execute("SET collation_connection  = utf8_spanish_ci")
except Exception as e:
    print(str(e))
    print("Check DB parameters")
    sys.exit(1)

dow         = ('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')
mon         = ('',"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
               "Agosto","Septiembre","Octubre","Noviembre","Diciembre")
num_boletin = 0
f           = datetime.strptime(op.fecha, "%Y-%m-%d")
hoy         = date( f.year, f.month, f.day)
fqry        = hoy
try:
    inicio = date(2015,1,1)
    cursor.execute("""SELECT fecha FROM feriados WHERE fecha >= DATE('%s')""" % (inicio,))
    if cursor.rowcount > 0:
        feriados = set( tuple[0] for tuple in cursor.fetchall() )

    if hoy in feriados or hoy.weekday() >4:
        print("No hay publicación el ",str(hoy))
        sys.exit(0)
    f = inicio
    while f <= hoy:
        if f.weekday() < 5 and not f in feriados:
            num_boletin += 1
            if f < hoy:
                fqry = f
        f += timedelta(days=1)
    del feriados
    f = hoy
    op.fecha = f.strftime("%Y-%m-%d")
    fpub = dow[ f.weekday() ] + " " + str(f.day) + " de " + mon[ f.month ] + " del " + str(f.year) 
    fqry = str(fqry.day) + " de " + mon[ fqry.month ] + " del " + str(fqry.year) 
except Exception as e:
    print("Error en fecha (" + op.fecha + ") " + str(e))
    sys.exit(1)


re_invalid= re.compile(r'\[\]\|\<\>')
#tipo,especial,plural
# "encabezado,estilo,del"
# estilo "5" (con negritas),"5NB" (sin negritas)
encabezados = {
  "acuerdo::":"Acuerdo,5,DEL",
  "acuerdo::s":"Acuerdos,5,DEL",
  "acuerdo:no publicado:":"Acuerdo No Publicado,5NB,",
  "acuerdo:no publicado:s":"Acuerdos No Publicados,5NB,",
  "acuerdo:mal publicado:":"Acuerdo Mal Publicado,5NB,",
  "acuerdo:mal publicado:s":"Acuerdos Mal Publicados,5NB,",
  "sentencia::":"Sentencia,5,DEL",
  "sentencia::s":"Sentencias,5,DEL",
  "sentencia:no publicado:":"Sentencia No Publicada,5,",
  "sentencia:no publicado:s":"Sentencias No Publicadas,5,",
  "sentencia:mal publicado:":"Sentencia Mal Publicada,5,",
  "sentencia:mal publicado:s":"Sentencias Mal Publicadas,5,",
  "sentencia definitiva::":"Sentencia Definitiva,5,DEL",
  "sentencia definitiva::s":"Sentencias Definitivas,5,DEL",
  "sentencia definitiva:no publicado:":"Sentencia Definitiva No Publicada,5,",
  "sentencia definitiva:no publicado:s":"Sentencias Definitivas No Publicadas,5,",
  "sentencia definitiva:mal publicado:":"Sentencia Definitiva Mal Publicado,5,",
  "sentencia definitiva:mal publicado:s":"Sentencias Definitivas Mal Publicadas,5,",
  "sentencia interlocutoria::":"Sentencia Interlocutoria ,5,DEL",
  "sentencia interlocutoria::s":"Sentencias Interlocutorias,5,DEL",
  "sentencia interlocutoria:no publicado:":"Sentencia Interlocutoria No Publicada,5,",
  "sentencia interlocutoria:no publicado:s":"Sentencias Interlocutorias No Publicadas,5,",
  "sentencia interlocutoria:mal publicado:":"Sentencia Interlocutoria Mal Publicada,5,",
  "sentencia interlocutoria:mal publicado:s":"Sentencias Interlocutorias Mal Publicadas,5,",
  "audiencia::":"Audiencia,5NB,DEL",
  "audiencia::s":"Audiencias,5NB,DEL",
  "audiencia:no publicado:":"Audiencia No Publicada,5NB,",
  "audiencia:no publicado:s":"Audiencias No Publicadas,5NB,",
  "audiencia:mal publicado:":"Audiencia Mal Publicada,5NB,",
  "audiencia:mal publicado:s":"Audiencias Mal Publicadas,5MB,",
}

sth_juzgados = """SELECT codigo, nombre
 FROM juzgado
WHERE tipo='juzgado'
  AND activo='V'
  AND subtipo='%(subtipo)s'
ORDER BY orden
"""

sth_cuentasj = """SELECT count(*) AS cuenta
FROM boletinhoy
WHERE subtipo    = '%(subtipo)s'
  AND juzgado    = '%(juzgado)s'
"""

sth_cuentas = """SELECT
count(*) AS cuenta
FROM boletinhoy
WHERE subtipo    = '%(subtipo)s'
  AND juzgado    = '%(juzgado)s'
  AND secretaria = '%(secretaria)s'
  AND tipo       = '%(tipo)s'
  %(especial)s
"""

sth_cuentass = """SELECT
count(*) AS cuenta
FROM boletinhoy
WHERE subtipo    = '%(subtipo)s'
  AND juzgado    = '%(juzgado)s'
  AND secretaria = '%(secretaria)s'
"""

sth_jboletin = """SELECT
actor,
demandado,
terceria, 
tipo_juicio,
nombre_expediente,
concepto,
visibilidad, 
publicar_en,
tipo_expediente
FROM boletinhoy
WHERE subtipo    = '%(subtipo)s'
  AND juzgado    = '%(juzgado)s'
  AND secretaria = '%(secretaria)s'
  AND tipo       = '%(tipo)s'
  %(especial)s
ORDER BY actor,demandado,terceria
"""

sth_autoridad = """SELECT juzgado, secretaria, autoridad, titulo
  FROM autoridad""" 

def extract_and_print(cursor,subtipo,juzgado,secretaria,tipo,especial):
    jlines = []
    cursor.execute( sth_jboletin % {
        "subtipo":subtipo,
        "juzgado":juzgado,
        "secretaria":secretaria,
        "tipo":tipo,
        "especial":especial})
    if cursor.rowcount > 0:
        for tuple in cursor.fetchall():
            (actor,demandado,terceria,tipo_juicio, 
             n_e,concepto,visibilidad, 
             publicar_en,tipo_expediente) = tuple
            nombre_expediente = n_e.split('|')[1] if '|' in n_e else n_e
            exp = "" if tipo_expediente in ("","expediente") else "(" + tipo_expediente + ")."
            datos_exped = []
            if visibilidad == "secreto" or  actor.upper()[:7] == "SECRETO":
                datos_exped.extend([ de for de in ("Secreto.",
                                                   tipo_juicio, concepto,publicar_en,
                                                   "Núm. Exp.",nombre_expediente,exp) if de ])
            else:
                actor     = actor     if len(actor) > 3     else "X."
                demandado = demandado if len(demandado) > 3 else ""
                vs = "vs."      if demandado else ""
                t = "Tercería:" if terceria  else ""
                # for de in ( actor, vs, demandado, t, terceria,
                #       tipo_juicio,nuevo_juicio,concepto,publicar_en,
                #       "Núm. Exp.", nombre_expediente, exp):
                #     if de: datos_exped.append(de)
                datos_exped.extend([ de for de in (actor, vs, demandado,
                      t, terceria, tipo_juicio, concepto,
                      publicar_en, "Núm. Exp.", nombre_expediente, exp) if de ])
            l = "{0}".format(" ".join(datos_exped))
            # Todas las líneas deben terminar con un punto
            l = l.strip()
            if not l.endswith("."):
                l += "."
            jlines.append( re_invalid.sub("",l) )
        
        print ( " </p>\n".join( sorted(jlines, key=str.lower) ) + " </p>" )

todos_los_juzgados = (
    ("PIC","Juzgados de lo Civil"), #84
    ("PIF","Juzgados de lo Familiar"), #43
    ("PC", "Juzgados de lo Civil de Cuantía Menor"), #29
    ("JCO","Juzgados de lo Civil de Proceso Oral"), #21
    ("JFO","Juzgados de Proceso Oral en Materia Familiar"), #21
    )



autoridad_todas = {}
cursor.execute(sth_autoridad)
if cursor.rowcount > 0:
  for tuple in cursor.fetchall():
    autoridad_todas[ str(tuple[0]) + ":" + str(tuple[1]) ] = tuple[2:]

if op.doquery:
    if op.verbose > 3: print ("Iniciando PROCEDURE")
    try:
        m = cursor.callproc('cBoletin3',(op.fecha,0))
        # print("<!-- callproc:",m,"--/>")
        dbd.commit()
    except Exception as e:
        print("Can't call:",str(e))
        sys.exit(1)
    if op.verbose > 3: print ("Fin de PROCEDURE")

print("<html><head><title> "+fpub+"</title></head><body>")

# solo_edictos = True
# if solo_edictos:
#     todos_los_juzgados = ()

for (subtipo, tit_seccion) in todos_los_juzgados:
    cursor.execute( sth_juzgados % {"subtipo":subtipo})
    all_juzgados = []
    juzgado_nombres = {}
    printed_fecha = False
    if cursor.rowcount > 0:
        print ("\n<H2 class='Orden'>{d} </H2>".format(d=tit_seccion))
        for tuple in cursor.fetchall():
            juzgado_nombres[ tuple[0] ] = tuple[1]
            all_juzgados.append( tuple[0] )
        if 0: print (all_juzgados)
    else:
        continue

    for juzgado in all_juzgados:
        cursor.execute( sth_cuentasj % {"subtipo":subtipo,"juzgado":juzgado})
        (cuenta,) = cursor.fetchone()
        # print ("cuentasj:{:d}".format(cuenta))
        if cuenta < 1: continue
        # obtener título del juzgado
        if juzgado in juzgado_nombres:
          nombre = juzgado_nombres[ juzgado ]
        else:
          nombre =  juzgado + ' nombre no determinado'
        print ("\n<H3 class='juzgado'>{d} </H3>".format(d=nombre))
        for secretaria in ('A','B','C'):
          cursor.execute( sth_cuentass % {"subtipo":subtipo,
                                          "juzgado":juzgado,
                                          "secretaria":secretaria})
          (cuenta,) = cursor.fetchone()
          # print ("cuentass:{:d}".format(cuenta))
          if cuenta < 1: continue
          # print ("\n<p class='Inicio_secretaria'></p>")
          print ("\n<H4 class='secretaria'> Secretaría \"{d}\" </H4>".format(d=secretaria))
          printed_fecha = False
          for tipo in ('acuerdo','audiencia','sentencia','sentencia interlocutoria','sentencia definitiva'):
            # else:
            #     print ('<p class="Error" msg="Resultado inesperado" />')
            #     continue
            for especial in ('','no publicado','mal publicado',):
              if tipo in ('sentencia definitiva',) and especial == '':
                # continue
                pass
              
              especialqry = "AND especial='" + especial + "'"

              cursor.execute( sth_cuentas % {
                  "subtipo":subtipo,
                  "juzgado":juzgado,
                  "secretaria":secretaria,
                  "tipo":tipo,
                  "especial":especialqry
                  })
              (cuenta,) = cursor.fetchone()
              if cuenta < 1:
                continue
              elif cuenta > 1: 
                plural = 's'
              else:
                plural = ''
              encab = encabezados[ ":".join((tipo,especial,plural))]
              (encab,styl,con_fecha) = encab.split(",",3)
              if printed_fecha:
                  if con_fecha:
                      print ("\n<h{s} class='tipo'>{e} del {f}</h{s}>".format(s=styl,e=encab,f=fqry))
                  else:
                      print ("\n<h{s} class='tipo'>{e}</h{s}>".format(s=styl,e=encab))
              else:
                  print ("\n<H4 class='secretaria'>{e} del {f}</H4>".format(e=encab,f=fqry))
                  printed_fecha = True
              extract_and_print(cursor,subtipo,juzgado,secretaria,tipo,especialqry)
          # obtener datos de la secretaría
          cod_sria = juzgado + ":" + secretaria
          if cod_sria in autoridad_todas:
            (nombre,cargo) = autoridad_todas[ cod_sria ]
          else:
            (nombre,cargo) = ('','')
          pals = cargo.split()
          # art = "La" if pals[0].lower().endswith('a') else "El"
          art = "" # ??
          print ("\n<h6 class='Firma'>{0} {1}</br>\n{2} </h6>".format(art, cargo, nombre))
          # print ("\n<p class='Fin_secretaria'></p>")

del cursor
dbd.close()
try:
    dbd = MySQLdb.connect( host=DB_host_edictos,
                            db=DB_name,
                            user=DB_user,
                            passwd=DB_passwd,
                            charset="utf8",
                            connect_timeout=4 )
    # # [boletin_judicial]
    # db_host="localhost"
    # db_user="root"
    # db_passwd="UGE0MTV3MHJkLgo"
    # db_name="sibjdf"

    # dbd = MySQLdb.connect(host=db_host,db=db_name,
    #                   user=db_user,passwd=db_passwd)
    cursor      = dbd.cursor()
    cursor.execute("SET collation_connection  = utf8_spanish_ci")
except Exception as e:
    print(str(e))
    print("Check DB parameters")
    sys.exit(1)

query_edictos = """
SELECT 
jz.nombre juzgado,
IF( ISNULL(e.id_acuerdo),'expediente', j.tipo_expediente) tipo_expediente,
IF( ISNULL(e.id_acuerdo), ie.expediente,j.expediente) expediente,
IF( ISNULL(e.id_acuerdo), ie.anio, j.anio) anio,
IF( ISNULL(e.id_acuerdo),'',j.bis) bis,
e.num_edicto,
e.ruta,
a.activacion,
IF( ISNULL(e.id_acuerdo), ie.secretaria,j.secretaria) secretaria,
e.resp_nombre,
COALESCE(( SELECT GROUP_CONCAT(
        DISTINCT DAYOFMONTH(fecha)
        ORDER BY fecha ASC
        SEPARATOR '-'
  ) AS grupo
   FROM edicto_publicacion ep
  WHERE ep.id_edicto = e.id_edicto
),'') AS numeritos,
e.folio,
e.costo
FROM edicto e
LEFT JOIN edicto_publicacion ep ON ep.id_edicto=e.id_edicto
LEFT JOIN acuerdo a             ON e.id_acuerdo=a.id_acuerdo
LEFT JOIN informacion_edicto ie ON ie.id_edicto=e.id_edicto
LEFT JOIN juicio j              ON a.id_juicio=j.id_juicio
LEFT JOIN juzgado jz            ON (!ISNULL(a.id_acuerdo) AND j.juzgado=jz.codigo) OR (ISNULL(a.id_acuerdo) AND ie.juzgado=jz.codigo)
LEFT JOIN autoridad at          ON at.juzgado=j.juzgado AND at.secretaria=j.secretaria
WHERE ep.fecha  = '%s'
  AND e.estatus = 'en publicacion'
ORDER BY jz.orden, j.secretaria, j.anio, j.expediente"""

print("\n\n\n<!-- ZDRkZjU5ZTE0OTEKN -->\n\n\n")
print("<EDICTOS>")

cursor.execute( query_edictos % op.fecha )
if cursor.rowcount > 0:
    for t in cursor.fetchall():
        (juzgado, tipo_expediente, expediente, anio, bis, num_edicto,
        ruta, fech, secretaria, nombre, numeritos, folio, costo) = t
        if not tipo_expediente:
            tipo_expediente = ""
        if not expediente:
            expediente = ""
        if not anio:
            anio = ""
        if not bis:
            bis = ""
        exp    =  ":".join((tipo_expediente, str(expediente), str(anio), str(bis)))
        #fecha = fech.strfmt("México, D.F. a %d de %m deL %Y.").replace(" 0"." ")
        if fech:
            fecha  = "Ciudad de México a "
            fecha += str(fech.day) + " de " + mon[ fech.month ] + " del " + str(fech.year) 
        else:
            fecha = ""
        firma  = 'EL SECRETARIO DE ACUERDOS "%s"</BR>\n' % secretaria if secretaria else ""
        costo  = locale.currency( costo )
        texto  = ""
        try:
            f = open(os.path.join("/files/edictos",ruta),"rt")
            soup = BeautifulSoup(f)
            t = soup.get_text().split("\n")
            # ??? ojo con los saltos de linea
            texto = [ x.strip() for x in t if x.strip() ]
        except:
            texto = ["Texto del Edicto",]

        print("<ect_ed_jzg>\n%s</BR>\n%s</BR>\nEDICTO No. %s\n<ect_ed_txt>" % (juzgado,exp,num_edicto))
        texto = dblspc.sub(" "," ".join( texto ))
        print(texto)
        print("<ect_ed_fin>\n%s</BR>\n%s%s</BR>\n%s %s %s\n" % (fecha,firma,nombre,numeritos,folio,costo))


# Avisos


# Autos

#query_autos = """SELECT
#
#prefijo, ws_concat('/',expediente,anio, descripcion
#        """

print("</body></html>")

