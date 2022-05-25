@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Salas</a></li>
    <li class="breadcrumb-item"><a href="#"> Incidencias de Salas</a></li>
 </ol>
 <h6 class="slim-pagetitle">Incidencias de Salas</h6>
@endsection

@section('contenido-principal')

    <div class="section-wrapper" style="max-width: 100%;">
        <div class="form-layout">

            <div class="d-flex justify-content-between" style="align-items: center;">
                <a style="border:1px solid #ccc; width: 70px; height: 45px;" data-toggle="collapse" data-parent="#accordion"
                    href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance"
                    class="btn btn-default">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <i class="fa fa-chevron-down" style="margin-left: 5%; font-size:0.7em;"></i>
                </a>
                <div class="row justify-content-end" style="width:80%;">
                    <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">

                    {{--  <div class="col-sm-2 pd-t-10" aling="right">
                        <a href="javascript:void(0);" onclick="descargar_consulta('xls');" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                    </div>  --}}
                    <div class="col-sm-2 pd-t-10" aling="right">
                        <a href="javascript:void(0);" onclick="nueva_incidencia();" class="btn btn-primary btn-sm btn-block "><i class="fa fa-plus mg-r-5"></i></i>Agregar Incidencia</a>
                    </div>
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
                                            <label class="label">Fecha Inicio: </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" id="fechaini" name="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Fecha Fin: </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" id="fechafin" name="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3" >
                                        <label class="form-control-label">Tipo de Incidencia:</label>
                                        <div class="form-group" >
                                            <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" id="tipoIncidencia">
                                                <option selected disabled value="">Elija una opción</option>
                                                <option value="">Todas</option>
                                                <option value="MANTENIMIENTO" >Mantenimiento</option>
                                                <option value="OTRO" >Otro</option>
                                                <option value="RESERVADO" >Reservado</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="sec_ajax('primera');">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--  <!-- pagination-wrapper -->
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
            </div><!-- pagination-wrapper -->       --}}

            <!--TABLA RESULTADOS BUSQUEDA -->
            <div id="table-incidencias" class="mg-b-20">
                <table id="incidenciasTable" class="display dataTable dtr-inline collapsed d-block" style="font-size: 0.9em;overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>    
                            <th style="cursor:pointer; min-width: 120px !important;" class="id_incidencia" name="creacion">Acciones</th>
                            <th style="cursor:pointer; min-width: 80px !important;" class="id_incidencia" name="creacion">Registro</th>
                            <th style="cursor:pointer; min-width: 200px !important;" class="motivo_incidencia" name="motivo_incidencia">Motivo de la Incidencia</th>
                            <th style="cursor:pointer; min-width: 200px !important;" class="fecha_inicial" name="fecha_inicial">Fecha/Hora Inicial</th>
                            <th style="cursor:pointer; min-width: 200px !important;" class="fecha_final" name="fecha_final">Fecha/Hora Final</th>
                            <th style="cursor:pointer; min-width: 200px !important;" class="salas_involucradas" name="salas_involucradas">Salas Involucradas</th>
                            <th style="cursor:pointer; min-width: 200px !important;" class="tipo_periodo" name="tipo_periodo">Tipo de Periodo</th>
                            <th style="cursor:pointer; min-width: 200px !important;" class="tipo_periodo" name="tipo_periodo">Aplica a todas las unidades</th>
                            <th style="cursor:pointer; min-width: 300px !important;" class="unidades_involucradas" name="unidades_involucradas">Unidades Involucradas</th>
                            <th style="cursor:pointer; min-width: 200px !important;" class="unidades_involucradas" name="unidades_involucradas">Etapa</th>
                            <th style="cursor:pointer; min-width: 200px !important;" class="comentarios_adicionales" name="comentarios_adicionales">Comentarios Adicionales</th>
                            <th style="cursor:pointer; min-width: 300px !important;" class="unidades_involucradas" name="unidades_involucradas">Usuario Responsable</th>
                        </tr>
                    </thead>
                    <tbody id="body-table1" style="width: 100%; text-align: center;">
                    </tbody>
                </table>
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

            <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
            <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
            <input type="hidden" id="numeropagina">

        </div>
    </div>

@endsection

