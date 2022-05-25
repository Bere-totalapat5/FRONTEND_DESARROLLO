<?php

// /*** RUTAS PARA ADMINISTRAR DIAS NO LABORALES
  Route::post('consultar_dias_inhabiles', 'dias_inhabiles\DiasInhabilesController@consultar_dias_inhabiles')->name('consultar_dias_inhabiles');
  Route::post('nuevo_dia_inhabil', 'dias_inhabiles\DiasInhabilesController@nuevo_dia_inhabil')->name('nuevo_dia_inhabil');
  Route::post('estatus_dia_inhabil', 'dias_inhabiles\DiasInhabilesController@estatus_dia_inhabil')->name('estatus_dia_inhabil');
//  TERMINA RUTAS PARA ADMINISTRAR DIAS NO LABORALES ***/

// CARPETAS - PARA CAMBIAR EL JUEZ DE CJ PROMUJER Y EJECUCION
  Route::post('cambiar_juez_predefinido', 'carpetas\CarpetasController@cambiar_juez_predefinido')->name('cambiar_juez_predefinido');
  Route::post('exportar_consulta_carpetas', 'carpetas\CarpetasController@exportar_consulta_carpetas')->name('exportar_consulta_carpetas');

// /*** RUTAS PARA USUARIOS
  Route::get('consulta_usuarios_filtros', 'usuarios\usuariosController@consulta_usuarios_filtros')->name('consulta_usuarios_filtros');
  Route::post('guardar_usuario', 'usuarios\usuariosController@guardar_usuario')->name('guardar_usuario');
  Route::post('ver_usuario', 'usuarios\usuariosController@ver_usuario')->name('ver_usuario');
  Route::post('guardar_cambios', 'usuarios\usuariosController@guardar_cambios')->name('guardar_cambios');
  Route::post('generar_usuarios', 'usuarios\usuariosController@generar_usuarios')->name('generar_usuarios');
  Route::post('cambio_adscripcion', 'usuarios\usuariosController@cambio_adscripcion')->name('cambio_adscripcion');
  Route::post('tipo', 'usuarios\usuariosController@tipo')->name('tipo');
//  TERMINA RUTAS PARA USUARIOS ***/

// /*** RUTAS PARA TIPOS DE AUDIENICA
  Route::get('consulta_tas', 'usuarios\usuariosController@consulta_tas', function(){
    dd('ruta OK');
});


// /*** RUTAS PARA TIPOS DE AUDIENICA




// /*** RUTAS PARA agregar_parte_procesal
  Route::post('agregar_parte_procesal', 'carpetas\CarpetasController@agregar_parte_procesal')->name('agregar_parte_procesal');
  Route::post('modificar_parte_procesal', 'carpetas\CarpetasController@modificar_parte_procesal')->name('modificar_parte_procesal');
  Route::post('borrar_parte_procesal', 'carpetas\CarpetasController@borrar_parte_procesal')->name('borrar_parte_procesal');
  Route::post('modificar_bandera_identidad_parte_procesal', 'carpetas\CarpetasController@modificar_bandera_identidad_parte_procesal')->name('modificar_bandera_identidad_parte_procesal');
//  TERMINA RUTAS PARA agregar_parte_procesal ***/

// /***RUTAS PARA DELITOS NO RELACIONADOS */
  Route::post('relacionar_delitos_sin_relacionar', 'carpetas\CarpetasController@relacionar_delitos_sin_relacionar')->name('relacionar_delitos_sin_relacionar');
  Route::post('actualizar_delito_sin_relacionar', 'carpetas\CarpetasController@actualizar_delito_sin_relacionar')->name('actualizar_delito_sin_relacionar');
// /***TERMINAN RUTAS */


