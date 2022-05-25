<?php

    
    $texto='';
    if(!isset($lista_expediente['response'][0]['id'])){
        $texto='<h4 class="tx-inverse ">Sin información previa</h4><br><br>
        <form method="POST" action="" id="formulario_modal" enctype="multipart/form-data">
            <input type="hidden" name="juicio_id" id="juicio_id" value="0">
            <input type="hidden" name="promocion_id" id="promocion_id" value="">
            <div class="col-lg-12">
                <button class="btn btn-primary btn-block mg-b-10" onclick="openURL();" type="button">Crear Toca</button>
            </div><!-- col-4 -->
        </form>

        <script>
        function openURL(){
          window.location.href="/juicio/nuevo/";
        }
        </script>
        ';
    }
    else{
        
        $texto.='
        <span class="tx-inverse ">
        <h5 class="tx-inverse ">Tocas existentes:</h5>
        
        <div class="table-responsive">
            <table class="table mg-b-0">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Toca</th>
                  <th>Ponencia</th>
                  <th>Partes</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>';

              for($i=0; $i<count($lista_expediente['response']); $i++){
                $texto.='
                <tr>
                  <th scope="row">'.($i+1).'</th>
                  <td>'.$lista_expediente['response'][$i]['numero'].'<br>'.$lista_expediente['response'][$i]['tipo'].'</td>
                  <td>';

                  if($lista_expediente['response'][$i]['ponencia']!=''){
                    $texto.=$lista_expediente['response'][$i]['ponencia'];
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
                        $texto.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_expediente['response'][$i]['partes']['actor'][$j].'</div>';
                    
                    }

                    if(isset($lista_expediente['response'][$i]['partes']['demandado'])){
                        for($j=0; $j<count($lista_expediente['response'][$i]['partes']['demandado']); $j++){
                            if($j==0){
                                $texto.='<strong>DEMANDADO</strong><br>';
                            }
                            $texto.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_expediente['response'][$i]['partes']['demandado'][$j].'</div>';
                        }
                    }

                  
                  $texto.='</td>
                  
                  <td><a href="javascript:void(0);" onclick="seleccionarToca('.$lista_expediente['response'][$i]['id'].', \''.$lista_expediente['response'][$i]['numero'].'\', \''.$lista_expediente['response'][$i]['tipo'].'\');">Asignar promoción</a></td>
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
                $("#informacion_toca").html("<h4 class=\"tx-success\">El toca seleccionado: " + texto + " (" + tipo + ")</h4><br><br>" ); 
                $("#modaldemo3").modal("hide");
              }

              function openURL(){
                location="/juicio/nuevo/";
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