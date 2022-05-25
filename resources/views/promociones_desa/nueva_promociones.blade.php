@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp
 
@extends('layouts.index')
 
@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Promociones</li>
        <li class="breadcrumb-item active" aria-current="page">Nueva</li>
    </ol>
    <h6 class="slim-pagetitle">Nueva Promoción</h6>
@endsection

@section('contenido-principal') 

    <div class="section-wrapper">
        <div class="row">
            <div class="col-lg-8">
                <h3 class="card-profile-name">Nueva promoción</h3>
            </div>
            <div class="col-lg-4">
                <!--        
                <div class="form-group mg-b-10-force filtro_tocas_turnados" >
                    <label class="ckbox" style="width: 150px;">
                        <input type="checkbox" name="bandera_toca_turnado" value="1" onclick="accionBuscarArchivo_ajax();"><span>Tocas turnados</span>
                    </label>
                </div>
                -->
            </div>
        </div>
        
        @isset($sesion['succes'])
        <div class="alert alert-success" role="alert">
            <strong>{!!$sesion['succes']!!}</strong>
          </div><!-- alert -->
        @endisset

        @isset($sesion['error'])
          <div class="alert alert-danger" role="alert">
            <strong>{!!$sesion['error']!!}</strong>
          </div><!-- alert -->
        @endisset
          
        <form method="POST" action="{{ route('promociones.promocion_guardar') }}" enctype="multipart/form-data" id="forma_guardar" name="registration" onsubmit="return validateForm()">
            <input type="hidden" value="1" id="bandera_metodo_recepcion" name="bandera_metodo_recepcion">
            <input type="hidden" value="0" id="id_juicio_promocion" name="id_juicio_promocion">
            <input type="hidden" value="0" id="juicio_promocion" name="juicio_promocion">
            <div class="table-wrapper">
                <div class="form-layout">
                    <div class="row ">
                        <div class="form-group col-lg-10">
                            <table width="100%">
                                <tr>
                                    <td style="width:30%;"><input class="form-control" type="text" name="toca" id="toca" value="" placeholder="" onkeyup="limpiarValidacion()" required></td>
                                    <td><center>/</center></td>
                                    <td style="width:30%;">
                                        <select class="form-control select2" data-placeholder="" id="anio_toca" style="width:100%;" onchange="limpiarValidacion()">
                                            @for($i=request()->entorno['variables_entorno']['ANIO_FIN']; $i>=request()->entorno['variables_entorno']['ANIO_INICIO']; $i--)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>

                                    </td>
                                    <td><center> {{$request->lang['/']}} </center></td>
                                    <td style="width:30%;"><input class="form-control" type="text" name="asunto_toca" id="asunto_toca" value="" placeholder="" onkeyup="limpiarValidacion()"></td>
                                </tr>
                            </table>
                        
                        </div>

                        <div class="form-group col-lg-2">
                            <button class="btn btn-success bd-0" data-toggle="modal" data-target="#modaldemo3" onclick="validarToca();" type="button">Validar</button>
                        </div>
                    </div><!-- col-4 -->
                </div>

                <div class="row mg-b-25 mg-t-25">
                    <div class="col-lg-12" id="informacion_toca">
                    
                    </div>


                    <div class="col-lg-12">
                    <h5>Información de la promoción</h5>
                    </div>
                    <div class="col-lg-4 mg-b-10-force">
                        <div class="form-group">
                            <label class="form-control-label">Fecha de recepción: <span class="tx-danger">*</span></label>
                            <div class="input-group" style="width:100%;">
                                <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                </div>
                                </div>
                                <input type="text" class="form-control fc-datepicker" value="{{date('Y-m-d')}}" name="fechaRecepcion" id="fechaRecepcion" readonly="readonly" required>
                            </div>
                        </div>
                    </div><!-- col-4 -->


                    <div class="col-lg-4 mg-b-10-force">
                        <div class="form-group">
                            <label class="form-control-label">Hora de recepción: <span class="tx-danger">*</span></label>
                            



                               <div class="d-flex">
                                <div class="input-group wd-150">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                    </div><!-- input-group-text -->
                                  </div><!-- input-group-prepend -->
                                    <input id="tp3" name="tp3" type="text" class="form-control" placeholder="" required value="{{date('H:i')}}">
                                </div><!-- input-group -->
                                <!--
                                <button id="setTimeButton" class="btn btn-primary mg-l-10" type="button">Ahora</button>
                                -->
                              </div>



                        </div>
                    </div><!-- col-4 -->

                    
                    <div class="col-lg-4 mg-b-10-force">
                    <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Tipo de promoción: <span class="tx-danger">*</span></label>
                        <select class="form-control select2" data-placeholder="Choose country" name="tipoDocumento" >
                            <!--<option value="INIC" disabled>Demanda</option>-->
                            <option value="POS" selected>Promoción</option>
                        </select>
                    </div>
                    </div><!-- col-4 -->
                    <div class="col-lg-4 ">
                    <div class="form-group mg-b-10-force">

                        
                        <label class="form-control-label">Estatus del pago de traslado: </label>
                            <label class="ckbox">
                              <input type="checkbox" id="estatus_traslado" name="estatus_traslado" value="1" ><span>Se ha pagado</span>
                            </label>
                          


                    </div>
                    </div><!-- col-4 -->
                    <div class="col-lg-4">
                    <div class="form-group mg-b-10-force">

                        
                        <label class="form-control-label">Fecha de pago: </label>
                        <input type="text" class="form-control fc-datepicker" value="{{date('Y-m-d')}}" name="fecha_pago_traslado" id="fecha_pago_traslado" readonly="readonly" >
                          


                    </div>
                    </div><!-- col-4 -->
                    <div class="col-lg-4">
                    <div class="form-group mg-b-10-force">

                        
                        <label class="form-control-label">Número de transacción: </label>
                        <input class="form-control" type="text" name="num_transaccion_traslado" id="num_transaccion_traslado" value="" placeholder=""  >
                          


                    </div>
                    </div><!-- col-4 -->
                    <div class="col-lg-12">
                    </div><!-- col-4 -->
                </div><!-- row -->
                







                <label class="section-title">Método de recepción</label>

                <div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed tx-gray-800 transition">
                                Adjuntar documento escaneado
                            </a>
                        </div><!-- card-header -->

                        <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="card-body">
                                
                                <div class="row mg-b-25 mg-t-25">
                                    <div class="col-lg-12">
                                        <h5>Selección del documento</h5>
                                    </div>
                                    <p class="card-profile-position">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                            <input type="hidden" value="localFile" id="localFile" name="uploadType">
                                            <label class="form-control-label" ><span class="tx-danger">*</span> Documento:</label>
                                                <div id="div_upload" class="field"  >
                                                <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_acuerdo" id="archivo_acuerdo" size="50" required style="width:100%;" accept=".pdf">
                                                
                                                </div>
                                            </div>
                                        </div><!-- col-2 -->
                                        </p>
                                    </div><!-- row -->
                                <div class="form-layout-footer">
                                    <button class="btn btn-primary btn-block mg-b-10" onclick="cambiarBandera(1);">Guardar promoción</button>
                                </div><!-- form-layout-footer -->



                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" role="tab" id="headingTwo">
                            <a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Crear carátula para escaner
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="card-body">
                            
                                <div class="row mg-b-25 mg-t-25">
                                    <div class="col-lg-4">
                                        <button class="btn btn-primary btn-block mg-b-10" onclick="cambiarBandera(2);">Crear carátula</button>
                                    </div>
                                    <div class="col-lg-8" id="lista_caratulas">
                                        
                                        




                                    </div>
                                    
                                </div>


                            </div>
                        </div>
                    </div>
                </div><!-- accordion -->





            </div><!-- form-layout -->
        </form>
    </div><!-- section-wrapper -->
