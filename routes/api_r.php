<?php
use App\Http\Controllers\clases\adip;
use GuzzleHttp\Client;

// PERMISOS
Route::post('guardar_permisos', 'configuracion\control_configuracion@guardar_permisos')->name('guardar_permisos');

// CATÁLOGOS
Route::post('obtener_modalidades', 'catalogos\CatalogosController@obtener_modalidades')->name('obtener_modalidades');
Route::post('obtener_agencias', 'catalogos\CatalogosController@obtener_agencias')->name('obtener_agencias');
Route::post('obtener_municipios', 'catalogos\CatalogosController@obtener_municipios')->name('obtener_municipios');
Route::post('obtener_jueces_guardias', 'catalogos\CatalogosController@obtener_jueces_guardias')->name('obtener_jueces_guardias');
Route::post('obtener_jueces_unidad', 'catalogos\CatalogosController@obtener_jueces_unidad')->name('obtener_jueces_unidad');
Route::post('obtener_usuarios_unidad', 'catalogos\CatalogosController@obtener_usuarios_unidad')->name('obtener_usuarios_unidad');
Route::post('obtener_grupo_trabajo', 'catalogos\CatalogosController@obtener_grupo_trabajo')->name('obtener_grupo_trabajo');
Route::post('obtener_tipo_audiencia', 'catalogos\CatalogosController@obtener_tipo_audiencia')->name('obtener_tipo_audiencia');
Route::post('obtener_siguiente_juez_control', 'catalogos\CatalogosController@obtener_siguiente_juez_control')->name('obtener_siguiente_juez_control');
Route::post('obtener_inmuebles', 'catalogos\CatalogosController@obtener_inmuebles')->name('obtener_inmuebles');
Route::post('obtener_inmueble_salas', 'catalogos\CatalogosController@obtener_inmueble_salas')->name('obtener_inmueble_salas');
Route::post('obtener_penas', 'catalogos\CatalogosController@obtener_penas')->name('obtener_penas');
Route::post('obtener_detalle_pena', 'catalogos\CatalogosController@obtener_detalle_pena')->name('obtener_detalle_pena');
Route::post('obtener_catalogo_desagregado', 'catalogos\CatalogosController@obtener_catalogo_desagregado')->name('obtener_catalogo_desagregado');
Route::get('obtener_autoridades_control_constitucional', 'catalogos\CatalogosController@obtener_autoridades_control_constitucional')->name('obtener_autoridades_control_constitucional');
Route::get('ver_reclusorios', 'catalogos\CatalogosController@ver_reclusorios')->name('ver_reclusorios');
Route::get('obtener_jueces', 'catalogos\CatalogosController@obtener_jueces')->name('obtener_jueces');

// SOLICITUDES
Route::post('enviar_solicitud', 'solicitudes\SolicitudesController@enviar_solicitud')->name('enviar_solicitud');
Route::post('enviar_solicitud_editada', 'solicitudes\SolicitudesController@enviar_solicitud_editada')->name('enviar_solicitud_editada');
Route::post('obtener_documentos_solicitud','solicitudes\SolicitudesController@obtener_documentos_solicitud')->name('obtener_documentos_solicitud');
Route::post('obtener_datos_solicitud','solicitudes\SolicitudesController@obtener_datos_solicitud')->name('obtener_datos_solicitud');
Route::post('autorizacion_exhorto','solicitudes\SolicitudesController@autorizacion_exhorto')->name('autorizacion_exhorto');

// GUARDIAS
Route::post('obtener_guardias', 'guardias\GuardiasController@obtener_guardias')->name('obtener_guardias');
Route::post('guardar_guardia', 'guardias\GuardiasController@guardar_guardia')->name('guardar_guardia');
Route::post('guardar_edicion_guardia', 'guardias\GuardiasController@guardar_edicion_guardia')->name('guardar_edicion_guardia');
Route::post('elimina_guardias', 'guardias\GuardiasController@elimina_guardias')->name('elimina_guardias');



