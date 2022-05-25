<?php
    define("SCRIPT",1);

    //local_host
        //require_once( "C:/Program Files/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    // TSJDF
        require_once( "/var/www/php-inc/globals.php");

    require_once "$inc_dir/db/DBReportesConciliacion.php";

    date_default_timezone_set('America/Mexico_City');
    echo "Migracion de seguimientos  " . date("Y-m-d H:i\n");

    if($argc!=2){
        echo "Debe indicar el archivo de destino";
        exit();
    }

    $fDestino = fopen($argv[1], "w");
    if($fDestino===false){
        echo "No se logro abrir el archivo " . $argv[1] . "\n";
        exit();
    }

    fwrite($fDestino, "Finanzas\tUsuarios Registrados\n");
    fwrite($fDestino, "Usuario\tNombre\tFecha de nacimiento\tDirección\tTeléfono local\tTeléfono movil\tCorreo electrónico\tDespacho\tCédula\tEjecutivo\tFecha de registro\tExpedientes totales contratados\tExpedientes incluidos contratados\tExpedientes adicionales contratados\tExpedientes aprobados solicitados\tExpedientes en revisión solicitados\tFecha de autorización del primer expediente\tExpedientes renovados solicitados\tExpedientes revocados solicitados\tExpedientes Rechazados solicitados\n");

    $dbReportesConciliacion = new DBReportesConciliacion();
    if(!$dbReportesConciliacion->generarTablaUsuariosRegistrados()){
        exit();
    }
    $data = $dbReportesConciliacion->obtenUsuariosRegistrados();



    foreach ( $data as $row ){
        $sumas = $dbReportesConciliacion->obtenSeguimientosPorUsuario($row['id_usuario']);
        fwrite($fDestino, $row['usuario'] . "\t" . $row['nombre'] . "\t" . $row['nacimiento'] .
                "\t" . $row['direccion'] . "\t" . $row['telefono'] . "\t" . $row['movil'] .
                "\t" . $row['correo'] . "\t" . $row['despacho'] . "\t" . $row['cedula'] .
                "\t" . $row['ejecutivo'] . "\t" . $row['fecha_registro'] . "\t" . $row['expedientes_totales'] .
                "\t" . $row['expedientes_incluidos'] . "\t" . $row['expedientes_adicionales'] .
                "\t" . $sumas['solicitados'] . "\t" . $sumas['revision'] .
                "\t" . $sumas['fecha_primero'] . "\t" . $sumas['renovados'] .
                "\t" . $sumas['revocados'] . "\t" . $sumas['rechazados'] . "\n");
        $dbReportesConciliacion->insertRegistroUsuario(
                $row['usuario'], $row['nombre'], $row['nacimiento'],
                $row['direccion'], $row['telefono'], $row['movil'],
                $row['correo'], $row['despacho'], $row['cedula'],
                $row['ejecutivo'], $row['fecha_registro'], $row['expedientes_totales'],
                $row['expedientes_incluidos'], $row['expedientes_adicionales'],
                $sumas['solicitados'], $sumas['revision'],
                $sumas['fecha_primero'], $sumas['renovados'],
                $sumas['revocados'], $sumas['rechazados']);
    }

    fclose($fDestino);

?>
