@php
    use App\Http\Controllers\clases\utilidades;
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{($bandeja=="iniciales") ? "Demandas" : "Promociones"}}</li>
    </ol>
    <h6 class="slim-pagetitle">{{($bandeja=="iniciales") ? "demandas" : "promociones"}}</h6>
@endsection


@section('contenido-principal')

        <div class="section-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="card-profile-name">Lista de {{($bandeja=="iniciales") ? "demandas" : "promociones"}}</h3>
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
                            
                                

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Día de recepción:</label>
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
                                    <label class="form-control-label">Medio de recepción:</label>
                                    
                                    
                                        <select class="form-control select2" id="medio_recepcion" name="medio_recepcion" data-placeholder="Choose one">
                                          <option value="-">TODOS</option>
                                          <option value="OPC">OPC</option>
                                          <option value="OPV">OPV</option>
                                        @if ($bandeja=="iniciales") 
                                          <option value="OPP">OPP</option>
                                          <option value="2DA_SEC">SEGUNDA SECRETARIA</option>
                                        @endif
                                          <option value="SIGJ WEB">OP/JUZGADO/INDIVIDUAL</option>
                                          <option value="SIGJ SCANER">OP/JUZGADO/QR</option> 
                                        </select>
                                      


                                </div>
                            </div><!-- col-4 -->

                            @if ($bandeja=="iniciales")
    

                                <div class="col-lg-4">
                                    <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Tipo de documento:</label>
                                        
                                        
                                            <select class="form-control select2" id="tipo_documento" name="medio_recepcion" data-placeholder="Choose one">
                                            

                                                @if($bandeja=="iniciales")
                                                <option value="INIC">TODOS</option>
                                                @else
                                                <option value="POS">TODOS</option>
                                                @endif
                                            <option value="CAUS">CAUSA ESPECIAL</option>
                                            <option value="INCO">INCOMPETENCIA</option>
                                            <option value="EXHO">EXHORTO</option>
                                            </select>
                                        


                                    </div>
                                </div><!-- col-4 -->
                            @endif

                        </div>

                            <div class="row mg-t-20">
                                <div class="col-lg-4">
                                  <label class="rdiobox">
                                    <input name="rdio" type="radio" value="t" checked >
                                    <span>Todo</span>
                                  </label>
                                </div><!-- col-3 -->
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                  <label class="rdiobox">
                                    <input name="rdio" type="radio" value="n" >
                                    <span>No confirmadas</span>
                                  </label>
                                </div><!-- col-3 -->
                                <div class="col-lg-4 mg-t-20 mg-lg-t-0">
                                  <label class="rdiobox">
                                    <input name="rdio" type="radio" value="c">
                                    <span>Confirmadas</span>
                                  </label>
                                </div><!-- col-3 -->
                              </div><!-- row -->


                            <div class="col-lg-12 mg-t-20">
                                <button class="btn btn-primary btn-block mg-b-10" onclick="accionBuscar_ajax('primera');">Buscar Promoción</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-solid alert-info" role="alert">
            En el caso de que se haya hecho el pago de las copias simples de traslado, el Órgano Jurisdiccional deberá reproducirlas, de lo contrario tendrá que exhibirlas el interesado ante el Órgano Jurisdiccional.
          </div><!-- alert -->

        

        <div class="table-wrapper">

                @isset($lista['response_pag']['pagina_actual'])
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
                @endisset

            <table id="datatable1" class="table display responsive nowrap">
                <thead>
                <tr>
                    <th class="wd-20p romperCadena">Fecha de recepción</th>
                    <th class="wd-40p">{{$request->lang['Toca']}} / Tipo</th>
                    <th class="wd-10p romperCadena">Partes</th>
                    <th class="wd-25p">Archivos</th>
                    <th class="wd-20p">Acciones</th>
                </tr>
                </thead>
                <tbody>

                   
                @isset($lista["response"])
                
                
                    @php $i=0; @endphp
                    
                    @foreach ($lista["response"] as $resolucion)
                       <tr class="data-row-id-{{$i}}">
                        <td class="romperCadena">
                            @php $fecha_arr=explode(' ', $resolucion['fecha_recepcion']); $fecha_arr_1=explode(' ', $resolucion['fecha_recepcion']); @endphp
                            {{$fecha_arr[0]}}<br>{{$fecha_arr_1[1]}}<br>
                            @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]); print($fechaCreacion); @endphp
                        </td>
                        <td class="romperCadena">
                            <strong>
                                @if($bandeja=="iniciales") 
                                    @if($resolucion['tipo_documento']=='CAUS')
                                        CAUSA ESPECIAL
                                    @elseif($resolucion['tipo_documento']=='INCO')
                                        INCOMPETENCIA
                                    @elseif($resolucion['tipo_documento']=='EXHO')
                                        EXHORTO
                                    @else
                                        DEMANDA
                                    @endif


                                @else 
                                    PROMOCIÓN  
                                @endif</strong><br>
                            {{$resolucion['expediente']}}<br>

                            <strong>TIPO DE JUICIO</strong><br>
                            @if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_opc"], $resolucion['tipo_expediente']) and $fecha_arr[0]>="2020-07-13")
                                <span style="color: red;">
                            @endif
                            @if($resolucion['opc_promocion_origen']=="SIGJ SCANER" or $resolucion['opc_promocion_origen']=="SIGJ WEB")
                                @isset($resolucion['datos_juicio']['juicio'][0]['accion'])
                                    {{strtoupper($resolucion['datos_juicio']['juicio'][0]['accion'])}} {{strtoupper($resolucion['datos_juicio']['juicio'][0]['materia'])}}
                                @endisset
                            @else
                                {{$resolucion['tipo_expediente_texto']}}
                            @endif
                            @if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_opc"], $resolucion['tipo_expediente']) and $fecha_arr[0]>="2020-07-13")
                                </span>
                            @endif

                            <br><strong>TIPO FORMATO</strong>
                            @if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_opc"], $resolucion['tipo_expediente']) and $fecha_arr[0]>="2020-07-13")
                                
                                @if ($resolucion['promocion_tipo_tramite_divorcio']==1)
                                    <span style="color:green;"><BR>EN LÍNEA </span>
                                @elseif($resolucion['promocion_tipo_tramite_divorcio']==2)
                                    <BR>PRESENCIAL
                                @else 
                                    <BR>PRESENCIAL
                                @endif 
                                </span>
                            @else 
                                  <BR>PRESENCIAL
                            @endif

                            <br><strong>ÁREA QUE REMITE</strong>  
                            <br>
                            @if($resolucion['opc_promocion_origen']=="SIGJ SCANER")
                                OP/JUZGADO/QR
                            @elseif($resolucion['opc_promocion_origen']=="SIGJ WEB")
                                OP/JUZGADO/INDIVIDUAL
                            @elseif($resolucion['opc_promocion_origen']=="2DA_SEC")
                                SEGUNDA SECRETARIA
                            @else
                                {{$resolucion['opc_promocion_origen']}}
                            @endif


                            @if( isset($resolucion['opc_promocion_estatus']) and $resolucion['opc_promocion_estatus'] == 0 )
                                <br><strong style='color:red;'>EXPEDIENTE CANCELADO POR EL ÁREA</strong>
                            @endif

                            @if( isset($resolucion['opc_promocion_bandera_mensaje']) and $resolucion['opc_promocion_bandera_mensaje'] != 0 )
                                @if ($resolucion['opc_promocion_bandera_mensaje']==1)
                                    <br><strong style='color:red;'>Demanda ingresada por OPV, el usuario no recibió su acuse de recepción, es probable que la demanda se encuentre duplicada en SIGJ, por lo que deberá realizar las acciones jurídicas necesarias</strong>
                                @endif
                            @endif


                        </td>
                        <td class="romperCadena">
                            @php $banderaActor=$banderaDemandado=$banderaPromovente=0 @endphp

                            @if($resolucion['opc_promocion_origen']=="SIGJ SCANER" or $resolucion['opc_promocion_origen']=="SIGJ WEB")
                               
                                @foreach($resolucion['datos_juicio']['partes'] AS $parte )
                                    @if($parte['parte_tipo']=="actor" and $parte['parte_promovente']=="0" and $banderaActor==0)
                                        @if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_opc"], $resolucion['tipo_expediente']))
                                            <strong>INTERESADOS</strong><br>
                                        @else
                                            <strong>ACTOR</strong><br>
                                        @endif
                                        @php $banderaActor=1; @endphp
                                    @elseif($parte['parte_tipo']=="demandado" and $parte['parte_promovente']=="0" and trim($parte['parte_nombres'])!="" and $banderaDemandado==0)
                                        <strong>DEMANDADO</strong><br>
                                        @php $banderaDemandado=1; @endphp 
                                    @elseif($parte['parte_promovente']=="1" and $banderaPromovente==0)
                                        <strong>PROMOVENTE</strong><br>
                                        @php $banderaPromovente=1; @endphp 
                                    @endif

                                    <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{($parte['parte_nombres'] == "-") ? "" : $parte['parte_nombres']}} {{($parte['parte_apellido_paterno'] == "-") ? "" : $parte['parte_apellido_paterno']}} {{($parte['parte_apellido_materno'] == "-") ? "" : $parte['parte_apellido_materno']}}@if($parte['parte_correo']!="" and $parte['parte_correo']!="-")<br><a href="mailto:{{$parte['parte_correo']}}">{{$parte['parte_correo']}}</a>@endif</div>

                                @endforeach


                            @else
                                @if($resolucion['opc_promocion_nombreCapturista']!='')
                                        <strong>PROMOVENTE</strong><br>
                                    <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$resolucion['opc_promocion_nombreCapturista']}}@if($resolucion['opc_promocion_emailCapturista']!="")<br><a href="mailto:{{$resolucion['opc_promocion_emailCapturista']}}">{{$resolucion['opc_promocion_emailCapturista']}}</a><br>@endif @if($resolucion['opc_promocion_telefonoCapturista']!=""){{$resolucion['opc_promocion_telefonoCapturista']}}@endif</div>
                                @endif


                                @isset($resolucion["partess"]) 
                                    @foreach ($resolucion['partess'] as $parte)
                                        @if($parte['parte_promocion_tipo']=='actor')
                                            @if($banderaActor==0)
                                                @if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_opc"], $resolucion['tipo_expediente']))
                                                    <strong>INTERESADOS</strong><br>
                                                @else
                                                    <strong>ACTOR</strong><br>
                                                @endif

                                                @php $banderaActor=1; @endphp
                                            @endif

                                            
                                            
                                            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{($parte['parte_promocion_nombres'] == "-") ? "" : $parte['parte_promocion_nombres']}} {{($parte['parte_promocion_apellido_paterno'] == "-") ? "" : $parte['parte_promocion_apellido_paterno']}} {{($parte['parte_promocion_apellido_materno'] == "-") ? "" : $parte['parte_promocion_apellido_materno']}}@if($parte['parte_promocion_correo']!="" and $parte['parte_promocion_correo']!="-")<br><a href="mailto:{{$parte['parte_promocion_correo']}}">{{$parte['parte_promocion_correo']}}</a>@endif</div>
                                        @endif
                                    @endforeach

                                    @foreach ($resolucion['partess'] as $parte)
                                        @if($parte['parte_promocion_tipo']=='demandado')
                                            @if($banderaDemandado==0)
                                                <strong>DEMANDADO</strong><br>
                                                @php $banderaDemandado=1; @endphp 
                                            @endif
                                            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['parte_promocion_nombres']}} {{$parte['parte_promocion_apellido_paterno']}} {{$parte['parte_promocion_apellido_materno']}}@if($parte['parte_promocion_correo']!="" and $parte['parte_promocion_correo']!="-")<br><a href="mailto:{{$parte['parte_promocion_correo']}}">{{$parte['parte_promocion_correo']}}</a>@endif</div>
                                        @endif
                                    @endforeach
                                    
                                @endisset
                            @endif
                        </td>
                        <td class="romperCadena">
                            @if($resolucion['opc_promocion_estatus']==1)
                                @if($resolucion['id_juicio']=="" and ($resolucion['tipo_expediente']!=357 and $resolucion['tipo_expediente']!=358 and $resolucion['tipo_expediente']!=360) and $resolucion['opc_promocion_origen']=="OPC")
                                    @if($bandeja=="iniciales")
                                        @if($resolucion['opc_promocion_origen']=="OPC") 
                                            El documento llegará de forma física mediante OPC, en caso de existir un digital usted podrá visualizar los documentos una vez que haya creado el expediente en SICOR y confirmado en el SIGJ. 
                                        @else
                                            En caso de existir el expediente en SICOR, solo confirme en el SIGJ
                                        @endif
                                    @else
                                        En caso de existir el expediente en SICOR, solo confirme en el SIGJ

                                    @endif
                                    
                                @else
                                    @if($resolucion['id_juicio']=="" and $resolucion['promocion_tipo_tramite_divorcio']!=1)
                                        @if($bandeja=="iniciales")
                                            @if($resolucion['opc_promocion_origen']=="OPC") 
                                                El documento llegará de forma física mediante OPC, en caso de existir un digital usted podrá visualizar los documentos una vez que haya creado el expediente en SICOR y confirmado en el SIGJ. 
                                            @else
                                                En caso de existir el expediente en SICOR, solo confirme en el SIGJ
                                            @endif
                                        @else
                                            En caso de existir el expediente en SICOR, solo confirme en el SIGJ
                                        @endif

                                    @else 
                                        @php $adjuntos_int=0 @endphp
                                        @if(count($resolucion['adjuntos'])==0)
                                            @if($bandeja=="iniciales")
                                                La demanda la recibirá físicamente 
                                            @else
                                                La promoción la recibirá físicamente
                                            @endif
                                        @else
                                            @foreach($resolucion['adjuntos'] as $adjuntos)
                                                @isset($adjuntos['json_arr']->idDocument)
                                                    @if($adjuntos_int==0)
                                                        <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});" ><span title="Comentarios: @isset($adjuntos['json_arr']->observaciones) {{$adjuntos['json_arr']->observaciones}} @else No hay observaciones @endif">@if(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_opc"], $resolucion['tipo_expediente']))Solicitud @else @if($bandeja=="iniciales") Demanda @else Promoción  @endif @endif</span></a>
                                                    @else
                                                        <br><a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});"><span title="Comentarios: @isset($adjuntos['json_arr']->observaciones) {{$adjuntos['json_arr']->observaciones}} @else No hay observaciones @endif">Adjunto {{$adjuntos_int}}</span></a>
                                                    @endif

                                                    @php $adjuntos_int++; @endphp 
                                                @endisset
                                            @endforeach
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </td>
                        <td class="romperCadena">
                            @if($request->session()->get('juzgado_subtipo')=="JFO" or 1) 
                                @if($resolucion['confirmado']=='no confirmado')
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="confirmarPromocion({{$resolucion['id_promocion']}}, '{{$resolucion['expediente']}}', '{{$resolucion['tipo_expediente']}}', '{{$resolucion['promocion_tipo_tramite_divorcio']}}', '{{$fecha_arr[0]}}', '{{$resolucion['opc_promocion_origen']}}');"><strong style="text-decoration: underline;">Por confirmar</strong></a>
                                @else
                                    Confirmada

                                    {{-- <a href="/acuerdo_detalles/{{$resolucion['id_juicio']}}">Confirmada</a> --}}
                                @endif
                                @if (!(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_opc"], $resolucion['tipo_expediente'])))
                                    <!--
                                    <br><small><a href="javascript:void(0);">No se ha pagado el traslado de copias</a></small>
                                    -->
                                @endif
                            @endif
                        </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                @endisset
                
                </tbody>
            </table>


            @isset($lista['response_pag']['pagina_actual'])
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
            @endisset



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
 

    function confirmarPromocion(promocion_id, expediente, tipo_juicio_id, promocion_tipo_tramite_divorcio, fecha, origen){
        $('#modaldemo3').find('.modal-header').html('');
        $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
        $.ajax({
            type:'POST',
            url:'/promociones/buscarExpediente',
            data:{ promocion_id:promocion_id, expediente:expediente, tipo_juicio_id:tipo_juicio_id, promocion_tipo_tramite_divorcio:promocion_tipo_tramite_divorcio, fecha:fecha, origen:origen },
            success:function(data){
                console.log(data);
                $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
                $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
            }
        });
    }

    function guardarConfirmacion(juicio_id, promocion_id){

        if(confirm('¿Esta seguro de incluir en el archivo?')){
            $.ajax({
                type:'POST',
                url:'/promociones/guardarAsignacion',
                data:{ promocion_id:promocion_id, juicio_id:juicio_id },
                success:function(data){
                    console.log(data);
                    location.reload();
                }
            });
        }
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
            pageLength: 10
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



            medio_recepcion=$('#medio_recepcion').val();
            tipo_documento=$('#tipo_documento').val();
 
            $('#modal_loading').modal({backdrop: 'static', keyboard: false})
            
            var tipo = $("input[name='rdio']:checked").val();
            var fecha = ($("input[name=fecha]").val()=="") ? "-" : $("input[name=fecha]").val();

            $.ajax({
                type:'POST',
                url:'/promociones/buscarPromocionAjax',
                data:{pagina:pagina, registros_por_pagina:registros_por_pagina, medio_recepcion:medio_recepcion, tipo_documento:tipo_documento, bandeja:'{{$bandeja}}', 
                    tipo:tipo, 
                    fecha:fecha
                
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
                            var partes="";

                            if(data.response[i]['opc_promocion_origen']=="SIGJ SCANER" || data.response[i]['opc_promocion_origen']=="SIGJ WEB"){

                                bandera_titulo_1=bandera_titulo_2=bandera_titulo_3=0;
                                for($j=0; $j<data.response[i]['datos_juicio']['partes'].length; $j++){
                                    
                                    if(data.response[i]['datos_juicio']['partes'][$j]['parte_nombres']==null) data.response[i]['datos_juicio']['partes'][$j]['parte_nombres']="";
                                    if(data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_paterno']==null) data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_paterno']="";
                                    if(data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_materno']==null) data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_materno']="";

                                    if(data.response[i]['datos_juicio']['partes'][$j]['parte_nombres']=="-") data.response[i]['datos_juicio']['partes'][$j]['parte_nombres']="";
                                    if(data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_paterno']=="-") data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_paterno']="";
                                    if(data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_materno']=="-") data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_materno']="";



                                    if(data.response[i]['datos_juicio']['partes'][$j]['parte_tipo']=="actor" && data.response[i]['datos_juicio']['partes'][$j]['parte_nombres']!="" && data.response[i]['datos_juicio']['partes'][$j]['parte_promovente']=="0" && bandera_titulo_1==0){
                                        if(data.response[i]['tipo_expediente']==357 || data.response[i]['tipo_expediente']==358 || data.response[i]['tipo_expediente']==360){
                                            partes+="<strong>INTERESADOS</strong><br>";
                                        }
                                        else{
                                            partes+="<strong>ACTOR</strong><br>";
                                        }
                                        bandera_titulo_1=1;
                                    }
                                    else if(data.response[i]['datos_juicio']['partes'][$j]['parte_tipo']=="demandado" && data.response[i]['datos_juicio']['partes'][$j]['parte_nombres']!="" && data.response[i]['datos_juicio']['partes'][$j]['parte_promovente']=="0" && bandera_titulo_2==0){
                                        partes+="<strong>DEMANDADO</strong><br>";
                                        bandera_titulo_2=1;
                                    }
                                    else if(data.response[i]['datos_juicio']['partes'][$j]['parte_promovente']=="1" && data.response[i]['datos_juicio']['partes'][$j]['parte_nombres']!="" && bandera_titulo_3==0){
                                        partes+="<strong>PROMOVENTE</strong><br>";
                                        bandera_titulo_3=1;
                                    }

                                    

                                    partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i]['datos_juicio']['partes'][$j]['parte_nombres']+' '+data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_paterno']+' '+data.response[i]['datos_juicio']['partes'][$j]['parte_apellido_materno']+'</div>';
                                }
                            }
                            else{
                                if(data.response[i]['opc_promocion_nombreCapturista']!=null){
                                    partes+="<strong>PROMOVENTE</strong><br>";
                                    partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i]['opc_promocion_nombreCapturista']+'<br><a href="mailto:'+data.response[i]['opc_promocion_emailCapturista']+'">'+data.response[i]['opc_promocion_emailCapturista']+'</a><br>'+data.response[i]['opc_promocion_telefonoCapturista']+'</div>';
                                }

                                bandera_titulo=0;
                                for(var j=0; j<data.response[i].partess.length; j++){
                                    if(data.response[i].partess[j].parte_promocion_tipo=="actor"){
                                        if(bandera_titulo==0){
                                            if(data.response[i]['tipo_expediente']==357 || data.response[i]['tipo_expediente']==358 || data.response[i]['tipo_expediente']==360){
                                                partes+="<strong>INTERESADOS</strong><br>";
                                            }
                                            else{
                                                partes+="<strong>ACTOR</strong><br>";
                                            }
                                            bandera_titulo=1;
                                        }
                                        if(data.response[i].partess[j]['parte_promocion_apellido_paterno']==null) data.response[i].partess[j]['parte_promocion_apellido_paterno']="";
                                        if(data.response[i].partess[j]['parte_promocion_apellido_materno']==null) data.response[i].partess[j]['parte_promocion_apellido_materno']="";

                                        partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].partess[j]['parte_promocion_nombres']+' '+data.response[i].partess[j]['parte_promocion_apellido_paterno']+' '+data.response[i].partess[j]['parte_promocion_apellido_materno']+'</div>';
                                    }
                                }

                                bandera_titulo=0;
                                for(var j=0; j<data.response[i].partess.length; j++){
                                    if(data.response[i].partess[j].parte_promocion_tipo=="demandado"){
                                        if(bandera_titulo==0){
                                            partes+="<strong>DEMANDADO</strong><br>";
                                            bandera_titulo=1;
                                        }

                                        if(data.response[i].partess[j]['parte_promocion_apellido_paterno']==null) data.response[i].partess[j]['parte_promocion_apellido_paterno']="";
                                        if(data.response[i].partess[j]['parte_promocion_apellido_materno']==null) data.response[i].partess[j]['parte_promocion_apellido_materno']="";

                                        partes+='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'+data.response[i].partess[j]['parte_promocion_nombres']+' '+data.response[i].partess[j]['parte_promocion_apellido_paterno']+' '+data.response[i].partess[j]['parte_promocion_apellido_materno']+'</div>';
                                    }
                                }
                            }


                            @if($request->session()->get('juzgado_subtipo')=="JFO" or 1)
                            if(data.response[i].confirmado=='no confirmado'){
                                acciones='<a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="confirmarPromocion('+data.response[i].id_promocion+', \''+data.response[i].expediente+'\', '+data.response[i].tipo_expediente+', '+data.response[i]['promocion_tipo_tramite_divorcio']+', \''+data.response[i].fecha_1+'\', \''+data.response[i]['opc_promocion_origen']+'\');"><strong style="text-decoration: underline;">Por confirmar</strong></a>'; 
                            }
                            else{
                                //acciones='<a href="/acuerdo_detalles/'+data.response[i].id_juicio+'">Confirmada</a>';
                                acciones='Confirmada';
                            }
                            @endif

                            documentos='';
                            bandera_titulo=0;




                            if(data.response[i].opc_promocion_estatus==1){
                                if(data.response[i].id_juicio==null && data.response[i]['tipo_expediente']!=357 && data.response[i]['tipo_expediente']!=358 && data.response[i]['tipo_expediente']!=360){
                                    @if($bandeja=="iniciales")
                                        if(data.response[i].opc_promocion_origen=="OPC"){
                                            documentos='El documento llegará de forma física mediante OPC, en caso de existir un digital usted podrá visualizar los documentos una vez que haya creado el expediente en SICOR y confirmado en el SIGJ.';
                                        }
                                        else{
                                            documentos='En caso de existir el expediente en SICOR, solo confirme en el SIGJ.';
                                        }
                                    @else
                                       documentos='En caso de existir el expediente en SICOR, solo confirme en el SIGJ.';
                                    @endif
                                }
                                else{ 
                                    if(data.response[i].id_juicio==null && data.response[i]['promocion_tipo_tramite_divorcio']!=1){
                                        @if($bandeja=="iniciales")
                                            if(data.response[i].opc_promocion_origen=="OPC"){
                                                documentos='El documento llegará de forma física mediante OPC, en caso de existir un digital usted podrá visualizar los documentos una vez que haya creado el expediente en SICOR y confirmado en el SIGJ.';
                                            }
                                            else{
                                                documentos='En caso de existir el expediente en SICOR, solo confirme en el SIGJ.';
                                            }
                                        @else
                                        documentos='En caso de existir el expediente en SICOR, solo confirme en el SIGJ.';
                                        @endif
                                    }
                                    else{
                                        if(data.response[i].adjuntos.length==0){
                                            @if($bandeja=="iniciales")
                                                documentos='La demanda la recibirá físicamente';
                                            @else
                                                documentos='La promoción la recibirá físicamente';
                                            @endif
                                        }
                                        else{ 

                                            for(var j=0; j<data.response[i].adjuntos.length; j++){
                                                if(typeof(data.response[i].adjuntos[j]['json_arr']) !== "undefined" && data.response[i].adjuntos[j]['json_arr'] !== null ){
                                                    if(bandera_titulo==0){
                                                        if((data.response[i]['tipo_expediente']==357 || data.response[i]['tipo_expediente']==358 || data.response[i]['tipo_expediente']==360)){
                                                            documentos+='<a href="javascript:void(0);" onclick="openDocumentoGestor('+data.response[i].adjuntos[j]['json_arr'].idDocument+');" > @if($bandeja=="iniciales") Solicitud @else Promoción  @endif</a>';
                                                        }
                                                        else{
                                                            documentos+='<a href="javascript:void(0);" onclick="openDocumentoGestor('+data.response[i].adjuntos[j]['json_arr'].idDocument+');" > @if($bandeja=="iniciales") Demanda @else Promoción  @endif</a>';
                                                        }
                                                        bandera_titulo=1;
                                                    } 
                                                    else{
                                                        documentos+='<br><a href="javascript:void(0);" onclick="openDocumentoGestor('+data.response[i].adjuntos[j]['json_arr'].idDocument+');" >Adjunto '+j+'</a>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }


                                            



                            expediente_txt='<strong>'; 

                            @if($bandeja=="iniciales") 

                                if(data.response[i]['tipo_documento']=="CAUS"){
                                    expediente_txt+="CAUSA ESPECIAL";
                                }
                                else if(data.response[i]['tipo_documento']=="INCO"){
                                    expediente_txt+="INCOMPETENCIA";
                                }
                                else if(data.response[i]['tipo_documento']=="EXHO"){
                                    expediente_txt+="EXHORTO";
                                }
                                else{
                                    expediente_txt+='DEMANDA'; 
                                }

                            @else 
                                expediente_txt+='PROMOCIÓN';  
                            @endif 
                            
                            expediente_txt+='</strong><br>';
                            expediente_txt+=data.response[i].expediente+'<br><strong>TIPO DE JUICIO</strong><br>';

                            if((data.response[i]['tipo_expediente']==357 || data.response[i]['tipo_expediente']==358 || data.response[i]['tipo_expediente']==360) && data.response[i].fecha_1>="2020-07-13"){
                                expediente_txt+='<span style="color: red;">';
                            }

                            /*
                            if(data.response[i]['opc_promocion_origen']=="SIGJ SCANER" || data.response[i]['opc_promocion_origen']=="SIGJ WEB"){
                                if(typeof data.response[i].datos_juicio.juicio[0].accion !== 'undefined'){
                                    expediente_txt+=data.response[i].datos_juicio.juicio[0].accion.toUpperCase() +" "+data.response[i].datos_juicio.juicio[0].materia.toUpperCase() ;
                                }
                            }
                            else{
                                expediente_txt+=data.response[i].tipo_expediente_texto;
                            }
                            */
                            expediente_txt+=data.response[i].tipo_expediente_texto;
                            
                            if((data.response[i]['tipo_expediente']==357 || data.response[i]['tipo_expediente']==358 || data.response[i]['tipo_expediente']==360) && data.response[i].fecha_1>="2020-07-13"){
                                expediente_txt+='</span>';
                            }

                            expediente_txt+='<br><strong>TIPO FORMATO</strong>';
                            if((data.response[i]['tipo_expediente']==357 || data.response[i]['tipo_expediente']==358 || data.response[i]['tipo_expediente']==360) && data.response[i].fecha_1>="2020-07-13"){
                                expediente_txt+='';
                                if(data.response[i]['promocion_tipo_tramite_divorcio']==1){
                                    expediente_txt+='<BR><span style="color:green;">EN LÍNEA</span>';
                                }
                                else{
                                    expediente_txt+='<BR>PRESENCIAL';
                                }
                            }
                            else{
                                expediente_txt+='<BR>PRESENCIAL';
                            }

                            expediente_txt+='<br><strong>ÁREA QUE REMITE</strong><br>';
                            

                            if(data.response[i]['opc_promocion_origen']=="SIGJ SCANER"){
                                expediente_txt+="OP/JUZGADO/QR";
                            }
                            else if(data.response[i]['opc_promocion_origen']=="SIGJ WEB"){
                                expediente_txt+="OP/JUZGADO/INDIVIDUAL";
                            }
                            else if(data.response[i]['opc_promocion_origen']=="2DA_SEC"){
                                expediente_txt+="SEGUNDA SECRETARIA";
                            }
                            else{
                                expediente_txt+=data.response[i]['opc_promocion_origen'];
                            }


                            if( data.response[i]['opc_promocion_estatus'] == 0 ){
                                expediente_txt+='<br><strong style="color:red;"">EXPEDIENTE CANCELADO POR EL ÁREA</strong>';                            
                            }

                            if( data.response[i]['opc_promocion_bandera_mensaje'] == 1 ){
                                expediente_txt+='<br><strong style="color:red;"">Demanda ingresada por OPV, el usuario no recibió su acuse de recepción, es probable que la demanda se encuentre duplicada en SIGJ, por lo que deberá realizar las acciones jurídicas necesarias</strong>';                            
                            }


                            var res = data.response[i].fecha_creacion.split(" ");
                            

                            var rowNode = dataTableGlobal.row.add( [ 
                                data.response[i].fecha_1+'<br>'+data.response[i].fecha_2+'<br>'+data.response[i].fecha_humana ,
                                expediente_txt,
                                partes,
                                documentos,
                                acciones
                            ] ).draw(false).nodes().to$().addClass( 'data-row-id-'+i);
                        }
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