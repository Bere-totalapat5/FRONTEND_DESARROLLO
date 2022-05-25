<?php

    define("SCRIPT",1);
    date_default_timezone_set('America/Mexico_City');
    echo "Reporte de seguimientos SMS " . date("Y-m-d H:i\n");
    //local_host
        require_once( "C:\Program Files\Apache Software Foundation\Apache2.2\SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    // TSJDF
        //require_once( "/home/web/php-inc/globals.php");
    //REDIT
        //require_once( "/var/www/php-inc/globals.php");

        require_once "$inc_dir/calixta/CalixtaAPI.php";

        $calixta = new CalixtaAPI();


        /* ENVIOS*/
  /*
        	// Conjunto de parametros
	$prop = array (
                   array("establishHourRange", "0")
    	   );

	$calixta->setPropiedades($prop);

	$path = "/var/www/scripts/sms/expedientes.csv";
	$ret=$calixta->enviaMensajeArchivoCSV($path,"SICOR\\nActualizaciones en:EXPEDIENTES" , '12/03/2013/22/15');

	if ($ret>0){
		echo 'Mensaje enviado con éxito. (',$ret,')';
	}else{
		echo 'Ocurrió un error al enviar el mensaje (',$ret,')';
	}
  */
        /* RVISION*/

        $ret=$calixta->getReporteArchivo(7295662, $filePath . "/ResEnvio_298566.zip");
	if ($ret<=0){
		echo 'Ocurrió un error al enviar el mensaje (',$ret,')';
	}else{
		echo 'Mensaje enviado con éxito. (',$ret,')';
	}

 ?>
