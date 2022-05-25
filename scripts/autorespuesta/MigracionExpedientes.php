<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);

    //local_host
        require_once( "C:\Program Files\Apache Software Foundation\Apache2.2\SIBJDF/php-inc/globals.php");
    //AMAZON
        //require_once( "/var/php-inc/globals.php");
    // TSJDF
        //require_once( "/home/web/php-inc/globals.php");
    //REDIT
        //require_once( "/var/www/php-inc/globals.php");
    date_default_timezone_set('America/Mexico_City');
    echo "Migración de expedientes " . date("Y-m-d H:i\n");

    require_once "$inc_dir/db/DBUsuarioJuicio.php";

    $dbUsuarioJuicio = new DBUsuarioJuicio();
    $vencidos = $dbUsuarioJuicio->obtenerPruebasVencidas();

    $cont =0;
    foreach ($vencidos as $vencido){

        $paqueteActivo = $dbUsuarioJuicio->obtenerPaqueteActivo($vencido['id_usuario']);
        if($paqueteActivo===false)
            continue;
        $limite = intval($paqueteActivo['seguimiento']) - intval($paqueteActivo['usados']);

        if($limite>0){
            $rows = $dbUsuarioJuicio->migrarExpedientesVencidos(
                    $vencido['id_saldo_usuario'], $paqueteActivo['id_saldo_usuario'], $limite);
            if ( $rows!==false ){
                echo "\tMover $rows expedientes de " . $vencido['id_saldo_usuario'] . " a " . $paqueteActivo['id_saldo_usuario'] . "\n";
                ++$cont;
            }
        }
        
    }

    echo "\t $cont paquetes migrados";
?>