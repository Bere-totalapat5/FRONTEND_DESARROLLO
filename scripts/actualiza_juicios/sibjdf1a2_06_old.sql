-- juzgado juicio parte y juicio_partes
CONNECT sibjdf vsicor2 ;

SET  FOREIGN_KEY_CHECKS=0;
LOAD DATA INFILE '/tmp/nuevos_juzgado.ltxt' INTO TABLE juzgado;
COMMIT ;
LOAD DATA INFILE '/tmp/nuevos_juicio.ltxt'  INTO TABLE juicio;
COMMIT ;
LOAD DATA INFILE '/tmp/nuevos_parte.ltxt'   INTO TABLE parte;
COMMIT ;
LOAD DATA INFILE '/tmp/nuevos_juicio_partes.ltxt' INTO TABLE juicio_partes;
COMMIT ;
SET FOREIGN_KEY_CHECKS=1;
