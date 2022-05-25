#! python
# -*- coding: utf-8 -*-

import sys
fecha = sala = ""
try:
    fecha = sys.argv[1]
    sala  = sys.argv[2]
except:
    pass

if not fecha:
    print("Falta la fecha")
    sys.exit(1)

import re
import os
import types
from datetime import datetime,timedelta
# from time import strftime, strptime, localtime, time


dow = ('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')
mon = ('',"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
       "Agosto","Septiembre","Octubre","Noviembre","Diciembre")

try:
    f = datetime.strptime(fecha, "%Y-%m-%d")
    fpub = "del " + str(f.day) + " de " + mon[ f.month ] + " del " + str(f.year)
    listado = "listado_salas_bj_" + fecha + ".txt"
except Exception as e:
    print("Error en fecha (" + fecha + ") ")
    print(str(e))
    sys.exit(1)

if sala:
    # una sala
    qry = '''SELECT codigo, nombre FROM juzgado
    WHERE codigo = '%s'
    ORDER BY orden''' % (sala,)
else:
    # todas las salas
    qry = '''SELECT codigo, nombre FROM juzgado
    WHERE codigo IN ('1SC','2SC','3SC','4SC','5SC','6SC','7SC','8SC','9SC','10SC','1SF','2SF','3SF','4SF','5SF')
    ORDER BY orden'''

from tempfile import mkdtemp
mytdir = mkdtemp(prefix='listado_',dir="/var/www/public_html/temporales72")

import MySQLdb
dbd = MySQLdb.connect(db="sibjdf",read_default_file="~/.my.cnf",
                     unix_socket="/var/run/mysqld/mysqld.sock")
cursor   = dbd.cursor()
cursor.execute( qry )
all_juzgados = []
juzgado_nombres = {}

if cursor.rowcount > 0:
    for tuple in cursor.fetchall():
        juzgado_nombres[ tuple[0] ] = tuple[1]
        all_juzgados.append( tuple[0] )
        if 0: print (all_juzgados)
else:
    print("Error en clave de juzgado")
    sys.exit(1)

        
qry = '''SELECT
CONCAT(COALESCE(TRIM(p1.nombre),''), ' VS. ', COALESCE(TRIM(p2.nombre),'')) AS actores,
COALESCE(TRIM(p3.nombre),'') AS terceria,
GROUP_CONCAT( DISTINCT CONCAT_WS(' ',
	IF( cj.juicio IS NOT NULL, CONCAT_WS(' ',TRIM(cj.juicio),cj.materia), COALESCE(TRIM(tj.nomco),'')),
	a.concepto, 
	IF(a.publicar_en='TOCA','T.',a.publicar_en),
	CONCAT_WS('-', j.toca, j.anio_toca, j.asunto_toca),
    IF(a.tipo='sentencia',CONCAT('Pon. ',j.secretaria),'')
) separator ', ') AS concepto,
a.visibilidad
FROM acuerdo a
LEFT JOIN juicio j  ON j.id_juicio=a.id_juicio
LEFT OUTER JOIN tipojuicio tj       ON tj.id_tipojuicio=j.id_tipojuicio
LEFT OUTER JOIN catalogo_juicios cj ON cj.id_catalogo_juicios=j.id_catalogo_juicios
LEFT OUTER JOIN juicio_partes jp    ON jp.id_juicio=j.id_juicio
LEFT OUTER JOIN parte p1  ON p1.id_parte=jp.id_parte1
LEFT OUTER JOIN parte p2  ON p2.id_parte=jp.id_parte2
LEFT OUTER JOIN parte p3  ON p3.id_parte=jp.id_parte3
WHERE
      j.juzgado='%s'
  AND a.estatus = 30 -- ESTATUS_FIRMADO_Y_APROBADO
  AND a.activacion='%s'
  AND a.tipo='%s'
GROUP BY j.toca, j.anio_toca, j.asunto_toca
ORDER BY actores'''

# --   j.juzgado IN ('1SC','2SC','3SC','4SC','5SC','6SC','7SC','8SC','9SC','10SC','1SF','2SF','3SF','4SF','5SF')
# --  visibilidad NOT IN ('personal','secreto')

with open(os.path.join(mytdir, listado),"wt", encoding='utf-8') as f:
    for juzgado in all_juzgados:
        f.write("\n" +  juzgado_nombres[ juzgado ] + "\n")
        for tip in ('acuerdo','sentencia','audiencia'):
            f.write( tip.capitalize() + "s " + fpub + "\n" )
            cursor.execute( qry % (juzgado,fecha,tip))
            # print( qry % (juzgado,fecha,tip) + "\n" * 2)
            if cursor.rowcount > 0:
                for tuple in cursor.fetchall():
                    (act,ter,conc,vis) = tuple
                    if vis:
                        act = "(SECRETO)"
                        ter = None
                    if ter:
                        act += " Tercero: " + ter
                    f.write(act + " " + conc + "\n")
            else:
                f.write( "-- No hay publicaciones --\n")
    print("OK " + os.path.join(mytdir,listado)[20:])
