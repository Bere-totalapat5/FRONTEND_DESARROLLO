#!/usr/bin/python3
# -*- coding: utf-8 -*-

# check for page num.: http://openoffice.2283327.n4.nabble.com/python-uno-the-page-number-is-blank-on-the-first-page-td3179194.html

delete_tmp_files = False # True # 
resize_val       = 1.0 # muy grande: 120.0/72.0
debugis          = False
log_enabled      = True
logger           = False
FILESBASE        = "/tmp/gotfile"
USE_WINDOWS      = True
args             = []

import sys
# find a port: RoundRobin
tasknum = 0
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
portnum = 2002 + (tasknum % 4)
# -- start                                                                        
import logging, getopt, uno, os, re, base64, subprocess, shutil
from time import strftime, localtime, time, sleep
from tempfile import mkdtemp
import psutil

start_time = time()

if log_enabled: #debug(), info(), warning(), error() and critical()
    logger = logging.getLogger("oooDocs")
    hdlr = logging.FileHandler("/tmp/docs.log")
    formatter = logging.Formatter("%(asctime)s [%(process)d] :"+str(portnum-2000)+": %(levelname)s - %(message)s")
    hdlr.setFormatter(formatter)
    logger.addHandler(hdlr)
    logger.setLevel(logging.DEBUG)
    logger.debug("Session Init")
    if 0:
        for key in os.environ.keys():
            logger.debug("%30s %s \n" % (key,os.environ[key]))

os.environ['TMP']      =  '/tmp'
os.environ['TEMP']     = '/tmp'
os.environ['HOME']     = '/var/www'
os.environ['USER']     = 'www-data'
os.environ['USERNAME'] = 'www-data'
os.environ['LOGNAME']  = 'www-data'
os.environ['LANG']     = 'es_MX.UTF-8'
os.environ['LC_ALL']   = 'C'
os.environ['MAIL']     = '/var/mail/www-data'
os.environ['PATH']     = '/usr/local/sbin:/usr/local/bin:/usr/bin:/bin'
os.environ['SHELL']    = '/bin/bash'

from sello_firma_al_margen import firma_pdf, get_acuerdo
from newtask_to_pdf        import send_to_win_queue

if 0 and log_enabled: #debug(), info(), warning(), error() and critical()
    for key in os.environ.keys():
        logger.debug("%s=%s\n" % (key,os.environ[key]))


mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales")

sello = """<table width=100% style="page-break-inside: avoid;"><tr>
<td><p style="color: #464;page-break-inside: avoid;margin-left: 3em">En el <b><i>Boletín Judicial</i>&nbsp;</b> No. <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U>
correspondiente al día <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de 
<U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> se hizo la publicación de Ley.&mdash; Conste.<br>
El <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> de <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U> del <U>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</U>, surtió efectos la notificación anterior.&mdash; Conste.</P>
</td></tr></table></body></html>"""

from os.path import isfile
#from os import getcwd
from unohelper import systemPathToFileUrl, absolutize
from com.sun.star.beans import PropertyValue
# from com.sun.star.style.BreakType import PAGE_BEFORE, PAGE_AFTER
from com.sun.star.text.ControlCharacter import PARAGRAPH_BREAK
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
        if debugis:
            print("Error(1) Index ({0}): {1}".format(errno, strerror))
            print("Error: input file name ??")
        return ""
    except:
        if debugis: print("Error(2):", sys.exc_info()[0])
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

    for t in soup('p', class_="indented"):
        # print("got indented")
        if t.has_attr('style'): 
            t['style'] += " margin-left: 2.0cm;"
        else:
            t['style']  = " margin-left: 2.0cm;"

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
pdd = re.compile(r'p style="padding-left: 2cm;"')

prerepl = '<p style="text-align:right;color: #464;line-height: 9 pt;font-family:Arial Narrow; font-size: xx-small;margin: 0; padding: 0;margin-left: -1.0 in">-- Firma'

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
        if debugis and log_enabled: logger.debug("DOCX Error loading: %s %s" % (filename,str(e)))
        return ""
    if not newdoc:
        if debugis: raise UnoException("The document could not be opened.")
        if log_enabled: logger.error("newdoc for DOCX failed")
    else:
        if debugis and log_enabled: logger.debug("newdoc for DOCX ok")
    return newdoc

