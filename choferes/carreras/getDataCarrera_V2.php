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
//id_carrera, tipo



$query="
select 
chofer.token as tokenChofer, 
user_app.fono,
carrera.id, 
carrera.id as id_carrera,
carrera.id_emp,
user_app.token as tokenCl,   
carrera.nombre_referencia, 
carrera.dir_inicio,
carrera.numero_direccion, 
carrera.dir_destino,
carrera.valor_cobrado as valorCarrera,
carrera.fono_referencia as telefono, 
carrera_lat_lon.lat as iLat, 
carrera_lat_lon.lon as iLon,
carrera_lat_lon_destino.lat as fLat, 
carrera_lat_lon_destino.lon as fLon
 from carrera
inner join chofer on chofer.id = carrera.id_chofer 
left join user_app on carrera.user_app_mail = user_app.email and user_app_mail<>''
left join carrera_lat_lon on carrera_lat_lon.id_carrera = carrera.id
left join carrera_lat_lon_destino on carrera_lat_lon_destino.id_carrera = carrera.id
where carrera.id='$id_carrera'";

$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$OP = get_opciones($arr['id_emp'], $mysqli);

if($arr['nombre_referencia']==''){ $arr['nombre_referencia'] = "CLIENTE NORMAL" ;}
if($arr['telefono'] == ""){
	$arr['telefono'] = $arr['fono'];
}

if($arr['telefono'] == ""){
	$arr['telefono'] = "";
}
if($tipo=="destino"){
	if($arr['dir_destino']==''){
		$arr['dir_inicio'] = "NO DISPONIBLE";
	}
	else{
		$arr['dir_inicio'] = $arr['dir_destino'];	
	}	
}
else{
	$arr['dir_inicio'] = $arr['dir_inicio']." ".$arr['numero_direccion'];	
}
if($OP['FORMA_COBRO'] == "2"){
	$arr['valor'] = $OP['MONTO_PACTADO'];
}
else{
	$arr['valor'] = "no";
}

$arr['ACCION_POST_20_SEG'] = $OP['ACCION_POST_20_SEG'];


echo json_encode($arr);