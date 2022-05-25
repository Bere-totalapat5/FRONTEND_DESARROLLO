@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();

@endphp
@extends('layouts.index')

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Exhortos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edición de Exhorto</li>
  </ol>
  <h6 class="slim-pagetitle">Edición de Exhorto</h6>
@endsection
@section('contenido-principal')
{{-- {{dd($request)}} --}}
  <div class="section-wrapper mg-b-100" style="max-width: 100%;">
 {{--    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 4, 0))
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else --}}

      <table class="mg-b-20 table-steps">
        <tr>
          <td class="td-step">
            <p class="step activo d-inline-block d-md-flex" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Datos de Solicitud de Exhorto</span></p>
          </td>
          <td class="td-step">
            <p class="step espera  d-inline-block d-md-flex" id="step-sujetos-procesales"><span class="num-step">2</span><span class="text-step d-none d-md-block">Sujetos Procesales</span></p>
          </td>
          <td class="td-step">
            <p class="step espera  d-inline-block d-md-flex" id="step-documentacion"><span class="num-step">3</span><span class="text-step d-none d-md-block">Documentación</span></p>
          </td>
        </tr>
      </table>

      <div class="form-layout">
        <div class="row mg-b-25 " id="datosSolicitudExhorto">{{-- datos de solicitud de audiencia --}}



          <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Carpeta de Exhorto:</label>
              <input class="form-control" type="text" name="carpeta_exhorto" id="carpetaExhorto" value="" placeholder="@php if($solicitud['folio_carpeta']!=null){echo $solicitud['folio_carpeta'];} @endphp" autocomplete="off" disabled>
            </div>
          </div>



          <div class="col-lg-3">
            <div class="form-group">
              <label class="form-control-label">Fecha de Recepción: <span class="tx-danger">*</span></label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                  </div>
                  <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="@php if($solicitud['fecha_asignacion']!=null){$fr=explode(' ',$solicitud['fecha_asignacion']); echo $fr[0];} @endphp" id="fechaRecepcion" name="fecha_recepcion" autocomplete="off">
              </div>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-3">
            <div class="form-group">
              <label class="form-control-label">Hora de Recepción <small>(24hrs)</small>: <span class="tx-danger">*</span></label>
              <div class="d-flex">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                    </div><!-- input-group-text -->
                  </div><!-- input-group-prepend -->
                  <input  type="text" class="form-control" id="horaRecepcion" value="@php if($solicitud['fecha_asignacion']!=null){$fr=explode(' ',$solicitud['fecha_asignacion']); echo $fr[1];} @endphp" name="hora_recepcion" placeholder="hh:mm" autocomplete="new-password">
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-3">
            <div class="form-group">
              <label class="form-control-label">Entidad federativa exhortante: <span class="tx-danger">*</span>  </label>
              <select class="form-control select2" id="entidadExhortante" name="entidad_exhortante" autocomplete="off">
                <option selected disabled value="">Elija una opción</option>
                    @foreach ($estados['response'] as $estado)
                      @if ($solicitud['exhorto_entidad_federativa']==$estado['id_estado'])
                         <option value="{{$estado['id_estado']}}" data-cve-estado="{{$estado['cve_estado']}}" selected>{{$estado['estado']}}</option>
                      @else
                         <option value="{{$estado['id_estado']}}" data-cve-estado="{{$estado['cve_estado']}}">{{$estado['estado']}}</option>
                      @endif
                    @endforeach
              </select>
            </div>
          </div><!-- col-6-->

          <div class="col-lg-12">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Juzgado de la autoridad Exhortante: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" value="@php if($solicitud['exhorto_juzgado']!=null){echo $solicitud['exhorto_juzgado'];} @endphp" name="juzgado_exhortante" id="juzgadoExhortante" autocomplete="off">
              </div>
            </div><!-- col-4 -->

            <div class="col-lg-0">
              <div class="form-group mg-b-10-force">
              </div>
            </div><!-- col-4 -->

          <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Nombre del Juez Exhortante: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" value="@php if($solicitud['exhorto_nombre_juez']!=null){echo $solicitud['exhorto_nombre_juez'];} @endphp"  name="juez_exhortante" id="juezExhortante" autocomplete="off">
            </div>
          </div><!-- col-4 -->

          <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Número de expediente de origen: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" value="@php if($solicitud['exhorto_expediente_origen']!=null){echo $solicitud['exhorto_expediente_origen'];} @endphp"  name="expediente_origen" id="expedienteOrigen" autocomplete="off">
            </div>
          </div><!-- col-4 -->

          <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">No. de folio/oficio:</label>
              <input class="form-control" type="text" value="@php if($solicitud['exhorto_num_folio']!=null){echo $solicitud['exhorto_num_folio'];} @endphp" name="folio_oficio" id="folioOficio" autocomplete="off">
            </div>
          </div><!-- col-4 -->

          <div class="col-lg-3">
              <div class="form-group">
                <label class="form-control-label">Delegación de exhorto: <span class="tx-danger">*</span>  </label>
                <select class="form-control select2" id="delegacionExhorto" name="delegacion_exhorto" autocomplete="off">
                  {{-- <option selected  disabled value="">Elija una opción</option> --}}
           {{--        @foreach ($estados as $estado)
                      <option value="{{$estado['id_estado']}}" data-cve-estado="{{$estado['cve_estado']}}">{{$estado['estado']}}</option>
                  @endforeach  --}}

                  @foreach ($delegaciones as $delegacion)
                  @if ($solicitud['exhorto_delegacion']==$delegacion['id_municipio'])
                     <option value="{{$delegacion['id_municipio']}}" data-cve-estado="{{$delegacion['cve_municipio']}}" selected>{{$delegacion['municipio']}}</option>
                  @else
                     <option value="{{$delegacion['id_municipio']}}" data-cve-estado="{{$delegacion['cve_municipio']}}">{{$delegacion['municipio']}}</option>
                  @endif
                @endforeach
                </select>
              </div>
            </div><!-- col-6-->


                          <div class="col-lg-6">
                              <div class="form-group" id="medioRecepcion" >
                                <label class="form-control-label mg-t-20"><strong>Medio de Recepción: </strong><span class="tx-danger">*</span></label>
                                <div class="d-inline-block mg-l-10">
                                  <label class="rdiobox d-inline-block mg-l-5">
                                    <input name="medio_recepcion" type="radio" value="correo" {{$solicitud['exhorto_medio_recepcion']=='correo_electronico'?'checked':''}}>
                                    <span class="pd-l-0">Correo Electrónico      </span>
                                  </label>
                                  <label class="rdiobox d-inline-block mg-l-5">
                                    <input name="medio_recepcion" type="radio" value="fisico" {{$solicitud['exhorto_medio_recepcion']=='fisico'?'checked':''}}>
                                    <span class="pd-l-0">Físico</span>
                                  </label>
                                </div>
                              </div>
                            </div>





            <div class="col-lg-6">
                <div class="form-group" id="materiaDestino">
                  <label class="form-control-label mg-t-20"><strong>Materia Destino: </strong><span class="tx-danger">*</span></label>
                  <div class="d-inline-block mg-l-10">
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="materia_destino" type="radio" value="adultos" {{$solicitud['materia_destino']=='adultos'?'checked':''}}>
                      <span class="pd-l-0">Penal Adultos</span>
                    </label>
                    <label class="rdiobox d-inline-block mg-l-5">
                      <input name="materia_destino" type="radio" value="adolescentes" {{$solicitud['materia_destino']=='adolescentes'?'checked':''}}>
                      <span class="pd-l-0">Penal Adolescentes</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="col-lg-8" >
                  <div class="form-group" id="tipoUnidadDestino">
                    <label class="form-control-label mg-t-20"><strong>Tipo de Unidad Destino: </strong><span class="tx-danger">*</span></label>
                    <div class="d-inline-block mg-l-10">
                      <label class="rdiobox d-inline-block mg-l-5">
                        <input name="tipo_unidad_destino" onclick="handleClick(this);"  type="radio" value="control" {{$solicitud['exhorto_tipo_unidad']=='control'?'checked':''}}>
                        <span class="pd-l-0">Unidad de control</span>
                      </label>
                      <label class="rdiobox d-inline-block mg-l-5">
                        <input name="tipo_unidad_destino" onclick="handleClick(this);"   type="radio" value="ejecucion" {{$solicitud['exhorto_tipo_unidad']=='ejecucion'?'checked':''}}>
                        <span class="pd-l-0">Unidad de ejecución</span>
                      </label>
                      <label class="rdiobox d-inline-block mg-l-5">
                          <input name="tipo_unidad_destino" onclick="handleClick(this);"  type="radio" value="especifica" {{$solicitud['exhorto_tipo_unidad']=='especifica'?'checked':''}}>
                          <span class="pd-l-0">Unidad Específica</span>
                        </label>
                    </div>
                  </div>
                </div>


                <div class="col-lg-6" id="divTipoDelito" style="display:block">
                    <div class="form-group" >
                      <label class="form-control-label mg-t-20"><strong>Tipo de delito:</strong> <span class="tx-danger">*</span></label>
                      <div class="d-inline-block mg-l-10">
                        <label class="rdiobox d-inline-block mg-l-5">
                          <input name="tipo_delito" type="radio" value="nograve" {{$solicitud['estatus_delito_grave']=='si'?'checked':''}}>
                          <span class="pd-l-0">Perseguible por querella</span>
                        </label>
                        <label class="rdiobox d-inline-block mg-l-5">
                          <input name="tipo_delito" type="radio" value="grave" {{$solicitud['estatus_delito_grave']=='no'?'checked':''}}>
                          <span class="pd-l-0">Perseguible por oficio</span>
                        </label>
                      </div>
                    </div>
                  </div>


                  <br>

            <div class="col-lg-6"  id="divEntidad" style="display:none" >
              <div class="form-group ">
                <label class="form-control-label"><strong>Unidad Destino:</strong> <span class="tx-danger">*</span>  </label>


                <select class="form-control select2" id="unidadDestino" name="unidad_destino" autocomplete="off">
                  <option selected disabled value="">Elija una opción</option>

                  {{-- @foreach ($unidades['response'] as $unidad)
                  <option value="{{$unidad['id_unidad_gestion']}}">{{$unidad['nombre_unidad']}}</option>
             @endforeach --}}
                </select>
              </div>
              </div>

              <div class="col-lg-6"  id="divEntidad2" style="display:none" >
                <div class="form-group">
                  <label class="form-control-label"><strong>Indique el motivo de la asignacion de la unidad:</strong></label>

                  <th colspan="100%">
                    <textarea id="motivoAsignacionUnidad" rows="1" placeholder="Escriba el motivo de asignación..." ></textarea>
                     </th>
                </div>
              </div><!-- col-9 -->



            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Resumen del Exhorto</label>

                <th colspan="100%">
                  <textarea id="resumenExhorto" value="@php if($solicitud['exhorto_resumen']!=null){echo $solicitud['exhorto_resumen'];} @endphp" rows="2"  >@php if($solicitud['exhorto_resumen']!=null){echo $solicitud['exhorto_resumen'];} @endphp</textarea>
                   </th>
              </div>
            </div><!-- col-9 -->









        </div><!-- row -->{{-- </datos de solicitud de audiencia> --}}

        <div class="mg-b-25 d-none" id="sujetosProcesales">{{-- <sujetos procesales> --}}
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Calidad Jurídica: <span class="tx-danger">*</span></label>
                <select class="form-control " id="tipoParte" name="tipo_parte" autocomplete="off">
                    <option selected  value="46">IMPUTADO</option>
                      @foreach ($calidad_juridica as $calidad)
                      @if($calidad['id_calidad_juridica']!=56 && $calidad['id_calidad_juridica']!=44)
                        <option value="{{$calidad['id_calidad_juridica']}}">{{$calidad['calidad_juridica']}}</option>
                      @endif
                    @endforeach
                </select>
              </div>
            </div><!-- col-6 -->
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Tipo Persona: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="tipoPersona" name="tipo_persona" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="fisica">FÍSICA</option>
                    <option value="moral">MORAL</option>
                </select>
              </div>
            </div><!-- col-6-->
            <div class="col-lg-6 fisica">
              <div class="form-group">
                <label class="form-control-label">Nacionalidad: </label>
                <select class="form-control select2" id="nacionalidad" name="nacionalidad" autocomplete="off">
                    <option selected  value="">Elija una opción</option>
                    <option value="mexicana">MEXICANA</option>
                    <option value="mexicana_otro">MEXICANA/OTRO</option>
                    <option value="extranjero">EXTRANJERO</option>
                </select>
              </div>
            </div><!-- col-6-->
            <div class="col-lg-6 fisica">
              <div class="form-group">
                <label class="form-control-label">Indique la Nacionalidad: </label>
                <select class="form-control " id="otraNacionalidad" name="otra_nacionalidad" autocomplete="off" disabled>
                    <option selected  value="" disabled>Elija una opción</option>
                  {{--   @foreach ($nacionalidades as $nacionalidad)
                          <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option>
                    @endforeach --}}
                </select>
              </div>
            </div><!-- col-6-->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">CURP:</label>
                <input class="form-control" type="text" name="curp" id="curp" autocomplete="off">
              </div>
            </div><!-- col-4 -->

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">RFC:</label>
                <input class="form-control" type="text" name="rfc" id="rfc" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-8 moral d-none">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Razón Social:</label>
                <input class="form-control" type="text" name="razon_social" id="razonSocial" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Cédula Profesional:</label>
                <input class="form-control" type="text" name="cedula_profesional" id="cedulaProfesional" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Nombre(s): <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="nombre" id="nombre" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="apellido_paterno" id="apellidoPaterno" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Apellido Materno:</label>
                <input class="form-control" type="text" name="apellido_materno" id="apellidoMaterno" autocomplete="off">
              </div>
            </div><!-- col-4-->
            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Genero: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="genero" name="genero" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="masculino">MASCULINO</option>
                    <option value="femenino">FEMENINO</option>
                    <option value="indeterminado">INDETERMINADO</option>
                </select>
              </div>
            </div><!-- col-4-->

            <div class="col-lg-3 fisica">
              <div class="form-group">
                <label class="form-control-label">Fecha de Nacimiento: </label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaNacimiento" name="fecha_nacimiento" autocomplete="off">
                </div>
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-3 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Edad:</label>
                <input class="form-control inpur-number" type="text" name="edad" id="edad" autocomplete="off">
              </div>
            </div><!-- col-4-->
          </div>
          <div id="acordingAlias" class="accordion-two mg-b-15" role="tablist" aria-multiselectable="true">
            <div class="card">
              <div class="card-header" role="tab" id="headingAlias">
                <a data-toggle="collapse" data-parent="#acordingAlias" href="#collapseAlias" aria-expanded="false" aria-controls="collapseAlias" class="tx-gray-800 transition collapsed">
                  Alias
                </a>
              </div><!-- card-header -->
              <div id="collapseAlias" class="collapse" role="tabpanel" aria-labelledby="headingalias">
                <div class="card-body">
                  <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10" id="agregarAlias">Agregar Alias <i class="fa fa-plus"></i></button>
                  <div id="datosAlias">

                  </div>
                </div>
              </div>
            </div>
          </div><!-- accordion -->
          <div id="accordionContacto" class="accordion-two" role="tablist" aria-multiselectable="true">
            <div class="card">
              <div class="card-header" role="tab" id="headingContacto">
                <a data-toggle="collapse" data-parent="#accordionContacto" href="#collapseContacto" aria-expanded="false" aria-controls="collapseContacto" class="tx-gray-800 transition collapsed">
                  Agregar Datos de Contacto
                </a>
              </div><!-- card-header -->
              <div id="collapseContacto" class="collapse" role="tabpanel" aria-labelledby="headingContacto">
                <div class="card-body">
                  <div class="row">

                      <div class="col-lg-4">
                          <div class="form-group">
                            <label class="form-control-label">Estado: </label>
                            <select class="form-control" id="estado" name="estado" autocomplete="off">
                                <option selected   value="">Elija una opción</option>
                     @foreach ($estados['response'] as $estado)
                                    <option value="{{$estado['id_estado']}}" data-cve-estado="{{$estado['cve_estado']}}">{{$estado['estado']}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>

                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label">Municipio: </label>
                        <select class="form-control" id="municipio" name="municipio" autocomplete="off">

                        </select>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Localidad:</label>
                        <input class="form-control" type="text" name="localidad" id="localidad" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Calle:</label>
                        <input class="form-control" type="text" name="calle" id="calle" autocomplete="off">
                      </div>
                    </div><!-- col-4 -->
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Número Exterior:</label>
                        <input class="form-control" type="text" name="numero_exterior" id="numeroExterior" autocomplete="off">
                      </div>
                    </div><!-- col-4 -->
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Número Interior:</label>
                        <input class="form-control" type="text" name="numero_interior" id="numeroInterior" autocomplete="off">
                      </div>
                    </div><!-- col-4-->
                    <div class="col-lg-9">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Colonia:</label>
                        <input class="form-control" type="text" name="colonia" id="colonia" autocomplete="off">
                      </div>
                    </div><!-- col-4 -->
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Código Postal:</label>
                        <input class="form-control" type="text" name="codigo_postal" id="codigoPostal" autocomplete="off">
                      </div>
                    </div><!-- col-4 -->
                    <div class="col-lg-8">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Entre la Calle:</label>
                        <input class="form-control" type="text" name="entre_calle" id="entreCalle" autocomplete="off">
                      </div>
                    </div><!-- col-4-->
                    <div class="col-lg-12">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Otras Referencias:</label>
                        <input class="form-control" type="text" name="otras_referencias" id="otrasReferencias" autocomplete="off">
                      </div>
                    </div><!-- col-4-->
                    <div class="col-12">
                      <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10 mg-t-15" id="agregarCorreo">Agregar Correo <i class="fa fa-plus"></i></button>
                      <div id="correos" class="mg-b-15">
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10" id="agregarTelefono">Agregar Telefono <i class="fa fa-plus"></i></button>
                      <div id="telefonos">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- accordion -->
          <div  class="d-flex mg-t-5" id="botonesPartes">
            <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="agregarParte">Agregar Parte</button>
          </div>
          <div class="mg-t-15">
            <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10" id="agregarDelito">Agregar Delito a Imputados Seleccionados</button>
            <button class="btn btn-outline-danger  mg-b-10 btn-sm" id="eliminarSeleccion">Borrar Seleccionados</button>
            <div>
              <table  class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0" role="grid" aria-describedby="example_info">
                <thead>
                    <tr style="background-color: #EBEEF1; color: #000;">
                        <th class="seleccion"></th>
                        <th class="acciones">Acciones</th>
                        <th class="tipo-parte">Calidad Jurídica</th>
                        <th class="nombre">Nombre/Razón Social</th>
                        <th class="delito">Delito(s)</th>
                        <th class="genero">Género</th>
                    </tr>
                </thead>
                <tbody id="tableSujetosProcesales">

                </tbody>
              </table>
            </div>
          </div>
        </div>{{-- </sujetos procesales> --}}

         {{-- D O C U M E N T A C I O N --}}
         <div class="row mg-b-25 d-none" id="div-datos-documentacion">
          <div class="col-lg-12">
            <div class="form-group">
              <!-- <label class="form-control-label">Ingrese documentación: <span class="tx-danger">*</span></label> -->
                <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data">
                    <div class="custom-input-file">
                    <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" accept=".pdf,.doc,.docx,.jpg,.png" >
                    <h5 class="px-3 py-3">Arrastre hasta aquí su documento o de clic para adjuntarlo</h5>
                    </div>
                </form>
                <br><br>
                <div class="row" id="div-view-archivos">
                </div>
            </div>
          </div><!-- col-4-->
        </div>

        <div class="form-layout-footer d-flex">
          <button class="btn btn-secondary bd-0 d-inline-block" id="atras" disabled>Atrás</button>
          <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="siguiente">Siguiente</button>
          <button class="btn btn-primary bd-0 ml-auto d-none" id="btn-enviar-solicitud" onclick="enviarExhorto()">Enviar Exhorto</button>        </div><!-- form-layout-footer -->
      </div>
   {{--  @endif --}}
  </div>
@endsection
@section('seccion-estilos')
  <link rel="stylesheet" type="text/css" href="{{asset("/css/dropzone.min.css")}}">
  <link href="{{asset("/lib/datatables/css/jquery.dataTables.css")}}" rel="stylesheet">

  <style>
    table.table-steps{
        display: flex;
      }
    .step{
      /* border: 1px solid #000; */
      border-radius: 25px;
      background: #EEEEEE;
      display: flex;
    }
    .step .num-step{
      display: inline-block;
      background: #FFF;
      margin: 4px;
      border-radius: 50%;
      padding: 3px 8px 3px 8px;
      width: 25px;
      height: 25px;
    }
    .step .text-step{
      display: inline-block;
      margin-left: auto;
      margin-right: auto;
      padding: 6px 8px 6px 4px;
    }
    .step.resuelto{
      background: #848F33;
    }
    .step.resuelto .text-step{
      color: #FFF;
    }
    .step.activo{
      background: #848F33;
    }
    .step.activo .text-step{
      color: #FFF;
      text-decoration: underline;
    }
    td.td-step{
      padding-left: 20px;
    }
    td.td-step:first-child{
      padding-left: 0;
    }
    .nav-tabs .nav-link {
      border-top-left-radius: 15px !important;
      border-top-right-radius: 15px !important;
    }

    #tableSujetosProcesales{
      text-transform:uppercase;
    }
    table.datatable td, th{
      /* padding-left: 5px !important;
      padding-right: 5px !important;
      padding-top: 12px;
      padding-bottom: 12px; */
      border-bottom: 1px solid #f0f2f7;
    }
    span.select2-container--open{
      z-index: 1100 !important;
    }
    #modalError{
      z-index: 1110 !important;
    }
    .tipo-parte{
      min-width: 160px !important;
    }
    .tipo-persona{
      min-width: 160px !important;
    }
    .nombre{
      min-width: 355px !important;
    }
    .rfc{
      min-width: 160px !important;
    }
    .genero{
      min-width: 160px !important;
    }
    .acciones{
      min-width: 140px !important;
    }
    td.acciones{
      font-size: 16px !important;
      text-align: justify;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      vertical-align: middle !important;
    }
    td.acciones a{
      margin-left: 20%;
      cursor: pointer;
    }
    td.acciones a:first-child{
      margin-left: 0;
    }
    .seleccion{
      min-width: 44px !important;
      vertical-align: middle !important;
    }
    .delito{
      min-width: 305px !important;
    }
    .card-body{
      background-color: #FFF;
    }
    textarea{
            background-color: white  !important;
            min-height: 41px !important;
            width: 100% !important;
            }
    #datosAlias .row{
      border: 1px solid #EEE;
      border-collapse: collapse;
      margin-top: 2px
    }
    div#datosAlias .row:nth-child(2n){
      background: #FDFDFD !important;
    }
    #correos p{
      margin-bottom: 0;
    }
    #telefonos p{
      margin-bottom: 0;
    }

    #correos .row{
      border: 1px solid #EEE;
      border-collapse: collapse;
      margin-top: 2px;
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }
    div#telefonos .row:nth-child(2n){
      background: #FDFDFD !important;
    }
    div.caja{
      border: 1px solid #EEE;
      padding: 10px;
    }

    #telefonos .row{
      border: 1px solid #EEE;
      border-collapse: collapse;
      margin-top: 2px;
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }
    div#correos .row:nth-child(2n){
      background: #FDFDFD !important;
    }
    table#tableDatosSujeto  td, table#tableDatosSujeto th{
      border: 1px solid #EEE;
      vertical-align: text-top;
      padding: 5px;
    }

    #datosCarpeta  td, #datosCarpeta th{
      border: 1px solid #EEE;
      vertical-align: text-top;
      padding: 5px;
      width: 230px;
      text-align: start;
    }

    .elimina-delito{
      width: 40px !important;
      text-align: center;
      vertical-align: middle !important;
    }

    tbody.table-datos-sujeto tr td:first-child{
      background-color: #f8f9fa;
      font-weight: bold;
    }

    .custom-input-file {
        cursor: pointer;
        font-size: 25px;
        font-weight: bold;
        margin: 0 auto 0;
        min-height: 15px;
        overflow: hidden;
        padding: 10px;
        position: relative;
        text-align: center;
        width: 500px;
        color: #848F33;
        border: 2px solid #EEE;
        border-style: dotted;
        height: 80px;
        border-radius: 25px;
        width: 80%;
      }

      .custom-input-file:hover{
        background: #848F33;
        color: #fff;
      }

      .custom-input-file .input-file{
        border: 10000px solid transparent;
        cursor: pointer;
        font-size: 10000px;
        margin: 0;
        opacity: 0;
        outline: 0 none;
        padding: 0 ;
        position: absolute;
        right: -1000px;
        top: -1000px;
      }
      #modalAgregarDelito {
            width: 100%;

            height: 90%;

             font-size: 18px;
        }
      .delito-s{
        min-width: 100px !important;
      }
      .modalidad{
        min-width: 100px !important;
      }
      .calificativo{
        min-width: 100px !important;
      }
      .grado-realizacion{
        min-width: 100px !important;
      }
      p.fl-m::first-letter{
        text-transform: uppercase;
      }

    @media only screen and (max-width: 1199px) {
      table#tableDatosSujeto td{
        width: auto;
      }
      .tipo-parte{
        min-width: 140px !important;
      }
      .tipo-persona{
        min-width: 140px !important;
      }
      .nombre{
        min-width: 255px !important;
      }
      .rfc{
        min-width: 125px !important;
      }
      .genero{
        min-width: 100px !important;
      }
      .acciones{
        min-width: 100px !important;
      }
      .seleccion{
        min-width: 20px !important;
      }
      .delito{
        min-width: 305px !important;
      }



    }
  </style>
@endsection
@section('seccion-scripts-libs')
        <script type="text/javascript" src="{{asset('/js/dropzone.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
        <script src="https://unpkg.com/jspdf-invoice-template@latest/dist/index.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
          {{-- <script type="text/javascript" src="{{asset('/js/dropzone.min.js')}}"></script> --}}
@endsection
@section('seccion-scripts-functions')
  <script>
    let step=1;
    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
          expVacio=/^[\s]*$/,
          expRFC=/^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/,
          arrDelitosNR=[],
          sujetosGuardados=@php echo json_encode($solicitud['personas'])@endphp,
          delitosNR=@php echo json_encode($solicitud['delitos_sin_relacionar'])@endphp,
          catalogoDelitos=@php echo json_encode($delitos['response'])@endphp,
          catalogoEstados=@php echo json_encode($estados['response'])@endphp;
          arrSujetosProcesales=[];
          documentos = [];

          setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 2000);


            $(()=>{

   /*              $(delitosNR).each(function(index, delito){
                const {id_persona_delito,id_delito,id_modalidad,nombre_modalidad,id_calificativo,calificativo,grado_realizacion,delito_grave}=delito;
                const textDelito=catalogoDelitos.filter(cDelito=>cDelito.id_delito==id_delito);
                const datosDelito={
                    "estatus":"1",
                    "id":id_persona_delito,
                    "id_delito":id_delito,
                    "id_imputable_a":[],
                    "imputable_a":[],
                    "delito_text":textDelito[0].delito,
                    "id_modalidad":id_modalidad,
                    "modalidad_text":nombre_modalidad,
                    "id_calificativo":id_calificativo,
                    "calificativo_text":calificativo,
                    "forma_comision":"forma",
                    "grado_realizacion":grado_realizacion,
                    "grado_realizacion_text":grado_realizacion.replace('_',' ').toUpperCase(),
                    "delito_grave":delito_grave,
                };
                arrDelitosNR.push(datosDelito);
                }); */

                $(sujetosGuardados).each(function(index, sujeto){

                const {alias, contacto, delitos, info_principal, direcciones, datos}=sujeto;

                const arrAlias=[],
                        arrCorreos=[],
                        arrTelefonos=[],
                        arrDirecciones=[],
                        arrDelitos=[],
                        arrDatos=[];

                $(alias).each(function(index, aliasSujeto){
                    const {id_alias,alias, estatus}=aliasSujeto;
                    if(estatus==1){
                    datosAlias={
                        id:id_alias,
                        alias:alias,
                        estatus:"1"
                    }
                    arrAlias.push(datosAlias);
                    }
                });


                $(contacto).each(function(index,contactoSujeto){
                    const {id_contacto_persona,tipo_contacto, contacto, estatus, extension}=contactoSujeto;
                    if(estatus==1){
                    if(tipo_contacto=='correo electronico'){
                        datosContacto={
                        id:id_contacto_persona,
                        correo:contacto,
                        estatus:"1"
                        }
                        arrCorreos.push(datosContacto);
                    }else{
                        datosContacto={
                        id:id_contacto_persona,
                        tipo:tipo_contacto,
                        numero:contacto,
                        extension:extension==null?'':extension,
                        estatus:"1"
                        }
                        arrTelefonos.push(datosContacto);
                    }
                    }
                });

                $(delitos).each(function(index, delitoSujeto){

                    const {id_persona,estatus,id_delito,delito, id_modalidad, modalidad ,id_calificativo,calificativo, grado_realizacion, delito_grave, nombre_modalidad} = delitoSujeto;
                    const textDelito=catalogoDelitos.filter(cDelito=>cDelito.id_delito==id_delito);
                    const datosDelito={
                            "estatus":"1",
                            "id":id_persona,
                            "id_delito":id_delito,
                          //  "delito_text":textDelito[0].delito,
                          "delito_text":delito,
                            "id_modalidad":id_modalidad,
                            "modalidad_text":nombre_modalidad,
                            "id_calificativo":id_calificativo,
                            "calificativo_text":calificativo,
                            "forma_comision":"forma",
                            "grado_realizacion":grado_realizacion,
                          //  "grado_realizacion_text":grado_realizacion.replace('_',' ').toUpperCase(),
                            "delito_grave":delito_grave,
                        };

                    arrDelitos.push(datosDelito);
                });

                $(datos).each(function(index, dato){
                    const { estatus,id_nivel_escolaridad,id_lengua,id_religion,id_lgbttti,id_grupo_etnico,tipo_ocupacion,otra_escolaridad,otra_ocupacion,otra_religion,otro_grupo_etnico,otro_idioma_traductor,requiere_traductor,idioma_traductor,requiere_interprete,tipo_interprete,capacidades_diferentes,capacidad_diferente,poblacion,otra_poblacion,pertenece_grupo_etnico,entiende_idioma_espanol,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,id_escolaridad,nivel_escolaridad,lengua,nombre_religion,nombre_poblacion,grupo_etnico,id_datos_persona}=dato;

                    const datosDatos={
                    id_datos_persona,
                    estatus,
                    id_nivel_escolaridad,
                    id_lengua,
                    id_religion,
                    id_lgbttti,
                    id_grupo_etnico,
                    tipo_ocupacion,
                    otra_escolaridad,
                    otra_ocupacion,
                    otra_religion,
                    otro_grupo_etnico,
                    otro_idioma_traductor,
                    requiere_traductor,
                    idioma_traductor,
                    requiere_interprete,
                    tipo_interprete,
                    capacidades_diferentes,
                    capacidad_diferente,
                    poblacion,
                    otra_poblacion,
                    pertenece_grupo_etnico,
                    entiende_idioma_espanol,
                    descripcion_discapacidad,
                    sabe_leer_escribir,
                    poblacion_callejera,
                    estatus,
                    id_escolaridad,
                    nivel_escolaridad,
                    lengua,
                    nombre_religion,
                    nombre_poblacion,
                    grupo_etnico,
                    };

                    arrDatos.push(datosDatos);
                });
                console.log(direcciones);

                $(direcciones).each(function(index, direccion){
                    const {calle,no_exterior,no_interior, colonia, codigo_postal,entidad_federativa,id_municipio, localidad, entre_calles,referencias, cve_PGJ, estado, municipio, id_direccion_persona, estatus,cve_estado}=direccion;

                    const datosDireccion={
                    "id":id_direccion_persona,
                    "estatus":"1",
                    "calle":calle==null?'':calle,
                    "numero_exterior":no_exterior==null?'dfdfdfd':no_exterior,
                    "numero_interior":no_interior==null?'fdfdfdf':no_interior,
                    "colonia":colonia==null?'':colonia,
                    "codigo_postal":codigo_postal==null?'':codigo_postal,
                    "estado":entidad_federativa,
                    "estado_text":estado==null?'':estado,
                    "cve_estado":cve_estado,
                    "municipio":id_municipio,
                    "municipio_text":municipio==null?'':municipio,
                    "localidad":localidad==null?'':localidad,
                    "entre_calle":entre_calles==null?'':entre_calles,
                    "otra_referencia":referencias==null?'':referencias,
                    };

                    arrDirecciones.push(datosDireccion);
                });

                const {id_calidad_juridica, tipo_persona, es_mexicano, otra_nacionalidad, curp, rfc_empresa,cedula_profesional,nombre,apellido_paterno,apellido_materno, genero,fecha_nacimiento, edad,id_estado_civil, razon_social, calidad_juridica,estado_civil, id_persona, estatus}=info_principal;

                if(fecha_nacimiento!=null){
                    fN=fecha_nacimiento.split('-');
                    fechaNacimiento=fN[2]+'-'+fN[1]+'-'+fN[0];
                }else{
                    fechaNacimiento='';
                }
                const sujetoProcesal={
                    "origen":$('#origen').val(),
                    "id":id_persona,
                    "estatus":"1",
                    "tipo_parte":id_calidad_juridica,
                    "tipo_parte_text":calidad_juridica,
                    "tipo_persona":tipo_persona,
                    "tipo_persona_text":tipo_persona=='fisica'?'FÍSICA':'MORAL',
                    "nacionalidad":es_mexicano==null?'':es_mexicano=='no'?'extranjero':otra_nacionalidad==null?'mexicano':'mexicana_otro',
                    "nacionalidad_text":es_mexicano==null?'':es_mexicano=='no'?'EXTRANJERO':otra_nacionalidad==null?'MEXICANO':'MEXICANO/OTRO',
                    "otra_nacionalidad":otra_nacionalidad,
                    "curp":curp==null?'':curp,
                    "rfc":rfc_empresa==null?'':rfc_empresa,
                    "cedula_profesional":cedula_profesional==null?'':cedula_profesional,
                    "nombre":nombre==null?'':nombre,
                    "apellido_paterno":apellido_paterno==null?'':apellido_paterno,
                    "apellido_materno":apellido_materno==null?'':apellido_materno,
                    "genero":genero,
                    "genero_text":genero==null?'':genero,
                    "fecha_nacimiento":fechaNacimiento,
                    "edad":edad==null?'':edad,
                    "estado_civil":id_estado_civil,
                    "estado_civil_text":estado_civil==null?'':estado_civil,
                    "razon_social":razon_social==null?'':razon_social,
                    "alias":arrAlias,
                    "correos":arrCorreos,
                    "telefonos":arrTelefonos,
                    "delitos":arrDelitos,
                    "datos":arrDatos,
                    "direcciones":arrDirecciones
                };

                arrSujetosProcesales.push(sujetoProcesal);
                });

                muestraSujetosProcesales();
                });








    $(function(){
      'use strict'
      $('.ui-datepicker-year').addClass('select2');

      // Datepicker
      $('.fc-datepicker').datepicker({

          showOtherMonths: true,
          selectOtherMonths: true,
          format: 'dd/mm/yyyy',
          changeYear: true,
          yearRange: "c-100:c+0"
      });

      $('#datepickerNoOfMonths').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          numberOfMonths: 2

      });



    });



    $(function(){
      'use strict'

      Toggles
      $('.toggle').toggles({
        on: false,
        height: 26
      });

      // Input Masks
      $('#dateMask').mask('99/99/9999');
      $('#phoneMask').mask('(999) 999-9999');
      $('#ssnMask').mask('999-99-9999');

      // Time Picker
      $('#tpBasic').timepicker();
      $('#tp2').timepicker({'scrollDefault': 'now'});
      $('#horaRecepcion').timepicker();

      $('#setTimeButton').on('click', function (){
        $('#horaRecepcion').timepicker('setTime', new Date());
      });

      // Color picker
      $('#colorpicker').spectrum({
        color: '#17A2B8'
      });

      $('#showAlpha').spectrum({
        color: 'rgba(23,162,184,0.5)',
        showAlpha: true
      });

      $('#showPaletteOnly').spectrum({
          showPaletteOnly: true,
          showPalette:true,
          color: '#DC3545',
          palette: [
              ['#1D2939', '#fff', '#0866C6','#23BF08', '#F49917'],
              ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
          ]
      });

    });

    $('#siguiente').click(function(){
      $('.error').removeClass('error');
      const validacion=validaDatos();
      if(validacion==100){
        step++;
        cambiarPantalla();
      }else{
        const {campo , error} = validacion;
        if($('#'+campo).is('select')){
          $('span[aria-labelledby="select2-'+campo+'-container"]').addClass('error');
        }else{
          $('#'+campo).focus().addClass('error');
        }
        $('#messageError').html(`${error}`);
        $('#modalError').modal('show');
      }
    });

    $('#atras').click(function(){

      step--;
      cambiarPantalla();
    });

    $('#tipoAudiencia').change(function(){
      const duracion=$(this).find('option:selected').attr('data-duracion');
      $('#duracionAproximada').val(duracion+' minutos');
    });

    $('#tipoPersona').change(function(){
      if($(this).val()=='moral'){
        $('.moral').removeClass('d-none');
        $('.fisica').addClass('d-none')
        $('.fisica').find('.form-control').val('');
      }else{
        $('.fisica').removeClass('d-none');
        $('.moral').addClass('d-none')
        $('.moral').find('.form-control').val('');
      }

      $('#nacionalidad').val('').select2({minimumResultsForSearch: Infinity});
      $('#otraNacionalidad').val('').attr('disabled', true).select2({minimumResultsForSearch: ''});
      $('#genero').val('').select2({minimumResultsForSearch: Infinity});
      $('#estadoCivil').val('').select2({minimumResultsForSearch: Infinity});

    });

    $('#nacionalidad').change(function(){
      if($(this).val()=='mexicana' || $(this).val()==null || $(this).val()==''){
        $('#otraNacionalidad').attr('disabled', true).val('');
      }else{
        $('#divOtraNacionalidad').removeClass('d-none');
        $('#otraNacionalidad').removeAttr('disabled')
      }
    });

    $('#agregarParte').click(function(){
      $('.error').removeClass('error');
      const validacion=validaDatosSujetoProcesal();
      if(validacion==100){
        agregarSujetoProcesal();
        limpiarCamposSujetos();
      }else{
        const {campo , error} = validacion;
        if($('#'+campo).is('select')){
          $('span[aria-labelledby="select2-'+campo+'-container"]').addClass('error').focus();
        }else{
          $('#'+campo).focus().addClass('error');
        }
        $('#messageError').html(`${error}`);
        $('#modalError').modal('show');
      }
    });

    $('#eliminarSeleccion').click(function(){
      sujetosSeleccionados=obtenerSujetosSeleccionados();

      if(sujetosSeleccionados!=-1){
        const nArrSujetosProcesales=arrSujetosProcesales.filter((sujeto, index)=>{
          if(!sujetosSeleccionados.some(indexSeleccionado=>indexSeleccionado==index)){
            return sujeto;
          }
        });
        arrSujetosProcesales=nArrSujetosProcesales;
      }
      muestraSujetosProcesales();
    });

    $('#agregarDelito').click(function(){
      sujetosSeleccionados=obtenerSujetosSeleccionados();

      if(sujetosSeleccionados!=-1){
        // const listaImputados=[];
        const imputados=arrSujetosProcesales.filter((sujeto, index)=>{
          if(sujetosSeleccionados.some(indexSeleccionado=>indexSeleccionado==index) && sujeto.tipo_parte==46){
            return sujeto;
          }
        });

        if(imputados.length){
          let listaImputados='';
          $(imputados).each((index, imputado)=>{
            const {razon_social, nombre, apellido_paterno, apellido_materno} =imputado;
            const li=`<li class="upercase">
                        ${razon_social}${nombre} ${apellido_paterno} ${apellido_paterno}
                      </li>`;
            listaImputados=listaImputados.concat(li);
          });
          $('#listaImputados').html(listaImputados);
          const jsonSeleccion=JSON.stringify(sujetosSeleccionados);
          $('#guardarDelito').attr('onclick', 'guardarDelito(`'+jsonSeleccion+'`)');
          $('#modalAgregarDelito').modal('show');

          setTimeout(()=>{
            $('#modalAgregarDelito .select2').select2({
              minimumResultsForSearch: Infinity
          });
          },150);

          if($('#delito').hasClass('select2-hidden-accessible')){
            $('#delito').select2('destroy');
            $('#delito').val('');
          }
          setTimeout(()=>{
            $('#delito').select2({minimumResultsForSearch: ''});
          },150);
        }
      }
    });


    $('#delito').change(function(){
      $.ajax({
        type:'POST',
        url:'/public/obtener_modalidades',
        data:{
          delito:$('#delito').val(),
        },
        success:function(response){
          if(response.status==100){
            let modalidades='<option selected disabled value>Elija una opcion</option>';
            $(response.response).each((index, modalidad)=>{
              const {id_modalidad, nombre_modalidad}=modalidad;
              const option=`<option value="${id_modalidad}">${nombre_modalidad}</option>`;
              modalidades=modalidades.concat(option);
            });
            $('#modalidadDelito').html(modalidades);
          }
        }
      });
    });




    $('#agregarAlias').click(function(){
      $('#datosAlias').append(`<div class="row datos-alias">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-alias"></i></p>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Alias:</label>
                                    <input class="form-control alias" type="text" name="alias" autocomplete="off">
                                  </div>
                                </div><!-- col-3-->
                              </div>`);
    });

    $('#datosAlias').on('click','.borrar-alias',function(){
      $(this).parent().parent().parent().remove();
    });

    $('#estado').change(function(){
      $.ajax({
        type:'POST',
        url:'/public/obtener_municipios',
        data:{
          estado:$('#estado').find('option:selected').attr('data-cve-estado'),
        },
        success:function(response){
          if(response.status==100){
            let municipios='<option disabled selected>Elija una opción</option>';
            $(response.response).each(function(index, datosMunicipio){
              const {id_municipio, municipio}=datosMunicipio;
              const option=`<option value="${id_municipio}">${municipio}</option>`;
              municipios=municipios.concat(option);
            });
            $('#municipio').html(municipios);
          }
        }
      });
    });

    $('#headingContacto').click(function(){
      if($('#estado').hasClass('select2-hidden-accessible')){
        $('#estado').select2('destroy');
      }
      if($('#municipio').hasClass('select2-hidden-accessible')){
        $('#municipio').select2('destroy');
      }
      setTimeout(()=>{
        $('#estado').select2({minimumResultsForSearch: ''});
        $('#municipio').select2({minimumResultsForSearch: ''});
      },100);

    });

    $('#agregarCorreo').click(function(){
      $('#correos').append(`<div class="row datos-correo">
                              <div class="col-12">
                                <p class="tx-right tx-danger"><i class="fa fa-close borrar-correo"></i></p>
                              </div>
                              <div class="col-8">
                                <div class="form-group mg-b-10-force">
                                  <label class="form-control-label">Correo Electrónico:</label>
                                  <input class="form-control correo-electronico" type="text" name="correo_electronico" autocomplete="off">
                                </div>
                              </div><!-- col-3-->
                            </div>`);
    });

    $('#correos').on('click','.borrar-correo',function(){
      $(this).parent().parent().parent().remove();
    });

    $('#agregarTelefono').click(function(){
      $('#telefonos').append(`<div class="row datos-telefono">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-telefono"></i></p>
                                </div>
                                <div class="col-lg-3">
                                  <div class="form-group">
                                    <label class="form-control-label">Tipo: </label>
                                    <select class="form-control tipo-telefono"  name="tipo_telefono" autocomplete="off">
                                        <option value="fijo">Fijo</option>
                                        <option value="celular">Celular</option>
                                    </select>
                                  </div>
                                </div><!-- col-3-->
                                <div class="col-lg-4">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Número:</label>
                                    <input class="form-control numero-telefono" type="text" name="numero_telefono" autocomplete="off">
                                  </div>
                                </div><!-- col-3-->
                                <div class="col-lg-2">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Extension:</label>
                                    <input class="form-control extension" type="text" name="estension" autocomplete="off">
                                  </div>
                                </div><!-- col-3-->
                              </div>`);

      // setTimeout(()=>{
        $('.tipo-telefono').select2({
          minimumResultsForSearch: Infinity
        });
      // },20);
    });

    $('#telefonos').on('click','.borrar-telefono',function(){
      $(this).parent().parent().parent().remove();
    });

    $('#fechaNacimiento').on('input change',function(){
      if(expRegFecha.test($(this).val())){
        const anioNac=$(this).val().split('-')[2],
              mesNac=$(this).val().split('-')[1],
              diaNac=$(this).val().split('-')[0],
              anioAct=new Date().getFullYear(),
              mesAct=new Date().getMonth()+1,
              diaAct=new Date().getDate();

        let edad=anioAct-anioNac;

        if(mesNac>mesAct || (mesAct==mesNac && diaNac>diaAct)){
          edad--;
        }

        $('#edad').val(edad);
      }
    });

    function validaDatos(){
      switch(step){
        case 1:
          return (validaDatosSolicitud());
          break;
        case 2:
        return (validaSujetosProcesales());
          break;
        case 3:
         return (validaDatosFiscalia());
      }
    }

    function validaSujetosProcesales(){
      if(!arrSujetosProcesales.length) return {'estatus':0,'campo':'-','error':'No ha agregado ningun sujeto procesal'};

      if(!arrSujetosProcesales.some(sujeto=>sujeto.tipo_parte==46))return {'estatus':0,'campo':'-','error':'No ha agregado a ningún imputado'};


      return 100;
    }

    function cambiarPantalla(stepModal=''){
      if(stepModal=='modal'){
        step--;
      }
      switch(step){
        case 1:
          mostrarDatosSolicitud();
          break;
        case 2:
          mostrarSujetosProcesales();
          break;
        case 3:
        mostrarDocumentacion();
          break;
        /* case 4:
          mostrarModalDocumento();
          break; */
      }

    }

    function validaDatosFiscalia(){

    }

    function validaDatosSolicitud(){


      if(!expRegFecha.test($('#fechaRecepcion').val())) return {'estatus':0,'campo':'fechaRecepcion','error':'Falta la fecha de recepción o el formato es inválido'};

      if(!expRegHora.test($('#horaRecepcion').val())) return {'estatus':0,'campo':'horaRecepcion','error':'Falta la hora de recepción o el formato es inválido'};
      if($('#entidadExhortante').val()==null) return {'estatus':0,'campo':'entidadExhortante','error':'No ha seleccionado la entidad exhortante'};
      if(expVacio.test($('#juzgadoExhortante').val())) return {'estatus':0,'campo':'juzgadoExhortante','error':'Falta el juzgado exhortante'};
      if(expVacio.test($('#juezExhortante').val())) return {'estatus':0,'campo':'juezExhortante','error':'Falta el juez exhortante'};
      if(expVacio.test($('#expedienteOrigen').val())) return {'estatus':0,'campo':'expedienteOrigen','error':'Falta el expediente origen'};

      if($('#delegacionExhorto').val()==null) return {'estatus':0,'campo':'delegacionExhorto','error':'No ha seleccionado la delegacion de exhorto'};


     if(!$('input:radio[name=medio_recepcion]:checked').length) return {'estatus':0,'campo':'medioRecepcion','error':'No ha seleccionado el medio de recepción'};
     if(!$('input:radio[name=materia_destino]:checked').length) return {'estatus':0,'campo':'materiaDestino','error':'No ha seleccionado la materia de destino'};


     if(!$('input:radio[name=tipo_unidad_destino]:checked').length) return {'estatus':0,'campo':'tipoUnidadDestino','error':'No ha seleccionado el tipo de unidad de destino'};


       if($('input:radio[name=tipo_unidad_destino]:checked').val()=='control'){
            if(!$('input:radio[name=tipo_delito]:checked').length) return {'estatus':0,'campo':'divTipoDelito','error':'No ha seleccionado el tipo de delito'};

        } else if($('input:radio[name=tipo_unidad_destino]:checked').val()=='ejecucion') {

             if(!$('input:radio[name=tipo_delito]:checked').length) return {'estatus':0,'campo':'divTipoDelito','error':'No ha seleccionado el tipo de delito'};
        }

        else if($('input:radio[name=tipo_unidad_destino]:checked').val()=='especifica') {

          if($('#unidadDestino').val()==null) return {'estatus':0,'campo':'unidadDestino','error':'No ha seleccionado la unidad destino'};
          if(expVacio.test($('#motivoAsignacionUnidad').val())) return {'estatus':0,'campo':'motivoAsignacionUnidad','error':'Falta el motivo de asignación a la unidad'};

        }

      if(expVacio.test($('#resumenExhorto').val())) return {'estatus':0,'campo':'resumenExhorto','error':'Falta el resumen del exhorto'};

      return 100;
    }

    function validaDatosSujetoProcesal(){
       if($('#tipoParte').val()==null) return {'estatus':0,'campo':'tipoParte','error':'No ha seleccionado el tipo de la parte'};

      if($('#tipoPersona').val()==null) return {'estatus':0,'campo':'tipoPersona','error':'No ha seleccionado el tipo de la persona'};

      if($('#nacionalidad').val()=='extranjero'){
        if($('#otraNacionalidad').val()==null) return {'estatus':0,'campo':'otraNacionalidad','error':'No ha seleccionado la nacionalidad"'};
      }

      if($('#tipoPersona').val()=='fisica'){

        if(expVacio.test($('#nombre').val())) return {'estatus':0,'campo':'nombre','error':'Falta el nombre de la parte'};

        if(expVacio.test($('#apellidoPaterno').val())) return {'estatus':0,'campo':'apellidoPaterno','error':'Falta el apellido paterno de la parte'};

        if($('#genero').val()==null) return {'estatus':0,'campo':'genero','error':'No ha seleccionado el género'};

      }else{

        if(expVacio.test($('#razonSocial').val())) return {'estatus':0,'campo':'razonSocial','error':'Falta la razón social'};

      }

      if(!expVacio.test($('#rfc').val())){
        if(!expRFC.test($('#rfc').val())) return {'estatus':0,'campo':'rfc','error':'El formato del RFC es inválido'};
      }

      return 100;
    }

    function mostrarDatosSolicitud(){
      $('#step-datos-solicitud').addClass('activo').removeClass('resuelto espera');
      $('#step-sujetos-procesales').addClass('espera').removeClass('activo resuelto');
      $('#step-documentacion').addClass('espera').removeClass('resuelto activo')

      $('#datosSolicitudExhorto').removeClass('d-none');

      $('#sujetosProcesales').addClass('d-none');
      $('#atras').attr('disabled', true);
      if($('#tipoAudiencia').hasClass('select2-hidden-accessible')){
        $('#tipoAudiencia').select2('destroy');
      }
      setTimeout(()=>{
        $('#tipoAudiencia').select2({minimumResultsForSearch: ''});
      },150);

      $('#siguiente').removeClass('d-none');
      $('#siguiente').addClass('bd-0 d-inline-block');

      $('#btn-enviar-solicitud').addClass('d-none');
      $('#btn-enviar-solicitud').removeClass('bd-0 d-inline-block');


    }

    function mostrarSujetosProcesales(){
      $('#step-datos-solicitud').addClass('resuelto').removeClass('espera activo');
      $('#step-sujetos-procesales').addClass('activo').removeClass('resuelto espera');
      $('#step-documentacion').addClass('espera').removeClass('resuelto activo');

      $('#datosSolicitudExhorto').addClass('d-none');
      $('#div-datos-documentacion').addClass('d-none');
      $('#sujetosProcesales').removeClass('d-none');
      $('#atras').removeAttr('disabled');

      $('#siguiente').removeClass('d-none');
      $('#siguiente').addClass('bd-0 d-inline-block');

      $('#btn-enviar-solicitud').addClass('d-none');
      $('#btn-enviar-solicitud').removeClass('bd-0 d-inline-block');


      if($('#tipoParte').hasClass('select2-hidden-accessible')){
        $('#tipoParte').select2('destroy');
      }
      if($('#otraNacionalidad').hasClass('select2-hidden-accessible')){
        $('#otraNacionalidad').select2('destroy');
      }
      if($('#estado').hasClass('select2-hidden-accessible')){
        $('#estado').select2('destroy');
      }
      if($('#municipio').hasClass('select2-hidden-accessible')){
        $('#municipio').select2('destroy');
      }

      setTimeout(()=>{
        $('#tipoParte').select2({minimumResultsForSearch: ''});
        $('#otraNacionalidad').attr('disabled', true).select2({minimumResultsForSearch: ''});
        $('#estado').select2({minimumResultsForSearch: ''});
        $('#municipio').select2({minimumResultsForSearch: ''});
      },20);

      $('#tipoPersona').select2({minimumResultsForSearch: Infinity});
      $('#nacionalidad').select2({minimumResultsForSearch: Infinity});
      $('#genero').select2({minimumResultsForSearch: Infinity});
      $('#estadoCivil').select2({minimumResultsForSearch: Infinity});



    }



    function agregarSujetoProcesal(){
      const aliasSujeto=[];
      const correos=[];
      const telefonos=[];

      $('.datos-alias').each(function(){
        datos={
          descripcion:$(this).find('.alias').val(),
        }
        aliasSujeto.push(datos);
      });

      $('.datos-correo').each(function(){
        datos={
          correo:$(this).find('.correo-electronico').val(),
        }
        correos.push(datos);
      });

      $('.datos-telefono').each(function(){
        datos={
          tipo:$(this).find('.tipo-telefono').val(),
          numero:$(this).find('.numero-telefono').val(),
          extension:$(this).find('.extension').val(),
        }
        telefonos.push(datos);
      });


      const sujetoProcesal={
        "tipo_parte":$('#tipoParte').val(),
        "tipo_parte_text":$('#tipoParte').find('option:selected').text(),
        "tipo_persona":$('#tipoPersona').val(),
        "tipo_persona_text":$('#tipoPersona').find('option:selected').text(),
        "nacionalidad":$('#nacionalidad').val(),
        "nacionalidad_text":$('#nacionalidad').find('option:selected').text(),
        "otra_nacionalidad":$('#otraNacionalidad').val(),
        "curp":$('#curp').val(),
        "rfc":$('#rfc').val(),
        "cedula_profesional":$('#cedulaProfesional').val(),
        "nombre":$('#nombre').val(),
        "apellido_paterno":$('#apellidoPaterno').val(),
        "apellido_materno":$('#apellidoMaterno').val(),
        "genero":$('#genero').val(),
        "genero_text":$('#genero').find('option:selected').text(),
        "fecha_nacimiento":$('#fechaNacimiento').val(),
        "edad":$('#edad').val(),
        "estado_civil":$('#estadoCivil').val(),
        "estado_civil_text":$('#estadoCivil').find('option:selected').text(),
        "razon_social":$('#razonSocial').val(),
        "calle":$('#calle').val(),
        "numero_exterior":$('#numeroExterior').val(),
        "numero_interior":$('#numeroInterior').val(),
        "colonia":$('#colonia').val(),
        "codigo_postal":$('#codigoPostal').val(),
        "estado":$('#estado').val(),
        "estado_text":$('#estado').find('option:selected').text(),
        "cve_estado":$('#estado').find('option:selected').attr('data-cve-estado'),
        "municipio":$('#municipio').val(),
        "municipio_text":$('#municipio').find('option:selected').text(),
        "localidad":$('#localidad').val(),
        "entre_calle":$('#entreCalle').val(),
        "otra_referencia":$('#otrasReferencias').val(),
        "alias":aliasSujeto,
        "correos":correos,
        "telefonos":telefonos,
        "delitos":[],
      };
      arrSujetosProcesales.push(sujetoProcesal);

      muestraSujetosProcesales();

    }

    function muestraSujetosProcesales(){
      let tableSujetosProcesales='';

      $(arrSujetosProcesales).each(function(index, datosSujeto){
        const {tipo_parte,tipo_parte_text, nombre, apellido_paterno, apellido_materno,  razon_social, genero, genero_text, delitos} = datosSujeto;
        let listaDelitos='';
        $(delitos).each(function(index, delito){
          li=`${delito.delito_text}<br>`;
          listaDelitos=listaDelitos.concat(li);
        });
        const verDelitos=tipo_parte==46?`<a href="javascript:void(0)" onclick="verDelitos(${index})"  data-toggle="tooltip" data-placement="a" title="Ver Delitos"><i class="icon ion-clipboard"></i></a>`:'';
        const sujeto= `<tr>
                        <td class="seleccion">
                          <label class="ckbox">
                            <input type="checkbox" class="sujeto-seleccion" value="${index}"><span></span>
                          </label>
                        </td>
                        <td class="acciones">
                          <a href="javascript:void(0)" onclick="verSujeto(${index})"  data-toggle="tooltip" data-placement="a" title="Ver Detalles" ><i class="icon ion-person"></i></a>
                          ${verDelitos}
                        </td>
                        <td class="tipo-parte">${tipo_parte_text}</td>
                        <td class="nombre">${razon_social}${nombre} ${apellido_paterno} ${apellido_materno} ${razon_social}</td>
                        <td class="delito">${listaDelitos}</td>
                        <td class="genero">${genero==null?'':genero_text}</td>
                      </tr>`;

        tableSujetosProcesales=tableSujetosProcesales.concat(sujeto);
      });

      $('#tableSujetosProcesales').html(tableSujetosProcesales);
    }

    function verDelitos(indexSujeto){

      muestraDelitosSujeto(indexSujeto);

      $('#titleSujeto').html('Delitos');
      $('#modalDatosSujeto').modal('show');
    }

    function muestraDelitosSujeto(indexSujeto){
      $('#tableDatosSujeto').html('');
      const tableHead= `<thead style="background-color: #EBEEF1; color="#000">
                        <tr>
                          <th class="elimina-delito"></th>
                          <th class="delito-s">Delito</th>
                        </tr>
                      </thead>`;
      let listaDelitos='';
      const delitos=arrSujetosProcesales[indexSujeto].delitos;
      $(delitos).each(function(index, datosDelito){
        const {delito_text, modalidad_text, calificativo_text, grado_realizacion_text} = datosDelito;
        tr=`<tr data-delito=${index}>
              <td class="elimina-delito">
                <i class="icon ion-close tx-danger" data-toggle="tooltip" data-placement="bottom" title="Quitar Delito" onclick="eliminaDelito(${indexSujeto},${index})"></i>
              </td>
              <td class="delito-s">${delito_text}</td>
            </tr>
        ${delito.delito}<br>`;
        listaDelitos=listaDelitos.concat(tr);
      });

      $('#tableDatosSujeto').append(tableHead).css({"overflow-x": "scroll", "display":"block"});
      $('#tableDatosSujeto').append(`<tbody class="datos-delitos-sujeto">${listaDelitos}</tbody>`);
      $('#divEditarDelito').html(``).css({"margin-left": "0"});
    }

    function eliminaDelito(indexSujeto, indexDelito){

      const nArrSujetosProcesales = arrSujetosProcesales.map((sujeto, indexS)=>{
        if(indexSujeto==indexS){

          const nDElitos=sujeto.delitos.filter((delito, indexD)=>{
            if(indexDelito!=indexD){
              return delito;
            }
          });
          sujeto.delitos=nDElitos;
        }
        return sujeto;
      });

      arrSujetosProcesales=nArrSujetosProcesales;
      muestraDelitosSujeto(indexSujeto);
      muestraSujetosProcesales()
    }

    function verSujeto(index){

      const {tipo_parte_text, nacionalidad, nacionalidad_text, curp, rfc, cedula_profesional, nombre, apellido_paterno, apellido_materno, razon_social, genero, genero_text, fecha_nacimiento, estado_civil, estado_civil_text, estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia,direcciones, entre_calle,alias, correos, telefonos, delitos}=arrSujetosProcesales[index];

console.log(arrSujetosProcesales);

      let listaDelitos='',
          listaAlias='',
          listaCorreos='',
          listaTelefonos='';

      $(alias).each(function(index, ali){
          li=`${ali.alias}<br>`;
          listaAlias=listaAlias.concat(li);
      });

      $(correos).each(function(index, correo){
          li=`${correo.correo}<br>`;
          listaCorreos=listaCorreos.concat(li);
      });

      $(telefonos).each(function(index, telefono){
          li=`${telefono.tipo}: ${telefono.numero} ${telefono.extension}<br>`;
          listaTelefonos=listaTelefonos.concat(li);
      });

      const table= `<tbody class="table-datos-sujeto">
                      <tr>
                        <td>Calidad Jurídica</td>
                        <td>${tipo_parte_text}</td>
                      </tr>
                      <tr>
                        <td>Nombre ó Razón Social</td>
                        <td>${razon_social}${nombre} ${apellido_paterno} ${apellido_materno}</td>
                      </tr>
                      <tr>
                        <td>RFC</td>
                        <td>${rfc}</td>
                      </tr>
                      <tr>
                        <td>CURP</td>
                        <td>${curp}</td>
                      </tr>
                      <tr>
                        <td>Cédula Profesional</td>
                        <td>${cedula_profesional}</td>
                      </tr>
                      <tr>
                        <td>Género</td>
                        <td>${genero==''?'':genero==null?'':genero_text}</td>
                      </tr>
                      <tr>
                        <td>Fecha de Nacimiento</td>
                        <td>${fecha_nacimiento}</td>
                      </tr>
                      <tr>
                        <td>Nacionalidad</td>
                        <td>${nacionalidad==''?'':nacionalidad==null?'':nacionalidad_text}</td>
                      </tr>
                      <tr>
                        <td>Estado Civíl</td>
                        <td>${estado_civil==''?'':estado_civil==null?'':estado_civil_text}</td>
                      </tr>
                      <tr>
                        <td>Alias</td>
                        <td>${listaAlias}</td>
                      </tr>
                      <tr>
                        <td>Domicilio</td>
                        <td>
                          Calle: ${direcciones[index].calle} <br>
                          Número Ext: ${direcciones[index].numero_exterior} <br>
                          Número Int: ${direcciones[index].numero_interior} <br>
                          Entre Calles: ${direcciones[index].entre_calle} <br>
                          Otras Referencias: ${direcciones[index].otra_referencia} <br>
                          Colonia: ${direcciones[index].colonia} <br>
                          Localidad: ${direcciones[index].localidad} <br>
                          Municipio: ${direcciones[index].municipio} <br>
                          Estado: ${direcciones[index].estado} <br>
                        </td>
                        <tr>
                          <td>Correo(s) Electrónico(s)</td>
                          <td>${listaCorreos}</td>
                        <tr>
                        <tr>
                          <td>Teléfono(s)</td>
                          <td>${listaTelefonos}</td>
                        </tr>
                      </tr>
                    </tbody>`;
      $('#titleSujeto').html('Datos');
      $('#tableDatosSujeto').html(table).css({"overflow-x": "none", "display": "table"});
      $('#divEditarDelito').html(`<button class="btn btn-primary d-inline-block" data-dismiss="modal" id="editarSujeto" onclick="editarSujeto(${index})">Editar</button>`).css({"margin-left": "auto"});
      $('#modalDatosSujeto').modal('show');
    }

    function editarSujeto(index){
      const {tipo_parte, tipo_persona, nacionalidad,otra_nacionalidad,direcciones, curp, rfc, cedula_profesional, nombre, apellido_paterno, apellido_materno, razon_social, genero, fecha_nacimiento, estado_civil, estado, municipio , colonia, localidad,codigo_postal,calle,numero_exterior, numero_interior, otra_referencia, entre_calle,alias, correos, telefonos,  edad, cve_estado}=arrSujetosProcesales[index];

      if($('#tipoParte').hasClass('select2-hidden-accessible')){
        $('#tipoParte').select2('destroy');
        $('#tipoParte').val(tipo_parte);
      }
      setTimeout(()=>{
        $('#tipoParte').select2({minimumResultsForSearch: ''});
      },200);

      $('#tipoPersona').val(tipo_persona).select2({minimumResultsForSearch: Infinity});
      if(tipo_persona=='moral'){
        $('.moral').removeClass('d-none');
        $('.fisica').addClass('d-none')
        $('.fisica').find('.form-control').val('');
      }else{
        $('.fisica').removeClass('d-none');
        $('.moral').addClass('d-none')
        $('.moral').find('.form-control').val('');
      }

      $('#nacionalidad').val(nacionalidad).select2({minimumResultsForSearch: Infinity});
      if(nacionalidad=='mexicana' || nacionalidad==null || nacionalidad==''){
        $('#otraNacionalidad').attr('disabled', true).val('');
      }else{
        $('#divOtraNacionalidad').removeClass('d-none');
        $('#otraNacionalidad').removeAttr('disabled')
        if($('#otraNacionalidad').hasClass('select2-hidden-accessible')){
          $('#otraNacionalidad').select2('destroy');
          $('#otraNacionalidad').val(otra_nacionalidad)
        }
        setTimeout(()=>{
          $('#otraNacionalidad').select2({minimumResultsForSearch: ''});
        },150);
      }


      $('#curp').val(curp);
      $('#rfc').val(rfc);
      $('#cedulaProfesional').val(cedula_profesional);
      $('#nombre').val(nombre);
      $('#apellidoPaterno').val(apellido_paterno);
      $('#apellidoMaterno').val(apellido_materno);
      $('#genero').val(genero).select2({minimumResultsForSearch: Infinity});
      $('#estadoCivil').val(estado_civil).select2({minimumResultsForSearch: Infinity});
      $('#fechaNacimiento').val(fecha_nacimiento);
      $('#edad').val(edad);
      $('#razonSocial').val(razon_social);
      $('#localidad').val(direcciones[index].localidad);
      $('#calle').val(direcciones[index].calle);
      $('#numeroExterior').val(direcciones[index].numero_exterior);
      $('#numeroInterior').val(direcciones[index].numero_interior);
      $('#colonia').val(direcciones[index].colonia);
      $('#codigoPostal').val(direcciones[index].codigo_postal);

      if($('#estado').hasClass('select2-hidden-accessible')){
        $('#estado').select2('destroy');
        $('#estado').val(estado);
      }
      setTimeout(()=>{
        $('#estado').select2({minimumResultsForSearch: ''});
      },150);

      if(estado!=null && estado!='' && municipio!=null && municipio!=''){
        $.ajax({
          type:'POST',
          url:'/public/obtener_municipios',
          data:{
            estado:cve_estado,
          },
          success:function(response){
            if(response.status==100){
              let municipios='<option disabled selected>Elija una opción</option>';
              $(response.response).each(function(index, datosMunicipio){
                if(datosMunicipio.id_municipio==municipio){
                  let option=`<option value="${datosMunicipio.id_municipio}" selected>${datosMunicipio.municipio}</option>`;
                  municipios=municipios.concat(option);
                }else{
                  let option=`<option value="${datosMunicipio.id_municipio}">${datosMunicipio.municipio}</option>`;
                  municipios=municipios.concat(option);
                }
              });

              if($('#municipio').hasClass('select2-hidden-accessible')){
                $('#municipio').select2('destroy');
                $('#municipio').html(municipios);

              }
              setTimeout(()=>{
                $('#municipio').select2({minimumResultsForSearch: ''});
              },150);

            }
          }
        });
      }


      $('#entreCalle').val(direcciones[index].entre_calle);
      $('#otrasReferencias').val(direcciones[index].otra_referencia);

      if(alias.length){
        sAlias='';
        $(alias).each(function(index, ali){
          sAlias=sAlias.concat(`<div class="row datos-alias">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-alias"></i></p>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Alias:</label>
                                    <input class="form-control alias" type="text" name="alias" autocomplete="off" value="${ali.alias}">
                                  </div>
                                </div><!-- col-3-->
                              </div>`);
        });
        $('#datosAlias').html(sAlias);
      }

      if(correos.length){
        sCorreos='';
        $(correos).each(function(index, correo){
          sCorreos=sCorreos.concat(`<div class="row datos-correo">
                                      <div class="col-12">
                                        <p class="tx-right tx-danger"><i class="fa fa-close borrar-correo"></i></p>
                                      </div>
                                      <div class="col-8">
                                        <div class="form-group mg-b-10-force">
                                          <label class="form-control-label">Correo Electrónico:</label>
                                          <input class="form-control correo-electronico" type="text" name="correo_electronico" autocomplete="off" value="${correo.correo}">
                                        </div>
                                      </div><!-- col-3-->
                                    </div>`);
        });
        $('#correos').html(sCorreos);
      }

      if(telefonos.length){
        sTelefonos='';
        $(telefonos).each(function(index, telefono){
          sTelefonos=sTelefonos.concat(`<div class="row datos-telefono">
                                          <div class="col-12">
                                            <p class="tx-right tx-danger"><i class="fa fa-close borrar-telefono"></i></p>
                                          </div>
                                          <div class="col-lg-3">
                                            <div class="form-group">
                                              <label class="form-control-label">Tipo: </label>
                                              <select class="form-control tipo-telefono"  name="tipo_telefono" autocomplete="off">
                                                  <option value="fijo" ${telefono.tipo=='fijo'?'selected':''}>Fijo</option>
                                                  <option value="celular" ${telefono.tipo=='celular'?'selected':''}>Celular</option>
                                              </select>
                                            </div>
                                          </div><!-- col-3-->
                                          <div class="col-lg-4">
                                            <div class="form-group mg-b-10-force">
                                              <label class="form-control-label">Número:</label>
                                              <input class="form-control numero-telefono" type="text" name="numero_telefono" autocomplete="off" value="${telefono.numero}">
                                            </div>
                                          </div><!-- col-3-->
                                          <div class="col-lg-2">
                                            <div class="form-group mg-b-10-force">
                                              <label class="form-control-label">Extension:</label>
                                              <input class="form-control extension" type="text" name="estension" autocomplete="off" value="${telefono.extension}">
                                            </div>
                                          </div><!-- col-3-->
                                        </div>`);
        });

        $('.tipo-telefono').select2({minimumResultsForSearch: Infinity});;
        $('#telefonos').html(sTelefonos);
      }

      $('#botonesPartes').append(`<button type="button" class="btn btn-secondary d-inline-block btn-edicion mg-l-auto" onclick="limpiarCamposSujetos()">Cancelar</button>
                                  <button class="btn btn-primary d-inline-block   btn-edicion mg-l-5"  onclick="editarDatosSujeto(${index})">Guardar Edición</button>`);
      $('#agregarParte').addClass('d-none').removeClass('d-inline-block');

    }

    function editarDatosSujeto(indexEditado){
      const delitos=arrSujetosProcesales[indexEditado].delitos,
            aliasSujeto=[],
            correos=[],
            telefonos=[];

      $('.datos-alias').each(function(){
        datos={
          aliasSujeto:$(this).find('.alias').val(),
        }
        aliasSujeto.push(datos);
      });

      $('.datos-correo').each(function(){
        datos={
          correo:$(this).find('.correo-electronico').val(),
        }
        correos.push(datos);
      });

      $('.datos-telefono').each(function(){
        datos={
          tipo:$(this).find('.tipo-telefono').val(),
          numero:$(this).find('.numero-telefono').val(),
          extension:$(this).find('.extension').val(),
        }
        telefonos.push(datos);
      });


      const sujetoProcesal={
        "tipo_parte":$('#tipoParte').val(),
        "tipo_parte_text":$('#tipoParte').find('option:selected').text(),
        "tipo_persona":$('#tipoPersona').val(),
        "tipo_persona_text":$('#tipoPersona').find('option:selected').text(),
        "nacionalidad":$('#nacionalidad').val(),
        "nacionalidad_text":$('#nacionalidad').find('option:selected').text(),
        "otra_nacionalidad":$('#otraNacionalidad').val(),
        "curp":$('#curp').val(),
        "rfc":$('#rfc').val(),
        "cedula_profesional":$('#cedulaProfesional').val(),
        "nombre":$('#nombre').val(),
        "apellido_paterno":$('#apellidoPaterno').val(),
        "apellido_materno":$('#apellidoMaterno').val(),
        "genero":$('#genero').val(),
        "genero_text":$('#genero').find('option:selected').text(),
        "fecha_nacimiento":$('#fechaNacimiento').val(),
        "edad":$('#edad').val(),
        "estado_civil":$('#estadoCivil').val(),
        "estado_civil_text":$('#estadoCivil').find('option:selected').text(),
        "razon_social":$('#razonSocial').val(),
        "calle":$('#calle').val(),
        "numero_exterior":$('#numeroExterior').val(),
        "numero_interior":$('#numeroInterior').val(),
        "colonia":$('#colonia').val(),
        "codigo_postal":$('#codigoPostal').val(),
        "estado":$('#estado').val(),
        "estado_text":$('#estado').find('option:selected').text(),
        "cve_estado":$('#estado').find('option:selected').attr('data-cve-estado'),
        "municipio":$('#municipio').val(),
        "municipio_text":$('#municipio').find('option:selected').text(),
        "localidad":$('#localidad').val(),
        "entre_calle":$('#entreCalle').val(),
        "otra_referencia":$('#otrasReferencias').val(),
        "alias":aliasSujeto,
        "correos":correos,
        "telefonos":telefonos,
        "delitos":delitos,
      };
      arrSujetosProcesales[indexEditado]=sujetoProcesal;


      if($('#tipoParte').val()!=46){
        arrSujetosProcesales[indexEditado].delitos=[];
      }

      $('#tipoParte').select2('destroy');
      $('#otraNacionalidad').select2('destroy');
      $('#estado').select2('destroy');
      $('#municipio').select2('destroy');
      muestraSujetosProcesales();
      limpiarCamposSujetos();

    }

    function obtenerSujetosSeleccionados(){
      let sujetosSeleccionados=[];
      if($('input[class=sujeto-seleccion]:checked').length){
        $('input[class=sujeto-seleccion]:checked').each(function(){
          sujetosSeleccionados.push($(this).val());
        });
      }
      return sujetosSeleccionados;
    }

    function limpiarCamposSujetos(){
      $('#tipoParte').val('').select2({minimumResultsForSearch: ''});
      $('#tipoPersona').val('').select2({minimumResultsForSearch: Infinity});
      $('#nacionalidad').val('').select2({minimumResultsForSearch: Infinity});
      $('#otraNacionalidad').val('').attr('disabled', true).select2({minimumResultsForSearch: ''});
      $('#curp').val('');
      $('#rfc').val('');
      $('#cedulaProfesional').val('');
      $('#nombre').val('');
      $('#apellidoPaterno').val('');
      $('#apellidoMaterno').val('');
      $('#genero').val('').select2({minimumResultsForSearch: Infinity});
      $('#estadoCivil').val('').select2({minimumResultsForSearch: Infinity});
      $('#fechaNacimiento').val('');
      $('#edad').val('');
      $('#razonSocial').val('');
      $('#estado').val('');
      $('#localidad').val('');
      $('#calle').val('');
      $('#numeroExterior').val('');
      $('#numeroInterior').val('');
      $('#colonia').val('');
      $('#codigoPostal').val('');
      $('#estado').val('').select2({minimumResultsForSearch: ''});
      $('#municipio').val('').select2({minimumResultsForSearch: ''});
      $('#entreCalle').val('');
      $('#otrasReferencias').val('');
      $('#datosAlias').html('');
      $('#correos').html('');
      $('#telefonos').html('');

      $('#agregarParte').removeClass('d-none').addClass('d-inline-block');
      $('.btn-edicion').remove();
    }

    function limpiarCamposDelito(){

      $('#modalidadDelito').val('').select2({minimumResultsForSearch: Infinity});
      $('#calificativo').val('').select2({minimumResultsForSearch: Infinity});
      $('#gradoRealizacion').val('').select2({minimumResultsForSearch: Infinity});
    }

    function guardarDelito(sujetos){
      $('.error').removeClass('error');

      const validacion=validaDatosDelito();

      if(validacion==100){

        const sujetosSeleccionados=JSON.parse(sujetos);
        let nArrSujetosProcesales=arrSujetosProcesales.map((sujeto, index)=>{
          if(sujetosSeleccionados.some(indexSeleccionado=>indexSeleccionado==index) && sujeto.tipo_parte==46){
            sujeto.delitos.push({
              "id_delito":$('#delito').val(),
              "delito_text":$('#delito').find('option:selected').text(),
              "id_modalidad":$('#modalidadDelito').val(),
              "modalidad_text":$('#modalidadDelito').find('option:selected').text(),
              "id_calificativo":$('#calificativo').val(),
              "calificativo_text":$('#calificativo').find('option:selected').text(),
              "forma_comision":"forma",
              "grado_realizacion":$('#gradoRealizacion').val(),
              "grado_realizacion_text":$('#gradoRealizacion').find('option:selected').text(),
              "delito_grave":$('#delito').find('option:selected').attr('data-grave'),
              });
          }
          return sujeto;
        });

        nArrSujetosProcesales=arrSujetosProcesales;
        $('#modalAgregarDelito').modal('hide');
        limpiarCamposDelito();
        muestraSujetosProcesales();

      }else{
        const {campo , error} = validacion;
        if($('#'+campo).is('select')){
          $('span[aria-labelledby="select2-'+campo+'-container"]').addClass('error');
        }else{
          $('#'+campo).focus().addClass('error');
        }
        $('#messageError').html(`${error}`);
        $('#modalError').modal('show');
      }


    }

    function validaDatosDelito(){
      if($('#delito').val()==null) return {'estatus':0,'campo':'delito','error':'No ha seleccionado el delito'};

/*       if($('#modalidadDelito').val()==null) return {'estatus':0,'campo':'modalidadDelito','error':'No ha seleccionado la modalidad del delito'};

      if($('#calificativo').val()==null) return {'estatus':0,'campo':'calificativo','error':'No ha seleccionado el calificativo'};

      if($('#gradoRealizacion').val()==null) return {'estatus':0,'campo':'gradoRealizacion','error':'No ha seleccionado el grado de realizacion'};
 */
      return 100;
    }

    function mostrarModalDocumento(){
      $('#modalAdjuntarDocumento').modal('show');
    }

    function mostrarDocumentacion(){
      $('#step-datos-solicitud').addClass('resuelto').removeClass('espera activo');
      $('#step-sujetos-procesales').addClass('resuelto').removeClass('espera activo');
      $('#step-documentacion').addClass('activo').removeClass('resuelto espera');
      $('#datosSolicitudExhorto').addClass('d-none');
      $('#sujetosProcesales').addClass('d-none');
      $('#div-datos-documentacion').removeClass('d-none');

      $('#atras').removeAttr('disabled');

      $('#siguiente').addClass('d-none');
      $('#siguiente').removeClass('bd-0 d-inline-block');
      $('#btn-enviar-solicitud').removeClass('d-none');
      $('#btn-enviar-solicitud').removeClass('bd-0 d-inline-block');


    }



    $('#div-view-archivos').on('click','.borrar_documento',function(){

      let clearedArray = [];
      let index_deleted = $(this).data('indexdocumento');

      console.log("borrar index doc : "+ index_deleted);

      $(documentos).each(function(index, archivo){
        if ( index != index_deleted ){
          clearedArray.push(archivo);
        }
      });

      documentos = clearedArray;
      pintar_documentos();
    });

    function refresca_nombres_documentos(){
      $(".nombre_documento").each(function(){
        documentos[ $(this).data('indexdocumento') ].nombre_documento = ($(this).val()).replaceAll(' ', '_');
      });
    }

    function get_tipo_data(extension){
      if( extension == 'pdf' || extension == 'PDF' ) return 'data:application/pdf;base64,';
      if( extension == 'jpg' || extension == 'JPG' ) return 'data:image/jpeg;base64,';
      if( extension == 'png' || extension == 'PNG' ) return 'data:image/png;base64,';
      if( extension == 'doc' || extension == 'DOC' ) return '';
      if( extension == 'docx' || extension == 'DOCX' ) return '';
    }

    function pintar_documentos(){
      console.log("Pinta documentos");
      $('#div-view-archivos div').remove();
      let reader_files=["pdf","png","jpg","PDF","PNG","JPG"];

      $(documentos).each(function(index, documento){

        if ( reader_files.includes(documento.extension) ) {

          $('#div-view-archivos').append(`
            <div class="col-sm-3" span="3">
                <div class="row justify-content-center">
                  <div class="col align-self-center" align="center">
                      <p class="tx-center tx-danger"><i class="fa fa-times-circle size-2x custom-x borrar_documento" data-indexdocumento="${index}" style="right: -85px !important;"></i></p>
                      <div style="height:150px; width:170px; border-style: solid; border-color: rgba(206, 212, 218, 0.38); border-radius: 10px; border-width: 10px;">
                       <object width="150px" height="100px" class="mg-t-25" data="${documento.tipo_data+documento.b64_doc}"></object>
                      </div>
                  </div>
                </div>
                <div class="row justify-content-center" align="center">
                  <div class="col align-self-center">
                      <div class="form-group mg-b-10-force">
                        <br>
                        <label id="lbl-nom-doc-${index}">${documento.nombre}</label><span id="lbl-ext-doc-${index}">.${documento.extension}</span>
                        <input id="edit-nom-doc-${index}" class="form-control d-none nombre_documento" type="text" data-indexdocumento="${index}" name="nombre_archivo" autocomplete="off" value="${documento.nombre}">
                      </div>
                  </div>
                </div>
            </div>`);
        }else{
          $('#div-view-archivos').append(`
            <div class="col-sm-3" span="3">
                <div class="row justify-content-center" align="center">
                  <div class="col align-self-center">
                    <p class="tx-center tx-danger"><i class="fa fa-times-circle size-2x custom-x borrar_documento" data-indexdocumento="${index}" style="right: -35px !important;"></i></p>
                    <div style="height:150px; width:170px;border-style: solid; border-color: rgba(206, 212, 218, 0.38); border-radius: 10px; border-width: 10px;">
                      <i class="icon ion-document-text ion-10x"></i>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center" align="center">
                  <div class="col align-self-center">
                      <div class="form-group mg-b-10-force">
                        <br>
                        <label id="lbl-nom-doc-${index}">${documento.nombre}</label><span id="lbl-ext-doc-${index}">.${documento.extension}</span>
                        <input id="edit-nom-doc-${index}" class="form-control d-none nombre_documento" type="text" data-indexdocumento="${index}" name="nombre_archivo" autocomplete="off" value="${documento.nombre}">
                      </div>
                  </div>
                </div>
            </div>`);
        }

        $("#lbl-nom-doc-"+index).click(function(){
          $(this).addClass('d-none');
          $("#lbl-ext-doc-"+index).addClass('d-none');
          $("#edit-nom-doc-"+index).removeClass('d-none');
        });
        $("#edit-nom-doc-"+index).focusout(function(e){
          $(this).val( ($(this).val()).replace(' ', '_') );
          $("#lbl-nom-doc-"+index).text( ($(this).val()).replace(' ', '_') );
          $("#lbl-nom-doc-"+index).removeClass('d-none');
          $("#lbl-ext-doc-"+index).removeClass('d-none');
          $(this).addClass('d-none');
        });
      });
    }


    function leeDocumento (input) {
      let acepted_files=["pdf","png","jpg","docx","doc","PDF","PNG","JPG","DOCX","DOC"];

      let file = $('#archivoPDF').val();
      let ext = "";
      let extension = "";
      let nombre_documento = "";

      if(file.length){
       ext = file.substring(file.lastIndexOf("."));
       extension = file.split('.')[1];
       extension = extension.toLowerCase();
       nombre_documento = (file.split('\\')[2]).split('.')[0];
       nombre_documento = nombre_documento.replaceAll(' ', '_');
       nombre_documento = nombre_documento.replaceAll('  ', '_');
       if(ext!=''){
          if( !acepted_files.includes(extension) ){
            alert('Solo puede adjuntar archivos PDF, PNG, JPG, DOC, DOCX');
            $('#archivoPDF').val('');
            return false
          }else{
            if (input.files && input.files[0]) {
              let reader = new FileReader();
              reader.onload = e=> {
                documentos.push({
                  'b64_doc' : e.target.result.split('base64,')[1],
                  'nombre' : nombre_documento,
                  'tamanio': input.files[0].size/1024,
                  'extension' : extension,
                  'tipo_data': get_tipo_data(extension),
                });
              }
              reader.readAsDataURL(input.files[0]);
            }
            setTimeout(function(){ refresca_nombres_documentos(); pintar_documentos(); },500);
          }
        }
      }else{
        return false;
      }
    }

    $("#archivoPDF").on('input',function () {
      leeDocumento(this);
    });




    function handleClick(myRadio) {

              var selectedValue = myRadio.value;

              if (selectedValue==="especifica") {
                console.log("especifica");
                $("#divTipoDelito").css("display", "none");
                $("#divEntidad").css("display", "");
                $("#divEntidad2").css("display", "");

              } else if (selectedValue==="control"){
                console.log("control");
                $("#divTipoDelito").css("display", "block");
                $("#divEntidad").css("display", "none");
                $("#divEntidad2").css("display", "none");
              }else if (selectedValue==="ejecucion"){
                console.log("ejecucion");
                $("#divTipoDelito").css("display", "block");
                $("#divEntidad").css("display", "none");
                $("#divEntidad2").css("display", "none");
              }

            }

            function refresca_nombres_documentos(){
      $(".nombre_documento").each(function(){
        documentos[ $(this).data('indexdocumento') ].nombre_documento = ($(this).val()).replaceAll(' ', '_');
      });
    }

    function enviarExhorto(){

                    //$('#modal_loading').modal('show');

              if( !documentos.length ){
                $('#bSocumento').focus().addClass('error');
                $('#messageError').html(`No ha agregago su documento PDF`);
                $('#modalError').modal('show');
              }else{
                const fechaRecepcion=$('#fechaRecepcion').val().split('-');


                console.log( documentos);

                $(documentos).each(function(index, documento){
                  delete documento.input;
                });

                refresca_nombres_documentos();

        let medioRecepcion;

         medioRecepcion= $('input:radio[name=medio_recepcion]:checked').val();

        $.ajax({
          type:'POST',
          url:'/public/enviar_exhorto',
          data:{
            fecha_recepcion:fechaRecepcion[2]+'-'+fechaRecepcion[1]+'-'+fechaRecepcion[0],
            hora_recepcion:$('#horaRecepcion').val(),
            entidad_federativa:$('#entidadExhortante').val(),
            juzgado_exhortante:$('#juzgadoExhortante').val(),
            nombre_juez:$('#juezExhortante').val(),
            expediente_origen:$('#expedienteOrigen').val(),
            no_oficio:$('#folioOficio').val(),
            medio_recepcion:medioRecepcion,
            delitos:"",
            sujetos_procesales:arrSujetosProcesales,
            resumen:$('#resumenExhorto').val(),
            delegacion:$('#delegacionExhorto').val(),
            materia_destino:$('input:radio[name=materia_destino]:checked').val(),

            tipo_unidad:$('input:radio[name=tipo_unidad_destino]:checked').val(),
            unidad_especifica:$('#unidadDestino').val(),
            tipo_delito:$('input:radio[name=tipo_delito]:checked').val(),
            documentos:documentos
          },
           success:function(response){
             console.log(response);

          var carpetaAsignada= response.response_carpeta.response.folio_carpeta;

             if(response.status==100){
               let docAcuse="";

              let tabla=`<table style="border:1px solid #EEE" class="dataTable" id="tableRespuestaSolicitud">
                            <tbody class="table-datos-sujeto">

                              <tr>
                                <td>Id Acuse</td>
                                <td>${response.response.id_acuse}</td>
                              </tr>
                              `;

             tabla=tabla.concat(`
                              <tr>
                                <td>Folio </td>
                                <td><p class="fl-m mg-b-0">${response.response.folio}</p></td>
                              </tr>
                              <tr>
                                <td>Folio de Carpeta Judicial</td>
                                <td>${response.response_carpeta.response.folio_carpeta}</td>
                              </tr>
                              <tr>
                                <td>Unidad de Gestión Judicial Asignada</td>
                                <td>${response.response_carpeta.response.folio_carpeta}</td>
                              </tr>
                              <tr>
                                <td>Fecha de Asignación</td>
                                <td>${response.response_carpeta.response.fecha_asignacion}</td>
                              </tr>
                              <!-- comentado
                              -->
                            </tbody>
                          </table>`);
                    $('#datos-respuesta-solicitud').append(tabla);

                    setTimeout(function(){
                $('#modal_loading').modal('hide');
                }, 500);

                 var  docID=response.response_carpeta.response.id_solicitud;

 var myImage = new Image();
myImage .src = '/images/logo_pjcdmx.jpg';



 //let imgData = '/images/header_2.png';


 var doc = new jsPDF('p','','letter')


  doc.setFontSize(10)
 // doc.addImage(imgData, 'png', 15, 20)
  doc.setTextColor(100)

  // jsPDF 1.4+ uses getWidth, <1.4 uses .width
  var pageSize = doc.internal.pageSize
  var pageWidth = pageSize.width ? pageSize.width : pageSize.getWidth()
  let wantedTableWidth = 100;
  let margin = (pageWidth - wantedTableWidth) / 2;
  //AJUSTE RESPECTO AL TAMAÑO DE LA PAGINA

  var text = doc.splitTextToSize("POR INSTRUCCIONES DEL SEÑOR PRESIDENTE DE ESTE TRIBUNAL, POR CORRESPONDER EN TURNO, SE REMITE ESTE EXHORTO A:", pageWidth - 35, {})
  var text2 = doc.splitTextToSize("LA DEVOLUCIÓN DEL EXHORTO DEBE HACERSE DIRECTAMENTE AL ÓRGANO JURISDICCIONAL EXHORTANTE", pageWidth - 35, {})
  var text3 = doc.splitTextToSize("LA C. JEFA DE LA OFICIALIA DE PARTES DE LA PRESIDENCIA DEL TRIBUNAL SUPERIOR DE JUSTICIA DE LA CIUDAD DE MEXICO", pageWidth - 35, {})
  var text4 = doc.splitTextToSize("LIC. DIANA PATRICIA VILLAVICENCIO GALICIA", pageWidth - 35, {})

  source = $('#tableRespuestaSolicitud')[0];

            /* doc.autoTable({
                head: headRows(),
                body: bodyRows(40),
                startY: 50,
                showHead: 'firstPage',
            }) */

            // doc.text("POR INSTRUCCIONES DEL SEÑOR PRESIDENTE DE ESTE TRIBUNAL, POR CORRESPONDER EN TURNO, SE REMITE ESTE EXHORTO A:", 8, doc.lastAutoTable.finalY - 40)

            //TABLE
        doc.autoTable({ html: source,
        theme: 'grid',
            startY: 110,
            showHead: 'firstPage',tableWidth: 'auto',
            styles: { cellPadding: 0.5, fontSize: 12, halign: 'left' },
            columnStyles: {0: { fillColor: [246, 246, 246], textColor: 0},
        // columnStyles: {0: { fillColor: [233, 255, 237], textColor: 0, fontStyle: 'bold' },
            },margin: {left:margin-10, right: margin}
                })

              doc.text(text2, 20, doc.lastAutoTable.finalY + 20)
              doc.text(text3, 20, doc.lastAutoTable.finalY + 33)
              doc.text(text4, 20, doc.lastAutoTable.finalY + 46)

              doc.text(text, 20, doc.lastAutoTable.finalY - 50)

              myImage .onload = function(){
            doc.addImage(myImage , 'png', 15, 15, 80, 30);
            doc.save('Exhorto '+carpetaAsignada+'.pdf');
          //  doc.output('dataurlnewwindow');

                            };

                docAcuse = doc.output('datauri');

                /*     var string = doc.output('datauristring');
                    var iframe = "<iframe width='100%' height='100%' src='" + string + "'></iframe>"
                    var x = window.open();
                    x.document.open();
                    x.document.write(iframe);
                    x.document.close();
                */

            $.ajax({
                    type:'POST',
                    url:'/public/guardar_acuse_exhorto',
                    data:{
                    b64_pdf:docAcuse,
                    id_solicitud:docID
                    },
                    success:function(response){
                    if(response.status==100){

                        console.log("sisisis");
                    }
                    }
                });

            $('#modalSuccess').modal('show');

            }else{
              let tabla=`<table style="border:1px solid #EEE" class="dataTable" id="tableRespuestaSolicitud">
                            <tbody class="table-datos-sujeto">

                              <tr>
                                <td>Mensaje</td>
                                <td>${response.response_carpeta.message}</td>
                              </tr>
                              `;

             tabla=tabla.concat(`
                              <tr>
                                <td>Folio </td>
                                <td><p class="fl-m mg-b-0">${response}</p></td>
                              </tr>


                              <!-- comentado
                              -->
                            </tbody>
                          </table>`);
                    $('#datos-respuesta-solicitud').append(tabla);
            }//finelse


           }

        });
      }
    }
  </script>
