let coincidencias_exhorto = [],
  arrAlias = [];

$('.btn_cerrar').click( () => { $('#divCoincidencias').removeClass('div_visible'); });

function validaExistenciaExhorto() {

  coincidencias_exhorto = [];
  

  $('#divCoincidencias').removeClass('div_visible');
  
  if( $('#entidadExhortante').val() != '' && $('#entidadExhortante').val() != null && !(expVacio.test($('#expedienteOrigen').val())) && !(expVacio.test($('#folioOficio').val())) ) {
    
    $('#modal_loading').modal('show');

    $.ajax({
      method: 'GET',
      url: '/public/valida_existencia_exhorto',
      data: {
        exhorto_entidad_federativa: $('#entidadExhortante').val(),
        exhorto_expediente_origen: $('#expedienteOrigen').val(),
        exhorto_num_folio: $('#folioOficio').val()
      }, 
      success: function(response){

        if( response.status == 100 ) {

          coincidencias_exhorto = response.response.filter( coincidencia => coincidencia.id_solicitud != $('#id_exhorto').val() );

          if( coincidencias_exhorto.length ) {

            if( coincidencias_exhorto.length == 1 ) 
              $('#cantidad_coincidencias_exhortos').html('ha detectado una posible coincidencia');
            else
              $('#cantidad_coincidencias_exhortos').html(`han detectado ${response.response_pag.registros_totales} posibles coincidencias`);

            $('#divCoincidencias').addClass('div_visible');

          }
        }
          

        console.log(response);
        
        setTimeout( () => { $('#modal_loading').modal('hide'); }, 400);
      }
    });

  }
}

function muestraTablaCoincidencias() {

  moment.locale('es-mx');

  $('#bodyTableCoincidencias').html('');

  $( coincidencias_exhorto ).each( function ( i , exhorto ) {
    
    const { folio_carpeta, fecha_recepcion, exhorto_entidad_federativa, exhorto_expediente_origen, exhorto_num_folio, exhorto_juzgado, personas } = exhorto;

    const nombre_entidad = $('#entidadExhortante [value='+ exhorto_entidad_federativa+']').text();

    let participantes = '';

    $( personas ).each( function( i, persona) {

      const { nombre_completo, calidad_juridica } = persona.info_principal;

      participantes += `<span style="border-left: 4px solid #848F33 !important; padding-left: 3px; margin-bottom: 0.2em;" class="d-block"> ${nombre_completo} <small style="color: #8A8A8A; font-weight: bold;">[${calidad_juridica}]</small></span>`;

    });

    $('#bodyTableCoincidencias').append(`
      <tr>
        <td><span class="label_td">Acciones: </span> <a href="javascript:verInfoCoincidencia(${i})" class="accion"><i class="fa fa-search" aria-hidden="true"></i></a></td>
        <td class="folio_carpeta"><span class="label_td">Carpeta exhorto: </span> ${folio_carpeta ?? '<span style="font-style: italic; color: #CB0C0D">Exhorto sin turnar</span>'}</td>
        <td class="fecha_recepcion"><span class="label_td">Fecha recepción: </span> ${moment(fecha_recepcion).format('LL')}</td>
        <td class="entidad_federativa"><span class="label_td">Entidad federativa: </span> ${nombre_entidad}</td>
        <td class="expediente_origen"><span class="label_td">No. expediente origen: </span> ${exhorto_expediente_origen}</td>
        <td class="numero_oficio"><span class="label_td">No. oficio: </span> ${exhorto_num_folio}</td>
        <td class="juzgado_exhortante"><span class="label_td">Juzgado exhortante: </span> ${exhorto_juzgado}</td>
        <td class="participantes"><span class="label_td">Participantes: </span>${participantes}</td>
      </tr>
    `);

  });


  $('#modalCoincidencias').modal('show');

}

function verInfoCoincidencia( i ) {

  $('#modalCoincidencias').modal('hide');
  moment.locale('es-mx');

  const { folio_solicitud, fecha_solicitud, fecha_recepcion, hora_recepcion, folio_carpeta, nombre_unidad, exhorto_entidad_federativa, exhorto_juzgado, exhorto_nombre_juez, exhorto_expediente_origen, exhorto_num_folio, exhorto_medio_recepcion, personas, delitos_sin_relacionar } = coincidencias_exhorto[i],
    nombre_entidad = $('#entidadExhortante [value='+ exhorto_entidad_federativa+']').text(),
    s_fecha = (fecha_solicitud.split(' ')[0]).split('-'),
    fecha_solicitud_ = s_fecha[2] + '-' + s_fecha[1] + '-' + s_fecha[0] + ' ' + fecha_solicitud.split(' ')[1];

  const datos = [
    ["Folio de registro:", folio_solicitud],
    ["Fecha de registro:", moment(fecha_solicitud_).format('LLL') + ' hrs'],
    ["Fecha de recepción:", moment(fecha_recepcion + ' ' + hora_recepcion).format('LLL') + ' hrs'],
    ["Carpeta de Exhorto asignada:", folio_carpeta ?? '<span style="font-style: italic; color: #CB0C0D">Exhorto sin turnar</span>' ],
    ["Unidad de gestión judicial asignada:", nombre_unidad ?? '<span style="font-style: italic; color: #CB0C0D">Exhorto sin turnar</span>'],
    ["Entidad federativa de la autoridad exhortante:", nombre_entidad],
    ["Juzgado de la autoridad exhortante:", exhorto_juzgado],
    ["Nombre del Juez exhortante:", exhorto_nombre_juez],
    ["Número de expediente de origen:", exhorto_expediente_origen],
    ["No. de folio/oficio:", exhorto_num_folio],
    ["Medio de recepción:", exhorto_medio_recepcion == 'correo_electronico' ? 'correo electrónico' : 'físico'],
  ];

  let tabla = '<table class="datatable tableDatosSujeto text-uppercase" style="overflow-x: none; display: table; color: #000; border: 1px solid #eee;"><tbody class="table-datos-sujeto"><tr><td colspan="2" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos del exhorto</td></tr>';

  $( datos ).each( function ( j, dato ) { tabla += `<tr><td>${dato[0]}</td><td>${dato[1]}</td></tr>`; });

  tabla += '<tr><td>Figuras jurídicas</td><td>';

  $( personas ).each( function( p, persona) {

    const { nombre_completo, calidad_juridica, id_calidad_juridica } = persona.info_principal;

    tabla += `<span style="border-left: 4px solid #848F33 !important; padding-left: 3px; margin-bottom: 0.8em;" class="d-block"> ${nombre_completo} <small style="color: #8A8A8A; font-weight: bold;">[${calidad_juridica}]</small>`;

    if( id_calidad_juridica ==  46 ) {

      tabla += '<br><span style="color: #8A8A8A; margin-top: 8px; display: block; margin-bottom: 2px; "> Delitos:</span>'

      $( persona.delitos ).each( function ( d, delito ) { tabla += `<span style="margin-left: 5px; display: block;">• ${delito.delito}</span>`; });   

    }
    
    tabla += '</span>';

  }); 

  tabla += '</td></tr>';

  if( delitos_sin_relacionar.length ) {

    tabla += '<tr><td>Figuras jurídicas</td><td>';

    $( delitos_sin_relacionar ).each( function ( ds, delito ) {

      tabla += `<td><span style="border-left: 4px solid #848F33 !important; padding-left: 3px" class="d-block"> ${delito.delito} </small>`;

    });

    tabla += '</tr>';
  }
    
  tabla += '</tbody></table>';

  $('#datosExhortoCoincidencia').html(tabla);
  abreModal( 'modalExhortoCoincidencia' , 400);
}

function abreModal( modal = '' , time = '') {

  setTimeout( () => { $('#'+modal).modal('show'); }, time );

}

function guardarExhorto() {

  if( $('#id_exhorto').val() == '' ) enviarExhorto(0);
  else editarExhorto();
  
}

