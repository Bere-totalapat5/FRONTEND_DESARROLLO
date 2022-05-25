#!/usr/bin/python3
# -*- coding: utf-8 -*-
this_config="boletin_judicial"

import sys, os, re
env = os.environ

import MySQLdb
import configparser
from datetime import datetime,timedelta,date

config = configparser.ConfigParser({this_config:{
            'rootdir': '/var/www/depjud2',
            'inc_dir': '/var/www/php-inc',
            'scripts_dir': '/var/www/scripts',
            'web_path': 'http://depjud.poderjudicialdf.gob.mx',
            'index_dir': '/var/www/public_html',
            'static_dir': '/var/www/static',
            'temp_dir': '/var/www/public_html/temporales',
            'wdir': '/var/www/public_html/temporales',
            'plantillas':  '/var/www/php-inc/reportes/PLANTILLAS',
            'santander_ok': 'true',
            'debug_sql': 'false',
            'is_production': 'true',
            'pdf_server': 'http://o2u:9180'}
                                    })

config.readfp(open('/etc/php/skills_depot.ini'))
q = re.compile(r'"')

#DB_port    = config.get(this_config,'db_port')
DB_host    = q.sub('',config.get(this_config,'DB_host'))
DB_user    = q.sub('',config.get(this_config,'DB_user'))
DB_passwd  = q.sub('',config.get(this_config,'DB_pass'))
DB_name    = q.sub('',config.get(this_config,'DB_name'))

try:
    dbd = MySQLdb.connect( host=DB_host,
                           db=DB_name,
                           user=DB_user,
                           passwd=DB_passwd,
                           charset="utf8",
                           connect_timeout=4 )
except Exception as e:
    print(str(e))
    print("Check DB parameters")
    sys.exit(1)
cursor   = dbd.cursor()


# def nad(fecha):
#     cursor.exec("""SELECT NAD(%s)""" % (fecha,))
#     f = ""
#     if cursor.rowcount > 0:
#         (f,) = cursor.fetchone()
#     return f

dow = ('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')
num_boletin = 0
inicio = date(2015,1,1)
# print("""SELECT fecha FROM feriados WHERE fecha >= DATE('%s')""" % (inicio,))
cursor.execute("""SELECT fecha FROM feriados WHERE fecha >= DATE('%s')""" % (inicio,))
if cursor.rowcount > 0:
    feriados = set( tuple[0] for tuple in cursor.fetchall() )
    #print(feriados)
# sys.exit(0)

facuerdos = date(1970,1,1)
f = inicio
hoy = date.today()
if len(sys.argv) > 1 and sys.argv[1]:
    h = datetime.strptime(sys.argv[1], "%Y-%m-%d")
    hoy = date( h.year, h.month, h.day)
    if hoy in feriados or hoy.weekday() >4:
        print("No hay publicación el ",str(hoy))
        sys.exit(0)
    while f <= hoy:
        if f.weekday() < 5 and not f in feriados:
            num_boletin += 1
            if f < hoy:
                facuerdos = f
        f += timedelta(days=1)
    print("num:",num_boletin,"fpub:",hoy,"dow:",dow[ hoy.weekday() ],"acuerdos del:",facuerdos)
else:
    if 0: hoy =date(2016,1,1)
    # print(hoy)
    while f < hoy:
        if f.weekday() < 5 and not f in feriados:
            num_boletin += 1
            print(num_boletin,f,dow[ f.weekday() ])
        f += timedelta(days=1)

