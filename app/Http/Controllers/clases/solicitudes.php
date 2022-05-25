<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\clases\entorno;

class solicitudes{

  public static function enviar_solicitud_xml( $body, $sistema = '' ){

    if( !entorno::validacion() ) {
        return true;
    } else {
      $entorno_privado = entorno::obtener_valores_privados(); 
      $base_uri= $entorno_privado['ws_uri_backend']['uri_penal'];
    }
    
    
    // $base_uri="http://172.19.223.68:8081/sigjp/";
    // return $base_uri;

    $client= new Client;
    $response = $client
        ->request('post', $base_uri.'registrar_solicitud'.$sistema,[
            "headers" => [
                "Content-Type" => "text/xml; charset=UTF8"
            ],
            "body"=>$body
        ]);

        return $response->getBody();

  }
  public static function enviar_promocion_xml( $body, $sistema = '' ){

    if( !entorno::validacion() ) {
      return true;
    } else {
      $entorno_privado = entorno::obtener_valores_privados(); 
      $base_uri= $entorno_privado['ws_uri_backend']['uri_penal'];
    }
    // return "hola";
    // $base_uri="http://172.19.223.68:8081/sigjp/";
    $client= new Client;
    $response = $client
        ->request('post', $base_uri.'registrar_promocion'.$sistema,[
            "headers" => [
                "Content-Type" => "text/xml; charset=UTF8"
            ],
            "body"=>$body
        ]);

        return $response->getBody();

  }

  public static function obtener_audiencia_solicitud( $datos ) {

    if( !entorno::validacion() ) {
        return true;
    } else {
      $entorno_privado = entorno::obtener_valores_privados(); 
      $base_uri= $entorno_privado['ws_uri_backend']['uri_penal'];
    }
    
    $client= new Client;
    $response = $client
        ->request('get', $base_uri.'ws_obtener_audiencia_solicitud',[
          "headers" => [
              "Content-Type" => "application/json"
          ],
          'json'=>[
            "datos" => $datos
          ]
        ]);

    return $response->getBody();
  }

  public static function notificar_total_audiencias( $datos ) {

    if( !entorno::validacion() ) {
      return true;
    } else {
      $entorno_privado = entorno::obtener_valores_privados(); 
      $base_uri= $entorno_privado['ws_uri_backend']['uri_penal'];
    }
    
    $client= new Client;
    $response = $client
        ->request('get', $base_uri.'ws_notificar_total_audiencias/',[
          "headers" => [
              "Content-Type" => "application/json"
          ],
          'json'=>[
            "datos" => $datos
          ]
        ]);

    return $response->getBody();
  }

  public static function obtener_folio_acuse_solicitud( $datos ) {

    if( !entorno::validacion() ) {
      return true;
    } else {
      $entorno_privado = entorno::obtener_valores_privados(); 
      $base_uri= $entorno_privado['ws_uri_backend']['uri_penal'];
    }
 
    $client= new Client;
    $response = $client
        ->request('get', $base_uri.'ws_obtener_folio_acuse_solicitud',[
          "headers" => [
              "Content-Type" => "application/json"
          ],
          'json'=>[
            "datos" => $datos
          ]
        ]);

    return $response->getBody();
  }

  public static function obtener_carpetas_judiciales( $datos ) {

    if( !entorno::validacion() ) {
      return true;
    } else {
      $entorno_privado = entorno::obtener_valores_privados(); 
      $base_uri= $entorno_privado['ws_uri_backend']['uri_penal'];
    }
    
    $client= new Client;
    $response = $client
        ->request('get', $base_uri.'ws_consulta_carpetas_judiciales/',[
          "headers" => [
              "Content-Type" => "application/json"
          ],
          'json'=>[
            "datos" => $datos
          ]
        ]);

    return $response->getBody();
  }

}

?>
