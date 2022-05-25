<?php
    $acuerdo_id=$input['id_acuerdo'];

    

    $plantilla_archivo_header = <<<EOF
      <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Mala Publicación</h6>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
EOF;


    $plantilla_archivo_body = <<<EOF
            <div class="media-body table-responsive-xl" style="">

              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label" >Anotación:</label>
                  <textarea rows="3" class="form-control" placeholder="" id="comentarios_mala_publicacion" name="comentarios_mala_publicacion"></textarea>
                </div>
              </div> 

               

              <div class="col-lg-12">
              <button class="btn btn-primary btn-sm btn-block mg-b-10" onclick="crear_mala_publicacion($acuerdo_id);">Guardar</button>
              </div>
            </div>

            <script>
            $(document).ready(function() {
              $('.select2').select2({
                minimumResultsForSearch: Infinity
              });

              $('.fc-datepicker').datepicker({
                language: 'es',
                showOtherMonths: true,
                selectOtherMonths: true
              });

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