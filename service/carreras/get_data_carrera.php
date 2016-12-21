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
$json_arr = array();
$json_arr['result'] = "success";
$json_arr['carrera'] = get_detalle_carrera($id_carrera, $mysqli);
if($json_arr['carrera']['imgChofer'] == ""){
	$json_arr['carrera']['imgChofer'] = "https://www.legaltaxi.cl/legaltaxi/assets/img/appicon_2.png";
}


echo json_encode($json_arr);