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
