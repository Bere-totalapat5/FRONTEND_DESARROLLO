<?php
    
    $id_juicio=($lista_archivos['response']['datos_toca'][0]['id_juicio']) ? "-" : $lista_archivos['response']['datos_toca'][0]['id_juicio'];
    $tipo_expediente=$lista_archivos['response']['datos_toca'][0]['tipo_expediente'];
    $toca=$lista_archivos['response']['datos_toca'][0]['toca'];
    $anio_toca=$lista_archivos['response']['datos_toca'][0]['anio_toca'];
    $asunto_toca=$lista_archivos['response']['datos_toca'][0]['asunto_toca'];
    $expediente=$lista_archivos['response']['datos_toca'][0]['expediente'];
    $bis=$lista_archivos['response']['datos_toca'][0]['bis'];
    $cuaderno=$lista_archivos['response']['datos_toca'][0]['cuaderno'];
    $alias=$lista_archivos['response']['datos_toca'][0]['alias'];
    $numero_expediente=$lista_archivos['response']['datos_toca'][0]['numero_expediente'];
    $resolucion_amparo=$lista_archivos['response']['datos_toca'][0]['resolucion_amparo'];
    $juzgado=$lista_archivos['response']['datos_toca'][0]['juzgado'];
    $juzgado_origen=$lista_archivos['response']['datos_toca'][0]['juzgado_origen'];
    $secretaria=$lista_archivos['response']['datos_toca'][0]['secretaria'];
    $fecha_publicacion=$lista_archivos['response']['datos_toca'][0]['fecha_publicacion'];
    $estatus=$lista_archivos['response']['datos_toca'][0]['estatus'];
    $id_tipojuicio=$lista_archivos['response']['datos_toca'][0]['id_tipojuicio'];
    $id_catalogo_juicios=$lista_archivos['response']['datos_toca'][0]['id_catalogo_juicios'];
    $id_etapaprocesal=$lista_archivos['response']['datos_toca'][0]['id_etapaprocesal'];
    $efecto_admite=$lista_archivos['response']['datos_toca'][0]['efecto_admite'];
    $efecto_admite_texto=$lista_archivos['response']['datos_toca'][0]['efecto_admite_texto'];
    $competencia=$lista_archivos['response']['datos_toca'][0]['competencia'];
    $interpone=$lista_archivos['response']['datos_toca'][0]['interpone'];
    $apela=$lista_archivos['response']['datos_toca'][0]['apela'];
    $tipo_recurso=$lista_archivos['response']['datos_toca'][0]['tipo_recurso'];
    $sas_bandera=$lista_archivos['response']['datos_toca'][0]['sas_bandera'];

    $toca_completo=$toca.'/'.$anio_toca;
    if($asunto_toca!=""){
        $toca_completo.='/'.$asunto_toca;
    }

    if($efecto_admite_texto!=""){
        $efecto_admite_texto=" - ".$efecto_admite_texto;
    }

    $html_partes_actor="";
    if(isset($lista_archivos['response']['partes']['partes']['actor'])){
        for($i=0; $i<count($lista_archivos['response']['partes']['partes']['actor']); $i++){
            $html_partes_actor.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response']['partes']['partes']['actor'][$i].'</div>';
        }
    }
    $html_partes_demandado="";
    if(isset($lista_archivos['response']['partes']['partes']['demandado'])){
        for($i=0; $i<count($lista_archivos['response']['partes']['partes']['demandado']); $i++){
            $html_partes_demandado.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response']['partes']['partes']['demandado'][$i].'</div>';
        }
    }

    $html_partes_tercero="";
    if(isset($lista_archivos['response']['partes']['partes']['terceros'])){
        for($i=0; $i<count($lista_archivos['response']['partes']['partes']['terceros']); $i++){
            $html_partes_tercero.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response']['partes']['partes']['terceros'][$i].'</div>';
        }
    }

    $plantilla_archivo_header = <<<EOF

    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detalles del Toca $toca_completo</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
EOF;

    $plantilla_archivo_body = <<<EOF
    <h4 class="tx-bold tx-inverse">Datos del toca</h4>
    <div class="col-12" style="" width="100%">
      <div class="form-layout form-layout-7">
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Sala:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $juzgado
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Ponencia:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $secretaria
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Tipo de archivo:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $tipo_expediente
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Tipo de recurso:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $tipo_recurso
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Competencia:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $competencia
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Toca / Cuaderno:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $toca_completo $cuaderno
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Estatus:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $estatus
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Fecha que se ingresó a la sala:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $fecha_publicacion
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Efecto en que se admite:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $efecto_admite    $efecto_admite_texto
                </div><!-- col-8 -->
              </div><!-- row -->
            </div><!-- form-layout -->
              <br>

              

            <h4 class="tx-bold tx-inverse">Datos del expediente ajunto</h4>

            <div class="form-layout form-layout-7">
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Expedientes:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Tipo de Juicio:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Juicio / Procedimiento
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Materia:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Juicio:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Tipo de acción:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Acción:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                
              </div><!-- col-8 -->
            </div><!-- row -->
          </div><!-- form-layout -->
          <br>

              

          <h4 class="tx-bold tx-inverse">Partes</h4>

          <div class="form-layout form-layout-7">
          <div class="row no-gutters">
            <div class="col-4 col-sm-3">
              Actor:
            </div><!-- col-4 -->
            <div class="col-8 col-sm-9">
                $html_partes_actor
            </div><!-- col-8 -->
          </div><!-- row -->
          <div class="row no-gutters">
            <div class="col-4 col-sm-3">
              Demandado:
            </div><!-- col-4 -->
            <div class="col-8 col-sm-9">
            $html_partes_demandado
            </div><!-- col-8 -->
          </div><!-- row -->
          <div class="row no-gutters">
            <div class="col-4 col-sm-3">
              Tercero
            </div><!-- col-4 -->
            <div class="col-8 col-sm-9">
            $html_partes_tercero
            </div><!-- col-8 -->
          </div><!-- row -->
          <div class="row no-gutters">
            <div class="col-4 col-sm-3">
              Recurrente:
            </div><!-- col-4 -->
            <div class="col-8 col-sm-9">
              
            </div><!-- col-8 -->
          </div><!-- row -->
          <div class="row no-gutters">
            <div class="col-4 col-sm-3">
              Resolución que se recurre:
            </div><!-- col-4 -->
            <div class="col-8 col-sm-9">
              
            </div><!-- col-8 -->
          </div><!-- row -->
        </div><!-- form-layout -->
    </div>



EOF;
?>