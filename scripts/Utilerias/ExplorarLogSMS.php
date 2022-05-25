<?php
define("SCRIPT", '1');
require_once '../../php-inc/globals.php';
require_once "$inc_dir/db/DBUsuario.php";
if( $argc<3)
    exit();
$origen = $argv[1];
$detino = $argv[2];
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
$amountLine = '/^ Se enviaron (\d+) .*$/';
$movilLine = '/^ (.+)\(([0123456789-]+)\)$/';

$searchAmount = false;

$dbUsuario = new DBUsuario();

while( ($line=fgets($fOrigen)) !== false ){

    if(preg_match($movilLine, $line, $matches)){

        $data = $dbUsuario->obtenUsuarioPorUsuario($matches[1]);
        fwrite( $fDestino, "\t" . $matches[1] . "\t" . $matches[2] ."\n");
        if($data !== false){
            foreach ($data as $row){
                fwrite($fDestino, "\t\t\t" . $row['nombres'] .  "\t" . $row['paterno'] .  "\t" . $row['materno']
                     .  "\t" .  $row['juzgado'] .  "\t" .  $row['expediente'] .  "\t" .  $row['anio'] .  "\t" .  $row['bis']
                     .  "\t" .  $row['tipo_expediente'] . "\n");
            }
        }
        continue;
    }


    if($searchAmount){
       if(preg_match($amountLine, $line, $matches)){
           echo "MATCH2\n";
           fwrite($fDestino, $matches[1] . "\n\n");
           $searchAmount=false;
       }
    }
    else{
       if(preg_match($dateLine, $line, $matches)){
           echo "MATCH1\n";
           fwrite($fDestino, $matches[1] . "\n");
           $searchAmount=true;
       }
    }



}

fclose($fOrigen);
fclose($fDestino);
?>
