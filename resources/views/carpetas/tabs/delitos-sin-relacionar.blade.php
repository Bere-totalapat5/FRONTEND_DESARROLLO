{{-- Delitos sin relacionar--}}
  <div class="form-layout">
    <div class="row mg-b-25">
      <br>
      {{-- SECCION   DELITOS SIN RELACIONAR --}}
      <div class="col-lg-12">
        <br>
        <h5 class="form-control-label">Delitos sin relacionar </h5>
        <hr/>
        <div class="row" id="divDelitosSinRelacionar">
        </div>
        <br>
        <h5 class="form-control-label">Delitos Estadísticos &nbsp; &nbsp; &nbsp; &nbsp;
          <button type="button" class="btn btn-outline-primary btn-sm" id="btn-agregarDelito-DE" onclick="formularioDelitoEstadistico()">Agregar Delito</button>
        </h5>
        <hr/>
        <div class="row" id="divDelitosEstadisticos">
        </div>
      </div><!-- col-lg-12-->

      <hr/>

    </div><!-- row -->

    {{-- BOTONES--}}    
    <div class="form-layout-footer d-flex">
      <!-- <button class="btn btn-primary bd-0 d-inline-block  ml-auto" id="btn-enviar-solicitud" onclick="relacionarDelitosSinRelacionar()">Imputar delitos</button> -->
    </div><!-- form-layout-footer -->
  </div>

  

  {{-- JS --}} 
  <script>
    var arrImputados=[];
    var arrDSR=[];
    
    var delitosEstadisticos_DE = @php echo json_encode($delitos_estadisticos); @endphp;
    var desagregadosEstadisticos_DE = @php echo json_encode($desagregados_estadisticos); @endphp; 

    /***********************************
    * 
    *  RELACIONAR DELITOS
    * 
    ***********************************/

    function relacionarDelitoSinRelacionar(indexDSR){
      
      $('.error').removeClass('error');

      //console.log(indexDSR,arrDSR[indexDSR]);
      var delitos_sin_relacionar =[];

      var imputados='';
      let strClass = `div.datos-dsr-imputado[data-indexdsr='${indexDSR}']`;
      $(strClass).find("input.imputado[type=checkbox]:checked").each(function(){
        console.log( $(this).val() );
        let indexImputado = $(this).val();
        let {id_persona,genero}=arrImputados[indexImputado].info_principal
        imputados= imputados.length? imputados+','+id_persona : imputados+id_persona;
      });
      var { calificativo,delito,delito_grave,delito_oficioso,estatus,forma_comision,grado_realizacion,id_calificativo,id_delito,id_modalidad,id_persona,id_persona_delito,id_solicitud,nombre_modalidad }= arrDSR[indexDSR];
      delitos_sin_relacionar.push({
        id_persona:imputados,
        id_persona_delito,
        id_delito,
        id_modalidad,
        id_calificativo,
        forma_comision,
        grado_realizacion,
        delito_grave,
        //estatus:1,
      });

      if( !imputados.length ){
        $('input.imputado').parent().addClass('error');
        modal_error('Debes seleccionar al menos un imputado','modalAdministracion');
        return false;
      }
      
      $.ajax({
        method:'POST',
        url:'/public/relacionar_delitos_sin_relacionar',
        data:{
          id_carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          delitos_sin_relacionar,
        },
        success:function(response){
          console.log(response);
          if(response.status==100){
            modal_success(`Delitos relacionados exitosamente`,'modalAdministracion');
            setTimeout(function(){ pintarDelitosSinRelacionar(); }, 500);
            setTimeout(function(){ pintarPersonas(); }, 300);
          }else{
            modal_error(response.message,'modalAdministracion');
          } 
        }
      });
    }

    /************************
    * 
    * MUESTRA TODOS LOS DELITOS
    * 
    *************************/

    function pintarDelitosSinRelacionar(){
      $("#divDelitosSinRelacionar div").remove();
      $.ajax({
        method:'POST',
        url:'/public/obtener_personas_carpeta',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
        },
        success:function(response){
          console.log(response);
          let strImputados = ``;

          if(response.status==100 && response.response.delitos_sin_relacionar.length){
            arrDSR = response.response.delitos_sin_relacionar

            $(response.response.personas).each(function(index_p, persona){
              if( persona.info_principal.id_calidad_juridica == 46 && $("#tipo_solicitud").val() != 'promujer' ){
                arrImputados[index_p] = persona;
                let uniqueID = get_unique_id();
                const {calidad_juridica,razon_social,nombre,apellido_paterno,apellido_materno,id_persona} = persona.info_principal;
                
                strImputados =strImputados.concat(`
                  <div class="col-sm-12">
                    <label class="ckbox d-inline-block mg-l-5">
                      <input name="imputado_${uniqueID}" class="imputado " type="checkbox" value="${index_p}">
                      <span>${razon_social==null?'':razon_social}  ${nombre==null?'':nombre}   ${apellido_paterno==null?'':apellido_paterno}   ${apellido_materno==null?'':apellido_materno}</span>
                    </label> 
                  </div>
                
                `);
                
              }
            }); // foreach

            $(response.response.delitos_sin_relacionar).each(function(index, delito){

              let strRelacionarDSR='';
              let strBorrarDSR = ``;
              let strEditarDSR = ``;
              let strHistorialDSR=``;
              if(true && $("#tipo_solicitud").val() != 'EXHORTO' ){ // aquí se controla el permiso de edición
                strRelacionarDSR = `<button class="btn btn-primary d-inline-block mg-l-10" onclick="relacionarDelitoSinRelacionar(${index})">Imputar delitos</button>`;
                //strBorrarDSR = `<button class="btn btn-danger d-inline-block mg-l-10" onclick="borrarDelitoSinRelacionar(${index})">Borrar</button>`;
                strEditarDSR = `<button class="btn btn-info d-inline-block mg-l-10" onclick="editarDelitoSinRelacionar(${index})">Editar</button>`;
                strHistorialDSR = `<button class="btn btn-secondary d-inline-block mg-l-10" onclick="mostrarHistorialDelitoSinRelacionar(${index})">Historial</button>`;
              }
              
              let table = ``;
              let relacionar =``;
              if( $("#tipo_solicitud").val() != 'EXHORTO' ){
                table=`
                  <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                    <tbody class="table-datos-sujeto">
                      <tr>
                        <td>Delito:</td>
                        <td colspan="3">${delito.delito.toUpperCase()}</td>
                      </tr>
                      <tr>
                        <td>Modalidad:</td>
                        <td colspan="3" style="text-transform:uppercase;">${delito.nombre_modalidad}</td>
                      </tr>
                      <tr>
                        <td>Calificativo:</td>
                        <td>${delito.calificativo?delito.calificativo.toUpperCase():'<span class="tx-italic">Sin registro</span>'}</td>
                        <td>Grado de realizacion:</td>
                        <td>${delito.grado_realizacion.replaceAll('_',' ').toUpperCase()}</td>
                      </tr>
                      <tr>
                        <td>Delito grave:</td>
                        <td>${delito.delito_grave.toUpperCase()}</td>
                      </tr>
                    </tbody>
                  </table>
                `;
                relacionar =`
                  <div class="col-sm-12">
                      <br>
                      <label class="form-control-label"> RELACIONAR DELITO A: </label>
                    </div>
                  <div class="col-sm-12 datos-dsr-imputado" data-indexdsr="${index}">
                    ${strImputados}
                  </div>
                `;
              }else{
                table=`
                  <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                    <tbody class="table-datos-sujeto">
                      <tr>
                        <td>Delito:</td>
                        <td>${delito.delito.toUpperCase()}</td>
                      </tr>
                    </tbody>
                  </table>
                `;
              }

              $('#divDelitosSinRelacionar').append(`
                <div class="col-lg-6">
                  <div id="accordion${index}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
                    <div class="card">
                      <div class="card-header" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#accordion${index}" href="#collapseOneDelitoSinRelacionar${index}" aria-expanded="true" aria-controls="collapseOneDelitoSinRelacionar${index}" class="tx-secondary tx-gray-800 transition collapsed">
                          ${ delito.delito.toUpperCase() } ${ delito.delito_grave !=null? (delito.delito_grave == 'no' ? '[ NO GRAVE ]' : '[ GRAVE ]'):''}
                        </a>
                      </div><!-- card-header -->

                      <div id="collapseOneDelitoSinRelacionar${index}" class="collapse" role="tabpanel" aria-labelledby="headingOne${index}">
                        <div class="card-body">
                          <div class="row relacion">
                            <div class="col-sm-12">
                              ${table}
                            </div>
                            ${relacionar}
                            <br>
                            <div class="col-sm-12 d-flex justify-content-end">
                              ${strHistorialDSR} ${strBorrarDSR} ${strEditarDSR} ${strRelacionarDSR}
                            </div>
                          </div>
                          <div class="row edicion d-none">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              `); 

              setTimeout(function(){ $('#collapseOneDelitoSinRelacionar'+index).collapse('show'); },200);
            });
            return false;
          }  // if status==100
          else if ( response.status==100 ){
            $('#divDelitosSinRelacionar').append(`
              <div class="col-lg-12">
                <span class="tx-italic">No hay delitos sin relacionar</span>
              </div>
            `);
            $(response.response.personas).each(function(index_p, persona){
              if( persona.info_principal.id_calidad_juridica == 46 && $("#tipo_solicitud").val() != 'promujer' ){
                arrImputados[index_p] = persona;
              }
            }); // foreach
          }
          else{
            $('#divDelitosSinRelacionar').append(`
              <div class="col-lg-12">
                <span class="tx-italic">No hay delitos sin relacionar</span>
              </div>
            `);
          }
        } // success
      }); // ajax
    }

    
    /************************
    * 
    * DELITO SIN RELACIONAR EN EDICION
    * 
    *************************/

    function editarDelitoSinRelacionar(indexDSR){
      console.log( indexDSR, arrImputados[indexDSR]);
     
      let inputID = get_unique_id();

      let cat_delitos='<option value="null">Elija una opción</option>';

      delito = arrDSR[indexDSR];
      
      $(catalogoDelitos).each(function(cat_index_delitos, undelito){
        const option=`<option value="${undelito.id_delito}" data-grave="${undelito.delito_oficioso==1?'si':'no'}" ${undelito.id_delito == delito.id_delito?'selected':''}>${undelito.delito}</option>`;
        cat_delitos=cat_delitos.concat(option);
      });

      var cat_modalidades=`<option value="null">Elija una opción</option>`;

      if(delito.id_delito!=null && delito.id_delito!='' && delito.id_modalidad!=null && delito.id_modalidad!=''){
        $.ajax({
          type:'POST',
          url:'/public/obtener_modalidades',
          data:{
            delito:delito.id_delito,
          },
          success:function(response){
            console.log(delito.id_modalidad, response)
            $(response.response).each((index, modalidad)=>{
              const {id_modalidad, nombre_modalidad}=modalidad;
              const option=`<option value="${id_modalidad}" ${ id_modalidad==delito.id_modalidad? 'selected' : ''}>${nombre_modalidad}</option>`;
              cat_modalidades=cat_modalidades.concat(option);
            });
            console.log(cat_modalidades);
          }
        });
      }
      
      let calificativos='<option value="null">Elija una opción</option>';
      $(catalogoCalificativos).each(function(index_cal, calificativo){
        const option=`<option value="${calificativo.id_calificativo}" ${calificativo.id_calificativo==delito.id_calificativo?'selected':''}>${calificativo.calificativo}</option>`;
        calificativos=calificativos.concat(option);
      });
      
      setTimeout(function(){
        console.log(cat_modalidades);
        
        $('#accordion'+indexDSR+' div.edicion').append(`
          <div class="row datos-delito" id="datos-delito${inputID}" data-id="${delito.id_persona_delito}" data-status="${delito.estatus}" data-indexdsr="${indexDSR}">
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Delito: <span class="tx-danger">*</span></label>
                <select class="form-control delito" id="delito${inputID}" name="delito" autocomplete="off">
                  ${cat_delitos}                      
                </select>
              </div>
            </div> 
            <div class="col-lg-12">
              <div class="form-group">
                <label class="form-control-label">Modalidad de Delito: <span class="tx-danger">*</span></label>
                <select class="form-control select2 modalidad-delito" id="modalidadDelito${inputID}" name="modalidad_delito" autocomplete="off">
                    ${cat_modalidades}
                </select>
              </div>
            </div> 
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Calificativo: <span class="tx-danger">*</span></label>
                <select class="form-control select2 calificativo" id="calificativo${inputID}" name="calificativo" autocomplete="off">
                  ${calificativos}
                </select>
              </div>
            </div> 
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Grado de Realización: <span class="tx-danger">*</span></label>
                <select class="form-control select2 grado-realizacion" id="gradoRealizacion${inputID}" name="grado_realizacion" autocomplete="off">
                    <option disabled value="">Elija una opción</option>
                    <option ${delito.grado_realizacion=="de_tentetiva"?'selected':''} value="de_tentetiva">DE TENTATIVA</option>
                    <option ${delito.grado_realizacion=="consumado"?'selected':''} value="consumado">CONSUMADO</option>
                    <option ${delito.grado_realizacion=="por_definir"?'selected':''} value="por_definir">POR DEFINIR</option>
                </select>
              </div>
            </div> 
            <div class="col-lg-12 d-flex justify-content-end">
              <button class="btn btn-danger d-inline-block mg-l-10" onclick="cancelarDelitoSinRelacionar(${indexDSR})">Cancelar</button>
              <button class="btn btn-primary d-inline-block mg-l-10" onclick="actualizarDelitoSinRelacionar(${indexDSR})">Guardar cambios</button>
            </div> 
          </div>
        `);

        setTimeout(()=>{
          $('#delito'+inputID).change(function(){
            $.ajax({
              type:'POST',
              url:'/public/obtener_modalidades',
              data:{
                delito:$('#delito'+inputID).val(),
              },
              success:function(response){
                if(response.status==100){
                  let modalidades='<option selected disabled value>Elija una opcion</option>';
                  $(response.response).each((index, modalidad)=>{
                    const {id_modalidad, nombre_modalidad}=modalidad;
                    const option=`<option value="${id_modalidad}">${nombre_modalidad}</option>`;
                    modalidades=modalidades.concat(option);
                  });
                  $('#modalidadDelito'+inputID).html(modalidades);
                }
              }
            });
          });

          $('#delito'+inputID).select2({minimumResultsForSearch: ''});    
          $('#modalidadDelito'+inputID).select2({minimumResultsForSearch: ''});    
          $('#calificativo'+inputID).select2({minimumResultsForSearch: ''});    
          $('#gradoRealizacion'+inputID).select2({minimumResultsForSearch: ''});    
        },100);
      },300);

      $('#accordion'+indexDSR+' div.relacion').addClass('d-none');
      $('#accordion'+indexDSR+' div.edicion').removeClass('d-none');
    }

    /************************
    * 
    * ACTUALIZA DELITO SIN RELACIONAR EN EDICION
    * 
    *************************/

    function actualizarDelitoSinRelacionar(indexDSR){

      if( !validaDatosDelito(indexDSR) ){
        return false;
      }else{
        let delitos_sin_relacionar=[];
        let{id_persona_delito,id_persona} = arrDSR[indexDSR];
        
        delitos_sin_relacionar.push(
          { id_persona_delito,
            id_persona:0,
            estatus:1,
            id_delito:$('#accordion'+indexDSR+' div.edicion select.delito').val(),
            id_modalidad:$('#accordion'+indexDSR+' div.edicion select.modalidad-delito').val(),
            id_calificativo:$('#accordion'+indexDSR+' div.edicion select.calificativo').val(),
            forma_comision:"-",
            grado_realizacion:$('#accordion'+indexDSR+' div.edicion select.grado-realizacion').val(),
            delito_grave:$('#accordion'+indexDSR+' div.edicion select.delito').find('option:selected').attr('data-grave'),
          }
        );

        //console.log( delitos_sin_relacionar );

        $.ajax({
          method:'POST',
          url:'/public/actualizar_delito_sin_relacionar',
          data:{
            id_carpeta : $("#id_carpeta_judicial").val(),
            id_solicitud : $("#id_solicitud").val(),
            tipo_solicitud : $("#tipo_solicitud").val(),
            delitos_sin_relacionar,
          },
          success:function(response){
            console.log(response);
            if(response.status==100){
              modal_success(`Delito actualizado exitosamente`,'modalAdministracion');
              setTimeout(function(){ pintarDelitosSinRelacionar(); }, 500);
            }else{
              modal_error(response.message,'modalAdministracion');
            } 
          }
        });
      }
    }

    /************************
    * 
    * MUESTRA EL HISTORIAL DE MODIFICACIONES A UN DELITO NO RELACIONADO
    * 
    *************************/
    
    function mostrarHistorialDelitoSinRelacionar( indexDSR ){
      let title = "HISTORIAL DEL DELITO: "+arrDSR[ indexDSR ].delito.toUpperCase();
      let body = ``;
      let listaDelitos=``;

      $.ajax({
        method:'POST',
        url:'/public/consulta_historial',
        data:{
          carpeta : $("#id_carpeta_judicial").val(),
          id_solicitud : $("#id_solicitud").val(),
          tipo_solicitud : $("#tipo_solicitud").val(),
          historial: 'delitos',
          id_delito: arrDSR[ indexDSR ].id_persona_delito,
        },
        success:function(response){
          console.log(response);
          if(response.status==100){
            $(response.response).each(function(index_d,delito){
              listaDelitos=listaDelitos.concat(`
                <tr>
                  <td>${delito.creacion != null ? delito.creacion.toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                  <td>${delito.delito != null ? delito.delito.toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                  <td>${delito.nombre_modalidad != null ? delito.nombre_modalidad.toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                  <td>${delito.calificativo != null ? delito.calificativo.toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                  <td>${delito.grado_realizacion != null ? delito.grado_realizacion.replaceAll('_',' ').toUpperCase() : '<span class="tx-italic">Sin registro</span>'}</td>
                </tr>
              ` );
            });
            body = `
              <div class="row">
                <div class="col-lg-12">
                  <table class="datatable tableDatosSujeto" style="overflow-x: none; display: table">
                    <thead>
                        <tr>
                          <th class="tx-center" style="background:#f8f9fa">Fecha</th>
                          <th class="tx-center" style="background:#f8f9fa">Delito</th>
                          <th class="tx-center" style="background:#f8f9fa">Modalidad delito</th>
                          <th class="tx-center" style="background:#f8f9fa">Calificativo</th>
                          <th class="tx-center" style="background:#f8f9fa">Grado realización</th>
                        </tr>
                      </thead>
                    <tbody class="table-datos-sujeto">
                    ${ listaDelitos.length ? listaDelitos : '<tr><td colspan="4"><span class="tx-italic">Sin delitos</span></td></tr>' }
                    </tbody>
                  </table>
                </div>
              </div>
            `;
            modal_historial(title,body,'modalAdministracion');
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        } // success
      }); // ajax
    }

    /**********************
    * 
    * CANCELAR EDICION DE DELITOS
    * 
    **********************/

    function cancelarDelitoSinRelacionar(indexDSR){
      $('#accordion'+indexDSR+' div.edicion div').remove();
      $('#accordion'+indexDSR+' div.edicion').addClass('d-none');
      $('#accordion'+indexDSR+' div.relacion').removeClass('d-none');
    }

    
    /**********************
    * 
    * FUNCIONES GENERALES
    * 
    **********************/
    
    function validaDatosDelito(indexDSR){
      console.log("Hola vato");
      if( !$('#accordion'+indexDSR+' div.edicion select.delito').val() || $('#accordion'+indexDSR+' div.edicion select.delito').val()=='null' ){
        modal_error('No ha seleccionado el delito','modalAdministracion');
        $('#accordion'+indexDSR+' div.edicion select.delito').parent().addClass('error');
        return false;
      }        
      if( !$('#accordion'+indexDSR+' div.edicion select.modalidad-delito').val() || $('#accordion'+indexDSR+' div.edicion select.modalidad-delito').val()=='null' ){
        modal_error('No ha seleccionado la modalidad del delito','modalAdministracion');
        $('#accordion'+indexDSR+' div.edicion select.modalidad-delito').parent().addClass('error');
        return false;
      }        
      if( !$('#accordion'+indexDSR+' div.edicion select.calificativo').val() || $('#accordion'+indexDSR+' div.edicion select.calificativo').val()=='null' ){
        modal_error('No ha seleccionado el calificativo','modalAdministracion');
        $('#accordion'+indexDSR+' div.edicion select.calificativo').parent().addClass('error');
        return false;
      }          

      if( !$('#accordion'+indexDSR+' div.edicion select.grado-realizacion').val() || $('#accordion'+indexDSR+' div.edicion select.grado-realizacion').val()=='null' ){
        modal_error('No ha seleccionado el grado de realizacion','modalAdministracion');
        $('#accordion'+indexDSR+' div.edicion select.grado-realizacion').parent().addClass('error');
        return false;
      }
      
      return true;
    }
    

    /**********************************
    * 
    * Delitos Estadisticos 
    * 
    *************************************/

    
    function formularioDelitoEstadistico(){ 
      let id = get_unique_id();
      let options_delitos = "";
      let strImputados = ""; 
      
      for( var i in desagregadosEstadisticos_DE ){
        let de = desagregadosEstadisticos_DE[i];

        options_delitos = options_delitos + `
          <option value="${de.id}" data-nivel="${de.nivel}" >${de.descripcion}</option>
        `; 
      }

      $(arrImputados).each(function(index_im, persona){
        let uniqueID = get_unique_id();
        const {calidad_juridica,razon_social,nombre,apellido_paterno,apellido_materno,id_persona} = persona.info_principal;
        
        strImputados =strImputados.concat(`
          <div class="col-sm-12">
            <label class="ckbox d-inline-block mg-l-5">
              <input name="imputado_${uniqueID}" class="imputado " type="checkbox" value="${id_persona}" data-id_delito_persona="-">
              <span>${razon_social==null?'':razon_social}  ${nombre==null?'':nombre}   ${apellido_paterno==null?'':apellido_paterno}   ${apellido_materno==null?'':apellido_materno}</span>
            </label> 
          </div>
        
        `);
      }); // foreach


      $("#divDelitosEstadisticos").append(`
        <div class="col-lg-6" id="fomurlarioDE-${id}" >
          <div id="accordion-${id}" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true" width="100%">
            <div class="card">
              <div class="card-header" role="tab" id="headingOne">
                <a data-toggle="collapse" data-parent="#accordion-${id}" href="#collapseOneDelitoEstadistico-${id}" aria-expanded="true" aria-controls="collapseOneDelitoEstadistico-${id}" class="tx-secondary tx-gray-800 transition collapsed">
                  Delito Estadístico
                </a>
              </div><!-- card-header -->

              <div id="collapseOneDelitoEstadistico-${id}" class="collapse" role="tabpanel" aria-labelledby="headingOne-${id}">
                <div class="card-body body-delitos-estadisitcos ">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label">Delito:<span class="tx-danger">*</span> <span style="font-weight: bolder; font-size: 1rem;" id="descripcion-0-${id}"></span> </label>
                        <select class="form-control select2 tipo_delictivo" id="tipo_delictivo-${id}" autocomplete="off" onchange="cargar_desagregados_DE( this , 0 , ${id})">
                          <option value="-" selected disabled>Seleccione una opcion</option>
                          ${options_delitos}
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row" id="div-desagregados">
                  </div> 
                  <div class="row imputados" style="margin-top:1rem;">
                    ${strImputados}
                    <div class="col-sm-12 d-flex justify-content-end">
                      <button class="btn btn-danger d-inline-block" onclick="destruirFormularioDE('#fomurlarioDE-${id}')">Cancelar</button>
                      <button class="btn btn-primary d-inline-block mg-l-10" onclick="guardarDelitoEstadistico(this, ${id})">Guardar</button>
                    </div>
                  </div>
                  <br>
                </div>
              </div>
            </div>
          </div>
        </div>
      `);

      setTimeout( function () {
        $('#tipo_delictivo-'+id).select2({minimumResultsForSearch: ''});
        $('#collapseOneDelitoEstadistico-'+id).collapse('show');
      }, 200);
      
    }

    async function cargar_desagregados_DE( tag , nivel, id_temporal = 0 ){
      //console.log( "tag:",$(`#descripcion-${nivel}-${id_temporal}`), "texo:", $( tag ).find(":selected").text() );
      $(`#descripcion-${nivel}-${id_temporal}`).html( $( tag ).find(":selected").text() );

      let bandera_aperturar_campo_otro = false;

      if( nivel == 1 && $(tag).val() == 204 ) bandera_aperturar_campo_otro = true;
      if( nivel == 4 && ( $(tag).val() == 11 || $(tag).val() == 60 )  ) bandera_aperturar_campo_otro = true;

      if( bandera_aperturar_campo_otro ){
        $("#div-desagregados").append(`
          <div class="col-md-12 div-otro-${id_temporal}" style="margin-top:1rem;">
            <label class="form-control-label">Especifique: </label>
            <input type="text" class="form-control otro" id="otro-${id_temporal}" autocomplete="off" >
          </div>
        `);
      }

      if( nivel >= 4 ) return false;
      else if( nivel == 0 ) $("#div-desagregados").empty();
      else{
        for( i = parseInt(nivel) + 1 ; i<4 ; i++ ){
          $(`.div-desagregado_n${i}-${id_temporal}`).remove();
        }
      }

      const tipo_delictivo = $(`#tipo_delictivo-${id_temporal}`).val();
      const desagregado_n1 = $(`#desagregado_n1-${id_temporal}`).val();
      const desagregado_n2 = $(`#desagregado_n2-${id_temporal}`).val();
      const desagregado_n3 = $(`#desagregado_n3-${id_temporal}`).val();

      let desagregados = await catalogo_desagregados( tipo_delictivo, desagregado_n1, desagregado_n2, desagregado_n3 );

      let options_desagregados = `<option value="-" selected disabled>Seleccione una opcion</option>`;
      let nuevo_nivel = nivel;
      let bandera_seleccionar_automatico = false;

      if( desagregados.status == 100 ){
        desagregados = desagregados.response;

        bandera_seleccionar_automatico = desagregados.length == 1 ? true : false;
        
        for( var i in desagregados ){
          options_desagregados = options_desagregados + `
            <option value="${desagregados[i].id}" data-nivel="${desagregados[i].nivel}"> ${desagregados[i].descripcion}</option>
          `; 
          nuevo_nivel = desagregados[i].nivel;
        }

        $("#div-desagregados").append(`
          <div class="col-md-12 div-desagregado_n${nuevo_nivel}-${id_temporal}" style="margin-top:1rem;">
            <label class="form-control-label">Desagregado:<span class="tx-danger">*</span> <span style="font-weight: bolder; font-size: 1rem;" id="descripcion-${nuevo_nivel}-${id_temporal}"></span> </label>
            <select class="form-control select2 desagregado_n${nuevo_nivel}" id="desagregado_n${nuevo_nivel}-${id_temporal}" autocomplete="off"  onchange="cargar_desagregados_DE( this , ${nuevo_nivel} , ${id_temporal})">
              ${options_desagregados}
            </select>
          </div>
        `);
        setTimeout(function(){
          $(`#desagregado_n${nuevo_nivel}-${id_temporal}`).select2({minimumResultsForSearch: ''});

          if( bandera_seleccionar_automatico ){
            setTimeout(function(){ $(`#desagregado_n${nuevo_nivel}-${id_temporal}`).val( desagregados[0].id ).trigger('change') }, 200);
          }

        }, 200);

      }
    }

    function catalogo_desagregados( tipo_delictivo, desagregado_n1, desagregado_n2, desagregado_n3 ){
      return new Promise(resolve => {
        $.ajax({
          method:'GET',
          url:'/public/obtener_desagregado_delito_estadistico',
          data:{
            tipo_delictivo,
            desagregado_n1,
            desagregado_n2,
            desagregado_n3
          },
          success:function(response){
            console.log(response);
            resolve(response);
          },
          error : function( errors ){
            modal_error('Error :'+errors,'modalAdministracion');
            resolve( {status:0, message:'Error al consumir servicio desagregados'} ) ;
          }
        });
      });
    }

    function guardarDelitoEstadistico( tag_btn , id_temporal ){

      let tipo_delictivo = "-";
      let desagregado_n1 = "-";
      let desagregado_n2 = "-";
      let desagregado_n3 = "-";
      let desagregado_n4 = "-";
      let otro = "-";
      let imputados = [];

      $(tag_btn).parent().parent().parent().find(".error").removeClass('error');

      if( $(tag_btn).parent().parent().parent().find('.tipo_delictivo').length > 0 ){
        if( !($(tag_btn).parent().parent().parent().find('.tipo_delictivo').val() > 0) ){
          modal_error('Debe seleccionar un delito','modalAdministracion');
          $(tag_btn).parent().parent().parent().find('.tipo_delictivo').parent().addClass('error');
          return false;
        }else tipo_delictivo = $(tag_btn).parent().parent().parent().find(".tipo_delictivo").val();
      }
      
      if( $(tag_btn).parent().parent().parent().find('.desagregado_n1').length > 0 ){
        if( !($(tag_btn).parent().parent().parent().find('.desagregado_n1').val() > 0) ){
          modal_error('Debe seleccionar un desagregado','modalAdministracion');
          $(tag_btn).parent().parent().parent().find('.desagregado_n1').parent().addClass('error');
          return false;
        }else desagregado_n1 = $(tag_btn).parent().parent().parent().find(".desagregado_n1").val();
      }
      
      if( $(tag_btn).parent().parent().parent().find('.desagregado_n2').length > 0 ){
        if( !($(tag_btn).parent().parent().parent().find('.desagregado_n2').val() > 0) ){
          modal_error('Debe seleccionar un desagregado','modalAdministracion');
          $(tag_btn).parent().parent().parent().find('.desagregado_n2').parent().addClass('error');
          return false;
        }else desagregado_n2 = $(tag_btn).parent().parent().parent().find(".desagregado_n2").val();
      }
      
      if( $(tag_btn).parent().parent().parent().find('.desagregado_n3').length > 0 ){
        if( !($(tag_btn).parent().parent().parent().find('.desagregado_n3').val() > 0) ){
          modal_error('Debe seleccionar un desagregado','modalAdministracion');
          $(tag_btn).parent().parent().parent().find('.desagregado_n3').parent().addClass('error');
          return false;
        }else desagregado_n3 = $(tag_btn).parent().parent().parent().find(".desagregado_n3").val();
      }
      
      if( $(tag_btn).parent().parent().parent().find('.desagregado_n4').length > 0 ){
        if( !($(tag_btn).parent().parent().parent().find('.desagregado_n4').val() > 0) ){
          modal_error('Debe seleccionar un desagregado','modalAdministracion');
          $(tag_btn).parent().parent().parent().find('.desagregado_n4').parent().addClass('error');
          return false;
        }else desagregado_n4 = $(tag_btn).parent().parent().parent().find(".desagregado_n4").val();
      }
      
      if( $(tag_btn).parent().parent().parent().find('.otro').length > 0 ){
        otro = $(tag_btn).parent().parent().parent().find(".otro").val();
      }

      $(tag_btn).parent().parent().find(".imputado:checked").each(function(){
        imputados.push($(this).val());
      });
      
      if( imputados.length == 0 ){
        modal_error('Debe seleccionar un imputado','modalAdministracion');
        $(tag_btn).parent().parent().parent().find(".imputados").addClass('error');
        return false;
      }

      $.ajax({
        method:'POST',
        url:'/public/asignar_delito_estadistico_persona',
        data:{
          solicitud : carpetaActiva.id_solicitud,
          tipo_delictivo,
          desagregado_n1,
          desagregado_n2,
          desagregado_n3,
          desagregado_n4,
          otro,
          imputados
        },
        success:function(response){
          console.log(response);
          if( response.status == 100 ){
            modal_success('Delitos agregados correctamente','modalAdministracion');
            $(tag_btn).parent().parent().parent().parent().parent().parent().parent().remove();
          }else{
            modal_error(response.message,'modalAdministracion');
          }
        },
        error : function( errors ){
          modal_error('Error :'+errors,'modalAdministracion');
          resolve( {status:0, message:'Error al consumir servicio desagregados'} ) ;
        }
      });
    }

    function destruirFormularioDE( id_formulario ){
      $( id_formulario ).remove();
    }
  
  </script>
  