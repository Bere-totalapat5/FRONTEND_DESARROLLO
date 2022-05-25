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
        <li class="breadcrumb-item">Procesos de trabajo</li>
        <li class="breadcrumb-item active" aria-current="page">Ministerio de Ley</li>
    </ol>
    <h6 class="slim-pagetitle">Ministerio de Ley</h6>
@endsection

@section('contenido-principal')
  
    <div class="section-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="card-profile-name">Ministerio de Ley</h3>
            </div>
            
            <div class="col-lg-12 mg-t-5">
              @if($id_ministerio==0)
              <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cambiarEstatusMinisterio({{$id_ministerio}});" style="float: right;">Agregar Ministerio de Ley</a>
              @endif
                <table id="datatable1" class="table display responsive nowrap">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de termino</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                    @isset($lista['response'][0]['fecha_inicio'])
                    @php $i=0; @endphp
                    
                    @foreach ($lista['response'] as $solicitud)

                        <tr id="data-row-id-{{$i}}">

                        <td>{{$solicitud['sustituto']['nombre']}}</td>
                        <td>
                            @php
                                $arr_fecha=explode(' ', $solicitud['fecha_inicio']);
                            @endphp
                            {{$arr_fecha[0]}}
                        </td>
                        <td>
                            @php
                                $arr_fecha=explode(' ', $solicitud['fecha_fin']);
                            @endphp
                            {{$arr_fecha[0]}}
                        </td>
                        <td>
                          @if ($solicitud['estatus_ministerio']==1)
                            Activo
                          @else
                            Desactivado
                          @endif
                        </td>
                        <td><a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cambiarEstatusMinisterio({{$id_ministerio}}, {{$solicitud['sustituto']['id_usuario']}}, {{$solicitud['estatus_ministerio']}});">Editar</a></td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                    @endisset


                </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('seccion-estilos')
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
@endsection

@section('seccion-scripts-libs')
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
@endsection

@section('seccion-scripts-functions')
  <script>
      setTimeout(function(){
          $('#modal_loading').modal('hide');
      }, 1000);

      var dataTableGlobal;

      $(function(){
        'use strict';

        dataTableGlobal=$('#datatable1').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });
      });


      function cambiarEstatusMinisterio(id_ministerio, id_usuario, estatus){

        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url: "{{ route('procesosTrabajo.cargar_ministerioLey_ajax') }}",
            data:{ id_ministerio:id_ministerio, id_usuario:id_usuario, estatus:estatus },
            success:function(data){
              $('#modal_loading').modal('hide');
              console.log(data);
              $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
              $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
        
      }

  </script>
@endsection

@section('seccion-modales')

<!-- LARGE MODAL -->
  <div id="modaldemo3" class="modal fade">
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