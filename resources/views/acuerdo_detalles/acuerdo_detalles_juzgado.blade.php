@php
  use App\Http\Controllers\clases\utilidades;
  use App\Http\Controllers\clases\humanRelativeDate;
  $humanRelativeDate = new humanRelativeDate();
  $bandera_vs=0;
@endphp

@extends('layouts.index')

@section('contenido-pageheader')
    <ol class="breadcrumb slim-breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Resumen {{$request->lang['toca']}}</li>
    </ol>
    <h6 class="slim-pagetitle">Resumen {{$request->lang['toca']}}</h6>
@endsection

@section('contenido-principal')

@if($error!="")
    <div class="alert alert-danger mg-b-0" role="alert">
      <strong>ALERTA</strong> {{$error}}
    </div><!-- alert -->
@endif
@if($request->session()->has('success'))
    <div class="alert alert-success mg-b-0" role="alert">
      <strong>ALERTA</strong> {!! $request->session()->get('success') !!}
    </div><!-- alert -->
@endif
<script>
  var texto_check_disable="";
  var arr_check_disable=[];
  var arr_checked=[];
</script>

    <div class="section-wrapper" style="max-width: 850px;" >
      
        <div class="table-wrapper" >
          
          <div class="media-body">
            <h3 class="card-profile-name">Resoluciones del {{utilidades::acomodarTipoExpedienteTxt($archivo_detalle['response'][0]['datos_archivo']['tipo_expediente'])}} {{$archivo_detalle['response'][0]['datos_archivo']['expediente']}}/{{$archivo_detalle['response'][0]['datos_archivo']['anio']}}@if($archivo_detalle['response'][0]['datos_archivo']['bis']!=""){{" bis ".$archivo_detalle['response'][0]['datos_archivo']['bis']}} @endif
            <small>@if($archivo_detalle['response'][0]['datos_archivo']['tipo_juicio_int']==1) en línea @else presencial @endif</small>
            </h3>
            <p class="card-profile-position">


              <div class="row">

              <div class="col" style="overflow-wrap: break-word;"> 
              

                    @php $bandera1=$bandera2=0; @endphp

                    @isset($archivo_detalle['response'][0]['partes']['actor'])
                      @php $bandera_vs=1 @endphp

                      @foreach ($archivo_detalle['response'][0]['partes']['actor'] as $parte)

                      


                        @if ((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo_detalle['response'][0]['datos_archivo']['id_catalogo_juicios'])) and $parte['parte_promovente']==0 and $bandera1==0)
                          <strong>INTERESADOS</strong><br>
                          @php $bandera1=1; @endphp

                        @elseif((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo_detalle['response'][0]['datos_archivo']['id_catalogo_juicios'])) and $parte['parte_promovente']==1 and $bandera2==0)
                          <strong>PROMOVENTE</strong><br>
                          @php $bandera2=1; @endphp
                        @elseif(!(utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo_detalle['response'][0]['datos_archivo']['id_catalogo_juicios'])) and $bandera1==0)
                          <strong>ACTOR</strong><br>
                          @php $bandera1=1; @endphp
                        @endif



                          <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['nombre']}} {{$parte['apellido_paterno']}} {{$parte['apellido_materno']}}</div>
                      @endforeach
                    @endisset
              </div>
                  
                  @if(isset($archivo_detalle['response'][0]['partes']['demandado']) and $archivo_detalle['response'][0]['partes']['demandado'][0]['nombre']!="")
                    
                    @if($bandera_vs==1)
                    <div class="col-1">
                      VS
                    </div>
                    @endif
                    <div class="col" style="overflow-wrap: break-word;">
                        <strong >DEMANDADO</strong><br>
                        @foreach ($archivo_detalle['response'][0]['partes']['demandado'] as $parte)
                            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['nombre']}} {{$parte['apellido_paterno']}} {{$parte['apellido_materno']}}</div>
                        @endforeach
                    </div>
                    @php $bandera_vs=1 @endphp

                  @endif

                  
                  @if(isset($archivo_detalle['response'][0]['partes']['tercero']) and $archivo_detalle['response'][0]['partes']['tercero'][0]['nombre']!="")
                    @if($bandera_vs==1)
                    <div class="col-1">
                      VS
                    </div>
                    @endif

                    <div class="col" style="overflow-wrap: break-word;">
                        <strong >TERCERO</strong><br>
                        @foreach ($archivo_detalle['response'][0]['partes']['tercero'] as $parte)
                            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['nombre']}} {{$parte['apellido_paterno']}} {{$parte['apellido_materno']}}</div>
                        @endforeach
                    </div>
                  @endif
                  @php $bandera_vs=1 @endphp
              </div>
            
            </p>
          </div>

        
          <div class="nav-statistics-wrapper" style="overflow-x: scroll; overflow-y: hidden;">
            <nav class="nav" style="width: 100%; ">
              <a class="nav-link active" id="pills-demandas-tab" data-toggle="pill" href="#pills-demandas" role="tab" aria-controls="pills-demandas" aria-selected="true"><h6><strong>Demandas y promociones</strong></h6></a>
              <a class="nav-link " id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="false" onclick="rebuilt_table(1);" ><h6><strong>Resoluciones y actuaciones</strong></h6></a>
              <a class="nav-link" id="pills-asuntos-tab" data-toggle="pill" href="#pills-asuntos" role="tab" aria-controls="pills-asuntos" aria-selected="false" onclick="rebuilt_table(2);"><h6><strong>Documentos relacionados</strong></h6></a>
              <a href="javascript:void(0);"  class="nav-link" id="pills-expediente-tab"  role="tab" aria-controls="pills-profile" aria-selected="false" data-toggle="modal" data-target="#modaldemo5" onclick="expediente_digital();"><h6><strong>Expediente digital</strong></h6></a>
            </nav>
          </div><!-- nav-statistics-wrapper -->

          <div class="tab-content" id="pills-tabContent">
            
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            

            <a href="javascript:void(0)" onclick="imprimirSeleccion(0);">Visualizar selección</a>   |    <a href="javascript:void(0)" onclick="imprimirTodo();">Visualizar todo</a>
            <table id="datatable1" class="table display responsive wrap" style="width: 100%; max-width: 850px;">
                <thead>
                <tr>
                    <th class="wd-15p" data-priority="1" style="width: 5%;">Publicación</th>
                    <th class="wd-15p" data-priority="1" style="width: 10%;">Resolución</th>
                    <th class="wd-30p">Concepto</th>
                    <th class="wd-20p" style="text-align: center;">Sivep</th>
                    <th class="wd-15p">
                      <table width="100%">
                        <thead>
                        <tr>
                          <th style="margin:0px; padding:0px;" colspan="3" style="text-align: center;">Permisos</th>
                        </tr>
                        <tr>
                          <th style="margin:0px; padding:5px;">Actor</th>
                          <th style="margin:0px; padding:5px;">Demandado</th>
                          <th style="margin:0px; padding:5px;">Tercero</th>
                        </tr>
                      </thead>
                      </table>
                    </th>
                    <th><input name="select_all" data-priority="1" value="1" style="width: 20px;" type="checkbox"></th>
                </tr>
                </thead>
                <tbody>


                </tbody>
            </table>

            


            <input type="hidden" id="pagina_actual" name="pagina_actual" value="1">
            <input type="hidden" id="paginas_totales" name="paginas_totales" value="{{$lista_acuerdos['response_pag']['paginas_totales']}}">

            <div class="pagination-wrapper justify-content-between">
                <ul class="pagination mg-b-0">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax('primera');" aria-label="Last">
                    <i class="fa fa-angle-double-left"></i>
                    </a>
                </li>
                
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax('atras');" aria-label="Next">
                        <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                
                </ul>
    
                <div id="texto_paginator">Página <span class="pagina_actual_texto">{{$lista_acuerdos['response_pag']['pagina_actual']}}</span> de <span class="pagina_total_texto">{{$lista_acuerdos['response_pag']['paginas_totales']}}</span></div>
    
                <ul class="pagination mg-b-0">
                
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax('avanzar');" aria-label="Next">
                    <i class="fa fa-angle-right"></i>
                    </a>
                </li>
                

                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax('ultima');" aria-label="Last">
                    <i class="fa fa-angle-double-right"></i>
                    </a>
                </li>
                </ul>
            </div><!-- pagination-wrapper -->



          </div>

          <div class="tab-pane fade" id="pills-asuntos" role="tabpanel" aria-labelledby="pills-asuntos-tab">

            

            <table id="datatable2" class="table display responsive nowrap" style="width: 100%;">
              <thead>
              <tr>
                  <th class="wd-15p">Fecha de creacion</th>
                  <th class="wd-15p">Número</th>
                  <th class="wd-15p">Tipo</th>
                  <th class="wd-15p"></th>
              </tr>
              </thead>
              <tbody>
                @isset($archivo_asuntos_relacionados['response'][0]['datos_archivo'])
                
                  @php $i=0; @endphp
                  @foreach ($archivo_asuntos_relacionados['response'] as $asunto_relacionados)
                  
                    <tr>
                      <td>
                        @php $fecha_arr=explode(' ', $asunto_relacionados['datos_archivo']['fecha_publicacion']); @endphp
                          {{$fecha_arr[0]}}<br> 
                          @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]); print($fechaCreacion); @endphp
                      </td>
                      <td>
                        {{$asunto_relacionados['datos_archivo']['expediente']}}/{{$asunto_relacionados['datos_archivo']['anio']}}
                      </td>
                      <td>
                          {{$asunto_relacionados['datos_archivo']['tipo_expediente']}}
                      </td>
                      <td>
                        <a href="/acuerdo_detalles/{{$asunto_relacionados['datos_archivo']['id_juicio']}}">Ver expediente</a>
                      </td>
                    </tr>
                    @php $i++; @endphp
                  @endforeach
                @endisset

                
              </tbody>
            </table>
          </div> 

          <div class="tab-pane fade show active" id="pills-demandas" role="tabpanel" aria-labelledby="pills-demandas-tab">

            <table id="datatable22" class="table display responsive wrap" style="width: 100%;">
              <thead>
                <tr>
                    <th class="wd-15p">Fecha de recepción</th>
                    <th class="wd-15p">Tipo</th>
                    <th class="wd-15p">Origen</th>
                    <th class="wd-15p">Relación</th>
                    <th class="wd-15p">Adjuntos</th>
                </tr>
              </thead>
              <tbody>
                @isset($lista_promociones_total[0]['fecha_recepcion'])
                
                  @php $i=0; @endphp
                  @foreach ($lista_promociones_total as $promociones)
                  
                    <tr>
                      <td>
                        @php $fecha_arr=explode(' ', $promociones['fecha_recepcion']); @endphp
                          {{$fecha_arr[0]}}<br>@if($fecha_arr[1]!="00:00:00") {{$fecha_arr[1]}}<br> @endif 
                          @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]); print($fechaCreacion); @endphp
                      </td>
                      <td>
                        @if($promociones['tipo_documento']=='EXHO')
                          EXHORTO
                        @elseif($promociones['tipo_documento']=='INIC')
                          DEMANDA
                        @elseif($promociones['tipo_documento']=='POS')
                          PROMOCION
                        @elseif($promociones['tipo_documento']=='CAUS')
                          CAUSA ESPECIAL
                        @elseif($promociones['tipo_documento']=='INCO')
                          INCOMPETENCIA
                        @else
                          {{$promociones['tipo_documento']}}
                        @endif
                      </td>
                      <td class="romperCadena">
                        @if($promociones['opc_promocion_origen']=='SIGJ WEB')
                          OP/JUZGADO/INDIVIDUAL
                          <a href="javascript:void(0);" onclick="eliminarCaratula('{{$promociones['id_promocion']}}');"><br><small>eliminar promoción</small></a>
                        @elseif($promociones['opc_promocion_origen']=='SIGJ SCANER')
                          OP/JUZGADO/QR
                          <a href="javascript:void(0);" onclick="eliminarCaratula('{{$promociones['id_promocion']}}');"><br><small>eliminar promoción</small></a>
                        @elseif($promociones['opc_promocion_origen']=="2DA_SEC")
                          SEGUNDA SECRETARIA
                        @else
                          {{$promociones['opc_promocion_origen']}}
                        @endif

                        <br><small>{{$promociones['id_promocion']}}<br>{{$promociones['comentario']}}</small>
                      </td>
                      
                      <td>

                        @isset($promociones['acuerdos_relacionados'][0])
                          @foreach ($promociones['acuerdos_relacionados'] as $acuerdos_relacionados => $valor)
                            <div style="line-height: 15px;" id=""> 
                              {{$valor[0]['acuerdo']}}<br><a href="javascript:void(0)" onclick="eliminarRelacion({{$valor[0]['id_acuerdo']}}, {{$promociones['id_promocion']}});"><small>eliminar</small></a>
                            </div>
                          @endforeach
                        @endisset

                      </td>

                      <td>
                        @php $adjuntos_int=0 @endphp
                        @foreach($promociones['adjuntos'] as $adjuntos)
                            @isset($adjuntos['json_arr']->idDocument)
                                @if($adjuntos_int==0)
                                    <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});" >@if ((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo_detalle['response'][0]['datos_archivo']['id_catalogo_juicios'])))Solicitud @else Documento @endif </a>
                                    @if($adjuntos['promocion_adjunto_visibilidad']==1)
                                      <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},0);"><i class="fa fa-eye"></i></a></span>
                                    @else
                                      <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},1);"><i class="fa fa-eye-slash"></i></a></span>
                                    @endif
                                    
                                @else
                                  <br><a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});">Adjunto {{$adjuntos_int}}</a>
                                  @if($adjuntos['promocion_adjunto_visibilidad']==1)
                                    <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},0);"><i class="fa fa-eye"></i></a></span>
                                  @else
                                    <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},1);"><i class="fa fa-eye-slash"></i></a></span>
                                  @endif
                                @endif
                                @php $adjuntos_int++; @endphp
                            @endisset

                            @isset($adjuntos['json_arr']->idGlobal)
                                @if($adjuntos_int==0)
                                    <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});" >@if ((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo_detalle['response'][0]['datos_archivo']['id_catalogo_juicios'])))Solicitud @else Documento @endif </a>
                                    @if($adjuntos['promocion_adjunto_visibilidad']==1)
                                      <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},0);"><i class="fa fa-eye"></i></a></span>
                                    @else
                                      <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},1);"><i class="fa fa-eye-slash"></i></a></span>
                                    @endif
                                @else
                                  <br><a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});">Adjunto {{$adjuntos_int}}</a>
                                  @if($adjuntos['promocion_adjunto_visibilidad']==1)
                                    <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},0);"><i class="fa fa-eye"></i></a></span>
                                  @else
                                    <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},1);"><i class="fa fa-eye-slash"></i></a></span>
                                  @endif
                                @endif
                                @php $adjuntos_int++; @endphp
                            @endisset
                        @endforeach

                        @if($adjuntos_int!=0) <br> @endif
                        @if($promociones['opc_promocion_tipo_recepcion']=="fisico")
                          Recepción: Físico
                        @elseif($promociones['opc_promocion_tipo_recepcion']=="ambos")
                          Recepción: Ambos
                        @elseif($promociones['opc_promocion_tipo_recepcion']=="digital")
                          Recepción: Digital
                        @endif

                      </td>
                    </tr>
                    @php $i++; @endphp
                  @endforeach
                @endisset

                @isset($lista_promociones['response'][0]['fecha_recepcion1'])
                  @php $i=0; @endphp
                  @foreach ($lista_promociones['response'] as $promociones)
                    @if($promociones['opc_promocion_origen']=='SIGJ SCANER' and !isset($promociones['adjuntos'][0]))
                      @continue
                    @endif
                    <tr>
                      <td>
                        @php $fecha_arr=explode(' ', $promociones['fecha_recepcion']); @endphp
                          {{$fecha_arr[0]}}<br>
                          @if($fecha_arr[1]!="00:00:00") {{$fecha_arr[1]}}<br> @endif 
                          @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]); print($fechaCreacion); @endphp
                      </td>
                      <td>PROMOCIÓN</td>
                      <td class="romperCadena">
                        @if($promociones['opc_promocion_origen']=='SIGJ WEB')
                          OP/JUZGADO/INDIVIDUAL
                          <a href="javascript:void(0);" onclick="eliminarCaratula('{{$promociones['id_promocion']}}');"><br><small>eliminar promoción</small></a>
                        @elseif($promociones['opc_promocion_origen']=='SIGJ SCANER')
                          OP/JUZGADO/QR
                          <a href="javascript:void(0);" onclick="eliminarCaratula('{{$promociones['id_promocion']}}');"><br><small>eliminar promoción</small></a>
                        @elseif($promociones['opc_promocion_origen']=="2DA_SEC")
                          SEGUNDA SECRETARIA
                        @else
                          {{$promociones['opc_promocion_origen']}}
                        @endif
                        <br><small>{{$promociones['id_promocion']}}<br>{{$promociones['comentario']}}</small>
                      </td>

                      
                      <td>

                        @isset($promociones['acuerdos_relacionados'][0])
                          @foreach ($promociones['acuerdos_relacionados'] as $acuerdos_relacionados => $valor)
                            <div style="line-height: 15px;" id=""> 
                              {{$valor[0]['acuerdo']}}<br><a href="javascript:void(0)" onclick="eliminarRelacion({{$valor[0]['id_acuerdo']}}, {{$promociones['id_promocion']}});"><small>eliminar</small></a>
                            </div>
                          @endforeach
                        @endisset
                      </td>
                      

                      <td>
                        @php $adjuntos_int=0 @endphp
                        @foreach($promociones['adjuntos'] as $adjuntos)
                          
                            @isset($adjuntos['json_arr']->idDocument)
                                @if($adjuntos_int==0)
                                    <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});" >@if ((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo_detalle['response'][0]['datos_archivo']['id_catalogo_juicios'])))Solicitud @else Documento @endif</a>
                                    
                                    @if($adjuntos['promocion_adjunto_visibilidad']==1)
                                      <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},0);"><i class="fa fa-eye"></i></a></span>
                                    @else
                                      <br><span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},1);"><i class="fa fa-eye-slash"></i></a></span>
                                    @endif
                                      
                                @else
                                  
                                  <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});">Adjunto {{$adjuntos_int}}</a>

                                  @if($adjuntos['promocion_adjunto_visibilidad']==1)
                                      <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},0);"><i class="fa fa-eye"></i></a></span>
                                    @else
                                      <br><span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},1);"><i class="fa fa-eye-slash"></i></a></span>
                                    @endif

                                @endif
                                @php $adjuntos_int++; @endphp
                            @endisset

                            @isset($adjuntos['json_arr']->idGlobal)
                                @if($adjuntos_int==0)
                                    <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});" >@if ((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo_detalle['response'][0]['datos_archivo']['id_catalogo_juicios'])))Solicitud @else Documento @endif</a>
                                    @if($adjuntos['promocion_adjunto_visibilidad']==1)
                                      <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},0);"><i class="fa fa-eye"></i></a></span>
                                    @else
                                      <br><span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},1);"><i class="fa fa-eye-slash"></i></a></span>
                                    @endif
                                @else
                                  <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});">Adjunto {{$adjuntos_int}}</a>
                                  @if($adjuntos['promocion_adjunto_visibilidad']==1)
                                      <span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},0);"><i class="fa fa-eye"></i></a></span>
                                    @else
                                      <br><span id="ocultar_promocion_{{$adjuntos['promocion_adjunto_id']}}"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor({{$promociones['id_promocion']}},{{$adjuntos['promocion_adjunto_id']}},1);"><i class="fa fa-eye-slash"></i></a></span>
                                    @endif
                                @endif
                                @php $adjuntos_int++; @endphp
                            @endisset

                            @if($adjuntos_int!=0) <br> @endif
                            @if($promociones['opc_promocion_tipo_recepcion']=="fisico")
                              Recepción: Físico
                            @elseif($promociones['opc_promocion_tipo_recepcion']=="ambos")
                              Recepción: Ambos
                            @elseif($promociones['opc_promocion_tipo_recepcion']=="digital")
                              Recepción: Digital
                            @endif
                            
                        @endforeach
                      </td>
                    </tr>
                    @php $i++; @endphp
                  @endforeach
                @endisset
              </tbody>
          </table>
          </div>


          
        </div>
      </div><!-- table-wrapper -->
    </div><!-- section-wrapper -->

    <div class="section-wrapper" >
      <form method="POST" action="{{ route('acuerdo_detalles.guardar') }}" enctype="multipart/form-data" name="registration">
        
          <input type="hidden" id="secretaria_expediente" name="secretaria_expediente" value="{{$archivo_detalle['response'][0]['datos_archivo']['secretaria']}}">
          <input type="hidden" id="id_juicio"  name="id_juicio" value="{{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}">
          <input type="hidden" id="juicio"  name="juicio" value="{{$archivo_detalle['response'][0]['datos_archivo']['expediente']}}/{{$archivo_detalle['response'][0]['datos_archivo']['anio']}}@if($archivo_detalle['response'][0]['datos_archivo']['bis']!=""){{"/".$archivo_detalle['response'][0]['datos_archivo']['bis']}} @endif">
          <input type="hidden" id="expediente"  name="expediente" value="{{$archivo_detalle['response'][0]['datos_archivo']['expediente']}}">
          <input type="hidden" id="id_catalogo_juicios"  name="id_catalogo_juicios" value="{{$archivo_detalle['response'][0]['datos_archivo']['id_catalogo_juicios']}}">
          <input type="hidden" id="fecha_publicacion_temp"  name="fecha_publicacion_temp" value="{{$lista_agenda['response_publicacion']}}">
          

          <div class="form-layout">
              <div class="row mg-b-25">
                <div class="col-lg-6">
                  <label class="section-title">Agregar Resolución</label>
                </div>

                <div class="col-lg-6 firma_sin_documento">
                  <div class="form-group">
                    <label class="ckbox">
                      <input type="checkbox" id="es_edicto" name="es_edicto"><span>Documento con Edicto</span>
                    </label>
                  </div>
                </div><!-- col-6 -->


                <div class="col-lg-6 firma_sin_documento">
                  <div class="form-group">
                    <label class="ckbox">
                      <input type="checkbox" id="conciliador" name="conciliador" value="1"><span>Secretario conciliador.</span>
                    </label>
                  </div>
                </div><!-- col-6 -->

                <div class="col-lg-6">
                </div>
                
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" ><span class="tx-danger">*</span> Resolución:</label>
                  
                      <table>
                          <tr>
                          <td><strong>{{$archivo_detalle['response'][0]['datos_archivo']['expediente']}}/{{$archivo_detalle['response'][0]['datos_archivo']['anio']}}-</strong></td>
                          <td><input class="form-control" type="text" name="acuerdo" id="acuerdo" value="{{$acuerdo_max+1}}" placeholder="" required></td>
                          </tr>
                      </table>
                    
                  </div>
                </div><!-- col-6 -->

                <div class="col-lg-6">
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" ><span class="tx-danger">*</span> Tipo de Resolución: </label>

                    <select class="form-control select2" data-placeholder="" id="tipo_acuerdo" name="tipo_acuerdo"  onchange="ponerSentenciaDivorcio(); ponerSubTipo()">
                        <option value="acuerdo" @if(old('tipo_acuerdo')=='acuerdo') selected @endif >Acuerdo</option>
                        <option value="sentencia definitiva" @if(old('tipo_acuerdo')=='sentencia definitiva') selected @endif>Sentencia Definitiva</option>
                        <option value="sentencia interlocutoria" @if(old('tipo_acuerdo')=='sentencia interlocutoria') selected @endif>Sentencia Interlocutoria</option>
                        <option value="audiencia" @if(old('tipo_acuerdo')=='audiencia') selected @endif>Audiencia</option>
                      </select>



                  </div>
                </div><!-- col-6 --> 

                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" ><span class="tx-danger">*</span> Subtipo de Resolución: </label>

                    <select class="form-control select2" data-placeholder="" id="subtipo_acuerdo" name="subtipo_acuerdo" onchange="">
                        
                      </select>



                  </div>
                </div><!-- col-6 --> 
  
  
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" >Caso especial:</label>
                  
                    <select class="form-control select2" data-placeholder="" id="especial" name="especial" >
                      <option value="-" @if(old('especial')=='-') selected @endif >Ninguno</option>
                      <option value="no publicado" @if(old('especial')=='no publicado') selected @endif>No publicado</option>
                      <option value="mal publicado" @if(old('especial')=='mal publicado') selected @endif>Mal publicado</option>
                    </select>
                  </div>
                </div><!-- col-6 -->

                <div class="col-lg-6">
                    <div class="form-group" id="">
                        <label class="form-control-label" ><span class="tx-danger">*</span> Fecha de resolución:</label>
                        <div class="input-group">
                        
                        <div class="input-group-prepend">

                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                        </div>
                        <input id="fecha" name="fecha" type="text" class="form-control fc-datepicker" placeholder="" data-date-format="yyyy-mm-dd" readonly="readonly" required >
                        </div>
                    </div>
                </div>

                <input type="hidden" id="publicar_en_slct" name="publicar_en_slct" value="EXPEDIENTE">
                
                <div class="col-lg-12 firma_sin_documento">
                  <div class="form-group">
                    <label class="form-control-label" >Concepto:</label>
                  <input class="form-control" type="text" name="concepto" id="concepto" value="{{ old('concepto') }}" placeholder="">
                  </div>
                </div><!-- col-6 -->

                <div class="col-md-12">
                  <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-primary">
                      Respuesta a demandas y promociones
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0" id="vincular_promocion" style="">
                        <div class="row p-0 m-0" style="height:430px; overflow-y: auto; width: 100%;" >
                          


                          <table id="datatable33" class="table display responsive nowrap" style="width: 100% !important; ">
                            <thead>
                            <tr>
                                <th class="wd-15p">Fecha de recepción</th>
                                <th class="wd-15p">Tipo/Origen</th>
                                <th class="wd-15p">Adjuntos</th>
                                <th class="wd-15p">Relación</th>
                                <th class="wd-15p"></th>
                            </tr>
                            </thead>
                            <tbody>
                              @isset($lista_promociones_total[0]['fecha_recepcion'])
                              
                                @php $i=0; @endphp
                                @foreach ($lista_promociones_total as $promociones)
                                  <tr>
                                    <td>
                                      @php $fecha_arr=explode(' ', $promociones['fecha_recepcion']); @endphp
                                          {{$fecha_arr[0]}}<br>@if($fecha_arr[1]!="00:00:00") {{$fecha_arr[1]}}<br> @endif 
                                          @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]); print($fechaCreacion); @endphp
                                    </td>
                                    <td class="romperCadena">

                                      @if($promociones['tipo_documento']=='EXHO')
                                        EXHORTO<BR>
                                      @elseif($promociones['tipo_documento']=='INIC')
                                        DEMANDA<BR>
                                      @elseif($promociones['tipo_documento']=='POS')
                                        PROMOCION<BR>
                                      @elseif($promociones['tipo_documento']=='CAUS')
                                        CAUSA ESPECIAL<BR>
                                      @elseif($promociones['tipo_documento']=='INCO')
                                        INCOMPETENCIA<BR>
                                      @else
                                        {{$promociones['tipo_documento']}}<BR>
                                      @endif


                                      @if($promociones['opc_promocion_origen']=='SIGJ WEB')
                                        OP/JUZGADO/INDIVIDUAL
                                      @elseif($promociones['opc_promocion_origen']=='SIGJ SCANER')
                                        OP/JUZGADO/QR
                                      @elseif($promociones['opc_promocion_origen']=="2DA_SEC")
                                        SEGUNDA SECRETARIA
                                      @else
                                        {{$promociones['opc_promocion_origen']}}
                                      @endif
                                      <br><small>{{$promociones['id_promocion']}}<br>{{$promociones['comentario']}}</small>
                                    </td>
                                    <td>
                                      @php $adjuntos_int=0 @endphp
                                      @foreach($promociones['adjuntos'] as $adjuntos)
                                          @isset($adjuntos['json_arr']->idDocument)
                                              @if($adjuntos_int==0)
                                                  <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});" >Ver documento</a>
                                              @else
                                              <br><a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});">Adjunto {{$adjuntos_int}}</a>
                                              @endif
                                              @php $adjuntos_int++; @endphp
                                          @endisset
              
                                          @isset($adjuntos['json_arr']->idGlobal)
                                              @if($adjuntos_int==0)
                                                  <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});"> Ver documento</a>
                                              @else
                                              <br><a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});">Adjunto {{$adjuntos_int}}</a>
                                              @endif
                                              @php $adjuntos_int++; @endphp
                                          @endisset
              
                                      @endforeach

                                      @if($adjuntos_int!=0) <br> @endif
                                      @if($promociones['opc_promocion_tipo_recepcion']=="fisico")
                                        Recepción: <BR>Físico
                                      @elseif($promociones['opc_promocion_tipo_recepcion']=="ambos")
                                        Recepción: <BR>Ambos
                                      @elseif($promociones['opc_promocion_tipo_recepcion']=="digital")
                                        Recepción: <BR>Digital
                                      @endif

                                    </td>
                                    <td class="wd-15p">
                                      @isset($promociones['acuerdos_relacionados'][0])
                                        @foreach ($promociones['acuerdos_relacionados'] as $acuerdos_relacionados => $valor)
                                          <div style="line-height: 15px;" id=""> 
                                            {{$valor[0]['acuerdo']}}<br><a href="javascript:void(0)" onclick="eliminarRelacion({{$valor[0]['id_acuerdo']}}, {{$promociones['id_promocion']}});"><small>eliminar</small></a>
                                          </div>
                                        @endforeach
                                      @endisset
                                    </td>

                                    <td>
                                      <div class="col-lg-3">
                                        <label class="ckbox">
                                          <input type="checkbox" class="promocion_adjuntar_class" name="promocion_adjuntar[]" id="promocion_adjuntar[]" value="{{$promociones['id_promocion']}}"><span>Seleccionar</span>
                                        </label>
                                      </div><!-- col-3 -->

                                    </td>
                                  </tr>
                                  @php $i++; @endphp
                                @endforeach
                              @endisset
                            </tbody>
                          </table>

                        </div>
                    </div><!-- card-body -->
                  </div><!-- card -->
                </div><!-- col -->
                



                <div class="col-md-12 m-t-20" style="margin-top: 20px;">
                  <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-primary">
                      Publicación en boletín y alertas para litigantes
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0">
                      

                        <div class="row p-0 m-0">
                          <div class="col-md-4">
                            <label class="rdiobox">
                              <input name="visibilidad" type="radio" id="v_normal" value="-" @empty(old('visibilidad')) checked  @endempty  @if(old('visibilidad')=='-') checked @endif onchange="cambiarTextoVisibilidad('-');" >
                              <span>Normal</span>
                            </label>
        
                            <label class="rdiobox">
                              <input name="visibilidad" type="radio" id="v_personal" value="personal" @if(old('visibilidad')=='personal') checked @endif onchange="cambiarTextoVisibilidad('personal');">
                              <span>Notificación personal</span>
                            </label>
                            
        
                            <label class="rdiobox">
                              <input name="visibilidad" type="radio" id="v_secreto" value="secreto" @if(old('visibilidad')=='secreto') checked @endif onchange="cambiarTextoVisibilidad('secreto');">
                              <span>Secreto</span>
                            </label>
                          </div>
                          <div class="col-md-8" id="texto_visibilidad">
                            <strong>Descripción</strong><br><ul style="text-align: justify;"><li>En boletín judicial físico se muestra nombre de las partes, tipo de juicio, número de expediente y número de acuerdos como mínimo</li><li>En sistema SIGJ para litigantes, se envía alerta al celular y al correo electrónico, podra visualizar el contenido del documento mediante la plataforma SIGJ</li></ul>
                          </div>
                        </div>
                      
                    </div><!-- card-body -->
                  </div><!-- card -->
                </div><!-- col -->


            
                
               


                
              <input type="hidden" value="firel" id="tipo_firma_publicacion" name="tipo_firma_publicacion">
              



                <!--
                  REVISADO
                -->
                


                <div class="col-md-12 m-t-20" style="margin-top: 20px;" id="notificacion_electronica" >
                  <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-primary">
                      Notificación
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0">
                      <div class="row">
                        <div class="col-md-7">

                          

                          <input type="hidden" value="0" name="bandera_noti_elect" id="bandera_noti_elect">
                        
                        

                        <div class="col-lg-12 usuario_actuarios" >
                  
                          <div class="form-group" style="width: 100%;">
                            <label class="form-control-label" >Elija al acturario que realizará la notificación:</label><br>
                            <select class="form-control select2" data-placeholder="" id="lista_actuario" name="lista_actuario" >
                              
                              @isset($lista_actuarios['response'][0]['id_usuario'])
                                @foreach($lista_actuarios['response'] as $actuario)
                                  <option value="{{$actuario['id_usuario']}}" >{{$actuario['nombre']}}</option>
                                @endforeach

                                @if(($request->entorno["variables_entorno"]["uga_produccion"]==1 and $request->entorno["variables_entorno"]["uga_materia"]==$request->session()->get('usuario_juzgado')) or $request->session()->get('sesion_tipo')=='soporte')
                                  <option value="1604071733" >NOTIFICACIÓN UGA</option>
                                @endif
                              @else
                                @if(($request->entorno["variables_entorno"]["uga_produccion"]==1 and $request->entorno["variables_entorno"]["uga_materia"]==$request->session()->get('usuario_juzgado')) or $request->session()->get('sesion_tipo')=='soporte')
                                  <option value="1604071733" >NOTIFICACIÓN UGA</option>
                                @else
                                  <option value="0" >Sin actuarios relacionados</option>
                                @endif
                              @endisset
                            </select>
                          </div>
        
                          <!--
                          <div class="row m-t-10-force" >
                            <div class="col-lg-12">
                              <label class="rdiobox">
                                <input name="tipo_noti_elect" type="radio" value="1" checked>
                                <span>Notificación electrónica por Articulo 113</span>
                              </label>
                            </div><!-- col-3 -- >
                            <div class="col-lg-12 mg-t-20 mg-lg-t-0">
                              <label class="rdiobox">
                                <input name="tipo_noti_elect" type="radio" value="2" >
                                <span>Notificación electrónica por correo del actuario</span>
                              </label>
                            </div><!-- col-3 -- >
                            <div class="col-lg-12 mg-t-20 mg-lg-t-0">
                              <label class="rdiobox">
                                <input name="tipo_noti_elect" type="radio" value="3" >
                                <span>Notificación física</span>
                              </label>
                            </div><!-- col-3 -- >
                          </div>
                        -->
        
                        </div>

                          
                        </div> 
                        <input type="hidden" value="{{$bandera_notificacion}}" name="bandera_notificacion" id="bandera_notificacion">

                        <div class="col-lg-5 " id="estatus_notificacion_partes">
                          
                          @if($bandera_notificacion==1)
                            <h5 class="tx-success">Con información de alguna las partes. <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cargarInfoNotificacion({{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}, 0, 1);">Consulta aquí.</a></h5>
                          @else
                            <h5 class="tx-danger">Ninguna de las partes esta completa. <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cargarInfoNotificacion({{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}, 0, 1);">Favor de validar aquí.</a></h5>
                          @endif


                        </div>



                        <div class="col-lg-12 ">
                          <div class="form-group" style="width: 100%;">
                            
                            @if($request->session()->get('sesion_tipo')=='soporte')
                              
                              
                              



                            @endif
                          </div>
                        </div>



                      </div>
                    </div>
                  </div>
                </div>
 

               



                @if (utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $archivo_detalle['response'][0]['datos_archivo']['id_catalogo_juicios']) and $archivo_detalle['response'][0]['datos_archivo']['tipo_juicio_int']==1)

                
                <div class="col-md-12" style="margin-top: 20px;">
                  <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white bg-danger">
                      Procedimiento en línea
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0">


                      <div class="row">
                        <input type="hidden" id="hidden_estatus_procedimiento_partes" name="hidden_estatus_procedimiento_partes" value="{{$bandera_correo}}">
                        <div class="col-lg-12 m-t-20-force " style="text-align: center" id="estatus_procedimiento_partes">

                          @if($bandera_correo==1)
                            <h5 class="tx-success">Con informacion de alguno de los interesados, se enviara correo. <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cargarInfoNotificacion({{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}, 1);">Consulta aquí.</a></h5>
                          @else
                            <h5 class="tx-danger">Al menos uno de los interesados o el solicitante debe tener correo, por lo cual no se enviará correo. <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cargarInfoNotificacion({{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}, 1);">Favor de validar aquí.</a></h5>
                          @endif

                          <hr>
                          
                        </div>

                        <div class="col-lg-6 m-t-20-force" id="">

                          <div class="col-lg-12 m-t-20-force" id="">
                            <div class="form-group tipo_virtual" >
                              <label class="form-control-label" ><strong>Tipo de resolución:</strong></label>
                              
                              <label class="rdiobox">
                                <input name="etapa_procesal" type="radio" id="de_admision" value="admision" @if(old('etapa_procesal')=='admision') checked  @endif   @empty(old('etapa_procesal')) checked  @endempty onchange="ocultar_horario_virtual()"   >
                                <span>Admisión</span>
                              </label>

                              <label class="rdiobox">
                                <input name="etapa_procesal" type="radio" id="de_autos" value="autos" @if(old('etapa_procesal')=='autos') checked @endif onchange="ocultar_horario_virtual()" >
                                <span>Autos</span>
                              </label>
  
                              <label class="rdiobox">
                                <input name="etapa_procesal" type="radio" id="de_prevencion" value="prevencion" @if(old('etapa_procesal')=='prevencion') checked  @endif  onchange="ocultar_horario_virtual()" >
                                <span>Prevención</span> 
                              </label>
  
                              <label class="rdiobox">
                                <input name="etapa_procesal" type="radio" id="de_desechamiento" value="desechamiento" @if(old('etapa_procesal')=='desechamiento') checked @endif onchange="ocultar_horario_virtual()" >
                                <span>Desechamiento</span>
                              </label>
                              
                              
                              <label class="rdiobox">
                                <input name="etapa_procesal" type="radio" id="de_sentencia" value="sentencia" @if(old('etapa_procesal')=='sentencia') checked @endif onchange="ocultar_horario_virtual()" >
                                <span>Sentencia</span>
                              </label>


                              
  
                              
                            </div>
                            </div>


                        </div>

                      <div class="col-lg-6 m-t-20-force">
                        <div class="form-group romperCadena">
                          
                          <input type="hidden" value="virtual" name="tipo_etapa_procesal" id="tipo_etapa_procesal">
                          <!--
                          <label class="rdiobox">
                            <input name="tipo_etapa_procesal" type="radio" id="de_virtual" value="virtual" @if(old('tipo_etapa_procesal')=='virtual') checked  @endif   @empty(old('tipo_etapa_procesal')) checked  @endempty  onchange="visualizarTipoEtapaProcesal()"  >
                            <span>Expediente electrónico</span>
                          </label>
                        -->

                        

                          <label class="tipo_virtual horario_virutal_label romperCadena">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo4" onclick="mostrarCalendarioAudiencias('{{$archivo_detalle['response'][0]['datos_archivo']['secretaria']}}')">SELECCIONE EL HORARIO</a>
                            <div id="horario_virtual_txt"></div>
                            <hr>
                            <div class="romperCadena">
                            <i class="fa fa-exclamation-triangle tx-warning"></i> Recuerde que el acuerdo debe ser firmado por el secretario y juez antes de la hora de cierre, de caso contrario no se podrá publicar y deberá crearlo nuevamente.
                            </div>
                            <input type="hidden" id="horario_virtual" name="horario_virtual" value="">
                          </label>

                        </div>
                      </div>




                        </div>
                      </div>
                  
                  </div>
                </div>

                @endif


                <div class="col-lg-12">
                    <br><br>
                    <h5 class="card-profile-name">Selecciona el documento</h5>
                    <p class="card-profile-position">
                        <div class="col-lg-12">
                        <div class="form-group">
                            <input type="hidden" value="localFile" id="localFile" name="uploadType">
                            <label class="form-control-label" ><span class="tx-danger">*</span> Documento:</label>
                            <div id="div_upload" class="field"  >
                                <input class="btn btn-oblong btn-outline-primary" type="file" name="archivo_acuerdo" id="archivo_acuerdo" size="50" required style="width:100%;" accept=".doc, .docx, .mht " />
                                
                            </div>
                        </div>
                        </div><!-- col-2 -->
                    </p>
                    <br><br>
                </div>


                <div class="col-lg-12">
                  <br>
                  <button class="btn btn-success btn-block mg-b-10"  id="agregar_acuerdo_boton">Agregar Acuerdo</button>
                </div>
              </div><!-- row -->    
          </div><!-- form-layout -->
       </form>
  </div><!-- section-wrapper -->
  <br><br>
@endsection

@section('seccion-estilos')
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/datatables/css/jquery.dataTables.css" rel="stylesheet">
  <link href="{{ $entorno["version_pages"]["version"] }}/lib/select2/css/select2.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/box/qtip2/jquery.qtip.css">

  <style>
    @media screen and (min-width: 992px) {
        .modal-dialog {
          width: 100%; /* New width for large modal */
        }
    }
    .romperCadena{
      word-wrap: break-word !important;
      white-space:normal !important;
    }
    .ckbox span:before{
      content:'' !important;
      border:1px solid #adb5bd !important;
    }

    #datatable33_wrapper{
      width: 100%;
    }

    .nav{
      flex-wrap:nowrap !important;
      text-align: center;
    }
  </style>
@endsection

@section('seccion-scripts-libs')
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
  <script  src="/box/js/jquery.validate.js"></script>
  <script type="text/javascript" src="/box/qtip2/jquery.qtip.js"></script>
  

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
@endsection

@section('seccion-scripts-functions')
<script>
var dataTableGlobal;
var dataTableGlobal_notificacion;
var dataTableGlobal_notificacion_='dataTableGlobal_notificacion_';
var dropdown_='dropdown_';
var dataTableGlobal2;
var i_global=-1;
//var texto_check_disable="";
 
function rebuilt_table(tabla){
  setTimeout(function(){
    if(tabla==1){
      dataTableGlobal.responsive.rebuild();
      dataTableGlobal.responsive.recalc();
    }
    else{
      dataTableGlobal2.responsive.rebuild();
      dataTableGlobal2.responsive.recalc();
    }
  }, 200);
}

function cargarInfoNotificacion(id, header=0, acuerdos=0){
  $('#modaldemo3').find('.modal-header').html('');
  $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
  $.ajax({
      type:'POST',
      url:'/consultaPartesNotificacion',
      data:{ id:id, guardar:1, header:header, acuerdos:acuerdos },
      success:function(data){
          $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
          $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);
      }
  });
}

function crear_relacion_promocion_ventana(id_acuerdo){
  
  $('#modaldemo3').find('.modal-header').html('');
  $('#modaldemo3').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
  $.ajax({
      type:'POST',
      url:'/acuerdo_detalles/crear_relacion_promocion_ventana',
      data:{ id_acuerdo:id_acuerdo, id_juicio:{{$id}} },
      success:function(data){
          console.log(data);
          $('#modaldemo3').find('.modal-header').html(data.plantilla_archivo_header);
          $('#modaldemo3').find('.modal-body').html(data.plantilla_archivo_body);

          setTimeout(function(){
            $('#datatable333').DataTable({
              bLengthChange: false, 
              searching: false,
              responsive: true,
              "ordering": false,
              "paging":   false
            });
          }, 500);
          
      }
  });
}

function accionPaginatorAcuerdos_ajax(pagina_accion){

  pagina=parseInt($('#pagina_actual').val());
  registros_por_pagina=5;

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
      console.log('aqui');
  }
  else{
      $('#pagina_actual').val(pagina);
      $('.pagina_actual_texto').html(pagina);

      $('#modal_loading').modal({backdrop: 'static', keyboard: false})

      $.ajax({
          type:'POST',
          url:'/acuerdo_detalle/accionPaginatorAcuerdos_ajax',
          data:{pagina:pagina, registros_por_pagina:registros_por_pagina, id:{{$id}} },
          success:function(data){
              setTimeout(function(){
                  $('#modal_loading').modal('hide');
              }, 500);
              
              console.log(data);
              dataTableGlobal.clear().draw();
              arr_check_disable=[];

              if(data.status==100){
                  
                  console.log(data.response);
                  
                  //se actualiza el total
                  $('.pagina_total_texto').html(data.response_pag['paginas_totales']);
                  $('#paginas_totales').val(data.response_pag['paginas_totales'])


                  for(var i=0; i<data.response.length; i++){

                    //FECHA DE PUBLICACION
                    fecha_publicacion_arr=[];

                    hidden='<input type="hidden" value="'+data.response[i]['id_acuerdo']+',{{$archivo_detalle['response'][0]['datos_archivo']['juzgado']}},'+data.response[i]['ultima_version']+'" id="data_imprimir_'+i+'">';

                    if(data.response[i]['fecha_publicacion']!=null){
                      fecha_publicacion_arr=data.response[i]['fecha_publicacion'].split(" ");
                      fecha_publicacion=fecha_publicacion_arr[0];
                    }
                    else{
                      fecha_publicacion=fecha_publicacion_arr[0]="";
                    }
                    
                    if(data.response[i]['acuerdo_copia_txt_de']!=0 && data.response[i]['acuerdo_copia_txt_de']!="" && data.response[i]['acuerdo_copia_txt_de']!=null){
                      fecha_publicacion+='<br><small>Mala publicación de:<br>'+ data.response[i]['acuerdo_copia_txt_de']+'</small>';
                    }
                    else if(data.response[i]['acuerdo_mala_publicacion_bandera']==1){
                      fecha_publicacion+='<br><small class="tx-danger">Mala publicación</small>';
                    }
                    else if(data.response[i]['acuerdo_mala_publicacion_bandera']==0 && fecha_publicacion_arr[0]!=""){
                      fecha_publicacion+='<br><div style="line-height:14px; "><small><a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo4" onclick="ventana_mala_publicacion('+data.response[i]['id_acuerdo']+');" >Marcar como<br>mala publicación</a></small></div>';
                    }

                    if(fecha_publicacion==""){
                      texto_firmantes="<strong>FALTANTES:</strong><br>";
                      for(j=0; j<data.response[i]['posesion_de'].length; j++){
                        texto_firmantes+=data.response[i]['posesion_de'][j]['usuario']+"<br>";
                      }
                      fecha_publicacion="<span title=\""+texto_firmantes+"\"><a href=\"javascript:void(0);\">Firmantes</a></span>";
                    }

                    //RESOLUCION
                    resolucion="";
                    if(data.response[i]['fecha_publicacion']!=null && data.response[i]['acuerdo_mala_publicacion_bandera']==0){
                      resolucion+='<a href="javascript:void(0);" onclick="imprimirAcuerdo(\''+data.response[i]['id_acuerdo']+',{{$archivo_detalle['response'][0]['datos_archivo']['juzgado']}},'+data.response[i]['ultima_version']+'\');">'+data.response[i]['acuerdo']+'</a>';
                    }
                    else{
                      resolucion+=data.response[i]['acuerdo'];
                    }
                    resolucion+='<div style="line-height:14px; "><small><a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="crear_relacion_promocion_ventana('+data.response[i]['id_acuerdo']+');" >Relacionar promoción</a></small></div>';
                    
                    if(data.response[i]['acuerdo_tipo_audiencia']=='virtual'){
                      if(data.response[i]['acuerdo_etapa_procesal']=='desechamiento') resolucion+='<small class="tx-danger">';
                      else if(data.response[i]['acuerdo_etapa_procesal']=='prevencion') resolucion+='<small class="tx-warning">';
                      else if(data.response[i]['acuerdo_etapa_procesal']=='admision') resolucion+='<small class="tx-success">';
                      else if(data.response[i]['acuerdo_etapa_procesal']=='sentencia') resolucion+='<small class="tx-primary">';
                      else resolucion+='';

                      resolucion+=data.response[i]['acuerdo_etapa_procesal'].charAt(0).toUpperCase() + data.response[i]['acuerdo_etapa_procesal'].slice(1) + '</small><br>'
                    }

                    if(data.response[i]['acuerdo_noti_elect_band']=='1'){
                      resolucion+='<small><u>Notificación personal</u></small>';
                      if(data.response[i]['fecha_publicacion']!=null){
                        if(typeof(data.response[i]['notificacion_electronica'][0]) != 'undefined'){
                          resolucion+='<small><br><a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo4" onclick="notificar_acuerdo_resumen('+data.response[i]['notificacion_electronica'][0]['id_acuerdo_notificacion']+')">Detalles</a>  </small>';
                        }
                      }
                    }

                    if(typeof(data.response[i]['promociones_relacionadas'][0]) != 'undefined'){
                      resolucion+='<small><u>Promoción relacionada:</u><br>';
                      
                      for(j=0; j<data.response[i]['promociones_relacionadas'].length; j++){
                        arr_fecha=data.response[i]['promociones_relacionadas'][j]['opc_promocion_fecha_recepcion'].split(" ");
                        resolucion+=arr_fecha[0]+' '+data.response[i]['promociones_relacionadas'][j]['opc_promocion_tipo_documento'];
                        if(data.response[i]['promociones_relacionadas'][j]['opc_promocion_origen']=='SIGJ WEB') resolucion+='OP/JUZGADO/INDIVIDUAL';
                        else if(data.response[i]['promociones_relacionadas'][j]['opc_promocion_origen']=='SIGJ SCANER') resolucion+='OP/JUZGADO/QR';
                        else if(data.response[i]['promociones_relacionadas'][j]['opc_promocion_origen']=='2DA_SEC') resolucion+='SEGUNDA SECRETARIA';
                        else resolucion+=data.response[i]['promociones_relacionadas'][j]['opc_promocion_origen'];

                        resolucion+='<br><a href="javascript:void(0)" onclick="eliminarRelacion('+data.response[i]['promociones_relacionadas'][j]['id_acuerdo']+', '+data.response[i]['promociones_relacionadas'][j]['opc_promocion_id']+');"><small>eliminar</small></a><br>';
                      }
                    }

                    //CONCEPTO
                    concepto=data.response[i]['concepto'];

                    //SIVEP
                    sivep='';
                    if(data.response[i]['tipo']=='sentencia definitiva'){
                      if(data.response[i]['fecha_publicacion']!=''){
                        
                        if(data.response[i]['estatus_sivep1']==1){
                          sivep+='<i class="fa fa-check-circle tx-success" style="font-size: 25px;"></i>';
                        }
                        else{
                          if({{$lista_acuerdos['response_sivep']}}!=0){
                          }
                          else if('{{$sesion['tipo_usuario_descripcion']}}'=='juez magistrado'){
                            sivep+='<a href="javascript:void(0)" id="sivep_'+data.response[i]['id_acuerdo']+'" onclick="agregar_acuerdo_sivep('+data.response[i]['id_acuerdo']+');"><img src="/images/error.png" width="20px"></a>';
                          }
                          else{
                            sivep+='<img src="/images/error.png" width="20px">';
                          }
                        }
                      }
                    }
                    else if(data.response[i]['estatus_sivep1']==1){
                      sivep+='<i class="fa fa-check-circle tx-success" style="font-size: 25px;"></i>';
                    }

                    //permisos
                    permisos='<table width="100%" style=""><tr style="background-color:transparent;">';
                    if(data.response[i]['permiso_parte1']=='S'){
                      permisos+='<td style="margin:0px; padding:5px; text-align:center;" id="permiso_1_'+data.response[i]['id_acuerdo']+'"><a href="javascript:void(0)" onclick="cambiarPermisosVisible('+data.response[i]['id_acuerdo']+', 1, 1);"><img src="/images/correcto.png" width="20px"></a></td>';
                    }
                    else{
                      permisos+='<td style="margin:0px; padding:5px; text-align:center;" id="permiso_1_'+data.response[i]['id_acuerdo']+'"><a href="javascript:void(0)" onclick="cambiarPermisosVisible('+data.response[i]['id_acuerdo']+', 1, 0);"><img src="/images/error.png" width="20px"></a></td>';
                    }
                    if(data.response[i]['permiso_parte2']=='S'){
                      permisos+='<td style="margin:0px; padding:5px; text-align:center;" id="permiso_2_'+data.response[i]['id_acuerdo']+'"><a href="javascript:void(0)" onclick="cambiarPermisosVisible('+data.response[i]['id_acuerdo']+', 2, 1);"><img src="/images/correcto.png" width="20px"></a></td>';
                    }
                    else{
                      permisos+='<td style="margin:0px; padding:5px; text-align:center;" id="permiso_2_'+data.response[i]['id_acuerdo']+'"><a href="javascript:void(0)" onclick="cambiarPermisosVisible('+data.response[i]['id_acuerdo']+', 2, 0);"><img src="/images/error.png" width="20px"></a></td>';
                    }
                    if(data.response[i]['permiso_parte3']=='S'){
                      permisos+='<td style="margin:0px; padding:5px; text-align:center;" id="permiso_3_'+data.response[i]['id_acuerdo']+'"><a href="javascript:void(0)" onclick="cambiarPermisosVisible('+data.response[i]['id_acuerdo']+', 3, 1);"><img src="/images/correcto.png" width="20px"></a></td>';
                    }
                    else{
                      permisos+='<td style="margin:0px; padding:5px; text-align:center;" id="permiso_3_'+data.response[i]['id_acuerdo']+'"><a href="javascript:void(0)" onclick="cambiarPermisosVisible('+data.response[i]['id_acuerdo']+', 3, 0);"><img src="/images/error.png" width="20px"></a></td>';
                    }
                    permisos+='</tr></table>';


                    if(data.response[i]['fecha_publicacion']==null){
                      arr_check_disable.push(i);
                    }
                    if(data.response[i]['acuerdo_mala_publicacion_bandera']==1){
                      arr_check_disable.push(i);
                    }

                    dataTableGlobal.row.add( [ 
                      hidden+fecha_publicacion,
                      resolucion,
                      concepto,
                      sivep,
                      permisos
                    ] ).draw(false);


                    setTimeout(function(){
                      $('span[title]').qtip({ 
                          content: {
                              text: false // Use each elements title attribute
                          },
                          style       : 'qtip-bootstrap'
                      });
                    }, 250);


                  }
              }
              else{
                  $('.pagina_actual_texto').html(0);
                  $('.pagina_total_texto').html(0);
              }
          }
      });
  }
}

