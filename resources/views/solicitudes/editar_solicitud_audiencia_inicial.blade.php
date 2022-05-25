@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  use Illuminate\Support\Arr;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Permisos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Permisos del Menú</li>
  </ol>
  <h6 class="slim-pagetitle">Permisos del Menú</h6>
@endsection
@section('contenido-principal')
{{-- {{dd($solicitud)}} --}}
  <div class="section-wrapper mg-b-100">
    @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 4, 0))
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else
      <table class="mg-b-20 table-steps">
        <tr>
          <td class="td-step">
            <p class="step activo d-inline-block d-md-flex" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Datos de Solicitud de Audiencia</span></p>
          </td>
          <td class="td-step">
            <p class="step espera  d-inline-block d-md-flex" id="step-sujetos-procesales"><span class="num-step">2</span><span class="text-step d-none d-md-block">Sujetos Procesales</span></p>
          </td>
          <td class="td-step">
            <p class="step espera  d-inline-block d-md-flex" id="step-datos-fiscalia"><span class="num-step">3</span><span class="text-step d-none d-md-block">Datos de Fiscalía</span></p>
          </td>
        </tr>
      </table>
      <div class="form-layout">
        <div class="row mg-b-25 " id="datosSolicitudAudiencia">{{-- datos de solicitud de audiencia --}}
          <input type="hidden" value="{{$solicitud['ruta_base_xml']==null?'interfaz':'xml'}}" id="origen">
          <input type="hidden" value="{{$solicitud['id_carpeta_judicial']}}" id="carpeta_judicial">
          <input type="hidden" value="{{$solicitud['estatus_flujo_actual']}}" id="estatus_flujo">
          <div class="col-lg-3">
            <div class="form-group">
              <label class="form-control-label tx-justify">Folio de Solicitud de Aud: </label>
              <input class="form-control" type="text" name="folio_solicitud_audiencia" id="folioSolicitudAudiencia" placeholder="Folio de Solicitud de Audiencia" autocomplete="off" disabled>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-3">
            <div class="form-group">
              <label class="form-control-label">Fecha de la solicitud: </label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                  </div>
                  <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaSolicitud"  name="fecha_solicitud" autocomplete="off" disabled>
              </div>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Fenece a las:</label>
              <input class="form-control" type="text" name="fenece" id="fenece" value="" placeholder="N/E" autocomplete="off" disabled>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Carpeta Judicial:</label>
              <input class="form-control" type="text" name="carpeta_juidicial" id="carpetaJudicial" value="{{$solicitud['folio_carpeta']==null?'En Trámite':$solicitud['folio_carpeta']}}" placeholder="N/E" autocomplete="off" disabled>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label">Número de Carpeta de Investigación: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" name="numero_carpeta_investigacion" id="numeroCarpetaInvestigacion" value="{{$solicitud['carpeta_investigacion']}}"  placeholder="Número de Carpeta de Investigación" autocomplete="off">
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-3">
            <div class="form-group">
              <label class="form-control-label">Fecha de Recepción: <span class="tx-danger">*</span></label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                  </div>
                  <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="@php if($solicitud['fecha_recepcion']!=null){$fr=explode('-',$solicitud['fecha_recepcion']); echo $fr[2].'-'.$fr[1].'-'.$fr[0];} @endphp" id="fechaRecepcion" name="fecha_recepcion" autocomplete="off">
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
                  <input  type="text" class="form-control" id="horaRecepcion" name="hora_recepcion" placeholder="hh:mm" autocomplete="off" value="@php if($solicitud['hora_recepcion']!=null){ $hr=explode(':',$solicitud['hora_recepcion']); echo $hr[0].':'.$hr[1];} @endphp">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="form-group">
              <label class="form-control-label">Tipo de Audiencia: <span class="tx-danger">*</span></label>
              <select class="form-control select2-show-search valid" id="tipoAudiencia" name="tipo_audiencia" autocomplete="off">
                  <option selected disabled value="">Elija una opción</option>
                  @foreach ($tipos_audiencia as $tipo_audiencia)
                      @if ($solicitud['id_audiencia']==$tipo_audiencia['id_ta'])
                        <option value="{{$tipo_audiencia['id_ta']}}" data-duracion="{{$tipo_audiencia['promedio_duracion']}}" selected>{{$tipo_audiencia['tipo_audiencia']}}</option>
                      @else
                        <option value="{{$tipo_audiencia['id_ta']}}" data-duracion="{{$tipo_audiencia['promedio_duracion']}}">{{$tipo_audiencia['tipo_audiencia']}}</option>
                      @endif
                  @endforeach
              </select>
            </div>
          </div><!-- col-9 -->
          <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Duracion Aproximada:</label>
              <input class="form-control" type="text" name="duracion_aproximada" id="duracionAproximada" placeholder="Duración Aproximada" autocomplete="nope" disabled>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-6 mg-t-20">
            <div class="row">
              <div class="col-6">
                <label class="form-control-label">Urgente:</label>
              </div>
              <div class="col-6">
                <div class="toggle-wrapper" id="urgente" >
                  <div class="toggle toggle-light primary" data-status="{{$solicitud['estatus_urgente']}}"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mg-t-20">
            <div class="row">
              <div class="col-6">
                <label class="form-control-label">Requiere Telepresencia:</label>
              </div>
              <div class="col-6">
                <div class="toggle-wrapper" id="requiereTelepresencia">
                  <div class="toggle toggle-light primary"  data-status="{{$solicitud['estatus_telepresencia']}}"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mg-t-20">
            <div class="row">
              <div class="col-6">
                <label class="form-control-label">Requiere Área de Resguardo:</label>
              </div>
              <div class="col-6">
                <div class="toggle-wrapper" id="requiereResguardo" >
                  <div class="toggle toggle-light primary" data-status="{{$solicitud['estatus_area_resguardo']}}"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mg-t-20">
            <div class="row">
              <div class="col-6">
                <label class="form-control-label">Requiere Modalidad de Testigo Protegido:</label>
              </div>
              <div class="col-6">
                <div class="toggle-wrapper" id="requiereTestigoProtegido">
                  <div class="toggle toggle-light primary"  data-status="{{$solicitud['estatus_mod_testigo_protegido']}}"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mg-t-20">
            <div class="row">
              <div class="col-6">
                <label class="form-control-label">Requiere Mesa de Evidencia:</label>
              </div>
              <div class="col-6">
                <div class="toggle-wrapper" id="requiereMesa"  >
                  <div class="toggle toggle-light primary" data-status="{{$solicitud['estatus_mesa_evidencia']}}"></div>
                </div>
              </div>
            </div>
          </div>
          {{-- <div class="col-lg-6 mg-t-20">
            <div class="row">
              <div class="col-6">
                <label class="form-control-label">Turnar:</label>
              </div>
              <div class="col-6">
                <div class="toggle-wrapper" id="turnar">
                  <div class="toggle toggle-light primary"></div>
                </div>
              </div>
            </div>
          </div>  --}}
          <div class="col-lg-6 mg-t-20">
            <div class="row">
              <div class="col-6">
                <label class="form-control-label">¿Prisión Preventiva Oficiosa?: <small>(Sí= Delito grave (Reclusorio), No= Delito No Grave (Lavista)</small></label>
              </div>
              <div class="col-6">
                <div class="toggle-wrapper" id="priosionOficiosa" >
                  <div class="toggle toggle-light primary"  data-status="{{$solicitud['estatus_delito_grave']}}"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="form-control-label mg-t-20">Materia Destino: <span class="tx-danger">*</span></label>
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
        </div><!-- row -->{{-- </datos de solicitud de audiencia> --}}
        <div class="mg-b-25 d-none" id="sujetosProcesales">{{-- <sujetos procesales> --}}
          <div class="row">
            <input type="hidden" id="persona" value="-">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Calidad Jurídica: <span class="tx-danger">*</span></label>
                <select class="form-control " id="tipoParte" name="tipo_parte" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
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
                    @foreach ($nacionalidades as $nacionalidad)
                          <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option>
                    @endforeach
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
                <label class="form-control-label">Estado Civil: </label>
                <select class="form-control select2" id="estadoCivil" name="estado_civil" autocomplete="off">
                    <option selected   value="">Elija una opción</option>
                    @foreach ($estado_civil as $estado)
                        <option value="{{$estado['id_estado_civil']}}">{{$estado['estado_civil']}}</option>
                    @endforeach
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
                  <div id="datosAlias">{{-- lista de alias --}}

                  </div>
                </div>
              </div>
            </div>
          </div><!-- accordion -->
          <div id="accordionContacto" class="accordion-two mg-b-15" role="tablist" aria-multiselectable="true">
            <div class="card">
              <div class="card-header" role="tab" id="headingContacto">
                <a data-toggle="collapse" data-parent="#accordionContacto" href="#collapseContacto" aria-expanded="false" aria-controls="collapseContacto" class="tx-gray-800 transition collapsed">
                  Agregar Datos de Contacto
                </a>
              </div><!-- card-header -->
              <div id="collapseContacto" class="collapse" role="tabpanel" aria-labelledby="headingContacto">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10 mg-t-15" id="agregarDomicilio">Agregar Domicilio <i class="fa fa-plus"></i></button>
                      <div id="domicilios" class="mg-b-15">
                      </div>
                    </div>
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
          <div id="accordionDatosAdicionales" class="accordion-two" role="tablist" aria-multiselectable="true">
            <div class="card">
              <div class="card-header" role="tab" id="headingDatosAdicionales">
                <a data-toggle="collapse" data-parent="#accordionDatosAdicionales" href="#collapseDatosAdicionales" aria-expanded="false" aria-controls="collapseContacto" class="tx-gray-800 transition collapsed">
                  Datos Adicionales
                </a>
              </div><!-- card-header -->
              <div id="collapseDatosAdicionales" class="collapse" role="tabpanel" aria-labelledby="headingDatosAdicionales">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Ocupación: </label>
                        <select class="form-control" id="ocupacion" name="ocupacion" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($ocupaciones as $ocupacion)
                                <option value="{{$ocupacion['id_ocupacion']}}" data-clave="{{$ocupacion['clave_ocupacion']}}">{{$ocupacion['nombre_ocupacion']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otra Ocuapación:</label>
                        <input class="form-control" type="text" name="otra_ocupacion" id="otra_ocupacion" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Escolaridad: </label>
                        <select class="form-control" id="escolaridad" name="escolaridad" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($escolaridades as $escolaridad)
                                <option value="{{$escolaridad['id_escolaridad']}}">{{$escolaridad['nivel_escolaridad']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otra Escolaridad:</label>
                        <input class="form-control" type="text" name="otra_escolaridad" id="otra_escolaridad" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Religión: </label>
                        <select class="form-control" id="religion" name="religion" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($religiones as $religion)
                                <option value="{{$religion['id_religion']}}">{{$religion['nombre_religion']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otra Religión:</label>
                        <input class="form-control" type="text" name="otra_religion" id="otra_religion" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Grupo Étnico: </label>
                        <select class="form-control" id="grupo_etnico" name="grupo_etnico" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($grupos_etnicos as $grupo_etnico)
                                <option value="{{$grupo_etnico['id_grupo_etnico']}}">{{$grupo_etnico['grupo_etnico']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otro Grupo Étnico:</label>
                        <input class="form-control" type="text" name="otro_grupo_etnico" id="otro_grupo_etnico" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Capacidad Diferente: </label>
                        <select class="form-control" id="capacidades_diferentes" name="capacidades_diferentes" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Discapacidad:</label>
                        <input class="form-control" type="text" name="discapacidad" id="discapacidad" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Lengua: </label>
                        <select class="form-control" id="lengua" name="lengua" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($lenguas as $lengua)
                                <option value="{{$lengua['id_lengua']}}">{{$lengua['lengua']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Sabe Leer y Escribir?: </label>
                        <select class="form-control" id="sabe_leer_escribir" name="sabe_leer_escribir" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Entiende el Idioma Español?: </label>
                        <select class="form-control" id="entiende_idioma_espanol" name="entiende_idioma_espanol" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Población Callejera?: </label>
                        <select class="form-control" id="poblacion_callejera" name="poblacion_callejera" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Poblacion LGBTTTI: </label>
                        <select class="form-control" id="poblacion" name="poblacion" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            @foreach ($poblaciones_lgbttti as $poblacion_lgbttti)
                                <option value="{{$poblacion_lgbttti['id_lgbttti']}}">{{$poblacion_lgbttti['nombre_poblacion']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otra Población:</label>
                        <input class="form-control" type="text" name="otra_poblacion" id="otra_poblacion" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3 fisica">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Nombre Población:</label>
                        <input class="form-control inpur-number" type="text" name="nombre_poblacion" id="nombre_poblacion" autocomplete="off">
                      </div>
                    </div><!-- col-4-->
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Requiere Traducto?: </label>
                        <select class="form-control" id="requiere_traductor" name="requiere_traductor" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Idioma del Traductor: </label>
                        <select class="form-control" id="idioma_traductor" name="idioma_traductor" autocomplete="off" disabled>
                            <option selected   value="">Elija una opción</option>
                            @foreach ($idiomas as $idioma)
                                <option value="{{$idioma['id_idioma']}}">{{$idioma['idioma']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Otro Idioma del Traductor:</label>
                        <input class="form-control" type="text" name="otro_idioma_traductor" id="otro_idioma_traductor" autocomplete="off" disabled>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">¿Requiere Intérprete?: </label>
                        <select class="form-control" id="requiere_interprete" name="requiere_interprete" autocomplete="off">
                            <option selected   value="">Elija una opción</option>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Tipo de Intérprete:</label>
                        <input class="form-control" type="text" name="tipo_interprete" id="tipo_interprete" autocomplete="off" disabled>
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
              @if ($solicitud['ruta_base_xml']!=null)
                <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10" onclick="verDelitosNR()">Ver Delitos No Relacionados</button>
              @endif
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
        <div class="row mg-b-25 d-none" id="datosFiscalia">
          <div class="col-lg-12">
            <div class="form-group">
              <label class="form-control-label">Fiscalía: <span class="tx-danger">*</span></label>
              <select class="form-control select2" id="fiscalia" name="fiscalia" autocomplete="off">
                  <option selected disabled  value="">Elija una opción</option>
                  @foreach ($fiscalias as $fiscalia)
                    @if($fiscalia['id_fiscalia']==$solicitud['id_fiscalia'])
                      <option value="{{$fiscalia['id_fiscalia']}}" selected>{{$fiscalia['fiscalia']}}</option>
                    @else
                      <option value="{{$fiscalia['id_fiscalia']}}">{{$fiscalia['fiscalia']}}</option>
                    @endif
                  @endforeach
              </select>
            </div>
          </div><!-- col-4-->
          <div class="col-lg-4">
            <div class="form-group">
              <label class="form-control-label">Agencia: <span class="tx-danger">*</span></label>
              <select class="form-control select2" id="agencia" name="agencia" autocomplete="off">
                  <option selected value="">Elija una opción</option>
              </select>
            </div>
          </div><!-- col-4-->
          <div class="col-lg-4">
            <div class="form-group">
              <label class="form-control-label">Unidad de Investigación:</label>
              <select class="form-control select2" id="unidadInvestigacion" name="unidad_investigacion" autocomplete="off">
                  <option value="">Elija una opción</option>
                  @foreach ($unidades_investigacion as $unidad)
                    @if($solicitud['unidad_id_fis']==$unidad['id_unidad_inv'])
                      <option selected value="{{$unidad['id_unidad_inv']}}">{{$unidad['unidad_investigacion']}}</option>
                    @else
                      <option value="{{$unidad['id_unidad_inv']}}">{{$unidad['unidad_investigacion']}}</option>
                    @endif

                  @endforeach
              </select>
            </div>
          </div><!-- col-4-->
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Coordinación Territorial:</label>
              <input class="form-control" type="text" name="coordinacion_territorial" id="coordinacionTerritorial" autocomplete="off"  value="{{$solicitud['cordinacion_territorial']}}">
            </div>
          </div><!-- col-4-->
          <div class="col-12">
            <h5>Datos del Fiscal</h5>
          </div>
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Nombre(s): <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" name="nombre_fiscal" id="nombreFiscal" autocomplete="off" value="{{$solicitud['mp_solicitante']}}">
            </div>
          </div><!-- col-4 -->
          {{-- <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" name="apellido_paterno_fiscal" id="apellidoPaternoFiscal" autocomplete="off">
            </div>
          </div><!-- col-4 -->
          <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Apellido Materno:</label>
              <input class="form-control" type="text" name="apellido_materno_fiscal" id="apellidoMaternoFiscal" autocomplete="off">
            </div>
          </div><!-- col-4 --> --}}
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">CURP:</label>
              <input class="form-control" type="text" name="curp_fiscal" id="curpFiscal" autocomplete="off" value="{{$solicitud['curp_mp']}}">
            </div>
          </div><!-- col-4 -->
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Correo Electrónico:</label>
              <input class="form-control correo_electronico_fiscal" type="text" name="correo_electronico_fiscal" id="correoFiscal" autocomplete="off"  value="{{$solicitud['correo_mp']}}">
            </div>
          </div><!-- col-4 -->
        </div>
        <div class="form-layout-footer d-flex">
          <button class="btn btn-secondary bd-0 d-inline-block" id="atras" disabled>Atrás</button>
          <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="siguiente">Siguiente</button>
        </div><!-- form-layout-footer -->
      </div>
    @endif
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

    div#domicilios .row:nth-child(2n){
      background: #FDFDFD !important;
    }

    #domicilios .row{
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
    table.tableDatosSujeto  td, table.tableDatosSujeto th{
      border: 1px solid #EEE;
      vertical-align: text-top;
      padding: 5px;
    }

    table.tableDatosSujeto2  td, table.tableDatosSujeto2 th{
      border: 1px solid #EEE;
      vertical-align: text-top;
      padding: 5px;
      width: 33%;
    }

    .elimina-delito{
      width: 40px !important;
      text-align: center;
      vertical-align: middle !important;
    }

    table.tableDatosSujeto tbody.table-datos-sujeto tr td:nth-child(2n-1){
      background-color: #f8f9fa;
    }
    table.tableDatosSujeto tbody.table-datos-sujeto tr td{
      width: 25%;
    }

    table.tableDatosSujeto2 thead tr:first-child{
      background-color: #f8f9fa;
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
      #duracionAproximada{
        background: #FFF;
      }
      .delito-s{
        min-width: 180px !important;
        padding: 10px;
      }
      .modalidad{
        min-width: 180px !important;
        padding: 10px;
      }
      .calificativo{
        min-width: 180px !important;
        padding: 10px;
      }
      .grado-realizacion{
        min-width: 180px !important;
        padding: 10px;
      }
      .imputable-a{
        min-width: 180px !important;
        padding: 10px;
      }
      .seleccion-delito{
        min-width: 40px !important;
        font-size: 24px;
        padding: 10px;
      }

    @media only screen and (max-width: 1199px) {
      table.tableDatosSujeto td{
        width: auto;
      }
      table#tableDatosSujeto2 td{
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
  <script src="../lib/jquery-ui/js/jquery-ui.js"></script>
  <script type="text/javascript" src="{{asset('/js/dropzone.min.js')}}"></script>
@endsection
@section('seccion-scripts-functions')
  <script>
    duracionAproximada();
    obtenerAgencias(@php echo $solicitud['id_fiscalia']@endphp,@php echo $solicitud['id_agencia_inv']@endphp);
    let step=1,
        arrSujetosProcesales=[];

    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
          expVacio=/^[\s]*$/,
          expRFC=/^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/,
          arrDelitosNR=[],
          sujetosGuardados=@php echo json_encode($solicitud['personas'])@endphp,
          delitosNR=@php echo json_encode($solicitud['delitos_sin_relacionar'])@endphp,
          catalogoDelitos=@php echo json_encode($delitos['response'])@endphp,
          catalogoEstados=@php echo json_encode($estados['response'])@endphp;

          console.log(sujetosGuardados);

    $(()=>{

      $(delitosNR).each(function(index, delito){
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
      });

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

          const {id_persona_delito,estatus,id_delito, id_modalidad, modalidad ,id_calificativo,calificativo, grado_realizacion, delito_grave, nombre_modalidad} = delitoSujeto;
          const textDelito=catalogoDelitos.filter(cDelito=>cDelito.id_delito==id_delito);
          const datosDelito={
                  "estatus":"1",
                  "id":id_persona_delito,
                  "id_delito":id_delito,
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

        $(direcciones).each(function(index, direccion){
          const {calle,no_exterior,no_interior, colonia, codigo_postal,entidad_federativa,id_municipio, localidad, entre_calles,referencias, cve_PGJ, estado, municipio, id_direccion_persona, estatus,cve_estado}=direccion;

          const datosDireccion={
            "id":id_direccion_persona,
            "estatus":"1",
            "calle":calle==null?'':calle,
            "numero_exterior":no_exterior==null?'':no_exterior,
            "numero_interior":no_interior==null?'':no_interior,
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

    setTimeout(function(){
        $('#modal_loading').modal('hide');
    }, 2000);

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
      // $('.toggle').toggles({
        // on: false,
        // height: 26
      // });

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

    $(function(){
      $('.toggle').each(function(){
        if($(this).attr('data-status')=='si'){
          $(this).toggles({on: true,height: 26});
        }else{
          $(this).toggles({on: false,height: 26});
        }
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
      duracionAproximada();
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
        let nArrSujetosProcesales;

        nArrSujetosProcesales=arrSujetosProcesales.map((sujeto, index)=>{
          if(sujeto.id!='-'){
            if(sujetosSeleccionados.some(indexSeleccionado=>indexSeleccionado==index)){
              sujeto.estatus="0";
            }
            return sujeto;
          }
        });

        arrSujetosProcesales=nArrSujetosProcesales.filter(sujeto=>{
          if(sujeto!=undefined){
            return sujeto;
          }
        });

        console.log(arrSujetosProcesales);
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

    $('#fiscalia').change(function(){
      obtenerAgencias($(this).val());
    });

    $('#agregarAlias').click(function(){
      $('#datosAlias').append(`<div class="row datos-alias" data-status="1">
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
      if($(this).parent().parent().parent().attr('data-id')){
        $(this).parent().parent().parent().attr('data-status','0');
        $(this).parent().parent().parent().addClass('d-none');
      }else{
        $(this).parent().parent().parent().remove();
      }
    });

    $('#domicilios').on('change','.estado',function(){
      const selectMunicipio=$(this).parent().parent().parent().find('.municipio');
      const estado=$(this).find('option:selected').attr('data-cve-estado');
      $.ajax({
        type:'POST',
        url:'/public/obtener_municipios',
        data:{
          estado,
        },
        success:function(response){
          if(response.status==100){
            let municipios='<option disabled selected>Elija una opción</option>';
            $(response.response).each(function(index, datosMunicipio){
              const {id_municipio, municipio}=datosMunicipio;
              const option=`<option value="${id_municipio}">${municipio}</option>`;
              municipios=municipios.concat(option);
            });
            selectMunicipio.html(municipios);
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

    $('#headingDatosAdicionales').click(function(){

      $('#escolaridad').select2({minimumResultsForSearch: Infinity});
      $('#sabe_leer_escribir').select2({minimumResultsForSearch: Infinity});
      $('#entiende_idioma_espanol').select2({minimumResultsForSearch: Infinity});
      $('#poblacion_callejera').select2({minimumResultsForSearch: Infinity});
      $('#requiere_interprete').select2({minimumResultsForSearch: Infinity});
      $('#requiere_traductor').select2({minimumResultsForSearch: Infinity});
      $('#ocupacion').select2({minimumResultsForSearch: ''});
      $('#religion').select2({minimumResultsForSearch: ''});
      $('#grupo_etnico').select2({minimumResultsForSearch: ''});
      $('#lengua').select2({minimumResultsForSearch: ''});
      $('#poblacion').select2({minimumResultsForSearch: ''});
      $('#idioma_traductor').select2({minimumResultsForSearch: ''});


    });

    $('#agregarCorreo').click(function(){
      $('#correos').append(`<div class="row datos-correo" data-status="1">
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

    $('#agregarDomicilio').click(function(){
      $('#domicilios').append(`<div class="row datos-domicilio" data-status="1">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-domicilio"></i></p>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label class="form-control-label">Estado: </label>
                                    <select class="form-control estado" name="estado" autocomplete="off">
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
                                    <select class="form-control municipio" name="municipio" autocomplete="off">

                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Localidad:</label>
                                    <input class="form-control localidad" type="text" name="localidad"  autocomplete="off">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Calle:</label>
                                    <input class="form-control calle" type="text" name="calle" autocomplete="off">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Número Exterior:</label>
                                    <input class="form-control numeroExterior" type="text" name="numero_exterior" autocomplete="off">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Número Interior:</label>
                                    <input class="form-control numero_interior" type="text" name="numero_interior"  autocomplete="off">
                                  </div>
                                </div><!-- col-4-->
                                <div class="col-lg-9">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Colonia:</label>
                                    <input class="form-control colonia" type="text" name="colonia"  autocomplete="off">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Código Postal:</label>
                                    <input class="form-control codigoPostal" type="text" name="codigo_postal" autocomplete="off">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-8">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Entre la Calle:</label>
                                    <input class="form-control entreCalle" type="text" name="entre_calle" autocomplete="off">
                                  </div>
                                </div><!-- col-4-->
                                <div class="col-lg-12">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Otras Referencias:</label>
                                    <input class="form-control otrasReferencias" type="text" name="otras_referencias" autocomplete="off">
                                  </div>
                                </div><!-- col-4-->
                              </div>`);
      $('.estado').select2({minimumResultsForSearch: ''});
      $('.municipio').select2({minimumResultsForSearch: ''});
    });

    $('#correos').on('click','.borrar-correo',function(){
      if($(this).parent().parent().parent().attr('data-id')){
        $(this).parent().parent().parent().attr('data-status','0');
        $(this).parent().parent().parent().addClass('d-none');
      }else{
        $(this).parent().parent().parent().remove();
      }

    });

    $('#telefonos').on('click','.borrar-telefono',function(){
      if($(this).parent().parent().parent().attr('data-id')){
        $(this).parent().parent().parent().attr('data-status','0');
        $(this).parent().parent().parent().addClass('d-none');
      }else{
        $(this).parent().parent().parent().remove();
      }
    });

    $('#domicilios').on('click','.borrar-domicilio',function(){
      if($(this).parent().parent().parent().attr('data-id')){
        $(this).parent().parent().parent().attr('data-status','0');
        $(this).parent().parent().parent().addClass('d-none');
      }else{
        $(this).parent().parent().parent().remove();
      }
    });

    $('#agregarTelefono').click(function(){
      $('#telefonos').append(`<div class="row datos-telefono" data-status="1">
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

    $("#archivoPDF").on('input',function () {
        leeDocumento(this);
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

    $('#ocupacion').change(function(){
      if($(this).val()==4){
        $('#otra_ocupacion').removeAttr('disabled');
      }else{
        $('#otra_ocupacion').val('').attr('disabled', true);
      }
    });

    $('#escolaridad').change(function(){
      if($(this).val()==7){
        $('#otra_escolaridad').removeAttr('disabled');
      }else{
        $('#otra_escolaridad').val('').attr('disabled', true);
      }
    });

    $('#religion').change(function(){
      if($(this).val()==18){
        $('#otra_religion').removeAttr('disabled');
      }else{
        $('#otra_religion').val('').attr('disabled', true);
      }
    });

    $('#grupo_etnico').change(function(){
      if($(this).val()==777){
        $('#otro_grupo_etnico').removeAttr('disabled');
      }else{
        $('#otro_grupo_etnico').val('').attr('disabled', true);
      }
    });

    $('#poblacion').change(function(){
      if($(this).val()==8){
        $('#otra_poblacion').removeAttr('disabled');
      }else{
        $('#otra_poblacion').val('').attr('disabled', true);
      }
    });

    $('#requiere_traductor').change(function(){
      if($(this).val()=='si'){
        $('#idioma_traductor').removeAttr('disabled');
      }else{
        $('#idioma_traductor').val('').attr('disabled', true);
        $('#idioma_traductor').select2({minimumResultsForSearch: ''});
        $('#otro_idioma_traductor').val('').attr('disabled', true);
      }
    });

    $('#idioma_traductor').change(function(){
      if($(this).val()==208){
        $('#otro_idioma_traductor').removeAttr('disabled');
      }else{
        $('#otro_idioma_traductor').val('').attr('disabled', true);
      }
    });

    $('#capacidad_diferente').change(function(){
      if($(this).val()=='si'){
        $('#discapacidad').removeAttr('disabled');
      }else{
        $('#discapacidad').val('').attr('disabled', true);
      }
    });

    function verDelitosNR(){
      $('#titleSujeto').html('Delitos Sin Relacionar');
      $('#modalDatosSujeto').modal('show');
      $('#divDatosSujeto').html('');
      const tableHead= `<thead style="background-color: #EBEEF1; color="#000">
                          <tr>
                            <th class="seleccion-delito"><th>
                            <th class="imputable-a">Imputable a:</th>
                            <th class="delito-s">Delito</th>
                            <th class="modalidad">Modalidal de Delito</th>
                            <th class="calificativo">Calificativo</th>
                            <th class="grado-realizacion">Grado de Realización</th>
                          </tr>
                        </thead>`;
      let listaDelitos='';
      const delitos=arrDelitosNR;

      $(delitos).each(function(index, datosDelito){
        if(datosDelito.estatus==1){
          const {delito_text, modalidad_text, calificativo_text, grado_realizacion_text, imputable_a} = datosDelito;
          listaImputableA='';
          $(imputable_a).each(function(index, li){
            listaImputableA=listaImputableA.concat(li+"<br>");
          });

          tr=`<tr data-delito=${index}>
                <th class="seleccion-delito"><i class="icon ion-person-add" data-toggle="tooltip" data-placement="i" title="Relacionar Delito a Imputados" onclick="relacionarDelito(${index},'${delito_text}')"></i><th>
                  <td class="imputable-a">${listaImputableA}</td>
                <td class="delito-s">${delito_text}</td>
                <td class="modalidad">${modalidad_text}</td>
                <td class="tx-uppercase calificativo">${calificativo_text==null?'':calificativo_text}</td>
                <td class="grado-realizacion">${grado_realizacion_text}</td>
              </tr>
          `;
          listaDelitos=listaDelitos.concat(tr);
        }
      });

      $('#divDatosSujeto').html(`<table style="overflow-x:scroll; display:block; border: 1px solid #EEE" class="datatable">${tableHead}<tbody class="datos-delitos-sujeto">${listaDelitos}</tbody></table>`);
      $('#divEditarDelito').html(``).css({"margin-left": "0"});
    }

    function relacionarDelito(delito, delito_text){

      const imputados=arrSujetosProcesales.filter(persona=>{
        if(persona.tipo_parte==46){
          return persona;
        }
      });
      let listaImputados='';
      $(imputados).each(function(index, imputado){
        const {nombre, apellido_paterno, apellido_materno,razon_social, id}=imputado;
        let checked='';
        if(arrDelitosNR[delito].id_imputable_a.some(persona=>persona==id)){
          checked='checked';
        }
        opcion=`<label class="ckbox">
                  <input type="checkbox" class="sujeto-seleccion" value="${id}" data-persona="${razon_social}${nombre} ${apellido_paterno} ${apellido_materno}" ${checked}><span>${razon_social}${nombre} ${apellido_paterno} ${apellido_materno}</span>
                </label>`
        listaImputados=listaImputados.concat(opcion);
      });

      $('#titleDelito').html(delito_text);
      $('#guardarRelacion').attr('onclick', `guardaRelacion(${delito})`);
      $('#opcionesImputados').html(listaImputados);
      $('#modalRelacionarDelito').modal('show');
      $('#modalDatosSujeto').modal('hide');
    }

    function guardaRelacion(delito){

      const imputable_a=[],
            id_imputable_a=[];

      if($('input[class=sujeto-seleccion]:checked').length){
        $('input[class=sujeto-seleccion]:checked').each(function(){
            imputable_a.push($(this).attr('data-persona'));
            id_imputable_a.push($(this).val());
        });
      }
      arrDelitosNR[delito].imputable_a=imputable_a;
      arrDelitosNR[delito].id_imputable_a=id_imputable_a;
      $('#modalRelacionarDelito').modal('hide');
      console.log(arrDelitosNR);
      verDelitosNR();
    }

    function obtenerAgencias(id_fiscalia, id_agencia=''){

      $.ajax({
        type:'POST',
        url:'/public/obtener_agencias',
        data:{
          fiscalia:id_fiscalia,
        },
        success:function(response){

          if(response.status==100){

            let agencias='<option disabled value>Elija una opcion</option>';

            $(response.response).each((index, agencia)=>{

              const {id_agencia_inv, agencia_investigacion}=agencia;

              if(id_agencia_inv==id_agencia){
                const option=`<option value="${id_agencia_inv}" selected>${agencia_investigacion}</option>`;
                agencias=agencias.concat(option);
              }else{
                const option=`<option value="${id_agencia_inv}">${agencia_investigacion}</option>`;
                agencias=agencias.concat(option);
              }
            });
            $('#agencia').html(agencias);
          }
        }
      });
    }

    function duracionAproximada(){
      const duracion=$('#tipoAudiencia').find('option:selected').attr('data-duracion');
      if(duracion!=undefined)$('#duracionAproximada').val(duracion+' minutos');
    }

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

      if(arrSujetosProcesales.some(sujeto=>!sujeto.delitos.length && sujeto.tipo_parte==46 && sujeto.origen=='interfaz'))return {'estatus':0,'campo':'-','error':'Hay imputados sin delitos agregados'};

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
          mostrarDatosFiscalia();
          break;
        case 4:
          mostrarModalDocumento();
          break;
      }

    }

    function validaDatosFiscalia(){
      if($('#fiscalia').val()==null) return {'estatus':0,'campo':'fiscalia','error':'No ha seleccionado la ficalia'};

      if($('#agencia').val()==null) return {'estatus':0,'campo':'agencia','error':'No ha seleccionado la agencia'};

      if(expVacio.test($('#nombreFiscal').val())) return {'estatus':0,'campo':'nombreFiscal','error':'Falta el nombre del fiscal'};

      return 100;
    }

    function validaDatosSolicitud(){

      if(!expRegFecha.test($('#fechaRecepcion').val())) return {'estatus':0,'campo':'fechaRecepcion','error':'Falta fecha de recepción o el formato es inválido'};

      if(!expRegHora.test($('#horaRecepcion').val())) return {'estatus':0,'campo':'horaRecepcion','error':'Falta la hora de recepción o el formato es inválido'};

      if(expVacio.test($('#numeroCarpetaInvestigacion').val())) return {'estatus':0,'campo':'numeroCarpetaInvestigacion','error':'Falta el número de carpeta de investigación'};

      if($('#tipoAudiencia').val()==null) return {'estatus':0,'campo':'tipoAudiencia','error':'No ha seleccionado el tipo de audiencia'};

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
        if(!expRFC.test($('#rfc').val())) return {'estatus':0,'campo':'rfc','error':'Falta el formato del RFC es inválido'};
      }

      return 100;
    }

    function mostrarDatosSolicitud(){
      $('#step-datos-solicitud').addClass('activo').removeClass('resuelto espera');
      $('#step-sujetos-procesales').addClass('espera').removeClass('activo resuelto');
      $('#datosSolicitudAudiencia').removeClass('d-none');
      $('#sujetosProcesales').addClass('d-none');
      $('#atras').attr('disabled', true);
      if($('#tipoAudiencia').hasClass('select2-hidden-accessible')){
        $('#tipoAudiencia').select2('destroy');
      }
      setTimeout(()=>{
        $('#tipoAudiencia').select2({minimumResultsForSearch: ''});
      },150);

    }

    function mostrarSujetosProcesales(){
      $('#step-datos-solicitud').addClass('resuelto').removeClass('espera activo');
      $('#step-sujetos-procesales').addClass('activo').removeClass('resuelto espera');
      $('#step-datos-fiscalia').addClass('espera').removeClass('resuelto activo');
      $('#datosSolicitudAudiencia').addClass('d-none');
      $('#datosFiscalia').addClass('d-none');
      $('#sujetosProcesales').removeClass('d-none');
      $('#atras').removeAttr('disabled');


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

    function mostrarDatosFiscalia(){
      $('#step-datos-solicitud').addClass('resuelto').removeClass('espera activo');
      $('#step-sujetos-procesales').addClass('resuelto').removeClass('espera activo');
      $('#step-datos-fiscalia').addClass('activo').removeClass('resuelto espera');
      $('#datosSolicitudAudiencia').addClass('d-none');
      $('#sujetosProcesales').addClass('d-none');
      $('#datosFiscalia').removeClass('d-none');
      $('#atras').removeAttr('disabled');

      if($('#fiscalia').hasClass('select2-hidden-accessible')){
        $('#fiscalia').select2('destroy');
      }
      if($('#unidadInvestigacion').hasClass('select2-hidden-accessible')){
        $('#unidadInvestigacion').select2('destroy');
      }
      setTimeout(()=>{
        $('#fiscalia').select2({minimumResultsForSearch: ''});
        $('#unidadInvestigacion').select2({minimumResultsForSearch: ''});
      },150);

      $('#agencia').select2({minimumResultsForSearch: Infinity});


    }

    function agregarSujetoProcesal(){
      const arrAlias=[],
            arrCorreos=[],
            arrTelefonos=[],
            arrDirecciones=[],
            arrDelitos=[],
            arrDatos=[];



      $('.datos-alias').each(function(){
        datosAlias={
          id:"-",
          estatus:"1",
          alias:$(this).find('.alias').val(),
        }
        arrAlias.push(datosAlias);
      });

      $('.datos-correo').each(function(){
        datosCorreo={
          id:"-",
          estatus:"1",
          correo:$(this).find('.correo-electronico').val(),
        }
        arrCorreos.push(datosCorreo);
      });

      $('.datos-telefono').each(function(){
        datosTelefono={
          id:"-",
          estatus:"1",
          tipo:$(this).find('.tipo-telefono').val(),
          numero:$(this).find('.numero-telefono').val(),
          extension:$(this).find('.extension').val(),
        }
        arrTelefonos.push(datosTelefono);
      });

      $('.datos-domicilio').each(function(){
        const datosDireccion={
          "id":$(this).attr('data-id'),
          "estatus":$(this).attr('data-status'),
          "calle":$(this).find('.calle').val(),
          "numero_exterior":$(this).find('.numeroExterior').val(),
          "numero_interior":$(this).find('.numero_interior').val(),
          "colonia":$(this).find('.colonia').val(),
          "codigo_postal":$(this).find('.codigoPostal').val(),
          "estado":$(this).find('.estado').val(),
          "estado_text":$(this).find('.estado').val()==''?'':$(this).find('.estado').find('option:selected').text(),
          "cve_estado":$(this).find('.estado').find('option:selected').attr('data-cve-estado'),
          "municipio":$(this).find('.municipio').val(),
          "municipio_text":$(this).find('.municipio').val()==''?'':$(this).find('.municipio').find('option:selected').text(),
          "localidad":$(this).find('.localidad').val(),
          "entre_calle":$(this).find('.entreCalle').val(),
          "otra_referencia":$(this).find('.otrasReferencias').val(),
        };

        arrDirecciones.push(datosDireccion);
      });

      const datosAdicionales={
        id_datos_persona:"",
        estatus:"",
        id_nivel_escolaridad:$('#escolaridad').val(),
        id_escolaridad:$('#escolaridad').val(),
        nivel_escolaridad:$('#escolaridad').val()==''?'':$('#escolaridad').find('option:selected').text(),
        otra_escolaridad:$('#otra_escolaridad').val(),
        id_lengua:$('#lengua').val(),
        lengua:$('#lengual').val()==''?'':$('#lengual').find('option:selected').text(),
        id_religion:$('#religion').val(),
        nombre_religion:$('#religion').val()==''?'':$('#religion').find('option:selected').text(),
        otra_religion:$('#otra_religion').val(),
        id_lgbttti:$('#poblacion').val(),
        nombre_poblacion:$('#poblacion').val()==''?'':$('#poblacion').find('option:selected').text(),
        id_grupo_etnico:$('#grupo_etnico').val(),
        grupo_etnico:$('#grupo_etnico').val()==''?'':$('#grupo_etnico').find('option:selected').text(),
        otro_grupo_etnico:$('#otro_grupo_etnico').val(),
        tipo_ocupacion:$('#ocupacion').val(),
        ocupacion:$('#ocupacion').val()==''?'':$('#ocupacion').find('option:selected').text(),
        otra_ocupacion:$('#otra_ocupacion').val(),
        requiere_traductor:$('#requiere_traductor').val(),
        idioma_traductor:$('#idioma_traductor').val(),
        otro_idioma_traductor:$('#otro_idioma_traductor').val(),
        requiere_interprete:$('#requiere_interprete').val(),
        tipo_interprete:$('#tipo_interprete').val(),
        capacidades_diferentes:$('#capacidades_diferentes').val(),
        capacidad_diferente:"",
        poblacion:$('#poblacion').val(),
        otra_poblacion:$('#otra_poblacion').val(),
        pertenece_grupo_etnico:$('#grupo_etnico').val()==''?'si':'no',
        entiende_idioma_espanol:$('#entiende_idioma_espanol').val(),
        descripcion_discapacidad:"",
        sabe_leer_escribir:$('#sabe_leer_escribir').val(),
        poblacion_callejera:$('#poblacion_callejera').val(),
        estatus:"1",
      };

      arrDatos.push(datosAdicionales);

      const sujetoProcesal={
        "id":"-",
        "estatus":"1",
        "origen":"interfaz",
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
        "alias":arrAlias,
        "correos":arrCorreos,
        "telefonos":arrTelefonos,
        "datos":arrDatos,
        "direcciones":arrDirecciones,
        "delitos":arrDelitos,
      };
      arrSujetosProcesales.push(sujetoProcesal);

      muestraSujetosProcesales();

    }

    function muestraSujetosProcesales(){

      let tableSujetosProcesales='';
      $(arrSujetosProcesales).each(function(index, datosSujeto){
        if(datosSujeto.estatus==1){
          const {id,tipo_parte,tipo_parte_text, nombre, apellido_paterno, apellido_materno,  razon_social, genero, genero_text, delitos} = datosSujeto;
          let listaDelitos='';
          $(delitos).each(function(index, delito){
            if(delito.estatus==1){
              li=`${delito.delito_text}<br>`;
              listaDelitos=listaDelitos.concat(li);
            }
          });
          const verDelitos=tipo_parte==46?`<a href="javascript:void(0)" onclick="verDelitos(${index})"  data-toggle="tooltip" data-placement="a" title="Ver Delitos"><i class="icon ion-clipboard"></i></a>`:'';
          const sujeto= `<tr>
                          <td class="seleccion">
                            <label class="ckbox">
                              <input type="checkbox" class="sujeto-seleccion" value="${index}" data-persona="${id}"><span></span>
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
        }
      });
      $('#tableSujetosProcesales').html(tableSujetosProcesales);

    }

    function verDelitos(indexSujeto){

      muestraDelitosSujeto(indexSujeto);

      $('#titleSujeto').html('Delitos del Sujeto Procesal');
      $('#modalDatosSujeto').modal('show');
    }

    function muestraDelitosSujeto(indexSujeto){
      $('#divDatosSujeto').html('');
      const tableHead= `<thead style="background-color: #EBEEF1; color="#000">
                          <tr>
                            <th class="elimina-delito"></th>
                            <th class="delito-s">Delito</th>
                            <th class="modalidad">Modalidal de Delito</th>
                            <th class="calificativo">Calificativo</th>
                            <th class="grado-realizacion">Grado de Realización</th>
                          </tr>
                        </thead>`;
      let listaDelitos='';
      const delitos=arrSujetosProcesales[indexSujeto].delitos;

      $(delitos).each(function(index, datosDelito){
        if(datosDelito.estatus==1){
          const {id_persona_delito,delito_text, modalidad_text, calificativo_text, grado_realizacion_text} = datosDelito;
            tr=`<tr data-delito=${index}>
                  <td class="elimina-delito">
                    <i class="icon ion-close tx-danger borrar-delito" data-id="" data-toggle="tooltip" data-placement="bottom" title="Quitar Delito" onclick="eliminaDelito(${indexSujeto},${index},${id_persona_delito})"></i>
                  </td>
                  <td class="delito-s">${delito_text}</td>
                  <td class="modalidad">${modalidad_text}</td>
                  <td class="tx-uppercase calificativo">${calificativo_text}</td>
                  <td class="grado-realizacion">${grado_realizacion_text}</td>
                </tr>
            `;
          listaDelitos=listaDelitos.concat(tr);
        }
      });

      $('#divDatosSujeto').html(`<table style="overflow-x:scroll; display:block; border: 1px solid #EEE" class="datatable">${tableHead}<tbody class="datos-delitos-sujeto">${listaDelitos}</tbody></table>`);
      $('#divEditarDelito').html(``).css({"margin-left": "0"});
    }

    function eliminaDelito(indexSujeto, indexDelito){
      let nArrSujetosProcesales;

      if(arrSujetosProcesales[indexSujeto].delitos[indexDelito].id==""){
        nArrSujetosProcesales = arrSujetosProcesales.map((sujeto, indexS)=>{
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
      }else{
        nArrSujetosProcesales = arrSujetosProcesales.map((sujeto, indexS)=>{
          if(indexSujeto==indexS){

            const nDElitos=sujeto.delitos.map((delito, indexD)=>{
              if(indexDelito==indexD){
                delito.estatus="0";
              }
              return delito;
            });
            sujeto.delitos=nDElitos;
          }
          return sujeto;
        });
      }


      arrSujetosProcesales=nArrSujetosProcesales;
      muestraDelitosSujeto(indexSujeto);
      muestraSujetosProcesales()
    }

    function verSujeto(index){

      const {tipo_parte_text, nacionalidad, nacionalidad_text, curp, rfc, cedula_profesional, nombre, apellido_paterno, apellido_materno, razon_social, genero, genero_text, fecha_nacimiento, estado_civil, estado_civil_text, alias, correos, telefonos, delitos, datos, direcciones}=arrSujetosProcesales[index];

      let listaDelitos='',
          listaAlias='',
          listaCorreos='',
          listaTelefonos='',
          listaDirecciones='';

      $(alias).each(function(index, ali){
          li=`${ali.alias}<br>`;
          listaAlias=listaAlias.concat(li);
      });

      $(correos).each(function(index, correo){
          li=`${correo.correo}<br>`;
          listaCorreos=listaCorreos.concat(li);
      });

      $(telefonos).each(function(index, telefono){
          li=`${telefono.tipo}: ${telefono.numero} ${telefono.extension==''?'':'ext '+telefono.extension}<br>`;
          listaTelefonos=listaTelefonos.concat(li);
      });



      $(direcciones).each(function(index, direccion){
        const {estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle}=direccion;
        const tableDireccion=`<br>
                              <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                                <thead>
                                  <tr>
                                    <th class="tx-center" colspan="4" style="background:#f8f9fa">Domicilio ${index+1}</th>
                                    <th class="d-none"></th>
                                    <th class="d-none"></th>
                                    <th class="d-none"></th>
                                  </tr>
                                </thead>
                                <tbody class="table-datos-sujeto">
                                  <tr>
                                    <td>Calle</td>
                                    <td>${calle==null?'':calle}</td>
                                    <td>Número Exterior</td>
                                    <td>${numero_exterior==null?'':numero_exterior}</td>
                                  </tr>
                                  <tr>
                                    <td>Número Interior</td>
                                    <td>${numero_interior==null?'':numero_interior}</td>
                                    <td>Localidad</td>
                                    <td>${localidad==null?'':localidad}</td>
                                  </tr>
                                  <tr>
                                    <td>Colonia</td>
                                    <td>${colonia==null?'':colonia}</td>
                                    <td>Municipio</td>
                                    <td>${municipio_text==null?'':municipio_text}</td>
                                  </tr>
                                  <tr>
                                    <td>Estado</td>
                                    <td>${estado_text==null?'':estado_text}</td>
                                    <td>Entre Calle y Calle</td>
                                    <td>${entre_calle==null?'':entre_calle}</td>
                                  </tr>
                                  <tr>
                                    <td>Otras Referencias</td>
                                    <td>${otra_referencia==null?'':otra_referencia}</td>
                                  </tr>
                                </tbody>
                              </table>  `;

        listaDirecciones=listaDirecciones.concat(tableDireccion);
      });

      const {ocupacion,otra_escolaridad,otra_ocupacion,otra_religion,otro_grupo_etnico,otro_idioma_traductor,requiere_traductor,idioma_traductor,requiere_interprete,tipo_interprete,capacidades_diferentes,capacidad_diferente,poblacion,otra_poblacion,pertenece_grupo_etnico,entiende_idioma_espanol,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,estatus,id_escolaridad,nivel_escolaridad,lengua,nombre_religion,nombre_poblacion,grupo_etnico}=datos[0];

      const table= `<table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                      <tbody class="table-datos-sujeto">
                        <tr>
                          <td>Calidad Jurídica</td>
                          <td>${tipo_parte_text}</td>
                          <td>Ocupación</td>
                          <td>${ocupacion==null?'':ocupacion}</td>
                        </tr>
                        <tr>
                          <td>Nombre ó Razón Social</td>
                          <td>${razon_social}${nombre} ${apellido_paterno} ${apellido_materno}</td>
                          <td>Otra Ocupación</td>
                          <td>${otra_ocupacion==null?'':otra_ocupacion}</td>
                        </tr>
                        <tr>
                          <td>RFC</td>
                          <td>${rfc}</td>
                          <td>Escolaridad</td>
                          <td>${nivel_escolaridad==null?'':nivel_escolaridad}</td>
                        </tr>
                        <tr>
                          <td>CURP</td>
                          <td>${curp}</td>
                          <td>Otra Escolaridad</td>
                          <td>${otra_escolaridad==null?'':otra_escolaridad}</td>
                        </tr>
                        <tr>
                          <td>Cédula Profesional</td>
                          <td>${cedula_profesional}</td>
                          <td>Religión</td>
                          <td>${nombre_religion==null?'':nombre_religion}</td>
                        </tr>
                        <tr>
                          <td>Género</td>
                          <td>${genero==''?'':genero==null?'':genero_text}</td>
                          <td>Otra Religión</td>
                          <td>${otra_religion==null?'':otra_religion}</td>
                        </tr>
                        <tr>
                          <td>Fecha de Nacimiento</td>
                          <td>${fecha_nacimiento}</td>
                          <td>Grupo Étnico</td>
                          <td>${grupo_etnico==null?'':grupo_etnico}</td>
                        </tr>
                        <tr>
                          <td>Nacionalidad</td>
                          <td>${nacionalidad==''?'':nacionalidad==null?'':nacionalidad_text}</td>
                          <td>Otro Grupo Étnico</td>
                          <td>${otro_grupo_etnico==null?'':otro_grupo_etnico}</td>
                        </tr>
                        <tr>
                          <td>Estado Civíl</td>
                          <td>${estado_civil==''?'':estado_civil==null?'':estado_civil_text}</td>
                          <td>Lengua</td>
                          <td>${lengua==null?'':lengua}</td>
                        </tr>
                        <tr>
                          <td>Capacidad Diferente</td>
                          <td>${capacidad_diferente==null?'':capacidad_diferente}</td>
                          <td>Discapacidad</td>
                          <td>${descripcion_discapacidad==null?'':descripcion_discapacidad}</td>
                        </tr>
                        <tr>
                          <td>Sabe Leer y Escribir</td>
                          <td>${sabe_leer_escribir==null?'':sabe_leer_escribir}</td>
                          <td>Población Callejera</td>
                          <td>${poblacion_callejera==null?'':poblacion_callejera}</td>
                        </tr>
                        <tr>
                          <td>Población</td>
                          <td>${poblacion==null?'':poblacion}</td>
                          <td>Otra Población</td>
                          <td>${otra_poblacion==null?'':otra_poblacion}</td>
                        </tr>
                        <tr>
                          <td>Nombre Población</td>
                          <td>${nombre_poblacion==null?'':nombre_poblacion}</td>
                          <td>Entiende el Idioma Español</td>
                          <td>${entiende_idioma_espanol==null?'':entiende_idioma_espanol}</td>
                        </tr>
                        <tr>
                          <td>Requiere Intérprete</td>
                          <td>${requiere_interprete==null?'':requiere_interprete}</td>
                          <td>Tipo de Intérprete</td>
                          <td>${tipo_interprete==null?'':tipo_interprete}</td>
                        </tr>
                        <tr>
                          <td>Requiere Traductor</td>
                          <td>${requiere_traductor==null?'':requiere_traductor}</td>
                          <td>Idioma del Traductor</td>
                          <td>${idioma_traductor==null?'':idioma_traductor}</td>
                        </tr>
                        <tr>
                          <td>Otro Idioma del Traductor</td>
                          <td>${otro_idioma_traductor==null?'':otro_idioma_traductor}</td>
                        </tr>
                      </tbody>
                    </table>
                    <br>
                    <table  class="datatable tableDatosSujeto2" style="overflow-x: none; display: table">
                      <thead>
                        <tr>
                          <th class="tx-center">Teléfonos</th>
                          <th class="tx-center">Correos</th>
                          <th class="tx-center">Alias</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>${listaTelefonos==''?'<span class="tx-italic">Sin teléfonos registrados</span>':listaTelefonos}</td>
                          <td>${listaCorreos==''?'<span class="tx-italic">Sin correos registrados</span>':listaCorreos}</td>
                          <td>${listaAlias==''?'<span class="tx-italic">Sin alias registrados</span>':listaAlias}</td>
                        </tr>
                      </tbody>
                    </table>
                    ${listaDirecciones} `;

      $('#titleSujeto').html('Datos del Sujeto Procesal');
      $('#divDatosSujeto').html(table);
      $('#divEditarDelito').html(`<button class="btn btn-primary d-inline-block" data-dismiss="modal" id="editarSujeto" onclick="editarSujeto(${index})">Editar</button>`).css({"margin-left": "auto"});
      $('#modalDatosSujeto').modal('show');
    }

    function editarSujeto(indexp){
      const {tipo_parte, tipo_persona, nacionalidad,otra_nacionalidad, curp, rfc, cedula_profesional, nombre, apellido_paterno, apellido_materno, razon_social, genero, fecha_nacimiento, estado_civil, direcciones, alias, correos, telefonos, edad,id, datos}=arrSujetosProcesales[indexp];

      $('#persona').val(id);

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

      const {id_nivel_escolaridad,id_lengua,id_religion,id_lgbttti,id_grupo_etnico,tipo_ocupacion,otra_escolaridad,otra_ocupacion,otra_religion,otro_grupo_etnico,otro_idioma_traductor,requiere_traductor,idioma_traductor,requiere_interprete,tipo_interprete,capacidades_diferentes,capacidad_diferente,poblacion,otra_poblacion,pertenece_grupo_etnico,entiende_idioma_espanol,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,id_escolaridad,nivel_escolaridad,lengua,nombre_religion,nombre_poblacion,grupo_etnico,id_datos_persona}=datos[0];
      console.log(datos);
      $('#escolaridad').val(id_nivel_escolaridad).select2({minimumResultsForSearch: Infinity});
      $('#sabe_leer_escribir').val(sabe_leer_escribir).select2({minimumResultsForSearch: Infinity});
      $('#entiende_idioma_espanol').val(entiende_idioma_espanol).select2({minimumResultsForSearch: Infinity});
      $('#poblacion_callejera').val(poblacion_callejera).select2({minimumResultsForSearch: Infinity});
      $('#requiere_interprete').val(requiere_interprete).select2({minimumResultsForSearch: Infinity});
      $('#requiere_traductor').val(requiere_traductor).select2({minimumResultsForSearch: Infinity});
      $('#ocupacion').val(tipo_ocupacion).select2({minimumResultsForSearch: ''});
      $('#religion').val(id_religion).select2({minimumResultsForSearch: ''});
      $('#grupo_etnico').val(id_grupo_etnico).select2({minimumResultsForSearch: ''});
      $('#lengua').val(id_lengua).select2({minimumResultsForSearch: ''});
      $('#poblacion').val(id_lgbttti).select2({minimumResultsForSearch: ''});
      $('#idioma_traductor').val(idioma_traductor).select2({minimumResultsForSearch: ''});

      if(otra_religion!=null && otra_religion!=''){
        $('#otra_religion').val(otra_religion).removeAttr('disabled');
      }
      if(otro_grupo_etnico!=null && otro_grupo_etnico!=''){
        $('#otro_grupo_etnico').val(otro_grupo_etnico).removeAttr('disabled');
      }
      if(otra_ocupacion!=null && otra_ocupacion!=''){
        $('#otra_ocupacion').val(otra_ocupacion).removeAttr('disabled');
      }
      if(otro_idioma_traductor!=null && otro_idioma_traductor!=''){
        $('#otro_idioma_traductor').val(otro_idioma_traductor).attr('disabled',true);
      }
      if(tipo_interprete!=null && tipo_interprete!=''){
        $('#tipo_interprete').val(tipo_interprete).removeAttr('disabled');
      }
      if(otra_poblacion!=null && otra_poblacion!=''){
        $('#otra_poblacion').val(otra_poblacion).removeAttr('disabled');
      }

      if(alias.length){
        sAlias='';
        $(alias).each(function(index, ali){
          sAlias=sAlias.concat(`<div class="row datos-alias ${ali.estatus==0?'d-none':''}" data-id="${ali.id}" data-status="${ali.estatus}">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-alias" data-index="${index}" data-indexp="${indexp}"></i></p>
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
          sCorreos=sCorreos.concat(`<div class="row datos-correo ${correo.estatus==0?'d-none':''}"  data-id="${correo.id}" data-status="${correo.estatus}">
                                      <div class="col-12">
                                        <p class="tx-right tx-danger"><i class="fa fa-close borrar-correo" data-index="${index}" data-indexp="${indexp}"></i></p>
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
          sTelefonos=sTelefonos.concat(`<div class="row datos-telefono ${telefono.estatus==0?'d-none':''}"  data-id="${telefono.id}" data-status="${telefono.estatus}">
                                          <div class="col-12">
                                            <p class="tx-right tx-danger"><i class="fa fa-close borrar-telefono" data-index="${index}" data-indexp="${indexp}"></i></p>
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

        $('.tipo-telefono').select2({minimumResultsForSearch: Infinity});
        $('#telefonos').html(sTelefonos);
      }

      if(direcciones.length){
        sDirecciones='';
        $(direcciones).each(function(index, direccion){

          const {estado, municipio , colonia, localidad,codigo_postal,calle,numero_exterior, numero_interior, otra_referencia, entre_calle,alias, correos, telefonos,  edad, cve_estado, id, estatus}=direccion;


          let estados='<option>Elija una opción</option>';

          $(catalogoEstados).each(function(index, datosEstado){

            if(estado==datosEstado.id_estado){

              const option=`<option value="${datosEstado.id_estado}" data-cve-estado="${datosEstado.cve_estado}" selected>${datosEstado.estado}</option>`;
              estados=estados.concat(option);
            }else{

              const option=`<option value="${datosEstado.id_estado}" data-cve-estado="${datosEstado.cve_estado}">${datosEstado.estado}</option>`;
              estados=estados.concat(option);
            }

          });

          let municipios='<option>Elija una opción</option>';

          if(estado!=null && estado!='' && municipio!=null && municipio!=''){

            $.ajax({
              type:'POST',
              url:'/public/obtener_municipios',
              data:{
                estado:cve_estado,
              },
              success:function(response){

                if(response.status==100){

                  $(response.response).each(function(index, datosMunicipio){

                    if(datosMunicipio.id_municipio==municipio){
                      let option=`<option value="${datosMunicipio.id_municipio}" selected>${datosMunicipio.municipio}</option>`;
                      municipios=municipios.concat(option);
                    }else{
                      let option=`<option value="${datosMunicipio.id_municipio}">${datosMunicipio.municipio}</option>`;
                      municipios=municipios.concat(option);
                    }
                  });
                }
              }
            });
          }

          setTimeout(function(){
            sDirecciones=sDirecciones.concat(`
                              <div class="row datos-domicilio ${estatus==0?'d-none':''}"  data-id="${id}" data-status="${estatus}">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-domicilio" data-index="${index}" data-indexp="${indexp}"></i></p>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label class="form-control-label">Estado: </label>
                                    <select class="form-control estado" name="estado" autocomplete="off">
                                        ${estados}
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label class="form-control-label">Municipio: </label>
                                    <select class="form-control municipio" name="municipio" autocomplete="off">
                                        ${municipios}
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Localidad:</label>
                                    <input class="form-control localidad" type="text" name="localidad"  autocomplete="off" value="${localidad==null?'':localidad}">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Calle:</label>
                                    <input class="form-control calle" type="text" name="calle" autocomplete="off"  value="${calle==null?'':calle}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Número Exterior:</label>
                                    <input class="form-control numeroExterior" type="text" name="numero_exterior" autocomplete="off" value="${numero_exterior==null?'':numero_exterior}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Número Interior:</label>
                                    <input class="form-control numero_interior" type="text" name="numero_interior"  autocomplete="off"  value="${numero_interior==null?'':numero_interior}">
                                  </div>
                                </div><!-- col-4-->
                                <div class="col-lg-9">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Colonia:</label>
                                    <input class="form-control colonia" type="text" name="colonia"  autocomplete="off"  value="${colonia==null?'':colonia}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Código Postal:</label>
                                    <input class="form-control codigoPostal" type="text" name="codigo_postal" autocomplete="off" value="${codigo_postal==null?'':codigo_postal}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-8">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Entre la Calle:</label>
                                    <input class="form-control entreCalle" type="text" name="entre_calle" autocomplete="off"  value="${entre_calle==null?'':entre_calle}">
                                  </div>
                                </div><!-- col-4-->
                                <div class="col-lg-12">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Otras Referencias:</label>
                                    <input class="form-control otrasReferencias" type="text" name="otras_referencias" autocomplete="off"  value="${otra_referencia==null?'':otra_referencia}">
                                  </div>
                                </div><!-- col-4-->
                              </div>
            `);
            $('#domicilios').html(sDirecciones);
          },500);
        });


        $('.estado').select2({minimumResultsForSearch: ''});
        $('.municipio').select2({minimumResultsForSearch: ''});
      }

      $('#botonesPartes').append(`<button type="button" class="btn btn-secondary d-inline-block btn-edicion mg-l-auto" onclick="limpiarCamposSujetos()">Cancelar</button>
                                  <button class="btn btn-primary d-inline-block   btn-edicion mg-l-5"  onclick="editarDatosSujeto(${indexp})">Guardar Edición</button>`);
      $('#agregarParte').addClass('d-none').removeClass('d-inline-block');

    }

    function editarDatosSujeto(indexEditado){

      const delitos=arrSujetosProcesales[indexEditado].delitos,
            alias=[],
            correos=[],
            telefonos=[],
            datos=[],
            direcciones=[];

      $('.datos-alias').each(function(){
        datosAlias={
          id:$(this).attr('data-id'),
          estatus:$(this).attr('data-status'),
          alias:$(this).find('.alias').val(),
          alias_apellido_paterno:$(this).find('.alias-apellido-paterno').val(),
          alias_apellido_materno:$(this).find('.alias-apellido-materno').val(),
        }
        alias.push(datosAlias);
      });

      $('.datos-correo').each(function(){
        datosCorreo={
          id:$(this).attr('data-id'),
          estatus:$(this).attr('data-status'),
          correo:$(this).find('.correo-electronico').val(),
        }
        correos.push(datosCorreo);
      });

      $('.datos-telefono').each(function(){
        datosTelefono={
          id:$(this).attr('data-id'),
          estatus:$(this).attr('data-status'),
          tipo:$(this).find('.tipo-telefono').val(),
          numero:$(this).find('.numero-telefono').val(),
          extension:$(this).find('.extension').val(),
        }
        telefonos.push(datosTelefono);
      });

      $('.datos-domicilio').each(function(){
        const datosDireccion={
          "id":$(this).attr('data-id'),
          "estatus":"1",
          "calle":$(this).find('.calle').val(),
          "numero_exterior":$(this).find('.numeroExterior').val(),
          "numero_interior":$(this).find('.numero_interior').val(),
          "colonia":$(this).find('.colonia').val(),
          "codigo_postal":$(this).find('.codigoPostal').val(),
          "estado":$(this).find('.estado').val(),
          "estado_text":$(this).find('.estado').val()==''?'':$(this).find('.estado').find('option:selected').text(),
          "cve_estado":$(this).find('.estado').find('option:selected').attr('data-cve-estado'),
          "municipio":$(this).find('.municipio').val(),
          "municipio_text":$(this).find('.municipio').val()==''?'':$(this).find('.municipio').find('option:selected').text(),
          "localidad":$(this).find('.localidad').val(),
          "entre_calle":$(this).find('.entreCalle').val(),
          "otra_referencia":$(this).find('.otrasReferencias').val(),
        };

        direcciones.push(datosDireccion);
      });

      const datosAdicionales={
        id_datos_persona:'',
        estatus:'',
        id_nivel_escolaridad:$('#escolaridad').val(),
        id_escolaridad:$('#escolaridad').val(),
        nivel_escolaridad:$('#escolaridad').val()==''?'':$('#escolaridad').find('option:selected').text(),
        otra_escolaridad:$('#otra_escolaridad').val(),
        id_lengua:$('#lengua').val(),
        lengua:$('#lengual').val()==''?'':$('#lengual').find('option:selected').text(),
        id_religion:$('#religion').val(),
        nombre_religion:$('#religion').val()==''?'':$('#religion').find('option:selected').text(),
        otra_religion:$('#otra_religion').val(),
        id_lgbttti:$('#poblacion').val(),
        nombre_poblacion:$('#poblacion').val()==''?'':$('#poblacion').find('option:selected').text(),
        id_grupo_etnico:$('#grupo_etnico').val(),
        grupo_etnico:$('#grupo_etnico').val()==''?'':$('#grupo_etnico').find('option:selected').text(),
        otro_grupo_etnico:$('#otro_grupo_etnico').val(),
        tipo_ocupacion:$('#ocupacion').val(),
        ocupacion:$('#ocupacion').val()==''?'':$('#ocupacion').find('option:selected').text(),
        otra_ocupacion:$('#otra_ocupacion').val(),
        requiere_traductor:$('#requiere_traductor').val(),
        idioma_traductor:$('#idioma_traductor').val(),
        otro_idioma_traductor:$('#otro_idioma_traductor').val(),
        requiere_interprete:$('#requiere_interprete').val(),
        tipo_interprete:$('#tipo_interprete').val(),
        capacidades_diferentes:$('#capacidades_diferentes').val(),
        capacidad_diferente:"",
        poblacion:$('#poblacion').val(),
        otra_poblacion:$('#otra_poblacion').val(),
        pertenece_grupo_etnico:$('#grupo_etnico').val()==''?'si':'no',
        entiende_idioma_espanol:$('#entiende_idioma_espanol').val(),
        descripcion_discapacidad:"",
        sabe_leer_escribir:$('#sabe_leer_escribir').val(),
        poblacion_callejera:$('#poblacion_callejera').val(),
        estatus:"1",
      };

      datos.push(datosAdicionales);
      const sujetoProcesal={
        "id":$('#persona').val(),
        "estatus":"1",
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
        "alias":alias,
        "correos":correos,
        "telefonos":telefonos,
        "delitos":delitos,
        "datos":datos,
        "direcciones":direcciones,
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
      $('#datosAlias').html('');
      $('#correos').html('');
      $('#telefonos').html('');
      $('#domicilios').html('');
      $('#escolaridad').val('').select2({minimumResultsForSearch: Infinity});
      $('#sabe_leer_escribir').val('').select2({minimumResultsForSearch: Infinity});
      $('#entiende_idioma_espanol').val('').select2({minimumResultsForSearch: Infinity});
      $('#poblacion_callejera').val('').select2({minimumResultsForSearch: Infinity});
      $('#requiere_interprete').val('').select2({minimumResultsForSearch: Infinity});
      $('#requiere_traductor').val('').select2({minimumResultsForSearch: Infinity});
      $('#ocupacion').val('').select2({minimumResultsForSearch: ''});
      $('#religion').val('').select2({minimumResultsForSearch: ''});
      $('#grupo_etnico').val('').select2({minimumResultsForSearch: ''});
      $('#lengua').val('').select2({minimumResultsForSearch: ''});
      $('#poblacion').val('').select2({minimumResultsForSearch: ''});
      $('#idioma_traductor').val('').select2({minimumResultsForSearch: ''});
      $('#otra_religion').val('').attr('disabled',true);
      $('#otro_grupo_etnico').val('').attr('disabled',true);
      $('#otra_ocupacion').val('').attr('disabled',true);
      $('#otro_idioma_traductor').val('').attr('disabled',true);
      $('#tipo_interprete').val('').attr('disabled',true);
      $('#otra_poblacion').val('').attr('disabled',true);
      $('#persona').val('-');
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
              "id":"",
              "estatus":"1",
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

      if($('#modalidadDelito').val()==null) return {'estatus':0,'campo':'modalidadDelito','error':'No ha seleccionado la modalidad del delito'};

      if($('#calificativo').val()==null) return {'estatus':0,'campo':'calificativo','error':'No ha seleccionado el calificativo'};

      if($('#gradoRealizacion').val()==null) return {'estatus':0,'campo':'gradoRealizacion','error':'No ha seleccionado el grado de realizacion'};

      return 100;
    }

    function mostrarModalDocumento(){
      $('#modalAdjuntarDocumento').modal('show');
    }

    function leeDocumento (input) {
      const file = $('#archivoPDF').val();
      const ext = file.substring(file.lastIndexOf("."));
      if(ext!=''){
        if(ext != ".pdf"){
          alert('Solo puede adjuntar archivos .pdf');
          $('#archivoPDF').val('');
        }else{
            if (input.files && input.files[0]) {
              const reader = new FileReader();
              reader.onload = e=> {
                  $('#documentoPDF').attr('data', e.target.result); // Renderizamos la imagen
                  $('#documentoPDF').removeClass('d-none');
                  $('#bDoc').val(e.target.result.split('base64,')[1]);
              }
              reader.readAsDataURL(input.files[0]);
            }
        }
      }

    }

    function enviarSolicitud(solicitud){
      // $('#modal_loading').modal('show');
      $('#modalAdjuntarDocumento').modal('hide');
      cambiarPantalla('modal');
      const validaDocumento=$('#bDoc').val();
      const fechaRecepcion=$('#fechaRecepcion').val().split('-');
      let urgente='no',
          requiereTelepresencia='no',
          requiereResguardo='no',
          requiereTestigoProtegido='no',
          requiereMesa='no',
          priosionOficiosa='no';

      if($('#urgente').find('.toggle-on').hasClass('active')) urgente='si';

      if($('#requiereTelepresencia').find('.toggle-on').hasClass('active')) requiereTelepresencia='si';

      if($('#requiereResguardo').find('.toggle-on').hasClass('active'))requiereResguardo='si';

      if($('#requiereTestigoProtegido').find('.toggle-on').hasClass('active')) requiereTestigoProtegido='si';

      if($('#requiereMesa').find('.toggle-on').hasClass('active')) requiereMesa='si';

      if($('#priosionOficiosa').find('.toggle-on').hasClass('active')) priosionOficiosa='si';

      $.ajax({
        type:'POST',
        url:'/public/enviar_solicitud_editada',
        data:{
          sujetos_procesales:arrSujetosProcesales,
          solicitud:solicitud,
          carpeta_judicial:$('#carpeta_judicial').val(),
          estatus_flujo:$('#estatus_flujo').val(),
          fecha_recepcion:fechaRecepcion[2]+'-'+fechaRecepcion[1]+'-'+fechaRecepcion[0],
          hora_recepcion:$('#horaRecepcion').val(),
          numero_carpeta_investigacion:$('#numeroCarpetaInvestigacion').val(),
          tipo_audiencia:$('#tipoAudiencia').val(),
          duracion_aproximada:$('#duracionAproximada').val().split('minutos')[0],
          urgente:urgente,
          requiere_telepresencia:requiereTelepresencia,
          requiere_resguardo:requiereResguardo,
          requiere_testigoProtegido:requiereTestigoProtegido,
          requiere_mesa:requiereMesa,
          prision_oficiosa:priosionOficiosa,
          materia_destino:$('input:radio[name=materia_destino]:checked').val(),
          fiscalia:$('#fiscalia').val(),
          agecia:$('#agencia').val(),
          unidad_investigacion:$('#unidadInvestigacion').val(),
          coordinacion_territorial:$('#coordinacionTerritorial').val(),
          nombre_fiscal:$('#nombreFiscal').val(),
          apellido_paterno_fiscal:$('#apellidpPaternoFiscal').val(),
          apellido_materno_fiscal:$('#apellidpMaternoFiscal').val(),
          curp_fical:$('#curpFiscal').val(),
          correo_fiscal:$('#correoFiscal').val(),
          documento:$('#bDoc').val(),
          delitos_no_relacionados:arrDelitosNR,
        },
        success:function(response){
          if(response.status==100){
              $('#modalSuccess').modal('show');
            }
          setTimeout(()=>{
            $('#modal_loading').modal('hide');
          },1000);
        }
      });
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
                    @foreach (Arr::sort($delitos['response'], 'delito') as $delito)
                        <option value="{{$delito['id_delito']}}" data-grave="{{$delito['delito_oficioso']==1?'si':'no'}}">{{$delito['delito']}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Modalidad de Delito: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="modalidadDelito" name="modalidad_delito" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>

                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Calificativo: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="calificativo" name="calificativo" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    @foreach ($calificativos as $calificativo)
                        <option value="{{$calificativo['id_calificativo']}}">{{$calificativo['calificativo']}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Grado de Realización: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="gradoRealizacion" name="grado_realizacion" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="de_tentetiva">DE TENTATIVA</option>
                    <option value="consumado">CONSUMADO</option>
                    <option value="por_definir">POR DEFINIR</option>
                </select>
              </div>
            </div>
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
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto"></span></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20" id="divDatosSujeto">

        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <div id="divEditarDelito">

          </div>
          <button type="button" class="btn btn-secondary d-inline-block mg-l-auto" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalAdjuntarDocumento" class="modal fade">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Adjuntar Documento</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-20">
          <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data">
            <div class="custom-input-file">
              <input type="file" id="archivoPDF" class="input-file" value="" name="archivoPDF" onchange="leeDocumento('archivoPDF');">
              <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para reemplazar el documento actual</h5>
              </div>
          </form>
          <div id="divDucumento">
            <object data="{{$documento}}"  id="documentoPDF" width="100%" height="350px" class="mg-t-25"></object>
            <input type="hidden" id="bDoc">
          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-secondary d-inline-block mg-r-auto" onclick="cambiarPantalla('modal')"  data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary d-inline-block mg-l-auto" style="margin-left: auto;" onclick="enviarSolicitud({{$solicitud['id_solicitud']}})">Enviar Solicitud</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalSuccess" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>
          <h4 class="tx-success tx-semibold mg-b-20">Hecho!</h4>
          <p class="mg-b-20 mg-x-20">La solicitud se ha modificado correctamente.</p>
          <a href="/consulta_solicitudes"><button type="button" class="btn btn-success pd-x-25">Aceptar</button></a>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalRelacionarDelito" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
      <div class="modal-content bd-0 tx-14">
        <div class="modal-header">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold" id="titleDelito"></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-25" >
          <h5 class="lh-3 mg-b-20 tx-inverse hover-primary">Selecciones los Imputados a Relacionar</h5>
          <div id="opcionesImputados">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="guardarRelacion">Guardar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection
