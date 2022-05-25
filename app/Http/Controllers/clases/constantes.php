<?php
namespace App\Http\Controllers\clases;

class constantes{

    const url_proyecto = "/usr/local/anales/httpd/htdocs/ferias-anales/";
    const url_configuraciones = self::url_proyecto."config/";


    const url_config_conexiones_BD = self::url_configuraciones."constantes.ini";

    public static function definicion_archivo_conexion_BDs(){
        return (    (file_exists(self::url_config_conexiones_BD))
                        ?   array("status"=>100,"message"=>"success")
                        :   array("status"=>0,"message"=>"ARCHIVO DE CONFIGURACION DE CONSTANTES NO DEFINIDO")
                );
    }

    public static function validar_conexion_BD( $nombre_conexion ){

        $response = parse_ini_file(self::url_config_conexiones_BD, true);

        if( isset($response["referencias_conexiones_BD"][$nombre_conexion]) && $response["referencias_conexiones_BD"][$nombre_conexion] == 1 ){
            return $nombre_conexion;
        } else {
            return "sicor2";
        }

    }

    public static function cifrados(){

        $response = parse_ini_file(self::url_config_conexiones_BD, true);

        if( isset($response["cifrado"]["KEY"]) && isset($response["cifrado"]["IV"]) ){
            return [    "status"=>100,
                        "response"=>[
                            "KEY"=>$response["cifrado"]["KEY"],
                            "IV"=>$response["cifrado"]["IV"]
                        ]
                ];
        } else {
            return [    "status"=>0,
                        "message"=>"CADENA DE CIFRADO NO DEFINIDA"
                ];
        }

    }

}

?>