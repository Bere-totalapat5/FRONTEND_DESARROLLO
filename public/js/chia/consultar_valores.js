let valores = [];

$(document).ready( function() {
    obtener_valores();
});



function obtener_valores(pagina=1,registros=10) {
  $('#modal_loading').modal('show');
  $.ajax({
    method: 'GET',
    url: '/public/obtener_valores_chia',
    data:{
      pagina,
      registros,
      folio: $('#folio').val(),
      tipo_valor: $('#tipoValor').val(),
      fecha_expedicion: $('#fechaExpedicion').val(),
      fecha_exhibicion: $('#fechaExhibicion').val(),
      expediente : $('#numeroExpediente').val(),
      filtro_instancia : $('#filtro_instancia').val(),
    },
    success: function(response){
      $('#bodyValores').html('');
      if( response.status == 100 ) {
        valores = response.response;
        $(valores).each( function( index, valor ) {
          
          const { CveFolio, Expedient, Description, Disposicion, ExpDate, ExhDate, Amount, Moneda, Depositor, DevDate, beneficiario, institucion, usuario } = valor;

          const dev = `<a href="javascript:void(0)" onclick="devolucion(${index})" class="pd-5 icon" data-toggle="tooltip" data-placement="top" title="Devolución"><i class="fa fa-undo" aria-hidden="true"></i></a>`,
            edit = `<a href="javascript:void(0)" onclick="editar(${index})" class="pd-5 icon" data-toggle="tooltip" data-placement="top" title="Edición"><i class="fa fa-pencil" aria-hidden="true"></i></a>`,
            trans = `<a href="javascript:void(0)" onclick="trasnferir(${index})" class="pd-5 icon" data-toggle="tooltip" data-placement="top" title="Transferir"><i class="fa fa-share-square-o" aria-hidden="true"></i></a>`,
            docs = `<a href="javascript:void(0)" onclick="documentos(${index})" class="pd-5 icon" data-toggle="tooltip" data-placement="top" title="Documentos"><i class="fa fa-files-o" aria-hidden="true"></i></a>`,
            origen_chia = usuario >= 1600000000000 ?'<span class="square-8 mg-r-5 rounded-circle" data-toggle="tooltip" data-placement="top" title="Registrado en sistema penal" style="background-color: #D6E7B0"></span>' : '';

          const tr = `
            <tr>
              <td class="acciones tx-center">
                ${dev}
                ${edit}
                ${trans}
                ${docs}
              </td>
              <td class="folio">${CveFolio} ${origen_chia}</td>
              <td class="expediente">${Expedient}</td>
              <td class="estatus">${Description}</td>
              <td class="instancia">${Disposicion}</td>
              <td class="fecha_ingreso">${formatoFecha(ExpDate)}</td>
              <td class="fecha_egreso">${formatoFecha(ExhDate)}</td>
              <td class="fecha_devolucion">${DevDate==null?'<span class="font-italic mg-l-30">N/A</span>':formatoFecha(DevDate)}</td>
              <td class="importe">${toMoney(Amount)}</td>
              <td class="moneda">${Moneda}</td>
              <td class="depositante  tx-uppercase">${Depositor}</td>     
              <td class="beneficiario">${beneficiario==undefined?'':beneficiario}</td>         
              <td class="institucion">${institucion==undefined?'':institucion}</td>         
            </tr>
          `;
          $('#bodyValores').append(tr);
        });

        const anterior = pagina==1?1:pagina-1,
          totalPaginas = response.paginacion.paginas_totales,
          siguiente = pagina+1>=totalPaginas?totalPaginas:pagina+1;

        $('.anterior').attr('onclick',`obtener_valores(${anterior})`);
        $('.pagina').html(pagina);
        $('.total-paginas').html(totalPaginas);
        $('.siguiente').attr('onclick',`obtener_valores(${siguiente})`);
        $('.ultima').attr('onclick',`obtener_valores(${totalPaginas})`);

      }else{
        $('#bodyValores').append(`<tr><td class="tx-danger text-center" colspan="9">Sin datos registrados</td</tr>`);
      }

      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },400);
    }
  });
}

