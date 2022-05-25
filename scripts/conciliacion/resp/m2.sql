SELECT 
u.usuario as "Usuario",
CONCAT_WS(' ', inf.nombres, inf.paterno, inf.materno) "Nombre",
p.nombre "Paquete",
s_u.ref_larga "Referencia",
TIMESTAMP(FROM_UNIXTIME(id_saldo_usuario/1000)) "Fecha de Registro SICOR",
a.fecha_operacion "fecha de Pago",
s_u.inicio "Fecha Inicio", 
s_u.vencimiento "Fecha Término",
s_u.forma_pago "Forma de Pago",
s_u.total "Monto Pagado", 
s_u.periodos "Meses Contratados",
a.num_autorizacion "Num. Autorización",
CONCAT_WS(  ' ', iper2.nombres, iper2.paterno, iper2.materno ) "Ejecutivo",
s_u.recibo "Factura" 
FROM informacionpersonal inf, files f, saldo_usuario s_u
LEFT JOIN afil a ON (
a.aplicado = s_u.id_saldo_usuario
-- AND s_u.operacion = a.num_autorizacion 
-- AND substr(cast(a.tarjeta as char), -4) = s_u.tarjeta 
)
LEFT JOIN paquete p ON (p.id_paquete = s_u.id_paquete)
LEFT JOIN usuarios u ON (u.id_usuario = s_u.id_usuario) 
LEFT OUTER JOIN informacionpersonal iper2 ON ( iper2.id_usuario = s_u.operador AND s_u.operador > 0) 
WHERE s_u.forma_pago <> "referenciado"
AND s_u.tarjeta is not null
AND s_u.operacion is not null 
AND a.id_archivo=f.id_file 
AND s_u.id_usuario=inf.id_usuario 
