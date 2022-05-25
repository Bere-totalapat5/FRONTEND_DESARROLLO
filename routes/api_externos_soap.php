<?php
use App\Http\Controllers\clases\adip;
use App\Http\Controllers\clases\solicitudes;
use App\Http\Controllers\clases\promociones;
use Spatie\ArrayToXml\ArrayToXml;
use GuzzleHttp\Client;


// servicios para fiscalía
Route::get('ws_fiscalia', function(){
  
  $server = new \nusoap_server();
  
  function registrarSolicitudInicial($Solicitud) {
    $result = str_replace(["<root>","</root>",'<?xml version="1.0"?>'],"",ArrayToXml::convert($Solicitud, ''));
    
    $solicitud=solicitudes::enviar_solicitud_xml('<Solicitud>'.$result.'</Solicitud>');
    
    return str_replace(['<?xml version="1.0" encoding="ISO-8859-1"?>','<![CDATA[','<acuse>','</acuse>'],'',$solicitud);
    
  }

  $server->configureWSDL("solicitudXML", false, url('api'));
  $server->wsdl->schemaTargetNamespace = "urn:solicitudXMLwsdl";
  $server->decode_utf8 = true;
  $server->soap_defencoding = "UTF-8";

  $server->register(
      'registrarSolicitudInicial',
      array('Solicitud' => 'xsd:string'),
      array('acuse' => 'xsd:string'),
      "solicitudXMLwsdl",
      "solicitudXMLwsdl#mensaje",
      'rpc',
      'encoded',
      'solicitud xml'
  );


  function registrarSolicitudPromocion($Solicitud) {
    $result = str_replace(["<root>","</root>",'<?xml version="1.0"?>'],"",ArrayToXml::convert($Solicitud, ''));
    
    $promocion=promociones::enviar_promocion_xml('<Solicitud>'.$result.'</Solicitud>');
    
    return str_replace(['<?xml version="1.0" encoding="ISO-8859-1"?>','<![CDATA[','<acuse>','</acuse>'],'',$promocion);
    
  }

  $server->register(
    'registrarSolicitudPromocion',
    array('Solicitud' => 'xsd:string'),
    array('acuse' => 'xsd:string'),
    "promocionXMLwsdl",
    "promocionXMLwsdl#mensaje",
    'rpc',
    'encoded',
    'promocion xml'
);

  function obtenerAudienciaSolicitud( $ctrlSolicitud, $idSolicitud ) {

    $datos = [
      "ctrlSolicitud" => $ctrlSolicitud,
      "idSolicitud" => $idSolicitud
    ];

    $solicitud = solicitudes::obtener_audiencia_solicitud( $datos );
    
    return str_replace(['<?xml version="1.0" encoding="ISO-8859-1"?>','<![CDATA[','<asignacionAudiencia>','</asignacionAudiencia>'],'',$solicitud);
    
  }
  $server->register(
      'obtenerAudienciaSolicitud',
      array('ctrlSolicitud' => 'xsd:string','idSolicitud' => 'xsd:string'),
      array('asignacionAudiencia' => 'xsd:string'),
      "asignacionAudienciaXMLwsdl",
      "asignacionAudienciaXMLwsdl#mensaje",
      'rpc',
      'encoded',
      'asignacionAudiencia xml'
  );

  function notificarTotalAudiencias( $fechaInicio, $fechaFin ) {

    $datos = [
      "fechaInicio" => $fechaInicio,
      "fechaFin" => $fechaFin
    ];

    $audiencias = solicitudes::notificar_total_audiencias( $datos );
    
    return str_replace(['<?xml version="1.0" encoding="ISO-8859-1"?>','<![CDATA[','<informacionAcuse>','</informacionAcuse>'],'',$audiencias);
    
  }
  $server->register(
      'notificarTotalAudiencias',
      array('fechaInicio' => 'xsd:string','fechaFin' => 'xsd:string'),
      array('datosResultado' => 'xsd:string'),
      "datosResultadowsdl",
      "datosResultadowsdl#mensaje",
      'rpc',
      'encoded',
      'datosResultado xml'
  );

  function obtenerFolioAcuseSolicitud( $ctrlSolicitud, $idSolicitud ) {

    $datos = [
      "ctrlSolicitud" => $ctrlSolicitud,
      "idSolicitud" => $idSolicitud
    ];

    $folio = solicitudes::obtener_folio_acuse_solicitud( $datos );
    
    return str_replace(['<?xml version="1.0" encoding="ISO-8859-1"?>','<![CDATA[','<informacionAcuse>','</informacionAcuse>'],'',$folio);
    
  }
  $server->register(
      'obtenerFolioAcuseSolicitud',
      array('ctrlSolicitud' => 'xsd:string','idSolicitud' => 'xsd:string'),
      array('informacionAcuse' => 'xsd:string'),
      "informacionAcusewsdl",
      "informacionAcusewsdl#mensaje",
      'rpc',
      'encoded',
      'informacionAcuse xml'
  );

  function consultaCarpetasJudiciales( $carpetaInvestigacion ) {

    $datos = [
      "carpetaInvestigacion"=>$carpetaInvestigacion
    ];

    $carpeta = solicitudes::obtener_carpetas_judiciales( $datos );
    
    return str_replace(['<?xml version="1.0" encoding="ISO-8859-1"?>','<![CDATA[','<respuesta>','</respuesta>'],'',$carpeta);
    
  }
  $server->register(
      'consultaCarpetasJudiciales',
      array('carpetaInvestigacion' => 'xsd:string'),
      array('respuesta' => 'xsd:string'),
      "respuestawsdl",
      "respuestawsdl#mensaje",
      'rpc',
      'encoded',
      'respuesta xml'
  );

  $server->service(file_get_contents("php://input"));  

});


