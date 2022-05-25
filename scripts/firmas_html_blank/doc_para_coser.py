#!/usr/bin/python3
# -*- coding: utf-8 -*-

# check for page num.: http://openoffice.2283327.n4.nabble.com/python-uno-the-page-number-is-blank-on-the-first-page-td3179194.html

delete_tmp_files = False # True # 
resize_val = 1.0 # muy grande: 120.0/72.0
debugis = False
log_enabled = True

import sys
import MySQLdb
#import qrcode

# find a port: RoundRobin
tasknum = 0
qrimg         = ""
mide_clave_qr = """SELECT gestor_documental 
FROM jucio_datos_personales 
WHERE id_acuerdo = %s"""

try:
    with open("/tmp/sofficetask","rt") as f:
        tn = f.read()
        if tn:
            tasknum = int(tn)
except:
    pass
tasknum += 1
try:
    with open("/tmp/sofficetask","wt") as f:
        f.write(str(tasknum))
except:
    pass
portnum = 2002 + (tasknum % 8)

# -- port found
from time import strftime, localtime, time
start_time = time()
import logging
import getopt
import uno
import os, re, base64
from tempfile import mkdtemp
import psutil
from anio_acuerdo import leyenda_multianual

if log_enabled: #debug(), info(), warning(), error() and critical()
    logger = logging.getLogger("oooDocs")
    hdlr = logging.FileHandler("/tmp/docs.log")
    formatter = logging.Formatter("%(asctime)s [%(process)d] :"+str(portnum-2000)+": %(levelname)s - %(message)s")
    hdlr.setFormatter(formatter)
    logger.addHandler(hdlr)
    logger.setLevel(logging.DEBUG)
    logger.debug("Session Init")

os.environ['TMP'] =  '/tmp'
os.environ['TEMP'] = '/tmp'
os.environ['HOME'] = '/var/www'
os.environ['USER'] = 'www-data'
os.environ['USERNAME'] = 'www-data'
os.environ['LOGNAME'] = 'www-data'


mytdir = mkdtemp(prefix='rpt_',dir="/var/www/html/sicor_extendido_80/public/temporales/")
#pbia =  style="page-break-inside: avoid;"
sello = ""

from os.path import isfile, join
#from os import getcwd
from unohelper import systemPathToFileUrl, absolutize
from com.sun.star.beans import PropertyValue
from com.sun.star.style.BreakType import PAGE_BEFORE, PAGE_AFTER
from com.sun.star.text.ControlCharacter import PARAGRAPH_BREAK
from com.sun.star.uno import Exception as UnoException, RuntimeException
from com.sun.star.connection import NoConnectException
from com.sun.star.lang import IllegalArgumentException
from com.sun.star.io import IOException

from bs4 import BeautifulSoup

rst00  = re.compile('mso-bidi-')
rst01  = re.compile('font-weight: normal;\s?')
rst02  = re.compile('font-style: normal;\s?')
rst03  = re.compile('font-size: [0-9][^;]*;\s?')
rst04  = re.compile('line-height[^;]*;\s?')
rst05  = re.compile('font-size[^;] --cámbiame-- *;\s?')
rst06  = re.compile('margin-left: auto; margin-right: auto;\s?')
rst07  = re.compile('font-family[^;]*;\s?')
rst08  = re.compile('float;\s?')
rst09  = re.compile('float: right;')
rst09b = re.compile('margin-right: 0px;')
rst10  = re.compile('float: left;')
rst10b = re.compile('margin-left: 0px;')
rst11  = re.compile('background-color[^;]*;\s?')
st1    = re.compile('</?st[^>]*>')
strong = re.compile('<stron>')
em     = re.compile('<em>')


def makeqr(gestor_documental):
    qr   = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_M,
        box_size=10,
        border=4,
    )
    qr.add_data("http://mide.poderjudicialcdmx.gob.mx/?NumeroDocumento=%s" % (gestor_documental))
    qr.make(fit=True)
    img  = qr.make_image()
    rimg = os.path.join("/san/www/public_html/temporales/","%s.png" % gestor_documental)
    img.save(rimg)
    # print("saved: %s" % "qr.png")
    return rimg


