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
$query = "select 
carrera.id_emp, 
carrera.id_chofer, 
carrera.id_movil, 
carrera.user_app_mail, user_app.token from carrera
left join user_app on user_app.email = carrera.user_app_mail
 where id='$id_carrera' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

$OP = get_opciones($arr['id_emp'], $mysqli);

if($OP['LEGAL_PAS_AUSENTE']=="SI"){
	$movil = select("movil", array("codigo, anterior"), array("id"=>$arr['id_movil']), array("limit"=>"1"), $mysqli);
	update("movil", array("estado_turno"=>"1", "t_cambio"=>$movil['anterior']),array("id"=>$arr['id_movil']), array("limit"=>"1"), $mysqli);
	update("carrera", array("estado_carrera"=>"4"), array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);
	update("empresa",array("last_query"=>$NOW), array("id"=>$arr['id_emp']), array("limit"=>"1"), $mysqli);
	insert("log", array("id_emp"=>$arr['id_emp'], "fecha"=>$HOY, "hora"=>$AHORA,  "id_movil"=>$arr['id_movil'], "mensaje"=>"CARRERA SIN PASAJERO (N°".$id_carrera.")"), $mysqli);
	insert("notificaciones", array("id_emp"=>$arr['id_emp'], "mensaje"=>"<b>Movil ".$movil['codigo']."</b> no encontró al pasajero de la carrera n°".$id_carrera, "estado"=>"ACTIVA", "origen"=>"INICIO_CHOFER"), $mysqli);


	if($arr['token'] != null){		
		$not = new NotificationSender($arr['token'], $id_carrera, "2");
		$not->enviaActualizacionCarrera("carrera_cancelada");
		$query = "update carrera_estado_legaltaxi set estado='6' where id_carrera='$id'";
		$result = $mysqli->query($query);
	}
	echo "true";
}
else{
	echo "La central no permite usar esta opción.";
}




