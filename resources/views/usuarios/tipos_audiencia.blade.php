@php
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\utilidades;
$humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Catalogos</a></li>
        <li class="breadcrumb-item"><a href="#">Tipos de Audiencia</a></li>
    </ol>
    <h6 class="slim-pagetitle"> Consulta de Tipos de audiencia</h6>
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
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="label">Tipo atencion:</label>
                                        <select class="form-control select2-show-search valid select2-hidden-accessible" id="tipo_atencion">
                                                <option value="" selected>Todas</option>
                                                <option value="2">Urgente</option>
                                                <option value="1">No Urgente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Tipo audiencia:</label>
                                        <input class="form-control" style="text-align:center" type="text" id="tipo_audiencia">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Código:</label>
                                        <input class="form-control" style="text-align:center" type="text" id="codigo">
                                    </div>
                                </div>
                            </div><!-- row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <br>
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10"
                                        data-toggle="collapse" data-target="#demo"
                                        onclick="sec_ajax('primera');">Filtrar</button>
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
            <br>



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



            <div class="mg-b-20">
                <table id="catalogoTable" class="display dataTable dtr-inline collapsed d-block"
                    style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">

                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>
                            <th class="th_accion">Acciones</th>
                            <th style="cursor:pointer" class="th_id_ta" name="th_id_ta">ID</th>
                            <th style="cursor:pointer" class="th_estatus" name="th_codigo">estatus</th>
                            <th style="cursor:pointer" class="th_codigo" name="th_codigo">Código</th>
                            <th style="cursor:pointer" class="th_tipo_audiencia" name="th_tipo_audiencia">Tipo audiencia</th>
                            <th style="cursor:pointer" class="th_duracion" name="th_duracion">Duracion</th>
                            <th style="cursor:pointer" class="th_atencion" name="th_atencion">Atención</th>
                            <th style="cursor:pointer" class="th_creacion" name="th_responsable">Responsable</th>
                            <th style="cursor:pointer" class="th_creacion" name="th_creacion">Creación</th>
                        </tr>
                    </thead>
                    <tbody id="body-table1" style="width: 100%; text-align: center;">
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

        <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;">
        </div>
    </div>
    {{-- @endif
    @endif --}}
@endsection
@section('seccion-estilos')
    <link href="{{ asset('/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 1050 !important;
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

        span.select2-container.select2-container--default.select2-container--open {
            width: "100%";
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

        .ref {
            min-width: 80px !important;
        }

        .th_accion {
            min-width: 120px !important;
        }
        .th_id_ta {
            min-width: 70px !important;
        }
        .th_estatus {
            min-width: 70px !important;
        }
        .th_codigo {
            min-width: 70px !important;
        }
        .th_tipo_audiencia {
            min-width: 300px !important;
        }
        .th_duracion {
            min-width: 150px !important;
        }
        .th_atencion {
            min-width: 100px !important;
        }
        .th_creacion {
            min-width: 160px !important;
        }
        .th_responsable {
            min-width: 160px !important;
        }

        .hover:hover {
            background-color: #90a03c;
            color: white;
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

        .flex-container {
            display: flex;
            justify-content: center;

        }

        .flex-container>div {
            margin: 1px;
            padding: 1px;
            font-size: 16px;
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
            width: "100%";
        }

        div .icon {
            background: #848F33 !important;
            padding: 2px 5px;
            border-radius: 25%;
            color: #fff;
        }

    </style>
@endsection
@section('seccion-scripts-libs')
    <script src="{{ $entorno['version_pages']['version'] }}/lib/jquery-ui/js/jquery-ui.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/moment/js/moment.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
@endsection
@section('seccion-scripts-functions')
    <script>

        $(function() {
            'use strict';
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
                $("#filtro_consulta").val(
                    JSON.stringify({
                        tipo_atencion: $("#tipo_atencion").val(),
                        tipo_audiencia: $("#tipo_audiencia").val(),
                        codigo: $("#codigo").val(),
                        pagina: 1,
                        registros_por_pagina: 1000000
                    })
                );

                $.ajax({
                    type: 'GET',
                    url: '/public/consulta_tas',
                    data: {
                        tipo_atencion: $("#tipo_atencion").val(),
                        tipo_audiencia: $("#tipo_audiencia").val(),
                        codigo: $("#codigo").val(),
                        pagina: $('#numeropagina').val(),
                        registros_por_pagina: 10,
                    },

                    success: function(response) {
                        if (response.status == 100) {

                            let color;

                            var datos = response.response;
                            var body = new $('#catalogoTable').dataTable({
                                processing: true,
                                data: datos,
                                columns: [{
                                        "data": "id_ta",
                                        "render": function(data, type, row, meta) {
                                            return '<div class="icono"><i class="fas fa-pen" title="" onclick="" style="cursor: pointer" id="editar"></i></div> '
                                        }
                                    },
                                    {
                                        data: "id_ta",
                                        title: "ID"
                                    },
                                    {
                                        data: "estatus",
                                        render: function(data, type, row, meta) {
                                            if (data == 1) {
                                                color = "green";
                                                title = "ACTIVO";
                                            } else {
                                                color = "grey";
                                                title = "INACTIVO";
                                            }
                                            return '<i class="fas fa-circle fa-lg" style="color:' +
                                                color + '" title="' + title + '" ></i>';
                                        },
                                    },
                                    {
                                        data: "codigo",
                                        title: "Codigo"
                                    },
                                    {
                                        data: "tipo_audiencia",
                                        title: "Tipo audiencia"
                                    },
                                    {
                                        data: "promedio_duracion",
                                        render: function(data, type, row, meta) {

                                              return  "<p>"+ data +" minutos</p>";

                                        },
                                    },
                                    {
                                        data: "tipo_atencion",
                                        render: function(data, type, row, meta) {
                                            if (data == 2) {
                                              return  "<strong><font style='color:red;'>URGENTE</font></strong>";
                                            }
                                            else {
                                              return  "<font style='color:orange;'>NO URGENTE</font>";
                                            }
                                        },
                                    },
                                    {
                                        data: "usuario",
                                        title: "Responsable"
                                    },
                                    {
                                        data: "creacion",
                                        title: "Creación"
                                    },

                                ],
                                columnDefs: [{
                                    orderable: false,
                                    targets: 0
                                }],
                                colReorder: {
                                    fixedColumnsLeft: 1
                                },
                                bDestroy: true,
                                colReset: true,
                                paging: false,
                                ordering: true,
                                info: false,
                                search: false,
                                filter: false,
                                stateSave: true,
                            });

                            $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                            $('#paginas_totales').val(response.response_pag['paginas_totales'])
                        } else {
                            body = "<tr>" +
                                "<td colspan='5'>" +
                                "<td colspan='7'>" +
                                "<h3>Sin datos relacionados</h3>" +
                                "</td>" +
                                "<tr>";

                            $('#body-table1').html(body);
                        }
                    }
                });
            }

        }



    </script>
@endsection
