class Carpeta {
  
  constructor( id_carpeta , carpeta = false ) {
    return ( async () => {
      
      if( carpeta == false ) {

        const datos_carpeta = await this.obtenerDatosCarpeta(id_carpeta);

        if( datos_carpeta.status == 100 )
          this.carpeta =  datos_carpeta.response[0];

      } else {
        this.carpeta = carpeta;
      }

      this.id_carpeta = id_carpeta;
      return this;

    })();
  }
  
  tipoCarpeta() {

    const { folio_carpeta } = this.carpeta;
    let tipo_carpeta;

    if ( folio_carpeta.substring(0, 4) == 'EJEC' ) tipo_carpeta = 'EJEC';
    else if ( folio_carpeta.substring(folio_carpeta.length, -2) == 'LN' ) tipo_carpeta = 'LN';
    else if ( folio_carpeta.substring(0, 2) == 'TE' ) tipo_carpeta = 'TE';
    else if( folio_carpeta.substring(0, 6) == 'UGJEMS') tipo_carpeta = 'UGJEMS';
    else tipo_carpeta = 'Control';

    return tipo_carpeta;

  }

  obtenerPersonas( imputados_activos = 'si' ) {
    return new Promise( resolve => {
      $.ajax({
        method: 'POST',
        url: '/public/obtener_personas_carpeta',
        data:{ carpeta: this.id_carpeta, imputados_activos },
        success: function(response){ resolve(response); }
      });
    });
  }

  filtrarPersonasCalJud( personas, id_calidad_juridica ) {
    personas = personas.filter( persona => id_calidad_juridica.includes( persona.info_principal.id_calidad_juridica) );
    return personas;
  }

  validarHistorialRemision() {
    return new Promise( resolve => {
      $.ajax({
        method: 'GET',
        url: '/public/valida_historial_carpeta_remision',
        data:{ carpeta: this.id_carpeta },
        success: function(response){ resolve(response); }
      });
    });
  }

  obtenerDatosCarpeta( carpeta_judicial ) {
    return new Promise( resolve => {
      $.ajax({
        method: 'POST',
        url: '/public/obtener_carpetas_judiciales',
        data:{ carpeta_judicial, modo: 'completo' },
        success: function(response){ 
          resolve(response); 
        }
      });
    });
  }

  obtenerDocumentosCarpeta( ) {
    return new Promise( resolve => {
      $.ajax({
        method: 'POST',
        url: '/public/obtener_documentos_carpeta',
        data:{ carpeta_judicial : this.id_carpeta },
        success: function(response){ resolve(response); }
      });
    });
  }
}
