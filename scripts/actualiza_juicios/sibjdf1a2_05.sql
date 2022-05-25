-- acuerdo
CONNECT sibjdf vsicor ;

DROP TABLE IF EXISTS `faltan_acuerdo`;
CREATE TEMPORARY TABLE `faltan_acuerdo` (
  `id_acuerdo` bigint(20) unsigned NOT NULL,
  UNIQUE KEY idx_faltan_acuerdo (id_acuerdo)
);
-- CREATE INDEX idx_faltan_acuerdo ON faltan_acuerdo(id_acuerdo);
LOAD DATA INFILE '/tmp/faltan_acuerdo.ltxt' INTO TABLE faltan_acuerdo;
SELECT
a.id_juicio,
a.id_acuerdo,
a.tipo_flujo,
a.acuerdo,
a.fecha,
a.activacion,
a.activo,
a.apelacion,
a.conciliador,
a.permiso_parte1,
a.permiso_parte2,
a.permiso_parte3,
a.extension,
a.estatus,
a.tipo,
a.especial,
a.visibilidad,
a.publicar_en,
a.concepto,
a.voto_particular,
a.fecha_voto,
a.comentario,
a.ultimo_cambio,
CRC32(j.juzgado)
 FROM                   acuerdo a
 JOIN                    juicio j ON a.id_juicio  = j.id_juicio
 LEFT OUTER JOIN faltan_acuerdo f ON a.id_acuerdo = f.id_acuerdo
WHERE f.id_acuerdo IS NULL
  AND j.juzgado    IS NOT NULL
 INTO OUTFILE '/tmp/nuevos_acuerdo.ltxt';
DROP TABLE IF EXISTS `faltan_acuerdo`;

