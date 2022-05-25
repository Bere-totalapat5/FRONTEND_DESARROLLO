@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index') 

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/acuerdo_detalles/{{$acuerdo_detalle['response'][0]['id_juicio']}}">Resumen toca</a></li>
        <li class="breadcrumb-item active" aria-current="page">Flujo del acuerdo</li>
    </ol>
    <h6 class="slim-pagetitle">Flujo del acuerdo</h6>
@endsection

@section('contenido-principal')
@if($error!="")
    <div class="alert alert-warning mg-b-0" role="alert">
      <strong>ALERTA</strong> {{$error}}
    </div><!-- alert -->
@endif
    <div class="section-wrapper" >
        <div class="table-wrapper" >
          <div class="media-body">
            <h4 class="card-profile-name">Datos del acuerdo {{$acuerdo_detalle['response'][0]['acuerdo']}}</h4>
            <p class="card-profile-position">
              <table style="width:100%;">
                <tr>
                  <td class="wd-20p">
                    @isset($archivo_detalle['response']['partes']['partes']['actor'])
                      <strong >ACTOR</strong><br>
                      @foreach ($archivo_detalle['response']['partes']['partes']['actor'] as $parte)
                          <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['nombres']}} {{$parte['apeliido_paterno']}} {{$parte['apellido_materno']}}</div>
                      @endforeach
                    @endisset
                  </td>
                  
                  @isset($archivo_detalle['response']['partes']['partes']['demandado'])
                    <td class="wd-5p">
                      VS
                    </td>
                  @endisset

                  @isset($archivo_detalle['response']['partes']['partes']['demandado'])
                    <td class="wd-20p">
                        <strong >DEMANDADO</strong><br>
                        @foreach ($archivo_detalle['response']['partes']['partes']['demandado'] as $parte)
                            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['nombres']}} {{$parte['apeliido_paterno']}} {{$parte['apellido_materno']}}</div>
                        @endforeach
                    </td>
                  @endisset

                  @isset($archivo_detalle['response']['partes']['partes']['terceros'])
                    <td class="wd-5p">
                      VS
                    </td>
                  @endisset
                  @isset($archivo_detalle['response']['partes']['partes']['terceros'])
                    <td class="wd-20p">
                      <strong >TERCERO</strong><br>
                      @foreach ($archivo_detalle['response']['partes']['partes']['terceros'] as $parte)
                          <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['nombres']}} {{$parte['apeliido_paterno']}} {{$parte['apellido_materno']}}</div>
                      @endforeach
                    </td>
                  @endisset
                </tr>
              </table>
            </p>
          </div>
          <hr>

          <form method="POST" action="{{ route('acuerdo_flujo.guardar') }}" enctype="multipart/form-data" name="registration">

            <h5 class="card-profile-name">Selecciona el documento</h5>
              <p class="card-profile-position">
                <div class="col-lg-12">
                  <div class="form-group">
                    <input type="hidden" value="localFile" id="localFile" name="uploadType">
                    <label class="form-control-label" ><span class="tx-danger">*</span> Documento:</label>
                      <div id="div_upload" class="field"  >
                        <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_acuerdo" id="archivo_acuerdo" size="50" required style="width:100%;" accept=".doc, .docx">
                        
                      </div>
                  </div>
                </div><!-- col-2 -->
              </p>
            <br><br>

            <h5 class="card-profile-name">Selecciona a los usuarios del flujo</h5>
            <input type="hidden" id="archivo_id" name="archivo_id" value="{{$archivo_id}}">
            <input type="hidden" id="acuerdo_id" name="acuerdo_id" value="{{$acuerdo_id}}">
            <input type="hidden" id="organo_acuerdo" name="organo_acuerdo" value="{{$archivo_detalle['response']['datos_toca'][0]['juzgado']}}">
            
            <div class="media-body table-responsive-xl" style="">
              <table width=100%; class="table table-borderless " style="width:100%;">
                <thead>
                <tr>
                  <th colspan="2" style="border-right:1px solid #cccccc; width:30%;">
                    <center>Usuario</center>
                  </th>
                  <th rowspan="2" style="border-right:1px solid #cccccc; width:20%;">
                    Rol
                  </th>
                  <th rowspan="2" style="border-right:1px solid #cccccc; width:10%;">
                    Acción
                  </th>
                  <th rowspan="2" style="border-right:1px solid #cccccc; width:20%;">
                    Fecha y Hora
                  </th>
                  <th rowspan="2" style="border-right:1px solid #cccccc; width:10%;">
                    Estatus
                  </th>
                  <th rowspan="2" style="border-right:1px solid #cccccc; width:10%;">
                    Acciones
                  </th>
                </tr>
                <tr>
                  <td style="border-right:1px solid #cccccc;">
                    Clave
                  </td>
                  <td>
                    Nombre
                  </td>
                </tr>
              </thead>
                <tr>
                  <td style="background-color:#22558c;"></td>
                  <td colspan="5" style="background-color:#22558c; color:#FFFFFF;">
                    <center>CREACIÓN</center>
                  </td>
                  <td style="background-color:#22558c;"></td>
                </tr>
                <tr>
                  <td colspan="7" style="padding: 0px;">

                    @isset($flujo_detalle['response']['creador'])
                      @foreach ($flujo_detalle['response']['creador'] as $usuarios)

                        <input type="hidden" id="clave" name="datos[creador][clave][]" value="{{strtoupper($usuarios['clave'])}}">
                        <input type="hidden" id="ministerio_ley" name="datos[creador][ministerio_ley][]" value="0">
                        <input type="hidden" id="id_flujo_sala" name="datos[creador][id_flujo_sala][]" value="">
                        <input type="hidden" id="eliminacion" name="datos[creador][eliminacion][]" value="0">
                        <input type="hidden" id="nombre" name="datos[creador][nombre][]" value="{{ucwords(strtolower($usuarios['nombre']))}}">
                        <input type="hidden" id="rol" name="datos[creador][rol][]" value="{{ucwords(strtolower($usuarios['rol']))}}">
                        <input type="hidden" id="accion" name="datos[creador][accion][]" value="{{$usuarios['accion']}}">
                        <input type="hidden" id="fecha_hora" name="datos[creador][fecha_hora][]" value="{{$usuarios['fecha_hora']}}">
                        <input type="hidden" id="estatus" name="datos[creador][estatus][]" value="{{$usuarios['estatus']}}">
                        <input type="hidden" id="id_usuario" name="datos[creador][id_usuario][]" value="{{$usuarios['id_usuario']}}">
                        <input type="hidden" id="codigo_organo_pertenece" name="datos[creador][codigo_organo_pertenece][]" value="{{$usuarios['codigo_organo_pertenece']}}">
                        @isset($usuarios['en_calidad'])
                          <input type="hidden" id="en_calidad" name="datos[creador][en_calidad][]" value="{{$usuarios['en_calidad']}}">
                        @else
                          <input type="hidden" id="en_calidad" name="datos[creador][en_calidad][]" value="">
                        @endisset

                        <table style="width:100%;"  class="table-borderless">
                          <tr>
                            <td style="border:none; border-right:1px solid #eef0f6; border-left:1px solid #eef0f6; padding-left:0px; width:15%;">
                              {{strtoupper($usuarios['clave'])}}
                            </td>
                            <td style="border:none; border-right:1px solid #eef0f6; padding-left:0px; width:15%;">
                              {{ucwords(strtolower($usuarios['nombre']))}}
                            </td>
                            <td style="border:none; border-right:1px solid #eef0f6; padding-left:0px; width:20%;">
                              @if(ucwords(strtolower($usuarios['rol']))=="Juez Magistrado")Magistrado @isset($usuarios['en_calidad']) {{ucwords(strtolower($usuarios['en_calidad']))}} @endisset @else {{ucwords(strtolower($usuarios['rol']))}} @endif
                            </td>
                            <td style="border:none; border-right:1px solid #eef0f6; padding-left:0px; width:10%;">
                              creador
                            </td>
                            <td style="border:none; border-right:1px solid #eef0f6; padding-left:0px; width:20%;">
                              {{$usuarios['fecha_hora']}}<br>
                              @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($usuarios["fecha_hora"]); print($fechaCreacion); @endphp
                            </td>
                            <td style="border:none; padding-left:0px; width:10%;">
                              {{$usuarios['estatus']}}
                            </td>
                            <td style="border:none; padding-left:0px; width:10%;">
                              
                            </td>
                          </tr>
                        </table>

                      @endforeach
                    @endisset

                  </td>
                </tr>
                <tr>
                  <td style="background-color:#22558c;">
                    <a href="" data-toggle="modal" data-target="#modaldemo3" style=" color:#FFFFFF;" onclick="showUsuarios('sortable_revision', {{$con_excusa}});">Agregar</a>
                  </td>
                  <td colspan="5" style="background-color:#22558c; color:#FFFFFF;">
                    <center>REVISIÓN</center>
                  </td>
                  <td style="background-color:#22558c;"></td>
                </tr>
                <tr>
                  <td colspan="7" style="padding:0px; margin:0px;">
                    <ul class="list-group" id="sortable_revision"  >

                      @isset($flujo_detalle['response']['revisores'])
                        @foreach ($flujo_detalle['response']['revisores'] as $usuarios)

                          <li class="list-group-item @if($loop->first) ui-state-disabled @endif" style="padding:0px; margin:0px; " id="bloque_revision_{{strtoupper($usuarios['clave'])}}">
                            <input type="hidden" id="clave" name="datos[revisores][clave][]" value="{{strtoupper($usuarios['clave'])}}">
                            <input type="hidden" id="ministerio_ley" name="datos[revisores][ministerio_ley][]" value="0">
                            <input type="hidden" id="id_flujo_sala" name="datos[revisores][id_flujo_sala][]" value="">
                            <input type="hidden" id="eliminacion" name="datos[revisores][eliminacion][]" value="0">
                            <input type="hidden" id="nombre" name="datos[revisores][nombre][]" value="{{ucwords(strtolower($usuarios['nombre']))}}">
                            <input type="hidden" id="rol" name="datos[revisores][rol][]" value="{{ucwords(strtolower($usuarios['rol']))}}">
                            <input type="hidden" id="accion" name="datos[revisores][accion][]" value="{{$usuarios['accion']}}">
                            <input type="hidden" id="fecha_hora" name="datos[revisores][fecha_hora][]" value="{{$usuarios['fecha_hora']}}">
                            <input type="hidden" id="estatus" name="datos[revisores][estatus][]" value="{{$usuarios['estatus']}}">
                            <input type="hidden" id="id_usuario" name="datos[revisores][id_usuario][]" value="{{$usuarios['id_usuario']}}">
                            <input type="hidden" id="codigo_organo_pertenece" name="datos[revisores][codigo_organo_pertenece][]" value="{{$usuarios['codigo_organo_pertenece']}}">
                            @isset($usuarios['en_calidad'])
                              <input type="hidden" id="en_calidad" name="datos[revisores][en_calidad][]" value="{{ucwords(strtolower($usuarios['en_calidad']))}}">
                            @else
                              <input type="hidden" id="en_calidad" name="datos[revisores][en_calidad][]" value="">
                            @endisset

                            <table style="width:100%;" style="border:none;" class="table-borderless">
                              <tr>
                                <td style="border:none; border-right:1px solid #eef0f6; padding-right:0px; padding-left:0px; width:15%;">
                                  {{strtoupper($usuarios['clave'])}}
                                </td>
                                <td style="border:none; border-right:1px solid #eef0f6; padding-right:0px; padding-left:0px; width:15%;">
                                  {{ucwords(strtolower($usuarios['nombre']))}}
                                </td>
                                <td style="border:none; border-right:1px solid #eef0f6; padding-right:0px; padding-left:0px; width:20%;">
                                  @if(ucwords(strtolower($usuarios['rol']))=="Juez Magistrado")Magistrado @isset($usuarios['en_calidad']) {{ucwords(strtolower($usuarios['en_calidad']))}} @endisset @else {{ucwords(strtolower($usuarios['rol']))}} @endif
                                </td>
                                <td style="border:none; border-right:1px solid #eef0f6; padding-right:0px; padding-left:0px; width:10%;">
                                  revisión
                                </td>
                                <td style="border:none; border-right:1px solid #eef0f6; padding-right:0px; padding-left:0px; width:20%;">
                                  
                                </td>
                                <td style="border:none; padding-right:0px; padding-left:0px; width:10%;">
                                  @if($loop->first) activo @else espera @endif
                                </td>
                                <td style="border:none; padding-right:0px; padding-left:0px; width:10%;">
                                  @if($loop->first)  @else <a href="javascript:void(0)" onclick="eliminarUsuarioFlujo(this)">Eliminar</a> @endif
                                </td>
                              </tr>
                            </table>
                          </li>

                        @endforeach
                      @endisset
                      
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="background-color:#22558c;">
                    <a href="" data-toggle="modal" data-target="#modaldemo3" style=" color:#FFFFFF;" onclick="showUsuarios('sortable_firmas', {{$con_excusa}});">Agregar</a>
                  </td>
                  <td colspan="5" style="background-color:#22558c; color:#FFFFFF;">
                    <center>FIRMAS</center>
                  </td>
                  <td style="background-color:#22558c;"></td>
                </tr>
                <tr>
                  <td colspan="7" style="padding:0px; margin:0px; ">

                    <ul class="list-group" id="sortable_firmas" class="sortable">
                      
                    @isset($flujo_detalle['response']['firmas'])
                      @foreach ($flujo_detalle['response']['firmas'] as $usuarios)

                        <li class="list-group-item" style="padding:0px; margin:0px; " id="bloque_firma_{{strtoupper($usuarios['clave'])}}">
                          <input type="hidden" id="clave" name="datos[firmas][clave][]" value="{{strtoupper($usuarios['clave'])}}">
                          
                          <input type="hidden" id="id_flujo_sala" name="datos[firmas][id_flujo_sala][]" value="">
                          <input type="hidden" id="eliminacion" name="datos[firmas][eliminacion][]" value="0">
                          
                          
                          
                          <input type="hidden" id="ministerio_ley" name="datos[firmas][ministerio_ley][]" value="0">

                          <input type="hidden" id="nombre" name="datos[firmas][nombre][]" value="{{ucwords(strtolower($usuarios['nombre']))}}">
                          <input type="hidden" id="rol" name="datos[firmas][rol][]" value="{{ucwords(strtolower($usuarios['rol']))}}">
                          <input type="hidden" id="accion" name="datos[firmas][accion][]" value="{{$usuarios['accion']}}">
                          <input type="hidden" id="fecha_hora" name="datos[firmas][fecha_hora][]" value="{{$usuarios['fecha_hora']}}">
                          <input type="hidden" id="estatus" name="datos[firmas][estatus][]" value="{{$usuarios['estatus']}}">
                          <input type="hidden" id="id_usuario" name="datos[firmas][id_usuario][]" value="{{$usuarios['id_usuario']}}">
                          <input type="hidden" id="codigo_organo_pertenece" name="datos[firmas][codigo_organo_pertenece][]" value="{{$usuarios['codigo_organo_pertenece']}}">
                          @isset($usuarios['en_calidad'])
                            <input type="hidden" id="en_calidad" name="datos[firmas][en_calidad][]" value="{{$usuarios['en_calidad']}}">
                          @else
                            <input type="hidden" id="en_calidad" name="datos[firmas][en_calidad][]" value="">
                          @endisset
                          
                          <table style="width:100%;" style="border:none; font-size:9px;" class="table-borderless">
                            <tr>
                              <td style="border:none; border-right:1px solid #eef0f6; padding-left:0px; width:15%;">
                                {{strtoupper($usuarios['clave'])}}
                              </td>
                              <td style="border:none; border-right:1px solid #eef0f6; padding-left:0px; width:15%;">
                                {{$usuarios['nombre']}}
                              </td>
                              <td style="border:none; border-right:1px solid #eef0f6; padding-left:0px; width:20%;">
                                @if(ucwords(strtolower($usuarios['rol']))=="Juez Magistrado")Magistrado @isset($usuarios['en_calidad']) {{ucwords(strtolower($usuarios['en_calidad']))}} @endisset @else {{ucwords(strtolower($usuarios['rol']))}} @endif
                              </td>
                              <td style="border:none; border-right:1px solid #eef0f6; padding-left:0px; width:10%;">
                                firma
                              </td>
                              <td style="border:none; border-right:1px solid #eef0f6; padding-left:0px; width:20%;">
                                
                              </td>
                              <td style="border:none; padding-left:0px; width:10%;">
                                espera
                              </td>
                              <td style="border:none; padding-left:0px; width:10%;">
                                <a href="javascript:void(0)" onclick="eliminarUsuarioFlujo(this)">Eliminar</a>
                              </td>
                            </tr>
                          </table>
                        </li>

                      @endforeach
                    @endisset

                    </ul>
                  </td>
                </tr>
              </table>

              <div class="row">
                <div class="col-md-12 col-lg-12">
                  <button class="btn btn-success btn-block mg-b-10" >Guardar</button>
                </div><!-- col-4 -->
              </div>
            </div>
          </form>
        </div><!-- table-wrapper -->
    </div><!-- section-wrapper -->
@endsection

@section('seccion-estilos')
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    <style>
      .ui-state-disabled{
        opacity: 1 !important;
        pointer-events: auto !important;
      }
    </style>
@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
    <script src="/box/js/jquery-ui.js"></script>
    <script  src="/box/js/jquery.validate.js"></script>
@endsection
 
@section('seccion-scripts-functions')


<script type="text/javascript">
  $(function() {
    jQuery.extend(jQuery.validator.messages, {
      required: "<h4 style='color:red;'>Este campo es obligatorio.</h4>",
      remote: "Please fix this field.",
      email: "Please enter a valid email address.",
      url: "Please enter a valid URL.",
      date: "Please enter a valid date.",
      dateISO: "Please enter a valid date (ISO).",
      number: "Please enter a valid number.",
      digits: "Please enter only digits.",
      creditcard: "Please enter a valid credit card number.",
      equalTo: "Please enter the same value again.",
      accept: "Please enter a value with a valid extension.",
      maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
      minlength: jQuery.validator.format("Please enter at least {0} characters."),
      rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
      range: jQuery.validator.format("Please enter a value between {0} and {1}."),
      max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
      min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
    });
    
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='registration']").validate({
      // Make sure the form is submitted to the destination defined
      // in the "action" attribute of the form when valid
      submitHandler: function(form) {

        //se obtienen los ids
        num_personas=0;
        num_secretarios=0;
        es_juez=0;
        es_secretario=0;
        
        $('#sortable_firmas li').each(function( index ) {
          num_personas++;
          
          if($( this ).find('#rol').val().toLowerCase().includes( 'acuerdo' ) || $( this ).find('#rol').val().toLowerCase().includes( 'asuntos' ) || $( this ).find('#rol').val().toLowerCase().includes( 'amparos' )){
            es_secretario=1;
            num_secretarios++;
          }
          if($( this ).find('#rol').val().toLowerCase().includes( 'magistrado' ) || $( this ).find('#rol').val().toLowerCase().includes( 'proyectista' )){
            es_juez=1;
          }
        });
        
        if(num_personas<=1){
          alert('Mínimo deben de ser dos firmantes.');
        }
        else if(es_secretario==0){
          alert('Debe de escoger uno de la Secretaría Auxiliar.');
        }
        else if(num_secretarios>=2){
          alert('Solo puede firmar uno de la Secretaría Auxiliar.');
        }
        else if(es_juez==0){
          alert('Debe de escoger al menos un Magistrado.');
        }
        else{
          //agregarLoading();
          setTimeout(function(){
            //alert('guardo');
            form.submit();
          },1000);
        }
      }
    });
  });
