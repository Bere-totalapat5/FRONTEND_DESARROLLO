let 
  delitos = [],
  penas = [],
  abonos = [],
  sustitutivos = [],
  sentenciados = [],
  defensores = [],
  victimas = [],
  asesores = [],
  ministerios_publico = [],
  informacion_complementaria = [],
  audiencias_dvd = [],
  billetes_remision = [],
  objetos_remision = [],
  adjuntos_remision = [],
  sentenciado_edit = '-',
  pena_edit = '-',
  delito_edit = '-',
  abono_edit = '-',
  sustitutivo_edit = '-',
  defensor_edit = '-',
  victima_edit = '-',
  asesor_edit = '-',
  ministerio_publico_edit = '-',
  remision_in,
  b_cargando = 0,
  secciones_completadas = [];
  
const 
  penas_detalle_pena = [7,6,12,13,30],
  periodos = [1,2,3,7],
  prision = [1],
  decomisos = [10],
  abonoPrision = [1,47,2,7,3],
  sustitutivoPena = [1,6],
  arr_sustitutivos = [1,2],
  tipo_defensor = [4,29,43,52],
  tipo_imputado = [46],
  tipo_victima = [2,13,60,61,62],
  tipo_aseseor_juridico = [47],
  tipo_ministerio_publico = [10001];
  
// SENTENCIADOS
function nuevoSentenciado(){
  sentenciado_edit = '-',
  penas = [];
  abonos = [];
  sustitutivos = [];
  delitos = [];
  $('#imputados').val('').trigger('change');
  $('.sentenciado_libertad').prop('checked', false);
  sentenciadoLibertad();
  suspensionCondicionalPena('no');
  $('.suspension_ejecucion').prop('checked', false);
  $('#centroDetencion').val('').trigger('change');
  $('#modalRemision').modal('hide');
  abreModal('modalSentenciado',400)
  showPenas();
}

async function agregarSentenciado(){
  $('#modalSentenciado').modal('hide');
  $('.error').removeClass('error');

  if($('#imputados').val()=='' || $('#imputados').val()==null){
    error('Datos Incompletos', 'No ha seleccionado un sentenciado', 'modalSentenciado');
    $('span[aria-labelledby="select2-imputados-container"]').addClass('error');
    return 0;
  }

  if( $('input[name="sentenciado_libertad"]:checked').val() == undefined ){
    error('Datos Incompletos', 'No ha indicado el estado de la libertad del sentenciado', 'modalSentenciado');
    return 0;
  }

  if( $('input[name="sentenciado_libertad"]:checked').val() == 'no' ){
    if( $('#centroDetencion').val() == ''  || $('#centroDetencion').val() == null ){
      error('Datos Incompletos', 'Debe indicar el centro de detención', 'modalSentenciado');
      $('#centroDetencion').addClass('error');
      return 0;
    }
  }
  
  if( penas.length == 0 || penas.find( pena => pena.estatus == 1 ) == undefined ){
    error('Datos Incompletos', 'No ha agregado ninguna pena', 'modalSentenciado');
    return 0;
  }

  if( $('input[name="suspension_ejecucion"]:checked').val() == undefined ){
    error('Datos Incompletos', 'No ha indicado si de concede la suspención condicional de la ejecución de la pena', 'modalSentenciado');
    return 0;
  }

  let monto_garantia = 0;

  if( $('input[name="suspension_ejecucion"]:checked').val() == 'si' ) {

    if( !penas.some( pena => pena.suspension_condicional == 1) ) {
      error('Datos Incompletos', 'No ha indicado ningúna pena a la que se concede la suspención condicional de la ejecución', 'modalSentenciado');
      return 0;
    }

    if( expVacio.test( $('#montoGarantia').val().replace( '$','' ) ) ){
      $('#montoBillete').addClass('error');
      return false;
    }

    monto_garantia = $('#montoGarantia').val();

  }
  

  const sentenciado = {
    estatus:'1',
    sentenciado:$('#imputados').val(),
    sentenciado_desc:$('#imputados option:selected').text(),
    tipo:$('#imputados option:selected').attr('data-tipo'),
    sentenciado_libertad:$('input[name="sentenciado_libertad"]:checked').val(),
    centro_detencion:$('#centroDetencion').val()==null?'-':$('#centroDetencion').val(),
    suspension_ejecucion:$('input[name="suspension_ejecucion"]:checked').val(),
    monto_garantia,
    penas
  }

  if( sentenciado_edit != '-' ){
    sentenciado.id =  sentenciado_edit.id;
    sentenciados[sentenciado_edit.index] = sentenciado;
  }else{
    sentenciado.id =  '-';
    sentenciados.push(sentenciado);
  }
  
  $('#sentenciados .square-8 ').remove();
  $('#sentenciados').append('<span class="square-8 bg-danger mg-r-5 mg-l-5 rounded-circle"></span>');
  sentenciado_edit = '-';
  penas = [];
  abonos = [];
  sustitutivos = [];
  delitos = [];
  showSentenciados();
  abreModal('modalRemision',300);
}

// DOCUMENTOS

function abrirDocumento( documento ) {
  
  const { url, nombre_archivo } = informacion_complementaria.documentos_remision_ue[documento];
  $('#nombreDocumento').html( `${nombre_archivo}` );
  $('#objectDocumento').html(`<object type="application/pdf" data="${url}" style="height: 80vh; width: 100%;"></object>`);
  $('#modalRemision').modal('hide');
  abreModal('modalDocumento',400);

}

function abrirAdjunto( adjunto ) {
  
  const { url, nombre_archivo } = adjuntos_remision[adjunto];
  $('#nombreDocumento').html( `${nombre_archivo}` );
  $('#objectDocumento').html(`<object type="application/pdf" data="${url}" style="height: 80vh; width: 100%;"></object>`);
  $('#modalRemision').modal('hide');
  abreModal('modalDocumento',400);

}

function eliminarAdjunto( adjunto ){

  if ( adjuntos_remision[adjunto].id == 0 ){

    adjuntos_remision = adjuntos_remision.filter( ( adjunto_remision, index_adjunto_remision ) => {
      if( index_adjunto_remision != adjunto )
        return adjunto_remision;
    });
  
  }else {

    adjuntos_remision = adjuntos_remision.map( ( adjunto_remision, index_adjunto_remision ) => {
      if (index_adjunto_remision == adjunto )
        adjunto_remision.estatus = 0;
      return adjunto_remision;
    });
  }

  showAdjuntos();
}

function showAdjuntos() {
  
  $('#div_documentos_adjuntos').html('');
  if(adjuntos_remision.length && adjuntos_remision.find( adjunto => adjunto.estatus == 1 )){
    $(adjuntos_remision).each(function(index, dataDoc){
      if ( dataDoc.estatus ) {
        $('#div_documentos_adjuntos').append(`
          <div style="padding-top: 13px; text-align: center;" class="col-md-4 mg-t-10">
            <a href="javascript:void(0)" ondblclick="abrirAdjunto('${index}')" class="d-none d-md-inline-flex">
              <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative; color: #C6362D;"></i>
            </a>
            <a href="${dataDoc.url}" class="d-inline-flex d-md-none">
              <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative; color: #C6362D;"></i>
            </a>
            <a href="javascript:void(0)" onclick="eliminarAdjunto('${index}')" class="mg-l-auto" style="position: absolute;">
              <i class="fa fa-times-circle tx-danger btn-cancel" aria-hidden="true" style="font-size:1rem;padding-top:4px;position: relative;top: -13px;"></i>
            </a>
            <label style="margin-top:0.65rem" class="d-block" ondblclick="cambiaNombreAdjunto(${index})" id="labelNomAd${index}">
              ${dataDoc.nombre_archivo}
            </label>  
            <input style="margin-top:0.65rem" id="inputNomAd${index}" class="d-none" value="${dataDoc.nombre_archivo.split('.')[0]}" onblur="actualizaNombreAdjunto(${index})">
          </div>`
        );
      }
    })
  }
}

function cambiaNombreAdjunto( index ) {
  $('#labelNomAd'+index).removeClass('d-block').addClass('d-none');
  $('#inputNomAd'+index).removeClass('d-none');
}

function actualizaNombreAdjunto( index ) {
  $('#labelNomAd'+index).addClass('d-block').removeClass('d-none');
  $('#inputNomAd'+index).addClass('d-none');

  adjuntos_remision[index].nombre_archivo = normalize($('#inputNomAd'+index).val()) + adjuntos_remision[index].extension_archivo;

  //console.log(adjuntos_remision);
  showAdjuntos()
}
// GENERALES 

function validaRemUniEjec(){
  const etapa = $('#etapas').find('.active').attr('etapa');
  $('.error').removeClass('error');
  // if( etapa == "inicial" ){
    
    if($('#fechaAudienciaSentencia').val() == '' || $('#fechaAudienciaSentencia').val() == null ){
      error('Datos Incompletos', 'No ha indicado la fecha de la audiencia en la cual se dicta sentencia', 'modalRemision');
      $('span[aria-labelledby="select2-fechaAudienciaSentencia-container"]').addClass('error');
      return 0; 
    }
    if(!expRegFecha.test($('#fechaCausaEjecutoria').val())){
      error('Datos Incompletos', 'No ha indicado la fecha a partir de la cual causa ejecutoria', 'modalRemision');
      $('#fechaCausaEjecutoria').addClass('error');
      return 0;
    }
    //console.log(documento_remision);
    form=new FormData($("#formRemision")[0]); 
    form.append('carpeta', carpeta_remitir.id_carpeta_judicial);
    form.append('juez', $('#fechaAudienciaSentencia option:selected').attr('data-cvj'));
    form.append('fecha_audiencia', $('#fechaAudienciaSentencia option:selected').attr('data-fecha'));
    form.append('seccion', 'inicial');
    form.append('remision_in', remision_in);
    form.append('remision', carpeta_remitir.id_remision);
    form.append('unidad_carpeta', carpeta_remitir.id_unidad);

    if( documento_remision.length )
      form.append('dataDoc', JSON.stringify(documento_remision));
    
    form.append('autorizacion', 'no');

    return 100;
  // }
}

