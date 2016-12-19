<?php
if(strpos(getcwd(), "pruebas")){
	$baseDir = "/home4/alvarube/public_html/centraltaxi/pruebas/centraltaxi/funciones/";
}
else if(is_dir("/home4/alvarube/public_html/centraltaxi/centraltaxi/funciones/")){
	$baseDir = "/home4/alvarube/public_html/centraltaxi/centraltaxi/funciones/";
}
else{
	$baseDir = "c:/wamp/www/centraltaxi/funciones/";
}
ini_set("allow_url_fopen", 1);
include($baseDir."conexion.php");
extract($_GET);
/*
$ciudad
$lat
$lon
*/

$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lon."&sensor=true";
$json = file_get_contents($url);
$obj = json_decode($json, true);
$arr = $obj["results"][0]["address_components"];

foreach ($arr as $component) {
	
	
	$CITY = $component['long_name'];
	$query = "select empresa.razon_social, empresa_tiempo_atencion.valor as tiempo from empresa inner join empresa_tiempo_atencion on empresa_tiempo_atencion.id = empresa.tiempo_atencion where empresa.ciudad like '%$CITY%' and empresa.legaltaxi='SI' and empresa_tiempo_atencion.id!='4' ORDER BY RAND()";
	
	$result = $mysqli->query($query);
	$strJson = array();
	if($result->num_rows > 0){
		$strJson['result'] = "success";
		$strJson['ciudad'] = $CITY;
		$strJson['centrales'] = array();
		while ($arr = $result->fetch_assoc()) {
			array_push($strJson['centrales'], $arr);
		}
		break;
	}
	else{
		$strJson['result'] = "no-central";
	}		 
	
}
echo json_encode($strJson);

