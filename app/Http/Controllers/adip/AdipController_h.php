<?php

namespace App\Http\Controllers\adip;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class AdipController_h extends Controller
{

    //VISTAS
    public function consulta_adip(Request $request){
         $elementos=["entorno"=>$request->entorno,
                     "request"=>$request,
                     "sesion"=>Session::all(),
                     "menu_general"=>$request->menu_general,
                    /*  "solicitudes"=>$solicitudes */

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
                     "clave"=>$request->clave
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

    public function obtener_reportes_pdf( Request $request,$id_reporte,$nombre_reporte,$tipo ){

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

    public function obtener_reportes_xml( Request $request,$id_reporte,$nombre_reporte,$tipo ){
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
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        
        // return $response;
        
        if($response['status'] == 0){
            return $response;
        }else{

            $files = glob('/san/www/html/front_penal_desarrollo/public/xml_adip/*'); //obtenemos todos los nombres de los ficheros
            foreach($files as $file){
                if(is_file($file))
                unlink($file); //elimino ficheros
            }
            $url_local='/san/www/html/front_penal_desarrollo/public/xml_adip/xml_reportes_'.$response['nombre'].'.xlsx';


            $documento_xlsx=$response['response'];
            copy($documento_xlsx, $url_local);

            return [
                "status"=>100,
                "response"=>"http://172.19.228.38:8083/xml_adip/xml_reportes_".$response['nombre'].".xlsx",
            ];
            // return $response;
        }
        
    }

}
