@php
    use App\Http\Controllers\clases\humanRelativeDate;
    use App\Http\Controllers\clases\utilidades;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Solicitudes</a></li>
        <li class="breadcrumb-item"><a href="#"> Consulta de Solicitudes PRO-MUJER</a></li>
    </ol>
    <h6 class="slim-pagetitle"> Consulta de Solicitudes PRO-MUJER</h6>
@endsection

@section('contenido-principal')

    
    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">

            <div class="d-flex justify-content-between" style="align-items: center;">
                <a style="border:1px solid #ccc; width: 70px; height: 45px;" data-toggle="collapse" data-parent="#accordion"
                    href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance"
                    class="btn btn-default">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <i class="fas fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i>
                </a>
                <div class="row justify-content-end" style="width:80%;">
                    <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">
                    @foreach ($acciones as $acc)
                        @if ($acc['id_vista_accion'] == 14 and $acc['valor'] != 0)
                            <div class="col-sm-2 pd-t-10" align="right">
                                <a href="javascript:void(0);" onclick="descargar_consulta('xls');"
                                    class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div id="collapseSearchAdvance" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                            <div>
                                <form class="row mg-b-25" autocomplete="nope">

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Id Acuse :</label>
                                            <input class="form-control" type="text" value="" name="" id="idsolicitud"
                                                placeholder="">
                                        </div>
                                    </div>
    
                                    <div class="col-lg-3">
                                        <label class="label">Estatus:</label>
                                        <div class="form-group">
                                            <select class="form-control-lg select2 valid" id="estatussemaforo">
                                                <option selected disabled value="">Elija una opción</option>
                                                <option value="">{{ 'TODAS' }}</option>
                                                <option value="rojo">{{ 'Visualizacion Pendiente' }}</option>
                                                <option value="amarillo">{{ 'Visto' }}</option>
                                                <option value="verde">{{ 'Atendida' }}</option>
    
                                            </select>
                                        </div>
                                    </div>
    
    
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Folio de solicitud : </label>
                                            <input class="form-control" type="text" value="" name="" id="foliosolicitud"
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
                                            <label class="label">Fecha de solicitud (Desde): </label>
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
                                            <label class="label">Fecha de solicitud (Hasta): </label>
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

                                </form>
                            </div><!-- row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" id="filtrarBtn" onclick="sec_ajax('primera');">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <div class="mg-b-20">
                <table id="consultaPromujerTable" class="display dataTable dtr-inline collapsed d-block"
                    style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>
                            <th class="acciones" name="acciones">Acciones</th>
                            <th class="semaforo" name="semaforo"> </th>
                            <th style="cursor:pointer" class="id_solicitud" name="id_solicitud">ID Acuse</th>
                            <th style="cursor:pointer" class="folio_solicitud" name="folio_solicitud">Folio de solicitud
                            </th>
                            <th style="cursor:pointer" class="fecha_registro" name="fecha_registro">Fecha/hora de registro
                            </th>
                            <th style="cursor:pointer" class="folio_carpeta" name="folio_carpeta">Carpeta Judicial</th>
                            <th style="cursor:pointer" class="juez" name="juez">Juez</th>
                            <th style="cursor:pointer" class="estatus" name="estatus">Estatus Flujo Actual</th>
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

        </div><!-- pagination-wrapper -->

        <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
        <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
        <input type="hidden" id="numeropagina">

        <input type="hidden" id="pagina_actual2" value="1">
        <input type="hidden" id="paginas_totales2" value="1">

    </div>

@endsection



