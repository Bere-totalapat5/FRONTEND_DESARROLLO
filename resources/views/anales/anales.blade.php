@extends('layouts.index_anales')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Boletín Judicial</li>
    </ol>
    <h6 class="slim-pagetitle">Boletín Judicial</h6> 
@endsection 

  
@section('contenido-principal') 

<div class="section-wrapper" >

    <div class="row">
        
          <div class="col-lg-6">
              <h3 class="card-profile-name">Boletín Judicial</h3>
          </div>
        <br><br>
    </div><!-- row -->
         
    <div class="alert alert-warning" role="alert">

        <strong>Se creará de forma automática el siguiente número de boletín.</strong>
        <br>

    </div><!-- alert -->

    <div class="table-wrapper" >
        <table id="datatable1" class="table display responsive nowrap">
            <thead>
            <tr>
                <th class="wd-15p">Folio</th>
                <th class="wd-15p">Fecha de publicación</th>
                <th class="wd-10p">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach($lista_boletin['response'] as $boletin)
                <tr>
                    <td>{{$boletin['datos']['boletin_numero']}}</td>
                    <td>{{$boletin['datos']['boletin_fecha_publicacion']}}</td>
                    <td>
                        <a href="/anales/editar/{{$boletin['datos']['boletin_numero']}}" >Editar acuerdos</a><br>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- table-wrapper -->
      
</div><!-- section-wrapper -->
<br><br><br>
@endsection

@section('seccion-estilos')
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">

    <style>
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

    </style>
@endsection

@section('seccion-scripts-libs')
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/moment/js/moment.js"></script>
    <script src="{{ $entorno["version_pages"]["version"] }}/lib/jquery-ui/js/jquery-ui.js"></script>
@endsection

@section('seccion-scripts-functions')
    <script>
        
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
        ordering: false,
        responsive: true,
        bLengthChange: false,
        searching: false,
        pageLength: 10,
        paging:   false,
        info:     false
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

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

        $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
        });
        $( ".fc-datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        setTimeout(function(){
        $('#modal_loading').modal('hide');
        }, 500);

      });
    </script>

@endsection

@section('seccion-modales')

<!-- EDITAR HTML -->
<div id="modaldemo_editar_html" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  >
  <div class="modal-dialog modal-lg modal-dialog-vertical-center modal-dialog-centered " role="document" style="max-width:1100px;" >
    <div class="modal-content tx-size-sm" >
      <div class="modal-header pd-x-20">
          
              <div class="col-lg-3">

              </div>
              <div class="col-lg-6">
                  <button class="btn btn-primary  btn-block mg-b-10" onclick="guardar_editor_HTML();">Guardar</button>
              </div>
              <div class="col-lg-3" style="text-align: right;">
                  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
          
      </div>
      <div class="modal-body pd-20" >


          



      </div><!-- modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->

@endsection