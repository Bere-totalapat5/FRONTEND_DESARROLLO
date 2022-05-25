<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);
    date_default_timezone_set('America/Mexico_City');
    echo date("Reporte de seguimientos SMS Y-m-d G:i\n");
    //local_host
        //require_once( "C:\Program Files\Apache Software Foundation\Apache2.2\SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    // TSJDF
        //require_once( "/home/web/php-inc/globals.php");
    //REDIT
        require_once( "/var/www/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');


    $ADMIN_PHONE= array("5591988906","5518390081","5527245813");

    require_once( "$inc_dir/db_globals.php");


    echo "\n$fecha Prueba conexion\n ";

    $url ="http://caballeroantonio.dyndns-ip.com:8800/Send%20Text%20Message.htm";
    //$url ="http://caballeroantonio.isa-geek.com:8800/Send%20Text%20Message.htm";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

    //Aviso de inicio
    foreach ($ADMIN_PHONE as $phone){
        $query = "PhoneNumber=" . $phone . "&Text=Probando conexión SICOR";
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $query);
        if( curl_exec($ch) )
            echo "Conexión establecida\n";
        else{
            echo "Error de conexión" . curl_error($ch) ."\n";
        }

    }


    curl_close($ch);    
?>