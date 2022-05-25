@php
    use App\Http\Controllers\clases\humanRelativeDate;
    use App\Http\Controllers\clases\utilidades;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Exhortos</a></li>
        <li class="breadcrumb-item"><a href="#"> Consulta de Exhortos</a></li>
    </ol>
    <h6 class="slim-pagetitle"> Consulta de Exhortos</h6>
@endsection

@section('contenido-principal')

    {{-- @if (!isset($request->menu_general['response']))
    <div class="section-wrapper">
        <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
    </div>
    @else
    @if (!utilidades::buscarPermisoMenu($request->menu_general['response'], 1151))
        <div class="section-wrapper">
            <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
        </div>
    @else --}}
    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">
            <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false"
                            aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                            Búsqueda Avanzada
                        </a>
                    </div><!-- card-header -->
                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                            <div class="row mg-b-25">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Folio de exhorto : </label>
                                        <input class="form-control" type="text" value="" name="" id="foliosolicitud"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Carpeta de Exhorto Asignada : </label>
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
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="" id="fechasolicitud" name="fechasolicitud" autocomplete="off">
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
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA"  value="" id="fechasolicitudh" name="fechasolicitudh" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label">Medio de Recepción:</label>
                                    <div class="form-group">
                                        <select class="form-control-lg select2 valid" width='100%' autocomplete="off"
                                            id="mediorecepcion">
                                            <option selected disabled value="">Elija una opción</option>
                                            <option value="">{{ 'TODOS' }}</option>
                                            <option value="RECIBIDA">{{ 'RECIBIDA' }}</option>
                                            <option value="REGISTRADA">{{ 'REGISTRADA' }}</option>
                                            <option value="TRAMITE CJ">{{ 'CARPETA JUDICIAL ASIGNADA' }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 {{ Session::get('id_unidad_gestion') == 0 ? '' : 'd-none'  }}">
                                    <label class="form-control-label">Unidad de gestión asignada:</label>
                                    <div class="form-group">
                                        
                                        <select class="form-control-lg select2 valid" width='100%' autocomplete="off"
                                            id="unidadAsignada">
                                            @if ( Session::get('id_unidad_gestion') == 0 )
                                                <option selected value="-">Todas</option>
                                            @endif
                                            @foreach ($unidades['response'] as $unidad)
                                                <option value="{{ $unidad['id_unidad_gestion'] }}" {{ Session::get('id_unidad_gestion') == $unidad['id_unidad_gestion'] ? 'selected' : ''  }}>
                                                    {{ $unidad['nombre_unidad'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-control-label">Situacion:</label>
                                    <div class="form-group">
                                        <select class="form-control-lg select2 valid" width='100%' autocomplete="off"
                                            id="situacion">
                                            <option selected disabled value="">Elija una opción</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3" width='100%'>
                                    <label class="form-control-label">Estatus semaforo:</label>
                                    <div class="form-group" width='100%'>
                                        <select class="form-control-lg select2 valid" width='100%' autocomplete="off"
                                            id="estatus_color">
                                            <option selected disabled value="">Elija una opción</option>
                                            <option value="">{{ 'TODOS' }}</option>
                                            <option value="verde">{{ 'Atendidas' }}</option>
                                            <option value="amarillo">{{ 'Visto,sin resolver' }}</option>
                                            <option value="rojo">{{ 'Pendiente' }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!-- row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10"
                                        data-toggle="collapse" data-target="#demo"
                                        onclick="sec_ajax('primera');">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- accordion -->
            <br>
            <div class="row justify-content-end">
                <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">
                <div class="col-sm-2 pd-t-10" align="right">
                    <a href="javascript:void(0);" onclick="descargar_consulta('xls');"
                        class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                </div>
                <div class="col-sm-2 pd-t-10" align="right">
                    <a href="javascript:void(0);" onclick="descargar_consulta('pdf');"
                        class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar PDF</a>
                </div>
            </div>
            <br>
            <div class="pagination-wrapper justify-content-between mg-b-20">
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera');"
                            aria-label="Last">
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
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar');"
                            aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima');"
                            aria-label="Last">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- pagination-wrapper -->
            <div id="table-firmas" class="mg-b-20">
                <table id="exhortosTable" class="display dataTable dtr-inline collapsed d-block"  style="font-size:0.9em; overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>
                            <th class="acciones" class="acciones" name="acciones">Acciones</th>
                            <th class="semaforo" class="semaforo" name="semaforo"></th>
                            <th style="cursor:pointer" class="folio_registro" name="folio_registro">Folio de Registro (UGJ)</th>
                            <th style="cursor:pointer" class="fecha_recepcion" name="fecha_recepcion">Fecha de recepción </th>
                            <th style="cursor:pointer" class="carpeta_exhorto_asignada" name="carpeta_exhorto_asignada">  Carpeta de Exhorto asignada</th>
                            <th style="cursor:pointer" class="unidad_gestion_exhorto">Unidad de gestión</th>
                            <th style="cursor:pointer" class="delito">Delito</th>
                            <th style="cursor:pointer" class="juzgado_exhortante" name="juzgado_exhortante">Juzgado  Exhortante</th>
                            <th style="cursor:pointer" class="entidad_exhortante" name="entidad_exhortante">Entidad Federativa Exhortante</th>
                            <th style="cursor:pointer" class="juez_exhortante" name="juez_exhortante">Juez Exhortante</th>
                            <th style="cursor:pointer" class="no_expediente" name="no_expediente">No. de Expediente</th>
                            <th style="cursor:pointer" class="no_oficio" name="no_oficio">No. de folio/oficio</th>
                            <th style="cursor:pointer" class="delegacion_requerida" name="delegacion_requerida">Delegación requerida</th>
                            <th style="cursor:pointer" class="tipo_unidad_destino" name="tipo_unidad_destino">Tipo de unidad destino</th>
                            <th style="cursor:pointer" class="medio_recepcion" name="medio_recepcion">Medio de recepción </th>
                            <th style="cursor:pointer" class="participantes" name="participantes">Participantes</th>
                            <th style="cursor:pointer" class="responsable" name="responsable">Situación actual</th>
                            <th style="cursor:pointer" class="responsable_registro" name="responsable_registro">Responsable del registro</th>
                            
                        </tr>
                    </thead>
                    <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper justify-content-between">
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('primera');"
                            aria-label="Last">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('atras');"
                            aria-label="Next">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                </ul>
                <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span
                        class="pagina_total_texto">0</span></div>
                <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('avanzar');"
                            aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="sec_ajax('ultima');"
                            aria-label="Last">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div><!-- pagination-wrapper -->

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

    </div>

    {{-- @endif
    @endif --}}
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
        <div class="modal-dialog" style="width:550px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Flujo de la solicitud</h5>
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
    <!-- Modal log -->

    <div class="modal" id="modal_log">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="width:820px;">
                <div class="modal-header">
                    <h5 class="modal-title">Consulta de log de la solicitud</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body p-3 mb-3 bg-dark text-white" id="modal_log_contenido"
                    style="max-width:820px; height:460px; overflow: scroll;">
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="cerrar_modal('modal_log')" class="btn btn-primary">Aceptar</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('seccion-estilos')
    <link href="{{ asset('/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/exhortos/consulta_exhortos.css">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
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

        .unidad_gestion_exhorto {
            min-width: 200px;
        }
        .delito {
            min-width: 200px;
        }
        .responsable_registro {
            min-width: 200px;
        }

        #exhortosTable {
            text-transform: uppercase;
        }

        @media screen and (max-width: 600px) {}

        #modal-ver .modal-dialog {
            font-size: 18px;
            height: 90%;
            margin: 0;
            padding: 1;
        }


        #modal-ver .modal-body {
            height: 95%;
            min-width: 90%;
        }

        #modal-ver .modal-content {
            height: 95%;
            min-width: 90%;
        }

        .embed-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }

        .embed-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 70%;
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
            font-size: 12px;
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


        .semaforo {
            min-width: 50px !important;
            /*  text-align:center;
                    size: 20px;
                    vertical-align: top; */
        }

        .acciones {
            min-width: 180px !important;

        }

        .folio_registro {
            min-width: 150px !important;
        }


        .fecha_recepcion {
            min-width: 170px !important;

        }

        .medio_recepcion {
            min-width: 140px !important;
        }

        .entidad_exhortante {
            min-width: 150px !important;
        }

        .juzgado_exhortante {
            min-width: 300px !important;
        }

        .juez_exhortante {
            min-width: 170px !important;
        }

        .no_expediente {
            min-width: 150px !important;
        }

        .no_oficio {
            min-width: 150px !important;
        }

        .delegacion_requerida {
            min-width: 170px !important;
        }

        .tipo_unidad_destino {
            min-width: 200px !important;
        }


        .carpeta_exhorto_asignada {
            min-width: 220px !important;
        }

        .participantes {
            min-width: 180px !important;
        }

        .unidad_asignada {
            min-width: 150px !important;
        }

        .responsable {
            min-width: 150px !important;
        }

        .situacion {
            min-width: 150px !important;
        }


        .td-title {
            background-color: #f0f2f7 !important;
            max-width: 70px !important;
            border-color: #f0f2f7 !important;
            max-height: 5px !important;
            padding: 3px 5px 3px 5px !important;
        }

        .th-title {
            column-span: 100%;
            background-color: #f0f2f7 !important;
            min-width: 120px !important;
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
            font-size: 16px;
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

        .ul {
            list-style: none;
        }

        .items {
            padding-right: 10px;
        }

        .items .item {
            flex: 1 0 25%;
            box-sizing: border-box;
            color: #171e42;
            padding: 10px;
            margin-bottom: 5px;
        }

        .icon {
            /* background: #154f89 !important; */
            padding: 1px 3px;
            border-radius: 25%;
            color: #fff;
            font-size: 15px;
            vertical-align: top;
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
    <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables-responsive/js/dataTables.responsive.js">
    </script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/moment/js/moment.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
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

        var id_unidad_session = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;

        $(function() {
            'use strict';


            // Select2
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });

            sec_ajax();

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

            // accionBuscarArchivo_ajax('primera');


            setTimeout(function() {
                $('#modal_loading').modal('hide');
            }, 1000);




        });

        
        function sec_ajax(pagina_accion) {

            $(document).ready( function() {
                $(".nav-tabs a").click( function() {
                    $(this).tab('show');
                });
            });

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
            if ( pagina <= 0 || pagina > $('#paginas_totales').val()) {} else {
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

                filtro = {
                    folio_solicitud: $("#foliosolicitud").val(),
                    folio_carpeta: $("#foliocarpeta").val(), //tipo solicitud
                    fecha_recepcionh: fechafin,
                    fecha_recepcion: fechaini,
                    medio_recepcion: $("#medio_recepcion").val(), //tipo solicitud
                    unidad_asignada: $("#unidadAsignada").val(), //tipo solicitud
                    estatus_flujo_actual: $("#situacion").val(), //tipo solicitud
                    pagina: 1,
                    registros_por_pagina: 1000000
                };

                var unidad_m = $("#unidadAsignada").val() == null ? id_unidad_session : $("#unidadAsignada").val();

                var modo = "completo";

                $('#modal_loading').modal('show');

                $.ajax({
                    type: 'GET',
                    url: '/public/obtener_exhortos',
                    // url:'/public/obtener_solicitudes',
                    data: {
                        modo: modo,
                        folio_solicitud: $("#foliosolicitud").val(), //folio solicitud
                        folio_carpeta: $("#foliocarpeta").val(), //tipo solicitud
                        fecha_recepcion: fechaini,
                        fecha_recepcionh: fechafin,
                        medio_recepcion: $("#medio_recepcion").val(), //tipo solicitud
                        unidad_asignada: unidad_m, //tipo solicitud
                        estatus_flujo_actual: $("#situacion").val(), //tipo solicitud
                        estatus_color: $("#estatus_color").val(), //tipo solicitud

                        pagina: $('#numeropagina').val(),
                        // registros_por_pagina:$('.pagina_actual_texto').val(),
                        registros_por_pagina: 10,
                    },

                    success: function(response) {

                        if (response.status == 100) {
                            let color;
                            let title;

                            var datos = response.response;

                            body = new $('#exhortosTable').dataTable({
                                processing: true,
                                data: datos,
                                columns: [{
                                        "data": "id_solicitud",
                                        "render": function(data, type, row, meta) {
                                            
                                            return `<i class="icon ion-ios-information" title="Información" style="cursor: pointer" onclick="ver_solicitud(${data})" id="informacion"></i> 
                                            <i class="icon ion-edit  d-none" title="Modificar" onclick = window.location.href="/editar_solicitud_exhorto/${data}" style="cursor: pointer" id="editar"></i>`;
                                             /*    + '<i class="icon ion-folder" title="Historial de Documentos" style="cursor: pointer" onclick="ver_documentos('+data+')" id="historial"></i> '
                                                + '<i class="icon ion-edit" title="Modificar" onclick="javascript:location.href=/editar_solicitud_audiencia_inicial/'+data+'" style="cursor: pointer" id="editar"></i> '
                                                + '<i class="icon ion-ios-download-outline"  title="Descargar PDF" style="cursor: pointer" onclick="descargar_pdf('+data+')" id="pdf"></i> '
                                                + '<i class="icon ion-code-download" title="Descargar XML" style="cursor: pointer" data-id="'+data+'" onclick="descargar_xml('+data+')" id="descargar_xml"></i> '
                                                + '<i class="icon ion-ios-list-outline" title="Consulta Log" style="cursor: pointer" onclick="ver_log('+data+')" id="log"></i> '
                                                + '<i class="icon ion-android-map" title="Consulta Flujo" style="cursor: pointer" onclick="ver_flujo('+data+')" id="flujo"></i> '
                                            */
                                        }
                                    },

                                    {
                                        "data": "estatus_semaforo",
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
                                            name = "estatus_semaforo";

                                            return '<i class="fas fa-lightbulb-o fa-lg" style="color:' +
                                                color + '" title="' + title +
                                                '" text-align="right" aria-hidden="true"></i>'

                                        }
                                    },
                                    {
                                        data: "folio_solicitud",
                                        title: "Folio de Registro (UGJ)"
                                    },
                                    {
                                        data: "fecha_asignacion",
                                        title: "Fecha de recepcion"
                                    },
                                    {
                                        data: "folio_carpeta",
                                        title: "Carpeta de Exhorto Asignada"
                                    },
                                    {
                                        data: "nombre_unidad",
                                        title: "Unidad Asignada"
                                    },

                                    {
                                        data: "personas[]",
                                        render: function(data, type, row, meta) {

                                            var delitos = "";
                                            $( data ).each( function( i, persona) {

                                                $( persona.delitos ).each( function( id, delito) {
                                                    
                                                    if( delito.delito == null )
                                                        delitos += delito.otro_delito;
                                                    else 
                                                        delitos += delito.delito;
                                                });
                                                
                                            });

                                            return delitos;
                                        }
                                    },
                                    {
                                        data: "exhorto_juzgado",
                                        title: "Juzgado Exhortante"
                                    },

                                    {
                                        data: "estado_exhorto",
                                        title: "Entidad Exhortante"
                                    },
                                    
                                    {
                                        data: "exhorto_nombre_juez",
                                        title: "Juez Exhortante"
                                    },
                                    {
                                        data: "exhorto_expediente_origen",
                                        title: "No de Expediente"
                                    },
                                    {
                                        data: "exhorto_num_folio",
                                        title: "No de Oficio"
                                    },
                                    {
                                        data: "municipio",
                                        title: "Delegacion Requerida"
                                    },
                                    {
                                        data: "exhorto_tipo_unidad",
                                        title: "Tipo de Unidad Destino"
                                    },
                                    {
                                        data: "exhorto_medio_recepcion",
                                        title: "Medio de recepcion"
                                    },
                                    {
                                        data: "personas[]",
                                        render: function(data, type, row, meta) {


                                            var personas = "";
                                            $(data).each(function(index, persona) {

                                                const {
                                                    nombre,
                                                    apellido_paterno,
                                                    apellido_materno
                                                } = persona.info_principal;
                                                const li = nombre + ` ` +
                                                    apellido_paterno + `<br>`;
                                                personas = personas.concat(li);
                                            });
                                            return personas
                                        },


                                    },
                                    {
                                        data: {},

                                        render: function(data, type, row, meta ) {
                                            
                                            var valor = '';

                                            if( data.estatus_flujo_actual == 'ASIGNADA CJ') 
                                                valor = data.estatus_flujo_actual+'<br>'+data.folio_carpeta;
                                            else 
                                                valor = data.estatus_flujo_actual;

                                            return valor;
                                        }

                                        // title: "Situación Actual"
                                    },
                                    {
                                        data: "responsable_registro",
                                        title: "Responsable del registro"
                                    }
                                ], //ATRIBUTOS
                                colReorder: {
                                    fixedColumnsLeft: 2
                                },
                                bDestroy: true,
                                colReset: true,
                                paging: false,
                                ordering: true,
                                info: false,
                                search: false,
                                filter: false,
                                stateSave: true,
                                upercase: true,
                            });
                            $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                            $('#paginas_totales').val(response.response_pag['paginas_totales'])


                        } else {
                            body = body.concat("<tr><td colspan='12'><h3>Sin datos relacionados</h3></td><tr>");
                            $("#body-table1").html(body);

                        }

                        setTimeout( () => {
                            $('#modal_loading').modal('hide');
                        }, 400);
                    }
                });
            }

        }

        function descargar_pdf(id_solicitud) {

            $.ajax({
                type: 'GET',
                url: 'public/descargar_pdf/' + id_solicitud,
                data: {

                },
                success: function(response) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);

                    if (response.status == 100) {
                        var win = window.open(response.response, '_blank');
                    } else {
                        $('#modalFail').modal('show');
                    }
                }
            });
        }

        function descargar_xml(id_solicitud) {
            $.ajax({
                type: 'GET',
                url: 'public/descargar_xml/' + id_solicitud,
                data: {

                },
                success: function(response) {

                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if (response.status == 100) {
                        var win = window.open(response.response, '_blank');
                    } else {
                        $('#modalFail').modal('show');
                    }
                }
            });
        }

        function ver_flujo(valor) {
            var id_solicitud = valor;
            $.ajax({
                type: "GET",
                url: "public/ver_flujo/" + id_solicitud,
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

            $('#modal_loading').modal('show');
            $("#modal_log_contenido").html("");

            var id_solicitud = valor;


            $.ajax({
                type: "GET",
                url: "public/ver_log/" + id_solicitud,
                data: {},

                success: function(response) {

                    $('#modal_loading').modal('hide');
                    $("#modal_log").modal("show");


                    var log = "";
                    log = decodeBase64(response.response['b64'])
                    $("#modal_log_contenido").html("<p>" + log + "</p>");



                },
            });
        }

        decodeBase64 = function(s) {
            var e = {},
                i, b = 0,
                c, x, l = 0,
                a, r = '',
                w = String.fromCharCode,
                L = s.length;
            var A = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
            for (i = 0; i < 64; i++) {
                e[A.charAt(i)] = i;
            }
            for (x = 0; x < L; x++) {
                c = e[s.charAt(x)];
                b = (b << 6) + c;
                l += 6;
                while (l >= 8) {
                    ((a = (b >>> (l -= 8)) & 0xff) || (x < (L - 2))) && (r += w(a));
                }
            }
            return r;
        };

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

        async function ver_solicitud(id_solicitud) {

            limpiarPDF();
            const doc_acuse = await obtener_acuse( id_solicitud );
            console.log(doc_acuse );
            if( doc_acuse.status == 100 ) {
                $('#nav-acuse').html(`
                    <object data="${doc_acuse.response}" type="application/pdf" id="pdfAcuse" style="width: 100%; height: 70vh;" class="d-none d-md-block"></object>
                    <div id="iconPDF" class="tx-center pd-t-15 d-md-none" style="width: 100%; display: flex;">
                        <a id="enlaceAcuse" href="${doc_acuse.response}" target="_blank" style="border: 1px solid #EEE;padding: 1em;margin-top: 1em;min-width: 100%;">
                            <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:1.8rem;position: relative; color: #C6362D; margin-right: 0.2em"></i>Acuse.pdf 
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </a>
                    </div>
                `)
            }
                

            $.ajax({
                type: 'GET',
                url: '/public/ver_exhorto',
                data: {
                    // modo:modo,
                    id_solicitud: id_solicitud,
                    pagina: 1,
                    // registros_por_pagina:$('.pagina_actual_texto').val(),
                    registros_por_pagina: 10,
                },
                success: function(response) {

                    
                    if (response.status == 100) {

                        solicitudes = response.response;
                        $.each(response.response, function(index, solicitud) {

                            const {personas,id_solicitud} = solicitudes[index];

                            let listaNorelacionados = [];

                            let listaSujetos = [];
                            let acordeones = [];
                            let listaArchivos = "";

                            let version = "";


                            

                            $.ajax({
                                type: 'GET',
                                url: 'public/descargar_pdf_exhorto',
                                data: { id_solicitud },
                                success: function(response) {

                                    setTimeout(function() {
                                        $('#modal_loading').modal('hide');
                                    }, 500);

                                    $(response).each(function(index, archivo) {

                                        let tipo = "";
                                        let icono = "";
                                        let extension_archivo = "";

                                        const { nombre_archivo, id_documento, id_version } = archivo;
                                        console.log(archivo);
                                        extension_archivo = nombre_archivo.split('.');
                                        if (extension_archivo[1] == "doc" || extension_archivo[1] == "docx") {
                                            icono = "far fa-file-word";
                                        } else if (extension_archivo[1] == "pdf") {
                                            icono = "fa fa-file-pdf-o";
                                        } else if (extension_archivo[1] == "jpg" ||
                                            extension_archivo[1] == "png") {
                                            icono = "far fa-file-image";
                                        } else if (extension_archivo[1] == "xls" ||
                                            extension_archivo[1] == "xlsx") {
                                            icono = "far fa-file-excel-o";
                                        } else {
                                            icono = "fa fa-file-pdf-o";
                                        }


                                        const li = `
                                            <a href="javascript:void(0)" onclick="descargar_archivo('${id_solicitud}','${id_version}');" style="border: 1px solid #EEE; border: 1px solid #EEE;display: block;padding: 5px 12px; margin-bottom: 5px;" class="pd-b-10">
                                                <i class="${icono} fa-2x" style="font-size: 1.5em; position: relative; color: #C6362D; margin-right: 0.2em"> </i>
                                                ${nombre_archivo == '.' ? ('Documento' + (index +1 )) : nombre_archivo}
                                                <i class="fa fa-download d-inline-block d-md-none" aria-hidden="true"></i>
                                            </a>
                                            
                                        `;

                                        listaArchivos = listaArchivos.concat(li);
                                        
                                        
                                    });

                                    $('#documentos-relacionados').html(`<div class="items ">${listaArchivos}</div> `);

                                    if( !(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) )
                                        $('#documentos-relacionados a:first-child').click();
                                }
                            });




                            //PERSONAS
                            $(personas).each(function(index_p, persona) {

                                let tablaDireccion = '';
                                let tablaAlias = '';
                                let tablaContacto = '';
                                let tablaCorreo = '';
                                let tablaDatos = '';
                                let tablaDelitos = '';

                                //DIRECCIONES
                                $(persona.direcciones).each(function(index_d, direccion) {

                                    const {
                                        calle,
                                        codigo_postal,
                                        colonia,
                                        entre_calles,
                                        estado,
                                        municipio,
                                        referencias,
                                        no_exterior,
                                        no_interior
                                    } = direccion;


                                    tablaDireccion = tablaDireccion + ` 
                                        <tr align="center" > <th colspan="100%" class="th-title">Direcciones</th> </tr>

                                        <tr>
                                            <td class="td-title">Calle</td>
                                            <td>${calle ?? "Sin datos"}</td>

                                            <td class="td-title">Número Exterior</td>
                                            <td>${no_exterior ?? "Sin datos"}</td>
                                        </tr>

                                        <tr>
                                            <td class="td-title">Número Interior</td>
                                            <td>${no_interior ?? "Sin datos"}</td>

                                            <td class="td-title">Colonia</td>
                                            <td>${colonia ?? "Sin datos"}</td>
                                        </tr>

                                        <tr>
                                            <td class="td-title">Municipio</td>
                                            <td>${municipio ?? "Sin datos"}</td>

                                            <td class="td-title">Estado</td>
                                            <td>${estado ?? "Sin datos"}</td>
                                        </tr>

                                        <tr>
                                            <td class="td-title">Código Postal</td>
                                            <td>${codigo_postal ?? "Sin datos"}</td>

                                            <td class="td-title">Referencias</td>
                                            <td>${referencias ?? "Sin datos"}</td>
                                        </tr>
                                    `;
                                });

                                tabla_direcciones[index_p] = tablaDireccion;


                                //DELITOS PERSONAS
                                if (persona.delitos.length) {
                                    $(persona.delitos).each(function(index_de, delitoo) {

                                        const {
                                            calificativo,
                                            forma_comision,
                                            grado_realizacion,
                                            delito,
                                            nombre_modalidad
                                        } = delitoo;

                                        tablaDelitos = tablaDelitos + `<tr><td>${delito ?? ""}</td></tr>`;
                                    });

                                    tabla_delitos[index_p] = `<tr align="center"><th colspan="100%" class="th-title">Delito Relacionado </th></tr>` + tablaDelitos;
                                } else {
                                    tabla_delitos[index_p] = `<tr> </tr>`;
                                }

                                //ALIAS ALIAS ALIAS ALIAS
                                $(persona.alias).each(function(index_a, aliases) {

                                    const {
                                        alias
                                    } = aliases;
                                    tablaAlias = tablaAlias + `${alias} <br>`;

                                });
                                tabla_alias[index_p] = tablaAlias;



                                //CONTACTO
                                $(persona.contacto).each(function(index_c, contact) {


                                    const {
                                        contacto,
                                        tipo_contacto
                                    } = contact;
                                    
                                    if (tipo_contacto == "correo electronico") {

                                        tablaCorreo = tablaCorreo + `${contacto} <br>`;
                                    } else {
                                        tablaContacto = tablaContacto +
                                            ` ${tipo_contacto} : ${contacto} <br> `;
                                    }
                                });
                                tabla_contacto[index_p] = tablaContacto;
                                tabla_correo[index_p] = tablaCorreo;



                            });

                            //acords
                            // INFO SOLICITUD PERSONAS
                            $(personas).each(function(index, sujetosProcesales) {

                                const {
                                    info_principal
                                } = sujetosProcesales;

                                const tablaSujeto = `
                                    <table class="dataTables">
                                        <tr>
                                            <td class="td-title">Cálidad Jurídica</td>
                                            <td>${info_principal.calidad_juridica ?? "Sin datos"}</td>

                                            <td class="td-title">Género</td>
                                            <td>${info_principal.genero ?? "Sin datos"}</td>

                                        </tr>

                                        <tr>
                                            <td class="td-title">Edad</td>
                                            <td>${info_principal.edad ?? "Sin datos"}</td>

                                            <td class="td-title">Fecha de Nacimiento</td>
                                            <td>${info_principal.fecha_nacimiento ?? "Sin datos"}</td>

                                        </tr>

                                        <tr>
                                            <td class="td-title">¿Es mexicano?</td>
                                            <td>${info_principal.es_mexicano ?? "Sin datos"}</td>

                                            <td class="td-title">Tipo de persona</td>
                                            <td>${info_principal.tipo_persona ?? "Sin datos"}</td>

                                        </tr>

                                    </table>
                                    <br>

                                    <table class="dataTables">
                                        <td>${tabla_direcciones[index] }</td>
                                    </table>
                                    <br>
                                    <table class="dataTables">
                                        <tr>
                                            <td class="td-title">Teléfono (s)</td>
                                            <td class="td-title">Correo(s) Electrónico(s)</td>
                                            <td class="td-title">Alias</td>
                                        </tr>

                                        <tr>
                                            <td>${tabla_contacto[index] ?? "Sin datos"}</td>
                                            <td>${tabla_correo[index] ?? "Sin datos"} </td>
                                            <td>${tabla_alias[index] ?? "Sin datos"}</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table class="dataTables">
                                        <tr>
                                            <td>${tabla_delitos[index]}</td>
                                        </tr>
                                    </table> 
                                    <br> 
                                `;



                                const accordion = `
                                    <h4 class="panel-title">
                                        <button class="accordion" data-toggle="collapse" href="#collapse${index}">
                                            <strong> ${info_principal.nombre ?? ""} ${info_principal.apellido_paterno ?? ""} ${info_principal.apellido_materno ?? ""} ${info_principal.razon_social ?? ""} </strong>
                                        </button>
                                    </h4>

                                    <div id="collapse${index}" border-style="solid" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            ${tablaSujeto}
                                        </div>
                                    </div>
                                `;


                                listaSujetos = listaSujetos.concat(tablaSujeto);
                                acordeones = acordeones.concat(accordion);



                                $('#acordeon').html(acordeones);

                            });




                            $('#datosolicitudRes').html(`
                                <tr align="center">
                                    <td class="td-title" style="width:100%">Resumen</td>
                                </tr>
                                <tr>
                                    <td>${solicitud.exhorto_resumen ?? "Sin datos"}</td>
                                </tr>
                            `);



                            $('#datosolicitud').html(` 
                                <tr>
                                    <td class="td-title">Creación</td>
                                    <td>${solicitud.creacion ?? "Sin datos"}</td>
                                    <td class="td-title">Estatus</td>
                                    <td>${solicitud.estatus_flujo_actual ?? "Sin datos"}</td>
                                </tr>
                                <tr>
                                    <td class="td-title">Folio de carpeta</td>
                                    <td>${solicitud.folio_carpeta ?? "Sin datos"}</td>
                                    <td class="td-title">Juzgado</td>
                                    <td>${solicitud.exhorto_juzgado ?? "Sin datos"}</td>
                                </tr>
                                <tr>
                                    <td class="td-title">Folio de solicitud</td>
                                    <td>${solicitud.folio_solicitud ?? "Sin datos"}</td>
                                </tr>
                                <br>
                            `);

                            $('#modal-ver').modal('show');

                        });


                    } else {
                        alert("Error , Comuniquese con Soporte");

                    }
                }
            });


        }

        function obtener_acuse( id_exhorto ) {

            return new Promise( resolve =>{

                $.ajax({
                    method: 'GET',
                    url: '/public/obtener_acuse_exhorto',
                    data: {id_exhorto},
                    success: function(response) {
                        console.log(response);
                        resolve(response);
                    }
                });

            });

        }

        function descargar_archivo( id_solicitud, version ) {

            $.ajax({
                type: 'GET',
                url: 'public/descargar_pdf_exhorto',
                data: { id_solicitud, version },
                success: function(response) {

                    if (response.response) {

                        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
                            window.open(response.response, '_blank');

                        else
                            $('#documentoPDFrame').attr('src', response.response);
                            // mostrarModalDocumento();
                        

                    } else if (response.status == 0) {
                        $('#modalFail').modal('show');
                    }

                }
            });


        }

        function limpiarPDF() {
            
            $('#documentoPDFrame').attr('src', ''); //text
            $('#nav-acuse').html('')

        }

        function descargar_consulta(extension) {

            let orden_columnas = get_orden_columnas();

            $('#modal_loading').modal('show');
            $.ajax({
                type: 'GET',
                url: '/exportar_busqueda_exhortos',
                data: {
                    id_solicitud: filtro.folio_solicitud,

                    folio_carpeta: filtro.folio_carpeta,
                    fecha_recepcion: filtro.fecha_recepcion,
                    fecha_recepcionh: filtro.fecha_recepcionh,
                    medio_recepcion: filtro.medio_recepcion,
                    unidad_asignada: filtro.unidad_asignada,


                    pagina: filtro.pagina,
                    registros_por_pagina: filtro.registros_por_pagina,
                    extension: extension,
                    orden_columnas: orden_columnas,
                },
                success: function(data) {
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

        function get_orden_columnas() {
            let campos_title = [{
                    campo: "id_solicitud",
                    titulo: "Folio de Carpeta"
                },
                {
                    campo: "folio_carpeta",
                    titulo: "ID Acuerdo"
                },
                {
                    campo: "fecha_recepcion",
                    titulo: "Fecha de recepcion1"
                },
                {
                    campo: "fecha_recepcionh",
                    titulo: "Fecha de recepcion"
                },
                {
                    campo: "medio_recepcion",
                    titulo: "Medio de recepcion"
                },
                {
                    campo: "unidad_asignada",
                    titulo: "Unidad Asignada"
                },
                {
                    campo: "estatus_flujo",
                    titulo: "Estatus del flujo"
                },
                {
                    campo: "estatus_color",
                    titulo: "Estatus color"
                },
            ];
            let columnas = [];
            $('#acuerdosTable thead tr th').each(function() {
                let columna = campos_title.filter(index => index.titulo == ($(this).attr('name') == 'semaforo' ? 'Semaforo' : $(this).text()));
                if (columna.length) {
                    columnas.push({
                        titulo: columna[0].titulo,
                        campo: columna[0].campo
                    });
                }
            });
            return columnas;
        }
    </script>
@endsection



@section('seccion-modales')

    {{-- VER SOLICITUD --}}
    <div id="modal-ver" class="modal fade" data-keyboard="false">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">


                <div class="modal-body">


                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aling="right" aria-hidden="true">&times;</span>
                    </button>


                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">Datos de la Solicitud</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false">Personas</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                role="tab" aria-controls="nav-contact" aria-selected="false">Documentos Relacionados</a>
                            <a class="nav-item nav-link" id="nav-acuse-tab" data-toggle="tab" href="#nav-acuse"
                                role="tab" aria-controls="nav-acuse" aria-selected="false">Acuse</a>
                        </div>
                    </nav>
                    <br>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <table id="datosolicitud" class="dataTables"> </table>
                            <br>
                            <table id="datosolicitudRes" class="dataTables"> </table>
                        </div>

                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


                            <div class="accordion" id="acordeon" role="tablist"> </div>

                            {{-- <table id="datosparticipantes" class="dataTables"> </table> --}}
                        </div>

                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                            <div class="box">
                                <div class="row">
                                    <div id="documentos-relacionados" class="col-12 col-md-3">
                                    </div>
                                    <div style="" class="col-9 d-none d-md-inline-block" >
                                        <iframe frameborder="0" allowfullscreen src="" id="documentoPDFrame" style="width: 100%; height: 65vh;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-acuse" role="tabpanel" aria-labelledby="nav-acuse-tab">

                            
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
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


@endsection
