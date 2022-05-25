DROP VIEW IF EXISTS  `depositos_afiliaciones`;
DROP VIEW IF EXISTS  `arch_afil`;
DROP VIEW IF EXISTS r_depositos_final ;
DROP VIEW IF EXISTS r_depositos_final ;
DROP VIEW IF EXISTS r_depositos_final ;
DROP VIEW IF EXISTS r_depositos_final ;
DROP VIEW IF EXISTS r_depositos_final ;
-- DROP VIEW IF EXISTS
DROP VIEW IF EXISTS  `saldo_usuario_concil`;

CREATE VIEW `arch_afil` AS
SELECT `a`.`id_archivo` AS `id_archivo`,`a`.`cuenta` AS `cuenta`,cast(`a`.`fecha_operacion` as date) AS `fecha`,`f`.`filename` AS `filename`,count(0) AS `movimientos`,sum(`a`.`importe`) AS `importe`
FROM (`afil` `a` 
JOIN `files` `f`)
WHERE (`a`.`id_archivo` = `f`.`id_file`)
GROUP BY `a`.`id_archivo`,`a`.`cuenta`,cast(`a`.`fecha_operacion` as date),`f`.`filename` ;

CREATE VIEW `depositos_afiliaciones` AS 
SELECT `aa`.`id_archivo` AS `id_archivo`,`aa`.`cuenta` AS `cuenta`,`aa`.`fecha` AS `fecha_afil`,`aa`.`movimientos` AS `movimientos`,`aa`.`importe` AS `importe_afil`,`bs`.`id_buzon_santander` AS `id_buzon_santander`,`bs`.`importe` AS `importe_deposito`,cast(`bs`.`fecha_hora` as date) AS `fecha_deposito`
FROM (`buzon_santander` `bs`
LEFT JOIN `arch_afil` `aa` ON(((`bs`.`folio` = `aa`.`cuenta`) AND (`aa`.`fecha` = cast(`bs`.`fecha_hora` as date))))) 
WHERE (`bs`.`cod_oper` = 38) ;

CREATE  VIEW `saldo_usuario_concil` AS (select * from `saldo_usuario` where (`saldo_usuario`.`id_saldo_usuario` > 1346210333668));

CREATE VIEW  r_depositos_final AS (
SELECT b_s.*, s_u.id_saldo_usuario, a.filename, a.mtime, u.usuario, 
CONCAT_WS(  ' ', iper.nombres, iper.paterno, iper.materno ) AS nombre_completo, 
s_u.inicio, s_u.vencimiento, p.nombre as paquete, s_u.id_usuario,
 u2.usuario as ejecutivo, CONCAT_WS(  ' ', iper2.nombres, iper2.paterno, iper2.materno ) AS nombre_completo_ejecutivo,
TIMESTAMP( FROM_UNIXTIME( id_saldo_usuario /1000 ) ) AS fecha_operacion,
s_u.ref_larga as referencia,
s_u.forma_pago,
s_u.id_paquete
FROM saldo_usuario_concil s_u
LEFT OUTER JOIN buzon_santander b_s ON ( b_s.aplicado = s_u.id_saldo_usuario ) 
JOIN informacionpersonal iper ON ( iper.id_usuario = s_u.id_usuario ) 
JOIN paquete p ON ( p.id_paquete = s_u.id_paquete ) 
JOIN usuarios u ON ( u.id_usuario = s_u.id_usuario ) 
LEFT OUTER JOIN usuarios u2 ON ( u2.id_usuario = s_u.operador AND u2.tipo =  'punto_venta') 
LEFT OUTER JOIN informacionpersonal iper2 ON ( iper2.id_usuario = u2.id_usuario )
JOIN files a ON (b_s.id_archivo = a.id_file)
WHERE s_u.forma_pago =  'referenciado'
AND s_u.total > 0
AND b_s.aplicado IS NOT NULL
);
