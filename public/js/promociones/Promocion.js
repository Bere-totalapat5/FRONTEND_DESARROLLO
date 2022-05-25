class Promocion{

  constructor( id_promocion, promocion = false ) {
    return ( async () => {
      this.id_promocion = id_promocion;
     if( promocion == false ) {
       const datos_promocion = await this.obtenerDatosPromocion( id_promocion, 'completo' );
       if( datos_promocion.status == 100 ) 
         this.promocion = datos_promocion.response[0];
     }else {
       this.promocion = promocion;
     }
     
     return this;
   })();
  }

  obtenerDatosPromocion( id_promocion, modo ) {
    return new Promise( resolve => {
      $.ajax({
        method: 'GET',
        url: '/public/obtener_promociones',
        data: { promocion: id_promocion, modo },
        success: function( response ){
          resolve( response );
        }
      });
    });
  }

  obtenerDocumentosPromocion( version = '' ) {
  
    return new Promise(resolve => {  
        $.ajax({
          method:'POST',
          url:'/public/obtener_documentos_promocion',
          data:{ promocion : this.id_promocion, version },
          success:function(response) { resolve(response); }
        });
    });
  }
}