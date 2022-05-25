function internoRecl(myRadio) {
                
  var selectedValue = myRadio.value;

  if (selectedValue==="no") {
    
    $('#reclusorioInternamiento').attr('disabled',true);
    $('#reclusorioInternamiento').val('').select2({minimumResultsForSearch: ''});
    $("#reclusorioInternamiento").parent().find('.tx-danger').addClass('d-none');
    
  } else if (selectedValue==="si"){
    
    $('#reclusorioInternamiento').removeAttr('disabled');
    $("#reclusorioInternamiento").parent().find('.tx-danger').removeClass('d-none');
  }

}

function validaRemTriEnj(){

  $('.error').removeClass('error');

  let strImputados='';

  if($('input:radio[name=privado_libertad]:checked').val() == undefined){
    error('Datos Incompletos', 'No ha indicado si el imputado se encuentra privado de su libertad', 'modalRemision'); 
    $('#privadoLibertadDiv').addClass('error');
    return 0;
  }

  if($('input:radio[name=privado_libertad]:checked').val() == 'si'){
    if($('#reclusorioInternamiento').val()=='' || $('#reclusorioInternamiento').val() == null){
      error('Datos Incompletos', 'No ha seleccionado el reclusorio de internamiento', 'modalRemision');
      $('span[aria-labelledby="select2-reclusorioInternamiento-container"]').addClass('error');
      return 0;
    }
  }

  if( documento_remision.length < 1 ){
    error('Datos Incompletos', 'No ha agregado su documento PDF', 'modalRemision');
    return 0;
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

  form=new FormData($("#formRemision")[0]);
  tamanio_archivo=$('#archivoPDF2')[0].files[0].size;

  form.append('carpeta', carpeta_remitir.id_carpeta_judicial);
  form.append('tamanio_archivo', tamanio_archivo);
  form.append('personas_remitidas', strImputados);
  form.append('unidad_carpeta',carpeta_remitir.id_unidad);
  form.append('dataDoc', JSON.stringify(documento_remision));
  form.append('id_audiencia_TE', $('#fechaAudienciaTE').val());
  form.append('fecha_audiencia_TE', $('#fechaAudienciaTE option:selected').attr('data-fecha'));
  form.append('juez_audiencia_TE', $('#fechaAudienciaTE option:selected').attr('data-cvj'));

  return 100;
}