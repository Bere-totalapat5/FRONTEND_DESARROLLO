<?php

namespace App\Http\Controllers\juicios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\clases\archivos;
use App\Http\Controllers\clases\humanRelativeDate;
use App\Http\Controllers\clases\promociones;
use App\Http\Controllers\clases\juicio;
use App\Http\Controllers\clases\utilidades;
use Exception;
use GuzzleHttp\Client;
use Session;

class juicios extends Controller
{
    public function nuevo(Request $request){
        if (session('promocion_id')){

            $juicio=0;

            if(session('tipo_juicio_id')!=0){
                $datos_juicio=[                 
                    "juicio_procedimiento"=>"",
                    "materia"=>"",
                    "juicio"=>"",
                    "tipo_accion"=>"",
                    "id_catalogo"=>session('tipo_juicio_id'),
                    ];

                $response = $request
                    ->clienteWS
                    ->request('get', 'obtener_catalogo', [
                        "headers"     => [
                            "usuario-id"    => Session::get("usuario-id"),
                            "cadena-sesion" => Session::get("cadena-sesion"),
                            "sesion-id"     => Session::get("sesion-id"),
                        ],
                        "query" => [
                            "datos" => $datos_juicio,
                        ],
                    ]);

                    $respuesta = json_decode($response->getBody(), true);
                    $juicio=$respuesta['response'];
            }
        
            $datos=[
                "fecha"=>"",
                "tipo_documento"=>"",
                "confirmados"=>"",
                "no_confirmados"=>"",
                "id_juicio"=>"",
                "juzgado_sicor"=>"",
                "id_promocion"=>session('promocion_id'),                
            ];
            //dd($datos);

            $response = $request
            ->clienteWS
                ->request('get', 'demanprom_consulta', [
                    "headers"     => [
                        "usuario-id"    => Session::get("usuario-id"),
                        "cadena-sesion" => Session::get("cadena-sesion"),
                        "sesion-id"     => Session::get("sesion-id"),
                    ],
                    "query" => [
                        "datos" => $datos,
                    ],
                ]);

            $promocion = json_decode($response->getBody(), true);

            // return $juicio;
            return view("juicios.nuevo_juicio",
                    ["entorno"=>$request->entorno, 
                    "promocion"=>$promocion['response'],
                    "request"=>$request,
                    "sesion"=>$request->session()->all(),
                    "ponencia"=>$request->session()->get('grupo_trabajo_identificar_area'),
                    'id_promocion'=>session('promocion_id'),
                    "juicio"=>$juicio,
                    ]
                );
            // return $promocion;

        }else{
            return view("juicios.nuevo_juicio",
                    ["entorno"=>$request->entorno, 
                    "request"=>$request,
                    "sesion"=>$request->session()->all(),
                    "ponencia"=>$request->session()->get('grupo_trabajo_identificar_area')
                    ]
                );
        }
        
    }

