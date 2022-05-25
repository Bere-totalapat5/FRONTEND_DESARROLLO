
let juez_ejec = '',
  tables = [],
  tareaSeleccionada;

const 
  penas_detalle_pena = [7,6,12,13,30],
  periodos = [1,2,3,7],
  prision = [1],
  decomisos = [10],
  abonoPrision = [1,47,2,7,3],
  sustitutivoPena = [1,6],
  arr_sustitutivos = [1,2],
  tipo_defensor = [4,29,43,52],
  tipo_aseseor_juridico = [47],
  tipo_victima = [2,13,60,61,62],
  tipo_ministerio_publico = [10001];

  var configuracion_usuarios,
    configuracion,
    resolucion_permiso;
    

$("#archivoDoc").on('input',function () {
  leeDocumento(this);
});

$('#seleccionaTodas').click(function () {

  if( $(this).is(':checked') )
    $('.seleccion_tarea').prop('checked',true);
  else
    $('.seleccion_tarea').prop('checked',false);

});

$('#aAtendidas').click( function() {
  $('#modalAlertaConfirmacion').modal('show');
  $('#mensajeAlertaConfirmacion').html('¿Está seguro de marcar como atendidas las tareas seleccionadas?')
});

function enviaTareasAtendidas() {

  $('#modalAlertaConfirmacion').modal('hide');
  $('#modal_loading').modal('show');

  let tareas = '';

  $('.seleccion_tarea:checked').each( function( i, tarea ) {
    if( i != 0 )
      tareas += ','+$(tarea).val();
    else 
      tareas += $(tarea).val();
  })

  $.ajax({
    method: 'PATCH',
    url: '/public/marcar_tareas' ,
    data: {tareas},
    success: function( response ) {
       if( response.status == 100 ) {
        $('#successMessage').html(response.message);
        $('#modalSuccess').modal('show');
        buscar(1);
       } else {
         $('#messageError').html(response.message);
         $('#modalError').modal('show');
       }

       setTimeout( () => {
         $('#modal_loading').modal('hide')
       }, 400);
    }
  });

}

function buscar( pagina ){
  moment.locale('es-mx'); 
  $('#modal_loading').modal('show');
  $.ajax({
    method:'POST',
    url:'/public/obtener_bandeja',
    data:{
      modo:"lista",
      tipo:"tareas",
      pagina,
      uga:$('#unidad').val(),
      usuario:$('#usuario').val(),
      folio:$('#folio').val(),
      estatus:$('#estatus').val(),
      desde:$('#desde').val(),
      hasta:$('#hasta').val(),
      carpeta_inv:$('#carpetaInv').val(),
      nombre_persona:$('#nombrePersona').val(),
      ap_paterno_persona:$('#apPaternoPersona').val(),
      ap_materno_persona:$('#apMaternoPersona').val(),
      clave_bandeja: $('#tipo_tarea').val(),
      folio_carpeta: $('#carpetaJudicial').val(),
    },
    success:function( response ){
      $('#bodyTareas').html('');
      if(response.status==100){
        arrTareas=response.response;
        $(response.response).each(function(index, tarea){
          const {id_bandeja, estatus_bandeja, creacion_bandeja, mensaje_bandeja, comentarios_bandeja, folio_solicitud, tipo_solicitud_, fecha_recepcion_solicitud, clave_bandeja, carpeta_investigacion, cve_juez_promujer, nombre_juez_promujer, nombre_usuario_origen, partes_procesales, delitos, carpeta_judicial, descripcion_bandeja, id_usuario_origen, usuario_origen, tipo_documento_acuerdo, fecha_creacion_acuerdo, id_usuario_destino, nombre_usuario_destino, usuario_destino, folio_carpeta_rem, creacion, fecha_creacion} = tarea;
          
          let lPartes='',
              lDelitos='',
              lCarpetas = '',
              fhCarpetas='';

          $(carpeta_judicial).each( function( index, carpeta ){
            
            const { fecha_asignacion, folio_carpeta} = carpeta;
            
            lCarpetas += `<div class="">${folio_carpeta == null ? '' : folio_carpeta} ${ folio_carpeta_rem == null ? '' : '<br>'+folio_carpeta_rem}</div>`;

            fhCarpetas += fecha_asignacion == null ? '' : moment(fecha_asignacion).format('LLLL') +  ' hrs.' ;

          });

          if(partes_procesales){
            const tipos_partes = Object.keys(partes_procesales);
            $(tipos_partes).each(function( index, tipo_parte ){
                lPartes += `<h6 class="mg-b-0 text-capitalize">${tipo_parte}</h6>`;
                $(partes_procesales[tipo_parte]).each(function( index, parte ){
                    const { razon_social, nombre, apellido_paterno, apellido_materno} = parte;
                    lPartes += `<div class="b-l-2">${razon_social == null ? '' : razon_social}${ nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</div>`;
                });
            });
          }

          $(delitos).each(function(index, delito){
              lDelitos += `<div class="b-l-2">${delito.delito}</div>`;
          });

          let fechaCreacionAc='';
          if(fecha_creacion_acuerdo!=null){
            const fAc=fecha_creacion_acuerdo.split(' ')[0].split('-');
            fechaCreacionAc='<br>'+fAc[2]+'-'+fAc[1]+'-'+fAc[0]+'<br>';
          }

          let datosDocumento='';
          if(clave_bandeja=='RS' || clave_bandeja=='CACU'){
            datosDocumento=`
              <span>${tipo_solicitud_}</span>
              <span>${folio_solicitud}</span>
              <span>${moment(fecha_recepcion_solicitud).format('LLL')}</span>
              <span>${carpeta_investigacion==null?'':fechaRecepcionSolicitud}</span>
              <span class="font-weight-bold">${cve_juez_promujer==null?'':'('+cve_juez_promujer+')'} ${nombre_juez_promujer==null?'':nombre_juez_promujer}</span>
            `;
          }else if(clave_bandeja=='REV'){
            datosDocumento=`
              <span>${tipo_documento_acuerdo}</span>
              <span>${fechaCreacionAc}</span>
            `;
          }

          fecha_recepcion = fecha_recepcion_solicitud.split(' ');
          const tr=`
            <tr>
              <td class="acciones">
                <label class="ckbox d-inline-block">
                  <input type="checkbox" class="seleccion_tarea" value="${parseInt(id_bandeja)}"><span></span>
                </label>
                <a href="javascript:void(0)"  onclick="verTarea(${index})" id="tarea_${parseInt(id_bandeja)}"><i class="icon ion-folder"></i></a>
              </td>
              <td class="folio">${id_bandeja}<br><small class="text-uppercase mg-b-0 ${estatus_bandeja=='espera'?'tx-danger':'tx-success'}">${estatus_bandeja}</small></td>
              <td class="remitente"> ${ moment(fecha_recepcion[0]+' '+fecha_recepcion[1]).format('LLL') }  hrs.</td>
              <td class="remitente">${ creacion_bandeja == null ? '' : moment(creacion_bandeja).format('LLLL') + ' hrs.'}</td>
              <td class="carpeta">${lCarpetas}</td>
              <td class="descripcion">${descripcion_bandeja=='REGISTRO DE PROMOCION'?'RECEPCIÓN DE PROMOCIÓN':descripcion_bandeja}</td>
              <td class="remitente">${id_usuario_origen==0||id_usuario_origen==null?"PGJ":""}${nombre_usuario_origen==null?"":nombre_usuario_origen} ${usuario_origen==null?"":'<br>('+usuario_origen+')'}</td>
              <td class="remitente">${id_usuario_destino==0||id_usuario_destino==null?"MASTER":""}${nombre_usuario_destino==null?"":nombre_usuario_destino} ${usuario_destino==null?"":'<br>('+usuario_destino+')'}</td>
              <td class="partes">${lPartes}</td>
              <td class="delitos">${lDelitos}</td>
              <td class="juez"><div class="b-l-2">${nombre_juez_promujer==null?'':nombre_juez_promujer}</div></td>
              <td class="comentarios">${comentarios_bandeja==null?'':comentarios_bandeja}</td>
            </tr>
          `;
          $('#bodyTareas').append(tr);
        });

        const anterior=pagina==1?1:pagina-1,
                    totalPaginas=response.response_pag.paginas_totales,
                    siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

        $('.anterior').attr('onclick',`buscar(${anterior})`);
        $('.pagina').html(pagina);
        $('.total-paginas').html(totalPaginas);
        $('.siguiente').attr('onclick',`buscar(${siguiente})`);
        $('.ultima').attr('onclick',`buscar(${totalPaginas})`);

      }else{
        const tr=`
          <tr>
            <td class="unidad tx-center tx-danger" colspan="8">Sin Datos Relacionados</td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
            <td class="d-none"></td>
          <tr>
        `;

        $('#bodyTareas').append(tr);

        $('.anterior').attr('onclick',`buscar(1)`);
        $('.pagina').html('1');
        $('.total-paginas').html('1');
        $('.siguiente').attr('onclick',`buscar(1)`);
        $('.ultima').attr('onclick',`buscar(1)`);
      }
      setTimeout(()=>{
        $('#modal_loading').modal('hide');
      },600);
    }

  });

  countBandejas();
}

