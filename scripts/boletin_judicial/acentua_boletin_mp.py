#!/usr/bin/env python3
# -*- coding: utf-8 -*-

cwd='/var/www/scripts/boletin_judicial/'
import os
os.chdir(cwd)

#: ToDo corregir <ruta> ???
DICCIONARIO_ACENTOS="nombres_acento.txt"

import sys,re
from multiprocessing import Process, Queue

eol    = re.compile(r"[\n\r]*$")
blanks = re.compile(r"(\s)\1+")

transtable = {
ord("á"):"a",
ord("à"):"a",
ord("â"):"a",
ord("ä"):"a",
ord("é"):"e",
ord("è"):"e",
ord("ê"):"e",
ord("ë"):"e",
ord("í"):"i",
ord("ì"):"i",
ord("î"):"i",
ord("ï"):"i",
ord("ó"):"o",
ord("ò"):"o",
ord("ô"):"o",
ord("ö"):"o",
ord("ú"):"u",
ord("ù"):"u",
ord("û"):"u",
ord("ü"):"u",
ord("ñ"):"ñ",
ord("Á"):"a",
ord("À"):"a",
ord("Â"):"a",
ord("Ä"):"a",
ord("É"):"e",
ord("È"):"e",
ord("Ê"):"e",
ord("Ë"):"e",
ord("Í"):"i",
ord("Ì"):"i",
ord("Î"):"i",
ord("Ï"):"i",
ord("Ó"):"o",
ord("Ò"):"o",
ord("Ô"):"o",
ord("Ö"):"o",
ord("Ú"):"u",
ord("Ù"):"u",
ord("Û"):"u",
ord("Ü"):"u",
ord("Ñ"):"ñ",
}
#
# -- generar diccionario de acentuación
simple_phrases = (
	'"A"',
	'"B"',
	'"C"',
	'"D"',
	'"E"',
	'"F"',
	)

common_phrases = (
    'a bienes',
    'a costas',
    'de lo Civil',
    'De la Barrera',
    'De la Concha',
    'De la Cruz',
    'De la Fuente',
    'De la Garza',
    'De la Lama',
    'De la Madrid',
    'De la Orta',
    'De la Parra',
    'De la Peña',
    'De la Plata',
    'De la Rosa',
    'De la Teja',
    'De la Torre',
    'De la Vega',
    'De las Eras',
    'De las Heras',
    'Del Hierro',
    'Del Llano',
    'Del Moral',
    'Del Regil',
    'Del Valle',
    'Ord. Civ.',
    'que opera bajo',
    'a bienes',
    'a la',
    'a las',
    'a lo',
    'a los',
    'Civil',
    'Familiar',
    'de Proceso Oral',
    'Lic\. ',
    'de Acuerdos',
    'La Secretaria de Acuerdos',
    'surten notificaciones por Boletín al demandado',
    'promovido por',
    'también conocida como',
    'también conocido como',
    'se ponen a disposición oficios y exhortos',
    'solicita copias certificadas',
    'como fiduciaria',
    'como fiduciario',
    'actuando como',
    'quién tambien se hace llamar',
    'quién también utiliza el nombre de',
    'causahabiente de',
    'un auto no publicado del día',
    'de lo Civil',
    'de lo Familiar',
    'en Cuad',
    'en Expdllo',
    'en Cuadernillo',
    )

def convupcase(w):
    return w.translate(transtable).upper()

# re_invalid= re.compile(r'\[\]\|\<\>')
re_sadecv = re.compile(r'S\s*\.? ?A\.? DE C\s*\.? ?V\.?',re.I)
re_snc    = re.compile(r'S\s*\.? ?N\.? ?C\s*\.?',re.I)
re_srlcv  = re.compile(r'S\s*\.? ?DE R\s*\.? ?L\s*\.? DE C\s*\.? ?V\.?',re.I)
re_sdrl   = re.compile(r'S\s*\.? ?DE R\s*\.? ?L\s*\.?',re.I)
re_srl    = re.compile(r'S\s*\.? ?R\s*\.? ?L\s*\.?',re.I)
re_sa     = re.compile(r'\sS\s*\.? ?A\s*\.',re.I)
re_sc     = re.compile(r'\sS\s*\.? ?C\s*\.',re.I)
re_ac     = re.compile(r'\sA\s*\.? ?C\s*\.',re.I)
re_vs     = re.compile(r'\svs\.\W*(?P<w>\w)', re.I)
re_roman  = re.compile(r'^[CILMVX]+$')
#re_comma  = re.compile(r'(?P<punct>[\,;:])+[\s]*')
re_comma  = re.compile(r'\s*([\,;:])+[\s]*[\,;:]*')
re_white  = re.compile(r'[\s]+')
re_dots   = re.compile(r'\s*[\.]+\s*[;:\.]*')
re_espec  = re.compile(r'^(?P<pre>[\W]*)(?P<w>[\w\d]+)(?P<sub>[\W]*)$')
#re_ddots  = re.compile(r'(?P<pre>[^\d\W])\.(?P<sub>[^\d\W])')
re_ddots  = re.compile(r'\.\.+')
re_cdots  = re.compile(r'\,\.+')
re_dotcom = re.compile(r' +,')
re_y_o    = re.compile(r'Y[/-]O',re.I)
re_voc    = re.compile(r'[aeiouáéíóú]',re.I)
re_primlet= re.compile(r'\>\s*(?P<w>\w)')
re_exped  = re.compile(r'\((?P<w>(expedientillo|amparo|cuaderno|cuadernillo))\)',re.I)
re_acdo   = re.compile(r'\bAcuerdo\.')
re_acdos  = re.compile(r'\bAcuerdos\.')
re_acdoc   = re.compile(r'\bAcdo\.\s+(?P<w>\w)')
re_acdosc  = re.compile(r'\bAcdos\.\s+(?P<w>\w)')
re_terce  = re.compile(r'\bTercería\,')
re_bslsh  = re.compile(r'\\')
re_tagstr = re.compile(r'<')
re_tagend = re.compile(r' <')
re_tagpnd = re.compile(r'<P> +')


def process_line_before(l):
    # m = re_comma.match(l)
    # while m:
    #     repl = m.group('punct')+ " "
    #     # print ("--",repl,"--")
    #     l = re_comma.sub(repl,l,1)
    #     m = re_comma.match(l)
    l = re_ddots.sub(". ",l)
    l = re_comma.sub(", ",l)
    l = re_dotcom.sub(",",l)
    l = re_tagstr.sub(" <",l)
    l = re_white.sub(" ",l)
    l = re_y_o.sub("y/o",l)
    return l

frases_comunes  = []
frases_comunesr = []
for f in simple_phrases:
    frases_comunesr.append(f)
    r = re.compile(f,re.I)
    frases_comunes.append(r)
for f in common_phrases:
    rr = re_bslsh.sub("",f)
    frases_comunesr.append(rr)
    f = r'\b' + f + r'\b'
    r = re.compile(f,re.I)
    frases_comunes.append(r)

