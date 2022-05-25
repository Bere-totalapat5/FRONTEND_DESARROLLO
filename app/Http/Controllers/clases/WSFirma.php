<?php

namespace App\Http\Controllers\clases;

class WSFirma
{
    private $usuario;
    private $contrasena;
    private $entidad;
    private $nameSpaceWS = "www.XMLWebServiceSoapHeaderAuth.net";
    private $urlWebService;
    
    private $certificado;
    private $ocsp;
    private $soapHeader;
    private $soapHeader2ndVersion;
    private $referencia;
    
    private $strCadenaOriginal;
    private $strFirma;


    private $identificadorTSA;
  
    private $urlFileUploadWS;

    private $strFileName;



    public function setConfiguracion($strURLWebService, $strUsuario, $strClave, $strEntidad)
    {
        $this->setUsuario($strUsuario);
        $this->setContrasena($strClave);
        $this->setEntidad($strEntidad);
        $this->setURL($strURLWebService);
        
    }
    public function setFileName($strFileName){
     $this->strFileName=$strFileName;
    }
    public function getFileName(){
        return $this->strFileName;
    }
    public function setFileUploadWS($urlFileUploadWS){
      $this->urlFileUploadWS=$urlFileUploadWS;
    }
    public function setURL($url = null)
    {
        $this->urlWebService = $url;
    }
    public function getURL()
    {
        return $this->urlWebService;
    }
    public function setUsuario($usuario = null)
    {
        $this->usuario = $usuario;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setContrasena($contrasena = null)
    {
        $this->contrasena = $contrasena;
    }
    public function getContrasena()
    {
        return $this->contrasena;
    }
    
    public function setEntidad($entidad = null)
    {
        $this->entidad = $entidad;
    }
    public function getEntidad()
    {
        return $this->entidad;
    }
    public function setReferencia($referencia = "Sin Referencia")
    {
        $this->referencia = $referencia;
    }
    public function getReferencia()
    {
        return is_null($this->referencia) ? 'Sin Referencia' : (strcmp($this->referencia, 'undefined') == 0 ? 'Sin Referencia' : $this->referencia);
    }
  
    public function setCertificado($certificado = null)
    {
        return $this->certificado = $certificado;
    }
    public function getCertificado()
    {
        return (strpos($this->certificado, ' ') !== false ? str_replace(' ', '+', $this->certificado) : $this->certificado);
    }
    public function setOCSP($ocsp = true)
    {
        if ($ocsp == false) {
            $this->ocsp = 1;
        } else {
            $this->ocsp = 0;
            
        }
    }
    public function getOCSP()
    {
        return $this->ocsp;
    }
	  
    public function setIdentificadorTSA($strIdentificadorTSA)
    {
        $this->identificadorTSA = $strIdentificadorTSA;
    }
    public function getIdentificadorTSA()
    {
        return $this->identificadorTSA;
        
    }
    
    private function generateHeader()
    {
        $this->soapHeader = array(
            'Usuario' => $this->getUsuario(),
            'Clave' => $this->getContrasena(),
            'Entidad' => $this->getEntidad()
        );
    }
    private function generateHeader2ndVersion()
    {
        $this->soapHeader2ndVersion = array(
            'User' => $this->getUsuario(),
            'Password' => $this->getContrasena(),
            'Entity' => $this->getEntidad()
        );
    }
    
    public function setCadenaOriginal($strCadenaOriginal)
    {
        $this->strCadenaOriginal = $strCadenaOriginal;
    }
    public function getCadenaOriginal()
    {
        return (strpos($this->strCadenaOriginal, ' ') !== false ? str_replace(' ', '+', $this->strCadenaOriginal) : $this->strCadenaOriginal);
    }
    
    public function setFirmaDigitalCadena($strFirmaDigital)
    {
        $this->strFirma = $strFirmaDigital;
    }
    public function getFirmaDigitalCadena()
    {
        return (strpos($this->strFirma, ' ') !== false ? str_replace(' ', '+', $this->strFirma) : $this->strFirma);
    }
    

    /*
	 * Decodifica certificado
	*/
    public function decodificaCertificado($strTsa="NA",$strSoapHeader = "AuthSoapHd")
    {
        $cliente = new soapclient($this->getURL(), array(
            "trace" => 1
        ));
        $this->generateHeader();
        $header  = new SoapHeader($this->nameSpaceWS, $strSoapHeader, $this->soapHeader);
        $payload = array(
            "evcOper" => $this->getOCSP(),
            "evcCertificado" => $this->getCertificado(),
            "evcReferencia" => $this->getReferencia(),
            "evcTsa" =>$strTsa
        );
        $client  = new SoapClient($this->getURL());
        $client->__setSoapHeaders($header);
        $result = $client->__soapCall("PwuDecodificaCertificado", array(
            $payload
        ));
        $response =$result->PwuDecodificaCertificadoResult;
        if($response->Estado==0){
            $data = array(
                "state" => $response->Estado,
                "description" => $response->Descripcion,
                "hexSerie" => $response->HexSerie,
                "notBefore" => $response->FechaInicio,
                "notAfter" => $response->FechaFin,
                "subjectName" => $response->SubjectNombre,
                "subjectEmail" => $response->SubjectCorreo,
                "subjectOrganization" => $response->SubjectOrganizacion,
                "subjectDepartament" => $response->SubjectDepartamento,
                "subjectState" => $response->SubjectEstado,
                "subjectCountry" => $response->SubjectPais,
                "subjectRFC" => $response->SubjectRFC,
                "subjectCURP" => $response->SubjectCurp,
                "issuerName" => $response->IssuerNombre,
                "issuerEmail" => $response->IssuerCorreo,
                "issuerOrganization" => $response->IssuerOrganizacion,
                "issuerDepartament" => $response->IssuerDepartamento,
                "issuerState" => $response->IssuerEstado,
                "issuerCountry" => $response->IssuerPais,
                "issuerRFC" => $response->IssuerRFC,
                "issuerCURP" => $response->IssuerCurp,
                "publicKey" => $response->LlavePublica,
                "fingerPrint" => $response->Huella,
                "transfer" => $response->Id,
                "date" => $response->Fecha
            );
            echo json_encode($data); 
        }
        else{
            $arr = array ('state'=>$response->Estado,'description'=>$response->Descripcion);
            echo json_encode($arr); 

        }
        
    }

 	/*
	 * Firma de cadenas
	*/
    
    public function firmaPKCS1($strNOM = "NA",$strTsa="NA", $strSoapHeader = "AuthSoapHd")
    {
        $cliente = new soapclient($this->getURL(), array(
            "trace" => 1
        ));
        $this->generateHeader();
        $header  = new SoapHeader($this->nameSpaceWS, $strSoapHeader, $this->soapHeader);
        $payload = array(
            "evcCadena" => $this->getCadenaOriginal(),
            "code" => 3,
            "evcFirma" => $this->getFirmaDigitalCadena(),
            "evcCertificado" => $this->getCertificado(),
            "evcReferencia" => $this->getReferencia(),
            "tsaName" => $strTsa,
            "nomName" => $strNOM
        );
        
        $cliente->__setSoapHeaders($header);
        $resultado = $cliente->__soapCall("PwuPkcs1Evidencias", array(
            $payload
        ));
        $response    = $resultado->PwuPkcs1EvidenciasResult;       
        $arr = array ('state'=>$response->Error,'description'=>$response->Descripcion,"transfer"=>$response->Id,"date"=>$response->Fecha,"commonName"=>$response->Cn,"hexSerie"=>$response->HexSerie);
        echo json_encode($arr); 
    }



    public function getDigestionExtendida($strDigestion,$strFecha, $strSoapHeader = "AuthSoapHd"){
        $cliente = new soapclient($this->getURL(), array(
            "trace" => 1
        ));
        $this->generateHeader();
        $header  = new SoapHeader($this->nameSpaceWS,$strSoapHeader, $this->soapHeader);
        $payload = array(
            "evcDigestion" => $strDigestion,
            "evcFecha" => $strFecha
        );
        $cliente->__setSoapHeaders($header);
        $resultado = $cliente->__soapCall("PwuDigestionExtendida", array(
            $payload
        ));
        $vector=$resultado->PwuDigestionExtendidaResult;
        if(!empty($vector)){
            $arr = array ('state'=>0,'description'=>"Satisfactorio","data"=>$vector);
            echo json_encode($arr); 
        }
        else{
            $arr = array ('state'=>-1,'description'=>"No se pudo generar vector de firma");
            echo json_encode($arr); 
        }
       
    }
    public function firmaExtendidaConGeneracionPDF($strRutaOrigen,$strRutaDestino,$strSoapHeader="AuthSoapHd"){
        $cliente = new soapclient($this->getURL(), array(
            "trace" => 1
        ));
        $this->generateHeader();
        
        $header  = new SoapHeader($this->nameSpaceWS,$strSoapHeader, $this->soapHeader);
        $payload = array(
            "evcCadena" => $this->getCadenaOriginal(),
            "code" => 3,
            "evcFirma" => $this->getFirmaDigitalCadena(),
            "evcCertificado" => $this->getCertificado(),
            "evcReferencia" => "Firma documento ".pathinfo($strRutaOrigen)["filename"],
            "tsaName" => $this->getIdentificadorTSA()
        );
        //Reportamos Firma digital del documento
        $cliente->__setSoapHeaders($header);
        $resultado = $cliente->__soapCall("PwuPkcs1Extendido", array(
            $payload
        ));
        $response=$resultado->PwuPkcs1ExtendidoResult;
        if($response->Error==0){
         $iStatus=0;
         $strDescription="Satisfactorio";
         $iID=$response->Id;
         $strFecha=$response->Fecha;
         $strSerialNumber=$response->HexSerie;
         $strCommonName=$response->Cn;
          
         $payload = array(
            "referencia" => "Generacion PKCS7: ".$iID,
            "source" => $strRutaOrigen,
            "target" => $strRutaDestino.".p7s",
            "ens" => $iID
          );

          //Generamos archivo PKCS7
          $this->generateHeader2ndVersion();
          $header  = new SoapHeader($this->nameSpaceWS,"AuthSoap", $this->soapHeader2ndVersion);
          $cliente->__setSoapHeaders($header);
          $resultado = $cliente->__soapCall("WSCreatePkcs7FromNs", array(
            $payload
          ));
          $pkcs7Result=$resultado->WSCreatePkcs7FromNsResult;
          if($pkcs7Result->State==0){
             //Generamos pdf
             $header  = new SoapHeader($this->nameSpaceWS,$strSoapHeader, $this->soapHeader);
             $cliente->__setSoapHeaders($header);
                
             $payload = array(
              "referencia" => "Generacion PDF: ".$iID,
              "source" => $strRutaDestino.".p7s",
              "target" => $strRutaDestino
             );
             $resultado = $cliente->__soapCall("PwuObtienePdf", array(
                $payload
             ));
             $pdfResult=$resultado->PwuObtienePdfResult;
             if($pdfResult->State==0){
                $arr = array ('state'=>$iStatus,'description'=>$strDescription,"transfer"=>$iID,"date"=>$strFecha,"commonName"=>$strCommonName,"hexSerie"=>$strSerialNumber);
                echo json_encode($arr); 
             }
             else{
                $arr = array ('state'=>$pdfResult->State,'description'=>$pdfResult->Descript);
                echo json_encode($arr); 
             }
          }
          else{
            $arr = array ('state'=>$pkcs7Result->State,'description'=>$pkcs7Result->Description);
            echo json_encode($arr); 

          }
        }
        else{
            $arr = array ('state'=>$response->Error,'description'=>$response->Descripcion);
            echo json_encode($arr); 
        }

    }

    public function firmaPKCS7($strSoapHeader="AuthSoapHd"){
        $cliente = new soapclient($this->getURL(), array(
            "trace" => 1
        ));
        $this->generateHeader();
        
        $header  = new SoapHeader($this->nameSpaceWS,$strSoapHeader, $this->soapHeader);
        $payload = array(
            "evcCadena" => $this->getCadenaOriginal(),
            "code" => 3,
            "evcFirma" => $this->getFirmaDigitalCadena(),
            "evcCertificado" => $this->getCertificado(),
            "evcReferencia" => "Firma documento",
            "tsaName" => $this->getIdentificadorTSA()
        );
        //Reportamos Firma digital del documento
        $cliente->__setSoapHeaders($header);
        $resultado = $cliente->__soapCall("PwuPkcs1Extendido", array(
            $payload
        ));
        $response=$resultado->PwuPkcs1ExtendidoResult;
        if($response->Error==0){
         $iStatus=0;
         $strDescription="Satisfactorio";
         $iID=$response->Id;
         $strFecha=$response->Fecha;
         $strSerialNumber=$response->HexSerie;
         $strCommonName=$response->Cn;
         $arr = array ('state'=>$iStatus,'description'=>$strDescription,"transfer"=>$iID,"date"=>$strFecha,"commonName"=>$strCommonName,"hexSerie"=>$strSerialNumber);
         echo json_encode($arr); 
        }
        else{
            $arr = array ('state'=>$response->Error,'description'=>$response->Descripcion);
            echo json_encode($arr); 
        }

    }


    public function obtenerPDF($pdfBase64,$strSoapHeader="AuthSoapHd"){
        $cliente = new soapclient($this->getURL(), array(
            "trace" => 1
        ));
        $this->generateHeader();
        
        $header  = new SoapHeader($this->nameSpaceWS,$strSoapHeader, $this->soapHeader);
        $payload = array(
            "evcCadena" => $this->getCadenaOriginal(),
            "code" => 3,
            "evcFirma" => $this->getFirmaDigitalCadena(),
            "evcCertificado" => $this->getCertificado(),
            "evcReferencia" => "Firma documento ",
            "tsaName" => $this->getIdentificadorTSA()
        );
        //Reportamos Firma digital del documento
        $cliente->__setSoapHeaders($header);
        $resultado = $cliente->__soapCall("PwuPkcs1Extendido", array(
            $payload
        ));
        $response=$resultado->PwuPkcs1ExtendidoResult;
	
        if($response->Error==0){
         $iID=$response->Id;
         $strFecha=$response->Fecha;
         $strSerialNumber=$response->HexSerie;
         $strCommonName=$response->Cn;
         
         $cliente = new soapclient($this->urlFileUploadWS, array(
            "trace" => 1
        ));
         //Subimos archivo al ws
         $payload = array(
            "archivo" => $pdfBase64,
            "transferencias" =>  $iID,
            "nombreArchivo"=>$this->getFileName()
         );
         $resultado = $cliente->__soapCall("GetPDF", array(
            $payload
        ));
		
         $pdfResult=$resultado->GetPDFResult;
         if($pdfResult->status==0){

            $pdf=$pdfResult->pdf;
            $pkcs7=$pdfResult->pkcs7;
            
            
            //Escribir documento en el repositorio local del aplicativo
            
            file_put_contents("/var/www/html/sicor_extendido_80/public/temporales/evidencia.pdf", $pdf);
            file_put_contents("/var/www/html/sicor_extendido_80/public/temporales/firmas.p7s", $pkcs7);

            $arr = array ('state'=>$pdfResult->status,'description'=>$pdfResult->description,"transfer"=>$iID,"date"=>$strFecha,"commonName"=>$strCommonName,"hexSerie"=>$strSerialNumber);
            echo json_encode($arr); 

         }
         else{
            $arr = array ('state'=>$pdfResult->status,'description'=>$pdfResult->description);
            echo json_encode($arr); 
         }
        }
        else{
            $arr = array ('state'=>$response->Error,'description'=>$response->Descripcion);
            echo json_encode($arr); 
        }
    }
}
