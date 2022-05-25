<?php

namespace App\Http\Controllers\logout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout( Request $request ){
        /*
        print($request->session()->get("sesion_id").'<br>');
        print($request->session()->get("cadena-sesion").'<br>');
        print($request->session()->get("usuario_id").'<br>');
        */
 
        $response = $request
                    ->clienteWS_penal
                    ->request('DELETE', 'logout',[
                        "query" => [ 
                        ],
                        "headers" => [
                            "sesion-id" => $request->session()->get("sesion-id"),
                            "cadena-sesion" => $request->session()->get("cadena-sesion"),
                            "usuario-id" => $request->session()->get("usuario-id")
                        ]
                    ]);
        $response = json_decode($response->getBody(),true) ;
        //dd($response);
        
        if ($request->session()->get("sesion_tipo")=="soporte"){
            //  print_r($sesion);
            $request->session()->flush();
            return redirect('/?soporte=1');
        
        }
        else{
            $request->session()->flush();
            return redirect('/');
        }
    }
}
