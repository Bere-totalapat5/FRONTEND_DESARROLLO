<?php
    //local_host
        //require_once( "C:/Archivos de programa/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');
    //REDIT
    define("SCRIPT",1);
    require_once( "/var/www/php-inc/globals.php");
    require_once "$inc_dir/depositosgarantia/DBDGTransaccion.php";

    $inDirectory = "/Banco/IN";
    $destDirectory = "/Banco/Archivos";

    $filePattern = "/^tran(\d{8})(\d{2})98_PJDF\.80.out$/";
    $dBDGTransaccion = new DBDGTransaccion();

    if ( ($gestor = opendir($inDirectory)) !== false ) {

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
                    if($codigo=='88')
                        $dBDGTransaccion->verificarTransaccion($numeroOrden);
                    $dBDGTransaccion->actualizaMotivo_devolucion($codigo, $numeroOrden);
                }
            }
            fclose($fileMng);

            rename("$inDirectory/$archivo", "$destDirectory/$anio/$mes/$dia/$archivo");
        }

    }

    closedir($gestor);
}
?>