// /*** RUTAS PARA DOCUMENTOS ASOCIADOS*/
  Route::post('obtener_documentos_asociados_carpeta', 'carpetas\CarpetasController@obtener_documentos_asociados_carpeta')->name('obtener_documentos_asociados_carpeta');
  Route::post('guardar_documentos_asociados_carpeta', 'carpetas\CarpetasController@guardar_documentos_asociados_carpeta')->name('guardar_documentos_asociados_carpeta');
  Route::post('coser_documentos_asociados', 'carpetas\CarpetasController@coser_documentos_asociados')->name('coser_documentos_asociados');
  Route::post('obtener_carpetas_acumuladas', 'carpetas\CarpetasController@obtener_carpetas_acumuladas')->name('obtener_carpetas_acumuladas');
  Route::post('estatus_documento_solicitud_inicial', 'carpetas\CarpetasController@estatus_documento_solicitud_inicial')->name('estatus_documento_solicitud_inicial');
  Route::post('estatus_version_acuerdo', 'carpetas\CarpetasController@editar_version_acuerdo')->name('editar_version_acuerdo');
  Route::post('estatus_documento_promocion', 'carpetas\CarpetasController@estatus_documento_promocion')->name('estatus_documento_promocion');

  // /*** Termina rutas */

  // /**** RUTAS PARA DOCUMENTOS GENERADOS */
  Route::post('obtener_documentos_generados', 'carpetas\CarpetasController@obtener_documentos_generados')->name('obtener_documentos_generados');
  Route::post('obtener_plantilla_documento_generado_carpeta', 'carpetas\CarpetasController@obtener_plantilla_documento_generado_carpeta')->name('obtener_plantilla_documento_generado_carpeta');
  Route::post('obtener_usuarios_por_tipo', 'carpetas\CarpetasController@obtener_usuarios_por_tipo')->name('obtener_usuarios_por_tipo');
  Route::post('obtener_catalogo_usmeca', 'carpetas\CarpetasController@obtener_catalogo_usmeca')->name('obtener_catalogo_usmeca');
  Route::post('avanzar_documento_generado_carpeta', 'carpetas\CarpetasController@avanzar_documento_generado_carpeta')->name('avanzar_documento_generado_carpeta');
  Route::post('obtener_archivo_firma_autografa', 'carpetas\CarpetasController@obtener_archivo_firma_autografa')->name('obtener_archivo_firma_autografa');
  Route::post('obtener_ultima_version_documento_generado', 'carpetas\CarpetasController@obtener_ultima_version_documento_generado')->name('obtener_ultima_version_documento_generado');
  Route::post('actualizar_documento_generado', 'carpetas\CarpetasController@actualizar_documento_generado')->name('actualizar_documento_generado');
  Route::post('enviar_solicitud_usmeca', 'carpetas\CarpetasController@enviar_solicitud_usmeca')->name('enviar_solicitud_usmeca');
  // /*** Termina rutas */

  // /*** RUTAS PARA AUDIENCIAS*/
  Route::post('consulta_audiencias', 'carpetas\CarpetasController@consulta_audiencias')->name('consulta_audiencias');
  Route::post('crear_audiencia', 'carpetas\CarpetasController@crear_audiencia')->name('crear_audiencia');
  Route::post('modificar_estatus_audiencia_cj', 'carpetas\CarpetasController@modificar_estatus_audiencia_cj')->name('modificar_estatus_audiencia_cj');
  Route::post('modificar_audiencia_cj', 'carpetas\CarpetasController@modificar_audiencia')->name('modificar_audiencia_cj');
  Route::post('estatusRecurso_logic', 'carpetas\CarpetasController@estatusRecurso_logic')->name('estatusRecurso_logic');
  Route::post('consultar_documento_cancelacion_audiencia', 'carpetas\CarpetasController@consultar_documento_cancelacion_audiencia')->name('consultar_documento_cancelacion_audiencia');
  // TERMINA RUTAS

  // /*** RUTAS PARA INCIDENCIAS */
  Route::post('obtener_incidencias_cj', 'carpetas\CarpetasController@obtener_incidencias')->name('obtener_incidencias_cj');
  // TERMINA RUTAS


  // /*** RUTAS PARA HISTORIALES */
  Route::post('consulta_historial', 'carpetas\CarpetasController@consulta_historial')->name('consulta_historial');
  Route::post('historial_estatus_imputado', 'carpetas\CarpetasController@historial_estatus_imputado')->name('historial_estatus_imputado');
  Route::post('ver_catalogo_situacion_imputado', 'carpetas\CarpetasController@ver_catalogo_situacion_imputado')->name('ver_catalogo_situacion_imputado');
  Route::post('ver_imputados', 'carpetas\CarpetasController@ver_imputados')->name('ver_imputados');
  Route::post('guardar_cambio_estatus', 'carpetas\CarpetasController@guardar_cambio_estatus')->name('guardar_cambio_estatus');
  Route::post('guardar_acumular', 'carpetas\CarpetasController@guardar_acumular')->name('guardar_acumular');
  Route::post('ver_ugas', 'carpetas\CarpetasController@ver_ugas')->name('ver_ugas');
  Route::post('prestamo_carpeta', 'carpetas\CarpetasController@prestamo_carpeta')->name('prestamo_carpeta');

  Route::post('devolver_carpeta', 'carpetas\CarpetasController@devolver_carpeta')->name('devolver_carpeta');
  Route::post('cambiar_situacion_carpeta','carpetas\CarpetasController@cambiar_situacion_carpeta');


  // /** termina rutas */
  Route::get('consulta_vida_carpeta', 'carpetas\CarpetasController@consulta_vida_carpeta')->name('consulta_vida_carpeta');
  Route::post('borrar_carpeta_judicial', 'carpetas\CarpetasController@borrar_carpeta_judicial')->name('borrar_carpeta_judicial');
  Route::post('sincronizacion_carpeta', 'carpetas\CarpetasController@sincronizacion_carpeta')->name('sincronizacion_carpeta');
  Route::post('obtener_audiencias_viejo_penal', 'carpetas\CarpetasController@obtener_audiencias_viejo_penal')->name('obtener_audiencias_viejo_penal');


  // Ruta oara consultar acuerdos
  Route::get('consulta_acuerdos_carpeta', 'carpetas\CarpetasController@consulta_acuerdos_carpeta')->name('consulta_acuerdos_carpeta');
  //  Route::get('consulta_archivo_promociones_carpeta/{modo?}', 'carpetas\CarpetasController@consulta_archivo_promociones_carpeta')->name('consulta_archivo_promociones_carpeta');

  // Rutas para remisiones
  Route::get('consulta_remisiones_carpeta', 'carpetas\CarpetasController@consulta_remisiones_carpeta')->name('consulta_remisiones_carpeta');
  Route::get('obtener_remisiones_por_tipo', 'carpetas\CarpetasController@obtener_remisiones_por_tipo')->name('obtener_remisiones_por_tipo');


  // /*** RUTAS PARA VIDA CARPETA JUDIDICAL


  //****RUTAS PARA MODULO USMC DEGT */
  //Route::get('consultar_oficios_usmc', 'usmc\control_usmc@consultar_oficios_usmc')->name('consultar_oficios_usmc');

  // /* RUTAS PARA NOTIFICACONE SY ALERTAS */ //
  Route::post('obtener_notificaciones', 'carpetas\CarpetasController@obtener_notificaciones')->name('obtener_notificaciones');
  Route::post('nueva_notificacion', 'carpetas\CarpetasController@nueva_notificacion')->name('nueva_notificacion');
  Route::post('editar_notificacion', 'carpetas\CarpetasController@editar_notificacion')->name('editar_notificacion');
  // TERMINA RUTAS


  // RUTAS PARA DELITOS ESTADÍSTICOS
  //Route::post('guardar_delito_estadistico', 'carpetas\CarpetasController@guardar_delito_estadistico')->name('guardar_delito_estadistico');
  Route::get('obtener_desagregado_delito_estadistico', 'catalogos\CatalogosController@obtener_desagregado_delito_estadistico')->name('obtener_desagregado_delito_estadistico');
  Route::post('asignar_delito_estadistico_persona', 'carpetas\CarpetasController@asignar_delito_estadistico_persona')->name('asignar_delito_estadistico_persona');
