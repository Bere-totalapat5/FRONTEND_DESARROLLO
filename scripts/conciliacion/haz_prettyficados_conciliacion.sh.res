#!/bin/bash
logfile=/opt/Apache/conciliacion/md5-sicor-parser.out
year_month=`date '+%Y'`

date >> ${logfile} 2>&1

cd ~/conciliacion
/usr/local/bin/python2.7 ~/conciliacion/md5-sicor-parser.py /files/buzon/${year_month} >> ${logfile} 2>&1
/usr/local/bin/python2.7 ~/conciliacion/md5-sicor-parser.py /files/buzon/${year_month} >> ${logfile} 2>&1

# -- compress_selectd_sibjdf-dump.sh 
[ -e /opt/Apache/sibjdump_selectedtables.sql.bz2 ] && rm /opt/Apache/sibjdump_selectedtables.sql.bz2
[ -e /opt/Apache/sibjdump_selectedtables.sql.bz2.cpt ] && rm /opt/Apache/sibjdump_selectedtables.sql.bz2.cpt
mysqldump sibjdf --tables conciliacion paths files afil buzon_santander juzgado_tipojuicio tiporesolucion promovente tramiteinterpuesto tipo_evento edicto paquete feriados transaccion_tarjeta flujo_revision tipojuicio_promovente tipojuicio etapaprocesal juzgado catalogo_juicios autoridad firmante usuarios_resp archivo_conciliado recuperacion_contrasena saldo_usuario lista_espera abogado migracion_juicio usuario_juicio informacionpersonal usuarios mensaje juicio_abogado | bzip2 -9c > /opt/Apache/sibjdump_selectedtables.sql.bz2
ccrypt -k /home/tsjdf/k2 /opt/Apache/sibjdump_selectedtables.sql.bz2

cd /opt/Apache/conciliacion

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

echo "SELECT
u.usuario, 
CONCAT( COALESCE(ip.nombres,''), COALESCE(CONCAT(' ',ip.paterno),''), COALESCE(CONCAT(' ',ip.materno),'') ) nombre, 
ip.nacimiento, REPLACE(ip.direccion,'|','; ') direccion, ip.telefono, ip.movil, u.correo, ip.despacho, 
IF(LOCATE('#',u.cedula)=0, u.cedula, '') cedula, '' Ejecutivo, FROM_UNIXTIME(u.id_usuario/1000) fecha_registro,
SUM(su.seguimiento) expedientes_concentrados, SUM(su.incluidos) expedientes_incluidos, SUM(su.adicionales) expedientes_adicionales, 
SUM(IF(uj.estatus='aprobado',1,0)) expedientes_aprobados, COUNT(uj.id_usuario_juicio) total_de_expedientes, 
SUM(IF(uj.estatus='por revisar',1,0)) expedientes_en_revisióMIN(uj.fecha_permiso) fecha_autorizacion,
'' expedientes_revocados, SUM(IF(uj.estatus='rechazado',1,0)) expedientes_rechazados
FROM usuarios u
LEFT JOIN informacionpersonal ip ON ip.id_usuario=u.id_usuario
LEFT JOIN saldo_usuario su ON su.id_usuario=u.id_usuario AND (su.activo='S' AND su.vencimiento>=CURDATE())
LEFT JOIN usuario_juicio uj ON uj.id_usuario=u.id_usuario
WHERE u.tipo='tarifado'
GROUP BY u.id_usuario
" | mysql sibjdf < ~/conciliacion/m1.sql > Usuarios_registrados.csv 2>> ${logfile} 

#M2 (Venta de paquetes)
echo "SELECT
u.usuario, 
CONCAT( COALESCE(ip.nombres,''), COALESCE(CONCAT(' ',ip.paterno),''), COALESCE(CONCAT(' ',ip.materno),'') ) nombre, 
p.nombre paquete, su.ref_larga referencia, FROM_UNIXTIME(id_saldo_usuario/1000) fecha_registro, 
'' Fecha_pago, su.inicio fecha_inicio, su.vencimiento fecha_termino, IF(su.forma_pago='credito', 'internet', su.forma_pago) Forma_pago, su.total monto_pagado, 
su.periodos meses_contratados, su.operacion numero_autorizacion, IF(ISNULL(ue.id_usuario),'portal',ue.usuario) Ejecutivo, su.recibo numero_factura
FROM saldo_usuario su
LEFT JOIN usuarios u ON u.id_usuario=su.id_usuario
LEFT JOIN informacionpersonal ip ON ip.id_usuario=su.id_usuario
LEFT JOIN usuarios ue ON ue.id_usuario=su.operador
LEFT JOIN paquete p ON p.id_paquete=su.id_paquete
WHERE su.activo='S'" | mysql sibjdf < ~/conciliacion/m2.sql > Venta_de_paquetes.csv 2>> ${logfile}

#M3 (Detalle por usuario)
echo "SELECT
uj.id_usuario_juicio folio, u.usuario usuario, 
IF( ISNULL(j.toca), 
    CONCAT( j.expediente, '/', j.anio, IF(ISNULL(j.bis),'', CONCAT(' ', j.bis, 'Bis')), IF(j.tipo_expediente='expediente', '', CONCAT('(',j.tipo_expediente,')')) ), 
    CONCAT( j.toca, '/', j.anio_toca, IF(ISNULL(j.asunto_toca),'', CONCAT('/', j.asunto_toca)), IF(j.tipo_expediente='expediente', '', CONCAT('(',j.tipo_expediente,')')) )
  ) numero_expediente, 
