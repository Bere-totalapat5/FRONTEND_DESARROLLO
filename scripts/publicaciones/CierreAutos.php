<?php

/*
 * cronjob
 * /php /scripts/publicaciones/CierreAutos.php >> 
 */
    define("SCRIPT",1);

    //local_host
        //require_once( "C:\Program Files\Apache Software Foundation\Apache2.2\SIBJDF/php-inc/globals.php");
    // TSJDF
        require_once( "/var/www/php-inc/globals.php");

    date_default_timezone_set('America/Mexico_City');
    echo "Cierre de Autos " . date("Y-m-d H:i\n");

    require_once( "$inc_dir/db_globals.php");
    require_once "$inc_dir/db/DBAuto.php";
    require_once "$inc_dir/utils/TimeUtils.php";

    $dbAuto = new DBAuto();
    $estatus = $dbAuto->getEstatus();
    
    $dbAuto->setEstatus('cerrado', '1');
    if($estatus=='firmado'){
        $dbAuto->setEstatus('publicado', '1');
        echo "Autos publicados\n";
    }
    else{
        $dbAuto->setEstatus('sin publicar', '1');
        echo "Autos sin publicar\n";
    }
    
?>
