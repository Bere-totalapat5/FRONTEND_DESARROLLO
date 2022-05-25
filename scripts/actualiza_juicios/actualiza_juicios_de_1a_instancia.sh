#!/bin/bash
export HOME=/var/www

cd /var/www/scripts/actualiza_juicios

ssh vsicor 'rm /tmp/{faltan_juzgado.ltxt,faltan_juicio.ltxt,faltan_parte.ltxt,faltan_juicio_partes.ltxt,faltan_acuerdo.ltxt,nuevos_juzgado.ltxt,nuevos_juicio.ltxt,nuevos_juicio_partes.ltxt,nuevos_parte.ltxt,nuevos_acuerdo.ltxt}' 2>/dev/null
rm -v          /tmp/{faltan_juzgado.ltxt,faltan_juicio.ltxt,faltan_parte.ltxt,faltan_juicio_partes.ltxt,faltan_acuerdo.ltxt,nuevos_juzgado.ltxt,nuevos_juicio.ltxt,nuevos_juicio_partes.ltxt,nuevos_parte.ltxt,nuevos_acuerdo.ltxt}  2>/dev/null
du -sch /tmp/ | tail
time mysql -v < sibjdf1a2_01.sql

scp /tmp/{faltan_juzgado.ltxt,faltan_juicio.ltxt,faltan_parte.ltxt,faltan_juicio_partes.ltxt,faltan_acuerdo.ltxt} vsicor:/tmp

# comm -13 /tmp/faltan_acuerdo.ltxt /tmp/faltan_acuerdo_sicor.ltxt > /tmp/comm-13_acuerdo.ltxt
# mysql -h vsicor  sibjdf_d01 &
# mysql -h vsicor2 sibjdf_d01 &
# wait

time mysql -v < sibjdf1a2_02.sql
time mysql -v < sibjdf1a2_03.sql
time mysql -v < sibjdf1a2_04.sql
time mysql -v < sibjdf1a2_05.sql

scp vsicor:/tmp/{nuevos_juicio.ltxt,nuevos_juicio_partes.ltxt,nuevos_parte.ltxt,nuevos_acuerdo.ltxt} /tmp

time mysql -v < sibjdf1a2_06.sql
time mysql -v < sibjdf1a2_07.sql

ls -l /tmp/{faltan_juzgado.ltxt,faltan_juicio.ltxt,faltan_parte.ltxt,faltan_juicio_partes.ltxt,faltan_acuerdo.ltxt,nuevos_juzgado.ltxt,nuevos_juicio.ltxt,nuevos_juicio_partes.ltxt,nuevos_parte.ltxt,nuevos_acuerdo.ltxt}
wc -l /tmp/{faltan_juzgado.ltxt,faltan_juicio.ltxt,faltan_parte.ltxt,faltan_juicio_partes.ltxt,faltan_acuerdo.ltxt,nuevos_juzgado.ltxt,nuevos_juicio.ltxt,nuevos_juicio_partes.ltxt,nuevos_parte.ltxt,nuevos_acuerdo.ltxt}

du -sch /tmp/ | tail

