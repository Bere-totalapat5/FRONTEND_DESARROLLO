@php
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\utilidades;
$humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Promociones</a></li>
        <li class="breadcrumb-item"><a href="#"> Consulta de Aclaratorios</a></li>
    </ol>
    <h6 class="slim-pagetitle"> Consulta de Aclaratorios</h6>
@endsection


@section('contenido-principal')

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
                                        <label class="label">Id Acuse :</label>
                                        <input class="form-control" type="text" value="" name="" id="idPromocion"
                                            placeholder="">
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Folio: </label>
                                        <input class="form-control" type="text" value="" name="" id="foliopromocion"
                                            placeholder="">
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
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA"
                                                value="" id="fechasolicitud" name="" autocomplete="off">
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
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA"
                                                value="" id="fechasolicitudh" name="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>




                                <div class="col-lg-3">
                                    <label class="form-control-label">Estatus Actual:</label>
                                    <div class="form-group">
                                        <select class="form-control-lg select2 valid" width='100%' autocomplete="off"
                                            id="estatusactual">
                                            <option selected disabled value="">Elija una opción</option>
                                            <option value="-">{{ 'TODOS' }}</option>
                                            <option value="REGISTRADA">{{ 'REGISTRADA' }}</option>
                                            <option value="VISTO">{{ 'VISTO' }}</option>
                                            <option value="RESOLUCION ASIGNADA">{{ 'RESOLUCION ASIGNADA' }}</option>
                                            <option value="RESUELTO">{{ 'RESUELTO' }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3" width='100%'>
                                    <label class="form-control-label">Estatus semaforo:</label>
                                    <div class="form-group" width='100%'>
                                        <select class="form-control-lg select2 valid" width='100%' autocomplete="off"
                                            id="estatus_color">
                                            <option selected disabled value="">Elija una opción</option>
                                            <option value="">{{ 'Todas' }}</option>
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
            </div>

            <div id="table-firmas" class="mg-b-20">
                <table id="promocionesTable" class="display dataTable dtr-inline collapsed d-block"
                    style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>
                            <th class="acciones" name="acciones">Acciones</th>
                            <th class="semaforo" name="semaforo"> </th>
                            <th style="cursor:pointer" class="folio_promocion" name="folio_promocion"> ID Acuse</th>
                            <th style="cursor:pointer" class="folio_promocion" name="folio_promocion"></th>
                            <th style="cursor:pointer" class="fecha_registro" name="fecha_registro"></th>
                            <th style="cursor:pointer" class="folio_carpeta" name="folio_carpeta">Carpeta Judicial</th>
                            <th style="cursor:pointer" class="tipo_solicitud" name="tipo_solicitud">Unidad receptora</th>
                            <th style="cursor:pointer" class="tipo_requerimiento" name="tipo_requerimiento">Tipo de
                                requerimiento</th>
                            <th style="cursor:pointer" class="nombre_promovente" name="nombre_promovente">Nombre del
                                Promovente</th>
                            <th style="cursor:pointer" class="figura_juridica" name="figura_juridica">Figura Juridica</th>
                            <th style="cursor:pointer" class="situacion_" name="situacion">Situacion</th>
                            <th style="cursor:pointer" class="responsable" name="responsable">Responsable</th>
                        </tr>
                    </thead>
                    <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">
                    </tbody>
                </table>
            </div>

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
            </div>

        </div>

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">


        <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;">
        </div>
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

@endsection



@section('seccion-estilos')
    <link href="{{ asset('/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
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


        @media screen and (max-width: 600px) {}

        #modal-ver .modal-dialog {
            width: 100%;
            max-width: 80%;
            height: 90%;
            margin: 0;
            padding: 1;
            font-size: 16px;
        }

        #modal-ver .modal-dialog {
            width: 100%;
            max-width: 80%;
            height: 90%;
            margin: 0;
            padding: 1;
            font-size: 16px;
        }

        table {
            width: calc(100% - 2px) !important;
            border-bottom: 1px solid #f0f2f7;
        }

        table .fas, .far {
          background: #848F33 ;
          padding: 5px 5px;
          border-radius: 25%;
          color: #fff;
        }

        td,
        th {
            padding-left: 1px !important;
            padding-right: 3px !important;
            padding-top: 0px;
            padding-bottom: px !important;
            border-bottom: 1px solid #f0f2f7;
            max-width: 110px !important;
            font-size: 16px;
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

        .id_promocion {
            min-width: 125px !important;
        }

        .folio_promocion {
            min-width: 130px !important;
        }

        .materia_destino {
            min-width: 120px !important;
        }

        .situacion_ {
            min-width: 160px !important;
        }

        .responsable {
            min-width: 120px !important;
        }

        .nombre_promovente {
            min-width: 210px !important;
        }

        .tipo_solicitud {
            min-width: 200px !important;
        }

        .tipo_requerimiento {
            min-width: 200px !important;
        }

        .tipo_audiencia {
            min-width: 200px !important;
        }

        .figura_juridica {
            min-width: 200px !important;
        }

        .semaforo {
            min-width: 50px !important;
            text-align: center;
            size: 20px;
            vertical-align: top;
        }


        .carpeta-investigacion {
            min-width: 220px !important;
        }

        .fecha_registro {
            min-width: 180px !important;
        }

        .folio_carpeta {
            min-width: 150px !important;
        }

        .estatus_urgente {
            min-width: 100px !important;
        }

        .td-title {
            background-color: #f0f2f7 !important;
            min-width: 50px !important;
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


        .accordion {
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
        }


        .panel {

            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: 0.2s ease-out;
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

            accionBuscarArchivo_ajax('primera');

            setTimeout(function() {
                $('#modal_loading').modal('hide');
            }, 1500);

        });

        function accionBuscarArchivo_ajax(pagina_accion) {}

        function sec_ajax(pagina_accion) {


            let body = "";
            pagina = parseInt($("#pagina_actual").val());
            registros_por_pagina = 10;

            if (pagina_accion == "primera") {
                pagina = 1;
            } else if (pagina_accion == "avanzar") {
                pagina = pagina + 1;
            } else if (pagina_accion == "atras") {
                pagina = pagina - 1;
            } else if (pagina_accion == "ultima") {
                pagina = $("#paginas_totales").val();
            }

            $("#pagina_actual").val(pagina);
            $("#numeropagina").val(pagina);
            $(".pagina_actual_texto").html(pagina);

            let id_solicitud = "";
            const format1 = "YYYY-DD-MM";

            var foliocarpeta = $("#foliocarpeta").val();
            var estatus_flujo_actual = $("#estatusactual").val();
            var foliopromocion = $("#foliopromocion").val();

            var fechaini = $("#fechasolicitud").val();
            var fechafin = $("#fechasolicitudh").val();

            var fechaini = fechaini.replace("/", "-");
            var fechafin = fechafin.replace("/", "-");

            var fechaini = fechaini.replace("/", "-");
            var fechafin = fechafin.replace("/", "-");

            $.ajax({
                type: "GET",
                url: "/public/obtener_aclaratorios",
                data: {
                    id_promocion: $("#idPromocion").val(),
                    folio_promocion: foliopromocion,
                    folio_carpeta: foliocarpeta,

                    fecha_recepcion: fechaini,
                    fecha_recepcionh: fechafin,
                    estatus_flujo_actual: estatus_flujo_actual,
                    estatus_semaforo: $("#estatus_color").val(),
                    pagina: $("#numeropagina").val(),
                    registros_por_pagina: 10,
                },

                success: function(response) {
                    if (response.status == 100) {
                        let color;
                        let title;

                        var datos = response.response;

                        var body = new $("#promocionesTable").dataTable({
                            processing: true,
                            data: datos,
                            columns: [{
                                    data: "id_promocion",
                                    render: function(data, type, row, meta) {
                                        return (
                                            '<i class="fas fa-info-circle" title="Información" style="cursor: pointer" onclick="ver_promocion(' +
                                            data + ')" id="informacion"></i> ' +

                                            '<i class="fas fa-download"  title="Descargar PDF" style="cursor: pointer" onclick="descargar_pdf(' +
                                            data + ')" id="pdf"></i> ' +

                                            '<i class="fas fa-laptop-code" title="Consulta Log" style="cursor: pointer" onclick="ver_log(' +
                                            data + ')" id="log"></i> ' +

                                            '<i class="fas fa-project-diagram" title="Consulta Flujo" style="cursor: pointer" onclick="ver_flujo(' +
                                            data + ')" id="flujo"></i> ' +

                                            '<i class="fas fa-stream" title="Descargar XML" style="cursor: pointer" data-id="' +
                                            data + '" onclick="descargar_xml(' + data + ')" id="descargar_xml"></i>'
                                        );
                                    },
                                },
                                {
                                    data: "estatus_semaforo",
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
                                        } else if (data) {
                                            color = "rojo";
                                            title = "Visualización pendiente";
                                        }
                                        return '<i class="fa fa-lightbulb-o fa-lg" style="color:' +
                                            color + '" title="' + title +
                                            '" text-align="right" aria-hidden="true"></i>';
                                    },
                                },
                                {
                                    data: "id_promocion",
                                    title: "ID Acuse"
                                },

                                {
                                    data: "folio_promocion",
                                    title: "Folio"
                                },
                                {
                                    data: "fecha",
                                    title: "Fecha/hora de registro"
                                },
                                {
                                    data: "folio_carpeta",
                                    title: "Carpeta Judicial"
                                },
                                {
                                    data: "nombre_unidad",
                                    title: "Unidad receptora"
                                },
                                {
                                    data: "tipo_requerimiento",
                                    title: "Tipo de Requerimiento"
                                },
                                {
                                    data: "nombre_promovente_ingresado",
                                    render: function(data, type, row, meta) {
                                        var nombre = "";
                                        nombre = row.nombre_promovente + row.nombre_promovente_ingresado + row.razon_social;
                                          return nombre
                                    },
                                },
                                {
                                    data: "promovente_calidad_juridica",
                                    render: function(data, type, row, meta) {
                                        var caljur = "";
                                        if (data) {
                                            caljur = data;
                                        } else {
                                            caljur = "sin calidad juridica";
                                        }

                                        return caljur;
                                    },
                                },
                                {
                                    data: "estatus_flujo_actual",
                                    title: "Situación"
                                },
                                {
                                    data: "responsable",
                                    title: "Responsable"
                                },
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
                        $(".pagina_total_texto").html(response.response_pag["paginas_totales"]);
                        $("#paginas_totales").val(response.response_pag["paginas_totales"]);
                    } else {
                        body = "<tr><td colspan='12'><h3>Sin datos relacionados</h3></td><tr>";
                        $("#body-table1").html(body);
                    }
                },
            });
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
                url: '/public/obtener_aclaratorios',
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
                                resumen,
                                tipo_audiencia,
                                tipo_promocion,
                                tipo_requerimiento,
                                nombre_promovente_ingresado,
                                nombre_promovente,
                                cuerpoTexto,
                                tipo_persona,
                                creacion,
                                origen

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
                                                "<td align='center'>"+calidad_juridica+"</td>"+
                                               "</tr>";

                                    listaNorelacionados = listaNorelacionados.concat(li);

                                });
                                $('#datosno-asociados').html("<tr align='center'>"+
                                                "<td class='td-title'>Nombres</td>"+
                                                "<td class='td-title'>Apellido Paterno</td>"+
                                                "<td class='td-title'>Apellido Materno</td>"+
                                                "</tr>"+
                                                "<tr>"+listaNorelacionados+"</tr>");

                            } else {
                                $('#datosno-asociados').html("<tr align='center'>"+
                                                             "<td class='td-title'>Sin personas NO Relacionadas</td>"+
                                                             "</tr>"+
                                                             "<tr>"+listaNorelacionados+"</tr>");
                            }

                            var nombre_promo = "";
                            var tipo_req     = "";

                            if(tipo_persona == "fisica"){
                              if(nombre_promovente){
                                nombre_promo = nombre_promovente;
                              }
                              if(nombre_promovente_ingresado){
                                nombre_promo = nombre_promovente_ingresado;
                              }
                            }
                            if(tipo_persona == "moral"){
                                nombre_promo = razon_social;
                            }
                            if(origen == "XML"){
                              nombre_promo = "MINISTERIO PÚBLICO";
                            }

                            if(!tipo_requerimiento || tipo_requerimiento == null){
                              tipo_req = "";
                            }
                            else{
                              tipo_req = tipo_requerimiento;
                            }


                            $('#datosolicitud').html("<table class='dataTables'>"+
                                                    "<tr>"+
                                                    "<td class='td-title'>Origen registro</td>"+
                                                    "<td>"+origen+"</td>"+
                                                    "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Folio</td>"+
                                                     "<td>"+folio_promocion+"</td>"+
                                                     "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Nombre del Promovente</td>"+
                                                     "<td>"+nombre_promo+"</td>"+
                                                     "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Folio de Carpeta</td>"+
                                                     "<td>"+folio_carpeta+"</td>"+
                                                     "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Tipo de requerimiento</td>"+
                                                     "<td>"+tipo_req+"</td>"+
                                                     "</tr>"+
                                                     "<tr>"+
                                                     "<td class='td-title'>Fecha/hora de recepción</td>"+
                                                     "<td>"+creacion+"</td>"+
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
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos de la Promocion</a>
                        {{-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Promovente</a> --}}
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Personas autorizadas a recibir documentacion </a>
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


@endsection