def filtro_salida( file_name ):
    l = ""
    # full_file = []
    try:
        if debugis: print("file:",file_name)
        with  open( file_name,"rt", encoding='utf-8') as f:
            l = "".join( [st1.sub("",x.replace('em>','i>').replace('strong>','b>'))
                                  for x in f] )

    except IndexError: #v2.5+ and up --# as (errno, strerror):
        print("Error(1) Index ({0}): {1}".format(errno, strerror))
        print("Error: input file name ??")
        return ""
    except:
        print("Error(2):", sys.exc_info()[0])
        return ""

    # l = "".join(full_file)
    m = re.search('MIME-Version', l)
    if m: # This is .mht --> unpack and load main file
        if debugis: print("Error(1) MHT files not allowed here")
        return ""
    soup = BeautifulSoup(l, "html.parser") # open(file_name))

    del l
    [s.extract() for s in soup('script')]
    [s.extract() for s in soup(class_='comentarios')]
    [s.extract() for s in soup(class_='comment-position')]

    for find_this_style in ('p','span','table','img','div'):
        for s in soup(find_this_style):
            if s.has_attr('style'):
                sty = s['style']
                if debugis: print(find_this_style + "::\n---" + sty)
                sty = rst00.sub('',sty)
                sty = rst01.sub('',sty)
                sty = rst02.sub('',sty)
                sty = rst03.sub('',sty)
                sty = rst04.sub('',sty)
                # sty = rst05.sub('',sty)
                sty = rst06.sub('align: center; ',sty)
                sty = rst07.sub('',sty)
                # sty = rst08.sub('',sty)
                sty = rst09.sub('text-align: right; margin-right: 0;',sty)
                sty = rst09b.sub('text-align: right; margin-right: 0;',sty)
                sty = rst10.sub('text-align: left; margin-left: 0;',sty)
                sty = rst10b.sub('text-align: left; margin-left: 0;',sty)
                sty = rst11.sub('',sty)
                #if debugis: print("    " + sty)
                s['style'] = sty
                if debugis: print(s['style'], end="\n\n\n")
    if debugis: print("End of find_this_sttyle")
    for sz in ('5','6','7','8','9','10','11'):
        cls = 'size-'+ sz +'pt'
        sty = 'font-size: '+ sz +'pt;'
        for t in soup('table', class_=cls):
            for c in t('th','tr'):
                c['style'] = ''
            for c in t('td'):
                c['style'] = sty
    if debugis: print("End of sz")
    for t in soup('table'):
        if t.has_attr('border') and t['border'] == "1":
            for c in t('td'):
                if c.has_attr('style'): 
                    c['style'] += " border: 0.3pt solid #070707;"
                else:
                    c['style']  = " border: 0.3pt solid #070707;"
    if debugis: print("End of table")
    for t in soup('p', class_="indented"):
        # print("got indented")
        if t.has_attr('style'): 
            t['style'] += " margin-left: 2.0cm;"
        else:
            t['style']  = " margin-left: 2.0cm;"
    if debugis: print("End of p indented")
    notas = soup.find_all('span', class_="note-position")
    notenum = 0
    for tag in notas:
        id = tag['id']
        if debugis: print("Nota : ",id)
        fn = None
        for c in soup.find_all('div', class_="nota"):
            fn = None
            notenum += 1
            divnotenum = "sdfootnote%d" % notenum
            divnote = soup.new_tag('div', id=divnotenum)
            symn = "sdfootnote%danc" % notenum
            symb = "sdfootnote%dsym" % notenum
            if debugis and log_enabled: logger.debug("symb: "+symb + " symn: " + symn)
            # <a class="sdfootnoteanc" name="sdfootnote1anc" href="#sdfootnote1sym"><sup>1</sup></a>
            fn = soup.new_tag('a', href="#"+symb, **{'class':'sdfootnoteanc'})
            fn['name']=symn
            num = soup.new_tag('sup')
            num.string = str(notenum)
            fn.append(num)
            if c.has_attr('data-uuid') and c['data-uuid'] == id:
                if debugis: print("      footnote:",c.string)
                fnotetext = c.extract()
                #fnote.string = fnotetext
                # <p class="sdfootnote"><a class="sdfootnotesym" name="sdfootnote1sym" href="#sdfootnote1anc">1</a>Nota
                notesym = soup.new_tag('a', href="#"+symn, **{'class':'sdfootnotesym'} )
                notesym['name']=symb
                notesym.string = str(notenum)
                notetxt = soup.new_tag('p', **{'class':'sdfootnote'})
                notetxt.append(notesym)
                notetxt.append(fnotetext.string)
                divnote.append(notetxt)
                soup.body.append(divnote)
                break
        if fn is not None: tag.replace_with(fn)
    if debugis: print("End of notes")
    if debugis: print("\n" * 2)
    if debugis: print("=" * 66)
    if debugis: print(str(soup))
    if debugis: print("=" * 66)
    return str(soup)
    # return str(soup)
    # --- ???? ----


