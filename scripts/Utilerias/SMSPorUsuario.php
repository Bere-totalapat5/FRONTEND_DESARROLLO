<?php
define("SCRIPT", '1');
require_once '../../php-inc/globals.php';
require_once "$inc_dir/db/DBUsuario.php";
if( $argc<4)
    exit();
$origen = $argv[1];
$detino = $argv[2];
$telefono = $argv[3];
echo "Desde $origen a $detino\n";

$fOrigen = fopen($origen, "r");
$fDestino = fopen($detino, "w");

if($fOrigen===FALSE){
    echo "Fallo origen\n";
    exit ();
}
if($fDestino===FALSE){
    echo "Fallo destino\n";
    exit ();
}

$dateLine = '/^(\d{4}-\d{2}-\d{2}) Reporte diario.*$/';
$endLine = '/^http://sicor.poderjudicialdf.gob.mx$/';
$movilLine = '/^.+' . $telefono . '.+$/';

$searchAmount = false;

$dbUsuario = new DBUsuario();

$writeLine=false;
while( ($line=fgets($fOrigen)) !== false ){

    if(preg_match($dateLine, $line, $matches)){
        echo "MATCH1\n";
        fwrite($fDestino, $matches[1] . "\n");
    }

    if(preg_match($movilLine, $line, $matches)){
        fwrite( $fDestino, "SICOR\n");
        $writeLine=true;
        continue;
    }

    if(preg_match($endLine, $line, $matches)){
        $writeLine=false;
        continue;
    }

    if($writeLine)
        fwrite( $fDestino, "$line\n");
}

fclose($fOrigen);
fclose($fDestino);
?>
