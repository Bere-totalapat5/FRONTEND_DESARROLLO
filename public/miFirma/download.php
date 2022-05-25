<?php
if(isset($_GET["fileName"])){
    $fichero = "/var/www/html/sicor_extendido_80/public/temporales/".$_GET["fileName"];

    if (file_exists($fichero)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($fichero).'"');
        header('Content-Length: ' . filesize($fichero));
        readfile($fichero);
        exit;
    }
    echo "Documento no encontrado";
  }
?>