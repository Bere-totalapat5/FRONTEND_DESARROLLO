@php
    use App\Http\Controllers\clases\utilidades;
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
   
@endphp
 
@extends('layouts.index_estadistica')

@section('contenido-pageheader')  
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Carátulas</li>
    </ol>
    <h6 class="slim-pagetitle">Carátulas</h6>
@endsection
 

@section('contenido-principal')

        <div class="section-wrapper"> 
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="card-profile-name">Lista de Carátulas</h3>
                </div>
                <div class="col-lg-4">
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
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="tx-gray-800 transition">
                      Busqueda Avanzada
                    </a>
                  </div><!-- card-header -->
    
                  <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body">
                        <div class="form-layout">
                            
                            
                            <div class="row mg-b-25">
                                <div class="col-lg-6 mg-b-25">
                                  
                                  <label class="form-control-label">Materia: <span class="tx-danger">*</span></label>
                                  
                                  <div class="d-md-flex">
                                      <div id="slWrapper" class="parsley-select">
                                          <select class="form-control select2" id="juzgado_subtipo_id" data-placeholder="Selecciona una" data-parsley-class-handler="#slWrapper" data-parsley-errors-container="#slErrorContainer" required>
                                              <option label="Selecciona una"></option>
                  
                                              @foreach($lista_materias['response'] AS $materia)
                                                  <option value="{{$materia['juzgado_subtipo_clave']}}" @if($materia['juzgado_subtipo_clave']==$juzgado_subtipo_id) selected @endif>{{$materia['juzgado_subtipo_nombre']}}</option>
                                              @endforeach
                  
                                          </select>
                                      <div id="slErrorContainer"></div>
                                      </div>
                                      <div class="mg-md-l-10 mg-t-10 mg-md-t-0">
                                      <button onclick="irMateria();" class="btn btn-primary pd-x-20" value="5">Ir</button>
                                      </div>
                                  </div><!-- d-flex -->
                                  
                  
                  
                  
                                </div><!-- col-4 -->
                  
                                @isset($lista_submateria['response'])
                  
                                <div class="col-lg-6 mg-b-25">
                                  
                                  <label class="form-control-label">Juzgado: <span class="tx-danger">*</span></label>
                                  
                                  <div class="d-md-flex">
                                      <div id="slWrapper" class="parsley-select">
                                          <select class="form-control select2" id="codigo_juzgado" data-placeholder="Selecciona una" data-parsley-class-handler="#slWrapper" data-parsley-errors-container="#slErrorContainer" required>
                                              <option label="Selecciona una"></option>
                  
                                              @foreach($lista_submateria['response'] AS $juzgado)
                                                  <option value="{{$juzgado['codigo']}}" @if($juzgado['codigo']==$codigo_juicio) selected @endif >{{$juzgado['nombre']}}</option>
                                              @endforeach
                  
                                          </select>
                                          <div id="slErrorContainer"></div>
                                      </div>
                                      <div class="mg-md-l-10 mg-t-10 mg-md-t-0">
                                      <button onclick="irJuzgado();" class="btn btn-primary pd-x-20" value="5">Ir</button>
                                      </div>
                                  </div><!-- d-flex -->
                  
                                </div><!-- col-4 -->
                                @endisset

                            </div>


                            @if($codigo_juicio!="")
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">ID:</label>
                                            <div class="input-group" style="width:100%;">
                                                <input type="text"  class="form-control" name="id_promocion" id="id_promocion" >
                                            </div>

                                        </div>
                                    </div><!-- col-4 -->

                                    <div class="col-lg-4">
                                        <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Día de creación:</label>
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                                </div>
                                                <input type="text"  class="form-control fc-datepicker" name="fecha" readonly="readonly" >
                                            </div>

                                        </div>
                                    </div><!-- col-4 -->

                                    <div class="col-lg-4">
                                        <div class="form-group mg-b-10-force">
                                            <label class="form-control-label">Tipo de origen:</label>
                                            <div class="input-group" style="width:100%;">
                                                
                                                <select class="form-control select2" data-placeholder="" id="origen" name="origen" style="width:100%;">
                                                    <option value="EXPEDIENTE EMP" selected>EXPEDIENTES</option>
                                                    <option value="ACUERDO EMP" >ACUERDOS</option>
                                                    <option value="PROMOCION EMP" >PROMOCIONES</option>
                                                </select>

                                            </div>

                                        </div>
                                    </div><!-- col-4 -->

            

                                    <div class="col-lg-12">
                                        <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Expediente:</label>
                                        <table>
                                                <tr>
                                                    <td style="width:30%;"><input class="form-control" type="text" name="toca" id="toca" value="" placeholder="Número"></td>
                                                    <td><center>/</center></td>
                                                    <td style="width:30%;">
                                                        <select class="form-control select2" data-placeholder="" id="anio_toca" name="anio_toca" style="width:100%;">
                                                            <option value="-" selected>Todos</option>
                                                            @for($i=request()->entorno['variables_entorno']['ANIO_FIN']; $i>=request()->entorno['variables_entorno']['ANIO_INICIO']; $i--)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
        
                                                    </td>
                                                    <td></td>
                                                    <td style="width:30%;"></td>
                                                </tr>
                                            </table>
        
        
                                        
                                        </div>
                                    </div><!-- col-4 -->


                                    
                                </div>

                                <div class="row mg-t-20">
                                    <div class="col-lg-4">
                                    <label class="rdiobox">
                                        <input name="rdio" type="radio" value="-"  >
                                        <span>Todo</span>
                                    </label>
                                    </div><!-- col-3 -->
                                    <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox">
                                        <input name="rdio" type="radio" value="n" checked >
                                        <span>No escaneadas</span>
                                    </label>
                                    </div><!-- col-3 -->
                                    <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                    <label class="rdiobox">
                                        <input name="rdio" type="radio" value="c">
                                        <span>Escaneadas</span>
                                    </label>
                                    </div><!-- col-3 -->
                                </div><!-- row -->


                                <div class="col-lg-12 mg-t-20">
                                    <button class="btn btn-primary btn-block mg-b-10" onclick="accionBuscar_ajax('primera');">Buscar Carátula</button>
                                </div>

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

       

        <div class="table-wrapper">

                
                    <div class="pagination-wrapper justify-content-between" style="margin-bottom: 20px;">
                        <ul class="pagination mg-b-0">
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="accionBuscar_ajax('primera');" aria-label="Last">
                            <i class="fa fa-angle-double-left"></i>
                            </a>
                        </li>
                        
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" onclick="accionBuscar_ajax('atras');" aria-label="Next">
                                <i class="fa fa-angle-left"></i>
                                </a>
                            </li>
                        
                        </ul>
            
                        <div id="texto_paginator">Página <span class="pagina_actual_texto">{{$lista['response_pag']['pagina_actual']}}</span> de <span class="pagina_total_texto">{{$lista['response_pag']['paginas_totales']}}</span></div>
            
                        <ul class="pagination mg-b-0">
                        
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="accionBuscar_ajax('avanzar');" aria-label="Next">
                            <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                        
        
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="accionBuscar_ajax('ultima');" aria-label="Last">
                            <i class="fa fa-angle-double-right"></i>
                            </a>
                        </li>
                        </ul>
                    </div><!-- pagination-wrapper -->
                

            <table id="datatable1" class="table display responsive wrap" style="max-width: 850px;">
                <thead>
                <tr>
                    <th class="wd-10p romperCadena">ID</th>
                    <th class="wd-40p romperCadena">Fecha de creación</th>
                    <th class="wd-20p">Expediente / Tipo</th>
                    <th class="wd-10p romperCadena">Comentarios</th>
                    <th class="wd-20p">Acciones</th>
                </tr>
                </thead>
                <tbody>

                   
                @isset($lista["response"])
               
                
                    @php $i=0; @endphp
                    
                    @foreach ($lista["response"] as $promocion)
                       <tr class="data-row-id-{{$i}}">

                        <td class="romperCadena">
                            {{$promocion['opc_promocion_id']}}
                            <br>
                            @if($promocion['opc_promocion_bandera_adjuntos_scanner']==1)
                                <span class="tx-success">Escaneada</span>
                            @else
                                <span class="tx-danger">Sin escanear</span>
                            @endif
                        </td>
                        <td class="romperCadena">
                            @php $fecha_arr=explode(' ', $promocion['opc_promocion_fecha_registro']); @endphp
                            {{$fecha_arr[0]}}<br>{{$fecha_arr[1]}}<br>
                            @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]); print($fechaCreacion); @endphp
                        </td>
                        <td class="romperCadena">
                            <strong>
                                {{$promocion['opc_promocion_no_expediente']}}/{{$promocion['opc_promocion_anio_expediente']}}
                            </strong><br>
                            {{utilidades::acomodarTipoExpedienteTxt($promocion['tipo_expediente'])}}
                        </td>
                        <td class="romperCadena">
                            {{$promocion['opc_promocion_comentario']}}
                        </td>
                        <td class="romperCadena">  
                            <a href="javascript:void(0);" onclick="openDocumentoCaratula('{{$promocion['opc_promocion_id']}}', '{{$promocion['opc_promocion_metadata']}}');">Consultar QR<br>
                            <a href="javascript:void(0);" onclick="openXML('{{$promocion['opc_promocion_id']}}', '{{$promocion['opc_promocion_metadata']}}', '{{$promocion['opc_promocion_id']}}_{{$codigo_juicio}}_{{$promocion['opc_promocion_no_expediente']}}/{{$promocion['opc_promocion_anio_expediente']}}');">XML<br>
                            <a href="javascript:void(0);" onclick="eliminarCaratula('{{$promocion['opc_promocion_id']}}', '{{$i}}');">Eliminar</a><br>
                            @if($promocion['opc_promocion_estatus']==1)
                                @isset($promocion['adjuntos'])
                                    @foreach($promocion['adjuntos'] as $adjuntos)
                                        @isset($adjuntos['json_arr']->idDocument)
                                            @if($adjuntos_int==0)
                                                <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});" ><span title="Comentarios: @isset($adjuntos['json_arr']->observaciones) {{$adjuntos['json_arr']->observaciones}} @else No hay observaciones @endif">Adjunto</span></a>
                                            @endif
                                        @endisset
                                    @endforeach
                                @endisset
                            @endif
                        </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                @endisset
                
                </tbody>
            </table>


            
                <input type="hidden" id="pagina_actual" name="pagina_actual" value="{{$lista['response_pag']['pagina_actual']}}">
                <input type="hidden" id="paginas_totales" name="paginas_totales" value="{{$lista['response_pag']['paginas_totales']}}">

                <div class="pagination-wrapper justify-content-between">
                    <ul class="pagination mg-b-0">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="accionBuscar_ajax('primera');" aria-label="Last">
                        <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);" onclick="accionBuscar_ajax('atras');" aria-label="Next">
                            <i class="fa fa-angle-left"></i>
                            </a>
                        </li>
                    
                    </ul>
        
                    <div id="texto_paginator">Página <span class="pagina_actual_texto">{{$lista['response_pag']['pagina_actual']}}</span> de <span class="pagina_total_texto">{{$lista['response_pag']['paginas_totales']}}</span></div>
        
                    <ul class="pagination mg-b-0">
                    
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="accionBuscar_ajax('avanzar');" aria-label="Next">
                        <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    

                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="accionBuscar_ajax('ultima');" aria-label="Last">
                        <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                    </ul>
                </div><!-- pagination-wrapper -->
            



            </div><!-- table-wrapper -->
        </div><!-- section-wrapper -->
        <br><br>
