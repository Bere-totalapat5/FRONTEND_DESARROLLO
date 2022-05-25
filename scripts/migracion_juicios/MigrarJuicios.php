<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    define("SCRIPT",1);

    //local_host
        require_once( "C:/Program Files/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    // TSJDF
        //require_once( "/var/www/php-inc/globals.php");

    require_once "$inc_dir/db/DBMigracion.php";
    date_default_timezone_set('America/Mexico_City');
    echo "Migracion de juicios  " . date("Y-m-d H:i\n");
    $t = date('YmdHi');
    echo "$t\n";
    echo "_$t\n";
    if( $argc != 2 ) {
        echo "\tEs necesario el archivo de migracion\n";
        exit();
    }


    $baseDir = "$files_dir/migracion_juicios";
    $archivoMigracion = $argv[1];

    if( !file_exists("$baseDir/$archivoMigracion.txt") ){
        echo "\tEl archivo $baseDir/$archivoMigracion.txt no existe\n";
        exit();
    }
    echo "\tMigrando archivo: $baseDir/$archivoMigracion.txt\n";


    $dbMigracion = new DBMigracion();
    $pArchivo = fopen("$baseDir/$archivoMigracion.txt","r");
    $pSalida = fopen("$baseDir/$archivoMigracion$t.txt","w");

    while ( ($linea=fgets($pArchivo))!==false ){

        $info = explode("\t", $linea);

        if( count($info) != 6 ){
            fputs($pSalida, "$juicioV\t$juicioN\tERROR_LINEA\n");
            continue;
        }
        $info[5] = str_replace("\n", "", $info[5]);
        $info[5] = str_replace("\r", "", $info[5]);

        $juicioV = $info[0] . "PIC " . $info[1] . "/" . $info[2];
        $juicioN = $info[3] . "PIC " . $info[4] . "/" . $info[5];

        $juiciosOriginales = $dbMigracion->obtenCuentaJuicio($info[0].'PIC', $info[1], $info[2]);
        if($juiciosOriginales==0){
            fputs($pSalida, "$juicioV\t$juicioN\tERROR_NO_JUICIO\n");
            continue;
        }

        $juiciosNuevos = $dbMigracion->obtenCuentaJuicio($info[3].'PIC', $info[4], $info[5]);
        if($juiciosNuevos>0){
            fputs($pSalida, "$juicioV\t$juicioN\tERROR_JUICIO_REPETIDO");
            $juicios = $dbMigracion->obtenJuicio($info[3].'PIC', $info[4], $info[5]);
            foreach ($juicios as $juicio){
                fputs($pSalida, "\t" . $juicio['id_juicio'] . "\t" . $juicio['juzgado'] . "\t" . $juicio['expediente'] . "\t" . $juicio['anio'] . "\t" . $juicio['bis'] . "\t" . $juicio['tipo_expediente'] );
            }
            fputs($pSalida,"\n");
            /*
            fputs($pSalida, "\tInvolucrados origen\n");
            $invlolucrados = $dbMigracion->obtenerInvolucrados($info[0].'PIC', $info[1], $info[2]);
            foreach ($invlolucrados as $invlolucrado){
                fputs($pSalida, "\t\t" . $invlolucrado['actor'] . "\t" . $invlolucrado['demandado'] . "\t" . $invlolucrado['terceria'] . "\n" );
            }
            fputs($pSalida, "\tInvolucrados destino\n");
            $invlolucrados = $dbMigracion->obtenerInvolucrados($info[3].'PIC', $info[4], $info[5]);
            foreach ($invlolucrados as $invlolucrado){
                fputs($pSalida, "\t\t" . $invlolucrado['actor'] . "\t" . $invlolucrado['demandado'] . "\t" . $invlolucrado['terceria'] . "\n" );
            }
             */
            continue;
        }

        $afectados = $dbMigracion->actualizaJuicio($info[0].'PIC', $info[1], $info[2],
                                                   $info[3].'PIC', $info[4], $info[5]);

        if($afectados<0){
            if($afectados==DBMigracion::$ERROR_ACTUALIZACION)
                fputs($pSalida, "$juicioV\t$juicioN\tERROR_DB_JUICIO\n");
            else if($afectados==DBMigracion::$ERROR_INSERCCION)
                fputs($pSalida, "$juicioV\t$juicioN\tERROR_DB_MIGRACION_JUICIO\n");
            else if($afectados==DBMigracion::$ERROR_RENGLONES)
                fputs($pSalida, "$juicioV\t$juicioN\tERROR_DB_DIF\n");
        }
        else{
            fputs($pSalida, "$juicioV\t$juicioN\tOK\n");
        }


    }

    fclose($pArchivo);
    fclose($pSalida);

?>
