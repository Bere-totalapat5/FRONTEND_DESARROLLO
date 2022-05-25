<?php
define("SCRIPT", 1);
require_once("/var/www/php-inc/globals.php");
require_once("$inc_dir/db/DBAuto.php");
date_default_timezone_set('America/Mexico_City');
echo "Corrimiento de autos " . date("Y-m-d H:i\n");

$datosAuto = new DBAuto;
$auto_publicacion=$datosAuto->getAutoEstatus();

if(is_array($auto_publicacion) && $auto_publicacion[0][0]!='firmado'){

    $rows = $datosAuto->updateAutoPublicacion();	
    if($rows===false){
        echo "Error en base de datos.\n";            
    }
    else{
        echo "Se ha recorrido la fecha de publicación de $rows autos.\n";
    }
}
echo "\n";

?>
