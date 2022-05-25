<?php

/*
	JAL. Compilador de tablas otakuraku@gmail.com 2/abr/2014
*/
	
	$ruta_archivo = "/var/www/depgar/public_html/maquetas/conceptos.json";
	//$ruta_archivo = "tablasCompiladas.php";
	
	$versionCompiladorDeConceptos = "0.1a";

	$db_server = "o2u";
	$db_username = "webuser";
	$db_password = "123465";
	$db_name = "sadg_fede";
	
//	echo "<pre>";
	echo "==== COMPILANDO CONCEPTOS (v$versionCompiladorDeConceptos) ====\n";

	mysql_connect($db_server,$db_username,$db_password);
	mysql_select_db($db_name);
	
	
	$qry = "SELECT * FROM catalogo_conceptos ORDER BY encabezado, materia, orden;";
	
	$res = mysql_query($qry) or die(mysql_error());
	
	$el_arreglo = array();
	
	for ($i = 0; $i < mysql_num_rows($res); $i++){
		$row = mysql_fetch_assoc($res);
		
		if ($row['concepto'] == "OTROS*" || $row['encabezado'] == "" || $row['concepto'] == "" || !isset($row['concepto']) || $row['concepto'] == NULL) {
			continue;
		}
		
		if (!isset($el_arreglo[$row['encabezado']])) {
			$el_arreglo[$row['encabezado']] = array();
		}
		
		if (!isset($el_arreglo[$row['encabezado']][$row['materia']])) {
			$el_arreglo[$row['encabezado']][$row['materia']] = array();
		}
		
		$el_arreglo[$row['encabezado']][$row['materia']][] = array("concepto"=>utf8_encode($row['concepto']),"orden"=>$row['orden']);
		echo utf8_encode("+ Concepto({$row['encabezado']})({$row['materia']}): '{$row['concepto']}' agregado.\n");
	}
	
	$el_archivo = json_encode($el_arreglo);
	
	$fp = fopen($ruta_archivo,"wt");
	
	fwrite($fp,$el_archivo);
	// chmod($ruta_archivo,0777);
	
	fclose($fp);
	
	echo "Archivo final en: $ruta_archivo.\n";
	echo "==== FIN DE COMPILACIÓN DE CONCEPTOS ====\n";
//	echo "</pre>";
?>