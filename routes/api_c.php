<?php
//Edicion reporte adip
Route::post('obtener_csv', 'adip\AdipController_cc@obtener_csv')->name('obtener_csv');
Route::post('guardar_json_local',  'adip\AdipController_cc@guardar_json_local')->name('guardar_json_local');
Route::post('eliminar_json_temporal',  'adip\AdipController_cc@eliminar_json_temporal')->name('eliminar_json_temporal');
Route::post('cambiar_estado_online',  'adip\AdipController_cc@cambiar_estado_online')->name('cambiar_estado_online');
Route::post('revisar_estado_online',  'adip\AdipController_cc@revisar_estado_online')->name('revisar_estado_online');
Route::post('csv_version_nueva',  'adip\AdipController_cc@csv_version_nueva')->name('csv_version_nueva');
Route::post('dias_edicion',  'adip\AdipController_cc@dias_edicion')->name('dias_edicion');
Route::post('ver_infoAdip',  'adip\AdipController_cc@ver_infoAdip')->name('ver_infoAdip');
Route::get('obtener_reportes_csv/{id_reporte}/{version}/{tipo}',"adip\AdipController_cc@obtener_reportes_csv")->name('obtener_reportes_csv');
Route::post('obtener_audiencias',  'adip\AdipController_cc@obtener_audiencias')->name('obtener_audiencias');
Route::post('cambiarHorarioAdip',  'adip\AdipController_cc@cambiarHorarioAdip')->name('cambiarHorarioAdip');
Route::post('fusionarReporte',  'adip\AdipController_cc@fusionarReporte')->name('fusionarReporte');
Route::post('generarReporteMaster',  'adip\AdipController_cc@generarReporteMaster')->name('generarReporteMaster');

//Resolutivos
Route::post('obtener_resolutivos', 'carpetas\CarpetasController@obtener_resolutivos')->name('obtener_resolutivos');
Route::post('obtener_audiencias_resolutivos', 'carpetas\CarpetasController@obtener_audiencias_resolutivos')->name('obtener_audiencias_resolutivos');
Route::post('guardar_audiencias_resolutivos', 'carpetas\CarpetasController@guardar_resolutivo')->name('guardar_resolutivo');
Route::post('editar_audiencias_resolutivos', 'carpetas\CarpetasController@editar_audiencias_resolutivos')->name('editar_audiencias_resolutivos');
Route::post('consulta_unidades_gestion',"carpetas\CarpetasController@consulta_unidades_gestion")->name('consulta_unidades_gestion');
Route::post('eliminar_audiencias_resolutivos',"carpetas\CarpetasController@eliminar_audiencias_resolutivos")->name('eliminar_audiencias_resolutivos');


//Mandamientos Judiciales
Route::post('guardar_mandamiento', 'carpetas\CarpetasController@guardar_mandamiento')->name('guardar_mandamiento');
Route::post('modificacion_audiencias_mandamientos_judiciales', 'carpetas\CarpetasController@modificacion_audiencias_mandamientos_judiciales')->name('modificacion_audiencias_mandamientos_judiciales');
Route::post('ver_catalogo_delitos',"carpetas\CarpetasController@ver_catalogo_delitos")->name('ver_catalogo_delitos');
Route::post('obtener_audiencias_mandamientos_judiciales', 'carpetas\CarpetasController@obtener_audiencias_mandamientos_judiciales')->name('obtener_audiencias_mandamientos_judiciales');
Route::post('consultar_carpetas_judiciales', 'carpetas\CarpetasController@consultar_carpetas_judiciales')->name('consultar_carpetas_judiciales');

//Acuerdos Reparatorios
Route::post('guardarAcuerdoR', 'carpetas\CarpetasController@guardarAcuerdoR')->name('guardarAcuerdoR');
Route::post('obtener_AcuerdosR', 'carpetas\CarpetasController@obtener_AcuerdosR')->name('obtener_AcuerdosR');
Route::post('actualizar_AcuerdoR', 'carpetas\CarpetasController@actualizar_AcuerdoR')->name('actualizar_AcuerdoR');


