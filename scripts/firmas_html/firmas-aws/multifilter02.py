#!/usr/bin/python
# -*- coding: utf-8 -*-

from __future__ import nested_scopes
import sys, os, re
from sgmllib import SGMLParser
import htmlentitydefs
import email, base64, quopri, urllib

verbose = 0
debuging = 0

useless_tags = ('style','meta','link')
invisible_tags = ('span',)

dc = {}
def find_dc(value):
    for key in dc.keys():
        if key.find(value) != -1:
            if verbose:
                print "Matched:",value, "with key:", key
            return dc[key]
    return ""

def unpack_mht( sourcestring ):
    m = email.message_from_string(sourcestring)

    rehtml = re.compile(r'text/html', re.I)
    rehead = re.compile(r'header\.htm', re.I)
    reimg  = re.compile(r'image', re.I)

    l = ""
    for w in m.walk():
        if not w.is_multipart():
            if debuging:
                print 'Content-Location:', w['Content-Location']
                print 'Content-Type:', w['Content-Type']
                print 'Content-Transfer-Encoding:', w['Content-Transfer-Encoding']

            if rehtml.search(w['Content-Type']) and \
                  not rehead.search(w['Content-Location']):
                if w['Content-Transfer-Encoding'] == "base64":
                    l=base64.b64decode(w.get_payload())
                else:
                    l=quopri.decodestring(w.get_payload())
            elif reimg.search(w['Content-Type']):
                dc[ w['Content-Location'] ] = "data:" + \
                    w['Content-Type'] + ";" + \
                    w['Content-Transfer-Encoding'] +"," + \
                    w.get_payload()
            
    return l



class WordhtmlFilter(SGMLParser):

    def reset(self):
        self.pieces = []
        self.allowed_tags = []
        self.in_useless   = 0
        SGMLParser.reset(self)

    def unknown_starttag(self, tag, attrs):
        align = ''
        for key, value in attrs:
            if key == 'style':
                m = re.search(r'text-align:(\w+)', value)
                if m and m.group(1):
                    align = " style='text-align:" + m.group(1) + "'"
        if tag in useless_tags:
            self.in_useless   = 1
            return
        if tag in invisible_tags:
            return
        if tag == "o":
            tag = 'p'
        if not tag in self.allowed_tags:
            self.allowed_tags.append(tag)
        self.pieces.append("<%(tag)s%(align)s>" % locals())
        if debuging:
            print "ust+pieces:", "<%(tag)s%(align)s>" % locals()


    def start_img(self, attrs):
        skey = ""
        atr = {}
        for key, value in attrs:
            atr[key]=value
            if key.lower() == 'src':
                skey = key
                hinlinetype = find_dc(value)
                if not hinlinetype:
                    if verbose: print "reading:", value
                    imgfile = urllib.urlopen( value )
                    if verbose: print "ok"
                    try:
                      i = imgfile.info()
                      mimetype = i.gettype()
                    except:
                      if verbose: print "error in info().gettype()"
                      mimetype = "image/jpeg"
                      pass
                    s = imgfile.read()
                    if verbose: print "len:", len(s)
                    payload = base64.b64encode(s)
                    if verbose: print "len:", len(payload)
                    hinlinetype = "data:" + mimetype + ";base64," + payload
                    # if verbose: print "inlinetype:", hinlinetype

        if skey:
            atr[skey] = hinlinetype
            if verbose: print "skey:", skey
        strattrs = "".join([' %s="%s"' % (key, value) for key, value in atr.items()])
        self.pieces.append("<img %(strattrs)s>" % locals())
        if debuging:
            print "simg+pieces:", "<img %(strattrs)s>" % locals()
        
    def unknown_endtag(self, tag):
        if tag in useless_tags:
            self.in_useless   = 0
            return
        if tag in invisible_tags:
            return
        if tag.startswith("o:"):
            tag = 'p'
        if not tag in self.allowed_tags:
            self.allowed_tags.append(tag)
        self.pieces.append("</%(tag)s>" % locals())
        if debuging:
            print "uet+pieces:", "</%(tag)s>" % locals()

    def handle_charref(self, ref):
        if self.in_useless:
            return
        self.pieces.append("&#%(ref)s;" % locals())
        if debuging:
            print "hcref+pieces:", "&#%(ref)s;" % locals()

    def handle_entityref(self, ref):
        if self.in_useless:
            return
        self.pieces.append("&%(ref)s" % locals())
        if debuging:
            print "heref+pieces:", "&%(ref)s;" % locals()
        if htmlentitydefs.entitydefs.has_key(ref):
            self.pieces.append(";")
            if debuging:
                print "heref+pieces:", ";" % locals()

    def handle_data(self, text):
        if self.in_useless:
            return
        self.pieces.append(text)
        if debuging:
            print "d+pieces:", text.encode('utf8')

    def handle_comment(self, text):
        pass

    def handle_pi(self, text):
        if self.in_useless:
            return
        pass

    def handle_decl(self, text):
        pass

