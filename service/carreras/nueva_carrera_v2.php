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


foreach ($_GET as $nombre => $value) {
	//echo'<hr>'.$nombre.'--->  '.strtoupper(str_replace("<>", " ", $value)).'<br>';
	$_GET[$nombre] = strtoupper(str_replace("<>", " ", $value));
}
extract($_GET);


$query ="select id from empresa where razon_social like '%$nombreCentral%' limit 1";
//echo'<hr>'.$query.'<hr>';
$result = $mysqli->query($query);
$empresa = $result->fetch_assoc();

//echo'<hr>'.var_dump($empresa['id']).'<hr>';
	// Datos Carrera
	if($_GET['direccion']!=''){
		$fecha				= $HOY;
		$tipo_carrera 		= 5; //llamada
		$estado_carrera 	= 6; //pENDIENTE
		$planificacion 		= 1; //inmediata
		$hora_activacion 	= $AHORA;		
		$dir_inicio			= $direccion." ".$num_casa;
		$dir_destino		= $direccionDestino." ".$num_casa_destino;

		

		//Log Inicial:
		$log = $AHORA."--Carrera Creada para <b>".$nombreCentral."</b>.";

		

		//agregar carrera // agregar reserva
		$campos = 
		array(
		"id_emp"=>$empresa['id'], 
		"fecha"=>$fecha, 
		"dir_inicio"=>$dir_inicio,
		"dir_destino"=>$direccionDestino." ".$num_casa_destino,
		"tipo_carrera"=>$tipo_carrera, 
		"estado_carrera"=>$estado_carrera, 
		"planificacion"=>$planificacion, 
		"hora_activacion"=>$hora_activacion,
		"numero_direccion"=>$numero_casa,
		"nombre_referencia"=>$nombreCl,
		"user_app_mail"=>$correo,
		"comentario"=>$datoExtra,
		"origen_movil"=>"APP",
		"terminadaChofer"=>"1",
		"log"=>$log
		);
		//echo'<hr>'.var_dump($campos).'<hr>';
		
		//echo'<hr>'.var_dump($campos).'<hr>';
		$id_carrera = insert("carrera",$campos ,$mysqli);
		$query = "insert into carrera_lat_lon(id_carrera, lat,lon)values('$id_carrera', '$iLat', '$iLon')";
		$result = $mysqli->query($query);
		$query = "insert into carrera_lat_lon_destino(id_carrera, lat,lon)values('$id_carrera', '$fLat', '$fLon')";
		$result = $mysqli->query($query);
		$query = "insert into carrera_estado_legaltaxi(id_carrera, estado)values('$id_carrera', '1')";
		$result = $mysqli->query($query);
		/*
		ENVIAR NOTIFICACION
		*/
		$campos = array("id_carrera"=>$id_carrera,"lat"=>$lat, "lon"=>$lon);
		insert("carrera_lat_lon", $campos, $mysqli);
		insert("notificaciones", array("id_emp"=>$empresa['id'], "mensaje"=>"<b>Nueva carrera desde LEGALTAXI</b>", "estado"=>"ACTIVA" , "origen"=>"INICIO_CHOFER"), $mysqli);		
		update("empresa",array("last_query"=>$NOW), array("id"=>$empresa['id']), array("limit"=>"1"), $mysqli);
		echo $id_carrera;
	}
	else{
		echo 'false';
	}

	add_notifications("NUEVA CARRERA LEGALTAXI!!", $id_carrera, $empresa['id']);



