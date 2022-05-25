<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    define("SCRIPT",1);

    //local_host
        require_once( "C:/Program Files/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    // TSJDF
        //require_once( "/var/www/php-inc/globals.php");

    require_once "$inc_dir/db/DBSaldoUsuario.php";

    date_default_timezone_set('America/Mexico_City');
    echo "Migracion de seguimientos  " . date("Y-m-d H:i\n");

    $dbSaldoUsuario = new DBSaldoUsuario();

    $cuentas = $dbSaldoUsuario->obtenCuentasAMigrar();

    if($cuentas === false)
        exit();

    foreach($cuentas as $cuenta){

        $dbSaldoUsuario->migrarCuenta($cuenta['id_saldo_usuario_origen'], $cuenta['id_saldo_usuario_destino']);
        
    }


?>