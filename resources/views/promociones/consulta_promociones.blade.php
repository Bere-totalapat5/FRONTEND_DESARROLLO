@php
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\utilidades;
$humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')
<style>
    #carpetasJudicialesA, #carpetasJudicialesR{
        width: 96%;
        max-height: 200px;
        overflow-y: auto;
        background: #444;
        position: absolute;
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
        background: #444;
        color: #fff;
        list-style: none;
      }
      #carpetasJudicialesA ul li, #carpetasJudicialesR ul li{
        width: 100%;
        padding: 5px;
        text-align: left;
        cursor: pointer;
        transition: all 300ms;
      }
      #carpetasJudicialesA ul li:hover, #carpetasJudicialesR ul li:hover{
        background: rgb(86, 86, 86);
      }
</style>
@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Promociones</a></li>
        <li class="breadcrumb-item"><a href="#"> Consulta de Promociones</a></li>
    </ol>
    <h6 class="slim-pagetitle"> Consulta de Promociones</h6>
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
                                        <input class="form-control" type="text" value="" name="" id="idPromocion" placeholder="">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Folio de promoción : </label>
                                        <input class="form-control" type="text" value="" name="" id="foliopromocion" placeholder="">
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
                                        <label class="label">Fecha de promocion (Desde): </label>
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
                                        <label class="label">Fecha de promocion (Hasta): </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA"  value="" id="fechasolicitudh" name="" autocomplete="off">
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
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10"
                                        data-toggle="collapse" data-target="#demo"
                                        onclick="sec_ajax(1);">Filtrar</button>
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
                            {{-- <th style="cursor:pointer" class="estatus_urgente" name="estatus_urgente">Urgente</th>--}}
                            {{-- <th style="cursor:pointer" class="responsable" name="responsable">Responsable</th>  --}}
                        </tr>
                    </thead>
                    <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">
                    </tbody>
                </table>
            </div>

            {{-- <div id="table-firmas" class="mg-b-20">
                <table id="promocionesTable" class="display dataTable dtr-inline collapsed d-block"
                    style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>
                            <th class="acciones" name="acciones">Acciones</th>
                            <th class="semaforo" name="semaforo"> </th>
                            <th style="cursor:pointer" class="folio_promocion" name="folio_promocion"> ID Acuse</th>
                            <th style="cursor:pointer" class="folio_promocion"></th>
                            <th style="cursor:pointer" class="folio_promocion" name="folio_promocion"></th>
                            <th style="cursor:pointer" class="fecha_registro" name="fecha_registro"></th>
                            <th style="cursor:pointer" class="folio_carpeta" name="folio_carpeta">Carpeta Judicial</th>
                            <th style="cursor:pointer" class="tipo_solicitud" name="tipo_solicitud">Unidad receptora</th>
                            <th style="cursor:pointer" class="tipo_requerimiento" name="tipo_requerimiento">Tipo de requerimiento</th>
                            <th style="cursor:pointer" class="nombre_promovente" name="nombre_promovente">Nombre del Promovente</th>
                            <th style="cursor:pointer" class="figura_juridica" name="figura_juridica">Figura Juridica</th>
                            <th style="cursor:pointer" class="tipo_audiencia" name="tipo_audiencia">Tipo de Audiencia</th>
                            <th style="cursor:pointer" class="responsable" name="responsable">Responsable</th>
                        </tr>
                    </thead>
                    <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">
                    </tbody>
                </table>
            </div> --}}            

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
        <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Flujo de la promoción</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body" id="modal_flujo_contenido">
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="cerrar_modal('modal_flujo')" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambio carpeta -->
    <div class="modal fade" id="modal_cambio_c" role="dialog">
        <div class="modal-dialog" role="document" style="width: -webkit-fill-available;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambio de carpeta judicial</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                        <div id="divAsociada" style="display:block">
                        <div class="form-group">
                        <label class="form-control-label">Carpeta Judicial: <span class="tx-danger">*</span></label>
                            <form autocomplete="nope">
                        <input autocomplete="new-text" class="form-control" id="carpetaJudicialSeleccionada" onkeyup="buscarCarpeta();" placeholder="Escribe para Buscar..." autocomplete="nope">
                        <input type="hidden" class="form-control" id="id_nueva_carpeta_judicial" >
                        <input type="hidden" class="form-control" id="id_promocion_" >
                            </form>
                        <datalist id="datalistCarpetas"></datalist>
                        <div id="carpetasJudicialesA"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="cerrar_modal('modal_cambio_c')" class="btn btn-secondary">Cancelar</button>
                    <button type="button" onclick="cambiar_carpeta(2,0)" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambio carpeta -->
    <div id="modalSuccess" class="modal fade" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-body tx-center pd-y-20 pd-x-20">
                            <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                            <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
                            <p style="padding-left: 5vh; padding-right: 5vh;">Se realizó exitósamente</p>
                        </div><!-- modal-body -->
                        <div class="modal-footer d-flex">
                            <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal"
                                aria-label="Close">Aceptar</button>
                        </div>
                    </div><!-- modal-content -->
                </div><!-- modal-dialog -->
            </div>

            <div id="modalError" class="modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-body tx-center pd-y-20 pd-x-20">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                            <div id="messageError">
                            </div>
                            <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal"
                                aria-label="Close">Aceptar</button>
                        </div><!-- modal-body -->
                    </div><!-- modal-content -->
                </div><!-- modal-dialog -->
            </div><!-- modal -->


            <div id="modalError" class="modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-body tx-center pd-y-20 pd-x-20">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                            <div id="messageError">
                            </div>
                            <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal"
                                aria-label="Close">Aceptar</button>
                        </div><!-- modal-body -->
                    </div><!-- modal-content -->
                </div><!-- modal-dialog -->
            </div><!-- modal -->



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
@endsection

