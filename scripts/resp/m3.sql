SELECT 
r_d_f.folio "Folio SICOR", 
r_d_f.usuario "Usuario", 
j.expediente "No. de Expediente", 
juz.tipo AS "Jurisdicción", 
juz.nombre_corto AS "Materia", 
j.juzgado "No. de Juzgado",  
r_d_f.nombre_completo_ejecutivo "Ejecutivo", 
r_d_f.fecha_operacion "Fecha de Registro SICOR", 
MIN(IF((u_j.estatus='aprobado' AND u_j.fecha_permiso>'0000-00-00'),u_j.fecha_permiso, NULL)) "Fecha Autorización", 
MIN(IF((u_j.estatus='revocado' AND u_j.fecha_permiso>'0000-00-00'),u_j.fecha_permiso, NULL)) "Fecha de Revocación"  
FROM usuario_juicio u_j LEFT JOIN r_depositos_final r_d_f ON ( u_j.id_saldo_usuario = r_d_f.id_saldo_usuario ) LEFT JOIN juicio j ON j.id_juicio=u_j.id_juicio 
LEFT JOIN juzgado juz ON (juz.codigo=j.juzgado AND u_j.id_usuario_juicio=j.id_juicio) 
WHERE 0=0 GROUP BY r_d_f.id_saldo_usuario