function devolucion( index ) {
  documentosValor = [];
  $('#divDocumentos').html('');
  const { CveFolio, CveValueStatus } = valores[index];

  $('#btnDescargaFormatoDevolucion').attr('onclick', `descargarFormato(${index})`);
  $('#folioDev').html(CveFolio);
  $('#operacion').val(CveValueStatus).trigger('change');
  $('#conceptoDevolucion').val('').trigger('change');
  $('#compareciente').val('');
  $('#identificacion').val('');
  $('#juezAutoriza').val('').trigger('change');
  $('#modalDevolucion').modal('show');
  $('#btnDevolucion').attr('onclick',`devolverValor(${index})`);

}

function devolverValor( index ) {
  $('.error').removeClass('error');
  if( $('#operacion').val() == '' || $('#operacion').val() == null )
    return error('Datos incompletos', 'El campo "Operación" es obligatorio', 'select2-operacion-container', 'modalDevolucion');

  if( $('#conceptoDevolucion').val() == '' || $('#conceptoDevolucion').val() == null )
    return error('Datos incompletos', 'El campo "Concepto de devolución" es obligatorio', 'select2-conceptoDevolucion-container', 'modalDevolucion');

  if( !expRegFecha.test( $('#fechaDevolucion').val() ) ) 
    return error('Datos incompletos', 'El campo "Fecha de devolución" es obligatorio', 'fechaDevolucion', 'modalDevolucion');

  if( expVacio.test( $('#compareciente').val() ) ) 
    return error('Datos incompletos', 'El campo "Compareciente" es obligatorio', 'compareciente', 'modalDevolucion');

  if( expVacio.test( $('#identificacion').val() ) ) 
    return error('Datos incompletos', 'El campo "Identificación" es obligatorio', 'identificacion', 'modalDevolucion');

  if( $('#juezAutoriza').val() == '' || $('#juezAutoriza').val() == null )
    return error('Datos incompletos', 'No ha indicado el Juez que autoriza', 'select2-juezAutoriza-container', 'modalDevolucion');

  if( documentosValor.length < 1 )
    return error('Datos incompletos', 'No ha adjuntado ningún documento', '', 'modalDevolucion');

  const { CveFolio, Expedient, valor } = valores[index];
  $('#modal_loading').modal('show');
  $.ajax({
    method: 'POST',
    url: '/public/actualizar_devolucion',
    data: { 
      valor,
      CveFolio,
      operacion: $('#operacion').val(),
      concepto_devolucion: $('#conceptoDevolucion').val(),
      fecha_devolucion: $('#fechaDevolucion').val(),
      Expedient,
      compareciente: $('#compareciente').val(),
      identificacion: $('#identificacion').val(),
      juez: $('#juezAutoriza').val(),
      documentosValor,
    },
    success: function(response) {
      if( response.status == 100 ){
        const pagina = $('.pagina').text();
        obtener_valores(parseInt(pagina));
        $('#tituloSucces').html('Actualizado');
        $('#modal-success-titulo').html(response.message);
        $('#modalSuccess').modal('show');
        // var link = document.createElement('a');
        // link.href = response.url;
        // link.download = 'devolucion_'+CveFolio+'.docx';
        // link.click();
      }else{
        error('Error', response.message, '', 'modalDevolucion');
      }
      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },500);
    }
  });

}

function descargarFormato( index ) {
  
  const { CveFolio, Expedient, valor } = valores[index];

  $.ajax({
    method: 'GET',
    url: '/public/formato_devolucion',
    data: { 
      valor,
      CveFolio,
      operacion: $('#operacion').val(),
      concepto_devolucion: $('#conceptoDevolucion').val(),
      fecha_devolucion: $('#fechaDevolucion').val(),
      Expedient,
      compareciente: $('#compareciente').val(),
      identificacion: $('#identificacion').val(),
      juez: $('#juezAutoriza').val(),
     },
    success: function( response ) {
      
      if( response.status ) {

        var link = document.createElement('a');
        link.href = response.url;
        link.download = 'devolucion_'+CveFolio+'.docx';
        link.click();
      
      }else{

        error('Error en formato', response.message , '', 'modalDevolucion');

      }
      
    }
  });
}

