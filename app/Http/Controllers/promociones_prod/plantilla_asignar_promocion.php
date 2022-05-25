<?php

    $expediente=$input['expediente'];
    $promocion_id=$input['promocion_id'];
    $boton=$texto='';
    $juicio_id=0;

    if($lista_expediente['status']==0){
        $texto='<h5 class="tx-inverse ">Sin información previa</h5>';
        $boton='Crear Archivo';
    }
    else{
        $juicio_id=$lista_expediente['response'][0]['id'];
        $texto.='
        <span class="tx-inverse ">
        <h5 class="tx-inverse ">Archivo existente: ' . $expediente.'</h5>';

        
        for($i=0; $i<count($lista_expediente['response'][0]['partes']['actor']); $i++){
            if($i==0){
                $texto.='<strong>ACTOR</strong><br>';
            }
            $texto.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_expediente['response'][0]['partes']['actor'][$i].'</div>';
        }

        if(isset($lista_expediente['response'][0]['partes']['demandado'])){
            for($i=0; $i<count($lista_expediente['response'][0]['partes']['demandado']); $i++){
                if($i==0){
                    $texto.='<strong>DEMANDADO</strong><br>';
                }
                $texto.='<div style="border-left: solid 3px #22558c; margin-bottom:5px; padding-left:5px;">'.$lista_expediente['response'][0]['partes']['demandado'][$i].'</div>';
            }
        }
        
        $texto.='</span>';
        $boton='Incluir en el archivo';
        
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
            <input type="hidden" name="promocion_id" id="promocion_id" value="$promocion_id">
            <input type="hidden" name="juicio_id" id="juicio_id" value="$juicio_id">

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="card-profile-name">Administración de promociones</h3>
                </div>
            
                <div class="col-lg-12">
                    <br>
                </div>

                <div class="col-lg-12">
                    $texto
                </div>

                <div class="col-lg-12 mg-t-30">
                    <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-block mg-b-10" onclick="">$boton</button>
                    </div><!-- col-4 -->
                    </div>
                </div>
            </div>
            </form>
        </div>
EOF;

?>