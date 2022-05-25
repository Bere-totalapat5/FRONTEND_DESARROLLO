@php
  use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

{{-- Header --}}
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">Reportes</a></li>
     <li class="breadcrumb-item"><a href="javascript:void(0);"> Reporte libertades</a></li>
  </ol>
  <h6 class="slim-pagetitle">  Reporte de Libertades</h6>
@endsection
{{-- Estilos --}}
@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>

      #tableRMReg tr.noSearch {background:White;}
      #tableRMReg tr.noSearch td {padding-top:10px}
      .hide {display:none;}

      .button_saved_all,
      .button_delete_all{
        position: absolute;
        cursor: pointer;
      }
      .button_saved_all{
        left: 0;
        color: #27AE60;
      }
      .button_delete_all{
        left: 7%;
        color: #F1948A;
      }
      .button_delete{
        color: #F1948A;
        cursor: pointer;
        font-size: 1.3em;
        position: absolute;
        right: 1%;
      }
      .button_saved{
        color: #27AE60;
        cursor: pointer;
        font-size: 1.3em;
        position: absolute;
        right: 9%;
      }
      .button_cerrar_globito{
        position: absolute;
        right: 3%;
        top: 3px;
        color: #bbb;
        background: #eee;
        border-radius: 50%;
        height: 15px;
        width: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.9em;
        text-align: center;
        cursor: pointer;
      }
      #titulo_globito{
        padding: 4px;
        text-align: center;
        border-bottom: 2px solid #848f33;
        margin-bottom: 3%; 
        position: relative;
      }
      @media(max-width:1024px){
        #button_mot_res{
          right: -4.7% !important;
        }
      }
      @media(max-width:800px){
        #globito{
          width: 50% !important; 
          right: 0% !important; 
        }
        #button_mot_res{
          right: -5.7% !important;
        }
      }
      @media(max-width:500px){
        #globito{
          width: 80% !important; 
          right: 0% !important; 
        }
        #button_mot_res{
          right: -3.7% !important;
        }
      }
      #globito{
        width:28%; 
        position: absolute; 
        top: 0%; 
        display:none; 
        right: 0%; 
        background: #fff; 
        padding: 10px; 
        box-shadow: 1px 1px 20px -3px #ccc;
      }
      #body_globito::-webkit-scrollbar {
          width: 8px;
          height: 9px;     
      }
      #body_globito::-webkit-scrollbar-thumb {
          background: #ccc;
          border-radius: 4px;
      }
      #body_globito::-webkit-scrollbar-thumb:hover {
          background: #b3b3b3;
          box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
      }
      #body_globito::-webkit-scrollbar-thumb:active {
          background-color: #999999;
      }
      #body_globito::-webkit-scrollbar-track {
          background: #e1e1e1;
          border-radius: 4px;
      }
      #body_globito::-webkit-scrollbar-track:hover,
      #body_globito::-webkit-scrollbar-track:active {
        background: #d4d4d4;
      }

      #body_globito{
        padding: 4px 10px;
        max-height: 560px;
        overflow-y: auto;
      }
      .title_carpeta{
        padding: 4px;
        font-size: 0.9em;
        border: 1px solid #eee;
        font-weight: bold;
        color: #aaa;
      }
      #button_mot_res{
        position: absolute;
        top: 5%;
        right: -2.7%;
        border: 1pxsolid #ccc;
        width: 33px;
        height: 28px;
        background: #848F33;
        color: #fff;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      #button_mot_res:active{
        transform: scale(0.95);
      }
      #libertadesTable{
        font-size: 1em;
      }
      .bot{
        width:50%; 
        color:#fff; 
        background:#848F33 !important; 
        border-color:#848F33 !important; 
        padding:4px !important;
      }
      @media(max-width: 770px){
        .bot{
            width: 100% !important;
            border-color:#848F33 !important;
        }
      }
      #accordion .card{
          border:none !important;
      }
      #accordion .card .card-header{
        width: 75px !important;
        border: 1px solid #dee2e6 !important;
      }
      #accordion .card .card-header a{
        padding: 10px !important;
      }
      #collapseSearchAdvance{
        border: 1px solid #eee !important;
        background: #f8f9fa;
      }
      #accordion a::before{
        top: 10px !important;
      }
      .select2-container.select2-container--default.select2-container--open{
          z-index: 1050 !important;
      }
      .page-link{
          border:none !important;
      }
      #cmp_clave{
        position: relative;
      }
      #cmp_clave i{
        position: absolute;
        top: 30%;
        right: 6%;
        cursor: pointer;
      }
      #alertaVacio{
        display: none;
        color: #E74C3C;
        font-size: 0.9em;
      }
      .odd {
        text-align: center !important;
     }
     .even {
        text-align: center !important;
     }
      table{
          width: calc(100% - 2px) !important;
          border-bottom: 1px solid #f0f2f7;
      }
      th{
          padding-left: 1px !important;
          padding-right: 3px !important;
          padding-top: 0px;
          padding-bottom:8px !important;
          border-bottom: 1px solid #f0f2f7;
          max-width: 110px !important;
      }
      td{
        padding: 0 !important;
      }
      .lds-roller {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
      }
      .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 40px 40px;
      }
      .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #fff;
        margin: -4px 0 0 -4px;
      }
      .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
      }
      .lds-roller div:nth-child(1):after {
        top: 63px;
        left: 63px;
      }
      .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
      }
      .lds-roller div:nth-child(2):after {
        top: 68px;
        left: 56px;
      }
      .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
      }
      .lds-roller div:nth-child(3):after {
        top: 71px;
        left: 48px;
      }
      .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
      }
      .lds-roller div:nth-child(4):after {
        top: 72px;
        left: 40px;
      }
      .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
      }
      .lds-roller div:nth-child(5):after {
        top: 71px;
        left: 32px;
      }
      .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
      }
      .lds-roller div:nth-child(6):after {
        top: 68px;
        left: 24px;
      }
      .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
      }
      .lds-roller div:nth-child(7):after {
        top: 63px;
        left: 17px;
      }
      .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
      }
      .lds-roller div:nth-child(8):after {
        top: 56px;
        left: 12px;
      }
      @keyframes lds-roller {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
      
      .con_altura::-webkit-scrollbar {
          width: 8px;
          height: 9px;     
      }
      .con_altura::-webkit-scrollbar-thumb {
          background: #ccc;
          border-radius: 4px;
      }
      .con_altura::-webkit-scrollbar-thumb:hover {
          background: #b3b3b3;
          box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
      }
      .con_altura::-webkit-scrollbar-thumb:active {
          background-color: #999999;
      }
      .con_altura::-webkit-scrollbar-track {
          background: #e1e1e1;
          border-radius: 4px;
      }
    
      .con_altura::-webkit-scrollbar-track:hover,
      .con_altura::-webkit-scrollbar-track:active {
        background: #d4d4d4;
      }
      #libertadesTable tr td{
        display: table-cell;
        vertical-align: middle;
      }
      
      #libertadesTable::-webkit-scrollbar {
          width: 8px;
          height: 9px;     
      }
      #libertadesTable::-webkit-scrollbar-thumb {
          background: #ccc;
          border-radius: 4px;
      }
      #libertadesTable::-webkit-scrollbar-thumb:hover {
          background: #b3b3b3;
          box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
      }
      #libertadesTable::-webkit-scrollbar-thumb:active {
          background-color: #999999;
      }
      #libertadesTable::-webkit-scrollbar-track {
          background: #e1e1e1;
          border-radius: 4px;
      }
    
      #libertadesTable::-webkit-scrollbar-track:hover,
      #libertadesTable::-webkit-scrollbar-track:active {
        background: #d4d4d4;
      }  
      
      
      #datos_adicionales::-webkit-scrollbar {
          width: 8px;
          height: 9px;     
      }
      #datos_adicionales::-webkit-scrollbar-thumb {
          background: #ccc;
          border-radius: 4px;
      }
      #datos_adicionales::-webkit-scrollbar-thumb:hover {
          background: #b3b3b3;
          box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
      }
      #datos_adicionales::-webkit-scrollbar-thumb:active {
          background-color: #999999;
      }
      #datos_adicionales::-webkit-scrollbar-track {
          background: #e1e1e1;
          border-radius: 4px;
      }
    
      #datos_adicionales::-webkit-scrollbar-track:hover,
      #datos_adicionales::-webkit-scrollbar-track:active {
        background: #d4d4d4;
      }  
      .editable{
        width: 100%;
        padding: 8px;
        text-align: center;
        border: none;
        background: #efefef;
        border-radius: 3px;      
      }
      .editable1{
        width: 100%;
        padding: 8px;
        text-align: center;
        border: none;
        font-size: 0.8em;
      }
      .boton_agregar_add{
        cursor: pointer;
      }
      .boton_agregar_add:active{
        transform: scale(0.95);
      }
      .boton_quitar_remove{
        color: #CB4335;
        cursor: pointer;
      }
      .boton_quitar_remove:active{
        transform: scale(0.95);
      }
      .multiselect{
        width: 100% !important;
        background: #fff;
      }
      td > div.btn-group{
        width: 100%;
      }
      .multiselect-selected-text{
        font-size: 0.83em;
      }
      ul.multiselect-container{
        font-size: 0.74em !important;
        width: 139% !important;
        height: 100px !important;
        overflow: auto;
      }
      ul.multiselect-container>li>a>label{
        height: 0 !important;
      }
      .clearfix{
        clear: both;
        content: '';
      }
      .expadir{
        width: 303px !important;
        transition: width 3ms ease-in-out;
      }
      .eliminar{
        width: 20px;
        text-align: center;
        float: left;
        font-size: 0.84em;
        height: 27px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-left: 1px solid #ccc;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        padding: 2px 4px;
      }
      .datos_libertad{
        width: calc(100% - 20px);
        float: left;
        display: flex;
        justify-content: space-around;
        border-right: 1px solid #ccc;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        padding: 2px 4px 2px 0px;
      }
      .libertad_reg{
        min-width: 300px;         
      }
      .responsive_tabla_libertades{
        width:calc(100% - 303px) !important;
      }
      @media(max-width: 700px){
        .responsive_tabla_libertades{
          width: 100% !important;
        }
        .expadir{
          min-width: 100% !important;
          margin: 2% 0;         
        }
      }
      .searchboxtype{
        width: 100%;
        border: none;
        border: 1px solid #ccc;
        border-radius: 3px;
        background: #fff;
        text-align: center;
        color: rgb(100, 100, 100);
        padding: 6px;
      }
      .searchboxtype:focus{
        outline: none;
      }
      #libertadesTable_filter{
        display: none;
      }
    </style>
