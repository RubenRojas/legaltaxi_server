<?php
if(strpos(getcwd(), "pruebas")){
	$baseDir = 
"/home4/alvarube/public_html/centraltaxi/pruebas/centraltaxi/funciones/";
}
else if(is_dir("/home4/alvarube/public_html/centraltaxi/centraltaxi/funciones/")){
	$baseDir = "/home4/alvarube/public_html/centraltaxi/centraltaxi/funciones/";
}
else{
	$baseDir = "c:/wamp/www/centraltaxi/funciones/";
}
include($baseDir."conexion.php");
extract($_GET);


$query ="update chofer set token='$token' where login = '$login' and pass='$pass' limit 1";

$result = $mysqli->query($query);