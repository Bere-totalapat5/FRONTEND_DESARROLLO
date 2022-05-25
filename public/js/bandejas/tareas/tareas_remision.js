let tipo_unidad = [],
  unidades_gestion_destino,
  documento_remision = [],
  form,
  b_cargando,
  etapas_rue = [];
const 
  tipo_imputado = [46];

async function verRemisionCorreccion() {
  const datos_remision = await obtenerInfoRemision( tareaSeleccionada.id_tabla_asociada );
  
  if( datos_remision.status != 100 )
    alert( datos_remision.message );

  tareaSeleccionada = Object.assign( tareaSeleccionada, datos_remision['response'][0] );

  switch( tareaSeleccionada.tipo_remision ) {
    case 'incompetencia':
      verRemisionCorreccionInco(); 
      break;
    case 'unidad_ejecucion':
      verRemisionCorreccionUniEjec();
      break;
    case 'tribunal_enjuiciamiento':
      verRemisionCorreccionTE();
      break;
    case 'ley_nacional':
      verRemisionCorreccionLN();
      break;
    default:
      alert('Error en tipo de remisión:' + tareaSeleccionada.tipo_remision);
  }
  
}

async function verRemisionCorreccionInco() { 

  const data_carpeta = await new Carpeta( tareaSeleccionada.id_carpeta_judicial);
  let options_fiscalias = '',
    imputadosRemitidos = '';

  const keys = Object.keys(fiscalias);
  
  $( keys ).each(function( i, index_fiscalia ) {

    options_fiscalias += `<option value="${fiscalias[index_fiscalia].id_fiscalia}">${fiscalias[index_fiscalia].fiscalia}</option>`;
    
  });

  const {tipo_remision, carpeta_judicial, id_personas_remitidas, motivo_incompetencia, id_fiscalia, tipo_unidad_destino, lugar_internamiento, imputado_privado_libertad, motivo_incompetencia_otro, comentarios } = tareaSeleccionada;

  const partes_carpeta = await obtener_personas_carpeta(tareaSeleccionada.id_carpeta_judicial),
    arrPersonaremitidas = id_personas_remitidas == null ? [] : id_personas_remitidas.split(',');
  
  if( partes_carpeta.status == 100 )
    $( partes_carpeta.response.personas ).each(function( index, imputado ) {
      
      const {nombre, apellido_paterno, apellido_materno,razon_social, tipo_persona, id_persona, id_calidad_juridica} = imputado.info_principal;
      
      let checked = '';
      if( arrPersonaremitidas.includes(String(id_persona)) )
        checked = 'checked';

      if( id_calidad_juridica == 46 )
      imputadosRemitidos += ` 
        <div class="col-md-4">
          <label class="ckbox">
            <input type="checkbox" value="${id_persona}" data-tipo="${tipo_persona}" name="imputados_sel" ${checked}><span>${nombre==null?'':nombre}${razon_social==null?'':razon_social} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</span>
          </label>
        </div>
      `;
    });

  const documentos_remision = await obtener_documentos_remision( tareaSeleccionada.id_tabla_asociada );
  
  let formularioRemision = '';

  if( tipo_remision == 'incompetencia' ) {
    
    let documento = '';
    if( documentos_remision.status == 100 ) 
      documento = await obtener_documentos_remision( tareaSeleccionada.id_tabla_asociada, documentos_remision.response[0].id_documento );
    if( documento.status == 100 ) 
      documento_remision.push({id_documento:documentos_remision.response[0].id_documento, estatus: 1});

      if( data_carpeta.tipoCarpeta() == "TE" )
      formularioRemision = `
        <div  class="slim-pagetitle mg-t-20  mg-b-20">
          <h6 class="mg-b-0">Datos Generales:</h6>  
        </div>
        <div class="row mg-b-15 pd-10">
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Carpeta Judicial a Remitir:</label>
              <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${carpeta_judicial}" placeholder="N/E" autocomplete="off" readonly>
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
                <option selected value="">Seleccione una Opción</option>
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
              ${imputadosRemitidos}
            </div>  
          </div>
        </div>
        `
      ;
    else if( ['EJEC', 'UGJEMS'].includes(data_carpeta.tipoCarpeta()) )
      formularioRemision  = `
        <div class="row pd-10">
          <div class="col-6">
            <div  class="slim-pagetitle mg-t-20  mg-b-20">
              <h6 class="mg-b-0">Datos Generales:</h6>  
            </div>
          </div>
        </div>
        <div class="row mg-b-15 pd-10 pd-l-20">
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Carpeta Judicial a Remitir:</label>
              <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${carpeta_judicial}" placeholder="N/E" autocomplete="off" readonly>
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
              ${imputadosRemitidos}
            </div>  
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
        </div>
        <div class="row mg-b-15 pd-10 d-none-rm">
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label">Carpeta Judicial a Remitir:</label>
              <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${carpeta_judicial}" placeholder="N/E" autocomplete="off" readonly>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label class="form-control-label">Motivo de la incompetencia: <span class="tx-danger">*</span></label>
              <select class="form-control select2" id="motivoIncompetencia" name="motivo_incompetencia" autocomplete="off" onchange="motivoIncompretencia()">
                <option selected value="" disabled>Seleccione una Opción</option>
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
          <div class="col-lg-4"  style="display:none">
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
          <div class="col-lg-8" style="display: none">
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
          <div class="col-lg-4" id="divUnidadDestino" style="display: none">
            <div class="form-group">
              <label class="form-control-label mg-lg-b-20">Tipo de unidad destino: <span class="tx-danger">*</span></label>
              <select class="form-control" id="tipoUnidadDestino" name="tipo_unidad_destino" autocomplete="off"  onchange="obtenerInmuebleFiscalia()">
                <option selected value="">Seleccione una Opción</option>
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
                <option selected value="">Seleccione una Opción</option>
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
            <div class="row mg-t-20 pd-10" style="padding-left: 10px;">
              ${imputadosRemitidos}
            </div>  
          </div>
        </div>
      `;



    // formularioRemision = `
    //   <div style="border: 1px solid #eee; padding: 0.5em; background-color: #f8f9fa;">
    //     <form action="/" onsubmit="return false;" enctype="multipart/form-data" id="formRemision">
    //       <div class="row pd-10">
    //         <div class="col-12">
    //           <div  class="slim-pagetitle mg-t-20  mg-b-20">
    //             <h6 class="mg-b-0">Datos Generales:</h6>  
    //           </div>
    //         </div>
    //       </div>
    //       <div class="row mg-b-15 pd-10">
    //         <div class="col-lg-4">
    //           <div class="form-group mg-b-10-force">
    //             <label class="form-control-label">Carpeta Judicial a Remitir:</label>
    //             <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${carpeta_judicial}" placeholder="N/E" autocomplete="off" readonly>
    //           </div>
    //         </div>
    //         <div class="col-lg-4">
    //           <div class="form-group">
    //             <label class="form-control-label">Motivo de la incompetencia: <span class="tx-danger">*</span></label>
    //             <select class="form-control select2" id="motivoIncompetencia" name="motivo_incompetencia" autocomplete="off" onchange="motivoIncompretencia()">
    //               <option selected value="" disabled>Seleccione una Opción</option>
    //               <option value="otra_materia" data-valor="0">Pertenece a otra materia</option>
    //               <option value="vinculacion_proceso" data-valor="3">Por vinculación a proceso</option>
    //               <option value="violencia_genero" data-valor="4">Por turno extraodinario violencia de género</option>
    //               <option value="mandato_zona" data-valor="40">Por mandato judicial - zona territorial</option>
    //               <option value="otro" data-valor="5">Otro</option>
    //             </select>
    //           </div>
    //         </div>
    //         <div class="col-lg-4">
    //           <div class="form-group mg-b-10-force">
    //             <label class="form-control-label">Motivo de la incompetencia (Otro):</label>
    //             <input class="form-control" type="text" placeholder=""  name="motivo_incompetencia_otro" id="motivoIncompetenciaOtro" autocomplete="off" readonly>
    //           </div>
    //         </div>
    //       </div>
    // `;

    // if( carpeta_judicial.substring(0,2) != "TE")
    //   formularioRemision  += `
        
    //     <div class="row mg-b-15  pd-10">
    //       <div class="col-lg-4">
    //         <div class="form-group" id="materiaDestino">
    //           <label class="form-control-label">Materia Destino: <span class="tx-danger">*</span></label>
    //           <div class="d-inline-block mg-l-5 mg-t-10" id="divMateriaDestino">
    //             <label class="rdiobox d-inline-block mg-l-5">
    //               <input name="materia_destino" type="radio" value="adultos" class="materia_destino">
    //               <span class="pd-l-0">Penal Adultos</span>
    //             </label>
    //             <label class="rdiobox d-inline-block mg-l-5">
    //               <input name="materia_destino" type="radio" value="adolescentes" class="materia_destino">
    //               <span class="pd-l-0">Penal Adolescentes</span>
    //             </label>
    //           </div>
    //         </div>
    //       </div>
    //       <div class="col-lg-8">
    //         <div class="form-group">
    //           <label class="form-control-label">Fiscalía: <span class="tx-danger">*</span></label>
    //           <select class="form-control select2-show-search" id="fiscalia" name="fiscalia" autocomplete="off" onchange="obtenerInmuebleFiscalia()">
    //             <option selected disabled  value="" >Elija una opción</option>
    //             ${options_fiscalias}
    //           </select>
    //         </div>
    //       </div><!-- col-4-->
    //     </div>
    //     <div class="row mg-b-15 pd-10">
    //       <div class="col-lg-4" id="divUnidadDestino">
    //         <div class="form-group">
    //           <label class="form-control-label mg-lg-b-20">Tipo de unidad destino: <span class="tx-danger">*</span></label>
    //           <select class="form-control select2-show-search" id="tipoUnidadDestino" name="tipo_unidad_destino" autocomplete="off"  onchange="obtenerInmuebleFiscalia()">
    //             <option selected value="">Seleccione una Opción</option>
    //             <option value="X" >Unidad especializada en Aprehensiones, Cateos y Técnicas de Investigacion</option>
    //             <option value="B">Unidad especializada en delitos de Oficio</option>
    //             <option value="A" >Unidad especializada en delitos de Querella</option>
    //             <option value="M" >Unidad especializada en Mujeres</option>
    //           </select>
    //         </div>
    //       </div>
    //       <div class="col-lg-4">
    //         <div class="form-group" >
    //           <label class="form-control-label ">¿El imputado se encuentra privado de su libertad?: <span class="tx-danger">*</span></label>
    //           <div class="d-inline-block mg-l-10" id="privadoLibertadDiv">
    //             <label class="rdiobox d-inline-block mg-l-50">
    //               <input name="privado_libertad" onclick="privadoLib(this);" type="radio" value="si">
    //               <span class="pd-l-0">Si</span>
    //             </label>
    //             <label class="rdiobox d-inline-block mg-l-30">
    //               <input name="privado_libertad" onclick="privadoLib(this);"  type="radio" value="no">
    //               <span class="pd-l-0">No</span>
    //             </label>
    //           </div>
    //         </div>
    //       </div>
    //       <div class="col-lg-4" id="divInternamiento" >
    //         <div class="form-group">
    //           <label class="form-control-label  mg-lg-b-20">Lugar de internamiento: <span class="tx-danger d-none">*</span></label>
    //           <select class="form-control select2" id="lugarInternamiento" name="lugar_internamiento" autocomplete="off" disabled>
    //             <option selected value="">Seleccione una Opción</option>
    //             <option value="00020005">Centro de Ejecución de Sanciones Penales Varonil Norte</option>
    //             <option value="00020006">Centro de Ejecución de Sanciones Penales Varonil Oriente</option>
    //             <option value="00020010">Centro de Reinserción Social Varonil (CERESOVA)</option>
    //             <option value="00020009">Centro Femenil de Reinserción Social (Tepepan)</option>
    //             <option value="00020014">Centro Preventivo y de Reinserción Social Chalco</option>
    //             <option value="00020004">Centro Varonil de Rehabilitación Psicosocial (CEVAREPSI)</option>
    //             <option value="00020011">Centro Varonil de Seguridad Penitenciaria I (CEVASEP I)</option>
    //             <option value="00020012">Centro Varonil de Seguridad Penitenciaria II (CEVASEP II)</option>
    //             <option value="00020013">Institución Abierta Casa de Medio Camino</option>
    //             <option value="00020007">Penitenciaría de la Ciudad de México</option>
    //             <option value="00020008">Centro Femenil de Reinserción Social (Santa Martha)</option>
    //             <option value="00020001">Reclusorio Preventivo Varonil Norte</option>
    //             <option value="00020002">Reclusorio Preventivo Varonil Oriente</option>
    //             <option value="00020003">Reclusorio Preventivo Varonil Sur</option>                
    //           </select>
    //         </div>
    //       </div>  
    //     </div>
    //     <div class="row mg-b-15 pd-10">
    //       <div class="col-lg-4" id="divEdificioReceptor">
    //         <div class="form-group">
    //           <label class="form-control-label">Edificio/reclusorio receptor: <span class="tx-danger d-none">*</span></label>
    //           <select class="form-control select2" id="edificioReceptor" name="edificio_receptor" autocomplete="off" readonly onchange="obtenerUnidadDestino()">
    //             <option selected value="">Seleccione una Opción</option>
    //             <option value="7">Reclusorio Preventivo Varonil Norte</option>
    //             <option value="8">Reclusorio Preventivo Varonil Oriente</option>
    //             <option value="9">Reclusorio Preventivo Varonil Sur</option>
    //             <option value="10">Centro Femenil de Reinserción Social (Santa Martha)</option>
    //             <option value="5">Dr. Lavista</option>
    //             <option value="4">Sullivan</option>
    //           </select>
    //         </div>
    //       </div>
    //       <div class="col-lg-8"  id="divSelectDestino">
    //         <div class="form-group mg-b-10-force">
    //           <label class="form-control-label">Unidad Destino</label>
    //           <input class="form-control" type="text" name="select_unidad" id="select_unidad" value="" autocomplete="off" readonly>
    //         </div>
    //       </div>
    //     </div>
    //     <div class="row mg-b-15 pd-10"> 
    //       <div class="col-lg-12">
    //         <div class="form-group">
    //           <label class="form-control-label">Comentarios Adicionales</label>
    //           <textarea id="comentariosAdicionales" rows="3" name="comentarios_adicionales" style="width:100%"></textarea>
    //         </div>
    //       </div>
    //     </div>
    //     <div class="row mg-b-15 pd-10">
    //       <div class="col-md-12">
    //         <div  class="slim-pagetitle mg-t-20">
    //           <h6>Seleccione los imputados que serán remitidos en la incompetencia: <span class="tx-danger">*</span></h6>  
    //         </div>
    //         <div class="row mg-t-20 pd-10">
    //           ${imputadosRemitidos}
    //         </div>  
    //       </div>
    //     </div>      
    //   `;
    // else
    //   formularioRemision += `
    //     <div class="row mg-b-15 pd-10">
    //       <div class="col-lg-4">
    //         <div class="form-group mg-b-10-force">
    //           <label class="form-control-label">Motivo de la incompetencia (Otro):</label>
    //           <input class="form-control" type="text" placeholder=""  name="motivo_incompetencia_otro" id="motivoIncompetenciaOtro" autocomplete="off" readonly>
    //         </div>
    //       </div>
    //       <div class="col-lg-4">
    //         <div class="form-group" >
    //           <label class="form-control-label ">¿El imputado se encuentra privado de su libertad?: <span class="tx-danger">*</span></label>
    //           <div class="d-inline-block mg-l-10" id="privadoLibertadDiv">
    //             <label class="rdiobox d-inline-block mg-l-50">
    //               <input name="privado_libertad" onclick="privadoLib(this);" type="radio" value="si">
    //               <span class="pd-l-0">Si</span>
    //             </label>
    //             <label class="rdiobox d-inline-block mg-l-30">
    //               <input name="privado_libertad" onclick="privadoLib(this);"  type="radio" value="no">
    //               <span class="pd-l-0">No</span>
    //             </label>
    //           </div>
    //         </div>
    //       </div>
    //       <div class="col-lg-4" id="divInternamiento" >
    //         <div class="form-group">
    //           <label class="form-control-label">Lugar de internamiento: <span class="tx-danger d-none">*</span></label>
    //           <select class="form-control select2" id="lugarInternamiento" name="lugar_internamiento" autocomplete="off" disabled onchange="lugarInternamientoInc()">
    //             <option selected value="">Seleccione una Opción</option>
    //             <option value="00020005">Centro de Ejecución de Sanciones Penales Varonil Norte</option>
    //             <option value="00020006">Centro de Ejecución de Sanciones Penales Varonil Oriente</option>
    //             <option value="00020010">Centro de Reinserción Social Varonil (CERESOVA)</option>
    //             <option value="00020009">Centro Femenil de Reinserción Social (Tepepan)</option>
    //             <option value="00020014">Centro Preventivo y de Reinserción Social Chalco</option>
    //             <option value="00020004">Centro Varonil de Rehabilitación Psicosocial (CEVAREPSI)</option>
    //             <option value="00020011">Centro Varonil de Seguridad Penitenciaria I (CEVASEP I)</option>
    //             <option value="00020012">Centro Varonil de Seguridad Penitenciaria II (CEVASEP II)</option>
    //             <option value="00020013">Institución Abierta Casa de Medio Camino</option>
    //             <option value="00020007">Penitenciaría de la Ciudad de México</option>
    //             <option value="00020008">Centro Femenil de Reinserción Social (Santa Martha)</option>
    //             <option value="00020001">Reclusorio Preventivo Varonil Norte</option>
    //             <option value="00020002">Reclusorio Preventivo Varonil Oriente</option>
    //             <option value="00020003">Reclusorio Preventivo Varonil Sur</option>                
    //           </select>
    //         </div>
    //       </div>  
    //       <div class="col-lg-4" id="divEdificioReceptor">
    //         <div class="form-group">
    //           <label class="form-control-label">Edificio/reclusorio receptor: <span class="tx-danger d-none">*</span></label>
    //           <select class="form-control select2" id="edificioReceptor" name="edificio_receptor" autocomplete="off" readonly onchange="obtenerUnidadDestino()">
    //             <option value="-1" valdefault="1">Elija una opción</option>
    //             <option value="1">Tribunal Enjuiciamiento Sede Norte</option>
    //             <option value="2">Tribunal Enjuiciamiento Sede Oriente</option>
    //             <option value="4">Tribunal Enjuiciamiento Sede Sullivan</option>
    //             <option value="3">Tribunal Enjuiciamiento Sede Sur</option>
    //           </select>
    //         </div>
    //       </div>
    //       <div class="col-lg-12">
    //         <div class="form-group">
    //           <label class="form-control-label">Comentarios Adicionales</label>
    //             <textarea id="comentariosAdicionales" rows="2" name="comentarios_adicionales" ></textarea>
    //         </div>
    //       </div>
    //     </div>
    //     <div  class="slim-pagetitle mg-t-20  mg-b-20">
    //       <h6 class="mg-b-0">Seleccione los imputados que serán remitidos en la incompetencia:</h6>  
    //     </div>
    //     <div class="row pd-10">
    //       <div class="col-md-12">
    //         <div class="row mg-t-20">
    //           ${imputadosRemitidos}
    //         </div>  
    //       </div>
    //     </div>
    //     <div  class="slim-pagetitle mg-t-30 mg-b-20">
    //       <h6>Documento</h6>  
    //     </div>
    //   `
    //   ;

      const newLocal = `
            <div class="row mg-b-15 pd-10">
              <div class="col-md-12">
                <div  class="slim-pagetitle mg-t-20 mg-b-20">
                  <h6>Documento</h6>  
                </div>
                <div class="custom-input-file mg-t-30">
                  <input type="file" id="archivoPDF2" class="input-file" name="documento_adjunto" accept="application/pdf" onchange="leeDocumento_v2(this, '.pdf', 'incompetencia')">
                  <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
                </div>
              </div>
              <div id="divDocumento" style="width:100%" class="col-12">
                <object data="${documento['response']}"  id="documentoPDF" width="100%" height="380px" class=""></object>
                <input type="hidden" id="bDoc" name="bDoc">
              </div>
            </div>
          </form>
        </div>
      `;
      formularioRemision += newLocal;
  } else if ( tipo_remision == 'tribunal_enjuiciamiento' ) {
    alert('');
  }

  $('#divTarea').html(formularioRemision);
  $('#divTarea .select2').select2({minimumResultsForSearch: Infinity});
  $('#divTarea .select2-show-search').select2({minimumResultsForSearch: ''});
  $('#motivoIncompetencia').val(motivo_incompetencia).trigger('change');
  if( motivo_incompetencia == 'otro') $('#motivoIncompetenciaOtro').removeAttr('disabled');
  $('#motivoIncompetenciaOtro').val(motivo_incompetencia_otro == null ? '' : motivo_incompetencia_otro).trigger('change');
  $('#fiscalia').val(id_fiscalia).trigger('change');
  $('#tipoUnidadDestino').val(tipo_unidad_destino).trigger('change');
  $('#lugarInternamiento').val(lugar_internamiento == null ? '' : String(lugar_internamiento).padStart(8, 0)).trigger('change');
  $('input[name=privado_libertad][value='+imputado_privado_libertad+']').prop('checked', true);
  if( imputado_privado_libertad == 'si' ) $('#lugarInternamiento').removeAttr('disabled');
  $('#comentariosAdicionales').val( comentarios == null ? '' : comentarios);
  $('#modalDatosTarea').modal('show');
  

}

