class Remision {

  constructor( id_remision, remision = false ) {

    return ( async () => {
       this.id_remision = id_remision;

      if( remision == false ) {
        const datos_remision = await this.obtenerDatosRemision( id_remision );
        if( datos_remision.status == 100 ) 
          this.remision = datos_remision.response[0];
      }else {
        this.remision = remision;
      }
      
      return this;
    })();

  }

  obtenerDatosRemision( remision ) {
    return new Promise( resolve => {
      $.ajax({
        method: 'POST',
        url: '/public/obtener_datos_remision',
        data: { remision },
        success: function(response){ resolve(response);}
      });
    })
  }

  obtenerPersonas() {
    return new Promise( resolve => {
      $.ajax({
        method: 'GET',
        url: '/public/obtener_personas_remision',
        data: { remision: this.id_remision },
        success: function(response){ resolve(response);}
      });
    });
  }

  obtenerDocumentosRemision( version = '' ) {
    return new Promise( resolve => {
      $.ajax({
        method: 'POST',
        url: '/public/obtener_documentos_remision',
        data: { remision: this.id_remision, version },
        success: function(response){ resolve(response);}
      });
    });
  }

  obtenerSeccionesRemusionEjecucion() {
    return new Promise( resolve => {
      $.ajax({
        method: 'GET',
        url:'/public/obtener_personas_remision',
        data: { remision: this.id_remision },
        success: function(response){ resolve(response);}
      });
    });
  }

  consultaDatosRemisionEjecucion = async () => {

    const [ secciones, documentosRemision ] = await Promise.all([ this.obtenerSeccionesRemusionEjecucion(), this.obtenerDocumentosRemision()])
 
    const urlDocs = await ( () => {
      
      return new Promise( resolve => {

        if( documentosRemision.status == 100 ) {
          
          let documentos = []
          if( documentosRemision.response.length ) {
            
            $( documentosRemision.response ).each( async (index, documento ) => {
              
              const urlDocumento = await this.obtenerDocumentosRemision( documento.id_documento )
              
              if( urlDocumento.status == 100 ) {
                documento = {
                  ...documento,
                  url:urlDocumento.response
                }
              }

              documentos = [ 
                ...documentos, 
                documento
              ]

              if( ( index + 1 ) == documentosRemision.response.length )
                resolve(documentos)

            })

          } else {
            resolve (documentos)
          }
        } else {
          resolve ([])
        }
      })
    })()

    const vistaPrevia = vistaDatosRemisionEjecucion( this.remision, secciones, urlDocs )

    return vistaPrevia;
  }
}