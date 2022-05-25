function obtenerInmuebleFiscalia() {
  unidades_gestion_destino = [];
  if ($('#tipoUnidadDestino').val() == null || $('#tipoUnidadDestino').val() == '')
    return false;

  if ($('#tipoUnidadDestino').val() == 'B' && $('#fiscalia').val() != null && $('#motivoIncompetencia').val() == 'vinculacion_proceso') {

    $.ajax({
      method: 'GET',
      url: '/public/obtener_inmueble_fiscalia',
      data: { fiscalia: $('#fiscalia').val() },
      success: function (response) {
        if (response.status == 100) {
          tipo_unidad = [$('#tipoUnidadDestino').val()];
          $('#edificioReceptor').val(response.response).trigger('change').attr('disabled', true);
          // $('#unidad_destino_select').addClass('d-none');
          // $('#unidad_destino_input').removeClass('d-none');
          obtenerUnidadDestino();
        } else {
          $('#edificioReceptor').removeAttr('disabled').val('').trigger('change');
          // $('#unidad_destino_input').addClass('d-none');
          // $('#unidad_destino_select').removeClass('d-none');
          $('#select_unidad').val('');
        }
      }
    });
  } else if ($('#tipoUnidadDestino').val() != 'B') {

    tipo_unidad = [$('#tipoUnidadDestino').val()];
    $('#edificioReceptor').attr('disabled', true);
    $('#select_unidad').val('');

    if ($('#motivoIncompetencia').val() != 'mandato_zona') {
      switch ($('#tipoUnidadDestino').val()) {
        case 'X':
        case 'A':
          $('#edificioReceptor').val('5').trigger('change');
          break;
        case 'B':
          $('#edificioReceptor').val('8').trigger('change');
          break;
        case 'M':
          $('#edificioReceptor').val('10').trigger('change');
          break;
        default:
        // $('#edificioReceptor').val('').trigger('change');
      }
    }
  }

}