@endsection

@section('seccion-estilos')
    
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
    <style>
        @media screen and (max-width: 600px) {
            .filtro_tocas_turnados{
                float: left !important;
            }
        }
        .filtro_tocas_turnados{
            float: right;
        }
        .redClass{
            background: #22558c;
        }
    </style>
@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/js/jquery.timepicker.js"></script>
@endsection

@section('seccion-scripts-functions')
<script>

    $('#setTimeButton').on('click', function (){
        $('#tp3').timepicker('setTime', new Date());
    });

    function cambiarBandera(opcion){
        $('#bandera_metodo_recepcion').val(opcion);
        if(opcion==1){
            $('#archivo_acuerdo').prop('required',true);
            $('#forma_guardar').attr('target', '_self');
        }
        else{
            $('#archivo_acuerdo').prop('required',false);
            $('#forma_guardar').attr('target', '_blank');
            cargarCaratulasPendinetes();
        }
    }

    function cargarCaratulasPendinetes(){
        $.ajax({
                type:'POST',
                url:'/promociones/cargar_caratulas_pendinetes',
                data:{ id_juicio:$('#id_juicio_promocion').val()  },
                success:function(data){
                    console.log(data);
                    $('#lista_caratulas').html(data);
                }
            });
    }

    function openDocumentoCaratula(id_promocion, metadatos){

        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "/promociones/cargar_caratulas_pdf");
        form.setAttribute("target", "view");

        var hiddenField = document.createElement("input"); 
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "metadatos");
        hiddenField.setAttribute("value", metadatos);
        form.appendChild(hiddenField);
        document.body.appendChild(form);


        var hiddenField = document.createElement("input"); 
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "id_promocion");
        hiddenField.setAttribute("value", id_promocion);
        form.appendChild(hiddenField);
        document.body.appendChild(form);


        window.open('', 'view');

        form.submit();
    }

    function limpiarValidacion(){
        $('#id_juicio_promocion').val(0);
        $('#informacion_toca').html('');
        $('#lista_caratulas').html('');
    }

    function validateForm(){
        if($('#id_juicio_promocion').val() == 0) {
            alert("Debe de validar el {{$request->lang['toca']}}.");
            return false;
        }
        if($('#fechaRecepcion').val() == ""){
            alert("La fecha de recepción es obligatoria.");
            $('#fechaRecepcion').focus();
            return false;
        }
    }

    function validarToca(){
        if($('#toca').val()==""){

            alert("El número de {{$request->lang['toca']}} es obligatorio");
            setTimeout(function(){
                $('#modaldemo3').modal('hide');
            },500);

        }
        else{
            $('#modaldemo3').find('.modal-header').html('');
            $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
            $.ajax({
                type:'POST',
                url:'/promociones/validarToca',
                data:{ toca:$('#toca').val(), anio_toca:$('#anio_toca').val(), asunto_toca:$('#asunto_toca').val()  },
                success:function(data){
                    console.log(data);
                    $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                    $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
                }
            });
        }
    }

    function confirmarPromocion(promocion_id, expediente){
        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/promociones/buscarExpediente',
            data:{ promocion_id:promocion_id, expediente:expediente },
            success:function(data){
                console.log(data);
                $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });


    }

    $(document).ready(function() {
   
        'use strict';
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

        //fechas
        $('.fc-datepicker').datepicker({
            language: 'es',
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: 'yyyy-mm-dd',
            maxDate: new Date()
        });

        $('#tp3').timepicker({'scrollDefault': 'now', 'timeFormat': 'H:i'});

        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 500);
    });
    
    function openDocumentoGestor(id){
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "/descargarGestor");
        form.setAttribute("target", "view");

        var hiddenField = document.createElement("input"); 
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "idGlobal");
        hiddenField.setAttribute("value", id);
        form.appendChild(hiddenField);
        document.body.appendChild(form);

        window.open('', 'view');

        form.submit();
    }

    $('input[type="file"]').on('change', function(){
      var ext = $( this ).val().split('.').pop();
      if ($( this ).val() != '') {
        if(ext == "pdf" ){
          
        }
        else
        {
          alert("Extensión no permitida: " + ext);
        }
      }
    });

</script>

@endsection

@section('seccion-modales')

<!-- LARGE MODAL -->
<div id="modaldemo3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-lg modal-dialog-vertical-center modal-dialog-centered" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm" >
        <div class="modal-header pd-x-20">
        </div>
        <div class="modal-body pd-20">
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

@endsection