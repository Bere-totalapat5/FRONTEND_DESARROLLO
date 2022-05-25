@php
    use App\Http\Controllers\clases\humanRelativeDate;
    $humanRelativeDate = new humanRelativeDate();
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
    <div class="alert alert-warning mg-b-0" role="alert">
      <strong>ALERTA</strong> {{$error}}
    </div><!-- alert -->
@endif
    <div class="section-wrapper" >
        <div class="table-wrapper" >
          
          <div class="media-body">
            <h3 class="card-profile-name">Resoluciones del {{$request->lang['toca']}} {{$archivo_detalle['response']['datos_toca'][0]['toca']}}/{{$archivo_detalle['response']['datos_toca'][0]['anio_toca']}}@if($archivo_detalle['response']['datos_toca'][0]['asunto_toca']!=""){{"/".$archivo_detalle['response']['datos_toca'][0]['asunto_toca']}} @endif</h3>
            <p class="card-profile-position">
              <table style="width:100%;">
                <tr>
                  <td class="wd-20p">
                    @isset($archivo_detalle['response']['partes']['partes']['actor'])

                    

                      <strong >ACTOR</strong><br>
                      @foreach ($archivo_detalle['response']['partes']['partes']['actor'] as $parte)
                          <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['nombres']}} {{$parte['apeliido_paterno']}} {{$parte['apellido_materno']}}</div>
                      @endforeach
                    @endisset
                  </td>
                  
                  @isset($archivo_detalle['response']['partes']['partes']['demandado'])
                    <td class="wd-5p">
                      VS
                    </td>
                    <td class="wd-20p">
                        <strong >DEMANDADO</strong><br>
                        @foreach ($archivo_detalle['response']['partes']['partes']['demandado'] as $parte)
                            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['nombres']}} {{$parte['apeliido_paterno']}} {{$parte['apellido_materno']}}</div>
                        @endforeach
                    </td>
                  @endisset

                  @isset($archivo_detalle['response']['partes']['partes']['terceros'])
                    <td class="wd-5p">
                      VS
                    </td>
                    <td class="wd-20p">
                      <strong >TERCERO</strong><br>
                      @foreach ($archivo_detalle['response']['partes']['partes']['terceros'] as $parte)
                          <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">{{$parte['nombres']}} {{$parte['apeliido_paterno']}} {{$parte['apellido_materno']}}</div>
                      @endforeach
                    </td>
                  @endisset
                </tr>
              </table>
            </p>
          </div>

        
          <div class="nav-statistics-wrapper">
            <nav class="nav" style="width: 100$;">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Acuerdos</a>
              <a class="nav-link" id="pills-demandas-tab" data-toggle="pill" href="#pills-demandas" role="tab" aria-controls="pills-demandas" aria-selected="false">Demandas</a>
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Promociones</a>
            </nav>
          </div><!-- nav-statistics-wrapper -->

          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">




            <a href="javascript:void(0)" onclick="imprimirSeleccion(0);">Imprimir selección</a>   |    <a href="javascript:void(0)" onclick="imprimirTodo();">Imprimir todo</a>
            <table id="datatable1" class="table display responsive nowrap">
                <thead>
                <tr>
                    <th class="wd-15p">Publicación</th>
                    <th class="wd-15p">Resolución</th>
                    <th class="wd-20p">Concepto</th>
                    <th class="wd-15p">
                      <table width="100%">
                        <thead>
                        <tr>
                          <th style="margin:0px; padding:0px;" colspan="3"><center>Permisos</center></th>
                        </tr>
                        <tr>
                          <th style="margin:0px; padding:5px;">Actor</th>
                          <th style="margin:0px; padding:5px;">Demandado</th>
                          <th style="margin:0px; padding:5px;">Tercero</th>
                        </tr>
                      </thead>
                      </table>
                    </th>
                    <th><input name="select_all" value="1" type="checkbox"></th>
                </tr>
                </thead>
                <tbody>
                  @isset($lista_acuerdos['response'][0]['id_acuerdo'])
                    @php $i=0; @endphp
                    @foreach ($lista_acuerdos['response'] as $acuerdo)

                      <tr>
                        <td>
                          <input type="hidden" value="{{$acuerdo['id_acuerdo']}},{{$archivo_detalle['response']['datos_toca'][0]['juzgado']}},{{$acuerdo['ultima_version']}}" id="data_imprimir_{{$i}}">
                          @php $fecha_publicacion=explode(' ' , $acuerdo['fecha_publicacion']); @endphp
                          {{$fecha_publicacion[0]}}
                        </td>
                        <td>{{$acuerdo['acuerdo']}}
                        

                          @isset($acuerdo['notificacion_electronica'][0]['id_noti_elect'])
                            <br><small><i class="fa fa-exclamation-triangle"></i> notificacion electrónica - {{$acuerdo['notificacion_electronica'][0]['noti_elect_estatus_envio']}}</small>
                            @if($acuerdo['fecha_publicacion']!="")
                              @if($acuerdo['acuerdo_url_doc_noti']!="")
                                <small><br><a href="{{$acuerdo['acuerdo_url_doc_noti']}}" target="_blank">Cedula de notificación</a></small>
                              @endif
                              @isset($acuerdo['notificacion_leida'][0]['id_lectura'])
                                <br><small><span title="@foreach($acuerdo['notificacion_leida'] as $notificacion)  {{$notificacion['usuario']}} - {{$notificacion['lectura_fecha']}}<br>  @endforeach">Partes notificadas</span></small>
                              @endisset
                            @endif
                          @endisset
                        
                        
                        </td>
                        <td>
                          Tipo de flujo: <strong><a href="" data-toggle="modal" data-target="#modaldemo3" onclick="cargarFlujo({{$acuerdo['id_juicio']}}, {{$acuerdo['id_acuerdo']}}, '{{$acuerdo['acuerdo']}}', 0);">{{$acuerdo['tipo_firma_codigo']}}</a></strong><br>
                          @isset($acuerdo['posesion_de'][0]['usuario'])
                            En posesión: <span title="@if($acuerdo['posesion_de'][0]['flujo_sala_tipo_participante']=="Juez Magistrado") Magistrado @else {{$acuerdo['posesion_de'][0]['flujo_sala_tipo_participante']}} @endif"><strong>{{$acuerdo['posesion_de'][0]['usuario']}}</strong></span>
                          @else
                            @if($acuerdo['fecha_publicacion']!="")
                              Termiando
                            @else
                              <a href="/acuerdo_flujo/{{$acuerdo['id_juicio']}}/{{$acuerdo['id_acuerdo']}}">Flujo pendiente</a>
                            @endif
                          @endisset
                        </td>
                        <td>
                          <table width="100%" style="">
                            
                          <tr style="background-color:transparent;">
                              @if($acuerdo['permiso_parte1']=='S')
                                <td style="margin:0px; padding:5px;" id="permiso_1_{{$acuerdo['id_acuerdo']}}"><a href="javascript:void(0)" onclick="cambiarPermisosVisible({{$acuerdo['id_acuerdo']}}, 1, 1);"><img src="/images/correcto.png" width="20px"></a></td>
                              @else
                                <td style="margin:0px; padding:5px;" id="permiso_1_{{$acuerdo['id_acuerdo']}}"><a href="javascript:void(0)" onclick="cambiarPermisosVisible({{$acuerdo['id_acuerdo']}}, 1, 0);"><img src="/images/error.png" width="20px"></a></td>
                              @endif

                              @if($acuerdo['permiso_parte2']=='S')
                                <td style="margin:0px; padding:5px;" id="permiso_2_{{$acuerdo['id_acuerdo']}}"><a href="javascript:void(0)" onclick="cambiarPermisosVisible({{$acuerdo['id_acuerdo']}}, 2, 1);"><img src="/images/correcto.png" width="20px"></a></td>
                              @else
                                <td style="margin:0px; padding:5px;" id="permiso_2_{{$acuerdo['id_acuerdo']}}"><a href="javascript:void(0)" onclick="cambiarPermisosVisible({{$acuerdo['id_acuerdo']}}, 2, 0);"><img src="/images/error.png" width="20px"></a></td>
                              @endif

                              @if($acuerdo['permiso_parte3']=='S')
                                <td style="margin:0px; padding:5px;" id="permiso_3_{{$acuerdo['id_acuerdo']}}"><a href="javascript:void(0)" onclick="cambiarPermisosVisible({{$acuerdo['id_acuerdo']}}, 3, 1);"><img src="/images/correcto.png" width="20px"></a></td>
                              @else
                                <td style="margin:0px; padding:5px;" id="permiso_3_{{$acuerdo['id_acuerdo']}}"><a href="javascript:void(0)" onclick="cambiarPermisosVisible({{$acuerdo['id_acuerdo']}}, 3, 0);"><img src="/images/error.png" width="20px"></a></td>
                              @endif

                            </tr>
                          
                          </table>

                        </td>
                        
                        <td></td>
                        
                      </tr>
                      <script>
                        @if($acuerdo['fecha_publicacion']=="")
                          setTimeout(function(){
                            $('#chbox_{{$i}}').css('display', 'none');
                          }, 2000);
                        @endif
                      </script>
                      @php $i++; @endphp
                    @endforeach
                  @endisset


                </tbody>
            </table>

          </div>
          <div class="tab-pane fade" id="pills-demandas" role="tabpanel" aria-labelledby="pills-demandas-tab">
            

            

            <table id="datatable2" class="table display responsive nowrap" style="width: 100%;">
              <thead>
              <tr>
                  <th class="wd-15p">Fecha de recepción</th>
                  <th class="wd-15p">Adjuntos</th>
              </tr>
              </thead>
              <tbody>
                @isset($lista_demandas['response'][0]['fecha_recepcion'])
                  @php $i=0; @endphp
                  @foreach ($lista_demandas['response'] as $promociones)

                    <tr>
                      <td>
                        @php $fecha_arr=explode(' ', $promociones['fecha_recepcion']); @endphp
                            {{$fecha_arr[0]}}<br>@if($fecha_arr[1]!="00:00:00") {{$fecha_arr[1]}}<br> @endif 
                            @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]); print($fechaCreacion); @endphp
                      </td>
                      <td>
                        @php $adjuntos_int=0 @endphp
                        @foreach($promociones['adjuntos'] as $adjuntos)
                            @isset($adjuntos['json_arr']->idDocument)
                                @if($adjuntos_int==0)
                                    <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});" >Demanda</a>
                                @else
                                <br><a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});">Adjunto {{$adjuntos_int}}</a>
                                @endif
                                @php $adjuntos_int++; @endphp
                            @endisset

                            @isset($adjuntos['json_arr']->idGlobal)
                                @if($adjuntos_int==0)
                                    <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});" >Demanda</a>
                                @else
                                <br><a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});">Adjunto {{$adjuntos_int}}</a>
                                @endif
                                @php $adjuntos_int++; @endphp
                            @endisset

                        @endforeach
                      </td>
                      
                      
                    </tr>

                    @php $i++; @endphp
                  @endforeach
                @endisset


              </tbody>
          </table>





          </div>


          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            

            <table id="datatable3" class="table display responsive nowrap" style="width: 100%;">
              <thead>
              <tr>
                  <th class="wd-15p">Fecha de recepción</th>
                  <th class="wd-15p">Adjuntos</th>
              </tr>
              </thead>
              <tbody>
                @isset($lista_promociones['response'][0]['fecha_recepcion'])
                  @php $i=0; @endphp
                  @foreach ($lista_promociones['response'] as $promociones)

                    <tr>
                      <td>
                        @php $fecha_arr=explode(' ', $promociones['fecha_recepcion']); @endphp
                            {{$fecha_arr[0]}}<br>@if($fecha_arr[1]!="00:00:00") {{$fecha_arr[1]}}<br> @endif 
                            @php $fechaCreacion=$humanRelativeDate->getTextForSQLDate($fecha_arr[0]); print($fechaCreacion); @endphp
                      </td>
                      <td>
                        @php $adjuntos_int=0 @endphp
                        @foreach($promociones['adjuntos'] as $adjuntos)
                            @isset($adjuntos['json_arr']->idDocument)
                                @if($adjuntos_int==0)
                                    <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});" >Demanda</a>
                                @else
                                <br><a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idDocument}});">Adjunto {{$adjuntos_int}}</a>
                                @endif
                                @php $adjuntos_int++; @endphp
                            @endisset


                            @isset($adjuntos['json_arr']->idGlobal)
                                @if($adjuntos_int==0)
                                    <a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});" >Demanda</a>
                                @else
                                <br><a href="javascript:void(0);" onclick="openDocumentoGestor({{$adjuntos['json_arr']->idGlobal}});">Adjunto {{$adjuntos_int}}</a>
                                @endif
                                @php $adjuntos_int++; @endphp
                            @endisset
                            
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
      <form method="POST" action="{{ route('acuerdo_detalles.guardar') }}" enctype="multipart/form-data" name="registration" id="registration">
        <label class="section-title">Agregar Resolución</label>
          <p class="mg-b-20 mg-sm-b-40">
            <label class="ckbox">
              <input type="checkbox" id="excusa" name="excusa" value="1" onchange="banderaConExcusa();"><span>Acuerdo con excusa</span>
            </label>
          </p>
  
          @csrf
          <input type="hidden" id="id_juicio"  name="id_juicio" value="{{$archivo_detalle['response']['datos_toca'][0]['id_juicio']}}">
          <input type="hidden" id="juicio"  name="juicio" value="{{$archivo_detalle['response']['datos_toca'][0]['toca']}}/{{$archivo_detalle['response']['datos_toca'][0]['anio_toca']}}@if($archivo_detalle['response']['datos_toca'][0]['asunto_toca']!=""){{"/".$archivo_detalle['response']['datos_toca'][0]['asunto_toca']}} @endif">
          
          <div class="form-layout">
              <div class="row mg-b-10">
                

                {!! $errors->first('tipo_flujo', '<div class="alert alert-danger mg-b-20" role="alert" style="width: 100%;">
                  <strong>Error</strong> Debe seleccionar un tipo de firma, sino estan disponibles, favor de consultar en el administrador.
                </div>') !!}
                




                  <div class="col-lg-12 firma_sin_documento sin_exucsa">
                    <div class="form-group">
                      <label class="section-title">Tipo de firma:</label>
                    </div>
                  </div><!-- col-2 -->
                  <div class="col-lg-2 firma_sin_documento sin_exucsa">
                    <div class="form-group mg-b-10-force">
                      <label class="rdiobox">
                        <input name="tipo_firma" type="radio" onchange="cambiar_tipo_firma(this.value);" value="colegiada" id="colegiada">
                        <span>Colegiada</span>
                      </label>
                      <label class="rdiobox">
                        <input name="tipo_firma" type="radio" onchange="cambiar_tipo_firma(this.value);" checked value="unitaria" id="unitaria" >
                        <span>Unitaria</span>
                      </label>
                    </div>
                  </div><!-- col-2 -->
                  <div class="col-lg-6 firma_sin_documento sin_exucsa">

                    <div class="form-group" id="flujos_unitarios" >

                      @isset($lista_firmas['response']['unitario'])
                        @foreach ($lista_firmas['response']['unitario'] as $firma)
                          
                          <label class="rdiobox">
                            <input name="tipo_flujo" required type="radio" value="{{$firma['id_tipo_firma']}}" onchange="personalizaFirma('{{$firma['tipo_firma_codigo']}}');" @if ($loop->first) @php $primer_tipo=$firma['tipo_firma_codigo']; @endphp checked @endif id="primer_chk" >
                            <span>{{$firma['tipo_firma_nombre']}}</span>
                          </label>
                        @endforeach
                      @endisset
                    </div>

                    <div class="form-group" id="flujos_colegiados" style="display:none;">
                      @isset($lista_firmas['response']['unitario'])
                        @foreach ($lista_firmas['response']['colegiado'] as $firma)
                          
                          <label class="rdiobox">
                            <input name="tipo_flujo" required type="radio" value="{{$firma['id_tipo_firma']}}" onchange="personalizaFirma('{{$firma['tipo_firma_codigo']}}');" @if ($loop->first) @endif id="primer_chk_c" >
                            <span>{{$firma['tipo_firma_nombre']}}</span>
                          </label>
                        @endforeach
                      @endisset
                    </div>
                  </div><!-- col-6 -->
                  
                  <div class="col-lg-4 firma_sin_documento sin_exucsa">
                    <div class="form-group">
                        
                    </div>
                  </div><!-- col-4 -->                
                
                
                <div class="row col-lg-12 mg-b-20 pd-t-10 " style="" id="">
                  
                  <div class="col-lg-6 firmante_calidad sin_exucsa" style="display:none;" >
                    <label class="section-title">Selecciona un firmante:</label>
                  
                      <div class="form-group">
                      @php $bandera=0; @endphp
                      <label class="rdiobox" @if(!($archivo_detalle['response']['datos_toca'][0]['secretaria']=="1" or $archivo_detalle['response']['datos_toca'][0]['secretaria']=="")) style="display: none;" @endif >
                        <input name="ponencia_origen" class="ponencia_origen" type="radio" value="1" id="ponencia1" @if(($archivo_detalle['response']['datos_toca'][0]['secretaria']=="1" or $archivo_detalle['response']['datos_toca'][0]['secretaria']=="")) checked="checked" @endif  >
                        <span>Ponencia 1</span>
                      </label>
                      <label class="rdiobox" @if(!($archivo_detalle['response']['datos_toca'][0]['secretaria']=="2" or $archivo_detalle['response']['datos_toca'][0]['secretaria']=="")) style="display: none;" @endif >
                        <input name="ponencia_origen" class="ponencia_origen" type="radio"  value="2" id="ponencia2"  @if(($archivo_detalle['response']['datos_toca'][0]['secretaria']=="2" or $archivo_detalle['response']['datos_toca'][0]['secretaria']=="")) checked="checked" @endif>
                        <span>Ponencia 2</span>
                      </label>
                      <label class="rdiobox" @if(!($archivo_detalle['response']['datos_toca'][0]['secretaria']=="3" or $archivo_detalle['response']['datos_toca'][0]['secretaria']=="")) style="display: none;" @endif >
                        <input name="ponencia_origen" class="ponencia_origen" type="radio"  value="3" id="ponencia3" @if(($archivo_detalle['response']['datos_toca'][0]['secretaria']=="3" or $archivo_detalle['response']['datos_toca'][0]['secretaria']=="")) checked="checked" @endif >
                        <span>Ponencia 3</span>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-6 firmante_calidad sin_exucsa"  style="display: none;">
                    <label class="section-title">En calidad de:</label>
                    <div class="form-group">
                      <label class="rdiobox">
                        <input name="en_calidad" type="radio" class="en_calidad" checked value="presidente" id="presidente">
                        <span>Presidente</span>
                      </label>
                      <label class="rdiobox">
                        <input name="en_calidad" type="radio" class="en_calidad" value="semanero" id="semanero" >
                        <span>Semanero</span>
                      </label>
                      <label class="rdiobox">
                        <input name="en_calidad" type="radio" class="en_calidad" value="ponente" id="ponente" >
                        <span>Ponente</span>
                      </label>
                    </div>
                </div>
              </div>
  






              <div class="col-lg-12 firma_sin_documento con_exucsa">
                    <div class="form-group">
                      <label class="section-title">Tipo de firma con excusa:</label>
                    </div>
                  </div><!-- col-2 -->
                  <div class="col-lg-2 firma_sin_documento con_exucsa">
                    <div class="form-group mg-b-10-force">
                      <label class="rdiobox">
                        <input name="tipo_firma" type="radio" onchange="cambiar_tipo_firma_excusa(this.value);" value="colegiada" id="colegiada_excusa">
                        <span>Colegiada</span>
                      </label>
                      <label class="rdiobox">
                        <input name="tipo_firma" type="radio" onchange="cambiar_tipo_firma_excusa(this.value);" checked value="unitaria" id="unitaria_excusa" >
                        <span>Unitaria</span>
                      </label>
                    </div>
                  </div><!-- col-2 -->
                  <div class="col-lg-6 firma_sin_documento con_exucsa">

                    <div class="form-group" id="flujos_unitarios_excusa" >

                      @isset($lista_firmas_excusa['response']['unitario'])
                        @foreach ($lista_firmas_excusa['response']['unitario'] as $firma)
                          
                          <label class="rdiobox">
                            <input name="tipo_flujo" required type="radio" value="{{$firma['id_tipo_firma']}}" onchange="personalizaFirma_excusa('{{$firma['tipo_firma_codigo']}}');" @if ($loop->first) @php $primer_tipo=$firma['tipo_firma_codigo']; @endphp checked @endif id="primer_chk_excusa" >
                            <span>{{$firma['tipo_firma_nombre']}}</span>
                          </label>
                        @endforeach
                      @endisset
                    </div>

                    <div class="form-group" id="flujos_colegiados_excusa" style="display:none;">
                      @isset($lista_firmas_excusa['response']['unitario'])
                        @foreach ($lista_firmas_excusa['response']['colegiado'] as $firma)
                          
                          <label class="rdiobox">
                            <input name="tipo_flujo" required type="radio" value="{{$firma['id_tipo_firma']}}" onchange="personalizaFirma_excusa('{{$firma['tipo_firma_codigo']}}');" @if ($loop->first) @endif id="primer_chk_c_excusa" >
                            <span>{{$firma['tipo_firma_nombre']}}</span>
                          </label>
                        @endforeach
                      @endisset
                    </div>
                  </div><!-- col-6 -->
                  
                  <div class="col-lg-4 firma_sin_documento con_exucsa">
                    <div class="form-group">
                        
                    </div>
                  </div><!-- col-4 -->                
                
                
                <div class="row col-lg-12 mg-b-20 pd-t-10 "  id="">
                  
                  <div class="col-lg-6  firmante_calidad_excusa"  style="display:none;">
                    <label class="section-title">Selecciona un firmante:</label>
                  
                      <div class="form-group">
                      @php $bandera=0; @endphp
                      <label class="rdiobox"  >
                        <input name="ponencia_origen" class="ponencia_origen_excusa" type="radio" value="1" id="ponencia1"  checked="checked"  >
                        <span>Ponencia 1</span>
                      </label>
                      <label class="rdiobox"  >
                        <input name="ponencia_origen" class="ponencia_origen_excusa" type="radio"  value="2" id="ponencia2"   >
                        <span>Ponencia 2</span>
                      </label>
                      <label class="rdiobox"  >
                        <input name="ponencia_origen" class="ponencia_origen_excusa" type="radio"  value="3" id="ponencia3"  >
                        <span>Ponencia 3</span>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-6  firmante_calidad_excusa" style="display:none;">
                    <label class="section-title">En calidad de:</label>
                    <div class="form-group">
                      <label class="rdiobox">
                        <input name="en_calidad" class="en_calidad_excusa" type="radio" checked value="presidente" id="presidente">
                        <span>Presidente</span>
                      </label>
                      <label class="rdiobox">
                        <input name="en_calidad" class="en_calidad_excusa" type="radio" value="semanero" id="semanero" >
                        <span>Semanero</span>
                      </label>
                      <label class="rdiobox">
                        <input name="en_calidad" class="en_calidad_excusa" type="radio" value="ponente" id="ponente" >
                        <span>Ponente</span>
                      </label>
                    </div>
                </div>
              </div>













  
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" ><span class="tx-danger">*</span> Resolución:</label>
                  
                      <table>
                          <tr>
                          <td><strong>{{$archivo_detalle['response']['datos_toca'][0]['toca']}}/{{$archivo_detalle['response']['datos_toca'][0]['anio_toca']}}@if($archivo_detalle['response']['datos_toca'][0]['asunto_toca']!=""){{"/".$archivo_detalle['response']['datos_toca'][0]['asunto_toca']}} @endif-</strong></td>
                          <td><input class="form-control" type="text" name="acuerdo" id="acuerdo" value="{{$lista_acuerdos['resolucion']}}" placeholder="" required></td>
                          </tr>
                      </table>
                    
                  </div>
                </div><!-- col-6 -->

                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" ><span class="tx-danger">*</span> Tipo de Resolución: <span id="tipo_resolucion_span">Acuerdo</span></label>
                    <input type="hidden" value="acuerdo" id="tipo_acuerdo" name="tipo_acuerdo">
                  </div>
                </div><!-- col-6 -->


                @if($bandera_permiso_publicacion["response"]==1)
                <div class="col-lg-6">
                    <div class="form-group" id="">
                        <label class="form-control-label" >Fecha de publicación:</label>
                        <div class="input-group">
                        
                        <div class="input-group-prepend">

                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                        </div>
                        <input id="fecha_publicacion" name="fecha_publicacion" type="text" class="form-control datepicker1" placeholder="" value="{{$request->proxima_publicacion['response']}}" data-date-format="yyyy-mm-dd" readonly="readonly"  >
                        </div>
                    </div>
                </div>
                @endif
  
  
  
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" >Caso especial:</label>
                  
                    <select class="form-control select2" data-placeholder="" id="especial" name="especial" onchange="selectEspecial(this.value);" >
                      <option value="-" @if(old('especial')=='-') selected @endif >Ninguno</option>
                      <option value="no publicado" @if(old('especial')=='no publicado') selected @endif>No publicado</option>
                      <option value="mal publicado" @if(old('especial')=='mal publicado') selected @endif>Mal publicado</option>
                    </select>
                  </div>
                </div><!-- col-6 -->
                

                

                <div class="col-lg-12" >

                  <div class="col-lg-6">
                      <div class="form-group" style="display:none;" id="sin_documento_div">
                          <label class="ckbox">
                            <input type="checkbox" id="sin_documento" name="sin_documento" value="1" onclick="mostrarFlujoSinDocumento();"><span>Publicar sin documento</span>
                          </label>
                      </div>

                      <div class="form-group" style="display:none;" id="fecha_especial_div">
                        <label class="form-control-label" ><span class="tx-danger">*</span> Fecha en que se publicó erróneamente:</label>
                        <div class="input-group">
                          
                          <div class="input-group-prepend">

                          <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                          </div>
                          <input id="fecha_especial" name="fecha_especial" type="text" class="form-control fc-datepicker" placeholder="YYYY-MM-DD" data-date-format="yyyy-mm-dd" readonly="readonly" required >
                        </div>
                      </div>

                      <div class="form-group" style="display:none;" id="anotacion_div">
                        <label class="form-control-label" ><span class="tx-danger">*</span> Anotación:</label>
                        <input class="form-control" type="text" name="anotacion" id="anotacion" value="{{ old('anotacion') }}" placeholder="" required>
                      </div>

                      <div class="form-group" style="display:none;" id="tipo_resolucion_radio_div">
                        <label class="form-control-label" >Tipo de resolución:</label>
                        
                        <label class="rdiobox">
                          <input name="tipo_resolucion_radio" type="radio" id="v_acuerdo" value="acuerdo" @empty(old('tipo_resolucion_radio')) checked  @endempty  @if(old('tipo_resolucion_radio')=='acuerdo') checked @endif onchange="cambiarTipoResolucion(this.value);" >
                          <span>Acuerdo</span>
                        </label>

                        <label class="rdiobox">
                          <input name="tipo_resolucion_radio" type="radio" id="v_sentencia" value="sentencia" @if(old('tipo_resolucion_radio')=='sentencia') checked @endif onchange="cambiarTipoResolucion(this.value);" >
                          <span>Sentencia</span>
                        </label>
                        <label class="rdiobox">
                          <input name="tipo_resolucion_radio" type="radio" id="v_audiencia" value="audiencia" @if(old('tipo_resolucion_radio')=='audiencia') checked @endif onchange="cambiarTipoResolucion(this.value);" >
                          <span>Audiencia</span>
                        </label>
                      </div>

                  </div>
                </div>
              

  
  
                <div class="col-lg-6 firma_sin_documento">
                  <div class="form-group">
                    <label class="form-control-label" >Resuelve:</label>
                    <select class="form-control select2" data-placeholder="" id="resuelve" name="resuelve">
                    <option value="Admite" @if(old('resuelve')=='Admite') selected @endif>Admite</option>
                    <option value="Inadmisible" @if(old('resuelve')=='Inadmisible') selected @endif>Inadmisible</option>
                    <option value="Extemporaneo" @if(old('resuelve')=='Extemporaneo') selected @endif>Extemporaneo</option>
                    <option value="Prevencion" @if(old('resuelve')=='Prevencion') selected @endif>Prevención</option>
                    <option value="Adm. Mod. G." @if(old('resuelve')=='Adm. Mod. G.') selected @endif>Adm. Mod. G.</option>
                    <option value="Citacion" @if(old('resuelve')=='Citacion') selected @endif>Citación</option>
                    <option value="Tramite" @if(old('resuelve')=='Tramite') selected @endif>Trámite</option>
                  </select>
                  </div>
                </div><!-- col-6 -->
                
  


                <div class="col-lg-6 firma_sin_documento">
                  <div class="form-group">
                    <label class="form-control-label" >Publicar en:</label>
                    <select class="form-control select2" data-placeholder="" id="publicar_en_slct" name="publicar_en_slct" onchange="publicar_en_opcion(this.value)">
                      <option value="TOCA">TOCA</option>
                      <option value="CUADERNO DE AMPARO" @if(old('publicar_en_slct')=='CUADERNO DE AMPARO') selected @endif>CUADERNO DE AMPARO</option>
                      <option value="REPOSICION DE TOCAS" @if(old('publicar_en_slct')=='REPOSICION DE TOCAS') selected @endif>REPOSICIÓN DE TOCAS</option>
                      <option value="REPOSICION DE CUADERNO DE AMPAROS" @if(old('publicar_en_slct')=='REPOSICION DE CUADERNO DE AMPAROS') selected @endif>REPOSICIÓN DE CUADERNO DE AMPAROS</option>
                      <option value="OTROS" @if(old('publicar_en_slct')=='OTROS') selected @endif>OTRO</option>
                  </select>
                  </div>
                </div><!-- col-6 -->
                

                <div class="col-lg-6 firma_sin_documento">
                  <div class="form-group">
                    <input class="form-control" type="text" name="publicar_en_txt" id="publicar_en_txt" value="{{ old('publicar_en_txt') }}" @if(old('publicar_en_slct')=='OTROS') style="display:block;" @else style="display:none;" @endif  placeholder="" required>
                  </div>
                </div>
                <div class="col-lg-6 firma_sin_documento">
                </div>

                <div class="col-lg-12 firma_sin_documento">
                  <div class="form-group">
                    <label class="form-control-label" >Concepto:</label>
                  <input class="form-control" type="text" name="concepto" id="concepto" value="{{ old('concepto') }}" placeholder="">
                  </div>
                </div><!-- col-6 -->


                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" >Visibilidad:</label>
                     
                    <label class="rdiobox">
                      <input name="visibilidad" type="radio" id="v_normal" value="-" @empty(old('visibilidad')) checked  @endempty  @if(old('visibilidad')=='-') checked @endif  >
                      <span>Normal</span>
                    </label>

                    <label class="rdiobox">
                      <input name="visibilidad" type="radio" id="v_personal" value="personal" @if(old('visibilidad')=='personal') checked @endif   >
                      <span>Notificación personal</span>
                    </label>
                    <label class="rdiobox">
                      <input name="visibilidad" type="radio" id="v_secreto" value="secreto" @if(old('visibilidad')=='secreto') checked @endif  >
                      <span>Secreto</span>
                    </label>
                  </div>
                </div><!-- col-6 -->



                


                <input type="hidden" value="firel" id="tipo_firma_publicacion" name="tipo_firma_publicacion">
                <!--
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" >Validación del documento:</label>
                     
                    

                    <label class="rdiobox">
                      <input name="tipo_firma_publicacion" type="radio" id="firel_radio" value="firel" @if(old('firma_documento')=='firel') checked @endif >
                      <span>Firma firel</span>
                    </label>

                    <label class="rdiobox" id="firel_sicor">
                      <input name="tipo_firma_publicacion" type="radio"  value="sicor" @empty(old('firma_documento')) checked  @endempty  @if(old('firma_documento')=='sicor') checked @endif >
                      <span>Sello SIGJ</span>
                    </label>

                  </div>
                </div><!-- col-6 -->



                <div class="col-lg-6 m-t-20-force">
                  <div class="form-group">
                    <label class="form-control-label" >Notificación electrónica:</label>


                    <p class="mg-b-20 mg-sm-b-40">
                      <label class="ckbox">
                        <input type="checkbox" id="bandera_noti_elect" name="bandera_noti_elect" value="1" onchange="ponerFirel(this);"><span>Acuerdo con notificación</span>
                      </label>
                    </p>


                    
                  </div>
                </div>


                <div class="col-lg-6 usuario_actuarios" >
                  
                  <div class="form-group">
                    <label class="form-control-label" >Lista de actuarios:</label>
                    <select class="form-control select2" data-placeholder="" id="actuario_id" name="actuario_id" >
                      @isset($lista_actuarios['response'][0]['id_usuario'])
                        @foreach($lista_actuarios['response'] as $actuario)
                          <option value="{{$actuario['id_usuario']}}" >{{$actuario['nombre']}}</option>
                          
                        @endforeach
                      @endisset
                    </select>
                  </div>

                  <div class="row m-t-10-force" >
                      <div class="col-lg-12">
                        <label class="rdiobox">
                          <input name="tipo_noti_elect" type="radio" value="1" checked>
                          <span>Notificacion por Articulo 111</span>
                        </label>
                      </div><!-- col-3 -->
                      <div class="col-lg-12 mg-t-20 mg-lg-t-0">
                        <label class="rdiobox">
                          <input name="tipo_noti_elect" type="radio" value="2" >
                          <span>Notificacion por Correo del actuario</span>
                        </label>
                      </div><!-- col-3 -->

                    </div>

                </div>

                


                <div class="col-lg-12">
                  <br>
                  <button class="btn btn-success btn-block mg-b-10" >Agregar Acuerdo</button>
                </div>
              </div><!-- row -->    
          </div><!-- form-layout -->
       </form>
  </div><!-- section-wrapper -->
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
  </style>
@endsection

@section('seccion-scripts-libs')
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables/js/jquery.dataTables.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/datatables-responsive/js/dataTables.responsive.js"></script>
  <script src="{{ $entorno["version_pages"]["version"] }}/lib/select2/js/select2.min.js"></script>
  <script  src="/box/js/jquery.validate.js"></script>
  <script type="text/javascript" src="/box/qtip2/jquery.qtip.js"></script>
@endsection

@section('seccion-scripts-functions')
<script>
var dataTableGlobal;
var i_global=-1;

$(document).ready(function() {
    var rows_selected = [];
    var table;
    dataTableGlobal = table = $('#datatable1').DataTable( {
      "ordering": false,
      'columnDefs': [
        { responsivePriority: 1, targets: 4 },  
        { "targets": [0],  "orderable": false, "visible": true },
        { "targets": [1],  "orderable": false, "visible": true },
        { "targets": [2],  "orderable": false, "visible": true },
        { "targets": [3],  "orderable": false, "visible": true },
        { "targets": [4],  "orderable": false, "visible": true },
          {
          'targets': 4,
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
      dateFormat: 'yyyy-mm-dd',
      maxDate: new Date()
    });

    $('.datepicker1').datepicker({
      language: 'es',
      showOtherMonths: true,
      selectOtherMonths: true,
      dateFormat: 'yyyy-mm-dd',
      minDate: new Date()
    });

    $('.usuario_actuarios').css('display', 'none');

    $('#datatable2, #datatable3').DataTable({
      bLengthChange: false,
      searching: false,
      responsive: true
    });

    $('.con_exucsa').css('display', 'none');
    $( "#unitaria" ).prop('checked', true);
    cambiar_tipo_firma('unitaria');

    setTimeout(function(){
        $('#modal_loading').modal('hide');

        $('span[title]').qtip({
            content: {
                text: false // Use each elements title attribute
            },
            style       : 'qtip-bootstrap'
        });

    }, 1000);
  });

  jQuery.extend(jQuery.validator.messages, {
      required: "Este campo es obligatorio.",
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
  
  $("form[name='registration']").validate({

    submitHandler: function(form) {

      bandera=1;
      //se revisa el numero de acuerdo
      if($('#acuerdo').val()!="" && !$.isNumeric($('#acuerdo').val())){
        alert('En acuerdo es obligatorio y debe de ser numérico');
        $('#acuerdo').focus();
        bandera=0;
      }
      //se revisa el campo especial
      if($('#especial').val()!='-'){
        if($('#sin_documento').prop('checked')){
          if($('#anotacion').val()==""){
            alert('El campo anotación es obligatorio');
            $('#anotacion').focus();
            bandera=0;
          }
        }
      }
      if($('#publicar_en_slct').val()=='OTROS'){
        if($('#publicar_en_txt').val()==''){
            alert('El campo "publicar en" es obligatorio');
            $('#publicar_en_txt').focus();
            bandera=0;
        }
      }

      if($(".firmante_calidad").is(":visible")){
        if(typeof $('input:radio[class=ponencia_origen]:checked').val()==="undefined"){
          bandera=0;
          alert('Debe de escoger una ponencia');
        }
      }

      if($(".firmante_calidad").is(":visible")){
        if(typeof $('input:radio[class=en_calidad]:checked').val()==="undefined"){
          bandera=0;
          alert('Debe de escoger la calidad del magistrado');
        }
      }



      if($(".con_exucsa").is(":visible")){
        if(typeof $('input:radio[class=ponencia_origen_excusa]:checked').val()==="undefined"){
          bandera=0;
          alert('Debe de escoger una ponencia');
        }
      }

      if($(".con_exucsa").is(":visible")){
        if(typeof $('input:radio[class=en_calidad_excusa]:checked').val()==="undefined"){
          bandera=0;
          alert('Debe de escoger la calidad del magistrado');
        }
      }
     

      
  
      //se manda a guardar si es posible
      if(bandera==1){
        agregarLoading();
        
        
        setTimeout(function(){
          form.submit();
        },1000);
      }
    }
  });

  function cambiarTipoResolucion(valor){
    if(valor=='acuerdo'){
      $('#tipo_resolucion_span').html('Acuerdo');
      $('#tipo_acuerdo').val('acuerdo');
    }
    else if(valor=='sentencia'){
      $('#tipo_resolucion_span').html('Sentencia');
      $('#tipo_acuerdo').val('sentencia');
    }
    else{
      $('#tipo_resolucion_span').html('Audiencia');
      $('#tipo_acuerdo').val('audiencia');
    }
  }

  function mostrarFlujoSinDocumento(){

    if($('#sin_documento').prop('checked')){

      tmp_acuerdo=$('#tipo_acuerdo').val();
      tmp_acuerdo_div=$('#tipo_resolucion_span').html();
      tmp_calidad_firmante=$('.firmante_calidad').css('display');

      $('#tipo_resolucion_radio_div').css('display', 'block');
      $('#anotacion_div').css('display', 'block');

      $('#tipo_resolucion_span').html('Acuerdo');
      $('#tipo_acuerdo').val('acuerdo');
      $('#v_acuerdo').prop('checked', true);


      $('.firmante_calidad').css('display','initial');
      $('.firma_sin_documento').css('display','none');

      $("input:radio[name=en_calidad]:first").attr("checked", true);
      
      
    }
    else{
      $('#tipo_resolucion_radio_div').css('display', 'none');
      $('#anotacion_div').css('display', 'none');
      $('#tipo_acuerdo').val(tmp_acuerdo);
      $('#tipo_resolucion_span').html(tmp_acuerdo_div);

      $('.firmante_calidad').css('display',tmp_calidad_firmante);
      $('.firma_sin_documento').css('display','initial');

      $("input:radio[name=en_calidad]:first").attr("checked", true);
    }
  }

  function banderaConExcusa(){
    if( $('#excusa').is(':checked') ) {
      $('.con_exucsa').css('display', 'initial');
      $('.sin_exucsa').css('display', 'none');
      $( "#unitaria_excusa" ).prop('checked', true);
      cambiar_tipo_firma_excusa('unitaria');

    }
    else{
      $('.con_exucsa').css('display', 'none');
      $('.sin_exucsa').css('display', 'initial');
      $( "#unitaria" ).prop('checked', true);
      cambiar_tipo_firma('unitaria');
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

  function selectEspecial(opcion){
    $('#sin_documento_div').css('display', 'none');
    $('#fecha_especial_div').css('display', 'none');

    if(opcion=='mal publicado'){
      $('#sin_documento_div').css('display', 'block');
      $('#fecha_especial_div').css('display', 'block');
    }
    else if(opcion=='no publicado'){
      $('#fecha_especial_div').css('display', 'block');
      if($("#sin_documento").is(':checked')) { 
        $("#sin_documento").click();
      }
    }
    else{
      if($("#sin_documento").is(':checked')) { 
        $("#sin_documento").click();
      }
    }
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

  function cambiar_tipo_firma(firma){
    if(firma=='colegiada'){
      $('#flujos_colegiados').css('display','block');
      $('#flujos_unitarios').css('display','none');
      $( "#primer_chk_c" ).prop('checked', true);
      
      seleccionFirmante($( "#primer_chk_c" ).val());
    }
    else{
      $('#flujos_unitarios').css('display','block');
      $('#flujos_colegiados').css('display','none');
      $( "#primer_chk" ).prop('checked', true);

      seleccionFirmante($( "#primer_chk" ).val());
    }
  }


  function cambiar_tipo_firma_excusa(firma){
    if(firma=='colegiada'){
      $('#flujos_colegiados_excusa').css('display','block');
      $('#flujos_unitarios_excusa').css('display','none');
      $( "#primer_chk_c_excusa" ).prop('checked', true);
      
      
    }
    else{
      $('#flujos_unitarios_excusa').css('display','block');
      $('#flujos_colegiados_excusa').css('display','none');
      $( "#primer_chk_excusa" ).prop('checked', true);
      
      
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


  function personalizaFirma(tipo_flujo){
    if(tipo_flujo=="AUA" || tipo_flujo=="AUN" || tipo_flujo=="AU" || tipo_flujo=="ATUD" || tipo_flujo=="AC" ||  tipo_flujo=="ACU" ||  tipo_flujo=="ACA" ||  tipo_flujo=="ACAU"){
      $('#tipo_resolucion_span').html('Acuerdo');
      $('#tipo_acuerdo').val('acuerdo');
      personalizarResuelve(1);
    }
    else if(tipo_flujo=="AudU" || tipo_flujo=="AudC"){
      $('#tipo_resolucion_span').html('Audiencia');
      $('#tipo_acuerdo').val('audiencia');
      personalizarResuelve(1);
    }
    else if(tipo_flujo=="SU" || tipo_flujo=="SUA" || tipo_flujo=="SCA" || tipo_flujo=="SCP" || tipo_flujo=="SCR"){
      $('#tipo_resolucion_span').html('Sentencia');
      $('#tipo_acuerdo').val('sentencia');
      personalizarResuelve(2);
    }
    seleccionFirmante(tipo_flujo);
  }

  function seleccionFirmante(tipo_firma){
    
    $('.firmante_calidad').css('display','none');
    if(tipo_firma=="AudU" ||  tipo_firma=="SUA" ||  tipo_firma=="AudC" ||  tipo_firma=="AC" ||  tipo_firma=="ACU" ||  tipo_firma=="ACA" ||  tipo_firma=="ACAU" ||  tipo_firma=="SCA" ||  tipo_firma=="SCR" ||  tipo_firma=="SU" ||  tipo_firma=="AU" ||  tipo_firma=="SCP" ){
      $('.firmante_calidad').css('display','initial');
      
      //$("input:radio[name=ponencia_origen]:first").attr('checked', true);
      @if($archivo_detalle['response']['datos_toca'][0]['secretaria']=="")
        $("input:radio[value=semanero]").attr("checked", true);
      @else
        $("input:radio[name=en_calidad]:first").attr("checked", true);
      @endif
    }

    else if(tipo_firma=="1" ||  tipo_firma=="2" ||  tipo_firma=="3" ||  tipo_firma=="4" ||  tipo_firma=="5" ||  tipo_firma=="6" ||  tipo_firma=="7" ||  tipo_firma=="9" ||  tipo_firma=="11" ||  tipo_firma=="15" || tipo_firma=="16" || tipo_firma=="13"){
      $('.firmante_calidad').css('display','initial');
      
      //$("input:radio[name=ponencia_origen]:first").attr('checked', true);
      @if($archivo_detalle['response']['datos_toca'][0]['secretaria']=="")
        $("input:radio[value=semanero]").attr("checked", true);
      @else
        $("input:radio[name=en_calidad]:first").attr("checked", true);
      @endif
    }
    else{
      
      $("input:radio[name=en_calidad]").attr("checked", false);
      //$("input:radio[name=ponencia_origen]").attr('checked', false);
    }
  }

  
  function personalizaFirma_excusa(tipo_flujo){
    if(tipo_flujo=="AUA" || tipo_flujo=="AUN" || tipo_flujo=="AU" || tipo_flujo=="ATUD" || tipo_flujo=="AC" ||  tipo_flujo=="ACU" ||  tipo_flujo=="ACA" ||  tipo_flujo=="ACAU"){
      $('#tipo_resolucion_span').html('Acuerdo');
      $('#tipo_acuerdo').val('acuerdo');
      personalizarResuelve(1);
    }
    else if(tipo_flujo=="AudU" || tipo_flujo=="AudC"){
      $('#tipo_resolucion_span').html('Audiencia');
      $('#tipo_acuerdo').val('audiencia');
      personalizarResuelve(1);
    }
    else if(tipo_flujo=="SU" || tipo_flujo=="SUA" || tipo_flujo=="SCA" || tipo_flujo=="SCP" || tipo_flujo=="SCR"){
      $('#tipo_resolucion_span').html('Sentencia');
      $('#tipo_acuerdo').val('sentencia');
      personalizarResuelve(2);
    }
    seleccionFirmante_excusa(tipo_flujo);
  }


  function seleccionFirmante_excusa(tipo_firma){
    
    $('.firmante_calidad_excusa').css('display','none');
    if(tipo_firma=="AudU" ||  tipo_firma=="SUA" ||  tipo_firma=="AudC" ||  tipo_firma=="AC" ||  tipo_firma=="ACU" ||  tipo_firma=="ACA" ||  tipo_firma=="ACAU" ||  tipo_firma=="SCA" ||  tipo_firma=="SCR" ||  tipo_firma=="SU" ||  tipo_firma=="AU" ||  tipo_firma=="SCP" ){
      $('.firmante_calidad_excusa').css('display','initial');
      
      //$("input:radio[name=ponencia_origen]:first").attr('checked', true);
      @if($archivo_detalle['response']['datos_toca'][0]['secretaria']=="")
        $("input:radio[value=semanero]").attr("checked", true);
      @else
        $("input:radio[name=en_calidad]:first").attr("checked", true);
      @endif
    }

    else if(tipo_firma=="1" ||  tipo_firma=="2" ||  tipo_firma=="3" ||  tipo_firma=="4" ||  tipo_firma=="5" ||  tipo_firma=="6" ||  tipo_firma=="7" ||  tipo_firma=="9" ||  tipo_firma=="11" ||  tipo_firma=="15" || tipo_firma=="16" || tipo_firma=="13"){
      $('.firmante_calidad_excusa').css('display','initial');
      
      //$("input:radio[name=ponencia_origen]:first").attr('checked', true);
      @if($archivo_detalle['response']['datos_toca'][0]['secretaria']=="")
        $("input:radio[value=semanero]").attr("checked", true);
      @else
        $("input:radio[name=en_calidad]:first").attr("checked", true);
      @endif
    }
    else{
      
      $("input:radio[name=en_calidad]").attr("checked", false);
      //$("input:radio[name=ponencia_origen]").attr('checked', false);
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
  
  @isset($primer_tipo)
    personalizaFirma('{{$primer_tipo}}');
  @endisset


  function personalizarResuelve(id){
    $("#resuelve option").remove();
    if(id==1){
      $('#resuelve').append('<option @if(old("resuelve")=="Admite") selected @endif value="Admite">Admite</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Inadmisible") selected @endif value="Inadmisible">Inadmisible</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Extemporaneo") selected @endif value="Extemporaneo">Extemporaneo</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Prevencion") selected @endif value="Prevencion">Prevención</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Adm. Mod. G.") selected @endif value="Adm. Mod. G.">Adm. Mod. G.</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Citacion") selected @endif value="Citacion">Citación</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Tramite") selected @endif value="Tramite">Trámite</option>');
    }
    else{
      $('#resuelve').append('<option @if(old("resuelve")=="Confirma") selected @endif value="Confirma">Confirma</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Revoca") selected @endif value="Revoca">Revoca</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Modifica") selected @endif value="Modifica">Modifica</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Infundada") selected @endif value="Infundada">Infundada</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Nulo") selected @endif value="Nulo">Nulo</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Sin materia") selected @endif value="Sin materia">Sin materia</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Fundada") selected @endif value="Fundada">Fundada</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="Improcedente") selected @endif value="Improcedente">Improcedente</option>');
      $('#resuelve').append('<option @if(old("resuelve")=="otros") selected @endif value="otros">Otro</option>');

    }
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


  function agregarLoading(){
    $('#modal_loading').modal({backdrop: 'static', keyboard: false})
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