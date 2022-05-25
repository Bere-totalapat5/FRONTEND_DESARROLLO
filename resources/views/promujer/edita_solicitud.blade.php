@php
  use App\Http\Controllers\clases\humanRelativeDate;
  use App\Http\Controllers\clases\utilidades;
  $humanRelativeDate = new humanRelativeDate();
@endphp
@extends('layouts.index')

@section('contenido-pageheader')
  <ol class="breadcrumb slim-breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Solicitudes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edita Solicitud</li>
  </ol>
  <h6 class="slim-pagetitle">Edita Solicitud</h6>
@endsection
@section('contenido-principal')
{{-- {{dd($request)}} --}}
  <div class="section-wrapper mg-b-100">

    {{-- @if(!utilidades::buscarPermisoMenu($request->menu_general['response'], 1305, 0))
      <h1 class="mg-b-50">No tiene permiso para acceder a esta sección, verifíquelo con su titular</h1>
      <a href="/home"><button class="btn btn-primary btn-block">Regresar al inicio</button><a>
    @else --}}

      <table class="mg-b-20 table-steps">
        <tr>
          <td class="td-step">
            <p class="step activo d-inline-block d-md-flex" id="step-datos-partes"><span class="num-step">1</span><span class="text-step d-none d-md-block">Registro de partes</span></p>
          </td>
          <td class="td-step">
            <p class="step espera  d-inline-block d-md-flex" id="step-relato-hechos"><span class="num-step">2</span><span class="text-step d-none d-md-block">Relato de hechos</span></p>
          </td>
          <td class="td-step">
            <p class="step espera  d-inline-block d-md-flex" id="step-documentacion"><span class="num-step">3</span><span class="text-step d-none d-md-block">Documentación</span></p>
          </td>
        </tr>
      </table>
      <div class="form-layout">
        <div class="row mg-b-25 datos-info-principal" id="div-datos-partes">{{-- datos de solicitud de audiencia --}}
          <input type="hidden" value="{{$solicitud['ruta_base_xml']==null?'interfaz':'xml'}}" id="origen">
          <input type="hidden" value="{{$solicitud['id_carpeta_judicial']}}" id="carpeta_judicial">
          <input type="hidden" value="{{$solicitud['estatus_flujo_actual']}}" id="estatus_flujo">
          <div class="col-lg-12">
            <h4 class="form-control-label"> Datos de la solicitud </h4>
            <hr/>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label class="form-control-label tx-justify">Folio de registro: </label>
              <input class="form-control" type="text" name="folio_registro" id="folioRegistro" placeholder="En tramite" autocomplete="off" value="{{$solicitud['folio_solicitud']==null? '':$solicitud['folio_solicitud']}}" disabled>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-4">
            <div class="form-group">
              <label class="form-control-label">Fecha de registro: </label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <div class="input-group-text">
                          <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                  </div>
                  <input type="text" class="form-control fc-datepicker" placeholder="En tramite" id="fechaRegistro"  name="fecha_registro" autocomplete="off" disabled value="@php if($solicitud['creacion']!=null){ $fr=explode(' ',$solicitud['creacion'])[0];  $fr=explode('-',$fr); echo $fr[2].'-'.$fr[1].'-'.$fr[0];} @endphp">
              </div>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Carpeta judicial asignada:</label>
              <input class="form-control" type="text" name="carpeta_judicial" id="carpetaJudicial" value="{{$solicitud['folio_carpeta']==null? '':$solicitud['folio_carpeta']}}" placeholder="En tramite" autocomplete="off" disabled>
            </div>
          </div><!-- col-3 -->
          <div class="col-lg-3">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Folio de recepcion:</label>
              <input class="form-control" type="text" name="folio_recepcion" id="folioRecepcion" placeholder="En tramite" autocomplete="off" value="{{$solicitud['folio_solicitud']==null? '':$solicitud['folio_solicitud']}}" disabled>
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
                  <input type="text" class="form-control fc-datepicker" placeholder="DD-MM-AAAA" value="@php if($solicitud['fecha_recepcion']!=null){$fr=explode('-',$solicitud['fecha_recepcion']); echo $fr[2].'-'.$fr[1].'-'.$fr[0];} @endphp" id="fechaRecepcion" name="fecha_recepcion" autocomplete="off" disabled>
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
                  <input  type="text" class="form-control" id="horaRecepcion" name="hora_recepcion" placeholder="hh:mm" value="@php if($solicitud['hora_recepcion']!=null){ $hr=explode(':',$solicitud['hora_recepcion']); echo $hr[0].':'.$hr[1];} @endphp" disabled>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <label class="form-control-label">Unidad de gestion asignada: </label>
              <input class="form-control" type="text" name="unidad_gestion" id="unidadGestion"  placeholder="En tramite" autocomplete="off" disabled value="{{$unidad_investigacion}}">
            </div>
          </div><!-- col-3 -->
          <!-- TERMINA RENGLON -->

          <div class="col-lg-12">
            <br>
            <h4 class="form-control-label"> Datos de las partes</h4>
            <hr/>
          </div>

            <div class="col-lg-4">
              <div class="form-group">
                <input type="hidden" id="persona" value="-">
                <label class="form-control-label">Calidad Jurídica: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="tipoParte" name="tipo_parte" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    @foreach ($calidad_juridica as $calidad)
                        <option value="{{$calidad['id_calidad_juridica']}}">{{$calidad['calidad_juridica']}}</option>
                    @endforeach
                </select>
              </div>
            </div><!-- col-6 -->
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Tipo Persona: <span class="tx-danger">*</span></label>
                <select class="form-control select2" id="tipoPersona" name="tipo_persona" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="fisica">FÍSICA</option>
                    <option value="moral">MORAL</option>
                </select>
              </div>
            </div><!-- col-6-->
            <div class="col-lg-4 fisica">
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
                <select class="form-control select2 " id="otraNacionalidad" name="otra_nacionalidad" autocomplete="off" disabled>
                    <option selected  value="" disabled>Elija una opción</option>
                    @foreach ($nacionalidades as $nacionalidad)
                          <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option> 
                    @endforeach
                </select>
              </div>
            </div><!-- col-6-->
            <div class="col-lg-6 fisica">
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
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Cédula Profesional:</label>
                <input class="form-control" type="text" name="cedula_profesional" id="cedulaProfesional" autocomplete="off">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-8 moral d-none">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Razón Social: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="razon_social" id="razonSocial" autocomplete="off">
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
            <div class="col-lg-4 fisica">
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
            <div class="col-lg-4 fisica">
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
            <div class="col-lg-4 fisica">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Edad:</label>
                <input class="form-control inpur-number" type="text" name="edad" id="edad" autocomplete="off">
              </div>
            </div><!-- col-4-->
            
            {{--   A C O R D E O N      A L I A S  --}}
            <div class="col-lg-12">
                <div id="acordingAlias" class="accordion-two mg-b-15" role="tablist" aria-multiselectable="true">
                    <div class="card">
                    <div class="card-header" role="tab" id="headingAlias">
                        <a data-toggle="collapse" data-parent="#acordingAlias" href="#collapseAlias" aria-expanded="false" aria-controls="collapseAlias" class="tx-gray-800 transition collapsed">
                        Agregar Alias
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
            </div>
            
            {{--   A C O R D E O N  D O M I C I L I O   Y   C O N T A C T O  --}}
            <div class="col-lg-12">
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
                            {{-- D O M I C I L I O --}}
                            <div class="col-12">
                                <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10 mg-t-15" id="agregarDomicilio">Agregar Domicilio <i class="fa fa-plus"></i></button>
                                <div id="domicilios" class="mg-b-15">
                                </div>
                            </div><!-- col-12 termina renglon -->

                            {{-- C O R R E O --}}
                            <div class="col-12">
                                <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10 mg-t-15" id="agregarCorreo">Agregar Correo <i class="fa fa-plus"></i></button>
                                <div id="correos" class="mg-b-15">
                                </div>
                            </div><!-- col-12 termina renglon -->

                            {{-- T E L E F O N O --}}
                            <div class="col-12">
                                <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10" id="agregarTelefono">Agregar Telefono <i class="fa fa-plus"></i></button>
                                <div id="telefonos">
                                </div>
                            </div><!-- col-12 termina renglon -->
                        </div>
                        </div>
                    </div>
                    </div>
                </div><!-- accordeon domicilio, contactos -->
            </div>
            <br>
            <div class="col-lg-12">
                <div id="accordionDatosAdicionales" class="accordion-two mg-b-15" role="tablist" aria-multiselectable="true">
                  <div class="card">
                    <div class="card-header" role="tab" id="headingDatosAdicionales">
                        <a data-toggle="collapse" data-parent="#accordionDatosAdicionales" href="#collapseDatosAdicionales" aria-expanded="false" aria-controls="collapseContacto" class="tx-gray-800 transition collapsed">
                        Datos Adicionales
                        </a>
                    </div><!-- card-header -->
                    <div id="collapseDatosAdicionales" class="collapse" role="tabpanel" aria-labelledby="headingDatosAdicionales">
                        <div class="card-body datos-adicionales">
                        <div class="row">
                            <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-control-label">Ocupación: </label>
                                <select class="form-control" id="ocupacion" name="ocupacion" autocomplete="off">
                                    <option selected  value="">Elija una opción</option>
                                    @foreach ($ocupaciones as $ocupacion)
                                        <option value="{{$ocupacion['id_ocupacion']}}" data-clave="{{$ocupacion['clave_ocupacion']}}">{{$ocupacion['nombre_ocupacion']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-control-label">Otra Ocupación:</label>
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
                                    <option value="No Aplica">NO APLICA</option>
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
                                    <option value="No Aplica">NO APLICA</option>
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
                                    <option value="No Aplica">NO APLICA</option>
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
                                    <option value="No Aplica">NO APLICA</option>
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
                                <label class="form-control-label">¿Requiere Traductor?: </label>
                                <select class="form-control" id="requiere_traductor" name="requiere_traductor" autocomplete="off">
                                    <option selected   value="">Elija una opción</option>
                                    <option value="si">SI</option>
                                    <option value="no">NO</option>
                                    <option value="No Aplica">NO APLICA</option>
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
                                <select class="form-control select2" id="requiere_interprete" name="requiere_interprete" autocomplete="off">
                                    <option selected   value="">Elija una opción</option>
                                    <option value="si">SI</option>
                                    <option value="no">NO</option>
                                    <option value="No Aplica">NO APLICA</option>
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
          </div>


          {{-- B O T O N    Y   T A B L A    P A R T E S --}}
          <div class="col-12 justify-content-end">
            <div  class="d-flex mg-t-5" id="botonesPartes">
                <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="agregarParte">Agregar Parte</button>
            </div>
            <div class="mg-t-15">
                <table  class="display dataTable dtr-inline collapsed d-block" style="overflow-x: auto; padding-left:0; padding-rigth:0;" role="grid" aria-describedby="example_info" width="100%" id="table-partes">
                    <thead>
                        <tr style="background-color: #EBEEF1; color: #000;">
                            <th class="acciones">Acciones</th>
                            <th class="tipo-parte">Calidad Jurídica</th>
                            <th class="nombre">Nombre/Razón Social</th>
                            <th class="genero">Género</th>
                        </tr>
                    </thead>
                    <tbody id="tableSujetosProcesales">
        
                    </tbody>
                </table>
            </div>
          </div><!-- row table partes -->
          
        </div>

        {{-- R E L A T O    D E   H E C H O S --}}
        <div class="row mg-b-25 d-none" id="div-datos-relato-hechos">
          <div class="col-lg-12">
            <div class="form-group">
              <label class="form-control-label">Relato de hechos: <span class="tx-danger">*</span></label>
              <textarea class="form-control" name="relato_hechos" id="relatoHechos" rows="20">{{$solicitud['descripcion_hechos']}}</textarea>
            </div>
          </div><!-- col-4-->
        </div>

        {{-- D O C U M E N T A C I O N --}}
        <div class="row mg-b-25 d-none" id="div-datos-documentacion">
          <div class="col-lg-12">
            <div class="form-group">
              <label class="form-control-label">Ingrese documentación: <span class="tx-danger">*</span></label>
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
          <button class="btn btn-primary bd-0 ml-auto d-none" id="btn-enviar-solicitud" onclick="enviarSolicitud()">Enviar solicitud</button>
        </div><!-- form-layout-footer -->
      </div>
      <br>
    {{-- @endif --}}
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
      background: #848F33 ;
    }
    .step.resuelto .text-step{
      color: #FFF;
    }
    .step.activo{
      background: #848F33 ;
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
      /* border-bottom: 1px solid #f0f2f7; */
      border-bottom: 1px solid #dee1e8;
    }
    span.select2-container--open{
      z-index: 1100 !important;
    }
    #modalError{
      z-index: 1110 !important;
    }
    .tipo-parte{
      /*min-width: 180px !important;*/
      min-width: 15% !important;
    }
    .tipo-persona{
      /* min-width: 160px !important; */
      min-width: 15% !important;
    }
    .nombre{
      /* min-width: 355px !important; */
      min-width: 30% !important;
    }
    .rfc{
      min-width: 160px !important;
    }
    .genero{
      /* min-width: 160px !important; */
      min-width: 15% !important;
    }
    .acciones{
      /*min-width: 140px !important;*/
      /*min-width: 215px !important;*/
      min-width: 25% !important;
    }

    td.acciones{
      font-size: 25px !important;
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
      /* border: 1px solid #EEE; */
      border: 1px solid #dee1e8;
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
      /* border: 1px solid #EEE; */
      border: 1px solid #dee1e8;
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
      /* border: 1px solid #EEE; */
      border: 1px solid #dee1e8;
      border-collapse: collapse;
      margin-top: 2px;      
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }

    #domicilios .row{
      border: 1px solid #dee1e8;
      /* border: 1px solid #EEE; */
      border-collapse: collapse;
      margin-top: 2px;      
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }

    div#domicilios .row:nth-child(2n){
      background: #FDFDFD !important;
    }

    div#correos .row:nth-child(2n){
      background: #FDFDFD !important;
    }
    table#tableDatosSujeto  td, table#tableDatosSujeto th{
      border: 1px solid #EEE;
      vertical-align: text-top;
      padding: 5px;
    }
    table#tableDatosSujeto2  td, table#tableDatosSujeto2 th{
      border: 1px solid #EEE;
      vertical-align: text-top;
      padding: 5px;
      /* width: 33%; */
    }

    table#tableDatosSujeto3  td, table#tableDatosSujeto3 th{
      border: 1px solid #EEE;
      vertical-align: text-top;
      padding: 5px;
      /* width: 33%; */
    }


    table#tableDatosSujeto tbody.table-datos-sujeto tr td:first-child(2n-1){
      background-color: #f8f9fa;
    }

    table.tableDatosSujeto tbody.table-datos-sujeto tr td{
      width: 25%;
    }

    table#table-partes{
      width: 100% !important;
    }

    table.dataTable {
      width: 100% !important;
    }

    /* PREVIEW FILES */
    .custom-preview-file {
      background: rgba(21, 79, 137, 0.70) !important;
      /* background: rgba(132, 143, 51, 0.76); */
      height: auto !important;
      cursor: pointer;
      font-size: 15px;
      font-weight: bold;
      margin: 0 auto 0;
      min-height: 230px;
      overflow: hidden;
      padding: 10px;
      position: relative;
      text-align: center;
      width: 500px;
      color: #FFFFFF;
      border: 2px solid #EEE;
      border-style: dotted;
      height: 80px;
      border-radius: 25px;
      width: 80%;
    }
    .custom-input-file:hover{
      background: #ffffff;
      color: #848F33 ;
    }

    .ion-10x:before {
      position: relative;
      font-size: 10em;
    }

    .error{
      margin: 1px !important; 
      border: 1px solid red !important;
    }

    .deleted{
      text-decoration:line-through;
      font-size: 10px;
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
      color: #848F33 ;
      border: 2px solid #EEE;
      border-style: dotted;
      height: 80px;
      border-radius: 25px;
      width: 80%;
    }

    .custom-input-file:hover{
      background: #848F33 ;
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

    tbody.table-datos-sujeto tr td:first-child{
      background-color: #f8f9fa;
    }

    table.dataTable{
      display:table !important;
    }
    .select2-selection__rendered{
      width: 223.854px !important;
    }

    .custom_row {
      display: flex;
      flex-flow: row wrap;
      justify-content: center;
    }

    .custom-col{
      flex: 0.1;
      max-width: 25%;
    }

    div.custom-card{
      display:block;
      width: 100%;
      /* margin: 1px; */
      /*border: 1px solid gray;*/
      background: rgba(222,226,230,047);
      height: auto !important;
      /* font-size: 15px; */
      font-weight: bold;
      overflow: hidden;
      position: relative;
      text-align: center;
      color: #848F33 !important;
      border-radius: 10px;
    }

    .custom-x{
      color: #dc3545;
      position: relative;
      top: 35px;
      right:-10px;
      z-index: 2;
    }

    .size-2x:before {
      position: relative;
      font-size: 2em;
    }

    td.td-title, th.td-title{
        background-color: #f0f2f7 !important;
        border-color: #f0f2f7 !important;
        max-height: 5px !important;
        padding: 3px 5px 3px 5px !important;
    }

    td.td-4col{
        min-width: 25% !important;
        max-width: 25% !important;
        width: 25% !important;
    }

    td.td-3col{
      min-width: 33.3% !important;
      max-width: 33.3% !important;
      width: 33.3% !important;
    }


    @media screen and (max-width: 600px) {
      table.dataTable{
        display:block !important;
      }
      table {
          width:100%;
      }
      thead {
          display: none;
      }
      tr:nth-of-type(2n) {
          background-color: inherit;
      }
      tr td:first-child {
          background: #f0f0f0;
          font-weight:bold;
          font-size:1.3em;
      }
      tbody td {
          display: block;
          text-align:center;
      }
      tbody td:before {
          content: attr(data-th);
          display: block;
          text-align:center;
      }
      .select2-selection__rendered{
        width: auto !important; 
      }
    }

    @media only screen and (max-width: 1199px) {
      table.dataTable{
        display:table !important;
      }
      table {
          width:100%;
      }

      .select2-selection__rendered{
        width: 223.854px !important;
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
    
    let step=1;
    const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
          expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
          expVacio=/^[\s]*$/,
          expRFC=/^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/;
          arrSujetosProcesales=[],
          documentos = [],
          sujetosGuardados=@php echo json_encode($solicitud['personas']);@endphp,
          documentosGuardados=@php echo json_encode($documentos);@endphp,
          catalogoEstados=@php echo json_encode($estados);@endphp;
    
    //const sujetosDatosProtegidos = [];
    const sujetoInputsProtegidos = [];

    const catalogo_nacionalidades = @php echo json_encode($nacionalidades);@endphp;
    const catalogo_estado_civil = @php echo json_encode($estado_civil);@endphp;
    const catalogo_estados = @php echo json_encode($estados);@endphp;
    const catalogo_escolaridades = @php echo json_encode($escolaridades);@endphp;
    const catalogo_ocupaciones = @php echo json_encode($ocupaciones);@endphp;
    const catalogo_religiones = @php echo json_encode($religiones);@endphp;
    const catalogo_grupos_etnicos = @php echo json_encode($grupos_etnicos);@endphp;
    const catalogo_lenguas = @php echo json_encode($lenguas);@endphp;
    const catalogo_poblaciones_lgbttti = @php echo json_encode($poblaciones_lgbttti);@endphp;
    const catalogo_idiomas = @php echo json_encode($idiomas);@endphp;


    function escanea_datos_protegidos() {
      console.log('comienza escaneo');
      
      $(sujetosGuardados).each(function(index_sujeto, sujeto){
        let arrayInputs = [];
        const {alias, contacto, info_principal, direcciones, datos}=sujeto;
        let arInputAlias=[];
        let arInputCorreos=[];
        let arInputTelefonos=[];
        let arInputDirecciones=[];
        let arInputDatos=[];
        let arInputInfoPrin=[];
        
        $(alias).each(function(index_alias, aliasSujeto){
          arInputAlias.push({
            id: aliasSujeto.id_alias,
            tag: 'div',
            clase : 'datos-alias', 
            nombre: 'alias', 
            is_disabled : true, 
          });
          
        });
        
        $(contacto).each(function(index_contacto,contactoSujeto){
            
          if(contactoSujeto.tipo_contacto=='correo electronico'){
            arInputCorreos.push({
              id: contactoSujeto.id_contacto_persona,
              tag:'div',
              clase : 'datos-correo',
              nombre: 'correo_electronico', 
              is_disabled : true,
            });
          }else{
            arInputTelefonos.push(
              { id: contactoSujeto.id_contacto_persona,
                tag:'div',
                clase : 'datos-telefono',
                nombre: 'tipo_telefono', 
                is_disabled : true,
              },
              { id: contactoSujeto.id_contacto_persona,
                tag:'div',
                clase : 'datos-telefono',
                nombre: 'numero_telefono', 
                is_disabled : contactoSujeto.contacto == null ? false : true,
              },
              { id: contactoSujeto.id_contacto_persona,
                tag:'div',
                clase : 'datos-telefono',
                nombre: 'estension', 
                is_disabled : contactoSujeto.extension == null ? false : true,
              },
            );
          }
            
        });

        $(datos).each(function(index_datos, dato){
          const ocupacion = dato.tipo_ocupacion == null ? null : catalogo_ocupaciones[dato.tipo_ocupacion].nombre_ocupacion;

          arInputDatos.push(
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'ocupacion', 
              is_disabled : dato.tipo_ocupacion == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'otra_ocupacion', 
              is_disabled : true,
              //  is_disabled : dato.tipo_ocupacion == null? false : true,
            }, 
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'escolaridad', 
              is_disabled : dato.id_escolaridad == null? false : true,
            },  
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'otra_escolaridad', 
              is_disabled : true,
              //  is_disabled : dato.otra_escolaridad == null? false : true,
            },  
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'religion', 
              is_disabled : dato.id_religion == null? false : true,
            },  
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'otra_religion', 
              is_disabled : true,
              //  is_disabled : dato.otra_religion == null? false : true,
            },  
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'grupo_etnico', 
              is_disabled : dato.id_grupo_etnico == null? false : true,
            },  
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'otro_grupo_etnico', 
              is_disabled : true,
              //  is_disabled : dato.otro_grupo_etnico == null? false : true,
            },  
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'capacidades_diferentes', 
              is_disabled : dato.capacidades_diferentes == null? false : true,
            },  
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'discapacidad', 
              is_disabled : true,
              //  is_disabled : dato.capacidad_diferente == null? false : true,
            },  
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'lengua', 
              is_disabled : dato.id_lengua == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'sabe_leer_escribir', 
              is_disabled : dato.sabe_leer_escribir == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'entiende_idioma_espanol', 
              is_disabled : dato.entiende_idioma_espanol == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'poblacion_callejera', 
              is_disabled : dato.poblacion_callejera == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'poblacion', 
              is_disabled : dato.poblacion == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'otra_poblacion', 
              is_disabled : true,
              //  is_disabled : dato.otra_poblacion == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'requiere_traductor', 
              is_disabled : dato.requiere_traductor == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'idioma_traductor', 
              is_disabled : dato.idioma_traductor == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'otro_idioma_traductor', 
              is_disabled : true,
              //  is_disabled : dato.otro_idioma_traductor == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'requiere_interprete', 
              is_disabled : dato.requiere_interprete == null? false : true,
            },
            { id: dato.id_datos_persona,
              tag:'div',
              clase:'datos-adicionales',
              nombre: 'tipo_interprete', 
              is_disabled : true,
              //  is_disabled : dato.tipo_interprete == null? false : true,
            },
          );
          
        });

        $(direcciones).each(function(index_direccion, direccion){
          arInputDirecciones.push(
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'estado', 
              is_disabled : direccion.entidad_federativa == null? false : true,
            },
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'municipio', 
              is_disabled : direccion.id_municipio == null? false : true,
            },
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'localidad', 
              is_disabled : direccion.localidad == null? false : true,
            },
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'calle', 
              is_disabled : direccion.calle == null? false : true,
            },
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'numero_interior', 
              is_disabled : direccion.no_interior == null? false : true,
            },
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'numero_exterior', 
              is_disabled : direccion.no_exterior == null? false : true,
            },
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'colonia', 
              is_disabled : direccion.colonia == null? false : true,
            },
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'codigo_postal', 
              is_disabled : direccion.codigo_postal == null? false : true,
            },
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'entre_calle', 
              is_disabled : direccion.entre_calles == null? false : true,
            },
            { id: direccion.id_direccion_persona,
              tag:'div',
              clase:'datos-domicilio',
              nombre: 'otras_referencias', 
              is_disabled : direccion.referencias == null? false : true,
            },
            
          );
        });

        arInputInfoPrin.push(
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'tipo_parte', 
            is_disabled : info_principal.id_calidad_juridica == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'tipo_persona', 
            is_disabled : info_principal.tipo_persona == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'nacionalidad', 
            is_disabled : info_principal.es_mexicano == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'otra_nacionalidad', 
            is_disabled : info_principal.otra_nacionalidad == true,
            //is_disabled : info_principal.otra_nacionalidad == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'estado_civil', 
            is_disabled : info_principal.id_estado_civil == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'curp', 
            is_disabled : info_principal.curp == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'rfc', 
            is_disabled : info_principal.rfc_empresa == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'cedula_profesional', 
            is_disabled : info_principal.cedula_profesional == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'nombre', 
            is_disabled : info_principal.nombre == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'razon_social', 
            is_disabled : info_principal.razon_social == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'apellido_paterno', 
            is_disabled : info_principal.apellido_paterno == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'apellido_materno', 
            is_disabled : info_principal.apellido_materno == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'genero', 
            is_disabled : info_principal.genero == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'fecha_nacimiento', 
            is_disabled : info_principal.fecha_nacimiento == null? false : true,
          },
          { id: info_principal.id_persona,
            tag:'div',
            clase:'datos-info-principal',
            nombre: 'edad', 
            is_disabled : info_principal.edad == null? false : true,
          },  
        );
        
        
        sujetoInputsProtegidos[info_principal.id_persona]={
          info_prin : arInputInfoPrin,
          alias:arInputAlias,
          correos : arInputCorreos,
          telefonos : arInputTelefonos,
          direcciones : arInputDirecciones,
          datos : arInputDatos,
        };            
      });

      console.log('sujetos inputs protegidos',sujetoInputsProtegidos);
    }
  
    function inhabilita_datos_protegidos( index_sujeto_aplicar){
      console.log('Comienza inhabilitación');
      console.log('idx persona', index_sujeto_aplicar);
      console.log('sujeto', arrSujetosProcesales[ index_sujeto_aplicar ]);
      console.log('id_sujeto', arrSujetosProcesales[ index_sujeto_aplicar ].id );
      console.log('inputs protejidos', sujetoInputsProtegidos[ arrSujetosProcesales[ index_sujeto_aplicar ].id ]);
      if(arrSujetosProcesales[ index_sujeto_aplicar ].id != '-' && sujetoInputsProtegidos[ arrSujetosProcesales[ index_sujeto_aplicar ].id ] != undefined ){
        console.log('asignaciones');
        let strdiv=``;
        let strinput=``;
        let strdel=``;

        forms = sujetoInputsProtegidos[ arrSujetosProcesales[ index_sujeto_aplicar ].id ];
        console.log('Forms', forms);

        // INHABILITA INFO_PRINCIPAL
        console.log('Info Prin', forms.info_prin);
        $(forms.info_prin).each(function(idx, input){
          //console.log('input',input);
          strdiv = `${input.tag}.${input.clase}`;
          strinput = `input[name='${input.nombre}']`;
          strslct = `select[name='${input.nombre}']`;
          //console.log( strdiv, strinput);
          $(strdiv).find(strinput).prop('disabled',input.is_disabled);
          $(strdiv).find(strslct).prop('disabled',input.is_disabled);

          //$(strdiv).find("i.borrar-alias").remove();
        });
         
        // INHABILITA ALIAS
        console.log('Alias', forms.alias);
        $(forms.alias).each(function(idx, input){
          //console.log('input',input);
          strdiv = `${input.tag}.${input.clase}[data-id='${input.id}']`;
          strinput = `input[name='${input.nombre}']`;
          //console.log( strdiv, strinput);
          $(strdiv).find(strinput).prop('disabled',input.is_disabled);

          $(strdiv).find("i.borrar-alias").remove();
        });

        // INHABILITA TELEFONOS
        console.log('telefonos', forms.telefonos);
        $(forms.telefonos).each(function(idx, input){
          //  console.log('input',input);
          strdiv = `${input.tag}.${input.clase}[data-id='${input.id}']`;
          strinput = `input[name='${input.nombre}']`;
          strslct = `select[name='${input.nombre}']`;
          //  console.log( strdiv, strinput);
          $(strdiv).find(strinput).prop('disabled',input.is_disabled);
          $(strdiv).find(strslct).prop('disabled',input.is_disabled);

          $(strdiv).find("i.borrar-telefono").remove();
        });

        // INHABILITA CORREOS
        console.log('correos', forms.correos);
        $(forms.correos).each(function(idx, input){
          //  console.log('input',input);
          strdiv = `${input.tag}.${input.clase}[data-id='${input.id}']`;
          strinput = `input[name='${input.nombre}']`;
          //  console.log( strdiv, strinput);
          $(strdiv).find(strinput).prop('disabled',input.is_disabled);

          $(strdiv).find("i.borrar-correo").remove();
        });

        // INHABILITA DIRECCIONES
        console.log('direcciones', forms.direcciones);
        $(forms.direcciones).each(function(idx, input){
          //  console.log('input',input);
          strdiv = `${input.tag}.${input.clase}[data-id='${input.id}']`;
          strinput = `input[name='${input.nombre}']`;
          strslct = `select[name='${input.nombre}']`;
          //  console.log( strdiv, strinput);
          $(strdiv).find(strinput).prop('disabled',input.is_disabled);
          $(strdiv).find(strslct).prop('disabled',input.is_disabled);

          $(strdiv).find("i.borrar-domicilio").remove();
        });

        // INHABILITA DIRECCIONES
        console.log('Datos adicionales', forms.datos);
        $(forms.datos).each(function(idx, input){
          //  console.log('input',input);
          strdiv = `${input.tag}.${input.clase}`;
          strinput = `input[name='${input.nombre}']`;
          strslct = `select[name='${input.nombre}']`;
          //  console.log( strdiv, strinput);
          $(strdiv).find(strinput).prop('disabled',input.is_disabled);
          $(strdiv).find(strslct).prop('disabled',input.is_disabled);

          // $(strdiv).find("i.borrar-datos-adicionales").remove();
        });
      }else{
        console.log("No se inhabilitan campos", arrSujetosProcesales[ index_sujeto_aplicar ].id, sujetoInputsProtegidos[ arrSujetosProcesales[ index_sujeto_aplicar ].id ] );
      }
    }

    function inhabilitacion_default(){
      // INHABILITAR RELATO DE HECHOS
      $("#relatoHechos").prop('disabled',true);

      // INHABILITAR DOCUMENTOS
      $(documentosGuardados).each(function(idx, input){
        //  console.log('input',input);
        strdiv = `div.datos-documento[data-id='${input.id_version}']`;
        strinput = `input[name='nombre_archivo']`;
        //  console.log( strdiv, strinput);
        $(strdiv).find(strinput).prop('disabled',true);

        $(strdiv).find("i.borrar_documento").remove();
      });
    }
    // así funciona deshabilitar  // console.log( $("div.datos-alias[data-id='208']").find("input[name='alias']").prop('disabled',false));

    //} 
    /***********************
     * 
     *  COMIENZA A CARGAR LOS SUJETOS
     * 
     ************************/
    $(()=>{
        escanea_datos_protegidos() ;
        
        $(sujetosGuardados).each(function(index_sujeto, sujeto){
            const {alias, contacto, info_principal, direcciones, datos}=sujeto;
            
            const arrAlias=[],
                arrCorreos=[],
                arrTelefonos=[],
                arrDirecciones=[],
                arrDatos=[];

            $(alias).each(function(index_alias, aliasSujeto){
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
            

            $(contacto).each(function(index_contacto,contactoSujeto){
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

            $(datos).each(function(index_datos, dato){
                const { estatus,id_nivel_escolaridad,id_lengua,id_religion,id_lgbttti,id_grupo_etnico,tipo_ocupacion,otra_escolaridad,otra_ocupacion,otra_religion,otro_grupo_etnico,otro_idioma_traductor,requiere_traductor,idioma_traductor,requiere_interprete,tipo_interprete,capacidades_diferentes,capacidad_diferente,poblacion,otra_poblacion,pertenece_grupo_etnico,entiende_idioma_espanol,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,id_escolaridad,nivel_escolaridad,lengua,nombre_religion,nombre_poblacion,grupo_etnico,id_datos_persona}=dato;
                const ocupacion = dato.tipo_ocupacion == null ? catalogo_ocupaciones[0].nombre_ocupacion : catalogo_ocupaciones[dato.tipo_ocupacion].nombre_ocupacion;
                const datosDatos={
                    id_datos_persona,
                    estatus,
                    id_nivel_escolaridad,
                    id_lengua,
                    id_religion,
                    id_lgbttti,
                    id_grupo_etnico,
                    tipo_ocupacion,
                    ocupacion,
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
                    nombre_poblacion,
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
                    grupo_etnico,
                };

                arrDatos.push(datosDatos);
            });

            $(direcciones).each(function(index_direccion, direccion){
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
                "nacionalidad":es_mexicano==null?'':es_mexicano=='no'?'extranjero':otra_nacionalidad==null?'mexicana':'mexicana_otro',
                "nacionalidad_text":es_mexicano==null?'':es_mexicano=='no'?'EXTRANJERO':otra_nacionalidad==null?'MEXICANA':'MEXICANA/OTRO',
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
                "datos":arrDatos,
                "direcciones":arrDirecciones
            };
            arrSujetosProcesales.push(sujetoProcesal); 
       });
      
       muestraSujetosProcesales();

       $(documentosGuardados).each(function(index_documento,documento){
        const {id_version,nombre_archivo,fecha_creacion,tamanio,extension,tipo_data,estatus,b64}=documento;
        datosDocumento={
          id: id_version,
          nombre_documento:nombre_archivo,
          extension:extension,
          tipo_data:tipo_data,
          tamanio:tamanio,
          estatus:estatus,
          fecha_creacion:fecha_creacion,
          b64:b64,
        }
        documentos.push(datosDocumento);
      });

      pintar_documentos();
      valores_default();
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
        // step++; //borrar
        // cambiarPantalla(); //borrar
        // console.log( step );
        // return false;
      $('.error').removeClass('error');
      const validacion=validaDatos();
      if(validacion==100){
        step++;
        cambiarPantalla();
      }else{
        const {campo , error} = validacion;
        if($('#'+campo).is('select')){
          $('#select2-'+campo+'-container').focus().addClass('error');
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

    $('#agregarAlias').click(function(){
      $('#datosAlias').append(`<div class="row datos-alias" data-status="1" data-id="-">
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
     
        $('#ocupacion').select2({minimumResultsForSearch: ''});
        $('#escolaridad').select2({minimumResultsForSearch: ''});
        $('#religion').select2({minimumResultsForSearch: ''});
        $('#grupo_etnico').select2({minimumResultsForSearch: ''});
        $('#capacidades_diferentes').select2({minimumResultsForSearch: Infinity});
        $('#lengua').select2({minimumResultsForSearch: ''});
        $('#sabe_leer_escribir').select2({minimumResultsForSearch: Infinity});
        $('#entiende_idioma_espanol').select2({minimumResultsForSearch: Infinity});
        $('#poblacion_callejera').select2({minimumResultsForSearch: Infinity});
        $('#poblacion').select2({minimumResultsForSearch: ''});
        $('#requiere_traductor').select2({minimumResultsForSearch: Infinity});
        $('#idioma_traductor').select2({minimumResultsForSearch: ''});
        $('#requiere_interprete').select2({minimumResultsForSearch: Infinity});
    });

    function get_unique_id(){
        var date = new Date();
        return date.getHours()+''+date.getMinutes()+''+date.getSeconds();
    }

    $('#agregarCorreo').click(function(){
      let inputID = get_unique_id();
      $('#correos').append(`<div class="row datos-correo" id="datos-correo${inputID}" data-status="1" data-id="-" data-index="-" data-unique="${inputID}">
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
      let inputID = get_unique_id();
      $('#domicilios').append(`<div class="row datos-domicilio" id="datos-domicilio${inputID}" data-status="1" data-id="-" data-index="-" data-unique="${inputID}">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-domicilio"></i></p>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label class="form-control-label">Estado: </label>
                                    <select class="form-control estado" name="estado" autocomplete="off" id="estado${inputID}">
                                        <option selected   value="">Elija una opción</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{$estado['id_estado']}}" data-cve-estado="{{$estado['cve_estado']}}">{{$estado['estado']}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label class="form-control-label">Municipio: </label>
                                    <select class="form-control municipio" name="municipio" autocomplete="off" id="municipio${inputID}">
                                        
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Localidad:</label>
                                    <input class="form-control localidad" type="text" name="localidad"  autocomplete="off" id="localidad${inputID}">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Calle:</label>
                                    <input class="form-control calle" type="text" name="calle" autocomplete="off" id="calle${inputID}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Número Exterior:</label>
                                    <input class="form-control numeroExterior" type="text" name="numero_exterior" autocomplete="off" id="numeroExterio${inputID}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Número Interior:</label>
                                    <input class="form-control numero_interior" type="text" name="numero_interior"  autocomplete="off" id="numeroInterior${inputID}">
                                  </div>
                                </div><!-- col-4-->
                                <div class="col-lg-9">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Colonia:</label>
                                    <input class="form-control colonia" type="text" name="colonia"  autocomplete="off" id="colonia${inputID}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-3">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Código Postal:</label>
                                    <input class="form-control codigoPostal" type="text" name="codigo_postal" autocomplete="off" id="codigoPostal${inputID}">
                                  </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-8">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Entre la Calle:</label>
                                    <input class="form-control entreCalle" type="text" name="entre_calle" autocomplete="off id="entreCalle${inputID}"">
                                  </div>
                                </div><!-- col-4-->
                                <div class="col-lg-12">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Otras Referencias:</label>
                                    <input class="form-control otrasReferencias" type="text" name="otras_referencias" autocomplete="off" id="otrasReferencias${inputID}">
                                  </div>
                                </div><!-- col-4-->
                              </div>`);
      $('#estado'+inputID).select2({minimumResultsForSearch: ''});
      $('#municipio'+inputID).select2({minimumResultsForSearch: ''});

      $('#estado'+inputID).on('change',function(){
        const selectMunicipio=$('#municipio'+inputID);
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
    });

    $('#agregarTelefono').click(function(){
      let inputID = get_unique_id();
      $('#telefonos').append(`<div class="row datos-telefono" id="datos-telefono${inputID}" data-status="1" data-id="-" data-index="-" data-unique="${inputID}">
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

    $('#datosAlias').on('click','.borrar-alias',function(){
      if($(this).parent().parent().parent().attr('data-index') != '-'){
        $(this).parent().parent().parent().attr('data-status','0');
        $(this).parent().parent().parent().addClass('d-none');
      }else{
        $(this).parent().parent().parent().remove();
      }
    });

    $('#correos').on('click','.borrar-correo',function(){
      if($(this).parent().parent().parent().attr('data-index') != '-' ){
        $(this).parent().parent().parent().attr('data-status','0');
        $(this).parent().parent().parent().addClass('d-none');
      }else{
        $(this).parent().parent().parent().remove();
      }
    });

    $('#telefonos').on('click','.borrar-telefono',function(){
      if($(this).parent().parent().parent().attr('data-index') != '-'){
        $(this).parent().parent().parent().attr('data-status','0');
        $(this).parent().parent().parent().addClass('d-none');
      }else{
        $(this).parent().parent().parent().remove();
      }
    });

    $('#domicilios').on('click','.borrar-domicilio',function(){
      if($(this).parent().parent().parent().attr('data-index') != '-' ){
        $(this).parent().parent().parent().attr('data-status','0');
        $(this).parent().parent().parent().addClass('d-none');
      }else{
        $(this).parent().parent().parent().remove();
      }
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

    function validaDatos(){
      switch(step){
        case 1:
          return (validaDatosPartes());
          break;
        case 2: 
          return (validaDatosRelatoHechos());
          break;
        case 3:
          return (validaDocumentacion());
      }
    }

    function validaDatosPartes(){
      
      if(!expRegFecha.test($('#fechaRecepcion').val())) return {'estatus':0,'campo':'fechaRecepcion','error':'Falta fecha de recepción o el formato es inválido'};

      if(!arrSujetosProcesales.length) return {'estatus':0,'campo':'-','error':'No ha agregado ningun sujeto procesal'};
      
      let flag_tipo_persona = false;

      $( arrSujetosProcesales ).each(function(index_sujeto,sujeto){
        console.log(sujeto.tipo_parte,sujeto.estatus);
        if( parseInt(sujeto.tipo_parte) ==46 && parseInt(sujeto.estatus)==1){ flag_tipo_persona = true;}
      });
      
      if( !flag_tipo_persona )return {'estatus':0,'campo':'-','error':'No ha agregado a ningun imputado'};
      //if(!arrSujetosProcesales.some(sujeto=>sujeto.tipo_parte==46 ))return {'estatus':0,'campo':'-','error':'No ha agregado a ningun imputado'};

      //if(!expRegHora.test($('#horaRecepcion').val())) return {'estatus':0,'campo':'horaRecepcion','error':'Falta la hora de recepción o el formato es inválido'};
      
      //if(expVacio.test($('#numeroCarpetaInvestigacion').val())) return {'estatus':0,'campo':'numeroCarpetaInvestigacion','error':'Falta el número de carpeta de investigación'};

      return 100; 
    }

    function validaDatosRelatoHechos(){
        if( !($('#relatoHechos').val()).length ) return {'estatus':0,'campo':'relatoHechos','error':'Debe ingresar el relato de cómo sucedieron los hechos'};
      return 100;
    }

    function validaDocumentacion(){
        return 100;
    }

    function cambiarPantalla(stepModal=''){
      if(stepModal=='modal'){
        step--;
      }
      switch(step){
        case 1:
          mostrarPartes();
          break;
        case 2: 
          mostrarRelatoHechos();
          break;
        case 3:
          mostrarDocumentacion();
          break;
      }
      
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

    function mostrarPartes(){
      $('#step-datos-partes').addClass('activo').removeClass('resuelto espera');
      $('#step-relato-hechos').addClass('espera').removeClass('activo resuelto');
      $('#div-datos-partes').removeClass('d-none');
      $('#div-datos-relato-hechos').addClass('d-none');
      $('#atras').attr('disabled', true);

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

    function mostrarRelatoHechos(){
      $('#step-datos-partes').addClass('resuelto').removeClass('espera activo');
      $('#step-relato-hechos').addClass('activo').removeClass('resuelto espera');
      $('#step-documentacion').addClass('espera').removeClass('resuelto activo');
      $('#div-datos-partes').addClass('d-none');
      $('#div-datos-relato-hechos').removeClass('d-none');
      $('#div-datos-documentacion').addClass('d-none');
      $('#atras').removeAttr('disabled');

      $('#siguiente').removeClass('d-none');
      $('#siguiente').removeClass('bd-0 d-inline-block');
      $('#btn-enviar-solicitud').addClass('d-none');
      $('#btn-enviar-solicitud').removeClass('bd-0 d-inline-block');
    }

    function mostrarDocumentacion(){
      $('#step-datos-partes').addClass('resuelto').removeClass('espera activo');
      $('#step-relato-hechos').addClass('resuelto').removeClass('espera activo');
      $('#step-documentacion').addClass('activo').removeClass('resuelto espera');
      $('#div-datos-partes').addClass('d-none');
      $('#div-datos-relato-hechos').addClass('d-none');
      $('#div-datos-documentacion').removeClass('d-none');
      
      $('#atras').removeAttr('disabled');

      $('#siguiente').addClass('d-none');
      $('#siguiente').removeClass('bd-0 d-inline-block');
      $('#btn-enviar-solicitud').removeClass('d-none');
      $('#btn-enviar-solicitud').removeClass('bd-0 d-inline-block');

      
    }

    /***********************************
     * 
     *  A G R E G A    S U J E T O 
     * 
     ***********************************/

    function agregarSujetoProcesal(){
      const aliasSujeto=[];
      const correos=[];
      const telefonos=[];
      const direcciones=[];
      const datosAdicionales=[];

      $('.datos-alias').each(function(){
        datos={
          id:"-",
          estatus: 1,
          alias:$(this).find('.alias').val(),
        }
        aliasSujeto.push(datos);
      });

      $('.datos-correo').each(function(){
        datos={
          id:"-",
          estatus: 1,
          correo:$(this).find('.correo-electronico').val(),
        }
        correos.push(datos);
      });

      $('.datos-telefono').each(function(){
        datos={
          id:"-",
          estatus: 1,
          tipo:$(this).find('.tipo-telefono').val(),
          numero:$(this).find('.numero-telefono').val(),
          extension:$(this).find('.extension').val(),
        }
        telefonos.push(datos);
      });

      $('.datos-domicilio').each(function(){
        let datosDireccion={
          "id":'-',
          "estatus": 1,
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

      const datoAdicional={
        id_datos_persona:"-",
        estatus:1,
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
      };

      datosAdicionales.push(datoAdicional);

      const sujetoProcesal={
        "origen": "interfaz",
        "id":"-",
        "estatus": 1,
        "tipo_parte":$('#tipoParte').val(),
        "tipo_parte_text":$('#tipoParte').find('option:selected').text(),
        "tipo_persona":$('#tipoPersona').val(),
        "tipo_persona_text":$('#tipoPersona').find('option:selected').text().toUpperCase(),
        "nacionalidad":$('#nacionalidad').val(),
        "nacionalidad_text":$('#nacionalidad').find('option:selected').text().toUpperCase(),
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
        "alias":aliasSujeto,
        "correos":correos,
        "telefonos":telefonos,
        "datos":datosAdicionales,
        "direcciones":direcciones,
      };
      arrSujetosProcesales.push(sujetoProcesal);
      console.log(arrSujetosProcesales);
      muestraSujetosProcesales();
     
    }

    /********************************************
     * 
     *  S U J E T O S      E N     T A B L A 
     * 
     ********************************************/

    function muestraSujetosProcesales(){
      let tableSujetosProcesales='';
      $(arrSujetosProcesales).each(function(index, datosSujeto){
        if(datosSujeto.estatus==1){
            const {tipo_parte,tipo_parte_text, nombre, apellido_paterno, apellido_materno,  razon_social, genero, genero_text} = datosSujeto;
            
            let strborrarSujeto = `<a href="javascript:void(0)" onclick="borrarSujeto(${index})"  data-toggle="tooltip" data-placement="a" title="Borrar" ><i class="icon ion-trash-a"></i></a>`;
            
            if( sujetoInputsProtegidos[ datosSujeto.id ] != undefined){
              strborrarSujeto = ``;
            }
             
            const sujeto= `<tr>
                            <td class="acciones"> 
                            <a href="javascript:void(0)" onclick="verSujeto(${index})"  data-toggle="tooltip" data-placement="a" title="Ver Detalles" ><i class="icon ion-person"></i></a>
                            ${strborrarSujeto}
                            </td>
                            <td class="tipo-parte">${tipo_parte_text}</td>
                            <td class="nombre">${razon_social}${nombre} ${apellido_paterno} ${apellido_materno}</td>
                            <td class="genero">${genero==null?'':genero_text}</td>
                        </tr>`;

            tableSujetosProcesales=tableSujetosProcesales.concat(sujeto);
        }
      });
      $('#tableSujetosProcesales').html(tableSujetosProcesales);
      console.log(arrSujetosProcesales);
    }

    /********************************************
     * 
     *  S U J E T O S      E N     M O D A L
     * 
     ********************************************/

    function verSujeto(index){
      
      //const {tipo_parte_text, nacionalidad, nacionalidad_text, curp, rfc, cedula_profesional, nombre, apellido_paterno, apellido_materno, razon_social, genero, genero_text, fecha_nacimiento, estado_civil, estado_civil_text, estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle,alias, correos, telefonos, datos, direcciones}=arrSujetosProcesales[index];
      //const {tipo_parte_text, nacionalidad, nacionalidad_text, curp, rfc, cedula_profesional, nombre, apellido_paterno, apellido_materno, razon_social, genero, genero_text, fecha_nacimiento, estado_civil, estado_civil_text, estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle, y_calle,alias, correos, telefonos, direcciones}=arrSujetosProcesales[index];
      const {alias,apellido_materno,apellido_paterno,cedula_profesional,correos,curp,datos,direcciones,edad,estado_civil,estado_civil_text,estatus,fecha_nacimiento,genero,genero_text,id,nacionalidad,nacionalidad_text,nombre,origen,otra_nacionalidad,razon_social,rfc,telefonos,tipo_parte,tipo_parte_text,tipo_persona,tipo_persona_text}=arrSujetosProcesales[index];
      
      let listaAlias='',
          listaCorreos='',
          listaTelefonos='',
          listaDirecciones='';

      $(alias).each(function(index_alias, ali){
          if( ali.estatus==1 ){
            li=`${ali.alias}<br>`;
            listaAlias=listaAlias.concat(li);
          }
      });

      $(correos).each(function(index_correo, correo){
          if( correo.estatus==1 ){
            li=`${correo.correo}<br>`;
            listaCorreos=listaCorreos.concat(li);
          }
      });

      $(telefonos).each(function(index_telefono, telefono){
          if( telefono.estatus == 1){
            li=`${telefono.tipo}: ${telefono.numero} ${telefono.extension==''?'':'ext '+telefono.extension}<br>`;
            listaTelefonos=listaTelefonos.concat(li);
          }
      });

      $(direcciones).each(function(index, direccion){
        if (direccion.estatus == 1){

          const {estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle}=direccion;
          const tableDireccion=`
                              <br>
                              <table class="dataTable" style="overflow-x: none; display: tableDatosSujeto" id="tableDatosSujeto3">
                                <thead>
                                  <tr>
                                    <th class="tx-center td-title" colspan="4" style="background:#f8f9fa">Domicilio ${index+1}</th>
                                    <th class="d-none"></th>
                                    <th class="d-none"></th>
                                    <th class="d-none"></th>
                                  </tr>
                                </thead>
                                <tbody class="table-datos-sujeto">
                                  <tr>
                                    <td class="td-title td-4col ">Calle</td>
                                    <td class="td-4col">${calle==null?'':calle}</td>
                                    <td class="td-title td-4col">Número Exterior</td>
                                    <td class="td-4col">${numero_exterior==null?'':numero_exterior}</td>
                                  </tr>
                                  <tr>
                                    <td class="td-title td-4col">Número Interior</td>
                                    <td class="td-4col">${numero_interior==null?'':numero_interior}</td>
                                    <td class="td-title td-4col">Localidad</td>
                                    <td class="td-4col">${localidad==null?'':localidad}</td>
                                  </tr>
                                  <tr>
                                    <td class="td-title td-4col">Colonia</td>
                                    <td class="td-4col">${colonia==null?'':colonia}</td>
                                    <td class="td-title td-4col">Municipio</td>
                                    <td class="td-4col">${municipio_text==null?'':municipio_text}</td>
                                  </tr>
                                  <tr>
                                    <td class="td-title td-4col">Estado</td>
                                    <td class="td-4col">${estado_text==null?'':estado_text}</td>
                                    <td class="td-title td-4col">Entre Calle y Calle</td>
                                    <td class="td-4col">${entre_calle==null?'':entre_calle}</td>
                                  </tr>
                                  <tr>
                                    <td class="td-title td-4col">Otras Referencias</td>
                                    <td class="td-4col">${otra_referencia==null?'':otra_referencia}</td>
                                  </tr>
                                </tbody>
                              </table> `;

          listaDirecciones=listaDirecciones.concat(tableDireccion);
        }
      });
    
      const {capacidad_diferente,capacidades_diferentes,descripcion_discapacidad,entiende_idioma_espanol,estatus_datos_adicionales,grupo_etnico,id_datos_persona,id_escolaridad,id_grupo_etnico,id_lengua,id_lgbttti,id_nivel_escolaridad,id_religion,idioma_traductor,lengua,nivel_escolaridad,nombre_poblacion,nombre_religion,otra_escolaridad,otra_ocupacion,otra_poblacion,otra_religion,otro_grupo_etnico,otro_idioma_traductor,pertenece_grupo_etnico,poblacion,poblacion_callejera,requiere_interprete,requiere_traductor,sabe_leer_escribir,tipo_interprete,tipo_ocupacion,ocupacion}=arrSujetosProcesales[index].datos[0];
      const table= `<table class="dataTable" style="overflow-x: none; display: tableDatosSujeto" id="tableDatosSujeto">
                      <tbody class="table-datos-sujeto">
                        <tr>
                          <td class="td-title">Calidad Jurídica</td>
                          <td>${tipo_parte_text}</td>
                          <td class="td-title">Ocupación</td>
                          <td>${ocupacion==null?'': ocupacion}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Nombre ó Razón Social</td>
                          <td>${razon_social}${nombre} ${apellido_paterno} ${apellido_materno}</td>
                          <td class="td-title">Otra Ocupación</td>
                          <td>${otra_ocupacion==null?'':otra_ocupacion}</td>
                        </tr>
                        <tr>
                          <td class="td-title">RFC</td>
                          <td>${rfc}</td>
                          <td class="td-title">Escolaridad</td>
                          <td>${nivel_escolaridad==null?'':nivel_escolaridad}</td>
                        </tr>
                        <tr>
                          <td class="td-title">CURP</td>
                          <td>${curp}</td>
                          <td class="td-title">Otra Escolaridad</td>
                          <td>${otra_escolaridad==null?'':otra_escolaridad}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Cédula Profesional</td>
                          <td>${cedula_profesional}</td>
                          <td class="td-title">Religión</td>
                          <td>${nombre_religion==null?'':nombre_religion}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Género</td>
                          <td>${genero==''?'':genero==null?'':genero_text}</td>
                          <td class="td-title">Otra Religión</td>
                          <td>${otra_religion==null?'':otra_religion}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Fecha de Nacimiento</td>
                          <td>${fecha_nacimiento}</td>
                          <td class="td-title">Grupo Étnico</td>
                          <td>${grupo_etnico==null?'':grupo_etnico}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Nacionalidad</td>
                          <td>${nacionalidad==''?'':nacionalidad==null?'':nacionalidad_text}</td>
                          <td class="td-title">Otra Nacionalidad</td>
                          <td>${otra_nacionalidad==null?'':otra_nacionalidad}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Estado Civíl</td>
                          <td>${estado_civil==''?'':estado_civil==null?'':estado_civil_text}</td>
                          <td class="td-title">Lengua</td>
                          <td>${lengua==null?'':lengua}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Capacidad Diferente</td>
                          <td>${capacidades_diferentes==null?'':capacidades_diferentes}</td>
                          <td class="td-title">Discapacidad</td>
                          <td>${descripcion_discapacidad==null?'':descripcion_discapacidad}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Sabe Leer y Escribir</td>
                          <td>${sabe_leer_escribir==null?'':sabe_leer_escribir}</td>
                          <td class="td-title">Población Callejera</td>
                          <td>${poblacion_callejera==null?'':poblacion_callejera}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Población</td>
                          <td>${poblacion==null?'':nombre_poblacion}</td>
                          <td class="td-title">Otra Población</td>
                          <td>${otra_poblacion==null?'':otra_poblacion}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Nombre Población</td>
                          <td>${nombre_poblacion==null?'':nombre_poblacion}</td>
                          <td class="td-title">Entiende el Idioma Español</td>
                          <td>${entiende_idioma_espanol==null?'':entiende_idioma_espanol}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Requiere Intérprete</td>
                          <td>${requiere_interprete==null?'':requiere_interprete}</td>
                          <td class="td-title">Tipo de Intérprete</td>
                          <td>${tipo_interprete==null?'':tipo_interprete}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Requiere Traductor</td>
                          <td>${requiere_traductor==null?'':requiere_traductor}</td>
                          <td class="td-title">Idioma del Traductor</td>
                          <td>${idioma_traductor==null?'':idioma_traductor}</td>
                        </tr>
                        <tr>
                          <td class="td-title">Otro Idioma del Traductor</td>
                          <td>${otro_idioma_traductor==null?'':otro_idioma_traductor}</td>
                        </tr>
                      </tbody>
                    </table>
                    <br>
                    <table  class="dataTable tableDatosSujeto" id="tableDatosSujeto2"style="overflow-x: none; display: table">
                      <thead>
                        <tr>
                          <th class="tx-center td-title">Teléfonos</th>
                          <th class="tx-center td-title">Correos</th>
                          <th class="tx-center td-title">Alias</th>
                        </tr>
                      </thead>
                      <tbody class="table-datos-sujeto">
                        <tr>
                          <td>${listaTelefonos==''?'<span class="tx-italic">Sin teléfonos registrados</span>':listaTelefonos}</td>
                          <td>${listaCorreos==''?'<span class="tx-italic">Sin correos registrados</span>':listaCorreos}</td>
                          <td>${listaAlias==''?'<span class="tx-italic">Sin alias registrados</span>':listaAlias}</td>
                        </tr>
                      </tbody>
                    </table>
                    ${listaDirecciones} `;
      $('#titleSujeto').html('Datos del Sujeto Procesal');
      $('#divDatosSujeto').html(table).css({"overflow-x": "none", "display": "block"});
      $('#divEditarDelito').html(`<button class="btn btn-primary d-inline-block" data-dismiss="modal" id="editarSujeto" onclick="editarSujeto(${index})">Editar</button>`).css({"margin-left": "auto"});
      $('#modalDatosSujeto').modal('show');
    }

    /***********************************
     * 
     *  B O R R A R    S U J E T O 
     * 
     ***********************************/

    function borrarSujeto(index_delete){
        let clearedArray = [];
        $(arrSujetosProcesales).each(function(index, sujeto){
          if ( index != index_delete ){
            clearedArray.push(sujeto);    
          }else{
              if(sujeto.id != '-'){
                  sujeto.estatus = 0;
                  clearedArray.push(sujeto);
              }
          }
        });

        arrSujetosProcesales = clearedArray;
        muestraSujetosProcesales();
    }

    /**************************************************
     * 
     *  C A R G A     S U J E T O     A   E D I T A R
     * 
     **************************************************/

    function editarSujeto(index){
      //const {tipo_parte, tipo_persona, nacionalidad,otra_nacionalidad, curp, rfc, cedula_profesional, nombre, apellido_paterno, apellido_materno, razon_social, genero, fecha_nacimiento, estado_civil, estado, municipio , colonia, localidad,codigo_postal,calle,numero_exterior, numero_interior, otra_referencia, entre_calle,alias, correos, telefonos,  edad, cve_estado}=arrSujetosProcesales[index];
      //const {tipo_parte, tipo_persona, nacionalidad,otra_nacionalidad, curp, rfc, cedula_profesional, nombre, apellido_paterno, apellido_materno, razon_social, genero, fecha_nacimiento, estado_civil, direcciones, alias, correos, telefonos, edad,id, datos}=arrSujetosProcesales[index];
      
      const {tipo_parte, tipo_persona, nacionalidad,otra_nacionalidad, curp, rfc, cedula_profesional, nombre, apellido_paterno, apellido_materno, razon_social, genero, fecha_nacimiento, estado_civil, direcciones, alias, correos, telefonos, edad,id, datos}=arrSujetosProcesales[index];
      
      $('#persona').val(id);
    
      console.log(nacionalidad,tipo_parte);

      if($('#tipoParte').hasClass('select2-hidden-accessible')){
        $('#tipoParte').select2('destroy');
        $('#tipoParte').val(tipo_parte); 
      }
      setTimeout(()=>{
        $('#tipoParte').select2({minimumResultsForSearch: ''});    
      },200);
      $('#tipoParte').change(); 
      
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
      $('#tipoPersona').change();
      
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
      $('#nacionalidad').change();

      
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
      $('#escolaridad').val( id_nivel_escolaridad != null ? id_nivel_escolaridad : '10'  ).select2({minimumResultsForSearch: Infinity});
      $('#sabe_leer_escribir').val( sabe_leer_escribir != null ? sabe_leer_escribir : 'No Aplica'  ).select2({minimumResultsForSearch: Infinity});
      $('#entiende_idioma_espanol').val( entiende_idioma_espanol != null ? entiende_idioma_espanol : 'No Aplica'  ).select2({minimumResultsForSearch: Infinity});
      $('#poblacion_callejera').val( poblacion_callejera != null ? poblacion_callejera : 'No Aplica'  ).select2({minimumResultsForSearch: Infinity});
      $('#requiere_interprete').val( requiere_interprete != null ? requiere_interprete : 'No Aplica'  ).select2({minimumResultsForSearch: Infinity});
      $('#requiere_traductor').val( requiere_traductor != null ? requiere_traductor : 'No Aplica'  ).select2({minimumResultsForSearch: Infinity});
      $('#ocupacion').val( tipo_ocupacion != null ? tipo_ocupacion :  '0' ).select2({minimumResultsForSearch: ''});
      $('#religion').val( id_religion != null ? id_religion :  '34' ).select2({minimumResultsForSearch: ''});
      $('#grupo_etnico').val( id_grupo_etnico != null ? id_grupo_etnico : '888'  ).select2({minimumResultsForSearch: ''});
      $('#capacidades_diferentes').val( capacidades_diferentes != null ? capacidades_diferentes :  'No Aplica' ).select2({minimumResultsForSearch: ''});
      $('#lengua').val( id_lengua != null ? id_lengua :  '888' ).select2({minimumResultsForSearch: ''});
      $('#poblacion').val( id_lgbttti != null ? id_lgbttti :  '9' ).select2({minimumResultsForSearch: ''});
      $('#idioma_traductor').val( idioma_traductor  ).select2({minimumResultsForSearch: ''});
      // $('#escolaridad').val(id_nivel_escolaridad).select2({minimumResultsForSearch: Infinity});
      // $('#sabe_leer_escribir').val(sabe_leer_escribir).select2({minimumResultsForSearch: Infinity});
      // $('#entiende_idioma_espanol').val(entiende_idioma_espanol).select2({minimumResultsForSearch: Infinity});
      // $('#poblacion_callejera').val(poblacion_callejera).select2({minimumResultsForSearch: Infinity});
      // $('#requiere_interprete').val(requiere_interprete).select2({minimumResultsForSearch: Infinity});
      // $('#requiere_traductor').val(requiere_traductor).select2({minimumResultsForSearch: Infinity});
      // $('#ocupacion').val(tipo_ocupacion).select2({minimumResultsForSearch: ''});
      // $('#religion').val(id_religion).select2({minimumResultsForSearch: ''});
      // $('#grupo_etnico').val(id_grupo_etnico).select2({minimumResultsForSearch: ''});
      // $('#capacidades_diferentes').val(capacidades_diferentes).select2({minimumResultsForSearch: ''});
      // $('#lengua').val(id_lengua).select2({minimumResultsForSearch: ''});
      // $('#poblacion').val(id_lgbttti).select2({minimumResultsForSearch: ''});
      // $('#idioma_traductor').val(idioma_traductor).select2({minimumResultsForSearch: ''});

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
        $(alias).each(function(index_alias, ali){
          sAlias=sAlias.concat(`<div class="row datos-alias ${ali.estatus==0?'d-none':''}" data-id="${ali.id}" data-status="${ali.estatus}" data-indexp="${index}">
                                <div class="col-12">
                                  <p class="tx-right tx-danger"><i class="fa fa-close borrar-alias"></i></p>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group mg-b-10-force">
                                    <label class="form-control-label">Alias:</label>
                                    <input class="form-control alias" type="text" name="alias" autocomplete="off" value="${ali.alias}" data-indexp="${index}">
                                  </div>
                                </div><!-- col-3-->
                              </div>`);
        });
        $('#datosAlias').html(sAlias);
      }

      if(correos.length){
        sCorreos='';
        $(correos).each(function(index_correo, correo){
          sCorreos=sCorreos.concat(`<div class="row datos-correo ${correo.estatus==0?'d-none':''}"  data-id="${correo.id}" data-status="${correo.estatus}" data-indexp="${index}">
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
        $(telefonos).each(function(index_telefono, telefono){
          sTelefonos=sTelefonos.concat(`<div class="row datos-telefono ${telefono.estatus==0?'d-none':''}"  data-id="${telefono.id}" data-status="${telefono.estatus}" data-indexp="${index}">
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

        if(direcciones.length){
            sDirecciones='';
            $(direcciones).each(function(index_direcciones, direccion){
            let inputID = get_unique_id();
            const {estado, municipio , colonia, localidad,codigo_postal,calle,numero_exterior, numero_interior, otra_referencia, entre_calle,alias, correos, telefonos,  edad, cve_estado, id, estatus}=direccion;
            
            
            let estados='<option>Elija una opción</option>';
            
            $(catalogoEstados).each(function(index_estados, datosEstado){
            
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
                    
                    $(response.response).each(function(index_municipio, datosMunicipio){

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
                                <div class="row datos-domicilio ${estatus==0?'d-none':''}"  data-id="${id}" data-status="${estatus}" data-indexp="${index}">
                                    <div class="col-12">
                                    <p class="tx-right tx-danger"><i class="fa fa-close borrar-domicilio" data-index="${index_direcciones}" data-indexp="${index}"></i></p>
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Estado: </label>
                                        <select class="form-control estado" name="estado" autocomplete="off" id="estado${inputID}">
                                            ${estados}
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Municipio: </label>
                                        <select class="form-control municipio" name="municipio" autocomplete="off" id="municipio${inputID}">
                                            ${municipios}
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Localidad:</label>
                                        <input class="form-control localidad" type="text" name="localidad"  autocomplete="off" value="${localidad==null?'':localidad}" id="localidad${inputID}">
                                    </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Calle:</label>
                                        <input class="form-control calle" type="text" name="calle" autocomplete="off"  value="${calle==null?'':calle}" id="calle${inputID}">
                                    </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-3">
                                    <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Número Exterior:</label>
                                        <input class="form-control numeroExterior" type="text" name="numero_exterior" autocomplete="off" value="${numero_exterior==null?'':numero_exterior}" id="numeroExterior${inputID}">
                                    </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-3">
                                    <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Número Interior:</label>
                                        <input class="form-control numero_interior" type="text" name="numero_interior"  autocomplete="off"  value="${numero_interior==null?'':numero_interior}" id="numeroInterior${inputID}">
                                    </div>
                                    </div><!-- col-4-->
                                    <div class="col-lg-9">
                                    <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Colonia:</label>
                                        <input class="form-control colonia" type="text" name="colonia"  autocomplete="off"  value="${colonia==null?'':colonia}" id="colonia${inputID}">
                                    </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-3">
                                    <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Código Postal:</label>
                                        <input class="form-control codigoPostal" type="text" name="codigo_postal" autocomplete="off" value="${codigo_postal==null?'':codigo_postal}" id="codigoPostal${inputID}">
                                    </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-12">
                                    <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Entre la Calle:</label>
                                        <input class="form-control entreCalle" type="text" name="entre_calle" autocomplete="off"  value="${entre_calle==null?'':entre_calle}" id="entreCalle${inputID}">
                                    </div>
                                    </div><!-- col-4-->
                                    <div class="col-lg-12">
                                    <div class="form-group mg-b-10-force">
                                        <label class="form-control-label">Otras Referencias:</label>
                                        <input class="form-control otrasReferencias" type="text" name="otras_referencias" autocomplete="off"  value="${otra_referencia==null?'':otra_referencia}" id="otrasReferencias${inputID}">
                                    </div>
                                    </div><!-- col-4-->
                                </div>
                `);
                $('#domicilios').html(sDirecciones);
            },500);
            setTimeout(function(){
                $('#estado'+inputID).select2({minimumResultsForSearch: ''});
                $('#municipio'+inputID).select2({minimumResultsForSearch: ''});

                $('#estado'+inputID).on('change',function(){
                    const selectMunicipio=$('#municipio'+inputID);
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
            },600);
            });
        }

      $('#botonesPartes').append(`<button type="button" class="btn btn-secondary d-inline-block btn-edicion mg-l-auto" onclick="limpiarCamposSujetos()">Cancelar</button>
                                  <button class="btn btn-primary d-inline-block   btn-edicion mg-l-5"  onclick="editarDatosSujeto(${index})">Guardar Edición</button>`);
      $('#agregarParte').addClass('d-none').removeClass('d-inline-block');
      // setTimeout(function(){ inhabilita_datos_protegidos( index) ; }, 700);
    }

    /*******************************************
     * 
     *  E D I T A R     D A T O S   S U J E T O 
     * 
     ********************************************/
    function editarDatosSujeto(indexEditado){
      const alias=[],
            correos=[],
            telefonos=[],
            datosAdicionales=[],
            direcciones=[];

      $('.datos-alias').each(function(){
        datos={
          id: $(this).attr('data-id')!='-' ? parseInt( $(this).attr('data-id') ) : '-',
          estatus: parseInt( $(this).attr('data-status') ),
          alias:$(this).find('.alias').val(),
        }
        alias.push(datos);
      });

      $('.datos-correo').each(function(){
        datos={
          id: $(this).attr('data-id')!='-' ? parseInt( $(this).attr('data-id') ) : '-',
          estatus: parseInt( $(this).attr('data-status') ),
          correo:$(this).find('.correo-electronico').val(),
        }
        correos.push(datos);
      });

      $('.datos-telefono').each(function(){
        datos={
          id: $(this).attr('data-id')!='-' ? parseInt( $(this).attr('data-id') ) :'-',
          estatus: parseInt( $(this).attr('data-status') ),
          tipo:$(this).find('.tipo-telefono').val(),
          numero:$(this).find('.numero-telefono').val(),
          extension:$(this).find('.extension').val(),
        }
        telefonos.push(datos);
      });

      $('.datos-domicilio').each(function(){
        const datosDireccion={
          "id": $(this).attr('data-id')!='-' ? parseInt( $(this).attr('data-id') ) : '-',
          "estatus": parseInt( $(this).attr('data-status') ),
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

      const datoAdicional={
        id_datos_persona: arrSujetosProcesales[indexEditado].datos[0].id_datos_persona,
        estatus:  arrSujetosProcesales[indexEditado].datos[0].estatus,
        id_nivel_escolaridad:$('#escolaridad').val(),
        id_escolaridad:$('#escolaridad').val(),
        nivel_escolaridad:$('#escolaridad').val()==''?'':$('#escolaridad').find('option:selected').text(),
        otra_escolaridad:$('#otra_escolaridad').val(),
        id_lengua:$('#lengua').val(),
        lengua:$('#lengual').val()!=''?$('#lengual').find('option:selected').text():'',
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
        capacidad_diferente:$('#capacidad_diferente').val(),
        poblacion:$('#poblacion').val(),
        otra_poblacion:$('#otra_poblacion').val(),
        pertenece_grupo_etnico:$('#grupo_etnico').val()==''?'si':'no',
        entiende_idioma_espanol:$('#entiende_idioma_espanol').val(),
        descripcion_discapacidad:"",
        sabe_leer_escribir:$('#sabe_leer_escribir').val(),
        poblacion_callejera:$('#poblacion_callejera').val(),
      };

      datosAdicionales.push(datoAdicional);
      
      const sujetoProcesal={
        "id":$('#persona').val()!='-' ? parseInt( $('#persona').val() ) : '-',
        "estatus":1,
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
        "datos":datosAdicionales,
        "direcciones":direcciones,
      };
      arrSujetosProcesales[indexEditado]=sujetoProcesal;

      $('#tipoParte').select2('destroy');
      $('#otraNacionalidad').select2('destroy');
      $('#estado').select2('destroy');
      $('#municipio').select2('destroy');
      muestraSujetosProcesales();
      limpiarCamposSujetos();
      
    }

    /*******************************************
     * 
     *  L I M P I A R       F O R M U L A R I O 
     *  
     ********************************************/

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

      // Info principal
	    $('#tipoParte').val('').prop('disabled',false);
      $('#tipoPersona').val('').prop('disabled',false);
      $('#nacionalidad').val('').prop('disabled',false);
      $('#curp').prop('disabled',false);
      $('#rfc').prop('disabled',false);
      $('#cedulaProfesional').prop('disabled',false);
      $('#nombre').prop('disabled',false);
      $('#apellidoPaterno').prop('disabled',false);
      $('#apellidoMaterno').prop('disabled',false);
      $('#genero').prop('disabled',false);
      $('#estadoCivil').prop('disabled',false);
      $('#fechaNacimiento').prop('disabled',false);
      $('#edad').prop('disabled',false);
      $('#razonSocial').prop('disabled',false);
      
      // Datos adicionales
      $('#escolaridad').prop('disabled',false);
      $('#sabe_leer_escribir').prop('disabled',false);
      $('#entiende_idioma_espanol').prop('disabled',false);
      $('#poblacion_callejera').prop('disabled',false);
      $('#requiere_interprete').prop('disabled',false);
      $('#requiere_traductor').prop('disabled',false);
      $('#ocupacion').prop('disabled',false);
      $('#religion').prop('disabled',false);
      $('#capacidades_diferentes').prop('disabled',false);
      $('#grupo_etnico').prop('disabled',false);
      $('#lengua').prop('disabled',false);
      $('#poblacion').prop('disabled',false);
      $('#idioma_traductor').prop('disabled',false);

      $('#otra_religion').val('').attr('disabled',true);
      $('#otro_grupo_etnico').val('').attr('disabled',true);
      $('#otra_ocupacion').val('').attr('disabled',true);
      $('#otro_idioma_traductor').val('').attr('disabled',true);
      $('#tipo_interprete').val('').attr('disabled',true);
      $('#otra_poblacion').val('').attr('disabled',true);
      $('#persona').val('-');
      $('#agregarParte').removeClass('d-none').addClass('d-inline-block');
      $('.btn-edicion').remove();

      $('#agregarParte').removeClass('d-none').addClass('d-inline-block');
      $('.btn-edicion').remove();

      valores_default();
    }

    function valores_default(){
      // valores por defecto 
      $('#escolaridad').val('10').change();
      $('#sabe_leer_escribir').val('No Aplica').change();
      $('#entiende_idioma_espanol').val('No Aplica').change();
      $('#poblacion_callejera').val('No Aplica').change();
      $('#requiere_interprete').val('No Aplica').change();
      $('#requiere_traductor').val('No Aplica');
      $('#ocupacion').val('0').change();
      $('#religion').val('34').change();
      $('#capacidades_diferentes').val('No Aplica').change();
      $('#grupo_etnico').val('888').change();
      $('#lengua').val('888').change();
      $('#poblacion').val('9').change();
    }
 

    $('#div-view-archivos').on('click','.borrar_documento',function(){
      
      let clearedArray = [];
      let index_deleted = $(this).data('indexdocumento');

      console.log("borrar index doc : "+ index_deleted);

      $(documentos).each(function(index, archivo){
        if ( index != index_deleted ){
          clearedArray.push(archivo);    
        }else{
          if( archivo.id != '-' ){
            archivo.estatus = 0;
            clearedArray.push(archivo);
          }
        }
      });
 
      documentos = clearedArray;
      pintar_documentos();
    });

    function get_tipo_data(extension){
      if( extension == 'pdf' || extension == 'PDF' ) return 'data:application/pdf;base64,';
      if( extension == 'jpg' || extension == 'JPG' ) return 'data:image/jpeg;base64,';
      if( extension == 'png' || extension == 'PNG' ) return 'data:image/png;base64,';
      if( extension == 'doc' || extension == 'DOC' ) return '';
      if( extension == 'docx' || extension == 'DOCX' ) return '';
    }
    
    function refresca_nombres_documentos(){
      $(".nombre_documento").each(function(){
        documentos[ $(this).data('indexdocumento') ].nombre_documento = ($(this).val()).replaceAll(' ', '_');
      });
    }

    function pintar_documentos(){
      console.log("Pinta documentos");
      $('#div-view-archivos div').remove();
      let reader_files=["pdf","png","jpg","PDF","PNG","JPG"];

      $(documentos).each(function(index, documento){

        if( documento.estatus == 1){

          if ( reader_files.includes(documento.extension) ) {

            $('#div-view-archivos').append(`
            <div class="col-sm-3 datos-documento" span="3" data-id="${documento.id}">
                <div class="row justify-content-center">
                  <div class="col align-self-center" align="center">
                      <p class="tx-center tx-danger"><i class="fa fa-times-circle size-2x custom-x borrar_documento" data-indexdocumento="${index}" style="right: -85px !important;"></i></p>
                      <div style="height:150px; width:170px; border-style: solid; border-color: rgba(206, 212, 218, 0.38); border-radius: 10px; border-width: 10px;">
                       <object width="150px" height="100px" class="mg-t-25" data="${documento.tipo_data+documento.b64}"></object>
                      </div>
                  </div>
                </div>
                <div class="row justify-content-center" align="center">
                  <div class="col align-self-center">
                      <div class="form-group mg-b-10-force">
                        <br>
                        <label id="lbl-nom-doc-${index}">${documento.nombre_documento}</label><span id="lbl-ext-doc-${index}">.${documento.extension}</span>
                        <input id="edit-nom-doc-${index}" class="form-control d-none nombre_documento" type="text" data-indexdocumento="${index}" name="nombre_archivo" autocomplete="off" value="${documento.nombre_documento}">
                      </div>
                  </div>
                </div>
            </div>`);
          }else{
            $('#div-view-archivos').append(`
            <div class="col-sm-3 datos-documento" span="3" data-id="${documento.id}">
                <div class="row justify-content-center" align="center">
                  <div class="col align-self-center">
                    <p class="tx-center tx-danger"><i class="fa fa-times-circle size-2x custom-x borrar_documento" data-indexdocumento="${index}" style="right: -35px !important;"></i></p>
                    <div style="height:150px; width:170px;border: 10px rgba(206, 212, 218, 0.38); border-radius: 10px; border-width: 10px;">
                      <i class="icon ion-document-text ion-10x"></i>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center" align="center">
                  <div class="col align-self-center">
                      <div class="form-group mg-b-10-force">
                        <br>
                        <label id="lbl-nom-doc-${index}">${documento.nombre_documento}</label><span id="lbl-ext-doc-${index}">.${documento.extension}</span>
                        <input id="edit-nom-doc-${index}" class="form-control d-none nombre_documento" type="text" data-indexdocumento="${index}" name="nombre_archivo" autocomplete="off" value="${documento.nombre_documento}">
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
            $(this).val( ($(this).val()).replaceAll(' ', '_') );
            $("#lbl-nom-doc-"+index).text( ($(this).val()).replaceAll(' ', '_') );
            $("#lbl-nom-doc-"+index).removeClass('d-none');
            $("#lbl-ext-doc-"+index).removeClass('d-none');
            $(this).addClass('d-none');
          });
        }
      });

      // setTimeout(function(){ inhabilitacion_default(); }, 500); // aquí se inhabilita edicion de campos
    }

    function leeDocumento (input) {
      let acepted_files=["pdf","png","jpg","docx","doc","PDF","PNG","JPG","DOCX","DOC"];

      let file = $('#archivoPDF').val();
      let ext = "";
      let extension = "";
      let nombre_documento = "";

      let date = new Date();
      let today = date.getDay()+'-'+date.getMonth()+'-'+date.getYear()+' '+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();

      if(file.length){
       ext = file.substring(file.lastIndexOf("."));
       extension = file.split('.')[1];
       extension = extension.toLowerCase();
       nombre_documento = (file.split('\\')[2]).split('.')[0];
       nombre_documento = nombre_documento.replaceAll(' ', '_');
       nombre_documento = nombre_documento.replaceAll('  ', '_');
       if(ext!=''){
          if( !acepted_files.includes(extension) ){
            alert('Solo puede adjutar archivos PDF, PNG, JPG, DOC, DOCX');
            $('#archivoPDF').val('');
            return false
          }else{
            if (input.files && input.files[0]) {
              let reader = new FileReader();
              reader.onload = e=> {
                documentos.push({
                  'id' : '-',
                  'nombre_documento':nombre_documento,
                  'extension':extension,
                  'tipo_data': get_tipo_data(extension),
                  'tamanio':input.files[0].size/1024,
                  'estatus':1,
                  'fecha_creacion': today,
                  'b64' : e.target.result.split('base64,')[1],
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
    
    function enviarSolicitud(){
      $('#modal_loading').modal('show');

      if( !documentos.length ){
        $('#bSocumento').focus().addClass('error');
        $('#messageError').html(`No ha agregago su documento PDF`);
        $('#modalError').modal('show');
      }else{
        const fechaRecepcion=$('#fechaRecepcion').val().split('-');
        console.log("entraste enviar solicitud");
        console.log("fecha_recepcion :"+ fechaRecepcion);
        console.log("sp :", arrSujetosProcesales);
        console.log("h :"+ $("#relatoHechos").val());
        console.log("docs", documentos);

        refresca_nombres_documentos();

        $.ajax({
          type:'POST',
          url:'/public/promujer_actualiza_solicitud',
          //dataType: "json",
          //cache: false,
          //contentType: false,
          //processData: false,
          data:{
            fecha_recepcion:fechaRecepcion[2]+'-'+fechaRecepcion[1]+'-'+fechaRecepcion[0],
            hora_recepcion:$('#horaRecepcion').val()+':00',
            sujetos_procesales:arrSujetosProcesales,
            relato_hechos:$("#relatoHechos").val(),
            documentos:documentos,
            id_solicitud: '{{$id_solicitud}}'
          },
          success:function(response){
            console.log(response);
            if(response.status==100){
              $("#datos-respuesta-solicitud").text("Actualizacion realizada exitosamente");
              $('#modalSuccess').modal('show');
            }else{
              $('#messageError').html(`Ocurrió un error :`+response.message);
              $('#modalError').modal('show');
            }

            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 500);
            
          },
          error: function( errorTrown){
            console.log("error : ", errorTrown);
            setTimeout(function(){
                $('#modal_loading').modal('hide');
            }, 500);
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
  
  <div id="modalDatosSujeto" class="modal fade">
    <div class="modal-dialog modal-lg mg-b-100" role="document" style="width: -webkit-fill-available;">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="titleSujeto">Datos</span> del Sujeto Procesal</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" align="center">
          <div id="divDatosSujeto" align="center" style="display:block !important;"> 

          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <div id="divEditarDelito">

          </div>
          <button type="button" class="btn btn-secondary d-inline-block mg-l-auto" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  <div id="modalSuccess" class="modal fade"  data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog" role="document">
      <div class="modal-content tx-size-sm">
        <div class="modal-header pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><span id="">Solicitud Actualizada</h6>
        </div>
        <div class="modal-body tx-center pd-y-20 pd-x-20">
          <div id="datos-respuesta-solicitud" align="left">

          </div>
        </div><!-- modal-body -->
        <div class="modal-footer d-flex">
          <button type="button" class="btn btn-primary pd-x-25 mg-l-auto" data-dismiss="modal" aria-label="Close" onclick="window.location.replace(`{{url('/consulta_promujer')}}`)">Aceptar</button>
        </div>
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

@endsection