</script>



<script>

  function showUsuarios(firma_ul, excusa){
    $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
    
    //se obtienen los ids
    arr_firmantes='';
    
    $('#'+firma_ul+' li').each(function( index ) {
      
      arr_firmantes+=$( this ).find('#id_usuario').val()+','
      //console.log( index + ": " + $( this ).find('#id_usuario').val() );
    });
    
    if(excusa==0){
      excusa="";
    }
    
    $.ajax({
        type:'POST',
        url:'/acuerdo_flujo_participantes',
        data:{ firma_ul:firma_ul, arr_firmantes:arr_firmantes, excusa:excusa },
        success:function(data){
            console.log(data);
            $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
        }
    });
  }

  function eliminarUsuarioFlujo(obj){
    $(obj).parent().parent().parent().parent().parent().remove();
  }


  $(function(){
    'use strict';
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

    $("#sortable_revision").sortable({
      cancel: ".ui-state-disabled",
      items: "li:not(.ui-state-disabled)"
    });

    $("#sortable_firmas").sortable({
      cancel: ".ui-state-disabled"
    });

    setTimeout(function(){
      $('input[type="file"]').on('change', function(){
        var ext = $( this ).val().split('.').pop();
        if ($( this ).val() != '') {
          if(ext == "doc" || ext == "docx"){

          }
          else
          {
            alert("Extensión no permitida: " + ext);
          }
        }
      });

      $('#modal_loading').modal('hide');
    }, 1000);
  });

  function agregarLoading(){
    $('#modal_loading').modal({backdrop: 'static', keyboard: false})
  }
</script>
@endsection

@section('seccion-modales')
<!-- LARGE MODAL -->
<div id="modaldemo3" class="modal fade" style="width: 95%;">
  <div class="modal-dialog modal-dialog-vertical-center" role="document" >
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agrega un usuario al flujo </h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body pd-20">

      </div><!-- modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalUsuarios">Cerrar</button>
      </div>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->
@endsection