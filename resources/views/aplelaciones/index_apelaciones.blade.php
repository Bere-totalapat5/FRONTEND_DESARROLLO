@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')
@section('contenido-pageheader')


    <ol class="breadcrumb slim-breadcrumb d-none d-md-flex">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Recursos de apelacion</li>
    </ol>
    <h6 class="slim-pagetitle" id="title_tareas">Recursos de apelacion</h6>

@endsection

@section('contenido-principal')
  <div class="section-wrapper mg-b-100" id="pageone" data-role="page">
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 57, 0))
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
      <div class="form-layout mg-b-25" style="" >
        <div id="divButtonN" style="">
          <button type="button" class="btn btn-primary mg-l-auto" style="" onclick="nuevoJuicioAmparo()" id="btnNuevoAmparo">Registrar nuevo juicio de amparo</button>
        </div>
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
                                    {{-- @foreach ($ugas as $uga)
                                            <option value="{{$uga['id_unidad_gestion']}}">{{$uga['nombre_unidad']}}</option>
                                    @endforeach --}}
                            </select>
                        </div>
                    </div>                    
                  @endif
                  <div class="col-lg-3 d-none">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Folio:</label>
                      <input class="form-control" type="text" name="folio" id="folio" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="form-control-label">Tipo de amparo: </label>
                      <select class="form-control select2-show-search" id="tipo_amparo_consulta" name="estatus" autocomplete="off">
                        <option value="">Todos</option>
                        <option value="10">Amparo directo</option>
                        <option value="1">Amparo indirecto</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="form-control-label">Categoria de amparo: </label>
                      <select class="form-control select2-show-search" id="categoria_amparo_consulta" name="estatus" autocomplete="off">
                        <option value="">Todos</option>
                        <option value="amparo_cierto">Ampato cierto</option>
                        <option value="amparo_transitorio">Ampato transitorio</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-3">
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
                  <div class="col-lg-3">
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
                  <div class="col-lg-3 d-none">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label" >Carpeta Inv:</label>
                      <input class="form-control" type="text" name="carpeta_inv" id="carpetaInv" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-3 d-none">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Nombre:</label>
                      <input class="form-control" type="text" name="nombre_persona" id="nombrePersona" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-3 d-none">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Apellido Paterno:</label>
                      <input class="form-control" type="text" name="ap_paterno_persona" id="apPaternoPersona" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-lg-3 d-none">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Apellido Materno:</label>
                      <input class="form-control" type="text" name="ap_materno_persona" id="apMaternoPersona" value="" autocomplete="off">
                    </div>
                  </div><!-- col-3 -->
                </div>
                <div class="row col-lg-12">
                  <div class="col-lg-12 d-flex">
                    <button class="btn btn-primary mg-l-auto " onclick="buscar(1)">Buscar</button>
                  </div>
                </div>
              </div><!-- card-bod -->
            </div>
          </div>
        </div><!-- accordion -->
        
      </div>
      <div class="row"  >
        <div class="col-lg-12">
          <table  data-swipe-ignore="true" id="tableAmparos" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
            <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
              <th class="acciones">Acciones</th>
              <th class="folio_registro">Folio de registro</th>
              <th class="carpeta_amparo">Carpeta de amparo</th>
              <th class="fecha_registro">Fecha de registro</th>
              <th class="tipo_amparo">Tipo amparo</th>
              <th class="carpeta_referida">Carpeta referida</th>
              <th class="no_juicio_amparo">No. de juicio de amparo</th>
              <th class="autoridad_requiriente">Autoridad requiriente</th>
              <th class="entidad_federativa_requiriente">Entidad federativa requiriente</th>
              <th class="registrado_por">Registrado por</th>
              <th class="comentarios_adicionales">Comentarios adicionales</th>
              <th class="situacion">Situación</th>
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
<link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
<link rel="stylesheet" href="/css/amparos/amparos.css">
<link rel="stylesheet" href="/js/clockpicker-gh-pages/src/clockpicker.css">
<link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
@endsection

