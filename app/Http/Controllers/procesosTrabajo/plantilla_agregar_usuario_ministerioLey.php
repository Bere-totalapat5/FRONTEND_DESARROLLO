<?php
    $hidden='';

    $option='';
    if(isset($lista['response'][0]['id_usuario'])){
        for($i=0; $i<count($lista['response']); $i++){
          if($estatus==1 and $lista['response'][$i]['id_usuario']==$id_usuario){
            $option.='<option value="'.$lista['response'][$i]['id_usuario'].'">'.$lista['response'][$i]['nombre'].'</option>';
          }
          elseif($estatus==0){
            $option.='<option value="'.$lista['response'][$i]['id_usuario'].'">'.$lista['response'][$i]['nombre'].'</option>';
          }
        }
      }

      $estatus_txt='Activar Ministerio <input type="hidden"  name="activo" id="activo" value="1">';
      if($estatus==1){
        $estatus_txt='Desactivar Ministerio';
      }

 
    $plantilla_archivo_body = <<<EOF
    <h4 class="tx-bold tx-inverse">Ministerio de Ley</h4>
    
    <form action="/procesosTrabajo/ministerioLey/guardarMinisterioLey" id="formulario_asignar" method="POST" enctype="multipart/form-data" >
        <input type="hidden" value="$id_ministerio" id="id_ministerio" name="id_ministerio">
        
        <div class="form-layout form-layout-7">
                <div class="row no-gutters">
                  <div class="col-4 col-sm-3">
                      Usuario:
                  </div><!-- col-4 -->
                  <div class="col-8 col-sm-9">
              
                      <select class="form-control select2 select2-show-search" onchange="" id="por_id" name="por_id" > 
                      $option
                      </select>
                  </div><!-- col-8 -->

                </div><!-- row -->


                <div class="row no-gutters">
                  <div class="col-4 col-sm-3">
                      Fecha de inicio:
                  </div><!-- col-4 -->
                  <div class="col-8 col-sm-9">
              
                    <div class="input-group col-sm-4" >
                        <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                        </div>
                        <input type="text"  class="form-control fc-datepicker" name="fecha_inicial" id="fecha_inicial" readonly="readonly" >
                    </div>
                  </div><!-- col-8 -->

                </div><!-- row -->


                <div class="row no-gutters">
                  <div class="col-4 col-sm-3">
                      Fecha de finalización:
                  </div><!-- col-4 -->
                  <div class="col-8 col-sm-9">
              
                      <div class="input-group col-sm-4" >
                        <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                        </div>
                        </div>
                        <input type="text"  class="form-control fc-datepicker" name="fecha_hasta" id="fecha_hasta" readonly="readonly" >
                    </div>
                  </div><!-- col-8 -->

                </div><!-- row -->


                <div class="row no-gutters">
                  <div class="col-4 col-sm-3">
                      Acción:
                  </div><!-- col-4 -->
                  <div class="col-8 col-sm-9">
              
                    
                      $estatus_txt
                    
                  </div><!-- col-8 -->

                </div><!-- row -->


                <div class="row no-gutters">
                  <div class="col-4 col-sm-3">
                      Migrar acuerdos:
                  </div><!-- col-4 -->
                  <div class="col-8 col-sm-9">
              
                    <label class="ckbox">
                      <input type="checkbox" checked name="migracion" value="1"><span>Migrar acuerdos por firmar pendientes</span>
                    </label>
                  </div><!-- col-8 -->

                </div><!-- row -->


                <br>
                <button class="btn btn-success btn-block mg-b-10" >Realizar cambio</button>
            
        </div><!-- form-layout -->

        
    </form>

      <script>

        $(function(){
          'use strict';

          $('.select2').select2({
            minimumResultsForSearch: Infinity
          });

         
            $('.fc-datepicker').datepicker({
              language: 'es',
              showOtherMonths: true,
              selectOtherMonths: true,
              dateFormat: 'yyyy-mm-dd',
            });

            var currentDate = currentDate = new Date();
            $('.fc-datepicker').data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()));
            $('#fecha_hasta').data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()))

          

        });

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
?>