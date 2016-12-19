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

$query = "select chofer.id, movil.codigo from chofer  inner join movil on movil.id_chofer = chofer.id where login='$login' and pass ='$pass' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

$path = "/home4/alvarube/maps/".$arr['id'];
mkdir($path);
$path_file = $path."/ubicacion.txt";

$myfile = fopen($path_file, "w+") or die("Unable to open file!");
$txt = $lat.",".$lon."---".$arr['id']."---".$arr['codigo'];
fwrite($myfile, $txt);
fclose($myfile);
