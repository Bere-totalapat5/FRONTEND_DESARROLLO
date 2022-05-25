
SET @suid=1316815608330;

SELECT t.id,max(t.vencimiento) AS vencimiento
FROM (
SELECT id_saldo_usuario as id,vencimiento FROM `saldo_usuario`
where id_saldo_usuario=@suid
UNION
SELECT padre as id,max(vencimiento) as vencimiento FROM `saldo_usuario`
where padre=@suid
group by padre
having count(*) > 1
) AS t
group by t.id;
