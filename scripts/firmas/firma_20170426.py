#!/usr/bin/python3
# -*- coding: utf-8 -*-
import logging, sys, os
from shutil import copyfile

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

def touch(fname, times=None):
    with open(fname, 'a'):
        os.utime(fname, times)

        # copia el origen al destino
# if sys.argv[1] != sys.argv[2]:
try:
    if sys.argv[1] != sys.argv[2]:
        copyfile(sys.argv[1],sys.argv[2])
    if os.path.isfile(sys.argv[2]):
        touch(sys.argv[2])
    print("OK")
except Exception as e:
    print("Error firmando")
    logger.error("Error firmando %s a %s -- %s" % (sys.argv[1],sys.argv[2],str(e)))

if log_enabled: #debug(), info(), warning(), error() and critical()
    logger.debug("OK")

sys.exit(0)

