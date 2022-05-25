<?php

Route::post('obtener_jueces_ejecucion', 'catalogos\CatalogosController@obtener_jueces_ejecucion')->name('obtener_jueces_ejecucion');
Route::post('obtener_juez_tramite', 'catalogos\CatalogosController@obtener_juez_tramite')->name('obtener_juez_tramite');
Route::post('obtener_horarios_salas', 'catalogos\CatalogosController@obtener_horarios_salas')->name('obtener_horarios_salas');
Route::post('obtener_ver_tipos_recursos', 'catalogos\CatalogosController@obtener_ver_tipos_recursos')->name('obtener_ver_tipos_recursos');
Route::post('obtener_nombre_tipos_recursos', 'catalogos\CatalogosController@obtener_nombre_tipos_recursos')->name('obtener_nombre_tipos_recursos');
Route::post('obtener_horarios_recursos', 'catalogos\CatalogosController@obtener_horarios_recursos')->name('obtener_horarios_recursos');

