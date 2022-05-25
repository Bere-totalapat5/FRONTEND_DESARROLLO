{{-- P A R T E S   P R O C E S A L E S--}}
<div class="form-layout">
  <div class="row mg-b-25">
    <br>
    {{-- T O G G L E    P A R T E S --}}
    <div class="col-lg-12">
      <br><br>
      <h5 class="form-control-label"> Partes Procesales </h5>
      <hr/>
      <div class="row" id="divPartesProcesales">
      </div>
    </div>

    <hr/>

    <div class="col-lg-12">
      @if( isset($permisos[85]) and $permisos[85] == 1 )
        <div id="accordionNuevaParteProcesal" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
          <div class="card bkgd-card">

            <div class="card-header bkg-card-header " role="tab" id="headingOne">
              <a id="titleAccordionNuevaParteProcesal" data-toggle="collapse" data-parent="#accordionNuevaParteProcesal" href="#collapseOneNuevaParteProcesal" aria-expanded="true" aria-controls="collapseOneNuevaParteProcesal" class="bkg-collapsed-btn tx-gray-800 transition collapsed tx-white">
                Agregar parte
              </a>
            </div>

            <div id="collapseOneNuevaParteProcesal" class="collapse" role="tabpanel" aria-labelledby="headingOneNuevaParteProcesal">
              <div class="card-body">
                <div class="row">
                  <input type="hidden" name="id_persona" id="id_persona" value="">

                  <div class="col-lg-4">
                    <div class="form-group">
                      <input type="hidden" id="persona" value="-">
                      <label class="form-control-label">Calidad Jurídica: <span class="tx-danger">*</span></label>
                      <select class="form-control select2" id="tipoParte" name="tipo_parte" autocomplete="off">
                          <option selected disabled value="">Elija una opción</option>
                          @foreach ($calidad_juridica as $calidad)
                            @if( in_array($calidad['id_calidad_juridica'], [47,4,29,43,52,1,10006,46,10003,10004,10005,10001,10002,10000,49,6,3,10007,2]))
                              <option value="{{$calidad['id_calidad_juridica']}}">{{$calidad['calidad_juridica']}}</option>
                            @endif
                          @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label">Tipo Persona: <span class="tx-danger">*</span></label>
                      <select class="form-control select2" id="tipoPersona" name="tipo_persona" autocomplete="off">
                          <option selected disabled value="">Elija una opción</option>
                          <option value="fisica">FÍSICA</option>
                          <option value="moral">MORAL</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-4 fisica">
                    <div class="form-group">
                      <label class="form-control-label">Identificación: </label>
                      <select class="form-control select2" id="identificacion" name="identificacion" autocomplete="off">
                          <option selected   value="">Elija una opción</option>
                          @foreach ($identificaciones as $identificacion)
                              <option value="{{$identificacion['id_identificacion']}}">{{$identificacion['tipo_identificacion']}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>

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
                  </div>

                  <div class="col-lg-4 fisica">
                    <div class="form-group">
                      <label class="form-control-label">Indique la Nacionalidad: </label>
                      <select class="form-control select2 " id="otraNacionalidad" name="otra_nacionalidad" autocomplete="off" disabled>
                          <option selected  value="" disabled>Elija una opción</option>
                          @foreach ($nacionalidades as $nacionalidad)
                                <option value="{{$nacionalidad['id_nacionalidad']}}">{{$nacionalidad['nacionalidad']}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-4 fisica">
                    <div class="form-group">
                      <label class="form-control-label">Estado Civil: </label>
                      <select class="form-control select2" id="estadoCivil" name="estado_civil" autocomplete="off">
                          <option selected   value="">Elija una opción</option>
                          @foreach ($estado_civil as $estado)
                              <option value="{{$estado['id_estado_civil']}}">{{$estado['estado_civil']}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-4 fisica">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">CURP:</label>
                      <input class="form-control" type="text" name="curp" id="curp" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">RFC:</label>
                      <input class="form-control" type="text" name="rfc" id="rfc" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-lg-4 fisica">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Cédula Profesional:</label>
                      <input class="form-control" type="text" name="cedula_profesional" id="cedulaProfesional" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-lg-8 moral d-none">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Razón Social: <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="razon_social" id="razonSocial" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-lg-4 fisica">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Nombre(s): <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="nombre" id="nombre" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-lg-4 fisica">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Apellido Paterno: <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="apellido_paterno" id="apellidoPaterno" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-lg-4 fisica">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Apellido Materno:</label>
                      <input class="form-control" type="text" name="apellido_materno" id="apellidoMaterno" autocomplete="off">
                    </div>
                  </div>

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
                  </div>
                  
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
                  </div>

                  <div class="col-lg-4 fisica">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Edad:</label>
                      <input class="form-control inpur-number" type="text" name="edad" id="edad" autocomplete="off">
                    </div>
                  </div>

                  {{--   A C C O R D E O N      A L I A S  --}}
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
                            <button class="btn btn-outline-primary btn-sm" id="agregarAlias">Agregar Alias <i class="fa fa-plus"></i></button>
                            <div id="datosAlias" class="row">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div><!-- accordion -->
                  </div>

                  {{--   A C C O R D E O N  D O M I C I L I O   Y   C O N T A C T O  --}}
                  <div class="col-lg-12">
                    <div id="accordionContacto" class="accordion-two mg-b-15" role="tablist" aria-multiselectable="true">
                      <div class="card">

                        <div class="card-header" role="tab" id="headingContacto">
                          <a data-toggle="collapse" data-parent="#accordionContacto" href="#collapseContacto" aria-expanded="false" aria-controls="collapseContacto" class="tx-gray-800 transition collapsed">
                            Agregar Datos de Contacto
                          </a>
                        </div>

                        <div id="collapseContacto" class="collapse" role="tabpanel" aria-labelledby="headingContacto">
                          <div class="card-body">
                            <div class="row">
                              {{-- D O M I C I L I O --}}
                              <div class="col-12">
                                <button class="btn btn-outline-primary btn-sm " id="agregarDomicilio">Agregar Domicilio <i class="fa fa-plus"></i></button>
                                <!-- <button class="btn btn-outline-primary mg-b-10 btn-sm mg-r-10 mg-t-15" id="agregarDomicilio">Agregar Domicilio <i class="fa fa-plus"></i></button> -->
                                <div id="domicilios" class="mg-b-15">
                                </div>
                              </div><!-- col-12 termina renglon -->

                              {{-- C O R R E O --}}
                              <div class="col-12">
                                <button class="btn btn-outline-primary btn-sm " id="agregarCorreo">Agregar Correo <i class="fa fa-plus"></i></button>
                                <div id="correos" class="mg-b-15 row">
                                </div>
                              </div><!-- col-12 termina renglon -->

                              {{-- T E L E F O N O --}}
                              <div class="col-12">
                                <button class="btn btn-outline-primary btn-sm " id="agregarTelefono">Agregar Telefono <i class="fa fa-plus"></i></button>
                                <div id="telefonos" class="row">
                                </div>
                              </div><!-- col-12 termina renglon -->
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  <br>
                  {{--   A C C O R D E O N  D A T O S   A D I C I O N A L E S  --}}
                  <div class="col-lg-12">
                    <div id="accordionDatosAdicionales" class="accordion-two mg-b-15" role="tablist" aria-multiselectable="true">
                      <div class="card">

                        <div class="card-header" role="tab" id="headingDatosAdicionales">
                          <a data-toggle="collapse" data-parent="#accordionDatosAdicionales" href="#collapseDatosAdicionales" aria-expanded="false" aria-controls="collapseContacto" class="tx-gray-800 transition collapsed">
                            Datos Adicionales
                          </a>
                        </div>

                        <div id="collapseDatosAdicionales" class="collapse" role="tabpanel" aria-labelledby="headingDatosAdicionales">
                          <div class="card-body datos-adicionales">
                            <div class="row" id="datos-adicionales-div">
                              
                              {{--  País de nacimiento Va para produccion --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">País de nacimiento: </label>
                                  <select class="form-control estado" id="pais_nac" name="pais_nac" autocomplete="off">
                                    <option selected  value="">Elija una opción</option>
                                    @foreach ($paises as $pais)
                                      <option value="{{$pais['id_pais']}}">{{$pais['descripcion']}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              
                              {{--  Entidad de nacimiento Va para produccion --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Entidad de nacimiento: </label>
                                  <select class="form-control estado" name="estado_nac" autocomplete="off" id="estado_nac">
                                    <option selected   value="">Elija una opción</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{$estado['id_estado']}}" data-cve-estado="{{$estado['cve_estado']}}">{{$estado['estado']}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              
                              {{--  Municipio/Alcaldía nacimiento Va para produccion --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Municipio/Alcaldía nacimiento: </label>
                                  <select class="form-control municipio" name="municipio_nac" autocomplete="off" id="municipio_nac">
                                  </select>
                                </div>
                              </div>

                              {{--  Ocupación  --}}
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

                              {{--  Otra Ocupación  --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Otra Ocupación:</label>
                                  <input class="form-control" type="text" name="otra_ocupacion" id="otra_ocupacion" autocomplete="off" disabled>
                                </div>
                              </div>

                              {{--  Escolaridad  --}}
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

                              {{--  Otra Escolaridad  --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Otra Escolaridad:</label>
                                  <input class="form-control" type="text" name="otra_escolaridad" id="otra_escolaridad" autocomplete="off" disabled>
                                </div>
                              </div>

                              {{--  Religión  --}}
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

                              {{--  Otra Religión  --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Otra Religión:</label>
                                  <input class="form-control" type="text" name="otra_religion" id="otra_religion" autocomplete="off" disabled>
                                </div>
                              </div>

                              {{--  Grupo Étnico  --}}
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

                              {{--  Otro Grupo Étnico  --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Otro Grupo Étnico:</label>
                                  <input class="form-control" type="text" name="otro_grupo_etnico" id="otro_grupo_etnico" autocomplete="off" disabled>
                                </div>
                              </div>

                              {{--  Capacidad Diferente  Va para produccion--}}
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

                              {{--  Discapacidad  Va para produccion --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Discapacidad:</label>
                                  <select class="form-control estado" id="discapacidad" name="discapacidad" autocomplete="off">
                                    <option selected value="">Elija una opción</option>
                                    @foreach ($discapacidades as $discapacidad)
                                      <option value="{{$discapacidad['id']}},{{$discapacidad['discapacidad']}}">{{$discapacidad['discapacidad']}}</option>
                                    @endforeach
                                  </select>
                                  {{--  <input class="form-control" type="text" name="discapacidad" id="discapacidad" autocomplete="off" disabled>  --}}
                                </div>
                              </div>

                              {{--  ¿Habla lengua indígena?  Va para produccion --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">¿Habla lengua indígena?: </label>
                                  <select class="form-control estado" id="habla_lengua_indigena" name="habla_lengua_indigena" autocomplete="off">
                                    <option selected   value="">Elija una opción</option>
                                    <option value="si">SI</option>
                                    <option value="no">NO</option>
                                    <option value="No Aplica">NO APLICA</option>
                                  </select>
                                </div>
                              </div>

                              {{--  Lengua  Va para produccion --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Lengua: </label>
                                  <select class="form-control" id="lengua" name="lengua" autocomplete="off" disabled>
                                    <option selected   value="">Elija una opción</option>
                                    @foreach ($lenguas as $lengua)
                                      <option value="{{$lengua['id_lengua']}}">{{$lengua['lengua']}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>

                              {{--  ¿Sabe Leer y Escribir?  --}}
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

                              {{--  ¿Entiende el Idioma Español?  --}}
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

                              {{--  ¿Población Callejera?  --}}
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

                              {{--  Poblacion LGBTTTI  --}}
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

                              {{--  Otra Población  --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Otra Población:</label>
                                  <input class="form-control" type="text" name="otra_poblacion" id="otra_poblacion" autocomplete="off" disabled>
                                </div>
                              </div>

                              {{--  ¿Requiere Traductor?  --}}
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

                              {{--  Idioma del Traductor  --}}
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

                              {{--  Otro Idioma del Traductor  --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Otro Idioma del Traductor:</label>
                                  <input class="form-control" type="text" name="otro_idioma_traductor" id="otro_idioma_traductor" autocomplete="off" disabled>
                                </div>
                              </div>

                              {{--  ¿Requiere Intérprete?  --}}
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

                              {{--  Tipo de Intérprete  --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Tipo de Intérprete:</label>
                                  <input class="form-control" type="text" name="tipo_interprete" id="tipo_interprete" autocomplete="off" disabled>
                                </div>
                              </div>

                              {{--  ¿Habla lengua extranjera?  Va para produccion --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">¿Habla lengua extranjera?: </label>
                                  <select class="form-control estado" id="habla_lengua_extranjera" name="habla_lengua_extranjera" autocomplete="off">
                                    <option selected   value="">Elija una opción</option>
                                    <option value="si">SI</option>
                                    <option value="no">NO</option>
                                    <option value="No Aplica">NO APLICA</option>
                                  </select>
                                </div>
                              </div>

                              {{--  Tipo de lengua extranjera  Va para produccion --}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Tipo de lengua extranjera: </label>
                                  <select class="form-control estado" id="lengua_extranjera" name="lengua_extranjera" autocomplete="off" disabled>
                                    <option selected   value="">Elija una opción</option>
                                    @foreach ($lengua_extranjera as $lengua)
                                      <option value="{{$lengua['id_lengua_extranjera']}}">{{$lengua['lengua_extranjera']}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>

                              {{--  Condición migratoria  Va para produccion--}}
                              <div class="col-lg-3">
                                <div class="form-group">
                                  <label class="form-control-label">Condición migratoria:</label>
                                  <select class="form-control estado" id="condicion_migratoria" name="condicion_migratoria" autocomplete="off">
                                    <option selected  value="">Elija una opción</option>
                                    @foreach ($condicion_migratoria as $condicion)
                                      <option value="{{$condicion['id_condicion_m']}}">{{$condicion['condicion']}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>

                              <div class="col-lg-3" id="procesos_multiples_div" style="display: none;">
                                <div class="form-group">
                                  <label class="form-control-label">Procesos Multiples:</label>
                                  <select class="form-control procesos_multiples" id="procesos_multiples" name="procesos_multiples" autocomplete="off">
                                  </select>
                                </div>
                              </div>

                              <div class="col-lg-3" id="relacion_imputado_div" style="display: none;">
                                <div class="form-group">
                                  <label class="form-control-label">Relación con el imputado:</label>
                                  <select class="form-control relacion_imputado" id="relacion_imputado" name="relacion_imputado" autocomplete="off">
                                  </select>
                                </div>
                              </div>

                              <div class="col-lg-3" id="utilizo_medio_tecnologico_div" style="display: none;">
                                <div class="form-group">
                                  <label class="form-control-label">Utilizó medio tecnológico por discapacidad:</label>
                                  <select class="form-control utilizo_medio_tecnologico" id="utilizo_medio_tecnologico" name="utilizo_medio_tecnologico" autocomplete="off">
                                  </select>
                                </div>
                              </div>

                              <div class="col-lg-3" id="condicion_embarazo_div" style="display: none;">
                                <div class="form-group">
                                  <label class="form-control-label">Condición de embarazo:</label>
                                  <select class="form-control condicion_embarazo" id="condicion_embarazo" name="condicion_embarazo" autocomplete="off">
                                  </select>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>

                      </div>
                    </div><!-- accordion -->
                  </div>

                  {{-- A C C O R D E O N    D E L I T O S --}}
                  <div class="col-lg-12 d-none" id="row-accordeon-delitos">
                    <div id="accordionDelitos" class="accordion-two mg-b-15" role="tablist" aria-multiselectable="true">
                      <div class="card">
                        <div class="card-header" role="tab" id="headingDelitos">
                          <a data-toggle="collapse" data-parent="#accordionDelitos" href="#collapseDelitos" aria-expanded="false" aria-controls="collapseDelitos" class="tx-gray-800 transition collapsed">
                            Delitos
                          </a>
                        </div><!-- card-header -->
                        <div id="collapseDelitos" class="collapse" role="tabpanel" aria-labelledby="headingDelitos">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-12">
                                @if(in_array($request->session()->get('id_tipo_usuario'), [ 1,18,20]))
                                  <button class="btn btn-outline-primary btn-sm" id="agregarDelito">Agregar Delito <i class="fa fa-plus"></i></button>
                                @endif
                                <button class="btn btn-outline-primary btn-sm" id="agregarDelitoEstadistico">Agregar Delito Estadístico<i class="fa fa-plus"></i></button>
                                <div id="delitos" class="mg-b-15">
                                </div>
                              </div><!-- col-12 termina renglon -->
                            </div> <!-- row -->
                          </div><!-- card body -->
                        </div><!-- accordion body -->
                      </div><!-- CARD -->
                    </div><!-- accordion -->
                  </div>

                  <div class="col-lg-12 d-flex mg-t-5" id="botonesPartes">
                    <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="agregarParte" onclick="agregarParteProcesal()">Agregar Parte</button>
                  </div>

                </div><!-- ROW GENERAL -->
              </div>
            </div>

          </div>
        </div>
      @endif
    </div>

  </div>

  {{-- BOTONES--}}
  <div class="form-layout-footer d-flex">
    <!-- <button class="btn btn-secondary bd-0 d-inline-block" id="cancelar" disabled>Cancelar</button> -->
    <!-- <button class="btn btn-primary bd-0 d-inline-block  ml-auto" id="btn-enviar-solicitud" onclick="guardarCambiosPP()">Guardar Cambios</button> -->
  </div>
</div>


{{-- CSS --}}
  <style>
    .content_persona{
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      width: 100%;
    }
    .barra_lateral_perfil{
      width: 100%;
      background: #848f33a3;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .imagen_perfil{
      width: 110px;
      border: 2px solid #fff;
      height: 110px;
      margin: 10% 10% 5% 10%;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      font-size: 2.2em;
      color: #fff;
    }
    .datos_principal{
      width: 100%;
      padding: 4px;
    }
    .table_datos_principal{
      margin-top: 5%;
      padding: 4px;
    }
    .table_datos_principal table{
      color:#f8f9fa; 
      font-weight: bold; 
      font-size: 0.85em; 
      text-align:left;
      text-transform: capitalize;
    }

    /* td .acciones-pp, .tipo-parte-pp .nombre-pp , .genero-pp{
      width:25%;
    }

    table.dataTable{
      display:table !important;
      width:100% !important;
    }

    table#table-partes{
      display:table !important;
      width:100% !important;
    } */

    .bkgd-card {
      background-color: #f0f2f740 !important;
    }

    .bkg-card-header {
      background-color: #dbdcde !important;
    }


    .bkg-collapsed-btn {
      /* background-color: #efefef !important; */
      background-color: #b0b781 !important;
    }

    .tx-white {
      color: #ffffff !important;
    }

    .f-right{
      float: right;
    }

    .pretty-box{
      /* border: 1px solid lightgray; */
      margin-top:15px;
      /* margin-right:10px; */
      /* margin-left:10px; */
      margin-bottom:5px;
    }


    /* a :focus {
      color: #154f89 !important;;
    } */

    .leyenda-sm{
      font-style: italic;
      font-style: oblique;
      color: lightgrey;
      font-size: 12px;
    }

    .situacion_imputado_activo{
      background: #dff0d8 !important;
      top: 38px;
      text-transform: lowercase;
      margin-right: 10px;
      position: absolute;
      left: 0;
      font-size: 0.75em;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #3c763d;
      border: 2px solid #dff0d8;
    }

    .situacion_imputado_otro{
      background: #f2dede !important;
      top: 38px;
      text-transform: lowercase;
      margin-right: 10px;
      position: absolute;
      left: 0;
      font-size: 0.75em;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #c7254e;
      border: 2px solid #f2dede;
    }
    

    @media only screen and (max-width: 1700px) {

    }
    @media (min-width: 992px){
      .modal-lg.xl {
          max-width: 1017px;
      }
    }

  </style>

{{-- JS --}}
  <script>
    var arrPP=[];
    //  const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/;
    //  const expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
    const expVacio=/^[\s]*$/;
    const expRFC=/^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/;
    //const expRFC=/^(([ÑA-Z|ña-z|&]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2}))$/;
    const catalogopPaises = @php echo json_encode($paises);@endphp;
    const catalogoEstados= @php echo json_encode($estados);@endphp;
    const catalogoDelitos= @php echo json_encode($delitos);@endphp;
    const catalogoCalificativos= @php echo json_encode($calificativos);@endphp;
    const catalogoOcupaciones= @php echo json_encode($ocupaciones);@endphp;
    const delitosEstadisticos_PP = @php echo json_encode($delitos_estadisticos); @endphp;
    const catalogo_relacion_imputado = @php echo json_encode($relacion_imputado);@endphp;
    const catalogo_elementos_comision = @php echo json_encode($elementos_comision);@endphp;
    const catalogo_modalidad_agresion = @php echo json_encode($modalidad_agresion);@endphp;
    /***********************************
    *
    *  AGREGAR PARTE PROCESAL
    *
    ***********************************/



    @if( isset($permisos[85]) and $permisos[85] == 1 )
    function agregarParteProcesal(){

      $('.error').removeClass('error');

      var validacion=validaDatosParteProcesal();
      if(validacion!=100){
        const {campo , error} = validacion;
        if($(campo).is('select')){
          $(`#select2-${campo.replaceAll("#","")}-container`).focus().addClass('error');
        }else{
          $(campo).focus().addClass('error');
        }
        modal_error(error,'modalAdministracion');
        return false;
      }

      var aliasSujeto=[];
      var correos=[];
      var telefonos=[];
      var direcciones=[];
      var datosAdicionales=[];
      var delitos=[];
      var delitos_estadisticos=[];

      $('.datos-alias').each(function(){
        aliasSujeto.push({ alias:$(this).find('.alias').val() });
      });

      $('.datos-correo').each(function(){
        correos.push({ correo:$(this).find('.correo-electronico').val() });
      });

      $('.datos-telefono').each(function(){
        telefonos.push(
          { tipo:$(this).find('.tipo-telefono').val(),
            numero:$(this).find('.numero-telefono').val(),
            extension:$(this).find('.extension').val(),
          }
        );
      });

      $('.datos-domicilio').each(function(){
        direcciones.push(
          { 
            pais_recidencia: $(this).find('.pais_resi').val(),
            calle:$(this).find('.calle').val(),
            numero_exterior:$(this).find('.numeroExterior').val(),
            numero_interior:$(this).find('.numero_interior').val(),
            colonia:$(this).find('.colonia').val(),
            codigo_postal:$(this).find('.codigoPostal').val(),
            estado:$(this).find('.estado').val(),
            estado_text:$(this).find('.estado').val()==''?'':$(this).find('.estado').find('option:selected').text(),
            cve_estado:$(this).find('.estado').find('option:selected').attr('data-cve-estado'),
            municipio:$(this).find('.municipio').val(),
            municipio_text:$(this).find('.municipio').val()==''?'':$(this).find('.municipio').find('option:selected').text(),
            localidad:$(this).find('.localidad').val(),
            entre_calle:$(this).find('.entreCalle').val(),
            otra_referencia:$(this).find('.otrasReferencias').val(),
          }
        );
      });

      $('.datos-delito').each(function(){
        if( $(this).data("tipo") == "estadistica" ){
          delitos_estadisticos.push(
            { 
              id:"-",
              tipo_delictivo:$(this).find('.tipo_delictivo').val(),
              desagregado_n1:$(this).find('.desagregado_n1').length > 0 ? $(this).find('.desagregado_n1').val() : "-",
              desagregado_n2:$(this).find('.desagregado_n2').length > 0 ? $(this).find('.desagregado_n2').val() : "-",
              desagregado_n3:$(this).find('.desagregado_n3').length > 0 ? $(this).find('.desagregado_n3').val() : "-",
              desagregado_n4:$(this).find('.desagregado_n4').length > 0 ? $(this).find('.desagregado_n4').val() : "-",
              otro:$(this).find('.otro').length > 0 ? $(this).find('.otro').val() : "-",
              estatus:1,
              comision_delito_estadistico: Number( $(this).find('.calificativo').val() ), 
              grado_realizacion_estadistico: $(this).find('.gradoRealizacion').val() , 
              tipo_violencia_estadistico: Number( $(this).find('.tipoViolencia').val() ), 
              consignacion_estadistico: Number( $(this).find('.consignacion').val() ), 
              fecha_ocurrencia_h_estadistico: $(this).find('.fechaOcurrenciaH').val(), 
              entidad_ocurrenica_h_estadistico: Number( $(this).find('.estadoOcurrenciaH').val() ), 
              municipio_ocurrencia_h_estadistico: Number( $(this).find('.municipioOcurrenciaH').val() ), 
              elementos_comision_estadistico: Number( $(this).find('.elementosComisionDel').val() ), 
              modo_agresion_estadistico: Number( $(this).find('.modoOcurrenciaAgresion').val() ), 
            }
          );
        }else{
          delitos.push(
            { 
              id_delito:$(this).find('.delito').val(),
              delito_text:$(this).find('.delito').find('option:selected').text(),
              id_modalidad:$(this).find('.modalidad-delito').val(),
              modalidad_text:$(this).find('.modalidad-delito').find('option:selected').text(),
              id_calificativo:$(this).find('.calificativo').val(),
              calificativo_text:$(this).find('.calificativo').find('option:selected').text(),
              forma_comision:"forma",
              grado_realizacion:$(this).find('.grado-realizacion').val(),
              grado_realizacion_text:$(this).find('.grado-realizacion').find('option:selected').text(),
              delito_grave:$(this).find('.delito').find('option:selected').attr('data-grave')
            }
          );
        }
      });

      const datoAdicional={

        pais_nacimiento : $('#pais_nac').val(), ///Se agrego 
        estado_nacimiento : $('#estado_nac').val(), ///Se agrego 
        municipio_nacimiento : $('#estado_nac').val() == '' ? '-' : $('#municipio_nac').val(),  ///Se agrego 

        tipo_ocupacion:$('#ocupacion').val(),
        ocupacion:$('#ocupacion').val()==''?'':$('#ocupacion').find('option:selected').text(),
        otra_ocupacion:$('#otra_ocupacion').val(),

        id_nivel_escolaridad:$('#escolaridad').val(),
        id_escolaridad:$('#escolaridad').val(),
        nivel_escolaridad:$('#escolaridad').val()==''?'':$('#escolaridad').find('option:selected').text(),
        otra_escolaridad:$('#otra_escolaridad').val(),
        
        id_religion:$('#religion').val(),
        nombre_religion:$('#religion').val()==''?'':$('#religion').find('option:selected').text(),
        otra_religion:$('#otra_religion').val(),

        id_grupo_etnico:$('#grupo_etnico').val(),
        grupo_etnico:$('#grupo_etnico').val()==''?'':$('#grupo_etnico').find('option:selected').text(),
        otro_grupo_etnico:$('#otro_grupo_etnico').val(),
        pertenece_grupo_etnico:$('#grupo_etnico').val()==''?'no':'si',

        capacidades_diferentes: $('#capacidades_diferentes').val(),
        capacidad_diferente: $('#capacidades_diferentes').val() == 'si' ? $('#discapacidad').val() : '-', ///Se agrego 

        id_lengua: $('#habla_lengua_indigena').val() == 'si' ? $('#lengua').val() : '-', ///Se agrego 
        lengua:$('#lengual').val()==''?'':$('#lengual').find('option:selected').text(),

        sabe_leer_escribir:$('#sabe_leer_escribir').val(),

        entiende_idioma_espanol:$('#entiende_idioma_espanol').val(),

        poblacion_callejera:$('#poblacion_callejera').val(),

        id_lgbttti:$('#poblacion').val(),
        poblacion:$('#poblacion').val(),
        otra_poblacion:$('#otra_poblacion').val(),
        nombre_poblacion:$('#poblacion').val()==''?'':$('#poblacion').find('option:selected').text(),

        requiere_traductor:$('#requiere_traductor').val(),
        idioma_traductor:$('#idioma_traductor').val(),
        otro_idioma_traductor:$('#otro_idioma_traductor').val(),

        requiere_interprete:$('#requiere_interprete').val(),
        tipo_interprete:$('#tipo_interprete').val(),

        condicion_migratoria: $('#condicion_migratoria').val(), ///Se agrego 
        lengua_extranjera: $('#habla_lengua_extranjera').val() == 'si' ? $('#lengua_extranjera').val() : '-', ///Se agrego 
        
        procesos_multiples: $('#procesos_multiples').val(), ///Se agrego 
        relacion_imputado: $('#relacion_imputado').val(), ///Se agrego 
        utilizo_medio_tecnologico: $('#utilizo_medio_tecnologico').val(), ///Se agrego 
        condicion_embarazo: $('#condicion_embarazo').val(), ///Se agrego 
      };

      info_principal= {
        origen: "interfaz",
        id:"-",
        tipo_parte:$('#tipoParte').val(),
        tipo_parte_text:$('#tipoParte').find('option:selected').text(),
        tipo_persona:$('#tipoPersona').val(),
        tipo_persona_text:$('#tipoPersona').find('option:selected').text().toUpperCase(),
        nacionalidad:$('#nacionalidad').val(),
        nacionalidad_text:$('#nacionalidad').find('option:selected').text().toUpperCase(),
        otra_nacionalidad:$('#otraNacionalidad').val(),
        curp:$('#curp').val(),
        rfc:$('#rfc').val(),
        cedula_profesional:$('#cedulaProfesional').val(),
        nombre:$('#nombre').val(),
        apellido_paterno:$('#apellidoPaterno').val(),
        apellido_materno:$('#apellidoMaterno').val(),
        genero:$('#genero').val(),
        genero_text:$('#genero').find('option:selected').text(),
        fecha_nacimiento:$('#fechaNacimiento').val(),
        edad:$('#edad').val(),
        estado_civil:$('#estadoCivil').val(),
        estado_civil_text:$('#estadoCivil').find('option:selected').text(),
        razon_social:$('#razonSocial').val(),
        id_tipo_identificacion:$('#identificacion').val(),
        tipo_identificacion:$('#identificacion').find('option:selected').text(),
      };

      var data = {
        id_carpeta : $("#id_carpeta_judicial").val(),
        id_solicitud : $("#id_solicitud").val(),
        tipo_solicitud : $("#tipo_solicitud").val(),
        info_principal,
        alias:aliasSujeto,
        correos,
        telefonos,
        datos:datoAdicional,
        direcciones,
        delitos,
        delitos_estadisticos,
      };
      
      console.log('Datos de presunto responsable', data);
      
      $.ajax({
        method:'POST',
        url:'/public/agregar_parte_procesal',
        data:{
          id_carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          info_principal,
          alias:aliasSujeto,
          correos,
          telefonos,
          datos:datoAdicional,
          direcciones,
          delitos,
          delitos_estadisticos,
        },
        success:function(response){
          console.log(response);
          if(response.status==100){
            modal_success(`Parte procesal agregada exitosamente`,'modalAdministracion');
            limpiarFormularioParteProcesal();
            pintarPersonas();
            pintarDelitosSinRelacionar();
          }else{
            if( response.message!="ERROR - sin datos asociados") modal_error(response.message+'PP','modalAdministracion');
          }
        }
      });
      
    }
    @endif

    /************************
    *
    * SUJETOS EN TOGGLES
    *
    *************************/

    function pintarPersonas(){
      $("#divPartesProcesales div").remove();

      $.ajax({
        method:'POST',
        url:'/public/obtener_personas_carpeta',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
        },
        success:function(response){
          console.log('PP',response);
          if( response.status==100 && response.response.personas.length){

            let arr_imputados = response.response.personas.filter( x => x.info_principal.id_calidad_juridica == 46 );
            let arr_otros = response.response.personas.filter( x => x.info_principal.id_calidad_juridica != 46 );
            arrPP = arr_imputados.concat( arr_otros );
            
            $(arrPP).each(function(index, persona){
              var index_persona = index;

              const {alias, contacto, delitos, delitos_estadisticos, direcciones, info_principal}= persona;
              const datos = persona.datos;
              //console.log("datos debug:", datos);
              let listaDelitos='',
                  listaDelitosEstadisticos='',
                  listaAlias='',
                  listaCorreos='',
                  listaTelefonos='',
                  listaDirecciones='';


              $(alias).each(function(index, aliasSujeto){
                listaAlias=listaAlias.concat( `${aliasSujeto.alias}<br>` );
              });

              $(contacto).each(function(index,contactoSujeto){
                const {id_contacto_persona,tipo_contacto, contacto, estatus, extension}=contactoSujeto;
                if(estatus==1){
                  if(tipo_contacto=='correo electronico'){
                    listaCorreos=listaCorreos.concat( `${contacto}<br>` );
                  }else{
                    listaTelefonos=listaTelefonos.concat( `${tipo_contacto == 'celular' ? 'Cel.: ': 'Fijo: '}${contacto} ${extension==null?'':'Ext.'+extension+''}<br>` );
                  }
                }
              });

              $(direcciones).each(function(index, direccionSujeto){
                const {estado ,municipio, colonia, localidad, calle,no_exterior, no_interior, referencias, entre_calles,codigo_postal, pais_residencia,descripcion}=direccionSujeto;
                let tableDireccion=`
                  <div class="col-md-${direcciones.length > 1 ? '6':'12'} col-lg-${direcciones.length > 1 ? '6':'12'} d-block" style="border-right: 1px solid #848f33;">
                    <table>
                      <tbody>
                        <tr>
                          <td>Calle</td>
                          <td>${calle==null?'(Sin datos)':calle}</td>
                          <td>Número Exterior</td>
                          <td>${no_exterior==null?'(Sin datos)':no_exterior}</td>
                        </tr>
                        <tr>
                          <td>Número Interior</td>
                          <td>${no_interior==null?'(Sin datos)':no_interior}</td>
                          <td>Localidad</td>
                          <td>${localidad==null?'(Sin datos)':localidad}</td>
                        </tr>
                        <tr>
                          <td>Colonia</td>
                          <td>${colonia==null?'(Sin datos)':colonia}</td>
                          <td>Municipio</td>
                          <td>${municipio==null?'(Sin datos)':municipio}</td>
                        </tr>
                        <tr>
                          <td>Estado</td>
                          <td>${estado==null?'(Sin datos)':estado}</td>
                          <td>Entre Calle y Calle</td>
                          <td>${entre_calles==null?'(Sin datos)':entre_calles}</td>
                        </tr>
                        <tr>
                          <td>Codigo Postal</td>
                          <td>${codigo_postal==null?'(Sin datos)':codigo_postal}</td>
                          <td>País de residencia</td>
                          <td>${descripcion==null?'(Sin datos)':descripcion}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                `;

                listaDirecciones=listaDirecciones.concat(tableDireccion);
              });

              if( listaDirecciones.length == 0 ) listaDirecciones = `<div class="col-md-12 col-lg-12 d-block" style="text-align: center;margin-bottom: 1px;border-right: 1px solid #848f33;"><p class="tx-13 mg-b-0">Sin direcciones</p></div>`;

              $(delitos).each(function(index, delito){
                listaDelitos=listaDelitos.concat(`
                  <div class="col-md-4 col-lg-4 d-block pd-y-10" style="border: 1px solid #ccc;">
                    <div class="d-flex justify-content-between align-items-center tx-12">
                      <span class="tx-inverse"><h6>${delito.delito}</h6></span>
                      <span><i class="fas fa-history tx-secondary" data-toggle="tooltip-primary" data-placement="top" title="Ver Historial" onclick="mostrarHistorialDelito(${index_persona},${index})"></i></span>
                    </div><!-- d-flex -->
                    
                    <span class="tx-13 mg-b-0 ${delito.nombre_modalidad != null ? '' : 'd-none'}">Modalidad: ${delito.nombre_modalidad} </span><br>
                    <span class="tx-13 mg-b-0 ${delito.calificativo != null ? '' : 'd-none'}">calificativo: ${delito.calificativo} </span><br>
                    <span class="tx-13 mg-b-0 ${delito.grado_realizacion != null ? '' : 'd-none'}">Grado realizacion: ${delito.grado_realizacion} </span><br>
                    
                    <div style="background: #848f33 !important;position: absolute;font-size: 0.75em;display: flex;justify-content: center;color: #ffff;border: 2px solid #848f33;bottom: 1px;right: -1px; padding-left: 2px;">
                      Delito
                    </div>
                  </div>
                ` );
              });

              $(delitos_estadisticos).each(function(index, delito){
                listaDelitosEstadisticos=listaDelitosEstadisticos.concat(`
                  <div class="col-md-4 col-lg-4 d-block pd-y-10" style="border: 1px solid #ccc;">
                    <div class="d-flex justify-content-between align-items-center tx-12">
                      <span>${delito.titulo}</span>
                    </div><!-- d-flex -->
                    <div class="d-flex justify-content-between align-items-center tx-12 mg-b-10">
                      <span>${delito.capitulo}</span>
                      <span><i class="fas fa-history tx-secondary" data-toggle="tooltip-primary" data-placement="top" title="Ver Historial" onclick="mostrarHistorialDelitoEstadistico(${index_persona},${index})"></i></span>
                    </div><!-- d-flex -->
                    
                    <h6 class="lh-3 mg-b-0"><span class="tx-inverse">${delito.tipo_delictivo}</span></h6>
                    <span class="tx-13 mg-b-0 ${delito.desagregado_n1 != null ? '' : 'd-none'}">${delito.desagregado_n1} <small>${delito.fundamento_n1 != null ? '' : 'Fdto. '+delito.fundamento_n1}</small> <br></span>
                    <span class="tx-13 mg-b-0 ${delito.desagregado_n2 != null ? '' : 'd-none'}">${delito.desagregado_n2} <small>${delito.fundamento_n2 != null ? '' : 'Fdto. '+delito.fundamento_n2}</small> <br></span>
                    <span class="tx-13 mg-b-0 ${delito.desagregado_n3 != null ? '' : 'd-none'}">${delito.desagregado_n3} <small>${delito.fundamento_n3 != null ? '' : 'Fdto. '+delito.fundamento_n3}</small> <br></span>
                    <span class="tx-13 mg-b-0 ${delito.desagregado_n4 != null ? '' : 'd-none'}">${delito.desagregado_n4} ${delito.otro_delito != null ? ': '+delito.otro_delito : ''  } </span>
                    
                    <div style="background: #848f33a3 !important;position: absolute;font-size: 0.75em;display: flex;justify-content: center;color: #ffff ;border: 2px solid #848f33a3;bottom: 1px;right: -1px; padding-right: 2px;">
                      Delito Estadístico
                    </div>
                  </div>
                ` );
              });

              seccion_delitos = ``;

              if( info_principal.id_calidad_juridica == 46 && $("#tipo_solicitud").val() != 'PRO-MUJER' && $("#tipo_solicitud").val() != 'PRO-MUJERF' ){
                seccion_delitos = `
                  <div class="col-md-12" style="text-align: center; text-weight: bolder; color: #ffff; background: #848f33a3;">
                    Delitos
                  </div>
                `;

                if( delitos.length == 0 && delitos_estadisticos.length == 0 ){  
                  seccion_delitos += `<div class="col-md-12 col-lg-12 d-block" style="border: 1px solid #848f33;text-align: center;"><p class="tx-13 mg-b-0">Sin delitos</p></div>`;
                } else{
                  seccion_delitos  += `
                    ${ listaDelitos.length ? listaDelitos : '<div class="col-md-4 col-lg-4 d-block pd-y-10" style="border: 1px solid #848f33; text-align: center;"><p class="tx-13 mg-b-0">Sin delitos</p></div>' }
                    ${ listaDelitosEstadisticos.length ? listaDelitosEstadisticos : '<div class="col-md-4 col-lg-4 d-block pd-y-10" style="border: 1px solid #848f33; text-align: center;"><p class="tx-13 mg-b-0">Sin delitos estadísticos</p></div>' }
                  `;
                }
              }

              const {calidad_juridica,razon_social,nombre,apellido_paterno,apellido_materno,rfc_empresa,curp,cedula_profesional,genero,fecha_nacimiento,nacionalidad,estado_civil,bandera_identidad_reservada, origen, edad, id_tipo_identificacion,tipo_identificacion,tipo_persona,es_mexicano} = info_principal;

              fechaNacimiento='(Sin datos)';
              if(fecha_nacimiento!=null){
                const f=fecha_nacimiento.split('-');
                fechaNacimiento=`${f[2]}-${f[1]}-${f[0]}`;
              }

              // try {
              //   var {otra_ocupacion,nivel_escolaridad,otra_escolaridad,nombre_religion,otra_religion,grupo_etnico,otro_grupo_etnico,lengua,capacidad_diferente,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,poblacion,otra_poblacion,nombre_poblacion,entiende_idioma_espanol,requiere_interprete,tipo_interprete,requiere_traductor,idioma_traductor,otro_idioma_traductor}= datos.length? datos[0]: null;
              // } catch (error) {
              //   console.log('ERROR ESTA PARTE PROCESAL NO TIENE INFORMACION ADICIONAL, SE TOMARAN VALORES NULOS :',error);

              const nombre_ocupacion = (datos).length > 0 ? datos[0].nombre_ocupacion : null;
              const tipo_ocupacion = (datos).length > 0 ? datos[0].tipo_ocupacion : null;
              const otra_ocupacion = (datos).length > 0 ? datos[0].otra_ocupacion : null;
              const id_escolaridad = (datos).length > 0 ? datos[0].id_escolaridad : null;
              const nivel_escolaridad = (datos).length > 0 ? datos[0].nivel_escolaridad : null;
              const otra_escolaridad = (datos).length > 0 ? datos[0].otra_escolaridad : null;
              const id_religion = (datos).length > 0 ? datos[0].id_religion : null;
              const nombre_religion = (datos).length > 0 ? datos[0].nombre_religion : null;
              const otra_religion = (datos).length > 0 ? datos[0].otra_religion : null;
              const id_grupo_etnico = (datos).length > 0 ? datos[0].id_grupo_etnico : null;
              const grupo_etnico = (datos).length > 0 ? datos[0].grupo_etnico : null;
              const otro_grupo_etnico = (datos).length > 0 ? datos[0].otro_grupo_etnico : null;
              const id_lengua = (datos).length > 0 ? datos[0].id_lengua : null;
              const lengua = (datos).length > 0 ? datos[0].lengua : null;
              const capacidad_diferente = (datos).length > 0 ? datos[0].capacidad_diferente : null;
              const capacidades_diferentes = (datos).length > 0 ? datos[0].capacidades_diferentes : null;
              const descripcion_discapacidad = (datos).length > 0 ? datos[0].descripcion_discapacidad : null;
              const sabe_leer_escribir = (datos).length > 0 ? datos[0].sabe_leer_escribir : null;
              const poblacion_callejera = (datos).length > 0 ? datos[0].poblacion_callejera : null;
              const poblacion = (datos).length > 0 ? datos[0].poblacion : null;
              const otra_poblacion = (datos).length > 0 ? datos[0].otra_poblacion : null;
              const nombre_poblacion = (datos).length > 0 ? datos[0].nombre_poblacion : null;
              const entiende_idioma_espanol = (datos).length > 0 ? datos[0].entiende_idioma_espanol : null;
              const requiere_interprete = (datos).length > 0 ? datos[0].requiere_interprete : null;
              const tipo_interprete = (datos).length > 0 ? datos[0].tipo_interprete : null;
              const requiere_traductor = (datos).length > 0 ? datos[0].requiere_traductor : null;
              const id_idioma = (datos).length > 0 ? datos[0].id_idioma : null;
              const idioma_traductor = (datos).length > 0 ? datos[0].idioma_traductor : null;
              const idioma = (datos).length > 0 ? datos[0].idioma : null;
              const otro_idioma_traductor = (datos).length > 0 ? datos[0].otro_idioma_traductor : null;
              const pais_nacimiento = (datos).length > 0 ? datos[0].descripcion : null;
              const estado_nacimiento = (datos).length > 0 ? datos[0].estado : null;
              const id_lgbttti = (datos).length > 0 ? datos[0].id_lgbttti : null;
              const municipio_nacimiento = (datos).length > 0 ? datos[0].municipio : null;
              const condicion = (datos).length > 0 ? datos[0].condicion : null;
              const condicion_migratoria = (datos).length > 0 ? datos[0].condicion_migratoria : null;
              const id_lengua_extranjera = (datos).length > 0 ? datos[0].id_lengua_extranjera : null;
              const lengua_extranjera = (datos).length > 0 ? datos[0].lengua_extranjera : null;
              // }

              discapacidad = '';
              if(capacidad_diferente != null){
                discapacidad = capacidad_diferente.split(',');
                discapacidad = discapacidad[1];
              }




              //const {otra_ocupacion,nivel_escolaridad,otra_escolaridad,nombre_religion,otra_religion,grupo_etnico,otro_grupo_etnico,lengua,capacidad_diferente,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,poblacion,otra_poblacion,nombre_poblacion,entiende_idioma_espanol,requiere_interprete,tipo_interprete,requiere_traductor,idioma_traductor,otro_idioma_traductor}= datos.length? datos[0]: null;

              ocupacion='';

              let strBorrarPP = ``;
              let strEditarPP = ``;
              if(!bandera_solo_consulta){ // aquí se controla elpermiso de edición
                @if( isset($permisos[84]) and $permisos[84] == 1 ) strEditarPP = `<button class="btn btn-primary d-inline-block mg-l-10" onclick="editarParteProcesal(${index})">Editar</button>`; @endif
                @if( isset($permisos[86]) and $permisos[86] == 1 ) strBorrarPP = `<button class="btn btn-danger d-inline-block mg-l-10" onclick="borrarParteProcesal(${index})">Borrar</button>`; @endif
              }

              const table= `

              <div class="content_persona">

                <div class="col-md-3 mb-3" style="padding:0;">
                  <div class="barra_lateral_perfil">

                    <div class="imagen_perfil">
                      <i class="fas fa-user"></i>
                    </div>

                    <div class="datos_principal">

                      <div style="color:#fff; font-weight: bold; font-size: 0.9em; text-align:center;"> ${ razon_social == null ? '' : razon_social} ${nombre == null ? '' : nombre }   ${ apellido_paterno == null ? '' : apellido_paterno }   ${apellido_materno == null ? '' : apellido_materno} </div>

                      <div class="table_datos_principal">
                        <span style="font-size: 0.8em; color: #fff; border-left: 3px solid #fff; padding-left: 3px; font-weight: bold;">Datos Principales</span>
                        <div class="table-responsive" style="margin-bottom: 5%;">
                          <table>
                            <tr>
                              <td>Calidad Juridica:</td>
                              <td>${calidad_juridica ?? '(Sin datos)'}</td>
                            </tr>
                            <tr>
                              <td>Tipo de Persona:</td>
                              <td>${tipo_persona ?? '(Sin datos)'}</td>
                            </tr>
                          </table>
                        </div>
                        <span style="font-size: 0.8em; color: #fff; border-left: 3px solid #fff; padding-left: 3px; font-weight: bold;">Datos Personales</span>
                        <div class="table-responsive" style="margin-bottom: 5%;">
                          <table>
                            <tr>
                              <td>RFC</td>
                              <td>${rfc_empresa==null?'(Sin datos)':rfc_empresa}</td>
                            </tr>
                            <tr>
                              <td>CURP</td>
                              <td>${curp==null?'(Sin datos)':curp}</td>
                            </tr>
                            <tr>
                              <td>Cédula Profesional</td>
                              <td>${cedula_profesional==null?'(Sin datos)':cedula_profesional}</td>
                            </tr>
                            <tr>
                              <td>Género</td>
                              <td class="text-capitalize">${genero==null?'(Sin datos)':genero}</td>
                            </tr>
                            <tr>
                              <td>Fecha de Nacimiento</td>
                              <td>${fechaNacimiento}</td>
                            </tr>
                            <tr>
                              <td>Edad</td>
                              <td>${edad==null?'(Sin datos)':edad+' Años'}</td>
                            </tr>
                          </table>
                        </div>
                        <span style="font-size: 0.8em; color: #fff; border-left: 3px solid #fff; padding-left: 3px; font-weight: bold;">Alias</span>
                        <div class="table-responsive" style="margin-bottom: 5%;">
                          <table>
                            <tr>
                              <td>${listaAlias==''?'(Sin datos)':listaAlias}</td>
                            </tr>
                          </table>
                        </div>
                        <span style="font-size: 0.8em; color: #fff; border-left: 3px solid #fff; padding-left: 3px; font-weight: bold;">Teléfonos</span>
                        <div class="table-responsive" style="margin-bottom: 5%;">
                          <table>
                            <tr>
                              <td>${listaTelefonos==''?'(Sin datos)':listaTelefonos}</td>
                            </tr>
                          </table>
                        </div>
                        <span style="font-size: 0.8em; color: #fff; border-left: 3px solid #fff; padding-left: 3px; font-weight: bold;">Correos</span>
                        <div class="table-responsive" style="margin-bottom: 5%;">
                          <table>
                            <tr>
                              <td>${listaCorreos==''?'(Sin datos)':listaCorreos}</td>
                            </tr>
                          </table>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>

                <div class="col-md-9 mb-3">
                  <div class="row">

                    <div class="col-md-12" style="text-align: center; text-weight: bolder; color: #ffff; background: #848f33a3;">
                      Informacion complementaria
                    </div>
                        
                    <div class="col-md-6" style="margin-bottom: 1px;border-right: 1px solid #848f33;">
                      <table>
                        <tbody>
                          <tr>
                            <td>Identidad Reservada</td>
                            <td>
                              <label class="ckbox d-inline-block mg-l-5">
                                @if( isset($permisos[84]) and $permisos[84] == 1 )
                                  <input name="identidad_reservada" id="identidad_reservada_${index}" class="imputado" type="checkbox" value="${index}" ${bandera_identidad_reservada==1 ? 'checked' : ''} onclick="modificarBanderaIdentidad(${index},true);">
                                  <span> <small> Presione para ${bandera_identidad_reservada==1 ? 'inhabilitar' : 'habilitar'} </small> </span>
                                @else
                                  ${bandera_identidad_reservada==1 ? 'Aplicada' : 'Sin aplicar'}
                                @endif
                              </label>
                            </td>
                          </tr>
                          <tr>
                            <td>Es de Nacionalidad Mexicana</td>
                            <td>${es_mexicano==null?'(No especificado)':es_mexicano}</td>
                          </tr>
                          <tr>
                            <td>Pais Nacimiento</td>
                            <td style="">${pais_nacimiento==null?'(No especificado)':pais_nacimiento}</td>
                          </tr>
                          <tr>
                            <td>Entidad Nacimiento</td>
                            <td>${estado_nacimiento==null?'(No especificado)':estado_nacimiento}</td>
                          </tr>
                          <tr>
                            <td>Municipio Nacimiento</td>
                            <td style="">${municipio_nacimiento==null?'(No especificado)':municipio_nacimiento}</td>
                          </tr>
                          <tr>
                            <td>Identificacion</td>
                            <td style="">${tipo_identificacion==null?'(Sin datos)':tipo_identificacion}</td>
                          </tr>
                          <tr>
                            <td>Estado Civíl</td>
                            <td>${estado_civil==null?'(No especificado)':estado_civil}</td>
                          </tr>
                          <tr>
                            <td>Ocupación</td>
                            <td style="">
                              ${nombre_ocupacion==null?'(Sin datos)':nombre_ocupacion} ${tipo_ocupacion==4 ? (otra_ocupacion!=null?'(No especificado)':'('+otra_ocupacion+')') :'' }
                            </td>
                          </tr>
                          <tr>
                            <td>Escolaridad</td>
                            <td style="">
                              ${nivel_escolaridad==null?'(Sin datos)':nivel_escolaridad} ${id_escolaridad == 7 ? (otra_escolaridad==null?'(No especificado)':'('+otra_escolaridad+')'):''}
                            </td>
                          </tr>
                          <tr>
                            <td>Religión</td>
                            <td style="">
                              ${nombre_religion==null?'(Sin datos)':nombre_religion} ${id_religion == 18 ? (otra_religion==null?'(No especificado)':'('+otra_religion+')'):''}
                            </td>
                          </tr>
                          <tr>
                            <td>Condición migratoria</td>
                            <td style="">
                              ${condicion_migratoria==null?'(Sin datos)': 'Si ('+condicion+')'}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 1px;border-right: 1px solid #848f33;">
                      <table>
                        <tbody>
                          <tr>
                            <td>Grupo Étnico</td>
                            <td style="">
                              ${grupo_etnico==null?'(Sin datos)':grupo_etnico} ${id_grupo_etnico == 777 ? (otro_grupo_etnico==null?'(No especificado)':'('+otro_grupo_etnico+')'):''}
                            </td>
                          </tr>
                          <tr>
                            <td>Población</td>
                            <td style="">
                              ${nombre_poblacion==null?'(Sin datos)':nombre_poblacion} ${id_lgbttti == 8 ? (otra_poblacion==null?'(No especificado)':'('+otra_poblacion+')'):''}
                            </td>
                          </tr>
                          <tr>
                            <td>Capacidad Diferente</td>
                            <td style="">
                              ${capacidades_diferentes==null?'(Sin datos)':capacidades_diferentes} ${capacidades_diferentes=='si' ?  (discapacidad==null?'(No especificado)':'('+discapacidad+')') : '' }
                            </td>
                          </tr>
                          <tr>
                            <td>Requiere Intérprete</td>
                            <td style="" class="text-capitalize">
                              ${requiere_interprete==null?'(Sin datos)':requiere_interprete} ${requiere_interprete=='si' ? (tipo_interprete==null?'(No especificado)':'('+tipo_interprete+')'):''}
                            </td>
                          </tr>
                          <tr>
                            <td>Entiende el Idioma Español</td>
                            <td style="" class="text-capitalize">${entiende_idioma_espanol==null?'(Sin datos)':entiende_idioma_espanol}</td>
                          </tr>
                          <tr>
                            <td>Requiere Traductor</td>
                            <td class="text-capitalize">
                              ${requiere_traductor==null?'(Sin datos)':requiere_traductor} 
                              ${idioma==null?'': '('+( id_idioma==208 ? ( otro_idioma_traductor==null?'No especificado':idioma+':'+otro_idioma_traductor  ):idioma)+')'} 
                            </td>
                          </tr>
                          <tr>
                            <td>Lengua</td>
                            <td style="">
                              ${lengua==null?'(Sin datos)': 'si ('+lengua+')' }
                            </td>
                          </tr>
                          <tr>
                            <td>Sabe Leer y Escribir</td>
                            <td class="text-capitalize">${sabe_leer_escribir==null?'(Sin datos)':sabe_leer_escribir}</td>
                          </tr>
                          <tr>
                            <td>Población Callejera</td>
                            <td style="" class="tx-capitalize">
                              ${poblacion_callejera==null?'(Sin datos)':poblacion_callejera}</td>
                          </tr>
                          <tr>
                            <td>Habla lengua Extranjera</td>
                            <td style="" class="tx-capitalize">
                              ${id_lengua_extranjera==null?'(Sin datos)': 'si ('+lengua_extranjera+')'}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="col-md-12" style="text-align: center; text-weight: bolder; color: #ffff; background: #848f33a3;">
                      Domicilios
                    </div>

                    ${listaDirecciones}

                    ${seccion_delitos}
                    
                  </div>


                </div>
              </div>

              <div class="d-flex justify-content-end">
                ${strBorrarPP} ${strEditarPP}
              </div>`;


              var color_situacion = "";
              var title = "";

              if( info_principal.situacion_imputado == 1){
                color_situacion = "#3ca467";
                title = "ACTIVO";
              }
              else{
                color_situacion = "#dc3545";
                title = "BAJA";

              }

              $('#divPartesProcesales').append(`
                <div class="col-lg-12">
                  <div id="accordion${index}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
                    <div class="card">
                      <div class="card-header" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion${index}" href="#collapseOne${index}" aria-expanded="true" aria-controls="collapseOne${index}" class="tx-secondary tx-gray-800 transition collapsed">
                          <div class="${info_principal.situacion_imputado==1?'situacion_imputado_activo':'situacion_imputado_otro'}">
                            Situación: ${info_principal.situacion??''} ${ info_principal.situacion_imputado == 0 ? '.    Motivo: '+(info_principal.motivo_estatus_actividad??'Sin motivo'):'' }
                          </div>
                          <span>
                            <i class="fas fa-user fa-lg" style="color:${color_situacion}; margin-right: 1%;" title="${title}" ></i>
                            ${razon_social==null?'':razon_social}  ${nombre==null?'':nombre}   ${apellido_paterno==null?'':apellido_paterno}   ${apellido_materno==null?'':apellido_materno}   
                            [ ${calidad_juridica} ] &nbsp; &nbsp; [ REGISTRADO EN: ${origen.replaceAll('_',' ').toUpperCase()} ]
                          </span>
                        </a> 
                      </div>

                      <div id="collapseOne${index}" class="collapse" role="tabpanel" aria-labelledby="headingOne${index}">
                        <div class="card-body">
                          ${table}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              `);
            }); // foreach
          }else{
            $("#divPartesProcesales").append('<div class="col-lg-12">Sin partes procesales <br></div>');
          } // if status==100
        } // success
      }); // ajax
    }

    /***********************************
    *
    *  BORRAR PARTE PROCESAL
    *
    ***********************************/
    @if( isset($permisos[86]) and $permisos[86] == 1 )
      function borrarParteProcesal( indexPP ){
        let validate = false;
        let id_persona_deleted = arrPP[ indexPP ].info_principal.id_persona;
        $( arrPP ).each(function(index, persona){
          if( persona.info_principal.id_persona != id_persona_deleted && persona.info_principal.id_calidad_juridica == 46 )
          {  validate = true; }
        });

        if( !validate ){
          modal_error('Para poder borrar esta parte procesal, deberás agregar primeramente otro imputado','modalAdministracion');
          return false;
        }

        console.log(arrPP[indexPP]);
      
        $.ajax({
          method:'POST',
          url:'/public/borrar_parte_procesal',
          data:{
            id_carpeta : $("#id_carpeta_judicial").val(),
            id_solicitud : arrPP[indexPP].info_principal.id_solicitud, //$("#id_solicitud").val(),
            tipo_solicitud : $("#tipo_solicitud").val(),
            id_persona : arrPP[indexPP].info_principal.id_persona,
          },
          success:function(response){
            console.log(response);
            if(response.status==100){
              modal_success(`Parte procesal borrada exitosamente`,'modalAdministracion');
              limpiarFormularioParteProcesal();
              pintarPersonas();
              pintarDelitosSinRelacionar()
            }else{
              modal_error(response.message,'modalAdministracion');
            }
          }
        });
      }
    @endif
    /************************
    *
    * MODIFICAR BANDERA IDENTIDAD DE PARTE PROCESAL
    *
    ************************/
    @if( isset($permisos[84]) and $permisos[84] == 1 )
      function modificarBanderaIdentidad(indexPP,showConfirm=true){
        let bandera_identidad_reservada = arrPP[ indexPP ].info_principal.bandera_identidad_reservada;
        bandera_identidad_reservada = bandera_identidad_reservada==1?0:1;
        $(`#identidad_reservada_${indexPP}`).prop('checked', false).parent().removeClass('active');

        if( showConfirm ){
          let title = 'CAMBIAR FORMA DE MOSTRAR LA PARTE PROCESAL';
          let body = bandera_identidad_reservada==0 ? '¿ESTAS SEGURO DE QUERER MOSTRAR EL NOMBRE COMPLETO DE LA PARTE PROCESAL?' : '¿ESTAS SEGURO DE QUERER MOSTRAR LA PARTE PROCESAL COMO IDENTIDAD RESERVADA?' ;
          body = body + '<br> <small> Presione ACEPTAR si estás seguro O CANCELAR si no lo estás </small>';
          modal_confirm(title,body,`modificarBanderaIdentidad(${indexPP},false)`,'modalAdministracion');
          return false;
        }

        console.log('Modificar parte procesal: ',bandera_identidad_reservada, arrPP[ indexPP ]);

        $.ajax({
          method:'POST',
          url:'/public/modificar_bandera_identidad_parte_procesal',
          data:{
            id_carpeta : $("#id_carpeta_judicial").val(),
            id_solicitud : $("#id_solicitud").val(),
            tipo_solicitud : $("#tipo_solicitud").val(),
            id_persona : arrPP[indexPP].info_principal.id_persona,
            bandera_identidad_reservada : bandera_identidad_reservada
          },
          success:function(response){
            console.log(response);
            if(response.status==100){
              modal_success(`La parte procesal se mostrará ${bandera_identidad_reservada==1? 'como IDENTIDAD RESERVADA' : 'con NOMBRE COMPLETO'}`,'modalAdministracion');
              limpiarFormularioParteProcesal();
              pintarPersonas();
              pintarDelitosSinRelacionar()
            }else{
              modal_error(response.message,'modalAdministracion');
            }
          }
        });
      }
    @endif

    /************************
    *
    * PARTE PROCESAL EN EDICION
    *
    *************************/
    @if( isset($permisos[84]) and $permisos[84] == 1 )
      function editarParteProcesal(indexPP, tag_btn_toggle){
        limpiarFormularioParteProcesal();
        setTimeout(function(){ cargaParteProcesalAEdicion(indexPP); },200);
        $( "#collapseOne"+indexPP ).collapse('hide');
      }

      function cargaParteProcesalAEdicion(indexPP){
        console.log( indexPP, arrPP);

        const {alias,contacto,datos,delitos,delitos_estadisticos,direcciones,info_principal}=arrPP[indexPP];

        const {apellido_materno,apellido_paterno,calidad_juridica,cedula_profesional,curp,edad,es_mexicano,estado_civil,fecha_nacimiento,folio_identificacion,genero,id_calidad_juridica,id_estado_civil,id_tipo_identificacion,id_nacionalidad,id_persona,id_persona_defensor,id_persona_fiscalia,lugar_reclusorio,nacionalidad,nombre,origen,otra_identificacion,otra_nacionalidad,otro_lugar_retencion,razon_social,reclusorio_detencion,requiere_defensoria,rfc_empresa,tipo_defensor,tipo_identificacion,tipo_persona,} = info_principal;
        $("#titleAccordionNuevaParteProcesal").html(`Editando a ${razon_social==null?'':razon_social}  ${nombre==null?'':nombre}   ${apellido_paterno==null?'':apellido_paterno}   ${apellido_materno==null?'':apellido_materno}    [ ${calidad_juridica} ]`);
        $("#titleAccordionNuevaParteProcesal").removeClass(`bkg-collapsed-btn`);
        $("#titleAccordionNuevaParteProcesal").addClass(`bkg-collapsed-btn-edit`);

        $('#id_persona').val(id_persona);

        if($('#tipoParte').hasClass('select2-hidden-accessible')){
          $('#tipoParte').select2('destroy');
          $('#tipoParte').val(id_calidad_juridica);
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
        let nacionalidad_val = es_mexicano=='si' ? ( otra_nacionalidad != null ? 'mexicana_otro' : 'mexicana'  ) : 'extranjero';
        $('#nacionalidad').val(nacionalidad_val).select2({minimumResultsForSearch: Infinity});
        if( otra_nacionalidad==null ){
          $('#otraNacionalidad').attr('disabled', true).val('');
          if($('#otraNacionalidad').hasClass('select2-hidden-accessible')){
            $('#otraNacionalidad').select2('destroy');
            $('#otraNacionalidad').val(9999);
            setTimeout(()=>{ $('#otraNacionalidad').select2({minimumResultsForSearch: ''}); },150);
          }
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

        $('#identificacion').val(id_tipo_identificacion);
        $('#identificacion').change();

        $('#curp').val(curp);
        $('#rfc').val(rfc_empresa);
        $('#cedulaProfesional').val(cedula_profesional);
        $('#nombre').val(nombre);
        $('#apellidoPaterno').val(apellido_paterno);
        $('#apellidoMaterno').val(apellido_materno);
        $('#genero').val(genero).select2({minimumResultsForSearch: Infinity});
        $('#estadoCivil').val(id_estado_civil).select2({minimumResultsForSearch: Infinity});
        $('#fechaNacimiento').val( fecha_nacimiento ? fecha_nacimiento.split('-').reverse().join('-') : '');
        $('#edad').val(edad);
        $('#razonSocial').val(razon_social);

        $('#escolaridad').select2('destroy');
        $('#sabe_leer_escribir').select2('destroy');
        $('#entiende_idioma_espanol').select2('destroy');
        $('#poblacion_callejera').select2('destroy');
        $('#requiere_interprete').select2('destroy');
        $('#requiere_traductor').select2('destroy');
        $('#ocupacion').select2('destroy');
        $('#religion').select2('destroy');
        $('#grupo_etnico').select2('destroy');
        $('#capacidades_diferentes').select2('destroy');
        $('#lengua').select2('destroy');
        $('#poblacion').select2('destroy');
        $('#idioma_traductor').select2('destroy');

        $('#pais_nac').select2('destroy');
        $('#estado_nac').select2('destroy');
        $('#municipio_nac').select2('destroy');
        $('#discapacidad').select2('destroy');
        $('#condicion_migratoria').select2('destroy');
        $('#habla_lengua_indigena').select2('destroy');
        $('#habla_lengua_extranjera').select2('destroy');
        $('#lengua_extranjera').select2('destroy');
        


        //const {capacidad_diferente,capacidades_diferentes,descripcion_discapacidad,entiende_idioma_espanol,grupo_etnico,id_datos_persona,id_escolaridad,id_grupo_etnico,id_lengua,id_lgbttti,id_nivel_escolaridad,id_religion,idioma_traductor,lengua,nivel_escolaridad,nombre_poblacion,nombre_religion,otra_escolaridad,otra_ocupacion,otra_poblacion,otra_religion,otro_grupo_etnico,otro_idioma_traductor,pertenece_grupo_etnico,poblacion,poblacion_callejera,requiere_interprete,requiere_traductor,sabe_leer_escribir,tipo_interprete,tipo_ocupacion}=datos[0];
        var otra_ocupacion = datos.length ? datos[0].otra_ocupacion : null;
        var nivel_escolaridad = datos.length ? datos[0].nivel_escolaridad : null;
        var otra_escolaridad = datos.length ? datos[0].otra_escolaridad : null;
        var nombre_religion = datos.length ? datos[0].nombre_religion : null;
        var otra_religion = datos.length ? datos[0].otra_religion : null;
        var grupo_etnico = datos.length ? datos[0].grupo_etnico : null;
        var otro_grupo_etnico = datos.length ? datos[0].otro_grupo_etnico : null;
        var lengua = datos.length ? datos[0].lengua : null;
        
        var descripcion_discapacidad = datos.length ? datos[0].descripcion_discapacidad : null;
        var sabe_leer_escribir = datos.length ? datos[0].sabe_leer_escribir : null;
        var poblacion_callejera = datos.length ? datos[0].poblacion_callejera : null;
        var poblacion = datos.length ? datos[0].poblacion : null;
        var otra_poblacion = datos.length ? datos[0].otra_poblacion : null;
        var nombre_poblacion = datos.length ? datos[0].nombre_poblacion : null;
        var entiende_idioma_espanol = datos.length ? datos[0].entiende_idioma_espanol : null;
        var requiere_interprete = datos.length ? datos[0].requiere_interprete : null;
        var tipo_interprete = datos.length ? datos[0].tipo_interprete : null;
        var requiere_traductor = datos.length ? datos[0].requiere_traductor : null;
        var idioma_traductor = datos.length ? datos[0].idioma_traductor : null;
        var otro_idioma_traductor = datos.length ? datos[0].otro_idioma_traductor : null;
        var id_escolaridad = datos.length ? datos[0].id_escolaridad : null;
        var tipo_ocupacion = datos.length ? datos[0].tipo_ocupacion : null;
        var id_religion = datos.length ? datos[0].id_religion : null;
        var id_grupo_etnico = datos.length ? datos[0].id_grupo_etnico : null;
        var capacidades_diferentes = datos.length ? datos[0].capacidades_diferentes : null;
        var id_lengua = datos.length ? datos[0].id_lengua : null;
        var id_lgbttti = datos.length ? datos[0].id_lgbttti : null;

        var id_pais = datos.length ? datos[0].id_pais : null;
        var id_estado = datos.length ? datos[0].id_estado : null;
        var id_municipio = datos.length ? datos[0].id_municipio : null;
        var capacidad_diferente = datos.length ? datos[0].capacidad_diferente : null;
        var condicion_migratoria = datos.length ? datos[0].condicion_migratoria : null;
        var habla_lengua_indigena = datos.length ? (datos[0].id_lengua != null ? 'si' : 'no') : null;
        var habla_lengua_extranjera = datos.length ? (datos[0].lengua_extranjera != null ? 'si' : 'no') : null;
        var lengua_extranjera = datos.length ? datos[0].id_lengua_extranjera : null;

        var procesos_multiples = datos.length ? datos[0].procesos_multiples : null;
        var relacion_imputado = datos.length ? datos[0].relacion_imputado : null;
        var utilizo_medio_tecnologico = datos.length ? datos[0].utilizo_medio_tecnologico : null;
        var condicion_embarazo = datos.length ? datos[0].condicion_embarazo : null;

        console.log(datos);
        $('#escolaridad').val( id_escolaridad != null ? id_escolaridad : '10'  ).select2({minimumResultsForSearch: Infinity});
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

        $('#pais_nac').val( id_pais != null ? id_pais : ''  ).select2({minimumResultsForSearch: ''});
        $('#estado_nac').val( id_estado != null ? id_estado : ''  ).select2({minimumResultsForSearch: ''});
        $('#discapacidad').val( capacidad_diferente != null ? capacidad_diferente : ''  ).select2({minimumResultsForSearch: Infinity});
        $('#condicion_migratoria').val( condicion_migratoria != null ? condicion_migratoria : ''  ).select2({minimumResultsForSearch: Infinity});
        $('#habla_lengua_indigena').val( habla_lengua_indigena != null ? habla_lengua_indigena : ''  ).select2({minimumResultsForSearch: Infinity});
        $('#habla_lengua_extranjera').val( habla_lengua_extranjera != null ? habla_lengua_extranjera : ''  ).select2({minimumResultsForSearch: Infinity});
        $('#lengua_extranjera').val( lengua_extranjera != null ? lengua_extranjera : ''  ).select2({minimumResultsForSearch: Infinity});

        $('#escolaridad').change();
        $('#sabe_leer_escribir').change();
        $('#entiende_idioma_espanol').change();
        $('#poblacion_callejera').change();
        $('#requiere_interprete').change();
        $('#requiere_traductor').change();
        $('#ocupacion').change();
        $('#religion').change();
        $('#grupo_etnico').change();
        $('#capacidades_diferentes').change();
        $('#lengua').change();
        $('#poblacion').change();
        $('#idioma_traductor').change();

        $('#pais_nac').change();
        $('#estado_nac').change();
        $('#discapacidad').change();
        $('#condicion_migratoria').change();
        $('#habla_lengua_indigena').change();
        $('#habla_lengua_extranjera').change();
        $('#lengua_extranjera').change();
        
        $('#otra_escolaridad').val(otra_escolaridad);
        $('#discapacidad').val(capacidad_diferente);
        //$('#nombre_poblacion').val(capacidad_diferente);

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
            sAlias=sAlias.concat(`
              <div class="col-lg-6 pretty-box datos-alias" data-id="${ali.id_alias}" data-status="1" data-indexp="${indexPP}">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Alias:</label> <span class="f-right tx-danger"><i class="fa fa-close borrar-alias"></i></span>
                  <input class="form-control alias" type="text" name="alias" autocomplete="off" value="${ali.alias}" data-indexp="${indexPP}">
                </div>
              </div><!-- col-6-->
            `);
          });
          $('#datosAlias').html(sAlias);
        }

        if(contacto.length){
          sCorreos='';
          sTelefonos='';
          $(contacto).each(function(index_contacto, uncontacto){
            if( uncontacto.tipo_contacto == "correo electronico" ){
              sCorreos=sCorreos.concat(`
                <div class="col-6 pretty-box datos-correo" data-id="${uncontacto.id_contacto_persona}" data-status="1" data-indexp="${indexPP}">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Correo Electrónico:</label> <span class="f-right tx-danger"><i class="fa fa-close borrar-correo"></i></span>
                    <input class="form-control correo-electronico" type="text" name="correo_electronico" autocomplete="off" value="${uncontacto.contacto}">
                  </div>
                </div><!-- col-3-->

              `);
            }else{
              sTelefonos=sTelefonos.concat(`
                <div class="col-lg-6 pretty-box">
                  <div class="row datos-telefono"  data-id="${uncontacto.id_contacto_persona}" data-status="1" data-indexp="${indexPP}">
                    <div class="col-12">
                      <p class="tx-right tx-danger"><i class="fa fa-close borrar-telefono"></i></p>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label">Tipo: </label>
                        <select class="form-control tipo-telefono"  name="tipo_telefono" autocomplete="off">
                            <option value="fijo" ${uncontacto.tipo_contacto=='fijo'?'selected':''}>Fijo</option>
                            <option value="celular" ${uncontacto.tipo_contacto=='celular'?'selected':''}>Celular</option>
                        </select>
                      </div>
                    </div><!-- col-3-->
                    <div class="col-lg-6">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Número:</label>
                        <input class="form-control numero-telefono" type="text" name="numero_telefono" autocomplete="off" value="${uncontacto.contacto}">
                      </div>
                    </div><!-- col-3-->
                    <div class="col-lg-3">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Extension:</label>
                        <input class="form-control extension" type="text" name="estension" autocomplete="off" value="${uncontacto.extension?uncontacto.extension:'' }">
                      </div>
                    </div><!-- col-3-->
                  </div>
                </div>
              `);
            }

          });
          $('.tipo-telefono').select2({minimumResultsForSearch: Infinity});;
          $('#telefonos').html(sTelefonos);
          $('#correos').html(sCorreos);
        }

        if(direcciones.length){
          sDirecciones='';
          $(direcciones).each(function(index_direcciones, direccion){
            let inputID = get_unique_id();
            const {calle,codigo_postal,colonia,cve_PGJ,cve_estado,cve_municipio,entidad_federativa,entre_calles,estado,estatus,id_direccion_persona,id_pais,id_estado,id_municipio,localidad,municipio,municipio_importacion,no_exterior,no_interior,referencias}=direccion;

            let estados='<option>Elija una opción</option>';

            $(catalogoEstados).each(function(index_estados, datosEstado){

              if(id_estado==datosEstado.id_estado){
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

                    if(datosMunicipio.id_municipio==id_municipio){
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

            let paises = '<option>Elija una opción</option>';
            $(catalogopPaises).each(function(index_paises, datosPais){

              if(id_pais==datosPais.id_pais){
                const option=`<option value="${datosPais.id_pais}"  selected>${datosPais.descripcion}</option>`;
                paises=paises.concat(option);
              }else{
                const option=`<option value="${datosPais.id_pais}">${datosPais.descripcion}</option>`;
                paises=paises.concat(option);
              }
            });


            setTimeout(function(){
              sDirecciones=sDirecciones.concat(`
                <div class="row datos-domicilio"  data-id="${id_direccion_persona}" data-status="1" data-indexp="${indexPP}">
                  <div class="col-12">
                    <p class="tx-right tx-danger"><i class="fa fa-close borrar-domicilio" data-index="${index_direcciones}" data-indexp="${indexPP}"></i></p>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label">País de residencia: </label>
                      <select class="form-control pais_resi" id="pais_resi${inputID}" name="pais_resi" autocomplete="off">
                        ${paises}
                      </select>
                    </div>
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
                  <div class="col-lg-8">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Colonia:</label>
                      <input class="form-control colonia" type="text" name="colonia"  autocomplete="off"  value="${colonia==null?'':colonia}" id="colonia${inputID}">
                    </div>
                  </div><!-- col-4 -->
                  <div class="col-lg-4">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Código Postal:</label>
                      <input class="form-control codigoPostal" type="text" name="codigo_postal" autocomplete="off" value="${codigo_postal==null?'':codigo_postal}" id="codigoPostal${inputID}">
                    </div>
                  </div><!-- col-4 -->
                  <div class="col-lg-6">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Calle:</label>
                      <input class="form-control calle" type="text" name="calle" autocomplete="off"  value="${calle==null?'':calle}" id="calle${inputID}">
                    </div>
                  </div><!-- col-4 -->
                  <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Número Exterior:</label>
                      <input class="form-control numeroExterior" type="text" name="numero_exterior" autocomplete="off" value="${no_exterior==null?'':no_exterior}" id="numeroExterior${inputID}">
                    </div>
                  </div><!-- col-4 -->
                  <div class="col-lg-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Número Interior:</label>
                      <input class="form-control numero_interior" type="text" name="numero_interior"  autocomplete="off"  value="${no_interior==null?'':no_interior}" id="numeroInterior${inputID}">
                    </div>
                  </div><!-- col-4-->
                  <div class="col-lg-6">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Entre la Calle:</label>
                      <input class="form-control entreCalle" type="text" name="entre_calle" autocomplete="off"  value="${entre_calles==null?'':entre_calles}" id="entreCalle${inputID}">
                    </div>
                  </div><!-- col-4-->
                  <div class="col-lg-6">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Otras Referencias:</label>
                      <input class="form-control otrasReferencias" type="text" name="otras_referencias" autocomplete="off"  value="${referencias==null?'':referencias}" id="otrasReferencias${inputID}">
                    </div>
                  </div><!-- col-4-->
                </div>
              `);

              $('#domicilios').html(sDirecciones);
            },500);

            setTimeout(function(){
              $('#estado'+inputID).select2({minimumResultsForSearch: ''});
              $('#municipio'+inputID).select2({minimumResultsForSearch: ''});
              $('#pais_resi'+inputID).select2({minimumResultsForSearch: ''});

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

        if(delitos.length){
          sDelitos='';

          console.log("delitos:",delitos);
          
          $(delitos).each(function(index_delito, delito){
            let inputID = get_unique_id();

            let cat_delitos='<option>Elija una opción</option>';

            $(catalogoDelitos).each(function(cat_index_delitos, undelito){
              const option=`<option value="${undelito.id_delito}" data-grave="${undelito.delito_oficioso==1?'si':'no'}" ${undelito.id_delito == delito.id_delito_persona_delito?'selected':''}>${undelito.delito}</option>`;
              cat_delitos=cat_delitos.concat(option);
            });

            var cat_modalidades=`<option>Elija una opción</option>`;

            let calificativos='<option>Elija una opción</option>';
            $(catalogoCalificativos).each(function(index_cal, calificativo){
              const option=`<option value="${calificativo.id_calificativo}" ${calificativo.id_calificativo==delito.id_calificativo?'selected':''}>${calificativo.calificativo}</option>`;
              calificativos=calificativos.concat(option);
            });

            setTimeout(function(){
              //console.log(cat_modalidades);
              sDelitos=sDelitos.concat(`
                <div class="row datos-delito" id="datos-delito${inputID}" data-id="${delito.id_persona_delito}" data-status="1" data-indexp="${indexPP}" style="border: 1px solid #848f33; margin: 2% 0; padding: 10px; position:relative;">
                  
                  <div style="position:absolute;position: absolute; left: 0; top: 0; padding: 4px; font-size: 0.8em; background: #848f3382; color: #fff;">
                    Delito
                  </div>

                  <div class="col-12">
                    <p class="tx-right tx-danger" style="cursor:pointer;"><i class="fa fa-close borrar-delito"></i></p>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Delito: <span class="tx-danger">*</span></label>
                      <select class="form-control delito" id="delito${inputID}" name="delito" autocomplete="off" onchange="obtener_modalidades( this , '#modalidadDelito${inputID}' )">
                        ${cat_delitos}
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Modalidad de Delito:</label>
                      <select class="form-control select2 modalidad-delito" id="modalidadDelito${inputID}" name="modalidad_delito" autocomplete="off">
                          ${cat_modalidades}
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Calificativo: <span class="tx-danger">*</span></label>
                      <select class="form-control select2 calificativo" id="calificativo${inputID}" name="calificativo" autocomplete="off">
                        ${calificativos}
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label">Grado de Realización: <span class="tx-danger">*</span></label>
                      <select class="form-control select2 grado-realizacion" id="gradoRealizacion${inputID}" name="grado_realizacion" autocomplete="off">
                          <option disabled value="">Elija una opción</option>
                          <option ${delito.grado_realizacion=="de_tentetiva"?'selected':''} value="de_tentetiva">DE TENTATIVA</option>
                          <option ${delito.grado_realizacion=="consumado"?'selected':''} value="consumado">CONSUMADO</option>
                          <option ${delito.grado_realizacion=="por_definir"?'selected':''} value="por_definir">POR DEFINIR</option>
                      </select>
                    </div>
                  </div>

                 </div>
              `);
              $('#delitos').append(sDelitos);

              setTimeout(()=>{

                $('#delito'+inputID).select2({minimumResultsForSearch: ''});
                $('#modalidadDelito'+inputID).select2({minimumResultsForSearch: ''});
                $('#calificativo'+inputID).select2({minimumResultsForSearch: ''});
                $('#gradoRealizacion'+inputID).select2({minimumResultsForSearch: ''});

                obtener_modalidades( '#delito'+inputID , '#modalidadDelito'+inputID , delito.id_modalidad );
              },100 + (index_delito * 100 ));
            },2000 + (index_delito * 100 ));
          });


        }

        if(delitos_estadisticos.length){
          $(delitos_estadisticos).each(function(index_delito, delito){
            
            const inputID = get_unique_id();
            
            $('#delitos').append(`
              <div class="row datos-delito" id="datos-delito-${inputID}" data-id="${delito.id_persona_delito}" data-status="1" data-indexp="${indexPP}" data-tipo="estadistica" style="position:relative;border: 1px solid #848f33; margin: 2% 0; padding: 10px;">
                
                <div style="position:absolute;position: absolute; left: 0; top: 0; padding: 4px; font-size: 0.8em; background: #848f3382; color: #fff;">
                  Delito Estadistico
                </div>
                
                <div class="col-12">
                  <p class="tx-right tx-danger" style="cursor:pointer;"><i class="fa fa-close borrar-delito"></i></p>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label">Delito:<span class="tx-danger">*</span> <span style="font-weight: bolder; font-size: 1rem;" id="descripcion-0-${inputID}"></span> </label>
                    <select class="form-control tipo_delictivo" id="tipo_delictivo-${inputID}" name="tipo_delictivo" autocomplete="off" onchange="cargar_desagregados_PP( this , 0 , ${inputID})">
                        <option selected disabled value="0">Elija una opción</option>
                        @foreach ($desagregados_estadisticos as $delito)
                          <option value="{{$delito['id']}}">{{$delito['descripcion']}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

                {{-- Deagregados --}}
                <div id="datos-delitoE-${inputID}" style="margin-bottom:1rem; width:100%;"></div>
    
                {{-- Calificativo --}}
                <div class="col-lg-6 mb-3">
                  <div class="form-group">
                    <label class="form-control-label">Calificativo: </label>
                    <select class="form-control calificativo" id="calificativo-${inputID}" name="calificativo-${inputID}" autocomplete="nope">
                        <option selected disabled value="">Elija una opción</option>
                        @foreach ($calificativos as $calificativo)
                            <option value="{{$calificativo['id_calificativo']}}">{{mb_strtoupper($calificativo['calificativo'])}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
    
                {{-- Grado de Realización --}}
                <div class="col-lg-6 mb-3">
                  <div class="form-group">
                    <label class="form-control-label">Grado de Realización: </label>
                    <select class="form-control gradoRealizacion" id="gradoRealizacion-${inputID}" name="grado_realizacion-${inputID}" autocomplete="nope">
                        <option selected disabled value="">Elija una opción</option>
                        <option value="de_tentetiva">DE TENTATIVA</option>
                        <option value="consumado">CONSUMADO</option>
                        <option value="por_definir">POR DEFINIR</option>
                    </select>
                  </div>
                </div> 
    
                {{-- Tipo de Violencia --}}
                <div class="col-lg-4 mb-3">
                  <div class="form-group">
                    <label class="form-control-label">Tipo de Violencia: </label>
                    <select class="form-control tipoViolencia" id="tipoViolencia-${inputID}" name="tipoViolencia-${inputID}" autocomplete="nope">
                        <option selected disabled value="">Elija una opción</option>
                        <option value="1">Violencia física</option>
                        <option value="2">Violencia moral</option>
                        <option value="3">Violencia fisica y moral</option>
                        <option value="0">No aplica</option>
                    </select>
                  </div>
                </div>
    
                {{-- Consignación --}}
                <div class="col-lg-4 mb-3">
                  <div class="form-group">
                    <label class="form-control-label">Consignación: </label>
                    <select class="form-control consignacion" id="consignacion-${inputID}" name="consignacion-${inputID}" autocomplete="nope">
                        <option selected disabled value="">Elija una opción</option>
                        <option value="1">Con detenido</option>
                        <option value="0">Sin detenido</option>
                    </select>
                  </div>
                </div>
    
                {{-- Entidad ocurrencia de los hechos --}}
                <div class="col-lg-4 mb-3">
                  <div class="form-group">
                    <label class="form-control-label">Entidad ocurrencia de los hechos: </label>
                    <select class="form-control estadoOcurrenciaH" name="estadoOcurrenciaH" autocomplete="off" id="estadoOcurrenciaH-${inputID}">
                        <option selected  disabled value="-">Elija una opción</option>
                        @foreach ($estados as $estado)
                            <option value="{{$estado['id_estado']}}" data-cve-estado="{{$estado['cve_estado']}}">{{$estado['estado']}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
    
                {{-- Municipio ocurrencia de los hechos --}}
                <div class="col-lg-4 mb-3">
                  <div class="form-group">
                    <label class="form-control-label">Municipio ocurrencia de los hechos: </label>
                    <select class="form-control municipioOcurrenciaH" name="municipioOcurrenciaH" autocomplete="off" id="municipioOcurrenciaH-${inputID}">
                    </select>
                  </div>
                </div>
    
                {{-- Fecha ocurrencia de los hechos --}}
                <div class="col-lg-4 mb-3">
                  <div class="form-group">
                    <label class="form-control-label">Fecha ocurrencia de los hechos: </label>
                    <input type="text" class="form-control fc-datepicker fechaOcurrenciaH" placeholder="DD/MM/AAAA" id="fechaOcurrenciaH-${inputID}" name="fechaOcurrenciaH" autocomplete="off">
                  </div>
                </div>
    
                {{-- Elementos para la comisión del delito --}}
                <div class="col-lg-4 mb-3">
                  <div class="form-group">
                    <label class="form-control-label">Elementos para la comisión del delito: </label>
                    <select class="form-control elementosComisionDel" name="elementosComisionDel" autocomplete="off" id="elementosComisionDel-${inputID}">
                        <option selected disabled  value="-">Elija una opción</option>
                        @foreach ($elementos_comision as $comision)
                            <option value="{{$comision['id_elemento_comision_delito']}}">{{$comision['elemento_comision_delito']}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
    
                {{-- Modo en que ocurre la agresión --}}
                <div class="col-lg-4 mb-3">
                  <div class="form-group">
                    <label class="form-control-label">Modo en que ocurre la agresión: </label>
                    <select class="form-control modoOcurrenciaAgresion" name="modoOcurrenciaAgresion" autocomplete="off" id="modoOcurrenciaAgresion-${inputID}">
                        <option selected  disabled value="-">Elija una opción</option>
                        @foreach ($modalidad_agresion as $magresion)
                            <option value="{{$magresion['id_modalidad_agresion']}}">{{$magresion['modalidad_agresion']}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

              </div>
            `);
            
            setTimeout(()=>{
              $('#tipo_delictivo-'+inputID).select2({minimumResultsForSearch: ''});
              
              if( delito.id_desagregado_n1 != null ) setTimeout(()=>{ $(`#desagregado_n1-${inputID}`).val(delito.id_desagregado_n1).trigger("change"); }, 200);
              if( delito.id_desagregado_n2 != null ) setTimeout(()=>{ $(`#desagregado_n2-${inputID}`).val(delito.id_desagregado_n2).trigger("change"); }, 200);
              if( delito.id_desagregado_n3 != null ) setTimeout(()=>{ $(`#desagregado_n3-${inputID}`).val(delito.id_desagregado_n3).trigger("change"); }, 200);
              if( delito.id_desagregado_n4 != null ) setTimeout(()=>{ $(`#desagregado_n4-${inputID}`).val(delito.id_desagregado_n4).trigger("change"); }, 200);
              if( delito.otro_delito != null ) setTimeout(()=>{ $(`#otro-${inputID}`).val(delito.otro_delito); }, 200);

              $('#calificativo-'+inputID).select2({minimumResultsForSearch: ''});
              $('#gradoRealizacion-'+inputID).select2({minimumResultsForSearch: ''});
              $('#tipoViolencia-'+inputID).select2({minimumResultsForSearch: ''});
              $('#consignacion-'+inputID).select2({minimumResultsForSearch: ''});
              $('#estadoOcurrenciaH-'+inputID).select2({minimumResultsForSearch: ''});
              $('#municipioOcurrenciaH-'+inputID).select2({minimumResultsForSearch: ''});
              $('#elementosComisionDel-'+inputID).select2({minimumResultsForSearch: ''});
              $('#modoOcurrenciaAgresion-'+inputID).select2({minimumResultsForSearch: ''});
    
              $('.fc-datepicker').datepicker({dateFormat:'yy-mm-dd',firstDay: 1})
    
              $('#estadoOcurrenciaH-'+inputID).on('change',function(){
                const selectMunicipio=$('#municipioOcurrenciaH-'+inputID);
                const estado=$(this).find('option:selected').attr('data-cve-estado');
                $.ajax({
                  type:'POST',
                  url:'/public/obtener_municipios',
                  data:{
                  estado,
                  },
                  success:function(response){
                    if(response.status==100){
                      let municipios='<option disabled selected >Elija una opción</option>';
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

              $('#tipo_delictivo-'+inputID).val( delito.id_tipo_delictivo ).trigger("change");
              $('#calificativo-'+inputID).val(delito.comision_delito_estadistico ).trigger("change");
              $('#gradoRealizacion-'+inputID).val(delito.grado_realizacion_estadistico ).trigger("change");
              $('#tipoViolencia-'+inputID).val(delito.tipo_violencia_estadistico ).trigger("change");
              $('#consignacion-'+inputID).val(delito.consignacion_estadistico ).trigger("change");
              $('#estadoOcurrenciaH-'+inputID).val(delito.entidad_ocurrenica_h_estadistico ).trigger("change");
              $('#elementosComisionDel-'+inputID).val(delito.elementos_comision_estadistico ).trigger("change");
              $('#fechaOcurrenciaH-'+inputID).val(delito.fecha_ocurrencia_h_estadistico );
              $('#modoOcurrenciaAgresion-'+inputID).val(delito.modo_agresion_estadistico ).trigger("change");

              setTimeout(()=>{ $('#municipioOcurrenciaH-'+inputID).val(delito.municipio_ocurrencia_h_estadistico ).trigger("change"); },400);

            },100);
           
          });
        }
        
        if(id_calidad_juridica == 46 || id_calidad_juridica == 56){
          $('#relacion_imputado_div').css('display', 'none');
          $('#utilizo_medio_tecnologico_div').css('display', 'none');
          $('#condicion_embarazo_div').css('display', 'none');

          $('#procesos_multiples_div').css('display', 'block');
          
          $('#procesos_multiples').html(`
            <option selected  value="-">Elija una opción</option>
            <option ${procesos_multiples ==1 ? 'selected' : ''} value="1">Si</option>
            <option ${procesos_multiples ==0 ? 'selected' : ''} value="0">No</option>
            <option ${procesos_multiples ==9 ? 'selected' : ''} value="9">Se desconoce</option>
          `);
        }else if(id_calidad_juridica == 1 || id_calidad_juridica == 2 || id_calidad_juridica == 7 || id_calidad_juridica == 8){
          $('#procesos_multiples_div').css('display', 'none');

          $('#relacion_imputado_div').css('display', 'block');
          $('#utilizo_medio_tecnologico_div').css('display', 'block');
          $('#condicion_embarazo_div').css('display', 'block');

          

          let relacion_imputado_op = '<option>Elija una opción</option>';
          $(catalogo_relacion_imputado).each(function(index_relacion_imputado, datosRelacion_imputado){

            if(relacion_imputado==datosRelacion_imputado.id_relacion_imputado){
              const option=`<option value="${datosRelacion_imputado.id_relacion_imputado}"  selected>${datosRelacion_imputado.relacion_imputado}</option>`;
              relacion_imputado_op=relacion_imputado_op.concat(option);
            }else{
              const option=`<option value="${datosRelacion_imputado.id_relacion_imputado}">${datosRelacion_imputado.relacion_imputado}</option>`;
              relacion_imputado_op=relacion_imputado_op.concat(option);
            }
          });

          $('#relacion_imputado').html(`${relacion_imputado_op}`);

          $('#utilizo_medio_tecnologico').html(`
            <option selected  value="-">Elija una opción</option>
            <option ${utilizo_medio_tecnologico == 1 ? 'selected':''} value="1">Si</option>
            <option ${utilizo_medio_tecnologico == 0 ? 'selected':''} value="0">No</option>
          `);
          $('#condicion_embarazo').html(`
            <option selected  value="-">Elija una opción</option>
            <option ${condicion_embarazo == 1 ? 'selected': 0} value="1">Si</option>
            <option ${condicion_embarazo == 0 ? 'selected': 0} value="0">No</option>
          `);
        }

        $('#botonesPartes').append(`
          <button type="button" class="btn btn-secondary d-inline-block btn-edicion mg-l-auto" onclick="limpiarFormularioParteProcesal()">Cancelar</button>
          <button class="btn btn-primary d-inline-block   btn-edicion mg-l-5"  onclick="guardarCambiosParteProcesal(${indexPP})">Guardar Edición</button>
        `);

        $('#agregarParte').addClass('d-none').removeClass('d-inline-block');

        setTimeout(function(){
          $('#collapseOneNuevaParteProcesal').collapse('show');
          $('#collapseAlias').collapse('show');
          $('#collapseContacto').collapse('show');
          $('#collapseDatosAdicionales').collapse('show');
          $('#collapseDelitos').collapse('show');
          $("#nombre").focus();
          $('#municipio_nac').val( id_municipio != null ? id_municipio : ''  ).select2({minimumResultsForSearch: ''});
          $('#municipio_nac').change();
          $('#procesos_multiples').select2({minimumResultsForSearch: ''});
          $('#relacion_imputado').select2({minimumResultsForSearch: ''});
          $('#utilizo_medio_tecnologico').select2({minimumResultsForSearch: ''});
          $('#condicion_embarazo').select2({minimumResultsForSearch: ''});
          $('#condicion_migratoria').select2({minimumResultsForSearch: ''});
          $('#lengua_extranjera').select2({minimumResultsForSearch: ''});
        },200);
      }
    @endif

    /****************************
    * MUESTRA HISTORIAL DE DELITO
    ******************************/

    function mostrarHistorialDelito(indexPP,indexDelito){
      let delito = arrPP[ indexPP ].delitos[indexDelito];
      let title = "HISTORIAL DEL DELITO: "+delito.delito.toUpperCase();
      let body = ``;
      let listaDelitos=``;

      $.ajax({
        method:'POST',
        url:'/public/consulta_historial',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          historial: 'delitos',
          id_delito: delito.id_persona_delito,
        },
        success:function(response){
          console.log(response);
          if(response.status==100){
            $(response.response).each(function(index_d,delito){
              listaDelitos=listaDelitos.concat(`
                <tr>
                  <td>${delito.creacion != null ? delito.creacion.toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                  <td>${delito.delito != null ? delito.delito.toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                  <td>${delito.nombre_modalidad != null ? delito.nombre_modalidad.toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                  <td>${delito.calificativo != null ? delito.calificativo.toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                  <td>${delito.grado_realizacion != null ? delito.grado_realizacion.replaceAll('_',' ').toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                </tr>
              ` );
            });
            body = `
              <div class="row">
                <div class="col-lg-12">
                  <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                    <thead>
                        <tr>
                          <th class="tx-center" style="background:#f8f9fa">Fecha</th>
                          <th class="tx-center" style="background:#f8f9fa">Delito</th>
                          <th class="tx-center" style="background:#f8f9fa">Modalidad delito</th>
                          <th class="tx-center" style="background:#f8f9fa">Calificativo</th>
                          <th class="tx-center" style="background:#f8f9fa">Grado realización</th>
                        </tr>
                      </thead>
                    <tbody class="table-datos-sujeto">
                    ${ listaDelitos.length ? listaDelitos : '<tr><td colspan="4"><span class="tx-italic">Sin delitos</span></td></tr>' }
                    </tbody>
                  </table>
                </div>
              </div>
            `;
            modal_historial(title,body,'modalAdministracion');
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax

    }

    function mostrarHistorialDelitoEstadistico(indexPP,indexDelito){
      let delito = arrPP[ indexPP ].delitos_estadisticos[indexDelito];
      let title = "HISTORIAL DEL DELITO: "+delito.tipo_delictivo.toUpperCase();
      let body = ``;
      let listaDelitos=``;

      $.ajax({
        method:'POST',
        url:'/public/consulta_historial',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          historial: 'delitos',
          id_delito: delito.id_persona_delito,
        },
        success:function(response){
          console.log(response);
          if(response.status==100){
            $(response.response).each(function(index_d,delito){
              listaDelitos=listaDelitos.concat(`
                <div class="list-group-item d-block pd-y-10" style="border: 1px solid #ccc; text-align: left !important;">
                  <div class="d-flex justify-content-between align-items-center tx-12">
                    <span>${delito.titulo}</span>
                  </div><!-- d-flex -->
                  <div class="d-flex justify-content-between align-items-center tx-12 mg-b-10">
                    <span>${delito.capitulo}</span>
                    <span>${delito.creacion}</span>
                  </div><!-- d-flex -->
                  
                  <h6 class="lh-3 mg-b-0"><span class="tx-inverse">${delito.tipo_delictivo}</span></h6>
                  <span class="tx-13 mg-b-0 ${delito.desagregado_n1 != null ? '' : 'd-none'}">${delito.desagregado_n1} <small>${delito.fundamento_n1 != null ? '' : 'Fdto. '+delito.fundamento_n1}</small> <br></span>
                  <span class="tx-13 mg-b-0 ${delito.desagregado_n2 != null ? '' : 'd-none'}">${delito.desagregado_n2} <small>${delito.fundamento_n2 != null ? '' : 'Fdto. '+delito.fundamento_n2}</small> <br></span>
                  <span class="tx-13 mg-b-0 ${delito.desagregado_n3 != null ? '' : 'd-none'}">${delito.desagregado_n3} <small>${delito.fundamento_n3 != null ? '' : 'Fdto. '+delito.fundamento_n3}</small> <br></span>
                  <span class="tx-13 mg-b-0 ${delito.desagregado_n4 != null ? '' : 'd-none'}">${delito.desagregado_n4} ${delito.otro_delito != null ? ': '+delito.otro_delito : ''  } </span>
                </div>
              ` );
            });
            body = `
              <div class="row">
                <div class="col-md-12 col-lg-12">
                  <div class="list-group">
                    <div class="list-group-item d-block pd-y-5" style="border: 1px solid #ccc; font-weight: bolder;">
                      <div class="d-flex justify-content-between align-items-center tx-14">
                        <span>Historial Delito Estadístico</span>
                        <span>${response.response.length}</span>
                      </div>
                    </div>
                    ${ listaDelitos.length ? listaDelitos : '<div class="list-group-item d-block pd-y-10" style="border: 1px solid #ccc;"><p class="tx-13 mg-b-0">Sin Historial</p></div>' }
                  </div>
                </div>
              <div
            `;
            modal_historial(title,body,'modalAdministracion');
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax

    }

    /************************
    *
    * ACTUALIZANDO PARTE PROCESAL
    *
    *************************/

    function guardarCambiosParteProcesal(indexPP){
      
      $('.error').removeClass('error');

      var validacion=validaDatosParteProcesal();
      if(validacion!=100){
        const {campo , error} = validacion;
        if($(campo).is('select')){
          $(`#select2-${campo.replaceAll("#","")}-container`).focus().addClass('error');
        }else{
          $(campo).focus().addClass('error');
        }
        modal_error(error,'modalAdministracion');
        return false;
      }


      if(arrPP[ indexPP ].info_principal.id_calidad_juridica == 46 && $("#tipoParte").val() != 46 ){
        let validate = false;
        let id_persona_change = arrPP[ indexPP ].info_principal.id_persona;
        $( arrPP ).each(function(index, persona){
          if( persona.info_principal.id_persona != id_persona_change && persona.info_principal.id_calidad_juridica == 46 )
          {  validate = true; }
        });

        if( !validate ){
          modal_error('Para poder modificar la calidad juridica de esta parte procesal, deberás agregar primeramente otro imputado','modalAdministracion');
          return false;
        }
      }

      var aliasSujeto=[];
      var correos=[];
      var telefonos=[];
      var direcciones=[];
      var datosAdicionales=[];
      var delitos=[];
      var delitos_estadisticos=[];

      $('.datos-alias').each(function(){
        console.log('alias',$(this).attr('data-id'));
        aliasSujeto.push(
          { id: $(this).attr('data-id')!='-' ? Number( $(this).attr('data-id') ) : '-',
            estatus: Number( $(this).attr('data-status') ),
            alias:$(this).find('.alias').val()
          });
      });

      $('.datos-correo').each(function(){
        console.log('correo',$(this).attr('data-id'));
        correos.push(
          { id: $(this).attr('data-id')!='-' ? Number( $(this).attr('data-id') ) : '-',
            estatus: Number( $(this).attr('data-status') ),
            correo:$(this).find('.correo-electronico').val()
          });
      });

      $('.datos-telefono').each(function(){
        console.log('tel',$(this).attr('data-id'));
        telefonos.push(
          { id: $(this).attr('data-id')!='-' ? Number( $(this).attr('data-id') ) :'-',
            estatus: Number( $(this).attr('data-status') ),
            tipo:$(this).find('.tipo-telefono').val(),
            numero:$(this).find('.numero-telefono').val(),
            extension:$(this).find('.extension').val(),
          }
        );
      });

      $('.datos-domicilio').each(function(){
        console.log('dom',$(this).attr('data-id'));
        direcciones.push(
          { id: $(this).attr('data-id')!='-' ? Number( $(this).attr('data-id') ) : '-',
            estatus: Number( $(this).attr('data-status') ),
            pais_recidencia: $(this).find('.pais_resi').val() == 'Elija una opción' ? '-' : $(this).find('.pais_resi').val(),
            calle:$(this).find('.calle').val(),
            numero_exterior:$(this).find('.numeroExterior').val(),
            numero_interior:$(this).find('.numero_interior').val(),
            colonia:$(this).find('.colonia').val(),
            codigo_postal:$(this).find('.codigoPostal').val(),
            estado:$(this).find('.estado').val(),
            estado_text:$(this).find('.estado').val()==''?'':$(this).find('.estado').find('option:selected').text(),
            cve_estado:$(this).find('.estado').find('option:selected').attr('data-cve-estado'),
            municipio:$(this).find('.municipio').val(),
            municipio_text:$(this).find('.municipio').val()==''?'':$(this).find('.municipio').find('option:selected').text(),
            localidad:$(this).find('.localidad').val(),
            entre_calle:$(this).find('.entreCalle').val(),
            otra_referencia:$(this).find('.otrasReferencias').val(),
          }
        );
      });

      $('.datos-delito').each(function(){

        if( $(this).data("tipo") == "estadistica" ){
          delitos_estadisticos.push(
            { 
              id: $(this).attr('data-id')!='-' ? Number( $(this).attr('data-id') ) : '-',
              tipo_delictivo:$(this).find('.tipo_delictivo').val(),
              desagregado_n1:$(this).find('.desagregado_n1').length > 0 ? ($(this).find('.desagregado_n1').val() == null ? "-" : $(this).find('.desagregado_n1').val() ) : "-",
              desagregado_n2:$(this).find('.desagregado_n2').length > 0 ? ($(this).find('.desagregado_n2').val() == null ? "-" : $(this).find('.desagregado_n2').val() ) : "-",
              desagregado_n3:$(this).find('.desagregado_n3').length > 0 ? ($(this).find('.desagregado_n3').val() == null ? "-" : $(this).find('.desagregado_n3').val() ) : "-",
              desagregado_n4:$(this).find('.desagregado_n4').length > 0 ? ($(this).find('.desagregado_n4').val() == null ? "-" : $(this).find('.desagregado_n4').val() ) : "-",
              otro:$(this).find('.otro').length > 0 ? $(this).find('.otro').val() : "-",
              estatus:Number( $(this).attr('data-status') ),
              comision_delito_estadistico: Number( $(this).find('.calificativo').val() ), 
              grado_realizacion_estadistico: $(this).find('.gradoRealizacion').val() , 
              tipo_violencia_estadistico: Number( $(this).find('.tipoViolencia').val() ),  
              consignacion_estadistico: Number( $(this).find('.consignacion').val() ), 
              fecha_ocurrencia_h_estadistico: $(this).find('.fechaOcurrenciaH').val() , 
              entidad_ocurrenica_h_estadistico: Number( $(this).find('.estadoOcurrenciaH').val() ), 
              municipio_ocurrencia_h_estadistico: Number( $(this).find('.municipioOcurrenciaH').val() ), 
              elementos_comision_estadistico: Number( $(this).find('.elementosComisionDel').val() ), 
              modo_agresion_estadistico: Number( $(this).find('.modoOcurrenciaAgresion').val() ), 
            }
          );
          
        }else{

          delitos.push(
            { id: $(this).attr('data-id')!='-' ? Number( $(this).attr('data-id') ) : '-',
              estatus: Number( $(this).attr('data-status') ),
              id_delito:$(this).find('.delito').val(),
              delito_text:$(this).find('.delito').find('option:selected').text(),
              id_modalidad:$(this).find('.modalidad-delito').val(),
              modalidad_text:$(this).find('.modalidad-delito').find('option:selected').text(),
              id_calificativo:$(this).find('.calificativo').val(),
              calificativo_text:$(this).find('.calificativo').find('option:selected').text(),
              forma_comision:"forma",
              grado_realizacion:$(this).find('.grado-realizacion').val(),
              grado_realizacion_text:$(this).find('.grado-realizacion').find('option:selected').text(),
              delito_grave:$(this).find('.delito').find('option:selected').attr('data-grave'),
            }
          );
        }
      });
      

      console.log("alexis",delitos_estadisticos);

      const datoAdicional={
        id_datos_persona: arrPP[indexPP].datos.length ? arrPP[indexPP].datos[0].id_datos_persona : "-",
        estatus: 1,
      
        pais_nacimiento : $('#pais_nac').val(), ///Se agrego 
        estado_nacimiento : $('#estado_nac').val(), ///Se agrego 
        municipio_nacimiento : $('#estado_nac').val() == '' ? '-' : $('#municipio_nac').val(),  ///Se agrego 

        tipo_ocupacion:$('#ocupacion').val(),
        ocupacion:$('#ocupacion').val()==''?'':$('#ocupacion').find('option:selected').text(),
        otra_ocupacion:$('#otra_ocupacion').val(),

        id_nivel_escolaridad:$('#escolaridad').val(),
        id_escolaridad:$('#escolaridad').val(),
        nivel_escolaridad:$('#escolaridad').val()==''?'':$('#escolaridad').find('option:selected').text(),
        otra_escolaridad:$('#otra_escolaridad').val(),


        id_religion:$('#religion').val(),
        nombre_religion:$('#religion').val()==''?'':$('#religion').find('option:selected').text(),
        otra_religion:$('#otra_religion').val(),

        id_grupo_etnico:$('#grupo_etnico').val(),
        grupo_etnico:$('#grupo_etnico').val()==''?'':$('#grupo_etnico').find('option:selected').text(),
        otro_grupo_etnico:$('#otro_grupo_etnico').val(),
        pertenece_grupo_etnico:$('#grupo_etnico').val()==''?'no':'si',

        capacidades_diferentes:$('#capacidades_diferentes').val(),
        capacidad_diferente: $('#discapacidad').val() ,

        id_lengua:$('#lengua').val(),
        lengua:$('#lengual').val()==''?'':$('#lengual').find('option:selected').text(),

        sabe_leer_escribir:$('#sabe_leer_escribir').val(),

        entiende_idioma_espanol:$('#entiende_idioma_espanol').val(),

        poblacion_callejera:$('#poblacion_callejera').val(),

        id_lgbttti:$('#poblacion').val(),
        poblacion:$('#poblacion').val(),
        otra_poblacion:$('#otra_poblacion').val(),
        nombre_poblacion:$('#poblacion').val()==''?'':$('#poblacion').find('option:selected').text(),

        requiere_traductor:$('#requiere_traductor').val(),
        idioma_traductor:$('#idioma_traductor').val(),
        otro_idioma_traductor:$('#otro_idioma_traductor').val(),

        requiere_interprete:$('#requiere_interprete').val(),
        tipo_interprete:$('#tipo_interprete').val(),

        condicion_migratoria: $('#condicion_migratoria').val(), ///Se agrego 
        lengua_extranjera: $('#habla_lengua_extranjera').val() == 'si' ? $('#lengua_extranjera').val() : '-', ///Se agrego 

        procesos_multiples: $('#procesos_multiples').val(), ///Se agrego 
        relacion_imputado: $('#relacion_imputado').val(), ///Se agrego 
        utilizo_medio_tecnologico: $('#utilizo_medio_tecnologico').val(), ///Se agrego 
        condicion_embarazo: $('#condicion_embarazo').val(), ///Se agrego 

      };
      

      info_principal= {
        id: arrPP[indexPP].info_principal.id_persona,
        estatus:1,
        tipo_parte:$('#tipoParte').val(),
        tipo_parte_text:$('#tipoParte').find('option:selected').text(),
        tipo_persona:$('#tipoPersona').val(),
        tipo_persona_text:$('#tipoPersona').find('option:selected').text().toUpperCase(),
        nacionalidad:$('#nacionalidad').val(),
        nacionalidad_text:$('#nacionalidad').find('option:selected').text().toUpperCase(),
        otra_nacionalidad:$('#otraNacionalidad').val(),
        curp:$('#curp').val(),
        rfc:$('#rfc').val(),
        cedula_profesional:$('#cedulaProfesional').val(),
        nombre:$('#nombre').val(),
        apellido_paterno:$('#apellidoPaterno').val(),
        apellido_materno:$('#apellidoMaterno').val(),
        genero:$('#genero').val(),
        genero_text:$('#genero').find('option:selected').text(),
        fecha_nacimiento:$('#fechaNacimiento').val(),
        edad:$('#edad').val(),
        estado_civil:$('#estadoCivil').val(),
        estado_civil_text:$('#estadoCivil').find('option:selected').text(),
        razon_social:$('#razonSocial').val(),
        id_tipo_identificacion:$('#identificacion').val(),
        tipo_identificacion:$('#identificacion').find('option:selected').text()
      };


      var data = {
        id_carpeta : $("#id_carpeta_judicial").val(),
        id_solicitud : arrPP[indexPP].info_principal.id_solicitud, //$("#id_solicitud").val(),
        tipo_solicitud : $("#tipo_solicitud").val(),
        id_persona : $("#id_persona").val(),
        info_principal,
        alias:aliasSujeto,
        correos,
        telefonos,
        datos:datoAdicional,
        direcciones,
        delitos,
        delitos_estadisticos,
      };

      console.log('Editar Parte prueba', data);
      
      $.ajax({
        method:'POST',
        url:'/public/modificar_parte_procesal',
        data:{
          id_carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : arrPP[indexPP].info_principal.id_solicitud, //$("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          id_persona : $("#id_persona").val(),
          info_principal,
          alias:aliasSujeto,
          correos,
          telefonos,
          datos:datoAdicional,
          direcciones,
          delitos,
          delitos_estadisticos,
        },
        success:function(response){
          console.log("ALEXIS2",response);

          if(response.status==100){
            modal_success(`Parte procesal actualizada exitosamente`,'modalAdministracion');
            limpiarFormularioParteProcesal();
            pintarPersonas();
            pintarDelitosSinRelacionar();
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        }
        
      });
      
    }

    /**********************
    *
    * FUNCIONES GENERALES
    *
    **********************/
    function get_leyenda_sm( leyenda=null ){
      if( leyenda!= null ) leyenda = `<span class="leyenda-sm"> ${leyenda} </span>`;
      else leyenda = `<span class="leyenda-sm"> Sin datos </span>`;
      return leyenda;
    }

    function cerrar_datosPP(){
      $("#modalDatosPP").modal('hide');
      $("#modalAdministracion").modal('show');
    }

    function limpiarFormularioParteProcesal(){
      $('#tipoParte').val('').select2({minimumResultsForSearch: ''});
      $('#tipoPersona').val('').select2({minimumResultsForSearch: Infinity});
      $('#identificacion').val('').select2({minimumResultsForSearch: Infinity});
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
      $('#pais_nac').val('').select2({minimumResultsForSearch: ''});
      $('#estado_nac').val('').select2({minimumResultsForSearch: ''});
      $('#municipio_nac').val('').select2({minimumResultsForSearch: ''});
      $('#escolaridad').val('').select2({minimumResultsForSearch: ''});
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

      $('#otra_escolaridad').val('').attr('disabled',true);
      $('#discapacidad').val('').attr('disabled',true);
      $('#delitos').html('');
      $('#id_persona').val('-');


      $('#relacion_imputado_div').css('display', 'none');
      $('#utilizo_medio_tecnologico_div').css('display', 'none');
      $('#condicion_embarazo_div').css('display', 'none');
      $('#procesos_multiples_div').css('display', 'none');


      $('#agregarParte').removeClass('d-none').addClass('d-inline-block');
      $('.btn-edicion').remove();
      $("#titleAccordionNuevaParteProcesal").html("Agregar Parte");
      $("#titleAccordionNuevaParteProcesal").removeClass(`bkg-collapsed-btn-edit`);
      $("#titleAccordionNuevaParteProcesal").addClass(`bkg-collapsed-btn`);
      $('#collapseOneNuevaParteProcesal').collapse('hide');
      $('#collapseAlias').collapse('hide');
      $('#collapseContacto').collapse('hide');
      $('#collapseDatosAdicionales').collapse('hide');
      $('#collapseDelitos').collapse('hide');
      valores_default();
    }

    function obtener_modalidades( tag_detonador , tag_afectado , opcion_seleccionada = null ){
      $.ajax({
        type:'POST',
        url:'/public/obtener_modalidades',
        data:{
          delito:$(tag_detonador).val(),
        },
        success:function(response){
          if(response.status==100){
            let modalidades='<option selected disabled value>Elija una opcion</option>';
            $(response.response).each((index, modalidad)=>{
              const {id_modalidad, nombre_modalidad}=modalidad;
              const option=`<option value="${id_modalidad}" ${id_modalidad==opcion_seleccionada?'selected':''}>${nombre_modalidad}</option>`;
              modalidades=modalidades.concat(option);
            });
            $(tag_afectado).html(modalidades);
          }else{
            $(tag_afectado).html(`<option selected disabled value>Campo no requerido</option>`);
          }
        }
      });
    }

    /*********************
     * 
     * 
     * Delitos estadisticos
     * 
     * **********************/

    async function cargar_desagregados_PP( tag , nivel, id_temporal = 0 ){
      $(`#descripcion-${nivel}-${id_temporal}`).html( $( tag ).find(":selected").text() );

      let bandera_aperturar_campo_otro = false;

      if( nivel == 1 && $(tag).val() == 204 ) bandera_aperturar_campo_otro = true;
      if( nivel == 4 && ( $(tag).val() == 11 || $(tag).val() == 60 )  ) bandera_aperturar_campo_otro = true;

      if( bandera_aperturar_campo_otro ){
        $(`#datos-delitoE-${id_temporal}`).append(`
          <div class="col-md-12 div-otro-${id_temporal}" style="margin-bottom: 0.5rem">
            <label class="form-control-label">Especifique: </label>
            <input type="text" class="form-control otro" id="otro-${id_temporal}" autocomplete="off" >
          </div>
        `);
      }else $(`.div-otro-${id_temporal}`).remove();

      if( nivel >= 4 ) return false;
      else{
        for( i = parseInt(nivel) + 1 ; i<5 ; i++ ){
          $(`.div-desagregado_n${i}-${id_temporal}`).remove();
        }
      }

      const tipo_delictivo = $(`#tipo_delictivo-${id_temporal}`).val();
      const desagregado_n1 = $(`#desagregado_n1-${id_temporal}`).val();
      const desagregado_n2 = $(`#desagregado_n2-${id_temporal}`).val();
      const desagregado_n3 = $(`#desagregado_n3-${id_temporal}`).val();

      let desagregados = await catalogo_desagregados( tipo_delictivo, desagregado_n1, desagregado_n2, desagregado_n3 );

      let options_desagregados = `<option value="0" selected disabled>Seleccione una opcion</option>`;
      let nuevo_nivel = nivel;
      let bandera_seleccionar_automatico = false;

      if( desagregados.status == 100 ){
        desagregados = desagregados.response;

        bandera_seleccionar_automatico = desagregados.length == 1 ? true : false;
        
        for( var i in desagregados ){
          options_desagregados = options_desagregados + `
            <option value="${desagregados[i].id}" data-nivel="${desagregados[i].nivel}"> ${desagregados[i].descripcion}</option>
          `; 
          nuevo_nivel = desagregados[i].nivel;
        }

        $(`#datos-delitoE-${id_temporal}`).append(`
          <div class="col-md-12 div-desagregado_n${nuevo_nivel}-${id_temporal}" style="margin-bottom: 0.5rem">
            <label class="form-control-label">Desagregado:<span class="tx-danger">*</span> <span style="font-weight: bolder; font-size: 1rem;" id="descripcion-${nuevo_nivel}-${id_temporal}"></span> </label>
            <select class="form-control select2 desagregado_n${nuevo_nivel}" id="desagregado_n${nuevo_nivel}-${id_temporal}" autocomplete="off"  onchange="cargar_desagregados_PP( this , ${nuevo_nivel} , ${id_temporal})">
              ${options_desagregados}
            </select>
          </div>
        `);
        setTimeout(function(){
          $(`#desagregado_n${nuevo_nivel}-${id_temporal}`).select2({minimumResultsForSearch: ''});

          if( bandera_seleccionar_automatico ){
            setTimeout(function(){ $(`#desagregado_n${nuevo_nivel}-${id_temporal}`).val( desagregados[0].id ).trigger('change') }, 100);
          }

        }, 100);

      }
    }
    
    /*
    function limpiarCamposDelito(){
      $('#modalidadDelito').val('').select2({minimumResultsForSearch: Infinity});
      $('#calificativo').val('').select2({minimumResultsForSearch: Infinity});
      $('#gradoRealizacion').val('').select2({minimumResultsForSearch: Infinity});
    }
    */

    function valores_default(){
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

    /******************
    *
    * CONFIG COMPONENTS PP
    *
    *********************/
    function loadConfigComponentsPP(){
      $('#tipoParte').select2({minimumResultsForSearch: ''});
      $('#pais_nac').select2({minimumResultsForSearch: ''});
      $('#estado_nac').select2({minimumResultsForSearch: ''});
      $('#municipio_nac').select2({minimumResultsForSearch: ''});
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

      //Variables agregadas       
      $('.estado').select2({minimumResultsForSearch: ''});
      $('.municipio').select2({minimumResultsForSearch: ''});

      setTimeout(function(){
        $('.procesos_multiples').select2({minimumResultsForSearch: ''});
        $('.relacion_imputado').select2({minimumResultsForSearch: ''});
        $('.utilizo_medio_tecnologico').select2({minimumResultsForSearch: ''});
        $('.condicion_embarazo').select2({minimumResultsForSearch: ''});
      },1000);


      /************************
      *
      * FUNCIONES ON CHANGE
      *
      ************************/

      $('#tipoParte').change(function(){
        $('#relacion_imputado_div').css('display', 'none');
        $('#utilizo_medio_tecnologico_div').css('display', 'none');
        $('#condicion_embarazo_div').css('display', 'none');
        $('#procesos_multiples_div').css('display', 'none');

        if($(this).val()==46 || $(this).val()==56 ){
          $('#row-accordeon-delitos').removeClass('d-none');

          $('#relacion_imputado_div').css('display', 'none');
          $('#utilizo_medio_tecnologico_div').css('display', 'none');
          $('#condicion_embarazo_div').css('display', 'none');

          $('#procesos_multiples_div').css('display', 'block');
          
          $('#procesos_multiples').html(`
            <option selected  value="-">Elija una opción</option>
            <option value="1">Si</option>
            <option value="0">No</option>
            <option value="9">Se desconoce</option>
          `);
        }else if($(this).val()==1 || $(this).val()==2 || $(this).val()==7 || $(this).val()==8){
          $('#procesos_multiples_div').css('display', 'none');

          $('#relacion_imputado_div').css('display', 'block');
          $('#utilizo_medio_tecnologico_div').css('display', 'block');
          $('#condicion_embarazo_div').css('display', 'block');

          
          $('#relacion_imputado').html(`
            <option selected  value="-">Elija una opción</option>
            @foreach ($relacion_imputado as $relacion)
              <option value="{{$relacion['id_relacion_imputado']}}">{{$relacion['relacion_imputado']}}</option>
            @endforeach
          `);
          $('#utilizo_medio_tecnologico').html(`
            <option selected  value="-">Elija una opción</option>
            <option value="1">Si</option>
            <option value="0">No</option>
          `);
          $('#condicion_embarazo').html(`
            <option selected  value="-">Elija una opción</option>
            <option value="1">Si</option>
            <option value="0">No</option>
          `);
        }else{
          $('#row-accordeon-delitos').addClass('d-none');
        }
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
      
      $('#capacidades_diferentes').change(function(){
        if($(this).val()=="si"){
          $('#discapacidad').attr('disabled', false);
        }else{
          $('#discapacidad').attr('disabled', true);
          $('#discapacidad').prop('selectedIndex',0).trigger( "change" );
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

      $('#requiere_interprete').change(function(){
        if($(this).val()=='si'){
          $('#tipo_interprete').removeAttr('disabled');
        }else{
          $('#tipo_interprete').val('').attr('disabled', true);
        }
      });

      //Variables agregadas  
      $('#estado_nac').change(function(){
        const selectMunicipio=$('#municipio_nac');
        const estado=$(this).find('option:selected').attr('data-cve-estado');

        if($('#estado_nac').val() == ''){
          $('#municipio_nac').html('<option disabled selected>Elija una opción</option>');
        }else{
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
        }
      });
      
      $('#habla_lengua_indigena').change(function(){
        if($(this).val()=="si"){
          $('#lengua').attr('disabled', false);
        }else{
          $('#lengua').attr('disabled', true);
          $('#lengua').prop('selectedIndex',0).trigger( "change" );
        }
      });
      
      $('#habla_lengua_extranjera').change(function(){
        if($(this).val()=="si"){
          $('#lengua_extranjera').attr('disabled', false);
        }else{
          $('#lengua_extranjera').attr('disabled', true);
          $('#lengua_extranjera').prop('selectedIndex',0).trigger( "change" );
        }
      });



      /************************
      *
      * FUNCIONES ADD CHILD
      *
      ************************/

      $('#agregarAlias').click(function(){
        $('#datosAlias').append(
        `<div class="col-lg-6 pretty-box datos-alias" data-status="1" data-id="-" data-index="-">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Alias:</label> <span class="f-right tx-danger"><i class="fa fa-close borrar-alias"></i></span>
              <input class="form-control alias" type="text" name="alias" autocomplete="off">
            </div>
          </div><!-- col-3-->
        `);
      });

      $('#agregarDomicilio').click(function(){
        let inputID = get_unique_id();
        $('#domicilios').append(
          `<div class="row pretty-box datos-domicilio" id="datos-domicilio${inputID}" data-status="1" data-id="-" data-index="-" data-unique="${inputID}">
            <div class="col-12">
              <p class="tx-right tx-danger"><i class="fa fa-close borrar-domicilio"></i></p>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">País de residencia: </label>
                <select class="form-control pais_resi" id="pais_resi${inputID}" name="pais_resi${inputID}" autocomplete="off">
                  <option selected  value="-">Elija una opción</option>
                  @foreach ($paises as $pais)
                    <option value="{{$pais['id_pais']}}">{{$pais['descripcion']}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Estado: </label>
                <select class="form-control estado" name="estado" autocomplete="off" id="estado${inputID}">
                    <option selected   value="-">Elija una opción</option>
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
            <div class="col-lg-8">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Colonia:</label>
                <input class="form-control colonia" type="text" name="colonia"  autocomplete="off" id="colonia${inputID}">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Código Postal:</label>
                <input class="form-control codigoPostal" type="text" name="codigo_postal" autocomplete="off" id="codigoPostal${inputID}">
              </div>
            </div><!-- col-4 -->
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
            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Entre la Calle:</label>
                <input class="form-control entreCalle" type="text" name="entre_calle" autocomplete="off id="entreCalle${inputID}"">
              </div>
            </div><!-- col-4-->
            <div class="col-lg-6">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Otras Referencias:</label>
                <input class="form-control otrasReferencias" type="text" name="otras_referencias" autocomplete="off" id="otrasReferencias${inputID}">
              </div>
            </div><!-- col-4-->
          </div>`
        );

        $('#estado'+inputID).select2({minimumResultsForSearch: ''});
        $('#pais_resi'+inputID).select2({minimumResultsForSearch: ''});
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
        $('#telefonos').append(`
          <div class="col-lg-6 pretty-box">
            <div class="row datos-telefono" id="datos-telefono${inputID}" data-status="1" data-id="-" data-index="-" data-unique="${inputID}">
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
              <div class="col-lg-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Número:</label>
                  <input class="form-control numero-telefono" type="text" name="numero_telefono" autocomplete="off">
                </div>
              </div><!-- col-3-->
              <div class="col-lg-3">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Extension:</label>
                  <input class="form-control extension" type="text" name="estension" autocomplete="off">
                </div>
              </div><!-- col-3-->
            </div>
          </div>
        `);

        $('.tipo-telefono').select2({
          minimumResultsForSearch: Infinity
        });
      });

      $('#agregarCorreo').click(function(){
        let inputID = get_unique_id();
        $('#correos').append(
          ` <div class="col-6 pretty-box datos-correo" id="datos-correo${inputID}" data-status="1" data-id="-" data-index="-" data-unique="${inputID}">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Correo Electrónico:</label> <span class="f-right tx-danger"><i class="fa fa-close borrar-correo"></i></span>
                <input class="form-control correo-electronico" type="text" name="correo_electronico" autocomplete="off">
              </div>
            </div><!-- col-3-->
          `);
      });

      $('#agregarDelito').click(function(){
        let inputID = get_unique_id();
        $('#delitos').append(
          `<div class="row pretty-box datos-delito" id="datos-delito${inputID}" data-status="1" data-id="-" data-index="-" data-unique="${inputID}" data-tipo="-" style="border: 1px solid #848f33; margin: 2% 0; padding: 10px; position:relative;">
            <div style="position:absolute;position: absolute; left: 0; top: 0; padding: 4px; font-size: 0.8em; background: #848f3382; color: #fff;">
              Delito
            </div>

            <div class="col-12">
              <p class="tx-right tx-danger"><i class="fa fa-close borrar-delito"></i></p>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Delito: <span class="tx-danger">*</span></label>
                <select class="form-control delito" id="delito${inputID}" name="delito" autocomplete="off" onchange="obtener_modalidades(this,'#modalidadDelito${inputID}')">
                    <option selected disabled value="">Elija una opción</option>
                    @foreach ($delitos as $delito)
                        <option value="{{$delito['id_delito']}}" data-grave="{{$delito['delito_oficioso']==1?'si':'no'}}">{{$delito['delito']}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Modalidad de Delito: </label>
                <select class="form-control select2 modalidad-delito" id="modalidadDelito${inputID}" name="modalidad_delito" autocomplete="off">
                    <option selected disabled value="">Elija una opción</option>
                </select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Calificativo: <span class="tx-danger">*</span></label>
                <select class="form-control select2 calificativo" id="calificativo${inputID}" name="calificativo" autocomplete="off">
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
                <select class="form-control select2 grado-realizacion" id="gradoRealizacion${inputID}" name="grado_realizacion" autocomplete="off">
                    <option disabled selected value="">Elija una opción</option>
                    <option value="de_tentetiva">DE TENTATIVA</option>
                    <option value="consumado">CONSUMADO</option>
                    <option value="por_definir">POR DEFINIR</option>
                </select>
              </div>
            </div>

          </div>
        `);

        setTimeout(()=>{
          /*$('#delito'+inputID).change(function(){
            $.ajax({
              type:'POST',
              url:'/public/obtener_modalidades',
              data:{
                delito:$('#delito'+inputID).val(),
              },
              success:function(response){
                if(response.status==100){
                  let modalidades='<option selected disabled value>Elija una opcion</option>';
                  $(response.response).each((index, modalidad)=>{
                    const {id_modalidad, nombre_modalidad}=modalidad;
                    const option=`<option value="${id_modalidad}">${nombre_modalidad}</option>`;
                    modalidades=modalidades.concat(option);
                  });
                  $('#modalidadDelito'+inputID).html(modalidades);
                }
              }
            });
          });*/

          $('#delito'+inputID).select2({minimumResultsForSearch: ''});
          $('#modalidadDelito'+inputID).select2({minimumResultsForSearch: ''});
          $('#calificativo'+inputID).select2({minimumResultsForSearch: ''});
          $('#gradoRealizacion'+inputID).select2({minimumResultsForSearch: ''});

          $('.selectt').select2({minimumResultsForSearch: ''});

        },200);
      });
      
      $('#agregarDelitoEstadistico').click(function(){
        let inputID = get_unique_id();
        $('#delitos').append(`
          <div class="row pretty-box datos-delito" id="datos-delito-${inputID}" data-status="1" data-id="-" data-index="-" data-unique="${inputID}" data-tipo="estadistica" style="position:relative;border: 1px solid #848f33; margin: 2% 0; padding: 10px;">
            
            <div style="position:absolute;position: absolute; left: 0; top: 0; padding: 4px; font-size: 0.8em; background: #848f3382; color: #fff;">
              Delito Estadistico
            </div>

            <div class="col-12">
              <p class="tx-right tx-danger"><i class="fa fa-close borrar-delito"></i></p>
            </div>

            {{-- Delito Estadistico --}}
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Delito:<span class="tx-danger">*</span> <span style="font-weight: bolder; font-size: 1rem;" id="descripcion-0-${inputID}"></span> </label>
                <select class="form-control tipo_delictivo" id="tipo_delictivo-${inputID}" name="tipo_delictivo" autocomplete="off" onchange="cargar_desagregados_PP( this , 0 , ${inputID})">
                    <option selected disabled value="0">Elija una opción</option>
                    @foreach ($desagregados_estadisticos as $delito)
                      <option value="{{$delito['id']}}">{{$delito['descripcion']}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            {{-- Deagregados --}}
            <div id="datos-delitoE-${inputID}" style="margin-bottom:1rem; width:100%;"></div>

            {{-- Calificativo --}}
            <div class="col-lg-6 mb-3">
              <div class="form-group">
                <label class="form-control-label">Calificativo: </label>
                <select class="form-control calificativo" id="calificativo-${inputID}" name="calificativo-${inputID}" autocomplete="nope">
                    <option selected disabled value="">Elija una opción</option>
                    @foreach ($calificativos as $calificativo)
                        <option value="{{$calificativo['id_calificativo']}}">{{mb_strtoupper($calificativo['calificativo'])}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            {{-- Grado de Realización --}}
            <div class="col-lg-6 mb-3">
              <div class="form-group">
                <label class="form-control-label">Grado de Realización: </label>
                <select class="form-control gradoRealizacion" id="gradoRealizacion-${inputID}" name="grado_realizacion-${inputID}" autocomplete="nope">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="de_tentetiva">DE TENTATIVA</option>
                    <option value="consumado">CONSUMADO</option>
                    <option value="por_definir">POR DEFINIR</option>
                </select>
              </div>
            </div> 

            {{-- Tipo de Violencia --}}
            <div class="col-lg-4 mb-3">
              <div class="form-group">
                <label class="form-control-label">Tipo de Violencia: </label>
                <select class="form-control tipoViolencia" id="tipoViolencia-${inputID}" name="tipoViolencia-${inputID}" autocomplete="nope">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="1">Violencia física</option>
                    <option value="2">Violencia moral</option>
                    <option value="3">Violencia fisica y moral</option>
                    <option value="0">No aplica</option>
                </select>
              </div>
            </div>

            {{-- Consignación --}}
            <div class="col-lg-4 mb-3">
              <div class="form-group">
                <label class="form-control-label">Consignación: </label>
                <select class="form-control consignacion" id="consignacion-${inputID}" name="consignacion-${inputID}" autocomplete="nope">
                    <option selected disabled value="">Elija una opción</option>
                    <option value="1">Con detenido</option>
                    <option value="0">Sin detenido</option>
                </select>
              </div>
            </div>

            {{-- Entidad ocurrencia de los hechos --}}
            <div class="col-lg-4 mb-3">
              <div class="form-group">
                <label class="form-control-label">Entidad ocurrencia de los hechos: </label>
                <select class="form-control estadoOcurrenciaH" name="estadoOcurrenciaH" autocomplete="off" id="estadoOcurrenciaH-${inputID}">
                    <option selected  disabled value="-">Elija una opción</option>
                    @foreach ($estados as $estado)
                        <option value="{{$estado['id_estado']}}" data-cve-estado="{{$estado['cve_estado']}}">{{$estado['estado']}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            {{-- Municipio ocurrencia de los hechos --}}
            <div class="col-lg-4 mb-3">
              <div class="form-group">
                <label class="form-control-label">Municipio ocurrencia de los hechos: </label>
                <select class="form-control municipioOcurrenciaH" name="municipioOcurrenciaH" autocomplete="off" id="municipioOcurrenciaH-${inputID}">
                </select>
              </div>
            </div>

            {{-- Fecha ocurrencia de los hechos --}}
            <div class="col-lg-4 mb-3">
              <div class="form-group">
                <label class="form-control-label">Fecha ocurrencia de los hechos: </label>
                <input type="text" class="form-control fc-datepicker fechaOcurrenciaH" placeholder="DD/MM/AAAA" id="fechaOcurrenciaH-${inputID}" name="fechaOcurrenciaH" autocomplete="off">
              </div>
            </div>

            {{-- Elementos para la comisión del delito --}}
            <div class="col-lg-4 mb-3">
              <div class="form-group">
                <label class="form-control-label">Elementos para la comisión del delito: </label>
                <select class="form-control elementosComisionDel" name="elementosComisionDel" autocomplete="off" id="elementosComisionDel-${inputID}">
                    <option selected disabled  value="-">Elija una opción</option>
                    @foreach ($elementos_comision as $comision)
                        <option value="{{$comision['id_elemento_comision_delito']}}">{{$comision['elemento_comision_delito']}}</option>
                    @endforeach
                </select>
              </div>
            </div>

            {{-- Modo en que ocurre la agresión --}}
            <div class="col-lg-4 mb-3">
              <div class="form-group">
                <label class="form-control-label">Modo en que ocurre la agresión: </label>
                <select class="form-control modoOcurrenciaAgresion" name="modoOcurrenciaAgresion" autocomplete="off" id="modoOcurrenciaAgresion-${inputID}">
                    <option selected  disabled value="-">Elija una opción</option>
                    @foreach ($modalidad_agresion as $magresion)
                        <option value="{{$magresion['id_modalidad_agresion']}}">{{$magresion['modalidad_agresion']}}</option>
                    @endforeach
                </select>
              </div>
            </div>
          

          </div>
        `);

        setTimeout(function(){
          $('#tipo_delictivo-'+inputID).select2({minimumResultsForSearch: ''});
          $('#calificativo-'+inputID).select2({minimumResultsForSearch: ''});
          $('#gradoRealizacion-'+inputID).select2({minimumResultsForSearch: ''});
          $('#tipoViolencia-'+inputID).select2({minimumResultsForSearch: ''});
          $('#consignacion-'+inputID).select2({minimumResultsForSearch: ''});
          $('#estadoOcurrenciaH-'+inputID).select2({minimumResultsForSearch: ''});
          $('#municipioOcurrenciaH-'+inputID).select2({minimumResultsForSearch: ''});
          $('#elementosComisionDel-'+inputID).select2({minimumResultsForSearch: ''});
          $('#modoOcurrenciaAgresion-'+inputID).select2({minimumResultsForSearch: ''});

          $('.fc-datepicker').datepicker({dateFormat:'yy-mm-dd',firstDay: 1})

          $('#estadoOcurrenciaH-'+inputID).on('change',function(){
            const selectMunicipio=$('#municipioOcurrenciaH-'+inputID);
            const estado=$(this).find('option:selected').attr('data-cve-estado');
            $.ajax({
              type:'POST',
              url:'/public/obtener_municipios',
              data:{
              estado,
              },
              success:function(response){
                if(response.status==100){
                  let municipios='<option disabled selected >Elija una opción</option>';
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
        },200);

      });
    

      
      /************************
      *
      * FUNCIONES DELETE CHILD
      *
      ************************/

      $('#datosAlias').on('click','.borrar-alias',function(){
        if($(this).parent().parent().parent().attr('data-index') != "-"){
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
          $(this).parent().parent().parent().parent().addClass('d-none');
        }else{
          $(this).parent().parent().parent().parent().remove();
        }
      });

      $('#delitos').on('click','.borrar-delito',function(){
        if($(this).parent().parent().parent().attr('data-index') != '-'){
          $(this).parent().parent().parent().attr('data-status','0');
          $(this).parent().parent().parent().addClass('d-none');
        }else{
          $(this).parent().parent().parent().remove();
        }
      });

      /************************
      *
      * FUNCIONES VALIDACION
      *
      ************************/
    }

    function validaDatosParteProcesal(){

      if($('#tipoParte').val()==null) return {'estatus':0,'campo':'#tipoParte','error':'No ha seleccionado el tipo de la parte'};

      if($('#tipoPersona').val()==null) return {'estatus':0,'campo':'#tipoPersona','error':'No ha seleccionado el tipo de la persona'};

      if($('#nacionalidad').val()=='extranjero'){
        if($('#otraNacionalidad').val()==null) return {'estatus':0,'campo':'#otraNacionalidad','error':'No ha seleccionado la nacionalidad"'};
      }

      if($('#tipoPersona').val()=='fisica'){

        if(expVacio.test($('#nombre').val())) return {'estatus':0,'campo':'#nombre','error':'Falta el nombre de la parte'};

        if(expVacio.test($('#apellidoPaterno').val())) return {'estatus':0,'campo':'#apellidoPaterno','error':'Falta el apellido paterno de la parte'};

        if($('#genero').val()==null) return {'estatus':0,'campo':'#genero','error':'No ha seleccionado el género'};

      }else{
        if(expVacio.test($('#razonSocial').val())) return {'estatus':0,'campo':'#razonSocial','error':'Falta la razón social'};
      }

      if(!expVacio.test($('#rfc').val())){
        if(!expRFC.test($('#rfc').val())) return {'estatus':0,'campo':'#rfc','error':'El formato del RFC es inválido'};
      }

      let respuesta = 100;

      if( $('#tipoParte').val()== 46 ){
        $('.datos-delito').each(function(){
          if( $(this).data("tipo") == "estadistica" ){
            console.log( "div:", $(this) );
            console.log( "input:", $(this).find('.tipo_delictivo').length, "Value: ",$(this).find('.tipo_delictivo').find('option:selected').val() );
            console.log( "input:", $(this).find('.desagregado_n1').length, "Value: ",$(this).find('.desagregado_n1').find('option:selected').val() );
            console.log( "input:", $(this).find('.desagregado_n2').length, "Value: ",$(this).find('.desagregado_n2').find('option:selected').val() );
            console.log( "input:", $(this).find('.desagregado_n3').length, "Value: ",$(this).find('.desagregado_n3').find('option:selected').val() );
            console.log( "input:", $(this).find('.desagregado_n4').length, "Value: ",$(this).find('.desagregado_n4').find('option:selected').val() );
            if( $(this).find('.tipo_delictivo').length > 0){ 
              if( $(this).find('.tipo_delictivo').find("option:selected").val() == 0 ){ 
                console.log("Hey - vergatl: ",1);
                respuesta = {'estatus':0,'campo':'#' + $(this).find('.tipo_delictivo')[0].id,'error':'Falta el Delito'};
              }
            }
            /*if( $(this).find('.desagregado_n1').length > 0){ 
              if( $(this).find('.desagregado_n1').find("option:selected").val() == 0 ){ 
                console.log("Hey - vergatl: ",2);
                respuesta = {'estatus':0,'campo':'#' + $(this).find('.desagregado_n1')[0].id,'error':'Falta el Desagregado'};
              }
            }
            if( $(this).find('.desagregado_n2').length > 0){ 
              if( $(this).find('.desagregado_n2').find("option:selected").val() == 0 ){ 
                console.log("Hey - vergatl: ",3);
                respuesta = {'estatus':0,'campo':'#' + $(this).find('.desagregado_n2')[0].id,'error':'Falta el Desagregado'};
              }
            }
            if( $(this).find('.desagregado_n3').length > 0){ 
              if( $(this).find('.desagregado_n3').find("option:selected").val() == 0 ){ 
                console.log("Hey - vergatl: ",4);
                respuesta = {'estatus':0,'campo':'#' + $(this).find('.desagregado_n3')[0].id,'error':'Falta el Desagregado'};
              }
            }
            if( $(this).find('.desagregado_n4').length > 0){ 
              if( $(this).find('.desagregado_n4').find("option:selected").val() == 0 ){ 
                console.log("Hey - vergatl: ",5);
                respuesta = {'estatus':0,'campo':'#' + $(this).find('.desagregado_n4')[0].id,'error':'Falta el Desagregado'};
              }
            }*/
          }
        });
      }

      return respuesta;
    }

    function obtener_alcaldias(valor,id){

      const selectAlcaldia=$("#amhechos" + id);


      $.ajax({
              type:'POST',
              url:'/public/obtener_municipios',
              data:{
                estado:valor,
              },
              success:function(response){
              if(response.status==100){
                let municipios='<option disabled selected>Elija una opción</option>';
                $(response.response).each(function(index, datosMunicipio){
                  const {id_municipio, municipio}=datosMunicipio;
                  const option=`<option value="${id_municipio}">${municipio}</option>`;
                  municipios=municipios.concat(option);
                });
                selectAlcaldia.html(municipios);
              }
            }
              });
    }

    /*
    function validaDatosDelito(){
      if($('#delito').val()==null) return {'estatus':0,'campo':'delito','error':'No ha seleccionado el delito'};

      if($('#modalidadDelito').val()==null) return {'estatus':0,'campo':'modalidadDelito','error':'No ha seleccionado la modalidad del delito'};

      if($('#calificativo').val()==null) return {'estatus':0,'campo':'calificativo','error':'No ha seleccionado el calificativo'};

      if($('#gradoRealizacion').val()==null) return {'estatus':0,'campo':'gradoRealizacion','error':'No ha seleccionado el grado de realizacion'};

      return 100;
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
    */
  </script>
