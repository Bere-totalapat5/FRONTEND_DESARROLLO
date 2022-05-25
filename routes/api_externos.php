<?php
Route::post('convertToPDF', 'documentos\DocumentosController@convertToPDF')->middleware(['middle_entorno']);
Route::post('convertToPDFPruebas', 'documentos\DocumentosController@convertToPDFPruebas')->middleware(['middle_entorno'])->name('convertToPDFPruebas');

Route::middleware([ "middle_entorno",
                    "middle_webService"])->group(function(){
    //OPC 
    Route::post("opc_promocion_guardar","promociones\control_promociones@opc_promocion_guardar");
    Route::post("opc_promocion_editar","promociones\control_promociones@opc_promocion_editar");


    //GESTOR DOCUMENTAL
    Route::post("gestor_guardar_doc","promociones\control_promociones@gestor_guardar_doc");
    Route::delete("opc_promocion_elimina/{id_promocion}/{proceso}","promociones\control_promociones@opc_promocion_eliminar");
    Route::post("estatus_escaneo_total/{juzgado}/{expediente}/{anio}","promociones\control_promociones@estatus_escaneo_total");
    
    //COSER ACUERDOS
    Route::post("coser_documentos", "bandejas\control_bandejas@documento_descargar_batch_ligitante_ajax");
    Route::post("expediente_digital", "bandejas\control_bandejas@documento_descargar_masivo_expediente_digital_ligitante");


    Route::get("crearSelloSigj", "bandejas\control_bandejas@crearSelloSigj" ) -> name('bandejas.crearSelloSigj');


});  