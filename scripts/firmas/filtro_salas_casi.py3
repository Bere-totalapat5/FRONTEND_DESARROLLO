#!/usr/bin/python3
# -*- coding: utf-8 -*-

import sys, os, re, base64, uuid
import logging, time, urllib
import email, quopri, subprocess
from tempfile import mkdtemp
from bs4 import BeautifulSoup, Comment

verbose = False
debugis = False

os.environ['TMP'] =  '/tmp'
os.environ['TEMP'] = '/tmp'
os.environ['HOME'] = '/var/www'
os.environ['USER'] = 'www-data'
os.environ['USERNAME'] = 'www-data'
os.environ['LOGNAME'] = 'www-data'
os.environ['LANG'] = 'en_US.UTF-8'

meses=('','Ene','Feb','Mzo','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic')

def filtro_salida( DATA ):
    l = ""
    soup = BeautifulSoup(DATA) # open(file_name))
    del DATA
    if soup is None:
        return ""
    s = soup.find('body')
    if s is None:
        return ""
    if 0:
        nospc = re.compile(r'\s')
        tag_key = set()
        for s in soup.find_all(True):
            for k in s.attrs:
                tag_key.add(s.name+":"+k)
            if 'style' in s.attrs:
                sty = nospc.sub('',s['style'])
                r = sty.split(';')
                for k in r:
                    k=k.split(':')[0]
                    tag_key.add(s.name+":style:"+k)
        if verbose: print("\n".join( tag_key ))
        if verbose: print("\n" * 3)
    for h in soup.find_all('head'):
        for s in h:
            try:
                if s.name == 'title':
                    s.extract()
            except:
                pass
    if soup.body.has_attr('style'):
        del soup.body['style']
    [ s.extract() for s in soup('script') ]
    [ s.extract() for s in soup('style')  ]
    [ s.extract() for s in soup('link')   ]
    for s in soup('meta'):
        if s.has_attr('charset'):
            pass
        elif s.has_attr('content') and 'charset' in s['content']:
            pass
        else:
            s.extract()
    font_attributes = {}
    for s in soup('font'):
        s.unwrap()
    for s in soup('o:p'):
        s.name = 'p'
    for s in soup(text=lambda text: isinstance(text, Comment)):
        s.extract()
    
    rst00 = re.compile(r'mso-bidi-')
    rst01 = re.compile(r'font-weight:\s*normal;?\s*')
    rst02 = re.compile(r'font-style:\s*normal;?\s*')
    rst03 = re.compile(r'font-size:\s*[0-9][^;"]*;?\s*')
    rst04 = re.compile(r'line-height[^;"]*;?\s*')
    rst05 = re.compile(r'\S*font-face:[^;"]*;?\s*')
    rst06 = re.compile(r'margin-left:\s*auto;\s*margin-right:\s*auto;?\s?')
    rst07 = re.compile(r'\S*font-family:[^;"]*;?\s*')

    if 1: #for find_this_tag in ('p','span','b','i'):
        for s in soup.find_all(True):
            for a in ('style','lang'):
                if s.has_attr(a):
                    del s[a]
                    next
            if 0:
                sty = s['style']
                if debugis: print(find_this_tag + "::\n---" + sty)
                #if sty.find("font-family") >= 0:
                sty = rst00.sub('',sty)
                sty = rst01.sub('',sty)
                sty = rst02.sub('',sty)
                sty = rst03.sub('',sty)
                sty = rst04.sub('',sty)
                sty = rst05.sub('',sty)
                sty = rst06.sub('align: center; ',sty)
                sty = rst07.sub('',sty)
                if sty:
                    s['style'] = sty
                else:
                    del s['style']
                if debugis: print(s['style'], end="\n\n\n")

    if 1:
        nospc = re.compile(r'\s')
        tag_key = set()
        for s in soup.find_all(class_=True):
            for k in s.attrs:
                tag_key.add(s.name+":"+k)
            if 'class' in s.attrs:
                sty = s['class']
                for k in sty:
                    tag_key.add(s.name+":class:"+k)
            if 'style' in s.attrs:
                sty = nospc.sub('',s['style'])
                r = sty.split(';')
                for k in r:
                    k=k.split(':')[0]
                    tag_key.add(s.name+":style:"+k)
        if verbose: print("\n".join( tag_key ))
        if verbose: print("\n" * 3)

    for s in soup.find_all('span'):
        if not s.attrs:
            s.unwrap()

    # span:class:MsoFootnoteReference
    for t in soup(class_=re.compile(r'FootnoteReference',re.I)):
        t.unwrap()

    # p:class:MsoFootnoteText
    for s in soup(class_=re.compile(r'FootnoteText',re.I)):
        # UUID
        uu = str( uuid.uuid4() )
        if verbose: print("UUID:", uu)
        if s.a.has_attr('href'):
            hr = s.a['href']
            if verbose: print("FootNote:",hr)
        if s.a.has_attr('name'):
            nm = s.a['name']
            if verbose: print("Anchor name:",nm)
        s.a.extract()
        if verbose:
            print("Text:",s.get_text(strip=True))
            ctxtn = 0
            for ctxt in s.contents:
                print("  %d: %s" % (ctxtn,ctxt))
                ctxtn += 1

        # find the href and replace with note-position
        hrf = '#_' + nm
        for t in soup('a',href=hrf):
            new_tag = soup.new_tag("span")
            new_tag['class'] = "note-position"
            new_tag['id'] = uu
            t.replace_with( new_tag )
        # find the parent <div> and set the appropiate class
        d = s.parent
        d['class'] = 'nota'
        d['data-uuid'] = uu
        d['data-user'] = "original"
        d['data-created'] = time.strftime("%Y/"+meses[int(time.strftime("%m"))]+"/%d %H:%M")
        s.unwrap()
        # the containning <div> add class "notas"
        p = d.parent
        p['class'] = 'notas'
        try:
            p.br.extract()
            p.hr.extract()
        except:
            pass
    if debugis: print("\n" * 2)
    if debugis: print("=" * 66)
    return str(soup)
    # return str(soup)
    # --- ???? ----

