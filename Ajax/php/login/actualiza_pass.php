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
$pass_actual = strtoupper($pass_actual);
$pass = strtoupper($pass);
$pass2 = strtoupper($pass2);

$pass_ant = select("user_app", array("pass"), array("email"=>$_COOKIE['email']), array("limit"=>"1"), $mysqli);


if($pass == $pass2 and $pass_actual == $pass_ant['pass']){
	update("user_app",array("pass"=>$pass), array("email"=>$_COOKIE['email']), array("limit"=>"1"), $mysqli);
	$_SESSION['msg'] = "Contraseña Actualizada correctamente.";
	header("location: /legaltaxi/dash.php");
}
else{
	$_SESSION['error'] = "Contraseñas ingresadas no coinciden.";
	header("location: /legaltaxi/actualizaPass.php");
}
