#!/usr/bin/python3
# -*- coding: utf-8 -*-

import base64, sys, os, re, subprocess, qrcode, datetime, hashlib, logging
from time   import strftime, localtime, time
from struct import calcsize, pack

start_time = time()
# Parámetros configurables
this_config   = "sicor"
watermarkfile = "/var/www/html/sicor_extendido_80/scripts/firmas/plantilla_sellosQR_v7.fodt"
# [sicor2]
DB_host       = "172.16.159.140"
DB_user       = "sicor"
DB_pass       = "SdbmjHjBq2p3Qsw4" 
DB_name       = "sibjdf"
# Fin -- Parámetros configurables
q             = re.compile(r'"')
import configparser
config        = configparser.ConfigParser()
config.read_file(open('/etc/php/skills_depot.ini','rt'))

#print( config.items( this_config) )
#print( q.sub(''.config.get( this_config,'DB_host')))

DB_host       = q.sub('',config.get(this_config,'DB_host'))
DB_user       = q.sub('',config.get(this_config,'DB_user'))
DB_passwd     = q.sub('',config.get(this_config,'DB_pass'))
DB_name       = q.sub('',config.get(this_config,'DB_name'))

# Globales
quote   = re.compile(r"(['\\])")
log_enabled = False
debugis = 1
verbose = 1
testing = 0 
cursor  = ""
dir     = ""
firmas_previas = {}
# Fin -- Globales

if log_enabled:
    logger    = logging.getLogger("oooDocs")
    hdlr      = logging.FileHandler("/tmp/docs.log")
    formatter = logging.Formatter("%(asctime)s [%(name)s] %(levelname)s - %(message)s")
        
def hex2Base64(s):
    pack_unit = "Q"
    cs = calcsize( pack_unit )
    ds = 2 * cs
    v=[]

    for i in range( int( len(s)/ ds ) ):
        v.append( int( s[i*ds:i*ds + ds], 16) )

    ps=pack("%s%s" % (len(v),pack_unit),*v)
    return base64.b64encode(ps).decode()


def makeqr(dir,nas,data,gestor_documental):
    path = "/san/www/html/sicor_extendido_80/storage/app/firmados/id_mide"+nas+".txt"
    days_file = open(path,'r')
    sello = days_file.readline()
    qr   = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_M,
        box_size=10,
        border=4,
    )
    qr.add_data("http://mide.poderjudicialcdmx.gob.mx/?NumeroDocumento=%s" % (sello))
    qr.make(fit=True)
    img  = qr.make_image()
    rimg = os.path.join(dir,"qr.png")
    img.save(rimg)
    # print("saved: %s" % "qr.png")
    return rimg

def ISREG(mode):
    # py3 octal mode 100664       100664
    return (mode & 0o170000) == 0o100000

# obtener sha256 del archivo
def check_hash(pathname):
    if not os.access(pathname, os.R_OK):
        print( "Can't read file:", pathname.encode('utf8','strict'))
        return
    try:
        mStat = os.lstat(pathname)
    except Exception as e:
        print( "Error check_hash:", str(e))
        print( "can't stat:", pathname )
        return
    if not ISREG( mStat.st_mode ): # is regular file
        if verbose:
            print( "not a file:", pathname )
            print( "%0o" % mStat.st_mode )
        return
    this_dir,filename = os.path.split( pathname )
    dirname = os.path.realpath(this_dir)
    sth_pn = """SELECT size, mtime, sha256
 FROM files f, paths p
WHERE p.path_no=f.path_no
  AND p.path='%s'
  AND f.filename='%s'"""
    # print(type(mStat.st_mtime))
    fmtime =  strftime( "%Y-%m-%d %X", localtime(mStat.st_mtime))
    cursor.execute( sth_pn % (quote.sub(r"\\\1", dirname),quote.sub(r"\\\1", filename)) )
    if cursor.rowcount:
        (size, mtime, sha256) = cursor.fetchone()

        if ((mStat.st_size & 0x7fffffff) == size) and \
            (fmtime == str(mtime)):
            return sha256
    if testing: print("Getting hash from:",pathname)
    if not os.path.isdir( dirname ):
        print( "Error:", dirname, ": utf8 error, not a dir (",this_dir,")" )
        sys.exit(1) # continue
    path_Stat = os.lstat(dirname)
    pfmtime =  strftime( "%Y-%m-%d %X", localtime(path_Stat.st_mtime))

    sth_pths = """SELECT path_no from paths WHERE path='%s'"""

    cursor.execute( sth_pths % (quote.sub(r"\\\1", dirname),))
    if cursor.rowcount > 0:
        (path_no,) = cursor.fetchone()
    else:
        sth_pthi = """INSERT INTO paths ( path ) VALUES ('%s')"""
        cursor.execute( sth_pthi % quote.sub(r"\\\1", dirname))
        # db.commit()
        cursor.execute( sth_pths % quote.sub(r"\\\1", dirname))
        (path_no,) = cursor.fetchone()
        # find the file
    # print("path_no:",path_no,"filename:",filename)
    sth_m = """SELECT id_file FROM files WHERE path_no=%s AND filename='%s'"""
    cursor.execute( sth_m % (path_no,quote.sub(r"\\\1",filename)))
    if cursor.rowcount:
        (id_file,) = cursor.fetchone()
    else:
        id_file = ""

    try:
        f = open(pathname,"rb")
        fmd5 = hashlib.md5()
        fsh6 = hashlib.sha256()
        t = f.read(32768)
        while t: #
            fmd5.update(t)
            fsh6.update(t)
            t = f.read(32768)
        f.close()
        fmd5 = fmd5.hexdigest()
        sha256 = hex2Base64(fsh6.hexdigest())
        if testing: print("sha256",sha256)
    except Exception as e:
        print( "Error reading file:", str(e), pathname )
        return

    try:
        sqlcmd = ""
        sqlname = quote.sub(r"\\\1", filename)
        if id_file:
            sth_u = """UPDATE files SET filename='%s', path_no=%s, size=%s,
mtime='%s', md5='%s', sha256='%s' WHERE id_file=%s"""
            sqlcmd = sth_u % (sqlname, path_no,
                             (mStat.st_size & 0x7fffffff),
                             fmtime, fmd5, sha256, id_file)
        else:
            sth_i = """INSERT INTO files ( filename, path_no, size, mtime, md5, sha256 )
VALUES ('%s',%s,%s,'%s','%s','%s')"""
            sqlcmd = sth_i % (sqlname,
                             path_no,
                             mStat.st_size & 0x7fffffff,
                             fmtime, fmd5, sha256)
        cursor.execute( sqlcmd )
    except Exception as e:
        print("SQL Error:", sqlcmd, str(e))
    except:
        print("SQL Error:", sqlname, filename)
    return sha256


NAS_FACTOR=6839.0
def getnas(id):
    nid = int(float(id) * NAS_FACTOR)
    nasc = "51" + format("%017d" % nid)
    for x in range(16,0,-4):
        nasc= nasc[:x] + "-" + nasc[x:]
    return nasc

def nas2id(nas):
    return int( float(nasc[2:].replace("-", "")) /NAS_FACTOR)


def get_acuerdo(id_acuerdo):

    #CONCAT( j.juzgado,' | Expediente: ', j.expediente,
    #    '/',
    #    CONCAT_WS(' ',j.anio, f_BIS(j.bis))
    #) AS nombre_expediente,

    sth_nas = """SELECT 
CONCAT( IF(z.tipo='juzgado','Juzgado ',''), z.nombre ) as juzgado,
j.juzgado AS nombre_expediente,
a.acuerdo,
a.activacion AS fecha_publicacion,
a.gestor_documental
FROM acuerdo a
JOIN juicio  j ON j.id_juicio=a.id_juicio
JOIN juzgado z ON z.codigo=j.juzgado
WHERE a.id_acuerdo=%s
LIMIT 1"""

    cursor.execute(sth_nas % id_acuerdo)
    
    if cursor.rowcount:
        # (juzgado,
        # nombre_expediente,
        # acuerdo,
        # fecha_publicacion) = cursor.fetchone()
        return cursor.fetchone()
    else:
        return ("","","","")


