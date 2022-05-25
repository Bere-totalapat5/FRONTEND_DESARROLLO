<?php

namespace App\Http\Controllers\clases;
use Illuminate\Http\Request;

/*

Human Friendly dates by Invent Partners
We hope you enjoy using this free class.
Remember us next time you need some software expertise!
http://www.inventpartners.com
*/

class humanRelativeDate{

    private $current_timestamp;
    private $current_timestamp_day;
    private $event_timestamp;
    private $event_timestamp_day;
    private $calc_time = false;   // Are we going to do times, or just dates?
    private $string = 'Ahora';
    
    private $magic_5_mins = 300;
    private $magic_15_mins = 900;
    private $magic_30_mins = 1800;
    private $magic_1_hour = 3600;
    private $magic_1_day = 86400;
    private $magic_1_week = 604800;
    
    public function __construct(){
        date_default_timezone_set('America/Mexico_City');
        $this->current_timestamp = time();
        $this->current_timestamp_day = mktime(0,  0 ,  0 , $month = date("n") , $day = date("j") , date("Y"));
    
    }
    
    
    
    public function getTextForSQLDate($sql_date){
        
        date_default_timezone_set('America/Mexico_City');
        
        // Split SQL date into date / time
        @list($date , $time) = explode(' ' , $sql_date);
        // Split date in Y,m,d
        @list($Y,$m,$d) = explode('-' , $date);
        // Check that this is actually a valid date!
        if(@checkdate($m , $d , $Y)){
            // If we have a time, then we can show relative time calcs!
            if(isset($time) && $time){
                $this->calc_time = true;
                // Split tim in H,i,s
                @list($H,$i,$s) = explode(':' , $time);
            } else {
                $this->calc_time = false;
                $H=12;
                $i=0;
                $s=0;
            }
            // Set the event timestamp
            $this->event_timestamp = mktime($H, $i , $s , $m , $d , $Y);
            $this->event_timestamp_day = mktime(0 , 0 , 0 , $m , $d , $Y);
            
            //Get the string
            $this->getString();
        } else {
            $this->string = 'Fecha inválida';
        }
        
        return $this->string;
        
    }
    
    public function getString(){
        date_default_timezone_set('America/Mexico_City');
        // Is this today
        if($this->event_timestamp_day == $this->current_timestamp_day){
            if($this->calc_time){
                $this->calcTimeDiffString();
                return true;
            } else {
                $this->string = 'Hoy';
                return true;
            }
        } else {
            $this->calcDateDiffString();
            return true;
        }
    
    }

    protected function calcTimeDiffString(){
        date_default_timezone_set('America/Mexico_City');
        $diff = $this->event_timestamp - $this->current_timestamp;
    
        // Future events
        if($diff > 0){
            if($diff < $this->magic_5_mins){
                $this->string = 'Ahora';
            } else if ($diff < $this->magic_15_mins){
                $this->string = 'En los próximos minutos';
            } else if ($diff < $this->magic_30_mins){
                $this->string = 'En la próxima media hora';
            } else if ($diff < $this->magic_1_hour){
                $this->string = 'En la próxima hora';
            } else {
                $this->string = 'Hoy a las ' . date('H:i' , $this->event_timestamp);
            }
        }
        // Past Events
        else {
            $diff = abs($diff);
            if($diff < $this->magic_5_mins){
                $this->string = 'Justo ahora';
            } else if ($diff < $this->magic_15_mins){
                $this->string = 'Hace pocos minutos';
            } else if ($diff < $this->magic_30_mins){
                $this->string = 'Hace media hora';
            } else if ($diff < $this->magic_1_hour){
                $this->string = 'En la ultima hora';
            } else  if ($diff < ($this->magic_1_hour * 2)){
                $this->string = 'Hace una hora';
            } else {
                $this->string = ' Hace '.floor($diff / $this->magic_1_hour) . ' horas';
                //$this->string = 'today at ' . date('H:i' , $this->event_timestamp);
            }
        
        }
    
    }
    
    protected function calcDateDiffString(){
    
        date_default_timezone_set('America/Mexico_City');
        $dias = array("lunes", "martes", "mi&eacute;rcoles", "jueves", "viernes", "s&aacute;bado", "domingo");
        
        $diff = $this->event_timestamp_day - $this->current_timestamp_day;
    
        // Future events
        if($diff > 0){
            //Tomorrow
            if($diff >= $this->magic_1_day && $diff < ($this->magic_1_day * 2)){
                $this->string = 'Mañana'; 
                return true;
            } else if($diff <= $this->magic_1_week){
                // Find out if this date is this week or next!
                $current_day = date('w' , $this->current_timestamp_day);
                if($current_day == 0){
                    $current_day = 7;
                }
                $event_day = date('w' , $this->event_timestamp_day);
                if($event_day == 0){
                    $event_day = 7;
                }
                if($event_day > $current_day){
                    $this->string = 'Éste ' . $dias[date('N' , $this->event_timestamp_day)-1];
                } else {
                    $this->string = 'Siguiente ' . $dias[date('N' , $this->event_timestamp_day)-1];
                }
            } else if($diff <= ($this->magic_1_week * 2) ) {
                $this->string = 'Del ' . $dias[date('N' , $this->event_timestamp_day)-1] . " en ocho d&iacute;as.";
            } else {
                $month_diff = $this->calcMonthDiff();
                if($month_diff == 0){
                    $this->string = 'A finales de mes';
                } else if($month_diff == 1){
                    $this->string = 'Siguiente mes';
                } else {
                    $this->string = 'En ' . $month_diff . ' meses';
                }
            }
        } 
        // Historical events
        else {
            $diff = abs($diff);
            //Tomorrow
            if($diff >= $this->magic_1_day && $diff < ($this->magic_1_day * 2)){
                $this->string = 'Ayer'; 
                return true;
            } else if($diff <= $this->magic_1_week){
                $this->string = 'El ' . $dias[date('N' , $this->event_timestamp_day)-1] . " pasado";
            } else if($diff <= ($this->magic_1_week * 2) ) {
                $this->string = 'Hace una semana ';
            } else {
                $month_diff = $this->calcMonthDiff();
                if($month_diff == 0){
                    $this->string = 'Casi un mes';
                } else if($month_diff == 1){
                    $this->string = 'Hace un mes';
                } else {
                    if($month_diff > 12){
                        $this->string = 'Casi un año';
                    } else {
                        $this->string = 'Hace '. $month_diff . ' meses';
                    }
                }
            }
            
        }
    
    }
    
    protected function calcMonthDiff(){
        date_default_timezone_set('America/Mexico_City');
        $event_month = intval( (date('Y' , $this->event_timestamp_day) * 12) + date('m' , $this->event_timestamp_day));
        $current_month = intval( (date('Y' , $this->current_timestamp_day) * 12) + date('m' , $this->current_timestamp_day));
        $month_diff = abs($event_month - $current_month);
        return $month_diff;
    
    }

}
	

?>