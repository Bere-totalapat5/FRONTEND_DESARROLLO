$('#aAtendidas').click( function() {
  $('#modalAlertaConfirmacion').modal('show');
  $('#mensajeAlertaConfirmacion').html('¿Está seguro de marcar como atendidas las tareas seleccionadas?')
});

$('#seleccionaTodas').click(function () {

  if( $(this).is(':checked') )
    $('.seleccion_tarea').prop('checked',true);
  else
    $('.seleccion_tarea').prop('checked',false);

});

function enviaTareasAtendidas() {

  $('#modalAlertaConfirmacion').modal('hide');
  $('#modal_loading').modal('show');

  let tareas = '';

  $('.seleccion_tarea:checked').each( function( i, tarea ) {
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

function verDatosNotificacion( i ) {

  notiSelecionada = arrNotificaciones[i];
  const { clave_bandeja, id_tabla_asociada, tipo_solicitud_ } = notiSelecionada;
  console.log( notiSelecionada );
  switch ( clave_bandeja ) {
    case 'RREM':
    case 'RREMA':
    case 'CREMA':
    case 'CTE':
    case 'RTCI':
      verDatosRemision( id_tabla_asociada );
      break;
    case 'RP':
      verDatosPromocion( id_tabla_asociada );
      break;
    case 'RS':
      verDatosSolicitud( id_tabla_asociada, tipo_solicitud_ );
      break;
    case 'CAUD':
      verDatosAudiencia( id_tabla_asociada );
      break;
    default:
      alert( 'clave desconocida ');
  }

}

async function verDatosRemision( remision ) {

  moment.locale('es-mx');
  const data_remision = await new Remision( remision );
  
  if ( data_remision.remision.tipo_remision == "incompetencia" ) {
    
    const { carpeta_investigacion, carpeta_judicial, comentarios_autorizacion, folio_carpeta_rem, imputado_privado_libertad, materia_destino, motivo_incompetencia, tipo_remision } = data_remision.remision;

    var campos_remision = [
      ['Tipo de remisión', tipo_remision],
      ['Carpeta de investigación', carpeta_investigacion],
      ['Carpeta judicial', carpeta_judicial],
      ['Comentarios de la autorización', comentarios_autorizacion ?? ''],
      ['Folio de la carpeta remitida', folio_carpeta_rem],
      ['Imputado(s) privado(s) de la libertad', imputado_privado_libertad ?? ''],
      ['Materia destino', materia_destino ?? ''],
      ['Motivo de la incompetencia', motivo_incompetencia ?? '']
    ];
  } else {

    const { folio_carpeta_rem, tipo_remision, carpeta_judicial, carpeta_investigacion, imputado_privado_libertad, materia_destino } = data_remision.remision;

    var campos_remision = [
      ['Tipo de remision', tipo_remision],
      ['Folio de la carpeta remitida', folio_carpeta_rem],
      ['Carpeta judicial', carpeta_judicial],
      ['Carpeta de investigación', carpeta_investigacion],
      ['Imputado(s) privado(s) de la libertad', imputado_privado_libertad ?? ''],
      ['Materia destino', materia_destino ?? '']
    ];
  }

  let tDatosRem = '<table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td colspan="2" class="tx-center" style="color: #FFF; background-color:#848F33">Datos generales de la remisión</td></tr>';

  $( campos_remision ).each( function( i, campo ) {
    tDatosRem += `<tr><td>${campo[0]}</td><td>${campo[1]}</td></tr>`;
  });

  tDatosRem += '</tbody></table>';

  
  let aPersonas = '';

  $( data_remision.remision.personas ).each( function( ip, persona ) {

    const { tipo_persona, nombre, apellido_paterno, apellido_materno, genero, edad, fecha_nacimiento, curp, rfc_empresa, razon_social,  cedula_profesional, calidad_juridica, estado_civil, nacionalidad } = persona.info_principal;

    const { otra_escolaridad, otra_ocupacion, otro_grupo_etnico, otro_idioma_traductor, requiere_traductor, idioma_traductor, requiere_interprete, tipo_interprete, capacidad_diferente, poblacion, otra_poblacion, entiende_idioma_espanol, descripcion_discapacidad, sabe_leer_escribir, poblacion_callejera, nivel_escolaridad, lengua, nombre_religion, nombre_poblacion, grupo_etnico } = persona.datos[0];

    ocupacion = '';
    
    const campos_persona = [
      ["Calidad Jurídica:", calidad_juridica],
      ["Ocupación:", ocupacion ?? ''],
      ["Nombre o razón social:", (razon_social ?? '') + (nombre ?? '') + ' ' + (apellido_paterno ?? '') + ' ' + ( apellido_materno ?? '')],
      ['Otra ocupacion:', otra_ocupacion ?? ''],
      ["RFC:", rfc_empresa ?? ''],
      ["Escolaridad:", nivel_escolaridad ?? ''],
      ["CURP:", curp ?? ''],
      ["Otra escolaridad:", otra_escolaridad ?? ''],
      ["Cédula preofecional:", cedula_profesional ?? ''],
      ["Religión:", nombre_religion ?? ''],
      ["Género:", genero ?? ''],
      ["Otra religíon:", otra_escolaridad ?? ''],
      ["Fecha de nacimiento:", fecha_nacimiento == null ? '' : moment(fecha_nacimiento).format('LL')],
      ["Grupo étnico:", grupo_etnico ?? ''],
      ["Nacionalidad:", nacionalidad ?? ''],
      ["Otro grupo étnico:", otro_grupo_etnico ?? ''],
      ["Estado civil:", estado_civil ?? ''],
      ["Lengua:", lengua ?? ''],
      ["Capacidad diferente:", capacidad_diferente ?? ''],
      ["Discapacidad:", descripcion_discapacidad ?? ''],
      ["Sabe leer y escribir:", sabe_leer_escribir ?? ''],
      ["Población callejera:", poblacion_callejera ?? ''],
      ["Población:", poblacion ?? ''],
      ["Otra población:", otra_poblacion ?? ''],
      ["Nombre de la población:", nombre_poblacion ?? ''],
      ["Entiende el idioma español:", entiende_idioma_espanol ?? ''],
      ["Requiere intérprete:", requiere_interprete ?? ''],
      ["Tipo de intérprete:", tipo_interprete ?? ''],
      ["Requiere traductor:", requiere_traductor ?? ''],
      ["Idioma del traductor:" , idioma_traductor ?? ''],
      ["Otro idioma del traductor:", otro_idioma_traductor ?? ''],
      ["Tipo de persona:", tipo_persona ?? ''],
    ];
    
    aPersonas += `<div id="accordion${ip}" class="accordion-one mg-b-10 tx-uppercase" role="tablist" aria-multiselectable="true">
      <div class="card"><div class="card-header" role="tab" id="headingOne"><a data-toggle="collapse" data-parent="#accordion${ip}" href="#collapseOne${ip}" aria-expanded="true" aria-controls="collapseOne${ip}" class="tx-gray-800 transition collapsed">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</a></div><div id="collapseOne${ip}" class="collapse" role="tabpanel" aria-labelledby="headingOne${ip}"><div class="card-body" ><table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td colspan="4" class="tx-center" style="color: #FFF; background-color:#848F33">Datos generales de la persona</td></tr>`;

    $( campos_persona ).each( function( ic, campo ) {
      if( ic%2 == 0) aPersonas += `<tr>`;

      aPersonas += `<td>${campo[0]}</td><td>${campo[1]}</td>`;

      if( ic%2 != 0) aPersonas += `</tr>`;
    });
            
    aPersonas += '</tbody></table>';
    aPersonas += '<div class="row">';

    if( persona.alias.length > 0 ) {
      
      aPersonas += '<div class="col-md-4"><br><table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td class="tx-center" style="color: #FFF; background-color:#848F33">Alias</td></tr>';

      $(persona.alias).each( function( ia, alias ) { 
        aPersonas += `<tr><td>${alias.alias} &nbsp;</td></tr>`;
      });

      aPersonas += '</tbody></table></div>';

    }

    const telefonos = persona.contacto.filter( telefono => telefono.tipo_contacto != 'correo electronico');
    const correos = persona.contacto.filter( correo => correo.tipo_contacto == 'correo electronico');

    if( telefonos.length > 0 ) {
      aPersonas += '<div class="col-md-4"><br><table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td class="tx-center" style="color: #FFF; background-color:#848F33">Teléfonos</td></tr>';

      $( telefonos ).each( function( it, telefono ) { 
        aPersonas += `<tr><td>${telefono.tipo_contacto}: ${telefono.contacto} ${telefono.extension == null ? ' ' : ' ext:' + telefono.extension}</td></tr>`;
      });

      aPersonas += '</tbody></table></div>';
    }

    if( correos.length > 0 ) {
      aPersonas += '<div class="col-md-4"><br><table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td class="tx-center" style="color: #FFF; background-color:#848F33">Correos</td></tr>';

      $( correos ).each( function( it, telefono ) { 
        aPersonas += `<tr><td>${telefono.contacto}</td></tr>`;
      });

      aPersonas += '</tbody></table></div>';
    }
    aPersonas += '</div>';

    $( persona.direcciones ).each( function( id, direccion) {

      aPersonas += `<br><table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td colspan="2" class="tx-center" style="color: #FFF; background-color:#848F33">Dirección ${id +1 }</td></tr>`;
      
      const { localidad, colonia, calle, entre_calles, referencias, codigo_postal, no_exterior, no_interior, municipio, estado } = direccion;

      const datos_direccion = [
        ["Estado:", estado ?? ''],
        ["Municipio:", municipio ?? ''],
        ["CP:", codigo_postal ?? ''],
        ["Localidad:", localidad ?? ''],
        ["Colonia:", colonia ?? ''],
        ["Calle:", calle ?? ''],
        ["Número exterior:", no_exterior ?? ''],
        ["Número interior:", no_interior ?? ''],
        ["Entre calles:", entre_calles ?? ''],
        ["Referencias:", referencias ?? ''],
      ];

      $( datos_direccion).each( function( id, campo ) {
        aPersonas += `<tr><td>${campo[0]}</td><td>${campo[1]}</td></tr>`;
      });

      aPersonas += '</tbody></table>';

    });

    aPersonas += '</div></div></div></div>';

  });

  const documentos = await data_remision.obtenerDocumentosRemision();
  console.log(documentos);
  let lDocs = '', 
  enlaces_documentos = '',
  object_documento = '';
  
  if( documentos.status == 100 ) {

    $( documentos.response ).each( function( index, version ) {
      
      const tipoArchivo = version.extension_archivo;
      
      switch (tipoArchivo){
        case 'pdf':
          icono = '<i class="fa fa-file-pdf-o mg-r-10" aria-hidden="true" style="font-size:20px;"></i>';
          break;
        case 'jpg':
        case 'png':
        case 'JPEG ':
          icono = '<i class="fa fa-file-image-o mg-r-10" aria-hidden="true" style="font-size:20px;"></i>';
          break;
        default:
          icono = '<i class="fa fa-question mg-r-10" aria-hidden="true" style="font-size:20px;"></i>';
      }

      enlaces_documentos +=`<a href="javascript:void(0)" onclick="verDocRemi(${index}, this)" class="${index == 0 ? 'bgDocRem' : ''}"><div style="border: 1px solid #ced4da; margin-bottom: 10px; padding: 10px; display: flex;" class="doc_remi">${icono} ${version.nombre_archivo.replace(data_remision.id_remision+'_', '')}</div></a>`;

      object_documento +=`<object data="/obtener_documentos_remision/${data_remision.id_remision}/${version.id_documento}" class="documento_remision ${index == 0 ? '' : 'd-none'}"  id="documentoPDF${index}" width="100%" height="455px" name="${version.nombre_archivo}.${version.extension_archivo}"></object>`;
    });

    lDocs += `<div class="row"><div class="col-md-3">${enlaces_documentos}</div><div class="col-md-9 ">${object_documento}</div></div>`;

  }

  $('#divDatosNoti').html(`
    <div id="validacionDatos">
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
              ${tDatosRem}
            </div><!-- tab-pane -->
            <div class="tab-pane" id="divDatosSujeto">
              ${aPersonas}
            </div><!-- tab-pane -->
            <div class="tab-pane" id="divDocumentos">
              ${lDocs}
            </div><!-- tab-pane -->
          </div><!-- tab-content -->
        </div><!-- card-body -->
      </div><!-- card -->
    </div>
  `);

  $('#modalDatosNoti').modal('show');

}

async function verDatosPromocion( promocion ) {

  const data_promocion = await new Promocion( promocion );
  const docs_promocion = await data_promocion.obtenerDocumentosPromocion();
  

  datosPromocion = data_promocion.promocion;

  const { folio_promocion, folio_carpeta,nombre_promovente, promovente_calidad_juridica, tipo_requerimiento} = datosPromocion;

  let documentos = '';
  dataPDF = await data_promocion.obtenerDocumentosPromocion();
  if( dataPDF.status == 100 ) documentos += `<object data="${dataPDF.response}"  id="documentoPDF" width="100%" height="350px" class="mg-t-25"></object>`;

  let tablePromocion = '<table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table"><tbody class="table-datos-sujeto"><tr><td colspan="2" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la promoción</td></tr>'
    
  const datos_tabla_promocion = [
    ["Folio de la promoción:", folio_promocion],
    ["Carpeta de investigación:", folio_carpeta],
    ["Promovente:", nombre_promovente],
    ["Calidad juridica del promovente", promovente_calidad_juridica == null ? '' : promovente_calidad_juridica],
    ["Tipo de requerimiento", tipo_requerimiento == null ? '' : tipo_requerimiento],
  ];

  $( datos_tabla_promocion ).each( function ( i, campo ) {
    tablePromocion += `<tr><td>${campo[0]}</td><td>${campo[1]}</td></tr>`;
  });

  let cards_partes = '';

  const data_carpeta = await new Carpeta( datosPromocion.id_carpeta_judicial );
  const partes_carpeta = await data_carpeta.obtenerPersonas();
  console.log(partes_carpeta);
  $( partes_carpeta.response.personas ).each(function(index, persona){

      const {alias, contacto, delitos, datos, direcciones, info_principal, id_unidad}= persona;

      unidad_tarea=id_unidad;

      let listaDelitos='',
          listaAlias='',
          listaCorreos='',
          listaTelefonos='',
          listaDirecciones='';

      $(alias).each( (index, aliasSujeto) => { listaAlias += aliasSujeto.alias + '<br>'; });

      $(contacto).each(function(index,contactoSujeto){
        const {id_contacto_persona,tipo_contacto, contacto, estatus, extension}=contactoSujeto;
        if( estatus == 1)
          if( tipo_contacto == 'correo electronico' ) listaCorreos += contacto + '<br>';
          else listaTelefonos += tipo_contacto + ': ' + contacto + ' ' + (extension == null ? '' : 'ext ' +extension) + '<br>';
      });

      $(direcciones).each(function( index, direccionSujeto ){

        const { estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle} = direccionSujeto;

        const tableDireccion=`
          <br>
          <table class="datatable tableDatosSujeto tx-uppercase" style=:"overflow-x: none; display: table">
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
      let table = '';

      const {otra_ocupacion,nivel_escolaridad,otra_escolaridad,nombre_religion,otra_religion,grupo_etnico,otro_grupo_etnico,lengua,capacidad_diferente,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,poblacion,otra_poblacion,nombre_poblacion,entiende_idioma_espanol,requiere_interprete,tipo_interprete,requiere_traductor,idioma_traductor,otro_idioma_traductor}=datos[0];
      
      table += '<table class="datatable tableDatosSujeto text-uppercase" style="overflow-x: none; display: table; color : #000"><tbody class="table-datos-sujeto"><tr><td style="background-color: #848F33; color: #FFF;" class="tx-center" colspan="4">Datos generales de la parte</td></tr>';

      const campos_datos_persona = [
        ["Calidad juridica:", calidad_juridica],
        ["Ocupación:", ocupacion == null ? '' : ocupacion],
        ["Nombre o razón social:", razon_social == null ? '' : razon_social+nombre == null ? '' : nombre + ' ' + apellido_paterno == null ? '' : apellido_paterno + ' ' + apellido_materno == null ? '' : apellido_materno],
        ["Otra ocupación:", otra_ocupacion == null ? '' : otra_ocupacion],
        ["RFC:", rfc_empresa == null ? '' : rfc_empresa],
        ["Escolaridad:", nivel_escolaridad == null ? '' : nivel_escolaridad],
        ["CURP:", curp == null ? '' : curp],
        ["Otra escolaridad:", otra_escolaridad == null ? '' : otra_escolaridad],
        ["Cédula profesional:", cedula_profesional == null ? '' : cedula_profesional],
        ["Religión:", nombre_religion == null ? '' : nombre_religion],
        ["Género:", genero == null ? '' : genero],
        ["Otra religión:", otra_religion == null ? '' : otra_religion],
        ["Fecha de nacimiento:", fecha_nacimiento == null ? '' : formatoFecha(fecha_nacimiento)],
        ["Grupo étnico:", grupo_etnico == null ? '' : grupo_etnico],
        ["Nacionalidad:", nacionalidad == null ? '' : nacionalidad],
        ["Otro grupo étnico:", otro_grupo_etnico == null ? '' : otro_grupo_etnico],
        ["Estado civil:", estado_civil == null ? '' : estado_civil],
        ["Lengua:", lengua == null ? '' : lengua],
        ["Capacidad diferente:", capacidad_diferente == null ? '' : capacidad_diferente],
        ["Discapacidad:", descripcion_discapacidad == null ? '' : descripcion_discapacidad],
        ["Sabe leer y escribir:", sabe_leer_escribir],
        ["Población callejera:", poblacion_callejera == null ? '' : poblacion_callejera],
        ["Población:", poblacion == null ? '' : poblacion],
        ["Otra población:", otra_poblacion == null ? '' : otra_poblacion],
        ["Nombre población:", nombre_poblacion == null ? '' : nombre_poblacion],
        ["Entiende el idioma español:", entiende_idioma_espanol == null ? '' : entiende_idioma_espanol],
        ["Requiere intérprete:", requiere_interprete == null ? '' : requiere_interprete],
        ["Tipo intérprete:", tipo_interprete == null ? '' : tipo_interprete],
        ["Requiere traductor:", requiere_traductor == null ? '' : requiere_traductor],
        ["Idioma traductor:", idioma_traductor == null ? '' : idioma_traductor],
        ["Otro idioma del traductor:", otro_idioma_traductor == null ? '' : otro_idioma_traductor],
      ];

      $( campos_datos_persona).each( function( i, campo ) {
        if( i%2 == 0 ) table += `<tr>`;
        table += `<td>${campo[0]}</td><td>${campo[1]}</td>`;
        if( i%2 != 0 ) table += `</tr>`;
      });
      
      table += '</tbody></table>';
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

      cards_partes += elementoPersona;

      });

  

  tablePromocion += '</tbody></table>';
          
      
     
  $('#divDatosNoti').html(`
    <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
      <div id="validacionDatos">
        <div class="card" style="min-height: 481px;">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#divSolicitud" data-toggle="tab">Datos Promoción</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#divPartes" data-toggle="tab">Partes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#divDocumentos" data-toggle="tab">Documentos</a>
              </li>
            </ul>
          </div><!-- card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="divSolicitud">
                ${tablePromocion}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDocumentos">
                ${documentos}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divPartes">
                ${cards_partes}
              </div><!-- tab-pane -->
            </div><!-- tab-content -->
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      <hr>
      <div id="resolucion" class="d-none">
      </div>
    </form>
  `);

  $('#modalDatosNoti').modal('show');
  console.log(data_promocion);
  console.log(docs_promocion);


}

async function verDatosSolicitud( solicitud, tipo_solicitud_ ) {

  const data_solicitud = await new Solicitud( solicitud, tipo_solicitud_ );
  console.log(data_solicitud);

  const datos = {};
  let elementosPersonas = '';
  if( data_solicitud.solicitud.personas ) {

    const perdonas_solicitud = data_solicitud.solicitud.personas.sort( (a,b) => {
      
      if ( a.info_principal.id_calidad_juridica > b.info_principal.id_calidad_juridica ) return 1;
      if ( a.info_principal.id_calidad_juridica < b.info_principal.id_calidad_juridica ) return -1;
      
      return 0;

    });
    
    $(perdonas_solicitud).each(function(index, persona){

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


  }

  const { folio_solicitud, materia_destino, fecha_asignacion, fecha_solicitud, fecha_recepcion, hora_recepcion, carpeta_investigacion, mp_solicitante, correo_mp, curp_mp, descripcion_hechos, tipo_audiencia, fecha_fenece, estatus_area_resguardo, estatus_telepresencia, estatus_mesa_evidencia, estatus_mod_testigo_protegido, delitos, fiscalia, unidad_registrante_prom} = data_solicitud.solicitud;

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
    ["Fiscalía", fiscalia],
    ["Requiere resguardo:", estatus_area_resguardo],
    ["Requiere Telepresencia:", estatus_telepresencia],
    ["Requiere mesa de evidencia:", estatus_mesa_evidencia],
    ["Requiere modalidad de testigo protegido", estatus_mod_testigo_protegido],
    ["Delitos", str_delitos],
    ["Materia:", materia_destino],
    ["Fecha de asignación de carpeta:", fecha_asignacion == null ? '' : moment(fecha_asignacion.split(' ')[0]).format('LL') ],
    ["Fecha de la solicitud:", fecha_solicitud == null ? '' : moment(fecha_solicitud_).format('LL')],
    ["Hora de recepción:", hora_recepcion],
    ["MP solicitante:", mp_solicitante],
    ["Correo del MP:", correo_mp == null ? '' : correo_mp],
    ["Unidad registrante", unidad_registrante_prom ?? ''],
    ["Descripción de los hechos:", descripcion_hechos == null ? '' : descripcion_hechos],
  ]

  $( datos_tabla_solicitud ).each( ( i, campo ) => { tableSolicitud += `<tr><td>${campo[0]}</td><td class="">${campo[1]}</td></tr>`; });

  tableSolicitud += '</tbody></table>';

  versiones = await data_solicitud.obtenerDocumentosSolicitud();
 
  documentos='<div class="row"><div class="col-md-3"><div class="list-group" style="padding-top:2.5vh">';
  
  
    console.log('--------');
    console.log(versiones);
    console.log('--------');
    
    let icono = '';

    icono='<i class="fa fa-file-pdf-o mg-r-10" aria-hidden="true" style="font-size:35px;"></i>';
    
    documentos += `
      <div class="list-group-item pd-y-10">
        <a href="javascript:void(0)">
          <div class="media" >
            <div class="d-flex mg-r-10 wd-50">
              ${icono}
            </div><!-- d-flex -->
            <div class="media-body">
              <h6 class="tx-inverse mg-t-10">Solicitud</h6>
            </div><!-- media-body -->
          </div><!-- media -->
        </a>
      </div><!-- list-group-item -->`;
  

  documentos += '</div></div><div class="col-md-9">';
  documentos += `<object data="${versiones.response}"  id="documentoPDF" width="100%" height="350px" class="mg-t-25"></object>`;
  documentos += '</div></div>';
  
  
  $('#divDatosNoti').html(`
    <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
      <div id="validacionDatos">
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
                ${tableSolicitud}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDatosSujeto">
                ${elementosPersonas}
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
  $('#modalDatosNoti').modal('show');
}

async function verDatosAudiencia( audiencia ) {
  
  const data_audiencia = await new Audiencia( audiencia );
  console.log(data_audiencia);
  const { carpeta_investigacion, descripcion_inmueble, direccion_inmueble, estatus_audiencia, estatus_semaforo, fecha_audiencia, folio_carpeta, hora_fin_audiencia, hora_inicio_audiencia,  nombre_sala, tipo_audiencia, juez, imputados, delitos, nombre_inmueble } = data_audiencia.audiencia;

  const datos_audiencia = [
    ["Carpeta de investigacion", carpeta_investigacion],
    ["Inmueble", nombre_inmueble],
    ["Dirección del inmuble", direccion_inmueble],
    ["Estatus de la audiencia", estatus_audiencia],
    ["Estatus del semáforo", estatus_semaforo],
    ["Fecha de la audiencia", moment(fecha_audiencia).format('dddd, LL')],
    ["Folio de la carpeta", folio_carpeta],
    ["Inicio de la audiencia", hora_inicio_audiencia],
    ["Fin de la audiencia", hora_fin_audiencia],
    ["Nombre de la sala", nombre_sala],
    ["Tipo de la audiencia", tipo_audiencia],
    ["Juez", juez.nombre_usuario+' ['+ juez.cve_juez +']'],
  ];

  let tabla_audiencia = '<table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td colspan="2" class="tx-center" style="color: #FFF; background-color:#848F33">Datos de la audiencia</td></tr>';

  $( datos_audiencia ).each( (i, dato) => {
    tabla_audiencia += `<tr><td>${dato[0]}</td><td>${dato[1]}</td></tr>`;
  });

  tabla_audiencia += '</tbody></table>';

  let imputados_audiencia = '<table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td colspan="2" class="tx-center" style="color: #FFF; background-color:#848F33">Imputados</td></tr><tr><th class="tx-center">Tipo persona</th><th class="tx-center">Nombre o razón social</th></tr>';

  $( imputados ).each( (i, imputado) => {
    imputados_audiencia += `<tr><td>${imputado.tipo}</td><td>${imputado.nombre ?? ''}${imputado.razon_social ?? ''}</td></tr>`;
  });

  imputados_audiencia += '</tbody></table>';

  let delitos_audiencia = '<table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td class="tx-center" style="color: #FFF; background-color:#848F33">Delitos</td></tr>';

  $( delitos ).each( (i, delito) => {
    delitos_audiencia += `<tr><td class="tx-center">${delito.delito}</td></tr>`;
  });

  delitos_audiencia += '</tbody></table>';

  $('#divDatosNoti').html(`
    <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
      <div id="validacionDatos">
        <div class="card" style="min-height: 481px;">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#divSolicitud" data-toggle="tab">Datos audiencia</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#divDatosSujeto" data-toggle="tab">Imputados y delitos</a>
              </li>              
            </ul>
          </div><!-- card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="divSolicitud">
                ${tabla_audiencia}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDatosSujeto">
                ${imputados_audiencia}
                <br>
                ${delitos_audiencia}
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
  $('#modalDatosNoti').modal('show');

}

function verDocRemi(i, e){
  $('.bgDocRem').removeClass('bgDocRem');
  $(e).addClass('bgDocRem');
  $('.documento_remision').addClass('d-none');
  $('#documentoPDF'+i).removeClass('d-none');
}

