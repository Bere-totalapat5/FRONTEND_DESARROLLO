<?php
    $id_juicio=$lista_archivos['response']['datos_toca'][0]['id_juicio'];
    $tipo_expediente=$lista_archivos['response']['datos_toca'][0]['tipo_expediente'];
    $toca=$lista_archivos['response']['datos_toca'][0]['toca'];
    $anio_toca=$anio_toca_2=$lista_archivos['response']['datos_toca'][0]['anio_toca'];
    $asunto_toca=$lista_archivos['response']['datos_toca'][0]['asunto_toca'];

    $expediente=$lista_archivos['response']['datos_toca'][0]['expediente'];
    $anio=$lista_archivos['response']['datos_toca'][0]['anio'];
    $bis=$lista_archivos['response']['datos_toca'][0]['bis'];

    $header="DATOS PARA LAS NOTIFICACIONES.";
    $tipo=0;
    //es para procedimiento en linea
    if(isset($input['header']) and $input['header']==1){
      $header="PROCEDIMIENTO EN LÍNEA";
      $tipo=1;
    }

    //historico de acuerdos por actor
    $acuerdos=0;
    if(isset($input['acuerdos'])){
        $acuerdos=$input['acuerdos'];
    }


    $toca_completo=$toca.'/'.$anio_toca;
    if($asunto_toca!=""){
        $toca_completo.='/'.$asunto_toca;
    }
    $boton_guardar=$script_guardar='';
    if(isset($input['guardar']) and $input['guardar']==1){
      $boton_guardar='<button class="btn btn-primary btn-block mg-b-10" onclick="guardarPartesNotificacion();">Guardar</button>';
      $script_guardar='alert("Se guardo exitosamente");';
    }

    $html_partes_actor="";
    if(isset($lista_archivos['response']['partes']['partes']['actor'])){

        
      //$html_partes_actor.=print_r($lista_archivos['response']['partes']['partes']['actor'], true);
        
        for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){

          if($lista_archivos['response']['partes']['partes']['actor'][$i]['promovente']==1){
            $html_partes_actor.='<h5 class="tx-bold tx-inverse">Promovente</h5>';
          }
          else{
            $html_partes_actor.='<h5 class="tx-bold tx-inverse">Actor</h5>';
          }


            $html_partes_actor.='<div class="partes">
                
              
            
            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'].'</div>';
            $html_partes_actor.='
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group mg-b-10">
                  <label>Correo electrónico: </label>
                  <input type="text" id="correo" name="datos['.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'][correo]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['correo'].'" placeholder="" >
                  
                  <input type="hidden" id="tipo" value="actor">
                  <input type="hidden" id="id_parte" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'">
                  <input type="hidden" id="nombres" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['nombres'].'">
                  <input type="hidden" id="apellido_paterno" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['apeliido_paterno'].'">
                  <input type="hidden" id="apellido_materno" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['apellido_materno'].'">
                  <input type="hidden" id="tipo" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['tipo'].'">
                  <input type="hidden" id="tipo_persona" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['tipo_persona'].'">
                  <input type="hidden" id="promovente" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['promovente'].'">
                  <input type="hidden" id="estatus" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['estatus'].'">
                  <input type="hidden" id="id_litigante" value="'; if(isset($lista_archivos['response']['partes']['partes']['actor'][$i]['datos_usuario'][0]['id_usuario'])){ $html_partes_actor.=$lista_archivos['response']['partes']['partes']['actor'][$i]['datos_usuario'][0]['id_usuario']; }else{ $html_partes_actor.='0';  } $html_partes_actor.='">

                </div><!-- form-group -->
              </div>
              <div class="col-lg-6">
                <div class="form-group mg-b-10">
                  <label>Celular:</label>
                  <input type="text" id="celular" name="datos['.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'][celular]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['telefono'].'" placeholder="" >
                </div><!-- form-group -->
              </div>';

              if($tipo==0){
                $html_partes_actor.='
              <div class="col-lg-6">
                <div class="form-group mg-b-0">
                  <label>Notificación:</label>
                  <select class="form-control select2" id="notificacion" name="notificacion" style="float:right;" onchange="mostrarDireccion(this);">
                    <option value="0">Sin notificación</option>
                    <option value="1" '; if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="1"){  $html_partes_actor.='selected '; }  $html_partes_actor.='>Notificación electrónica por Articulo 113</option>
                    <option value="2" '; if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="2"){  $html_partes_actor.='selected '; }  $html_partes_actor.='>Notificación electrónica por correo del actuario</option>
                    <option value="3" '; if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="3"){  $html_partes_actor.='selected '; }  $html_partes_actor.='>Notificación física</option>
                  </select>
                </div>
              </div>';
              }
              else{
                $html_partes_actor.='<input type="hidden" id="notificacion" name="notificacion" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion'].'">';
              }

              $html_partes_actor.='
              <div class="col-lg-6">
                <div class="form-group mg-b-0" '; if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']!="3"){  $html_partes_actor.=' style="display:none; '; }  $html_partes_actor.='" id="div_direccion_notificacion">
                  <label>Dirección: </label>
                  <textarea rows="3" class="form-control" placeholder="" id="direccion" name="direccion">'.$lista_archivos['response']['partes']['partes']['actor'][$i]['direccion'].'</textarea>
                </div>
              </div>

              


              <div class="col-lg-12">';
                if($acuerdos==1){
                  $html_partes_actor.='

                  <br>
                  <div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true">
                    <div class="card">
                      <div class="card-header" role="tab" id="headingOne">
                        <a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'" aria-expanded="false" aria-controls="collapseOne" onclick="abrir_accordion('.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].')" >
                          Historial de acuerdos
                        </a>
                      </div><!-- card-header -->

                      <div id="collapseOne_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                        
                        <input type="hidden" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['extras'].'" name="arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'" id="arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'">
                        <table id="datatable_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'" class="table display wrap" style="width: 100%; max-width: 850px;">
                          <thead>
                            <tr>
                                <th class="wd-25p" data-priority="1" style="">Publicación</th>
                                <th class="wd-25p" data-priority="1" style="">Resolución</th>
                                <th class="wd-50p">Concepto</th>
                                <th></th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
      
                        <input type="hidden" id="pagina_actual_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'" name="pagina_actual_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'" value="1">
                        <input type="hidden" id="paginas_totales_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'" name="paginas_totales_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'" value="1">
            
                        <div class="pagination-wrapper justify-content-between">
                            <ul class="pagination mg-b-0">
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'primera\', '.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].');" aria-label="Last">
                                  <i class="fa fa-angle-double-left"></i>
                                  </a>
                              </li>
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'atras\', '.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].');" aria-label="Next">
                                  <i class="fa fa-angle-left"></i>
                                  </a>
                              </li>
                            </ul>
                
                            <div id="texto_paginator_notificacion">Página <span class="pagina_actual_texto_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'">1</span> de <span class="pagina_total_texto_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'">1</span></div>
                
                            <ul class="pagination mg-b-0">
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'avanzar\', '.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].');" aria-label="Next">
                                  <i class="fa fa-angle-right"></i>
                                  </a>
                              </li>
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'ultima\', '.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].');" aria-label="Last">
                                  <i class="fa fa-angle-double-right"></i>
                                  </a>
                              </li>
                            </ul>
                          </div><!-- pagination-wrapper -->






                        </div>
                      </div>
                    </div>
                    
                  </div><!-- accordion -->';

                }


              $html_partes_actor.='
              </div>
              
            </div>
            </div>
            <br>
            <script>

            $(function(  ){
        
              dataTableGlobal_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].' = table_notificacion = $(\'#datatable_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'\').DataTable( {
                "ordering": false,
                "columnDefs": [
                  { responsivePriority: 1, targets: 3 },  
                  { "targets": [0],  "orderable": false, targets: 0, "visible": true },
                  { "targets": [1],  "orderable": false, targets: 0, "visible": true },
                  { "targets": [2],  "orderable": false, targets: 0, "visible": true, "class":"romperCadena" },
                    {
                    "targets": 3,
                    "searchable": false,
                    "orderable": false,
                    "width": "1%",
                    "className": "dt-body-center",
                    "render": function (data, type, full, meta){
                      
                      i_global++;
                      
                      if($.inArray(meta.row, arr_check_disable)!= -1){
                        return "";
                      }
                      else{
          
                        id=full[0].substr(28,10);
                        select_txt="";
          
                        if(($("#arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'").val().search(id) != -1) && $("#arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'").val()!="") {
                          select_txt="checked";
                        }
          
                        return "<input type=\'checkbox\' id=\'chbox_notificacion_"+meta.row+"_'.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'\' class=\'\' "+select_txt+" value=\'"+meta.row+"\' onclick=\'actualizarNotificacion("+meta.row+", '.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].');\'>";
                      }  
                   }
                }],
                bLengthChange: false,
                searching: false,
                responsive: true,
                pageLength: 5,
                paging: false,
                info: false,
                "rowCallback": function(row, data, dataIndex){
                   // Get row ID
                   var rowId = data[0];
                }
              } );
              
            });
            </script>
            
            ';
        }
    }
    $html_partes_demandado="";
    if(isset($lista_archivos['response']['partes']['partes']['demandado'])){
      $html_partes_demandado.='<hr>';
      for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){
        $html_partes_demandado.='<h5 class="tx-bold tx-inverse">Demandado</h5>';

          $html_partes_demandado.='<div class="partes">
          <!--
          <label class="ckbox" style="float:right;">
                <input type="checkbox" value="1" id="notificacion" name="notificacion" '; if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="si"){  $html_partes_demandado.='checked '; }    $html_partes_demandado.='><span>Marcar para notificar</span>
              </label>
              -->
          <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombre'].'</div>';
          $html_partes_demandado.='
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group mg-b-0">
                  <label>Correo electrónico: </label>
                  <input type="text" id="correo" name="datos['.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'][correo]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['correo'].'" placeholder="" >

                  <input type="hidden" id="tipo" value="demandado">
                  <input type="hidden" id="id_parte" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'">
                  <input type="hidden" id="nombres" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['nombres'].'">
                  <input type="hidden" id="apellido_paterno" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['apeliido_paterno'].'">
                  <input type="hidden" id="apellido_materno" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['apellido_materno'].'">
                  <input type="hidden" id="tipo" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['tipo'].'">
                  <input type="hidden" id="tipo_persona" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['tipo_persona'].'">
                  <input type="hidden" id="promovente" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['promovente'].'">
                  <input type="hidden" id="estatus" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['estatus'].'">
                  <input type="hidden" id="id_litigante" value="'; if(isset($lista_archivos['response']['partes']['partes']['demandado'][$i]['datos_usuario'][0]['id_usuario'])){ $html_partes_demandado.=$lista_archivos['response']['partes']['partes']['demandado'][$i]['datos_usuario'][0]['id_usuario']; }else{ $html_partes_demandado.='0';  } $html_partes_demandado.='">

                </div><!-- form-group -->
              </div>
              <div class="col-lg-6">
                <div class="form-group mg-b-10">
                  <label>Celular:</label>
                  <input type="text" id="celular" name="datos['.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'][celular]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono'].'" placeholder="" >
                </div><!-- form-group -->
              </div>';

              if($tipo==0){
              $html_partes_demandado.='
              <div class="col-lg-6">
                <div class="form-group mg-b-0">
                  <label>Notificación:</label>
                  <select class="form-control select2" id="notificacion" name="notificacion" style="float:right;" onchange="mostrarDireccion(this);">
                    <option value="0">Sin notificación</option>
                    <option value="1" '; if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="1"){  $html_partes_demandado.='selected '; }  $html_partes_demandado.='>Notificación electrónica por Articulo 113</option>
                    <option value="2" '; if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="2"){  $html_partes_demandado.='selected '; }  $html_partes_demandado.='>Notificación electrónica por correo del actuario</option>
                    <option value="3" '; if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="3"){  $html_partes_demandado.='selected '; }  $html_partes_demandado.='>Notificación física</option>
                  </select>
                </div>
              </div>';
            }
            else{
              $html_partes_demandado.='<input type="hidden" id="notificacion" name="notificacion" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion'].'">';
            }

            $html_partes_demandado.='
              <div class="col-lg-6">
                <div class="form-group mg-b-0" '; if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']!="3"){  $html_partes_demandado.=' style="display:none; '; }  $html_partes_demandado.='" id="div_direccion_notificacion">
                  <label>Dirección: </label>
                  <textarea rows="3" class="form-control" placeholder="" id="direccion" name="direccion">'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['direccion'].'</textarea>
                </div>
              </div>



              <div class="col-lg-12">';
                if($acuerdos==1){
                  $html_partes_demandado.='

                  <br>
                  <div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true">
                    <div class="card">
                      <div class="card-header" role="tab" id="headingOne">
                        <a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'" aria-expanded="false" aria-controls="collapseOne" onclick="abrir_accordion('.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].')" >
                          Historial de acuerdos
                        </a>
                      </div><!-- card-header -->

                      <div id="collapseOne_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                        
                        <input type="hidden" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['extras'].'" name="arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'" id="arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'">
                        <table id="datatable_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'" class="table display wrap" style="width: 100%; max-width: 850px;">
                          <thead>
                            <tr>
                                <th class="wd-25p" data-priority="1" style="">Publicación</th>
                                <th class="wd-25p" data-priority="1" style="">Resolución</th>
                                <th class="wd-50p">Concepto</th>
                                <th></th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
      
                        <input type="hidden" id="pagina_actual_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'" name="pagina_actual_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'" value="1">
                        <input type="hidden" id="paginas_totales_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'" name="paginas_totales_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'" value="1">
            
                        <div class="pagination-wrapper justify-content-between">
                            <ul class="pagination mg-b-0">
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'primera\', '.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].');" aria-label="Last">
                                  <i class="fa fa-angle-double-left"></i>
                                  </a>
                              </li>
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'atras\', '.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].');" aria-label="Next">
                                  <i class="fa fa-angle-left"></i>
                                  </a>
                              </li>
                            </ul>
                
                            <div id="texto_paginator_notificacion">Página <span class="pagina_actual_texto_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'">1</span> de <span class="pagina_total_texto_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'">1</span></div>
                
                            <ul class="pagination mg-b-0">
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'avanzar\', '.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].');" aria-label="Next">
                                  <i class="fa fa-angle-right"></i>
                                  </a>
                              </li>
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'ultima\', '.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].');" aria-label="Last">
                                  <i class="fa fa-angle-double-right"></i>
                                  </a>
                              </li>
                            </ul>
                          </div><!-- pagination-wrapper -->






                        </div>
                      </div>
                    </div>
                    
                  </div><!-- accordion -->';

                }


              $html_partes_demandado.='
              </div>


            </div>
            </div>
            <br>
            
            <script>

            $(function(  ){
        
              dataTableGlobal_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].' = table_notificacion = $(\'#datatable_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'\').DataTable( {
                "ordering": false,
                "columnDefs": [
                  { responsivePriority: 1, targets: 3 },  
                  { "targets": [0],  "orderable": false, targets: 0, "visible": true },
                  { "targets": [1],  "orderable": false, targets: 0, "visible": true },
                  { "targets": [2],  "orderable": false, targets: 0, "visible": true, "class":"romperCadena" },
                    {
                    "targets": 3,
                    "searchable": false,
                    "orderable": false,
                    "width": "1%",
                    "className": "dt-body-center",
                    "render": function (data, type, full, meta){
                      
                      i_global++;
                      
                      if($.inArray(meta.row, arr_check_disable)!= -1){
                        return "";
                      }
                      else{
          
                        id=full[0].substr(28,10);
                        select_txt="";
          
                        if(($("#arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'").val().search(id) != -1) && $("#arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'").val()!="") {
                          select_txt="checked";
                        }
          
                        return "<input type=\'checkbox\' id=\'chbox_notificacion_"+meta.row+"_'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'\' class=\'\' "+select_txt+" value=\'"+meta.row+"\' onclick=\'actualizarNotificacion("+meta.row+", '.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].');\'>";
                      }  
                   }
                }],
                bLengthChange: false,
                searching: false,
                responsive: true,
                pageLength: 5,
                paging: false,
                info: false,
                "rowCallback": function(row, data, dataIndex){
                   // Get row ID
                   var rowId = data[0];
                }
              } );
              
            });
            </script>

            ';
      }
    }

    $html_partes_tercero="";
    if(isset($lista_archivos['response']['partes']['partes']['tercero'])){
      
      for($i=0; $i<count($lista_archivos['response']['partes']['partes']['tercero']); $i++){

          $html_partes_tercero.='<hr><h5 class="tx-bold tx-inverse">Tercero</h5>';

          $html_partes_tercero.='<div class="partes">
          <!--
          <label class="ckbox" style="float:right;">
                <input type="checkbox" value="1" id="notificacion" name="notificacion" '; if($lista_archivos['response']['partes']['partes']['tercero'][$i]['notificacion']=="si"){  $html_partes_tercero.='checked '; }    $html_partes_tercero.='><span>Marcar para notificar</span>
              </label>
              -->
          
          <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['nombre'].'</div>';
          $html_partes_tercero.='
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group mg-b-0">
                  <label>Correo electrónico: </label>
                  <input type="text" id="correo" name="datos['.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'][correo]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['correo'].'" placeholder="" >

                  <input type="hidden" id="tipo" value="tercero">
                  <input type="hidden" id="id_parte" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'">
                  <input type="hidden" id="nombres" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['nombres'].'">
                  <input type="hidden" id="apellido_paterno" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['apeliido_paterno'].'">
                  <input type="hidden" id="apellido_materno" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['apellido_materno'].'">
                  <input type="hidden" id="tipo" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['tipo'].'">
                  <input type="hidden" id="tipo_persona" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['tipo_persona'].'">
                  <input type="hidden" id="promovente" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['promovente'].'">
                  <input type="hidden" id="estatus" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['estatus'].'">
                  <input type="hidden" id="id_litigante" value="'; if(isset($lista_archivos['response']['partes']['partes']['tercero'][$i]['datos_usuario'][0]['id_usuario'])){ $html_partes_tercero.=$lista_archivos['response']['partes']['partes']['tercero'][$i]['datos_usuario'][0]['id_usuario']; }else{ $html_partes_tercero.='0';  } $html_partes_tercero.='">

                </div><!-- form-group -->
              </div>
              <div class="col-lg-6">
                <div class="form-group mg-b-0">
                  <label>Celular:</label>
                  <input type="text" id="celular" name="datos['.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'][celular]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['telefono'].'" placeholder="" >
                </div><!-- form-group -->
              </div>';

              if($tipo==0){
                $html_partes_tercero.='
              <div class="col-lg-6">
                <div class="form-group mg-b-0">
                  <label>Notificación:</label>
                  <select class="form-control select2" id="notificacion" name="notificacion" style="float:right;" onchange="mostrarDireccion(this);">
                    <option value="0">Sin notificación</option>
                    <option value="1" '; if($lista_archivos['response']['partes']['partes']['tercero'][$i]['notificacion']=="1"){  $html_partes_tercero.='selected '; }  $html_partes_tercero.='>Notificación electrónica por Articulo 113</option>
                    <option value="2" '; if($lista_archivos['response']['partes']['partes']['tercero'][$i]['notificacion']=="2"){  $html_partes_tercero.='selected '; }  $html_partes_tercero.='>Notificación electrónica por correo del actuario</option>
                    <option value="3" '; if($lista_archivos['response']['partes']['partes']['tercero'][$i]['notificacion']=="3"){  $html_partes_tercero.='selected '; }  $html_partes_tercero.='>Notificación física</option>
                  </select>
                </div>
              </div>';
            }
            else{
              $html_partes_tercero.='<input type="hidden" id="notificacion" name="notificacion" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['notificacion'].'">';
            }

            $html_partes_tercero.='
              <div class="col-lg-6">
                <div class="form-group mg-b-0" '; if($lista_archivos['response']['partes']['partes']['tercero'][$i]['notificacion']!="3"){  $html_partes_tercero.=' style="display:none; '; }  $html_partes_tercero.='" id="div_direccion_notificacion">
                  <label>Dirección: </label>
                  <textarea rows="3" class="form-control" placeholder="" id="direccion" name="direccion">'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['direccion'].'</textarea>
                </div>
              </div>


              <div class="col-lg-12">';
                if($acuerdos==1){
                  $html_partes_tercero.='

                  <br>
                  <div id="accordion" class="accordion-one" role="tablist" aria-multiselectable="true">
                    <div class="card">
                      <div class="card-header" role="tab" id="headingOne">
                        <a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'" aria-expanded="false" aria-controls="collapseOne" onclick="abrir_accordion(('.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].')" >
                          Historial de acuerdos
                        </a>
                      </div><!-- card-header -->

                      <div id="collapseOne_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-body">
                        
                        <input type="hidden" value="'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['extras'].'" name="arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'" id="arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'">
                        <table id="datatable_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'" class="table display wrap" style="width: 100%; max-width: 850px;">
                          <thead>
                            <tr>
                                <th class="wd-25p" data-priority="1" style="">Publicación</th>
                                <th class="wd-25p" data-priority="1" style="">Resolución</th>
                                <th class="wd-50p">Concepto</th>
                                <th></th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
      
                        <input type="hidden" id="pagina_actual_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'" name="pagina_actual_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'" value="1">
                        <input type="hidden" id="paginas_totales_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'" name="paginas_totales_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'" value="1">
            
                        <div class="pagination-wrapper justify-content-between">
                            <ul class="pagination mg-b-0">
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'primera\', '.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].');" aria-label="Last">
                                  <i class="fa fa-angle-double-left"></i>
                                  </a>
                              </li>
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'atras\', '.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].');" aria-label="Next">
                                  <i class="fa fa-angle-left"></i>
                                  </a>
                              </li>
                            </ul>
                
                            <div id="texto_paginator_notificacion">Página <span class="pagina_actual_texto_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'">1</span> de <span class="pagina_total_texto_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'">1</span></div>
                
                            <ul class="pagination mg-b-0">
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'avanzar\', '.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].');" aria-label="Next">
                                  <i class="fa fa-angle-right"></i>
                                  </a>
                              </li>
                              <li class="page-item">
                                  <a class="page-link" href="javascript:void(0);" onclick="accionPaginatorAcuerdos_ajax_notificacion(\'ultima\', '.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].');" aria-label="Last">
                                  <i class="fa fa-angle-double-right"></i>
                                  </a>
                              </li>
                            </ul>
                          </div><!-- pagination-wrapper -->






                        </div>
                      </div>
                    </div>
                    
                  </div><!-- accordion -->';

                }


              $html_partes_tercero.='
              </div>
              


            </div>
            </div>
            <br>
            
            <script>

            $(function(  ){
        
              dataTableGlobal_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].' = table_notificacion = $(\'#datatable_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'\').DataTable( {
                "ordering": false,
                "columnDefs": [
                  { responsivePriority: 1, targets: 3 },  
                  { "targets": [0],  "orderable": false, targets: 0, "visible": true },
                  { "targets": [1],  "orderable": false, targets: 0, "visible": true },
                  { "targets": [2],  "orderable": false, targets: 0, "visible": true, "class":"romperCadena" },
                    {
                    "targets": 3,
                    "searchable": false,
                    "orderable": false,
                    "width": "1%",
                    "className": "dt-body-center",
                    "render": function (data, type, full, meta){
                      
                      i_global++;
                      
                      if($.inArray(meta.row, arr_check_disable)!= -1){
                        return "";
                      }
                      else{
          
                        id=full[0].substr(28,10);
                        select_txt="";
          
                        if(($("#arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'").val().search(id) != -1) && $("#arr_acuerdos_notificacion_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'").val()!="") {
                          select_txt="checked";
                        }
          
                        return "<input type=\'checkbox\' id=\'chbox_notificacion_"+meta.row+"_'.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].'\' class=\'\' "+select_txt+" value=\'"+meta.row+"\' onclick=\'actualizarNotificacion("+meta.row+", '.$lista_archivos['response']['partes']['partes']['tercero'][$i]['id'].');\'>";
                      }  
                   }
                }],
                bLengthChange: false,
                searching: false,
                responsive: true,
                pageLength: 5,
                paging: false,
                info: false,
                "rowCallback": function(row, data, dataIndex){
                   // Get row ID
                   var rowId = data[0];
                }
              } );
              
            });
            </script>
            
            ';
      }
    }

    $plantilla_archivo_header = <<<EOF
    
    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">$header</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
