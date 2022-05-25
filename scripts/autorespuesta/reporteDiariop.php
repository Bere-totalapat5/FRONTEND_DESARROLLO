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

    echo date("Notificación de seguimientos Y-m-d G:i\n");

    require_once( "$inc_dir/db_globals.php");
    require_once( "$inc_dir/mail_globals.php");
    require_once("$inc_dir/phpmailer/class.phpmailer.php");
    require_once "$inc_dir/db/DBSaldoUsuario.php";
    require_once "$scripts_dir/autorespuesta/CorreoDiario.php";
    require_once "$inc_dir/db/DBAcuerdo.php";
    require_once "$inc_dir/db/DBFileLinks.php";

    $correo = new CorreoDiario();

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
    $mail->Subject    = utf8_decode($correo->getAsunto()) ;
    $mail->WordWrap   = 50;

    $dbSaldoUsuario = new DBSaldoUsuario();
    $dbAcuerdo = new DBAcuerdo();
    $dbFileLinks = new DBFileLinks();

    $fecha = $dbSaldoUsuario->ayer();

    $usuarios = $dbSaldoUsuario->obtenUsuariosCorreoDiario();

    foreach ($usuarios as $usuario){
        $links = $usuario['descarga_mail']=='S';

        $acuerdos = $dbAcuerdo->getAcuerdosRecientesCorreo($usuario['id_usuario'], $usuario['cedula']);

        $ultimoFolio='';
        $expedientes = '';
        foreach ($acuerdos as $acuerdo ){
            $nombre = $acuerdo['juicio'];
            if($acuerdo['bis']!='')
                $nombre .= ' ' . $acuerdo['bis'] . 'Bis.';
            if($acuerdo['tipo_expediente']!='expediente'&&$acuerdo['tipo_expediente']!='toca')
                $nombre .= '(' . $acuerdo['tipo_expediente'] . ')';
            if( $nombre!= $ultimoFolio ){
                $ultimoFolio = $nombre;
                $expedientes .= '<div class="expediente">Expediente ' . $ultimoFolio . '</div>';
            }

            $expedientes .= '<div class="acuerdo">';

            if( $acuerdo['acuerdo']==''  ){
                $expedientes .= "No hay actualizaciones en este juicio.";
            }
            else{
                $expedientes .= $acuerdo['fecha'] . ' ';
                if($links){
                    $idLink = $dbFileLinks->insertarLink($acuerdo['ruta'], $acuerdo['id_acuerdo'], $acuerdo['extension']=='.mht'?'.html':$acuerdo['extension']);
                    $expedientes .= "<a href='$web_path/acuerdos/ObtenerAcuerdoL.php?id_link=$idLink'>";
                    $expedientes .= $acuerdo['acuerdo'];
                    $expedientes .= "</a>";
                }else{
                    $expedientes .= $acuerdo['acuerdo'];
                }
            }

            $expedientes .= "</div>";

        }


        $mail->ClearAddresses();
        $mail->ClearReplyTos();
        $mail->ClearAttachments();

        $mail->AltBody    = utf8_decode($correo->getTEXT($usuario['usuario'], $fecha, $expedientes));
        $mail->MsgHTML( utf8_decode($correo->getHTML($usuario['usuario'], $fecha, $expedientes)) );

        $mail->AddReplyTo($acount,"SICOR");

        $mail->AddAddress($usuario['correo']);

        $mail->IsHTML(true); // send as HTML

        $mail->Send();

    }


?>