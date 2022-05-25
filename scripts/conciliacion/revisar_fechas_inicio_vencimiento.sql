SELECT id_saldo_usuario AS id, id_saldo_usuario, inicio,vencimiento
  FROM saldo_usuario
  WHERE id_saldo_usuario IN (1316815608330,1320075552246,1346163627344,1360788340827)
UNION
  SELECT padre as id, id_saldo_usuario, inicio, vencimiento
  FROM saldo_usuario
  WHERE padre IN (1316815608330,1320075552246,1346163627344,1360788340827)

ORDER BY id, id_saldo_usuario;
