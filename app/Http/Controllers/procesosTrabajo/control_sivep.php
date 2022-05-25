<?php

namespace App\Http\Controllers\procesosTrabajo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\sivep;
use DB;

class control_sivep extends Controller
{
    public function inicio( Request $request ){

         
        $lista=sivep::bandeja_sivep($request, 'espera');
        //dd($lista);
        return view(    "procesosTrabajo.sivep",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request, 
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista"=>$lista
                        ]
                    );

    }

 
    public function agregar_acuerdo_sivep_ajax( Request $request ){
        $input = $request->all();
        $id_acuerdo=$input['id_acuerdo'];
        $id_juicio=$input['id_juicio'];
        

        $lista=sivep::mover_sivep($request, $id_acuerdo);

        //se manda al sicor
        sivep::insertar_sicor_sivep($request, $id_juicio, $id_acuerdo);
        
        return response()->json([$lista]);
    }


    
    
}