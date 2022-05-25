<?php
namespace App\Http\Controllers\clases;

use DateTime;
use Exception;

define ('ruta_dir_log', '/var/www/Libros_Logs/');
define ('DS', '/');
define ('AMBIENTE', 'desarrollo');
define ('SERVER', 'frontend');

class libros_logs
{
    public function verificar_carpetas()
    {
        $anio = date('Y');
        $mes = date('n');

        $re = $this->generar_carpetas_libro($anio, $mes);

        return $re;
    }

    private function generar_carpetas_libro($anio, $mes)
    {
        try
        {   
            $dir_correctos = 'Correctos';
            $dir_erroneos = 'Erroneos';

            $array_meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            $mes = $array_meses[($mes  - 1)];

            if(file_exists(ruta_dir_log))
            {
                //CARPETA DEL AÑO
                if( !file_exists(ruta_dir_log . $anio) )
                {
                    mkdir(ruta_dir_log . $anio, 0775, true);
                }
    
                //CARPETA DEL MES
                if( !file_exists(ruta_dir_log . $anio . DS . $mes) )
                {
                    mkdir(ruta_dir_log . $anio . DS . $mes, 0775, true);
                }
    
                //CARPETA DE CORRECTOS
                if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos) )
                {
                    mkdir(ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos, 0775, true);
                }
    
                //CARPETA DE ERRONEOS
                if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos) )
                {
                    mkdir(ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos, 0775, true);
                }

                return 'OK!';
            }
    
            else
            {
                mkdir(ruta_dir_log, 0775, true);

                //CARPETA DEL AÑO
                if( !file_exists(ruta_dir_log . $anio) )
                {
                    mkdir(ruta_dir_log . $anio, 0775, true);
                }

                //CARPETA DEL MES
                if( !file_exists(ruta_dir_log . $anio . DS . $mes) )
                {
                    mkdir(ruta_dir_log . $anio . DS . $mes, 0775, true);
                }

                //CARPETA DE CORRECTOS
                if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos) )
                {
                    mkdir(ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos, 0775, true);
                }

                //CARPETA DE ERRONEOS
                if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos) )
                {
                    mkdir(ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos, 0775, true);
                }

                return 'OK!';
            }
        }
        catch(Exception $exp)
        {
            return $exp->getMessage();
        }
    }

    public function regristro_correctos($funcion, $datos)
    {
        try
        {
            $anio = date('Y');
            $mes_num = date('n');
            $fecha_hora = date('Y_m_d');
            
            $dir_correctos = 'Correctos';

            $array_meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            $mes = $array_meses[($mes_num  - 1)];
   
            if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos) )
            {
                $this->generar_carpetas_libro($anio, $mes_num);
            }

            //CARPETA DEL DÍA CORRECTOS
            if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos . DS . $fecha_hora) )
            {
                mkdir(ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos . DS . $fecha_hora, 0775, true);
            }
 
            // //ARCHIVO LOG CORRECTO DEL DÍA
            if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos . DS . $fecha_hora . DS . $fecha_hora . '.ini') )
            {
                $file = ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos . DS . $fecha_hora . DS . $fecha_hora . '.ini';

                $file = fopen( $file,'a');

                chmod($file, 0775);
            }

            if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos . DS . $fecha_hora . DS . $fecha_hora . '.ini') )
            {
                $file = ruta_dir_log . $anio . DS . $mes . DS . $dir_correctos . DS . $fecha_hora . DS . $fecha_hora . '.ini';

                $date = new DateTime();
                $nombre_seccion = $date->format('H_i_s_u');
                
                $array_datos = array("tiempo"=>$nombre_seccion, "ambiente"=>AMBIENTE, "server"=>SERVER, "funcion"=>$funcion, "datos"=>$datos);

                $salida = '[' . $array_datos['tiempo'] . ']' . PHP_EOL;

                foreach($array_datos as $index => $value)
                {
                    $salida .= $index.' = "'.$value.'"'.PHP_EOL;
                }

                $file = fopen( $file,'a');

                fwrite($file, $salida . PHP_EOL);

                fclose($file);         
            }

            return "OK!";
        }

        catch(Exception $exp)
        {
            return "Error al guardar el log C: " . $exp->getMessage();
        }
    }

    public function registro_errores($funcion, $error)
    {
        try
        {
            $anio = date('Y');
            $mes_num = date('n');
            $fecha_hora = date('Y_m_d');
            
            $dir_erroneos = 'Erroneos';

            $array_meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            $mes = $array_meses[($mes_num  - 1)];
   
            //VERIFICAMOS QUE EXISTA LA CARPETA PADRE
            if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos) )
            {
                $this->generar_carpetas_libro($anio, $mes_num);
            }

            //CARPETA DEL DÍA ERRONEOS
            if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos . DS . $fecha_hora) )
            {
                mkdir(ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos . DS . $fecha_hora, 0775, true);
            }
 
            // //ARCHIVO LOG ERRONEO DEL DÍA
            if( !file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos . DS . $fecha_hora . DS . $fecha_hora . '.ini') )
            {
                $file = ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos . DS . $fecha_hora . DS . $fecha_hora . '.ini';

                fopen( $file,'a');

                chmod($file, 0775);
            }

            if( file_exists(ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos . DS . $fecha_hora . DS . $fecha_hora . '.ini') )
            {
                $file = ruta_dir_log . $anio . DS . $mes . DS . $dir_erroneos . DS . $fecha_hora . DS . $fecha_hora . '.ini';

                $date = new DateTime();
                $nombre_seccion = $date->format('H_i_s_u');
                
                $array_errores = array("tiempo"=>$nombre_seccion, "ambiente"=>AMBIENTE, "server"=>SERVER, "funcion"=>$funcion, "error"=>$error);

                $salida = '[' . $array_errores['tiempo'] . ']' . PHP_EOL;

                foreach($array_errores as $index => $value)
                {
                    $salida .= $index.' = "'.$value.'"'.PHP_EOL;
                }

                $file = fopen( $file,'a');

                fwrite($file, $salida . PHP_EOL);

                fclose($file);
            }

            return "OK!";
        }

        catch(Exception $exp)
        {
            return "Error al guardar el log E: " . $exp->getMessage();
        }
    }
}