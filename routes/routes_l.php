<?php

//pruebas

Route::get("/probarmetodo", "bandejas\control_bandejas@probarmetodo" ) -> name('pruebas.probarmetodo');
Route::get("/firmar_tsjcdmx", "bandejas\control_bandejas@firmar_tsjcdmx" ) -> name('pruebas.firmar_tsjcdmx');
Route::get("/probarpdf", "pruebas\control_pruebas@probarpdf" ) -> name('pruebas.probarpdf');
Route::get("/probardocumento", "pruebas\control_pruebas@probardocumento" ) -> name('pruebas.probarpdf');
Route::get("/descarga_gestor/{idDocument}", "pruebas\control_pruebas@descarga_gestor" ) -> name('pruebas.descarga_gestor');
Route::post("/probar_excel", "pruebas\control_pruebas@probar_excel" ) -> name('pruebas.probar_excel');
Route::post("/probar_pdf", "pruebas\control_pruebas@probar_pdf" ) -> name('pruebas.probar_pdf');
  
/*
*   NO NECESITAN DE INTERFAZ GRÁFICA 
*/ 

require 'juicios_ajax.php'; 
//require 'rutas_libros_ajax.php';  

//Expedientes  
Route::post("/home", "dashboard\control_dashboard@buscar_archivo_ajax") ->  name('home.buscar'); 
Route::post("/home/aviso_sesion", "dashboard\control_dashboard@aviso_sesion") ->  name('home.aviso_sesion'); 
Route::post("/home/archivoDetalles/{id}", "dashboard\control_dashboard@archivo_detalles_ajax") ->  name('home.archivoDetallesAjax');
Route::post("/turnarTocaInfo", "dashboard\control_dashboard@turnar_toca_info_ajax") ->  name('home.turnar_toca_info_ajax');
Route::post("/turnarTocaGuardar", "dashboard\control_dashboard@turnar_toca_guardar") ->  name('home.turnar_toca_guardar');
Route::post("/validarLitigante", "dashboard\control_dashboard@validar_litigante") ->  name('home.validar_litigante');

//flujos
Route::post("/acuerdo_flujo", "acuerdo_detalles\control_acuerdo_detalles@guardarFlujo" ) -> name('acuerdo_flujo.guardar');
Route::post("/acuerdo_detalles", "acuerdo_detalles\control_acuerdo_detalles@guardar" ) -> name('acuerdo_detalles.guardar');
Route::post("/editar_acuerdo_flujo_ajax", "acuerdo_detalles\control_acuerdo_detalles@editar_acuerdo_flujo_ajax" ) -> name('acuerdo_flujo.editar_acuerdo_flujo_ajax');
Route::post("/acuerdo_flujo_detalles", "acuerdo_detalles\control_acuerdo_detalles@mostrarFlujoDetalles_ajax" ) -> name('acuerdo_flujo.mostrarDetallesParticpantes');
Route::post("/acuerdo_flujo_participantes", "acuerdo_detalles\control_acuerdo_detalles@mostrarFlujoParticipantes_ajax" ) -> name('acuerdo_flujo.mostrarFlujoParticpantes');
Route::post("/asignacion_flujo_participantes", "acuerdo_detalles\control_acuerdo_detalles@mostrarFlujoParticipantesAsignacion_ajax" ) -> name('acuerdo_flujo.mostrarFlujoParticpantesAsignacion');
Route::post("/asignacion_flujo_participantes_guardar", "acuerdo_detalles\control_acuerdo_detalles@guardarFlujoParticipantesAsignacion" ) -> name('acuerdo_flujo.guardarFlujoParticpantesAsignacion');

