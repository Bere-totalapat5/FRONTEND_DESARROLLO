#!/bin/python3
import binascii, sys
from datetime import date, timedelta, datetime

start = "20151231"
i = 0
hoy = datetime.strptime(start, "%Y%m%d")
un_dia = timedelta(days=1)
salt = "porfirmar/2016/05"

# example_string = "bj/2016/05/BoletinJudicial_TSJCDMX_20160609.pdf"

if len(sys.argv) > 1:
    hoy = ""
    try:
        hoy =  datetime.strptime( sys.argv[1],"%Y-%m-%d")
    except Exception as e:
        print("got: ", sys.argv[1])
        print("Error: se espera fecha en formato 2016-02-17")
        print("Error: ",str(e))
        sys.exit(1)
    if hoy:
        archivo_de_hoy = hoy.strftime("bj/%Y/%m/BoletinJudicial_TSJCDMX_%Y%m%d.pdf")
        archivo_crc32 = binascii.crc32( archivo_de_hoy.encode("utf-8"))
        en_hex = '{:#010x}'.format( archivo_crc32 )
        nombre_completo = archivo_de_hoy.replace(".pdf", "_" + en_hex[-8:] + ".pdf")
        print( nombre_completo )
        sys.exit(0)
    else:
        print("No se comprende la fecha:",sys.argv[1])
        print("Error: se espera fecha en formato 2016-02-17")
        sys.exit(1)

while i < 100:
    hoy += un_dia
    fecha_hoy_string = hoy.strftime("%Y-%m-%d")
    print(fecha_hoy_string, end="\t")
    archivo_de_hoy = hoy.strftime("bj/%Y/%m/BoletinJudicial_TSJCDMX_%Y%m%d.pdf")
    print( archivo_de_hoy, end="\t" )
    archivo_crc32 = binascii.crc32( archivo_de_hoy.encode("utf-8"))
    print( archivo_crc32, end="\t" )
    en_hex = '{:#010x}'.format( archivo_crc32 )
    print( en_hex, end="\t" )
    nombre_completo = archivo_de_hoy.replace(".pdf", "_" + en_hex[-8:] + ".pdf")
    print( nombre_completo )
    i +=1
