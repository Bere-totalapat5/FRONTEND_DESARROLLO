async function verSolicitud(){

  const {id_solicitud, tipo_solicitud_,tipo_resolucion_solicitud,id_juez_promujer} = tareaSeleccionada;
  
  let documentos;
  if(tipo_solicitud_=='INICIAL' || tipo_solicitud_=='EXHORTO'){

    const dataPDF =  await obtenerDocumentosSolicitud(id_solicitud);
    documentos = `<object data="${dataPDF.response}"  id="documentoPDF" width="100%" height="350px" class="mg-t-25"></object>`;

  }else if(tipo_solicitud_=='PRO-MUJER'){

    versiones = await obtenerDocumentosSolicitud(id_solicitud, 'todas');

    documentos='<div class="row">';

    $(versiones).each(function(index, version){

      const icono = icon( version.nombre_archivo.substring(version.nombre_archivo.lastIndexOf(".")) )

      documentos = documentos.concat(`
        <div class="col-md-4">
          <a href="/obtener_documentos_solicitud/${id_solicitud}" target="_blank">${icono} ${version.nombre_archivo}</a>
        </div>
      `);

    });
    documentos = documentos.concat('</div>');
  }

  datosSolicitud= await obtenerDatosSolicitud(id_solicitud);

  let tipoResolucion = '';
  if( tipo_resolucion_solicitud != null )
    tipoResolucion =`
      <h4 class="mg-t-15 mg-b-20">
        Tipo de Resolución: <span class="text-capitalize">${tipo_resolucion_solicitud}</span>
      </h4>
      <div class="form-group d-none">
        <label class="form-control-label">Resolver por:</label>
        <select class="form-control select2" id="tipoResolucion" name="tipo_resolucion" autocomplete="off">
          <option value="">Seleccione una Opción</option>
          <option value="acuerdo" ${tipo_resolucion_solicitud=='acuerdo'?'selected':''}>Acuerdo</option>
          <option value="audiencia" ${tipo_resolucion_solicitud=='audiencia'?'selected':''}>Audiencia</option>
        </select>
      </div>
    `;
  else if( tipo_solicitud_=='PRO-MUJER' || tipo_solicitud_=='EXHORTO' ) 
    tipoResolucion=`
      <h4 class="mg-t-15 mg-b-20">
        Tipo de Resolución: Acuerdo
      </h4>
      <div class="form-group d-none">
        <label class="form-control-label">Resolver por:</label>
        <select class="form-control select2" id="tipoResolucion" name="tipo_resolucion" autocomplete="off">
          <option value="acuerdo" selected>Acuerdo</option>
        </select>
      </div>
    `;
  else 
    tipoResolucion=`
      <div class="form-group">
        <label class="form-control-label">Resolver por:</label>
        <select class="form-control select2" id="tipoResolucion" name="tipo_resolucion" autocomplete="off">
          <option selected value="">Seleccione una Opción</option>
          <option value="acuerdo">Acuerdo</option>
          <option value="audiencia">Audiencia</option>
        </select>
      </div>
    `;
  
  $('#divTarea').append(`
    <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
      <div id="validacionDatos">
        ${tipoResolucion}
        <div class="card" style="min-height: 481px;">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#divSolicitud" data-toggle="tab">Datos Solicitud</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#divDatosSujeto" data-toggle="tab">Partes Procesales</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#divDocumentos" data-toggle="tab">Documentos</a>
              </li>
            </ul>
          </div><!-- card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="divSolicitud">
                ${datosSolicitud.infoSolicitud}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDatosSujeto">
                ${datosSolicitud.elementosPersonas}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDocumentos">
                ${documentos}
              </div><!-- tab-pane -->
            </div><!-- tab-content -->
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      <hr>
      <div id="resolucion" class="d-none">
      <div>
    </form>
  `);

  $('#tipoResolucion').select2({minimumResultsForSearch: Infinity});
  $('#tipoArchivo').select2({minimumResultsForSearch: Infinity});
  $('#accion').select2({minimumResultsForSearch: Infinity});
  $('#delegar').select2({minimumResultsForSearch: ''});
  $('#usuario_destino').select2({minimumResultsForSearch: ''});
  firmante();
  editorHTML();
}

