@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
 <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="#">ADIP</a></li>
    <li class="breadcrumb-item"><a href="#"> Consulta de reportes ADIP</a></li>
 </ol>
 <h6 class="slim-pagetitle">Consulta de reportes ADIP </h6>
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

            {{--  Busqueda Avanzada  --}}
            <div id="accordion" class="accordion-one mg-b-15" role="tablist" aria-multiselectable="true">
              <div class="card">
                  {{--  header del card  --}}
                  <div class="card-header" role="tab" id="headingOne">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance" aria-expanded="false" aria-controls="collapseSearchAdvance" class="tx-gray-800 transition collapsed">
                          <i class="fa fa-search" aria-hidden="true"></i> 
                      </a>
                  </div>
                  {{--  body del card  --}}
                  <div id="collapseSearchAdvance" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                          {{--  Formulario de la busqueda avanzada --}}
                          <div class="row mg-b-25">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha de Inicial : </label>
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
                                        <label class="label">Fecha Final : </label>
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


                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Tipo Reporte:</label>
                                    <select name="tipo_reporte" id="tipo_reporte" class="form-control ">
                                        <option value="-">Seleccione un tipo de reporte</option>
                                        <option value="adip">ADIP</option>
                                        <option value="estadistico">ESTADISTICA</option>
                                        <option value="audiencias_p">AUDIENCIAS</option>
                                        <option value="delitos">DELITOS</option>
                                        <option value="cln">CARPETAS LN</option>
                                    </select>
                                </div>
                            </div>

                          </div>
                          {{--  Boton para filtrar  --}}
                          <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="sec_ajax('primera');">Filtrar</button>
                            </div>
                          </div>

                        </div>
                  </div>
                </div>
            </div>

            

          </div>

            

            {{--  Botones de De exportacion  --}}
            {{--  
            <div class="row justify-content-between my-2 ">
                <div class="col-sm-3 col-md-4 col-lg-2 pd-t-10" id="merge_adip" align="left">
                    <a href="javascript:void(0);" onclick="fusionar_reporte()" class="btn btn-primary btn-sm btn-block "><i class="far fa-object-ungroup  mg-r-5"></i>Fusionar</a>
                </div>
            </div>  --}}

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
                <table id="adipTable" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                    <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                        <tr>
                            <th style="" class="acciones" name="acciones">Acciones</th>
                            {{--  <th style="cursor:pointer" class="bandera_creacion" name="bandera_creacion">Correcto</th>  --}}
                            <th style="cursor:pointer" class="bandera_reporte" name="bandera_reporte">Tipo</th>
                            <th style="cursor:pointer" class="registros_procesados" name="registros_procesados">Total de registros procesados</th>
                            <th style="cursor:pointer" class="fecha_final" name="fecha_final">Fechas</th>
                            {{--  <th style="cursor:pointer" class="fecha_inicio" name="fecha_inicio">Fecha final</th>  --}}
                            <th style="cursor:pointer" class="creacion" name="creacion">Fecha de Creacion</th>
                            <th style="cursor:pointer" class="creacion" name="creacion">Tipo Creacion</th>
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


            <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;"></div>

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
                min-width: 170px !important;
            }
            .bandera_creacion {
                min-width: 185px !important;
            }
            .bandera_reporte {
                min-width: 200px !important;
            }
            .tipo{
                padding: 4px;
                border-radius: 5px;
                color: #444;
                font-size: 0.8em;
                position: relative;
            }
            .audiencias_r{
                border: 2px solid #ddc23f;
                margin: 0 8%;
            }
            .adip_r{
                border: 2px solid #848F33;
                margin: 0 8%;
            }
            .delitos_r{
                border: 2px solid #d8deae;
                margin: 0 8%;
            }
            .estadistica_r{
                border: 2px solid #8ebd99;
                margin: 0 8%;
            }
            .cln_r{
                border: 2px solid #427a4f;
                margin: 0 8%;
            }
            .lb_r{
                border: 2px solid #939693;
                margin: 0 8%;
            }
            .registros_procesados {
                min-width: 280px !important;
            }

            .disponible{
                background: #28B463;
                width: 7px;
                height: 7px;
                border-radius: 50%;
                margin: 2% 24%;
                position: absolute;
                top: 0;
                right: -23px;
            }
            .ocupado{
                background: #F1C40F;
                width: 7px;
                height: 7px;
                border-radius: 50%;
                margin: 2% 24%;
                position: absolute;
                top: 0;
                right: -23px;
            }

            .fecha_final {
                min-width: 290px !important;
            }
            .fecha_inicio {
                min-width: 280px !important;
            }
            .creacion {
                min-width: 280px !important;
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

            #documentoPDFrame , #vista_Excel_Modal{
                min-height: 100%;
                min-width: 100%;
            }

            .table-responsive::-webkit-scrollbar {
                width: 8px;
                height: 8px;     
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 4px;
            }

            .table-responsive::-webkit-scrollbar-thumb:hover {
                background: #b3b3b3;
                box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
            }

            .table-responsive::-webkit-scrollbar-thumb:active {
                background-color: #999999;
            }

            .table-responsive::-webkit-scrollbar-track {
                background: #e1e1e1;
                border-radius: 4px;
            }
        
            .table-responsive::-webkit-scrollbar-track:hover,
            .table-responsive::-webkit-scrollbar-track:active {
              background: #d4d4d4;
            }    

                                 
            #table_vista_Excel_Modal{
                table-layout: fixed;
                margin: 3% auto;
            }

            #adipTable tbody tr td{
                display: table-cell;
                vertical-align: middle;
            }

            #encabezado_personalizado th{
                font-size: 0.8em;
                padding: 0.2rem 0.2rem !important;
                overflow: auto;
                border: 1px solid #ccc;
                background: #eee;
                display: table-cell;
                vertical-align: middle;
                text-align: center;
            } 
            #encabezado_personalizado.dataTable tbody td{
                word-break: keep-all;;
            }
            #table_vista_Excel_Modal tbody td{
                font-size: 0.7em;
                border:1px solid #eee;
            }
            #tatable_vista_Excel_Modalble.dataTable.dataTable_width_auto {
                width: auto;
            }
            .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.current:focus {
                background-color: #848F33 !important;
            }
            #encabezado_personalizado th:nth-child(1){width: 40px  !important;}
            #encabezado_personalizado th:nth-child(2){width: 170px !important;}
            #encabezado_personalizado th:nth-child(3){width: 140px !important;}
            #encabezado_personalizado th:nth-child(4){width: 140px !important;}
            #encabezado_personalizado th:nth-child(5){width: 130px !important;}
            #encabezado_personalizado th:nth-child(6){width: 146px !important;}
            #encabezado_personalizado th:nth-child(7){width: 145px !important;}
            #encabezado_personalizado th:nth-child(8){width: 300px  !important;}
            #encabezado_personalizado th:nth-child(9){width: 80px  !important;}
            #encabezado_personalizado th:nth-child(10){width: 80px !important;}
            #encabezado_personalizado th:nth-child(11){width: 100px !important;}
            #encabezado_personalizado th:nth-child(12){width: 170px !important;}
            #encabezado_personalizado th:nth-child(13){width: 180px !important;}
            #encabezado_personalizado th:nth-child(14){width: 205px !important;}
            #encabezado_personalizado th:nth-child(15){width: 130px !important;}
            #encabezado_personalizado th:nth-child(16){width: 125px !important;}
            #encabezado_personalizado th:nth-child(17){width: 170px !important;}
            #encabezado_personalizado th:nth-child(18){width: 170px !important;}
            #encabezado_personalizado th:nth-child(19){width: 130px !important;}
            #encabezado_personalizado th:nth-child(20){width: 120px !important;}
            #encabezado_personalizado th:nth-child(21){width: 105px !important;}
            #encabezado_personalizado th:nth-child(22){width: 140px !important;}
            #encabezado_personalizado th:nth-child(23){width: 195px !important;}
            #encabezado_personalizado th:nth-child(24){width: 135px !important;}
            #encabezado_personalizado th:nth-child(25){width: 135px !important;}
            
            #encabezado_personalizado th,#table_vista_Excel_Modal tbody td th{
                max-width: 300px !important;
            }

            #sarchItem{
                border: 1px solid #eee;
                border-radius: 0 0 10% 10%;
                padding: 4px;
                text-align: center;
                width: 30%;
                outline: none;
            }
            #sarchItem:active{
                outline: none;
            }
            #table_vista_Excel_Modal_filter{
                display: none;
            }   
            #table_vista_Excel_Modal_length{
                display: none;
            }
            #table_vista_Excel_Modal_paginate{
                position: fixed;
                bottom: 2%;
                left: 40%;
            }
            @media (max-width:900px){
                #table_vista_Excel_Modal_paginate{
                    left: 26%;
                }
            }
            @media (max-width:700px){
                #table_vista_Excel_Modal_paginate{
                    left: 2%;
                }
            }
            @media (max-width:500px){
                #sarchItem{
                    width: 90%;
                }
                #table_vista_Excel_Modal_paginate{
                    left: 22%;
                    bottom: 10%;
                }
                #modal-footer{
                    padding-top: 18%;
                    justify-content: center;
                }
            }

            .CI_auto, .CJ_auto, .nombre_auto, .apellidoPaterno_auto, .apellidoMaterno_auto, 
            .fechaNacimiento_auto, .domicilio_auto, .genero_auto, .edad_auto, 
            .ingreso_auto, .estatus_imputado_auto, .estatus_reincidencia_auto, .fecha_vinculacion_proceso_auto,
            .fecha_sentencia_auto, .fecha_apelacion_auto, .estatus_multa_posterior_apelacion_auto, 
            .pena_pecunaria_posterior_apelacion_auto, .fecha_amparo_auto, .fecha_sobreseimiento_auto,
            .tipo_juicio_auto, .tiempo_sentencia_auto, .estatus_multa_posterior_sentencia_auto,
            .pena_pecunaria_sentencia_auto, .estatus_carpeta_auto
            {
                width: 100%;
                padding: 8px;
                text-align: center;
                border: none;
                background: #efefef;
                border-radius: 3px;
            }
		    .ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all{
		    	z-index: 1050 !important;
		    }
            .CI_auto:focus, .CJ_auto:focus, .nombre_auto:focus, .apellidoPaterno_auto:focus, .apellidoMaterno_auto:focus, 
            .fechaNacimiento_auto:focus, .domicilio_auto:focus, .genero_auto:focus, .edad_auto:focus, 
            .ingreso_auto:focus, .estatus_imputado_auto:focus, .estatus_reincidencia_auto:focus, .fecha_vinculacion_proceso_auto:focus,
            .fecha_sentencia_auto:focus, .fecha_apelacion_auto:focus, .estatus_multa_posterior_apelacion_auto:focus, 
            .pena_pecunaria_posterior_apelacion_auto:focus, .fecha_amparo_auto:focus, .fecha_sobreseimiento_auto:focus,
            .tipo_juicio_auto:focus, .tiempo_sentencia_auto:focus, .estatus_multa_posterior_sentencia_auto:focus,
            .pena_pecunaria_sentencia_auto:focus, .estatus_carpeta_auto:focus{
                outline-color: #848F33;
            }
            .nombre_auto, .apellidoPaterno_auto, .apellidoMaterno_auto{
                text-transform: uppercase;
            }
            .check_adip{
                margin-left: 20px;
                margin-top: 5px;
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
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endsection


@section('seccion-scripts-functions')

<script>
    var filtro = null; // variable que almacena el filtro de busqueda para la exportacion a XSL o PDF

        
    //desactivar la recarga
    var preventF5 = (event) => {
        event.preventDefault();
        // Chrome 
        event.returnValue = '';
    };

    $(function(){

        'use strict';

        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 1000);

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
                    $('#idUnidad').html(`<option selected disabled value="">Elija una opción</option><option value=""> TODAS LAS UNIDADES </option>` + unidades);
                }
            }
        });
        
        $(".cerrar-modal").click(function(){
            let modalOpen = $(this).attr('data-modal');
            let modalClose = $(this).attr('data-thismodal');
            //console.log(modalOpen,modalClose);
            $("#"+modalClose).modal('hide');
            if( modalOpen.length ) setTimeout(function(){ $("#"+modalOpen).modal('show'); }, 500); 
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

        // Select2
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });

        sec_ajax();

        setInterval(revisar_estado_online, 1000);

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

        if(pagina<=0 || pagina>$('#paginas_totales').val()){}
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


            var date3 = new Date($("#fechaini").val());
            fechainicreacion = moment(date3).format(format1);
            if (fechainicreacion === "Invalid date") {
                fechainicreacion= '';}



            var date4 = new Date($("#fechafin").val());
            fechafincreacion = moment(date4).format(format1);
            if (fechafincreacion === "Invalid date") {
                fechafincreacion= '';}


            var bandera_reporte = $("#tipo_reporte").val()
            

            $.ajax({
                type:'GET',
                url:'/public/obtener_reportes_adip',
                data:{
                    fecha_inicio: fechainicreacion,
                    fecha_final: fechafincreacion,
                    bandera_reporte: bandera_reporte
                },
                    success:function(response) {
                        console.log(response);

                    if(response.status==100){


                        var datos=response.response;
                        let color;
                        let title;
                        var id_r = [];

                        for(i = 0; i < datos.length; i++){
                            if(datos[i].bandera_reporte == 'adip'){
                                id_r.push({
                                    id_reporte : datos[i].id_reporte,
                                    disponibilidad : datos[i].disponibilidad
                                });
                            }
                        }
                        localStorage.setItem('id_reportes',JSON.stringify(id_r));

                        body = new $('#adipTable').dataTable( {
                           // responsive: true,
                                    processing: true,
                                    data: datos,
                                    responsive: false,
                                    columns: [
                                        {
                                            data: "id_reporte",
                                            render: function (data, type, row, meta) {
                                                if(row.bandera_reporte == 'adip'){

                                                    if(row.disponibilidad == 1){
                                                        boton = '<i class="icon fas fa-file-excel" title="Editar Excel" style="cursor: pointer;padding: 5px 6px;font-size: 0.8em; " id="b_'+data+'" onclick="vista_Excel_Modal('+data+')"></i>';
                                                        input = '<input type="checkbox" id="c_'+data+'" class="check_adip" />'; 
                                                    }else{
                                                        boton = '<i class="icon fas fa-file-excel" title="Editar Excel" style="cursor: pointer;padding: 5px 6px;font-size: 0.8em; background: #F1C40F !important;" id="b_'+data+'" onclick="alertaOcupado('+data+')"></i>';
                                                    }
                                                    return (
                                                        '<i class="icon ion-ios-download-outline"  title="Descargar Excel" style="cursor: pointer" onclick="descargar_excel(' +data +')" id="pdf"></i> ' +
                                                        '<i class="icon ion-code-download" title="Descargar XML" style="cursor: pointer" onclick="descargar_xml('+data+')" id="descarga_xml"></i> ' +
                                                        boton 
                                                        
                                                    );
                                                }else{
                                                    return (
                                                        '<i class="icon ion-ios-download-outline"  title="Descargar Excel" style="cursor: pointer" onclick="descargar_excel(' +data +')" id="pdf"></i> ' +
                                                        '<i class="icon ion-code-download" title="Descargar XML" style="cursor: pointer" onclick="descargar_xml('+data+')" id="descarga_xml"></i> ' 
                                                    ); 
                                                }


                                            },
                                        },
                                        {
                                            data: 'bandera_reporte',
                                            render : function (data, type, row, meta){
                                                if(data == "adip"){
   
                                                    title = "ADIP";
                                                    clase = 'adip_r';
                                                    id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';
                                                    if(row.disponibilidad  == 1){
                                                        titulo = "Disponible"
                                                        classe = "disponible"
                                                        status = '<div class="'+classe+'" title="'+titulo+'" id="d_'+row.id_reporte+'"></div>';
                                                    }else{
                                                        titulo = "Ocupado"
                                                        classe = "ocupado"
                                                        status = '<div class="'+classe+'" title="'+titulo+'" id="d_'+row.id_reporte+'"></div>';
                                                    }
                                                    return '<div class="tipo '+clase+'">'+title+ status + id_r+' </div>';
                                                }else if(data == 'estadistico'){
                                                    title = "ESTADISTICA";
                                                    clase = 'estadistica_r';
                                                    id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                    return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                }else if(data == 'audiencias_p'){
                                                    title = "AUDIENCIAS";
                                                    clase = 'audiencias_r';
                                                    id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                    return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                }else if(data =='delitos'){
                                                    title = "DELITOS";
                                                    clase = 'delitos_r';
                                                    id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                    return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                }
                                                else if(data =='cln'){
                                                    title = "CLN";
                                                    clase = 'cln_r';
                                                    id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                    return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                }else if(data =='libertades'){
                                                    title = "LIBERTADES";
                                                    clase = 'lb_r';
                                                    id_r = '<div style="color:#b3b3b3; font-size:0.8em;">'+row.id_reporte+'</div>';

                                                    return '<div class="tipo '+clase+'">'+title+id_r+'</div>';
                                                }
                                                
                                            }
                                        },
                                        { data: "total_registros_procesados" ,title:"Total de Registros Procesados"},
                                        { data: "fecha_inicio" ,
                                            render : function (data, type, row, meta){
                                                return(
                                                    '<div style="display: flex;justify-content: center;flex-direction: column; align-items: center;">'+
                                                        '<label style="border-left: 4px solid #848F33; width:83%">Fecha Inicio: '+data+'</label>'+
                                                        '<label style="border-left: 4px solid #848F33; width:83%">Fecha Final: '+row.fecha_final+'</label>'+
                                                    '</div>'
                                                );
                                            },
                                        },
                                        { data: "creacion" ,title:"Fecha de Creacion"},
                                        {
                                          data: "creacion_bandera",
                                          render: function (data, type, row, meta){
                                              if(data == 'cron'){
                                                return('<div style="width:100%; display:flex; flex-direction:column; align-items:center; text-align:center;"><i class="fas fa-clock" style="font-size: 1.3em; color: #86a54a;"></i> CRON</div>');
                                              }else{
                                                return('<div style="width:100%; display:flex; flex-direction:column; align-items:center; text-align:center;"><i class="fas fa-object-group" style="font-size: 1.3em; color: #eaae58;"></i> INTERFAZ</div>');
                                              }
                                          }
                                        }
                                    ],
                                    colReorder: {
                                        fixedColumnsLeft: 2,
                                    },
                                    columnDefs: [
                                        { orderable: false, targets: 0 }
                                    ],
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
                    /*  $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                        $('#paginas_totales').val(response.response_pag['paginas_totales'])
                    */
                    }else {
                       body = "<tr><td colspan='12'><h3>Sin datos relacionados</h3></td><tr>";
                        $("#body-table1").html(body);

                        }
                    }
                });

            }
    }
    /*
    { data: "bandera_creacion_correcta",
                                        
        render: function (data, type, row, meta) {
            if (data == "1") {
                color = "green";
                title = "Generado Correctamente";
            } else if (data == "0") {
                color = "red";
                title = "NO generado";
            }
            return '<i class="fas fa-lightbulb-o fa-lg" style="color:' + color + '" title="' + title + '" text-align="right" aria-hidden="true"></i>';
        },
    },
    */
    function descargar_excel(id_reporte){

        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 1000);

        var idReporte=id_reporte;
        var tipo="xlsx";

        $.ajax({

            type:'GET',
            url:'/public/obtener_reportes_excel/'+ idReporte +"/"+ tipo ,
            data:{},
                            success:function(response) {
                             if(response.status==100){

                              var win = window.open(response.response, '_blank');

                                        }
                            }

       });
    }

    function Download(url) {
        document.getElementById('my_iframe').src = url;
    }

    function descargar_xml(id_reporte){

        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 1000);

        var idReporte=id_reporte;
        var tipo="xml";

        $.ajax({

            type:'GET',
            url:'/public/obtener_reportes_xml/'+ idReporte +"/"+ tipo ,
            data:{},
            success:function(response) {

                if(response.status==100){
                    console.log(response.response);
                    window.open(response.response, 'Reporte XML', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=600,height=600,left = 390,top = 50');
                    //window.open(response.response);
                }
            }

        });
        
                    /*     console.log(idAcuerdo);
                    console.log(versionAcuerdo); */
    }

    function mostrarModalDocumento(){
        $('#modalAdjuntarDocumento').modal('show');
    }

    function cerrar_modal(valor){
        if(valor == 'vista_Excel_Modal'){
            $("#"+valor).modal('hide');
            $('body').removeClass('modal-open');
            $('#table_vista_Excel_Modal').DataTable().destroy();
            var id_reporte = $('#id_report').val();
            $('#modalCerrarEdicion').modal('show');
            $('#modal_id_reporte').val(id_reporte);
            //$('#modal-cerrarEdicion-titulo').html('Reporte: '+id_reporte);
        }
        else{
            $("#"+valor).modal('hide');
            $('body').removeClass('modal-open');
        }
    }

    function cerrar_modal_1(valor, modal_anterior){
        $("#"+valor).modal('hide');
        $("#"+modal_anterior).modal('show');
    }
    
    function modal_error(mensaje,modalAnterior=null){
        $('#messageError').html(`${mensaje}`);
        $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
        if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
        $('#modalError').modal('show');
    }
  
    function modal_success(mensaje,modalAnterior=null){
        $('#modal-success-titulo').html(`${mensaje}`);
        $('#btnCerrarSuccess').attr('data-modal',modalAnterior!=null?modalAnterior:'');
        if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
        $('#modalSuccess').modal('show');
    }

    function alertaOcupado(mensaje){
        $('#modal-warning-titulo').html(`El reporte ${mensaje} esta ocupado`);
        $('#modalWarning').modal('show');
    }

    // ########### EDICION DE EXCEL  ########
    {{-- Trae los datos del servidor y genera el json con la version mas reciente --}}
    function vista_Excel_Modal(id_reporte){

        window.addEventListener('beforeunload', preventF5);
        
        $.ajax({
            type:'POST',
            url:'/public/obtener_csv/',
            data:{
                id_reporte: id_reporte
            },
            success:function(response) {
                console.log(response);
                
                if(response.status==100){
                    
                    cambiar_estado_online(id_reporte,0,'vista','');

                    //console.log(response.response);
                    
                    var datos=response.response;
                    
                    var table = $('#table_vista_Excel_Modal').DataTable({
                        processing: true,
                        data:datos,
                        responsive: false,
                        columns: [
                            { data: "no",                               },   
                            { data: "CI",
                                "render": function ( data, type, row, meta ) {
                                    
                                    //if(data < 1){
                                   //     return '<input type="text" placeholder="CI" class="CI_auto" onkeyup="seleccionCampo(this)">';
                                   // }else{
                                   //     return data;
                                   // }
                                    
                                    return data;
                                }
                            },   
                            { data: "CJ",
                                "render": function ( data, type, row, meta ) {
                                    
                                   // if(data < 1){
                                   //     return '<input type="text" placeholder="CJ" class="CJ_auto" onkeyup="seleccionCampo(this)">';
                                   // }else{
                                   //     return data;
                                   // }
                                    
                                    return data;
                                }
                            },   
                            { data: "nombre",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="nombre" class="nombre_auto" onkeyup="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },       
                            { data: "apellidoPaterno",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="apellido Paterno" class="apellidoPaterno_auto" onkeyup="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },           
                            { data: "apellidoMaterno",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="apellido Materno" class="apellidoMaterno_auto" onkeyup="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },           
                            { data: "fechaNacimiento",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1 || data == 'no'){
                                        return '<input type="text" placeholder="fecha Nacimiento" class="fechaNacimiento_auto fc_auto" onChange="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },           
                            { data: "domicilio",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="domicilio" class="domicilio_auto" onkeyup="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },       
                            { data: "genero",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<select class="genero_auto" onChange="seleccionCampo(this)"><option value="">Genero</option><option value="Masculino">Masculino</option><option value="Femenino">Femenino</option></select>';
                                    }else{
                                        return data;
                                    }
                                }
                            },   
                            { data: "edad",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="number" placeholder="edad" class="edad_auto" min="1" max="100" onChange="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },   
                            { data: "ingreso",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="Ingreso" class="ingreso_auto fc_auto" onChange="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },   
                            { data: "estatus_imputado",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<select class="estatus_imputado_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="ACTIVO">ACTIVO</option><option value="INACTIVO">INACTIVO</option></select>';
                                    }else{
                                        return data;
                                    }
                                }
                            },               
                            { data: "estatus_reincidencia",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<select class="estatus_reincidencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="ACTIVO">ACTIVO</option><option value="INACTIVO">INACTIVO</option></select>';
                                    }else{
                                        return data;
                                    }
                                }
                            },                   
                            { data: "fecha_vinculacion_proceso",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1 || data == 'no' ){
                                        return '<input type="text" placeholder="Fecha de vinculacion" class="fecha_vinculacion_proceso_auto fc_auto" onChange="seleccionCampo(this)">';
                                    }else{
                                        return data.replace(/=>/g, ':');
                                    }
                                }
                            },                       
                            { data: "fecha_sentencia",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1 || data == 'no'){
                                        return '<input type="text" placeholder="Fecha de sentencia" class="fecha_sentencia_auto fc_auto" onChange="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },           
                            { data: "fecha_apelacion",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="Fecha de Apelacion" class="fecha_apelacion_auto fc_auto" onChange="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },           
                            { data: "estatus_multa_posterior_apelacion",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="estatus multa posterior apelacion" class="estatus_multa_posterior_apelacion_auto" onchange="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },                               
                            { data: "pena_pecunaria_posterior_apelacion",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="pena pecunaria posterior apelacion" class="pena_pecunaria_posterior_apelacion_auto" onkeyup="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },                               
                            { data: "fecha_amparo",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1 || data == 'no'){
                                        return '<input type="text" placeholder="Fecha de Amparo" class="fecha_amparo_auto fc_auto" onChange="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },           
                            { data: "fecha_sobreseimiento",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1 || data == 'no'){
                                        return '<input type="text" placeholder="Fecha sobreseimiento" class="fecha_sobreseimiento_auto fc_auto" onChange="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },               
                            { data: "tipo_juicio",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="tipo juicio" class="tipo_juicio_auto " onkeyup="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },       
                            { data: "tiempo_sentencia",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1 || data == 'no'){
                                        return '<input type="text" placeholder="tiempo sentencia" class="tiempo_sentencia_auto " onkeyup="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },               
                            { data: "estatus_multa_posterior_sentencia",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="estatus multa posterior sentencia" class="estatus_multa_posterior_sentencia_auto " onchange="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },                               
                            { data: "pena_pecunaria_sentencia",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<input type="text" placeholder="pena pecunaria sentencia" class="pena_pecunaria_sentencia_auto " onkeyup="seleccionCampo(this)">';
                                    }else{
                                        return data;
                                    }
                                }
                            },                       
                            { data: "estatus_carpeta",
                                "render": function ( data, type, row, meta ) {
                                    if(data < 1){
                                        return '<select class="estatus_carpeta_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Activo">Activo</option><option value="Cerrada">Cerrada</option></select>';
                                    }else{
                                        return data;
                                    }
                                }
                            }         
                        ],
                        searching: true, 
                        paging: true,
                        info:false, 
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            }
                        },
                        lengthMenu: [[7,10, 25, 50, -1], [7,10, 25, 50, "All"]]
                    });
                    
                    $('#sarchItem').on('keyup', function () {
                        table.search($(this).val()).draw();
                    } );

                    $('#version_CSV').val(response.version);
                    $('#nombre_CSV').val(response.nombre_documento);
                    $('#id_report').val(id_reporte);
                    eliminar_json_temporal(response.nombre_documento,2);
                    
                   table.on('page.dt', function (){
                        setTimeout(function(){
                            $(".fc_auto").datepicker({showOtherMonths: true,selectOtherMonths: true,dateFormat: 'yy-mm-dd',});
                        }, 600);
                    });

                    $('#vista_Excel_Modal').modal('show');

                }else if(response.status == 200){
                    $('#modal-warning-titulo').html(response.response);
                    $('#modalWarning').modal('show');
                }
                
            }
        });
        
        setTimeout(function(){
            $(".fc_auto").datepicker({showOtherMonths: true,selectOtherMonths: true,dateFormat: 'yy-mm-dd',});
        }, 600)
        
    }

    {{-- Hace las celdas editables --}}
    {{-- const createdCell = function(cell) {
        let original;

        if(cell.textContent.length > 0){

        }else{
            cell.setAttribute('contenteditable', true)
            cell.setAttribute('spellcheck', false)
            cell.addEventListener("focus", function(e) {
                  original = e.target.textContent
              })
            cell.addEventListener("blur", function(e) {
                if (original !== e.target.textContent) {
                    const row = table.row(e.target.parentElement)
                    row.invalidate()
                    console.log('Row changed: ', row.data())
                }
            })
        }
    } --}}
    
    {{-- Guarda los datos en el json local --}}
    function guardar_json_local(){
        var json_csv= [];
        var json = [];
        var version_CSV = (parseInt($('#version_CSV').val(), 10) + 1);
        var nombre_CSV = $('#nombre_CSV').val();
        var id_reporte = $('#id_report').val();
        var nombre_nuevo_CSV = id_reporte+'_'+version_CSV

        var no = [];
        var CI = [];
        var CJ = [];
        var nombre = [];
        var apellidoPaterno = [];
        var apellidoMaterno = [];
        var fechaNacimiento = [];
        var domicilio = [];
        var genero = [];
        var edad = [];
        var ingreso = [];
        var estatus_imputado = [];
        var estatus_reincidencia = [];
        var fecha_vinculacion_proceso = [];
        var fecha_sentencia = [];
        var fecha_apelacion = [];
        var estatus_multa_posterior_apelacion = [];
        var pena_pecunaria_posterior_apelacion = [];
        var fecha_amparo = [];
        var fecha_sobreseimiento = [];
        var tipo_juicio = [];
        var tiempo_sentencia = [];
        var estatus_multa_posterior_sentencia = [];
        var pena_pecunaria_sentencia = [];
        var estatus_carpeta = [];
        
        var rows = $("#table_vista_Excel_Modal").dataTable().fnGetNodes();
        for(var i=0; i<rows.length; i++)
        {
            no.push($(rows[i]).find("td").eq(0).text());
            CI.push($(rows[i]).find("td").eq(1).text());
            CJ.push($(rows[i]).find("td").eq(2).text());
            //nombre
            if($(rows[i]).find("td").eq(3).text().length >= 1){
                nombre.push($(rows[i]).find("td").eq(3).text());
            }else{
                nombre.push( $(rows[i]).find("td").eq(3).children(".nombre_auto").val().toUpperCase() );
            }
            //Apellido Paterno
            if($(rows[i]).find("td").eq(4).text().length >= 1){
                apellidoPaterno.push($(rows[i]).find("td").eq(4).text());
            }else{
                apellidoPaterno.push( $(rows[i]).find("td").eq(4).children(".apellidoPaterno_auto").val().toUpperCase() );
            }
            //Apellido Materno
            if($(rows[i]).find("td").eq(5).text().length >= 1){
                apellidoMaterno.push( $(rows[i]).find("td").eq(5).text() );
            }else{
                apellidoMaterno.push( $(rows[i]).find("td").eq(5).children(".apellidoMaterno_auto").val().toUpperCase());
            }
            //Fecha Nacimiento
            if($(rows[i]).find("td").eq(6).text().length >= 1){
                fechaNacimiento.push($(rows[i]).find("td").eq(6).text());
            }else{
                fechaNacimiento.push( $(rows[i]).find("td").eq(6).children(".fechaNacimiento_auto").val());
            }

            //Domicilio
            if($(rows[i]).find("td").eq(7).text().length >= 1){
                domicilio.push($(rows[i]).find("td").eq(7).text());
            }else{
                domicilio.push( $(rows[i]).find("td").eq(7).children(".domicilio_auto").val() );
            }

            //Genero
            if($(rows[i]).find("td").eq(8).text().length >= 1){
                genero.push($(rows[i]).find("td").eq(8).text());
            }else{
                genero.push( $(rows[i]).find("td").eq(8).children(".genero_auto").val() );
            }

            //edad
            if($(rows[i]).find("td").eq(9).text().length >= 1){
                edad.push($(rows[i]).find("td").eq(9).text());
            }else{
                edad.push( $(rows[i]).find("td").eq(9).children(".edad_auto").val() );
            }

            //ingreso
            if($(rows[i]).find("td").eq(10).text().length >= 1){
                ingreso.push($(rows[i]).find("td").eq(10).text());
            }else{
                ingreso.push( $(rows[i]).find("td").eq(10).children(".ingreso_auto").val() );
            }

            //estatus imputado
            if($(rows[i]).find("td").eq(11).text().length >= 1 && $(rows[i]).find("td").eq(11).text().length <= 8){
                estatus_imputado.push($(rows[i]).find("td").eq(11).text());
            }else{
                estatus_imputado.push( $(rows[i]).find("td").eq(11).children(".estatus_imputado_auto").val() );
            }            

            //estatus reincidencia
            if($(rows[i]).find("td").eq(12).text().length >= 1 && $(rows[i]).find("td").eq(12).text().length <= 8){
                estatus_reincidencia.push($(rows[i]).find("td").eq(12).text());
            }else{
                estatus_reincidencia.push( $(rows[i]).find("td").eq(12).children(".estatus_reincidencia_auto").val() );
            }  
            
            //Fecha vinculacion proceso (rango entre 1 y 8)
            if($(rows[i]).find("td").eq(13).text().length >= 1){
                fecha_vinculacion_proceso.push($(rows[i]).find("td").eq(13).text());
            }else{
                fecha_vinculacion_proceso.push( $(rows[i]).find("td").eq(13).children(".fecha_vinculacion_proceso_auto").val() );
            }   
            
            //Fecha setencia
            if($(rows[i]).find("td").eq(14).text().length >= 1){
                fecha_sentencia.push($(rows[i]).find("td").eq(14).text());
            }else{
                fecha_sentencia.push( $(rows[i]).find("td").eq(14).children(".fecha_sentencia_auto").val() );
            }             

            //Fecha apelacion
            if($(rows[i]).find("td").eq(15).text().length >= 1){
                fecha_apelacion.push($(rows[i]).find("td").eq(15).text());
            }else{
                fecha_apelacion.push( $(rows[i]).find("td").eq(15).children(".fecha_apelacion_auto").val() );
            } 

            //Estatus multa posterior apelacion
            if($(rows[i]).find("td").eq(16).text().length >= 1 && $(rows[i]).find("td").eq(16).text().length <= 8){
                estatus_multa_posterior_apelacion.push($(rows[i]).find("td").eq(16).text()); 
            }else{
                estatus_multa_posterior_apelacion.push( $(rows[i]).find("td").eq(16).children(".estatus_multa_posterior_apelacion_auto").val() );
            }             

            //Pena pecunaria posterior apelacion
            if($(rows[i]).find("td").eq(17).text().length >= 1){
                pena_pecunaria_posterior_apelacion.push($(rows[i]).find("td").eq(17).text());
            }else{
                pena_pecunaria_posterior_apelacion.push( $(rows[i]).find("td").eq(17).children(".pena_pecunaria_posterior_apelacion_auto").val() );
            }

           //Fecha amparo
           if($(rows[i]).find("td").eq(18).text().length >= 1){
                fecha_amparo.push($(rows[i]).find("td").eq(18).text()); 
           }else{
                fecha_amparo.push( $(rows[i]).find("td").eq(18).children(".fecha_amparo_auto").val() );
           } 

           //Fecha sobreseimiento
           if($(rows[i]).find("td").eq(19).text().length >= 1){
                fecha_sobreseimiento.push($(rows[i]).find("td").eq(19).text()); 
           }else{
                fecha_sobreseimiento.push( $(rows[i]).find("td").eq(19).children(".fecha_sobreseimiento_auto").val() );
           } 

            //Tipo juicio
            if($(rows[i]).find("td").eq(20).text().length >= 1){
                tipo_juicio.push($(rows[i]).find("td").eq(20).text());  
            }else{
                tipo_juicio.push( $(rows[i]).find("td").eq(20).children(".tipo_juicio_auto").val() );
            }            

            //Tiempo sentencia
            if($(rows[i]).find("td").eq(21).text().length >= 1){
                tiempo_sentencia.push($(rows[i]).find("td").eq(21).text());
            }else{
                tiempo_sentencia.push( $(rows[i]).find("td").eq(21).children(".tiempo_sentencia_auto").val() );
            }            
            
            //estatus multa posterior setencia
            if( $(rows[i]).find("td").eq(22).text().length >= 1 && $(rows[i]).find("td").eq(22).text().length <= 8){
                estatus_multa_posterior_sentencia.push($(rows[i]).find("td").eq(22).text()); 
            }else{
                estatus_multa_posterior_sentencia.push( $(rows[i]).find("td").eq(22).children(".estatus_multa_posterior_sentencia_auto").val() );
            }

            //estatus multa posterior setencia
            if($(rows[i]).find("td").eq(23).text().length >= 1 && $(rows[i]).find("td").eq(23).text().length <= 8){
                pena_pecunaria_sentencia.push($(rows[i]).find("td").eq(23).text()); 
            }else{
                pena_pecunaria_sentencia.push( $(rows[i]).find("td").eq(23).children(".pena_pecunaria_sentencia_auto").val() );
            }            

            //estatus multa posterior setencia
            if($(rows[i]).find("td").eq(24).text().length >= 1 && $(rows[i]).find("td").eq(24).text().length <= 8  ){
                estatus_carpeta.push($(rows[i]).find("td").eq(24).text());
            }else{
                estatus_carpeta.push( $(rows[i]).find("td").eq(24).children(".estatus_carpeta_auto").val() );
            }           
             
        }


        var tr = [];
        for(i = 0; i < no.length; i++){
            tr.push({
                "no":no[i],
                "CI":CI[i],
                "CJ":CJ[i],
                "nombre":nombre[i],
                "apellidoPaterno":apellidoPaterno[i],
                "apellidoMaterno":apellidoMaterno[i],
                "fechaNacimiento":fechaNacimiento[i],
                "domicilio":domicilio[i],
                "genero":genero[i],
                "edad":edad[i],
                "ingreso":ingreso[i],
                "estatus_imputado":estatus_imputado[i],
                "estatus_reincidencia":estatus_reincidencia[i],
                "fecha_vinculacion_proceso":fecha_vinculacion_proceso[i],
                "fecha_sentencia":fecha_sentencia[i],
                "fecha_apelacion":fecha_apelacion[i],
                "estatus_multa_posterior_apelacion":estatus_multa_posterior_apelacion[i],
                "pena_pecunaria_posterior_apelacion":pena_pecunaria_posterior_apelacion[i],
                "fecha_amparo":fecha_amparo[i],
                "fecha_sobreseimiento":fecha_sobreseimiento[i],
                "tipo_juicio":tipo_juicio[i],
                "tiempo_sentencia":tiempo_sentencia[i],
                "estatus_multa_posterior_sentencia":estatus_multa_posterior_sentencia[i],
                "pena_pecunaria_sentencia":pena_pecunaria_sentencia[i],
                "estatus_carpeta":estatus_carpeta[i]
            })
        }
        
        for(j = 0; j < tr.length; j++){
            json_csv.push(tr[j]);
        }

        //console.log(json_csv);
        
        
        if(version_CSV == '' || nombre_CSV == '' ||  version_CSV == null || nombre_CSV == null ){
            json['response'] = null;
            json['version'] = null;
            json['nombre'] = null;
            json['status'] = 0;
            
            var mensaje = 'Error en la version y nombre del documento';
            modal_error(mensaje, 'vista_Excel_Modal' );
        }else{
            
            json['response'] = json_csv;
            json['version'] = version_CSV;
            json['nombre'] = nombre_nuevo_CSV;
            json['status'] = 100;
            
            console.log(json);

            
            $.ajax({
                type:'POST',
                url:'/public/guardar_json_local',
                data:{
                    "response":json_csv,
                    'version':version_CSV,
                    'nombre':nombre_nuevo_CSV,
                    'status':100
                },
                beforeSend: function(){
                    $('#btn_guardarExcel').html('Guardando...');
                },
                success:function(response) {
                    if(response.status == 100){
                        $('#table_vista_Excel_Modal').DataTable().destroy();
                        mostrar_version_nueva_csv(id_reporte,version_CSV,json_csv);
                        modal_success(response.message, 'vista_Excel_Modal' );
                        $('#btn_guardarExcel').html('Guardar');
                    }else{
                        modal_error(response.message, 'vista_Excel_Modal' );
                    }
                }
            });
        }
        
    }

    {{-- Muestra los datos del json local --}}
    function mostrar_version_nueva_csv(nombre, version, json){

            var table = $('#table_vista_Excel_Modal').DataTable({
                data:json,
                responsive: true,
                columns: [
                    { data: "no",                               },   
                    { data: "CI",
                        "render": function ( data, type, row, meta ) {
                            
                            //if(data < 1){
                           //     return '<input type="text" placeholder="CI" class="CI_auto" onkeyup="seleccionCampo(this)">';
                           // }else{
                           //     return data;
                           // }
                            
                            return data;
                        }
                    },   
                    { data: "CJ",
                        "render": function ( data, type, row, meta ) {
                            
                           // if(data < 1){
                           //     return '<input type="text" placeholder="CJ" class="CJ_auto" onkeyup="seleccionCampo(this)">';
                           // }else{
                           //     return data;
                           // }
                            
                            return data;
                        }
                    },   
                    { data: "nombre",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="nombre" class="nombre_auto" onkeyup="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },       
                    { data: "apellidoPaterno",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="apellido Paterno" class="apellidoPaterno_auto" onkeyup="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },           
                    { data: "apellidoMaterno",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="apellido Materno" class="apellidoMaterno_auto" onkeyup="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },           
                    { data: "fechaNacimiento",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1 || data == 'no'){
                                return '<input type="text" placeholder="fecha Nacimiento" class="fechaNacimiento_auto fc_auto" onChange="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },           
                    { data: "domicilio",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="domicilio" class="domicilio_auto" onkeyup="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },       
                    { data: "genero",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<select class="genero_auto" onChange="seleccionCampo(this)"><option value="">Genero</option><option value="Masculino">Masculino</option><option value="Femenino">Femenino</option></select>';
                            }else{
                                return data;
                            }
                        }
                    },   
                    { data: "edad",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="number" placeholder="edad" class="edad_auto" min="1" max="100" onChange="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },   
                    { data: "ingreso",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="Ingreso" class="ingreso_auto fc_auto" onChange="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },   
                    { data: "estatus_imputado",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<select class="estatus_imputado_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="ACTIVO">ACTIVO</option><option value="INACTIVO">INACTIVO</option></select>';
                            }else{
                                return data;
                            }
                        }
                    },               
                    { data: "estatus_reincidencia",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<select class="estatus_reincidencia_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="ACTIVO">ACTIVO</option><option value="INACTIVO">INACTIVO</option></select>';
                            }else{
                                return data;
                            }
                        }
                    },                   
                    { data: "fecha_vinculacion_proceso",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1 || data == 'no' ){
                                return '<input type="text" placeholder="Fecha de vinculacion" class="fecha_vinculacion_proceso_auto fc_auto" onChange="seleccionCampo(this)">';
                            }else{
                                return data.replace(/=>/g, ':');
                            }
                        }
                    },                       
                    { data: "fecha_sentencia",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1 || data == 'no'){
                                return '<input type="text" placeholder="Fecha de sentencia" class="fecha_sentencia_auto fc_auto" onChange="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },           
                    { data: "fecha_apelacion",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="Fecha de Apelacion" class="fecha_apelacion_auto fc_auto" onChange="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },           
                    { data: "estatus_multa_posterior_apelacion",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="estatus multa posterior apelacion" class="estatus_multa_posterior_apelacion_auto" onchange="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },                               
                    { data: "pena_pecunaria_posterior_apelacion",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="pena pecunaria posterior apelacion" class="pena_pecunaria_posterior_apelacion_auto" onkeyup="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },                               
                    { data: "fecha_amparo",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1 || data == 'no'){
                                return '<input type="text" placeholder="Fecha de Amparo" class="fecha_amparo_auto fc_auto" onChange="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },           
                    { data: "fecha_sobreseimiento",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1 || data == 'no'){
                                return '<input type="text" placeholder="Fecha sobreseimiento" class="fecha_sobreseimiento_auto fc_auto" onChange="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },               
                    { data: "tipo_juicio",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="tipo juicio" class="tipo_juicio_auto " onkeyup="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },       
                    { data: "tiempo_sentencia",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1 || data == 'no'){
                                return '<input type="text" placeholder="tiempo sentencia" class="tiempo_sentencia_auto " onkeyup="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },               
                    { data: "estatus_multa_posterior_sentencia",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="estatus multa posterior sentencia" class="estatus_multa_posterior_sentencia_auto " onchange="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },                               
                    { data: "pena_pecunaria_sentencia",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<input type="text" placeholder="pena pecunaria sentencia" class="pena_pecunaria_sentencia_auto " onkeyup="seleccionCampo(this)">';
                            }else{
                                return data;
                            }
                        }
                    },                       
                    { data: "estatus_carpeta",
                        "render": function ( data, type, row, meta ) {
                            if(data < 1){
                                return '<select class="estatus_carpeta_auto" onchange="seleccionCampo(this)"><option value="">Estatus</option><option value="Activo">Activo</option><option value="Cerrada">Cerrada</option></select>';
                            }else{
                                return data;
                            }
                        }
                    }         
                ],
                searching: true, 
                paging: true,
                info:false, 
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                lengthMenu: [[7,10, 25, 50, -1], [7,10, 25, 50, "All"]]
            });
                    
            $('#sarchItem').on('keyup', function () {
                table.search($(this).val()).draw();
            } );

            $('#version_CSV').val(version);
            $('#nombre_CSV').val(nombre);

            setTimeout(function(){
                $(".fc_auto").datepicker({showOtherMonths: true,selectOtherMonths: true,dateFormat: 'yy-mm-dd',});
            }, 600);

            table.on('page.dt', function (){
                setTimeout(function(){
                    $(".fc_auto").datepicker({showOtherMonths: true,selectOtherMonths: true,dateFormat: 'yy-mm-dd',});
                }, 600);
            });

            guardar_json_CSV(nombre, version,json);
    }

    {{-- funcion que se ejecuta en segundo plano para enviar el json al servidor --}}
    function guardar_json_CSV(nombre, version, data){
        $.ajax({
            type:'POST',
            url:'/public/csv_version_nueva',
            data:{
                nombre: nombre,
                version: version,
                data:data
            },
            success: function(response){}
        });
    }

    {{-- Eliminar documento Temporal de Version --}}
    function eliminar_json_temporal(nombre, version){
        var nombre_completo = nombre+version;

        $.ajax({
            type:'post',
            url:'/public/eliminar_json_temporal',
            data:{
                nombre_archivo : nombre_completo
            },
            success: function(response){
                console.log(response);
            }
        });
    }

    {{-- Datos rellenados --}}
    function seleccionCampo(obj){
        if(obj.value.length > 0){
            obj.style.background='#848F33';
            obj.style.color='#fff';
        }else{
            obj.style.background='#efefef';
            obj.style.color='#444';
        }
    }

    {{-- Cambair estado online --}}
    function cambiar_estado_online(id,estado, donde, modal){
        if(donde=='modal'){
            id_reporte = $('#modal_id_reporte').val();
            $.ajax({
                type:'POST',
                url:'/public/cambiar_estado_online',
                data:{
                    id_reporte: id_reporte,
                    estado: estado
                },
                success: function(response){}
            });
            $('#'+modal).modal('hide');
            window.removeEventListener("beforeunload", preventF5, false);
        }else if (donde == 'vista'){
            $.ajax({
                type:'POST',
                url:'/public/cambiar_estado_online',
                data:{
                    id_reporte: id,
                    estado: estado
                },
                success: function(response){}
            });
        }

    }

    {{-- Revisar Estado --}}
    function revisar_estado_online(){
        
        $.ajax({
            type:'POST',
            url:'/public/revisar_estado_online',
            data:{
                adip: 'adip'
            },
            success: function(response){
                if(response.status == 100){
                    datos = response.response;
                    //console.log(datos);
                    for(i= 0; i < datos.length; i++){
                        if(datos[i].disponibilidad == 0){
                            $('#d_'+datos[i].id_reporte).removeClass('disponible');
                            $('#d_'+datos[i].id_reporte).addClass('ocupado');
                            $('#c_'+datos[i].id_reporte).prop('disabled', true);
                            $('#b_'+datos[i].id_reporte).attr("onclick", 'alertaOcupado('+datos[i].id_reporte+')');
                            $('#b_'+datos[i].id_reporte).css("background", "#F1C40F !important");
                        }else{
                            $('#d_'+datos[i].id_reporte).removeClass('ocupado');
                            $('#d_'+datos[i].id_reporte).addClass('disponible');
                            $('#c_'+datos[i].id_reporte).prop('disabled', false);
                            $('#b_'+datos[i].id_reporte).attr("onclick", 'vista_Excel_Modal('+datos[i].id_reporte+')');
                        }
                    }
                }
            }
        });

    }

    {{--  Fusionar reportes  --}}
    function fusionar_reporte(){
        array_fusion = [];

        $('.check_adip').each(function(){
            if($(this).is(':checked') ){
                array_fusion.push($(this).attr('id').replace('c_', ''));
            }else{
            }
        });

        console.log(array_fusion);
    }

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

                    <iframe src="" id="documentoPDFrame"></iframe>

                </div><!-- modal-body -->
                <div class="modal-footer d-flex">
                <button type="button" class="btn btn-secondary d-inline-block mg-l-auto"  style="margin-left: auto;" data-dismiss="modal">Cerrar</button>
           </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="vista_Excel_Modal" class="modal fade" data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available; max-width: 1350px!important;">
            <div class="modal-content tx-size-sm">
                <div class="modal-header pd-x-20" style="background:#848F33 !important; color:#fff !important;">
                <h5 class="modal-title" >Editar Excel - Reporte ADIP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrar_modal('vista_Excel_Modal')">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body pd-x-20 pd-t-0">
                    <input type="hidden" id="version_CSV">
                    <input type="hidden" id="nombre_CSV">
                    <input type="hidden" id="id_report">
                    <div class="col-md-12 d-flex justify-content-center">
                        <input type="text" id="sarchItem" placeholder="Buscar registros">
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="table_vista_Excel_Modal">
                            <thead>
                                <tr id="encabezado_personalizado">
                                    <th scope="col">N°</th>
                                    <th scope="col">Carpeta Investigación</th>
                                    <th scope="col">Expediente Digital</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido Paterno</th>
                                    <th scope="col">Apellido Materno</th>
                                    <th scope="col">Fecha Nacimiento</th>
                                    <th scope="col">Domicilio</th>
                                    <th scope="col">Sexo</th>
                                    <th scope="col">Edad</th>
                                    <th scope="col">Ingreso</th>
                                    <th scope="col">Estatus del Imputado</th>
                                    <th scope="col">Estatus de Reincidencia</th>
                                    <th scope="col">Fecha vinculación proceso</th>
                                    <th scope="col">Fecha sentencia</th>
                                    <th scope="col">Fecha Apelación</th>
                                    <th scope="col">Estatus de la multa posterior a la apelación</th>
                                    <th scope="col">Pena pecuniaria posterior a la apelación</th>
                                    <th scope="col">Fecha Amparo</th>
                                    <th scope="col">Fecha Sobreseimiento</th>
                                    <th scope="col">Tipo de Juicio</th>
                                    <th scope="col">Tiempo de Sentencia</th>
                                    <th scope="col">Estatus de la multa posterior a la sentencia</th>
                                    <th scope="col">Pena pecuniaria de Sentencia</th>
                                    <th scope="col">Estatus Proceso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div><!-- modal-body -->
                <div class="modal-footer d-flex" id="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar_modal('vista_Excel_Modal')">Cerrar</button>
                    <button type="button" class="btn btn-secondary " onclick="guardar_json_local()" style="background:#848F33 !important; color:#fff;"  id="btn_guardarExcel">Guardar</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalError" class="modal fade">
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> -->
              <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
              <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
              <p class="mg-b-20 mg-x-20" id="messageError"></p>
              <button type="button" class="btn btn-danger pd-x-25 cerrar-modal" data-modal="" data-thismodal="modalError" id="btnCerrarError">Aceptar</button>
            </div><!-- modal-body -->
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    
    <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
              <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
              <h6 class="tx-success tx-semibold mg-b-20">Hecho!</h6>
              <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-success-titulo">Titulo Modal Success</p>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex">
              <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-modal="" data-thismodal="modalSuccess" id="btnCerrarSuccess">Aceptar</button>
            </div>
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalWarning" class="modal fade"  data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <i class="fas fa-exclamation-triangle tx-100 tx-warning lh-1 mg-y-20 d-inline-block"></i>
              <h6 class="tx-warning tx-semibold mg-b-20">Lo sentimos!</h6>
              <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-warning-titulo">Titulo Modal Success</p>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex">
              <button type="button" class="btn btn-primary pd-x-25 mg-l-auto cerrar-modal" data-modal="" data-thismodal="modalWarning" id="btnCerrarSuccess">Aceptar</button>
            </div>
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modalCerrarEdicion" class="modal fade"  data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog" role="document">
          <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" id="modal_id_reporte">
                <i class="fas fa-exclamation-triangle tx-100 tx-warning lh-1 mg-y-20 d-inline-block"></i>
              <h6 class="tx-warning tx-semibold mg-b-20">Deseas salir sin guardar Cambios?</h6>
              <p style="padding-left: 5vh; padding-right: 5vh;" id="modal-cerrarEdicion-titulo"></p>
            </div><!-- modal-body -->
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-default pd-x-25 cerrar-modal" data-modal=""  onclick="cerrar_modal_1('modalCerrarEdicion','vista_Excel_Modal')">Cancelar</button>
              <button type="button" class="btn btn-primary pd-x-25 cerrar-modal" data-modal=""  onclick="cambiar_estado_online('',1,'modal','modalCerrarEdicion')">Aceptar</button>
            </div>
          </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->

@endsection
