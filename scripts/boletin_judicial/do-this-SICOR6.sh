#!/bin/sh
# cron www-data
cd /var/www/scripts/boletin_judicial
OPATH=/var/www/public_html/temporales72
find ${OPATH} -type f +ctime 72 -exec rm -fr {} \+ >/dev/null
fpub=`date +%Y-%m-%d`
echo "http://201.163.22.157:8088/temporales72/boletin_"${fpub}".pdf" > ${OPATH}/extrae_boletin_${fpub}.log
echo "" >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
echo "" >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
echo "== Inicio ==" >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
date >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
echo "== 1 == Extrae Boletin de la Base de Datos para" ${fpub} >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
time python3 extrae_boletin3.py -e -f ${fpub} > ${OPATH}/extrae_boletin_${fpub}.out >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
echo "== 2 == Acentúa y convierte a May/minúsculas" >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
time python3 acentua_boletin_mp.py ${OPATH}/extrae_boletin_${fpub}.out > ${OPATH}/extrae_boletin__${fpub}.html
echo "== 3 == Prepara PDF" >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
time python3 coser_boletin_byrecord.py ${OPATH}/extrae_boletin__${fpub}.html >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
tail -20 /tmp/docs.log >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
echo "== Fin ==" >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
date >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
####---
ls -al ${OPATH}/boletin__${fpub}.*  >> ${OPATH}/extrae_boletin_${fpub}.log 2>&1
python3 distribuye-boletin.py "SICOR Boletín Judicial del ${fpub}" ${OPATH}/extrae_boletin_${fpub}.log