def junta_pdf(files,pdfOfile):
    tname = pdfOfile.replace(".pdf",".txt")
    # merge de los PDFs
    try:
        f = open(tname,"wt")
        cmd = ["/usr/bin/pdftk",] + files + ["cat","output",pdfOfile]
        if debugis: print(cmd)
        oproc = subprocess.Popen(cmd,
                                 stdout=subprocess.PIPE,
                                 stderr=subprocess.PIPE,
                                 env={'PATH': '/usr/bin:/bin'})
        (stdoutdata, stderrdata) = oproc.communicate()
    except Exception as e:
        f.write("Error (e):", str(e))
        f.write("\n\nstdout:\n" + stdoutdata.decode())
        f.write("\n\nstderr:\n" + stderrdata.decode())
        if debugis: print("Error pdf:",tname)
        return "Error al unir pdfs"
    toproc = str(type(oproc))
    f.write("type:\n"     + toproc + "\n")
    # if stderrdata or (oproc and toproc=="<class 'subprocess.Popen'>") and oproc.wait() != 0:
    if oproc.wait() != 0 or stderrdata:
        sname = tname
        f.write("\n\nstdout:\n" + stdoutdata.decode())
        f.write("\n\nstderr:\n" + stderrdata.decode())
        f.close()
        return "Error 17 al unir pdfs", tname
    else:
        sname = tname.replace('.txt','.pdf')
        f.close()
        os.remove(tname)
    del oproc
    f = re.sub('^.*/temporales','/temporales',pdfOfile)
    if debugis and log_enabled: logger.debug("junta_pdf OK %s" % f)
    return "OK " + f


cUrl = "file:///var/www/scripts/firmas/tsjdf_plantilla20160211.ott"
outputfile = "resoluciones.pdf"
retVal = 0