function obtenerDatosSolicitud(solicitud){

  $('#validacionDatos').removeClass('d-none');
  $('#resolucion').addClass('d-none');

  const tipo = arrTareas[indexTarea].tipo_solicitud_;

  return new Promise(resolve => {

    $.ajax({
      method:'POST',
      url:'/public/obtener_datos_solicitud',
      data:{
        solicitud,
        tipo
      },
      success:function(response){

        if( response.status == 100 ){

          const datos = {};
          let elementosPersonas='';
          if(response.response[0].personas.length){
            $(response.response[0].personas).each(function(index, persona){

              const {alias, contacto, delitos, datos, direcciones, info_principal, id_unidad}= persona;

              unidad_tarea=id_unidad;

              let listaDelitos='',
                  listaAlias='',
                  listaCorreos='',
                  listaTelefonos='',
                  listaDirecciones='';

              $(alias).each(function(index, aliasSujeto){
                  li=`${aliasSujeto.alias}<br>`;
                  listaAlias=listaAlias.concat(li);
              });

              $(contacto).each(function(index,contactoSujeto){
                const {id_contacto_persona,tipo_contacto, contacto, estatus, extension}=contactoSujeto;
                if(estatus==1){
                  if(tipo_contacto=='correo electronico'){
                    li=`${contacto}<br>`;
                    listaCorreos=listaCorreos.concat(li);
                  }else{
                    li=`${tipo_contacto}: ${tipo_contacto} ${extension==null?'':'ext '+extension}<br>`;
                    listaTelefonos=listaTelefonos.concat(li);
                  }
                }
              });

              $(direcciones).each(function( index, direccionSujeto ){

                const { estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle} = direccionSujeto;

                const tableDireccion=`
                  <br>
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
                  </table>  `
                ;

                listaDirecciones=listaDirecciones.concat(tableDireccion);

              });

              const {calidad_juridica,razon_social,nombre,apellido_paterno,apellido_materno,rfc_empresa,curp,cedula_profesional,genero,fecha_nacimiento,nacionalidad,estado_civil} = info_principal;

              fechaNacimiento='';
              if(fecha_nacimiento!=null){
                const f=fecha_nacimiento.split('-');
                fechaNacimiento=`${f[2]}-${f[1]}-${f[0]}`;
              }
              
              ocupacion='';

              if(datos[0]){
                const {otra_ocupacion,nivel_escolaridad,otra_escolaridad,nombre_religion,otra_religion,grupo_etnico,otro_grupo_etnico,lengua,capacidad_diferente,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,poblacion,otra_poblacion,nombre_poblacion,entiende_idioma_espanol,requiere_interprete,tipo_interprete,requiere_traductor,idioma_traductor,otro_idioma_traductor}=datos[0];
                table_datos_adicionales=`
                  <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                    <tbody class="table-datos-sujeto">
                      <tr>
                        <td>Calidad Jurídica</td>
                        <td>${calidad_juridica}</td>
                        <td>Ocupación</td>
                        <td>${ocupacion==null?'':ocupacion}</td>
                      </tr>
                      <tr>
                        <td>Nombre ó Razón Social</td>
                        <td>${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</td>
                        <td>Otra Ocupación</td>
                        <td>${otra_ocupacion==null?'':otra_ocupacion}</td>
                      </tr>
                      <tr>
                        <td>RFC</td>
                        <td>${rfc_empresa==null?'':rfc_empresa}</td>
                        <td>Escolaridad</td>
                        <td>${nivel_escolaridad==null?'':nivel_escolaridad}</td>
                      </tr>
                      <tr>
                        <td>CURP</td>
                        <td>${curp==null?'':curp}</td>
                        <td>Otra Escolaridad</td>
                        <td>${otra_escolaridad==null?'':otra_escolaridad}</td>
                      </tr>
                      <tr>
                        <td>Cédula Profesional</td>
                        <td>${cedula_profesional==null?'':cedula_profesional}</td>
                        <td>Religión</td>
                        <td>${nombre_religion==null?'':nombre_religion}</td>
                      </tr>
                      <tr>
                        <td>Género</td>
                        <td class="text-capitalize">${genero==null?'':genero}</td>
                        <td>Otra Religión</td>
                        <td>${otra_religion==null?'':otra_religion}</td>
                      </tr>
                      <tr>
                        <td>Fecha de Nacimiento</td>
                        <td>${fechaNacimiento}</td>
                        <td>Grupo Étnico</td>
                        <td>${grupo_etnico==null?'':grupo_etnico}</td>
                      </tr>
                      <tr>
                        <td>Nacionalidad</td>
                        <td>${nacionalidad==null?'':nacionalidad}</td>
                        <td>Otro Grupo Étnico</td>
                        <td>${otro_grupo_etnico==null?'':otro_grupo_etnico}</td>
                      </tr>
                      <tr>
                        <td>Estado Civíl</td>
                        <td>${estado_civil==null?'':estado_civil}</td>
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
                        <td class="text-capitalize">${sabe_leer_escribir==null?'':sabe_leer_escribir}</td>
                        <td>Población Callejera</td>
                        <td class="tx-capitalize">${poblacion_callejera==null?'':poblacion_callejera}</td>
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
                        <td class="text-capitalize">${entiende_idioma_espanol==null?'':entiende_idioma_espanol}</td>
                      </tr>
                      <tr>
                        <td>Requiere Intérprete</td>
                        <td class="text-capitalize">${requiere_interprete==null?'':requiere_interprete}</td>
                        <td>Tipo de Intérprete</td>
                        <td>${tipo_interprete==null?'':tipo_interprete}</td>
                      </tr>
                      <tr>
                        <td>Requiere Traductor</td>
                        <td class="text-capitalize">${requiere_traductor==null?'':requiere_traductor}</td>
                        <td>Idioma del Traductor</td>
                        <td>${idioma_traductor==null?'':idioma_traductor}</td>
                      </tr>
                      <tr>
                        <td>Otro Idioma del Traductor</td>
                        <td>${otro_idioma_traductor==null?'':otro_idioma_traductor}</td>
                      </tr>
                    </tbody>
                  </table>
                `;
              }
              

              const table=`
                ${table_datos_adicionales}
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
                ${listaDirecciones}
              `;
              const elementoPersona=`
                <div id="accordion${index}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
                  <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                      <a data-toggle="collapse" data-parent="#accordion${index}" href="#collapseOne${index}" aria-expanded="true" aria-controls="collapseOne${index}" class="tx-gray-800 transition collapsed">
                        ${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}
                      </a>
                    </div><!-- card-header -->

                    <div id="collapseOne${index}" class="collapse" role="tabpanel" aria-labelledby="headingOne${index}">
                      <div class="card-body" >
                        ${table}
                      </div>
                    </div>
                  </div>
                </div>
              `;

              elementosPersonas=elementosPersonas.concat(elementoPersona);

            });

            datos.elementosPersonas=elementosPersonas;


          }

          const {folio_solicitud,materia_destino,fecha_asignacion_carpeta,fecha_solicitud,fecha_recepcion,hora_recepcion,carpeta_investigacion,mp_solicitante,correo_mp,curp_mp,descripcion_hechos}=response.response[0];

          let fechaAsignacionCarpeta='',
            fechaSolicitud='',
            fechaRecepcion='';

          if(fecha_asignacion_carpeta!=null){
            const fa=fecha_asignacion_carpeta.split(' ')[0].split('-');
            fechaAsignacionCarpeta=`${fa[2]}-${fa[1]}-${fa[0]}`;
          }

          if(fecha_solicitud!=null){
            const fs=fecha_solicitud.split(' ')[0];
            fechaSolicitud=fs;
            // fechaSolicitud=`${f[2]}-${f[1]}-${f[0]}`;
          }

          if(fecha_recepcion!=null){
            const fr=fecha_recepcion.split('-');
            fechaRecepcion=`${fr[2]}-${fr[1]}-${fr[0]}`;
          }

          const tableSolicitud= `
            <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
              <tbody class="table-datos-sujeto">
                <tr>
                  <td>Folio de la Solicitud</td>
                  <td>${folio_solicitud}</td>
                </tr>
                <tr>
                  <td>Materia Destino</td>
                  <td class="text-capitalize">${materia_destino}</td>
                </tr>
                <tr>
                  <td>Fecha de Asignación de Carpeta</td>
                  <td>${fechaAsignacionCarpeta}</td>
                </tr>
                <tr>
                  <td>Fecha de Solicitud</td>
                  <td>${fechaSolicitud}</td>
                </tr>
                <tr>
                  <td>Fecha de Recepción</td>
                  <td>${fechaRecepcion}</td>
                </tr>
                <tr>
                  <td>Hora de Recepción</td>
                  <td>${hora_recepcion}</td>
                </tr>
                <tr>
                  <td>Carpeta de Investigación</td>
                  <td>${carpeta_investigacion==null?'':carpeta_investigacion}</td>
                </tr>
                <tr>
                  <td>MP Solicitante</td>
                  <td>${mp_solicitante==null?'':mp_solicitante}</td>
                </tr>
                <tr>
                  <td>Correo del MP</td>
                  <td>${correo_mp==null?'':correo_mp}</td>
                </tr>
                <tr>
                  <td>Curp del MP</td>
                  <td>${curp_mp==null?'':curp_mp}</td>
                </tr>
                <tr>
                  <td>Descripción de los Hechos</td>
                  <td>${descripcion_hechos==null?'':descripcion_hechos}</td>
                </tr>
              </tbody>
            </table>
          `;

          datos.infoSolicitud=tableSolicitud

          resolve(datos);

        }else{
          error(response.message.split('-')[1])
        }
      }
    });

  });
}
