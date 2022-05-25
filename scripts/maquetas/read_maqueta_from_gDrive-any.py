#!/usr/bin/python
# -*- coding: utf-8 -*-

debugis         = 1
skills_depot    = "sicor"

import sys, os, json, httplib2, datetime, re

doc_name = sys.argv[1]
ws_name = sys.argv[2]
if len( sys.argv ) > 3:
    debugis = sys.argv[3]

import gdata.spreadsheets
import gdata.spreadsheets.client
import gdata.gauth
from oauth2client.client import SignedJwtAssertionCredentials
from time import time
import MySQLdb, MySQLdb.cursors

## =============================================================================

import ConfigParser
env = os.environ
config = ConfigParser.ConfigParser({skills_depot:{
            'rootdir': '/var/www/sicor',
            'inc_dir': '/var/www/sicor/php-inc',
            'scripts_dir': '/var/www/sicor/scripts',
            'web_path': 'http://depjud.poderjudicialdf.gob.mx',
            'index_dir': '/var/www/sicor/public_html',
            'static_dir': '/var/www/sicor/static',
            'temp_dir': '/var/www/public_html/temporales',
            'wdir': '/var/www/depgar/public_html/temporales',
            'plantillas':  '/var/www/depgar/php-inc/reportes/PLANTILLAS',
            'santander_ok': 'false',
            'debug_sql': 'false',
            'is_production': 'true',
            'pdf_server': 'http://o2u:9180'}
                                    })
config.readfp(open('/etc/php/skills_depot.ini'))
q = re.compile(r'"')

username        = 'depjud_sistema@tsjdf.gob.mx'
passwd          = 'tsjdfdf88'
doc_name        = 'Maqueta SICOR 2015'
rootdir         = "/var/www/public_html"
inc_dir         = "/var/www/php-inc"
maquetas        = inc_dir + "/reportes/maquetas"
DB_port         = 3306
DB_host         = "o2u"

#DB_port    = config.get(skills_depot,'db_port')
DB_host     = q.sub('',config.get(skills_depot,'db_host')).decode('utf-8')
DB_user     = q.sub('',config.get(skills_depot,'db_user')).decode('utf-8')
DB_passwd   = q.sub('',config.get(skills_depot,'db_pass')).decode('utf-8')
DB_name     = q.sub('',config.get(skills_depot,'db_name')).decode('utf-8')
rootdir     = q.sub('',config.get(skills_depot,'index_dir')).decode('utf-8')
index_dir   = q.sub('',config.get(skills_depot,'index_dir')).decode('utf-8')
inc_dir     = q.sub('',config.get(skills_depot,'inc_dir')).decode('utf-8')
wdir        = q.sub('',config.get(skills_depot,'temp_dir')).decode('utf-8')
plantillas  = os.path.join(str(inc_dir),"reportes","PLANTILLAS")
maquetas    = os.path.join(str(inc_dir),"reportes/maquetas")

db = MySQLdb.connect( host=DB_host,
                      db=DB_name,
                      user=DB_user,
                      passwd=DB_passwd,
                      charset="utf8",
                      use_unicode=True,
                      connect_timeout=4 )

cursor   = db.cursor()

def dfnt( value ):
    if isinstance( value, unicode ):
        # if debugis: print "UTF8", value.encode("utf-8")
        value =  value.encode("utf-8")
    if isinstance(value, basestring ):
        value = db.escape_string(value.strip())
    elif value is None:
        value = ""
    return value

start_time = time()
# Connect to Google
json_key = json.load(open('/var/www/google_access_key.json'))
scope=('https://spreadsheets.google.com/feeds',)
credentials = SignedJwtAssertionCredentials(json_key['client_email'],
                                            json_key['private_key'],
                                            scope)

if credentials.access_token_expired or not credentials.access_token:
    credentials.refresh(httplib2.Http())

auth2token = gdata.gauth.OAuth2TokenFromCredentials(credentials)
gd_client = gdata.spreadsheets.client.SpreadsheetsClient()
gd_client = auth2token.authorize(gd_client)

q = gdata.spreadsheets.client.SpreadsheetQuery(title=doc_name,title_exact=True)
feed = gd_client.get_spreadsheets(query = q)
rows = []

if len(feed.entry) == 0:
    print "Unable to find spreadsheet named %s" % (doc_name)
    sys.exit(1)

