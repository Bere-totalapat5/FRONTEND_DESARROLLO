<?php
    date_default_timezone_set('America/Mexico_City');
    echo "VerificaOut: " . date("Y-m-d H:i") . "\n";
    define("SCRIPT",1);
    require_once("/var/www/depgar/php-inc/globals.php");
    require_once "$inc_dir/db/DBPersona.php";

    $inDirectory = "/Banco/IN";
    $destDirectory = "/Banco/Archivos";

    $filePattern = "/^tran(\d{8})(\d{2})98_PJDF\.out$/";
    $dBPersona = new DBPersona();
    
    $fecha = date('Y-m-d');
	$nuevafecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

	echo $nuevafecha;

  /*  if ( $gestor = opendir($inDirectory) ) {

    while (false !== ($archivo = readdir($gestor))) {
        if( preg_match($filePattern, $archivo,$matches)==1 ){
            $dia = substr($matches[1],0,2);
            $mes = substr($matches[1],2,2);
            $anio = substr($matches[1],4,4);

            $fileMng = fopen("$inDirectory/$archivo", "r");
            if(!$fileMng)
                continue;

            while( ($line=fgets($fileMng))!= false ){
                $tipoRegistro = substr($line, 0,2);
                if($tipoRegistro=='02'){
                    $numeroOrden = substr($line, 42, 16);
                    $codigo= substr($line, 400, 2);
                    if($codigo=='00')
                        $dBPersona->actualizarEstatus ($numeroOrden, 'ACEPTADO');
                    else{
                        $dBPersona->actualizarEstatus ($numeroOrden, 'MOVIMIENTO RECHAZADO');
                        $dBPersona->actualizarMotivoDevolucion($numeroOrden, $codigo);
                    }
                }
            }
            fclose($fileMng);

 	    $aux = "$destDirectory/$anio/$mes/$dia";
            if( !is_dir($aux) )
            mkdir ($aux, 0775, true);

            rename("$inDirectory/$archivo", "$aux/$archivo");
        }
        
    }

    closedir($gestor);
}*/
?>
