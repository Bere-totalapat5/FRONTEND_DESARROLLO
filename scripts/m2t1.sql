SELECT
SUM(IF(p.id_paquete=1,1,0)) 'Básicos',
SUM(IF(p.id_paquete=2,1,0)) 'Avisos',
SUM(IF(p.id_paquete=3,1,0)) 'Integrales',
SUM(IF(p.id_paquete=30,1,0)) 'Promocionales'
FROM saldo_usuario su
LEFT JOIN usuarios u ON u.id_usuario=su.id_usuario
LEFT JOIN paquete p ON p.id_paquete=su.id_paquete
WHERE su.activo='S';

