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
$json_arr['carrera'] = get_ultima_carrera($correo, $mysqli);
if($json_arr['carrera']['id']!= "" and $json_arr['carrera']['a_bordo']==0){
	$json_arr['result'] = "success";	
}
else{
	$json_arr['result'] = "no-data";
}
//echo'<hr>'.var_dump($json_arr['carrera']).'<hr>';


echo json_encode($json_arr);