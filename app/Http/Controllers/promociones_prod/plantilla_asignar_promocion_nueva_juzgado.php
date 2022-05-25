<?php


    $texto='';
    if(!isset($lista_expediente['response'][0]['datos_archivo']['id_juicio'])){

      //impar
      if( ($expediente % 2) == 1 and $request->session()->get('grupo_trabajo_identificar_area')=='B'){
        $texto.='<br><center><h4>No te corresponde ese expediente es de la secretaria A<h4></center><br>';

      }
      else if( ($expediente % 2) == 0 and $request->session()->get('grupo_trabajo_identificar_area')=='A'){
        $texto.='<br><center><h4>No te corresponde ese expediente es de la secretaria B<h4></center><br>';
      }
      else{

        $texto.='<h4 class="tx-inverse ">Sin información previa</h4><br><br>
        <form method="POST" action="" id="formulario_modal" enctype="multipart/form-data">
            <input type="hidden" name="juicio_id" id="juicio_id" value="0">
            <input type="hidden" name="promocion_id" id="promocion_id" value="">
            <div class="col-lg-12">
                <button class="btn btn-primary btn-block mg-b-10" onclick="openURL()" type="button">Crear expediente</button>
            </div><!-- col-4 -->
        </form>
        <script>
        function openURL(){
          
          window.location.href="/juicio/nuevo/";
        }
        </script>
        ';
      }
     
    }
    else{
        
        $texto.='
        <span class="tx-inverse ">
        <h5 class="tx-inverse ">Expedientes existentes:</h5>
        
        <div class="table-responsive">
            <table class="table mg-b-0">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Expediente</th>
                  <th>Secretaría</th>
                  <th>Partes</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>';

              for($i=0; $i<count($lista_expediente['response']); $i++){
                  $expediente=$lista_expediente['response'][$i]['datos_archivo']['expediente'].'/'.$lista_expediente['response'][$i]['datos_archivo']['anio'];
                  if($lista_expediente['response'][$i]['datos_archivo']['bis']!=""){
                    $expediente.='/'.$lista_expediente['response'][$i]['datos_archivo']['bis'];
                  }

                $texto.='
                <tr>
                  <th scope="row">'.($i+1).'</th>
                  <td>'.$expediente.'<br>'.$lista_expediente['response'][$i]['datos_archivo']['tipo_expediente'].'</td>
                  <td>';

                  if($lista_expediente['response'][$i]['datos_archivo']['secretaria']!=''){
                    $texto.=$lista_expediente['response'][$i]['datos_archivo']['secretaria'];
                  }
                  else{
                    $texto.='-';
                  }

                  $texto.=
                    '</td>
                  <td>';
                  
                    for($j=0; $j<count($lista_expediente['response'][$i]['partes']['actor']); $j++){
                        if($j==0){
                            $texto.='<strong>ACTOR</strong><br>';
                        }
                        $texto.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_expediente['response'][$i]['partes']['actor'][$j]['nombre'].' '.$lista_expediente['response'][$i]['partes']['actor'][$j]['apellido_paterno'].' '.$lista_expediente['response'][$i]['partes']['actor'][$j]['apellido_materno'].'</div>';
                    
                    }

                    if(isset($lista_expediente['response'][$i]['partes']['demandado'])){
                        for($j=0; $j<count($lista_expediente['response'][$i]['partes']['demandado']); $j++){
                            if($j==0){
                                $texto.='<strong>DEMANDADO</strong><br>';
                            }
                            $texto.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_expediente['response'][$i]['partes']['demandado'][$j]['nombre'].' '.$lista_expediente['response'][$i]['partes']['demandado'][$j]['apellido_paterno'].' '.$lista_expediente['response'][$i]['partes']['demandado'][$j]['apellido_materno'].'</div>';
                        }
                    }

                  
                  $texto.='</td>
                  
                  <td><a href="javascript:void(0);" onclick="seleccionarToca('.$lista_expediente['response'][$i]['datos_archivo']['id_juicio'].', \''.$expediente.'\', \''.$lista_expediente['response'][$i]['datos_archivo']['tipo_expediente'].'\');">Asignar promoción</a></td>
                </tr>';
              }
              $texto.='
              </tbody>
            </table>
          </div><!-- table-responsive -->

          <script>
              function seleccionarToca(id, texto, tipo){
                  
                $("#id_juicio_promocion").val(id);
                $("#juicio_promocion").val(texto);
                $("#informacion_toca").html("<h4 class=\"tx-success\">El archivo seleccionado: " + texto + " (" + tipo + ")</h4><br><br>" ); 
                $("#modaldemo3").modal("hide");
              }
              
          </script>
        ';
        
        $texto.='</span>';
        
        
    }
    

    $plantilla_archivo_header = <<<EOF
      <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Asignación de la promoción</h6>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
EOF;

    
    $plantilla_archivo_body = <<<EOF
        <div class="media-body table-responsive-xl" style="">

            <form method="POST" action="" id="formulario_modal" enctype="multipart/form-data">
            

            <div class="row">
            
                <div class="col-lg-12">
                    <br>
                </div>

                <div class="col-lg-12">
                    $texto
                </div>

                
            </div>
            </form>
        </div>
EOF;

?>