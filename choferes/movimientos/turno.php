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

//login, pass, accion

//login, pass, accion


$query ="select movil.id_emp, movil.id, chofer.id as id_chofer from chofer inner join movil on movil.id_chofer = chofer.id where chofer.login='$login' and chofer.pass='$pass' limit 1";
$result = $mysqli->query($query);
$data = $result->fetch_assoc();
$id_chofer = $data['id_chofer'];

update("chofer",array("token"=>""), array("id"=>$id_chofer), array("limit"=>"1"), $mysqli);

$estado_turno= 4;
$movil = select("movil", array("id, estado_turno, codigo, id_turno"), array("id"=>$data['id'],"id_emp"=>$data['id_emp']), array("limit"=>"1"), $mysqli);	
$id_turno = $movil['id_turno'];
$query = "update movil_turno set fecha_termino='$HOY', hora_termino='$AHORA' where id='$id_turno' limit 1";
$result = $mysqli->query($query);
$query = "update movil set estado_turno='4', t_cambio='$NOW', id_turno='', pendiente='NO' where id='$movil[id]' limit 1";
$result = $mysqli->query($query);

/*$query = "update movil set id_chofer='' where id_chofer='$id_chofer'";
$result = $mysqli->query($query);
*/



insert("log", array("id_emp"=>$data['id_emp'], "fecha"=>$HOY, "hora"=>$AHORA,  "id_movil"=>$data['id'], "mensaje"=>"TERMINA TURNO TELEFONO"), $mysqli);
insert("notificaciones", array("id_emp"=>$data['id_emp'], "mensaje"=>"<b>Movil ".$movil['codigo']."</b> ha finalizado turno", "estado"=>"ACTIVA", "origen"=>"INICIO_CHOFER"), $mysqli);
update("empresa",array("last_query"=>$NOW), array("id"=>$data['id_emp']), array("limit"=>"1"), $mysqli);
echo "true";
	
