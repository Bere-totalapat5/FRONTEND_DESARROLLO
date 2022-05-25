

UPDATE saldo_usuario su, afil a
SET
su.tarjeta=CAST( SUBSTRING(a.tarjeta FROM -4) AS DECIMAL(4,0)),
su.operacion=CAST( a.num_autorizacion AS UNSIGNED INTEGER ),
su.conciliado='T',
su.activo='S',
su.inicio=NAD(DATE_ADD(DATE( FROM_UNIXTIME(su.id_saldo_usuario/1000) ), INTERVAL 3 DAY)),
vencimiento=DATE_ADD(NAD(DATE_ADD(DATE( FROM_UNIXTIME(su.id_saldo_usuario/1000) ), INTERVAL 3 DAY)),INTERVAL ((30*periodos)+5) DAY)
WHERE su.id_saldo_usuario=1360601125716
  AND a.id=203;


UPDATE afil SET aplicado=1360601125716 WHERE id=203;

