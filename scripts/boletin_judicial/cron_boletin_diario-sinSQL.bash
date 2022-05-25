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
echo "=== Inicio =======================" > /tmp/sbj_${fpub}

date >> /tmp/sbj_${fpub}
echo "=== Selección de registros =======" >> /tmp/sbj_${fpub}
python3 extrae_boletin3.py -f ${fpub} > /var/www/public_html/temporales72/extrae_boletin_${fpub}.out 2>> /tmp/sbj_${fpub}

date >> /tmp/sbj_${fpub}
echo "=== Acentuación ==================" >> /tmp/sbj_${fpub}
python3 acentua_boletin_mp.py /var/www/public_html/temporales72/extrae_boletin_${fpub}.out >  /var/www/public_html/temporales72/boletin_${fpub}.html 2>> /tmp/sbj_${fpub}

date >> /tmp/sbj_${fpub}
echo "=== Conversión a PDF =============" >> /tmp/sbj_${fpub}
python3 coser_boletin_byrecord.py  /var/www/public_html/temporales72/boletin_${fpub}.html  >> /tmp/sbj_${fpub} 2>&1

date >> /tmp/sbj_${fpub}
echo "=== Fin ==========================" >> /tmp/sbj_${fpub}

b=`sed -n 's!^OK !http://201.163.22.157:8088!p' /tmp/sbj_${fpub}`
#python3 distribuye-boletin.py "${b}" /tmp/sbj_${fpub}
python3 email_por_awsses.py "${b}" ${fpub} /tmp/sbj_${fpub} >/tmp/sem_${fpub} 2>&1
