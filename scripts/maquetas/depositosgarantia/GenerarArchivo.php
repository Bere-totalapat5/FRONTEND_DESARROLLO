<?php
define ('SCRIPT', '1');

/* VALORES CONSTANTES*/
define('TIPO_CUENTA_ORIGINADOR','01');
define('NUMERO_CUENTA_ORIGINADOR','65503028892');
define('NOMBRE_ORIGINADOR','TRIBUNAL SUPERIOR DE JUSTICIA DEL DF');
define('CURP_ORIGINADOR','TSJ5501014L8');
define('MODALIDAD','C');
//define('APLICACION_ORDEN','A');
//define('OUT_DIR', '/san/files/h2h/OUT/');
define('OUT_DIR', '/tmp/');

require("/var/www/depgar/php-inc/globals.php");
require("/var/www/depgar/php-inc/db/mysql/DBPersona.php");

date_default_timezone_set("America/Mexico_City");
while ( true ) {
  $dbPersona = new DBPersona();
  $msqlTime = date("Y-m-d");
  // echo "********************************************\n";
  // echo "GenerarArchivo.php $msqlTime\n";
  
  //Obtener tranasacciones
  $data = $dbPersona->obtenerPersonasTransaccionPorPublicar();

  if( !is_array($data) || count($data)==0){
    echo "No hay transacciones pendientes\n";
    exit();
  }
  
  $dataArreglaFecPersona=$data;
  //Revisa y arregla datos
  foreach ($dataArreglaFecPersona as $fila ){
  	$idPersonaArregla = $fila['transaccion']->idPersona;
  	$nombreArregla = $fila['transaccion']->nombre_beneficiario;
  	$modificaFecPerTransaccion = $dbPersona->modificaFechasPersonaTransaccion($nombreArregla,$idPersonaArregla);
  }
  $data = $dbPersona->obtenerPersonasTransaccionPorPublicar();
  foreach ($data as $row ){
  $cuenta = $dbPersona->obtenerCuentaDiaria($msqlTime);
  
  if ($cuenta < 100) {
    $acuenta = str_pad($cuenta, 2, "0", STR_PAD_LEFT);
  } elseif ($cuenta > 99 and $cuenta < 2700) {
    /* Israel Cao icao@santander.com.mx
       Poniendo una letra o dos al final del nombre del archivo,
       es decir tran160420130198ab_PJDF.in
    */
    $x = (int)( $cuenta / 100 );
    $acuenta = str_pad($cuenta % 100, 2, "0", STR_PAD_LEFT) . chr($x + 96);
  } else {
    $x100 = (int)( $cuenta / 2700 ) ;
    $c = (int) ($cuenta - $x100 * 2700) ;
    $x = (int)( $c / 100 );
    $acuenta = str_pad($cuenta % 100, 2, "0", STR_PAD_LEFT) . chr($x100+96) . chr($x + 97);
  }

  $time = date("dmY");
  $time2 = date("Ymd");
  $file_path = OUT_DIR . "tran" . $time . $acuenta . "98_PJDF.in";
  echo $file_path . "\n";
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
  //foreach ($data as $row ){
    ++$cont;
    if($row['transaccion']->fecha_aplicacion=='')
      $row['transaccion']->fecha_aplicacion='00000000';
    if($row['transaccion']->fecha_limite=='')
      $row['transaccion']->fecha_limite='00000000';
    
    fwrite2($file, "02");                                            //(1)tipode registro
    fwrite2($file, str_pad($cont,7,'0',STR_PAD_LEFT));               //(2)secuencial
    fwrite2($file, "60");                                            //(3)codigo de operacion
    fwrite2($file, "01");                                            //(4)codigode divisa
    fwrite2($file, $row['transaccion']->fecha_limite);               //(5)Fecha l??mite de pago
    fwrite2($file, "014");                                           //(6)Banco presentador
    fwrite2($file, "000");                                           //(7)Banco Receptor
    fwrite2($file, str_pad(str_replace('.', '', $row['transaccion']->importe),15,   //(8)Importe de la operacion
			   '0',STR_PAD_LEFT));
    fwrite2($file, str_pad($row['transaccion']->idPersona,16,'0',STR_PAD_LEFT)); //(9)N??merode orden
    fwrite2($file, "80");                                            //(10)tipo de operacion
    fwrite2($file,$row['transaccion']->fecha_aplicacion);            //(11)Fecha de aplicaci??n
    fwrite2($file, TIPO_CUENTA_ORIGINADOR);                          //(12)Tipo de cuenta del oriinador
    fwrite2($file, str_pad(NUMERO_CUENTA_ORIGINADOR,20,'0',          //(13)Numero de cuenta del originador
			   STR_PAD_LEFT));
    fwrite2($file, str_pad(NOMBRE_ORIGINADOR,40,' ', STR_PAD_RIGHT));//(14)nombre del originador
    fwrite2($file, str_pad(CURP_ORIGINADOR,18,' ',STR_PAD_RIGHT));   //(15)CURP del originador            
    fwrite2($file, "00");                                            //(16)Tipo de cuenta del receptor
    fwrite2($file, str_pad('',20,'0', STR_PAD_LEFT));                //(17)Numero de cuenta del receptor
    $benef = uper($row['persona']->nombre_beneficiario . " " .
		  $row['persona']->paterno_beneficiario . " " .
		  $row['persona']->materno_beneficiario );
    echo "Orden/Beneficiario: " . str_pad($row['transaccion']->referencia_santander,13,'0',STR_PAD_LEFT) . " " . $benef . " ";
    // nombre
    if( $row['persona']->tipo=='fisica')                             //(18)nombre del receptor.
      fwrite2($file,
	      substr(str_pad($benef, 40,
			     ' ', STR_PAD_RIGHT),0,40));
    else if( $row['persona']->tipo=='moral')
      fwrite2($file,
	      substr(str_pad(uper(
			   $row['persona']->nombre_representante . " " .
			   $row['persona']->paterno_representante . " " .
			   $row['persona']->materno_representante ), 40,
			     ' ', STR_PAD_RIGHT),0,40));
    else
      fwrite2($file,
	      substr(str_pad(uper(
			   $row['persona']->nombre_beneficiario), 40,
			     ' ', STR_PAD_RIGHT),0,40));
    
    if( $row['persona']->tipo=='fisica')                             //(19)CURP del receptor
      fwrite2($file, str_pad($row['persona']->CURP,18,' ',
			     STR_PAD_RIGHT));
    else if( $row['persona']->tipo=='moral')
      fwrite2($file, str_pad($row['persona']->RFC,18,' ',
			     STR_PAD_RIGHT));
    else
      fwrite2($file, str_pad("",18, ' ', STR_PAD_RIGHT));
    
    fwrite2($file, str_pad("",40, ' ', STR_PAD_RIGHT));              //(20)Referencia del servicio con el emisor
    fwrite2($file, str_pad("",40, ' ', STR_PAD_RIGHT));              //(21)Nombre del titular del servicio
    fwrite2($file, str_pad("",15, '0', STR_PAD_RIGHT));              //(22)Iva operacion
    fwrite2($file, str_pad('1',7, '0', STR_PAD_LEFT));               //(23)Referencia numerica del originador
    if( $row['persona']->tipo=='fisica')                             //(24)Persona autorizada
      fwrite2($file,
	      substr(str_pad($benef, 40,
			     ' ', STR_PAD_RIGHT),0,40));
    else if( $row['persona']->tipo=='moral')
      fwrite2($file,
	      substr(str_pad(uper(
			   $row['persona']->nombre_representante . " " .
			   $row['persona']->paterno_representante . " " .
			   $row['persona']->materno_representante ), 40,
			     ' ', STR_PAD_RIGHT),0,40));
    else
      fwrite2($file,
	      str_pad(substr(uper(
			   $row['persona']->nombre_beneficiario), 40,
			     ' ', STR_PAD_RIGHT),0,40));
    
    fwrite2($file, str_pad($row['persona']->id_autorizado,30,' ',    //(25)identificacion de la persona autorizada
			   STR_PAD_RIGHT));
    fwrite2($file, "00");                                            //(26)Motivo de devolucion
    //fwrite2($file, $row['transaccion']->fecha_aplicacion);         //(27)Fecha de operacion
    fwrite2($file, date('%Y%m%d'));          						 //(27)Fecha de operacion
    fwrite2($file, MODALIDAD);                                       //(28)Modalidad
    fwrite2($file, "9999");                                          //(29)sucursal
    fwrite2($file, "E");                                             //(30)tipo de pago
    fwrite2($file, $row['transaccion']->aplicacion_orden);           //(31)Accion de laorden
    fwrite2($file, str_pad($row['transaccion']->vigencia,3,'0',
			   STR_PAD_LEFT));                          //(32)vigencia de la orden
    fwrite2($file, "  ");                                            //(33)Uso futuro banco
    fwrite2($file, str_repeat(' ', 17));
    fwrite2($file, str_pad($row['transaccion']->referencia_santander //(34)referencia beneficiario
			   ,13,'0',STR_PAD_LEFT));
    fwrite2($file, str_pad(uper($row['transaccion']->concepto),30   //(35)Concepto del cobro
			   ,' ', STR_PAD_RIGHT));
    fwrite2($file, "\n");
    $importe_total += floatval($row['transaccion']->importe);
	if ($row['transaccion']->estatus == "POR CANCELAR") {
    	$dbPersona->actualizarEstatus($row['transaccion']->idPersona,'ENVIADA CANCELACION');
	}else {
    	$dbPersona->actualizarEstatus($row['transaccion']->idPersona,'ENVIADO');
	}
  //}

  //Pie
  fwrite2($file, "09");        //Tipo de registro
  fwrite2($file, str_pad($cont+1,7,'0',STR_PAD_LEFT));   //nuemero de secuencia
  fwrite2($file, "60");        //Codigo de operacion
  fwrite2($file, "0000001");   //numero de lote
  fwrite2($file, str_pad($cont-1, 7,'0',STR_PAD_LEFT)); //Numero de operaciones
  fwrite2($file, str_pad(number_format($importe_total,2,'',''), 18,'0',STR_PAD_LEFT));//importe total
  // fwrite2($file, "                    ");
  fwrite2($file, str_pad("",40+399,' ',STR_PAD_LEFT));
  fwrite2($file, "\n");

  fclose($file);
  $dbPersona->incrementarCuentaDiaria(date("Y-m-d"));
  }
}

function fwrite2($file, $data){
  fwrite($file, utf8_decode($data));
}

function uper($str){
  $str2 = str_replace("??", "N", $str);
  $str2 = str_replace("??", "N", $str2);
  $str2 = str_replace("??", "A", $str2);
  $str2 = str_replace("??", "E", $str2);
  $str2 = str_replace("??", "I", $str2);
  $str2 = str_replace("??", "O", $str2);
  $str2 = str_replace("??", "U", $str2);
  $str2 = str_replace("??", "A", $str2);
  $str2 = str_replace("??", "E", $str2);
  $str2 = str_replace("??", "I", $str2);
  $str2 = str_replace("??", "O", $str2);
  $str2 = str_replace("??", "U", $str2);
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
