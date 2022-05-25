#!/usr/bin/env python3
# -*- coding: utf-8 -*-
BOLETIN_HOY="extrae_boletin_pub.html"
PLANTILLA="plantilla_boletin_20150413d.fodt"
# check for page num.: http://openoffice.2283327.n4.nabble.com/python-uno-the-page-number-is-blank-on-the-first-page-td3179194.html

delete_tmp_files = False # True # 
resize_val = 1.0 # muy grande: 120.0/72.0
debugis = False
log_enabled = True

import logging
import getopt, sys
import uno
import os, re, base64
from tempfile import mkdtemp

if log_enabled: #debug(), info(), warning(), error() and critical()
    logger = logging.getLogger("oooDocs")
    hdlr = logging.FileHandler("/tmp/docs.log")
    formatter = logging.Formatter("%(asctime)s [%(name)s] %(levelname)s - %(message)s")
    hdlr.setFormatter(formatter)
    logger.addHandler(hdlr)
    if debugis:
        logger.setLevel(logging.DEBUG)
    else:
        logger.setLevel(logging.INFO)
    logger.info("Session Init")

os.environ['TMP'] =  '/tmp'
os.environ['TEMP'] = '/tmp'
os.environ['HOME'] = '/tmp'
#os.environ['USER'] = 'apache'
#os.environ['USERNAME'] = 'apache'
#os.environ['LOGNAME'] = 'apache'

mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales72")

from os.path import isfile, join
#from os import getcwd
from unohelper import systemPathToFileUrl, absolutize
from com.sun.star.beans import PropertyValue
# from com.sun.star.style.BreakType import PAGE_BEFORE, PAGE_AFTER
from com.sun.star.uno import Exception as UnoException, RuntimeException
from com.sun.star.connection import NoConnectException
from com.sun.star.lang import IllegalArgumentException
from com.sun.star.io import IOException
from com.sun.star.text.ControlCharacter import PARAGRAPH_BREAK
from com.sun.star.text.ControlCharacter import LINE_BREAK

re_instancia = re.compile("Instancia: (.*)$")
re_head = re.compile(r"</head><body><pre>")
sel = re.compile(r'</body></html>')

def usage():
    sys.stderr.write("usar: python3 coser_boletin.py "+
                      "       [-c  | --connection-string=]\n"+
		      "       [-o  | --outfile=] \n"+
                      "       file1 file2 ...\n")

def process_fields(text):
    return text

def tcursopos(txt, search_text):
    #text   = newdoc.Text
    #cursor = text.createTextCursor()

    pos = 0
    try:
        srch = txt.createSearchDescriptor()
    except Exception as e:
        print("q1", str(e))
    try:
        srch.SearchString = search_text
    except Exception as e:
        print("q2", str(e))
    try:
        srch.SearchCaseSensitive = True
    except Exception as e:
        print("q3", str(e))
    try:
        srch.SearchWords = True
    except Exception as e:
        print("q4", str(e))
    try:
        xFound = txt.findFirst( srch )
    except Exception as e:
        print("q5", str(e))
    try:
        if xFound is not None:
            pos =  xFound.getEnd()
        else:
            pos = 0
    except Exception as e:
        print("q6", str(e))
    try:
        repl = txt.createReplaceDescriptor()
    except Exception as e:
        print("q7", str(e))
    try:
        repl.SearchString = search_text
    except Exception as e:
        print("q8", str(e))
    try:
        repl.ReplaceString = ""
    except Exception as e:
        print("q9", str(e))
    try:
        txt.replaceAll( repl ) 
    except Exception as e:
        print("q10", str(e))
    if pos == 0:
        sys.exit(1)
    return pos

