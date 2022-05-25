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