EOF;

    $plantilla_archivo_body = <<<EOF

    

    $html_partes_actor

    $html_partes_demandado

    $html_partes_tercero

    <div class="col-lg-12 mg-t-30">
        <div class="row">
        <div class="col-lg-12">
          <input type="hidden" id="juicio_id" value="$juicio_id" >
          <input type="hidden" id="tipo_expediente" value="$tipo_expediente" >
          <input type="hidden" id="toca" value="$toca" >
          <input type="hidden" id="anio_toca_2" value="$anio_toca_2" >
          <input type="hidden" id="asunto_toca" value="$asunto_toca" >

          <input type="hidden" id="expediente" value="$expediente" >
          <input type="hidden" id="anio" value="$anio" >
          <input type="hidden" id="bis" value="$bis" >

          $boton_guardar
        </div><!-- col-4 -->
        </div>
    </div>

    <script>

      

      function mostrarDireccion(notificacion){
        
        if($(notificacion).val()==3){
          $(notificacion).parent().parent().parent().find("#div_direccion_notificacion").css("display", "block");
        }
        else{
          $(notificacion).parent().parent().parent().find("#div_direccion_notificacion").css("display", "none");
        }
      }

      function validarLitigante(obj){
        if($(obj).parent().parent().parent().find('#correo').val()!=""){
          if(validarEmail($(obj).parent().parent().parent().find('#correo'))){
            $.ajax({
              type:'POST',
              url:'/validarLitigante',
              data: { correo: $(obj).parent().parent().parent().find('#correo').val() } ,
              success:function(data){
                  console.log(data);
                  if(data.status==0){
                    $(obj).parent().parent().parent().find('#estatus_correo').html(' Correo registrado con el usuario: <strong>'+data.response.user+'</strong>');
                    $(obj).parent().parent().parent().find('#id_litigante').val(data.response.id_usuario);
                  }
                  else{
                    $(obj).parent().parent().parent().find('#estatus_correo').html(' Correo no registrado, se enviará invitación.');
                    $(obj).parent().parent().parent().find('#id_litigante').val(0);
                  }
              }
            });
          }
          else{
            $(obj).parent().parent().parent().find('#estatus_correo').html(" El correo no tiene formato válido");
          }
        }
        else{
          alert("Debe de ingresar un correo");
        }
      }

      function regresarBandera(){
        $(".partes").each(function( i ){
          window[dropdown_ + $(this).find('#id_parte').val()]=0;
        });
      }

      function guardarPartesNotificacion(){
        bandera=1;
        bandera_completo=0;
        bandera_procedimiento=0;
        var arr_partes = {
          "actor": [],
          "demandado": [],
          "tercero": []
        };


        $(".partes").each(function( i ){
          
          if($(this).find('#tipo').val()=='actor'){
            arr_partes.actor.push({
              'id': $(this).find('#id_parte').val(),
              'nombres': $(this).find('#nombres').val(),
              'apellido_paterno': ($(this).find('#apellido_paterno').val().trim() == '') ? '-' : $(this).find('#apellido_paterno').val(),
              'apellido_materno': ($(this).find('#apellido_materno').val().trim() == '') ? '-' : $(this).find('#apellido_materno').val(),
              'tipo': $(this).find('#tipo').val(),
              'tipo_persona': $(this).find('#tipo_persona').val(),
              'promovente': $(this).find('#promovente').val(),
              'estatus': $(this).find('#estatus').val(),
              'correo': ($(this).find('#correo').val().trim() == "") ? '-' : $(this).find('#correo').val(),
              'telefono': ($(this).find('#celular').val().trim() == "") ? '-' : $(this).find('#celular').val(),
              'notificacion': ($(this).find('#notificacion option:selected').val() === undefined) ? $(this).find('#notificacion').val() : $(this).find('#notificacion option:selected').val(),
              'direccion': ($(this).find('#direccion').val().trim() == "") ? '-' : $(this).find('#direccion').val(),
              'id_usuario_notificacion': ($(this).find('#id_litigante').val() == "") ? '0' : $(this).find('#id_litigante').val(),
              'extras': ($(this).find('#arr_acuerdos_notificacion_'+$(this).find('#id_parte').val()).val() == "") ? '' : $(this).find('#arr_acuerdos_notificacion_'+$(this).find('#id_parte').val()).val(),
            });


            if($(this).find('#notificacion option:selected').val()==3 && $(this).find('#direccion').val()!="" && $(this).find('#direccion').val()!="-"){
              bandera_completo=1;
            }
            else if($(this).find('#notificacion option:selected').val()==3){
              bandera=0;
              alert("La dirección es obligatoria");
              $(this).find('#direccion').focus();
            }

            //bandera de actualizacion
            if(($(this).find('#notificacion option:selected').val()==1 || $(this).find('#notificacion option:selected').val()==2) && ($(this).find('#correo').val()!="" || $(this).find('#correo').val()!="-")){
              bandera_completo=1;
              console.log('dos');
            }

            if(($(this).find('#correo').val()!="" && $(this).find('#correo').val()!="-")){
              bandera_procedimiento=1;
              console.log('dos');
            }
            


          }
          else if($(this).find('#tipo').val()=='demandado'){

            arr_partes.demandado.push({
              'id': $(this).find('#id_parte').val(),
              'nombres': ($(this).find('#nombres').val().trim() == '') ? '-' : $(this).find('#nombres').val(),
              'apellido_paterno': ($(this).find('#apellido_paterno').val().trim() == '') ? '-' : $(this).find('#apellido_paterno').val(),
              'apellido_materno': ($(this).find('#apellido_materno').val().trim() == '') ? '-' : $(this).find('#apellido_materno').val(),
              'tipo': $(this).find('#tipo').val(),
              'tipo_persona': $(this).find('#tipo_persona').val(),
              'promovente': $(this).find('#promovente').val(),
              'estatus': $(this).find('#estatus').val(),
              'correo': ($(this).find('#correo').val().trim() == '') ? '-' : $(this).find('#correo').val(),
              'telefono': ($(this).find('#celular').val().trim() == '') ? '-' : $(this).find('#celular').val(),
              'notificacion': ($(this).find('#notificacion option:selected').val() === undefined) ? $(this).find('#notificacion').val() : $(this).find('#notificacion option:selected').val(),
              'direccion': ($(this).find('#direccion').val().trim() == '') ? '-' : $(this).find('#direccion').val(),
              'id_usuario_notificacion': ($(this).find('#id_litigante').val() == "") ? '0' : $(this).find('#id_litigante').val(),
              'extras': ($(this).find('#arr_acuerdos_notificacion_'+$(this).find('#id_parte').val()).val() == "") ? '' : $(this).find('#arr_acuerdos_notificacion_'+$(this).find('#id_parte').val()).val(),
            });

            if($(this).find('#notificacion option:selected').val()==3 && $(this).find('#direccion').val()!="" && $(this).find('#direccion').val()!="-"){
              bandera_completo=1;
              console.log('tres');
            }
            else if($(this).find('#notificacion option:selected').val()==3){
              alert("La dirección es obligatoria");
              $(this).find('#direccion').focus();
              bandera=0;
            }

            //bandera de actualizacion
            if(($(this).find('#notificacion option:selected').val()==1 || $(this).find('#notificacion option:selected').val()==2) && ($(this).find('#correo').val()!="" || $(this).find('#correo').val()!="-")){
              bandera_completo=1;
              console.log('cuatro');
            }


            if(($(this).find('#correo').val()!="" && $(this).find('#correo').val()!="-")){
              bandera_procedimiento=1;
              console.log('cuatro');
            }

          }
          else if($(this).find('#tipo').val()=='tercero'){
            arr_partes.tercero.push({ 
              'id': $(this).find('#id_parte').val(),
              'nombres': ($(this).find('#nombres').val().trim() == '') ? '-' : $(this).find('#nombres').val(),
              'apellido_paterno': ($(this).find('#apellido_paterno').val().trim() == "") ? '-' : $(this).find('#apellido_paterno').val(),
              'apellido_materno': ($(this).find('#apellido_materno').val().trim() == '') ? '-' : $(this).find('#apellido_materno').val(),
              'tipo': $(this).find('#tipo').val(),
              'tipo_persona': $(this).find('#tipo_persona').val(),
              'promovente': $(this).find('#promovente').val(),
              'estatus': $(this).find('#estatus').val(),
              'correo': ($(this).find('#correo').val().trim() == "") ? '-' : $(this).find('#correo').val(),
              'telefono': ($(this).find('#celular').val().trim() == "") ? '-' : $(this).find('#celular').val(),
              'notificacion': ($(this).find('#notificacion option:selected').val() === undefined) ? $(this).find('#notificacion').val() : $(this).find('#notificacion option:selected').val(),
              'direccion': ($(this).find('#direccion').val().trim() == "") ? '-' : $(this).find('#direccion').val(),
              'id_usuario_notificacion': ($(this).find('#id_litigante').val() == "") ? '' : $(this).find('#id_litigante').val(),
              'extras': ($(this).find('#arr_acuerdos_notificacion_'+$(this).find('#id_parte').val()).val() == "") ? '' : $(this).find('#arr_acuerdos_notificacion_'+$(this).find('#id_parte').val()).val(),
            });
          }
        });

        console.log(arr_partes);
        console.log(bandera_completo);
        if(bandera==1){
          $.ajax({
              type:'POST',
              url:'/guardarPartesNotificacion',
              data: { arr_partes: arr_partes, juicio_id: $('#juicio_id').val(), tipo_expediente: $('#tipo_expediente').val(), toca: $('#toca').val(), anio_toca: $('#anio_toca_2').val(), asunto_toca: $('#asunto_toca').val(), expediente: $('#expediente').val(), anio: $('#anio').val(), bis: $('#bis').val() } ,
              success:function(data1){

                console.log(data1);
                if(data1.status==100){
                  console.log('Se guardó exitosamente.');

                  if(bandera_completo==1){
                    $('#estatus_notificacion_partes').html('<h5 class="tx-success">Con información de alguna de las partes. <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cargarInfoNotificacion($id_juicio,0,1);">Consulta aquí.</a></h5>');
                    $('#bandera_notificacion').val(1);
                  }
                  else{
                    $('#estatus_notificacion_partes').html('<h5 class="tx-danger">Ninguna de las partes esta completa. <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cargarInfoNotificacion($id_juicio,0,1);">Favor de validar aquí.</a></h5>');
                    $('#bandera_notificacion').val(0);
                  }


                  if(bandera_procedimiento==1){
                    $('#estatus_procedimiento_partes').html('<h5 class="tx-success">Con informacion de alguno de los interesados, se enviará correo. <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cargarInfoNotificacion($id_juicio, $tipo);">Consulta aquí.</a></h5><hr>');
                    $('#hidden_estatus_procedimiento_partes').val(1);
                  }
                  else{
                    $('#estatus_procedimiento_partes').html('<h5 class="tx-danger">Al menos uno de los interesados o el solicitante debe tener correo, por lo cual no se enviará correo. <a href="javascript:void(0);" data-toggle="modal" data-target="#modaldemo3" onclick="cargarInfoNotificacion($id_juicio, $tipo);">Favor de validar aquí.</a></h5><hr>');
                    $('#hidden_estatus_procedimiento_partes').val(0);
                  }
                  $script_guardar
                }
              }
          });
        }
      }

      function validarEmail(email) {
        var email = $(email).val();
        var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

        if (caract.test(email) == false){
            return false;
        }else{
            return true;
        }
      }




    </script>
    
EOF;
?>