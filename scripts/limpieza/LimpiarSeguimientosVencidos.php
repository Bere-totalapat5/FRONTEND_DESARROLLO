<?php
    define("SCRIPT",1);

    //local_host
        require_once( "C:\Program Files\Apache Software Foundation\Apache2.2\SIBJDF/php-inc/globals.php");
    //AMAZON
        //require_once( "/var/www/php-inc/globals.php");
    // TSJDF
       // require_once( "/var/www/php-inc/globals.php");
    //REDIT
        //require_once( "/var/www/php-inc/globals.php");
    date_default_timezone_set('America/Mexico_City');

    require_once "$inc_dir/db/DBLimpieza.php";

    $dbLimpieza = new DBLimpieza();

    $seguimientos = $dbLimpieza->obtenSeguimientosVencidos();

    $count = 1;
    foreach ($seguimientos as $seguimiento){
        echo "***********************   $count  **************************\n";
        ++$count;

        $dbLimpieza->cancelarSeguimiento($seguimiento['id_usuario_juicio'],
                                         $seguimiento['estatus'],
                                         $seguimiento['cedula'],
                                         $seguimiento['id_juicio']);
        $dbLimpieza->agregarCancelacion($seguimiento['id_usuario_juicio'], $seguimiento['estatus'], 'vencimiento');
    }

?>
