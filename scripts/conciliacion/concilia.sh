#!/bin/bash
logfile=/opt/Apache/conciliacion/md5-sicor-parser.out
year_month=`date '+%Y/%m'`

date >> ${logfile} 2>&1

cd ~/conciliacion
#/usr/local/bin/Python-2.7/python ~/conciliacion/md5-sicor-parser.py /files/buzon/${year_month} >> ${logfile} 2>&1
/usr/bin/python2 ~/conciliacion/md5-sicor-parser.py /files/buzon/${year_month} >> ${logfile} 2>&1
/usr/bin/python2 ~/conciliacion/md5-sicor-parser.py /files/buzon/${year_month} >> ${logfile} 2>&1
#python2.7
