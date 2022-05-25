<?php
namespace App\Http\Controllers\clases;

use App\Http\Controllers\clases\entorno;

class des_cifrado{

	public static function cifrado_descifrado( $string, $action='cifrado' ){


		if( !entorno::validacion(true) ){
			return [ "status"=>0, "message"=>"ERROR - en archivo de entrono" ];
		}

        $action = trim($action);
        $output = false;
        $myKey = entorno::obtener_valor( "llaves_cifrado", "llave" );
        $myIV = entorno::obtener_valor( "llaves_cifrado", "iv" );;

        $encrypt_method = 'AES-256-CBC';

        $secret_key = hash('sha256',$myKey);
        $secret_iv = substr(hash('sha256',$myIV),0,16);

        if ( $action && ($action == 'cifrado' || $action == 'descifrado') && $string )
        {
            $string = trim(strval($string));

            if ( $action == 'cifrado' )
            {
                $output = openssl_encrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
            }

            if ( $action == 'descifrado' )
            {
                $output = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
            }
        };

        return [ "status"=>100, "response"=>$output ];

    }

}