SELECT
CONCAT('$',SUM(IF(p.id_paquete=1,su.total,0)) )'Básicos',
CONCAT('$',SUM(IF(p.id_paquete=2,su.total,0)) )'Avisos',
CONCAT('$',SUM(IF(p.id_paquete=3,su.total,0)) )'Integrales',
CONCAT('$',SUM(IF(p.id_paquete=30,su.total,0)) )'Promocionales',
CONCAT('$',SUM( su.total) )'Total'
FROM saldo_usuario su
LEFT JOIN usuarios u ON u.id_usuario=su.id_usuario
LEFT JOIN paquete p ON p.id_paquete=su.id_paquete
WHERE su.activo='S'