def get_firmas( id_acuerdo, sha256, vp ):
    if(vp=='vp'):
	    vp2 = " AND (f.tipo_firma='voto particular' ||  u.tipo='secretario') "
    else:
	    vp2 = " AND (f.tipo_firma!='voto particular' || u.tipo='secretario') "
    sth_f = """SELECT
id_firma,
u.usuario,
firma,
firmado/1000
FROM firma f, usuarios u
WHERE id_acuerdo=%s
  AND firmado IS NOT NULL
  AND u.id_usuario=f.id_usuario
  %s 
ORDER BY orden, firmado, id_firmante"""

    sthupdf = """UPDATE firma SET firma='%s', sha256='%s' WHERE id_firma=%s"""

    cursor.execute( sth_f % (id_acuerdo, vp2)) # , sumsarchivo["sha256"] )
    if cursor.rowcount:
        AllFirmantes = cursor.fetchall()
        faltan_firmas = [ x for x in AllFirmantes if not x[2] ]
        if faltan_firmas:
            for x in faltan_firmas:
                (id_firma,firmante,firma,fecha_hora) = x
                if firmante in firmas_previas:
                    firma = firmas_previas[ firmante ]
                else:
                    # print(str(id_acuerdo),str(firmante),sha256)
                    ftemp = "|".join((str(id_acuerdo),str(firmante),sha256))
                    # print(ftemp)
                    fsh6  = hashlib.sha256(ftemp.encode())
                    firma = hex2Base64(fsh6.hexdigest())

                # print("firma:",firma)
                # print( sthupdf % (firma, sha256, id_acuerdo, firmante ))
                cursor.execute( sthupdf % (firma, sha256, id_firma ))
            cursor.execute( sth_f % (id_acuerdo, vp2) ) # , sumsarchivo["sha256"] )
            if cursor.rowcount:
                AllFirmantes = cursor.fetchall()
            else:
                AllFirmantes = [[],]
    else:
        AllFirmantes = [[],]

    f_cert = 0
    asello = []
    for x in AllFirmantes:
        if len(x) == 4:
            (i,f,h,t) = x # id_firma, firmante, firma, fecha_firma
            fmtime =  strftime( "%Y-%m-%d %X", localtime(t))
            if f in firmas_previas:
                h = firmas_previas[f]
            for i in range(len(h),0,-4):
                h= h[:i] + " " + h[i:]
            f = f if f else ""
            asello.append(" | ".join(("Firma: " + f,h[-15:],fmtime)))
            f_cert = max( f_cert, t ) if t else f_cert
    fmtime = strftime( "%Y-%m-%d %X", localtime(f_cert)) if f_cert else ""
    return (fmtime," | ".join(asello))


def watermark(qrimg,sello):
    #print(qrimg)
    with open(watermarkfile, encoding="utf-8", errors="surrogateescape") as f:
        try:
            all_html = f.read()
        except Exception as e:
            print("Error wmf:",str(e))
            all_html = ""
    if not all_html:
        return "Error 2 marca de agua"
    with open(qrimg,"rb") as f:
        binimg = f.read()
    (dir,n)     = os.path.split(qrimg)
    iniimgstr   = "<office:binary-data>"
    endimgstr   = "</office:binary-data>"
    inisellostr = '<text:span text:style-name="T1"> '
    endsellostr = " </text:span>"
    #inisellostr = '<text:span text:style-name="T1">Firma electrónica SICOR / TSJCDMX -- '
    #endsellostr = " -- SICOR / TSJCDMX --</text:span>"
    #"".join(map(chr, bytes)
    # replace_image = iniimgstr + base64.b64encode("".join(map(chr, binimg))) + endimgstr
    # gives:  'str' does not support the buffer interface
    
    replace_image = iniimgstr + base64.b64encode( binimg ).decode() + endimgstr
    m = re.search(r'\<Image QR /\>',all_html,re.DOTALL) #  re.IGNORECASE
    if m:
        inicio   = all_html[:m.start()]
        cierre   = all_html[m.end():]
        all_html = inicio + replace_image + cierre
    else:
        print("Error: Image QR se encontró en plantilla.")
        sys.exit(1)

    replace_sello = inisellostr + sello + endsellostr
    m = re.search(r'\<Text sello /\>',all_html,re.DOTALL) #  re.IGNORECASE
    if m:
        inicio = all_html[:m.start()]
        cierre = all_html[m.end():]
        all_html = inicio + replace_sello + cierre
    else:
        print("Error: Text sello no se encontró en plantilla.")
        sys.exit(1)
    owatermarkfile = os.path.join(dir,"watermark.fodt")
    with open(owatermarkfile,"w",encoding="utf-8") as f:
        try:
            f.write(all_html)
        except Exception as e:
            all_html = ""
        return to_pdf(owatermarkfile)
    return "Error marca de agua."

     
