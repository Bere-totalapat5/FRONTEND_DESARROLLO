#!/bin/bash
logfile=/opt/Apache/conciliacion/md5-sicor-parser.out
year_month=`date '+%Y'`

date >> ${logfile} 2>&1

cd ~/conciliacion
/usr/local/bin/python2.7 ~/conciliacion/md5-sicor-parser.py /files/buzon/${year_month} >> ${logfile} 2>&1
/usr/local/bin/python2.7 ~/conciliacion/md5-sicor-parser.py /files/buzon/${year_month} >> ${logfile} 2>&1

cd /opt/Apache/conciliacion

for f in *-win.csv *.bak ; do rm ${f} ; done

echo 'select * from afil' | mysql sibjdf > afil_completo.csv 2>> ${logfile} 
echo 'select * from buzon_santander' | mysql sibjdf > bs_completo.csv 2>> ${logfile} 

# --  referenciados_solosicor
echo "SELECT s_u.ref_larga as Referencia,
u.usuario as Usuario,
s_u.total as Importe,
TIMESTAMP(FROM_UNIXTIME(id_saldo_usuario/1000)) as F_Operacion,
p.nombre as Paquete
FROM saldo_usuario s_u
LEFT JOIN paquete p ON (p.id_paquete = s_u.id_paquete)
LEFT JOIN usuarios u ON (u.id_usuario = s_u.id_usuario)
LEFT OUTER JOIN conciliacion c ON (c.id_susicor = s_u.id_saldo_usuario)
WHERE s_u.forma_pago ='referenciado'
  AND c.id_susicor IS NULL
" | mysql sibjdf > referenciados_solosicor.csv 2>> ${logfile} 

# -- referenciados_conciliados
echo "SELECT s_u.ref_larga as Referencia,
u.usuario as Usuario,
s_u.total as Importe,
TIMESTAMP(FROM_UNIXTIME(id_saldo_usuario/1000)) as F_Operacion,
p.nombre as Paquete
FROM saldo_usuario s_u
LEFT JOIN paquete p ON (p.id_paquete = s_u.id_paquete)
LEFT JOIN usuarios u ON (u.id_usuario = s_u.id_usuario)
LEFT OUTER JOIN conciliacion c ON (c.id_susicor = s_u.id_saldo_usuario)
WHERE s_u.forma_pago ='referenciado'
  AND c.id_susicor IS NOT NULL
" | mysql sibjdf > referenciados_conciliados.csv 2>> ${logfile} 

# -- referenciados_solobanco
echo "SELECT b_s.referencia_santander as Referencia,
b_s.fecha_hora as F_Pago,
b_s.importe as Importe,
b_s.cod_oper as Cod_Oper,
b_s.folio as Folio,
b_s.signo as Signo,
b_s.centro_oper as Centro_Oper,
b_s.descripcion as Descripcion
FROM buzon_santander b_s
LEFT OUTER JOIN conciliacion c ON (c.id_deposito = b_s.id_buzon_santander)
WHERE b_s.cod_oper = 0 AND c.id_deposito IS NULL
" | mysql sibjdf > referenciados_solobanco.csv 2>> ${logfile} 

# -- tarjetas_conciliados
echo "SELECT
s_u.forma_pago as "Forma_pago",
u.usuario	      as Nombre,
p.nombre	      as paquete,
TIMESTAMP(FROM_UNIXTIME(id_saldo_usuario/1000)) as F_Operacion,
s_u.total	      as importe,
a.cuenta	      as cuenta,
s_u.tarjeta	      as TC,
s_u.operacion	      as Operacion,
a.id_archivo as Archivo_AFIL,
a.aplicado as Aplicado,
s_u.id_saldo_usuario as id,
a.tipo_tc	      as Tipo_tarjeta,
a.tarjeta	      as Tarjeta_Credito,
a.visamc	      as visamc,
a.importe	      as Importe_TC,
a.num_autorizacion    as Num_Autorizacion
FROM saldo_usuario s_u
LEFT JOIN afil a ON (
a.aplicado = s_u.id_saldo_usuario
-- AND s_u.operacion = a.num_autorizacion 
-- AND substr(cast(a.tarjeta as char), -4) = s_u.tarjeta 
)
LEFT JOIN paquete p ON (p.id_paquete = s_u.id_paquete)
LEFT JOIN usuarios u ON (u.id_usuario = s_u.id_usuario)

WHERE s_u.forma_pago ='terminal'
AND s_u.tarjeta is not null
AND s_u.operacion is not null
"  | mysql sibjdf > tarjetas_conciliados.csv 2>> ${logfile} 

