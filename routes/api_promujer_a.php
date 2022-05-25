<?php

Route::post('promujer_enviar_solicitud', 'promujer\promujerController@enviar_solicitud')->name('promujer_enviar_solicitud');

Route::post('promujer_actualiza_solicitud', 'promujer\promujerController@actualiza_solicitud')->name('promujer_actualiza_solicitud');






Route::get('/obtener_solicitud_promujer',"promujer\promujerController@obtener_solicitudes_promujer")->name('obtener_solicitud_promujer');

Route::get('promujer_descargar_pdf/{id_solicitud}',"promujer\promujerController@descargar_pdf")->name('promujer_descargar_pdf');

Route::get('descargar_archivos_promujer/{id_solicitud}/{id_version}',"promujer\promujerController@descargar_pdfs_promujer")->name('descargar_archivos');
