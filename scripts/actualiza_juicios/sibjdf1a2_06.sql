-- juzgado juicio parte y juicio_partes
-- CONNECT sibjdf vsicor2 ;

SET  FOREIGN_KEY_CHECKS=0;
LOAD DATA INFILE '/var/lib/mysql-files/nuevos_juzgado.ltxt' IGNORE INTO TABLE juzgado;
COMMIT ;
LOAD DATA INFILE '/var/lib/mysql-files/nuevos_juicio.ltxt'  IGNORE INTO TABLE juicio
(
id_juicio,
id_padre,
tipo_expediente,
tipo_expediente_extras,
toca,
anio_toca,
asunto_toca,
expediente,
anio,
bis,
juzgado,
juzgado_origen,
secretaria,
fecha_publicacion,
estatus,
id_tipojuicio,
id_catalogo_juicios,
id_etapaprocesal,
promovente,
tramite_interpuesto,
tipo_resolucion,
fecha_resolucion,
efecto_admite,
efecto_admite_texto,
interpone,
apela,
tipo_recurso
);
COMMIT ;
LOAD DATA INFILE '/var/lib/mysql-files/nuevos_parte.ltxt'   IGNORE INTO TABLE parte;
COMMIT ;
LOAD DATA INFILE '/var/lib/mysql-files/nuevos_juicio_partes.ltxt' IGNORE INTO TABLE juicio_partes;
COMMIT ;
SET FOREIGN_KEY_CHECKS=1;