function motivoIncompretenciaEjec() {

  $('#lugarInternamiento').val('').trigger('change').attr('readondisabledly', true);
  $('#select_unidad_select').val('').trigger('change').attr('disabled', true);
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

}

async function verRemisionCorreccionUniEjec(seccion_actual=''){
  
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
  carpeta_remitir = tareaSeleccionada;
  
  $("#formularioRemision").html('<div class="d-flex ht-300 pos-relative align-items-center"><div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div><div class="sk-cube2 sk-cube"></div><div class="sk-cube4 sk-cube"></div><div class="sk-cube3 sk-cube"></div></div></div><!-- d-flex -->');
  
  const {delitos, id_carpeta_judicial, carpeta_judicial, carpeta_investigacion, imputados} = tareaSeleccionada;

  $('#btnSiguiente').attr('disabled',true);
  $('#delitoPena').html('<option value="" disabled selected>Seleccione una opción</option>');

  $(delitos).each( function( index, delito ){ $('#delitoPena').append(`<option value="${delito.id_delito}">${delito.delito}</option>`); });

  $('#imputados').html('<option value="" disabled selected>Seleccione una opción</option>');

  $(imputados).each( function( index, imputado ){
    const { nombre, razon_social, tipo,id_persona } = imputado;
    $('#imputados').append( `<option value="${id_persona}" data-tipo="${tipo}">${nombre==null?'':nombre}${razon_social==null?'':razon_social}</option>` );
  });

  let fecha_audiencia_sentencia = '',
      juez_dicto_sentencia = '',
      fecha_causa_ejecutoria = '',
      comentarios_adicionales = '',
      fechasAudiencias = '';
      documento_remision_ejec = '';
  
  

    const { EJEC_fecha_ejecutoria, EJEC_nom_juez_sentencia, EJEC_fecha_audiencia, EJEC_secciones_completadas, id_remision, comentarios } = tareaSeleccionada;
    
    documentos_remision_arr = await obtenerDocumentosRemision( id_remision ); 
   
    if( documentos_remision_arr.status == 100 ) {
      
      doc_rem = documentos_remision_arr.response.filter( doc => !['_sentencia.pdf', '_auto.pdf', '_audiencia.pdf'].includes( doc.nombre_archivo.replace( id_remision,'' ))); 

      documento_remision.push({ id_documento: doc_rem[0].id_documento, estatus: 1 });
      documento = await obtenerDocumentosRemision( id_remision, doc_rem[0].id_documento ); 
      
      if( documento.status == 100 )
        documento_remision_ejec = documento.response;
    
    }

    remision_in = id_remision;
    secciones_completadas = JSON.parse(EJEC_secciones_completadas);
    fecha_audiencia_sentencia = EJEC_fecha_audiencia == null ? '' : EJEC_fecha_audiencia.split(' ')[0];
    juez_dicto_sentencia = EJEC_nom_juez_sentencia;
    expFecha = EJEC_fecha_ejecutoria == null ? '--' : EJEC_fecha_ejecutoria.split('-');
    fecha_causa_ejecutoria = expFecha[2] + '-' + expFecha[1] + '-' + expFecha[0];
    
    fechasAudiencias = await obtenerFechasAudSent( id_carpeta_judicial, fecha_audiencia_sentencia );

  let tipos_documentos_op = '';

  $(tipos_documentos_carpeta).each( function( index, doc ) {
    const option = `<option value="${doc.id_documento}">${doc.nombre}</option>`;
    tipos_documentos_op = tipos_documentos_op.concat(option);
  });
  
  formularioRemision  = `
    <form action="/" onsubmit="return false;" enctype="multipart/form-data" id="formRemision">
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
                    <input class="form-control" type="text" name="carpeta_judicial_remitir" id="carpetaJudicialRemitir" value="${carpeta_judicial}" placeholder="" autocomplete="off" disabled style="background:#FFF">
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
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Fecha de la audiencia en la cual se dicta sentencia:<span class="tx-danger">*</span></label>
                    <select class="form-control select2" id="fechaAudienciaSentencia" name="fecha_audiencia_sentencia" autocomplete="off" onchange="indicaJuez()">
                      <option value="">Seleccione una Opción</option>
                      ${fechasAudiencias}
                    </select>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Juez que dictó sentencia:</label>
                    <input class="form-control" type="text" name="juez_dicto_sentencia" id="juezDictoSent" value="${juez_dicto_sentencia}" placeholder="" autocomplete="off" style="background: #fff;" readonly>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Fecha a partir de la cual causa ejecutoria:<span class="tx-danger">*</span></label>
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
                    <textarea class="form-control" type="text" id="comentarios" name="comentarios" autocomplete="off">${comentarios == null ? "" : comentarios}</textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="custom-input-file mg-t-30">
                    <input type="file" id="archivoPDF2" class="input-file" name="documento_remision" accept="application/pdf" onchange="leeDocumento_v2(this, '.pdf', 'unidad_ejecucion')">
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
                  <button class="btn btn-primary mg-l-auto" onclick="actualizar_remision('no')">Guardar</button>
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
                            <input type="file" id="copia_certificada_sentencia" class="input-file" value="" name="copia_certificada_sentencia" onchange="leeDocumento_v2(this, '.pdf', 'copia_certificada_sentencia')" accept="application/pdf">
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
                            <input type="file" id="copia_certificada_auto" class="input-file" value="" name="copia_certificada_auto" onchange="leeDocumento_v2(this, '.pdf', 'copia_certificada_auto')" accept="application/pdf">
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
                            <input type="file" id="acta_minima" class="input-file" value="" name="acta_minima" onchange="leeDocumento_v2(this, '.pdf', 'acta_minima')" accept="application/pdf">
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
                    <input type="file" id="documento_adjunto" class="input-file" value="" name="documento_adjunto" onchange="leeDocumento_v2(this, '', 'adjunto')">
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
    </form>
  `;

  $('#divTarea').html(formularioRemision);
  $('#modalDatosTarea').modal('show');

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
  $('#fechaAudiencia').trigger('change');
  // $('#btnSiguiente').attr('onclick', 'remisionEjecAutorizacion()');
  
  
  $('#fechaCausaEjecutoria').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    format: 'yyyy/mm/dd',
    changeYear: true,
    yearRange: "c-100:c+0"
  });

  if( secciones_completadas.length ){

    $('.seccion').removeClass('d-none active tx-danger');
    secciones = $('.seccion');
    $('#inicial').click().addClass('active');
    // $(secciones_completadas).each( function( index, seccion ){

    //   if( seccion_actual != '' )
    //     $('#'+seccion_actual).click().addClass('active');
    //   else
    //     if( secciones.length == secciones_completadas.length ) 
    //       $('#'+secciones[secciones_completadas.length-1].id).click().addClass('active');
    //     else 
    //       $('#'+secciones[secciones_completadas.length].id).click().addClass('active');

      
    // });

    if( secciones_completadas.length == 3 )
      $('#btnSiguiente').removeAttr('disabled');
    else
      $('#btnSiguiente').attr('disabled', true);
  }

  obtenerPersonasRemisionRUE(tareaSeleccionada.id_remision);
  obtenerPersonasCarpetaRUE(tareaSeleccionada.id_carpeta_judicial);
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