# -- internet_conciliados
echo "SELECT
s_u.forma_pago as "Forma_pago",
u.usuario	      as Nombre,
p.nombre	      as paquete,
TIMESTAMP(FROM_UNIXTIME(id_saldo_usuario/1000)) as F_Operacion,
s_u.total	      as importe,
a.cuenta	      as cuenta,
s_u.tarjeta	      as TC,
s_u.operacion	      as Operacion,
a.id_archivo as Archivo_AFIL,
a.aplicado as Aplicado,
s_u.id_saldo_usuario as id,
a.tipo_tc	      as Tipo_tarjeta,
a.tarjeta	      as Tarjeta_Credito,
a.visamc	      as visamc,
a.importe	      as Importe_TC,
a.num_autorizacion    as Num_Autorizacion
FROM saldo_usuario s_u
LEFT JOIN afil a ON (
a.aplicado = s_u.id_saldo_usuario
-- AND s_u.operacion = a.num_autorizacion 
-- AND substr(cast(a.tarjeta as char), -4) = s_u.tarjeta 
)
LEFT JOIN paquete p ON (p.id_paquete = s_u.id_paquete)
LEFT JOIN usuarios u ON (u.id_usuario = s_u.id_usuario)

WHERE s_u.forma_pago ='terminal'
AND s_u.tarjeta is not null
AND s_u.operacion is not null
" | mysql sibjdf > internet_conciliados.csv 2>> ${logfile} 

# -- terminal_conciliados
echo "SELECT
s_u.forma_pago as "Forma_pago",
u.usuario	      as Nombre,
p.nombre	      as paquete,
TIMESTAMP(FROM_UNIXTIME(id_saldo_usuario/1000)) as F_Operacion,
s_u.total	      as importe,
a.cuenta	      as cuenta,
s_u.tarjeta	      as TC,
s_u.operacion	      as Operacion,
a.id_archivo as Archivo_AFIL,
a.aplicado as Aplicado,
s_u.id_saldo_usuario as id,
a.tipo_tc	      as Tipo_tarjeta,
a.tarjeta	      as Tarjeta_Credito,
a.visamc	      as visamc,
a.importe	      as Importe_TC,
a.num_autorizacion    as Num_Autorizacion
FROM saldo_usuario s_u
LEFT JOIN afil a ON (
a.aplicado = s_u.id_saldo_usuario
-- AND s_u.operacion = a.num_autorizacion 
-- AND substr(cast(a.tarjeta as char), -4) = s_u.tarjeta 
)
LEFT JOIN paquete p ON (p.id_paquete = s_u.id_paquete)
LEFT JOIN usuarios u ON (u.id_usuario = s_u.id_usuario)

WHERE s_u.forma_pago ='terminal'
AND s_u.tarjeta is not null
AND s_u.operacion is not null
" | mysql sibjdf > terminal_conciliados.csv 2>> ${logfile} 

# -- afil conciliados
echo "SELECT * FROM depositos_afiliaciones" | mysql sibjdf > afil_conciliados.csv 2>> ${logfile} 

# -- terminal_solosicor
echo "SELECT 
u.usuario	      as Nombre,
p.nombre	      as paquete,
TIMESTAMP(FROM_UNIXTIME(id_saldo_usuario/1000)) as F_Operacion,
s_u.total	      as importe,
a.cuenta	      as cuenta,
s_u.tarjeta	      as TC,
s_u.operacion	      as Operacion
FROM saldo_usuario s_u
LEFT JOIN paquete p ON (p.id_paquete = s_u.id_paquete)
LEFT JOIN usuarios u ON (u.id_usuario = s_u.id_usuario)
LEFT JOIN afil a ON (a.aplicado = s_u.id_saldo_usuario)
WHERE s_u.forma_pago ='terminal'
  AND a.id IS NULL
" | mysql sibjdf > terminal_solosicor.csv 2>> ${logfile} 

# -- terminal_solobanco
echo "SELECT * FROM afil 
WHERE aplicado IS NULL
  AND cuenta = 7227588
" | mysql sibjdf > terminal_solobanco.csv 2>> ${logfile} 

# -- internet_solosicor
echo "SELECT 
u.usuario	      as Nombre,
p.nombre	      as paquete,
TIMESTAMP(FROM_UNIXTIME(id_saldo_usuario/1000)) as F_Operacion,
s_u.total	      as importe,
a.cuenta	      as cuenta,
s_u.tarjeta	      as TC,
s_u.operacion	      as Operacion
FROM saldo_usuario s_u
LEFT JOIN paquete p ON (p.id_paquete = s_u.id_paquete)
LEFT JOIN usuarios u ON (u.id_usuario = s_u.id_usuario)
LEFT JOIN afil a ON (a.aplicado = s_u.id_saldo_usuario)
WHERE s_u.forma_pago ='credito'
  AND a.id IS NULL