@section('seccion-estilos')

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/dropzone.min.css') }}">
    <link href="{{ asset('/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <link rel="stylesheet" href="/box/scheduler/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/box/scheduler/samples/common/controls_styles.css?v=5.3.8">
    <link href="{{ $entorno['version_pages']['version'] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
    <link href="{{ $entorno['version_pages']['version'] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/js/clockpicker-gh-pages/src/clockpicker.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <style>
        .item_sala{
            width:100%; 
            display:flex; 
            flex-wrap: wrap; 
            justify-content: center; 
            align-items: center; 
            border: 1px solid #eee; paddin: 4px; 
            margin-bottom:2%;
            cursor: pointer;
            transition: 0.2 all;
        }
        .item_sala:hover{
            background:  #A72424;
            color:#fff;
        }
        .item_sala:active{
            transform: scale(0.95);
        }
        .uni_agregada{
            cursor: pointer;
            margin: 2px 5px;
            width: 120px;
            height: 54px;
            background: #fff;
            color: #848f33;
            border: 1px solid #848f33;
            font-size: 0.8em;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 4px;
        }
        .uni_agregada:hover{
            background:  #848f33;
            color: #fff;
        }
        .uni_agregada:active{
            transform: scale(0.95);
        }

        .activa{
            background:  #848f33 !important;
            color: #fff !important;
        }

        .select2-container.select2-container--default.select2-container--open {
            z-index: 1050 !important;
        }
        .lista_chida{
            text-align:center; 
            max-height: 100px; 
            overflow:auto; 
            list-style:none;
        }

        .lista_chida::-webkit-scrollbar {
            width: 8px;
            height: 8px;     
        }

        .lista_chida::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .lista_chida::-webkit-scrollbar-thumb:hover {
            background: #b3b3b3;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }

        .lista_chida::-webkit-scrollbar-thumb:active {
            background-color: #999999;
        }

        .lista_chida::-webkit-scrollbar-track {
            background: #e1e1e1;
            border-radius: 4px;
        }
    
        .lista_chida::-webkit-scrollbar-track:hover,
        .lista_chida::-webkit-scrollbar-track:active {
          background: #d4d4d4;
        }    

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

        #modal-ver .modal-dialog {
            width: 100%;
            max-width:700px;
            height: 90%;
            margin: 0;
            padding: 1;
        }

        table{
            width: calc(100% - 2px) !important;
            border-bottom: 1px solid #f0f2f7;
        }

        td, th{
            padding-left: 1px !important;
            padding-right: 3px !important;
            padding-top: 0px;
            padding-bottom: px !important;
            border-bottom: 1px solid #f0f2f7;
            max-width: 110px !important;
        }
        span.select2-container.select2-container--default.select2-container--open{

            width:'100%';
        }

        .abs-center {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
        }
        .iconify{
            display: inline-block;
            text-align: left;
            vertical-align: top;
        }


        div.modal-body.pd-30 {
            padding-top: 10px;
        }

        div.modalRemision-body{
            /* min-width: 90% !important; */
            min-width: 90%;;
        }

        div.modalRemision-content{
            min-height: 80%;
        }
        div.modalRemision-body{
            max-width: 900px !important;
        }

        div.modalNuevaIncidencia-content{
            min-height: 80%;
        }

        div.modalNuevaIncidencia-body {
            max-width: 900px !important;
            min-width: 90%;;
            font-size: 15px;
            padding-top: 10px;
        }

        .id_incidencia {
            min-width: 150px !important;
        }

        .motivo_incidencia {
            min-width: 150px !important;
        }

        .fecha_inicial {
            min-width: 150px !important;
        }
        .fecha_final {
            min-width: 150px !important;
        }

        .salas_involucradas {
            min-width: 150px !important;
        }
        .tipo_periodo {
            min-width: 150px !important;
        }
        .aplica_todas_unidades {
            min-width: 150px !important;
        }

        .unidades_involucradas {
            min-width: 200px !important;
        }
        .etapa {
            min-width: 120px !important;
        }
        .comentarios_adicionales {
            min-width: 200px !important;
        }
        .responsable_registro {
            min-width: 200px !important;
        }
        .td-title {
            background-color: #f0f2f7 !important;
            min-width: 120px !important;
            border-color: #f0f2f7 !important;
            max-height:5px !important;
            padding: 3px 5px 3px 5px  !important;
        }
        .odd {
            text-align: center !important;

        }
        .even {
            text-align: center !important;
        }

        #datosSala .row{
            border: 1px solid #EEE;
            border-collapse: collapse;
            margin-top: 5px;
            margin-left: 15px;
            width: 24%;
            display: inline-table !important ;
            margin-inline: 5px !important ;
        }

        div#datosSala .row:nth-child(2n){
            background: #FDFDFD !important;
        }

        div#cuerpoRemision1 {
            display: flex;
            flex-wrap: wrap;
            margin-right: -10px;
            margin-left: 20px;
        }

        div#formularioIncidencia2 {
            display: flex;
            flex-wrap: wrap;
            margin-right: -10px;

            margin-bottom: 10px;
        }

        div#formularioIncidencia3 {
            display: flex;
            flex-wrap: wrap;
            margin-right: 20px;
            margin-left: 50px;
        }

        tbody.table-datos-incidencia tr td:first-child{
            background-color: #f8f9fa;
            min-width: 150px;
            font-weight: bolder;
            height: 20%;
            }

        tbody.table-datos-incidencia  td{
            min-width: 150px;
        }

        .slim-navbar{
            z-index: 1000 !important;
        }

        .ul{
            list-style: none;
        }

        .depo {
            min-width: 80px  !important;
        }

        table{

            width: calc(100% - 2px) !important;
        }
        table a:hover{
            font-weight:bold;
        }
        span.select2-container{
            width:'100%';
        }
        .tx-danger {
            margin-bottom: -5px;
        }
        .modal-datepicker-div{
            z-index: 9999999 !important;
            overflow:visible;
        }
        .modal-datepicker{
            overflow:visible;
            z-index: 9999 !important;
        }
        .#fechaFinAgregar{
            overflow:visible;
            z-index: 9999 !important;
        }
        .ui-datepicker{
            z-index: 55555 !important;
        }
        #ui-datepicker-div{
            z-index: 55555 !important;
        }
    </style>
@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno['version_pages']['version'] }}/lib/jquery-ui/js/jquery-ui.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno['version_pages']['version'] }}/lib/moment/js/moment.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>

    <script src="/box/scheduler/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
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

    <script src="http://10.6.5.1:9002/dist/development/ovenplayer/ovenplayer.js"></script>
    <script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>
@endsection

