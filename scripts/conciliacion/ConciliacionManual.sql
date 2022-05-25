SET @suid=1360787057998;
SET @aid=215;

SELECT * FROM afil WHERE id=@aid \G
SELECT * FROM saldo_usuario WHERE id_saldo_usuario=@suid \G

UPDATE saldo_usuario su, afil a
SET
su.tarjeta=CAST( SUBSTRING(a.tarjeta FROM -4) AS DECIMAL(4,0)),
su.operacion=CAST( a.num_autorizacion AS UNSIGNED INTEGER ),
su.conciliado='T',
su.activo='S',
su.inicio=NAD(DATE_ADD(DATE( FROM_UNIXTIME(su.id_saldo_usuario/1000) ), INTERVAL 3 DAY)),
vencimiento=DATE_ADD(NAD(DATE_ADD(DATE( FROM_UNIXTIME(su.id_saldo_usuario/1000) ), INTERVAL 3 DAY)),INTERVAL ((30*periodos)+5) DAY)
WHERE su.id_saldo_usuario=@suid
  AND a.id=@aid;


UPDATE afil SET aplicado=@suid WHERE id=@aid;

SELECT * FROM afil WHERE id=@aid \G
SELECT * FROM saldo_usuario WHERE id_saldo_usuario=@suid \G