//Acuerdos
Route::post("/acuerdo_detalles/eliminarAcuerdo", "acuerdo_detalles\control_acuerdo_detalles@eliminarAcuerdo_ajax" ) -> name('acuerdo_detalles.eliminarAcuerdo_ajax');
Route::post("/acuerdo_detalles/cancelarFechaPublicacion_ajax", "acuerdo_detalles\control_acuerdo_detalles@cancelar_publicacion_ajax" ) -> name('acuerdo_detalles.cancelarFechaPublicacion_ajax');
Route::post("/acuerdo_detalles/expediente_digital", "acuerdo_detalles\control_acuerdo_detalles@expediente_digital") ->  name('acuerdo_detalles.expediente_digital');
Route::post("/acuerdo_detalles/eliminar_relacion", "acuerdo_detalles\control_acuerdo_detalles@eliminar_relacion") ->  name('acuerdo_detalles.eliminar_relacion');
Route::post("/acuerdo_detalles/crear_relacion_promocion_ventana", "acuerdo_detalles\control_acuerdo_detalles@crear_relacion_promocion_ventana") ->  name('acuerdo_detalles.crear_relacion_promocion_ventana');
Route::post("/acuerdo_detalles/crear_relacion_promocion_accion", "acuerdo_detalles\control_acuerdo_detalles@crear_relacion_promocion_accion") ->  name('acuerdo_detalles.crear_relacion_promocion_accion');


Route::post("/bandejas/guardarAcuerdoDocumento", "acuerdo_detalles\control_acuerdo_detalles@guardar_acuerdo_documento" ) -> name('bandeja.guardar_acuerdo_documento');
Route::post("/bandejas/formularioAcuerdoGuardarAjax", "acuerdo_detalles\control_acuerdo_detalles@formulario_acuerdo_guardar_ajax" ) -> name('bandeja.formulario_acuerdo_guardar_ajax');
Route::post("/acuerdo_detalle/mostrarCalendarioAudiencias", "acuerdo_detalles\control_acuerdo_detalles@mostrarCalendarioAudiencias" ) -> name('acuerdo_detalle.mostrarCalendarioAudiencias');
Route::post("/acuerdo_detalle/accionPaginatorAcuerdos_ajax", "acuerdo_detalles\control_acuerdo_detalles@accionPaginatorAcuerdos_ajax" ) -> name('acuerdo_detalle.accionPaginatorAcuerdos_ajax');
 
