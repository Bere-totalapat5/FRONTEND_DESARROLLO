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
        //require_once( "/var/www/php-inc/globals.php");
    //ubzbz.com
       //require_once( '/home/u113152/domains/ubzbz.com/php-inc/globals.php');



    $outPath = $files_dir . "/SMS/";
    $filePath = date("Y/m/");
    $fileName= "envio_" . date("dmY") . ".csv";
    $sendTime= date("d/m/Y/H/i",time()+300);
    echo "Hora de envio: " . $sendTime;

    if(!is_dir($outPath.$filePath))
            mkdir($outPath.$filePath , 0750, true);
    $outFile = fopen($outPath . $filePath . $fileName, "w");
    if($outFile===false){
        echo "No de puede generar el archivo " . $outPath . $filePath . $fileName;
        exit();
    }

    $ADMIN_PHONE= array("5591988906","5518390081","5527245813");

    require_once( "$inc_dir/db_globals.php");
    require_once "$inc_dir/db/DBSaldoUsuario.php";
    require_once "$inc_dir/db/DBAcuerdo.php";
    require_once "$inc_dir/db/DBArchivoCalixta.php";
    require_once "$inc_dir/calixta/CalixtaAPI.php";


    $dbSaldoUsuario = new DBSaldoUsuario();
    $dbAcuerdo = new DBAcuerdo();
    $dbArchivoCalixta = new DBArchivoCalixta();
    $objArchivoCalixta = new ObjArchivoCalixta();
    $objArchivoCalixta->fecha=date('Y-m-d');
    $objArchivoCalixta->archivo_envio=$filePath.$fileName;


    $usuarios = $dbSaldoUsuario->obtenUsuariosSMSDiario();

    //Aviso de inicio
    foreach ($ADMIN_PHONE as $phone){
        $query = $phone . ",\"Inicia envio de mensajes SMS SICOR\"";
        fwrite($outFile, $query ."\n");
    }

    $enviados=0;
    foreach ($usuarios as $usuario){

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
                    $new = "\\n" . $ultimoFolio . " " . $acuerdo['cuenta'] . "R";
                    if( (strlen($expedientes)+strlen($new))+36 > 160 ){
                        $expedientes .= "\\n Y otros";
                        break;
                    }
                    else
                        $expedientes .= $new;
                }
            }

        }

        if(strlen($expedientes)>0){

            $expedientes = "SICOR\\nActualizaciones en:" . $expedientes;

            $expedientes .= "\\n$web_path";
            $query = str_replace('-', '',$usuario['movil']) . ",\"" . $expedientes . "\"";
            fwrite($outFile, $query . "\n");
            ++$enviados;
        }
        //echo"\n*********************************\n";

    }

    //Aviso de fin
    foreach ($ADMIN_PHONE as $phone){
        $query = $phone . ",\"Termina envio de mensajes SMS SICOR ($enviados mensajes enviados)\"";
        fwrite($outFile, $query . "\n");
    }

    fclose($outFile);

    /*****ENVIA A CALIXTA ********************/

    $calixta = new CalixtaAPI();
    // Conjunto de parametros
    $prop = array (
        array("establishHourRange", "0")
    );
    $calixta->setPropiedades($prop);

    $ret=$calixta->enviaMensajeArchivoCSV(
            $outPath . $filePath . $fileName ,
            "SICOR\nActualizaciones en:EXPEDIENTES" ,
            $sendTime);

    if ($ret>0){
	echo 'Mensaje enviado con éxito. (',$ret,')';
        echo "Se enviaron $enviados mensajes.";
        $objArchivoCalixta->id_envio=$ret;
        $dbArchivoCalixta->agregaArchivo($objArchivoCalixta);
    }else{
	echo 'Ocurrió un error al enviar el mensaje (',$ret,')';
    }


?>