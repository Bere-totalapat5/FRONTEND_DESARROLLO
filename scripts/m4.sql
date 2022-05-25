SELECT
IF(jz.tipo='sala', 'Sala', 'Primera Instancia') 'Jurisdicción',
 IF(subtipo='PIC', 'Civil',
   IF(subtipo='PIF', 'Familiar',
    IF(subtipo='PC', 'Civil de cuantía menor',
     IF(subtipo='SC', 'Civil',
      IF(subtipo='SF', 'Familiar',
       IF(subtipo='JCO', 'Civil de proceso orar','')))))) 'Materia',
SUBSTRING(nombre_corto, 1, LOCATE( ' ', nombre_corto )-1) 'No. de juzgado',
COUNT(id_usuario_juicio) 'Solicitudes totales',
SUM(IF(uj.estatus='aprobado',1,0)) 'Solicitudes aprobadas',
SUM(IF(uj.estatus='por revisar',1,0)) 'Solicitudes pendientes por revisar',
SUM(IF(uj.estatus='rechazado',1,0)) 'Solicitudes rechazadas'
FROM usuario_juicio uj
LEFT JOIN juicio j ON uj.id_juicio=j.id_juicio
LEFT JOIN juzgado jz ON jz.codigo=j.juzgado
WHERE (jz.orden>0 AND jz.orden<100)
OR (jz.orden>1000 AND jz.orden<1076)
OR (jz.orden>1200 AND jz.orden<1300)
OR (jz.orden>2000 AND jz.orden<2100)
OR (jz.orden>2300 AND jz.orden<2400)
OR (jz.orden>2500 AND jz.orden<2600)
GROUP BY j.juzgado ORDER BY jz.orden;

