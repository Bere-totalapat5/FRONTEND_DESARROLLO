#!/usr/bin/python
# -*- coding: utf-8 -*-

verbose    = 1
skip_this  = 0
debug_on   = 0

ya         = set()

import os
import sys
import re
import types
try:
    from hashlib import md5
except:
    from md5 import md5

import MySQLdb
from time import strftime, localtime, time

from p_sicor_buzon import parse_buzon
from p_sicor_afil  import parse_afil

#from stat import ...
#S_IFREG  = 0100000
def ISREG(mode):
    return (mode & 0170000) == 0100000

def do_exit(exit_mode=0):
    db.commit()
    elapsed = (time() - start_time) or 1e-6
    efic = (tfiles + tdirs)/elapsed
    print "\n\nElapsed: %.4f secs. %d files. %d dirs." % (elapsed, tfiles, tdirs)
    print "    %.4f rows/sec.\n" % (efic,)
    db.close()
    sys.exit(exit_mode)

#db = MySQLdb.connect(db="sibjdf",read_default_file="~/.my.cnf")
db = MySQLdb.connect(db="sibjdf",user="sicor",passwd="tsjdf123")

cursor   = db.cursor()

sth_i = """INSERT INTO files ( filename, path_no, size, mtime, md5 )
 VALUES ('%s',%s,%s,'%s','%s')"""

sth_s = """SELECT mtime, size from files
  WHERE path_no=%s
    AND filename=%s"""

sth_m = """SELECT filename, mtime, size from files
    WHERE path_no=%s"""

sth_mn = """SELECT filename, id_file from files
    WHERE path_no=%s
      AND aplicado = 'N'"""

sth_d =  """DELETE FROM files
  WHERE path_no=%s
    AND filename='%s'"""

sth_pthi = """INSERT INTO paths ( path )
  VALUES ('%s')"""

sth_pths = """SELECT path_no from paths
  WHERE path='%s'"""

sth_visited = """SELECT path_no FROM paths
  WHERE path LIKE '%s/%%'"""

sth_dya = """DELETE FROM ya
  WHERE path_no IN (
    SELECT path_no
      FROM paths
     WHERE path LIKE '%s%%')"""

sth_gone = """SELECT p.path_no, f.mtime, f.size,
    concat(p.path, '/', f.filename) AS ffile, f.md5
  FROM paths p, files f
  WHERE f.path_no = p.path_no
  AND p.path_no IN (%s)"""

tfiles = 0
tdirs  = 0

list_dir = []
if len( sys.argv ) > 1:
    list_dir = sys.argv[1:]
    if "--verbose" in list_dir:
        verbose = 1
        list_dir.remove("--verbose")
    if "--skip-this" in list_dir:
        skip_this = 1
        list_dir.remove("--skip-this")

if not len(list_dir) > 0:
    list_dir = [ os.getcwd() ]

skip_dirs = ["/proc","/dev","/sys","/var/run","/usr/obj"]
not_valid_dirs = re.compile(r"(/squid/cache$)|(/spool/squid)|(/oradata$)|(/RECYCLER$)|(/System Volume Information$)|(/pg_database$)|(/pgsql/data$)|(/postgresql/[^/]*/main$)|(/postgres.*data$)|(/\.beagle/TextCache$)|(/linux/proc$)|(/\.thumbnails$)|(/\.mozilla)|(/Mozilla/Firefox/Profile)|(/Thunderbird/Profile)|(Data/Downloading)|(postgresql/.*/base)|(postgresql/.*/main)|(/postgresql/.*/pg_stat_tmp)|(^/var/run)|(^/dev/)|(/\.cache)|(/\.gvf)|(/\.mal)|(/\$Recycle.Bin)|(/System Volume Information|VirtualBox\ VMs|/var/lib/mysql|/var/log/mysql)")

# quote = re.compile(r"'")
quote = re.compile(r"(['\\])")
skip_this_files = {"hiberfil.sys" : 1,
                   "pagefile.sys" : 1
}

sth_mn = """SELECT filename, id_file FROM files
    WHERE path_no=%s
      AND aplicado = 'N'"""