" | mysql sibjdf > internet_solosicor.csv 2>> ${logfile} 

# -- internet_solobanco
echo "SELECT * FROM afil 
WHERE aplicado IS NULL
  AND cuenta = 7233873
" | mysql sibjdf > internet_solobanco.csv 2>> ${logfile} 

#M1 (Usuarios registrados)
#echo "Módulo finanzas	Usuarios Registrados" > Usuarios_registrados.csv
#echo "" | mysql sibjdf < ~/conciliacion/m1.sql >> Usuarios_registrados.csv 2>> ${logfile} 
php /var/www/scripts/reportes_conciliacion/FinanzasUsuariosRegistrados.php Usuarios_registrados.csv 


#M2 (Venta de paquetes)
echo "Módulo finanzas	Venta de Paquetes" > Venta_de_paquetes.csv
echo "" | mysql sibjdf < ~/conciliacion/m2.sql >> Venta_de_paquetes.csv 2>> ${logfile}
echo "" >> Venta_de_paquetes.csv 
echo "Paquetes:" >> Venta_de_paquetes.csv 
echo "" | mysql sibjdf < ~/conciliacion/m2t1.sql >> Venta_de_paquetes.csv 2>> ${logfile}
echo "" >> Venta_de_paquetes.csv
echo "Montos:" >> Venta_de_paquetes.csv
echo "" | mysql sibjdf < ~/conciliacion/m2t2.sql >> Venta_de_paquetes.csv 2>> ${logfile}

#M3 (Detalle por usuario)
echo "Módulo finanzas	Detalle por Usuario" > Detalle_por_usuario.csv
echo "" | mysql sibjdf < ~/conciliacion/m3.sql >> Detalle_por_usuario.csv 2>> ${logfile}

#M4 (Solicitudes en seguimiento)
echo "Módulo finanzas	Solicituides en Seguimiento" > Solicitudes_en_seguimiento.csv
echo "" | mysql sibjdf < ~/conciliacion/m4.sql >> Solicitudes_en_seguimiento.csv 2>> ${logfile}

#E5 (Usuarios registrados)
#echo "Módulo ejecutivo	Usuarios Registrados" > Ejec_Usuarios_registrados.csv
#echo "" | mysql sibjdf < ~/conciliacion/e5.sql >> Ejec_Usuarios_registrados.csv 2>> ${log\
#file}
## php /var/www/scripts/reportes_conciliacion/FinanzasUsuariosRegistrados.php Ejec_Usuarios_registrados.csv
cp  Usuarios_registrados.csv  Ejec_Usuarios_registrados.csv

#E6 (Venta de paquetes)
echo "Módulo ejecutivo	Venta de Paquetes" > Ejec_Venta_de_paquetes.csv
echo "" | mysql sibjdf < ~/conciliacion/e6.sql >> Ejec_Venta_de_paquetes.csv  2>> ${log\
file}

rm *.bak >> ${logfile} 2>&1
for f in *.csv
do
  sed -i.bak 's/&\([^ ]\)/& \1/g;s/NULL/\&nbsp;/g' ${f} >> ${logfile} 2>&1
  python ~/csv2dataTable_Tab.py ${f} > ${f%.csv}.html 2>> ${logfile} 
done

for f in *.csv
do
 iconv -f UTF-8 -t WINDOWS-1252 ${f} > ${f%.csv}-win.csv
 sed -i 's/\&nbsp;//g' ${f%.csv}-win.csv
done

# -- compress_selectd_sibjdf-dump.sh 
[ -e /opt/Apache/sibjdump_selectedtables.sql.bz2 ] && rm /opt/Apache/sibjdump_selectedtables.sql.bz2
[ -e /opt/Apache/sibjdump_selectedtables.sql.bz2.cpt ] && rm /opt/Apache/sibjdump_selectedtables.sql.bz2.cpt
mysqldump sibjdf --tables motivos usuarios_registrados depositos_anulados_pend conciliacion paths files afil buzon_santander juzgado_tipojuicio tiporesolucion promovente tramiteinterpuesto tipo_evento edicto paquete feriados transaccion_tarjeta flujo_revision tipojuicio_promovente tipojuicio etapaprocesal juzgado catalogo_juicios autoridad firmante usuarios_resp archivo_conciliado recuperacion_contrasena saldo_usuario lista_espera abogado migracion_juicio usuario_juicio informacionpersonal usuarios mensaje juicio_abogado | bzip2 -9c > /opt/Apache/sibjdump_selectedtables.sql.bz2
ccrypt -k /home/tsjdf/k2 /opt/Apache/sibjdump_selectedtables.sql.bz2

