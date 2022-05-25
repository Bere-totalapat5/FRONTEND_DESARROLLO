
const expRegFecha=/^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
      expRegHora=/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
      tipo_victima = [2,13,60,61,62];  
let   arrTareas,
      editor_html,
      clave_bandeja,
      index_global,
      origen,
      form,
      docs_firmar,
      carpeta_firma,
      tareaSeleccionada,
      contiene_fracciones = true;

setInterval(function(){
  buscar(1);
},120000);

$(document).ready(()=>{
  // alert('1');
  buscar(1);
  
  setTimeout(function(){
    $('#modal_loading').modal('hide');  
  }, 2000);

});

$('#aAtendidas').click( function() {
  $('#modalAlertaConfirmacion').modal('show');
  $('#mensajeAlertaConfirmacion').html('¿Está seguro de marcar como atendidas las tareas seleccionadas?')
});

function enviaTareasAtendidas() {

  $('#modalAlertaConfirmacion').modal('hide');
  $('#modal_loading').modal('show');

  let tareas = '';

  $('.seleccion-tarea:checked').each( function( i, tarea ) {
    if( i != 0 )
      tareas += ','+$(tarea).val();
    else 
      tareas += $(tarea).val();
  })

  $.ajax({
    method: 'PATCH',
    url: '/public/marcar_tareas' ,
    data: {tareas},
    success: function( response ) {
       if( response.status == 100 ) {
        $('#successMessage').html(response.message);
        $('#modalSuccess').modal('show');
        buscar(1);
       } else {
         $('#messageError').html(response.message);
         $('#modalError').modal('show');
       }

       setTimeout( () => {
         $('#modal_loading').modal('hide')
       }, 400);
    }
  });

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
          const {usuario, id_usuario}=usuario_unidad;
          $('#usuario').append(`<option value="${id_usuario}">${usuario}</option>`);
        });
      }
    }
  });
}
    
function verTarea(index){
  $('#divDatosSujeto').html('');
  $('#divDocumentos').html('');
  $('#divSolicitud').html('');
  
  index_global = index;
  clave_bandeja = arrTareas[index].clave_bandeja;
  origen = arrTareas[index].tabla_asociada;
  tareaSeleccionada = arrTareas[index];
  console.log(tareaSeleccionada);
  switch (clave_bandeja){
    case 'RS':
      verSolicitud(index);
      break;
    case 'CACU':
    case 'COR':
      verSolicitud(index);
      $('#tipoResolucion').val(tareaSeleccionada.tipo_resolucion_solicitud).attr('disabled', true);
      $('#tipoResolucion').select2({minimumResultsForSearch: ''});
      break;
    case 'REV':
      verSolicitud(index);
      $('#tipoResolucion').val(tareaSeleccionada.tipo_resolucion_solicitud).attr('disabled', true);
      $('#tipoResolucion').select2({minimumResultsForSearch: ''});
      break;
    case 'FIR':
      verSolicitud(index);
      $('#tipoResolucion').val(tareaSeleccionada.tipo_resolucion_solicitud).attr('disabled', true);
      $('#tipoResolucion').select2({minimumResultsForSearch: ''});
      setTimeout(function(){
        siguiente(tareaSeleccionada.id_solicitud, index)
      },800);
      break;
    
    default:
      window.location.reload();
  };
}

function verSolicitud(index){
  $('#validacionDatos').removeClass('d-none');
  $('#resolucion').addClass('d-none');
  const solicitud = tareaSeleccionada.id_solicitud,
        tipo = tareaSeleccionada.tipo_solicitud_;

  $.ajax({
    method:'POST',
    url:'/public/obtener_pdf_solicitud',
    data:{
      solicitud
    },
    success:function(response){
      $('#divDocumentos').html(`<object data="${response.response}"  id="documentoPDF" width="100%" height="350px" class="mg-t-25"></object>`);
    }
  });

  $.ajax({
    method:'POST',
    url:'/public/obtener_datos_solicitud',
    data:{
      solicitud,
      tipo
    },
    success:function(response){
      console.log(response);
      if(response.status==100){
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
                  </table>  
                `;

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

            $('#divDatosSujeto').append(`
              <div id="accordion${index}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
                <div class="card">
                  <div class="card-header" role="tab" id="headingOne">
                    <a data-toggle="collapse" data-parent="#accordion${index}" href="#collapseOne${index}" aria-expanded="true" aria-controls="collapseOne${index}" class="tx-gray-800 transition collapsed">
                      ${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}
                    </a>
                  </div><!-- card-header -->

                  <div id="collapseOne${index}" class="collapse" role="tabpanel" aria-labelledby="headingOne${index}">
                    <div class="card-body">
                      ${table}
                    </div>
                  </div>
                </div>
              </div>
            `);  

          });
        }

        const {folio_solicitud,materia_destino,fecha_asignacion_carpeta,fecha_solicitud,fecha_recepcion,hora_recepcion,carpeta_investigacion,mp_solicitante,correo_mp,curp_mp,descripcion_hechos}=response.response[0];
      
        let fechaAsignacionCarpeta='',
          fechaSolicitud='',
          fechaRecepcion='';
      
        if(fecha_asignacion_carpeta!=null){
          const f=fecha_asignacion_carpeta.split('-');
          fechaAsignacionCarpeta=`${f[2]}-${f[1]}-${f[0]}`;
        }
      
        if(fecha_solicitud!=null){
          const f=fecha_solicitud.split('-');
          fechaSolicitud=`${f[2]}-${f[1]}-${f[0]}`;
        }
      
        if(fecha_recepcion!=null){
          const f=fecha_recepcion.split('-');
          fechaRecepcion=`${f[2]}-${f[1]}-${f[0]}`;
        }
      
        const tableSolicitud= `<table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
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
                            </table>`;

        $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente(${solicitud}, ${index})">Siguiente</button>`)
        $('#divSolicitud').append(tableSolicitud);
        
        if(clave_bandeja!='FIR'){
          abreModal('modalDatosTarea');
        }

      }else{
        error(response.message.split('-')[1])
      }
    }
  });

}

function siguiente(solicitud, index){
  $('.error').removeClass('error');
  $('#resolucion').html('');
  
  if($('#tipoResolucion').val()==''){

    error('Datos Incompletos', 'No ha seleccionado el tipo de resolución de la solicitud', 'modalDatosTarea');
    $('#modalDatosTarea').modal('hide');
    $('span[aria-labelledby="select2-tipoResolucion-container"]').addClass('error');

  }else{
    $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
    $('#step-resolucion').removeClass('espera').addClass('activo');
    $('#atras').removeAttr('disabled');
    
    if($('#tipoResolucion').val()=='acuerdo'){
      
      if(tUsuario==3 || clave_bandeja=='CACU' || clave_bandeja=='REV' || clave_bandeja=='FIR'){
        
        $('#resolucion').append(` 
          <div class="row mg-t-15">
            <div class="col-md-4">
              <label class="rdiobox">
                <input name="doc" type="radio" checked value="subir" class="doc" onchange="tipoDocumento()">
                <span>Subir Documento</span>
              </label>
            </div>
            <div class="col-md-4">
              <label class="rdiobox">
                <input name="doc" type="radio" value="crear" class="doc" onchange="tipoDocumento()">
                <span>Crear Documento en Línea</span>
              </label>
            </div>
            <div class="col-md-4">
              <label class="rdiobox">
                <input name="doc" type="radio" value="delegar" class="doc" onchange="tipoDocumento()">
                <span>Delegar Tarea</span>
              </label>
            </div>
          </div>
        `);

        setTimeout(function(){
          tipoDocumento();
        },300);

        if(clave_bandeja=='REV' || clave_bandeja=='FIR'){
          obtener_doc_acuerdo(arrTareas[index].id_acuerdo);
        }

      }else{
        $('#resolucion').append(` 
          <div class="row mg-t-15">
            <div class="col-12">
              <h3>La tarea se turnará al Subdirector de Causa para agregar el acuerdo</h3>
            </div>
          </div>
        `);
      }

    }else if($('#tipoResolucion').val()=='audiencia'){
      if(tUsuario==4){
        $('#resolucion').append('agendar audiencia');
      }
    }

    $('#validacionDatos').addClass('d-none');
    $('#resolucion').removeClass('d-none');

    if(clave_bandeja=='REV'){
      
      const acuerdo=arrTareas[index].id_acuerdo;
      $('#avanzar').attr('onclick',`avanzar(${acuerdo})`)
      $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="abreModal('modalAvanzar')" data-dismiss="modal">Resolver Tarea</button>`); 

    }else{
      $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="resolverTareaSolicitud(${solicitud}, ${index})">Resolver Tarea</button>`); 
    }
    
  }
}

function tipoDocumento(){
  
  $('.resolucion').remove();
  
  if($('input:radio[name=doc]:checked').val()=='subir'){
    
    
    $('#resolucion').append(` 
      <div class="col-lg-6 resolucion">
        <div class="form-group   mg-t-15">
            <label class="form-control-label">Tipo Archivo:</label>
            <select class="form-control" id="tipoArchivo" name="tipo_archivo" autocomplete="off">
              <option selected value="122">AUTO</option>
              <option selected value="505">CONSTANCIA</option>
            </select>
        </div>
      </div>
      <div class="resolucion " id="divAcuerdo">
          <input type="file" id="archivoDoc" class="btn btn-outline-primary" value="" name="archivo_doc" onchenge="leeDocumento('archivoDoc')">
      </div>
    `);

    $('#tipoArchivo').select2({minimumResultsForSearch: Infinity});

  }else if($('input:radio[name=doc]:checked').val()=='crear'){
   
    $('#resolucion').append(`
      <div class="col-lg-6 resolucion">
        <div class="form-group  mg-t-15">
            <label class="form-control-label">Tipo Archivo:</label>
            <select class="form-control" id="tipoArchivo" name="tipo_archivo" autocomplete="off">
              <option selected value="122">AUTO</option>
              <option selected value="505">CONSTANCIA</option>
            </select>
        </div>
      </div> 
      <div class="resolucion" id="divAcuerdo">
        <div id="editor" style="">
          <div id='edit' style="margin-top: 20px; width:100%;">
            <h1>Documento de prueba SIGJ Penal</h1>
          </div>
        </div>
      </div>
    `);
       
    $('#tipoArchivo').select2({minimumResultsForSearch: Infinity});
    if(clave_bandeja!='REV' && clave_bandeja!='FIR'){
      editorHTML();
    }
                         
  }else if($('input:radio[name=doc]:checked').val()=='delegar'){

    $.ajax({
      method:'POST',
      url:'/public/obtener_grupo_trabajo',
      data:{
        tipo:'desc',
        nivel:'1'
      },
      success:function(response){
        if(response.status==100){
          let usuarios='';

          $(response.response).each(function(index, usuario){
            const {id_usuario, nombres, apellido_paterno, apellido_materno}=usuario;
            usuarios=usuarios.concat(`<option  value="${id_usuario}">${nombres} ${apellido_paterno} ${apellido_materno}</option>`);
          });
          $('#resolucion').append(`
            <div class="col-lg-12 mg-t-15 resolucion">
              <h5 class="mg-t-15">Seleccione el usuario a quien se le delegará la tarea</h5>
              <div class="form-group">
                <label class="form-control-label">Usuario:</label>
                <select class="form-control" id="delegar" name="delegar" autocomplete="off">
                  <option selected value="" disabled>Elija un usuario</option>
                  ${usuarios}
                </select>
              </div>
            </div>
          `);
        }
        $('#delegar').select2({minimumResultsForSearch: ''});
      }
    });
    
    
  }
}

function abreModal(modal){
  setTimeout(function(){
    $('#'+modal).modal('show');
  },355);
}


function enviarCorreccion(acuerdo, tipo_documento='acuerdo'){
  $('#modal_loading').modal('show');
  $('#modalConfirmacion').modal('hide');
  let valid=1;
  let url = '/public/avanzar_acuerdo';

  resolucion=new FormData($("#cargarDocumento")[0]);
  resolucion.append('acuerdo',acuerdo);
  resolucion.append('accion','correccion');
  resolucion.append('solicitud',acuerdo);
  resolucion.append('comentarios',$('#comentariosRegresar').val());

  if(tipo_documento=='carpetas_judiciales_documentos'){
    url = '/public/avanzar_documento';
    let tarea = arrTareas.filter( x => x.id_tabla_asociada == acuerdo );
    resolucion=new FormData($("#cargarDocumento")[0]);
    resolucion.append('id_documento',acuerdo);
    resolucion.append('accion','correccion');
    resolucion.append('id_carpeta',tarea[0].id_carpeta_judicial);
    resolucion.append('id_usuario_destino',tarea[0].id_usuario_origen);
    resolucion.append('comentarios',$('#comentariosRegresar').val());
  }
  // resolucion.append('usuario{_destino',$('#usuario_destino').val());

  if($('input:radio[name=doc]:checked').val()=='subir'){
    
    if(($('#archivoDoc').val()==null || $('#archivoDoc').val()=='') && clave_bandeja!='REV'){
      error('Datos Incompletos', 'No ha seleccionado un archivo', 'modalDatosTarea');
    }else{       

      const file = $('#archivoDoc').val();
      if(file!=''){
        extension = file.substring(file.lastIndexOf("."));
        
        nombre_archivo=$('#archivoDoc')[0].files[0].name;
        tamanio_archivo=$('#archivoDoc')[0].files[0].size;

        resolucion.append('extension',extension);
        resolucion.append('nombre_archivo',nombre_archivo);
        resolucion.append('tamanio_archivo',tamanio_archivo);
      }

    }
  }else if($('input:radio[name=doc]:checked').val()=='crear'){
    
    extension='html'
    archivo=editor_html.html.get();   
    resolucion.append('archivo_doc',archivo);
    resolucion.append('extension',extension);
  
  }

  // if($('#accion').val()=='' || $('#accion').val()==null){
  //   error('Datos Incompletos', 'No ha seleccionado la acción', 'modalAvanzar');
  //   $('span[aria-labelledby="select2-accion-container"]').addClass('error');
  //   valid=0;
  // }

  // if($('#accion').val()=='firma' && $('#usuario_destino').val()==null){
  //   error('Datos Incompletos', 'No ha seleccionado un Juez', 'modalAvanzar');
  //   $('span[aria-labelledby="select2-usuario_destino-container"]').addClass('error');
  // }

  if(valid==1){
    $.ajax({
      method:'POST',
      //url:'/public/avanzar_acuerdo',
      url:url,
      data:resolucion,
      contentType: false, 
      processData: false,
      cache: false,
      success:function(response){
        console.log(response);
        console.log(response);
        if(response.status==100){
          const message=response.message;
          $('#successMessage').html(`${message}`);
          $('#modalAvanzar').modal('hide');
          $('#modalSuccess').modal('show');
          countBandejas();
          buscar(1);
        }
        setTimeout(()=>{
          $('#modal_loading').modal('hide');
        },200);
      }
    });
  }
}

function atras(){
  $('#step-datos-solicitud').addClass('activo').removeClass('resuelto');
  $('#step-resolucion').addClass('espera').removeClass('activo');
  $('#atras').attr('disabled', true);
  $('#resolucion').addClass('d-none');
  $('#validacionDatos').removeClass('d-none');
  $('#divButtons').html('<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente()">Siguiente</button>')
}

function error(title='', message='', modal=''){
  $('#titleError').html(title);
  $('#messageError').html(message);
  $('#modalError').modal('show');
  if(modal!=''){
    $('#'+modal).modal('hide');
    $('#acepError').attr('onclick', `abreModal('${modal}')`);
  }
  // setTimeout(function(){
  //   $('#modal_loading').modal('hide');
  // },500);
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
            console.log(result);
            console.log(e.target);
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

function obtener_doc_acuerdo(acuerdo){
  $.ajax({
    method:'POST',
    url:'/public/obtener_ultima_version_acuerdo',
    data:{
      acuerdo,
    },
    success:function(response){
      console.log(response)
      if(response.status==100){
        $('.doc').attr('disabled', true);
        if(response.extension=='html'){
          $('.doc').each(function(){
            if($(this).val()=='crear'){
              $(this).attr('checked', true);
            }else{
              $(this).removeAttr('checked');
            }
          });
          setTimeout(function(){
            $('#edit').html(response.response);
              // setTimeout(function(){ 
                editorHTML();
              // },100);
          },200);
          
        }else{
          $('#resolucion').append(`
            <h3 class="mg-t-20">Documento Actual</h3>
            <object data="${response.response}"  id="documentoPDF" width="100%" height="350px" class="mg-t-20"></object>
          `);
          $('.doc').each(function(){
            if($(this).val()=='subir'){
              $(this).attr('checked', true);
            }else{
              $(this).removeAttr('checked');
            }
          });
        }
      }
    }
  });
}

$('.transition.fracciones').click(function() {
  
  $('#navItemsFracciones li:first-child').find('a').click();
  if($(this).find('i').hasClass('fa-angle-down')){
    $(this).find('i').removeClass('fa-angle-down');
    $(this).find('i').addClass('fa-angle-up');
  }else{
    $(this).find('i').addClass('fa-angle-down');
    $(this).find('i').removeClass('fa-angle-up');
  }

});

function obtenerDatosSolicitud( solicitud ){

  const tipo = tareaSeleccionada.tipo_solicitud_;

  return new Promise(resolve => {

    $.ajax({
      method:'POST',
      url:'/public/obtener_datos_solicitud',
      data:{
        solicitud,
        tipo
      },
      success:function(response){

        if( response.status == 100 )
          Object.assign(tareaSeleccionada, response.response[0]);
        else
          error(response.message.split('-')[1])
        
        resolve(true);
      }
    });

  });
}

function obtenerMedidasProteccion( persona ) {

  return new Promise(resolve => {

    $.ajax({
      method:'GET',
      url:'/public/obtener_medidas_proteccion',
      data:{
        persona,
        id_documento: tareaSeleccionada.id_acuerdo,
        tipo: 'acuerdo'
      },
      success:function(response){ resolve(response); }
    });

  });

}

function tableFracciones( i ) {

  if( !$('#tableFracciones'+i).hasClass('no-footer') ) {
    setTimeout(function(){
      tables[i] = $('#tableFracciones'+i).DataTable({
        ordering: false
      });
      
    },1)

  }  
}

function guardarCambiosMedidas( persona, i ) {

  let medidasPersonaAcu = [];

  var rows = $("#tableFracciones"+i).dataTable().fnGetNodes();

  $(rows).each( function() {
    
    let fraccion_valor = 0;
    
    if( $(this).find('.fraccion_acuerdo').find('.toggle-on').hasClass('active') )
      fraccion_valor = 1;

    let fraccion_descripcion_otros = '-';

    if( $(this).find('.fraccion_acuerdo').attr('id-cat') == 16  )
      fraccion_descripcion_otros = $(this).find('input').val();

    const medidas = {
      id_cat: $(this).find('.fraccion_acuerdo').attr('id-cat'),
      id_fraccion_valor: $(this).find('.fraccion_acuerdo').attr('id-acu-fraccion'),
      fraccion_valor,
      fraccion_descripcion_otros,      
    };

    medidasPersonaAcu.push(medidas);

  });
  console.log(medidasPersonaAcu);
  $.ajax({

    method: 'PATCH',
    url: '/public/modificar_medidas_proteccion_persona',
    data:{
      medidasPersona: medidasPersonaAcu,
      persona,
      id_documento: tareaSeleccionada.id_acuerdo,
      tipo: 'acuerdo'
    },
    success: function(response){

      $('#check'+persona).removeClass('d-none');
      setTimeout( () => {
        $('#check'+persona).addClass('d-none');
      },800);

    }

  });

  if ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 ) {

    let medidasPersonaSol = [];
    let persona;

    $(rows).each( function() {
      
      let fraccion_valor = 0;
      
      if( $(this).find('.fraccion_solicitud').find('.toggle-on').hasClass('active') )
        fraccion_valor = 1;

      let fraccion_descripcion_otros = '-';

      if( $(this).find('.fraccion_solicitud').attr('id-cat') == 16  )
        fraccion_descripcion_otros = $(this).find('input').val();

      const medidas = {
        id_cat: $(this).find('.fraccion_solicitud').attr('id-cat'),
        id_fraccion_valor: $(this).find('.fraccion_solicitud').attr('id-fraccion-solicitud'),
        fraccion_valor,
        fraccion_descripcion_otros,      
      };
      
      if( medidas.id_fraccion_valor != 0 )
        medidasPersonaSol.push(medidas);

      persona = $(this).find('.fraccion_solicitud').attr('id-persona');

    });
    console.log(medidasPersonaSol);
    $.ajax({

      method: 'PATCH',
      url: '/public/modificar_medidas_proteccion_persona',
      data:{
        medidasPersona:medidasPersonaSol,
        persona,
        id_documento: tareaSeleccionada.id_solicitud,
        tipo: 'solicitud'
      },
      success: function(response){

        $('#check'+persona).removeClass('d-none');
        setTimeout( () => {
          $('#check'+persona).addClass('d-none');
        },800);

      }

    });
    
  }
}
  
function addroww( table ) {


  var rows = $("#tableFracciones"+table).dataTable().fnGetNodes();

  const tr_otros = rows[ rows.length - 1 ],
    id_persona_sol = $($(tr_otros).children()[2]).find('.fraccion_solicitud').attr('id-persona'),
    tipo_fraccion_sol = $($(tr_otros).children()[2]).find('.fraccion_solicitud').attr('tipo-fraccion'),
    id_cat_sol = $($(tr_otros).children()[2]).find('.fraccion_solicitud').attr('id-cat'),
    id_fraccion_sol = $($(tr_otros).children()[2]).find('.fraccion_solicitud').attr('id-fraccion-solicitud');

  const toggle_solicitud = `
    <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
      <div class="toggle_on new-toggle toggle-light primary valor_fraccion fraccion_solicitud ${id_persona_sol}" tipo-fraccion="${tipo_fraccion_sol}" id-cat="${id_cat_sol}"  id-persona="${id_persona_sol}" id-fraccion-solicitud="0"></div>
    </div>
  `;

  const id_persona_acu = $($(tr_otros).children()[3]).find('.fraccion_acuerdo').attr('id-persona'),
    tipo_fraccion_acu = $($(tr_otros).children()[3]).find('.fraccion_acuerdo').attr('tipo-fraccion'),
    id_cat_acu = $($(tr_otros).children()[3]).find('.fraccion_acuerdo').attr('id-cat');
    // id_fraccion_acu = $($(tr_otros).children()[3]).find('.fraccion_acuerdo').attr('id-acu-fraccion');

  const toggle_acuerdo = `
    <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
      <div class="toggle new-toggle toggle-light primary valor_fraccion fraccion_acuerdo ${id_persona_acu}" tipo-fraccion="${tipo_fraccion_acu}" id-cat="${id_cat_acu}" id-acu-fraccion="0" id-persona="${id_persona_acu}"></div>
    </div>
    <div class="agregarRow" style="text-align:center; padding-top: 20px;">
      <a href="javascript:void(0)" onclick="addroww(${table})" style="font-size: 1.8em;"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
    </div>
  `;
  $('.agregarRow').remove();
  var rowNode = tables[table]
    .row.add( [ 
      $($(tr_otros).children()[0]).html(),
      $($(tr_otros).children()[1]).html(), 
      toggle_solicitud, 
      toggle_acuerdo ] )
    .draw()
    .node();
 
  $( rowNode )
    .css( 'background-color', '#f8f9fa' );

  tables[table].page( 'last' ).draw( 'page' );

  $('.new-toggle').toggles({
    on: true,
    height: 26,
    width: 50
  });

  $('.new-toggle').css('margin', 'auto');
}
