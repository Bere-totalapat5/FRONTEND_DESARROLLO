#!/usr/bin/python
# -*- coding: utf-8 -*-

import gpgme,sys,re,os
import logging

os.environ['HOME'] = '/var/www/scripts/firmas' # /home/www-data'
os.environ['TMP'] =  '/tmp'
os.environ['TEMP'] = '/tmp'
os.environ['USER'] = 'www-data'
os.environ['USERNAME'] = 'www-data'
os.environ['LOGNAME'] = 'www-data'

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


import io
output = io.StringIO()

ctx = gpgme.Context()
ctx.armor = True
key = ctx.get_key('D9617993')
ctx.signers = [key]

f = open(sys.argv[1],"rb")
all_html = "".join(f.readlines())
m = re.search(r'(<body.*</body>)',all_html,re.DOTALL) #  re.IGNORECASE
if m:
    inicio = all_html[:m.start()]
    cierre = all_html[m.end():]
    matched = m.group(0)
else:
    inicio = '<html><head>\n<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">\n</head>\n'
    cierre = '</html>'
    matched = '<body>' + all_html + '</body>'

matched = re.sub(r'<body','\n<div', matched, re.IGNORECASE)
matched = re.sub(r'</body>','</div>\n', matched, re.IGNORECASE)

# E-sig start
input = io.StringIO(matched)
new_sigs = ctx.sign(input, output, gpgme.SIG_MODE_DETACH)
signature = output.getvalue()
output.close()
sig = re.split(r'\n',signature)
# E-sig end
signature = "\n".join(sig[2:6])

opt = open(sys.argv[2],"wb")
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
print("OK")

if log_enabled: #debug(), info(), warning(), error() and critical()
    logstring = "OK"
    logger.debug(logstring)

sys.exit(0)

