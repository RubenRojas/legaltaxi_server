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
// id_carrera

extract($_GET);
$query = "select id_emp, id_chofer, id_movil, user_app_mail from carrera where id='$id_carrera' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

$OP = get_opciones($arr['id_emp'], $mysqli);


if($OP["LEGAL_RECHAZA_CARR"]=="SI" or $arr['user_app_mail']!=""){
	
	$query = "update carrera set id_chofer='', id_movil='', hora_envio='', estado_carrera='6', valor_cobrado='' where id='$id_carrera' limit 1";
	$result = $mysqli->query($query);
	$movil = select("movil", array("codigo, anterior"), array("id"=>$arr['id_movil']), array("limit"=>"1"), $mysqli);

	insert("log", array("id_emp"=>$arr['id_emp'], "fecha"=>$HOY, "hora"=>$AHORA,  "id_movil"=>$arr['id_movil'], "mensaje"=>"RECHAZA CARRERA N°".$id_carrera), $mysqli);
	insert("notificaciones", array("id_emp"=>$arr['id_emp'], "mensaje"=>"<b>Movil ".$movil['codigo']."</b> rechazo la carrera n°".$id_carrera, "estado"=>"ACTIVA", "origen"=>"INICIO_CHOFER"), $mysqli);

	update("empresa",array("last_query"=>$NOW), array("id"=>$arr['id_emp']), array("limit"=>"1"), $mysqli);
	echo "true";

	update("carrera_estado_legaltaxi",array("estado"=>"1"), array("id_carrera"=>$id_carrera), array("limit"=>"1"), $mysqli);

	if($OP['MANTIENE_LUGAR_SI_RECHAZA']=="SI"){
		update("movil", array("estado_turno"=>"1", "t_cambio"=>$movil['anterior']),array("id"=>$arr['id_movil']), array("limit"=>"1"), $mysqli);
	}
	else{
		update("movil",array("estado_turno"=>"1"), array("id"=>$arr['id_movil']), array("limit"=>"1"), $mysqli);
	}
}
else{
	echo'La central no admite el rechazo de carreras.';
}