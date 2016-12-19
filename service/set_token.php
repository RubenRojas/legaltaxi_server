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
$email = $_GET['correo'];
$token = $_GET['token'];

$query ="update user_app set token='$token' where email = '$email' limit 1";
echo'<hr>'.$query.'<hr>';
if($token!="null"){

$result = $mysqli->query($query);	
}
