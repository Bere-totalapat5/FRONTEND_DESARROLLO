-- juzgado
-- juicio
-- parte
-- juicio_partes
-- acuerdo

CONNECT sibjdf vsicor2 ;
SELECT codigo     FROM juzgado WHERE codigo     IS NOT NULL INTO OUTFILE '/tmp/faltan_juzgado.ltxt';
SELECT id_juicio  FROM juicio  WHERE id_juicio  IS NOT NULL INTO OUTFILE '/tmp/faltan_juicio.ltxt';
SELECT id_parte   FROM parte   WHERE id_parte   IS NOT NULL INTO OUTFILE '/tmp/faltan_parte.ltxt';
SELECT id_juicio  FROM juicio_partes  WHERE id_juicio  IS NOT NULL INTO OUTFILE '/tmp/faltan_juicio_partes.ltxt';
SELECT id_acuerdo FROM acuerdo WHERE id_acuerdo IS NOT NULL INTO OUTFILE '/tmp/faltan_acuerdo.ltxt';

