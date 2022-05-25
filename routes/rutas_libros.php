<?php
//libros digitales
Route::get("/libros_gobierno/{tipo?}/{libro?}/", "libros_digitales_salas\control_libros_salas@vista_libros") -> name("libros.inicio");

Route::post("/libros_gobierno/buscar_toca/", "libros_digitales_salas\control_libros_salas@buscar_toca") -> name("libros.buscar_toca");

Route::post("/libros_gobierno/guardar/", "libros_digitales_salas\control_libros_salas@guardar_libro") -> name("libros.guardar");

Route::post("/libros_gobierno/buscar_registro/", "libros_digitales_salas\control_libros_salas@buscar_registro") -> name("libros.buscar_registro");

Route::post("/libros_gobierno/guardar_edicion/", "libros_digitales_salas\control_libros_salas@guardar_edicion") -> name("libros.guardar_edicion");

Route::post("/libros_gobierno/datos_base_libro/", "libros_digitales_salas\control_libros_salas@datos_base_libro") -> name("libros.guardar_edicion");

Route::post("/libros_gobierno/{tipo}/{idLibro}/{pagina}", "libros_digitales_salas\control_libros_salas@libro_pagina") -> name("libros.pagina");


//RUTA JUZGADOS
Route::post("/libros_gobierno/buscar_expediente/", "libros_digitales_salas\control_libros_salas@buscar_expediente") -> name("libros.buscar_expediente");

Route::post("/libros_gobierno/guardar/juzgado/", "libros_digitales_salas\control_libros_salas@guardar_libro_juzgado") -> name("libros.guardar.juzgado");

Route::post("/libros_gobierno/buscar_registro/juzgado", "libros_digitales_salas\control_libros_salas@buscar_registro_juzgado") -> name("libros.buscar.registro.juzgado");

Route::post("/libros_gobierno/guardar_edicion/juzgado", "libros_digitales_salas\control_libros_salas@guardar_edicion_juzgado") -> name("libros.guardar.edicion.juzgado");

Route::post("/libros_gobierno/guardar_expediente", "libros_digitales_salas\control_libros_salas@guardar_expediente") -> name("libros.guardar.expediente");

Route::post("/libros_gobierno/consultar_informacion", "libros_digitales_salas\control_libros_salas@consultar_informacion") -> name("libros.informacion");


//BIOMETRICOS
// Route::post("/libros_gobierno/verificar_biometrico", "libros_digitales_salas\control_libros_salas@verificar_biometrico") -> name("libros.verificar_biometrico");