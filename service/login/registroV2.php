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

foreach ($_GET as $key => $value) {
	$_GET[$key] = strtoupper($value);
}
extract($_GET);

//email, origen, nombre
$query = "select fono, telefono_valido from user_app where email='$email' limit 1";
$result = $mysqli->query($query);

if($result->num_rows>0){ //el usuario existe. Tengo que validar sus datos
	$usuario = $result->fetch_assoc();
	update("user_app",array("email"=>$email, "origen"=>$origen), array("id"=>$usuario['id']), array("limit"=>"1"), $mysqli); //actualizo el origen
	if($usuario['telefono_valido']=="NO"){
		echo'ValidaTelefono'; //activity validaTelefono
	}
	else{
		echo $usuario['fono']." ";
	}
}
else{ //el usuario no existe. Tengo que registrarlo
	insert("user_app", $_GET, $mysqli);
	echo'ValidaTelefono'; //activity validaTelefono
}