function guardarPersonas(seccion){
  
  let data;
  if( seccion == 'sentenciados' ){
    
    if( sentenciados.length && sentenciados.find( sentenciado => sentenciado.estatus == 1 ) != undefined){
      data = sentenciados;
    }else{
      error('Datos incompletos','No ha agregado a ningún sentenciado','modalRemision');
      return 0;
    }
  }else if( seccion == 'defensores' ){
    
    if( defensores.length && defensores.find( defensor => defensor.estatus == 1 ) != undefined){
      data = defensores;
    }else{
      error('Datos incompletos','No ha agregado a ningún defensor','modalRemision');
      return 0;
    }
  }else if( seccion == 'victimas' ){
    
    if( victimas.length && victimas.find( victima => victima.estatus == 1 ) != undefined){
      data = victimas;
    }else{
      error('Datos incompletos','No ha agregado a ningúna víctima','modalRemision');
      return 0;
    }
  }else if( seccion == 'asesores_juridicos' ){
    
    if( asesores.length && asesores.find( asesor => asesor.estatus == 1 ) != undefined){
      data = asesores;
    }else{
      error('Datos incompletos','No ha agregado a ningún asesor jurídico','modalRemision');
      return 0;
    }
  }else if( seccion == 'ministerio_publico' ){
    
    if( ministerios_publico.length && ministerios_publico.find(  ministerio_publico => ministerio_publico.estatus == 1 ) != undefined){
      data = ministerios_publico;
    }else{
      error('Datos incompletos','No ha agregado a ningún ministerio público','modalRemision');
      return 0;
    }
  }else if( seccion == 'informacion_complementaria' ){
    
    if( validaInformacionComplementaria() ){

      data = informacion_complementaria.documentos_remision_ue;
      data.id = informacion_complementaria.id;
      data.numero_dvds = $('#numeroDVD').val();
      data.audiencias = audiencias_dvd;
      data.billetes = billetes_remision;
      data.objetos_asegurados = objetos_remision;
      
    }else{
      return false;
    }
      
  }else if ( seccion == 'adjuntos' ) {
    if( adjuntos_remision.length && adjuntos_remision.find(  adjunto => adjunto.estatus == 1 ) != undefined){
      data = adjuntos_remision;
    }else{
      error('Datos incompletos','No ha agregado ningún documento adjunto','modalRemision');
      return 0;
    }
  }
  
  form=new FormData($("#formRemision")[0]);
  form.append('data',JSON.stringify(data));
  form.append('seccion',seccion);
  form.append('remision_in',carpeta_remitir.id_remision);
  
  $('#'+seccion+' .square-8 ').remove();
  $('#modalRemision').modal('hide');
  $('#modal_loading').modal('show');

  if( !secciones_completadas.includes(seccion))
    registrarPersonasRemision(seccion);
  else
    actualizarPersonasRemision(seccion);
    
}

function registrarPersonasRemision(seccion){

  $.ajax({
    method:'POST',
    url:'/public/registrar_personas_remision',
    data:form,
    processData: false,
    contentType: false,
    success:function(response){
      if( response.status == 100 ){
        $('#'+seccion).removeClass('tx-danger');
        secciones_completadas.push(seccion);
        abreModal('modalRemision',1000);
        remisionUnidadEjecucion(seccion);
        etapas();
      }else{
        error('Error', response.message , 'modalRemision');
      }
      setTimeout(() => {$('#modal_loading').modal('hide')},600);
    }
  });
}

function actualizarPersonasRemision(seccion){
  
  if( seccion == 'inicial' ) {
    $.ajax({
      method:'POST',
      url:'/public/modificar_remision',
      data:form,
      processData: false,
      contentType: false,
      success:function(response){
        if( response.status == 100 ){
          $('#'+seccion).removeClass('tx-danger');
          abreModal('modalRemision',1000);
          remisionUnidadEjecucion(seccion);
          etapas();
        }else{
          error('Error', response.message , 'modalRemision');
        }
        setTimeout(() => {$('#modal_loading').modal('hide')},600);
      }
    });
  }else {
    $.ajax({
      method:'POST',
      url:'/public/actualizar_personas_remision',
      data:form,
      processData: false,
      contentType: false,
      success:function(response){
        if( response.status == 100 ){
          $('#'+seccion).removeClass('tx-danger');
          abreModal('modalRemision',1000);
          remisionUnidadEjecucion(seccion);
          etapas();
        }else{
          error('Error', response.message , 'modalRemision');
        }
        setTimeout(() => {$('#modal_loading').modal('hide')},600);
      }
    });
  }

  
}

function obtenerPersonasRemisionRUE(remision){
  $.ajax({
    method:'GET',
    url:'/public/obtener_personas_remision',
    data:{remision},
    success: async function(response){
        
      if( secciones_completadas.includes('sentenciados') ){
        $(response.response.sentenciados).each(function(index, sentenciado) {
          const {id_rem_per, estatus, id_persona, nombre, apellido_paterno, apellido_materno, razon_social, tipo_persona, en_libertad, id_unidad_centro_detencion, suspension_condicional, penas, monto_garantia} = sentenciado;

          const penas_sentenciado = [];
          if( penas.length ){
            $(penas).each(async function(index,pena){

              const {id_pena, estatus, id_tipo_pena, id_pena_impuesta,id_sub_pena_impuesta, periodo_anios, periodo_meses, periodo_dias, decomiso_instrumento, decomiso_objetos, decomiso_productos_delito,sustitutivo_pena, id_centro_detencion, detalles_adicionales, delitos, abonos, sustitutivos} = pena;

              const delitos_pena_sentenciado = [];
              if(delitos.length){
                $(delitos).each(function(index, delito){
                  const delito_pena_sentenciado = {
                    id:'1',
                    estatus:'1',
                    delito:delito.delito,
                    id_delito:delito.id_delito
                  }
                  delitos_pena_sentenciado.push(delito_pena_sentenciado);
                });
              }

              const abonos_pena_sentenciado = [];
              if( abonos.length ){
                $(abonos).each(function(index,abono){

                  const {id_abono, estatus, periodo_anios, periodo_meses, periodo_dias, id_centro_detencion, otro} = abono;
                  const centro_detencion_desc = $('#centroDetencionAbono option[value="'+id_centro_detencion+'"]').text();
                  const abono_pena_sentenciado = {
                    id:id_abono,
                    estatus:estatus,
                    anios_abono:periodo_anios,
                    meses_abono:periodo_meses,
                    dias_abono:periodo_dias,
                    centro_detencion:id_centro_detencion,
                    centro_detencion_desc,
                    centro_detencion_otro:otro==null?'':otro,
                  };
                  abonos_pena_sentenciado.push(abono_pena_sentenciado);
                });
              }

              const sustitutivos_pena_setntenciado = [];
             
              if( sustitutivos.length ){
                $(sustitutivos).each(function(index,sustitutivo){

                  const {id_pena_sustitutivo, estatus, id_sustitutivo, monto, acoge_sustitutivo, detalles} = sustitutivo;
                  const sustitutivo_desc = $('#sustitutivo option[value="'+id_sustitutivo+'"]').text();
                  const sustitutivo_pena_sentenciado={
                    id:id_pena_sustitutivo,
                    estatus:estatus,
                    sustitutivo:id_sustitutivo,
                    sustitutivo_desc,
                    monto:monto==null?'':monto,
                    acoge_sustitutivo:acoge_sustitutivo,
                    detalles_adicionales:detalles
                  }
                  sustitutivos_pena_setntenciado.push(sustitutivo_pena_sentenciado);
                });
              }
              pena_impuesta = await obtenerPenas(id_tipo_pena,id_pena_impuesta);
              const pena_sentencido = {
                id:id_pena,
                estatus:estatus,
                tipo_pena:id_tipo_pena,
                tipo_pena_desc:'--',
                pena_impuesta:id_pena_impuesta,
                pena_impuesta_desc:pena_impuesta.pena,
                detalle_pena:id_sub_pena_impuesta,
                detalle_pena_desc:'--',
                periodo_anios:periodo_anios,
                periodo_mese:periodo_meses,
                periodo_dias:periodo_dias,
                decomiso_instrumento:decomiso_instrumento,
                decomiso_objetos:decomiso_objetos,
                decomiso_productos_delito:decomiso_productos_delito,
                centro_detencion_pena:id_centro_detencion,
                centro_detencion_pena_desc:'--',
                detalles_adicionales_pena:detalles_adicionales==null?'':detalles_adicionales,
                sustitutivo_pena:sustitutivo_pena,
                delitos:delitos_pena_sentenciado,
                abonos:abonos_pena_sentenciado,
                sustitutivos:sustitutivos_pena_setntenciado,
                suspension_condicional: pena.suspension_condicional,
              };
              //console.log(pena_impuesta);
            penas_sentenciado.push(pena_sentencido);
            });
          }

          const sentenciado_remision = {
            id:id_rem_per,
            estatus:estatus,
            sentenciado:id_persona,
            sentenciado_desc:`${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}`,
            tipo:tipo_persona,
            sentenciado_libertad:en_libertad,
            centro_detencion:id_unidad_centro_detencion,
            suspension_ejecucion:suspension_condicional,
            penas:penas_sentenciado,
            monto_garantia: monto_garantia
          }
          sentenciados.push(sentenciado_remision);
          
        });
        showSentenciados();
      }

      if( secciones_completadas.includes('defensores') ){
        $(response.response.defensores).each(function(index, defensor){
          const {id_rem_per, id_persona, ids_sentenciados_defendidos,tipo_defensor, nombre, apellido_paterno, apellido_materno, estatus} = defensor;
          const persona_desc = `${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}`;
          const defensor_remision = {
            id : id_rem_per,
            estatus,
            persona : id_persona,
            persona_desc,
            tipo_defensor,
            ids_sentenciados_defendidos
          };
          defensores.push(defensor_remision);
        })
        showDefensores();
      }

      if( secciones_completadas.includes('victimas') ){
        $( response.response.victimas ).each( function( index, victima ) {
          const { id_rem_per,estatus,id_persona, nombre, apellido_paterno, apellido_materno } = victima;
          const desc_victima = `${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}`;
          const victima_remision = {
            id : id_rem_per,
            estatus,
            victima : id_persona,
            desc_victima
          };
          victimas.push(victima_remision);
        });
        showVictimas();
      }

      if( secciones_completadas.includes('asesores_juridicos') ){
        $( response.response.asesores_juridicos ).each( function( index, asesor ) {
          const { id_rem_per, id_persona, nombre, apellido_paterno, apellido_materno, estatus, ids_victimas_asesorados } = asesor;
          const desc_asesor = `${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}`;
          const asesor_remision = {
            id : id_rem_per,
            estatus,
            asesor : id_persona,
            desc_asesor,
            ids_victimas_asesorados
          };
          asesores.push( asesor_remision );
        });
        showAsesores();
      }

      if( secciones_completadas.includes('ministerio_publico') ){
        $( response.response.ministerio_publico ).each( function( index, ministerio ) {
          const { id_rem_per, id_persona, nombre, apellido_paterno, apellido_materno, estatus } = ministerio;
          const ministerio_publico_desc = `${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}`;
          const ministerio_publico_remision = {
            id : id_rem_per,
            estatus,
            ministerio_publico : id_persona,
            ministerio_publico_desc
          };
          ministerios_publico.push( ministerio_publico_remision );
        });
        showMinisterioPublico(); 
      }

      if( secciones_completadas.includes('informacion_complementaria') && response.response.informacion_complementaria.length ){
         
        const { id_remision, numero_dvds, id_info_com, ids_audiencias_remitidas, billetes, objetos } = response.response.informacion_complementaria[0];
        informacion_complementaria.id = id_info_com;
        
        $(ids_audiencias_remitidas.split(',')).each( function( index, audiencia ) {
        
          const fecha = $('#fechaAudienciaDVD option[value='+audiencia+']').text();
        
          const audiencia_dvd = {
            id: audiencia,
            fecha,
            estatus: 1
          };

          audiencias_dvd.push(audiencia_dvd);

        });

        showAudienciasDVD();

        if( billetes.length ){
          $('input[name=billete_remision][value="si"').prop("checked", true);
          billeteRemision();
        }
          

        $(billetes).each( function( index, billete ) {
        
          const { id_billete, numero_billete, monto, estatus } = billete;

          const billete_remision = {
            id: id_billete,
            numero_billete,
            estatus,
            monto
          };

          billetes_remision.push(billete_remision);
          
        });

        showBilletesRemision();

        
        if( objetos.length ){
          $('input[name=objeto_asegurado][value="si"').prop("checked", true);
          objetoAsegurado();
        }

        $(objetos).each( function( index, objeto ) {

          const { id_objeto, estatus, objeto_descripcion, objeto_ubicacion } = objeto;

          const objeto_remision = {
            id: id_objeto,
            estatus,
            objeto_descripcion,
            objeto_ubicacion
          }

          objetos_remision.push(objeto_remision);

        });
        
        showObjetos();

        $('#numeroDVD').val(numero_dvds);
      
        const documentos = await obtenerDocumentosInfoComp( carpeta_remitir.id_remision );
     
        if( documentos.status == 100 ) {
          $(documentos.response).each( async function( index, dataDoc ) {
            setTimeout( async () => {
              url = await obtenerDocumentosInfoComp( carpeta_remitir.id_remision, dataDoc.id_documento );
              
              if( url.status == 100 ) {
                dataDoc.url = url.url
                dataDoc.icon = "fa-file-pdf-o";
                dataDoc.estatus = 1;
                dataDoc.tipo_documento = url.tipo_archivo;
                
                const tipoDoc = dataDoc.nombre_archivo.split('_');

                if ( tipoDoc[tipoDoc.length -1].split('.')[0] == 'sentencia' ) 
                  dataDoc.documento = 'copia_certificada_sentencia';
                else if ( tipoDoc[tipoDoc.length -1].split('.')[0] == 'auto' )
                  dataDoc.documento = 'copia_certificada_auto';
                else if ( tipoDoc[tipoDoc.length -1].split('.')[0] == 'audiencia' )
                  dataDoc.documento = 'acta_minima';
                else 
                  adjuntos_remision.push(dataDoc);
                
                showAdjuntos();
                setTimeout( () => {

                  $('#div_'+dataDoc.documento).html(doc_loadind);
                  $('#'+dataDoc.documento).parent().addClass('d-none');
                  informacion_complementaria.documentos_remision_ue[dataDoc.documento] = dataDoc;   
                  $('#div_'+dataDoc.documento).html(`
                    <div style="padding-top: 13px;">
                      <a href="javascript:void(0)" ondblclick="abrirDocumento('${dataDoc.documento}')" class="d-none d-md-inline-flex">
                        <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative; color: #C6362D;"></i>
                      </a>
                      <a href="${dataDoc.url}" class="d-inline-flex d-md-none">
                        <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative; color: #C6362D;"></i>
                      </a>
                      <a href="javascript:void(0)" onclick="eliminarDocumento('${dataDoc.documento}')" class="mg-l-auto" style="position: absolute;">
                        <i class="fa fa-times-circle tx-danger btn-cancel" aria-hidden="true" style="font-size:1rem;padding-top:4px;position: relative;top: -13px;"></i>
                      </a>
                    </div>`);
                    
                },200);
              }
            }, (index*100) );
          });
        }
      }
    }
  });
}

