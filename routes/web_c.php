<?php
//Conuslta reportes Delitos y Libertades
Route::get("/consulta_reportes", "descarga_reportes\DescargaReportesController@vista_descarga_reportes")->name("consulta_reportes");

//Reporte de libertades
Route::get("/reporte_libertades", "descarga_reportes\DescargaReportesController@vista_reporte_libertades")->name("reporte_libertades");

// Informes de desempeño
Route::get("/informes_DEGJ", "descarga_reportes\DescargaReportesController@vista_informes")->name("informes_DEGJ");

// Tablero de ejecucion
Route::get("/reporte_ejecucion", "carpetas\CarpetasController@reporte_ejecucion_vista")->name("reporte_ejecucion");

//Prueba de Websockets
Route::get("/websockets", "pruebas_websockets\WebsocketController@vista_websockets")->name("websockets");

// Route::get('/message', "pruebas_websockets\WebsocketController@sendMessage")->name("message");

//Personas Global 
Route::get("/personas", "descarga_reportes\DescargaReportesController@personasGlobal")->name("personas");

// ADIP
Route::get("/consulta_adip", "adip\AdipController_cc@consulta_adip")->name("consulta_adip");

//ADIP Temporal
//Route::get("/consulta_adip_cc", "adip\AdipController_cc@consulta_adip")->name("consulta_adip_cc");

// Grupo de jueces
Route::get("/administracion_jueces", "jueces\JuecesController_h@ver_admon_jueces")->name("administracion_jueces");

// ####### Recursos de audiencia #######
Route::get("/recursos_adicionales", "jueces\JuecesController_h@ver_recursos_adicionales")->name("recursos_adicionales");

//Grupo de jueces
Route::get("/grupo_jueces", "jueces\JuecesController_h@consulta_grupos_jueces")->name("grupo_jueces");

//	Registro de solicitudes iniciales (Tribunal de Enjuiciamiento / Ejecución)
Route::get("/solicitudes_ejecucion_tribunal_enjuciamiento", "solicitudes\SolicitudesController@solicitudes_ejecucion_tribunal_enjuciamiento")->name("solicitudes_ejecucion_tribunal_enjuciamiento");

// Acuerdos Reparatorios 
Route::get("/acuerdos_reparatorios", "descarga_reportes\DescargaReportesController@vista_acuerdos_reparatorios")->name("acuerdos_reparatorios");