//Medidas Cautelares
Route::post('guardarMedidaC', 'carpetas\CarpetasController@guardarMedidaC')->name('guardarMedidaC');
Route::post('obtener_MedidaC', 'carpetas\CarpetasController@obtener_MedidaC')->name('obtener_MedidaC');
Route::post('actualizar_MedidaC', 'carpetas\CarpetasController@actualizar_MedidaC')->name('actualizar_MedidaC');
Route::post('obtener_MedidasCautelares', 'carpetas\CarpetasController@obtener_MedidasCautelares')->name('obtener_MedidasCautelares');

//Medidas de proteccion
Route::post('guardarMedidaP', 'carpetas\CarpetasController@guardarMedidaP')->name('guardarMedidaP');
Route::post('obtener_MedidaP', 'carpetas\CarpetasController@obtener_MedidaP')->name('obtener_MedidaP');
Route::post('obtener_CondicionS', 'carpetas\CarpetasController@obtener_CondicionS')->name('obtener_CondicionS');
Route::post('actualizar_MedidaP', 'carpetas\CarpetasController@actualizar_MedidaP')->name('actualizar_MedidaP');
Route::post('obtener_MedidasProteccion', 'carpetas\CarpetasController@obtener_MedidasProteccion')->name('obtener_MedidasProteccion');
Route::post('obtener_CondicionesSuspension', 'carpetas\CarpetasController@obtener_CondicionesSuspension')->name('obtener_CondicionesSuspension');

//ADIP
Route::get('obtener_reportes_adip',"adip\AdipController_cc@obtener_reportes_adip")->name('obtener_reportes_adip');
Route::get('obtener_reportes_xml/{id_reporte}/{nombre_reporte}/{tipo}',"adip\AdipController_h@obtener_reportes_xml")->name('obtener_reportes_xml');
Route::get('obtener_reportes_excel/{id_reporte}/{nombre_reporte}/{tipo}',"adip\AdipController_h@obtener_reportes_excel")->name('obtener_reportes_excel');
Route::get('obtener_reportes_pdf/{id_reporte}/{nombre_reporte}/{tipo}',"adip\AdipController_h@obtener_reportes_pdf")->name('obtener_reportes_pdf');

//Conuslta reportes adip xml
Route::get("consulta_reporte_adip_xml","adip\AdipController_cc@consulta_reportes_adip_xml")->name('consulta_reporte_adip_xml');

//Reenvio de correos
Route::post('reenvio_correo',  'descarga_reportes\DescargaReportesController@reenvio')->name('reenvio_correo');

//descargar reportes
Route::post('descargar_r_delitos',  'descarga_reportes\DescargaReportesController@descargar_reporte_delitos')->name('descargar_r_delitos');
Route::post('descargar_r_libertades',  'descarga_reportes\DescargaReportesController@descargar_reporte_libertades')->name('descargar_r_libertades');
Route::post('descargar_r_resolutivos_audiencia',  'descarga_reportes\DescargaReportesController@descargar_reporte_resolutivos_audiencia')->name('descargar_r_resolutivos_audiencia');
Route::post('descargar_r_desempeno_juez',  'descarga_reportes\DescargaReportesController@descargar_reporte_desempeno_juez')->name('descargar_r_desempeno_juez');
Route::post('descargar_r_cj_recibidas',  'descarga_reportes\DescargaReportesController@descargar_reporte_cj_recibidas')->name('descargar_r_cj_recibidas');
Route::post('descargar_r_audiencias',  'descarga_reportes\DescargaReportesController@descargar_reporte_r_audiencias')->name('descargar_r_audiencias');
Route::post('descargar_r_sol_recibidas_td',  'descarga_reportes\DescargaReportesController@descargar_reporte_sol_recibidas_td')->name('descargar_r_sol_recibidas_td');
Route::post('descargar_r_resolutivos_por_audiencia',  'descarga_reportes\DescargaReportesController@descargar_reporte_resolutivos_por_audiencia')->name('descargar_r_resolutivos_por_audiencia');
Route::post('descargar_r_medidas_Rati_LAMV',  'descarga_reportes\DescargaReportesController@descargar_reporte_medidas_Rati_LAMV')->name('descargar_r_medidas_Rati_LAMV');
Route::post('descargar_r_contadores_audiencias',  'descarga_reportes\DescargaReportesController@descargar_reporte_contadores_audiencias')->name('descargar_r_contadores_audiencias');
Route::post('descargar_r_prom_tipos_audiencia',  'descarga_reportes\DescargaReportesController@descargar_reporte_prom_tipos_audiencia')->name('descargar_r_prom_tipos_audiencia');
Route::post('descargar_r_suspension_condicional',  'descarga_reportes\DescargaReportesController@descargar_reporte_suspension_condicional')->name('descargar_r_suspension_condicional');
Route::post('descargar_r_remisiones_incompetencia',  'descarga_reportes\DescargaReportesController@descargar_reporte_remisiones_incompetencia')->name('descargar_r_remisiones_incompetencia');
Route::get('exportar_solicitudes_excel',  'solicitudes\SolicitudesController@exportar_solicitudes_excel')->name('exportar_solicitudes_excel');


