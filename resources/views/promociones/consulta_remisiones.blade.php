@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Remisiones</a></li>
    <li class="breadcrumb-item"><a href="#">Consulta de Remisiones</a></li>
 </ol>
 <h6 class="slim-pagetitle">Consulta de Remisiones</h6>
@endsection



@section('contenido-principal')

  {{--   @if(!isset($request->menu_general['response']))
    <div class="section-wrapper">
        <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
    </div>
    @else
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 1151))
        <div class="section-wrapper">
            <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
        </div>
    @else --}}
 <div class="section-wrapper"  style="max-width: 100%;">
    <div class="form-layout">
        <div id="accordion" class="accordion-one mg-b-20" role="tablist" aria-multiselectable="true">
            <div class="card">

                <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                    Búsqueda Avanzada
                    </a>
                </div><!-- card-header -->

                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="row mg-b-25">
                                <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Id Acuse :</label>
                                            <input class="form-control" type="text"  value="" name="" id="idsolicitud" placeholder="">
                                        </div>
                                    </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Folio de solicitud : </label>
                                        <input class="form-control" type="text"  value="" name="" id="foliosolicitud" placeholder="">
                                    </div>
                                </div>



                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Carpeta Judicial : </label>
                                        <input class="form-control" type="text"  value="" placeholder="" id="foliocarpeta"  >
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




                                <div class="col-lg-3" >
                                <label class="form-control-label">Estatus Actual:</label>
                                <div class="form-group" >
                                    <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" id="estatusactual">
                                        <option selected disabled value="">Elija una opción</option>
                                        <option value="" >{{'TODOS'}}</option>
                                            <option value="RECIBIDA" >{{'RECIBIDA'}}</option>
                                            <option value="REGISTRADA" >{{'REGISTRADA'}}</option>
                                            <option value="TRAMITE CJ" >{{'CARPETA JUDICIAL ASIGNADA'}}</option>
                                    </select>
                                </div>
                                </div>

                            <div class="col-lg-3">
                            <label class="form-control-label">Situacion:</label>
                            <div class="form-group" >
                                <select class="form-control-lg select2 valid" width='100%'   autocomplete="off" id="situacion">
                                    <option selected disabled value="">Elija una opción</option>

                                </select>
                            </div>
                            </div>

                            <div class="col-lg-3" width='100%'>
                            <label class="form-control-label">Estatus semaforo:</label>
                            <div class="form-group" width='100%'>
                                <select class="form-control-lg select2 valid" width='100%'   autocomplete="off" id="estatus_color">
                                    <option selected disabled value="">Elija una opción</option>
                                    <option value="" >{{'TODOS'}}</option>
                                    <option value="verde" >{{'Atendidas'}}</option>
                                    <option value="amarillo" >{{'Visto,sin resolver'}}</option>
                                    <option value="rojo" >{{'Pendiente'}}</option>
                                </select>
                            </div>
                            </div>


                                </div><!-- row -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="sec_ajax('primera');">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div><!-- accordion -->

                        <br>


{{--
                        <div class="row justify-content-end">
                            <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">
                            @foreach($acciones as $acc)
                            @if($acc['id_vista_accion'] == 5 and $acc['valor'] != 0)
                            <div class="col-sm-2 pd-t-10" align="right">
                                <a href="javascript:void(0);" onclick="descargar_consulta('xls');" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                            </div>
                            @endif
                            @if($acc['id_vista_accion'] == 19 and $acc['valor'] != 0)
                            <div class="col-sm-2 pd-t-10" align="right">
                                <a href="javascript:void(0);" onclick="descargar_consulta('pdf');" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar PDF</a>
                            </div>
                            @endif
                            @endforeach
                        </div> --}}


                        <br>
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
                            <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
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


<!-- pagination-wrapper -->
<div id="table-firmas" class="mg-b-20">
    <table id="remisionesTable" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
        <thead style="background-color: #EBEEF1; color: #000; text-align:center">
            <tr>
                <th class="acciones">Acciones</th>
                <th class="semaforo"> </th>
                <th class="folio_solicitud">Folio de solicitud</th>
                <th class="fecha_registro">Fecha/hora de registro</th>
                <th class="carpeta_judicial">Carpeta Remitida</th>
                <th class="tipo_carpeta">Tipo de Carpeta</th>
                <th class="unidad_destino">Unidad de Gestion Destino</th>
                <th class="carpeta_judicial_asignada">Carpeta Judicial Asignada</th>
                <th class="responsable">Registrado por</th>
                <th class="situacion">Situacion</th>
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
    <div id="texto_paginator">Página <span class="pagina_actual_texto">0</span> de <span class="pagina_total_texto">0</span></div>
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
</div><!-- pagination-wrapper -->

    <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
    <input type="hidden" id="paginas_totales" name="paginas_totales" value="1">
    <input type="hidden" id="numeropagina">


    <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;">
            </div>
        </div>

     {{--    @endif
    @endif --}}
    <!-- Modal documentos -->

