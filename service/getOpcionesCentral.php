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
	/*
	$query ="update carrera_estado_legaltaxi set estado='3' where id_carrera='$id_carrera'";
	$result = $mysqli->query($query);
	*/

$query = "SELECT parametro.id, parametro.nombre, parametro.valor FROM `parametro` join carrera on carrera.id_emp = parametro.id_emp where carrera.id='$id_carrera' and parametro.nombre in('LEGAL_VALOR_PD', 'LEGAL_CANT_PD', 'LEGAL_VALOR_UTD', 'LEGAL_CANT_UTD', 'LEGAL_VALOR_BB', 'LEGAL_TIEMPO_BAJADA', 'LEGAL_METROS_BAJADA' , 'LEGAL_USO_TAXIMETRO')";
$result = $mysqli->query($query);

$ret = array();
$ret['result'] = "success";
$ret['data'] = array();
while ($arr = $result->fetch_assoc()) {
	
	$ret['data'][$arr['nombre']] = $arr['valor'];
	
}

echo json_encode($ret);