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

extract($_POST);
if($email=='' or $pass==''){
	$_SESSION['error'] = "Debes Ingresar un correo o una contraseña";
	header("location: /legaltaxi/index.php");
}
$us = existe_mail($email, $mysqli);
if($us['email']!=''){
	$usuario = valida_login($email, $pass, $mysqli);
	if($usuario['email']!=''){ //usuario correcto
		setcookie("email", strtoupper($email), time()+259200,"/",""); //cookie que dura 3 días
		header("location: /legaltaxi/dash.php");
	}
	else{ //existe un registro con el correo, pero la pass esta mal
		$_SESSION['error'] = "Correo o contraseña incorrectos.";
		header("location: /legaltaxi/index.php");
	}
}
else{ //no existe un registro para ese correo, se debe crear
	$_POST['email'] = strtoupper($_POST['email']);
	insert("user_app", $_POST, $mysqli);
	header("location: /legaltaxi/completaDatos.php");
	setcookie("email", strtoupper($email), time()+259200,"/",""); //cookie que dura 3 días
}