def main():
    opts, args = getopt.getopt(sys.argv[1:], "hco:", ["help", "connection-string=", "outfile" ])
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
        logger.info("Got params %s", ' '.join(sys.argv[1:]))
    # evitar que crezca la cola de impresión
    x=0
    for p in psutil.process_iter():
        if p.name == 'python3':
            x += 1
            if False and log_enabled: logger.debug("pid (%d) %s" % (p.pid,p.name))
    if x > 20:
        if log_enabled:
            logger.error("Too many processes running")
            logger.debug("Session End")
        if debugis: print("No es posible producir PDF, carga excesiva en el sistema")
        sys.exit(0)
                                                                                                    
    done_impresos       = {}
    done_impresos_order = []
    using_windows       = False
    for pathname in args:
        if isfile(pathname):
            # check cache
            if pathname.endswith(".doc"):
                expected_filename = pathname.replace(".doc",".pdf")
            elif pathname.endswith('docx'):
                expected_filename = pathname.replace(".docx",".pdf")
            else:
                expected_filename = ""
            if "/firmados/" in expected_filename:
                expected_filename = expected_filename.replace(".pdf","2.pdf")
            found_in_cache = 0
            if expected_filename:
                if isfile(expected_filename):
                    if os.stat(expected_filename).st_mtime > os.stat(pathname).st_mtime:
                        found_in_cache = 1
                if not found_in_cache:
                    (mpath,mfile) = os.path.split(expected_filename)
                    gotfile = os.path.join(FILESBASE,mfile)
                    if isfile(gotfile):
                        if os.stat(gotfile).st_mtime > os.stat(pathname).st_mtime:
                            shutil.move(gotfile, expected_filename)
                            found_in_cache = 1

            if found_in_cache:
                # take it from cache
                done_impresos[pathname] = "OK " + expected_filename
                if log_enabled: logger.debug("from cache: %s" % expected_filename)
            else:
                if USE_WINDOWS and (pathname.endswith('doc') or pathname.endswith('docx')):
                    using_windows = True
                    send_to_win_queue(pathname)
                else:
                    done_impresos[pathname] = imprime_uno(pathname)
                    # copy to cache
                    if expected_filename and done_impresos[pathname].startswith("OK "):
                        try:
                            shutil.copy(done_impresos[pathname][3:], expected_filename)
                            if log_enabled: logger.debug("into cache: %s" % expected_filename)
                        except:
                            if log_enabled: logger.warn("failed cache: %s" % done_impresos[pathname])

            # print("Impreso: %s -- %s" % (pathname, done_impresos[pathname]))
            done_impresos_order.append(pathname)
        else:
            if log_enabled: logger.error("IOException: 3 (not a file) %s", pathname)
            if debugis: print("Error: Problemas para localizar el archivo")
    cuantos = len(done_impresos_order)
    if using_windows:
        max_wait = 60 + cuantos * 18
        if max_wait > 900:
            max_wait = 900
        while max_wait > 0 and len(done_impresos) < cuantos:
            max_wait -= 1
            for pathname in done_impresos_order:
                if "OK " + pathname in done_impresos:
                    pass
                else:
                    # check windows return dir
                    if pathname.endswith(".doc"):
                        expected_filename = pathname.replace(".doc",".pdf")
                    elif pathname.endswith('docx'):
                        expected_filename = pathname.replace(".docx",".pdf")
                    else:
                        continue

                    (mpath,mfile) = os.path.split(expected_filename)
                    gotfile = os.path.join(FILESBASE,mfile)
                    #print("looking for: %s for %s" % (gotfile,expected_filename))
                    if isfile(gotfile):
                        shutil.move(gotfile, expected_filename)
                        if log_enabled: logger.info("Got: " + mfile)

                        if "/firmados/" in pathname:
                            try:
                                if log_enabled: logger.info("A firmar arhivo: %s" % pathname)
                                destFile = expected_filename
                                try:
                                    destFile = firma_pdf(pathname, expected_filename)
                                    if destFile.startswith("/"):
                                        rv = "OK %s" % destFile
                                    else:
                                        rv = destFile
                                except Exception as e:
                                    rv = "Error firmando (%s) %s,%s" % (str(e),i,destFile.replace('file://',''))
                                    if log_enabled: logger.error("Error firmando (%s) %s,%s" % (str(e), i,destFile.replace('file://','')))
                                if log_enabled: logger.info("Firmado: %s" % destFile)
                            except Exception as e:
                                rv = "Error firmando: %s -- %s" % (destFile.replace('file://',''),str(e))
                        else:
                            rv = "OK " + expected_filename
                        done_impresos[pathname] = rv
            if len(done_impresos) < cuantos: sleep(0.3)
                    
    # print("cuantos",cuantos,len(done_impresos_order),done_impresos_order)
    r = "Error: No se produjo PDF"
    if cuantos == 1:
        for x in done_impresos_order:
            if x in done_impresos and "/files/" in done_impresos[x]:
                mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales")
                final_name = mytdir + "/resoluciones.pdf"
                try:
                    shutil.copy(done_impresos[x][3:], final_name )
                    if log_enabled: logger.debug("copied: %s to %s" % (done_impresos[x][3:], final_name ))
                except Exception as e:
                    if log_enabled: logger.warn("failed copy: %s" % str(e))
                    pass
                r = "OK " + re.sub('^.*/temporales','/temporales',final_name)
            # else:
            #     r = "OK " + re.sub('^.*/temporales','/temporales',done_impresos[x])
            if log_enabled: logger.info("print c=1 %s" % r)
        print( r )
    elif cuantos > 1:
        mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales")
        oPDF = os.path.join(mytdir,"unidos.pdf")
        errores = ""
        thispdf = []
        for x in done_impresos_order:
            if x in done_impresos and done_impresos[x].startswith("OK "):
                thispdf.append( done_impresos[x][3:] )
        if log_enabled: logger.info("merging: %s in %s" % ("+".join(thispdf), oPDF))
        junta = junta_pdf( thispdf, oPDF )
        if log_enabled: logger.info("junta_pdf got: %s" % junta)        
        junta = junta.replace('file:///var/lib/lxc/desasicor/rootfs','')
        junta = junta.replace('/var/lib/lxc/desasicor/rootfs','')
        if log_enabled: logger.info("print %s" % str(junta))
        print(junta)
        if log_enabled: logger.debug("merged: %s" % oPDF)
    else:                      
        if log_enabled: logger.info("print Error: Ningún archivo")
        print("Error: Ningún archivo")
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
        logger.debug("Session end. %.4f secs. %.4f docs/sec" % (elapsed,efic))
    sys.exit(0)


