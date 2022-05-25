class Solicitud{

  constructor( id_solicitud, tipo_solicitud = '-', solicitud = false ) {
    return ( async () => {
      this.id_solicitud = id_solicitud;
     if( solicitud == false ) {
       const datos_solicitud = await this.obtenerDatosSolicitud( id_solicitud, 'completo', tipo_solicitud );
       if( datos_solicitud.status == 100 ) 
         this.solicitud = datos_solicitud.response[0];
     }else {
       this.solicitud = solicitud;
     }
     
     return this;
   })();
  }

  obtenerDatosSolicitud( id_solicitud, modo, tipo_solicitud ) {
    return new Promise( resolve => {
      $.ajax({
        method: 'GET',
        url: '/public/obtener_solicitudes',
        data: { id_solicitud, modo, tipo_solicitud },
        success: function( response ){
          resolve( response );
        }
      });
    });
  }

  obtenerDocumentosSolicitud( version = '' ) {
  
    return new Promise(resolve => {  
        $.ajax({
          method:'POST',
          url:'/public/obtener_documentos_solicitud',
          data:{ solicitud : this.id_solicitud, version },
          success:function(response) { resolve(response); }
        });
    });
  }
}