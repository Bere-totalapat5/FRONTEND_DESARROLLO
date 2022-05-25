<?php

Route::get('juicio/nuevo/{id_promocion?}', 'juicios\juicios@nuevo')->name('juicio/nuevo');

// Route::post('juicio/verificaJuicio', 'juicios\juicios@verifica')->name('juicio/verificaJuicio');

// Route::post('juicio/catalogoJuicios', 'juicios\juicios@catalogoJuicios')->name('juicio/catalogoJuicios');

// Route::post('juicio/guardarArchivo', 'juicios\juicios@guardarArchivo')->name('juicio/guardarArchivo');

// Route::post('juicio/juzgados', 'juicios\juicios@juzgados')->name('juicio/juzgados');

// Route::post('juicio/buscarExpediente', 'juicios\juicios@buscarExpediente')->name('juicio/buscarExpediente');

// Route::post('juicio/buscarToca', 'juicios\juicios@buscarToca')->name('juicio/buscarToca');

// Route::post('juicio/datosToca', 'juicios\juicios@datosToca')->name('juicio/datosToca');

Route::get('juicio/editar/{id_juicio?}', 'juicios\juicios@editar')->name('juicio/editar');

Route::post('juicio/actualizarArchivo', 'juicios\juicios@actualizarArchivo')->name('juicio/actualizarArchivo');

// Route::post('juicio/buscar_opc', 'juicios\juicios@buscar_opc')->name('buscar_opc');


