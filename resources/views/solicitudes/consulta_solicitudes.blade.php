@php
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\utilidades;
$humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Solicitudes</a></li>
        <li class="breadcrumb-item"><a href="#"> Consulta de Solicitudes</a></li>
    </ol>
    <h6 class="slim-pagetitle"> Consulta de Solicitudes</h6>
@endsection

@section('contenido-principal')

    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">
            <div class="d-flex justify-content-between" style="align-items: center;">
                <a style="border:1px solid #ccc; width: 70px; height: 45px;" data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance" class="btn btn-default">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <i class="fas fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i>
                </a>
                <div class="row justify-content-end" style="width:80%;">
                    <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">
                    
                    @if( isset($permisos[5]) and $permisos[5] == 1 ) 
                    <div class="col-sm-4 col-md-3 col-lg-2 pd-t-10" align="right">
                        <a href="javascript:void(0);" onclick="exportar_excel_solicitudes(1);" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                    </div>
                    @endif
                    @if( isset($permisos[19]) and $permisos[19] == 1 ) 
                    {{--  <div class="col-sm-4 col-md-3 col-lg-2 pd-t-10" align="right">
                        <a href="javascript:void(0);" onclick="descargar_consulta('pdf');" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar PDF</a>
                    </div>  --}}
                    @endif
                </div>
            </div>

            <div id="accordion" class="accordion-one mt-2 mg-b-20" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div id="collapseSearchAdvance" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                            <div class="row mg-b-25">

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Id Acuse :</label>
                                        <input class="form-control" type="text" value="" name="" id="idsolicitud" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Folio de solicitud : </label>
                                        <input class="form-control" type="text" value="" name="" id="foliosolicitud" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Carpeta de investigación : </label>
                                        <input class="form-control" type="text" value="" placeholder="" id="carpetainvestigacion">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Carpeta Judicial : </label>
                                        <input class="form-control" type="text" value="" placeholder="" id="foliocarpeta">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Fecha de solicitud (Desde): </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fechasolicitud" name="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Fecha de solicitud (Hasta): </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fechasolicitudh" name="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                  <label class="form-control-label">Estatus Actual:</label>
                                  <div class="form-group">
                                    <select class="form-control-lg select2 valid" width='100%' autocomplete="off" id="estatusactual">
                                      <option selected disabled value="">Elija una opción</option>
                                      <option value="">{{ 'TODOS' }}</option>
                                      <option value="RECIBIDA">{{ 'RECIBIDA' }}</option>
                                      <option value="TRAMITE_CJ">EN ESPERA DE SER TURNADO</option>
                                      <option value="REGISTRADA">{{ 'REGISTRADA' }}</option>
                                      <option value="TRAMITE CJ">{{ 'CARPETA JUDICIAL ASIGNADA' }}</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-lg-3">
                                  <label class="form-control-label">Estatus urgente:</label>
                                  <div class="form-group">
                                    <select class="form-control-lg select2 valid" width='100%' autocomplete="off" id="estatusurgente">
                                      <option selected disabled value="">Elija una opción</option>
                                      <option value="">{{ 'TODOS' }}</option>
                                      <option value="si">{{ 'SI' }}</option>
                                      <option value="no">{{ 'NO' }}</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-lg-3" width='100%'>
                                  <label class="form-control-label">Materia destino:</label>
                                  <div class="form-group" width='100%'>
                                    <select class="form-control-lg select2 valid" width='100%' autocomplete="off" id="materiadestino">
                                      <option selected disabled value="">Elija una opción</option>
                                      <option value="">{{ 'TODOS' }}</option>
                                      <option value="adolescentes">{{ 'ADOLESCENTES' }}</option>
                                      <option value="adultos">{{ 'ADULTOS' }}</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-lg-3" width='100%'>
                                    <label class="form-control-label">Estatus semaforo:</label>
                                    <div class="form-group" width='100%'>
                                        <select class="form-control-lg select2 valid" width='100%' autocomplete="off" id="estatus_color">
                                            <option selected disabled value="">Elija una opción</option>
                                            <option value="-">{{ 'TODOS' }}</option>
                                            <option value="verde">{{ 'Atendidas' }}</option>
                                            <option value="amarillo">{{ 'Visto,sin resolver' }}</option>
                                            <option value="rojo">{{ 'Pendiente' }}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="sec_ajax(1);">Filtrar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="pagination-wrapper justify-content-between">
                <ul class="pagination mg-b-0">
                  <li class="page-item">
                    <a class="page-link primera" href="javascript:void(0)" aria-label="Last" onclick="sec_ajax(1)">
                      <i class="fa fa-angle-double-left"></i>
                    </a>
                  </li>
                  <li class="page-item">
                    <a class="page-link anterior" href="javascript:void(0)" aria-label="Next" onclick="sec_ajax(1)">
                      <i class="fa fa-angle-left"></i>
                    </a>
                  </li>
                </ul>
                <ul class="pagination mg-b-0">
                  <li class="page-item">Página <span class="pagina">1</span> de <span class="total-paginas">1</span></li>
                </ul>
    
                <ul class="pagination mg-b-0">
                  <li class="page-item">
                    <a class="page-link siguiente" href="javascript:void(0)" aria-label="Next" onclick="sec_ajax(1)">
                      <i class="fa fa-angle-right"></i>
                    </a>
                  </li>
                  <li class="page-item">
                    <a class="page-link ultima" href="javascript:void(0)" aria-label="Last" onclick="sec_ajax(1)">
                      <i class="fa fa-angle-double-right"></i>
                    </a>
                  </li>
                </ul>
            </div>

            <div id="table-solicitudes" class="mg-b-20 mg-t-20">
                <table id="solicitudesTable" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>
                            <th class="acciones" name="acciones">Acciones</th>
                            <th class="semaforo" name="semaforo"> </th>
                            <th style="cursor:pointer" class="id_solicitud" name="id_solicitud">Datos Solicitud</th>
                            {{-- <th style="cursor:pointer" class="folio_solicitud" name="folio_solicitud">Folio de solicitud</th> --}}
                            <th style="cursor:pointer" class="fecha_registro" name="fecha_registro">Fecha/hora de registro
                            </th>
                            {{-- <th style="cursor:pointer" class="folio_carpeta" name="folio_carpeta">Carpeta Judicial</th> --}}
                            <th style="cursor:pointer" class="carpeta-investigacion" name="carpeta-investigacion">Carpetas
                            </th>
                            <th style="cursor:pointer" class="tipo_audiencia" name="tipo_audiencia">Tipo de Audiencia</th>
                            {{-- <th style="cursor:pointer" class="estado_solicitud" name="estado_solicitud">Estado</th> --}}
                            <th style="cursor:pointer" class="materia_destino" name="materia_destino">Materia destino</th>
                            <th style="cursor:pointer" class="estatus_urgente" name="estatus_urgente">Urgente</th>
                            <th style="cursor:pointer" class="totales_tareas" name="estatus_urgente">Totales</th>
                            {{-- <th style="cursor:pointer" class="estatus_urgente" name="estatus_urgente">Urgente</th>
                            <th style="cursor:pointer" class="responsable" name="responsable">Responsable</th> --}}
                        </tr>
                    </thead>
                    <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper justify-content-between">
                <ul class="pagination mg-b-0">
                  <li class="page-item">
                    <a class="page-link primera" href="javascript:void(0)" aria-label="Last" onclick="sec_ajax(1)">
                      <i class="fa fa-angle-double-left"></i>
                    </a>
                  </li>
                  <li class="page-item">
                    <a class="page-link anterior" href="javascript:void(0)" aria-label="Next" onclick="sec_ajax(1)">
                      <i class="fa fa-angle-left"></i>
                    </a>
                  </li>
                </ul>
                <ul class="pagination mg-b-0">
                  <li class="page-item">Página <span class="pagina">1</span> de <span class="total-paginas">1</span></li>
                </ul>
    
                <ul class="pagination mg-b-0">
                  <li class="page-item">
                    <a class="page-link siguiente" href="javascript:void(0)" aria-label="Next" onclick="sec_ajax(1)">
                      <i class="fa fa-angle-right"></i>
                    </a>
                  </li>
                  <li class="page-item">
                    <a class="page-link ultima" href="javascript:void(0)" aria-label="Last" onclick="sec_ajax(1)">
                      <i class="fa fa-angle-double-right"></i>
                    </a>
                  </li>
                </ul>
            </div>

        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

        <input type="hidden" id="pagina_actual2" value="1">
        <input type="hidden" id="paginas_totales2" value="1">


        <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;"></div>
    </div>

    <!-- Modal documentos -->
    <div class="modal fade" id="modal_docs">
        <div class="modal-dialog" style="width:430px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Historial de documentos</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body" id="modal_docs_contenido">

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="cerrar_modal('modal_docs')" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal flujo -->
    <div class="modal fade" id="modal_flujo" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="width:740px;">
                <div class="modal-header">
                    <h5 class="modal-title">Flujo de la solicitud</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body" id="modal_flujo_contenido">
                    <table id="flujos" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid"
                        aria-describedby="example_info">
                        <thead style="background-color: #848F33; color: #FFF;" class="tx-center">
                            <tr>
                                <td class="estatus_">Estatus</td>
                                <td class="responsable_">Responsable</td>
                                <td class="comentarios_">Comentarios</td>
                                <td class="horafecha_">Hora/Fecha</td>
                            </tr>
                        </thead>
                        <tbody id="body-table2" class="items-agregados" style="width: 100%; text-align: center;">
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrapper justify-content-between" id="flechas">

                </div>
                <div class="modal-footer">

                    <button type="button" onclick="cerrar_modal('modal_flujo')" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambio de carpeta -->
  <div id="ModalCambiarCarpeta" class="modal fade" data-keyboard="false">
    <div class="modal-dialog modal-dialog-medium" role="document">
      <div class="modal-content bd-0 tx-14">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="tituloCambiarFolio">Cambiar folio de carpeta</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Folio Actual</label>
                <input type="text" class="form-control"  id="folio_actual" name="folio_actual" disabled>
              </div>
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Nuevo folio</label>
                <input type="text" class="form-control"  id="nuevo_folio" name="nuevo_folio">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="" onclick="">Cambiar</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('seccion-estilos')
    <link href="{{ asset('/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/solicitudes/consulta_solicitudes.css">

    <style>
        .flex-container {
            display: flex;
            justify-content: center;

        }

        .flex-container>div {
            margin: 1px;
            padding: 1px;
            font-size: 16px;
        }

        @media screen and (max-width: 600px) {}

        #accordion .card {
            border: none !important;
        }

        #accordion .card .card-header {
            width: 75px !important;
            border: 1px solid #dee2e6 !important;
        }

        #accordion .card .card-header a {
            padding: 10px !important;
        }

        #collapseSearchAdvance,
        #collapseSearchAdvance {
            border: 1px solid #eee !important;
            background: #f8f9fa;
        }

        #accordion a::before {
            top: 10px !important;
        }

        #modalAdjuntarDocumento .modal-dialog {
            height: 95%;
            min-width: 90%;
        }


        #modalAdjuntarDocumento .modal-body {
            height: 95%;
            min-width: 90%;
        }

        #modalAdjuntarDocumento .modal-content {
            height: 95%;
            min-width: 90%;
        }

        #documentoPDFrame {
            min-height: 100%;
            min-width: 100%;

        }

        #modal_flujo .modal-dialog {
            height: 95%;
            min-width: 90%;
        }


        #modal_flujo .modal-body {
            height: 95%;
            min-width: 90%;
        }

        #modal_flujo .modal-content {
            height: 95%;
            min-width: 90%;
        }

        table {
            width: calc(100% - 2px) !important;
            border-bottom: 1px solid #f0f2f7;
        }

        td,
        th {
            padding-left: 1px !important;
            padding-right: 3px !important;
            padding-top: 0px;
            padding-bottom: px !important;
            border-bottom: 1px solid #f0f2f7;
            max-width: 110px !important;
            position: relative;
        }

        span.select2-container.select2-container--default.select2-container--open {

            width: '100%';
        }

        .datepicker-container {
            z-index: 1110;
        }

        .abs-center {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .iconify {
            display: inline-block;
            text-align: left;
            vertical-align: top;
        }

        .fecha {
            min-width: 111px !important;
        }

        .expediente {
            min-width: 80px !important;
        }

        .ref {
            min-width: 80px !important;

        }

        .id_solicitud {
            min-width: 165px !important;
        }

        .folio_solicitud {
            min-width: 130px !important;
        }

        .materia_destino {
            min-width: 120px !important;
        }

        .tipo_audiencia {
            min-width: 200px !important;
        }

        .semaforo {
            min-width: 50px !important;
            text-align: center;
            size: 20px;
            vertical-align: top;
        }

        .carpeta-investigacion {
            min-width: 250px !important;
        }

        .totales_tareas {
            min-width: 183px !important;
        }

        .fecha_registro {
            min-width: 180px !important;
        }

        .folio_carpeta {
            min-width: 130px !important;
        }

        .estatus_urgente {
            min-width: 100px !important;
        }

        .estatus_ {
            min-width: 160px !important;
        }

        .responsable_ {
            min-width: 160px !important;
        }

        .comentarios_ {
            min-width: 230px !important;
        }

        .horafecha_ {
            min-width: 160px !important;
        }

        .td-title {
            background-color: #f0f2f7 !important;
            min-width: 120px !important;
            border-color: #f0f2f7 !important;
            max-height: 5px !important;
            padding: 3px 5px 3px 5px !important;
        }

        .th-title {
            column-span: 100%;
            background-color: #f0f2f7 !important;
            min-width: 130px !important;
            border-color: #f0f2f7 !important;
            max-height: 5px !important;
            padding: 3px 0px 3px 5px !important;
            align: center !important;
        }

        .slim-navbar {
            z-index: 1000 !important;
        }

        table#datosolicitud tr td:nth-child(2) {
            padding-left: 5px !important;
        }

        .dep {
            min-width: 115px !important;
        }

        .concepto {
            min-width: 86px !important;
        }

        .importe {

            min-width: 80px !important;
        }

        .moneda {
            min-width: 100px !important;
        }

        .estatus {
            min-width: 80px !important;
        }

        .acciones {
            min-width: 200px !important;

        }

        .estado_solicitud {
            min-width: 110px !important;
        }

        td.acciones {
            font-size: 25px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            display: inline-block;

        }

        td.acciones a {
            display: inline;
            margin-left: 20%;
            cursor: pointer;
            text-align: left;
        }

        td.acciones a:first-child {
            margin-left: 0;
            text-align: left;
        }

        .ul {
            list-style: none;
        }

        .depo {
            min-width: 80px !important;
        }

        table {

            width: calc(100% - 2px) !important;
        }

        table a:hover {
            font-weight: bold;
        }

        span.select2-container {
            width: '100%';
        }

        /* .active:after {
            content: "\2212";
        } */

        .accordion {
            /* background-color: #eee; */

            color: #444;
            cursor: pointer;
            padding: 10px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active,
        .accordion:hover {
            /*  background-color: #ccc; */
        }


        .panel {

            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: 0.2s ease-out;
        }

        .molde {
            width: 100%;
            height: 80px;
            padding: 0 4px;
            background: #fff;
        }

        .soli {
            width: 100%;
            padding: 2px 0;
            background: #dfe6ad;
            color: #757575;
            font-size: 0.82em;
            font-weight: bold;
            text-align: center;
        }

        .soli_e {
            font-size: 0.8em;
            color: #a9a9a9;
            padding-top: 10px;
            text-align: center;
            width: 100%;
        }

        .soli_fs {
            width: 100%;
            color: green;
            text-align: right;
            font-size: 0.61em;
            font-weight: bold;
            padding: 10px 0 0 5px;
        }

        .soli_fs span {
            color: #a9a9a9;
            font-size: 0.92em;
            margin: 0 1%;
        }

        td {
            padding: 0 !important;
            display: table-cell !important;
            vertical-align: middle !important;
        }

        .molde2 {
            width: 100%;
            height: 80px;
            padding: 0 10px;
        }

        .molde3 {
            width: 100%;
            height: 80px;
            padding: 10px;
        }

        .barra_l {
            border-left: 3px solid #848F33 !important;
            padding: 4px;
        }

        .barra_l ul {
            width: 100%;
            padding: 0;
            text-align: left;
            margin-left: 2%;
        }

        .barra_l ul li {
            list-style: none;
            margin-bottom: 4px;
        }

        .barra_l ul li ul li {
            list-style: none;
        }
        ::-webkit-scrollbar {
            height: 8px;  
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background: #D7DCE1; 
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a8acaf; 
        }
        ::-webkit-scrollbar-track {
            background: #fff 
        }
  </style>
@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno['version_pages']['version'] }}/lib/jquery-ui/js/jquery-ui.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/moment/js/moment.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script src="/js/solicitudes/consulta_solicitudes.js"></script>
@endsection

@section('seccion-scripts-functions')
    <script>
        let solicitudes = [],
        tabla_direcciones = [],
        tabla_alias = [],
        tabla_contacto = [],
        tabla_correo = [],
        id_unidad_g = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp,
        tabla_datos = [],
        tabla_delitos = [],
        tabla_no_relacionados = [],
        datatable = null,
        solicitud_seleccionada;

        var solicitudes_ = [];

        const permiso_turnar =  @if( isset($permisos[77]) and $permisos[77] == 1 ) true; @else false; @endif

        $(function() {
            'use strict';

            // Select2
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });

            sec_ajax(1);

            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true
            });

            $(".fc-datepicker").datepicker("option", "dd-mm-yy");

            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '< Ant',
                nextText: 'Sig >',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov',
                    'Dic'
                ],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };

            $.datepicker.setDefaults($.datepicker.regional['es']);
            $(function() {
                $("#fc-datepicker").datepicker();
            });

            //focus textfiled
            $('.form-layout .form-control').on('focusin', function() {
                $(this).closest('.form-group').addClass('form-group-active');
            });

            $('.form-layout .form-control').on('focusout', function() {
                $(this).closest('.form-group').removeClass('form-group-active');
            });

            setTimeout(function() {
                $('#modal_loading').modal('hide');
            }, 1000);

        });

        function sec_ajax(pagina) {

            $('#modal_loading').modal('show');

            let body = "";
        
            registros_por_pagina = 10;

            $('#pagina_actual').val(pagina);
            $('#numeropagina').val(pagina);
            $('.pagina_actual_texto').html(pagina);
            
            var data = {
                id_solicitud: $("#idsolicitud").val(),
                folio_solicitud: $("#foliosolicitud").val(),
                carpeta_investigacion: $("#carpetainvestigacion").val(),
                folio_carpeta: $("#foliocarpeta").val(),
                fecha_recepcion: get_date($("#fechasolicitud").val()),
                fecha_recepcionh: get_date($("#fechasolicitudh").val()),
                estatus_flujo_actual: $("#estatusactual").val(),
                estatus_urgente: $("#estatusurgente").val(),
                materia_destino: $("#materiadestino").val(),
                color: $("#estatus_color").val(),
                id_unidad_gestion: id_unidad_g == 0 ? "" : id_unidad_g,
                pagina: pagina,
                registros_por_pagina: 10,
            };


            $.ajax({
                type: 'GET',
                url: '/public/obtener_solicitudes',
                data: data,
                success: function(response) {
                    if (response.status == 100) {
                        console.log('solicitudes', response.response);
                        

                        $('.anterior').attr('onclick', `sec_ajax( ${(pagina - 1 ) < 1 ? 1 : (pagina - 1)} )`);
                        $('.siguiente').attr('onclick', `sec_ajax( ${ (pagina + 1 ) >= (response.response_pag.paginas_totales) ? (response.response_pag.paginas_totales) : (pagina + 1) } )`);
                        $('.ultima').attr('onclick', `sec_ajax(${response.response_pag.paginas_totales})`);
                        $('.pagina').html(pagina);
                        $('.total-paginas').html(response.response_pag.paginas_totales);
                        
                        solicitudes_.length = 0;
                        var datos = response.response;
                        solicitudes_ = response.response;
                        let color;
                        let title;
                        

                        var body = new $('#solicitudesTable').dataTable({
                            processing: true,
                            data: datos,
                            columns: [
                                {
                                    data: "id_solicitud",
                                    "render": function(data, type, row, meta) {

                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;';
                                        }

                                        return (
                                            `
                                            <div class="molde3" style="${sin_tareas}">
                                                @if( isset($permisos[4]) and $permisos[4] == 1 ) <i class="icon ion-ios-information" title="Información" style="cursor: pointer" onclick="ver_solicitud(${data})" id="informacion"></i> @endif
                                                @if( isset($permisos[3]) and $permisos[3] == 1 ) <i class="icon ion-edit" data-target="#modal_loading" data-toggle="modal" title="Modificar"  onclick=window.location.href="editar_solicitud_audiencia_inicial/${data}" style="cursor: pointer" id="editar"></i> @endif
                                                @if( isset($permisos[1]) and $permisos[1] == 1 ) <i class="icon ion-ios-download-outline"  title="Descargar PDF" style="cursor: pointer" onclick="descargar_pdf(${data})" id="pdf"></i> @endif
                                                @if( isset($permisos[2]) and $permisos[2] == 1 ) <i class="icon ion-code-download" title="Descargar XML" style="cursor: pointer" data-id="${data}" onclick="descargar_xml(${data})" id="descargar_xml"></i> @endif
                                                @if( isset($permisos[15]) and $permisos[15] == 1 ) <i class="icon ion-ios-list-outline" title="Consulta Log" style="cursor: pointer" onclick="ver_log(${data})" id="log"></i> @endif
                                                @if( isset($permisos[16]) and $permisos[16] == 1 ) <i class="icon ion-android-map" title="Consulta Flujo" style="cursor: pointer" onclick="ver_flujo(${data})" id="flujo"></i> @endif
                                                @if( isset($permisos[16]) and $permisos[16] == 1 ) <i class="icon ion-edit placeholder-icon" title="Cambiar Carpeta" style="cursor: pointer" onclick="cambiarCarpeta(${data})" id="editCarpeta"></i> @endif
                                            </div>
                                            `
                                        );
                                    }
                                },
                                {
                                    data: "estatus_semaforo",
                                    name: "estatus_semaforo",
                                    "render": function(data, type, row, meta) {
                                        if (data == "amarillo") {
                                            color = "#ffc40c";
                                            title = "Visto, en espera de atención";

                                        } else if (data == "verde") {
                                            color = "green";
                                            title = "Atendido";
                                        } else if (data == "rojo") {
                                            color = "red";
                                            title = "Visualización pendiente";
                                        }
                                        
                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;';
                                        }

                                        return( `<div class="molde3" style="${sin_tareas}">
                                            <i class="fas fa-lightbulb-o fa-lg" style="color:${color}" title="${title}" text-align="right" aria-hidden="true"></i>
                                        </div>`);

                                    }
                                },
                                {
                                    data: "id_solicitud",
                                    title: "Datos de Solicitud",
                                    name: "id_solicitud",
                                    "render": function(data, type, row, meta) {

                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;';
                                        }
    
                                        return (`<div class="molde" style="${sin_tareas}">
                                                    <div class="soli">${data}</div>
                                                    <div class="soli_e">${row.estatus_flujo_actual}</div>
                                                    <div class="soli_fs"><span>Folio </span>${row.folio_solicitud}</div>
                                                </div>`);
                                    }
                                },
                                {
                                    data: "fecha_solicitud",
                                    title: "Fecha/hora de registro",
                                    name: "fecha_solicitud",
                                    "render": function(data, type, row, meta) {
                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;';
                                        }

                                        return `<div class="molde3" style="${sin_tareas}">${data}</div>`;
                                    }
                                },
                                {
                                    data: "carpeta_investigacion",
                                    title: "Carpetas",
                                    name: "carpeta_investigaciones",
                                    "render": function(data, type, row, meta) {

                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;';
                                        }

                                        return (`<div class="molde3" style="${sin_tareas}">
                                                    <div class="barra_l">
                                                        <ul style="margin: 1.3% 0 1.3% 2%;">
                                                            <li style="font-size: 0.8em;"><strong>Carpeta Judicial:</strong> ${row.folio_carpeta ?? ""} </li>
                                                            <li style="font-size: 0.8em;"><strong>Carpeta Inv.:</strong>
                                                                <ul>
                                                                    <li style="font-size: 0.97em;">${data}</li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>`);
                                    }
                                },
                                {
                                    data: "tipo_audiencia",
                                    title: "Tipo de Audiencia",
                                    name: "tipo_audiencia",
                                    "render": function(data, type, row, meta) {
                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;';
                                        }

                                        return `<div class="molde3" style="${sin_tareas}">${data}</div>`;
                                    }
                                },
                                {
                                    data: "materia_destino",
                                    title: "Materia Destino",
                                    name: "materia_destino",
                                    "render": function(data, type, row, meta) {
                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;';
                                        }

                                        return `<div class="molde3" style="${sin_tareas}">${data}</div>`;
                                    }
                                },
                                {
                                    data: "estatus_urgente",
                                    title: "Urgente",
                                    name: "estatus_urgente",
                                    "render": function(data, type, row, meta) {
                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;';
                                        }

                                        return `<div class="molde3" style="${sin_tareas}">${data}</div>`;
                                    }
                                },
                                {
                                    data: "id_solicitud",
                                    title: "Tareas Totales",
                                    "render": function(data, type, row, meta) {
                                        var stilo = '';
                                        var button_sin_tareas = '';
                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            stilo = 'color: #404040; font-size:1.3em; font-weight:bold';
                                            sin_tareas = '';
                                            button_sin_tareas = '';
                                        }else{
                                            stilo = 'color: #cb1b10; font-size:1.3em; font-weight:bold';
                                            sin_tareas = 'background: #fff0ec;'
                                            button_sin_tareas = `<i title="Generar tareas" class="fas fa-sync-alt" style="color: #848f33; cursor: pointer; margin-left: 15%;" onclick="generarTareas('solicitud', ${data})"></i>`;
                                        }
                                        return (`<div class="molde3" style="${sin_tareas}">
                                                    <div class="barra_l">
                                                        <ul style="margin: 1.3% 0 1.3% 2%;">
                                                            <li style="font-size: 0.8em;">
                                                                <strong>Generadas:</strong> <span style="${stilo}">${row.tareas_generadas}${button_sin_tareas}</span>
                                                                <div style="cursor:pointer;" onclick="modalVerDetallesTareas(${meta.row})">
                                                                    Ver detalles
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>`);
                                    }
                                },
                            ],
                            colReorder: {
                                fixedColumnsLeft: 2
                            },
                            bDestroy: true,
                            colReset: true,
                            paging: false,
                            ordering: true,
                            columnDefs: [{
                                orderable: false,
                                targets: 0
                            }],
                            info: false,
                            search: false,
                            filter: false,
                            stateSave: true,
                            //stateClear: false,
                            //stateLoaded: true,
                        });
                        datatable = body;

                        $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                        $('#paginas_totales').val(response.response_pag['paginas_totales'])

                    } else {

                        $('.anterior').attr('onclick', `sec_ajax(1)`);
                        $('.siguiente').attr('onclick', `sec_ajax(1)`);
                        $('.ultima').attr('onclick', `sec_ajax(1)`);
                        $('.pagina').html(0);
                        $('.total-paginas').html(0);

                        body = `<tr>
                                    <td colspan="5">
                                    <td colspan="5"><h3>Sin datos relacionados</h3></td>
                                <tr>`;
                        $('#body-table1').html(body);

                    }

                    setTimeout( () => {
                        $('#modal_loading').modal('hide');
                    },600);
                }
            });
            

        }

        function ver_log(valor) {
            var id_solicitud = valor;
            $.ajax({
                type: "GET",
                url: "public/ver_log/" + id_solicitud,
                data: {},
                success: function(response) {
                    var win = window.open('http://172.19.228.38:8083/archivo.log', '_blank');
                },
            });
        }

        function descargar_consulta(extension) {
            console.log("entraste a generar :" + extension);

            let filtro = JSON.parse($("#filtro_consulta").val());
            let orden_columnas = get_orden_columnas();

            $('#modal_loading').modal('show');

            $.ajax({
                type: 'GET',
                url: '/exportar_busqueda_solicitudes',
                data: {
                    id_solicitud: filtro.id_solicitud,
                    folio_solicitud: filtro.folio_solicitud,
                    carpeta_investigacion: filtro.carpeta_investigacion,
                    folio_carpeta: filtro.folio_carpeta,
                    fecha_recepcion: filtro.fecha_recepcion,
                    fecha_recepcionh: filtro.fecha_recepcionh,
                    estatus_flujo_actual: filtro.estatus_flujo_actual,
                    estatus_urgente: filtro.estatus_urgente,
                    materia_destino: filtro.materia_destino,
                    pagina: filtro.pagina,
                    registros_por_pagina: filtro.registros_por_pagina,
                    extension: extension,
                    orden_columnas: orden_columnas,
                },
                success: function(data) {
                    console.log(data);
                    if (data.status == 100) {
                        let tag_a = $("<a>");
                        tag_a.attr("href", data.file);
                        $("body").append(tag_a);
                        tag_a.attr("download", data.filename);
                        tag_a[0].click();
                        tag_a.remove();
                    } else {
                        alert(data.message);
                    }

                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                }
            });
        }

        function exportar_excel_solicitudes(pagina){
            $('#modal_loading').modal('show');

            registros_por_pagina = 10;

            $('#pagina_actual').val(pagina);
            $('#numeropagina').val(pagina);
            $('.pagina_actual_texto').html(pagina);

            let id_solicitud = ""
            const format1 = "YYYY-DD-MM"

            var date1 = new Date($("#fechasolicitud").val());
            fechaini = moment(date1).format(format1);
            if (fechaini === "Invalid date") {
                fechaini = '';
            }
            var date2 = new Date($("#fechasolicitudh").val());
            fechafin = moment(date2).format(format1);

            if (fechafin === "Invalid date") {
                fechafin = '';
            }

            $("#filtro_consulta").val(
                JSON.stringify({
                    id_solicitud: $("#idsolicitud").val(),
                    folio_solicitud: $("#foliosolicitud").val(),
                    carpeta_investigacion: $("#carpetainvestigacion").val(),
                    folio_carpeta: $("#foliocarpeta").val(),
                    fecha_recepcion: fechaini,
                    fecha_recepcionh: fechafin,
                    estatus_flujo_actual: $("#estatusactual").val(),
                    estatus_urgente: $("#estatusurgente").val(),
                    materia_destino: $("#materiadestino").val(),
                    color: $("#estatus_color").val(),
                    pagina: 1,
                    registros_por_pagina: 1000000
                })
            );

            $.ajax({
                type: 'GET',
                url: '/public/exportar_solicitudes_excel',
                data: {
                    id_solicitud: $("#idsolicitud").val(),
                    folio_solicitud: $("#foliosolicitud").val(),
                    carpeta_investigacion: $("#carpetainvestigacion").val(),
                    folio_carpeta: $("#foliocarpeta").val(),
                    fecha_recepcion: fechaini,
                    fecha_recepcionh: fechafin,
                    estatus_flujo_actual: $("#estatusactual").val(),
                    estatus_urgente: $("#estatusurgente").val(),
                    materia_destino: $("#materiadestino").val(),
                    color: $("#estatus_color").val(),
                    id_unidad_gestion: id_unidad_g == 0 ? "" : id_unidad_g,
                    pagina: pagina,
                    // registros_por_pagina:$('.pagina_actual_texto').val(),
                    registros_por_pagina: 1000000,
                },

                success: function(response) {

                    setTimeout( () => { $('#modal_loading').modal('hide'); },500);

                    if (response.status == 100) {
                        console.log(response.response);
                        window.open(response.response);
                    } else {
                        console.log(response.response);
                        error('', response.response, '');
                    }
                }
            });


        }

        function get_orden_columnas() {
            let campos_title = [{
                    campo: "id_solicitud",
                    titulo: "ID Acuse"
                },
                {
                    campo: "estatus_semaforo",
                    titulo: "Semaforo"
                },
                {
                    campo: "folio_solicitud",
                    titulo: "Folio de Solicitud"
                },
                {
                    campo: "fecha_solicitud",
                    titulo: "Fecha/hora de registro"
                },
                {
                    campo: "folio_carpeta",
                    titulo: "Carpeta Judicial"
                },
                {
                    campo: "carpeta_investigacion",
                    titulo: "Carpeta de Investigación"
                },
                {
                    campo: "tipo_audiencia",
                    titulo: "Tipo de Audiencia"
                },
                {
                    campo: "estatus_flujo_actual",
                    titulo: "Estado"
                },
                {
                    campo: "materia_destino",
                    titulo: "Materia Destino"
                },
                {
                    campo: "estatus_urgente",
                    titulo: "Urgente"
                },
            ];
            let columnas = [];
            $('#solicitudesTable thead tr th').each(function() {
                let columna = campos_title.filter(index => index.titulo == ($(this).attr('name') == 'semaforo' ?
                    'Semaforo' : $(this).text()));
                if (columna.length) {
                    columnas.push({
                        titulo: columna[0].titulo,
                        campo: columna[0].campo
                    });
                }
            });
            return columnas;
        }

        function generarTareas(tipo, id_solicitud){
            $.ajax({
                type: "POST",
                url: "public/generarTarea",
                data: {
                    tipo:tipo,
                    id_solicitud
                },
                success: function(response) {
                    console.log(response);
                    if(response.status == 100){
                        console.log('ids',response.response);
                        sec_ajax();
                    }else{
                        error('', response.message);
                    }
                },
            });
        }

        function ver_documento(valor, valor2) {
            var id_solicitud = valor;
            var version = valor2;

            $.ajax({
                type: "GET",
                url: "public/ver_documentos/" + id_solicitud + "/" + version,
                data: {},
                success: function(response) {
                    console.log(response);

                    var extension = response.extension;
                    var url = "http://155.94.139.2:8083/temporal." + extension;
                    console.log(url);
                    window.open(url, '_blank');
                },
            });
        }

        function turnar(id_solicitud) {

            $('#modal-ver').modal('hide');
            $('#modal_loading').modal('show');
            // $('#boton').html(`<button type="button" onclick="turnar(${id_solicitud ?? ""})" class="btn btn-success" data-dismiss="modal">Turnar</button>`);
            
            $.ajax({
                type: 'PUT',
                url: '/public/turnar_carpeta/5/' + id_solicitud,
                data: { },
                success: function(response) {                
                    if ( response.status == 100 ) 
                        $('#modalOkTurnado').modal('show');
                    else 
                    error('', response.message, 'modal-ver');
                    
                    setTimeout( () => { 
                    $('#modal_loading').modal('hide');
                    },400); 
                }
            });
        }

        function descargar_pdf(id_solicitud) {

            $.ajax({
                type: 'GET',
                url: 'public/descargar_pdf/' + id_solicitud,
                data: {

                },
                success: function(response) {
                    console.log(response);
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);

                    if (response.response) {
                        
                        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

                            window.open(response.response, '_blank');

                        } else { 

                            $('#documentoPDFrame').attr('src', response.response);
                            mostrarModalDocumento();

                        }

                    } else if (response.status == 0) {
                        $('#modalFail').modal('show');
                    }
                }
            });
        }

        function mostrarModalDocumento() {

            $('#modalAdjuntarDocumento').modal('show');
        }

        function descargar_xml(id_solicitud) {
            $.ajax({
                type: 'GET',
                url: 'public/descargar_xml/' + id_solicitud,
                data: {

                },
                success: function(response) {
                    console.log(response);
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if (response.status == 100) {
                        var win = window.open(response.response, '_blank');
                    } else {
                        error('', response.message);
                    }
                }
            });
        }

        function ver_documentos(valor) {
            var id_solicitud = valor;
            $.ajax({
                type: "GET",
                url: "public/ver_documentos/" + id_solicitud + "/todas",
                data: {},
                success: function(response) {
                    $("#modal_docs").modal("show");

                    var a = 0;
                    var count = response.length;
                    var contenido = "<table class='table table-hover'><thead><tr style='text-align: center;'>" +
                        "<th>Documento</th><th>Tipo</th><th>Tamaño</th><th>Fecha de carga</th></thead></tr>";
                    var archivo = "";
                    var version = "";
                    var creacion = "";
                    var nombre_archivo = "";
                    var tamanio = "";
                    var documento = "";
                    if (count > 0) {
                        while (a <= count - 1) {
                            archivo = response[a]['nombre_archivo'].split('.');
                            version = response[a]['id_version'];
                            creacion = response[a]['fecha_creacion'];
                            nombre_archivo = response[a]['nombre_archivo'];
                            tamanio = response[a]['tamanio'];
                            documento = archivo[1];

                            if (documento == 'doc' || documento == 'docx') {
                                contenido +=
                                    "<tr style='text-align: center;'><td style='cursor: pointer' title='Ver Documento' onclick='ver_documento(" +
                                    id_solicitud + "," + version +
                                    ");'><i class='fas fa-file-word fa-2x' title='" + nombre_archivo +
                                    "'></i></td><td>" +
                                    documento + "</td><td>" + tamanio + " kB</td><td>" + creacion +
                                    "</td></tr>";
                            }
                            if (documento == 'pdf') {
                                contenido +=
                                    "<tr style='text-align: center;'><td style='cursor: pointer' title='Ver PDF' onclick='ver_documento(" +
                                    id_solicitud + "," + version +
                                    ");'><i class='fas fa-file-pdf fa-2x' title='" + nombre_archivo +
                                    "'></i></td><td>" +
                                    documento + "</td><td>" + tamanio + " kB</td><td>" + creacion +
                                    "</td></tr>";
                            }
                            if (documento == 'jpg' || documento == 'png') {
                                contenido +=
                                    "<tr style='text-align: center;'><td style='cursor: pointer' title='Ver IMAGEN' onclick='ver_documento(" +
                                    id_solicitud + "," + version +
                                    ");'><i class='fas fa-file-images fa-2x' title='" + nombre_archivo +
                                    "'></i></td><td>" +
                                    documento + "</td><td>" + tamanio + " kB</td><td>" + creacion +
                                    "</td></tr>";
                            }

                            a++;
                        }

                    } else {
                        contenido +=
                            "<tr style='text-align: center;'><td colspan='4'>No se encontraron documentos</td></tr>";

                    }
                    contenido += "</table>";
                    $("#modal_docs_contenido").html(contenido);
                },
            });
        }

        function ver_flujo(valor, pagina_accion, valor3) {

            if (valor3 == 0) {
                $('#pagina_actual2').val(1);
            }

            if (pagina_accion > 0) {
                $(document).ready(function() {
                    $(".nav-tabs a").click(function() {
                        $(this).tab('show');
                    });
                });
                pagina = parseInt($('#pagina_actual2').val());
                tope = parseInt($('#paginas_totales2').val());

                registros_por_pagina = 10;
                if (pagina_accion == 1) {
                    pagina = 1;
                    $('#pagina_actual2').val(pagina);
                } else if (pagina_accion == 3 && pagina < tope) {
                    pagina = pagina + 1;
                    $('#pagina_actual2').val(pagina);
                } else if (pagina_accion == 2 && pagina > 1) {
                    pagina = pagina - 1;
                    $('#pagina_actual2').val(pagina);
                } else if (pagina_accion == 4) {
                    pagina = $('#paginas_totales2').val();
                }
            } else {

                var flechas = "<ul class='pagination mg-b-0'>" +
                    "<li class='page-item'>" +
                    "<a class='page-link' href='javascript:void(0);' onclick='ver_flujo(" + valor +
                    ",1,1);' value='primera' aria-label='Last'>" +
                    "<i class='fa fa-angle-double-left'></i>" +
                    "</a>" +
                    "</li>" +
                    "<li class='page-item'>" +
                    "<a class='page-link' href='javascript:void(0);' onclick='ver_flujo(" + valor +
                    ",2,1);' value='atras' aria-label='Next'>" +
                    "<i class='fa fa-angle-left'></i>" +
                    "</a>" +
                    "</li>" +
                    "</ul>" +
                    "<div id='pag_actual'></div>" +
                    "<ul class='pagination mg-b-0'>" +
                    "<li class='page-item'>" +
                    "<a class='page-link' href='javascript:void(0);' onclick='ver_flujo(" + valor +
                    ",3,1);' value='avanzar' aria-label='Next'>" +
                    "<i class='fa fa-angle-right'></i>" +
                    "</a>" +
                    "</li>" +
                    "<li class='page-item'>" +
                    "<a class='page-link' href='javascript:void(0);' onclick='ver_flujo(" + valor +
                    ",4,1);' value='ultima' aria-label='Last'>" +
                    "<i class='fa fa-angle-double-right'></i>" +
                    "</a>" +
                    "</li>" +
                    "</ul>";

                $("#flechas").html(flechas);
                pagina = parseInt($('#pagina_actual2').val());
            }

            var id_solicitud = valor;
            $.ajax({
                type: "GET",
                url: "public/ver_flujo/" + id_solicitud,
                data: {
                    pagina: pagina,
                    registros_por_pagina: 4
                },
                success: function(response) {
                    if (response.status == 100) {

                        $("#modal_flujo").modal("show");

                        var contenido = response.response;
                        var count = contenido.length;
                        var a = 0;
                        var responsable = "";
                        var estatus = "";
                        var comentarios = "";
                        var fecha = "";
                        var body = "";
                        var response_pag = response.response_pag;
                        var paginas_totales = response_pag['paginas_totales'];

                        $("#paginas_totales2").val(paginas_totales);

                        while (a <= count - 1) {

                            if (contenido[a]['nombres'] != null || contenido[a]['apellido_paterno'] != null ||
                                contenido[a]['apellido_materno'] != null) {
                                responsable = contenido[a]['nombres'] + " " + contenido[a]['apellido_paterno'] +
                                    " " + contenido[a]['apellido_materno'];
                            } else {
                                responsable = "Desconocido."
                            }

                            estatus = contenido[a]['estatus_actividad'];
                            fecha = contenido[a]['creacion'];
                            comentarios = contenido[a]['comentarios'];
                            if (comentarios) {
                                var comentarios = comentarios.split('"');
                                comentarios = comentarios[3];
                            } else {
                                comentarios = "Sin comentarios."
                            }

                            var fecha = fecha.split('-');
                            var dia_hora = fecha[2].split(' ');
                            var dia = dia_hora[0];
                            var hora = dia_hora[1];

                            fecha = hora + " / " + dia + "-" + fecha[1] + "-" + fecha[0];

                            body += "<tr><td>" + estatus + "</td><td>" + responsable + "</td><td>" +
                                comentarios + "</td><td>" + fecha + "</td></tr>";

                            a++;
                        }
                        $('#body-table2').html(body);
                        $('#pag_actual').html("Pagina " + pagina + " de " + paginas_totales);

                    }
                },
            });
        }
        function cambiarCarpeta(valor){
            $('#ModalCambiarCarpeta').modal('show');
            $('#folio_actual').val(valor);
        }

        function cerrar_modal(valor) {
            $("#" + valor).modal('hide');
            $('body').removeClass('modal-open');

        }
        
        function modalVerDetallesTareas(__index__){
            var info = solicitudes_[__index__];
            var html = '';
            $('#bodyVerDetallesTareas').html('');
            
            $.ajax({
                type: "GET",
                url: "public/correos_enviados",
                data: {
                    id_solicitud:info.id_solicitud,
                    tipo : 'solicitudes'
                },
                success: function(response) {
                    if (response.status == 100) {
                        console.log('Correos Enviados', response);
                        var correos = '';
                        var datos = response.response;

                        for (i in datos){
                            correos += `
                                <div class="mt-3" style="display: flex; flex-wrap: wrap;">
                                    <div class="col-md-3">
                                        <div style="width: 100%; height: 100%; border:1px solid #dfe6ad; display: flex; justify-content: center; align-items: center; padding: 4px; font-size: 0.9em; color: ${datos[i].correo_estatus_enviado == 'enviado' ? '#16A085' : '#CB4335'}; flex-direction: column; position:relative;">
                                            <div style="position: absolute; top: 0; right: 0; background: #dfe6ad; color: #444; width: 65px; text-align: center;border-radius: 0 0 0 9px;"> ${datos[i].nombre_corto ?? ""} </div>
                
                                            <i class="fas fa-send" style="font-size: 2.9em; margin-bottom: 10%;"></i>
                
                                            Estatus: ${datos[i].correo_estatus_enviado.replace("_", " ") ?? ""}
                
                                            <div style="position: absolute; bottom: 17%; color: #aaa; width:100%; text-align:center;"><i class="fas fa-user" style=" margin-right: 6%;"></i>${datos[i].usuario ?? ""}</div>
                
                                        </div>
                                    </div>
                
                                    <div class="col-md-9">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th>Nombre Destinatario:</th>
                                                        <td>${datos[i].nombre_completo ?? ""}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Correo Destinatario:</th>
                                                        <td>${datos[i].correo_destinatario ?? ""}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fecha Programacion</th>
                                                        <td>${datos[i].correo_fecha_programacion ?? ""}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fecha de envio</th>
                                                        <td>${datos[i].correo_fecha_enviado ?? ""}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }

                        html = `
                            <div style="display:flex; justify-content:space-around; align-items: center; background: #dfe6ad;color: #757575; padding: 9px 6px;font-weight: bold;">
                                <div>
                                    Solicitud: ${info.id_solicitud}
                                </div>
                                <div>
                                    Folio: ${info.folio_solicitud}
                                </div>
                                <div>
                                    Urgente:  ${info.estatus_urgente}
                                </div>
                            </div>
                            ${correos}
                        `;
                    }else{
                        html = `
                            <div style="display:flex; justify-content:space-around; align-items: center; background: #dfe6ad;color: #757575; padding: 9px 6px;font-weight: bold;">
                                <div>
                                    Solicitud: ${info.id_solicitud}
                                </div>
                                <div>
                                    Folio: ${info.folio_solicitud}
                                </div>
                                <div>
                                    Urgente:  ${info.estatus_urgente}
                                </div>
                            </div>
                            
                            <div style="width: 100%; display: flex; justify-content: center; align-items: center; height: 200px; border: 1px solid #bbb; color: #aaa; font-size: 1.3em;">
                                Sin datos relacionados
                            </div>
                        `;
                    }

                    $('#bodyVerDetallesTareas').html(html);
                    $('#modalVerDetallesTareas').modal('show');
                }
            });
            
        }

        function get_date( date , format = 'YYYY-MM-DD' ){
            date = date.replaceAll("/","-");
            
            if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('-') ) 
              return date.split('-').reverse().join('-');
            if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('-') )
              return date.split('-').reverse().join('-');
            if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('/') ) 
              return date.split('/').reverse().join('-');
            if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('/') )
              return date.split('/').reverse().join('-');
            else
              return date;
        }

    </script>
@endsection

@section('seccion-modales')

    {{-- VER SOLICITUD --}}
    <div id="modal-ver" class="modal fade" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-body pd-0">
            <div class="card">
              <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#tabDatosSolicitud" data-toggle="tab">Datos de la Solicitud</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#tabPersonas" data-toggle="tab">Personas</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#tabDelitosNoRelacionados" id="navDelitosNoRelacionados" data-toggle="tab">Delitos no Relacionados</a>
                  </li>
                </ul>
              </div><!-- card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tabDatosSolicitud">
                  </div><!-- tab-pane -->
                  <div class="tab-pane" id="tabPersonas">
                  </div><!-- tab-pane -->
                  <div class="tab-pane" id="tabDelitosNoRelacionados">
                  </div><!-- tab-pane -->
                </div><!-- tab-content -->
              </div><!-- card-body -->
            </div><!-- card -->
          </div>
          <div class="modal-footer">
              <div id="boton" data-dismiss="modal"></div>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    {{-- SIN DATOS --}}

    <div id="modalFail" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="icon ion-ios-close-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class=" tx-semibold style='color:red' mg-b-20">Ohhhh!</h4>
                    <p class="mg-b-20 mg-x-20">No existe documento relacionado.</p>
                    <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal"
                        aria-label="Close">Cerrar</button>
                </div><!-- modal-body -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalFailTurnado" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="icon ion-ios-close-outline tx-100 style='color:red' lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class=" tx-semibold style='color:red' mg-b-20">Ohhhh!</h4>
                    <p class="mg-b-20 mg-x-20">La solicitud ya dispone con una Carpeta Judicial Asignada</p>
                    <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal"
                        aria-label="Close">Cerrar</button>
                </div><!-- modal-body -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalOkTurnado" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i
                        class="icon ion-ios-checkmark-circle-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class=" tx-semibold style='color:green' mg-b-20" style='color:green'>Proceso Concluido!</h4>

                    <p id="carpetaAsignada" color='green' class="mg-b-20 mg-x-20">Carpeta Judicial Asignada</p>

                    <button type="button" class="btn btn-sucess pd-x-25" data-dismiss="modal"
                        aria-label="Close">Cerrar</button>
                </div><!-- modal-body -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalAdjuntarDocumento" class="modal fade">
        <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
            <div class="modal-content tx-size-sm">
                <div class="modal-header pd-x-20">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Documento de la
                            Solicitud</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pd-20">
                    {{-- <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data">
                    <div class="custom-input-file">
                      <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" onchange="leeDocumento('archivoPDF');">
                      <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
                      </div>
                  </form> --}}

                    <iframe src="" id="documentoPDFrame"></iframe>


                </div><!-- modal-body -->
                <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-secondary d-inline-block mg-l-auto" style="margin-left: auto;"
                        data-dismiss="modal">Cerrar</button>
                    {{-- <button type="button" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="enviarPromocion()">Enviar Solicitud</button> --}}
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalError" class="modal fade">
      <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
          <div class="modal-body tx-center pd-y-20 pd-x-20">
            <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
            <h4 class="tx-danger mg-b-20" id="titleError"></h4>
            <p class="mg-b-20 mg-x-20" id="messageError"></p>
            <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close"   id="acepError">Aceptar</button>
          </div><!-- modal-body -->
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalVerDetallesTareas" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
            <div class="modal-content tx-size-sm">
                <div class="modal-header pd-x-20">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Detalles</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pd-20">
                    <div id="bodyVerDetallesTareas" style="width: 100%;overflow: auto;height: 70vh;"></div>
                </div>
                <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-secondary d-inline-block mg-l-auto" style="margin-left: auto;" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
