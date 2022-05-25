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

function agregarMovimiento (){
 
  if( validacionDatos() ){

    // $.ajax({

    // });
  }
    
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
    if ( $('#numeroExpediente').val().split('/').length !=2 ||  expVacio.test( $('#numeroExpediente').val().split('/')[0] ) || $('#numeroExpediente').val().split('/')[1].length != 4 ) 
      return error('Datos incompletos', 'El formato del número de expediente es inválido', 'numeroExpediente');
      
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
  $('#'+campo).addClass('error');
  $('#modalError').modal('show');
  
  if ( modal != '' )
    $('#btnError').attr('onclick', `abreModal(${modal})`);

  return false;
}