function editar( index ) {
  
  const { CveTypeCertificate, CveFolio, Expedient, CveCurrency, Amount, ExpDate, ExhDate, CveConceptExh, Depositor, CveAtDisposalOf, DevDate, CveConceptDev, beneficiario, institucion, CveBank } = valores[index];

  $('#tipoValorE').val(CveTypeCertificate).trigger('change');
  $('#folioE').val(CveFolio);
  $('#numeroExpedienteE').val(Expedient);
  $('#monedaE').val(CveCurrency).trigger('change');
  $('#importeE').val(toMoney(Amount));
  $('#fechaExpedicionE').val(formatoFecha(ExpDate,"dd-mm-yy", 'n'));
  $('#fechaExhibicionE').val(formatoFecha(ExhDate,"dd-mm-yy", 'n'));
  $('#conceptoE').val(CveConceptExh).trigger('change');
  $('#nombreDepositanteE').val(Depositor);
  $('#disposicionE').val(CveAtDisposalOf).trigger('change');
  $('#fechaDevolucionE').val(DevDate==null?'':formatoFecha(DevDate,"dd-mm-yy", 'n'));
  $('#conceptoDevolucionE').val(CveConceptDev).trigger('change');
  $('#beneficiarioE').val(beneficiario==null?'':beneficiario);
  $('#institucionE').val(institucion==null?'':institucion);
  $('#banco_e').val(CveBank).trigger('change');
  $('#btnEditar').attr('onclick', `guardarEdicion(${index})`);
  $('#modalEdicion').modal('show');

}

function guardarEdicion( index ) {
  $('#modalEdicion').modal('hide');
  $('#modal_loading').modal('show');
  const { CveFolio, valor } = valores[index];

  $.ajax({
    method: 'POST',
    url: '/public/actualizar_valor_chia',
    data: {
      valor,
      CveFolio,
      tipo_valor: $('#tipoValorE').val(),
      moneda: $('#monedaE').val(),
      importe: $('#importeE').val().replace( '$','' ).replace(/,/g,''),
      depositante: $('#nombreDepositanteE').val(),
      carpeta_judicial: $('#numeroExpedienteE').val(),
      banco: $('#bancoE').val(),
      disposicion: $('#disposicionE').val(),
      concepto: $('#conceptoE').val(),
      fecha_expedicion: $('#fechaExpedicionE').val(),
      fecha_exhibicion: $('#fechaExhibicionE').val(),
      fecha_devolucion: $('#fechaDevolucionE').val(),
      concepto_devolucion: $('#conceptoDevolucionE').val(),
      beneficiario: $('#beneficiarioE').val(),
      institucion: $('#institucionE').val()
    },
    success: function( response ) {
      if( response.status == 100 ){
        const pagina = $('.pagina').text();
        obtener_valores(parseInt(pagina));
        $('#tituloSucces').html('Actualizado');
        $('#modal-success-titulo').html(response.message);
        $('#modalSuccess').modal('show');
      }else{
        error('Error', response.message, '','modalEdicion');
      }
      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },400);
    }
    
  });
}

function trasnferir( index ) {

  const { CveFolio, CveAtDisposalOf } = valores[index];

  $('#folioTransfir').html(CveFolio);
  $('#disposicionT').val(CveAtDisposalOf).trigger('change');
  $('#btnTransferir').attr('onclick', `transferirValor(${index})`);
  $('#modalTransferencia').modal('show');

}

function transferirValor( index ) {
  $('#modalTransferencia').modal('hide');
  $('#modal_loading').modal('show');
  const { CveFolio, valor } = valores[index];

  if( $('#disposicionT').val() == null || $('#disposicionT').val() == '' )
    return error('Datos incompletos', 'Debe elegir la instancia a la cual se transferirá el valor', '', 'modalTransferencia');

  $.ajax({
    method: 'POST',
    url: '/public/transferir_valor_chia',
    data:{
      valor,
      CveFolio,
      disposicion: $('#disposicionT').val(),
    },
    success: function( response ) {
      if( response.status == 100 ){
        const pagina = $('.pagina').text();
        obtener_valores(parseInt(pagina));
        $('#tituloSucces').html('Actualizado');
        $('#modal-success-titulo').html(response.message);
        $('#modalSuccess').modal('show');
      }else{
        error('Error', response.response, '','modalTransferencia');
      }
      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },400);
    }
  });
}

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

