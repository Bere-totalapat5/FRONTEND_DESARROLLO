-- acuerdo
-- CONNECT sibjdf vsicor2 ;

LOAD DATA INFILE '/var/lib/mysql-files/nuevos_acuerdo.ltxt' IGNORE INTO TABLE acuerdo
(id_juicio,
id_acuerdo,
tipo_flujo,
acuerdo,
fecha,
activacion,
activo,
apelacion,
conciliador,
permiso_parte1,
permiso_parte2,
permiso_parte3,
extension,
estatus,
tipo,
especial,
visibilidad,
publicar_en,
concepto,
voto_particular,
fecha_voto,
comentario,
ultima_edicion,
mcrc);
COMMIT ;