////////////////////////////////////////////////////////////////////////

Route::get('ws_enviar_promocion_xml', function(){
  
  $server = new \nusoap_server();
  
  function enviar_promocion_xml($Solicitud) {
    $result = str_replace(["<root>","</root>",'<?xml version="1.0"?>'],"",ArrayToXml::convert($Solicitud, ''));
    
    $promocion=promociones::enviar_promocion_xml('<Solicitud>'.$result.'</Solicitud>');
    
    return str_replace(['<?xml version="1.0" encoding="ISO-8859-1"?>','<![CDATA[','<acuse>','</acuse>'],'',$promocion);
    
  }

  $server->configureWSDL("promocionXML","urn:promocionXMLwsdl");
  $server->wsdl->schemaTargetNamespace = "urn:promocionXMLwsdl";
  $server->decode_utf8 = true;
  $server->soap_defencoding = "UTF-8";

  $server->register(
      'enviar_promocion_xml',
      array('Solicitud' => 'xsd:string'),
      array('acuse' => 'xsd:string'),
      "promocionXMLwsdl",
      "promocionXMLwsdl#mensaje",
      'rpc',
      'encoded',
      'promocion xml'
  );

  $server->service(file_get_contents("php://input"));
  
});

Route::get('ws_obtener_audiencia_solicitud', function(){
  
  $server = new \nusoap_server();
  
  function obtener_audiencia_solicitud( $ctrlSolicitud, $idSolicitud ) {

    $datos = [
      "ctrlSolicitud" => $ctrlSolicitud,
      "idSolicitud" => $idSolicitud
    ];

    $solicitud = solicitudes::obtener_audiencia_solicitud( $datos );
    
    return str_replace(['<?xml version="1.0" encoding="ISO-8859-1"?>','<![CDATA[','<asignacionAudiencia>','</asignacionAudiencia>'],'',$solicitud);
    
  }

  $server->configureWSDL("asignacionAudienciaXML","urn:asignacionAudienciaXMLwsdl");
  $server->wsdl->schemaTargetNamespace = "urn:asignacionAudienciaXMLwsdl";
  $server->decode_utf8 = true;
  $server->soap_defencoding = "UTF-8";

  $server->register(
      'obtener_audiencia_solicitud',
      array('ctrlSolicitud' => 'xsd:string','idSolicitud' => 'xsd:string'),
      array('asignacionAudiencia' => 'xsd:string'),
      "asignacionAudienciaXMLwsdl",
      "asignacionAudienciaXMLwsdl#mensaje",
      'rpc',
      'encoded',
      'asignacionAudiencia xml'
  );

  $server->service(file_get_contents("php://input"));
  
});


Route::post('ws_documento_adip', function(){

  $server = new \nusoap_server();
        
  function obtener_reportes_adip($fecha_inicio,$fecha_final,$tipo_archivo) {
    
    $documento=adip::consulta_reportes_adip($fecha_inicio,$fecha_final,$tipo_archivo);

    return $documento;
    
  }

  $server->configureWSDL("ReportesADIP","urn:ReportesADIPwsdl");
  $server->wsdl->schemaTargetNamespace = "urn:ReportesADIPwsdl";
  $server->decode_utf8 = true;
  $server->soap_defencoding = "UTF-8";

  $server->register(
      'obtener_reportes_adip',
      array('fecha_inicio' => 'xsd:string','fecha_final' => 'xsd:string','tipo_archivo' => 'xsd:string'),
      array('status' => 'xsd:string','response' => 'xsd:string','message' => 'xsd:string'),
      "ReportesADIPwsdl",
      "ReportesADIPwsdl#mensaje",
      'rpc',
      'encoded',
      'reportes adip'
  );

  $server->service(file_get_contents("php://input"));

});