//Bandejas 
Route::post("/bandejas/formularioAcuerdoInfoVisibleAjax", "acuerdo_detalles\control_acuerdo_detalles@formulario_acuerdo_info_visible_ajax" ) -> name('bandeja.formulario_acuerdo_info_visible_ajax');
Route::post("/bandejas/formularioAcuerdoNotificacionAjax", "acuerdo_detalles\control_acuerdo_detalles@formulario_acuerdo_notificacion_ajax" ) -> name('bandeja.formulario_acuerdo_notificacion_ajax');
Route::post("/bandejas/formularioAcuerdoNotificacionGuardarAjax", "acuerdo_detalles\control_acuerdo_detalles@formulario_acuerdo_notificacion_guardar_ajax" ) -> name('bandeja.formulario_acuerdo_notificacion_guardar_ajax');
Route::post("/bandejas/formularioAcuerdoInfoAjax", "acuerdo_detalles\control_acuerdo_detalles@formulario_acuerdo_info_ajax" ) -> name('bandeja.formulario_acuerdo_info_ajax');
Route::post("/bandejas/formularioAcuerdoActualizarDocumentoAjax", "acuerdo_detalles\control_acuerdo_detalles@formulario_acuerdo_actualizar_documento_ajax" ) -> name('bandeja.formulario_acuerdo_actualizar_documento_ajax');
Route::post("/bandejas/imprimirMasivoAjax", "bandejas\control_bandejas@documento_descargar_masivo_ajax" ) -> name('bandeja.documento_descargar_masivo_ajax');
Route::post("/bandejas/firmarFirel/ajax", "bandejas\control_bandejas@bandeja_firmar_firel_ajax" ) -> name('bandeja.bandeja_firmar_firel_ajax');
Route::post("/bandejas/proximaPublicacion/buscar", "bandejas\control_bandejas@buscar_listado_proxima_publicacion" ) -> name('bandeja.buscar_proximaPublicacion');
Route::post("/bandejas/buscarPublicacion/buscar", "bandejas\control_bandejas@buscar_listado_busquda_publicacion" ) -> name('bandeja.buscar_listado_busquda_publicacion');
Route::post("/bandejas/buscar", "bandejas\control_bandejas@buscar_bandeja_ajax" ) -> name('bandeja.buscar_bandeja_ajax');
Route::post("/bandejas/avanzar/ajax", "bandejas\control_bandejas@bandeja_avanzar_revision_ajax" ) -> name('bandeja.bandeja_avanzar_revision_ajax');
Route::post("/bandejas/retreceso/ajax", "bandejas\control_bandejas@bandeja_retroceso_revision_ajax" ) -> name('bandeja.bandeja_retroceso_revision_ajax');
Route::post("/bandejas/descargaDocumento", "bandejas\control_bandejas@documento_descargar_ajax" ) -> name('bandeja.documento_descargar_ajax');
Route::post("/bandejas/descargaDocumento_sinse", "bandejas\control_bandejas@documento_descargar_ajax_sinse" ) -> name('bandeja.documento_descargar_ajax_sinse');
Route::post("/bandejas/descargaDocumento/preview", "bandejas\control_bandejas@documento_descargar_preview_ajax" ) -> name('bandeja.documento_descargar_preview_ajax');
Route::post("/bandejas/descargaDocumento/batch", "bandejas\control_bandejas@documento_descargar_batch_ajax" ) -> name('bandeja.documento_descargar_batch_ajax');
Route::post("/bandejas/descargaDocumento/batch_expediente_digital", "bandejas\control_bandejas@documento_descargar_masivo_expediente_digital_ajax" ) -> name('bandeja.documento_descargar_masivo_expediente_digital_ajax');
Route::post("/bandejas/descargaDocumento/elminar_orden_expedinte_digital_ajax", "bandejas\control_bandejas@elminar_orden_expedinte_digital_ajax" ) -> name('bandeja.elminar_orden_expedinte_digital_ajax');
Route::post("/bandejas/votoParticular/{accion}", "bandejas\control_bandejas@voto_particular_ajax" ) -> name('bandeja.voto_particular_ajax');
Route::post("/bandejas/mostrarEditorHTML", "bandejas\control_bandejas@mostrar_editor_HTML" ) -> name('bandeja.mostrar_editor_HTML');
Route::post("/bandejas/guardarEditorHTML", "bandejas\control_bandejas@guardar_editor_HTML" ) -> name('bandeja.guardar_editor_HTML');
Route::post("/bandejas/descargarPDFPreview", "bandejas\control_bandejas@descargarPDFPreview" ) -> name('bandeja.descargarPDFPreview');
Route::post("/bandejas/crear_mala_publicacion", "bandejas\control_bandejas@crear_mala_publicacion" ) -> name('bandeja.crear_mala_publicacion');
Route::post("/bandejas/ventana_mala_publicacion", "bandejas\control_bandejas@ventana_mala_publicacion" ) -> name('bandeja.ventana_mala_publicacion');
   
//Notificaciones electrónicas
Route::post("consultaPartesNotificacion", "dashboard\control_dashboard@notificacion_partes_ajax") ->  name('home.notificacion_partes_ajax');
Route::post("guardarPartesNotificacion", "dashboard\control_dashboard@notificacion_guardar_partes_ajax") ->  name('home.notificacion_guardar_partes_ajax');

//agendas
Route::post("/agendas/consultaEventoAjax", "agendas\control_agendas@consulta_evento_ajax" ) -> name('agendas.consulta_evento_ajax');
Route::post("/agendas/guardarEventoEditado", "agendas\control_agendas@guardar_agenda_editado" ) -> name('agendas.guardar_agenda_editado');
Route::post("/agendas/guardarEvento", "agendas\control_agendas@guardar_agenda" ) -> name('agendas.guardar_agenda');
Route::post("/agendas/validar_acuerdo_ajax", "agendas\control_agendas@validar_acuerdo_ajax" ) -> name('agenda.validar_acuerdo_ajax');
Route::post("/agendas/exportar_citas_excel", "agendas\control_agendas@exportar_citas_excel" ) -> name('agenda.exportar_citas_excel');
Route::post("/agendas/cambiar_estatus_citas_zoho", "agendas\control_agendas@cambiar_estatus_citas_zoho" ) -> name('agenda.cambiar_estatus_citas_zoho');

