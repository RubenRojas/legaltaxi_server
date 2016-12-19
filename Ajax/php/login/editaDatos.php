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
/*$pass = strtoupper($pass);
$pass2 = strtoupper($pass2);
update_dev("user_app",array("pass"=>$pass), array("email"=>$_COOKIE['email']), array("limit"=>"1"), $mysqli);
*/

$campos = array("nombre"=>strtoupper($nombre), "fono"=>strtoupper($fono), "direccion"=>strtoupper($direccion), "numero_casa"=>strtoupper($numero), "ciudad"=>strtoupper($ciudad), "central"=>strtoupper($central));
update("user_app",$campos, array("email"=>$_COOKIE['email']), array("limit"=>"1"), $mysqli);	


$_SESSION['msg'] = "Datos Actualizados correctamente.";
header("location: /legaltaxi/dash.php");