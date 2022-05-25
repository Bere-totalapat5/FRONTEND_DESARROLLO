#!/usr/bin/python
# -*- coding: utf-8 -*-

from __future__ import with_statement
import gpgme,sys,re,os
import logging
import filelock

os.environ['HOME'] = '/var/www/scripts/firmas' # /home/www-data'
os.environ['TMP'] =  '/tmp'
os.environ['TEMP'] = '/tmp'
os.environ['USER'] = 'www-data'
os.environ['USERNAME'] = 'www-data'
os.environ['LOGNAME'] = 'www-data'

debugis     = False
log_enabled = True
listo       = False

if log_enabled: #debug(), info(), warning(), error() and critical()
    logger = logging.getLogger("firmas")
    hdlr = logging.FileHandler("/tmp/firmas.log")
    formatter = logging.Formatter("%(asctime)s [%(process)d] %(levelname)s - %(message)s")
    hdlr.setFormatter(formatter)
    logger.addHandler(hdlr)
    logger.setLevel(logging.DEBUG)
    logger.debug("Init: %s" % " :: ".join(sys.argv[1:]))

import cStringIO
output = cStringIO.StringIO()

ctx = gpgme.Context()
ctx.armor = True
key = ctx.get_key('D9617993')
ctx.signers = [key]

lock1 = filelock.FileLock(sys.argv[2] +",lck")
try:
    with lock1.acquire(timeout = 2.0, poll_intervall=0.1):
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
        input = cStringIO.StringIO(matched)
        new_sigs = ctx.sign(input, output, gpgme.SIG_MODE_DETACH)
        signature = output.getvalue()
        output.close()
        sig = re.split(r'\n',signature)
        # E-sig end
        signature = "\n".join(sig[2:6])
        if log_enabled:
            logger.debug("Firma obtenida %s" % "".join(sig[2:6]))
        try:
            ofile = open(sys.argv[2],"wb")
        except Exception as e:
            logger.error("Error (%s) en %s" % (str(e),sys.argv[2]))
        else:
            with ofile:
                #print inicio
                ofile.write(inicio)
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
                ofile.write('<body><pre>----------- Firma electrónica SICOR/TSJDF Inicio -----------<pksc7_siginit />\n' +
                          linea + '</pre><br/>\n' +
                          matched + 
                          '<pksc7_sigend />\n<br/><pre>----------- Firma electrónica SICOR/TSJDF Fin -----------\n')
                #print matched
                #print signature
                ofile.write( signature )
                ofile.write( '\n</pre>\n</body>' + cierre)
                #print cierre
                ofile.close()
            try:
                data = os.lstat(sys.argv[2])
                listo = True
                if 0:
                    logger.debug("STAT para %s: %s" % (sys.argv[2],":".join(map(str,data))))
                    data = os.lstat(sys.argv[2] +",lck")
                    logger.debug("STAT para %s: %s" % (sys.argv[2] + ",lck",":".join(map(str,data))))
            except Exception as e:
                logger.error("Error (%s) en %s" % (str(e),sys.argv[2]))

            if log_enabled: #debug(), info(), warning(), error() and critical()
                logger.debug("OK")
    if listo:
        print "OK"
    else:
        logger.error("Error en firmado")
        print "Error en firmado, vuelva a intentar."

except filelock.Timeout:
    print "Archivo ocupado, vuelva a intentar."

sys.exit(0)