async function verTarea(index){

  abreModal('modal_loading');
  $('#resolucion').html('');
  $('#divDatosSujeto').html('');
  $('#divDocumentos').html('');
  $('#divSolicitud').html('');
  $('#opConfirmar').html('');
  $('#divTarea').html('');
  $('#divFracciones').addClass('d-none');
  $('#navItemsFracciones').html('');
  $('#accordionFraccionesSol').addClass('d-none');
  $('#tabPaneFracciones').html('');
  $('.no-footer').DataTable().destroy();
  $('#steps').html('<p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>');
  if( $('.transition.fracciones').attr('aria-expanded') == 'true' ){
    $('.transition.fracciones').click();
  }
  $('#divButtons').parent().removeClass('d-none');
  
  tareaSeleccionada = arrTareas[index];

  const { tabla_asociada,id_tabla_asociada, clave_bandeja, descripcion_bandeja,id_acuerdo,exhorto_autorizacion, estatus_bandeja, id_solicitud, tipo_solicitud_, tipo_resolucion_solicitud,  } = tareaSeleccionada;
  configuracion_usuario = new ConfiguracionRT( tabla_asociada, clave_bandeja, tipo_solicitud_, tipo_resolucion_solicitud );
  configuracion = configuracion_usuario.configuracion();
  resolucion_permiso = configuracion.resolucion_permiso;

  indexTarea=index;

  $('#titleTarea').html(`${descripcion_bandeja} (${clave_bandeja})`);
  
  if( tabla_asociada == 'solicitudes' ) {
    
    if( estatus_bandeja == 'atendida' ) {

      verSolicitudAtendida();
      cierraLoading(600,'modalDatosTarea');
      $('#divButtons').addClass('d-none');

    }else{
      switch (clave_bandeja){
        case 'RS':  // Recepción de solicitud
        case 'CACU':  //Creación del acuerdo
        case 'CAUD':
        case 'REJEC':
          await verSolicitud();
          cierraLoading(600,'modalDatosTarea');
          break;
        case 'RE':// Recepción de exhortos
          if( exhorto_autorizacion == null ) {
            if( tUsuario == 2){
              await verSolicitud(index);
              // abreModal('modalDatosTarea',850);
              cierraLoading(600,'modalDatosTarea');
            }else{
              $('#mensajeWarning').html(`
                <div class="warning-alert">
                  <i class="fa fa-exclamation" aria-hidden="true"></i>
                </div>
                <p class="tx-center">Aún no se ha autorizado el seguimiento para el exhorto</p>
              `);
              abreModal('modalWarning',500);
            }
  
          }else{
            // await stepsSolicitud();
            await verSolicitud(index);
            cierraLoading(600,'modalDatosTarea');
            
          }
          break;
        default:
          alert('calve de tarea no identificada ' + clave_bandeja);
      }
      $('#btnSiguiente').attr('onclick','siguiente()').html('Siguiente');
    }

  }else if(tabla_asociada == 'acuerdos'){

    switch (clave_bandeja){
      case 'REV': // Revisión
      case 'COR': // Corrección
      case 'DEL': //Delegación
        await verAcuerdo(id_acuerdo);
        cierraLoading(600,'modalDatosTarea');
        // abreModal('modalDatosTarea',850);
        break;
      default:
        alert('calve de tarea no identificada');
        return 0;
    }

    $('#btnSiguiente').attr('onclick','siguiente()').html('Siguiente');

  }else if(tabla_asociada =="promociones"){

    switch(clave_bandeja){
      case 'RP':  //Recepción de promoción
      case 'CACU': //Creación del acuerdo
      case 'CAUD':
      case 'RAC':
        // await stepsPromocion();
        await verPromocion(index);
        cierraLoading(600,'modalDatosTarea');
        
        break;
      default:
        alert('calve de tarea no identificada ' + claveBandeja);
    }

    $('#btnSiguiente').attr('onclick','siguiente()').html('Siguiente');

  }else if( tabla_asociada == 'remisiones' ){

    switch ( clave_bandeja ){
      case 'RREMA':
        await verRemision(index);
        cierraLoading(600,'modalDatosTarea');
        $('#btnSiguiente').attr('onclick',`resolverRemision(${tareaSeleccionada.id_tabla_asociada})`).html(`Realizar dictamen final`);
        break;
      case 'CEJE':
        asignacionClave(index);
        break;
      case 'CREM':
        await verRemisionCorreccion(index);
        cierraLoading(600,'modalDatosTarea');
        $('#btnSiguiente').attr('onclick', 'actualizar_remision()');
        break;
      case 'RREM':
        await verRemision();
        break;
      case 'REJEC':
        await verRemisionREJEC();
        cierraLoading(600,'modalDatosTarea');
        break;
      default:
        alert('calve de tarea no identificada ' + claveBandeja);
    }
  }else if( tabla_asociada == 'carpetas_judiciales_documentos' ){
    switch (clave_bandeja){
      case 'CORDOC': // Corrección
      case 'DELDOC': //Delegación
        await verDocumentoG(id_tabla_asociada);
        cierraLoading(600,'modalDatosTarea');
        break;
      default:
        alert('calve de tarea no identificada');
        return 0;
    }
  }
 
  $("#comentarios").val('');
  if( tareaSeleccionada.estatus_bandeja == 'atendida' ) $('#divButtons').parent().addClass('d-none');
}

function obtenerUsuariosUnidad(){
  $('#usuario').html('');
  $.ajax({
    method:'POST',
    url:'/public/obtener_usuarios_unidad',
    data:{
      uga:$('#unidad').val(),
    },
    success:function(response){
      $('#usuario').append('<option value="">Todos</option>');
      if(response.status==100){
        $(response.response).each(function(index, usuario_unidad){
          const {usuario, id_usuario,nombres,apellido_paterno,apellido_materno} = usuario_unidad;
          $('#usuario').append(`<option value="${id_usuario}">${nombres} ${apellido_paterno} ${apellido_materno} (${usuario})</option>`);
        });
      }
    }
  });
}


function firmante(){
  if($('#accion').val()=='firma'){
    $('#usuario_destino').removeAttr('disabled');
    $('#delegar').attr('disabled',true);
  }else if($('#accion').val()=='delegar'){
    $('#usuario_destino').attr('disabled', true);
    $('#delegar').removeAttr('disabled');
  }else{
    $('#delegar').attr('disabled',true);
    $('#usuario_destino').attr('disabled', true);
  }
}

function obtenerDocumentosSolicitud(solicitud, version=''){
  
  return new Promise(resolve => {  
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_solicitud',
        data:{
          solicitud,
          version
        },
        success:function(response){
          resolve(response);
        }
      });
  });
}

