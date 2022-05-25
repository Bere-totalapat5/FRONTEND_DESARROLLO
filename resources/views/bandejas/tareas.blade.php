@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')

@section('contenido-pageheader')


    <ol class="breadcrumb slim-breadcrumb d-none d-md-flex">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Bandejas</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tareas</li>
    </ol>
    <h6 class="slim-pagetitle" id="title_tareas">Tareas</h6>

@endsection

@section('contenido-principal')
  <div class="section-wrapper mg-b-100" id="pageone" data-role="page">
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 29, 0))
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
      <div class="form-layout mg-b-25">
				<div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true">
					<div class="card">
						<div class="card-header" role="tab" id="headingOne">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                <i class="fa fa-search" aria-hidden="true"></i>
							</a>
						</div><!-- card-header -->
						<div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="card-body">
								<div class="row mg-b-15">
                  @if(utilidades::obtener_acciones_vista($request,Session::get('usuario_id'),29,42))
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Unidad:</label>
                        <select class="form-control select2-show-search" id="unidad" name="unidad" autocomplete="off" onchange="obtenerUsuariosUnidad()">
                          <option selected value="">Todas</option>
                          @foreach ($ugas as $uga)
                            <option value="{{$uga['id_unidad_gestion']}}">{{$uga['nombre_unidad']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Usuario: </label>
                        <select class="form-control select2-show-search" id="usuario" name="usuario" autocomplete="off">
                          <option selected value="">Todos</option>
                        </select>
                      </div>
                    </div>
                  @endif
                  <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Folio:</label>
                      <input class="form-control" type="text" name="folio" id="folio" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-2">
                    <div class="form-group">
                      <label class="form-control-label">Estatus: </label>
                      <select class="form-control select2-show-search" id="estatus" name="estatus" autocomplete="off">
                        <option value="">Todos</option>
                        <option selected value="espera">Espera</option>
                        <option value="atendida">Atendida</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <label class="form-control-label">Tipo de tarea: </label>
                      <select class="form-control select2-show-search" id="tipo_tarea" name="tipo_tarea" autocomplete="off">
                        <option value="" selected>Todas</option>
                        <option value="DEL">Delegadas</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <label class="form-control-label">Desde: </label>
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <div class="input-group-text">
                                  <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                              </div>
                          </div>
                          <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="desde"  name="desde" autocomplete="off">
                      </div>
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-2">
                    <div class="form-group">
                      <label class="form-control-label">Hasta: </label>
                      <div class="input-group">
                          <div class="input-group-prepend">
                              <div class="input-group-text">
                                  <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                              </div>
                          </div>
                          <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="hasta"  name="hasta" autocomplete="off">
                      </div>
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-2">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label" >Carpeta judicial:</label>
                      <input class="form-control" type="text" name="carpeta_judicial" id="carpetaJudicial" value="" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label" >Carpeta de investigación:</label>
                      <input class="form-control" type="text" name="carpeta_inv" id="carpetaInv" value="" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Nombre:</label>
                      <input class="form-control" type="text" name="nombre_persona" id="nombrePersona" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Apellido Paterno:</label>
                      <input class="form-control" type="text" name="ap_paterno_persona" id="apPaternoPersona" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Apellido Materno:</label>
                      <input class="form-control" type="text" name="ap_materno_persona" id="apMaternoPersona" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
								</div>
								<div class="row">
									<div class="col-lg-12 d-flex">
										<button class="btn btn-primary mg-l-auto " onclick="buscar(1)" id="searchFolioB">Buscar</button>
									</div>
								</div>
							</div><!-- card-bod -->
						</div>
					</div>
				</div><!-- accordion -->
      </div>
      <div class="row"  >
        <div class="col-lg-12">
          <a href="javascript:void(0)" id="aAtendidas"><i class="fa fa-check-square" aria-hidden="true"></i> Marcar como atendidas</a>
            @if( in_array( $request->session()->get('id_tipo_usuario'), [1,18] ) )
              <a href="javascript:void(0)" id="aEspera"><i class="fa fa-check-square" aria-hidden="true"></i> Marcar en  espera</a>
              @endif
          <table  data-swipe-ignore="true" id="tableTareas" class="display dataTable dtr-inline collapsed" style="margin-top: 10px; overflow-x: auto; padding-left:0; padding-rigth:0">
            <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
              <th class="acciones">
                <label class="ckbox d-inline-block">
                  <input type="checkbox" id="seleccionaTodas"><span></span>
                </label>
                Acciones
              </th>
              <th class="folio">Folio</th>
              <th class="remitente">Fecha de registro</th>
              <th class="remitente">Fecha de tarea</th>
              <th class="carpeta">Carpeta Judicial</th>
              <th class="descripcion">Descripción Tarea</th>
              <th class="remitente">Remitente</th>
              <th class="remitente">Receptor</th>
              <th class="partes">Partes Procesales</th>
              <th class="delitos">Delitos</th>
              <th class="delitos">Juez</th>
              <th class="comentarios">Comentarios</th>
            </thead>
            <tbody id="bodyTareas">
            </tbody>
          </table>
          <div class="pagination-wrapper justify-content-between">
            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link primera" href="javascript:void(0)" aria-label="Last" onclick="buscar(1)">
                  <i class="fa fa-angle-double-left"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link anterior" href="javascript:void(0)" aria-label="Next" onclick="buscar(1)">
                  <i class="fa fa-angle-left"></i>
                </a>
              </li>
            </ul>
            <ul class="pagination mg-b-0">
              <li class="page-item">Página <span class="pagina">1</span> de <span class="total-paginas">1</span></li>
            </ul>

            <ul class="pagination mg-b-0">
              <li class="page-item">
                <a class="page-link siguiente" href="javascript:void(0)" aria-label="Next" onclick="buscar(1)">
                  <i class="fa fa-angle-right"></i>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link ultima" href="javascript:void(0)" aria-label="Last" onclick="buscar(1)">
                  <i class="fa fa-angle-double-right"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    @endif
  </div>

@endsection

@section('seccion-estilos')
  <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset("/css/bandejas/tareas.css")}}">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"> --}}
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/froala_editor.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/froala_style.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/code_view.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/colors.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/emoticons.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/image_manager.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/image.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/line_breaker.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/quick_insert.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/table.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/file.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/char_counter.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/video.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/emoticons.css">
  <link rel="stylesheet" href="/box/froala_editor_3.1.1/css/plugins/fullscreen.css">

  <link rel="stylesheet" href="/box/scheduler_5.3.11_enterprise/codebase/dhtmlxscheduler_material.css?v=5.3.8" type="text/css" charset="utf-8">
  <link rel="stylesheet" href="/box/scheduler_5.3.11_enterprise/samples/common/controls_styles.css?v=5.3.8">
  <link rel="stylesheet" href="{{asset('/css/carpetas_judiciales/remisiones.css')}}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="/js/clockpicker-gh-pages/src/clockpicker.css">
  
  <style>
    @media (min-width: 992px){
      .modal-xl {
          max-width: 1000px !important;
      }
    }
    .modal-xl div.modal-content{
      width: 1000px !important;
    }

    .datepicker{
      z-index:9999 !important
    }
    .modal-open .ui-datepicker{
      z-index: 2000!important
    }
    ul.uib-datepicker-popup.dropdown-menu.ng-scope { z-index: 1090 !important; }
    #ui-datepicker-div{
      z-index: 1050 !important;
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
    #collapseOne{
      border: 1px solid #eee !important;
      background: #f8f9fa;
    }
    #accordion a::before{
      top: 10px !important;
    }


  </style>
@endsection

@section('seccion-scripts-libs')
  <script src="/lib/datatables/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/froala_editor.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/froala_editor.pkgd.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/align.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/code_beautifier.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/code_view.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/colors.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/emoticons.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/draggable.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/font_size.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/font_family.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/image.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/image_manager.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/line_breaker.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/quick_insert.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/link.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/lists.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/paragraph_format.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/paragraph_style.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/video.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/table.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/url.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/emoticons.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/file.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/entities.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/inline_style.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/save.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/fullscreen.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/languages/es.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/quote.min.js"></script>
	<script type="text/javascript" src="/box/froala_editor_3.1.1/js/plugins/char_counter.min.js"></script>


  <script src="/box/scheduler_5.3.11_enterprise/codebase/dhtmlxscheduler.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler/codebase/locale/locale_es.js" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_limit.js?v=5.3.8" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_agenda_view.js?v=5.3.8" charset="utf-8"></script>
  <script src='/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_timeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src='/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_treetimeline.js?v=5.3.8' type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_minical.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_units.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/box/scheduler_5.3.11_enterprise/codebase/ext/dhtmlxscheduler_week_agenda.js?v=5.3.8" type="text/javascript" charset="utf-8"></script>
  <script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>  

  <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
  

@endsection

