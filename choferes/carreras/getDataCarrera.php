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
if($tipo=="destino"){
	$query = "select 
	carrera.nombre_referencia,
	carrera.id_emp,
	carrera.fono_referencia,
	carrera.dir_destino,
	carrera.numero_direccion,
	user_app.fono,
	carrera_lat_lon_destino.lat,
	carrera_lat_lon_destino.lon 
	from carrera 
	left join user_app on carrera.user_app_mail = user_app.email and user_app_mail<>''
	left join carrera_lat_lon_destino on carrera_lat_lon_destino.id_carrera = carrera.id 
	where carrera.id = '$id_carrera'";
}
else{
	$query = "select 
	carrera.nombre_referencia,
	carrera.id_emp,
	carrera.fono_referencia,
	carrera.dir_inicio,
	carrera.numero_direccion,
	user_app.fono,
	carrera_lat_lon.lat,
	carrera_lat_lon.lon 
	from carrera 
	left join user_app on carrera.user_app_mail = user_app.email and user_app_mail<>''
	left join carrera_lat_lon on carrera_lat_lon.id_carrera = carrera.id 
	where carrera.id = '$id_carrera'";
}
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$OP = get_opciones($arr['id_emp'], $mysqli);
if($arr['nombre_referencia']==''){ $arr['nombre_referencia'] = "CLIENTE NORMAL" ;}
if($arr['fono']==''){ 
	if($arr['fono_referencia']!=""){
		$arr['fono'] = $arr['fono_referencia'] ;	
	}
	else{
		$arr['fono'] = "SIN FONO" ;
	}
}
if($arr['lat']==''){ $arr['lat'] = "NO_DATA" ;}
if($arr['lon']==''){ $arr['lon'] = "NO_DATA" ;}
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
echo json_encode($arr);