@section('seccion-scripts-functions')
    <script>
        const expVacio = /^[\s]*$/;
        const unidades_session = @php echo json_encode($unidades);@endphp;
        const salas_session = @php echo json_encode($salas); @endphp;

        let arrSalas = [];
        var unidadesSeleccionadas = [];
        var incidencias = [];

        $(function () {
            "use strict";

            console.log('unidades', unidades_session);
            console.log('salas', salas_session);

            setTimeout(function () {
                $("#modal_loading").modal("hide");
            }, 1000);

            sec_ajax();

        });        

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

            if (pagina <= 0 || pagina > $("#paginas_totales").val()) {
            } else {
                $("#pagina_actual").val(pagina);
                $("#numeropagina").val(pagina);
                $(".pagina_actual_texto").html(pagina);

                let id_solicitud = "";


                //cambio formato de fecha
                var fechaini = $("#fechaini").val() == '' ? '-' : get_date($("#fechaini").val());
                var fechafin = $("#fechafin").val() == '' ? '-' : get_date($("#fechafin").val());
                var tipo = $("#tipoIncidencia").val() == '' ? '' : $("#tipoIncidencia").val();

                $.ajax({
                    type: "POST",
                    url: "/public/obtener_incidencias",
                    data: {
                        fecha_ini: fechaini,
                        fecha_fin: fechafin,
                        motivo:tipo,

                        pagina: $("#numeropagina").val(),
                        registros_por_pagina: 10,
                    },
                    success: function (response) {

                        console.log('insidencias', response);
                        if (response.status == 100) {
                            incidencias.length = 0;
                            var datos = response.response;

                            incidencias = datos;

                            html = '';

                            for(i in datos){


                                var unidades = `<ul class="lista_chida">`;
                                for(j in datos[i].unidades){
                                    unidades += `<li style="border-left:2px solid #848f33; margin:2% 0;">${datos[i].unidades[j].nombre_unidad}</li>`;
                                }
                                unidades += '</ul>';


                                var salas = `<ul class="lista_chida">`;
                                    for(j in datos[i].nombre_salas){
                                        salas += `<li style="border-left:2px solid #848f33; margin:2% 0;">${datos[i].nombre_salas[j].nombre_sala}</li>`;
                                    }
                                salas += '</ul>';

                                activar = '';
                                if(datos[i].etapa == 1){
                                    activar = `<i class="fas fa-arrow-alt-circle-up" title="Activar Incidencia" onclick="modalActivarIncidencia(${i})" style="cursor:pointer; color: #fff; background: #E67E22; padding: 5px; border-radius: 6px;"></i>`;
                                }else if(datos[i].etapa == 2){
                                    activar = `<i class="fas fa-arrow-alt-circle-down" title="Desactivar Incidencia" onclick="modalDesactivarIncidencia(${i})" style="cursor:pointer; color: #fff; background: #E67E22; padding: 5px; border-radius: 6px;"></i>`;
                                }else{
                                    activar = '';
                                }

                                html += `
                                    <tr>
                                        <td>
                                            <i class="fas fa-edit" title="Editar Incidencia" onclick="editarIncidencia(${i})" style="cursor:pointer; color: #fff; background: #848f33; padding: 5px; border-radius: 6px;"></i>
                                            ${activar}
                                            <i class="fas fa-trash-alt" title="Eliminar Incidencia" onclick="modalEliminar(${i})" style="cursor:pointer; background: #A72424; padding: 5px; color: #fff; border-radius: 4px;"></i>
                                        </td>
                                        <td>${datos[i].id_incidencia_sala}</td>
                                        <td>${datos[i].motivo}</td>
                                        <td>${datos[i].fecha_desde}</td>
                                        <td>${datos[i].fecha_hasta}</td>
                                        <td>${salas}</td>
                                        <td>${datos[i].tipo}</td>
                                        <td>${datos[i].aplica_unidades == 0 ? 'No' : 'Si'}</td>
                                        <td>${unidades}</td>
                                        <td>${datos[i].etapa == 1 ? '1.- En registro': (datos[i].etapa == 2 ? '2.- Activo' : '3.- Inactivo')}</td>
                                        <td>${datos[i].comentarios ?? ""}</td>
                                        <td>${datos[i].usuario_responsable}</td>
                                    </tr>
                                `;
                            }

                            $('#body-table1').html(html);

                            $(".pagina_total_texto").html(response.response_pag["paginas_totales"]);
                            $("#paginas_totales").val(response.response_pag["paginas_totales"]);
                        } else {
                            body = `<tr><td colspan="5"><h5>Sin datos para mostrar</h5></td> tr>`;
                            $("#body-table1").html(body);
                        }
                    },
                });
            }
        }

        function nueva_incidencia() {

            var salas_ss = '<option value="" selected >Seleccionar</option>';
            for(i in salas_session['message']){
                salas_ss += `<option  value="${salas_session['message'][i].id_sala}"  nombre="${salas_session['message'][i].sala}">${salas_session['message'][i].sala}</option>`;
            }


            var html = `
                <div class="row my-3">
                    <div class="col-lg-4" style="border-right: 1px solid #848f33;">
                        <div style="border-bottom: 1px solid #848f33; padding-bottom:10px; display:flex; justify-content: space-between; align-items: center;">
                            <div class="col-lg-11">
                                <div class="form-group">
                                    <label class="label">Sala: </label>
                                    <select  class="form-control select2"  id="sala_cmp" name="" autocomplete="off">
                                        ${salas_ss}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1" style="margin-top:3%; padding:0;">
                                <a href="javascript:void(0)" style="font-size: 26px; color:#848f33;" onclick="agregarSala()">
                                    <i class="fa fa-plus-circle d-inline-block" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div id="datosSala"  class="row" style="max-height: 400px; justify-content: center; align-items: center; overflow: auto; width: 100%; margin: 0 auto;"></div>
                    </div>

                    <form class="col-lg-8" autocomplete="off">

                        <div class="row"  id="formularioIncidencia2">

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="label">Fecha de solicitud (De): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" id="fechaInicioAgregar" name="" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="label">Fecha de solicitud (A): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA"  id="fechaFinAgregar" name="" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="inputsm">De las:</label>
                                <input class="form-control form-control clockpicker" id="deLas" type="text" autocomplete="off">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="inputsm">Hrs. a las:</label>
                                <input class="form-control form-control clockpicker" id="aLas" type="text" autocomplete="off">
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group" style="margin-bottom: 2px;" id="todasUnidades">
                                    <label class="form-control-label mg-t-20"><strong>¿Aplicar a todas las unidades de gestión?: </strong><span class="tx-danger">*</span></label>
                                    <div class="d-inline-block mg-l-10">
                                        <label class="rdiobox d-inline-block mg-l-5">
                                            <input name="todas_unidades"  type="radio" onclick="seleccionarU(this)" value="TODAS">
                                            <span class="pd-l-0">SI </span>
                                        </label>
                                        <label class="rdiobox d-inline-block mg-l-5">
                                            <input name="todas_unidades"  type="radio" onclick="seleccionarU(this)" value="NOTODAS">
                                            <span class="pd-l-0">NO</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group" style="margin-bottom: 2px;" id="tipoPeriodo">
                                    <label class="form-control-label mg-t-20"><strong>Tipo de periodo: </strong><span class="tx-danger">*</span></label>
                                    <div class="d-inline-block mg-l-10">
                                        <label class="rdiobox d-inline-block mg-l-5">
                                        <input name="tipo_periodo" type="radio" value="unico">
                                        <span class="pd-l-0">Intervalo Único </span>
                                        </label>
                                        <label class="rdiobox d-inline-block mg-l-5">
                                        <input name="tipo_periodo" type="radio" value="repetitivo">
                                        <span class="pd-l-0">Repetitivo</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="sel2">Motivo de la incidencia:</label>
                                <select class="form-control form-control" id="motivoIncidencia">
                                    <option selected disabled value="">Elija una opción</option>
                                    <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                    <option value="RESERVADO">RESERVADO</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <div class="form-group" >
                                    <label class="form-control-label">Comentarios Adicionales</label>
                                    <textarea class="form-control" id="comentariosAdicionales" rows="3" cols="20" ></textarea>
                                </div>    
                            </div>

                        </div>

                        <div id="frmUnidades"  style="display: none; flex-wrap: wrap;">
                            
                        </div>

                    </form>   
                </div>
            `;
            
            $('#titleInci').html('Agregar Nueva Incidencia');

            $('#footerIncidencia').html(`
                <button type="button" class="btn btn-secondary d-inline-block mg-r-auto" data-dismiss="modal">Cerrar</button>
                <button type="button" id="enviarConfiguracionIncidenciaBtn" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="guardarIncidencia()">Guardar Incidencia</button>
            `);

            $('#espacionAgregar').html(html);

            setTimeout(function(){ configA() },400);
            $("#modalNuevaIncidencia").modal("show");
        }


        function agregarSala(){
            var sala_seleccionada = $('#sala_cmp').val();
            var nombre_sala_seleccionada = $('#sala_cmp option:selected').attr('nombre');
            
            if(sala_seleccionada == '')  return modal_error('Selecciona una sala', 'modalNuevaIncidencia');

            for(j in arrSalas){
                if(arrSalas[j].id_sala == sala_seleccionada){
                    return modal_error('Esta sala ya fue agregada', 'modalNuevaIncidencia');
                }
            }

            arrSalas.push({
                'id_sala': sala_seleccionada,
                'nombre_sala':nombre_sala_seleccionada,
                'status':1
            });

            mostrarSalas();
        }

        function mostrarSalas(){
            var salas = '';

            for(i in arrSalas){
                if(arrSalas[i].status == 1){
                salas += `<div class="item_sala" onclick="removerSala(${i})">
                            <div class="col-md-12">
                                <h6 style="padding: 9px 0 0 8px; text-align:center;" id="title_${arrSalas[i].id_sala}">${arrSalas[i].nombre_sala}</h6>
                            </div>
                        </div>`;
                }
            }

            $('#datosSala').html(salas);
        }

        function removerSala(__indx__){
            arrSalas[__indx__].status = 0;
            mostrarSalas()
        }


        function seleccionarU(obj){
            var opcion = $(obj).val();
            console.log(opcion);

            if(opcion == 'NOTODAS'){
                let unidades_ss = optNoUnidades();
                $('#frmUnidades').css('display', 'flex');
                $('#frmUnidades').html(unidades_ss);
            }else{
                $('#frmUnidades').html('');
                $('#frmUnidades').css('display', 'none');
            }
        }

        function optNoUnidades(){

            unidadesSeleccionadas.length = 0;
            title_u = ['Unidad de Gestión 1', 'Unidad de Gestión 2', 'Unidad de Gestión 3', 'Unidad de Gestión 4', 'Unidad de Gestión 5', 'Unidad de Gestión 6', 'Unidad de Gestión 7', 'Unidad de Gestión 8', 'Unidad de Gestión 9', 'Unidad de Gestión 10', 'Unidad de Gestión 11', 'Unidad de Gestión 12', 'Unidad Adolescentes', 'Ejecución Sullivan', 'Ejecución Norte', 'Ejecución Oriente', 'Ejecución Medidas Sancionadoras'];

            var unidades_ss = '';
            for(i in unidades_session['response']){

                unidadesSeleccionadas.push({
                    'id_unidad':unidades_session['response'][i].id_unidad_gestion,
                    'nombre_corto':unidades_session['response'][i].nombre_corto,
                    'nombre_largo': title_u[i],
                    'status': 0
                });

                unidades_ss += `<div class="uni_agregada" id="uni_agregada_${unidades_session['response'][i].id_unidad_gestion}" onclick="seleccionarUnidad(${i})">
                    ${unidades_session['response'][i].nombre_corto}
                    <div style="font-size:0.9em; text-align:center;">
                        ${title_u[i]}
                    </div>
                </div>`;
            }

            return unidades_ss;

        }


        function seleccionarUnidad(__indx__){
            unidadesSeleccionadas[__indx__].status = 1;
            mostrarUnidades();
        }

        function mostrarUnidades(){
            var unidades_ss = '';

            for(i in unidadesSeleccionadas){
                if(unidadesSeleccionadas[i].status == 1){
                    unidades_ss += `<div class="uni_agregada activa" id="uni_agregada_${unidadesSeleccionadas[i].id_unidad}" onclick="removerUnidad(${i})">
                        ${unidadesSeleccionadas[i].nombre_corto}
                        <div style="font-size:0.9em; text-align:center;">
                            ${unidadesSeleccionadas[i].nombre_largo}
                        </div>
                    </div>`;
                }else{
                    unidades_ss += `<div class="uni_agregada" id="uni_agregada_${unidadesSeleccionadas[i].id_unidad}" onclick="seleccionarUnidad(${i})">
                        ${unidadesSeleccionadas[i].nombre_corto}
                        <div style="font-size:0.9em; text-align:center;">
                            ${unidadesSeleccionadas[i].nombre_largo}
                        </div>
                    </div>`;
                }
            }

            $('#frmUnidades').html(unidades_ss);
        }

        function removerUnidad(__indx__, __indy__){
            unidadesSeleccionadas[__indx__].status = 0;
            mostrarUnidades();
        } 


        // ###### GUARDAR INCIDENCIA ######
        
        function guardarIncidencia() {
            $(".error").removeClass("error");

            const validacion = validarDatos();

            if (validacion != 100) {
                const { campo, error } = validacion;
                if ($("#" + campo).is("select")) {
                    $('span[aria-labelledby="select2-' + campo + '-container"]').addClass("error");
                } else {
                    $("#" + campo).addClass("error");
                }

                modal_error(error, 'modalNuevaIncidencia');
            } 

            var fechaini = $("#fechaInicioAgregar").val() == '' ? '-' : get_date($("#fechaInicioAgregar").val());
            var fechafin = $("#fechaFinAgregar").val() == '' ? '-' : get_date($("#fechaFinAgregar").val());

            var horainicio = $("#deLas").val() == '' ? '00:00': $("#deLas").val();
            var horafin = $("#aLas").val() == '' ? '23:59': $("#aLas").val();

            var aplica_unidades =  $("input:radio[name=todas_unidades]:checked").val() == 'TODAS' ? 1 : 0;
            var tipo =  $("input:radio[name=tipo_periodo]:checked").val();
            
            var motivo = $("#motivoIncidencia").val() == '' ? '-' : $("#motivoIncidencia").val();
            var comentarios = $("#comentariosAdicionales").val();


            var ids_unidad_gestion = [];
            if (aplica_unidades == 1) {
                uni = "12,13,14,15,16,17,18,19,20,30,31,32,33,34,35,36,37";
                ids_unidad_gestion = uni.split(',');
            } else {
                for(i in unidadesSeleccionadas){
                    if(unidadesSeleccionadas[i].status == 1){
                        ids_unidad_gestion.push(unidadesSeleccionadas[i].id_unidad);
                    }
                }
            }   


            if(arrSalas.length <= 0){
                return modal_error('Falta agregar salas', 'modalNuevaIncidencia');
            }

            var salas = [];
            for(i in arrSalas){
                if(arrSalas[i].status == 1){
                    salas.push(arrSalas[i].id_sala);
                }
            }

            var data = {
                fecha_desde: fechaini + " " + horainicio + ":00",
                fecha_hasta: fechafin + " " + horafin + ":00",
                aplica_unidades: aplica_unidades,
                tipo: tipo,
                motivo: motivo,
                comentarios: comentarios,
                ids_unidad_gestion: ids_unidad_gestion,
                salas: salas,
            }

            console.log('Datos de insidencias',data);
            
            
            $.ajax({
                type: "POST",
                url: "/public/registrar_incidencia",
                data: data,
                success: function (response) {
                    if (response.status == 100) {
                        sec_ajax();
                        var mensaje = response.response;
                        $('#modalNuevaIncidencia').modal('hide');
                        modal_success(mensaje);
                    } else {
                        var mensaje = response.response;
                        modal_error(mensaje, 'modalNuevaIncidencia');
                    }
                }
            });
            
        }

        // ##### ACTUALIZAR INCIDENCIA ######

        function editarIncidencia(__index__){
            arrSalas.length = 0;
            unidadesSeleccionadas.length = 0;

            var info = incidencias[__index__];
            let title_u = [
                'Unidad de Gestión 1', 
                'Unidad de Gestión 2', 
                'Unidad de Gestión 3', 
                'Unidad de Gestión 4', 
                'Unidad de Gestión 5', 
                'Unidad de Gestión 6', 
                'Unidad de Gestión 7', 
                'Unidad de Gestión 8', 
                'Unidad de Gestión 9', 
                'Unidad de Gestión 10', 
                'Unidad de Gestión 11', 
                'Unidad de Gestión 12', 
                'Unidad Adolescentes', 
                'Ejecución Sullivan', 
                'Ejecución Norte', 
                'Ejecución Oriente', 
                'Ejecución Medidas Sancionadoras',
                ];

            console.log(info);

            var salas_ss = '<option value="" selected >Seleccionar</option>';
            for(i in salas_session['message']){
                salas_ss += `<option  value="${salas_session['message'][i].id_sala}"  nombre="${salas_session['message'][i].sala}">${salas_session['message'][i].sala}</option>`;
            }

            
            for(i in info.nombre_salas){
                arrSalas.push({
                    'id_sala': info.nombre_salas[i].id_sala,
                    'nombre_sala':info.nombre_salas[i].nombre_sala,
                    'status':1
                });
            }
            
            let fecha_inicio = info.fecha_desde == null ? '' : info.fecha_desde.substring(0,10); 
            let fecha_fin = info.fecha_hasta == null ? '' : info.fecha_hasta.substring(0,10); 

            let hora_ini = info.fecha_desde == null ? '' : info.fecha_desde.substring(11,16); 
            let hora_fin = info.fecha_hasta == null ? '' : info.fecha_hasta.substring(11,16); 

            if(info.aplica_unidades == 0){
                checked = 'checked';
                checked1 = '';
                display_ = 'flex';
            }else{
                checked = '';
                checked1 = 'checked';
                display_ = 'none';
            }

            if(info.tipo == 'unico'){
                checked2 = 'checked';
                checked3 = '';
            }else{
                checked2 = '';
                checked3 = 'checked';
            }

            let option = '';
            switch(info.motivo){
                case 'MANTENIMIENTO':
                    option = `
                        <option disabled value="">Elija una opción</option>
                        <option selected value="MANTENIMIENTO">MANTENIMIENTO</option>
                        <option value="RESERVADO">RESERVADO</option>
                        <option value="OTRO">OTRO</option>
                    `;
                break;

                case 'RESERVADO':
                    option = `
                        <option disabled value="">Elija una opción</option>
                        <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                        <option selected value="RESERVADO">RESERVADO</option>
                        <option value="OTRO">OTRO</option>
                    `;
                break;

                case 'OTRO':
                    option = `
                        <option disabled value="">Elija una opción</option>
                        <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                        <option value="RESERVADO">RESERVADO</option>
                        <option selected value="OTRO">OTRO</option>
                    `;
                break;

                default :                
                    option = `
                        <option selected disabled value="">Elija una opción</option>
                        <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                        <option value="RESERVADO">RESERVADO</option>
                        <option value="OTRO">OTRO</option>
                    `;
                break;
            }
            
            
            let u = [];
            for(j in info.unidades){
                u.push(info.unidades[j].id_unidad);
            }

            var unidades_ss = '';
            for(i in unidades_session['response']){
                if(u.includes(unidades_session['response'][i].id_unidad_gestion)){
                    unidadesSeleccionadas.push({
                        'id_unidad':unidades_session['response'][i].id_unidad_gestion,
                        'nombre_corto':unidades_session['response'][i].nombre_corto,
                        'nombre_largo': title_u[i],
                        'status':  1
                    });
                }else{
                    unidadesSeleccionadas.push({
                        'id_unidad':unidades_session['response'][i].id_unidad_gestion,
                        'nombre_corto':unidades_session['response'][i].nombre_corto,
                        'nombre_largo': title_u[i],
                        'status':  0
                    });
                }
            }


            var html = `
                <div class="row my-3">
                    <div class="col-lg-4" style="border-right: 1px solid #848f33;">
                        <div style="border-bottom: 1px solid #848f33; padding-bottom:10px; display:flex; justify-content: space-between; align-items: center;">
                            <div class="col-lg-11">
                                <div class="form-group">
                                    <label class="label">Sala: </label>
                                    <select  class="form-control select2"  id="sala_cmp" name="" autocomplete="off">
                                        ${salas_ss}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1" style="margin-top:3%; padding:0;">
                                <a href="javascript:void(0)" style="font-size: 26px; color:#848f33;" onclick="agregarSala()">
                                    <i class="fa fa-plus-circle d-inline-block" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div id="datosSala"  class="row" style="max-height: 400px; justify-content: center; align-items: center; overflow: auto; width: 100%; margin: 0 auto;"></div>
                    </div>

                    <form class="col-lg-8" autocomplete="off">

                        <div class="row"  id="formularioIncidencia2">

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="label">Fecha de solicitud (De): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" value="${fecha_inicio}" placeholder="DD-MM-AAAA" id="fechaInicioAgregar" name="" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="label">Fecha de solicitud (A): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" value="${fecha_fin}" placeholder="DD-MM-AAAA"  id="fechaFinAgregar" name="" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="inputsm">De las:</label>
                                <input class="form-control form-control clockpicker" value="${hora_ini}" id="deLas" type="text" autocomplete="off">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="inputsm">Hrs. a las:</label>
                                <input class="form-control form-control clockpicker" value="${hora_fin}" id="aLas" type="text" autocomplete="off">
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group" style="margin-bottom: 2px;" id="todasUnidades">
                                    <label class="form-control-label mg-t-20"><strong>¿Aplicar a todas las unidades de gestión?: </strong><span class="tx-danger">*</span></label>
                                    <div class="d-inline-block mg-l-10">
                                        <label class="rdiobox d-inline-block mg-l-5">
                                            <input name="todas_unidades"  type="radio" ${checked1} onclick="seleccionarU(this)" value="TODAS">
                                            <span class="pd-l-0">SI </span>
                                        </label>
                                        <label class="rdiobox d-inline-block mg-l-5">
                                            <input name="todas_unidades"  type="radio" ${checked} onclick="seleccionarU(this)" value="NOTODAS">
                                            <span class="pd-l-0">NO</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group" style="margin-bottom: 2px;" id="tipoPeriodo">
                                    <label class="form-control-label mg-t-20"><strong>Tipo de periodo: </strong><span class="tx-danger">*</span></label>
                                    <div class="d-inline-block mg-l-10">
                                        <label class="rdiobox d-inline-block mg-l-5">
                                        <input name="tipo_periodo" type="radio" ${checked2} value="unico">
                                        <span class="pd-l-0">Intervalo Único </span>
                                        </label>
                                        <label class="rdiobox d-inline-block mg-l-5">
                                        <input name="tipo_periodo" type="radio" ${checked3} value="repetitivo">
                                        <span class="pd-l-0">Repetitivo</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="sel2">Motivo de la incidencia:</label>
                                <select class="form-control form-control" id="motivoIncidencia">
                                    ${option}
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <div class="form-group" >
                                    <label class="form-control-label">Comentarios Adicionales</label>
                                    <textarea class="form-control" value="${info.comentarios != null ? info.comentarios : ''}" id="comentariosAdicionales" rows="3" cols="20" >${info.comentarios != null ? info.comentarios : ''}</textarea>
                                </div>    
                            </div>

                        </div>

                        <div id="frmUnidades"  style="display: ${display_}; flex-wrap: wrap;">
                            
                        </div>

                    </form>   
                </div>
            `;

            $('#titleInci').html('Actualizar Incidencia');

            $('#footerIncidencia').html(`
                <button type="button" class="btn btn-secondary d-inline-block mg-r-auto" data-dismiss="modal">Cerrar</button>
                <button type="button" id="enviarConfiguracionIncidenciaBtn" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="actualizarIncidencia(${info.id_incidencia_sala})">Actualizar Incidencia</button>
            `);

            $('#espacionAgregar').html(html);

            setTimeout(function(){ 
                configA() 
                mostrarSalas();
                mostrarUnidades();
            },400);

            $("#modalNuevaIncidencia").modal("show");
        }

        function actualizarIncidencia(id_incidencia_sala){
            $(".error").removeClass("error");

            const validacion = validarDatos();

            if (validacion != 100) {
                const { campo, error } = validacion;
                if ($("#" + campo).is("select")) {
                    $('span[aria-labelledby="select2-' + campo + '-container"]').addClass("error");
                } else {
                    $("#" + campo).addClass("error");
                }

                modal_error(error, 'modalNuevaIncidencia');
            } 

            var fechaini = $("#fechaInicioAgregar").val() == '' ? '-' : get_date($("#fechaInicioAgregar").val());
            var fechafin = $("#fechaFinAgregar").val() == '' ? '-' : get_date($("#fechaFinAgregar").val());

            var horainicio = $("#deLas").val() == '' ? '00:00': $("#deLas").val();
            var horafin = $("#aLas").val() == '' ? '23:59': $("#aLas").val();

            var aplica_unidades =  $("input:radio[name=todas_unidades]:checked").val() == 'TODAS' ? 1 : 0;
            var tipo =  $("input:radio[name=tipo_periodo]:checked").val();
            
            var motivo = $("#motivoIncidencia").val() == '' ? '-' : $("#motivoIncidencia").val();
            var comentarios = $("#comentariosAdicionales").val();


            var ids_unidad_gestion = [];
            if (aplica_unidades == 1) {
                uni = "12,13,14,15,16,17,18,19,20,30,31,32,33,34,35,36,37";
                ids_unidad_gestion = uni.split(',');
            } else {
                for(i in unidadesSeleccionadas){
                    if(unidadesSeleccionadas[i].status == 1){
                        ids_unidad_gestion.push(unidadesSeleccionadas[i].id_unidad);
                    }
                }
            }   


            if(arrSalas.length <= 0){
                return modal_error('Falta agregar salas', 'modalNuevaIncidencia');
            }

            var salas = [];
            for(i in arrSalas){
                if(arrSalas[i].status == 1){
                    salas.push(arrSalas[i].id_sala);
                }
            }

            var data = {
                id_incidencia_sala : id_incidencia_sala,
                fecha_desde: fechaini + " " + horainicio + ":00",
                fecha_hasta: fechafin + " " + horafin + ":00",
                aplica_unidades: aplica_unidades,
                tipo: tipo,
                motivo: motivo,
                comentarios: comentarios,
                ids_unidad_gestion: ids_unidad_gestion,
                salas: salas,
            }

            console.log('Datos de insidencias',data);

            $.ajax({
                type: "POST",
                url: "/public/actualizar_incidencia",
                data: data,
                success: function (response) {
                    if (response.status == 100) {
                        sec_ajax();
                        var mensaje = response.response;
                        $('#modalNuevaIncidencia').modal('hide');
                        modal_success(mensaje);
                    } else {
                        var mensaje = response.response;
                        modal_error(mensaje, 'modalNuevaIncidencia');
                    }
                }
            });
            
        }

        // #### ELIMINAR INCIDENCIA #######

        function modalEliminar(__index__){
            $('#eliminarResolutivos').attr('onclick', `eliminarInsidencias(${__index__})`);
            $('#modalEliminar').modal('show');
        }

        function eliminarInsidencias(__index__){
            var info = incidencias[__index__];
            $('#modalEliminar').modal('hide');

            console.log('info', info);
            
            $.ajax({
                type: "POST",
                url: "/public/eliminar_incidencia",
                data: {
                    id_incidencia_sala:info.id_incidencia_sala
                },
                success: function (response) {
                    if (response.status == 100) {
                        sec_ajax();
                        var mensaje = response.response;
                        $('#modalNuevaIncidencia').modal('hide');
                        modal_success(mensaje);
                    } else {
                        var mensaje = response.response;
                        modal_error(mensaje, 'modalNuevaIncidencia');
                    }
                }
            });
            
        }

        //####  MODAL ACTIVAR/DESACTIVAR INCIDENCIA #####

        function modalActivarIncidencia(__index__){
            $('#titleAct').html('Activar Incidencia de Sala');
            $('#bodyAct').html('¿Desea Activar esta Incidencia de sala?');
            $('#activaDesSala').html('Activar');
            $('#activaDesSala').attr('onclick', `activarIncidencia(${__index__}, 2)`);
            $('#modalAct').modal('show');
        }

        function modalDesactivarIncidencia(__index__){
            $('#titleAct').html('Desactivar Incidencia de Sala');
            $('#bodyAct').html('¿Desea Inactivar esta Incidencia de sala?');
            $('#activaDesSala').html('Desactivar');
            $('#activaDesSala').attr('onclick', `activarIncidencia(${__index__}, 3)`);
            $('#modalAct').modal('show');
        }

        function activarIncidencia(__index__, status){
            var info = incidencias[__index__];
            $('#modalAct').modal('hide');

            console.log('info', info);
            
            $.ajax({
                type: "POST",
                url: "/public/activar_incidencia",
                data: {
                    id_incidencia_sala:info.id_incidencia_sala,
                    etapa: status
                },
                success: function (response) {
                    if (response.status == 100) {
                        sec_ajax();
                        var mensaje = response.response;
                        modal_success(mensaje);
                    } else {
                        var mensaje = response.response;
                        modal_error(mensaje);
                    }
                }
            });
        }

        //  ########### FUNCIONALIDADES ###########
        function descargar_consulta(extension) {
            console.log("entraste a generar :" + extension);

            $("#modal_loading").modal("show");

            //cambio formato de fecha
            var fechaini = $("#fechaini").val() == '' ? '-' : get_date($("#fechaini").val());
            var fechafin = $("#fechafin").val() == '' ? '-' : get_date($("#fechafin").val());
            var tipo = $("#tipoIncidencia").val() == '' ? '-' : $("#tipoIncidencia").val();
            let orden_columnas = get_orden_columnas();

            $.ajax({
                type: "GET",
                url: "/exportar_busqueda_incidencias",
                data: {
                    fecha_ini: fechaini,
                    fecha_fin: fechafin,
                    tipo: tipo,
                    extension: extension,
                    orden_columnas: orden_columnas
                },
                success: function (data) {
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

                    setTimeout(function () {
                        $("#modal_loading").modal("hide");
                    }, 500);
                },
            });
        }

        function validarDatos() {
            if (expVacio.test($("#fechaInicioAgregar").val())) return { estatus: 0, campo: "fechaInicioAgregar", error: "Falta la fecha inicial" };

            if (expVacio.test($("#fechaFinAgregar").val())) return { estatus: 0, campo: "fechaFinAgregar", error: "Falta la fecha final" };

            if (expVacio.test($("#deLas").val())) return { estatus: 0, campo: "deLas", error: "Falta la hora inicial" };
            if (expVacio.test($("#aLas").val())) return { estatus: 0, campo: "aLas", error: "Falta la hora final" };

            return 100;
        }

        function configA(){
            $('.clockpicker').clockpicker({
                autoclose: true
            });

            $(".select2").select2();

            let fecha_actual = new Date();
            $('.fc-datepicker').datepicker({
              showOtherMonths: true,
              selectOtherMonths: true,
              dateFormat: 'yy-mm-dd',
              changeYear: true,
              yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
            });
        }

        //####### FUNCIONES GENERALES ########### 

        function get_date(date, format = 'YYYY-MM-DD') {
            if (format == 'YYYY-MM-DD' && date.substring(0, 4).includes('-'))
                return date.split('-').reverse().join('-');
            if (format == 'DD-MM-YYYY' && !date.substring(0, 4).includes('-'))
                return date.split('-').reverse().join('-');
            if (format == 'DD/MM/YYYY' && !date.substring(0, 4).includes('-'))
                return date.split('/').reverse().join('-');
            else
                return date;
        }

        function modal_success(mensaje,modalAnterior=null){
            $('#modal-success-titulo').html(`${mensaje}`);
            $('#btnCerrarSuccess').attr('data-modal',modalAnterior!=null?modalAnterior:'');
            if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
            $('#modalSuccess').modal('show');
        }
  
        function modal_error(mensaje,modalAnterior=null){
            $('#messageError').html(`${mensaje}`);
            $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
            if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
            $('#modalError').modal('show');
        }

        function cerrar_modal(valor) {
            $("#" + valor).modal("hide");
            $("body").removeClass("modal-open");
        }

        $(".cerrar-modal").click(function(){
            let modalOpen = $(this).attr('data-modal');
            let modalClose = $(this).attr('data-thismodal');
            
              if(modalClose == 'listaJuecesTramite'){
                  $('#tramitelawer').prop('checked',false);
              }
  
            //console.log(modalOpen,modalClose);
            $("#"+modalClose).modal('hide');
            if( modalOpen.length ) setTimeout(function(){ $("#"+modalOpen).modal('show'); }, 500); 
        });

    </script>
