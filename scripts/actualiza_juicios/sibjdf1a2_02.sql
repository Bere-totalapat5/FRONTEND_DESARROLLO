-- juicio
CONNECT sibjdf vsicor ;

DROP TABLE IF EXISTS `faltan_juzgado`;
CREATE TEMPORARY TABLE `faltan_juzgado` (
  `codigo` char(10) COLLATE utf8_spanish_ci NOT NULL,
  UNIQUE KEY idx_faltan_juzgado (codigo)
);
-- CREATE INDEX idx_faltan_juzgado ON faltan_juzgado(codigo);
LOAD DATA INFILE '/tmp/faltan_juzgado.ltxt' INTO TABLE faltan_juzgado;
SELECT j.* FROM         juzgado j 
 LEFT OUTER JOIN faltan_juzgado f ON j.codigo=f.codigo
WHERE f.codigo IS NULL
 INTO OUTFILE '/tmp/nuevos_juzgado.ltxt';
DROP TABLE IF EXISTS `faltan_juzgado`;



DROP TABLE IF EXISTS `faltan_juicio`;
CREATE TEMPORARY TABLE `faltan_juicio` (
  `id_juicio` bigint(20) unsigned NOT NULL,
  UNIQUE KEY idx_faltan_juicio (id_juicio)
);
-- CREATE INDEX idx_faltan_juicio ON faltan_juicio(id_juicio);
LOAD DATA INFILE '/tmp/faltan_juicio.ltxt' INTO TABLE faltan_juicio;
SELECT j.* FROM         juicio j 
 LEFT OUTER JOIN faltan_juicio f ON j.id_juicio=f.id_juicio
WHERE f.id_juicio IS NULL
 INTO OUTFILE '/tmp/nuevos_juicio.ltxt';
DROP TABLE IF EXISTS `faltan_juicio`;
