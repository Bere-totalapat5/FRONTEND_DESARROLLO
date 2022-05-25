#!/opt/openoffice.org3/program/python
# -*- coding: utf-8 -*-

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
    logger.setLevel(logging.DEBUG)
    logger.debug("Session Init")

os.environ['TMP'] =  '/tmp'
os.environ['TEMP'] = '/tmp'
os.environ['HOME'] = '/tmp'
os.environ['USER'] = 'apache'
os.environ['USERNAME'] = 'apache'
os.environ['LOGNAME'] = 'apache'

mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales")

sello = """<table width=100% style="page-break-inside: avoid;"><tr>
<td><p style="color: #464;page-break-inside: avoid;margin-left: 3em">En el <b><i>Boletín Judicial</i></b> número <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U>,
correspondiente al día <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de 
<U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> del presente, se hizo la publicación de Ley.&mdash; Conste.<br>
El día <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> del <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> a las doce horas del día surtió sus efectos de notificación.&mdash; Conste.</P>
</td></tr></table></body></html>"""

from os.path import isfile, join
#from os import getcwd
from unohelper import systemPathToFileUrl, absolutize
from com.sun.star.beans import PropertyValue
# from com.sun.star.style.BreakType import PAGE_BEFORE, PAGE_AFTER
from com.sun.star.uno import Exception as UnoException, RuntimeException
from com.sun.star.connection import NoConnectException
from com.sun.star.lang import IllegalArgumentException
from com.sun.star.io import IOException

re_instancia = re.compile("Instancia: (.*)$")
re_head = re.compile(r"</head><body><pre>")
re_img = re.compile(r"src=\"data:image/([^;]*);base64,([^\"]*)")

rh5 = re.compile(r'(?P<Cin>\</?[Hh])5')
rh4 = re.compile(r'(?P<Cua>\</?[Hh])4')
rh3 = re.compile(r'(?P<Tre>\</?[Hh])3')
rh2 = re.compile(r'(?P<Dos>\</?[Hh])2')
rh1 = re.compile(r'(?P<Uno>\</?[Hh])1')
fpr = re.compile(r'<pre>----------- Firma')
sel = re.compile(r'</body></html>')

# findheader = re.compile(r'''<pre>----------- Firma electrónica SICOR/TSJDF Inicio -----------<pksc7_siginit />
#             Instancia: 12° Juzgado de Primera Instancia Civil
#            Expediente: 1999/2010
#            Secretaria: A
#             Documento: 
#             publicado: 2011-09-05
# </pre><br/>
# 
# ''')
# 
# findfooter = re.compile(r'''<pksc7_sigend />
# <br/><pre>----------- Firma electrónica SICOR/TSJDF Fin -----------
# 
# iF4EABEIAAYFAk5hEjoACgkQWymFedlheZPKngEAuUKXVG/UnBelMIDyuG26dFJ3
# AKyhYLWodS6b9kkGZf4A+wchYTOjTzZm7h7HDbnpM7Qr60uKPc5mWPb8HjmpqjXn
# =Z9BL
# </pre>
# ''')


prerepl = '<p style="text-align:right;color: #464;line-height: 9 pt;font-family:Arial Narrow; font-size: xx-small;margin: 0; padding: 0;margin-left: -1.0 in">-- Firma'

def usage():
    sys.stderr.write("usar: /opt/openoffice.org3/program/python doc_para_coser.py "+
                      "       [-c  | --connection-string=]\n"+
		      "       [-o  | --outfile=] \n"+
                      "       file1 file2 ...\n")

def process_fields(text):
    return text

