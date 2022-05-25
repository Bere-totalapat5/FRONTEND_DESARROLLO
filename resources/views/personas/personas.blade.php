@php
  use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

{{-- Header --}}
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">Personas</a></li>
     <li class="breadcrumb-item"><a href="javascript:void(0);"> Busqueda de Personas</a></li>
  </ol>
  <h6 class="slim-pagetitle"> Busqueda de Personas (Global)</h6>
@endsection


{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">

          <form class="row" autocomplete="off">

              <div class="col-lg-3">
                <div class="form-group">
                  <label for="calidad_juridica">Calidad Juridica:</label>
                  <select class="form-control select2" id="calidad_juridica">
                    <option value="" disabled selected>Selecciona una opcion</option>
                    <option value="-">Todas</option>
                    @foreach ($calidad_juridica as $calidad)
                      <option value="{{$calidad['id_calidad_juridica']}}">{{$calidad['calidad_juridica']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group">
                  <label for="calidad_juridica">Tipo carpeta:</label>
                  <select class="form-control select2" id="tipo_carpeta"> 
                      <option value="" disabled selected>Selecciona una opcion</option>
                      <option value="-">Todas</option>
                      <option value="1">Carpeta de Control</option>
                      <option value="2">Carpeta de Exhorto</option>
                      <option value="3">Carpeta de Amparo</option>
                      <option value="4">Carpeta de Apelación</option>
                      <option value="5">Carpetas</option>
                      <option value="6">Carpeta de Ejecución</option>
                      <option value="7">Cuadernillos (Unidad Ejecución)</option>
                      <option value="8">Carpeta Judicial de Alzada</option>
                      <option value="9">Cuadernillo Ley Nacional</option>
                      <option value="10">Carpeta de Ley Mujeres Libre de Violencia</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="label">Nombre Completo: </label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                      </div>
                      <input type="text" class="form-control" autocomplete="off" placeholder="Nombre completo" id="item_NC" name="item_NC" autocomplete="off">
                  </div>
                </div>
              </div>

            <div class="col" style="display: flex; justify-content:center; align-items:center;">
              <button type="button" class="btn btn-primary btn-sm btn-block" title="Buscar" style="padding:8% 0;" onclick="sec_ajax('primera');"><i class="fas fa-search"></i></button>
            </div>
            <div class="col" style="display: flex; justify-content:center; align-items:center;">
              <button type="button" class="btn btn-primary btn-sm btn-block" title="Limpiar busqueda" style="padding:8% 0;" onclick="limpiar_Busqueda();"><i class="fas fa-refresh"></i></button>
            </div>
            <div class="col" style="display: flex; justify-content:center; align-items:center;">
              <button type="button" class="btn btn-primary btn-sm btn-block" title="Exportar Constancia de Busqueda " style="padding:8% 0;" onclick="exportar_constancia();"><i class="fas fa-file-pdf"></i></button>
            </div>
          </form>

          <div style="display: Flex; margin-bottom:3px;">
            <span style="font-weight: bold;">Semaforo: </span>
            <div style="width: 201px;display: flex;justify-content: center;align-items: center;"><div style="background: #2ECC71; width: 21px; height: 13px; margin-right: 4%;"></div>Valor más acertado</div>
            <div style="width: 201px;display: flex;justify-content: center;align-items: center;"><div style="background: #3498DB; width: 21px; height: 13px; margin-right: 4%;"></div>Coincidencia</div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div id="resultados" >
                <div class="empty">
                  <i class="fas fa-users"></i>
                  <p style="font-size: 0.5em;">Realice una busqueda</p>
                </div>
              </div>
            </div>
          </div>

          <!-- pagination-wrapper -->
          <div class="pagination-wrapper justify-content-between">
              <ul class="pagination mg-b-0">
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera');" aria-label="Last">
                          <i class="fa fa-angle-double-left"></i>
                      </a>
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('atras');" aria-label="Next">
                          <i class="fa fa-angle-left"></i>
                      </a>
                  </li>
              </ul>
              <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span
                      class="pagina_total_texto">0</span></div>
              <ul class="pagination mg-b-0">
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar');" aria-label="Next">
                          <i class="fa fa-angle-right"></i>
                      </a>
                  </li>
                  <li class="page-item">
                      <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima');" aria-label="Last">
                          <i class="fa fa-angle-double-right"></i>
                      </a>
                  </li>
              </ul>
          </div><!-- pagination-wrapper -->

        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

    </div>

@endsection

{{-- Scripts librerias --}}
@section('seccion-scripts-libs')
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

  <!-- SCRIPTS para linea de tiempo -->
  <!-- <script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.3.8" charset="utf-8"></script>
  <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src='/box/scheduler/codebase/ext/dhtmlxscheduler_treetimeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_units.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/ext/dhtmlxscheduler_week_agenda.js?v=5.3.8" type="text/javascript" charset="utf-8"></script> -->


  <script src="/box/scheduler_5.3.11_enterprise/codebase/dhtmlxscheduler.js" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_limit.js" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_agenda_view.js" charset="utf-8"></script>
  <script src='/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_timeline.js' type="text/javascript" charset="utf-8"></script>
  <script src='/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_treetimeline.js' type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_units.js" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_week_agenda.js" type="text/javascript" charset="utf-8"></script>


  <!--- scripts para editor de texto en linea -->
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/froala_editor.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/froala_editor.pkgd.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/align.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/colors.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/emoticons.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/font_size.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/font_family.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/image.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/line_breaker.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/quick_insert.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/link.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/video.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/table.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/url.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/emoticons.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/file.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/entities.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/inline_style.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/save.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/fullscreen.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/languages/es.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/quote.min.js"></script>
  <script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/char_counter.min.js"></script>




  <script src="{{asset('/js/remisiones/remision.js')}}"></script>
  <script src="{{asset('/js/remisiones/remision_unidad_ejecucion.js')}}"></script>
  <script src="{{asset('/js/remisiones/remision_incompetencia.js')}}"></script>
  <script src="{{asset('/js/remisiones/remision_tribunal_enjuiciamiento.js')}}"></script>
  <script src="{{asset('/js/remisiones/obtenerInmuebleFiscalia.js')}}"></script>
  <script src="{{asset('/js/remisiones/obtenerUnidadDestino.js')}}"></script>
  <script src="{{asset('/js/remisiones/remision_preventiva.js')}}"></script>
  <script src="{{asset('/js/carpetas/data_carpeta.js')}}"></script>

  <script src="http://10.6.5.1:9002/dist/development/ovenplayer/ovenplayer.js"></script>

@endsection

{{-- Estilos --}}
@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

    <!-- estilos para linea del tiempo -->
    <!-- <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8"> -->
    <link rel="stylesheet" href="/box/scheduler_5.3.11_enterprise/codebase/dhtmlxscheduler.css" type="text/css" charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/box/scheduler_5.3.11_enterprise/samples/common/controls_styles.css">
    <!-- <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8"> -->
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">  

    <!-- estilos para editor de texto -->
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/froala_editor.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/froala_style.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/code_view.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/colors.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/emoticons.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/image_manager.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/image.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/line_breaker.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/quick_insert.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/table.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/file.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/char_counter.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/video.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/emoticons.css">
    <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/fullscreen.css">
    <link rel="stylesheet" href="{{asset('/css/carpetas_judiciales/remisiones.css')}}">
  
    <style>
      .info_persona{
        display: flex;
        flex-wrap: wrap;
      }
      .solicitud_d{
        text-align: center;
        font-size: 0.9em;
        font-weight: bold;
        color: #aaa;
        margin: 5% 0 13% 0;
      }
      .solicitud_f{
        text-align: right;
        font-size: 0.7em;
        font-weight: bold;
        color: #aaa;
        margin: 2% 0;
        width: 100%;
      }
      .title_info{
        width: 100%;
        border:1px solid #848f33;
        color:#848F33;
        text-transform: capitalize;
        text-align: center;
        margin: 4% auto;
        font-size: 0.9em;
      }
      .imagess{
        width: 100%;
        text-align: center;
        font-size: 3.4em;
        color: #848f33;
        margin-top: 8%;
      }
      .conten-image{
        border: 1px solid #eee;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        position: relative;
      }
      .resultado{
        border: 1px solid #eee;
        display: flex;
        flex-wrap: wrap;
      }
      .empty{
        background: #ebebeb;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 400px;
        margin: 1% 0;
        color: #ccc;
        font-size: 5.4em;
      }
      .rele{
        position: absolute;
        font-size: 0.7em;
        bottom: -10px;
        right: 6px;
      }
      .info_carpeta{
        display: flex;
        flex-wrap: wrap;
        font-size: 0.8em; 
        border-bottom: 2px solid #eee;
        padding-bottom: 3px;
      }
      .lista_personas{
        width: 100%;
        padding: 0;
        height: 110px;
        overflow: auto;
        font-size: 0.8em;
      }

      .lista_personas::-webkit-scrollbar {
          width: 8px;
          height: 9px;     
      }
      .lista_personas::-webkit-scrollbar-thumb {
          background: #ccc;
          border-radius: 4px;
      }
      .lista_personas::-webkit-scrollbar-thumb:hover {
          background: #b3b3b3;
          box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
      }
      .lista_personas::-webkit-scrollbar-thumb:active {
          background-color: #999999;
      }
      .lista_personas::-webkit-scrollbar-track {
          background: #e1e1e1;
          border-radius: 4px;
      }
      .lista_personas::-webkit-scrollbar-track:hover,
      .lista_personas::-webkit-scrollbar-track:active {
        background: #d4d4d4;
      }
      .encontrado{
        background:#2ECC71 !important;
        color:#fff;
      }
      .coincidencia{
        background:#3498DB;
        color:#fff;
      }

      /*Estilos de carpetas*/

      .current {
        color: red;
      }
      
      #pagin li {
        display: inline-block;
      }
  
      .carpeta_acumula_content{
        width: 100%; 
        border: 1px solid #848f33; 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        height: 100%;
      }
      .carpeta_acumula_content i{
        font-size: 4.9em;
        color: #848f33;
      }
      .pad{
        padding: 0 40px;
      }
      .contenedor-puni{
        width: 100%;
        margin: 0 auto;
      }
      .contenedor-prev{
        width:100%;
        margin: 0 auto;
      }
      @media(max-width: 1024px) {
        .contenedor-puni{
          width: calc(100% - 180px);
        }
        .contenedor-prev{
          width: calc(100% - 54px);
        }
        /*Tabs de carpestas responsivas*/
        .tabs_responsivas{
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
          display: flex;
          min-width: 100%;
          flex-direction: row;
          overflow-y: hidden;
        }
        .tabs_responsivas a:nth-child(1) { min-width: 170px; border:1px solid #ccc; text-align: center; } /* Documentos Asociados */
        .tabs_responsivas a:nth-child(2) { min-width: 100px; border:1px solid #ccc; text-align: center; } /* Audiencias */
        .tabs_responsivas a:nth-child(3) { min-width: 140px; border:1px solid #ccc; text-align: center; } /* Partes Procesales */
        .tabs_responsivas a:nth-child(4) { min-width: 160px; border:1px solid #ccc; text-align: center; } /* Delitos Sin Relacionar */
        .tabs_responsivas a:nth-child(5) { min-width: 170px; border:1px solid #ccc; text-align: center; } /* Documentos Generados*/
        .tabs_responsivas a:nth-child(6) { min-width: 120px; border:1px solid #ccc; text-align: center; } /* Prescripciones*/
        .tabs_responsivas a:nth-child(7) { min-width: 170px; border:1px solid #ccc; text-align: center; } /* Notificaciones / Alertas */
        .tabs_responsivas a:nth-child(8) { min-width: 240px; border:1px solid #ccc; text-align: center; } /* Historial de estatus de imputado*/
        .nav{
          flex-wrap: inherit !important;
        }
        /*Tabs de carpestas responsivas*/
      }
  
      @media(max-width: 900px) {
        /*Tabs de carpestas responsivas*/
        .tabs_responsivas{
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
          display: flex;
          min-width: 100%;
          flex-direction: row;
          overflow-y: hidden;
        }
        .tabs_responsivas a:nth-child(1) { min-width: 170px; border:1px solid #ccc; text-align: center; } /* Documentos Asociados */
        .tabs_responsivas a:nth-child(2) { min-width: 100px; border:1px solid #ccc; text-align: center; } /* Audiencias */
        .tabs_responsivas a:nth-child(3) { min-width: 140px; border:1px solid #ccc; text-align: center; } /* Partes Procesales */
        .tabs_responsivas a:nth-child(4) { min-width: 160px; border:1px solid #ccc; text-align: center; } /* Delitos Sin Relacionar */
        .tabs_responsivas a:nth-child(5) { min-width: 170px; border:1px solid #ccc; text-align: center; } /* Documentos Generados*/
        .tabs_responsivas a:nth-child(6) { min-width: 120px; border:1px solid #ccc; text-align: center; } /* Prescripciones*/
        .tabs_responsivas a:nth-child(7) { min-width: 170px; border:1px solid #ccc; text-align: center; } /* Notificaciones / Alertas */
        .tabs_responsivas a:nth-child(8) { min-width: 240px; border:1px solid #ccc; text-align: center; } /* Historial de estatus de imputado*/
        .nav{
          flex-wrap: inherit !important;
        }
        /*Tabs de carpestas responsivas*/
        .carpeta_acumula_content i{
          margin: 7% 0;
        }
        .pad{
          padding: 10px;
        }
        .contenedor-puni,.contenedor-prev {
          width: 100%;
        }
      }
  
      @media(max-width: 760px) {
        /*Tabs de carpestas responsivas*/
        .tabs_responsivas{
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
          display: flex;
          min-width: 100%;
          flex-direction: row;
          overflow-y: hidden;
        }
        .tabs_responsivas a:nth-child(1) { min-width: 170px; border:1px solid #ccc; text-align: center; } /* Documentos Asociados */
        .tabs_responsivas a:nth-child(2) { min-width: 100px; border:1px solid #ccc; text-align: center; } /* Audiencias */
        .tabs_responsivas a:nth-child(3) { min-width: 140px; border:1px solid #ccc; text-align: center; } /* Partes Procesales */
        .tabs_responsivas a:nth-child(4) { min-width: 160px; border:1px solid #ccc; text-align: center; } /* Delitos Sin Relacionar */
        .tabs_responsivas a:nth-child(5) { min-width: 170px; border:1px solid #ccc; text-align: center; } /* Documentos Generados*/
        .tabs_responsivas a:nth-child(6) { min-width: 120px; border:1px solid #ccc; text-align: center; } /* Prescripciones*/
        .tabs_responsivas a:nth-child(7) { min-width: 170px; border:1px solid #ccc; text-align: center; } /* Notificaciones / Alertas */
        .tabs_responsivas a:nth-child(8) { min-width: 240px; border:1px solid #ccc; text-align: center; } /* Historial de estatus de imputado*/
        .nav{
          flex-wrap: inherit !important;
        }
        /*Tabs de carpestas responsivas*/
  
        .carpeta_acumula_content i{
          margin: 7% 0;
        }
        .modal-dialog-xxl{
          min-width: 100% !important;
          max-width: 100% !important;
        }
        .modal-dialog{
          margin: 0 !important;
        }
        .pad{
          padding: 0;
        }
        .slim-pagetitle {
          font-size: 15px !important;
        }
        .contenedor-puni,.contenedor-prev {
          width: 100%;
        }
  
        #fra_nes, #fra_nes thead, #fra_nes tbody, #fra_nes th, #fra_nes td, #fra_nes tr {
          display: block;
        }
  
        #fra_nes thead tr {
          position: absolute;
          top: -9999px;
          left: -9999px;
        }
  
        #fra_nes tr {
          margin: 0 0 1rem 0;
        }
  
        #fra_nes tr:nth-child(odd) {
          background: #fff;
        }
  
        #fra_nes td {
          border: none;
          border-bottom: 1px solid #eee;
          position: relative;
          padding-left: 50%;
          display: block !important;
        }
  
        #fra_nes td:nth-of-type(2){ 
          padding: 12px 1% !important; 
          border-left: 1px solid #eee; 
          border-right: 1px solid #eee; 
        }
  
        #fra_nes td:before {
          position: absolute;
          top: 7px;
          left: 6px;
          width: 45%;
          padding-right: 10px;
          white-space: nowrap;
        }
  
        #fra_nes td:nth-of-type(1):before { content: "Fraccion"; }
        #fra_nes td:nth-of-type(2):before { content: ""; }
        #fra_nes td:nth-of-type(3):before { content: "Solicitada"; }
        #fra_nes td:nth-of-type(4):before { content: "Acuerdo"; }
  
        /*Carpetas Judicales*/
        #tableCarpetas{
          border: none;
        }
  
        #tableCarpetas, #tableCarpetas thead, #tableCarpetas tbody, #tableCarpetas th, #tableCarpetas td, #tableCarpetas tr {
          display: block;
        }
  
        #tableCarpetas thead tr {
          position: absolute;
          top: -9999px;
          left: -9999px;
        }
  
        #tableCarpetas tr {
          margin: 0 0 1rem 0;
          border: 1px solid #eee;
        }
  
        #tableCarpetas tr:nth-child(odd) {
          background: #fff;
        }
  
        #tableCarpetas td {
          border: none;
          border-bottom: 1px solid #eee;
          position: relative;
          padding-left: 50%;
          display: block !important;
        }
  
        #tableCarpetas td:before {
          position: absolute;
          top: 1px;
          left: 3%;
          width: 45%;
          padding-right: 10px;
          white-space: nowrap;
          text-align: left;
          text-transform: uppercase;
          font-weight: 500;
          color: rgb(182 182 182);
          font-size: 0.7em;
        } 
        #tableCarpetas td:nth-of-type(1) { 
          text-align: center;
        }
        #tableCarpetas td:nth-of-type(2) { 
          text-align: left;
          height: 20px;
          margin-left: 5px;
          margin-top: 6px;
        }
        #tableCarpetas td:nth-of-type(3) { 
          text-align: left;
          height: 20px;
          margin-left: 5px;
          margin-top: 6px;
        }
        #tableCarpetas td:nth-of-type(4) { 
          text-align: left;
          height: 20px;
          margin-left: 5px;
          margin-top: 6px;
        }
        #tableCarpetas td:nth-of-type(5) { 
          text-align: left;
          height: 20px;
          margin-left: 5px;
          margin-top: 6px;
        }
        #tableCarpetas td:nth-of-type(6) { 
          text-align: left;
          height: 20px;
          margin-left: 5px;
          margin-top: 6px;
        }
        #tableCarpetas td:nth-of-type(7) { 
          text-align: left;
          height: 20px;
          margin-left: 5px;
          margin-top: 6px;
        }
        #tableCarpetas td:nth-of-type(8) { 
          text-align: left;
          height: 20px;
          margin-left: 5px;
          margin-top: 6px;
        }
        #tableCarpetas td:nth-of-type(9) span .b-l-2 { 
          font-size: 0.85em;
        }
        #tableCarpetas td:nth-of-type(10) .b-l-2{ 
          font-size: 0.85em;
        }
  
        #tableCarpetas td:nth-of-type(2):before { content: "Tipo de Carpeta"; } 
        #tableCarpetas td:nth-of-type(3):before { content: "Unidad"; }  
        #tableCarpetas td:nth-of-type(4):before { content: "Carpeta Judicial"; }  
        #tableCarpetas td:nth-of-type(5):before { content: "Carpeta Inv"; }
        #tableCarpetas td:nth-of-type(6):before { content: "Creación"; }  
        #tableCarpetas td:nth-of-type(7):before { content: "Situación"; }
        #tableCarpetas td:nth-of-type(8):before { content: "T. Solicitud"; }
      }

      .modal {
        overflow-y: auto !important;
      }
      .select2-container.select2-container--default.select2-container--open{
        z-index: 1050;
      }
      .ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
        z-index: 1050 !important;
      }
      .carpeta{
        min-width: 160px !important;
      }
      .carpeta-TE{
        min-width: 160px !important;
      }
      .carpeta-EJEC{
        min-width: 160px !important;
      }
      .carpeta-LN{
        min-width: 160px !important;
      }
      .carpeta-IN{
        min-width: 160px !important;
      }
      .unidad{
        min-width: 120px !important;
      }
      .folio{
        min-width: 130px !important;
      }
      .fecha{
        min-width: 75px !important;
      }
      .situacion{
        min-width: 75px !important;
      }
      .tipo_solicitud{
        min-width: 100px !important;
      }
      .involucrados{
        min-width: 170px !important;
      }
      .delitos{
        min-width: 190px !important;
      }
      td.tipo_audiencia{
        text-transform: uppercase;
      }
      .acciones{
        min-width: 150px !important;
      }
      .carpeta_inv{
        min-width: 120px !important;
      }
      td.acciones{
        font-size: 16px !important;
      }
  
      #tableCarpetas{
        display:table;
        margin-bottom: 15px;
        margin-top: 15px;
      }
      #tableCarpetas td,#tableCarpetas th{
        padding:12px !important;
      }
      div.modal-body i.tx-success{
        color: #23BF08 !important;
      }
      .pagination-wrapper{
        height: 50px !important;
      }
  
      table.tableDatosSujeto  td, table.tableDatosSujeto th{
        border: 1px solid #EEE;
        vertical-align: text-top;
        padding: 5px;
      }
  
      table.tableDatosSujeto2  td, table.tableDatosSujeto2 th{
        border: 1px solid #EEE;
        vertical-align: text-top;
        padding: 5px;
        width: 33%;
      }
      table.tableDatosSujeto tbody.table-datos-sujeto tr td:nth-child(2n-1){
        background-color: #f8f9fa;
      }
      table.tableDatosSujeto tbody.table-datos-sujeto tr td{
        width: 25%;
      }
      table.tableDatosSujeto2 thead tr:first-child{
        background-color: #f8f9fa;
      }
  
      /* div.modalAdministracion-body{
        min-width: 1600px;
      } */
  
      .modal-dialog-xxl{
        min-width: 90%;
        max-width: 90%;
        /*
        min-height: 90%;
        max-height: 800px !important;
        overflow-x: auto;
        */
      }
  
      div.modalRemision-body{
        /* min-width: 90% !important; */
        min-width: 1400px;
      }
  
      /* div.modalAdministracion-content{
        min-height: 800px;
      } */
      div.modalRemision-content{
        min-height: 700px;
      }
  
      .tx-secondary {
        color: #727C2E !important;
      }
  
      /* toggle con apariencia de boton */
      .bkg-collapsed-btn{
        background-color: #b0b781 !important;
      }
  
      .bkg-collapsed-btn-hover {
        background-color: #fff !important;
        color: #848961 !important;
        border: 2px solid #848961 !important;
        /* background-color: #848961  !important; */
      }
  
      .bkg-collapsed-btn-hover:hover{
        /* background-color: #fff !important;
        color: #848961 !important;
        border: 2px solid #848961 !important; */
        background-color: #848961  !important;
        color: #ffffff !important;
      }
  
      .bkg-collapsed-btn-edit {
        /* background-color: #FF5733 !important; */
        background-color: #f5755a !important;
      }
  
      .tx-white {
        color: #ffffff !important;
      }
  
      table .fas, .far {
        background: #848F33 ;
        padding: 5px 5px;
        border-radius: 25%;
        color: #fff;
      }
  
      .row{
        /*PARA QUE SELECT NO SALGA DE ROW POR SER MUY LARGO  */
        overflow: hidden;
      }
  
      .dhx_cal_event_line{
        background: #848961;
      }
  
      .timeline_scalex_class{
        min-width:40px !important;
        max-width:41px !important;
      }
  
      .td-title{
        background:#f8f9fa;
      }
  
      @media only screen and (max-width: 1700px) {
        #tableCarpetas{
          display: block;
        }
        /* div.modalAdministracion-body{
          max-width: 900px !important;
        } */
      }
      @media (min-width: 992px){
        .modal-lg.xl {
            max-width: 1017px;
        }
  
        div.modalRemision-body{
          max-width: 900px !important;
        }
  
        .labelTipoRemision{
          font-family: "Roboto", "Helvetica Neue", Arial, sans-serif;
          font-size: 1.875rem;
          font-weight: 400;
          line-height: 1.5;
          color: #848F33 ;
          text-align: left;
        }
  
       .formularioRemision{
          max-width: 60% !important;
        }
        textarea{
          background-color: white  !important;
          min-height: 100px !important;
          width: 100% !important;
        }
  
        #tableCarpetas{
          display: block;
        }
      }
  
      #events-list-vcj::-webkit-scrollbar {
        width: 8px;
        height: 8px;
      }
  
      #events-list-vcj::-webkit-scrollbar-thumb {
          background: #ccc;
          border-radius: 4px;
      }
  
      #events-list-vcj::-webkit-scrollbar-thumb:hover {
          background: #b3b3b3;
          box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
      }
  
      #events-list-vcj::-webkit-scrollbar-thumb:active {
          background-color: #999999;
      }
  
      #events-list-vcj::-webkit-scrollbar-track {
          background: #e1e1e1;
          border-radius: 4px;
      }
  
      #events-list-vcj::-webkit-scrollbar-track:hover,
      #events-list-vcj::-webkit-scrollbar-track:active {
        background: #d4d4d4;
      }
  
      /*Input Carpeta Asociada*/
  
      input[carpetaJudicialAsociada]{
        max-width: 400%;
  
      }
  
  
      #carpetasJudicialesA, #carpetasJudicialesR{
        width: 96%;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
      }
      @media (max-width:768px){
        #carpetasJudicialesA, #carpetasJudicialesR{
          width: 95.5%;
        }
      }
      @media (max-width:416px){
        #carpetasJudicialesA, #carpetasJudicialesR{
          width: 92%;
        }
      }
      @media (max-width:360px){
        #carpetasJudicialesA, #carpetasJudicialesR{
          width: 90%;
        }
      }
      #carpetasJudicialesA ul, #carpetasJudicialesR ul{
        width: 100%;
        padding: 6px;
        list-style: none;
  
      }
      #carpetasJudicialesA ul li, #carpetasJudicialesR ul li{
        width: 100%;
        padding: 10px 4px;
        text-align: left;
        cursor: pointer;
        transition: all 400ms;
      }
      #carpetasJudicialesA ul li:hover, #carpetasJudicialesR ul li:hover{
        background: rgb(136, 148, 52);
        color: #fff;
  
      }

    </style>
