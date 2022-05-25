<?php
namespace App;
namespace App\Http\Controllers\gestorDocumental;

use App\Http\Controllers\clases\gestorDocumental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class control_gestorDocumental extends Controller
{

    public function descargar_gestor( Request $request ){

        $input = $request->all();
        $idGlobal=$input['idGlobal'];

        //$idGlobal=288348;
        
        $bin=gestorDocumental::getDocGestor($request, $idGlobal); 
        
        
        if(!isset($input['save'])){

            if($bin['response']==0)
                return $bin['pdf'];

            header('Content-Type: application/pdf'); 
            echo $bin['pdf'];
        }
        else{
            if($bin['response']==0)
                return '';

            $pdf_decoded = $bin['pdf'];
            //Write data back to pdf file
            $url= '/var/www/html/sicor_extendido_80/public/temporales/'.$idGlobal.'_expediente.pdf';
            $pdf = fopen ($url,'w');
            fwrite ($pdf,$pdf_decoded);
            //close output file
            fclose ($pdf);

            return '/temporales/'.$idGlobal.'_expediente.pdf';

        }

        
    }
}