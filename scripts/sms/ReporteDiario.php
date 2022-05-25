<?php
/*
 * cronjob
 * /usr/local/bin/php /home/u113152/domains/ubzbz.com/scripts/autorespuesta/autorespuesta.php >> /home/u113152/domains/ubzbz.com/cron_result
 */
    define("SCRIPT",1);
    date_default_timezone_set('America/Mexico_City');
    echo "Reporte de seguimientos SMS " . date("Y-m-d G:i\n");
    //local_host
        require_once( "C:\Program Files\Apache Software Foundation\Apache2.2\SIBJDF/php-inc/globals.php");
    //amazon
        //require_once( "/var/php-inc/globals.php");
    // TSJDF
        //require_once( "/home/web/php-inc/globals.php");
    //REDIT
        require_once( "/var/www/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');
        

    $ADMIN_PHONE= array("5591988906","5518390081","5527245813");

    require_once( "$inc_dir/db_globals.php");
    require_once "$inc_dir/db/DBSaldoUsuario.php";
    require_once "$inc_dir/db/DBAcuerdo.php";
    require_once "$inc_dir/db/DBEnvioSms.php";


    $dbSaldoUsuario = new DBSaldoUsuario();
    $dbAcuerdo = new DBAcuerdo();
    $dbEnvioSms = new DBEnvioSms();

    $fecha = $dbSaldoUsuario->ayer();
    echo "\n$fecha Reporte diario\n ";

    $usuarios = $dbSaldoUsuario->obtenUsuariosSMSDiario();

    $url ="http://caballeroantonio.dyndns-ip.com:8800/Send%20Text%20Message.htm";
    //$url ="http://caballeroantonio.isa-geek.com:8800/Send%20Text%20Message.htm";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

    //Aviso de inicio
    foreach ($ADMIN_PHONE as $phone){
        $query = "PhoneNumber=" . $phone . "&Text=Inicia envio de mensajes SMS SICOR";
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $query);
        //curl_exec($ch);
    }

    $enviados=0;
    foreach ($usuarios as $usuario){

        $objEnvioSms = new ObjEnvioSms();
        $objEnvioSms->id_usuario=$usuario['id_usuario'];
        $objEnvioSms->telefono=str_replace('-', '',$usuario['movil']);

        $acuerdos = $dbAcuerdo->getAcuerdosRecientesSMS($usuario['id_usuario'], $usuario['cedula']);

        $ultimoFolio='';
        $expedientes='';
        foreach ($acuerdos as $acuerdo ){
            $nombre = $acuerdo['juicio'];
            if($acuerdo['bis']!='')
                $nombre .= ' ' . $acuerdo['bis'] . 'Bis.';
            if($acuerdo['tipo_expediente']!='expediente'&&$acuerdo['tipo_expediente']!='toca')
                $nombre.= ' (' . $acuerdo['tipo_expediente'] . ')';

            if( $nombre!= $ultimoFolio ){
                $ultimoFolio = $nombre;
                if($acuerdo['cuenta']>0){
                    $new = "\n" . $ultimoFolio . " " . $acuerdo['cuenta'] . "R";
                    if( (strlen($expedientes)+strlen($new))+36 > 160 ){
                        $expedientes .= "\n Y otros";
                        break;
                    }
                    else
                        $expedientes .= $new;
                }
            }
            
        }

        if(strlen($expedientes)>0){

            $expedientes = "SICOR\nActualizaciones en:" . $expedientes;

            $expedientes .= "\n$web_path";
            $query = "PhoneNumber=" . str_replace('-', '',$usuario['movil']) . "&Text=" . $expedientes;
            $objEnvioSms->mensaje = $expedientes;
            echo "$query\n";
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $query);

            //if(!curl_exec($ch))
                //$objEnvioSms->error="Error de conexion con proxi SMS";
            $dbEnvioSms->insertEnvioSms($objEnvioSms);
            ++$enviados;
        }
        //echo"\n*********************************\n";

    }

    //Aviso de fin
    foreach ($ADMIN_PHONE as $phone){
        $query = "PhoneNumber=" . $phone . "&Text=Termina envio de mensajes SMS SICOR ($enviados mensajes enviados)";
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $query);
        curl_exec($ch);
    }

    curl_close($ch);
    echo "Se enviaron $enviados mensajes.";
?>