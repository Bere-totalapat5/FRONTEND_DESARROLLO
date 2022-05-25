@php
use App\Http\Controllers\clases\humanRelativeDate;
$humanRelativeDate = new humanRelativeDate();
use App\Http\Controllers\clases\utilidades;
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$request->lang['Búsqueda Sentencia/Toca']}}</li>
    </ol>
    <h6 class="slim-pagetitle">{{$request->lang['Búsqueda Sentencia/Toca']}}</h6>
@endsection

 
@section('contenido-principal')

@if(!isset($request->menu_general['response']))
    <div class="section-wrapper">
        <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
    </div>
@else

    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 65))
        <div class="section-wrapper">
            <BR><h1 style="text-align: center;">Por el momento solo puede utilizar el modulo de demandas y promociones para su consulta</h1>
        </div>
    @else

        <div class="section-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="card-profile-name">{{$request->lang['Búsqueda Sentencia/Toca']}}</h3>
                </div>
            </div>
            

            <div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true" style="margin-bottom:10px;">
                <div class="card">
                  <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="tx-gray-800 transition">
                      Busqueda Avanzada
                    </a>
                  </div><!-- card-header -->
    
                  <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                     




                        <div class="form-layout">
                            <div class="row mg-b-0">
                                
                                <div class="col-lg-12">

                                    <div class="row mg-t-10">

                                        
                                        <div class="col-lg-3">
                                            <label class="rdiobox">
                                              <input name="bandera_toca_turnado" type="radio" value="" @if($ponencia=="") checked @else disabled @endif>
                                              <span>Todos los tocas</span>
                                            </label>
                                          </div><!-- col-3 -->
                                          <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                              <input name="bandera_toca_turnado" type="radio" value="0" @if($ponencia!="") checked @endif >
                                              <span>Tocas turnados</span>
                                            </label>
                                          </div><!-- col-3 -->
                                          <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                            <label class="rdiobox">
                                              <input name="bandera_toca_turnado" type="radio" value="1" @if($ponencia!="") disabled @endif >
                                              <span>Tocas sin turnar</span>
                                            </label>
                                          </div><!-- col-3 -->

                                    </div>
                                </div>

                                
                                <div class="col-lg-12">
                                <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Toca: <span class="tx-danger">*</span></label>
                                    <table>
                                        <tr>
                                            <td style="width:30%;"><input class="form-control" type="text" name="toca" value="" placeholder="Número"></td>
                                            <td><center>/</center></td>
                                            <td style="width:30%;">
                                                <select class="form-control select2" data-placeholder="" id="anio_toca" style="width:100%;">
                                                    @for($i=request()->entorno['variables_entorno']['ANIO_FIN']; $i>=request()->entorno['variables_entorno']['ANIO_INICIO']; $i--)
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td><center>/</center></td>
                                            <td style="width:30%;"><input class="form-control" type="text" name="asunto_toca" value="" placeholder="Asunto"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div><!-- col-4 -->
                            


                            <div class="col-lg-12">
                                <div class="form-group">
                                <label class="form-control-label">Expediente:</label>
                                <table>
                                        <tr>
                                            <td style="width:30%;"><input class="form-control" type="text" name="expediente" value="" placeholder="Número"></td>
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
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Nombre:</label>
                                    <input class="form-control" type="text" name="involucrados_nombre" value="" placeholder="">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Apellido paterno: </label>
                                    <input class="form-control" type="text" name="involucrados_apellido_paterno" value="" placeholder="">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Apellido materno:</label>
                                    <input class="form-control" type="text" name="involucrados_apellido_materno" value="" placeholder="">
                                </div>
                            </div><!-- col-4 -->