# Now that we're connected, we query the spreadsheet by name, and
# extract the unique spreadsheet and worksheet IDs.

worksheet_id = None
print "looking for:",ws_name

for spreadsheet in feed.entry:
    spreadsheet_id = spreadsheet.id.text.rsplit('/',1)[1]
    worksheetFeed = gd_client.GetWorksheets(spreadsheet_id)
    recordIndex = 0
    for worksheet in worksheetFeed.entry:
      if worksheet.title.text != ws_name:
        continue
      worksheet_id = worksheet.id.text.rsplit('/',1)[1]
      for row in gd_client.GetListFeed(spreadsheet_id, worksheet_id).entry:
        r = row.to_dict()
        # rs = [ r[t] for t in campos[ws_name] ]
        rows.append(r)
      if 0 : print json.dumps(rows, default=dthandler, ensure_ascii=False, indent=1 ).encode('utf-8')

## =============================================================================


elapsed = (time() - start_time) or 1e-6
print "\nGot %d rows in: %.4f secs.\n" % (len(rows), elapsed,)

# At this point, you have a row iterator which will yield rows for the
# spreadsheet. This example will print everything out, keyed by column
# names:

casos = {
    "Maqueta_tablas":{
        "tabla":"maq_tablas",
        # stitle|bsortable|sclass|swidth|tipo|formato|totales|idtable|direccion|campo|filtro|rango|action|nomreport|xlsname|initcol|initrow|viewstr|querystr|wherestr|orderstr|groupstr
        "first":"stitle",
        "repfef":"nomreport",
        "idrow":"maq_tablas_id",
        "rowprimary":"stitle",
        "sthmaster":"""INSERT INTO maq_tablas
        (nomreport,direccion,initcol,initrow,xlsname,viewstr,querystr,wherestr,orderstr,groupstr, url2edit)
        VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)""",
        "masterid":"""SELECT maq_tablas_id FROM maq_tablas WHERE nomreport=%s""",
        "mastervals":("nomreport","direccion","initcol","initrow","xlsname","viewstr","querystr","wherestr","orderstr","groupstr", "url2edit"),
        "sthparts":"""INSERT INTO maq_tablas_elementos (maq_tablas_id,orden,stitle,tipo,sclass,totales,formato,swidth,campo,filtro,rango,linkaction,filtrodef,editable,opciones) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)""",
        "partvals":("stitle","tipo","sclass","totales","formato","swidth","campo","filtro","rango","linkaction","filtrodef","editable","opciones"),
        "rnotnulls":{"tipo":"text","stitle":"","totales":'F',"campo":""},
        "intvals":("swidth","initcol","initrow"),
        "mnotnulls":(),
        "jsondir":"maquetas/tablas",
        "jsonkeymaster":(),
        "jsonkeyelements":("sTitle","tipo","sWidth","bVisible")
        },
    "Maqueta_formas":{
        "tabla":"maq_formas",
        # clave|usuario|menu|label|name|id|tipo|maxlength|rdonly|defaultvalue|tituloformulario|action|required|message
        "first":"clave",
        "repfef":"clave",
        "idrow":"maq_formas_id",
        "rowprimary":"id",
        "sthmaster":"""INSERT INTO maq_formas
        (clave,usuario,menu,tituloformulario,action)
        VALUES (%s,%s,%s,%s,%s)""",
        "mastervals":("clave","usuario","menu","tituloformulario","action"),
        "masterid":"SELECT maq_formas_id FROM maq_formas WHERE clave=%s",
        "sthparts":"""INSERT INTO maq_formas_elementos
        (maq_formas_id,orden,label,name,id,tipo,maxlength,defaultvalue,filtro,required,message,rdonly)
        VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)""",
        "partvals":("label","name","id","tipo","maxlength","defaultvalue","filtro","required","message","rdonly"),
        "intvals":("maxlength"),
        "rnotnulls":{"tipo":"text","rdonly":"F","required":"F"},
        "mnotnulls":{},
        "jsondir":"maquetas/formas"
    },
    "Maqueta_menus":{
        "tabla":"maq_menus",
        # Antes: clavemenu|nombremenu|ordenmenu|nivelmenu|privilegiomenu|leyendamenu|accionmenu|tooltipmenu|observacionesmenu
        # leyendamenu|padremenu|nivel1|nivel2|nivel3|accionmenu|tooltipmenu|pragma|observacionesmenu
        "first":"tipousuario",
        "repfef":"tipousuario",
        "idrow":"maq_menus_id",
        "rowprimary":"leyendamenu",
        "sthmaster":"""INSERT INTO maq_menus (tipousuario) VALUES (%s)""",
        "masterid":"SELECT maq_menus_id FROM maq_menus WHERE tipousuario=%s",
        "mastervals":("tipousuario",),
        "sthparts":"""INSERT INTO maq_menus_elementos (maq_menus_id,orden,padremenu,nivel1,nivel2,nivel3,leyendamenu,accionmenu,tooltipmenu,pragma,observacionesmenu,deshabilitado) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)""",
        "partvals":("padremenu","nivel1","nivel2","nivel3","leyendamenu","accionmenu","tooltipmenu","pragma","observacionesmenu","deshabilitado"),
        "intvals":("padremenu","nivel1","nivel2","nivel3"),
        "rnotnulls":{"padremenu":0,"nivel1":0,"nivel2":0,"nivel3":0,"deshabilitado":"F"},
        "mnotnulls":{},
        "jsondir":"maquetas/menus"
    },
    "Maqueta_actions":{
        "tabla":"maq_actions",
        # action|label|cmd|isPopup|condMensajes|tituloMensajesDeshab|tituloConfirmacion|jsonparam|aurl
        "first":"action",
        "repfef":"action",
        "idrow":"maq_actions_id",
        "rowprimary":"action",
        "sthmaster":"""INSERT INTO maq_actions
        (action,label,cmd,ispopup,condmensajes,
         titulomensajesdeshab,tituloconfirmacion,
         jsonparam,aurl)
        VALUES (%s,%s,%s,%s,%s,
        %s,%s,
        %s,%s)""",
        "masterid":"",
        "mastervals":("action","label","cmd","ispopup","condmensajes",
                      "titulomensajesdeshab","tituloconfirmacion",
                      "jsonparam","aurl"),
        "sthparts":"",
        "partvals":(),
        "intvals":(),
        "rnotnulls":{},
        "mnotnulls":{},
        "jsondir":"maquetas"
    },
}

