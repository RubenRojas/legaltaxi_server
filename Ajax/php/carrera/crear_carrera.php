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
$email = $_COOKIE['email'];
$usuario = getUsuario($email, $mysqli);
 
	
	// Datos Carrera
	if($_POST['direccion']!=''){
		if($_POST['reserva']=='true'){ //reserva o compromiso
			$fecha				= $_POST['fecha'];
			$hora_activacion 	= $AHORA;
			$tipo_carrera 		= 4; //reserva
			$estado_carrera 	= 6; //pENDIENTE
			$planificacion 		= 2; // reserva 
			$hora_reserva		= str_replace(" ", "", $_POST['hora']);
			//$hora_reserva		= substr($_POST['hora'], 0, -3);
		}
		else{
			$fecha				= $HOY;
			$tipo_carrera 		= 5; //llamada
			$estado_carrera 	= 6; //pENDIENTE
			$planificacion 		= 1; //inmediata
			$hora_activacion 	= $AHORA;
		}


		$dir_inicio			= strtoupper($_POST['direccion']);
		

		//Log Inicial:
		$central = get_campo("empresa", "razon_social", $_POST['central'], $mysqli);
		$log = $AHORA."--Carrera Creada para <b>".$central."</b>.";

		

		//agregar carrera // agregar reserva
		$campos = 
		array(
		"id_emp"=>$_POST['central'], 
		"fecha"=>$fecha, 
		"dir_inicio"=>$dir_inicio,
		"tipo_carrera"=>$tipo_carrera, 
		"estado_carrera"=>$estado_carrera, 
		"planificacion"=>$planificacion, 
		"hora_activacion"=>$hora_activacion,
		"numero_direccion"=>$_POST['numero'],
		"nombre_referencia"=>$_POST['nombre_referencia'],
		"user_app_mail"=>$usuario['email'],
		"origen_movil"=>"WEB",
		"log"=>$log
		);

		
		$id_carrera = insert("carrera",$campos ,$mysqli);

		if($planificacion == 2){ //si hay reserva
			$campos = array("id_carrera"=>$id_carrera, "id_emp"=>$_POST['central'], "fecha"=>$fecha, "hora"=>$hora_reserva);
			insert("reserva", $campos, $mysqli);	
		}		
		update("empresa",array("last_query"=>$NOW), array("id"=>$_POST['central']), array("limit"=>"1"), $mysqli);
	}

	//echo $id_carrera;

