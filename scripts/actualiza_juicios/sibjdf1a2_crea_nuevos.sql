CONNECT sibjdf sicor ;

-- juzgado
DROP TABLE IF EXISTS `faltan_juzgado`;
CREATE TEMPORARY TABLE `faltan_juzgado` (
  `codigo` char(10) COLLATE utf8_spanish_ci NOT NULL,
  UNIQUE KEY idx_faltan_juzgado (codigo)
);

LOAD DATA INFILE '/var/lib/mysql-files/estos_juzgado.ltxt' INTO TABLE faltan_juzgado;
SELECT j.* FROM         juzgado j 
 JOIN faltan_juzgado f ON j.codigo=f.codigo
WHERE f.codigo IS NOT NULL
 INTO OUTFILE '/var/lib/mysql-files/nuevos_juzgado.ltxt';
DROP TABLE IF EXISTS `faltan_juzgado`;


-- juicio
DROP TABLE IF EXISTS `faltan_juicio`;
CREATE TEMPORARY TABLE `faltan_juicio` (
  `id_juicio` bigint(20) unsigned NOT NULL,
  UNIQUE KEY idx_faltan_juicio (id_juicio)
);

LOAD DATA INFILE '/var/lib/mysql-files/estos_juicio.ltxt' INTO TABLE faltan_juicio;
SELECT j.* FROM         juicio j 
 JOIN faltan_juicio f ON j.id_juicio=f.id_juicio
WHERE f.id_juicio IS NOT NULL
 INTO OUTFILE '/var/lib/mysql-files/nuevos_juicio.ltxt';
DROP TABLE IF EXISTS `faltan_juicio`;

-- parte
DROP TABLE IF EXISTS `faltan_parte`;
CREATE TEMPORARY TABLE `faltan_parte` (
  `id_parte` bigint(20) unsigned NOT NULL,
  UNIQUE KEY idx_faltan_parte (id_parte)
);

LOAD DATA INFILE '/var/lib/mysql-files/estos_parte.ltxt' INTO TABLE faltan_parte;
SELECT j.* FROM         parte j 
 JOIN faltan_parte f ON j.id_parte=f.id_parte
WHERE f.id_parte IS NOT NULL
 INTO OUTFILE '/var/lib/mysql-files/nuevos_parte.ltxt';
DROP TABLE IF EXISTS `faltan_parte`;

-- juicio_partes
DROP TABLE IF EXISTS `faltan_juicio_partes`;
CREATE TEMPORARY TABLE `faltan_juicio_partes` (
  `id_juicio` bigint(20) unsigned NOT NULL,
  UNIQUE KEY idx_faltan_juicio_partes (id_juicio)
);

LOAD DATA INFILE '/var/lib/mysql-files/estos_juicio_partes.ltxt' INTO TABLE faltan_juicio_partes;
SELECT j.* FROM         juicio_partes j 
 JOIN faltan_juicio_partes f ON j.id_juicio=f.id_juicio
WHERE f.id_juicio IS NOT NULL
 INTO OUTFILE '/var/lib/mysql-files/nuevos_juicio_partes.ltxt';
DROP TABLE IF EXISTS `faltan_juicio_partes`;

-- acuerdo
DROP TABLE IF EXISTS `faltan_acuerdo`;
CREATE TEMPORARY TABLE `faltan_acuerdo` (
  `id_acuerdo` bigint(20) unsigned NOT NULL,
  UNIQUE KEY idx_faltan_acuerdo (id_acuerdo)
);

LOAD DATA INFILE '/var/lib/mysql-files/estos_acuerdo.ltxt' INTO TABLE faltan_acuerdo;
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
 JOIN            faltan_acuerdo f ON a.id_acuerdo = f.id_acuerdo
WHERE f.id_acuerdo IS NOT NULL
  AND j.juzgado    IS NOT NULL
 INTO OUTFILE '/var/lib/mysql-files/nuevos_acuerdo.ltxt';
DROP TABLE IF EXISTS `faltan_acuerdo`;
