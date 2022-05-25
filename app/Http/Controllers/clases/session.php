<?php
namespace App\Http\Controllers\clases;

class session{
    
    public static function add( $key, $value ){
        $_SESSION[$key] = $value;
    }

    public static function get( $key ){
        return $_SESSION[$key];
    }

    public static function delete( $key ){
        unset( $_SESSION[$key] );
    }

    public static function exist( $key ){
        if( isset($_SESSION[$key]) ){
            return true;
        } else {
            return false;
        }
    }
}