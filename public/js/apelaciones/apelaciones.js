let carpeta_referida = {},
 dataDoc = [];

const expRegFecha = /^([0-2][0-9]|3[0-1])(-)(0[1-9]|1[0-2])\2(\d{4})$/,
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
      yearRange: "c-100:"+ new Date().getFullYear()
    });
  
    $('.clockpicker-A').clockpicker();
  }

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

function nuevoRecursoApelacion() {
  
  $('#carpetaReferida').html('').trigger('change');
  $('.form-control').val('').trigger('change');
  $('#fechaEmisionAudiencia').html('').trigger('change');
  $('input[type="radio"]').prop('checked', false).trigger('change');
  $('#modalNuevaApelacion').modal('show');  
  $('#iconPDF').html('');
  $('#document').html('');
  carpeta_referida = {};
}

function seleccionarCarpeta( id_carpeta_judicial, folio_carpeta ) {

  $('#apelante').html('<option value="">Cargando partes...</option>');
  $('#fechaEmisionAudiencia').html('<option value="">Cargando audiencias...</option>');

  $('#listaCarpetas').addClass('d-none');
  carpeta_referida = { 
    id_carpeta_judicial,
    folio_carpeta
  }
  $('#carpetaReferida').val(folio_carpeta);

  $.ajax({
    method: 'POST',
    url: '/public/obtener_personas_carpeta',
    data: { carpeta : id_carpeta_judicial },
    success: function(response){
      $('#apelante').html('<option value="" disabled selected>Seleccione una opción</option>');
      if( response.status == 100 ) 
        $(response.response.personas).each(function( i, persona ) {
          const {id_persona, nombre, apellido_paterno, apellido_materno, calidad_juridica, id_calidad_juridica} = persona.info_principal;
          $('#apelante').append(`<option data-calidad-juridica=${id_calidad_juridica} value="${id_persona}">${nombre == null?'&nbsp':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno} (${calidad_juridica})</option>`);
        });
      else
        alert('Carpeta sin partes relacionadas');
    }
  });

  $('#fechaEmisionAudiencia').html('<option value="" disabled selected>Seleccione una opción</option>');
  obtenerFechasAud( id_carpeta_judicial );

}

let top_calendar = 0;

$('#modalNuevaApelacion').on('scroll', function() {
  
  const scroll = $(this).scrollTop();
  const scroll_window = $(window).scrollTop();
  let nuevo_top = top_calendar - scroll;
  $('#ui-datepicker-div').css({top: ( nuevo_top )})
  
});

$('#modalNuevaApelacion').on( 'click', '.fc-datepicker-A', function() {
  top_calendar = $('#ui-datepicker-div').position().top + $('#modalNuevaApelacion').scrollTop();
});

$('#modalNuevaApelacion').on('scroll', function() {
  
  const scroll = $(this).scrollTop(),
    top_propover = $('.popover').attr('top'),
    scroll_window = $(window).scrollTop(),
    nuevo_top = top_propover-scroll;
  
  $('.popover').css({top: ( nuevo_top )})
  
});

function adjuntaDocumento( input ) {
  $('#document').html(spinner)
  $('#iconPDF').html(spinner)
  dataDoc = [];
  const data = new FormData( $('#formNuevaApelacion')[0] ),
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
  $('#iconPDF').html(`<a href="${url}"  target="_blank" style="border: 1px solid #EEE;padding: 1em;margin-top: 1em;min-width: 100%; overflow: auto;"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:1.8rem;position: relative; color: #C6362D; margin-right: 0.2em"></i>${nombre_archivo}</a>`);

}

function resolucionImpugnada( ) {

  $('.tipo_resolucion_impugnada').addClass('d-none');

  if( $('input[name=resolucion_impugnada]:checked').val() == 'emitida_escrito' ) {
    $('#juezEmisor').removeAttr('disabled');
    $('.resolucion_impugnada_escrito').removeClass('d-none');
  } else {
    $('#juezEmisor').attr('disabled', true);
    $('.resolucion_impugnada_audiencia').removeClass('d-none'); 
  }
    
}

function obtenerFechasAud(carpeta_judicial,fecha_selec = ''){
 
  $.ajax({
    method:'POST',
    url:'/public/obtener_fechas_aud_sent',
    data:{carpeta_judicial},
    success:function(response){
      
      if( response.status == 100 ){
        $(response.response).each(function(index, audiencia){
          moment.locale('es-mx');          
          const { hora_inicio_audiencia, hora_fin_audiencia, id_audiencia, fecha_audiencia, tipo_audiencia} = audiencia;
          $('#fechaEmisionAudiencia').html('<option value="" disabled selected>Seleccione una opción</option>');
          $('#fechaEmisionAudiencia').append(
            `<option value="${audiencia.id_audiencia}" data-juez="${audiencia.juez.nombre_usuario}" data-cvj="${audiencia.id_juez}" data-fecha="${audiencia.fecha_audiencia} ${audiencia.hora_inicio_audiencia}" > ${moment(fecha_audiencia).format('L')} ${moment(fecha_audiencia +' '+hora_inicio_audiencia).format('LTS')}  Hrs - ${tipo_audiencia} - ID: ${id_audiencia}</option>`
          );
        });
      }
    }
  }); 
}

function elejirJuez() {

  const juez = $('#fechaEmisionAudiencia option:selected').attr('data-cvj');
  $('#juezEmisor').val(juez).trigger('change');

}

function guardarJuicioAmparo() {

  $('.error').removeClass('error');

  if( !carpeta_referida.id_carpeta_judicial ) {
    $('#carpetaReferida').addClass('error').focus();
    return false;
  }

  if( $('#apelante').val() == null || $('#apelante').val() == '' ) {
    $('#apelante').focus();
    $('#select2-apelante-container').addClass('error');
    return false;
  }

  if( !$('input[name=resolucion_impugnada]:checked').val() ) {
    $('.resolucion_impugnada').addClass('error').focus();
    return false;
  }

  if( $('#nombreResolucion').val() == '' ) {
    $('#nombreResolucion').addClass('error').focus();
    return false;
  }

  if( $('input[name=resolucion_impugnada]:checked').val() == 'emitida_audiencia' ) {
    
    if ( $('#fechaEmisionAudiencia').val() == null || $('#fechaEmisionAudiencia').val() == '' ) {

      $('#fechaEmisionAudiencia').focus();
      $('#select2-fechaEmisionAudiencia-container').addClass('error');
      return false;
    }
  } else {
    
    if( !expRegFecha.test($('#fechaEmision').val()) ) {

      $('#fechaEmision').addClass('error').focus();
      return false;
    }
  
  }

  if( !$('input[name=agravios_orales]:checked').val() ) {
    $('.agravios_orales').addClass('error').focus();
    return false;
  }

  if( $('#juezEmisor').val() == '' || $('#juezEmisor').val() == null ) {

    $('#juezEmisor').focus();
    $('#select2-juezEmisor-container').addClass('error');
    return false;
  }

  if( $('#oficioDEGJ').val() == '' ) {
    $('#oficioDEGJ').addClass('error').focus();
    return false;
  }

  if( !$('input[name=senala_domicilio]:checked').val() ) {
    $('.senala_domicilio').addClass('error').focus();
    return false;
  }

  if( !dataDoc.length ) {

    $('.custom-input-file').addClass('error');
    return false;
  }

  const data = new FormData( $('#formNuevaApelacion')[0] );
  data.append('documento_apelacion', JSON.stringify(dataDoc));
  data.append('id_carpeta_referida', carpeta_referida.id_carpeta_judicial);
  data.append('folio_carpeta', carpeta_referida.folio_carpeta);
  data.append('figura_juridica', $('#apelante option:selected').attr('data-calidad-juridica'));
  data.append('juez', $('#juezEmisor').val() );

  if( $('input[name=resolucion_impugnada]:checked').val() == 'emitida_audiencia' ) {
    data.append('fecha_emision', $('#fechaEmisionAudiencia option:selected').attr('data-fecha'));
    data.append('id_audiencia', $('#fechaEmisionAudiencia').val());
  } else {
    data.append('fecha_emision', $('#fechaEmision').val() );
    data.append('id_audiencia', '' );
  }

  $('#modal_loading').modal('show');
  $('#modalNuevaApelacion').modal('hide');
  
  $.ajax({
    method: 'POST',
    url: '/public/enviar_apelacion',
    data,
    processData: false,
    contentType: false,
    success: function(response){
      console.log(response);
      if( response.status == 100 ) {
        $('#successMessage').html(`${response.message}<br><span style="font-weight: bold">Folio: </span>${response.response.folio_carpeta}`);
        $('#modalSuccess').modal('show');
        buscar(1);
      } else {
        $('#errorMessage').html(response.message);
        $('#modalError').modal('show');
      }
      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },400);
      
    }
  });

}

function buscar( pagina ) {
  
  moment.locale('es-mx');

  $.ajax({
    method: 'GET',
    url: '/public/obtener_apelaciones',
    data:{
      fecha_min: $('#desde').val(),
      fecha_max: $('#hasta').val(),
      pagina,
    },
    success: function(response){
      console.log(response);
      $('#bodyApelaciones').html('');

      if( response.status == 100 ) {

        $('.anterior').attr('onclick', `buscar( ${(pagina - 1 ) < 1 ? 1 : (pagina - 1)} )`);
        $('.siguiente').attr('onclick', `buscar( ${ (pagina + 1 ) >= (response.response_paginacion.paginas_totales) ? (response.response_paginacion.paginas_totales) : (pagina + 1) } )`);
        $('.ultima').attr('onclick', `buscar(${response.response_paginacion.paginas_totales})`);
        $('.pagina').html(pagina);
        $('.total-paginas').html(response.response_paginacion.paginas_totales);

        $( response.response ).each( async function (i, apelacion ) {
          const { folio, fecha_creacion, resolucion_impugnada, nombre_resolucion , carpeta_judicial, carpeta_judicial_referida, usuario, persona_apelante, calidad_juridica} = apelacion;

          const datos_registro = [
            "",
            folio,
            moment(fecha_creacion).format('LLL'),
            carpeta_judicial_referida,
            carpeta_judicial,
            persona_apelante,
            calidad_juridica,
            resolucion_impugnada.replace('_', ' '),
            nombre_resolucion,
            "En trámite",
            "N/E",
            usuario,
            "",
          ];
          
          let tr = '<tr>';

          $( datos_registro ).each( function( i, registro ) {
            tr += `<td>${registro}</td>`;
          });

          tr += '</tr>';

          $('#bodyApelaciones').append( tr );

        });

      } else {

        $('#bodyApelaciones').html('<tr><td colspan="12" style="text-align: center;" class="tx-danger">No se encontraron registros</td></tr>');

      }
    }
  });

}