@endsection

{{-- Scripts --}}
@section('seccion-scripts-functions')
  <script>
    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
    expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
    guardias=[];
    guardias=[],
    penas=[],
    tipos_documentos_carpeta = @php echo json_encode($tipos_documento_carpeta); @endphp,
    fiscalias = @php echo json_encode($fiscalias); @endphp;
    unidades = @php echo json_encode($unidades); @endphp;
    let arrPersonas,
    folio_carpeta_seleccionada,
    carpeta_seleccionada,
    unidad_carpeta,
    strUnidadesDestino,
    form,
    copia_certificada_sentencia,
    etapas_rue=[]
    remi_sentenciados=[];;
    var arrCarpetasJudiciales=[];
    var carpetaActiva=null;
    var bandera_solo_consulta = false;
    var idf_unidad_ge = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;
    var datos_constancia = [];

    $(function(){
        //select
        $('.date').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yyyy-mm-dd'
        });

        $('.select2').select2()

        //Loader
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 1000);

        //sec_ajax();
    });

    $(document).ready(function() {
      setTimeout(function(){ loadConfigComponentsPP(); }, 300);
      setTimeout(function(){ loadConfigComponentsDA(); }, 300);
      setTimeout(function(){ loadConfigComponentsDG(); }, 300);
      setTimeout(function(){ $('#modal_loading').modal('hide'); }, 1000);
    });

    $(function(){
      'use strict'
      $('.ui-datepicker-year').addClass('select2');
      
      $('#collapseOneVidaCarpetaJudicial').on('shown.bs.collapse', function () {
				pintarEventosLT();
				pintaInformacionPrincipalVCJ(); 
				hScroll(60);
			})

      // Datepicker
      $('.fc-datepicker').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          format: 'dd/mm/yyyy',
          changeYear: true,
          yearRange: "c-100:c+0"
      });

      $('.date_fif').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd'
      });

      $('#datepickerNoOfMonths').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          numberOfMonths: 2

      });

      $('#brannd').click(function(){
        if($(this).attr('mostrar') == 1){
          $('#modulo_acumuladas').addClass('mostrar');
          $('#modulo_acumuladas').removeClass('hide');

          $('#modulo_documentos_asociados').removeClass('grande');
          $(this).attr('mostrar', 0)
        }else{
          $('#modulo_acumuladas').addClass('hide');
          $('#modulo_acumuladas').removeClass('mostrar');
          $('#modulo_documentos_asociados').addClass('grande');
          $(this).attr('mostrar', 1)
        }
      });

    });

    $(function(){
      'use strict'

      Toggles
      $('.toggle').toggles({
        on: false,
        height: 26
      });

      // Input Masks
      $('#dateMask').mask('99/99/9999');
      $('#phoneMask').mask('(999) 999-9999');
      $('#ssnMask').mask('999-99-9999');

      // Time Picker
      $('#tpBasic').timepicker();
      $('#tp2').timepicker({'scrollDefault': 'now'});
      //$('#horaInicio').timepicker();
			//$('#horaFin').timepicker();

      $('#setTimeButton').on('click', function (){
        $('#horaRecepcion').timepicker('setTime', new Date());
      });

      // Color picker
      $('#colorpicker').spectrum({
        color: '#17A2B8'
      });

      $('#showAlpha').spectrum({
        color: 'rgba(23,162,184,0.5)',
        showAlpha: true
      });

      $('#showPaletteOnly').spectrum({
          showPaletteOnly: true,
          showPalette:true,
          color: '#DC3545',
          palette: [
              ['#1D2939', '#fff', '#0866C6','#23BF08', '#F49917'],
              ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
          ]
      });

      //acuerdos reparatorios
      $("#acuerdoPDF").on('input',function () {
        leeDocumentoAcuerdoR(this, 'nuevo');
        $('#divViewDocumentosAcuerdo').css('display', 'block');
        $('#col_nombre_documento_acuerdo').css('display', 'block');
        $('#col_nombre_documento_acuerdo').css('visibility', 'hidden');
      });

      //acuerdos reparatorios
      $("#acuerdoPDF_E").on('input',function () {
        leeDocumentoAcuerdoR(this, 'edit');
        $('#divViewDocumentosAcuerdo_E').css('display', 'block');
        $('#col_nombre_documento_acuerdo_E').css('display', 'block');
        $('#col_nombre_documento_acuerdo_E').css('visibility', 'hidden');
      });

      //mandamiento
      $("#mandamientoPDF").on('input',function () {
        leeDocumentoMandamiento(this, 'nuevo');
        $('#divViewDocumentosMandamiento').css('display', 'block');
        $('#col_nombre_documento_mandamiento').css('display', 'block');
        $('#col_nombre_documento_mandamiento').css('visibility', 'hidden');
      });

      //mandamiento
      $("#mandamientoPDF_E").on('input',function () {
        leeDocumentoMandamiento(this, 'edit');
        $('#divViewDocumentosMandamiento_E').css('display', 'block');
        $('#col_nombre_documento_mandamiento_E').css('display', 'block');
        $('#col_nombre_documento_mandamiento_E').css('visibility', 'hidden');
      });
    });


    function sec_ajax(pagina_accion) {

      let body = "";

      pagina = parseInt($('#pagina_actual').val());
      registros_por_pagina = 10;

      if (pagina_accion == "primera") {
          pagina = 1;
      } else if (pagina_accion == "avanzar") {
          pagina = pagina + 1;
      } else if (pagina_accion == "atras") {
          pagina = pagina - 1;
      } else if (pagina_accion == "ultima") {
          pagina = $('#paginas_totales').val();
      }

      if (pagina <= 0 || pagina > $('#paginas_totales').val()) {

      } else {
          $('#pagina_actual').val(pagina);
          $('#numeropagina').val(pagina);
          $('.pagina_actual_texto').html(pagina);

          let id_solicitud = "";

          var calidad_juridica = $("#calidad_juridica").val();
          var tipo_carpeta = $("#tipo_carpeta").val();
          var nombre = $("#item_NC").val();

          datos_constancia.length = 0;

          console.log('idf_unidad',idf_unidad_ge);

          if(nombre.length < 1){
            error('Debe escribir un nombre para realizar la busqueda');
          }else{
            $.ajax({
                type: 'GET',
                url: '/public/buscar_personas_global',
                data: {
                    nombre: nombre,
                    tipo_carpeta:tipo_carpeta,
                    calidad_juridica:calidad_juridica,
                    id_unidad: idf_unidad_ge == 0 ? '-' : idf_unidad_ge,
                    pagina: $('#numeropagina').val(),
                    registros_por_pagina: 10,
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 100) {
                        var datos = response.response;
                        var resultado = ``;
                        var texto = nombre.toUpperCase();
                        var texto_part = texto.split(' ');
                        var carpetas = [];

                        for(i in datos){

                          if(datos[i].porcentage_coincidencia == 100){
                            carpetas.push(datos[i].datos_carpeta.folio_carpeta);
                          }

                          var imputados = ``;
                          for(j in datos[i].personas.IMPUTADO){
                            imputados += `<li><span>${datos[i].personas.IMPUTADO[j].nombre_completo}</span></li>`;
                          }

                          var victimas = ``;
                          for(j in datos[i].personas.VÍCTIMA){
                            victimas += `<li><span>${datos[i].personas.VÍCTIMA[j].nombre_completo}</span></li>`;
                          }

                          var defensor_publico = ``;
                          for(j in datos[i].personas.DEFENSOR_DE_OFICIO){
                            defensor_publico += `<li><span>${datos[i].personas.DEFENSOR_DE_OFICIO[j].nombre_completo}</span></li>`;
                          }

                          var asesor_juridico = ``;
                          for(j in datos[i].personas.ASESOR_JURÍDICO){
                            asesor_juridico += `<li><span>${datos[i].personas.ASESOR_JURÍDICO[j].nombre_completo}</span></li>`;
                          }
                          
                          var apoderado_legal = ``;
                          for(j in datos[i].personas.REPRESENTANTE_LEGAL){
                            apoderado_legal += `<li><span>${datos[i].personas.REPRESENTANTE_LEGAL[j].nombre_completo}</span></li>`;
                          }

                          var mp = ``;
                          for(j in datos[i].personas.MINISTERIO_PÚBLICO){
                            mp += `<li><span>${datos[i].personas.MINISTERIO_PÚBLICO[j].nombre_completo}</span></li>`;
                          }

                          resultado += `<div class="resultado">
                            <div class="col-md-2 conten-image">
                              <div class="solicitud_f">
                                Coincidencia: <span style="${(datos[i].porcentage_coincidencia > 80) ? 'color: #27AE60;' : (datos[i].porcentage_coincidencia < 80 &&  datos[i].porcentage_coincidencia > 50 ) ? 'color: #F1C40F;': 'color:#F1948A;' }">${datos[i].porcentage_coincidencia}%</span>
                              </div>
                              <div class="imagess">
                                <i class="fas fa-id-card-alt"></i>
                              </div>
                              <div class="solicitud_d">
                                ${datos[i].datos_carpeta.carpeta_investigacion}
                              </div>
                            </div>
                            <div class="col-md-10">
                              <div class="info_carpeta">
                                <div class="col-md-3">
                                  Carpeta Judicial: <span style="cursor:pointer; font-weight:bold;" title="Ver Carpeta Judicial" onclick="abrirModalAdministracion(${datos[i].datos_carpeta.id_carpeta_judicial})">${datos[i].datos_carpeta.folio_carpeta}</span>
                                </div>
                                <div class="col-md-3">
                                  Unidad: ${datos[i].datos_carpeta.nombre_unidad}
                                </div>
                                <div class="col-md-3">
                                  Fecha Asignacion: ${datos[i].datos_carpeta.fecha_asignacion}
                                </div>
                              </div>
                              <div class="info_persona">
                                <div class="col">
                                  <div class="title_info">imputado</div>
                                  <ul class="lista_personas">
                                    ${imputados}
                                  </ul>
                                </div>
                                <div class="col">
                                  <div class="title_info">víctima</div>
                                  <ul class="lista_personas">
                                    ${victimas}
                                  </ul>
                                </div>
                                <div class="col">
                                  <div class="title_info">asesor jurídico</div>
                                  <ul class="lista_personas">
                                    ${asesor_juridico}
                                  </ul>
                                </div>
                                <div class="col">
                                  <div class="title_info">defensor de oficio</div>
                                  <ul class="lista_personas">
                                    ${defensor_publico}
                                  </ul>
                                </div>
                                <div class="col">
                                  <div class="title_info">representante legal</div>
                                  <ul class="lista_personas">
                                    ${apoderado_legal}
                                  </ul>
                                </div>
                                <div class="col">
                                  <div class="title_info">ministerio público</div>
                                  <ul class="lista_personas">
                                    ${apoderado_legal}
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>`;
                        }
                        
                        datos_constancia.push({
                          "nombre_buscado":nombre,
                          "carpetas": carpetas.length > 0 ? carpetas : ''
                        });

                        setTimeout(function(){
                          $(".lista_personas").children("li").each(function(i,e){
                            var search = $(e).children("span").html();
                            var resultado = search.indexOf(texto);
                            if(texto.length>1 && resultado !== -1){
                              if(texto_part.length == 1){
                                $(e).children("span").addClass('coincidencia');
                              }else{
                                $(e).children("span").addClass('encontrado');
                              }
                            }else{
                              $(e).children("span").css("color","");
                            }
                          });
                        }, 1000)

                        setTimeout(function(){
                          
                          $(".lista_personas").children("li").each(function(i,e){
                            var search = $(e).children("span").html();

                            for(k in texto_part){
                              var resultado = search.indexOf(texto_part[k]);
                              if(texto_part[k].length > 1 && resultado !== -1){
                                if(!$(e).children("span").hasClass('encontrado')){
                                  $(e).children("span").addClass('coincidencia');
                                }
                              }else{
                                $(e).children("span").css("color","");
                              }
                            }
                          });
                        },1200)

                        $('#resultados').html(resultado);
                        $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                        $('#paginas_totales').val(response.response_pag['paginas_totales'])

                    } else {
                      let body = `<div class="empty">
                        <i class="fas fa-users"></i>
                        <p style="font-size: 0.5em;">Lo sentimos, no encontramos datos relacionados</p>
                      </div>`;

                      $('#resultados').html(body);
                    }
                }
            });
          }
      }
    } 

    function success(mensaje){
      $('#messageExito').html(mensaje);
      $('#modalSuccess').modal('show');
    }

    function error(mensaje){
      $('#messageError').html(mensaje);
      $('#modalError').modal('show');
    }

    function loader(accion){
      if(accion){
        $('#loader').modal('show');
      }else{
        setTimeout(function(){ $('#loader').modal('hide'); }, 500);
      }
    }

    function loading(accion){
      if(accion){
        $('#modal_loading').modal('show');
      }else{
        setTimeout(function(){ $('#modal_loading').modal('hide'); }, 500);
      }
    }

    function get_date(date, format = 'YYYY-MM-DD') {
      if (format == 'YYYY-MM-DD' && date.substring(0, 4).includes('-'))
          return date.split('-').reverse().join('-');
      if (format == 'DD-MM-YYYY' && !date.substring(0, 4).includes('-'))
          return date.split('-').reverse().join('-');
      else
          return date;
    }

    function limpiar_Busqueda(){
      $('#resultados').html('');
      $('#item_NC').val('');

      $('#resultados').html(`<div class="empty">
        <i class="fas fa-users"></i>
        <p style="font-size: 0.5em;">Realice una busqueda</p>
      </div>`);
    }

    function exportar_constancia(){
      console.log('Datos de constancia',datos_constancia);

      if(datos_constancia.length <= 0) error('Es necesario realizar una busqueda');

      $.ajax({
        type: 'POST',
        url: '/public/exportar_constancia_busqueda',
        data: {
          datos_constancia: datos_constancia
        },
        success: function(response) {
            console.log(response);
            if(response.status == 100) {
              window.open(response.response);
            }else {
              error(response.message);
            }
        }
      });
    }

    // ### funcionalidades de la carpeta
    function cargar_opciones_tipo_carpeta( tag_select_unidad , tag_select_tipo_carpeta ){
      let id_unidad = $(tag_select_unidad).val();
      let seleccion_anterior = $(tag_select_unidad).attr("data-seleccion_anterior");
      $(tag_select_unidad).attr("data-seleccion_anterior",id_unidad);
      const unidades_ejecucion = ['20','35','36','37'];

      if( unidades_ejecucion.includes( id_unidad ) ){
        $( tag_select_tipo_carpeta ).val('6').trigger('change');
      }else{
        $( tag_select_tipo_carpeta ).val('1').trigger('change');
      }
    }

    async function abrirModalCambiar( id_carpeta_judicial , id_unidad ){
      $("#id_juez_cambiar").empty();
      $("#motivoCambioJuez").val('');

      let jueces = await obtener_jueces_control_ejecuion( id_unidad );
      let optionJ = ``;
      
      if( jueces.status == 100 ){
        optionJ = `<option value="-">Seleccione un juez</option>`;
        for( var i in jueces.response ){
          let juez = jueces.response[i];
          optionJ = optionJ + `<option value="${juez.id_usuario}" data-cve="${juez.cve_juez}">${juez.nombres??''} ${juez.apellido_paterno??''} ${juez.apellido_materno??''}</option>`;
        }

      }else optionJ = `<option value="-">${jueces.message}</option>`;

      $("#id_juez_cambiar").html(optionJ);
      $("#btnCambiarJuezCJ").attr('onCLick', `cambiar_juez( ${id_carpeta_judicial}, '${id_unidad}', ${true} )` );
      $("#modalCambiarJuezCJ").modal('show');
      setTimeout(function (){ $("#id_juez_cambiar").select2(); },500);
    }

    function cambiar_juez( id_carpeta_judicial, id_unidad, confirmar = true ){
      
      if( confirmar ){

        let nombre_juez = $("#id_juez_cambiar option:selected").text();
        let title = `Asignar al juez ${nombre_juez} a la carpeta ${ arrCarpetasJudiciales[id_carpeta_judicial].folio_carpeta }`;
        let body = `<p>Presione "Aceptar" si está seguro de cambiar al juez o "Cancelar" para no aplicar cambios</p>` 
        $("#btnAceptarModalConfirm").attr("data-modal","");
        setTimeout(function (){ modal_confirm(title,body,`cambiar_juez( ${id_carpeta_judicial}, '${id_unidad}', ${false} )`, 'modalCambiarJuezCJ' ); },1000);
        return false;
      }

      let juez = $("#id_juez_cambiar").val();
      let cve = $("#id_juez_cambiar option:selected").attr("data-cve");
      let motivos = $("#motivoCambioJuez").val();

      if( !juez || juez == "-" || juez == ""){ modal_error('Debe seleccionar un juez','modalCambiarJuezCJ'); return false; }
      if( !motivos || motivos == "-" || motivos == ""){ modal_error('Debe ingresar el motivo','modalCambiarJuezCJ');  return false; }

      $.ajax({
        method:'POST',
        url:'/public/cambiar_juez_predefinido',
        data:{
          carpeta : id_carpeta_judicial ,
          juez : juez ,
          cve : cve ,
          comentarios : motivos ,
        },
        success:function(response){
          console.log( "Cambiar juez:", response );
          if( response.status == 100 ){
            modal_success('Se ha cambiado el juez exitosamente',null);
            $("#btnCambiarJuezCJ").attr('onCLick', `` );
            $("#btnAceptarModalConfirm").attr("data-modal","modalAdministracion");
            buscar( parseInt( $(".pagina").text() ) );
          }else{
            modal_error('Error :'+ response.message,'modalCambiarJuezCJ');
          }
        },
        error : function( errors ){
          modal_error('Error :'+ errors.message,'modalCambiarJuezCJ');
        }
      });

    }
    
    function obtener_jueces_control_ejecuion( id_unidad ){
      return new Promise(resolve => {
        $.ajax({
          method:'POST',
          url:'/public/obtener_jueces_unidad',
          async: false,
          data:{ id_unidad:id_unidad, uga:id_unidad },
          success:function(response){
            console.log(response);
            resolve(response);
          },
          error : function( errors ){
            modal_error('Error :'+errors,'modalConfirm');
            resolve( {status:0, message:'Error al consumir servicio jueces '+tipo} );
          }
        });
      });
    }

    function cambiar_situacion_carpeta(id_carpeta_judicial,id_situacion_carpeta){
        $("#input_id_carpeta_judicial_situacion").val(id_carpeta_judicial);

        $("#modal_situacion_carpeta").modal("show");

        if(id_situacion_carpeta == 3){
          $("#mensaje_modal_situacion").html("<div class='alert alert-success' role='alert'>Activar carpeta judicial</div>");
        }
        else{
          $("#mensaje_modal_situacion").html("<div class='alert alert-danger' role='alert'>Cerrar carpeta judicial</div>");
        }
    }

    function guardar_situacion_carpeta(){

      $.ajax({
        method:'POST',
        url:'/public/cambiar_situacion_carpeta',
        data:{
          id_carpeta_judicial : $("#input_id_carpeta_judicial_situacion").val(),
          comentarios : $("#comentarios_situacion_carpeta").val()
        },
        success:function(response){
          if( response.status == 100){
            modal_success('Proceso realizado');
            buscar(1);
            cerrarModalGeneral('modal_situacion_carpeta');
          }
          else{
            modal_error(response.message);
          }
        }
      });

    }

    function prestar_carpeta_guardar(){

      $.ajax({
        method:'POST',
        url:'/public/prestamo_carpeta',
        data:{
          id_carpeta_judicial : $("#id_carpeta_prestamo").val(),
          id_unidad : $("#unidad_prestamo").val()
        },
        success:function(response){
          if( response.status == 100){

            modal_success('Proceso realizado');
            $("#id_unidad").val("");
            cerrarModalGeneral('modal_prestamo');
            buscar(1);

          }
          else{
            modal_error(response.message);
          }
        }
      });

    }

    function cerrarModalGeneral(valor){
      $('#'+valor).hide();
      $('#'+valor).modal("toggle");
    }

    function buscarCarpetaReferida() {
      var carpetaAsociada = $("#carpetaJudicialReferida").val();
      $.ajax({
          type: "POST",
          url: "public/buscar_carpetas_referidas",
          data: {
              carpetaAsociada: carpetaAsociada,
          },
          success: function (response) {
              if (response.status == 100) {
                  $("#carpetasJudicialesR").css("display", "block");
                  let carpetas = "";
                  $(response.response).each(function (index, carpeta) {
                      const { id_carpeta_judicial, folio_carpeta } = carpeta;
                      const option = `<li onclick="setInputCarpteaAsociada('${folio_carpeta}', 'referido', '${id_carpeta_judicial}')">${folio_carpeta}</li>`;
                      carpetas = carpetas.concat(option);
                  });

                  $("#carpetasJudicialesR").html("<ul>" + carpetas + "</ul>");
              } else {
                  $("#carpetasJudicialesR").html("<ul><li>Sin datos para mostrar</li></ul>");
              }
              setTimeout(function () {
                  $("#modal_loading").modal("hide");
              }, 500);
          },
      });
    }

    function setInputCarpteaAsociada(carpeta, tipo, idCarpeta){
      if(carpeta == 'n' && idCarpeta=='n'){
        $('#carpetaJudicialReferida').val('');
        $('#carpetasJudicialesR').css('display', 'none');
      }else{
        $("#id_carpeta_hija").val(idCarpeta);
        $('#carpetaJudicialReferida').val(carpeta);
        $('#carpetaJudicialReferida').attr('data-idcarpeta',idCarpeta);
        $('#carpetasJudicialesR').css('display', 'none');
      }
    }

    function acumular(valor,valor2){
      $("#modal_acumula").modal("show");

      $("#id_carpeta_padre").val(valor);
      $("#carpeta_padre").val(valor2);
    }

    function prestar_carpeta(valor,valor2,valor3){

      if(valor3 > 0){
        $("#modal_devolver_prestamo").modal("show");

        $.ajax({
          method:'POST',
          url:'/public/ver_ugas',
          data:{
            tipo : 5
          },
          success:function(response){
            console.log(response);
                 option = "";
            if( response.status == 100){
              $(response.response).each(function(index, unidad){
                option += "<option>" + unidad.nombre_unidad + "</option>";
                if(unidad.id_unidad_gestion == valor3){
                  option += "<option value = '" + unidad.id_unidad_gestion + "' disabled selected>" + unidad.nombre_unidad + "</option>";
                }
              });

              $("#unidad_prestamo_origen").html(option);
              $("#input_id_carpeta_judicial_dev").val(valor);
            }
          }
        });
      }
      else{
        $("#id_carpeta_prestamo").val(valor);
        $("#folio_carpeta_prestamo").val(valor2);
        $("#modal_prestamo").modal("show");

        $.ajax({
          method:'POST',
          url:'/public/ver_ugas',
          data:{
            tipo : 5
          },
          success:function(response){
            var option = "<option disabled selected>Seleccione...</option>";
            if( response.status == 100){
              $(response.response).each(function(index, unidad){
                option += "<option value = '" + unidad.id_unidad_gestion + "'>" + unidad.nombre_unidad + "</option>";
              });
              $("#unidad_prestamo").html(option);
            }
          }
        });
      }
    }

    function devolver_carpeta(){
      var input_id_carpeta_judicial_dev = $("#input_id_carpeta_judicial_dev").val();
       if(input_id_carpeta_judicial_dev){
        $.ajax({
          method:'POST',
          url:'/public/devolver_carpeta',
          data:{
            id_carpeta_judicial : input_id_carpeta_judicial_dev
          },
          success:function(response){
            if( response.status == 100){
              modal_success('Carpeta judicial devuelta correctamente');
              cerrarModalGeneral('modal_devolver_prestamo');
              buscar(1);
            }
            else{
              modal_error(response.message);
            }
          }
        });
      }
      else{
        modal_error("ERROR");
      }
    }

    function guardar_acumulacion(){
      var id_carpeta_padre = $("#id_carpeta_padre").val();
      var id_carpeta_hija  = $("#id_carpeta_hija").val();
      var carpetaJudicialReferida = $("#carpetaJudicialReferida").val();

      const id_carpeta_hija_array = [id_carpeta_hija];

      if((id_carpeta_padre) && (id_carpeta_hija_array.length >0) &&(carpetaJudicialReferida)){
        $.ajax({
          method:'POST',
          url:'/public/guardar_acumular',
          data:{
            id_carpeta_padre : id_carpeta_padre,
            id_carpeta_hija : id_carpeta_hija_array
          },
          success:function(response){
            if( response.status == 100){
              modal_success('Carpeta acumulada');
              cerrarModalGeneral('modal_acumula');
              $("#id_carpeta_hija").val("");
              $("#carpetaJudicialReferida").val("");
              buscar(1);

            }
            else{
              modal_error(response.message);
            }
          }
        });
      }
      else{
        modal_error('Seleccione carpeta judicial');
      }
    }

    function guardar_acumulacion(){
      var id_carpeta_padre = $("#id_carpeta_padre").val();
      var id_carpeta_hija  = $("#id_carpeta_hija").val();
      var carpetaJudicialReferida = $("#carpetaJudicialReferida").val();

      const id_carpeta_hija_array = [id_carpeta_hija];

      if((id_carpeta_padre) && (id_carpeta_hija_array.length >0) &&(carpetaJudicialReferida)){
        $.ajax({
          method:'POST',
          url:'/public/guardar_acumular',
          data:{
            id_carpeta_padre : id_carpeta_padre,
            id_carpeta_hija : id_carpeta_hija_array
          },
          success:function(response){
            if( response.status == 100){
              modal_success('Carpeta acumulada');
              cerrarModalGeneral('modal_acumula');
              $("#id_carpeta_hija").val("");
              $("#carpetaJudicialReferida").val("");
              buscar(1);

            }
            else{
              modal_error(response.message);
            }
          }
        });
      }
      else{
        modal_error('Seleccione carpeta judicial');
      }
    }

    function abrirCarpetaNotificacion(){
      var URLactual = window.location.pathname;

      if(URLactual.length < 21){}else{ // si la url trae paramatros

        var id = URLactual.split('/');
        var id_c = atob(id[2]);
        var cifr = id_c.split('_');
        var id_carp = cifr[0];
        var carp_jl = cifr[1];

        $("#unidad option:first").prop('selected',true).trigger( "change" );
        $("#tipoCarpeta option:first").prop('selected',true).trigger( "change" );
        $('#folioCarpeta').val(carp_jl);


        setTimeout(function(){
          $('#buzz').trigger('click');
        }, 500);

        setTimeout(function(){
          window.history.replaceState({}, document.title, "/" + "carpetas_judiciales");
          abrirModalAdministracion(id_carp);
          $('#folioCarpeta').val('');
          $('#buzz').trigger('click');
        }, 700);

      }

    }

    async function abrirModalAdministracion( id_carpeta_judicial , tag_btn = false ){
      if(tag_btn) $(tag_btn).attr('disabled',true);

      //loading(true);

      carpetaActiva = null;
      //carpetaActiva = arrCarpetasJudiciales[id_carpeta_judicial];
      carpetaActiva = arrCarpetasJudiciales[id_carpeta_judicial] != undefined ? arrCarpetasJudiciales[id_carpeta_judicial] : await obtener_carpeta_por_id( id_carpeta_judicial ) ;
      if( carpetaActiva == 0 ) return false;
      
      if( (carpetaActiva.id_unidad != "{{$request->session()->get('id_unidad_gestion')}}" && "{{$request->session()->get('id_unidad_gestion')}}" != "0") ){
        bandera_solo_consulta = true;
        $("#accordionAudienciasCrear").addClass('d-none');
        $("#btn-agregarDelito-DE").addClass('d-none');
        $("#accordionDocumentosAsociados").addClass('d-none');
        $("#accordionDocumentosGenerados").addClass('d-none');
        $("#accordionHisgtorialImputado").addClass('d-none');
        $("#accordionNotificaionAlerta").addClass('d-none');
        $("#accordionNuevaParteProcesal").addClass('d-none');
        $("#btn-agregarPrescripcion-P").addClass('d-none');
      }else{
        bandera_solo_consulta = false;
        $("#accordionAudienciasCrear").removeClass('d-none');
        $("#btn-agregarDelito-DE").removeClass('d-none');
        $("#accordionDocumentosAsociados").removeClass('d-none');
        $("#accordionDocumentosGenerados").removeClass('d-none');
        $("#accordionHisgtorialImputado").removeClass('d-none');
        $("#accordionNotificaionAlerta").removeClass('d-none');
        $("#accordionNuevaParteProcesal").removeClass('d-none');
        $("#btn-agregarPrescripcion-P").removeClass('d-none');
      }

      if( carpetaActiva.tipo_solicitud_ == 'PRO-MUJER' || carpetaActiva.id_juez_ejecucion != null ){
        bandera_juez_predefinido = true ;
      }else{
        bandera_juez_predefinido = false ;
      }
      

      let titulo = 'CARPETA JUDICIAL : '+carpetaActiva.folio_carpeta;
      let texto = '';
      let style = '';

      if(carpetaActiva.situacion_carpeta == 'activo'){
        texto = 'activo';
        style = 'background: #51b640 !important; top:26px; text-transform:lowercase; width: 35px !important; height: 18px !important; margin-right: 10px; position: absolute; left: 0; font-size: 0.65em; display: flex; justify-content: center; align-items: center; color: #fff;';
      }else if(carpetaActiva.situacion_carpeta == 'Cerrada') {
        texto = 'cerrada';
        style = 'background: #525458 !important; top:26px; text-transform:lowercase; width: 35px !important; height: 18px !important; margin-right: 10px; position: absolute; left: 0; font-size: 0.65em; display: flex; justify-content: center; align-items: center; color: #fff;';
      }

      if(carpetaActiva.id_tipo_carpeta != 6){
        $('#nav-prescripciones-tab').css('display', 'none');
      }

      $("#lbl-titulo-modal-administracion").text( titulo );
      $("#lbl-titulo-modal-administracion").css('margin-left', '10px');
      $("#estado_carpeta").attr( 'style', style );
      $("#estado_carpeta").html(texto);
      $("#id_carpeta_judicial").val( id_carpeta_judicial );
      $("#id_solicitud").val( carpetaActiva.id_solicitud );
      $("#tipo_solicitud").val( carpetaActiva.tipo_solicitud_ );

      //loading(true);
      $.ajax({
        method:'POST',
        url:'/public/sincronizacion_carpeta',
        async:false,
        data:{ id_solicitud : carpetaActiva.id_solicitud, },
        success:function(response){
          console.log('RESPUESTA SINCRONIZACIÓN CJ :',response);
          //loading(false , 1000);
        },
        error: function(request, status, error){
          console.log(request, status, error);
          //loading(false , 1000);
        },
      }); // ajax

      $("#modalAdministracion").modal('show');


      //setTimeout(function(){
        //loading(false, 100);
        //setTimeout(function(){  $("#modalAdministracion").modal('show'); }, 1000 );
        //if(tag_btn) $(tag_btn).attr('disabled',false);
      //}, 3000 );

      $("#nav-tab-carpetas-judiciales a.nav-item").each(function(){
        if( $( this ).hasClass("active") ){
          cargarInformacionTab( $( this ).attr("id") );
          if( $( this ).attr("id") == "nav-documentos-asociados-tab" ){ limpiaFormularioDocumentosAsociados(); }
          if( $( this ).attr("id") == "nav-audiencias-tab" ){ limpiarEspacioA('#espacioEditarAudiencia'); limpiarEspacioA('#espacioCrearAudiencia') }
          if( $( this ).attr("id") == "nav-partes-procesales-tab" ){ limpiarFormularioParteProcesal(); }
          if( $( this ).attr("id") == "nav-documentos-generados-tab" ){ $("#tipoPlantilla").val('-').change(); }
          if( $( this ).attr("id") == "nav-prescripciones-tab" ){  resetform('frm_prescripcion'); resetform('frm_prescripcion_Edit'); }
          if( $( this ).attr("id") == "nav-notificaciones-alertas-tab" ){ reset_formulario_NA(); }
        }
      });

      //pintarEventosLT();
    }

    function cargarInformacionTab( id_nav ){
      console.log("seleccionaste a "+ id_nav);
      if( id_nav == "nav-documentos-asociados-tab" ){ pintarDocumentosAsociados(); pintarCarpetasRemitidas(); pintarCarpetasAcumuladas(); pintarAudiencias(); }
      if( id_nav == "nav-audiencias-tab" ){ pintarAudiencias(); }
      if( id_nav == "nav-partes-procesales-tab" ){ pintarPersonas(); limpiarFormularioParteProcesal(); }
      if( id_nav == "nav-delitos-sin-relacionar-tab" ){ pintarDelitosSinRelacionar(); }
      if( id_nav == "nav-documentos-generados-tab" ){ pintarPersonas(); $("#tipoPlantilla").val('-').change(); cancelarEdicionDG(); pintarDocumentosGenerados(); cargaUsuarios(); pintarOficiosEnviadosUSMC(); obtenerAudenciasDGVP();   }
      if( id_nav == "nav-prescripciones-tab" ){ pintarPrescripciones(); }
      if( id_nav == "nav-notificaciones-alertas-tab" ){ pintarNotificacionesAlertas();  }
      if( id_nav == "nav-estatus-imputado-tab" ){ pintarHistorialImputados(); }
    }

    function obtener_carpeta_por_id( id_carpeta ){
      return new Promise(resolve => {
        $.ajax({
          method:'POST',
          url:'/public/obtener_carpetas_judiciales',
          data:{
            modo:"completo",
            carpeta_judicial:id_carpeta,
            bandera_sin_unidad:1
          },
          success:function(response){
            if( response.status == 100 ) resolve( response.response[0] );
            else{ modal_error( response.message ); resolve( 0 ); }
          },
          error : function( errors ){
            modal_error('Error :'+errors,'modalAdministracion');
            resolve( 0 ) ;
          }
        });
      });
    }

    function abrirModalBorrarCJ( id_carpeta_judicial ){
      carpetaActiva = arrCarpetasJudiciales[id_carpeta_judicial];
      let titulo = 'CARPETA JUDICIAL A BORRAR: '+carpetaActiva.folio_carpeta;
      $("#id_carpeta_borrar").val(id_carpeta_judicial);
      $("#id_unidad_redireccion").val('-').trigger('change');
      $("#motivo_redireccion").val("");
      $("#modalBorrarCJ").modal('show');
    }

    function borrarCarpetaJudicial( ){
      $("#modalBorrarCJ").modal('hide');
      $.ajax({
        method:'POST',
        url:'/public/borrar_carpeta_judicial',
        data:{
          carpeta:$("#id_carpeta_borrar").val(),
          id_unidad_redireccion:$("#id_unidad_redireccion").val(),
          motivo_redireccion:$("#motivo_redireccion").val(),
        },
        success:function(response){
          console.log('RESPUESTA BORRAR CJ :',response);
          if(response.status==100){
            let mensaje = ( $("#id_unidad_redireccion").val() == "-" ? 'Carpeta Judicial eliminada' : 'Carpeta redirecionada con el folio '+response.response.folio_carpeta_nueva ) 
            modal_success( mensaje);
            buscar( parseInt( $(".pagina").text() ) );
          }else{
            modal_error(response.message);
          }
        } // success
      }); // ajax
    }

    function loading(accion, delay = 500){
      if(accion){
        $('#modal_loading').modal('show');
      }else{
        setTimeout(function(){ $('#modal_loading').modal('hide'); }, delay);
      }
    }

    $(".cerrar-modal").click(function(){
      let modalOpen = $(this).attr('data-modal');
      let modalClose = $(this).attr('data-thismodal');
      //console.log(modalOpen,modalClose);
      $("#"+modalClose).modal('hide');
      if( modalOpen.length ) setTimeout(function(){ $("#"+modalOpen).modal('show'); }, 500);
    });

    function modal_error(mensaje,modalAnterior=null){
      $('#messageError').html(`${mensaje}`);
      $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
      $('#modalError').modal('show');
    }

    function modal_success(mensaje,modalAnterior=null){
      $('#modal-success-titulo').html(`${mensaje}`);
      $('#btnCerrarSuccess').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
      $('#modalSuccess').modal('show');
    }

    function modal_warning(mensaje,fn,modalAnterior=null){
      $('#modal-warning-titulo').html(`${mensaje}`);
      $('#btnCerrarWarning').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
      $('#btnCerrarWarning').attr('onclick', fn);
      $('#modalWarning').modal('show');
    }

    function modal_confirm(title,body,fn=null,modalAnterior=null){

      if(body=='borrar_documento'){
        body = `
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Ingrese los motivos por los que desea remover este documento:</label>
                <textarea class="form-control" name="motivo_remover_documento" id="motivoRemoverDocumento" rows="4"></textarea>
              </div>
            </div>
          </div>
        `;
      }else if( body=='enviar_documento' ){
        body = `
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Turnar documento </label>
                <label class="form-control-label">Comentarios Adicionales </label>
                <textarea class="form-control" name="comentariosAdicionalesEnvioDocumento" id="comentariosAdicionalesEnvioDocumento" rows="4"></textarea>
              </div>
            </div>
          </div>
        `;
      }

      $("#tituloModalConfirm").html('');
      $("#bodyModalConfirm").empty();
      $("#btnAceptarModalConfirm").removeAttr( "onClick" );

      $("#tituloModalConfirm").html(title);
      $("#bodyModalConfirm").append(body);
      if( fn!=null ) $("#btnAceptarModalConfirm").attr('onClick',fn);

      if( modalAnterior ) $('#'+modalAnterior).modal('hide');

      $('#btnCancelarModalConfirm').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      $("#modalConfirm").modal('show');
    }

    function modal_historial(title,body,modalAnterior=null){
      $("#tituloModalHistory").html('');
      $("#bodyModalHistory div").remove();

      $("#tituloModalHistory").html(title);
      $("#bodyModalHistory").append(body);

      if( modalAnterior ) $('#'+modalAnterior).modal('hide');
      $('.btnCerrarModalHistory').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      //$('#btnCerrarModalHistory').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      $("#modalHistory").modal('show');
    }

    function modal_detalle(title,body,modalAnterior=null){
      $("#tituloModalDetalle").html('');
      $("#bodyModalDetalle div").remove();
      $("#bodyModalDetalle").empty();

      $("#tituloModalDetalle").html(title);
      $("#bodyModalDetalle").append(body);

      if( modalAnterior ) $('#'+modalAnterior).modal('hide');
      //$('#btnCerrarModalDetalle').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      $('.btnCerrarModalDetalle').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      $("#modalDetalle").modal('show');
    }

    function get_unique_id(){
      var date = new Date();
      return date.getHours()+''+date.getMinutes()+''+date.getSeconds()+''+date.getMilliseconds();;
    }

    function get_fecha_letra(fecha, options=null){
      fl = new Date(fecha);
      options = options?? { year: 'numeric', month: 'long', day: 'numeric' };

      return fl.toLocaleDateString("es-ES", options);
    }

    function error(title='', message='', modal=''){
      $('#titleError').html(title);
      $('#messageError').html(message);
      $('#modalError').modal('show');
      if(modal!=''){
        $('#'+modal).modal('hide');
        $('#btnCerrarError').attr('onclick', `abreModal('${modal}',355)`);
      }
    }

    function abreModal(modal, time=0){
      setTimeout(function(){
        $('#'+modal).modal('show');
      },time);
    }

    function cerrarModalAdmon(){
      $('#modalAdministracion').hide();
      $('#titleAccordionVidaCarpetaJudicial').removeClass('collapsed');
      $('#collapseOneVidaCarpetaJudicial').removeClass('show');

      $('#titleAccordionVidaCarpetaJudicial').addClass('collapsed');
    }

  </script>
