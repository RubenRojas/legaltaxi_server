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


$carrera = select("carrera", array("id", "id_movil", "id_emp"), array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);
$estado_carrera = 4; //negativa	
$campos = array("estado_carrera"=>$estado_carrera, "a_bordo"=>"1");
update_dev("carrera", $campos, array("id"=>$carrera['id']), array("limit"=>"1"), $mysqli);

$anterior = get_campo("movil", "anterior", $carrera['id_movil'], $mysqli);
update_dev("movil", array("estado_turno"=>"1", "t_cambio"=>$anterior), array("id"=>$carrera['id_movil']), array("limit"=>"1"), $mysqli);

$query ="update carrera_estado_legaltaxi set estado='5' where id_carrera='$id_carrera'";
$result = $mysqli->query($query);



$campos = array("id_razon_cancela"=>"5", "hora"=>$AHORA, "id_carrera"=>$carrera['id']);
insert_dev("carrera_cancelacion", $campos, $mysqli); 
insert_dev("notificaciones", array("id_emp"=>$carrera['id_emp'], "mensaje"=>"Carrera N° <b>".$carrera['id']."</b> ha quedado negativa","estado"=>"ACTIVA", "origen"=>"legaltaxi", "carrera"=>$carrera['id']), $mysqli);		
update_dev("empresa",array("last_query"=>$NOW), array("id"=>$carrera['id_emp']), array("limit"=>"1"), $mysqli);

$query ="select chofer.token from movil inner join chofer on chofer.id = movil.id_chofer where movil.id='$carrera[id_movil]' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$token = $arr['token'];
$not = new NotificationSenderChofer($token, $id_carrera, $carrera['estado_carrera']);
$not->notificacionEspecial("carrera_cancelada", "Carrera Cancelada", "El usuario ha cancelado la carrera.");