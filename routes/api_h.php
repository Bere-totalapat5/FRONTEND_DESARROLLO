<?php


Route::post('guardar_defaultconf', 'solicitudes\SolicitudesController_h@guardar_configuracion_default_tipo_usuario')->name('guardar_defaultconf');


//SOLICITUDES
Route::get('obtener_solicitudes',"solicitudes\SolicitudesController_h@obtener_solicitudes")->name('obtener_solicitudes');
// Route::get('obtener_solicitudes_promujer',"solicitudes\SolicitudesController_h@obtener_solicitudes_promujer")->name('obtener_solicitudes_promujer');
Route::get('descargar_pdf/{id_solicitud}',"solicitudes\SolicitudesController_h@descargar_pdf")->name('descargar_pdf');

Route::get('ver_documentos/{id_solicitud}/{valor}',"solicitudes\SolicitudesController_h@ver_documentos")->name('ver_documentos');
Route::get('ver_flujo/{id_solicitud}',"solicitudes\SolicitudesController_h@ver_flujo")->name('ver_flujo');
Route::get('ver_log/{id_solicitud}',"solicitudes\SolicitudesController_h@ver_log")->name('ver_log');
Route::get('descargar_xml/{id_solicitud}',"solicitudes\SolicitudesController_h@descargar_xml")->name('descargar_xml');
Route::post('obtener_carga',"solicitudes\SolicitudesController_h@obtener_carga")->name('obtener_carga');
Route::post('obtener_bitacora',"solicitudes\SolicitudesController_h@obtener_bitacora")->name('obtener_bitacora');
Route::post('obtener_jueces', 'solicitudes\SolicitudesController_h@obtener_jueces')->name('obtener_jueces');
Route::post('obtener_usuarios', 'solicitudes\SolicitudesController_h@obtener_usuarios')->name('obtener_usuarios');
Route::post('obtener_unidades', 'solicitudes\SolicitudesController_h@obtener_unidades')->name('obtener_unidades');
Route::post('enviarCSV', 'solicitudes\SolicitudesController_h@enviarSolicitudesCSV')->name('enviarCSV');

//obtener configuraciones default
Route::post('obtener_tipo_usuario', 'solicitudes\SolicitudesController_h@obtener_tipos_usuarios')->name('obtener_tipo_usuario');
Route::post('obtener_configuracion_usuario', 'solicitudes\SolicitudesController_h@ver_configuracion_usuario')->name('obtener_configuracion_usuario');
Route::put('turnar_carpeta/5/{id_solicitud}',"solicitudes\SolicitudesController_h@turnar_carpeta")->name('turnar_carpeta');




//PROMOCIONES
Route::get('obtener_promociones',"promociones\PromocionesController_h@obtener_promociones")->name('obtener_solicitudes');
Route::post('buscar_carpetas_asociadas',"promociones\PromocionesController_h@carpetas_asociadas")->name('buscar_carpetas_asociadas');
Route::post('buscar_carpetas_referidas',"promociones\PromocionesController_h@carpetas_referidas")->name('buscar_carpetas_referidas');
Route::post('buscar_partes_carpeta',"promociones\PromocionesController_h@buscar_partes")->name('buscar_partes_carpeta');
Route::post('enviar_promocion', 'promociones\PromocionesController_h@registrar_promocion')->name('enviar_promocion');
Route::put('enviar_promocion_editada', 'promociones\PromocionesController_h@enviar_promocion_editada')->name('enviar_promocion_editada');

Route::get('descargar_pdf_promocion/{id_promocion}',"promociones\PromocionesController_h@descargar_pdf_promocion")->name('descargar_pdf_promocion');
Route::get('descargar_xml_promocion/{id_promocion}',"promociones\PromocionesController_h@descargar_xml_promocion")->name('descargar_xml_promocion');
Route::get('ver_flujo_promocion/{id_solicitud}',"promociones\PromocionesController_h@ver_flujo_promocion")->name('ver_flujo_promocion');
Route::get('ver_log_promocion/{id_solicitud}',"promociones\PromocionesController_h@ver_log_promocion")->name('ver_log_promocion');
Route::post('cambio_carpeta_promocion',"promociones\PromocionesController_h@cambio_carpeta_promocion")->name('cambio_carpeta_promocion');
Route::get('obtener_aclaratorios',"promociones\PromocionesController_h@obtener_aclaratorios")->name('obtener_aclaratorios');


