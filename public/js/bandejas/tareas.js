
let juez_ejec='';

$("#archivoDoc").on('input',function () {
  leeDocumento(this);
});

function buscar( pagina ){
  $('#modal_loading').modal('show');
  $.ajax({
    method:'POST',
    url:'/public/obtener_bandeja',
    data:{
      modo:"lista",
      tipo:"tareas",
      pagina,
      uga:$('#unidad').val(),
      usuario:$('#usuario').val(),
      folio:$('#folio').val(),
      estatus:$('#estatus').val(),
      desde:$('#desde').val(),
      hasta:$('#hasta').val(),
      carpeta_inv:$('#carpetaInv').val(),
      nombre_persona:$('#nombrePersona').val(),
      ap_paterno_persona:$('#apPaternoPersona').val(),
      ap_materno_persona:$('#apMaternoPersona').val(),
    },
    success:function( response ){
      $('#bodyTareas').html('');
      if(response.status==100){
        arrTareas=response.response;
        $(response.response).each(function(index, tarea){
          const {id_bandeja,estatus_bandeja,creacion_bandeja,mensaje_bandeja,comentarios_bandeja ,folio_solicitud,tipo_solicitud_,fecha_recepcion_solicitud,clave_bandeja,carpeta_investigacion,cve_juez_promujer,nombre_juez_promujer , nombre_usuario_origen,partes_procesales,delitos,carpeta_judicial,descripcion_bandeja,id_usuario_origen,usuario_origen,tipo_documento_acuerdo,fecha_creacion_acuerdo,id_usuario_destino,nombre_usuario_destino,usuario_destino}=tarea;

            let lPartes='',
                lDelitos='',
                lCarpetas='',
                fhCarpetas='';

            $(carpeta_judicial).each(function(index, carpeta){
              fechaAsignacion='';
                if(carpeta.fecha_asignacion!=null){
                    const fhCrea=carpeta.fecha_asignacion.split(' ')
                    const fCrea=fhCrea[0].split('-');
                    fechaAsignacion=fCrea[2]+'-'+fCrea[1]+'-'+fCrea[0]+' '+fhCrea[1];
                }
                lCarpetas=lCarpetas.concat(`<div class="">${carpeta.folio_carpeta==null?'':carpeta.folio_carpeta}</div>`);
                fhCarpetas=fhCarpetas.concat(`${fechaAsignacion}`);
            });

            if(partes_procesales){
              const tipos_partes=Object.keys(partes_procesales);
              $(tipos_partes).each(function(index, tipo_parte){
                  lPartes=lPartes.concat(`<h6 class="mg-b-0 text-capitalize">${tipo_parte}</h6>`);
                  $(partes_procesales[tipo_parte]).each(function(index, parte){
                      const {razon_social,nombre, apellido_paterno, apellido_materno} = parte;
                      lPartes=lPartes.concat(`<div class="b-l-2">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</div>`);
                  });
              });
            }

            $(delitos).each(function(index, delito){
                lDelitos=lDelitos.concat(`<div class="b-l-2">${delito.delito}</div>`);
            });


            let fechaRecepcionSolicitud='';
            if(creacion_bandeja!=null){
              const fRep=fecha_recepcion_solicitud.split(' ')[0].split('-');
              fechaRecepcionSolicitud='<br>'+fRep[2]+'-'+fRep[1]+'-'+fRep[0]+'<br>';
            }

            let fechaCreacionAc='';
            if(fecha_creacion_acuerdo!=null){
              const fAc=fecha_creacion_acuerdo.split(' ')[0].split('-');
              fechaCreacionAc='<br>'+fAc[2]+'-'+fAc[1]+'-'+fAc[0]+'<br>';
            }

            let creacionBandeja='';
            if(creacion_bandeja!=null){
                const fhRep= creacion_bandeja.split(' ');
                const fRep=fhRep[0].split('-');
                creacionBandeja=fRep[2]+'-'+fRep[1]+'-'+fRep[0]+' '+fhRep[1]+'<br>';
            }

            let datosDocumento='';
            if(clave_bandeja=='RS' || clave_bandeja=='CACU'){
              datosDocumento=`
                <span>${tipo_solicitud_}</span>
                <span>${folio_solicitud}</span>
                <span>${fechaRecepcionSolicitud}</span>
                <span>${carpeta_investigacion==null?'':fechaRecepcionSolicitud}</span>
                <span class="font-weight-bold">${cve_juez_promujer==null?'':'('+cve_juez_promujer+')'} ${nombre_juez_promujer==null?'':nombre_juez_promujer}</span>
              `;
            }else if(clave_bandeja=='REV'){
              datosDocumento=`
                <span>${tipo_documento_acuerdo}</span>
                <span>${fechaCreacionAc}</span>
              `;
            }

            const tr=`
              <tr>
                <td class="acciones"><i class="icon ion-folder" onclick="verTarea(${index})"></i></td>
                <td class="folio">${id_bandeja}<br><small class="text-uppercase mg-b-0 ${estatus_bandeja=='espera'?'tx-danger':'tx-success'}">${estatus_bandeja}</small></td>
                <td class="remitente">${fhCarpetas}</td>
                <td class="remitente">${creacionBandeja}</td>
                <td class="carpeta">${lCarpetas}</td>
                <td class="descripcion">${descripcion_bandeja=='REGISTRO DE PROMOCION'?'RECEPCIÓN DE PROMOCIÓN':descripcion_bandeja}</td>
                <td class="remitente">${id_usuario_origen==0||id_usuario_origen==null?"PGJ":""}${nombre_usuario_origen==null?"":nombre_usuario_origen} ${usuario_origen==null?"":'<br>('+usuario_origen+')'}</td>
                <td class="remitente">${id_usuario_destino==0||id_usuario_destino==null?"MASTER":""}${nombre_usuario_destino==null?"":nombre_usuario_destino} ${usuario_destino==null?"":'<br>('+usuario_destino+')'}</td>
                <td class="partes">${lPartes}</td>
                <td class="delitos">${lDelitos}</td>
                <td class="juez">${nombre_juez_promujer==null?'':nombre_juez_promujer}</td>
                <td class="comentarios">${comentarios_bandeja==null?'':comentarios_bandeja}</td>
              </tr>
            `;
            $('#bodyTareas').append(tr);
        });

        const anterior=pagina==1?1:pagina-1,
                    totalPaginas=response.response_pag.paginas_totales,
                    siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

        $('.anterior').attr('onclick',`buscar(${anterior})`);
        $('.pagina').html(pagina);
        $('.total-paginas').html(totalPaginas);
        $('.siguiente').attr('onclick',`buscar(${siguiente})`);
        $('.ultima').attr('onclick',`buscar(${totalPaginas})`);

      }else{
        const tr=`
          <tr>
            <td class="unidad tx-center tx-danger" colspan="9">Sin Datos Relacionados</td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
          <tr>
        `;

        $('#bodyTareas').append(tr);

        $('.anterior').attr('onclick',`buscar(1)`);
        $('.pagina').html('1');
        $('.total-paginas').html('1');
        $('.siguiente').attr('onclick',`buscar(1)`);
        $('.ultima').attr('onclick',`buscar(1)`);
      }
      setTimeout(()=>{
        $('#modal_loading').modal('hide');
      },500);
    }

  });

  countBandejas();
}

