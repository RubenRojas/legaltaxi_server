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

$query = "select empresa_tiempo_atencion.valor, empresa_tiempo_atencion.id from empresa_tiempo_atencion inner join empresa on empresa.tiempo_atencion = empresa_tiempo_atencion.id where empresa.id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
echo json_encode($arr);