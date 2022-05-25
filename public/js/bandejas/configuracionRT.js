class ConfiguracionRT {
  
  constructor( tipo_origen_bandeja, tipo_bandeja, tipo_solicitud = '', tipo_resolucion_solicitud = '' ) {

    this.tipo_origen_bandeja = tipo_origen_bandeja;
    this.tipo_bandeja = tipo_bandeja;
    this.tipo_solicitud = tipo_solicitud;
    this.tipo_resolucion_solicitud = tipo_resolucion_solicitud;
    this.tipo_usuario = tUsuario;
    this.tipo_usuario_sustitucion = tUsuarioSustitucion;

    if( unidades_ejecucion.includes( String(unidadGestion) ) ) 
      this.tipo_unidad = "ejecucion";
    else 
      this.tipo_unidad = "control";

  }

  configuracion() {

    var tipos_resolucion = [];
    var resolucion_permiso = {};

    if( this.tipo_origen_bandeja == "remisiones" ) {

      if( this.tipo_unidad == "ejecucion" ) {

        if( this.tipo_bandeja ==  "REJEC" ) {

          if( this.vatu([2,25]) ) {  //Director de Unidad de Gestion Judicial, Dirección de la Unidad de Gestión Especializada en Ejecución de Sanciones Penales

            tipos_resolucion = this.tiposResolucion( 'todos' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: false
            };

          } else if ( this.vatu([3]) ) { //Subdirector de Causa y Ejecuciones,

            tipos_resolucion = this.tiposResolucion( 'todos' , 'acuerdo' ); 

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          } else if ( this.vatu([31]) ) {  //Subdirección de Sala,

            tipos_resolucion = this.tiposResolucion( 'todos' , 'audiencia' ); 

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: true
            };

          } else { //Resto de usuarios

            tipos_resolucion = this.tiposResolucion( 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          }

        } else if ( this.tipo_bandeja == 'RREMA') {

          if( this.vatu([2,25]) )
            resolucion_permiso = { autorizacion_remision : true};
          else
            resolucion_permiso = { autorizacion_remision : false};

        }

      } else if ( this.tipo_unidad == "control") {
        
        if ( this.tipo_bandeja == 'RREMA') {

          if( this.vatu([2,25]) )
            resolucion_permiso = { autorizacion_remision : true};
          else
            resolucion_permiso = { autorizacion_remision : false};

        }

      }
    } else if( this.tipo_origen_bandeja == "solicitudes" ) {
      
      if( this.tipo_unidad == "ejecucion" ) {

        if( ['RS'].includes(this.tipo_bandeja) ) { //Resolución de solicitud

          if( this.vatu([2,25]) ) { //Director de Unidad de Gestion Judicial, Dirección de la Unidad de Gestión Especializada en Ejecución de Sanciones Penales

            tipos_resolucion = this.tiposResolucion( 'todos' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          } else if( this.vatu([3]) ) { //Subdirector de Causa y Ejecuciones,
            
            tipos_resolucion = this.tiposResolucion( 'todos' , 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          } else if( this.vatu([31]) ) { //Subdirección de Sala,
            
            tipos_resolucion = this.tiposResolucion( 'todos' , 'audiencia' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: true
            };

          } else {

            tipos_resolucion = this.tiposResolucion( 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          }
        } else if( this.tipo_bandeja ==  "REJEC" ) {
    
          if( this.vatu([2,25]) ) {  //Director de Unidad de Gestion Judicial, Dirección de la Unidad de Gestión Especializada en Ejecución de Sanciones Penales

            tipos_resolucion = this.tiposResolucion( 'todos' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: false
            };

          } else if ( this.vatu([3]) ) { //Subdirector de Causa y Ejecuciones,

            tipos_resolucion = this.tiposResolucion( 'todos' , 'acuerdo' ); 

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          } else if ( this.vatu([31]) ) {  //Subdirección de Sala,

            tipos_resolucion = this.tiposResolucion( 'todos' , 'audiencia' ); 

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: true
            };

          } else { //Resto de usuarios

            tipos_resolucion = this.tiposResolucion( 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          }
  
        }

      } else if ( this.tipo_unidad == "control" ) {

        if( ['RS', 'RE'].includes(this.tipo_bandeja) && this.tipo_resolucion_solicitud == null ) { //Resolución de solicitudes, Resolución de exhortos

          if( this.vatu([25]) ) {  //Director de Unidad de Gestion Judicial, Dirección de la Unidad de Gestión Especializada en Ejecución de Sanciones Penales
            
            tipos_resolucion = this.tiposResolucion( 'todos' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: false
            };

          }else if( this.vatu([2,3]) ) {  //Subdirector de Causa y Ejecuciones
            
            tipos_resolucion = this.tiposResolucion( 'todos', 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };
          
          }else if( this.vatu([31]) ) { //Subdirección de Sala,
           
            tipos_resolucion = this.tiposResolucion( 'todos', 'audiencia' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: true
            };

          }else {

            tipos_resolucion = this.tiposResolucion( 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };
          }

        } else if ( ['CACU'].includes(this.tipo_bandeja) ) { // Creación de acuerdo

          tipos_resolucion = this.tiposResolucion( 'acuerdo' );

          resolucion_permiso = { 
            acuerdo: true,
            audiencia: false
          };

        } else if ( ['CAUD'].includes(this.tipo_bandeja) ) { //Creación de audiencia

          tipos_resolucion = this.tiposResolucion( 'audiencia' );

          resolucion_permiso = { 
            acuerdo: false,
            audiencia: true
          };

        } else if( this.tipo_resolucion_solicitud != null ){ //Tipo de resolución que trae el registro

          tipos_resolucion = this.tiposResolucion( this.tipo_resolucion_solicitud );

          resolucion_permiso = { 
            acuerdo: this.tipo_resolucion_solicitud == 'acuerdo' ? true : false,
            audiencia: this.tipo_resolucion_solicitud == 'audiencia' ? true : false,
          };

        }
        
      }
      

    } else if( this.tipo_origen_bandeja == 'promociones' ) {

      if( this.tipo_unidad == "ejecucion" ) {

        if( ['RS'].includes(this.tipo_bandeja) ) { //Resolución de solicitud

          if( this.vatu([2,25]) ) { //Director de Unidad de Gestion Judicial, Dirección de la Unidad de Gestión Especializada en Ejecución de Sanciones Penales

            tipos_resolucion = this.tiposResolucion( 'todos' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          } else if( this.vatu([3, 26]) ) { //Subdirector de Causa y Ejecuciones,
            
            tipos_resolucion = this.tiposResolucion( 'todos' , 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          } else if( this.vatu([31]) ) { //Subdirección de Sala,
            
            tipos_resolucion = this.tiposResolucion( 'todos' , 'audiencia' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: true
            };

          } else {

            tipos_resolucion = this.tiposResolucion( 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };

          }
        } else if( ['RP'].includes(this.tipo_bandeja) && this.tipo_resolucion_solicitud == null ) { //Resolución de solicitudes, Resolución de exhortos

          if( this.vatu([2,25]) ) {  //Director de Unidad de Gestion Judicial, Dirección de la Unidad de Gestión Especializada en Ejecución de Sanciones Penales
            
            tipos_resolucion = this.tiposResolucion( 'todos' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: false
            };

          }else if( this.vatu([3, 26]) ) {  //Subdirector de Causa y Ejecuciones
            
            tipos_resolucion = this.tiposResolucion( 'todos', 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };
          
          }else if( this.vatu([31]) ) { //Subdirección de Sala,
           
            tipos_resolucion = this.tiposResolucion( 'todos', 'audiencia' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: true
            };

          }else {

            tipos_resolucion = this.tiposResolucion( 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };
          }

        } else {

          tipos_resolucion = this.tiposResolucion( this.tipo_resolucion_solicitud );

          resolucion_permiso = { 
            acuerdo: true,
            audiencia: true
          };

        }

      } else if ( this.tipo_unidad == "control" ) {

        if( ['RP'].includes(this.tipo_bandeja) && this.tipo_resolucion_solicitud == null ) { //Resolución de solicitudes, Resolución de exhortos

          if( this.vatu([2,25]) ) {  //Director de Unidad de Gestion Judicial, Dirección de la Unidad de Gestión Especializada en Ejecución de Sanciones Penales
            
            tipos_resolucion = this.tiposResolucion( 'todos' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: false
            };

          }else if( this.vatu([3]) ) {  //Subdirector de Causa y Ejecuciones
            
            tipos_resolucion = this.tiposResolucion( 'todos', 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };
          
          }else if( this.vatu([31]) ) { //Subdirección de Sala,
           
            tipos_resolucion = this.tiposResolucion( 'todos', 'audiencia' );

            resolucion_permiso = { 
              acuerdo: false,
              audiencia: true
            };

          }else {

            tipos_resolucion = this.tiposResolucion( 'acuerdo' );

            resolucion_permiso = { 
              acuerdo: true,
              audiencia: false
            };
          }

        } else if ( ['CACU'].includes(this.tipo_bandeja) ) { // Creación de acuerdo

          tipos_resolucion = this.tiposResolucion( 'acuerdo' );

          resolucion_permiso = { 
            acuerdo: true,
            audiencia: false
          };

        } else if ( ['CAUD'].includes(this.tipo_bandeja) ) { //Creación de audiencia

          tipos_resolucion = this.tiposResolucion( 'audiencia' );

          resolucion_permiso = { 
            acuerdo: false,
            audiencia: true
          };

        } else if( this.tipo_resolucion_solicitud != null ){ //Tipo de resolución que trae el registro

          tipos_resolucion = this.tiposResolucion( this.tipo_resolucion_solicitud );

          resolucion_permiso = { 
            acuerdo: this.tipo_resolucion_solicitud == 'acuerdo' ? true : false,
            audiencia: this.tipo_resolucion_solicitud == 'audiencia' ? true : false,
          };

        }
        
      }
    } else if( this.tipo_origen_bandeja == 'acuerdos' ) {

      tipos_resolucion = this.tiposResolucion( 'acuerdo' );

      resolucion_permiso = {
        acuerdo: true,
        audiencia: false
      }

    }

    let select_tipo_resolucion = '';
    
    $.each( tipos_resolucion , function( i, tipo_resolucion ) {
      const { label, value, selected, disabled } = tipo_resolucion;
      select_tipo_resolucion += `<option value="${value}" ${disabled == true ? 'disabled' : ''} ${selected == true ? 'selected' : ''}>${label}</option>`; 
    })

    const configuracion = {
      select_tipo_resolucion,
      resolucion_permiso
    }

    return  configuracion ;

  };

  tiposResolucion( tipo, s_selected = '', disabled = [] ) {

    switch ( tipo ) {

      case 'todos':
        var opciones = [
          {
            label: "Seleccione una opción",
            value: "",
            selected: s_selected == '' ? true : false,
            disabled: true
          },
          {
            label: "Acuerdo",
            value: "acuerdo",
            selected: s_selected == 'acuerdo' ? true : false,
            disabled: disabled.includes('acuerdo'),
          },
          {
            label: "Audiencia",
            value: "audiencia",
            selected:  s_selected == 'audiencia' ? true : false,
            disabled: disabled.includes('audiencia'),
          }
        ];
        break;

      case 'acuerdo':
        var opciones =  [
          {
            label: "Acuerdo",
            value: "acuerdo",
            selected: s_selected == 'acuerdo' ? true : false,
            disabled: disabled.includes('acuerdo'),
          },
        ];
        break;
      
      case 'audiencia':
        var opciones =   [
            {
            label: "Audiencia",
            value: "audiencia",
            selected:  s_selected == 'audiencia' ? true : false,
            disabled: disabled.includes('audiencia'),
          }
        ];
        break;

      default:
        var opciones =  [];
      
    }

    return opciones;

  }

  vatu( usuarios_autorizados ) {

    if( usuarios_autorizados.includes( this.tipo_usuario_sustitucion )  || usuarios_autorizados.includes( this.tipo_usuario ) ) return true;
    else return false;

  }

}