function obtenerDocumentosRemision( remision, version='' ){
  return new Promise(resolve => {
      $.ajax({
        method:'POST',
        url:'/public/obtener_documentos_remision',
        data:{ remision, version },
        success:function(response){
          resolve(response);
        }
      });
  });
}

function obtenerDocumentosPromocion( promocion, version = '' ) {

  return new Promise(resolve => {
    $.ajax({
      method:'POST',
      url:'/public/obtener_documentos_promocion',
      data:{ promocion, version},
      success: function(response){ resolve(response); }
    });
  });
}

function obtenerDatosSolicitud_arreglo(solicitud){

    const tipo = arrTareas[indexTarea].tipo_solicitud_;

    return new Promise(resolve => {
      $.ajax({
        method:'POST',
        url:'/public/obtener_datos_solicitud',
        data:{ solicitud, tipo },
        success:function(response){ resolve(response); }
      });
    });
}

function obtenerDatosRemision(remision){
  moment.locale('es-mx');
  $('#validacionDatos').removeClass('d-none');
  $('#resolucion').addClass('d-none');
  $('#accordionFraccionesSol').addClass('d-none');

  return new Promise(resolve => {

    $.ajax({
      method:'POST',
      url:'/public/obtener_datos_remision',
      data:{
        remision,
      },
      success:function(response){
        if(response.status==100){
          tareaSeleccionada = Object.assign( tareaSeleccionada, response['response'][0] );
          const datos={};
          let elementosPersonas='';
          if(response.response[0].personas.length){

            $(response.response[0].personas).each(function(index, persona){
              const {alias, contacto, delitos, datos, direcciones, info_principal} = persona;

              let listaDelitos = '',
                  listaAlias = '',
                  listaCorreos = '',
                  listaTelefonos = '',
                  listaDirecciones = '';

              $(alias).each(function(index, aliasSujeto){ listaAlias += aliasSujeto.alias + '<br>' ;});

              $(contacto).each(function(index,contactoSujeto){
                const {id_contacto_persona,tipo_contacto, contacto, estatus, extension} = contactoSujeto;
                
                if( estatus == 1 )
                  if( tipo_contacto == 'correo electronico' ) 
                    listaCorreos += contacto + '<br>';
                  else 
                    listaTelefonos +=`${tipo_contacto}: ${tipo_contacto} ${extension==null?'':'ext '+extension}<br>`;
              });

              $(direcciones).each(function(index, direccionSujeto){

                const {estado ,estado_text, municipio_text, colonia, localidad, calle,numero_exterior, numero_interior, otra_referencia, entre_calle}=direccionSujeto;

                const tableDireccion=`<br>
                                      <table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000">
                                        <thead>
                                          <tr>
                                            <th class="tx-center" colspan="4" style="background:#f8f9fa">Domicilio ${index+1}</th>
                                            <th class="d-none"></th>
                                            <th class="d-none"></th>
                                            <th class="d-none"></th>
                                          </tr>
                                        </thead>
                                        <tbody class="table-datos-sujeto">
                                          <tr>
                                            <td>Calle:</td>
                                            <td>${calle==null?'':calle}</td>
                                            <td>Número exterior:</td>
                                            <td>${numero_exterior==null?'':numero_exterior}</td>
                                          </tr>
                                          <tr>
                                            <td>Número interior:</td>
                                            <td>${numero_interior==null?'':numero_interior}</td>
                                            <td>Localidad:</td>
                                            <td>${localidad==null?'':localidad}</td>
                                          </tr>
                                          <tr>
                                            <td>Colonia:</td>
                                            <td>${colonia==null?'':colonia}</td>
                                            <td>Municipio:</td>
                                            <td>${municipio_text==null?'':municipio_text}</td>
                                          </tr>
                                          <tr>
                                            <td>Estado:</td>
                                            <td>${estado_text==null?'':estado_text}</td>
                                            <td>Entre Calle y calle:</td>
                                            <td>${entre_calle==null?'':entre_calle}</td>
                                          </tr>
                                          <tr>
                                            <td>Otras referencias:</td>
                                            <td>${otra_referencia==null?'':otra_referencia}</td>
                                          </tr>
                                        </tbody>
                                      </table>  `;

                listaDirecciones += tableDireccion;

              });

              const {calidad_juridica,razon_social,nombre,apellido_paterno,apellido_materno,rfc_empresa,curp,cedula_profesional,genero,fecha_nacimiento,nacionalidad,estado_civil} = info_principal;

              // fechaNacimiento='';
              // if( fecha_nacimiento != null )
              //   fechaNacimiento = formatoFecha(fecha_nacimiento);
              
              const {otra_ocupacion,nivel_escolaridad,otra_escolaridad,nombre_religion,otra_religion,grupo_etnico,otro_grupo_etnico,lengua,capacidad_diferente,descripcion_discapacidad,sabe_leer_escribir,poblacion_callejera,poblacion,otra_poblacion,nombre_poblacion,entiende_idioma_espanol,requiere_interprete,tipo_interprete,requiere_traductor,idioma_traductor,otro_idioma_traductor} = datos[0];
              ocupacion = '';

              const table=`
                <table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000">
                  <tbody class="table-datos-sujeto">
                    <tr><td colspan="4" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la persona</td></tr>
                    <tr>
                      <td>Calidad jurídica:</td>
                      <td>${calidad_juridica}</td>
                      <td>Ocupación:</td>
                      <td>${ocupacion==null?'':ocupacion}</td>
                    </tr>
                    <tr>
                      <td>Nombre ó Razón Social:</td>
                      <td>${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}</td>
                      <td>Otra Ocupación:</td>
                      <td>${otra_ocupacion==null?'':otra_ocupacion}</td>
                    </tr>
                    <tr>
                      <td>RFC:</td>
                      <td>${rfc_empresa==null?'':rfc_empresa}</td>
                      <td>Escolaridad:</td>
                      <td>${nivel_escolaridad==null?'':nivel_escolaridad}</td>
                    </tr>
                    <tr>
                      <td>CURP:</td>
                      <td>${curp==null?'':curp}</td>
                      <td>Otra Escolaridad:</td>
                      <td>${otra_escolaridad==null?'':otra_escolaridad}</td>
                    </tr>
                    <tr>
                      <td>Cédula Profesional:</td>
                      <td>${cedula_profesional==null?'':cedula_profesional}</td>
                      <td>Religión:</td>
                      <td>${nombre_religion==null?'':nombre_religion}</td>
                    </tr>
                    <tr>
                      <td>Género:</td>
                      <td class="text-capitalize">${genero==null?'':genero}</td>
                      <td>Otra Religión:</td>
                      <td>${otra_religion==null?'':otra_religion}</td>
                    </tr>
                    <tr>
                      <td>Fecha de Nacimiento:</td>
                      <td>${fecha_nacimiento == null ? '' : moment(fecha_nacimiento).format('LL')}</td>
                      <td>Grupo Étnico:</td>
                      <td>${grupo_etnico==null?'':grupo_etnico}</td>
                    </tr>
                    <tr>
                      <td>Nacionalidad:</td>
                      <td>${nacionalidad==null?'':nacionalidad}</td>
                      <td>Otro Grupo Étnico:</td>
                      <td>${otro_grupo_etnico==null?'':otro_grupo_etnico}</td>
                    </tr>
                    <tr>
                      <td>Estado Civíl:</td>
                      <td>${estado_civil==null?'':estado_civil}</td>
                      <td>Lengua:</td>
                      <td>${lengua==null?'':lengua}</td>
                    </tr>
                    <tr>
                      <td>Capacidad Diferente:</td>
                      <td>${capacidad_diferente==null?'':capacidad_diferente}</td>
                      <td>Discapacidad:</td>
                      <td>${descripcion_discapacidad==null?'':descripcion_discapacidad}</td>
                    </tr>
                    <tr>
                      <td>Sabe Leer y Escribir:</td>
                      <td>${sabe_leer_escribir==null?'':sabe_leer_escribir}</td>
                      <td>Población Callejera:</td>
                      <td>${poblacion_callejera==null?'':poblacion_callejera}</td>
                    </tr>
                    <tr>
                      <td>Población:</td>
                      <td>${poblacion==null?'':poblacion}</td>
                      <td>Otra Población:</td>
                      <td>${otra_poblacion==null?'':otra_poblacion}</td>
                    </tr>
                    <tr>
                      <td>Nombre Población:</td>
                      <td>${nombre_poblacion==null?'':nombre_poblacion}</td>
                      <td>Entiende el Idioma Español:</td>
                      <td>${entiende_idioma_espanol==null?'':entiende_idioma_espanol}</td>
                    </tr>
                    <tr>
                      <td>Requiere Intérprete:</td>
                      <td>${requiere_interprete==null?'':requiere_interprete}</td>
                      <td>Tipo de Intérprete:</td>
                      <td>${tipo_interprete==null?'':tipo_interprete}</td>
                    </tr>
                    <tr>
                      <td>Requiere Traductor:</td>
                      <td>${requiere_traductor==null?'':requiere_traductor}</td>
                      <td>Idioma del Traductor:</td>
                      <td>${idioma_traductor==null?'':idioma_traductor}</td>
                    </tr>
                    <tr>
                      <td>Otro Idioma del Traductor:</td>
                      <td>${otro_idioma_traductor==null?'':otro_idioma_traductor}</td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <div class="row">
                  <div class="col-md-4">
                    <br>
                    <table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000">
                      <tbody>
                        <tr>
                          <td style="background-color: #848F33; color: #FFF;" class="tx-center">Teléfonos</td>
                        </tr>
                        <tr>
                          <td>${listaTelefonos==''?'<span class="tx-italic" style="color: #868ba1">Sin teléfonos registrados</span>':listaTelefonos}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-4">
                    <br>
                    <table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000">
                      <tbody>
                        <tr>                          
                          <th style="background-color: #848F33; color: #FFF;" class="tx-center">Correos</th>
                        </tr>
                        <tr>
                          <td>${listaCorreos==''?'<span class="tx-italic" style="color: #868ba1">Sin correos registrados</span>':listaCorreos}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-4">
                    <br>
                    <table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000">
                      <tbody>
                        <tr>
                          <th style="background-color: #848F33; color: #FFF;" class="tx-center">Alias</th>
                        </tr>
                        <tr>
                          <td>${listaAlias==''?'<span class="tx-italic" style="color: #868ba1">Sin alias registrados</span>':listaAlias}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                ${listaDirecciones}
              `;
              const elementoPersona=`
                <div id="accordion${index}" class="accordion-one mg-b-10 tx-uppercase" role="tablist" aria-multiselectable="true">
                  <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                      <a data-toggle="collapse" data-parent="#accordion${index}" href="#collapseOne${index}" aria-expanded="true" aria-controls="collapseOne${index}" class="tx-gray-800 transition collapsed">
                        ${razon_social==null?'':razon_social}${nombre==null?'':nombre} ${apellido_paterno==null?'':apellido_paterno} ${apellido_materno==null?'':apellido_materno}
                      </a>
                    </div><!-- card-header -->

                    <div id="collapseOne${index}" class="collapse" role="tabpanel" aria-labelledby="headingOne${index}">
                      <div class="card-body" >
                        ${table}
                      </div>
                    </div>
                  </div>
                </div>
              `;

              elementosPersonas=elementosPersonas.concat(elementoPersona);

            });

            
            

          }
          datos.elementosPersonas=elementosPersonas;

          const {folio, tipo_remision, fecha_registro, materia_destino, fecha_solicitud, fecha_recepcion, carpeta_judicial, carpeta_investigacion, motivo_incompetencia, motivo_incompetencia_otro} = response.response[0];

          let tableSolicitud= `
            <table class="datatable tableDatosSujeto tx-uppercase" style="overflow-x: none; display: table; color: #000"">
              <tbody class="table-datos-sujeto">
                <tr><td colspan="2" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la remisión</td></tr>
                <tr>
                  <td>Folio:</td>
                  <td>${folio}</td>
                </tr>
                <tr>
                  <td>Carpeta Judicial:</td>
                  <td>${carpeta_judicial}</td>
                </tr>
                <tr>
                  <td>Carpeta de investigación:</td>
                  <td>${carpeta_investigacion}</td>
                </tr>
                <tr>
                  <td>Materia Destino:</td>
                  <td>${materia_destino==null?"<span style='font-style: italic;'>na</span>":materia_destino.replace("_"," ")}</td>
                </tr>
                <tr>
                  <td>Motivo de la Remisión:</td>
                  <td>${tipo_remision==null?"":tipo_remision.replace("_"," ")}</td>
                </tr>
                <tr>
                  <td>Motivo de la incompetencia:</td>
                  <td>${motivo_incompetencia == null ? "<span style='font-style: italic;'>na</span>" : motivo_incompetencia == 'otro' ? motivo_incompetencia_otro : motivo_incompetencia.replace("_"," ")}</td>
                </tr>
                <tr>
                  <td>Fecha de Registro:</td>
                  <td>${moment(fecha_registro).format('dddd, LL')}</td>
                </tr>
                <tr>
                  <td>Fecha de Recepción:</td>
                  <td>${moment(fecha_recepcion).format('LLLL')} hrs.</td>
                </tr>
              
          `;


          if( tareaSeleccionada.datos_cj != null && tareaSeleccionada.datos_cj.folio_carpeta )
            tableSolicitud += `<tr><td>Folio remisión:</td><td>${tareaSeleccionada.datos_cj.folio_carpeta}</td></tr>`;

          tableSolicitud += '</tbody></table>';

          datos.infoSolicitud=tableSolicitud

          resolve(datos);

        }else{
          error(response.message)
        }
      }
    });

  });
}

