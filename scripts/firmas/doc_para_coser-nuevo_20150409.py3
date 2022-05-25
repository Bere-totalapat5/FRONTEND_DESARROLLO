#!/usr/bin/python3
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
os.environ['HOME'] = '/var/www'
os.environ['USER'] = 'www-data'
os.environ['USERNAME'] = 'www-data'
os.environ['LOGNAME'] = 'www-data'


mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales")

sello = """<table width=100% style="page-break-inside: avoid;"><tr>
<td><p style="color: #464;page-break-inside: avoid;margin-left: 3em">En el <b><i>Boletín Judicial</i>&nbsp;</b> No. <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U>
correspondiente al día <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de 
<U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> se hizo la publicación de Ley.&mdash; Conste.<br>
El <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> del <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U>, surtió efectos la notificación anterior.&mdash; Conste.</P>
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

from bs4 import BeautifulSoup

def filtro_salida( file_name ):
    l = ""
    try:
        if debugis: print("file:",file_name)
        with  open( file_name,"r", encoding='utf-8') as f:
            l = f.read()

        m = re.search(r'MIME-Version', l)
        if m: # This is .mht --> unpack and load main file
            if debugis: print("Error(1) MHT files not allowed here")
            return ""
    except IndexError: #v2.5+ and up --# as (errno, strerror):
        print("Error(1) Index ({0}): {1}".format(errno, strerror))
        print("Error: input file name ??")
        return ""
    except:
        print("Error(2):", sys.exc_info()[0])
        return ""
    soup = BeautifulSoup(l) # open(file_name))

    del l
    [s.extract() for s in soup('script')]
    [s.extract() for s in soup(class_='comentarios')]
    [s.extract() for s in soup(class_='comment-position')]

    rst00  = re.compile(r'mso-bidi-')
    rst01  = re.compile(r'font-weight: normal;\s?')
    rst02  = re.compile(r'font-style: normal;\s?')
    rst03  = re.compile(r'font-size: [0-9][^;]*;\s?')
    rst04  = re.compile(r'line-height[^;]*;\s?')
    rst05  = re.compile(r'font-size[^;] --cámbiame-- *;\s?')
    rst06  = re.compile(r'margin-left: auto; margin-right: auto;\s?')
    rst07  = re.compile(r'font-family[^;]*;\s?')
    rst08  = re.compile(r'float;\s?')
    rst09  = re.compile(r'float: right;')
    rst09b = re.compile(r'margin-right: 0px;')
    rst10  = re.compile(r'float: left;')
    rst10b = re.compile(r'margin-left: 0px;')
    rst11  = re.compile(r'background-color[^;]*;\s?')

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

    for sz in ('5','6','7','8','9','10','11'):
        cls = 'size-'+ sz +'pt'
        sty = 'font-size: '+ sz +'pt;'
        for t in soup('table', class_=cls):
            for c in t('th','tr'):
                c['style'] = ''
            for c in t('td'):
                c['style'] = sty
    for t in soup('table'):
        if t.has_attr('border') and t['border'] == "1":
            for c in t('td'):
                if c.has_attr('style'): 
                    c['style'] += " border: 0.3pt solid #070707;"
                else:
                    c['style']  = " border: 0.3pt solid #070707;"

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

    if debugis: print("\n" * 2)
    if debugis: print("=" * 66)
    return str(soup)
    # return str(soup)
    # --- ???? ----


re_instancia = re.compile("Instancia: (.*)$")
re_head = re.compile(r"<body[^>]*>")
re_img = re.compile(r"src=\"data:image/([^;]*);base64,([^\"]*)")

rh5 = re.compile(r'(?P<Cin>\</?[Hh])5')
rh4 = re.compile(r'(?P<Cua>\</?[Hh])4')
rh3 = re.compile(r'(?P<Tre>\</?[Hh])3')
rh2 = re.compile(r'(?P<Dos>\</?[Hh])2')
rh1 = re.compile(r'(?P<Uno>\</?[Hh])1')
fpr = re.compile(r'<pre>----------- Firma')
fpr2 = re.compile(r'</pre>\s*<br/>')
fpr3 = re.compile(r'<br/>\s*</br>')
sel = re.compile(r'</body>\s*</html>')

prerepl = '<p style="text-align:right;color: #464;line-height: 9 pt;font-family:Arial Narrow; font-size: xx-small;margin: 0; padding: 0;margin-left: -1.0 in">-- Firma'

def usage():
    sys.stderr.write("usar: /opt/openoffice.org3/program/python doc_para_coser.py "+
                      "       [-c  | --connection-string=]\n"+
		      "       [-o  | --outfile=] \n"+
                      "       file1 file2 ...\n")

def process_fields(text):
    return text

def main():
    cUrl = "file:///var/www/scripts/firmas/tsjdf_plantilla20150105_toficio.ott"
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
        logger.info("Got params %s", ','.join(sys.argv[1:]))

    try:
        ctxLocal = None
        resolver = None
        ctx = None
        smgr = None
        desktop = None

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

    img_counter = 1;
    img_list = []

    for i in args:
        if isfile(i):
            instance = ""
            oLines = []
            rLines = []
            missing_instance = 1;
            (p,n) = os.path.split(i)
            oName = os.path.join(mytdir, n)
            if log_enabled: logger.debug("searching %s for instances" % i)
            fsal = filtro_salida(i)

            for l in fsal.split("\n"):
                if 0 and log_enabled: logger.debug(l)
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
                l = rh5.sub(r'\g<Cin>6',l)
                l = rh4.sub(r'\g<Cua>5',l)
                l = rh3.sub(r'\g<Tre>4',l)
                l = rh2.sub(r'\g<Dos>3',l)
                l = rh1.sub(r'\g<Uno>2',l)

                # if missing_instance == 0 and instance:
                #     m = re_head.search(l)
                #     if m:
                #         l = re_head.sub(r'<body>',l)
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
                    lheight = re.search(r'height="(\d+)"',l)
                    lwidth  = re.search(r'width="(\d+)"',l)
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
                    l = re.sub(r'<img[^>]*>','<img src="'+ os.path.join(mytdir, img_name) + '"' + h + w +'>', l)
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
                allfile = re_head.sub(r'<body>',allfile)
            instance = instance if instance else "&nbsp;"
            allfile = allfile.replace("<body>","<body><h1>" + instance + "</h1>",1)
            # missing_instance = 1;

            if log_enabled: logger.debug("closed %s, %d lines" % (i, len(oLines)))
            del oLines
            # # Replace -- Firma Electrónica
            # allfile = process_fields(allfile)
            allfile = fpr.sub(prerepl,allfile)
            allfile = fpr2.sub("\n",allfile)
            allfile = fpr3.sub("\n",allfile)
            allfile = sel.sub(sello,allfile)
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
                if 0:
                    try:
                        cursor.setPropertyValue("PageDescName", "Default")
                        # cursor.PageDescName = "Default"
                    except Exception as e:
                        if log_enabled:
                            logger.error("Cursor defa error: %s" % fileUrl)
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
            print("No access to file: %s" % (i,))
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
        print("OK %s" % (destFile.replace('file:///var/www/public_html',''),))
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
        logger.debug("Session End")

    sys.exit(0)

main()

