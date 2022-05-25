<?php

     
    $texto='';
    if(!isset($lista_expediente[0]->id_juicio)){
        $texto='<h4 class="tx-inverse ">Sin información previa</h4><br><br>

        <h3 style="color:red;">Por favor de registrar el asunto en el SICOR para confirmar y visualizar esta promoción.</h3>
        <br><br>

        <!--
        <form method="POST" action="/promociones/guardarAsignacion" id="formulario_modal" enctype="multipart/form-data">
            <input type="hidden" name="juicio_id" id="juicio_id" value="0">
            <input type="hidden" name="promocion_id" id="promocion_id" value="'.$promocion_id.'">
            <input type="hidden" name="tipo_juicio_id" id="tipo_juicio_id" value="'.$tipo_juicio_id.'">
            <div class="col-lg-12">
                <button class="btn btn-primary btn-block mg-b-10" onclick="">Crear expediente</button>
            </div><!-- col-4 -- >
        </form>
        -->
       ';
        
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

              for($i=0; $i<count($lista_expediente); $i++){
                  $expediente=$lista_expediente[$i]->expediente.'/'.$lista_expediente[$i]->anio;
                  if($lista_expediente[$i]->bis!=""){
                    $expediente.='/'.$lista_expediente[$i]->bis;
                  }

                $texto.='
                <tr>
                  <th scope="row">'.($i+1).'</th>
                  <td>'.$expediente.'<br>'.$lista_expediente[$i]->tipo_expediente.'</td>
                  <td>';

                  if($lista_expediente[$i]->secretaria!=''){
                    $texto.=$lista_expediente[$i]->secretaria;
                  }
                  else{
                    $texto.='-';
                  }

                  $texto.=
                    '</td>
                  <td>';
                  
                    
                        
                    $texto.='<strong>ACTOR</strong><br>';
                    
                    $texto.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_expediente[$i]->p1_nombre.'</div>';
                    
                    

                    if($lista_expediente[$i]->p2_nombre!=""){
                        $texto.='<strong>DEMANDADO</strong><br>';
                                
                        $texto.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_expediente[$i]->p2_nombre.'</div>';
                    }
                  
                  $texto.='</td>
                  
                  <td><a href="javascript:void(0);" onclick="guardarConfirmacion('.$lista_expediente[$i]->id_juicio.', '.$promocion_id.');" style="text-decoration: underline;"><strong>Agregar al expediente</strong></a></td>
                </tr>';
              }
              $texto.='
              </tbody>
            </table>
          </div><!-- table-responsive -->

          <script>
              
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

            <form method="POST" action="/promociones/guardarAsignacion" id="formulario_modal" enctype="multipart/form-data">
            

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