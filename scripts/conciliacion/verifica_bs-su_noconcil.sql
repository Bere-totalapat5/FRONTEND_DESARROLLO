SELECT bs.id_buzon_santander,
su.id_saldo_usuario,
bs.cod_oper,
bs.folio,
bs.centro_oper,
bs.importe,
su.total 

FROM buzon_santander bs 
INNER JOIN saldo_usuario su on (su.ref_larga = bs.referencia_santander) 
LEFT OUTER JOIN depositos_anulados_pend a ON (a.folio=bs.folio AND a.centro_oper=bs.centro_oper) 

WHERE su.forma_pago='referenciado' 
  AND bs.signo='+' 
  AND bs.cod_oper IN (0,6,180,187,2082)
  AND bs.aplicado IS NULL
  AND a.folio IS NULL
  AND bs.fecha_hora > DATE('2012-10-31')
  AND bs.importe = su.total;
