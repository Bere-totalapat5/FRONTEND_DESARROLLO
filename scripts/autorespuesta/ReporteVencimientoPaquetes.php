<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);

    //local_host
        //require_once( "C:/Archivos de programa/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    //AMAZON
        //require_once( "/var/php-inc/globals.php");
    // TSJDF
        //require_once( "/home/web/php-inc/globals.php");
    //REDIT
        require_once( "/var/www/php-inc/globals.php");

    if( $argc != 2 ) {
        echo "Falta el número de días";
        exit();
    }

    date_default_timezone_set('America/Mexico_City');
    $dias = intval($argv[1]);
    echo "Vencimiento de paquetes  $dias Días " . date("Y-m-d H:i\n");

    require_once( "$inc_dir/db_globals.php");
    require_once( "$inc_dir/mail_globals.php");
    require_once("$inc_dir/phpmailer/class.phpmailer.php");
    require_once "$inc_dir/db/DBSaldoUsuario.php";
    require_once "$inc_dir/correos/CorreoVencimiento.php";
    require_once "$inc_dir/utils/TimeUtils.php";

    $correo = new CorreoVencimiento();

    //Configuracion del Mailer
    $mail             = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = $smtp_secure;          // sets the prefix to the servier
    $mail->Host       = $smtp_server;          // sets GMAIL as the SMTP server
    $mail->Port       = $smtp_port;            // set the SMTP port
    $mail->Username   = $acount;               // GMAIL username
    $mail->Password   = $password;             // GMAIL password
    $mail->From       = $acount;
    $mail->FromName   = "SICOR";
    $mail->Subject    = utf8_decode($correo->getAsunto()) ;
    $mail->WordWrap   = 50;

    $dbSaldoUsuario = new DBSaldoUsuario();

    $fecha = $dbSaldoUsuario->ayer();

    $usuarios = $dbSaldoUsuario->obtenPaquetesPorVencer($dias);
    $cont=0;
    $errorCont=0;
    $listaCorreos ='';
    $listaFallidos='';
    foreach ($usuarios as $usuario){

        if($usuario['id_paquete']=='30')
            $leyenda="Le pedimos que adquiera un nuevo paquete a la brevedad.";
        else
            $leyenda="<p>Lo invitamos a renovar su paquete. Entrando  a la pestaña de compras " .
                     "en donde deberá seleccionar el botón \"Renovar paquete\" y seleccionar " .
                     "el paquete que desee renovar.</p><p> " .
                     "Es   importante   mencionarle  que  en  caso  de   seleccionar  el  botón " .
                     "\"Comprar paquete\"  estará  adquiriendo  un nuevo  paquete en donde no " .
                     "tendrá activos los seguimientos que ya tenga autorizados.</p>";
        if($dias==0)
            $tiempo = " el día de hoy " . TimeUtils::fechaLargaAMD($usuario['max_ven']) . "";
        else if($dias==1)
            $tiempo = " el día de mañana " . TimeUtils::fechaLargaAMD($usuario['max_ven']) . "";
        else
            $tiempo = " en $dias días, el " . TimeUtils::fechaLargaAMD($usuario['max_ven']) . "";
        $mail->AltBody =
                utf8_decode(
                        $correo->getTEXT( $usuario['nombres'] . ' ' . $usuario['paterno'] . ' ' . $usuario['materno'],
                                          $usuario['paquete'], $usuario['seguimiento'], $tiempo, $leyenda)
                        );

        $mail->MsgHTML(
                utf8_decode(
                        $correo->getHTML( $usuario['nombres'] . ' ' . $usuario['paterno'] . ' ' . $usuario['materno'],
                                          $usuario['paquete'], $usuario['seguimiento'], $tiempo, $leyenda)
                        )
        );

        //echo "\t" . $usuario['correo'] . ": \n";
        try{
            $mail->AddAddress($usuario['correo']);
        }catch(Exception $e){
            echo "\t" . $e->getMessage() . "(1)\n" ;
            $mail->ClearAddresses();
            continue;
        }

        $mail->IsHTML(true); // send as HTML

        $fromCount = 0;
        do{
            try{
                $mail->Send();
                $fromError=false;
                $listaCorreos .= "'" . $usuario['correo'] . "',";
                ++$cont;
                //echo "\t\tenviado\n";
            }catch (Exception $e){
                //echo "\t\t" . $e->getMessage() . "\n" ;
                sleep(30);
                $fromError = true;
                ++$fromCount;
            }
        }while ($fromError && $fromCount<10);
        if($fromCount==10){
            //echo "\tCorreo no enviado a " . $usuario['correo'] . " \n";
            $listaFallidos .= "'" . $usuario['correo'] . "',";
            ++$errorCont;
        }
        $mail->ClearAddresses();

    }


    echo "\t$cont correos enviados\n";
    echo "$listaCorreos\n";
    echo "\t$errorCont correos fallidos\n";
    echo "$listaFallidos\n";

?>