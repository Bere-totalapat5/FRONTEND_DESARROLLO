<?php

namespace App\Http\Controllers\clases;

class StringUtils {

    public static function getSoundex($cadena){
        $vars = explode(" ",$cadena);
        $resp = "";
        $count=0;
        foreach($vars as $var){
            $resp.= soundex($var);
            ++$count;
            if($count>5) break;
        }
        return $resp;
    }

    public static function toUpperCase($cadena){
        return trim(strtr(strtoupper($cadena),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"));
    }

    public static function toLowerCase($cadena){
        return trim(strtr(strtolower($cadena),"ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ","àèìòùáéíóúçñäëïöü"));
    }

    
    private static $CURPFormat = "/[A-Z]{4}[0-9]{2}(0[0-9]|1[0-2])([0-2][0-9]|3[0-1])(M|H)[A-Z]{5}[0-9A-Z][0-9]/";
    public static function isCURP( $curp ){
        return preg_match( self::$CURPFormat, $curp);
    }

    private static $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    public static function randomString($long =19){
        mt_srand((double)microtime()*1000000);
        $i=0;
        $pass=0;
        $validLength = strlen(self::$chars);
        while ($i < $long) {
            $rand=mt_rand() % $validLength;
            $tmp=self::$chars[$rand];
            $pass=$pass . $tmp;
            $i++;
        }
        return strrev($pass);
    }
}
?>
