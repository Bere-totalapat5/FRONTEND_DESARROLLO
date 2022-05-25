<?php

namespace App\Http\Controllers\juicio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class control_juicio extends Controller
{
    public function intf_nuevo( Request $request ){
    	return view('registro.RegistroNuevo',
                    ["entorno" => $request->entorno]);
    }
}
