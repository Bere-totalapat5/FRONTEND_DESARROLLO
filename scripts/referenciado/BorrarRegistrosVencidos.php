<?php

    define("SCRIPT",1);
    
    //local_host
        //require_once( "C:/Archivos de programa/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');
    //REDIT
        require_once( "/var/www/php-inc/globals.php");
        
    require_once "$inc_dir/utils/db/DBSaldoUsuario.php";
    
    $dbSaldoUsuario = new DBSaldoUsuario();
    
    $dbSaldoUsuario->borrarRegistrosVencidos();

?>
