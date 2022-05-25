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
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 63, 0))
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
      <div class="form-layout mg-b-25" style="" >
        <div id="divButtonN" style="">
          <button type="button" class="btn btn-primary mg-l-auto" style="" onclick="nuevoRecursoApelacion()" id="btnNuevaApelación">Registrar nuevo recurso de apelación</button>
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
          <table  data-swipe-ignore="true" id="tableApelaciones" class="display dataTable dtr-inline collapsed" style="overflow-x: auto; padding-left:0; padding-rigth:0">
            <thead style="background-color: #EBEEF1; color: #000;" data-swipe-ignore="true">
              <th class="acciones">Acciones</th>
              <th class="folio_registro">Folio de registro</th>
              <th class="fecha_registro">Fecha de registro</th>
              <th class="carpeta_judicial">Carpeta judicial</th>
              <th class="carpeta_apelcaion">Carpeta de apelacion</th>
              <th class="nombre_apelante">Nombre del apelante</th>
              <th class="figura_juridica">Figura juridica</th>
              <th class="resolucion_impugnada">Resolución impugnada</th>
              <th class="nombre_resolucion">Nombre de la resolución</th>
              <th class="sala_asignada">Sala penal asignada</th>
              <th class="no_toca">Número de toca</th>
              <th class="registrado_por">Registrado por</th>
              <th class="situacion">Situación</th>
            </thead>
            <tbody id="bodyApelaciones">
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
<link rel="stylesheet" href="/css/apelaciones/apelaciones.css">
<link rel="stylesheet" href="/js/clockpicker-gh-pages/src/clockpicker.css">
<link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
@endsection

