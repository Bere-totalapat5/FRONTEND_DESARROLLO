SELECT u.usuario "Usuario", 
CONCAT_WS( ' ', inf.nombres, inf.paterno, inf.materno ) "Nombre", 
inf.nacimiento AS "Fecha de Nacimiento", 
inf.direccion "Dirección", 
inf.telefono "Teléfono local", 
inf.movil "Teléfono móvil", 
u.correo "Correo Electronico", 
inf.despacho "Despacho", 
u.cedula "Cédula", 
TIMESTAMP(FROM_UNIXTIME(e.id_evento/1000)) "Fecha de Registro", 
IFNULL(SUM(s_u.periodos),0) "Expedientes Contratados", 
IFNULL(SUM(s_u.incluidos),0) "Expedientes Incluidos", 
IFNULL(SUM(s_u.adicionales),0) "Expedientes Adicionales", 
(IFNULL(SUM(s_u.periodos),0)+IFNULL(SUM(s_u.incluidos),0)+IFNULL(SUM(s_u.adicionales),0)) "Total de Expedientes", 
SUM(IF(uj.estatus='aprobado',1,0)) "Expedientes Aprobados", 
SUM(IF(uj.estatus='por revisar',1,0)) "Expedientes en Revisión", 
MIN(IF((uj.estatus='aprobado' AND uj.fecha_permiso>'0000-00-00'),uj.fecha_permiso, NULL)) "Fecha Autorizacion 1er. Expediente", 
SUM(IF(uj.estatus='renovado',1,0)) "Expedientes Renovados", 
SUM(IF(uj.estatus='revocado',1,0)) "Expedientes Revocados", 
SUM(IF(uj.estatus='rechazado',1,0)) "Expedientes Rechazados" 
FROM saldo_usuario s_u JOIN usuarios u ON ( s_u.id_usuario = u.id_usuario ) JOIN informacionpersonal inf ON (s_u.id_usuario = inf.id_usuario) 
LEFT JOIN usuario_juicio uj ON uj.id_saldo_usuario=s_u.id_saldo_usuario LEFT OUTER JOIN  evento e  ON (e.id_usuario=s_u.id_usuario) 
GROUP BY s_u.id_usuario 