re_instancia = re.compile("Instancia: (.*)$")
re_head = re.compile(r"<body[^>]*>")
re_img = re.compile(r"src=\"data:image/([^;]*);base64,([^\"]*)")

rh5 = re.compile('(?P<Cin>\</?[Hh])5')
rh4 = re.compile('(?P<Cua>\</?[Hh])4')
rh3 = re.compile('(?P<Tre>\</?[Hh])3')
rh2 = re.compile('(?P<Dos>\</?[Hh])2')
rh1 = re.compile('(?P<Uno>\</?[Hh])1')
fpr = re.compile('<pre>----------- Firma')
fpr2 = re.compile('</pre>\s*<br/>')
fpr3 = re.compile('<br/>\s*</br>')
fpr5 = re.compile('<pksc7_sigend></pksc7_sigend>\s*<br/>')
sel2 = re.compile('</body>\s*</html>')
pdd  = re.compile('p style="padding-left: 2cm;"')

prerepl = '<p style="text-align:right;color: #464;line-height: 9 pt;font-family:Arial Narrow; font-size: xx-small;margin: 0; padding: 0;margin-left: -1.0 in">-- Firma'
prerepl = ''

def usage():
    sys.stderr.write("usar: /opt/openoffice.org3/program/python doc_para_coser.py "+
                      "       [-c  | --connection-string=]\n"+
		      "       [-o  | --outfile=] \n"+
                      "       file1 file2 ...\n")

def process_fields(text):
    return text

def read_docx(desktop,filename):
    newdoc = ""
    try:
        cwd = systemPathToFileUrl( mytdir )
        cUrl = absolutize(cwd, systemPathToFileUrl(filename))
        # document = self.desktop.loadComponentFromURL( inputurl , "_blank", 0, inputprops )
        inProps = PropertyValue( "Hidden" , 0 , True, 0 ),
        newdoc = desktop.loadComponentFromURL( cUrl, "_blank", 0,  inProps )
        if debugis and log_enabled: logger.debug("newdoc for DOCX ok")
    except Exception as e:
        if debugis and log_enabled: logger.debug("DOCX Error loading:",filename,str(e))
        return ""
    if not newdoc:
        raise UnoException("The document '%s' could not be opened." % inputurl, None)
        if log_enabled: logger.error("newdoc for DOCX failed")
    else:
        if debugis and log_enabled: logger.debug("newdoc for DOCX ok")
    return newdoc

anio_plantilla = {
    2020:"tsjdf_plantilla20200101_toficio.ott",
    2019:"tsjdf_plantilla20190101_toficio.ott",
	2018:"tsjdf_plantilla20180101_toficio.ott",
    2017:"tsjdf_plantilla20170103_toficio.ott",
    2016:"tsjdf_plantilla20160211_toficio.ott",
    2015:"tsjdf_plantilla20150105_toficio.ott",
    2014:"tsjdf_plantilla20140107_toficio.ott",
    2013:"tsjdf_plantilla20130111_toficio.ott",
    2012:"tsjdf_plantilla2012a_toficio.ott",
    2011:"tsjdf_plantilla2011a_toficio.ott",
    "blank":"blank.ott"
}

