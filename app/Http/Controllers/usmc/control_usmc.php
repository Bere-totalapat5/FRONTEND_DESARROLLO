<?php

namespace App\Http\Controllers\usmc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use App;
use DateTime;

use App\Http\Controllers\clases\catalogos;

class control_usmc extends Controller
{
    public function consultar_oficios_usmc(Request $request){
        //$unidades = catalogos::obtener_ugas_incidencias_salas($request)['response'];
        $unidades = catalogos::obtener_ugas($request)['response'];

        $parametros=[
            "request"=>$request,
            "sesion"=>Session::all(),
            "menu_general"=>$request->menu_general,
            "entorno"=>$request->entorno,
            'unidades'=>$unidades
        ];

        return view('usmc.consulta_usmc',$parametros);
    }
    
}



