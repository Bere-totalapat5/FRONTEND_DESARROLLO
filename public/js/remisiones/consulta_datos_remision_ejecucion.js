const vistaDatosRemisionEjecucion = async ( remision, secciones, documentos ) => {
    
    let vista = ''
  
    const {folio, tipo_remision, fecha_registro, materia_destino, fecha_recepcion, carpeta_judicial, carpeta_investigacion, folio_carpeta_rem, EJEC_fecha_audiencia, EJEC_nom_juez_sentencia, EJEC_fecha_ejecutoria, comentarios, id_carpeta_judicial, id_remision} = remision;
  
    const NA = "<span style='font-style: italic; color: #b1afaf'>na</span>"
  
    const datosRemision = [
      [ 'Folio', folio ?? NA ],
      [ 'Fecha de Registro:', formateaFecha(fecha_registro) ?? NA],
      [ 'Carpeta de ejecución asignada', folio_carpeta_rem ?? NA],
      [ 'Fecha de Recepción:', formateaFecha(fecha_recepcion) ?? NA],
      [ 'Carpeta Judicial ', carpeta_judicial ?? NA ],
      [ 'Carpeta de investigación', carpeta_investigacion ?? NA ],
      [ 'Fecha de fecha de la audiencia en la cual se dicta sentencia', formateaFecha(EJEC_fecha_audiencia) ?? NA],
      [ 'Juez que dictó sentencia', EJEC_nom_juez_sentencia ?? NA],
      [ 'Fecha a partir de la cual causa ejecutoria', formateaFecha(EJEC_fecha_ejecutoria) ?? NA],
      [ 'Comentarios', comentarios ?? NA],
      [ 'Materia Destino:', materia_destino == null ? NA : materia_destino.replace("_"," ") ],
      [ 'Motivo de la Remisión:', tipo_remision == null ? NA : tipo_remision.replace("_"," ") ],
    ];

    const tiposRemision = {
      unidad_ejecucion: 'Unidad de ejecución'
    }
    
    let sentenciados = ''
    let complementaria = ''
    
    if( secciones.status == 100 ) {
      
      if( Object.keys(secciones.response.sentenciados).length ) {

        sentenciados += await ( () => {
    
          return new Promise( resolve => {
            
            let acordeonesSentenciados = ''
      
            $(secciones.response.sentenciados).each( async ( index , sentenciado) => {
              
              let datosSentenciado = ''
  
              const { tipo_remision, en_libertad, suspension_condicional, monto_garantia, tipo_persona, nombre, apellido_paterno, apellido_materno, genero, razon_social, calidad_juridica, nombre_reclusorio, penas} = sentenciado
          
              const infoSentenciado = [
                ["Tipo de remisión:", tiposRemision[tipo_remision] ?? NA], 
                ["Se encuentra en libertad:",en_libertad ?? NA], 
                ["Se concede suspención condicional:",suspension_condicional ?? NA], 
                ["Monto de la garantía:",monto_garantia ?? NA], 
                ["Tipo de persona:",( tipo_persona == 'fisica' ? 'Física' : tipo_persona ) ?? NA], 
                ["Nombre:",nombre ?? NA], 
                ["Apellido paterno:",apellido_paterno ?? NA], 
                ["Apellido materno:",apellido_materno ?? NA], 
                ["Género:",genero ?? NA], 
                ["Razón social:",razon_social ?? NA], 
                ["Calidad jurídica:",calidad_juridica ?? NA], 
                ["Reclusorio de internamiento:",nombre_reclusorio ?? NA]
              ]
          
              const tablaDatosSentenciado = generaTabla( infoSentenciado, "Datos del sentenciado");
              datosSentenciado += tablaDatosSentenciado
    
              if( penas.length ) {
                const tablaDatosPenas = await generaDatosPena(penas)
                datosSentenciado += '<br>' + tablaDatosPenas
              }
              
              acordeonesSentenciados += creaAcordeon( datosSentenciado, (razon_social ?? '')+(nombre ?? '')+' '+(apellido_paterno ?? '')+' '+(apellido_materno ?? ''))
  
              if( (index +1 ) == secciones.response.sentenciados.length )
                resolve (acordeonesSentenciados)
  
            })
      
          })
        })()
  
      } else {

        sentenciados += '<h1>Sin datos de sentenciados</h1>'

      }

      if( Object.keys(secciones.response.informacion_complementaria).length ) {

        const { numero_dvds, ids_audiencias_remitidas, billetes, objetos } = secciones.response.informacion_complementaria[0]

        let datosComplementaria = [
          [ "Número de DVD's de audiencias a remitir", numero_dvds],
        ]

        const arrAudiencias = ids_audiencias_remitidas.split(",");
        const audienciasCarpeta = await consumirServicio('/public/obtener_fechas_aud_sent', 'POST', {carpeta_judicial: id_carpeta_judicial})
        
        if( arrAudiencias.length ) {

          let lista = '<ul style="margin-bottom: 0; padding-left: 0;">'

          $( arrAudiencias ).each( (index, audiencia  ) => {
            
            const datosAudiencia = audienciasCarpeta.response.find( audienciaCarpeta => audienciaCarpeta.id_audiencia == audiencia )
            const { fecha_audiencia, hora_inicio_audiencia, juez } = datosAudiencia
            const { nombre_usuario, cve_juez } = juez
            
            lista += `
              <li  style="list-style-type: none;border-left: 3px solid #848F33;padding: 3px; margin-top: 4px;">
                ${formateaFecha(fecha_audiencia)} ${hora_inicio_audiencia} Hrs <br>
                ${nombre_usuario} (${cve_juez})
              </li>`
  
          })
  
          lista += '</ul>'
  
          datosComplementaria = [
            ...datosComplementaria,
            [ "Audiencias:", lista ]
          ]

        }

        if( billetes.length ) {

          let lista = '<ul style="margin-bottom: 0; padding-left: 0;">'

          $( billetes ).each( ( index, billete ) => {
            
            const { numero_billete, monto } = billete
            
            lista += `
              <li  style="list-style-type: none;border-left: 3px solid #848F33;padding: 3px; margin-top: 4px;">
                Número de billete: ${numero_billete}<br>
                Monto: ${formatearCantidad(monto)}
              </li>`
          })
  
          lista += '</ul>'
  
          datosComplementaria = [
            ...datosComplementaria,
            [ "Billetes:", lista ]
          ]
          
        }

        if( objetos.length ) {
          console.log(objetos)
          let lista = '<ul style="margin-bottom: 0; padding-left: 0;">'

          $( objetos ).each( ( index, objeto ) => {
            
            const { objeto_descripcion, objeto_ubicacion } = objeto
            
            lista += `
              <li  style="list-style-type: none;border-left: 3px solid #848F33;padding: 3px; margin-top: 4px;">
                <span>Descripción:</span> ${objeto_descripcion} <br>
                <span>Ubicación:</span> ${objeto_ubicacion}
              </li>`
          })
  
          lista += '</ul>'
  
          datosComplementaria = [
            ...datosComplementaria,
            [ "Objetos:", lista ]
          ]

        }

        const tablaComplementaria = generaTabla( datosComplementaria, "Información complementaria")

        complementaria += tablaComplementaria

      } else {

        complementaria += '<h1 class="tx-danger">Sin información complementaria</h1>'

      }

    } else {
      sentenciados += '<h1 class="tx-danger">Sin datos de sentenciados</h1>'
    }

    const divsDocumentos = await ( () => {

      return new Promise( resolve => {

        let enlacesDocumentos = ''
        let objectDocumento = ''

        if( documentos.length ) {
          $(documentos).each( (index, documento ) => {

            switch ( documento.extension_archivo ){
              case 'pdf':
                var icono = '<i class="fa fa-file-pdf-o mg-r-10" aria-hidden="true" style="font-size:20px;"></i>';
                break;
              case 'jpg':
              case 'png':
              case 'JPEG ':
                icono = '<i class="fa fa-file-image-o mg-r-10" aria-hidden="true" style="font-size:20px;"></i>';
                break;
              default:
                icono = '<i class="fa fa-question mg-r-10" aria-hidden="true" style="font-size:20px;"></i>';
            }
      
      
            enlacesDocumentos +=`<a href="javascript:void(0)" onclick="verDocRemi(${index}, this)" class="${index == 0 ? 'bgDocRem' : ''}"><div style="border: 1px solid #ced4da; margin-bottom: 10px; padding: 10px; display: block;" class="doc_remi"><i class="fa fa-file-pdf-o mg-r-10" aria-hidden="true" style="font-size:20px;"></i> ${documento.nombre_archivo.replace(id_remision+'_', '').replace('.pdf','')}.pdf</div></a>`;
      
            objectDocumento +=`<object data="${documento.url}" class="documento_remision ${index == 0 ? '' : 'd-none'}"  id="documentoPDF${index}" width="100%" height="455px" name="${documento.nombre_archivo}.${documento.extension_archivo}"></object>`;
      
            if( ( index + 1 ) == documentos.length )
              resolve({ enlacesDocumentos, objectDocumento })
      
          });
        } else {
          resolve ( { enlacesDocumentos, objectDocumento } )
        }
      })
    })()

    const listaDocumentos = `
      <div class="row">
        <div class="col-md-3">${divsDocumentos.enlacesDocumentos}</div>
        <div class="col-md-9 ">${divsDocumentos.objectDocumento}</div>
      </div>
    `;

    
    vista += `
      <div class="card" style="min-height: 481px;">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active" href="#divDatosRemision" data-toggle="tab">Datos de la remisión</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#divDatosImputado" data-toggle="tab">Sentenciados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#divComplementaria" data-toggle="tab">Información complementaria</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#divDocumentos" data-toggle="tab">Documentos</a>
            </li>            
          </ul>
        </div><!-- card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane active" id="divDatosRemision">
              ${generaTabla( datosRemision ,"Datos principales de la remision")}
            </div><!-- tab-pane -->
            <div class="tab-pane" id="divDatosImputado">
              ${sentenciados}
            </div><!-- tab-pane -->
            <div class="tab-pane" id="divComplementaria">
              ${complementaria}
            </div><!-- tab-pane -->
            <div class="tab-pane" id="divDocumentos">
              ${listaDocumentos}
            </div><!-- tab-pane -->
          </div><!-- tab-content -->
        </div><!-- card-body -->
      </div><!-- card -->
    `
  
    return vista
}

const generaDatosPena = penas => {

  return new Promise( resolve => {
    
    let tablasPenas = ''
    const NA = "<span style='font-style: italic; color: #b1afaf'>na</span>"
    const tiposSustitutivos = {
      1: "Multa en beneficio de la víctima",
      2: "Multa en favor de la comunidad",
      3: "Trabajo en beneficio de la víctima",
      4: "Trabajo en favor de la comunidad",
      5: "Tratamiento en libertad",
      6: "Tratamiento en semilibertad",
    }

    $(penas).each( async ( index, pena ) => {
      
      const { id_tipo_pena, id_pena_impuesta, id_sub_pena_impuesta, id_centro_detencion, periodo_anios, periodo_meses, periodo_dias, monto_garantia, decomiso_instrumento, decomiso_objetos, decomiso_productos_delito, sustitutivo_pena, ids_delitos, detalles_adicionales, suspension_condicional, delitos, abonos, sustitutivos } = pena
      
      const tipoPena = catalogoPenas.find( penaCatalogo => penaCatalogo.id_tipo_pena == id_tipo_pena )

      const [ arrPenaImpuesta, arrDetallesPena ] = await Promise.all([
        consumirServicio('/public/obtener_penas', 'POST', { tipo_pena: id_tipo_pena }),
        consumirServicio('/public/obtener_detalle_pena', 'POST', {pena_impuesta:id_pena_impuesta})
      ])
      
      const penaImpuestaVal = arrPenaImpuesta.response.find( ePenaImpuesta => ePenaImpuesta.codigo == id_pena_impuesta)
      
      if( id_sub_pena_impuesta ) {
        var detallePenaImpuesta = arrDetallesPena.message.find( eDetallesPena => eDetallesPena.id_pena_opcion == id_sub_pena_impuesta)
      } else {
        var detallePenaImpuesta = { descripcion : NA}
      }

      let infoPena = [
        [ "Tipo de pena:", tipoPena.descripcion ?? NA],
        [ "Pena impuesta:", penaImpuestaVal.pena ?? NA],
        [ "Detalle de la pena:", detallePenaImpuesta.descripcion ],
        [ "Sustitutivo de la pena:", sustitutivo_pena ?? NA ],
        [ "Detalles adicionales:", detalles_adicionales ?? NA],
        [ "Suspensión condicional:", (suspension_condicional == 1 ? 'Si' : 'No') ?? NA],
        [ "Decomiso de instrumentos:", (decomiso_instrumento == 1 ? 'Si' : 'No') ?? NA],
        [ "Decomiso de objetos:", (decomiso_objetos == 1 ? 'Si' : 'No') ?? NA],
        [ "Decomiso de productos del delito:", (decomiso_productos_delito == 1 ? 'Si' : 'No') ?? NA]
      ]

      if( delitos.length ) {

        let lista = '<ul style="margin-bottom: 0; padding-left: 0;">'

        $(delitos).each( ( index, delito ) => {
          lista += `<li  style="list-style-type: none;border-left: 3px solid #848F33;padding: 3px; margin-top: 4px;">${delito.delito} </li>`
        })

        lista += '</ul>'

        infoPena = [
          ...infoPena,
          [ "Delitos:", lista ]
        ]

      }

      if( abonos.length ) {

        let lista = '<ul style="margin-bottom: 0; padding-left: 0;">'

        $(abonos).each( ( index, abono ) => {

          const { id_centro_detencion, periodo_anios, periodo_meses, periodo_dias } = abono
          const reclusorio = reclusorios.find( reclusorio => reclusorio.id_reclusorio == id_centro_detencion )

          lista += `
            <li  style="list-style-type: none;border-left: 3px solid #848F33;padding: 3px; margin-top: 4px;">
              ${reclusorio.nombre}
              </br>
              ${periodo_anios} ${periodo_anios != 1 ? 'Años' : 'Año'}, 
              ${periodo_meses} ${periodo_meses != 1 ? 'Meses' : 'Mes'}, 
              ${periodo_dias} ${periodo_dias != 1 ? 'Días' : 'Día'}
            </li>`
        })

        lista += '</ul>'

        infoPena = [
          ...infoPena,
          [ "Abonos:", lista ]
        ]
      }

      if( sustitutivos.length ) {

        let lista = '<ul style="margin-bottom: 0; padding-left: 0;">'

        $( sustitutivos ).each( ( index, sustitutivo ) => {

          const { id_sustitutivo, acoge_sustitutivo, monto } = sustitutivo

          lista += `<li  style="list-style-type: none;border-left: 3px solid #848F33;padding: 4px; margin-top: 4px;">${tiposSustitutivos[id_sustitutivo]}  <br> Acoge sustitutivo: ${ acoge_sustitutivo } <br> Cantidad: ${ formatearCantidad(monto)} <br> ( ${sustitutivo.detalles} )</li>`
        })

        lista += '</ul>'

        infoPena = [
          ...infoPena,
          [ "sustitutivos:", lista ]
        ]
      }
      
      const datosPena = generaTabla( infoPena, "Datos de la pena #" + ( index + 1 ))
      tablasPenas += datosPena
      
      if( (index + 1) == penas.length ) 
        resolve (tablasPenas)
    })

  })
}