//remisiones
Route::get('obtener_remisiones',"promociones\PromocionesController_h@obtener_remisiones")->name('obtener_remisiones');
Route::get('ver_documentos_remision/{id_remision}',"promociones\PromocionesController_h@descargar_docs_remisiones")->name('ver_documentos_remision');
Route::get('abrir_documento_remision/{id_remision}/{id_documento}',"promociones\PromocionesController_h@descargar_documento_remision")->name('abrir_documento_remision');


//SALAS
Route::post('obtener_salas',"salas\SalasController_h@salas_unidad_inmueble")->name('obtener_salas');
Route::post('consulta_sala',"salas\SalasController_h@consulta_sala")->name('consulta_sala');
Route::post('nueva_sala',"salas\SalasController_h@nueva_sala")->name('nueva_sala');
Route::post('actualiza_sala',"salas\SalasController_h@actualiza_sala")->name('actualiza_sala');
Route::post('guardar_unidades_salas', 'salas\SalasController_h@guardar_configuracion_unidades_salas')->name('guardar_unidades_salas');
Route::post('obtener_todas_salas',"salas\SalasController_h@obtener_todas_salas")->name('obtener_todas_salas');



//EXHORTOS
Route::post('buscar_delitos', 'exhortos\ExhortosController_h@delitos')->name('buscar_delitos');
Route::post('enviar_exhorto', 'exhortos\ExhortosController_h@enviar_exhorto')->name('enviar_exhorto');
Route::post('obtener_delegaciones', 'exhortos\ExhortosController_h@delegaciones')->name('obtener_delegaciones');
Route::get('obtener_exhortos', 'exhortos\ExhortosController_h@obtener_carpetas_judiciales_exhortos')->name('obtener_exhortos');
Route::post('guardar_acuse_exhorto', 'exhortos\ExhortosController_h@guardar_acuse_exhorto')->name('guardar_acuse_exhorto');
Route::get('ver_exhorto', 'exhortos\ExhortosController_h@obtener_carpetas_judiciales_exhortos_completo')->name('ver_exhortos');
Route::get('descargar_pdf_exhorto',"exhortos\ExhortosController_h@descargar_pdf_exhorto")->name('descargar_pdf_exhorto');

// CARPETA JUDICIAL
Route::post('h_obtener_carpetas_judiciales_h', 'carpetas\h_CarpetasController_h@obtener_carpetas_judiciales')->name('h_obtener_carpetas_judiciales_h');


//ACUERDOS
Route::get('obtener_acuerdos', 'acuerdos\AcuerdosController_h@obtener_acuerdos')->name('obtener_acuerdos');
Route::get('descargar_pdf_acuerdo/{id_acuerdo}/{id_unidad}',"acuerdos\AcuerdosController_h@descargar_pdf_acuerdo")->name('descargar_pdf_acuerdo');
Route::get('ver_flujo_acuerdo/{id_acuerdo}',"acuerdos\AcuerdosController_h@ver_flujo_acuerdo")->name('ver_flujo_acuerdo');


//LEYENDAS
Route::post('obtener_leyendas',"leyendas\LeyendasController_h@obtener_leyendas")->name('obtener_leyendas');
Route::post('guardar_nueva_leyenda',"leyendas\LeyendasController_h@guardar_nueva_leyenda")->name('guardar_nueva_leyenda');
Route::post('guardar_cambios_leyenda',"leyendas\LeyendasController_h@guardar_cambios_leyenda")->name('guardar_cambios_leyenda');


//AUDIENCIAS
Route::get('consultar_audiencias',"audiencias\AudienciasController_h@obtener_audiencias")->name('consultar_audiencias');
Route::post('obtener_inmueble_salas_audiencia',"audiencias\AudienciasController_h@obtener_inmueble_salas_audiencia")->name('obtener_inmueble_salas_audiencia');


//SUSTITUCIONES
Route::post('registrar_sustitucion',"sustituciones\SustitucionesController_h@registrar_sustitucion")->name('registrar_sustitucion');
Route::post('modifica_agenda_sustitucion',"sustituciones\SustitucionesController_h@modifica_agenda_sustitucion")->name('modifica_agenda_sustitucion');
Route::post('obtener_usuarios_sustitucion',"sustituciones\SustitucionesController_h@usuarios_sustitucion")->name('obtener_usuarios_sustitucion');


