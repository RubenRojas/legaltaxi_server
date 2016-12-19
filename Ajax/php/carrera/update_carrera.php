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

extract($_POST);
$central = get_campo("empresa", "razon_social", $_POST['central'], $mysqli);
$log = get_campo("carrera", "log", $_POST['id'], $mysqli);
$log .= $SEPARADOR_LOG.$AHORA."--Carrera actualizada para <b>".$central."</b>.";
$id_emp_ant = get_campo("carrera", "id_emp", $id, $mysqli);
update_dev("carrera",array("dir_inicio"=>$direccion, "numero_direccion"=>$numero, "nombre_referencia"=>$nombre, "id_emp"=>$_POST['central'], "log"=>$log, "calificado"=>0), array("id"=>$id), array("limit"=>"1"), $mysqli);

$hora_reserva	= str_replace(" ", "", $_POST['hora']);
if($reserva != "false"){ //si hay reserva
	update_dev("carrera",array("planificacion"=>"2"), array("id"=>$id), array("limit"=>"1"), $mysqli);
	$campos = array("id_carrera"=>$id, "id_emp"=>$_POST['central'], "fecha"=>$fecha, "hora"=>$hora_reserva);
	insert("reserva", $campos, $mysqli);	
}	
update_dev("empresa",array("last_query"=>$NOW), array("id"=>$id_emp_ant), array("limit"=>"1"), $mysqli);	
update_dev("empresa",array("last_query"=>$NOW), array("id"=>$_POST['central']), array("limit"=>"1"), $mysqli);
