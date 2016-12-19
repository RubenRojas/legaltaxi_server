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
$email = $_COOKIE['email'];
$usuario = getUsuario($email, $mysqli);
$query = "update user_app set suscrito=1 where email='$email' limit 1";	
$result = $mysqli->query($query);
$url = Pushpad\Pushpad::path_for(strtoupper($_COOKIE['email']));
header("location: ".$url);