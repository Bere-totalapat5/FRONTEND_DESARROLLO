let tipo_unidad = [],
  unidades_gestion_destino = [],
  documento_remision = [];

async function motivoIncompretencia(){
  
  $('#motivoIncompetenciaOtro').val('').attr('readonly', true);
  $(".materia_destino").removeAttr('readonly').parent().parent().parent().find('.tx-danger').removeClass('d-none');
  // $('#tipoUnidadDestino').attr('readonly',true).val('').select2({minimumResultsForSearch: Infinity}).parent().find('.tx-danger');
  $('#edificioReceptor').val('').attr('disabled',true).select2({minimumResultsForSearch: Infinity}).parent().find('.tx-danger').addClass('d-none');
  $("input[name=materia_destino]").prop("checked", false).removeAttr('disabled');
  $('#unidad_destino_input').removeClass('d-none');
  $('#unidad_destino_select').addClass('d-none');


  switch($('#motivoIncompetencia').val()){
    
    case "otra_materia":
      
      if( carpeta_remitir.materia_destino == !'adultos' ) {
        $("input[name=materia_destino][value='adultos']").prop("checked", true);
      } else {
        $("input[name=materia_destino][value='adolescentes']").prop("checked", true) 
        $('#edificioReceptor').val('4').trigger('change').attr('disabled', true);
      }

      $("input[name=materia_destino]:not(:checked)").attr('disabled', true);
      $('#tipoUnidadDestino').val('').trigger('change').attr('disabled', true);
      tipo_unidad = ['D'];

      obtenerUnidadDestino();
      break;
    case "vinculacion_proceso":
      $('#tipoUnidadDestino').removeAttr('disabled').parent().find('.tx-danger');
      $("input[name=materia_destino][value='adultos']").prop("checked", true);
      $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
      tipo_unidad = ["A","B","M","D"];
      if( $('#fiscalia').val() != null && $('#tipoUnidadDestino').val() == "B" )
        await obtenerInmuebleFiscalia();

      obtenerUnidadDestino();

      break;
    case "violencia_genero":
      $("input[name=materia_destino][value='adultos']").prop("checked", true);
      $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
      $(".materia_destino").attr('disabled', true).parent().parent().parent().find('.tx-danger').addClass('d-none');
      $('#edificioReceptor').val('').attr('disabled',true).trigger('change').parent().find('.tx-danger').addClass('d-none');
      $('#tipoUnidadDestino').val('').attr('disabled',true).trigger('change').parent().find('.tx-danger').addClass('d-none');
      $('#unidad_destino_input').addClass('d-none');
      $('#unidad_destino_select').removeClass('d-none');
      break;
    case "mandato_zona":
      $(".materia_destino").attr('disabled', true).parent().parent().parent().find('.tx-danger').addClass('d-none');
      $('#tipoUnidadDestino').val('').attr('disabled',true).trigger('change').parent().find('.tx-danger').addClass('d-none');
      $('#edificioReceptor').val('').removeAttr('disabled');
      $("input[name=materia_destino][value='adultos']").prop("checked", true);
      $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
      tipo_unidad = ["A","B","M"];
      obtenerUnidadDestino();
      break;
    case "otro": 
      $('#motivoIncompetenciaOtro').removeAttr('readonly');
      $("input[name=materia_destino][value='adultos']").prop("checked", true);
      $("input[name=materia_destino][value='adolescentes']").attr('disabled', true);
      $('#tipoUnidadDestino').removeAttr('disabled').parent().find('.tx-danger');
      break;
    case "privado_libertad":
      $('#lugarInternamiento').removeAttr('disabled');
      $('#privadoLibertadDiv').addClass('d-none');
      break;
    case "imputado_libertad":
      $('#lugarInternamiento').val('').attr('disabled', true);
      $('#privadoLibertadDiv').parent().parent().addClass('d-none');
      $('input[name=privado_libertad]').prop('checked', false);
      $('#edificioReceptor').val('4').trigger('change');
      break;
    case "mandato_judicial":
      $('#privadoLibertadDiv').parent().parent().removeClass('d-none');
      $('input[name=privado_libertad]').prop('checked', false);
      $('#lugarInternamiento').removeAttr('disabled');
      

    default:
      obtenerUnidadDestino();
  }

}

function lugarInternamientoInc() {

  const abierto = ['00020010', '00020009', '00020014', '00020011', '00020012', '00020013', '00020007'],
    norte = ['00020005', '00020001'],
    oriente = ['00020006', '00020002'],
    sur = ['00020003', '00020008', '00020004'];

  if( abierto.includes($('#lugarInternamiento').val()) ) $('#edificioReceptor').val('-1').trigger('change').removeAttr('disabled');
  else if( norte.includes($('#lugarInternamiento').val()) ) $('#edificioReceptor').val('1').trigger('change').attr('disabled', true);
  else if( oriente.includes($('#lugarInternamiento').val()) ) $('#edificioReceptor').val('2').trigger('change').attr('disabled', true);
  else if( sur.includes($('#lugarInternamiento').val()) ) $('#edificioReceptor').val('3').trigger('change').attr('disabled', true);
  else $('#edificioReceptor').val('4').trigger('change').attr('disabled', true);
  
}

function privadoLib(option) {
  if( $(option).val() == 'si' ) {
    $('#lugarInternamiento').removeAttr('disabled');
      if ( $('#motivoIncompetencia').val() == 'mandato_judicial' )
        $('#edificioReceptor').removeAttr('disabled');
  } else {
    $('#lugarInternamiento').val('').trigger('change').attr('disabled', true);
  }  
}

function obtenerUnidadDestino(){
  
  unidades_gestion_destino = [];

  if( $('#motivoIncompetencia').val() == 'privado_libertad' ){

  
  
    switch( $('#edificioReceptor').val() ) {
      case '-1':
        unidades_gestion_destino = [];
        break;
      case '1': //
        unidades_gestion_destino = [19,32];
        break;
      case '2': //
        unidades_gestion_destino = [13, 17, 31];
        break;
      case '3': //
        unidades_gestion_destino = [18];
        break;
      case '4': //
        unidades_gestion_destino = [33];
        break
      default:
        alert('Error en la selección de edificio');

      return true;
    }
  }else{
    $('#select_unidad').val('Cargando . . .');
    $.ajax({
      method:'POST',
      url:'/public/obtener_unidad_destino_remision',
      data:{
        tipo_unidad,
        edificio_receptor:$('#edificioReceptor').val(),
      },
      success:function(response){
        let strUnidades='';
        console.log(response);
        if( response.status == 100 ){
          $(response.response).each(function(index, unidad){
            
            const {nombre_unidad, id_unidad_gestion} = unidad;
            unidades_gestion_destino.push(id_unidad_gestion);

            if(index > 0)
              strUnidades=strUnidades.concat(', '+nombre_unidad);
            else
              strUnidades=strUnidades.concat(nombre_unidad);
            
          });
        }
        $('#select_unidad').val(strUnidades);
      }
    });
  }
}

