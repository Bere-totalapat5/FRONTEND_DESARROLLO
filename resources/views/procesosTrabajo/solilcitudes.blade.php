@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader-usuario')
{{$sesion['usuario_nombre']}}
@endsection

@section('contenido-pageheader-organo')
{{$sesion['juzgado_nombre_largo']}}
@endsection

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/bandejas/proximaPublicacion/">Próximas publicaciones</a></li>
        <li class="breadcrumb-item active" aria-current="page">Lista de publicaciones</li>
    </ol>
    <h6 class="slim-pagetitle">Lista de publicaciones</h6>
@endsection

@section('contenido-principal')

    <div class="section-wrapper">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="card-profile-name">Lista de publicaciones</h3>
                <p class="mg-b-20 mg-sm-b-20">Resoluciones turnadas desde el sistema de SASFam.</p>
            </div>
            <div class="col-lg-3">
              <div class="input-group">
                <div class="input-group-prepend">

                  <div class="input-group-text">
                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                  </div>
                </div>
                <input id="dp_listaPublicacion" type="text" class="form-control fc-datepicker" placeholder="YYYY/MM/DD" data-date-format="yyyy/mm/dd" readonly="readonly" value="{{$diaBoletin}}">
              </div>
            </div>
            <div class="col-lg-3">
              <button class="btn btn-primary " onclick="buscarPublicacion();">Buscar Publicación</button>
            </div>
            

            <div class="col-lg-12 mg-t-50">
                <div style="" class="boletin_body">
                {!! $boletin !!}
                </div>
            </div>


        </div>
    </div>
@endsection

@section('seccion-estilos')
    
@endsection

@section('seccion-scripts-libs')
   
@endsection

@section('seccion-scripts-functions')
  <script>
      setTimeout(function(){
          $('#modal_loading').modal('hide');
      }, 1000);

      //fechas
      $('.fc-datepicker').datepicker({
          language: 'es',
          showOtherMonths: true,
          selectOtherMonths: true
      });
      diasAsuetoListaNormal('dp_listaPublicacion', [@php for($i=0; $i<count($request->dias_inhabiles["response"]); $i++){ print("'".$request->dias_inhabiles["response"][$i]["dia_no_laboral_fecha"]."', ");   } @endphp]);
      $('.fc-datepicker').data('datepicker').selectDate(new Date({{$anio}}, {{$mes}}, {{$dia}}));

      function buscarPublicacion(){
        location="/boletin/listaPublicaciones/"+$('#dp_listaPublicacion').val();
      }

  </script>
@endsection

@section('seccion-modales')

<!-- LARGE MODAL -->
  <<div id="modaldemo3" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Message Preview</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <h5 class=" lh-3 mg-b-20"><a href="" class="tx-inverse hover-primary">Why We Use Electoral College, Not Popular Vote</a></h5>
          <p class="mg-b-5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. </p>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection