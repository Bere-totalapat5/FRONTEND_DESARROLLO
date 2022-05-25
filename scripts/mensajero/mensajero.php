<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);
    //local_host
        //require_once( "C:/Archivos de programa/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    // TSJDF
        require_once( "/var/www/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');


    require_once( "$inc_dir/db_globals.php");
    require_once "$inc_dir/db/DBMensaje.php";
    require_once( "$inc_dir/mail_globals.php");
    require_once("$inc_dir/phpmailer/class.phpmailer.php");


    $dbMensaje = new DBMensaje();


    $mensajes = $dbMensaje->getNext(300);

    $mail             = new PHPMailer();

    $mail->IsSMTP();
    $mail->SMTPAuth   = true;           // enable SMTP authentication
    $mail->SMTPSecure = $smtp_secure;   // sets the prefix to the servier
    $mail->Host       = $smtp_server;   // sets GMAIL as the SMTP server
    $mail->Port       = $smtp_port;     // set the SMTP port
    $mail->Username   = $acount;        // GMAIL username
    $mail->Password   = $password;      // GMAIL password
    $mail->From       = $from;
    $mail->FromName   = "SICOR";
    $mail->WordWrap   = 100;

    $mail->ClearReplyTos();
    $mail->ClearAttachments();
    $mail->AddReplyTo($from,"SICOR");


    $lastId=0;
    foreach ($mensajes as $mensaje){

        $mail->ClearAddresses();
        $mail->IsHTML(true); // send as HTML
        $mail->Subject    = utf8_decode($mensaje->getAsunto());
        $mail->AltBody    = utf8_decode($mensaje->getCuerpo_text());
        $mail->MsgHTML( utf8_decode($mensaje->getCuerpo_html()));
        try{
            $mail->AddAddress($mensaje->getCorreo());
        }catch(Exception $e){
            echo "\t" . $e->getMessage() . "(1)\n" ;
            $mail->ClearAddresses();
            $dbMensaje->marcarEnvioInvalido($mensaje->getId_mensaje());
            continue;
        }
        try{
            $mail->Send();
        }catch (Exception $e){
            echo "\t" . $e->getMessage() . "(2)\n" ;
            $mail->ClearAddresses();
            continue;
        }

        $size = strlen($mail->Subject) + strlen($mail->AltBody) + strlen($mail->Body);
        $dbMensaje->marcarEnvio($mensaje->getId_mensaje(), $size);
    }
    
?>