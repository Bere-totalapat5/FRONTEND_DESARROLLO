#!/usr/bin/python3
# -*- coding: utf-8 -*-

"""Produce la página de Autos en PDF para una fecha"""
this_config="boletin_judicial"
log_enabled=False
debugis=True

import sys, getopt, re, os, MySQLdb, uno

from unohelper import systemPathToFileUrl, absolutize
from com.sun.star.beans import PropertyValue
from com.sun.star.text.ControlCharacter import PARAGRAPH_BREAK
# from com.sun.star.style.BreakType import PAGE_BEFORE, PAGE_AFTER
# from com.sun.star.uno import Exception as UnoException, RuntimeException
# from com.sun.star.connection import NoConnectException
# from com.sun.star.lang import IllegalArgumentException
# from com.sun.star.io import IOException

from datetime     import datetime,timedelta, date
from aux_boletin  import fecha_boletin, config
from tempfile     import mkdtemp

env = os.environ
os.environ['TMP'] =  '/tmp'
os.environ['TEMP'] = '/tmp'
os.environ['HOME'] = '/tmp'
mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales72")

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

def tcursorpos(txt, search_text):
    pos = 0
    try:
        srch = txt.createSearchDescriptor()
        srch.SearchString = search_text
        srch.SearchCaseSensitive = True
        srch.SearchWords = True
        xFound = txt.findFirst( srch )
        if xFound is not None:
            pos  = xFound.getEnd()
            repl = txt.createReplaceDescriptor()
            repl.SearchString  = search_text
            repl.ReplaceString = ""
            txt.replaceAll( repl ) 
        else:
            pos = 0
    except Exception as e:
        print("tcursorpos:", str(e))
    if pos == 0:
        sys.exit(1)
    return pos

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

