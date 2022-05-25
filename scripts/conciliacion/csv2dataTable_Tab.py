#! python
#-*- coding: utf-8 -*-

import sys, csv
excelin = csv.reader(open(sys.argv[1], 'rb'), delimiter='	') #,dialect='excel', quoting=csv.QUOTE_NONNUMERIC)

print """
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
</style>
</head>
<body>
<div>
    <div style="float:right; margin: 0; padding: 5px 30px">
        <img src="/img/logoSICOR.png">
    </div>
    <div style="float:left; margin: 0; padding: 5px 30px;">
        <img src="/img/logoTribunal.png">
    </div>
</div>
"""

rowno = 0
table = True
for row in excelin:
    rowno += 1
    if ( rowno == 1):
        print "<div style='font-size:16pt;font-weight: bold; height: 110px;'><div>&nbsp;</div><div>&nbsp;</div><div style='vertical-align: bottom'>" + "</div><div>".join(row) + """</div></div><table cellpadding="0" cellspacing="0" border="0" class="display" id="table1">"""
    elif( rowno == 2):
        print "<thead><tr><th>" + "</th><th>".join(row) + "</th></tr></thead><tbody>"
    else:
        #print "<tr><td>" + "</td><td>".join([str(x) for x in row]) + "</td></tr>"i
        if ( table ):
            if ( len(row) > 0 ):
                print "<tr><td>" + "</td><td>".join(row) + "</td></tr>"
            else:
                print """</tbody></table>
<script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#table1').dataTable({
                "bJQueryUI": true,
                "sPaginationType": "full_numbers"});
        } );
</script>
"""
                table=False
        else:
            print """<div style="float:left;width: 150px;font-family: 'Lucida Grande',Verdana,Arial,Helvetica,sans-serif;font-size: 10pt;">""" + """</div><div style="float:left;width: 150px;font-family: 'Lucida Grande',Verdana,Arial,Helvetica,sans-serif; font-size: 10pt;">""".join(row) + """</div><div style='clear: both'></div>"""
if( table ):
    print """</tbody></table>
<script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#table1').dataTable({
                "bJQueryUI": true,
                "sPaginationType": "full_numbers"});
        } );
</script>
"""
print """</body></html>"""

