let carpeta_referida = {}
  quejosos = [],
  alias_parte = [],
  telefonos_persona = [],
  correos_persona = [],
  actos_reclamados = [],
  dataDoc = [];
  datos_amparos = [];

const tipo_defensor = [4,29,43,52]
  expRegFecha = /^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
  expRegHora = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;

const spinner = '<div class="sk-circle"><div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div>';


$(function(){
  'use strict'
  
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

    $('.time-edit-A').attr('type','time');          
    $('.fc-datepicker-A').attr('type','date');
  
  }else{
  
    $('.fc-datepicker-A').datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      format: 'dd/mm/yyyy',
      changeYear: true,
      yearRange: "c-100:"+ ( new Date().getFullYear() + 15 )
    });
  
    $('.clockpicker-A').clockpicker();
  }

});

$(document).ready(function() {

  buscar(1);
});

$('body').on('input','.select2-search__field', function () {
  $('#carpetaReferida').html('');
  if( $(this).parent().parent().find('ul').is("#select2-carpetaReferida-results") ){
    $.ajax({
      method: 'POST',
      url: '/public/buscar_carpetas_asociadas',
      data: {carpetaAsociada: $(this).val() },
      success: function(response){
        if( response.status == 100 ) 
          $(response.response).each( function (i, carpeta) {
            const newOption = new Option(carpeta.folio_carpeta, carpeta.id_carpeta_judicial, true, true);    
            $('#carpetaReferida').append(newOption).trigger('change');
          });
        else
          $('#carpetaReferida').val(null).trigger('change');
      }
    });
  }
});

$(document).on("click",function(e) {                  
  var container = $("#listaCarpetas");
  if (!container.is(e.target) && container.has(e.target).length === 0) $('#listaCarpetas').addClass('d-none');         
});

$('#categoriaAmparo').change(function() {
    if( $(this).val() == 'amparo_cierto'){
      $('#carpetaReferida').removeAttr('disabled');
    }else {
      $('#carpetaReferida').attr('disabled',true).val('');
      carpeta_referida = {};
    }
      
})


$('#carpetaReferida').on('input click', function () {

  if( $(this).val() == '' )    return false;

  $.ajax({
    method: 'POST',
    url: '/public/buscar_carpetas_asociadas',
    data: {carpetaAsociada: $(this).val() },
    success: function(response){
      $('#listaCarpetas').html('');
      if( response.status == 100 ) {
        $(response.response).each( function (i, carpeta) {
          $('#listaCarpetas').append(`
            <a href="javascript:void(0)"  onclick="seleccionarCarpeta(${carpeta.id_carpeta_judicial}, '${carpeta.folio_carpeta}')">
              <li class="list-group-item text-muted" style="border-bottom: none; border: none; padding: 6px 15px;">
                <p class="mg-b-0"><span class="">${carpeta.folio_carpeta}</span></p>
              </li>
            </a>
          `);          
        });
        $('#listaCarpetas').removeClass('d-none');
      } else {
        $('#listaCarpetas').append(`
          <li class="list-group-item text-muted" style="border-bottom: none; border: none; padding: 6px 15px;">
            <p class="mg-b-0"><span class="">Sin resultados</span></p>
          </li>
        `);
        $('#listaCarpetas').addClass('d-none');
      }
    }
  });

});

$('#calidadJuridica').change(function() {
 
  if( tipo_defensor.includes(parseInt($(this).val())) )
    $('#tipo_defensor').parent().parent().removeClass('d-none');
  else
    $('#tipo_defensor').parent().parent().addClass('d-none');

});

$('#estado').change(function() {
  $('#municipio').html('<option selected disabled value="">Elija una opción</option>');

  $.ajax({
    method: 'POST',
    url: '/public/obtener_municipios',
    data: { estado : $(this).val() },
    success: function(data) { 
      if( data.status == 100 )
        $(data.response).each(function( i, municipio ) {
          $('#municipio').append(`
            <option value="${municipio.cve_municipio}">${municipio.municipio}</option>
          `);
        });
    }
  });
});

$('#tipo_persona').change(function() {
  
  if( $(this).val() == 'fisica' ) {
    $('#apellido_parteno_parte').parent().parent().removeClass('d-none');
    $('#apellido_marteno_parte').parent().parent().removeClass('d-none');
    $('#nacionalidad').parent().parent().removeClass('d-none');
    $('#genero').parent().parent().removeClass('d-none');
  }else {
    $('#apellido_parteno_parte').parent().parent().addClass('d-none');
    $('#apellido_marteno_parte').parent().parent().addClass('d-none');
    $('#nacionalidad').parent().parent().addClass('d-none');
    $('#genero').parent().parent().addClass('d-none');
  }

});

