<?php

namespace App\Http\Controllers\expediente_buscar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class control_expediente_buscar extends Controller
{
    public function inicio( Request $request )
    {

        return view(    "expediente_buscar.expediente_buscar",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general
                        ]
                    );
    }
}