if ws_name in casos:
    r = casos[ ws_name ]
    if r["partvals"]:
        cursor.execute("DELETE FROM " + r["tabla"] + "_elementos")
    cursor.execute("DELETE FROM " + r["tabla"] )
    db.commit()
else:
    print "Tabla inválida"
    sys.exit(0)

orden        = 0
defreport_id = 0
numrow       = 1
start_time   = time()
master_id    = 0

for row in rows:
    numrow += 1
    if row[ r["repfef"] ] and row[ r["repfef"] ].strip().startswith('#'):
        continue
    if row[ r["repfef"] ] and row[ r["repfef"] ].find("--") == -1:
        print numrow, row[ r["repfef"] ].encode("utf-8")
        # recor = [ dfnt(row[x]) for x in r["mastervals"] ]
        recor = []
        for x in r["mastervals"]:
            z = row[x]
            if x in r["intvals"]:
                if row[x]:
                    recor.append( dfnt(row[x]) )
                else:
                    recor.append(0)
            else:
                    recor.append( dfnt(row[x]) )
        # for f in r["intvals"]:
        #     if f in recor and not recor[f]:
        #         recor[f] = 0
        if debugis: print "master:", recor
        cursor.execute( r[ "sthmaster"], recor)
        db.commit()
        if r["masterid"]:
            if debugis:
                print r["masterid"],
                print dfnt(row[ r["repfef"] ])
                print r["masterid"] %  (dfnt(row[ r["repfef"] ]),)
            cursor.execute( r["masterid"], (dfnt(row[ r["repfef"] ]),))
            (master_id,) = cursor.fetchone()
            orden = 0
    if r["partvals"]:
        if debugis: print "mater_id=",master_id,"repfef=",dfnt(row[ r["repfef"] ])
        if row[ r["first"] ] and row[ r["first"] ].find("--") >= 0:
            master_id = 0
            continue
        if not master_id or not row[ r["rowprimary"] ]:
            continue
        for k,v in r["rnotnulls"].iteritems():
            if not row[k]:
                row[k] = v
            if not row[k]:
                continue
        recor = [master_id,orden]
        # recor.extend( [ dfnt(row[x]) for x in r["partvals"] ] )
        for x in r["partvals"]:
            if x in r["intvals"]:
                if row[x]:
                    recor.append( dfnt(row[x]) )
                else:
                    recor.append(0)
            else:
                recor.append( dfnt(row[x]) )
        if debugis:
            print "parts:", recor
            # print "query=", r["sthparts"]
            # print r["sthparts"] % recor
        if debugis:
            print("q:",r["sthparts"])
            print("r:",recor)
            print(r["sthparts"], recor)
        cursor.execute( r["sthparts"], recor)
    orden += 1