<div class="modal fade" id="modal_docs" >
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
      <div class="modal-header" >
        <h5 class="modal-title">Consulta de log de la solicitud</h5>
        <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <div class="modal-body p-3 mb-3 bg-dark text-white" id="modal_log_contenido" style="max-width:820px; height:460px; overflow: scroll;">
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
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
        <style>
            .flex-container {
            display: flex;
            justify-content: center;

            }

           .flex-container > div {
           margin: 1px;
           padding: 1px;
           font-size: 16px;
           }


          @media screen and (max-width: 600px) {

            }
            #modal-ver .modal-dialog {
                font-size: 18px;
                width: 100%;
                max-width:80%;
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
                font-size: 16px;
            }
            span.select2-container.select2-container--default.select2-container--open{

                width:'100%';
            }

             .datepicker-container{
                z-index: 1110;
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

            .fecha{
                min-width: 111px !important;
            }
            .carpeta_judicial {
                min-width: 200px !important;
            }

            .carpeta_judicial_asignada {
                min-width: 200px !important;
            }


            .folio_solicitud {
                min-width: 130px !important;
            }

            .situacion {
                min-width: 200px !important;
            }
            .responsable {
                min-width: 120px !important;
            }


            .semaforo {
                min-width: 50px !important;
                text-align:center;
                size: 20px;
                vertical-align: top;
            }

            .unidad_destino {
                min-width: 180px !important;
            }

            .tipo_carpeta {
                min-width: 180px !important;
            }

            .fecha_registro {
                min-width: 180px !important;
            }
            .folio_remitida {
                min-width: 130px !important;
            }
            .estatus_urgente {
                min-width: 100px !important;
            }

           .td-title {
                background-color: #f0f2f7 !important;
                max-width: 70px !important;
                border-color: #f0f2f7 !important;
                max-height:5px !important;
                padding: 3px 5px 3px 5px  !important;
            }

            .th-title {
                column-span: 100%;
                background-color: #f0f2f7 !important;
                min-width: 130px !important;
                border-color: #f0f2f7 !important;
                max-height:5px !important;
                padding: 3px 0px 3px 5px  !important;
                align: center !important;

            }


            .slim-navbar{
                z-index: 1000 !important;

            }

            table#datosolicitud tr td:nth-child(2) {
                    padding-left: 5px !important;
}



            .estatus {
                min-width: 80px  !important;
            }
            .acciones {
                min-width: 140px !important;

            }
            .estado_solicitud {
                min-width: 110px !important;
            }
            td.acciones{
                font-size: 25px !important;
                padding-top: 0 !important;
                padding-bottom: 0 !important;
                display: inline-block;

            }
            td.acciones a{display: inline;
                margin-left: 20%;
                cursor: pointer;
                text-align: left;
            }
            td.acciones a:first-child{
                margin-left: 0;
                text-align: left;
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

                    .active, .accordion:hover {
                    /*  background-color: #ccc; */
                    }


.panel {

  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: 0.2s ease-out;
}

</style>
@endsection
     @section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endsection
@section('seccion-scripts-functions')
<script>

let solicitudes=[];
let tabla_direcciones=[];
let tabla_alias=[];
let tabla_contacto=[];
let tabla_correo=[];

let tabla_datos=[];
let tabla_delitos=[];
let tabla_no_relacionados=[];


$(function(){
    'use strict';





             //enter key press
                    $('#idsolicitud').keypress(function (e) {
                if (e.which == 13) {
                    sec_ajax('primera');   //<---- Add this line
                }
                });

                $('#foliosolicitud').keypress(function (e) {
                if (e.which == 13) {
                    sec_ajax('primera');   //<---- Add this line
                }
                });



                $('#foliocarpeta').keypress(function (e) {
                if (e.which == 13) {
                    sec_ajax('primera');   //<---- Add this line
                }
                });

                $('#fechasolicitud').keypress(function (e) {
                if (e.which == 13) {
                    sec_ajax('primera');   //<---- Add this line
                }
                });

                $('#fechasolicitudh').keypress(function (e) {
                if (e.which == 13) {
                    sec_ajax('primera');   //<---- Add this line
                }
                });






     // Select2
     $('.select2').select2({
        minimumResultsForSearch: Infinity
    });

    sec_ajax();

    $('.fc-datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true
        });
     $( ".fc-datepicker" ).datepicker( "option", "dd-mm-yy" );

     $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '< Ant',
                nextText: 'Sig >',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
                    };

          $.datepicker.setDefaults($.datepicker.regional['es']);
          $(function () {
                    $("#fc-datepicker").datepicker();
            });

    //focus textfiled
    $('.form-layout .form-control').on('focusin', function(){
        $(this).closest('.form-group').addClass('form-group-active');
    });
    $('.form-layout .form-control').on('focusout', function(){
        $(this).closest('.form-group').removeClass('form-group-active');
    });

    accionBuscarArchivo_ajax('primera');

    setTimeout(function(){
        $('#modal_loading').modal('hide');
    }, 1000);




});

function accionBuscarArchivo_ajax(pagina_accion) {}





    function sec_ajax(pagina_accion) {
        $(document).ready(function(){
        $(".nav-tabs a").click(function(){
            $(this).tab('show');
        });
        });
            let body="";
            pagina=parseInt($('#pagina_actual').val());
            registros_por_pagina=10;

            if(pagina_accion=="primera"){
                pagina=1;
            }
            else if(pagina_accion=="avanzar"){
                pagina=pagina+1;
            }
            else if(pagina_accion=="atras"){
                pagina=pagina-1;
            }
            else if(pagina_accion=="ultima"){
                pagina=$('#paginas_totales').val();
            }
            if(pagina<=0 || pagina>$('#paginas_totales').val()){
            }
            else{
                $('#pagina_actual').val(pagina);
                $('#numeropagina').val(pagina);
                $('.pagina_actual_texto').html(pagina);




            let id_solicitud=""
                                    const format1 = "YYYY-DD-MM"

                            var date1 = new Date($("#fechasolicitud").val());
                            fechaini = moment(date1).format(format1);
                            if (fechaini === "Invalid date") {
                                fechaini= '';}
                            var date2 = new Date($("#fechasolicitudh").val());
                            fechafin = moment(date2).format(format1);

                            if (fechafin === "Invalid date") {
                                fechafin= '';}

                                $("#filtro_consulta").val(
                JSON.stringify(
                    {
                        id_solicitud:$("#idsolicitud").val(),
                        folio_solicitud:$("#foliosolicitud").val(),
                        folio_carpeta:$("#foliocarpeta").val(),
                        fecha_recepcion:fechaini,
                        fecha_recepcionh:fechafin,
                        estatus_flujo_actual:$("#estatusactual").val(),
                        estatus_urgente:$("#estatusurgente").val(),
                        materia_destino:$("#materiadestino").val(),
                        color:$("#estatus_color").val(),
                        pagina:1,
                        registros_por_pagina:1000000
                    }
                )
            );



            $.ajax({
                type:'GET',
            url:'/public/obtener_remisiones',
            // url:'/public/obtener_solicitudes',
                data:{
                    id_solicitud:$("#idsolicitud").val(),
                    folio_solicitud:$("#foliosolicitud").val(),
                    folio_carpeta:$("#foliocarpeta").val(),
                    fecha_recepcion:fechaini,
                    fecha_recepcionh:fechafin,
                    estatus_flujo_actual:$("#estatusactual").val(),
                    estatus_urgente:$("#estatusurgente").val(),
                    materia_destino:$("#materiadestino").val(),
                    color:$("#estatus_color").val(),
                    pagina:$('#numeropagina').val(),
                // registros_por_pagina:$('.pagina_actual_texto').val(),
                    registros_por_pagina:10,
                },

                    success:function(response) {
                        console.log(response);
                    if(response.status==100){


                        var datos=response.response;
                            color="";
                            title="";

                            body = new $('#remisionesTable').dataTable( {
                                        processing: true,
                                        data: datos,
                                        columns: [
                                            {
                                        data: "id_remision",
                                        render: function (data, type, row, meta) {
                                            return (
                                '<i class="icon ion-ios-information" title="Información" style="cursor: pointer" onclick="ver_remision('+data+')" id="informacion"></i> ' +
                                '<i class="icon fa fa-check-circle" title="Marcar solicitud como notificada" style="cursor: pointer" onclick="ver_flujo('+data+')" id="flujo"></i> '
                                            );
                                        },
                                    },
                                    {
                                    data: "estatus_actual",
                                    render: function (data, type, row, meta) {
                            /*           if (data == "amarillo") {
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
                                        } */

                                    // return '<i class="fas fa-lightbulb-o fa-lg" style="color:' + color + '" title="' + title + '" text-align="right" aria-hidden="true"></i>';
                                        return '<i class="fas fa-lightbulb-o fa-lg" style="color:" title="" text-align="right" aria-hidden="true"></i>';

                                    },
                                },
                                            { data: "folio",title:"Folio de Solicitud"},
                                            { data: "fecha_recepcion" ,title:"Fecha/hora de Registro"},
                                            { data: "folio_carpeta_rem" ,title:"Carpeta Remitida"},
                                            { data: "tipo_unidad_destino" ,title:"Tipo de carpeta"},

                                            { data: "unidad_destino" ,title:"Unidad de Gestion destino"},
                                            { data: "carpeta_judicial" ,title:"Carpeta Judicial Asignada"},
                                            { data: "id_usuario" ,title:"Registrado por"},
                                            { data: "estatus_actual" ,title:"Situación"},
                                        ],
                                        colReorder: {
                                fixedColumnsLeft: 2,
                            },
                            columnDefs: [
                                                { orderable: false, targets: 0 }
                                                ],
                            bDestroy: true,
                            colReset: true,
                            paging: false,
                            ordering: true,
                            info: false,
                            search: false,
                            filter: false,
                            stateSave: true,
                                    //  stateClear: false,
                                    //  stateLoaded: true,
                                    } );

                                        $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                                        $('#paginas_totales').val(response.response_pag['paginas_totales'])


                    }else{
                        body=body.concat(`<tr>
                            <td colspan="5">
                                            <td colspan="5"><h3>Sin datos relacionados</h3></td>
                                            <tr>`);
                                            $('#body-table1').html(body);
                                        //  limpiarCampos();

                    }
                }
            });
        }

    }

    function turnar(id_solicitud){

        //alert("turnar");

        const turnado= `<button type="button" onclick="turnar(${id_solicitud ?? ""})" class="btn btn-success" data-dismiss="modal">Turnar</button>   `
                    $('#boton').html( `${turnado}`);

        $.ajax({
        type:'PUT',
        url:'public/turnar_carpeta/5/'+ id_solicitud,
        data:{

        },
        success:function(response) {
             setTimeout(function(){
                $('#modal_loading').modal('hide');
                }, 500);
                if(response.status==100){

            //valor y boton id solicitud para turnado
          /*   const turnado= `<p class="mg-b-20 mg-x-20" > Carpeta Judicial Asignada ${response.folio_carpeta ?? ""}</p>   `
                                $('#carpetaAsignada').html( `${turnado}`);



                    const carpeta= response.folio_carpeta;
 */


                    $('#modalOkTurnado').modal('show');


                    }
                else{
                    $('#modalFailTurnado').modal('show');
                }
        }
        });
    }


        function descargar_pdf(id_solicitud){

                        $.ajax({
                    type:'GET',
                    url:'public/descargar_pdf/'+ id_solicitud,
                        data:{

                        },
                        success:function(response) {
                            setTimeout(function(){
                                $('#modal_loading').modal('hide');
                                }, 500);

                                if(response.status==100){
                                    var win = window.open(response.response, '_blank');
                                    }
                                else{
                                        $('#modalFail').modal('show');
                                }
                        }
                    });
        }

        function descargar_xml(id_solicitud){
            $.ajax({
                type:'GET',
                url:'public/descargar_xml/'+ id_solicitud,
                data:{

                },
                success:function(response) {

                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                        }, 500);
                        if(response.status==100){
                            var win = window.open(response.response, '_blank');
                            }
                        else{
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
            success: function (response) {
                $("#modal_docs").modal("show");

                var a = 0;
                var count = response.length;
                var contenido = "<table class='table table-hover'><thead><tr style='text-align: center;'>"+
                                "<th>Documento</th><th>Tipo</th><th>Tamaño</th><th>Fecha de carga</th></thead></tr>";
                var archivo = "";
                var version = "";
                var creacion = "";
                var nombre_archivo = "";
                var tamanio = "";
                var documento = "";
        if(count>0){
        while (a <= count - 1) {
            archivo = response[a]['nombre_archivo'].split('.');
            version = response[a]['id_version'];
            creacion = response[a]['fecha_creacion'];
            nombre_archivo = response[a]['nombre_archivo'];
            tamanio = response[a]['tamanio'];
            documento = archivo[1];

            if(documento == 'doc' || documento == 'docx'){
            contenido +=  "<tr style='text-align: center;'><td style='cursor: pointer' title='Ver Documento' onclick='ver_documento(" +
            id_solicitud + "," + version + ");'><i class='fas fa-file-word fa-2x' title='" + nombre_archivo + "'></i></td><td>" +
            documento + "</td><td>" + tamanio + " kB</td><td>" + creacion + "</td></tr>";
            }
            if(documento == 'pdf' ){
            contenido +=  "<tr style='text-align: center;'><td style='cursor: pointer' title='Ver PDF' onclick='ver_documento(" +
            id_solicitud + "," + version + ");'><i class='fas fa-file-pdf fa-2x' title='" + nombre_archivo + "'></i></td><td>" +
            documento + "</td><td>" + tamanio + " kB</td><td>" + creacion + "</td></tr>";
            }
            if(documento == 'jpg' || documento == 'png'){
            contenido +=  "<tr style='text-align: center;'><td style='cursor: pointer' title='Ver IMAGEN' onclick='ver_documento(" +
            id_solicitud + "," + version + ");'><i class='fas fa-file-images fa-2x' title='" + nombre_archivo + "'></i></td><td>" +
            documento + "</td><td>" + tamanio + " kB</td><td>" + creacion + "</td></tr>";
            }

            a++;
        }

        }
        else{
        contenido +=  "<tr style='text-align: center;'><td colspan='4'>No se encontraron documentos</td></tr>";

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
        url: "public/ver_flujo/" + id_solicitud,
        data: {},
        success: function (response) {
            $("#modal_flujo").modal("show");

            a = 0;
            var count = response.response.length;
            var contenido = "<table class='table table-hover'><thead><tr style='text-align: center;'>"+
                            "<th>Estatus</th>"+
                            "<th>Responsable</th>"+
                            "<th>Fecha</th></thead></tr>";
            var nombres = "";
            var usuario = "";
            while (a <= count - 1) {

            if(response.response[a]['nombres'] != null || response.response[a]['apellido_paterno'] != null || response.response[a]['apellido_materno'] != null){
                nombres = response.response[a]['nombres'] + " " +
                        response.response[a]['apellido_paterno'] + " " +
                        response.response[a]['apellido_materno'];

            }else{
                nombres = "desconocido";
            }

            if(response.response[a]['usuario'] != null){
                usuario = response.response[a]['usuario'];
            }
            else{
                usuario = "desconocido";

            }


            contenido += "<tr>"+
                        "<td>" + response.response[a]['estatus_actividad'] + "</td>"+
                        "<td><strong>Nombre: </strong>" + nombres +
                        "<br><strong>Usuario: </strong>" + usuario + "</td>"+
                        "<td>" + response.response[a]['creacion'] + "</td>"+
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

                success: function (response) {

                    $('#modal_loading').modal('hide');
                    $("#modal_log").modal("show");


                    var log = "";
                    log = decodeBase64(response.response['b64'])
                    $("#modal_log_contenido").html("<p>"+log+"</p>");



                },
            });
            }

                decodeBase64 = function(s) {
                var e={},i,b=0,c,x,l=0,a,r='',w=String.fromCharCode,L=s.length;
                var A="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
                for(i=0;i<64;i++){e[A.charAt(i)]=i;}
                for(x=0;x<L;x++){
                c=e[s.charAt(x)];b=(b<<6)+c;l+=6;
                while(l>=8){((a=(b>>>(l-=8))&0xff)||(x<(L-2)))&&(r+=w(a));}
                }
                return r;
                };

        function ver_documento(valor,valor2) {
        var id_solicitud = valor;
        var version = valor2;

            $.ajax({
                type: "GET",
                url: "public/ver_documentos/" + id_solicitud + "/" + version,
                data: {},
                success: function (response) {
                window.open(response[0]['url'], '_blank');
                },
            });
        }

            function cerrar_modal(valor){
            $("#"+valor).modal('hide');
            $('body').removeClass('modal-open');

            }



function ver_remision(id_remision){

    var modo = "completo";

    $.ajax({
            type:'GET',
            url:'/public/obtener_remisiones',
            data:{
                modo:modo,
                id_remision:id_remision,
                pagina:1,
               // registros_por_pagina:$('.pagina_actual_texto').val(),
                 registros_por_pagina:10,


            },
            success:function(response) {


if(response.status==100){

    solicitudes=response.response;
    $.each(response.response, function(index, solicitud){
        console.log(solicitud);



                    const {personas,id_remision}=solicitudes[index];

                //   let listaPersona=[];
                    let listaNorelacionados=[];
                    let  listaSujetos=[];
                    let  acordeones=[];
                let listaArchivos="";

                version="";

                    $.ajax({
            type:'GET',
            url:'public/ver_documentos_remision/'+ id_remision,
                data:{},
                success:function(response) {


                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                        }, 500);



                      //  if(response.status==100){


                            $(response.response).each(function(index, archivo){

                                let tipo= "";
                                let icono= "";

                                const {nombre_archivo,id_documento,extension_archivo} =archivo;
                                console.log(archivo);

                            //tipo de archivo

                            // tipo = nombre_archivo.split('.');
                                 if(extension_archivo=="doc"  || extension_archivo=="docx"    ) {
                                    icono="far fa-file-word";
                                }
                                else if(extension_archivo=="pdf"){
                                    icono="far fa-file-pdf";
                                }
                                else if(extension_archivo=="jpg" || extension_archivo=="png"  ){
                                    icono="far fa-file-image";
                                }else if(extension_archivo=="xls" || extension_archivo=="xlsx"  ){
                                    icono="far fa-file-excel-o";
                                }



                     const li=`<div class="item">
                                            <a href="javascript:void(0)" onclick="descargar_archivo('${id_remision}','${id_documento}');">
                                                <i class="${icono} fa-2x"> </i>
                                                ${nombre_archivo}</a>
                                </div>  `;

                                    listaArchivos= listaArchivos.concat(li);

            });  $('#documentos-relacionados').html(  `<div class="items ">
                                                            ${listaArchivos}
                                                </div> `);



                }
            });



//PERSONAS
        $(personas).each(function(index_p, persona){

//   listaPersona.push(persona.info_principal);

            let tablaDireccion='';
            let tablaAlias='';
            let tablaContacto='';
            let tablaCorreo='';
            let tablaDatos='';
            let tablaDelitos='';

            $(persona.direcciones).each(function(index_d, direccion){

    const {calle,codigo_postal,colonia,entre_calles,estado,municipio,referencias,no_exterior,no_interior}=direccion;


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


                    </tr>`;
            });   tabla_direcciones[index_p] = tablaDireccion;


             //DELITOS PERSONAS
if(persona.delitos.length){
$(persona.delitos).each(function(index_de, delitoo){

const {calificativo,forma_comision,grado_realizacion,delito,nombre_modalidad}  =delitoo;



tablaDelitos = tablaDelitos + `
                                    <tr style='text-align: center;'>
                                        <td>${delito ?? ""}</td>
                                    </tr>`;
});   tabla_delitos[index_p] =   ` <tr align="center"><th colspan="100%" class="th-title">Delito Relacionado </th></tr>
                            `+  tablaDelitos;
}else{

tabla_delitos[index_p] = ` <tr> </tr>`;;
}

             //ALIAS ALIAS ALIAS ALIAS
            $(persona.alias).each(function(index_a, aliases){

                    const {alias} =aliases;
                    tablaAlias= tablaAlias + `${alias} <br>`;

                    }); tabla_alias[index_p] = tablaAlias;



                                //CONTACTO
 $(persona.contacto).each(function(index_c, contact){


                    const {contacto,tipo_contacto} =contact;
                    console.log(contact);

                    if(tipo_contacto== "correo electronico"){

                        tablaCorreo = tablaCorreo + `${contacto} <br>`;
                    }
                    else{
                        tablaContacto = tablaContacto + ` ${tipo_contacto} : ${contacto} <br> `;
                        }
    }); tabla_contacto[index_p] = tablaContacto;
      tabla_correo[index_p] = tablaCorreo;



        });

        //acords
// INFO SOLICITUD PERSONAS
$(personas).each(function(index,sujetosProcesales){

    const {info_principal} =sujetosProcesales;
    console.log(info_principal);

    const tablaSujeto = `<table class="dataTables">
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
            </table> <br> `;



const accordion = `<h4 class="panel-title">
                    <button class="accordion" data-toggle="collapse" href="#collapse${index}">
                        <strong> ${info_principal.nombre ?? ""} ${info_principal.apellido_paterno ?? ""} ${info_principal.apellido_materno ?? ""} ${info_principal.razon_social ?? ""} </strong>

                    </button>
            </h4>

            <div id="collapse${index}" border-style="solid" class="panel-collapse collapse">
                        <div class="panel-body">
                                <tr>
                                ${tablaSujeto}
                                </tr>
                        </div>
            </div>`;


                    listaSujetos=listaSujetos.concat(tablaSujeto);
                    acordeones=acordeones.concat(accordion);



        $('#acordeon').html(acordeones);
    //   $('#datosparticipantes').html(listaSujetos).css({"overflow-x": "none", "display": "table"});

});


$('#datosolicitud').html(` <tr>
                            <td class="td-title">Fecha de Creación</td>
                            <td>${solicitud.creacion ?? "Sin datos"}</td>

                            <td class="td-title">Estatus</td>
                            <td>${solicitud.estatus_actual ?? "Sin datos"}</td>

                    </tr>
                    <tr>
                            <td class="td-title">Folio de carpeta</td>
                            <td>${solicitud.folio ?? "Sin datos"}</td>

                            <td class="td-title">Folio de carpeta remitida</td>
                            <td>${solicitud.folio_carpeta_rem ?? "Sin datos"}</td>

                    </tr>
                    <tr>
                            <td class="td-title">Carpeta Judicial Asignada</td>
                            <td>${solicitud.carpeta_judicial ?? "Sin datos"}</td>

                            <td class="td-title">Tipo de Remision</td>
                            <td>${solicitud.tipo_remision ?? "Sin datos"}</td>

                    </tr>
                    <tr>
                            <td class="td-title">Tipo de Unidad Destino</td>
                            <td>${solicitud.tipo_unidad_destino ?? "Sin datos"}</td>

                            <td class="td-title">Materia Destino</td>
                            <td>${solicitud.materia_destino ?? "Sin datos"}</td>

                    </tr>
                    <tr>
                            <td class="td-title">Motivo de incompetencia</td>
                            <td>${solicitud.motivo_incompetencia ?? "Sin datos"}</td>

                            <td class="td-title">Comentarios</td>
                            <td>${solicitud.comentarios ?? "Sin datos"}</td>

                    </tr>
                    `);

$('#modal-ver').modal('show');


                                });


}else{
    alert("Error , Comuniquese con Soporte");

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
      $('#estatus_color').val('');



    } */

    function descargar_archivo(id_remision,id_documento){

                $.ajax({
                type:'GET',
                url:'public/abrir_documento_remision/'+ id_remision +'/'+ id_documento,
                    data:{
                    },
                    success:function(response) {
                        console.log(response);

                        var win = window.open(response.response, '_blank');

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

</script>
@endsection



@section('seccion-modales')

    {{-- VER SOLICITUD --}}
    <div id="modal-ver" class="modal fade" data-keyboard="false">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">


                 <div class="modal-body">


                            <button type="button" class="close ml-auto"  data-dismiss="modal" aria-label="Close">
                                <span  aling="right" aria-hidden="true">&times;</span>
                            </button>


                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos de la Solicitud</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Personas</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Documentos Relacionados</a>
                                </div>
                            </nav>
                            <br>

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <table id="datosolicitud" class="dataTables"> </table>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                              <div class="accordion" id="acordeon" role="tablist"> </div>
                               </div>

                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="container" id="documentos-relacionados" > </div>
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
                  <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
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
                  <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
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
                  <i class="icon ion-ios-checkmark-circle-outline tx-100 color='#848F33' lh-1 mg-t-20 d-inline-block"></i>
                  <h4 class=" tx-semibold style='color:green' mg-b-20" style='color:green'>Proceso Concluido!</h4>

                  <p id="carpetaAsignada" color='green'  class="mg-b-20 mg-x-20">Carpeta Judicial Asignada</p>

                  <button type="button" class="btn btn-sucess pd-x-25" data-dismiss="modal" aria-label="Close" >Cerrar</button>
                </div><!-- modal-body -->
              </div><!-- modal-content -->
            </div><!-- modal-dialog -->
          </div><!-- modal -->


@endsection