//consulta reporte libertades
Route::post('ver_reporte_libertades',  'descarga_reportes\DescargaReportesController@ver_reporte_libertades')->name('ver_reporte_libertades');
Route::post('eliminarMotivoResumen',  'descarga_reportes\DescargaReportesController@eliminarMotivoResumen')->name('eliminarMotivoResumen');



//Guardar campos resumen, motivo
Route::post('guardarMotivoResumen',  'descarga_reportes\DescargaReportesController@guardarMotivoResumen')->name('guardarMotivoResumen');

//Verifica password
Route::post('validacion_password',  'descarga_reportes\DescargaReportesController@validacion_password')->name('validacion_password');

//ADMINISTRACION DE JUECES
Route::post('obtener_jueces_admon',"jueces\JuecesController_h@obtener_jueces_administracion")->name('obtener_jueces_admon');
Route::post('consulta_agenda_admon',"jueces\JuecesController_h@consulta_agenda_administracion")->name('consulta_agenda_admon');
Route::post('inserta_agenda_admon',"jueces\JuecesController_h@inserta_agenda_administracion")->name('inserta_agenda_admon');
//Route::post('modifica_agenda_admon',"jueces\JuecesController_h@modifica_agenda_administracion")->name('modifica_agenda_admon');
Route::post('elimina_agenda_administracion',"jueces\JuecesController_h@elimina_agenda_administracion")->name('elimina_agenda_administracion');
Route::post('obtener_ugas_jueces',"jueces\JuecesController_h@obtener_ugas_jueces")->name('obtener_ugas_jueces');

//RECURSOS ADICIONALES
Route::post('obtener_recursos_adicionales',"recursos_adicionales\RecursosAdicionalesController@obtener_recursosAdicionales")->name('obtener_recursos_adicionales');
Route::post('guardar_tipo_recursos_adicionales',"recursos_adicionales\RecursosAdicionalesController@guardar_tipoRecursosAdicionales")->name('guardar_tipo_recursos_adicionales');
Route::post('actualizar_tipo_recursos_adicionales',"recursos_adicionales\RecursosAdicionalesController@actualizar_tipo_recursos_adicionales")->name('actualizar_tipo_recursos_adicionales');
Route::post('obtener_recursos_audiencia',"recursos_adicionales\RecursosAdicionalesController@obtener_recursos_audiencia")->name('obtener_recursos_audiencia');
Route::post('save_recurso_audiencia',"recursos_adicionales\RecursosAdicionalesController@save_recurso_audiencia")->name('save_recurso_audiencia');
Route::post('update_recurso_audiencia',"recursos_adicionales\RecursosAdicionalesController@update_recurso_audiencia")->name('update_recurso_audiencia');