$('#nacionalidad').change(function() {

  if( ['extranjera', 'extranjera_mexicana'].includes($(this).val())  )
    $('#otra_nacionalidad').parent().parent().removeClass('d-none');
  else
    $('#otra_nacionalidad').parent().parent().addClass('d-none');

});

function nuevoJuicioAmparo() {
  
  $('#carpetaReferida').html('').trigger('change');
  $('.form-control').val('').trigger('change');
  $('input[type="checkbox"]').prop('checked', false).trigger('change');
  $('#iconPDF').html('');
  $('#document').html('');
  alias_parte = [];
  telefonos_persona = [];
  correos_persona = []; 
  carpeta_referida = {};
  mostrarQuejosos();
  mostrarAlias();
  mostrarTelefonos();
  mostrarCorreos();
  mostrarActosReclamados();
  tipoAudiencia();
  $('#modalNuevoAmparo').modal('show');  

}

function seleccionarCarpeta( id_carpeta_judicial, folio_carpeta ) {
  $('#listaCarpetas').addClass('d-none');
  carpeta_referida = { 
    id_carpeta_judicial,
    folio_carpeta
  }
  $('#carpetaReferida').val(folio_carpeta);
  $('#quejoso').html('<option value="" disabled selected>Seleccione una opción</option>');
  $.ajax({
    method: 'POST',
    url: '/public/obtener_personas_carpeta',
    data: { carpeta : id_carpeta_judicial },
    success: function(response){
      console.log(response);
      if( response.status == 100 ) 
        $(response.response.personas).each(function( i, persona ) {
          const {id_persona, nombre, apellido_paterno, apellido_materno, calidad_juridica} = persona.info_principal;
          $('#quejoso').append(`<option value="${id_persona}">${nombre == null?'&nbsp':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno} (${calidad_juridica})</option>`);
        });
      else
        alert('Carpeta sin partes relacionadas');
    }
  });

}

function agregarQuejoso() {
  $('#select2-quejoso-containe').removeClass('error');

  if( $('#quejoso').val() == null ){
    $('#select2-quejoso-container').addClass('error');
    return false;
  }
    
  
  const quejoso = {
    nombre: $('#quejoso option:selected').text(),
    id_quejoso: $('#quejoso').val()
  }

  quejosos.push(quejoso);

  mostrarQuejosos();
}

function mostrarQuejosos() {
  $('#bodyQuejosos').html('');
  if( quejosos.length > 0 ) 
    $(quejosos).each(function ( i, quejoso) {
      $('#bodyQuejosos').append(`
        <tr>
          <td class="tx-center acciones">
            <a href="javascript:void(0)" onclick="eliminarQuejoso(${i})" style="font-size: 16px">
              <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
            </a>
          </td>
          <td class="nombre_quejoso">
            ${quejoso.nombre}
          </td>
        </tr>
      `);
    });
  else
    $('#bodyQuejosos').append(`<tr class="tx-center"><td colspan="2" class="tx-danger">No ha agregado a ningún quejoso</td></tr>`);
  
}

function eliminarQuejoso(i) {

  quejosos = quejosos.filter( ( q, j ) => j != i );
 
  mostrarQuejosos();

}

function nuevaParteQuejoso() {

  alias_parte = [];
  telefonos_persona = [];
  correos_persona = []; 

  mostrarAlias();
  mostrarTelefonos();
  mostrarCorreos();

  $('#modalNuevoAmparo').modal('hide');

  $('#modalAgregarParte').modal('show');
}

function agregarAlias() {
  $('.error').removeClass('error');
  if( $('#alias').val() == '' ) {
    $('#alias').addClass('error');
    return false;
  }

  const alias = {
    alias : $('#alias').val(),
    apellido_parteno: $('#apellido_paterno_alias').val(),
    apellido_marteno: $('#apellido_materno_alias').val()
  };

  alias_parte.push(alias);

  mostrarAlias();

}

function mostrarAlias() {

  $('#bodyAlias').html('');
  if( alias_parte.length > 0 ) 
    $(alias_parte).each(function( i, alias) {
      $('#bodyAlias').append(`
        <tr>
          <td>
            <a href="javascript:void(0)" onclick="eliminarAlias(${i})" style="font-size: 16px">
              <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
            </a>
          </td>
          <td>
            ${alias.alias}
          </td>
          <td>
            ${alias.apellido_parteno}  
          </td>
          <td>
            ${alias.apellido_marteno}
          </td>
        </tr>
      `);
    });
  else 
    $('#bodyAlias').append(`<tr class="tx-danger tx-center"><td colspan="4">No ha agregado ningún alias</td></tr>`);

}

function eliminarAlias(i) {
  
  alias_parte = alias_parte.filter( ( a, j ) => j != i );
 
  mostrarAlias();

}

function agregarTelefono() {

  $('.error').removeClass('error');

  if( $('#tipo_telefono').val() == null ){
    $('#select2-tipo_telefono-container').addClass('error');
    return false;
  }

  if( $('#numero_telefono').val() == '' ){
    $('#numero_telefono').addClass('error');
    return false;
  }

  

  const telefono = {
    tipo: $('#tipo_telefono').val(),
    lada: $('#lada').val(),
    numero: $('#numero_telefono').val(),
    extension: $('#extension').val(),
  }

  telefonos_persona.push(telefono);

  mostrarTelefonos();

}

function mostrarTelefonos() {
  $('#bodyTelefonos').html('');
  if( telefonos_persona.length > 0 ) 
    $(telefonos_persona).each( function( i, telefono) {
      $('#bodyTelefonos').append(`
        <tr>
          <td class="acciones">
            <a href="javascript:void(0)" onclick="eliminarTelefono(${i})" style="font-size: 16px">
              <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
            </a>
          </td>
          <td class="tipo">
            ${telefono.tipo == 'fijo' ? 'Fijo' : 'Celular'}
          </td>            
          <td class="lada">
            ${telefono.lada}
          </td>
          <td class="numero">
            ${telefono.numero}
          </td>
          <td class="extension">
            ${telefono.extension}
          </td>          
        </tr>
      `);
    });
  else
    $('#bodyTelefonos').append(`<tr class="tx-center"><td colspan="5" class="tx-danger">No ha agregado a ningún teléfono</td></tr>`);
  
}

function eliminarTelefono(i) {

  telefonos_persona = telefonos_persona.filter( ( t, j ) => j != i );

  mostrarTelefonos();
}

function agregarCorreo() {
  $('.error').removeClass('error');

  if( $('#correo_electronico').val() == '' ) {
    $('#correo_electronico').addClass('error');
    return false;
  }

  const correo = {
    correo : $('#correo_electronico').val(),
  };

  correos_persona.push(correo);

  mostrarCorreos();
}

function mostrarCorreos() {
  $('#bodyCorreos').html('');
  if( correos_persona.length > 0 ) 
    $(correos_persona).each(function( i, correo ) {
      $('#bodyCorreos').append(`
        <tr>
          <td class="acciones">
            <a href="javascript:void(0)" onclick="eliminarCorreo(${i})" style="font-size: 16px">
              <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
            </a>
          </td>
          <td class="correo">
            ${correo.correo}
          </td>
        </tr>
      `);
    });
  else
    $('#bodyCorreos').append(`<tr class="tx-center"><td colspan="2" class="tx-danger">No ha agregado a ningún correo electrónico</td></tr>`);
  
}

function eliminarCorreo(i) {

  correos_persona = correos_persona.filter( ( c, j ) => j != i );

  mostrarCorreos();
}

function guardarNuevaPersona() { 
  $('.error').removeClass('error');

  if( $('#calidadJuridica').val() == null ) {
    $('#select2-calidadJuridica-container').addClass('error');
    return false;
  }

  if( tipo_defensor.includes($('#calidadJuridica').val()) ) {
    if( $('#tipo_defensor').val() == null ){
      $('#select2-calidadJuridica-container').addClass('error');
      return false;
    }
  }

  if( $('#tipo_persona').val() == null ) {
    $('#select2-tipo_persona-container').addClass('error');
    return false;
  }

  if( $('#tipo_persona').val() == 'fisica' ) {
    if( $('#nacionalidad').val() == null ) {
      $('#select2-nacionalidad-container').addClass('error');
      return false;
    }
    if( $('#genero').val() == null ) {
      $('#select2-genero-container').addClass('error');
      return false;
    }
  }

  const nombres = $('#nombres_parte').val(),
    apellido_parteno = $('#tipo_persona').val() == 'moral' ? '' : $('#apellido_paterno_parte').val(),
    apellido_marteno = $('#tipo_persona').val() == 'moral' ? '' : $('#apellido_materno_parte').val();

  const persona = {
    calidad_juridica: $('#calidadJuridica').val(),
    tipo_defensor: $('#calidadJuridica').val() == null ? '' : $('#tipo_defensor').val(),
    tipo_persona: $('#tipo_persona').val(),
    nacionalidad: $('#tipo_persona').val() == 'moral' ? '' : $('#nacionalidad').val(),
    otra_nacionalidad: $('#otra_nacionalidad').val(),
    genero: $('#tipo_persona').val() == null ? '' : $('#genero').val(),
    nombres,
    apellido_parteno,
    apellido_marteno,
    nombre: nombres+' '+apellido_parteno+' '+apellido_marteno,
    id_quejoso: 0,
    alias: alias_parte,
    telefonos: telefonos_persona,
    correo: correos_persona,
    id_municipio: $('#municipio').val(),
    municipio_importacion:"-",
    entidad_federativa: $('#estado').val(),
    localidad: $('#localidad').val(),
    colonia: $('#colonia').val(),
    calle: $('#calle').val(),
    entre_calles: $('#entre_calles').val(),
    referencias: $('#otra_referencia').val(),
    codigo_postal: $('#codigo_postal').val(),
    no_exterior: $('#no_exterior').val(),
    no_interior: $('#no_interior').val(),
  };

  quejosos.push(persona);
  alias_parte = [];
  telefonos_persona = [];
  correo_persona = [];

  $('#modalAgregarParte').modal('hide');

  setTimeout( () => {
    $('#modalNuevoAmparo').modal('show');
  },300);

  mostrarQuejosos();
}

function agregarActoReclamado() {
  $('.error').removeClass('error');
   if( $('#acto_reclamado').val() == null ) {
      $('#select2-acto_reclamado-container').addClass('error');
      return false;
   }

   const acto_reclamado = {
     id_acto_reclamado : $('#acto_reclamado').val(),
     acto_reclamado: $('#acto_reclamado option:selected').text(),
     detalles_adicionales: $('#detalles_adicionales_acto').val(),
   }

   actos_reclamados.push(acto_reclamado);

   mostrarActosReclamados();
}

function mostrarActosReclamados() {
  $('#bodyActosReclamados').html('');
  if( actos_reclamados.length > 0) 
    $(actos_reclamados).each(function( i, acto) {
      $('#bodyActosReclamados').append(`
        <tr>
          <td class="acciones">
            <a href="javascript:void(0)" onclick="eliminarActoReclamado(${i})" style="font-size: 16px">
              <i class="fa fa-trash tx-danger" aria-hidden="true"></i>
            </a>
          </td>
           
          <td class="acto_reclamado">
          ${acto.acto_reclamado}
          </td>
          
          <td class="detalles_adicionales_acto">
          ${acto.detalles_adicionales}
          </td>
        </tr>
      `);
    });
  else
    $('#bodyActosReclamados').append(`<tr class="tx-center"><td colspan="3" class="tx-danger">No ha agregado a ningún acto reclamado</td></tr>`);
}

function eliminarActoReclamado(i) {

  actos_reclamados = actos_reclamados.filter( ( a, j ) => j != i );

  mostrarActosReclamados();
}

function guardarJuicioAmparo() {

  moment.locale('es-mx');

  $('.error').removeClass('error');

  if( $('#fechaRecepcion').val() == '' ) {
    $('#fechaRecepcion').addClass('error').focus();
    return false;
  }

  if( $('#horaRecepcion').val() == '' ) {
    $('#horaRecepcion').addClass('error').focus();
    return false;
  }

  if( $('#tipoAmparo').val() == null ) {
    $('#select2-tipoAmparo-container').addClass('error');
    $('#tipoAmparo').focus();
    return false;
  }

  if( $('#entidadFederativa').val() == null ) {
    $('#select2-entidadFederativa-container').addClass('error');
    $('#entidadFederativa').focus();
    return false;
  }

  if( $('#autoridadControl').val() == null ) {
    $('#select2-autoridadControl-container').addClass('error');
    $('#autoridadControl').focus();
    return false;
  }

  if( $('#categoriaAmparo').val() == null ) {
    $('#select2-categoriaAmparo-container').addClass('error');
    $('#categoriaAmparo').focus();
    return false;
  }

  if( $('input[class=juez_referir]:checked').length < 1 ) {
    $('.juez_referir').focus();
    return false;
  }

  if( quejosos.length < 1 ) {
    $('#select2-quejoso-container').addClass('error');
    $('#quejoso').focus();
    return false;
  }

  if( actos_reclamados.length < 1 ) {    
    $('#select2-acto_reclamado-container').addClass('error');
    $('#acto_reclamado').focus();
    return false;
  }

  if( !dataDoc.length ) {
    $('#archivoPDF').parent().addClass('error');
    $('#custom-input-file').parent().focus();
    return false;
  }

  if( $('#tipo_audiencia').val() == '' || $('#tipo_audiencia').val() == null ) {
    $('#select2-tipo_audiencia-container').addClass('error');
    $('#archivoPDF').focus();
    return false;
  }

  if( [1,2].includes( $('tipo_audiencia').val() ) ) {

    if( !$('input[name=fundamento]:checked').val() ) {
      $('.fundamentos').addClass('error');
      $('.fundamentos').focus();
      return false;
    }

    if( $('#fecha_termino').val() == '' || $('#fecha_termino').val() == null ) {
      $('#fecha_termino').addClass('error');
      $('#fecha_termino').focus();
      return false;
    }

    if( $('#hora_termino').val() == '' || $('#hora_termino').val() == null ) {
      $('#hora_termino').addClass('error');
      $('#hora_termino').focus();
      return false;
    }
    
    if( $('#dias').val() == '' || $('#dias').val() == null ) {
      $('#dias').addClass('error');
      $('#dias').focus();
      return false;
    }

    if( $('#horas').val() == '' || $('#horas').val() == null ) {
      $('#horas').addClass('error');
      $('#horas').focus();
      return false;
    }

  }

  $('#modalNuevoAmparo').modal('hide');
  $('#modal_loading').modal('show');

  const data = new FormData( $('#formNewAmparo')[0] );

  data.append('quejosos', JSON.stringify(quejosos));

  const jueces_referidos = [];

  $('input[name=juez_referido]:checked').each(function ( i, juez) {
    jueces_referidos.push({ id_juez: $(juez).val() });
  })

  data.append('jueces_referidos', JSON.stringify(jueces_referidos));
  data.append('actos_reclamados', JSON.stringify(actos_reclamados));
  data.append('documentos_amparo', JSON.stringify(dataDoc));
  data.append('carpeta_referida', JSON.stringify(carpeta_referida));
  data.append('actos_reclamados', JSON.stringify(actos_reclamados));

  $.ajax({
    method: 'POST',
    url: '/public/enviar_amparo',
    data,
    processData: false,
    contentType: false,
    success: function( response ){
       if( response.status == 100 ) {

        $('#succesMessage').html(`${response.message} <br><br> <span style="font-weight: bolder">Fecha de asignación:</span> ${moment(response.response.fecha_asignacion).format('lll')} Hrs. <br> <span style="font-weight: bolder">Folio de la carpeta:</span> ${response.response.folio_carpeta}`);
        abreModal('modalSuccess',800);
        buscar(1);
       } else {
        $('#errorMessage').html(response.response);
        abreModal('modalError', 800);
       }

       setTimeout( () => {
         $('#modal_loading').modal('hide')
       },600);
    }
  });

}

async function mostrarAutoridades() {

  $('#autoridadControl').html('<option selected disabled  value="">Elija una opción</option>');

  if( $('#tipoAmparo').val() != null && $('#entidadFederativa').val() != null ) {

    const autoridades = await obtenerAutoridades( $('#entidadFederativa').val(), $('#tipoAmparo').val() );

    if( autoridades.status == 100 ) {

      $( autoridades.response ).each( function( i, autoridad ) {
        $('#autoridadControl').append(`<option value="${autoridad.id_autoridad}">${autoridad.organo_jurisdiccional}</option>`);
      });

    }
  }

}

function obtenerAutoridades( entidad_federativa, tipo_amparo ) {

  return new Promise( resolve => {

    $.ajax({
      method: 'GET',
      url: '/public/obtener_autoridades_control_constitucional',
      data: { entidad_federativa,  tipo_amparo },
      success: function(response){
        
        resolve(response);

      }
    });

  })


}

function adjuntaDocumento( input ) {
  dataDoc = [];
  $('#document').html(spinner);
  $('#iconPDF').html(spinner);
  const data = new FormData( $('#formNewAmparo')[0] ),
    file = $('#archivoPDF').val(),
    extension = file.substring(file.lastIndexOf(".")),
    nombre_archivo = normalize((input.files[0].name).replace(extension,'')) + extension,
    tamanio_archivo = input.files[0].size;
  data.append('ext', extension);
  data.append('origen', 'b64');

  $.ajax({
    method: 'POST',
    url: '/public/vista_previa',
    data,
    processData: false,
    contentType: false,
    success: function(url) {

      dataDoc.push({
        extension_archivo: extension,
        url,
        nombre_archivo,
        tamanio_archivo
      });
      $('#archivoPDF').val('');
      mostrarArchivo()
    }
  });
}

function mostrarArchivo() {

  const { url, nombre_archivo } = dataDoc[0];

  $('#document').html(`<object type="application/pdf" data="${url}" style="width: 100%; height: 30em; border: 1px solid #EEE;" class="d-none d-md-block"></object>`);
  $('#iconPDF').html(`<a href="${url}"  target="_blank" style="border: 1px solid #EEE;padding: 1em;margin-top: 1em;min-width: 100%; overflow-x: auto;"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:1.8rem;position: relative; color: #C6362D; margin-right: 0.2em;"></i>${nombre_archivo}</a>`);

}

