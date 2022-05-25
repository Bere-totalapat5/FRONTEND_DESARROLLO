let b_cargando = 0,
  documentosValor = [];

async function leeDocumento ( input ) {
  
  if(input.files[0].size > 5242880)
    return error('Archivo inválido', 'El archivo no debe terner un tamaño mayor a 5 MB', '','modalDevolucion');
  
  const file =  $('#archivo_doc').val(),
    ext = file.substring(file.lastIndexOf(".")).toLowerCase();
  
  if( ext!='' ){
      
    if ( ext != '.pdf') 
      return error('Archivo inválido', 'Solo puede agregar archivos PDF', '','modalDevolucion');

    if( input.files && input.files[0] ) {
        
      b_cargando ++;
      $('#divDocumentos').append(`<div class="col-md-6">${doc_loadind}</div>`);
      const dataDoc = await datosDoc(input, ext);
      documentosValor.push( dataDoc );
      $('#archivo_doc').val('');
      mostrarDocumentos();
      b_cargando --;
    }
  }
  
}

function mostrarDocumentos() {

  $('#divDocumentos').html('');
  $( documentosValor ).each( function( index, dataDoc) {
    console.log( dataDoc );
    if ( dataDoc.estatus == 1 ){
      $('#divDocumentos').append(`
      <div style="padding-top: 13px;" class="col-md-6">
        <a href="javascript:void(0)" ondblclick="abrirDocumento(${index}, 1)" class="d-none d-md-inline-flex">
          <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
        </a>
        <a href="${dataDoc.url}" target="_blank" class="d-inline-flex d-md-none">
          <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
        </a>
        <a href="javascript:void(0)" onclick="eliminarDocumento(${index})" class="mg-l-auto" style="position: absolute;">
          <i class="fa fa-times-circle tx-danger btn-cancel" aria-hidden="true" style="font-size:1rem;padding-top:4px;position: relative;top: -13px;"></i>
        </a>
        <label class="d-block">${dataDoc.nombre_archivo}</label>
      </div>`);
    }
  });

}

function eliminarDocumento( index , id = '-') {

  if( id == '-' ){
    documentosValor = documentosValor.filter((documento, index_doc) => {
      if( index_doc != index )
        return documento;
    });
  }else{
    documentosValor = documentosValor.map((documento, index_doc) =>{
      if( index_doc == index )
        documento.estatus = 0;
        return documento;
    })
  }

  mostrarDocumentos();
}

function datosDoc( input = '', ext = '' ){
  return new Promise( resolve => {
    let icon;
    switch (ext){
      case '.pdf':
       icon = "fa-file-pdf-o";
        break;
      case '.jpg':
      case '.png':
      case '.JPEG ':
       icon = "fa-file-image-o";
        break;
      case '.doc':
      case '.docx': 
        icon = "fa-file-word-o";
        break;
      case '.txt': 
        icon = "fa-file-text";
        break;
      default:
        icon='fa-question';
    }

    // const {data, nombre_archivo, id} = documentos_remision_ue[documento];
    const nombre_archivo = normalize((input.files[0].name).replace(ext,'').replace(ext.toLocaleUpperCase(),'')) + ext,
          tamanio_archivo = input.files[0].size;
    
    form = new FormData($("#cargarDocumento")[0]);
    form.append('ext', ext);
    form.append('origen', 'b64');
    form.append('nombre_archivo', nombre_archivo);
    form.append('tamanio', tamanio_archivo);

    $.ajax({
      method: 'POST',
      url: '/public/vista_previa',
      data:form,
      processData: false,
      contentType: false,
      success: function(url){
        const dataDoc = {
                id_documento : 0,
                extension_archivo: ext,
                nombre_archivo,
                tamanio_archivo,
                icon,
                url,
                estatus: 1
              };
        resolve(dataDoc);
      }
    });
    
  });
}


function abrirDocumento( documento , devolucion = '') {
  
    const { url, nombre_archivo } = documentosValor[documento];

    if( devolucion == '' ) {
      $('#nombreDocumento').html( `${nombre_archivo}` );
      $('#objectDocumento').html(`<object type="application/pdf" data="${url}" style="height: 80vh; width: 100%;"></object>`);
      $('#modalDocumentos').modal('hide');
      abreModal('modalDocumento',400);
    }else{
      $('#nombreDocumentoDevolucion').html( `${nombre_archivo}` );
      $('#objectDocumentoDevolucion').html(`<object type="application/pdf" data="${url}" style="height: 80vh; width: 100%;"></object>`);
      $('#modalDevolucion').modal('hide');
      abreModal('modalDocumentoDevolucion',400);
    }
    

}

function abreModal(modal, time=0){
  setTimeout(function(){
    $('#'+modal).modal('show');
  },time);
}

function encode_utf8(s) {
  return unescape(encodeURIComponent(s));
}

function decode_utf8(s) {
  return decodeURIComponent(escape(s));
}

const doc_loadind = `    
    <div class="sk-circle">
      <div class="sk-circle1 sk-child"></div>
      <div class="sk-circle2 sk-child"></div>
      <div class="sk-circle3 sk-child"></div>
      <div class="sk-circle4 sk-child"></div>
      <div class="sk-circle5 sk-child"></div>
      <div class="sk-circle6 sk-child"></div>
      <div class="sk-circle7 sk-child"></div>
      <div class="sk-circle8 sk-child"></div>
      <div class="sk-circle9 sk-child"></div>
      <div class="sk-circle10 sk-child"></div>
      <div class="sk-circle11 sk-child"></div>
      <div class="sk-circle12 sk-child"></div>
    </div>
  
`;