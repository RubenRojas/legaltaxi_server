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

$query ="select id_emp from chofer where login='$login' and pass='$pass' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$id_emp = $arr['id_emp'];

$query = "select * from empresa_tarifario where id_emp='$id_emp' order by destino asc";
$result = $mysqli->query($query);


$ret['result'] = "success";
$ret['registros'] = array();
while ($arr = $result->fetch_assoc()) {
	array_push($ret['registros'], $arr);
}
echo json_encode($ret);
