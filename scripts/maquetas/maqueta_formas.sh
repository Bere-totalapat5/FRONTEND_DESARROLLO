#!/bin/sh
cd /var/www/scripts/maquetas
python read_maqueta_from_gDrive-any.py 'Maqueta SICOR 2015' 'Maqueta_formas' 1 > formas_json.out 2>&1
# /usr/local/zend/bin/php compilar_formas.php
cd -