sth_ui = "UPDATES files SET aplicado='%s' WHERE id_file=%s"
def check_by_extension( numpath, rootdir, database ):
    global sth_mn
    fdict = {}
    cursor   = database.cursor()
    cursor.execute( sth_mn % (numpath,))
    for tuple in cursor.fetchall(): # SELECT file, .. aplicado <> 'A'
      fdict[ tuple[0] ] = tuple[1]

    for name, fid in fdict.items():
        pathname = os.path.join(rootdir,name)
        try:
            mStat = os.lstat(pathname)
        except:
            print rootdir + "/"
            print "can't stat skipping:", pathname
            pass
            continue
        if not ISREG( mStat.st_mode ): # is regular file
            print "not a regular file skipping:", pathname
            continue
        try:
            (n,ext3) = name.split('.',1)
        except:
            continue
        # !!! don't skip txt ========================================
        if ext3 in ('log','err','dump','py','php','html'):
            continue
        # !!! don't skip txt ----------------------------------------
        print "EXT#:", n, ext3
        if ext3 == 'zip' and n.startswith('80075698185'):
            if verbose: print "parse_buzon:", fid, pathname
            reval = parse_buzon( pathname, fid, cursor )
            db.commit()
        elif ext3 == 'txt' and (n.endswith('7227588') or
                                n.endswith('7233873')):
            if verbose: print "parse_afil:", fid, pathname
            reval = parse_afil( pathname, fid, cursor )
            db.commit()

        # -- ??  if reval in ('A','P'):
        # -- ??      cursor.execute( sth_ui % (reval, fid))
    return

def process_dir( root, files ):
    global tdirs, tfiles
    printed_pathname = 0
    havent_got_skip = 1

    path_Stat = os.lstat(root)
    pfmtime =  strftime( "%Y-%m-%d %X", localtime(path_Stat.st_mtime))
    # print sth_pths % (quote.sub(r"\\\1", root),)
    cursor.execute( sth_pths % (quote.sub(r"\\\1", root),))
    # print cursor.rowcount
    if cursor.rowcount > 0:
      (path_no,) = cursor.fetchone()
    else:
      print "PATH_NO not found", root
      printed_pathname = 1
      cursor.execute( sth_pthi % (quote.sub(r"\\\1", root),))
      # db.commit()
      cursor.execute( sth_pths % (quote.sub(r"\\\1", root),))
      (path_no,) = cursor.fetchone()

    #? if str(path_no) in bdb: # mark visited
    if path_no in ya:
        ya.remove(path_no)
    # cursor.execute("DELETE FROM ya WHERE path_no=%d" % (path_no,))

    if verbose:
        print "%6d %s" % (path_no, root)
        printed_pathname = 1
    fdict = {}
    cursor.execute( sth_m % (path_no,))

    for tuple in cursor.fetchall(): # SELECT file, mtime, size from files
      fdict[ tuple[0] ] = tuple[1:]

    changes = 0

    for name in files:
        pathname = os.path.join(root,name)
        if skip_this:
            if skip_this_files.has_key(pathname):
                if verbose:
                    uname = pathname.decode("utf8","ignore")
                    uname = uname.encode('utf8','strict')
                    print "Skipping file:", uname
                havent_got_skip = 0
                continue
        try:
            mStat = os.lstat(pathname)
        except:
            if not printed_pathname:
                print root + "/"
                printed_pathname = 1
            print "can't stat:", pathname
            continue
        if not ISREG( mStat.st_mode ): # is regular file
            if verbose:
                if not printed_pathname:
                    print root + "/"
                    printed_pathname = 1
                print "not a file:", pathname
            continue
        tfiles += 1

        try:
            uname = name.decode("utf8","ignore")
            uname = uname.encode('utf8','strict')
        except:
            print "Not unicode:", name
            continue

        fmtime =  strftime( "%Y-%m-%d %X", localtime(mStat.st_mtime))

        dict_key = None
        if uname in fdict:
            dict_key = uname
            if ((mStat.st_size & 0x7fffffff) == fdict[ uname ][1]) and \
               (fmtime == str(fdict[ uname ][0])):
                fdict[ uname ] = None
                continue
        if dict_key:
            sqlname = quote.sub(r"\\\1", uname)
            if not printed_pathname:
                print root + "/"
                printed_pathname = 1
            print uname,\
                fmtime,"<>", fdict[ dict_key ][0],\
                mStat.st_size, "<>", fdict[ dict_key ][1]
            cursor.execute( sth_d % (path_no, sqlname))
            changes = 1

        if not os.access(pathname, os.R_OK):
            # fullfilename = os.path.join(root,name)
            # fn = fullfilename.decode('utf8','strict')
            print "Can't read file:", pathname.encode('utf8','strict')
            continue


        f = open(pathname,"rb")
        fmd5 = md5()
        t = f.read(32768)
        try:
            while t: #
                fmd5.update(t)
                t = f.read(32768)
            f.close()
            fmd5 = fmd5.hexdigest()
        except:
            print "Error reading file:", pathname
            continue

        try:
            sqlname = quote.sub(r"\\\1", uname)
            cursor.execute( sth_i % (sqlname, path_no,mStat.st_size,
                                     fmtime, fmd5))
            changes = 1
            if verbose:
                print "  +", sqlname, mStat.st_size, fmtime
        except Exception, e:
            print "SQL Error sadj files:", e, sqlname

        fdict[ dict_key ] = None

    if havent_got_skip:

        for n in fdict:
            if fdict[n] is None:
                continue

            pathname = os.path.join(root,n)
            try:
                mStat = os.lstat(pathname)
            except:
                if not printed_pathname:
                    print root + "/"
                    printed_pathname = 1
                print "Removed:", path_no, n
                sqlname = quote.sub(r"\\\1", n)
                cursor.execute( sth_d % (path_no, sqlname))
                changes = 1
                continue
            if not ISREG( mStat.st_mode ): # is regular file
                if not printed_pathname:
                    print root + "/"
                    printed_pathname = 1
                print "Remove ISREG:", path_no, n
                continue
            print "False Remove:", path_no, pathname

    if changes:
        db.commit()
        check_by_extension( path_no, root, db )
        db.commit()

