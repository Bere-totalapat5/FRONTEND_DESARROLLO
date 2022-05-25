<?php

/*
	JAL. Compilador de formularios otakuraku@gmail.com 2/abr/2014
*/
	
	$ruta_archivo = "/var/www/depgar/php-inc/maquetas/formulariosCompilados.php";
	//$ruta_archivo = "formulariosCompilados.php";
	
	$versionCompiladorDeFormas = "0.1a";

	$db_server = "o2u";
	$db_username = "webuser";
	$db_password = "123465";
	$db_name = "sadg_fede";
	
	$camposNumericos = array("orden","maxlength");
//	echo "<pre>";
	echo "==== COMPILANDO FORMAS (v$versionCompiladorDeFormas) ====\n";

	mysql_connect($db_server,$db_username,$db_password);
	mysql_select_db($db_name);
	
	
	$el_archivo = "<?php\n//Este es un archivo generado, no modificar directamente.\n\n";
	$el_archivo .= "\t\$formulariosCompilados = array(\n";
	
	$qry = "SELECT * FROM maq_formas;";
	
	$res = mysql_query($qry) or die(mysql_error());
	
	for ($i = 0; $i < mysql_num_rows($res); $i++){
		$row = mysql_fetch_assoc($res);
//		print_r($row);
		$qry = "SELECT * FROM maq_formas_elementos WHERE maq_formas_id = '{$row['maq_formas_id']}'";
		
		$res2 = mysql_query($qry) or die(mysql_error());
		
		if ($i > 0) {
			$el_archivo .=",";
		}
		
		$el_archivo .= "\n\t\t\"{$row['clave']}\"\t=> array(\n";
		$el_archivo .= "\t\t\t\t\t\t\"forma\"\t=> array(\n";
		
		$contador = 0;
		foreach ($row as $k=>$l) {
			if ($k == "maq_formas_id") {
				continue;
			}
			
			$l = str_replace("\\\"","\"",$l);
			$l = str_replace("\\n","\n",$l);
			$l = str_replace("\"","\\\"",$l);
			$l = str_replace("\n","\\\\n",$l);
			if ($contador > 0) {
				$el_archivo .= ",";
			}
			
			$el_archivo .= "\n\t\t\t\t\t\t\t\t\t\"$k\"\t\t=> utf8_encode(\"$l\")";
			
			$contador++;
		}
		
		$el_archivo .= "\n\t\t\t\t\t\t\t\t\t),\n";
		
//		echo "---- Elementos -----";

		$el_archivo .= "\t\t\t\t\t\t\"elementos\"\t=> array(\n";
		
		for ($j = 0; $j < mysql_num_rows($res2); $j++) {
			$row2 = mysql_fetch_assoc($res2);
			
			if ($j > 0) {
				$el_archivo .= ",";
			}
			
//			print_r($row2);
			$el_archivo .= "\n\t\t\t\t\t\t\t\t\tarray(\n";
			$contador = 0;
			foreach ($row2 as $k=>$l) {
				if ($k == "maq_formas_id") {
					continue;
				}
				$l = str_replace("\\\"","\"",$l);
				$l = str_replace("\\n","\n",$l);
				$l = str_replace("\"","\\\"",$l);
				$l = str_replace("\n","\\\\n",$l);
				if ($contador > 0) {
					$el_archivo .= ",";
				}
				
				if (in_array($k,$camposNumericos)) {
					$el_archivo .= "\n\t\t\t\t\t\t\t\t\t\"$k\"\t\t=> $l";
				}else {
					$el_archivo .= "\n\t\t\t\t\t\t\t\t\t\"$k\"\t\t=> utf8_encode(\"$l\")";
				}
				
				$contador++;
			}
			
			$el_archivo .= "\n\t\t\t\t\t\t\t\t\t)";
		}
		
		$el_archivo .= "\n\t\t\t\t\t\t\t\t)\n";
		$el_archivo .= "\t\t\t\t\t\t)";
		
		echo " + Forma '{$row['clave']}' compilada.\n";
	}
	
	$el_archivo .= "\n\t);\n";
	$el_archivo .= "\n?>";
	
	$fp = fopen($ruta_archivo,"wt");
	
	fwrite($fp,$el_archivo);
	// chmod($ruta_archivo,0777);
	
	fclose($fp);
	
	echo "Archivo final en: $ruta_archivo.\n";
	echo "==== FIN DE COMPILACIÓN DE FORMAS ====\n";
	
//	echo "</pre>";
?>