SELECT TIMESTAMP(FROM_UNIXTIME(su.id_saldo_usuario/1000)) as t_operacion,
su.id_saldo_usuario, su.id_usuario, su.ref_larga, su.total as importe,
bz.fecha_hora, bz.cod_oper, bz.folio, bz.signo, bz.importe as bs_importe, bz.centro_oper, bz.id_archivo,
c.fecha_registro
FROM saldo_usuario su
LEFT OUTER JOIN conciliacion c ON (c.id_susicor = su.id_saldo_usuario)
LEFT OUTER JOIN buzon_santander bz ON (bz.id_buzon_santander = c.id_deposito)
WHERE su.forma_pago='referenciado'
  AND su.id_saldo_usuario > 1346039706310;
