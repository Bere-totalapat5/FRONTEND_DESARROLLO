SELECT
u.usuario 'Usuario',
CONCAT( COALESCE(ip.nombres,''), COALESCE(CONCAT(' ',ip.paterno),''), COALESCE(CONCAT(' ',ip.materno),'') ) 'Nombre',
p.nombre 'Paquete', IF(ISNULL(su.ref_larga), id_saldo_usuario, su.ref_larga) 'Referencia', 
FROM_UNIXTIME(id_saldo_usuario/1000) 'Fecha de registro SICOR',
IF(su.forma_pago='referenciado',bz.fecha_hora,a.fecha_operacion) 'Fecha de pago', su.inicio 'Fecha inicio', su.vencimiento 'Fecha término', 
IF(su.forma_pago='credito', 'Internet', IF(su.forma_pago='referenciado', 'Depósito', 'Terminal')) 'Forma de pago', 
CONCAT('$',su.total) 'Monto pagado',
su.periodos 'Meses contratados', su.operacion 'No. de autorización', 
IF(ISNULL(ue.id_usuario),'Portal',ue.usuario) 'Ejecutivo', 
su.recibo 'No. de factura'
FROM saldo_usuario su
LEFT JOIN usuarios u ON u.id_usuario=su.id_usuario
LEFT JOIN informacionpersonal ip ON ip.id_usuario=su.id_usuario
LEFT JOIN usuarios ue ON ue.id_usuario=su.operador
LEFT JOIN paquete p ON p.id_paquete=su.id_paquete
LEFT JOIN buzon_santander bz ON bz.aplicado=su.id_saldo_usuario
LEFT JOIN afil a ON a.aplicado=su.id_saldo_usuario
WHERE su.activo='S'

