@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
    use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Notificaciones</li>
        <li class="breadcrumb-item active" aria-current="page">@if($bandeja!="notificado") Sin notificar @else Notificados @endif</li>
    </ol>
    <h6 class="slim-pagetitle">Lista de acuerdos @if($bandeja!="notificado") sin notificar @else notificados @endif</h6>
@endsection

@section('contenido-principal')

<!--
<div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true" style="margin-bottom:10px;">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
        Busqueda Avanzada
      </a>
    </div><!-- card-header -- >

    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-body">
       
          <div class="form-layout">
              <div class="row mg-b-0">
                  
                  <div class="col-lg-12">
                  <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Solicitud:</label>
                  <input class="form-control" type="text" name="folio" id="folio" value="" placeholder="Número">
                  
                  </div>
              </div><!-- col-4 -- >
              

              <div class="col-lg-12">
                  <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Registro: </label>
                  
                  <table style="width:100%;">
                          <tr>
                              <td style="width:10%;">Desde </td>
                              <td style="width:30%;">
                                  <div class="input-group" style="width:100%;">
                                      <div class="input-group-prepend">
                                      <div class="input-group-text">
                                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                      </div>
                                      </div>
                                      <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" name="fecha_desde" id="fecha_desde" readonly="readonly">
                                  </div>
                                  </td>
                              <td> &nbsp; &nbsp; &nbsp;</td>
                              <td style="width:10%;">Hasta </td>
                              <td style="width:30%;">
                                  <div class="input-group">
                                      <div class="input-group-prepend">
                                      <div class="input-group-text">
                                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                      </div>
                                      </div>
                                      <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" name="fecha_hasta" id="fecha_hasta" readonly="readonly">
                                  </div>
                              </td>
                          </tr>
                      </table>
                  </div>
              </div><!-- col-4 -- >
              <div class="col-lg-12">
                  <button class="btn btn-primary btn-sm btn-block mg-b-10" onclick="accionBuscar_ajax();">Buscar Solicitud</button>
              </div>
              </div><!-- row -- >
          </div>
      </div>
  </div>
</div>
</div>

-->


@if(isset($request->menu_general['response']) and !utilidades::buscarPermisoMenu($request->menu_general['response'], 1073) and request()->is('notificaciones/notificado'))
  <div class="section-wrapper">
    <BR><h1 style="text-align: center;">USTED NO TIENE AUTORIZACIÓN DE VER ESTA PÁGINA</h1>
  </div>
@elseif(isset($request->menu_general['response']) and !utilidades::buscarPermisoMenu($request->menu_general['response'], 1074) and request()->is('notificaciones/sin_notificar'))
  <div class="section-wrapper">
    <BR><h1 style="text-align: center;">USTED NO TIENE AUTORIZACIÓN DE VER ESTA PÁGINA</h1>
  </div>
@elseif(!isset($request->menu_general['response']))
  <div class="section-wrapper">
    <BR><h1 style="text-align: center;">USTED NO TIENE AUTORIZACIÓN DE VER ESTA PÁGINA</h1>
  </div>
@else


    <div class="section-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="card-profile-name">Lista de acuerdos @if($bandeja!="notificado")sin notificar @else notificados @endif</h3>
            </div>
            <div class="col-lg-12 mg-t-20">

              <div style="float: left;">
                
            </div>
            <div style="float: right">
                
              
            </div>


                <div style="" >
                  <table id="datatable1" class="table display responsive nowrap">
                    <thead>
                    <tr>
                        <th class="romperCadena">Fecha publicación</th>
                        <th>Acuerdo</th>
                        <th>{{$request->lang['Ponencia']}}</th>
                        <!--
                        <th>Tipo Notificación</th>
                        -->
                        @if($request->session()->get('tipo_usuario_descripcion')=="actuario" or $request->session()->get('tipo_usuario_descripcion')=="auxiliar")
                          @if($bandeja!='notificado' and $bandeja!='fisicas_notificados' and $bandeja!="revision_info")
                            <th>Acciones</th>
                          @else
                            @if($bandeja=="revision_info")
                              <th class="romperCadena">Fecha de envio a revisión</th>
                              <th class="romperCadena">Partes</th>
                            @else
                              <th class="romperCadena">Fecha de envío notificación</th>
                              <th class="romperCadena">Usuarios notificados</th>
                            @endif
                             
                          @endif
                        @else
                          @if($bandeja=='notificado')
                            <th class="romperCadena">Fecha de envío notificación</th>
                            <th class="romperCadena">Usuarios notificados</th>
                          @elseif($bandeja=="fisicas_notificados")
                            <th class="romperCadena">Fecha de inicio notificación</th>
                            <th class="romperCadena">Usuarios notificados</th>
                            @elseif($bandeja=="revision_info")
                            <th class="romperCadena">Fecha de envio a revisión</th>
                            <th class="romperCadena">Acciones</th>
                          @endif
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                      
                      @isset($lista['response'])
                        
                        @php $i=0; @endphp
                        
                        
                        @foreach ($lista['response'] as $solicitud)
                       
                          @if($solicitud['acuerdo_url_doc_noti']!="")
                            <tr id="data-row-id-{{$i}}">
                              <td>
                                @php $arr_fecha=explode(' ', $solicitud['fecha_publicacion']); @endphp {{$arr_fecha[0]}}</td>

                              
                              
                              <td>{{$solicitud['acuerdo']}}<br>{{utilidades::acomodarTipoExpedienteTxt($solicitud['tipo_expediente'])}}</td>
                              
                              <td>{{$solicitud['secretaria']}}</td>


                              <!--
                              <td>@if($solicitud['acuerdo_tipo_noti_elect']==1)  Articulo 113 @elseif($solicitud['acuerdo_tipo_noti_elect']==2) Correo del actuario @else Notificación física @endif</td>
                              -->

                              @if($request->session()->get('tipo_usuario_descripcion')=="actuario" or $request->session()->get('tipo_usuario_descripcion')=="auxiliar")
                                @if($bandeja!='notificado' and $bandeja!='fisicas_notificados' and $bandeja!="revision_info")
                                
                                  @if(isset($solicitud['tipo_notificacion']) && $solicitud['tipo_notificacion']=='3')
                                  <td>
                                      <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cambiarNotificacionFisica('{{$solicitud['id_noti_elect']}}', {{$i}});">Confimar notificación</a>
                                      <br><a href="/notificacion/{{$solicitud['id_acuerdo']}}_{{$solicitud['id_parte']}}_3.pdf" target="_blank" onclick="">Ver documento</a>
                                    </td>
                                  @elseif(isset($solicitud['noti_elect_estatus_correccion']) and ($solicitud['noti_elect_estatus_correccion']=='correccion_actuario' or $solicitud['noti_elect_estatus_correccion']=='datos_correctos_sa'))
                                    <td><a href="javascript:void(0);" onclick="obtenerInformacionActuario({{$solicitud['id_acuerdo']}}, 'bandejas_notificacion', {{$i}}, '{{$solicitud['codigo_organo']}}', {{$solicitud['id_juicio']}}, '{{$solicitud['acuerdo_url_doc_noti']}}', '{{$solicitud['id_acuerdo_notificacion']}}', '{{$solicitud['ultima_version_id']}}', '{{$solicitud['id_noti_elect']}}', '{{$solicitud['noti_elect_estatus_correccion']}}', '@php echo preg_replace("[\n|\r|\n\r]", "<br>", $solicitud['noti_elect_comentario_correccion']); @endphp', '{{$solicitud['id_parte']}}');">Obtener información</a>
                                      <br><a href="javascript:void(0);" onclick="vistaPrevia({{$solicitud['id_acuerdo']}}, '{{$solicitud['codigo_organo']}}', {{$solicitud['ultima_version_id']}}, 'pdf');">Ver resolución</a>
                                      </td>
                                  @elseif($solicitud['acuerdo_tipo_noti_elect']=='2' or 1)
                                  <td><a href="javascript:void(0);" onclick="obtenerInformacion({{$solicitud['id_acuerdo']}}, 'bandejas_notificacion', {{$i}}, '{{$solicitud['codigo_organo']}}', {{$solicitud['id_juicio']}}, '{{$solicitud['acuerdo_url_doc_noti']}}', '{{$solicitud['id_acuerdo_notificacion']}}', '{{$solicitud['ultima_version_id']}}');">Obtener información</a>
                                    <br><a href="javascript:void(0);" onclick="vistaPrevia({{$solicitud['id_acuerdo']}}, '{{$solicitud['codigo_organo']}}', {{$solicitud['ultima_version_id']}}, 'pdf');">Ver resolución</a>
                                    </td>
                                  @else
                                    <td>
                                      <a href="javascript:void(0);" onclick="cambiarNotificacion('{{$solicitud['id_acuerdo_notificacion']}}', {{$i}}, 0);">Confimar notificación</a>
                                      <br><a href="javascript:void(0);" onclick="vistaPrevia({{$solicitud['id_acuerdo']}}, '{{$solicitud['codigo_organo']}}', {{$solicitud['ultima_version_id']}}, 'pdf');">Ver resolución</a>
                                    </td>
                                  @endif
                                @else
                                  @if($bandeja=='revision_info')
                                    <td class="romperCadena">{{utilidades::acomodarFechaHora($solicitud['acuerdo_notificacion_creacion'])}}</td>
                                    <td class="romperCadena">{{$solicitud['datos_parte'][0]['parte_nombres']}}<br>{{$solicitud['datos_parte'][0]['parte_correo']}}<br><strong>Error reportado: {{$solicitud['noti_elect_comentario_correccion']}}</strong></td>
                                  @else
                                    <td class="romperCadena">
                                      {{utilidades::acomodarFechaHora($solicitud['acuerdo_notificacion_creacion'])}}
                                    </td>
                                    <td class="romperCadena">
                                      @if($bandeja=='fisicas_notificados')
                                        <a href="/notificacion/{{$solicitud['id_acuerdo']}}_{{$solicitud['id_parte']}}_3.pdf" target="_blank" onclick="">Ver documento</a>
                                      @else
                                        @isset($solicitud['notificaciones_leidas'][0]['id_lectura'])
                                          @foreach ($solicitud['notificaciones_leidas'] as $item)
                                            <span title="Correo: {{$item['correo']}}<br>Confirmación: {{$item['lectura_fecha']}}"><a href="javascript:void(0)">{{$item['usuario']}}</a></span><br>
                                          @endforeach
                                        @else
                                          <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo4" onclick="notificar_acuerdo_resumen({{$solicitud['id_acuerdo_notificacion']}} )">Detalles</a>  
                                        @endisset
                                      @endif
                                    </td>
                                  @endif
                                @endif
                              @else
                                  @if($bandeja=='notificado')
                                    <td class="romperCadena">{{utilidades::acomodarFechaHora($solicitud['acuerdo_notificacion_creacion'])}}</td>
                                    <td class="romperCadena">
                                      @isset($solicitud['notificaciones_leidas'][0]['id_lectura'])
                                        @foreach ($solicitud['notificaciones_leidas'] as $item)
                                          <span title="Correo: {{$item['correo']}}<br>Confirmación: {{$item['lectura_fecha']}}"><a href="javascript:void(0)">{{$item['usuario']}}</a></span><br>
                                        @endforeach
                                      @else
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo4" onclick="notificar_acuerdo_resumen({{$solicitud['id_acuerdo_notificacion']}} )">Detalles</a>  
                                      @endisset
                                    </td>
                                  @elseif($bandeja=="revision_info")
                                  <td class="romperCadena">{{utilidades::acomodarFechaHora($solicitud['acuerdo_notificacion_creacion'])}}</td>
                                  <td class="romperCadena">
                                    
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo4" onclick="consultarEstatusErrorParte({{$solicitud['id_noti_elect']}}, {{$solicitud['id_juicio']}}, {{$solicitud['id_parte']}}, '@php echo preg_replace("[\n|\r|\n\r]", "<br>", $solicitud['noti_elect_comentario_correccion']); @endphp')">Autorizar</a>  
                                    
                                  </td>

                                  @endif
                              @endif
                              
                            </tr>
                            @php $i++; @endphp
                            @endif
                        @endforeach
                      @endisset
    
    
                    </tbody>
                  </table>
            </div>
          </div>
        </div>
    </div>
@endif

@endsection

@section('seccion-estilos')
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/box/qtip2/jquery.qtip.css">
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/jquery.steps/css/jquery.steps.css" rel="stylesheet">
  <style>
    .romperCadena{
      word-wrap: break-word !important;
      white-space:normal !important;
    }
    #modaldemo_editar_html .modal-dialog {
        width: 100%;
        max-width:700px;
        height: 90%;
        margin: 0;
        padding: 0;
    }

    #modaldemo_editar_html .modal-content {
        height: auto;
        min-height: 90%;
        border-radius: 0;
    }

    .datepicker { z-index: 99009!important; }

  </style>
@endsection

@section('seccion-scripts-libs')
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery.steps/js/jquery.steps.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/parsleyjs/js/parsley.js"></script>

  <script type="text/javascript" src="/box/qtip2/jquery.qtip.js"></script>
@endsection

@section('seccion-scripts-functions')
  <script>

    var dataTableGlobal;
    var i_global=-1;
    $(document).ready(function() {
        var rows_selected = [];
        var table ;
        
        dataTableGlobal = table = $('#datatable1').DataTable( {
            "ordering": false,
            'columnDefs': [
            { responsivePriority: 1, targets: @if($request->session()->get('tipo_usuario_descripcion')=="actuario" or $request->session()->get('tipo_usuario_descripcion')=="auxiliar") @if($bandeja=='notificado') 4 @else 3 @endif @else 2 @endif },  
            { "targets": [0],  "orderable": false, "visible": true },
            { "targets": [1],  "orderable": false, "visible": true },
            { "targets": [2],  "orderable": false, "visible": true }
            ],
            bLengthChange: false,
            searching: false,
            responsive: true,
            pageLength: 10,

            'rowCallback': function(row, data, dataIndex){
                // Get row ID
                var rowId = data[0];

                // If row ID is in the list of selected row IDs
                if($.inArray(rowId, rows_selected) !== -1){
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                    $(row).addClass('selected');
                }
            }
        });

        /*
        // Handle click on table cells with checkboxes
        $('#datatable1').on('click', 'tbody td, thead th:first-child', function(e){
            $(this).parent().find('input[type="checkbox"]').trigger('click');
        });
        */

        
        //bandera para saber si hay firma el correo para actuario
        bandera_firmado_actuario=bandera_113=0;
        informacionFinal_inicio=informacionFinal_fisica="";
        var n=0;
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
        });

        stepsWizard=$('#wizard1').steps({
          headerTag: 'h3',
          bodyTag: 'section',
          autoFocus: true,
          titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
          labels: {
            cancel: "Cancelar",
            current: "Siguiente:",
            pagination: "Pagination",
            finish: "Confirmar notificación",
            next: "Siguiente",
            previous: "Anterior",
            loading: "Cargando ..."
          },
          onStepChanging: function (event, currentIndex, newIndex) { 
            console.log(currentIndex);
            if(currentIndex==0){
              informacionFinal_inicio="";
              guardarPartesNotificacion();

              //se revisa cada uno
              $( ".select_notificacion" ).each(function( index ) {
                if($(this).val()==2 && bandera_firmado_actuario==0){
                  bandera_firmado_actuario=1; 
                }

                if($(this).val()==1){
                  
                  bandera_error=0;
                  if($(this).parent().parent().parent().find('#noti_elect_estatus_correccion').is(':checked')) {
                    bandera_error=1;
                    comentarios="<strong>Información erronea reportada</strong><br>"+$(this).parent().parent().parent().find('#noti_elect_comentario_correccion').val();
                  }
                  else{
                    comentarios="Se enviará correo electrónico";
                  }
                  //informacionFinal_inicio+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="1"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#correo').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"><label class="ckbox "><input type="checkbox" class="ckbox_notificacion"><span> Notificado </span></label></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación electrónica por Artículo 113</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+$(this).parent().parent().parent().find('#tipo').val()+'<br></span>'+$(this).parent().parent().parent().find('#nombres').val()+' '+$(this).parent().parent().parent().find('#apellido_paterno').val()+' '+$(this).parent().parent().parent().find('#apellido_materno').val()+'</h5></div><div class="col-md-4"><h5 class="card-text">'+$(this).parent().parent().parent().find('#correo').val()+' </h5></div><div class="col-md-2">Se enviará correo electrónico</div></div></div></div></div>';
                  informacionFinal_inicio+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="1"><input type="hidden" id="noti_elect_estatus_correccion" value="'+bandera_error+'"><input type="hidden" id="noti_elect_comentario_correccion" value="'+$(this).parent().parent().parent().find('#noti_elect_comentario_correccion').val()+'"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#correo').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación electrónica por Artículo 113</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+$(this).parent().parent().parent().find('#tipo').val()+'<br></span>'+$(this).parent().parent().parent().find('#nombres').val()+' '+$(this).parent().parent().parent().find('#apellido_paterno').val()+' '+$(this).parent().parent().parent().find('#apellido_materno').val()+'</h5></div><div class="col-md-4"><h5 class="card-text">'+$(this).parent().parent().parent().find('#correo').val()+' </h5></div><div class="col-md-2">'+comentarios+'</div></div></div></div></div>';
                  bandera_113=1;
                  bandera_render=1;
                }


                if($(this).val()==2 && $(this).parent().parent().parent().find('#noti_elect_estatus_correccion').is(':checked')){
                  bandera_error=1;
                  bandera_firmado_actuario=0;
                  comentarios="<strong>Información erronea reportada</strong><br>"+$(this).parent().parent().parent().find('#noti_elect_comentario_correccion').val();
                  informacionFinal_inicio+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="2"><input type="hidden" id="noti_elect_estatus_correccion" value="'+bandera_error+'"><input type="hidden" id="noti_elect_comentario_correccion" value="'+$(this).parent().parent().parent().find('#noti_elect_comentario_correccion').val()+'"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#correo').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación electrónica por correo del actuario</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+$(this).parent().parent().parent().find('#tipo').val()+'<br></span>'+$(this).parent().parent().parent().find('#nombres').val()+' '+$(this).parent().parent().parent().find('#apellido_materno').val()+'</h5></div><div class="col-md-4"><h5 class="card-text">'+$(this).parent().parent().parent().find('#correo').val()+' </h5></div><div class="col-md-2">'+comentarios+'</div></div></div></div></div>';
                }



                if($(this).val()==0){
                  console.log($(this).parent().parent().parent().find('#nombres').val());
                  
                  bandera_error=0;
                  if($(this).parent().parent().parent().find('#noti_elect_estatus_correccion').is(':checked')) {
                    bandera_error=1;
                    comentarios="<strong>Información erronea reportada</strong><br>"+$(this).parent().parent().parent().find('#noti_elect_comentario_correccion').val();
                  }
                  else{
                    comentarios="Sin Notificación";
                  }
                  //informacionFinal_inicio+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="1"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#correo').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"><label class="ckbox "><input type="checkbox" class="ckbox_notificacion"><span> Notificado </span></label></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación electrónica por Artículo 113</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+$(this).parent().parent().parent().find('#tipo').val()+'<br></span>'+$(this).parent().parent().parent().find('#nombres').val()+' '+$(this).parent().parent().parent().find('#apellido_paterno').val()+' '+$(this).parent().parent().parent().find('#apellido_materno').val()+'</h5></div><div class="col-md-4"><h5 class="card-text">'+$(this).parent().parent().parent().find('#correo').val()+' </h5></div><div class="col-md-2">Se enviará correo electrónico</div></div></div></div></div>';
                  informacionFinal_inicio+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="0"><input type="hidden" id="noti_elect_estatus_correccion" value="'+bandera_error+'"><input type="hidden" id="noti_elect_comentario_correccion" value="'+$(this).parent().parent().parent().find('#noti_elect_comentario_correccion').val()+'"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#correo').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Sin Notificación</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+$(this).parent().parent().parent().find('#tipo').val()+'<br></span>'+$(this).parent().parent().parent().find('#nombres').val()+' '+$(this).parent().parent().parent().find('#apellido_paterno').val()+' '+$(this).parent().parent().parent().find('#apellido_materno').val()+'</h5></div><div class="col-md-4"><h5 class="card-text">'+$(this).parent().parent().parent().find('#correo').val()+' </h5></div><div class="col-md-2">'+comentarios+'</div></div></div></div></div>';
                  bandera_render=1;

                }


                if($(this).val()==3){
                  informacionFinal_fisica+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="3"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#direccion').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación física</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+$(this).parent().parent().parent().find('#tipo').val()+'<br></span>'+$(this).parent().parent().parent().find('#nombres').val()+' '+$(this).parent().parent().parent().find('#apellido_paterno').val()+' '+$(this).parent().parent().parent().find('#apellido_materno').val()+'</h5></div><div class="col-md-4"><h5 class="card-text">'+$(this).parent().parent().parent().find('#direccion').val()+'</h5></div><div class="col-md-2"></div></div></div></div></div>';
                }

              });
            }


            //opcion para firmar
            if(currentIndex==3 && newIndex==4 && bandera_firmado_actuario==1 && bandera_render==1){
              bandera_render=0;
              procesarFirelCorreo();
              $('#modaldemo_editar_html').css('z-index', '1040');
              $('#modal_loading').modal({backdrop: 'static', keyboard: false});
            }
            
            return true;
            
          },
          onStepChanged: function (event, currentIndex, priorIndex) {
            //cuando no hay correo actuario, se manda directo al 4
            if(bandera_firmado_actuario==0){
              stepsWizard.steps("setStep", 4);
              $('#informacionFinal').html(informacionFinal_inicio);

            }
            else if(currentIndex==1 && priorIndex==0 ){
              stepsWizard.steps("setStep", 3);
            }
            

          },
          onFinishing: function (event, currentIndex) {   
            if(currentIndex==4){
              
              console.log($('#modal_correo_notificacion_id').val());
              cambiarNotificacion($('#modal_correo_notificacion_id').val(), $('#modal_correo_index').val(), 1);
              
            }
            
          }, 
          onFinished: function (event, currentIndex) {   },

        });

        $.fn.steps.setStep = function (step)
        {
          var currentIndex = $(this).steps('getCurrentIndex');
          for(var i = 0; i < Math.abs(step - currentIndex); i++){

            if(step >= currentIndex) {
              $(this).steps('next');
            }
            else{
              $(this).steps('previous');
            }
          } 
        };

        setTimeout(function(){
            $('#modal_loading').modal('hide');

            $('span[title]').qtip({
                content: {
                    text: false // Use each elements title attribute
                },
                style       : 'qtip-bootstrap'
            });


        }, 500);
    });
  var stepsWizard;
  var bandera_render=1;

      function vistaPrevia(id_acuerdo, ponencia, id_documento, tipo_documento){
        
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})
          $.ajax({
              type:'POST',
              url: "{{ route('bandeja.documento_descargar_ajax_sinse') }}",
              data:{ id_acuerdo:id_acuerdo, ponencia:ponencia, id_documento:id_documento, tipo_documento:tipo_documento },
              success:function(data){
                  console.log(data);
                  setTimeout(function(){
                      $('#modal_loading').modal('hide');
                  }, 500);
                  if(data.status==100){
                      var win = window.open(data.response, '_blank');
                  }
                  else{
                      alert(data.message);
                      setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);
                  }
              }
          });
      }


      function notificar_acuerdo_resumen(id){
        $('#modaldemo4').find('.modal-header').html('');
        $('#modaldemo4').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url: "{{ route('notificaciones.notificar_acuerdo_resumen') }}",
            data:{ id:id },
            success:function(data){
                $('#modaldemo4').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo4').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
      }


    function cambiarEstatusNotificacion(bandera, id_noti_elect){

      if(bandera==1){

        $.ajax({
          type:'POST',
          url: "{{ route('notificaciones.notificar_estatus_error_parte') }}",
          data:{ id_noti_elect:id_noti_elect, bandera:"correccion_actuario", comentarios:$('#noti_elect_comentario_correccion').val() },
          success:function(data){
            console.log(data);

            $('#modaldemo3').modal('hide');
          }
        });

      }
      else{

        $.ajax({
          type:'POST',
          url: "{{ route('notificaciones.notificar_estatus_error_parte') }}",
          data:{ id_noti_elect:id_noti_elect, bandera:"datos_correctos_sa", comentarios:$('#noti_elect_comentario_correccion').val() },
          success:function(data){
            console.log(data);

            $('#modaldemo3').modal('hide');

            

          }
        });

      }
      
      location.reload();
      
    }


      function consultarEstatusErrorParte(id, id_juicio, id_parte, error){
        $('#modaldemo4').find('.modal-header').html('');
        $('#modaldemo4').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url: "{{ route('notificaciones.consultar_estatus_error_parte') }}",
            data:{ id:id, id_juicio:id_juicio, id_parte:id_parte, error:error, sa:1 },
            success:function(data){
                $('#modaldemo4').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo4').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
      }
      


      
      function cambiarNotificacionFisica(id_noti_elect, index){
        $('#id_noti_elect').val(id_noti_elect);
        $('#index').val(index);
      }
      function confirmarNotificacionFisica(){
        index=$('#index').val();
        $.ajax({
            type:'POST',
            url: "{{ route('notificaciones.notificar_acuerdo_bandera_fisica') }}",
            data:{ id_noti_elect:$('#id_noti_elect').val(), fecha:$('#datepicker_fisica').val()  },
            success:function(data){
              console.log(data);

              $('#modaldemo3').modal('hide');

              $('.bandejas_notificacion_fisicas').find('#revision').html($('.bandejas_notificacion_fisicas').find('#revision').html()+1);
              $('.bandejas_notificacion_fisicas').find('#firma').html(parseInt($('.bandejas_notificacion_fisicas').find('#firma').html())-1);
              //$('#datatable1').find('#data-row-id-'+index).fadeOut('slow', function($row){
                  dataTableGlobal.rows($('#datatable1').find('#data-row-id-'+index)).remove().draw();
              //});

            }
          });
      }
 
      
      function cambiarNotificacion(notificacion_id, index, modal){
        
        bandera_enviar=1;
        console.log('vas');
        $( ".ckbox_notificacion" ).each(function( index ) {
          console.log($(this).is(":checked"));
          if(!($(this).is(":checked"))){
            console.log('entro');
            bandera_enviar=0;
          }
        });

        if(bandera_enviar==1){
          if(confirm('¿Esta seguro de confirmar la notificación?')){

            var notificacion_id=0;
            $( ".informacion_notificaciones" ).each(function( index ) {

              notificacion_id=$(this).find('#notificacion_id').val();
              
              console.log($(this).find('#noti_elect_estatus_correccion').val());
              console.log($(this).find('#noti_elect_comentario_correccion').val());

              
              if($('#modal_correo_id_noti_elect').val()==""){
                
                $.ajax({
                  type:'POST',
                  url: "{{ route('notificaciones.notificar_acuerdo_correo_ajax') }}",
                  data:{ tipo_notificacion:$(this).find('#tipo_notificacion').val(), noti_elect_estatus_correccion:$(this).find('#noti_elect_estatus_correccion').val(), noti_elect_comentario_correccion:$(this).find('#noti_elect_comentario_correccion').val(), id_acuerdo_notificacion:$(this).find('#notificacion_id').val(), parte_correo:$(this).find('#correo').val(), id_parte:$(this).find('#id_parte').val()  },
                  success:function(data){
                    console.log(data);
                  }
                });
              }
              else{
                
                //se edita
                $.ajax({
                  type:'POST',
                  url: "{{ route('notificaciones.notificar_estatus_error_parte') }}",
                  data:{ id_noti_elect:$('#modal_correo_id_noti_elect').val(), bandera:'', comentarios:'' },
                  success:function(data){
                    console.log(data);
                    location.reload();
                    $('#modaldemo3').modal('hide');
                  }
                });
              }

              //se manda el 113
              if($(this).find('#tipo_notificacion').val()==1 ){
                $.ajax({
                  type:'POST',
                  url:"{{ route('notificaciones.notificar_acuerdo_111_ajax') }}",
                  data:{ modal_id_acuerdo:$('#modal_correo_id_acuerdo').val(), modal_id_juicio:$('#modal_correo_id_juicio').val(), id_parte:$(this).find('#id_parte').val(), modal_correo_codigo_organo:$('#modal_correo_codigo_organo').val()  },  
                  success:function(data){
                    console.log(data);
                  }
                });
              }

              /*
              //se hace el documento de la notificacion fisica
              if($(this).find('#tipo_notificacion').val()==3){
                $.ajax({
                  type:'POST',
                  url:"{{ route('notificaciones.notificar_acuerdo_not_fisica') }}",
                  data:{ modal_correo_id_acuerdo:$('#modal_correo_id_acuerdo').val(), modal_correo_id_juicio:$('#modal_correo_id_juicio').val(), modal_correo_notificacion_id:$('#modal_correo_notificacion_id').val(), modal_correo_codigo_organo:$('#modal_correo_codigo_organo').val(), modal_correo_ultima_version:$('#modal_correo_ultima_version').val(), id_parte:$(this).find('#id_parte').val(), direccion:$(this).find('#correo').val()  },
                  success:function(data){
                    console.log(data);
                  }
                });
              }
              */


            });

            
            $.ajax({
              type:'POST',
              url: "{{ route('notificaciones.notificar_acuerdo_bandera_notificado') }}",
              data:{ id_acuerdo_notificacion:notificacion_id  },
              success:function(data){
                console.log(2);
                console.log(data);
                setTimeout(function(){
                    if(modal==0){
                      $('#modal_loading').modal('hide');
                    }
                    else if(modal==1){
                      
                      $('#modaldemo_editar_html').modal('hide');
                    }
                }, 500);
                
                if(data.error==1){
                    alert(data.mensaje);
                }
                else{
                  $('.bandejas_notificacion').find('#revision').html($('.bandejas_notificacion').find('#revision').html()-1);
                  $('.bandejas_notificacion').find('#firma').html(parseInt($('.bandejas_notificacion').find('#firma').html())+1);
                  //$('#datatable1').find('#data-row-id-'+index).fadeOut('slow', function($row){
                      dataTableGlobal.rows($('#datatable1').find('#data-row-id-'+index)).remove().draw();
                  //});
                }
              }
            });


          }

          
        }
        else{
          alert("Debe seleccionar todas las partes.");
        }
      }
      


      function firmarNotificacion(id_acuerdo, bandeja, index, codigo_organo, id_juicio, notificaicon_url, notificacion_id){

        $.ajax({
            type:'POST',
            url:'/consultaPartesNotificacion',
            data:{ id:id_juicio },
            success:function(data){
                
                $('.actores_lista').html(data.plantilla_archivo_body);
            }
        });


        $('#modal_id_acuerdo').val(id_acuerdo);
        $('#modal_bandeja').val(bandeja);
        $('#modal_accion').val('');
        $('#modal_index').val(index);
        $('#modal_codigo_organo').val(codigo_organo);
        $('#modal_id_juicio').val(id_juicio);
        $('#modal_notificaicon_url').val(notificaicon_url);
        $('#modal_notificacion_id').val(notificacion_id);
        //se muesstra el modal de la firel
        $('#modal_firel').modal('show');

      }


      function procesarFirel(){

        alert(1);
        return 1;
        guardarPartesNotificacion();

        //manejo de modales
        $('#modal_firel').modal('hide');
        $('#modal_loading').modal({backdrop: 'static', keyboard: false});
        setTimeout(function(){
          jQuery.ajax({
              type: 'POST',
              url:"{{ route('notificaciones.notificar_acuerdo_111_ajax') }}",
              data: new FormData($("#form_firma_firel")[0]),
              processData: false, 
              contentType: false, 
              success: function(data) {
                  console.log(data);
                  setTimeout(function(){
                      $('#modal_loading').modal('hide');
                  }, 500);
                  
                  if(data.error==1){
                      alert(data.mensaje);
                  }
                  else{
                      
                      bandeja=$('#modal_bandeja').val();
                      index=$('#modal_index').val();

                      $('.bandejas_notificacion').find('#revision').html($('.bandejas_notificacion').find('#revision').html()-1);
                      $('.bandejas_notificacion').find('#firma').html(parseInt($('.bandejas_notificacion').find('#firma').html())+1);
                      //$('#datatable1').find('#data-row-id-'+index).fadeOut('slow', function($row){
                          dataTableGlobal.rows($('#datatable1').find('#data-row-id-'+index)).remove().draw();
                      //});
                  }
              }
          });
        }, 800);
      }


      function seleccionarCredenciales(tipo){
        if(tipo=="firel" || tipo=="firel_tsj"){
            $('#id_pfx').css("display", "block");
            $('#id_key').css("display", "none");
            $('#id_cert').css("display", "none");
            $('#id_contrasenia').css("display", "block");
        }
        else if(tipo=="fiel" || tipo=="fiel_tsj"){
            $('#id_pfx').css("display", "none");
            $('#id_key').css("display", "block");
            $('#id_cert').css("display", "block");
            $('#id_contrasenia').css("display", "block");
        }
        else{
            $('#id_pfx').css("display", "none");
            $('#id_key').css("display", "none");
            $('#id_cert').css("display", "none");
            $('#id_contrasenia').css("display", "none");
        }
    }


    function mostrarCorreoActuario(){
      $.ajax({
          type:'POST',
          url:'/bandejas/mostrarEditorHTML',
          data:{ tipo:"acuerdo", id_acuerdo:id_acuerdo, ponencia:ponencia, id_documento:id_documento, tipo_documento:tipo_documento, flujo_id:flujo_id },
          success:function(data){
              setTimeout(function(){
                  $('#modaldemo_editar_html').find('.modal-body').html(data.plantilla_archivo_body);
                  //$('#modaldemo_editar_html').find('.modal-header').html(data.plantilla_archivo_header);
                  $('#modaldemo_editar_html').modal({backdrop: 'static', keyboard: false});
              }, 500);
          }
      });

    }

    
    var implementado=0;
    function obtenerInformacionActuario(id_acuerdo, bandeja, index, codigo_organo, id_juicio, notificaicon_url, notificacion_id, ultima_version_id, id_noti_elect, noti_elect_estatus_correccion, noti_elect_comentario_correccion, id_parte){

      $('#modal_correo_id_acuerdo').val(id_acuerdo);
      $('#modal_correo_bandeja').val(bandeja);
      $('#modal_correo_accion').val('');
      $('#modal_correo_index').val(index);
      $('#modal_correo_codigo_organo').val(codigo_organo);
      $('#modal_correo_id_juicio').val(id_juicio);
      $('#modal_correo_notificaicon_url').val(notificaicon_url);
      $('#modal_correo_notificacion_id').val(notificacion_id);
      $('#modal_correo_ultima_version').val(ultima_version_id);
      $('#modal_correo_id_noti_elect').val(id_noti_elect);
      $('#modal_correo_noti_elect_estatus_correccion').val(noti_elect_estatus_correccion);
      $('#modal_correo_noti_elect_comentario_correccion').val(noti_elect_comentario_correccion);

      console.log(notificacion_id);
      console.log($('#modal_correo_notificacion_id').val());
      
      $('#informacionPartes').html('');
      $('#informacionHtml1').html('');
      $('#informacionHtml2').html('');
      $('#informacionFinal').html('');

      $('#modaldemo_editar_html').modal({backdrop: 'static', keyboard: false});
      
      alert('aqui');
      $.ajax({
          type:'POST',
          url:'/notificaciones/cargarStep',
          data:{ id_juicio:id_juicio, notificacion_id:notificacion_id  },
          success:function(data){
            console.log('en data 1');
            console.log(data);

            
              $.ajax({
                  type:'POST',
                  url:'/notificaciones/mostrarPartes',
                  data:{ id:id_juicio, id_noti_elect:id_noti_elect, noti_elect_estatus_correccion:noti_elect_estatus_correccion, error:noti_elect_comentario_correccion, id_parte:id_parte, editar:1 },
                  success:function(data){
                      
                    $('#informacionPartes').html(data.plantilla_archivo_body);
                     
                  }
              });

              $.ajax({
                  type:'POST',
                  url:'/notificaciones/mostrarEditorHTML',
                  data:{ id:id_juicio, texto:"1", notificacion_id:notificacion_id, "usuario-juzgado":codigo_organo },
                  success:function(data){
                      setTimeout(function(){
                          $('#informacionHtml1').html(data.plantilla_archivo_body);
                      }, 500);
                  }
              });

              $.ajax({
                  type:'POST',
                  url:'/notificaciones/mostrarEditorHTML',
                  data:{ id:id_juicio, texto:"2", notificacion_id:notificacion_id, "usuario-juzgado":codigo_organo },
                  success:function(data){
                      setTimeout(function(){
                          $('#informacionHtml2').html(data.plantilla_archivo_body);
                      }, 500);
                  }
              });

              if(data[0]==1){
              

              //informacionFinal_inicio+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="1"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#correo').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"><label class="ckbox "><input type="checkbox" class="ckbox_notificacion"><span> Notificado </span></label></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación electrónica por Artículo 113</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+$(this).parent().parent().parent().find('#tipo').val()+'<br></span>'+$(this).parent().parent().parent().find('#nombres').val()+' '+$(this).parent().parent().parent().find('#apellido_paterno').val()+' '+$(this).parent().parent().parent().find('#apellido_materno').val()+'</h5></div><div class="col-md-4"><h5 class="card-text">'+$(this).parent().parent().parent().find('#correo').val()+' </h5></div><div class="col-md-2">Se enviará correo electrónico</div></div></div></div></div>';



              informacionFinal="";
              for(i=0; i<data[1].length; i++){
                informacionFinal+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="2"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#correo').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"><label class="ckbox "><input type="checkbox" class="ckbox_notificacion"><span> Notificado </span></label></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación electrónica por correo del actuario</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+data[1][i]['tipo']+'<br></span>'+data[1][i]['nombre']+'<input type="button" value="copiar" onclick="setClipboardText(\''+data[1][i]['nombre']+'\', \'correo_'+data[1][i]['nombre']+'\')" style="font-size:12px;"></h5></div><div class="col-md-4"><h5 class="card-text">'+data[1][i]['correo']+' </h5><input type="button" value="copiar" onclick="setClipboardText(\''+data[1][i]['correo']+'\', \'correo_'+data[1][i]['correo']+'\')"></div><div class="col-md-2"><a href="'+data[1][i]['url']+'" target="_black" class="card-link">Cédula de Notificación</a></div></div></div></div></div>';
              }
              bandera_render=0;

              $('#informacionFinal').html(informacionFinal);
              setTimeout(function(){
                stepsWizard.steps("setStep", 4);
                stepsWizard.steps("next");
              }, 500);
              //$('#wizard1 .steps').find('li').removeClass().addClass('disabled');
              //$('#wizard1 .steps li:first').removeClass('disabled').addClass('first current');
              setTimeout(function(){
                bandera_render=1;
              }, 800);
            }
            else{

              bandera_render=1;
              comentarios=informacionFinal_inicio=informacionFinal_fisica=informacionFinal="";
              $('#informacionFinal').html('');
              stepsWizard.steps("setStep", 0);
              $('#wizard1 .steps').find('li').removeClass().addClass('disabled');
              $('#wizard1 .steps li:first').removeClass('disabled').addClass('first current');

            }
          }
      });
      
    }




    var implementado=0;
    function obtenerInformacion(id_acuerdo, bandeja, index, codigo_organo, id_juicio, notificaicon_url, notificacion_id, ultima_version_id){

      $('#modal_correo_id_acuerdo').val(id_acuerdo);
      $('#modal_correo_bandeja').val(bandeja);
      $('#modal_correo_accion').val('');
      $('#modal_correo_index').val(index);
      $('#modal_correo_codigo_organo').val(codigo_organo);
      $('#modal_correo_id_juicio').val(id_juicio);
      $('#modal_correo_notificaicon_url').val(notificaicon_url);
      $('#modal_correo_notificacion_id').val(notificacion_id);
      $('#modal_correo_ultima_version').val(ultima_version_id);

      console.log(notificacion_id);
      console.log($('#modal_correo_notificacion_id').val());
      
      $('#informacionPartes').html('');
      $('#informacionHtml1').html('');
      $('#informacionHtml2').html('');
      $('#informacionFinal').html('');

      $('#modaldemo_editar_html').modal({backdrop: 'static', keyboard: false});
      

      $.ajax({
          type:'POST',
          url:'/notificaciones/cargarStep',
          data:{ id_juicio:id_juicio, notificacion_id:notificacion_id },
          success:function(data){
            console.log('en data');
            console.log(data);

            $.ajax({
              type:'POST',
              url:'/notificaciones/mostrarPartes',
              data:{ id:id_juicio, "usuario-juzgado":codigo_organo },
              success:function(data){
                  console.log(data);
                $('#informacionPartes').html(data.plantilla_archivo_body);
                  
              }
            });

            $.ajax({
              type:'POST',
              url:'/notificaciones/mostrarEditorHTML',
              data:{ id:id_juicio, juicio:id_juicio, texto:"1", notificacion_id:notificacion_id, "usuario-juzgado":codigo_organo },
              success:function(data){
                console.log(data);
                setTimeout(function(){
                    $('#informacionHtml1').html(data.plantilla_archivo_body);
                }, 500);
              }
            });

            $.ajax({
              type:'POST',
              url:'/notificaciones/mostrarEditorHTML',
              data:{ id:id_juicio, juicio:id_juicio, texto:"2", notificacion_id:notificacion_id, "usuario-juzgado":codigo_organo },
              success:function(data){
                console.log(data);
                setTimeout(function(){
                    $('#informacionHtml2').html(data.plantilla_archivo_body);
                }, 500);
              }
            });

            if(data[0]==1){
              

              //informacionFinal_inicio+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="1"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#correo').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"><label class="ckbox "><input type="checkbox" class="ckbox_notificacion"><span> Notificado </span></label></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación electrónica por Artículo 113</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+$(this).parent().parent().parent().find('#tipo').val()+'<br></span>'+$(this).parent().parent().parent().find('#nombres').val()+' '+$(this).parent().parent().parent().find('#apellido_paterno').val()+' '+$(this).parent().parent().parent().find('#apellido_materno').val()+'</h5></div><div class="col-md-4"><h5 class="card-text">'+$(this).parent().parent().parent().find('#correo').val()+' </h5></div><div class="col-md-2">Se enviará correo electrónico</div></div></div></div></div>';



              informacionFinal="";
              for(i=0; i<data[1].length; i++){
                informacionFinal+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="2"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+$(this).parent().parent().parent().find('#correo').val()+'"><input type="hidden" id="id_parte" value="'+$(this).parent().parent().parent().find('#id_parte').val()+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"><label class="ckbox "><input type="checkbox" class="ckbox_notificacion"><span> Notificado </span></label></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación electrónica por correo del actuario</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+data[1][i]['tipo']+'<br></span>'+data[1][i]['nombre']+'<input type="button" value="copiar" onclick="setClipboardText(\''+data[1][i]['nombre']+'\', \'correo_'+data[1][i]['nombre']+'\')" style="font-size:12px;"></h5></div><div class="col-md-4"><h5 class="card-text">'+data[1][i]['correo']+' </h5><input type="button" value="copiar" onclick="setClipboardText(\''+data[1][i]['correo']+'\', \'correo_'+data[1][i]['correo']+'\')"></div><div class="col-md-2"><a href="'+data[1][i]['url']+'" target="_black" class="card-link">Cédula de Notificación</a></div></div></div></div></div>';
              }
              bandera_render=0;

              $('#informacionFinal').html(informacionFinal);
              setTimeout(function(){
                stepsWizard.steps("setStep", 4);
                stepsWizard.steps("next");
              }, 500);
              //$('#wizard1 .steps').find('li').removeClass().addClass('disabled');
              //$('#wizard1 .steps li:first').removeClass('disabled').addClass('first current');
              setTimeout(function(){
                bandera_render=1;
              }, 800);
            }
            else{
              
              bandera_render=1;

              stepsWizard.steps("setStep", 0);
              $('#wizard1 .steps').find('li').removeClass().addClass('disabled');
              $('#wizard1 .steps li:first').removeClass('disabled').addClass('first current');

            }
          }
      });

    }


    var editor_html_1=editor_html_2="";
    function procesarFirelCorreo(){
      


      $('#modal_correo_texto1').val(editor_html_1.html.get());
      $('#modal_correo_texto2').val(editor_html_2.html.get());

      jQuery.ajax({
          type: 'POST',
          url:"{{ route('notificaciones.guardar_notificion_correo_actuario') }}",
          data: new FormData($("#form_firma_notificacion")[0]),
          processData: false, 
          contentType: false, 
          success: function(data) {
              console.log(data);
              setTimeout(function(){
                  $('#modal_loading').modal('hide');
              }, 500);

              setTimeout(function(){
                $('#modaldemo_editar_html').css('z-index', '1050');
              }, 700);
              

              if(data.error==1){
                  alert(data.mensaje);
              }
              else{
                  
                informacionFinal="";
                for(i=0; i<data[0].length; i++){
                  informacionFinal+='<div class="informacion_notificaciones"><input type="hidden" id="tipo_notificacion" value="2"><input type="hidden" id="notificacion_id" value="'+$('#modal_correo_notificacion_id').val()+'"><input type="hidden" id="correo" value="'+data[0][i]['correo']+'"><input type="hidden" id="id_parte" value="'+data[0][i]['id_parte']+'"></div><div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"><label class="ckbox "><input type="checkbox" class="ckbox_notificacion"><span> Notificado </span></label></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15" style="font-size:14px; color:red;">Notificación electrónica por correo del actuario</span><br> <span class="card-subtitle tx-normal mg-b-15" style="font-size:14px;">'+data[0][i]['tipo']+'<br></span>'+data[0][i]['nombre']+'<input type="button" value="copiar" onclick="setClipboardText(\''+data[0][i]['nombre']+'\', \'correo_'+data[0][i]['nombre']+'\')" style="font-size:12px;"></h5></div><div class="col-md-4"><h5 class="card-text">'+data[0][i]['correo']+' </h5><input type="button" value="copiar" onclick="setClipboardText(\''+data[0][i]['correo']+'\', \'correo_'+data[0][i]['correo']+'\')"></div><div class="col-md-2"><a href="'+data[0][i]['url']+'" target="_black" class="card-link">Cédula de Notificación</a></div></div></div></div></div>';
                                                                                                                                                                                                                                                                                                                                                                                                                                      // informacionFinal+='<div class="col-md-12 mg-t-20 mg-md-t-0"><div class="card"><div class="card-body"><div class="row"><div class="col-md-2"><label class="ckbox "><input type="checkbox" class="ckbox_notificacion"><span> Notificado </span></label></div><div class="col-md-4"><h5 class="card-title tx-dark tx-medium mg-b-10"><span class="card-subtitle tx-normal mg-b-15">'+data[0][i]['tipo']+'<br></span>'+data[0][i]['nombre']+'<input type="button" value="copiar" onclick="setClipboardText(\''+data[0][i]['nombre']+'\', \'correo_'+data[0][i]['nombre']+'\')" style="font-size:12px;"></h5></div><div class="col-md-4"><h5 class="card-text">'+data[0][i]['correo']+' </h5><input type="button" value="copiar" onclick="setClipboardText(\''+data[0][i]['correo']+'\', \'correo_'+data[0][i]['correo']+'\')"></div><div class="col-md-2"><a href="'+data[0][i]['url']+'" target="_black" class="card-link">Cédula de Notificación</a></div></div></div></div></div';
                }

                console.log(informacionFinal);
                console.log(informacionFinal_inicio);
                $('#informacionFinal').html(informacionFinal+informacionFinal_inicio+informacionFinal_fisica);

                /*
                  bandeja=$('#modal_bandeja').val();
                  index=$('#modal_index').val();

                  $('.bandejas_notificacion').find('#revision').html($('.bandejas_notificacion').find('#revision').html()-1);
                  $('.bandejas_notificacion').find('#firma').html(parseInt($('.bandejas_notificacion').find('#firma').html())+1);
                  $('#datatable1').find('#data-row-id-'+index).fadeOut('slow', function($row){
                      dataTableGlobal.rows(index).remove().draw();
                  });
                  */

              }
          }
      });
    }
    

    function setClipboardText(text, id_texto){
        var id = id_texto;
        var existsTextarea = document.getElementById(id);
    
        if(!existsTextarea){
            console.log("Creando textarea");
            var textarea = document.createElement("textarea");
            textarea.id = id;
            // Coloca el textarea en el borde superior izquierdo
            textarea.style.position = 'fixed';
            textarea.style.top = 0;
            textarea.style.left = 0;
    
            // Asegurate que las dimensiones del textarea son minimas, normalmente 1px 
            // 1em no funciona porque esto generate valores negativos en algunos exploradores
            textarea.style.width = '1px';
            textarea.style.height = '1px';
    
            // No se necesita el padding
            textarea.style.padding = 0;
    
            // Limpiar bordes
            textarea.style.border = 'none';
            textarea.style.outline = 'none';
            textarea.style.boxShadow = 'none';
    
            // Evitar el flasheo de la caja blanca al renderizar
            textarea.style.background = 'transparent';
            document.querySelector("body").appendChild(textarea);
            console.log("The textarea now exists :)");
            existsTextarea = document.getElementById(id);
        }else{
            console.log("El textarea ya existe")
        }
    
        existsTextarea.value = text;
        existsTextarea.select();
    
        try {
            var status = document.execCommand('copy');
            if(!status){
                console.error("No se pudo copiar el texto");
            }else{
                console.log("El texto ahora está en el portapapeles");
            }
        } catch (err) {
            console.log('Uy, no se pudo copiar');
        }
    }

    
  </script>
@endsection

@section('seccion-modales')



<!-- EDITAR HTML -->
<div id="modaldemo_editar_html" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
  <div class="modal-dialog modal-lg modal-dialog-vertical-center modal-dialog-centered " role="document" style="max-width:1100px;" >
    <div class="modal-content tx-size-sm" >
      <div class="modal-header pd-x-20">
          
              <div class="col-lg-12">

              </div>
              
          
      </div>
      <div class="modal-body " >
        
          
          <div id="wizard1">
            <h3>Información de las partes</h3>
            <section>

              <p id="informacionPartes"></p>
            </section>
            <h3>Primer documento</h3>
            <section>
              <p id="informacionHtml1"></p>
            </section>
            <h3>Segundo documento</h3>
            <section>
              <p id="informacionHtml2"></p>
            </section>
            <h3>Credenciales</h3>
            <section>
              <p >

                <div class="modal-body pd-20">
                  <form id="form_firma_notificacion" enctype="multipart/form-data" method="post">
      
                      <input type="hidden" value="" name="modal_correo_id_notificacion" id="modal_correo_id_notificacion">
                      <input type="hidden" value="" name="modal_correo_id_acuerdo" id="modal_correo_id_acuerdo">
                      <input type="hidden" value="" name="modal_correo_bandeja" id="modal_correo_bandeja">
                      <input type="hidden" value="" name="modal_correo_accion" id="modal_correo_accion">
                      <input type="hidden" value="" name="modal_correo_index" id="modal_correo_index">
                      <input type="hidden" value="" name="modal_correo_codigo_organo" id="modal_correo_codigo_organo">
                      <input type="hidden" value="" name="modal_correo_ultima_version" id="modal_correo_ultima_version">
                      <input type="hidden" value="" name="modal_correo_tipo_firma" id="modal_correo_tipo_firma">
                      <input type="hidden" value="" name="modal_correo_masivo" id="modal_correo_masivo">
                      <input type="hidden" value="" name="modal_correo_id_juicio" id="modal_correo_id_juicio">
                      <input type="hidden" value="" name="modal_correo_tipo_flujo_nombre" id="modal_correo_tipo_flujo_nombre">
                      <input type="hidden" value="" name="modal_correo_notificaicon_url" id="modal_correo_notificaicon_url">
                      <input type="hidden" value="" name="modal_correo_notificacion_id" id="modal_correo_notificacion_id">
                      <input type="hidden" value="" name="modal_correo_texto1" id="modal_correo_texto1">
                      <input type="hidden" value="" name="modal_correo_texto2" id="modal_correo_texto2">
                      <input type="hidden" value="" name="modal_correo_id_noti_elect" id="modal_correo_id_noti_elect">
                      <input type="hidden" value="" name="modal_correo_noti_elect_estatus_correccion" id="modal_correo_noti_elect_estatus_correccion">
                      <input type="hidden" value="" name="modal_correo_noti_elect_comentario_correccion" id="modal_correo_noti_elect_comentario_correccion">
                      <input type="hidden" value="" name="guardar" id="0">
                      

                      
                      <div class="media-body table-responsive-xl" style="">
                          
                          <h5 class="card-profile-name">Selecciona el tipo de credenciales</h5>
                          <p class="card-profile-position">
                              <div class="row col-lg-12" id="">
                                @if($request->entorno["variables_entorno"]["MIFIRMA_ACTIVO"]==0)
                                  <div class="col-lg-3">
                                      <label class="rdiobox" style="width: 70px; text-align:center;">
                                        <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="firel" style="margin-top: -10px;" checked onclick="seleccionarCredenciales('firel')">
                                        <span>Firel</span>
                                      </label>
                                    </div><!-- col-3 -->
                                    <div class="col-lg-3 mg-t-20 mg-lg-t-0" style="">
                                      <label class="rdiobox" style="text-align:center; width: 80px;">
                                        <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="fiel" style="margin-top: -10px;" onclick="seleccionarCredenciales('fiel')">
                                        <span style="">E.Firma</span>
                                      </label>
                                    </div><!-- col-3 -->
                             
                            @else
                              <div class="col-lg-3">
                                <label class="rdiobox" style="width: 150px; text-align:center;">
                                      <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="firel_tsj" style="margin-top: -10px;" checked onclick="seleccionarCredenciales('firel_tsj')">
                                      <span>Firel MiFirma</span>
                                  </label>
                              </div><!-- col-3 -->
                              <div class="col-lg-3 mg-t-20 mg-lg-t-0" style="">
                                <label class="rdiobox" style="text-align:center; width: 150px;">
                                      <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="fiel_tsj" style="margin-top: -10px;" onclick="seleccionarCredenciales('fiel_tsj')">
                                      <span>E.Firma MiFirma</span>
                                  </label>
                              </div><!-- col-3 -->
                            @endif
                          </div>
                              <hr>
      
                              <div class="col-lg-12" id="id_pfx">
                                  <div class="form-group">
                                      <label class="form-control-label" ><span class="tx-danger">*</span> Archivo PFX:</label>
                                      <div id="div_upload" class="field"  >
                                          <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_pfx" id="archivo_pfx" size="50" required accept=".pfx">
                                      </div>
                                  </div>
                              </div><!-- col-2 -->
      
      
                              <div class="col-lg-12" id="id_key" style="display: none;">
                                  <div class="form-group">
                                      <label class="form-control-label" ><span class="tx-danger">*</span> Archivo KEY:</label>
                                      <div id="div_upload" class="field"  >
                                          <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_key" id="archivo_key" size="50" required accept=".key">
                                      </div>
                                  </div>
                              </div><!-- col-2 -->
                              <div class="col-lg-12" id="id_cert" style="display: none;">
                                  <div class="form-group">
                                      <label class="form-control-label" ><span class="tx-danger">*</span> Archivo CER:</label>
                                      <div id="div_upload" class="field"  >
                                          <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_cer" id="archivo_cer" size="50" required accept=".cer">
                                      </div>
                                  </div>
                              </div><!-- col-2 -->
                              
      
      
      
                              <div class="col-lg-12" id="id_contrasenia">
      
                                  <div class="form-group">
                                      <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                                      <input class="form-control" type="password" name="password" value="" placeholder="" required>
                                  </div>
                              </div>
                              
                          </p>
                          <br><br>
                      </div>
                  </form>
              </div><!-- modal-body -->




              </p>
            </section>
            <h3>Resumen</h3>
            <section>
              <div class="row" id="informacionFinal">
                Cargando...
              </div>
            </section>
          </div>
        




      </div><!-- modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->
















<!-- LARGE MODAL -->
  <div id="modaldemo3" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Confirmar notificación física</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">



          <form method="POST" id="forma_voto_particuar"  enctype="multipart/form-data"> 
            
            <div class="media-body table-responsive-xl" style="">
              
                <input type="hidden" id="id_noti_elect" name="id_noti_elect" value="0">
                <input type="hidden" id="index" name="index" value="0">

                <div class="row no-gutters">
                    <h5 class="card-profile-name">Selecciona la fecha de confirmación</h5>
                    <p class="card-profile-position">
                    

                    <div class="col-lg-12" id="">
                      <div class="input-group">
                        <div class="input-group-prepend">
        
                          <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                        </div>
                        <input id="datepicker_fisica" type="text" class="form-control fc-datepicker" placeholder="YYYY/MM/DD" data-date-format="yyyy/mm/dd" readonly="readonly" value="">
                      </div>
                    </div>
                    
                </div><!-- row -->
                <br>
                <button class="btn btn-success btn-block mg-b-10" type="button" onclick="confirmarNotificacionFisica()">Guardar</button>
            </div><!-- form-layout -->
        </form>



          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->


  <!-- LARGE MODAL -->
  <div id="modaldemo4" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Resumen de notificaciones</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->


  

  <!-- LARGE MODAL -->
  <div id="modal_firel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-lg modal-dialog-vertical-center modal-dialog-centered" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm" >
        <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Favor de subir sus credenciales para la firma</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pd-20">
            <form id="form_firma_firel" enctype="multipart/form-data" method="post">

                <input type="hidden" value="" name="modal_id_acuerdo" id="modal_id_acuerdo">
                <input type="hidden" value="" name="modal_bandeja" id="modal_bandeja">
                <input type="hidden" value="" name="modal_accion" id="modal_accion">
                <input type="hidden" value="" name="modal_index" id="modal_index">
                <input type="hidden" value="" name="modal_codigo_organo" id="modal_codigo_organo">
                <input type="hidden" value="" name="modal_ultima_version" id="modal_ultima_version">
                <input type="hidden" value="" name="modal_tipo_firma" id="modal_tipo_firma">
                <input type="hidden" value="" name="modal_masivo" id="modal_masivo">
                <input type="hidden" value="" name="modal_id_juicio" id="modal_id_juicio">
                <input type="hidden" value="" name="modal_tipo_flujo_nombre" id="modal_tipo_flujo_nombre">
                <input type="hidden" value="" name="modal_notificaicon_url" id="modal_notificaicon_url">
                <input type="hidden" value="" name="modal_notificacion_id" id="modal_notificacion_id">
                <input type="hidden" value="" name="guardar" id="0">
                
                
                <div class="media-body table-responsive-xl" style="">
                    <h5 class="card-profile-name">Valida la información de las partes</h5>
                    <p class="card-profile-position actores_lista"></p>

                    <!--
                    <hr>
                    <h5 class="card-profile-name">Selecciona el tipo de credenciales</h5>
                    <p class="card-profile-position">
                        <div class="row col-lg-12" id="">
                            <div class="col-lg-4">
                                <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="firel" checked onclick="seleccionarCredenciales('firel')">
                                  <span>Firel</span>
                                </label>
                              </div><!-- col-3 -- >
                              <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="fiel" onclick="seleccionarCredenciales('fiel')">
                                  <span>E.Firma</span>
                                </label>
                              </div><!-- col-3 -- >
                        </div>
                        <hr>

                        <div class="col-lg-12" id="id_pfx">
                            <div class="form-group">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Archivo PFX:</label>
                                <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_pfx" id="archivo_pfx" size="50" required accept=".pfx">
                                </div>
                            </div>
                        </div><!-- col-2 -- >


                        <div class="col-lg-12" id="id_key" style="display: none;">
                            <div class="form-group">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Archivo KEY:</label>
                                <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_key" id="archivo_key" size="50" required accept=".key">
                                </div>
                            </div>
                        </div><!-- col-2 -- >
                        <div class="col-lg-12" id="id_cert" style="display: none;">
                            <div class="form-group">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Archivo CER:</label>
                                <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_cer" id="archivo_cer" size="50" required accept=".cer">
                                </div>
                            </div>
                        </div><!-- col-2 -- >




                        <div class="col-lg-12" id="id_contrasenia">

                            <div class="form-group">
                                <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" name="password" value="Lbh_220609" placeholder="" required>
                            </div>
                        </div>
                      -->
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary" onclick="procesarFirel();">Enviar Notificación</button>
                        </div>
                    </p>
                    <br><br>
                </div>
            </form>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection