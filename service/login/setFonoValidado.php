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
$query = "select email from user_app where fono='$fono' limit 1";
$result = $mysqli->query($query);
if($result->num_rows > 0){
	echo'El numero ingresado se encuentra registrado en nuestro sistema. Por favor intenta con otro.';
}
else{
	update("user_app", array("fono"=>$fono, "telefono_valido"=>"SI"), array("email"=>$email), array("limit"=>"1"), $mysqli);	
	echo'true';
}
