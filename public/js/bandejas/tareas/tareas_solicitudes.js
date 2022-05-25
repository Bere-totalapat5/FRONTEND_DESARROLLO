let fracciones_acuerdo = {},
  contiene_fracciones = true;

async function verSolicitud(){

  const { id_solicitud, tipo_solicitud_, tipo_resolucion_solicitud, id_juez_promujer, exhorto_autorizacion} = tareaSeleccionada;
  
  let documentos;
  console.log(tipo_solicitud_)  ;
  if( ['INICIAL', 'INICIAL_COPIA'].includes( tipo_solicitud_ ) ){

    const dataPDF =  await obtenerDocumentosSolicitud( id_solicitud );
    console.log(dataPDF);
    documentos = `
      <div class="d-flex">
        <object data="${dataPDF.response}"  id="documentoPDF" width="100%" height="350px"></object>
        <a href="${dataPDF.response}" target="_blank" class="d-md-none" style=" margin-top: 6em; margin-right: auto; margin-left: auto; border: 1px solid #EEE; padding: 10px; ">
          <i class="fa fa-download" aria-hidden="true" style="font-size: 2em"></i>
          <span class="d-block">documento_solicitud.pdf</span>
        </a>
      </div>`;
    
  }else if( ['PRO-MUJER', 'EXHORTO'].includes( tipo_solicitud_ )){

    versiones = await obtenerDocumentosSolicitud(id_solicitud, 'todas');

    documentos='<div class="row"><div class="col-md-3"><div class="list-group" style="padding-top:2.5vh">';
    
    $(versiones).each(function(index, version){

      const icono = icon( version.nombre_archivo.substring(version.nombre_archivo.lastIndexOf(".")) )
      
      documentos = documentos + `
        <div class="list-group-item pd-y-10 mg-b-5">
          <a href="javascript:void(0)" onclick="seleccionarDoumentoSolicitud(${id_solicitud},${version.id_version})">
            <div class="media" >
              <div class="d-flex mg-r-10 wd-50">
                ${icono}
              </div><!-- d-flex -->
              <div class="media-body">
                ${version.nombre_archivo}
              </div><!-- media-body -->
            </div><!-- media -->
          </a>
        </div><!-- list-group-item -->`;
    });

    documentos += '</div></div><div class="col-md-9 d-none d-md-inline-block">';
    const dataPDF =  await obtenerDocumentosSolicitud( id_solicitud );
    documentos += `<object data="${dataPDF.response}"  id="documentoPDF" width="100%" height="350px" class="mg-t-25"></object>`;
    documentos += '</div></div>';
  }
  
  const datosSolicitud = await obtenerDatosSolicitud(id_solicitud);
  
  let tipoResolucion = '';
  
  if( tipo_solicitud_=='PRO-MUJER') 
    tipoResolucion +=`
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
  else if ( tipo_solicitud_=='EXHORTO' && exhorto_autorizacion == null ){

    tipoResolucion += `<h4 class="mg-t-15 mg-b-20">Autorización de Exhorto</h4>`

  }else{
    
    tipoResolucion +=`
      <div class="form-group">
        <label class="form-control-label">Resolver por:</label>
        <select class="form-control select2" id="tipoResolucion" name="tipo_resolucion" autocomplete="off">
          ${configuracion.select_tipo_resolucion}
        </select>
      </div>
    `;
  }

  let accordionFracciones = '';
  
  if( tareaSeleccionada.tipo_solicitud_ == 'PRO-MUJER' || ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 )){
    
    accordionFracciones += `
      <div class="card fracciones d-none" id="accordionFraccionesSol">
        <div class="card-header fracciones" role="tab" id="headingTwo">
          <a class="collapsed tx-gray-800 transition fracciones" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="padding:10px; color:#000">
            Medidas de protección <i class="fa fa-angle-down" aria-hidden="true"></i>
          </a>
        </div>
        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
          <div class="card-body fracciones">
            <div class="row">
              <div class="col-md">
                <div class="card">
                  <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="navItemsFraccionesSol">
                      
                    </ul>
                  </div><!-- card-header -->
                  <div class="card-body">
                    <div class="tab-content" id="tabPaneFraccionesSol">
                      
                    </div><!-- tab-content -->
                  </div><!-- card-body -->
                </div><!-- card -->
              </div><!-- col -->
            </div>
          </div>
        </div>
      </div>`
    ;
  }

  
  $('#divTarea').append(`
    ${accordionFracciones}
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
  if( tareaSeleccionada.tipo_solicitud_ == 'PRO-MUJER' || ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 ))
    mostrarMedidasPersonas('solicitud');
  firmante();
  editorHTML();
}

function obtenerDatosSolicitud( solicitud ){
  
  moment.locale('es-mx'); 
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

        if( response.status == 100 ) {
          Object.assign(tareaSeleccionada, response.response[0]);
          const datos = {};
          let elementosPersonas = '';
          if( response.response[0].personas.length ) {

            const personas_solicitud = response.response[0].personas.sort( (a,b) => {
              
              if ( a.info_principal.id_calidad_juridica > b.info_principal.id_calidad_juridica ) return 1;
              if ( a.info_principal.id_calidad_juridica < b.info_principal.id_calidad_juridica ) return -1;
              
              return 0;

            });
            
            $(personas_solicitud).each(function(index, persona){

              const {alias, contacto, delitos, datos, direcciones, info_principal, id_unidad}= persona;

              unidad_tarea = id_unidad;

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
                    li=`${tipo_contacto}: ${contacto} ${extension==null?'':'ext '+extension}<br>`;
                    listaTelefonos=listaTelefonos.concat(li);
                  }
                }
              });

              $(direcciones).each(function( index, direccionSujeto ){

                const { estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle} = direccionSujeto;

                const tableDireccion=`
                  <br>
                  <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                    <tbody class="table-datos-sujeto">
                      <tr>
                        <td colspan="4" style="background-color: #848F33; color: #FFF;" class="tx-center">Domicilio ${index+1}</td>
                      </tr>
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

              ocupacion='';

              if(datos[0]){
                const {otra_ocupacion,nivel_escolaridad,otra_escolaridad,nombre_religion,otra_religion,grupo_etnico,otro_grupo_etnico,lengua,capacidad_diferente,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,poblacion,otra_poblacion,nombre_poblacion,entiende_idioma_espanol,requiere_interprete,tipo_interprete,requiere_traductor,idioma_traductor,otro_idioma_traductor}=datos[0];
                table_datos_adicionales=`
                  <table class="datatable tableDatosSujeto text-uppercase" style="overflow-x: none; display: table; color : #000">
                    <tbody class="table-datos-sujeto">
                      <tr><td style="background-color: #848F33; color: #FFF;" class="tx-center" colspan="4">Datos generales de la parte</td></tr>
                      <tr>
                        <td>Calidad Jurídica:</td>
                        <td>${calidad_juridica}</td>
                        <td>Ocupación:</td>
                        <td>${ocupacion==null?'':ocupacion}</td>
                      </tr>
                      <tr>
                        <td>Nombre ó Razón Social:</td>
                        <td>${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</td>
                        <td>Otra Ocupación:</td>
                        <td>${otra_ocupacion==null?'':otra_ocupacion}</td>
                      </tr>
                      <tr>
                        <td>RFC:</td>
                        <td>${rfc_empresa==null?'':rfc_empresa}</td>
                        <td>Escolaridad:</td>
                        <td>${nivel_escolaridad==null?'':nivel_escolaridad}</td>
                      </tr>
                      <tr>
                        <td>CURP:</td>
                        <td>${curp==null?'':curp}</td>
                        <td>Otra Escolaridad:</td>
                        <td>${otra_escolaridad==null?'':otra_escolaridad}</td>
                      </tr>
                      <tr>
                        <td>Cédula Profesional:</td>
                        <td>${cedula_profesional==null?'':cedula_profesional}</td>
                        <td>Religión:</td>
                        <td>${nombre_religion==null?'':nombre_religion}</td>
                      </tr>
                      <tr>
                        <td>Género:</td>
                        <td>${genero==null?'':genero}</td>
                        <td>Otra Religión:</td>
                        <td>${otra_religion==null?'':otra_religion}</td>
                      </tr>
                      <tr>
                        <td>Fecha de Nacimiento:</td>
                        <td>${fecha_nacimiento == null ? '' : formatoFecha(fecha_nacimiento)}</td>
                        <td>Grupo Étnico:</td>
                        <td>${grupo_etnico==null?'':grupo_etnico}</td>
                      </tr>
                      <tr>
                        <td>Nacionalidad:</td>
                        <td>${nacionalidad==null?'':nacionalidad}</td>
                        <td>Otro Grupo Étnico:</td>
                        <td>${otro_grupo_etnico==null?'':otro_grupo_etnico}</td>
                      </tr>
                      <tr>
                        <td>Estado Civíl:</td>
                        <td>${estado_civil==null?'':estado_civil}</td>
                        <td>Lengua:</td>
                        <td>${lengua==null?'':lengua}</td>
                      </tr>
                      <tr>
                        <td>Capacidad Diferente:</td>
                        <td>${capacidad_diferente==null?'':capacidad_diferente}</td>
                        <td>Discapacidad:</td>
                        <td>${descripcion_discapacidad==null?'':descripcion_discapacidad}</td>
                      </tr>
                      <tr>
                        <td>Sabe Leer y Escribir:</td>
                        <td>${sabe_leer_escribir==null?'':sabe_leer_escribir}</td>
                        <td>Población Callejera:</td>
                        <td class="tx-capitalize">${poblacion_callejera==null?'':poblacion_callejera}</td>
                      </tr>
                      <tr>
                        <td>Población:</td>
                        <td>${poblacion==null?'':poblacion}</td>
                        <td>Otra Población:</td>
                        <td>${otra_poblacion==null?'':otra_poblacion}</td>
                      </tr>
                      <tr>
                        <td>Nombre Población:</td>
                        <td>${nombre_poblacion==null?'':nombre_poblacion}</td>
                        <td>Entiende el Idioma Español:</td>
                        <td class="text-capitalize">${entiende_idioma_espanol==null?'':entiende_idioma_espanol}</td>
                      </tr>
                      <tr>
                        <td>Requiere Intérprete:</td>
                        <td>${requiere_interprete==null?'':requiere_interprete}</td>
                        <td>Tipo de Intérprete:</td>
                        <td>${tipo_interprete==null?'':tipo_interprete}</td>
                      </tr>
                      <tr>
                        <td>Requiere Traductor:</td>
                        <td>${requiere_traductor==null?'':requiere_traductor}</td>
                        <td>Idioma del Traductor:</td>
                        <td>${idioma_traductor==null?'':idioma_traductor}</td>
                      </tr>
                      <tr>
                        <td>Otro Idioma del Traductor:</td>
                        <td>${otro_idioma_traductor==null?'':otro_idioma_traductor}</td>
                      </tr>
                    </tbody>
                  </table>
                `;
              }

              let table = table_datos_adicionales;

              table += '<div class="row">';

              table +=`
                <div class="col-md-4">
                  <br>
                  <table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color : #000">
                    <thead>
                      <tr>
                        <td style="background-color: #848F33; color: #FFF;" class="tx-center">Teléfonos</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>${listaTelefonos==''?'<span class="tx-italic" style="color: #868ba1">Sin teléfonos registrados</span>':listaTelefonos}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              `;

              table +=`
                <div class="col-md-4">
                  <br>
                  <table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color : #000">
                    <thead>
                      <tr>
                        <td style="background-color: #848F33; color: #FFF;" class="tx-center">Correos</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>${listaCorreos==''?'<span class="tx-italic" style="color: #868ba1">Sin correos registrados</span>':listaCorreos}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              `;

              table +=`
                <div class="col-md-4">
                  <br>
                  <table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color : #000">
                    <thead>
                      <tr>
                        <td style="background-color: #848F33; color: #FFF;" class="tx-center">Alias</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>${listaAlias==''?'<span class="tx-italic" style="color: #868ba1">Sin alias registrados</span>':listaAlias}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              `;

              table += '</div>';

              table += listaDirecciones;

              const elementoPersona=`
                <div id="accordion${index}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
                  <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                      <a data-toggle="collapse" data-parent="#accordion${index}" href="#collapseOne${index}" aria-expanded="true" aria-controls="collapseOne${index}" class="tx-gray-800 transition collapsed">
                        ${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno} <small style="color: #8A8A8A; font-weight: bold;">[${calidad_juridica}]</small>
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

          const { folio_solicitud, materia_destino, fecha_asignacion, fecha_solicitud, fecha_recepcion, hora_recepcion, carpeta_investigacion, mp_solicitante, correo_mp, curp_mp, descripcion_hechos, tipo_audiencia, fecha_fenece, estatus_area_resguardo, estatus_telepresencia, estatus_mesa_evidencia, estatus_mod_testigo_protegido, delitos, fiscalia, unidad_registro_promujer} = tareaSeleccionada;

          let tableSolicitud = '<table class="datatable tableDatosSujeto text-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td colspan="2" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la soliditud</td></tr>';

          str_delitos = '';
          $( delitos ).each( function( i, delito) { i == 0 ? str_delitos += delito.delito : str_delitos += ', ' + delito.delito});

          const arr_fs = fecha_solicitud.split(' ')[0].split('-').reverse(),
            fecha_solicitud_ = arr_fs[0] + '-' +arr_fs[1] + '-' +arr_fs[2];

          const datos_tabla_solicitud = [
            ["Folio de la solicitud:", folio_solicitud],
            ["Fecha de recepción:", fecha_recepcion == null ? '' : moment(fecha_recepcion.split(' ')[0]).format('LL')],
            ["Carpeta de investigación:", carpeta_investigacion == null ? '' : carpeta_investigacion],
            ["Fenece a las:", fecha_fenece == null ? '' : moment(fecha_fenece.split(' ')[0]).format('LL')],
            ["Tipo de audiencia:", tipo_audiencia],
            ["Clase de audiencia:", 'Ordinaria'],
            ["Fiscalía", fiscalia ?? ''],
            ["Requiere resguardo:", estatus_area_resguardo ?? ''],
            ["Requiere Telepresencia:", estatus_telepresencia ?? ''],
            ["Requiere mesa de evidencia:", estatus_mesa_evidencia ?? ''],
            ["Requiere modalidad de testigo protegido", estatus_mod_testigo_protegido ?? ''],
            ["Delitos", str_delitos ?? ''],
            ["Materia:", materia_destino ?? ''],
            ["Fecha de asignación de carpeta:", fecha_asignacion == null ? '' : moment(fecha_asignacion.split(' ')[0]).format('LL') ],
            ["Fecha de la solicitud:", fecha_solicitud == null ? '' : moment(fecha_solicitud_).format('LL')],
            ["Hora de recepción:", hora_recepcion ?? ''],
            ["MP solicitante:", mp_solicitante ?? ''],
            ["Correo del MP:", correo_mp ?? ''],
            ["Unidad registrante", unidad_registro_promujer ?? ''],
            ["Descripción de los hechos:", descripcion_hechos ?? ''],
          ]

          $( datos_tabla_solicitud ).each( ( i, campo ) => { tableSolicitud += `<tr><td>${campo[0]}</td><td class="">${campo[1]}</td></tr>`; });

          tableSolicitud += '</tbody></table>';
          
          datos.infoSolicitud = tableSolicitud

          resolve(datos);

        }else{
          error(response.message.split('-')[1])
        }
      }
    });

  });
}

async function seleccionarDoumentoSolicitud( id_solicitud, version ) {
  const dataPDF =  await obtenerDocumentosSolicitud( id_solicitud , version );

  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

    window.open(dataPDF.response, '_blank');

  } else { 

    $('#documentoPDF').attr('data', dataPDF.response);

  }
}

function mostrarFracciones() { 
  $('#btnSiguiente').attr('onclick', 'validarTareaSolicitud()');
  $('#resolucion').addClass('d-none');
  $('#divFracciones').removeClass('d-none');
}

function guardarFracciones() {
  
  $('.error').removeClass('error');
  
  if( $('#victimaFracciones').val() == null || $('#victimaFracciones').val() == '' ) {
    $('#select2-victimaFracciones-container').addClass('error');
    return false;
  }

  $('#victimaFracciones option:selected').append(`<i class="fa fa-check tx-success" aria-hidden="true" style="position: absolute; top: 40px; left: 218px; font-size: 1.4em;"></i>`);

  fracciones_acuerdo[$('#victimaFracciones').val()] = [];
  
  $('.fraccion_acuerdo').each( function( i ) {
   
    const fraccion_acuerdo = {
      id_fraccion: $(this).attr('id'),
      id_persona: $('#victimaFracciones').val(),
      descripcion_otros: $(this).attr('id') == 16 ? $('#descripcion_otros').val() : "-",
      valor_solicitado: $(this).find('.toggle-on').hasClass('active') == true ? 1 : 0,
    };
   
    fracciones_acuerdo[$('#victimaFracciones').val()].push(fraccion_acuerdo);

  });
   
  $('#successFracciones').removeClass('d-none');
  setTimeout(function(){
    $('#successFracciones').addClass('d-none');
  },700);

}

async function showFraccionesPersona() { 
  
  await toggleOff();
  
  if( fracciones_acuerdo[ $('#victimaFracciones').val() ]){
    $ (fracciones_acuerdo[ $('#victimaFracciones').val() ]).each( function( i, fraccion) {
      
      if( fraccion.valor_solicitado == 1 ){
        $("#"+fraccion.id_fraccion).click();
      }


      if( fraccion.id_fraccion == 16 )
        $('#descripcion_otros').val(fraccion.descripcion_otros);

    });
  }
    
}


function toggleOff() {

  return new Promise( resolve => {

    $('.fraccion_acuerdo').each( function () {

      $('#descripcion_otros').val('');
      
      if( $(this).find('.toggle-on').hasClass('active') )
        $(this).click();

    })
    
    resolve(true);

  });
}

function mostrarMedidasPersonas( tipo ){ 
  
  const victimas = tareaSeleccionada.personas.filter( persona => tipo_victima.includes(persona.info_principal.id_calidad_juridica) );
  
  if( victimas.length < 1 )
    $('#tabPaneFraccionesSol').html('<div class="tx-center tx-danger">Sin víctimas registradas</div>');

  $( victimas ).each( async function( i, persona ) {

    const { nombre, apellido_paterno, apellido_materno, id_persona } = persona.info_principal;
    
      $('#navItemsFraccionesSol').append(`
        <li class="nav-item">
          <a class="nav-link" href="#tab${i}" data-toggle="tab" onclick="tableFracciones(${i})">${nombre == null ? '':nombre} ${apellido_paterno == null ? '' : apellido_paterno}</a>
        </li>
      `);

      let btnFracciones = '';

      if( tipo != 'solicitud' )
        btnFracciones += `<button class="btn btn-primary" onclick="guardarCambiosMedidas(${id_persona},${i})" type="button" style="padding: 10px 24px;">Guardar cambios<span style="position:absolute"> <i class="fa fa-check tx-success d-none" style="position: relative; left: 2px; font-size: 1.2em;" id="check${id_persona}" aria-hidden="true"></i></button>`

      $('#tabPaneFraccionesSol').append(`
        <div class="tab-pane" id="tab${i}">
          <div class="tx-center btn-nombre-fracciones">
            <h5 style="margin-bottom: 10px;">${nombre == null ? '': nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</h5>
            ${btnFracciones}
          </div>
          <table id="tableFracciones${i}" cellspacing style="display: block;overflow-x: scroll;" class="cell-border">
            <thead>
              <tr>
                <th>Fracción</th>
                <th></th>
                <th>Seleccionada</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="tbodySol${i}">
             
            </tbody>
          </table>
        </div>
      `);
      
      const medidasProteccion = await obtenerMedidasProteccion( id_persona, tipo == 'acuerdo' ? tareaSeleccionada.id_acuerdo : tareaSeleccionada.id_solicitud, tipo );
      
      if( medidasProteccion.status == 100 ) {
        contiene_fracciones = true;
        $(medidasProteccion.response).each(function( im, medida) {
          
          const { fraccion, descripcion, id_cat, id_padre, soli_fraccion_valor, id_soli_fraccion } = medida;

          if( id_padre == 0 ) {

            let toggle_solicitud;

            if( tareaSeleccionada.tipo_solicitud_ == 'PRO-MUJER' )

              if( soli_fraccion_valor == 1 )

                toggle_solicitud = `<div class="toggle-wrapper" style="margin: auto !important; display: table !important;" disabled=""><div class="toggle-light primary valor_fraccion" id="a1" style="height: 26px;width: 50px;" disabled=""><div class="toggle-slide"><div class="toggle-inner" style="width: 74px; margin-left: 0px;"><div class="toggle-on active" style="height: 26px; width: 37px; text-indent: -8.66667px; line-height: 26px;">SI</div><div class="toggle-blob" style="height: 26px; width: 26px; margin-left: -13px;"></div><div class="toggle-off" style="height: 26px; width: 37px; margin-left: -13px; text-indent: 8.66667px; line-height: 26px;">NO</div></div></div></div></div>`;
              else

                toggle_solicitud = `<div class="toggle-wrapper 1" style="margin: auto !important; display: table !important;"><div class="toggle-light primary valor_fraccion" id="a27" style="height: 26px; width: 50px;"><div class="toggle-slide"><div class="toggle-inner" style="width: 74px; margin-left: -24px;"><div class="toggle-on" style="height: 26px; width: 37px; text-indent: -8.66667px; line-height: 26px;">SI</div><div class="toggle-blob" style="height: 26px; width: 26px; margin-left: -13px;"></div><div class="toggle-off active" style="height: 26px; width: 37px; margin-left: -13px; text-indent: 8.66667px; line-height: 26px;">NO</div></div></div></div></div>`;

            else
              toggle_solicitud = `
                <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
                  <div class="toggle${soli_fraccion_valor == 1 ? '_on' : ''} toggle-light primary valor_fraccion fraccion_solicitud ${id_persona}" tipo-fraccion="solicitud" id-cat="${id_cat}"  id="${id_soli_fraccion}" id-persona="${id_persona}" id-fraccion-solicitud="${id_soli_fraccion}"></div>
                </div>
              `;

            let btnAgregar = '';

            if( medidasProteccion.response.length == (im + 1) )
                btnAgregar = `<div class="agregarRow" style="text-align:center; padding-top: 20px;">
                    <a href="javascript:void(0)" onclick="addroww(${i})"  style="font-size: 1.8em;"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                  </div>`;

            
            if( tipo == 'solicitud ' ) 
              $('#tbodySol'+i).append(`
                <tr style="background-color: #f8f9fa">
                  <td class="nFraccion pd-10"><h6>${fraccion}</h6></td>
                  <td class="dFraccion pd-10">
                    ${descripcion}
                    ${id_cat != 16 ? '': '(especifique):<div class="form-group mg-b-10-force mg-t-10"><input type="text" style="width:100%" id="descripcion_otros" class="form-control"></div>'}
                  </td>
                  <td class="sFraccion pd-10" style="text-align: -webkit-center;">
                    ${toggle_solicitud}
                  </td>
                  <td class="sFraccion pd-10" style="text-align: -webkit-center;">
                    <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
                      <div class="toggle toggle-light primary valor_fraccion fraccion_acuerdo ${id_persona}" tipo-fraccion="acuerdo" id-cat="${id_cat}" id-persona="${id_persona}"></div>
                    </div>
                    ${btnAgregar}
                  </td>
                </tr>
              `);
            else
              $('#tbodySol'+i).append(`
                <tr style="background-color: #f8f9fa">
                  <td class="nFraccion pd-10"><h6>${fraccion}</h6></td>
                  <td class="dFraccion pd-10">
                    ${descripcion}
                    ${id_cat != 16 ? '': '(especifique):<div class="form-group mg-b-10-force mg-t-10"><input type="text" style="width:100%" id="descripcion_otros" class="form-control"></div>'}
                  </td>
                  <td class="sFraccion pd-10" style="text-align: -webkit-center;">
                    ${toggle_solicitud}
                  </td>
                  <td class="sFraccion pd-10" style="text-align: -webkit-center;">
                    <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
                      <div class="toggle${medida.acu_fraccion_valor == 1 ? '_on' : ''} toggle-light primary valor_fraccion fraccion_acuerdo ${id_persona}" tipo-fraccion="acuerdo" id-cat="${id_cat}" id-acu-fraccion="${medida.id_acu_fraccion}" id-persona="${id_persona}"></div>
                    </div>
                    ${btnAgregar}
                  </td>
                </tr>
              `);

            $(medidasProteccion.response).each(function(ih , hipotesis) {

              if( hipotesis.id_padre == id_cat ) {
                $('#tbodySol'+i).append(`
                  <tr>
                    <td class="nHipotesis pd-10"></td>
                    <td class="dHipotesis pd-10 pd-l-20">${hipotesis.descripcion}</td>
                    <td class="sHipotesis pd-10" style="text-align: -webkit-center;">
                      <div class="toggle-wrapper 1" style="margin: auto !important; display: table !important;">
                        <div class="toggle-light primary valor_fraccion" id="a27" style="height: 26px; width: 50px;"><div class="toggle-slide"><div class="toggle-inner" style="width: 74px; margin-left: -24px;"><div class="toggle-on" style="height: 26px; width: 37px; text-indent: -8.66667px; line-height: 26px;">SI</div><div class="toggle-blob" style="height: 26px; width: 26px; margin-left: -13px;"></div><div class="toggle-off active" style="height: 26px; width: 37px; margin-left: -13px; text-indent: 8.66667px; line-height: 26px;">NO</div></div></div></div>
                      </div>
                    </td>
                    <td class="sHipotesis pd-10" style="text-align: -webkit-center;">
                      <div class="toggle-wrapper" style="margin: auto !important; display: table !important;">
                        <div class="toggle${hipotesis.acu_fraccion_valor == 1 ? '_on' : ''} toggle-light primary hipotesis fraccion_acuerdo ${id_cat} ${id_persona}" id-cat-padre="${id_cat}" id-cat="${hipotesis.id_cat}" id="${hipotesis.id_cat}" id-persona="${id_persona}"></div>
                      </div>
                    </td>
                  </tr>`);
              }

            });
          }
          
        });

        
        $('.toggle').toggles({
          on: false,
          height: 26
        });

        $('.toggle_on').toggles({
          on: true,
          height: 26
        });

        

      }else {
        contiene_fracciones = false;
      }
      
    // }
  });

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