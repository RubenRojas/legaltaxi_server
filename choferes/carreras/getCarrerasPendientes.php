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
//obtener la empresa
/*
$query = "select id, id_emp from chofer where login='$login' and pass='$pass' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$id_emp = $arr['id_emp'];
$id_chofer = $arr['id'];
*/
$query ="select id, fecha, hora_envio from carrera where id_chofer=(select id from chofer where login='$login' and pass='$pass' limit 1) and terminadaChofer='1' and estado_carrera !=4 order by id desc limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();


$minutos_espera = 30; //son los minutos que esperara la app para refrescar la ultma carrera
$hora_actual_unix = strtotime(date("Y-m-d H:i:s"));
$hora_activacion_carrera = strtotime(date($arr['fecha']." ".$arr['hora_envio'].":00"));
$hora_limite_carrera=($minutos_espera * 60) + $hora_activacion_carrera;

$tiempo_restante = $hora_limite_carrera - $hora_actual_unix; //en segundos



if($tiempo_restante > 0){
	echo $arr['id'];
}
else{
	echo'no-data';
	
}