def imprime_autos(cursor, fech):
    # copia plantilla "plantilla_autos_20150413e.fodt" y crea instancia
    fecha_impresa   = 'Martes 9 de Septiembre de 2014'
    pfech           = '[fech]'
    pfechletra      = '[fechletra]'

    fpub,fqry,fecha,en_letras,num_boletin = fecha_boletin(fech)
    PLANTILLA="plantilla_autos_20150413e.fodt"
    # actualiza valores (num y fecha del BJ, fechas en las leyendas fijas
    # -> localiza "[fech]" en encab y "[fech]" en cierre
    change_fecha    = re.compile(fecha_impresa)

    with open(PLANTILLA,"r") as f:
        with open("/tmp/" + PLANTILLA,"w") as o:
            for l in f:
                if fecha_impresa in l:
                    l = change_fecha.sub(fpub,l)
                if pfech in l:
                    l = l.replace(pfech,fqry)
                if pfechletra in l:
                    l = l.replace(pfechletra,en_letras)
                o.write(l)
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

    cursor.execute( qry_autos % fech )
    if cursor.rowcount == 0:
        return
    tt = cursor.fetchall()
    # abre en LibreOffice
    # -> localiza "pos_autos"
    cUrl = "file:///tmp/" + PLANTILLA

    try:
        ctxLocal = uno.getComponentContext()
        smgrLocal = ctxLocal.ServiceManager
        resolver = smgrLocal.createInstanceWithContext(
            "com.sun.star.bridge.UnoUrlResolver", ctxLocal )
        ctx = resolver.resolve( "uno:socket,port=2002;urp;StarOffice.ComponentContext" )
        smgr = ctx.ServiceManager
        desktop = smgr.createInstanceWithContext("com.sun.star.frame.Desktop", ctx )
        if log_enabled:
            logger.debug("ooo Desktop OK")
    except Exception as e:
        if log_enabled:
            logger.error("Could not create a new doc: " + str(e))
        else:
            print("Could not create a new doc: " + str(e))
        sys.exit(1)

    cwd = systemPathToFileUrl( mytdir )
    outputfile = "Autos_"+ fecha +".pdf"

    destFile = absolutize( cwd, systemPathToFileUrl(outputfile) )
    inProps  = PropertyValue( "Hidden",       0, True,                0 ),
    oProps   = (
               PropertyValue("CharacterSet", 0, 'utf-8',             0 ),
               PropertyValue("Pages",        0, 'All',               0 ),
               PropertyValue("FilterName",   0, "OpenDocument Text Flat XML", 0),
    )
    #          PropertyValue("FilterName",   0, "ODF Text Document", 1 ),
    # inProps = ()
    if log_enabled:
        logger.debug("ooo Conf OK")

    #
    # Stop here, set propper headers, replace: No. and Fecha.
    #
    try:
        # newdoc = desktop.loadComponentFromURL( "private:factory/swriter", "_blank", 0, inProps )
        newdoc = desktop.loadComponentFromURL( cUrl, "_blank", 0,  inProps )
    except Exception as e:
        if log_enabled: logger.error("Could not create a new doc: " + str(e))
        sys.exit(1)

    if log_enabled:
        logger.debug("newdoc  OK")

    try:
        text   = newdoc.Text
        cursor = text.createTextCursor()
    except Exception as e:
        if log_enabled: logger.error("Text and Cursor: " + str(e))
        sys.exit(1)

    tc = tcursorpos(newdoc,"pos_autos")
    if tc: # skip to next line
        cursor.gotoRange(tc,False)

    #  inserta los textos
    tipo_auto_ant = ""
    for t in tt: # cursor.fetchall()
        (tipo_auto, prefj, expd, anio, acumulados, descripcion, acuerdos, diferidos) = t

        if tipo_auto_ant != tipo_auto:
            cursor.ParaStyleName = "Heading 3"
            text.insertString( cursor, tipo_auto + ":", 0)
            text.insertControlCharacter( cursor, PARAGRAPH_BREAK, 0 )
            tipo_auto_ant = tipo_auto
            
        cursor.ParaStyleName = "Text Body"
        cline = [ "%s %s " % (prefj,str(expd) + "/" + str(anio))]

        if acumulados:
            if descripcion or acuerdos or diferidos:
                comma = ","
            else:
                comma = ""
            cline.append("y su(s) acumulado(s) %s%s " % (acumulados.strip(),comma))
        if descripcion.strip():
            if acuerdos or diferidos:
                comma = ","
            else:
                comma = ""
            cline.append("%s%s" %(descripcion.strip(),comma))
        if acuerdos > 0:
            if diferidos:
                comma = ","
            else:
                comma = ""
            if (acuerdos > 1):
                etqta = "Acuerdos"
            else:
                etqta = "Acuerdo"
            cline.append(" %s %s%s" % (acuerdos,etqta,comma))
        if diferidos > 0:
            if (diferidos > 1):
                etqta =  "Acuerdos Diferidos"
            else:
                etqta =  "Acuerdo Diferido"
            cline.append(" %s %s" % (diferidos,etqta))

        text.insertString( cursor, "".join(cline), 0)
        text.insertControlCharacter( cursor, PARAGRAPH_BREAK, 0 )

    # fin de textos

    try:
        # newdoc.resetUserData('www-data')
        destFodt = destFile.replace('pdf','fodt')
        newdoc.storeToURL(destFodt,oProps)
        if log_enabled: logger.debug("Done building FODT: %s" % destFodt)
        # if debugis: print("   %s" % (destFodt.replace('file:///var/www/public_html',''),))
    except Exception as e:
        if debugis: print("Unexpected error:", sys.exc_info()[0])
        if log_enabled:
            logger.error("Undef error (" + str(e) + ")")
            logger.error("failed: %s" % destFile)

    try:
        if log_enabled: logger.info("store: %s" % destFile)
        newdoc.storeToURL(destFile,(PropertyValue("FilterName",0, "writer_pdf_Export", 1),))
        if log_enabled: logger.info("Done building PDF: %s" % destFile)
        # print("OK %s" % (destFile.replace('file:///var/www/public_html',''),))
    except Exception as e:
        if debugis: print("Unexpected error:", sys.exc_info()[0])
        if log_enabled:
            logger.error("Undef error (" + str(e) + ")")
            logger.error("failed: %s" % destFile)

    return("OK %s" % (destFile.replace('file:///var/www/public_html',''),))

# __main__
                    
op = Options(sys.argv[1:])
if op.fecha:
    if op.verbose: print('autos: preparando la página para el Boletín Judicial del', op.fecha)
    pass
else:
    print('autos: se requiere una fecha, en formato YYYY-MM-DD')
    sys.exit(255)

q = re.compile(r'"')

DB_host_edictos = "localhost"
DB_host         = q.sub('',config.get(this_config,'DB_host'))
DB_user         = q.sub('',config.get(this_config,'DB_user'))
DB_passwd       = q.sub('',config.get(this_config,'DB_pass'))
DB_name         = q.sub('',config.get(this_config,'DB_name'))

try:
    dbd = MySQLdb.connect( host=DB_host_edictos,
                            db=DB_name,
                            user=DB_user,
                            passwd=DB_passwd,
                            charset="utf8",
                            connect_timeout=4 )
    cursor = dbd.cursor()
    cursor.execute("SET collation_connection  = utf8_spanish_ci")
except Exception as e:
    print(str(e))
    print("Check DB parameters")
    sys.exit(1)

print(imprime_autos(cursor,op.fecha))
"""
a='\u2013'
print(a)
"""