function obtenerGrupoTrabajo(){
  return new Promise(resolve => {
    let usuarios='';
    $.ajax({
      method:'POST',
      url:'/public/obtener_grupo_trabajo',
      async:true,
      data:{
        tipo:'desc',
        nivel:'1',
        id_usuario: idUsuario
      },
      success:function(response){
        if(response.status==100){

          $(response.response).each(function(index, usuarioGT){
            const {id_usuario, nombres, apellido_paterno, apellido_materno, usuario}=usuarioGT;
            usuarios=usuarios.concat(`<option class="text-uppercase"  value="${id_usuario}">${nombres} ${apellido_paterno} ${apellido_materno} (${usuario})</option>`);
          });
        }
        resolve(usuarios);
      }
    });

  });
}

function obtenerJueces(juezFirmante='', cambio='0'){
  
  if( unidades_ejecucion.includes( String(unidadGestion) ))
    var director = 25;
  else
    var director = 2;

  return new Promise(resolve => {
    let jueces='<option value="" disabled selected>Seleccione a un Juez</option>';
    $.ajax({
      method:'POST',
      url:'/public/obtener_jueces_unidad',
      async:true,
      data:{
        director,
        tipo_resolucion: $('#tipoResolucion').val(),
        // uga: tareaSeleccionada.id_unidad,
      },
      success:function(response){
        if(response.status==100){
          
          $(response.response).each(function(index, juez){
            
            const {id_usuario, nombres, apellido_paterno, apellido_materno, cve_juez, id_tipo_usuario,usuario}=juez;
            
            if(juezFirmante == id_usuario)
             jueces += `<option class="text-uppercase" value="${id_usuario}" selected>${id_tipo_usuario==5?'Juez':id_tipo_usuario==2?'Dir':''} ${nombres} ${apellido_paterno} ${apellido_materno} (${cve_juez}) - ${usuario}</option>`;

            else if( cambio == 0 )
              jueces += `<option class="text-uppercase" value="${id_usuario}">${id_tipo_usuario==5?'Juez':id_tipo_usuario==2?'Dir':''} ${nombres} ${apellido_paterno} ${apellido_materno} (${cve_juez ?? 'na'}) - ${usuario}</option>`;
            
          });
        }
        resolve(jueces);
      }
    });

  });
}

function obtener_siguiente_juez_control(){
    return new Promise(resolve => {
      let jueces='';
      $.ajax({
        method:'POST',
        url:'/public/obtener_siguiente_juez_control',
        async:true,
        data:{

        },
        success:function(response){
            resolve(response);
        }
      });

    });
}


function obtener_inmuebles(){
  return new Promise(resolve => {
    let jueces='';
    $.ajax({
      method:'POST',
      url:'/public/obtener_inmuebles',
      async:true,
      data:{

      },
      success:function(response){
          resolve(response);
      }
    });

  });
}

function obtener_inmueble_salas(id_inmueble){
  return new Promise(resolve => {
    let jueces='';
    $.ajax({
      method:'POST',
      url:'/public/obtener_inmueble_salas',
      async:true,
      data:{
          id_inmueble:id_inmueble
      },
      success:function(response){
          resolve(response);
      }
    });

  });
}

let index_global;
function siguienteX(solicitud, index){
  $('.error').removeClass('error');

  if($('#tipoResolucion').val()==''){

    error('Datos Incompletos', 'No ha seleccionado el tipo de resolución de la solicitud', 'modalDatosTarea');
    $('#modalDatosTarea').modal('hide');
    $('span[aria-labelledby="select2-tipoResolucion-container"]').addClass('error');

  }else{
    $('#step-datos-solicitud').removeClass('activo').addClass('resuelto');
    $('#step-resolucion').removeClass('espera').addClass('activo');
    $('#atras').removeAttr('disabled');

    if($('#tipoResolucion').val()=='acuerdo'){

      if(tUsuario==3 || claveBandeja=='CACU' || claveBandeja=='REV' || claveBandeja=='COR' || claveBandeja=='RP'){

        $('#resolucion').append(`

        `);

        setTimeout(function(){
          tipoDocumento();
        },300);

        if(claveBandeja=='REV' || claveBandeja=='COR'){
          obtener_doc_acuerdo(tareaSeleccionada.id_acuerdo);
        }

      }else{

      }

    }else if($('#tipoResolucion').val()=='audiencia'){
        //alert('aqui con aud ' + tUsuario);


        if(typeof index == "number"){
            index_global = index;
        }
        cargarAudiencia(index_global);

    }

    $('#validacionDatos').addClass('d-none');
    $('#resolucion').removeClass('d-none');
    $('#accordionFraccionesSol').removeClass('d-none');

    if((claveBandeja=='REV' || claveBandeja=='CACU' || claveBandeja=='RE') && origenTarea=='solicitudes'){

      const acuerdo=tareaSeleccionada.id_acuerdo;
      $('#avanzar').attr('onclick',`avanzar(${acuerdo})`)
      $('#btnSiguiente').attr('onclick', `validarTareaSolicitud(${solicitud}, ${indexTarea})`).html(`Resolver Tarea`);

    }else if((claveBandeja=='RP' || claveBandeja=='CACU') && origenTarea=="promociones"){

      $('#btnSiguiente').attr('onclick', `validarTareaPromocion(${promocion}, ${indexTarea})`).html(`">Resolver Tarea`);
    }
    else{
      $('#btnSiguiente').attr('onclick', `validarTareaSolicitud(${solicitud}, ${indexTarea})`).html(`Resolver Tarea`);
    }
  }
}

function atras( step = ''){
  
  
  
  if( step == 'fracciones' ){
    $('#divFracciones').addClass('d-none');
    $('#resolucion').removeClass('d-none');
    $('#steps p:last-child').remove();
    $('#divButtons').html('<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="validarTareaSolicitud()" id="btnSiguiente">Siguiente</button>');
  }else{
    $('#resolucion').addClass('d-none');  
    $('#atras').attr('disabled', true);
    $('#steps').html(`<p class="step activo d-inline-block d-md-flex mg-r-10" id="step-datos-solicitud"><span class="num-step">1</span><span class="text-step d-none d-md-block">Validación de Datos</span></p>`);
    $('#step-datos-solicitud').addClass('activo').removeClass('resuelto');
    $('#step-resolucion').addClass('espera').removeClass('activo');
    $('#validacionDatos').removeClass('d-none');
    $('#divButtons').html('<button type="button" class="btn btn-primary d-inline-block mg-l-auto" onclick="siguiente()" id="btnSiguiente">Siguiente</button>');
  }
  
  
  $('#atras').attr('onclick', "atras()");
}

async function leeDocumento (input) {

  const file = $('#archivoDoc').val(),
        ext = file.substring(file.lastIndexOf("."));
        nombre=normalize((file.split('\\')[2]).split('.')[0]);
        $('#archivoDoc')[0].files[0].name="gocumento.docx";
        setTimeout(()=>{
        },500);
  if(ext!=''){
    if(ext != ".doc" && ext != ".docx" && ext != ".pdf"){
      alert('Solo puede adjutar archivos .doc , .docx o .pdf');
      $('#archivoDoc').val('');
      $('#docSeleccionado').html('');
      $('#vistaPreviaDocPDF').html(``);
    }else{
      $('#docSeleccionado').html(`
      <div class="tx-center">
        <a href="javascript:void(0)"  onclick="borraDoc()"><i class="fa fa-times" aria-hidden="true" style="margin-left: 140px; margin-bottom: 10px; color: red;"></i></a>
        <i class="fa fa-file-${(ext == '.doc' || ext == '.docx') ? 'word' : 'pdf'}-o d-block mg-b-10" aria-hidden="true" style="color:#848F33; font-size:70px"></i>
        <label ondblclick="cambiarNombre()" id="labelNombre" style="width: 100%; overflow-x: scroll;">${nombre}${ext}</label>
        <input type="hidden" value="${nombre}" id="nombreDoc" name="nombre_doc" onblur="guardaNombreDoc('${ext}')"  onkeypress="guardaNombreDoc('${ext}', event)" style="text-align: center; border:#868ba1"></div>
      `);
      const url_previa= await vistaPrevia();
      $('#vistaPreviaDocPDF').html(`<object data="${url_previa}" width="100%" height="350px" class="mg-t-25"></object>`)
    }
  }
}

function borraDoc(){
  $('#archivoDoc').val('');
  $('#docSeleccionado').html('');
  $('#vistaPreviaDocPDF').html('');
}

function vistaPrevia(){
  return new Promise(resolve => {
    abreModal('modal_loading');
    $('#modalDatosTarea').modal('hide');
    resolucion=new FormData($("#cargarDocumento")[0]);
    resolucion.append('nombre_doc',$('#labelNombre').text())
    $.ajax({
      method:'POST',
      url:'/public/vista_previa',
      data:resolucion,
      contentType: false,
      processData: false,
      cache: false,
      success:function(response){
        cierraLoading(500);
        abreModal('modalDatosTarea',350);
        
        resolve(response);
      }
    });
  });
}

function cambiarNombre(){
  $('#labelNombre').addClass('d-none');
  $('#nombreDoc').attr('type','text').focus();
}

function guardaNombreDoc(ext, e=''){
  if ((e=='' || e.keyCode === 13) && !e.shiftKey) {

    const nombre=normalize($('#nombreDoc').val());

    $('#labelNombre').removeClass('d-none').html(nombre+ext);
    $('#nombreDoc').attr('type','hidden').val(nombre);
  }
}

function error(title='', message='', modal=''){
  $('#titleError').html(title);
  $('#messageError').html(message);
  $('#modalError').modal('show');
  if(modal!=''){
    $('#'+modal).modal('hide');
    $('#acepError').attr('onclick', `abreModal('${modal}',355)`);
  }
  return false;
}

function abreModal(modal, time=0){
  setTimeout(function(){
    $('#'+modal).modal('show');
  },time);
}