    public function verifica(Request $request){
        $datos=[               
                    "juzgado"=>Session::get("usuario_juzgado"),
                    "tipo_expediente"=>$request->tipo_archivo,
                    "toca"=>$request->toca==null?"":$request->toca,
                    "anio_toca"=>$request->anio_toca==null?"":$request->anio_toca,
                    "asunto_toca"=>$request->asunto_toca==null?"":$request->asunto_toca,
                    "expediente"=>$request->expediente==null?"":$request->expediente,
                    "anio"=>$request->anio==null?"":$request->anio,
                    "bis"=>$request->bis==null?"":$request->bis,
                    "cuaderno"=>$request->cuaderno==null?"":$request->cuaderno,
                    "alias"=>$request->alias==null?"":$request->alias,
                    "numero_expediente"=>$request->numero_expediente==null?"":$request->numero_expediente
            
        ];

        $response = $request
        ->clienteWS
            ->request('get', 'validar_existencia_archivo', [
                "headers"     => [
                    "usuario-id"    => Session::get("usuario-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "sesion-id"     => Session::get("sesion-id"),
                ],
                "query" => [
                    "datos" => $datos,
                ],
            ]);

        $respuesta = json_decode($response->getBody(), true);

        return $respuesta;
    }

    public function catalogoJuicios(Request $request){
        $datos=[                 
            "juicio_procedimiento"=>$request->juicio_procedimiento==null?"":$request->juicio_procedimiento,
            "materia"=>$request->materia==null?"":$request->materia,
            "juicio"=>$request->juicio==null?"":$request->juicio,
            "tipo_accion"=>$request->tipo_accion==null?"":$request->tipo_accion,
            "id_catalogo"=>$request->id_catalogo==null?"":$request->id_catalogo,
            ];


            $response = $request
            ->clienteWS
                ->request('get', 'obtener_catalogo', [
                    "headers"     => [
                        "usuario-id"    => Session::get("usuario-id"),
                        "cadena-sesion" => Session::get("cadena-sesion"),
                        "sesion-id"     => Session::get("sesion-id"),
                    ],
                    "query" => [
                        "datos" => $datos,
                    ],
                ]);

            $respuesta = json_decode($response->getBody(), true);

            return $respuesta;
    }

    public function guardarArchivo(Request $request){

        $partes=[];
        foreach ($request->partes as $key => $datos_parte) {
            $parte=[
                "nombres"=> $datos_parte['nombre'],
                "apellido_paterno"=> $datos_parte['apellido_paterno']==null?"-":$datos_parte['apellido_paterno'],
                "apellido_materno"=> $datos_parte['apellido_materno']==null?"-":$datos_parte['apellido_materno'],
                "tipo"=> $datos_parte['tipo'],
                "tipo_persona"=> $datos_parte['tipo_persona'],
                "correo"=>$datos_parte['correo']==null?"-":$datos_parte['correo'],
                "telefono"=>$datos_parte['telefono_celular']==null?"-":$datos_parte['telefono_celular'],
                "promovente"=> $datos_parte['promovente'],
                "notificacion"=>$datos_parte['notificacion'],
                "id_usuario_notificacion"=>$datos_parte['id_usuario_notificacion'],
            ];
            array_push($partes,$parte);
        }
        

        if(isset($request->expedientes_relacionados)){
            $expedientes_relacionados=$request->expedientes_relacionados;
        }

        $tocas_relacionados=[];

        if(isset($request->tocas_relacionados)){
            $tocas_relacionados=$request->tocas_relacionados;
        }

        
        if (Session::get('juzgado_subtipo')=='SF' || Session::get('juzgado_subtipo')=='SC'){
            $datos=              
                ["tipo_expediente"=>$request->datos['tipo_archivo'],
                "tipo_expediente_extras"=>$request->datos['tipo_expediente_extra']==null?"":$request->datos['tipo_expediente_extra'],
                "toca"=>$request->datos['toca'],
                "anio_toca"=>$request->datos['anio_toca'],
                "asunto_toca"=>$request->datos['asunto_toca']==null?"":$request->datos['asunto_toca'],
                "expediente"=>"",
                "anio"=>"",
                "bis"=> "",
                "cuaderno"=>$request->datos['cuaderno']==null?"":$request->datos['cuaderno'],
                "alias"=>$request->datos['alias']==null?"":$request->datos['alias'],
                "numero_expediente"=>$request->datos['numero_expediente']==null?"":$request->datos['numero_expediente'],
                "resolucion_amparo"=>$request->datos['resolucion_amparo']==null?"":$request->datos['resolucion_amparo'],
                "juzgado"=> Session::get('usuario_juzgado'),
                "juzgado_origen"=> "",
                "secretaria"=>"",
                "fecha_publicacion"=> $request->datos['fecha_ingreso']==null?"":$request->datos['fecha_ingreso'],
                "estatus"=> "abierto",
                "id_tipojuicio"=> "",
                "id_catalogo_juicios"=> $request->datos['id_catalogo_juicio']==null?"":$request->datos['id_catalogo_juicio'],
                "id_etapaprocesal"=>"",
                "promovente"=>"",
                "tramite_interpuesto"=> "",
                "tipo_resolucion"=> "",
                "fecha_resolucion"=> "",
                "efecto_admite"=>$request->datos['efecto_admite'],
                "efecto_admite_texto"=> "",
                "competencia"=> $request->datos['competencia'],
                "interpone"=> "",
                "apela"=> $request->datos["tipo_recurso"],
                "tipo_recurso"=> $request->datos["tipo_recurso"],
                "partes"=>$partes,
                "resolucion_que_recurre"=>$request->datos["resolucion_recurre"],
                "expendientes_relacionados"=>$request->expedientes_relacionados ,
                "tocas_relacionados"=>$tocas_relacionados 
            ];
            
        }

        
        if (Session::get('juzgado_subtipo')=='PIC' || Session::get('juzgado_subtipo')=='PIF' || Session::get('juzgado_subtipo')=='PC' || Session::get('juzgado_subtipo')=='JCO' || Session::get('juzgado_subtipo')=='JFO' || Session::get('juzgado_subtipo')=='TDH'){
            $datos=       
                ["tipo_expediente"=>$request->datos['tipo_archivo'],
                "tipo_expediente_extras"=>"",
                "toca"=>"",
                "anio_toca"=>"",
                "asunto_toca"=>"",
                "expediente"=>$request->datos['expediente'],
                "anio"=>$request->datos['anio'],
                "bis"=> $request->datos['bis']==null?"":$request->datos['bis'],
                "cuaderno"=>$request->datos['cuaderno']==null?"":$request->datos['cuaderno'],
                "alias"=>$request->datos['alias']==null?"":$request->datos['alias'],
                "numero_expediente"=>"",
                "resolucion_amparo"=>"",
                "juzgado"=> Session::get('usuario_juzgado'),
                "juzgado_origen"=> "",
                "secretaria"=>$request->datos['secretaria']==null?"":$request->datos['secretaria'],
                "fecha_publicacion"=> $request->datos['fecha_ingreso']==null?"":$request->datos['fecha_ingreso'],
                "estatus"=> "abierto",
                "id_tipojuicio"=> "",
                "id_catalogo_juicios"=> $request->datos['id_catalogo_juicio'],
                "id_etapaprocesal"=>$request->datos['etapa_procesal'],
                "promovente"=>"",
                "tramite_interpuesto"=>"",
                "tipo_resolucion"=> "",
                "fecha_resolucion"=> "",
                "efecto_admite"=>"",
                "efecto_admite_texto"=>"",
                "competencia"=> "",
                "interpone"=> "",
                "apela"=> "",
                "tipo_recurso"=>"",
                "tipo_juicio_int"=>$request->datos['tipo_juicio_int'],
                "partes"=>$partes,
                "expendientes_relacionados"=>[] ,
                "tocas_relacionados"=>[] 
            ];
        }
        


        $respuestaA = $request
        ->clienteWS
            ->request('post', 'registrarArchivo', [
                "headers"     => [
                    "usuario-id"    => Session::get("usuario-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "sesion-id"     => Session::get("sesion-id"),
                ],
                "json" => [
                    "datos" => $datos,
                ],

            ]);

        $respuesta = json_decode($respuestaA->getBody(), true);



        if($request->id_promocion!=0 && $respuesta["status"]=='100'){

            $lista=promociones::editar_promocion_asignacion($request, $request->id_promocion, $respuesta["response"]["juicio"]);
            // return back();
        }else{

            $request->session()->flash('promocion_id', $request->id_promocion);
            // return redirect()->away("/juicio/nuevo/");
        }

        return $respuesta;
       
    }

    public function juzgados(Request $request){
       

        $respuestaA = $request
        ->clienteWS->request('get', 'obtenerJuzgadoTipo/'. $request->tipo_juzgado, [
                "headers"     => [
                    "usuario-id"    => Session::get("usuario-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "sesion-id"     => Session::get("sesion-id"),
                ],
            ]);

        $respuesta = json_decode($respuestaA->getBody(), true);

        return $respuesta;
    }

    public function buscarExpediente(Request $request){

        $datos=[
            "expediente_num"=>$request->expediente_num==null?"":$request->expediente_num,
            "expediente_anio"=>$request->anio==null?"":$request->anio,
            "expediente_bis"=>$request->bis==null?"":$request->bis,
            "cuaderno"=>"",
            "alias"=>"",
            "tipo_archivo"=>$request->tipo_archivo==null?"":$request->tipo_archivo,
            "id_expediente"=>$request->id_expediente==null?"":$request->id_expediente
            ];

        $codigo_organo=$request->juzgado;

        $expedientes=juicio::buscar_expediente($datos, $codigo_organo ,$request);

        return $expedientes;
    }

    public function buscarToca(Request $request){

        if(isset($request->expediente) && isset($request->anio_expediente)){

            $datos=[
                "expediente_num"=>$request->expediente==null?"":$request->expediente,
                "expediente_anio"=>$request->anio_expediente==null?"":$request->anio_expediente,
                "expediente_bis"=>$request->bis==null?"":$request->bis,
                "cuaderno"=>"",
                "alias"=>"",
                "tipo_archivo"=>"",
                "id_expediente"=>""
                ];
    
            $codigo_organo=Session::get("usuario_juzgado");
    
            $expedientes=juicio::buscar_expediente($datos, $codigo_organo ,$request);
    
            // return $datos;

            if($expedientes['status']==100){

                $response_expedientes=array();

                foreach($expedientes['response'] as $expediente){
                    
                    
                    
                    $actores=array();
                    
                    if(isset($expediente["partes"]["actor"])){
                        foreach($expediente["partes"]["actor"] as $actor){
                            $actor_datos=$actor["nombre"]." ".$actor["apellido_paterno"]." ".$actor["apellido_materno"];
                            array_push($actores, $actor_datos);
                        }
                    }

                    $demandados=array();

                    if(isset($expediente["partes"]["demandado"])){
                        foreach($expediente["partes"]["demandado"] as $demandado){
                            $demandado_datos=$demandado["nombre"]." ".$demandado["apellido_paterno"]." ".$demandado["apellido_materno"];
                            array_push($demandados, $demandado_datos);                    
                        }
                    }

                    $datos_archivo=$expediente['datos_archivo'];

                    $response=[
                        "expediente_principal"=>"",
                        "fecha_ingreso"=>$datos_archivo['fecha_publicacion'],
                        "id"=>$datos_archivo['id_juicio'],
                        "juzgado_expediente"=>"",
                        "numero"=>$datos_archivo["expediente"]."/".$datos_archivo["anio"].($datos_archivo["bis"]==null?"":$datos_archivo["bis"]. "Bis"),
                        "partes"=>[
                            "actor"=>$actores,
                            "demandado"=>$demandados,
                        ],
                        "tipo"=>$datos_archivo["tipo_expediente"]

                    ];

                    array_push($response_expedientes, $response);
                }

                

                $respuesta=[
                    "status"=>100,
                    "response"=>$response_expedientes,
                ];
            }else{
                $respuesta=$expedientes;
            }

            
            return $respuesta;

        }else{
            $datos=[
                "toca"=>$request->toca==null?"":$request->toca,
                "anio_toca"=>$request->anio==null?"":$request->anio,
                "asunto_toca"=>$request->asunto==null?"":$request->asunto,
                "por_turnar"=>"",
                "expediente"=>"",
                "expediente_anio"=>"",
                "involucrado"=>[
                    "nombres"=>"",
                    "apellido_paterno"=>"",
                    "apellido_materno"=>""
                ],
                "registrado_desde"=>"",
                "registrado_hasta"=>"",
                "juzgado"=>Session::get("usuario_juzgado"),
                "tipo_archivo"=>$request->tipo_archivo==null?"":$request->tipo_archivo 
                ];

            $respuestaA = $request
            ->clienteWS->request('get', 'buscarArchivo', [
                    "headers"     => [
                        "usuario-id"    => Session::get("usuario-id"),
                        "cadena-sesion" => Session::get("cadena-sesion"),
                        "sesion-id"     => Session::get("sesion-id"),
                    ],
                    "query" => [
                        "datos" => $datos,
                    ],
                ]);

            $respuesta = json_decode($respuestaA->getBody(), true);
         
            return $respuesta;

        }
        
    }

    public function datosToca(Request $request){

   

        $respuestaA = $request
        ->clienteWS->request('get', 'buscarToca/'. $request->id_juicio, [
                "headers"     => [
                    "usuario-id"    => Session::get("usuario-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "sesion-id"     => Session::get("sesion-id"),
                ],
                
            ]);

        $respuesta = json_decode($respuestaA->getBody(), true);

        return $respuesta;
    }

    public function editar(Request $request){
        if (isset($request->id_juicio)){ 

            if (Session::get("juzgado_subtipo")=="SC" || Session::get("juzgado_subtipo") =="SF") {
      
                $respuestaA =  $request
                    ->clienteWS
                    ->request('get', 'buscarToca/'. $request->id_juicio, [
                            "headers"     => [
                                "usuario-id"    => Session::get("usuario-id"),
                                "cadena-sesion" => Session::get("cadena-sesion"),
                                "sesion-id"     => Session::get("sesion-id"),
                            ],
                        ]);

                $respuesta = json_decode($respuestaA->getBody(), true);
                $juicio=$respuesta["response"];

                $expedientes_relacionados=[];

                foreach($respuesta["response"]['expedientes'] as $expediente){

                   $datos=[
                        "expediente_num"=>"",
                        "expediente_anio"=>"",
                        "expediente_bis"=>"",
                        "cuaderno"=>"",
                        "alias"=>"",
                        "tipo_archivo"=>"",
                        "id_expediente"=>$expediente['id_expediente'],
                        ];

                    $codigo_organo=$expediente['codigo_organo'];

                    $id=$expediente['id'];

                    $principal=$expediente['principal'];

                    $datos_expediente=(juicio::buscar_expediente($datos, $codigo_organo ,$request))['response'][0];

                    $expediente_relacionado=[
                        "expediente"=>$datos_expediente,
                        "nombre_juzgado"=>$expediente['nombre_organo'], 
                        "id"=>$id, 
                        "principal"=>$principal
                    ];

                    array_push($expedientes_relacionados, $expediente_relacionado);
                }

            //    return $expedientes_relacionados;
                if($respuesta["status"]==100){

                    return view("juicios.editar_juicio",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "ponencia"=>$request->session()->get('grupo_trabajo_identificar_area'),
                        'juicio'=>$juicio,
                        'expedientes'=>$expedientes_relacionados,
                        ]
                    );

                }        
            }   
            
            if (Session::get("juzgado_subtipo")=="PIC" || Session::get("juzgado_subtipo") =="PC" || Session::get("juzgado_subtipo" )=="JCO" || Session::get("juzgado_subtipo") =="PIF" || Session::get("juzgado_subtipo") =="JFO" || Session::get('juzgado_subtipo')=='TDH')  {
                
                $datos=[
                    "expediente_num"=>"",
                    "expediente_anio"=>"",
                    "expediente_bis"=>"",
                    "cuaderno"=>"",
                    "alias"=>"",
                    "tipo_archivo"=>"",
                    "id_expediente"=>$request->id_juicio
                        ];

                $respuestaA = $request
                    ->clienteWS->request('get', 'buscar_expediente/'. Session::get("usuario_juzgado"), [
                            "headers"     => [
                                "usuario-id"    => Session::get("usuario-id"),
                                "cadena-sesion" => Session::get("cadena-sesion"),
                                "sesion-id"     => Session::get("sesion-id"),
                            ],
                            "query" => [
                                "datos" => $datos,
                            ],
                        ]);
        
                $respuesta = json_decode($respuestaA->getBody(), true);

                $juicio=$respuesta["response"][0];

                //  return $juicio;
                if($respuesta["status"]==100){
                    return view("juicios.editar_juicio",
                        ["entorno"=>$request->entorno, 
                        "request"=>$request,
                        "sesion"=>$request->session()->all(),
                        "ponencia"=>$request->session()->get('grupo_trabajo_identificar_area'),
                        'juicio'=>$juicio,
                        ]
                    );
                // return $promocion;
                }
                
            }
            //  return $juicio;
            

            
            

        }else{
            redirect()->route('home');
        }
        
    }

    public function actualizarArchivo(Request $request){
        if (Session::get('juzgado_subtipo')=='SF' || Session::get('juzgado_subtipo')=='SC'){
            $archivo=[
                
                "id_juicio"              => $request->datos['id_juicio'],
                "tipo_expediente"        => $request->datos['tipo_archivo'],
                "tipo_expediente_extras" => $request->datos['tipo_expediente_extra']==null?"":$request->datos['tipo_expediente_extra'],
                "toca"                   => $request->datos['toca'],
                "anio_toca"              => $request->datos['anio_toca'],
                "asunto_toca"            => $request->datos['asunto_toca']==null?"":$request->datos['asunto_toca'],
                "expediente"             => "-",
                "anio"                   => "-",
                "bis"                    => "-",
                "cuaderno"               => $request->datos['cuaderno']==null?"":$request->datos['cuaderno'],
                "alias"                  => $request->datos['alias']==null?"":$request->datos['alias'],
                "numero_expediente"      => $request->datos['numero_expediente']==null?"":$request->datos['numero_expediente'],
                "resolucion_amparo"      => $request->datos['resolucion_amparo']==null?"":$request->datos['resolucion_amparo'],
                "juzgado"                => Session::get('usuario_juzgado'),
                "juzgado_origen"         => "-",
                "secretaria"             => $request->datos['secretaria']==null?"":$request->datos['secretaria'],
                "fecha_publicacion"      => $request->datos['fecha_ingreso']==null?"":$request->datos['fecha_ingreso'],
                "estatus"                => "abierto",
                "id_tipojuicio"          => "-",
                "id_catalogo_juicios"    => $request->datos['id_catalogo_juicio'],
                "id_etapaprocesal"       => "-",
                "promovente"             => "-",
                "tramite_interpuesto"    => "-",
                "fecha_resolucion"       => "-",
                "efecto_admite"          => $request->datos['efecto_admite'],
                "efecto_admite_texto"    => "-",
                "competencia"            => $request->datos['competencia'],
                "resolucion_recurre"     =>$request->datos["resolucion_recurre"],
                "interpone"              => "-",
                "apela"                  => "-",
                "tipo_recurso"           => $request->datos["tipo_recurso"],
            ];

            $datos=[
                "archivo"=>$archivo,
                "partes"      => $request->partes,
                "expedientes" => $request->expedientes_relacionados==null?[]:$request->expedientes_relacionados,
                "tocas_relacionados"=>$request->tocas_relacionados==null?[]:$request->tocas_relacionados,
            ];
            
        }
        if (Session::get('juzgado_subtipo')=='PIC' || Session::get('juzgado_subtipo')=='PIF' || Session::get('juzgado_subtipo')=='PC' || Session::get('juzgado_subtipo')=='JCO' || Session::get('juzgado_subtipo')=='JFO' || Session::get('juzgado_subtipo')=='TDH'){
            $archivo=       
                [
                    "id_juicio"       => $request->datos['id_juicio'],    
                    "tipo_expediente"=>$request->datos['tipo_archivo'],
                    "tipo_juicio_int"=>$request->datos['tipo_juicio_int'],
                    "tipo_expediente_extras"=>"",
                    "toca"=>"-",
                    "anio_toca"=>"-",
                    "asunto_toca"=>"-",
                    "expediente"=>$request->datos['expediente'],
                    "anio"=>$request->datos['anio'],
                    "bis"=> $request->datos['bis']==null?"-":$request->datos['bis'],
                    "cuaderno"=>$request->datos['cuaderno']==null?"-":$request->datos['cuaderno'],
                    "alias"=>$request->datos['alias']==null?"-":$request->datos['alias'],
                    "numero_expediente"=>"-",
                    "resolucion_amparo"=>"-",
                    "juzgado"=> Session::get('usuario_juzgado'),
                    "juzgado_origen"=> "-",
                    "secretaria"=>$request->datos['secretaria'],
                    "fecha_publicacion"=> $request->datos['fecha_ingreso']==null?"":$request->datos['fecha_ingreso'],
                    "estatus"=> "abierto",
                    "id_tipojuicio"=> "-",
                    "id_catalogo_juicios"=> $request->datos['id_catalogo_juicio'],
                    "id_etapaprocesal"=>$request->datos['etapa_procesal'],
                    "promovente"=>"-",
                    "tramite_interpuesto"=>"-",
                    "tipo_resolucion"=> "-",
                    "fecha_resolucion"=> "-",
                    "efecto_admite"=>"-",
                    "efecto_admite_texto"=>"-",
                    "competencia"=> "-",
                    "interpone"=> "-",
                    "apela"=> "-",
                    "tipo_recurso"=>"-"
                ];
            $datos=[
                "archivo"=>$archivo,
                "partes"      => $request->partes,
                "expedientes" => [],
                "tocas_relacionados"=>[],
            ];
        }

        $respuestaA        = $request
        ->clienteWS
            ->request('put', 'modificarArchivo/' . $request->datos['id_juicio'], [
                'headers'     => [
                    "usuario-id"    => Session::get("usuario-id"),
                    "cadena-sesion" => Session::get("cadena-sesion"),
                    "sesion-id"     => Session::get("sesion-id"),
                    'autorizacion'  => 'minutmanQAEtHReI',
                ],

                'json' => [
                    "datos" => $datos
                ],

            ]);

        $respuesta = json_decode($respuestaA->getBody(), true);

        return  $respuesta;
    }

    public function buscar_opc(Request $request){

        $expediente=$request->expediente;
        $anio=$request->anio;

        $juzgado_ususario=$request->session()->get('usuario_juzgado');

        if($request->session()->get('usuario_juzgado')=="200PIC" || $request->session()->get('usuario_juzgado')=="100PIC"){
            $juzgado_ususario="57PIC";
        }

        $materia_opc=$this->getMateria($request->session()->get('juzgado_subtipo'));

        $materias_arr = array("PIC", "PIF", "JCO", "PC", "JFO", "CJM", "SF", "SC");
        $juzgado = str_replace($materias_arr, "", $juzgado_ususario);
        $juzgado=$this->getNumeroJuzgadoSIGJtoOPC($request->session()->get('juzgado_subtipo'), $juzgado);

        if(utilidades::pingServer('opv.poderjudicialcdmx.gob.mx', '80')){
            try{
                $client = new Client(['base_uri'=>'https://opv.poderjudicialcdmx.gob.mx/serviciosopc/api/']);
    
                $response = $client
                    ->request('get', 'expediente.json', [            
                        'auth' => [
                            'LIBROGOB', 
                            'cantera'
                        ],
                        'query'=>[
                            'materia'=>$materia_opc,
                            'juzgado'=>$juzgado,
                            'expediente'=>$expediente,
                            'anio'=>$anio
                        ],
                    ]);
    
                $respuesta = json_decode($response->getBody(), true);
    
                return [
                    'status'=>100,
                    'response'=>$respuesta
                ];
            }
            catch (Exception $exp){
                return [
                    'status'=>0,
                    'message'=>'Sin resultados',
                ];
            }
        }else{
            return [
                'status'=>0,
                'message'=>'Error en conexión a opc, favor de reportarlo a la DEGT',
            ];
        }

    }

    public static function getNumeroJuzgadoSIGJtoOPC($materia_sigj, $numero_sigj){
        
        //civil
        if($materia_sigj=='PIC'){
            $numero_opc=$numero_sigj;
        }
        //familiar
        else if($materia_sigj=='PIF'){
            $numero_opc=$numero_sigj;
        }
        //CIVIL DE PROCESO ORAL
        else if($materia_sigj=='JCO'){
            $numero_opc=$numero_sigj;
        }
        //CUANTÍA MENOR
        else if($materia_sigj=='PC'){
            if($numero_sigj==2) $numero_opc="1";
            if($numero_sigj==3) $numero_opc="2";
            if($numero_sigj==7) $numero_opc="3";
            if($numero_sigj==8) $numero_opc="4";
            if($numero_sigj==10) $numero_opc="5";
            if($numero_sigj==11) $numero_opc="6";
            if($numero_sigj==12) $numero_opc="7";
            if($numero_sigj==13) $numero_opc="8";
            if($numero_sigj==15) $numero_opc="9";
            if($numero_sigj==16) $numero_opc="10";
            if($numero_sigj==17) $numero_opc="11";
            if($numero_sigj==21) $numero_opc="12";
            if($numero_sigj==22) $numero_opc="13";
            if($numero_sigj==27) $numero_opc="14";
            if($numero_sigj==33) $numero_opc="15";
            if($numero_sigj==36) $numero_opc="16";
            if($numero_sigj==42) $numero_opc="17";
            if($numero_sigj==43) $numero_opc="18";
            if($numero_sigj==44) $numero_opc="19";
            if($numero_sigj==46) $numero_opc="20";
            if($numero_sigj==50) $numero_opc="21";
            if($numero_sigj==54) $numero_opc="22";
            if($numero_sigj==57) $numero_opc="23";
            if($numero_sigj==58) $numero_opc="24";
            if($numero_sigj==63) $numero_opc="25";
            if($numero_sigj==66) $numero_opc="26";
            if($numero_sigj==67) $numero_opc="27";
            
        }
        //FAMILIAR DE PROCESO ORAL
        else if($materia_sigj=='R'){
            $numero_opc=$numero_sigj;
        }
        //PROCESO ORAL EN MATERIA FAMILIAR DE JUSTICIA PARA LAS MUJURES
        else if($materia_sigj=='B'){
            $numero_opc=$numero_sigj;
        }
        //SALAS FAMILIARES
        else if($materia_sigj=='SF'){
            $numero_opc=$numero_sigj;
        }
        else if($materia_sigj=='SC'){
            $numero_opc=$numero_sigj;
        }
        else{
            $numero_opc='1';
        }
        return $numero_opc;
    }

    public static function getMateria($materia_sicor){
        
        if($materia_sicor=="PIC"){       //ya
            return "C";
        }
        else if($materia_sicor=="PIF"){      
            return "F";
        }
        else if($materia_sicor=="JCO"){
            return "V";
        }
        else if($materia_sicor=="PC"){     
            return "U";
        }
        else if($materia_sicor=="JFO"){             //revisar si es R o B
            return "R";
        }
        else if($materia_sicor=="CJM"){
            return "B";
        }
        else if($materia_sicor=='SF'){
            return "SF";
        }
        else if($materia_sicor=='SC'){
            return "SC";
        }
        else{
            return $materia_sicor;
        }
    }
}