def imprime_uno(i):
    try:
        mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales")
        url = "uno:socket,host=localhost,port="+str(portnum)+";urp;StarOffice.ComponentContext"

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
            logger.error("OpenOffice process not found or not listening (" + str(e) + ")")
        sys.exit(1)
    except IllegalArgumentException as e:
        if log_enabled:
            logger.error("The url is invalid IllegalArgumentException (" + str(e) + ")")
        sys.exit(1)
    except RuntimeException as e:
        if log_enabled:
            logger.error("An unknown error occured: " + str(e))
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
        if log_enabled: logger.error(str(e))
    except RuntimeException as e:
        if log_enabled: logger.error(str(e))
    except NoConnectException as e:
        if log_enabled: logger.error(str(e))
    except IllegalArgumentException as e:
        if log_enabled: logger.error(str(e))
    except IOException as e:
        if log_enabled: logger.error(str(e))
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

    # print("Doing:",i)
    if i.endswith('doc') or i.endswith('docx'):
        newdoc = read_docx(desktop, i)
    else:
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
                    m = re.search(r'/([0-9]+)\.',i)
                    if m:
                        id_acuerdo = m.group(1)
                        instance,expediente,acuerdo,fecha_pub = get_acuerdo(id_acuerdo)
                        missing_instance = 0
                    # m = re_instancia.search(l)
                    # if m:
                    #     instance = m.group(1)
                    #     missing_instance = 0
                except Exception as e:
                    if log_enabled:
                        logger.error("Error re_instancia (" + str(e) + ")")
                    sys.exit(4)

        if log_enabled: logger.debug("scanning %d lines from %s for images" % (len(rLines), i))

        for l in rLines:
            l = rh5.sub(r'\g<Cin>6',l)
            l = rh4.sub(r'\g<Cua>5',l)
            l = rh3.sub(r'\g<Tre>4',l)
            l = rh2.sub(r'\g<Dos>3',l)
            l = rh1.sub(r'\g<Uno>2',l)
            l = pdd.sub(r'p class="indented" style="margin-left: 2cm;"',l)

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
                        logger.error("Error creando imagen %s (" % img_name + str(e) + ")")
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
            if log_enabled: logger.error("Error Writing Temporary (" + str(e) + ")")
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
                try:
                    #text.insertControlCharacter( cursor, PARAGRAPH_BREAK, 0 )
                    cursor.setPropertyValue("PageDescName", "Default")
                    # cursor.PageDescName = "Default"
                except Exception as e:
                    if log_enabled:
                        logger.error("Cursor PageDescName error: %s at %s" % (str(e),fileUrl))
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
                if log_enabled: logger.error("Error IO (" + str(e) + ")")
            except IllegalArgumentException as e:
                if log_enabled: logger.error("The url is invalid (" + str(e) + ")")
            except Exception as e:
                if log_enabled: logger.error("Undef error (" + str(e) + ")")

        except IOException as e:
            if log_enabled: logger.error("Error IO 2: " + str(e))
            sys.exit()
        except UnoException as e:
            if log_enabled: logger.error("Error 2("+repr(e.__class__)+") during conversion:" + str(e))
            sys.exit()
        except Exception as e:
            if log_enabled: logger.error("Undef error 2(" + str(e) + ")")
            sys.exit()

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
        newdoc.dispose()
        # disconnect from UNO
    except IOException as e:
        if log_enabled:
            logger.error("Error IO (" + str(e) + ")")
            logger.error("failed: %s" % destFile) #.replace('file:///var/www/public_html',''))
    except IllegalArgumentException as e:
        if log_enabled:
            logger.error("The url is invalid (" + str(e) + ")")
            logger.error("failed: %s" % destFile) #.replace('file:///var/www/public_html',''))
    except Exception as e:
        print("Unexpected error:", sys.exc_info()[0])
        if log_enabled:
            logger.error("Undef error (" + str(e) + ")")
            logger.error("failed: %s" % destFile) #.replace('file:///var/www/public_html',''))
    # disconnect from soffice
    logger.info("Disconnecting.")
    try:
        del desktop
        del smgr
        del ctx
        del resolver
        del ctxLocal
    except Exception as e:
        logger.error("Disconnecting:", str(e))
        pass
    if log_enabled: logger.debug("so far: %s" % destFile)
    # f = destFile.replace('file:///var/www/public_html','')
    # f = f.replace('file:///var/lib/lxc/desasicor/rootfs','')
    # f = f.replace('/var/lib/lxc/desasicor/rootfs','')
    # f = f.replace('/var/lib/lxc/desasicor/rootfs/var/www/public_html','')
    f = re.sub('^.*/temporales','/temporales',destFile)

    rv = "OK %s" % f 
    # tiene firma ?
    if "/firmados/" in i:
        try:
            if log_enabled: logger.info("A firmar arhivo: %s" % i)
            try:
                destFile = firma_pdf(i, destFile.replace('file://',''))
                if destFile.startswith("/"):
                    rv = "OK %s" % destFile
                else:
                    rv = destFile
            except Exception as e:
                rv = "Error firmando (%s) %s,%s" % (str(e),i,destFile.replace('file://',''))
                if log_enabled: logger.error("Error firmando (%s) %s,%s" % (str(e), i,destFile.replace('file://','')))
            if log_enabled: logger.info("Firmado: %s" % destFile)
        except Exception as e:
            rv = "Error firmando: %s -- %s" % (destFile.replace('file://',''),str(e))

    if delete_tmp_files:
        for img_name in img_list:
            os.remove( os.path.join(mytdir, img_name))
            if log_enabled: logger.debug("removing: %s" % img_name)

    if log_enabled:
        logger.info("imprimir_uno: %s" % rv)

    return rv

main()

