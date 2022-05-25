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

    $juzgado='9JFO';

    $link=dbConnect();
    $query="SELECT t1.* 
            FROM juicio_$juzgado AS t1 
            WHERE t1.juicio_migracion=0";

    $query="SELECT t1.* 
    FROM juicio_$juzgado AS t1 
    WHERE t1.juicio_migracion=0 AND tipo_juicio_int=1";

    $lista=dbQueryArray($query, $link);

    print('EXPEDIENTES EN SIGJ: '. count($lista).'<br>');

    //exit;
    $query_txt="";
    $query_existentes=0;
    
    for($i=0; $i<count($lista); $i++){
        /*
        //se consulta en sicor
        $query="SELECT * FROM juicio WHERE expediente=".$lista[$i]['expediente']." AND anio=".$lista[$i]['anio']." AND tipo_expediente='expediente' AND juzgado='".$juzgado ."'";
        $servername = "172.16.159.139";
        $username = "sicor";
        $password = "f;3D=}VwsspX@y-k";
        $db = "sibjdf";
        $conn = new mysqli($servername, $username, $password, $db);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        //echo "Connected successfully";
        $result = $conn->query($query);
        $data = array();
        $cont = 0;
        while ( $row = mysqli_fetch_assoc($result) ){
            $data[$cont++] = $row;
        }

        
        print($query);
        if(count($data)!=0){
            $query_existentes++;
            print('<BR>EXISTE EL EXPEDIENTE');
            print(json_encode($data));
        }
        print('<hr>');

        //print(json_encode($lista[$i]).'<br><br>');
        */

        $bis = trim($lista[$i]['bis']=="") ? "NULL" : "'".$lista[$i]['bis']."'";
        $query_txt="INSERT INTO juicio (id_juicio, tipo_expediente, expediente, anio, bis, juzgado, secretaria, fecha_publicacion, estatus, id_tipojuicio, id_catalogo_juicios, id_etapaprocesal, exp_sigj) VALUES (".$lista[$i]['id_juicio'].", '".$lista[$i]['tipo_expediente']."', '".$lista[$i]['expediente']."', '".$lista[$i]['anio']."', ". $bis .", '".$lista[$i]['juzgado']."', '".$lista[$i]['secretaria']."', '".$lista[$i]['fecha_publicacion']."', '".$lista[$i]['estatus']."', NULL, '".$lista[$i]['id_catalogo_juicios']."', '".$lista[$i]['id_etapaprocesal']."', 1);<br>";

        //pedimos las partes
        $query="SELECT * FROM partes_$juzgado WHERE id_juicio=".$lista[$i]['id_juicio'];
        $lista_partes=dbQueryArray($query, $link);

        $actor=$demandado='';
        $actor_i=$demandado_i=0;
        for($j=0; $j<count($lista_partes); $j++){
            if($lista_partes[$j]['parte_tipo']=='actor'){

                if($actor_i!=0){
                    $actor.=', ';
                }

                $actor.=$lista_partes[$j]['parte_nombres'];
                if($lista_partes[$j]['parte_apellido_paterno']!="-") $actor.=" ".$lista_partes[$j]['parte_apellido_paterno'];
                if($lista_partes[$j]['parte_apellido_materno']!="-") $actor.=" ".$lista_partes[$j]['parte_apellido_materno'];

                
                $actor_i++;
            }

            if($lista_partes[$j]['parte_tipo']=='demandado'){

                if($demandado_i!=0){
                    $demandado.=', ';
                }

                $demandado.=$lista_partes[$j]['parte_nombres'];
                if($lista_partes[$j]['parte_apellido_paterno']!="-") $demandado.=" ".$lista_partes[$j]['parte_apellido_paterno'];
                if($lista_partes[$j]['parte_apellido_materno']!="-") $demandado.=" ".$lista_partes[$j]['parte_apellido_materno'];

                
                $demandado_i++;
            }
        }


        $query_txt.="INSERT INTO parte (id_parte, nombre) VALUES (".$lista[$i]['id_juicio']."1, '$actor');<br>";
        $query_txt.="INSERT INTO parte (id_parte, nombre) VALUES (".$lista[$i]['id_juicio']."2, '$demandado');<br>";


        $query_txt.="INSERT INTO juicio_partes (id_juicio, id_parte1, id_parte2) VALUES (".$lista[$i]['id_juicio'].", ".$lista[$i]['id_juicio']."1, ".$lista[$i]['id_juicio']."2);<br>";
        print($query_txt);
        

        


    }


    print('<br><br><hr>EXISTENTES EN SICOR: '.$query_existentes);

    

?>