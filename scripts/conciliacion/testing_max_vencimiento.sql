
SET @suid=1316815608330;

SELECT t.id,max(t.vencimiento) AS vencimiento
FROM (
  SELECT id_saldo_usuario AS id, vencimiento
  FROM saldo_usuario
  WHERE id_saldo_usuario=@suid
UNION
  SELECT padre as id,vencimiento
  FROM saldo_usuario
  WHERE padre=@suid
) AS t
GROUP BY t.id;
