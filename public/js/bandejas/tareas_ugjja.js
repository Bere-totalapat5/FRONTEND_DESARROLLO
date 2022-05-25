const tUsuarioCEJE = 26;

function asignacionClave( index ) {
  
  tareaSeleccionada = arrTareas[index];
  $('#subclaveugjems').select2({minimumResultsForSearch: Infinity});
  $('#modalAsignacionclave').modal('show');
  $('#btnResolverClave').attr('onclick', `asignarClaveCarpeta()`);
  
}

async function resolverTareasCEJE() {

  $('#modalAsignacionclave').modal('hide');

  if( $('#subclaveugjems').val() == null || $('#subclaveugjems').val() == '' )
    return error( "Datos incompletos", 'No ha seleccionado la subclave para la carpeta', 'modalAsignacionclave' );
  
  $('#modal_loading').modal('show');
  await verCEJE();

  abreModal('modalDatosTarea',850);

}

async function verCEJE() {

  const { id_tabla_asociada } = tareaSeleccionada;
  const versiones = await obtenerDocumentosRemision( id_tabla_asociada );
  let documentos='<div class="row">';

  $( versiones.response ).each( function( index, version ) {

    switch ( version.extension_archivo ){
      case 'pdf':
        icono = '<i class="fa fa-file-pdf-o mg-r-10" aria-hidden="true" style="font-size:35px;"></i>';
        break;
      case 'jpg':
      case 'png':
      case 'JPEG ':
        icono = '<i class="fa fa-file-image-o mg-r-10" aria-hidden="true" style="font-size:35px;"></i>';
        break;
      default:
        icono = '<i class="fa fa-question mg-r-10" aria-hidden="true" style="font-size:35px;"></i>';
    }

    documentos=documentos.concat(`
      <div class="col-md-3">
        <a href="javascript:void(0)">${icono} ${version.nombre_archivo}</a>
      </div>
      <div class="col-md-9">
        <object data="/obtener_documentos_remision/${id_tabla_asociada}/${version.id_documento}"  id="documentoPDF" width="100%" height="455px"></object>
      </div>
    `);
  });

  documentos = documentos.concat('</div>')

  datosRemision = await obtenerDatosRemision(id_tabla_asociada);

  $('#divTarea').append(`
    <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
      <div id="validacionDatos">
        <div class="form-group">
          <label class="form-control-label">Resolver por:</label>
          <select class="form-control" id="tipoResolucion" name="tipo_resolucion" autocomplete="off">
            <option selected value="">Seleccione una Opción</option>
            <option value="acuerdo">Acuerdo</option>
            <option value="audiencia">Audiencia</option>
          </select>
        </div>
        <div class="card" style="min-height: 481px;">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#divSolicitud" data-toggle="tab">Datos Solicitud</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#divDatosSujeto" data-toggle="tab">Partes Procesales</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#divDocumentos" data-toggle="tab">Documentos</a>
              </li>
            </ul>
          </div><!-- card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="divSolicitud">
                ${datosRemision.infoSolicitud}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDatosSujeto">
                ${datosRemision.elementosPersonas}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDocumentos">
                ${documentos}
              </div><!-- tab-pane -->
            </div><!-- tab-content -->
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      <hr>
      <div id="resolucion" class="d-none">
      <div>
    </form>
  `);

  $('#divButtons').html(`<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguienteCEJE()">Siguiente</button>`);

  $('#tipoResolucion').select2({minimumResultsForSearch: Infinity});

  setTimeout( () => {
    $('#modal_loading').modal('hide');
  },400);
}

