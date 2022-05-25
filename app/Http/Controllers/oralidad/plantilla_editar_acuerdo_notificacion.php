<?php

    $acuerdo_id=$input['acuerdo_id'];
    $juicio_id=$input['juicio_id'];
    $id_not= $input['id_acuerdo_notificacion'];

    $selectDocumento="";
    if(isset($lista_actuarios['response'][0]['id_usuario'])){
      for($i=0; $i<count($lista_actuarios['response']); $i++){
        $selectDocumento.='<option value="'.$lista_actuarios['response'][$i]['id_usuario'].'" >'.$lista_actuarios['response'][$i]['usuario'].'</option>';
      }
    }
 

 
    $plantilla_archivo_header = <<<EOF
      <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Notificación electrónica</h6>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
EOF;

    if($lista_actuarios['status']==0){
        $error=$lista_actuarios['message'];
        $plantilla_archivo_body = <<<EOF
    <h4 class="tx-bold tx-inverse">$error</h4>

EOF;
    }
    else{
        if($lista_actuarios['status']==100){

            $plantilla_archivo_body = <<<EOF
            <div class="media-body table-responsive-xl" style="">

              



            <div class="col-lg-6 usuario_actuarios" >
      
              <div class="form-group">
                <label class="form-control-label" >Elija al usuario que realizará la notificación:</label><br>
                <select class="form-control select2" data-placeholder="" id="lista_actuario" name="lista_actuario" >
                  $selectDocumento
                </select>
              </div>
            
            </div>




            <div class="row" style="margin-top:20px;">
              
              <div class="col-lg-6">
              <button class="btn btn-primary  btn-block mg-b-10" onclick="guardarNotificacionAcuerdo($id_not);">Asignar notificación</button>
              </div>

             

              </div>
            </div>

            <script>
            $(document).ready(function() {
              $('.select2').select2({
                minimumResultsForSearch: Infinity
              });

            });

            function guardarNotificacionAcuerdo(id){
              
              $.ajax({
                  type:'POST',
                  url:'/oralidad/formularioAcuerdoNotificacionGuardarAjax',
                  data:{ id_not:id, lista_actuario:$("#lista_actuario").val()   },
                  success:function(data){
                      console.log(data);
                      alert('Se guardó exitosamente.');
                      location.reload();
                  }
              });
            }

            </script>
            <style>
            .select2-container--open {
                z-index: 9999999
            }
            .datepicker{ 
              z-index:9999999 !important; 
         }
            </style>
EOF;
        }
        else{
            $plantilla_archivo_body ='<h4 class="tx-bold tx-inverse">No existe el flujo</h4>';
        }

    }


?>