//promociones
Route::post("/promociones/guardarAsignacion", "promociones\control_promociones@guardar_asignacion" ) -> name('promociones.guardar_asignacion');
Route::post("/promociones/validarToca", "promociones\control_promociones@validar_toca_ajax" ) -> name('promociones.validar_toca_ajax');
Route::post("/promociones/buscarExpediente", "promociones\control_promociones@buscar_expediente_ajax" ) -> name('promociones.buscar_expediente_ajax');
Route::post("/promociones/buscarPromocionAjax", "promociones\control_promociones@buscar_promocion_ajax" ) -> name('promociones.buscar_promocion_ajax');
Route::post("/promociones/guardarPromocion", "promociones\control_promociones@promocion_guardar" ) -> name('promociones.promocion_guardar');
Route::post("/promociones/cargar_caratulas_pendinetes", "promociones\control_promociones@cargar_caratulas_pendinetes" ) -> name('promociones.cargar_caratulas_pendinetes');
Route::post("/promociones/cargar_caratulas_pdf", "promociones\control_promociones@cargar_caratulas_pdf" ) -> name('promociones.cargar_caratulas_pdf');
Route::post("/promociones/buscar_caratula", "promociones\control_promociones@buscar_caratula" ) -> name('promociones.buscar_caratula');
Route::post("/promociones/eliminar_caratula", "promociones\control_promociones@eliminar_caratula" ) -> name('promociones.eliminar_caratula');
Route::post("/promociones/editar_promocion_adjunto_visor", "promociones\control_promociones@editar_promocion_adjunto_visor" ) -> name('promociones.editar_promocion_adjunto_visor');

//configuración
Route::post("/menu_permisos", "configuracion\control_configuracion@guardar_permisos_menu" ) -> name('configuracion.guardar_permisos_menu');


//procesos de trabajo
Route::post("/procesosTrabajo/solicitudes/cambiarEstatus", "procesosTrabajo\control_solicitudes@solicitudes_cabiar_estatus" ) -> name('procesosTrabajo.cambiar_estatus_solicitudes_ajax');
Route::post("/procesosTrabajo/solicitudes/cambiarEstatusMasivo", "procesosTrabajo\control_solicitudes@solicitudes_cabiar_estatus_masivo" ) -> name('procesosTrabajo.solicitudes_cabiar_estatus_ajax_masivo');
Route::post("/procesosTrabajo/solicitudes/obtenerPromocionPDF", "procesosTrabajo\control_solicitudes@obtenerPromocionPDF" ) -> name('procesosTrabajo.obtenerPromocionPDF');
Route::post("/procesosTrabajo/solicitudes/exportar_lista_excel", "procesosTrabajo\control_solicitudes@exportar_lista_excel" ) -> name('procesosTrabajo.exportar_lista_excel');

//miniesterio de ley
Route::post("/procesosTrabajo/ministerioLey/guardarMinisterioLey", "procesosTrabajo\control_ministerioLey@guardar_ministerioLey" ) -> name('procesosTrabajo.guardar_ministerioLey');
Route::post("/procesosTrabajo/ministerioLey/cargarMinisterioLey", "procesosTrabajo\control_ministerioLey@cargar_ministerioLey_ajax" ) -> name('procesosTrabajo.cargar_ministerioLey_ajax');
//grupos de trabajo
Route::post("/procesosTrabajo/grupos/guardarAgregarUsuario", "procesosTrabajo\control_grupos@guardar_usuario_grupo" ) -> name('procesosTrabajo.guardar_usuario_grupo');
Route::post("/procesosTrabajo/grupos/agregarUsuario", "procesosTrabajo\control_grupos@agregar_usuario_grupo" ) -> name('procesosTrabajo.agregar_usuario_grupo');
Route::post("/procesosTrabajo/grupos/cargarPermisosUsuarios", "procesosTrabajo\control_grupos@cargar_permisos_usuarios" ) -> name('procesosTrabajo.cargar_permisos_usuarios');
Route::post("/procesosTrabajo/grupos/cargarMenusUsuarios", "procesosTrabajo\control_grupos@cargar_menu_usuarios" ) -> name('procesosTrabajo.cargar_menu_usuarios');
Route::post("/procesosTrabajo/grupos/guardarMenusUsuarios", "procesosTrabajo\control_grupos@guardar_menu_usuarios" ) -> name('procesosTrabajo.guardar_menu_usuarios');
Route::post("/procesosTrabajo/grupos/guardarAccionUsuarios", "procesosTrabajo\control_grupos@guardar_accion_usuarios" ) -> name('procesosTrabajo.guardar_accion_usuarios');
//sivep
Route::post("/procesosTrabajo/sivep/agregar_acuerdo_sivep_ajax", "procesosTrabajo\control_sivep@agregar_acuerdo_sivep_ajax" ) -> name('procesosTrabajo.agregar_acuerdo_sivep_ajax');


