<?php

Route::get("/promujer_alta_solicitud", "promujer\promujerController@alta_solicitud")->name("promujer_alta_solicitud");

Route::get("/promujer_edita_solicitud/{id_solicitud}", "promujer\promujerController@edita_solicitud")->name("promujer_edita_solicitud");


Route::get("consulta_promujer", "promujer\promujerController@consulta_promujer")->name("consulta_promujer");

Route::get('/exportar_busqueda_promujer',"promujer\promujerController@exportar_busqueda_promujer")->name('exportar_busqueda_promujer');