function tipoValorE() {
  
  if( $('#tipoValorE').val() == '2' ) {
    $('#bancoE').parent().removeClass('d-none');
  }else{
    $('#bancoE').parent().addClass('d-none');
    $('#bancoE').val('').trigger('change');
  }

}

function error( title = '', message = '', campo = '', modal = '' ){
  $('#titleError').html(title);
  $('#messageError').html(message);

  if(modal != '')
    $('#'+modal).modal('hide'); 

  if(campo != '')
    $('#'+campo).addClass('error');
  
  $('#modalError').modal('show');
  
  if ( modal != '' )
    $('#btnError').attr('onclick', `abreModal('${modal}')`);

  return false;
}

function abreModal( modal, time=0 ){
  setTimeout(function(){
    $('#'+modal).modal('show');
  },time);
}

function documentos( index ) {
  const { valor, url } = valores[index];
  
  if ( valor == undefined ){
    $('#lista_docs').html(`<div class="col-12"><h5 class="tx-danger">El valor no se encuentra registrado en el sistema actual</h5></div>`);
    $('#modalDocumentos').modal('show');
  }

  documentos_valor = [];
  $('#lista_docs').html('');
  $.ajax({
    method: 'GET',
    url: '/public/ver_documento_chia',
    data:{valor},
    success: function ( response ) {
      if ( response.status == 100 ) {
        $( response.response ).each( function( index, doc ) {
          documentosValor = response.response;
          console.log(documentosValor)
          icon = '';
          switch ( doc.extension_archivo ){
            case 'pdf':
             icon = "fa-file-pdf-o";
              break;
            case 'jpg':
            case 'png':
            case 'JPEG ':
             icon = "fa-file-image-o";
              break;
            case 'doc':
            case 'docx': 
              icon = "fa-file-word-o";
              break;
            case 'txt': 
              icon = "fa-file-text";
              break;
            default:
              icon = 'fa-question';
          }

          $('#lista_docs').append(`
            <div style="padding-top: 13px;" class="col-md-6">
              <a href="javascript:void(0)" ondblclick="ver_documento_chia(${valor}, ${index})" class="d-none d-md-inline-flex">
                <i class="fa ${icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
              </a>
              <a href="/public/ver_documento_chia/${valor}/${doc.id_documento}/1" target="_blank" class="d-inline-flex d-md-none">
                <i class="fa ${icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
              </a>
              <label class="d-block">${doc.nombre_archivo}</label>
            </div>
          `);
        });

        $('#modalDocumentos').modal('show');
      }else{
        $('#lista_docs').html(`<div class="col-12"><h5 class="tx-danger">${response.message}</h5></div>`);
        $('#modalDocumentos').modal('show');
      }
    }
  });
}

function ver_documento_chia( valor, index ) {
  
  const { id_documento, nombre_archivo, url } = documentosValor[index];
  
  if( url != undefined ){

    $('#nombreDocumento').html( `${nombre_archivo}` );
    $('#objectDocumento').html(`<object type="application/pdf" data="${url}" style="height: 80vh; width: 100%;"></object>`);
    $('#modalDocumentos').modal('hide');
    abreModal('modalDocumento',400);

  }else{

    $.ajax({
      method: 'GET',
      url: '/public/ver_documento_chia',
      data:{ valor, id_documento },
      success: function( response ) {
        if( response.status == 100 ) {
          documentosValor[index].url = response.url;
          $('#nombreDocumento').html( `${nombre_archivo}` );
          $('#objectDocumento').html(`<object type="application/pdf" data="${response.url}" style="height: 80vh; width: 100%;"></object>`);
          $('#modalDocumentos').modal('hide');
          abreModal('modalDocumento',400);
        }
      }
    });

  }
}


