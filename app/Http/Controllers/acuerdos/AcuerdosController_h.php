<?php

namespace App\Http\Controllers\acuerdos;


use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\export;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;

class AcuerdosController_h extends Controller
{


                                    //VISTAS


    public function consulta_acuerdos(Request $request){


        $arr_tipos_documento=catalogos::obtener_tipos_documentos($request);


        $tipos_documentos=Arr::sort($arr_tipos_documento, 'id_tipo_documento');

         $elementos=["entorno"=>$request->entorno,
                     "request"=>$request,
                     "sesion"=>Session::all(),
                     "menu_general"=>$request->menu_general,
                     "tipos_documentos"=>$tipos_documentos,
                    /*  "solicitudes"=>$solicitudes */

                     ];
         return view('acuerdos.consulta_acuerdos', $elementos);

       }


//DATOS

    public function obtener_acuerdos( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_acuerdos',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    // "modo"=>$request->modo,
                  //  "id_unidad" => Session::get("id_unidad_gestion"),
                     "id_unidad"=>$request->id_unidad,
                     "tipo_documento"=>$request->tipo_documento,
                     "folio_carpeta"=>$request->folio_carpeta,
                     "id_acuerdo"=>$request->id_acuerdo,
                     "id_carpeta_judicial"=>$request->id_carpeta_judicial,
                     "fecha_desde"=>$request->fecha_recepcion,
                     "fecha_hasta"=>$request->fecha_recepcionh,
                     "creacion"=>$request->fecha_creacion,
                     "creacion"=>$request->fecha_creacionh,
                     "estatus_firma"=>$request->estatus_firma,
                ], "paginacion"=>[
                    "registros_por_pagina"=>$request->registros_por_pagina,
                    "pagina"=>$request->pagina]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }



    public function exportar_busqueda_acuerdos(Request $request){
        $file = new export();
        //dd($this->obtener_solicitudes);
        $out = isset($request->out) ? $request->out : 'B64';

        $respuesta = $this->obtener_acuerdos($request);

        if($respuesta['status'] == 100){
            $data = $respuesta['response'];
        }else{
            //return $respuesta;
            $data = [[
                'folio_carpeta'=> 'Sin datos' ,
                'id_acuerdo'=> 'Sin datos' ,
                'id_tipo_documento'=> 'Sin datos' ,
                'nombre_juez'=> 'Sin datos' ,
                'estatus_firma'=> 'Sin datos' ,
                'fecha_firma'=> 'Sin datos' ,
                'comentarios_acuerdo'=> 'Sin datos' ,
                ]];
        }

        $header = [];
        if( isset($request->orden_columnas) && !empty($request->orden_columnas) ){
            foreach($request->orden_columnas as $c){
                $header[$c['campo']]=$c['titulo'];
            }
        }else{
            $header = [
                'folio_carpeta'=> 'Folio Carpeta Judicial' ,
                'id_acuerdo'=> 'ID Acuerdo' ,
                'id_tipo_documento'=> 'Tipo Documento' ,
                'nombre_juez'=> 'Nombre Juez' ,
                'estatus_firma'=> 'Estado de Firma' ,
                'fecha_firma'=> 'Fecha de Firmado' ,
                'comentarios_acuerdo'=> 'Comentarios' ,

            ];
        }

        $file->set_tema('sigj_penal');
        $file->set_report_title('Consulta de Acuerdos');
        $file->set_sheet_title('Hoja 1');
        $file->set_header($header );
        $file->set_data($data);
        $file->set_position_sheet('horizontal');
        return $file->get_file($request->extension, $out);
        //dd('llegaste');
    }


    public function ver_flujo_acuerdo(Request $request,$id_acuerdo){


        $response = $request
        ->clienteWS_penal
        ->request('GET', 'consultar_flujo_acuerdo/'.$id_acuerdo,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ],
            "json" => [
                "paginacion"=>[
                "registros_por_pagina"=>$request->registros_por_pagina,
                "pagina"=>$request->pagina]
                     ]
        ]);

        return $response = json_decode($response->getBody(),true);
      }



    public function obtener_unidades( Request $request ){


        $response = $request
        ->clienteWS_penal
        ->request('POST', 'ver_ugas',[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;
        return $response;
    }



    public function descargar_pdf_acuerdo(Request $request, $id_acuerdo, $id_unidad){
        // apartado agregado para que se pueda ver con usuario master.
   /*      $id_unidad=null;
        if(isset($request->id_unidad) && !$request->id_unidad!='-')
            $id_unidad =$request->id_unidad;
        else
            $id_unidad = Session::get('id_unidad_gestion'); */

            $tipo="pdf";

        $response = $request
        ->clienteWS_penal
        ->request('get', 'obtener_ultima_version_acuerdo/'.Session::get('usuario_id').'/'.$id_unidad.'/'.$id_acuerdo.'/'.$tipo,[
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json"
            ]
        ]);
                // return 'obtener_ultima_version_acuerdo/'.Session::get('usuario_id').'/'.Session::get('id_unidad_gestion').'/'.$id_acuerdo.'/'.$tipo;
        $response = json_decode($response->getBody(),true);
        if($response['status']==100){

            $url=$response['response'];

            $expl=explode('.',$url);

            $extension=end($expl);

            $url_local= base_path().'/storage/acuerdos/'.$id_acuerdo.'.'.$extension;

            $documento_pdf=$response['response'];

            copy($documento_pdf, $url_local);

            $respuesta=[
                "status"=>100,
                "response"=>"/acuerdos/$id_acuerdo.$extension",
                "ruta_local"=>$url_local,
                "extension"=>$extension,
            ];

            if($extension=='html' || $extension=='text'){
                $respuesta['contenido']=file_get_contents($url_local);
            }

            return $respuesta;
        }else{
            return $response;
        }

    }


    public function ver_flujo(Request $request,$id_solicitud){


      $response = $request
      ->clienteWS_penal
      ->request('GET', 'consultar_flujo_solicitud/'.$id_solicitud,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json" => [
              "paginacion"=>[
              "registros_por_pagina"=>$request->registros_por_pagina,
              "pagina"=>$request->pagina]
                   ]
      ]);

      return $response = json_decode($response->getBody(),true);
    }

    public function ver_log(Request $request,$id_solicitud){

      $response = $request
      ->clienteWS_penal
      ->request('GET', 'consultar_log/'.$id_solicitud,[
          "headers" => [
              "sesion-id" => $request->session()->get("sesion-id"),
              "cadena-sesion" => $request->session()->get("cadena-sesion"),
              "usuario-id" => $request->session()->get("usuario-id"),
              "Content-Type" => "application/json"
          ],
          "json" => [
              "datos" => [],
              "status" => 100
          ]
      ]);
      $response = json_decode($response->getBody(),true);
      $b64 = $response['response']['b64'];
      $route = base_path()."/public/archivo.log";
      if (file_exists($route)) {
        unlink($route);
       }
      $log = fopen($route,"a");
      fwrite(	$log, base64_decode($b64)."\n\n");
      fclose( $log );

      return 1;
    }


}
