<?php
/* 
 * Genera el reporte de captura de tocas en sala
 */
define("SCRIPT",1)
echo "0\n";
//if($_GET['psw']!='mnrywoieurwerw6fhf')
        //exit();
require_once '/var/www/php-inc/globals.php';
echo "1\n";
require_once "$inc_dir/db/DBReporteSalas.php";
echo "2\n";
require_once "$inc_dir/utils/TimeUtils.php";
echo "3\n";

echo "Generando de " . $argv[1] . " a " . $argv[1] "\n";
if(!isset($argv[1]) || !isset($argv[2])){
    exit();
}

$inicio=$argv[1];
$final=$argv[2];
$salas = Array("1SC","2SC","3SC","4SC","5SC","6SC","7SC","8SC","9SC","10SC");
$dbReporteSalas=new DBReporteSalas();

$NAD=$inicio;
do{
    do{
     $AD=$NAD;
     $NAD = $dbReporteSalas->getNAD($AD);
    }while(!$dbReporteSalas->isAD($AD));
    
    $creados = $dbReporteSalas->getGenerados($AD, $NAD);
    $publicados=$dbReporteSalas->getPublicados($AD);
    $tocasCreados=$dbReporteSalas->getTocasCreados($AD, $NAD);
    
    echo "<table>";
    echo "<TR><TD colspan=11>$AD</TD></TR>";
    echo "<TR><TD>Tocas</TD></TR>";
    echo "<TR><TD>Sala</TD><TD>Creados</TD></TR>";
    echo "<TR><TD></TD><TD>Totales</TD></TR>";
    
    //Tocas creados
    foreach ($salas as $sala){
        $impreso=false;
        foreach ($tocasCreados as $row){
            if($sala==$row['codigo']){
                echo "<TR><TD>" . $sala . "</TD><TD>" . $row['tocas'] . "</TD></TR>";
                $impreso=true;
            }
        }
        if(!$impreso)
            echo "<TR><TD>" . $sala . "</TD><TD>0</TD></TR>";        
    }
    
    echo "<TR><TD></TD></TR> <TR><TD></TD></TR> <TR><TD>Acuerdos</TD></TR>";
    echo "<TR><TD>Sala</TD><TD colspan='5'>Creados</TD><TD colspan='5'>Publicados</TD></TR>";
    echo "<TR><TD>Totales</TD><TD>Secretaria</TD><TD>Ponencia 1</TD><TD>Ponencia 2</TD><TD>Ponencia 3</TD><TD>Totales</TD><TD>Secretaria</TD><TD>Ponencia 1</TD><TD>Ponencia 2</TD><TD>Ponencia 3</TD></TR>";

    //Acuerdos
    foreach ($salas as $sala){
        echo "<TR>";
        $impreso=false;
        foreach ($creados as $row){
            if($sala==$row['codigo']){
                echo "<TD>" . $sala . "</TD><TD>" . $row['totales'] . "</TD><TD>" . $row['secretaria'] . "</TD><TD>" . $row['ponencia1'] . "</TD><TD>" . $row['ponencia2'] . "</TD><TD>" . $row['ponencia3'] . "</TD>";
                $impreso=true;
            }
        }
        if(!$impreso)
            echo "<TD>" . $sala . "</TD><TD>0</TD><TD>0</TD><TD>0</TD><TD>0</TD><TD>0</TD>";        
        
        $impreso=false;
        foreach ($publicados as $row){
            if($sala==$row['codigo']){
                echo "<TD>" . $sala . "</TD><TD>" . $row['totales'] . "</TD><TD>" . $row['secretaria'] . "</TD><TD>" . $row['ponencia1'] . "</TD><TD>" . $row['ponencia2'] . "</TD><TD>" . $row['ponencia3'] . "</TD>";
                $impreso=true;
            }
        }
        if(!$impreso)
            echo "<TD>" . $sala . "</TD><TD>0</TD><TD>0</TD><TD>0</TD><TD>0</TD><TD>0</TD>";
        
        echo "</TR>";
    }
    
    echo "<TR><TD></TD></TR><TR><TD></TD></TR>";
    
}while(TimeUtils::compara_fechas($AD, $final)<0);