//notificaciones 
Route::get("/notificaciones/correoElectronico", "procesosTrabajo\control_envioCorreoElectronico@inicio" ) -> name('envioCorreoElectronico.inicio');
Route::post("/notificaciones/notificar_acuerdo_111_ajax", "notificaciones\control_notificaciones@notificar_acuerdo_111" ) -> name('notificaciones.notificar_acuerdo_111_ajax');
Route::post("/notificaciones/notificar_acuerdo_not_fisica", "notificaciones\control_notificaciones@notificar_acuerdo_not_fisica" ) -> name('notificaciones.notificar_acuerdo_not_fisica');
Route::post("/notificaciones/notificar_acuerdo_correo_ajax", "notificaciones\control_notificaciones@notificar_acuerdo_correo" ) -> name('notificaciones.notificar_acuerdo_correo_ajax');
Route::post("/notificaciones/notificar_acuerdo_bandera_notificado", "notificaciones\control_notificaciones@modificar_notificacion_acuerdo" ) -> name('notificaciones.notificar_acuerdo_bandera_notificado');
Route::post("/notificaciones/notificar_acuerdo_bandera_fisica", "notificaciones\control_notificaciones@notificar_acuerdo_bandera_fisica" ) -> name('notificaciones.notificar_acuerdo_bandera_fisica');
Route::post("/notificaciones/notificar_estatus_error_parte", "notificaciones\control_notificaciones@notificar_estatus_error_parte" ) -> name('notificaciones.notificar_estatus_error_parte');
Route::post("/notificaciones/notificar_acuerdo_resumen", "notificaciones\control_notificaciones@notificar_acuerdo_resumen" ) -> name('notificaciones.notificar_acuerdo_resumen');
Route::post("/notificaciones/consultar_estatus_error_parte", "notificaciones\control_notificaciones@consultar_estatus_error_parte" ) -> name('notificaciones.consultar_estatus_error_parte');
Route::post("/notificaciones/mostrarEditorHTML", "notificaciones\control_notificaciones@mostrar_editor_html" ) -> name('notificaciones.mostrar_editor_html');
Route::post("/notificaciones/mostrarPartes", "notificaciones\control_notificaciones@mostrar_partes" ) -> name('notificaciones.mostrar_partes');
Route::post("/notificaciones/guardarNotificionCorreoActuario", "notificaciones\control_notificaciones@guardar_notificion_correo_actuario" ) -> name('notificaciones.guardar_notificion_correo_actuario');
Route::post("/notificaciones/cargarStep", "notificaciones\control_notificaciones@cargar_step" ) -> name('notificaciones.cargar_step');

//edictos
Route::post("/edictos/consultarDocumentoEdicto", "edictos\control_edictos@consultarDocumentoEdicto" ) -> name('edictos.consultarDocumentoEdicto');
Route::post("/edictos/mostrarEditorHTML", "edictos\control_edictos@mostrar_editor_HTML" ) -> name('edictos.mostrarEditorHTML');
Route::post("/edictos/guardarEditorHTML", "edictos\control_edictos@guardar_editor_HTML" ) -> name('edictos.guardarEditorHTML');
Route::post("/edictos/editar", "edictos\control_edictos@editar" ) -> name('edictos.guardarEditorHTML');
Route::post("/edictos/cambiar_estatus_ajax", "edictos\control_edictos@cambiar_estatus_ajax" ) -> name('edictos.cambiar_estatus_ajax');
Route::post("/edictos/cambiar_firma_ajax", "edictos\control_edictos@cambiar_firma_ajax" ) -> name('edictos.cambiar_firma_ajax');

