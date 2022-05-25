<?php
    use App\Http\Controllers\clases\acuerdos;

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
                  <th>Acuerdos</th>
                </tr>
              </thead>
              <tbody>';

              for($i=0; $i<count($lista_expediente['response']); $i++){


                $lista_acuerdos=acuerdos::obtener_archivo_acuerdos($request, $lista_expediente['response'][$i]['datos_archivo']['id_juicio']);


                $expediente=$lista_expediente['response'][$i]['datos_archivo']['expediente'].'/'.$lista_expediente['response'][$i]['datos_archivo']['anio'];
                if($lista_expediente['response'][$i]['datos_archivo']['bis']!=""){
                $expediente.='/'.$lista_expediente['response'][$i]['datos_archivo']['bis'];
                }

                $texto.='
                <tr>
                  <td scope="row">'.($i+1).'</td>
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
                  if(isset($lista_expediente['response'][$i]['partes']['actor'])){
                    for($j=0; $j<count($lista_expediente['response'][$i]['partes']['actor']); $j++){
                        if($j==0){
                            $texto.='<strong>ACTOR</strong><br>';
                        }
                        $texto.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_expediente['response'][$i]['partes']['actor'][$j]['nombre'].' '.$lista_expediente['response'][$i]['partes']['actor'][$j]['apellido_paterno'].' '.$lista_expediente['response'][$i]['partes']['actor'][$j]['apellido_materno'].'</div>';
                    
                    }
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
                  <td >
                    <ul>';
                  if(isset($lista_acuerdos['response'][0])){
                    for($j=0; $j<count($lista_acuerdos['response']); $j++){
                        $texto.='<li>'.$lista_acuerdos['response'][$j]['acuerdo'].' <a href="javascript:void(0);" onclick="seleccionarToca('.$lista_acuerdos['response'][$j]['id_acuerdo'].', \''.$lista_acuerdos['response'][$j]['acuerdo'].'\', \''.$lista_expediente['response'][$i]['datos_archivo']['secretaria'].'\');">Asignar Agenda</a></li>';
                    }
                  }

                $texto.='</ul>
                
                </td></tr>';
              }
              $texto.='
              </tbody>
            </table>
          </div><!-- table-responsive -->

          <script> 
              function seleccionarToca(id_acuerdo, texto, secretaria){
                  
                $("#id_acuerdo_promocion").val(id_acuerdo);
                $("#ponencia_evento").val(secretaria);
                $("#id_juicio_promocion").val(id_acuerdo);
                $("#juicio_promocion").val(texto);
                $("#informacion_toca").html("<h5 class=\"tx-success\">El archivo seleccionado: " + texto + "</h5><br><br>" );

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