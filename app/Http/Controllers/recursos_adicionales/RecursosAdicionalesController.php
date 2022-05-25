<?php

namespace App\Http\Controllers\recursos_adicionales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RecursosAdicionalesController extends Controller{

  //Ver todas los recursos
  public function obtener_recursosAdicionales(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'ver_catalogo_tipos_recursos',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
              "tipoRecurso"=>$request->tipoRecurso,
            ], "paginacion"=>[
              "registros_por_pagina"=>$request->registros_por_pagina,
              "pagina"=>$request->pagina]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }

  //Guardar tipo de Recursos adicionales
  public function guardar_tipoRecursosAdicionales(Request $request){
    $codigo_unidad = '001';
    $codigo_institucion = '001';
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'inserta_catalogo_tipos_recursos',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
                "codigo_unidad"=>$codigo_unidad,
                "codigo_institucion"=>$codigo_institucion,
                "codigo"=>$request->consecutivo,
                "tipo_recurso"=>$request->tipoRecurso,
                "descripcion"=>$request->descripcion,
            ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }

  //Actualizar y desactivar 
  public function actualizar_tipo_recursos_adicionales(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'modifica_catalogo_tipos_recursos',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
              "id_tipo_recurso"=>$request->idtipoRecurso,
              "tipo_recurso"=>$request->tipoRecurso,
              "descripcion"=>$request->descripcion,
              "estatus"=>$request->estatus,
            ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }

  public function obtener_recursos_audiencia(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'ver_catalogo_recursos_audiencia',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
              "tipo_recurso"=>$request->tipoRecurso,
            ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }

  public function save_recurso_audiencia(Request $request){
    $codigo_unidad = '001';
    $codigo_institucion = '001';
    $codigo_adscripcion = '00020003';

    $response = $request
    ->clienteWS_penal
    ->request('POST', 'inserta_catalogo_recursos_audiencia',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
              "codigo_unidad"=>$codigo_unidad,
              "codigo_institucion"=>$codigo_institucion,
              "codigo"=>$request->A_codigo,
              "tipo_recurso"=>$request->tipoRecurso,
              "cve_recurso"=>$request->A_claveRecurso,
              "nombre_recurso"=>$request->A_nombreRecurso,
              "adscripcion_recurso"=>$codigo_adscripcion
            ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }

  public function update_recurso_audiencia(Request $request){
    $response = $request
    ->clienteWS_penal
    ->request('POST', 'modifica_catalogo_recursos_audiencia',[
        "headers" => [
            "sesion-id" => $request->session()->get("sesion-id"),
            "cadena-sesion" => $request->session()->get("cadena-sesion"),
            "usuario-id" => $request->session()->get("usuario-id"),
            "Content-Type" => "application/json"
        ],
        "json"=>[
            "datos"=>[
              "id_recurso_audiencia"=> $request->E_idRecursoAudiencia,
              "codigo_unidad" => $request->E_codigoUnidad,
              "codigo_institucion" => $request->E_codigo_Institucion,
              "codigo" => $request->E_codigo,
              "tipo_recurso" => $request->E_idTipoRecurso,
              "cve_recurso" => $request->E_claveRecurso,
              "nombre_recurso" => $request->E_nombreRecurso,
              "adscripcion_recurso" => $request->E_adscripcion,
              "estatus"=>$request->E_estatus
            ]
        ]
    ]);
    $response = json_decode($response->getBody(),true) ;
    return $response;
  }
}