def to_pdf(fsavename):
    (root, ext) = os.path.splitext(fsavename)
    tname = root + ".txt"
    e = ""
    stderrdata = ""
    oproc = {}
    try:
        f = open(tname,"wt")
        oproc = subprocess.Popen(["/usr/bin/env","/usr/bin/ods2pdf", fsavename],
                                 stdout=subprocess.PIPE,
                                 stderr=subprocess.PIPE,
                                 env={'PATH': '/usr/bin:/bin'})
        (stdoutdata, stderrdata) = oproc.communicate()
    except Exception as e:
        f.write("Error (e):", str(e))
        return "Error convirtitiendo a pdf"
    toproc = str(type(oproc))
    f.write("type:\n"     + toproc + "\n")
    # if stderrdata or (oproc and toproc=="<class 'subprocess.Popen'>") and oproc.wait() != 0:
    if oproc.wait() != 0 or stderrdata:
        sname = tname
        f.write("\n\nstdout:\n" + stdoutdata.decode())
        f.write("\n\nstderr:\n" + stderrdata.decode())
        f.close()
        return "Error 27 convirtitiendo a pdf"
    else:
        sname = tname.replace('.txt','.pdf')
        f.close()
        os.remove(tname)
    del oproc
    return sname

# preparar PDF watermark
def sellos_firmas(pathname,pdfOfile):
    #print("En sellos")
    #print(pathname)
    # checar id_acuerdo en firma con firmado not NULL
    # obtener sha256 del archivo
    dir="/san/www/html/sicor_extendido_80/storage/app/firmados/"
    id_acuerdo=""
    sha256=""
    gestor_documental=""
    qrimg   = makeqr(dir,pathname,sha256,gestor_documental)
    # preparar sello y colocar en PDF
    #AQUI PUEDE QUE SIRVA
    #fecha = "<text:line-break/>"
    #if isinstance(fecha_pub, datetime.datetime):
    #    fecha += "Fecha de publicación: " + fecha_pub.isoformat()
    #elif isinstance(fecha_pub, datetime.date):
    #    fecha += "Fecha de publicación: " + fecha_pub.isoformat()
    #elif isinstance(fecha_cert, datetime.datetime):
    #    fecha += "No Publicado | Fecha del certificado: " + fecha_cert.isoformat()
    #nas = "NAS: " + nas
    #sello = " | ".join((juzgado,"Clave: " + expediente,"Documento: " + acuerdo,firmas,fecha,nas))
    path = "/san/www/html/sicor_extendido_80/storage/app/firmados/firma"+pathname+".txt"
    #print(path)
    days_file = open(path,'r')
    sello = days_file.readline()
    return (qrimg,sello)

