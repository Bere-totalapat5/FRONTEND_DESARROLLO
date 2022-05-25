<?php


Route::get("home","dashboard\control_dashboard@inicio") -> name('home');
Route::post("/home/aviso_sesion", "dashboard\control_dashboard@aviso_sesion") ->  name('home.aviso_sesion');

Route::get("/menu_permisos/{id_usuario?}", "configuracion\control_configuracion@cargar_permisos_menu" ) -> name('menu_permisos');

Route::get("/solicitud_audiencia_inicial", "solicitudes\SolicitudesController@solicitud_audiencia_inicial")->name("solicitud_audiencia_inicial");
Route::get("/editar_solicitud_audiencia_inicial/{solicitud}", "solicitudes\SolicitudesController@editar_solicitud_audiencia_inicial")->name("editar_solicitud_audiencia_inicial");

Route::get("/guardias", "guardias\GuardiasController@guardias")->name("guardias");
Route::get("/guardias_promujer", "guardias\GuardiasController@guardias_promujer")->name("guardias_promujer");

// Carpetas
Route::get("/carpetas_judiciales/{id?}", "carpetas\CarpetasController@carpetas_judiciales")->name("carpetas_judiciales");
Route::get("creacion_carpeta", "carpetas\CarpetasController@creacion_carpeta")->name("creacion_carpeta");


Route::get("/notificaciones", "bandejas\BandejasController@notificaciones")->name("notificaciones");
Route::get("/tareas/{id?}", "bandejas\BandejasController@tareas")->name("tareas");
Route::get("/documentos", "bandejas\BandejasController@documentos")->name("documentos");

Route::get('/obtener_ultima_version_acuerdo/{id_acuerdo?}', 'documentos\DocumentosController@obtener_ultima_version_acuerdo')->name('obtener_ultima_version_acuerdo');
Route::get('/obtener_ultima_version_oficio/{id_carpeta_judicial}/{id_oficio}', 'documentos\DocumentosController@obtener_ultima_version_oficio')->name('obtener_ultima_version_oficio');
Route::get('/vista_previa/{archivo_doc}', 'documentos\DocumentosController@vista_previa')->name('vista_previa');
Route::get('/prueba_firma_electronica', 'documentos\DocumentosController@prueba_firma_electronica')->name('prueba_firma_electronica');

Route::get('obtener_documentos_solicitud/{id_solicitud?}', 'solicitudes\SolicitudesController@obtener_documentos_solicitud')->name('obtener_documentos_solicitud');

Route::get('obtener_documentos_remision/{id_remision?}/{version?}', 'remisiones\RemisionesController@obtener_documentos_remision')->name('obtener_documentos_remision');

// CHIA
Route::get('agregar_valores', 'chia\ChiaController@agregar_valores')->name('agregar_valores');
Route::get('consultar_valores', 'chia\ChiaController@consultar_valores')->name('consultar_valores');

// Amparos
Route::get('recursos_amparo', 'amparos\AmparosController@index_amparos')->name('recursos_amparo');

// Apelaciones
Route::get('recursos_apelacion', 'apelaciones\ApelacionesController@index_apelacion')->name('recursos_apelacion');

// Audiencias
Route::get('audiencias_programadas', 'audiencias\AudienciasController_h@audiencias_programadas')->name('audiencias_programadas');
Route::get('audiencia_carpeta_judicial/{id_carpeta_judicial?}', 'audiencias\AudienciasController_h@audiencia_carpeta_judicial')->name('audiencia_carpeta_judicial');

//Route::get('firmar_documento', 'bandejas\BandejasController@firmar_documento')->name('firmar_documento');

// Rutas temporales

Route::get('carpetas_judiciales_R', 'carpetas\CarpetasController@carpetas_judiciales_R')->name('carpetas_judiciales_R'); 
Route::get('blade_prueba', 'bandejas\BandejasController@blade_prueba')->name('blade_prueba');