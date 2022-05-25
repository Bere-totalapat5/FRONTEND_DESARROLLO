@php
    use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Archivo Judicial</li>
    </ol>
    <h6 class="slim-pagetitle">Archivo Judicial</h6>
@endsection


@section('contenido-principal') 

<div class="section-wrapper" >

    <div class="row"> 
        
          <div class="col-lg-6">
              <h3 class="card-profile-name">Archivo Judicial</h3>
          </div>
      
        </div><!-- row -->
        

        <!--
      <div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true" style="margin-bottom:10px; width:100%;">
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
                        <div class="form-group">
                        <label class="form-control-label">Expediente:</label>
                        <table>
                                <tr>
                                    <td style="width:30%;"><input class="form-control" type="text" name="expediente" id="expediente" value="" placeholder="Número"></td>
                                    <td><center>/</center></td>
                                    <td style="width:30%;">
                                        <select class="form-control select2" data-placeholder="" id="anio_expediente" style="width:100%;">
                                            <option value="0" selected>Todos</option>
                                            @for($i=request()->entorno['variables_entorno']['ANIO_FIN']; $i>=request()->entorno['variables_entorno']['ANIO_INICIO']; $i--)
                                            <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>

                                    </td>
                                    <td style="width:35%;"></td>
                                </tr>
                            </table>


                        </div>
                    </div><!-- col-4 -- >
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-control-label">Nombre:</label>
                            <input class="form-control" type="text" name="involucrados_nombre" id="involucrados_nombre"  value="" placeholder="">
                        </div>
                    </div><!-- col-4 -- >
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-control-label">Apellido paterno: </label>
                            <input class="form-control" type="text" name="involucrados_apellido_paterno" id="involucrados_apellido_paterno" value="" placeholder="">
                        </div>
                    </div><!-- col-4 -- >
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-control-label">Apellido materno:</label>
                            <input class="form-control" type="text" name="involucrados_apellido_materno" id="involucrados_apellido_materno" value="" placeholder="">
                        </div>
                    </div><!-- col-4 -- >
                    <div class="col-lg-6">
                        <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Tipo acuerdo: <span class="tx-danger">*</span></label>
                        <select class="form-control select2" data-placeholder="" name="tipo_acuerdo" id="tipo_acuerdo" style="width:100%;">
                            <option value="-" selected>Todos</option>
                            <option value="Acuerdos">Acuerdos</option>
                            <option value="Sentencias">Sentencias</option>
                            <option value="Audiencias">Audiencias</option>
                        </select>
                        </div>
                    </div><!-- col-8 -- >
                    <div class="col-lg-6">
                        <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Origen acuerdo: <span class="tx-danger">*</span></label>
                        <select class="form-control select2" data-placeholder="" name="origen_acuerdo" id="origen_acuerdo" style="width:100%;">
                            <option value="-" selected>Todos</option>
                            <option value="Acuerdos">Secretaria de acuerdos</option>
                            <option value="Sentencias">Secretaria de amparos</option>
                            <option value="Audiencias">Secretaria de asuntos nuevos</option>
                            <option value="Audiencias">Ponencia 1</option>
                            <option value="Audiencias">Ponencia 2</option>
                            <option value="Audiencias">Ponencia 3</option>
                        </select>
                        </div>
                    </div><!-- col-8 -- >


                    <div class="col-lg-12">
                        <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Registro: <span class="tx-danger">*</span></label>
                        
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
                        <button class="btn btn-primary btn-sm btn-block mg-b-10" onclick="accionBuscar_ajax();">Buscar Resolución</button>
                    </div>
                    </div><!-- row -- >
                </div>
            </div>
        </div>
    </div>
</div>


