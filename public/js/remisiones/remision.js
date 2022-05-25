let carpeta_remitir;
  // data_carpeta;


async function nuevaRemision( carpeta_id ){

  carpeta_remitir = arrCarpetasJudiciales[carpeta_id];

  const data_carpeta = await new Carpeta( carpeta_remitir.id_carpeta_judicial, carpeta_remitir );
  //console.log(data_carpeta);
  documento_remision = '';

  const {folio_carpeta} = carpeta_remitir;
  $('#formularioRemision').html('');
  $("#labelTipoRemision").html('');
  if ($('#tipoRemision').hasClass("select2-hidden-accessible")) $("#tipoRemision").select2("destroy");
  $("#tipoRemision").html( '<option disabled selected>Seleccione una opción</option>');
  // $("#tipoRemision option").attr('disabled', true);
  $("#lbl-titulo-modal-remision").text(`REMITIR LA CARPETA JUDICIAL: ${folio_carpeta}`);
  $("#modalRemision").modal('show');

  switch ( data_carpeta.tipoCarpeta() ) {
    
    case 'EJEC':
    case 'UGJEMS':
    case 'LN':
      $("#tipoRemision").append( new Option('por Incompetencia', 'incompetencia') );
      break;
    case 'TE':
      $("#tipoRemision").append( new Option('por Incompetencia', 'incompetencia') );
      $("#tipoRemision").append( new Option('a Unidad de Ejecución ', 'unidad_ejecucion') );
      $("#tipoRemision").append( new Option('reportar a Unidad de Ejecución Preventiva', 'ley_nacional') ); 
      break;
    case 'Control':
      $("#tipoRemision").append( new Option('por Incompetencia', 'incompetencia') );
      $("#tipoRemision").append( new Option('a Tribunal de Enjuiciamiento', 'tribunal_enjuiciamiento') ); 
      $("#tipoRemision").append( new Option('a Unidad de Ejecución ', 'unidad_ejecucion') );
      $("#tipoRemision").append( new Option('reportar a Unidad de Ejecución Preventiva', 'ley_nacional') ); 
      
      break;
    default:
      alert("Error al buscar el tipo de carpeta");  
  }

  const personas = await data_carpeta.obtenerPersonas();
  //console.log(personas);
  if( personas.status == 100 ) {
    
    const imputados = data_carpeta.filtrarPersonasCalJud( personas.response.personas, [46] );
    //console.log(imputados);
      if( imputados.length < 1 ) {
        $("#tipoRemision option[value='incompetencia']").remove(); 
        $("#tipoRemision option[value='unidad_ejecucion']").remove(); 
        $("#tipoRemision option[value='tribunal_enjuiciamiento']").remove(); 
      }
      
  } else {
    $("#tipoRemision option[value='incompetencia']").remove();
    $("#tipoRemision option[value='unidad_ejecucion']").remove();
    $("#tipoRemision option[value='tribunal_enjuiciamiento']").remove();
  }
  setTimeout( () => {
    $("#tipoRemision").select2();
  },100);
}

function tipo_Remision() {
  
  const tipo_remision = $('#tipoRemision').val();
  switch (tipo_remision) {
    case 'incompetencia':
      remisionIncompetencia();
      break;
    case 'tribunal_enjuiciamiento':
      remisionTrubunalEnjuciamiento();
      break;
    case 'unidad_ejecucion':
      remisionUnidadEjecucion();
      break;
    case 'ley_nacional':
      remisionPreventiva();
      break;
    default:
      
  }
}

