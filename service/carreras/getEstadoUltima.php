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


$query = "select 
carrera_estado_legaltaxi.estado,
carrera_estado_legaltaxi.id_carrera 
from carrera_estado_legaltaxi 
inner join carrera on carrera_estado_legaltaxi.id_carrera = carrera.id

where 
carrera.user_app_mail='$correo' and carrera_estado_legaltaxi.id_carrera = carrera.id
order by carrera.id desc limit 1;";


$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
echo json_encode($arr);