@section('seccion-scripts-functions')
  <script src="{{asset('/js/bandejas/tareas/tareas.js')}}?v=@php echo time(); @endphp" defer=""></script>
  <script src="{{asset('/js/bandejas/tareas/tareas_audiencias.js')}}?v=@php echo time(); @endphp" defer=""></script>
  <script src="{{asset('/js/bandejas/tareas/tareas_ugjja.js')}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset('/js/bandejas/tareas/tareas_solicitudes.js')}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset('/js/bandejas/tareas/tareas_rejec.js')}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset('/js/bandejas/tareas/tareas_remision.js')}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset('/js/bandejas/configuracionRT.js')}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset('/js/remisiones/obtenerInmuebleFiscalia.js')}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset('/js/remisiones/obtenerUnidadDestino.js')}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset('/js/remisiones/remision_sentenciados.js')}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset('/js/utilidades.js')}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset("/js/remisiones/consulta_datos_remision_ejecucion.js")}}?v=@php echo time(); @endphp"></script>
  <script src="{{asset("/js/remisiones/cRemision.js")}}?v=@php echo time(); @endphp"></script>
  <script src="/js/moment.js"></script>
  <script src="/js/moment-with-locales.js"></script>
  <script src="/js/solicitudes/Solicitud.js"></script>
  <script src="/js/carpetas/data_carpeta.js"></script>
  <script src="/js/acuerdos/Acuerdo.js"></script>
  <script src="/js/audiencias/Audiencia.js"></script>
  <script src="/js/promociones/Promocion.js"></script>
  <script>
    
    @php $ejecucion_promocion = [13,2,40]; @endphp
    const expRegFecha = /^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
          expVacio = /^[\s]*$/,
          tipos_documentos_carpeta = @php echo json_encode($tipos_documento_carpeta); @endphp;
    const unidadGestion = @php echo Session::get('id_unidad_gestion')==''?0:Session::get('id_unidad_gestion'); @endphp;
    const tUsuario = @php echo Session::get('id_tipo_usuario')==''?0:Session::get('id_tipo_usuario'); @endphp;
    const idUsuario = @php echo Session::get('usuario_id')==''?0:Session::get('usuario_id'); @endphp;
    const tUsuarioSustitucion = @php echo Session::get('sustituyendo_a_id_tipo_usuario')==''? 0 :Session::get('sustituyendo_a_id_tipo_usuario'); @endphp;
    const inmueble_usu = @php echo Session::get('id_inmueble')==''?0:Session::get('id_inmueble'); @endphp;
    const leyenda = "@php echo $leyenda; @endphp";
    const fiscalias = @php echo json_encode($fiscalias); @endphp;
    const catalogoPenas = @php echo json_encode($penas); @endphp;
    const unidades_ejecucion = (@php echo json_encode($unidades_ejecucion) @endphp).split(',');
    const tipos_audiencias =  @php echo json_encode($tipos_audiencia); @endphp;
    const usuario_reemplazado =  @php echo Session::get('sustituyendo_a_id_usuario') == '' ? 0 : Session::get('sustituyendo_a_id_usuario') ; @endphp;
    const reclusorios = @php echo json_encode($reclusorios); @endphp;

    let   arrTareas,
          editor_html,
          descripcioBandeja,
          claveBandeja,
          indexTarea,
          origenTarea,
          resolucion,
          solicitud,
          promocion,
          datos_solicitud,
          medidasPersona = [],
          recursos_adi=[];

    $(document).ready(function(){
      buscar(1);
      setTimeout(function(){
        $('#modal_loading').modal('hide');        
      }, 2000);
    });

    $( function() {
      // $('.toggle-on').toggles({
      //   on: true,
      //   height: 26
      // });
      $('.toggle').toggles({
        on: false,
        height: 26
      });
    });


    function abrirTareaNotificacion(){
      var URLactual = window.location.pathname;

      if(URLactual.length < 7){}else{ // si la url trae paramatros
        
        var id = URLactual.split('/');
        var id_c = atob(id[2]);
        console.log(id_c);
        /*
        var id_c = atob(id[2]);
        var cifr = id_c.split('_');
        var id_carp = cifr[0];
        var carp_jl = cifr[1];


        setTimeout(function(){
          $('#buzz').trigger('click');
        }, 500);
        */
        setTimeout(function(){
          window.history.replaceState({}, document.title, "/" + "tareas");
        }, 700);

      }

    }

    async function siguiente(){
      
      const { tabla_asociada, clave_bandeja } = tareaSeleccionada;

      if( $('#tipoResolucion').val() == 'acuerdo' ){
        
        if( configuracion.resolucion_permiso.acuerdo ) {

          
          resolverPorAcuerdo();
          $('#atras').removeAttr('disabled');
          $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
          $('#validacionDatos').addClass('d-none');
          $('#resolucion').removeClass('d-none');
          if( contiene_fracciones )
            $('#accordionFraccionesSol').removeClass('d-none');
            

          if( tabla_asociada == "solicitudes" && ( ['CACU', 'REV', 'COR', 'RS', 'RE', 'REJEC'].includes(clave_bandeja) ) ) {
            
            if( tUsuario != 2 ) {

              
              $('#btnSiguiente').attr('onclick','validarTareaSolicitud()');
              $('#steps').append(`<p class="step activo  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>`);

            }else {

              validarTareaSolicitud(); 

            }

          }else if( tabla_asociada == 'promociones' && (clave_bandeja == "RP" || clave_bandeja == 'CACU' || clave_bandeja == 'RAC' ) ){
            
            $('#btnSiguiente').attr('onclick','validarTareaPromocion()');
            $('#steps').append(`<p class="step activo  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Promoción</span></p>`);

          }

        }else {
          
          if( tabla_asociada == "solicitudes" && ( ['CACU', 'REV','COR','RE'].includes(clave_bandeja) ) ){
            resolverPorAcuerdo();
            $('#atras').removeAttr('disabled');
            $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
            $('#steps').append(`<p class="step activo  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>`);
            $('#validacionDatos').addClass('d-none');
            $('#resolucion').removeClass('d-none');
            if( contiene_fracciones )
              $('#accordionFraccionesSol').removeClass('d-none');
            $('#btnSiguiente').attr('onclick','validarTareaSolicitud()');
          }else if(  clave_bandeja == "RP" ){
            
            validarTareaPromocion();
          
          }else if( clave_bandeja == "CACU"){

            resolverPorAcuerdo();
            $('#atras').removeAttr('disabled');
            $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
            $('#steps').append(`<p class="step activo  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>`);
            $('#validacionDatos').addClass('d-none');
            $('#resolucion').removeClass('d-none');
            $('#btnSiguiente').attr('onclick','validarTareaPromocion()');

          }else{
            validarTareaSolicitud();
          }
        }

      }else if( $('#tipoResolucion').val() == 'audiencia' ){
        
        if( configuracion.resolucion_permiso.audiencia ) {
          $('#atras').removeAttr('disabled');
          $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
          $('#steps').append(`<p class="step activo  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>`);
          
          $('#validacionDatos').addClass('d-none');
          $('#resolucion').removeClass('d-none');
          if( contiene_fracciones )
            $('#accordionFraccionesSol').removeClass('d-none');

          if( tabla_asociada == 'promociones' && ( clave_bandeja == 'RP' || clave_bandeja=='CAUD' ) ){
            $('#btnSiguiente').attr('onclick','validarTareaPromocion()');
          }else{
            $('#btnSiguiente').attr('onclick','validarTareaSolicitud()');
          }

          resolverPorAudiencia();
        }else {

          if( clave_bandeja=='CAUD' ){
            $('#atras').removeAttr('disabled');
            $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
            $('#steps').append(`<p class="step activo  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>`);
            $('#validacionDatos').addClass('d-none');
            $('#resolucion').removeClass('d-none');
            if( contiene_fracciones )
              $('#accordionFraccionesSol').removeClass('d-none');
            $('#btnSiguiente').attr('onclick','validarTareaSolicitud()');
            resolverPorAudiencia();
          }else if( clave_bandeja == "RP" ){
            validarTareaPromocion();
          }else{
            validarTareaSolicitud();
          }
        }

      }else if( tareaSeleccionada.tipo_solicitud_=='EXHORTO' && tareaSeleccionada.exhorto_autorizacion == null ) {
        $('#mensajeConfirmar').html(`Seleccione la opción deseada para el seguimiento del exhorto`);
            $('#opConfirmar').html(`
              <div class="form-group">
                <label class="form-control-label">Autorizar: </label>
                <select class="form-control" id="autorizacionExh" name="estatus" autocomplete="off">
                  <option selected value="si">Si</option>
                  <option value="no">No</option>
                </select>
              </div>
            `);
            abreModal('modalConfirmacion',500);
            $('#modalDatosTarea').modal('hide');
            $('#regresar').attr('onclick','abreModal(`modalDatosTarea`,400)');
            $('#autorizacionExh').select2({minimumResultsForSearch: Infinity});
            $('#btnResolver').attr('onclick',`autorizacionExh(${tareaSeleccionada.id_solicitud})`);
      
      }else{

        error('Datos Incompletos', 'No ha seleccionado el tipo de resolución de la solicitud', 'modalDatosTarea');
        $('#modalDatosTarea').modal('hide');
        $('span[aria-labelledby="select2-tipoResolucion-container"]').addClass('error');

      }

    }

    function stepsSolicitud(){

      const { clave_bandeja } = tareaSeleccionada;

      if(clave_bandeja=='RS'){

        @if(Session::get('id_tipo_usuario')==3 || Session::get('id_tipo_usuario')==31)
          $('#divTarea').append(`
            <div class="steps d-flex">
              <p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
              <p class="step espera  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>
            </div>
          `);
          $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente(${solicitud}, ${indexTarea})">Siguiente</button>`);
        @else
          $('#divTarea').append(`
            <div class="steps d-flex">
              <p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
            </div>
          `);
          $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="validarTareaSolicitud()">Siguiente</button>`);
        @endif

      }else if(clave_bandeja=='CACU'){

        $('#divTarea').append(`
            <div class="steps d-flex">
              <p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
              <p class="step espera  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>
            </div>
          `);
          $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente(${solicitud}, ${indexTarea})">Siguiente</button>`)
      }else if(clave_bandeja=='RE'){
        $('#divTarea').append(`
          <div class="steps d-flex">
            <p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
            <p class="step espera  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>
          </div>
        `);
        $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente(${solicitud}, ${indexTarea})">Siguiente</button>`);
      }

    }

    function stepsPromocion(){
      const { clave_bandeja } = tareaSeleccionada;
      promocion=tareaSeleccionada.id_tabla_asociada;
      if(clave_bandeja=='RP'){

        @if(Session::get('id_tipo_usuario')==3)
          $('#divTarea').append(`
            <div class="steps d-flex">
              <p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
              <p class="step espera  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Promoción</span></p>
            </div>
          `);
          $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente(${promocion}, ${indexTarea})">Siguiente</button>`);
        @else
          $('#divTarea').append(`
            <div class="steps d-flex">
              <p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
            </div>
          `);
          $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="validarTareaPromocion()">Resolver Tarea</button>`);
        @endif
      }else if(clave_bandeja=='CACU'){

        $('#divTarea').append(`
            <div class="steps d-flex">
              <p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
              <p class="step espera  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>
            </div>
          `);
          $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente(${promocion}, ${indexTarea})">Siguiente</button>`)
      }else if(clave_bandeja=='RE'){
        $('#divTarea').append(`
          <div class="steps d-flex">
            <p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
            <p class="step espera  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>
          </div>
        `);
        $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente(${promocion}, ${indexTarea})">Siguiente</button>`);
      }

    }

    function validarTareaSolicitud(){
      const { clave_bandeja, tabla_asociada } = tareaSeleccionada;
      $('.error').removeClass('error');
      resolucion = new FormData($("#cargarDocumento")[0]);

      if( clave_bandeja == "REJEC" && tabla_asociada == "remisiones" )
        resolucion.append('solicitud',tareaSeleccionada.datos_cj.id_solicitud );
      else
        resolucion.append('solicitud',tareaSeleccionada.id_tabla_asociada );

      let valid=0;
          usuario_delegado='-',
          extension='-',
          archivo='-',
          nombre_archivo='-',
          tamanio_archivo='-';

      if( ['RS', 'CAUD', 'REJEC'].includes( clave_bandeja ) ){

        if( $('#tipoResolucion').val() == 'acuerdo' ){
          
          if( resolucion_permiso.acuerdo ) {
            validacionRS();
          } else {
            confirmarResolucionSolicitud();
          }

        }else if( $('#tipoResolucion').val() == 'audiencia' ){

          
          if( resolucion_permiso.audiencia ) {
            if( tareaSeleccionada.tabla_asociada == 'promociones')
              validacionRP();
            else
              validacionRS();
          }else {
            confirmarResolucionSolicitud();
          }
          
        }else{
          error('Datos Incompletos', 'No ha seleccionado el tipo de resolución de la solicitud', 'modalDatosTarea');
          $('#modalDatosTarea').modal('hide');
          $('span[aria-labelledby="select2-tipoResolucion-container"]').addClass('error');
          return 0;
        }


      }else if(clave_bandeja=='CACU'){
          validacionRS();

      }else if(clave_bandeja=='RE'){

        validacionRS();

      }else if($('#tipoResolucion').val()=="audiencia"){

        if( resolucion_permiso.audiencia ) 
          validacionRS();
        else
          confirmarResolucionSolicitud();
        
      } else {
        if( resolucion_permiso.acuerdo ) {

        }else {
          confirmarResolucionSolicitud();
        }
      }

      

    }

    function validarTareaPromocion(){
      const { clave_bandeja, id_tabla_asociada } = tareaSeleccionada;
      $('.error').removeClass('error');
      resolucion=new FormData($("#cargarDocumento")[0]);
      resolucion.append('promocion', id_tabla_asociada);

      let valid=0;
          usuario_delegado='-',
          extension='-',
          archivo='-',
          nombre_archivo='-',
          tamanio_archivo='-';

      if(clave_bandeja=='RP' || clave_bandeja == 'CAUD' || clave_bandeja == 'RAC' ){

          if( $('#tipoResolucion').val() == 'acuerdo' ){

            if( configuracion.resolucion_permiso.acuerdo ) {

              validacionRP();

            } else {

              if($('#tipoResolucion').val()==''){
                error('Datos Incompletos', 'No ha seleccionado el tipo de resolución de la solicitud', 'modalDatosTarea');
                $('#modalDatosTarea').modal('hide');
                $('span[aria-labelledby="select2-tipoResolucion-container"]').addClass('error');
                return 0;
              }else{
                confirmarResolucionPromocion();
              }

            }

          }else if( $('#tipoResolucion').val() == 'audiencia' ){

            if( configuracion.resolucion_permiso.audiencia ) {
              validacionRP();
            } else {
              confirmarResolucionPromocion();
            }
          }


      }else if(clave_bandeja=='CACU'){

        validacionRP();

      }else if(clave_bandeja=='RE'){

        validacionRP();

      }else if($('#tipoResolucion').val()=="audiencia"){

        if( configuracion.resolucion_permiso.audiencia )   validacionRP();
        else confirmarResolucionPromocion();
        
      }


    }

    function validacionRS(){

      if( $('#tipoResolucion').val() == 'acuerdo' ){

        if( $('input:radio[name=doc]:checked').val() == 'subir' ){

          if($('#tipoArchivo').val()==null || $('#tipoArchivo').val()=='') {

            error('Datos Incompletos', 'No ha seleccionado el tipo de archivo', 'modalDatosTarea');
            $('span[aria-labelledby="tipoArchivo-delegar-container"]').addClass('error');
            return 0;

          }

          if( configuracion.resolucion_permiso.acuerdo ) {

            if( $('#accion').val()=='firma' && ($('#usuario_destino').val()==null || $('#usuario_destino').val()=='') ) {

              error('Datos Incompletos', 'No ha seleccionado un firmante', 'modalDatosTarea');
              $('span[aria-labelledby="usuario_destino-delegar-container"]').addClass('error');
              return 0;

            }

          } else {

            if($('#accion').val()=='firma' && ($('#usuario_destino').val()==null || $('#usuario_destino').val()=='')) {

              error('Datos Incompletos', 'No ha seleccionado un usuario para delegar la tarea', 'modalDatosTarea');
              $('span[aria-labelledby="select2-delegar-container"]').addClass('error');
              return 0;

            }

          }

          if($('#archivoDoc').val()==null || $('#archivoDoc').val()=='') {
            error('Datos Incompletos', 'No ha seleccionado un archivo', 'modalDatosTarea');
            $('#archivoDoc').addClass('error');
            return 0;
          }

          const file = $('#archivoDoc').val();
          extension = file.substring(file.lastIndexOf("."));
          tamanio_archivo=$('#archivoDoc')[0].files[0].size;
          nombre_archivo=$('#nombreDoc').val();
          resolucion.append('extension',extension);
          resolucion.append('nombre_archivo',nombre_archivo);
          resolucion.append('tamanio_archivo',tamanio_archivo);

        }else if($('input:radio[name=doc]:checked').val()=='crear'){

          if($('#tipoArchivo').val()==null || $('#tipoArchivo').val()=='') {
            error('Datos Incompletos', 'No ha seleccionado el tipo de archivo', 'modalDatosTarea');
            $('span[aria-labelledby="tipoArchivo-delegar-container"]').addClass('error');
            return 0;

          }

          if( configuracion.resolucion_permiso.acuerdo ) {

            if( $('#accion').val()=='firma' && ($('#usuario_destino').val()==null || $('#usuario_destino').val()=='')) {
              error('Datos Incompletos', 'No ha seleccionado un juez firmante', 'modalDatosTarea');
              $('span[aria-labelledby="usuario_destino-delegar-container"]').addClass('error');
              return 0;
            }
          
          } else {

            if($('#accion').val()=='firma' && ($('#usuario_destino').val()==null || $('#usuario_destino').val()=='')){
              error('Datos Incompletos', 'No ha seleccionado un usuario para delegar la tarea', 'modalDatosTarea');
              $('span[aria-labelledby="select2-delegar-container"]').addClass('error');
              return 0;
            }

          }


          extension='html';
          archivo=editor_html.html.get();
          nombre_archivo=$('#nombreHTML').val();
          resolucion.append('archivo_doc',archivo);
          resolucion.append('extension',extension);
          resolucion.append('nombre_archivo',nombre_archivo);

        }else if($('input:radio[name=doc]:checked').val()=='delegar'){

          if($('#delegar').val()==null || $('#delegar').val()==''){

            error('Datos Incompletos', 'No ha seleccionado un usuario para delegar la tarea', 'modalDatosTarea');
            $('span[aria-labelledby="select2-delegar-container"]').addClass('error');
            return 0;
          }
            resolucion.append('usuario_delegado',$('#delegar').val());
        }
      }else if( $('#tipoResolucion').val() == "audiencia" ){

        if( $('input[name="doc"]:checked').val() == "crear_audiencia" ) {
          
          if( $('#id_tipo_audiencia').val() == '' && $('#id_tipo_audiencia_select').val() == '' ) {

            error('Datos Incompletos', 'Falta el tipo de audiencia', 'modalDatosTarea');
            $('span[aria-labelledby="select2-id_tipo_audiencia_select-container"]').addClass('error');
            $("#id_tipo_audiencia").addClass('error');
            $('#tabDatosGenerales').click();
            return 0;

          }

          if( $('#id_juez_asignado').val() == '' && $('#jueces_ejecucion').val() == '' ) {
            error('Datos Incompletos', 'Falta seleccionar a un juez', 'modalDatosTarea');
            $('span[aria-labelledby="select2-jueces_ejecucion-container"]').addClass('error');
            $("#id_juez_asignado").addClass('error');
            $('#tabCalendar').click();
            return 0;
          }

          if( $('#select_inmueble_salas').val() == null ||  $('#select_inmueble_salas').val() == '' ){
            error('Datos Incompletos', 'No ha seleccionado una sala', 'modalDatosTarea');
            $('span[aria-labelledby="select2-select_inmueble_salas-container"]').addClass('error');
            $('#tabCalendar').addClass('error');
            return 0;
          }

          if( !expRegHora.test($('#tp_hora_inicio').val()) ){
            error('Datos Incompletos', 'No ha indicado la hora de inicio de la audiencia', 'modalDatosTarea');
            $('#tp_hora_inicio').addClass('error');
            $('#tabCalendar').click();
            return 0;
          }

          if( !expRegHora.test($('#tp_hora_final').val()) ){
            error('Datos Incompletos', 'No ha indicado la hora final de la audiencia o el formato es invalido (HH:mm)', 'modalDatosTarea');
            $('#tp_hora_final').addClass('error');
            $('#tabCalendar').click();
            return 0;
          }

          if( horario_valido !=1 ){
            error('Datos Incompletos', 'Debe seleccionar un horario válido o el formato es invalido (HH:mm)', 'modalDatosTarea');
            $('#tp_hora_inicio').addClass('error');
            $('#tp_hora_final').addClass('error');
            $('#tabCalendar').click();
            return 0;
          }

          if( $('#tp_hora_final').val() <= $('#tp_hora_inicio').val() ){
            error('Datos Incompletos', 'Debe leccionar un horario válido o el formato es invalido (HH:mm)', 'modalDatosTarea');
            $('#tp_hora_inicio').addClass('error');
            $('#tp_hora_final').addClass('error');
            $('#tabCalendar').click();
            return 0;
          }
        } else if( $('input[name="doc"]:checked').val() == "delegar" ) {

          if( $('#delegar').val() == null || $('#delegar').val()=='' ) {
            error('Datos Incompletos', 'No ha indicado el usuario al que se le delegará la tarea', 'modalDatosTarea');
            $('#select2-delegar-container').addClass('error');
            return false;
          }

        }

      }


      // else{
        
        confirmarResolucionSolicitud();
      // }

      
    }

    function validacionRP(){
      if( $('#tipoResolucion').val() == 'acuerdo' ) {

        if($('input:radio[name=doc]:checked').val()=='subir'){

          if($('#tipoArchivo').val()==null || $('#tipoArchivo').val()=='') {
            error('Datos Incompletos', 'No ha seleccionado el tipo de archivo', 'modalDatosTarea');
            $('span[aria-labelledby="tipoArchivo-delegar-container"]').addClass('error');
            return 0;
          }

          if( configuracion.resolucion_permiso.acuerdo ) {

            if($('#usuario_destino').val()==null || $('#usuario_destino').val()=='') {
              error('Datos Incompletos', 'No ha seleccionado un juez firmante', 'modalDatosTarea');
              $('span[aria-labelledby="usuario_destino-delegar-container"]').addClass('error');
              return 0;
            }

          }else {

            if( $('#accion').val() == 'firma' && ( $('#usuario_destino').val() == null || $('#usuario_destino').val() == '') ){
              error('Datos Incompletos', 'No ha seleccionado un usuario para delegar la tarea', 'modalDatosTarea');
              $('span[aria-labelledby="select2-delegar-container"]').addClass('error');
              return 0;
            }

          }

          if( $('#archivoDoc').val() == null || $('#archivoDoc').val() == '' ) {
            error('Datos Incompletos', 'No ha seleccionado un archivo', 'modalDatosTarea');
            $('#archivoDoc').addClass('error');
            return 0;
          }

          const file = $('#archivoDoc').val();
          extension = file.substring(file.lastIndexOf("."));
          tamanio_archivo=$('#archivoDoc')[0].files[0].size;
          nombre_archivo=$('#nombreDoc').val();
          resolucion.append('extension',extension);
          resolucion.append('nombre_archivo',nombre_archivo);
          resolucion.append('tamanio_archivo',tamanio_archivo);

        }else if($('input:radio[name=doc]:checked').val()=='crear'){

          if($('#tipoArchivo').val()==null || $('#tipoArchivo').val()=='') {
            error('Datos Incompletos', 'No ha seleccionado el tipo de archivo', 'modalDatosTarea');
            $('span[aria-labelledby="tipoArchivo-delegar-container"]').addClass('error');
            return 0;
          }
          if( configuracion.resolucion_permiso.acuerdo ) {

            if($('#usuario_destino').val()==null || $('#usuario_destino').val()=='') {
              error('Datos Incompletos', 'No ha seleccionado un juez firmante', 'modalDatosTarea');
              $('span[aria-labelledby="usuario_destino-delegar-container"]').addClass('error');
              return 0;
            }

          } else {

            if($('#accion').val()=='firma' && ($('#usuario_destino').val()==null || $('#usuario_destino').val()=='')){
              error('Datos Incompletos', 'No ha seleccionado un usuario para delegar la tarea', 'modalDatosTarea');
              $('span[aria-labelledby="select2-delegar-container"]').addClass('error');
              return 0;
            }

          }


          extension='html';
          archivo=editor_html.html.get();
          nombre_archivo=$('#nombreHTML').val();
          resolucion.append('archivo_doc',archivo);
          resolucion.append('extension',extension);
          resolucion.append('nombre_archivo',nombre_archivo);

        }else if($('input:radio[name=doc]:checked').val()=='delegar'){

          if($('#delegar').val()==null || $('#delegar').val()==''){

            error('Datos Incompletos', 'No ha seleccionado un usuario para delegar la tarea', 'modalDatosTarea');
            $('span[aria-labelledby="select2-delegar-container"]').addClass('error');
            return 0;
          }
            resolucion.append('usuario_delegado',$('#delegar').val());
        }
      }else if( $('#tipoResolucion').val() == 'audiencia' ){
        
        if( $('input:radio[name=doc]:checked').val() == 'crear_audiencia' ) {

          
          if( $('#id_tipo_audiencia').val() == '' && $('#id_tipo_audiencia_select').val() == '' ) {

            error('Datos Incompletos', 'Falta el tipo de audiencia', 'modalDatosTarea');
            $('span[aria-labelledby="select2-id_tipo_audiencia_select-container"]').addClass('error');
            $("#id_tipo_audiencia").addClass('error');
            $('#tabDatosGenerales').click();
            return 0;

          }

          if( $('#id_juez_asignado').val() == '' && $('#jueces_ejecucion').val() == '' ) {
            error('Datos Incompletos', 'Falta seleccionar a un juez', 'modalDatosTarea');
            $('span[aria-labelledby="select2-jueces_ejecucion-container"]').addClass('error');
            $("#id_juez_asignado").addClass('error');
            $('#tabCalendar').click();
            return 0;
          }

          if( $('#select_inmueble_salas').val() == null ||  $('#select_inmueble_salas').val() == '' ){
            error('Datos Incompletos', 'No ha seleccionado una sala', 'modalDatosTarea');
            $('span[aria-labelledby="select2-select_inmueble_salas-container"]').addClass('error');
            $('#tabCalendar').addClass('error');
            return 0;
          }

          if( !expRegHora.test($('#tp_hora_inicio').val()) ) {

            error('Datos Incompletos', 'No ha indicado la hora de inicio de la audiencia', 'modalDatosTarea');
            $('#tp_hora_inicio').addClass('error');
            $('#tabCalendar').click();
            return 0;
          }

          if( !expRegHora.test($('#tp_hora_final').val()) ) {
            error('Datos Incompletos', 'No ha indicado la hora final de la audiencia o el formato es invalido (HH:mm)', 'modalDatosTarea');
            $('#tp_hora_final').addClass('error');
            $('#tabCalendar').addClass('error');
            return 0;
          }

          if( horario_valido !=1 ) {
            error('Datos Incompletos', 'Debe seleccionar un horario válido o el formato es invalido (HH:mm)', 'modalDatosTarea');
            $('#tp_hora_inicio').addClass('error');
            $('#tp_hora_final').addClass('error');
            $('#tabCalendar').addClass('error');
            return 0;
          }

          if( $('#tp_hora_final').val() <= $('#tp_hora_inicio').val() ) {
            error('Datos Incompletos', 'Debe leccionar un horario válido o el formato es invalido (HH:mm)', 'modalDatosTarea');
            $('#tp_hora_inicio').addClass('error');
            $('#tp_hora_final').addClass('error');
            $('#tabCalendar').addClass('error');
            return 0;
          }
        } else if( $('input[name="doc"]:checked').val() == 'delegar' ) {
          
          if( $('#delegar').val() == null || $('#delegar').val()=='' ) {
            error('Datos Incompletos', 'No ha indicado el usuario al que se le delegará la tarea', 'modalDatosTarea');
            $('#select2-delegar-container').addClass('error');
            return false;
          }

        }
      }

      confirmarResolucionPromocion();
    }

    function confirmarResolucionSolicitud(){
      const { clave_bandeja } = tareaSeleccionada;
      let continuar_ = true;
      if( tareaSeleccionada.tipo_solicitud_ == 'PRO-MUJER' || ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 )) {
        
        $($('#victimaFracciones option')).each( function( i, victima ) {
          if( !fracciones_acuerdo[($(this).val())] && $(this).val() != '' ) 
            continuar_ = error('Datos Incompletos', 'No ha seleccionado las medidad de protección para la víctima '+$(this).text(), 'modalDatosTarea');
        });
      }
      
      if( !continuar_ ) 
        return false;
       
      if( $('#tipoResolucion').val() == 'acuerdo' ) {
       
        if( ['RS', 'REJEC'].includes(clave_bandeja)){

          if( configuracion.resolucion_permiso.acuerdo ) {

            if($('input:radio[name=doc]:checked').val()=='subir'){

              const juez=$('#usuario_destino').find('option:selected').text()
              $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);

            }else if($('input:radio[name=doc]:checked').val()=='crear'){
              const juez=$('#usuario_destino').find('option:selected').text()
              $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);

            }else if($('input:radio[name=doc]:checked').val()=='delegar'){
              const juez=$('#delegar').find('option:selected').text()
              $('#mensajeConfirmar').html(`La tarea se delegará  a: ${juez}`);
            }

          } else {

            $('#mensajeConfirmar').html(`La tarea se asignará al Subdirector de Causa para agregar el acuerdo`);

          }

        } else if( clave_bandeja=='CACU' ){

          if( $('#tipoResolucion').val() == 'acuerdo' ) {

            if( $('#accion').val() == "revision" ) {

              $('#mensajeConfirmar').html(`El acuerdo se enviará al Subdirector de Causa para su revisión`);

            } else if( $('#accion').val() == "firma" ) {
 
              const juez=$('#usuario_destino option:selected').text()
              $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al: ${juez}`);

            }
          }
        }else if( clave_bandeja=='RE' ) {

          if($('input:radio[name=doc]:checked').val()=='subir'){

            const juez=$('#usuario_destino').find('option:selected').text()
            $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);

          }else if($('input:radio[name=doc]:checked').val()=='crear'){ 

            const juez=$('#usuario_destino').find('option:selected').text()
            $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);

          }else if($('input:radio[name=doc]:checked').val()=='delegar'){

            const juez=$('#delegar').find('option:selected').text()
            $('#mensajeConfirmar').html(`La tarea se delegará  a: ${juez}`);
            
          }
        } else {
          
          if( resolucion_permiso.acuerdo ) {
          
          }else {
            $('#mensajeConfirmar').html(`La tarea se asignará al Subdirector de Causa para crear el acuerdo`);
          
          }

        }

      }else if( $('#tipoResolucion').val() == 'audiencia' ) {

        if( resolucion_permiso.audiencia ) {
          
          if( $('input[name="doc"]:checked').val() == 'crear_audiencia' ) {
            
            const fecha = moment($('#fecha_audiencia_hidden').val()).format('dddd LL'),
                inicio = $('#tp_hora_inicio').val(),
                fin = $('#tp_hora_final').val();
          
            $('#mensajeConfirmar').html(`Se agendará la audiencia para el dia ${fecha} de ${inicio} a ${fin} hrs.`);

          } else if( $('input[name="doc"]:checked').val() == 'delegar' ) {

            const usuario_delegar = $('#delegar option:selected').text();

            $('#mensajeConfirmar').html(`La tarea se delegará al usuario: ${usuario_delegar} para agendar la audiencia`);  

          }

        } else {

          $('#mensajeConfirmar').html(`La tarea se asignará al Subdirector de Sala para agendar la audiencia`);

        }
          
      }

      

      $('#modalDatosTarea').modal('hide');
      abreModal('modalConfirmacion',350);

      $('#regresar').attr('onclick','abreModal(`modalDatosTarea`,400)');
      $('#btnResolver').attr('onclick','resolverTareaSolicitud()');

    }

    function confirmarResolucionPromocion(){
      const { clave_bandeja } = tareaSeleccionada;
      if( $('#tipoResolucion').val() == 'acuerdo' ){
        if(clave_bandeja=='RP' || clave_bandeja == 'CAUD' || clave_bandeja == 'RAC'){
          @if(Session::get('id_tipo_usuario')==3 || in_array(Session::get('id_tipo_usuario'),$ejecucion_promocion))
            if($('input:radio[name=doc]:checked').val()=='subir'){

              const juez=$('#usuario_destino').find('option:selected').text()
              $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);

            }else if($('input:radio[name=doc]:checked').val()=='crear'){
              const juez=$('#usuario_destino').find('option:selected').text()
              $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);

            }else if($('input:radio[name=doc]:checked').val()=='delegar'){
              const juez=$('#delegar').find('option:selected').text()
              $('#mensajeConfirmar').html(`La tarea se delegará  a: ${juez}`);
            }

          @else
            if($('#tipoResolucion').val()=='acuerdo'){
              $('#mensajeConfirmar').html(`La tarea se asignará al Subdirector de Causa para agregar el acuerdo`);
            }
          @endif
        } else if(clave_bandeja=='CACU'){
          if($('#tipoResolucion').val()=='acuerdo'){
            if($('#accion').val()=="revision"){
              $('#mensajeConfirmar').html(`El acuerdo se enviará al Subdirector de Causa para su revisión`);
            }else if($('#accion').val()=="firma"){
              const juez=$('#usuario_destino').find('option:selected').text()
              $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);
            }
          }
        }else if(clave_bandeja=='RE'){

          if($('input:radio[name=doc]:checked').val()=='subir'){

            const juez=$('#usuario_destino').find('option:selected').text()
            $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);

          }else if($('input:radio[name=doc]:checked').val()=='crear'){
            const juez=$('#usuario_destino').find('option:selected').text()
            $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);

          }else if($('input:radio[name=doc]:checked').val()=='delegar'){
            const juez=$('#delegar').find('option:selected').text()
            $('#mensajeConfirmar').html(`La tarea se delegará  a: ${juez}`);
          }
        }
      }else if( $('#tipoResolucion').val() == 'audiencia' ){
        
        if( resolucion_permiso.audiencia ) {

          if( $('input[name="doc"]:checked').val() == 'crear_audiencia' ) {

            const fecha = moment($('#fecha_audiencia_hidden').val()).format('dddd LL'),
                  inicio=$('#tp_hora_inicio').val(),
                  fin=$('#tp_hora_final').val();
            $('#mensajeConfirmar').html(`Se agendará la audiencia para el dia ${fecha} de ${inicio} a ${fin} hrs.`);
          } else if( $('input[name="doc"]:checked').val() == 'delegar' ) {

            const usuario_delegar = $('#delegar option:selected').text();

            $('#mensajeConfirmar').html(`La tarea se delegará al usuario: ${usuario_delegar} para agendar la audiencia`);  

          }

        } else {
         
          $('#mensajeConfirmar').html(`La tarea se asignará al Subdirector de Sala para agendar la audiencia`);

        }

      }


      $('#modalDatosTarea').modal('hide');
      abreModal('modalConfirmacion',350);

      $('#regresar').attr('onclick','abreModal(`modalDatosTarea`,400)');
      $('#btnResolver').attr('onclick','resolverTareaPromocion()');
    }

    async function resolverTareaPromocion(){
      const { clave_bandeja } = tareaSeleccionada;
      resolucion.append('comentarios',$('#comentarios').val());

      if( $('#tipoResolucion').val() == "audiencia"){

        if( $('input[name="doc"]:checked').val() == 'crear_audiencia' ) {

          resolucion.append('id_inmueble',$('#select_inmueble').val());
          resolucion.append('id_sala',$('#select_inmueble_salas').val());
          resolucion.append('id_juez',$('#id_juez_asignado').val());
          resolucion.append('id_juez_ejecucion', $('#jueces_ejecucion').val());
          resolucion.append('cve_juez',$('#clave_juez_asignado').val());
          resolucion.append('cve_juez_ejecucion', $('#jueces_ejecucion option:selected').attr('cve-juez'));
          resolucion.append('fecha_audiencia',$('#fecha_audiencia_hidden').val());
          resolucion.append('hora_inicio_audiencia',$('#tp_hora_inicio').val());
          resolucion.append('hora_fin_audiencia',$('#tp_hora_final').val());
          resolucion.append('bandera_juez_excusa',$('#bandera_juez_excusa').val());
          resolucion.append('bandera_juez_tramite',$('#bandera_juez_tramite').val());
          resolucion.append('comentarios_excusa',$('#comentarios_excusa').val());
          resolucion.append('recursos_arr',JSON.stringify(recursos_adi));

          resolucion.append('id_tipo_audiencia',$('#id_tipo_audiencia').val());
          resolucion.append('id_tipo_audiencia_select', $('#id_tipo_audiencia_select').val());

        } else if( $('input[name="doc"]:checked').val() == 'delegar' ) {
          
          resolucion.append('usuario_delegado',$('#delegar').val());

        }
      }
      // resolucion.append('promocion', promocion);
      $('#modal_loading').modal('show');
      $('#modalConfirmacion').modal('hide');
      $.ajax({
        method:'POST',
        url:'/public/resolver_tarea_promocion',
        data:resolucion,
        contentType: false,
        processData: false,
        asynct:false,
        cache: false,
        success:async function(response){

          if( response[0].status == 100 ) {
            
            if( $('#tipoResolucion').val() == 'acuerdo'){
              
              if(clave_bandeja=='RP' || clave_bandeja == 'CAUD') {

                if( !configuracion.resolucion_permiso.acuerdo ) {

                  const message=response[0].message.split('-')[1];
                  $('#successMessage').html(`${message}`);
                  cierraLoading(200);
                  $('#modalSuccess').modal('show');
                  
                }else {

                  if( $('input:radio[name=doc]:checked').val() == 'delegar' ) {

                    const message=response[0].message.split('-')[1],
                          nombre_usuario=$('#delegar').find('option:selected').text();
                    $('#successMessage').html(`${message} para el usuario ${nombre_usuario}`);
                    cierraLoading(350);
                    $('#modalSuccess').modal('show');

                  }else if( $('input:radio[name=doc]:checked').val() == 'subir' || $('input:radio[name=doc]:checked').val() == 'crear' ) {

                    const message=response[0].message.split('-')[1],
                          nombre_usuario=$('#usuario_destino').find('option:selected').text(),
                          acuerdo=response[0].response.id_acuerdo;

                    await avanzar(acuerdo, nombre_usuario, 'firma');
                    cierraLoading(350);

                  }

                }
              }else if(clave_bandeja=="CACU" || clave_bandeja=="RE"){

                const message=response[0].message.split('-')[1],
                      nombre_usuario=$('#usuario_destino').find('option:selected').text(),
                      acuerdo=response[0].response.id_acuerdo;
                if($('#accion').val()=='revision'){
                  await avanzar(acuerdo, nombre_usuario, 'revision');
                }else{
                  await avanzar(acuerdo, nombre_usuario, 'firma');
                }

                cierraLoading(350);
              }
            }else{

              if( $('input[name="doc"]:checked').val() == 'crear_audiencia' ) {
                
                const exp = response[1].data_audiencia.fecha_audiencia.split('-');

                if( configuracion.resolucion_permiso.audiencia ) {

                  const fecha = `${exp[2]}-${exp[1]}-${exp[0]}`;
                  var message = `Audiencia Programada <br>Dia: <span>${fecha}</span> <br> Hora de inicio: <span>${response[1].data_audiencia.hora_inicio_audiencia}</span>` ;

                }else {

                  var message= response[0].message ;

                }
                

              } else if( $('input[name="doc"]:checked').val() == 'delegar' ) { 

                var message = response[0].message ;

              }

              $('#successMessage').html(message);
              cierraLoading(600, 'modalSuccess');

            }
            buscar(1);
            countBandejas();
          }else{
            error("Error",response[0].message);
          }
          cierraLoading(400);
        }
      });

    }


    async function resolverPorAcuerdo() {

      
      const { clave_bandeja, tabla_asociada } = tareaSeleccionada;
      const usuarios = await obtenerGrupoTrabajo();
      let jueces = '';
      if( juez_ejec != '' && juez_ejec != null)
        jueces = await obtenerJueces(juez_ejec, 1);
      else if( clave_bandeja == 'REJEC' && tabla_asociada == 'remisiones' )
        jueces = await obtenerJueces(tareaSeleccionada.datos_cj.id_juez_ejecucion);
      else
        jueces = await obtenerJueces(tareaSeleccionada.id_juez_promujer);

      let accion='';

      @if(Session::get('id_tipo_usuario')==3)
        accion=`
          <div class="form-group">
            <label class="form-control-label">Enviar a:</label>
            <select class="form-control" id="accion" name="accion" autocomplete="off" onchange="firmante()">
              <option  value="firma">FIRMA</option>
            </select>
          </div>
        `;
      @else
        accion=`
            <div class="form-group">
              <label class="form-control-label">Enviar a:</label>
              <select class="form-control" id="accion" name="accion" autocomplete="off" onchange="firmante()">
                <option  value="revision">REVISIÓN</option>
                <option  value="firma" selected>FIRMA</option>
              </select>
            </div>
          `;
      @endif

      if( ['RE', 'REJEC'].includes(clave_bandeja) ){
        accion=`
          <div class="form-group">
            <label class="form-control-label">Enviar a:</label>
            <select class="form-control" id="accion" name="accion" autocomplete="off" onchange="firmante()">
              <option  value="firma">FIRMA</option>
            </select>
          </div>
        `;
      }
      // alert('va por acá');
      const res=`
        <div class="row mg-t-15 pd-r-10 pd-l-10">
          <div class="col-md-4">
            <label class="rdiobox">
              <input name="doc" type="radio" checked value="subir" class="doc" onchange="tipoDocumento()">
              <span>Subir Documento</span>
            </label>
          </div>
          <div class="col-md-4">
            <label class="rdiobox">
              <input name="doc" type="radio" value="crear" class="doc" onchange="tipoDocumento()">
              <span>Crear Documento en Línea</span>
            </label>
          </div>
          <div class="col-md-4 ${usuarios == '' ? 'd-none' : ''}">
            <label class="rdiobox">
              <input name="doc" type="radio" value="delegar" class="doc" onchange="tipoDocumento()">
              <span>Delegar Tarea</span>
            </label>
          </div>
        </div>
        <hr>
        <div style="background: #f8f9fa; padding: 10px; min-height: 470px; border: 1px solid #eee;">
          <div class="row mg-t-30">
            <div id="divAccion" class="col-md-4">
              ${accion}
            </div>
            <div class="col-md-4"  id="divFirmante">
              <div class="form-group">
                <label class="form-control-label">Juez Firmante:</label>
                <select class="form-control" id="usuario_destino" name="usuario_destino" autocomplete="off" @if($sesion['id_tipo_usuario']!=3){{"disabled"}}@endif>
                  ${jueces}
                </select>
              </div>
            </div>
            <div id="divTipoArchivo" class="col-md-4">
              <div class="form-group">
                <label class="form-control-label">Tipo Archivo:</label>
                <select class="form-control" id="tipoArchivo" name="tipo_archivo" autocomplete="off">
                  <option  value="207">ACUERDO</option>
                  <option  value="122">AUTO</option>
                  <option  value="505">CONSTANCIA</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 d-none" id="divNombreHTML" style="display:none">
              <div class="form-group">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Nombre del documento:</label>
                  <input class="form-control" type="text" name="nombre_html" id="nombreHTML" autocomplete="off">
                </div>
              </div>
            </div><!-- col-3 -->
          </div>
          <div class="mg-t-40" id="porDOC">
            <div class="custom-input-file">
              <input type="file" id="archivoDoc" class="input-file" value="" name="archivo_doc" onchange="leeDocumento('archivoDoc')" accept=".doc,.docx,.pdf">
              <h5 class="px-3 py-3">Arrastre hasta aquí su documento de Word o de clic para adjuntarlo</h5>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div id="docSeleccionado" class="mg-t-40">
                </div>
              </div>
              <div class="col-md-9" id="vistaPreviaDocPDF">

              </div>
            </div>
          </div>
          <div class="d-none" id="porHTML">
            <div id="editor" style="text-align: -webkit-center;">
              <div id='edit' style="margin-top: 20px; width:100%;">
                <table>
                  <tbody>
                    <tr>
                      <td>
                        <img src="http://172.19.228.38:8083/images/logoTSJCDMX2.png" style="height: 100px;" id="logo_tsj">
                      </td>
                      <td>
                        <p>"${leyenda}"</p>
                        <img src="http://172.19.228.38:8083/images/logoDEGJ.png" style="height: 100px;" id="logo_tsj">
                      </td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <br>
                <p>
                  Escriba aquí ...
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                </p>
              </div>
            </div>
          </div>
          <div class="mg-t-40 d-none" id="delegarTarea">
            <h5 class="mg-t-15">Seleccione el usuario a quien se le delegará la tarea</h5>
            <div class="form-group">
              <label class="form-control-label">Usuario:</label>
              <select class="form-control select2-show-search" id="delegar" name="delegar" autocomplete="off">
                <option selected value="" disabled>Elija un usuario</option>
                ${usuarios}
              </select>
            </div>
          </div>
        </div>
      `;

      $('#resolucion').html(res);

      $('#tipoArchivo').select2({minimumResultsForSearch: Infinity});
      $('#accion').select2({minimumResultsForSearch: Infinity});
      $('#delegar').select2({minimumResultsForSearch: ''});
      $('#usuario_destino').select2({minimumResultsForSearch: ''});
      $('#tabCalendar').click();
      firmante();
      editorHTML();
      setTimeout(function(){
        $( "#editor div:nth-child(1) div:nth-child(1)" ).addClass( "show-placeholder");
        $( "#editor td:nth-child(1)" ).css( {"width":"50%", "padding-top":"10px"} );
        $( "#editor img:nth-child(1)" ).css( {"height":"100px"} );
        $( "#editor td:nth-child(2)" ).css( {"text-align": "right", "width":"50%"} );
        $( "#editor img:nth-child(2)" ).css( {"height": "90px", "margin-left":"auto"} );
        $( "#editor td:nth-child(2) p" ).css( {"font-weigth":"bold", "font-style": "italic", "font-size": "18px", "margin-bottom": "0px"} );
      }, 500);
      
      juez_ejec = '';
    }

    async function verPromocion(){

      datosPromocion = await obtenerDatosPromocion( tareaSeleccionada.id_tabla_asociada );

      if( datosPromocion.status == 100 )
        Object.assign( tareaSeleccionada, datosPromocion.response[0] );
      else
        return error( 'Error en consulta de promoción', datosPromocion.message );

      const { folio_promocion, folio_carpeta,nombre_promovente, promovente_calidad_juridica, tipo_requerimiento, id_juez_ejecucion, id_solicitud,id_tabla_asociada, tipo_solicitud_,tipo_resolucion_solicitud,id_juez_promujer, clave_bandeja} = tareaSeleccionada;

      let documentos = '';
      dataPDF =  await obtenerDocumentosPromocion( tareaSeleccionada.id_tabla_asociada );
      if( dataPDF.status == 100 ) documentos += `<object data="${dataPDF.response}"  id="documentoPDF" width="100%" height="350px" class="mg-t-25"></object>`;

      let tablePromocion = '<table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; "><tbody class="table-datos-sujeto"><tr><td colspan="2" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la promoción</td></tr>'
        
      const datos_tabla_promocion = [
        ["Folio de la promoción:", folio_promocion],
        ["Carpeta de investigación:", folio_carpeta],
        ["Promovente:", nombre_promovente],
        ["Calidad juridica del promovente", promovente_calidad_juridica == null ? '' : promovente_calidad_juridica],
        ["Tipo de requerimiento", tipo_requerimiento == null ? '' : tipo_requerimiento],
      ];

      $( datos_tabla_promocion ).each( function ( i, campo ) {
        tablePromocion += `<tr><td>${campo[0]}</td><td>${campo[1]}</td></tr>`;
      });

      let cards_partes = '';

      const partes_carpeta = await obtenerPersonasCarpeta( tareaSeleccionada.id_carpeta_judicial );
      console.log( partes_carpeta );
      const personas_carpeta_asc= partes_carpeta.response.personas .sort( (a,b) => {
              
        if ( a.info_principal.id_calidad_juridica > b.info_principal.id_calidad_juridica ) return 1;
        if ( a.info_principal.id_calidad_juridica < b.info_principal.id_calidad_juridica ) return -1;
        
        return 0;

      });

      $( personas_carpeta_asc ).each(function(index, persona){

          const {alias, contacto, delitos, datos, direcciones, info_principal, id_unidad}= persona;

          unidad_tarea=id_unidad;

          let listaDelitos='',
              listaAlias='',
              listaCorreos='',
              listaTelefonos='',
              listaDirecciones='';

          $(alias).each( (index, aliasSujeto) => { listaAlias += aliasSujeto.alias + '<br>'; });

          $(contacto).each(function(index,contactoSujeto){
            const {id_contacto_persona,tipo_contacto, contacto, estatus, extension}=contactoSujeto;
            if( estatus == 1)
              if( tipo_contacto == 'correo electronico' ) listaCorreos += contacto + '<br>';
              else listaTelefonos += tipo_contacto + ': ' + contacto + ' ' + (extension == null ? '' : 'ext ' +extension) + '<br>';
          });

          $(direcciones).each(function( index, direccionSujeto ){

            const { estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle} = direccionSujeto;

            const tableDireccion=`
              <br>
              <table class="datatable tableDatosSujeto tx-uppercase" style=:"overflow-x: none; ">
                <tbody class="table-datos-sujeto">
                  <tr>
                    <td colspan="4" style="background-color: #848F33; color: #FFF;" class="tx-center">Domicilio ${index+1}</td>
                  </tr>
                  <tr>
                    <td>Calle</td>
                    <td>${calle==null?'':calle}</td>
                    <td>Número Exterior</td>
                    <td>${numero_exterior==null?'':numero_exterior}</td>
                  </tr>
                  <tr>
                    <td>Número Interior</td>
                    <td>${numero_interior==null?'':numero_interior}</td>
                    <td>Localidad</td>
                    <td>${localidad==null?'':localidad}</td>
                  </tr>
                  <tr>
                    <td>Colonia</td>
                    <td>${colonia==null?'':colonia}</td>
                    <td>Municipio</td>
                    <td>${municipio_text==null?'':municipio_text}</td>
                  </tr>
                  <tr>
                    <td>Estado</td>
                    <td>${estado_text==null?'':estado_text}</td>
                    <td>Entre Calle y Calle</td>
                    <td>${entre_calle==null?'':entre_calle}</td>
                  </tr>
                  <tr>
                    <td>Otras Referencias</td>
                    <td>${otra_referencia==null?'':otra_referencia}</td>
                  </tr>
                </tbody>
              </table>  `
            ;

            listaDirecciones=listaDirecciones.concat(tableDireccion);

          });
          
          const {calidad_juridica,razon_social,nombre,apellido_paterno,apellido_materno,rfc_empresa,curp,cedula_profesional,genero,fecha_nacimiento,nacionalidad,estado_civil} = info_principal;

          ocupacion='';
          let table = '';

          const {otra_ocupacion,nivel_escolaridad,otra_escolaridad,nombre_religion,otra_religion,grupo_etnico,otro_grupo_etnico,lengua,capacidad_diferente,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,poblacion,otra_poblacion,nombre_poblacion,entiende_idioma_espanol,requiere_interprete,tipo_interprete,requiere_traductor,idioma_traductor,otro_idioma_traductor}=datos[0];
          
          table += '<table class="datatable tableDatosSujeto text-uppercase" style="overflow-x: none;  color : #000"><tbody class="table-datos-sujeto"><tr><td style="background-color: #848F33; color: #FFF;" class="tx-center" colspan="4">Datos generales de la parte</td></tr>';

          const campos_datos_persona = [
            ["Calidad juridica:", calidad_juridica],
            ["Ocupación:", ocupacion == null ? '' : ocupacion],
            ["Nombre o razón social:", razon_social == null ? '' : razon_social+nombre == null ? '' : nombre + ' ' + apellido_paterno == null ? '' : apellido_paterno + ' ' + apellido_materno == null ? '' : apellido_materno],
            ["Otra ocupación:", otra_ocupacion == null ? '' : otra_ocupacion],
            ["RFC:", rfc_empresa == null ? '' : rfc_empresa],
            ["Escolaridad:", nivel_escolaridad == null ? '' : nivel_escolaridad],
            ["CURP:", curp == null ? '' : curp],
            ["Otra escolaridad:", otra_escolaridad == null ? '' : otra_escolaridad],
            ["Cédula profesional:", cedula_profesional == null ? '' : cedula_profesional],
            ["Religión:", nombre_religion == null ? '' : nombre_religion],
            ["Género:", genero == null ? '' : genero],
            ["Otra religión:", otra_religion == null ? '' : otra_religion],
            ["Fecha de nacimiento:", fecha_nacimiento == null ? '' : formatoFecha(fecha_nacimiento)],
            ["Grupo étnico:", grupo_etnico == null ? '' : grupo_etnico],
            ["Nacionalidad:", nacionalidad == null ? '' : nacionalidad],
            ["Otro grupo étnico:", otro_grupo_etnico == null ? '' : otro_grupo_etnico],
            ["Estado civil:", estado_civil == null ? '' : estado_civil],
            ["Lengua:", lengua == null ? '' : lengua],
            ["Capacidad diferente:", capacidad_diferente == null ? '' : capacidad_diferente],
            ["Discapacidad:", descripcion_discapacidad == null ? '' : descripcion_discapacidad],
            ["Sabe leer y escribir:", sabe_leer_escribir],
            ["Población callejera:", poblacion_callejera == null ? '' : poblacion_callejera],
            ["Población:", poblacion == null ? '' : poblacion],
            ["Otra población:", otra_poblacion == null ? '' : otra_poblacion],
            ["Nombre población:", nombre_poblacion == null ? '' : nombre_poblacion],
            ["Entiende el idioma español:", entiende_idioma_espanol == null ? '' : entiende_idioma_espanol],
            ["Requiere intérprete:", requiere_interprete == null ? '' : requiere_interprete],
            ["Tipo intérprete:", tipo_interprete == null ? '' : tipo_interprete],
            ["Requiere traductor:", requiere_traductor == null ? '' : requiere_traductor],
            ["Idioma traductor:", idioma_traductor == null ? '' : idioma_traductor],
            ["Otro idioma del traductor:", otro_idioma_traductor == null ? '' : otro_idioma_traductor],
          ];

          $( campos_datos_persona).each( function( i, campo ) {
            if( i%2 == 0 ) table += `<tr>`;
            table += `<td>${campo[0]}</td><td>${campo[1]}</td>`;
            if( i%2 != 0 ) table += `</tr>`;
          });
          
          table += '</tbody></table>';
          table += '<div class="row">';
          table +=`
            <div class="col-md-4">
              <br>
              <table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color : #000">
                <thead>
                  <tr>
                    <td style="background-color: #848F33; color: #FFF;" class="tx-center">Teléfonos</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>${listaTelefonos==''?'<span class="tx-italic" style="color: #868ba1">Sin teléfonos registrados</span>':listaTelefonos}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          `;

          table +=`
            <div class="col-md-4">
              <br>
              <table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color : #000">
                <thead>
                  <tr>
                    <td style="background-color: #848F33; color: #FFF;" class="tx-center">Correos</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>${listaCorreos==''?'<span class="tx-italic" style="color: #868ba1">Sin correos registrados</span>':listaCorreos}</td>
                    </tr>
                </tbody>
              </table>
            </div>
          `;

          table +=`
            <div class="col-md-4">
              <br>
              <table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color : #000">
                <thead>
                  <tr>
                    <td style="background-color: #848F33; color: #FFF;" class="tx-center">Alias</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>${listaAlias==''?'<span class="tx-italic" style="color: #868ba1">Sin alias registrados</span>':listaAlias}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          `;

          table += '</div>';

          table += listaDirecciones;

          const elementoPersona=`
            <div id="accordion${index}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
              <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                  <a data-toggle="collapse" data-parent="#accordion${index}" href="#collapseOne${index}" aria-expanded="true" aria-controls="collapseOne${index}" class="tx-gray-800 transition collapsed">
                    ${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno} <small style="color: #8A8A8A; font-weight: bold;">[${calidad_juridica}]</small>
                  </a>
                </div><!-- card-header -->

                <div id="collapseOne${index}" class="collapse" role="tabpanel" aria-labelledby="headingOne${index}">
                  <div class="card-body" >
                    ${table}
                  </div>
                </div>
              </div>
            </div>
          `;

          cards_partes += elementoPersona;

          });

      
    
      tablePromocion += '</tbody></table>';
          
      let tipoResolucion=`
        <div class="form-group">
          <label class="form-control-label">Resolver por:</label>
          <select class="form-control select2" id="tipoResolucion" name="tipo_resolucion" autocomplete="off">
            ${configuracion.select_tipo_resolucion}
          </select>
        </div>
      `;


      const usuarios=await obtenerGrupoTrabajo(),
            jueces=await obtenerJueces(id_juez_promujer);

      let accion='';

      @if(Session::get('id_tipo_usuario')==3)
        accion=`
          <div class="form-group">
            <label class="form-control-label">Enviar a:</label>
            <select class="form-control" id="accion" name="accion" autocomplete="off" onchange="firmante()">
              <option  value="firma">FIRMA</option>
            </select>
          </div>
        `;
      @else
        accion=`
            <div class="form-group">
              <label class="form-control-label">Enviar a:</label>
              <select class="form-control" id="accion" name="accion" autocomplete="off" onchange="firmante()">
                <option  value="revision">REVISIÓN</option>
                <option  value="firma">FIRMA</option>
              </select>
            </div>
          `;
      @endif

      if(clave_bandeja=='RE'){
        accion=`
          <div class="form-group">
            <label class="form-control-label">Enviar a:</label>
            <select class="form-control" id="accion" name="accion" autocomplete="off" onchange="firmante()">
              <option  value="firma">FIRMA</option>
            </select>
          </div>
        `;
      }

      $('#divTarea').append(`
        <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
          <div id="validacionDatos">
            ${tipoResolucion}
            <div class="card" style="min-height: 481px;">
              <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#divSolicitud" data-toggle="tab">Datos Promoción</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#divPartes" data-toggle="tab">Partes</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#divDocumentos" data-toggle="tab">Documentos</a>
                  </li>
                </ul>
              </div><!-- card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="divSolicitud">
                    ${tablePromocion}
                  </div><!-- tab-pane -->
                  <div class="tab-pane" id="divDocumentos">
                    ${documentos}
                  </div><!-- tab-pane -->
                  <div class="tab-pane" id="divPartes">
                    ${cards_partes}
                  </div><!-- tab-pane -->
                </div><!-- tab-content -->
              </div><!-- card-body -->
            </div><!-- card -->
          </div>
          <hr>
          <div id="resolucion" class="d-none">
          </div>
        </form>
      `);

      $('#tipoResolucion').select2({minimumResultsForSearch: Infinity});
      $('#tipoArchivo').select2({minimumResultsForSearch: Infinity});
      $('#accion').select2({minimumResultsForSearch: Infinity});
      $('#delegar').select2({minimumResultsForSearch: ''});
      $('#usuario_destino').select2({minimumResultsForSearch: ''});
      firmante();
      editorHTML();
      setTimeout(function(){
        $( "#editor div:nth-child(1) div:nth-child(1)" ).addClass( "show-placeholder");
        $( "#editor td:nth-child(1)" ).css( {"width":"50%", "padding-top":"10px"} );
        $( "#editor img:nth-child(1)" ).css( {"height":"100px"} );
        $( "#editor td:nth-child(2)" ).css( {"text-align": "right", "width":"50%"} );
        $( "#editor img:nth-child(2)" ).css( {"height": "90px", "margin-left":"auto"} );
        $( "#editor td:nth-child(2) p" ).css( {"font-weigth":"bold", "font-style": "italic", "font-size": "18px", "margin-bottom": "0px"} );
      }, 500);
    }

    async function verRemision() {

      if( tareaSeleccionada.estatus_bandeja == 'atendida' ) {

          const objRemision = await new Remision( tareaSeleccionada.id_tabla_asociada )

          const vista = await objRemision.consultaDatosRemisionEjecucion()

          $('#divTarea').append( vista )

      } else {

        const {id_tabla_asociada, id_remision} = tareaSeleccionada;
        
        let documentos='', 
          enlaces_documentos = '',
          object_documento = '';

        versiones = await obtenerDocumentosRemision(id_tabla_asociada);
        
        $(versiones.response).each(function(index, version){

          tipoArchivo=version.extension_archivo
          switch (tipoArchivo){
            case 'pdf':
              icono = '<i class="fa fa-file-pdf-o mg-r-10" aria-hidden="true" style="font-size:20px;"></i>';
              break;
            case 'jpg':
            case 'png':
            case 'JPEG ':
              icono = '<i class="fa fa-file-image-o mg-r-10" aria-hidden="true" style="font-size:20px;"></i>';
              break;
            default:
              icono = '<i class="fa fa-question mg-r-10" aria-hidden="true" style="font-size:20px;"></i>';
          }


          enlaces_documentos +=`<a href="javascript:void(0)" onclick="verDocRemi(${index}, this)" class="${index == 0 ? 'bgDocRem' : ''}"><div style="border: 1px solid #ced4da; margin-bottom: 10px; padding: 10px; display: block;" class="doc_remi">${icono} ${version.nombre_archivo.replace(id_tabla_asociada+'_', '')}</div></a>`;

          object_documento +=`<object data="/obtener_documentos_remision/${id_tabla_asociada}/${version.id_documento}" class="documento_remision ${index == 0 ? '' : 'd-none'}"  id="documentoPDF${index}" width="100%" height="455px" name="${version.nombre_archivo}.${version.extension_archivo}"></object>`;
        });

        documentos += `
          <div class="row">
            <div class="col-md-3">${enlaces_documentos}</div>
            <div class="col-md-9 ">${object_documento}</div>
          </div>
        `;
        

        datosRemision= await obtenerDatosRemision(id_tabla_asociada);

        $('#divTarea').append(`
          <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
            <div id="validacionDatos">
              <div class="card" style="min-height: 481px;">
                <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#divSolicitud" data-toggle="tab">Datos Solicitud</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#divDatosSujeto" data-toggle="tab">Partes Procesales</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#divDocumentos" data-toggle="tab">Documentos</a>
                    </li>
                  </ul>
                </div><!-- card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="divSolicitud">
                      ${datosRemision.infoSolicitud}
                    </div><!-- tab-pane -->
                    <div class="tab-pane" id="divDatosSujeto">
                      ${datosRemision.elementosPersonas}
                    </div><!-- tab-pane -->
                    <div class="tab-pane" id="divDocumentos">
                      ${documentos}
                    </div><!-- tab-pane -->
                  </div><!-- tab-content -->
                </div><!-- card-body -->
              </div><!-- card -->
            </div>
          </form>
        `);
      }
    }

    async function resolverTareaSolicitud(){
      const { clave_bandeja } = tareaSeleccionada;
      resolucion.append('comentarios',$('#comentarios').val());
      // resolucion.append('unidad_gestion',unidad_tarea);


      //se agrega las audiencias al arreglo

      if($('#tipoResolucion').val()=="audiencia"){

        if( $('input[name="doc"]:checked').val() == 'crear_audiencia' ) {

          resolucion.append('id_inmueble',$('#select_inmueble').val());
          resolucion.append('id_sala',$('#select_inmueble_salas').val());
          resolucion.append('id_juez',$('#id_juez_asignado').val());
          resolucion.append('id_juez_ejecucion', $('#jueces_ejecucion').val());
          resolucion.append('cve_juez',$('#clave_juez_asignado').val());
          resolucion.append('cve_juez_ejecucion', $('#jueces_ejecucion option:selected').attr('cve-juez'));
          resolucion.append('fecha_audiencia',$('#fecha_audiencia_hidden').val());
          resolucion.append('hora_inicio_audiencia',$('#tp_hora_inicio').val());
          resolucion.append('hora_fin_audiencia',$('#tp_hora_final').val());
          resolucion.append('bandera_juez_excusa',$('#bandera_juez_excusa').val());
          resolucion.append('bandera_juez_tramite',$('#bandera_juez_tramite').val());
          resolucion.append('comentarios_excusa',$('#comentarios_excusa').val());
          resolucion.append('id_tipo_audiencia',$('#id_tipo_audiencia').val());
          resolucion.append('id_tipo_audiencia_select', $('#id_tipo_audiencia_select').val());
          resolucion.append('recursos_arr',JSON.stringify(recursos_adi));

        } else if( $('input[name="doc"]:checked').val() == 'delegar' ) {

          resolucion.append('usuario_delegado',$('#delegar').val());

        }
        
      }

      
      if( (tareaSeleccionada.tipo_solicitud_ == 'PRO-MUJER' || ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 )) && contiene_fracciones ){

        
        $($('#tabPaneFraccionesSol').find('table')).each( function() {
          
          const table = "#"+$(this).attr('id');
          const rows = $(table).dataTable().fnGetNodes();
          
          fracciones_acuerdo[$(rows[0]).find('.fraccion_acuerdo').attr('id-persona')] = [];
 
          $(rows).each( function( i, row) {
           
            let fraccion_valor = 0;
            if( $(this).find('.fraccion_acuerdo').find('.toggle-on').hasClass('active') )
              fraccion_valor = 1;

            let fraccion_descripcion_otros = '-';

            if( $(this).find('.fraccion_acuerdo').attr('id-cat') == 16  )
              fraccion_descripcion_otros =  $(this).find('input').val();

            const medidas = {
              id_fraccion: $(this).find('.fraccion_acuerdo').attr('id-cat'),
              valor_solicitado: fraccion_valor,
              descripcion_otros: fraccion_descripcion_otros,      
              id_persona: $(this).find('.fraccion_acuerdo').attr('id-persona'),
            };

            fracciones_acuerdo[$(this).find('.fraccion_acuerdo').attr('id-persona')].push(medidas);
            
          });

          if ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 ) {

            let medidasPersona = [];
            let persona;

            $(rows).each( function() {
              
              let fraccion_valor = 0;
              // const id_fraccion_valor = $(this).find('.fraccion_solicitud').attr('id');
              
              if( $(this).find('.fraccion_solicitud').find('.toggle-on').hasClass('active') )
                fraccion_valor = 1;

              let fraccion_descripcion_otros = '-';

              if( $(this).find('.fraccion_solicitud').attr('id-cat') == 16  )
                fraccion_descripcion_otros = $(this).find('input').val();

              const medidas = {
                id_cat: $(this).find('.fraccion_solicitud').attr('id-cat'),
                id_fraccion_valor: $(this).find('.fraccion_solicitud').attr('id-fraccion-solicitud'),
                fraccion_valor,
                fraccion_descripcion_otros,      
              };
              
              if( medidas.id_fraccion_valor != 0 )
                medidasPersona.push(medidas);

              persona = $(this).find('.fraccion_solicitud').attr('id-persona');

            });

            $.ajax({

              method: 'PATCH',
              url: '/public/modificar_medidas_proteccion_persona',
              data:{
                medidasPersona,
                persona,
                id_documento: tareaSeleccionada.id_solicitud,
                tipo: 'solicitud'
              },
              success: function(response){

                $('#check'+persona).removeClass('d-none');
                setTimeout( () => { $('#check'+persona).addClass('d-none'); }, 800);

              }
            });
          }
        });
        
        resolucion.append('fracciones', JSON.stringify(fracciones_acuerdo));

      }
      
      $('#modalConfirmacion').modal('hide');
      $('#modal_loading').modal('show');

      $.ajax({
        method:'POST',
        url:'/public/resolver_tarea_solicitud',
        data:resolucion,
        contentType: false,
        processData: false,
        asynct:false,
        cache: false,
        json: true,
        success:async function(response){

          if(response[0].status==100){
            if($('#tipoResolucion').val()=='acuerdo'){

              if(clave_bandeja=='RS' || clave_bandeja=='RP'){

                if( !configuracion.resolucion_permiso.acuerdo ) {
                  const message=response[0].message.split('-')[1];
                  $('#successMessage').html(`${message}`);
                  cierraLoading(200);
                  $('#modalSuccess').modal('show');

                } else {

                  if( $('input:radio[name=doc]:checked').val() == 'delegar' ) {

                    const message=response[0].message.split('-')[1],
                          nombre_usuario=$('#delegar').find('option:selected').text();
                    $('#successMessage').html(`${message} para el usuario ${nombre_usuario}`);
                    cierraLoading(350);
                    $('#modalSuccess').modal('show');

                  }else if( $('input:radio[name=doc]:checked').val() == 'subir' || $('input:radio[name=doc]:checked').val() == 'crear' ) {

                    const message=response[0].message.split('-')[1],
                          nombre_usuario=$('#usuario_destino').find('option:selected').text(),
                          acuerdo=response[0].response.id_acuerdo;

                    await avanzar(acuerdo, nombre_usuario, 'firma');
                    cierraLoading(350);

                  }
                }
              }else if( clave_bandeja == "RE" ) {
                
                const message = response[0].message.split('-')[1],
                      nombre_usuario = $('#usuario_destino').find('option:selected').text(),
                      acuerdo = response[0].response.id_acuerdo;

                if( $('#accion').val() == 'revision' )  await avanzar(acuerdo, nombre_usuario, 'revision');
                else await avanzar(acuerdo, nombre_usuario, 'firma');
                
                cierraLoading(350);

              }else if( clave_bandeja == "CACU" ) {

                const message=response[0].message.split('-')[1],
                  nombre_usuario=$('#usuario_destino option:selected').text(),
                  acuerdo=response[0].response.id_acuerdo;

                  if($('#accion').val()=='revision') await avanzar(acuerdo, nombre_usuario, 'revision');
                  else await avanzar(acuerdo, nombre_usuario, 'firma');
                  
                  $('#successMessage').html(`${message} para el usuario ${nombre_usuario}`); 
                  cierraLoading(350);
                  $('#modalSuccess').modal('show');
              }

            }else{

              if( $('input[name="doc"]:checked').val() == 'crear_audiencia' ) {
                
                const exp = response[1].data_audiencia.fecha_audiencia.split('-');

                if( configuracion.resolucion_permiso.audiencia ) {

                  const fecha=`${exp[2]}-${exp[1]}-${exp[0]}`;
                  var message = `${response[0].message} <br>Dia: <span>${fecha}</span> <br> Hora de inicio: <span>${response[1].data_audiencia.hora_inicio_audiencia}</span>` ;
                  console.log('agendada');
                  
                }else {

                  var message = response[0].message  ;

                }

                

              } else if( $('input[name="doc"]:checked').val() == 'delegar' ) { 
                
                var message = response[0].message;

              }

              $('#successMessage').html(message);
              cierraLoading(600, 'modalSuccess');
              // $('#modalSuccess').modal('show');
            }

            buscar(1);
            countBandejas();

          }else{

            error("Error",response[0].message, 'modalConfirmacion');

            if( $('#tipoResolucion').val() == 'audiencia' && $('input[name="doc"]:checked').val() == 'crear_audiencia' ) 
              obtener_horarios_salas();
            

          }
          
          cierraLoading(500);
        }
      });

    }

    async function resolverTareaAcuerdo(acuerdo, nombre_usuario='', accion=''){

      $('#modal_loading').modal('show');
      $('#modalConfirmacion').modal('hide');

      await avanzar(acuerdo, nombre_usuario, accion);

      setTimeout(()=>{
        $('#modal_loading').modal('hide');
      },200);

    }

    function resolverRemision(remision) {
      $('#modalDatosTarea').modal('hide');
      $('#regresar').attr('onclick',`abreModal('modalDatosTarea',500)`);
      if( configuracion.resolucion_permiso.autorizacion_remision ) {
        
        $('#mensajeConfirmar').html(`Seleccione la opción deseada para el seguimiento de la remisión`);
        $('#opConfirmar').html(`
          <div class="form-group">
            <label class="form-control-label">Autorizar: </label>
            <select class="form-control" id="autorizacionRem" name="estatus" autocomplete="off">
              <option selected value="si">Autorizar remisión</option>
              <option value="no">Solicitar cambios</option>
            </select>
          </div>
        `);
        abreModal('modalConfirmacion',500);
        $('#autorizacionRem').select2({minimumResultsForSearch: Infinity});
        $('#btnResolver').attr('onclick',`autorizacionRem(${remision})`);

      } else {

        $('#mensajeWarning').html(`
          <div class="warning-alert">
            <i class="fa fa-exclamation" aria-hidden="true"></i>
          </div>
          <p class="tx-center">Aún no se ha autorizado el seguimiento para la remisión</p>
        `);
        abreModal('modalWarning',500);

      }
    }

    function avanzar(acuerdo, nombre_usuario='', accion=''){
      resolucion.append('comentarios',$('#comentarios').val());

      if(accion=="delegado"){
        resolucion.append('usuario_destino',$('#delegar').val());
      }

      return new Promise(resolve => {
        resolucion.append('acuerdo',acuerdo);
        resolucion.append('accion',accion);
        $.ajax({
          method:'POST',
          url:'/public/avanzar_acuerdo',
          data:resolucion,
          contentType: false,
          processData: false,
          cache: false,
          success:function(response){
            if(response.status==100){
              const message=response.message;
              if(accion=='firma'){
                $('#successMessage').html(`${message} <br> Acuerdo enviado a ${nombre_usuario}`);
              }else{
                $('#successMessage').html(`${message}`);
              }
              $('#modalConfirmacion').modal('hide');
              $('#modalSuccess').modal('show');
              buscar(1);
              countBandejas();
            }
            resolve(response.status);
          }
        });
      });
    }

    function datausu(acuerdo, accion){

      return new Promise(resolve => {

        $.ajax({
          method:'POST',
          url:'/public/avanzar_acuerdo',
          data:{ datausu:'/datausu', accion, acuerdo },
          success:function(response){ resolve(response); }
        });
      });

    }

    function datausuOficio(id_unidad){

      return new Promise(resolve => {

        $.ajax({
          method:'POST',
          url:'/public/obtener_usuarios_por_tipo',
          data:{ id_unidad },
          success:function(response){ resolve(response); }
        });
      });

    }

    function tipoDocumento(){

      if($('input:radio[name=doc]:checked').val()=='subir'){

        $('#porDOC').removeClass('d-none');
        $('#divTipoArchivo').removeClass('d-none');
        $('#divFirmante').removeClass('d-none');
        $('#divNombreHTML').addClass('d-none');
        $('#porHTML').addClass('d-none');
        $('#delegarTarea').addClass('d-none');
        $('#divAccion').removeClass('d-none');


      }else if($('input:radio[name=doc]:checked').val()=='crear'){

        $('#porDOC').addClass('d-none');
        $('#divTipoArchivo').removeClass('d-none');
        $('#divNombreHTML').removeClass('d-none');
        $('#divFirmante').removeClass('d-none');
        $('#porHTML').removeClass('d-none');
        $('#delegarTarea').addClass('d-none');
        $('#divAccion').removeClass('d-none');


      }else if($('input:radio[name=doc]:checked').val()=='delegar'){

        $('#porDOC').addClass('d-none');
        $('#divTipoArchivo').addClass('d-none');
        $('#divNombreHTML').addClass('d-none');
        $('#divFirmante').addClass('d-none');
        $('#porHTML').addClass('d-none');
        $('#delegarTarea').removeClass('d-none');
        $('#divAccion').addClass('d-none');
        $('#delegar').removeAttr('disabled');


      }
    }

    async function verAcuerdo(acuerdo){
      const {id_juez_promujer,id_usuario_origen, clave_bandeja}=tareaSeleccionada;

      dataPDF=  await obtener_archivo_acuerdo(acuerdo);
      dataArchivo=  await obtener_archivo_acuerdo(acuerdo, 'archivo');
      let edicion;
      if(dataArchivo.extension=='html'){
        edicion=`
          <input type="hidden" value="html" id="extOrigen">
          <div id="editor" style="text-align: -webkit-center;">
              <div id='edit' style="margin-top: 20px; width:100%;">
                ${dataArchivo.contenido}
              </div>
            </div>
          </div>
        `;
      }else if(dataArchivo.extension=='doc' || dataArchivo.extension=='docx' || dataArchivo.extension=='pdf'){
        edicion=`
          <input type="hidden" value="word" id="extOrigen">
          <div class="mg-t-40" id="porDOC">
            <div class="custom-input-file">
              <input type="file" id="archivoDoc" class="input-file" value="" name="archivo_doc" onchange="leeDocumento('archivoDoc')" accept=".doc,.docx,.pdf">
              <h5 class="px-3 py-3">Arrastre hasta aquí su documento de Word o de clic para adjuntarlo</h5>
            </div>
            <div class="d-inline-flex" style="width:100%">
              <a href="${dataArchivo.response}" download class="mg-l-auto mg-t-15"><i class="fa fa-file-word-o" aria-hidden="true"></i> Descargar archivo actual</a>
            </div>
            <div id="docSeleccionado" class="mg-t-40 d-none">
            </div>
          </div>
          <div id="vistaPreviaDocPDF"><div>
        `;
      }

      documentos = `<object data="${dataPDF.response}"  id="documentoPDF" width="100%" height="455px" class="mg-t-25"></object>`;

      let tipoResolucion=`

      `;
      const usuarios=await obtenerGrupoTrabajo();

      if(clave_bandeja=="COR" || clave_bandeja=="DEL" || clave_bandeja=="REV"){


        juez_firmante=await datausu(tareaSeleccionada.id_acuerdo,'firma');
        if(juez_firmante.status==100){
          jueces=await obtenerJueces(juez_firmante.response.id_usuario);
        }else{
          jueces=await obtenerJueces(0);
        }

        usuarios_delegar=`
          <div class="col-md-4" id="delegarTarea">
            <div class="form-group">
              <label class="form-control-label">Usuario a delegar:</label>
              <select class="form-control select2-show-search" id="delegar" name="delegar" autocomplete="off" disabled>
                <option selected value="" disabled>Elija un usuario</option>
                ${usuarios}
              </select>
            </div>
          </div>`;
      }else{
        jueces=await obtenerJueces(id_juez_promujer),
        usuarios_delegar='';
      }
      await obtenerDatosSolicitud( tareaSeleccionada.id_solicitud)
      let accordionFracciones = '';
   
      if( tareaSeleccionada.tipo_solicitud_ == 'PRO-MUJER' || ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 )){
        
        accordionFracciones = `
        <div class="card fracciones" id="accordionFraccionesSol">
          <div class="card-header fracciones" role="tab" id="headingTwo">
            <a class="collapsed tx-gray-800 transition fracciones" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="padding:10px; color:#000">
              Medidas de protección <i class="fa fa-angle-down" aria-hidden="true"></i>
            </a>
          </div>
          <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="card-body fracciones">
              <div class="row">
                <div class="col-md">
                  <div class="card">
                    <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" id="navItemsFraccionesSol">
                        
                      </ul>
                    </div><!-- card-header -->
                    <div class="card-body">
                      <div class="tab-content" id="tabPaneFraccionesSol">
                        
                      </div><!-- tab-content -->
                    </div><!-- card-body -->
                  </div><!-- card -->
                </div><!-- col -->
              </div>
            </div>
          </div>
        </div>`;
        
      }
      $('#divTarea').append(`
       ${accordionFracciones}
        <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
          <div id="validacionDatos">
            <div style="background: #f8f9fa; padding: 10px; min-height: 620px; border: 1px solid #eee;">
              <div class="row mg-t-30" id="accionesTareaAcu">
                <div id="divAccion" class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Enviar a:</label>
                    <select class="form-control" id="accion" name="accion" autocomplete="off" onchange="firmante()">
                      @if($sesion['id_tipo_usuario']!=3)<option  value="revision">REVISIÓN</option>@endif
                      <option  value="firma">FIRMA</option>
                      ${clave_bandeja=="COR" || "REV"?'<option  value="delegar">DELEGAR</option>':''}
                    </select>
                  </div>
                </div>
                <div class="col-md-4"  id="divFirmante">
                  <div class="form-group">
                    <label class="form-control-label">Juez Firmante:</label>
                    <select class="form-control" id="usuario_destino" name="usuario_destino" autocomplete="off" @if($sesion['id_tipo_usuario']!=3){{"disabled"}}@endif>
                      ${jueces}
                    </select>
                  </div>
                </div>
                ${usuarios_delegar}
                <div class="col-md-4 d-none" id="divNombreHTML" style="display:none">
                  <div class="form-group">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Nombre del documento:</label>
                      <input class="form-control" type="text" name="nombre_html" id="nombreHTML" autocomplete="off">
                    </div>
                  </div>
                </div><!-- col-3 -->
              </div>
              ${tipoResolucion}
              <hr>
              <div id="accionesDocAcu">
                <div class="row mg-t-15 pd-r-10 pd-l-10">
                  <div class="col-md-4">
                    <label class="rdiobox">
                      <input name="accion_acuerdo" type="radio" checked value="vista_previa" class="accion_acuerdo" onchange="irEditar()">
                      <span>Vista previa</span>
                    </label>
                  </div>
                  <div class="col-md-4">
                    <label class="rdiobox">
                      <input name="accion_acuerdo" type="radio" value="editar" class="accion_acuerdo" onchange="irEditar()">
                      <span>Editar</span>
                    </label>
                  </div>
                </div>
              </div>
              <div id="vistaPrePDFAcu">
                ${documentos}
              </div>
              <hr>
              <div id="resolucion" class="d-none">
                <div id="edicion">
                  ${edicion}
                </div>
              </div>
            </div>
          </div>
        </form>
      `);

      $('#tipoResolucion').select2({minimumResultsForSearch: Infinity});
      $('#tipoArchivo').select2({minimumResultsForSearch: Infinity});
      $('#accion').select2({minimumResultsForSearch: Infinity});
      $('#delegar').select2({minimumResultsForSearch: ''});
      $('#usuario_destino').select2({minimumResultsForSearch: ''});
      $('#btnResolver').attr('onclick','resolverTareaSolicitud()');
      if( tareaSeleccionada.tipo_solicitud_ == 'PRO-MUJER' || ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 ))
        mostrarMedidasPersonas('acuerdo');
      firmante();

      $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="confirmarResolucionAcuerdo()">Resolver Tarea</button>`)
      if(dataArchivo.extension=='html'){
        setTimeout(()=>{
          editorHTML();
        },200);
        setTimeout(function(){
          $( "#editor div:nth-child(1) div:nth-child(1)" ).addClass( "show-placeholder");
          $( "#editor td:nth-child(1)" ).css( {"width":"50%", "padding-top":"10px"} );
          $( "#editor img:nth-child(1)" ).css( {"height":"100px"} );
          $( "#editor td:nth-child(2)" ).css( {"text-align": "right", "width":"50%"} );
          $( "#editor img:nth-child(2)" ).css( {"height": "90px", "margin-left":"auto"} );
          $( "#editor td:nth-child(2) p" ).css( {"font-weigth":"bold", "font-style": "italic", "font-size": "18px", "margin-bottom": "0px"} );
          $( "#editor table:nth-child(1) td" ).css( {"border": "none"} );
        }, 500);
      }

      
    }

    async function verDocumentoG(id_documento){
      const {id_juez_promujer,id_usuario_origen, clave_bandeja, id_carpeta_judicial, id_tabla_asociada}=tareaSeleccionada;

      dataPDF=  await obtener_archivo_oficio(id_carpeta_judicial,id_documento, 'pdf');
      dataArchivo=  await obtener_archivo_oficio(id_carpeta_judicial,id_documento, 'archivo');
      let edicion;
      if(dataArchivo.extension=='html'){
        edicion=`
          <input type="hidden" value="html" id="extOrigen">
          <div id="editor" style="text-align: -webkit-center;">
              <div id='edit' style="margin-top: 20px; width:100%;">
                ${dataArchivo.contenido}
              </div>
            </div>
          </div>
        `;
      }else if(dataArchivo.extension=='doc' || dataArchivo.extension=='docx' || dataArchivo.extension=='pdf'){
        edicion=`
          <input type="hidden" value="word" id="extOrigen">
          <div class="mg-t-40" id="porDOC">
            <div class="custom-input-file">
              <input type="file" id="archivoDoc" class="input-file" value="" name="archivo_doc" onchange="leeDocumento('archivoDoc')" accept=".doc,.docx,.pdf">
              <h5 class="px-3 py-3">Arrastre hasta aquí su documento de Word o de clic para adjuntarlo</h5>
            </div>
            <div class="d-inline-flex" style="width:100%">
              <a href="${dataArchivo.response}" download class="mg-l-auto mg-t-15"><i class="fa fa-file-word-o" aria-hidden="true"></i> Descargar archivo actual</a>
            </div>
            <div id="docSeleccionado" class="mg-t-40 d-none">
            </div>
          </div>
          <div id="vistaPreviaDocPDF"><div>
        `;
      }

      documentos = `<object data="${dataPDF.response}"  id="documentoPDF" width="100%" height="455px" class="mg-t-25"></object>`;

      let tipoResolucion=``;
      let strOptionUsuarios = ``;
      let strOptionUsuariosDelegar = ``;
      const usuarios=await datausuOficio( tareaSeleccionada.carpeta_judicial[0].id_unidad );
      
      if(clave_bandeja=="CORDOC" || clave_bandeja=="DELDOC" ){

        if(usuarios.status==100){
          $(usuarios.response).each(function(index, un_usuario){
            const {id_usuario, nombres, cve_juez, id_tipo_usuario,usuario}=un_usuario;
            let str_cve_uez = (cve_juez != null &&  cve_juez != '') ? `(${cve_juez})` : '';
            if( tareaSeleccionada.id_usuario_origen == id_usuario ){
              strOptionUsuarios += `<option class="text-uppercase" value="${id_usuario}" selected>${id_tipo_usuario==5?'Juez':id_tipo_usuario==2?'Dir':''} ${nombres} ${str_cve_uez} - ${usuario}</option>`;
            }else{
              strOptionUsuarios += `<option class="text-uppercase" value="${id_usuario}">${id_tipo_usuario==5?'Juez':id_tipo_usuario==2?'Dir':''} ${nombres} ${str_cve_uez} - ${usuario}</option>`;
              strOptionUsuariosDelegar += `<option class="text-uppercase" value="${id_usuario}">${id_tipo_usuario==5?'Juez':id_tipo_usuario==2?'Dir':''} ${nombres} ${str_cve_uez} - ${usuario}</option>`;
            }
          });
        }

        usuarios_delegar=`
          <div class="col-md-4" id="delegarTarea">
            <div class="form-group">
              <label class="form-control-label">Usuario a delegar:</label>
              <select class="form-control select2-show-search" id="delegar" name="delegar" autocomplete="off" disabled>
                <option selected value="" disabled>Elija un usuario</option>
                ${strOptionUsuariosDelegar}
              </select>
            </div>
          </div>`;
      }else{
        jueces=await obtenerJueces(id_juez_promujer),
        usuarios_delegar='';
      }
      let accordionFracciones = '';
   
      
      $('#divTarea').append(`
       ${accordionFracciones}
        <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
          <div id="validacionDatos">
            <div style="background: #f8f9fa; padding: 10px; min-height: 620px; border: 1px solid #eee;">
              <div class="row mg-t-30" id="accionesTareaAcu">
                <div id="divAccion" class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Enviar a:</label>
                    <select class="form-control" id="accion" name="accion" autocomplete="off" onchange="firmante()">
                      <option  value="firma">FIRMA</option>
                      ${clave_bandeja=="CORDOC"?'<option  value="delegado">DELEGAR</option>':''}
                    </select>
                  </div>
                </div>
                <div class="col-md-4"  id="divFirmante">
                  <div class="form-group">
                    <label class="form-control-label">Firmante:</label>
                    <select class="form-control" id="usuario_destino" name="usuario_destino" autocomplete="off" @if($sesion['id_tipo_usuario']!=3){{"disabled"}}@endif>
                      ${strOptionUsuarios}
                    </select>
                  </div>
                </div>
                ${usuarios_delegar}
                <div class="col-md-4 d-none" id="divNombreHTML" style="display:none">
                  <div class="form-group">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Nombre del documento:</label>
                      <input class="form-control" type="text" name="nombre_html" id="nombreHTML" autocomplete="off">
                    </div>
                  </div>
                </div><!-- col-3 -->
              </div>
              ${tipoResolucion}
              <hr>
              <div id="accionesDocAcu">
                <div class="row mg-t-15 pd-r-10 pd-l-10">
                  <div class="col-md-4">
                    <label class="rdiobox">
                      <input name="accion_acuerdo" type="radio" checked value="vista_previa" class="accion_acuerdo" onchange="irEditar()">
                      <span>Vista previa</span>
                    </label>
                  </div>
                  <div class="col-md-4">
                    <label class="rdiobox">
                      <input name="accion_acuerdo" type="radio" value="editar" class="accion_acuerdo" onchange="irEditar()">
                      <span>Editar</span>
                    </label>
                  </div>
                </div>
              </div>
              <div id="vistaPrePDFAcu">
                ${documentos}
              </div>
              <hr>
              <div id="resolucion" class="d-none">
                <div id="edicion">
                  ${edicion}
                </div>
              </div>
            </div>
          </div>
        </form>
      `);

      $('#accion').select2({minimumResultsForSearch: Infinity});
      $('#delegar').select2({minimumResultsForSearch: ''});
      $('#usuario_destino').select2({minimumResultsForSearch: ''});

      $('#btnSiguiente').attr('onclick',`avanzarOficio(${id_documento}, '${dataArchivo.extension}')`);
      $('#btnSiguiente').text('Enviar documento');

      if(dataArchivo.extension=='html'){
        setTimeout(()=>{
          editorHTML();
        },200);
        setTimeout(function(){
          $( "#editor div:nth-child(1) div:nth-child(1)" ).addClass( "show-placeholder");
          $( "#editor td:nth-child(1)" ).css( {"width":"50%", "padding-top":"10px"} );
          $( "#editor img:nth-child(1)" ).css( {"height":"100px"} );
          $( "#editor td:nth-child(2)" ).css( {"text-align": "right", "width":"50%"} );
          $( "#editor img:nth-child(2)" ).css( {"height": "90px", "margin-left":"auto"} );
          $( "#editor td:nth-child(2) p" ).css( {"font-weigth":"bold", "font-style": "italic", "font-size": "18px", "margin-bottom": "0px"} );
          $( "#editor table:nth-child(1) td" ).css( {"border": "none"} );
        }, 500);
      }

      
    }

    function avanzarOficio(id_documento, extension ){

      let resolucion=new FormData($("#cargarDocumento")[0]);
      resolucion.append('id_documento',id_documento);
      resolucion.append('id_carpeta',tareaSeleccionada.id_carpeta_judicial);
      resolucion.append('accion', $("#accion").val() );


      if($("#accion").val()=="delegado"){
        resolucion.append('usuario_destino', $('#delegar').val());
        resolucion.append('comentarios',$('#comentarios').val());
      }else if( $("#accion").val()=='firma' ){
        resolucion.append('id_usuario_destino', $("#usuario_destino").val() );
        resolucion.append('solicitud', tareaSeleccionada.id_carpeta_judicial );
        resolucion.append('id_unidad', tareaSeleccionada.carpeta_judicial[0].id_unidad );

        if(dataArchivo.extension=='html'){
          resolucion.append('extension', 'html' );
          resolucion.append('archivo_doc', editor_html.html.get() );
        }else{

          if( !$("#archivoDoc").val() ){ 
            alert("Debes adjuntar un documentos");
            return false;
          }

          nombre =  $("#archivoDoc")[0].files[0].name;
          tamanio_archivo  = $("#archivoDoc")[0].files[0].size;
          punto = nombre.lastIndexOf('.');
          ext = nombre.substr( punto +1 , nombre.length - punto -1 );
          nombre = nombre.substr( 0 , punto );
          resolucion.append('nombre_archivo', nombre );
          resolucion.append('tamanio_archivo', tamanio_archivo );
          resolucion.append('extension', ext );
          resolucion.append('archivo_doc', $("#archivoDoc")[0].files[0] );
        }
      }

      $("#modalDatosTarea").modal("hide");

      $.ajax({
        method:'POST',
        url:'/public/avanzar_documento',
        data:resolucion,
        contentType: false,
        processData: false,
        cache: false,
        success:function(response){
          if(response.status==100){
            const message=response.message;
            if(accion=='firma'){
              $('#successMessage').html(`${message} <br> Documento enviado a ${nombre_usuario}`);
            }else{
              $('#successMessage').html(`${message}`);
            }
            $('#modalConfirmacion').modal('hide');
            $('#modalSuccess').modal('show');
            buscar(1);
            countBandejas();
          }
        }
      });

    }

    function irEditar(){
      if($('input:radio[name=accion_acuerdo]:checked').val()=='vista_previa'){
        $('#resolucion').addClass('d-none');
        $('#vistaPrePDFAcu').removeClass('d-none');
      }else if($('input:radio[name=accion_acuerdo]:checked').val()=='editar'){
        $('#vistaPrePDFAcu').addClass('d-none');
        $('#resolucion').removeClass('d-none');
        if( contiene_fracciones )
          $('#accordionFraccionesSol').removeClass('d-none');
      }

    }

    function confirmarResolucionAcuerdo(){
      const { clave_bandeja } = tareaSeleccionada;
      resolucion=new FormData($("#cargarDocumento")[0]);

      if($('#extOrigen').val()=='word'){
        if($('#archivoDoc').val()!='' && $('#archivoDoc').val()!=null){
          const file = $('#archivoDoc').val();
          extension = file.substring(file.lastIndexOf("."));
          tamanio_archivo=$('#archivoDoc')[0].files[0].size;
          nombre_archivo=$('#nombreDoc').val();
          resolucion.append('extension',extension);
          resolucion.append('nombre_archivo',nombre_archivo);
          resolucion.append('tamanio_archivo',tamanio_archivo);
        }
      }else if($('#extOrigen').val()=='html'){
        extension='html';
        archivo=editor_html.html.get();
        nombre_archivo=$('#nombreHTML').val();
        resolucion.append('archivo_doc',archivo);
        resolucion.append('extension',extension);
        resolucion.append('nombre_archivo',nombre_archivo);
      }

      if(clave_bandeja=='COR' || clave_bandeja=='REV' || clave_bandeja=='DEL'){
        if($('#accion').val()=="delegar"){

          const usuario_a_delegar=$('#delegar').find('option:selected').text()
          $('#mensajeConfirmar').html(`La tarea se delegará  a: ${usuario_a_delegar}`);
          $('#btnResolver').attr('onclick',`resolverTareaAcuerdo(${tareaSeleccionada.id_acuerdo},'${usuario_a_delegar}','delegado')`);

        }else if($('#accion').val()=="firma"){
          const juez = $('#usuario_destino option:selected').text();
          $('#mensajeConfirmar').html(`El acuerdo se enviará a firma al juez: ${juez}`);
          nombre_usuario=$('#usuario_destino option:selected').text(),
          $('#btnResolver').attr('onclick',`resolverTareaAcuerdo(${tareaSeleccionada.id_acuerdo},'${nombre_usuario}','firma')`);
        }

        else if($('#accion').val()=="revision"){

          $('#mensajeConfirmar').html(`El acuerdo se enviará al Subdirector de Causa para su revisión`);

          $('#btnResolver').attr('onclick',`resolverTareaAcuerdo(${tareaSeleccionada.id_acuerdo},'Subdirector de Causa','revision')`);
        }
      }

      $('#modalDatosTarea').modal('hide');
      abreModal('modalConfirmacion',350);

      $('#regresar').attr('onclick','abreModal(`modalDatosTarea`,400)');

    }

    function autorizacionExh(solicitud){
      $('#modal_loading').modal('show');
      $.ajax({
        method:'POST',
        url:'/public/autorizacion_exhorto',
        data:{
          solicitud,
          autorizacion:$('#autorizacionExh').val(),
          comentarios:$('#comentarios').val(),
        },
        success:function(response){
          if(response.status==100){
            $('#successMessage').html(response.message);
            $('#modalSuccess').modal('show');
            buscar(1);
          }else{
            $('#messageError').html(response.message);
            $('#modalError').modal('show');
          }

          setTimeout(()=>{
            $('#modal_loading').modal('hide');
            $('#modalConfirmacion').modal('hide');
          },200);
        }
      });
    }

    function autorizacionRem(solicitud){
      $('.error').removeClass('error');
     
      if( !$('#comentarios').val() && $('#autorizacionRem').val() != 'si' ) {
        $('#comentarios').addClass('error');
        return false;
      }
      
      $('#modal_loading').modal('show');
      $('#modalConfirmacion').modal('hide');

      $.ajax({
        method:'POST',
        url:'/public/autorizacion_remision',
        data:{
          solicitud,
          autorizacion:$('#autorizacionRem').val(),
          comentarios:$('#comentarios').val(),
          unidad_carpeta: tareaSeleccionada.id_unidad,
        },
        success:function(response){
          
          if( response.status == 100 ){

            if( response.response_carpeta )
              if( response.response_carpeta.message )
                $('#successMessage').html(`${response.message.split('-')[1]}, ${response.response_carpeta.message.split('-')[1]}<br>Carpeta Judicial: <span style="font-weight: bold">${response.response_carpeta.response.folio_carpeta}</span>`);
              else 
                $('#successMessage').html(`${response.message.split('-')[1]}, <br>Carpeta Judicial: <span style="font-weight: bold">${response.response_carpeta.folio_carpeta}</span>`);

            else if( response.response )

              $('#successMessage').html(`${response.message.split('-')[1]}<br>Folio : <span style="font-weight: bold">${response.response.folio_carpeta}</span>`);

            else
              $('#successMessage').html(`${response.message}`);
            
            $('#modalSuccess').modal('show');
            buscar(1);
          }else{
            $('#messageError').html(response.message);
            $('#modalError').modal('show');
          }
          setTimeout(()=>{
            $('#modal_loading').modal('hide');
          },600);
        }
      });
    }

    const plantilla=`
      <div>
        <table style="border: none;">
          <tbody>
            <tr>
              <td style="border: 0;">
                <h1>
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAABOCAYAAABbuPRQAAAWTklEQVRoBdVaeVSV17Xvei/ta/te2pgomKRJTISkzySm/eM1bV/Tpk0ba1IjOEbRCBrjmGicMQ5cvEwaZlAZBCMOiAgq4DygosikzNMF7sAk8zwp+Htr7+87H99HzNX3Vt9a7V3r3DOf8/v22XufffY538M/2e97/2R4oQFc3FCPi1VluFxVzuGK0YDLRilNZVeo3CjFXFdVjktVZbhpqUJVSxMG7t17rO8vNptwOusWzt/JksLtbFy4k6PKZ+H87SxuU2Ixa8bUAF6VFIuf7/eH/W7P4RDqCXsOHkqZXSilVflgd7y1xxsOsZHYdeMSKpoblUkePHigpEVi3b49GPvpHNjOnw6bT6bDlgKlOT8Ntp9QmI6xn36MdRGhohvHGsBfJsfh1YhdsAtyh12gNowP1MEuSIfxQe54RanbwXm74B2wC9HDfq8X7MN98KtIXwSlp+L+0CBPMhL0pugw2LrMho2TA2ydHDDGyVEVHLjcxskRtgtnYVPU3u8GvCY5DvbhOzE+QKcN/nI+UIpfEfkAHV6Ry9R9eAUifPBZ0hG09fZoJqSM6/5w2DjPwpg5DhgzZ6oUz6W0A8bMncrBZq4DbJ1nwjU6TNNfQ+G1RGEBmIAIMDJAO867Y7zI04eJdiKWy2iV7CN2wjkxBr0jeHvT/nDYuswEgRqjDmrATo4YNc8B68JDHgXYR0vdkdQOkAC/EqCDnRwoTUFNZUoTWxHoHVfPaiYVgAU1CTSBt2HqOmD03Kn4t4/ew7gFsxB2Il7T99EUJt4VVJOpKAAKPicqqwHTSnAg0CF6vBaqR3btsLQzYGIJNXXl9L9Pm4Qn/vp7/Gn1MuRWlKOxoeG7Aa9JIZbwUSjHgiZTkdMyEKLey/7bYeOxAc+4r4Gt9ya8EuDGFGaqyx8pVoDYbGnSUWVi4mFbFeDRcxxAQP9l0u/x5sK5CD95HL19fdy+uqZG6UcJLYVT4iUeFhMyz6qWWqbwS77b8JLHBiw+FAnvc6cwKyoEz3tswMsBbhJl5X68MgE62Ifo8WaoJ4xtLTy5xBKzMGr2FPzwoz/jBx/+ARMXOcHn4H7cbW7WALRUV2vyIwAf+5aWUC81UzbADc/vWIvQS2eUge7fv4/1CYdh67lBFlRSfcOahQUwzBsJxXncZ/XeIPzA8X2Mnj4Z76/7HOGnEtDU2qqMp1aDj6Qw6VFFeALdJN5UqbFnd7piUogP7o2Q/KqGevzMbQ2e0q+FrY+rHDZhjOcGPKNfhzE7XbHp5FF0dXQiMO4IPA9/g6ziQgwOSrqa0T4ACCwHGb5VCq9LOcYsIfhQABdLS3kbr42YE6VVNTR2V28vtiXGYk50KBwjAzA13A8zIoOwIGYv1iUcQvCVc0gvK0F/by+hUqhJCQXkgwcYGhrivGjwGIB9MN7fTdIMQlX5kxaQhOoF322Y6LMFpbVa3hIT/L3j+vp6ZUj6sBE8HK/hYUFZJWahc8cY/XpMDfFBV4+0i3X39qDQbIKx8S5MjXdhaWrgYG5sgKnhLowN9SCWqW1uQl9vD+oaG1BRbXloMMjlldUWVDfcRUFZqQKYElrApwVLuLPw8M6mknhJv7pjlPsaLIzejaHBIR6MADsGeeOF7V9igvdmTPD6dnjDXwf/80no7erCut2BeHH+DLw4x4HDC3L84pypkIJUPs55FrZGWdmaJR4moZOWf3ygzBr+w5vHz77egtc9XWFsuIu+gX6cykpn0GcLczHabTV+5rsVL/ltw4t+2+V4G17y346XgnS4bq7kthuiwvD0J9Pw1Oy/cfgpxbOk9FOzP5TKP/4bRs13xMZ9e7iP+NNQeJ3Qw8y7BFoGLng4UIdR21fB9+wp7n/w1jXYrP0MRTXSLuYcE4Zn9Ot5S2YbQx6HzNU/7Q9G98AA99u0n6y1mRit2umGt2XJAOKt2mUmNls1fk4fw2vhO1n584TMszrYkVoL1GGsjyv+21eHzu5udPT04J0gD/xo60o4R+9mIEU1Fth5bMKLvltlfSxtJK9G+GB3xjVBJIiNQzF+5ki2BG3VZEeQjUF1ZK1ZBcwsESEDZuNFZgU2btwwevtqHMu4wRP7XkjBKN2XGBfghrFbV+FsXg6X608nYJRuDcaTzUy7XJg33o8JRXtf70MBk00sGT4CtARWALZqXhJL0MYhtAKxBKuzQB1vAI57ffFgaAiVDfUsXMSvZADZeG3A+0Fe6B8YQEtXJ972d8ezOzfDbrcnJuz1xnVzhQKWEpItMVOxfRWrbc5UhcJswT3SHk6hrdln2B4IlPiYhOZ5ty9xs6yYJ152JApP71grUZEstUAdntm2CmFXznH9wVvXMdpzA17b44ljRXc0YClDLMEGvLz8xMvD/KxliU37rJw41gq1Jhs/vNMRmB1rsfzwPp74amkh2xLj/LcrVh2pu+d2bcFEr82oaWvB/cFBLI3bj6QSyXYYiVjwMFORjkiKPeyA0U5TMcZpqnR8cpkJV2tHpLVn4vFalC/sQuQzWogeLwS44eeem1jxD+EBpkQEwHbnZtiHeuDVMG82R2lVyFB/2nM9XOMPMr7OtnbcH2FvCOBfHYiErYtsD6sAE3ApyICJJawB3nD8EMbvWI8J+g2YoN+ICR4bMWb1InidiOO5YlIvYOzaxRjvthav6zdiflw0FicextJTR7D9SgoSi3ORXV6KFtlErK2tFRg18ZaYfTJLDKswWzXYx9USK0P8MPaT6Xh2rgOHn0ybhF8umof2jg60dLTjjUVOeHLaJNg6OWLiUmc0jLBdBSpDhSRkXV1daGpqEsVKzBR2loWOz3GCsiImtniMQ+jyED/pcOjkgNFzpuIHk9/FgTPJPNHmsFA88cG70pLNm4Y3ljmjfgRgMk7o19bWBmG0iFhBC0BiCTqESktP4AQfS/Fj8vDK3f7MW6Qb6RD43poVrMaKqipgM+MD/HTWhywMY+ZPw+vLnFHXrKWeAEzgKisrMdA/gIGBAdTVDVtcVEeASUuwDlbAOir8y6CJwo8SuhUhvtxo1Mcf4ckp7+FydiYT5mPdV3hiyh+HJ5AB16qWW23TUicCajQZuT+xBZ1KxE8tdARaEjR1rBI6a1uzYIl//fBdLPDYzuOfvpmGH/3tj3h6zkcSYBIOGXBN47BLihqrKUx5o9GIzs5OPlXU1dUJvBJLKIdQ0rsqsLTzCbXmPNO652dFqB+emueAZ2d+iFKTkanyuy8+ww+n/kWhLu//8yUerlUBHklh8QEGgySAra2tDJ7KmSVcZkmOFIUlZNAyYOJrm0cZPytC/fH9qX+GLiqcqRGSEIcnJv9BMkZkP5gAPGHpAtQ0WacwDUKUbZQ/rE4+PZBaIz3MY6lsCRY+oq4sjGMfBXihrxfeWPIJ2jo7UdfUBLt5M/DkjMmKBCuGCrHEcmeoeZi/8Dv+DAYDs0tXdxcG+vqx7WA0U08SLhmgmi1UgK1uzfM9tiPyrKTGPtvlge+9+1/48bRJ+LHjJCmeNokdHj+eMRnjXGYrlPsOnEpxb28vLGYL5/u6uuEasRs2C2YOOwEJoOIY/F/YEvtOJmLowQNUWix4d8Wn+M2KRfj9F0s4vPPFEryzagmkeCmmuK5FXnER6uvqYbFYOFRXVytpKjNTeXU1TGYzsrKy0d/fzyfmVUFf4z+m/xWjP56CMbO14RlV3mb+NLhaO3GkZmYwFfrv3eMDJk3Q19eHvv6HhX4GQG0eGQYGWCcLLbLhyH6M3rAEL29bjZe3rsK4ras4PW7rary0hfJfcNm4Heux7eSwi4vAaY5Ii7zdEZFyUlnK/49ER2MzXM8mwo4c58F6jA/RK8YWOQ6pjJ3j5ESM8oXuksSiAosG8OIAHzw94wOcvHZF1MtODoA23YepLq6g1rLHRspza6WPGIw0BnmMPNMusDtBOSiQOStcW3TglfOvRuyE24Uk0Z1jDWDSw09+PAW2jpNx/PKF4YZsIkh2AkHXOm7kcgWwlBetxSBkuZEupp/HtXOKh0ntFRUfIADTbYDuohUKL+eteRYLxE8+/BO8DkRptlRB4aEh2f8l/GByrLiZVGh7SENYLCDLTfzIwU0uWAWg8HrKniYqJ9DU5hGA/fikShci5Cf4/qR38MH6Vbh6O1vM9dgx2Q60YdD2LIRNdNanEmCV/0MGTH6QV/wl1wIDjngEYBc/L4xd4iSZmLQTLZiJH07/K0ZNn4zZ+i04lZ6Gpq5OMe9D467ubt7djFVGNI8wP0UH/VWJJZgdxOlcHMuYh2X3wKMoHH/9Mu/zusPfgII7hSNSenPkbmyO2I3Q+FicvXEdeUVFrGPJf8s612xmapIuJoPH2k9PPEzuBOHdJ1YQQienBUu4XZCcNmI8jdCJwseNiWfJjBzpKxb9Bc9TXs0WngQ4bCfo+owd37LDhm6n1GUkdG7nrQDu6u9HU08XWnp7ODT3dKNJCV2cbuzpghS6MTgkOQMFwJGxGrC6bsulZNiHqe4DZcDkA+E7QFmt0eHW7bwVtaa7mITfHgjG7yL9OPw20he/DqfwNce/oXSEL94O/xq/ivgaDocjEJB+BbfrLBi4b/2e2dzeitiCHHyWFItf7PGWb1qJFdykIGsIci0Mawkf6C5YUWtfnIrFa9F+fISnYzzdaHLg3UgP+1A97EM8lJ3Ifo90VftqiB6OsREITE9Fbn2NQvm6jjYcL87F0pSjDNJ+rze7rujOg7xKarUm8bDkuLEjrymrNR9Y5eE1ybJ/WOw8sldHuTrgcppMunChQVnS6a6Zwe+EfdAOzDwWxddcv470BX0UX6WF6hWASn9BVR5H8sUxheX5STB11nY6umsW93RiUBGrb5PEXbMk5ZLeFD648cE7GCQ5AckmkJyCUhsxloayzALD1FauhWUKPxpwmNoZKFNSVubShLJgCCc3U0laSgFI8SuLlRCUVMfUX7mdGgYsNg4ai4hndadbw7dIsjNQpdAZgJpN1EConPIsPMMCI1F/2JARepbL5T6C0lwnxpF5W9rpfLDdmlpbefIIfh4TyDeXgj/pS9WTi4mVcqFDxQeK9gIAxSIt2lAfuR3LgMaWkASOhP4/YwKx9ZzW3NVsHLcsVVhxJh5v7d3J5h892ODHHiNBjKCwoJAAoaaiBEgWTjGO0l8SNP4g+oggwf8+eDvSF1sup6CkYdg9QLpcA1god0NTA/ZmpeGjw2EsOGQ1sTpjSgkhU1Fefn4glljE9AGaj1ABFqvG9aF6+SXMDsw4ug8xeZmo7+wQcDS75EMBi5b37t8HPUbaeP4kfh3pxzrUPsyHKaEAkVmCtIhdAFGMnt5IFFUAq/Mye9DKvcp62Qek/lwvJiHNUoVB+dmNwDByt9QAVu/3ooOIazvacDg/GwtOHMRrIR4Sy+zxYrVFwNRqT+LzYVUmPoCoyn5lMnyC9Zh7/BscystCbUe7mIZjgUOAFXmqfCRgdWMxKu1m3mkX8d43IdJLK7Jt6XzG2kISMoV3CWSwu7TDhfngt/v8sfVKCjKqjXyvLMYUsQBJeUorhwK5gQaw6KSO1YDVaWrT2d+HpLICLD51BBP3+vAJwZ7shKAdzBZMTfqYIHdMZ97MQsND7OmRINXzqOtozv8TYPWA4uMMzY3Yk3Wd366R/UGC+nakH766mISMGhP7O0RbitVjqEGp06Kduu3fDbAAQ1YbvRY8lJ+N6vbhRxuifiQIAXBkrG73UMDqQvXg/whpNTYNhWubGpFdUoxcQxlyy0cEQxnyRpZZyecZyr89BrUfOfbIvBjTUIackmKY6us07KMB7BEbwzeRzzk54vl50/C8kxSeFfl50/AclztKdZQWQW773FypL7WjfjSWKKO2Ii/KqN1zYp65jniWx3PkvnRDuizET7PIGsDG2hpczsnEhcxbOJtxE6m3szh/Ov0GXx9QnurO3brJR/+LWRmgkEqvUzNvIfnGdaTcvI4LWRm4lJ2JlPQ0nMu4yXWXc7KQmpOF85m3ONAY3DcnGxfopWtmOveldjQftUtOv47bZSXfDbi02ozkWzdwt62VbzPPZWcgs7SIO6QXFyKF6lpb0DvQj/M5mcitNKDUbMKZrFsa5za9JKmsld6bdfX2wHy3HlfzcrldZ28PmtvbeHxz412czc6Asb4OdS3SBU9OufQCpaWzA930PmiERtFQODApASFJCdgYHQb3Q/tx6U4ODl4+j+BTx+EVdxDpxQUIOnkcgSfjsT5yD3IMZQhMiEP46VPwPBqDe4P30dvfh8CEo3A7GI3qxgak5t2G7mA0dh2PRVphPvf1Ox7LfWjc9JJCXMm9jT3JJ/gabXmoPzLKipF4Kw2pBdLV73cKXVBSAjxiD+BI6kV4xUpXsLUtTVi5OwAR56TD4NFrV7B23x64xUShqrYGe5NP4tOAnYhPu8rUINDBiccY8N3WVlzLvwPdoWjE35TeS+xJSgR51b/6JhIn09O4T11LMyJOn0LEmSQsC9yFXXGHEXfzKnIqDdYpHHX+NPJNVdwo9uolhJyKR+CJYziXkwnvowcReSYJu5MTkXDzGtwPRSP1TjYOXDjN7HHg4ll++BF39TK3u5SbA//EOO5/8U42th/Yx6BiLp/HoUvncCb7FgJOxGPfuWTEp6Vib1Iigk7E42rubYSlnIA+9gB84g4hs0R6QcCgRu503T09IOeduFMrqqqE5a50KWiwmHEzL5evsGh/zzOUoaiyAvXyhQvdi9BjJVJ94rUVpc3yRUyZ2cRqjiamd5UmkwlVFgsKjZXo6O5Gc2srO8+pnt5d1DQ0IKMgHybVdRnVaXi4ta0dRaVlqKwywlxdg4bGJjwYeoBygwGFRcWoqKhES2srmlpa0NzSgva2DhQUFsFQWclGCtVRO5PZgkqTCYWFRWhra+e38YYKaeWqzGYUl5YiN78AZrMF7e0daGxqQm1dPYeC4mLU1NbCUl2DKqMJzc0tD9fDxNhlFRWK26m4rBwl5QYM3h9EekYmikrKeFVyCwqQmZ2D23n5qDSZmVoNjY1oam7hDyTQdM2QmnYD2bfvsCuLHvPfyMhEpdGE7NxcZN2+g6KSUl6t3IIiVJnMMJotPCZN0trWBpNFusQpLC1TVvxbFLbU1MJoMvPdMFGporIKVSYTSsvKkZuXj+rqGuTlF6KgsBhl5QbcyS/gNhUVVXzPQdQoLi5BTV0d8guLkJGZhfb2dgwODqGi0ojqmlqQ8zCvoAAFhYVobGhkSpot1TAazSgzVKC6upYpbaioRG1tPSqN5odTmNATJUrLDbDU1IDcpm3t7TwI6cMqoxElZeVobW9HX38/U6e2vh75hYWob2jAvfv30N7Zyfma+jrmY2IXc3U1t6cnDLSKJCcNzU0oLC7mMWms9s4OZjHi/dLycjQ2NzPbFZeWcV9eWvlPw8P+J47h9ZULMXHlIryx3BlvLnfBWysX8c09xW99/imX0S0o3eZT2S9XLcbEFQsxYckn/CThl59Leer7iy8W462VC/H60gV4c4ULx9SP2tNYv/j8U7y+bAGPOXG5C/d/6/NFmLjCRZpnhQvWR1l5aHejuBDByYkITU5EiAhJiQgRgcpEOikRoZSWyygtApVxndxW3U70V+pV/bmO8wncPzgpEWdzMtUE1moJTc0/aEbDEv+gGDWw/gepeW3EAfUw2AAAAABJRU5ErkJggg==" width="68" style="width: 68px; height: 115.719px;" height="115.719">
                </h1>
              </td>
              <td style="border: 0;">
                <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;TRIBUNAL SUPERIOR DE JUSTICIA DE LA CIUDAD DE M&Eacute;XICO</strong></p>
                <p><em>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &ldquo;<strong>2021</strong>: <strong>A</strong>&ntilde;o de la <strong>I</strong>ndependencia&rdquo;</em></p>
                <p><em>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Unidad X </em></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Ciudad de M&eacute;xico a&nbsp;X&nbsp;de&nbsp;X&nbsp;del dos mil veintiuno.</p>
      <p><strong>Titulo</strong></p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.&nbsp;Pellentesque tincidunt consectetur felis nec consectetur. Aenean vitae nisl tempor, laoreet magna id, venenatis sapien. Quisque viverra est imperdiet dui porta viverra. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec pulvinar condimentum tempus. Aenean nec suscipit arcu. Nulla sed massa id mi finibus ultricies. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      <p>Nullam eu aliquet dolor, rutrum faucibus sapien.&nbsp;Ut elementum dui ac elit sollicitudin aliquam. Praesent dictum facilisis velit. Nulla ac vulputate nisi, et bibendum ante. Mauris vitae urna lorem. Aliquam leo velit, hendrerit in diam id, sagittis vestibulum risus. Ut tempor, sapien sed aliquam vulputate, ex augue aliquam urna, rhoncus tempus sem erat ut enim. Vivamus blandit leo et consectetur vestibulum.&nbsp;Aenean varius, sapien ac lobortis luctus, ipsum magna tempus lorem, ut consequat ex ipsum ut ligula. Nulla facilisi. Quisque felis turpis, egestas eu urna ac, faucibus egestas nunc. Sed non lacus quis lectus vestibulum iaculis eu ut justo.&nbsp;Nulla risus tortor, vestibulum sit amet ullamcorper eget, suscipit sit amet velit.&nbsp;Aenean id lacus id arcu pulvinar hendrerit vel eu mauris.</p>
    `;

  </script>
@endsection

@section('seccion-modales')
  <div id="modalError" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20" id="titleError"></h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close"   id="acepError">Aceptar</button>
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
          <p style="padding-left: 5vh; padding-right: 5vh;" id="successMessage" class="f-mayus"></p>
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto mg-r-auto" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDatosTarea" class="modal fade" data-backdrop="static">
    <div class="modal-dialog mg-b-100" role="document" style="" >
      <div class="modal-content tx-size-sm" style="">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleTarea"></span></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <div class="steps d-flex" id="steps">
            <p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>
          </div>          
          <div  id="divTarea"></div>
          <div id="divFracciones" class="d-none">
            <div class="row">
              <div class="col-md-9">
                <div class="form-group">
                  <label class="form-control-label">Víctimas: <span class="tx-danger">*</span></label>
                  <select class="form-control select2-show-search" id="victimaFracciones" name="victima_fracciones" autocomplete="off" onchange="showFraccionesPersona()">
                    <option selected disabled value="">Elija una opción</option>
                      
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <label class="form-control-label">&nbsp;</label>
                <button class="btn btn-primary btn-block" id="btnGuardarFracciones" onclick="guardarFracciones()">Guardar Fracciones<i class="fa fa-check d-none tx-success" id="successFracciones" aria-hidden="true" style="position: absolute; top: 40px; left: 218px; font-size: 1.4em;"></i></button>
              </div>
            </div>
            @if ($fracciones['status'] == 100 )
              <table id="tableFracciones" cellspacing style="display: block;overflow-x: auto;">
                <thead>
                  <tr>
                    <th>Fracción</th>
                    <th></th>
                    <th>Seleccionada</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $fracciones['response'] as $fraccion )
                    <tr style="background-color: #f8f9fa"   >
                      <td class="nFraccion pd-10"><h6>{{$fraccion['fraccion'][0]['fraccion']}}</h6></td>
                      <td class="dFraccion pd-10">
                        {{$fraccion['fraccion'][0]['descripcion']}}
                        @if ( $fraccion['fraccion'][0]['id_catalogo_fraccion'] == 16 )
                        (especifique):
                        <div class="form-group mg-b-10-force mg-t-10">
                          <input type="text" style="width:100%" id="descripcion_otros" class="form-control">
                        </div>
                          
                        @endif
                      </td>
                      <td class="sFraccion pd-10" style="text-align: -webkit-center;">
                        <div class="toggle-wrapper" style="margin: auto !important; display: table !important;" disabled="">
                          <div class="toggle-light primary valor_fraccion" id="a1" style="height: 26px;width: 50px;" disabled=""><div class="toggle-slide">
                            <div class="toggle-inner" style="width: 74px; margin-left: 0px;">
                              <div class="toggle-on active" style="height: 26px; width: 37px; text-indent: -8.66667px; line-height: 26px;">SI</div>
                              <div class="toggle-blob" style="height: 26px; width: 26px; margin-left: -13px;"></div>
                              <div class="toggle-off" style="height: 26px; width: 37px; margin-left: -13px; text-indent: 8.66667px; line-height: 26px;">NO</div></div></div></div>
                        </div>
                      </td>
                      <td class="sFraccion pd-10" style="text-align: -webkit-center;">
                        <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
                          <div class="toggle toggle-light primary valor_fraccion fraccion_acuerdo" id="{{$fraccion['fraccion'][0]['id_catalogo_fraccion']}}"></div>
                        </div>
                        @if ( $fraccion['fraccion'][0]['id_catalogo_fraccion'] == 16 )
                          <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        @endif
                      </td>
                    </tr>
                    @if ( isset($fraccion['hipo']) )
                      @foreach ( $fraccion['hipo'] as $hipotesis )
                        <tr>
                          <td class="nHipotesis pd-10"></td>
                          <td class="dHipotesis pd-10 pd-l-20">{{$hipotesis['descripcion']}}</td>
                          <td class="sHipotesis pd-10" style="text-align: -webkit-center;">
                            <div class="toggle-wrapper 1" style="margin: auto !important; display: table !important;">
                              <div class="toggle-light primary valor_fraccion" id="a27" style="height: 26px; width: 50px;"><div class="toggle-slide"><div class="toggle-inner" style="width: 74px; margin-left: -24px;"><div class="toggle-on" style="height: 26px; width: 37px; text-indent: -8.66667px; line-height: 26px;">SI</div><div class="toggle-blob" style="height: 26px; width: 26px; margin-left: -13px;"></div><div class="toggle-off active" style="height: 26px; width: 37px; margin-left: -13px; text-indent: 8.66667px; line-height: 26px;">NO</div></div></div></div>
                            </div>
                          </td>
                          <td class="sHipotesis pd-10" style="text-align: -webkit-center;">
                            <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
                              <div class="toggle toggle-light primary hipotesis fraccion_acuerdo {{$fraccion['fraccion'][0]['id_catalogo_fraccion']}}" id-fraccion="{{$fraccion['fraccion'][0]['id_catalogo_fraccion']}}" id="{{$hipotesis['id_catalogo_fraccion']}}"></div>
                            </div>
                          </td>
                        </tr>
                      @endforeach    
                    @endif
                  @endforeach
                </tbody>
              </table>
            @endif
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary d-inline-block" disabled onclick="atras()" id="atras">Atrás</button>
          <div id="divButtons" class="d-inline-block" style="margin-left: auto">
            <button type="button" class="btn btn-primary d-inline-block mg-l-auto" id="btnSiguiente">Siguiente</button>
          </div>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalAvanzar" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
      <div class="modal-content bd-0 tx-14" style="min-width: 500px">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Avanzar Acuerdo</h6>
        </div>
        <div class="modal-body pd-25">
          <div class="row">
             <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Acción:</label>
                <select class="form-control select2" id="accion" name="accion" autocomplete="off" onchange="accion()">
                  <option value="" disabled>Seleccione una opción</option>
                  @if(Session::get('id_tipo_usuario')!=3)<option value="revision" >Enviar a Revisión</option>@endif
                  <option value="firma">Enviar a Firma</option>
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Juez:</label>
                <select class="form-control select2-show-search" id="usuario_destino" name="usuario_destino" autocomplete="off">
                  <option selected value="" disabled>Seleccione a un Juez</option>
                  @foreach ($jueces as $juez)
                      <option value="{{$juez['id_usuario']}}">{{$juez['cve_juez']}}  {{$juez['nombres']}} {{$juez['apellido_paterno']}} {{$juez['apellido_materno']}}</option>
                  @endforeach
                </select>
              </div>
             </div>
          </div>
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary mg-l-auto" id="avanzar">Aceptar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalConfirmacion" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-vertical-center" role="document" style="">
      <div class="modal-content bd-0 tx-14" style="min-width: 100%">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Resolver Tarea</h6>
        </div>
        <div class="modal-body pd-25">
          <h5 id="mensajeConfirmar"></h5>
          <div id="opConfirmar"></div>
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Comentarios:</label>
            <textarea class="form-control" type="text" id="comentarios" name="comentarios" autocomplete="off" value=""></textarea>
          </div>
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary mg-r-auto" id="regresar" data-dismiss="modal" style="margin-right: auto;">Regresar</button>
          <button type="button" class="btn btn-primary mg-l-auto" id="btnResolver">Aceptar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalAsignacionclave" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-dialog-vertical-center" role="document" style="">
      <div class="modal-content bd-0 tx-14" style="min-width: 100%">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Resolver Tarea</h6>
        </div>
        <div class="modal-body pd-25">
          <h5 id="mensajeAsignacionclave">Indique la subclave para la carpeta UGJEMS</h5>
          <div class="form-group">
            <label class="form-control-label">Subclave: </label>
              <select class="form-control" id="subclaveugjems" name="subclave_ugjems" autocomplete="off">
              <option selected disabled>Seleccione una opción</option>
              <option value="IP">IP</option>
              <option value="CE">CE</option>
            </select>
          </div>
        </div>
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary mg-r-auto" id="regresar" data-dismiss="modal" style="margin-right: auto;">Regresar</button>
          <button type="button" class="btn btn-primary mg-l-auto" id="btnResolverClave">Aceptar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalWarning" class="modal fade">
		<div class="modal-dialog modal-dialog-vertical-center mg-b-100" role="document">
			<div class="modal-content bd-0 tx-14">
				<div class="modal-header">
					<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Atención</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body pd-25" id="mensajeWarning">

				</div>
				<div class="modal-footer ">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<div id="botonWarning" style="margin-left: auto;">

					</div>
				</div>
			</div>
		</div><!-- modal-dialog -->
	</div><!-- modal -->
  <!-- LARGE MODAL -->
  <div id="modaldemo3" class="modal fade" style="overflow-y: scroll;" data-backdrop="static">
    <div class="modal-dialog modal-xl mg-b-100" role="document" style="max-width: 340px;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">

        </div>
        <div class="modal-body pd-20">


        </div><!-- modal-body -->
        <div class="modal-footer">

        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalSentenciado" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Datos del sentenciado</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row mg-b-15">
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Nombre del sentenciado:<span class="tx-danger">*</span></label>
                <select class="form-control select2" id="imputados" name="imputados" autocomplete="off">
                </select>
              </div>
            </div>
          </div>
          <div class="row mg-b-15">
            <div class="col-md-5">
              <div class="form-group" id="">
                <label class="form-control-label">¿El sentenciado se encuentra en libertad?:
                  <span class="tx-danger">*</span></label>
                <div class="row pd-7">
                  <div class="col-6 col-md-4">
                    <label class="rdiobox d-inline-block mg-l-20">
                      <input name="sentenciado_libertad" type="radio" value="si" class="sentenciado_libertad" onchange="sentenciadoLibertad()">
                      <span class="pd-l-0">Sí</span>
                    </label>
                  </div>
                  <div class=" col-6 col-md-4">
                    <label class="rdiobox d-inline-block mg-l-20">
                      <input name="sentenciado_libertad" type="radio" value="no" class="sentenciado_libertad" onchange="sentenciadoLibertad()">
                      <span class="pd-l-0">No</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label class="form-control-label">Centro de detención: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="centroDetencion" name="centro_detencion" autocomplete="off">
                  <option value="" disabled selected>Seleccione una opción</option>
                  <option value="1">Reclusorio Preventivo Varonil Norte</option>
                  <option value="2">Reclusorio Preventivo Varonil Oriente</option>
                  <option value="3">Reclusorio Preventivo Varonil Sur</option>
                  <option value="9">Centro Femenil de Reinserción Social (Santa Martha)</option>
                  {{-- <option value="5">Dr. Lavista</option>
                  <option value="4">Sullivan</option> --}}
                </select>
              </div>
            </div>
          </div>
          <div class="row mg-b-30">
            <div class="col-12">
              <div>
                <div class="d-flex">
                  <label for="table-remi" class="form-control-label">Penas impuestas en la sentencia:</label>
                  <a href="javascript:void(0)" onclick="nuevaPena()" class="mg-l-auto"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar pena</a>
                </div>
                <table class="table-remi" id="tablePenas">
                  <thead>
                    <tr>
                      <th class="acciones">Acciones</th>
                      <th class="pena">Pena impuesta</th>
                      <th class="delitos">Deltilos</th>
                      <th class="detalles">Detalles adicionales</th>
                      <th class="sustitutivo">Sustitutivo para la pena</th>
                    </tr>
                  </thead>
                  <tbody id="bodyPenas">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row mg-b-15">
            <div class="col-12">
              <div class="form-group" id="">
                <label class="form-control-label">
                  ¿Se concede la SUSPENSIÓN CONDICIONAL DE LA EJECUCIÓN DE LA PENA?:
                  <span class="tx-danger">*</span></label>

                  <label class="rdiobox d-inline-block mg-l-15">
                    <input name="suspension_ejecucion" type="radio" value="si" class="suspension_ejecucion">
                    <span class="pd-l-0">Sí</span>
                  </label>
                  <label class="rdiobox d-inline-block mg-l-15">
                    <input name="suspension_ejecucion" type="radio" value="no" class="suspension_ejecucion">
                    <span class="pd-l-0">No</span>
                  </label>
              </div>
            </div>
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarSentenciado()">Guardar sentenciado</button>
          <button type="button" class="btn btn-secondary" onclick="abreModal('modalDatosTarea',300)" data-dismiss="modal" aria-label="Close">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalPenas" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Registrar pena</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="card">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#datosGenerales" data-toggle="tab" id="navDatosGenerales">Datos generales</a>
                </li>
                <li class="nav-item d-none" id="sectionAbonoPrision">
                  <a class="nav-link" href="#abonoPrision" data-toggle="tab">Abono de prisión preventiva</a>
                </li>
                <li class="nav-item d-none" id="sectionSustitutivosPena">
                  <a class="nav-link" href="#sutitutivosPena" data-toggle="tab">Sustitutivos de pena</a>
                </li>
              </ul>
            </div><!-- card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="datosGenerales">
                  <div class="row mg-b-10">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label">Tipo de pena:<span class="tx-danger">*</span></label>
                        <select class="form-control select2" id="tipoPena" name="tipo_pena" autocomplete="off" onchange="obtenerPenas()">
                          <option value="" disabled selected>Seleccione una opción</option>
                          @foreach ($penas as $pena)
                              <option value="{{$pena['id_tipo_pena']}}">{{$pena['descripcion']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <label class="form-control-label">Pena impuesta:<span class="tx-danger">*</span></label>
                        <select class="form-control" id="penaImpuesta" name="pena_impuesta" autocomplete="off" onchange="penaImpuesta()">
                          <option value="">Seleccione una opción</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-10 d-none" id="divDecomisos">
                    <div class="col-md-4">
                      <label class="ckbox">
                        <input type="checkbox" class="decomiso" id="decomisoInstrumento"><span>Decomiso de instrumento</span>
                      </label>
                    </div>
                    <div class="col-md-4">
                      <label class="ckbox">
                        <input type="checkbox" class="decomiso" id="decomisoObjetos"><span>Decomiso de objetos</span>
                      </label>
                    </div>
                    <div class="col-md-4">
                      <label class="ckbox">
                        <input type="checkbox" class="decomiso" id="decomisoProductos"><span>Decomiso de productos del delito</span>
                      </label>
                    </div>
                  </div>
                  <div class="row mg-b-10">
                    <div class="col-12">
                      <div class="form-group d-none" id="divDetallePena">
                        <label class="form-control-label">Detalle de la pena:<span class="tx-danger">*</span></label>
                        <select class="form-control" id="detallePena" name="detalle_pena" autocomplete="off">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-10 d-none" id="divPeriodo">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Años: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="periodo_anios" id="periodoAnios" autocomplete="off" oninput="calculoAbonoSentencia()" min="0" >
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Meses: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="periodo_meses" id="periodoMeses" value=""  placeholder="" autocomplete="off" oninput="calculoAbonoSentencia()" min="0">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Días: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="periodo_dias" id="periododias" value=""  placeholder="" autocomplete="off" oninput="calculoAbonoSentencia()" min="0">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" id="divCentroDetencionPena">
                        <label class="form-control-label">Centro de detención actual:<span class="tx-danger">*</span></label>
                        <select class="form-control" id="centroDetencionPena" name="centro_detencion_pena" autocomplete="off" >
                          <option value="" disabled selected>Seleccione una opción</option>
                          
                          @foreach ($centros_detencion as $centro_detencion)
                              <option value="{{$centro_detencion['id_reclusorio']}}">{{$centro_detencion['nombre']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-10">
                    <div class="col-12">
                      <div class="form-group">
                        <label class="form-control-label">Detalles Adicionales:</label>
                        <textarea class="form-control" name="detalles_adicionales" id="detallesAdicionalesPena" rows="4"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-30">
                    <div class="col-12">
                      <div>
                        <div class="row">
                          <div class="col-6">
                            <label for="table-remi" class="form-control-label">Delitos por los cuales se impone al pena:</label>
                          </div>
                          <div class="col-6 text-right">
                            <a href="javascript:void(0)" onclick="nuevoDelito()" class=""><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar delito</a>
                          </div>
                        </div>
                        <table class="table-remi">
                          <thead>
                            <tr>
                              <th class="acciones">Acciones</th>
                              <th class="delito">Delitos</th>
                            </tr>
                          </thead>
                          <tbody id="bodyDelitos">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div><!-- tab-pane -->
                <div class="tab-pane" id="abonoPrision">
                  <div class="row mg-b-15">
                    <div class="col-12">
                      <a href="javascript:void(0)" onclick="nuevoAbono()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar cómputo</a>
                    </div>
                  </div>
                  <div class="row mg-b-15 d-none" id="divCentroDetencionAbono">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Años: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="abono_anios" id="abonoAnios" value="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Meses: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="abono_meses" id="abonoMeses" value="">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label class="form-control-label">Días: <span class="tx-danger">*</span></label>
                        <input class="form-control input-number" type="text" name="abono_dias" id="abonodias" value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Centro de detención:<span class="tx-danger">*</span></label>
                        <select class="form-control select2-show-search" id="centroDetencionAbono" name="centro_detencion_abono" autocomplete="off" onchange="centroDetencionAbono()">
                          <option value="" selected disabled>Seleccione una opción</option>
                          <option value="otro">Otro</option>
                          @foreach ($centros_detencion as $centro_detencion)
                              <option value="{{$centro_detencion['id_reclusorio']}}">{{$centro_detencion['nombre']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Otro centro de detención:</label>
                        <input class="form-control" type="text" name="centro_detencion_abono_otro" id="centroDetencionAbonoOtro" value=""  placeholder="" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 28px">
                      <button type="button" class="btn btn-outline-primary" onclick="agregarAbono()">Agregar</button>
                      <button type="button" class="btn btn-outline-secondary"  onclick="cancelarAbono()">Cancelar</button>
                    </div>
                  </div>
                  <div class="row mg-b-30">
                    <div class="col-md-12">
                      <table class="table-remi d-block">
                        <thead>
                          <th class="acciones">Acciones</th>
                          <th class="anios_abono">Años</th>
                          <th class="meses_abono">Meses</th>
                          <th class="dias_abono">Días</th>
                          <th class="centro_abono">Centro de detención</th>
                          <th class="otro_centro_abono">Otro centro de detención</th>
                        </thead>
                        <tbody id="bodyAbonos"></tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <p style="font-weight: bold">Total de abono de prisión preventiva:</p>
                    </div>
                    <div class="col-md-4">
                      <p><span id="abonoAniosTotal">0</span> años, <span id="abonoMesesTotal">0</span> meses, <span id="abonoDiasTotal">0</span> días</p>
                    </div>
                  </div>
                  <div class="row mg-b-15">
                    <div class="col-md-4">
                      <p style="font-weight: bold">Total de sentencia por cumplir:</p>
                    </div>
                    <div class="col-md-4">
                      <p><span id="aniosTotalCumplir">0</span> años, <span id="mesesTotalCumplir">0</span> meses, <span id="diasTotalCumplir">0</span> días</p>
                    </div>
                  </div>
                </div><!-- tab-pane -->
                <div class="tab-pane" id="sutitutivosPena">
                  <div class="row mg-b-15">
                    <div class="col-12">
                      <a href="javascript:void(0)" onclick="nuevoSustitutivo()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33"></i> Agregar sustitutivo</a>
                    </div>
                  </div>
                  <div id="sistitutivoNuevo" class="d-none">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label">Sustitutivo:<span class="tx-danger">*</span></label>
                          <select class="form-control select2-show-search" id="sustitutivo" name="sustitutivo" autocomplete="off" onchange="sustitutivo()">
                            <option value="" selected>Seleccione una opción</option>
                            <option value="1" >Multa en beneficio de la víctima</option>
                            <option value="2" >Multa en favor de la comunidad</option>
                            <option value="3" >Trabajo en beneficio de la víctima</option>
                            <option value="4" >Trabajo en favor de la comunidad</option>
                            <option value="5" >Tratamiento en libertad</option>
                            <option value="6" >Tratamiento en semilibertad</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group d-none" id="divMonto">
                          <label class="form-control-label">Monto:</label>
                          <input class="form-control input-money" type="text" name="monto_sustitutivo" id="montoSustitutivo" value="" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-15">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-control-label">¿Se acoge al sustitutivo?<span class="tx-danger">*</span></label>
                          <div class="d-inline-block mg-l-5 mg-t-10" id="divMateriaDestino">
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="acoge_sustitutivo" type="radio" value="si" class="acoge_sustitutivo_val">
                              <span class="pd-l-0">Si</span>
                            </label>
                            <label class="rdiobox d-inline-block mg-l-5">
                              <input name="acoge_sustitutivo" type="radio" value="no" class="acoge_sustitutivo_val">
                              <span class="pd-l-0">no</span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-15">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label">Detalles adicionales:</label>
                          <textarea class="form-control" name="detalles_adicionales_sustitutivo" id="detallesAdicionalesSustitutivo" rows="4"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row mg-b-20">
                      <div class="col-12 d-flex">
                        <button type="button" class="btn btn-outline-primary mg-l-auto" onclick="agregarSustitutivo()">Guardar</button>
                        <button type="button" class="btn btn-outline-secondary mg-l-10" onclick="cancelarSustitutivo()">Cancelar</button>
                      </div>
                    </div>
                  </div>
                  <div class="row mg-b-30">
                    <div class="col-12">
                      <table class="table-remi d-block d-md-table">
                        <thead>
                          <th class="acciones">Acciones</th>
                          <th class="sustitutivo">Sustitutivo</th>
                          <th class="monto_sustitutivo">Monto</th>
                          <th class="acoge_sustitutivo">Se acoge al sustitutivo</th>
                          <th class="detalles_adicionales_sustitutivo">Detalles adicionales</th>
                        </thead>
                        <tbody id="bodySustitutivos"></tbody>
                      </table>
                    </div>
                  </div>
                </div><!-- tab-pane -->
              </div><!-- tab-content -->
            </div><!-- card-body -->
          </div><!-- card -->
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarPena()">Guardar pena</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalSentenciado',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDelitos" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar delito</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row mg-b-10">
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Delito a agregar:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="delitoPena" name="delitoPena" autocomplete="off">
                </select>
              </div>
            </div>
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarDelito()">Guardar delito</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalPenas',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDefensor" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar defensor</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="row mg-b-10">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-control-label">Tipo de presona:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="tipoPersonaDefensor" name="tipo_persona_defensor" autocomplete="off">
                  <option value="" selected disabled>Seleccione una opción</option>
                  <option value="fisica">Física</option>
                  <option value="moral">Moral</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 fisica">
              <div class="form-group">
                <label class="form-control-label">Nacionalidad:<span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" id="nacionalidadDefensor" name="nacionalidad_defensor" autocomplete="off">
                  <option value="" selected disabled>Seleccione una opción</option>
                  <option value="mexicana">Mexicana</option>
                  <option value="extranjero">Extranjero</option>
                  <option value="mexicana_otro">Mexicana/Otra</option>
                  <option value="no_especificada">No especificada</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 fisica">
              <div class="form-group">
                <label class="form-control-label">Indique la Nacionalidad: </label>
                <select class="form-control " id="otraNacionalidadDefensor" name="otra_nacionalidad_defensor" autocomplete="off" disabled>
                    <option selected  value="" disabled>Elija una opción</option>
                    @foreach ($nacionalidades as $nacionalidad)
                          <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option>
                    @endforeach
                </select>
              </div>
            </div><!-- col-6-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Nombre(s): <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="nombre_defensor" id="nombreDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="apellido_paterno_defensor" id="apellidoPaternoDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Materno:</label>
                <input class="form-control" type="text" name="apellido_materno_defensor" id="apellidoMaternoDefensor" autocomplete="off">
              </div>
            </div><!-- col-4-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Genero: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="generoDefensor" name="genero_defensor" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="masculino">MASCULINO</option>
                    <option value="femenino">FEMENINO</option>
                    <option value="indeterminado">INDETERMINADO</option>
                </select>
              </div>
            </div><!-- col-4-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Fecha de Nacimiento: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaNacimientoDefensor" name="fecha_nacimiento_defensor" autocomplete="off">
                </div>
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-3 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Edad:</label>
                <input class="form-control input-number" type="text" name="edad_defensor" id="edadDefensor" autocomplete="off">
              </div>
            </div><!-- col-4-->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Estado Civil: </label>
                <select class="form-control select2" id="estadoCivilDefensor" name="estado_civil_defensor" autocomplete="off">
                    <option selected   value="">Elija una opción</option>
                    @foreach ($estado_civil as $estado)
                        <option value="{{$estado['id_estado_civil']}}">{{$estado['estado_civil']}}</option>
                    @endforeach
                </select>
              </div>
            </div><!-- col-4-->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">CURP:</label>
                <input class="form-control" type="text" name="curp_defensor" id="curpDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
          </div>
          <div class="row mg-b-15">
            <div class="col-lg-8 moral d-none">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Razón Social:</label>
                <input class="form-control" type="text" name="razon_social_defensor" id="razonSocialDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 moral d-none">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">RFC:</label>
                <input class="form-control" type="text" name="rfc_defensor" id="rfcDefensor" autocomplete="off">
              </div>
            </div><!-- col-4 -->
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="agregarNuevoDefensor()">Agregar delito</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalPenas',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalDocumento" class="modal fade" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-inverse tx-bold" id="nombreDocumento"></h6>
        </div>
        <div class="modal-body pd-20" id="objectDocumento">
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="abreModal('modalDatosTarea',400)">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modaldemo398" class="modal fade" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Message Preview</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <h5 class=" lh-3 mg-b-20"><a href="" class="tx-inverse hover-primary">Why We Use Electoral College, Not Popular Vote</a></h5>
          <p class="mg-b-5">What is Lorem Ipsum?
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            
            Why do we use it?
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
            
            
            Where does it come from?
            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
            
            The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
            
            Where can I get some?
            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc. What is Lorem Ipsum?
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            
            Why do we use it?
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
            
            
            Where does it come from?
            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
            
            The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
            
            Where can I get some?
            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalAlertaConfirmacion" class="modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content bd-0 tx-14">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Atención</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <p class="mg-b-5" id="mensajeAlertaConfirmacion"></p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btn_tareas_estatus" value="" onclick="enviaTareasAtendidas(this.value)">Aceptar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div>
  
@endsection
