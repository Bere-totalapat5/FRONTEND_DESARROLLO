<?php

Route::get("consulta_carga", "solicitudes\SolicitudesController_h@consulta_carga" ) -> name('consulta_carga');
Route::get("consulta_bitacora", "solicitudes\SolicitudesController_h@consulta_bitacora" ) -> name('consulta_bitacora');
Route::get("/permisos_default", "solicitudes\SolicitudesController_h@permisos_default" ) -> name('permisos_default');
Route::get('/exportar_carga',"solicitudes\SolicitudesController_h@exportar_carga")->name('exportar_carga');
Route::get('/exportar_busqueda_bitacora',"solicitudes\SolicitudesController_h@exportar_busqueda_bitacora")->name('exportar_busqueda_bitacora');
Route::get("solicitud_inicial_csv", "solicitudes\SolicitudesController_h@solicitud_csv" ) -> name('solicitud_inicial_csv');


//PROMOCIONES
Route::get("/consulta_promociones", "promociones\PromocionesController_h@consulta_promociones" ) -> name('consulta_promociones');
Route::get("/consulta_remisiones", "promociones\PromocionesController_h@consulta_remisiones" ) -> name('consulta_remisiones');
Route::get("/alta_promocion", "promociones\PromocionesController_h@alta_promocion" ) -> name('alta_promocion');
Route::get("/editar_solicitud_promocion/{id_promocion}", "promociones\PromocionesController_h@editar_solicitud_promocion")->name("editar_solicitud_promocion");

//ACLARATORIOS
Route::get("/consulta_aclaratorios", "promociones\PromocionesController_h@consulta_aclaratorios")->name("consulta_aclaratorios");
Route::get("/exportar_busqueda_aclaratorios", "promociones\PromocionesController_h@exportar_busqueda_aclaratorios")->name("exportar_busqueda_aclaratorios");


//REMISIONES
Route::get("/alta_remision", "promociones\PromocionesController_h@reenvio_carpeta" ) -> name('alta_remision');


//SALAS
Route::get("/activacion_salas", "salas\SalasController_h@activacion_salas" ) -> name('activacion_salas');
Route::get("/incidencias_salas", "salas\SalasController_h@incidencias_de_salas" ) -> name('incidencias_salas');
Route::get("/exportar_busqueda_incidencias", "salas\SalasController_h@exportar_busqueda_incidencias")->name("exportar_busqueda_incidencias");


//EXHORTOS
Route::get('consulta_exhortos',"exhortos\ExhortosController_h@ver_exhortos")->name('consulta_exhortos');
Route::get('alta_exhorto',"exhortos\ExhortosController_h@registro_exhortos")->name('alta_exhorto');
Route::get("/editar_solicitud_exhorto/{id_exhorto?}", "exhortos\ExhortosController_h@editar_solicitud_exhorto")->name("editar_solicitud_exhorto");
Route::get('/exportar_busqueda_exhortos',"exhortos\ExhortosController_h@exportar_busqueda_exhortos")->name('exportar_busqueda_exhortos');


// CARPETAS JUDICIALES
Route::get("/h_carpetas_judiciales_h", "carpetas\h_CarpetasController_h@carpetas_judiciales")->name("h_carpetas_judiciales_h");


// ACUERDOS
Route::get("/consulta_acuerdos", "acuerdos\AcuerdosController_h@consulta_acuerdos")->name("consulta_acuerdos");
Route::get("/exportar_busqueda_acuerdos", "acuerdos\AcuerdosController_h@exportar_busqueda_acuerdos")->name("exportar_busqueda_acuerdos");


// LEYENDAS
Route::get("/consulta_leyendas", "leyendas\LeyendasController_h@consulta_leyendas")->name("consulta_leyendas");


// AUDIENCIAS
Route::get('consulta_audiencias',"audiencias\AudienciasController_h@consulta_audiencias")->name('consulta_audiencias');
Route::get("/exportar_busqueda_audiencias", "audiencias\AudienciasController_h@exportar_busqueda_audiencias")->name("exportar_busqueda_audiencias");


// SUSTITUCIONES

Route::get("/sustituciones", "sustituciones\SustitucionesController_h@ver_sustituciones")->name("sustituciones");

