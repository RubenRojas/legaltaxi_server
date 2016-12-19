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

$calificaciones = array("chofer"=>$chofer, "tiempos"=>$tiempos, "general"=>$general, "taxi"=>$taxi);
foreach ($calificaciones as $key => $value) {
	if($value=="undefined"){ $value = 0; }
	$arr = array("id_carrera"=>$id_carrera, "user_app_mail"=>$_COOKIE['email'], "item"=>$key, "calif"=>$value);
	insert_dev("carrera_calificacion", $arr, $mysqli);
}