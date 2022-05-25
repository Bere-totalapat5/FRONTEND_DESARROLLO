async function remisionPreventiva() {
 
  const data_carpeta = await new Carpeta( carpeta_remitir.id_carpeta_judicial, carpeta_remitir );

  let imputados_carpeta = '',
    fechasAudiencias = '';

  const personas = await data_carpeta.obtenerPersonas( 'no' );
 
  if( personas.status == 100 ) {

    const imputados =  data_carpeta.filtrarPersonasCalJud( personas.response.personas, [46]);
    let reclusorios_options = '';

    $.each( reclusorios, function( i , reclusorio) {
      if( [33].includes(unidadId)  ) {
        if( [17, 18, 19, 20, 21, 22].includes(reclusorio.id_reclusorio) )
          reclusorios_options += `<option value="${reclusorio.id_reclusorio}">${reclusorio.nombre}</option>`;
      } else {
        if( ![17, 18, 19, 20, 21, 22].includes(reclusorio.id_reclusorio) )
          reclusorios_options += `<option value="${reclusorio.id_reclusorio}">${reclusorio.nombre}</option>`;
      }
    });


    $( imputados ).each( function( ip, imputado ) {
      
      const { nombre, apellido_paterno, apellido_materno, razon_social, tipo_persona, id_persona } = imputado.info_principal;
      
      imputados_carpeta += ` 
        <div class="row" style="background-color: #FBFBFB; border: 1px solid #c3c2c2; border-radius: 20px; padding: 10px 5px 5px 5px; margin-bottom: 0.5em;">
          <div class="col-md-6" style="margin-top: auto;margin-bottom: auto;">
            <label class="ckbox">
              <input type="checkbox" value="${id_persona}" data-tipo="${tipo_persona}" name="imputados_sel" onclick="imputadoSeleccionado(this)"><span>${razon_social ?? ''}${nombre ?? ''} ${apellido_paterno ?? ''} ${apellido_materno ?? ''}</span>
            </label>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-control-label">Lugar de internamiento: <span class="tx-danger d-none">*</span></label>
              <select class="form-control lugar_internamiento" id="internamiento-${id_persona}" name="lugar_internamiento" autocomplete="off" disabled>
                <option selected value="" disabled>Seleccione una opción</option>
                ${reclusorios_options}
              </select>
            </div>
          </div>
        </div>
      `;

    });
  } else {
    imputados_carpeta += '<div class="col-12"><h5 class="tx-danger">Carpeta sin imputados activos</h5></div>';
  }


  const { id_carpeta_judicial } = carpeta_remitir;
  fechasAudiencias = await obtenerFechasAudSent( id_carpeta_judicial );

  $("#formularioRemision").html('<div class="d-flex ht-300 pos-relative align-items-center"><div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div><div class="sk-cube2 sk-cube"></div><div class="sk-cube4 sk-cube"></div><div class="sk-cube3 sk-cube"></div></div></div><!-- d-flex -->');
  formularioRemision  = `
    <div class="row mg-b-15 pd-10">
      <div class="col-12">
        <div  class="slim-pagetitle mg-t-20  mg-b-20">
          <h6 class="mg-b-0">Datos Generales:</h6>  
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label" >Carpeta Judicial a Remitir:</label>
          <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${carpeta_remitir.folio_carpeta}" placeholder="N/E" autocomplete="off" disabled="">
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label" >Juez que impuso la prisión preventiva:</label>
          <input class="form-control" type="text" name="juez_vinculacion" id="juezVinculacion" value="" placeholder="N/E" autocomplete="off" disabled="">
        </div>
      </div>
    </div>
    <div class="row pd-10">
      <div class="col-lg-8">
        <div class="form-group">
          <label class="form-control-label">Audiencia en que se impuso la prisión preventiva</label>
          <select class="form-control" id="fechaAudiencia" name="LN_id_audiencia" autocomplete="off" onchange="indicaJuezAudienciaPreventiva()">
            <option selected value="">Seleccione una opción</option>
            ${fechasAudiencias}
          </select>
        </div>
      </div>
      <div class="col-lg-4" style="padding: 0 4em;">
        <div class="form-group mg-b-10-force vinculacion_proceso">
          <label class="form-control-label d-block">Se vincula a proceso:</label>
          <div class="toggle-wrapper" style="position: absolute; margin-left: 20px;">
            <div class="toggle toggle-light primary"></div>
          </div>
        </div>
      </div>
      
    </div>    
    <div class="row mg-b-15  pd-10">
      <div class="col-lg-12">
        <div class="form-group">
          <label class="form-control-label">Comentarios Adicionales</label>
          <th colspan="100%">
            <textarea id="comentariosAdicionales" rows="2"  ></textarea>
          </th>
        </div>
      </div>
      <div class="col-12">
        <div  class="slim-pagetitle mg-t-20  mg-b-20">
          <h6 class="mg-b-0">Seleccione los imputados que serán remitidos a prisión preventiva:  <span class="tx-danger">*</span></h6>  
        </div>
        <div class="pd-20"> 
          ${imputados_carpeta}
        </div>
      </div>
    </div>
    <div class="row mg-b-15 pd-10">
      <div class="col-12">
        <div  class="slim-pagetitle mg-t-20  mg-b-20">
          <h6 class="mg-b-0">Documentos:</h6>  
        </div>
      </div>
      <div class="col-12">
        <div class="custom-input-file mg-t-30">
          <input type="file" id="archivoPDF2" class="input-file" name="documento_adjunto" accept="application/pdf" onchange="leeDocumento(this, '.pdf,.PDF', 'tribunal_enjuiciamiento')">
          <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
        </div>
      </div>
      <div id="divDocumento" style="width:100%" class="col-12">
        <object data=""  id="documentoPDF" width="100%" height="350px" class=" mg-t-25"></object>
        <input type="hidden" id="bDoc" name="bDoc">
      </div>
    </div>
  `;
  $("#labelTipoRemision").html("REMISIÓN DE CARPETA POR PRISIÓN PREVENTIVA");

  
  $("#formularioRemision").html(formularioRemision);
  $('#reclusorioInternamiento').select2({minimumResultsForSearch: ''});
  $('#fechaAudiencia').select2( { minimumResultsForSearch: Infinity } );
  $('#btnSiguiente').removeAttr('disabled').attr('onclick', 'enviarRemision()');
  $('.lugar_internamiento').select2({minimumResultsForSearch: ''});
  setTimeout( () => { $('.toggle').toggles({ on: false, height: 26 }); },100);

}

