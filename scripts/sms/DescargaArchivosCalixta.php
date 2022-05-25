<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);
    date_default_timezone_set('America/Mexico_City');
    echo "Resultados de envio de SMS " . date("Y-m-d G:i\n");
    //local_host
        require_once( "C:\Program Files\Apache Software Foundation\Apache2.2\SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    // TSJDF
        //require_once( "/home/web/php-inc/globals.php");
    //REDIT
        //require_once( "/var/www/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');




    require_once( "$inc_dir/db_globals.php");
    require_once "$inc_dir/db/DBArchivoCalixta.php";
    require_once "$inc_dir/calixta/CalixtaAPI.php";


    $outPath = $files_dir . "/SMS/";
    $filePath = date("Y/m/");
    if(!is_dir($outPath.$filePath))
            mkdir($outPath.$filePath , 0750, true);



    $dbArchivoCalixta = new DBArchivoCalixta();
    $archivos = $dbArchivoCalixta->obtenArchivosPorDescargar();
    $calixta = new CalixtaAPI();


    foreach ($archivos as $archivo){

        $ret=$calixta->getReporteArchivo(
                $archivo->id_envio,
                $filePath . "/" . $archivo->id_archivo_calixta . ".zip");

	if ($ret<=0){
		$dbArchivoCalixta->incrementaIntentos($archivo->id_archivo_calixta);
	}else{
		echo 'Mensaje enviado con éxito. (',$ret,')';
	}

        $respuesta = $

    }




?>