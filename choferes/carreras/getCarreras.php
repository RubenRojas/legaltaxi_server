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
carrera.hora_activacion,
carrera_calificacion.calif as calificacion_chofer
from carrera left join carrera_calificacion on carrera_calificacion.id_carrera=carrera.id and carrera_calificacion.item='CHOFER' where carrera.id_chofer='$id_chofer' and carrera.estado_carrera='3' order by id desc limit 15";
$result = $mysqli->query($query);
$ret = array();
$ret['result'] = "success";
$ret['carreras'] = array();
while ($arr = $result->fetch_assoc()) {
	if($arr['calificacion_chofer']=='') {$arr['calificacion_chofer']=0;}
	array_push($ret['carreras'], $arr);
}
$query = "select 
	chofer.login,
	chofer.pass,
	chofer.nombre,
	chofer.fono,
	chofer.id_emp,
	chofer.codigo as codigoChofer,
	empresa.razon_social as nombreEmp,
	chofer.id_emp,
	movil.estado_turno,
	movil.codigo as codigoMovil,
	movil.id as id_movil
	from chofer 
	inner join empresa on chofer.id_emp = empresa.id
	left join movil on movil.id_chofer = chofer.id
	where 
	chofer.login='$login' and
	chofer.pass='$pass' limit 1";
	$result = $mysqli->query($query);
	$usuario = $result->fetch_assoc();
	if($usuario['estado_turno']==''){ $usuario['estado_turno']="4";}
	if($usuario['codigoMovil']==''){ $usuario['codigoMovil']="-";}
	if($usuario['id_movil']==''){ $usuario['id_movil']="-";}
	$ret['user'] = $usuario;
	$query = "select orden from empresa_posicion_fichero where id_emp='$usuario[id_emp]' limit 1";
	$result = $mysqli->query($query);
	$arr = $result->fetch_assoc();
	$json = json_decode($arr['orden'], true);
	if($json[$id_movil]==''){
		$ret['user']['posFichero']="--";
	}
	else {
		$ret['user']['posFichero'] = $json[$id_movil];
	}
echo json_encode($ret);
