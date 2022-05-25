-- parte
CONNECT sibjdf vsicor ;

DROP TABLE IF EXISTS `faltan_parte`;
CREATE TEMPORARY TABLE `faltan_parte` (
  `id_parte` bigint(20) unsigned NOT NULL,
  UNIQUE KEY idx_faltan_parte (id_parte)
);
-- CREATE INDEX idx_faltan_parte ON faltan_parte(id_parte);
LOAD DATA INFILE '/tmp/faltan_parte.ltxt' INTO TABLE faltan_parte;
SELECT j.* FROM         parte j 
 LEFT OUTER JOIN faltan_parte f ON j.id_parte=f.id_parte
WHERE f.id_parte IS NULL
 INTO OUTFILE '/tmp/nuevos_parte.ltxt';
DROP TABLE IF EXISTS `faltan_parte`;