//archivo judicial
Route::post("/archivoJudicial/detalles_archivo", "archivo_judicial\control_archivo_judicial@detalles_archivo" ) -> name('archivo_judicial.detalles_archivo');
Route::post("/archivoJudicial/agregar_lista", "archivo_judicial\control_archivo_judicial@agregar_lista" ) -> name('archivo_judicial.agregar_lista');
Route::post("/archivoJudicial/eliminar_lista", "archivo_judicial\control_archivo_judicial@eliminar_lista" ) -> name('archivo_judicial.eliminar_lista');
Route::post("/archivoJudicial/confirmar_lista_expedientes", "archivo_judicial\control_archivo_judicial@confirmar_lista_expedientes" ) -> name('archivo_judicial.confirmar_lista_expedientes');
Route::post("/archivoJudicial/cambiar_estatus_archivo", "archivo_judicial\control_archivo_judicial@cambiar_estatus_archivo" ) -> name('archivo_judicial.cambiar_estatus_archivo');
Route::post("/archivoJudicial/descargar_archivo", "archivo_judicial\control_archivo_judicial@descargar_archivo" ) -> name('archivo_judicial.descargar_archivo');


//utilidades
//Route::post("/utilidades/ping", "agendas\control_utilidades@ping" ) -> name('utilidades.ping');

//citas
Route::post("/agendas/citas_json", "agendas\control_agendas@citas_json" ) -> name('agendas.citas_json');

//logout
// Route::get('logout','logout\control_logout@logout') -> name('logout');
Route::post('/cambiar_reseteo','login\control_login@cambiar_reseteo') -> name('login.cambiar_reseteo');

//Gestor Documental
Route::post("/descargarGestor", "gestorDocumental\control_gestorDocumental@descargar_gestor" ) -> name('promociones.descargar_gestor');


/* 
*      necesitan de interfaz gráfica  ORALIDAD
*/
Route::middleware([ "middle_elementos_front_oralidad"])->group(function(){
    Route::get("oralidad/calendario","oralidad\control_oralidad@inicio") -> name('oralidad.divorcios');
    Route::get("oralidad/consulta/acuerdos/{materia?}/{juzgado?}/{expediente?}/{anio?}/{bis?}/{id_juicio?}","oralidad\control_oralidad@inicio_consulta_acuerdos") -> name('oralidad.inicio_consulta_acuerdos');
    Route::get("oralidad/consulta/promociones/{materia?}/{juzgado?}/{expediente?}/{anio?}/{bis?}/{id_juicio?}","oralidad\control_oralidad@inicio_consulta_promociones") -> name('oralidad.inicio_consulta_promociones');
    Route::get("oralidad/consulta/notificaciones/{materia?}/{juzgado?}/{estatus?}","oralidad\control_oralidad@inicio_consulta_notificaciones") -> name('oralidad.inicio_consulta_notificaciones');
});

//NO NECESITA INTERFAZ GRAFICA ORALIDAD
Route::post("/oralidad/cargarInfoEvento_ajax", "oralidad\control_oralidad@cargarInfoEvento_ajax" ) -> name('oralidad.cargarInfoEvento_ajax');
Route::post("/oralidad/descargar_acuerdo", "oralidad\control_oralidad@descargar_acuerdo" ) -> name('oralidad.descargar_acuerdo');
Route::post("/oralidad/citas_excel", "oralidad\control_oralidad@citas_excel" ) -> name('oralidad.citas_excel');
Route::post("/oralidad/formulario_asignar_notificador", "oralidad\control_oralidad@formulario_asignar_notificador" ) -> name('oralidad.formulario_asignar_notificador');
Route::post("/oralidad/formularioAcuerdoNotificacionGuardarAjax", "oralidad\control_oralidad@formulario_acuerdo_notificacion_guardar_ajax" ) -> name('oralidad.formulario_acuerdo_notificacion_guardar_ajax');

