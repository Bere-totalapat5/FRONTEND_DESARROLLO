<?php

namespace App\Http\Controllers\billetes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class BilletesController extends Controller
{
    public function billetes( Request $request ) {

        $elementos=["entorno"=>$request->entorno,
                    "request"=>$request,
                    "sesion"=>Session::all(),
                    "menu_general"=>$request->menu_general,
                  ];
        return view('billetes.billetes', $elementos);
        // return view('billetes.billetes');
    }
}
