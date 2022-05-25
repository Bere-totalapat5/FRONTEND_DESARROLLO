{{-- Notificaciones y Alertas--}}
  <div class="form-layout">
    <div class="row mg-b-25">
      <br>
      <div class="col-lg-12">
        <br>
        <h5 class="form-control-label">Notificaciones y Alertas </h5>
        <hr/>
      </div><!-- col-lg-12-->
      
      <div class="col-lg-12"> <!-- Nueva Notificacion Alerta -->
        <br>
        <div id="accordionNotificaionAlerta" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
          <div class="card">
            <div class="card-header" role="tab" id="headingOne">
              <a id="titleAccordionNotificaionAlerta" data-toggle="collapse" data-parent="#accordionNotificaionAlerta" href="#collapseOneNotificaionAlerta" aria-expanded="true" aria-controls="collapseOneNotificaionAlerta" class="bkg-collapsed-btn tx-gray-800 transition collapsed tx-white">
                Nueva Notificacion / Alerta
              </a>
            </div><!-- card-header -->
            <div id="collapseOneNotificaionAlerta" class="collapse" role="tabpanel" aria-labelledby="headingOneNotificaionAlerta">
              <div class="card-body">
                <div class="mg-t-15">
                  <div class="row">

                    <div class="col-lg-6">
                      <div class="form-group mg-b-10-force">
                        <label class="form-control-label">Fecha de Alerta/Notificacon:<span class="tx-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fecha-NA" name="fecha-NA" autocomplete="off">
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Tipo de Notificacion: <span class="tx-danger">*</span> </label>
                        <select class="form-control select2" id="tipo-NA" name="tipo-NA" autocomplete="off">
                          <option selected value="null">Elija una opción</option>
                          <option value="PERSONAL">Personal</option>
                          <option value="GENERAL">General</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-lg-12" id="col_nombre_documento_asociado">
                      <div class="form-group">
                        <label class="form-control-label">Comentario Alerta/Notificacion: <span class="tx-danger">*</span> </label>
                        <textarea type="text" class="form-control" id="comentario-NA" name ="comentario-NA" placeholder="Ingrese comentarios" maxlength="700"></textarea>
                      </div>
                    </div>

                  </div>
                  <div class="col-lg-12 d-flex mg-t-5" id="botonesNotificaionAlerta">
                    <input type="hidden" id="idNotificacionAlerta" name="idNotificacionAlerta" value="">
                    <button class="btn btn-secondary bd-0 d-inline-block" id="btnCancelarEdicionNotificacionAlerta" onclick="reset_formulario_NA()">Cancelar</button>
                    <button class="btn btn-primary bd-0 d-inline-block ml-auto" id="btnNotificacionAlerta" onclick="agregarNotificacionAlerta()">Agregar</button>
                  </div>

                </div>
              </div> <!-- CARD BODY -->
            </div> <!-- BODY COLLAPSE -->
          </div> <!-- CARD -->
        </div> <!-- ACCORDEON TODAS PARTES PROCESALES -->
        <br>
      </div><!-- col-lg-12-->
      
      
      <div class="col-lg-12"> <!-- busqueda -->
        
          <div class="row">
              
            <div class="col-lg-4 mb-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Desde:</span>
                </div>
                <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fecha_alerta_desde_buscar-NA" name="fecha_alerta_desde_buscar-NA" autocomplete="off">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4 mb-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Hasta:</span>
                </div>
                <input type="text" class="form-control fc-datepicker" placeholder="DD/MM/AAAA" id="fecha_alerta_hasta_buscar-NA" name="fecha_alerta_hasta_buscar-NA" autocomplete="off">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                </div>
              </div>
            </div>

            <div class="col-lg-4 mb-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Estatus:</span>
                </div>
                <div class="col pl-0 pr-0">
                  <select class="form-control select2" id="estatus_actual_buscar-NA" name="estatus_actual_buscar-NA" autocomplete="off">
                    <option selected value="-">Todos</option>
                    <option value="ACTIVA">Activas</option>
                    <option value="CANCELADA">Canceladas</option>
                    <option value="ATENDIDA">Atendidas</option>
                  </select>
                </div>
                <div class="col-md-3 pr-0">
                  <button class="btn btn-primary w-100"  type="button" onclick="pintarNotificacionesAlertas(1)">Filtrar</button>
                </div>
              </div>
            </div>
              
          </div><!-- row-->
        
      </div><!-- col-lg-12-->
      
      <div class="col-lg-12"> <!-- tabla -->
        
        <table id="tableNotificacionesAlertas" class="display dataTable dtr-inline collapsed">
          <thead style="background-color: #EBEEF1; color: #000;">
            <tr>
              <th>#</th>
              <th>Acciones</th>
              <th>Tipo de alerta</th>
              <th>Fecha de<br>alerta</th>
              <th>Comentarios</th>
              <th>Fecha de registro</th>
              <th>Registrado por</th>
              <th>Estatus<br>alerta</th>
            </tr>
          </thead>
          <tbody>

          </tbody> 
        </table>
        <div class="pagination-wrapper justify-content-between">
          <ul class="pagination mg-b-0">
            <li class="page-item">
              <a class="page-link primera-NA" href="javascript:void(0)" aria-label="Last" onclick="pintarNotificacionesAlertas(1)">
                <i class="fa fa-angle-double-left"></i>
              </a>
            </li>
            <li class="page-item">
              <a class="page-link anterior-NA" href="javascript:void(0)" aria-label="Next" onclick="pintarNotificacionesAlertas(1)">
                <i class="fa fa-angle-left"></i>
              </a>
            </li>
          </ul>

          <ul class="pagination mg-b-0">
            <li class="page-item">Página <span class="pagina-NA">1</span> de <span class="total-paginas-NA">1</span></li>
          </ul>

          <ul class="pagination mg-b-0">
            <li class="page-item">
              <a class="page-link siguiente-NA" href="javascript:void(0)" aria-label="Next" onclick="pintarNotificacionesAlertas(1)">
                <i class="fa fa-angle-right"></i>
              </a>
            </li>
            <li class="page-item">
              <a class="page-link ultima-NA" href="javascript:void(0)" aria-label="Last" onclick="pintarNotificacionesAlertas(1)">
                <i class="fa fa-angle-double-right"></i>
              </a>
            </li>
          </ul>
        </div>
      </div><!-- col-lg-12-->
      
      

      <hr/>

    </div><!-- row -->

    {{-- BOTONES--}}    
    <div class="form-layout-footer d-flex">
    </div><!-- form-layout-footer -->
  </div>

  <script>

    var arrNA = [];

    /************************
    * 
    * MUESTRA ALERTAS Y NOTIFICACIONES
    * 
    *************************/
    function pintarNotificacionesAlertas( pagina = 1 ){
      $("#tableNotificacionesAlertas tbody tr").remove();

      $.ajax({
        method:'POST',
        url:'/public/obtener_notificaciones',
        data:{
          id_carpeta_judicial : $("#id_carpeta_judicial").val() ,
          estatus_actual : $("#estatus_actual_buscar-NA").val() ,
          fecha_programada_desde : $("#fecha_alerta_desde_buscar-NA").val() ,
          fecha_programada_hasta : $("#fecha_alerta_hasta_buscar-NA").val() ,
          pagina : pagina ,
        },
        success:function(response){
          arrNA = [];
          
          console.log('consulta notificaciones alertas.',response);

          if(response.status == 100){

            arrNA = response.response;
            
            strEditarNA = ``; 
            strCancelarNA = ``; 
            $( response.response ).each( function(index, na){

              if( !bandera_solo_consulta && na.estatus_actual!='FINALIZADA' ){ // aquí se controla el permiso de edición 
                strEditarNA = `<i class="fas fa-edit" data-toggle="tooltip-primary" data-placement="top" title="Editar NotificacionAlerta" onclick="editarNotificacionAlerta(${index})"></i>`
              }
              
              if(!bandera_solo_consulta){ // aquí se controla el permiso de cancelacion
                if( na.estatus_actual=='ACTIVA'  )
                strCancelarNA = `<i class="fas fa-ban" data-toggle="tooltip-primary" data-placement="top" title="Editar NotificacionAlerta" onclick="estatusNotificacionAlerta(${index}, 'CANCELADA')"></i>`
                else if ( na.estatus_actual=='CANCELADA' )
                strCancelarNA = `<i class="fas fa-undo-alt" data-toggle="tooltip-primary" data-placement="top" title="Borrar NotificacionAlerta" onclick="estatusNotificacionAlerta(${index}, 'ACTIVA')"></i>`
              }

              $('#tableNotificacionesAlertas tbody').append(`
                <tr>
                  <td>${index+1}</td>
                  <td>${strEditarNA} ${strCancelarNA}</td>
                  <td>${na.tipo_notificacion}</td>
                  <td>${ get_date( na.fecha_programada , 'DD-MM-YYYY' )}</td>
                  <td>${ na.texto_notificacion }</td>
                  <td>${ get_date( na.creacion.split(' ')[0] , 'DD-MM-YYYY' )} ${get_time( na.creacion , 'HH:mm' )}</td>
                  <td>${na.nombre_usuario_registra}</td>
                  <td>${na.estatus_actual}</td>
                </tr>
              `);
            });

            let anterior=pagina==1?1:pagina-1;
            let totalPaginas=response.paginacion.total_paginas;
            let siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

            $('.anterior-NA').attr('onclick',`pintarNotificacionesAlertas(${anterior})`);
            $('.pagina-NA').html(pagina);
            $('.total-paginas-NA').html(totalPaginas);
            $('.siguiente-NA').attr('onclick',`pintarNotificacionesAlertas(${siguiente})`);
            $('.ultima-NA').attr('onclick',`pintarNotificacionesAlertas(${totalPaginas})`);

          }  // if status==100
          else{
            $('#tableNotificacionesAlertas tbody').append(`
              <tr>
                <td colspan="8">
                  <span class="tx-italic">${response.message}</span>
                </td>
              </tr>
            `);
            $('.anterior-NA').attr('onclick',`pintarNotificacionesAlertas(1)`);
            $('.pagina-NA').html('1');
            $('.total-paginas-NA').html('1');
            $('.siguiente-NA').attr('onclick',`pintarNotificacionesAlertas(1)`);
            $('.ultima-NA').attr('onclick',`pintarNotificacionesAlertas(1)`);

            //if( response.message!="ERROR - sin referencia a datos" && response.message!="ERROR - sin datos asociados" ) modal_error('Notificaciones y Alertas dice : '+response.message,'modalAdministracion');
          }
        }, // success
        error: function( e ){
          console.log( e );
          modal_error('Notificaciones y Alertas dice : Ocurrió un error al consultar las nofiticaciones y alertas ','modalAdministracion')
        }
      }); // ajax
    }

    /************************
    * 
    * GUARDAR NOTIFICACION ALERTA
    * 
    *************************/
    function agregarNotificacionAlerta(){

      if( !$("#fecha-NA").val() ){
        modal_error('Debe ingresar una fecha','modalAdministracion');
        return false;
      }
      if( !$("#comentario-NA").val() ){
        modal_error('Debe agregar un comentario','modalAdministracion');
        return false;
      }
      if( $("#tipo-NA").val()=='null' ){
        modal_error('Debe seleccionar un tipo de notificación','modalAdministracion');
        return false;
      }


      $.ajax({
        method:'POST',
        url:'/public/nueva_notificacion',
        data:{
          id_carpeta_judicial : $("#id_carpeta_judicial").val() ,
          fecha_programada : $("#fecha-NA").val() ,
          texto_notificacion : $("#comentario-NA").val() ,
          tipo_notificacion : $("#tipo-NA").val() ,
          id_unidad : carpetaActiva.id_unidad ,
        },
        success:function(response){
          if( response.status == 100 ){
            modal_success('Alerta / Notificación agregada correctamente','modalAdministracion');
            reset_formulario_NA();
            pintarNotificacionesAlertas();
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        }
      });
    }


    /************************
    * 
    * EDITAR NOTIFICACION ALERTA
    * 
    *************************/

    function editarNotificacionAlerta( indexNA ){
      let na = arrNA[indexNA];
      $('#idNotificacionAlerta').val(na.id_notificacion);
      $('#tipo-NA').val( na.tipo_notificacion ).trigger('change');
      $("#comentario-NA").val(na.texto_notificacion);
      $("#fecha-NA").val( get_date( na.fecha_programada , 'DD-MM-YYYY') );
      $("#titleAccordionNotificaionAlerta").text('Editando Notificacion / Alerta');
      $("#titleAccordionNotificaionAlerta").addClass(`bkg-collapsed-btn-edit`);
      $("#titleAccordionNotificaionAlerta").removeClass(`bkg-collapsed-btn`);
      $("#btnNotificacionAlerta").text('Actualizar');
      $("#btnNotificacionAlerta").attr('onclick','guardarCambiosNotificacionAlerta()');
      $("#collapseOneNotificaionAlerta").collapse('show');
    }

    /************************
    * 
    * GUARDAR CAMBIOS NOTIFICACION ALERTA
    * 
    *************************/
    function guardarCambiosNotificacionAlerta(){
      
      if( !$("#fecha-NA").val() ){
        modal_error('Debe ingresar una fecha','modalAdministracion');
        return false;
      }
      if( !$("#comentario-NA").val() ){
        modal_error('Debe agregar un comentario','modalAdministracion');
        return false;
      }
      if( $("#tipo-NA").val()=='null' ){
        modal_error('Debe seleccionar un tipo de notificación','modalAdministracion');
        return false;
      }

      $.ajax({
        method:'POST',
        url:'/public/editar_notificacion',
        data:{
          id_notificacion : $('#idNotificacionAlerta').val() ,
          id_carpeta_judicial : $("#id_carpeta_judicial").val() ,
          fecha_programada : $("#fecha-NA").val() ,
          texto_notificacion : $("#comentario-NA").val() ,
          tipo_notificacion : $("#tipo-NA").val() ,
        },
        success:function(response){
          if( response.status == 100 ){
            modal_success('Alerta / Notificación modificada correctamente','modalAdministracion');
            reset_formulario_NA();
            pintarNotificacionesAlertas();
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        }
      });
    }

    /************************
    * 
    * CANELAR NOTIFICACION ALERTA
    * 
    *************************/
    function estatusNotificacionAlerta(indexNA , estatus){

      $.ajax({
        method:'POST',
        url:'/public/editar_notificacion',
        data:{
          id_notificacion : arrNA[ indexNA ].id_notificacion ,
          id_carpeta_judicial : $("#id_carpeta_judicial").val() ,
          estatus_actual : estatus,
        },
        success:function(response){
          if( response.status == 100 ){
            modal_success(`Alerta / Notificación ha sido ${estatus=='ACTIVA'?'ACTIVADA':estatus} correctamente`,'modalAdministracion');
            reset_formulario_NA();
            pintarNotificacionesAlertas();
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        }
      });
    }

    function reset_formulario_NA(){
      $('#idNotificacionAlerta').val('');
      $('#tipo-NA').val('null').trigger('change');
      $("#comentario-NA").val("");
      $("#fecha-NA").val("");
      $("#titleAccordionNotificaionAlerta").text('Nueva Notificacion / Alerta');
      $("#titleAccordionNotificaionAlerta").removeClass(`bkg-collapsed-btn-edit`);
      $("#titleAccordionNotificaionAlerta").addClass(`bkg-collapsed-btn`);
      $("#btnNotificacionAlerta").text('Agregar');
      $("#btnNotificacionAlerta").attr('onclick','agregarNotificacionAlerta()');
      $("#collapseOneNotificaionAlerta").collapse('hide');
    }
    

  </script>