async function consultaExhorto( id_exhorto ) {

  $('#modal_loading').modal('show');

  $.ajax({
    method: 'GET',
    url: '/public/obtener_exhortos',
    data:{ id_solicitud: id_exhorto },
    success: function(response){
      if( response.status == 100 ) {

        const { fecha_recepcion, hora_recepcion, exhorto_entidad_federativa, exhorto_juzgado, exhorto_nombre_juez, exhorto_expediente_origen, exhorto_num_folio, exhorto_delegacion, exhorto_medio_recepcion, materia_destino, exhorto_tipo_unidad, estatus_delito_grave, exhorto_resumen, personas } = response.response[0];

        const s_fecha = fecha_recepcion.split('-');

        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

          $('#fechaRecepcion').val( fecha_recepcion );
        
        } else {

          $('#fechaRecepcion').val( s_fecha[2] + '-' + s_fecha[1] + '-' + s_fecha[0]);

        }
         
        $('#horaRecepcion').val(hora_recepcion.substr( 0, 5 ));
        $('#entidadExhortante').val(exhorto_entidad_federativa).trigger('change');
        $('#juzgadoExhortante').val(exhorto_juzgado);
        $('#juezExhortante').val(exhorto_nombre_juez);
        $('#expedienteOrigen').val(exhorto_expediente_origen).trigger('blur');
        $('#folioOficio').val(exhorto_num_folio).trigger('blur');
        $('#delegacionExhorto').val(exhorto_delegacion).trigger('change');
        $('input[name=medio_recepcion][value='+(exhorto_medio_recepcion == 'correo_electronico' ? 'correo' : 'fisico')+']').click();
        $('input[name=materia_destino][value='+materia_destino+']').click();
        $('input[name=tipo_unidad_destino][value='+exhorto_tipo_unidad+']').click();
        $('input[name=tipo_delito][value='+(estatus_delito_grave == "no" ? "nograve" : "grave")+']').click();
        $('#resumenExhorto').val(exhorto_resumen);

        $( personas ).each( function( i, persona ) {

          console.log(persona.delitos);

          const aliasSujeto = [],
            correos = [],
            telefonos = [],
            delitos = [];
  
          $( persona.alias ).each( function( ia, alias ) { 
            
            aliasSujeto.push({
              descripcion : alias.alias ?? '',
              id_alias : alias.id_alias,
              estatus: alias.estatus
            });
  
          });
  
          $( persona.contacto ).each( function( ic, contacto ) {
            
            if( contacto.tipo_contacto == 'correo electronico' )
  
              correos.push({
                id_contacto_persona : contacto.id_contacto_persona,
                correo: contacto.contacto ?? '',
                estatus: contacto.estatus
              });
  
            else
  
              telefonos.push({
                id_contacto_persona: contacto.id_contacto_persona,
                tipo: contacto.tipo_contacto ?? '',
                numero: contacto.contacto ?? '',
                extension: contacto.extension ?? '',
                estatus: contacto.estatus
              });
  
          });

          $( persona.delitos ).each( function( id, data_delito ) {

            const { id_persona_delito, id_delito, delito, id_modalidad} = data_delito;

            delitos.push({
              id_persona_delito,
              id_delito: id_delito ?? '',
              delito_text: delito ?? '',
              id_modalidad: id_modalidad ?? '',
              modalidad_text: '',
              id_calificativo: '',
              calificativo_text: '',
              forma_comision: "forma",
              grado_realizacion: '',
              grado_realizacion_text: '',
              delito_grave: $('#delito option[value='+id_delito+']').attr('data-grave'),
            });

          });
  
          const { id_persona, id_calidad_juridica, tipo_persona, nacionalidad, otra_nacionalidad, curp, rfc_empresa, cedula_profesional, nombre, apellido_paterno, apellido_materno, genero, fecha_nacimiento, edad, estado_civil, razon_social} = persona.info_principal;

          if( fecha_nacimiento != null ) {
            const s_fecha = fecha_nacimiento.split('-');
            var n_fecha_nacimiento = s_fecha[2] + '-' + s_fecha[1] + '-' + s_fecha[0];
          }

          let sujetoProcesal = {
            id_persona,
            tipo_parte: id_calidad_juridica,
            tipo_parte_text: $('#tipoParte option[value='+id_calidad_juridica+']').text(),
            tipo_persona: tipo_persona,
            tipo_persona_text:$('#tipoPersona option[value='+tipo_persona+']').text(),
            nacionalidad: nacionalidad ?? '',
            nacionalidad_text: nacionalidad == null ? '' : $('#nacionalidad option[value='+nacionalidad+']').text(),
            otra_nacionalidad: otra_nacionalidad ?? '',
            curp: curp ?? '',
            rfc: rfc_empresa ?? '',
            cedula_profesional: cedula_profesional ?? '',
            nombre: nombre ?? '',
            apellido_paterno: apellido_paterno ?? '',
            apellido_materno: apellido_materno ?? '',
            genero: genero ?? '',
            genero_text: genero == null ? '' : $('#genero option[value='+genero+']').text(),
            fecha_nacimiento: fecha_nacimiento == null ? '' : n_fecha_nacimiento,
            edad: edad ?? '',
            estado_civil: estado_civil ?? '',
            estado_civil_text: estado_civil == null ? '' : $('#estadoCivil ontion[value='+estado_civil+']').text(),
            razon_social: razon_social ?? '' ,
            alias:aliasSujeto,
            correos:correos,
            telefonos:telefonos,
            delitos,
          };

          $( persona.direcciones ).each( function( id, direccion ) {

            const { id_direccion_persona, calle, no_exterior, no_interior, colonia, codigo_postal, id_estado, id_municipio, localidad, entre_calles, referencias } = direccion;

            sujetoProcesal = {
              ...sujetoProcesal,
              id_direccion_persona,
              calle: calle ?? '',
              numero_exterior: no_exterior ?? '',
              numero_interior: no_interior ?? '',
              colonia: colonia ?? '',
              codigo_postal: codigo_postal ?? '',
              estado: id_estado ?? '',
              estado_text: id_estado == null ? '' : $('#estado option[value='+id_estado+']').text(),
              cve_estado: id_estado == null ? '' : $('#estado option[value='+id_estado+']').attr('data-cve-estado'),
              municipio: id_municipio ?? '',
              municipio_text: id_municipio == null ? '' : $('#municipio option[value='+id_municipio+']').text(),
              localidad: localidad ?? '',
              entre_calle: entre_calles ?? '',
              otra_referencia: referencias ?? '',  
            }

          });
  
          arrSujetosProcesales.push(sujetoProcesal);

        });

        muestraSujetosProcesales();
      } else {
        $('#messageError').html(`${response.message}`);
        $('#modalError').modal('show');
      }

      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },400);
    }
  });

  const documentos_exhorto = await obtener_archivos( id_exhorto );

  if( !documentos_exhorto.status ) {

    $( documentos_exhorto ).each( async function( i, doc ) {

      const doc_exhorto = await obtener_archivos( id_exhorto , doc.id_version );

      console.log( doc_exhorto );

    });

  }

}

function obtener_archivos( id_solicitud, version ) {

  return new Promise( resolve => {
    $.ajax({
      type: 'GET',
      url: 'public/descargar_pdf_exhorto',
      data: { id_solicitud, version },
      success: function(response) {
        resolve(response);
      }
    });
  });


}

function mostrarAlias( index_sujeto ) {

  $('#tbodyAlias').html('');

  if( arrAlias.length ) {

    $(arrAlias).each( function( ia, alias){
      console.log(alias);
      $('#tbodyAlias').append(`
        <tr>
          <td class="tx-center">
            <a href="javascript:void(0)" onclick="borrarAlias(${ia})" style="font-size: 1.4em;" class="tx-danger mg-l-10 btn-eliminar-alias">
              <i class="fa fa-trash-o" aria-hidden="true"></i>
            </a>
            <a href="javascript:void(0)" onclick="editarAlias(this, ${ia})" style="font-size: 1.4em;" class="mg-l-10 btn-editar-alias">
              <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
          </td>
          <td><div class="div-alias"><span>${alias.descripcion}</span><input class="input-alias" type="text" onblur="actualizaAlias(${ia}, this)"></div></td>
        </tr>`);
    });

  } else {
    $('#tbodyAlias').html('<tr><td style="font-style: italic;" class="tx-danger text-center" colspan="2">No ha agregado ningún alias</td></tr>');
  }
}


function borrarAlias( index ) {

  
  if( arrAlias[index].id_alias == 0 )

    arrAlias = arrAlias.filter( ( alias, i) =>  i != index );
  
  else 
    
    arrAlias = arrAlias.map( (i, alias) => {

      if( i == index )
        alias.estatus == 0;

      return alias;

    });

  mostrarAlias();

}

function editarAlias( element, index ) {
  $(element).parent().parent().find(".div-alias").addClass('active').find('input').val( arrAlias[index].descripcion );
}

function actualizaAlias( index, element ) {
  
  $('.div-alias').removeClass('active');

  arrAlias[index]['descripcion'] = $(element).val();

  mostrarAlias();
}

function tipoDelito() {
  
  $('#otro_delito').val('')

  if( $('#delito').val() == '33' )
    $('#div_otro_delito').removeClass('d-none')
  else
    $('#div_otro_delito').addClass('d-none')
    
}