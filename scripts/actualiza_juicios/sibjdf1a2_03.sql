-- juicio_partes
CONNECT sibjdf vsicor ;

DROP TABLE IF EXISTS `faltan_juicio_partes`;
CREATE TEMPORARY TABLE `faltan_juicio_partes` (
  `id_juicio` bigint(20) unsigned NOT NULL,
  UNIQUE KEY idx_faltan_juicio_partes (id_juicio)
);
-- CREATE INDEX idx_faltan_juicio_partes ON faltan_juicio_partes(id_juicio);
LOAD DATA INFILE '/tmp/faltan_juicio_partes.ltxt' INTO TABLE faltan_juicio_partes;
SELECT j.* FROM         juicio_partes j 
 LEFT OUTER JOIN faltan_juicio_partes f ON j.id_juicio=f.id_juicio
WHERE f.id_juicio IS NULL
 INTO OUTFILE '/tmp/nuevos_juicio_partes.ltxt';
DROP TABLE IF EXISTS `faltan_juicio_partes`;