function tipoAudiencia() {

  $('#divEspecificacion').addClass('d-none');
  $('#especificacion').val('');
  $('#fecha_termino').val('').trigger('change');
  $('#hora_termino').val('').trigger('change');
  $('#dias').val('').trigger('change');
  $('#dias').val('').trigger('change');
  $('.divTermino').addClass('d-none');
  $('#divFundamentos').addClass('d-none');
  $('.fundamentos').addClass('d-none');
  $('input[name=fundamento]').prop('checked', false);

  switch( $('#tipo_audiencia').val() ) {

    case '1':
      $('#divFundamentos').removeClass('d-none');
      $('.divTermino').removeClass('d-none');
      $('#fundamento_132').removeClass('d-none');
      $('#fundamento_140').removeClass('d-none');
      break;
    case '2':
      $('#divFundamentos').removeClass('d-none');
      $('.divTermino').removeClass('d-none');
      $('#fundamento_117').removeClass('d-none');
      $('#fundamento_149').removeClass('d-none');
      break;
    case '3':
    case '14':
      $('#divEspecificacion').removeClass('d-none');
      break;
    default:
      return false;

  }

}

let top_calendar = 0;

$('#modalNuevoAmparo').on('scroll', function() {
  
  const scroll = $(this).scrollTop();
  const scroll_window = $(window).scrollTop();
  let nuevo_top = top_calendar - scroll;
  $('#ui-datepicker-div').css({top: ( nuevo_top )})
  
});

$('#modalNuevoAmparo').on( 'click', '.fc-datepicker-A', function() {
  top_calendar = $('#ui-datepicker-div').position().top + $('#modalNuevoAmparo').scrollTop();
});

$('#modalNuevoAmparo').on('scroll', function() {
  
  const scroll = $(this).scrollTop(),
    top_propover = $('.popover').attr('top'),
    scroll_window = $(window).scrollTop(),
    nuevo_top = top_propover-scroll;
  
  $('.popover').css({top: ( nuevo_top )})
  
});

function obtenerFechaTermino() {

  moment.locale('es-mx');
  // let fecha = new Date( $('#fecha_termino').val().split("-").reverse().join("-")+' '+$('#hora_termino').val() + ':00' );
  // const dia_horas = parseInt($('#dias').val() == '' ? 0 : $('#dias').val()) * 24;
  // const horas_totales = parseInt( dia_horas) + parseInt($('#horas').val() == '' ? 0 : $('#horas').val());

  const fecha_termino = $('#fecha_termino').val().split("-").reverse().join("-");
  const hora_termino = $('#hora_termino').val() + ':00';
  const dias = $('#dias').val();
  const horas = $('#horas').val();

  let fecha = calculaFechaTermino( fecha_termino, hora_termino, dias, horas);
	// fecha = moment(fecha_termino).format('lll');

  $('#fecha_hora_termino').val(fecha + ' Hrs.');
}

function calculaFechaTermino( fecha_termino, hora_termino, dias, horas ) {

  const fecha_inicial = fecha_termino + ' ' + hora_termino;
  const dia_horas = Number( dias == '' ? 0 : dias ) * 24;
  const horas_totales = dia_horas + Number( horas == '' ? 0 : horas );
  const fecha = moment( fecha_inicial ).add( horas_totales, 'hours' ).format('lll');
 
  return fecha;

}

function abreModal(modal, time=0){
  setTimeout(function(){
    $('#'+modal).modal('show');
  },time);
}

function buscar( pagina ) {
  
  moment.locale('es-mx');

  $.ajax({
    method: 'GET',
    url: '/public/obtener_amparos',
    data:{
      id_unidad: $('#unidad').val(),
      // id_solicitud_amparo: $('#solicitud_amparo').val(),
      tipo_amparo: $('#tipo_amparo_consulta').val(),
      categoria_aparo: $('#categoria_amparo_consulta').val(),
      fecha_min: $('#desde').val(),
      fecha_max: $('#hasta').val(),
      pagina,
    },
    success: function(response){
      console.log(response);
      $('#bodyTareas').html('');

      if( response.status == 100 ) {

        $('.anterior').attr('onclick', `buscar( ${(pagina - 1 ) < 1 ? 1 : (pagina - 1)} )`);
        $('.siguiente').attr('onclick', `buscar( ${ (pagina + 1 ) >= (response.response_paginacion.paginas_totales) ? (response.response_paginacion.paginas_totales) : (pagina + 1) } )`);
        $('.ultima').attr('onclick', `buscar(${response.response_paginacion.paginas_totales})`);
        $('.pagina').html(pagina);
        $('.total-paginas').html(response.response_paginacion.paginas_totales);

        datos_amparos = response.response;

        $( response.response ).each( async function (i, amparo) {
          const { id_solicitud,folio_solicitud, carpeta_judicial, carpeta_judicial_referida,fecha_recepcion,fecha_creacion, hora_recepcion, no_juicio_amparo, entidad_federativa, tipo_amparo, autoridad_control, usuario, autoridad_control_nombre, entidad_federativa_nombre, situacion, termino_fecha, termino_hora, plazo_dias, plazo_horas, folio,comentarios } = amparo;
          var cancelar_carpeta = '';


          if(situacion == 1){
            cancelar_carpeta = `
              <div title="Cancelar Carpeta" onclick="modalCancelar(${id_solicitud}, 0)" style="font-size: 16px; border: 1px solid #dc3545; border-radius: 20%; padding: 3px 4px; width:25px; height:25px; display: flex; justify-content:center; align-items: center; cursor:pointer;">
                <i class="fa fa-ban tx-danger" aria-hidden="true"></i>
              </div>
            `;
          }else{
            cancelar_carpeta = `
              <div title="Activar Carpeta" onclick="modalCancelar(${id_solicitud}, 1)" style="font-size: 16px; border: 1px solid #16A085; border-radius: 20%; padding: 3px 4px; width:25px; height:25px; display: flex; justify-content:center; align-items: center; cursor:pointer;">
                <i class="fa fa-check tx-success" aria-hidden="true"></i>
              </div>
            `;
          }

          cancelar_carpeta += `
            <div title="Ver Datos Carpeta" onclick="modal_ver_datos(${i})" style="font-size: 16px; border: 1px solid #848F33; border-radius: 20%; padding: 3px 4px; margin: 0 2%; width:25px; height:25px; display: flex; justify-content:center; align-items: center; width:25px; height:25px; display: flex; justify-content:center; align-items: center; cursor:pointer;">
              <i class="fa fa-info-circle" aria-hidden="true" style="color: #848F33 !important; "></i>
            </div>
          `;

          div_cancelar_botones = `
            <div style="display:flex; justify-content: space-between; width: 100%;">
              ${cancelar_carpeta}
            </div>
          `;

          let fecha_inicio_c = moment(fecha_creacion.substring(0,10)+' '+fecha_creacion.substring(11,19)).format('LLL') + ' Hrs.'
          
          let fecha_fin_c = ( termino_fecha == null ? '' : ( calculaFechaTermino( termino_fecha, termino_hora, plazo_dias, plazo_horas ) + ' Hrs.' ))

          div_fecha_registro = fecha_fin_c != '' ? `
            <div>
              <div style="border-left:3px solid #848f33; padding-left:5px; margin-bottom:5px; text-align:left;" ><span style="font-weight: bold; ">Fecha Inicio: </span>${fecha_inicio_c}</div>
              <div style="border-left:3px solid #848f33; padding-left:5px; text-align:left;" ><span style="font-weight: bold; ">Fecha Término: </span>${fecha_fin_c}</div>
            </div>
          `
          : `
            <div>
                <div style="border-left:3px solid #848f33; padding-left:5px; text-align:left;"><span style="font-weight: bold; ">Fecha Inicio: </span>${fecha_inicio_c}</div>
            </div>
          `;

          let comentarios_g = `
            <div style="${comentarios != null ? (comentarios.length > 20 ? "height: 100px; overflow-y:auto; text-align:justify;padding:4px;": "") : ""}">
              ${comentarios ?? ""}
            </div>
          `;

          let situacion_g=`
            <div>
              ${carpeta_judicial != null                 
                ? 
                  `<div>
                    
                  </div>`
                :
                  ""
              }
              <div></div>
            </div>
          `;

          const datos_registro = [
            div_cancelar_botones,
            folio,
            carpeta_judicial,
            div_fecha_registro,
            $('#tipoAmparo option[value='+tipo_amparo+']').text(),
            carpeta_judicial_referida,
            no_juicio_amparo,
            autoridad_control_nombre,
            entidad_federativa_nombre,
            usuario,
            comentarios_g,
            "",
          ];
          
          let tr = '<tr>';

          $( datos_registro ).each( function( i, registro ) {
            tr += `<td style="display:table-cell; position:relative; font-size: 0.9em;">${registro ?? "" }</td>`;
          });

          tr += '</tr>';

          $('#bodyTareas').append( tr );

        });

      } else {

        $('#bodyTareas').html('<tr><td colspan="12" style="text-align: center;" class="tx-danger">No se encontraron registros</td></tr>');

      }
    }
  });

}

function modalCancelar(id_solicitud,situacion){
  $('#modalBodyAmpa').find('i').remove();
  let mensaje  = '';
  let btn = '';

  if(situacion == 0){
    mensaje = '¿Deseas cancelar la carpeta?';
    btn = 'Cancelar';
    icon = `<i class="icon icon ion-ios-close-outline tx-100 tx-danger lh-1 mg-t-10  mg-b-20 d-inline-block"></i>`;
    $('#btnCancelarCarpeta').removeClass('btn-success');
    $('#btnCancelarCarpeta').addClass('btn-danger');
  }else{
    mensaje = '¿Deseas Activar la carpeta?'
    btn = 'Activar';
    icon = `<i class="icon ion-ios-checkmark-outline tx-100 tx-success lh-1 mg-t-20 d-inline-block"></i>`;
    $('#btnCancelarCarpeta').removeClass('btn-danger');
    $('#btnCancelarCarpeta').addClass('btn-success');
  }

  $('#modalBodyAmpa').prepend(icon);
  $('#menajeBodyAmpa').html(mensaje);
  $('#btnCancelarCarpeta').html(btn);
  $('#btnCancelarCarpeta').attr('onclick', `cancelarCarpeta(${id_solicitud}, ${situacion})`);
  $('#modalEliminar').modal('show');
}


function cancelarCarpeta(id_solicitud, situacion) {
  $('#modalEliminar').modal('hide');
  $.ajax({
      method: "POST",
      url: "/public/cancelar_carpeta_amparo",
      data: {
          id_solicitud: id_solicitud,
          situacion : situacion
      },
      success: function (response) {
          if (response.status == 100) {
            $('#succesMessage').html(response.response);
            abreModal('modalSuccess',800);
            buscar(1);
          }else{
            $('#errorMessage').html(response.response);
            abreModal('modalError', 800);
          }
      },
  });
}

function modal_ver_datos(index){
  let info = datos_amparos[index];

  let fecha_inicio_c = moment(info.fecha_creacion.substring(0,10)+' '+info.fecha_creacion.substring(11,19)).format('LLL') + ' Hrs.'
  let fecha_fin_c = ( info.termino_fecha == null ? '' : ( calculaFechaTermino( info.termino_fecha, info.termino_hora, info.plazo_dias, info.plazo_horas ) + ' Hrs.' ))

  let ul_actos = '<ul style="margin:0;">';
  for(i in info.actos_reclamados){
    ul_actos += `
      <li>${info.actos_reclamados[i].acto}</li>
    `;
  }
  ul_actos += '</ul>';

  console.log(info);

  let table=`
    <div style="padding:1% 0;  background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la solicitud</div>
    <table style="border: 1px solid #ccc;">
      <tboy>
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Folio de la Solicitud</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.folio}</td>
        </tr>
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Fecha de recepción</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${fecha_inicio_c}</td>
        </tr>
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Fecha de termino</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${fecha_fin_c}</td>
        </tr>
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Carpeta Judicial</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.carpeta_judicial ?? ""}</td>
        </tr>
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Carpeta Judicial referida</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.carpeta_judicial_referida}</td>
        </tr>   
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Id solicitud</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.id_solicitud_amparo}</td>
        </tr>   
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Unidad de Gestión</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.nombre_unidad}</td>
        </tr>         
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Tipo Amparo</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.tipo_amparo == 10 ? "Amparo directo" : "Amparo indirecto" }</td>
        </tr>   
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">N° de juicio de amparo</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.no_juicio_amparo}</td>
        </tr>  
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Autoridad requiriente</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.autoridad_control_nombre}</td>
        </tr>  
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Entidad federativa</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.entidad_federativa_nombre}</td>
        </tr>  
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Usuario</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.usuario}</td>
        </tr>         
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Tipos de promoción</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${info.tipo_promocion_nombre ?? ""}</td>
        </tr> 
        <tr>
          <td style="padding: 1%; border: 1px solid #ccc;">Actos Reclamados</td>
          <td style="padding: 1%; border: 1px solid #ccc;">${ul_actos}</td>
        </tr>   
      </tboy>    
    </table>
  `;

  $('#tabDatosSolicitud').html(table);

  let datos_personas = '';

  const personas_asc = info.personas.sort( (a,b) => {
              
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
        
    card_persona += '<table class="table tableDatosSujeto  tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody class="table-datos-sujeto"><tr><td colspan="4" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la persona</td></tr>';
    
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

  $('#modal-ver').modal('show');
}