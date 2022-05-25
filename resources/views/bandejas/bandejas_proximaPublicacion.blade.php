@php
    use App\Http\Controllers\clases\humanRelativeDate;
    use App\Http\Controllers\clases\utilidades;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Bandeja</li>
        <li class="breadcrumb-item active" aria-current="page">Próxima publicación</li>
    </ol>
    <h6 class="slim-pagetitle">Bandeja Próxima Publicación</h6>
@endsection


@section('contenido-principal')
            
        <div class="section-wrapper">
            <div class="row">
                <div class="col-lg-11">
                    @php
                    
                        $fecha_arr=explode('-', $request->proxima_publicacion['response_dh']);
                        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                        $fecha_desktop=$fecha_arr[2] . ' de ' .$meses[$fecha_arr[1]-1] .' de ' . $fecha_arr[0];
                        
                    @endphp
                    <h3 class="card-profile-name">Lista de publicación del dia {{$fecha_desktop}}</h3>
                </div>
                <div class="col-lg-1">
                    <!--        
                    <div class="form-group mg-b-10-force filtro_tocas_turnados" >
                        <label class="ckbox" style="width: 150px;">
                            <input type="checkbox" name="bandera_toca_turnado" value="1" onclick="accionBuscarArchivo_ajax();"><span>Tocas turnados</span>
                        </label>
                    </div>
                    -->
                </div>
            </div>
            

            <div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true" style="margin-bottom:10px;">
                <div class="card">
                  <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                      Busqueda Avanzada
                    </a>
                  </div><!-- card-header -->
    
                  <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                     
                        <div class="form-layout">
                            <div class="row mg-b-0">
                                
                                <div class="col-lg-12">
                                <div class="form-group mg-b-10-force">
                                <label class="form-control-label">{{$request->lang['Toca']}}:</label>
                                <table>
                                        <tr>
                                            <td style="width:30%;"><input class="form-control" type="text" name="toca" id="toca" value="" placeholder="Número"></td>
                                            <td><center>/</center></td>
                                            <td style="width:30%;">
                                                <select class="form-control select2" data-placeholder="" id="anio_toca" style="width:100%;">
                                                    <option value="0" selected>Todos</option>
                                                    @for($i=request()->entorno['variables_entorno']['ANIO_FIN']; $i>=request()->entorno['variables_entorno']['ANIO_INICIO']; $i--)
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                </select>

                                            </td>
                                            <td><center>{{$request->lang['/']}}</center></td>
                                            <td style="width:30%;"><input class="form-control" type="text" name="asunto_toca" id="asunto_toca" value="" placeholder="{{$request->lang['Asunto']}}"></td>
                                        </tr>
                                    </table>


                                
                                </div>
                            </div><!-- col-4 -->
                            

                            
                            <div class="col-lg-12">
                                <button class="btn btn-primary btn-sm btn-block mg-b-10" onclick="accionBuscar_ajax();">Buscar Publicación</button>
                            </div>
                            </div><!-- row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <a href="javascript:void(0)" onclick="imprimirSeleccion(0);">Imprimir selección</a>   |    <a href="javascript:void(0)" onclick="imprimirTodo();">Imprimir todo</a>
            <table id="datatable1" class="table display responsive wrap" style="width: 100%; max-width: 850px;">
                <thead>
                <tr> 
                    <th class="wd-10p">Fecha de <br>publicación</th>
                    <th class="wd-15p">{{$request->lang['Toca']}}/<br>Estado</th>
                    <th class="wd-5p">{{$request->lang['Ponencia']}}</th>
                    <th class="wd-25p">Partes</th>
                    <th class="wd-10p">Acciones</th>
                    <th><input name="select_all" value="1" type="checkbox"></th>
                </tr>
                </thead>
                <tbody>
                @isset($lista['response'][0]["id_acuerdo"])
                    
                    @php $i=0; @endphp
                    @foreach ($lista['response'] as $resolucion)
                    <tr class="data-row-id-{{$i}}">
                        <td>
                            <input type="hidden" value="{{$resolucion['id_acuerdo']}},{{$resolucion['id_organo']}},{{$resolucion['ultima_version']}}" id="data_imprimir_{{$i}}">
                            @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($resolucion["fecha_publicacion"]); $fecha_arr=explode(" ", $resolucion["fecha_publicacion"]); print($fecha_arr[0].'<br>'.$fechaCreacion); @endphp
                        </td>
                        <td>
                            @isset($resolucion["acuerdo"]) {{$resolucion["acuerdo"]}}<br> @endisset
                            @isset($resolucion["tipo_archivo"]) {{utilidades::acomodarTipoExpedienteTxt($resolucion["tipo_archivo"])}} @endisset
                        </td>
                        <td> 
                            @if($resolucion["ponencia"]!="P ")
                                @if($request->session()->get('juzgado_tipo')=='juzgado')
                                    @php $ponencia=explode(' ', $resolucion["ponencia"]); @endphp
                                    {{$ponencia[1]}}
                                @else
                                    {{$resolucion["ponencia"]}}
                                @endif
                            @else 
                                -
                            @endif
                        </td>
                        <td class="romperCadena">
                            @isset($resolucion["involucrados"]) 

                                @isset($resolucion['involucrados']['actor'])
                                    <strong>ACTOR</strong><br>
                                    @foreach ($resolucion['involucrados']["actor"] as $parte)
                                        <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['parte_nombres']}} {{$parte['parte_apellido_paterno']}} {{$parte['parte_apellido_materno']}}</div>
                                    @endforeach
                                @endisset

                                @if(isset($resolucion['involucrados']['demandado']) and trim($resolucion['involucrados']['demandado'][0]['parte_nombres'])!="")
                                    <strong >DEMANDADO</strong><br>
                                    @foreach ($resolucion['involucrados']["demandado"] as $parte)
                                        <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['parte_nombres']}} {{$parte['parte_apellido_paterno']}} {{$parte['parte_apellido_materno']}}</div>
                                    @endforeach
                                @endif

                                @if(isset($resolucion['involucrados']['tercero']) and trim($resolucion['involucrados']['tercero'][0]['parte_nombres'])!="")
                                    <strong>TERCERO</strong><br>
                                    @foreach ($resolucion['involucrados']["tercero"] as $parte)
                                        <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['parte_nombres']}} {{$parte['parte_apellido_paterno']}} {{$parte['parte_apellido_materno']}}</div>
                                    @endforeach
                                @endif
                            @endisset
                        </td>
                    
                        <td>
                            <a href="javascript:void(0);" onclick="vistaPrevia({{$resolucion['id_acuerdo']}}, '{{$resolucion['id_organo']}}', {{$resolucion['ultima_version']}}, 'pdf');"><strong>Vista previa</strong></a>
                            
                            @if($sesion['id_tipo_usuario']=='1' or $sesion['id_tipo_usuario']=='4' or $sesion['id_tipo_usuario']=='5' or $sesion['id_tipo_usuario']=='6' or $lista_acciones['response'][7]['valor']==1)
                                <br><a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="programarNotificacion({{$resolucion['id_juicio']}}, {{$resolucion['id_acuerdo']}}, {{$i}});">Enviar a notificación</a>
                            @endif

                            @if($sesion['id_tipo_usuario']=='1' or $sesion['id_tipo_usuario']=='4' or $sesion['id_tipo_usuario']=='5' or $sesion['id_tipo_usuario']=='6')
                                
                                @php
                                    $fecha_actual = strtotime(date($request->proxima_publicacion['response_dh'] . " H:i:00",time()));
                                    $fecha_entrada = strtotime($request->proxima_publicacion['response_dh']." ". $sesion['horario_cierre']);
                                @endphp
                                @if($fecha_actual < $fecha_entrada)
                                    <br><a href="javascript:void(0);" onclick="cancelarResolucion({{$resolucion['id_acuerdo']}}, {{$resolucion['id_juicio']}}, '{{$resolucion['id_organo']}}', {{$i}});">Cancelar publicación</a>  
                                @endif 

                                <!--
                                <br><a href="javascript:void(0);" onclick="cancelarResolucion({{$resolucion['id_acuerdo']}}, {{$i}});">Cancelar publicación</a>
                                @if($resolucion['propietario']==$sesion['usuario_id'])
                                    <br><a href="javascript:void(0);" onclick="eliminarAcuerdo({{$resolucion['id_acuerdo']}}, {{$i}});">Eliminar acuerdo</a>
                                @endif
                                -->

                                @if ($request->session()->get('juzgado_tipo')=="sala")
                                    <br><a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="actualizarAcuerdo({{$resolucion['id_juicio']}}, {{$resolucion['id_acuerdo']}}, '{{$resolucion['acuerdo']}}');">Actualizar acuerdo</a>
                                @endif
                                
                            @endif
                        </td>
                        <td></td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                @endisset
                
                </tbody>
            </table>
            </div><!-- table-wrapper -->
        </div><!-- section-wrapper -->
        <br><br>
