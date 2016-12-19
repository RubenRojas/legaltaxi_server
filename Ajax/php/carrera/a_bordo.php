<?php
if(strpos(getcwd(), "pruebas")){
	$baseDir = "/home4/alvarube/public_html/centraltaxi/pruebas/centraltaxi/funciones/";
	$url = "http://pruebas.legaltaxi.cl/legaltaxi/califica.php";
}
else if(is_dir("/home4/alvarube/public_html/centraltaxi/centraltaxi/funciones/")){
	$baseDir = "/home4/alvarube/public_html/centraltaxi/centraltaxi/funciones/";
	$url = "http://legaltaxi.cl/legaltaxi/califica.php";
}
else{
	$baseDir = "c:/wamp/www/centraltaxi/funciones/";
}
include($baseDir."conexion.php");

$id_carrera = $_GET['id_carrera'];

$log = get_campo("carrera", "log", $id_carrera, $mysqli);
$log.=$SEPARADOR_LOG.$AHORA."--Cliente aborda el Movil.";


update_dev("carrera",array("log"=>$log, "a_bordo"=>1), array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);
$url = "https://legaltaxi.cl/legaltaxi/califica.php";
$notification = new Pushpad\Notification(array(
  'body' => "Gracias por confiar en LegalTaxi. Por favor, califica nuestro servicio.", # max 90 characters
  'title' => "LegalTaxi", # optional, defaults to your project name, max 30 characters
  'target_url' => $url# optional, defaults to your project website
));

# deliver to a user
//$notification->deliver_to(strtoupper($_COOKIE['email']));