'' Jurisdiccion, '' Materia, jz.nombre_corto juzgado, '' ejecutivo, 
alta fecha_registro, uj.fecha_permiso fecha_autorizacion, '' fecha_revocacion 
FROM usuario_juicio uj 
LEFT JOIN juicio j ON j.id_juicio=uj.id_juicio 
LEFT JOIN juzgado jz ON jz.codigo=j.juzgado 
LEFT JOIN usuarios u ON u.id_usuario=uj.id_usuario" | mysql sibjdf < ~/conciliacion/m3.sql > Detalle_por_usuario.csv 2>> ${logfile}

#M4 (Solicitudes en seguimiento)
echo "SELECT 
jz.nombre, COUNT(id_usuario_juicio) solicitudes_totales, SUM(IF(uj.estatus='aprobado',1,0)) solicitudes_aprobadas,
 SUM(IF(uj.estatus='por revisar',1,0)) solicitudes_por_revisar,  SUM(IF(uj.estatus='rechazado',1,0)) solicitudes_rechazadas 
FROM usuario_juicio uj 
LEFT JOIN juicio j ON uj.id_juicio=j.id_juicio 
LEFT JOIN juzgado jz ON jz.codigo=j.juzgado 
WHERE (jz.orden>0 AND jz.orden<100) 
OR (jz.orden>1000 AND jz.orden<1076) 
OR (jz.orden>1200 AND jz.orden<1300) 
OR (jz.orden>2000 AND jz.orden<2100) 
OR (jz.orden>2300 AND jz.orden<2400) 
OR (jz.orden>2500 AND jz.orden<2600) 
GROUP BY j.juzgado ORDER BY jz.orden" | mysql sibjdf < ~/conciliacion/m4.sql > Solicitudes_en_seguimiento.csv 2>> ${logfile}

#E5 (Usuarios registrados)
echo "SELECT
u.usuario,
CONCAT( COALESCE(ip.nombres,''), COALESCE(CONCAT(' ',ip.paterno),''), COALESCE(CONCAT(' ',ip.materno),'') ) nombre,
ip.nacimiento, REPLACE(ip.direccion,'|','; ') direccion, ip.telefono, ip.movil, u.correo, ip.despacho,
IF(LOCATE('#',u.cedula)=0, u.cedula, '') cedula, '' Ejecutivo, FROM_UNIXTIME(u.id_usuario/1000) fecha_registro,
SUM(su.seguimiento) expedientes_concentrados, SUM(su.incluidos) expedientes_incluidos, SUM(su.adicionales) expedientes_adicionales,
SUM(IF(uj.estatus='aprobado',1,0)) expedientes_aprobados, COUNT(uj.id_usuario_juicio) total_de_expedientes,
SUM(IF(uj.estatus='por revisar',1,0)) expedientes_en_revisióMIN(uj.fecha_permiso) fecha_autorizacion,
'' expedientes_revocados, SUM(IF(uj.estatus='rechazado',1,0)) expedientes_rechazados
FROM usuarios u
LEFT JOIN informacionpersonal ip ON ip.id_usuario=u.id_usuario
LEFT JOIN saldo_usuario su ON su.id_usuario=u.id_usuario AND (su.activo='S' AND su.vencimiento>=CURDATE())
LEFT JOIN usuario_juicio uj ON uj.id_usuario=u.id_usuario
WHERE u.tipo='tarifado'
GROUP BY u.id_usuario
" | mysql sibjdf < ~/conciliacion/e5.sql > Ejec_Usuarios_registrados.csv 2>> ${log\
file}

#E6 (Venta de paquetes)
echo "SELECT
u.usuario, 
CONCAT( COALESCE(ip.nombres,''), COALESCE(CONCAT(' ',ip.paterno),''), COALESCE(CONCAT(' ',ip.materno),'') ) nombre, 
p.nombre paquete, su.ref_larga referencia, FROM_UNIXTIME(id_saldo_usuario/1000) fecha_registro, 
'' Fecha_pago, su.inicio fecha_inicio, su.vencimiento fecha_termino, su.forma_pago Forma_pago, su.total monto_pagado, 
su.periodos meses_contratados, su.operacion numero_autorizacion, IF(ISNULL(ue.id_usuario),'portal',ue.usuario) Ejecutivo, su.recibo numero_factura
FROM saldo_usuario su
LEFT JOIN usuarios u ON u.id_usuario=su.id_usuario
LEFT JOIN informacionpersonal ip ON ip.id_usuario=su.id_usuario
LEFT JOIN usuarios ue ON ue.id_usuario=su.operador
LEFT JOIN paquete p ON p.id_paquete=su.id_paquete
WHERE su.activo='S'
" | mysql sibjdf < ~/conciliacion/e6.sql > Ejec_Venta_de_paquetes.csv  2>> ${log\
file}

rm *.bak >> ${logfile} 2>&1
for f in *.csv
do
  sed -i.bak 's/NULL/\&nbsp;/g' ${f} >> ${logfile} 2>&1
  python ~/csv2dataTable_Tab.py ${f} > ${f%.csv}.html 2>> ${logfile} 
done