@endsection

{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">

          {{-- //Botones de descarga --}}
          <div class="d-flex justify-content-between" style="align-items: center;">
              <a style="border:1px solid #ccc; width: 70px; height: 45px;" data-toggle="collapse" data-parent="#accordion"
                  href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance"
                  class="btn btn-default">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <i class="fas fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i>
              </a>
              <div class="row justify-content-end" style="width:80%;">
                  <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">
                  {{-- <div class="col-sm-6 col-md-6 col-lg-8 pd-t-3" aling="left">
                    <input type="text" class="searchboxtype" value="" id="searchboxtype" placeholder="Busqueda en tabla libertades" autocomplete="off"/>
                  </div>  --}}
                  <div class="col-sm-4 col-md-4 col-lg-3 pd-t-10" aling="right">
                      <button onclick="descargar_r_libertades();" id="exportxls" class="btn btn-primary btn-sm btn-block " title="Exportar excel"><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</button>
                  </div>
                  <div class="col-sm-2 col-md-2 col-lg-2 pd-t-10" aling="right">
                    <button onclick="sec_ajax('primera')" id="exportxls" style="padding: 4px 0;" class="btn btn-primary btn-sm btn-block " title="Refrescar Tabla"><i class="fas fa-sync-alt mg-r-5"></i></button>
                  </div>
              </div>
          </div>

          {{-- //Filtros --}}
          <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
              <div class="card">
                  {{-- <div class="card-header" role="tab" id="headingOne">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                  Búsqueda Avanzada
                  </a>
              </div><!-- card-header --> --}}

                  <div id="collapseSearchAdvance" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="card-body">
                          <form class="row mg-b-25" autocomplete="off">

                              {{-- <div class="col-lg-4">
                                  <label class="form-control-label">Unidad de Gestion:</label>
                                  <div class="form-group">
                                      <select class="form-control-lg select2 valid" width='100%' autocomplete="off" name="idunidad" id="idunidad"></select>
                                  </div>
                              </div> --}}
                            
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="label">Fecha inicio (Desde): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker date" placeholder="DD-MM-AAAA" id="fechaini" name="" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="label">Fecha fin (Hasta): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker date" placeholder="DD-MM-AAAA" id="fechafin" name="" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                              <div class="form-group">
                                <label class="label">Carpeta Judicial: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                          <i class="far fa-folder-open tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="searhfor" tipo="cj" placeholder="Carpeta Judicial" name="" autocomplete="off">
                                </div>
                              </div>
                            </div>

                          </form><!-- row -->
                          <div class="row">
                              <div class="col-lg-12">
                                  <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10"
                                      data-toggle="collapse" data-target="#demo" onclick="sec_ajax('primera');">Filtrar</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          {{-- <!-- pagination-wrapper -->
          <div class="pagination-wrapper justify-content-between mg-b-20">
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
          </div> --}}


          <div class="card"> 
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#LibertadesTab" data-toggle="tab">Libertades</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#MotivoResumenTab" data-toggle="tab">Motivo y resumen</a>
                </li>
              </ul>
            </div> 
            
            <div class="card-body">
              <div class="tab-content">

                <div class="tab-pane active" id="LibertadesTab">
                  <div id="table-libertades" class="mg-b-20">
                    <table id="libertadesTable" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                        <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                            <tr>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 80px  !important;" name="unidad_gestion">Unidad</th>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 300px !important;" name="carpeta_investigacion">Carpetas</th>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 150px !important;" name="fecha_audiencia">Fecha</th>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 260px !important;" name="tipo_audiencia">Tipo de Audiencia</th>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 255px !important;" name="juez">Juez</th>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 480px  !important;" name="imputados">Imputados</th>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 300px !important;" name="delitos">Delitos</th>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 210px  !important;" name="mp">Ministerio Publico</th>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 210px !important;" name="asesor">Asesor Juridico</th>
                                <th style="cursor:pointer; font-size: 0.84em; min-width: 210px !important;" name="defensa">Defensa</th>
                            </tr>
                        </thead>
                        <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center; font-size: 0.84em;">
                        </tbody>
                    </table>
                  </div>

                  <div id="globito" class="globito">
                    <div id="titulo_globito">
                      <span class="button_saved_all" onclick="guardarMotivoResumenTodo()" title="Guardar Todo"><i class="far fa-save"></i></span>
                      {{--  <span class="button_delete_all" onclick="removerMotivoResumen('todos')" title="Cancelar Todo"><i class="fas fa-eraser"></i></span>  --}}
                      Motivos y Resumen 
                      <span class="button_cerrar_globito" onclick="mostrarTabMotivoResumen()">x</span>
                    </div>
                    <div class="row" id="body_globito" style="padding: 4px 10px;">
                      <div class="col-md-12 sin_imputados" style="width: 100%; background:#eee; text-align:center; padding:4px;">
                        Seleccione Imputados
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane" id="MotivoResumenTab">
                  <form class="row justify-content-center" autocomplete="off">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" onkeyup="doSearch()" placeholder="Buscar dentro de la tabla visible" id="serchaBar" name="" autocomplete="off">
                        </div>
                      </div>
                    </div>
                  </form>
                  <div class="table-responsive" style="max-height:400px;">
                    <table class="table mg-b-20" style="text-align: center;font-size: 0.9em;" id="tableRMReg">
                      <thead>
                        <tr>
                          <th style="font-size: 0.9em; text-align:center;">Unidad</th>
                          <th style="font-size: 0.9em; text-align:center;">Imputado</th>
                          <th style="font-size: 0.9em; text-align:center;">Resumen</th>
                          <th style="font-size: 0.9em; text-align:center;">Motivo</th>
                          <th style="font-size: 0.9em; text-align:center;">Carpetas</th>
                          <th style="font-size: 0.9em; text-align:center;">Fecha</th>
                          <th style="font-size: 0.9em; text-align:center;">Tipo Audiencia</th>
                        </tr>
                      </thead>
                      <tbody id="motivo_resumenTbody">
                        <tr>
                          <td colspan="7" style="font-weight: bold; padding:7px !important;">Sin referencia de datos</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- pagination-wrapper -->
          <div class="pagination-wrapper justify-content-between mg-t-20">
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

          <div class="row mt-4 mb-2" style="display:flex; justify-content: space-between; padding: 0 17px;">
            <h5 style="font-size:1.44em;">Libertades adicionales</h5>
            <div class="btn-group">
              <button onclick="addRow()" style="background:#848F33; border:1px solid #848F33; padding:8px; font-size:0.9em; border-radius:6px; margin:0 2%;" class="btn btn-success" ><i class="fas fa-plus-circle boton_agregar_add" title="Agregar filas"></i></button>
              <button onclick="verLibertades(this)" id="raf" data-open="0" style="background:#848F33; border:1px solid #848F33; padding:8px; font-size:0.9em; border-radius:6px; margin:0 2%;" class="btn btn-success" ><i class="far fa-list-alt" title="Ver Libertades"></i></button>  
              <button onclick="guardar_info_addi()" style="background:#848F33; border:1px solid #848F33; padding:8px; font-size:0.9em; border-radius:6px; margin:0 2%;" class="btn btn-success" ><i class="far fa-save" style="margin-right: 2%;" title="Guardar"></i></button>  
            </div>
          </div>
          
          <div class="row">
            <div id="datos_adicionales" style="width:100%; overflow:auto; padding: 2% auto; float:left;">
              <table style="border: 1px solid #ccc; margin:6px 0 50px 0;" id="Datos_add_table">
                <thead>
                  <tr style="font-size:0.8em; background: #f3f3f3;">
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:50px;"></th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:100px;">Unidad</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:160px;">Carpeta Judicial</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:300px;">Carpeta de Investigacion</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:100px;">Fecha</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:260px;">Juez</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:260px;">Victimas</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:260px;">Imputados</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:300px;">Delitos</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:260px;">Ministerio Publico</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:300px;">Asesor Juridico</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:300px;">Defensa</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:170px;">Motivo de libertad</th>
                    <th style="display:table-cell; vertical-align: middle; text-align:center; height: 36px; padding: 0 !important; min-width:170px;">Breve Resumen</th>
                  </tr>
                </thead>
                <tbody id="datos_add">
                  
                </tbody>
              </table>
              <div id="mensaje_datos" style="text-align: center; font-size: 1.1em; font-weight: bold; margin: -1% auto 2% auto; color: #bdbdbd;">No existen datos agregados</div>
            </div>
            <div class="ver_libertades" id="ver_libertades" style="width: 0%; border:1px solid #ccc; float: right; overflow:auto;">
            </div>
            <div class="clearfix"></div>
          </div>

        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

    </div>
@endsection

{{-- Scripts librerias --}}
@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
@endsection

{{-- Scripts --}}
@section('seccion-scripts-functions')
  <script>

    var idf_unidad_ge = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;
    var clave = '';
    var combo_unidades = '';
    console.log(idf_unidad_ge);

    var imputadosARR = [];
    var indices = [];

    switch(idf_unidad_ge){
      case 12:
        clave = '001';
        break;
      case 13:
        clave = '002';
        break;
      case 14:
        clave = '003';
        break;
      case 15:
        clave = '004';
        break;
      case 16:
        clave = '005';
        break;
      case 17:
        clave = '006';
        break;
      case 18:
        clave = '007';
        break;
      case 19:
        clave = '008';
        break;
      case 32:
        clave = '209';
        break;
      case 31:
        clave = '010';
        break;
      case 30:
        clave = '011';
        break;
      case 34:
        clave = '012';
        break;
      case 33:
        clave = '301';
        break;
    }

    $(function(){
        //select
        $('.date').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          dateFormat: 'yyyy-mm-dd'
        });

        //Loader
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 1000);

        $.ajax({
            type: 'POST',
            url: '/public/obtener_unidades',
            data: {

            },

            success: function(response) {

                console.log(response);

                if (response.status == 100) {
                    let unidades = response.response;
                    combo_unidades = unidades;
                    var option = '';
                    for(i = 0; i<unidades.length; i++){
                      var option = option + `<option value="${unidades[i].id_unidad_gestion}"> ${unidades[i].nombre_unidad} </option>`;
                    }

                    $('#idunidad').html(`<option selected disabled value="">Elija una opción</option> <option value=""> TODAS LAS UNIDADES </option>` + option);
                }
            }
        });

        sec_ajax();

        setTimeout(function(){
          $('#libertadesTable').append(`<div  id="button_mot_res" onclick="mostrarTabMotivoResumen()">
            <i class="fas fa-bars"></i>
          </div>`);
        },1000);

        hScroll(60);

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          sec_ajax();
        });

    });

    //desaparecer un elemento pulsando en cualquier lado de la pantalla
    $(document).on("click",function(e) {
                    
      var container = $("#raf");
                         
         if (!container.is(e.target) && container.has(e.target).length === 0) { 
          $('#ver_libertades').removeClass('expadir');
          $('#datos_adicionales').removeClass('responsive_tabla_libertades');
          $('#ver_libertades').html('');
          $("#raf").attr('data-open', 0);  
         }
    });

    //Aqui las function
    function descargar_r_libertades(){
      var inicio = get_date($('#fechaini').val());
      var final = get_date($('#fechafin').val());
      var clave_unidad = clave;

      $.ajax({
        type:'POST',
        url:'/public/descargar_r_libertades',
        data:{
          fecha_inicio: inicio,
          fecha_final:final,
          unidad_gestion: idf_unidad_ge,
        },
        beforeSend: function(){
          $('#exportxls').html('Consultando...');
          $('#exportxls').prop('disabled', true);
          loading(true);
        },
        success:function(response) {
            console.log(response);
          
            if(response.status==100){
              $('#exportxls').html('Exportar Excel');
              window.open(response.response);
              $('#exportxls').prop('disabled', false);
              loading(false);
            }else{
                error(response.message);
                $('#exportxls').html('Exportar Excel');
                loading(false);
            }
          
        }
      }); 
      
    }

    function sec_ajax(pagina_accion) {
      
      imputadosARR.length = 0;
      indices.length = 0;

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

          //cambio formato de fecha
          /*
            const format1 = "YYYY-DD-MM";

            var date1 = new Date($("#fechaini").val());
            var fechaini = moment(date1).format(format1);

            if (fechaini === "Invalid date") {
                fechaini = '';
            }

            var date2 = new Date($("#fechafin").val());
            fechafin = moment(date2).format(format1);

            if (fechafin === "Invalid date") {
                fechafin = '';
            }
          */

          var fechaini = get_date($("#fechaini").val());
          var fechafin = get_date($("#fechafin").val());
          var searhfor = '';
          if($('#searhfor').length > 0){searhfor =  $('#searhfor').val().trim()};
          
          //console.log(searhfor)
          //console.log(fechaini)
          //console.log(fechafin)
          
          $('#body_globito').html(`<div class="col-md-12 sin_imputados" style="width: 100%; background:#eee; text-align:center; padding:4px;">
            Seleccione Imputados
          </div>`);

          $.ajax({
              type: 'POST',
              url: '/public/ver_reporte_libertades',
              data: {
                  id_unidad_gestion: idf_unidad_ge,
                  fecha_ini: fechaini,
                  fecha_fin: fechafin,
                  searhfor : searhfor,
                  pagina: $('#numeropagina').val(),
                  registros_por_pagina: 8,
              },
              success: function(response) {
                console.log(response);
                  if (response.status == 100) {
                      var datos = response.response;

                      console.log('datos',datos);
                      /*
                      var body = $('#libertadesTable').DataTable({
                          processing: true,
                          data: datos,
                          responsive: false,
                          columns: [
                              {   data: "unidad_gestion",
                                  "render": function(data, type, row, meta) {
                                    texto = data;

                                    if(data == '209'){texto="009"}//209
                                    if(data == '301'){texto="UGJJA"}//Adolescentes
                                    
                                    return texto;
                                  }
                              },
                              {   data: "carpeta_investigacion",
                                  "render": function (data, type, row, meta){
                                    var celda = `<div style="padding: 2px; width: 100%;">
                                      <div style="padding-left:4px; text-align:left; border-left:2px solid #848F33; margin: 1.5% auto 4% auto; width:90%;"><span style="font-weight:bold !important; color:#848484 !important; font-size:0.9em;">Carpeta Judicial:</span>  ${row.carpeta_judicial}</div>
                                      <div style="padding-left:4px; text-align:left; border-left:2px solid #848F33; margin: 2% auto 1.5% auto; width:90%;">
                                        <div style="font-weight:bold !important; color:#848484 !important; margin-bottom:1%; font-size:0.9em;">Carpeta de Investigacion: </div>
                                        <div style="font-size:0.85em;">${data}</div>
                                      </div>
                                    </div>`;
                                    return celda;
                                  }
                              },
                              {   data: "fecha"
                              },
                              {   data: "tipo_audiencia"
                              },
                              {   data: "jueces[]"
                              },
                              {   data: "imputados",
                                  "render": function(data, type, row, meta) {
                                    

                                    return personas_z;      
                                  }
                              },
                              {   data: "delitos",
                                  "render": function (data, type, row, meta){
                                    let lista = '';
                                    if(data.length > 0){
                                      lista = '<ul style="font-size:0.9em; list-style:none;">';
                                      
                                      for(i = 0; i < data.length; i++){
                                        lista +=`<li style="border-left: 2px solid #848f33; padding-left:2%;">${data[i]}</li>`; 
                                      }
                                    
                                      lista += '</ul>';
                                    
                                      return lista;
                                    }else{
                                      return 'N/A';
                                    }
                                  } 
                              },
                              {   data: "mp",
                                  "render": function(data, type,row, meta){
                                    if(data.length > 0){
                                      return data;
                                    }else{
                                      return 'N/A';
                                    }
                                  }
                              },
                              {   data: "asesores[]",
                                  "render": function(data, type,row, meta){
                                    if(data.length > 0){
                                      return data;
                                    }else{
                                      return 'N/A';
                                    }
                                  }
                              },
                              {   data: "defensores",
                                  "render": function(data, type,row, meta){
                                    if(data.length > 0){
                                      return data;
                                    }else{
                                      return 'N/A';
                                    }
                                  }
                              }
                          ],

                        columnDefs: [
                            { orderable: false, targets: 0 }
                        ],
                        bDestroy: true,
                        colReset:true,
                        paging:   false,
                        ordering: true,
                        info:     false,
                        search: true,
                        filter: true,
                        stateSave: true
                      });
                      */

                      var tableLib = '';
                      var indice = 0;
                      for(i=0; i < datos.length; i++){

                        //Unidad
                        let texto = datos[i].clave_unidad;
                        if(datos[i].clave_unidad == '209'){texto="009"}//209
                        if(datos[i].clave_unidad == '301'){texto="UGJJA"}//Adolescentes

                        //Delitos
                        let delitos = '<ul class="con_altura" style="font-size:0.9em; list-style:none; max-height: 110px; overflow: auto;  ">';
                        if(datos[i].delitos.length > 0){
                          for(j = 0; j < datos[i].delitos.length; j++){
                            delitos +=`<li style="border-left: 2px solid #848f33; padding-left:2%;">${datos[i].delitos[j]}</li>`; 
                          }                        
                          delitos += '</ul>';
                        }else{
                          delitos = 'N/A';
                        }

                        let mp = '<ul style="font-size:0.9em; list-style:none;">';
                        if(datos[i].mp.length > 0){
                          for(j = 0; j < datos[i].mp.length; j++){
                            mp +=`<li style="border-left: 2px solid #848f33; padding-left:2%;">${datos[i].mp[j]}</li>`; 
                          }      
                        }else{
                          mp = 'N/A';
                        }
                      
                        let ace = '<ul style="font-size:0.9em; list-style:none;">';
                        if(datos[i].asesores.length > 0){
                          for(j = 0; j < datos[i].asesores.length; j++){
                            ace +=`<li style="border-left: 2px solid #848f33; padding-left:2%;">${datos[i].asesores[j]}</li>`; 
                          }   
                        }else{
                          ace = 'N/A';
                        }
                      
                        let def = '<ul style="font-size:0.9em; list-style:none;">';
                        if(datos[i].defensores.length > 0){
                          for(j = 0; j < datos[i].defensores.length; j++){
                            def +=`<li style="border-left: 2px solid #848f33; padding-left:2%;">${datos[i].defensores[j]}</li>`; 
                          }   
                        }else{
                          def = 'N/A';
                        }
                        

                        //Imputados y victimas
                        var cabecera = `<div style="justify-content:space-between; width:100%; display:flex;">
                          <div class="col-md-6" style=" background: #cacfa9; height: 20px; color: #807c7c; padding: 4px; font-weight: bold; font-size: 0.9em;">
                            Victimas
                          </div>
                          <div class="col-md-6" style=" background: #cacfa9; height: 20px; color: #807c7c; padding: 4px; font-weight: bold; font-size: 0.9em;">
                            Imputados
                          </div>
                        </div>`;

                        if(datos[i].imputados.length > 0){
                          
                          if(datos[i].imputados.length > 4 ){
                            clase = 'con_altura';
                            styles = 'height:110px; overflow-y:auto;';
                          }else{
                            clase = '';
                            styles ='';
                          }

                          var imputados_q =`<ul class="${clase}" style="${styles}list-style:none; text-align:left; width:100%; padding:0;">`;
                          
                          for(j=0; j < datos[i].imputados.length; j++){
                            
                            if(datos[i].imputados[j].libertad_motivo != null && datos[i].imputados[j].libertad_resumen != null){
                              imputadosARR.push({
                                'guardado':1,
                                'FolioCarpeta': datos[i].carpeta_judicial,
                                'idCarpeta': datos[i].id_carpeta_judicial,
                                'id_persona': datos[i].imputados[j].id_persona,
                                'nombre_persona': datos[i].imputados[j].nombre,
                                'motivo': datos[i].imputados[j].libertad_motivo,
                                'motivo_escrito': 1,
                                'resumen':datos[i].imputados[j].libertad_resumen,
                                'resumen_escrito': 1,
                                'clave_unidad':datos[i].clave_unidad,
                                'fecha':datos[i].fecha,
                                'tipo_audiencia':datos[i].tipo_audiencia,
                                'carpeta_investigacion': datos[i].carpeta_investigacion
                              });
                            }else{
                              imputadosARR.push({
                                'guardado':0,
                                'FolioCarpeta': datos[i].carpeta_judicial,
                                'idCarpeta': datos[i].id_carpeta_judicial,
                                'id_persona': datos[i].imputados[j].id_persona,
                                'nombre_persona': datos[i].imputados[j].nombre,
                                'motivo': '',
                                'motivo_escrito': 0,
                                'resumen':'',
                                'resumen_escrito': 0,
                                'clave_unidad':datos[i].clave_unidad,
                                'fecha':datos[i].fecha,
                                'tipo_audiencia':datos[i].tipo_audiencia,
                                'carpeta_investigacion': datos[i].carpeta_investigacion
                              });
                            }

                            var checked = '';
                            if(datos[i].imputados[j].libertad_resumen != null && datos[i].imputados[j].libertad_motivo != null){
                              checked = 'checked';
                              fn = `eliminarMotivoResumenDBModal(${i},${indice});`;
                            }else{
                              checked = '';
                              fn = `motivos_resumen_add(${i},${indice}, this)`;
                            }

                            imputados_q += `<li style="font-size:0.9em;">
                              <label style="padding: 4px;cursor: pointer;">
                                <input type="checkbox" id="item_${i}${indice}_${datos[i].imputados[j].id_persona}" ${checked} onchange="${fn}" value="${datos[i].imputados[j].id_persona}"> ${datos[i].imputados[j].nombre}
                              </label>
                            </li>`;
                            indice++;
                          }

                          imputados_q += '</ul>';

                          imputados_w = `
                              <div class="col-md-6 mt-2">
                                  ${imputados_q}
                              </div>
                          `;
                          
                        }else{

                          imputadosARR.push({
                            'guardado':0,
                            'FolioCarpeta': datos[i].carpeta_judicial,
                            'idCarpeta': datos[i].id_carpeta_judicial,
                            'id_persona': 0,
                            'nombre_persona': '',
                            'motivo': '',
                            'motivo_escrito': 0,
                            'resumen':'',
                            'resumen_escrito': 0,
                            'clave_unidad':datos[i].clave_unidad,
                            'fecha':datos[i].fecha,
                            'tipo_audiencia':datos[i].tipo_audiencia,
                            'carpeta_investigacion': datos[i].carpeta_investigacion
                          });

                          imputados_w = `
                            <div class="col-md-6 mt-2">
                              N/A
                            </div>
                          `;
                        }

                        if(datos[i].victima.length > 0){

                          if(datos[i].victima.length > 4 ){
                            clase = 'con_altura';
                            styles = 'height:110px; overflow-y:auto;';
                          }else{
                            clase = '';
                            styles ='';
                          }

                          var victima_q =`<ul class="${clase}" style="${styles}list-style:none; text-align:left; width:100%; padding:0;">`;
                            
                          for(j=0; j<datos[i].victima.length; j++){
                            victima_q += '<li style="font-size:0.9em;"><label style="padding: 4px;cursor: pointer;">'+datos[i].victima[j]+'</label></li>'; 
                          } 
                          victima_q += '</ul>';
                          
                          victima_w = `
                              <div class="col-md-6 mt-2">
                                  ${victima_q}
                              </div>
                          `;
                          
                        }else{
                          victima_w = `
                          <div class="col-md-6 mt-2">
                              N/A
                          </div>
                          `;
                        }
                        
                        personas_z = `
                          <div>
                            ${cabecera}
                            <div style="justify-content:space-between; width:100%; display:flex;">
                              ${victima_w}
                              ${imputados_w}
                            </div>
                          </div>
                        `;

                        tableLib += `
                        <tr>
                          <td style="display: table-cell; vertical-align:middle; "> 
                            ${texto}
                          </td>  
                          <td style="display: table-cell; vertical-align:middle; "> 
                            <div style="padding: 2px; width: 100%;">
                              <div style="padding-left:4px; text-align:left; border-left:2px solid #848F33; margin: 1.5% auto 4% auto; width:90%;"><span style="font-weight:bold !important; color:#848484 !important; font-size:0.9em;">Carpeta Judicial:</span>  ${datos[i].carpeta_judicial}</div>
                              <div style="padding-left:4px; text-align:left; border-left:2px solid #848F33; margin: 2% auto 1.5% auto; width:90%;">
                                <div style="font-weight:bold !important; color:#848484 !important; margin-bottom:1%; font-size:0.9em;">Carpeta de Investigacion: </div>
                                <div style="font-size:0.85em;">${datos[i].carpeta_investigacion}</div>
                              </div>
                            </div>
                          </td>  
                          <td style="display: table-cell; vertical-align:middle; "> 
                            ${datos[i].fecha}
                          </td>  
                          <td style="display: table-cell; vertical-align:middle; "> 
                            ${datos[i].tipo_audiencia}
                          </td>  
                          <td style="display: table-cell; vertical-align:middle; "> 
                            ${datos[i].jueces[0]}
                          </td>  
                          <td style="display: table-cell; vertical-align:middle; "> 
                            ${personas_z}
                          </td>  
                          <td style="display: table-cell; vertical-align:middle; "> 
                            ${delitos}
                          </td>  
                          <td style="display: table-cell; vertical-align:middle; "> 
                            ${mp}
                          </td>  
                          <td style="display: table-cell; vertical-align:middle; "> 
                            ${ace}
                          </td>  
                          <td style="display: table-cell; vertical-align:middle; "> 
                            ${def}
                          </td>  
                        </tr>
                        `;
                        

                      }

                      setTimeout(function(){
                        var table = ``;
                        for(i in imputadosARR){
                          if(imputadosARR[i].motivo != ''){
                            texto = imputadosARR[i].clave_unidad ;
  
                            if(imputadosARR[i].clave_unidad == '209'){texto="009"}//209
                            if(imputadosARR[i].clave_unidad == '301'){texto="UGJJA"}//Adolescentes

                            table += `<tr>
                              <td style="display: table-cell; vertical-align:middle; "> 
                                ${texto}
                              </td>  
                              <td style="display: table-cell; vertical-align:middle; ">${imputadosARR[i].nombre_persona}</td>  
                              <td style="display: table-cell; vertical-align:middle; ">
                                <textarea class="form-control blanco" rows="1" tipo="resumen" id="text_${i}_${imputadosARR[i].id_persona}_r" onchange="actualizarMotivoResumen(${i}, this)" value="${imputadosARR[i].resumen}" style="background: #cacfa9;margin-top: 0px; margin-bottom: 0px; min-height: 42px; font-size:0.9em;">${imputadosARR[i].resumen}</textarea>
                              </td>  
                              <td style="display: table-cell; vertical-align:middle; ">
                                <textarea  class="form-control blanco" rows="1" tipo="motivo" id="text_${i}_${imputadosARR[i].id_persona}_m" onchange="actualizarMotivoResumen(${i}, this)" value="${imputadosARR[i].motivo}" style="background: #cacfa9;margin-top: 0px; margin-bottom: 0px; min-height: 42px; font-size:0.9em;">${imputadosARR[i].motivo}</textarea>
                              </td>  
                              <td style="display: table-cell; vertical-align:middle;">
                                <div style="padding: 2px; width: 100%;">
                                  <div style="padding-left:4px; text-align:left; border-left:2px solid #848F33; margin: 1.5% auto 4% auto; width:90%;"><span style="font-weight:bold !important; color:#848484 !important; font-size:0.9em;">Carpeta Judicial:</span>  ${imputadosARR[i].FolioCarpeta}</div>
                                  <div style="padding-left:4px; text-align:left; border-left:2px solid #848F33; margin: 2% auto 1.5% auto; width:90%;">
                                    <div style="font-weight:bold !important; color:#848484 !important; margin-bottom:1%; font-size:0.9em;">Carpeta de Investigacion: </div>
                                    <div style="font-size:0.85em;">${imputadosARR[i].carpeta_investigacion}</div>
                                  </div>
                                </div>
                              </td>
                              <td style="display: table-cell; vertical-align:middle;">${imputadosARR[i].fecha}</td>
                              <td style="display: table-cell; vertical-align:middle;">${imputadosARR[i].tipo_audiencia}</td>
                            </tr>`;
                          }
                        }

                        table +=`<tr class='noSearch hide'>
                          <td colspan="7" style="font-weight: bold; padding:7px !important;">Sin referencia de datos</td>
                        </tr>`;

                        $('#motivo_resumenTbody').html(table);
                      },1000);


                      $('#body-table1').html(tableLib)

                      console.log('imputados agregados', imputadosARR);

                      $('.pagina_total_texto').html(response.response_paginacion['paginas_totales']);
                      $('#paginas_totales').val(response.response_paginacion['paginas_totales'])

                  } else {
                      let body = "";
                      body = `<tr><td colspan="12" style="font-weight: bold; padding:7px !important;">Sin referencia de datos</td><tr>`;
                      $("#body-table1").html(body);
                  }
              }
          });
          
      }
    }


  /* ############# Funciones para libertades no guardadas en DB ################*/
    function mostrarTabMotivoResumen(){
      $('#globito').toggle();
    }

    function motivos_resumen_add(__indx__, __indy__ = null, obj){
      var info = imputadosARR[__indy__];
      var folio = info.FolioCarpeta;
      var idCarpeta = info.idCarpeta;
      var id_persona = info.id_persona;
      var nombre_persona = info.nombre_persona;
      //var _index_ = imputadosARR.length;

      if($(obj).is(':checked')){
        
        imputadosARR[__indy__].guardado = 0;
        imputadosARR[__indy__].motivo = '';
        imputadosARR[__indy__].motivo_escrito = 0;
        imputadosARR[__indy__].resumen = '';
        imputadosARR[__indy__].resumen_escrito = 0;

        indices.push(__indy__);

        //Muestra el modal de globito
        $('#globito').toggle(true);

        // 1.- Si aun no hay algun imputado registrado
        if($('#body_globito div').hasClass('sin_imputados')){
          $('.sin_imputados').remove(); //Quitamos el letrero

          //Añadimos una carpeta
          carpeta = `
          <div class="col-md-12 carpeta carpeta_${__indx__}${__indy__}_${idCarpeta}" id="carpeta_${__indx__}${__indy__}_${idCarpeta}" guardado="0">
            <div class="title_carpeta">Carpeta: ${folio}</div>
            <ul style="width:100%; list-style:none; padding:0;" id="items_${__indx__}${__indy__}_${idCarpeta}">
              <li style="font-size:0.82em; position:relative; padding:6px;" id="it_${__indx__}${__indy__}_${id_persona}"  guardado="0">${nombre_persona} 
                <span class="button_saved" onclick="guardarMotivoResumen(${__indx__}, ${__indy__})" title="Guardar ${nombre_persona}"><i class="far fa-save" style="margin-top:1%;"></i></span>
                <span class="button_delete" onclick="removerMotivoResumen(${__indx__}, ${__indy__})" title="Deseleccionar ${nombre_persona}"><i class="fas fa-eraser" style="margin-top:1%;"></i></span>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Motivos</label>
                      <textarea class="form-control" rows="1" onchange="escribirMR(${__indy__},'motivo', this)" style="margin-top: 0px; margin-bottom: 0px; min-height: 42px; font-size:0.9em;"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Resumen</label>
                      <textarea class="form-control" rows="1" onchange="escribirMR(${__indy__},'resumen', this)" style="margin-top: 0px; margin-bottom: 0px; min-height: 42px; font-size:0.9em;"></textarea>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          `;

          $('#body_globito').append(carpeta);

        }
        
        //2. si ya existe una carpeta agregada
        else if($('#body_globito div').hasClass(`carpeta`)){

          // 2.1 Verificamos que carpeta existe

          // 2.1.1 Si el imputado es de la misma carpeta
          if($('#body_globito div').hasClass(`carpeta_${__indx__}${__indy__}_${idCarpeta}`)){
            $(`#carpeta_${__indx__}${__indy__}_${idCarpeta}`).attr('guardado',2);

            $(`#items_${__indx__}${__indy__}_${idCarpeta}`).append(`<li style="font-size:0.82em; position:relative; padding:6px;" id="it_${__indx__}${__indy__}_${id_persona}"  guardado="0">${nombre_persona} 
                                                <span class="button_saved" onclick="guardarMotivoResumen(${__indx__}, ${__indy__})" title="Guardar ${nombre_persona}"><i class="far fa-save" style="margin-top:1%;"></i></span>
                                                <span class="button_delete" onclick="removerMotivoResumen(${__indx__}, ${__indy__})" title="Deseleccionar ${nombre_persona}"><i class="fas fa-eraser" style="margin-top:1%;"></i></span>
                                                <div class="row">
                                                  <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label>Motivos</label>
                                                      <textarea class="form-control" rows="1" onchange="escribirMR(${__indy__},'motivo', this)" style="margin-top: 0px; margin-bottom: 0px; min-height: 42px; font-size:0.9em;"></textarea>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label for="exampleFormControlTextarea1">Resumen</label>
                                                      <textarea class="form-control" rows="1" onchange="escribirMR(${__indy__},'resumen', this)" style="margin-top: 0px; margin-bottom: 0px; min-height: 42px; font-size:0.9em;"></textarea>
                                                    </div>
                                                  </div>
                                                </div>
                                              </li>`);
          }
          // 2.1.2 Si el imputado es de otra carpeta
          else{
            //Añadimos una carpeta
            carpeta = `
              <div class="col-md-12 carpeta carpeta_${__indx__}${__indy__}_${idCarpeta}" id="carpeta_${__indx__}${__indy__}_${idCarpeta}" guardado="0">
                <div class="title_carpeta">Carpeta: ${folio}</div>
                <ul style="width:100%; list-style:none; padding:0;" id="items_${__indx__}${__indy__}_${idCarpeta}">
                  <li style="font-size:0.82em; position:relative; padding:6px;" id="it_${__indx__}${__indy__}_${id_persona}"  guardado="0">${nombre_persona} 
                    <span class="button_saved" onclick="guardarMotivoResumen(${__indx__}, ${__indy__})" title="Guardar ${nombre_persona}"><i class="far fa-save" style="margin-top:1%;"></i></span>
                    <span class="button_delete" onclick="removerMotivoResumen(${__indx__}, ${__indy__})" title="Deseleccionar ${nombre_persona}"><i class="fas fa-eraser" style="margin-top:1%;"></i></span>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Motivos</label>
                          <textarea class="form-control" rows="1" onchange="escribirMR(${__indy__},'motivo', this)" style="margin-top: 0px; margin-bottom: 0px; min-height: 42px; font-size:0.9em;"></textarea>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleFormControlTextarea1">Resumen</label>
                          <textarea class="form-control" rows="1" onchange="escribirMR(${__indy__},'resumen', this)" style="margin-top: 0px; margin-bottom: 0px; min-height: 42px; font-size:0.9em;"></textarea>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            `;
      
            $('#body_globito').prepend(carpeta);

          }

        }
      }else{
        remover_ya_agregado(__indx__, __indy__);
      }

      console.log('imputados nuevos', imputadosARR);
    }

    function escribirMR(index, tipo, obj){
      if(tipo == 'resumen'){
        var valor = $(obj).val();

        if(valor != ''){
          imputadosARR[index].resumen = $(obj).val();
          imputadosARR[index].resumen_escrito = 1;
        }else{
          imputadosARR[index].resumen = '';
          imputadosARR[index].resumen_escrito = 0;
        }

      }else if(tipo == 'motivo'){
        var valor = $(obj).val();

        if(valor != '' ){
          imputadosARR[index].motivo = $(obj).val();

          imputadosARR[index].motivo_escrito = 1;
        }else{
          imputadosARR[index].motivo = '';
          imputadosARR[index].motivo_escrito = 0;
        }
        
      }

      console.log(imputadosARR); 
    }

    function guardarMotivoResumen(__indx__, __indy__){

      var info = imputadosARR[__indy__];
      console.log('imputado a guardar', info);
      var persona = [];
      persona.push(info);

      if(info.motivo_escrito == 0 || info.resumen_escrito == 0){
        error('Lo sentimos, debe llenar ambos campos para guardar');
      }else{
        $.ajax({
          type: 'POST',
          url: '/public/guardarMotivoResumen',
          data: {
            persona: persona
          },
          success: function(response) {
            console.log(response);
            if(response.status == 100){
              $(`#it_${__indx__}${__indy__}_${info.id_persona} textarea`).css('background', '#cacfa9');
              setTimeout(function(){
                remover_ya_agregado(__indx__, __indy__);
              },2000);
            }else{
              $(`#it_${__indx__}${__indy__}_${info.id_persona} textarea`).css('background', '#cfa9a9');
            }
          }
        });
      }
    }

    function removerMotivoResumen(__indx__, __indy__){

        var info = imputadosARR[__indy__];

        //Remover un registro no guardado
        if(info.guardado == 0){

          $(`#item_${__indx__}${__indy__}_${info.id_persona}`).prop('checked', false);
          imputadosARR[__indy__].guardado = 0;
          imputadosARR[__indy__].motivo = '';
          imputadosARR[__indy__].motivo_escrito = 0;
          imputadosARR[__indy__].resumen = '';
          imputadosARR[__indy__].resumen_escrito = 0;

          if($(`#items_${__indx__}${__indy__}_${info.idCarpeta} li`).length  >  1){
            $(`#it_${__indx__}${__indy__}_${info.id_persona}`).remove();
          }else{
            if($('#body_globito .carpeta').length > 1){
              $(`#carpeta_${__indx__}${__indy__}_${info.idCarpeta}`).remove();
            }else{
              $('#body_globito').html(`<div class="col-md-12 sin_imputados" style="width: 100%; background:#eee; text-align:center; padding:4px;">
                Seleccione Imputados
              </div>`);
            }
          }

          console.log('imputados eliminados',imputadosARR);

        }
    }

    function remover_ya_agregado(__indx__, __indy__){
      var info = imputadosARR[__indx__];

      imputadosARR[__indy__].guardado = 0;
      imputadosARR[__indy__].motivo = '';
      imputadosARR[__indy__].motivo_escrito = 0;
      imputadosARR[__indy__].resumen = '';
      imputadosARR[__indy__].resumen_escrito = 0;

      if($(`#items_${__indx__}${__indy__}_${info.idCarpeta} li`).length  >  1){
        $(`#it_${__indx__}${__indy__}_${info.id_persona}`).remove();
      }else{
        if($('#body_globito .carpeta').length > 1){
          $(`#carpeta_${__indx__}${__indy__}_${info.idCarpeta}`).remove();
        }else{
          $('#body_globito').html(`<div class="col-md-12 sin_imputados" style="width: 100%; background:#eee; text-align:center; padding:4px;">
            Seleccione Imputados
          </div>`);
        }
      }
    }

    function guardarMotivoResumenTodo(){
      console.log('indices a guardar',indices);
      personas = [];
      for(i in indices){
        var info = imputadosARR[indices[i]];

        if(info.motivo != ''){
          personas.push(info);
        }
      }

      if(personas.length <= 0)  error('Lo sentimos, debe llenar por lo menos un par de registros');
      else
      $.ajax({
        type: 'POST',
        url: '/public/guardarMotivoResumen',
        data: {
          persona: personas
        },
        success: function(response) {
          console.log(response);
          if(response.status == 100){
            success('Datos guardados correctamente');
            sec_ajax();
          }else{
            error('Lo sentimos, ocurrio un error al guardad los datos');
          }
        }
      });
    }


    //################  prueba de servicios de libertades ###############

    //Quitar en caso de estar ya guardado en DB
    function eliminarMotivoResumenDBModal(__indx__, __indy__ = null, tipo){
      var info = imputadosARR[__indy__];

      if(tipo == 2) $('#usuarioAsigando').html(`El motivo y resumen de ${info.nombre_persona} se removera`);
      else $('#usuarioAsigando').html(`Deseas remover el motivo y resumen de ${info.nombre_persona} ?`);

      $('#modalAdvertirbtn').attr('onclick', `removerMotivoResumenDB(${__indy__})`);

      if(tipo == 2) $('#modalAdvertirbtnCerrar').css('display', 'none');
      else $('#modalAdvertirbtnCerrar').css('display', 'block'); $('#modalAdvertirbtnCerrar').attr('onclick', `cerraModalAdvertir(${__indx__}, ${__indy__}, ${ info.id_persona})`);

      $('#modalAdvertir').modal('show');

    }

    function removerMotivoResumenDB(__indx__){
      var info = imputadosARR[__indx__];

      $.ajax({
        type: 'POST',
        url: '/public/eliminarMotivoResumen',
        data: {
          id_persona: info.id_persona,
        },
        success: function(response) {
          console.log('repuesta',response);
          if(response.status == 100){
            $('#modalAdvertir').modal('hide');
            success(response.response);
            sec_ajax();
          }else{
            $('#modalAdvertir').modal('hide');
            error(response.response);
          }
        }
      });
      
    }

    //Actualizar los datos en caso de ya estar guardados DB

    function actualizarMotivoResumen(__indx__,obj){
      var info = imputadosARR[__indx__];
      var tipo = $(obj).attr('tipo');
      var resumen = '';
      var motivo = '';
      let valid = null;

      if(tipo == 'motivo'){
        motivo = $(obj).val();
        resumen = $(`#text_${__indx__}_${info.id_persona}_r`).val();
        if($(obj).val() == '') $(obj).css('background', '#fff');
      }else{
        motivo = $(`#text_${__indx__}_${info.id_persona}_m`).val();
        resumen = $(obj).val();
        if($(obj).val() == '') $(obj).css('background', '#fff');
      }

      console.log('resumen', resumen);
      console.log('motivo', motivo);

      valid = validadorMR(motivo, resumen, info.nombre_completo);

      if(valid.status == 100){
        imputadosARR[__indx__].motivo = motivo;
        imputadosARR[__indx__].resumen = resumen;
        editarMotivoResumen(__indx__, obj);
      }else{
        console.log('indice', __indx__);
        console.log('removido', imputadosARR)
        eliminarMotivoResumenDBModal(__indx__, null, 2);
      }
    }

    function editarMotivoResumen(__indx__, obj){
      var info = imputadosARR[__indx__];
      console.log('imputado a editar', info);
      var persona = [];
      persona.push(info);

      $.ajax({
          type: 'POST',
          url: '/public/guardarMotivoResumen',
          data: {
            persona: persona
          },
          success: function(response) {
              console.log(response);
              if(response.status == 100){
                if($(obj).val() == '') $(obj).css('background', '#fff');
                else $(obj).css('background', '#cacfa9');
              }else{
                if($(obj).val() == '') $(obj).css('background', '#fff');
                else $(obj).css('background', '#cfa9a9');
              }
          }
      });
      
    }


    // ######### Herramientas  #############
    function cerraModalAdvertir(__indx__, __indy__, id_persona){
      $('#modalAdvertir').modal('hide');
      $(`#item_${__indx__}${__indy__}_${id_persona}`).prop('checked', true);
    }

    function validadorMR(motivo, resumen, persona){
      if((motivo == '' || motivo === null) && (resumen == '' || resumen == null)) return {'status':0, 'response':`Desea Remover el Motivo y resumen de ${persona}` }

      return {'status':100};
    }

    function doSearch(){
        const tableReg = document.getElementById('tableRMReg');
        const searchText = document.getElementById('serchaBar').value.toLowerCase();
        let total = 0;

        // Recorremos todas las filas con contenido de la tabla
        for (let i = 1; i < tableReg.rows.length; i++) {
            // Si el td tiene la clase "noSearch" no se busca en su cntenido
            if (tableReg.rows[i].classList.contains("noSearch")) {
                continue;
            }

            let found = false;
            const cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
            // Recorremos todas las celdas
            for (let j = 0; j < cellsOfRow.length && !found; j++) {
                const compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                // Buscamos el texto en el contenido de la celda
                if (searchText.length == 0 || compareWith.indexOf(searchText) > -1) {
                    found = true;
                    total++;
                }
            }
            if (found) {
                tableReg.rows[i].style.display = '';
            } else {
                // si no ha encontrado ninguna coincidencia, esconde la
                // fila de la tabla
                tableReg.rows[i].style.display = 'none';
            }
        }

        // mostramos las coincidencias
        const lastTR=tableReg.rows[tableReg.rows.length-1];
        const td=lastTR.querySelector("td");
        lastTR.classList.remove("hide");
        if (searchText == "") {
            lastTR.classList.add("hide");
        } else if (total) {
            td.innerHTML="Se ha encontrado "+total+" coincidencia"+((total>1)?"s":"");
        } else {
            td.innerHTML="Sin referencia de datos";
        }
    }

    /* Funciones que no se mueven */

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
    
    function hScroll (amount) {
      /*
      amount = amount || 120;
      $('#libertadesTable').bind("DOMMouseScroll mousewheel", function (event) {
          var oEvent = event.originalEvent, 
              direction = oEvent.detail ? oEvent.detail * -amount : oEvent.wheelDelta, 
              position = $(this).scrollLeft();
          position += direction > 0 ? -amount : amount;
          $('#libertadesTable').scrollLeft(position);
          event.preventDefault();
        })
        
        /*
        $('#datos_adicionales').bind("DOMMouseScroll mousewheel", function (event) {
          var oEvent = event.originalEvent, 
              direction = oEvent.detail ? oEvent.detail * -amount : oEvent.wheelDelta, 
              position = $(this).scrollLeft();
          position += direction > 0 ? -amount : amount;
          $('#datos_adicionales').scrollLeft(position);
          event.preventDefault();
        })
        */
        
    }
    
    function addRow(){
      let combo_unidad = '';
      let tr = "";

      $('#mensaje_datos').css('display', 'none');

      @if($request->session()->get('id_tipo_usuario') == 1)

        console.log('combo_unidades',combo_unidades);
        //Unidad
        array_p1Un = [];
        array_p2Un = [];
        for(i = 0; i < combo_unidades.length; i++){
          if(combo_unidades[i].clave_unidad < 302){
              var texto = '';
              var conclave_r = '';
              if(combo_unidades[i].clave_unidad == '001'){array_p1Un.push({ "clave":'001', "texto":"001"})}//001
              if(combo_unidades[i].clave_unidad == '002'){array_p1Un.push({ "clave":'002', "texto":"002"})}//002
              if(combo_unidades[i].clave_unidad == '003'){array_p1Un.push({ "clave":'003', "texto":"003"})}//003
              if(combo_unidades[i].clave_unidad == '004'){array_p1Un.push({ "clave":'004', "texto":"004"})}//004
              if(combo_unidades[i].clave_unidad == '005'){array_p1Un.push({ "clave":'005', "texto":"005"})}//005
              if(combo_unidades[i].clave_unidad == '006'){array_p1Un.push({ "clave":'006', "texto":"006"})}//006
              if(combo_unidades[i].clave_unidad == '007'){array_p1Un.push({ "clave":'007', "texto":"007"})}//007
              if(combo_unidades[i].clave_unidad == '008'){array_p1Un.push({ "clave":'008', "texto":"008"})}//008
              if(combo_unidades[i].clave_unidad == '209'){array_p1Un.push({ "clave":'209', "texto":"009"})}//209
              if(combo_unidades[i].clave_unidad == '010'){array_p2Un.push({ "clave":'010', "texto":"010"})}//010
              if(combo_unidades[i].clave_unidad == '011'){array_p2Un.push({ "clave":'011', "texto":"011"})}//011
              if(combo_unidades[i].clave_unidad == '012'){array_p2Un.push({ "clave":'012', "texto":"012"})}//012
              if(combo_unidades[i].clave_unidad == '301'){array_p2Un.push({ "clave":'301', "texto":"UGJJA"})}//Adolescentes
          }
        }

        cbo_unidades_mostrar = array_p1Un.concat(array_p2Un);
      
        combo_unidad = `<select class="editable1 un" onchange="setUnidad(this)">`;
          for(i = 0; i < cbo_unidades_mostrar.length; i++){
            combo_unidad += `<option value="${cbo_unidades_mostrar[i].clave}"> ${cbo_unidades_mostrar[i].texto} </option>`;
          }
        combo_unidad += `</select>`;
      
        //Carpeta Judicial
        CJ = `<input type="text" class="editable1 cj" placeholder="xxxx/xxxx/xxxx" onchange="obtener_Carpetas(this)">`;
        
        //Jueces
        jueces = `<select class="editable1 jueces multi" multiple="multiple" style="height:0;"></select>`;

        //Victimas
        victimas = `<select class="editable1 vi multi" multiple="multiple" style="height:0;"></select>`;

        //imputados
        imputados = `<select class="editable1 imputados multi" multiple="multiple" style="height:0;"></select>`;
        
        //delitos
        delitos = `<select class="editable1 delitos multi" multiple="multiple" style="height:0;"></select>`;

        //mipublico
        mipublico = `<select class="editable1 mipublico multi" multiple="multiple" style="height:0;"></select>`;

        //asjuridico
        asjuridico = `<select class="editable1 asjuridico multi" multiple="multiple" style="height:0;"></select>`;

        //defensa
        defensa = `<select class="editable1 defensa multi" multiple="multiple" style="height:0;"></select>`;


        tr = `<tr style="text-align: center;" unidad="001">
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><i class="fas fa-times-circle boton_quitar_remove" title="Quitar filas" onclick="removeRow(this)"></i></td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"> ${combo_unidad} </td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"> ${CJ} </td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><input type="text" class="editable1 ci" placeholder="Carpeta de Investigacion" readonly></td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><input type="date" class="editable1 fecha" placeholder="Fecha" value="<?php echo date('Y-m-d');?>"></td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${jueces}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${victimas}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${imputados}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${delitos}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${mipublico}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${asjuridico}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${defensa}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><input type="text" class="editable1 motlibertad" placeholder="Motivo de libertad"></td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><input type="text" class="editable1 brresumen" placeholder="Breve Resumen"></td>
              </tr>`;
        
      @else
        
          var texto = '';
          if(clave == '001'){texto="001"}//001
          if(clave == '002'){texto="002"}//002
          if(clave == '003'){texto="003"}//003
          if(clave == '004'){texto="004"}//004
          if(clave == '005'){texto="005"}//005
          if(clave == '006'){texto="006"}//006
          if(clave == '007'){texto="007"}//007
          if(clave == '008'){texto="008"}//008
          if(clave == '209'){texto="009"}//209
          if(clave == '010'){texto="010"}//010
          if(clave == '011'){texto="011"}//011
          if(clave == '012'){texto="012"}//012
          if(clave == '301'){texto="UGJJA"}//Adolescentes
        
        
        combo_unidad = `<input type="text" class="editable1 un" placeholder="Formato: xxx" value="${texto}" readonly>`;

        //Carpeta Judicial
        CJ = `<input type="text" class="editable1 cj" placeholder="xxxx/xxxx/xxxx" onchange="obtener_Carpetas(this)">`;

        //Jueces
        jueces = `<select class="editable1 jueces multi" multiple="multiple" style="height:0;"></select>`;

        //Victimas
        victimas = `<select class="editable1 vi multi" multiple="multiple" style="height:0;"></select>`;

        //imputados
        imputados = `<select class="editable1 imputados multi" multiple="multiple" style="height:0;"></select>`;
        
        //delitos
        delitos = `<select class="editable1 delitos multi" multiple="multiple" style="height:0;"></select>`;

        //mipublico
        mipublico = `<select class="editable1 mipublico multi" multiple="multiple" style="height:0;"></select>`;

        //asjuridico
        asjuridico = `<select class="editable1 asjuridico multi" multiple="multiple" style="height:0;"></select>`;

        //defensa
        defensa = `<select class="editable1 defensa multi" multiple="multiple" style="height:0;"></select>`;

        tr = `<tr style="text-align: center;" unidad="${clave}">
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><i class="fas fa-times-circle boton_quitar_remove" title="Quitar filas" onclick="removeRow(this)"></i></td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"> ${combo_unidad} </td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"> ${CJ} </td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><input type="text" class="editable1 ci" placeholder="Carpeta de Investigacion" readonly></td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><input type="date" class="editable1 fecha" placeholder="Fecha" value="<?php echo date('Y-m-d');?>"></td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${jueces}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${victimas}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${imputados}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${delitos}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${mipublico}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${asjuridico}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;">${defensa}</td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><input type="text" class="editable1 motlibertad" placeholder="Motivo de libertad"></td>
                <td style="border: 1px solid #ccc; height: 32px; display: table-cell; vertical-align: middle;"><input type="text" class="editable1 brresumen" placeholder="Breve Resumen"></td>
              </tr>`;


      @endif

      $("#datos_add").append(`${tr}`);
      
    }

    function removeRow(obj){
      var cuantos = $("#Datos_add_table tbody tr").length
      $(obj).closest('tr').remove();

      if(cuantos < 2){
        $('#mensaje_datos').css('display', 'block');
      }
    }

    function guardar_info_addi(){
      objeto_datos=[];
      c_unidad =[];
      c_cj = [];
      c_ci = [];
      c_fecha = [];
      c_jueces = [];
      c_victimas = [];
      c_imputados = [];
      c_delitos = [];
      c_mipublico = [];
      c_asjuridico = [];
      c_defensa =[];
      c_motlibertad =[];
      c_brresumen = [];

      $('#datos_add tr').each(function() {
        //Obtener datos de la tabla
        var unidad = $(this).find("td").eq(1).children(".un").val() == '' ? '' : $(this).find("td").eq(1).children(".un").val()
        var cj = $(this).find("td").eq(2).children(".cj").val() == '' ? '' : $(this).find("td").eq(2).children(".cj").val()
        var ci = $(this).find("td").eq(3).children(".ci").val() == '' ? '' : $(this).find("td").eq(3).children(".ci").val()
        var fecha = $(this).find("td").eq(4).children(".fecha").val() == '' ? '' : $(this).find("td").eq(4).children(".fecha").val()
        var jueces = $(this).find("td").eq(5).children(".jueces").val() == '' ? [""] :  $(this).find("td").eq(5).children(".jueces").val()
        var victimas = $(this).find("td").eq(6).children(".vi").val() == '' ? [""] :  $(this).find("td").eq(6).children(".vi").val()
        var imputados = $(this).find("td").eq(7).children(".imputados").val() == '' ? [""] : $(this).find("td").eq(7).children(".imputados").val()
        var delitos = $(this).find("td").eq(8).children(".delitos").val() == '' ? [""] : $(this).find("td").eq(8).children(".delitos").val()
        var mipublico = $(this).find("td").eq(9).children(".mipublico").val() == '' ? [""] : $(this).find("td").eq(9).children(".mipublico").val()
        var asjuridico = $(this).find("td").eq(10).children(".asjuridico").val() == '' ? [""] : $(this).find("td").eq(10).children(".asjuridico").val()
        var defensa = $(this).find("td").eq(11).children(".defensa").val() == '' ? [""] : $(this).find("td").eq(11).children(".defensa").val()
        var motlibertad = $(this).find("td").eq(12).children(".motlibertad").val() == '' ? '' : $(this).find("td").eq(12).children(".motlibertad").val()
        var brresumen = $(this).find("td").eq(13).children(".brresumen").val() == '' ? '' : $(this).find("td").eq(13).children(".brresumen").val()

        //Añadir a los arreglos
        c_unidad.push(unidad);
        c_cj.push(cj);
        c_ci.push(ci);
        c_fecha.push(fecha);
        c_jueces.push(jueces);
        c_victimas.push(victimas);
        c_imputados.push(imputados);
        c_delitos.push(delitos);
        c_mipublico.push(mipublico);
        c_asjuridico.push(asjuridico);
        c_defensa.push(defensa);
        c_motlibertad.push(motlibertad);
        c_brresumen.push(brresumen);

      });

     
      for(i = 0; i < c_unidad.length; i++){
        objeto_datos.push({
          "unidad":  c_unidad[i],
          "CJ":  c_cj[i],
          "CI": c_ci[i],
          "fecha": c_fecha[i],
          "jueces": c_jueces[i],
          "victimas": c_victimas[i],
          "imputados": c_imputados[i],
          "delitos": c_delitos[i],
          "ministerio_publico": c_mipublico[i],
          "asesor_juridico": c_asjuridico[i],
          "defensa": c_defensa[i],
          "motivo_libertad": c_motlibertad[i],
          "breve_resumen": c_brresumen[i]
        });
      }



      if(objeto_datos.length <= 0){
        error('No hay datos en la tabla');
      }else{
        console.log(objeto_datos);
        if(objeto_datos[0].CI == ''){
          error('No hay datos en la tabla');
        }else{
          $.ajax({
            type: 'POST',
            url: '/public/guardar_info_addi',
            data: {
              objeto_datos: objeto_datos
            },
            success: function(response) {
              console.log(response);
              if(response.status == 100){
                success(response.response);
                $('#datos_add').html('');
                $('#mensaje_datos').css('display', 'block');
              }else{
                error(response.response);
              }
            }
          });
        } 
      }
    }

    //Auto llenado
    function obtener_Carpetas(obj){
      var unidad_seleccionada = $(obj).parent().parent().attr("unidad");
      var valor =  $(obj).val().trim();
      
      if(valor.length > 0){
        $.ajax({
          type: 'POST',
          url: '/public/ObtenerCarpetaSeleccionada',
          data: {
            unidad: unidad_seleccionada,
            carpeta: valor,
          },
          success: function(response) {
              console.log('datos',response);
              if(response.status == 100){
              carpeta_encontrada = response.response;
              var imputados = '';              
              var defensas = '';              
              var victimas = ''; 
              var mp = ''; 
              var asesor = '';
              var delitos = '';
              var jueces = '';              

              $(obj).css("background", '#ABEBC6');
              setTimeout(function(){
                $(obj).css("background", '#fff');
              }, 2000);

              $(obj).closest('td').siblings().find('.ci').val(carpeta_encontrada[0].Carpeta_investigacion);

              //llenado de victimas
              for(i = 0; i < carpeta_encontrada[0].jueces.length; i++){
                jueces += '<option value="'+carpeta_encontrada[0].jueces[i].id+'">'+ carpeta_encontrada[0].jueces[i].nombre_completo +'</option>';
              }
              $(obj).closest('td').siblings().find('.jueces').append(jueces);

              
              //llenado de victimas
              for(i = 0; i < carpeta_encontrada[0].victimas.length; i++){
                victimas += '<option value="'+carpeta_encontrada[0].victimas[i].id+'">'+ carpeta_encontrada[0].victimas[i].nombre_completo +'</option>';
              }
              $(obj).closest('td').siblings().find('.vi').append(victimas);

              //llenado de defensores
              for(i = 0; i < carpeta_encontrada[0].defensas.length; i++){
                defensas += '<option value="'+carpeta_encontrada[0].defensas[i].id+'">'+ carpeta_encontrada[0].defensas[i].nombre_completo +'</option>';
              }
              $(obj).closest('td').siblings().find('.defensa').append(defensas);
              
              //llenado imputados
              for(i = 0; i < carpeta_encontrada[0].imputados.length; i++){
                imputados += '<option value="'+carpeta_encontrada[0].imputados[i].id+'">'+ carpeta_encontrada[0].imputados[i].nombre_completo +'</option>';
              }
              $(obj).closest('td').siblings().find('.imputados').append(imputados);

              //llenado aseores
              for(i = 0; i < carpeta_encontrada[0].asesor_juridico.length; i++){
                asesor += '<option value="'+carpeta_encontrada[0].asesor_juridico[i].id+'">'+ carpeta_encontrada[0].asesor_juridico[i].nombre_completo +'</option>';
              }
              $(obj).closest('td').siblings().find('.asjuridico').append(asesor);
                        
              //llenado mp
              for(i = 0; i < carpeta_encontrada[0].ministerio_publico.length; i++){
                mp += '<option value="'+carpeta_encontrada[0].ministerio_publico[i].id+'">'+ carpeta_encontrada[0].ministerio_publico[i].nombre_completo +'</option>';
              }
              $(obj).closest('td').siblings().find('.mipublico').append(mp);

              //llenado delitos
              for(i = 0; i < carpeta_encontrada[0].delitos.length; i++){
                delitos += '<option value="'+carpeta_encontrada[0].delitos[i].id_delito+'">'+ carpeta_encontrada[0].delitos[i].delito +'</option>';
              }
              $(obj).closest('td').siblings().find('.delitos').append(delitos);
              

              $(obj).closest('td').siblings().find(".multi").multiselect({
                includeSelectAllOption: true,
                buttonWidth:'auto',
                dropRight:false,
                dropUp:false,
                selectAllText:' Selecciona todos',
                nonSelectedText: 'Selecciona uno',
                buttonTextAlignment: 'center',
                numberDisplayed: 2,
              });

              }else{
                $(obj).css("background", '#F1948A');
                setTimeout(function(){
                  $(obj).css("background", '#fff');
                }, 2000);
              }
          }
        });
      }else{
        $(obj).closest('td').siblings().find('input[type="text"]').val('')
      }

    }

    function cerrar_modal(valor){
      $("#"+valor).modal('hide');
    }

    function setUnidad(obj){
      var valor = $(obj).val()
      $(obj).parent().parent().attr("unidad",valor);
      $(obj).closest('td').siblings().find('input[type="text"]').val('')
    }

    function verLibertades(obj){
      var cerrado_abierto = $(obj).attr('data-open');
      if(cerrado_abierto == 0){
        $('#ver_libertades').addClass('expadir');
        $('#datos_adicionales').addClass('responsive_tabla_libertades');
        $(obj).attr('data-open', 1);
        cargaLibertadesAdicionales();
         
      }else{        
        $('#ver_libertades').removeClass('expadir');
        $('#datos_adicionales').removeClass('responsive_tabla_libertades');
        $('#ver_libertades').html('');
        $(obj).attr('data-open', 0);
      }
    } 

    function cargaLibertadesAdicionales(){
      $.ajax({
        type: 'POST',
        url: '/public/ObtenerLibertadesRegistradas',
        data: {
        },
        success: function(response) {
          console.log(response);
          if(response.status ==100){
            var datos = response.response;

            if(datos.length > 0){
              var libertades_R = '<div style="text-align:center; font-weight:bold; color: #fff !important; background: #848F33 !important; padding: 2px 0px; ">Libertades Registradas</div>';
              for(i = 0; i < datos.length; i++){

                libertades_R +=  `<div class="libertad_reg">
                    <div class="eliminar"><i class="fas fa-trash boton_quitar_remove" title="Quitar registro" onclick="quitarLibertad_c(${datos[i].id_libertad})"></i></div>
                    <div class="datos_libertad">
                      <div><strong>U: </strong>${datos[i].clave_unidad}</div>
                      <div><strong>CJ:</strong> ${datos[i].folio_carpeta}</div>
                      <div><strong>F: </strong>${datos[i].fecha}</div>
                    </div>
                  </div>
                  <div class="clearfix"></div>`; 
              }
          }else{
            libertades_R = `<div style="text-align:center;text-align: center; font-weight: bold; display: flex; justify-content: center; align-items: center; height: 100%;">
              No existen datos registrados
            </div>`;
          }

          $('#ver_libertades').html(libertades_R);

          }else{
            $('#ver_libertades').html(`
              <div style="text-align:center; font-weight: bold; display: flex; justify-content: center; align-items: center; height: 100%;">
                No existen datos registrados
              </div>`);
          }
        }
      })
    }

    function quitarLibertad_c(id){
      $('#id_delete').val(id);

      $('#delete_reg').modal('show');
    }

    function eliminarRegistro(){
      var id_reg = $('#id_delete').val();

      $.ajax({
        type: 'POST',
        url: '/public/borra_libertad_adicional',
        data: {
          id_reg: id_reg,
        },
        success: function(response) {
            console.log(response);
            if(response.status == 100){
              $('#delete_reg').modal('hide');
              success(response.response);
              cargaLibertadesAdicionales();
            }else{  
              error(response.response);
            }
        }
      });
    }

    function buscarPor(obj){
      var valor = $(obj).val();
      var html = '';

      $("#opcion_escogida").html('');
      console.log(valor);
      switch(valor){
        case 'cj':  
          html = `<div class="form-group">
            <label class="label">Carpeta Judicial: </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="far fa-folder-open tx-16 lh-0 op-6"></i>
                    </div>
                </div>
                <input type="text" class="form-control" id="searhfor" tipo="cj" placeholder="unidad/folio/año" name="" autocomplete="off">
            </div>
          </div>`;
        break;

        case 'imp':
          html = `<div class="form-group">
            <label class="label">Imputados: </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-users tx-16 lh-0 op-6"></i>
                    </div>
                </div>
                <input type="text" class="form-control" tipo="imp" placeholder="Imputado" id="searhfor"  name="" autocomplete="off">
            </div>
          </div>`;
        break;

        case 'vic':
          html = `<div class="form-group">
            <label class="label">Victimas: </label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-users tx-16 lh-0 op-6"></i>
                    </div>
                </div>
                <input type="text" class="form-control" tipo="vic" placeholder="Victima" id="searhfor" name="" autocomplete="off">
            </div>
          </div>`;
        break;
      }

      $("#opcion_escogida").append(html);
    }

  </script>
@endsection

@section('seccion-modales')
  {{-- modales de exito y error --}}
  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
          <div id="messageExito">
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="modalError" class="modal fade" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block "></i>
          <div id="messageError" class="mg-b-20">
          </div>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
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

  <div class="modal fade" data-backdrop="static" id="modalAdvertir" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="idGrupo">
          <input type="hidden" id="iduser_input">
          <h5><span id="usuarioAsigando"></span></h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalAdvertirbtnCerrar">Cerrar</button>
          <button type="button" class="btn btn-primary" id="modalAdvertirbtn" onclick="eliminarMotivoResumen()">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
@endsection


