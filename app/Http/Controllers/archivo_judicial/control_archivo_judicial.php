<?php

namespace App\Http\Controllers\archivo_judicial;

use App\Http\Controllers\clases\archivo_judicial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class control_archivo_judicial extends Controller
{
    public function inicio( Request $request ){

        $datos['modo']='lista';
        $datos['pagina']='1';
        $datos['registros_por_pagina']='30';
        $lista=archivo_judicial::juicios_para_archivo_judicial($request, $datos);
        
        return view(    "archivo_judicial.inicio",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "menu_general"=>$request->menu_general,
                        "lista"=>$lista
                        ]
                    );
    }
 
    public function detalles_archivo( Request $request ){

        $input = $request->all();
        $datos['id_juicio']=$input['id_juicio'];
        $lista_historial=archivo_judicial::historial_archivo_judicial_expediente($request, $datos);

        $plantilla_archivo_body=print_r($lista_historial, true);
        $plantilla_archivo_header="";
        $agregar=$input['agregar'];

        include "plantilla_historial.php";
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
        
    }


    public function confirmar_lista_expedientes( Request $request ){

        $input = $request->all();
        $arr_imprimir=$input['arr_imprimir'];
        $arr_imprimir=explode("----", $arr_imprimir);

        $plantilla_archivo_body=print_r($input, true);
        $plantilla_archivo_header="";

        if($arr_imprimir[0]!=""){
            include "plantilla_resumen_lista.php";
        }
        else{
            $plantilla_archivo_body="<center><h4><br><br>Debe de seleccionar al menos un expediente</h4></center><br><br>";
        }
        return response()->json(['plantilla_archivo_header'=>$plantilla_archivo_header, 'plantilla_archivo_body'=>$plantilla_archivo_body]);
    }

    public function cambiar_estatus_archivo( Request $request ){
        $input = $request->all();

        $datos=[];
        $datos_guardar=[];
        $datos_final=[];

        $datos_guardar1['tipo_archivo_judicial']=$input['tipo_archivo_judicial'];
        $datos_guardar1['folio_lista']=$input['folio'];

        for($i=0; $i<count($input['datos']['num']); $i++){
            $datos[$i]['num']=$input['datos']['num'][$i];
            $datos[$i]['expediente']=$input['datos']['expediente'][$i];
            $datos[$i]['actor']=$input['datos']['actor'][$i];
            $datos[$i]['demandado']=$input['datos']['demandado'][$i];
            $datos[$i]['juicio']=$input['datos']['juicio'][$i];
            $datos[$i]['fojas']=$input['datos']['fojas'][$i];

            $datos_guardar=[];
            $datos_guardar['id_juicio']=$input['datos']['id_juicio'][$i];
            $datos_guardar['organo']=$request->session()->get('usuario_juzgado');
            $datos_guardar['fojas']=$input['datos']['fojas'][$i];
            $datos_guardar['ubicacion_fisica']=$input['tipo_archivo_judicial'];

            $datos_final[]=$datos_guardar;
        }

        $lista=archivo_judicial::agregar_expediente_archivo_judicial($request, $datos_final, $datos_guardar1);
        $url=archivo_judicial::generarListaArchivoJudicial($request, $datos, $input['folio'], $input['tipo_archivo_judicial']);
        $b64PDF=chunk_split(base64_encode(file_get_contents($url, "r")));

        //dd($lista['response']['id_folio_lista']);
        $id=$lista['response']['id_folio_lista'];
        //se sube el documento
        $lista_subir=archivo_judicial::agregar_lista_pdf_archivo_judicial($request, $id, 'subir', $b64PDF);

        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=".$url);
        @readfile($url);

        return $url;
    }
    

    public function agregar_lista( Request $request ){
        $input = $request->all();
        $datos['id_juicio']=$input['id_juicio'];
        $datos['fojas']=$input['fojas'];

        $return=archivo_judicial::agregar_a_lista_archivo_judicial($request, $datos);
        return $return;
    }

    public function eliminar_lista( Request $request ){
        $input = $request->all();
        $datos['id_archivo_judicial_lista']=$input['id_archivo_judicial_lista'];
        $return=archivo_judicial::eliminar_a_lista_archivo_judicial($request, $datos);
        return 1;
    }

    public function descargar_archivo( Request $request ){
        $input = $request->all();
        $id=$input['id'];
        $b64PDF="";
        $lista_subir=archivo_judicial::agregar_lista_pdf_archivo_judicial($request, $id, 'obtener', $b64PDF);
        return $lista_subir;
    }

}