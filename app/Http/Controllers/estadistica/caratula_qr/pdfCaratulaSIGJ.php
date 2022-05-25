<?php
  //include "ClassQR.php";
  //include "qrfmwk/qrlib.php"; 
  
use setasign\Fpdi\Fpdi;

require_once('fpdf/fpdf.php'); // Incluímos las librerías anteriormente mencionadas
require_once('fpdi/src/autoload.php'); // Incluímos las librerías anteriormente mencionadas


function guardarPDF($idSentencia, $metadatos){

    

    //1593141963|6|1|1.0|C|C100|2020|1|Ordinario|Centésimo de lo Civil|2020-08-26 20:24:17|Salvador  Ríos  García , Pepe  Pecas  |Lalo  Landa  |1|1593141963|sigj_promocion


    $datos=explode('/', $metadatos);

    // Creación del objeto de la clase heredada
    $pdf = new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',11);
    $pdf->Image(storage_path('app/temporales/'.$idSentencia.'.png'),70,70, 73);
    $pdf->Ln(120);


    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID DOCUMENTO:                             '.$datos[0]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('JUZGADO:                                       '.$datos[1]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('EXPEDIENTE:                                 '.$datos[2].'/'.$datos[3]),0,1);
    //$pdf->Cell(20);
    //$pdf->Cell(0,6,utf8_decode('NÚMERO EXPEDIENTE:                '.$datos[7]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('FECHA DE DOCUMENTO:             '.$datos[4]),0,1);
    //$pdf->Output();

    $pdf->Output(storage_path('app/temporales/'.$idSentencia.'.png'),'F');

    /*
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID DOCUMENTO:                             '.$datos[0]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID APLICATIVO:                               '.$datos[2]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID MATERIA:                                    '.$datos[4]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('MATERIA:                                        '.$datos[9]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID JUICIO:                                        '.$datos[13]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('JUICIO:                                            '.$datos[8]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID JUZGADO:                                  '.$datos[5]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('JUZGADO:                                       '.$datos[9]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('AÑO EXPEDIENTE:                         '.$datos[6]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('NÚMERO EXPEDIENTE:                '.$datos[7]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ASUNTO:'),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ID TIPO EXPEDIENTE:                   POS'),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('TIPO EXPEDIENTE:                        POSTERIOR'),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('FECHA DE DOCUMENTO:             '.$datos[10]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('ACTOR:                                           '.$datos[11]),0,1);
    $pdf->Cell(20);
    $pdf->Cell(0,6,utf8_decode('DEMANDAO:                                   '.$datos[12]),0,1);
    $pdf->Output();
    */
}


/*
DATOS FINALES
$idSentencia = rand();
$formData = array("A","B","C","D");


$qrGenerado = $oQR -> generaImagenQR($idSentencia,$formData);
$resultado = guardarPDF($idSentencia);

var_dump($resultado);
*/


/* $pdf->AddPage();
$pdf->setSourceFile("Ruta_de_mi_archivo_PDF"); // Sin extensión
$template = $pdf->importPage(1);
$pdf->useTemplate($template);
$pdf->Image('Ruta_de_mi_imagen.jpg', $x, $y, $width, $height);
$pdf->Output($nuevoNombreDelPDF, "F"); */

?>