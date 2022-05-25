#!/usr/bin/python3
# -*- coding: utf-8 -*-

"""Produce la página de Autos en PDF para una fecha"""
this_config="boletin_judicial"

import sys, getopt, re, os, configparser,  MySQLdb
from datetime import datetime,timedelta, date

env = os.environ

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
        except getopt.error as e:
            print('autos: %s no se comprende.' % str(e))
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
            elif opt in ['-f', '--fecha']:
                self.fecha = arg

# Autos
# ===================
# TABLE "auto"
# id_auto	    bigint(20) 	Iderntificador único del registro. Microsegundos del momento de creación
# tipo_auto	    enum('ACUERDOS','ADMISORIOS','AUDIENCIAS','DESECHATORIOS','PREVENCIONES','RESOLUCIONES DE PRIMERA INSTANCIA','RESOLUCIONES DE RECURSO DE INCONFORMIDAD')	Tipo de auto
# prefijo	    enum('A.D.','AVE','AVJ','DPO','Q') Prefijo del expediente
# expediente	int(11)	Número de expedeinte
# anio	        int(11)	Año del expediente
# acumulados	char(255) Lista de expedientes acumulados. En formato: "prefijo expediente/año"
# descripcion	char(255) Detalles sobre el auto
# acuerdos	    int(11) [0]	Número de acuerdos
# diferidos	    int(11) [0]	Número de acuerdos diferidos
# id_auto_publicacion	date Identificador de la publicación que contiene el auto
# ===================
fqry   = ""
cursor = ""
def imprime_autos(fech):
    # copia plantilla y crea instancia
    # actualiza valores (num y fecha del BJ, fechas en las leyendas fijas
    # abre en LibreOffice e inserta los textos

    qry_autos = """SELECT
tipo_auto,
prefijo,
expediente,
anio,
acumulados,
descripcion,
acuerdos,
diferidos
FROM auto
WHERE id_auto_publicacion = '%s'
ORDER BY tipo_auto, anio DESC, expediente"""

    encab = """<h2>
            CONSEJO DE LA JUDICATURA DEL DISTRITO FEDERAL<br>
            AUTOS DICTADOS POR LA COMISIÓN DE DISCIPLINA JUDICIAL, ANTE LA FE DE LA<br>
            SECRETARÍA TÉCNICA DE LA COMISIÓN DE DISCIPLINA JUDICIAL DEL CONSEJO DE<br>
            LA JUDICATURA DEL DISTRITO FEDERAL<br>%s"""
    print(encab % fqry)
    cursor.execute( qry_autos % fech)

    if cursor.rowcount == 0:
        return

    tipo_auto_ant = ""
    for t in cursor.fetchall():
        (tipo_auto, prefj, expd, anio, acumulados, descripcion, acuerdos, diferidos) = t

        if tipo_auto_ant != tipo_auto:
            print("<h3 class='auto_titulo'>%s:" % tipo_auto)
            tipo_auto_ant = tipo_auto

        print("<auto>%s\t%s/%s\t" % (prefj,expd,anio))
        # última col
        if acumulados:
            if descripcion or acuerdos or diferidos:
                comma = ","
            else:
                comma = ""
            print("y su(s) acumulado(s) %s%s" % (acumulados.strip(),comma))
        if descripcion.strip():
            if acuerdos or diferidos:
                comma = ","
            else:
                comma = ""
            print("%s%s" %(descripcion.strip(),comma))
        if acuerdos > 0:
            if diferidos:
                comma = ","
            else:
                comma = ""
            if (acuerdos > 1):
                etqta = "Acuerdos"
            else:
                etqta = "Acuerdo"
            print("%s %s%s" % (acuerdos,etqta,comma))
        if diferidos > 0:
            if (diferidos > 1):
                etqta =  "Acuerdos Diferidos"
            else:
                etqta =  "Acuerdo Diferido"
            print(diferidos,etqta)

    # imprime el pié de pág y firma
    firma = """LA SECRETARIA TÉCNICA DE LA COMISIÓN DE DISCIPLINA JUDICIAL.&ndash;LIC. DIANA LÓPEZ HIPÓLITO.&ndash;FIRMA."""
    print("<firmaautos>México, D.F. a %s.&ndash;%s" % (fqry,firma))


# __main__
                    
op = Options(sys.argv[1:])
if op.fecha:
    if op.verbose: print('autos: preparando la página para el Boletín Judicial del', op.fecha)
    pass
else:
    print('autos: se requiere una fecha, en formato YYYY-MM-DD')
    sys.exit(255)

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
q = re.compile(r'"')

DB_host_edictos = "localhost"
#DB_port        = config.get(this_config,'db_port')
DB_host         = q.sub('',config.get(this_config,'DB_host'))
DB_user         = q.sub('',config.get(this_config,'DB_user'))
DB_passwd       = q.sub('',config.get(this_config,'DB_pass'))
DB_name         = q.sub('',config.get(this_config,'DB_name'))

try:
    dbd = MySQLdb.connect( host=DB_host,
                           db=DB_name,
                           user=DB_user,
                           passwd=DB_passwd,
                           charset="utf8",
                           connect_timeout=4 )
except Exception as e:
    print(str(e))
    print("Check DB parameters")
    sys.exit(1)

cursor      = dbd.cursor()
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
print("<html><head><title> "+fpub+"</title></head><body>")

try:
    dbd = MySQLdb.connect( host=DB_host_edictos,
                            db=DB_name,
                            user=DB_user,
                            passwd=DB_passwd,
                            charset="utf8",
                            connect_timeout=4 )
except Exception as e:
    print(str(e))
    print("Check DB parameters")
    sys.exit(1)
cursor      = dbd.cursor()

imprime_autos(op.fecha)
print("</body></html>")


