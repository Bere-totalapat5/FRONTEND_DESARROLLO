<?php
$valid_extensions = array('pdf');
include_once "Constantes.php";
header("Content-Type: application/json");
if($_FILES['file']){
 
 $img = $_FILES['file']['name'];
 $tmp = $_FILES['file']['tmp_name'];
 $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
 if(in_array($ext, $valid_extensions)){  
  $path = $path.$img; 
  if(move_uploaded_file($tmp,$path)){

    
    $binHash=hash_file('sha256', $path,true);
    $strB64Hash=base64_encode($binHash);


    $arr = array ('status'=>0,'description'=>"Satisfactorio",'path'=>base64_encode( $img),"digest"=>$strB64Hash);
    echo json_encode($arr); 
  }
 } 
else {
    $arr = array ('status'=>-1,'description'=>"Archivo no válido");
    echo json_encode($arr);
 }
}
?>