async function remisionIncompetencia(){
  
  const data_carpeta = await new Carpeta( carpeta_remitir.id_carpeta_judicial, carpeta_remitir );
  const {folio_carpeta} = carpeta_remitir;

  $("#formularioRemision").html('<div class="d-flex ht-300 pos-relative align-items-center"><div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div><div class="sk-cube2 sk-cube"></div><div class="sk-cube4 sk-cube"></div><div class="sk-cube3 sk-cube"></div></div></div><!-- d-flex -->');

  let imputados_carpeta = '';
  const personas = await data_carpeta.obtenerPersonas();
 
  if( personas.status == 100 ) {

    const imputados =  data_carpeta.filtrarPersonasCalJud( personas.response.personas, [46]);

    $( imputados ).each( function( ip, imputado ) {
      
      const { nombre, apellido_paterno, apellido_materno, razon_social, tipo_persona, id_persona } = imputado.info_principal;
      
      imputados_carpeta += ` 
        <div class="col-md-4">
          <label class="ckbox">
            <input type="checkbox" value="${id_persona}" data-tipo="${tipo_persona}" name="imputados_sel"><span>${razon_social == null ? '' : razon_social}${nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</span>
          </label>
        </div>
      `;

    });
  } else {
    imputados_carpeta += '<div class="col-12"><h5 class="tx-danger">Carpeta sin imputados activos</h5></div>'
  }
    
 
  let options_fiscalias = '';  
  $.each( fiscalias, (i, fiscalia) => {
    options_fiscalias += `<option value="${fiscalia.id_fiscalia}" ${fiscalia.id_fiscalia == carpeta_remitir.id_fiscalia ? '' : ' selected'}>${fiscalia.fiscalia}</option>`;
  });

  let ugas_opts = '';
  const keys_uni = Object.keys(unidades);

  $( keys_uni ).each( function( i, i_uni) {
    if( unidades[i_uni].tipo_institucion == 'UNIDAD' )
      if( ![0,107,105,20,35,37,36,110,109].includes(unidades[i_uni].id_unidad_gestion) )
        ugas_opts += `<option value="${unidades[i_uni].id_unidad_gestion}">${unidades[i_uni].nombre_unidad}</option>`;
  });

  let btn_regresar_remision = '';
  const historial_status = await data_carpeta.validarHistorialRemision();
  if( historial_status.status == 100 )
    btn_regresar_remision = '<div class="col-6" style="text-align: end;"><div class="form-group mg-b-10-force mg-l-auto mg-t-auto mg-b-auto regresar_remi"><label class="form-control-label d-block">Regresar remisión:</label><div class="toggle-wrapper"><div class="toggle toggle-modern primary"></div></div></div></div>';
  
  $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL POR INCOMPETENCIA");//INCOMPETENCIA
  
  let formularioRemision = "";
  if( data_carpeta.tipoCarpeta() == "TE" )
    formularioRemision = `
      <div  class="slim-pagetitle mg-t-20  mg-b-20">
        <h6 class="mg-b-0">Datos Generales:</h6>  
      </div>
      <div class="row mg-b-15 pd-10">
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Carpeta Judicial a Remitir:</label>
            <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${folio_carpeta}" placeholder="N/E" autocomplete="off" readonly>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group">
            <label class="form-control-label">Motivo de la incompetencia: <span class="tx-danger">*</span></label>
            <select class="form-control select2" id="motivoIncompetencia" name="motivo_incompetencia" autocomplete="off" onchange="motivoIncompretencia()">
              <option value="-1" valdefault="1">Elija una opción</option>
              <option value="privado_libertad" data-valor="1">El imputado ha sido privado de su libertad</option>
              <option value="imputado_libertad" data-valor="2">El imputado ha quedado en libertad</option>
              <option value="mandato_judicial" data-valor="4">Por mandato judicial</option>
              <option value="otro" data-valor="5">Otro</option>	
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Motivo de la incompetencia (Otro):</label>
            <input class="form-control" type="text" placeholder=""  name="motivo_incompetencia_otro" id="motivoIncompetenciaOtro" autocomplete="off" readonly>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group" >
            <label class="form-control-label ">¿El imputado se encuentra privado de su libertad?: <span class="tx-danger">*</span></label>
            <div class="d-inline-block mg-l-10" id="privadoLibertadDiv">
              <label class="rdiobox d-inline-block mg-l-50">
                <input name="privado_libertad" onclick="privadoLib(this);" type="radio" value="si">
                <span class="pd-l-0">Si</span>
              </label>
              <label class="rdiobox d-inline-block mg-l-30">
                <input name="privado_libertad" onclick="privadoLib(this);"  type="radio" value="no">
                <span class="pd-l-0">No</span>
              </label>
            </div>
          </div>
        </div>
        <div class="col-lg-4" id="divInternamiento" >
          <div class="form-group">
            <label class="form-control-label">Lugar de internamiento: <span class="tx-danger d-none">*</span></label>
            <select class="form-control select2" id="lugarInternamiento" name="lugar_internamiento" autocomplete="off" disabled onchange="lugarInternamientoInc()">
              <option selected value="">Seleccione una opción</option>
              <option value="00020005">Centro de Ejecución de Sanciones Penales Varonil Norte</option>
              <option value="00020006">Centro de Ejecución de Sanciones Penales Varonil Oriente</option>
              <option value="00020010">Centro de Reinserción Social Varonil (CERESOVA)</option>
              <option value="00020009">Centro Femenil de Reinserción Social (Tepepan)</option>
              <option value="00020014">Centro Preventivo y de Reinserción Social Chalco</option>
              <option value="00020004">Centro Varonil de Rehabilitación Psicosocial (CEVAREPSI)</option>
              <option value="00020011">Centro Varonil de Seguridad Penitenciaria I (CEVASEP I)</option>
              <option value="00020012">Centro Varonil de Seguridad Penitenciaria II (CEVASEP II)</option>
              <option value="00020013">Institución Abierta Casa de Medio Camino</option>
              <option value="00020007">Penitenciaría de la Ciudad de México</option>
              <option value="00020008">Centro Femenil de Reinserción Social (Santa Martha)</option>
              <option value="00020001">Reclusorio Preventivo Varonil Norte</option>
              <option value="00020002">Reclusorio Preventivo Varonil Oriente</option>
              <option value="00020003">Reclusorio Preventivo Varonil Sur</option>                
            </select>
          </div>
        </div>  
        <div class="col-lg-4" id="divEdificioReceptor">
          <div class="form-group">
            <label class="form-control-label">Edificio/reclusorio receptor: <span class="tx-danger d-none">*</span></label>
            <select class="form-control select2" id="edificioReceptor" name="edificio_receptor" autocomplete="off" readonly onchange="obtenerUnidadDestino()">
              <option value="-1" valdefault="1">Elija una opción</option>
              <option value="1">Tribunal Enjuiciamiento Sede Norte</option>
              <option value="2">Tribunal Enjuiciamiento Sede Oriente</option>
              <option value="4">Tribunal Enjuiciamiento Sede Sullivan</option>
              <option value="3">Tribunal Enjuiciamiento Sede Sur</option>
            </select>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <label class="form-control-label">Comentarios Adicionales</label>
              <textarea id="comentariosAdicionales" rows="2" name="comentarios_adicionales" ></textarea>
          </div>
        </div>
      </div>
      <div  class="slim-pagetitle mg-t-20  mg-b-20">
        <h6 class="mg-b-0">Seleccione los imputados que serán remitidos en la incompetencia:</h6>  
      </div>
      <div class="row pd-10">
        <div class="col-md-12">
          <div class="row mg-t-20" style="padding-left: 10px;">
            ${imputados_carpeta}
          </div>  
        </div>
      </div>
      <div  class="slim-pagetitle mg-t-30 mg-b-20">
        <h6>Documento <span class="tx-danger d-none">*</span></h6>  
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="custom-input-file mg-t-30" style="background: #FFF">
            <input type="file" id="archivoPDF2" class="input-file" name="documento_adjunto" accept="application/pdf" onchange="leeDocumento(this, '.pdf,.PDF', 'incompetencia')">
            <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
          </div>
        </div>
      </div>
      <div class="row mg-b-15">
        <div id="divDocumento" style="width:100%" class="col-12">
          <object data=""  id="documentoPDF" width="100%" height="350px" class=" mg-t-25"></object>
          <input type="hidden" id="bDoc" name="bDoc">
        </div>
      </div>`
    ;
  else if( ['EJEC', 'UGJEMS'].includes(data_carpeta.tipoCarpeta()) )
    formularioRemision  = `
      <div class="row pd-10">
        <div class="col-6">
          <div  class="slim-pagetitle mg-t-20  mg-b-20">
            <h6 class="mg-b-0">Datos Generales:</h6>  
          </div>
        </div>
        ${btn_regresar_remision}
      </div>
      <div class="row mg-b-15 pd-10 pd-l-20">
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Carpeta Judicial a Remitir:</label>
            <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${folio_carpeta}" placeholder="N/E" autocomplete="off" readonly>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group">
            <label class="form-control-label">Motivo de la incompetencia: <span class="tx-danger">*</span></label>
            <select class="form-control select2" id="motivoIncompetencia" name="motivo_incompetencia" autocomplete="off" onchange="motivoIncompretenciaEjec()">
              <option selected value="" disabled>Seleccione una opción</option>
              <option value="imputado_privado_libertad_ejec" data-valor="1">El imputado ha sido privado de su libertad</option>
              <option value="imputado_libertad_ejec" data-valor="2" >El imputado ha quedado en libertad</option>
              <option value="mandato_judicial_ejec" data-valor="4">Por mandato judicial</option>
              <option value="otro" data-valor="5">Otro</option>
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label">Motivo de la incompetencia (Otro):</label>
            <input class="form-control" type="text" placeholder=""  name="motivo_incompetencia_otro" id="motivoIncompetenciaOtro" autocomplete="off" readonly>
          </div>
        </div>   
      </div>
      <div class="row mg-b-15 pd-10 pd-l-20">
        <div class="col-lg-4" id="divImputadoLibertad">
          <div class="form-group" >
            <label class="form-control-label ">¿El imputado se encuentra privado de su libertad?: <span class="tx-danger">*</span></label>
            <div class="d-inline-block mg-l-10" id="privadoLibertadDiv">
              <label class="rdiobox d-inline-block mg-l-50">
                <input name="privado_libertad" onclick="privadoLibEjec(this);" type="radio" value="si">
                <span class="pd-l-0">Si</span>
              </label>
              <label class="rdiobox d-inline-block mg-l-30">
                <input name="privado_libertad" onclick="privadoLibEjec(this);"  type="radio" value="no">
                <span class="pd-l-0">No</span>
              </label>
            </div>
          </div>
        </div>
        <div class="col-lg-6" id="divInternamiento" >
          <div class="form-group">
            <label class="form-control-label  mg-lg-b-20">Lugar de internamiento: <span class="tx-danger d-none">*</span></label>
            <select class="form-control select2" id="lugarInternamiento" name="lugar_internamiento" autocomplete="off" disabled onchange="obtenerUnidadadDestinoEjec()">
              <option selected value="">Seleccione una opción</option>
              <option value="00020005">Centro de Ejecución de Sanciones Penales Varonil Norte</option>
              <option value="00020006">Centro de Ejecución de Sanciones Penales Varonil Oriente</option>
              <option value="00020010">Centro de Reinserción Social Varonil (CERESOVA)</option>
              <option value="00020009">Centro Femenil de Reinserción Social (Tepepan)</option>
              <option value="00020014">Centro Preventivo y de Reinserción Social Chalco</option>
              <option value="00020004">Centro Varonil de Rehabilitación Psicosocial (CEVAREPSI)</option>
              <option value="00020011">Centro Varonil de Seguridad Penitenciaria I (CEVASEP I)</option>
              <option value="00020012">Centro Varonil de Seguridad Penitenciaria II (CEVASEP II)</option>
              <option value="00020013">Institución Abierta Casa de Medio Camino</option>
              <option value="00020007">Penitenciaría de la Ciudad de México</option>
              <option value="00020008">Centro Femenil de Reinserción Social (Santa Martha)</option>
              <option value="00020001">Reclusorio Preventivo Varonil Norte</option>
              <option value="00020002">Reclusorio Preventivo Varonil Oriente</option>
              <option value="00020003">Reclusorio Preventivo Varonil Sur</option>                
            </select>
          </div>
        </div>  
      </div>
      <div class="row mg-b-15 pd-10 pd-l-20">
        <div class="col-lg-12"  id="divSelectDestino">
          <div class="form-group" id="unidad_destino_select">
            <label class="form-control-label">Unidad Destino <span class="tx-danger d-none">*</span></label>
            <select class="form-control select2" id="select_unidad_select" name="select_unidad_select" autocomplete="off" onchange="agregarUnidadDestinoSelect()">
              <option selected value="" disabled>Seleccione una opción</option>
              <option value="20">Unidad de Gestión Judicial de Ejecución de Sanciones Penales 1 (Sullivan)</option>
              <option value="35">Unidad de Gestión Judicial de Ejecución de Sanciones Penales 2 (Norte)</option>
              <option value="37">Unidad de Gestión Judicial de Ejecución de Sanciones Penales 3 (Oriente)</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row mg-b-15 pd-10 pd-l-20"> 
        <div class="col-lg-12">
          <div class="form-group">
            <label class="form-control-label">Comentarios Adicionales</label>
              <textarea id="comentariosAdicionales" rows="2" name="comentarios_adicionales" ></textarea>
          </div>
        </div>
      </div>
      <div class="row mg-b-15 pd-10  d-none-rm">
        <div class="col-md-12">
          <div  class="slim-pagetitle mg-t-20">
            <h6>Seleccione los imputados que serán remitidos en la incompetencia: <span class="tx-danger">*</span></h6>  
          </div>
          <div class="row mg-t-20 pd-10" style="padding-left: 10px;">
            ${imputados_carpeta}
          </div>  
        </div>
      </div>
      <div class="row mg-b-15 pd-10">
        <div class="col-md-12">
          <div  class="slim-pagetitle mg-t-20 mg-b-20">
            <h6>Documento <span class="tx-danger d-none">*</span></h6>  
          </div>
          <div class="custom-input-file rem_ejec mg-t-30" style="background: #FFF">
            <input type="file" id="archivoPDF2" class="input-file" name="documento_adjunto" accept="application/pdf" onchange="leeDocumento(this, '.pdf,.PDF', 'incompetencia')">
            <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
          </div>
        </div>
        <div id="divDocumento" style="width:100%" class="col-12">
          <object data=""  id="documentoPDF" width="100%" height="380px" class=""></object>
          <input type="hidden" id="bDoc" name="bDoc">
        </div>
      </div>
    `;
  else 
    formularioRemision  = `
    <div class="row pd-10">
      <div class="col-6">
        <div  class="slim-pagetitle mg-t-20  mg-b-20">
          <h6 class="mg-b-0">Datos Generales:</h6>  
        </div>
      </div>
      ${btn_regresar_remision}
    </div>
    <div class="row mg-b-15 pd-10 d-none-rm">
      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">Carpeta Judicial a Remitir:</label>
          <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${folio_carpeta}" placeholder="N/E" autocomplete="off" readonly>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <label class="form-control-label">Motivo de la incompetencia: <span class="tx-danger">*</span></label>
          <select class="form-control select2" id="motivoIncompetencia" name="motivo_incompetencia" autocomplete="off" onchange="motivoIncompretencia()">
            <option selected value="" disabled>Seleccione una opción</option>
            ${ carpeta_remitir.materia_destino == 'adolescentes' ? '' : '<option value="otra_materia" data-valor="0">Pertenece a otra materia</option>'}
            <option value="vinculacion_proceso" data-valor="3">Por vinculación a proceso</option>
            <option value="violencia_genero" data-valor="4">Por turno extraodinario violencia de género</option>
            <option value="mandato_zona" data-valor="40">Por mandato judicial - zona territorial</option>
            <option value="otro" data-valor="5">Otro</option>
          </select>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label">Motivo de la incompetencia (Otro):</label>
          <input class="form-control" type="text" placeholder=""  name="motivo_incompetencia_otro" id="motivoIncompetenciaOtro" autocomplete="off" readonly>
        </div>
      </div>
    </div>
    <div class="row mg-b-15  pd-10  d-none-rm   ">
      <div class="col-lg-4  ${carpeta_remitir.materia_destino == 'adolescentes' ? 'd-none' : ''}"  style="display:"">
        <div class="form-group" id="materiaDestino">
          <label class="form-control-label">Materia Destino: <span class="tx-danger">*</span></label>
          <div class="d-inline-block mg-l-5 mg-t-10" id="divMateriaDestino">
            <label class="rdiobox d-inline-block mg-l-5">
              <input name="materia_destino" type="radio" value="adultos" class="materia_destino" ${carpeta_remitir.materia_destino == 'adolescentes' ? 'disabled' : ''}>
              <span class="pd-l-0">Penal Adultos</span>
            </label>
            <label class="rdiobox d-inline-block mg-l-5">
              <input name="materia_destino" type="radio" value="adolescentes" class="materia_destino"  ${carpeta_remitir.materia_destino == 'adolescentes' ? 'disabled' : ''}>
              <span class="pd-l-0">Penal Adolescentes</span>
            </label>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="form-group">
          <label class="form-control-label">Fiscalía: <span class="tx-danger">*</span></label>
          <select class="form-control" id="fiscalia" name="fiscalia" autocomplete="off" onchange="obtenerInmuebleFiscalia()">
            <option selected disabled  value="" >Elija una opción</option>
            ${options_fiscalias}
          </select>
        </div>
      </div><!-- col-4-->
    </div>
    <div class="row mg-b-15 pd-10  d-none-rm">
      <div class="col-lg-4" id="divUnidadDestino">
        <div class="form-group">
          <label class="form-control-label mg-lg-b-20">Tipo de unidad destino: <span class="tx-danger">*</span></label>
          <select class="form-control" id="tipoUnidadDestino" name="tipo_unidad_destino" autocomplete="off"  onchange="obtenerInmuebleFiscalia()">
            <option selected value="">Seleccione una opción</option>
            <option value="X" >Unidad especializada en Aprehensiones, Cateos y Técnicas de Investigacion</option>
            <option value="B">Unidad especializada en delitos de Oficio</option>
            <option value="A" >Unidad especializada en delitos de Querella</option>
            <option value="M" >Unidad especializada en Mujeres</option>
          </select>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group" >
          <label class="form-control-label ">¿El imputado se encuentra privado de su libertad?: <span class="tx-danger">*</span></label>
          <div class="d-inline-block mg-l-10" id="privadoLibertadDiv">
            <label class="rdiobox d-inline-block mg-l-50">
              <input name="privado_libertad" onclick="privadoLib(this);" type="radio" value="si">
              <span class="pd-l-0">Si</span>
            </label>
            <label class="rdiobox d-inline-block mg-l-30">
              <input name="privado_libertad" onclick="privadoLib(this);"  type="radio" value="no">
              <span class="pd-l-0">No</span>
            </label>
          </div>
        </div>
      </div>
      <div class="col-lg-4" id="divInternamiento" >
        <div class="form-group">
          <label class="form-control-label  mg-lg-b-20">Lugar de internamiento: <span class="tx-danger d-none">*</span></label>
          <select class="form-control select2" id="lugarInternamiento" name="lugar_internamiento" autocomplete="off" disabled>
            <option selected value="">Seleccione una opción</option>
            <option value="00020005">Centro de Ejecución de Sanciones Penales Varonil Norte</option>
            <option value="00020006">Centro de Ejecución de Sanciones Penales Varonil Oriente</option>
            <option value="00020010">Centro de Reinserción Social Varonil (CERESOVA)</option>
            <option value="00020009">Centro Femenil de Reinserción Social (Tepepan)</option>
            <option value="00020014">Centro Preventivo y de Reinserción Social Chalco</option>
            <option value="00020004">Centro Varonil de Rehabilitación Psicosocial (CEVAREPSI)</option>
            <option value="00020011">Centro Varonil de Seguridad Penitenciaria I (CEVASEP I)</option>
            <option value="00020012">Centro Varonil de Seguridad Penitenciaria II (CEVASEP II)</option>
            <option value="00020013">Institución Abierta Casa de Medio Camino</option>
            <option value="00020007">Penitenciaría de la Ciudad de México</option>
            <option value="00020008">Centro Femenil de Reinserción Social (Santa Martha)</option>
            <option value="00020001">Reclusorio Preventivo Varonil Norte</option>
            <option value="00020002">Reclusorio Preventivo Varonil Oriente</option>
            <option value="00020003">Reclusorio Preventivo Varonil Sur</option>                
          </select>
        </div>
      </div>  
    </div>
    <div class="row mg-b-15 pd-10  d-none-rm">
      <div class="col-lg-4" id="divEdificioReceptor">
        <div class="form-group">
          <label class="form-control-label">Edificio/reclusorio receptor: <span class="tx-danger d-none">*</span></label>
          <select class="form-control select2" id="edificioReceptor" name="edificio_receptor" autocomplete="off" readonly onchange="obtenerUnidadDestino()">
            <option selected value="">Seleccione una opción</option>
            <option value="7">Reclusorio Preventivo Varonil Norte</option>
            <option value="8">Reclusorio Preventivo Varonil Oriente</option>
            <option value="9">Reclusorio Preventivo Varonil Sur</option>
            <option value="10">Centro Femenil de Reinserción Social (Santa Martha)</option>
            <option value="5">Dr. Lavista</option>
            <option value="4">Sullivan</option>
          </select>
        </div>
      </div>
      <div class="col-lg-8"  id="divSelectDestino">
        <div class="form-group mg-b-10-force" id="unidad_destino_input">
          <label class="form-control-label">Unidad Destino</label>
            <textarea class="form-control" type="text" name="select_unidad" id="select_unidad" value="" autocomplete="off" readonly rows="1" style="background-color: #e9ecef !important;"></textarea>
        </div>
        <div class="form-group d-none" id="unidad_destino_select">
          <label class="form-control-label">Unidad Destino <span class="tx-danger d-none">*</span></label>
          <select class="form-control select2" id="select_unidad_select" name="select_unidad_select" autocomplete="off" onchange="agregarUnidadDestinoSelect()">
            <option selected value="" disabled>Seleccione una opción</option>
            ${ugas_opts}
          </select>
        </div>
      </div>
    </div>
    <div class="row mg-b-15 pd-10 "> 
      <div class="col-lg-12">
        <div class="form-group">
          <label class="form-control-label">Comentarios Adicionales</label>
            <textarea id="comentariosAdicionales" rows="2" name="comentarios_adicionales" ></textarea>
        </div>
      </div>
    </div>
    <div class="row mg-b-15 pd-10  d-none-rm">
      <div class="col-md-12">
        <div  class="slim-pagetitle mg-t-20">
          <h6>Seleccione los imputados que serán remitidos en la incompetencia: <span class="tx-danger">*</span></h6>  
        </div>
        <div class="row mg-t-20 pd-10">
          ${imputados_carpeta}
        </div>  
      </div>
    </div>
    <div class="row mg-b-15 pd-10">
      <div class="col-md-12">
        <div  class="slim-pagetitle mg-t-20 mg-b-20">
          <h6>Documento <span class="tx-danger d-none">*</span></h6>  
        </div>
        <div class="custom-input-file mg-t-30" style="background: #FFF">
          <input type="file" id="archivoPDF2" class="input-file" name="documento_adjunto" accept="application/pdf" onchange="leeDocumento(this, '.pdf,.PDF', 'incompetencia')">
          <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
        </div>
      </div>
      <div id="divDocumento" style="width:100%" class="col-12">
        <object data=""  id="documentoPDF" width="100%" height="380px" class=""></object>
        <input type="hidden" id="bDoc" name="bDoc">
      </div>
    </div>
    `;

  $("#formularioRemision").html(formularioRemision);
  $('#motivoIncompetencia , #tipoUnidadDestino , #edificioReceptor').select2({minimumResultsForSearch: Infinity});
  $('#fiscalia , #lugarInternamiento').select2({minimumResultsForSearch: ''});
  $('#select_unidad_select').select2({minimumResultsForSearch: ''});
  $('#btnSiguiente').removeAttr('disabled').attr('onclick', 'enviarRemision()');
  setTimeout( () => { $('.toggle').toggles({ on: false, height: 26 }); },100);
}

