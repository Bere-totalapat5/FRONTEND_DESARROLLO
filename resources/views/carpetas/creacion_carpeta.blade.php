@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')
@section('contenido-pageheader')


    <ol class="breadcrumb slim-breadcrumb d-none d-md-flex">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Creación de carpeta judicial</li>
    </ol>
    <h6 class="slim-pagetitle" id="title_tareas">Creación de carpeta judicial</h6>

@endsection
{{-- {{dd($request->menu_general['response'])}} --}}
@section('contenido-principal')
  <div class="section-wrapper mg-b-100" id="pageone" data-role="page">
    @if( !utilidades::buscarPermisoMenu($request->menu_general['response'], 66) || Session::get('id_unidad_gestion') != 0 )
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
      <div class="form-layout mg-b-25" style="" >
        <form action="/" onsubmit="return false" id="formCarpeta">
          <div class="row mg-b-15">
            <div class="col-12">
              <div class="form-group">
                  <label class="form-control-label">Unidad:</label>
                  <select class="form-control select2-show-search" id="unidad" name="unidad" autocomplete="off" >
                    <option value="" selected disabled>Seleccione una opción</option>
                    @if(utilidades::obtener_acciones_vista($request,Session::get('usuario_id'),19))
                      @foreach ($ugas as $uga)
                        @if( in_array( $uga['id_unidad_gestion'], [20,35,36,37] ) )
                          <option value="{{$uga['id_unidad_gestion']}}">{{$uga['nombre_unidad']}}</option>
                        @endif
                      @endforeach
                    @else
                      <option value="{{Session::get('id_unidad_gestion')}}">{{Session::get('nombre_unidad')}}</option>
                    @endif
                  </select>
              </div>
            </div>                    
            <div class="col-12">
              <div class="form-group">
                <label class="form-control-label">Tipo de carpeta: </label>
                <select class="form-control select2-show-search" id="tipoCarpeta" name="tipo_carpeta" autocomplete="off">
                  {{-- @if(utilidades::obtener_acciones_vista($request,Session::get('usuario_id'),19))
                    <option value="1	">Carpeta de Control</option>
                    <option value="2	">Carpeta de Exhorto</option>
                    <option value="3	">Carpeta de Amparo</option>
                    <option value="4	">Carpeta de Apelación</option>
                    <option value="5	">Carpeta de Tribunal enjuiciamiento</option>
                    <option value="6	">Carpeta de Ejecución</option>
                    <option value="7	">Cuadernillos (Unidad Ejecución)</option>
                    <option value="8	">Carpeta Judicial de Alzada</option>
                    <option value="9	">Cuadernillo Ley Nacional</option>
                    <option value="10">	Carpeta de Ley Mujeres Libre de Violencia</option>
                  @else --}}
                    <option value="9">Cuadernillo Ley Nacional</option>
                  {{-- @endif --}}
                </select>
              </div>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-lg-12 d-flex">
            <button class="btn btn-primary mg-l-auto " onclick="generarCarpeta()">Crear carpeta</button>
          </div>
        </div>
      </div>
      
        
    @endif
  </div>
@endsection

@section('seccion-estilos')
<link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
<link rel="stylesheet" href="/js/clockpicker-gh-pages/src/clockpicker.css">
<link rel="stylesheet" href="/css/carpetas_judiciales/creacion_carpeta.css">
<link href="{{ $entorno["version_pages"]["version"] }}/lib/jt.timepicker/css/jquery.timepicker.css" rel="stylesheet">
@endsection

@section('seccion-scripts-libs')
<script src="/js/clockpicker-gh-pages/src/clockpicker.js"></script>  
<script src="../lib/jquery-ui/js/jquery-ui.js"></script>
<script src="/js/picker.js"></script>
<script src="/js/moment.js"></script>
<script src="/js/moment-with-locales.js"></script>
<script src="/js/carpetas/creacion_carpeta.js"></script>
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
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>
@endsection