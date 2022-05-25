class Audiencia {

  constructor ( id_audiencia, audiencia = false ) {
    return( async ( ) => {
      this.id_audiencia = id_audiencia;

      if( audiencia == false ) {
        const datos_audiencia = await this.obtenerDatosAudiencia( id_audiencia, 'completo' );

        if( datos_audiencia.status == 100 ) 
          this.audiencia = datos_audiencia.response[0];
      } else {
        this.audiencia = audiencia;
      }

      return this;
    })();
  }

  obtenerDatosAudiencia( id_audiencia , modo ) {
    console.log(id_audiencia);
    return new Promise( resolve => {
      $.ajax({
        method: 'GET',
        url: '/public/consultar_audiencias',
        data: { id_audiencia },
        success: function ( response ) { resolve( response ); },
      });
    });
  }
}