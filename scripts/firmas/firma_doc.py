#!/usr/bin/env python3
# -*- coding: utf-8 -*-

# --- Firma ---
# el doc está sellado? (text)
  # SI: devuelve "Este acuerdo ya está firmado y sellado"

# existe el html en firmado?
  # NO: convert to firmado/*.html (lo)

# Procede con firmado del html (text)

# Tiene el html ambas firmas y sello ?
  # SI: extrae firma(s) del html (text)
  #     prepara <style> y agrega el texto de las firmas y sello al final de docx (lo)


delete_tmp_files = False # True # 
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

def process_fields(text):
    return text

def tcursorfind(txt, search_text):
    pos = 0
    srch = txt.createSearchDescriptor()
    srch.SearchString = search_text
    srch.SearchCaseSensitive = True
    srch.SearchWords = True
    xFound = txt.findFirst( srch )
    if xFound is not None:
        pos =  xFound.getEnd()
    else:
        pos = 0
    return pos

def get_newdoc(fname):
    cUrl = "file://" + fname
    try:
        url = "uno:socket,port=2002;urp;StarOffice.ComponentContext"
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

    inProps = PropertyValue( "Hidden",       0, True,                0 ),
    if log_enabled:
        logger.debug("ooo Conf OK")

    try:
        newdoc = desktop.loadComponentFromURL( cUrl, "_blank", 0,  inProps )
    except Exception as e:
        if log_enabled: logger.error("Could not create a new doc: " + str(e))
        sys.exit(1)

    if log_enabled:
        logger.debug("newdoc  OK")
    return newdoc

def tcursopos(txt, search_text):
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



def convert2html(namedoc):
    try:
        (r,extdestino) = os.path.splitext(namedoc)
        destino = r + ".html"
        (destPath,destN) = os.path.split(namedoc)
        newdoc  = get_newdoc(namedoc)
        cwd = systemPathToFileUrl( destPath )
        destFile = absolutize( cwd, systemPathToFileUrl(destino) )
        if debugis: print("destFile:",destFile)
        oProps  = (
            PropertyValue("CharacterSet", 0, 'utf-8',             0 ),
            PropertyValue("Pages",        0, 'All',               0 ),
            PropertyValue("FilterName",   0, 'HTML (StarWriter)', 0 ),
        )
        newdoc.storeToURL(destFile,oProps)
        newdoc.dispose()
        newdoc.close(True)
    except Exception as e:
        print("convert2html failed:", str(e))
    if log_enabled: logger.debug("Done building document: %s" % destino)
    return destino

def doc_esta_sellado(namedoc):
    try:
        newdoc = get_newdoc(namedoc)
        text   = newdoc.Text
        cursor = text.createTextCursor()
        res    = False
        tc     = tcursorfind(newdoc,"Firma electrónica SICOR/TSJCDMX")
        if not tc:
            tc = tcursorfind(newdoc,"Firma electrónica SICOR/TSJDF")
        if tc:
            res = True
        # cursor.gotoRange(tc,False)
        newdoc.dispose()
        newdoc.close(True)
    except Exception as e:
        print("doc_esta_sellado failed:", str(e))
    return res


def doc_agrega_sign(namedoc,linea,sign):
    (r,extdestino) = os.path.splitext(namedoc)
    destino = r + "F" + extdestino
    try:
        newdoc  = get_newdoc(namedoc)
        text   = newdoc.Text
        cursor = text.createTextCursor()

        cursor.gotoEnd(False)
        cursor.ParaStyleName = "Text Body"
        # hard-enter
        text.insertControlCharacter( cursor, PARAGRAPH_BREAK, 0 )
        # shift-enter: text.insertString( cursor, "\n", 0)
        text.insertString( cursor, "------ Firma electrónica SICOR/TSJCDMX ------", 0)
        text.insertControlCharacter( cursor, PARAGRAPH_BREAK, 0 )
        # shift-enter: text.insertString( cursor, "\n", 0)
        text.insertString( cursor, linea, 0)
        text.insertControlCharacter( cursor, PARAGRAPH_BREAK, 0 )
        text.insertString( cursor, sign, 0)
        # docx "Office Open XML Text"
        (r,extdestino) = os.path.splitext(destino)

    except Exception as e:
        if log_enabled: logger.error("Agrega Sign: " + str(e))
        sys.exit(1)

    if debugis: print("So far so good!")
    try:
        if 1:
            dtype = {'.doc':'MS Word 97',
                     '.docx':'Office Open XML Text',
                     '.fodt':'OpenDocument Text Flat XML',
                     '.odt':'writer8'}[extdestino]
            if debugis: print("dtype:",extdestino,dtype)
            doc_type = PropertyValue("FilterName",   0, dtype, 0)
            oProps  = (
                PropertyValue("CharacterSet", 0, 'utf-8',             0 ),
                PropertyValue("Pages",        0, 'All',               0 ),
                doc_type
            )
            (destPath,destN) = os.path.split(destino)
            cwd = systemPathToFileUrl( destPath )
            destFile = absolutize( cwd, systemPathToFileUrl(destino) )
            if debugis: print("destFile:", destFile)
            newdoc.storeToURL( destFile, oProps)
        else:
            newdoc.save()
        if log_enabled: logger.debug("Done building document: %s" % destino)
        if debugis: print("   %s" % (destino.replace('file:///var/www/public_html',''),))
    except Exception as e:
        if debugis: print("Unexpected error:", sys.exc_info()[0])
        if log_enabled:
            logger.error("Undef error (" + str(e) + ")")
            logger.error("failed: %s" % namedoc)
    newdoc.dispose()
    newdoc.close(True)
    os.rename(destino, namedoc)
