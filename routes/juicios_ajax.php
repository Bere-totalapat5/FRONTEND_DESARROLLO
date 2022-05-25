<?php

// Route::get('juicio/nuevo/{id_promocion?}', 'juicios\juicios@nuevo')->name('juicio/nuevo');

Route::post('juicio_ajax/verificaJuicio', 'juicios\juicios@verifica')->name('juicio_ajax/verificaJuicio');

Route::post('juicio_ajax/catalogoJuicios', 'juicios\juicios@catalogoJuicios')->name('juicio_ajax/catalogoJuicios');

Route::post('juicio_ajax/guardarArchivo', 'juicios\juicios@guardarArchivo')->name('juicio_ajax/guardarArchivo');

Route::post('juicio_ajax/juzgados', 'juicios\juicios@juzgados')->name('juicio_ajax/juzgados');

Route::post('juicio_ajax/buscarExpediente', 'juicios\juicios@buscarExpediente')->name('juicio_ajax/buscarExpediente');

Route::post('juicio_ajax/buscarToca', 'juicios\juicios@buscarToca')->name('juicio_ajax/buscarToca');

Route::post('juicio_ajax/datosToca', 'juicios\juicios@datosToca')->name('juicio_ajax/datosToca');

// Route::get('juicio/editar/{id_juicio?}', 'juicios\juicios@editar')->name('juicio/editar');

Route::post('juicio_ajax/actualizarArchivo', 'juicios\juicios@actualizarArchivo')->name('juicio_ajax/actualizarArchivo');

Route::post('juicio_ajax/buscar_opc', 'juicios\juicios@buscar_opc')->name('juicio_ajax_buscar_opc');

