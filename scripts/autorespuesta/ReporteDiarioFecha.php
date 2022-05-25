<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);

    //local_host
        //require_once( "C:\Program Files\Apache Software Foundation\Apache2.2\SIBJDF/php-inc/globals.php");
    //AMAZON
        //require_once( "/var/www/php-inc/globals.php");
    // TSJDF
        require_once( "/var/www/php-inc/globals.php");
    //REDIT
        //require_once( "/var/www/php-inc/globals.php");
    date_default_timezone_set('America/Mexico_City');

    require_once( "$inc_dir/db_globals.php");
    require_once( "$inc_dir/mail_globals.php");
    require_once("$inc_dir/phpmailer/class.phpmailer.php");
    require_once "$inc_dir/db/DBSaldoUsuario.php";
    require_once "$scripts_dir/autorespuesta/CorreoDiario.php";
    require_once "$inc_dir/db/DBAcuerdo.php";
    require_once "$inc_dir/db/DBFileLinks.php";
    require_once "$inc_dir/utils/TimeUtils.php";

    $correo = new CorreoDiario();

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
    $mail->Subject    = $correo->getAsunto();
    $mail->WordWrap   = 50;

    $dbSaldoUsuario = new DBSaldoUsuario();
    $dbAcuerdo =      new DBAcuerdo();
    $dbFileLinks =    new DBFileLinks();

    if( $argc != 2)
        echo "Requiere fecha 'yyyy-mm-dd'\n";

    $fechaMysql = $argv[1];
    $fecha = TimeUtils::fechaLargaAMD($fechaMysql);
    echo "Notificación de seguimientos $fechaMysql\n";

    $usuarios = $dbSaldoUsuario->obtenUsuariosCorreoDiario($fechaMysql);
    $cont=0;
    $errorCont=0;
    $listaCorreos ='';
    $listaFallidos='';
    foreach ($usuarios as $usuario){

        $links = $usuario['descarga_mail']=='S';

        $acuerdos = $dbAcuerdo->getAcuerdosRecientesCorreo($usuario['id_usuario'], $usuario['cedula'], $fechaMysql);

        $ultimoFolio='';
        $expedientes = '';
        foreach ($acuerdos as $acuerdo ){
            $nombre = $acuerdo['juicio'];
            if($acuerdo['bis']!='')
                $nombre .= ' ' . $acuerdo['bis'] . 'Bis.';
            if($acuerdo['tipo_expediente']!='expediente'&&$acuerdo['tipo_expediente']!='toca')
                $nombre .= ' (' . $acuerdo['tipo_expediente'] . ')';
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
                if($acuerdo['descarga']=='S'){
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

        if($expedientes=='')
            $expedientes = "<div>No hay movimientos en tus expedientes.</div>";
        $mail->AltBody    =
                $correo->getTEXT(
                $usuario['usuario'],
                $usuario['nombres'] . " " .$usuario['paterno'] . " " .$usuario['materno'],
                $fecha, $expedientes);
        $mail->MsgHTML(
                $correo->getHTML(
                $usuario['usuario'],
                $usuario['nombres'] . " " .$usuario['paterno'] . " " .$usuario['materno'],
                $fecha, $expedientes));

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

    require_once "$inc_dir/db/DBReporteCorreoDiario.php";
    $dbReporte= new DBReporteCorreoDiario();
    $reporte = new ObjReporteCorreoDiario();
    $reporte->setFecha(date("Y-m-d"));
    $reporte->setEnviados($cont);
    $reporte->setFallidos($errorCont);
    $dbReporte->insertaReporte($reporte);

    echo "\t$cont correos enviados\n";
    echo "$listaCorreos\n";
    echo "\t$errorCont correos fallidos\n";
    echo "$listaFallidos\n";

   require_once "$inc_dir/db/DBReporteCorreoDiario.php";
    $dbReporte= new DBReporteCorreoDiario();
    $reporte = new ObjReporteCorreoDiario();
    $reporte->setFecha(date("Y-m-d"));
    $reporte->setEnviados($cont);
    $reporte->setFallidos($errorCont);
    $dbReporte->insertaReporte($reporte);
?>