@section('seccion-scripts-libs')
<script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>  
<script src="../lib/jquery-ui/js/jquery-ui.js"></script>
<script src="/js/picker.js"></script>
<script src="/js/apelaciones/apelaciones.js?v=@php echo time(); @endphp"></script>
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
  <div id="modalNuevaApelacion" class="modal fade"  data-backdrop="static" data-keyboard="false" style="overflow: auto;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Registro de recurso de apelación</h6>
        </div>
        <div class="modal-body pd-20">
          <div class="form-layout">
            <form action="" onsubmit="return false" id="formNuevaApelacion"> 
              <div  class="slim-pagetitle mg-t-20">
                <h6>Datos generales:</h6>  
              </div>
              <div class="row pd-l-10">
                <div class="col-lg-5">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Carpeta Judicial:</label>
                    <input class="form-control" type="text" name="carpeta_referida" id="carpetaReferida" autocomplete="off">
                    <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
                    <ul class="list-group d-none" id="listaCarpetas" style="max-height: 150px; overflow-y: auto; position: absolute; border: 1px solid #EEE; border-top: 0; padding: 5px 5px; color: #6c757d; background-color: #fff; width: 88%; z-index: 1;">
                    </ul>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-7">
                  <div class="form-group">
                    <label class="form-control-label">Nombre del apelante: </label>
                    <div class="d-flex">
                      <select class="form-control select2-show-search" id="apelante" name="apelante" autocomplete="off">
                        <option selected disabled value="">Elija una opción</option>                            
                      </select>
                      {{-- <a href="javascript:void(0)" style="font-size: 26px; margin-left: 15px;" onclick="agregarQuejoso()">
                        <i class="fa fa-plus-circle d-inline-block" aria-hidden="true"></i>
                      </a>
                      <a href="javascript:void(0)" style="font-size: 26px; margin-left: 15px; margin-right: 15px;">
                        <i  class="fa fa-user-plus d-inline-block" aria-hidden="true" onclick="nuevaParteQuejoso()"></i>
                      </a> --}}
                    </div>
                  </div>
                </div>
                <div class="col-lg-5" id="divResolucionImpugnada">
                  <div class="form-group" >
                    <label class="form-control-label d-block">Resolución impugnada: <span class="tx-danger">*</span></label>
                    <div class="d-inline-block mg-l-10" id="">
                      {{-- 1.- Requerimiento de informe previo --}}
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-20 resolucion_impugnada" id="">
                          <input name="resolucion_impugnada" type="radio" value="emitida_escrito" onclick="resolucionImpugnada()">
                          <span class="pd-l-0">Emitida por escrito
                          </span>
                        </label>
                      </div>
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-20 resolucion_impugnada" id="">
                          <input name="resolucion_impugnada" type="radio" value="emitida_audiencia" onclick="resolucionImpugnada()">
                          <span class="pd-l-0">Emitida en audiencia
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-7">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Nombre de la resolución:</label>
                    <input class="form-control" type="text" name="nombre_resolucion" id="nombreResolucion">
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-5 resolucion_impugnada_escrito tipo_resolucion_impugnada">
                  <div class="form-group">
                    <label class="form-control-label">Fecha de la emisión: <span class="tx-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control fc-datepicker-A" placeholder="DD/MM/AAAA" id="fechaEmision"  name="fecha_emision" autocomplete="off" value="{{date('d-m-Y')}}">
                    </div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-lg-12 tipo_resolucion_impugnada resolucion_impugnada_audiencia d-none">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Fecha de la emisión</label>
                    <select class="form-control select2-show-search" id="fechaEmisionAudiencia" name="fecha_emision_audiencia" autocomplete="off" onchange="elejirJuez()">
                      
                    </select>
                  </div>
                </div>
                <div class="col-lg-7">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Juez que la emitió</label>
                    <select class="form-control select2-show-search" id="juezEmisor" name="juez_emisor" autocomplete="off" >
                      <option value="" selected disabled>Seleccione una opción</option>
                      @if ( $jueces['status'] == 100 )
                        @foreach ( $jueces['response'] as  $juez )
                          <option value="{{$juez['id_usuario']}}">{{$juez['nombres']}} {{$juez['apellido_paterno']}} {{$juez['apellido_materno']}} ({{$juez['cve_juez']}})</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="col-5" id="">
                  <div class="form-group" >
                    <label class="form-control-label d-block">¿Se expresarán agravios oralmente? <span class="tx-danger">*</span></label>
                    <div class="d-inline-block mg-l-10" id="">
                      {{-- 1.- Requerimiento de informe previo --}}
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-50 agravios_orales" id="">
                          <input name="agravios_orales" type="radio" value="1">
                          <span class="pd-l-0">Sí
                          </span>
                        </label>
                      </div>
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-50 agravios_orales" id="">
                          <input name="agravios_orales" type="radio" value="0">
                          <span class="pd-l-0">No
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-7">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">No. de oficio enviado a DEGJ:</label>
                    <input class="form-control" type="text" name="oficio_DEGJ" id="oficioDEGJ">
                  </div>
                </div><!-- col-3 -->
                <div class="col-12" id="">
                  <div class="form-group" >
                    <label class="form-control-label d-inline-block mg-t-10">El apelante señala domicilio diverso al registrado, para oír y recibir notificaciones ante el Tribunal de Alzada
                      <span class="tx-danger">*</span></label>
                    <div class="d-inline-block mg-l-10" id="">
                      {{-- 1.- Requerimiento de informe previo --}}
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-50 senala_domicilio" id="">
                          <input name="senala_domicilio" type="radio" value="1">
                          <span class="pd-l-0">Sí
                          </span>
                        </label>
                      </div>
                      <div class="d-inline-block">
                        <label class="rdiobox mg-l-50 senala_domicilio" id="">
                          <input name="senala_domicilio" type="radio" value="0">
                          <span class="pd-l-0">No
                          </span>
                        </label>
                      </div>
                    </div>
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
          <p class="mg-b-20 mg-x-20" id="successMessage"></p>
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
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close" onclick="abreModal('modalNuevaApelacion',400)">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  
@endsection