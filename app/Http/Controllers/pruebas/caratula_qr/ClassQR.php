<?PHP
/*
	*	Programa: 		ClassQR.php
	*	Creado:			Mayo 01, 2019
	*	Descripción:	Realiza altas y modificaciones a la BD para la generación de los sellos
*/



	//use setasign\Fpdi\Fpdi;
	//require_once('service/fpdf/fpdf.php'); // Incluímos las librerías anteriormente mencionadas
	//require_once('service/fpdi/src/autoload.php'); // Incluímos las librerías anteriormente mencionadas
	//$pdf = new FPDI();

class QR
{
	function generaImagenQR($idSentencia,$metadata){
	   global $oQR;
	   $fecha = date("Ymd");
	   $aQR = array();
	   $PNG_TEMP_DIR = dirname(__FILE__,2).DIRECTORY_SEPARATOR."caratula_qr/qr_img/".DIRECTORY_SEPARATOR; // OJO CON LAS DIAGONALES (LINUX /-WINDOWS\\)
	     $PNG_WEB_DIR = "caratula_qr/qr_img/"; //$PNG_WEB_DIR = "qr_img\\".$fecha."\\";
	     //return $PNG_WEB_DIR;
	      //if (!file_exists($PNG_TEMP_DIR))
	      //  mkdir($PNG_TEMP_DIR);
	    $aQR["estatus"] = false;
	    $filename = $PNG_TEMP_DIR.$idSentencia.'.png'; 
	    $errorCorrectionLevel = 'M';
	    $matrixPointSize = "5";

	    if (isset($idSentencia)) {
	        $filename = $idSentencia.'.png';
	        $filenameRuta = $PNG_WEB_DIR.$filename;
	        $filenameDir = $PNG_TEMP_DIR.$filename;
	        $back_color = 0xFFFFFF; 
	        $fore_color = 0x000000; 
	        $contenidoQR = $metadata;
	        QRcode::png($contenidoQR,$filenameDir,$errorCorrectionLevel, $matrixPointSize, 2, false, $back_color, $fore_color);

	        $img = $filenameDir;
	        $img64 = base64_encode($img); 

	        $aQR["qrRuta"] = $filenameDir;
	        $aQR["qr64"] = $img64;
	        $aQR["estatus"] = true;
	        

	    }
	    return $aQR;
	}
		
}
?>