// CARPETAS
Route::post('obtener_carpetas_judiciales', 'carpetas\CarpetasController@obtener_carpetas_judiciales')->name('obtener_carpetas_judiciales');
Route::post('obtener_personas_carpeta', 'carpetas\CarpetasController@obtener_personas_carpeta')->name('obtener_personas_carpeta');
Route::get('consulta_partes_carpeta', 'carpetas\CarpetasController@consulta_partes_carpeta')->name('consulta_partes_carpeta');
Route::get('valida_historial_carpeta_remision', 'remisiones\RemisionesController@valida_historial_carpeta_remision')->name('valida_historial_carpeta_remision');
Route::post('generar_carpeta', 'carpetas\CarpetasController@generar_carpeta')->name('generar_carpeta');



// BANDEJAS
Route::post('firmar_documento', 'bandejas\BandejasController@firmar_documento')->name('firmar_documento');
Route::post('obtener_bandeja', 'bandejas\BandejasController@obtener_bandeja')->name('obtener_bandeja');
Route::post('resolver_tarea_solicitud', 'bandejas\BandejasController@resolver_tarea_solicitud')->name('resolver_tarea_solicitud');
Route::post('resolver_tarea_promocion', 'bandejas\BandejasController@resolver_tarea_promocion')->name('resolver_tarea_promocion');
Route::post('avanzar_acuerdo', 'bandejas\BandejasController@avanzar_acuerdo')->name('avanzar_acuerdo');
Route::post('avanzar_documento', 'bandejas\BandejasController@avanzar_documento')->name('avanzar_documento');
Route::post('asignar_clave_ugjems', 'bandejas\BandejasController@asignar_clave_ugjems')->name('asignar_clave_ugjems');
Route::get('obtener_medidas_proteccion', 'bandejas\BandejasController@obtener_medidas_proteccion')->name('obtener_medidas_proteccion');
Route::patch('modificar_medidas_proteccion_persona', 'bandejas\BandejasController@modificar_medidas_proteccion_persona')->name('modificar_medidas_proteccion_persona');
Route::patch('marcar_tareas', 'bandejas\BandejasController@marcar_tareas')->name('marcar_tareas');


// REMISIONES
Route::post('enviar_remision', 'remisiones\RemisionesController@enviar_remision')->name('enviar_remision');
Route::post('obtener_unidad_destino_remision', 'remisiones\RemisionesController@obtener_unidad_destino_remision')->name('obtener_unidad_destino_remision');
Route::post('autorizacion_remision', 'remisiones\RemisionesController@autorizacion_remision')->name('autorizacion_remision');
Route::post('obtener_datos_remision','remisiones\RemisionesController@obtener_datos_remision')->name('obtener_datos_remision');
Route::post('obtener_documentos_remision','remisiones\RemisionesController@obtener_documentos_remision')->name('obtener_documentos_remision');
Route::post('obtener_fechas_aud_sent','remisiones\RemisionesController@obtener_fechas_aud_sent')->name('obtener_fechas_aud_sent');
Route::post('consultar_remisiones_carpeta','remisiones\RemisionesController@consultar_remisiones_carpeta')->name('consultar_remisiones_carpeta');
Route::post('registrar_personas_remision', 'remisiones\RemisionesController@registrar_personas_remision')->name('registrar_personas_remision');
Route::get('obtener_personas_remision', 'remisiones\RemisionesController@obtener_personas_remision')->name('obtener_personas_remision');
Route::post('actualizar_personas_remision', 'remisiones\RemisionesController@actualizar_personas_remision')->name('actualizar_personas_remision');
Route::get('obtener_documentos_inf_comp', 'remisiones\RemisionesController@obtener_documentos_inf_comp')->name('obtener_documentos_inf_comp');
Route::post('remision_eje_autorizacion', 'remisiones\RemisionesController@remision_eje_autorizacion')->name('remision_eje_autorizacion');
Route::get('obtener_inmueble_fiscalia', 'remisiones\RemisionesController@obtener_inmueble_fiscalia')->name('obtener_inmueble_fiscalia');
Route::post('modificar_remision', 'remisiones\RemisionesController@modificar_remision')->name('modificar_remision');