def process_line_after(l):
    l = re_sadecv.sub("S.A. de C.V.",l)
    l = re_srlcv.sub("S. de R.L. de C.V.",l)
    l = re_sdrl.sub("S. de R.L.",l)
    l = re_srl.sub("S. de R.L.",l)
    l = re_snc.sub("S.N.C.",l)
    l = re_sa.sub(" S.A.",l)
    l = re_sc.sub(" S.C.",l)
    l = re_ac.sub(" A.C.",l)
    l = re_acdo.sub("Acdo.",l)
    l = re_acdos.sub("Acdos.",l)
    l = re_terce.sub("Tercería:",l)
    l = re_tagend.sub("<",l)
    l = re_tagpnd.sub("<P>",l)

    m = re_acdosc.search(l)
    if m:
        repl = "Acdos., "+ m.group('w').capitalize()
        # print ("--",repl,"--")
        l = re_acdosc.sub(repl,l)
    
    m = re_acdoc.search(l)
    if m:
        repl = "Acdo., "+ m.group('w').capitalize()
        # print ("--",repl,"--")
        l = re_acdoc.sub(repl,l)
    
    m = re_exped.search(l)
    if m:
        repl = '(' + m.group('w').lower() + ')'
        l = re_exped.sub(repl,l)
    m = re_primlet.search(l)
    if m:
        repl = ">" + m.group('w').capitalize()
        l = re_primlet.sub(repl,l)
    m = re_vs.search(l)
    if m:
        repl = " vs. "+ m.group('w').capitalize()
        # print ("--",repl,"--")
        l = re_vs.sub(repl,l)
    m = re_dots.search(l)
    j=0
    while m and j<6:
        j += 1
        #print ("dots:",m.span(0))
        l = re_dots.sub('. ',l)
        m = re_dots.search(l)
    l = re_cdots.sub(",",l)
    i=0
    for r in frases_comunes:
        j = 0
        m = r.search(l)
        while m and j<6:
            l = r.sub(frases_comunesr[i],l)
            if 0 and len(frases_comunesr[i]):
                print ("fc:",l)
                print ("FC:",frases_comunesr[i])
            j += 1
            m = r.search(l)
        i += 1
    l = re_dotcom.sub(",",l)
    return l

import fileinput

f = open(DICCIONARIO_ACENTOS,"r")
diccionario_acentos = {}
do_exit = 0
for line in f:
    uline = eol.sub("",line)
    culine = convupcase(uline)
    if culine in diccionario_acentos:
        print (uline)
        print (diccionario_acentos[culine])
        do_exit = 1
    diccionario_acentos[culine]=uline
if do_exit:
    sys.exit(0)
f.close()

def acentua(line):
    if '<meta charset="UTF-8">' in line:
        return line
    line = process_line_before(line)
    words = line.split()
    nwords = []
    for p in words:
        m = re_espec.match(p)
        if not m:
            # print ("--",p,"--") # 1415/2010 E.N.R. S.A.P.I. F/304557 y/oS.
            if p.upper() in ("Y/O","Y/OS","Y/OTRAS","Y/OTRO","Y/OTROS"):
                nwords.append(p.lower())
            else:
                nwords.append(p.upper())
            continue
        w   = m.group('w')
        pre = m.group('pre')
        sub = m.group('sub')
        P   = convupcase(w)

        if P in diccionario_acentos:
            nwords.append(diccionario_acentos[P])
        elif re_roman.match(P):
            nwords.append(P)
        else:
            if len(w) > 1:
                m = re_voc.search(w)
                if m:
                    nwords.append(w.capitalize())
                else:
                    nwords.append(w.upper())
            elif len(w) == 1:
                w = w.upper()
                if w in diccionario_acentos:
                    nwords.append(diccionario_acentos[w])
                else:
                    nwords.append(w)
            else:
                nwords.append("")
        if pre:
            nwords[-1] = pre + nwords[-1]
        if sub:
            nwords[-1] += sub
        #if 0 and (pre or sub): print ("::".join(m.groups()))
    line = " ".join(nwords)
    return process_line_after(line)

def mpacentua(q,lst):
    ret = [ acentua(l) for l in lst ]
    q.put( ret )

all_lines = []
rst_lines = []
dorest    = False
for line in fileinput.input():
    if "ZDRkZjU5ZTE0OTEKN" in line:
        dorest = True
        next
    if dorest:
        rst_lines.append(line)
    else:
        all_lines.append(line)

if 1:
    processes   = 8
    p           = [ x for x in range(processes) ]
    pq          = p
    splitat     = len(all_lines) / processes
    init        = 0
    # ---- start processes   ----

    for pn in range( processes ):
        q = Queue()
        end = int( (pn+1) * splitat )
        pc = Process(target=mpacentua, args=(q, all_lines[init:end]))
        p[ pn ] = pc
        p[ pn ].start()
        pq[ pn ] = q
        init = end
    # ---- end of processes ----
    for pn in range( processes ):
        res = pq[pn].get()
        print ("\n".join( res ))
else:
    print ("\n".join( [acentua(l) for l in all_lines ]))

print ("\n".join( rst_lines ))

sys.exit(0)
