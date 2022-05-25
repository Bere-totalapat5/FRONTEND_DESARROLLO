<?php
//BUSCAR REGISTRO
Route::post("/libros_java_buscar_registro", "libros_digitales_java\control_libros_java_PIC@buscar_registro");


//BUSCAR EXPEDIENTE
Route::post("/libros_java_buscar_expediente", "libros_digitales_java\control_libros_java_PIC@buscar_expediente");


//TABLA LIBROS
Route::post("/registros_libros", "libros_digitales_java\control_libros_java_PIC@registros_libros");


//LIBROS PIC
Route::post("/guardar_egreso_JPIC", "libros_digitales_java\control_libros_java_PIC@guardar_egreso_JPIC");
Route::post("/guardar_notarios_JPIC", "libros_digitales_java\control_libros_java_PIC@guardar_notarios_JPIC");
Route::post("/guardar_ministerio_JPIC", "libros_digitales_java\control_libros_java_PIC@guardar_ministerio_JPIC");

Route::post("/editar_egreso_JPIC", "libros_digitales_java\control_libros_java_PIC@editar_egreso_JPIC");
Route::post("/editar_notarios_JPIC", "libros_digitales_java\control_libros_java_PIC@editar_notarios_JPIC");
Route::post("/editar_ministerio_JPIC", "libros_digitales_java\control_libros_java_PIC@editar_ministerio_JPIC");


//LIBROS PIF
Route::post("/guardar_egresos_JPIF", "libros_digitales_java\control_libros_java_PIF@guardar_egresos_JPIF");
Route::post("/guardar_notarios_JPIF", "libros_digitales_java\control_libros_java_PIF@guardar_notarios_JPIF");
Route::post("/guardar_turno_JPIF", "libros_digitales_java\control_libros_java_PIF@guardar_turno_JPIF");
Route::post("/guardar_remision_JPIF", "libros_digitales_java\control_libros_java_PIF@guardar_remision_JPIF");

Route::post("/editar_egresos_JPIF", "libros_digitales_java\control_libros_java_PIF@editar_egresos_JPIF");
Route::post("/editar_notarios_JPIF", "libros_digitales_java\control_libros_java_PIF@editar_notarios_JPIF");
Route::post("/editar_turno_JPIF", "libros_digitales_java\control_libros_java_PIF@editar_turno_JPIF");
Route::post("/editar_remision_JPIF", "libros_digitales_java\control_libros_java_PIF@editar_remision_JPIF");


//LIBROS PC
Route::post("/guardar_egresos_JPC", "libros_digitales_java\control_libros_java_PC@guardar_egresos_JPC");
Route::post("/guardar_notarios_JPC", "libros_digitales_java\control_libros_java_PC@guardar_notarios_JPC");

Route::post("/editar_egresos_JPC", "libros_digitales_java\control_libros_java_PC@editar_egresos_JPC");
Route::post("/editar_notarios_JPC", "libros_digitales_java\control_libros_java_PC@editar_notarios_JPC");


//LIBROS JCO
Route::post("/guardar_notarios_JJCO", "libros_digitales_java\control_libros_java_JCO@guardar_notarios_JJCO");
Route::post("/guardar_fianzas_JJCO", "libros_digitales_java\control_libros_java_JCO@guardar_fianzas_JJCO");

Route::post("/editar_notarios_JJCO", "libros_digitales_java\control_libros_java_JCO@editar_notarios_JJCO");
Route::post("/editar_fianzas_JJCO", "libros_digitales_java\control_libros_java_JCO@editar_fianzas_JJCO");


//LIBROS JFO
Route::post("/guardar_egresos_JJFO", "libros_digitales_java\control_libros_java_JFO@guardar_egresos_JJFO");
Route::post("/guardar_notarios_JJFO", "libros_digitales_java\control_libros_java_JFO@guardar_notarios_JJFO");
Route::post("/guardar_turno_JJFO", "libros_digitales_java\control_libros_java_JFO@guardar_turno_JJFO");
Route::post("/guardar_remision_JJFO", "libros_digitales_java\control_libros_java_JFO@guardar_remision_JJFO");

Route::post("/editar_egresos_JJFO", "libros_digitales_java\control_libros_java_JFO@editar_egresos_JJFO");
Route::post("/editar_notarios_JJFO", "libros_digitales_java\control_libros_java_JFO@editar_notarios_JJFO");
Route::post("/editar_turno_JJFO", "libros_digitales_java\control_libros_java_JFO@editar_turno_JJFO");
Route::post("/editar_remision_JJFO", "libros_digitales_java\control_libros_java_JFO@editar_remision_JJFO");