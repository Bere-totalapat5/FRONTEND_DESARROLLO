<?php
use App\Http\Controllers\clases\utilidades;

$texto="";
if(isset($lista['response'][0])){
$texto.='<div class="table-responsive">
<table class="table mg-b-0">
  <thead>
    <tr>
      <th>Coreo / Dirección</th>
      <th>Tipo Notificación</th>
      <th>Estatus</th>
      <th>Fecha notificación</th>
      <th>Usuario notificado</th>
    </tr>
  </thead>
  <tbody>';


  for($i=0; $i<count($lista['response']); $i++){
    $texto.='<tr>
    <th scope="row">'.$lista['response'][$i]['parte_correo'].'</th>
    <td>';
      if($lista['response'][$i]['tipo_notificacion']==1){
        $texto.='Notificación electrónica por Artículo 113';
      }
      else if($lista['response'][$i]['tipo_notificacion']==2){
        $texto.='Notificación correo electrónico del actuario';
      }
      else if($lista['response'][$i]['tipo_notificacion']==3){
        $texto.='Notificación física';
      }
    
    $texto.='</td>
    <td>'.$lista['response'][$i]['noti_elect_estatus_envio'].'</td>
    <td>';
    if($lista['response'][$i]['noti_elect_estatus_envio']=='notificado'){
      if($lista['response'][$i]['tipo_notificacion']==3){
        $texto.=utilidades::acomodarFechaMinHora($lista['response'][$i]['noti_elect_modificacion']);
      }
      else{
        $texto.=utilidades::acomodarFechaMinHora($lista['response'][$i]['acuerdo_notificacion_creacion']);
      }
    }
    else{
      $texto.='-';
    }
    $texto.='</td>
    <td>';
    if($lista['response'][$i]['noti_elect_estatus_leido']=="leido"){
      $texto.=$lista['response'][$i]['noti_elect_estatus_leido'].'<br>'.utilidades::acomodarFechaMinHora($lista['response'][$i]['noti_elect_modificacion']);
    }
    else{
      $texto.="Sin estatus";
    }
    $texto.='</td>
  </tr>';
  }

  $texto.=' </tbody>
  </table>
</div><!-- table-responsive -->';

}
else{
  $texto="<center><h4 class='tx-warning'><br><br><br>Aún no se realiza la notificación<br><br><br></h4></center>";
}

$plantilla_archivo_header = <<<EOF

    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Actualización del documento</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
EOF;

$plantilla_archivo_body = <<<EOF
    

              $texto
             
EOF;

?>