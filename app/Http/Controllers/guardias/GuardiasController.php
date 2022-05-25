<?php

namespace App\Http\Controllers\guardias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\clases\catalogos;
use App\Http\Controllers\clases\archivos;
use Illuminate\Support\Arr;

class GuardiasController extends Controller
{
    public function guardias(Request $request)
    {
        $ugas = catalogos::obtener_ugas($request)['response'];

        $id_usuario = Session::get('usuario_id');
        $response = $request->clienteWS_penal->request('get', 'obtener_acciones_vista' . "/" . $id_usuario . "/10", [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
        ]);
        $acciones = json_decode($response->getBody(), true);
        $acciones = $acciones['response'];

        $elementos = ["entorno" => $request->entorno, "request" => $request, "sesion" => Session::all(), "menu_general" => $request->menu_general, "ugas" => $ugas, "acciones" => $acciones];

        return view('guardias.guardias', $elementos);
    }

    public function guardias_promujer(Request $request)
    {
        $ugas = catalogos::obtener_ugas($request)['response'];

        $id_usuario = Session::get('usuario_id');
        $response = $request->clienteWS_penal->request('get', 'obtener_acciones_vista' . "/" . $id_usuario . "/11", [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
        ]);
        $acciones = json_decode($response->getBody(), true);
        $acciones = $acciones['response'];

        $elementos = ["entorno" => $request->entorno, "request" => $request, "sesion" => Session::all(), "menu_general" => $request->menu_general, "ugas" => $ugas, "acciones" => $acciones];

        return view('guardias.guardias_promujer', $elementos);
    }

    public function obtener_guardias(Request $request)
    {
        $datos = [
            "id_unidad" => $request->unidad,
            "tipo_guardia" => $request->tipo,
        ];
        // return $datos;
        $response = $request->clienteWS_penal->request('post', 'ver_guardias', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => $datos,
                "paginacion" => [
                    "pagina" => $request->pagina,
                    "registros_por_pagina" => 10,
                ],
            ],
        ]);

        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function guardar_guardia(Request $request)
    {
        $jueces = '';
        $fI = explode('-', $request->fecha_inicio);
        $fecha_inicio = $fI[2] . '-' . $fI[1] . '-' . $fI[0];
        $fF = explode('-', $request->fecha_fin);
        $fecha_fin = $fF[2] . '-' . $fF[1] . '-' . $fF[0];

        if (isset($request->jueces)) {
            $i = 0;
            foreach ($request->jueces as $juez) {
                if ($i == 0) {
                    $jueces .= $juez;
                } else {
                    $jueces .= "," . $juez;
                }
                $i++;
            }
        }

        $datos = [
            "id_usuario" => Session::get('usuario_id'),
            "id_unidad" => $request->unidad,
            "ids_jueces" => $jueces,
            "tipo_guardia" => $request->tipo,
            "fecha_inicio" => $fecha_inicio . " " . $request->hora_inicio . ":00",
            "fecha_fin" => $fecha_fin . " " . $request->hora_fin . ":00",
            "comentarios_guardia" => $request->comentarios,
            "id_usuario_sesion" => Session::get('usuario_id'),
        ];

        $response = $request->clienteWS_penal->request('post', 'inserta_guardias', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => $datos,
            ],
        ]);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function elimina_guardias(Request $request)
    {
        $response = $request->clienteWS_penal->request('post', 'elimina_guardias', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => [
                    "id_guardia" => $request->id_guardia,
                ],
            ],
        ]);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function guardar_edicion_guardia(Request $request)
    {
        $jueces = '';
        $fI = explode('-', $request->fecha_inicio);
        $fecha_inicio = $fI[2] . '-' . $fI[1] . '-' . $fI[0];
        $fF = explode('-', $request->fecha_fin);
        $fecha_fin = $fF[2] . '-' . $fF[1] . '-' . $fF[0];
        if (isset($request->jueces)) {
            $i = 0;
            foreach ($request->jueces as $juez) {
                if ($i == 0) {
                    $jueces .= $juez;
                } else {
                    $jueces .= "," . $juez;
                }
                $i++;
            }
        }
        $datos = [
            "id_guardia" => $request->guardia,
            "id_usuario" => Session::get('usuario_id'),
            "id_unidad" => $request->unidad,
            "ids_jueces" => $jueces,
            "tipo_guardia" => $request->tipo,
            "fecha_inicio" => $fecha_inicio . " " . $request->hora_inicio . ":00",
            "fecha_fin" => $fecha_fin . " " . $request->hora_fin . ":00",
            "comentarios_guardia" => $request->comentarios,
            "id_usuario_sesion" => Session::get('usuario_id'),
            "estatus" => $request->estatus,
        ];

        $response = $request->clienteWS_penal->request('post', 'modifica_guardias', [
            "headers" => [
                "sesion-id" => $request->session()->get("sesion-id"),
                "cadena-sesion" => $request->session()->get("cadena-sesion"),
                "usuario-id" => $request->session()->get("usuario-id"),
                "Content-Type" => "application/json",
            ],
            "json" => [
                "datos" => $datos,
            ],
        ]);
        $response = json_decode($response->getBody(), true);

        return $response;
    }
}
