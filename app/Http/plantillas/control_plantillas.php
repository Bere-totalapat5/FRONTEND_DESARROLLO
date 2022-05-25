<?php

namespace App\Http\Controllers\plantillas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class control_plantillas extends Controller
{
    public function action_leyenda(Request $request)
    {
		$response = $request
                        ->clienteWS
                        ->request('get', 'obtenerLeyenda',[
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id,
                                "autorizacion" => "minutmanQAEtHReI"
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true);
        
        return $responseBody;
    }
    
    public function action_plantilla(Request $request)
    {
		$response = $request
                        ->clienteWS
                        ->request('get', 'obtenerPlantilla',[
                            "headers" => [
                                "sesion-id" => $request->sesion_id,
                                "cadena-sesion" => $request->cadena_sesion,
                                "usuario-id" => $request->usuario_id,
                                "autorizacion" => "minutmanQAEtHReI"
                            ]
                        ]);

        $responseBody = json_decode($response->getBody(),true);

        return $responseBody;
	}
}