@endsection

@section('seccion-modales')

    <div id="modalNuevaIncidencia" class="modal fade" style="overflow-y: scroll;" data-backdrop="static">
        <div class="modal-dialog modal-lg xl mg-b-100 modalRemision-body" role="document" style="width: -webkit-fill-available;">
            <div class="modal-content tx-size-sm modalRemision-content">
                <div class="modal-header pd-x-20">
                    <h5 class="modal-title" id="titleInci">-</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body pd-30" id="espacionAgregar"> </div>

                <div class="modal-footer d-flex" id="footerIncidencia"></div>

            </div>
        </div><!-- modal-body -->
    </div>

    <div id="modalEliminar" class="modal fade" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Eliminar Incidencia</h5>
            </div>
            <div class="modal-body">
              <input type="hidden" id="idGrupo">
              <input type="hidden" id="iduser_input">
              <h5>¿Deseas eliminar la Incidencia?</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary cerrar-modal" data-modal="modalHistory" data-thismodal="modalEliminar">Cerrar</button>
              <button type="button" class="btn btn-danger" id="eliminarResolutivos" onclick="eliminarInsidencias()">Eliminar</button>
            </div>
          </div>
        </div>
    </div>

    <div id="modalAct" class="modal fade" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="titleAct">-</h5>
            </div>
            <div class="modal-body">
              <h5 id="bodyAct">-</h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary cerrar-modal" data-modal="modalHistory" data-thismodal="modalAct">Cerrar</button>
              <button type="button" class="btn btn-primary" id="activaDesSala" onclick="activarIncidencia()">Activar</button>
            </div>
          </div>
        </div>
    </div>

    {{-- MODAL ERROR --}}
    <div id="modalError" class="modal fade"  data-backdrop="static">
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> -->
              <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
              <h4 class="tx-danger mg-b-20">Error!</h4>
              <p class="mg-b-20 mg-x-20" id="messageError"></p>
              <button type="button" class="btn btn-danger pd-x-25 cerrar-modal" data-modal="" data-thismodal="modalError" id="btnCerrarError">Aceptar</button>
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div>
    
    {{-- MODAL SUCCESS --}}
    <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
          <div class="modal-dialog" role="document">
              <div class="modal-content tx-size-sm">
                <div class="modal-body tx-center pd-y-20 pd-x-20">
                      <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
                      <h6 class="tx-success tx-semibold mg-b-20">Hecho!</h6>
                      <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-success-titulo">Titulo Modal Success</p>
                </div>
                <div class="modal-footer d-flex">
                  <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-modal="" data-thismodal="modalSuccess" id="btnCerrarSuccess">Aceptar</button>
                </div>
              </div>
          </div>
    </div>
@endsection