def main():
    cUrl = "file:///var/www/scripts/firmas/tsjdf_plantilla11_toficio.ott"
    outputfile = "resoluciones.pdf"
    retVal = 0

    opts, args = getopt.getopt(sys.argv[1:], "hco:", ["help", "connection-string=", "outfile" ])
    url = "uno:socket,host=localhost,port=2002;urp;StarOffice.ComponentContext"

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
        logger.debug("Got params %s", ','.join(sys.argv[1:]))

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


    except NoConnectException, e:
        if log_enabled: logger.error("OpenOffice process not found or not listening (" + e.Message + ")")
        sys.exit(1)
    except IllegalArgumentException, e:
        if log_enabled: logger.error("The url is invalid (" + e.Message + ")")
        sys.exit(1)
    except RuntimeException, e:
        if log_enabled: logger.error("An unknown error occured: " + e.Message)
        sys.exit(1)

    cwd = systemPathToFileUrl( mytdir )
    destFile = absolutize( cwd, systemPathToFileUrl(outputfile) )
    inProps = PropertyValue( "Hidden" , 0 , True, 0 ),
    oProps  = PropertyValue( "CharacterSet" , 0 , 'utf-8', 0 ),PropertyValue( "Pages" , 0 , 'All', 0 ),
    # inProps = ()
    if log_enabled:
        logger.debug("ooo Conf OK")

    # newdoc = desktop.loadComponentFromURL( "private:factory/swriter", "_blank", 0, inProps )
    try:
        newdoc = desktop.loadComponentFromURL( cUrl, "_blank", 0,  inProps )
    except UnoException, e:
        if log_enabled: logger.error(e.Message)
    except RuntimeException, e:
        if log_enabled: logger.error(e.Message)
    except NoConnectException, e:
        if log_enabled: logger.error(e.Message)
    except IllegalArgumentException, e:
        if log_enabled: logger.error(e.Message)
    except IOException, e:
        if log_enabled: logger.error(e.Message)
    except:
        if log_enabled: logger.error("Could not create a new doc")
        sys.exit(1)

    if log_enabled:
        logger.debug("newdoc  OK")

    text   = newdoc.Text
    cursor = text.createTextCursor()

    img_counter = 1;
    img_list = []

    for i in args:
        if isfile(i):
            instance = ""
            oLines = []
            missing_instance = 1;
            if log_enabled: logger.debug("scanning %s for images",i)
            try:
                f = open( i,"r")
            except:
                if log_enabled: logger.error("openning %s",i)
                sys.exit(1)

            # oName = mkstemp("/dev/shm/")
            (p,n) = os.path.split(i)
            oName = os.path.join(mytdir, n)
            o = open(oName,"w")
            try:
                f = open( i,"r")
                for l in f:
                  if missing_instance:  
                      m = re_instancia.search(l)
                      if m:
                          instance = m.group(1)
                          break
                f.close()
            except Exception as e:
                if log_enabled: logger.error("Error reading input (" + e.Message + ")")
                print "Error creando el temporal"
                sys.exit(1)
            f = open( i,"r")
            for l in f:
              l = rh5.sub(r'\g<Cin>6',l)
              l = rh4.sub(r'\g<Cua>5',l)
              l = rh3.sub(r'\g<Tre>4',l)
              l = rh2.sub(r'\g<Dos>3',l)
              l = rh1.sub(r'\g<Uno>2',l)

              if missing_instance and instance:
                  m = re_head.search(l)
                  if m:
                      l = l.replace("</head><body><pre>",
                               "</head><body><h1>" + instance + "</h1><pre>",1)
                      missing_instance = 0;
              m = re_img.search(l)
              if m:
                  h = ''
                  w = ''
                  img=base64.b64decode(m.group(2))
                  img_type = m.group(1)
                  img_name = "%04d.%s" % (img_counter,img_type)
                  if debugis: print "Found img",img_name
                  img_list.append( img_name )
                  try:
                      img_handle = open(os.path.join(mytdir, img_name),"wb")
                      img_handle.write(img)
                      img_handle.close()
                  except Exception as e:
                      if log_enabled: logger.error("Error Writing Temporary (" + e.Message + ")")
                      print "Error creando el temporal"
                      sys.exit(1)

                  img_counter += 1
                  del img
                  lheight = re.search(r'height="(\d+)"',l)
                  lwidth  = re.search(r'width="(\d+)"',l)
                  if lheight:
                      lheight =  float(lheight.group(1))*resize_val
                      if debugis: print "found height", lheight
                      try:
                          h = ' height="' + str(lheight) + '"'
                      except:
                          pass
                  if lwidth:
                      lwidth =  float(lwidth.group(1))*resize_val
                      if debugis: print "found width", lwidth
                      try:
                          w = ' width="' + str(lwidth) + '"'
                      except:
                          pass
                  l = re.sub(r'<img[^>]*>','<img src="'+ os.path.join(mytdir, img_name) + '"' + h + w +'>', l)
                  # l = re_img.sub('src="'+ img_name, l)
                  if debugis: print img_name,h,w
                  if log_enabled:
                      logger.debug( "img: %s %s %s" %
                                    (os.path.join(mytdir, img_name),h,w ))
              oLines.append(l)
            f.close()
            allfile = "".join(oLines)
            del oLines
            # # Replace -- Firma Electrónica
            # allfile = process_fields(allfile)
            allfile = fpr.sub(prerepl,allfile)
            allfile = sel.sub(sello,allfile)
            try:
                o.write(allfile)
                o.close()
            except Exception as e:
                if log_enabled: logger.error("Error Writing Temporary (" + e.Message + ")")
                print "Error creando el temporal"
                sys.exit(1)

            if debugis: print "Done scanning: %s" % i
            if log_enabled:
                logger.debug( "Done scanning: %s" % i )

            try:
                fileUrl = absolutize( cwd, systemPathToFileUrl(oName) )
                if log_enabled:
                    logger.debug("Appending %s" % fileUrl)
                if debugis: print "Appending %s" % fileUrl
                try:
                    cursor.gotoEnd(False)
                    cursor.setPropertyValue("PageDescName", "Default")
                    cursor.setPropertyValue("PageNumberOffset", 1)

                    cursor.insertDocumentFromURL(fileUrl, ())
                    if 0 and debugis:
                        o = open(oName,"r")
                        for l in o:
                            print l
                        o.close()
                        print "-" * 77

                    if log_enabled:
                        logger.debug("Inserting %s" % fileUrl)
                    if delete_tmp_files:
                        os.remove(oName)

                except IOException, e:
                    if log_enabled: logger.error("Error IO (" + e.Message + ")")
                except IllegalArgumentException, e:
                    if log_enabled: logger.error("The url is invalid (" + e.Message + ")")
                except Exception, e:
                    if log_enabled: logger.error("Undef error (" + e.Message + ")")

            except IOException as e:
                if log_enabled: logger.error("Error IO 2: " + e.Message)
            except UnoException as e:
                if log_enabled: logger.error("Error 2("+repr(e.__class__)+") during conversion:" + e.Message)
            except Exception as e:
                if log_enabled: logger.error("Undef error 2(" + e.Message + ")")
        else:
            if log_enabled: logger.error("IOException: 3(not a file) %s" % (i,))
            print "No access to file: %s" % (i,)
            sys.exit(1)

    if debugis: print "saving."
    if debugis: print "%s merged into %s" % (args, destFile)
    e = False
    try:
        destFodt = destFile.replace('pdf','odt')
        if log_enabled: logger.info("store: %s" % destFile) # .replace('file:///var/www/public_html',''))
        newdoc.storeAsURL(destFodt,oProps) # (PropertyValue("FilterName",0, "ODF Text Document", 1),))
        #MAL newdoc.storeAsURL(destFodt)
        if debugis: newdoc.storeToURL(destFile,(PropertyValue("FilterName",0, "writer_pdf_Export", 1),))
        print "OK %s" % (destFile.replace('file:///var/www/public_html',''),)
    except IOException as e:
        if log_enabled:
            logger.error("Error IO (" + e.Message + ")")
            logger.error("failed: %s" % destFile) #.replace('file:///var/www/public_html',''))
    except IllegalArgumentException as e:
        if log_enabled:
            logger.error("The url is invalid (" + e.Message + ")")
            logger.error("failed: %s" % destFile) #.replace('file:///var/www/public_html',''))
    except Exception as e:
        print "Unexpected error:", sys.exc_info()[0]
        if log_enabled:
            logger.error("Undef error (" + e.Message + ")")
            logger.error("failed: %s" % destFile) #.replace('file:///var/www/public_html',''))

    newdoc.dispose()

    if delete_tmp_files:
        for img_name in img_list:
            os.remove( os.path.join(mytdir, img_name))
            if log_enabled: logger.debug("removing: %s" % img_name)

    if log_enabled:
        logger.debug("Session End")

main()

