#!/usr/local/bin/python2.7
#-*- coding: utf-8 -*-

import MySQLdb
import sys, csv, os
from types import *
from tempfile import mkstemp



qfile = sys.argv[1]
f = open( qfile, "rb" )
query = "".join( f.readlines() )

(handle, csvfile) = mkstemp(prefix='tmp', dir='/tmp')
del handle

handle = open(csvfile,'wb')
excelout = csv.writer(handle, dialect='excel', quoting=csv.QUOTE_NONNUMERIC)

# excelout.writerow( ('cuenta','fecha_hora','cod_oper', 'folio',..
## $db_name = "sibjdf"; 
## $db_host = "localhost"; 
## $db_username = "sicor";
## $db_password = "tsjdf123"; 

db = MySQLdb.connect(db="sibjdf", user="sicor", passwd="tsjdf123", charset="utf8", use_unicode=True)
cursor   = db.cursor()

cursor.execute( query )

header= ['#']
for t in cursor.description:
    header.append( t[0] )
excelout.writerow( header )

i=1
for tuple in cursor.fetchall(): # SELECT file, mtime, size from files
    row = [ i ]
    for x in tuple:
        if isinstance(x, StringType) or isinstance(x, UnicodeType):
            x = x.encode('utf-8')
        row.append(x)
    excelout.writerow( row ) # [s.encode('utf-8') for s in row]
    i += 1

handle.close()
handle = open(csvfile, 'rb')
excelin = csv.reader(handle) #,dialect='excel', quoting=csv.QUOTE_NONNUMERIC)

#rfile = csvfile.replace("/tmp/","") + ".html"
#ofile = os.path.join("/var/www/public_html/temporales/", sys.argv[1], rfile)

#- # /var/www/scripts/firmas/doc_para_coser_2012OK.py
#- mytdir = mkdtemp(prefix='rpt_',dir="/var/www/public_html/temporales")
#- oName = os.path.join(mytdir, n)
#- o = open(oName,"w")

ofile = qfile + ".html"
rfile = ofile.replace("/var/www/public_html/","/")

f=open(ofile,"wb")

f.write("""<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" language="javascript" src="/static/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="/static/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="data:text/css,">
<style type="text/css" media="screen">
  @import "/static/site_jui.ccss";
  @import "/static/demo_table_jui.css";
  @import "/static/jquery-ui-1.7.2.custom.css";
  .dataTables_info { padding-top: 0; }
  .dataTables_paginate { padding-top: 0; }
  .css_right { float: right; }
  #table1_wrapper .fg-toolbar { font-size: 0.8em }
  #theme_links span { float: left; padding: 2px 10px; }
  #table1_wrapper { -webkit-box-shadow: 2px 2px 6px #666;
                    box-shadow: 2px 2px 6px #666;
                    border-radius: 5px; }
  #table1 tbody {
      border-left: 1px solid #AAA;
      border-right: 1px solid #AAA;
  }
  #table1 thead th:first-child { border-left: 1px solid #AAA; }
  #table1 thead th:last-child { border-right: 1px solid #AAA; }
  tr.odd { background-color: #CFD2B2; }
  tr.odd td.sorting_1 { background-color: #CFD2B2; }
  tr.even td.sorting_1 { background-color: #CFD2B2; }
  body { font: 100%/1em Arial, Helvetica, "Lucida Grande", Verdana, sans-serif; color: #010; }
</style>
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="table1">
""")

rowno = 0
for row in excelin:
    rowno += 1
    if ( rowno == 1):
        f.write("<thead><tr><th>" + "</th><th>".join(row) + "</th></tr></thead><tbody>\n")
    else:
        #print "<tr><td>" + "</td><td>".join([str(x) for x in row]) + "</td></tr>"
        f.write("<tr><td>" + "</td><td>".join(row) + "</td></tr>\n")

f.write("""</tbody></table>
<script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#table1').dataTable({
                "bJQueryUI": true,
                "sPaginationType": "full_numbers"});
        } );
</script>
</body></html>
""")

print "OK", rfile

handle.close()
os.unlink( csvfile )
