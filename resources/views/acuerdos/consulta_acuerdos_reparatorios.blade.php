@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

{{-- Header --}}
@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0);">Reportes</a></li>
     <li class="breadcrumb-item"><a href="javascript:void(0);"> Consulta Reportes</a></li>
  </ol>
  <h6 class="slim-pagetitle">  Consulta Reportes</h6>
@endsection
{{-- Estilos --}}
@section('seccion-estilos')
    <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <style>
      
    </style>
@endsection

{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="section-wrapper" style="max-width: 100%;">
      @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 49, 0))
        <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
        <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
      @else
        <div class="form-layout" style="position: relative;">


        </div>
      @endif
    </div>

@endsection


{{-- Scripts librerias --}}
@section('seccion-scripts-libs')
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
     <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
     <script src="https://cdn.datatables.net/colreorder/1.5.3/js/dataTables.colReorder.min.js"></script>
@endsection

{{-- Scripts --}}
@section('seccion-scripts-functions')
  <script>
    const unidades_precargadas = @php echo json_encode($unidades);@endphp;
    const jueces_precargados = @php echo json_encode($jueces);@endphp;
    const inmuebles_precargados = @php echo json_encode($inmuebles);@endphp;
    var id_unidad_sesion = @php echo json_encode($request->session()->get('id_unidad_gestion')); @endphp;


    $(function(){
        //select
        $('.selectable').select2();
        
        //Loader
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 1000);

        console.log('jueces', jueces_precargados);
        console.log('unidades', unidades_precargadas);
        console.log('inmuebles', inmuebles_precargados);  
    });


    function descargarReporte(reporte){
      var validar = revisar_campos(reporte);
      console.log('estatus', validar );
      if(validar.status == 100){

        var inicio = $('#fecha_inicio').val();
        var final =  $('#fecha_final').val();
        var select_unidad = '';
        var select_juez = '';
        var select_carpeta = '';
        var select_inmueble = '';

        if(reporte == 'delitos'){ inicio = inicio +' 00:00:00' ; final = final +' 23:59:59';}
        if(reporte == 'resolutivos_por_audiencia'){ select_unidad = $('#unidadSeleccionada').val();}
        if(reporte == 'desempeno_juez'){ select_juez = $('#juez_seleccionado').val(); }
        if(reporte == 'cj_recibidas'){ 
          select_unidad = $('#unidadSeleccionada').val();
          select_carpeta = $('#tipo_carpeta').val();
        }
        if(reporte == 'audiencias'){ select_inmueble = $('#inmuebleSelecc').val(); }
        
        
        
        $.ajax({
          type:'POST',
          url: reporte_config[reporte].ruta,
          data:{
            fecha_inicio: inicio,
            fecha_final:final,
            id_inmueble: select_inmueble,
            id_unidad: select_unidad,
            id_juez: select_juez,
            tipo_carpeta: select_carpeta
          },beforeSend: function(){
            $('.btnDescargar').html('Consultando...');
            $('.btnDescargar').prop('disabled', true);
            loading(true);
          },
          success:function(response) {
            console.log(response);
            if(response.status==100){
              $('.btnDescargar').html('Consultar');
              $('.btnDescargar').prop('disabled', false);
              window.open(response.response);
              loading(false);
              elegirReporte(reporte);
            }else{
              error(response.message);
              $('.btnDescargar').html('Consultar');
              loading(false);
            }
          }
        }); 
        
      }else{
        $(`${validar.campo}`).addClass('is-invalid');
        error(validar.mensaje);
      }
    }

    // ########## FUNCIONES GENERALES  ##############

    function get_date( date , format = 'YYYY-MM-DD' ){
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('-') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('-') )
        return date.split('-').reverse().join('-');
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('/') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('/') )
        return date.split('-').reverse().join('-');
      else
        return date;
    }

    function success(mensaje){
      $('#messageExito').html(mensaje);
      $('#modalSuccess').modal('show');
    }

    function error(mensaje){
      $('#messageError2').html(mensaje);
      $('#modalError2').modal('show');
    }

    function modal_error(mensaje,modalAnterior=null){
      $('#messageError').html(`${mensaje}`);
      $('#btnCerrarError').attr('data-modal',modalAnterior!=null?modalAnterior:'');
      if( modalAnterior!=null ) $('#'+modalAnterior).modal('hide');
      $('#modalError').modal('show');
    }

    function loader(accion){
      if(accion){
        $('#loader').modal('show');
      }else{
        setTimeout(function(){ $('#loader').modal('hide'); }, 500);
      }
    }

    function loading(accion){
      if(accion){
        $('#modal_loading').modal('show');
      }else{
        setTimeout(function(){ $('#modal_loading').modal('hide'); }, 500);
      }
    }

    function cerrar_modal(valor){
      $("#"+valor).modal('hide');
    }


  </script>
@endsection


@section('seccion-modales')

  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
          <div id="messageExito">
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="modalError" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25 cerrar-modal" data-modal="" data-thismodal="modalError" id="btnCerrarError">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalError2" class="modal fade" data-backdrop="static" data-keyboard="false" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError2"></p>
          <button type="button" class="btn btn-danger pd-x-25"  data-dismiss="modal" id="btnCerrarError">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

  <div id="modalWarning" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <i class="icon ion-warning-outline tx-100 tx-warning lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-warning tx-semibold mg-b-20">Advertencia!</h4>
          <div>
            Hay Campos vacios
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" >Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

  <div id="loader" class="modal fade"  data-backdrop="static" data-keyboard="false" style="display: none">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20" style="background: rgba(0,0,0,0.7);">
          <h5 style="color:#fff;">Consultando Reporte</h5>
          <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div>

@endsection

