<?php
    $id_juicio=($lista_archivos['response']['datos_toca'][0]['id_juicio']) ? "-" : $lista_archivos['response']['datos_toca'][0]['id_juicio'];
    $tipo_expediente=$lista_archivos['response']['datos_toca'][0]['tipo_expediente'];
    $toca=$lista_archivos['response']['datos_toca'][0]['toca'];
    $anio_toca=$anio_toca_2=$lista_archivos['response']['datos_toca'][0]['anio_toca'];
    $asunto_toca=$lista_archivos['response']['datos_toca'][0]['asunto_toca'];

    $expediente=$lista_archivos['response']['datos_toca'][0]['expediente'];
    $anio=$lista_archivos['response']['datos_toca'][0]['anio'];
    $bis=$lista_archivos['response']['datos_toca'][0]['bis'];

    $toca_completo=$toca.'/'.$anio_toca;
    if($asunto_toca!=""){
        $toca_completo.='/'.$asunto_toca;
    }
    $boton_guardar=$script_guardar='';
    if(isset($input['guardar']) and $input['guardar']==1){
      $boton_guardar='<button class="btn btn-primary btn-block mg-b-10" onclick="guardarPartesNotificacion();">Guardar</button>';
      $script_guardar='alert("Se guardo exitosamente");';
    }

    $html_partes_actor=$acuerdos."";
    if(isset($lista_archivos['response']['partes']['partes']['actor'])){
        
        for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){

          if($lista_archivos['response']['partes']['partes']['actor'][$i]['promovente']==1){
            $html_partes_actor.='<h5 class="tx-bold tx-inverse">Promovente</h5>';
          }
          else{
            $html_partes_actor.='<h5 class="tx-bold tx-inverse">Actor</h5>';
          }


            $html_partes_actor.='<div class="partes">
            <label class="ckbox" style="float:right;">
                <input type="checkbox" value="1" id="notificacion" name="notificacion" '; if($lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="si"){  $html_partes_actor.='checked '; }    $html_partes_actor.='><span>Marcar para notificar</span>
              </label>
            
            <div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response']['partes']['partes']['actor'][$i]['nombre'].'</div>';
            $html_partes_actor.='
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group mg-b-0">
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
                <div class="form-group mg-b-0">
                  <label>Celular:</label>
                  <input type="text" id="celular" name="datos['.$lista_archivos['response']['partes']['partes']['actor'][$i]['id'].'][celular]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['actor'][$i]['telefono'].'" placeholder="" >
                </div><!-- form-group -->
              </div>
              <!--
              <div class="col-lg-12">
                <button class="btn btn-secondary btn-sm  mg-b-10" onclick="validarLitigante(this);">Validar</button> <span class="mg-l-5" id="estatus_correo">'; if(isset($lista_archivos['response']['partes']['partes']['actor'][$i]['datos_usuario'][0]['usuario'])){ $html_partes_actor.='  Correo registrado con el usuario: <strong>'.$lista_archivos['response']['partes']['partes']['actor'][$i]['datos_usuario'][0]['usuario'].'</strong>'; }else if(!isset($lista_archivos['response']['partes']['partes']['actor'][$i]['datos_usuario'][0]['usuario']) and $lista_archivos['response']['partes']['partes']['actor'][$i]['notificacion']=="si"){  $html_partes_actor.='Correo no registrado, se enviará invitación.';   }else{ $html_partes_actor.='';  } $html_partes_actor.='</span>
              </div>
              -->
            </div>
            </div>
            <br>';
        }
    }
    $html_partes_demandado="";
    if(isset($lista_archivos['response']['partes']['partes']['demandado'])){
      $html_partes_demandado.='<hr>';
      for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){
        $html_partes_demandado.='<h5 class="tx-bold tx-inverse">Demandado</h5>';

          $html_partes_demandado.='<div class="partes">
          <label class="ckbox" style="float:right;">
                <input type="checkbox" value="1" id="notificacion" name="notificacion" '; if($lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="si"){  $html_partes_demandado.='checked '; }    $html_partes_demandado.='><span>Marcar para notificar</span>
              </label>
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
                <div class="form-group mg-b-0">
                  <label>Celular:</label>
                  <input type="text" id="celular" name="datos['.$lista_archivos['response']['partes']['partes']['demandado'][$i]['id'].'][celular]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['telefono'].'" placeholder="" >
                </div><!-- form-group -->
              </div>
              <!--
              <div class="col-lg-12">
                <button class="btn btn-secondary btn-sm  mg-b-10" onclick="validarLitigante(this);">Validar</button>  <span class="mg-l-5" id="estatus_correo">'; if(isset($lista_archivos['response']['partes']['partes']['demandado'][$i]['datos_usuario'][0]['usuario'])){ $html_partes_demandado.='  Correo registrado con el usuario: <strong>'.$lista_archivos['response']['partes']['partes']['demandado'][$i]['datos_usuario'][0]['usuario'].'</strong>'; }else if(!isset($lista_archivos['response']['partes']['partes']['demandado'][$i]['datos_usuario'][0]['usuario']) and $lista_archivos['response']['partes']['partes']['demandado'][$i]['notificacion']=="si"){  $html_partes_demandado.='Correo no registrado, se enviará invitación.';   }else{ $html_partes_demandado.='';  } $html_partes_demandado.='</span>
              </div>
              -->
            </div>
            </div>
            <br>';
      }
    }

    $html_partes_tercero="";
    if(isset($lista_archivos['response']['partes']['partes']['terceros'])){
      $html_partes_tercero.='<hr><h5 class="tx-bold tx-inverse">Tercero</h5>';
      for($i=0; $i<count($lista_archivos['response']['partes']['partes']['terceros']); $i++){
          $html_partes_tercero.='<div class="partes">
          <label class="ckbox" style="float:right;">
                <input type="checkbox" value="1" id="notificacion" name="notificacion" '; if($lista_archivos['response']['partes']['partes']['terceros'][$i]['notificacion']=="si"){  $html_partes_tercero.='checked '; }    $html_partes_tercero.='><span>Marcar para notificar</span>
              </label>
          <input type="hidden" id="id_parte" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['id'].'"><div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['nombre'].'</div>';
          $html_partes_tercero.='
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group mg-b-0">
                  <label>Correo electrónico: </label>
                  <input type="text" id="correo" name="datos['.$lista_archivos['response']['partes']['partes']['terceros'][$i]['id'].'][correo]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['correo'].'" placeholder="" >

                  <input type="hidden" id="tipo" value="terceros">
                  <input type="hidden" id="id_parte" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['id'].'">
                  <input type="hidden" id="nombres" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['nombres'].'">
                  <input type="hidden" id="apellido_paterno" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['apeliido_paterno'].'">
                  <input type="hidden" id="apellido_materno" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['apellido_materno'].'">
                  <input type="hidden" id="tipo" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['tipo'].'">
                  <input type="hidden" id="tipo_persona" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['tipo_persona'].'">
                  <input type="hidden" id="promovente" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['promovente'].'">
                  <input type="hidden" id="estatus" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['estatus'].'">
                  <input type="hidden" id="id_litigante" value="'; if(isset($lista_archivos['response']['partes']['partes']['terceros'][$i]['datos_usuario'][0]['id_usuario'])){ $html_partes_tercero.=$lista_archivos['response']['partes']['partes']['terceros'][$i]['datos_usuario'][0]['id_usuario']; }else{ $html_partes_tercero.='0';  } $html_partes_tercero.='">

                </div><!-- form-group -->
              </div>
              <div class="col-lg-6">
                <div class="form-group mg-b-0">
                  <label>Celular:</label>
                  <input type="text" id="celular" name="datos['.$lista_archivos['response']['partes']['partes']['terceros'][$i]['id'].'][celular]" class="form-control" value="'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['telefono'].'" placeholder="" >
                </div><!-- form-group -->
              </div>
              <!--
              <div class="col-lg-12">
                <button class="btn btn-secondary btn-sm  mg-b-10" onclick="validarLitigante(this);">Validar</button>  <span class="mg-l-5" id="estatus_correo">'; if(isset($lista_archivos['response']['partes']['partes']['terceros'][$i]['datos_usuario'][0]['usuario'])){ $html_partes_tercero.='  Correo registrado con el usuario: <strong>'.$lista_archivos['response']['partes']['partes']['terceros'][$i]['datos_usuario'][0]['usuario'].'</strong>'; }else{ $html_partes_tercero.='';  } $html_partes_tercero.='</span>
              </div>
            -->
            </div>
            </div>
            <br>';
      }
    }

    $plantilla_archivo_header = <<<EOF
    
    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Datos para las notificaciones.</h6>
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

      $(function(  ){
        
      });

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

      function guardarPartesNotificacion(){

        var arr_partes = {
          "actor": [],
          "demandado": [],
          "terceros": []
        };


        $(".partes").each(function( i ){

          if($(this).find('#tipo').val()=='actor'){
            arr_partes.actor.push({
              'id': $(this).find('#id_parte').val(),
              'nombres': $(this).find('#nombres').val(),
              'apellido_paterno': ($(this).find('#apellido_paterno').val() == "") ? '-' : $(this).find('#apellido_paterno').val(),
              'apellido_materno': ($(this).find('#apellido_materno').val() == '') ? '-' : $(this).find('#apellido_materno').val(),
              'tipo': $(this).find('#tipo').val(),
              'tipo_persona': $(this).find('#tipo_persona').val(),
              'promovente': $(this).find('#promovente').val(),
              'estatus': $(this).find('#estatus').val(),
              'correo': ($(this).find('#correo').val() == "") ? '' : $(this).find('#correo').val(),
              'telefono': ($(this).find('#celular').val() == "") ? '' : $(this).find('#celular').val(),
              'notificacion': ($(this).find('#notificacion').is(':checked') == true) ? '1' : 0,
              'id_usuario_notificacion': ($(this).find('#id_litigante').val() == "") ? '' : $(this).find('#id_litigante').val()
            });

            


          }
          else if($(this).find('#tipo').val()=='demandado'){

            arr_partes.demandado.push({
              'id': $(this).find('#id_parte').val(),
              'nombres': ($(this).find('#nombres').val() == '') ? '-' : $(this).find('#nombres').val(),
              'apellido_paterno': ($(this).find('#apellido_paterno').val() == "") ? '-' : $(this).find('#apellido_paterno').val(),
              'apellido_materno': ($(this).find('#apellido_materno').val() == '') ? '-' : $(this).find('#apellido_materno').val(),
              'tipo': $(this).find('#tipo').val(),
              'tipo_persona': $(this).find('#tipo_persona').val(),
              'promovente': $(this).find('#promovente').val(),
              'estatus': $(this).find('#estatus').val(),
              'correo': ($(this).find('#correo').val() == "") ? '-' : $(this).find('#correo').val(),
              'telefono': ($(this).find('#celular').val() == "") ? '-' : $(this).find('#celular').val(),
              'notificacion': ($(this).find('#notificacion').is(':checked') == true) ? '1' : 0,
              'id_usuario_notificacion': ($(this).find('#id_litigante').val() == "") ? '' : $(this).find('#id_litigante').val()
            });
          }
          else if($(this).find('#tipo').val()=='terceros'){
            arr_partes.terceros.push({
              'id': $(this).find('#id_parte').val(),
              'nombres': ($(this).find('#nombres').val() == '') ? '-' : $(this).find('#nombres').val(),
              'apellido_paterno': ($(this).find('#apellido_paterno').val() == "") ? '-' : $(this).find('#apellido_paterno').val(),
              'apellido_materno': ($(this).find('#apellido_materno').val() == '') ? '-' : $(this).find('#apellido_materno').val(),
              'tipo': $(this).find('#tipo').val(),
              'tipo_persona': $(this).find('#tipo_persona').val(),
              'promovente': $(this).find('#promovente').val(),
              'estatus': $(this).find('#estatus').val(),
              'correo': ($(this).find('#correo').val() == "") ? '-' : $(this).find('#correo').val(),
              'telefono': ($(this).find('#celular').val() == "") ? '-' : $(this).find('#celular').val(),
              'notificacion': ($(this).find('#notificacion').is(':checked') == true) ? '1' : 0,
              'id_usuario_notificacion': ($(this).find('#id_litigante').val() == "") ? '' : $(this).find('#id_litigante').val()
            });
          }

        });

        console.log(arr_partes);
        $.ajax({
            type:'POST',
            url:'/guardarPartesNotificacion',
            data: { arr_partes: arr_partes, juicio_id: $('#juicio_id').val(), tipo_expediente: $('#tipo_expediente').val(), toca: $('#toca').val(), anio_toca: $('#anio_toca_2').val(), asunto_toca: $('#asunto_toca').val(), expediente: $('#expediente').val(), anio: $('#anio').val(), bis: $('#bis').val() } ,
            success:function(data1){
                console.log(data1);
                if(data1.status==100){
                  console.log('Se guardó exitosamente.');
                  $script_guardar
                }
            }
        });
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