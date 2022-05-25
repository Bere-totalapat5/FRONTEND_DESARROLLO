<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    define("DB_HOST","172.16.147.177");
    define("DB","sicor_extendido");
    define("DB_USER","iarellano_front");
    define("DB_PASSWD",'}*SXTZ4%:pG$DLr');

    function dbConnect(){ 
        //se conecta con la DB
        $link = mysqli_connect((DB_HOST),(DB_USER),(DB_PASSWD), (DB));
        mysqli_set_charset($link, 'utf8mb4');
        // mysqli_query("SET NAMES 'utf8'", $link);
        
        //mysql_set_charset('utf8');
        if (!$link){
            return mysqli_error($link);
        }
        return $link;
    }


    function dbQueryArray($query, $link){

        $result = mysqli_query($link, $query);
        $resultRow = array ();
        if ($result){
            $i=0;
            while ($row=mysqli_fetch_array($result)) {
            $resultRow[$i]=$row;
            $i++;
            }
        } 
        return $resultRow;
    }

    $juzgado='1JFO';

    $link=dbConnect();
    $query="SELECT * 
            FROM demanprom_opc_promociones AS t1 
            WHERE t1.opc_promocion_juzgado_sicor='$juzgado' 
                and t1.id_juicio<>''
                and t1.opc_promocion_id NOT IN (SELECT t2.id_opc_promocion FROM demanprom_promociones_acuerdos AS t2 WHERE t2.codigo_organo='$juzgado' )";
    //print $query;

    //and (t1.opc_promocion_tipo_documento='POS' ) 
    //and (t1.opc_promocion_origen='OPV' OR  t1.opc_promocion_origen='OPC' OR  t1.opc_promocion_origen='SIGJ SCANER') 
    //and t1.opc_promocion_creacion BETWEEN '2020-10-19 00:00:01' AND '2020-10-23 23:59:00' 
    //GROUP BY DAY(t1.opc_promocion_creacion)
    //1 importación INIC >=
    //2 importacion INIC <=
    //3 importacion >=    fechas del and t1.opc_promocion_creacion BETWEEN '2020-10-19 00:00:01' AND '2020-10-23 23:59:00'  con promociones POS
    //4 importacion <=
    //5 JFO1        >=
    //6 JFO1        <=


    $lista=dbQueryArray($query, $link);

    print(count($lista).'<br>');
    //print_r($lista);

    //exit;
    $query_txt="";
    
    for($i=0; $i<count($lista); $i++){
        print(json_encode($lista[$i]).'<br><br>');


        $query='SELECT * 
                FROM acuerdo_'.$juzgado.' 
                WHERE acuerdo LIKE "'.$lista[$i]['opc_promocion_no_expediente'].'/'.$lista[$i]['opc_promocion_anio_expediente'].'%" 
                        AND fecha_publicacion <= "'.$lista[$i]['opc_promocion_fecha_recepcion'].'" 
                        AND activo<>0
                LIMIT 1';
        print($query.'<br><br>');
        $lista_acuerdo=dbQueryArray($query, $link);

        if(isset($lista_acuerdo[0]['id_acuerdo'])){
            print(json_encode($lista_acuerdo[0]).'<br><br>');

            $insert='INSERT INTO demanprom_promociones_acuerdos (codigo_organo, id_acuerdo, id_opc_promocion, fecha_creacion, estatus, automatizacion) VALUES ("'.$juzgado.'", '.$lista_acuerdo[0]['id_acuerdo'].', '.$lista[$i]['opc_promocion_id'].', "'.date('Y-m-d H:i:s').'", 1, 6);';
            print($insert);
            $query_txt.=$insert.'<br>';

            print('<hr>');
        }
        else{
            print('<strong>SIN RELACION</strong><hr>');
        }
    }


    print('<br><br><hr><hr>'.$query_txt);

    

?>