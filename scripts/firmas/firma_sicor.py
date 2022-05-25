#!/usr/bin/python3
# -*- coding: utf-8 -*-

import gpgme,sys,re,os
import logging
from firma_doc import convert2html, doc_esta_sellado, doc_agrega_sign
from shutil import copyfile

try:
    from BytesIO import BytesIO
except ImportError:
    from io import BytesIO

os.environ['HOME']     = '/var/www/scripts/firmas' # /home/www-data'
#os.environ['HOME']     = '/mnt/ProjectsR1/home/mdragon/tsjdf/boletin/alestrasicor/firmas_acuerdos_docx'
os.environ['TMP']      = '/tmp'
os.environ['TEMP']     = '/tmp'
# os.environ['USER']     = 'www-data'
# os.environ['USERNAME'] = 'www-data'
# os.environ['LOGNAME']  = 'www-data'

debugis = False
log_enabled = True

if log_enabled: #debug(), info(), warning(), error() and critical()
    logger = logging.getLogger("firmas")
    hdlr = logging.FileHandler("/tmp/firmas.log")
    formatter = logging.Formatter("%(asctime)s [%(name)s] %(levelname)s - %(message)s")
    hdlr.setFormatter(formatter)
    logger.addHandler(hdlr)
    logger.setLevel(logging.DEBUG)
    logstring = "Init: " + " :: ".join(sys.argv[1:])
    logger.debug(logstring)

def is_doc(fname):
    if fname.endswith(".doc")  or \
       fname.endswith(".docx") or \
       fname.endswith(".odt")  or \
       fname.endswith(".fodt"):
        return True
    else:
        return False

def get_contents(fname):
    if is_doc(fname):
        if debugis: print("trying convert2html")
        fname = convert2html(fname)
        if debugis: print("finished convert2html")
    # HTML work
    f = open(fname,"rt")
    all_html = f.read()
    m = re.search(r'(<body.*</body>)',all_html,re.DOTALL) #  re.IGNORECASE
    if m:
        inicio  = all_html[:m.start()]
        cierre  = all_html[m.end():]
        matched = m.group(0)
    else:
        inicio  = '<html><head>\n<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">\n</head>\n'
        cierre  = '</html>'
        matched = '<body>' + all_html + '</body>'

    matched   = re.sub(r'<body','\n<div', matched, re.IGNORECASE)
    matched   = re.sub(r'</body>','</div>\n', matched, re.IGNORECASE)
    return(inicio,cierre,matched)

(inicio,cierre,matched) = get_contents(sys.argv[1])


goutput      = BytesIO()
ginput       = BytesIO(bytearray(matched,"utf-8"))
# E-sig start
try:
    ctx         = gpgme.Context()
    ctx.armor   = True
    if debugis: logger.debug("armor OK")
    key         = ctx.get_key('D9617993')
    #ctx.signers = tuple(i for i in ctx.keylist() if i.can_sign)
    if debugis: logger.debug("signers/key OK")
    new_sigs    = ctx.sign(ginput, goutput, gpgme.SIG_MODE_DETACH)
    if debugis: logger.debug("sign OK")
    signature   = goutput.getvalue().decode('utf-8')
    if debugis: logger.debug("signature %s" % signature)
    goutput.close()
    ginput.close()
    sig         = re.split(r'\n',signature)
    signature   = "\n".join(sig[2:6])
    logger.info("GPG signature OK: %s" % signature)
except Exception as e:
    logstring = "GPG Error: %s" % str(e)
    if debugis: print(logstring)
    logger.debug(logstring)
    signature = "iF4EABEIAAYFAlVwzkAACgkQWymFedlheZM0VwD/f+Y57x5WZzUwo/h8DkRJ8Pbt\nZ2oWxsozZaa1DCpjxQABAMKwZaTGLmRtcfUk7j7WW3n2Cth5OAwAupTrY6TRmCB3\n=1On4"""
# E-sig end

destino = sys.argv[2]
if is_doc(destino):
    (r,e) = os.path.splitext(destino)
    destino = r + ".html"

opt = open(destino,"wt")
opt.write(inicio)
linea = ''
if len(sys.argv) > 3:
    tabla = sys.argv[3]
    # print "Tabla", tabla
    lineas = tabla.split(';')
    linea = ''
    for l in lineas:
        if l:
            (k,v) = l.split(':',2)
            linea += "%21s: %s\n" % (k,v)
opt.write('<body><pre>----------- Firma electrónica SICOR/TSJCDMX Inicio -----------<pksc7_siginit />\n' +
          linea + '</pre><br/>\n' +
          matched + 
          '<pksc7_sigend />\n<br/><pre>----------- Firma electrónica SICOR/TSJCDMX Fin -----------\n')
opt.write( signature )
opt.write( '\n</pre>\n</body>' + cierre)
opt.close()

if is_doc(sys.argv[2]):
    if debugis: print("doc_agrega_sign Inicio")
    # copia el origen al destino
    if sys.argv[1] != sys.argv[2]:
        copyfile(sys.argv[1],sys.argv[2])
    # agrega "signature" al doc destino
    doc_agrega_sign(sys.argv[2], linea, signature)
    if debugis: print("doc_agrega_sign Fin")

print("OK")

if log_enabled: #debug(), info(), warning(), error() and critical()
    logstring = "OK"
    logger.debug(logstring)

sys.exit(0)

