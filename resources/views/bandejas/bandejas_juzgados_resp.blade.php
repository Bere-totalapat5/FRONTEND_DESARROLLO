@php
    use App\Http\Controllers\clases\utilidades;
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Bandeja</li>
        <li class="breadcrumb-item active" aria-current="page">{{$bandeja_txt}}</li>
    </ol>
    <h6 class="slim-pagetitle">Bandeja {{$bandeja_txt}}</h6>
@endsection


@section('contenido-principal')
        <div class="section-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="card-profile-name">Lista de resoluciones en {{$bandeja_txt}}</h3>
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
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="tx-gray-800 transition collapsed">
                      Busqueda Avanzada
                    </a>
                  </div><!-- card-header -->
    
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
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Nombre:</label>
                                    <input class="form-control" type="text" name="involucrados_nombre" id="involucrados_nombre"  value="" placeholder="">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Apellido paterno: </label>
                                    <input class="form-control" type="text" name="involucrados_apellido_paterno" id="involucrados_apellido_paterno" value="" placeholder="">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">Apellido materno:</label>
                                    <input class="form-control" type="text" name="involucrados_apellido_materno" id="involucrados_apellido_materno" value="" placeholder="">
                                </div>
                            </div><!-- col-4 -->
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
                            </div><!-- col-8 -->
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
                            </div><!-- col-8 -->


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
                            </div><!-- col-4 -->
                            <div class="col-lg-12">
                                <button class="btn btn-primary btn-sm btn-block mg-b-10" onclick="accionBuscar_ajax();">Buscar Resolución</button>
                            </div>
                            </div><!-- row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>



            <div class="table-wrapper">
                <div style="float: left;">
                    <a href="javascript:void(0)" onclick="imprimirSeleccion(0, '{{$bandeja}}');">Imprimir selección</a>   |    <a href="javascript:void(0)" onclick="imprimirTodo();">Imprimir todo</a>
                </div>

                <div style="float: right">
                    @if($bandeja=='firma')
                        <a href="javascript:void(0)" onclick="avanzarSeleccion(0, '{{$bandeja}}');">@if($bandeja=='revision')Autorizar @else Firmar @endif selección</a>   |    <a href="javascript:void(0)" onclick="avanzarSeleccion(1, '{{$bandeja}}');">@if($bandeja=='revision')Autorizar @else Firmar @endif 10 acuerdos</a>
                    @endif
                </div>

            <table id="datatable1" class="table display responsive nowrap">
                <thead>
                <tr>
                    <th class="wd-15p">Fecha</th>
                    <th class="wd-10p">Secretaria</th>
                    <th class="wd-10p">Resolución / Estado</th>
                    
                    <th class="wd-25p">Partes</th>
                    <th class="wd-10p">Acciones</th>
                    <th><input name="select_all" value="1" type="checkbox"></th>
                </tr>
                </thead>
                <tbody>
                
                @isset($lista["response"])
                    
                    @php $i=0; @endphp
                    @foreach ($lista["response"] as $resolucion)
                       <tr class="data-row-id-{{$i}}">
                        <td>{{$i}}
                            <input type="hidden" value="{{$resolucion['id_acuerdo']}},{{$resolucion['codigo_organo']}},{{$resolucion['ultima_version']}}" id="data_imprimir_{{$i}}">
                            @php $fecha_arr=explode(' ', $resolucion['Fecha']); @endphp
                            {{$fecha_arr[0]}}<br>
                            @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]); print($fechaCreacion); @endphp
                        </td>
                        <td>
                            @if($resolucion["Ponencia"]!="")
                            {{$resolucion["Ponencia"]}}
                            @else 
                            -
                            @endif
                        </td>
                        <td>
                            @isset($resolucion["Toca/Estado"]["acuerdo"]) {{$resolucion["Toca/Estado"]["acuerdo"]}}<br> @endisset
                            @isset($resolucion["Toca/Estado"]["tipo_expediente"]) {{strtoupper($resolucion["Toca/Estado"]["tipo_expediente"])}}<br> @endisset

                            @isset($resolucion['firmado_por'][0]['nom_clave'])
                                @foreach ($resolucion['firmado_por'] as $firmado_por)
                                    <span title="{{$firmado_por['nom']}} {{$firmado_por['ap']}} {{$firmado_por['am']}}<br>{{$firmado_por['fecha_firma']}}" data-mode="above" style="font-weight: bold;">{{$firmado_por['nom_clave']}}</span><br>
                                @endforeach
                            @endisset

                            @if ($resolucion["visibilidad"]=="electronica")
                                <small><i class="fa fa-exclamation-triangle tx-warning"></i><a href="{{$resolucion["firma_notificacion"]["url"]}}" target="_blank">Notificación electrónica</a></small>
                            @endif    


                        </td>
                        
                        <td class="romperCadena">
                            @isset($resolucion["partes"]) 

                                @isset($resolucion['partes']['actor'])
                                    @php $bandera1=$bandera2=0; $sello=1; @endphp

                                    @foreach ($resolucion['partes']["actor"] as $parte)



                                        
                                        @if((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $resolucion['id_catalogo_juicio'])) and $parte['parte_promovente']==0 and $bandera1==0)
                                            <strong>INTERESADOS</strong><br>
                                            @php $bandera1=1; $sello=0; @endphp

                                        @elseif((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $resolucion['id_catalogo_juicio'])) and $parte['parte_promovente']==1 and $bandera2==0)
                                            <strong>PROMOVENTE</strong><br>
                                            @php $bandera2=1; $sello=0; @endphp
                                        @elseif((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $resolucion['id_catalogo_juicio'])) and $bandera1==0)
                                            <strong>ACTOR</strong><br>
                                            @php $bandera1=1; @endphp
                                        @endif




                                        <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['parte_nombres']}} {{$parte['parte_apellido_paterno']}} {{$parte['parte_apellido_materno']}}</div>
                                    @endforeach
                                @endisset

                                @isset($resolucion['partes']['demandado'])
                                    <strong >DEMANDADO</strong><br>
                                    @foreach ($resolucion['partes']["demandado"] as $parte)
                                        <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['parte_nombres']}} {{$parte['parte_apellido_paterno']}} {{$parte['parte_apellido_materno']}}</div>
                                    @endforeach
                                @endisset

                                @isset($resolucion['partes']['terceros'])
                                    <strong>TERCERO</strong><br>
                                    @foreach ($resolucion['partes']["terceros"] as $parte)
                                        <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['parte_nombres']}} {{$parte['parte_apellido_paterno']}} {{$parte['parte_apellido_materno']}}</div>
                                    @endforeach
                                @endisset
                            @endisset
                        </td>
                    
                        <td>
                            <a href="javascript:void(0);" onclick="vistaPrevia({{$resolucion['id_acuerdo']}}, '{{$resolucion['codigo_organo']}}', {{$resolucion['ultima_version']}}, 'pdf');"><strong>Vista previa</strong></a><br>

                                                                                                
                                                                                                   


                            @if($bandeja=='firma')
                            <a class="tx-danger" href="javascript:void(0);" onclick="avanzarFlujo({{$resolucion['id_acuerdo']}}, '{{$bandeja}}', 'regreso', {{$i}}, '{{$resolucion['codigo_organo']}}', {{$resolucion['ultima_version']}}, 'firel', '{{$resolucion['id_juicio']}}',  '{{$resolucion['tipo_flujo_nombre']}}', {{$sello}});">A revisión</a><br>
                            @endisset

                            @if($bandeja=='firma')
                            <a class="tx-success" href="javascript:void(0);" onclick="avanzarFlujo({{$resolucion['id_acuerdo']}}, '{{$bandeja}}', 'avance', {{$i}}, '{{$resolucion['codigo_organo']}}', {{$resolucion['ultima_version']}}, 'firel', '{{$resolucion['id_juicio']}}', '{{$resolucion['tipo_flujo_nombre']}}', {{$sello}});">Firmar</a><br>
                            @else
                                <a class="tx-success" href="javascript:void(0);" onclick="avanzarFlujo({{$resolucion['id_acuerdo']}}, '{{$bandeja}}', 'corregido', {{$i}}, '{{$resolucion['codigo_organo']}}', {{$resolucion['ultima_version']}}, 'firel', '{{$resolucion['id_juicio']}}',  '{{$resolucion['tipo_flujo_nombre']}}', {{$sello}});">Corregido</a><br>
                            @endisset
                            <input type="hidden" value="{{$resolucion['id_acuerdo']}},{{$bandeja}},avance,{{$i}},{{$resolucion['codigo_organo']}},{{$resolucion['ultima_version']}},firel,{{$resolucion['id_juicio']}},{{$resolucion['tipo_flujo_nombre']}},{{$sello}}" id="avanzar_masivo_{{$i}}" class="avanzar_masivo">


                            @if($bandeja!='firma')
                                @if($resolucion['extension_documento']=='.html')
                                    <a href="javascript:void(0);" onclick="vistaPrevia({{$resolucion['id_acuerdo']}}, '{{$resolucion['codigo_organo']}}', {{$resolucion['ultima_version']}}, 'html', '{{$resolucion['posicion_en_flujo'][0]['id_flujo_participante']}}');">Editar</a><br>
                                @else
                                    <a href="javascript:void(0);" onclick="vistaPrevia({{$resolucion['id_acuerdo']}}, '{{$resolucion['codigo_organo']}}', {{$resolucion['ultima_version']}}, 'word');">Descargar</a><br>
                                @endif
                                
                            @endif


                            @if($bandeja=='firma')
                                @if($resolucion['extension_documento']=='.html' and !isset($resolucion['firmado_por'][0]['fecha_firma']) and 0)
                                    <a href="javascript:void(0);" onclick="vistaPrevia({{$resolucion['id_acuerdo']}}, '{{$resolucion['codigo_organo']}}', {{$resolucion['ultima_version']}}, 'html', '{{$resolucion['posicion_en_flujo'][0]['id_flujo_participante']}}');">Editar acuerdo HTML</a><br>
                                @endif
                                
                            @endif

                            @if($bandeja!='firma')
                                @if($resolucion['extension_documento']!='.html')
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="actualizarAcuerdoDocumento({{$resolucion['id_acuerdo']}}, '{{$resolucion['codigo_organo']}}', '{{$resolucion['posicion_en_flujo'][0]['id_flujo_participante']}}');">Actualizar</a><br>
                                @endif

                                <!--
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="actualizarAcuerdo({{$resolucion['id_juicio']}}, {{$resolucion['id_acuerdo']}}, '{{$resolucion['Toca/Estado']['acuerdo']}}');">Actualizar</a><br>
                                -->
                            @endif

                            @if($resolucion['id_creador']==$sesion['usuario_id'] or $sesion['usuario_tipo']=='juez magistrado')
                                <a href="javascript:void(0);" onclick="eliminarResolucion({{$resolucion['id_acuerdo']}}, '{{$bandeja}}', 'avance', {{$i}}, '{{$resolucion['codigo_organo']}}', {{$resolucion['ultima_version']}});">Eliminar</a><br>
                            @endif


                            <!--
                            <a href="{{ route('acuerdo_detalles.general', $resolucion["id_acuerdo"]) }}">Resoluciones</a><br>
                            <a href="javascript:void(0);" onclick="alert('Turnar');">Turnar</a><br>
                            <a href="" data-toggle="modal" data-target="#modaldemo3" onclick="archivoDetalles({{$resolucion["id_acuerdo"]}});">Ver Toca</a>
                            -->
                    
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

    <script type="text/javascript" src="/box/qtip2/jquery.qtip.js"></script>
