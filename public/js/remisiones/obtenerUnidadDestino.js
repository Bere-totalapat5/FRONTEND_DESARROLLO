function obtenerUnidadDestino() {

  unidades_gestion_destino = [];

  if ($('#motivoIncompetencia').val() == 'privado_libertad')
    switch ($('#edificioReceptor').val()) {
      case '-1':
        unidades_gestion_destino = [];
        break;
      case '1':
        unidades_gestion_destino = [19, 32];
        break;
      case '2':
        unidades_gestion_destino = [13, 17, 31];
        break;
      case '3':
        unidades_gestion_destino = [18];
        break;
      case '4':
        unidades_gestion_destino = [33];
        break;
      default:
        alert('Error en la selección de edificio');

        return true;
    }

  else
    $.ajax({
      method: 'POST',
      url: '/public/obtener_unidad_destino_remision',
      data: {
        tipo_unidad,
        edificio_receptor: $('#edificioReceptor').val(),
      },
      success: function (response) {
        let strUnidades = '';
        if (response.status == 100) {
          $(response.response).each(function (index, unidad) {

            const { nombre_unidad, id_unidad_gestion } = unidad;
            unidades_gestion_destino.push(id_unidad_gestion);

            if (index > 0)
              strUnidades = strUnidades.concat(', ' + nombre_unidad);

            else
              strUnidades = strUnidades.concat(nombre_unidad);

          });
        }
        $('#select_unidad').val(strUnidades);
      }
    });
}

function agregarUnidadDestinoSelect() {
  unidades_gestion_destino = [];
  unidades_gestion_destino.push( $('#select_unidad_select').val() );
}

function obtenerUnidadadDestinoEjec() {

  $('#select_unidad_select').val('').trigger('change').attr('disabled', true);

  switch( $('#lugarInternamiento').val() ) {

    case '00020005':
    case '00020001':
      $('#select_unidad_select').val(35).trigger('change'); //Unidad de Gestión Judicial de Ejecución de Sanciones Penales 2 (Norte)
      break;
    case '00020006':
    case '00020008':
    case '00020002':
    case '00020003':
      $('#select_unidad_select').val(37).trigger('change'); //Unidad de Gestión Judicial de Ejecución de Sanciones Penales 3 (Oriente)
      break;         
    case '00020010':
    case '00020009':
    case '00020014':
    case '00020004':
    case '00020011':
    case '00020012':
    case '00020013':
    case '00020007':
      $('#select_unidad_select').val('').trigger('change').removeAttr('disabled');
      break;  

  }

  $('#select_unidad_select').val('').trigger('change').removeAttr('disabled');

}