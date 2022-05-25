<?php

namespace App\Http\Controllers\expediente_buscar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class control_expediente_buscar extends Controller
{
    public function inicio( Request $request ){

        
        return view(     "expediente_buscar.expediente_buscar",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general
                        ]
                    );
    }

    public function buscar( Request $request )
    {
        $response = $request
                        ->clienteWS
                        ->request('get', 'buscarArchivo',[
                            "form_params" => [
                                "toca" => $request->toca,
                                "anio_toca" => $request->anio_toca,
                                "asunto_toca" => $request->asunto_toca,
                                "por_turnar" => $request->por_turnar,
                                "expediente" => $request->expediente,
                                "expediente_anio" => $request->expediente_anio,
                                "involucrado" => $request->involucrado,
                                "registrado_desde" => $request->registrado_desde,
                                "registrado_hasta" => $request->registrado_hasta
                            ],
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true) ;
        
        return $responseBody;
    }
}