function editorHTML(){
  editor_html = new FroalaEditor("#edit", {
    height: 'calc(100vh - 100vh/2)',
    language: 'es',
    width: '800',
    imageDefaultWidth: 0,
    imageOutputSize: true,

    key: '0BA3jA11A8B5A3E4D4aIVLEABVAYFKc2Cb1MYGH1g1NYVMiG5G4E3C3A1C8C6D4A3F4==',
    embedlyKey: '0BA3jA11A8B5A3E4D4aIVLEABVAYFKc2Cb1MYGH1g1NYVMiG5G4E3C3A1C8C6D4A3F4==',

    attribution: false,
    autofocus: true,
    htmlUntouched: true,
    htmlAllowedAttrs: ['v:shapes'],
    imageUploadParams:{
      'v:shapes':'mi_prueba'
    },
    imageRoundPercent: true,

    // Set custom buttons with separator between them.
    toolbarButtons: {
      'moreText': {
        'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
      },
      'moreParagraph': {
        'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
      },
      'moreRich': {
        'buttons': ['insertLink', 'insertImage', 'insertTable', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR']
      },
      // 'moreMisc': {
      //   'buttons': ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help']
      // }
    },
    imageEditButtons: [['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize']],
    // toolbarButtonsXS: [['undo', 'redo'], ['bold', 'italic', 'underline']],
    events: {
      'image.beforeUpload': function (files) {
        const editor = this
        if (files.length) {
          var reader = new FileReader()
          reader.onload = function (e) {
            var result = e.target.result;
            num1=Math.floor(Math.random() * 100) + 1;
            num2=Math.floor(Math.random() * 100) + 1;

            editor.image.insert(result, null, {'v:shapes': 'Imagen_'+num1+'_'+num2+''}, editor.image.get())

            const dataAttributesToFix = ['v:shapes'] // replace this for the attributes you want fixed
            editor.events.on('image.inserted', image => {
              dataAttributesToFix.forEach(k => {
                if (image.attr('data-str' + k)) {
                    image.attr( k, image.attr('data-str' + k))
                    image.removeAttr('data-str' + k)
                }
              })
            })

          }
          reader.readAsDataURL(files[0])
        }
        return false
      }
    }
  })
}

function obtener_grupo_trabajo(){
  $.ajax({
    method:'POST',
    url:'/public/obtener_grupo_trabajo',
    data:{

    },
    success:function(response){

    }
  });
}

function accion(){
  if($('#accion').val()=='revision'){
    $('#usuario_destino').attr('disabled', true);
  }else{
    $('#usuario_destino').removeAttr('disabled');
  }
}

function cierraLoading(time, modal){
  setTimeout( () => {
    $('#modal_loading').modal('hide');
  },time);
  setTimeout( () => {
    $('#'+modal).modal('show');
  }, time + 400);
};


var normalize = (function() {
  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
      to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      mapping = {};

  for(var i = 0, j = from.length; i < j; i++ )
      mapping[ from.charAt( i ) ] = to.charAt( i );

  return function( str ) {
      var ret = [];
      for( var i = 0, j = str.length; i < j; i++ ) {
          var c = str.charAt( i );
          if( mapping.hasOwnProperty( str.charAt( i ) ) )
              ret.push( mapping[ c ] );
          else
              ret.push( c );
      }
      return ret.join( '' ).replace( /-|[^-A-Za-z0-9]+/g, '_' ).toLowerCase();;
  }

})();

function obtener_archivo_acuerdo(acuerdo, tipo='pdf'){
  return new Promise( resolve => {
    $.ajax({
      method:'POST',
      url:'/public/obtener_ultima_version_acuerdo',
      data:{ acuerdo, tipo },
      success:function(response){ resolve(response) }
    });
  });
}

function obtener_archivo_oficio(id_carpeta_judicial, id_documento, modo='pdf'){
  return new Promise( resolve => {
    $.ajax({
      method:'POST',
      url:`public/obtener_ultima_version_oficio`,
      data:{ id_carpeta_judicial,  documento:id_documento, modo },
      success:function(response){ resolve(response) }
    });
  });
}

function obtenerDatosPromocion(promocion, tipo =''){
  return new Promise(resolve => {
    $.ajax({
      method:'GET',
      url:'/public/obtener_promociones',
      // data:{ id_promocion: promocion, usuario: 1},
      data:{ id_promocion: promocion, usuario: idUsuario},
      success:function(response){ resolve(response); }
    });
  });
}


function icon( tipoArchivo ) {
  let icono = '';

  switch (tipoArchivo){
    case '.pdf':
      icono='<i class="fa fa-file-pdf-o mg-r-10" aria-hidden="true" style="font-size:25px;"></i>';
      break;
    case '.jpg':
    case '.png':
    case '.JPEG ':
      icono='<i class="fa fa-file-image-o mg-r-10" aria-hidden="true" style="font-size:25px;"></i>';
      break;
    default:
      icono='<i class="fa fa-question mg-r-10" aria-hidden="true" style="font-size:25px;"></i>';
  }

  return icono;
}

$('.valor_fraccion').click(function() { 
  setTimeout( () => { 
    if( !$(this).find('.toggle-on').hasClass('active') )  {
      $( $( '.'+$(this).attr('id') ) ).each( function() { 
        if( $(this).find('.toggle-on').hasClass('active') ) 
          $(this).click(); 
      });
    }
  },100); 
});

$('.hipotesis').click(function() { 
  setTimeout( () => { 
    if( $(this).find('.toggle-on').hasClass('active') )  
      if( !$('#'+$(this).attr('id-fraccion')).find('.toggle-on').hasClass('active') ) 
        $('#'+$(this).attr('id-fraccion')).click(); 
      
  },100); 
});

function obtenerMedidasProteccion( persona, id_documento = tareaSeleccionada.id_acuerdo , tipo = 'acuerdo' ) {

  return new Promise(resolve => {

    $.ajax({
      method:'GET',
      url:'/public/obtener_medidas_proteccion',
      data:{
        persona,
        id_documento,
        tipo
      },
      success:function(response){ resolve(response); }
    });

  });

}

function tableFracciones( i ) {

  if( !$('#tableFracciones'+i).hasClass('no-footer') ) {
    setTimeout(function(){
      tables[i] = $('#tableFracciones'+i).DataTable({
        ordering: false
      });
      
    },1)

  }  
}

$('#tabPaneFracciones').on('click', '.fraccion_acuerdo' , function() {

    let fraccion_valor = 0;

    if( $(this).find('.toggle-on').hasClass('active') )
      fraccion_valor = 1;

    let fraccion_descripcion_otros = '-';

    if( $(this).attr('id-cat') == 16  )
      fraccion_descripcion_otros = $('#descripcion_otros');
    
    const medidas = {
      id_cat: $(this).attr('id-cat'),
      id_fraccion_valor: $(this).attr('id-acu-fraccion'),
      fraccion_valor,
      fraccion_descripcion_otros,      
    };

    medidasPersona.push(medidas);

});

function guardarCambiosMedidas( persona, i ) {

  let medidasPersona = [];

  var rows = $("#tableFracciones"+i).dataTable().fnGetNodes();

  $(rows).each( function() {
    
    let fraccion_valor = 0;
    
    if( $(this).find('.fraccion_acuerdo').find('.toggle-on').hasClass('active') )
      fraccion_valor = 1;

    let fraccion_descripcion_otros = '-';

    if( $(this).find('.fraccion_acuerdo').attr('id-cat') == 16  )
      fraccion_descripcion_otros = $('#descripcion_otros').val();

    const medidas = {
      id_cat: $(this).find('.fraccion_acuerdo').attr('id-cat'),
      id_fraccion_valor: $(this).find('.fraccion_acuerdo').attr('id-acu-fraccion'),
      fraccion_valor,
      fraccion_descripcion_otros,      
    };

    medidasPersona.push(medidas);

  });
  $.ajax({

    method: 'PATCH',
    url: '/public/modificar_medidas_proteccion_persona',
    data:{
      medidasPersona,
      persona,
      id_documento: tareaSeleccionada.id_acuerdo,
      tipo: 'acuerdo'
    },
    success: function(response){

      $('#check'+persona).removeClass('d-none');
      setTimeout( () => {
        $('#check'+persona).addClass('d-none');
      },800);

    }

  });

  if ( tareaSeleccionada.tipo_solicitud_ == 'INICIAL' && tareaSeleccionada.id_ta == 52 ) {

    let medidasPersonaSol = [];
    let persona;

    $(rows).each( function() {
      
      let fraccion_valor = 0;
      
      if( $(this).find('.fraccion_solicitud').find('.toggle-on').hasClass('active') )
        fraccion_valor = 1;

      let fraccion_descripcion_otros = '-';

      if( $(this).find('.fraccion_solicitud').attr('id-cat') == 16  )
        fraccion_descripcion_otros = $('#descripcion_otros').val();

      const medidas = {
        id_cat: $(this).find('.fraccion_solicitud').attr('id-cat'),
        id_fraccion_valor: $(this).find('.fraccion_solicitud').attr('id'),
        fraccion_valor,
        fraccion_descripcion_otros,      
      };
      
      medidasPersonaSol.push(medidas);

      persona = $(this).find('.fraccion_solicitud').attr('id-persona');

    });
    $.ajax({

      method: 'PATCH',
      url: '/public/modificar_medidas_proteccion_persona',
      data:{
        medidasPersona:medidasPersonaSol,
        persona,
        id_documento: tareaSeleccionada.id_solicitud,
        tipo: 'solicitud'
      },
      success: function(response){

        $('#check'+persona).removeClass('d-none');
        setTimeout( () => {
          $('#check'+persona).addClass('d-none');
        },800);

      }

    });
    
  }
}

$('#modalDatosTarea').on('click', '.transition.fracciones', function() {
  
  if(!$('#navItemsFraccionesSol li:first-child').hasClass('selected')){
    $('#navItemsFraccionesSol li:first-child').addClass('selected');
    $('#navItemsFraccionesSol li:first-child').find('a').click();
  }

  if($(this).find('i').hasClass('fa-angle-down')){
    $(this).find('i').removeClass('fa-angle-down');
    $(this).find('i').addClass('fa-angle-up');
  }else{
    $(this).find('i').addClass('fa-angle-down');
    $(this).find('i').removeClass('fa-angle-up');
  }

});

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

function obtenerPersonasCarpeta(carpeta){
  
  return new Promise( resolve => {
    $.ajax({
      method:'POST',
      url:'/public/obtener_personas_carpeta',
      data:{carpeta},
      success:function(response){ resolve(response); }
    });
  });

}

async function verSolicitudAtendida() {
  
  moment.locale('es-mx');        
  const data_solicitud = await new Solicitud( tareaSeleccionada.id_solicitud, tareaSeleccionada.tipo_solicitud_ ),
    documentos_solicitud = await data_solicitud.obtenerDocumentosSolicitud();
  
  let lDocs = '';

  if( documentos_solicitud.status == 100 ) {
    lDocs += `<object data="${documentos_solicitud.response}" width="100%" height="455px" ></object>`;
  }
    
  let dResolucion = '';
  console.log(data_solicitud);
  const { personas, fecha_solicitud, carpeta_investigacion, fecha_fenece, folio_solicitud, fecha_recepcion, hora_recepcion, tipo_audiencia, estatus_telepresencia, estatus_area_resguardo, estatus_mod_testigo_protegido, estatus_mesa_evidencia,  mp_solicitante, materia_destino, correo_mp, delitos, fecha_asignacion, descripcion_hechos, unidad_registrante_prom } = data_solicitud.solicitud;

  let tableSolicitud = '<table class="datatable tableDatosSujeto text-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td colspan="2" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la soliditud</td></tr>';

  str_delitos = '';
  $( delitos ).each( function( i, delito) { i == 0 ? str_delitos += delito.delito : str_delitos += ', ' + delito.delito});

  const arr_fs = fecha_solicitud.split(' ')[0].split('-').reverse(),
    fecha_solicitud_ = arr_fs[0] + '-' +arr_fs[1] + '-' +arr_fs[2];

  const datos_tabla_solicitud = [
    ["Folio de la solicitud:", folio_solicitud],
    ["Fecha de recepción:", fecha_recepcion == null ? '' : moment(fecha_recepcion.split(' ')[0]).format('LL')],
    ["Carpeta de investigación:", carpeta_investigacion == null ? '' : carpeta_investigacion],
    ["Fenece a las:", fecha_fenece == null ? '' : formatoFecha(fecha_fenece.split(' ')[0])],
    ["Tipo de audiencia:", tipo_audiencia],
    ["Clase de audiencia:", 'Ordinaria'],
    ["Requiere resguardo:", estatus_area_resguardo ?? ''],
    ["Requiere Telepresencia:", estatus_telepresencia ?? ''],
    ["Requiere mesa de evidencia:", estatus_mesa_evidencia ?? ''],
    ["Requiere modalidad de testigo protegido", estatus_mod_testigo_protegido ?? ''],
    ["Delitos:", str_delitos],
    ["Materia:", materia_destino],
    ["Fecha de asignación de carpeta:", fecha_asignacion == null ? '' : formatoFecha(fecha_asignacion.split(' ')[0]) ],
    ["Fecha de la solicitud:", fecha_solicitud == null ? '' : formatoFecha(fecha_solicitud_)],
    ["Hora de recepción:", hora_recepcion],
    ["MP solicitante:", mp_solicitante ?? ''],
    ["Correo del MP:", correo_mp == null ? '' : correo_mp],
    ["Unidad registrante", unidad_registrante_prom ?? ''],
    ["Descripción de los hechos:", descripcion_hechos == null ? '' : descripcion_hechos],
  ]

  $( datos_tabla_solicitud ).each( ( i, campo ) => { tableSolicitud += `<tr><td>${campo[0]}</td><td class="">${campo[1]}</td></tr>`; });

  tableSolicitud += '</tbody></table>';

  let datos_personas = '';
  $( personas ).each( function( i, persona ){

    const { razon_social, nombre, apellido_paterno, apellido_materno, calidad_juridica, ocuapcion, rfc_empresa, nivel_escolaridad, curp, otra_escolaridad, cedula_profesional, nombre_religion, genero, otra_religion, fecha_nacimiento, grupo_etnico, estado_civil, lengua, capacidad_diferente, sabe_leer_escribir, poblacion_callejera, poblcacion, otra_poblacion, nombre_poblacion, entiende_idioma_espanol, requiere_interprete, tipo_interprete, requiere_traductor, idioma_traductor, otro_idioma_traductor} = persona.info_principal;

    const campos_adicionales_persona = [
      ["Calidad juridica:", calidad_juridica],
      ["Ocupación:", ocuapcion],
      ["RFC:", rfc_empresa],
      ["Nivel de escolaridad:", nivel_escolaridad],
      ["CURP:", curp],
      ["Otra escolaridad:", otra_escolaridad],
      ["Cédula Profesional:", cedula_profesional],
      ["Religión:", nombre_religion],
      ["Género:", genero],
      ["Otra religión:", otra_religion],
      ["Fecha de nacimiento:", fecha_nacimiento == null ? '' : formatoFecha(fecha_nacimiento)],
      ["Grupo étnico:", grupo_etnico],
      ["Estado civil:", estado_civil],
      ["Lengua:", lengua],
      ["Capacidad diferente:", capacidad_diferente],
      ["Sabe leer y escribir:", sabe_leer_escribir],
      ["Población callejera:", poblacion_callejera],
      ["Población:", poblcacion],
      ["Otra población:", otra_poblacion],
      ["Nombre de la población:", nombre_poblacion],
      ["Entiende el idioma español:", entiende_idioma_espanol],
      ["Requiere intérprete:", requiere_interprete],
      ["Tipo de intérprete:", tipo_interprete],
      ["Requiere traductor:", requiere_traductor],
      ["Idioma del traductor:", idioma_traductor],
      ["Otro idioma del traductor:", otro_idioma_traductor],
    ];

    let card_persona = `<div id="accordion${i}" class="accordion-one mg-b-10  tx-uppercase" role="tablist" aria-multiselectable="true">
        <div class="card"><div class="card-header" role="tab" id="headingOne"><a data-toggle="collapse" data-parent="#accordion${i}" href="#collapseOne${i}" aria-expanded="true" aria-controls="collapseOne${i}" class="tx-gray-800 transition collapsed">${razon_social == null ? '' : razon_social}${nombre == null ? '' : nombre} ${apellido_paterno == null ? '' : apellido_paterno} ${apellido_materno == null ? '' : apellido_materno}</a></div><div id="collapseOne${i}" class="collapse" role="tabpanel" aria-labelledby="headingOne${i}"><div class="card-body" >`;
        
    card_persona += '<table class="datatable tableDatosSujeto  tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody class="table-datos-sujeto"><tr><td colspan="4" style="background-color: #848F33; color: #FFF;" class="tx-center">Datos generales de la persona</td></tr>';
    
    $( campos_adicionales_persona).each( function( i, campo ){
      if( i%2 == 0 ) card_persona += '<tr>';
      card_persona += `<td>${campo[0]}</td><td style="">${campo[1] == null ? '' : campo[1]}</td>`;
      if( i%2 != 0 ) card_persona += '</tr>';
    });

    card_persona += '</tbody></table>';

    if( persona.delitos.length > 0 ) {

      card_persona += '<br><table  class="datatable tableDatosSujeto2 tx-uppercase table_persona_delitos" style="overflow-x: none; display: table; color: #000;"><tbody><tr><td style="background-color: #848F33; color: #FFF;" class="tx-center" colspan="4">Delitos relacionados a la persona</td></tr><tr><th class="tx-center">Delito</th><th class="tx-center">Modalidad</th><th class="tx-center">Calificativo</th><th class="tx-center">Grado de realización</th></tr>';

      $( persona.delitos ).each( function( id, delito ) { 
        card_persona += `<tr><td>${delito.delito}</td><td>${delito.nombre_modalidad}</td><td>${delito.calificativo}</td><td>${delito.grado_realizacion.replace('_', ' ')}</td><tr>`;
      });

      card_persona += '</tbody></table>';

    }

    card_persona += '<div class="row"><div class="col-md-4"><br><table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody><tr><td  style="background-color: #848F33; color: #FFF;" class="tx-center">Teléfonos</td><tr>';

    const telefonos = persona.contacto.filter( contacto => contacto.tipo_contacto != 'correo electronico' );

    if( telefonos.length > 0 ) $( telefonos ).each(function( ic, contaco) { card_persona += `<tr><td>${tipo_contacto}: ${contacto} ${extension == null ? '' : 'ext:' +extension}<br></tr></td>`; });
    else card_persona += '<tr><td><span class="tx-italic" style="color: #a9a9a9">Sin teléfonos registrados</span></tr></td>';

    card_persona += '</tbody></table></div><div class="col-md-4"><br><table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody><tr><td class="tx-center" style="background-color: #848F33; color: #FFF;">Correos</td>';
    
    const correos = persona.contacto.filter( contacto => contacto.tipo_contacto == 'correo electronico' );

    if( correos.length > 0 ) $( correos ).each(function( ic, contaco) { card_persona += '<tr><td>'+contaco.contacto+'</tr></td>'; });
    else card_persona += '<tr><td><span class="tx-italic" style="color: #a9a9a9">Sin correos registrados</span></tr></td>';

    card_persona += '</tbody></table></div><div class="col-md-4"><br><table  class="datatable tableDatosSujeto2 tx-uppercase" style="overflow-x: none; display: table; color: #000;"><tbody><tr><td style="background-color: #848F33; color: #FFF;" class="tx-center">Alias</td></tr>';
    
    if( persona.alias.length > 0 ) $( persona.alias ).each(function( ia, alias ){ card_persona += '<tr><td>'+alias.alias+'</td></tr>'; });
    else card_persona += '<tr><td><span class="tx-italic" style="color: #a9a9a9">Sin alias registrados</span></td></tr>';
    
    card_persona += '</tbody></table></div></div>';
    card_persona += '</div></div></div></div>';
    datos_personas += card_persona;

  });

  // $('#tabPersonas').html(datos_personas);
    
  if( data_solicitud.solicitud.delitos_sin_relacionar.length > 0) {

    let delitos_sin = '<table class="datatable tableDelitosSujeto text-uppercase" style="overflow-x: none; display: table; color: #000"><tbody class="table-datos-sujeto"><tr><td style="background-color: #848F33; color: #FFF;" class="tx-center" colspan="4">Datos de los delitos no relacionados</td></tr></tr><tr><th class="tx-center">Delito</th><th class="tx-center">Modalidad</th><th class="tx-center">Calificativo</th><th class="tx-center">Grado de realización</th></tr>';

    $( data_solicitud.solicitud.delitos_sin_relacionar ).each( function( id, delito ) {
      delitos_sin += `<tr><td>${delito.delito}</td><td>${delito.nombre_modalidad}</td><td>${delito.calificativo == null ? "" : delito.calificativo}</td><td>${delito.grado_realizacion.replace('_', ' ')}</td><tr>`;
    });

    delitos_sin += '</tbody></table>';

    $('#tabDelitosNoRelacionados').html(delitos_sin);
    $('#navDelitosNoRelacionados').removeClass('d-none');
  }else {
    $('#navDelitosNoRelacionados').addClass('d-none');
  }

  if( data_solicitud.solicitud.id_acuerdo_resolucion != null ) {
    
    const data_acuerdo = await new Acuerdo( data_solicitud.solicitud.id_acuerdo_resolucion ),
      documento = await data_acuerdo.obtenerDocumentoAcuerdo();

  } else {

    const data_audiencia = await new Audiencia( data_solicitud.solicitud.id_audiencia_resolucion );

  }

  $('#divTarea').html(`
      <div id="validacionDatos">
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
              <li class="nav-item">
                <a class="nav-link" href="#divResolucion" data-toggle="tab">Resolución</a>
              </li>
            </ul>
          </div><!-- card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="divSolicitud">
                ${tableSolicitud}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDatosSujeto">
                ${datos_personas}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divDocumentos">
                ${lDocs}
              </div><!-- tab-pane -->
              <div class="tab-pane" id="divResolucion">
              ${dResolucion}
            </div><!-- tab-pane -->
            </div><!-- tab-content -->
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
    `);
  
}

// function reubicarReloj( elemento ) {
$('#modalDatosTarea').on('scroll', function() {
  
  const scroll = $(this).scrollTop(),
    top_propover = $('.popover').attr('top'),
    scroll_window = $(window).scrollTop(),
    nuevo_top = top_propover-scroll+scroll_window;
  
  $('.popover').css({top: ( nuevo_top )})
  
});
// }

// const doc_loadind = `    
//     <div class="sk-circle">
//       <div class="sk-circle1 sk-child"></div>
//       <div class="sk-circle2 sk-child"></div>
//       <div class="sk-circle3 sk-child"></div>
//       <div class="sk-circle4 sk-child"></div>
//       <div class="sk-circle5 sk-child"></div>
//       <div class="sk-circle6 sk-child"></div>
//       <div class="sk-circle7 sk-child"></div>
//       <div class="sk-circle8 sk-child"></div>
//       <div class="sk-circle9 sk-child"></div>
//       <div class="sk-circle10 sk-child"></div>
//       <div class="sk-circle11 sk-child"></div>
//       <div class="sk-circle12 sk-child"></div>
//     </div>
  
// `;