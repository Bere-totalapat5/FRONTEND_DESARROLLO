-- juzgado juicio parte y juicio_partes
CONNECT sibjdf vsicor2 ;

DROP TABLE IF EXISTS juicio33;
CREATE TABLE juicio33 AS (SELECT * FROM juicio WHERE 1=0);

LOAD DATA INFILE '/tmp/nuevos_juicio.ltxt'  INTO TABLE juicio33
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
