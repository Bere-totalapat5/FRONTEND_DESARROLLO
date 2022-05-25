<?php
namespace App\Http\Controllers\dias_inhabiles;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use DateTime;
use DateInterval;

class DiasInhabilesController extends Controller
{
	public function dias_inhabiles(Request $request){
		$anios = []; 
		$anio_actual = (int) date('Y');
		$anio_tope = 2011;

		while ( $anio_actual >= $anio_tope) {
			$anios[]=$anio_actual;
			$anio_actual--;
		}

        $elementos=["entorno"=>$request->entorno,
                     "request"=>$request,
                     "sesion"=>Session::all(),
                     "menu_general"=>$request->menu_general,
                     "anios" => $anios,

                     ];
		
        return view('dias_inhabiles.dias_inhabiles',$elementos);
    }

	public function consultar_dias_inhabiles(Request $request){

        $response = $request
        ->clienteWS_penal
        ->request('get', 'consultar_dias',[
            "form_params" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ],
            "json"=>[
                "datos"=>[
                    "anios"=>$request->filtro['anio']
                ]
            ]
        ]);

        $respuesta = json_decode($response->getBody(), true);

        return $respuesta;
    }
 
    public function nuevo_dia_inhabil(Request $request){

        if( $request->datos['dia'] != '-'){
            $fecha_inicio = $request->datos['dia'];
            $fecha_fin = $request->datos['dia'];
        }else{
            $fecha_inicio = $request->datos['desde'];
            $fecha_fin = $request->datos['hasta'];
        }
    	
        $response = $request
        ->clienteWS_penal
        ->request('post', 'insertar_dias/'.Session::get('usuario_id'),[
            "form_params" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ],
            "json"=>[
                "datos"=>[
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin
                ]
            ]
        ]);

        $respuesta = json_decode($response->getBody(), true);

        return $respuesta;
    }

    public function estatus_dia_inhabil(Request $request){
        //dd($request->datos);
        $response = $request
        ->clienteWS_penal
        ->request('PUT', 'modificar_dias/'.Session::get('usuario_id'), [
            "form_params" => [
            ],
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "autorizacion" => "minutmanQAEtHReI"
            ],
            "json" => [
                'datos' => [
                    'dias' =>[$request->datos]
                ]
            ]
        ]);

        $respuesta = json_decode($response->getBody(), true);

        return $respuesta;
    }

}