async function siguienteCEJE() {

  if( $('#tipoResolucion').val() == '' ||  $('#tipoResolucion').val() == null )
    return error("Error",'Seleccione el tipo de resolución', 'modalRemision');;

  if( $('#tipoResolucion').val() == 'acuerdo' ) {

    $('#steps').append(`<p class="step activo  d-inline-block d-md-flex  mg-r-10" id="step-resolucion"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolver Solicitud</span></p>`);
    const usuarios = await obtenerGrupoTrabajo();
    let jueces = '';
    
    if( juez_ejec != '' && juez_ejec != null)
      jueces = await obtenerJueces( juez_ejec, 1 );
    else
      jueces=await obtenerJueces( tareaSeleccionada.id_juez_promujer );

    $('#resolucion').html(`
      <div class="row mg-t-15 pd-r-10 pd-l-10">
        <div class="col-md-4">
          <label class="rdiobox">
            <input name="doc" type="radio" checked value="subir" class="doc" onchange="tipoDocumento()">
            <span>Subir Documento</span>
          </label>
        </div>
        <div class="col-md-4">
          <label class="rdiobox">
            <input name="doc" type="radio" value="crear" class="doc" onchange="tipoDocumento()">
            <span>Crear Documento en Línea</span>
          </label>
        </div>
        <div class="col-md-4">
          <label class="rdiobox">
            <input name="doc" type="radio" value="delegar" class="doc" onchange="tipoDocumento()">
            <span>Delegar Tarea</span>
          </label>
        </div>
      </div>
      <hr>
      <div style="background: #f8f9fa; padding: 10px; min-height: 470px; border: 1px solid #eee;">
        <div class="row mg-t-30">
          <div id="divAccion" class="col-md-4">
            <div class="form-group">
              <label class="form-control-label">Enviar a:</label>
              <select class="form-control" id="accion" name="accion" autocomplete="off" onchange="firmante()">
                <option  value="firma">FIRMA</option>
              </select>
            </div>
          </div>
          <div class="col-md-4"  id="divFirmante">
            <div class="form-group">
              <label class="form-control-label">Juez Firmante:</label>
              <select class="form-control" id="usuario_destino" name="usuario_destino" autocomplete="off">
                ${jueces}
              </select>
            </div>
          </div>
          <div id="divTipoArchivo" class="col-md-4">
            <div class="form-group">
              <label class="form-control-label">Tipo Archivo:</label>
              <select class="form-control" id="tipoArchivo" name="tipo_archivo" autocomplete="off">
                <option  value="207">ACUERDO</option>
                <option  value="122">AUTO</option>
                <option  value="505">CONSTANCIA</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 d-none" id="divNombreHTML" style="display:none">
            <div class="form-group">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Nombre del documento:</label>
                <input class="form-control" type="text" name="nombre_html" id="nombreHTML" autocomplete="off">
              </div>
            </div>
          </div><!-- col-3 -->
        </div>
        <div class="mg-t-40" id="porDOC">
          <div class="custom-input-file">
            <input type="file" id="archivoDoc" class="input-file" value="" name="archivo_doc" onchange="leeDocumento('archivoDoc')" accept=".doc,.docx">
            <h5 class="px-3 py-3">Arrastre hasta aquí su documento de Word o de clic para adjuntarlo</h5>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div id="docSeleccionado" class="mg-t-40">
              </div>
            </div>
            <div class="col-md-9" id="vistaPreviaDocPDF">

            </div>
          </div>
        </div>
        <div class="d-none" id="porHTML">
          <div id="editor" style="">
            <div id='edit' style="margin-top: 20px; width:100%;">
              ${plantilla}
            </div>
          </div>
        </div>
        <div class="mg-t-40 d-none" id="delegarTarea">
          <h5 class="mg-t-15">Seleccione el usuario a quien se le delegará la tarea</h5>
          <div class="form-group">
            <label class="form-control-label">Usuario:</label>
            <select class="form-control select2-show-search" id="delegar" name="delegar" autocomplete="off">
              <option selected value="" disabled>Elija un usuario</option>
              ${usuarios}
            </select>
          </div>
        </div>
      </div>
    `);

    $('#validacionDatos').addClass('d-none');
    $('#resolucion').removeClass('d-none');
    $('#tipoArchivo').select2({minimumResultsForSearch: Infinity});
    $('#accion').select2({minimumResultsForSearch: Infinity});
    $('#delegar').select2({minimumResultsForSearch: ''});
    $('#usuario_destino').select2({minimumResultsForSearch: ''});
  }

}


function asignarClaveCarpeta( index ) {
  
  const { id_tabla_asociada } = arrTareas[index];
  $('#modal_loading').modal('show');
  
  $.ajax({
    method: 'POST',
    url: '/public/asignar_clave_ugjems',
    data: {
      remision: id_tabla_asociada,
      subclave: $('#subclaveugjems').val(),
    },
    success: function( response ) {
      if( response.status == 100 ) {
        $('#modal-success-titulo').html(response.response);
        $('#modalSuccess').modal('show');
        
      }else{
        error('Error', response.message , 'modalAsignacionclave');
      }
      setTimeout( () => {
        $('#modal_loading').modal('hide');
      },400);
    }
  });
}