elapsed = (time() - start_time) or 1e-6
print "\nSaved %d rows in: %.4f secs.\n" % (numrow, elapsed,)

start_time = time()
db.commit()
elapsed = (time() - start_time) or 1e-6

db = MySQLdb.connect( host=DB_host,
                      db=DB_name,
                      user=DB_user,
                      passwd=DB_passwd,
                      charset="utf8",
                      use_unicode=True,
                      connect_timeout=4,
                      cursorclass=MySQLdb.cursors.DictCursor ) 

cursor   = db.cursor()
all_masters_fields = [r["idrow"]]
all_masters_fields.extend(r["mastervals"])
all_masters = "SELECT " + ",".join(all_masters_fields)+ " FROM " + r["tabla"]
if debugis: print all_masters

if r["partvals"]:
    all_parts = "SELECT orden, " + ",".join(r["partvals"])+ " FROM " + r["tabla"] + "_elementos WHERE " + r["idrow"] + "=%s  ORDER BY orden"
else:
    all_parts = ""

if debugis: print all_parts
report_names  = []
cursor.execute(all_masters)
allm = cursor.fetchall()
if debugis: print("-- allm: --",allm)
for t in allm:
    k = t[ r["idrow"] ]
    del t[ r["idrow"] ]
    if r["partvals"]:
        cursor.execute( all_parts,(k,) )
        elementos = cursor.fetchall()
        obj = json.dumps( {"forma":t,"elementos":elementos},
                          indent=2, encoding="utf-8", ensure_ascii=False)
        if 1 or debugis:
            print "search cmd=",t[ r["repfef"] ]
            print obj.encode("utf-8")
            print
    else:
        obj = json.dumps( {"forma":t},
                          indent=2, encoding="utf-8", ensure_ascii=False)
    # replace or insert
    cursor.execute("""SELECT comando FROM formas_reportes WHERE comando=%s""",(t[ r["repfef"] ],))
    row = cursor.fetchone()
    if row:
        cursor.execute("""UPDATE formas_reportes SET jsonstring=%s
        WHERE comando=%s""", (obj,t[ r["repfef"] ]))
    else:
        cursor.execute("""INSERT INTO formas_reportes (comando,jsonstring) VALUES (%s,%s)""",(t[ r["repfef"] ],obj))

    if ws_name != "Maqueta_tablas":
        continue
    #
    # Test new system: Look Ma, Pure json !
    #
    arch_filtros = os.path.join(maquetas,t[ r["repfef"] ] + ".json")
    mtj = open( arch_filtros,"wb")
    mtj.write(obj.encode("utf-8"))
    mtj.close()

    wjson = { "div_table":"div_" + t[ r["repfef"] ],
             "id_tabla":t[ r["repfef"] ],
             "url":"",
             "url2edit":t["url2edit"],
             "visible_table":"T",
             "columns":[]
             }
    # ("campo","stitle","tipo","rango","linkaction","swidth"):
            #if e[f]:
    report_names.append( wjson["id_tabla"] )
    for e in elementos:
        o = {
            "campo"     :e["campo"],
            "sTitle"    :e["stitle"],
            "tipo"      :e["tipo"],
            "linkaction":e["linkaction"],
            "filtrodef" :e["filtrodef"],
            "editable"  :e["editable"],
            "opciones"  :e["opciones"],
            "rango"     :e["rango"],
            "sWidth"    :e["swidth"],
            "bVisible"  :"T" if e["tipo"] not in ("NOSELECT","invisible") else "F"
            }
        o["bVisible"] = "T" if e["tipo"] not in ("NOSELECT","invisible") else "F"
        if o["sWidth"] == 0:
            del o["sWidth"]
        for f in ("sTitle","tipo","linkaction","rango","opciones"):
            if o[f] == "":
                del o[f]
        wjson["columns"].append(o)
    obj = json.dumps( wjson, indent=2, encoding="utf-8", ensure_ascii=False)
    opath = os.path.join( rootdir, r["jsondir"], t[ r["repfef"] ] + ".json" )
    if debugis: print("Saving:",opath)
    f = open( opath, "wb")
    f.write(obj.encode("utf-8"))
    f.close()
