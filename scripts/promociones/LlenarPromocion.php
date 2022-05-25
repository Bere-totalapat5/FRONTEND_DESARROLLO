<?php
    define("SCRIPT",1);
    date_default_timezone_set("America/Mexico_City");
    $fecha = date("Y/m/d H:i:s");

    echo $fecha . "\n";
    //local_host
       // require_once( "C:/Program Files/Apache Software Foundation/Apache2.2/SIBJDF/php-inc/globals.php");
    //SICOR
        require_once( "/var/www/php-inc/globals.php");
    require_once "$inc_dir/promociones_globals.php";
    require_once "$inc_dir/db/DBPromocion.php";
    $dbPromocion = new DBPromocion();

    $lastId = $dbPromocion->getUltimoId();
    //$lastId=0;

    try {
        echo "$PROMO_SERVICE\n";
        $cliente = new SoapClient(null, array('location' => $PROMO_SERVICE,'uri' => 'urn:webservices'));
        $sql = "select * from promociones where id>$lastId";
        $datos = $cliente -> obtenerMetadatos($sql);
    } catch (SoapFault $fault) {
        echo "Error de conexion " . $fault->faultcode . " - " .$fault->faultstring;
        exit();
    }

    foreach ($datos as $row){
        $objPromocion = new ObjPromocion();
        $objPromocion->id = $row['Id'];
        $objPromocion->hash = $row['Hash'];
        $objPromocion->juzgado = $row['Juzgado'];
        $objPromocion->codigo = $row['Codigo'];
        $objPromocion->fecha_hora = $row['Fecha_Hora'];
        $objPromocion->promovente = $row['Promovente'];
        $objPromocion->expediente = $row['Expediente'];
        $objPromocion->year = $row['Year'];
        $objPromocion->tipo_documento = $row['Tipo_Documento'];
        $objPromocion->bis = $row['Bis'];
        $objPromocion->actor = $row['Actor'];
        $objPromocion->demandado = $row['Demandado'];
        $objPromocion->observaciones = $row['Observaciones'];
        $objPromocion->folio_libro_digital = $row['Folio_Libro_Digital'];
        $objPromocion->consecutivo_exp = $row['Consecutivo_Exp'];
        $dbPromocion->insertPromocion($objPromocion);
    }

?>