@endsection
@section('seccion-modales')
  <div id="modalError" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-danger mg-b-20">Datos incompletos</h4>
          <p class="mg-b-20 mg-x-20" id="messageError"></p>
          <button type="button" class="btn btn-danger pd-x-25" data-dismiss="modal" aria-label="Close">Aceptar</button>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalAgregarDelito" class="modal fade modal-agregar-delito">
    <div class="modal-dialog modal-lg mg-b-100" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Agregar Delito</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <div class="row form-layout">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Delito: <span class="tx-danger">*</span></label>
                <select class="form-control" id="delito" name="delito" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                   {{--   @foreach ($delitos as $delito)
                        <option value="{{$delito['id_delito']}}" data-grave="{{$delito['delito_oficioso']==1?'si':'no'}}">{{$delito['delito']}}</option>
                    @endforeach --}}
                </select>
              </div>
            </div>
  {{--           <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Modalidad de Delito: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="modalidadDelito" name="modalidad_delito" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>

                </select>
              </div>
            </div>  --}}
          {{--   <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Calificativo: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="calificativo" name="calificativo" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                     @foreach ($calificativos as $calificativo)
                        <option value="{{$calificativo['id_calificativo']}}">{{$calificativo['calificativo']}}</option>
                    @endforeach
                </select>
              </div>
            </div>  --}}
         {{--    <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Grado de Realización: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="gradoRealizacion" name="grado_realizacion" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="de_tentetiva">DE TENTATIVA</option>
                    <option value="consumado">CONSUMADO</option>
                    <option value="por_definir">POR DEFINIR</option>
                </select>
              </div>
            </div>  --}}
          </div>
          <h5 class="lh-3 mg-b-20 mg-t-20 tx-inverse hover-primary">Delito Imputable a:</h5>
          <ul id="listaImputados"></ul>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary d-block" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary d-block ml-auto" id="guardarDelito">Guardar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalDatosSujeto" class="modal fade">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Datos</span> del Sujeto Procesal</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <table id="tableDatosSujeto" class="datatable">
          </table>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <div id="divEditarDelito">

          </div>
          <button type="button" class="btn btn-secondary d-inline-block mg-l-auto" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
 {{--  <div id="modalAdjuntarDocumento" class="modal fade">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Adjuntar Documento</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary d-inline-block mg-r-auto" onclick="cambiarPantalla('modal')"  data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="()">Enviar Solicitud</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal --> --}}
  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="">Exhorto Registrado</h6>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <div id="datos-respuesta-solicitud" align="left">

          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" onclick="window.location.reload()">Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->



  <div id="modalAdjuntarDocumento" class="modal fade">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Documento de Exhorto</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">

          <div id="divDucumento">
            <object data=""  id="documentoPDF" width="100%" height="350px" class="d-none mg-t-25"></object>
            <input type="hidden" id="bDoc">
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
{{--                   <button type="button" class="btn btn-secondary d-inline-block mg-r-auto" onclick="cambiarPantalla('modal')"  data-dismiss="modal">Cerrar</button>
--}}                  <button type="button" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="enviarPromocion()">Enviar Solicitud</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection
