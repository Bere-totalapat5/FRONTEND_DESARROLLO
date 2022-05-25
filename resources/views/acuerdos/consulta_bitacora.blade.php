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

 <div class="section-wrapper" style="max-width: 1200px;">
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
                                    <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" name="idunidad" id="idunidad">

                                    </select>
                                </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                      <label class="form-control-label">Elije un Usuario: {{-- <span class="tx-danger">*</span> --}}</label>
                                      <select class="form-control select2" id="selectusuario" name="selectusuario" autocomplete="off">

                                      </select>
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
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" id="fechaini" name="" autocomplete="off">
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
                                            <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" id="fechafin" name="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3" >
                                <label class="form-control-label">Tipo de Proceso:</label>
                                <div class="form-group" >
                                    <select class="form-control-lg select2 valid" width='100%'  autocomplete="off" id="tipoproceso">
                                        <option selected disabled value="">Elija una opción</option>
                                        <option value="" >{{'TODAS'}}</option>
                                             <option value="insercion" >{{'Inserción'}}</option>
                                            <option value="modificacion" >{{'Modificación'}}</option>
                                            <option value="logueo" >{{'Logueo'}}</option>
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



                     {{--   [9:44, 4/3/2021] +52 1 55 4898 9876: style="cursor:pointer";
                       [9:44, 4/3/2021] +52 1 55 4898 9876: style="cursor:all-scroll"; --}}

 <!--TABLA RESULTADOS BUSQUEDA -->
                <div id="table-bitacora" class="mg-b-20">
                    <table id="bitacoraTable" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                        <thead style="background-color: #EBEEF1; color: #000; text-align:center">
                            <tr>
                                <th style="cursor:pointer" class="unidad" name="unidad">Unidad</th>
                                <th style="cursor:pointer" class="tipo_documento" name="tipo_documento">Tipo de Documento</th>
                                <th style="cursor:pointer" class="folio_carpeta" name="folio_carpeta">Folio de Carpeta</th>
                                <th style="cursor:pointer" class="id_acuerdo" name="id_acuerdo">Id- Acuerdo</th>
                                <th style="cursor:pointer" class="id_carpeta_judicial" name="id_carpeta_judicial">Id Carpeta Judicial</th>
                            </tr>
                        </thead>
                      {{--   <tbody id="body-table1" class="items-agregados" style="width: 100%; text-align: center;">
                        </tbody>  --}}
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


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.5.3/css/colReorder.dataTables.min.css"/>


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

            .unidad {
                min-width: 150px !important;
            }

            .tipo_documento {
                min-width: 200px !important;
            }

            .folio_carpeta {
                min-width: 110px !important;
            }

            .id_acuerdo {
                min-width: 150px !important;
            }
            .id_carpeta_judicial {
                min-width: 180px !important;
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
                $('#idunidad').html(`<option selected disabled value="">Elija una opción</option>
                <option value=""> TODAS LAS UNIDADES </option>` + unidades);

            }
            }
        });


             //obtener un
        $('#idunidad').change(function(){
        $.ajax({
            type:'POST',
            url:'/public/obtener_usuarios',
            data:{
            id_unidad_gestion:$('#idunidad').val(),
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
         $('#idunidad').keypress(function (e) {
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




        $.ajax({
            type:'POST',
            url:'/public/obtener_acuerdos',
            data:{
                id_usuario:$("#selectusuario").val(),
                id_unidad_gestion:$("#idunidad").val(),
                //usuario:$("#usuario").val(),
                fecha_ini:fechaini,
                fecha_fin:fechafin,
                tipo:$("#tipoproceso").val(),
                pagina:$('#numeropagina').val(),
                //registros_por_pagina:$('.pagina_actual_texto').val(),
                 registros_por_pagina:10,

            },
                success:function(response) {

                if(response.status==100){

                    var datos=response.response;


                   var body = new $('#bitacoraTable').dataTable( {
                                processing: true,
                                data: datos,
                                columns: [
                                    { data: "creacion" ,title:"creacion"},
                                    { data: "id_usuario" ,title: "id_usuario" },
                                    { data: "usuario_responsable" ,title: "usuario_responsable" },
                                    { data: "nombre_responsable",title: "nombre_responsable"  },
                                    { data: "puesto_responsable",title: "puesto_responsable"  },
                                    { data: "nombre_unidad",title: "nombre_unidad"  },
                                    { data: "modulo",title: "modulo"  },
                                    { data: "tipo",title: "tipo"  },
                                    { data: "tabla",title: "tabla"  }
                                ],
                                colReorder: true,
                                bDestroy: true,
                                colReset:true,
                                paging:   false,
                                ordering: false,
                                info:     false,
                                search:false,
                                filter:false,
                                stateSave: true,
                              //  stateClear: false,
                              //  stateLoaded: true,
                            } ); 
                                 $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                                $('#paginas_totales').val(response.response_pag['paginas_totales'])

                }else{
                    body=body.concat(`<tr>
                                          <td colspan="5"><h3>Sin datos para mostrar</h3></td>
                                          <tr>`);
                                    $('#body-table1').html(body);
                                       //  limpiarCampos();

                    }
                }
            });




            
        }
}

  function descargar_consulta(extension){
    console.log("entraste a generar :"+extension);

    let orden_columnas = get_orden_columnas();

    $('#modal_loading').modal('show');

    $.ajax({
        type:'GET',
        url:'/exportar_busqueda_bitacora',
        data:{
            id_usuario:$("#selectusuario").val(),
            d_unidad_gestion:$("#idunidad").val(),
            fecha_ini:fechaini,
            fecha_fin:fechafin,
            tipo:$("#tipoproceso").val(),
            pagina:1,
            registros_por_pagina:10000000,
            extension : extension,
            orden_columnas:orden_columnas,
        },
        success:function(data){
            console.log(data);
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
        { campo: "creacion" ,titulo:"creacion"},
        { campo: "id_usuario" ,titulo: "id_usuario" },
        { campo: "usuario_responsable" ,titulo: "usuario_responsable" },
        { campo: "nombre_responsable",titulo: "nombre_responsable"  },
        { campo: "puesto_responsable",titulo: "puesto_responsable"  },
        { campo: "nombre_unidad",titulo: "nombre_unidad"  },
        { campo: "modulo",titulo: "modulo"  },
        { campo: "tipo",titulo: "tipo"  },
        { campo: "tabla",titulo: "tabla"  }
    ];
    let columnas = [];
    $('#bitacoraTable thead tr th').each(function() {
        let columna =  campos_title.filter( index => index.titulo == $(this).text() ); 
        if( columna.length ){
            columnas.push({ titulo:  columna[0].titulo, campo: columna[0].campo });
        }
    });
    return columnas;
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

@endsection