@section('seccion-scripts-functions')
    <script>
        let solicitudes = [];
        let tabla_direcciones = [];
        let tabla_alias = [];
        let tabla_contacto = [];
        let tabla_correo = [];
        let tabla_datos = [];
        let tabla_delitos = [];
        let tabla_no_relacionados = [];
        let datatable = null;
        let solicitud_seleccionada;
        var id_unidad_g = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;

        var solicitudes_ = [];


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

            $("#pagina_actual").val(pagina);
            $("#numeropagina").val(pagina);
            $(".pagina_actual_texto").html(pagina);

            var data =  {
                id_promocion: $("#idPromocion").val(),
                folio_promocion: $("#foliopromocion").val(),
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
                type: "GET",
                url: "/public/obtener_promociones",
                data: data,
                success: function(response) {
                    if (response.status == 100) {
                        console.log('promociones', response.response);

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


                        var body = new $("#solicitudesTable").dataTable({
                            processing: true,
                            data: datos,
                            columns: [
                                {
                                    data: "id_promocion",
                                    render: function(data, type, row, meta) {

                                        var editable = 1;

                                        if(row.estatus_registro == "Turnado"){
                                          var editable = 0;
                                        }

                                        
                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;'
                                        }

                                        return (`
                                        <div class="molde3" style="${sin_tareas}">
                                            @if( isset($permisos[65]) and $permisos[65] == 1 ) <i class="icon ion-ios-information" title="Información" style="cursor: pointer" onclick="ver_promocion(${data})" id="informacion"></i>  @endif
                                            @if( isset($permisos[66]) and $permisos[66] == 1 ) <i class="icon ion-edit" title="Modificar" onclick="modificar_promocion(${data},'${editable}')" style="cursor: pointer" id="editar"></i>  @endif
                                            @if( isset($permisos[66]) and $permisos[66] == 1 ) <i class="icon fa-solid fa-folder-plus" title="Cambia de carpeta judicial" style="cursor: pointer" onclick="cambiar_carpeta(1,${data})" ></i> @endif                                          
                                            @if( isset($permisos[67]) and $permisos[67] == 1 ) <i class="icon ion-ios-download-outline"  title="Descargar PDF" style="cursor: pointer" onclick="descargar_pdf(${data})" id="pdf"></i>  @endif
                                            @if( isset($permisos[68]) and $permisos[68] == 1 ) <i class="icon ion-code-download" title="Descargar XML" style="cursor: pointer" data-id="${data}" onclick="descargar_xml(${data})" id="descargar_xml"></i>  @endif
                                            @if( isset($permisos[69]) and $permisos[69] == 1 ) <i class="icon ion-ios-list-outline" title="Consulta Log" style="cursor: pointer" onclick="ver_log(${data})" id="log"></i> @endif
                                            @if( isset($permisos[70]) and $permisos[70] == 1 ) <i class="icon ion-android-map" title="Consulta Flujo" style="cursor: pointer" onclick="ver_flujo(${data})" id="flujo"></i> @endif
                                        </div>
                                        `);
                                    },
                                },
                                {
                                    data: "estatus_semaforo",
                                    name: "estatus_semaforo",
                                    render: function(data, type, row, meta) {
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
                                            sin_tareas = 'background: #fff0ec;'
                                        }
                                        
                                        return (`<div class="molde3" style="${sin_tareas}">
                                            <i class="fa fa-lightbulb-o fa-lg" style="color:${color}" title="${title}" text-align="right" aria-hidden="true"></i>
                                        </div>`);

                                    }
                                },
                                {
                                    data: "id_promocion",
                                    title: "Datos de Solicitud",
                                    name: "id_promocion",
                                    render: function(data, type, row, meta) {
                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;'
                                        }

                                        return (`<div class="molde" style="${sin_tareas}">
                                                    <div class="soli">${data}</div>
                                                    <div class="soli_e">${row.estatus_flujo_actual}</div>
                                                    <div class="soli_fs"><span>Folio </span>${row.folio_promocion}</div>
                                                </div>`);
                                    }
                                },
                                {
                                    data: "fecha",
                                    title: "Fecha/hora de registro",
                                    name: "fecha",
                                    render: function(data, type, row, meta) {

                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;'
                                        }

                                       return  `<div class="molde3" style="${sin_tareas}">${data}</div>`;
                                    }
                                },
                                {
                                    data: "carpeta_investigacion",
                                    title: "Carpetas",
                                    name: "carpeta_investigaciones",
                                    render: function(data, type, row, meta) {
                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;'
                                        }

                                        return (`<div class="molde3" style="${sin_tareas}">
                                                    <div class="barra_l">
                                                        <ul style="margin: 1.3% 0 1.3% 2%;">
                                                            <li style="font-size: 0.8em;"><strong>Carpeta Judicial:</strong> ${row.folio_carpeta ?? ""} </li>
                                                            <li style="font-size: 0.8em;"><strong>Carpeta Inv.:</strong>
                                                                <ul>
                                                                    <li style="font-size: 0.97em;">${data ?? ""}</li>
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
                                    render: function(data, type, row, meta) {

                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;'
                                        }

                                       return  `<div class="molde3" style="${sin_tareas}">${data ?? ""}</div>`;
                                    }
                                },
                                {
                                    data: "id_promocion",
                                    title: "Urgente",
                                    name: "estatus_urgente",
                                    render: function (data, type, row, meta){
                                        var sin_tareas = '';
                                        let urgente = row.tipo_atencion != null ? (row.tipo_atencion == 1 ? 'No' : 'Si') : '';

                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;'
                                        }

                                       return  `<div class="molde3" style="${sin_tareas}">${urgente}</div>`;
                                    }
                                },
                                {
                                    data: "materia",
                                    title: "Materia Destino",
                                    name: "materia_destino",
                                    render: function(data, type, row, meta) {

                                        var sin_tareas = '';
                                        if(row.tareas_generadas > 0){
                                            sin_tareas = '';
                                        }else{
                                            sin_tareas = 'background: #fff0ec;'
                                        }

                                       return  `<div class="molde3" style="${sin_tareas}">${data}</div>`;
                                    }
                                },
                                {
                                    data: "id_promocion",
                                    title: "Tareas Totales",
                                    render: function(data, type, row, meta) {
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
                                                                <strong>Generadas:</strong> <span style="${stilo}">${row.tareas_generadas ?? 0}${button_sin_tareas}</span>
                                                                <div style="cursor:pointer;" onclick="modalVerDetallesTareas(${meta.row})">
                                                                    Ver detalles
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>`);
                                    }
                                }
                            ], //ATRIBUTOS
                            colReorder: {
                                fixedColumnsLeft: 2,
                            },
                            columnDefs: [{
                                orderable: false,
                                targets: 0
                            }],
                            bDestroy: true,
                            colReset: true,
                            paging: false,
                            ordering: true,
                            info: false,
                            search: false,
                            filter: false,
                            stateSave: true,
                        });
                        datatable = body;

                        $(".pagina_total_texto").html(response.response_pag["paginas_totales"]);
                        $("#paginas_totales").val(response.response_pag["paginas_totales"]);

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
                },
            });
        }

        function setInputCarpta(carpeta,idCarpeta){
            $("#id_nueva_carpeta_judicial").val(idCarpeta);
            $('#carpetasJudicialesA').css('display', 'none');
            $('#carpetaJudicialSeleccionada').val(carpeta);
            $('#carpetaJudicialSeleccionada').attr('data-idcarpeta',idCarpeta);

        }

        function buscarCarpeta() {

                var carpetaAsociada = $('#carpetaJudicialSeleccionada').val();
                $('#carpetasJudicialesA').html("");
              
                $("#nombrePromovente").html("");


                    $.ajax({
                    type:'POST',
                    url:'public/buscar_carpetas_asociadas',
                    data:{
                        carpetaAsociada: carpetaAsociada,
                    },
                    success:function(response){

                        if(response.status==100){

                            $('#carpetasJudicialesA').css('display', 'block');
                            let carpetas='';
                            var carpetas_act = [];
                            $(response.response).each(function(index, carpeta){

                            const {id_carpeta_judicial,folio_carpeta}  = carpeta;
                            
                            const option=`<li onclick="setInputCarpta('${folio_carpeta}','${id_carpeta_judicial}')">${folio_carpeta}</li>`;
                            carpetas=carpetas.concat(option);
                            });

                            $('#carpetasJudicialesA').html(`
                            <ul>
                                <li disabled selected>Elija una opción</li> `+ carpetas+`
                            </ul>`
                            );
                        }
                        else{
                            $("#id_nueva_carpeta_judicial").val("");
                        $('#carpetasJudicialesA').html("<ul><li>Sin datos encontrados</li></ul>");
                        }
                        setTimeout(function(){  $('#modal_loading').modal('hide');  }, 500);
                    }
                });
        }

        function modificar_promocion(valor,valor2){
          if(valor2 == 0){
            var texto_modal_fail = "<p class='mg-b-20 mg-x-20'>No se puede editar, la Promoción ya fue turnada</p>";

            $('#texto_modal_fail').html(texto_modal_fail);
            $('#modalFail').modal('show');

          }
          else{
            window.location.href="editar_solicitud_promocion/"+valor;
          }
        }

        function descargar_pdf(id_promocion) {
            $.ajax({
                type: 'GET',
                url: 'public/descargar_pdf_promocion/' + id_promocion,
                data: {

                },
                success: function(response) {
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

                      var texto_modal_fail = "<p class='mg-b-20 mg-x-20'>No existe documento PDF</p>";

                      $('#texto_modal_fail').html(texto_modal_fail);
                      $('#modalFail').modal('show');

                    }
                }
            });
        }

        function mostrarModalDocumento() {

            $('#modalAdjuntarDocumento').modal('show');
        }

        function descargar_xml(id_promocion) {
            $.ajax({
                type: 'GET',
                url: 'public/descargar_xml_promocion/' + id_promocion,
                data: {

                },
                success: function(response) {

                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if (response.status == 100) {
                        var win = window.open(response.response, '_blank');
                    } else {
                        var texto_modal_fail = "<p class='mg-b-20 mg-x-20'>Promoción registrada desde interfáz.</p>";

                        $('#texto_modal_fail').html(texto_modal_fail);
                        $('#modalFail').modal('show');
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

        function cambiar_carpeta(accion,id_promocion){

            if(accion == 1){
                $("#id_promocion_").val(id_promocion);
                $("#modal_cambio_c").modal("show");
                $("#carpetaJudicialSeleccionada").val("");
                $("#id_nueva_carpeta_judicial").val("");
            }
            if(accion == 2){

                $.ajax({
                type: "post",
                url: "public/cambio_carpeta_promocion",
                data: {
                    id_promocion:$("#id_promocion_").val(),
                    id_carpeta_judicial: $("#id_nueva_carpeta_judicial").val()
                },
                success: function(response) {
                    console.log("alexis",response);
                    if (response.status == 100) {
                        cerrar_modal('modal_cambio_c');
                        $('#modalSuccess').modal('show');
                        sec_ajax();
                    }
                    else{

                        var error = "<p class='mg-b-20 mg-x-20'>ERROR</p>";
                        $('#messageError').html(error);
                        $('#modalError').modal('show');

                    }
                },
            });

         }
         
        }

    
        function ver_flujo(valor) {
            var id_solicitud = valor;
            $.ajax({
                type: "GET",
                url: "public/ver_flujo_promocion/" + id_solicitud,
                data: {},
                success: function(response) {
                    $("#modal_flujo").modal("show");

                    a = 0;
                    var count = response.response.length;
                    var contenido = "<table class='table table-hover'><thead><tr style='text-align: center;'>" +
                        "<th>Estatus</th>" +
                        "<th>Responsable</th>" +
                        "<th>Fecha</th></thead></tr>";
                    var nombres = "";
                    var usuario = "";
                    while (a <= count - 1) {

                        if (response.response[a]['nombres'] != null || response.response[a][
                            'apellido_paterno'] != null || response.response[a]['apellido_materno'] != null) {
                            nombres = response.response[a]['nombres'] + " " +
                                response.response[a]['apellido_paterno'] + " " +
                                response.response[a]['apellido_materno'];

                        } else {
                            nombres = "desconocido";
                        }

                        if (response.response[a]['usuario'] != null) {
                            usuario = response.response[a]['usuario'];
                        } else {
                            usuario = "desconocido";

                        }


                        contenido += "<tr>" +
                            "<td>" + response.response[a]['estatus_actividad'] + "</td>" +
                            "<td><strong>Nombre: </strong>" + nombres +
                            "<br><strong>Usuario: </strong>" + usuario + "</td>" +
                            "<td>" + response.response[a]['creacion'] + "</td>" +
                            "</tr>";
                        a++;
                    }
                    contenido += "</table>";


                    $("#modal_flujo_contenido").html(contenido);
                },
            });
        }

        function ver_log(valor) {
            var id_promocion = valor;
            $.ajax({
                type: "GET",
                url: "public/ver_log_promocion/" + id_promocion,
                data: {},
                success: function(response) {
                    var win = window.open('http://172.19.228.38:8083/archivo.log', '_blank');
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
                    window.open(response[0]['url'], '_blank');
                },
            });
        }

        function cerrar_modal(valor) {
            $("#" + valor).modal('hide');
            $('body').removeClass('modal-open');
        }

        function ver_promocion(id_promocion) {

            $.ajax({
                type: 'GET',
                url: '/public/obtener_promociones',
                data: {
                    id_promocion: id_promocion, //id_promocion
                    cambio_estatus: 1,
                    pagina: 1,
                    registros_por_pagina: 10,
                },
                success: function(response) {

                    if (response.status == 100) {

                        $.each(response.response, function(index, promocion) {
                            const {
                                completado,
                                fecha,
                                folio_carpeta,
                                folio_promocion,
                                id_carpeta_judicial,
                                id_promocion,
                                id_ta,
                                id_tipo_requerimiento,
                                ids_persona,
                                personas,
                                promovente,
                                razon_social,
                                cuerpoTexto,
                                tipo_audiencia,
                                tipo_promocion,
                                tipo_requerimiento,
                                id_persona_promovente,
                                nombre_promovente,
                                nombre_promovente_ingresado
                            } = promocion;


                            let listaPersona = [];
                            let listaNorelacionados = [];

                            let listaSujetos = [];
                            let acordeones = [];

                            if (personas.length) {
                                $(personas).each(function(index, sin) {

                                    const {
                                        apellido_materno,
                                        apellido_paterno,
                                        calidad_juridica,
                                        id_calidad_juridica,
                                        id_persona,
                                        nombre
                                    } = sin;
                                    const li = "<tr>"+
                                                "<td align='center'>"+nombre+"</td>"+
                                                "<td align='center'>"+apellido_paterno+"</td>"+
                                                "<td align='center'>"+apellido_materno+"</td>"+
                                                "</tr>";

                                    listaNorelacionados = listaNorelacionados.concat(li);

                                });
                                $('#datosno-asociados').html("<tr align='center'>"+
                                                             "<td class='td-title'>Nombres</td>"+
                                                             "<td class='td-title'>Apellido Paterno</td>"+
                                                             "<td class='td-title'>Apellido Materno</td>"+
                                                             "</tr><tr>"+listaNorelacionados+"</tr>");

                            } else {
                                $('#datosno-asociados').html("<tr align='center'>"+
                                                             "<td class='td-title'> Sin personas Relacionadas </td>"+
                                                             "</tr>"+
                                                             "<tr>"+listaNorelacionados+"</tr>");
                            }

                            var nombre_del_promovente = "";

                            if(id_persona_promovente > 0){
                              nombre_del_promovente = nombre_promovente;
                            }
                            else{
                              nombre_del_promovente = nombre_promovente_ingresado;
                            }

                            var info_tipo_audiencia = "";

                            if(tipo_audiencia == null){
                              info_tipo_audiencia = "SIN DATOS";
                            }
                            else{
                              info_tipo_audiencia = tipo_audiencia;

                            }

                            $('#datosolicitud').html("<table class='dataTables'>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Nombre del Promovente</td>"+
                                                     "<td>"+nombre_del_promovente+"</td>"+
                                                     "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Folio de Carpeta</td>"+
                                                     "<td>"+folio_carpeta+"</td>"+
                                                     "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Folio de Promocion</td>"+
                                                     "<td>"+folio_promocion+"</td>"+
                                                     "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Tipo de audiencia</td>"+
                                                     "<td>"+info_tipo_audiencia+"</td>"+
                                                     "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Tipo de requerimiento</td>"+
                                                     "<td>"+tipo_requerimiento+"</td>"+
                                                     "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Resumen del documento</td>"+
                                                     "<td>"+cuerpoTexto+"</td>"+
                                                     "</tr></table>");

                            $('#modal-ver').modal('show');
                        });
                    }
                }
            });
        }

        function modalVerDetallesTareas(__index__){
            var info = solicitudes_[__index__];
            var html = '';
            $('#bodyVerDetallesTareas').html('');
            
            $.ajax({
                type: "GET",
                url: "public/correos_enviados",
                data: {
                    id_solicitud:info.id_promocion,
                    tipo : 'promociones'
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
                                    Promocion: ${info.id_promocion}
                                </div>
                                <div>
                                    Folio: ${info.folio_promocion}
                                </div>
                                <div>
                                    Urgente:  ${info.tipo_atencion != null ? (info.tipo_atencion == 1 ? 'No' : 'Si') : ''}
                                </div>
                            </div>
                            ${correos}
                        `;
                    }else{
                        html = `
                            <div style="display:flex; justify-content:space-around; align-items: center; background: #dfe6ad;color: #757575; padding: 9px 6px;font-weight: bold;">
                                <div>
                                    Promocion: ${info.id_promocion}
                                </div>
                                <div>
                                    Folio: ${info.folio_promocion}
                                </div>
                                <div>
                                    Urgente:  ${info.tipo_atencion != null ? (info.tipo_atencion == 1 ? 'No' : 'Si') : ''}
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

    <div id="modal-ver" class="modal fade" data-keyboard="false">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-body">
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aling="right" aria-hidden="true">&times;</span>
                    </button>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos de la Promoción</a>
                            {{-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Promovente</a> --}}
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Personas autorizadas para recibir documentación </a>
                        </div>
                    </nav>
                    <br />
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <table id="datosolicitud" class="dataTables"></table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="accordion" id="acordeon" role="tablist"></div>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <table id="datosno-asociados" class="dataTables"></table>
                        </div>
                    </div>
                    <br />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    //MODAL FAIL
    <div id="modalFail" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="icon ion-ios-close-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-semibold style='color:red' mg-b-20">No disponible</h4>
                    <div id="texto_modal_fail"></div>
                    <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalAdjuntarDocumento" class="modal fade">
        <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
            <div class="modal-content tx-size-sm">
                <div class="modal-header pd-x-20">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Documento de la Promoción</span></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pd-20">
                    {{--
                    <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data">
                        <div class="custom-input-file">
                            <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" onchange="leeDocumento('archivoPDF');" />
                            <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
                        </div>
                    </form>
                    --}}
                    <iframe src="" id="documentoPDFrame"></iframe>
                </div>
                <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-secondary d-inline-block mg-l-auto" style="margin-left: auto;" data-dismiss="modal">Cerrar</button>
                    {{-- <button type="button" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="enviarPromocion()">Enviar Solicitud</button> --}}
                </div>
            </div>
        </div>
    </div>

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
