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

//login, pass
//obtener la id, empresa
$query = "select id, id_emp from chofer where login='$login' and pass='$pass' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$id_emp = $arr['id_emp'];
$id_chofer = $arr['id'];
$query = "select concat(carrera.dir_inicio, ' ', carrera.numero_direccion) as dir_inicio,
carrera.id,
carrera.hora_activacion as hora,
DATE_FORMAT(carrera.fecha,'%d-%m-%Y') as fecha,
carrera.nombre_referencia as cliente,
carrera.valor_cobrado
from carrera
where 
carrera.id_chofer='$id_chofer' and carrera.id_emp='$id_emp' and carrera.estado_carrera='3'";

if($fecha!=""){
	$query.=" and fecha='$fecha'";
}
else{
	$query.=" and fecha='$HOY'";	
}
$query.=" order by id desc";
$result = $mysqli->query($query);

//valores y cantidad de carreras

$query = "select count(carrera.id) as cantidad, sum(carrera.valor_cobrado) as valorTotal
from carrera
where 
carrera.id_chofer='$id_chofer' and carrera.id_emp='$id_emp' and carrera.estado_carrera='3'";

if($fecha!=""){
	$query.=" and fecha='$fecha'";
}
else{
	$query.=" and fecha='$HOY'";	
}

$result2 = $mysqli->query($query);
$arr2 = $result2->fetch_assoc();


if($arr2['valorTotal'] == "") { $arr2['valorTotal'] = 0; }

$ret = array();
$ret['result'] = "success";
$ret['cantidad'] = $arr2['cantidad'];
$ret['valorTotal'] = $arr2['valorTotal'];
$ret['registros'] = array();
while ($arr = $result->fetch_assoc()) {
	if($arr['cliente']==''){ $arr['cliente']='CLIENTE NORMAL'; }
	array_push($ret['registros'], $arr);
}

echo json_encode($ret);
