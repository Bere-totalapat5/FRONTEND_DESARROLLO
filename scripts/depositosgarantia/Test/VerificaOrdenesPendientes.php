<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);
    //define ("BASE_DIR","C:/Program Files/Apache Software Foundation/Apache2.2/SIBJDF/archivos");
    define ("BASE_DIR","");

    //local_host
        //require_once( "C:/Program Files/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');
    //REDIT
        require_once( "/var/www/php-inc/globals.php");

    $filePattern = "/^H2HREPHISOP_29144024_(\d{4})(\d{2})(\d{2}).out$/";

    $inDir = BASE_DIR . "/Banco/IN";
    $filesDir = BASE_DIR . "/Banco/Archivos";

    echo date("Conciliacion de pagos Y-m-d G:i\n");

    require_once( "$inc_dir/db_globals.php");
    require_once "$inc_dir/depositosgarantia/DBDGTransaccion.php";
   $dbTransaccion = new DBDGTransaccion();


    //Leemoseldirectorio
    $dirGestor = opendir($inDir);
    if ( $dirGestor === false ) {
        echo "\tNo se pudo leer directorio $inDir\n";
        exit();
    }

    //Leyendo archivos
    while( false !== ($archivo = readdir($dirGestor)) ) {

        $count=0;

        //Revisamos que sea un archivo de pendientes
        if(!preg_match($filePattern, $archivo, $matches))
            continue;

        //Obtenemosdirectorio para colocar el archivo
        //Lo creamossi no existe
        $localDir = $filesDir . "/" . $matches[1] . "/" . $matches[2] . "/" . $matches[3];
        if( !is_dir($localDir) )
            mkdir ($localDir, 0750, true);

        echo " \tAnalizando $archivo\n";

        //Abrimos archivo e iteramos líneas
        $fileGestor = fopen("$inDir/$archivo", "r");

        if($fileGestor===false){
            echo "\tNo se puede leer archivo $archivo\n";
            continue;
        }

        while( ($line = fgets($fileGestor)) !==false ) {
            $data = explode(",", $line);
            
            //Si no tiene el formato ignoramos la línea
            if(count($data)!= 16)
                continue;

            //Si existe la referencia actualizamos la transaccion
            $numeroOrden = $dbTransaccion->existeOrden($data[1]);
            if( $numeroOrden!== false){
                $fecha = substr($data[10],6,4) . "-" . substr($data[10],3,2) . "-" .substr($data[10],0,2);
                $dbTransaccion->actualizaEstatus($data[12], $fecha, $numeroOrden);

            }

        }
        fclose($fileGestor);
        rename("$inDir/$archivo", "$localDir/$archivo");

    }

?>
