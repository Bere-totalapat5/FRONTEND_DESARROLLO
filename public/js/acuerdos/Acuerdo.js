class Acuerdo {

  constructor( id_acuerdo, acuerdo = false ){
    return( async () => {

      this.id_acuerdo = id_acuerdo;

      if( acuerdo == false ) {
        const datos_acuerdo = await this.obtenerDatosAcuerdo( id_acuerdo );

        if( datos_acuerdo.status == 100 ) 
          this.acuerdo = datos_acuerdo.response[0];
      } else {
        this.acuerdo = acuerdo;
      }

      return this;
    })();
  }

  obtenerDatosAcuerdo( id_acuerdo = '' ) {
    return new Promise( resolve => {
      $.ajax({
        method: 'GET',
        url: '/public/obtener_acuerdos',
        data: { id_acuerdo },
        success: function( response ){ resolve( response ); },
      });
    });
  }

  obtenerDocumentoAcuerdo() {
    return new Promise( resolve => {
      $.ajax({
        method: 'POST',
        url: '/public/obtener_ultima_version_acuerdo',
        data: { acuerdo : this.id_acuerdo },
        success: function( response ){ resolve( response ); },
      });
    });
  }
}