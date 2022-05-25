@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-principal')

{{-- @if(!isset($request->menu_general['response']))
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
                          <div class="col-lg-2">
                            <label class="form-control-label">Estatus actual:</label>
                            <div class="form-group">
                              <select class="form-control-lg select2 valid" autocomplete="off">
                                  <option selected disabled value="">Elija una opción</option>
                                       <option value="" >{{'RECIBIDA'}}</option>
                                       <option value="" >{{'REGISTRADA'}}</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-2">
                            <label class="form-control-label">Estatus urgente:</label>
                            <div class="form-group">
                              <select class="form-control-lg select2 valid" autocomplete="off">
                                  <option selected disabled value="">Elija una opción</option>
                                       <option value="" >{{'SI'}}</option>
                                       <option value="" >{{'NO'}}</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-2">
                            <label class="form-control-label">Materia destino:</label>
                            <div class="form-group">
                              <select class="form-control-lg select2 valid" autocomplete="off">
                                  <option selected disabled value="">Elija una opción</option>
                                       <option value="" >{{'Adolescentes'}}</option>
                                       <option value="" >{{'Adultos'}}</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha solicitud (Desde): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" value="{{date('Y-m-d')}}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha solicitud (Hasta): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" value="{{date('Y-m-d')}}" autocomplete="off">
                                    </div>                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Folio solicitud de Audiencia (Desde): </label>
                                    <input class="form-control" type="text"  value="" name="" id="id_solicitud" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-control-label">Folio solicitud de Audiencia (Hasta): </label>
                                    <input class="form-control" type="text"  value="" placeholder="" >
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha recepción (Desde): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" value="{{date('Y-m-d')}}" autocomplete="off">
                                    </div>                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha recepción (Hasta): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="AAAA/MM/DD" value="{{date('Y-m-d')}}" autocomplete="off">
                                    </div>                                </div>
                            </div>
                            <div class="col-lg-3">
                              <div class="form-group">
                                <label class="form-control-label">Hora de Recepción (Desde)<small>(24hrs)</small>: <span class="tx-danger">*</span></label>
                                <div class="d-flex">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                      </div><!-- input-group-text -->
                                    </div><!-- input-group-prepend -->
                                    <input  type="text" class="form-control" placeholder="hh:mm" autocomplete="off">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-3">
                              <div class="form-group">
                                <label class="form-control-label">Hora de Recepción (Hasta)<small>(24hrs)</small>: <span class="tx-danger">*</span></label>
                                <div class="d-flex">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                      </div><!-- input-group-text -->
                                    </div><!-- input-group-prepend -->
                                    <input  type="text" class="form-control"  placeholder="hh:mm" autocomplete="off">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha fenece(Desde): </label>
                                    <input class="form-control" type="text" value="" placeholder="" >
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="label">Fecha fenece (Hasta): </label>
                                    <input class="form-control" type="text" value="" placeholder="" >
                                </div>
                            </div>
                        </div><!-- row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" data-toggle="collapse" data-target="#demo" onclick="sec_ajax();">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- accordion -->



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


        {{-- </div><!-- pagination-wrapper -->
        <div class="table-solicitudes">
            <table id="tabla_solicitudes" class="table table-striped" >
                <thead style="background-color: #EBEEF1; color: rgb(0, 0, 0); text-align:center font-size: 10px; ">
                    <tr >
                    <th class="">Acciones</th>
                    <th class="">Folio de solicitud</th>
                    <th class="">Fecha/hora de registro</th>
                    <th class="">Carpeta Judicial</th>
                    <th class="">Carpeta de Investigacion</th>
                    <th class="">Tipo de Audiencia</th>
                    <th class="">Clase de Audiencia</th>
                    <th class="">Estado de la Solicitud</th>
                    <th class="">Responsable</th>
                </tr>
              </thead>
              <tbody id="body-table1" style="width: 100%; font-size: 10px; text-align: left;">

                @foreach ($solicitudes['response'] as $solicitud)

                        <tr>
                            <th class="btn-group btn-group-xs" scope="row">

                                <button type="button" title="PDF" class="btn" target="_blank" href={{$solicitud['ruta_base_pdf']}}>a</button>

                            </th>

                            <th scope="row">{{$solicitud['id_solicitud']}}</th>
                            <th scope="row">{{$solicitud['id_solicitud']}}</th>
                            <th scope="row">{{$solicitud['fecha_solicitud']}}</th>
                            <th scope="row">{{$solicitud['id_carpeta_judicial']}}</th>
                            <th scope="row">{{$solicitud['carpeta_investigacion']}}</th>
                            <th scope="row">{{$solicitud['tipo_audiencia']}}</th>
                            <th scope="row">{{$solicitud['estatus_flujo_actual']}}</th>
                            <th scope="row">{{$solicitud['estatus_flujo_actual']}}</th>

                        </tr>

                      @endforeach


            </tbody>
            </table>
          </div><!-- table-responsive -->

 --}}

<!-- pagination-wrapper -->
<div id="table-firmas" class="mg-b-20">
    <table id="depositos" class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
        <thead style="background-color: #EBEEF1; color: #000; text-align:center">
            <tr>
                <th class="">Acciones</th>
                <th class="">Folio de solicitud</th>
                <th class="">Fecha/hora de registro</th>
                <th class="">Carpeta Judicial</th>
                <th class="">Carpeta de Investigacion</th>
                <th class="">Tipo de Audiencia</th>
                <th class="">Clase de Audiencia</th>
                <th class="">Estado de la Solicitud</th>
                <th class="">Responsable</th>
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




        <div class="pagination-wrapper justify-content-space-between col-sm-4 " style="border:0px;float:none;margin:auto;">
            <ul class="pagination pagination-sm">
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
                <ul class="pagination pagination-sm">
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

       {{--  @endif
    @endif --}}
        @endsection



    @section('seccion-estilos')
        <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
        <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
     @endsection



        @section('seccion-scripts-libs')
        <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
            <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
            <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
            <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
            <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
        @endsection


    @section('seccion-scripts-functions')
     <script>





var dataTableGlobal;

$(function(){

    'use strict';

    //datatable
    dataTableGlobal=$('#datatable1').DataTable({
        responsive: true,
        "paging":   false,
        "info":     false,
        "ordering": false,
        "searching": false,
        'columnDefs': [

            { "targets": [0], responsivePriority: 1, targets: 0, "orderable": false, "visible": true },
            { "targets": [1], responsivePriority: 1, "orderable": false, "visible": true },
            { "targets": [2], responsivePriority: 1, "orderable": false, "visible": true },
            { "targets": [3], responsivePriority: 2, targets: 0, "orderable": false  },
            { "targets": [4], responsivePriority: 2, "orderable": false }
        ],
        orderable: false,
        bLengthChange: false,
        searching: false,
        responsive: true,
        language: {
            searchPlaceholder: 'Filtrar...',
            sSearch: '',
            lengthMenu: '_MENU_ Registros'
        }

    });

    //focus textfiled
    $('.form-layout .form-control').on('focusin', function(){
        $(this).closest('.form-group').addClass('form-group-active');
    });
    $('.form-layout .form-control').on('focusout', function(){
        $(this).closest('.form-group').removeClass('form-group-active');
    });

    // Select2
    $('.select2').select2({
        minimumResultsForSearch: Infinity
    });


    accionBuscarArchivo_ajax('primera');

    function accionBuscarArchivo_ajax(pagina_accion) {


}



    function sec_ajax(pagina_accion) {

        let body=""

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
            console.log('aqui');
        }
        else{
            $('#pagina_actual').val(pagina);

            $('#numeropagina').val(pagina);
            //$('#body-table1').html(body);

            $('.pagina_actual_texto').html(pagina);

        let juzgado=""
        let sin_juzgado='-'
        let id_lc='-'
        //let num_exp='-'
        //let anio_exp='-'
        let bis_exp='-'
        //let referencia='-'
        //let fecha_expedido='-'
        let hora_expedido='-'
        //let estatus_actual=$("#sel1").val()
        let id_solicitud=""
        //console.log(estatus_actual);

        $.ajax({
            type:'POST',
            url:'solicitudes/consulta_solicitudes',
            data:{
                id_solicitud:$("#id_solicitud").val(),
               /*  sin_juzgado:sin_juzgado,
                id_lc:id_lc,
                num_exp:$("#pornum_exp").val(),
                anio_exp:$("#poranio_exp").val(),
                bis_exp:bis_exp,
                referencia:$("#porreferencia").val(),
                fecha_expedido:$("#fechaconsulta").val(),
                hora_expedido:hora_expedido,
                pagina:$('#numeropagina').val(),
                registros_por_pagina:$('.pagina_actual_texto').val(),
                estatus_actual:$("#sel1").val(), */

            },
                success:function(response) {

                if(response.status==100){

                    $.each(response.response, function(index, solicitud){

                         console.log(linea.estatus_actual);
                        // console.log(linea.referencia_num);


    body=body.concat(`<tr id_solicitud="${solicitud.id_solicitud}"


                        <td class="acciones">
                            <a href="javascript:void(0)" data-toggle="modal" onclick="exhibir(${linea.id_linea_captura})"> Exhibir </a><br>
                            <a href="javascript:void(0)" data-toggle="modal" onclick="edita_linea(${linea.id_linea_captura},'${linea.id_juicio}','${linea.num_expediente}','${linea.anio_expediente}','${linea.bis_expediente}','${linea.tipo_expediente}','${linea.id_acuerdo}','${linea.num_acuerdo}','${linea.NAS_acuerdo}','${linea.fecha_exhibicion}')">Cambiar Acuerdo</a><br>
                            <a href="javascript:void(0)" data-toggle="modal" onclick="ver_linea(${linea.id_linea_captura},'${linea.folio}','${linea.referencia_santander}','${linea.referencia_num}','${linea.involucrados[0].nombre}','${linea.concepto}','${linea.monto}','${linea.tipo_moneda}','${linea.estatus_actual}','${linea.num_expediente}','${linea.anio_expediente}','${linea.id_acuerdo}','${linea.num_acuerdo}','${linea.NAS_acuerdo}','${linea.fecha_exhibicion}')"> Ver</a><br>
                            <a href="javascript:void(0);" onclick="descargar_ajax(${linea.id_linea_captura});"> Descargar </a>
                        </td>
                    <tr>`);


                              });

                                   $('.pagina_total_texto').html(response.response_pag['paginas_totales']);
                                $('#paginas_totales').val(response.response_pag['paginas_totales'])

                    $('#body-table1').html(body);




                }else{
                    body=body.concat(`<tr>
                        <td colspan="5">
                                          <td colspan="5"><h3>Sin datos relacionados</h3></td>
                                          <tr>`);
                                            $('#body-table1').html(body);
                }
            }


        });
    }

}




      </script>
    @endsection