function obtenerDocumentosInfoComp( remision , documento="" ){
  
  return new Promise(resolve => {
      $.ajax({
        method: 'GET',
        url: '/public/obtener_documentos_inf_comp',
        data: { remision, documento },
        success: function(response){
          resolve(response);  
        }
      });
  });
}

function obtenerPersonasCarpetaRUE(carpeta){
  $.ajax({
    method:'POST',
    url:'/public/obtener_personas_carpeta',
    data:{carpeta},
    success:function(response){
      if( response.status == 100 ){
        $(response.response.personas).each(function(index, persona){
          
          const {id_calidad_juridica,id_persona,nombre,apellido_paterno,apellido_materno,razon_social} = persona;
          
          if( tipo_defensor.includes(id_calidad_juridica) )
            $('#defensor').append(`<option value="${id_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);

          else if( tipo_victima.includes(id_calidad_juridica) )
            $('#victima').append(`<option value="${id_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);

          else if( tipo_aseseor_juridico.includes(id_calidad_juridica) )
            $('#asesorJuridico').append(`<option value="${id_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);

          else if( tipo_ministerio_publico.includes( id_calidad_juridica ) )
            $('#ministerioPublico').append(`<option value="${id_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);
          
          else if( tipo_imputado.includes( id_calidad_juridica ) )
            $('#imputados').append(`<option value="${id_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);
        });
      }
    }
  });
}

function remisionEjecAutorizacion( ) {
  $('#modalRemision').modal('hide');
  
  if( secciones_completadas.length != 3 ) {
    error('Datos Incompletos', 'No ha completado las secciones', 'modalRemision');
    return 0;
  }

  $('#modal_loading').modal('show');
  $.ajax({
    method: 'POST',
    url: '/public/remision_eje_autorizacion',
    data: {remision_in},
    success: function ( response ) {
      //console.log(response);
      if ( response.status == 100 ) {
        $('#modal-success-titulo').html(`${response.message}<br><span class="tx-bold">Folio: ${response.response.folio}</span>`);
        $('#btnCerrarSuccess').attr('data-modal',"");
        $('#modalSuccess').modal('show');
      }else{
        error('Error', response.message, 'modalRemision');
      }
      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },600);
    }

  });
}


function showSentenciados(){
  
  $('#bodySentenciados').html('');
  if(sentenciados.length && sentenciados.find( sentenciado => sentenciado.estatus == 1 )){
    $(sentenciados).each(function(index, sentenciado){
      const{sentenciado_desc,tipo,id, estatus} = sentenciado;
      if( estatus ){
        $('#bodySentenciados').append(`
        <tr>
          <td>
            <a href="javascript:void(0)" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar sentenciado" onclick="eliminarSentenciado(${index},'${id}')"><i class="fa fa-trash tx-danger"></i></a>
            <a href="javascript:void(0)" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar sentenciado" onclick="editarSentenciado(${index},'${id}')" style="color:#848F33"><i class="fa fa-pencil-square-o mg-l-10" ></i></a>
          </td>
          <td>${sentenciado_desc}</td>
          <td>${tipo}</td>
        </tr>
      `);
      }
    });
  }else{
    $('#bodySentenciados').append(`<tr><td class="tx-danger tx-center" colspan="3">No ha agregado ningun sentenciado</td></tr>`);
  }
}

function eliminarSentenciado(index, id){

  if( id == '-' ){
    sentenciados = sentenciados.filter((sentenciado, index_sent) => {
      if( index_sent != index )
        return sentenciado;
    });
  }else{
    sentenciados = sentenciados.map((sentenciado, index_sent) =>{
      if( index_sent == index )
        sentenciado.estatus = 0;
        return sentenciado;
    })
  }
  //console.log(sentenciados);
  $('#sentenciados .square-8 ').remove();
  $('#sentenciados').append('<span class="square-8 bg-danger mg-r-5 mg-l-5 rounded-circle"></span>');
  showSentenciados();
}

function sentenciadoLibertad(){
  
  if( $('input:radio[name=sentenciado_libertad]:checked').val() == 'si' ){
    $('#centroDetencion').attr('disabled',true).val('').trigger('change');
    $('#centroDetencion').parent().find('.tx-danger').addClass('d-none');

  }else{
    $('#centroDetencion').removeAttr('disabled');
    $('#centroDetencion').parent().find('.tx-danger').removeClass('d-none');
  }
}

function editarSentenciado(index,id){
  
  sentenciado_edit = {index,id};
  const sentenciado = sentenciados[index];
  penas = sentenciado.penas;
  $('#imputados').val(sentenciado.sentenciado).trigger('change');
  $("input[name=sentenciado_libertad][value='"+sentenciado.sentenciado_libertad+"']").prop("checked", true);
  sentenciadoLibertad();
  suspensionCondicionalPena(sentenciado.suspension_ejecucion);
  $('#centroDetencion').val(sentenciado.centro_detencion).trigger('change');
  $('#montoGarantia').val(sentenciado.monto_garantia).trigger('input');
  $("input[name=suspension_ejecucion][value='"+sentenciado.suspension_ejecucion+"']").prop("checked", true);
  $('#modalRemision').modal('hide');
  showPenas();
  abreModal('modalSentenciado',400);

}

// PENAS
function nuevaPena(){
  pena_edit = '-';
  $('#modalSentenciado').modal('hide');
  $('#modalPenas .nav-link').removeClass('active');
  $('#modalPenas .tab-pane').removeClass('active');
  $('#navDatosGenerales').addClass('active');
  $('#datosGenerales').addClass('active');
  $('#tipoPena').val('').trigger('change');
  $('#penaImpuesta').val('').trigger('change');
  $('#detallePena').val('').trigger('change');
  $('#centroDetencionPena').val('').trigger('change');
  $('#centroDetencionAbono').val('').trigger('change');
  $('#centroDetencionAbonoOtro').val('').removeAttr('disabled');
  $('#detallesAdicionalesPena').val('');
  showDelitos();
  showAbonos();
  showSustitutivos();
  abreModal('modalPenas',300);
}

function obtenerPenas(pena_tipo='',pena_impuesta=''){
  //console.log("pena_tipo,pena_impuesta");
  //console.log(pena_tipo,pena_impuesta);
  const tipo_pena = pena_tipo == '' ?$('#tipoPena').val() : pena_tipo;
  $('#penaImpuesta').html('<option value="" disabled selected>Cargando...</option>');
  return new Promise(resolve => {
    $.ajax({
      method:'POST',
      url:'/public/obtener_penas',
      data:{tipo_pena},
      success:function(response){
        let pena_selec = '';
        // console.log(response.response);
        if( response.status == 100 ){
          $('#penaImpuesta').html('<option value="" disabled>Seleccione una opción</option>');
          $(response.response).each(function(index, pena){
            //console.log(pena)
            //console.log(String(pena_impuesta))
            // console.log(String(pena_impuesta) == pena.codigo)
            if( String(pena_impuesta) != pena.codigo){
              $('#penaImpuesta').append(`<option value="${pena.codigo}">${pena.pena}</option>`);              
            }else{
              $('#penaImpuesta').append(`<option value="${pena.codigo}" selected>${pena.pena}</option>`);
              pena_selec = pena;
            }
            $('#penaImpuesta').trigger('change');
          });
          resolve(pena_selec);
        }
      }
    });
  });
}

function penaImpuesta( detalle_pena = '' ){
  const pena_impuesta = $('#penaImpuesta').val();
  $('#divPeriodo').addClass('d-none').find('input').val('');
  $('#centroDetencionPena').val('').trigger('change');
  $('#divCentroDetencion').addClass('d-none');
  $('#sectionAbonoPrision').addClass('d-none');
  $('#sectionSustitutivosPena').addClass('d-none');
  $('#divDecomisos').addClass('d-none').find('.decomiso').prop('checked', false);
  $('#detallePena').html('<option value="" selected disabled>Seleccione una opción</option>');
  if( penas_detalle_pena.includes( parseInt(pena_impuesta) ) ){
    $.ajax({
      method:'POST',
      url:'/public/obtener_detalle_pena',
      data:{ pena_impuesta },
      success:function(response){
        if( response.message.length ) {
          $(response.message).each( function( index, detalle ) {
            $('#detallePena').append(`<option value="${detalle.id_pena_opcion}" ${ detalle_pena == detalle.id_pena_opcion ? 'selected' : '' }>${detalle.descripcion}</option>`);
          });
          $('#divDetallePena').removeClass('d-none');
        }
      }
    });
  }else{
    $('#divDetallePena').addClass('d-none');
  }

  if( periodos.includes(parseInt(pena_impuesta)) ) 
    $('#divPeriodo').removeClass('d-none');
    
  if( prision.includes(parseInt(pena_impuesta)) ) 
    $('#divCentroDetencion').removeClass('d-none');

  if( decomisos.includes(parseInt(pena_impuesta)) ) 
    $('#divDecomisos').removeClass('d-none'); 

  if( abonoPrision.includes(parseInt(pena_impuesta)) ) 
    $('#sectionAbonoPrision').removeClass('d-none'); 
  else
    abonos = [];

  if( sustitutivoPena.includes(parseInt(pena_impuesta)) ) 
    $('#sectionSustitutivosPena').removeClass('d-none');
  else 
    sustitutivos = [];

}

function agregarPena() {
  $('.error').removeClass('error');

  if($('#tipoPena').val()=='' || $('#tipoPena').val()==null){
    error('Datos Incompletos', 'No ha seleccionado el tipo de pena', 'modalPenas');
    $('span[aria-labelledby="select2-tipoPena-container"]').addClass('error');
    return 0;
  }
  
  if( $('#penaImpuesta').val() == '' || $('#penaImpuesta').val() == null) {
    error('Datos Incompletos', 'No ha seleccionado la pena impuesta', 'modalPenas');
    $('span[aria-labelledby="select2-penaImpuesta-container"]').addClass('error');
    return 0;
  }

  const penaImpuesta = $('#penaImpuesta').val();

  if( penas_detalle_pena.includes(parseInt(penaImpuesta)) ){
    if( $('#detallePena').val() == '' || $('#detallePena').val() == null ){
      error('Datos Incompletos', 'No ha seleccionado el detalle de la pena impuesta', 'modalPenas');
      $('span[aria-labelledby="select2-detallePena-container"]').addClass('error');
      return 0;
    }
  }

  if( periodos.includes(parseInt(penaImpuesta)) ){

    // if( $('#periodoAnios').val() == '' || $('#periodoAnios').val() == null ){
    //   error('Datos Incompletos', 'No ha indicado los años', 'modalPenas');
    //   $('span[aria-labelledby="select2-periodoAnios-container"]').addClass('error');
    //   return 0;
    // }

    // if( $('#periodoMeses').val() == '' || $('#periodoMeses').val() == null ){
    //   error('Datos Incompletos', 'No ha indicado los meses', 'modalPenas');
    //   $('span[aria-labelledby="select2-periodoMeses-container"]').addClass('error');
    //   return 0;
    // }

    // if( $('#periododias').val() == '' || $('#periododias').val() == null ){
    //   error('Datos Incompletos', 'No ha indicado los días', 'modalPenas');
    //   $('span[aria-labelledby="select2-periododias-container"]').addClass('error');
    //   return 0;
    // }
  }

  if( prision.includes(parseInt(penaImpuesta)) ){
    
    if( $('#centroDetencionPena').val() == '' || $('#centroDetencionPena').val() == null ){
      error('Datos Incompletos', 'No ha indicado el centro de detención', 'modalPenas');
      $('span[aria-labelledby="select2-periododias-container"]').addClass('error');
      return 0;
    }
    
  }

  if( delitos.length == 0 ){
    error('Datos Incompletos', 'No ha agregado ningún delito', 'modalPenas');
      // $('span[aria-labelledby="select2-periododias-container"]').addClass('error');
      return 0;
  }

  const tipo_pena = $('#tipoPena').val(),
        tipo_pena_desc = tipo_pena==null?'':$('#tipoPena option:selected').text(),
        pena_impuesta = $('#penaImpuesta').val(),
        pena_impuesta_desc = pena_impuesta==null?'':$('#penaImpuesta option:selected').text(),
        detalle_pena = $('#detallePena').val()==null?'':$('#detallePena').val(),
        detalle_pena_desc = detalle_pena==''?'':$('#detallePena option:selected').text(),
        centro_detencion_pena = $('#centroDetencionPena').val()==null?'':$('#centroDetencionPena').val(),
        centro_detencion_pena_desc = centro_detencion_pena==null?'':$('#centroDetencionPena option:selected').text();
        detalles_adicionales_pena= $('#detallesAdicionalesPena').val();

  const pena={
    estatus:'1',
    tipo_pena,
    tipo_pena_desc,
    pena_impuesta,
    pena_impuesta_desc,
    detalle_pena,
    detalle_pena_desc,
    periodo_anios:$('#periodoAnios').val(),
    periodo_mese:$('#periodoMeses').val(),
    periodo_dias:$('#periododias').val(),
    decomiso_instrumento:$('#decomisoInstrumento').is(':checked'),
    decomiso_objetos:$('#decomisoObjetos').is(':checked'),
    decomiso_productos_delito:$('#decomisoProductos').is(':checked'),
    centro_detencion_pena,
    centro_detencion_pena_desc,
    detalles_adicionales_pena,
    sustitutivo_pena: sustitutivos.length == 0 ? 'no' : 'si',
    delitos,
    abonos,
    sustitutivos,
    suspension_condicional : 0
  };

  if( pena_edit != '-' ){
    pena.id = pena_edit.id;
    penas[pena_edit.index] = pena;
  }else{
    pena.id = '-';
    penas.push(pena);
  }
  pena_edit = '-';
  delitos=[];
  showPenas();
  $('#modalPenas').modal('hide');
  abreModal('modalSentenciado',400);
  
}

function eliminarPena(index,id){

  if( id == '-' ){
    penas = penas.filter((pena, index_pena) => {
      if( index_pena != index )
        return pena;
    });
  }else{
    penas = penas.map((pena, index_pena) => {
      if( index_pena == index )
        pena.estatus = 0;
        return pena;
    })
  }
  showPenas();
}

function showPenas(){
  $('#bodyPenas').html('');
  const scep = $('input[name="suspension_ejecucion"]:checked').val();
  
  if(penas.length && penas.find( pena => pena.estatus == 1 ) != undefined){
    $(penas).each(function(index, pena){
      //console.log(pena);
      const{pena_impuesta_desc, delitos, detalles_adicionales_pena, sustitutivo_pena, id, estatus, suspension_condicional} = pena;
      if( estatus ){
        let listDelitos='';
        $(delitos).each(function(index, delito){
          if( delito.estatus )
            listDelitos=listDelitos.concat(`- ${delito.delito}<br>`);
        });
        
        $('#bodyPenas').append(`
          <tr>
            <td class="acciones_pena">
              <i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar pena" onclick="eliminarPena(${index},'${id}')"></i>
              <i class="fa fa-pencil-square-o mg-l-10" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar pena" onclick="editarPena(${index},'${id}')" style="color:#848F33"></i>
            </td>
            <td class="suspension_condicional_pena ${ scep == 'si' ? '' : "d-none"} tx-center"><label class="ckbox mg-l-10" style="margin-bottom:0 !important;">
            <input type="checkbox" name="suspension_condicional_pena" onchange="agregarSuspCond(${index}, this)" ${ suspension_condicional == 1 ? 'checked' : ''}><span></span>
          </label></td>
            <td class="pena">${pena_impuesta_desc}</td>
            <td class="delitos">${listDelitos}</td>
            <td class="detalles">${detalles_adicionales_pena}</td>
            <td class="sustitutivo">${sustitutivo_pena}</td>
          </tr>`)
      }
    });
  }else{
    $('#bodyPenas').append(`<tr><td class="tx-danger tx-center" colspan="5">No ha agregado ninguna pena</td></tr>`);
  }
}

async function editarPena(index, id){
  
  pena_edit = {index,id};
  const {tipo_pena, pena_impuesta, periodo_anios, periodo_dias, periodo_mese, centro_detencion_pena, decomiso_instrumento, decomiso_objetos, decomiso_productos_delito, detalles_adicionales_pena, detalle_pena} = penas[index];
  abonos = penas[index].abonos;
  sustitutivos = penas[index].sustitutivos;
  delitos = penas[index].delitos;
  $('#modalSentenciado').modal('hide');
  $('#modalPenas .nav-link').removeClass('active');
  $('#modalPenas .tab-pane').removeClass('active');
  $('#navDatosGenerales').addClass('active');
  $('#datosGenerales').addClass('active');
  $('#tipoPena').val(tipo_pena).trigger('change'); 
  await obtenerPenas(tipo_pena,'');
  await sleep(50);
  $('#penaImpuesta').val(pena_impuesta).trigger('change');
  penaImpuesta( detalle_pena );
  await sleep(100);
  $('#periodoAnios').val(periodo_anios);
  $('#periodoMeses').val(periodo_mese);
  $('#periododias').val(periodo_dias);
  $('#centroDetencionPena').val(centro_detencion_pena).trigger('change');

  if( decomiso_instrumento == true)
    $('#decomisoInstrumento').prop("checked", true);

  if( decomiso_objetos == true)
    $('#decomisoObjetos').prop("checked", true);

  if( decomiso_productos_delito == true)
    $('#decomisoProductos').prop("checked", true);

  $('#detallePena').val(detalle_pena).trigger('change');
  $('#detallesAdicionalesPena').val(detalles_adicionales_pena);
  $('#centroDetencionAbono').val('').trigger('change');
  $('#centroDetencionAbonoOtro').val('').removeAttr('disabled');
  $('#sustitutivo').val('').trigger('change');
  $('.acoge_sustitutivo').prop('ckeched', false);
  $('#detallesAdicionalesSustitutivo').val('');
  $('#montoSustitutivo').val('');
  showDelitos();
  showAbonos();
  showSustitutivos();
  abreModal('modalPenas',300);
}

sleep = time => {
  return new Promise( resolve => {
    setTimeout( () => { resolve( true ) }, time );
  });
};

// DELITOS
function nuevoDelito(){

  delito_edit = '-';
  $('#modalPenas').modal('hide');
  $('#modalDelitos').modal('show');
}

function agregarDelito(){
  
  if($('#delitoPena').val()=='' || $('#delitoPena').val()==null){
    error('Datos Incompletos', 'No ha seleccionado el delito a agregar', 'modalDelitos');
    $('span[aria-labelledby="select2-delitoPena-container"]').addClass('error');
    return 0;
  }

  const delito=$('#delitoPena option:selected').text(),
        id_delito=$('#delitoPena').val();

  repeated = 0;
  $(delitos).each(function(index_del, delito_){
    if( delito_.id_delito == id_delito && index_del != delito_edit.index ){
      error('Verifique la información', 'El delito seleccionado ya está agregado', 'modalDelitos');
      $('span[aria-labelledby="select2-delitoPena-container"]').addClass('error');
      repeated = 1;
    }
  });

  if(repeated) 
    return 0;

  delito_agregar={
    estatus:'1',
    delito,
    id_delito
  };

  if( delito_edit != '-' ){
    delito_agregar.id = delito_edit.id;
    delitos[delito_edit.index] = delito_agregar;
  }else{
    delito_agregar.id = '-';
    delitos.push(delito_agregar);
  }

  delito_edit = '-';
  $('#modalDelitos').modal('hide');
  abreModal('modalPenas',400);
  $('#delitoPena').val('').trigger('change');

  showDelitos();
}

function showDelitos(){
  $('#bodyDelitos').html('');
  if(delitos.length){
    $(delitos).each(function(index, delito){
      $('#bodyDelitos').append(`<tr><td><i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar delito" onclick="eliminarDelitoPena(${index})"></i><i class="fa fa-pencil-square-o mg-l-10" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar delito" onclick="editarDelito(${index},'${delito.id}')" style="color:#848F33"></i></td><td data-delito="${index}">${delito.delito}</td></tr>`);
    });
  }else{
    $('#bodyDelitos').append(`<tr><td class="tx-danger tx-center" colspan="2">No ha agregado ningun delito</td></tr>`);
  }
}

function eliminarDelitoPena(delito_n){

  delitos = delitos.filter((delito, index) => {
    if( delito_n != index )
      return delito;
  });

  showDelitos();
}

function editarDelito(index, id){

  delito_edit = {index,id}
  $('#delitoPena').val(delitos[index].id_delito).trigger('change');
  $('#modalPenas').modal('hide');
  $('#modalDelitos').modal('show');

}

// ABONOS
function nuevoAbono(){
  $('#divCentroDetencionAbono').removeClass('d-none');
  $('#centroDetencionPena').val('').trigger('change');
  $('#centroDetencionAbonoOtro').val('').removeAttr('disabled');
}

function agregarAbono(){
  $('.error').removeClass('error');

  if( expVacio.test( $('#abonoAnios').val() ) ){
    error('Datos Incompletos', 'No ha indicado los años', 'modalPenas');
    $('#abonoAnios').addClass('error');
    return 0;
  }

  if( expVacio.test($('#abonoMeses').val()) ){
    error('Datos Incompletos', 'No ha indicado los meses', 'modalPenas');
    $('#abonoMeses').addClass('error');
    return 0;
  }

  if( expVacio.test($('#abonodias').val()) ){
    error('Datos Incompletos', 'No ha indicado los días', 'modalPenas');
    $('#abonodias').addClass('error');
    return 0;
  }

  if( $('#centroDetencionAbono').val()=='' || $('#centroDetencionAbono').val()==null ){
    error('Datos Incompletos', 'No ha seleccionado el centro de detención', 'modalPenas');
    $('span[aria-labelledby="select2-centroDetencionAbono-container"]').addClass('error');
    return 0;
  }

  if( $('#centroDetencionAbono').val()=='otro' ){
    if( expVacio.test($('#centroDetencionAbonoOtro').val()) ){
      error('Datos Incompletos', 'No ha especificado el campo "Otro centro de detención"', 'modalPenas');
      $('#centroDetencionAbono').addClass('error');
      return 0;
    }
  }

  const abono={
    estatus:'1',
    anios_abono:$('#abonoAnios').val(),
    meses_abono:$('#abonoMeses').val(),
    dias_abono:$('#abonodias').val(),
    centro_detencion:$('#centroDetencionAbono').val(),
    centro_detencion_desc:$('#centroDetencionAbono').val()==null?'':$('#centroDetencionAbono option:selected').text(),
    centro_detencion_otro:$('#centroDetencionAbonoOtro').val(),
  };

  if( abono_edit != '-' ){
    abono.id = abono_edit.id;
    abonos[abono_edit.index] = abono;
  }else{
    abono.id = '-';
    abonos.push(abono);
  }
  abono_edit = '-';
  showAbonos();
  calculoAbonoSentencia()

  $('#abonoAnios').val('');
  $('#abonoMeses').val('');
  $('#abonodias').val('');
  $('#centroDetencionAbono').val('').trigger('change');
  $('#centroDetencionAbonoOtro').val('');
  $('#divCentroDetencionAbono').addClass('d-none');
}

function showAbonos(){
  $('#bodyAbonos').html('');
  if(abonos.length){
    $(abonos).each(function(index, abono){
      $('#bodyAbonos').append(`<tr><td class="acciones"><i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar abono" onclick="eliminarAbono(${index},'${abono.id}')"></i><i class="fa fa-pencil-square-o mg-l-10" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar abono" onclick="editarAbono(${index},'${abono.id}')" style="color:#848F33"></i></td><td class="anios_abono">${abono.anios_abono}</td><td class="meses_abono">${abono.meses_abono}</td><td class="dias_abono">${abono.dias_abono}</td><td class="centro_abono">${abono.centro_detencion_desc}</td><td class=otro_centro_abono">${abono.centro_detencion_otro}</td></tr>`);
    });
    
  }else{
    $('#bodyAbonos').append(`<tr><td class="tx-danger tx-center" colspan="6">No ha agregado ningun abono</td></tr>`);
  }
}

function centroDetencionAbono(){
  if( $('#centroDetencionAbono').val() == 'otro' ){
    $('#centroDetencionAbonoOtro').removeAttr('disabled');
  }else{
    $('#centroDetencionAbonoOtro').val('').attr('disabled',true);
  }
}

function eliminarAbono(index, id){

  if( id == '-' ){
    abonos = abonos.filter((abono,index_abono) => {
      if( index != index_abono )
        return abono;
    });  
  }else{
    abonos = abonos.filter((abono, index_abono)=> {
      if( index == index_abono )
        abono.estatus=0;
        return abono;
    });
  }
  calculoAbonoSentencia();
  showAbonos();
}

function cancelarAbono(){
  $('#abonoAnios').val('');
  $('#abonoMeses').val('');
  $('#abonodias').val('');
  $('#centroDetencionAbono').val('').trigger('change');
  $('#centroDetencionAbonoOtro').val('');
  $('#divCentroDetencionAbono').addClass('d-none');
  abono_edit = '-';
}

function calculoAbonoSentencia(){
  const 
    expInt = /^\d+$/,
    anios_periodo = expInt.test( $('#periodoAnios').val() ) == false ? 0 : parseInt( $('#periodoAnios').val() ),
    meses_periodo = expInt.test( $('#periodoMeses').val() ) == false ? 0 : parseInt( $('#periodoMeses').val() ),
    dias_periodo = expInt.test( $('#periododias').val() ) == false ? 0 : parseInt( $('#periododias').val() );
  let
    total_abono_anios=0,
    total_abono_meses=0,
    total_abono_dias=0;

    $(abonos).each(function(index, abono){
      total_abono_anios = total_abono_anios + parseInt(expInt.test(abono.anios_abono)==false?0:abono.anios_abono);
      total_abono_meses = total_abono_meses + parseInt(expInt.test(abono.meses_abono)==false?0:abono.meses_abono);
      total_abono_dias = total_abono_dias + parseInt(expInt.test(abono.dias_abono)==false?0:abono.dias_abono);
    });            

    $('#abonoAniosTotal').html(total_abono_anios);
    $('#abonoMesesTotal').html(total_abono_meses);
    $('#abonoDiasTotal').html(total_abono_dias);

    anios_cumplir = anios_periodo - total_abono_anios;
    meses_cumplir = meses_periodo - total_abono_meses;
    dias_cumplir = dias_periodo - total_abono_dias;

    $('#aniosTotalCumplir').html(anios_cumplir<1?'0':anios_cumplir);
    $('#mesesTotalCumplir').html(meses_cumplir<1?'0':meses_cumplir);
    $('#diasTotalCumplir').html(dias_cumplir<1?'0':dias_cumplir)
}

function editarAbono(index, id){

  abono_edit = {index, id};
  $('#abonodias').val(abonos[index].dias_abono);
  $('#abonoMeses').val(abonos[index].meses_abono);
  $('#abonoAnios').val(abonos[index].anios_abono);
  $('#centroDetencionAbono').val(abonos[index].centro_detencion).trigger('change');
  setTimeout(()=>{centroDetencionAbono()},100);
  $('#centroDetencionAbonoOtro').val(abonos[index].centro_detencion_otro).removeAttr('disabled');
  $('#divCentroDetencionAbono').removeClass('d-none');
  
}
// SUSTITUTIVOS
function nuevoSustitutivo(){
  
  sustitutivo_edit = '-';
  $('#sustitutivo').val('').trigger('change');
  $('#montoSustitutivo').val('');
  $('input[name=acoge_sustitutivo]').prop('ckeched', false);
  $('#detallesAdicionalesSustitutivo').val('');
  $('#sistitutivoNuevo').removeClass('d-none');

}

function agregarSustitutivo(){

  if( $('#sustitutivo').val() == '' || $('#sustitutivo').val() == null ){
    error('Datos Incompletos', 'No ha seleccionado un sustitutivo', 'modalPenas');
    $('span[aria-labelledby="select2-sustitutivo-container"]').addClass('error');
    return 0;
  }

  if( arr_sustitutivos.includes(parseInt($('#sustitutivo.val'))) ){
    if( expVacio.test($('#montoSustitutivo').val()) ){
      error('Datos Incompletos', 'No ha seleccionado un sustitutivo', 'modalPenas');
      $('#montoSustitutivo').addClass('error');
      return 0;
    }
  }
    
  const sustitutivo={
    id:'0',
    estatus:'1',
    sustitutivo:$('#sustitutivo').val(),
    sustitutivo_desc:$('#sustitutivo').val()==''?'':$('#sustitutivo option:selected').text(),
    monto:$('#montoSustitutivo').val(),
    acoge_sustitutivo:$('input:radio[name=acoge_sustitutivo]:checked').val(),
    detalles_adicionales:$('#detallesAdicionalesSustitutivo').val()
  }
  $('#sistitutivoNuevo').addClass('d-none');
  if( sustitutivo_edit != '-' ){
    sustitutivo.id = sustitutivo_edit.id;
    sustitutivos[sustitutivo_edit.index] = sustitutivo;
  }else{
    sustitutivo.id = '-';
    sustitutivos.push(sustitutivo);  
  }
  sustitutivo_edit = '-';
  showSustitutivos();
}

function sustitutivo(){
  
  if( arr_sustitutivos.includes(parseInt($('#sustitutivo').val())) ){
    $('#divMonto').removeClass('d-none');
  }else{
    $('#divMonto').addClass('d-none');
    $('#montoSustitutivo').val('');
  }
}

function showSustitutivos(){
  $('#bodySustitutivos').html('');
  if(sustitutivos.length){
    $(sustitutivos).each(function(index, sustitutivo){
      $('#bodySustitutivos').append(`<tr><td class="acciones"><i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar sustitutivo" onclick="eliminarSustitutivo(${index}, '${sustitutivo.id}')"></i><i class="fa fa-pencil-square-o mg-l-10" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar sustitutivo" onclick="editarSustitutivo(${index},'${sustitutivo.id}')" style="color:#848F33"></i></td><td class="sustitutivo">${sustitutivo.sustitutivo_desc}</td><td class="monto_sustitutivo">${sustitutivo.monto}</td><td class="acoge_sustitutivo text-capitalize">${sustitutivo.acoge_sustitutivo}</td><td class="detalles_adicionales_sustitutivo">${sustitutivo.detalles_adicionales}</td><</tr>`);
    });
    
  }else{
    $('#bodySustitutivos').append(`<tr><td class="tx-danger tx-center" colspan="6">No ha agregado ningun abono</td></tr>`);
  }
}

function eliminarSustitutivo(index, id){

  if( id == '-' ){
    sustitutivos = sustitutivos.filter((sustitutivo,index_sustitutivo) => {
      if( index != index_sustitutivo )
        return sustitutivo;
    });
  }else{
    sustitutivos = sustitutivos.map((sustitutivo, index_sustitutivo)=>{
      if( index_sustitutivo == index )
        sustitutivo.estatus = 0;
        return sustitutivo;
    });
  }
  showSustitutivos();

}

function cancelarSustitutivo(){
  $('#sustitutivo').val('').trigger('change');
  $('#montoSustitutivo').val('');
  $('input[name=acoge_sustitutivo]').prop('ckeched', false);
  $('#detallesAdicionalesSustitutivo').val('');
  $('#sistitutivoNuevo').addClass('d-none');
}

function editarSustitutivo(index,id){

  sustitutivo_edit = {index,id};
  $('#sustitutivo').val(sustitutivos[index].sustitutivo).trigger('change');
  sustitutivo();
  $('#montoSustitutivo').val(sustitutivos[index].monto);
  $("input[name=acoge_sustitutivo][value='"+sustitutivos[index].acoge_sustitutivo+"']").prop("checked", true);
  $('#detallesAdicionalesSustitutivo').val(sustitutivos[index].detalles_adicionales);
  $('#sistitutivoNuevo').removeClass('d-none');

}

// DEFENSORES
function nuevoDefensor(){
  $('#defensor').val('').trigger('change');
  $('#tipoDefensor').val('').trigger('change');
  $('#sentenciadosDefensores').html('');
  $(sentenciados).each(function(index, sentenciado){
    $('#sentenciadosDefensores').append(`<label class="ckbox mg-l-10"><input type="checkbox" class="sentenciado_defensor" value="${sentenciado.sentenciado}"><span>${sentenciado.sentenciado_desc}</span></label><br>`);
  });
  $('#divDefensor').removeClass('d-none');
}

function agregarDefensor(){

  let ids_sentenciados_defendidos = '';
  $('.sentenciado_defensor').each(function(index){
    if($(this).is(':checked')){
      if(index > 0)
        ids_sentenciados_defendidos=ids_sentenciados_defendidos.concat(','+$(this).val());
      else
        ids_sentenciados_defendidos=ids_sentenciados_defendidos.concat($(this).val());
    }
  });
  
  const defensor = {
    estatus:1,
    persona:$('#defensor').val(),
    persona_desc:$('#defensor option:selected').text(),
    tipo_defensor:$('#tipoDefensor').val(),
    ids_sentenciados_defendidos
  };
  
  if( defensor_edit != '-' ){
    defensor.id = defensor_edit.id;
    defensores[defensor_edit.index] = defensor;
  }else{
    defensor.id = 0,
    defensores.push(defensor);
  }
  $('#defensores .square-8 ').remove();
  $('#defensores').append('<span class="square-8 bg-danger mg-r-5 mg-l-5 rounded-circle"></span>');
  defensor_edit != '-';
  $('#divDefensor').addClass('d-none');
  showDefensores();
}

function showDefensores(){
  $('#bodyDefensores').html('');
  if( defensores.length && defensores.find( defensor => defensor.estatus == 1 ) != undefined ){
    $(defensores).each(function(index,defensor){
      const {persona_desc,tipo_defensor,id, estatus} = defensor;
      if( estatus )
        $('#bodyDefensores').append(`
        <tr>
          <td>
            <i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar defensor" onclick="eliminarDefensor(${index},${id})"></i>
            <i class="fa fa-pencil-square-o mg-l-10" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar defensor" onclick="editarDefensor(${index},${id})" style="color:#848F33"></i>
          </td>
          <td>
            ${persona_desc}
          </td>
          <td class="text-capitalize">
            ${tipo_defensor}
          </td>
        </tr>
      `);
    });
  }else{
    $('#bodyDefensores').append(`<tr><td class="tx-danger tx-center" colspan="3">No ha agregado ningún defensor</td></tr>`);
  }
}

function eliminarDefensor(index,id){
  if( id == 0 ){
    defensores = defensores.filter((defensor,index_defensor)=>{
      if( index_defensor != index )
        return defensor;
    });
  }else{
    defensores = defensores.map((defensor,index_defensor)=>{
      if( index_defensor == index )
        defensor.estatus = 0;
      return defensor;
    })
  }
  showDefensores();
}

function cancelarDefensor(){
  $('#defensor').val('').trigger('change');
  $('#tipoDefensor').val('').trigger('change');
  $('input[name=sentenciado_defensor]').prop('ckeched', false);
  $('#divDefensor').addClass('d-none');
}

function editarDefensor(index,id){
  defensor_edit = {index,id};
  $('#defensor').val(defensores[index].persona).trigger('change');
  $('#tipoDefensor').val(defensores[index].tipo_defensor).trigger('change');
  sentenciados_defensor = defensores[index].ids_sentenciados_defendidos.split(',');
  $('#sentenciadosDefensores').html('');
  $(sentenciados).each(function(index, sentenciado){
    if(sentenciados_defensor.includes(sentenciado.sentenciado.toString()))
      $('#sentenciadosDefensores').append(`<label class="ckbox mg-l-10"><input type="checkbox" class="sentenciado_defensor" value="${sentenciado.sentenciado}" checked><span>${sentenciado.sentenciado_desc}</span></label><br>`);
    else
      $('#sentenciadosDefensores').append(`<label class="ckbox mg-l-10"><input type="checkbox" class="sentenciado_defensor" value="${sentenciado.sentenciado}"><span>${sentenciado.sentenciado_desc}</span></label checked><br>`);
  });
  $('#divDefensor').removeClass('d-none');
}

function nuevoRegistroDefensor(){
  $('#modalRemision').modal('hide');
  abreModal('modalDefensor',300);
}

// VÍCTIMAS

function nuevaVictima(){
  $('#divVictima').removeClass('d-none');
}

function showVictimas(){
  
  $('#bodyVictimas').html('');
  if( victimas.length && victimas.find( victima => victima.estatus == 1 ) != undefined ){
    $(victimas).each(function(index,victima){
      const {desc_victima,id, estatus} = victima;
      if( estatus )
        $('#bodyVictimas').append(`
        <tr>
          <td>
            <i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar víctima" onclick="eliminarVictima(${index},${id})"></i>
            <i class="fa fa-pencil-square-o mg-l-10" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar víctima" onclick="editarVictima(${index},${id})" style="color:#848F33"></i>
          </td>
          <td>
            ${desc_victima}
          </td>
        </tr>
      `);
    });
  }else{
    $('#bodyVictimas').append(`<tr><td class="tx-danger tx-center" colspan="2">No ha agregado ningúna víctima</td></tr>`);
  }
}

function cancelarVictima(){
  $('#divVictima').addClass('d-none');
  victima_edit = '-';
}

function agregarVictima(){
  
  const victima = {
    estatus:1,
    victima:$('#victima').val(),
    desc_victima:$('#victima option:selected').text(),
  };

  if( victima_edit != '-' ){
    victima.id = victima_edit.id;
    victimas[victima_edit.index] = victima;
  }else{
    victima.id = 0;
    victimas.push(victima);
  }
  
  $('#victimas .square-8 ').remove();
  $('#victimas').append('<span class="square-8 bg-danger mg-r-5 mg-l-5 rounded-circle"></span>');
  $('#divVictima').addClass('d-none');
  victima_edit = '-';
  showVictimas();
}

function eliminarVictima(index,id){
  if( id == 0 ){
    victimas = victimas.filter((victima,index_victima)=>{
      if( index_victima != index )
        return victima;
    });
  }else{
    victimas = victimas.map((victima,index_victima)=>{
      if( index_victima == index )
        victima.estatus = 0;
      return victima;
    })
  }
  showVictimas();
}

function editarVictima(index, id){

  victima_edit = {index, id};
  $('#victima').val(victimas[index].victima).trigger('change');
  $('#divVictima').removeClass('d-none');

}

// ASESORES JURÍDICOS

function nuevoAsesor(){
  $('#asesorJuridico').val('').trigger('change');
  $('#victimasAsesor').html('');
  $(victimas).each(function(index, victima){
    $('#victimasAsesor').append(`<label class="ckbox mg-l-10"><input type="checkbox" class="victima_asesor" value="${victima.victima}"><span>${victima.desc_victima}</span></label><br>`);
  });
  $('#divAsesor').removeClass('d-none');
}

function agregarAsesor(){

  if( $('#asesorJuridico').val() == ''){
    $('span[aria-labelledby="select2-fechaAudienciaSentencia-container"]').addClass('error');
    return false;
  }
    

  let ids_victimas_asesorados = '';
  $('.victima_asesor').each(function(index){
    if($(this).is(':checked')){
      if(index > 0)
        ids_victimas_asesorados=ids_victimas_asesorados.concat(','+$(this).val());
      else
        ids_victimas_asesorados=ids_victimas_asesorados.concat($(this).val());
    }
  }); 
    
  const asesor = {
    estatus:1,
    asesor:$('#asesorJuridico').val(),
    desc_asesor:$('#asesorJuridico option:selected').text(),
    ids_victimas_asesorados
  };

  if( asesor_edit != '-' ){
    asesor.id = asesor_edit.id;
    asesores[asesor_edit.index] = asesor;
  }else{
    asesor.id = 0;
    asesores.push(asesor);
  }

  $('#asesores_juridicos .square-8 ').remove();
  $('#asesores_juridicos').append('<span class="square-8 bg-danger mg-r-5 mg-l-5 rounded-circle"></span>');
  asesor_edit = '-';
  $('#divAsesor').addClass('d-none');
  showAsesores();
}

function cancelarAsesor(){
  $('#asesorJuridico').val('').trigger('change');
  $('#divAsesor').addClass('d-none');
  asesor_edit = '-';
}

function showAsesores(){
  
  $('#bodyAsesores').html('');
  if( asesores.length && asesores.find( asesor => asesor.estatus == 1 ) != undefined ){
    $(asesores).each(function(index,asesor){
      const {desc_asesor,id, estatus} = asesor;
      if( estatus )
        $('#bodyAsesores').append(`
        <tr>
          <td>
            <i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar víctima" onclick="eliminarAsesor(${index},${id})"></i>
            <i class="fa fa-pencil-square-o mg-l-10" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar víctima" onclick="editarAsesor(${index},${id})" style="color:#848F33"></i>
          </td>
          <td>
            ${desc_asesor}
          </td>
        </tr>
      `);
    });
  }else{
    $('#bodyAsesores').append(`<tr><td class="tx-danger tx-center" colspan="2">No ha agregado ningún asesor</td></tr>`);
  }
}

function eliminarAsesor(index,id){
  if( id == 0 ){
    asesores = asesores.filter((asesor,index_asesor)=>{
      if( index_asesor != index )
        return asesor;
    });
  }else{
    asesores = asesores.map((asesor,index_asesor)=>{
      if( index_asesor == index )
        asesor.estatus = 0;
      return asesor;
    })
  }
  showAsesores();
}

function editarAsesor(index,id){
  asesor_edit = {index,id};
  $('#asesorJuridico').val(asesores[index].asesor).trigger('change');
  victimas_asesor = asesores[index].ids_victimas_asesorados.split(',');
  $('#victimasAsesor').html('');
  $(victimas).each(function(index, victima){
    if(victimas_asesor.includes(victima.victima.toString()))
      $('#victimasAsesor').append(`<label class="ckbox mg-l-10"><input type="checkbox" class="victima_asesor" value="${victima.victima}" checked><span>${victima.desc_victima}</span></label><br>`);
    else
      $('#victimasAsesor').append(`<label class="ckbox mg-l-10"><input type="checkbox" class="victima_asesor" value="${victima.victima}"><span>${victima.desc_victima}</span></label checked><br>`);
  });
  $('#divAsesor').removeClass('d-none');
}

// MINISTERO PÚBLICO

function nuevoMinisterioPublico(){

  $('#ministerioPublico').val('').trigger('change');
  $('#divMinisterioPublico').removeClass('d-none');
}

function agregarMinisterioPublico(){
  
  if( $('#ministerioPublico').val() == ''){
    $('span[aria-labelledby="select2-ministerioPublico-container"]').addClass('error');
    return false;
  }
    
  const ministerio_publico = {
    estatus:1,
    ministerio_publico:$('#ministerioPublico').val(),
    ministerio_publico_desc:$('#ministerioPublico option:selected').text(),
  };

  if( ministerio_publico_edit != '-' ){
    ministerio_publico.id = ministerio_publico_edit.id;
    ministerios_publico[ministerio_publico_edit.index] = ministerio_publico;
  }else{
    ministerio_publico.id = 0;
    ministerios_publico.push(ministerio_publico);
  }

  $('#ministerio_publico .square-8 ').remove();
  $('#ministerio_publico').append('<span class="square-8 bg-danger mg-r-5 mg-l-5 rounded-circle"></span>');
  ministerio_publico_edit = '-';
  $('#divMinisterioPublico').addClass('d-none');
  showMinisterioPublico();
}

function showMinisterioPublico(){
  
  $('#bodyMinisterioPublico').html('');
  if( ministerios_publico.length && ministerios_publico.find( ministerio_publico => ministerio_publico.estatus == 1 ) != undefined ){
    $(ministerios_publico).each(function( index, ministerio_publico ){
      const {ministerio_publico_desc,id, estatus} = ministerio_publico;
      if( estatus )
        $('#bodyMinisterioPublico').append(`
        <tr>
          <td>
            <i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar ministerio público" onclick="eliminarMinisterioPublico(${index},${id})"></i>
            <i class="fa fa-pencil-square-o mg-l-10" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar ministerio público" onclick="editarMinisterioPublico(${index},${id})" style="color:#848F33"></i>
          </td>
          <td>
            ${ministerio_publico_desc}
          </td>
        </tr>
      `);
    });
  }else{
    $('#bodyMinisterioPublico').append(`<tr><td class="tx-danger tx-center" colspan="2">No ha agregado ningún ministerio público</td></tr>`);
  }
}

function eliminarMinisterioPublico(index,id){
  if( id == 0 ){
    ministerios_publico = ministerios_publico.filter( ( ministerio_publico, index_ministerio_publico ) => {
      if( index_ministerio_publico != index )
        return ministerio_publico;
    });
  }else{
    ministerios_publico = ministerios_publico.map( ( ministerio_publico, index_ministerio_publico ) => {
      if( index_ministerio_publico == index )
        ministerio_publico.estatus = 0;
      return ministerio_publico;
    })
  }
  showMinisterioPublico();
}


function editarMinisterioPublico(index,id){
  ministerio_publico_edit = { index, id };
  $('#ministerioPublico').val(ministerios_publico[index].ministerio_publico).trigger('change');
  $('#divMinisterioPublico').removeClass('d-none');
}

// AUDIENCIAS DVD

function agregarFechaDVD(){
  $('.error').removeClass('error');
  if( $('#fechaAudienciaDVD').val() == '' || $('#fechaAudienciaDVD').val() == null ){
    $('span[aria-labelledby="select2-fechaAudienciaDVD-container"]').addClass('error');
    return false;
  }else{
    const audiencia_dvd = {
      id : $('#fechaAudienciaDVD').val(),
      fecha : $('#fechaAudienciaDVD option:selected').text(),
      estatus : 1,
    };
  
    audiencias_dvd.push(audiencia_dvd);
    $('#fechaAudienciaDVD').val('').trigger('change');
    showAudienciasDVD();
  }
  
}

function showAudienciasDVD(){
  
  $('#bodyAudienciaDVD').html('');

  if( audiencias_dvd.length && audiencias_dvd.find( audiencia => audiencia.estatus == 1 ) != undefined ) {
    $( audiencias_dvd ).each( function( index, audiencia ) {
      if( audiencia.estatus ) {
        $('#bodyAudienciaDVD').append(`
          <tr>
            <td>
              <i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar audiencia" onclick="eliminarAudienciaDVD(${index})"></i>
            </td>
            <td>
              ${audiencia.fecha}
            </td>
          <tr>  
        `);
      }
    });
  }else{
    $('#bodyAudienciaDVD').append(`<tr><td class="tx-danger tx-center" colspan="2">No ha agregado ningúna audiencia</td></tr>`);
  }
}

function eliminarAudienciaDVD( index ){

  audiencias_dvd = audiencias_dvd.filter( ( audiencia, index_audiencia ) => {
    if( index_audiencia != index )
      return audiencia;
  });

  showAudienciasDVD();
}

// BILLETES

function agregarBilleteRemision(){

  $('.error').removeClass('error');

  if( expVacio.test($('#noBillete').val()) ){
    $('#noBillete').addClass('error');
    return false;
  }

  if( expVacio.test( $('#montoBillete').val().replace( '$','' ) ) ){
    $('#montoBillete').addClass('error');
    return false;
  }

  const billete_remision = {
    id: 0,
    estatus : 1,
    numero_billete : $('#noBillete').val(),
    monto : $('#montoBillete').val().replace( '$','' ).replace(/,/g,''),
  }

  billetes_remision.push(billete_remision);
  $('#noBillete').val('');
  $('#montoBillete').val('');
  //console.log(billetes_remision);
  showBilletesRemision();
}

function showBilletesRemision(){

  $('#bodyBilletesRemision').html('');

  if( $('input[name="billete_remision"]:checked').val() == 'si' ) {
    if( billetes_remision.length && billetes_remision.find( billete => billete.estatus == 1 ) != undefined ) {
      $( billetes_remision ).each( function( index, billete ) {
        const monto = toMoney(billete.monto);
        if( billete.estatus ) {
          $('#bodyBilletesRemision').append(`
            <tr>
              <td>
                <i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar billete" onclick="eliminarBilleteRemision(${index})"></i>
              </td>
              <td style="text-align: end; padding-right: 10%;">
                ${billete.numero_billete}
              </td>
              <td style="text-align: end; padding-right: 10%;">
                ${monto}
              </td>
            <tr>  
          `);
        }
      });
    }else{
      $('#bodyBilletesRemision').append(`<tr><td class="tx-danger tx-center" colspan="3">No ha agregado ningún billete</td></tr>`);
    }
  }else{
    $('#bodyBilletesRemision').append(`<tr><td class="tx-center font-italic" colspan="3">No aplica</td></tr>`);
  }
}

function eliminarBilleteRemision( index ){
  
  if( billetes_remision[index].id == 0 ){
    
    billetes_remision = billetes_remision.filter( ( billete, index_billete ) => {
      if( index_billete != index )
        return billete;
    });

  }else{

    billetes_remision = billetes_remision.map( ( billete, index_billete ) => {
      if ( index_billete == index )
        billete.estatus = 0;
      return billete;
      
    });

  }

  showBilletesRemision();
}

function billeteRemision(){
  if ( $('input[name="billete_remision"]:checked').val() == 'no' ) {
    $('#noBillete').val('').attr('disabled', true);
    $('#montoBillete').val('').attr('disabled', true);
    $('#btnBilletes').attr('disabled', true);
  }else{
    $('#noBillete').val('').removeAttr('disabled');
    $('#montoBillete').val('').removeAttr('disabled');
    $('#btnBilletes').removeAttr('disabled');
  }
  showBilletesRemision();
}

// OBJETOS

function agregarObjeto() {
  
  $('.error').removeClass('error');

  if( expVacio.test( $('#descripcionObjeto').val() ) ) {
    $('#descripcionObjeto').addClass('error');
    return false;
  }

  if( expVacio.test( $('#ubicacionObjeto').val() ) ) {
    $('#ubicacionObjeto').addClass('error');
    return false;
  }

  const objeto = {
    id:0,
    estatus : 1,
    objeto_descripcion : $('#descripcionObjeto').val(),
    objeto_ubicacion : $('#ubicacionObjeto').val()
  }

  objetos_remision.push(objeto);
  $('#descripcionObjeto').val('');
  $('#ubicacionObjeto').val('');
  showObjetos();
}

function showObjetos(){
  //console.log(objetos_remision)
  $('#bodyObjetos').html('');

  if( $('input[name="objeto_asegurado"]:checked').val() == 'si' ) {
    if( objetos_remision.length && objetos_remision.find( objeto => objeto.estatus == 1 ) != undefined ) {
      $( objetos_remision ).each( function( index, objeto ) {
        if( objeto.estatus ) {
          $('#bodyObjetos').append(`
            <tr>
              <td>
                <i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar objeto" onclick="eliminarObjeto(${index})"></i>
              </td>
              <td>
                ${objeto.objeto_descripcion}
              </td>
              <td>
                ${objeto.objeto_ubicacion}
              </td>
            <tr>  
          `);
        }
      });
    }else{
      $('#bodyObjetos').append(`<tr><td class="tx-danger tx-center" colspan="3">No ha agregado ningún objeto</td></tr>`);
    }
  }else{
    $('#bodyObjetos').append(`<tr><td class="tx-center font-italic" colspan="3">No aplica</td></tr>`);
  }
}

function eliminarObjeto( index ){

  if ( objetos_remision[index].id == 0 ){

    objetos_remision = objetos_remision.filter( ( objeto, index_objeto ) => {
      if( index_objeto != index )
        return objeto;
    });
  
  }else {

    objetos_remision = objetos_remision.map( ( objeto, index_objeto ) => {
      if (index_objeto == index )
        objeto.estatus = 0;
      return objeto;
    });
  }

  
  showObjetos();
}

function objetoAsegurado(){

  if( $('input[name="objeto_asegurado"]:checked').val() == 'si' ) {
    $('#descripcionObjeto').removeAttr('disabled').val('');
    $('#ubicacionObjeto').removeAttr('disabled').val('');
    $('#btnObjetos').removeAttr('disabled');
  }else{
    $('#descripcionObjeto').attr('disabled', true).val('');
    $('#ubicacionObjeto').attr('disabled', true).val('');
    $('#btnObjetos').attr('disabled', true);
  }

  showObjetos();
}

function validaInformacionComplementaria(){
  $('.error').removeClass('error');

  if ( !informacion_complementaria.documentos_remision_ue.copia_certificada_sentencia ) {
    error('Datos Incompletos', 'No ha agregado la copia certificada de la sentencia', 'modalRemision');
    $('#copia_certificada_sentencia').parent().addClass('error');
    return false; 
  }

  if ( !informacion_complementaria.documentos_remision_ue.copia_certificada_auto ) {
    error('Datos Incompletos', 'No ha agregado la copia certificada de auto donde se reconoce la ejecución de la setencia aludida', 'modalRemision');
    $('#copia_certificada_auto').parent().addClass('error');
    return false; 
  }

  if ( !informacion_complementaria.documentos_remision_ue.acta_minima ) {
    error('Datos Incompletos', 'No ha agregado el acta mínima de la audiencia que contenga la lectura y explicación de sentencia', 'modalRemision');
    $('#acta_minima').parent().addClass('error');
    return false; 
  }

  if ( expVacio.test( $('#numeroDVD').val() )) {
    error('Datos Incompletos', 'No ha indicado el número de DVDs de audiencias a remitir', 'modalRemision');
    $('#numeroDVD').addClass('error');
    return false; 
  }

  if ( !audiencias_dvd.length || audiencias_dvd.find( audiencia => audiencia.estatus == 1 ) == undefined ) {
    error('Datos Incompletos', 'No ha indicado las fechas de las audiencias que se remiten en los DVD´s', 'modalRemision');
    $('#span[aria-labelledby="select2-fechaAudienciaDVD-container"]').addClass('error');
    return false; 
  }

  if ( $('input[name="billete_remision"]:checked') == undefined ) {
    error('Datos Incompletos', 'No ha indicado si se remite algún billete de depósito', 'modalRemision');
    $('#privadoLibertadDiv').addClass('error');
    return false; 
  }

  if ( $('input[name="objeto_asegurado"]:checked') == undefined ) {
    error('Datos Incompletos', 'No ha indicado si cuenta con información respecto a objetos asegurados', 'modalRemision');
    $('#divObjeto').addClass('error');
    return false; 
  }

  return true
}

function suspensionCondicionalPena( suspension ) {
  //console.log(suspension);
  if( suspension == 'si' ) {

    $('.suspension_condicional_pena').removeClass('d-none');

  } else {
    $('.suspension_condicional_pena').addClass('d-none');
  }
    
  $('#montoGarantia').val('0');
}

function agregarSuspCond( pena, e ) {

  penas[pena].suspension_condicional = $(e).is(':checked') == true ? '1' : '0';
  
}