def firma_pdf(pathname,pdfOfile):
    (dir,n)     = os.path.split(pdfOfile)
    try:
        qrimg,sello = sellos_firmas(pathname,pdfOfile)
    except Exception as e:
        return ""

    try:
        wm    = watermark(qrimg,sello)
    except Exception as e:
        print("Error produciendo marca de agua %s" % str(e))
        return ""

    ofile = pdfOfile.replace(".pdf","2.pdf")
    tname = wm.replace(".pdf",".txt")
    # merge de los PDFs
    try:
        f = open(tname,"wt")
        # print("Calling:",["/usr/bin/pdftk",  pdfOfile,"multibackground", wm,"output",ofile])
        oproc = subprocess.Popen(["/usr/bin/pdftk",  pdfOfile,
                                  "multistamp", wm,
                                  "output",          ofile],
                                 stdout=subprocess.PIPE,
                                 stderr=subprocess.PIPE,
                                 env={'PATH': '/usr/bin:/bin'})
        (stdoutdata, stderrdata) = oproc.communicate()
    except Exception as e:
        f.write("Error (e):", str(e))
        f.close()
        return "Error 43 firma pdf"
    if oproc.wait() != 0 or stderrdata:
        sname = tname
        f.write("\n\nstdout:\n" + stdoutdata.decode())
        f.write("\n\nstderr:\n" + stderrdata.decode())
        f.close()
        return "Error 31 convirtitiendo sello"
    else:
        f.close()
        os.remove(tname)
    del oproc

    return ofile

def extrae_firmas(pathname):
    all_html = ""
    with open(pathname,"rt") as f:
        try:
            all_html = f.read()
        except UnicodeDecodeError as e:
            if debugis and log_enabled: logger.debug("extrae_firmas UnicodeDecodeError:",str(e))
            with open(pathname,encoding="latin-1") as g:
                try:
                    all_thml = g.read()
                except Exception as e2:
                    if debugis and log_enabled: logger.debug("extrae_firmas read latin-1:",str(e2))
                    return
        except Exception as e3:
            if debugis and log_enabled: logger.debug("extrae_firmas read:",str(e3))
            return
    usuarios = []
    # - Firmante -
    try:
        t = re.findall(r'Firmante: ([0-9A-Z]*)',all_html,re.DOTALL)
    except Exception as e:
        if debugis and log_enabled: logger.debug("extrae_firmas firmante:",str(e))
        return
    for m in t:
        usuarios.append(m)
    # - Firma -
    try:
        t = re.findall(r'Firma\s[^<]*\sFin[\s-]*([^<]*)',all_html,re.DOTALL)
    except Exception as e:
        if debugis and log_enabled: logger.debug("extrae_firmas firma:",str(e))
        return
    # ([^\<]*)\</pre\>
    for m in t:
        m = m.replace("\n","")
        try:
            f = usuarios.pop()
            firmas_previas[f] = m
            # print("Firma:",f,m)
        except:
            pass
    return

#try:
#    import MySQLdb
#    db = MySQLdb.connect( host="172.16.159.140",
#                           db=DB_name,
#                           user=DB_user,
#                           passwd=DB_pass,
#                           charset="utf8",
#                           connect_timeout=4 )

#except Exception as e:
#    print("Error 3: Carga driver de la base de datos: %s" % str(e)) # Failed to load MySQLdb
#    sys.exit(1)

#cursor = db.cursor()

if testing:
    watermarkfile = "/mnt/ProjectsR1/home/mdragon/rabbitmq/plantilla_sellosQR_v7.fodt"
    qrimg         = "/mnt/ProjectsR1/home/mdragon/rabbitmq/qr.png"
    pdfOfile      = "/san/www/public_html/temporales/rpt_dkg7phwn/resoluciones.pdf"
    pathname      = "/files/firmados/2014/12/18/09/1418917758482.htm"
    # (dir,n)  = os.path.split(pdfOfile)
    # rt = watermark(qrimg,sello,dir)
    # print(rt)
    # (qrimg,sello) = sellos_firmas(pathname, pdfOfile)
    elapsed = (time() - start_time) or 1e-6
    print("\n\nInit: %.4f secs." % elapsed)
    start_time = time()
    print(firma_pdf(pathname, pdfOfile),"bk:")
    elapsed = (time() - start_time) or 1e-6
    print("\n\nElapsed: %.4f secs." % elapsed)
    print(strftime("%X",localtime()))
    sys.exit(0)
