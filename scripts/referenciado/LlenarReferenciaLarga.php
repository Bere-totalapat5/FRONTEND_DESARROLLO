<?php
    define("SCRIPT",1);
    date_default_timezone_set("America/Mexico_City");
    $fecha = date("Y/m/d");

    //local_host
        //require_once( "C:/Program Files/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');
    //REDIT
        require_once( "/var/www/php-inc/globals.php");
        
     require_once "$inc_dir/db/DBSaldoUsuario.php";
     require_once "$inc_dir/referenciado/Codigos.php";
     require_once "$inc_dir/referenciado/ReferenciaSantander.php";

     $dbSaldoUsuario = new DBSaldoUsuario();
     $saldos = $dbSaldoUsuario->getSaldosReferencioados();

     foreach ($saldos as $saldo){

         echo $saldo['id_paquete'] . " " . $saldo['nombre_paquete'] . "\n";
        $total = number_format(floatval($saldo['total']),2);
        $vigencia = 10;
        $area = '11';
        $producto = $PROD_PAQUETE[intval($saldo['id_paquete'])];
        $unidades = $saldo['periodos'];

        $referencia = ReferenciaSantander::generaReferencia($total, $vigencia, $area, $producto, $unidades, $saldo['id_saldo_usuario']);
        echo "\t" . $saldo['id_saldo_usuario'] . " -> " . $referencia . "\n";
        $dbSaldoUsuario->actualizarRef_larga($saldo['id_saldo_usuario'], $referencia);
        
     }


?>
