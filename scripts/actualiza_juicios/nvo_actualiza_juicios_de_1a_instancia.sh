#!/bin/bash
# echo -n "Start: " 
# date

# -- backup
## -- tsd=$(date '+%Y%m%d%H')
## -- fd=`date +/san/backup/%Y/%m/%d`
## -- [ ! -d ${fd} ] && mkdir -p ${fd}
## -- wd=/san/tsjdf
## -- k2=/root/.ssh/k2

# -- 1 --

## Es necesario, o lo realiza root/bkps ?? ## rm ${wd}/sibjdf_*.dump_* 2>/dev/null
## -- mysqldump --routines --triggers --flush-logs sibjdf | split -b 1024M - ${wd}/sibjdf2_${tsd}.dump_

# -- 2 -- ¿qué tenemos?

ssh fsicor 'rm /var/lib/mysql-files/*.ltxt' 2>/dev/null
rm /var/lib/mysql-files/f*ltxt 2>/dev/null

export HOME=/var/www
cd /var/www/scripts/actualiza_juicios

mysql --defaults-file=/root/.sicor.cnf -h fsicor  sibjdf < sibjdf1a2_has_fsicor.sql  &
mysql --defaults-file=/root/.sicor.cnf sibjdf < sibjdf1a2_has_vsicor2.sql &
wait

# -- 3 -- compara

scp -q /var/lib/mysql-files/{faltan2_juzgado.ltxt,faltan2_juicio.ltxt,faltan2_parte.ltxt,faltan2_juicio_partes.ltxt,faltan2_acuerdo.ltxt} fsicor:/var/lib/mysql-files/
ssh fsicor /root/cronjobs/sibjdf1a2_compara.sh
# ssh fsicor 'ls -ltr /var/lib/mysql-files/*ltxt'

# -- 4 -- selecciona los nuevos
mysql --defaults-file=/root/.sicor.cnf < sibjdf1a2_crea_nuevos.sql

scp -q fsicor:/var/lib/mysql-files/{nuevos_juzgado.ltxt,nuevos_juicio.ltxt,nuevos_juicio_partes.ltxt,nuevos_parte.ltxt,nuevos_acuerdo.ltxt} /var/lib/mysql-files/

# echo "===" SICOR nuevos
# ssh fsicor 'wc -l /var/lib/mysql-files/*ltxt'

# -- 5 -- carga los nuevos en SICOR2

mysql --defaults-file=/root/.sicor.cnf sibjdf < sibjdf1a2_06.sql
mysql --defaults-file=/root/.sicor.cnf sibjdf < sibjdf1a2_07.sql

# -- 6 -- limpia el área de trabajo

#ssh fsicor 'rm /var/lib/mysql-files/*.ltxt' 2>/dev/null
#rm /var/lib/mysql-files/f*ltxt 2>/dev/null
touch /var/lib/mysql-files/finished.ltxt

# -- 7 -- comprime el respaldo

## -- for f in ${wd}/sibjdf2_${tsd}.dump_* ; do
## --     xz $f &
## -- done
# echo -n "End: " 
# date
