#!/usr/bin/python2.6
# -*- coding: utf-8 -*-

from __future__ import nested_scopes
import sys, re
from sgmllib import SGMLParser
import htmlentitydefs
import chardet

    ## def start_a(self, attrs):
    ##     href = [v for k, v in attrs if k=='href']
    ##     if href:
    ##         self.urls.extend(href)

    ## def start_img(self, attrs):
    ##     href = [v for k, v in attrs if (k=='src' or k=='SRC')]
    ##     if href:
    ##         self.imgs.extend(href)

useless_tags = ('style','meta','link')
invisible_tags = ('span',)

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

    def handle_charref(self, ref):
        if self.in_useless:
            return
        self.pieces.append("&#%(ref)s;" % locals())

    def handle_entityref(self, ref):
        if self.in_useless:
            return
        self.pieces.append("&%(ref)s" % locals())
        if htmlentitydefs.entitydefs.has_key(ref):
            self.pieces.append(";")

    def handle_data(self, text):
        if self.in_useless:
            return
        self.pieces.append(text)

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
    try:
        f = open(arg, 'r')
        l = f.read()
        m = re.search(r'charset=(\S*)"', l)
        f.close()
        if m and m.group(1):
            encoding = m.group(1)
        else:
            chd = chardet.detect(l)
            if chd['confidence'] > 0.979:
                encoding = chd['encoding']
            else:
                encoding = "windows-1252"
        if encoding in ('macintosh',):
            encoding = 'mac_roman'
        data = l.decode(encoding,'ignore')
    except IndexError as (errno, strerror):
        print "Error Index ({0}): {1}".format(errno, strerror)
        print "Error: input file name ??"
    except:
        print "Error(1):", sys.exc_info()[0]
    try:
        parser = WordhtmlFilter()
        parser.feed(data)
        data = "".join( parser.pieces )
        parser.close()
    except:
        print "Error(2):", sys.exc_info()[0]
    try:
        data = re.sub(u'\xa0',' ',data)
        data = re.sub(r'\s+', ' ', data)         # collapse spaces
        data = re.sub(r'>\s+<', '><', data)       # collapse more spaces
        data = re.sub(r'<(\w+)></\1>', '', data) # collapse empty
        data = re.sub(r'</p>', r'</p>\n', data)  # add new lines
        data = re.sub(r'<head>','<head>\n<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">\n', data) # add header
    except:
        print "Error(3):", sys.exc_info()[0]
    try:
        arg = sys.argv[2]
        f = open(arg, 'wb')
        f.write(data.encode('utf8'))
        f.close()
        print "OK"
    except IndexError as (errno, strerror):
        print "Error Index ({0}): {1}".format(errno, strerror)
        print "Error: output file name ??"
    except IOError as (errno, strerror):
        print "Error IO ({0}): {1}".format(errno, strerror)
    except:
        print "Error(4):", sys.exc_info()[0]