function abrir_accordion(id_parte){
  if(window[dropdown_ + id_parte]!=1){
    window[dropdown_ + id_parte]=1;
    accionPaginatorAcuerdos_ajax_notificacion('primera', id_parte);
  }
}

function accionPaginatorAcuerdos_ajax_notificacion(pagina_accion, id_parte){

  pagina=parseInt($('#pagina_actual_notificacion_'+id_parte).val());
  registros_por_pagina=5;

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
      pagina=$('#paginas_totales_notificacion_'+id_parte).val();
  }

  if(pagina<=0 || pagina>$('#paginas_totales_notificacion_'+id_parte).val()){
      console.log('aqui');
  }
  else{
    $('#pagina_actual_notificacion_'+id_parte).val(pagina);
    $('.pagina_actual_texto_notificacion_'+id_parte).html(pagina);

    //$('#modal_loading').modal({backdrop: 'static', keyboard: false})

    $.ajax({
        type:'POST',
        url:'/acuerdo_detalle/accionPaginatorAcuerdos_ajax',
        data:{pagina:pagina, registros_por_pagina:registros_por_pagina, id:{{$id}} },
        success:function(data){
            setTimeout(function(){
                //$('#modal_loading').modal('hide');
            }, 500); 
            
            console.log(data);
            window[dataTableGlobal_notificacion_ + id_parte].clear().draw();
            //dataTableGlobal_notificacion.clear().draw();
            arr_check_disable=[];
            arr_checked=[];

            if(data.status==100){
                
                console.log(data.response);
                
                //se actualiza el total
                $('.pagina_total_texto_notificacion_'+id_parte).html(data.response_pag['paginas_totales']);
                $('#paginas_totales_notificacion_'+id_parte).val(data.response_pag['paginas_totales'])


                for(var i=0; i<data.response.length; i++){

                  //FECHA DE PUBLICACION
                  fecha_publicacion_arr=[];

                  hidden='<input type="hidden" value="'+data.response[i]['id_acuerdo']+'" id="hidden_notificacion_'+i+'_'+id_parte+'">';

                  if(data.response[i]['fecha_publicacion']!=null){
                    fecha_publicacion_arr=data.response[i]['fecha_publicacion'].split(" ");
                  }
                  else{
                    fecha_publicacion_arr[0]='';
                  }
                  fecha_publicacion=fecha_publicacion_arr[0];

                  //RESOLUCION
                  resolucion="";
                  if(data.response[i]['fecha_publicacion']!=null && data.response[i]['acuerdo_mala_publicacion_bandera']==0){
                    resolucion+='<a href="javascript:void(0);" onclick="imprimirAcuerdo(\''+data.response[i]['id_acuerdo']+',{{$archivo_detalle['response'][0]['datos_archivo']['juzgado']}},'+data.response[i]['ultima_version']+'\');">'+data.response[i]['acuerdo']+'</a>';
                  }
                  else{
                    resolucion+=data.response[i]['acuerdo'];
                  }

                  //CONCEPTO
                  concepto=data.response[i]['concepto'];
                  

                  if(data.response[i]['fecha_publicacion']==null){
                    arr_check_disable.push(i);
                  }
                  if(data.response[i]['acuerdo_mala_publicacion_bandera']==1){
                    arr_check_disable.push(i);
                  }

                  
                  if($('#arr_acuerdos_notificacion_'+id_parte).val().search(data.response[i]['id_acuerdo']) != -1){
                    arr_checked.push(data.response[i]['id_acuerdo']);
                  }

                  window[dataTableGlobal_notificacion_ + id_parte].row.add( [ 
                    hidden+fecha_publicacion,
                    resolucion,
                    concepto
                  ] ).draw(false);

                }
            }
            else{
                $('.pagina_actual_texto').html(0);
                $('.pagina_total_texto').html(0);
            }
        }
    });
  }
}