@section('seccion-scripts-libs')
<script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>  
<script src="../lib/jquery-ui/js/jquery-ui.js"></script>
<script src="/js/picker.js"></script>
<script src="/js/amparos/amparos.js"></script>
<script src="/js/moment.js"></script>
<script src="/js/moment-with-locales.js"></script>
@endsection

@section('seccion-scripts-functions')
  <script>
    $(document).ready( function() {
      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },600);
    });
  </script>
@endsection

@section('seccion-modales')
  <div id="modalNuevoAmparo" class="modal fade"  data-backdrop="static" data-keyboard="false" style="overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Recepción de juicio de amparo</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="form-layout">
            <form action="" onsubmit="return false" id="formNewAmparo"> 
              <div  class="slim-pagetitle mg-t-20">
                <h6>Datos generales:</h6>  
              </div>
              <div class="row pd-l-10">
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="form-control-label">Fecha de recepción: <span class="tx-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control fc-datepicker-A" placeholder="DD/MM/AAAA" id="fechaRecepcion"  name="fecha_recepcion" autocomplete="off" value="{{date('d-m-Y')}}">
                    </div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="form-control-label">Hora de Recepción <small>(24hrs)</small>: <span class="tx-danger">*</span></label>
                    <div class="d-flex">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                          </div><!-- input-group-text -->
                        </div><!-- input-group-prepend -->
                        <input  type="text" class="form-control time-edit-A clockpicker-A" id="horaRecepcion" name="hora_recepcion" placeholder="hh:mm" autocomplete="new-password" data-align="top" data-autoclose="true" value="{{date('H:i')}}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="form-control-label">Tipo de amparo: <span class="tx-danger">*</span></label>
                    <select class="form-control select2" id="tipoAmparo" name="tipo_amparo" autocomplete="off" onchange="mostrarAutoridades()">
                        <option selected disabled value="">Elija una opción</option>
                        <option value="10">Amparo directo</option>
                        <option value="1">Amparo indirecto</option>
                    </select>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">No. de juicio de amparo:</label>
                    <input class="form-control" type="text" name="no_juicio_amparo" id="noJuicioAmparo">
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">No. de oficio de la autoridad federal:</label>
                    <input class="form-control" type="text" name="no_oficio" id="noOficio">
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="form-control-label">Entidad federativa de la autoridad requiriente: <span class="tx-danger">*</span></label>
                    <select class="form-control select2-show-search" id="entidadFederativa" name="entidad_federativa" autocomplete="off" onchange="mostrarAutoridades()">
                      <option selected disabled value="">Elija una opción</option>                                          
                      @if ( $estados['status'] == 100 )
                        @foreach ( $estados['response'] as $estado )
                          <option value="{{$estado['cve_estado']}}">{{$estado['estado']}}</option>
                        @endforeach      
                      @endif    
                    </select>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">Autoridad de Control Constitucional requiriente: <span class="tx-danger">*</span><br>&nbsp;</label>
                    <select class="form-control select2-show-search" id="autoridadControl" name="autoridad_control" autocomplete="off">
                      <option selected disabled value="">Elija una opción</option>
                    </select>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="form-control-label">Categoria del amparo: <span class="tx-danger">*</span></label>
                    <select class="form-control select2" id="categoriaAmparo" name="categoria_amparo" autocomplete="off">
                        <option selected disabled value="">Elija una opción</option>
                        <option value="amparo_cierto">Ampato cierto</option>
                        <option value="amparo_transitorio">Ampato transitorio</option>
                    </select>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-3">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Carpeta referida:</label>
                    <input class="form-control" type="text" name="carpeta_referida" id="carpetaReferida" autocomplete="off">
                    <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
                    <ul class="list-group d-none" id="listaCarpetas" style="max-height: 150px; overflow-y: auto; position: absolute; border: 1px solid #EEE; border-top: 0; padding: 5px 5px; color: #6c757d; background-color: #fff; width: 88%; z-index: 1;">
                    </ul>
                  </div>
                </div><!-- col-3 -->
              </div>
              <div  class="slim-pagetitle mg-t-20">
                <h6>Juez referido:</h6>  
              </div>
              <div class="row pd-l-10">
                <div class="col-lg-12">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label"></label>
                    <div id="juecesReferir" class="row" style="max-height: 15em; overflow: auto; border: 1px solid #EEE; padding: 1em;">
                      @if ( $jueces['status'] == 100 )
                        @foreach ( $jueces['response'] as  $juez )
                          <div class="col-md-4 col-lg-3">
                            <label class="ckbox">
                              <input type="checkbox" value="{{$juez['id_usuario']}}" class="juez_referir" name="juez_referido">
                              <span>
                                Juez  {{$juez['cve_juez']}}
                                {{-- {{$juez['nombres'] == null ? '' : $juez['nombres']}} 
                                {{$juez['apellido_paterno'] == null ? '' : $juez['apellido_paterno']}} 
                                {{$juez['apellido_materno'] == null ? '' : $juez['apellido_materno']}}  --}}
                                ({{$juez['descripcion']}})</span>
                            </label>
                          </div>
                        @endforeach
                          
                      @endif
                      
                    </div>
                  </div>
                </div>
              </div>
              <div  class="slim-pagetitle mg-t-20 mg-b-20">
                <h6>Quejoso</h6>  
              </div>
              <div class="row pd-l-10">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label">Quejoso: </label>
                    <div class="d-flex">
                      <select class="form-control select2" id="quejoso" name="quejoso" autocomplete="off">
                        <option selected disabled value="">Elija una opción</option>                            
                      </select>
                      <a href="javascript:void(0)" style="font-size: 26px; margin-left: 15px;" onclick="agregarQuejoso()">
                        <i class="fa fa-plus-circle d-inline-block" aria-hidden="true"></i>
                      </a>
                      <a href="javascript:void(0)" style="font-size: 26px; margin-left: 15px; margin-right: 15px;">
                        <i  class="fa fa-user-plus d-inline-block" aria-hidden="true" onclick="nuevaParteQuejoso()"></i>
                      </a>
                    </div>
                  </div>

                  <table style="border: 1px solid #EEE" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0" id="tableQuejoso">
                    <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true" >
                      <tr>
                        <th class="acciones">Acciones</th>
                        <th class="tx-center nombre_quejoso">Nombre del quejoso</th>
                      </tr>
                    </thead>
                    <tbody id="bodyQuejosos">
                    </tbody>
                  </table>
                </div>
              </div>
              <div  class="slim-pagetitle mg-t-20 mg-b-20">
                <h6>Acto reclamado:</h6>  
              </div>
              <div class="row pd-l-10">
                <div class="col-lg-12">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="form-control-label">Acto reclamado:</label>
                          <select class="form-control select2-show-search" id="acto_reclamado" name="acto_reclamado" autocomplete="off">
                            <option selected disabled value="">Elija una opción</option>
                            @if ( $actos_reclamacion['status'] == 100)
                              @foreach ( $actos_reclamacion['response'] as $acto )
                                <option value="{{$acto['id_acto']}}">{{$acto['acto_reclamado']}}</option>                            
                              @endforeach    
                            @endif                                          
                          </select>    
                        </div>  
                      </div>
                      <div class="col-md-5">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Detalles adicionales: </label>
                          <textarea class="form-control" type="text" name="detalles_adicionales_acto" id="detalles_adicionales_acto"></textarea>
                        </div>
                      </div>
                      <div class="col-md-2 tx-center pd-b-10" style="display: grid;">
                        <a href="javascript:void(0)" onclick="agregarActoReclamado()" style="font-size: 26px;margin-top: auto;margin-bottom: auto;display: block;">
                          <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        </a>
                      </div>
                    </div>
                    <table style="border: 1px solid #EEE" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0" id="tableActos">
                      <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true" >
                        <tr>
                          <th class="acciones tx-center">Acciones</th>
                          <th class="tx-center acto_reclamado">Acto reclamado</th>
                          <th class="tx-center detalles_adicionales_acto">Detalles adicionales</th>
                        </tr>
                      </thead>
                      <tbody id="bodyActosReclamados">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div  class="slim-pagetitle mg-t-20 mg-b-20">
                <h6>Documento:</h6>  
              </div>
              <div class="row pd-l-10">
                <div class="col-lg-3 mg-t-10">
                  <div class="custom-input-file">
                    <input type="file" id="archivoPDF" class="input-file" value="" name="documento_adjunto" accept="application/pdf" onchange="adjuntaDocumento(this)">
                    <p class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</p>
                  </div>
                  <div id="iconPDF" class="tx-center pd-t-15" style="width: 100%; display: flex;"></div>
                </div>
                <div class="col-lg-9" id="document">

                </div>
              </div>
              <div  class="slim-pagetitle mg-t-20 mg-b-20">
                <h6>Información complementaria:</h6>  
              </div>
              <div class="row pd-l-10">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Tipo de promoción: <span class="tx-danger">*</span></label>
                    <select id="tipo_audiencia" name="tipo_audiencia" autocomplete="off" class="form-control select2" onchange="tipoAudiencia()">
                      <option selected disabled>Elija una opción</option>
                      <option value="1">1.- Requerimiento de informe previo</option>
                      <option value="2">2.- Requerimiento de informe justificado</option>
                      <option value="3">3.- Requerimiento de informe diverso</option>
                      <option value="4">4.- Informe de audiencia constitucional</option>
                      <option value="5">5.- Informe de suspensión definitivo del acto reclamado</option>
                      <option value="6">6.- Informe de diferimiento de audiencia constitucional</option>
                      <option value="7">7.- Informe de acumulación de procesos</option>
                      <option value="8">8.- Informe de consesión de amparo</option>
                      <option value="9">9.- Informe de negación de amparo</option>
                      <option value="10">10.- Causa ejecutoria</option>
                      <option value="11">11.- Requerimiento de cumplimiento de amparo</option>
                      <option value="12">12.- Informe de interposición de inconformidad</option>
                      <option value="13">13.- Informe de interposisicón de queja</option>
                      <option value="14">14.- Otros informes</option>
                      <option value="15">15.- Se decreta el sobreseimiento del juicio de amparo</option>
                      <option value="16">16.- Informe de audiencia incidental</option>			
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mg-b-10-force" id="divEspecificacion">
                    <label class="form-control-label">Especifique:</label>
                    <input class="form-control" type="text" name="especificacion" id="especificacion">
                  </div>
                </div>
                <div class="col-12" id="divFundamentos">
                  <div class="form-group" >
                    <label class="form-control-label d-block">Fundamento: <span class="tx-danger">*</span></label>
                    <div class="d-inline-block mg-l-10" id="">
                      {{-- 1.- Requerimiento de informe previo --}}
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-50 fundamentos" id="fundamento_132">
                          <input name="fundamento" type="radio" value="132">
                          <span class="pd-l-0">132 de la Ley de Amparo Abrogada
                          </span>
                        </label>
                      </div>
                      
                      {{-- 1.- Requerimiento de informe previo --}}
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-50 fundamentos" id="fundamento_140">
                          <input name="fundamento" type="radio" value="140">
                          <span class="pd-l-0">	140 de la Ley de Amparo Vigente
                          </span>
                        </label>
                      </div>

                      {{-- 2.- Requerimiento de informe justificado --}}
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-50 fundamentos" id="fundamento_117">
                          <input name="fundamento" type="radio" value="117">
                          <span class="pd-l-0">117 de la Ley de Amparo Vigente</span>
                        </label>
                      </div>

                      {{-- 2.- Requerimiento de informe justificado --}}
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-50 fundamentos" id="fundamento_149">
                          <input name="fundamento"  type="radio" value="149">
                          <span class="pd-l-0">149 de la Ley de Amparo Abrogada
                          </span>
                        </label>                    
                      </div>  
                    </div>
                  </div>
                </div>
                <div class="col-md-8 divTermino" id="">
                  <div class="form-group">
                    <label class="form-control-label">Término o plazo para rendir el informe solicitado: <span class="tx-danger">*</span></label>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                            </div>
                          </div>
                          <input type="text" class="form-control fc-datepicker-A" placeholder="DD/MM/AAAA" id="fecha_termino"  name="fecha_termino" autocomplete="off" onchange="calculaFechaTermino()" value="{{date('d-m-Y')}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="d-flex">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                              </div><!-- input-group-text -->
                            </div><!-- input-group-prepend -->
                            <input  type="text" class="form-control time-edit-A clockpicker-A" id="hora_termino" name="hora_termino" placeholder="hh:mm" autocomplete="off"  data-align="top" data-autoclose="true" onchange="calculaFechaTermino()" value="{{date('H:i')}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group mg-b-10-force pd-t-15">
                          <label class="form-control-label">Días:</label>
                          <input class="form-control input-number" type="text" name="dias" id="dias" placeholder="Días" oninput="calculaFechaTermino()">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group mg-b-10-force pd-t-15">
                          <label class="form-control-label">Horas:</label>
                          <input class="form-control input-number" type="text" name="horas" id="horas" placeholder="Horas" oninput="calculaFechaTermino()">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 divTermino" style=" display: flex; align-items: center;">
                  <div class="form-group mg-b-10-force pd-t-15" style="margin-left: auto; margin-right: auto; width: 100%;">
                    <input class="form-control" type="text" name="" id="fecha_hora_termino" placeholder="" readonly style="border: 2px solid #848F33;color: #848F33;height: 3em;font-size: 1.1em;text-align: center;padding: 2px; background-color: #F5F5F5;">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Comentarios adicionales:</label>
                    <textarea class="form-control" type="text" name="comentarios_adicionales" id="comentarios_adicionales" rows="3"></textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onclick="guardarJuicioAmparo()">Guardar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalAgregarParte" class="modal fade" data-backdrop="static" data-keyboard="false"  style="overflow: auto;">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document">
      <div class="modal-content bd-0 tx-14">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar parte</h6>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#datos_generales" data-toggle="tab">Datos generales</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#datos_alias" data-toggle="tab">Registro de alias</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#datos_contacto" data-toggle="tab">Datos de contacto</a>
                </li>
              </ul>
            </div><!-- card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="datos_generales">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label">Calidad jurídica: </label>
                        <select class="form-control select2-show-search" id="calidadJuridica" name="calidad_juridica" autocomplete="off">
                          <option selected disabled value="">Elija una opción</option>                                          
                          @foreach ( $cat_calidad_juridica as $cal )
                            <option value="{{$cal['id_calidad_juridica']}}">{{$cal['calidad_juridica']}}</option>                            
                          @endforeach
                        </select>    
                      </div>  
                    </div>
                    <div class="col-md-4 d-none">
                      <div class="form-group">
                        <label class="form-control-label">Tipo de defensor: </label>
                        <select class="form-control select2-show-search" id="tipo_defensor" name="tipo_defensor" autocomplete="off">
                          <option selected disabled value="">Elija una opción </option>
                          <option value="publico">Público</option>
                          <option value="privado">Privado<option>                                                                    
                        </select>    
                      </div>  
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label">Tipo de persona: <span class="tx-danger">*</span></label>
                        <select class="form-control select2-show-search" id="tipo_persona" name="tipo_persona" autocomplete="off">
                          <option selected disabled value="">Elija una opción</option>                                          
                          <option value="fisica">FÍSICA</option>                                          
                          <option value="moral">MORAL</option>                                          
                        </select>    
                      </div>  
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label">Nacionalidad: <span class="tx-danger">*</span></label>
                        <select class="form-control select2-show-search" id="nacionalidad" name="nacionalidad" autocomplete="off">
                          <option selected disabled value="">Elija una opción</option>                                          
                          <option value="mexicana">MEXICANA</option>                                          
                          <option value="extranjera">EXTRANJERA</option>                                          
                          <option value="extranjera_mexicana">EXTRANJERA/MEXICANA</option>                                          
                          <option value="no_especificada">NO ESPECIFICADA</option>                                           
                        </select>    
                      </div>  
                    </div>
                    <div class="col-md-4 d-none">
                      <div class="form-group">
                        <label class="form-control-label">Indique la nacionalidad: </label>
                        <select class="form-control select2-show-search" id="otra_nacionalidad" name="otra_nacionalidad" autocomplete="off">
                          <option selected disabled value="">Elija una opción</option>
                          @if ( $nacionalidades['status'] == 100)
                            @foreach ( $nacionalidades['response'] as $nacionalidad )
                              <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option>                            
                            @endforeach    
                          @endif                                          
                        </select>    
                      </div>  
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label">Género: <span class="tx-danger">*</span></label>
                        <select class="form-control select2-show-search" id="genero" name="genero" autocomplete="off">
                          <option selected disabled value="">Elija una opción</option>                                          
                          <option value="masculino">MASCULINO</option>                                          
                          <option value="femenino">FEMENINO</option>                                          
                          <option value="no_identificaco">NO IDENTIFICADO</option>                                          
                        </select>    
                      </div>  
                    </div>
                    <div class="col-md-8">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Nombres: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="nombres_parte" id="nombres_parte">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Apellido paterno: </label>
                        <input class="form-control" type="text" name="apellido_parteno_parte" id="apellido_paterno_parte">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Apellido materno: </label>
                        <input class="form-control" type="text" name="apellido_marteno_parte" id="apellido_materno_parte">
                      </div>
                    </div>
                  </div>
                </div><!-- tab-pane -->
                <div class="tab-pane" id="datos_alias">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Alias: <span class="tx-danger">*</span></label>
                        <input class="form-control" type="text" name="alias" id="alias">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Apellido paterno: </label>
                        <input class="form-control" type="text" name="apellido_paterno_alias" id="apellido_paterno_alias">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Apellido materno: </label>
                        <input class="form-control" type="text" name="apellido_materno_alias" id="apellido_materno_alias">
                      </div>
                    </div>
                    <div class="col-md-2 tx-center" style="display: grid;">
                      <a href="javascript:void(0)" onclick="agregarAlias()" style="font-size: 26px;margin-top: auto;margin-bottom: auto;display: block;">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                      </a>
                    </div>
                  </div>
                  <table  data-swipe-ignore="true" id="tableAlias" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
                    <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
                      <th class="acciones">Acciones</th>
                      <th class="folio_registro">Alias</th>
                      <th class="carpeta_amparo">Apellido Paterno</th>
                      <th class="fecha_registro">Apellido Materno</th>
                    </thead>
                    <tbody id="bodyAlias">
                    </tbody>
                  </table>
                </div><!-- tab-pane -->
                <div class="tab-pane" id="datos_contacto">
                  <div>
                    <div  class="slim-pagetitle">
                      <h6>Domicilio</h6>  
                    </div>
                    <div class="row pd-10">
                      <div class="col-md-6">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Calle: </label>
                          <input class="form-control" type="text" name="calle" id="calle">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Número exterior:: </label>
                          <input class="form-control" type="text" name="no_exterior" id="no_exterior">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Número interior: </label>
                          <input class="form-control" type="text" name="no_interior" id="no_interior">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">C.P.: </label>
                          <input class="form-control" type="text" name="codigo_postal" id="codigo_postal">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Colonia: </label>
                          <input class="form-control" type="text" name="colonia" id="colonia">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Estado: </label>
                          <select class="form-control select2-show-search" id="estado" name="estado" autocomplete="off">
                            <option selected disabled value="">Elija una opción</option>                                          
                            @if ( $estados['status'] == 100 )
                              @foreach ( $estados['response'] as $estado )
                                <option value="{{$estado['cve_estado']}}">{{$estado['estado']}}</option>
                              @endforeach      
                            @endif                                  
                          </select>    
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Municipio: </label>
                          <select class="form-control select2-show-search" id="municipio" name="municipio" autocomplete="off">
                            <option selected disabled value="">Elija una opción</option>                                          
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Localidad: </label>
                          <input class="form-control" type="text" name="localidad" id="localidad">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Entre calle y calle: </label>
                          <input class="form-control" type="text" name="entre_calles" id="entre_calles">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Otras referencias: </label>
                          <textarea class="form-control" type="text" name="otra_referencia" id="otra_referencia"></textarea>
                        </div>
                      </div>
                    </div>
                    <div  class="slim-pagetitle mg-t-10">
                      <h6>Teléfonos</h6>  
                    </div>
                    <div class="row pd-10">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="form-control-label">Tipo: <span class="tx-danger">*</span></label>
                          <select class="form-control select2" id="tipo_telefono" name="tipo_telefono" autocomplete="off">
                            <option selected disabled value="">Elija una opción</option>                                          
                            <option value="fijo">Fijo</option>                                          
                            <option value="celular">Celular</option>                                          
                          </select>    
                        </div>  
                      </div>
                      <div class="col-md-2">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Lada: </label>
                          <input class="form-control" type="text" name="lada" id="lada">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Número: <span class="tx-danger">*</span></label>
                          <input class="form-control" type="text" name="numero_telefono" id="numero_telefono">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Extensión: </label>
                          <input class="form-control" type="text" name="extension" id="extension">
                        </div>
                      </div>
                      <div class="col-md-1 tx-center" style="display: grid;">
                        <a href="javascript:void(0)" onclick="agregarTelefono()" style="font-size: 26px;margin-top: auto;margin-bottom: auto;display: block;">
                          <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        </a>
                      </div>
                      <div class="col-12">
                        <table  data-swipe-ignore="true" id="tableTelefonos" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
                          <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
                            <tr>
                              <th class="text-center acciones"></th>
                              <th class="tipo">Tipo</th>
                              <th class="lada">Lada</th>
                              <th class="numero">Número</th>
                              <th class="extension">Extensión</th>
                            </tr>
                          </thead>
                          <tbody id="bodyTelefonos">
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div  class="slim-pagetitle mg-t-10">
                      <h6>Correos electrónicos</h6>  
                    </div>
                    <div class="row pd-10">
                      <div class="col-md-10">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Correo electrónico: <span class="tx-danger">*</span></label>
                          <input class="form-control" type="text" name="correo_electronico" id="correo_electronico">
                        </div>
                      </div>
                      <div class="col-md-2 tx-center" style="display: grid;">
                        <a href="javascript:void(0)" onclick="agregarCorreo()" style="font-size: 26px;margin-top: auto;margin-bottom: auto;display: block;">
                          <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        </a>
                      </div>
                      <div class="col-12">
                        <table  data-swipe-ignore="true" id="tableCorreos" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
                          <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
                            <tr>
                              <th class="acciones"></th>
                              <th class="tx-center correo">Correo electrónico</th>
                            </tr>
                          </thead>
                          <tbody id="bodyCorreos">
                          </tbody>
                        </table>
                      </div>
                    </div>                    
                  </div>
                </div><!-- tab-pane -->
              </div><!-- tab-content -->
            </div><!-- card-body -->
          </div><!-- card -->
        </div>
        <div class="modal-footer">          
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancelarParte" data-toggle="modal" data-target="#modalNuevoAmparo">Cancelar</button>
          <button type="button" class="btn btn-primary" onclick="guardarNuevaPersona()">Guardar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalSuccess" class="modal fade" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <p class="mg-b-20 mg-x-20" id="succesMessage"></p>
          <button type="button" class="btn btn-success pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="modalError" class="modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <p class="mg-b-20 mg-x-20" id="errorMessage"></p>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" onclick="abreModal('modalNuevoAmparo',400)">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>
@endsection