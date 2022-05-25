<?php
namespace App\Http\Controllers\clases;

use DateTime;
use Exception;
use DB;

class sivep_sigj
{
    public function consultar_estatus($tipo_usuario)
    {
        try
        {
            if($tipo_usuario === "JUZGADO")
            {

            }
            else if($tipo_usuario === "PENAL")
            {

            }
            else
            {
                return array("status"=>"200",
                            "message"=>"No se encontro el TIPO de usuario",
                            "resopnse"=>"");
            }
        }

        catch(Exception $exp)
        {
            return array("status"=>"300",
                        "message"=>"Ocurrio un error: " . $exp->getMessage(),
                        "response"=>"");
        }
    }

    public function consultar_bandeja($estatus, $tabla)
    {
        try
        {
            
        }

        catch(Exception $exp)
        {
            return array("status"=>"300",
                        "message"=>"Ocurrio un error: " . $exp->getMessage(),
                        "response"=>"");
        }
    }

    public function consultar_paginator($estatus, $tabla)
    {
        try
        {

        }

        catch(Exception $exp)
        {
            return array("status"=>"300",
                        "message"=>"Ocurrio un error: " . $exp->getMessage(),
                        "response"=>"");
        }
    }
    
    public function datos_sentencia($id_sentencia, $tabla)
    {
        try
        {

        }

        catch(Exception $exp)
        {
            return array("status"=>"300",
                        "message"=>"Ocurrio un error: " . $exp->getMessage(),
                        "response"=>"");
        }
    }

    public function desacargar_sentencia($id_sentencia, $tabla)
    {
        try
        {

        }

        catch(Exception $exp)
        {
            return array("status"=>"300",
                        "message"=>"Ocurrio un error: " . $exp->getMessage(),
                        "response"=>"");
        }
    }

    public function subir_sentencia($id_sentencia, $tabla)
    {
        try
        {

        }

        catch(Exception $exp)
        {
            return array("status"=>"300",
                        "message"=>"Ocurrio un error: " . $exp->getMessage(),
                        "response"=>"");
        }
    }
}