@endsection

@section('seccion-scripts-functions')
<script>
    /*
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
    */

    function asignarAcuerdo(acuerdo_id, id_flujo_participante, posicion, seccion){
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
                
        //se obtienen los ids
        $.ajax({
            type:'POST',
            url:'/asignacion_flujo_participantes',
            data:{ acuerdo_id:acuerdo_id, id_flujo_participante:id_flujo_participante, posicion:posicion, seccion:seccion },
            success:function(data){
                $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
    }


    function actualizarAcuerdoDocumento(acuerdo_id, codigo_organo, id_flujo_participante){

        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/bandejas/formularioAcuerdoActualizarDocumentoAjax',
            data:{ acuerdo_id:acuerdo_id, codigo_organo:codigo_organo, id_flujo_participante,id_flujo_participante },
            success:function(data){
                $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
    }


    function guardarInfoAcuerdo(acuerdo_id){
        if(confirm('¿Esta seguro de guardar los cambios?')){
            $('#modaldemo3').modal('hide');
            setTimeout(function(){ 
                $('#modal_loading').modal({backdrop: 'static', keyboard: false})
                $.ajax({
                    type:'POST',
                    url:'/bandejas/formularioAcuerdoGuardarAjax',
                    data:{ acuerdo_id:acuerdo_id, especial:$( "#especial option:selected" ).val(), fecha_especial:$('#fecha_especial').val(), resolvio:$( "#resolvio option:selected" ).val(), anotacion:$('#anotacion').val()  },
                    success:function(data){
                        console.log(data);
                        $('#modal_loading').modal('hide');
                    }
                });
            }, 500);
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

    var dataTableGlobal;
    var i_global=-1;
    $(document).ready(function() {
        var rows_selected = [];
        var table ;
        
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
                    i_global++;
                    return '<input type="checkbox" id="chbox_'+i_global+'" class="chbox_imprimir" value="'+i_global+'">';
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
            dateFormat: 'yyyy-mm-dd'
        });

        

        setTimeout(function(){
            $('#modal_loading').modal('hide');

            $('span[title]').qtip({
                content: {
                    text: false // Use each elements title attribute
                },
                style       : 'qtip-bootstrap'
            });


        }, 500);
    });
    
    //busqueda de tocas
    function accionBuscar_ajax(){
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})
        
        
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
            url:'/bandejas/buscar',
            data:{bandeja:'{{$bandeja}}', 
                expediente:expediente, 
                anio_expediente:anio_expediente, 
                involucrados_nombre:involucrados_nombre,
                involucrados_apellido_paterno:involucrados_apellido_paterno,
                involucrados_apellido_materno:involucrados_apellido_materno,
                tipo_acuerdo:tipo_acuerdo, 
                origen_acuerdo:origen_acuerdo, 
                fecha_desde:fecha_desde, 
                fecha_hasta:fecha_hasta 
            },
            success:function(data){
                setTimeout(function(){
                    $('#modal_loading').modal('hide');
                },500);
                
                dataTableGlobal.clear().draw();
                console.log(data);
                if(data.status==100){
                    i_global=-1;

                    for(var i=0; i<data.response.length; i++){
                        
                        var ponencia = "-";
                        if(data.response[i].Ponencia!=null){
                            ponencia=data.response[i].Ponencia;
                        }

                        var partes="";
                        for(var j=0; j<data.response[i].partes.actor.length; j++){
                            if(data.response[i].partes.actor!=null){


                                if(j==0){
                                    partes+="<strong>ACTOR</strong><br>";
                                }

                                if(data.response[i].partes.actor[j]['parte_apellido_paterno']==null) data.response[i].partes.actor[j]['parte_apellido_paterno']="";
                                if(data.response[i].partes.actor[j]['parte_apellido_materno']==null) data.response[i].partes.actor[j]['parte_apellido_materno']="";

                                partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].partes.actor[j]['parte_nombres']+' '+data.response[i].partes.actor[j]['parte_apellido_paterno']+' '+data.response[i].partes.actor[j]['parte_apellido_materno']+'</div>';
                            }
                        }
                        if(data.response[i].partes.demandado!=null){
                            for(var j=0; j<data.response[i].partes.demandado.length; j++){                            
                                if(j==0){
                                    partes+="<strong>DEMANDADO</strong><br>";
                                }
                                
                                if(data.response[i].partes.demandado[j]['parte_apellido_paterno']==null) data.response[i].partes.demandado[j]['parte_apellido_paterno']="";
                                if(data.response[i].partes.demandado[j]['parte_apellido_materno']==null) data.response[i].partes.demandado[j]['parte_apellido_materno']="";

                                partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].partes.demandado[j]['parte_nombres']+' '+data.response[i].partes.demandado[j]['parte_apellido_paterno']+' '+data.response[i].partes.demandado[j]['parte_apellido_materno']+'</div>';
                            }
                        }
                        if(data.response[i].partes.terceros!=null){
                            for(var j=0; j<data.response[i].partes.terceros.length; j++){
                            
                                if(j==0){
                                    partes+="<strong>TERCERO</strong><br>";
                                }

                                if(data.response[i].partes.terceros[j]['parte_apellido_paterno']==null) data.response[i].partes.terceros[j]['parte_apellido_paterno']="";
                                if(data.response[i].partes.terceros[j]['parte_apellido_materno']==null) data.response[i].partes.terceros[j]['parte_apellido_materno']="";

                                partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].partes.terceros[j]['parte_nombres']+' '+data.response[i].partes.terceros[j]['parte_apellido_paterno']+' '+data.response[i].partes.terceros[j]['parte_apellido_materno']+'</div>';
                            }
                        }

                        acciones='<a href="javascript:void(0);" onclick="vistaPrevia('+data.response[i].id_acuerdo+', \''+data.response[i].codigo_organo+'\', \''+data.response[i].ultima_version+'\', \'pdf\');"><strong>Vista previa</strong></a><br>';



                        @if($bandeja=='firma')
                            acciones+='<a class="tx-danger" href="javascript:void(0);" onclick="avanzarFlujo('+data.response[i].id_acuerdo+', \'{{$bandeja}}\', \'regreso\', '+i+', \''+data.response[i].codigo_organo+'\', \''+data.response[i].ultima_version+'\', \'firel\', '+data.response[i].id_juicio+', \''+data.response[i].firma_notificacion.firma+'\');">A revisión</a><br>';
                        @endisset

                        @if($bandeja=='firma')
                            acciones+='<a class="tx-success" href="javascript:void(0);" onclick="avanzarFlujo('+data.response[i].id_acuerdo+', \'{{$bandeja}}\', \'avance\', '+i+', \''+data.response[i].codigo_organo+'\', \''+data.response[i].ultima_version+'\', \'firel\', '+data.response[i].id_juicio+', \''+data.response[i].firma_notificacion.firma+'\');">'; acciones+='Firmar'; acciones+='</a><br>';
                            acciones+='<input type="hidden" value="'+data.response[i].id_acuerdo+',{{$bandeja}},avance,'+i+','+data.response[i].codigo_organo+','+data.response[i].ultima_version+',firel,'+data.response[i].id_juicio+','+data.response[i].firma_notificacion.firma+'" id="avanzar_masivo_'+i+'" class="avanzar_masivo">';  
                        @else
                            acciones+='<a class="tx-success" href="javascript:void(0);" onclick="avanzarFlujo('+data.response[i].id_acuerdo+', \'{{$bandeja}}\', \'corregido\', '+i+', \''+data.response[i].codigo_organo+'\', \''+data.response[i].ultima_version+'\', \'firel\', '+data.response[i].id_juicio+', \''+data.response[i].firma_notificacion.firma+'\');">Corregido</a><br>';
                        @endisset





                        @if($bandeja!='firma')
                            acciones+='<a href="javascript:void(0);" onclick="vistaPrevia('+data.response[i].id_acuerdo+', \''+data.response[i].codigo_organo+'\',  \''+data.response[i].ultima_version+'\', \'word\');">Descargar </a><br>';
                        @endif

                        @if($bandeja!='firma')
                            acciones+='<a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="actualizarAcuerdoDocumento('+data.response[i].id_acuerdo+', \''+data.response[i].codigo_organo+'\', '+data.response[i].posicion_en_flujo[0]['id_flujo_participante']+');">Actualizar </a><br>';
                        @endif

                        if(data.response[i].id_creador=='{{$sesion['usuario_id']}}' || '{{$sesion['usuario_tipo']}}'=='juez magistrado'){
                            acciones+='<a href="javascript:void(0);" onclick="eliminarResolucion('+data.response[i].id_acuerdo+',  \'{{$bandeja}}\', \'avance\', '+i+', \''+data.response[i].codigo_organo+'\', \''+data.response[i].ultima_version+'\');">Eliminar </a><br>';
                        }


                        var resolucion=data.response[i].TocaEstado.acuerdo+'<br>'+data.response[i].TocaEstado.tipo_expediente.toUpperCase();

                        if(data.response[i].firmado_por.length != 0){
                            for(var j=0; j<data.response[i].firmado_por.length; j++){
                                resolucion+='<br><span title="'+data.response[i].firmado_por[j].nom+' '+data.response[i].firmado_por[j].ap+' '+data.response[i].firmado_por[j].am+'<br>'+data.response[i].firmado_por[j].fecha_firma+'" data-mode="above" style="font-weight: bold;">'+data.response[i].firmado_por[j].nom_clave+'</span>';
                            }
                        }
                        if(data.response[i].visibilidad=="electronica"){
                            resolucion+='<br><small><i class="fa fa-exclamation-triangle tx-warning"></i><a href="'+data.response[i].firma_notificacion.url+'" target="_blank">Notificación electrónica</a></small>';
                        }


                        var rowNode = dataTableGlobal.row.add( [ 
                            i + " " + data.response[i].fecha_1+'<br>'+data.response[i].fecha_humana+'<input type="hidden" value="'+data.response[i].id_acuerdo+','+data.response[i].codigo_organo+','+data.response[i].ultima_version+'" id="data_imprimir_'+i+'">' ,
                            ponencia,
                            resolucion,
                            partes,
                            acciones
                        ] ).draw(false).nodes().to$().addClass( 'data-row-id-'+i );
                        
                    }
                    $('span[title]').qtip({
                        content: {
                            text: false // Use each elements title attribute
                        },
                        style       : 'qtip-bootstrap'
                    });
                    
                }
            }
        });
    }
    
    function cargarFlujo(id_juicio, id_acuerdo, acuerdo_texto, bandera){
        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/acuerdo_flujo_detalles',
            data:{ id_juicio:id_juicio, id_acuerdo:id_acuerdo, acuerdo_texto,acuerdo_texto, bandera:bandera },
            success:function(data){
                $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
    }
    
    function avanzarFlujo(id_acuerdo, bandeja, accion, index, codigo_organo, ultima_version, tipo_firma, id_juicio, tipo_flujo_nombre="", sello=1){
        
        if(accion=='avance' || accion=="corregido"){
            console.log(index);

            

                if(tipo_firma=='firel' & bandeja=="firma"){
                    $('#modal_id_acuerdo').val(id_acuerdo);
                    $('#modal_bandeja').val(bandeja);
                    $('#modal_accion').val(accion);
                    $('#modal_index').val(index);
                    $('#modal_codigo_organo').val(codigo_organo);
                    $('#modal_ultima_version').val(ultima_version);
                    $('#modal_tipo_firma').val(tipo_firma);
                    $('#modal_id_juicio').val(id_juicio);
                    $('#modal_tipo_flujo_nombre').val(tipo_flujo_nombre);

                    if(sello==0){
                        $('#sello_sigj_visible').css('display', 'none');
                    }

                    //se muesstra el modal de la firel
                    $('#modal_firel').modal('show');
                }
                else{
                    /*
                    $('#modal_loading').modal({backdrop: 'static', keyboard: false})
                    $.ajax({
                        type:'POST',
                        url: "{{ route('bandeja.bandeja_avanzar_revision_ajax') }}",
                        data:{ accion:accion, id_acuerdo:id_acuerdo, codigo_organo:codigo_organo, ultima_version:ultima_version, bandeja:bandeja, tipo_firma:tipo_firma, tipo_flujo_nombre:tipo_flujo_nombre },
                        success:function(data){
                            console.log(data);

                            setTimeout(function(){
                                $('#modal_loading').modal('hide');
                            }, 500);

                            if(data.status!=0){
                                if(data.response.finalizacion_flujo=="si"){
                                    alert("La fecha de publicación es: " + data.response.fecha_a_publicar);
                                }

                                $('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);
                                $('#datatable1').find('.data-row-id-'+index).fadeOut('slow', function($row){
                                    dataTableGlobal.rows(index).remove().draw();
                                });
                            }
                            else{
                                alert('Problemas al avanzar el flujo');
                            }
                        }
                    });
                    */endif
                }
            
            
        }
        else if(accion=='regreso'){
            if(confirm('¿Esta seguro de enviar a revisión el acuerdo?')){
                $('#modal_loading').modal({backdrop: 'static', keyboard: false})
                $.ajax({
                    type:'POST',
                    url: "{{ route('bandeja.bandeja_retroceso_revision_ajax') }}",
                    data:{ id_acuerdo:id_acuerdo, id_juicio:id_juicio, codigo_organo:codigo_organo },
                    success:function(data){
                        console.log(data);
                        setTimeout(function(){
                            $('#modal_loading').modal('hide');
                        }, 500);
                        if(data.status==0){
                            alert(data.message);
                        }
                        else{
                            $('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);
                            $('#datatable1').find('.data-row-id-'+index).fadeOut('slow', function($row){
                                dataTableGlobal.rows(index).remove().draw();
                            });
                        }
                    }
                });
            }
        }   
    }

    function eliminarResolucion(id_acuerdo, bandeja, accion, index, codigo_organo, ultima_version){

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
                        $('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);
                        $('#datatable1').find('.data-row-id-'+index).fadeOut('slow', function($row){
                            dataTableGlobal.rows(index).remove().draw();
                        });
                    }
                }
            });
        }
    }

    function vistaPrevia(id_acuerdo, ponencia, id_documento, tipo_documento, flujo_id=""){
        
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})
        $.ajax({
            type:'POST',
            url: "{{ route('bandeja.documento_descargar_ajax') }}",
            data:{ id_acuerdo:id_acuerdo, ponencia:ponencia, id_documento:id_documento, tipo_documento:tipo_documento },
            success:function(data){
                
                if(data.status==100){
                    if(tipo_documento=='word' || tipo_documento=='pdf'){
                        var win = window.open(data.response, '_blank');
                    }
                    else{
                        $.ajax({
                            type:'POST',
                            url:'/bandejas/mostrarEditorHTML',
                            data:{ tipo:"acuerdo", bandeja:'{{$bandeja}}', id_acuerdo:id_acuerdo, ponencia:ponencia, id_documento:id_documento, tipo_documento:tipo_documento, flujo_id:flujo_id },
                            success:function(data){
                                if(0){

                                }
                                else{
                                    setTimeout(function(){
                                    $('#modaldemo_editar_html').find('.modal-body').html(data.plantilla_archivo_body);
                                    //$('#modaldemo_editar_html').find('.modal-header').html(data.plantilla_archivo_header);
                                    $('#modaldemo_editar_html').modal({backdrop: 'static', keyboard: false})
                                }, 500);
                                }
                            }
                        });
                    }
                }
                else{
                    alert(data.message);
                }

                setTimeout(function(){
                    $('#modal_loading').modal('hide');
                }, 800);
            }
        });
    }

    function imprimirTodo(){
        $('#modal_loading').modal({backdrop: 'static', keyboard: false})
        $.ajax({
            type:'POST',
            url: "{{ route('bandeja.documento_descargar_masivo_ajax') }}",
            data:{ bandeja:'{{$bandeja}}', expediente:$('#expediente').val(), anio_expediente:$('#anio_expediente').val(), involucrados_nombre:$('#involucrados_nombre').val(), involucrados_apellido_paterno:$('#involucrados_apellido_paterno').val(), involucrados_apellido_materno:$('#involucrados_apellido_materno').val(), tipo_acuerdo:$('#tipo_acuerdo').val(), origen_acuerdo:$('#origen_acuerdo').val(), fecha_desde:$('#fecha_desde').val(), fecha_hasta:$('#fecha_hasta').val() },
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
        }
        console.log(arr_imprimir);

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

    var arr_imprimir=Array();
    function avanzarSeleccion(todos, bandeja_global){
        var total=0;
        var bandera_firel=0;
        arr_imprimir=Array();

        if(todos==0){
            $( ".chbox_imprimir" ).each(function( index ) {
                if($(this).is(':checked')) {
                    arr_imprimir[total]=$('#avanzar_masivo_'+$(this).val()).val();
                    total++;
                }
            });
        }
        else{
            $( ".chbox_imprimir" ).each(function( index ) {
                arr_imprimir[total]=$('#avanzar_masivo_'+$(this).val()).val();
                total++;
            });
            $('input[name="select_all"]').click();
        }
        console.log(arr_imprimir);
        console.log(arr_imprimir.length);
        
        if(arr_imprimir.length!=0){
            //se revisan
            if(bandeja_global=='revision'){
                if(confirm('¿Esta seguro de autorizar los acuerdos?')){
                    procesado=0;

                    $('#modal_loading').modal({backdrop: 'static', keyboard: false});
                    $('#modal_loading').find('#mensaje_procesos').html('Procesando '+procesado+' de ' + total);
                    
                    for(i=0; i<arr_imprimir.length; i++){
                        
                        //se obtienen los datos
                        arr_acuerdos=arr_imprimir[i].split(',');
                        console.log(arr_acuerdos);

                        id_acuerdo=arr_acuerdos[0];
                        bandeja=arr_acuerdos[1];
                        index=arr_acuerdos[3];
                        codigo_organo=arr_acuerdos[4];
                        ultima_version=arr_acuerdos[5];
                        tipo_firma="sicor";
                        if(arr_acuerdos[6]!=""){
                            tipo_firma=arr_acuerdos[6];
                        }
                        id_juicio=arr_acuerdos[7];
                        tipo_flujo_nombre=arr_acuerdos[8];

                        $.ajax({
                            type:'POST',
                            url: "{{ route('bandeja.bandeja_avanzar_revision_ajax') }}",
                            data:{ id_acuerdo:arr_acuerdos[0], codigo_organo:codigo_organo, ultima_version:ultima_version, bandeja:bandeja, tipo_firma:tipo_firma, index:index, id_juicio:id_juicio, tipo_flujo_nombre:tipo_flujo_nombre },
                            success:function(data){
                                procesado++;

                                //mensajes para el usuario
                                $('#modal_loading').find('#mensaje_procesos').html('Procesando '+procesado+' de ' + total);
                                $('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);

                                if(procesado==arr_imprimir.length){
                                    setTimeout(function(){
                                        dataTableGlobal.rows('.selected').remove().draw();
                                        $('#modal_loading').modal('hide');
                                    }, 2000);
                                }
                            }
                        });
                        
                    }
                }
            }
            //se firman
            else{
                console.log('Se firma');
                if(confirm('¿Esta seguro de firmar los acuerdos?')){
                    procesado=0;
                    var textoPublicacion="";
                    var bandera_firel=false;


                    for(i=0; i<arr_imprimir.length; i++){
                        arr_acuerdos=arr_imprimir[i].split(',');
                        if(arr_acuerdos[6]=='firel'){
                            console.log('Se encontro firel');
                            bandera_firel=true;
                            id_acuerdo=arr_acuerdos[0];
                            bandeja=arr_acuerdos[1];
                            accion=arr_acuerdos[2];
                            index=arr_acuerdos[3];
                            codigo_organo=arr_acuerdos[4];
                            ultima_version=arr_acuerdos[5];
                            tipo_firma=arr_acuerdos[6];
                            id_juicio=arr_acuerdos[7];
                            tipo_flujo_nombre=arr_acuerdos[8];
                        }
                    }

                    if(bandera_firel==true){
                        $('#modal_masivo').val(1);
                        $('#modal_firel').modal('show');
                    }
                    else{
                        procesarMasivoFirmas();
                    }
                }
            }
        }
        else{
            alert('Debe de seleccionar al menos un documento');
        }
    }

    function procesarMasivoFirmas(){
        procesado=0;
        total=arr_imprimir.length;
        textoPublicacion="";
        
        $('#modal_loading').modal({backdrop: 'static', keyboard: false});
        $('#modal_loading').find('#mensaje_procesos').html('Procesando '+procesado+' de ' + total);
        
        for(i=0; i<arr_imprimir.length; i++){
            
            //se obtienen los datos
            arr_acuerdos=arr_imprimir[i].split(',');
            console.log(arr_acuerdos);

            id_acuerdo=arr_acuerdos[0];
            bandeja=arr_acuerdos[1];
            accion=arr_acuerdos[2];
            index=arr_acuerdos[3];
            codigo_organo=arr_acuerdos[4];
            ultima_version=arr_acuerdos[5];
            tipo_firma="sicor";
            if(arr_acuerdos[6]!=""){
                tipo_firma=arr_acuerdos[6];
            }
            id_juicio=arr_acuerdos[7];
            tipo_flujo_nombre=arr_acuerdos[8];

            if(tipo_firma=="sicor"){
                console.log('Se firma Sicor');
                $.ajax({
                    type:'POST',
                    url: "{{ route('bandeja.bandeja_avanzar_revision_ajax') }}",
                    data:{ id_acuerdo:id_acuerdo, codigo_organo:codigo_organo, ultima_version:ultima_version, bandeja:bandeja, tipo_firma:tipo_firma, index:index, id_juicio:id_juicio, tipo_flujo_nombre:tipo_flujo_nombre, accion:accion },
                    success:function(data){
                        console.log(data);
                        procesado++;

                        //mensajes para el usuario
                        $('#modal_loading').find('#mensaje_procesos').html('Procesando '+procesado+' de ' + total);
                        $('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);

                        if(data.response.finalizacion_flujo=="si"){
                            textoPublicacion = "La fecha de publicación de algunos acuerdos es: " + data.response.fecha_a_publicar+"\nFavor de consultarlo en Próximas publicaciones.";
                        }

                        if(procesado==arr_imprimir.length){
                            setTimeout(function(){
                                dataTableGlobal.rows('.selected').remove().draw();
                                $('#modal_loading').modal('hide');

                                if(textoPublicacion!=""){
                                    alert(textoPublicacion);
                                }
                            }, 2000);
                        }
                    }
                });
            }else{

                console.log('Se firma FIREL');
                $('#modal_id_acuerdo').val(id_acuerdo);
                $('#modal_bandeja').val(bandeja);
                $('#modal_accion').val(accion);
                $('#modal_index').val(index);
                $('#modal_codigo_organo').val(codigo_organo);
                $('#modal_ultima_version').val(ultima_version);
                $('#modal_tipo_firma').val(tipo_firma);
                $('#modal_id_juicio').val(id_juicio);
                $('#modal_tipo_flujo_nombre').val(tipo_flujo_nombre);


                $('#sello_sigj_visible').css('display', 'none');


                jQuery.ajax({
                    type: 'POST',
                    url:"{{ route('bandeja.bandeja_firmar_firel_ajax') }}",
                    data: new FormData($("#form_firma_firel")[0]),
                    processData: false, 
                    contentType: false, 
                    success: function(data) {
                        console.log(data);
                        procesado++;
                        
                        if(data.error==1){
                            alert(data.mensaje);
                        }
                        else{
                            bandeja=$('#modal_bandeja').val();
                            $('#modal_loading').find('#mensaje_procesos').html('Procesando '+procesado+' de ' + total);
                            $('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);

                            if(data.response.finalizacion_flujo=="si"){
                                textoPublicacion = "La fecha de publicación de algunos acuerdos es: " + data.response.fecha_a_publicar+"\nFavor de consultarlo en Próximas publicaciones.";
                            }


                            if(procesado==arr_imprimir.length){
                                setTimeout(function(){
                                    dataTableGlobal.rows('.selected').remove().draw();
                                    $('#modal_loading').modal('hide');

                                    if(textoPublicacion!=""){
                                        alert(textoPublicacion);
                                    }
                                }, 2000);
                            }
                        }
                    }
                });
            }
            
            

        }
    }

    function procesarFirel(){

        if($('#modal_masivo').val()==0){
            console.log('Es individual');

            
            //manejo de modales
            $('#modal_firel').modal('hide');
            $('#modal_loading').modal({backdrop: 'static', keyboard: false});

            jQuery.ajax({
                type: 'POST',
                url:"{{ route('bandeja.bandeja_firmar_firel_ajax') }}",
                data: new FormData($("#form_firma_firel")[0]),
                processData: false, 
                contentType: false,
                async: true,
                success: function(data) {
                    console.log(data);
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);
                    
                    
                    if(data.error==1){
                        alert(data.mensaje);
                    }
                    else{
                        if(data.response.finalizacion_flujo=="si"){
                            alert("La fecha de publicación es: " + data.response.fecha_a_publicar);
                        }
                        bandeja=$('#modal_bandeja').val();
                        index=$('#modal_index').val();

                        $('#bandejas_sicor').find('#'+bandeja).html($('#bandejas_sicor').find('#'+bandeja).html()-1);
                        $('#datatable1').find('.data-row-id-'+index).fadeOut('slow', function($row){
                            dataTableGlobal.rows(index).remove().draw();
                        });
                    }
                }
            });
        }
        else{
            console.log('se manda al masivo');
            $('#modal_firel').modal('hide');
            procesarMasivoFirmas();
        }
    }

    $('input[name="archivo_pfx"]').on('change', function(){
      var ext = $( this ).val().split('.').pop();
      if ($( this ).val() != '') {
      }
    });
    
    function seleccionarCredenciales(tipo){
        if(tipo=="firel"){
            $('#id_pfx').css("display", "block");
            $('#id_key').css("display", "none");
            $('#id_cert').css("display", "none");
            $('#id_contrasenia').css("display", "block");
        }
        else if(tipo=="fiel"){
            $('#id_pfx').css("display", "none");
            $('#id_key').css("display", "block");
            $('#id_cert').css("display", "block");
            $('#id_contrasenia').css("display", "block");
        }
        else{
            $('#id_pfx').css("display", "none");
            $('#id_key').css("display", "none");
            $('#id_cert').css("display", "none");
            $('#id_contrasenia').css("display", "none");
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


  <!-- LARGE MODAL -->
<div id="modaldemo4" class="modal fade" style="width: 95%;">
    <div class="modal-dialog modal-dialog-vertical-center" role="document" >
        <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agrega un usuario al flujo </h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pd-20">

        </div><!-- modal-body -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalUsuarios">Cerrar</button>
        </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

  <!-- LARGE MODAL -->
<div id="modal_firel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-lg modal-dialog-vertical-center modal-dialog-centered" role="document" style="width: 95%;">
      <div class="modal-content tx-size-sm" >
        <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Firma del documento</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pd-20">
            <form id="form_firma_firel" enctype="multipart/form-data" method="post">

                <input type="hidden" value="" name="modal_id_acuerdo" id="modal_id_acuerdo">
                <input type="hidden" value="" name="modal_bandeja" id="modal_bandeja">
                <input type="hidden" value="" name="modal_accion" id="modal_accion">
                <input type="hidden" value="" name="modal_index" id="modal_index">
                <input type="hidden" value="" name="modal_codigo_organo" id="modal_codigo_organo">
                <input type="hidden" value="" name="modal_ultima_version" id="modal_ultima_version">
                <input type="hidden" value="" name="modal_tipo_firma" id="modal_tipo_firma">
                <input type="hidden" value="" name="modal_masivo" id="modal_masivo">
                <input type="hidden" value="" name="modal_id_juicio" id="modal_id_juicio">
                <input type="hidden" value="" name="modal_tipo_flujo_nombre" id="modal_tipo_flujo_nombre">
                
                
                
                <div class="media-body table-responsive-xl" style="">
                    <h5 class="card-profile-name">Selecciona el tipo de firma</h5>
                    <p class="card-profile-position">
                        <div class="row col-lg-12" id="">
                            <div class="col-lg-4">
                                <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="firel" checked onclick="seleccionarCredenciales('firel')">
                                  <span>Firel</span>
                                </label>
                              </div><!-- col-3 -->
                              <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="fiel" onclick="seleccionarCredenciales('fiel')">
                                  <span>E.Firma</span>
                                </label>
                              </div><!-- col-3 -->
                              <div class="col-lg-4 mg-t-20 mg-lg-t-0" id="sello_sigj_visible">
                                <label class="rdiobox">
                                  <input name="tipo_firma_firel" type="radio" id="tipo_firma_firel" value="sello_sigj" onclick="seleccionarCredenciales('sello_sigj')">
                                  <span>Sello SIGJ</span>
                                </label>
                              </div><!-- col-3 -->
                        </div>
                        <hr>

                        <div class="col-lg-12" id="id_pfx">
                            <div class="form-group">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Archivo PFX:</label>
                                <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_pfx" id="archivo_pfx" size="50" required accept=".pfx">
                                </div>
                            </div>
                        </div><!-- col-2 -->


                        <div class="col-lg-12" id="id_key" style="display: none;">
                            <div class="form-group">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Archivo KEY:</label>
                                <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_key" id="archivo_key" size="50" required accept=".key">
                                </div>
                            </div>
                        </div><!-- col-2 -->
                        <div class="col-lg-12" id="id_cert" style="display: none;">
                            <div class="form-group">
                                <label class="form-control-label" ><span class="tx-danger">*</span> Archivo CER:</label>
                                <div id="div_upload" class="field"  >
                                    <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_cer" id="archivo_cer" size="50" required accept=".cer">
                                </div>
                            </div>
                        </div><!-- col-2 -->




                        <div class="col-lg-12" id="id_contrasenia">

                            <div class="form-group">
                                <label class="form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="password" name="password" value="" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary" onclick="procesarFirel();">Firmar</button>
                        </div>
                    </p>
                    <br><br>
                </div>
            </form>
        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection