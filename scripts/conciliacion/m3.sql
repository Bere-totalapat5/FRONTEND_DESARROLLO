SELECT
uj.id_usuario_juicio 'Folio SICOR', u.usuario 'Usuario',
IF( ISNULL(j.toca),
    CONCAT( j.expediente, '/', j.anio, IF(ISNULL(j.bis),'', CONCAT(' ', j.bis, 'Bis')), IF(j.tipo_expediente='expediente', '', CONCAT('(',j.tipo_expediente,')')) ),
    CONCAT( j.toca, '/', j.anio_toca, IF(ISNULL(j.asunto_toca),'', CONCAT('/', j.asunto_toca)), IF(j.tipo_expediente='expediente', '', CONCAT('(',j.tipo_expediente,')')) )
  ) 'No. de expediente',
IF(jz.tipo='sala', 'Sala', 'Primera Instancia') 'Jurisdicción', 
 IF(subtipo='PIC', 'Civil',
   IF(subtipo='PIF', 'Familiar',
    IF(subtipo='PC', 'Civil de cuantía menor',
     IF(subtipo='SC', 'Civil',
      IF(subtipo='SF', 'Familiar',
       IF(subtipo='JCO', 'Civil de proceso orar','')))))) 'Materia', 
SUBSTRING(nombre_corto, 1, LOCATE( ' ', nombre_corto )-1) 'No. de juzgado',
IF(ISNULL(ue.id_usuario),'Portal', ue.usuario) 'Ejecutivo', 
alta 'Fecha de registro', uj.fecha_permiso 'Fecha de autorización', 
CONCAT('') 'Fecha de revocación'
FROM usuario_juicio uj
LEFT JOIN juicio j ON j.id_juicio=uj.id_juicio
LEFT JOIN juzgado jz ON jz.codigo=j.juzgado
LEFT JOIN usuarios u ON u.id_usuario=uj.id_usuario
LEFT JOIN saldo_usuario su ON su.id_saldo_usuario=uj.id_saldo_usuario
LEFT JOIN usuarios ue ON ue.id_usuario=su.operador;
