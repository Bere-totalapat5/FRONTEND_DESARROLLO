  <div class="form-layout">
    <div class="row mg-b-25">
      <div id="tabFracciones" class="col-lg-12" style="padding:2%;">

        <div class="row">
          <div class="title-pane" style=" width:100%; border-bottom:2px solid #848F33; text-align:left; font-size: 0.9em; padding:10px; display: flex;flex-wrap: wrap;">
            <input type="hidden" id="cmp_medidaP_id_acuerdo">
            <div class="col-md-2">
              <div class="form-group text-left">
                <label class="form-control-label">Fecha incio:</label>
                <input type="text" id="cmp_medidaP_fecha_inicio_acuerdo_c" name="cmp_medidaP_fecha_inicio_acuerdo_c" class="form-control cal">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group text-left">
                <label class="form-control-label">Cantidad de dias:</label>
                <div style="display: flex;">
                  <input type="text" id="cmp_medidaP_cantidad_dias_c" name="cmp_medidaP_cantidad_dias_c" class="form-control">
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group text-left">
                <label class="form-control-label">Fecha fin:</label>
                <input type="text" id="cmp_medidaP_fecha_fin_acuerdo_c" name="cmp_medidaP_fecha_fin_acuerdo_c" class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group text-left">
                <label class="form-control-label">Resolución a la solicitud:</label>
                <select class="form-control select2" id="resolucion_solicitud_medidad_c">
                </select>
              </div>
            </div>
            <div class="col-md-2" style="display: flex; justify-content: center; align-items: center;">
              <div class="form-group text-left" style="margin-bottom: 0;">
                <button class="btn btn-primary" id="saveFechas_c"><i class="fas fa-save"></i></button>
              </div>
            </div>
          </div>
        </div>

        <div id="medias_proteccion_menu_promujer_rat_c" style="display: none;">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-" role="tabpanel" aria-labelledby="nav-home-tab">
              <div class="col-lg-12">
                <div style="display: flex; flex-wrap:wrap; justify-content: space-between;">
                  <div class="col-sm-12 col-md-6 col-lg-4 mg-b-2">
                    <select class="form-control" ids_victimas="" id="lista_victimas_c" style="border: none; border-bottom: 1px solid #848F33; border-left: 1px solid #848F33; border-right: 1px solid #848F33;" onchange="listaFracciones(${a.id_audiencia});">
    
                    </select>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-2 mg-b-2">
                    <button type="button" class="btn btn-success" id="checkados_fracc_c" style="background:#848F33 !important; border:none; cursor:pointer;" tipo="" onclick="checkados_fracc_c(${a.id_audiencia})">Guardar Seleccion</button>
                  </div>
                </div>
                <div class="responsive-table mg-t-35" style="padding: 0 2%;">
                  <table id="tablaFracciones_e">
                    <thead>
                      <tr>
                        <th style="font-size: 1.3em; font-weight: bold;"></th>
                        <th style="font-size: 1.3em; font-weight: bold;">Fraccion</th>
                        <th style="font-size: 1.1em; font-weight: bold; text-align:center;">Solicitadas</th>
                        <th style="font-size: 1.1em; font-weight: bold; text-align:center;">Audiencia</th>
                      </tr>
                    </thead>
                    <tbody id="table_fracciones_c">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <style type="text/css" >

    .ui-datepicker-year{
      border: none;
      color: #5B93D3;
      font-weight: 500;
    }
    .ui-datepicker-year:focus{
      outline: none;
    }


  </style>

  <script>
    var fracciones_totales_c = [];

    function limpiarTabFracciones(){
      $('#tabFracciones').html();
    }

    function pintarTabFracciones(){
      let tipo_audiencia = carpetaActiva.tipo_audiencia_inicial;
      let carpeta_judicial_F = carpetaActiva.tipo_audiencia_inicial;
      let victimas_F = carpetaActiva.victimas;
      let id_solicitud_F = carpetaActiva.id_solicitud;
      let id_audiencia_F = null;

      if(tipo_audiencia == 252 || tipo_audiencia == 52){
        $('#medias_proteccion_menu_promujer_rat_c').css('display', 'block');
        listarVictimas_c(victimas_F,id_solicitud_F,id_audiencia_F, tipo_audiencia);
        setTimeout(function(){
          listaFracciones_c(id_audiencia_F,tipo_audiencia);
        },1000);
      }

    }

    // MEDIDAS DE PROTECCION  -- FRACCIONES --
    function listaFracciones_c(id_audiencia_F, tipo_audiencia){
      console.log($('#lista_victimas_c').val());
      
      fracciones_totales_c.splice(0,fracciones_totales_c.length);

      var id_solicitud_F =  $('#lista_victimas_c').attr('id_solicitud');
      var id_persona = $('#lista_victimas_c').val();

      console.log('id_audiencia',id_audiencia_F);

      // Revisar primero por audiencia
      $.ajax({
        type:'POST',
        url:'/public/catalogo_fracciones_solicitud',
        data:{
          id_persona : (id_persona == '' || id_persona == null) ? 0 : id_persona,
          id_solicitud : '',
          id_audiencia: id_audiencia_F
        },
        success:function(response){
          console.log(response);
          $('#table_fracciones_c').html('');

          //Existe un formato de audiencia
          if(response.status == 100){ 
            var html = '';
            var lista = response.response;
            $('#checkados_fracc_c').attr('tipo', 'audiencia');
            $('#checkados_fracc_c').html('Actualizar Seleccion');
            console.log('Con formato de audienca');

            for(i = 0; i < lista.length; i++){
        
              button_show = '';
              checkado_promujer = '';
              checkado_audi = '';
              descripcion = '';

              //Agregamos las fracciones a un array
              fracciones_totales_c.push({
                "id_padre": lista[i].id_padre,            
                "id_cat": lista[i].id_cat,
                "id_fraccion_valor": lista[i].id_audi_fraccion, //id de la medida de proteccion
                "fraccion_valor":lista[i].audi_fraccion_valor,
                "fraccion_descripcion_otros":lista[i].audi_fraccion_descripcion_otros
              });

              if(lista[i].id_cat != 16){
                
                if(lista[i].soli_fraccion_valor == 1){
                  checkado_promujer = `<i style="color: #229954; font-size: 1.4em; background:none;" class="far fa-check-circle"></i>`;
                }else{
                  checkado_promujer = `<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>`;
                }

                if(lista[i].audi_fraccion_valor == 1){
                  checkado_audi = `checked`;
                }else{
                  checkado_audi = ``;
                }

                //switcc
                button_show = `<label class="switch" >
                  <input type="checkbox" ${checkado_audi} id="frac_${lista[i].id_cat}" class="fraccion_checada" value="${lista[i].id_cat}" padre="${lista[i].id_padre}" fraccion="${lista[i].descripcion}"  onchange="fraccion_check_audi_c(this,${lista[i].id_audi_fraccion} ,${lista[i].id_cat})">
                  <span class="slider round"></span>
                </label>`;

                descripcion = lista[i].descripcion;

              }else{
                
                checkado_promujer ='<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>';
                
                if(i == (lista.length - 1)){
                  checkado_promujer =`<button class="addfr"><i class="fa fa-plus" onclick="add_fracc_c(${lista[i].id_cat}, ${lista[i].id_padre}, ${lista[i].id_audi_fraccion}, 'audiencia')"></i></button>`;
                }

                if(lista[i].audi_fraccion_valor == 1){
                  checkado_audi = `checked`;
                }else{
                  checkado_audi = ``;
                }

                descripcion = lista[i].audi_fraccion_descripcion_otros;
                
                button_show = `<label class="switch" >
                  <input type="checkbox" ${checkado_audi} id="frac_${lista[i].id_cat}" class="fraccion_checada" value="${lista[i].id_cat}" padre="${lista[i].id_padre}" fraccion="${lista[i].descripcion}"  onchange="fraccion_check_audi_c(this,${lista[i].id_audi_fraccion} ,${lista[i].id_cat})">
                  <span class="slider round"></span>
                </label>`;
                //button_show =  
              }

              //quitar el if en caso de mostrar las hipotesis
              if(lista[i].id_padre == 0){
                //cuerpo de la tabla
                html += `<tr>
                  <td style="min-width: 5%; text-align:center; border: 1px solid #eee; color: #848F33;;font-weight: bold;font-size: 1.2em;">${lista[i].id_padre == 0 ? lista[i].fraccion : '' }</td>
                  <td style="min-width: 80%; text-align:justify; border-bottom: 1px solid #eee; padding:1px 1%; font-size: 0.9em;">${descripcion == null ? 'Sin Titulo' : descripcion}</td>
                  <td style="min-width: 5%; border-left: 1px solid #eee; display: table-cell; justify-content: center; padding: 1% 1%; align-items: center;">
                    ${checkado_promujer} 
                  </td>
                  <td style="min-width: 5%; border-left: 1px solid #eee; display: table-cell; justify-content: center; padding: 1% 1%; align-items: center;">
                    ${button_show}
                  </td>
                </tr>`;
              }
              
            }
            
            $('#table_fracciones_c').html(html); //Caso de Audiencia

          }else{
            console.log('Con formato de solicitud');
            // En caso de que no tenga El formato de Audiencia Se ocupa el formato de la solicitud
            $.ajax({
              type:'POST',
              url:'/public/catalogo_fracciones_solicitud',
              data:{
                id_audiencia: '',
                id_persona : id_persona,
                id_solicitud : id_solicitud_F
              },
              success:function(response){
                
                console.log(response);
                $('#table_fracciones_c').html('');
        
                if(response.status == 100){
                  var html = '';
                  var lista = response.response;
                  $('#checkados_fracc_c').attr('tipo', 'solicitud');
                  $('#checkados_fracc_c').html('Guardar Seleccion');
                  var ids_vic = $('#lista_victimas_c').attr('ids_victimas');
                  var ids_victimas = ids_vic.split(',');

                  for(m in ids_victimas){
                    for(n = 0; n < lista.length; n++){
                      //Agregamos las fracciones a un array
                      fracciones_totales_c.push({
                        "id_persona":ids_victimas[m],              
                        "id_fraccion": lista[n].id_cat,
                        "valor_solicitado":'0',
                        "descripcion_otros":'-',
                        "fraccion": lista[n].fraccion,
                        "id_padre": lista[n].id_padre
                      });
                    }
                  }

                  for(i = 0; i < lista.length; i++){
              
                    button_show = '';
                    checkado_promujer = '';

                    if(lista[i].id_cat != 16){
                
                      if(lista[i].soli_fraccion_valor == 1){
                        checkado_promujer = `<i style="color: #229954; font-size: 1.4em; background:none;" class="far fa-check-circle"></i>`;
                      }else{
                        checkado_promujer = `<i style="color: #c0b5b4c4; font-size: 1.4em; background:none;" class="fas fa-minus"></i>`;
                      }
        
                      //switcc
                      button_show = `<label class="switch" >
                        <input type="checkbox" id="frac_${lista[i].id_cat}" class="fraccion_checada" value="${lista[i].id_cat}" fraccion="${lista[i].fraccion}" padre="${lista[i].id_padre}" onchange="fraccion_check_c(this, ${id_persona},${lista[i].id_cat})">
                        <span class="slider round"></span>
                      </label>`;
        
                    }else{
                      checkado_promujer ='';
                      button_show = `<button class="addfr"><i class="fa fa-plus" onclick="add_fracc_c(${lista[i].id_cat}, ${lista[i].id_padre}, ${id_persona}, 'solicitud')"></i></button>`;
                    }
        
                    //quitar el if en caso de mostrar las fracciones
                    if(lista[i].id_padre == 0){
                      html += `<tr>
                        <td style="min-width: 5%; text-align:center; border: 1px solid #eee; color: #848F33;;font-weight: bold;font-size: 1.2em;">${lista[i].id_padre == 0 ? lista[i].fraccion : '' }</td>
                        <td style="min-width: 80%; text-align:justify; border-bottom: 1px solid #eee; padding:1px 1%; font-size: 0.9em;">${lista[i].descripcion}</td>
                        <td style="min-width: 5%; border-left: 1px solid #eee; display: table-cell; justify-content: center; padding: 1% 1%; align-items: center;">
                          ${checkado_promujer} 
                        </td>
                        <td style="min-width: 5%; border-left: 1px solid #eee; display: table-cell; justify-content: center; padding: 1% 1%; align-items: center;">
                          ${button_show}
                        </td>
                      </tr>`;
                    }
                      
                  }

                }else{
                  html += `<tr>
                    <td style="min-width: 95%; text-align:left;">No se Encontraron resultados</td>
                    <td style="min-width: 5%; border-left: 1px solid #eee;">
                      <label class="switch">
                        <input type="checkbox" disabled>
                        <span class="slider round"></span>
                      </label>
                    </td>
                  </tr>`;
                }

                $('#table_fracciones_c').html(html); //Caso de solicitud
              }
            });
            
          }
        }
      });
    }

    function listarVictimas_c(victimas_F,id_solicitud_F, id_audiencia_F,tipo_audiencia ){
      console.log('Victimas a listar', victimas_F);

      $('#lista_victimas_c').attr('id_solicitud',id_solicitud_F);

      let victima = '<option value="0">Selecciona una opción</option>';
      var active = '';
      var ids_victimas = [];
      //var style = 'border-radius: 4px 4px 0px 0px; font-size: 0.7em; text-align: center; cursor: pointer; height: 36px; border:1px solid #848F33;';
      //var id_trigger = '';
      for(i in victimas_F){

        if(i == 0){
          active = 'selected';
        }else{
          active = '';
        }
        ids_victimas.push(victimas_F[i].id_persona);
        victima += `<option ${active} value="${victimas_F[i].id_persona}" solicitud="${id_solicitud_F}" audiencia="${id_audiencia_F}" >${victimas_F[i].tipo == 'fisica' ? victimas_F[i].nombre : victimas_F[i].razon_social}</option>`;
      }

      $('#lista_victimas_c').attr('ids_victimas',ids_victimas);
      $('#lista_victimas_c').html(victima);
      
      //### Aqui se agrega la opcion de campos
      obtener_fecha_acuerdo_c(carpetaActiva.id_solicitud,tipo_audiencia);

    }

    function obtener_fecha_acuerdo_c(id_solicitud,tipo_audiencia){

      $.ajax({
        type:'GET',
        url:'/public/obtener_fecha_acuerdo_c',
        data:{
          id_solicitud: id_solicitud
        },
        success:function(response){
      
          console.log(response);
  
          if(response.status == 100){
            $('#cmp_medidaP_fecha_inicio_acuerdo_c').val(`${response.response.fecha_firma ?? ""}`);
            $('#cmp_medidaP_fecha_fin_acuerdo_c').val(`${response.response.fecha_fin_medida_proteccion ?? ""}`);

            $('#cmp_medidaP_id_acuerdo').val(`${response.response.id_acuerdo}`);
            $('#cmp_medidaP_cantidad_dias_c').val(response.response.cantidad_dias);

            if(tipo_audiencia == 52){
              $('#resolucion_solicitud_medidad_c').html(`
                <option seleted value="-">Selecciona una opcion</option>
                <option ${response.response.resolucion_solicitud == 0 ? 'selected': ''} value="0">Negada</option>
                <option ${response.response.resolucion_solicitud == 1 ? 'selected': ''} value="1">Ratificada</option>
                <option ${response.response.resolucion_solicitud == 2 ? 'selected': ''} value="2">No Ratificada</option>
                <option ${response.response.resolucion_solicitud == 3 ? 'selected': ''} value="3">Sin materia</option>
                <option ${response.response.resolucion_solicitud == 4 ? 'selected': ''} value="4">Desistida</option>
                <option ${response.response.resolucion_solicitud == 5 ? 'selected': ''} value="5">Solicitada</option>
                <option ${response.response.resolucion_solicitud == 6 ? 'selected': ''} value="6">Otro</option>
              `);
            }else{
              $('#resolucion_solicitud_medidad_c').html(`
                <option seleted value="">Selecciona una opcion</option>
                <option ${response.response.resolucion_solicitud == 0 ? 'selected': ''} value="0">Negada</option>
                <option ${response.response.resolucion_solicitud == 1 ? 'selected': ''} value="1">Concedida</option>
              `);
            }

          }else{
            $('#cmp_medidaP_fecha_inicio_acuerdo_c').val(response.response);

            if(tipo_audiencia == 52){
              $('#resolucion_solicitud_medidad_c').html(`
                <option seleted value="-">Selecciona una opcion</option>
                <option value="0">Negada</option>
                <option value="1">Ratificada</option>
                <option value="2">No Ratificada</option>
                <option value="3">Sin materia</option>
                <option value="4">Desistida</option>
                <option value="5">Solicitada</option>
                <option value="6">Otro</option>
              `);
            }else{
              $('#resolucion_solicitud_medidad_c').html(`
                <option seleted value="-">Selecciona una opcion</option>
                <option value="0">Negada</option>
                <option value="1">Concedida</option>
              `);
            }
          }

          setTimeout(function(){

            $('#saveFechas_c').click(function(){
              var cantidad_dias =  $('#cmp_medidaP_cantidad_dias_c').val();
              var fecha_fin =  $('#cmp_medidaP_fecha_fin_acuerdo_c').val();
              var resolucion_solicitud_medidad_c = $('#resolucion_solicitud_medidad_c').val();
              var id_acuerdo = $('#cmp_medidaP_id_acuerdo').val();

              $.ajax({
                type:'post',
                url:'/public/guardarFechas_rat',
                data:{
                  "cantidad_dias": cantidad_dias,
                  "fecha_fin": fecha_fin,
                  "id_acuerdo": id_acuerdo,
                  "resolucion_solicitud_medidad_c": resolucion_solicitud_medidad_c
                },
                success:function(response) {
                  console.log(response);
                  if(response.status==100){
                    $('#modalMedidasProteccion').modal('hide');
                    var exito = "<p class='mg-b-20 mg-x-20'>"+response.response+"</p>";
                    modal_success(exito,'modalHistory');
                  }else{
                    var error = "<p class='mg-b-20 mg-x-20'>"+response.response+"</p>";
                    modal_error(error,'modalHistory');
                  }
                }
              });
            });

            $('#cmp_medidaP_cantidad_dias_c').on('input', function () { 
              this.value = this.value.replace(/[^0-9]/g,'');
            });

            let fecha_actual = new Date();
            $('.cal').datepicker({
              showOtherMonths: true,
              selectOtherMonths: true,
              dateFormat: 'yy-mm-dd',
              changeYear: true,
              yearRange: "c-100:" + (fecha_actual.getFullYear() + 5)
            });

            $('#resolucion_solicitud_medidad_c').select2();

            $('#cmp_medidaP_cantidad_dias_c').change(function(){
              let resultado = '';
              let cantidad = $(this).val();
              $('#cmp_medidaP_fecha_fin_acuerdo_c').val('');
              resultado = moment($('#cmp_medidaP_fecha_inicio_acuerdo_c').val()).add(cantidad, 'd').format("YYYY-MM-DD");
              $('#cmp_medidaP_fecha_fin_acuerdo_c').val(resultado);
            });

          },500);

        }
      });
    }

    function add_fracc_c(id_cat, id_padre, id_persona_audi_fraccion, tipo){

      if(tipo == 'solicitud'){
        if($('.boton_quitar_remove').length > 0){
          indice = 0;
        }else{
          indice = id_persona_audi_fraccion;
        }

        tr = `
          <tr>
            <td style="min-width: 3%; text-align:center; border: 1px solid #eee; color: #848f3363;font-weight: bold;font-size: 1.4em;">
              <i class="fa fa-times-circle boton_quitar_remove" title="Quitar filas" onclick="removeRow_c(this,${indice},${id_cat})"></i>
            </td>
            <td style="min-width: 82%; text-align:justify; border-bottom: 1px solid #eee; padding:0 1%;"><input type="text" class="fraccion16 fr"></td>
            <td style="min-width: 5%; border-left: 1px solid #eee;">
            </td>
            <td style="min-width: 5%; border-left: 1px solid #eee;">
              <label class="switch">
                <input type="checkbox" id="frac_${id_cat}" class="fraccion_checada" value="${id_cat}" fraccion="otros" padre="${id_padre}" onchange="fraccion_check_c(this, ${id_persona_audi_fraccion},${id_cat})">
                <span class="slider round"></span>
              </label>
            </td>
          </tr>
        `;
      }else{
        var indice = '';
        if($('.boton_quitar_remove').length > 0){
          indice = 0;
        }else{
          indice = id_persona_audi_fraccion;
        }

        tr = `
          <tr>
            <td style="min-width: 3%; text-align:center; border: 1px solid #eee; color: #075576;font-weight: bold;font-size: 1.4em;">
              <i class="fa fa-times-circle boton_quitar_remove" title="Quitar filas" onclick="removeRow_c(this,${indice},${id_cat})"></i>
            </td>
            <td style="min-width: 82%; text-align:justify; border-bottom: 1px solid #eee; padding:0 1%;"><input type="text" class="fraccion16 fr"></td>
            <td style="min-width: 5%; border-left: 1px solid #eee;">
            </td>
            <td style="min-width: 5%; border-left: 1px solid #eee;">
              <label class="switch">
                <input type="checkbox" id="frac_${id_cat}" class="fraccion_checada" value="${id_cat}" fraccion="otros" padre="${id_padre}" onchange="fraccion_check_audi_c(this, ${id_persona_audi_fraccion},${id_cat})">
                <span class="slider round"></span>
              </label>
            </td>
          </tr>
        `;
      }

      $('#table_fracciones_c').append(tr);
    }
    
    function removeRow_c(obj,id_audi_fraccion, id_fraccion){

      if(id_audi_fraccion == 0 && id_fraccion == 16){
        fracciones_totales_c.pop()
      }else{
        for(i in fracciones_totales_c){
          if(fracciones_totales_c[i].id_cat == id_fraccion && fracciones_totales_c[i].id_fraccion_valor == id_audi_fraccion){
            fracciones_totales_c[i].fraccion_valor = 0;
            fracciones_totales_c[i].fraccion_descripcion_otros = null;
          }
        } 
      }

      $(obj).closest('tr').remove();
      console.log(fracciones_totales_c);
    }
    
    
    //Guardar o Actualizar informacion 
    function checkados_fracc_c(id_audiencia){
      var tipo = $('#checkados_fracc_c').attr('tipo');
      var id_persona = $('#lista_victimas_c').val();

      if(tipo == 'solicitud'){
        $.ajax({
          type:'post',
          url:'/public/guardar_fracciones_audiencia_f',
          data:{
            "id_audiencia": id_audiencia,
            "tipo":tipo,
            "fracciones": fracciones_totales_c
          },
          success:function(response) {
            console.log(response);
            if(response.status==100){
              $('#modalMedidasProteccion').modal('hide');
              var exito = "<p class='mg-b-20 mg-x-20'>Fracciones Agregadas Exitosamente</p>";
              modal_success(exito,'modalHistory');
              listaFracciones(id_audiencia);
            }else{
              var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
              modal_error(error,'modalHistory');
            }
          }
        });
      }else{
        $.ajax({
          type:'post',
          url:'/public/guardar_fracciones_audiencia_f',
          data:{
            "id_audiencia": id_audiencia,
            "tipo":tipo,
            "id_persona":id_persona,
            "fracciones": fracciones_totales_c
          },
          success:function(response) {
            console.log(response);
            if(response.status==100){
              $('#modalMedidasProteccion').modal('hide');
              var exito = "<p class='mg-b-20 mg-x-20'>Fracciones Actualizadas Exitosamente</p>";
              modal_success(exito,'modalHistory');
              listaFracciones(id_audiencia);
            }else{
              var error = "<p class='mg-b-20 mg-x-20'>"+response.message+"</p>";
              modal_error(error,'modalHistory');
            }
          }
        });
      }
      console.log('Fracciones a guardar',fracciones_totales_c);
    }

    //Acciones de los check segun el tipo de formato
    function fraccion_check_audi_c(obj,id_audi_fraccion, id_fraccion){
      var valor_solicitado = '';
      var id_padre = '';

      if($(obj).attr('padre') == 0){

        //valor solicitado
        if($(obj).is(':checked')){
          valor_solicitado = '1';
        }else{
          valor_solicitado = '0';
        }
        
        //accion para agregar el valor a padre e hijos
        if(valor_solicitado == '1'){  //agregar valor

          for(i in fracciones_totales_c){
            // padre
            if(fracciones_totales_c[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales_c[i].id_cat == id_fraccion){
              if(id_fraccion == 16){
                if(fracciones_totales_c[i].fraccion_valor == '1'){
                  fracciones_totales_c.push({
                    "id_padre":fracciones_totales_c[i].id_padre,
                    "id_cat":fracciones_totales_c[i].id_cat,
                    "id_fraccion_valor":0,
                    "fraccion_valor":valor_solicitado,
                    "fraccion_descripcion_otros": $('.fr:last').val()
                  })
                }else{
                  fracciones_totales_c[i].fraccion_valor = valor_solicitado;
                  fracciones_totales_c[i].fraccion_descripcion_otros = $('.fr:last').val();
                }
              }else{
                fracciones_totales_c[i].fraccion_valor = valor_solicitado;
              }
            }

            //hijos
            if(fracciones_totales_c[i].id_padre == id_fraccion){
              fracciones_totales_c[i].fraccion_valor = valor_solicitado;
              $('#frac_'+fracciones_totales_c[i].id_cat).prop('checked',true);
            }

          }
        }else{ //quitar valor

          for(i in fracciones_totales_c){
            // padre
            if(fracciones_totales_c[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales_c[i].id_cat == id_fraccion){
              fracciones_totales_c[i].fraccion_valor = valor_solicitado;
            }

            //hijos
            if(fracciones_totales_c[i].id_padre == id_fraccion){
              fracciones_totales_c[i].fraccion_valor = valor_solicitado;
              $('#frac_'+fracciones_totales_c[i].id_cat).prop('checked',false);
            }

          }
        }

      }else{
        id_padre = $(obj).attr('padre');

        if($(obj).is(':checked')){
          valor_solicitado = '1';
        }else{
          valor_solicitado = '0';
        }

        if(valor_solicitado == '1'){
          for(i in fracciones_totales_c){
            // padre
            if(fracciones_totales_c[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales_c[i].id_cat == id_padre){
              fracciones_totales_c[i].fraccion_valor = valor_solicitado;
              $('#frac_'+fracciones_totales_c[i].id_padre).prop('checked',true);
            }

            //hijos
            if(fracciones_totales_c[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales_c[i].id_padre == id_fraccion){
              fracciones_totales_c[i].fraccion_valor = valor_solicitado;
            }
          }
        }else if(valor_solicitado == '0'){
          for(i in fracciones_totales_c){
            //hijos
            if(fracciones_totales_c[i].id_fraccion_valor == id_audi_fraccion && fracciones_totales_c[i].id_cat == id_fraccion){
              fracciones_totales_c[i].fraccion_valor = valor_solicitado;
            }
          }
        }

      }

      console.log(fracciones_totales_c)
    }

    function fraccion_check_c(obj,id_persona, id_fraccion){
      var valor_solicitado = '';
      var id_padre = '';

      if($(obj).attr('padre') == 0){

        if($(obj).is(':checked')){
          valor_solicitado = '1';
        }else{
          valor_solicitado = '0';
        }
        
        if(valor_solicitado == '1'){ //agregar valor

          for(i in fracciones_totales_c){
            // padre
            if(fracciones_totales_c[i].id_persona == id_persona && fracciones_totales_c[i].id_fraccion == id_fraccion){
              if(id_fraccion == 16){
                if(fracciones_totales_c[i].valor_solicitado == '1'){
                  fracciones_totales_c.push({
                    "id_persona":id_persona,              
                    "id_fraccion": id_fraccion,
                    "valor_solicitado":valor_solicitado,
                    "descripcion_otros":$('.fr:last').val(),
                    "fraccion": fracciones_totales_c[i].fraccion,
                    "id_padre": fracciones_totales_c[i].id_padre
                  })
                }else{
                  fracciones_totales_c[i].valor_solicitado = valor_solicitado;
                  fracciones_totales_c[i].descripcion_otros = $('.fr:last').val();
                }
              }else{
                fracciones_totales_c[i].valor_solicitado = valor_solicitado;
              }
            }

            //hijos
            if(fracciones_totales_c[i].id_persona == id_persona && fracciones_totales_c[i].id_padre == id_fraccion){
              fracciones_totales_c[i].valor_solicitado = valor_solicitado;
              $('#frac_'+fracciones_totales_c[i].id_fraccion).prop('checked',true);
            }

          }
        }else{

          for(i in fracciones_totales_c){
            // padre
            if(fracciones_totales_c[i].id_persona == id_persona && fracciones_totales_c[i].id_fraccion == id_fraccion){
              fracciones_totales_c[i].valor_solicitado = valor_solicitado;
            }

            //hijos
            if(fracciones_totales_c[i].id_persona == id_persona && fracciones_totales_c[i].id_padre == id_fraccion){
              fracciones_totales_c[i].valor_solicitado = valor_solicitado;
              $('#frac_'+fracciones_totales_c[i].id_fraccion).prop('checked',false);
            }

          }
        }

      }else{
        id_padre = $(obj).attr('padre');

        if($(obj).is(':checked')){
          valor_solicitado = '1';
        }else{
          valor_solicitado = '0';
        }

        if(valor_solicitado == '1'){
          for(i in fracciones_totales_c){
            // padre
            if(fracciones_totales_c[i].id_persona == id_persona && fracciones_totales_c[i].id_fraccion == id_padre){
              fracciones_totales_c[i].valor_solicitado = valor_solicitado;
              $('#frac_'+fracciones_totales_c[i].id_padre).prop('checked',true);
            }

            //hijos
            if(fracciones_totales_c[i].id_persona == id_persona && fracciones_totales_c[i].id_padre == id_fraccion){
              fracciones_totales_c[i].valor_solicitado = valor_solicitado;
            }
          }
        }else if(valor_solicitado == '0'){
          for(i in fracciones_totales_c){
            //hijos
            if(fracciones_totales_c[i].id_persona == id_persona && fracciones_totales_c[i].id_fraccion == id_fraccion){
              fracciones_totales_c[i].valor_solicitado = valor_solicitado;
            }
          }
        }

      }

      console.log(fracciones_totales_c)
    }

  </script>