@endsection

@section('seccion-modales')
  <!-- M O D A L    A D M  I N  I S T  R A  C I O N -->
  <div id="modalAdministracion" class="modal fade"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-xxl modal-lg xl mg-b-100 modalAdministracion-body" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm modalAdministracion-content" style="overflow-y: auto; min-height: 900px;">
        <div class="modal-header pd-x-20 d-flex justify-content-between">
          <div class="p-2">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><div id="estado_carpeta"></div><span id="lbl-titulo-modal-administracion"></span></h6>
          </div>
          <div class="p-2">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="lbl-hijos-modal-administracion"></span></h6>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModalAdmon()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> <!-- HEADER -->

        <div class="modal-body pd-20">
          <input type="hidden" name="id_carpeta_judicial" id="id_carpeta_judicial" value="">
          <input type="hidden" name="id_solicitud" id="id_solicitud" value="">
          <input type="hidden" name="tipo_solicitud" id="tipo_solicitud" value="">
          @include('carpetas.tabs.vida-carpeta')
          <br><br>
          <nav>
            <div class="nav nav-tabs tabs_responsivas" id="nav-tab-carpetas-judiciales" role="tablist">
              <a class="nav-item nav-link active" id="nav-documentos-asociados-tab" data-toggle="tab" href="#nav-documentos-asociados" role="tab" aria-controls="nav-documentos-asociados" aria-selected="true" onclick="cargarInformacionTab('nav-documentos-asociados-tab')">Documentos Asociados</a>
              <a class="nav-item nav-link" id="nav-audiencias-tab" data-toggle="tab" href="#nav-audiencias" role="tab" aria-controls="nav-audiencias" aria-selected="false"  onclick="cargarInformacionTab('nav-audiencias-tab')">Audiencias</a>
              <a class="nav-item nav-link" id="nav-partes-procesales-tab" data-toggle="tab" href="#nav-partes-procesales" role="tab" aria-controls="nav-partes-procesales" aria-selected="false"  onclick="cargarInformacionTab('nav-partes-procesales-tab')">Partes Procesales</a>
              <a class="nav-item nav-link" id="nav-delitos-sin-relacionar-tab" data-toggle="tab" href="#nav-delitos-sin-relacionar" role="tab" aria-controls="nav-delitos-sin-relacionar" aria-selected="false"  onclick="cargarInformacionTab('nav-delitos-sin-relacionar-tab')">Delitos Sin Relacionar</a>
              <a class="nav-item nav-link" id="nav-documentos-generados-tab" data-toggle="tab" href="#nav-documentos-generados" role="tab" aria-controls="nav-documentos-generados" aria-selected="false"  onclick="cargarInformacionTab('nav-documentos-generados-tab')">Documentos Generados</a>
              <a class="nav-item nav-link" id="nav-prescripciones-tab" data-toggle="tab" href="#nav-prescripciones" role="tab" aria-controls="nav-prescripciones" aria-selected="false"  onclick="cargarInformacionTab('nav-prescripciones-tab')">Prescripciones</a>
              <a class="nav-item nav-link" id="nav-notificaciones-alertas-tab" data-toggle="tab" href="#nav-notificaciones-alertas" role="tab" aria-controls="nav-notificaciones-alertas" aria-selected="false"  onclick="cargarInformacionTab('nav-notificaciones-alertas-tab')">Notificaciones / Alertas</a>
              <a class="nav-item nav-link" id="nav-estatus-imputado-tab" data-toggle="tab" href="#nav-estatus-imputado" role="tab" aria-controls="nav-estatus-imputado" aria-selected="false"  onclick="cargarInformacionTab('nav-estatus-imputado-tab')">Historial de estatus de imputado</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-documentos-asociados" role="tabpanel" aria-labelledby="nav-documentos-asociados">
              @include('carpetas.tabs.documentos-asociados')
            </div><!-- tab-docuemntos-asociados -->
            <div class="tab-pane fade" id="nav-audiencias" role="tabpanel" aria-labelledby="nav-audiencias">
              @include('carpetas.tabs.audiencias')
            </div><!-- tab-audiencias -->
            <div class="tab-pane fade" id="nav-partes-procesales" role="tabpanel" aria-labelledby="nav-partes-procesales">
              @include('carpetas.tabs.partes-procesales')
            </div><!-- tab-partes-procesales -->
            <div class="tab-pane fade" id="nav-delitos-sin-relacionar" role="tabpanel" aria-labelledby="nav-delitos-sin-relacionar">
              @include('carpetas.tabs.delitos-sin-relacionar')
            </div><!-- tab-delitos-sin-relacionar -->
            <div class="tab-pane fade" id="nav-documentos-generados" role="tabpanel" aria-labelledby="nav-documentos-generados">
              @include('carpetas.tabs.documentos-generados')
            </div><!-- tab-documentos-generados -->
            <div class="tab-pane fade" id="nav-prescripciones" role="tabpanel" aria-labelledby="nav-prescripciones">
              @include('carpetas.tabs.prescripciones')
            </div><!-- tab-prescripciones -->
            <div class="tab-pane fade" id="nav-notificaciones-alertas" role="tabpanel" aria-labelledby="nav-notificaciones-alertas">
              @include('carpetas.tabs.notificaciones-alertas')
            </div><!-- tab-notificaciones-alertas -->
            <div class="tab-pane fade" id="nav-estatus-imputado" role="tabpanel" aria-labelledby="nav-estatus-imputado">
              @include('carpetas.tabs.historial-imputado')
            </div><!-- tab-carpetas-imputado -->
          </div><!-- div-historial-content -->
        </div><!-- modal-body -->

        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModalAdmon()">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <!-- M O D A L    U S O     G E N E R A L -->

  <div id="modalError" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20" id="titleError">Datos incompletos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25 cerrar-modal" data-modal="" data-thismodal="modalError" id="btnCerrarError">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h6 class="tx-success tx-semibold mg-b-20"></h6>
          <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-success-titulo">Titulo Modal Success</p>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-modal="" data-thismodal="modalSuccess" id="btnCerrarSuccess">Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalConfirm" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-medium modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalConfirm"></h6>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyModalConfirm">

        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalAdministracion" data-thismodal="modalConfirm" id="btnCancelarModalConfirm">Cancelar</button>
          <button type="button" class="btn btn-primary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalAdministracion" data-thismodal="modalConfirm" id="btnAceptarModalConfirm">Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalHistory" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalHistory"></h6>
          <button type="button" class="close cerrar-modal btnCerrarModalHistory" data-modal="modalAdministracion" data-thismodal="modalHistory" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyModalHistory">

        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalHistory" data-modal="modalAdministracion" data-thismodal="modalHistory" id="btnCerrarModalHistory">Cerrar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->


  <div id="modalWarning" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
      <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <i class="icon ion-warning-outline tx-100 tx-warning lh-1 mg-t-20 d-inline-block"></i>
            <h4 class="tx-warning tx-semibold mg-b-20">Advertencia!</h4>
            <div>
              Hay Campos vacios
            </div>
          </div><!-- modal-body -->
          <div class="modal-footer d-flex">
            <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
          </div>
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
  </div>

  <div id="loader" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20" style="background: rgba(0,0,0,0.7);">
          <h5 style="color:#fff;">Consultando Reporte</h5>
          <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="delete_reg" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available; max-width: 500px!important;">
        <div class="modal-content tx-size-sm">
            <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
            <h5 class="modal-title" >Eliminar Registro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('delete_reg')">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body pd-x-20 pd-t-0 pd-b-0">
              <input type="hidden" id="id_delete">
              <h5 class="my-4">¿Deseas eliminar el registro?</h5>
            </div>
            <div class="modal-footer d-flex" id="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar_modal('delete_reg')">Cancelar</button>
                <button type="button" class="btn btn-secondary " onclick="eliminarRegistro()" style="background:#E74C3C !important; color:#fff;"  id="btn_guardarContacto">Eliminar</button>
            </div>
        </div>
    </div>
  </div>


  <!-- M O D A L    S T R E A M I N G  -->
  
  <div id="modal-streaming" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-vertical-center modal-xl" role="document" style="min-width: 80%;">
        <div class="modal-content bd-0 tx-14" style="border-radius: 7px;">
            <div class="modal-header" style="padding:2px 25px; background: rgba(0,0,0,0.8) !important; color:#fff !important; border-bottom:none;">
                <h6 class="tx-12 mg-b-0 tx-uppercase tx-inverse tx-bold" style="color:#fff !important; margin-top:1.2%;"><span id="streaming_id">-</h6>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close" style="color:#fff !important;" onclick="cerrarStream('modal-streaming', 'modalAdministracion')">
                    <span aling="right" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0px !important;">
                <div id="stream" class="buffering"></div>
            </div>
        </div>
    </div>
  </div>

  {{-- ACUSE AUDIENCIA --}}
  <div id="modal-acuse" class="modal fade" data-keyboard="false">
    <div class="modal-dialog modal-dialog-vertical-center modal-xl" role="document" style="min-width: 70%;">
      <div class="modal-content bd-0 tx-14" >
        <div class="modal-header">
            <h6 class="tx-12 mg-b-0 tx-uppercase tx-inverse tx-bold">Documentos</h6>
            <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close" onclick="cerrarAcuse('modal-acuse', 'modalAdministracion')">
                <span aling="right" aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align: center;">
            <div class="row">
                <div class="col-md-3" >
                    <div class="documentos" id="lista_docs">

                    </div>
                </div>
                <div class="col-md-9" id="visorPDFacuse">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"  onclick="cerrarAcuse('modal-acuse', 'modalAdministracion')">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  {{--  DDCUMENTOS DE RESOLUTIVOS AUDIENCIA --}}
  <div id="modal-res-documento" class="modal fade" data-keyboard="false">
    <div class="modal-dialog modal-dialog-vertical-center modal-xl" role="document" style="min-width: 70%;">
      <div class="modal-content bd-0 tx-14" >
        <div class="modal-header">
            <h6 class="tx-12 mg-b-0 tx-uppercase tx-inverse tx-bold">Documentos</h6>
            <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close" onclick="cerrarAcuse('modal-res-documento', 'modalHistory')">
                <span aling="right" aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align: center;">
            <div class="row">
                <div class="col-md-12" id="visorPDFdocumento">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"  onclick="cerrarAcuse('modal-res-documento', 'modalHistory')">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- M O D A L    A U D I E N C I A   I N F O -->

  {{--  // ########## MANDAMIENTOS jUDICIALES ##########  --}}

  {{-- Modal Agregar acciones resolutivos --}}
  <div id="modalAccionesResolutivos" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Resolutivo</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalAccionesResolutivos" data-modal="modalHistory" data-thismodal="modalAccionesResolutivos" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyAccionesResolutivos">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalAccionesResolutivos"  data-modal="modalHistory" data-thismodal="modalAccionesResolutivos" id="btnCerrarModalAccionesResolutivos">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardar_resolutivo()" id="saveResolutivo">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal editar acciones resolutivos--}}
  <div id="modalAccionesResolutivos_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Resolutivo</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalAccionesResolutivos_E" data-modal="modalHistory" data-thismodal="modalAccionesResolutivos_E" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyAccionesResolutivos_E">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalAccionesResolutivos_E" data-modal="modalHistory" data-thismodal="modalAccionesResolutivos_E" id="btnCerrarModalAccionesResolutivos_E">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="editar_resolutivo()" id="saveResolutivo">Actualizar</button>
        </div>
      </div>
    </div>
  </div>


  {{-- Modal Agregar Mandamientos judiciales --}}
  <div id="modalMandamiendoJudicial" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Mandamiento Judicial</h6>
          <button type="button" class="close cerrar-modal btnCerrarmodalMandamiendoJudicial" data-modal="modalHistory" data-thismodal="modalMandamiendoJudicial" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyMandamiendoJudicial">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarMandamiendoJudicial" data-modal="modalHistory" data-thismodal="modalMandamiendoJudicial" id="btnCerrarMandamiendoJudicial">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarMandamiento()" id="btnGuardarMandamiendoJudicial">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal editar Mandamientos judiciales --}}
  <div id="modalMandamiendoJudicialEdit" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Mandamiento</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalMandamiendoJudicialEdit" data-modal="modalHistory" data-thismodal="modalMandamiendoJudicialEdit" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyMandamiendoJudicialEdit">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalMandamiendoJudicialEdit" data-modal="modalHistory" data-thismodal="modalMandamiendoJudicialEdit" id="btnCerrarMandamiendoJudicialEdit">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_mandamientos()" id="btnActualizarMandamiento">Actualizar</button>
        </div>
      </div>
    </div>
  </div>


  {{--  // ########## ACUERDOS REPARATORIOS ##########  --}}
  {{--  Modal Agregar Acuerdo Reparatorio  --}}
  <div id="modalAcuerdoR" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-xl" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: auto; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Acuerdo Reparatorio</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalAcuerdoR" data-modal="modalHistory" data-thismodal="modalAcuerdoR" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyAcuerdoR">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalHistory" data-thismodal="modalAcuerdoR" id="btnCerrarModalAcuerdoR">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarAcuerdoR()" id="btnGuardarAcuerdoR">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  {{--  Modal Editar Acuerdo Reparatorio  --}}
  <div id="modalAcuerdoR_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-xl" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: auto; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Acuerdo Reparatorio</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalAcuerdoR_E" data-modal="modalHistory" data-thismodal="modalAcuerdoR_E" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyAcuerdoR_E">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal" data-modal="modalHistory" data-thismodal="modalAcuerdoR_E" id="btnCerrarModalAcuerdoR_E">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_AcuerdoR()" id="btnEditarAcuerdoR">Actualizar</button>
        </div>
      </div>
    </div>
  </div>


  {{--  // ########## MEDIDAS CAUTELARES##########  --}}
  {{--  Modal Agregar Medida Cautelar  --}}
  <div id="modalMedidasCautelares" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Medida Cautelar</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalMedidasCautelares" data-modal="modalHistory" data-thismodal="modalMedidasCautelares" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyMedidasCautelares">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalMedidasCautelares" data-modal="modalHistory" data-thismodal="modalMedidasCautelares"  id="btnCerrarModalMedidasCautelares">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarMedidaC()" id="saveMedidaCautelar">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  
  {{--  Modal Editar Medida Cautelar  --}}
  <div id="modalMedidasCautelares_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Medida Cautelar</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalMedidasCautelares_E" data-modal="modalHistory" data-thismodal="modalMedidasCautelares_E" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyMedidasCautelares_E">

        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalMedidasCautelares_E" data-modal="modalHistory" data-thismodal="modalMedidasCautelares_E"  id="btnCerrarModalMedidasCautelares_E">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_MedidaC()" id="saveMedidaCautelar_E">Actualizar</button>
        </div>
      </div>
    </div>
  </div>



  {{--  // ########## MEDIDAS PROTECCION ##########  --}}
  {{--  Modal Agregar Medida Proteccion  --}}
  <div id="modalMedidasProteccion" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nuevo Medida de Proteccion</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalMedidasProteccion" data-modal="modalHistory" data-thismodal="modalMedidasProteccion" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="boyMedidasProteccion">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalModalMedidasProteccion" data-modal="modalHistory" data-thismodal="modalMedidasProteccion"  id="btnCerrarModalMedidasProteccion">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarMedidaP()" id="saveMedidaProteccion">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  {{--  Modal Editar Medida Proteccion  --}}
  <div id="modalMedidasProteccion_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Medida Proteccion</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalMedidasProteccion_E" data-modal="modalHistory" data-thismodal="modalMedidasProteccion_E" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyMedidasProteccion_E">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalMedidasProteccion_E" data-modal="modalHistory" data-thismodal="modalMedidasProteccion_E"   id="btnCerrarModalMedidasProteccion_E">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_MedidaP()" id="saveMedidaProteccion_E">Actualizar</button>
        </div>
      </div>
    </div>
  </div>



  {{--  // ########## CONDICION DE PROCESOS ##########  --}}
  {{--  Modal Agregar condicion de proceso  --}}
  <div id="modalCondicionS" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Nueva Condicion de suspensión de proceso</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalModalCondicionS" data-modal="modalHistory" data-thismodal="modalCondicionS" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyCondicionS">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalModalCondicionS" data-modal="modalHistory" data-thismodal="modalCondicionS" id="btnCerrarModalModalCondicionS">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="guardarCondicionS()" id="saveCondicionS">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  {{--  Modal Editar Condicion de proceso  --}}
  <div id="modalCondicionS_E" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-dialog-xxl modal-lg" role="document">
      <div class="modal-content tx-size-sm" style="overflow-y: scroll; min-height: 800px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="#">Editar Condicion de suspensión de proceso</h6>
          <button type="button" class="close cerrar-modal btnCerrarModalCondicionS_E" data-modal="modalHistory" data-thismodal="modalCondicionS_E" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20" id="bodyCondicionS_E">
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10 cerrar-modal btnCerrarModalCondicionS_E" data-modal="modalHistory" data-thismodal="modalCondicionS_E"  id="btnCerrarModalCondicionS_E">Cerrar</button>
          <button type="button" class="btn btn-secondary pd-x-25 mg-l-10" style="background:#848F33 !important; color:#fff;" onclick="actualizar_CondicionS()" id="saveCondicionS_E">Actualizar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- M O D A L E S   V I D A     C A R P  E T A    J U D I C I A L  -->

  <div id="modalDetalle" class="modal fade" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-dialog-xxl modal-lg modal-dialog-vertical-center" role="document">
      <div class="modal-content bd-0 tx-14" style="overflow-y: scroll; min-height: 900px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-semibold mg-b-0 tx-uppercase"><span id="tituloModalDetalle"></span></h6>

          <button type="button" class="close cerrar-modal  btnCerrarDetalle" data-modal="modalAdministracion" data-thismodal="modalDetalle" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div> <!-- HEADER -->
        <div class="modal-body" style=" overflow-y: auto;">
          <div class="col-md-12">
            <nav>
              <div class="nav nav-tabs" id="nav-tab-info-doc" role="tablist">
                <a class="nav-item nav-link active" id="nav-documento_view-tab"  data-toggle="tab" href="#nav-documento_view" role="tab" aria-controls="nav-documento_view" aria-selected="true">Documento</a>
                <a class="nav-item nav-link"        id="nav-fracciones-tab"      data-toggle="tab" href="#nav-fracciones"     role="tab" aria-controls="nav-fracciones"     aria-selected="true">Fracciones</a>
              </div
            </nav>
          </div>

          <div class="tab-content" id="nav-tabContent-info-doc" style="width: 100%;">
            <div class="tab-pane fade show active" id="nav-documento_view" role="tabpanel" aria-labelledby="nav-documento_view-tab">
              <div id="bodyModalDetalle"></div>
            </div>
            <div class="tab-pane fade show" id="nav-fracciones" role="tabpanel" aria-labelledby="nav-fracciones-tab">
              <div class="row mg-t-20" id="fracciones_acuerdo_documento">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Victimas: </label>
                    <select name="" id="victimas_acuerdo" class="form-control" onchange="ConsultarFraccionAcu(this)">

                    </select>
                  </div>
                </div>
              </div>
              <div class="row" style="justify-content: center;">
                <div class="col-md-12 col-md-8 col-lg-8">
                  <div class="table-responsive">
                    <table id="fra_nes">
                      <thead>
                        <tr style="border: 1px solid #848f3363;">
                          <th style="padding:6px; text-align:center;"></th>
                          <th style="padding:6px; text-align:center;">Fracciones</th>
                          <th style="padding:6px; text-align:center;">Solicitadas</th>
                          <th style="padding:6px; text-align:center;">Acuerdo</th>
                        </tr>
                      </thead>
                      <tbody id="Fra_cciones">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>  <!-- BODY -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cerrar-modal btnCerrarDetalle" data-modal="modalAdministracion" data-thismodal="modalDetalle" id="btnCerrarDetalle">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalBorrarCJ" class="modal fade" data-keyboard="false">
    <div class="modal-dialog modal-dialog-vertical-center " role="document">
      <div class="modal-content bd-0 tx-14" style="overflow-y: scroll; min-height: 500px;">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalBorrarCJ"></h6>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_carpeta_borrar" id="id_carpeta_borrar">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Redireccionar a la unidad:</label>
                <select class="form-control select2" id="id_unidad_redireccion" name ="id_unidad_redireccion">
                  <option value="-" selected>Sin redireccionamiento, sólo borrar.</option>
                  @foreach( $ugas as $u )
                  <option value="{{$u['id_unidad_gestion']}}">{{$u['nombre_unidad']}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Motivos:</label>
                <textarea class="form-control" name="motivo_redireccion" id="motivo_redireccion" rows="4"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnBorrarCJ" onclick="borrarCarpetaJudicial()">Borrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
 
  
  <div id="modalCambiarJuezCJ" class="modal fade" data-keyboard="false">
    <div class="modal-dialog modal-dialog-medium" role="document">
      <div class="modal-content bd-0 tx-14">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloModalCambiarJuezCJ">Cambiar juez</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Juez:</label>
                <select class="form-control" id="id_juez_cambiar" name ="id_juez_cambiar">
                </select>
              </div>
            </div>
            <div class="col-lg-12">
              <label class="form-control-label"> Ingrese los motivos del porqué desea cambiar el juez:</label>
              <textarea class="form-control" name="motivoCambioJuez" id="motivoCambioJuez" rows="4"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnCambiarJuezCJ" onclick="">Cambiar Juez</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  {{-- modals remisiones --}}
  <div id="modalRemision" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm modalRemision-content">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="lbl-titulo-modal-remision"></span></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> <!-- HEADER -->
        <div class="modal-body pd-20">
          <form action="/" onsubmit="return false;" enctype="multipart/form-data" id="formRemision">
            <div class="row mg-b-25 " id="cuerpoRemision1"><!-- datos de solicitud de audiencia -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Remitir carpeta judicial:</label>
                  <select class="form-control select2" id="tipoRemision" name="tipo_remision" autocomplete="off" onchange="tipo_Remision()">
                    <option disabled value="" selected>Seleccione una opción</option>
                    <option value="incompetencia">Por Incompetencia</option>
                    @if (Session::get('id_unidad_gestion') != 34)
                      <option value="tribunal_enjuiciamiento">A Tribunal de Enjuiciamiento</option>
                      <option value="unidad_ejecucion">A Unidad de Ejecución</option>
                    @endif
                    <option value="ley_nacional">Reportar Unidad de Ejecución Prisión preventiva</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-8" align="center">
                <div class="form-group mg-t-30 d-none d-lg-block">
                  <h4 id="labelTipoRemision"></h4>
                </div>
              </div>
            </div>
            <hr>
            <div  style="background: #f8f9fa; padding: 10px; min-height: 470px; border: 1px solid #EEE; display: grid;" id="formularioRemision" class="mg-b-25"><!-- datos de solicitud de audiencia -->
            </div>
          </form>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <div style="display: contents">
            <button data-dismiss="modal" aria-label="Close" class="btn btn-secondary mg-r-auto">Cerrar</button>
            <button class="btn btn-primary mg-l-auto" onclick="remisionEjecAutorizacion()" id="btnSiguiente">Solicitar Autorización</button>
          </div>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <!-- M O D A L E S   P E R S O N A S    P R O C E S A L E S  N O   S E     U S A N  -->

  <div id="modalSentenciado" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Datos del sentenciado</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row mg-b-15">
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Nombre del sentenciado:<span class="tx-danger">*</span></label>
                <select class="form-control select2" id="imputados" name="imputados" autocomplete="off">
                </select>
              </div>
            </div>
          </div>
          <div class="row mg-b-15">
            <div class="col-md-5">
              <div class="form-group" id="">
                <label class="form-control-label">¿El sentenciado se encuentra en libertad?:
                  <span class="tx-danger">*</span></label>
                <div class="row pd-7">
                  <div class="col-6 col-md-4">
                    <label class="rdiobox d-inline-block mg-l-20">
                      <input name="sentenciado_libertad" type="radio" value="si" class="sentenciado_libertad" onchange="sentenciadoLibertad()">
                      <span class="pd-l-0">Sí</span>
                    </label>
                  </div>
                  <div class=" col-6 col-md-4">
                    <label class="rdiobox d-inline-block mg-l-20">
                      <input name="sentenciado_libertad" type="radio" value="no" class="sentenciado_libertad" onchange="sentenciadoLibertad()">
                      <span class="pd-l-0">No</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label class="form-control-label">Centro de detención: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="centroDetencion" name="centro_detencion" autocomplete="off">
                  <option value="" disabled selected>Seleccione una opción</option>
                  <option value="7">Reclusorio Preventivo Varonil Norte</option>
                  <option value="8">Reclusorio Preventivo Varonil Oriente</option>
                  <option value="9">Reclusorio Preventivo Varonil Sur</option>
                  <option value="10">Centro Femenil de Reinserción Social (Santa Martha)</option>
                  <option value="5">Dr. Lavista</option>
                  <option value="4">Sullivan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row mg-b-30">
            <div class="col-12">
              <div>
                <div class="d-flex">
                  <label for="table-remi" class="form-control-label">Penas impuestas en la sentencia:</label>
                  <a href="javascript:void(0)" onclick="nuevaPena()" class="mg-l-auto"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar pena</a>
                </div>
                <table class="table-remi" id="tablePenas">
                  <thead>
                    <tr>
                      <th class="acciones">Acciones</th>
                      <th class="suspension_condicional_pena d-none">S.C.E.P </th>
                      <th class="pena">Pena impuesta</th>
                      <th class="delitos">Deltilos</th>
                      <th class="detalles">Detalles adicionales</th>
                      <th class="sustitutivo">Sustitutivo para la pena</th>
                    </tr>
                  </thead>
                  <tbody id="bodyPenas">
                  </tbody>
                </table>
                <small>*S.C.E.P : SUSPENSIÓN CONDICIONAL DE LA EJECUCIÓN DE LA PENA</small>
              </div>
            </div>
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-9">
              <div class="form-group" id="">
                <label class="form-control-label">
                  ¿Se concede la SUSPENSIÓN CONDICIONAL DE LA EJECUCIÓN DE LA PENA?:
                  <span class="tx-danger">*</span></label>

                  <label class="rdiobox d-inline-block mg-l-15">
                    <input name="suspension_ejecucion" type="radio" value="si" class="suspension_ejecucion" onchange="suspensionCondicionalPena('si')">
                    <span class="pd-l-0">Sí</span>
                  </label>
                  <label class="rdiobox d-inline-block mg-l-15">
                    <input name="suspension_ejecucion" type="radio" value="no" class="suspension_ejecucion" onchange="suspensionCondicionalPena('no')">
                    <span class="pd-l-0">No</span>
                  </label>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="form-group d-none suspension_condicional_pena" id="divMontoGarantia" >
                <label class="form-control-label">Monto de la garantía:</label>
                <input class="form-control input-money" type="text" name="monto_garantia" id="montoGarantia" value="" autocomplete="off">
              </div>
            </div>
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarSentenciado()">Guardar sentenciado</button>
          <button type="button" class="btn btn-secondary" onclick="abreModal('modalRemision',300)" data-dismiss="modal" aria-label="Close">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalPenas" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Registrar pena</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="card">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#datosGenerales" data-toggle="tab" id="navDatosGenerales">Datos generales</a>
                </li>
                <li class="nav-item d-none" id="sectionAbonoPrision">
                  <a class="nav-link" href="#abonoPrision" data-toggle="tab">Abono de prisión preventiva</a>
                </li>
                <li class="nav-item d-none" id="sectionSustitutivosPena">
                  <a class="nav-link" href="#sutitutivosPena" data-toggle="tab">Sustitutivos de pena</a>
                </li>
              </ul>
            </div><!-- card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="datosGenerales">
                  <div class="row mg-b-10">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label">Tipo de pena:<span class="tx-danger">*</span></label>
                        <select class="form-control select2" id="tipoPena" name="tipo_pena" autocomplete="off" onchange="obtenerPenas()">
                          <option value="" disabled selected>Seleccione una opción</option>
                          @foreach ($penas as $pena)
                              <option value="{{$pena['id_tipo_pena']}}">{{$pena['descripcion']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <label class="form-control-label">Pena impuesta:<span class="tx-danger">*</span></label>
                        <select class="form-control" id="penaImpuesta" name="pena_impuesta" autocomplete="off" onchange="penaImpuesta()">
                          <option value="">Seleccione una opción</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-10 d-none" id="divDecomisos">
                    <div class="col-md-4">
                      <label class="ckbox">
                        <input type="checkbox" class="decomiso" id="decomisoInstrumento"><span>Decomiso de instrumento</span>
                      </label>
                    </div>
                    <div class="col-md-4">
                      <label class="ckbox">
                        <input type="checkbox" class="decomiso" id="decomisoObjetos"><span>Decomiso de objetos</span>
                      </label>
                    </div>
                    <div class="col-md-4">
                      <label class="ckbox">
                        <input type="checkbox" class="decomiso" id="decomisoProductos"><span>Decomiso de productos del delito</span>
                      </label>
                    </div>
                  </div>
                  <div class="row mg-b-10">
                    <div class="col-12">
                      <div class="form-group d-none" id="divDetallePena">
                        <label class="form-control-label">Detalle de la pena:<span class="tx-danger">*</span></label>
                        <select class="form-control" id="detallePena" name="detalle_pena" autocomplete="off">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-10 d-none" id="divPeriodo">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Años: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="periodo_anios" id="periodoAnios" autocomplete="off" oninput="calculoAbonoSentencia()" min="0" >
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Meses: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="periodo_meses" id="periodoMeses" value=""  placeholder="" autocomplete="off" oninput="calculoAbonoSentencia()" min="0">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Días: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="periodo_dias" id="periododias" value=""  placeholder="" autocomplete="off" oninput="calculoAbonoSentencia()" min="0">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" id="divCentroDetencionPena">
                        <label class="form-control-label">Centro de detención actual:<span class="tx-danger">*</span></label>
                        <select class="form-control" id="centroDetencionPena" name="centro_detencion_pena" autocomplete="off" >
                          <option value="" disabled selected>Seleccione una opción</option>

                          @foreach ($centros_detencion as $centro_detencion)
                              <option value="{{$centro_detencion['id_reclusorio']}}">{{$centro_detencion['nombre']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-10">
                    <div class="col-12">
                      <div class="form-group">
                        <label class="form-control-label">Detalles Adicionales:</label>
                        <textarea class="form-control" name="detalles_adicionales" id="detallesAdicionalesPena" rows="4"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-30">
                    <div class="col-12">
                      <div>
                        <div class="row">
                          <div class="col-6">
                            <label for="table-remi" class="form-control-label">Delitos por los cuales se impone al pena:</label>
                          </div>
                          <div class="col-6 text-right">
                            <a href="javascript:void(0)" onclick="nuevoDelito()" class=""><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar delito</a>
                          </div>
                        </div>
                        <table class="table-remi">
                          <thead>
                            <tr>
                              <th class="acciones">Acciones</th>
                              <th class="delito">Delitos</th>
                            </tr>
                          </thead>
                          <tbody id="bodyDelitos">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div><!-- tab-pane -->
                <div class="tab-pane" id="abonoPrision">
                  <div class="row mg-b-15">
                    <div class="col-12">
                      <a href="javascript:void(0)" onclick="nuevoAbono()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar cómputo</a>
                    </div>
                  </div>
                  <div class="row mg-b-15 d-none" id="divCentroDetencionAbono">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Años: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="abono_anios" id="abonoAnios" value="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Meses: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="abono_meses" id="abonoMeses" value="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Días: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="abono_dias" id="abonodias" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Centro de detención:<span class="tx-danger">*</span></label>
                        <select class="form-control select2-show-search" id="centroDetencionAbono" name="centro_detencion_abono" autocomplete="off" onchange="centroDetencionAbono()">
                          <option value="" selected disabled>Seleccione una opción</option>
                          <option value="otro">Otro</option>
                          @foreach ($centros_detencion as $centro_detencion)
                              <option value="{{$centro_detencion['id_reclusorio']}}">{{$centro_detencion['nombre']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Otro centro de detención:</label>
                        <input class="form-control" type="text" name="centro_detencion_abono_otro" id="centroDetencionAbonoOtro" value=""  placeholder="" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 28px">
                      <button type="button" class="btn btn-outline-primary" onclick="agregarAbono()">Agregar</button>
                      <button type="button" class="btn btn-outline-secondary"  onclick="cancelarAbono()">Cancelar</button>
                    </div>
                  </div>
                  <div class="row mg-b-30">
                    <div class="col-md-12">
                      <table class="table-remi d-block">
                        <thead>
                          <th class="acciones">Acciones</th>
                          <th class="anios_abono">Años</th>
                          <th class="meses_abono">Meses</th>
                          <th class="dias_abono">Días</th>
                          <th class="centro_abono">Centro de detención</th>
                          <th class="otro_centro_abono">Otro centro de detención</th>
                        </thead>
                        <tbody id="bodyAbonos"></tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <p style="font-weight: bold">Total de abono de prisión preventiva:</p>
                    </div>
                    <div class="col-md-4">
                      <p><span id="abonoAniosTotal">0</span> años, <span id="abonoMesesTotal">0</span> meses, <span id="abonoDiasTotal">0</span> días</p>
                    </div>
                  </div>
                  <div class="row mg-b-15">
                    <div class="col-md-4">
                      <p style="font-weight: bold">Total de sentencia por cumplir:</p>
                    </div>
                    <div class="col-md-4">
                      <p><span id="aniosTotalCumplir">0</span> años, <span id="mesesTotalCumplir">0</span> meses, <span id="diasTotalCumplir">0</span> días</p>
                    </div>
                  </div>
                </div><!-- tab-pane -->
                <div class="tab-pane" id="sutitutivosPena">
                  <div class="row mg-b-15">
                    <div class="col-12">
                      <a href="javascript:void(0)" onclick="nuevoSustitutivo()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar sustitutivo</a>
                    </div>
                  </div>
                  <div id="sistitutivoNuevo" class="d-none">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label">Sustitutivo:<span class="tx-danger">*</span></label>
                          <select class="form-control select2-show-search" id="sustitutivo" name="sustitutivo" autocomplete="off" onchange="sustitutivo()">
                            <option value="" selected>Seleccione una opción</option>
                            <option value="1" >Multa en beneficio de la víctima</option>
                            <option value="2" >Multa en favor de la comunidad</option>
                            <option value="3" >Trabajo en beneficio de la víctima</option>
                            <option value="4" >Trabajo en favor de la comunidad</option>
                            <option value="5" >Tratamiento en libertad</option>
                            <option value="6" >Tratamiento en semilibertad</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group d-none" id="divMonto">
                          <label class="form-control-label">Monto:</label>
                          <input class="form-control input-money" type="text" name="monto_sustitutivo" id="montoSustitutivo" value="" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-15">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label">¿Se acoge al sustitutivo?<span class="tx-danger">*</span></label>
                          <div class="d-inline-block mg-l-5 mg-t-10" id="divMateriaDestino">
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="acoge_sustitutivo" type="radio" value="si" class="acoge_sustitutivo_val">
                              <span class="pd-l-0">Si</span>
                            </label>
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="acoge_sustitutivo" type="radio" value="no" class="acoge_sustitutivo_val">
                              <span class="pd-l-0">no</span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-15">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label">Detalles adicionales:</label>
                          <textarea class="form-control" name="detalles_adicionales_sustitutivo" id="detallesAdicionalesSustitutivo" rows="4"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-20">
                      <div class="col-12 d-flex">
                        <button type="button" class="btn btn-outline-primary mg-l-auto" onclick="agregarSustitutivo()">Guardar</button>
                        <button type="button" class="btn btn-outline-secondary mg-l-10" onclick="cancelarSustitutivo()">Cancelar</button>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-30">
                    <div class="col-12">
                      <table class="table-remi d-block d-md-table">
                        <thead>
                          <th class="acciones">Acciones</th>
                          <th class="sustitutivo">Sustitutivo</th>
                          <th class="monto_sustitutivo">Monto</th>
                          <th class="acoge_sustitutivo">Se acoge al sustitutivo</th>
                          <th class="detalles_adicionales_sustitutivo">Detalles adicionales</th>
                        </thead>
                        <tbody id="bodySustitutivos"></tbody>
                      </table>
                    </div>
                  </div>
                </div><!-- tab-pane -->
              </div><!-- tab-content -->
            </div><!-- card-body -->
          </div><!-- card -->
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarPena()">Guardar pena</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalSentenciado',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDelitos" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar delito</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row mg-b-10">
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Delito a agregar:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="delitoPena" name="delitoPena" autocomplete="off">
                </select>
              </div>
            </div>
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarDelito()">Guardar delito</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalPenas',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDefensor" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar defensor</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row mg-b-10">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-control-label">Tipo de presona:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="tipoPersonaDefensor" name="tipo_persona_defensor" autocomplete="off">
                  <option value="" selected disabled>Seleccione una opción</option>
                  <option value="fisica">Física</option>
                  <option value="moral">Moral</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 fisica">
              <div class="form-group">
                <label class="form-control-label">Nacionalidad:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="nacionalidadDefensor" name="nacionalidad_defensor" autocomplete="off">
                  <option value="" selected disabled>Seleccione una opción</option>
                  <option value="mexicana">Mexicana</option>
                  <option value="extranjero">Extranjero</option>
                  <option value="mexicana_otro">Mexicana/Otra</option>
                  <option value="no_especificada">No especificada</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 fisica">
              <div class="form-group">
                <label class="form-control-label">Indique la Nacionalidad: </label>
                <select class="form-control " id="otraNacionalidadDefensor" name="otra_nacionalidad_defensor" autocomplete="off" disabled>
                    <option selected  value="" disabled>Elija una opción</option>
                    @foreach ($nacionalidades as $nacionalidad)
                          <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option>
                    @endforeach
                </select>
              </div>
            </div><!-- col-6-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Nombre(s): <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="nombre_defensor" id="nombreDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="apellido_paterno_defensor" id="apellidoPaternoDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Materno:</label>
                <input class="form-control" type="text" name="apellido_materno_defensor" id="apellidoMaternoDefensor" autocomplete="off">
              </div>
            </div><!-- col-4-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Genero: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="generoDefensor" name="genero_defensor" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="masculino">MASCULINO</option>
                    <option value="femenino">FEMENINO</option>
                    <option value="indeterminado">INDETERMINADO</option>
                </select>
              </div>
            </div><!-- col-4-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Fecha de Nacimiento: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaNacimientoDefensor" name="fecha_nacimiento_defensor" autocomplete="off">
                </div>
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-3 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Edad:</label>
                <input class="form-control input-number" type="text" name="edad_defensor" id="edadDefensor" autocomplete="off">
              </div>
            </div><!-- col-4-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Estado Civil: </label>
                <select class="form-control select2" id="estadoCivilDefensor" name="estado_civil_defensor" autocomplete="off">
                    <option selected   value="">Elija una opción</option>
                    @foreach ($estado_civil as $estado)
                        <option value="{{$estado['id_estado_civil']}}">{{$estado['estado_civil']}}</option>
                    @endforeach
                </select>
              </div>
            </div><!-- col-4-->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">CURP:</label>
                <input class="form-control" type="text" name="curp_defensor" id="curpDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-8 moral d-none">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Razón Social:</label>
                <input class="form-control" type="text" name="razon_social_defensor" id="razonSocialDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 moral d-none">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">RFC:</label>
                <input class="form-control" type="text" name="rfc_defensor" id="rfcDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarNuevoDefensor()">Agregar delito</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalPenas',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDocumento" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-inverse tx-bold" id="nombreDocumento"></h6>
        </div>
        <div class="modal-body pd-20" id="objectDocumento">
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalRemision',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection