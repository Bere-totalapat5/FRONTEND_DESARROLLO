<?php

    $juzgado=$lista[0]['datos_evento']['nombre'];
    $ponencia=$lista[0]['datos_evento']['evento_ponencia'];
    $evento_fecha=$lista[0]['datos_evento']['evento_fecha'];
    $evento_hora_inicio=$lista[0]['datos_evento']['evento_hora_inicio'];
    $evento_hora_final=$lista[0]['datos_evento']['evento_hora_final']; 
    $evento_liga=$lista[0]['datos_evento']['evento_liga'];
    $evento_ponencia=$lista[0]['datos_evento']['evento_ponencia'];

    $accion=$lista[0]['datos_acuerdo']['accion'];
    $acuerdo=$lista[0]['datos_acuerdo']['acuerdo'];
    $fecha_publicacion=$lista[0]['datos_acuerdo']['fecha_publicacion'];
    $evento_liga=$lista[0]['datos_evento']['evento_liga'];
    
    $correos="";
    for($i=0; $i<count($lista[0]['correos']); $i++){
        if($lista[0]['correos'][$i]['correo_destinatario']!="miguel.acevedo@tsjcdmx.gob.mx" and $lista[0]['correos'][$i]['correo_destinatario']!="salvador.rios@tsjcdmx.gob.mx" and $lista[0]['correos'][$i]['correo_destinatario']!="salvador.rios@tsjcdmx.gob.mx" and $lista[0]['correos'][$i]['correo_destinatario']!="iarellano@totalpat.com" and $lista[0]['correos'][$i]['correo_destinatario']!="lchavez@totalpat.com"){
            $correos.=$lista[0]['correos'][$i]['correo_nombre_destinatario']." ".$lista[0]['correos'][$i]['correo_destinatario']."<br>";
        }
    }
    
    

    $plantilla_archivo_header = <<<EOF
      <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detalles del evento</h6>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
EOF;

    $plantilla_archivo_body = <<<EOF
    <div class="media-body table-responsive-xl" style="">

        

        <h4 class="tx-bold tx-inverse">Datos del evento</h4>
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
                    Acuerdo:
                    </div><!-- col-4 -->
                    <div class="col-8 col-sm-9">
                    $acuerdo
                    </div><!-- col-8 -->
                </div><!-- row -->
                <div class="row no-gutters">
                    <div class="col-4 col-sm-3">
                    Ponencia:
                    </div><!-- col-4 -->
                    <div class="col-8 col-sm-9">
                    $ponencia
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
                <div class="row no-gutters">
                    <div class="col-4 col-sm-3">
                    Fecha de inicio:
                    </div><!-- col-4 -->
                    <div class="col-8 col-sm-9">
                    $evento_fecha $evento_hora_inicio
                    </div><!-- col-8 -->
                </div><!-- row -->
                <div class="row no-gutters">
                    <div class="col-4 col-sm-3" style="text-align:right;">
                    Fecha de finalización:
                    </div><!-- col-4 -->
                    <div class="col-8 col-sm-9">
                    $evento_fecha $evento_hora_final
                    </div><!-- col-8 -->
                </div><!-- row -->
                <div class="row no-gutters">
                    <div class="col-4 col-sm-3">
                    Liga:
                    </div><!-- col-4 -->
                    <div class="col-8 col-sm-9">
                    $evento_liga
                    </div><!-- col-8 -->
                </div><!-- row -->
                <div class="row no-gutters">
                    <div class="col-4 col-sm-3">
                    Involucrados:
                    </div><!-- col-4 -->
                    <div class="col-8 col-sm-9">
                    $correos
                    </div><!-- col-8 -->
                </div><!-- row -->
        </div>

    </div>

    <script>

       

    </script>
    <style>
        .select2-container--open {
            z-index: 9999999
        }
    </style>
            
EOF;
        


?>