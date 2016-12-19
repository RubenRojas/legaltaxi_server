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

/*
id_Carrera
c_chofer
c_taxi
c_central
user_app_mail
*/
insert("carrera_calificacion", array("id_carrera"=>$id_carrera, "user_app_mail"=>$user_app_mail, "item"=>"CHOFER", "calif"=>$c_chofer), $mysqli);
insert("carrera_calificacion", array("id_carrera"=>$id_carrera, "user_app_mail"=>$user_app_mail, "item"=>"TAXI", "calif"=>$c_taxi), $mysqli);
insert("carrera_calificacion", array("id_carrera"=>$id_carrera, "user_app_mail"=>$user_app_mail, "item"=>"GENERAL", "calif"=>$c_central), $mysqli);

$query = "insert into carrera_lat_lon_termino(id_carrera, lat, long) values('$id_carrera', '$LAT', '$LON')";
$result = $mysqli->query($query);

$query = "insert into carrera_valor_taximetro_referencia(id_carrera, valor_taximetro) values('$id_carrera', '$valor_taximetro')";
$result = $mysqli->query($query);

update("carrera",array("calificado"=>"1"), array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);
$query ="update carrera_estado_legaltaxi set estado='6' where id_carrera='$id_carrera'";
$result = $mysqli->query($query);