function obtenerUsuariosUnidad(){
  $('#usuario').html('');
  $.ajax({
    method:'POST',
    url:'/public/obtener_usuarios_unidad',
    data:{
      uga:$('#unidad').val(),
    },
    success:function(response){
      $('#usuario').append('<option value="">Todos</option>');
      if(response.status==100){
        $(response.response).each(function(index, usuario_unidad){
          const {usuario, id_usuario,nombres,apellido_paterno,apellido_materno}=usuario_unidad;
          $('#usuario').append(`<option value="${id_usuario}">${nombres} ${apellido_paterno} ${apellido_materno} (${usuario})</option>`);
        });
      }
    }
  });
}


function firmante(){
  if($('#accion').val()=='firma'){
    $('#usuario_destino').removeAttr('disabled');
    $('#delegar').attr('disabled',true);
  }else if($('#accion').val()=='delegar'){
    $('#usuario_destino').attr('disabled', true);
    $('#delegar').removeAttr('disabled');
  }else{
    $('#delegar').attr('disabled',true);
    $('#usuario_destino').attr('disabled', true);
  }
}

function obtenerDocumentosSolicitud(solicitud, version=''){
  // let PDF;
  return new Promise(resolve => {
    // setTimeout(() => {
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_solicitud',
        data:{
          solicitud,
          version
        },
        success:function(response){
          // $('#divDocumentos').html(`<object data="${response.response}"  id="documentoPDF" width="100%" height="350px" class="mg-t-25"></object>`);
          resolve(response);

        }
      });
    // }, 2000);
  });
}

function obtenerDocumentosRemision( remision, version='' ){
  return new Promise(resolve => {
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_remision',
        data:{ remision, version },
        success:function(response){
          resolve(response);
        }
      });
  });
}

function obtenerDocumentosPromocion(promocion, version=''){


  return new Promise(resolve => {
    
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_promocion',
        data:{
          promocion,
          version
        },
        success:function(response){
          console.log(response);
          resolve(response);

        }
      });
    
  });
}

function obtenerDatosSolicitud_arreglo(solicitud){

    // const solicitud=arrTareas[index].id_solicitud
    const tipo=arrTareas[indexTarea].tipo_solicitud_;

    return new Promise(resolve => {

      $.ajax({
        method:'POST',
        url:'/public/obtener_datos_solicitud',
        data:{
          solicitud,
          tipo
        },
        success:function(response){
            resolve(response);
        }
      });
    });
}

function obtenerDatosSolicitud(solicitud){
  $('#validacionDatos').removeClass('d-none');
  $('#resolucion').addClass('d-none');
  // const solicitud=arrTareas[index].id_solicitud
  const tipo=arrTareas[indexTarea].tipo_solicitud_;

  return new Promise(resolve => {

    $.ajax({
      method:'POST',
      url:'/public/obtener_datos_solicitud',
      data:{
        solicitud,
        tipo
      },
      success:function(response){

        if(response.status==100){

          const datos={};
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

              $(direcciones).each(function(index, direccionSujeto){

                const {estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle}=direccionSujeto;

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

function obtenerDatosRemision(remision){
  $('#validacionDatos').removeClass('d-none');
  $('#resolucion').addClass('d-none');
  // const solicitud=arrTareas[index].id_solicitud

  return new Promise(resolve => {

    $.ajax({
      method:'POST',
      url:'/public/obtener_datos_remision',
      data:{
        remision,
      },
      success:function(response){
        if(response.status==100){

          const datos={};
          let elementosPersonas='';
          if(response.response[0].personas.length){

            $(response.response[0].personas).each(function(index, persona){
              const {alias, contacto, delitos, datos, direcciones, info_principal}= persona;

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

              $(direcciones).each(function(index, direccionSujeto){

                const {estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle}=direccionSujeto;

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

              const {calidad_juridica,razon_social,nombre,apellido_paterno,apellido_materno,rfc_empresa,curp,cedula_profesional,genero,fecha_nacimiento,nacionalidad,estado_civil} = info_principal;

              fechaNacimiento='';
              if(fecha_nacimiento!=null){
                const f=fecha_nacimiento.split('-');
                fechaNacimiento=`${f[2]}-${f[1]}-${f[0]}`;
              }

              const {otra_ocupacion,nivel_escolaridad,otra_escolaridad,nombre_religion,otra_religion,grupo_etnico,otro_grupo_etnico,lengua,capacidad_diferente,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,poblacion,otra_poblacion,nombre_poblacion,entiende_idioma_espanol,requiere_interprete,tipo_interprete,requiere_traductor,idioma_traductor,otro_idioma_traductor}=datos[0];
              ocupacion='';

              const table=`
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

            
            

          }
          datos.elementosPersonas=elementosPersonas;

          const {folio,tipo_remision,fecha_registro,materia_destino,fecha_solicitud,fecha_recepcion,carpeta_judicial}=response.response[0];

          let fechaRegistro='',
            fechaSolicitud='',
            fechaRecepcion='';

          if(fecha_registro!=null){
            const fa=fecha_registro.split(' ')[0].split('-');
            fechaRegistro=`${fa[2]}-${fa[1]}-${fa[0]}`;
          }

          if(fecha_solicitud!=null){
            const fs=fecha_solicitud.split(' ')[0];
            fechaSolicitud=fs;
            // fechaSolicitud=`${f[2]}-${f[1]}-${f[0]}`;
          }

          if(fecha_recepcion!=null){
            const fr=fecha_recepcion.split(' ')[0].split('-');
            fechaRecepcion=`${fr[2]}-${fr[1]}-${fr[0]}`;
          }

          const tableSolicitud= `
            <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
              <tbody class="table-datos-sujeto">
                <tr>
                  <td>Folio</td>
                  <td>${folio}</td>
                </tr>
                <tr>
                  <td>Carpeta Judicial</td>
                  <td>${carpeta_judicial}</td>
                </tr>
                <tr>
                  <td>Materia Destino</td>
                  <td class="text-capitalize">${materia_destino==null?"NA":materia_destino.replace("_"," ")}</td>
                </tr>
                <tr>
                  <td>Motivo de la Remisión</td>
                  <td class="text-capitalize">${tipo_remision==null?"":tipo_remision.replace("_"," ")}</td>
                </tr>
                <tr>
                  <td>Fecha de Registro</td>
                  <td>${fechaRegistro}</td>
                </tr>
                <tr>
                  <td>Fecha de Recepción</td>
                  <td>${fechaRecepcion}</td>
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

function obtenerGrupoTrabajo(){
  return new Promise(resolve => {
    let usuarios='';
    $.ajax({
      method:'POST',
      url:'/public/obtener_grupo_trabajo',
      async:true,
      data:{
        tipo:'desc',
        nivel:'1'
      },
      success:function(response){
        if(response.status==100){

          $(response.response).each(function(index, usuarioGT){
            const {id_usuario, nombres, apellido_paterno, apellido_materno, usuario}=usuarioGT;
            usuarios=usuarios.concat(`<option class="text-uppercase"  value="${id_usuario}">${nombres} ${apellido_paterno} ${apellido_materno} (${usuario})</option>`);
          });
        }
        resolve(usuarios);
      }
    });

  });
}

function obtenerJueces(juezFirmante='', cambio='0'){
  
  return new Promise(resolve => {
    let jueces='<option value="" disabled selected>Seleccione a un Juez</option>';
    $.ajax({
      method:'POST',
      url:'/public/obtener_jueces_unidad',
      async:true,
      data:{

      },
      success:function(response){
        if(response.status==100){
          $(response.response).each(function(index, juez){
            const {id_usuario, nombres, apellido_paterno, apellido_materno, cve_juez, id_tipo_usuario,usuario}=juez;
            if(juezFirmante==id_usuario)
             jueces=jueces.concat(`<option class="text-uppercase" value="${id_usuario}" selected>${id_tipo_usuario==5?'Juez':id_tipo_usuario==2?'Dir':''} ${nombres} ${apellido_paterno} ${apellido_materno} (${cve_juez}) - usuario</option>`);
            else if( cambio == 0 )
              jueces=jueces.concat(`<option class="text-uppercase" value="${id_usuario}">${id_tipo_usuario==5?'Juez':id_tipo_usuario==2?'Dir':''} ${nombres} ${apellido_paterno} ${apellido_materno} (${cve_juez}) - ${usuario}</option>`);
            
          });
        }
        resolve(jueces);
      }
    });

  });
}

function obtener_siguiente_juez_control(){
    return new Promise(resolve => {
      let jueces='';
      $.ajax({
        method:'POST',
        url:'/public/obtener_siguiente_juez_control',
        async:true,
        data:{

        },
        success:function(response){
            resolve(response);
        }
      });

    });
  }


function obtener_inmuebles(){
  return new Promise(resolve => {
    let jueces='';
    $.ajax({
      method:'POST',
      url:'/public/obtener_inmuebles',
      async:true,
      data:{

      },
      success:function(response){
          resolve(response);
      }
    });

  });
}

function obtener_inmueble_salas(id_inmueble){
  return new Promise(resolve => {
    let jueces='';
    $.ajax({
      method:'POST',
      url:'/public/obtener_inmueble_salas',
      async:true,
      data:{
          id_inmueble:id_inmueble
      },
      success:function(response){
          resolve(response);
      }
    });

  });
}

let index_global;
function siguienteX(solicitud, index){
  $('.error').removeClass('error');

  if($('#tipoResolucion').val()==''){

    error('Datos Incompletos', 'No ha seleccionado el tipo de resolución de la solicitud', 'modalDatosTarea');
    $('#modalDatosTarea').modal('hide');
    $('span[aria-labelledby="select2-tipoResolucion-container"]').addClass('error');

  }else{
    $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
    $('#step-resolucion').removeClass('espera').addClass('activo');
    $('#atras').removeAttr('disabled');

    if($('#tipoResolucion').val()=='acuerdo'){

      if(tUsuario==3 || claveBandeja=='CACU' || claveBandeja=='REV' || claveBandeja=='COR' || claveBandeja=='RP'){

        $('#resolucion').append(`

        `);

        setTimeout(function(){
          tipoDocumento();
        },300);

        if(claveBandeja=='REV' || claveBandeja=='COR'){
          obtener_doc_acuerdo(tareaSeleccionada.id_acuerdo);
        }

      }else{

      }

    }else if($('#tipoResolucion').val()=='audiencia'){
        //alert('aqui con aud ' + tUsuario);


        if(typeof index == "number"){
            index_global = index;
        }
        cargarAudiencia(index_global);

    }

    $('#validacionDatos').addClass('d-none');
    $('#resolucion').removeClass('d-none');

    if((claveBandeja=='REV' || claveBandeja=='CACU' || claveBandeja=='RE') && origenTarea=='solicitudes'){

      const acuerdo=tareaSeleccionada.id_acuerdo;
      $('#avanzar').attr('onclick',`avanzar(${acuerdo})`)
      $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="validarTareaSolicitud(${solicitud}, ${indexTarea})">Resolver Tarea</button>`);

    }else if((claveBandeja=='RP' || claveBandeja=='CACU') && origenTarea=="promociones"){

      $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="validarTareaPromocion(${promocion}, ${indexTarea})">Resolver Tarea</button>`);
    }
    else{
      $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="validarTareaSolicitud(${solicitud}, ${indexTarea})">Resolver Tarea</button>`);
    }
  }
}


function atras(){
  $('#steps').html(`<p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>`);
  $('#step-datos-solicitud').addClass('activo').removeClass('resuelto');
  $('#step-resolucion').addClass('espera').removeClass('activo');
  $('#atras').attr('disabled', true);
  $('#resolucion').addClass('d-none');
  $('#validacionDatos').removeClass('d-none');
  $('#divButtons').html('<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente()" id="btnSiguiente">Siguiente</button>')
}

async function leeDocumento (input) {

  const file = $('#archivoDoc').val(),
        ext = file.substring(file.lastIndexOf("."));
        nombre=normalize((file.split('\\')[2]).split('.')[0]);
        $('#archivoDoc')[0].files[0].name="gocumento.docx";
        setTimeout(()=>{
        },500);
  if(ext!=''){
    if(ext != ".doc" && ext != ".docx"){
      alert('Solo puede adjutar archivos .doc o .docx');
      $('#archivoDoc').val('');
      $('#docSeleccionado').html('');
      $('#vistaPreviaDocPDF').html(``);
    }else{
      $('#docSeleccionado').html(`
      <div class="tx-center">
        <a href="javascript:void(0)"  onclick="borraDoc()"><i class="fa fa-times" aria-hidden="true" style="margin-left: 140px; margin-bottom: 10px; color: red;"></i></a>
        <i class="fa fa-file-word-o d-block mg-b-10" aria-hidden="true" style="color:#848F33; font-size:70px"></i>
        <label ondblclick="cambiarNombre()" id="labelNombre" style="width: 100%; overflow-x: scroll;">${nombre}${ext}</label>
        <input type="hidden" value="${nombre}" id="nombreDoc" name="nombre_doc" onblur="guardaNombreDoc('${ext}')"  onkeypress="guardaNombreDoc('${ext}', event)" style="text-align: center; border:#868ba1"></div>
      `);
      const url_previa= await vistaPrevia();
      $('#vistaPreviaDocPDF').html(`<object data="${url_previa}" width="100%" height="350px" class="mg-t-25"></object>`)
    }
  }
}

function borraDoc(){
  $('#archivoDoc').val('');
  $('#docSeleccionado').html('');
  $('#vistaPreviaDocPDF').html('');
}

function vistaPrevia(){
  return new Promise(resolve => {
    abreModal('modal_loading');
    $('#modalDatosTarea').modal('hide');
    resolucion=new FormData($("#cargarDocumento")[0]);
    resolucion.append('nombre_doc',$('#labelNombre').text())
    $.ajax({
      method:'POST',
      url:'/public/vista_previa',
      data:resolucion,
      contentType: false,
      processData: false,
      cache: false,
      success:function(response){
        cierraLoading();
        abreModal('modalDatosTarea',350);
        
        resolve(response);
      }
    });
  });
}

function cambiarNombre(){
  $('#labelNombre').addClass('d-none');
  $('#nombreDoc').attr('type','text').focus();
}

function guardaNombreDoc(ext, e=''){
  if ((e=='' || e.keyCode === 13) && !e.shiftKey) {

    const nombre=normalize($('#nombreDoc').val());

    $('#labelNombre').removeClass('d-none').html(nombre+ext);
    $('#nombreDoc').attr('type','hidden').val(nombre);
  }
}

function error(title='', message='', modal=''){
  $('#titleError').html(title);
  $('#messageError').html(message);
  $('#modalError').modal('show');
  if(modal!=''){
    $('#'+modal).modal('hide');
    $('#acepError').attr('onclick', `abreModal('${modal}',355)`);
  }
  return 0;
}

function abreModal(modal, time=0){
  setTimeout(function(){
    $('#'+modal).modal('show');
  },time);
}

function editorHTML(){
  editor_html = new FroalaEditor("#edit", {
    height: 'calc(100vh - 100vh/2)',
    language: 'es',
    imageDefaultWidth: 0,
    imageOutputSize: true,

    key: '0BA3jA11A8B5A3E4D4aIVLEABVAYFKc2Cb1MYGH1g1NYVMiG5G4E3C3A1C8C6D4A3F4==',
    embedlyKey: '0BA3jA11A8B5A3E4D4aIVLEABVAYFKc2Cb1MYGH1g1NYVMiG5G4E3C3A1C8C6D4A3F4==',

    attribution: false,
    autofocus: true,
    htmlUntouched: true,
    htmlAllowedAttrs: ['v:shapes'],
    imageUploadParams:{
      'v:shapes':'mi_prueba'
    },
    imageRoundPercent: true,

    // Set custom buttons with separator between them.
    toolbarButtons: {
      'moreText': {
        'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
      },
      'moreParagraph': {
        'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
      },
      'moreRich': {
        'buttons': ['insertLink', 'insertImage', 'insertTable', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
      },
      // 'moreMisc': {
      //   'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help']
      // }
    },
    imageEditButtons: [['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize']],
    // toolbarButtonsXS: [['undo', 'redo'], ['bold', 'italic', 'underline']],
    events: {
      'image.beforeUpload': function (files) {
        const editor = this
        if (files.length) {
          var reader = new FileReader()
          reader.onload = function (e) {
            var result = e.target.result;
            num1=Math.floor(Math.random() * 100) + 1;
            num2=Math.floor(Math.random() * 100) + 1;

            editor.image.insert(result, null, {'v:shapes': 'Imagen_'+num1+'_'+num2+''}, editor.image.get())

            const dataAttributesToFix = ['v:shapes'] // replace this for the attributes you want fixed
            editor.events.on('image.inserted', image => {
              dataAttributesToFix.forEach(k => {
                if (image.attr('data-str' + k)) {
                    image.attr( k, image.attr('data-str' + k))
                    image.removeAttr('data-str' + k)
                }
              })
            })

          }
          reader.readAsDataURL(files[0])
        }
        return false
      }
    }
  })
}

function obtener_grupo_trabajo(){
  $.ajax({
    method:'POST',
    url:'/public/obtener_grupo_trabajo',
    data:{

    },
    success:function(response){

    }
  });
}

function accion(){
  if($('#accion').val()=='revision'){
    $('#usuario_destino').attr('disabled', true);
  }else{
    $('#usuario_destino').removeAttr('disabled');
  }
}

function cierraLoading(time){
  setTimeout(()=>{
    $('#modal_loading').modal('hide');
  },time);
};


var normalize = (function() {
  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
      to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      mapping = {};

  for(var i = 0, j = from.length; i < j; i++ )
      mapping[ from.charAt( i ) ] = to.charAt( i );

  return function( str ) {
      var ret = [];
      for( var i = 0, j = str.length; i < j; i++ ) {
          var c = str.charAt( i );
          if( mapping.hasOwnProperty( str.charAt( i ) ) )
              ret.push( mapping[ c ] );
          else
              ret.push( c );
      }
      return ret.join( '' ).replace( /-|[^-A-Za-z0-9]+/g, '_' ).toLowerCase();;
  }

})();

function obtener_archivo_acuerdo(acuerdo, tipo='pdf'){
  return new Promise(resolve => {
    $.ajax({
      method:'POST',
      url:'/public/obtener_ultima_version_acuerdo',
      data:{
        acuerdo,
        tipo,
      },
      success:function(response){
        if(response.status==100){
          resolve(response)
        }
      }
    });
  });
}

function obtenerDatosPromocion(promocion){
  return new Promise(resolve => {
    $.ajax({
      method:'GET',
      url:'/public/obtener_promociones',
      data:{promocion},
      success:function(response){
        if(response.status==100){
          const {folio_promocion, folio_carpeta,promovente, promovente_calidad_juridica, tipo_requerimiento, id_juez_ejecucion} = response.response[0];
          juez_ejec = id_juez_ejecucion;
         
          const tablePromocion= `
            <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
              <tbody class="table-datos-sujeto">
                <tr>
                  <td>Folio de la Promoción</td>
                  <td>${folio_promocion}</td>
                </tr>
                <tr>
                  <td>Carpeta de Investigación</td>
                  <td class="text-capitalize">${folio_carpeta}</td>
                </tr>
                <tr>
                  <td>Promovente</td>
                  <td class="text-capitalize">${promovente}</td>
                </tr>
                <tr>
                  <td>Calidad jurídica del promovente</td>
                  <td>${promovente_calidad_juridica}</td>
                </tr>
                <tr>
                  <td>Tipo de requerimiento</td>
                  <td>${tipo_requerimiento}</td>
                </tr>
              
              </tbody>
            </table>
          `;

          resolve(tablePromocion);
        }
      }
    });
  });
}