function obtenerInfoRemision( remision ) {

  return new Promise( resolve => {
    $.ajax({
      method:'POST',
      url:'/public/obtener_datos_remision',
      data:{ remision },
      success: function( response ){ resolve( response ); },
    });
  });
}

async function motivoIncompretencia(){
        
  $('#motivoIncompetenciaOtro').val('').attr('readonly', true);
  $(".materia_destino").removeAttr('readonly').parent().parent().parent().find('.tx-danger').removeClass('d-none');
  // $('#tipoUnidadDestino').attr('readonly',true).val('').select2({minimumResultsForSearch: Infinity}).parent().find('.tx-danger');
  $('#edificioReceptor').val('').attr('disabled',true).select2({minimumResultsForSearch: Infinity}).parent().find('.tx-danger').addClass('d-none');
  $("input[name=materia_destino]").prop("checked", false).removeAttr('disabled');


  switch($('#motivoIncompetencia').val()){
    case "otra_materia":
      
      if( tareaSeleccionada.materia_destino == !'adultos' ) {
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
      break;
    case "mandato_zona":
      $(".materia_destino").attr('disabled', true).parent().parent().parent().find('.tx-danger').addClass('d-none');
      $('#tipoUnidadDestino').removeAttr('disabled').parent().find('.tx-danger');
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

function privadoLib(option) {
  if( $(option).val() == 'si' ) {
    $('#lugarInternamiento').removeAttr('disabled');
      if ( $('#motivoIncompetencia').val() == 'mandato_judicial' )
        $('#edificioReceptor').removeAttr('disabled');
  } else {
    $('#lugarInternamiento').val('').trigger('change').attr('disabled', true);
  }  
}

async function leeDocumento_v2 (input, tipo_archivo='', documento) {
  let b_cargando = 0;
  
  const file =  $('#'+input.id).val(),
        ext = file.substring(file.lastIndexOf(".")),
        tipos_archivo = tipo_archivo.split(',');
        
  if( ext!='' ){
 
    if( tipo_archivo != '' && !tipos_archivo.includes( ext ) ){
 
      error( 'Tipo de archivo inválido', 'Solo puede adjutar archivos '+ tipo_archivo ,'modalDatosTarea');
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
                <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
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

        }else if ( ['incompetencia', 'tribunal_enjuiciamiento', 'ley_nacional', 'acuerdo_remision'].includes(documento) ){

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

function datosDoc( input, ext = '', documento = '' ){
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

function obtener_personas_carpeta( carpeta ) {
  return new Promise( resolve => {
    $.ajax({
      method: 'POST',
      url: '/public/obtener_personas_carpeta',
      data: {carpeta},
      success: function( response ) { 
        resolve( response );
      }
    });
  });
}

function obtener_documentos_remision( remision , version = '' ) {
  return new Promise( resolve => {
    $.ajax({
      method: 'POST',
      url: '/public/obtener_documentos_remision',
      data: {remision, version},
      success: function( response ) { 
        resolve( response );
      }
    });
  });
}

function actualizar_remision( autorizacion = 'si' ,finalizar = false ) {

  form = false;
  let validacion = 0;

  if( tareaSeleccionada.tipo_remision == '' || tareaSeleccionada.tipo_remision == null ){

    error('Datos Incompletos', 'No ha seleccionado el tipo de remisión', 'modalDatosTarea');
    $('span[aria-labelledby="select2-tipoRemision-container"]').addClass('error');
    return 0;

  }else if( tareaSeleccionada.tipo_remision == 'incompetencia' ){

    validacion = validaRemInc();

  }else if( tareaSeleccionada.tipo_remision == 'tribunal_enjuiciamiento' ){

    validacion=validaRemTriEnj();

  }else if( tareaSeleccionada.tipo_remision == 'unidad_ejecucion' ){

    validacion=validaRemUniEjec( autorizacion );

    if( tareaSeleccionada.id_remision && !finalizar == finalizar){

      $('#modalDatosTarea').modal('hide');
      $('#modal_loading').modal('show');
      actualizarPersonasRemision('inicial');
      $('#inicial .square-8 ').remove();
      return 0;

    }

  }else if( tareaSeleccionada.tipo_remision == 'ley_nacional') {
  
    validacion = validaLN();

  }
  
  if( validacion === 100 ) {
    
    $('#modalDatosTarea').modal('hide');
    $('#modal_loading').modal('show');
    $.ajax({
      method:'POST',
      url:'/public/modificar_remision',
      data:form,
      processData: false,
      contentType: false,
      success:function(response){
        if( response.status == 100 ){

          if( autorizacion == 'no' ) {
            setTimeout(()=>{
              $('#modalDatosTarea').modal('show'); 
            },600);   

            $('#inicial').find('span').remove();
          }else {
            $('#successMessage').html(`${response.message}`);
            $('#modalSuccess').modal('show');  
            buscar(1);
          }

        }else{
          error('Error', response.message , 'modalDatosTarea');
        }
        setTimeout(()=>{
          $('#modal_loading').modal('hide');
        },500);
      }
    });
  }
}

function validaRemInc(){
  $('.error').removeClass('error');

  let strImputados='';

  if($('#motivoIncompetencia').val()=='' || $('#motivoIncompetencia').val()==null){
    error('Datos Incompletos', 'No ha seleccionado el motivo de incompetencia', 'modalDatosTarea');
    $('span[aria-labelledby="select2-motivoIncompetencia-container"]').addClass('error');
    return 0;
  }

  if($('#motivoIncompetencia').val()=='otro'){
    if(expVacio.test($('#motivoIncompetenciaOtro').val())){
      error('Datos Incompletos', 'Indique el motivo de la incompetencia (otro)', 'modalDatosTarea');
      $('#motivoIncompetenciaOtro').addClass('error');
      return 0;
    }
  }

  if($('#motivoIncompetencia').val() == 'otra_materia' || $('#motivoIncompetencia').val() == 'vinculacion_proceso' || $('#motivoIncompetencia').val() == 'otro'){
    if($('input:radio[name=materia_destino]:checked').val() == undefined){
      error('Datos Incompletos', 'No ha seleccionado la materia destino', 'modalDatosTarea');
      $('#divMateriaDestino').addClass('error');
      return 0;
    }
  }

  if( ($('#fiscalia').val()=='' || $('#fiscalia').val()==null) && tareaSeleccionada.carpeta_judicial.substring(0,2) != "TE" && tareaSeleccionada.carpeta_judicial.substring(0,4) != "EJEC" ){
    error('Datos Incompletos', 'No ha seleccionado la fiscalia', 'modalDatosTarea');
    $('span[aria-labelledby="select2-fiscalia-container"]').addClass('error');
    return 0;
  }

  // if($('#tipoUnidadDestino').val()=='' || $('#tipoUnidadDestino').val() == null){
  //   error('Datos Incompletos', 'No ha seleccionado el tipo de unidad destino', 'modalDatosTarea');
  //   $('span[aria-labelledby="select2-tipoUnidadDestino-container"]').addClass('error');
  //   return 0;
  // }

  if($('input:radio[name=privado_libertad]:checked').val() == undefined && tareaSeleccionada.carpeta_judicial.substring(0,4) != "EJEC"  ){
    error('Datos Incompletos', 'No ha indicado si el imputado se encuentra privado de su libertad', 'modalDatosTarea'); 
    $('#privadoLibertadDiv').addClass('error');
    return 0;
  }

  if($('input:radio[name=privado_libertad]:checked').val() == 'si'){
    if($('#lugarInternamiento').val()=='' || $('#lugarInternamiento').val() == null){
      error('Datos Incompletos', 'No ha seleccionado el lugar de internamiento', 'modalDatosTarea');
      $('span[aria-labelledby="select2-lugarInternamiento-container"]').addClass('error');
      return 0;
    }
  }

  if($('#motivoIncompetencia').val() == 'mandato_zona'){
    if($('#edificioReceptor').val()=='' || $('#edificioReceptor').val()==null){
      error('Datos Incompletos', 'No ha seleccionado el edificio receptor', 'modalDatosTarea');
      $('span[aria-labelledby="select2-edificioReceptor-container"]').addClass('error');
      return 0;
    }
  }

  if( !($('input[name=imputados_sel]:checked').length) ) {
    error('Datos Incompletos', 'No ha seleccionado a ningún imputado', 'modalDatosTarea');
    return 0;
  } else {
    let i = 0;
    $('input[name=imputados_sel]:checked').each( function() {
      if( i == 0 )
        strImputados = strImputados.concat($(this).val());
      else
        strImputados = strImputados.concat(','+$(this).val());
      
      i++;
    });
  }

  if( documento_remision.length < 1 ){
    error('Datos Incompletos', 'No ha agregado su documento PDF', 'modalDatosTarea');
    return 0;
  }
  
  form = new FormData($("#formRemision")[0]);

  if( $('#motivoIncompetencia').val() != 'mandato_zona'  && tareaSeleccionada.carpeta_judicial.substring(0,4) != "EJEC" )
    form.append('edificio_receptor', $('#edificioReceptor').val());
  
  form.append('remision', tareaSeleccionada.id_tabla_asociada);
  form.append('personas_remitidas', strImputados);
  form.append('dataDoc', JSON.stringify(documento_remision));
  let unidades = '';
  $(unidades_gestion_destino).each(function( i , id ) {
    if( i > 0 ) unidades += ','+id;
    else unidades += id;
  });

  form.append('unidades', unidades);

  return 100;
  
}

function verDocRemi(i, e){
  $('.bgDocRem').removeClass('bgDocRem');
  $(e).addClass('bgDocRem');
  $('.documento_remision').addClass('d-none');
  $('#documentoPDF'+i).removeClass('d-none');
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
            options += `<option value="${audiencia.id_audiencia}" data-juez="${audiencia.juez.nombre_usuario}" data-cvj="${audiencia.id_juez}" data-fecha="${audiencia.fecha_audiencia} ${audiencia.hora_inicio_audiencia}" ${fecha_selec == audiencia.id_audiencia ? 'selected' : ''}>${formatoFecha(audiencia.fecha_audiencia)}</option>`;
          });
        }
        resolve(options)
      }
    });
  }); 
}

