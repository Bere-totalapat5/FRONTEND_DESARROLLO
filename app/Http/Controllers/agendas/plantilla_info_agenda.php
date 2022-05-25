<?php

    $descripcion=$lista['response'][0]['descripcion'];

    $acuerdo="";
    $id_acuerdo=0;
    if(isset($lista['response'][0]['datos_juicio']['datos'][0]['acuerdo'])){
        $acuerdo=$lista['response'][0]['datos_juicio']['datos'][0]['tipo_expediente']." ".$lista['response'][0]['datos_juicio']['datos'][0]['acuerdo'];
        $id_acuerdo=$lista['response'][0]['datos_juicio']['datos'][0]['id_acuerdo'];
    }
    
    $fecha=$lista['response'][0]['fecha'];
    $arr_fecha=explode('-', $fecha);
    $dia=$arr_fecha[2];
    $mes=$arr_fecha[1];
    $anio=$arr_fecha[0];

    $hora_final=$lista['response'][0]['hora_final'];
    $hora_inicio=$lista['response'][0]['hora_inicio'];
    $id_evento=$lista['response'][0]['id_evento'];
    $intervalo_min=$lista['response'][0]['intervalo_min'];
    $liga=$lista['response'][0]['liga'];
    $nombre=$lista['response'][0]['nombre'];
    $noti_correo=$lista['response'][0]['noti_correo'];
    $noti_sms=$lista['response'][0]['noti_sms'];
    $ponencia=$lista['response'][0]['ponencia'];
    

    $selected_5="";
    $selected_10="";
    $selected_15="";
    $selected_20="";
    $selected_25="";
    $selected_30="";
    $selected_35="";
    $selected_40="";
    $selected_45="";
    $selected_50="";
    $selected_55="";
    $selected_60="";

    ${"selected_" . $intervalo_min} = "selected";

    $selected_ponencia1="";
    $selected_ponencia2="";
    $selected_ponencia3="";
    $selected_ponenciaA="";
    $selected_ponenciaB="";
    $selected_ponenciaC="";
    $disabled_ponencia="";
    $ponencia_hidden="";
    
    ${"selected_ponencia" . $ponencia} = "selected";

    $vista="unit";
    if($sesion['grupo_trabajo_tipo_area']=='ponencia'){
      $disabled_ponencia="disabled";
      $ponencia_hidden='<input type="hidden" name="ponencia_evento" id="ponencia_evento" value="'.$ponencia.'">';
      $vista="day";
    }

    $select_ponencia="";
    if($ponencia==1 or $ponencia==2 or $ponencia==3){
        $select_ponencia.='<option value="1" '.$selected_ponencia1.' >1</option>';
        $select_ponencia.='<option value="2" '.$selected_ponencia2.' >2</option>';
        $select_ponencia.='<option value="3" '.$selected_ponencia3.' >3</option>';
    }
    else{
        $select_ponencia.='<option value="A" '.$selected_ponenciaA.' >A</option>';
        $select_ponencia.='<option value="B" '.$selected_ponenciaB.' >B</option>';
        //$select_ponencia.='<option value="C" '.$selected_ponenciaC.' >C</option>';
    }



    $selected_correo="";
    if($noti_correo==1){
      $selected_correo="checked";
    }

    $selected_sms="";
    if($noti_sms==1){
      $selected_sms="checked";
    }

    $plantilla_archivo_header = <<<EOF
      <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detalles del acuerdo</h6>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
EOF;

    if($lista['status']==0){
        $error=$lista['message'];
        $plantilla_archivo_body = <<<EOF
    <h4 class="tx-bold tx-inverse">$error</h4>

EOF;
    }
    else{
        if($lista['status']==100){

            $plantilla_archivo_body = <<<EOF
            <div class="media-body table-responsive-xl" style="">

              <form method="POST" action="/agendas/guardarEventoEditado" id="formulario_modal" enctype="multipart/form-data">
                <input type="hidden" name="fecha_evento" id="fecha_evento_mod" value="$fecha">
                <input type="hidden" name="id_evento" id="id_evento" value="$id_evento">
                <input type="hidden" name="id_acuerdo" id="id_acuerdo" value="$id_acuerdo">
                <input type="hidden" name="estatus_eliminacion" id="estatus_eliminacion" value="0">
                $ponencia_hidden

                <div class="row">
                    <div class="col-lg-5">
                        <h3 class="card-profile-name">Agenda de Audiencias</h3>
                    </div>
                    <div class="col-lg-7">
                        <h4 class="card-profile-name tx-uppercase">$acuerdo</h4>
                    </div>

                    
                
                    <div class="col-lg-5">
                        <div id="cal_here_modal" ></div>
                    </div>

                    <div class="col-lg-7">
                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label">Evento: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" id="nombre_evento" name="nombre_evento"  value="$nombre" placeholder="" required>
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label">Descripción: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" id="descripcion_evento" name="descripcion_evento"  value="$descripcion" placeholder="" required>
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label">Secretaría: <span class="tx-danger">*</span></label>
                                <select id="ponencia_evento" class="form-control select2" name="ponencia_evento" $disabled_ponencia >
                                    $select_ponencia
                                </select>
                            </div>
                        </div><!-- col-4 -->

                        <div class="col-lg-12">

                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%;">

                                <div class="form-group">
                                    <label class="form-control-label">Inicio: <span class="tx-danger">*</span></label>
                            <div class="wd-150 mg-b-30">
                                <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                    </div><!-- input-group-text -->
                                </div><!-- input-group-prepend -->
                                <input id="hora_inicio" name="hora_inicio" type="text" class="form-control tp2" placeholder="00:00" value="$hora_inicio" required>
                                </div>
                            </div><!-- wd-150 -->
                            </div>

                                    </td>
                                    <td style="width: 50%;">


                                        <div class="form-group">
                                            <label class="form-control-label">Finalización: <span class="tx-danger">*</span></label>
                                    <div class="wd-150 mg-b-30">
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <i class="fa fa-clock-o tx-16 lh-0 op-6"></i>
                                            </div><!-- input-group-text -->
                                        </div><!-- input-group-prepend -->
                                        <input id="hora_final" name="hora_final" type="text" class="form-control tp2" placeholder="00:00" value="$hora_final" required>
                                        </div>
                                    </div><!-- wd-150 -->
                                    </div>



                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <div class="col-lg-12" style="display:none;"> 
                        <hr>
                        <div class="row">
                            
                            <div class="col-lg-2 mg-t-20">
                                <h5 class="card-profile-name">Recordatorio</h5>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mg-b-0">
                                    <label>Minutos antes del evento: <span class="tx-danger">*</span></label>
                                    <select id="intervalo_min" class="form-control select2" name="intervalo_min" data-placeholder="Minutos antes del evento">
                                        <option value="5" $selected_5>5</option>
                                        <option value="10" $selected_10>10</option>
                                        <option value="15" $selected_15>15</option>
                                        <option value="20" $selected_20>20</option>
                                        <option value="25" $selected_25>25</option>
                                        <option value="30" $selected_30>30</option>
                                        <option value="35" $selected_35>35</option>
                                        <option value="40" $selected_40>40</option>
                                        <option value="45" $selected_45>45</option>
                                        <option value="50" $selected_50>50</option>
                                        <option value="55" $selected_55>55</option>
                                        <option value="60" $selected_60>60</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 mg-t-20">
                                <label class="ckbox">
                                    <input type="checkbox" id="recordatorio_sms" name="recordatorio_sms" value="1" $selected_sms><span>Enviar por SMS</span>
                                </label>
                            </div>
                            <div class="col-lg-3 mg-t-20">
                                <label class="ckbox">
                                    <input type="checkbox" id="recordatorio_correo" name="recordatorio_correo" value="1" $selected_correo><span>Enviar por email</span>
                                </label>
                            </div>
                        </div>
                    </div><!-- col-4 -->

                    <div class="col-lg-12 mg-t-30">
                      <div class="row">

                        <div class="col-lg-6">
                            <button class="btn btn-danger btn-block mg-b-10" onclick="$('#estatus_eliminacion').val(1);">Eliminar agenda</button>
                        </div><!-- col-4 -->

                        <div class="col-lg-6">
                            <button class="btn btn-primary btn-block mg-b-10" onclick="">Guardar agenda</button>
                        </div><!-- col-4 -->
                      </div>
                    </div>

                </div>
              </form>
            </div> 

            <script>

              $(document).ready(function() {
                
                var calendar_modal = scheduler.renderCalendar({
                    container:"cal_here_modal", 
                    date:new Date($anio,$mes-1,$dia),
                    navigation:true,
                    handler:function(date){
                        //console.log(scheduler.getState().mode);
                        scheduler.setCurrentView(date, '$vista');
                        //console.log(date.getDate());
                        //console.log(date.getMonth());
                        //console.log(date.getFullYear());
                        $('#fecha_evento_mod').val(date.getFullYear()+'-'+(date.getMonth()+1)+"-"+date.getDate());
                    }
                });
                $('.select2').select2({
                  minimumResultsForSearch: Infinity
                });
                $('.tp2').timepicker({'scrollDefault': 'now', 'timeFormat': "H:i", 'minTime': '7:00', 'maxTime': '18:00'});
              });

              $("#formulario_modal").submit(function() {
                  if ($('#estatus_eliminacion').val() == "1") {
                      if(confirm('Esta seguro de eliminar el evento?')){
                        return true;
                      }
                      else{
                        return false;
                      }
                      
                  }
              });

            </script>
            <style>
              .select2-container--open {
                  z-index: 9999999
              }
            </style>
            
EOF;
        }
        else{
            $plantilla_archivo_body ='<h4 class="tx-bold tx-inverse">No existe el flujo</h4>';
        }

    }


?>