//GRUPO JUECES
Route::post('consulta_jueces_administracion',"jueces\JuecesController_h@consulta_jueces_administracion")->name('consulta_jueces_administracion');
Route::post('consulta_unidades_gestion',"jueces\JuecesController_h@consulta_unidades_gestion")->name('consulta_unidades_gestion');
Route::post('consulta_usuarios_administracion',"jueces\JuecesController_h@consulta_usuarios_administracion")->name('consulta_usuarios_administracion');
Route::post('consulta_usuarios_grupos_jueces',"jueces\JuecesController_h@consulta_usuarios_grupos_jueces")->name('consulta_usuarios_grupos_jueces');
Route::post('insertar_usuario_jueces',"jueces\JuecesController_h@agregar_usuario_jueces")->name('agregar_usuario_jueces');
Route::post('consulta_usuarios_x_juez',"jueces\JuecesController_h@consulta_usuarios_x_juez")->name('consulta_usuarios_x_juez');
Route::post('actualizar_usuarios_grupos_jueces',"jueces\JuecesController_h@actualizar_usuarios_grupos_jueces")->name('actualizar_usuarios_grupos_jueces');
Route::get("ver_grupos_jueces","jueces\JuecesController_h@ver_grupos_jueces")->name('ver_grupos_jueces');
Route::post("eliminarGrupo","jueces\JuecesController_h@eliminarGrupo")->name('eliminarGrupo');

//consulta audiencias
Route::post('ws_salas',"audiencias\AudienciasController_h@ws_salas")->name('ws_salas');

//Consulta contactos de reportes
Route::post('obtener_contactos',"descarga_reportes\DescargaReportesController@obtener_contactos")->name('obtener_contactos');
Route::post('guardar_contacto',"descarga_reportes\DescargaReportesController@guardar_contacto")->name('guardar_contacto');
Route::post('actualizar_contacto',"descarga_reportes\DescargaReportesController@actualizar_contacto")->name('actualizar_contacto');
Route::post('eliminar_contacto',"descarga_reportes\DescargaReportesController@eliminar_contacto")->name('eliminar_contacto');

Route::post('obtener_reportes_programados',"descarga_reportes\DescargaReportesController@obtener_reportes_programados")->name('obtener_reportes_programados');
Route::post('guardar_reporte_programado',"descarga_reportes\DescargaReportesController@guardar_reporte_programado")->name('guardar_reporte_programado');
Route::post('actualizar_reporte_programado',"descarga_reportes\DescargaReportesController@actualizar_reporte_programado")->name('actualizar_reporte_programado');

Route::post('asignar_contacto',"descarga_reportes\DescargaReportesController@asignar_contacto")->name('asignar_contacto');
Route::post('removerContacto',"descarga_reportes\DescargaReportesController@removerContacto")->name('removerContacto');


//WebSocket
Route::post('enviar_notificacion',"websockets\WebsocketController@enviar_notificacion")->name('enviar_notificacion');
Route::post('obtener_alertas',"websockets\WebsocketController@obtener_alertas")->name('obtener_alertas');
Route::post('actualizar_visto',"websockets\WebsocketController@actualizar_visto")->name('actualizar_visto');


//Reseteo pass login
Route::post('cambiar_reseteo',"login\control_login@cambiar_reseteo")->name('cambiar_reseteo');
Route::post('statuspws',"login\control_login@statuspws")->name('statuspws');

//Nuevas Libertades
Route::post('ObtenerCarpetaSeleccionada',"descarga_reportes\DescargaReportesController@ObtenerCarpetaSeleccionada")->name('ObtenerCarpetaSeleccionada');
Route::post('guardar_info_addi',"descarga_reportes\DescargaReportesController@guardar_info_addi")->name('guardar_info_addi');
Route::post('ObtenerLibertadesRegistradas',"descarga_reportes\DescargaReportesController@ObtenerLibertadesRegistradas")->name('ObtenerLibertadesRegistradas');
Route::post('borra_libertad_adicional',"descarga_reportes\DescargaReportesController@borra_libertad_adicional")->name('borra_libertad_adicional');