$(document).ready(function() {
    var rows_selected = [];
    var table;
    
    dataTableGlobal = table = $('#datatable1').DataTable( {
      "ordering": false,
      'columnDefs': [
        { responsivePriority: 1, targets: 5 },  
        { "targets": [0],  "orderable": false, targets: 0, "visible": true },
        { "targets": [1],  "orderable": false, targets: 0, "visible": true },
        { "targets": [2],  "orderable": false, targets: 0, "visible": true, "class":"romperCadena" },
        { "targets": [3],  "orderable": false,  },
        { "targets": [4],  "orderable": false,  },
          {
          'targets': 5,
          'searchable': false,
          'orderable': false,
          'width': '1%',
          'className': 'dt-body-center',
          'render': function (data, type, full, meta){
            //arr_check_disable=texto_check_disable.split(',');

            i_global++;
            
            //console.log('i_global: ' + i_global);
            //console.log('arr_check_disable: ' + arr_check_disable);
            

           // console.log($.inArray(i_global, arr_check_disable))

            if($.inArray(meta.row, arr_check_disable)!= -1){
              //console.log('dentro ' + i_global);
              return '';
            }
            else{
              return '<input type="checkbox" id="chbox_'+meta.row+'" class="chbox_imprimir" value="'+meta.row+'">';
            }  
         }
      }],
      bLengthChange: false,
      searching: false,
      responsive: true,
      pageLength: 5,
      paging: false,
      info: false,
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


    'use strict';

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
      language: 'es',
      showOtherMonths: true,
      selectOtherMonths: true, 
      dateFormat: 'yyyy-mm-dd'
    });

    $('#datatable33').DataTable({
      bLengthChange: false, 
      searching: false,
      responsive: true,
      "ordering": false,
      "paging":   false
    });


    dataTableGlobal2=$('#datatable2, #datatable22, #datatable3, #datatable4').DataTable({
      bLengthChange: false, 
      searching: false,
      responsive: true,
      "ordering": false,
      "pageLength": 5
    });

    //$('.usuario_actuarios').css('display', 'none');
    $('#notificacion_electronica').css('display', 'none');


    $('input[type="file"]').on('change', function(){
      var ext = $( this ).val().split('.').pop();
      if ($( this ).val() != '') {
        if(ext == "doc" || ext == "docx" || ext == "mht"){

        }
        else
        {
          alert("Extensión no permitida: " + ext); 
        }
      }
    });

    
    $('span[title]').qtip({ 
        content: {
            text: false // Use each elements title attribute
        },
        style       : 'qtip-bootstrap'
    });

    accionPaginatorAcuerdos_ajax('primera');
    //accionPaginatorAcuerdos_ajax_notificacion('primera');

    setTimeout(function(){
        $('#modal_loading').modal('hide');
    }, 500);
  });

  jQuery.extend(jQuery.validator.messages, {
      required: "<br><h5 style='color:red;'>Este campo es obligatorio.</h5>",
      remote: "Please fix this field.",
      email: "Please enter a valid email address.",
      url: "Please enter a valid URL.",
      date: "Please enter a valid date.",
      dateISO: "Please enter a valid date (ISO).",
      number: "Please enter a valid number.",
      digits: "Please enter only digits.",
      creditcard: "Please enter a valid credit card number.",
      equalTo: "Please enter the same value again.",
      accept: "Please enter a value with a valid extension.",
      maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
      minlength: jQuery.validator.format("Please enter at least {0} characters."),
      rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
      range: jQuery.validator.format("Please enter a value between {0} and {1}."),
      max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
      min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
  });
  

  var bandera_promocion_global=0;

  function actualizarNotificacion(index, id_parte){
    if( $('#chbox_notificacion_'+index+'_'+id_parte).prop('checked') ){
      $('#arr_acuerdos_notificacion_'+id_parte).val($('#arr_acuerdos_notificacion_'+id_parte).val()+','+$('#hidden_notificacion_'+index+'_'+id_parte).val());
    }
    else{
      $('#arr_acuerdos_notificacion_'+id_parte).val($('#arr_acuerdos_notificacion_'+id_parte).val().replace(','+$('#hidden_notificacion_'+index+'_'+id_parte).val(), ''));
    }

    console.log($('#hidden_notificacion_'+index+'_'+id_parte).val());
    console.log($('#arr_acuerdos_notificacion_'+id_parte).val());
  }

  function cambiar_bandera_global(bandera){
    if(bandera==1){
      bandera_promocion_global=1;
      $('#agregar_acuerdo_boton').click();
    }
    else{
      $(window).scrollTop($('#vincular_promocion').offset().top);
      $('#vincular_promocion').css('border', '4px solid red');
    }
  }


  $("form[name='registration']").validate({

    submitHandler: function(form) {

      bandera=1;


      bandera_promocion=0;
      $( ".promocion_adjuntar_class" ).each(function( index ) {
        if($(this).is(':checked')) {
          bandera_promocion=1;
        }
      });



      console.log($('#notificacion_electronica').css('display'));
      if($('#notificacion_electronica').css('display')=="block"){
        if($('#bandera_notificacion').val()==0){
          alert('ALERTA: No hay información de las partes para realizar la notificación.');
        }
        if($('#lista_actuario').val()==0){
          alert('Debe de seleccionar un actuario para continuar.');
          bandera=0;
        }
      }
      
      //se revisa el numero de acuerdo
      if($('#acuerdo').val()!="" && !$.isNumeric($('#acuerdo').val())){
        alert('En acuerdo es obligatorio y debe de ser numérico');
        $('#acuerdo').focus();
        bandera=0;
      }
      
      if($('#publicar_en_slct').val()=='OTROS'){
        if($('#publicar_en_txt').val()==''){
            alert('El campo "publicar en" es obligatorio');
            $('#publicar_en_txt').focus();
            bandera=0;
        }
      }

      if(typeof($('#hidden_estatus_procedimiento_partes')) != 'undefined' && $('#hidden_estatus_procedimiento_partes').val()=="0"){
        alert("Al menos uno de los interesados o el solicitante debe tener correo para continuar.");
        bandera=0;
      }

      

      if(typeof($('#horario_virtual')) != 'undefined' && $('input[name="etapa_procesal"]:checked').val()=="admision"){

        if($('#horario_virtual').val()==""){
          alert("Debe de escoger una fecha en el calendario");
          bandera=0;
        }
      }


      if(bandera_promocion==0 && bandera_promocion_global==0 && bandera==1){
        $('#modal_relacion_acuerdo').click();
        bandera=0;
      }
  
      //se manda a guardar si es posible
      if(bandera==1){
        agregarLoading();
        
        
        setTimeout(function(){
          form.submit();
        },1000);
      }
      else{

      }
    }
  });

  function ponerSubTipo(){
    $('#subtipo_acuerdo').empty()
    if($('#tipo_acuerdo').val()=="acuerdo"){
      $('#subtipo_acuerdo').append(new Option("Admisión", "Admisión"));
      $('#subtipo_acuerdo').append(new Option("Desechamiento", "Desechamiento"));
      $('#subtipo_acuerdo').append(new Option("Prevención", "Prevención"));
      $('#subtipo_acuerdo').append(new Option("Incompetencia", "Incompetencia"));
      $('#subtipo_acuerdo').append(new Option("Contestación de Demanda", "Contestación de Demanda"));
      $('#subtipo_acuerdo').append(new Option("Rebeldía", "Rebeldía"));
      $('#subtipo_acuerdo').append(new Option("Admisión de Pruebas", "Admisión de Pruebas"));
      $('#subtipo_acuerdo').append(new Option("Ordena Ejecución", "Ordena Ejecución"));
      $('#subtipo_acuerdo').append(new Option("Desistimiento de la Acción", "Desistimiento de la Acción"));
      $('#subtipo_acuerdo').append(new Option("Desistimiento de la Instancia", "Desistimiento de la Instancia"));
      $('#subtipo_acuerdo').append(new Option("Desistimiento de la Demanda", "Desistimiento de la Demanda"));
      $('#subtipo_acuerdo').append(new Option("Pasa a Sentencia", "Pasa a Sentencia"));
      $('#subtipo_acuerdo').append(new Option("Causa Ejecutoria Sentencia", "Causa Ejecutoria Sentencia"));
      $('#subtipo_acuerdo').append(new Option("Convenio", "Convenio"));
      $('#subtipo_acuerdo').append(new Option("Otros", "Otros"));
    }
    else if($('#tipo_acuerdo').val()=="sentencia definitiva"){
      $('#subtipo_acuerdo').append(new Option("Absolutoria", "Absolutoria"));
      $('#subtipo_acuerdo').append(new Option("Condenatoria", "Condenatoria"));
      $('#subtipo_acuerdo').append(new Option("Declarativa", "Declarativa"));
      $('#subtipo_acuerdo').append(new Option("Mixta", "Mixta"));
      $('#subtipo_acuerdo').append(new Option("En cumplimiento de amparo", "En cumplimiento de amparo"));
    }
    else if($('#tipo_acuerdo').val()=="sentencia interlocutoria"){
      $('#subtipo_acuerdo').append(new Option("Intereses", "Intereses"));
      $('#subtipo_acuerdo').append(new Option("Adjudicación Remate", "Adjudicación Remate"));
      $('#subtipo_acuerdo').append(new Option("Otros", "Otros"));
    }
    else if($('#tipo_acuerdo').val()=="audiencia"){
      $('#subtipo_acuerdo').append(new Option("Preliminar", "Preliminar"));
      $('#subtipo_acuerdo').append(new Option("De Juicio", "De Juicio"));
      $('#subtipo_acuerdo').append(new Option("De Ley", "De Ley"));
      $('#subtipo_acuerdo').append(new Option("Incidental", "Incidental"));
    }

  }
  ponerSubTipo();

  

  function ventana_mala_publicacion(id_acuerdo){
    $('#modaldemo4').find('.modal-header').html('');
    $('#modaldemo4').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
    $.ajax({
        type:'POST',
        url: "{{ route('bandeja.ventana_mala_publicacion') }}",
        data:{ id_acuerdo:id_acuerdo },
        success:function(data){
            $('#modaldemo4').find('.modal-header').html(data.plantilla_archivo_header);
            $('#modaldemo4').find('.modal-body').html(data.plantilla_archivo_body);
        }
    });
  }


  function crear_mala_publicacion(id_acuerdo){
    if(confirm('¿Esta seguro de crear una mala publicación?')){
      $('#modal_loading').modal('show');
      $.ajax({
          type:'POST',
          url:'/bandejas/crear_mala_publicacion',
          data:{ id_acuerdo:id_acuerdo, id_juicio:{{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}, comentarios:$('#comentarios_mala_publicacion').val() },
          success:function(data){
            console.log(data);
            if(data.status==100){
              alert('Se creo exitosamente.');
              location.reload();
            }
            else{
              alert(data.message);
            }
            setTimeout(function(){
              $('#modal_loading').modal('hide');
            }, 500);
            
          }
      });
    }
  }

  function cambiarTextoVisibilidad(tipo){
    if(tipo=='-'){
      $('#notificacion_electronica').css('display', 'none');
      $('#bandera_noti_elect').val(0);
      $('#texto_visibilidad').html('<strong>Descripción</strong><br><ul style="text-align: justify;"><li>En boletín judicial físico se muestra nombre de las partes, tipo de juicio, número de expediente y número de acuerdos como mínimo</li><li>En sistema SIGJ para litigantes, se envía alerta al celular y al correo electrónico, podra visualizar el contenido del documento mediante la plataforma SIGJ</li></ul>');
    }
    else if(tipo=='personal'){
      $('#bandera_noti_elect').val(1);
      $('#notificacion_electronica').css('display', 'initial');

      $('#texto_visibilidad').html('<strong>Descripción</strong><br><ul style="text-align: justify;"><li>En boletín judicial físico muestra nombre de las partes, tipo de juicio, número de expediente y número de acuerdos como mínimo</li><li>En sistema SIGJ para litigantes, no se envía alerta al celular ni correo electrónico, no se podra visualizar el contenido del documento mediante la plataforma SIGJ</li><li>Se seleccionara en la parte de abajo un método de notificación</li></ul>');
    }
    else{
      $('#bandera_noti_elect').val(0);
      $('#notificacion_electronica').css('display', 'none');
      $('#texto_visibilidad').html('<strong>Descripción</strong><br><ul style="text-align: justify;"><li>En boletín judicial físico no se muestra nombre de las partes, si se muestra tipo de juicio, número de expediente y número de acuerdos como mínimo</li><li>En sistema SIGJ para litigantes, no se envía alerta al celular ni correo electrónico, no se podra visualizar el contenido del documento mediante la plataforma SIGJ</li></ul>');
    }
  }
  
  function ponerSentenciaDivorcio(){
    if($('#tipo_acuerdo').val()=="sentencia definitiva"){
      $('#de_sentencia').prop("checked", true);
      $('#de_desechamiento').attr("disabled",true);
      $('#de_prevencion').attr("disabled",true);
      $('#de_admision').attr("disabled",true);
    }
    else{
      $('#de_desechamiento').attr("disabled",false);
      $('#de_prevencion').attr("disabled",false);
      $('#de_admision').attr("disabled",false);
      $('#de_sentencia').attr("disabled",false);
    }
    ocultar_horario_virtual();
  }

  function ocultar_horario_virtual(){
    if($('input:radio[name=etapa_procesal]:checked').val()=="admision"){
      $('.horario_virutal_label').css('display', 'initial');
    }
    else{
      $('.horario_virutal_label').css('display', 'none');
    }
  }

  function visualizarTipoEtapaProcesal(){
    if($('input:radio[name=tipo_etapa_procesal]:checked').val()=="virtual"){
      $('.tipo_virtual').css('display', 'initial');
    }
    else{
      $('.tipo_virtual').css('display', 'none');
    }
  }
 
  function ponerFirel(notificacion){
    if($(notificacion).is(':checked')){
      $("input:radio[id=firel_radio]").prop("checked", true);
      $('#firel_sicor').css('display', 'none');

      $('.usuario_actuarios').css('display', 'initial');
    }
    else{
      $('#firel_sicor').css('display', 'initial');
      $('.usuario_actuarios').css('display', 'none');
    }
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
 

  function agregar_acuerdo_sivep(id_acuerdo){
    $('#modal_loading').modal('show');

    $.ajax({
        type:'POST',
        url:'/procesosTrabajo/sivep/agregar_acuerdo_sivep_ajax',
        data:{ id_acuerdo:id_acuerdo, id_juicio:{{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}  },
        success:function(data){
          console.log(data);
          //alert(data[0].status);
          if(data[0].status==100){
             
            $('#sivep_'+id_acuerdo).html('<img src="/images/correcto.png" width="20px">');

          }
          else{
            alert(data[0].message);
          }
          setTimeout(function(){
            $('#modal_loading').modal('hide');
          }, 500);
          
        }
    });

  }


  function cambiarPermisosVisible(acuerdo_id, parte, permiso){
    $('#modal_loading').modal('show');
    $.ajax({
        type:'POST',
        url:'/bandejas/formularioAcuerdoInfoVisibleAjax',
        data:{ acuerdo_id:acuerdo_id, parte:parte, permiso:permiso },
        success:function(data){
          console.log(data);
          if(data.status==100){
            if(permiso==1){
              $('#permiso_'+parte+'_'+acuerdo_id).html('<a href="javascript:void(0)" onclick="cambiarPermisosVisible('+acuerdo_id+', '+parte+', 0);"><img src="/images/error.png" width="20px"></a>');
            }
            else{
              $('#permiso_'+parte+'_'+acuerdo_id).html('<a href="javascript:void(0)" onclick="cambiarPermisosVisible('+acuerdo_id+', '+parte+', 1);"><img src="/images/correcto.png" width="20px"></a>');
            }
          }
          else{
            alert(data.message);
          }
          setTimeout(function(){
            $('#modal_loading').modal('hide');
          }, 500);
          
        }
    });
  }


  var seleccionTotal=0;
  function seleccinarTodoRadio(){
    if(seleccionTotal==0){
      $('.radio_acuerdo').prop('checked', true);
      seleccionTotal=1;
    }
    else{
      $('.radio_acuerdo').prop('checked', false);
      seleccionTotal=0;
    }
  }


  function publicar_en_opcion(opcion){
    if(opcion=='OTROS'){
      $('#publicar_en_txt').css('display', 'block');
      setTimeout(function(){
        $('#publicar_en_txt').focus();
      },100);
      
    }
    else{
      $('#publicar_en_txt').css('display', 'none');
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

  function imprimirTodo(){
      $('#modal_loading').modal({backdrop: 'static', keyboard: false})
      $.ajax({
          type:'POST',
          url: "{{ route('bandeja.documento_descargar_masivo_ajax') }}",
          data:{ bandeja:'acuerdos', id:'{{$id}}' },
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

  function elminar_orden_expedinte_digital_ajax(){
    $('#modal_loading').modal({backdrop: 'static', keyboard: false});
    $.ajax({
      type:'POST',
      url: "{{ route('bandeja.elminar_orden_expedinte_digital_ajax') }}",
      data:{ juicio:{{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}} },
      success:function(data){
        setTimeout(function(){
          $('#modal_loading').modal('hide');
        }, 500);

        console.log(data);
        $('#modaldemo5').modal('hide');
        setTimeout(function(){
          $('#pills-expediente-tab').click();
        },800);
      }
    });
  }

  function imprimirTodoExpedienteDigital(){
    var arr_orden=arr_imprimir="";

    $( ".print_expediente_digital_modal" ).each(function( index ) {
      arr_imprimir+=$(this).val()+'-';
    });

    $( ".orden_expediente_digital_modal" ).each(function( index ) {
      arr_orden+=$(this).val()+'--';
    });

    console.log(arr_imprimir);
    console.log(arr_orden);
    
    if(arr_imprimir!=""){
      $('#modaldemo5').css('z-index', '1040');
      $('#modal_loading').modal({backdrop: 'static', keyboard: false})
      $.ajax({
        type:'POST',
        url: "{{ route('bandeja.documento_descargar_masivo_expediente_digital_ajax') }}",
        data:{ juicio:{{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}, arr_imprimir:arr_imprimir, arr_orden:arr_orden },
        success:function(data){
          console.log(data);
          setTimeout(function(){ 
            $('#modal_loading').modal('hide');
            $('#modaldemo5').css('z-index', '1050');
          }, 500);

          if(data.status==100){

              var win = window.open('/box/PDF-Flip/?pdf='+data.file, '_blank');
              //var win = window.open(data.file, '_blank');
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
  
  function imprimirSeleccion(todos){
    var arr_imprimir="";

    if(todos==0){
      $( ".chbox_imprimir" ).each(function( index ) {
        if($(this).is(':checked')) {
            arr_imprimir+=$('#data_imprimir_'+$(this).val()).val()+'-';
            console.log(arr_imprimir);
        }
      });
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


  function imprimirAcuerdo(acuerdo){
    var arr_imprimir=acuerdo;
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
 

  function notificar_acuerdo_resumen(id){
    $('#modaldemo4').find('.modal-header').html('');
    $('#modaldemo4').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
    $.ajax({
        type:'POST',
        url: "{{ route('notificaciones.notificar_acuerdo_resumen') }}",
        data:{ id:id },
        success:function(data){
            $('#modaldemo4').find('.modal-header').html(data.plantilla_archivo_header);
            $('#modaldemo4').find('.modal-body').html(data.plantilla_archivo_body);
        }
    });
  }
    
  function agregarLoading(){
    $('#modal_loading').modal({backdrop: 'static', keyboard: false})
  }

 

  function mostrarCalendarioAudiencias(secretaria){
    $('#modaldemo4').find('.modal-header').html('');
    $('#modaldemo4').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
    $.ajax({
        type:'POST',
        url: "{{ route('acuerdo_detalle.mostrarCalendarioAudiencias') }}",
        data:{ secretaria:secretaria, dia_min:'{{$lista_agenda['response']}}' },
        success:function(data){
            $('#modaldemo4').find('.modal-header').html(data.plantilla_archivo_header);
            $('#modaldemo4').find('.modal-body').html(data.plantilla_archivo_body);
          }
    });
  }

  function vistaPrevia(id_acuerdo, ponencia, id_documento, tipo_documento){
    $('#modal_loading').modal({backdrop: 'static', keyboard: false});
    $.ajax({
      type:'POST',
      url: "{{ route('bandeja.documento_descargar_ajax') }}",
      data:{ id_acuerdo:id_acuerdo, ponencia:ponencia, id_documento:id_documento, tipo_documento:tipo_documento },
      success:function(data){
        
        if(data.status==100){
            if(tipo_documento=='word' || tipo_documento=='pdf'){
                var win = window.open(data.response, '_blank');
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


  function vistaPrevia_exp_dig(id_acuerdo, ponencia, id_documento, tipo_documento){
    
    $('#modal_loading').modal({backdrop: 'static', keyboard: false});
    $('#modaldemo5').css('z-index', '1040');

    $.ajax({
      type:'POST',
      url: "{{ route('bandeja.documento_descargar_ajax') }}",
      data:{ id_acuerdo:id_acuerdo, ponencia:ponencia, id_documento:id_documento, tipo_documento:tipo_documento, copia:1 },
      success:function(data){
        if(data.status==100){
          $('#preview_exp_dig_pdf').html("");
          $('#preview_exp_dig_pdf').html('<object data="'+data.response+'" type="application/pdf" id="" width="100%" class="ht-100v"></object>');

        }
        else{
            alert(data.message);
        }

        setTimeout(function(){
            $('#modaldemo5').css('z-index', '1050');
            $('#modal_loading').modal('hide');
        }, 800);
      }
    });
  }


  function openDocumentoGestor_exp_dig(id){


    $('#modaldemo5').css('z-index', '1040');
    $.ajax({
      type:'POST',
      url: "/descargarGestor",
      data:{ idGlobal:id, save:1 },
      success:function(data){
        
        $('#preview_exp_dig_pdf').html("");
        $('#preview_exp_dig_pdf').html('<object data="'+data+'" type="application/pdf" id="" width="100%" class="ht-100v"></object>');

        

        setTimeout(function(){
            $('#modaldemo5').css('z-index', '1050');
            $('#modal_loading').modal('hide');
        }, 800);
        
      }
    });
  }


  function expediente_digital(){
    $('#modaldemo5').find('.modal-header').html('');
    $('#modaldemo5').find('.modal-body').html('<div class="col-md-12 col-xl-12"><div class="d-flex  ht-300 pos-relative align-items-center">    <div class="sk-three-bounce">        <div class="sk-child sk-bounce1 bg-gray-800"></div>        <div class="sk-child sk-bounce2 bg-gray-800"></div>        <div class="sk-child sk-bounce3 bg-gray-800"></div>      </div> </div><!-- d-flex --></div><!-- col-4 -->');
    $.ajax({
        type:'POST',
        url: "{{ route('acuerdo_detalles.expediente_digital') }}",
        data:{ id_juicio:{{$archivo_detalle['response'][0]['datos_archivo']['id_juicio']}}, juzgado:'{{$archivo_detalle['response'][0]['datos_archivo']['juzgado']}}' },
        success:function(data){
            setTimeout(function(){
              $('#modaldemo5').find('.modal-header').html(data.plantilla_archivo_header);
              $('#modaldemo5').find('.modal-body').html(data.plantilla_archivo_body);
            }, 500);
          }
    });
  }

  function eliminarRelacion(id_acuerdo, id_promocion){
    if(confirm('¿Esta seguro de eliminar la relación?')){
      $.ajax({
        type:'POST',
        url: "{{ route('acuerdo_detalles.eliminar_relacion') }}",
        data:{ id_acuerdo:id_acuerdo, id_promocion:id_promocion },
        success:function(data){
            console.log(data);
            location.reload();
          }
      });
    }
  }

  function crear_relacion_acuerdo(id_acuerdo){
    
    var arr_orden=arr_promocion="";

    $( ".promocion_adjuntar_ventana" ).each(function( index ) {
      if(this.checked){
        arr_promocion+=$(this).val()+'-';
      }
    });

    if(arr_promocion!=""){

      $.ajax({
        type:'POST',
        url: "{{ route('acuerdo_detalles.crear_relacion_promocion_accion') }}",
        data:{ arr_promocion:arr_promocion, id_acuerdo:id_acuerdo },
        success:function(data){
            location.reload();
        }
      });

    }
    else{
      alert("Debe de seleccionar alguna promoción");
    }
    console.log(arr_promocion);
  }


  function eliminarCaratula(id_promocion){
      if(confirm('¿Estas seguro de eliminarla?')){
          $.ajax({
              type:'POST',
              url:'/promociones/eliminar_caratula',
              data:{ id_promocion:id_promocion },
              success:function(data){
                  console.log(data);
                  if(data.status==100){
                    location.reload();
                  }
                  else{
                    alert(data.message);
                  }
              }
          });
      }
  }

  

  function editar_promocion_adjunto_visor(id_promocion, id_adjunto, status){
    $.ajax({
        type:'POST',
        url:'/promociones/editar_promocion_adjunto_visor',
        data:{ id_promocion:id_promocion, id_adjunto:id_adjunto, status:status  },
        success:function(data){
            console.log(data);
            if(data.status==100){
              if(status==0){
                $('#ocultar_promocion_'+id_adjunto).html('<span id="ocultar_promocion_'+id_adjunto+'"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor('+id_promocion+','+id_adjunto+',1);"><i class="fa fa-eye-slash tx-18"></i></a></span>');
              }
              else{
                $('#ocultar_promocion_'+id_adjunto).html('<span id="ocultar_promocion_'+id_adjunto+'"><a href="javascript:void(0);" onclick="editar_promocion_adjunto_visor('+id_promocion+','+id_adjunto+',0);"><i class="fa fa-eye tx-18"></i></a></span>');
              }
              //location.reload();
            }
            else{
              alert(data.message);
            }
        }
    });
  }

</script>

@endsection

@section('seccion-modales')

<!-- LARGE MODAL -->
<div class="modal fade" id="modaldemo3" tabindex="10" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
    <div class="modal-content tx-size-sm" >
      <div class="modal-header pd-x-20">
      </div>
      <div class="modal-body pd-20">
      </div><!-- modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="regresarBandera();">Cerrar</button>
      </div>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- LARGE MODAL -->
<div id="modaldemo4" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document" style="width: 95%;">
    <div class="modal-content tx-size-sm">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Resumen de notificaciones</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-20">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div id="modaldemo5" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-vertical-center " role="document" style="width: 100%; margin: 0; padding: 0; max-width:1200px;">
    <div class="modal-content tx-size-sm ht-100v" style="">
      <div class="modal-header pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Resumen de notificaciones</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ht-auto" style="height:88%;"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->


<a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#modaldemo2" id="modal_relacion_acuerdo"></a>
    <div id="modaldemo2" class="modal fade">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Alerta</h6>
          </div>
          <div class="modal-body pd-20">
            <p class="mg-b-5"><h4 class="tx-danger">No ha vinculado ninguna promoción para esta resolución, ¿Desea vincular una?</h4></p>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="cambiar_bandera_global(0);">Sí</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cambiar_bandera_global(1);">No</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
@endsection