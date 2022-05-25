-- juzgado
-- juicio
-- parte
-- juicio_partes
-- acuerdo

SELECT codigo     FROM juzgado WHERE codigo     IS NOT NULL ORDER BY codigo       INTO OUTFILE '/var/lib/mysql-files/faltan_juzgado.ltxt';
SELECT id_juicio  FROM juicio  WHERE id_juicio  IS NOT NULL ORDER BY id_juicio    INTO OUTFILE '/var/lib/mysql-files/faltan_juicio.ltxt';
SELECT id_parte   FROM parte   WHERE id_parte   IS NOT NULL ORDER BY id_parte     INTO OUTFILE '/var/lib/mysql-files/faltan_parte.ltxt';
SELECT id_juicio  FROM juicio_partes  WHERE id_juicio  IS NOT NULL ORDER BY id_juicio    INTO OUTFILE '/var/lib/mysql-files/faltan_juicio_partes.ltxt';
SELECT id_acuerdo FROM acuerdo WHERE id_acuerdo IS NOT NULL ORDER BY id_acuerdo    INTO OUTFILE '/var/lib/mysql-files/faltan_acuerdo.ltxt';
