async function verRemisionREJEC() {

  moment.locale('es-mx');
  const { id_tabla_asociada, tabla_asociada, clave_bandeja} = tareaSeleccionada
  const datos_remision = await obtenerInfoRemision( id_tabla_asociada );
  const configuracion = configuracion_usuario.configuracion( tabla_asociada, clave_bandeja );

  if( datos_remision.status != 100 )
    alert( datos_remision.message );

  tareaSeleccionada = Object.assign( tareaSeleccionada, datos_remision['response'][0] );

  let datos_remision_tabla = '<table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td colspan="2" class="tx-center" style="color: #FFF; background-color:#848F33">Datos generales de la remisión</td></tr>';

  if( tareaSeleccionada.tipo_remision == 'ley_nacional' )
    var campos_datos = {
      folio_carpeta_rem : "Folio de la carpera:",
      carpeta_judicial : "Carpeta judicial remitida:",
      LN_fecha_audiencia : "Audiencia en que se impuso la prisión preventiva:",
      LN_nom_juez_audiencia : "Juez que impuso la prisión preventiva:",
      LN_vinculacion_proceso : "Se vincula a proceso:",
    };
  else if( tareaSeleccionada.tipo_remision == 'unidad_ejecucion' )
    var campos_datos = {
      folio_carpeta_rem : "Carpeta generada:",
      carpeta_judicial : "Carpeta judicial remitida:",
      EJEC_fecha_audiencia : "Fecha de la audiencia en la cual se dicta sentencia:",
      EJEC_nom_juez_sentencia : "Juez que dictó sentencia:",
      EJEC_fecha_ejecutoria : "Fecha a partir de la cual causa ejecutoria:"
    };
  
  $.each(campos_datos, function(campo, titulo){
    if( !['LN_fecha_audiencia', 'EJEC_fecha_audiencia', 'EJEC_fecha_ejecutoria'].includes(campo) )      
      datos_remision_tabla += `<tr><td>${titulo}</td><td>${tareaSeleccionada[campo] == null ? '' : tareaSeleccionada[campo]}</td></tr>`;
    else
      datos_remision_tabla += `<tr><td>${titulo}</td><td>${tareaSeleccionada[campo] == null ? '' : moment(tareaSeleccionada[campo].split(' ')[0]).format('LL')}</td></tr>`;
  });

  datos_remision_tabla += '</tbody></table>';

  let datos_personas = '';
  
  if( tareaSeleccionada.tipo_remision == 'ley_nacional' ) {
    $( tareaSeleccionada.personas ).each( function( i, persona ){

      const { razon_social, nombre, apellido_paterno, apellido_materno} = persona.info_principal;

      const campos_adicionales_persona = {
        calidad_juridica : "Calidad juridica",
        ocuapcion : "Ocupación",
        rfc_empresa : "RFC",
        nivel_escolaridad : "Nivel de escolaridad",
        curp : "CURP",
        otra_escolaridad : "Otra escolaridad",
        cedula_profesional : "Cédula Profesional",
        nombre_religion : "Religión",
        genero : "Género",
        otra_religion : "Otra religión",
        fecha_nacimiento : "Fecha de nacimiento",
        grupo_etnico : "Grupo étnico",
        estado_civil : "Estado civil",
        lengua : "Lengua",
        capacidad_diferente : "Capacidad diferente",
        sabe_leer_escribir : "Sabe leer y escribir",
        poblacion_callejera : "Población callejera",
        poblcacion : "Población",
        otra_poblacion : "Otra población",
        nombre_poblacion : "Nombre de la población",
        entiende_idioma_espanol : "Entiende el idioma español",
        requiere_interprete : "Requiere intérprete",
        tipo_interprete : "Tipo de intérprete",
        requiere_traductor : "Requiere traductor",
        idioma_traductor : "Idioma del traductor",
        otro_idioma_traductor : "Otro idioma del traductor",
      };

      let card_persona = `<div id="accordion${i}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
          <div class="card"><div class="card-header" role="tab" id="headingOne"><a data-toggle="collapse" data-parent="#accordion${i}" href="#collapseOne${i}" aria-expanded="true" aria-controls="collapseOne${i}" class="tx-gray-800 transition collapsed">${razon_social == null ? '' : razon_social}${nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</a></div><div id="collapseOne${i}" class="collapse" role="tabpanel" aria-labelledby="headingOne${i}"><div class="card-body" >`;
          
      card_persona += '<table class="datatable tableDatosSujeto" style="overflow-x: none; display: table"><tbody class="table-datos-sujeto">';
      
      let j = 0;
      $.each( campos_adicionales_persona , function( campo, titulo ){
        
        if( j%2 == 0 ) card_persona += '<tr>';

        if( !['fecha_nacimiento'].includes(campo) )      
          card_persona += `<td>${titulo}</td><td style="text-transform: capitalize">${persona.info_principal[campo] == null ? '' : persona.info_principal[campo]}</td>`;
        else
          card_persona += `<td>${titulo}</td><td>${persona.info_principal[campo] == null ? '' : formatoFecha(persona.info_principal[campo].split(' ')[0])}</td>`;

        if( j%2 != 0 ) card_persona += '</tr>';

        j++

      });

      card_persona += '</tbody></table>';
      card_persona += '<br><table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table"><thead><tr><th class="tx-center">Teléfonos</th><th class="tx-center">Correos</th><th class="tx-center">Alias</th></tr></thead><tbody><tr><td>';

      const telefonos = persona.contacto.filter( contacto => contacto.tipo_contacto != 'correo electronico' );

      if( telefonos.length > 0 )
        $( telefonos ).each(function( ic, contaco) { card_persona += `${tipo_contacto}: ${contacto} ${extension == null ? '' : 'ext:' +extension}<br>`; });
      else
        card_persona += '<span class="tx-italic">Sin teléfonos registrados</span>';

      card_persona += '</td><td>';

      const correos = persona.contacto.filter( contacto => contacto.tipo_contacto == 'correo electronico' );

      if( correos.length > 0 )
        $( correos ).each(function( ic, contaco) { card_persona += contaco.contacto+'<br>'; });
      else
        card_persona += '<span class="tx-italic">Sin correos registrados</span>';

      card_persona += '</td><td>';

      if( persona.alias.length > 0 )
        $( persona.alias ).each(function( ia, alias ){ card_persona += alias.alias+'<br>'; });
      else
        card_persona += '<span class="tx-italic">Sin alias registrados</span>';
      
      card_persona += '</td></tr></tbody></table>';
      card_persona += '</div></div></div></div>';
      datos_personas += card_persona;
    });
  }else if( ['unidad_ejecucion', 'incompetencia'].includes(tareaSeleccionada.tipo_remision) ) {

    const datos_personas_ue = await obtenerPersonasUE(tareaSeleccionada.id_remision);
    if( datos_personas_ue.status == 100 ) 
      tareaSeleccionada = Object.assign( tareaSeleccionada, datos_personas_ue['response'] );

    datos_remision_tabla += '<div class="row"><div class="col-md-6"><br><table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody><tr><td class="tx-center" colspan="2" style="color: #FFF; background-color:#848F33">Billetes de depósito</td></tr>';

    if( tareaSeleccionada.informacion_complementaria[0].billetes.length > 0 ) {

      datos_remision_tabla += '<tr class="tx-center"><th>Número de billete</th><th>Monto</th></tr>';
      
      $( tareaSeleccionada.informacion_complementaria[0].billetes ).each( function( i, billete) {  
        datos_remision_tabla += `<tr class="tx-center"><td>${billete.numero_billete}</td><td>${toMoney(billete.monto)}</td></tr>`;
      });

    }else  {
      datos_remision_tabla += '<tr><td colspan="2" class="tx-center"><span class="tx-italic tx-center" style="color: #C5C5C5">Sin billetes registrados</span></td></tr>';
    }

    datos_remision_tabla += '</tbody></table></div><div class="col-md-6"><br><table class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000"><tbody><tr><td class="tx-center" colspan="2" style="color: #FFF; background-color:#848F33">Objetos asegurados</td><tr>';

    if( tareaSeleccionada.informacion_complementaria[0].objetos.length > 0 ) {
      datos_remision_tabla += '<tr class="tx-center"><th>Descripción</th><th>Ubicación</th></tr>';

      $( tareaSeleccionada.informacion_complementaria[0].objetos ).each( function( i, objeto) {
        datos_remision_tabla += `<tr class="tx-center"><td>${objeto.objeto_descripcion}</td><td>${objeto.objeto_ubicacion}</td></tr>`;
      });
    } else {
      datos_remision_tabla += '<tr><td colspan="2" class="tx-center"><span class="tx-italic" style="color: #C5C5C5">Sin objetos registrados</span></td></tr>';
    }

    datos_remision_tabla += '</tbody></table></div></div>';

    $( tareaSeleccionada.sentenciados ).each( async function( i, sentenciado ) {

      const { nombre, apellido_paterno, apellido_materno, razon_social, calidad_juridica, en_libertad, id_unidad_centro_detencion } =  sentenciado;

      let card_persona = `<div id="accordion${i}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
          <div class="card"><div class="card-header" role="tab" id="headingOne"><a data-toggle="collapse" data-parent="#accordion${i}" href="#collapseOne${i}" aria-expanded="true" aria-controls="collapseOne${i}" class="tx-gray-800 transition collapsed">${razon_social == null ? '' : razon_social}${nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</a></div><div id="collapseOne${i}" class="collapse" role="tabpanel" aria-labelledby="headingOne${i}"><div class="card-body" >`;
        
      card_persona += '<table class="datatable tableDatosSujeto" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td class="tx-center" colspan="4" style="color: #FFF; background-color:#848F33">Datos generales del sentenciado</td><tr>';
      card_persona += `<tr><td colspan="2">Nombre</td><td colspan="2">${razon_social == null ? '' : razon_social}${nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</td><tr>`;
      
      let j = 0;
      
      if( id_unidad_centro_detencion != null )
        var centro_detencion = await obtenerReclusorios(id_unidad_centro_detencion) ;

      const campos_persona = [
        ["Calidad juridica:", calidad_juridica],
        ["Persona en libertad:", en_libertad],
        ["Centro de detención", id_unidad_centro_detencion == null ? '' : centro_detencion.message[0].nombre]
      ];

      // $.each( campos_persona , function( campo, titulo ){
        
      $( campos_persona ).each( function( i, campo){
        if( j%2 == 0 ) card_persona += '<tr>';

        if( !['fecha_nacimiento'].includes(campo) )      
          card_persona += `<td>${campo[0]}</td><td style="text-transform: capitalize">${campo[1] == null ? '' : campo[1]}</td>`;
        else
          card_persona += `<td>${titulo}</td><td>${sentenciado[campo] == null ? '' : formatoFecha(sentenciado[campo].split(' ')[0])}</td>`;

        if( j%2 != 0 ) card_persona += '</tr>';

        j++

      });

      card_persona += '</tbody></table>';
      card_persona += '</div></div></div></div>';
      datos_personas += card_persona;
    });

  }

  let documento_vista = '';
  const documentos_remision_solicitud = await obtenerDocumentosSolicitud( tareaSeleccionada.datos_cj.id_solicitud ); 
  
  if( documentos_remision_solicitud.status == 100 )
    documento_vista += `<div class="row"><div class="col-md-12"><object data="${documentos_remision_solicitud.response}" class="documento_remision" width="100%" height="455px"></object></div></div>`;
    
  $('#divTarea').append(`
    <form onsubmit="return false;" id="cargarDocumento" action="/" enctype="multipart/form-data" class="documento">
      <div id="validacionDatos">        
        <div class="form-group">
          <label class="form-control-label">Resolver por:</label>
          <select class="form-control" id="tipoResolucion" name="tipo_resolucion" autocomplete="off">
            ${configuracion.select_tipo_resolucion}
          </select>
        </div>
        <div class="card" style="min-height: 481px;">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#divSolicitud" data-toggle="tab">Datos Remisión</a>
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
                ${datos_remision_tabla}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDatosSujeto">
                ${datos_personas}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDocumentos">
                ${documento_vista}
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

  $('#steps').append('<p class="step espera d-inline-block d-md-flex mg-r-10" id="step_resolucion_remision"><span class="num-step">2</span><span class="text-step d-none d-md-block">Resolución de la remision</span></p>');
  $('#tipoResolucion').select2({minimumResultsForSearch: Infinity});
  $('#btnSiguiente').attr('onclick', 'resolucionRejec()');
  // $('#modalDatosTarea').modal('show');
}

function resolucionRejec() {
  
  const { clave_bandeja } = tareaSeleccionada;
  
  if( $('#tipoResolucion').val() == 'acuerdo' ) {

    if( resolucion_permiso.acuerdo ) {
      
      resolverPorAcuerdo();      
      $('#step_resolucion_remision').removeClass('espera').addClass('activo');
      $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
      $('#resolucion').removeClass('d-none');
      $('#validacionDatos').addClass('d-none');
      $('#atras').removeAttr('disabled').attr('onclick', 'regresarResolucionRejec()');
      $('#btnSiguiente').attr('onclick', 'validarREJEC()');

    } else if( clave_bandeja == "RP" ) {
      validarTareaPromocion();
    } else {
      validarTareaSolicitud();
    }

  } else {

    if( resolucion_permiso.audiencia ) {

      resolverPorAudiencia();
      $('#step_resolucion_remision').removeClass('espera').addClass('activo');
      $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
      $('#resolucion').removeClass('d-none');
      $('#validacionDatos').addClass('d-none');
      $('#atras').removeAttr('disabled').attr('onclick', 'regresarResolucionRejec()');
      $('#btnSiguiente').attr('onclick', 'validarREJEC()');
      
    } else if( clave_bandeja == "RP" ) {
      validarTareaPromocion();
    } else {
      validarTareaSolicitud();
    }
    
  } 

  
}

function regresarResolucionRejec() {
  $('#step-datos-solicitud').removeClass('resuelto').addClass('activo');
  $('#step_resolucion_remision').removeClass('activo').addClass('espera');
  $('#validacionDatos').removeClass('d-none');
  $('#resolucion').addClass('d-none');
  $('#btnSiguiente').attr('onclick', 'resolucionRejec()');
}

function validarREJEC() {
  resolucion = new FormData( $('#cargarDocumento')[0] );
  resolucion.append('solicitud', tareaSeleccionada.datos_cj.id_solicitud);
  if( $('#tipoResolucion').val() == 'acuerdo' ) {

    if( $('input[name=doc]:checked').val() == 'subir' ) 
      if( $('#archivoDoc').val() == '' ) 
        return error('Datos incompletos', 'No ha adjuntado ningún documento', 'modalDatosTarea');

    if( $('input[name=doc]:checked').val() == 'delegar' )
      if( $('#delegar').val() == null )
        return error('Datos Incompletos', 'No ha seleccionado el usuario al que se delegará la tarea', 'modalDatosTarea');

    if( $('#usuario_destino').val() == null )
      return error('Datos Incompletos', 'No ha seleccionado el usuario que firmará el documento', 'modalDatosTarea');


    if( $('input[name=doc]:checked').val() == 'subir' ){
      
      const file = $('#archivoDoc').val();
        extension = file.substring(file.lastIndexOf("."));
        tamanio_archivo=$('#archivoDoc')[0].files[0].size;
        nombre_archivo=$('#nombreDoc').val();
        resolucion.append('extension',extension);
        resolucion.append('nombre_archivo',nombre_archivo);
        resolucion.append('tamanio_archivo',tamanio_archivo);
      
    }else if( $('input[name=doc]:checked').val() == 'crear' ){
      extension = 'html';
      archivo = editor_html.html.get();
      nombre_archivo = $('#nombreHTML').val();
      resolucion.append('archivo_doc',archivo);
      resolucion.append('extension',extension);
      resolucion.append('nombre_archivo',nombre_archivo);
    }

  }else {

    if( ($('#id_tipo_audiencia').val() == '' && $('#id_tipo_audiencia_select').val() == '' )||( tareaSeleccionada.clave_bandeja == 'REJEC' && $('#id_tipo_audiencia_select').val() == '')) {
      error('Datos Incompletos', 'Falta el tipo de audiencia', 'modalDatosTarea');
      $('span[aria-labelledby="select2-id_tipo_audiencia_select-container"]').addClass('error');
      $("#id_tipo_audiencia").addClass('error');
      $('#tabDatosGenerales').click();
      return 0;
    }

    if( $('#id_juez_asignado').val() == '' && $('#jueces_ejecucion').val() == '' ) {
      error('Datos Incompletos', 'Falta el tipo de audiencia', 'modalDatosTarea');
      $('span[aria-labelledby="select2-jueces_ejecucion-container"]').addClass('error');
      $("#id_juez_asignado").addClass('error');
      $('#tabCalendar').click();
      return 0;
    }

    if( $('#select_inmueble_salas').val() == null ||  $('#select_inmueble_salas').val() == '' ){
      error('Datos Incompletos', 'No ha seleccionado una sala', 'modalDatosTarea');
      $('span[aria-labelledby="select2-select_inmueble_salas-container"]').addClass('error');
      $('#tabCalendar').addClass('error');
      return 0;
    }

    if( !expRegHora.test($('#tp_hora_inicio').val()) ){
      error('Datos Incompletos', 'No ha indicado la hora de inicio de la audiencia', 'modalDatosTarea');
      $('#tp_hora_inicio').addClass('error');
      $('#tabCalendar').click();
      return 0;
    }

    if( !expRegHora.test($('#tp_hora_final').val()) ){
      error('Datos Incompletos', 'No ha indicado la hora final de la audiencia o el formato es invalido (HH:mm)', 'modalDatosTarea');
      $('#tp_hora_final').addClass('error');
      $('#tabCalendar').click();
      return 0;
    }

    if( horario_valido !=1 ){
      error('Datos Incompletos', 'Debe seleccionar un horario válido o el formato es invalido (HH:mm)', 'modalDatosTarea');
      $('#tp_hora_inicio').addClass('error');
      $('#tp_hora_final').addClass('error');
      $('#tabCalendar').click();
      return 0;
    }

    if( $('#tp_hora_final').val() <= $('#tp_hora_inicio').val() ){
      error('Datos Incompletos', 'Debe leccionar un horario válido o el formato es invalido (HH:mm)', 'modalDatosTarea');
      $('#tp_hora_inicio').addClass('error');
      $('#tp_hora_final').addClass('error');
      $('#tabCalendar').click();
      return 0;
    }
  }

  confirmarREJEC();

}

function confirmarREJEC() {


  if( $('#tipoResolucion').val() == 'acuerdo' ) {

    if( ['subir', 'crear'].includes($('input[name=doc]:checked').val())  ) 
      $('#mensajeConfirmar').html('El acuerdo se enviará a firma al usuario' + $('#usuario_destino option:selected').text());
    else if ( $('input[name=doc]:checked').val() == 'delegar' )
      $('#mensajeConfirmar').html('La tarea se delegará al usuario' + $('#delegar option:selected').text());
  
  }else {
    const fecha = $('#fecha_audiencia_hidden').val(),
      inicio = $('#tp_hora_inicio').val(),
      fin = $('#tp_hora_final').val();
    $('#mensajeConfirmar').html(`Se agendará la audiencia para el dia ${fecha} de ${inicio} a ${fin} hrs.`);
  }
  
  $('#regresar').attr('onclick', "abreModal('modalDatosTarea', 400)");
  $('#btnResolver').attr('onclick', 'resolverREJEC()');
  $('#modalDatosTarea').modal('hide');
  $('#modalConfirmacion').modal('show');

}

function resolverREJEC() {
  moment.locale('es-mx');
  $('#modalConfirmacion').modal('hide');
  $('#modal_loading').modal('show');
  if( $('#tipoResolucion').val() == "audiencia"){

    resolucion.append('id_inmueble',$('#select_inmueble').val());
    resolucion.append('id_sala',$('#select_inmueble_salas').val());
    resolucion.append('id_juez',$('#id_juez_asignado').val());
    resolucion.append('id_juez_ejecucion', $('#jueces_ejecucion').val());
    resolucion.append('cve_juez',$('#clave_juez_asignado').val());
    resolucion.append('cve_juez_ejecucion', $('#jueces_ejecucion option:selected').attr('cve-juez'));
    resolucion.append('fecha_audiencia',$('#fecha_audiencia_hidden').val());
    resolucion.append('hora_inicio_audiencia',$('#tp_hora_inicio').val());
    resolucion.append('hora_fin_audiencia',$('#tp_hora_final').val());
    resolucion.append('bandera_juez_excusa',$('#bandera_juez_excusa').val());
    resolucion.append('bandera_juez_tramite',$('#bandera_juez_tramite').val());
    resolucion.append('comentarios_excusa',$('#comentarios_excusa').val());
    resolucion.append('recursos_arr',JSON.stringify(recursos_adi));
    resolucion.append('id_tipo_audiencia',$('#id_tipo_audiencia').val());
    resolucion.append('id_tipo_audiencia_select', $('#id_tipo_audiencia_select').val());
  }

  resolucion.append('comentarios', $('#comentarios').val());

  $.ajax({
    method:'POST',
    url:'/public/resolver_tarea_solicitud',
    data:resolucion,
    contentType: false,
    processData: false,
    asynct:false,
    cache: false,
    json: true,
    success:async function(response){
      console.log(response);
      if( response[0].status == 100 ) {
        
        if( $('#tipoResolucion').val() == 'acuerdo' ) {

          const nombre_usuario = $('#usuario_destino option:selected').text(),
            acuerdo = response[0].response.id_acuerdo;

          if($('#accion').val() == 'revision'){
            await avanzar(acuerdo, nombre_usuario, 'revision');
          } else {
            await avanzar(acuerdo, nombre_usuario, 'firma');
          }

        }else{

          const exp = response[1].data_audiencia.fecha_audiencia.split('-');
          const fecha = `${exp[2]}-${exp[1]}-${exp[0]}`;
          const message=`${response[0].message} <br>Dia: <span>${fecha}</span> <br> Hora de inicio: <span>${response[1].data_audiencia.hora_inicio_audiencia}</span>` ;
          $('#successMessage').html(`${message}`);
          cierraLoading(200);
          $('#modalSuccess').modal('show');
        }
        buscar(1);
        countBandejas();
      } else {
        error("Error",response[0].message);
      }
    }
  });
}

function obtenerPersonasUE(remision){
  return new Promise( resolve => {
    $.ajax({
      method:'GET',
      url:'/public/obtener_personas_remision',
      data:{remision},
      success: async function(response){
        resolve(response);
      }
    });
  });
}
    