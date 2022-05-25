<?php
$connection = mysql_connect( 'localhost', 'root', '123456',true);
mysql_select_db('sibjdf', $connection);
mysql_set_charset('utf8',  $connection);

$qry =
"SELECT numero_orden , " .
"DATE_FORMAT(fecha_aplicacion,'%Y%m%d') fecha_aplicacion ,DATE_FORMAT(fecha_limite,'%Y%m%d') fecha_limite , importe ,".
"tipo_cuenta_originador ,numero_cuenta_originador ,nombre_originador ,CURP_originador ,".
"tipo_cuenta_receptor ,numero_cuenta_receptor ,nombre_beneficiario ,CURP_receptor ,".
"id_autorizado ,motivo_devolucion ,modalidad ,aplicacion_orden ,vigencia ,".
"referencia ,concepto ,registrado ,verificado ".
"FROM dg_transaccion where registrado='F' and (numero_orden>=1319319600004 AND numero_orden<=1319319600007) ORDER BY numero_orden LIMIT 10";

$result = mysql_query($qry);
$time = date("dmY");
$time2 = date("Ymd");
$file_path = "files/tran" . $time . "0198_TJDF.in";
$file = fopen($file_path, "w");
if($file===false){
    echo "No se pudo crear el archivo $file_path\n";
    exit();
}

fwrite2($file, "01");
fwrite2($file, "0000001");
fwrite2($file, "60");
fwrite2($file, "014");
fwrite2($file, "E");
fwrite2($file, "2");
fwrite2($file, "0000001");
fwrite2($file, $time2);
fwrite2($file, "01");
fwrite2($file, "00");
fwrite2($file, "1");
fwrite2($file, str_pad("",446, ' ', STR_PAD_RIGHT));
fwrite2($file, "\n");

$cont=1;
$importe_total=0;
while ($row = mysql_fetch_array($result) ){
    ++$cont;
    fwrite2($file, "02");                                            //tipode registro
    fwrite2($file, str_pad($cont,7,'0',STR_PAD_LEFT));               //secuencial
    fwrite2($file, "60");                                            //codigo de operacion
    fwrite2($file, "01");                                            //codigode divisa
    fwrite2($file, $row['fecha_limite']);                            //fecha limite de pago
    fwrite2($file, "014");                                           //Bancopresentador
    fwrite2($file, "000");                                           //BancoReceptor
    fwrite2($file, str_pad($row['importe'],15,'0',STR_PAD_LEFT));    //Importe de la operacion
    fwrite2($file, str_pad($row['numero_orden'],16,'0',STR_PAD_LEFT));//Numero de orden de pago
    fwrite2($file, "80");                                            //tipo de operacion
    fwrite2($file, $row['fecha_aplicacion']);                        //Fecha de aplicacion de la orden
    fwrite2($file, "01");                                            //Tipo de cuenta del oriinador
    fwrite2($file, str_pad($row['numero_cuenta_originador'],20,'0',STR_PAD_LEFT));//Numero de cuenta del originador
    fwrite2($file, str_pad(uper($row['nombre_originador']),40,' ', STR_PAD_RIGHT));//nombre del originador
    fwrite2($file, str_pad($row['CURP_originador'],18,' ',STR_PAD_RIGHT));//CURP del originador
    fwrite2($file, "00");                                            //Tipo de cuenta del receptor
    fwrite2($file, str_pad($row['numero_cuenta_receptor'],20,'0',STR_PAD_LEFT));//Numero de cuenta del receptor
    fwrite2($file, str_pad(uper($row['nombre_beneficiario']),40,' ', STR_PAD_RIGHT));//nombre del receptor
    fwrite2($file, str_pad($row['CURP_receptor'],18,' ',STR_PAD_RIGHT));//CURP del receptor
    fwrite2($file, str_pad("",40, ' ', STR_PAD_RIGHT));                  //Referencia del servicio con el emisor
    fwrite2($file, str_pad("",40, ' ', STR_PAD_RIGHT));                  //Nombre del titular del servicio
    fwrite2($file, str_pad("",15, '0', STR_PAD_RIGHT));                  //Iva operacion
    fwrite2($file, str_pad($row['referencia'],7, '0', STR_PAD_RIGHT));                  //Referencia numerica del originador
    fwrite2($file, str_pad(uper($row['nombre_beneficiario']),40,' ', STR_PAD_RIGHT));//Persona autorizada
    fwrite2($file, str_pad($row['id_autorizado'],30,' ',STR_PAD_RIGHT));//identificacion de la persona autorizada
    fwrite2($file, "00");                                                //Motivo de devolucion
    fwrite2($file, $row['fecha_aplicacion']);                        //Fecha de operacion
    fwrite2($file, $row['modalidad']);                               //Modalidad
    fwrite2($file, "9999");                                          //sucursal
    fwrite2($file, "E");                                             //tipo de pago
    fwrite2($file, $row['aplicacion_orden']);                        //Accion de laorden
    fwrite2($file, str_pad($row['vigencia'],3,'0',STR_PAD_LEFT));    //vigencia de la orden
    fwrite2($file, "  ");                                            //Uso futuro banco
    fwrite2($file, str_pad($row['referencia'],30,'0',STR_PAD_LEFT)); //referencia beneficiario
    fwrite2($file, str_pad(uper($row['concepto']),30,' ',STR_PAD_RIGHT));  //Concepto del cobro
    fwrite2($file, "\n");
    $importe_total += intval($row['importe']);
}

//Pie
fwrite2($file, "09");        //Tipo de registro
fwrite2($file, str_pad($cont+1,7,'0',STR_PAD_LEFT));   //nuemero de secuencia
fwrite2($file, "60");        //Codigo de operacion
fwrite2($file, "0000001");   //numero de lote
fwrite2($file, str_pad($cont-1, 7,'0',STR_PAD_LEFT)); //Numero de operaciones
fwrite2($file, str_pad($importe_total, 18,'0',STR_PAD_LEFT));//importe total
fwrite2($file, "                    ");
fwrite2($file, str_pad("",419,' ',STR_PAD_LEFT));
fwrite2($file, "\n");

fclose($file);

function fwrite2($file, $data){
    fwrite($file, utf8_decode($data));
}

function uper($str){
    $str2 = str_replace("ñ", "N", $str);
    $str2 = str_replace("Ñ", "N", $str2);
    $str2 = str_replace("á", "A", $str2);
    $str2 = str_replace("é", "E", $str2);
    $str2 = str_replace("í", "I", $str2);
    $str2 = str_replace("ó", "O", $str2);
    $str2 = str_replace("ú", "U", $str2);
    $str2 = str_replace("Á", "A", $str2);
    $str2 = str_replace("É", "E", $str2);
    $str2 = str_replace("Í", "I", $str2);
    $str2 = str_replace("Ó", "O", $str2);
    $str2 = str_replace("Ú", "U", $str2);
    $str2 = strtoupper($str2);
    $size = strlen($str2);
    $newStr = "";
    for($i=0;$i<$size;++$i){
        if( $str2[$i]==' ' || 
            ( ord($str2[$i])>47 && ord($str2[$i])<58 ) ||
            ( ord($str2[$i])>64 && ord($str2[$i])<91 ))
            $newStr.=$str2[$i];
    }

    return $newStr;
}
?>