function obtenerPersonasRemisionRUE(remision){
  $.ajax({
    method:'GET',
    url:'/public/obtener_personas_remision',
    data:{remision},
    success: async function(response){
      // let secciones_personas_completadas = [];
      // if( response.status == 100 )
      // secciones_personas_completadas = Object.keys(response.response);
        
      if( secciones_completadas.includes('sentenciados') ){
        $(response.response.sentenciados).each(function(index, sentenciado) {
          const {id_rem_per, estatus, id_persona, nombre, apellido_paterno, apellido_materno, razon_social, tipo_persona, en_libertad, id_unidad_centro_detencion, suspension_condicional, penas} = sentenciado;

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
                sustitutivos:sustitutivos_pena_setntenciado
              };
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
            penas:penas_sentenciado
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
                        <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
                      </a>
                      <a href="${dataDoc.url}" class="d-inline-flex d-md-none">
                        <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
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

function obtenerPersonasCarpetaRUE(carpeta){
  $.ajax({
    method:'POST',
    url:'/public/obtener_personas_carpeta',
    data:{carpeta},
    success:function(response){
      if( response.status == 100 ){
        $(response.response.personas).each(function(index, persona){
          const {id_calidad_juridica,id_persona,nombre,apellido_paterno,apellido_materno,razon_social, tipo_persona} = persona.info_principal;
          
          if( tipo_defensor.includes(id_calidad_juridica) )
            $('#defensor').append(`<option value="${id_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);

          else if( tipo_victima.includes(id_calidad_juridica) )
            $('#victima').append(`<option value="${id_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);

          else if( tipo_aseseor_juridico.includes(id_calidad_juridica) )
            $('#asesorJuridico').append(`<option value="${id_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);

          else if( tipo_ministerio_publico.includes( id_calidad_juridica ) )
            $('#ministerioPublico').append(`<option value="${id_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);

          else if( tipo_imputado.includes( id_calidad_juridica ) )
            $('#imputados').append(`<option value="${id_persona}" data-tipo="${tipo_persona}">${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</option>`);
            
        });
      }
    }
  });
}

function obtenerPartesCarpeta( carpeta ) {
  return new Promise( resolve => {
    $.ajax({
      method:'POST',
      url:'/public/obtener_personas_carpeta',
      data:{carpeta},
      success:function(response){
        resolve( response );
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

function showAdjuntos() {
  
  $('#div_documentos_adjuntos').html('');
  if(adjuntos_remision.length && adjuntos_remision.find( adjunto => adjunto.estatus == 1 )){
    $(adjuntos_remision).each(function(index, dataDoc){
      if ( dataDoc.estatus ) {
        $('#div_documentos_adjuntos').append(`
          <div style="padding-top: 13px; text-align: center;" class="col-md-4 mg-t-10">
            <a href="javascript:void(0)" ondblclick="abrirAdjunto('${index}')" class="d-none d-md-inline-flex">
              <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
            </a>
            <a href="${dataDoc.url}" class="d-inline-flex d-md-none">
              <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
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

function abrirDocumento( documento ) {
  
  const { url, nombre_archivo } = informacion_complementaria.documentos_remision_ue[documento];
  $('#nombreDocumento').html( `${nombre_archivo}` );
  $('#objectDocumento').html(`<object type="application/pdf" data="${url}" style="height: 80vh; width: 100%;"></object>`);
  $('#modalDatosTarea').modal('hide');
  abreModal('modalDocumento',400);

}

async function leeDocumento (input, tipo_archivo='', documento) {
  let b_subiendo = 0;
 
  const file =  $('#'+input.id).val(),
        ext = file.substring(file.lastIndexOf(".")),
        tipos_archivo = tipo_archivo.split(',');
        
  if( ext!='' ){
 
    if( tipo_archivo != '' && !tipos_archivo.includes( ext ) ){
 
      error( 'Tipo de archivo inválido', 'Solo puede adjutar archivos '+ tipo_archivo ,'modalDatosTarea');
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
                <i class="fa ${dataDoc.icon}" aria-hidden="true" style="font-size:3rem;position: relative;"></i>
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


function validaRemUniEjec( autorizacion ){
  const etapa = $('#etapas').find('.active').attr('etapa');
  $('.error').removeClass('error');
  // if( etapa == "inicial" ){
    
    if($('#fechaAudienciaSentencia').val() == '' || $('#fechaAudienciaSentencia').val() == null ){
      error('Datos Incompletos', 'No ha indicado la fecha de la audiencia en la cual se dicta sentencia', 'modalDatosTarea');
      $('span[aria-labelledby="select2-fechaAudienciaSentencia-container"]').addClass('error');
      return 0; 
    }
    if(!expRegFecha.test($('#fechaCausaEjecutoria').val())){
      error('Datos Incompletos', 'No ha indicado la fecha a partir de la cual causa ejecutoria', 'modalDatosTarea');
      $('#fechaCausaEjecutoria').addClass('error');
      return 0;
    }
    
    form=new FormData($("#formRemision")[0]); 
    form.append('carpeta', carpeta_remitir.id_carpeta_judicial);
    form.append('juez', $('#fechaAudienciaSentencia option:selected').attr('data-cvj'));
    form.append('fecha_audiencia', $('#fechaAudienciaSentencia option:selected').attr('data-fecha'));
    form.append('seccion', 'inicial');
    form.append('remision_in', remision_in);
    form.append('remision', carpeta_remitir.id_remision);
    form.append('unidad_carpeta', carpeta_remitir.id_unidad);
    form.append('dataDoc', JSON.stringify(documento_remision));
    form.append('autorizacion', autorizacion);

    return 100;
  // }
}

function guardarPersonas(seccion){
  
  let data;
  if( seccion == 'sentenciados' ){
    
    if( sentenciados.length && sentenciados.find( sentenciado => sentenciado.estatus == 1 ) != undefined){
      data = sentenciados;
    }else{
      error('Datos incompletos','No ha agregado a ningún sentenciado','modalDatosTarea');
      return 0;
    }
  }else if( seccion == 'defensores' ){
    
    if( defensores.length && defensores.find( defensor => defensor.estatus == 1 ) != undefined){
      data = defensores;
    }else{
      error('Datos incompletos','No ha agregado a ningún defensor','modalDatosTarea');
      return 0;
    }
  }else if( seccion == 'victimas' ){
    
    if( victimas.length && victimas.find( victima => victima.estatus == 1 ) != undefined){
      data = victimas;
    }else{
      error('Datos incompletos','No ha agregado a ningúna víctima','modalDatosTarea');
      return 0;
    }
  }else if( seccion == 'asesores_juridicos' ){
    
    if( asesores.length && asesores.find( asesor => asesor.estatus == 1 ) != undefined){
      data = asesores;
    }else{
      error('Datos incompletos','No ha agregado a ningún asesor jurídico','modalDatosTarea');
      return 0;
    }
  }else if( seccion == 'ministerio_publico' ){
    
    if( ministerios_publico.length && ministerios_publico.find(  ministerio_publico => ministerio_publico.estatus == 1 ) != undefined){
      data = ministerios_publico;
    }else{
      error('Datos incompletos','No ha agregado a ningún ministerio público','modalDatosTarea');
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
      error('Datos incompletos','No ha agregado ningún documento adjunto','modalDatosTarea');
      return 0;
    }
  }
  
  form=new FormData($("#formRemision")[0]);
  form.append('data',JSON.stringify(data));
  form.append('seccion',seccion);
  form.append('remision_in',carpeta_remitir.id_remision);
  
  $('#'+seccion+' .square-8 ').remove();
  $('#modalDatosTarea').modal('hide');
  $('#modal_loading').modal('show');

  if( !secciones_completadas.includes(seccion))
    registrarPersonasRemision(seccion);
  else
    actualizarPersonasRemision(seccion);
    
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
  $('#centroDetencion').val(sentenciado.centro_detencion).trigger('change');
  $("input[name=suspension_ejecucion][value='"+sentenciado.suspension_ejecucion+"']").prop("checked", true);
  $('#modalDatosTarea').modal('hide');
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
  
  const tipo_pena = pena_tipo == '' ?$('#tipoPena').val() : pena_tipo;
  $('#penaImpuesta').html('<option value="" disabled selected>Cargando...</option>');
  return new Promise(resolve => {
    $.ajax({
      method:'POST',
      url:'/public/obtener_penas',
      data:{tipo_pena},
      success:function(response){
        let pena_selec = '';
        if( response.status == 100 ){
          $('#penaImpuesta').html('<option value="" disabled>Seleccione una opción</option>');
          $(response.response).each(function(index, pena){
            
            if( String(pena_impuesta) != pena.codigo){
              $('#penaImpuesta').append(`<option value="${pena.codigo}">${pena.pena}</option>`);
              pena_selec = pena;
            }else{
              $('#penaImpuesta').append(`<option value="${pena.codigo}" selected>${pena.pena}</option>`);
            }
            $('#penaImpuesta').trigger('change');
          });
          resolve(pena_selec);
        }
      }
    });
  });
}

function penaImpuesta(){
  const pena_impuesta = $('#penaImpuesta').val();
  $('#divPeriodo').addClass('d-none').find('input').val('');
  $('#centroDetencionPena').val('').trigger('change');
  $('#divCentroDetencion').addClass('d-none');
  $('#sectionAbonoPrision').addClass('d-none');
  $('#sectionSustitutivosPena').addClass('d-none');
  $('#divDecomisos').addClass('d-none').find('.decomiso').prop('checked', false);
  $('#detallePena').html('<option value="" selected disabled>Seleccione una opción</option>');
  if( penas_detalle_pena.includes(parseInt(pena_impuesta)) ){
    $.ajax({
      method:'POST',
      url:'/public/obtener_detalle_pena',
      data:{pena_impuesta},
      success:function(response){
        if( response.message.length ){
          $(response.message).each(function(index,detalle){
            $('#detallePena').append(`<option value="${detalle.id_pena_opcion}">${detalle.descripcion}</option>`);
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

function agregarPena(){
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

    if( $('#periodoAnios').val() == '' || $('#periodoAnios').val() == null ){
      error('Datos Incompletos', 'No ha indicado los años', 'modalPenas');
      $('span[aria-labelledby="select2-periodoAnios-container"]').addClass('error');
      return 0;
    }

    if( $('#periodoMeses').val() == '' || $('#periodoMeses').val() == null ){
      error('Datos Incompletos', 'No ha indicado los meses', 'modalPenas');
      $('span[aria-labelledby="select2-periodoMeses-container"]').addClass('error');
      return 0;
    }

    if( $('#periododias').val() == '' || $('#periododias').val() == null ){
      error('Datos Incompletos', 'No ha indicado los días', 'modalPenas');
      $('span[aria-labelledby="select2-periododias-container"]').addClass('error');
      return 0;
    }
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
    sustitutivo_pena:sustitutivos.length==0?'no':'si',
    delitos,
    abonos,
    sustitutivos
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
  if(penas.length && penas.find( pena => pena.estatus == 1 ) != undefined){
    $(penas).each(function(index, pena){
      const{pena_impuesta_desc, delitos, detalles_adicionales_pena, sustitutivo_pena, id, estatus} = pena;
      if( estatus ){
        let listDelitos='';
        $(delitos).each(function(index, delito){
          if( delito.estatus )
            listDelitos=listDelitos.concat(`- ${delito.delito}<br>`);
        });
        $('#bodyPenas').append(`
          <tr>
            <td>
              <i class="fa fa-trash tx-danger" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Eliminar pena" onclick="eliminarPena(${index},'${id}')"></i>
              <i class="fa fa-pencil-square-o mg-l-10" aria-hidden="true" data-toggle="tooltip" data-placement="top" title data-original-title="Editar pena" onclick="editarPena(${index},'${id}')" style="color:#848F33"></i>
            </td>
            <td>${pena_impuesta_desc}</td>
            <td>${listDelitos}</td>
            <td>${detalles_adicionales_pena}</td>
            <td>${sustitutivo_pena}</td>
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
  await obtenerPenas(tipo_pena,pena_impuesta);
  $('#penaImpuesta').val(penaImpuesta).trigger('change');
  penaImpuesta();
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

  if( expVacio.test($('#abonoAnios').val()) ){
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
  $('#modalDatosTarea').modal('hide');
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
    error('Datos Incompletos', 'No ha agregado la copia certificada de la sentencia', 'modalDatosTarea');
    $('#copia_certificada_sentencia').parent().addClass('error');
    return false; 
  }

  if ( !informacion_complementaria.documentos_remision_ue.copia_certificada_auto ) {
    error('Datos Incompletos', 'No ha agregado la copia certificada de auto donde se reconoce la ejecución de la setencia aludida', 'modalDatosTarea');
    $('#copia_certificada_auto').parent().addClass('error');
    return false; 
  }

  if ( !informacion_complementaria.documentos_remision_ue.acta_minima ) {
    error('Datos Incompletos', 'No ha agregado el acta mínima de la audiencia que contenga la lectura y explicación de sentencia', 'modalDatosTarea');
    $('#acta_minima').parent().addClass('error');
    return false; 
  }

  if ( expVacio.test( $('#numeroDVD').val() )) {
    error('Datos Incompletos', 'No ha indicado el número de DVDs de audiencias a remitir', 'modalDatosTarea');
    $('#numeroDVD').addClass('error');
    return false; 
  }

  if ( !audiencias_dvd.length && audiencias_dvd.find( audiencia => audiencia.estatus == 1 ) != undefined ) {
    error('Datos Incompletos', 'No ha indicado las fechas de las audiencias que se remiten en los DVD´s', 'modalDatosTarea');
    $('#span[aria-labelledby="select2-fechaAudienciaDVD-container"]').addClass('error');
    return false; 
  }

  if ( $('input[name="billete_remision"]:checked') == undefined ) {
    error('Datos Incompletos', 'No ha indicado si se remite algún billete de depósito', 'modalDatosTarea');
    $('#privadoLibertadDiv').addClass('error');
    return false; 
  }

  if ( $('input[name="objeto_asegurado"]:checked') == undefined ) {
    error('Datos Incompletos', 'No ha indicado si cuenta con información respecto a objetos asegurados', 'modalDatosTarea');
    $('#divObjeto').addClass('error');
    return false; 
  }

  return true
}

function nuevoSentenciado(){
  sentenciado_edit = '-',
  penas = [];
  abonos = [];
  sustitutivos = [];
  delitos = [];
  $('#imputados').val('').trigger('change');
  $('.sentenciado_libertad').prop('checked', false);
  sentenciadoLibertad();
  $('.suspension_ejecucion').prop('checked', false);
  $('#centroDetencion').val('').trigger('change');
  $('#modalDatosTarea').modal('hide');
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

  const sentenciado = {
    estatus:'1',
    sentenciado:$('#imputados').val(),
    sentenciado_desc:$('#imputados option:selected').text(),
    tipo:$('#imputados option:selected').attr('data-tipo'),
    sentenciado_libertad:$('input[name="sentenciado_libertad"]:checked').val(),
    centro_detencion:$('#centroDetencion').val()==null?'-':$('#centroDetencion').val(),
    suspension_ejecucion:$('input[name="suspension_ejecucion"]:checked').val(),
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
  abreModal('modalDatosTarea',300);
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
          abreModal('modalDatosTarea',1000);
          remisionUnidadEjecucion(seccion);
          etapas();
        }else{
          error('Error', response.message , 'modalDatosTarea');
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
          abreModal('modalDatosTarea',1000);
          remisionUnidadEjecucion(seccion);
          etapas();
        }else{
          error('Error', response.message , 'modalDatosTarea');
        }
        setTimeout(() => {$('#modal_loading').modal('hide')},600);
      }
    });
  }
}

async function remisionUnidadEjecucion(seccion_actual=''){
  
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

  const {delitos, id_carpeta_judicial, folio_carpeta, carpeta_investigacion, imputados} = carpeta_remitir;

  $('#btnSiguiente').attr('disabled',true);
  $('#delitoPena').html('<option value="" disabled selected>Seleccione una opción</option>');

  $(delitos).each( function( index, delito ){ $('#delitoPena').append(`<option value="${delito.id_delito}">${delito.delito}</option>`); });

  $('#imputados').html('<option value="" disabled selected>Seleccione una opción</option>');

  $(imputados).each( function( index, imputado ){
    const { nombre, razon_social, tipo,id_persona } = imputado;
    $('#imputados').append( `<option value="${id_persona}" data-tipo="${tipo}">${nombre==null?'':nombre}${razon_social==null?'':razon_social}</option>` );
  });

  const remisionesCarpeta = await consultaRemisiones(id_carpeta_judicial);
  
  let remision_ue = [];

  if( remisionesCarpeta.status == 100 ) 
    remision_ue = remisionesCarpeta.response.filter( remision => remision.tipo_remision == 'unidad_ejecucion');
  
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
      
      documento_remision.push({ id_documento: doc_rem[0].id_documento, estatus: 1 });
      documento = await obtenerDocumentosRemision( id_remision, doc_rem[0].id_documento ); 
    
      if( documento.status == 100 )
        documento_remision_ejec = documento.response;
      
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
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Fecha de la audiencia en la cual se dicta sentencia:<span class="tx-danger">*</span></label>
                  <select class="form-control select2" id="fechaAudienciaSentencia" name="fecha_audiencia_sentencia" autocomplete="off" onchange="indicaJuez()">
                    <option value="">Seleccione una Opción</option>
                    ${fechasAudiencias}
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label mg-b-1208-29">Juez que dictó sentencia:<br>&nbsp;</label>
                  <input class="form-control" type="text" name="juez_dicto_sentencia" id="juezDictoSent" value="${juez_dicto_sentencia}" placeholder="" autocomplete="off" style="background: #fff;" readonly>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label mg-b-1208-29">Fecha a partir de la cual causa ejecutoria:<span class="tx-danger">*</span><br>&nbsp;</label>
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
                  <input type="file" id="archivoPDF2" class="input-file" name="documento_remision" accept="application/pdf" onchange="leeDocumento(this, '.pdf', 'unidad_ejecucion')">
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
                          <input type="file" id="copia_certificada_sentencia" class="input-file" value="" name="copia_certificada_sentencia" onchange="leeDocumento(this, '.pdf', 'copia_certificada_sentencia')" accept="application/pdf">
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
                          <input type="file" id="copia_certificada_auto" class="input-file" value="" name="copia_certificada_auto" onchange="leeDocumento(this, '.pdf', 'copia_certificada_auto')" accept="application/pdf">
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
                          <input type="file" id="acta_minima" class="input-file" value="" name="acta_minima" onchange="leeDocumento(this, '.pdf', 'acta_minima')" accept="application/pdf">
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
  // $('#btnSiguiente').attr('onclick', 'remisionEjecAutorizacion()');
  
  
  $('#fechaCausaEjecutoria').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    format: 'yyyy/mm/dd',
    changeYear: true,
    yearRange: "c-100:c+0"
  });

  if( secciones_completadas.length ){

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

function consultaRemisiones(carpeta_judicial){
  return new Promise(resolve => {
    $.ajax({
      method:'POST',
      url:'/public/consultar_remisiones_carpeta',
      data:{carpeta_judicial, imputados_activos: 'si'},
      success:function(response){
        resolve(response);
      }
    });
  }); 
}

function eliminarDocumento(doc, index=''){

    $('#div_'+doc).html('');
    $('#'+doc).parent().removeClass('d-none');
    documentos_remision_ue[doc] = '';
  
}

async function verRemisionCorreccionTE(){
  let imputadosRemitidos='',
    fechasAudiencias = '';

  const {folio_carpeta, id_carpeta_judicial, id_personas_remitidas, carpeta_judicial, TE_id_audiencia, imputado_privado_libertad, lugar_internamiento} = tareaSeleccionada;
    
  const personasCarpeta = await obtenerPartesCarpeta( id_carpeta_judicial );
    arrPersonasRemitidas = id_personas_remitidas.split(',');

  const documentos_remision = await obtener_documentos_remision( tareaSeleccionada.id_tabla_asociada );

  let formularioRemision = '';
  
  let documento = '';
  if( documentos_remision.status == 100 ) 
    data_documento = await obtener_documentos_remision( tareaSeleccionada.id_tabla_asociada, documentos_remision.response[0].id_documento );

  if( data_documento.status == 100 ) {
    documento_remision.push({id_documento:documentos_remision.response[0].id_documento, estatus: 1});
    documento = data_documento.response;
  }
   
  if( personasCarpeta.status == 100 )
    $( personasCarpeta.response.personas ).each(function( i, persona){
      const {nombre, apellido_paterno, apellido_materno, razon_social, tipo, id_persona, id_calidad_juridica} = persona.info_principal;
      if( id_calidad_juridica == 46 ) {
        
        let checked = '';
        if( arrPersonasRemitidas.includes(String(id_persona)) )
          checked = 'checked';

        imputadosRemitidos += ` 
          <div class="col-md-4">
            <label class="ckbox">
              <input type="checkbox" value="${id_persona}" data-tipo="${tipo}" name="imputados_sel" ${checked}><span>${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</span>
            </label>
          </div>
        `;
      }
        
    });

  fechasAudiencias = await obtenerFechasAudSent( id_carpeta_judicial );

  $("#formularioRemision").html('<div class="d-flex ht-300 pos-relative align-items-center"><div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div><div class="sk-cube2 sk-cube"></div><div class="sk-cube4 sk-cube"></div><div class="sk-cube3 sk-cube"></div></div></div><!-- d-flex -->');
  formularioRemision  = `
    <div style="border: 1px solid #eee; padding: 0.5em; background-color: #f8f9fa;">
      <form action="/" onsubmit="return false;" enctype="multipart/form-data" id="formRemision">
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
              <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${carpeta_judicial}" placeholder="N/E" autocomplete="off" disabled="">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group mg-b-10-force">
              <label class="form-control-label"  style="margin-bottom:29px">Juez que determino la vinculacion:</label>
              <input class="form-control" type="text" name="juez_vinculacion" id="juezVinculacion" value="" placeholder="N/E" autocomplete="off" disabled="">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label class="form-control-label">Fecha de la audiencia en la cual se determina la vinculación a Juicio Oral:</label>
              <select class="form-control" id="fechaAudienciaTE" name="fecha_audiencia_te" autocomplete="off" onchange="indicaJuezAudiencia()">
                <option selected value="">Seleccione una Opción</option>
                ${fechasAudiencias}
              </select>
            </div>
          </div>
        </div>
        <div class="row mg-b-15 pd-10">
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
              <select class="form-control select2" id="reclusorioInternamiento" name="lugar_internamiento" autocomplete="off" disabled>
                <option selected value="">Seleccione una Opción</option>
                <option value="00020008">Centro Femenil de Reinserción Social (Santa Martha)</option>
                <option value="00020004">Centro Varonil de Rehabilitación Psicosocial (CEVAREPSI)</option>
                <option value="00020001">Reclusorio Preventivo Varonil Norte</option>
                <option value="00020002">Reclusorio Preventivo Varonil Oriente</option>
                <option value="00020003">Reclusorio Preventivo Varonil Sur</option>
              </select>
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
            <div class="row mg-t-20">
              ${imputadosRemitidos}
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
            <input type="file" id="archivoPDF2" class="input-file" name="documento_adjunto" accept="application/pdf" onchange="leeDocumento_v2(this, '.pdf', 'tribunal_enjuiciamiento')">
              <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
            </div>
          </div>
          <div id="divDocumento" style="width:100%" class="col-12">
            <object data="${documento}"  id="documentoPDF" width="100%" height="350px" class=" mg-t-25"></object>
            <input type="hidden" id="bDoc" name="bDoc">
          </div>
        </div>
      </form>
    </div>
  `;
  $("#labelTipoRemision").html(" ENVIO DE CARPETA JUDICIAL A TRIBUNAL DE ENJUICIAMIENTO");

  
  $("#divTarea").html(formularioRemision);
  $('#reclusorioInternamiento').select2({minimumResultsForSearch: ''});
  $('#fechaAudienciaTE').select2( { minimumResultsForSearch: Infinity } );
  $('#modalDatosTarea').modal('show');
  $('#fechaAudienciaTE').val(TE_id_audiencia).trigger('change');
  $('input[name=privado_libertad][value='+imputado_privado_libertad+']').prop('checked',true).trigger('click');
  $('#reclusorioInternamiento').val(String(lugar_internamiento).padStart(8,0)).trigger('change');
}

function indicaJuezAudiencia() {
  $('#juezVinculacion').val( $('#fechaAudienciaTE option:selected').attr('data-juez') );
}

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
  // tamanio_archivo=$('#archivoPDF2')[0].files[0].size;

  form.append('carpeta', tareaSeleccionada.id_carpeta_judicial);
  // form.append('tamanio_archivo', tamanio_archivo);
  form.append('personas_remitidas', strImputados);
  form.append('unidad_carpeta',tareaSeleccionada.id_unidad);
  form.append('remision', tareaSeleccionada.id_remision);
  form.append('dataDoc', JSON.stringify(documento_remision));
  form.append('id_audiencia_TE', $('#fechaAudienciaTE').val());
  form.append('fecha_audiencia_TE', $('#fechaAudienciaTE option:selected').attr('data-fecha'));
  form.append('juez_audiencia_TE', $('#fechaAudienciaTE option:selected').attr('data-cvj'));

  return 100;
}

async function verRemisionCorreccionLN () {
 
  let imputadosRemitidos='',
    fechasAudiencias = '';

  const { carpeta_judicial, id_carpeta_judicial, id_personas_remitidas, LN_id_audiencia, LN_vinculacion_proceso} = tareaSeleccionada;
 
  const personasCarpeta = await obtenerPartesCarpeta( id_carpeta_judicial );
    arrPersonasRemitidas = id_personas_remitidas.split(',');

  if( personasCarpeta.status == 100 ) {
    $( personasCarpeta.response.personas ).each(function( i, persona){
      const {nombre, apellido_paterno, apellido_materno, razon_social, tipo, id_persona, id_calidad_juridica} = persona.info_principal;
      if( id_calidad_juridica == 46 ) {
        
        let checked = '';
        if( arrPersonasRemitidas.includes(String(id_persona)) )
          checked = 'checked';

        imputadosRemitidos += ` 
          <div class="col-md-4">
            <label class="ckbox">
              <input type="checkbox" value="${id_persona}" data-tipo="${tipo}" name="imputados_sel" ${checked}><span>${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</span>
            </label>
          </div>
        `;
      }      
    });
  }

  // fechasAudiencias = await obtenerFechasAudSent( id_carpeta_judicial, LN_id_audiencia );

  const documentos_remision = await obtener_documentos_remision( tareaSeleccionada.id_tabla_asociada );
  
  let documento = '';
  if( documentos_remision.status == 100 ) 
    data_documento = await obtener_documentos_remision( tareaSeleccionada.id_tabla_asociada, documentos_remision.response[0].id_documento );

  if( data_documento.status == 100 ) {
    documento_remision.push({id_documento:documentos_remision.response[0].id_documento, estatus: 1});
    documento = data_documento.response;
  }

  $("#formularioRemision").html('<div class="d-flex ht-300 pos-relative align-items-center"><div class="sk-folding-cube"><div class="sk-cube1 sk-cube"></div><div class="sk-cube2 sk-cube"></div><div class="sk-cube4 sk-cube"></div><div class="sk-cube3 sk-cube"></div></div></div><!-- d-flex -->');
  formularioRemision  = `
    <form action="/" onsubmit="return false;" enctype="multipart/form-data" id="formRemision">
      <div class="row mg-b-15  pd-10">
        <div class="col-12">
          <div  class="slim-pagetitle mg-t-20  mg-b-20">
            <h6 class="mg-b-0">Datos Generales:</h6>  
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label" >Carpeta Judicial a Remitir:</label>
            <input class="form-control" type="text" name="carpeta_a_remitir" id="carpetaARemitir" value="${carpeta_judicial}" placeholder="N/E" autocomplete="off" disabled="">
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group">
            <label class="form-control-label">Audiencia en que se impuso la prisión preventiva:</label>
            <select class="form-control" id="fechaAudienciaTE" name="LN_id_audiencia" autocomplete="off" onchange="indicaJuezAudiencia()">
              <option selected value="">Seleccione una Opción</option>
              ${fechasAudiencias}
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="form-group mg-b-10-force">
            <label class="form-control-label" >Juez que impuso la prisión preventiva:</label>
            <input class="form-control" type="text" name="juez_vinculacion" id="juezVinculacion" value="" placeholder="N/E" autocomplete="off" disabled="">
          </div>
        </div>
      </div>
      <div class="row mg-b-15  pd-10">
        <div class="col-12">
          <div class="form-group mg-b-10-force vinculacion_proceso">
            <label class="form-control-label">Se vincula a proceso:</label>
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
            <h6 class="mg-b-0">Seleccione los imputados que serán remitidos en la incompetencia:  <span class="tx-danger">*</span></h6>  
          </div>
          <div class="row mg-t-20">
            ${imputadosRemitidos}
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
            <input type="file" id="archivoPDF2" class="input-file" name="documento_adjunto" accept="application/pdf" onchange="leeDocumento_v2(this, '.pdf', 'ley_nacional')">
            <h5 class="px-3 py-3">Arrastre hasta aquí su documento pdf o de clic para adjuntarlo</h5>
          </div>
        </div>
        <div id="divDocumento" style="width:100%" class="col-12">
          <object data="${documento}"  id="documentoPDF" width="100%" height="350px" class=" mg-t-25"></object>
          <input type="hidden" id="bDoc" name="bDoc">
        </div>
      </div>
    </form>
  `;
  $("#labelTipoRemision").html("REMISIÓN DE CARPETA POR PRISIÓN PREVENTIVA");

  
  $("#divTarea").html(formularioRemision);
  $('#reclusorioInternamiento').select2({minimumResultsForSearch: ''});
  $('#fechaAudienciaTE').select2( { minimumResultsForSearch: Infinity } ).trigger('change');
  $('#modalDatosTarea').modal('show');
  setTimeout( () => { $('.toggle').toggles({ on: LN_vinculacion_proceso == 'no' ? false : true, height: 26 }); },100);

}

function validaLN() {
  
  if( $('#fechaAudienciaTE').val() == null || $('#fechaAudienciaTE').val() == '') {
    $('#select2-fechaAudiencia-container').addClass('error');
    $('#fechaAudienciaTE').focus();
    return false;    
  }

  if( documento_remision.length < 1 ) {
    error('Datos Incompletos', 'No ha seleccionado un documentos para la remisión', 'modalDatosTarea');
    return false;
  }

  let strImputados = ''; 
  if( !($('input[name=imputados_sel]:checked').length)){
    error('Datos Incompletos', 'No ha seleccionado a ningún imputado', 'modalRemision');
    return false;
  }else{

    $('input[name=imputados_sel]:checked').each(function( i ) {
      if( i == 0 ) strImputados += $(this).val();
      else strImputados += ','+$(this).val();
    });
  }
  
  form = new FormData($("#formRemision")[0]);
  form.append('carpeta', tareaSeleccionada.id_carpeta_judicial);
  form.append('personas_remitidas', strImputados);
  form.append('unidad_carpeta',tareaSeleccionada.id_unidad);
  form.append('remision', tareaSeleccionada.id_remision);
  form.append('dataDoc', JSON.stringify(documento_remision));
  form.append('LN_fecha_audiencia', $('#fechaAudienciaTE option:selected').attr('data-fecha'));
  form.append('LN_id_juez_audiencia', $('#fechaAudienciaTE option:selected').attr('data-cvj'));
  form.append('LN_nom_juez_audiencia', $('#fechaAudienciaTE option:selected').attr('data-juez'));

  return 100;
}