change_fecha = re.compile('Martes 9 de Septiembre de 2014')
def main():

    opts, args = getopt.getopt(sys.argv[1:], "hco:", ["help", "connection-string=", "outfile" ])
    url = "uno:socket,port=2002;urp;StarOffice.ComponentContext"

    for o, a in opts:
        if o in ("-h", "--help"):
            usage()
            sys.exit()
        if o in ("-c", "--connection-string" ):
            url = "uno:" + a + ";urp;StarOffice.ComponentContext"
        if o in ("-o", "--outfile"):
            outputfile = a

        if not len( args ):
            usage()
            sys.exit()

    if log_enabled:
        logger.info("Got params %s", ','.join(sys.argv[1:]))

    hoy = ""
    for inputfile in args:
        if isfile(inputfile):
            fi = open(inputfile,"rt")
            l = fi.readline()
            m = re.search("<HTML><HEAD><TITLE>([^<]*)</TITLE></HEAD><BODY>",l)
            if m:
                hoy = m.group(1).strip()
    # print("hoy:",hoy)
    # sys.exit(1)
    with open(PLANTILLA,"r") as f:
        with open("/tmp/" + PLANTILLA,"w") as o:
            for line in f:
                l = change_fecha.sub(hoy,line)
                o.write(l)

    cUrl = "file:///tmp/" + PLANTILLA
    h = hoy.split(" ") # "Martes_7_de_Abril_del_2015"
    if len(h) == 5:
        hoy = h[5] + "_" + h[3] + "_" + h[1]
    outputfile = "TSJDF_BoletinJudicial_"+ hoy.replace(" ","_") +".pdf"
    #print("outputfile:",outputfile)
    #sys.exit(1)
    retVal = 0

    try:
        ctxLocal = uno.getComponentContext()
        smgrLocal = ctxLocal.ServiceManager
        resolver = smgrLocal.createInstanceWithContext(
            "com.sun.star.bridge.UnoUrlResolver", ctxLocal )
        ctx = resolver.resolve( url )
        smgr = ctx.ServiceManager
        desktop = smgr.createInstanceWithContext("com.sun.star.frame.Desktop", ctx )
        if log_enabled:
            logger.debug("ooo Desktop OK")


    except NoConnectException as e:
        if log_enabled: logger.error("OpenOffice process not found or not listening: (" + str(e) + ")")
        sys.exit(1)
    except IllegalArgumentException as e:
        if log_enabled: logger.error("The url is invalid: (" + str(e) + ")")
        sys.exit(1)
    except RuntimeException as e:
        if log_enabled: logger.error("An unknown error occured: " + str(e))
        sys.exit(1)
    except Exception as e:
        if log_enabled: logger.error("Could not create a new doc: " + str(e))
        sys.exit(1)

    cwd = systemPathToFileUrl( mytdir )
    destFile = absolutize( cwd, systemPathToFileUrl(outputfile) )
    inProps = PropertyValue( "Hidden",       0, True,                0 ),
    oProps  = (
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

    img_counter = 1;
    img_list = []
    striptags = re.compile(r'\<[^>]*\>')
    nline = 0
    for inputfile in args:
        if isfile(inputfile):
            fi = open(inputfile,"rt")

            if debugis: print("Appending %s" % inputfile)
            if log_enabled:
                logger.debug("Appending %s" % inputfile)
            try:
                br = False
                nextbr = False
                cursor.gotoEnd(False)
                for f in fi.readlines():
                    nline += 1
                    if debugis and ((nline % 1000) == 0):
                        print(nline, end=" ",flush=True)
                    # if (nline % 10000) == 0:
                    #     break
                    f = f.strip()
                    if not f:
                        continue
                    nextbr = True if f.endswith("</BR>") else False
                    cline  = striptags.sub("",f)
                    # print(cline)
                    if f.startswith("<"):
                        if f.startswith("<H2 CLASS='ORDEN'>"):
                            tc = 0
                            if f.find("<H2 CLASS='ORDEN'>JUZGADOS de lo Civil </H2>") != -1:
                                tc = tcursopos(newdoc,"PIC___Juzgados de lo Civil")
                            elif f.find("<H2 CLASS='ORDEN'>JUZGADOS de lo Familiar </H2>") != -1:
                                tc = tcursopos(newdoc,"PIF___Juzgados de lo Familiar")
                            elif f.find("<H2 CLASS='ORDEN'>JUZGADOS de lo Civil de Cuantía Menor </H2>") != -1:
                                tc = tcursopos(newdoc,"PC___Juzgados de lo Civil de Cuantia Menor")
                            elif f.find("<H2 CLASS='ORDEN'>JUZGADOS de lo Civil de Proceso Oral </H2>") != -1:
                                tc = tcursopos(newdoc,"JCO___Juzgados de lo Civil de Proceso Oral")
                            elif f.find("<H2 CLASS='ORDEN'>JUZGADOS de Proceso Oral en Materia Familiar </H2>") != -1:
                                tc = tcursopos(newdoc,"JFO___Juzgados de Proceso Oral en Materia Familiar")
                            else:
                                print("algo no funciona")
                                sys.exit(1)
                            if tc: # skip to next line
                                cursor.gotoRange(tc,False)
                                continue
                            else:
                                print("tc not found")
                        if f.startswith("<H2 CLASS='ORDEN'>"):
                                cursor.ParaStyleName = "Heading 2"
                        elif f.startswith("<H3 CLASS='JUZGADO'>"):
                            cursor.ParaStyleName = "Heading 3"
                        elif f.startswith("<H4 CLASS='SECRETARIA'>"):
                            cursor.ParaStyleName = "Heading 4"
                        elif f.startswith("<H5 CLASS='TIPO'>"):
                            cursor.ParaStyleName = "Heading 5"
                        elif f.startswith("<H5NB"):
                            cursor.ParaStyleName = "Heading 5NB"
                        elif f.startswith("<H6 CLASS='FIRMA'>"):
                            cursor.ParaStyleName = "Heading 6"
                        else:
                            # desecha </.. <HTML </BODY
                            continue
                    else:
                        if br: # continúa del tag anterior
                            br = False
                        else: # Texto Normal
                            cursor.ParaStyleName = "Text Body"

                    # http://www.openoffice.org/udk/python/python-bridge.html
                    text.insertString( cursor, cline, 0)
                    if nextbr:
                        #text.insertControlCharacter( cursor, LINE_BREAK, 0 )
                        text.insertString( cursor, "\n", 0)
                        br = True
                    else:
                        text.insertControlCharacter( cursor, PARAGRAPH_BREAK, 0 )
                #cursor.setPropertyValue("PageDescName", "Default")
                #cursor.setPropertyValue("PageNumberOffset", 1)

                # Consider
                # https://www.openoffice.org/api/docs/common/ref/com/sun/star/document/XDocumentProperties.html
                # resetUserData
                if log_enabled:
                    logger.debug("Done inserting %s" % inputfile)
                smgr2 = ctx.ServiceManager # just allow service to sync
                if log_enabled:
                    logger.debug("Done syncing.")

            except Exception as e:
                if log_enabled: logger.error("Undef error 2 (" + str(e) + ")")
            fi.close()
        else:
            if log_enabled: logger.error("IOException: 3(not a file) %s" % (i,))
            if debugis: print("No access to file: %s" % (i,))
            sys.exit(1)

    if debugis: print(nline,"saving.")
    if debugis: print("%s merged into %s" % (args, destFile))

    try:
        # newdoc.resetUserData('www-data')
        destFodt = destFile.replace('pdf','fodt')
        newdoc.storeToURL(destFodt,oProps)
        if log_enabled: logger.debug("Done building FODT: %s" % destFodt)
        if debugis: print("   %s" % (destFodt.replace('file:///var/www/public_html',''),))
    except Exception as e:
        if debugis: print("Unexpected error:", sys.exc_info()[0])
        if log_enabled:
            logger.error("Undef error (" + str(e) + ")")
            logger.error("failed: %s" % destFile)

    try:
        if log_enabled: logger.info("store: %s" % destFile)
        newdoc.storeToURL(destFile,(PropertyValue("FilterName",0, "writer_pdf_Export", 1),))
        if log_enabled: logger.info("Done building PDF: %s" % destFile)
        print("OK %s" % (destFile.replace('file:///var/www/public_html',''),))
    except Exception as e:
        if debugis: print("Unexpected error:", sys.exc_info()[0])
        if log_enabled:
            logger.error("Undef error (" + str(e) + ")")
            logger.error("failed: %s" % destFile)

    newdoc.dispose()
    newdoc.close(True)

    if delete_tmp_files:
        for img_name in img_list:
            os.remove( os.path.join(mytdir, img_name))
            if log_enabled: logger.debug("removing: %s" % img_name)
    #
    # Stop here, gmail it!
    #
    if log_enabled:
        logger.info("Session End")

main()
