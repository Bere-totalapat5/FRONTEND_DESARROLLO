<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("phpmailer1/class.phpmailer.php");


$mail = new PHPMailer;

try {
    //Server settings
    $mail->SMTPDebug = 1;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'email-smtp.us-east-1.amazonaws.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'AKIAJ3AIIBUPLQ273UTQ';                     // SMTP username
    $mail->Password   = 'BCU8JSSnDsVFeMckahjssLchBc2pVHIlkln/4rpDZjbV';                               // SMTP password
    $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('jfpo.01@tsjcdmx.gob.mx', 'TSJCDMX 01');
    $mail->addAddress('iarellano@totalpat.com', 'Israel');     // Add a recipient
    $mail->addAddress('salvador.rios@tsjcdmx.gob.mx');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



?>