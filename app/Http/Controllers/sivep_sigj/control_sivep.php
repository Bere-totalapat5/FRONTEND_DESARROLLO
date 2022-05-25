<?php

namespace App\Http\Controllers\sivep_sigj;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use DateTime;

class control_sivep extends Controller
{

    // PARA SIVEP NO BORRAR NI MODIFICAR
    private $autorizacion = "P1v6iu/$1v3P/P3u41";

    public function ver_ugas_sivep( Request $request , $materia = "UGJP" )
    {
        $tipos = "";

        if( !in_array( $materia, ["UGJP", "CJM", "UTE" ]))
        return ["status" => "0", "message" => "materia invalida" ];

        if ( $materia == 'CJM' ){
            $tipos = "0";
        } else if ( $materia == 'UTE' ){
            $tipos = "9";
        }

        $response = $request
        ->clienteWS_penal
        ->request('post', 'ver_ugas',[
            "headers" => [
                "Content-Type" => "application/json"
            ],
            "json" => [
                "datos"=> [
                    "tipo" => $tipos ,
                ]
            ]
        ]);
        $response = json_decode($response->getBody(),true) ;

        return $response;
    }

    public function obtener_jueces_unidad(Request $request, $id_unidad = null ){

        if( $id_unidad == null ) return ["status"=>0, "message"=> "Error - Unidad es requerida" ];
        // DESCARTA A UNIDADES PROMUJER
        if( in_array($id_unidad , [97, 98, 99, 100, 101,107]) ) return ["status"=>0, "message"=> "Error - Unidad invalida" ];

        if( ! $request->hasHeader('autorizacion') || $request->header("autorizacion") != $this->autorizacion )
        return ["status"=>0, "message"=> "Error - Sin autorizacion" ];
        
        $response = $request
        ->clienteWS_penal
        ->request('post', 'consulta_jueces',[
            "headers" => [
                "autorizacion" => "autorization_penal_luke",
                "Content-Type" => "application/json"
            ],
            "json"=>[
                "datos"=>[
                    "id_unidad_gestion"=>$id_unidad,
                    "tipo"=> [5,14,15,94],    // control, tramite, ejecucion, oralidad(TE)
                ],
            ]
        ]);
        $jueces = json_decode($response->getBody(),true) ;

        $response = [ 
            "jueces_control" => [],
            "jueces_tramite" => [],
            "jueces_ejecucion" => [],
            "jueces_enjuiciamiento" => [],
        ];

        if( $jueces["status"] == 100 ){

            foreach($jueces["response"] as $ij => $j){
                if( $j["id_tipo_usuario"] == 5 ) $response["jueces_control"] [] = $j;
                if( $j["id_tipo_usuario"] == 14 ) $response["jueces_tramite"] [] = $j;
                if( $j["id_tipo_usuario"] == 15 ) $response["jueces_ejecucion"] [] = $j;
                if( $j["id_tipo_usuario"] == 94 ) $response["jueces_enjuciamiento"] [] = $j;
            }
        }

        $jueces["response"] = $response;
        
        return $jueces;
    }
}