start_time = time()
if skip_this:
    if verbose: print "Reading /tmp/skipthis"
    f = open("/tmp/skipthis","r")
    for l in f:
        skip_this_files[l[:-1]] = 1
    f.close()

for this_dir in list_dir:
    if not os.path.isdir( this_dir ):
        print "Not a dir:", this_dir
        continue

    dirname = os.path.realpath(this_dir)
    dirname = dirname.decode('utf8','ignore')
    dirname = dirname.encode('utf8','strict')
    if not os.path.isdir( dirname ):
        print "Error:", dirname, ": utf8 error, not a dir (",this_dir,")"
        do.exit(1) # continue

    cursor.execute( sth_visited % (quote.sub(r"\\\1", dirname),))
    ya.clear()
    for (t,) in cursor.fetchall():
        ya.add(t)
    if debug_on:
        print "Testing path_no(s)", ",".join([ str(t) for t in ya ])
    if verbose:
        print "DIR:", dirname, "has", len(ya), "paths."

    i = 1
    mStat = os.lstat(dirname)
    for root, dirs, files in os.walk(dirname):
        i += 1
        dont_traverse = 0
        mStat = os.lstat(root)
        if root in skip_dirs \
               or not_valid_dirs.search( root ):
            dont_traverse = 1
            if verbose: print "Skipping:", root, ":", ", ".join( dirs )
            for d in dirs:
                skip_dirs.append(os.path.join(root, d))
            # continue
        tdirs += 1
        process_dir(root,files)
        # find unaccessable dirs and remove them from TEMP TABLE or they will be GONE
        for d in dirs:
            dn = d.decode('utf8','ignore')
            dn = dn.encode('utf8','strict')
            dn = os.path.join(root, dn)
            if not os.access(dn, os.R_OK):
                print "Can't read dir:",dn

                cursor.execute(sth_visited % (quote.sub(r"\\\1", dn),))
                if cursor.rowcount > 0:
                    for (x,) in cursor.fetchall():
                        if path_no in ya:
                            ya.remove(x)

    nv_paths = [ str(t) for t in ya ]

    if nv_paths:
        dpaths = ", ".join(nv_paths)
        if debug_on:
            print "Dpaths:", dpaths

        cursor.execute(sth_gone % (dpaths,))
        for tuple in cursor.fetchall(): # SELECT mtime, size, file
            print "GONE:\t" + "\t".join([str(x) for x in tuple])

        print "DELETE FROM files WHERE path_no IN (" + dpaths + ");"
        cursor.execute("DELETE FROM files WHERE path_no IN (" + dpaths + ")")

        print "DELETE FROM paths WHERE path_no IN (" + dpaths + ");"
        cursor.execute( "DELETE FROM paths WHERE path_no IN (" + dpaths + ")")
        del dpaths
        del nv_paths

        ya.clear()

    db.commit()
    if verbose: print skip_dirs
do_exit()
