<?php
include_once 'Classes/WSFirma.php';
$firmaWS = new WSFirma();
$firmaWS->setConfiguracion("http://mifirmaservices.poderjudicialcdmx.gob.mx/certifiel_bus/WSCommerceFiel/WebService.asmx?WSDL", "user_oficios", "M82KrHjC", "oficios");
$firmaWS->setFileUploadWS("http://mifirmaservices.poderjudicialcdmx.gob.mx/Upload/upload.asmx?WSDL");
//$firmaWS->setConfiguracion("http://172.19.224.26/certifiel_bus/WSCommerceFiel/WebService.asmx?WSDL", "user_oficios", "M82KrHjC", "oficios");
//$firmaWS->setFileUploadWS("http://172.19.224.26/Upload/upload.asmx?WSDL");
include_once "Constantes.php";
ini_set('default_socket_timeout', 1000 * 120);

//Identificador de la TSA para generar estampillas de tiempo
$firmaWS->setIdentificadorTSA("tsapj");

function encodeError($iErrorCode, $strDescription)
{
	$arr = array('status' => $iErrorCode, 'description' => $strDescription);
	echo json_encode($arr);
}

if (strcmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {


	if (isset($_POST["metodo"])) {
		$strMetodo = $_POST["metodo"];
		if ($strMetodo == "der") {
			if (!isset($_POST['digest']) || empty($_POST["digest"]) || empty($_POST["fecha"]) || !isset($_POST['fecha'])) {
				encodeError(-1, "Parámetros incompletos");
			} else {
				$digestion = str_replace(" ", "+", $_POST["digest"]);
				$fecha = $_POST["fecha"];
				$firmaWS->getDigestionExtendida($digestion, $fecha);
			}
		} else if ($strMetodo == "decodecert") {
			$ocsp = true;
			if (isset($_POST["cert"])) {
				$cert = $_POST["cert"];
				if (isset($_POST["ocsp"])) {
					$ocsp = $_POST["ocsp"];
				}
				if (!empty($cert)) {
					$cert = str_replace(" ", "+", $cert);
					$realizarOcsp = true;
					if ($ocsp == "false") {
						$realizarOcsp = false;
					}
					$firmaWS->setReferencia("Decodificar Certificado");
					$firmaWS->setCertificado($cert);
					$firmaWS->setOCSP($realizarOcsp);
					$firmaWS->decodificaCertificado();
				} else {
					encodeError(-1, "Parámetros incompletos");
				}
			} else {
				encodeError(-1, "Parámetros incompletos");
			}
		} else if ($strMetodo == "pkcs1") {

			if (!isset($_POST['original']) || empty($_POST["original"]) || !isset($_POST['firma']) || empty($_POST["firma"]) || !isset($_POST['cert']) || empty($_POST["cert"])) {
				encodeError(-1, "Parámetros de petición incompletos");
			} else {
				$cadenaOriginal = $_POST["original"];
				$firma = $_POST["firma"];
				$certificado = $_POST["cert"];
				$firma = str_replace(" ", "+", $firma);
				$certificado = str_replace(" ", "+", $certificado);
				$firmaWS->setReferencia("Firma cadena PKCS1");
				$firmaWS->setCertificado($certificado);
				$firmaWS->setCadenaOriginal($cadenaOriginal);
				$firmaWS->setFirmaDigitalCadena($firma);
				$firmaWS->firmaPKCS1();
			}
		} else if ($strMetodo == "vector") {
			if (!isset($_POST['vector']) || empty($_POST["vector"]) || !isset($_POST['firma']) || empty($_POST["firma"]) || !isset($_POST['cert']) || empty($_POST["cert"])) {
				encodeError(-1, "Parámetros incompletos");
			} else {
				$vector = $_POST["vector"];
				$firmaVector = $_POST["firma"];
				$certificadoBase64 = $_POST["cert"];

				$vector = str_replace(" ", "+", $vector);
				$firmaVector = str_replace(" ", "+", $firmaVector);
				$certificadoBase64 = str_replace(" ", "+", $certificadoBase64);

				$firmaWS->setCertificado($certificadoBase64);
				$firmaWS->setCadenaOriginal($vector);
				$firmaWS->setFirmaDigitalCadena($firmaVector);

				if (isset($_POST["createPDF"])) {
					if ($_POST["createPDF"] == "true") {
						//Leer archivo original

						$nombre_fichero = $path.$_POST["filePath"];
						$gestor = fopen($nombre_fichero, "r");
						$contenido = fread($gestor, filesize($nombre_fichero));
						fclose($gestor);

						$firmaWS->setFileName($_POST["filePath"]);
						$firmaWS->obtenerPDF($contenido);
					} else {
						$firmaWS->firmaPKCS7();
					}
				} else {
					$firmaWS->firmaPKCS7();
				}
			}
		}
	}
}
