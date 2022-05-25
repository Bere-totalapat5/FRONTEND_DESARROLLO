#!/bin/bash
logfile=/opt/Apache/conciliacion/md5-sicor-parser.out
year_month=`date '+%Y/%m'`

date >> ${logfile} 2>&1

cd ~/conciliacion
/usr/local/bin/python2.7 ~/conciliacion/md5-sicor-parser.py /files/buzon/${year_month} >> ${logfile} 2>&1
/usr/local/bin/python2.7 ~/conciliacion/md5-sicor-parser.py /files/buzon/${year_month} >> ${logfile} 2>&1