//Consulta informes
Route::post('consulta_informes_c',"descarga_reportes\DescargaReportesController@consulta_informes_c")->name('consulta_informes_c');

//Conuslta reportes adip xml
Route::get("consulta_reportes_estadistico","adip\AdipController_cc@consulta_reportes_estadistico")->name('consulta_reportes_estadistico');
Route::get('obtener_reportes_zip/{id_reporte}/{nombre_reporte}/{tipo}',"adip\AdipController_cc@obtener_reportes_zip")->name('obtener_reportes_zip');

//Rutas Fracciones
Route::post('catalogo_fracciones_solicitud', 'audiencias\AudienciasController_h@catalogo_fracciones_solicitud')->name('catalogo_fracciones_solicitud');
Route::post('guardar_fracciones_audiencia_f', 'audiencias\AudienciasController_h@guardar_fracciones_audiencia')->name('guardar_fracciones_audiencia_f');
Route::post('catalogo_fracciones_solicitud_acuerdo', 'audiencias\AudienciasController_h@catalogo_fracciones_solicitud_acuerdo')->name('catalogo_fracciones_solicitud_acuerdo');

//Rutas Prescripciones
Route::post('catalogo_pena', 'carpetas\CarpetasController@catalogo_pena')->name('catalogo_pena');
Route::post('obtenerPrescripciones', 'carpetas\CarpetasController@obtenerPrescripciones')->name('obtenerPrescripciones');
Route::post('guardar_prescripcion', 'carpetas\CarpetasController@guardar_prescripcion')->name('guardar_prescripcion');
Route::post('eliminar_prescripcion', 'carpetas\CarpetasController@eliminar_prescripcion')->name('eliminar_prescripcion');
Route::post('actualizar_prescripcion', 'carpetas\CarpetasController@actualizar_prescripcion')->name('actualizar_prescripcion');
Route::get('imputados_remision_prescripcion', 'carpetas\CarpetasController@imputados_remision_prescripcion')->name('imputados_remision_prescripcion');


//Rutas Reporte de Ejecucion
Route::post('consulta_reporte_Ejecucion', 'carpetas\CarpetasController@consulta_reporte_Ejecucion')->name('consulta_reporte_Ejecucion');
Route::post('descargar_r_ejecucion',  'carpetas\CarpetasController@descargar_reporte_ejecucion')->name('descargar_r_ejecucion');
Route::post('guardarCamposEjecucion',  'carpetas\CarpetasController@guardarCamposEjecucion')->name('guardarCamposEjecucion');

//Rutas Arbol Carpetas Remitidas
Route::post('obtener_carpetas_remitidas', 'carpetas\CarpetasController@obtener_carpetas_remitidas')->name('obtener_carpetas_remitidas');

//Rutas Informacion Solicitud inicial Remisiones TE/EJEC/LN 
Route::get('muestraSolicitudInicialRem', 'carpetas\CarpetasController@muestraSolicitudInicialRem')->name('muestraSolicitudInicialRem');

//obtener acuse
Route::post('obtener_acuse_audiencia', 'audiencias\AudienciasController_h@obtener_acuse_audiencia')->name('obtener_acuse_audiencia');

//Exportar xlsx de audiencias
Route::post('exportar_busqueda_audiencias', 'audiencias\AudienciasController_h@exportar_busqueda_audiencias')->name('exportar_busqueda_audiencias');

//obtener documento resolutivo
Route::get('obtener_documento_resolutivo', 'carpetas\CarpetasController@obtener_documento_resolutivo')->name('obtener_documento_resolutivo');

//Buscar personas Global
Route::get('buscar_personas_global', 'descarga_reportes\DescargaReportesController@buscar_personas_global')->name('buscar_personas_global');

// ver catalogo de tipos de usuario
Route::get('ver_catalogo_tipos_usuario', 'audiencias\AudienciasController_h@ver_catalogo_tipos_usuario')->name('ver_catalogo_tipos_usuario');

