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
// id_carrera



extract($_GET);

	$not = new NotificationSender($tokenCl, $id_carrera, "2");
	$not->send();
	update("carrera_estado_legaltaxi", array("estado"=>"2"), array("id_carrera"=>$id_carrera), array("limit"=>"1"), $mysqli);

echo 'true';