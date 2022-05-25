SELECT
u.usuario 'Usuario', 
CONCAT( COALESCE(ip.nombres,''), COALESCE(CONCAT(' ',ip.paterno),''), COALESCE(CONCAT(' ',ip.materno),'') ) 'Nombre', 
ip.nacimiento 'Fecha de nacimiento', REPLACE(ip.direccion,'|','|') 'Dirección', ip.telefono 'Teléfono local', ip.movil 'Teléfono movil', 
u.correo 'Correo electrónico', ip.despacho 'Despacho', IF(LOCATE('#',u.cedula)=0, u.cedula, '') 'Cédula', 
IF(ISNULL(ue.id_usuario),'Portal',ue.usuario) 'Ejecutivo', 
FROM_UNIXTIME(u.id_usuario/1000) 'Fecha de registro',
SUM(su.seguimiento) 'Expedientes totales contratados', 
SUM(su.incluidos) 'Expedientes incluidos contratados', 
SUM(su.adicionales) 'Expedientes adicionales contratados', 
SUM(IF(uj.estatus='aprobado',1,0)) 'Expedientes aprobados solicitados', 
SUM(IF(uj.estatus='por revisar',1,0)) 'Expedientes en revisión solicitados',
MIN( IF(uj.fecha_permiso='0000-00-00', NULL, uj.fecha_permiso)) 'Fecha de autorización del primer expediente',
CONCAT('') 'Primer expediente solicitado',
CONCAT('') 'Expedientes renovados solicitados', 
CONCAT('') 'Expedientes revocados solicitados', 
SUM(IF(uj.estatus='rechazado',1,0)) 'Expedientes rechazados solicitados'
FROM usuarios u
LEFT JOIN informacionpersonal ip ON ip.id_usuario=u.id_usuario
LEFT JOIN saldo_usuario su ON su.id_usuario=u.id_usuario AND (su.activo='S' AND su.inicio<=CURDATE() AND su.vencimiento>=CURDATE() )
LEFT JOIN usuario_juicio uj ON uj.id_usuario=u.id_usuario
LEFT JOIN evento e ON e.id_tipo_evento=11 AND e.valores=u.id_usuario 
LEFT JOIN usuarios ue ON ue.id_usuario=e.id_usuario
WHERE u.tipo='tarifado'
GROUP BY u.id_usuario;