async function remisionTrubunalEnjuciamiento(){

  const data_carpeta = await new Carpeta( carpeta_remitir.id_carpeta_judicial, carpeta_remitir ); 

  let imputados_carpeta = '',
    fechasAudiencias = '';

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

  const personas = await data_carpeta.obtenerPersonas();
  if( personas.status == 100 ) {

    const imputados =  data_carpeta.filtrarPersonasCalJud( personas.response.personas, [46]);

    $( imputados ).each( function( ip, imputado ){
      const { nombre, apellido_paterno, apellido_materno, razon_social, tipo_persona, id_persona } = imputado.info_principal;

      imputados_carpeta += ` 
        <div class="col-md-4">
          <label class="ckbox">
            <input type="checkbox" value="${id_persona}" data-tipo="${tipo_persona}" name="imputados_sel"><span>${razon_social == null ? '' : razon_social}${nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</span>
          </label>
        </div>
      `;
    });
  } else {
    imputados_carpeta += '<div class="col-12"><h5 class="tx-danger">Carpeta sin imputados activos</h5></div>'
  }

  // let option_reclusorio = '';
  // const reclusorios = await obtenerReclusorios();
   
  // $( reclusorios.message ).each( function ( i, reclusorio ){
  //   if( [9,5,1,2,3].includes(reclusorio.id_reclusorio) )
  //     option_reclusorio +=  `<option value="${reclusorio.id_reclusorio}">${reclusorio.nombre}</option>`
  // });
  

  const { id_carpeta_judicial } = carpeta_remitir;
  fechasAudiencias = await obtenerFechasAudSent( id_carpeta_judicial );

  $("#formularioRemision").html('<div class="d-flex ht-300 pos-relative align-items-center"><div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div><div class="sk-cube2 sk-cube"></div><div class="sk-cube4 sk-cube"></div><div class="sk-cube3 sk-cube"></div></div></div><!-- d-flex -->');
  formularioRemision  = `
    <div class="row pd-10">
      <div class="col-12">
        <div  class="slim-pagetitle mg-t-20  mg-b-20">
          <h6 class="mg-b-0">Datos Generales:</h6>  
        </div>
      </div>
    </div>
    <div class="row mg-b-15 pd-10">
      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label" style="margin-bottom:29px">Carpeta Judicial a Remitir:</label>
          <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${carpeta_remitir.folio_carpeta}" placeholder="N/E" autocomplete="off" disabled="">
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group">
          <label class="form-control-label">¿El imputado se encuentra interno en algún reclusorio?: <span class="tx-danger">*</span></label>
          <div class="d-inline-block mg-l-10" id="privadoLibertadDiv">
            <label class="rdiobox d-inline-block mg-l-5" style="margin: 0 20px;">
              <input name="privado_libertad" type="radio" onclick="internoRecl(this);" value="si">
              <span class="pd-l-0">Si</span>
            </label>
            <label class="rdiobox d-inline-block mg-l-5" style="margin: 0 20px;">
              <input name="privado_libertad" type="radio" onclick="internoRecl(this);"  value="no">
              <span class="pd-l-0">No</span>
            </label>
          </div>
        </div>
      </div>
      <div class="col-lg-4" id="reclusorioInternamientoDiv">
        <div class="form-group">
          <label class="form-control-label" style="margin-bottom:20px;">Reclusorio de internamiento:</label>
          <select class="form-control select2" id="reclusorioInternamiento" name="edificio_receptor" autocomplete="off" disabled>
            <option selected value="">Seleccione una opción</option>
            ${reclusorios_options}
          </select>
        </div>
      </div>
    </div>
    <div class="row mg-b-15 pd-10">
      <div class="col-lg-8">
        <div class="form-group">
          <label class="form-control-label">Fecha de la audiencia en la cual se determina la vinculación a Juicio Oral:</label>
          <select class="form-control" id="fechaAudienciaTE" name="fecha_audiencia_te" autocomplete="off" onchange="indicaJuezAudiencia()">
            <option selected value="">Seleccione una opción</option>
            ${fechasAudiencias}
          </select>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group mg-b-10-force">
          <label class="form-control-label"  style="">Juez que determino la vinculacion:</label>
          <input class="form-control" type="text" name="juez_vinculacion" id="juezVinculacion" value="" placeholder="N/E" autocomplete="off" disabled="">
        </div>
      </div>
    </div>
    <div class="row mg-b-15 pd-10">
      <div class="col-lg-12">
        <div class="form-group">
          <label class="form-control-label">Comentarios Adicionales</label>
          <th colspan="100%">
            <textarea id="comentariosAdicionales" rows="2"  ></textarea>
          </th>
        </div>
      </div>
    </div>
    <div class="row pd-10">      
      <div class="col-md-12">
        <div  class="slim-pagetitle mg-t-20  mg-b-20">
          <h6 class="mg-b-0">Seleccione los imputados que serán remitidos en la incompetencia:</h6>  
        </div>
        <div class="row mg-t-20" style="padding-left: 10px;">
          ${imputados_carpeta}
        </div>  
      </div>
    </div>
    <div class="row mg-b-15 pd-10">
      <div class="col-12">
        <div  class="slim-pagetitle mg-t-20  mg-b-20">
          <h6 class="mg-b-0">Documentos: <span class="tx-danger d-none">*</span></h6>  
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
  $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL A TRIBUNAL DE ENJUICIAMIENTO");

  
  $("#formularioRemision").html(formularioRemision);
  $('#reclusorioInternamiento').select2({minimumResultsForSearch: ''});
  $('#fechaAudienciaTE').select2( { minimumResultsForSearch: Infinity } );
  $('#btnSiguiente').removeAttr('disabled').attr('onclick', 'enviarRemision()');
}

function obtenerReclusorios( id_reclusorio ) {
  return new Promise( resolve => {
    $.ajax({
      method: 'GET',
      url: '/public/ver_reclusorios',
      data:{ id_reclusorio },
      success: function(response){ resolve(response); }
    });
  });
}

async function remisionUnidadEjecucion(seccion_actual=''){
  
  moment.locale('es-mx');
  const data_carpeta = await new Carpeta( carpeta_remitir.id_carpeta_judicial ); 
  console.log( data_carpeta );
  sentenciados = [];
  defensores = [];
  victimas = [];
  asesores = [];
  ministerios_publico = [];
  informacion_complementaria = { documentos_remision_ue : {} };
  audiencias_dvd = [];
  billetes_remision = [];
  objetos_remision = [];
  adjuntos_remision = [];
  remision_in = '0';
  secciones_completadas = [];
  documento_remision = [];
  
  $("#formularioRemision").html('<div class="d-flex ht-300 pos-relative align-items-center"><div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div><div class="sk-cube2 sk-cube"></div><div class="sk-cube4 sk-cube"></div><div class="sk-cube3 sk-cube"></div></div></div><!-- d-flex -->');

  const {delitos, id_carpeta_judicial, folio_carpeta, carpeta_investigacion, imputados} = data_carpeta.carpeta;

  $('#btnSiguiente').attr('disabled',true);
  $('#delitoPena').html('<option value="" disabled selected>Seleccione una opción</option>');

  $(delitos).each( function( index, delito ){ $('#delitoPena').append(`<option value="${delito.id_delito}">${delito.delito}</option>`); });

  $('#imputados').html('<option value="" disabled selected>Seleccione una opción</option>');

  const personas = await data_carpeta.obtenerPersonas();
    if( personas.status == 100 ) {

      const imputados =  data_carpeta.filtrarPersonasCalJud( personas.response.personas, [46]);

      $( imputados ).each( function( ip, imputado ){
        const { nombre, apellido_paterno, apellido_materno, razon_social, tipo_persona, id_persona } = imputado.info_principal;

        $('#imputados').append( `<option value="${id_persona}" data-tipo="${tipo_persona}">${razon_social == null ? '' : razon_social}${nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</option>` );

      });
    }

  const remisionesCarpeta = await consultaRemisiones(id_carpeta_judicial);
  console.log( remisionesCarpeta );
  let remision_ue = [];

  if( remisionesCarpeta.status == 100 ) remision_ue = remisionesCarpeta.response.filter( remision => (remision.tipo_remision == 'unidad_ejecucion') && ( remision.estatus_actual == 'REGISTRADA') );
  
  let fecha_audiencia_sentencia = '',
      juez_dicto_sentencia = '',
      fecha_causa_ejecutoria = '',
      comentarios_adicionales = '',
      fechasAudiencias = '';
      documento_remision_ejec = '';

  if( remision_ue.length ){

    carpeta_remitir = Object.assign(carpeta_remitir, remision_ue[0]);

    const { EJEC_fecha_ejecutoria, EJEC_nom_juez_sentencia, EJEC_fecha_audiencia, EJEC_secciones_completadas, id_remision } = remision_ue[0];
    
    documentos_remision_arr = await obtenerDocumentosRemision( id_remision ); 

    if( documentos_remision_arr.status == 100 ) {
      
      doc_rem = documentos_remision_arr.response.filter( doc => !['_sentencia.pdf', '_auto.pdf', '_audiencia.pdf'].includes( doc.nombre_archivo.replace( id_remision,'' ))); 
      
      if( doc_rem.length ) {

        documento_remision.push({ id_documento: doc_rem[0].id_documento, estatus: 1 });
        documento = await obtenerDocumentosRemision( id_remision, doc_rem[0].id_documento ); 
        if( documento.status == 100 )
        documento_remision_ejec = documento.response;
      }

     
      
    }
    
    remision_in = id_remision;
    secciones_completadas = JSON.parse(EJEC_secciones_completadas);
    fecha_audiencia_sentencia = EJEC_fecha_audiencia == null ? '' : EJEC_fecha_audiencia.split(' ')[0];
    juez_dicto_sentencia = EJEC_nom_juez_sentencia;
    expFecha = EJEC_fecha_ejecutoria == null ? '--' : EJEC_fecha_ejecutoria.split('-');
    fecha_causa_ejecutoria = expFecha[2] + '-' + expFecha[1] + '-' + expFecha[0];
    comentarios = comentarios_adicionales;
    
  }
  
  fechasAudiencias = await obtenerFechasAudSent( id_carpeta_judicial, fecha_audiencia_sentencia );

  let tipos_documentos_op = '';

  $(tipos_documentos_carpeta).each( function( index, doc ) {
    const option = `<option value="${doc.id_documento}">${doc.nombre}</option>`;
    tipos_documentos_op = tipos_documentos_op.concat(option);
  });
  
  formularioRemision  = `
    <div class="card">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs d-block d-md-flex" id="etapas">
          <li class="nav-item">
            <a class="nav-link active seccion" href="#panelInicial" data-toggle="tab" id="inicial" etapa="inicial">Datos de registro</a>
          </li>
          <li class="nav-item">
            <a class="nav-link seccion tx-danger d-none" href="#panelSentenciados" data-toggle="tab" id="sentenciados" etapa="sentenciados">Datos del sentenciado</a>
          </li>
          <!--<li class="nav-item">
            <a class="nav-link seccion d-none tx-danger" href="#panelDefensores" data-toggle="tab"  id="defensores" etapa="defensores">Defensores&nbsp;&nbsp;&nbsp;</a>
          </li>
          <li class="nav-item">
            <a class="nav-link seccion d-none tx-danger" href="#panelVictimas" data-toggle="tab"  id="victimas" etapa="victimas">Víctimas / Ofendidos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link seccion d-none tx-danger" href="#panelAsesores" data-toggle="tab"  id="asesores_juridicos" etapa="asesores_juridicos">Aseseores jurídicos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link seccion d-none tx-danger" href="#panelMinisterioPublico" data-toggle="tab"  id="ministerio_publico" etapa="ministerio_publico">Ministerio Público</a> 
          </li>-->
          <li class="nav-item">
            <a class="nav-link seccion tx-danger d-none" href="#panelInformacionComplementaria" data-toggle="tab"  id="informacion_complementaria" etapa="informacion_complementaria">Información complementaria</a>
          </li>
          <!--<li class="nav-item">
            <a class="nav-link seccion tx-danger d-none" href="#panelAdjuntos" data-toggle="tab"  id="adjuntos" etapa="adjuntos">Adjuntos</a>
          </li>-->
        </ul>
      </div><!-- card-header -->
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="panelInicial">
            <div class="row mg-b-15">
              <div class="col-lg-3">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Folio de la solicitud:<br>&nbsp</label>
                  <input class="form-control" type="text" name="folio_solicitud" id="folioSolicitud" value="" placeholder="En trámite" autocomplete="off" disabled="">
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Fecha de registro:<br>&nbsp</label>
                  <input class="form-control" type="text" name="fecha_registro" id="fechaRegistro" value="" placeholder="En trámite" autocomplete="off" disabled="">
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Carpeta de Ejecución Asignada:<br>&nbsp</label>
                  <input class="form-control" type="text" name="carpeta_ejecucion_asignada" id="carpetaEjecucionAsignada" value="" placeholder="En trámite" autocomplete="off" disabled="">
                </div>
              </div>
              <div class="col-lg-3">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label"  style="margin-bottom:7px">Fecha de recepción en unidad de ejecución:</label>
                  <input class="form-control" type="text" name="fecha_recepcion_unidad" id="fechaRecepcionUnidad" value="" placeholder="En trámite" autocomplete="off" disabled="">
                </div>
              </div>
            </div>
            <div class="row mg-b-15">
              <div class="col-lg-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label"  style="margin-bottom:7px">Carpeta Judicial a remitir:</label>
                  <input class="form-control" type="text" name="carpeta_judicial_remitir" id="carpetaJudicialRemitir" value="${folio_carpeta}" placeholder="" autocomplete="off" disabled style="background:#FFF">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label"  style="margin-bottom:7px">Carpeta de investigación:</label>
                  <input class="form-control" type="text" name="carpeta_investigacion" id="carpetaInvestigacion" value="${carpeta_investigacion}" placeholder="" autocomplete="off" disabled style="background:#FFF">
                </div>
              </div>
            </div>
            <div class="row mg-b-15">
              <div class="col-md-7">
                <div class="form-group">
                  <label class="form-control-label">Fecha de la audiencia en la cual se dicta sentencia:<span class="tx-danger">*</span></label>
                  <select class="form-control select2" id="fechaAudienciaSentencia" name="fecha_audiencia_sentencia" autocomplete="off" onchange="indicaJuez()">
                    <option value="">Seleccione una opción</option>
                    ${fechasAudiencias}
                  </select>
                </div>
              </div>
              <div class="col-lg-5">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label mg-b-1208-29">Juez que dictó sentencia:</label>
                  <input class="form-control" type="text" name="juez_dicto_sentencia" id="juezDictoSent" value="${juez_dicto_sentencia}" placeholder="" autocomplete="off" style="background: #fff;" readonly>
                </div>
              </div>
              <div class="col-lg-5">
                <div class="form-group">
                  <label class="form-control-label mg-b-1208-29">Fecha a partir de la cual causa ejecutoria:<span class="tx-danger">*</span></label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                          </div>
                      </div>
                      <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fechaCausaEjecutoria" name="fecha_causa_ejecutoria" autocomplete="off" value="${fecha_causa_ejecutoria}" onchange="indicaJuez()">
                  </div>
                </div>
              </div>
            </div>
            <div class="row mg-b-15">
              <div class="col-12">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Comentarios:</label>
                  <textarea class="form-control" type="text" id="comentarios" name="comentarios" autocomplete="off" value="${comentarios_adicionales}"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="custom-input-file mg-t-30">
                  <input type="file" id="archivoPDF2" class="input-file" name="documento_remision" accept="application/pdf" onchange="leeDocumento(this, '.pdf,.PDF', 'unidad_ejecucion')">
                  <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
                </div>
              </div>
              <div id="divDocumento" style="width:100%" class="col-12">
                <object data="${documento_remision_ejec}"  id="documentoPDF" width="100%" height="350px" class=" mg-t-25"></object>
                <input type="hidden" id="bDoc" name="bDoc">
              </div>
            </div>
            <div class="row mb-b-15">
              <div class="col-12 d-flex">
                <button class="btn btn-primary mg-l-auto" onclick="enviarRemision()">Guardar</button>
              </div>
            </div>
          </div><!-- tab-pane -->
          <!-- /PANEL INICIAL -->
          <div class="tab-pane" id="panelSentenciados">
            <div class="mg-b-10">
                <a href="javascript:void(0)" onclick="nuevoSentenciado()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33 "></i> Agregar sentenciado</a>
            </div>
            <table id="tableSentenciados" class="table-remi">
              <thead>
                <tr>
                  <th class="acciones">Acciones</th>
                  <th class="nombre">Nombre o razón social</th>
                  <th class="t-persona">Tipo persona</th>
                <tr>
              </thead>
              <tbody id="bodySentenciados">
              </tbody>
            </table>
            <div class="d-flex mg-t-30">
              <button class="btn btn-primary mg-l-auto" onclick="guardarPersonas('sentenciados')">Guardar</button>
            </div>
          </div><!-- tab-pane -->
          <!-- 
          <div class="tab-pane" id="panelDefensores">
            <div class="row mg-b-10">
              <div class="col-12">
                <a href="javascript:void(0)" onclick="nuevoDefensor()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33 "></i> Agregar defensor</a>
              </div>  
            </div>
            <div class="row mg-b-30 d-none" id="divDefensor">
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Nombre del defensor:<span class="tx-danger">*</span></label>
                  <select class="form-control " id="defensor" name="defensor" autocomplete="off">
                    <option value="" selected disabled>Seleccione una opción</option>
                  </select>
                </div>
              </div>
              <div class="col-3 d-none">
                <a href="javascript:void(0)" onclick="nuevoRegistroDefensor()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33 " style="padding-top:35px;"></i> Registrar nuevo defensor</a>
              </div> 
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Tipo de defensor?: <span class="tx-danger">*</span></label>
                  <select class="form-control select2" id="tipoDefensor" name="tipo_defensor" autocomplete="off">
                    <option value="" selected disabled>Seleccione una opción</option>
                    <option value="privado">Privado</option>
                    <option value="publico">Público</option>
                  </select>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-lg-8">
                    <h6>Sentenciados:</h6>
                    <div id="sentenciadosDefensores">
                    </div>
                  </div>
                  <div class="col-lg-4" style="padding-top: 10px">
                    <button type="button" class="btn btn-outline-primary" onclick="agregarDefensor()">Agregar</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="cancelarDefensor()">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>
            <table id="tableDefensores" class="table-remi">
              <thead>
                <tr>
                  <th class="acciones">Acciones</th>
                  <th class="nombre">Defensor</th>
                  <th class="t-persona">Tipo defensor</th>
                <tr>
              </thead>
              <tbody id="bodyDefensores">
              </tbody>
            </table>
            <div class="d-flex mg-t-30">
              <button class="btn btn-primary mg-l-auto" onclick="guardarPersonas('defensores')">Guardar</button>
            </div>
          </div> -->
          <div class="tab-pane" id="panelVictimas">
            <div class="row mg-b-10">
              <div class="col-12">
                <a href="javascript:void(0)" onclick="nuevaVictima()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33 "></i> Agregar victima/ofendido</a>
              </div>  
            </div>
            <div class="row mg-b-30 d-none" id="divVictima">
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Nombre de la víctima / ofendido:<span class="tx-danger">*</span></label>
                  <select class="form-control" id="victima" name="victima" autocomplete="off">
                    <option value="" selected disabled>Seleccione una opción</option>
                  </select>
                </div>
              </div>
              <div class="col-3 d-none">
                <a href="javascript:void(0)" onclick="nuevoRegistroDefensor()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33 " style="padding-top:35px;"></i> Registrar nuevo defensor</a>
              </div> 
              <div class="col-lg-4" style="margin-top: 29px">
                <label class="form-control-label">&nbsp;</label>
                <button type="button" class="btn btn-outline-primary" onclick="agregarVictima()">Agregar</button>
                <button type="button" class="btn btn-outline-secondary" onclick="cancelarVictima()">Cancelar</button>
              </div>
            </div>
            <table id="tableVictimas" class="table-remi">
              <thead>
                <tr>
                  <th class="acciones">Acciones</th>
                  <th class="nombre">Víctima / Ofendido</th>
                <tr>
              </thead>
              <tbody id="bodyVictimas">
              </tbody>
            </table>
            <div class="d-flex mg-t-30">
              <button class="btn btn-primary mg-l-auto" onclick="guardarPersonas('victimas')">Guardar</button>
            </div>
          </div><!-- tab-pane -->
          <!-- tab-pane
          <div class="tab-pane" id="panelAsesores">
            <div class="row mg-b-10">
              <div class="col-12">
                <a href="javascript:void(0)" onclick="nuevoAsesor()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33 "></i> Agregar asesor jurídico</a>
              </div>  
            </div>
            <div class="row mg-b-30 d-none" id="divAsesor">
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Nombre del defensor:<span class="tx-danger">*</span></label>
                  <select class="form-control" id="asesorJuridico" name="asesor_juridico" autocomplete="off">
                    <option value="" selected disabled>Seleccione una opción</option>
                  </select>
                </div>
              </div>
              <div class="col-3 d-none">
                <a href="javascript:void(0)" onclick="nuevoRegistroAsesor()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33 " style="padding-top:35px;"></i> Registrar nuevo asesor</a>
              </div> 
              <div class="col-12">
                <div class="row">
                  <div class="col-lg-8">
                    <h6>Indique las víctimas / ofendidos que asesora:</h6>
                    <div id="victimasAsesor">
                    </div>
                  </div>
                  <div class="col-lg-4" style="padding-top: 10px">
                    <button type="button" class="btn btn-outline-primary" onclick="agregarAsesor()">Agregar</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="cancelarAsesor()">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>
            <table id="tableAsesores" class="table-remi">
              <thead>
                <tr>
                  <th class="acciones">Acciones</th>
                  <th class="nombre">Asesor Jurídico</th>
                <tr>
              </thead>
              <tbody id="bodyAsesores">
              </tbody>
            </table>
            <div class="d-flex mg-t-30">
              <button class="btn btn-primary mg-l-auto" onclick="guardarPersonas('asesores_juridicos')">Guardar</button>
            </div>
          </div> -->
          <!-- tab-pane
          <div class="tab-pane" id="panelMinisterioPublico">
            <div class="row mg-b-10">
              <div class="col-12">
                <a href="javascript:void(0)" onclick="nuevoMinisterioPublico()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33 "></i> Agregar ministerio público</a>
              </div>  
            </div>
            <div class="row mg-b-30 d-none" id="divMinisterioPublico">
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Nombre del ministerio público:<span class="tx-danger">*</span></label>
                  <select class="form-control" id="ministerioPublico" name="ministerio_publico" autocomplete="off">
                    <option value="" selected disabled>Seleccione una opción</option>
                  </select>
                </div>
              </div>
              <div class="col-3 d-none">
                <a href="javascript:void(0)" onclick="nuevoRegistroMinisterioPublico()"><i class="fa fa-plus-circle" aria-hidden="true" style="color:#848F33 " style="padding-top:35px;"></i> Registrar nuevo defensor</a>
              </div> 
              <div class="col-lg-4" style="margin-top: 29px">
                <label class="form-control-label">&nbsp;</label>
                <button type="button" class="btn btn-outline-primary" onclick="agregarMinisterioPublico()">Agregar</button>
                <button type="button" class="btn btn-outline-secondary" onclick="cancelarMinisterioPublico()">Cancelar</button>
              </div>
            </div>
            <table id="tableMinisterioPublico" class="table-remi">
              <thead>
                <tr>
                  <th class="acciones">Acciones</th>
                  <th class="nombre">Ministerio público / Ofendido</th>
                <tr>
              </thead>
              <tbody id="bodyMinisterioPublico">
              </tbody>
            </table>
            <div class="d-flex mg-t-30">
              <button class="btn btn-primary mg-l-auto" onclick="guardarPersonas('ministerio_publico')">Guardar</button>
            </div>
          </div> -->
          <div class="tab-pane" id="panelInformacionComplementaria">
            <div class="row">
              <div class="col-md-8 pd-20  br-lg-1">                
                <div  class="slim-pagetitle">
                  <h6>Audiencias que se remiten en los DVD´s</h6>  
                </div>
                <div class="row pd-20">
                  <div class="col-md-4">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Número de DVDs de audiencias a remitir: <span class="tx-danger">*</span></label>
                      <input class="form-control input-number" type="text" name="numero_dvd" id="numeroDVD" value="" autocomplete="off">
                    </div>  
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label">Fechas de audiencias:<br><span class="d-none d-md-block">&nbsp;<span></label>                      
                      <select class="form-control" id="fechaAudienciaDVD" name="fecha_audiencia_dvd" autocomplete="off">
                        <option value="" selected disabled>Seleccione una opción</option>
                        ${fechasAudiencias}
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <button class="btn btn-outline-primary mg-l-auto d-block" id="btnFecha" onclick="agregarFechaDVD()">Agregar</button>
                  </div>
                  <div class="col-12">
                    <table id="tableAudienciaDVD" class="table-remi mg-t-10 mg-b-30">
                      <thead>
                        <tr>
                          <th class="acciones">Acciones</th>
                          <th class="nombre">Fecha audiencia</th>
                        <tr>
                      </thead>
                      <tbody id="bodyAudienciaDVD">
                      </tbody>
                    </table>
                  </div>
                </div>
                <div  class="slim-pagetitle mg-t-20">
                  <h6>Billetes</h6>  
                </div>
                <div class="row mg-b-30 pd-20">  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-control-label">¿Se remite algún billete de depósito?: <span class="tx-danger">*</span></label>
                      <div class="mg-l-10" id="privadoLibertadDiv">
                        <label class="rdiobox d-inline-block mg-l-5" style="margin: 0 20px;">
                          <input name="billete_remision" type="radio" onclick="billeteRemision();" value="si">
                          <span class="pd-l-0">Si</span>
                        </label>
                        <label class="rdiobox d-inline-block mg-l-5" style="margin: 0 20px;">
                          <input name="billete_remision" type="radio" onclick="billeteRemision();"  value="no"  checked>
                          <span class="pd-l-0">No</span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">No. billete:</label>
                      <input class="form-control input-number" type="text" name="no_billete" id="noBillete" value="" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Monto:</label>
                      <input class="form-control input-money" type="text" name="monto_billete" id="montoBillete" value="" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-2 mg-b-18">
                    <button class="btn btn-outline-primary mg-t-md-28 mg-l-auto d-block" id="btnBilletes" onclick="agregarBilleteRemision()">Agregar</button>
                  </div>
                  <div class="col-12">
                    <table id="tableBilletesRemision" class="table-remi mg-t-30">
                      <thead>
                        <tr>
                          <th class="acciones">Acciones</th>
                          <th class="no_billete">No. de billete</th>
                          <th class="monto_billete">Monto del billete</th>
                        <tr>
                      </thead>
                      <tbody id="bodyBilletesRemision">
                      </tbody>
                    </table>
                  </div>
                </div>
                
                <div  class="slim-pagetitle mg-t-20">
                  <h6>Objetos asegurados</h6>  
                </div>
                <div class="row pd-20">
                  <div class="col-12">
                    <div class="form-group">
                      <label class="form-control-label">¿Cuenta con información respecto a objetos asegurados?: <span class="tx-danger">*</span></label>
                      <div class="d-inline-block mg-l-10" id="divObjeto">
                        <label class="rdiobox d-inline-block mg-l-5" style="margin: 0 20px;">
                          <input name="objeto_asegurado" type="radio" onclick="objetoAsegurado();" value="si">
                          <span class="pd-l-0">Si</span>
                        </label>
                        <label class="rdiobox d-inline-block mg-l-5" style="margin: 0 20px;">
                          <input name="objeto_asegurado" type="radio" onclick="objetoAsegurado();"  value="no"  checked>
                          <span class="pd-l-0">No</span>
                        </label>
                      </div>
                    </div>
                  </div>
               
                  <div class="col-md-5">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Descripción:</label>
                      <textarea class="form-control" type="text" name="descripcion_objeto" id="descripcionObjeto"></textarea> 
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group mg-b-10-force">
                      <label class="form-control-label">Ubicación:</label>
                      <textarea class="form-control" type="text" name="ubicacion_objeto" id="ubicacionObjeto" value="" autocomplete="off"></textarea> 
                    </div>
                  </div>
                  <div class="col-md-2 mg-b-18">
                    <button class="btn btn-outline-primary mg-l-auto d-block mg-t-md-28" id="btnObjetos" onclick="agregarObjeto()">Agregar</button>
                  </div>
                  <div class="col-12">
                    <table id="tableObjetos" class="table-remi mg-t-30">
                      <thead>
                        <tr>
                          <th class="acciones">Acciones</th>
                          <th class="descripcion_objeto">Descripción</th>
                          <th class="ubicacion_objeto">Ubicación</th>
                        <tr>
                      </thead>
                      <tbody id="bodyObjetos">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-4 pd-15">
                <h5 style="border-left: 5px solid #848F33; padding-left: 5px;" class="mg-b-20">Documentos:</h5>
                <table style="border: 1px solid #EEE; margin-bottom: 15%;">
                  <body>
                    <tr >
                      <td style="background-color: #848F33; text-align: center; color: #FFF;">Copia certificada de la sentencia:<span class="tx-danger">*</span></td>
                    </tr>
                    <tr>
                      <td style="padding: 4%;">
                        <div class="custom-input-file rem_ejec">
                          <input type="file" id="copia_certificada_sentencia" class="input-file" value="" name="copia_certificada_sentencia" onchange="leeDocumento(this, '.pdf,.PDF', 'copia_certificada_sentencia')" accept="application/pdf">
                          <p class="">Arrastre hasta aquí su documento o de clic para adjuntarlo</p>
                        </div>
                        <div class="col-lg-6 mg-l-auto mg-r-auto tx-center" id="div_copia_certificada_sentencia">
                        </div>  
                      </td>
                    </tr>
                  </body>
                </table>
                <table style="border: 1px solid #EEE; margin-bottom: 15%;">
                  <body>
                    <tr>
                      <td style="background-color: #848F33; text-align: center; color: #FFF;">Copia certificada de auto donde se reconoce la ejecución de la setencia aludida:<span class="tx-danger">*</span></td>
                    </tr>
                    <tr>
                      <td style="padding: 4%;">
                        <div class="custom-input-file rem_ejec" id="">
                          <input type="file" id="copia_certificada_auto" class="input-file" value="" name="copia_certificada_auto" onchange="leeDocumento(this, '.pdf,.PDF', 'copia_certificada_auto')" accept="application/pdf">
                          <p class="">Arrastre hasta aquí su documento o de clic para adjuntarlo</p>
                        </div>
                        <div class="col-lg-6 mg-l-auto mg-r-auto tx-center" id="div_copia_certificada_auto">
                        </div>  
                      </td>
                    </tr>
                  </body>
                </table>     
                <table style="border: 1px solid #EEE; margin-bottom: 15%;">
                  <body>
                    <tr>
                      <td style="background-color: #848F33; text-align: center; color: #FFF;">Acta mínima de la audiencia que contenga la lectura y explicación de sentencia:<span class="tx-danger">*</span></td>
                    </tr>
                    <tr>
                      <td style="padding: 4%;">
                        <div class="custom-input-file rem_ejec" id="">
                          <input type="file" id="acta_minima" class="input-file" value="" name="acta_minima" onchange="leeDocumento(this, '.pdf,.PDF', 'acta_minima')" accept="application/pdf">
                          <p class="">Arrastre hasta aquí su documento o de clic para adjuntarlo</p>
                        </div>
                        <div class="col-lg-6 mg-l-auto mg-r-auto tx-center" id="div_acta_minima">
                        </div>  
                      </td>
                    </tr>
                  </body>
                </table>     
              </div>
            </div>
            <div class="row mb-b-15">
              <div class="col-12 d-flex">
                <button class="btn btn-primary mg-l-auto" onclick="guardarPersonas('informacion_complementaria')">Guardar</button>
              </div>
            </div>
          </div><!-- tab-pane -->
          <div class="tab-pane" id="panelAdjuntos">
            <div class="row mg-b-30">
            <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Tipo de documento a adjuntar:<span class="tx-danger">*</span></label>
                  <select class="form-control mg-b-20 " id="tipo_documento_adjunto" name="tipo_documento_adjunto" autocomplete="off">
                    <option value="" selected disabled>Seleccione una opción</option>
                    ${tipos_documentos_op}
                  </select>
                </div>
                <div class="custom-input-file  mg-t-30">
                  <input type="file" id="documento_adjunto" class="input-file" value="" name="documento_adjunto" onchange="leeDocumento(this, '', 'adjunto')">
                  <p class="" style="font-size:1.07rem">Arrastre hasta aquí su documento o de clic para adjuntarlo</p>
                </div>   
              </div>
              <div class="col-lg-6 mg-b-30" >
                <div class="row" id="div_documentos_adjuntos">
                </div>    
              </div>
            </div>
            <div class="row mb-b-15">
              <div class="col-12 d-flex">
                <button class="btn btn-primary mg-l-auto" onclick="guardarPersonas('adjuntos')">Guardar</button>
              </div>
            </div>
          </div>
        </div><!-- tab-content -->
      </div><!-- card-body -->
    </div><!-- card -->
  `;

  $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL A UNIDAD DE EJECUCIÓN");
  $("#formularioRemision").html(formularioRemision);
  $('#fechaAudienciaSentencia').select2({minimumResultsForSearch: Infinity});
  $('#detallePena').select2({minimumResultsForSearch: Infinity});
  $('#defensor').select2({minimumResultsForSearch: ''});
  $('#victima').select2({minimumResultsForSearch: ''});
  $('#tipoDefensor').select2({minimumResultsForSearch: ''});
  $('#asesorJuridico').select2({minimumResultsForSearch: ''});
  $('#ministerioPublico').select2({minimumResultsForSearch: ''});
  $('#fechaAudienciaDVD').select2({minimumResultsForSearch: Infinity}).val('').trigger('change'); 
  $('#fechaAudienciaDVD option').removeAttr('selected');
  $('#penaImpuesta').select2({minimumResultsForSearch: ''});
  $('#centroDetencionPena').select2({minimumResultsForSearch: ''});
  $('#tipo_documento_adjunto').select2({minimumResultsForSearch: ''});
  $('#btnSiguiente').attr('onclick', 'remisionEjecAutorizacion()');
  
  
  $('#fechaCausaEjecutoria').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    format: 'yyyy/mm/dd',
    changeYear: true,
    yearRange: "c-100:c+0"
  });

  if( secciones_completadas.length  ){

    $('.seccion').removeClass('d-none active');
    secciones = $('.seccion');

    $(secciones_completadas).each( function( index, seccion ){

      $('#'+seccion).removeClass('tx-danger');

      if( seccion_actual != '' )
        $('#'+seccion_actual).click().addClass('active');
      else
        if( secciones.length == secciones_completadas.length ) 
          $('#'+secciones[secciones_completadas.length-1].id).click().addClass('active');
        else 
          $('#'+secciones[secciones_completadas.length].id).click().addClass('active');

    });

    if( secciones_completadas.length == 3 )
      $('#btnSiguiente').removeAttr('disabled');
    else
      $('#btnSiguiente').attr('disabled', true);
  }

  obtenerPersonasRemisionRUE(remision_in);
  obtenerPersonasCarpetaRUE(id_carpeta_judicial);
  showSentenciados();
  showDefensores();
  showVictimas();
  showAsesores();
  showMinisterioPublico();
  showAudienciasDVD();
  showBilletesRemision();
  billeteRemision();
  showObjetos();
  objetoAsegurado();

}

function etapas(etapa=''){
  if( etapa == '' ){
    etapa = $('#etapas').find('.active').attr('etapa');
  }
  
  if(etapas_rue.includes(etapa)){
    $('#btnSiguiente').attr('disabled',true);
  }else{
    $('#btnSiguiente').removeAttr('disabled');
  }
}

function enviarRemision( finalizar = false ){
  form=false;
  let validacion = 0;

  if($('#tipoRemision').val() == '' || $('#tipoRemision').val() == null ){

    error('Datos Incompletos', 'No ha seleccionado el tipo de remisión', 'modalRemision');
    $('span[aria-labelledby="select2-tipoRemision-container"]').addClass('error');
    return 0;

  }else if( $('#tipoRemision').val() == 'incompetencia' ){

    validacion=validaRemInc();

  }else if( $('#tipoRemision').val() == 'tribunal_enjuiciamiento' ){

    validacion=validaRemTriEnj();

  }else if( $('#tipoRemision').val() == 'unidad_ejecucion' ){

    validacion=validaRemUniEjec();

    if( carpeta_remitir.id_remision && !finalizar ){

      $('#modalRemision').modal('hide');
      $('#modal_loading').modal('show');
      actualizarPersonasRemision('inicial');
      $('#inicial .square-8 ').remove();
      return 0;

    }

  }else if( $('#tipoRemision').val() == 'ley_nacional' ) {
    
    validacion = validaRemPreventiva();

  }

  if(validacion==100){
    $('#modalRemision').modal('hide');
    $('#modal_loading').modal('show');
    $.ajax({
      method:'POST',
      url:'/public/enviar_remision',
      data:form,
      processData: false,
      contentType: false,
      success:function(response){
        if(response.status==100){
          if( $('#tipoRemision').val() == 'incompetencia' ){

            $('#modal-success-titulo').html(`${response.message.split('-')[1]=='solicitud de remisión registrada'?'Enviado a autorización':response.message.split('-')[1]} <br> Folio: <span style="font-weight: bolder;"">${response.response.folio}</span>`);

          }else if( $('#tipoRemision').val() == 'tribunal_enjuiciamiento' ){

            $('#modal-success-titulo').html(`${response.message.split('-')[1]} <br> Folio: <span style="font-weight: bolder;"">${response.response.folio}</span>`);

          }else if( $('#tipoRemision').val() == 'ley_nacional') {
            $('#modal-success-titulo').html(`${response.message.split('-')[1]} <br> Folio: <span style="font-weight: bolder;"">${response.response.folio}</span>`);
          }
          
          if( $('#tipoRemision').val() == 'unidad_ejecucion' ){
            abreModal('modalRemision',1000);
            remisionUnidadEjecucion();
          }else{
            $('#btnCerrarSuccess').attr('data-modal','');
            $('#modalSuccess').modal('show');
          }
          
        }else{
          error('Error', response.message , 'modalRemision');
        }
        setTimeout(()=>{
          $('#modal_loading').modal('hide');
        },500);
      }
    });
  }
}