<!--
                            <div class="col-lg-6">
                                <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Tipo acuerdo: </label>
                                <select class="form-control select2" data-placeholder="" name="tipo_acuerdo" style="width:100%;">
                                    <option value="0" selected>Todos</option>
                                    <option value="Acuerdos">Acuerdos</option>
                                    <option value="Sentencias">Sentencias</option>
                                    <option value="Audiencias">Audiencias</option>
                                </select>
                                </div>
                            </div><!-- col-8 -- >
                            <div class="col-lg-6">
                                <div class="form-group mg-b-10-force">
                                <label class="form-control-label">Origen acuerdo: </label>
                                <select class="form-control select2" data-placeholder="" name="origen_acuerdo" style="width:100%;">
                                    <option value="0" selected>Todos</option>
                                    <option value="Acuerdos">Secretaria de acuerdos</option>
                                    <option value="Sentencias">Secretaria de amparos</option>
                                    <option value="Audiencias">Secretaria de asuntos nuevos</option>
                                    <option value="Audiencias">Ponencia 1</option>
                                    <option value="Audiencias">Ponencia 2</option>
                                    <option value="Audiencias">Ponencia 3</option>
                                </select>
                                </div>
                            </div><!-- col-8 -- >
-->

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
                                                    <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" name="fecha_desde" readonly="readonly">
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
                                                    <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" name="fecha_hasta" readonly="readonly">
                                                </div>

                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div><!-- col-4 -->


                            <div class="col-lg-12">
                                <button class="btn btn-primary btn-sm btn-block mg-b-10" onclick="accionBuscarArchivo_ajax('primera');">Buscar {{$request->lang['Toca']}}</button>
                            </div>

                            </div><!-- row -->
                        </div>
                       </div>
                    </div>
                </div>
            </div>



            <div class="table-wrapper">

                @isset($lista_archivos['response_pag']['pagina_actual'])
                <div class="pagination-wrapper justify-content-between" style="margin-bottom: 20px;">
                    <ul class="pagination mg-b-0">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="accionBuscarArchivo_ajax('primera');" aria-label="Last">
                          <i class="fa fa-angle-double-left"></i>
                        </a>
                      </li>
                      
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="accionBuscarArchivo_ajax('atras');" aria-label="Next">
                            <i class="fa fa-angle-left"></i>
                            </a>
                        </li>
                      
                    </ul>
        
                    <div id="texto_paginator">Página <span class="pagina_actual_texto">{{$lista_archivos['response_pag']['pagina_actual']}}</span> de <span class="pagina_total_texto">{{$lista_archivos['response_pag']['paginas_totales']}}</span></div>
        
                    <ul class="pagination mg-b-0">
                      
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="accionBuscarArchivo_ajax('avanzar');" aria-label="Next">
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </li>
                     
    
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="accionBuscarArchivo_ajax('ultima');" aria-label="Last">
                          <i class="fa fa-angle-double-right"></i>
                        </a>
                      </li>
                    </ul>
                  </div><!-- pagination-wrapper -->
                  @endisset

                <table id="datatable1" class="table display responsive nowrap" style="max-width: 850px;">
                <thead>
                <tr>
                    <th class="wd-15p" style="width: 25%;">Toca</th>
                    <th class="wd-10p" style="width: 10%;">Ponencia</th>
                    <th class="wd-15p" style="width: 15%;">Fecha ingreso</th>
                    <th class="wd-15p" style="width: 30%;">Partes</th>
                    <th class="wd-10p" style="width: 20%;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                
                @isset($lista_archivos["response"])
                    @foreach ($lista_archivos["response"] as $archivo)
                    <tr>
                        <td style="word-wrap: break-word; white-space:normal;">
                            {{$archivo["numero"]}}<br>
                            {{$archivo["tipo"]}}<br>
                            {{$archivo["expediente_principal"]}} {{$archivo["juzgado_expediente"]}}
                        </td>
                        <td style="word-wrap: break-word; white-space:normal;">
                            @if($archivo["ponencia"]!="")
                            P
                            @else
                            -
                            @endif
                            {{$archivo["ponencia"]}} 
                        </td>
                        <td style="word-wrap: break-word; white-space:normal;">
                            {{ \Carbon\Carbon::parse($archivo["fecha_ingreso"])->format('d-M-Y') }}<br>
                            @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($archivo["fecha_ingreso"]); print($fechaCreacion); @endphp

                        </td>
                        
                        <td style="word-wrap: break-word; white-space:normal;">
                            
                            @isset($archivo["partes"]['actor'])
                                <strong>ACTOR</strong><br>
                                @foreach ($archivo["partes"]['actor'] as $parte)
                                    <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte}}</div>
                                @endforeach
                            @endisset

                            @isset($archivo["partes"]['demandado'])
                                <strong >DEMANDADO</strong><br>
                                @foreach ($archivo["partes"]["demandado"] as $parte)
                                    <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte}}</div>
                                @endforeach


                            @endisset

                            @isset($archivo["partes"]['terceros'])
                                <strong>TERCERO</strong><br>
                                @foreach ($archivo["partes"]["terceros"] as $parte)
                                    <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte}}</div>
                                @endforeach

                            @endisset
                            
                        </td>
                        <td>
                            <a href="javascript:void(0);" onclick="alert('Representantes');">Representantes</a><br>
                            <a href="{{ route('acuerdo_detalles.general', $archivo["id"]) }}">Resoluciones</a><br>
                            <a href="" data-toggle="modal" data-target="#modaldemo3" onclick="archivoDetalles({{$archivo['id']}});">Ver {{$request->lang['Toca']}}</a><br>

                            @if ($bandera_turnar_toca['response']==1)
                                @if (@$archivo["ponencia"]=="")
                                    <a href="" data-toggle="modal" data-target="#modaldemo3" onclick="turnarTocaInfo({{$archivo['id']}});">Turnar {{$request->lang['Toca']}}</a><br>
                                @endif
                            @endif 
                            
                            @if ($bandera_modificar_toca['response']==1)
                                <a href="/juicio/editar/{{$archivo['id']}}">Editar {{$request->lang['Toca']}}</a><br>
                            @endif
                            

                            <!--
                            <hr style="margin-top:5px; margin-bottom:5px;">
                            <a href="" data-toggle="modal" data-target="#modaldemo3" onclick="cargarInfoNotificacion({{$archivo['id']}});">Notificación electrónica</a>
                            -->
                            
                            
                        </td>
                    </tr>
                    @endforeach
                @endisset
                
                </tbody>
            </table>


            @isset($lista_archivos['response_pag']['pagina_actual'])
            <input type="hidden" id="pagina_actual" name="pagina_actual" value="{{$lista_archivos['response_pag']['pagina_actual']}}">
            <input type="hidden" id="paginas_totales" name="paginas_totales" value="{{$lista_archivos['response_pag']['paginas_totales']}}">

            
            <div class="pagination-wrapper justify-content-between">
                <ul class="pagination mg-b-0">
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="accionBuscarArchivo_ajax('primera');" aria-label="Last">
                      <i class="fa fa-angle-double-left"></i>
                    </a>
                  </li>
                  
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="accionBuscarArchivo_ajax('atras');" aria-label="Next">
                        <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                  
                </ul>
     
                <div id="texto_paginator">Página <span class="pagina_actual_texto">{{$lista_archivos['response_pag']['pagina_actual']}}</span> de <span class="pagina_total_texto">{{$lista_archivos['response_pag']['paginas_totales']}}</span></div>
    
                <ul class="pagination mg-b-0">
                  
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="accionBuscarArchivo_ajax('avanzar');" aria-label="Next">
                      <i class="fa fa-angle-right"></i>
                    </a>
                  </li>
                 

                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="accionBuscarArchivo_ajax('ultima');" aria-label="Last">
                      <i class="fa fa-angle-double-right"></i>
                    </a>
                  </li>
                </ul>
              </div><!-- pagination-wrapper -->
              @endisset


            </div><!-- table-wrapper -->
        </div><!-- section-wrapper -->
    @endif