@section('seccion-estilos')

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/dropzone.min.css') }}">
    <link href="{{ asset('/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">

    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>

        
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
            max-width: 700px;
            height: 90%;
            margin: 0;
            padding: 1;
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
        }

        span.select2-container.select2-container--default {

            width: 100% !important;
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

        .acciones {
            min-width: 160px !important;
        }

        .ref {
            min-width: 80px !important;

        }

        .id_solicitud {
            min-width: 190px !important;
        }

        .folio_solicitud {
            min-width: 190px !important;
        }

        .tipo_audiencia {
            min-width: 200px !important;
        }


        .fecha_registro {
            min-width: 200px !important;
        }

        .folio_carpeta {
            min-width: 200px !important;
        }

        .juez {
            min-width: 200px !important;
        }

        .estatus_ {
            min-width: 160px !important;
        }

        .estatus {
            min-width: 300px !important;
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



        .concepto {
            min-width: 86px !important;
        }

        .importe {

            min-width: 80px !important;
        }


        textarea {

            background-color: white !important;
            min-height: 150px !important;
            width: 100% !important;
        }

        .semaforo {
            min-width: 30px !important;
            text-align: right;
            size: 20px;
            vertical-align: top;
        }

        .estado_solicitud {
            min-width: 110px !important;
        }

        td.acciones {
            font-size: 25px !important;
            vertical-align: top;
            display: inline-block;

        }

        .ul {
            list-style: none;
        }

        .items {
            display: flex;
            flex-wrap: wrap;
            inline-size: min-content;
        }

        .items .item {
            flex: 1 0 25%;
            box-sizing: border-box;

            color: #171e42;
            padding: 10px;
        }

        .icon {
            /* background: #154f89 !important; */
            padding: 1px 3px;
            border-radius: 25%;
            color: #fff;
            font-size: 15px;
            vertical-align: top;
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
            /*  background-color: #ccc; */
        }



        .panel {

            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: 0.2s ease-out;
        }

        #documentoPDFrame {
            min-height: 550px;
            min-width: 100%;

        }

        #modal-ver .modal-dialog {
            font-size: 18px;
            width: 100%;
            max-width: 80%;
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

        .box {
            display: flex;
            align-items: stretch;
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
        let lista_archivos = [];
        let listaArchivos = [];
        let tabla_contacto = [];
        let tabla_correo = [];

        let tabla_datos = [];
        let tabla_delitos = [];
        let tabla_no_relacionados = [];

        var filtro = null; // variable que almacena el filtro de busqueda para la exportacion a XSL o PDF
        var id_unidad_sesion = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;

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
            }, 1000);




        });

        function accionBuscarArchivo_ajax(pagina_accion) {}

        function cerrar_modal(valor) {
            $("#" + valor).modal('hide');
        }

        function descargar_pdf(id_solicitud) {
            $.ajax({
                type: 'GET',
                url: 'public/descargar_pdf/' + id_solicitud,
                data: {},
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

        function ver_log(valor) {
            var id_solicitud = valor;
            $.ajax({
                type: "GET",
                url: "public/ver_log/" + id_solicitud,
                data: {},
                success: function(response) {
                    var win = window.open('http://155.94.139.2:8083/archivo.log', '_blank');
                },
            });
        }

        function sec_ajax(pagina_accion) {
            $(document).ready(function() {
                $(".nav-tabs a").click(function() {
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

            if (pagina <= 0 || pagina > $('#paginas_totales').val()) {} else {
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
                        pagina: 1,
                        registros_por_pagina: 1000000
                    })
                );

                // se almacena parametros de busqueda en filtro
                filtro = {
                    modo: "",
                    id_solicitud: $("#idsolicitud").val(),
                    folio_solicitud: $("#foliosolicitud").val(),
                    folio_carpeta: $("#foliocarpeta").val(),
                    tipo_solicitud: "PRO-MUJER",
                    estatus_semaforo: $("#estatussemaforo").val(),
                    pagina: $('#numeropagina').val(),
                    registros_por_pagina: 1000000,
                };

                fecha_recepcion_min =  $('#fechasolicitud').val().split('/').reverse().join('-');
                fecha_recepcion_max =  $('#fechasolicitudh').val().split('/').reverse().join('-');    

                $.ajax({
                    type: 'GET',
                    url: '/public/obtener_solicitud_promujer',
                    data: {
                        modo: "",
                        id_solicitud: $("#idsolicitud").val(),
                        folio_solicitud: $("#foliosolicitud").val(),
                        folio_carpeta: $("#foliocarpeta").val(),
                        tipo_solicitud: "PRO-MUJER",
                        estatus_semaforo: $("#estatussemaforo").val(),
                        fecha_recepcion_min: fecha_recepcion_min,
                        fecha_recepcion_max: fecha_recepcion_max,
                        id_unidad: id_unidad_sesion == 0 ? '-' : id_unidad_sesion,
                        pagina: $('#numeropagina').val(),
                        registros_por_pagina: 10,
                    },
                    success: function(response) {

                        console.log(response);

                        if (response.status == 100) {
                            let color;
                            let msg;

                            var datos = response.response;
                            // onclick="window.location.href=/editar_solicitud_audiencia_inicial/"'+data+'
                            var body = new $('#consultaPromujerTable').dataTable({
                                processing: true,
                                data: datos,
                                columns: [{
                                        "data": "id_solicitud",
                                        "render": function(data, type, row, meta) {
                                            return '<i class="icon ion-ios-information" title="Información" style="cursor: pointer" onclick="ver_solicitud(' +
                                                data + ')" id="informacion"></i> ' +
                                                '<i class="icon ion-edit" title="Modificar"  onclick=window.location.href="promujer_edita_solicitud/' +
                                                data +
                                                '" style="cursor: pointer" id="editar"></i> ' +
                                                '<i class="icon ion-ios-list-outline" title="Consulta Log" style="cursor: pointer" onclick="ver_log(' +
                                                data + ')" id="log"></i> ' +
                                                '<i class="icon ion-android-map" title="Consulta Flujo" style="cursor: pointer" onclick="ver_flujo(' +
                                                data + ')" id="flujo"></i> '
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
                                            return '<i class="fas fa-lightbulb-o fa-lg" style="color:' +
                                                color + '" title="' + title +
                                                '" text-align="right" aria-hidden="true"></i>'
                                        }
                                    },


                                    {
                                        data: "id_solicitud",
                                        title: "ID Acuse"
                                    },
                                    {
                                        data: "folio_solicitud",
                                        title: "Folio de Solicitud"
                                    },
                                    {
                                        data: "fecha_solicitud",
                                        title: "Fecha/hora de registro"
                                    },
                                    {
                                        data: "folio_carpeta",
                                        title: "Carpeta Judicial"
                                    },
                                    {
                                        data: "nombre_juez",
                                        title: "Juez"
                                    },
                                    {
                                        data: "estatus_flujo_actual",
                                        title: "Estatus"
                                    },
                                ],
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
                                //stateClear: false,
                                //stateLoaded: true,
                            });

                            $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                            $('#paginas_totales').val(response.response_pag['paginas_totales'])


                            /*  $.each(response.response, function(index, solicitud){

                                /bulb colors
                                if(solicitud.estatus_semaforo=="amarillo"){
                                    color="#ffc40c";
                                    msg="VISTO";
                                    }
                                    else if(solicitud.estatus_semaforo=="verde"){
                                        color="green";
                                        msg="ATENDIDO";
                                    }
                                    else if(solicitud.estatus_semaforo=="rojo"){
                                        color="red";
                                        msg="VISUALIZACION PENDIENTE";
                                    }

                                body=body.concat(`<tr id="${id_solicitud}">

                                 <td style="vertical-align:middle;">
                                   <div class="flex-container">
                                   @foreach ($acciones as $acc)
                                       @if ($acc['id_vista_accion'] == 13 and $acc['valor'] != 0)
                                           <div onclick="ver_solicitud(${solicitud.id_solicitud})" title="Información" style="cursor: pointer"><i
                                                   class="icon ion-ios-information"></i></div>
                                       @endif
                                       @if ($acc['id_vista_accion'] == 40 and $acc['valor'] != 0)
                                           <div onclick="ver_documentos(${solicitud.id_solicitud});" title="Historial de documentos"
                                               style="cursor: pointer"><i class="icon ion-folder"></i></div>
                                       @endif
                                       @if ($acc['id_vista_accion'] == 12 and $acc['valor'] != 0)
                                           <div title="Modificar" style="cursor: pointer"><a href="promujer_edita_solicitud/${solicitud.id_solicitud}"><i
                                                       class="icon ion-edit"></i></a></div>
                                       @endif
                                       @if ($acc['id_vista_accion'] == 11 and $acc['valor'] != 0)
                                           <div onclick="ver_log(${solicitud.id_solicitud});" title="Consulta log" style="cursor: pointer"><i
                                                   class="icon ion-ios-list-outline"></i></div>
                                       @endif
                                       @if ($acc['id_vista_accion'] == 39 and $acc['valor'] != 0)
                                           <div onclick="ver_flujo(${solicitud.id_solicitud},0,0);" title="Consulta flujo" style="cursor: pointer"><i
                                                   class="icon ion-android-map"></i></div>
                                       @endif
                                   @endforeach
                                   </div>
                                  </td>

                                 <td class="semaforo"> <i class="fas fa-lightbulb-o fa-lg" width:"100%"   style="color:${color}" title="${msg}" text-align="right" aria-hidden="true"></i> </td>

                                    <td class="id_solicitud">${solicitud.id_solicitud ?? ' '}</td>
                                    <td class="folio_solicitud">${solicitud.folio_solicitud ?? ' '}</td>
                                    <td class="fecha_registro">${solicitud.fecha_solicitud ?? ' '}</td>
                                    <td class="folio_carpeta">${solicitud.folio_carpeta ?? ' '}</td>
                                    <td class="juez"> ${solicitud.cve_juez ?? ' '} ${solicitud.nombre_juez ?? ' '} </td>

                                 <tr>`);
                                                    });


                                    $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                                    $('#paginas_totales').val(response.response_pag['paginas_totales'])

                                $('#body-table1').html(body);
                            */

                            //  limpiarCampos();
                        } else {
                            let body = "";
                            body = body.concat(
                            "<tr><td colspan='12'><h3>Sin datos relacionadoss</h3></td><tr>");
                            $("#body-table1").html(body);
                            //  limpiarCampos();
                        }
                    }
                });
            }

        }

        function turnar(id_solicitud) {

            //alert("turnar");

            const turnado =
                `<button type="button" onclick="turnar(${id_solicitud ?? ""})" class="btn btn-success" data-dismiss="modal">Turnar</button>   `
            $('#boton').html(`${turnado}`);

            $.ajax({
                type: 'PUT',
                url: 'public/turnar_carpeta/5/' + id_solicitud,
                data: {

                },
                success: function(response) {


                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);

                    if (response.status == 100) {

                        //valor y boton id solicitud para turnado
                        /*   const turnado= `<p class="mg-b-20 mg-x-20" > Carpeta Judicial Asignada ${response.folio_carpeta ?? ""}</p>   `
                                    $('#carpetaAsignada').html( `${turnado}`);

                            const carpeta= response.folio_carpeta;
                        */


                        $('#modalOkTurnado').modal('show');


                    } else {
                        $('#modalFailTurnado').modal('show');
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

        function ver_solicitud(id_solicitud) {
            limpiarPDF();
            var modo = "completo";

            $.ajax({
                type: 'GET',
                url: '/public/obtener_solicitud_promujer',
                data: {
                    modo: modo,
                    id_solicitud: id_solicitud,
                    // folio_solicitud:$("#foliosolicitud").val(),
                    /*                 carpeta_investigacion:$("#carpetainvestigacion").val(),
                                    folio_carpeta:$("#foliocarpeta").val(),
                                    fecha_recepcion:$("#fechasolicitud").val(),
                                    fecha_recepcionh:$("#fechasolicitudh").val(),
                                    estatus_flujo_actual:$("#estatusactual").val(),
                                    estatus_urgente:$("#estatusurgente").val(),
                                    materia_destino:$("#materiadestino").val(),
                                    pagina:$('#numeropagina').val(),*/
                    pagina: 1,
                    // registros_por_pagina:$('.pagina_actual_texto').val(),
                    registros_por_pagina: 10,


                },
                success: function(response) {

                    if (response.status == 100) {

                        console.log(response);


                        $(response.response).each(function(index, solicitud) {


                            const {
                                id_solicitud,
                                folio_solicitud_audiencia,
                                personas,
                                delitos_sin_relacionar,
                                fecha_solicitud,
                                carpeta_investigacion,
                                cordinacion_territorial,
                                folio_carpeta,
                                folio_solicitud,
                                fecha_recepcion,
                                hora_recepcion,
                                tipo_audiencia,
                                duracion_aproximada,
                                estatus_urgente,
                                estatus_telepresencia,
                                estatus_area_resguardo,
                                estatus_mod_testigo_protegido,
                                estatus_mesa_evidencia,
                                estatus_delito_grave,
                                mp_solicitante,
                                tipo_solicitud,
                                fiscalia,
                                materia_destino,
                                curp_mp,
                                correo_mp,
                                descripcion_hechos,
                                unidad_registrante_prom
                            } = solicitud;

                            listaArchivos = "";
                            let listaPersona = [];
                            let listaSujetos = [];
                            let acordeones = [];


                            $.ajax({
                                type: 'GET',
                                url: 'public/promujer_descargar_pdf/' + id_solicitud,
                                data: {},
                                success: function(response) {


                                    setTimeout(function() {
                                        $('#modal_loading').modal('hide');
                                    }, 500);

                                    //  if(response.status==100){

                                    $(response).each(function(index, archivo) {

                                        let tipo = "";
                                        let icono = "";

                                        const {
                                            nombre_archivo,
                                            id_version
                                        } = archivo;

                                        //tipo de archivo

                                        tipo = nombre_archivo.split('.');
                                        if (tipo[1] == "doc" || tipo[1] == "docx") {
                                            icono = "far fa-file-word";
                                        } else if (tipo[1] == "pdf") {
                                            icono = "far fa-file-pdf";
                                        } else if (tipo[1] == "jpg" || tipo[1] ==
                                            "png") {
                                            icono = "far fa-file-image";
                                        } else if (tipo[1] == "xls" || tipo[1] ==
                                            "xlsx") {
                                            icono = "far fa-file-excel-o";
                                        }



                                        const li = `<div class="item">

                                            <a href="javascript:void(0)" onclick="descargar_archivo('${id_solicitud}','${id_version}');">
                                                <i class="${icono} fa-2x"> </i>
                                                ${nombre_archivo}
                                            </a>
                                         </div>  `;

                                        listaArchivos = listaArchivos.concat(li);

                                    });
                                    $('#documentos-relacionados').html(`<div class="items ">
                                                            ${listaArchivos}
                                                </div> `);



                                }
                            });



                            //PERSONAS
                            $(personas).each(function(index_p, persona) {

                                listaPersona.push(persona.info_principal);

                                let tablaDireccion = '';
                                let tablaAlias = '';
                                let tablaContacto = '';
                                let tablaCorreo = '';
                                let tablaDatos = '';
                                let tablaDelitos = '';

                                $(persona.direcciones).each(function(index_d, direccion) {

                                    const {
                                        id_persona,
                                        calle,
                                        codigo_postal,
                                        colonia,
                                        entidad_federativa,
                                        entre_calles,
                                        estado,
                                        localidad,
                                        municipio,
                                        no_exterior,
                                        no_interior,
                                        referencias
                                    } = direccion;


                                    tablaDireccion = tablaDireccion + ` <tr align="center" > <th colspan="100%" class="th-title">Direcciones</th> </tr>
                                        <tr>
                                            <td class="td-title">Calle</td>
                                            <td>${calle ?? "Sin datos"}</td>
                                        
                                            <td class="td-title">Número Exterior</td>
                                            <td>${no_exterior ?? "Sin datos"}</td>
                                        </tr>
                                    
                                        <tr>
                                            <td class="td-title">Número Interior</td>
                                            <td>${no_interior ?? "Sin datos"}</td>
                                        
                                            <td class="td-title">Localidad</td>
                                            <td>${localidad ?? "Sin datos"}</td>
                                        </tr>
                                    
                                        <tr>
                                            <td class="td-title">Colonia</td>
                                            <td>${colonia ?? "Sin datos"}</td>
                                        
                                            <td class="td-title">Estado</td>
                                            <td>${estado ?? "Sin datos"}</td>
                                        </tr>
                                    
                                        <tr>
                                            <td class="td-title">Municipio</td>
                                            <td>${municipio ?? "Sin datos"}</td>
                                        
                                            <td class="td-title">Otras Referencias</td>
                                            <td>${referencias ?? "Sin datos"}</td>
                                        </tr>
                                    
                                        <tr>
                                            <td class="td-title">Entre Calles</td>
                                            <td>${entre_calles ?? "Sin datos"}</td>
                                        
                                            <td class="td-title">Codigo Postal</td>
                                            <td>${codigo_postal ?? "Sin datos"}</td>
                                        </tr>`;
                                    });
                                tabla_direcciones[index_p] = tablaDireccion;

                                //DELITOS PERSONAS
                                /* if(persona.delitos.length){
                                     $(persona.delitos).each(function(index_de, delitoo){

                                      const {calificativo,forma_comision,grado_realizacion,delito,nombre_modalidad}  =delitoo;



                                      tablaDelitos = tablaDelitos + `
                                                                       <tr>
                                                                           <td>${delito ?? ""}</td>
                                                                           <td>${nombre_modalidad ?? ""}</td>
                                                                           <td>${calificativo ?? ""}</td>
                                                                           <td>${grado_realizacion ?? ""}</td>
                                                                       </tr>`;
                                       });   tabla_delitos[index_p] =   ` <tr align="center"><th colspan="100%" class="th-title">Delitos Relacionados </th></tr>
                                                               <tr>
                                                                   <td class="td-title">Delito</td>
                                                                   <td class="td-title">Modalidad del Delito</td>
                                                                   <td class="td-title">Calificativo</td>
                                                                   <td class="td-title">Grado de Realizacion</td>
                                                               </tr>`+  tablaDelitos;
                                   }else{

                                       tabla_delitos[index_p] = ` <tr> </tr>`;;

                                    } 
                                */


                                //DATOS PERSONAS
                                $(persona.datos).each(function(index_da, datos) {

                                    const {
                                        capacidad_diferente,
                                        capacidades_diferentes,
                                        entiende_idioma_español,
                                        grupo_etnico,
                                        idioma_traductor,
                                        lengua,
                                        nivel_escolaridad,
                                        nombre_poblacion,
                                        nombre_religion,
                                        requiere_interprete,
                                        requiere_traductor,
                                        sabe_leer_escribir
                                    } = datos;


                                    tablaDatos = datos;

                                });
                                tabla_datos[index_p] = tablaDatos;

                                // ALIAS PERSONAS
                                $(persona.alias).each(function(index_a, aliases) {

                                    const {
                                        alias
                                    } = aliases;
                                    tablaAlias = tablaAlias + `${alias} <br>`;

                                });
                                tabla_alias[index_p] = tablaAlias;


                                // CONTACTO PERSONAS
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
                            $(listaPersona).each(function(index, sujetosProcesales) {

                                const {
                                    id_persona,
                                    nombre,
                                    apellido_paterno,
                                    apellido_materno,
                                    calidad_juridica,
                                    cedula_profesional,
                                    curp,
                                    edad,
                                    es_mexicano,
                                    estado_civil,
                                    fecha_nacimiento,
                                    folio_identificacion,
                                    lugar_reclusorio,
                                    genero,
                                    nacionalidad,
                                    otra_nacionalidad,
                                    tipo_identificacion,
                                    tipo_persona,
                                    rfc_empresa,
                                    tipo_ocupacion,
                                    poblacion_callejera
                                } = sujetosProcesales;



                                const tablaSujeto = `<table class="dataTables">
                                    <tr>
                                        <td class="td-title">Calidad Juridica</td>
                                        <td>${calidad_juridica ?? "Sin datos"}</td>
                                    
                                        <td class="td-title">Sabe Leer y Escribir</td>
                                        <td>${tabla_datos[index].sabe_leer_escribir ?? "Sin datos"}</td>
                                    </tr>

                                    <tr>
                                           <td class="td-title">RFC </td>
                                           <td>${rfc_empresa ?? ""}</td>
                                    
                                           <td class="td-title">LGBTTTI</td>
                                           <td>${tabla_datos[index].nombre_poblacion ?? "Sin datos"}</td>
                                    </tr>
                                
                                    <tr>
                                           <td class="td-title">CURP </td>
                                           <td>${curp ?? ""}</td>
                                    
                                           <td class="td-title">Poblacion</td>
                                           <td>${tabla_datos[index].poblacion ?? "Sin datos"}</td>
                                    </tr>
                                
                                    <tr>
                                           <td class="td-title">Cédula Profesional </td>
                                           <td>${cedula_profesional ?? "Sin datos"}</td>
                                    
                                           <td class="td-title">Requiere traductor</td>
                                           <td>${tabla_datos[index].requiere_traductor ?? "Sin datos"}</td>
                                    </tr>
                                
                                    <tr>
                                           <td class="td-title">Género </td>
                                           <td>${genero ?? "Sin datos"}</td>
                                    
                                           <td class="td-title">Requiere Interprete</td>
                                           <td>${tabla_datos[index].requiere_interprete ?? "Sin datos"}</td>
                                    </tr>
                                
                                    <tr>
                                           <td class="td-title">Fecha de Nacimiento </td>
                                           <td>${fecha_nacimiento ?? "Sin datos"}</td>
                                    
                                           <td class="td-title">Capacidades Diferentes</td>
                                           <td>${tabla_datos[index].capacidad_diferente ?? "Sin datos"}</td>
                                    </tr>
                                
                                    <tr>
                                           <td class="td-title">Nacionalidad </td>
                                           <td>${nacionalidad ?? "Sin datos"}</td>
                                    
                                           <td class="td-title">Poblacion Callejera</td>
                                           <td>${tabla_datos[index].poblacion_callejera ?? "Sin datos"}</td>
                                    </tr>
                                
                                    <tr>
                                           <td class="td-title">Otra Nacionalidad </td>
                                           <td>${otra_nacionalidad ?? "Sin datos"}</td>
                                    
                                           <td class="td-title">Lengua</td>
                                           <td>${estado_civil ?? "Sin datos"}</td>
                                    </tr>
                                
                                    <tr>
                                           <td class="td-title">Estado Civil </td>
                                           <td>${estado_civil ?? "Sin datos"}</td>
                                    
                                           <td class="td-title">Religion</td>
                                           <td>${tabla_datos[index].nombre_religion ?? "Sin datos"}</td>
                                    </tr>
                                
                                    <tr>
                                           <td class="td-title">Tipo Persona </td>
                                           <td>${tipo_persona ?? "Sin datos"}</td>
                                    
                                           <td class="td-title">Grupo Etnico</td>
                                           <td>${tabla_datos[index].grupo_etnico?? "Sin datos"}</td>
                                    </tr>
                                
                                    <tr>
                                           <td class="td-title">Nivel Escolaridad </td>
                                           <td>${tabla_datos[index].nivel_escolaridad ?? "Sin datos"}</td>
                                    
                                           <td class="td-title">Ocupación</td>
                                           <td>${tabla_datos[index].tipo_ocupacion ?? "Sin datos"}</td>
                                    </tr>
                                </table>
                                                            <br>

                                <table class="">
                                    <td>${tabla_direcciones[index] }</td>
                                </table>
                                                            <br>
                                <table class="">
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
                                </table><br> `;




                                const accordion = `<h4 class="panel-title">

                                    <button class="accordion" data-toggle="collapse" href="#collapse${index}">
                                        <strong> ${nombre ?? "Sin nombre"} ${apellido_paterno ?? ""} ${apellido_materno ?? ""}</strong>
                                    </button>
                                </h4>

                                <div id="collapse${index}" border-style="solid" class="panel-collapse collapse">
                                           <div class="panel-body">
                                                   <tr>
                                                   ${tablaSujeto}
                                                   </tr>
                                           </div>
                                </div>`;


                                listaSujetos = listaSujetos.concat(tablaSujeto);

                                acordeones = acordeones.concat(accordion);
                                $('#acordeon').html(acordeones);
                                //   $('#datosparticipantes').html(listaSujetos).css({"overflow-x": "none", "display": "table"});

                            });

                            $('#hechos').html(`  <tr align="center" > <th colspan="100%" class="th-title">Relato de hechos</th> </tr>

                                <th colspan="100%">
                                    <textarea id="textarea"  rows="4"  disabled >${descripcion_hechos ?? "Sin datos"}</textarea>
                                 </th>    `);



                            //DATOS PRINCIPALES DE LA SOLICITUD
                            $('#datosolicitud').html(`<tr>
                                        <td class="td-title">Folio de Solicitud de Audiencia</td>
                                        <td>${folio_solicitud_audiencia ?? "Sin datos"}</td>
                                    </tr>

                                    <tr>
                                        <td class="td-title">Fecha de la Solicitud</td>
                                        <td>${fecha_solicitud ?? "Sin datos"}</td>
                                    </tr>



                                    <tr>
                                        <td class="td-title">Carpeta Judicial</td>
                                        <td>${folio_carpeta ?? "Sin datos"}</td>
                                    </tr>



                                    <tr>
                                        <td class="td-title">Fecha de Recepción</td>
                                        <td>${fecha_recepcion ?? "Sin datos"}</td>
                                    </tr>

                                    <tr>
                                        <td class="td-title">Hora de Recepción</td>
                                        <td>${hora_recepcion ?? "Sin datos"}</td>
                                    </tr>

                                    <tr>
                                        <td class="td-title">Unidad Registrante</td>
                                        <td>${unidad_registrante_prom ?? "Sin datos"}</td>
                                    </tr>

                                <br>

                            `);

                            $('#modal-ver').modal('show');

                        });

                        /* <tr align="center" > <th colspan="100%" class="th-title">Direcciones</th> </tr> */

                    } else {

                    }
                }
            });


        }

        /* function limpiarCampos(){

              $('#idsolicitud').val('');//text
              $('#foliosolicitud').val('');
              $('#carpetainvestigacion').val('');
              $('#foliocarpeta').val('');

              $('#fechasolicitud').val('');//pickers
              $('#fechasolicitudh').val('');

              $('#estatusactual').val('');//selects
              $('#estatusurgente').val('');
              $('#materiadestino').val('');



            } */

        function descargar_archivo(id_solicitud, id_version) {

            $.ajax({
                type: 'GET',
                url: 'public/descargar_archivos_promujer/' + id_solicitud + '/' + id_version,
                data: {},
                success: function(response) {
                    console.log(response);

                    $('#documentoPDFrame').attr('src', response.response);


                    /*


                         setTimeout(function(){
                             $('#modal_loading').modal('hide');
                             }, 500);

                             if(response.status==100){
                                 var win = window.open(response.response, '_blank');
                                 }
                             else{
                                     $('#modalFail').modal('show');
                             } */
                }
            });


        }

        function limpiarPDF() {
            console.log("campos limpios");
            $('#documentoPDFrame').attr('src', ''); //text

        }

        function descargar_consulta(extension) {

            fecha_recepcion_min =  $('#fechasolicitud').val().split('/').reverse().join('-');
            fecha_recepcion_max =  $('#fechasolicitudh').val().split('/').reverse().join('-');    

            $('#modal_loading').modal('show');

            $.ajax({
                type: 'GET',
                url: 'public/exportar_busqueda_promujer',
                data: {
                    modo: "",
                    id_solicitud: $("#idsolicitud").val(),
                    folio_solicitud: $("#foliosolicitud").val(),
                    folio_carpeta: $("#foliocarpeta").val(),
                    tipo_solicitud: "PRO-MUJER",
                    estatus_semaforo: $("#estatussemaforo").val(),
                    fecha_recepcion_min: fecha_recepcion_min,
                    fecha_recepcion_max: fecha_recepcion_max,
                    pagina: $('#numeropagina').val(),
                    registros_por_pagina: 100,
                },
                success: function(response) {
                    if(response.status==100){
                        $('#modal_loading').modal('hide');

                        window.open(response.response);

                    }else{
                        error(response.message);

                        $('#modal_loading').modal('hide');
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
                    campo: "nombre_juez",
                    titulo: "Juez"
                },
            ];
            
            let columnas = [];

            $('#consultaPromujerTable thead tr th').each(function() {
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

        function error(mensaje){
            $('#messageError').html(mensaje);
            $('#modalError').modal('show');
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
                                role="tab" aria-controls="nav-contact" aria-selected="false">Archivos Relacionados</a>
                        </div>
                    </nav>
                    <br>

                    <div class="tab-content" id="nav-tabContent">

                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <table id="datosolicitud" class="dataTables"> </table>
                            <br>
                            <table id="hechos" class="dataTables"> </table>
                        </div>

                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


                            <div class="accordion" id="acordeon" role="tablist"> </div>


                            {{-- <table id="datosparticipantes" class="dataTables"> </table> --}}
                        </div>

                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">


                            <div class="box">
                                <div id="documentos-relacionados" class="">
                                </div>

                                <div style="width: -webkit-fill-available;">
                                    <iframe frameborder="0" allowfullscreen src="" id="documentoPDFrame"></iframe>
                                </div>
                            </div>

                        </div>

                    </div>

                    <br>
                </div>



                <div class="modal-footer">

                    {{-- <div id="boton" data-dismiss="modal">Turnar</div> --}}

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
                    <i class="icon ion-ios-close-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
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
                    <h4 class=" tx-semibold style='color:green' mg-b-20">Proceso Concluido!</h4>

                    <p id="carpetaAsignada" class="mg-b-20 mg-x-20">Carpeta Judicial Asignada</p>

                    <button type="button" class="btn btn-sucess pd-x-25" data-dismiss="modal"
                        aria-label="Close">Cerrar</button>
                </div><!-- modal-body -->
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

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
                    <table id="flujos" class="display dataTable dtr-inline collapsed d-block"
                        style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid"
                        aria-describedby="example_info">
                        <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                            <tr>
                                <th class="estatus_">Estatus</th>
                                <th class="responsable_">Responsable</th>
                                <th class="comentarios_">Comentarios</th>
                                <th class="horafecha_">Hora/Fecha</th>
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
    
    {{-- MODAL ERROR --}}
    <div id="modalError" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> -->
              <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
              <h4 class="tx-danger mg-b-20">Error!</h4>
              <p class="mg-b-20 mg-x-20" id="messageError"></p>
              <button type="button" class="btn btn-danger pd-x-25 cerrar-modal"  data-dismiss="modal" id="btnCerrarError">Aceptar</button>
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div>

@endsection
