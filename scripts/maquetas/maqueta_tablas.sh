#!/bin/sh
cd  /var/www/scripts/maquetas
python read_maqueta_from_gDrive-any.py "Maqueta SICOR 2015" Maqueta_tablas 0
# /usr/local/zend/bin/php compilar_tablas.php
cd -
