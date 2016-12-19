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
include($baseDir."conexion.php");

extract($_GET);
$carreras = get_carreras_dash_movil_app($correo, $mysqli);
$json_arr = array();
$json_arr['result'] = "success";
$json_arr['carreras'] = array();
while($arr = $carreras->fetch_assoc()){
	array_push($json_arr['carreras'], $arr);
}

echo json_encode($json_arr);