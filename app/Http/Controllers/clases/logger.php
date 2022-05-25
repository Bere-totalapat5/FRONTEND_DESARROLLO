<?php
namespace App\Http\Controllers\clases;

use Illuminate\Http\Request;

class logger{

  private $filename = null;
  private $filepath = null;
  private $path = null;

  private $username = null;
  private $the_function = null;
  private $process_name = null;
  private $response = null;
  private $time = null;


  function __construct( $path, $filename, $username=null, $function=null ){

    $this->path = $path;
    $this->filename = $filename;
    $this->username = $username;
    $this->the_function = $function; 

    $this->filepath = $path.$filename;
  }

  public function write( $time, $username, $action , $detail ){
    
    if( !file_exists( $this->path ) ) mkdir( $this->path, 0777, true );

    fopen( $this->filepath , " \n\n [ ".date('d-m-Y H:i:s')." ] " )
  }

  public function write_internal_error( $message ){

    $path = base_path().'/storage/custom_logs/'.date('Y/m/d/');

    if( !file_exists( $path ) ) mkdir( $path, 0777, true );

    $log = fopen($path. 'INTERNAL_ERROR.ini', 'a+' );

    fwrite( $log , "\n\n [ ". date('d-m-Y H:i:s') ." ] ". $message );
    fclose( $log );
  }
}