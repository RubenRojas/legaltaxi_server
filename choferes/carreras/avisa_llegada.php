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
// id_carrera

extract($_GET);

$query = "select user_app.token from carrera inner join  user_app on user_app.email = carrera.user_app_mail where carrera.id='$id_carrera' limit 1";

$result = $mysqli->query($query);
if($result->num_rows > 0){
	$arr = $result->fetch_assoc();
	$token = $arr['token'];
	$not = new NotificationSender($token, $id_carrera, "6");
	$not->mensaje("Chofer en Destino", "El chofer se encuentra en la direccion indicada. Por favor acercarse.");
	echo "true";
}
else{
	echo "false";
}

