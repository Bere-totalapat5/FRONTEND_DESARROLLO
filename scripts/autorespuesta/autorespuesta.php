<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);
    echo date("Y-m-d G:i\n");
    //local_host
    /*
        require_once( "C:/Archivos de programa/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    */

    //ubzbz.com
    /*
        require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');
    */

    //amazon
    /*
        require_once( "/var/php-inc/globals.php");
    */

    //redit
        require_once( "/var/www/php-inc/globals.php");


    require_once( "$inc_dir/db_globals.php");
    require_once( "$inc_dir/mail_globals.php");
    require_once("$inc_dir/db/DBInformacionAcuerdo.php");
    require_once("MailReader.php");
    require_once("$inc_dir/phpmailer/class.phpmailer.php");

    //$mailer = new MailReader(,'c0r0n1t4',,'993');
    $mailer = new MailReader($acount,$password, $imap_server, $imap_port, $imap_options);
    if( !$mailer->connect() ){
        echo("\tError al conectar:\n");
        $errores = imap_errors();
        foreach ($errores as $error)
            echo("\t\t".$error."\n");
        exit();
    }

    $mailData = $mailer->getMailData();
    $mailer->close_mailbox();

    if( is_null($mailData) ){
        echo("\tError al leer correo\n");
        $errores = imap_errors();
        foreach ($errores as $error)
            echo("\t\t".$error."\n");
        exit();
    }

    if( count($mailData) == 0 ){
        echo("\tNo hay correos\n");
        exit();
    }

    //Respuestas de correo
    $respuestas = parse_ini_file("respuestas.ini",true);
    if(!$respuestas){
        echo("\tError al leer archivo de respuestas\n");
        exit();
    }

    //Base de datos
    $dbInformacionAcuerdo = new DBInformacionAcuerdo();

    //Configuracion del Mailer
        $mail             = new PHPMailer();

        $mail->IsSMTP();
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = $smtp_secure;                 // sets the prefix to the servier
        $mail->Host       = $smtp_server;      // sets GMAIL as the SMTP server
        $mail->Port       = $smtp_port;                   // set the SMTP port
        $mail->Username   = $acount;  // GMAIL username
        $mail->Password   = $password;            // GMAIL password
        $mail->From       = $acount;
        $mail->FromName   = "SICOR";
        $mail->Subject    = "JDF Solicitud de folio";
        $mail->WordWrap   = 50;

    foreach ($mailData as $register){

        $mail->ClearAddresses();
        $mail->ClearReplyTos();
        $mail->ClearAttachments();

        echo "\tenviando folio: *" . $register->getFolio()."* cedula: *" . $register->getCedula() . "*\n";
        if($register->getFolio()!=''){
            $informacionAcuerdo = $dbInformacionAcuerdo->getAcuerdosByFolioAbogado($register->getFolio(),$register->getCedula(),0, 0);

            if( is_null($informacionAcuerdo) || count($informacionAcuerdo)==0 ){
                $mail->AltBody    = str_replace('FOLIO', $register->getFolio(), $respuestas[TEXTO][error_folio]);
                $mail->MsgHTML( str_replace('FOLIO', $register->getFolio(), $respuestas[HTML][error_folio]) );

            }else{
                $mail->AltBody    = str_replace('FOLIO', $register->getFolio(), $respuestas[TEXTO][correcto]);
                $mail->MsgHTML( str_replace('FOLIO', $register->getFolio(), $respuestas[HTML][correcto]) );

                foreach ($informacionAcuerdo as $acuerdo ){
                    $path = $files_dir ."/originales/". $acuerdo->getId_acuerdo(). ".jpg";
                    $mail->AddAttachment($path);             // attachment
                }
            }
        }else{
            $mail->AltBody    = "Tu mensaje no tiene el formato adecuado.\nfolio:numero_de_folio cedula:cedula_profecional " . $register->getFolio();
            $mail->MsgHTML("Tu mensaje no tiene el formato adecuado.<br>folio:numero_de_folio cedula:cedula_profesional " . $register->getFolio());
        }

        $mail->AddReplyTo("sicor@tsjdf.gob.mx","SICOR");

        $mail->AddAddress($register->getEmail(),$register->getDe());

        $mail->IsHTML(true); // send as HTML

        if(!$mail->Send()) {
            echo "\tMailer Error: " . $mail->ErrorInfo."\n";
        } else {
            echo "\tMessage has been sent\n";
        }

    }


?>