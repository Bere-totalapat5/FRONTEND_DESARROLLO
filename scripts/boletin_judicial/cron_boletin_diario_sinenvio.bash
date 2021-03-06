#!/bin/bash
#
b=`mysql sibjdf -Ne 'SELECT count(*) FROM feriados WHERE fecha=CURRENT_DATE'`
if [ $b -eq 1 ] ; then
    exit
fi
# Go
cd /var/www/scripts/boletin_judicial/
fpub=`mysql sibjdf -e 'select NAD(CURRENT_DATE);' | tail -1`
#date +%Y-%m-%d`
echo "=== Inicio =======================" > /tmp/bj_${fpub}

date >> /tmp/bj_${fpub}
echo "=== Selección de registros =======" >> /tmp/bj_${fpub}
python3 extrae_boletin3_conedictos.py -e -f ${fpub} > /var/www/public_html/temporales72/extrae_boletin_${fpub}.out 2>> /tmp/bj_${fpub}

date >> /tmp/bj_${fpub}
echo "=== Acentuación ==================" >> /tmp/bj_${fpub}
python3 acentua_boletin_mp.py /var/www/public_html/temporales72/extrae_boletin_${fpub}.out >  /var/www/public_html/temporales72/boletin_${fpub}.html 2>> /tmp/bj_${fpub}

date >> /tmp/bj_${fpub}
echo "=== Conversión a PDF =============" >> /tmp/bj_${fpub}
python3 coser_boletin_byrecord.py  /var/www/public_html/temporales72/boletin_${fpub}.html  >> /tmp/bj_${fpub} 2>&1

date >> /tmp/bj_${fpub}
echo "=== Fin ==========================" >> /tmp/bj_${fpub}

b=`sed -n 's!^OK !http://201.163.22.157:8088!p' /tmp/bj_${fpub}`
#python3 distribuye-boletin.py "${b}" /tmp/bj_${fpub}
# python3 email_por_awsses.py "${b}" ${fpub} /tmp/bj_${fpub} >  /tmp/em_${fpub} 2&1
echo to email_por_awsses.py "${b}" ${fpub} /tmp/bj_${fpub}