function consultaRemisiones(carpeta_judicial){
  return new Promise(resolve => {
    $.ajax({
      method:'POST',
      url:'/public/consultar_remisiones_carpeta',
      data:{carpeta_judicial},
      success:function(response){
        resolve(response);
      }
    });
  }); 
}

function obtenerFechasAudSent(carpeta_judicial,fecha_selec){
     
  return new Promise(resolve => {
    $.ajax({
      method:'POST',
      url:'/public/obtener_fechas_aud_sent',
      data:{carpeta_judicial},
      success:function(response){
        let options='';
        if( response.status == 100 ){
          $(response.response).each(function(index, audiencia){
            moment.locale('es-mx');          
            const { hora_inicio_audiencia, hora_fin_audiencia, id_audiencia, fecha_audiencia} = audiencia;
            
            options += `<option value="${audiencia.id_audiencia}" data-juez="${audiencia.juez.nombre_usuario}" data-cvj="${audiencia.id_juez}" data-fecha="${audiencia.fecha_audiencia} ${audiencia.hora_inicio_audiencia}" ${ fecha_selec == fecha_audiencia ? 'selected' : ''}> De ${moment(fecha_audiencia+" "+hora_inicio_audiencia).format('h:mm:ss a')} a ${moment(fecha_audiencia+" "+hora_fin_audiencia).format('h:mm:ss a')} del ${moment(fecha_audiencia).format('LL')} - ID: ${id_audiencia}</option>`;

            // if( fecha_selec === audiencia.fecha_audiencia){
            //   const option = `<option value="${audiencia.id_audiencia}" data-juez="${audiencia.juez.nombre_usuario}" data-cvj="${audiencia.id_juez}" data-fecha="${audiencia.fecha_audiencia} ${audiencia.hora_inicio_audiencia}" selected>${moment(fecha).format('ll')} [${moment(hora_inicio_audiencia).format('LTS')} - ${moment(hora_fin_audiencia).format('LTS')}] ID: ${audiencia.id_audiencia}</option>`;
            //   options=options.concat(option);
            // }else{
            //   const option = `<option value="${audiencia.id_audiencia}" data-juez="${audiencia.juez.nombre_usuario}" data-cvj="${audiencia.id_juez}" data-fecha="${audiencia.fecha_audiencia} ${audiencia.hora_inicio_audiencia}">${moment(fecha).format('ll')} [] ID: ${audiencia.id_audiencia}</option>`;
            //   options=options.concat(option);
            // }
          });
        }
        resolve(options)
      }
    });
  }); 
}