/*
*      necesitan de interfaz gráfica  ESTADISTICA
*/
Route::middleware([ "middle_elementos_front_estadistica"])->group(function(){

    Route::get("/estadistica/consulta/{materia?}/{juzgado?}","estadistica\control_estadistica@inicio_caratulas") -> name('estadistica.caratula');
    Route::get("/estadistica/{materia?}/{juzgado?}/{expediente?}/{anio?}/{bis?}/{id_juicio?}","estadistica\control_estadistica@inicio") -> name('estadistica.inicio');
});

//NO NECESITA INTERFAZ GRAFICA ESTADÍSTICA
Route::post("/estadistica/cargar_caratulas_pdf", "estadistica\control_estadistica@cargar_caratulas_pdf" ) -> name('estadistica.cargar_caratulas_pdf');
Route::post("/estadistica/cargar_caratulas_xml", "estadistica\control_estadistica@cargar_caratulas_xml" ) -> name('estadistica.cargar_caratulas_xml');
Route::post("/estadistica/buscar_caratula", "estadistica\control_estadistica@buscar_caratula" ) -> name('estadistica.buscar_caratula');
Route::post("/estadistica/generar_caratula", "estadistica\control_estadistica@generar_caratula" ) -> name('estadistica.generar_caratula');
Route::post("/estadistica/generar_caratula_xml", "estadistica\control_estadistica@generar_caratula_xml" ) -> name('estadistica.generar_caratula_xml');


/*
*      necesitan de interfaz gráfica ANALES
*/
Route::middleware([ "middle_elementos_front_anales"])->group(function(){

    Route::get("/anales","anales\control_anales@inicio") -> name('anales.inicio');
    Route::get("/anales/editar/{id}/{materia?}","anales\control_anales@editar") -> name('anales.editar');
});

//NO NECESITA INTERFAZ GRAFICA ANALES
Route::post("/anales/editar/sincronizarJuzgadoBoletin", "anales\control_anales@sincronizarJuzgadoBoletin" ) -> name('anales.sincronizarJuzgadoBoletin');
Route::post("/anales/editar/cargarJuzgadoBoletin", "anales\control_anales@cargarJuzgadoBoletin" ) -> name('anales.cargarJuzgadoBoletin');
Route::post("/anales/editar/verJuzgadoBoletin", "anales\control_anales@verJuzgadoBoletin" ) -> name('anales.verJuzgadoBoletin');
Route::get("/anales/editar/txtJuzgadoBoletin/{juzgado?}/{id_boletin_registro?}", "anales\control_anales@txtJuzgadoBoletin" ) -> name('anales.txtJuzgadoBoletin');
Route::get("/anales/editar/txtJuzgadoBoletin/{juzgado?}/{id_boletin_registro?}/{todo?}", "anales\control_anales@txtJuzgadoBoletin" ) -> name('anales.txtJuzgadoBoletin');
Route::post("/anales/editar/sincronizacionTotalBoletin", "anales\control_anales@sincronizacionTotalBoletin" ) -> name('anales.sincronizacionTotalBoletin');
Route::post("/anales/editar/guardarJuzgadoBoletin", "anales\control_anales@guardarJuzgadoBoletin" ) -> name('anales.guardarJuzgadoBoletin');

 

