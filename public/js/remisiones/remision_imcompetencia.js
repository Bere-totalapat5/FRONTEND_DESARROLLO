function motivoIncompretencia(){
        
  $('#motivoIncompetenciaOtro').val('').attr('readonly', true);
  $(".materia_destino").removeAttr('readonly').parent().parent().parent().find('.tx-danger').removeClass('d-none');
  $('#tipoUnidadDestino').attr('readonly',true).val('').select2({minimumResultsForSearch: Infinity}).parent().find('.tx-danger');
  $('#edificioReceptor').val('').attr('disabled',true).select2({minimumResultsForSearch: Infinity}).parent().find('.tx-danger').addClass('d-none');
  $("input[name=materia_destino]").prop("checked", false).removeAttr('disabled');


  switch($('#motivoIncompetencia').val()){
    case "otra_materia":
      $('#edificioReceptor').val('4').select2({minimumResultsForSearch: Infinity}).attr('disabled', true);
      break;
    case "vinculacion_proceso":
      $('#tipoUnidadDestino').removeAttr('disabled').parent().find('.tx-danger');
      $("input[name=materia_destino][value='adultos']").prop("checked", true);
      $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
      break;
    case "violencia_genero":
      $("input[name=materia_destino][value='adultos']").prop("checked", true);
      $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
      $(".materia_destino").attr('disabled', true).parent().parent().parent().find('.tx-danger').addClass('d-none');
      $('#edificioReceptor').val('').attr('disabled',true).trigger('change').parent().find('.tx-danger').addClass('d-none');
      $('#tipoUnidadDestino').val('').attr('disabled',true).trigger('change').parent().find('.tx-danger').addClass('d-none');
      break;
    case "mandato_zona":
      $(".materia_destino").attr('disabled', true).parent().parent().parent().find('.tx-danger').addClass('d-none');
      $('#tipoUnidadDestino').removeAttr('disabled').parent().find('.tx-danger');
      $('#edificioReceptor').val('').attr('disabled',true).trigger('change').parent().find('.tx-danger').addClass('d-none');
      $("input[name=materia_destino][value='adultos']").prop("checked", true);
      $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
      break;
    case "otro": 
      $('#motivoIncompetenciaOtro').removeAttr('readonly');
      $("input[name=materia_destino][value='adultos']").prop("checked", true);
      $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
      break;
    default:
      alert("Opción inválida");
  }
  
}

function obtenerUnidadDestino(){
  $('#edificioReceptor').val('4').attr('disabled', true).trigger('change');
  
  if( $('#motivoIncompetencia').val() != 'mandato_zona' ){
    switch ($('#tipoUnidadDestino').val()){
      case 'u12':
      case 'querella':
        $('#edificioReceptor').val('5').trigger('change');
        break;
      case 'oficioso':
        $('#edificioReceptor').val('8').trigger('change');
        break;
      case 'mujeres':
        $('#edificioReceptor').val('10').trigger('change');
        break;
      default:
      $('#edificioReceptor').val('').trigger('change');
    }
  }

  $.ajax({
    method:'POST',
    url:'/public/obtener_unidad_destino_remision',
    data:{
      tipo_unidad:$('#tipoUnidadDestino').val(),
      fiscalia:$('#fiscalia').val(),
    },
    success:function(response){
      let strUnidades='';
      if(response.status==100){
        strUnidadesDestino=response.response.unidades;
        $(response.response.unidades_data).each(function(index, unidad){
          const {nombre_unidad} = unidad;
          
          if(index > 0){
            strUnidades=strUnidades.concat(', '+nombre_unidad);
          }else{
            strUnidades=strUnidades.concat(nombre_unidad);
          }

        });
      }
      $('#select_unidad').val(strUnidades);
    }
  });
}