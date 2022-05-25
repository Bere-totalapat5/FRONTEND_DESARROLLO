<?php
    define("SCRIPT",1);
    echo "Cancelacion de seguimientos " . date("Y-m-d G:i\n");

    //local_host
    
        require_once( "C:\Program Files\Apache Software Foundation\Apache2.2\SIBJDF\php-inc\globals.php");
    
    //redit
        //require_once( "/var/www/php-inc/globals.php");

        require_once "$inc_dir/db/DBUsuarioJuicio.php";

    $dbUsuarioJuicio = new DBUsuarioJuicio();
    $folios = $dbUsuarioJuicio->obtenCancelaciones();

    foreach ($folios as $folio){
        echo "Cancelando folio " . $folio->getId_usuario_juicio();
        $dbUsuarioJuicio->desasignarJuicio($folio->getId_juicio(), $folio->getId_usuario());
    }

    ?>