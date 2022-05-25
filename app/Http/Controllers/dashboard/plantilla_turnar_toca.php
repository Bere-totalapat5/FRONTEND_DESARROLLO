<?php

    $expediente_id=$input['id'];
    

    $plantilla_archivo_header = <<<EOF
      <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Turnar toca</h6>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
EOF;

    
    $plantilla_archivo_body = <<<EOF
        <div class="media-body table-responsive-xl" style="">

            <input type="hidden" name="expediente_id" id="expediente_id" value="$expediente_id">
            
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="card-profile-name">Selecciona la ponencia.</h3>
                </div>
            
                <div class="col-lg-12">
                    <br>
                </div>

                <div class="col-lg-12">
                    <div class="col-lg-4">
                        <select class="form-control select2" name="ponencia" id="ponencia" data-placeholder="Choose one">
                            <option value="1">Ponencia 1</option>
                            <option value="2">Ponencia 2</option>
                            <option value="3">Ponencia 3</option>
                        </select>
                    </div><!-- col-4 -->
                </div>

                <div class="col-lg-12 mg-t-30">
                    <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-block mg-b-10" onclick="guardarTurnado();">Turnar toca</button>
                    </div><!-- col-4 -->
                    </div>
                </div>
            </div>
            
        </div>
        <script>
        // Select2
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });

        function guardarTurnado(){
            $.ajax({
                type:'POST',
                url:'/turnarTocaGuardar',
                data: { expediente_id: $('#expediente_id').val(), ponencia: $('#ponencia').val() } ,
                success:function(data){
                    console.log(data);
                    if(data.status==100){
                      alert('Se guardó exitosamente.');
                      location.reload();
                    }
                    else{
                        alert(data.message);
                    }
                }
            });
        }

        </script>
        <style>
            .select2-container--open {
                z-index: 9999999
            }
        </style>
EOF;

?>