@endsection

@section('seccion-estilos')
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
    <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/box/qtip2/jquery.qtip.css">
    <style>
        @media screen and (max-width: 600px) {
            .filtro_tocas_turnados{
                float: left !important;
            }
        }
        .filtro_tocas_turnados{
            float: right;
        }
        .redClass{
            background: #22558c;
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
    <script type="text/javascript" src="/box/qtip2/jquery.qtip.js"></script>
@endsection

@section('seccion-scripts-functions')
<script>

    function irMateria(){
        materia=$( "#juzgado_subtipo_id option:selected" ).val();
        location="/estadistica/consulta/"+materia;
    }

    function irJuzgado(){
        materia=$( "#juzgado_subtipo_id option:selected" ).val();
        juzgado=$( "#codigo_juzgado option:selected" ).val();
        location="/estadistica/consulta/"+materia+"/"+juzgado;
    }

    function openDocumentoGestor(id){
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "/descargarGestor");
        form.setAttribute("target", "view");

        var hiddenField = document.createElement("input"); 
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "idGlobal");
        hiddenField.setAttribute("value", id);
        form.appendChild(hiddenField);
        document.body.appendChild(form);

        window.open('', 'view');

        form.submit();
    }

    function openXML(id_promocion, metadatos, nombre){
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "/estadistica/cargar_caratulas_xml");
        form.setAttribute("target", "_top");

        var hiddenField = document.createElement("input"); 
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "metadatos");
        hiddenField.setAttribute("value", metadatos);
        form.appendChild(hiddenField);
        document.body.appendChild(form);


        var hiddenField = document.createElement("input"); 
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "id_promocion");
        hiddenField.setAttribute("value", id_promocion);
        form.appendChild(hiddenField);
        document.body.appendChild(form);


        var hiddenField = document.createElement("input"); 
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "nombre");
        hiddenField.setAttribute("value", nombre);
        form.appendChild(hiddenField);
        document.body.appendChild(form);

        window.open('', 'view');
        form.submit();
    }
 


    var dataTableGlobal;
    var i_global=-1;
    $(document).ready(function() {
        var rows_selected = [];
        var table ;
        
        dataTableGlobal = table = $('#datatable1').DataTable( {
            "paging":   false,
            "info":     false,
            "ordering": false,
            'columnDefs': [
            { responsivePriority: 0, targets: 4 },  
            { "targets": [0],  "orderable": false, "visible": true, 'className': 'romperCadena' },
            { "targets": [1],  "orderable": false, "visible": true, 'class': 'romperCadena' },
            { "targets": [2],  "orderable": false, "visible": true, 'class': 'romperCadena' },
            { "targets": [3],  "orderable": false, "visible": true, 'class': 'romperCadena' },
            { "targets": [4],  "orderable": false, "visible": true, 'className': 'romperCadena' }
        ],
            bLengthChange: false,
            searching: false,
            responsive: true,
            pageLength: 20
        });
            

   
        'use strict';
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

        //var currentDate = currentDate = new Date();
        //$('.fc-datepicker').data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()))

        $('span[title]').qtip({
            content: {
                text: false // Use each elements title attribute
            },
            style       : 'qtip-bootstrap'
        });

        setTimeout(function(){
            $('#modal_loading').modal('hide');
        }, 500);
    });
    

    //busqueda de tocas
    function accionBuscar_ajax(pagina_accion){

        pagina=parseInt($('#pagina_actual').val());
        registros_por_pagina=20;

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

        if(pagina<=0 || pagina>$('#paginas_totales').val() && 0){
            console.log(1);
        }
        else{
            $('#modal_loading').modal({backdrop: 'static', keyboard: false});

            if(pagina<=0 || pagina>$('#paginas_totales').val()){
                console.log(2);
                pagina=$('#paginas_totales').val();
            }

            $('#pagina_actual').val(pagina);
            $('.pagina_actual_texto').html(pagina);
            
            var id_promocion=$('#id_promocion').val();
            var tipo = $("input[name='rdio']:checked").val();
            var fecha = ($("input[name=fecha]").val()=="") ? "-" : $("input[name=fecha]").val();
            var origen = $("#origen option:selected").val();
            //alert(origen);

            
            var toca = ($("input[name=toca]").val()=="") ? "-" : $("input[name=toca]").val();
            //var anio_toca = ($("input[name=anio_toca]").val()=="") ? "-" : $("input[name=anio_toca]").val();
            var anio_toca = $("#anio_toca option:selected").val();

            $.ajax({
                type:'POST',
                url:'/estadistica/buscar_caratula',
                data:{pagina:pagina, registros_por_pagina:registros_por_pagina, 
                    id_promocion:id_promocion, 
                    tipo:tipo, 
                    fecha:fecha,
                    expediente:toca,
                    expediente_anio:anio_toca,
                    origen:origen,
                    codigo_juicio:'{{$codigo_juicio}}'
                
                }, 
                success:function(data){
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    },500);
                    
                    dataTableGlobal.clear().draw();
                    console.log(data);
                    if(data.status==100){
                        i_global=-1;


                        $('.pagina_total_texto').html(data.response_pag['paginas_totales']);
                        $('#paginas_totales').val(data.response_pag['paginas_totales'])
                        
                        acciones="";
                        

                        for(var i=0; i<data.response.length; i++){
                            documentos='';

                            //if(data.response[i]['opc_promocion_origen']=='SIGJ SCANER'){
                                documentos='<a href="javascript:void(0);" onclick="openDocumentoCaratula('+data.response[i]['opc_promocion_id']+', \''+data.response[i]['opc_promocion_metadata']+'\');">Consultar QR<br>';
                                documentos+='<a href="javascript:void(0);" onclick="openXML('+data.response[i]['opc_promocion_id']+', \''+data.response[i]['opc_promocion_metadata']+'\', \''+data.response[i]['opc_promocion_id']+'_{{$codigo_juicio}}_'+data.response[i]['opc_promocion_no_expediente']+'_'+data.response[i]['opc_promocion_anio_expediente']+'\');">XML<br>';
                            //} 

                            bandera_titulo=0;

                            if(data.response[i].opc_promocion_estatus==1){
                                if(typeof(data.response[i].adjuntos) !== "undefined" ){
                                    for(var j=0; j<data.response[i].adjuntos.length; j++){
                                        if(typeof(data.response[i].adjuntos[j]['json_arr']) !== "undefined" && data.response[i].adjuntos[j]['json_arr'] !== null ){
                                            if(typeof(data.response[i].adjuntos[j]['json_arr'].idDocument) !== "undefined"){
                                                documentos+='<a href="javascript:void(0);" onclick="openDocumentoGestor('+data.response[i].adjuntos[j]['json_arr'].idDocument+');" >Adjunto</a><br>';
                                            }
                                            else{
                                                documentos+='<a href="javascript:void(0);" onclick="openDocumentoGestor('+data.response[i].adjuntos[j]['json_arr'].idGlobal+');" >Adjunto</a><br>';
                                            }
                                            
                                        }
                                    }
                                }
                            }

                            documentos+='<a href="javascript:void(0);" onclick="eliminarCaratula('+data.response[i]['opc_promocion_id']+', '+i+');">Eliminar</a>';


                            expediente_txt='<strong>'+data.response[i]['opc_promocion_no_expediente']+'/'+data.response[i]['opc_promocion_anio_expediente']+'</strong><br>'+acomodarTipoExpedienteTxt(data.response[i]['tipo_expediente'])+'<br>';
                            //if(data.response[i]['opc_promocion_tipo_documento']=="OTROS"){
                            //    expediente_txt+="OTROS";
                            //}
                            //else{
                            //    expediente_txt+='PROMOCION'; 
                            //}

                            var texto_id=data.response[i].opc_promocion_id;
                            //if(data.response[i]['opc_promocion_origen']=='SIGJ SCANER'){
                                if(data.response[i].opc_promocion_bandera_adjuntos_scanner==1){
                                    texto_id+='<br><span class="tx-success">Escaneada</span>';
                                }
                                else{
                                    texto_id+='<br><span class="tx-danger">Sin escanear</span>';
                                }
                            //}
                            

                            var rowNode = dataTableGlobal.row.add( [ 
                                texto_id,
                                data.response[i].fecha_1+'<br>'+data.response[i].fecha_2+'<br>'+data.response[i].fecha_humana ,
                                expediente_txt,
                                data.response[i].opc_promocion_comentario,
                                documentos
                            ] ).draw(false).nodes().to$().addClass( 'data-row-id-'+i );
                        }
                    }
                    else{
                        $('.pagina_total_texto').html(0);
                        $('.pagina_actual_texto').html(0);
                        
                    }
                }
            });
        }
    }

    function openDocumentoCaratula(id_promocion, metadatos){

        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "/estadistica/cargar_caratulas_pdf");
        form.setAttribute("target", "view");

        var hiddenField = document.createElement("input"); 
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "metadatos");
        hiddenField.setAttribute("value", metadatos);
        form.appendChild(hiddenField);
        document.body.appendChild(form);


        var hiddenField = document.createElement("input"); 
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "id_promocion");
        hiddenField.setAttribute("value", id_promocion);
        form.appendChild(hiddenField);
        document.body.appendChild(form);

        window.open('', 'view');
        form.submit();
    }
    
    function eliminarCaratula(id_promocion, index){
        if(confirm('¿Estas seguro de eliminarla?')){
            $.ajax({
                type:'POST',
                url:'/promociones/eliminar_caratula',
                data:{ id_promocion:id_promocion },
                success:function(data){
                    console.log(data);
                    if(data.status==100){
                        dataTableGlobal.rows($('#datatable1').find('.data-row-id-'+index)).remove().draw();
                    }
                    else{
                        alert(data.message);
                    }
                }
            });
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