/*
*      necesitan de interfaz gráfica  SIGJ
*/
Route::middleware([ "middle_elementos_front"])->group(function(){
        
    require 'rutas_libros.php'; 
    require 'juicios.php';

    //dd($request->session()->all());
    //Expedientes
    //if(session()->get('tipo_usuario_descripcion')=="actuario"){
    //    return redirect('notificaciones/sin_notificar/');
   // }
   // else{
        Route::get("home","dashboard\control_dashboard@inicio") -> name('home');
   // }
    
    //Acuerdos
    Route::get("/acuerdo_detalles/{id}/{error?}/{success?}", "acuerdo_detalles\control_acuerdo_detalles@inicio" ) -> name('acuerdo_detalles.general');
    Route::get("/acuerdo_flujo/{id}/{acuerdo_id}/{error?}", "acuerdo_detalles\control_acuerdo_detalles@mostrarFlujo" ) -> name('acuerdo_flujo.mostrarFlujo');

    //configuracion
    Route::get("/menu_permisos/{error?}", "configuracion\control_configuracion@cargar_permisos_menu" ) -> name('configuracion.cargar_permisos_menu');

    //boletin
    Route::get("/boletin/listaPublicaciones/{anio?}/{mes?}/{dia?}", "boletin\control_boletin@inicio" ) -> name('boletin.inicio');

    //bandejas
    Route::get("/bandejas/editarAcuerdoHtml/{id_acuerdo}/{id_juicio}/{flujo_id}/{bandeja}", "bandejas\control_bandejas@editarAcuerdoHtml" ) -> name('bandejas.editarAcuerdoHtml');
    Route::get("/bandejas/buscarPublicaciones", "bandejas\control_bandejas@obtener_listado_proxima_publicacion2" ) -> name('bandejas.bandejas_proximaPublicacion2');
    Route::get("/bandejas/proximaPublicacion/{error?}", "bandejas\control_bandejas@obtener_listado_proxima_publicacion" ) -> name('bandeja.proximaPublicacion');
    Route::get("/bandejas/{bandeja}/{error?}", "bandejas\control_bandejas@inicio" ) -> name('bandeja.general');

    //notificaciones
    Route::get("/notificaciones/{estatus}", "notificaciones\control_notificaciones@inicio" ) -> name('notificaciones.inicio');

    //procesos de trabajo
    Route::get("/procesosTrabajo/solicitudes/{folio?}/{fecha_inic?}/{fecha_final?}", "procesosTrabajo\control_solicitudes@inicio_solicitudes" ) -> name('procesosTrabajo.inicio_solicitudes');
    //miniesterio de ley
    Route::get("/procesosTrabajo/ministerioLey", "procesosTrabajo\control_ministerioLey@inicio_ministerioLey" ) -> name('procesosTrabajo.inicio_ministerioLey');
    //grupos de trabajo
    Route::get("/procesosTrabajo/grupos", "procesosTrabajo\control_grupos@inicio_grupos" ) -> name('procesosTrabajo.inicio_grupos');
    //sivep
    Route::get("/sivep", "procesosTrabajo\control_sivep@inicio" ) -> name('procesosTrabajo.sivep.inicio');
    
    //agendas
    Route::get("/agendas", "agendas\control_agendas@inicio" ) -> name('agendas.inicio');
    Route::get("/agendas/citas/", "agendas\control_agendas@citas" ) -> name('agendas.citas');
    


    //promociones
    Route::get("/promociones/caratulas/", "promociones\control_promociones@inicio_caratulas" ) -> name('promociones.inicio_caratulas');
    Route::get("/promociones/nueva/", "promociones\control_promociones@nueva_promcion" ) -> name('promociones.nueva_promocion');
    Route::get("/promociones/{bandeja}", "promociones\control_promociones@inicio" ) -> name('promociones.inicio');

    //edictos
    Route::get("/edictos", "edictos\control_edictos@bandeja_nuevos" ) -> name('edictos.bandeja_nuevos');
    Route::get("/edictos/autorizar", "edictos\control_edictos@bandeja_autorizar" ) -> name('edictos.bandeja_autorizar');
    Route::get("/edictos/aprobados", "edictos\control_edictos@bandeja_aprobados" ) -> name('edictos.bandeja_aprobados');
    Route::get("/edictos/porpagar", "edictos\control_edictos@bandeja_porpagar" ) -> name('edictos.bandeja_porpagar');
    Route::get("/edictos/publicados", "edictos\control_edictos@bandeja_publicados" ) -> name('edictos.bandeja_publicados');

    //Archivo Judicial
    Route::get("/archivoJudicial", "archivo_judicial\control_archivo_judicial@inicio" ) -> name('archivo_judicial.inicio');

    Route::get("/registro/nuevo","juicio\control_juicio@intf_nuevo");

});