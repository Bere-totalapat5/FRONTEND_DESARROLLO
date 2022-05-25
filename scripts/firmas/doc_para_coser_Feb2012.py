#!/opt/openoffice.org3/program/python
# -*- coding: utf-8 -*-

# check for page num.: http://openoffice.2283327.n4.nabble.com/python-uno-the-page-number-is-blank-on-the-first-page-td3179194.html

delete_tmp_files = True # False
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

mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales")

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

def usage():
    sys.stderr.write( "usar: /opt/openoffice.org3/program/python doc_para_coser.py "+
                      "       [-c  | --connection-string=]\n"+
		      "       [-o  | --outfile=] \n"+
                      "       file1 file2 ...\n")

def main():
    cUrl = "file:///var/www/scripts/firmas/tsjdf_plantilla08_toficio.ott"
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
            f = open( i,"r")
            for l in f:
              if missing_instance:  
                  m = re_instancia.search(l)
                  if m:
                      instance = m.group(1)
                      break
            f.close()
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
                  img_handle = open(os.path.join(mytdir, img_name),"wb")
                  img_handle.write(img)
                  img_handle.close()
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
            o.write("".join(oLines))
            o.close()
            del oLines
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
                    if delete_tmp_files:
                        os.remove(oName)

                except IOException, e:
                    if log_enabled: logger.error("Error during opening ( " + e.Message + ")")
                except IllegalArgumentException, e:
                    if log_enabled: logger.error("The url is invalid ( " + e.Message + ")")

            except IOException, e:
                if log_enabled: logger.error("Error during opening: " + e.Message)
            except UnoException, e:
                if log_enabled: logger.error("Error ("+repr(e.__class__)+") during conversion:" + e.Message)
        else:
            if log_enabled: logger.error("IOException: (not a file) %s" % (i,))

    if debugis: print "saving."
    if debugis: print "%s merged into %s" % (args, destFile)

    try:
        newdoc.storeToURL(destFile,(PropertyValue("FilterName",0, "writer_pdf_Export", 1),))
        if log_enabled: logger.info("store: %s" % destFile.replace('file:///var/www/public_html',''))
        print "OK %s" % (destFile.replace('file:///var/www/public_html',''),)
    except e:
        if log_enabled:
            logger.error("failed: %s" % destFile.replace('file:///var/www/public_html',''))
            logger.error(e)

    newdoc.dispose()

    if delete_tmp_files:
        for img_name in img_list:
            os.remove( os.path.join(mytdir, img_name))
            if log_enabled: logger.debug("removing: %s" % img_name)


    if log_enabled:
        logger.debug("Session End")

main()

