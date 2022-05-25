<?php

namespace App\Http\Controllers\adip;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class AdipController_cc extends Controller
{
    //VISTAS
    public function consulta_adip(Request $request){
      $arr_unidades=catalogos::obtener_ugas($request,3)['response'];
      $unidades=Arr::sort($arr_unidades, 'id_unidad_gestion');

      $elementos=["entorno"=>$request->entorno,
                  "request"=>$request,
                  "sesion"=>Session::all(),
                  "menu_general"=>$request->menu_general,
                  "unidades" => $unidades,
                  ];

      return view('adip.consulta_adip', $elementos);
    }

    //DATOS
    public function obtener_reportes_adip( Request $request ){

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consulta_reportes_adip',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                     "fecha_inicio"=>$request->fecha_inicio,
                     "fecha_final"=>$request->fecha_final,
                     "bandera_reporte"=>$request->bandera_reporte,
                     "clave"=>$request->clave,
                     "searchIdReporte"=>$request->searchIdReporte
                ],
                "paginacion"=>[
                  "registros_por_pagina"=>$request->registros_por_pagina,
                  "pagina"=>$request->pagina
              ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }

    public function obtener_reportes_excel( Request $request,$id_reporte,$nombre_reporte,$tipo ){
        $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

        $response = $request
        ->clienteWS_penal
        ->request('GET', 'obtener_archivo_reporte_adip/'.$id_reporte.'/'.$nombre_reporte.'/'.$tipo,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[]
            ]
        ]);
        
        $response = json_decode($response->getBody(),true);


        if(!isset($response['status'])){

          $files = glob($ruta_base_local.'public/excel_adip/*'); //obtenemos todos los nombres de los ficheros
          foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino ficheros
          }
          
          $url_local=$ruta_base_local.'public/excel_adip/'.$id_reporte.'.xml';

          $documento_xml=$response['response'];
          copy($documento_xml, $url_local);
          return [
              "status"=>100,
              "response"=>"/excel_adip/$id_reporte.xml"
          ];

        }else{
          return $response;
        }
    }

    public function obtener_reportes_zip( Request $request,$id_reporte,$nombre_reporte,$tipo ){
      $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

      $response = $request
      ->clienteWS_penal
      ->request('GET', 'obtener_archivo_reporte_adip/'.$id_reporte.'/'.$nombre_reporte.'/'.$tipo,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[]
          ]
      ]);
      
      $response = json_decode($response->getBody(),true);


      if(!isset($response['status'])){

        $files = glob($ruta_base_local.'public/excel_adip/*'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
        }
        
        $url_local=$ruta_base_local.'public/excel_adip/'.$id_reporte.'.xml';

        $documento_xml=$response['response'];
        copy($documento_xml, $url_local);
        return [
            "status"=>100,
            "response"=>"/excel_adip/$id_reporte.xml"
        ];

      }else{
        return $response;
      }
    }

    public function obtener_reportes_pdf( Request $request,$id_reporte,$nombre_reporte,$tipo ){
      $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

      $response = $request
      ->clienteWS_penal
      ->request('GET', 'obtener_archivo_reporte_adip/'.$id_reporte.'/'.$nombre_reporte.'/'.$tipo,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[]
          ]
      ]);
      
      $response = json_decode($response->getBody(),true);
      

      if(!isset($response['status'])){

        $files = glob($ruta_base_local.'public/excel_adip/*'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
        }
        
        $url_local=$ruta_base_local.'public/excel_adip/'.$id_reporte.'.xml';

        $documento_xml=$response['response'];
        copy($documento_xml, $url_local);
        return [
            "status"=>100,
            "response"=>"/excel_adip/$id_reporte.xml"
        ];

      }else{
        return $response;
      }
    }

    public function obtener_reportes_xml( Request $request,$id_reporte,$nombre_reporte,$tipo ){
      $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];
      
      $response = $request
        ->clienteWS_penal
        ->request('GET', 'obtener_archivo_reporte_adip/'.$id_reporte.'/'.$nombre_reporte.'/'.$tipo,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[]
            ]
        ]);
        $response = json_decode($response->getBody(),true);

        if (!isset($response['status'])) {

            $nombre_doc = rand().'-'.$id_reporte.'-'.rand();

            $url_local = base_path().'/public/pdf_promocion/' . $nombre_doc . '.xml';

            $documento_pdf = $response['response'];
            copy($documento_pdf, $url_local);

            return [
                "status" => 100,
                "response" => "/pdf_promocion/$id_reporte.xml",
                "ruta_local"=>$url_local,
                "extension"=>'xml',
            ];
        }else{
            return $response;
        }
    }

    public function consulta_reportes_adip_xml(Request $request){
      $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

      if(isset($request->tipo_archivo) && $request->tipo_archivo != ''){
        $tipo = $request->tipo_archivo;
      }else{
        $tipo = 'xml';
      }

      $response = $request
      ->clienteWS_penal
      ->request('GET', 'consulta_reportes_adip_xml',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos"=>[
              "tipo_archivo"=>$tipo
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      
      
      // return $response;
      
      if($response['status'] == 0){
          return $response;
      }else{

          $files = glob($ruta_base_local.'public/xml_adip/*'); //obtenemos todos los nombres de los ficheros
          foreach($files as $file){
              if(is_file($file))
              unlink($file); //elimino ficheros
          }
          $url_local=$ruta_base_local.'public/xml_adip/xml_reportes_'.$response['nombre'].'.'.$tipo;


          $documento_xlsx=$response['response'];
          copy($documento_xlsx, $url_local);

          return [
              "status"=>100,
              "response"=>"http://".$_SERVER['HTTP_HOST']."/xml_adip/xml_reportes_".$response['nombre'].".".$tipo,
          ];
          // return $response;
      }
      
    }

    public function consulta_reportes_estadistico(Request $request){
      $ruta_base_local = $request->entorno_privado["servidor_local"]["uri_local_proyecto"];

      if(isset($request->tipo_archivo) && $request->tipo_archivo != ''){
        $tipo = $request->tipo_archivo;
      }else{
        $tipo = 'xlsx';
      }

      $response = $request
      ->clienteWS_penal
      ->request('GET', 'consulta_reportes_estadistico',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos"=>[
              "tipo_archivo"=>$tipo
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      
      // return $response;
      
      if($response['status'] == 0){
          return $response;
      }else{

          $files = glob($ruta_base_local.'public/estadistica/*'); //obtenemos todos los nombres de los ficheros
          foreach($files as $file){
              if(is_file($file))
              unlink($file); //elimino ficheros
          }
          $url_local=$ruta_base_local.'public/estadistica/'.$response['nombre'].'.'.$tipo;

          $documento_xlsx=$response['response'];
          copy($documento_xlsx, $url_local);

          return [
              "status"=>100,
              "response"=>"http://".$_SERVER['HTTP_HOST']."/estadistica/".$response['nombre'].".".$tipo,
          ];
          // return $response;
      }
      
    }

    ################## EDICION ADIP ##############

    // obtiene los datos del servidor 
    public function obtener_csv(Request $request){
      $tipo = 'csv';
      $response = $request
      ->clienteWS_penal
      ->request('GET', 'obtener_csv/'.$request->id_reporte.'/'.$tipo,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[]
          ]
      ]);
      $response = json_decode($response->getBody(),true); //documento

      $version = $response['version'];
      // $version = 1;
      $id_reporte = $request->id_reporte;
      $ruta_base_local = base_path().'/public/adip_csv/';
      
      if ($response['status'] == 0) {
        return [
            "status" => 200,
            "response" => "No contiene archivo CSV"
        ];
      }else{
          $documento_pdf = $response['response'];
          $data = $this->csvToJson($documento_pdf);
          $version = $response['version'];
        
          if(count($data[0]) <= 1){
            return [
              "status" => 200,
              "response" => "No contiene datos el documento"
            ];
          }

          // array con claves
          $data_key_c = [];
          for($i = 0; $i < count($data)-1; $i++){
                array_push($data_key_c, array(
                    "no"=>$i,
                    "CJ"=>$data[$i][0], 
                    "CI"=>$data[$i][1],
                    "nombre"=>$data[$i][2], 
                    "apellidoPaterno"=>$data[$i][3],  
                    "apellidoMaterno"=>$data[$i][4], 
                    "fechaNacimiento"=>$data[$i][5],
                    "domicilio"=>$data[$i][6],  
                    "genero"=>$data[$i][7],  
                    "edad"=>$data[$i][8], 
                    "ingreso"=>$data[$i][9],  
                    "estatus_imputado"=>$data[$i][10], 
                    "estatus_reincidencia"=>$data[$i][11],  
                    "fecha_vinculacion_proceso"=>$data[$i][12], 
                    "fecha_sentencia"=>$data[$i][13], 
                    "fecha_apelacion"=>$data[$i][14], 
                    "estatus_multa_posterior_apelacion"=>$data[$i][15], 
                    "pena_pecunaria_posterior_apelacion"=>$data[$i][16],
                    "fecha_amparo"=>$data[$i][17], 
                    "fecha_sobreseimiento"=>$data[$i][18],  
                    "tipo_juicio"=>$data[$i][19],
                    "tiempo_sentencia"=>$data[$i][20], 
                    "estatus_multa_posterior_sentencia"=>$data[$i][21], 
                    "pena_pecunaria_sentencia"=>$data[$i][22],  
                    "estatus_carpeta"=>$data[$i][23],
                    "id_persona"=>$data[$i][24]    
                ));
          }
          

          $response["data"] =  $data;
          $res = [  "status"=>100,
                    "response"=>$data_key_c, 
                    "version"=>$version, 
                    "nombre_documento"=>$id_reporte.'_'.$version
                  ];

          return $res;
          
      }
    
    }
    //guarda datos en el local
    public function guardar_json_local(Request $request){
      $data = $request->response;
      $nombre = $request->nombre;
      $version = $request->version;
      $status = $request->status;

      $ruta_base_local = base_path().'/public/adip_csv/';

      if($status == 100){
        $fp = fopen($ruta_base_local.$nombre.'.json', 'a');
          foreach($data as $dato){
            fwrite($fp,json_encode($dato));
          }
        fclose($fp);

        return ["status" => 100, "message" => "Los cambios han sido guardados"];
        
      }else{
        return ["status" => 0, "message" => "Error al guardar los datos"];
      }
    }
    // elimina los archivos temporales
    public function eliminar_json_temporal(Request $request){
      $ruta_base_local = base_path().'/public/adip_csv/';
      $nombre_archivo = $request->nombre_archivo;
      $file = $ruta_base_local.$nombre_archivo.'.json';

      if(is_file($file)){
        unlink($file); 
        return ["status" => 100, "message" => "Archivo temporal eliminado"];
      }else{
        return ["status" => 100, "message" => "No existe el archivo: ".$nombre_archivo.".json"];
      }
    }
    //Convierte a csv
    public function csvToJson($fname) {

      $content =  file_get_contents($fname);  
      $rows = explode("\n",$content);
      $s = array();   

      foreach($rows as $key => $row) {
        $s[] = str_getcsv($row);
      }

      return $s; 
    }
    //cambiar estado en linea
    public function cambiar_estado_online(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'estado_online',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[
                   "id_reporte"=>$request->id_reporte,
                   "estado"=>$request->estado
              ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }    
    //revisar estado en linea
    public function revisar_estado_online(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'revisar_estado',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[
                   "bandera_reporte"=>$request->adip,
              ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }
    //guardar version json
    public function csv_version_nueva(Request $request){
      $fecha_modificacion = date('Y-m-d H:i:s');

      $response = $request
      ->clienteWS_penal
      ->request('POST', 'csv_version_nueva',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[
                   "new_csv"=>$request->data,
                   "nombre"=>$request->nombre,
                   "version"=>$request->version,
                   "id_unidad"=>$request->id_unidad,
                   "id_session"=> $request->session()->get("usuario-id")
              ],
              "historia_version"=>[
                  "version"=>$request->version,
                  "fecha_m"=>$fecha_modificacion,
                  "id_usuario"=>$request->session()->get("usuario-id")
              ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;


      return $response;
    }
    //Dias de edicion
    public function dias_edicion(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'dias_edicion',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos"=>[
              "unidad"=>$request->unidad
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }
    //Ver info Adip
    public function ver_infoAdip(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'ver_infoAdip',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos"=>[
              "id_reporte"=>$request->id_reporte
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }
    // obtener los versionados en csv
    public function obtener_reportes_csv( Request $request,$id_reporte,$version,$tipo ){
      $response = $request
      ->clienteWS_penal
      ->request('GET', 'obtener_archivo_reporte_adip_csv/'.$id_reporte.'/'.$version.'/'.$tipo,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[]
          ]
      ]);

      $response = json_decode($response->getBody(),true);

      if(!isset($response['status'])){

        $files = glob('/san/www/html/front_penal_desarrollo/public/excel_adip/*'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
          if(is_file($file))
          unlink($file); //elimino ficheros
        }
        
        $url_local='/san/www/html/front_penal_desarrollo/public/excel_adip/'.$id_reporte.'.xml';


        $documento_xml=$response['response'];
        copy($documento_xml, $url_local);

        return [
          "status"=>100,
          "response"=>"/excel_adip/$id_reporte.xml"
        ];
      }else{
          return $response;
      }
    }

    public function cambiarHorarioAdip(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'cambiarHorarioAdip',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos"=>[
              "id_unidad"=>$request->id_unidad,
              "hora"=>$request->hora
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }
    
    public function obtener_audiencias(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'obtener_audiencias',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
              "datos"=>[
                   "folio_carpeta"=>$request->folio_carpeta,
              ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }

    public function fusionarReporte(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'fusionarReporteCompleto',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos"=>[
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }

    public function generarReporteMaster(Request $request){
      $response = $request
      ->clienteWS_penal
      ->request('POST', 'generarReporteMaster',[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json"=>[
            "datos"=>[
            ]
          ]
      ]);
      $response = json_decode($response->getBody(),true) ;
      return $response;
    }

}
