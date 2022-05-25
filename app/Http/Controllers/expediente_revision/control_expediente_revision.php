<?php

namespace App\Http\Controllers\expediente_revision;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class control_expediente_revision extends Controller
{
    public function inicio( Request $request ){

        return view(    "expediente_revision.expediente_revision",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general
                        ]
                    );
    }
}