@endsection

@section('seccion-estilos')
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    <style>
        @media screen and (max-width: 600px) {
            .filtro_tocas_turnados{
                float: left !important;
            }
        }
        .filtro_tocas_turnados{
            float: right;
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

    function actualizarAcuerdo(juicio_id, acuerdo_id, acuerdo_texto){

        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/bandejas/formularioAcuerdoInfoAjax',
            data:{ juicio_id:juicio_id, acuerdo_id:acuerdo_id, acuerdo_texto,acuerdo_texto },
            success:function(data){
                console.log(data);
                $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
    }


    function programarNotificacion(juicio_id, acuerdo_id, i){
        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/bandejas/formularioAcuerdoNotificacionAjax',
            data:{ juicio_id:juicio_id, acuerdo_id:acuerdo_id  },
            success:function(data){
                console.log(data);
                $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html('<h5 class="card-profile-name">Valida la información de las partes</h5> <p class="card-profile-position actores_lista"></p><hr>'+data.plantilla_archivo_body);

                $.ajax({
                    type:'POST',
                    url:'/consultaPartesNotificacion', 
                    data:{ id:juicio_id },
                    success:function(data){
                        
                        $('.actores_lista').html(data.plantilla_archivo_body);
                    }
                });
            }
        });
    }


    function eliminarAcuerdo(id_acuerdo, index){

        if(confirm('¿Esta seguro de elminar el acuerdo?')){
            $('#modal_loading').modal({backdrop: 'static', keyboard: false})
            $.ajax({
                type:'POST',
                url: "{{ route('acuerdo_detalles.eliminarAcuerdo_ajax') }}",
                data:{ id_acuerdo:id_acuerdo},
                success:function(data){
                    console.log(data);
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if(data.status==0){
                        alert(data.message);
                    }
                    else{
                        //$('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);
                        //$('#datatable1').find('.data-row-id-'+index).fadeOut('slow', function($row){
                            dataTableGlobal.rows($('#datatable1').find('.data-row-id-'+index)).remove().draw();
                        //});
                    } 
                }
            });
        }
    }

    function cancelarResolucion(id_acuerdo, id_juicio, codigo_organo, index){
    //function cancelarResolucion(id_acuerdo, index){

        if(confirm('¿Esta seguro de cancelar la publicación?')){
            $('#modal_loading').modal({backdrop: 'static', keyboard: false})
            $.ajax({
                type:'POST',
                url: "{{ route('acuerdo_detalles.cancelarFechaPublicacion_ajax') }}",
                data:{ id_acuerdo:id_acuerdo, id_juicio:id_juicio, codigo_organo:codigo_organo},
                success:function(data){
                    console.log(data);
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if(data.status==0){
                        alert(data.message);
                    }
                    else{
                        //$('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);
                        //$('#datatable1').find('.data-row-id-'+index).fadeOut('slow', function($row){
                            dataTableGlobal.rows($('#datatable1').find('.data-row-id-'+index)).remove().draw();
                        //});
                    }
                }
            });
        }
    }


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

    $(document).ready(function() {
        var rows_selected = [];
        var table ;
        var i=-1;
        dataTableGlobal = table = $('#datatable1').DataTable( {
            "ordering": false,
            'columnDefs': [
            { responsivePriority: 1, targets: 5 },  
            { "targets": [0],  "orderable": false, "visible": true },
            { "targets": [1],  "orderable": false, "visible": true },
            { "targets": [2],  "orderable": false, "visible": true },
            { "targets": [3],  "orderable": false, "visible": true, 'className': 'romperCadena' },
            { "targets": [4],  "orderable": false, "visible": true },
            {
            'targets': 5,
            'searchable': false,
            'orderable': false,
            'width': '1%',
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                i++;
                return '<input type="checkbox" id="chbox_'+meta.row+'" class="chbox_imprimir" value="'+meta.row+'">';
            }
        }],
        bLengthChange: false,
        searching: false,
        responsive: true,
        pageLength: 10,

        'rowCallback': function(row, data, dataIndex){
            // Get row ID
            var rowId = data[0];

            // If row ID is in the list of selected row IDs
            if($.inArray(rowId, rows_selected) !== -1){
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');
            }
        }
        } );
            
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
    } );


    var dataTableGlobal;

    $(function(){
        'use strict';
        /*
        //datatable
        dataTableGlobal=$('#datatable1').DataTable({
            responsive: true,
            bLengthChange: false,
            language: {
                searchPlaceholder: 'Filtrar...',
                sSearch: '',
                lengthMenu: '_MENU_ Registros'
            }
        });
        */

        //focus textfiled
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

        //fechas
        $('.fc-datepicker').datepicker({
            language: 'es',
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "yyyy-mm-dd",
            minDate: new Date() 
        });
        $( ".fc-datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 500);
    });
    
    //busqueda de tocas
    function accionBuscar_ajax(){
        
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})
 
        var toca = ($("input[name=toca]").val()=="") ? "-" : $("input[name=toca]").val();
        var anio_toca = $("#anio_toca option:selected").val()
        var asunto_toca = ($("input[name=asunto_toca]").val()=="") ? "-" : $("input[name=asunto_toca]").val();

        var fecha_desde = ($("input[name=fecha_desde]").val()=="") ? "-" : $("input[name=fecha_desde]").val();
        var fecha_hasta = ($("input[name=fecha_hasta]").val()=="") ? "-" : $("input[name=fecha_hasta]").val();

        $.ajax({
            type:'POST',
            url:'/bandejas/proximaPublicacion/buscar/',
            data:{toca:toca, anio_toca:anio_toca, asunto_toca:asunto_toca, fecha_desde:"", fecha_hasta:"" },
            success:function(data){
                console.log(data);
                dataTableGlobal.clear().draw();
                setTimeout(function(){
                    $('#modal_loading').modal('hide');
                }, 500);
                if(data.status==100){
                    

                    for(var i=0; i<data.response.length; i++){
                        
                        var ponencia = "";
                        if(data.response[i].ponencia!='P '){
                            if('{{$request->session()->get('juzgado_tipo')}}'=='sala'){
                                ponencia=data.response[i].ponencia;
                            }
                            else{
                                ponencia=data.response[i].ponencia.replace('P ', '')
                            }
                            
                        }

                        var partes="";
                        if(data.response[i].involucrados.actor!=null){
                            for(var j=0; j<data.response[i].involucrados.actor.length; j++){
                                if(data.response[i].involucrados.actor!=null){
                                    if(j==0){
                                        partes+="<strong>ACTOR</strong><br>";
                                    }

                                    if(data.response[i].involucrados.actor[j]['parte_apellido_paterno']==null) data.response[i].involucrados.actor[j]['parte_apellido_paterno']="";
                                    if(data.response[i].involucrados.actor[j]['parte_apellido_materno']==null) data.response[i].involucrados.actor[j]['parte_apellido_materno']="";
                                    
                                    partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].involucrados.actor[j]['parte_nombres']+' '+data.response[i].involucrados.actor[j]['parte_apellido_paterno']+' '+data.response[i].involucrados.actor[j]['parte_apellido_materno']+'</div>';
                                }
                            }
                        }
                        if(data.response[i].involucrados.demandado!=null && data.response[i].involucrados.demandado[0]['parte_nombres']!=""){
                            for(var j=0; j<data.response[i].involucrados.demandado.length; j++){                            
                                if(j==0){
                                    partes+="<strong>DEMANDADO</strong><br>";
                                }

                                if(data.response[i].involucrados.demandado[j]['parte_apellido_paterno']==null) data.response[i].involucrados.demandado[j]['parte_apellido_paterno']="";
                                if(data.response[i].involucrados.demandado[j]['parte_apellido_materno']==null) data.response[i].involucrados.demandado[j]['parte_apellido_materno']="";

                                partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].involucrados.demandado[j]['parte_nombres']+' '+data.response[i].involucrados.demandado[j]['parte_apellido_paterno']+' '+data.response[i].involucrados.demandado[j]['parte_apellido_materno']+'</div>';
                            }
                        }
                        if(data.response[i].involucrados.tercero!=null && data.response[i].involucrados.tercero[0]['parte_nombres']!=""){
                            for(var j=0; j<data.response[i].involucrados.tercero.length; j++){
                            
                                if(j==0){
                                    partes+="<strong>TERCERO</strong><br>";
                                }

                                if(data.response[i].involucrados.tercero[j]['parte_apellido_paterno']==null) data.response[i].involucrados.tercero[j]['parte_apellido_paterno']="";
                                if(data.response[i].involucrados.tercero[j]['parte_apellido_materno']==null) data.response[i].involucrados.tercero[j]['parte_apellido_materno']="";

                                partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].involucrados.tercero[j]['parte_nombres']+' '+data.response[i].involucrados.tercero[j]['parte_apellido_paterno']+' '+data.response[i].involucrados.tercero[j]['parte_apellido_materno']+'</div>';
                            }
                        }


                        


                        var fecha_arr=data.response[i].fecha_publicacion.split(" ");

                        var fecha=fecha_arr[0]+'<br>'+data.response[i].fecha_humana+'<input type="hidden" value="'+data.response[i].id_acuerdo+','+data.response[i].id_organo+','+data.response[i].ultima_version+'" id="data_imprimir_'+i+'">';
                        var acciones = '<a href="javascript:void(0);" onclick="vistaPrevia('+data.response[i].id_acuerdo+', \''+data.response[i].id_organo+'\', '+data.response[i].ultima_version+', \'pdf\');"><strong>Vista previa</strong></a>';


                        @if($sesion['id_tipo_usuario']=='1' or $sesion['id_tipo_usuario']=='4' or $sesion['id_tipo_usuario']=='5' or $sesion['id_tipo_usuario']=='6' or $lista_acciones['response'][7]['valor']==1)
                            acciones += '<br><a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="programarNotificacion('+data.response[i].id_juicio+', '+data.response[i].id_acuerdo+', '+i+');">Enviar a notificación</a>';
                        @endif

                        //acciones += '<br><a href="javascript:void(0);" onclick="cancelarResolucion('+data.response[i].id_acuerdo+', '+i+');">Cancelar publicación</a>';
                        


                        @if($sesion['id_tipo_usuario']=='1' or $sesion['id_tipo_usuario']=='4' or $sesion['id_tipo_usuario']=='5' or $sesion['id_tipo_usuario']=='6' )


                            fecha2='@php print($request->proxima_publicacion['response_dh']."T");  @endphp'+moment().format('HH:mm')+':00Z';
                            fecha1=fecha_arr[0]+'@php print("T".$sesion['horario_cierre']."Z"); @endphp';
                            if(comprarFechasMomento(fecha1, fecha2)){
                                acciones += '<br><a href="javascript:void(0);" onclick="cancelarResolucion('+data.response[i].id_acuerdo+', '+data.response[i].id_juicio+', \''+data.response[i].id_organo+'\', '+i+');">Cancelar publicación</a>';
                            }
                            
                            acciones1 = '<br><a href="javascript:void(0);" onclick="eliminarAcuerdo('+data.response[i].id_acuerdo+', '+i+');">Eliminar acuerdo</a>';
                            
                            @if ($request->session()->get('juzgado_tipo')=="sala")
                                acciones += '<br><a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="actualizarAcuerdo('+data.response[i].id_juicio+', '+data.response[i].id_acuerdo+', \''+data.response[i].acuerdo+'\');">Actualizar acuerdo</a>';
                            @endif
                        @endif


                        dataTableGlobal.row.add( [ 
                            fecha,
                            data.response[i].acuerdo+'<br>'+acomodarTipoExpedienteTxt(data.response[i].tipo_archivo),
                            ponencia,
                            partes,
                            acciones
                        ] ).draw(false).nodes().to$().addClass( 'data-row-id-'+i );

                        $(".format_human_js").timeago();
                    }
                }
            }
        });
    }
    
    function cargarFlujo(id_acuerdo, acuerdo_texto){
        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/acuerdo_flujo_detalles',
            data:{ id_acuerdo:id_acuerdo, acuerdo_texto,acuerdo_texto },
            success:function(data){
                $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
    }

    function vistaPrevia(id_acuerdo, ponencia, id_documento, tipo_documento){
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})
        $.ajax({
            type:'POST',
            url: "{{ route('bandeja.documento_descargar_ajax') }}",
            data:{ id_acuerdo:id_acuerdo, ponencia:ponencia, id_documento:id_documento, tipo_documento:tipo_documento },
            success:function(data){
                if(data.status==100){
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);
                    
                    var win = window.open(data.response, '_blank');
                }
                else{
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);
                    alert(data.message);
                }
            }
        });
    }

    function imprimirTodo(){
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})


        $.ajax({
            type:'POST',
            url: "{{ route('bandeja.documento_descargar_masivo_ajax') }}",
            data:{ bandeja:'proximaPublicacion', toca:$('#toca').val(), anio_toca:$('#anio_toca').val(), asunto_toca:$('#asunto_toca').val(), fecha_desde:"", fecha_hasta:""  },
            success:function(data){
                setTimeout(function(){
                    $('#modal_loading').modal('hide');
                }, 500);
                console.log(data);
                if(data.status==100){
                    var win = window.open(data.file, '_blank');
                }
                else{
                    alert(data.message);
                }
            }
        });
    }

    function imprimirSeleccion(todos){
        var arr_imprimir="";

        if(todos==0){
            $( ".chbox_imprimir" ).each(function( index ) {
                if($(this).is(':checked')) {
                    arr_imprimir+=$('#data_imprimir_'+$(this).val()).val()+'-';
                }
            });
            console.log(arr_imprimir);
        }
       
        if(arr_imprimir!=""){
            $('#modal_loading').modal({backdrop: 'static', keyboard: false})
            $.ajax({
                type:'POST',
                url: "{{ route('bandeja.documento_descargar_batch_ajax') }}",
                data:{ arr_imprimir:arr_imprimir },
                success:function(data){
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);
                    console.log(data);
                    //console.log(data.response[1593371487][0]['response']);
                    //console.log(data.response[1593331549][0]['response']);
                    if(data.status==100){
                        var win = window.open(data.file, '_blank');
                    }
                    else{
                        alert(data.message);
                    }
                }
            });
        }
        else{
            alert('Debe de seleccionar al menos un documento');
        }
    }
</script>
@endsection

@section('seccion-modales')
<!-- LARGE MODAL -->
<div id="modaldemo3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-lg modal-dialog-vertical-center modal-dialog-centered" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm" >
        <div class="modal-header pd-x-20">
        </div>
        <div class="modal-body pd-20">
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
@endsection