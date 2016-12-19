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
//tokenCl
//tokenChofer 	 
if($tokenChofer=="null"){
	$query = "select chofer.token from chofer inner join carrera on carrera.id_chofer = chofer.id where carrera.id = '$id_carrera'";	
	$result = $mysqli->query($query);
	$arr = $result->fetch_assoc();
	$tokenChofer = $arr['token'];
}

$not = new NotificationSenderChofer($tokenChofer, "", "");
$not->aBordoCliente($confirmacion);