@endif

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
        table.dataTable tbody td {
            word-break: break-word;
            vertical-align: top;
            white-space:normal;
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
    $('#modal_loading').modal({backdrop: 'static', keyboard: false});

    var dataTableGlobal;

    $(function(){

        'use strict';
        
        //datatable
        dataTableGlobal=$('#datatable1').DataTable({
            "paging":   false,
            "info":     false,
            "ordering": false,
            "searching": false,
            "ordering": false,
            'columnDefs': [
                
                { "targets": [0],  "orderable": false, "visible": true },
                { "targets": [1],  "orderable": false, "visible": true },
                { "targets": [2],  "orderable": false, "visible": true },
                { "targets": [3],  "orderable": false, "visible": true },
                { "targets": [4],  "orderable": false, "visible": true },
                {
                'orderable': false
            }],
            orderable: false,
            bLengthChange: false,
            responsive: true,
            language: {
                searchPlaceholder: 'Filtrar...',
                sSearch: '',
                lengthMenu: '_MENU_ Registros'
            }
        });

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
            dateFormat: 'yyyy-mm-dd',
        });
        

        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 1000);
    });

    //busqueda de tocas
    function accionBuscarArchivo_ajax(pagina_accion){

        /*
        if($("input[name=toca]").val().trim()==""){
            alert("El número de toca es obligatorio");
            return 0;
        }
*/


        pagina=parseInt($('#pagina_actual').val());
        registros_por_pagina=10;

        if(pagina_accion=="primera"){
            pagina=1;    
        }
        else if(pagina_accion=="avanzar"){
            pagina=pagina+1;
        }
        else if(pagina_accion=="atras"){
            pagina=pagina-1;
        }
        else if(pagina_accion=="ultima"){
            pagina=$('#paginas_totales').val();
        }

        if(pagina<=0 || pagina>$('#paginas_totales').val()){
            
        }
        else{

            $('#pagina_actual').val(pagina);
            $('.pagina_actual_texto').html(pagina);

                
            $('#modal_loading').modal({backdrop: 'static', keyboard: false})
                            
            var bandera_toca_turnado = $('input:radio[name=bandera_toca_turnado]:checked').val();

            var toca = ($("input[name=toca]").val()=="") ? "-" : $("input[name=toca]").val();
            var anio_toca = $("#anio_toca option:selected").val()
            var asunto_toca = ($("input[name=asunto_toca]").val()=="") ? "-" : $("input[name=asunto_toca]").val();

            var expediente = ($("input[name=expediente]").val()=="") ? "-" : $("input[name=expediente]").val();
            var anio_expediente = $("#anio_expediente option:selected").val()

            var involucrados_nombre = ($("input[name=involucrados_nombre]").val()=="") ? "-" : $("input[name=involucrados_nombre]").val();
            var involucrados_apellido_paterno = ($("input[name=involucrados_apellido_paterno]").val()=="") ? "-" : $("input[name=involucrados_apellido_paterno]").val();
            var involucrados_apellido_materno = ($("input[name=involucrados_apellido_materno]").val()=="") ? "-" : $("input[name=involucrados_apellido_materno]").val();

            var tipo_acuerdo = $("#tipo_acuerdo option:selected").val()
            var origen_acuerdo = $("#origen_acuerdo option:selected").val();

            var fecha_desde = ($("input[name=fecha_desde]").val()=="") ? "-" : $("input[name=fecha_desde]").val();
            var fecha_hasta = ($("input[name=fecha_hasta]").val()=="") ? "-" : $("input[name=fecha_hasta]").val();

            $.ajax({
                type:'POST',
                url:'/home',
                data:{pagina:pagina, registros_por_pagina:registros_por_pagina, bandera_toca_turnado:bandera_toca_turnado, toca:toca, anio_toca:anio_toca, asunto_toca:asunto_toca, expediente:expediente, anio_expediente:anio_expediente, involucrados_nombre:involucrados_nombre, involucrados_apellido_paterno:involucrados_apellido_paterno, involucrados_apellido_materno:involucrados_apellido_materno, tipo_acuerdo:tipo_acuerdo, origen_acuerdo:origen_acuerdo, fecha_desde:fecha_desde, fecha_hasta:fecha_hasta },
                success:function(data){
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);
                    console.log(data);
                    dataTableGlobal.clear().draw();
                    
                    if(data.status==100){

                        //se actualiza el total
                        $('.pagina_total_texto').html(data.response_pag['paginas_totales']);
                        $('#paginas_totales').val(data.response_pag['paginas_totales'])


                        const d1 = moment(new Date(Date.UTC("2020", "05", "14", "18", "47", "00"))).toDate();
                        
                        for(var i=0; i<data.response.length; i++){
                            const d = new Date(data.response[i].fecha_ingreso);

                            d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 );
                            const ye = new Intl.DateTimeFormat('es', { year: 'numeric' }).format(d);
                            const mo = new Intl.DateTimeFormat('es', { month: 'short' }).format(d);
                            const da = new Intl.DateTimeFormat('es', { day: '2-digit' }).format(d);
                            
                            var ponencia = "-";
                            if(data.response[i].ponencia!=null){
                                ponencia="P "+data.response[i].ponencia;
                            }

                            var partes="";
                            for(var j=0; j<data.response[i].partes.actor.length; j++){
                                if(data.response[i].partes.actor!=null){
                                    if(j==0){
                                        partes+="<strong>ACTOR</strong><br>";
                                    }
                                    partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].partes.actor[j]+'</div>';
                                }
                            }
                            if(data.response[i].partes.demandado!=null){
                                for(var j=0; j<data.response[i].partes.demandado.length; j++){                            
                                    if(j==0){
                                        partes+="<strong>DEMANDADO</strong><br>";
                                    }
                                    partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].partes.demandado[j]+'</div>';
                                }
                            }
                            if(data.response[i].partes.terceros!=null){
                                for(var j=0; j<data.response[i].partes.terceros.length; j++){
                                
                                    if(j==0){
                                        partes+="<strong>TERCERO</strong><br>";
                                    }
                                    partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].partes.terceros[j]+'</div>';
                                }
                            }

                            var url="{{ route('acuerdo_detalles.general', '/') }}/"+data.response[i].id;

                            acciones='<a href="javascript:void(0);" onclick="alert(\'Representantes\');">Representantes</a><br><a href="'+url+'">Resoluciones</a><br><a href="" data-toggle="modal" data-target="#modaldemo3" onclick="archivoDetalles('+data.response[i].id+');">Ver Toca</a><br>';
                            @if ($bandera_turnar_toca['response']==1)
                                if(data.response[i].ponencia==null){
                                    acciones+='<a href="" data-toggle="modal" data-target="#modaldemo3" onclick="turnarTocaInfo('+data.response[i].id+');">Turnar Toca</a><br>';
                                }
                            @endif

                            @if($bandera_modificar_toca['response']==1)
                                acciones+='<a href="/juicio/editar/'+data.response[i].id+'">Editar {{$request->lang['Toca']}}</a>';
                            @endif

                            dataTableGlobal.row.add( [ 
                                '<span style="word-wrap: break-word; white-space:normal;">'+data.response[i].numero+'<br>'+data.response[i].tipo+'<br>'+data.response[i].expediente_principal+' '+data.response[i].juzgado_expediente+'</span>',
                                '<span style="word-wrap: break-word; white-space:normal;">'+ponencia+'</span>',
                                '<span style="word-wrap: break-word; white-space:normal;">'+data.response[i].fecha_1+'<br>'+data.response[i].fecha_humana+'</div>'+'</span>',
                                '<span style="word-wrap: break-word; white-space:normal;">'+partes+'</span>',
                                acciones
                            ] ).draw(false);

                            $(".format_human_js").timeago();
                        }
                    }
                    else{
                        $('.pagina_total_texto').html(0);
                        $('#paginas_totales').val(0)
                    }
                }
            });
        }
    }

    function turnarTocaInfo(id){
        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/turnarTocaInfo',
            data:{ id:id },
            success:function(data){
                
                $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
    }

    function cargarInfoNotificacion(id){
        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/consultaPartesNotificacion',
            data:{ id:id },
            success:function(data){
                $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
    }
    


    function archivoDetalles(id){

        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/home/archivoDetalles/'+id,
            data:{ id:id },
            success:function(data){
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