// DOCUMENTOS
Route::post('obtener_ultima_version_acuerdo', 'documentos\DocumentosController@obtener_ultima_version_acuerdo')->name('obtener_ultima_version_acuerdo');
Route::post('obtener_ultima_version_oficio', 'documentos\DocumentosController@obtener_ultima_version_oficio')->name('obtener_ultima_version_oficio');
Route::post('vista_previa', 'documentos\DocumentosController@vista_previa')->name('vista_previa');
Route::post('obtener_documentos_promocion', 'documentos\DocumentosController@obtener_documentos_promocion')->name('obtener_documentos_promocion');
Route::post('obtener_anexo', 'documentos\DocumentosController@obtener_anexo')->name('obtener_anexo');
Route::post('prueba_firma', 'documentos\DocumentosController@prueba_firma')->name('prueba_firma');

// SERVICIOS PARA CONSULTAS EXTERNAS
Route::post('enviar_promocion_xml', 'solicitudes\SolicitudesController@enviar_promocion_xml')->name('enviar_promocion_xml');
Route::post('enviar_solicitud_xml', 'solicitudes\SolicitudesController@enviar_solicitud_xml')->name('enviar_solicitud_xml');
Route::post('enviar_solicitud_public', 'solicitudes\SolicitudesController@enviar_solicitud_public')->name('enviar_solicitud_public');
Route::get('consulta_reportes_adip', 'adip\AdipController@consulta_reportes_adip')->name('consulta_reportes_adip');
Route::get('obtener_archivo_reporte_adip/{id_reporte}/{nombre_reporte?}/{tipo_archivo?}', 'adip\AdipController@obtener_archivo_reporte_adip')->name('obtener_archivo_reporte_adip');

// CHIA
Route::get('obtener_valores_chia', 'chia\ChiaController@obtener_valores_chia')->name('obtener_valores_chia');
Route::post('registrar_valor_chia', 'chia\ChiaController@registrar_valor_chia')->name('registrar_valor_chia');
Route::post('actualizar_valor_chia', 'chia\ChiaController@actualizar_valor_chia')->name('actualizar_valor_chia');
Route::post('valida_valor', 'chia\ChiaController@valida_valor')->name('valida_valor');
Route::post('actualizar_devolucion', 'chia\ChiaController@actualizar_devolucion')->name('actualizar_devolucion');
Route::post('transferir_valor_chia', 'chia\ChiaController@transferir_valor_chia')->name('transferir_valor_chia');
Route::get('ver_documento_chia/{valor?}/{id_documento?}/{redirect?}', 'chia\ChiaController@ver_documento_chia')->name('ver_documento_chia');
Route::get('formato_devolucion', 'chia\ChiaController@formato_devolucion')->name('formato_devolucion');

// AMPAROS
Route::post('enviar_amparo', 'amparos\AmparosController@enviar_amparo')->name('enviar_amparo');
Route::get('obtener_amparos', 'amparos\AmparosController@obtener_amparos')->name('obtener_amparos');

//SUSTITUCIONES 
Route::get('obtener_sustituciones', 'sustituciones\SustitucionesController_h@obtener_sustituciones')->name('obtener_sustituciones');

//EXHORTOS
Route::get('valida_existencia_exhorto', 'exhortos\ExhortosController_h@obtener_carpetas_judiciales_exhortos')->name('valida_existencia_exhorto');
Route::get('obtener_acuse_exhorto', 'exhortos\ExhortosController_h@obtener_acuse_exhorto')->name('obtener_acuse_exhorto');

//APELACIONES
Route::post('enviar_apelacion', 'apelaciones\ApelacionesController@enviar_apelacion')->name('enviar_apelacion');
Route::get('obtener_apelaciones', 'apelaciones\ApelacionesController@obtener_apelaciones')->name('obtener_apelaciones');


// Rutas temporales

// Route::post('h_obtener_carpetas_judiciales_h', 'carpetas\h_CarpetasController_h@obtener_carpetas_judiciales')->name('h_obtener_carpetas_judiciales_h');

include 'api_externos_soap.php';
