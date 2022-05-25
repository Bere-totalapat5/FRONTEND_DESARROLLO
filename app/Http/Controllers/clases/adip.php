<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class adip{

  public static function consulta_reportes_adip($fecha_inicio,$fecha_final,$tipo_archivo ){
    $base_uri="http://172.19.223.68:8081/sigjp/";

    $exp_fi=explode('-',$fecha_inicio);

    if(strlen($fecha_inicio) != 10 || !checkdate((int)$exp_fi[1],(int)$exp_fi[2],(int)$exp_fi[0]))
      return ["status"=>0,"message"=>"Fecha de incio inválida"];
    
    $exp_ff=explode('-',$fecha_final);

    if(strlen($fecha_final) != 10 || !checkdate((int)$exp_ff[1],(int)$exp_ff[2],(int)$exp_ff[0]))
      return ["status"=>0,"message"=>"Fecha final inválida"];

    $datos=[
      "fecha_inicio"=>$fecha_inicio,
      "fecha_final"=>$fecha_final,
    ];

    $client= new Client;
    $response = $client
    ->request('get', $base_uri.'consulta_reportes_adip',[
        "headers" => [            
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>$datos,
        ]
    ]);

    $response = json_decode($response->getBody(),true) ;

    if( $response['status'] == 100 ){

      $id_reporte= $response['response'][0]['id_reporte'];
      
      $extension=$tipo_archivo==null?'xml':$tipo_archivo;
      $client= new Client;
      $response_doc = $client
      ->request('get', $base_uri.'obtener_archivo_reporte_adip/'.$id_reporte.'/'.$extension,[
          "headers" => [
              
              "Content-Type" => "application/json"
          ]
      ]);
      $response_doc = json_decode($response_doc->getBody(),true) ;
  
      if($response['status']==100){
          $url=$response_doc['response'];
          $response_doc['response']="http://172.19.228.38:8083".archivos::obtener_archivo_adip( $url, $extension );
  
          return $response_doc;
      }else{
        return $response_doc;
      }
    }else{
      return $response;
    }
  }
  
  
}