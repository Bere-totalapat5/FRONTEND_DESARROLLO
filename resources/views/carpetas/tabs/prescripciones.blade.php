{{-- PRESCRIPCIONES--}}

  <div class="form-layout">
    <div class="row mg-b-25 mg-t-25">

      {{-- SECCION TABLA PRESCRIPCIONES --}}
      <div class="col-lg-12">
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; padding: 2px; align-items:center;">
          <h5 class="form-control-label" style="margin-bottom:0;">Prescripciones</h5>
          <button class="btn btn-success" id="btn-agregarPrescripcion-P" style="border:none; background: #848f33; color:#fff;" data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance2" aria-expanded="false" aria-controls="collapseSearchAdvance2">Agregar Prescripción</button>
        </div>
        <hr/>
        <div class="row" id="divAudiencias">
          <div class="col-lg-12">

            {{-- Agregar preescripcion --}}
            <div id="accordion" class="accordion-one mg-b-15" role="tablist" aria-multiselectable="true">
              <div class="card" style="border:none;">
                <div id="collapseSearchAdvance2" class="collapse" role="tabpanel" aria-labelledby="headingOne" style="border:1px solid #848f33; padding: 4px;" >
                    <div class="card-header" style="background: #848f33; color:#fff; font-size: 1.1em; font-weight: bold; text-align:center; padding: 10px 0; margin-bottom: 1%;">
                      Nueva Prescripción
                    </div>
                    <div class="card-body" style="padding:0px !important">

                      <form id="frm_prescripcion">

                        {{--  Formulario de la busqueda avanzada --}}
                        <div class="row mg-b-4 pad">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label  for="pre_imputado">Imputado/Sentenciado:</label>
                                <select name="" id="pre_imputado" class="form-control select2" onchange="obtenerPena(this)">
                                  <option value="" selected>Seleccione una opción</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="pre_pena">Pena:</label>
                              <select name="" id="pre_pena" class="form-control select2" onchange="mostrarPanel('pre_pena')">
                                <option value="" selected>Seleccione una opción</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row mg-b-4 pad">
                          <div class="col-md-12 col-md-6 col-lg-7 mg-b-50">
                            <div class="contenedor-puni">
                              <div style="background: #848f33; color: #fff; text-align: center; padding: 2px; width: 265px; border-radius: 0 17px 0 0;">
                                Abono prisión punitiva
                              </div>
                              <div style="border: 1px solid #ccc;">
                                <div style="display: flex; justify-content: center; flex-wrap: wrap; margin: 2% 0 0 0;">
                                  <div class="form-group">
                                    <label for="anios_abono_puni">Años</label>
                                    <input type="number" class="form-control" min="0" id="anios_abono_puni" max="100" placeholder="0" onchange="restar(this, 'anios_por_cumplir')">
                                  </div>
                                  <div class="form-group">
                                    <label for="meses_abono_puni">Meses</label>
                                    <input type="number" class="form-control" min="0" id="meses_abono_puni" max="12" placeholder="0" onchange="restar(this, 'meses_por_cumplir')">
                                  </div>
                                  <div class="form-group">
                                    <label for="dias_abono_puni">Dias</label>
                                    <input type="number" class="form-control" min="0" id="dias_abono_puni" max="366" placeholder="0" onchange="restar(this, 'dias_por_cumplir')">
                                  </div>
                                </div>
                                <div style="padding: 8px">
                                  <div class="form-group">
                                    <label for="">Comentarios prisión punitiva:</label>
                                    <textarea name="comentarios_prision_punitiva" id="comentarios_prision_punitiva" style="width: 100%" rows="5"></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-12 col-md-6 col-lg-5 mg-b-50">
                            <div class="contenedor-prev">
                              <div style="background: #848f33; color: #fff; text-align: center; padding: 2px; width: 265px; border-radius: 0 17px 0 0;">
                                Abono prisión preventiva 
                              </div>
                              <div style="border: 1px solid #ccc;">
                                <div style="display: flex; justify-content: center; flex-wrap: wrap; margin: 2% 0 0 0;">
                                  <div class="form-group">
                                    <label for="anios_abono_prev">Años</label>
                                    <input type="number" class="form-control" min="0" max="100" id="anios_abono_prev" placeholder="0" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="meses_abono_prev">Meses</label>
                                    <input type="number" class="form-control" min="0" max="12" id="meses_abono_prev" placeholder="0" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="dias_abono_prev">Dias</label>
                                    <input type="number" class="form-control" min="0" max="366" id="dias_abono_prev"  placeholder="0" readonly>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div id="pena_por_cumplir" class="contenedor-prev" style="margin-top:57px; display:none;">
                              <div style="background: #848f33; color: #fff; text-align: center; padding: 2px; width: 265px; border-radius: 0 17px 0 0;">
                                Pena por complir
                              </div>
                              <div style="border: 1px solid #ccc;">
                                <div style="display: flex; justify-content: center; flex-wrap: wrap; margin: 2% 0 0 0;">
                                  <div class="form-group">
                                    <label for="anios_abono_prev">Años</label>
                                    <input type="number" class="form-control" min="0" max="100" id="anios_por_cumplir" placeholder="0" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="meses_abono_prev">Meses</label>
                                    <input type="number" class="form-control" min="0" max="12" id="meses_por_cumplir" placeholder="0" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="dias_abono_prev">Dias</label>
                                    <input type="number" class="form-control" min="0" max="366" id="dias_por_cumplir"  placeholder="0" readonly>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row mg-b-4 pad">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="fecha_sustraccion">Fecha de sustraccion del imputado/sentenciado:</label>
                              <input type="text" id="fecha_sustraccion" class="form-control datepicker">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="fecha_u_acto">Fecha de último acto de la autoridad:</label>
                              <input type="text" id="fecha_u_acto" class="form-control datepicker">
                            </div>
                          </div>
                        </div>

                        <div class="row mg-b-4 pad">
                          <div class="col-md-8">
                            <div class="form-group">
                              <label  for="vive_ciudad_mexico">¿El imputado/sentenciado se encuentra en la Ciudad de México?:</label>
                              <select name="" id="vive_ciudad_mexico" class="form-control">
                                <option value="" selected>Seleccione una opción</option>
                                <option value="1" >Si</option>
                                <option value="0" >No</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label  for="fecha_prescripcion">Fecha de prescripción:</label>
                              <input type="text" id="fecha_prescripcion" class="form-control datepicker" required>
                            </div>
                          </div>
                        </div>

                      </form>  

                        {{--  Boton para filtrar  --}}
                      <div class="row justify-content-center mt-4">
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10" onclick="guardarPrescripcion();">Guardar</button>
                        </div>
                        <div class="col-lg-2">
                          <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10"  id="cancelarPrescripcion" data-toggle="collapse" data-parent="#accordion" href="#collapseSearchAdvance2" aria-expanded="false" aria-controls="collapseSearchAdvance2" onclick="resetform('frm_prescripcion');">Cancelar</button>
                        </div>
                      </div>

                    </div>
                </div>
              </div>
            </div>

            {{-- Editar preescripcion --}}
            <div id="accordionEditar" class="accordion-one mg-b-15" role="tablist" aria-multiselectable="true">
              <div class="card" style="border:none;">
                <div id="collapseSearchAdvance3" class="collapse" role="tabpanel" aria-labelledby="headingOne" style="border:1px solid #848f33; padding: 4px;" >
                    <div class="card-header" style="background: #f5755a; color:#fff; font-size: 1.1em; font-weight: bold; text-align:center; padding: 10px 0; margin-bottom: 1%;">
                      Editar Prescripción
                    </div>
                    <div class="card-body" style="padding:0px !important">

                      <form id="frm_prescripcion_Edit">

                        {{--  Formulario de la busqueda avanzada --}}
                        <div class="row mg-b-4 pad">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label  for="pre_imputado_e">Imputado/Sentenciado:</label>
                                <select name="" id="pre_imputado_e" class="form-control select2" onchange="obtenerPena(this)">
                                  <option value="" selected>Seleccione una opción</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="pre_pena_e">Pena:</label>
                              <select name="" id="pre_pena_e" class="form-control select2" onchange="mostrarPanel('pre_pena')">
                                <option value="" selected>Seleccione una opción</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row mg-b-4 pad">
                          <div class="col-md-12 col-md-6 col-lg-7 mg-b-50">
                            <div class="contenedor-puni">
                              <div style="background: #848f33; color: #fff; text-align: center; padding: 2px; width: 265px; border-radius: 0 17px 0 0;">
                                Abono prisión punitiva
                              </div>
                              <div style="box-shadow: 0px 7px 12px -3px #ccc;">
                                <div style="display: flex; justify-content: center; flex-wrap: wrap; margin: 2% 0 0 0;">
                                  <div class="form-group">
                                    <label for="anios_abono_puni">Años</label>
                                    <input type="number" class="form-control" id="anios_abono_puni_e" max="100" placeholder="Años">
                                  </div>
                                  <div class="form-group">
                                    <label for="meses_abono_puni">Meses</label>
                                    <input type="number" class="form-control" id="meses_abono_puni_e" max="12" placeholder="Meses">
                                  </div>
                                  <div class="form-group">
                                    <label for="dias_abono_puni">Dias</label>
                                    <input type="number" class="form-control" id="dias_abono_puni_e" max="366" placeholder="Dias">
                                  </div>
                                </div>
                                <div style="padding: 8px">
                                  <div class="form-group">
                                    <label for="">Comentarios prisión punitiva:</label>
                                    <textarea name="comentarios_prision_punitiva" id="comentarios_prision_punitiva_e" style="width: 100%" rows="5"></textarea>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                          
                          <div class="col-md-12 col-md-6 col-lg-5 mg-b-50">
                            <div class="contenedor-prev">
                              <div style="background: #848f33; color: #fff; text-align: center; padding: 2px; width: 265px; border-radius: 0 17px 0 0;">
                                Abono prisión preventiva 
                              </div>
                              <div style="display: flex; justify-content: center; flex-wrap: wrap; margin: 2% 0 0 0; box-shadow: 0px 7px 12px -3px #ccc;">
                                <div class="form-group">
                                  <label for="anios_abono_prev">Años</label>
                                  <input type="number" class="form-control" max="100" id="anios_abono_prev_e" placeholder="Años">
                                </div>
                                <div class="form-group">
                                  <label for="meses_abono_prev">Meses</label>
                                  <input type="number" class="form-control" max="12" id="meses_abono_prev_e" placeholder="Meses">
                                </div>
                                <div class="form-group">
                                  <label for="dias_abono_prev">Dias</label>
                                  <input type="number" class="form-control" max="366" id="dias_abono_prev_e"  placeholder="Dias">
                                </div>
                              </div>
                            </div>

                            <div id="pena_por_cumplir_e" class="contenedor-prev" style="margin-top:57px; display:none;">
                              <div style="background: #848f33; color: #fff; text-align: center; padding: 2px; width: 265px; border-radius: 0 17px 0 0;">
                                Pena por complir
                              </div>
                              <div style="border: 1px solid #ccc;">
                                <div style="display: flex; justify-content: center; flex-wrap: wrap; margin: 2% 0 0 0;">
                                  <div class="form-group">
                                    <label for="anios_abono_prev">Años</label>
                                    <input type="number" class="form-control" min="0" max="100" id="anios_por_cumplir_e" placeholder="0" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="meses_abono_prev">Meses</label>
                                    <input type="number" class="form-control" min="0" max="12" id="meses_por_cumplir_e" placeholder="0" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label for="dias_abono_prev">Dias</label>
                                    <input type="number" class="form-control" min="0" max="366" id="dias_por_cumplir_e"  placeholder="0" readonly>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row mg-b-4 pad">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="fecha_sustraccion">Fecha de sustraccion del imputado/sentenciado:</label>
                              <input type="text" id="fecha_sustraccion_e" class="form-control datepicker">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label  for="fecha_u_acto">Fecha de último acto de la autoridad:</label>
                              <input type="text" id="fecha_u_acto_e" class="form-control datepicker">
                            </div>
                          </div>
                        </div>

                        <div class="row mg-b-4 pad">
                          <div class="col-md-8">
                            <div class="form-group">
                              <label  for="vive_ciudad_mexico">¿El imputado/sentenciado se encuentra en la Ciudad de México?:</label>
                              <select name="" id="vive_ciudad_mexico_e" class="form-control">
                                <option value="" selected>Seleccione una opción</option>
                                <option value="1" >Si</option>
                                <option value="0" >No</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label  for="fecha_prescripcion">Fecha de prescripción:</label>
                              <input type="text" id="fecha_prescripcion_e" class="form-control datepicker" required>
                            </div>
                          </div>
                        </div>

                      </form>  

                        {{--  Boton para filtrar  --}}
                      <div class="row justify-content-center mt-4">
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10"  id="editarPrescripcion">Actualizar</button>
                        </div>
                        <div class="col-lg-2">
                          <button type="button" class="btn btn-primary btn-sm btn-block mg-b-10"  id="cancelarPrescripcion_e" data-toggle="collapse" data-parent="#accordionEditar" href="#collapseSearchAdvance3" aria-expanded="false" aria-controls="collapseSearchAdvance3" onclick="resetform('frm_prescripcion_Edit')">Cancelar</button>
                        </div>
                      </div>

                    </div>
                </div>
              </div>
            </div>
            

            {{-- <div class="pagination-wrapper justify-content-between">
              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link primera-A" href="javascript:void(0)" aria-label="Last" onclick="pintarAudiencias(1)">
                    <i class="fa fa-angle-double-left"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link anterior-A" href="javascript:void(0)" aria-label="Next" onclick="pintarAudiencias(1)">
                    <i class="fa fa-angle-left"></i>
                  </a>
                </li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">Página <span class="pagina-A">1</span> de <span class="total-paginas-A">1</span></li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link siguiente-A" href="javascript:void(0)" aria-label="Next" onclick="pintarAudiencias(1)">
                    <i class="fa fa-angle-right"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link ultima-A" href="javascript:void(0)" aria-label="Last" onclick="pintarAudiencias(1)">
                    <i class="fa fa-angle-double-right"></i>
                  </a>
                </li>
              </ul>
            </div> --}}

            <div class="table-responsive mg-y-20">
              <table id="tablePrescripciones" class="display dataTable dtr-inline collapsed">
                <thead style="background-color: #EBEEF1; color: #444;">
                  <tr>
                    <th  style="min-width:60px; font-size:0.9em;">Acciones</th>
                    <th  style="min-width:150px; font-size:0.9em;">Fecha de registro</th>
                    <th  style="min-width:150px; font-size:0.9em;">Imputado /Sentenciado</th>
                    <th  style="min-width:100px; font-size:0.9em;">Fecha de prescripción</th>
                    <th  style="min-width:280px; font-size:0.9em;">Situación de prescripción</th>
                    <th  style="min-width:280px; font-size:0.9em;">Comentarios</th>
                  </tr>
                </thead>
                <tbody id="table-prescripciones">
                  <tr>
                    <th colspan="6" style="text-align: center;">
                      No se encontraron datos relacionados
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>


            <div class="pagination-wrapper justify-content-between">
              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link primera-A" href="javascript:void(0)" aria-label="Last" onclick="pintarAudiencias(1)">
                    <i class="fa fa-angle-double-left"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link anterior-A" href="javascript:void(0)" aria-label="Next" onclick="pintarAudiencias(1)">
                    <i class="fa fa-angle-left"></i>
                  </a>
                </li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">Página <span class="pagina-A">1</span> de <span class="total-paginas-A">1</span></li>
              </ul>

              <ul class="pagination mg-b-0">
                <li class="page-item">
                  <a class="page-link siguiente-A" href="javascript:void(0)" aria-label="Next" onclick="pintarAudiencias(1)">
                    <i class="fa fa-angle-right"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link ultima-A" href="javascript:void(0)" aria-label="Last" onclick="pintarAudiencias(1)">
                    <i class="fa fa-angle-double-right"></i>
                  </a>
                </li>
              </ul>
            </div>

          </div>
        </div>

      </div>

    </div>

  </div>

  <style type="text/css" >

  </style>

  <script>
    //variables de contador
    var count_days = 0;
    var count_months = 0;
    var count_years = 0;

    var arrPre = [];

    function pintarPrescripciones(pagina=1){
      
      configA();

      $.ajax({
        url:'public/obtenerPrescripciones',
        type:'POST',
        data: {
          id_carpeta: carpetaActiva.id_carpeta_judicial,
          pagina: pagina
        },
        success: function(response){
          console.log('prescripciones',response)
          if(response.status == 100){

            var lista = response.response;
            arrPre = lista;

            var tr = '';
            for(i in lista){

              acciones = `
                <i class="fas fa-trash" style="cursor:pointer;" title="Eliminar" onclick="eliminarPrescripcionModal(${lista[i].id_prescripcion}, ${lista[i].id_carpeta_judicial})"></i>
                <i class="fas fa-edit" style="cursor:pointer;" title="Editar" onclick="editarPrescripcion__(${i})"></i>
              `;

              tr += ` <tr>
                        <td>${acciones}</td>
                        <td>${lista[i].fecha_creacion}</td>
                        <td>${lista[i].nombre} ${lista[i].apellido_paterno} ${lista[i].apellido_materno}</td>
                        <td>${lista[i].fecha_prescripcion}</td>
                        <td>Pena por Cumplir: Años  ${lista[i].anios_por_cumplir}, Meses  ${lista[i].meses_por_cumplir}, Dias ${lista[i].dias_por_cumplir}</td>
                        <td>${lista[i].comentarios_puni}</td> 
                      </tr>`;
            }

            $('#table-prescripciones').html(tr);

            let anterior=pagina==1?1:pagina-1;
            let totalPaginas=response.response_paginacion.paginas_totales;
            let siguiente=pagina+1>=totalPaginas?totalPaginas:pagina+1;

            $('.anterior-A').attr('onclick',`pintarAudiencias(${anterior})`);
            $('.pagina-A').html(pagina);
            $('.total-paginas-A').html(totalPaginas);
            $('.siguiente-A').attr('onclick',`pintarAudiencias(${siguiente})`);
            $('.ultima-A').attr('onclick',`pintarAudiencias(${totalPaginas})`);
          }else{
            $('#table-prescripciones').html(`<tr>
              <th colspan="6" style="text-align: center;">
                No se encontraron datos relacionados
              </th>
            </tr>`);

            $('.anterior-A').attr('onclick',`pintarAudiencias(1)`);
            $('.pagina-A').html('1');
            $('.total-paginas-A').html('1');
            $('.siguiente-A').attr('onclick',`pintarAudiencias(1)`);
            $('.ultima-A').attr('onclick',`pintarAudiencias(1)`);
          }
        }
      });

    }

    function configA(){
      $('.datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        format: 'dd/mm/yyyy',
        changeYear: true,
        yearRange: "c-100:c+0"
      });

      $('.select2').select2();
      setTimeout(function(){
        prescripcionesObtenerImputados();
      },1000);
    }

    function prescripcionesObtenerImputados(){
      
      var id_carpeta = carpetaActiva.id_carpeta_judicial;
     console.log(id_carpeta);
      $.ajax({
        method:'GET',
        url:'/public/imputados_remision_prescripcion',
        data:{
          id_carpeta:id_carpeta
        },
        success:function(response){
          console.log(response);
          
          if(response.status == 100){
            var lista = response.response;
            var  option = '<option selected value="">Selecciona una opción</option>';

            for(i in lista){
              option += `<option value="${lista[i].id_persona}">${ lista[i].tipo_persona == "fisica" ? lista[i].nombre_completo : lista[i].razon_social}</option>`;
            }

            $('#pre_imputado').html(option);
            $('#pre_imputado_e').html(option);
          }else{
            var option = '<option selected value="">'+response.response+'</option>';
            $('#pre_imputado').html(option);
            $('#pre_imputado_e').html(option);
          }
        }
      });

    }

    function obtenerPena(obj){
      var imputado = $(obj).val();
      
      $.ajax({
        method:'POST',
        url:'/public/catalogo_pena',
        data:{
          id_imputado:imputado
        },
        success:function(response){
          console.log(response);
          
          if(response.status == 100){
            var lista = response.response;
            var option = '<option value="">Selecciona una opción</option>';

            for(i in lista){
              if(lista[i].id_tipo_pena == 1){
                atributos = `anios="${lista[i].periodo_anios}"  meses="${lista[i].periodo_meses}"  dias="${lista[i].periodo_dias}"`;
              }else{
                atributos = ``;
              }
              option += `<option value="${lista[i].id_rem_per}" tipo="${lista[i].id_tipo_pena}" ${atributos}> ${lista[i].pena}, Delito: ${lista[i].delitos}, Años: ${lista[i].periodo_anios}, Meses: ${lista[i].periodo_meses}, Dias: ${lista[i].periodo_dias}</option>`;
            } 

            $('#pre_pena').html(option);
            $('#pre_pena_e').html(option);
          }else{
            var option = '<option selected value="">'+response.response+'</option>';
            $('#pre_pena').html(option);
            $('#pre_pena_e').html(option);
          }
        }
      });
    }

    function mostrarPanel(obj){
        var value = $('#'+obj+' :selected').attr('tipo')
        
        if(value == '1'){
          $('#pena_por_cumplir').css('display', 'block');
          var anios = $('#'+obj+' :selected').attr('anios');
          var mese  = $('#'+obj+' :selected').attr('meses');
          var dias = $('#'+obj+' :selected').attr('dias');

          $('#anios_por_cumplir').val(anios);
          $('#meses_por_cumplir').val(mese);
          $('#dias_por_cumplir').val(dias);

          $('#anios_por_cumplir').attr('dato',anios);
          $('#meses_por_cumplir').attr('dato',mese);
          $('#dias_por_cumplir').attr('dato',dias);
        }else{

        }
    }

    function guardarPrescripcion(){
      var imputado = $('#pre_imputado').val();
      var pena = $('#pre_pena').val();
      var anio_pripun = $('#anios_abono_puni').val();
      var meses_pripun = $('#meses_abono_puni').val();
      var dias_pripun = $('#dias_abono_puni').val();
      var comentarios_pripun = $('#comentarios_prision_punitiva').val();
      var anio_pripre = $('#anios_abono_prev').val();
      var meses_pripre = $('#meses_abono_prev').val();
      var dias_pripre = $('#dias_abono_prev').val();
      var fecha_sustraccion = get_date($('#fecha_sustraccion').val());
      var fecha_acto_autoridad = get_date($('#fecha_u_acto').val());
      var se_encuentra_cdmx = $('#vive_ciudad_mexico').val();
      var fecha_prescripcion = get_date($('#fecha_prescripcion').val());

      var anio_por_cumplir = $('#anios_por_cumplir').val();
      var meses_por_cumplir = $('#meses_por_cumplir').val();
      var dias_por_cumplir = $('#dias_por_cumplir').val();

      var validador = validar_campos('agregar');
      
      $('.error').removeClass('error');
      
      if(validador == 100){

        var prision_punitiva = {
          "anio_pripun": anio_pripun,
          "meses_pripun": meses_pripun,
          "dias_pripun": dias_pripun,
          "comentarios_pripun": comentarios_pripun
        }
  
        var prision_preventiva = {
          "anio_pripre": anio_pripre,
          "meses_pripre": meses_pripre,
          "dias_pripre": dias_pripre,
        }

        var pena_por_cumplir = {
          "anio_por_cumplir": anio_por_cumplir,
          "meses_por_cumplir": meses_por_cumplir,
          "dias_por_cumplir": dias_por_cumplir,
        }
  
        var data = {
          "imputado" : imputado,
          "pena": pena,
          "prision_punitiva": prision_punitiva,
          "prision_preventiva": prision_preventiva,
          "pena_por_cumplir": pena_por_cumplir,
          "fecha_sustraccion": fecha_sustraccion,
          "fecha_acto_autoridad": fecha_acto_autoridad,
          "se_encuentra_cdmx": se_encuentra_cdmx,
          "fecha_prescripcion": fecha_prescripcion
        }

        var datas ={
          "id_carpeta" : carpetaActiva.id_carpeta_judicial,
          "data": data
        }

        console.log(datas);
        
        $.ajax({
          method:'POST',
          url:'/public/guardar_prescripcion',
          data:{
            id_carpeta : carpetaActiva.id_carpeta_judicial,
            data: data
          },
          success:function(response){
            if(response.status == 100){
              console.log(response.response);
              modal_success('Prescripción creada exitosamente','modalAdministracion');
              $('#cancelarPrescripcion').trigger('click');
              pintarPrescripciones();
            }else{
              modal_error(response.response,'modalAdministracion');
            }
          }
        });
        

      }else{
        const {campo , error} = validador;
        if($('#'+campo).is('select')){
          $('#'+campo).focus().addClass('error');
        }else{
          $('#'+campo).focus().addClass('error');
        }
          modal_error(error,'modalAdministracion');
      }

    }

    function eliminarPrescripcionModal(id_pre, id_carpeta_judicial){
      var mensaje = 'Desea Eliminar la prescripción '+id_pre+' ?';
      var fn = `eliminarPrescripcion(${id_pre}, ${id_carpeta_judicial})`;
      modal_warning(mensaje,fn,'modalAdministracion');
    }

    function eliminarPrescripcion(id_pre, id_carpeta_judicial){
      $.ajax({
        method:'POST',
        url:'/public/eliminar_prescripcion',
        data:{
          id_carpeta : id_carpeta_judicial,
          id_prescripcion: id_pre
        },
        success:function(response){
          if(response.status == 100){
            console.log(response.response);
            modal_success(response.response,'modalAdministracion');
            pintarPrescripciones();
          }else{
            modal_error(response.response,'modalAdministracion');
          }
        }
      });
    }

    function editarPrescripcion__(index){
      var datos = arrPre[index];
      var fn = `editarPrescripcion(${datos['id_prescripcion']})`;
      
      var imputado = datos['id_imputado'];
      var pena = datos['id_pena'];
      var anio_pripun = datos['anios_puni'];
      var meses_pripun = datos['meses_puni'];
      var dias_pripun = datos['dias_puni'];
      var comentarios_pripun = datos['comentarios_puni'];
      var anio_pripre = datos['anios_prevent'];
      var meses_pripre = datos['meses_prevent'];
      var dias_pripre = datos['dias_prevent'];
      var anios_por_cumplir = datos['anios_por_cumplir'];
      var meses_por_cumplir = datos['meses_por_cumplir'];
      var dias_por_cumplir = datos['dias_por_cumplir'];
      var fecha_sustraccion = datos['fecha_sustraccion'];
      var fecha_acto_autoridad = datos['fecha_acto_autoridad'];
      var se_encuentra_cdmx = datos['se_encuentra_cdmx'];
      var fecha_prescripcion = datos['fecha_prescripcion'];

      $('#editarPrescripcion').attr('onclick', fn);

      $('#pre_imputado_e:selected').attr("selected",false);


      if($('#collapseSearchAdvance3').hasClass('show')){
        resetform('frm_prescripcion_Edit');

        $('#pre_imputado_e option[value='+ imputado +']').attr("selected",true);
        $('#pre_pena_e option[value='+ pena +']').attr("selected",true);
        $('#anios_abono_puni_e').val(anio_pripun);
        $('#meses_abono_puni_e').val(meses_pripun);
        $('#dias_abono_puni_e').val(dias_pripun);
        $('#comentarios_prision_punitiva_e').val(comentarios_pripun);
        $('#anios_abono_prev_e').val(anio_pripre);
        $('#meses_abono_prev_e').val(meses_pripre);
        $('#dias_abono_prev_e').val(dias_pripre);
        $('#fecha_sustraccion_e').val(fecha_sustraccion)
        $('#fecha_u_acto_e').val(fecha_acto_autoridad)
        $('#vive_ciudad_mexico_e option[value='+ se_encuentra_cdmx +']').attr("selected",true);
        $('#fecha_prescripcion_e').val(fecha_prescripcion)

        if(datos['id_pena'] == 1){
          $('#pena_por_cumplir_e').css('display', 'block');

          setTimeout(function(){
            $('#anios_por_cumplir_e').val(anios_por_cumplir);
            $('#meses_por_cumplir_e').val(meses_por_cumplir);
            $('#dias_por_cumplir_e').val(dias_por_cumplir);
          },1200);
        }

      }else{
        $('#collapseSearchAdvance3').addClass('show')
        resetform('frm_prescripcion_Edit');

        $('#pre_imputado_e option[value='+ imputado +']').attr("selected",true);
        $('#pre_pena_e option[value='+ pena +']').attr("selected",true);
        $('#anios_abono_puni_e').val(anio_pripun);
        $('#meses_abono_puni_e').val(meses_pripun);
        $('#dias_abono_puni_e').val(dias_pripun);
        $('#comentarios_prision_punitiva_e').val(comentarios_pripun);
        $('#anios_abono_prev_e').val(anio_pripre);
        $('#meses_abono_prev_e').val(meses_pripre);
        $('#dias_abono_prev_e').val(dias_pripre);
        $('#fecha_sustraccion_e').val(fecha_sustraccion)
        $('#fecha_u_acto_e').val(fecha_acto_autoridad)
        $('#vive_ciudad_mexico_e option[value='+ se_encuentra_cdmx +']').attr("selected",true);
        $('#fecha_prescripcion_e').val(fecha_prescripcion)


        if(datos['id_pena'] == 1){
          $('#pena_por_cumplir_e').css('display', 'block');

          setTimeout(function(){
            $('#anios_por_cumplir_e').val(anios_por_cumplir);
            $('#meses_por_cumplir_e').val(meses_por_cumplir);
            $('#dias_por_cumplir_e').val(dias_por_cumplir);
          },1200);
        }
      }

    }

    function editarPrescripcion(id_prescripcion){ 
      var imputado = $('#pre_imputado_e').val();
      var pena = $('#pre_pena_e').val();
      var anio_pripun = $('#anios_abono_puni_e').val();
      var meses_pripun = $('#meses_abono_puni_e').val();
      var dias_pripun = $('#dias_abono_puni_e').val();
      var comentarios_pripun = $('#comentarios_prision_punitiva_e').val();
      var anio_pripre = $('#anios_abono_prev_e').val();
      var meses_pripre = $('#meses_abono_prev_e').val();
      var dias_pripre = $('#dias_abono_prev_e').val();
      var fecha_sustraccion = get_date($('#fecha_sustraccion_e').val());
      var fecha_acto_autoridad = get_date($('#fecha_u_acto_e').val());
      var se_encuentra_cdmx = $('#vive_ciudad_mexico_e').val();
      var fecha_prescripcion = get_date($('#fecha_prescripcion_e').val());

      var validador = validar_campos('edicion');
      
      $('.error').removeClass('error');
      
      if(validador == 100){

        var prision_punitiva = {
          "anio_pripun": anio_pripun,
          "meses_pripun": meses_pripun,
          "dias_pripun": dias_pripun,
          "comentarios_pripun": comentarios_pripun
        }
  
        var prision_preventiva = {
          "anio_pripre": anio_pripre,
          "meses_pripre": meses_pripre,
          "dias_pripre": dias_pripre,
        }
  
        var data = {
          "id_prescripcion": id_prescripcion,
          "imputado" : imputado,
          "pena": pena,
          "prision_punitiva": prision_punitiva,
          "prision_preventiva": prision_preventiva,
          "fecha_sustraccion": fecha_sustraccion,
          "fecha_acto_autoridad": fecha_acto_autoridad,
          "se_encuentra_cdmx": se_encuentra_cdmx,
          "fecha_prescripcion": fecha_prescripcion
        }

        var datas ={
          "data": data
        }

        console.log(datas);
        
        $.ajax({
          method:'POST',
          url:'/public/actualizar_prescripcion',
          data:{
            data: data
          },
          success:function(response){
            if(response.status == 100){
              console.log(response.response);
              modal_success('Prescripción Actuzalizada exitosamente','modalAdministracion');
              $('#cancelarPrescripcion_e').trigger('click');
              pintarPrescripciones();
            }else{
              modal_error(response.response,'modalAdministracion');
            }
          }
        });
      }else{
        const {campo , error} = validador;
        if($('#'+campo).is('select')){
          $('#'+campo).focus().addClass('error');
        }else{
          $('#'+campo).focus().addClass('error');
        }
          modal_error(error,'modalAdministracion');
      }
    }

    function get_date( date , format = 'YYYY-MM-DD' ){
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('-') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('-') )
        return date.split('-').reverse().join('-');
      if( format == 'YYYY-MM-DD' && date.substring(0,4).includes('/') ) 
        return date.split('-').reverse().join('-');
      if( format == 'DD-MM-YYYY' && !date.substring(0,4).includes('/') )
        return date.split('-').reverse().join('-');
      else
        return date;
    }
    
    function resetform(form) {
      $("#"+form+" select").each(function() { $(this).removeAttr('selected') });
      $("#"+form+" input[type=text] , form textarea, input[type=number]").each(function() { this.value = '' });
    }

    function validar_campos(tipo){
      if(tipo == 'agregar'){
        if ($('#pre_imputado').val() == '') return {'status':100, 'campo': 'pre_imputado', 'error': 'Error no a elegido ha un imputado'};
        if ($('#pre_pena').val() == '') return {'status':100, 'campo': 'pre_pena', 'error': 'Error no ha elegido una pena'};
        if ($('#fecha_prescripcion').val() =='') return {'status':100, 'campo': 'fecha_prescripcion', 'error': 'Error no ha escrito un fecha'};
      }else if(tipo == 'edicion'){
        if ($('#pre_imputado_e').val() == '') return {'status':100, 'campo': 'pre_imputado_e', 'error': 'Error no a elegido ha un imputado'};
        if ($('#pre_pena_e').val() == '') return {'status':100, 'campo': 'pre_pena_e', 'error': 'Error no ha elegido una pena'};
        if ($('#fecha_prescripcion_e').val() =='') return {'status':100, 'campo': 'fecha_prescripcion_e', 'error': 'Error no ha escrito un fecha'};
      }
      return 100;
    }

    function restar(obj, id){
      var resta ='';
      valor_por_cumplir = $('#'+id).attr('dato');

      var dato1 = $(obj).val();
      var dato2 = $('#'+id).val();

      if(dato1 <= valor_por_cumplir){
        resta = valor_por_cumplir - dato1;
      }else if(dato1 > dato2){
        resta = 0;
      }

      $('#'+id).val(resta);
    }

  </script>
