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
$carrera = select("carrera", array("id_emp"), array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);

update_dev("carrera",array("id_emp"=>""), array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);
update("empresa",array("last_query"=>$NOW), array("id"=>$carrera['id_emp']), array("limit"=>"1"), $mysqli);