async function leeDocumento (input, tipo_archivo='', documento) {
  let b_subiendo = 0;
 
  const file =  $('#'+input.id).val(),
        ext = file.substring(file.lastIndexOf(".")),
        tipos_archivo = tipo_archivo.split(',');
        
  if( ext!='' ){
 
    if( tipo_archivo != '' && !tipos_archivo.includes( ext ) ){
 
      error( 'Tipo de archivo inválido', 'Solo puede adjutar archivos '+ tipo_archivo ,'modalRemision');
      $('#'+input.id).val('');

    }else{
 
      if( input.files && input.files[0] ) {
 
        
        if ( documento == 'TE'  ) {
          
          const reader = new FileReader();
          reader.readAsDataURL(input.files[0]);
          reader.onload = e => {
              $('#documentoPDF').attr('data', e.target.result); 
              $('#documentoPDF').removeClass('d-none');
              $('#bDoc').val(e.target.result.split('base64,')[1]);
          }
          
        }else if( ['copia_certificada_sentencia','copia_certificada_auto','acta_minima'].includes(documento)) {
          
          b_cargando ++;
          $('#div_'+documento).html(doc_loadind);
          $('#'+input.id).parent().addClass('d-none');
          
          const dataDoc = await datosDoc(input, ext, documento);
          if( informacion_complementaria.documentos_remision_ue[documento] ){
            informacion_complementaria.documentos_remision_ue[documento].url = dataDoc.url;
            informacion_complementaria.documentos_remision_ue[documento].nombre_archivo = dataDoc.nombre_archivo;
            informacion_complementaria.documentos_remision_ue[documento].extension = dataDoc.extension;
            informacion_complementaria.documentos_remision_ue[documento].estatus = dataDoc.estatus;   
          }else{
            informacion_complementaria.documentos_remision_ue[documento] = dataDoc;
          }

          b_cargando --;
          $('#div_'+documento).html(`
            <div style="padding-top: 13px;">
              <a href="javascript:void(0)" ondblclick="abrirDocumento('${documento}')" class="d-none d-md-inline-flex">
                <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative; color: #C6362D"></i>
              </a>
              <a href="${dataDoc.url}" class="d-inline-flex d-md-none">
                <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
              </a>
              <a href="javascript:void(0)" onclick="eliminarDocumento('${documento}')" class="mg-l-auto" style="position: absolute;">
                <i class="fa fa-times-circle tx-danger btn-cancel" aria-hidden="true" style="font-size:1rem;padding-top:4px;position: relative;top: -13px;"></i>
              </a>
            </div>`);
          
        }else if( documento == 'adjunto' ){
          
          const dataDoc = await datosDoc(input, ext, documento);
          dataDoc.estatus = 1;
          dataDoc.tipo_documento = $('#tipo_documento_adjunto').val();
          adjuntos_remision.push(dataDoc);
          showAdjuntos()
        }else if ( documento == 'unidad_ejecucion'){
          
          documento_remision = documento_remision.map( documento => {
            documento.estatus = 0;
            return documento;
          } );

          const dataDoc = await datosDoc(input, ext, documento);
          documento_remision.push(dataDoc);
          $('#documentoPDF').attr('data',dataDoc.url).removeClass('d-none')

        }else{
          const dataDoc = await datosDoc(input, ext, documento);
          documento_remision = dataDoc;
          $('#documentoPDF').attr('data',dataDoc.url).removeClass('d-none')
        }
      }
    }
  }
  
}

