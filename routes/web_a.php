<?php

Route::get("consulta_solicitudes", "solicitudes\SolicitudesController@consulta_solicitudes" ) -> name('consulta_solicitudes');

Route::get('/exportar_busqueda_solicitudes',"solicitudes\SolicitudesController_h@exportar_busqueda")->name('exportar_busqueda_solicitudes');



// Administracion de dias inhabiles
Route::get('dias_inhabiles', 'dias_inhabiles\DiasInhabilesController@dias_inhabiles')->name('dias_inhabiles');

//usuarios
Route::get('consulta_usuarios', 'usuarios\usuariosController@consulta_usuarios')->name('consulta_usuarios');
Route::get('exportar_busqueda_usuarios', 'usuarios\usuariosController@exportar_busqueda_usuarios')->name('exportar_busqueda_usuarios');
Route::get('consultar_oficios_usmc', 'usmc\control_usmc@consultar_oficios_usmc')->name('consultar_oficios_usmc');

//tipos de audiencia
Route::get('consulta_tipos_audiencia','usuarios\usuariosController@consulta_tipos_audiencia')->name('consulta_tipos_audiencia');

//