dc = {}
def find_dc(value):
    if value in dc:
        return dc[key]
    return ""

def unpack_mht( file_name ):
    m = ""
    with open(file_name, 'r', encoding="latin1", errors="surrogateescape") as f:
        data = f.read()

    with open(file_name + '.new',"wb") as f:
        f.write(bytes(data, 'utf-8'))
    del data

    with open( file_name + '.new' ) as fp:
        m = email.message_from_file(fp)
    os.unlink( file_name + '.new' )
    if not m:
        return ""
    l = ""
    rehead = re.compile(r'header\.htm', re.I)
    for w in m.walk():
        if w.is_multipart():
            next
        if verbose: print(w.get_content_type())
        if w.get_content_type().startswith("image"):
            dc[ w['Content-Location'] ] = "data:"    + \
                w.get_content_type() + ";"           + \
                w['Content-Transfer-Encoding'] + "," + \
                w.get_payload()
            if verbose > 1:
                print( "-" * 70)
                print("MHT Got image:", w['Content-Location'] )
                print( dc[ w['Content-Location'] ] )
                print( "-" * 70)
        elif w.get_content_type() == "text/html" and \
            not rehead.search(w['Content-Location']):
            l = w.get_payload(decode=True)
        else:
            if verbose: print("MHT:",w.get_content_type(),w['Content-Location'],w['Content-Transfer-Encoding'])
    if l:
        soup = BeautifulSoup(l)
        for i in soup('img'):
            value = i['src']
            if value in dc:
                i['src'] = dc[ value ]
            else:
                if verbose: print("reading:", value)
                for k in dc.keys():
                    if verbose: print("searching:",value,"dc_key:",k)
                    if value in k:
                        i['src'] = dc[ k ]
                        if verbose: print("found:",value,"dc_key:",k)
                        break
                                      
                # try:
                #     try:
                #         imgfile = urllib.request.urlopen( value )
                #     except:
                #         imgfile = urllib.request.urlopen( w['Content-Location'] )
                #     if verbose: print("ok")
                #     i = imgfile.info()
                #     mimetype = i.gettype()
                #     s = imgfile.read()
                #     if verbose: print("len:", len(s))
                #     payload = base64.b64encode(s)
                #     if verbose: print("len:", len(payload))
                #     i['src'] = "data:" + mimetype + ";base64," + payload
                # except Exception as e:
                #     if verbose: print("error in info().gettype()", str(e))
                #     mimetype = "image/jpeg"
        l = str(soup)
    return filtro_salida(l)

def htm_from_LO( file_name ):
    l = ""
    cmd = ['unoconv','-d','document','-f','html',file_name]
    try:
        # p = subprocess.check_output( cmd, stderr=subprocess.STDOUT )
        p = subprocess.call( cmd, shell=True )
        if p == 0:
            file_name = re.sub(r'\.[a-z]+$','.html',file_name)
            with open(file_name, 'r', encoding="utf-8", errors="surrogateescape") as f:
                l = f.read()
        else:
            print("Document conversion error")
    except Exception as e:
        print("Error",e)
        sys.exit(1)
    return filtro_salida(l)

if __name__ == "__main__":
    l = ""
    is_mht = False
    infile = sys.argv[1]
    #if not os. is readable
    # print("Erorr: archivo inválido")
    # sys.exit(1)
    if infile.endswith(".mht"):
        is_mht = True
    elif infile.endswith(".doc") or infile.endswith(".docx"):
        if debugis: print("Got MS-Word file")
        l = htm_from_LO( infile )
    elif infile.endswith(".odt") or infile.endswith(".fodt"):
        if debugis: print("Got LibreOffice file")
        l = htm_from_LO( infile )
    else:
        with open(infile,'r', encoding="latin1", errors="surrogateescape") as f:
            l = f.read()
            m = re.search(r'MIME-Version', l[:2048], re.I) # , 0, 2048)
            h = re.search(r'<[a-z]+>', l[:8192], re.I) # , 0, 8192)
            if m:
                is_mht = True
                l = ""
            elif h:
                with open( infile + '.new', 'w', encoding="utf-8", errors="surrogateescape") as f:
                    f.write(l)
                l = ""
                with open( infile + '.new' ) as f:
                    l = f.read()
                    l = filtro_salida(l)
            else:
                print("Unknown file type")
                l = ""
    if is_mht:
        l = unpack_mht( infile ) # This is .mht --> unpack and load main file
    if l:
        infile = sys.argv[2]
        # infile = re.sub(r'\.[a-z]+','.htm',infile)
        try:
            with open(infile,"wb") as f:
                f.write(bytes(l, 'utf-8'))
                print("OK")
            sys.exit(0)
        except Exception as e:
            print("Error(5) " ,sys.exc_info()[0])
    else:
        print("Error !L")

sys.exit(7)