if __name__ == "__main__":
    encoding = ""
    arg = sys.argv[1]
    if debuging:
        f = open(arg, 'r')
        l = f.read()
        m = re.search(r'MIME-Version', l)
        if m: # This is .mht --> unpack and load main file
            l = unpack_mht(l)

        m = re.search(r'charset=(\S*)"', l)
        f.close()
        if m and m.group(1):
            encoding = m.group(1)
        else:
            encoding = "windows-1252"
        #if verbose: print "Encoding: ", encoding
        if encoding in ('macintosh',):
            encoding = 'mac_roman'
        data = l.decode(encoding,'ignore')
        odeb = open("/tmp/data.in","wb")
        odeb.write(data.encode('utf8'))
        odeb.close()

    else:
        try:
            f = open(arg, 'r')
            l = f.read()
            m = re.search(r'MIME-Version', l)
            if m: # This is .mht --> unpack and load main file
                l = unpack_mht(l)

            m = re.search(r'charset=(\S*)"', l)
            f.close()
            if m and m.group(1):
                encoding = m.group(1)
            else:
                #C chd = chardet.detect(l)
                #C if chd['confidence'] > 0.979:
                #C     encoding = chd['encoding']
                #C else:
                #C     encoding = "windows-1252"
                encoding = "windows-1252"
            #if verbose: print "Encoding: ", encoding
            if encoding in ('macintosh',):
                encoding = 'mac_roman'
            data = l.decode(encoding,'ignore')
        except IndexError as (errno, strerror):
            print "Error(1) Index ({0}): {1}".format(errno, strerror)
            print "Error: input file name ??"
            sys.exit(1)
        except:
            print "Error(2):", sys.exc_info()[0]
            sys.exit(2)

    # print data.encode('utf8')
    if debuging:
        parser = WordhtmlFilter()
        print "WordhtmlFilter done"
        parser.feed(data)
        print "parser done"
        odeb = open("/tmp/data.out","wb")
        for p in parser.pieces:
            odeb.write("\n::" + p.encode('utf8') + "::")
        odeb.close()
        data = "".join( parser.pieces )
        print "data done"
        parser.close()
    else:
        try:
            parser = WordhtmlFilter()
        except:
            print "Error(3.0):", sys.exc_info()[0]
            sys.exit(3)
        try:
            parser.feed(data)
        except:
            print "Error(3.1):", sys.exc_info()[0]
            sys.exit(3)
        try:
            data = "".join( parser.pieces )
        except:
            print "Error(3.2):", sys.exc_info()[0]
            sys.exit(3)
        parser.close()
    try:
        data = re.sub(u'\xa0',' ',data)
        data = re.sub(r'\s+', ' ', data)         # collapse spaces
        data = re.sub(r'>\s+<', '><', data)       # collapse more spaces
        data = re.sub(r'<head>','<head>\n<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">\n', data) # add header
        data = re.sub(r'<(\w+)></\1>', '', data) # collapse empty
        data = re.sub(r'</p>', r'</p>\n', data)  # add new lines
    except:
        print "Error(4):", sys.exc_info()[0]
        sys.exit(4)
    try:
        arg = sys.argv[2]
        f = open(arg, 'wb')
        f.write(data.encode('utf8'))
        f.close()
        print "OK"
    except IndexError as (errno, strerror):
        print "Error(5) Index ({0}): {1}".format(errno, strerror)
        print "Error: output file name ??"
        sys.exit(5)
    except IOError as (errno, strerror):
        print "Error(6) IO ({0}): {1}".format(errno, strerror)
        sys.exit(6)
    except:
        print "Error(7):", sys.exc_info()[0]
        sys.exit(6)
