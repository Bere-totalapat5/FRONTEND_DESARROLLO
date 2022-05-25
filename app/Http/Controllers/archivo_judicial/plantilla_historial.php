
<?php
    use App\Http\Controllers\clases\utilidades;
    
    $historial="<center><h4><br>No hay historial<br><br><br></h4></center>";

    if(isset($lista_historial['response'][0]['id_archivo_judicial'])){
      $historial='<div class="form-layout form-layout-7">';
      for($i=0; $i<count($lista_historial['response']); $i++){
        $historial.='
                    <div class="row no-gutters">
                      <div class="col-4 col-sm-3">
                        Folio: '.$lista_historial['response'][$i]['folio'].'  <br>
                        '.utilidades::acomodarFechaHora($lista_historial['response'][$i]['creacion']).'
                      </div><!-- col-4 -->
                      <div class="col-6 col-sm-6">';
                      if($lista_historial['response'][$i]['archivo_judicial_estatus']=='archivo_judicial'){
                        $historial.='Resguardo';
                      }
                      else if($lista_historial['response'][$i]['archivo_judicial_estatus']=='destruccion'){
                        $historial.='Destrucción';
                      }
                      else{
                        $historial.='Devolución';
                      }
                      
                      $historial.='<br>Fojas: '.$lista_historial['response'][$i]['archivo_judicial_fojas'].'
                      </div><!-- col-8 -->
                      <div class="col-2 col-sm-3">
                        <a href="javascript:void()" onclick="descargarDocumento('.$lista_historial['response'][$i]['archivo_judicial_folio_lista'].');">Documento</a>
                      </div><!-- col-8 -->
                    </div><!-- col-8 -->';
      }
      $historial.=' </div>';
    }

    $id_juicio=$input['id_juicio'];
   

    $plantilla_archivo_header = <<<EOF

    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Archivo Judicial</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
EOF;

    $agregar_txt='';
    if($agregar==1){
      $agregar_txt='
      <input type="hidden" name="id_juicio" id="id_juicio" value="'.$id_juicio.'">
      <div class="col-12">
        <div class="d-md-flex mg-b-30">
          <div class="form-group mg-b-0 mg-md-l-20 mg-t-20 mg-md-t-0">
            <label>Fojas: <span class="tx-danger">*</span></label>
            <input type="text" name="fojas" id="fojas" class="form-control wd-100" placeholder="" required>
          </div><!-- form-group -->
          <div class="form-group mg-b-0 mg-t-25">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-primary pd-x-20" onclick="guardarLista()">Agregar a la lista</button>
          </div>
        </div><!-- d-flex -->
      </div>
    ';
    }
 
    $plantilla_archivo_body = <<<EOF
    
    $agregar_txt
    

    <h4 class="tx-bold tx-inverse">Historial del expediente</h4>
    <div class="col-12" style="" width="100%">
      <div class="form-layout form-layout-7">
        
      $historial
 
      </div><!-- form-layout -->          
    </div>
    <script>
      function guardarLista(){
        $.ajax({
          type:'POST',
          url:'/archivoJudicial/agregar_lista',
          data:{ id_juicio:$('#id_juicio').val(), fojas:$('#fojas').val() },
          success:function(data){
            console.log(data);
            alert('Se agregró exitosamente');
            $('#modaldemo3').modal('hide')
          }
        });
      }

      function descargarDocumento(id){
        $.ajax({
          type:'POST',
          url:'/archivoJudicial/descargar_archivo',
          data:{ id:id },
          success:function(data){
            console.log(data);
            window.open(data.response);
          }
        });
      }

    </script>



EOF;
?>