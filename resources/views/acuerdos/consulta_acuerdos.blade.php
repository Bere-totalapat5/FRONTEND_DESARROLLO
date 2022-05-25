@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Acuerdos</a></li>
    <li class="breadcrumb-item"><a href="#"> Consulta de acuerdos</a></li>
 </ol>
 <h6 class="slim-pagetitle"> Consulta de acuerdos </h6>
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

 <div class="section-wrapper" style="max-width: 100%;">
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



                             <div class="col-lg-3" >
                                <label class="form-control-label">Unidad de Gestion:</label>
                                <div class="form-group" >
                                    <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" name="idunidad" id="idUnidad">

                                    </select>
                                </div>
                                </div>



                                  <div class="col-lg-3">
                                    <div class="form-group mg-b-10-force">
                                      <label class="form-control-label">Folio de Carpeta:</label>
                                      <input class="form-control" type="text" name="folio_carpeta" id="folioCarpeta" autocomplete="off">
                                    </div>
                                  </div>

                                  <div class="col-lg-3">
                                    <div class="form-group mg-b-10-force">
                                      <label class="form-control-label">Id de Acuerdo:</label>
                                      <input class="form-control" type="text" name="folio_carpeta" id="idAcuerdo" autocomplete="off">
                                    </div>
                                  </div>

                                  <div class="col-lg-3">
                                    <div class="form-group mg-b-10-force">
                                      <label class="form-control-label">Id de Carpeta Judicial:</label>
                                      <input class="form-control" type="text" name="folio_carpeta" id="idCarpetaJudicial" autocomplete="off">
                                    </div>
                                  </div>


                                  <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Fecha de creacion (Desde): </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" id="fechainicreacion" name="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="label">Fecha de creacion (Hasta): </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" id="fechafincreacion" name="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>



                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="label">Fecha de firmado (Desde): </label>
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
                                            <label class="label">Fecha de firmado (Hasta): </label>
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
                                    <label class="form-control-label">Estatus:</label>
                                    <div class="form-group" >
                                        <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" name="estatus_firmado" id="estatusFirmado">
                                         <option selected disabled value="">Elija una opción</option>
                                            <option value=""> TODAS </option>
                                            <option value="proceso"> EN PROCESO DE FIRMA </option>
                                            <option value="firmado"> FIRMADO </option>
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



                        <div class="row justify-content-end">
                            <input type="hidden" id="filtro_consulta" name="filtro_consulta" value="">

                            <div class="col-sm-2 pd-t-10" aling="right">
                                <a href="javascript:void(0);" onclick="descargar_consulta('xls');" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar Excel</a>
                            </div>

                            <div class="col-sm-2 pd-t-10" aling="right">
                                <a href="javascript:void(0);" onclick="descargar_consulta('pdf');" class="btn btn-primary btn-sm btn-block "><i class="fa fa-pdf mg-r-5"></i>Exportar PDF</a>
                            </div>

                        </div>


                        <br>

                        <!-- pagination-wrapper -->
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




 <!--TABLA RESULTADOS BUSQUEDA -->
                <div id="table-acuerdos" class="mg-b-20">
                    <table id="acuerdosTable" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                        <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                            <tr>
                                <th style="" class="acciones" name="acciones">Acciones</th>
                                <th style="cursor:pointer" class="folio_carpeta" name="folio_carpeta">Folio de Carpeta</th>
                                <th style="cursor:pointer" class="id_acuerdo" name="id_acuerdo">Id- Acuerdo</th>
                                <th style="cursor:pointer" class="id_carpeta_judicial" name="id_carpeta_judicial">Id Carpeta Judicial</th>
                                <th style="cursor:pointer" class="nombre_juez" name="nombre_juez">Nombre del Juez</th>
                                <th style="cursor:pointer" class="estatus_firma" name="estatus_firma">Estatus de firma</th>
                                <th style="cursor:pointer" class="fecha_firma" name="fecha_firma">Fecha de firma</th>
                            </tr>
                        </thead>
                        <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">

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
@endsection



