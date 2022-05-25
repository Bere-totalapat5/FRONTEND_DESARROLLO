<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);

    date_default_timezone_set('America/Mexico_City');
    echo "Prueba de correo " . date("Y-m-d H:i\n");

    require_once( "$inc_dir/mail_globals.php");
    require_once("$inc_dir/phpmailer/class.phpmailer.php");


    //Configuracion del Mailer
    $mail             = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = $smtp_secure;          // sets the prefix to the servier
    $mail->Host       = $smtp_server;          // sets GMAIL as the SMTP server
    $mail->Port       = $smtp_port;            // set the SMTP port
    $mail->Username   = $acount;               // GMAIL username
    $mail->Password   = $password;             // GMAIL password
    $mail->From       = $from;
    $mail->FromName   = "SICOR";
    $mail->Subject    = "Prueba envio";
    $mail->WordWrap   = 50;


    $fecha = date("Y-m-d");

    $usuarios = array("javier.pineda.rodriguez@gmail.com");
    foreach ($usuarios as $usuario){
        $mail->AltBody    = "Prueba de envio de correo";

        $mail->MsgHTML("<H1>Prueva de envio de correo</H1>");

        try{
            $mail->AddAddress($usuario);
        }catch(Exception $e){
            echo "\t" . $e->getMessage() . "(1)\n" ;
            $mail->ClearAddresses();
            continue;
        }

        $mail->IsHTML(true); // send as HTML

        try{
            $mail->Send();
            $fromError=false;
            echo "\t\tenviado\n";
        }catch (Exception $e){
            echo "\t\t" . $e->getMessage() . "\n" ;
        }
        $mail->ClearAddresses();

    }

?>