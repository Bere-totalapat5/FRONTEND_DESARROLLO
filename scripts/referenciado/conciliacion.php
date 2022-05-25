<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);
    date_default_timezone_set("America/Mexico_City");
    $fecha = date("Y/m/d");
    $inicioCompra = date("Y-m-d");
    //local_host
        //require_once( "C:/Archivos de programa/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');
    //REDIT
        require_once( "/var/www/php-inc/globals.php");

    $buzon = "buzon.santander.com.mx";
    $usuario = "e5698185";
    $password ="M4dr6Gx2";
    $NO_TRANS = "SIN MOVIMIENTOS";
    echo "Conciliacion de pagos " . date("Y-m-d H:m"). "\n";

    require_once( "$inc_dir/db_globals.php");
    require_once "$inc_dir/referenciado/Codigos.php";
    require_once "$inc_dir/db/DBSaldoUsuario.php";
    require_once "$inc_dir/db/DBMensaje.php";
    require_once "$inc_dir/db/DBRecuperacionContrasena.php";
    require_once "$inc_dir/db/DBArchivoConciliado.php";
    require_once "$inc_dir/correos/CorreoConciliacionRef.php";
    require_once "$inc_dir/correos/CorreoRecuperacion.php";

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

    $dbRecuperacionContrasena = new DBRecuperacionContrasena();
    $dbSaldoUsuario = new DBSaldoUsuario();
    $dbArchivoConciliado = new DBArchivoConciliado();
    $correo = new CorreoConciliacionRef();
    $correoRecuperacion = new CorreoRecuperacion();
    $dbMensaje = new DBMensaje();

    foreach ($files as $file){

        if( !$dbArchivoConciliado->esConciliado($file)){

            $objArchivoConciliado = new ObjArchivoConciliado();
            $objArchivoConciliado->setId_archivo_conciliado($file);
            $dbArchivoConciliado->agregarArchivoConciliado($objArchivoConciliado);
            
            echo " \tAnalizando $file\n";
            $localFile = "$localDir/$file";

            if(! ftp_get($con, $localFile, $file, FTP_BINARY)){
                echo "\t\tError al descargar $file\n";
                continue;
            }

            //ftp_delete($con, $file);

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
                    $total = number_format(   floatval(substr($line, 44, 14)) / 100.0, 2 );
                    $fecha = substr($line, 83, 4) . '-' . substr($line, 87, 2) . '-' . substr($line, 89, 2);
                    $folio = substr($line, 74, 9);

                    if( $dbSaldoUsuario->verificaSaldo($idSaldo) ){

                        $objMensaje = new ObjMensaje();
                        $objMensaje->setCorreo($info['correo']);

                        if( $info['id_paquete'] == PROD_CAMBIO_CONTRASENA ){
                            //Generar registro de recuperacion
                            $dbSaldoUsuario->activarSaldo($idSaldo);
                            $id = $dbRecuperacionContrasena->generarRecuperacion($info['id_usuario']);
                            if($id===false )
                                echo "\t\tEl pago con referencia: $ref no logro generar una clave de recuperacion de contraseña\n";

                            $objMensaje->setAsunto($correoRecuperacion->getAsunto());

                            $mensaje->setCuerpo_html(
                                    $correoRecuperacion->getHTML(
                                        $info['usuario'],
                                        $info['nombre'],
                                        "$web_path/principal.php?id=$id"));
                            $mensaje->setCuerpo_text(
                                    $correoRecuperacion->getTEXT(
                                        $info['usuario'],
                                        $info['nombre'],
                                        "$web_path/principal.php?id=$id"));

                        }else{
                            if($info['padre']=='0'){
                                echo "\t\tPaquete padre " . $idSaldo;
                                $fechas = $dbSaldoUsuario->actualizaFechas($idSaldo, $inicioCompra);
                            }else{
                                echo "\t\tPaquete hijo " . $idSaldo;
                                $fechas['inicio'] = $info['inicio'];
                                $fechas['vencimiento'] = $info['vencimiento'];
                            }
                            $objMensaje->setAsunto($correo->getAsunto());
                            $objMensaje->setCuerpo_html(
                                    $correo->getHTML(
                                            $ref,
                                            $info['nombre'],
                                            $info['paquete'],
                                            $info['seguimientos'],
                                            $fechas['inicio'], $fechas['vencimiento'],
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
                        }
                        $objMensaje->setPrioridad(1);
                        $dbMensaje->insertMensaje($objMensaje);
                    }
                }else{
                    echo "\t\tEl pago con referencia: $ref no tiene un registro correspondiente en SICOR\n";
                }


            }while( $line = fgets($ucFile));
        }  else {
            
        }

    }
    
?>