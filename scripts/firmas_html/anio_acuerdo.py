import MySQLdb, re

anio_for_acuerdo = """SELECT YEAR(activacion)
FROM acuerdo
WHERE id_acuerdo = %s"""

# /files/firmados/2017/01/09/12/1481912896147.htm
racuerdo = re.compile(r"/(\d{13})\.")

#     anio, numac = leyenda_multianual( args )
def leyenda_multianual( args ):
    db = MySQLdb.connect(db="sibjdf",
                         user="sicor",
                         passwd="SdbmjHjBq2p3Qsw4",
                         charset='utf8')
    db.autocommit(True)
    cursor = db.cursor()

    anio = 0
    narc = 0
    for i in args: # extract numac for query
        m = racuerdo.search(i)
        if m:
            narc = m.groups(1)[0]

            try:
                cursor.execute( anio_for_acuerdo % (narc,))
                if cursor.rowcount > 0:
                    (anio,) = cursor.fetchone()
                    if anio and anio > 2000:
                        break
            except Exception as e:
                # print("Error:", str(e))
                pass
    db.close()
    return (anio, narc)
