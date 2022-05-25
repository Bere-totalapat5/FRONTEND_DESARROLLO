SELECT juz.nombre "Juzgado", 
SUM(s_u.seguimiento) "Solicitudes Totales", 
SUM(IF(u_j.estatus='aprobado',1,0)) "Solicitudes Aprobadas", 
SUM(IF(u_j.estatus='por revisar',1,0)) "Solicitudes Pendientes por Revisar", 
SUM(IF(u_j.estatus='rechazado',1,0)) "Solicitudes Rechazadas" 
FROM  usuario_juicio u_j, juicio j, juzgado juz, saldo_usuario s_u 
WHERE u_j.id_juicio = j.id_juicio AND j.juzgado = juz.codigo and u_j.id_saldo_usuario = s_u.id_saldo_usuario GROUP BY j.juzgado 
