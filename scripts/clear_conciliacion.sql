truncate afil;
truncate buzon_santander;
truncate depositos_anulados_pend;
truncate conciliacion;
UPDATE saldo_usuario SET conciliado='F';
delete from files;
