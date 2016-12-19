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

$query = "select * from carrera where id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

$log = explode($SEPARADOR_LOG, $arr['log']);
$log_enviado = "";
foreach ($log as $entrada) {
	$data = explode("--", $entrada);
	$log_enviado.="<li><span>".$data[0]."</span>: ".$data[1]."</li>";
}
$codigo_movil = get_campo("movil", "codigo", $arr['id_movil'], $mysqli);
$movil = select("movil", array("codigo, marca, modelo, color, patente"), array("id"=>$arr['id_movil']), array("limit"=>"1"), $mysqli);
$chofer = get_campo("chofer", "nombre", $arr['id_chofer'], $mysqli);
$arr['log'] = $log_enviado;
$arr['chofer'] = $chofer;
$arr['movil'] = $movil;
echo json_encode($arr);