// juez por tipo de juez
Route::get('juezxtipo_juez', 'audiencias\AudienciasController_h@juezxtipo_juez')->name('juezxtipo_juez');

//Exportar constancia de busqueda
Route::post('exportar_constancia_busqueda', 'descarga_reportes\DescargaReportesController@exportar_constancia_busqueda')->name('exportar_constancia_busqueda');
Route::post('registrar_solicitud_TE_EJEC', 'solicitudes\SolicitudesController@registrar_solicitud_TE_EJEC')->name('registrar_solicitud_TE_EJEC');
Route::get('consultar_solicitudes_TEJEC', 'solicitudes\SolicitudesController@consultar_solicitudes_TEJEC')->name('consultar_solicitudes_TEJEC');


//Finalizar captura de Resolutivos
Route::post('finalizarAbrirCaptura', 'carpetas\CarpetasController@finalizarAbrirCaptura')->name('finalizarAbrirCaptura');

//Notificacion con MAJO y SIAJOP
Route::post('renotificar_audiencia_MAJO_SIAJOP', 'audiencias\AudienciasController_h@renotificar_audiencia_MAJO_SIAJOP')->name('renotificar_audiencia_MAJO_SIAJOP');
Route::post('exportar_consulta_carpetas_j', 'carpetas\CarpetasController@exportar_consulta_carpetas_j')->name('exportar_consulta_carpetas_j');

Route::post('generarTarea', 'solicitudes\SolicitudesController@generarTarea')->name('generarTarea');
Route::post('exportar_consulta_carpetas_j', 'carpetas\CarpetasController@exportar_consulta_carpetas_j')->name('exportar_consulta_carpetas_j');

//Incidencias de Sala
Route::post('registrar_incidencia',"salas\SalasController_h@registrar_incidencia_sala")->name('registrar_incidencia');
Route::post('actualizar_incidencia',"salas\SalasController_h@actualizar_incidencia")->name('actualizar_incidencia');
Route::post('obtener_incidencias',"salas\SalasController_h@obtener_incidencias_sala")->name('obtener_incidencias');
Route::post('eliminar_incidencia',"salas\SalasController_h@eliminar_incidencia")->name('eliminar_incidencia');
Route::post('activar_incidencia',"salas\SalasController_h@activar_incidencia")->name('activar_incidencia');

// Reporte Acuerdo Reparatorios
Route::get('buscar_acuerdos_reparatorios',"descarga_reportes\DescargaReportesController@buscar_acuerdos_reparatorios")->name('buscar_acuerdos_reparatorios');
Route::post('informe_existencia_acuerdo',"descarga_reportes\DescargaReportesController@informe_existencia_acuerdo")->name('informe_existencia_acuerdo');

// Amparos Cancelacion carpeta
Route::post('cancelar_carpeta_amparo',"amparos\AmparosController@cancelar_carpeta_amparo")->name('cancelar_carpeta_amparo');

// Documento Solicitudes TEJEC
Route::post('obtener_documento_solicitud_TEJEC',"descarga_reportes\DescargaReportesController@obtener_documento_solicitud_TEJEC")->name('obtener_documento_solicitud_TEJEC');

// correos Enviados
Route::get('correos_enviados',"solicitudes\SolicitudesController@correos_enviados")->name('correos_enviados');

// obtener fecha acuerdo firma 
Route::get('obtener_fecha_acuerdo',"audiencias\AudienciasController_h@obtener_fecha_acuerdo")->name('obtener_fecha_acuerdo');
Route::post('guardarFechas_rat',"audiencias\AudienciasController_h@guardarFechas_rat")->name('guardarFechas_rat');

// obtener ip
Route::get('obtener_ip',"descarga_reportes\DescargaReportesController@obtener_IP")->name('obtener_ip');

Route::post('resolucion_apel', 'carpetas\CarpetasController@resolucion_apel')->name('resolucion_apel');

