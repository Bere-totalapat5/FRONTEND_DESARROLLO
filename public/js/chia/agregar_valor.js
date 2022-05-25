function tipoValor() {
  
  if( $('#tipoValor').val() == '2' ) {
    $('#folio').val('CH');
    $('#banco').parent().removeClass('d-none');
  }else{
    $('#folio').val('');
    $('#banco').parent().addClass('d-none');
    $('#banco').val('').trigger('change');
  }

}

async function agregarMovimiento(){
  
  $('folioConfirmacion').val('');
  $('importeConfirmacion').val('$');
  
  if( validacionDatos() )
    $('#modal_loading').modal('show');
    if( ( await validarValor() ) == 0 )
      $('#modalConfirmacion').modal('show');
    else
      error('Valor existente', 'El valor indicado ya se encuentra registrado');
  

  setTimeout( () => {
    $('#modal_loading').modal('hide');
  },500);
    
    
}

function registraValor(){
  
  if( confirmacionValor() ){
    $('#modal_loading').modal('show');
      $.ajax({
        method: 'POST',
        url: '/public/registrar_valor_chia',
        data: {
          folio: $('#folio').val(),
          tipo_valor: $('#tipoValor').val(),
          moneda: $('#moneda').val(),
          importe: $('#importe').val().replace( '$','' ).replace(/,/g,''),
          depositante: $('#nombreDepositante').val(),
          carpeta_judicial: $('#numeroExpediente').val(),
          banco: $('#banco').val(),
          disposicion: $('#disposicion').val(),
          concepto: $('#concepto').val(),
          fecha_expedicion: $('#fechaExpedicion').val(),
          fecha_exhibicion: $('#fechaExhibicion').val(),
          beneficiario: $('#beneficiario').val(),
          institucion: $('#institucion').val(),
          documentosValor
        },
        success: function(response){
          if( response.status == 100 ){
            $('#modal-success-titulo').html(response.message);
            $('#modalSuccess').modal('show');            
          }else{
            error('Error al registrar', response.response);
          }
          setTimeout( () => {
            $('#modal_loading').modal('hide');
          },400);
        }
      });
  }
}

const confirmacionValor = () => {
  $('.error').removeClass('error');
  if( expVacio.test( $('#folioConfirmacion').val() ) )
    return error('Datos incompletos', 'El campo "Folio" es obligatorio', 'folioConfirmacion', 'modalConfirmacion');

  if( $('#importeConfirmacion').val().replace('$','') <= 0 || $('#importeConfirmacion').val() == "" )
    return error('Datos incompletos', 'El campo "Importe" es obligatorio', 'importeConfirmacion', 'modalConfirmacion');

  if( $('#folio').val().toUpperCase() != $('#folioConfirmacion').val().toUpperCase() )
    return error('Datos incorrectos', 'El Folio no coincide', 'folioConfirmacion', 'modalConfirmacion');

  if( $('#importe').val() != $('#importeConfirmacion').val() )
    return error('Datos incorrectos', 'El Importe no coincide', 'importeConfirmacion', 'modalConfirmacion');

  return true;
}

const validarValor = () => {
  return new Promise( resolve => {
    $.ajax({
      method: 'POST',
      url: '/public/valida_valor',
      data: {
        folio: $('#folio').val(),
      },
      success: function(response){
        console.log('validacion' + response);
        resolve(response);
      }
    });
  });
}

const validacionDatos = () => {
  $('.error').removeClass('error');

  if( $('#tipoValor').val() == '' || $('#tipoValor').val() == null )
    return error('Datos incompletos', 'El campo "Tipo de valor" es obligatorio', 'select2-tipoValor-container');

  if( expVacio.test( $('#folio').val() ) )
    return error('Datos incompletos', 'El campo "Folio" es obligatorio', 'folio');

  if( expVacio.test( $('#numeroExpediente').val() ) )
    return error('Datos incompletos', 'El campo "Número de expediente" es obligatorio', 'numeroExpediente');
  else  
    if ( $('#numeroExpediente').val().split('/').length !=3 ||  expVacio.test( $('#numeroExpediente').val().split('/')[0] ) || $('#numeroExpediente').val().split('/')[2].length != 4 ) 
      return error('Datos incompletos', 'El formato del número de carpeta judicial es inválido', 'numeroExpediente');
      
  if( $('#tipoValor').val() == '' || $('#tipoValor').val() == null )
      return error('Datos incompletos', 'El campo "Tipo de valor" es obligatorio', 'select2-tipoValor-container');

  if( $('#moneda').val() == '' || $('#moneda').val() == null )
    return error('Datos incompletos', 'El campo "Moneda" es obligatorio', 'select2-moneda-container');

  if( $('#importe').val().replace('$','') <= 0 || $('#importe').val() == "" )
    return error('Datos incompletos', 'El campo "Importe" es obligatorio', 'importe');

  if( !expRegFecha.test( $('#fechaExpedicion').val() ) ) 
    return error('Datos incompletos', 'El campo "Fecha de expedición" es obligatorio', 'fechaExpedicion');

  if( !expRegFecha.test( $('#fechaExhibicion').val() ) ) 
    return error('Datos incompletos', 'El campo "Fecha de exhibición" es obligatorio', 'fechaExhibicion');

  if( $('#concepto').val() == '' || $('#concepto').val() == null )
    return error('Datos incompletos', 'El campo "Concepto" es obligatorio', 'select2-concepto-container');
  
  if( expVacio.test( $('#nombreDepositante').val() ) )
    return error('Datos incompletos', 'El campo "Nombre del depositante" es obligatorio', 'nombreDepositante');

  if( $('#disposicion').val() == '' || $('#disposicion').val() == null )
    return error('Datos incompletos', 'El campo "A dsisposición de" es obligatorio', 'select2-disposicion-container');

  if( $('#tipoValor').val() === '2')
    if( $('#banco').val() == '' || $('#banco').val() == null )
      return error('Datos incompletos', 'El campo "Banco" es obligatorio', 'select2-banco-container');

  return true;
};

function error(title = '', message = '', campo = '', modal = ''){
  $('#titleError').html(title);
  $('#messageError').html(message);

  if(campo != '')
    $('#'+campo).addClass('error');
  
  $('#modalError').modal('show');
  
  if ( modal != '' )
    $('#btnError').attr('onclick', `abreModal('${modal}')`);

  return false;
}

function abreModal(modal, time=0){
  setTimeout(function(){
    $('#'+modal).modal('show');
  },time);
}