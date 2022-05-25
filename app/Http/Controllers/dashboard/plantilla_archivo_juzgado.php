<?php
    use App\Http\Controllers\clases\utilidades;
     
    $id_juicio=$lista_archivos['response'][0]['datos_archivo']['id_juicio'];
    $tipo_expediente=$lista_archivos['response'][0]['datos_archivo']['tipo_expediente'];
    $expediente=$lista_archivos['response'][0]['datos_archivo']['expediente'];
    $bis=$lista_archivos['response'][0]['datos_archivo']['bis'];
    $cuaderno=$lista_archivos['response'][0]['datos_archivo']['cuaderno'];
    $alias=$lista_archivos['response'][0]['datos_archivo']['alias'];
    //$numero_expediente=$lista_archivos['response'][0]['datos_archivo']['numero_expediente'];
    //$resolucion_amparo=$lista_archivos['response'][0]['datos_archivo']['resolucion_amparo'];
    $juzgado=$request->session()->get('juzgado_nombre_largo');
    $juzgado_origen=$lista_archivos['response'][0]['datos_archivo']['juzgado_origen'];
    $secretaria=$lista_archivos['response'][0]['datos_archivo']['secretaria'];
    $fecha_publicacion=$lista_archivos['response'][0]['datos_archivo']['fecha_publicacion'];
    $estatus=$lista_archivos['response'][0]['datos_archivo']['estatus'];
    $id_tipojuicio=$lista_archivos['response'][0]['datos_archivo']['id_tipojuicio'];
    $id_catalogo_juicios=$lista_archivos['response'][0]['datos_archivo']['id_catalogo_juicios'];
    $id_etapaprocesal=$lista_archivos['response'][0]['datos_archivo']['id_etapaprocesal'];
    $efecto_admite=$lista_archivos['response'][0]['datos_archivo']['efecto_admite'];
    $efecto_admite_texto=$lista_archivos['response'][0]['datos_archivo']['efecto_admite_texto'];
    $competencia=$lista_archivos['response'][0]['datos_archivo']['competencia'];
    //$interpone=$lista_archivos['response'][0]['datos_archivo']['interpone'];
    //$apela=$lista_archivos['response'][0]['datos_archivo']['apela'];
    //$resolucion_recurre=$lista_archivos['response'][0]['datos_archivo']['resolucion_recurre'];
    //$recurrente=$lista_archivos['response'][0]['datos_archivo']['recurrente'];
    $tipo_recurso=$lista_archivos['response'][0]['datos_archivo']['tipo_recurso'];
    //$sas_bandera=$lista_archivos['response'][0]['datos_archivo']['sas_bandera'];


    if(isset($lista_archivos['response'][0]['tipo_juicio'][0]['accion'])){
        $juicio=$lista_archivos['response'][0]['tipo_juicio'][0]['juicio'];
        $accion=$lista_archivos['response'][0]['tipo_juicio'][0]['accion'];
        $materia=$lista_archivos['response'][0]['tipo_juicio'][0]['materia'];
        $JP=($lista_archivos['response'][0]['tipo_juicio'][0]['JP']=='P')?'Procedimiento':'Juicio';
        $M=$lista_archivos['response'][0]['tipo_juicio'][0]['M'];
        $J=$lista_archivos['response'][0]['tipo_juicio'][0]['J'];
        $TA=$lista_archivos['response'][0]['tipo_juicio'][0]['TA'];
        $ACC=$lista_archivos['response'][0]['tipo_juicio'][0]['ACC'];
    } 
    else{
        $juicio=$lista_archivos['response'][0]['tipo_juicio'][0]['juicio'];
        $accion="";
        $materia="";
        $JP="";
        $M="";
        $J="";
        $TA="";
        $ACC="";
    }
    

    if($efecto_admite_texto!=""){
        $efecto_admite_texto=" - ".$efecto_admite_texto;
    }

    

    $html_partes_actor="";
    $bandera1=$bandera2=0;
    
    
    if(isset($lista_archivos['response'][0]['partes']['actor'])){
        for($i=0; $i<count($lista_archivos['response'][0]['partes']['actor']); $i++){

          if((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $lista_archivos['response'][0]['datos_archivo']['id_catalogo_juicios'])) and $lista_archivos['response'][0]['partes']['actor'][$i]['parte_promovente']==0 and $bandera1==0){
            $html_partes_actor.='<strong>INTERESADOS</strong><br>';
            $bandera1=1; 
            $sello=0; 
          }

          else if((utilidades::buscarCatalogoBandera($request->entorno["catalogos"]["divorcio_expres_sigj"], $lista_archivos['response'][0]['datos_archivo']['id_catalogo_juicios'])) and $lista_archivos['response'][0]['partes']['actor'][$i]['parte_promovente']==1 and $bandera2==0){
            $html_partes_actor.='<strong>PROMOVENTE</strong><br>';
            $bandera2=1;
            $sello=0;
          }
          else if($bandera1==0){
            $html_partes_actor.='<strong>ACTOR</strong><br>';
            $bandera1=1;
          }


          $html_partes_actor.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response'][0]['partes']['actor'][$i]['nombre'].' '.$lista_archivos['response'][0]['partes']['actor'][$i]['apellido_paterno'].' '.$lista_archivos['response'][0]['partes']['actor'][$i]['apellido_materno'].'</div>';
        }
    }
    $html_partes_demandado="";
    if(isset($lista_archivos['response'][0]['partes']['demandado'])){
        for($i=0; $i<count($lista_archivos['response'][0]['partes']['demandado']); $i++){
            $html_partes_demandado.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response'][0]['partes']['demandado'][$i]['nombre'].' '.$lista_archivos['response'][0]['partes']['demandado'][$i]['apellido_paterno'].' '.$lista_archivos['response'][0]['partes']['demandado'][$i]['apellido_materno'].'</div>';
        }
    }

    $html_partes_tercero="";
    if(isset($lista_archivos['response'][0]['partes']['tercero'])){
        for($i=0; $i<count($lista_archivos['response'][0]['partes']['tercero']); $i++){
            $html_partes_tercero.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_archivos['response'][0]['partes']['tercero'][$i]['nombre'].' '.$lista_archivos['response'][0]['partes']['tercero'][$i]['apellido_paterno'].' '.$lista_archivos['response'][0]['partes']['tercero'][$i]['apellido_materno'].'</div>';
        }
    }

    $titulo_actores="ACTOR:";
    if($bandera2==1){
      $titulo_actores="INTERESADOS:";
    }
   

    $plantilla_archivo_header = <<<EOF

    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detalles del Expediente</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
EOF;

    $plantilla_archivo_body = <<<EOF
    
    <div class="col-12" style="" width="100%">
      <div class="form-layout form-layout-7">
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Juzgado:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $juzgado
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Secretaria:
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
                  Estatus:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $estatus
                </div><!-- col-8 -->
              </div><!-- row -->
              <div class="row no-gutters">
                <div class="col-4 col-sm-3">
                  Fecha de creación:
                </div><!-- col-4 -->
                <div class="col-8 col-sm-9">
                  $fecha_publicacion
                </div><!-- col-8 -->
              </div><!-- row -->
              



              
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Juicio / Procedimiento
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                $JP
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Materia:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                $materia
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Juicio:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                $juicio
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Tipo de acción:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                $TA
              </div><!-- col-8 -->
            </div><!-- row -->
            <div class="row no-gutters">
              <div class="col-4 col-sm-3">
                Acción:
              </div><!-- col-4 -->
              <div class="col-8 col-sm-9">
                $accion
              </div><!-- col-8 -->
            </div><!-- row -->



            </div><!-- form-layout -->
              <br>

              
              

          <h4 class="tx-bold tx-inverse">Partes</h4>

          <div class="form-layout form-layout-7">
          <div class="row no-gutters">
            <div class="col-4 col-sm-3">
              $titulo_actores
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
              Tercero:
            </div><!-- col-4 -->
            <div class="col-8 col-sm-9">
            $html_partes_tercero
            </div><!-- col-8 -->
          </div><!-- row -->
          
          
    </div>



EOF;
?>