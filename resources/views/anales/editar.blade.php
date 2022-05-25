@php
    
    $arr_materias_sinc=array('PIC', 'PC', 'JCO', 'PIF', 'JFO', 'CJM', 'SC', 'PF', 'TDH');
    $arr_juzgados_sigj=array('41PIC','44PIC','52PIC','57PIC','60PIC','61PIC' ); 

@endphp
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
    <div class="row">
        <div class="col-lg-6 mg-t-20 mg-lg-t-0">
            <div class="card card-table">
                <div class="card-header">
                <h6 class="slim-card-title">Lista de Materias</h6>
                </div><!-- card-header -->
                <div class="table-responsive">
                <table class="table mg-b-0"> 
                    <thead> 
                    <tr class="tx-10">
                        <th class="w-50">Materia</th>
                        
                        <th class="w-25">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($lista_materias['response'] as $materia)
                        @if(in_array($materia['juzgado_subtipo_clave'], $arr_materias_sinc))
                    <tr>
                        <td>
                            <a href="javascript:void(0);" class="tx-inverse tx-14 tx-medium d-block">{{$materia['juzgado_subtipo_nombre']}}</a>
                        </td>
                        
                        <td>
                            <a href="javascript:void(0);" onclick="sincronizacionTotalBoletin('/anales/editar/sincronizacionTotalBoletin', '{{$materia['juzgado_subtipo_clave']}}', {{$lista_info_boletin["response"][0]["datos"]["id_boletin_registro"]}});" ><i class="icon ion-android-sync tx-success pd-r-5" style="font-size: 30px;"></i></a>
                            
                            
                            <a href="/anales/editar/{{$numero_boletin}}/{{$materia['juzgado_subtipo_clave']}}"><i class="icon ion-android-arrow-forward tx-success" style="font-size: 30px;"></i></a>
                        </td>
                    </tr>
                        @endif
                    @endforeach

                    <tr>
                        <td>
                            <a href="javascript:void(0);" class="tx-inverse tx-14 tx-medium d-block">CIVIL SICOR</a>
                        </td>
                        
                        <td>
                            <a href="javascript:void(0);" onclick="sincronizacionTotalBoletin('/anales/editar/sincronizacionTotalBoletin', 'PIC_SICOR', {{$lista_info_boletin["response"][0]["datos"]["id_boletin_registro"]}});" ><i class="icon ion-android-sync tx-success pd-r-5" style="font-size: 30px;"></i></a>
                            
                            
                            <a href="/anales/editar/{{$numero_boletin}}/PIC_SICOR"><i class="icon ion-android-arrow-forward tx-success" style="font-size: 30px;"></i></a>
                        </td>
                    </tr>

                    </tbody>
                </table>
                </div><!-- table-responsive -->
            </div><!-- card -->
        </div><!-- col-6 -->

        @isset($lista_submateria['response'])
        <div class="col-lg-6 mg-t-20 mg-lg-t-0">
            <div class="card card-table">
                <div class="card-header">
                <h6 class="slim-card-title">Lista de Juzgados</h6>
                </div><!-- card-header -->
                <div class="table-responsive">
                <table class="table mg-b-0">
                    <thead>
                        <tr class="tx-10">
                            <th class="w-50">Juzgado</th>
                            <th class="w-25">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($lista_submateria['response'] as $submateria)
                        @if(in_array($submateria['codigo'], $arr_juzgados_sigj))
                    <tr>
                        <td>
                            <div class="tx-inverse tx-14 tx-medium d-block">{{$submateria['nombre']}}</div>
                            <span class="tx-11 d-block">{{$submateria['nombre_corto']}}</span>
                        </td>
                        <td>
                            <a href="javascript:void(0);" onclick="sincronizarJuzgadoBoletin('{{$submateria['codigo']}}', '{{$submateria['subtipo']}}', '{{$submateria['nombre']}}');"><i class="icon ion-ios-cloud-download tx-success pd-r-5" style="font-size: 30px;"></i></a>
 
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo_editar_html" onclick="cargarJuzgadoBoletin('{{$submateria['codigo']}}');"><i class="icon ion-code-working tx-success pd-r-5" style="font-size: 30px;"></i></a>

                            <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo_html" onclick="verJuzgadoBoletin('{{$submateria['codigo']}}');"><i class="icon ion-android-list tx-success" style="font-size: 30px;"></i></a>

                        </td>
                    </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                </div><!-- table-responsive -->
            </div><!-- card -->
        </div><!-- col-6 -->
        @endisset
    </div>
      
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

    function sincronizarJuzgadoBoletin(juzgado, subtipo, nombre_largo){
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})
        $.ajax({
            type:'POST',
            url:'/anales/editar/sincronizarJuzgadoBoletin',
            data:{ id_boletin_registro:{{$lista_info_boletin["response"][0]["datos"]["id_boletin_registro"]}}, juzgado:juzgado, subtipo:subtipo, nombre_largo:nombre_largo, numero_boletin:'{{$numero_boletin}}', fecha_boletin:'{{$lista_info_boletin["response"][0]["datos"]["boletin_fecha_publicacion"]}}' },
            success:function(data){
                console.log(data);
                breakSesion(data);
                setTimeout(function(){
                    $('#modal_loading').modal('hide');
                },500);

                alert('Se sincronizó correctamente');
            }
        });
    }

    function cargarJuzgadoBoletin(juzgado){
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})
        $.ajax({
            type:'POST',
            url:'/anales/editar/cargarJuzgadoBoletin',
            data:{ id_boletin_registro:{{$lista_info_boletin["response"][0]["datos"]["id_boletin_registro"]}}, juzgado:juzgado },
            success:function(data){
                console.log(data);
                breakSesion(data);

                setTimeout(function(){
                    $('#modal_loading').modal('hide');

                    if(data.plantilla_archivo_body!=-1){
                        $('#modaldemo_editar_html').find('.modal-body').html(data.plantilla_archivo_body);
                        //$('#modaldemo_editar_html').find('.modal-header').html(data.plantilla_archivo_header);
                        $('#modaldemo_editar_html').modal({backdrop: 'static', keyboard: false})
                    }
                    else{
                        $('#modaldemo_editar_html').modal('hide');
                        alert('Debe de sincronizar primero la información');
                    }
                    
                }, 500);

            }
        });
    }


    function verJuzgadoBoletin(juzgado){
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})
        $.ajax({
            type:'POST',
            url:'/anales/editar/verJuzgadoBoletin',
            data:{ id_boletin_registro:{{$lista_info_boletin["response"][0]["datos"]["id_boletin_registro"]}}, juzgado:juzgado },
            success:function(data){
                console.log(data);
                breakSesion(data);

                setTimeout(function(){
                    $('#modal_loading').modal('hide');

                    if(data.plantilla_archivo_body!=-1){
                        $('#modaldemo_html').find('.modal-body').html(data.plantilla_archivo_body);
                        //$('#modaldemo_editar_html').find('.modal-header').html(data.plantilla_archivo_header);
                        $('#modaldemo_html').modal({backdrop: 'static', keyboard: false})
                    }
                    else{
                        $('#modaldemo_html').modal('hide');
                        alert('Debe de sincronizar primero la información');
                    }
                    
                }, 500); 

            }
        });
    }

    function sincronizacionTotalBoletin(path, materia, id_boletin_registro) {
        var form = $('<form></form>');

        form.attr("method", "post");
        form.attr("target", "_blank");
        form.attr("action", path);
        
        
        var field = $('<input></input>');
        field.attr("type", "hidden");
        field.attr("name", 'materia');
        field.attr("value", materia);
        form.append(field);


        var field = $('<input></input>');
        field.attr("type", "hidden");
        field.attr("name", 'id_boletin_registro');
        field.attr("value", id_boletin_registro);
        form.append(field);

        var field = $('<input></input>');
        field.attr("type", "hidden");
        field.attr("name", 'numero_boletin');
        field.attr("value", {{$numero_boletin}});
        form.append(field);

        // The form needs to be a part of the document in
        // order for us to be able to submit it.
        $(document.body).append(form);
        form.submit();
    }


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
                  <button class="btn btn-primary  btn-block mg-b-10" onclick="guardarJuzgadoBoletin();">Guardar</button>
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




<div id="modaldemo_html" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-lg modal-dialog-vertical-center modal-dialog-centered" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm" style="max-height:530px; overflow-y: auto;" >
        <div class="modal-header pd-x-20">
        </div>
        <div class="modal-body pd-20 boletin_body_anales" >
        </div><!-- modal-body -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->



@endsection