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
$query = "select chofer.id_emp, movil.id from chofer inner join movil on movil.id_chofer=chofer.id where chofer.login='$login' and chofer.pass='$pass' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$id_emp = $arr['id_emp'];
$id_movil = $arr['id'];

$query = "select mensaje, hora, DATE_FORMAT(fecha,'%d-%m-%Y') as fecha  from log where id_emp='$id_emp' and id_movil='$id_movil' ";
if($fecha!=""){
	$query.=" and fecha='$fecha'";
}
else{
	$query.=" and fecha='$HOY'";	
}
$query .="order by id desc";
$result = $mysqli->query($query);
$ret['result'] = "success";
$ret['registros'] = array();
while ($arr = $result->fetch_assoc()) {
	array_push($ret['registros'], $arr);
}
echo json_encode($ret);