-->
          
        
   

      @if($lista['status']==100)
        <div class="table-wrapper" >

        <div style="float: right;">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modaldemo3" onclick="confirmarListaExpedinetes();">Resumen expedientes seleccionados</a></a>
        </div>

        <table id="datatable1" class="table display responsive nowrap">
            <thead>
            <tr>
                <th class="wd-10p">Número</th>
                <th class="wd-25p">Partes</th>
                <th class="wd-15p">Tipo de juicio</th>
                <th class="wd-15p">Última<br>modificación</th>
                <th class="wd-10p">Acciones</th>
                <th><input name="select_all" value="1" type="checkbox"></th>
            </tr>
            </thead>
            
            <tbody>
              @php $i=0; @endphp
              
              @foreach ($lista['response'] as $archivo)
              <tr class="data-row-id-{{$i}}">
                <td>
                    

                    @isset($archivo['datos_juicio'][0]['expediente'])
                        {{$archivo['datos_juicio'][0]['expediente']}}
                    @endisset
                    /
                    @isset($archivo['datos_juicio'][0]['anio'])
                        {{$archivo['datos_juicio'][0]['anio']}}
                    @endisset

                    @if($archivo['datos_juicio'][0]['bis']!="")
                        Bis. {{$archivo['datos_juicio'][0]['bis']}}
                    @endif
                    <br>{{$archivo['datos_juicio'][0]['tipo_expediente']}}
                </td>
                <td>


                    @if(isset($archivo['partes']['actor']))
                        @php $bandera1=$bandera2=0; $actor=$demandado=$tercero="" @endphp
                        @for($j=0; $j<count($archivo['partes']['actor']); $j++)

                            
                
                            @if((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo['datos_juicio'][0]['id_catalogo_juicios'])) and $archivo['partes']['actor'][$j]['parte_promovente']==0 and $bandera1==0)
                            <strong>INTERESADOS</strong><br>
                            @php
                                $bandera1=1; 
                                $sello=0; 
                            @endphp
                
                          @elseif((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo['datos_juicio'][0]['id_catalogo_juicios'])) and $archivo['partes']['actor'][$j]['parte_promovente']==1 and $bandera2==0)
                            <strong>PROMOVENTE</strong><br>
                            @php
                                $bandera2=1;
                                $sello=0;
                            @endphp
                          @elseif($bandera1==0)
                            <strong>ACTOR</strong><br>
                            @php
                                $bandera1=1;
                            @endphp
                          @endif
                          @php 
                          if($j==0){
                              $actor.=$archivo['partes']['actor'][$j]['parte_nombres'].' '.$archivo['partes']['actor'][$j]['parte_apellido_paterno'].' '.$archivo['partes']['actor'][$j]['parte_apellido_materno'];
                          }
                          else{
                              $actor.=', '.$archivo['partes']['actor'][$j]['parte_nombres'].' '.$archivo['partes']['actor'][$j]['parte_apellido_paterno'].' '.$archivo['partes']['actor'][$j]['parte_apellido_materno']; 
                          }
                              
                              @endphp
                          <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$archivo['partes']['actor'][$j]['parte_nombres'].' '.$archivo['partes']['actor'][$j]['parte_apellido_paterno'].' '.$archivo['partes']['actor'][$j]['parte_apellido_materno']}}</div>
                        @endfor
                    @endif
                    

                    @if(isset($archivo['partes']['demandado']))
                        <strong>DEMANDADO</strong><br>
                        @for($j=0; $j<count($archivo['partes']['demandado']); $j++)
                            @php 
                            if($j==0){
                                $demandado.=$archivo['partes']['demandado'][$j]['parte_nombres'].' '.$archivo['partes']['demandado'][$j]['parte_apellido_paterno'].' '.$archivo['partes']['demandado'][$j]['parte_apellido_materno'];
                            }
                            else{
                                $demandado.=', '.$archivo['partes']['demandado'][$j]['parte_nombres'].' '.$archivo['partes']['demandado'][$j]['parte_apellido_paterno'].' '.$archivo['partes']['demandado'][$j]['parte_apellido_materno'].'<br>';
                            }
                            @endphp
                            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$archivo['partes']['demandado'][$j]['parte_nombres'].' '.$archivo['partes']['demandado'][$j]['parte_apellido_paterno'].' '.$archivo['partes']['demandado'][$j]['parte_apellido_materno']}}</div>
                        @endfor
                    @endif

                    @if(isset($archivo['partes']['tercero']))
                        <strong>TERCERO</strong><br>
                        @for($j=0; $j<count($archivo['partes']['tercero']); $j++)
                            @php 
                            if($j==0){
                                $tercero.=$archivo['partes']['tercero'][$j]['parte_nombres'].' '.$archivo['partes']['tercero'][$j]['parte_apellido_paterno'].' '.$archivo['partes']['tercero'][$j]['parte_apellido_materno'];
                            }
                            else{
                                $tercero.=', '.$archivo['partes']['tercero'][$j]['parte_nombres'].' '.$archivo['partes']['tercero'][$j]['parte_apellido_paterno'].' '.$archivo['partes']['tercero'][$j]['parte_apellido_materno'].'<br>';
                            }
                            @endphp
                            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$archivo['partes']['tercero'][$j]['parte_nombres'].' '.$archivo['partes']['tercero'][$j]['parte_apellido_paterno'].' '.$archivo['partes']['tercero'][$j]['parte_apellido_materno']}}</div>
                        @endfor
                    @endif

                </td>
                <td>
                    {{$archivo['datos_juicio'][0]['juicio']}}
                </td>
                <td>
                    @if($archivo['datos_juicio'][0]['juicio_modificacion']!="")
                      @php
                        $lista=explode(' ', $archivo['datos_juicio'][0]['juicio_modificacion']);
                        print($lista[0]);
                      @endphp
                    @else
                      -
                    @endif
                </td>
                <td>
                    <a href="/acuerdo_detalles/{{$archivo['datos_juicio'][0]['id_juicio']}}" >Ver expediente</a><br>

                    <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="archivoJudicial({{$archivo['datos_juicio'][0]['id_juicio']}});">Historial</a><br>

                    <a href="javascript:void(0);" onclick="eliminar_lista({{$archivo['id_archivo_judicial_lista']}}, {{$i}})" >Eliminar</a><br>
                    <input type="hidden" value="{{$archivo['datos_juicio'][0]['id_juicio']}}/**/{{$archivo['datos_juicio'][0]['expediente']}}/{{$archivo['datos_juicio'][0]['anio']}}/**/{{$actor}}/**/{{$demandado}}/**/{{$archivo['datos_juicio'][0]['juicio']}}/**/{{$archivo['num_fojas']}}" id="data_imprimir_{{$i}}">
                </td>
                <td></td>
                </tr>
                
                
                @php $i++; @endphp
              @endforeach
             
            
            </tbody>
        </table>
        </div><!-- table-wrapper -->
      @else
        <center><br><br><h3>No hay expedientes en la lista</h3></center>
      @endif
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

        .romperCadena{
            word-wrap: break-word !important;
            white-space:normal !important;
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
        var rows_selected = [];
        var table;
        var i_global = -1;
        dataTableGlobal = table = $('#datatable1').DataTable( {
            "ordering": false,
            'columnDefs': [
                { responsivePriority: 1, targets: 5 },  
                { "targets": [0],  "orderable": false, "visible": true },
                { "targets": [1],  "orderable": false, "visible": true, "class":"romperCadena" },
                { "targets": [2],  "orderable": false, "visible": true, "class":"romperCadena" },
                { "targets": [3],  "orderable": false, "visible": true },
                { "targets": [4],  "orderable": false, "visible": true },
                {
                'targets': 5,
                'searchable': false,
                'orderable': false,
                'width': '1%',
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    i_global++;
                            return '<input type="checkbox" id="chbox_'+i_global+'" class="chbox_imprimir" value="'+i_global+'">';
                            
                }
            }],
            bLengthChange: false,
            searching: false,
            responsive: true,
            pageLength: 5,
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
            
            // Handle click on checkbox
        $('#datatable1 tbody').on('click', 'input[type="checkbox"]', function(e){
            var $row = $(this).closest('tr');

            // Get row data
            var data = table.row($row).data();

            // Get row ID
            var rowId = data[0];

            // Determine whether row ID is in the list of selected row IDs
            var index = $.inArray(rowId, rows_selected);

            // If checkbox is checked and row ID is not in list of selected row IDs
            if(this.checked && index === -1){
                rows_selected.push(rowId);

            // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
            } else if (!this.checked && index !== -1){
                rows_selected.splice(index, 1);
            }

            if(this.checked){
                $row.addClass('selected');
            } else {
                $row.removeClass('selected');
            }

            // Update state of "Select all" control
            updateDataTableSelectAllCtrl(table);

            // Prevent click event from propagating to parent
            e.stopPropagation();
        });

        /*
        // Handle click on table cells with checkboxes
        $('#datatable1').on('click', 'tbody td, thead th:first-child', function(e){
            $(this).parent().find('input[type="checkbox"]').trigger('click');
        });
        */
        // Handle click on "Select all" control
        $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
            if(this.checked){
            $('#datatable1 tbody input[type="checkbox"]:not(:checked)').trigger('click');
            } else {
            $('#datatable1 tbody input[type="checkbox"]:checked').trigger('click');
            }

            // Prevent click event from propagating to parent
            e.stopPropagation();
        });

        // Handle table draw event
        table.on('draw', function(){
            // Update state of "Select all" control
            updateDataTableSelectAllCtrl(table);
        });

        function updateDataTableSelectAllCtrl(table){
            var $table             = table.table().node();
            var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
            var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
            var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

            // If none of the checkboxes are checked
            if($chkbox_checked.length === 0){
                chkbox_select_all.checked = false;
                if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
                }

            // If all of the checkboxes are checked
            } else if ($chkbox_checked.length === $chkbox_all.length){
                chkbox_select_all.checked = true;
                if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
                }

            // If some of the checkboxes are checked
            } else {
                chkbox_select_all.checked = true;
                if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = true;
                }
            }
        }


            
       

        'use strict';

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


        function archivoJudicial(id){
            $('#modaldemo3').find('.modal-header').html('');
            $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
            $.ajax({
                type:'POST',
                url:'/archivoJudicial/detalles_archivo',
                data:{ id_juicio:id, agregar:0 },
                success:function(data){
                    $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                    $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
                }
            });
        }


        function eliminar_lista(id, index){
            if(confirm('¿Esta seguro de eliminar el expediente de la lista?')){
                $.ajax({
                    type:'POST',
                    url:'/archivoJudicial/eliminar_lista',
                    data:{ id_archivo_judicial_lista:id  },
                    success:function(data){
                        dataTableGlobal.rows(index).remove().draw();
                    }
                });
            }
        }

        function confirmarListaExpedinetes(){
            $('#modaldemo3').find('.modal-header').html('');
            $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
            
            
            arr_imprimir="";
            $( ".chbox_imprimir" ).each(function( index ) {
                if($(this).is(':checked')) {
                    arr_imprimir+=$('#data_imprimir_'+$(this).val()).val()+'----';
                }
            });

            $.ajax({
                type:'POST',
                url:'/archivoJudicial/confirmar_lista_expedientes',
                data:{ arr_imprimir:arr_imprimir },
                success:function(data){
                    $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                    $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
                    setTimeout(function(){
                        //alert('vas');
                        //$('.select2').select2({
                        //    minimumResultsForSearch: Infinity
                        //});
                    }, 1000);
                    
                }
            });
        }

 
        function refreshPage(){
            
            location.reload(true);
        }

         


    </script>

@endsection

@section('seccion-modales')

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