@section('seccion-estilos')
    <link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
{{--     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.5.3/css/colReorder.dataTables.min.css"/>
 --}}
        <style>
            @media screen and (max-width: 600px) {

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
             .acciones {
                min-width: 150px !important;
            }
            .unidad {
                min-width: 150px !important;
            }

            .tipo_documento {
                min-width: 200px !important;
            }

            .folio_carpeta {
                min-width: 220px !important;
            }

            .id_acuerdo {
                min-width: 220px !important;
            }
            .id_carpeta_judicial {
                min-width: 220px !important;
            }
            .nombre_juez {
                min-width: 230px !important;
            }
            .estatus_firma {
                min-width: 220px !important;
            }
            .fecha_firma {
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



</style>
@endsection

@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>

@endsection


@section('seccion-scripts-functions')

<script>
    var filtro = null; // variable que almacena el filtro de busqueda para la exportacion a XSL o PDF


    $(function(){

        'use strict';


        $.ajax({
            type:'POST',
            url:'/public/obtener_unidades',
            data:{

                    },

            success:function(response){

                console.log(response);

            if(response.status==100){


                let unidades='';
                $(response.response).each((index, unidad)=>{
                const {id_unidad_gestion, nombre_unidad,clave_unidad}=unidad;
                const option=`<option value="${id_unidad_gestion}"> ${nombre_unidad} </option>`;
                unidades=unidades.concat(option);
                });
                $('#idUnidad').html(`<option selected disabled value="">Elija una opción</option>
                <option value=""> TODAS LAS UNIDADES </option>` + unidades);

            }
            }
        });


             //obtener un
        $('#idUnidad').change(function(){
        $.ajax({
            type:'POST',
            url:'/public/obtener_usuarios',
            data:{
            id_unidad_gestion:$('#idUnidad').val(),
            },
            success:function(response){

            if(response.status==100){

                let usuarios='';
                $(response.response).each((index, usuarioo)=>{
                const {usuario,id_usuario, nombres,apellido_paterno,apellido_materno,cve_juez}=usuarioo;
                const option=`<option value="${id_usuario}" > (${usuario}) ${nombres} ${apellido_paterno} ${apellido_materno}</option>`;
                usuarios=usuarios.concat(option);
                });
                $('#selectusuario').html(`<option selected disabled value="">Elija una opción</option>
                <option value=""> TODOS </option>`+ usuarios);
            }
            }
        });
        });





             //enter key press
         $('#idUnidad').keypress(function (e) {
                if (e.which == 13) {
                    sec_ajax('primera');   //<---- Add this line
                }
                });

        $('#juez').keypress(function (e) {
                if (e.which == 13) {
                    sec_ajax('primera');   //<---- Add this line
                }
                });

        $('#fechaini').keypress(function (e) {
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



        //busqueda
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


                    //cambio formato de fecha
                const format1 = "YYYY-DD-MM"

                    var date1 = new Date($("#fechaini").val());
                    fechaini = moment(date1).format(format1);
                    if (fechaini === "Invalid date") {
                        fechaini= '';}



                    var date2 = new Date($("#fechafin").val());
                    fechafin = moment(date2).format(format1);
                    if (fechafin === "Invalid date") {
                                fechafin= '';}


                    var date3 = new Date($("#fechainicreacion").val());
                    fechainicreacion = moment(date3).format(format1);
                    if (fechainicreacion === "Invalid date") {
                        fechainicreacion= '';}



                    var date4 = new Date($("#fechafincreacion").val());
                    fechafincreacion = moment(date4).format(format1);
                    if (fechafincreacion === "Invalid date") {
                        fechafincreacion= '';}






            // se almacena parametros de busqueda en filtro
            filtro = {
                id_unidad:$("#idUnidad").val(),
                tipo_documento:$("#tipoDocumento").val(),
                folio_carpeta:$("#folioCarpeta").val(),
                id_acuerdo:$("#idAcuerdo").val(),
                id_carpeta_judicial:$("#idCarpetaJudicial").val(),
                pagina:1,
                registros_por_pagina:1000000,
            };

            $.ajax({
                type:'GET',
                url:'/public/obtener_acuerdos',
                data:{
                    id_unidad:$("#idUnidad").val(),
                    tipo_documento:$("#tipoDocumento").val(),
                    folio_carpeta:$("#folioCarpeta").val(),
                    id_acuerdo:$("#idAcuerdo").val(),
                    id_carpeta_judicial:$("#idCarpetaJudicial").val(),
                    pagina:$('#numeropagina').val(),
                    fecha_recepcion: fechaini,
                    fecha_recepcionh: fechafin,
                    fecha_creacion: fechainicreacion,
                    fecha_creacionh: fechafincreacion,
                    estatus_firma:$("#estatusFirmado").val(),
                    //registros_por_pagina:$('.pagina_actual_texto').val(),
                    registros_por_pagina:10,

                },
                    success:function(response) {
                        console.log(response);

                    if(response.status==100){

                        var datos=response.response;


                        body = new $('#acuerdosTable').dataTable( {
                           // responsive: true,
                                    processing: true,
                                    data: datos,
                                    columns: [
                                        {
                                    data: "id_acuerdo",
                                    render: function (data, type, row, meta) {
                                        return (
                            '<i class="icon ion-ios-download-outline"  title="Descargar PDF" style="cursor: pointer" onclick="descargar_pdf(' +
                            data +')" id="pdf"></i> ' +
                            '<i class="icon ion-android-map" title="Consulta Flujo" style="cursor: pointer" onclick="ver_flujo('+data+')" id="flujo"></i> '
                                        );
                                    },
                                },
                                        { data: "folio_carpeta",title:"Folio de Carpeta"},
                                        { data: "id_acuerdo" ,title:"ID Acuerdo"},
                                        { data: "id_carpeta_judicial" ,title:"ID Carpeta Judicial"},
                                        { data: "nombre_juez" ,title:"Nombre del Juez"},
                                        { data: "estatus_firma" ,title:"Estatus de firma"},
                                        { data: "fecha_firma" ,title:"Fecha de firmado"},
                                    ],
                                    colReorder: {
                            fixedColumnsLeft: 1,
                                                 },
                                    bDestroy: true,
                                    colReset:true,
                                    paging:   false,
                                    ordering: true,
                                    info:     false,
                                    search:false,
                                    filter:false,
                                    stateSave: true,
                                  //  responsive: true
                                //  stateClear: false,
                                //  stateLoaded: true,
                                } );
                                    $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                                    $('#paginas_totales').val(response.response_pag['paginas_totales'])

                    }else {
                       body = "<tr><td colspan='12'><h3>Sin datos relacionados</h3></td><tr>";
                        $("#body-table1").html(body);


                        }
                    }
                });

            }
    }

    function descargar_pdf(id_acuerdo){

        var idAcuerdo=id_acuerdo;
        var idUnidad="";

        $.ajax({

            type:'GET',
            url:'/public/obtener_acuerdos',
            data:{
                id_acuerdo:idAcuerdo
            },
                            success:function(response) {

                                    if(response.status==100){
                                        idUnidad=response.response[0].id_unidad;


                                        $.ajax({
                            type:'GET',
                            url:'public/descargar_pdf_acuerdo/'+ id_acuerdo+'/'+idUnidad,
                            data:{

                            },
                            success:function(response) {
                                setTimeout(function(){
                                    $('#modal_loading').modal('hide');
                                    }, 500);

                                    if(response.status==100){
                                        $('#documentoPDFrame').attr('src',response.response);
                            mostrarModalDocumento();
                                        }
                                    else{
                                            $('#modalFail').modal('show');
                                    }
                            }
                            });

                                        }
                            }

                            });

    /*     console.log(idAcuerdo);
    console.log(versionAcuerdo); */
    }

    function mostrarModalDocumento(){

        $('#modalAdjuntarDocumento').modal('show');
        }


        function descargar_consulta(extension){

            let orden_columnas = get_orden_columnas();

            $('#modal_loading').modal('show');
            $.ajax({
                type:'GET',
                url:'/exportar_busqueda_acuerdos',
                data:{
                    id_unidad:filtro.id_unidad,
                    tipo_documento:filtro.tipo_documento,
                    folio_carpeta:filtro.folio_carpeta,
                    id_acuerdo:filtro.id_acuerdo,
                    id_carpeta_judicial:filtro.id_carpeta_judicial,
                    pagina:filtro.pagina,
                    registros_por_pagina:filtro.registros_por_pagina,
                    extension : extension,
                    orden_columnas:orden_columnas,
                },
                success:function(data){
                    if(data.status==100){
                        let tag_a = $("<a>");
                        tag_a.attr("href",data.file);
                        $("body").append(tag_a);
                        tag_a.attr("download",data.filename);
                        tag_a[0].click();
                        tag_a.remove();
                    }else{
                        alert(data.message);
                    }

                    setTimeout(function(){  $('#modal_loading').modal('hide');  }, 500);
                }
            });
        }

    function get_orden_columnas(){
        let campos_title = [
            { campo: "folio_carpeta" ,titulo:"Folio de Carpeta"},
            { campo: "id_acuerdo" ,titulo:"ID Acuerdo"},
            { campo: "id_carpeta_judicial" ,titulo:"ID Carpeta Judicial"},
            { campo: "nombre_juez" ,titulo:"Nombre del Juez"},
            { campo: "estatus_firma" ,titulo:"Estatus de firma"},
            { campo: "fecha_firma" ,titulo:"Fecha de firma"},
        ];
        let columnas = [];
        $('#acuerdosTable thead tr th').each(function() {
            let columna =  campos_title.filter( index => index.titulo == ( $(this).attr('name')=='semaforo'? 'Semaforo' : $(this).text() ) );
            if( columna.length ){
                columnas.push({ titulo:  columna[0].titulo, campo: columna[0].campo });
            }
        });
        return columnas;
    }


    function ver_flujo(valor) {
        var id_acuerdo = valor;
        $.ajax({
        type: "GET",
        url: "public/ver_flujo_acuerdo/" + id_acuerdo,
        data: {},
        success: function (response) {
            $("#modal_flujo").modal("show");

            a = 0;
            var count = response.response.length;
            var contenido = "<table class='table table-hover'><thead><tr style='text-align: center;'>"+
                            "<th>Estatus</th>"+
                            "<th>Responsable</th>"+
                            "<th>Descripción</th>"+
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

                        "<td>" + response.response[a]['flujo_estatus'] + "</td>"+

                        "<td><strong>Nombre: </strong>" + nombres +
                        "<br><strong>Descripcion: </strong>" + usuario + "</td>"+

                        "<td>" + response.response[a]['flujo_comentarios'] + "</td>"+

                        "<td>" + response.response[a]['creacion'] + "</td>"+



                        "</tr>";
            a++;
            }
            contenido += "</table>";


            $("#modal_flujo_contenido").html(contenido);
        },
        });
    }

    function cerrar_modal(valor){
        $("#"+valor).modal('hide');
        $('body').removeClass('modal-open');

    }

    /*     function limpiarCampos(){

      $('#idunidad').val('');//text
      $('#juez').val('');
      $('#tipocarga').val('');
      $('#foliocarpeta').val('');

      $('#fechaini').val('');
      $('#fechafin').val('');   } */


</script>
@endsection



@section('seccion-modales')

<!-- Modal flujo -->
<div class="modal fade" id="modal_flujo" role="dialog">
    <div class="modal-dialog" style="width:550px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Flujo del Acuerdo</h5>
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


  <div id="modalAdjuntarDocumento" class="modal fade">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Documento del acuerdo</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
       {{--    <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data">
            <div class="custom-input-file">
              <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" onchange="leeDocumento('archivoPDF');">
              <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
              </div>
          </form> --}}

            <iframe src="" id="documentoPDFrame"></iframe>


        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary d-inline-block mg-l-auto"  style="margin-left: auto;" data-dismiss="modal">Cerrar</button>
{{--                   <button type="button" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="enviarPromocion()">Enviar Solicitud</button>
--}}                </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection
