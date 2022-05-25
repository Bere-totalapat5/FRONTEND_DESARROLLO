async function ver_solicitud( id_solicitud ) {
  
  var modo = "completo";
  const datos_solicitud = await obtenerDatosSolicitud( id_solicitud, modo );
  
  if( datos_solicitud.status != 100 )
    return error( "Error al consultar solicitud", datos_solicitud.message );

  solicitud_seleccionada = datos_solicitud.response[0];

  const { folio_solicitud_audiencia, personas, delitos_sin_relacionar, fecha_solicitud, carpeta_investigacion, cordinacion_territorial, fecha_fenece, folio_carpeta, folio_solicitud, fecha_recepcion, hora_recepcion, tipo_audiencia, duracion_aproximada, estatus_urgente, estatus_telepresencia, estatus_area_resguardo, estatus_mod_testigo_protegido, estatus_mesa_evidencia, estatus_delito_grave, mp_solicitante, tipo_solicitud, fiscalia, materia_destino, color, curp_mp, correo_mp, delitos, fecha_asignacion, descripcion_hechos } = solicitud_seleccionada;

  if( typeof permiso_turnar != undefined && permiso_turnar ){
    $('#boton').html(`<button type="button" onclick="turnar(${id_solicitud})" class="btn btn-success" data-dismiss="modal">Turnar</button>`);
  } else {
    $('#boton').html(``);
  }

  let tableSolicitud = '<table class="datatable tableDatosSujeto text-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td colspan="2" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la soliditud</td></tr>';

  str_delitos = '';
  $( delitos ).each( function( i, delito) { i == 0 ? str_delitos += delito.delito : str_delitos += ', ' + delito.delito});

  const arr_fs = fecha_solicitud.split(' ')[0].split('-').reverse(),
    fecha_solicitud_ = arr_fs[0] + '-' +arr_fs[1] + '-' +arr_fs[2];

  const datos_tabla_solicitud = [
    ["Folio de la solicitud:", folio_solicitud],
    ["Fecha de recepción:", fecha_recepcion == null ? '' : formatoFecha(fecha_recepcion.split(' ')[0])],
    ["Carpeta de investigación:", carpeta_investigacion == null ? '' : carpeta_investigacion],
    ["Fenece a las:", fecha_fenece == null ? '' : formatoFecha(fecha_fenece.split(' ')[0])],
    ["Tipo de audiencia:", tipo_audiencia],
    ["Fiscalía", fiscalia],
    ["Clase de audiencia:", 'Ordinaria'],
    ["Requiere resguardo:", estatus_area_resguardo],
    ["Requiere Telepresencia:", estatus_telepresencia],
    ["Requiere mesa de evidencia:", estatus_mesa_evidencia],
    ["Requiere modalidad de testigo protegido", estatus_mod_testigo_protegido],
    ["Delitos:", str_delitos],
    ["Materia:", materia_destino],
    ["Fecha de asignación de carpeta:", fecha_asignacion == null ? '' : formatoFecha(fecha_asignacion.split(' ')[0]) ],
    ["Fecha de la solicitud:", fecha_solicitud == null ? '' : formatoFecha(fecha_solicitud_)],
    ["Hora de recepción:", hora_recepcion],
    ["MP solicitante:", mp_solicitante],
    ["Correo del MP:", correo_mp == null ? '' : correo_mp],
    ["Descripción de los hechos:", descripcion_hechos == null ? '' : descripcion_hechos],
  ]

  $( datos_tabla_solicitud ).each( ( i, campo ) => { tableSolicitud += `<tr><td>${campo[0]}</td><td class="">${campo[1]}</td></tr>`; });

  tableSolicitud += '</tbody></table>';
  
  $('#tabDatosSolicitud').html(tableSolicitud);

  let datos_personas = '';

  const personas_asc = personas.sort( (a,b) => {
              
    if ( a.info_principal.id_calidad_juridica > b.info_principal.id_calidad_juridica ) return 1;
    if ( a.info_principal.id_calidad_juridica < b.info_principal.id_calidad_juridica ) return -1;
    
    return 0;

  });


  $( personas_asc ).each( function( i, persona ){

    const { razon_social, nombre, apellido_paterno, apellido_materno, calidad_juridica, ocuapcion, rfc_empresa, nivel_escolaridad, curp, otra_escolaridad, cedula_profesional, nombre_religion, genero, otra_religion, fecha_nacimiento, grupo_etnico, estado_civil, lengua, capacidad_diferente, sabe_leer_escribir, poblacion_callejera, poblcacion, otra_poblacion, nombre_poblacion, entiende_idioma_espanol, requiere_interprete, tipo_interprete, requiere_traductor, idioma_traductor, otro_idioma_traductor} = persona.info_principal;

    const campos_adicionales_persona = [
      ["Calidad juridica", calidad_juridica],
      ["Ocupación", ocuapcion],
      ["RFC", rfc_empresa],
      ["Nivel de escolaridad", nivel_escolaridad],
      ["CURP", curp],
      ["Otra escolaridad", otra_escolaridad],
      ["Cédula Profesional", cedula_profesional],
      ["Religión", nombre_religion],
      ["Género", genero],
      ["Otra religión", otra_religion],
      ["Fecha de nacimiento", fecha_nacimiento == null ? '' : formatoFecha(fecha_nacimiento)],
      ["Grupo étnico", grupo_etnico],
      ["Estado civil", estado_civil],
      ["Lengua", lengua],
      ["Capacidad diferente", capacidad_diferente],
      ["Sabe leer y escribir", sabe_leer_escribir],
      ["Población callejera", poblacion_callejera],
      ["Población", poblcacion],
      ["Otra población", otra_poblacion],
      ["Nombre de la población", nombre_poblacion],
      ["Entiende el idioma español", entiende_idioma_espanol],
      ["Requiere intérprete", requiere_interprete],
      ["Tipo de intérprete", tipo_interprete],
      ["Requiere traductor", requiere_traductor],
      ["Idioma del traductor", idioma_traductor],
      ["Otro idioma del traductor", otro_idioma_traductor],
    ];

    let card_persona = `<div id="accordion${i}" class="accordion-one mg-b-10  tx-uppercase" role="tablist" aria-multiselectable="true">
        <div class="card"><div class="card-header" role="tab" id="headingOne"><a data-toggle="collapse" data-parent="#accordion${i}" href="#collapseOne${i}" aria-expanded="true" aria-controls="collapseOne${i}" class="tx-gray-800 transition collapsed">${razon_social == null ? '' : razon_social}${nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno} <small style="color: #8A8A8A; font-weight: bold;">[${calidad_juridica}]</small></a></div><div id="collapseOne${i}" class="collapse" role="tabpanel" aria-labelledby="headingOne${i}"><div class="card-body" >`;
        
    card_persona += '<table class="datatable tableDatosSujeto  tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody class="table-datos-sujeto"><tr><td colspan="4" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la persona</td></tr>';
    
    $( campos_adicionales_persona).each( function( i, campo ){
      if( i%2 == 0 ) card_persona += '<tr>';
      card_persona += `<td>${campo[0]}</td><td style="">${campo[1] == null ? '' : campo[1]}</td>`;
      if( i%2 != 0 ) card_persona += '</tr>';
    });

    card_persona += '</tbody></table>';

    if( persona.delitos.length > 0 ) {

      card_persona += '<br><table  class="datatable tableDelitosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody><tr><td style="background-color: #848F33; color: #FFF;" class="tx-center" colspan="4">Delitos relacionados a la persona</td></tr><tr><th class="tx-center">Delito</th><th class="tx-center">Modalidad</th><th class="tx-center">Calificativo</th><th class="tx-center">Grado de realización</th></tr>';

      $( persona.delitos ).each( function( id, delito ) { 
        card_persona += `<tr><td>${delito.delito}</td><td>${delito.nombre_modalidad}</td><td>${delito.calificativo}</td><td>${delito.grado_realizacion.replace('_', ' ')}</td><tr>`;
      });

      card_persona += '</tbody></table>';

    }

    card_persona += '<div class="row"><div class="col-md-4"><br><table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody><tr><td  style="background-color: #848F33; color: #FFF;" class="tx-center">Teléfonos</td><tr>';

    const telefonos = persona.contacto.filter( contacto => contacto.tipo_contacto != 'correo electronico' );
    
    if( telefonos.length > 0 ) $( telefonos ).each(function( ic, contacto) { card_persona += `<tr><td>${contacto.tipo_contacto}: ${contacto.contacto} ${contacto.extension == null ? '' : 'ext:' +contacto.extension}<br></tr></td>`; });
    else card_persona += '<tr><td><span class="tx-italic" style="color: #a9a9a9">Sin teléfonos registrados</span></tr></td>';

    card_persona += '</tbody></table></div><div class="col-md-4"><br><table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody><tr><td class="tx-center" style="background-color: #848F33; color: #FFF;">Correos</td>';
    
    const correos = persona.contacto.filter( contacto => contacto.tipo_contacto == 'correo electronico' );

    if( correos.length > 0 ) $( correos ).each(function( ic, contaco) { card_persona += '<tr><td>'+contaco.contacto+'</tr></td>'; });
    else card_persona += '<tr><td><span class="tx-italic" style="color: #a9a9a9">Sin correos registrados</span></tr></td>';

    card_persona += '</tbody></table></div><div class="col-md-4"><br><table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody><tr><td style="background-color: #848F33; color: #FFF;" class="tx-center">Alias</td></tr>';
    
    if( persona.alias.length > 0 ) $( persona.alias ).each(function( ia, alias ){ card_persona += '<tr><td>'+alias.alias+'</td></tr>'; });
    else card_persona += '<tr><td><span class="tx-italic" style="color: #a9a9a9">Sin alias registrados</span></td></tr>';
    
    card_persona += '</tbody></table></div></div>';
    card_persona += '</div></div></div></div>';
    datos_personas += card_persona;

  });

  $('#tabPersonas').html(datos_personas);
    
  if( solicitud_seleccionada.delitos_sin_relacionar.length > 0) {

    let delitos_sin = '<table class="datatable tableDelitosSujeto text-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td style="background-color: #848F33; color: #FFF;" class="tx-center" colspan="4">Datos de los delitos no relacionados</td></tr></tr><tr><th class="tx-center">Delito</th><th class="tx-center">Modalidad</th><th class="tx-center">Calificativo</th><th class="tx-center">Grado de realización</th></tr>';

    $( solicitud_seleccionada.delitos_sin_relacionar ).each( function( id, delito ) {
      delitos_sin += `<tr><td>${delito.delito}</td><td>${delito.nombre_modalidad}</td><td>${delito.calificativo == null ? "" : delito.calificativo}</td><td>${delito.grado_realizacion.replace('_', ' ')}</td><tr>`;
    });

    delitos_sin += '</tbody></table>';

    $('#tabDelitosNoRelacionados').html(delitos_sin);
    $('#navDelitosNoRelacionados').removeClass('d-none');
  }else {
    $('#navDelitosNoRelacionados').addClass('d-none');
  }

  $('#modal-ver').modal('show');

}

function obtenerDatosSolicitud( id_solicitud, modo ) {
  return new Promise( resolve => {
    $.ajax({
      method: 'GET',
      url: '/public/obtener_solicitudes',
      data: { id_solicitud, modo },
      success: function( response ){
        resolve( response );
      }
    });
  });
}

function error(title='', message='', modal=''){
  $('#titleError').html(title);
  $('#messageError').html(message);
  $('#modalError').modal('show');
  if(modal!=''){
    $('#'+modal).modal('hide');
    $('#acepError').attr('onclick', `abreModal('${modal}',355)`);
  }
  return false;
}

function abreModal( modal, time = 0 ){
  setTimeout( () => { $('#'+modal).modal('show'); },time);
}