function validaRemInc(){
  $('.error').removeClass('error');

  let strImputados='';

  

  // if($('#tipoUnidadDestino').val()=='' || $('#tipoUnidadDestino').val() == null){
  //   error('Datos Incompletos', 'No ha seleccionado el tipo de unidad destino', 'modalRemision');
  //   $('span[aria-labelledby="select2-tipoUnidadDestino-container"]').addClass('error');
  //   return 0;
  // }

  
  if( !$('#modalRemision').find('.toggle-on').hasClass('active') ) {
    
    if($('#motivoIncompetencia').val() == 'mandato_zona'){

      if($('#edificioReceptor').val()=='' || $('#edificioReceptor').val()==null){

        error('Datos Incompletos', 'No ha seleccionado el edificio receptor', 'modalRemision');
        $('span[aria-labelledby="select2-edificioReceptor-container"]').addClass('error');
        return 0;
      }
    }

    if($('#motivoIncompetencia').val()=='' || $('#motivoIncompetencia').val()==null){
      error('Datos Incompletos', 'No ha seleccionado el motivo de incompetencia', 'modalRemision');
      $('span[aria-labelledby="select2-motivoIncompetencia-container"]').addClass('error');
      return 0;
    }
  
    if($('#motivoIncompetencia').val()=='otro'){
      if(expVacio.test($('#motivoIncompetenciaOtro').val())){
        error('Datos Incompletos', 'Indique el motivo de la incompetencia (otro)', 'modalRemision');
        $('#motivoIncompetenciaOtro').addClass('error');
        return 0;
      }
    }
  
    if($('#motivoIncompetencia').val() == 'otra_materia' || $('#motivoIncompetencia').val() == 'vinculacion_proceso' || $('#motivoIncompetencia').val() == 'otro'){
      if( $('input:radio[name=materia_destino]:checked').val() == undefined ){
        error('Datos Incompletos', 'No ha seleccionado la materia destino', 'modalRemision');
        $('#divMateriaDestino').addClass('error');
        return 0;
      }
    }
  
    if( ($('#fiscalia').val()=='' || $('#fiscalia').val()==null) && carpeta_remitir.folio_carpeta.substring(0,2) != "TE" && carpeta_remitir.folio_carpeta.substring(0,4) != "EJEC"){
      error('Datos Incompletos', 'No ha seleccionado la fiscalia', 'modalRemision');
      $('span[aria-labelledby="select2-fiscalia-container"]').addClass('error');
      return 0;
    }

    if( $('input:radio[name=privado_libertad]:checked').val() == undefined && !['imputado_privado_libertad_ejec','imputado_libertad_ejec'].includes( $('#motivoIncompetencia').val() ) ) {

      error('Datos Incompletos', 'No ha indicado si el imputado se encuentra privado de su libertad', 'modalRemision'); 
      $('#privadoLibertadDiv').addClass('error');
      return 0;

    }
  
    if($('input:radio[name=privado_libertad]:checked').val() == 'si'){
      if($('#lugarInternamiento').val()=='' || $('#lugarInternamiento').val() == null){
        error('Datos Incompletos', 'No ha seleccionado el lugar de internamiento', 'modalRemision');
        $('span[aria-labelledby="select2-lugarInternamiento-container"]').addClass('error');
        return 0;
      }
    }

    if(!($('input[name=imputados_sel]:checked').length)){
      error('Datos Incompletos', 'No ha seleccionado a ningún imputado', 'modalRemision');
      return 0;
    }else{
      let i=0;
      $('input[name=imputados_sel]:checked').each(function(){
        if(i==0){
          strImputados=strImputados.concat($(this).val());
        }else{
          strImputados=strImputados.concat(','+$(this).val());
        }
        i++;
      });
    }

  }

  if( documento_remision.length < 1 ){
    error('Datos Incompletos', 'No ha agregado su documento PDF', 'modalRemision');
    return 0;
  }
  
  
  form=new FormData($("#formRemision")[0]);
  tamanio_archivo=$('#archivoPDF2')[0].files[0].size;

  if( $('#motivoIncompetencia').val() != 'mandato_zona' && carpeta_remitir.folio_carpeta.substring(0,4) != "EJEC" ){
    form.append('edificio_receptor', $('#edificioReceptor').val());
  }
  
  form.append('carpeta', carpeta_remitir.id_carpeta_judicial);
  form.append('tamanio_archivo', tamanio_archivo);
  form.append('personas_remitidas', strImputados);
  form.append('unidad_carpeta',carpeta_remitir.id_unidad);
  form.append('dataDoc', JSON.stringify(documento_remision));

  if( $('#modalRemision').find('.regresar_remi').find('.toggle-on').hasClass('active') )
    form.append('regresar_remision','si');


  let unidades = '';
  $(unidades_gestion_destino).each(function( i , id ) {
    if( i > 0 ) unidades += ','+id;
    else unidades += id;
  });

  if( ( $('#motivoIncompetencia').val() == 'violencia_genero' || unidades_gestion_destino.length < 1 ) && !$('#modalRemision').find('.toggle-on').hasClass('active') ) {
    if( $('#select_unidad_select').val() == null ) {
      error('Datos Incompletos', 'No ha seleccionado la unidad destino', 'modalRemision');
      $('span[aria-labelledby="select2-select_unidad_select-container"]').addClass('error');
      return 0;
    }else{
      form.append('unidades', $('#select_unidad_select').val());
    }

  }else {
    form.append('unidades', unidades);
  }

  

  return 100;
  
}

function motivoIncompretenciaEjec() {

  $('#lugarInternamiento').val('').trigger('change').attr('readondisabledly', true);
  // $('#select_unidad_select').val('').trigger('change').attr('disabled', true);
  $('#divImputadoLibertad').addClass('d-none');
  $('input[name=privado_libertad]').prop('checked', false);
  $('#motivoIncompetenciaOtro').val('').attr('readonly', true);;

  switch( $('#motivoIncompetencia').val() ) {

    case 'imputado_privado_libertad_ejec':
      $('#lugarInternamiento').removeAttr('disabled');
      break;
    case 'imputado_libertad_ejec':
      $('#lugarInternamiento').val('').trigger('change').attr('disabled', true);
      $('#select_unidad_select').val(20).trigger('change');
      break;
    case 'mandato_judicial_ejec':
      $('#divImputadoLibertad').removeClass('d-none');
      break;
    case 'otro':
      $('#divImputadoLibertad').removeClass('d-none');
      $('#motivoIncompetenciaOtro').removeAttr('readonly');
      break;
    default:
      alert('Opción inválida');

  }
  
  $('#select_unidad_select').val('').trigger('change').removeAttr('disabled');

}

function privadoLibEjec(option) {
  if( $(option).val() == 'si' ) {

    $('#select_unidad_select').val('').trigger('change');// .attr('disabled');
    $('#lugarInternamiento').val('').trigger('change').removeAttr('disabled');

  } else {

    $('#lugarInternamiento').val('').trigger('change').attr('disabled', true);
    $('#select_unidad_select').val('').trigger('change'); //.removeAttr('disabled');

  }
    
  $('#select_unidad_select').val('').trigger('change').removeAttr('disabled');
}

$('#modalRemision').on('click', '.regresar_remi .toggle-wrapper', function( ) {

  if( $(this).find('.toggle-on').hasClass('active') ) 
    $('.d-none-rm').addClass('d-none');
  else
    $('.d-none-rm').removeClass('d-none');

});

