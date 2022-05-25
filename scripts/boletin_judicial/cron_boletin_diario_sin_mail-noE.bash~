#!/bin/bash
#
#-- b=`mysql sibjdf -Ne 'SELECT count(*) FROM feriados WHERE fecha=CURRENT_DATE'`
#-- if [ $b -eq 1 ] ; then
#--     exit
#-- fi
# Go
cd /var/www/scripts/boletin_judicial/
# - # - # fpub=`mysql sibjdf -e 'select NAD(CURRENT_DATE);' | tail -1`
fpub='2016-02-24'
#date +%Y-%m-%d`
echo "=== Inicio =======================" > /tmp/bj_${fpub}

date >> /tmp/bj_${fpub}
echo "=== Selección de registros =======" >> /tmp/bj_${fpub}

python3 extrae_boletin3_conedictos.py -e -f ${fpub} > /var/www/public_html/temporales72/extrae_boletin_${fpub}.out 2>> /tmp/bj_${fpub}
#no_update python3 extrae_boletin3_conedictos.py -f ${fpub} > /var/www/public_html/temporales72/extrae_boletin_${fpub}.out 2>> /tmp/bj_${fpub}

date >> /tmp/bj_${fpub}
echo "=== Acentuación ==================" >> /tmp/bj_${fpub}
python3 acentua_boletin_mp.py /var/www/public_html/temporales72/extrae_boletin_${fpub}.out >  /var/www/public_html/temporales72/boletin_${fpub}.html 2>> /tmp/bj_${fpub}

date >> /tmp/bj_${fpub}
echo "=== Conversión a PDF =============" >> /tmp/bj_${fpub}
#NO python3 coser_boletin_byrecord.py /var/www/public_html/temporales72/boletin_${fpub}.html  >> /tmp/bj_${fpub} 2>&1
python3 coser_boletin_byrecord_con_edictos.py /var/www/public_html/temporales72/boletin_${fpub}.html  >> /tmp/bj_${fpub} 2>&1
date >> /tmp/bj_${fpub}

echo "=== Autos =============" >> /tmp/bj_${fpub}
python3 autos2.py -f  ${fpub} >> /tmp/autos_${fpub}
/usr/bin/pdftk $(awk '/pdf$/{printf "/var/www/public_html/%s ", $NF}' /tmp/autos_${fpub}  /tmp/bj_${fpub}) cat output /var/www/public_html/temporales72/boletin.pdf
mv /var/www/public_html/temporales72/boletin.pdf $(awk '/pdf$/{print "/var/www/public_html/" $NF}'  /tmp/bj_${fpub})
echo "=== Fin ==========================" >> /tmp/bj_${fpub}
b=`sed -n 's!^OK !http://201.163.22.157:8088!p' /tmp/bj_${fpub}`
echo $b
#NO envía por mail:
# python3 email_por_awsses.py "${b}" ${fpub} /tmp/bj_${fpub} >  /tmp/em_${fpub} 2&1
echo "-----------------------" /tmp/bj_${fpub} "-----------------------"
cat /tmp/bj_${fpub}
