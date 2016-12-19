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


update("carrera",array("a_bordo"=>"1"), array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);
$query ="update carrera_estado_legaltaxi set estado='3' where id_carrera='$id_carrera'";
$result = $mysqli->query($query);