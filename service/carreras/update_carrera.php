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


$email 			= strtoupper(str_replace("<>", " ", $_GET['correo']));
$direccion 		= strtoupper(str_replace("<>", " ", $_GET['direccion']));
$numero_casa 	= strtoupper(str_replace("<>", " ", $_GET['numero_casa']));
$nombreCentral 	= strtoupper(str_replace("<>", " ", $_GET['nombreCentral']));
$nombre 		= strtoupper(str_replace("<>", " ", $_GET['nombre']));
$referencia 	= strtoupper(str_replace("<>", " ", $_GET['referencia']));


$query ="select * from empresa where razon_social like '%$nombreCentral%' limit 1";
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
		
		$dir_inicio			= strtoupper($direccion);
		

		//Log Inicial:
		$log = $AHORA."--Carrera actualizada para <b>".$nombreCentral."</b>.";

		

		//agregar carrera // agregar reserva
		$campos = 
		array(
		"id_emp"=>$empresa['id'], 
		"fecha"=>$fecha, 
		"dir_inicio"=>$dir_inicio,
		"tipo_carrera"=>$tipo_carrera, 
		"estado_carrera"=>$estado_carrera, 
		"planificacion"=>$planificacion, 
		"hora_activacion"=>$hora_activacion,
		"numero_direccion"=>$numero_casa,
		"nombre_referencia"=>$nombre,
		"user_app_mail"=>$email,
		"comentario"=>$referencia,
		"origen_movil"=>"APP",
		"log"=>$log
		);
		//echo'<hr>'.var_dump($campos).'<hr>';
		
		//echo'<hr>'.var_dump($campos).'<hr>';
		
		update("carrera",$campos, array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);
		
		/*
		ENVIAR NOTIFICACION
		*/

		update("empresa",array("last_query"=>$NOW), array("id"=>$empresa['id']), array("limit"=>"1"), $mysqli);
		echo $id_carrera;
	}
	else{
		echo 'false';
	}
update("carrera",array("id_emp"=>""), array("id"=>$id), array("limit"=>"1"), $mysqli);