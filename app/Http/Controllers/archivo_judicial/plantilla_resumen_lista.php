
<?php
    use App\Http\Controllers\clases\utilidades;
    
    $historial="";

 
    if(isset($arr_imprimir[0])){
      $pagina=1;
      for($i=0; $i<count($arr_imprimir); $i++){
        
        if($arr_imprimir[$i]!=""){

          $arr_imprimir_datos=explode('/**/', $arr_imprimir[$i]);

           
          $historial.='
          <tr>
            <td scope="row">
            <input type="hidden" value="'.$pagina.'" name="datos[num][]">
            '.$pagina.'
            </td>
            <td>
            <input type="hidden" value="'.$arr_imprimir_datos[0].'" name="datos[id_juicio][]">
            <input type="hidden" value="'.$arr_imprimir_datos[1].'" name="datos[expediente][]">
            '.$arr_imprimir_datos[1].'</td>
            <td>
            <input type="hidden" value="'.$arr_imprimir_datos[2].'" name="datos[actor][]">
            '.$arr_imprimir_datos[2].'</td>
            <td>
            <input type="hidden" value="'.$arr_imprimir_datos[3].'" name="datos[demandado][]">
            '.$arr_imprimir_datos[3].'</td>
            <td>
            <input type="hidden" value="'.$arr_imprimir_datos[4].'" name="datos[juicio][]">
            '.$arr_imprimir_datos[4].'</td>
            <td>
              <div class="col-lg">
                <input class="form-control" placeholder="" type="text" name="datos[fojas][]" value="'.$arr_imprimir_datos[5].'" required>
              </div><!-- col -->
            </td>
          </tr>';
          $pagina++;
        }
      }
    }

    //$id_juicio=$input['id_juicio'];
   

    $plantilla_archivo_header = <<<EOF

    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Archivo Judicial</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
EOF;

    
    $plantilla_archivo_body = <<<EOF
    
    <form action="/archivoJudicial/cambiar_estatus_archivo" target="_blank" method="POST" onsubmit="refreshPage()" data-parsley-validate>
      <div class="row">
        <div class="col-lg-4">
          <div class="form-group mg-b-0 mg-md-l-20 mg-t-20 mg-md-t-0">
            <label>Folio: <span class="tx-danger">*</span></label>
            <input type="text" name="folio" class="form-control " placeholder="" required>
          </div><!-- form-group -->
        </div>
        <div class="col-lg-4">
          <div class="form-group mg-b-0 mg-md-l-20 mg-t-20 mg-md-t-0">
            <label>Tipo de lista: <span class="tx-danger">*</span></label>
            <select class="form-control select2" id="tipo_archivo_judicial" name="tipo_archivo_judicial">
              <option value="archivo_judicial">Resguardo</option>
              <option value="devolucion">Devolución</option>
              <option value="destruccion">Destrucción</option>
            </select>
          </div><!-- form-group -->
        </div>
        <div class="col-lg-4">
            <div class="form-group mg-b-0 mg-t-25">
              <label>&nbsp;</label>
              <button type="submit" class="btn btn-primary pd-x-20">Crear Archivo Judicial</button>
            </div>
          </div><!-- d-flex -->
        </div>
      </div>
      <br>
    

      <h4 class="tx-bold tx-inverse">Lista de expedientes</h4>
      <div class="table-responsive">
            <table class="table table-striped mg-b-0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Expediente</th>
                  <th>Actor</th>
                  <th>Demandado</th>
                  <th>Juicio</th>
                  <th>Fojas</th>
                </tr>
              </thead>
              <tbody>
                $historial
              </tbody>
            </table>
    </form>
    

EOF;
?>