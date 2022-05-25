UPDATE  transaccion_tarjeta tt, saldo_usuario su
SET su.tarjeta = tt.terminacion,
su.operacion = CAST(tt.autorizacion AS UNSIGNED INTEGER)
WHERE tt.id_saldo_usuario > 1360045764000
  AND tt.autorizacion IS NOT NULL
  AND su.id_saldo_usuario = tt.id_saldo_usuario
  AND ( su.operacion < 1 OR su.operacion IS NULL );
