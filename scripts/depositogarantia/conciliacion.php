<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);
    $fecha = date("Y/m/d");
    //local_host
        //require_once( "C:/Archivos de programa/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');
    //REDIT
        require_once( "/var/www/php-inc/globals.php");

    $buzon = "buzon.santander.com.mx";
    $usuario = "e1206688";
    $password ="K9r%tfgc";
    $NO_TRANS = "SIN MOVIMIENTOS";
    echo date("Conciliación de depoósitos en garantía Y-m-d G:i\n");

    require_once( "$inc_dir/db_globals.php");
    require_once "$inc_dir/db/DBSaldoUsuario.php";
    require_once "$inc_dir/db/DBMensaje.php";
    require_once "$inc_dir/correos/CorreoConciliacionRef.php";

    $patron_cuenta_1 = '/^80121206688\d{14}.zip$/';
    $patron_cuenta_2 = '/^80121206688\d{12}198.txt$/';
    $patron_cuenta_3 = '/^80121206688\d{12}199.txt$/';
    $con = ftp_connect($buzon);
    $login = ftp_login($con, $usuario, $password);

        // check connection
    if ((!$con) || (!$login)) {
        echo "\tFallo de conexión\n";
        echo "\tIntentando conectarse a $buzon con usuario $usuario\n";
        exit;
    } else {
        echo "\tConectado a $buzon, con usuario $usuario\n";
    }

    // Si no existe el direcctorio del dia lo creamos
    $localDir =  "$files_dir/buzon/$fecha";
    if( !is_dir($localDir) )
        mkdir ($localDir, 0750, true);

    //para cada archivo en el buzon
    $files = ftp_nlist($con, ".");
    $count=0;

    $dbSaldoUsuario = new DBSaldoUsuario();
    $correo = new CorreoConciliacionRef();
    $dbMensaje = new DBMensaje();

    foreach ($files as $file){

        if(++$count>=5)
            break;
        
        echo " \tAnalizando $file\n";
        $localFile = "$localDir/$file";

        if(! ftp_get($con, $localFile, $file, FTP_BINARY)){
            echo "\t\tError al descargar $file\n";
            continue;
        }

        ftp_delete($con, $file);

        $zipFile = new ZipArchive();
        $internalFile = substr($file, 0, -4) . ".txt";
        $zipFile->open($localFile);
        $ucFile = $zipFile->getStream($internalFile);

        $line =$line=fgets($ucFile);
        if(  $line=== false ){
             echo "\t\tArchivo vacio\n";
             continue;
        }

        if( strpos($line, $NO_TRANS )!==false  ){
                echo "\t\tSin transacciones.\n";
                continue;
        }


        do{
            $ref = trim(substr($line, 4,40));
            $idSaldo = substr($ref, 11, 13);
            if( ($info = $dbSaldoUsuario->getInformacionVenta($idSaldo)) !== false ){
                $total = (string)(int) substr($line, 44, 14);
                $fecha = substr($line, 83, 4) . '-' . substr($line, 87, 2) . '-' . substr($line, 89, 2);
                $folio = substr($line, 74, 9);

                if( $dbSaldoUsuario->activarSaldo($idSaldo) ){

                    $objMensaje = new ObjMensaje();
                    $objMensaje->setCorreo($info['correo']);
                    $objMensaje->setAsunto($correo->getAsunto());
                    $objMensaje->setCuerpo_html(
                            $correo->getHTML(
                                    $ref,
                                    $info['nombre'],
                                    $info['paquete'],
                                    $info['seguimientos'],
                                    $info['inicio'], $info['vencimiento'],
                                    $total,
                                    $fecha,
                                    $folio)
                            );
                    $objMensaje->setCuerpo_text(
                            $correo->getTEXT(
                                    $ref,
                                    $info['nombre'],
                                    $info['paquete'],
                                    $info['seguimientos'],
                                    $info['inicio'], $info['vencimiento'],
                                    $total,
                                    $fecha,
                                    $folio)
                            );
                    $objMensaje->setPrioridad(1);
                    $dbMensaje->insertMensaje($objMensaje);
                }
            }else{
                echo "\t\tEl pago con refgerencia: $ref no tiene un registro correspondiente en SICOR\n";
            }
            

        }while( $line = fgets($ucFile));
        

    }

    
?>