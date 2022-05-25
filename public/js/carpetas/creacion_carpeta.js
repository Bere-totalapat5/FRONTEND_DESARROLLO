function generarCarpeta() {

  moment.locale('es-mx');
  $('#modal_loading').modal('show');

  if( $('#unidad').val() == '' || $('#unidad').val() == null) {
    $('#select2-unidad-container').addClass('error');
    $('#unidad').focus();
    return false;
  }

  if( $('#tipoCarpeta').val() == '' || $('#tipoCarpeta').val() == null) {
    $('#select2-tipoCarpeta-container').addClass('error');
    $('#tipoCarpeta').focus();
    return false;
  }

  $.ajax({
    method: 'POST',
    url: '/public/generar_carpeta',
    data: {
      unidad: $('#unidad').val(),
      tipo_carpeta: $('#tipoCarpeta').val(),
    },
    success: function (response) { 
      
      if( response.status == 100 ) {

        $('#succesMessage').html('<span style="font-weight: bold;">'+response.message +'</span><br><span style="font-weight: bold;">Carpeta judicial: </span>'+ response.response.datos_carpeta.folio_carpeta+'<br><span style="font-weight: bold;">Fecha de asignación: </span>'+moment(response.response.datos_carpeta.fecha_asignacion).format('LLL')+' Hrs.');
        $('#modalSuccess').modal('show')

      } else {
        $('#errorMessage').html(response.message);
        $('#modalError').modal('show');
      }

      if( response.status == -1)
        window.location.reload();

      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },400);
    }
  });
}