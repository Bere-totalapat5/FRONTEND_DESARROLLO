<?php
define("SCRIPT",1);

//if($_GET['psw']!='mnrywoieurwerw6fhf')
        //exit();
require_once '../../php-inc/globals.php';
echo ("1");
require_once "$inc_dir/db/DBUsuario.php";
require_once "$inc_dir/db/DBMensaje.php";
echo ("2");
require_once "$inc_dir/correos/CorreoMasivo.php";
echo ("3");

$dbUsuario = new DBUsuario();
$registros = $dbUsuario->getCorreoMasivo();
echo ("5");

require_once("$inc_dir/phpmailer/class.phpmailer.php");

//local_host
    $imap_server = 'email-smtp.us-east-1.amazonaws.com';
    $imap_port = '465';
    $imap_options = '/ssl';
    $smtp_server = 'email-smtp.us-east-1.amazonaws.com';
    $smtp_port = '465';
    $smtp_secure = 'ssl';
    $from = "sicor@tsjdf.gob.mx";
    $acount = "AKIAJCIMGKYVUBUR737A";
    $password = 'AjaxaoOQMscaKGIQI5vgHzs6GvjMevXmLt0LsNtjx72h';

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
    $mail->CharSet    = 'UTF-8';
    $mail->IsHTML(true);

echo ("5.1");

$correo = new CorreoMasivo();
echo ("5.2");
$dbMensaje = new DBMensaje();
echo ("6\n");


foreach ($registros as $registro){
echo $registro['correo'] . "\n";

    $mail->ClearReplyTos();
    $mail->ClearAttachments();
    $mail->AddReplyTo($from,"SICOR");


    $mail->ClearAddresses();
    $mail->IsHTML(true); // send as HTML
    $mail->Subject    = $correo->getAsunto();
    $mail->AltBody    = $correo->getTEXT();
    $mail->MsgHTML( $correo->getHTML());
    try{
        $mail->AddAddress($registro['correo']);
    }catch(Exception $e){
        Logger::debug( $e->getMessage() ) ;
        $mail->ClearAddresses();
        exit();
    }
    try{
        $mail->Send();

    }catch (Exception $e){
        Logger::debug( $e->getMessage() ) ;

    }
}
?>