function eliminarDocumento(doc, index=''){

    $('#div_'+doc).html('');
    $('#'+doc).parent().removeClass('d-none');
    documentos_remision_ue[doc] = '';
  
}

function datosDoc( input, ext = '', documento = '' ){
  return new Promise( resolve => {
    let icon;
    switch (ext){
      case '.pdf':
      case '.PDF':
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

    const nombre_archivo = normalize((input.files[0].name).replace(ext,'')) + ext,
          tamanio_archivo = input.files[0].size;
    
    form = new FormData($("#formRemision")[0]);
    form.append('origen','b64'),
    form.append('tipo_documento', documento);
    form.append('ext', ext);
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
                documento,
                estatus: 1
              };
        resolve(dataDoc);
      }
    });
    
  });
}

function indicaJuez(){
  const juez = $('#fechaAudienciaSentencia option:selected').attr('data-juez');
  $('#juezDictoSent').val(juez);
  $('#inicial .square-8 ').remove();
  $('#inicial').append('<span class="square-8 bg-danger mg-r-5 mg-l-5 rounded-circle"></span>');
}

function obtenerDocumentosRemision( remision, version = '' ) {
  
  return new Promise( resolve => {

    $.ajax({
      method: 'POST',
      url: '/public/obtener_documentos_remision',
      data: {remision, version},
      success: function( response ) {
        resolve(response);
      }
    });
  });
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

let top_calendar = 0;

$('#modalRemision').on('scroll', function() {
  
  const scroll = $(this).scrollTop();
  const scroll_window = $(window).scrollTop();
  let nuevo_top = top_calendar - scroll + scroll_window;

  
  $('#ui-datepicker-div').css({top: ( nuevo_top )})
  
});

$('#modalRemision').on( 'click', '.fc-datepicker', function() {
  top_calendar = $('#ui-datepicker-div').position().top + $('#modalRemision').scrollTop();
  // top_element = $('#'+$(this).attr('id')).position().top
  // console.log(top_element);
});