def main():
    cUrl = "file:///var/www/scripts/firmas/tsjdf_plantilla20170103_toficio.ott"
    outputfile = "resoluciones.pdf"
    retVal = 0

    opts, args = getopt.getopt(sys.argv[1:], "hcop:", ["help", "connection-string=", "outfile", "port" ])
    url = "uno:socket,host=localhost,port="+str(portnum)+";urp;StarOffice.ComponentContext"
    #url = "uno:socket,host=localhost,port=2002;urp;StarOffice.ComponentContext"
    #print(url)
    for o, a in opts:
        if o in ("-h", "--help"):
            usage()
            sys.exit()
        if o in ("-c", "--connection-string" ):
            url = "uno:" + a + ";urp;StarOffice.ComponentContext"
        if o in ("-p", "--port" ):
            url = "uno:socket,host=localhost,port="+a+";urp;StarOffice.ComponentContext"
        if o in ("-o", "--outfile"):
            outputfile = a

    if not len( args ):
        usage()
        sys.exit()

    if log_enabled:
        logger.info("Got params %s", ','.join(sys.argv[1:]))
    # evitar que crezca la cola de impresión
    x=0
    for p in psutil.process_iter():
        if p.name == 'python3':
            x += 1
    if x > 40:
        if log_enabled:
            logger.error("Too many processes running")
            logger.debug("Session End")
        print("No es posible producir PDF, carga excesiva en el sistema")
        sys.exit(0)
    # leyenda multianual
    anio  = 2020
    numac = ""
    #(anio, numac) = leyenda_multianual( sys.argv[1:] )
    if log_enabled: logger.debug("Multianual anio for %s is %d" % (numac,anio))

    if anio in anio_plantilla:
        cUrl = "file:///var/www/html/sicor_extendido_80/scripts/firmas_html/blank.ott" 

    try:
        ctxLocal = None
        resolver = None
        ctx      = None
        smgr     = None
        desktop  = None

        ctxLocal = uno.getComponentContext()
        if ctxLocal is None:
            logger.error("Can't create ctxLocal")
            sys.exit()

        resolver = ctxLocal.ServiceManager.createInstanceWithContext(
            "com.sun.star.bridge.UnoUrlResolver", ctxLocal )
        if resolver is None:
            logger.error("Can't create resolver")
            sys.exit()
        ctx = resolver.resolve( url )
        if ctx is None:
            logger.error("Can't create ctx")
            sys.exit()
        smgr = ctx.ServiceManager
        if smgr is None:
            logger.error("Can't create smgr")
            sys.exit()
        desktop = smgr.createInstanceWithContext("com.sun.star.frame.Desktop", ctx )
        if desktop:
            if log_enabled:
                logger.debug("ooo Desktop OK")
        else:
            logger.error("Can't get desktop")
            sys.exit()

    except NoConnectException as e:
        if log_enabled:
            logger.error("OpenOffice process not found or not listening (" + e.Message + ")")

        #main()    
        sys.exit(1)
    except IllegalArgumentException as e:
        if log_enabled:
            logger.error("The url is invalid IllegalArgumentException (" + e.Message + ")")
        sys.exit(1)
    except RuntimeException as e:
        if log_enabled:
            logger.error("An unknown error occured: " + e.Message)
        sys.exit(1)

    cwd = systemPathToFileUrl( mytdir )
    #print(cwd)
    destFile = absolutize( cwd, systemPathToFileUrl(outputfile) )
    inProps = PropertyValue( "Hidden" , 0 , True, 0 ),
    oProps  = PropertyValue( "CharacterSet" , 0 , 'utf-8', 0 ),PropertyValue( "Pages" , 0 , 'All', 0 ),
    # inProps = ()
    if log_enabled:
        logger.debug("ooo Conf OK")
    newdoc = ""
    # newdoc = desktop.loadComponentFromURL( "private:factory/swriter", "_blank", 0, inProps )
    try:
        newdoc = desktop.loadComponentFromURL( cUrl, "_blank", 0,  inProps )
    except UnoException as e:
        if log_enabled: logger.error(e.Message)
    except RuntimeException as e:
        if log_enabled: logger.error(e.Message)
    except NoConnectException as e:
        if log_enabled: logger.error(e.Message)
    except IllegalArgumentException as e:
        if log_enabled: logger.error(e.Message)
    except IOException as e:
        if log_enabled: logger.error(e.Message)
    except:
        if log_enabled: logger.error("Could not create a new doc")
        sys.exit(1)

    if newdoc:
        logger.debug("newdoc  OK")
    else:
        logger.error("Can't get desktop")
        sys.exit()

    text   = newdoc.Text
    cursor = text.createTextCursor()
    cursor_mide = text.createTextCursor()
    second_time = False
    img_counter = 1;
    img_list = []

    for i in args:
        if (not isfile(i)) and ("/firmados/" in i):
            ialtern = i.replace("/firmados/","/porfirmar/")
            if isfile( ialtern ):
                with  open( ialtern,"rt", encoding='utf-8') as f:
                    l = [ x for x in f
                          if ("Firma electrónica SICOR/TSJDF Inicio") in x ]
                if len(l) > 0: # == 2:
                    i = ialtern

        if isfile(i):
            if i.endswith('doc') or i.endswith('docx'):
                newdoc = read_docx(desktop, i)
            else:
                instance = ""
                oLines = []
                rLines = []
                missing_instance = 1;
                (p,n) = os.path.split(i)
                if log_enabled: logger.debug("id_acuerdo %s",n)
                id_acuerdo = n
                
                id_acuerdo = id_acuerdo.replace(".html","")
                id_acuerdo = id_acuerdo.replace(".htm","")
                if log_enabled: logger.debug("id_acuerdo2 %s",id_acuerdo)
                
                #db = MySQLdb.connect(db="sibjdf",
                                     #user="sicor",
                                     #passwd="SdbmjHjBq2p3Qsw4",
                                     #charset='utf8')
                #db.autocommit(True)
                #cursor_mide = db.cursor()
                #cursor_mide.execute( mide_clave_qr % (id_acuerdo,))
                #if cursor_mide.rowcount > 0:
                #    (gestor_documental,) = cursor_mide.fetchone()
                #    if log_enabled: logger.debug("gestor_documental %s",gestor_documental)
                    #qrimg = makeqr(gestor_documental)
                
                oName = os.path.join(mytdir, n)
                if log_enabled: logger.debug("searching %s for instances" % i)
                fsal = filtro_salida(i)

                for l in fsal.split("\n"):
                    if 0 and log_enabled: logger.debug(l)
                    l = st1.sub("",l)
                    rLines.append(l)
                    if missing_instance:  
                        try:
                            m = re_instancia.search(l)
                            if m:
                                instance = m.group(1)
                                missing_instance = 0
                        except Exception as e:
                            if log_enabled:
                                logger.error("Error re_instancia (" + e.Message + ")")
                            sys.exit(4)

                if log_enabled: logger.debug("scanning %d lines from %s for images" % (len(rLines), i))

                for l in rLines:
                    l = rh5.sub('\g<Cin>6',l)
                    l = rh4.sub('\g<Cua>5',l)
                    l = rh3.sub('\g<Tre>4',l)
                    l = rh2.sub('\g<Dos>3',l)
                    l = rh1.sub('\g<Uno>2',l)
                    l = pdd.sub('p class="indented" style="margin-left: 2cm;"',l)

                    # if missing_instance == 0 and instance:
                    #     m = re_head.search(l)
                    #     if m:
                    #         l = re_head.sub('<body>',l)
                    #         l = l.replace("<body>",
                    #                "<body><h1>" + instance + "</h1><pre>",1)
                    #         missing_instance = 1;
                    m = re_img.search(l)
                    if m:
                        h = ''
                        w = ''
                        img=base64.b64decode(m.group(2))
                        img_type = m.group(1)
                        img_name = "%04d.%s" % (img_counter,img_type)
                        if debugis: print("Found img",img_name)
                        img_list.append( img_name )
                        try:
                            with open(os.path.join(mytdir, img_name),"wb") as img_handle:
                                img_handle.write(img) # as bytes
                        except Exception as e:
                            if log_enabled:
                                logger.error("Error creando imagen %s (" % img_name + e.Message + ")")
                            sys.exit(1)

                        img_counter += 1
                        del img
                        lheight = re.search('height="(\d+)"',l)
                        lwidth  = re.search('width="(\d+)"',l)
                        if lheight:
                            lheight =  float(lheight.group(1))*resize_val
                            if debugis: print("found height", lheight)
                            try:
                                h = ' height="' + str(lheight) + '"'
                            except:
                                pass
                        if lwidth:
                            lwidth =  float(lwidth.group(1))*resize_val
                            if debugis: print("found width", lwidth)
                            try:
                                w = ' width="' + str(lwidth) + '"'
                            except:
                                pass
                        l = re.sub('<img[^>]*>','<img src="'+ os.path.join(mytdir, img_name) + '"' + h + w +'>', l)
                        # l = re_img.sub('src="'+ img_name, l)
                        if log_enabled:
                            logger.debug( "img: %s %s %s" %
                                          (os.path.join(mytdir, img_name),h,w ))
                    oLines.append(l)

                allfile = " ".join(oLines)
                # if missing_instance == 0:
                m = re_head.search(allfile)
                if m:
                    if debugis and log_enabled: logger.debug("Got BODY: %s" % m.group(0))
                    allfile = re_head.sub('<body>',allfile)
                instance = instance if instance else "&nbsp;"
                instance = "Centésimo de lo Familiar"
                path = "/san/www/html/sicor_extendido_80/storage/app/firmados/juzgado_nombre.txt"
                days_file = open(path,'r')
                instance = days_file.readline() 


                if log_enabled: logger.debug("id_acuerdo impresion %s",id_acuerdo)
                if log_enabled: logger.debug("instance impresion %s",instance)
                allfile = allfile.replace("<body>","<body><h1>" + instance + "</h1>",1)
                #se pone el ID
                allfile = allfile.replace("</pre><br/>","-" + id_acuerdo + "</pre><br/>",2)
                #allfile = allfile.replace("<body>","<body><h1>" + instance + "</h1>",1)
                # missing_instance = 1;

                if log_enabled: logger.debug("closed %s, %d lines" % (i, len(oLines)))
                del oLines
                # # Replace -- Firma Electrónica
                # allfile = process_fields(allfile)
                #se pone el id
                #allfile = fpr.sub(prerepl,allfile)
                #allfile = fpr2.sub("\n",  allfile)
                #allfile = fpr3.sub("\n",  allfile)
                #allfile = fpr5.sub("",    allfile)
                allfile = sel2.sub("",    allfile)

                allfile += sello
                if log_enabled: logger.debug("sealed %s" % i)
                try:
                    with open(oName,"wb") as ofile2:
                        ofile2.write(bytes(allfile, 'UTF-8'))
                    if log_enabled:
                        logger.debug( "Written allfile: %s" % oName )
                except Exception as e:
                    if log_enabled: logger.error("Error Writing Temporary (" + e.Message + ")")
                    sys.exit(1)

                if debugis: print("Done scanning: %s" % i)
                if log_enabled:
                    logger.debug( "Done scanning: %s" % i )

                try:
                    fileUrl = absolutize( cwd, systemPathToFileUrl(oName) )
                    if log_enabled:
                        logger.debug("Appending %s" % fileUrl)
                    if debugis: print("Appending %s" % fileUrl)
                    try:
                        cursor.gotoEnd(False)
                    except Exception as e:
                        if log_enabled:
                            logger.error("Cursor goto error: %s" % fileUrl)
                    if 1:
                        if second_time:
                            try:
                                # ---- ??? ---
                                cursor.BreakType = PAGE_AFTER
                                text.insertControlCharacter( cursor, PARAGRAPH_BREAK, 0 )
                                cursor.setPropertyValue("PageDescName", "Default Style")
                                #cursor.PageDescName = "Default"

                            except Exception as e:
                                if log_enabled:
                                    logger.error("Cursor defa error: %s at %s" % (str(e),fileUrl))
                        else:
                            second_time = True
                    try:
                        cursor.setPropertyValue("PageNumberOffset", 1)
                    except Exception as e:
                        if log_enabled:
                            logger.error("Cursor page error: %s" % fileUrl)
                    try:
                        cursor.insertDocumentFromURL(fileUrl, ())
                        if 0 and debugis:
                            o = open(oName,"r")
                            for l in o:
                                print(l)
                            o.close()
                            print("-" * 77)

                        if log_enabled:
                            logger.debug("Inserting %s" % fileUrl)
                        if delete_tmp_files:
                            os.remove(oName)

                        if 0:
                            try:
                                cursor.BreakType = PAGE_AFTER
                            except Exception as e:
                                if log_enabled:
                                    logger.error("Cursor defa error: %s" % fileUrl)

                    except IOException as e:
                        if log_enabled: logger.error("Error IO (" + e.Message + ")")
                    except IllegalArgumentException as e:
                        if log_enabled: logger.error("The url is invalid (" + e.Message + ")")
                    except Exception as e:
                        if log_enabled: logger.error("Undef error (" + e.Message + ")")

                except IOException as e:
                    if log_enabled: logger.error("Error IO 2: " + e.Message)
                    sys.exit()
                except UnoException as e:
                    if log_enabled: logger.error("Error 2("+repr(e.__class__)+") during conversion:" + e.Message)
                    sys.exit()
                except Exception as e:
                    if log_enabled: logger.error("Undef error 2(" + e.Message + ")")
                    sys.exit()
        else:
            if log_enabled: logger.error("IOException: 3 (not a file) %s" % (i,))
            print("ERROR: No hay archivo para el acuerdo")
            sys.exit(0)

    if debugis: print("saving.")
    if debugis: print("%s merged into %s" % (args, destFile))
    e = False
    try:
        destFodt = destFile.replace('pdf','odt')
        if log_enabled: logger.info("store: %s" % destFile) # .replace('file:///var/www/public_html',''))
        # ???? OjO con el " or 1"
        if debugis or 1: newdoc.storeAsURL(destFodt,oProps) # (PropertyValue("FilterName",0, "ODF Text Document", 1),))
        #MAL newdoc.storeAsURL(destFodt)
        newdoc.storeToURL(destFile,(PropertyValue("FilterName",0, "writer_pdf_Export", 1),))
        print("OK %s" % (destFile.replace('file:///san/www/public_html',''),))
    except IOException as e:
        if log_enabled:
            logger.error("Error IO (" + e.Message + ")")
            logger.error("failed: %s" % destFile) #.replace('file:///var/www/public_html',''))
    except IllegalArgumentException as e:
        if log_enabled:
            logger.error("The url is invalid (" + e.Message + ")")
            logger.error("failed: %s" % destFile) #.replace('file:///var/www/public_html',''))
    except Exception as e:
        print("Unexpected error:", sys.exc_info()[0])
        if log_enabled:
            logger.error("Undef error (" + e.Message + ")")
            logger.error("failed: %s" % destFile) #.replace('file:///var/www/public_html',''))

    newdoc.dispose()

    if delete_tmp_files:
        for img_name in img_list:
            os.remove( os.path.join(mytdir, img_name))
            if log_enabled: logger.debug("removing: %s" % img_name)

    if log_enabled:
        try:
            elapsed = (time() - start_time) or 1e-6
            tfiles = len(args)
            if tfiles < 1:
                tfiles = 1
            efic = tfiles/elapsed
        except:
            efic    = 0.0
            elapsed = 0.0
            tfiles  = 0
        logger.debug("Session End. %.4f s. %3d %.4f docs/s" % (elapsed,tfiles,efic))

    sys.exit(0)

main()