db.commit()

# actions
cursor.execute("SELECT * FROM maq_actions")
wjson = {}
for e in cursor.fetchall():
    o = {
        "label": e["label"],
        "cmd": e["cmd"],
        "isPopup": e["ispopup"],
        "condMensajes": e["condmensajes"],
        "tituloMensajesDeshab": e["titulomensajesdeshab"],
        "tituloConfirmacion": e["tituloconfirmacion"],
        "jsonparam": e["jsonparam"],
        "aurl": e["aurl"],
        }
    wjson[ e["action"] ] = o

obj = json.dumps( wjson, indent=2, encoding="utf-8", ensure_ascii=False)
opath = os.path.join( rootdir, "maquetas/actions.json" )
if debugis: print("Saving:",opath)
f = open( opath, "wb")
f.write(obj) # .encode("utf-8")
f.close()

# maquetas para reportes

defrpts_qry = """SELECT maq_tablas_id, initcol, initrow, xlsname,
   querystr, viewstr, wherestr, orderstr, groupstr
FROM maq_tablas
WHERE nomreport = '%s'"""

coldesc_qry = """SELECT campo, tipo, stitle, totales, filtro
FROM maq_tablas_elementos
WHERE maq_tablas_id=%s
ORDER BY orden"""

db = MySQLdb.connect( host=DB_host,
                      db=DB_name,
                      user=DB_user,
                      passwd=DB_passwd,
                      charset="utf8",
                      use_unicode=True,
                      connect_timeout=4,
                      cursorclass=MySQLdb.cursors.Cursor) 

cursor   = db.cursor()

def get_defrpts( rptname ):
    # print defrpts_qry % (rptname,)
    cursor.execute( defrpts_qry % (rptname,))
    if cursor.rowcount > 0: # Oracle if cursor: #
        t = cursor.fetchone()
        # print "cursor.fetchone:", t
        (tablas_id,init_col,init_row,xlsname, query,view,where,orderby,groupby) = [ dfnt(i) for i in t ]
        # print "--".join((rptname,tablas_id,init_col,init_row,xlsname,query,view,where,orderby,groupby))
        
    else:
        # print "Error: not found"
        return (None,None,None,None,None,None,None,None,None)

    coldesc = []
    # print coldesc_qry % (tablas_id,)
    cursor.execute( coldesc_qry % (tablas_id,))
    for t in cursor:
        coldesc.append([dfnt(i) for i in t])
    return (init_col,init_row,xlsname,query,view,where,coldesc,orderby,groupby)

# For all reportes
for reporte in report_names:
    arch_filtros = os.path.join(inc_dir,"reportes","maquetas",reporte + ".json")
    if not os.access(arch_filtros, os.W_OK):
        print "Maqueta inválida:", arch_filtros
        sys.exit(1)
    f = open(arch_filtros, "wb")
    if debugis: print("Saving:",arch_filtros)
    desc_filtros = get_defrpts( reporte )
    f.write(json.dumps(desc_filtros, indent=2, encoding="utf-8", ensure_ascii=False))
    f.close()

print "debugis:",debugis
sys.exit(0)




















# "sthparts":"""INSERT INTO maq_tablas_elementos (    VALUES (       "partvals":(       
# maq_tablas_id,                                      %s,            
# orden,                                              %s,                
# stitle,                                             %s,                "stitle",      
# tipo,                                               %s,                "tipo",        
# sclass,                                             %s,                "sclass",      
# totales,                                            %s,                "totales",     
# formato,                                            %s,                "formato",     
# swidth,                                             %s,                "swidth",      
# campo,                                              %s,                "campo",       
# filtro,                                             %s,                "filtro",      
# rango,                                              %s,                "rango",       
# linkaction,                                         %s,                "linkaction",  
# filtrodef,                                          %s,                "filtrodef",   
# editable,                                           %s,                "editable",    
# opciones)                                           %s)""",            "opciones"),   