function indicaJuezAudienciaPreventiva() {
  $('#juezVinculacion').val( $('#fechaAudiencia option:selected').attr('data-juez') );
}

function indicaJuezAudiencia() {
   $('#juezVinculacion').val( $('#fechaAudienciaTE option:selected').attr('data-juez') );
}

function validaRemPreventiva() {

  $('.error').removeClass('error');

  if( $('#fechaAudiencia').val() == '' || $('#fechaAudiencia').val() == null ) {
    error('Datos Incompletos', 'No ha indicado la audiencia en que se impuso la prisión preventiva', 'modalRemision');
    $('#select2-fechaAudiencia-container').addClass('error');
    return 0;
  }

  if( documento_remision.length < 1 ){
    error('Datos Incompletos', 'No ha agregado su documento PDF', 'modalRemision');
    return 0;
  }
  
  let strImputados = '';

  if(!($('input[name=imputados_sel]:checked').length)){
    error('Datos Incompletos', 'No ha seleccionado a ningún imputado', 'modalRemision');
    return 0;
  }else{
    $('input[name=imputados_sel]:checked').each(function( i ){
      if( i == 0 ) strImputados += $(this).val();
      else strImputados += ','+$(this).val();

      if( $('#internamiento-'+$(this).val()).val() == null || $('#internamiento-'+$(this).val()).val() == '' ) {
        error('Datos Incompletos', 'Indique el lugar de internamiento del imputado', 'modalRemision');
        $('select2-internamiento-'+$(this).val()+'-container').addClass('error').focus();
        return 0;
      }

      strImputados += ','+$('#internamiento-'+$(this).val()).val();

    });
  }


  form=new FormData($("#formRemision")[0]);
  tamanio_archivo=$('#archivoPDF2')[0].files[0].size;

  form.append('carpeta', carpeta_remitir.id_carpeta_judicial);
  form.append('tamanio_archivo', tamanio_archivo);
  form.append('personas_remitidas', strImputados);
  form.append('unidad_carpeta', carpeta_remitir.id_unidad);
  form.append('dataDoc', JSON.stringify(documento_remision));
  form.append('LN_fecha_audiencia', $('#fechaAudiencia option:selected').attr('data-fecha'));
  form.append('LN_id_juez_audiencia', $('#fechaAudiencia option:selected').attr('data-cvj'));
  form.append('LN_nom_juez_audiencia', $('#fechaAudiencia option:selected').attr('data-juez'));
  if( $('#modalRemision').find('.vinculacion_proceso').find('.toggle-on').hasClass('active')) form.append('LN_vinculacion_proceso', 'si');
  else form.append('LN_vinculacion_proceso', 'no');

  return 100;

}

function imputadoSeleccionado( element ) {

  if( $(element).is(':checked') ) 
    $('#internamiento-'+$(element).val()).removeAttr('disabled')
  else 
    $('#internamiento-'+$(element).val()).attr('disabled', true).val('').trigger('change');
  

}