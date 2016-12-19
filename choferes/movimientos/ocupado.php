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

$query ="select movil.id_emp, movil.id from chofer inner join movil on movil.id_chofer = chofer.id where chofer.login='$login' and chofer.pass='$pass' limit 1";
$result = $mysqli->query($query);
$data = $result->fetch_assoc();



if($accion=='inicia'){
	$estado_turno= 2;	
	$OP = get_opciones($data['id_emp'], $mysqli);
	$movil = select("movil", array("id, estado_turno, codigo"), array("id"=>$data['id'], "id_emp"=>$data['id_emp']), array("limit"=>"1"), $mysqli);	
	
	if($OP['LEGAL_ESTADO_OCUPADO']=='SI'){
		
		$query = "update movil set estado_turno='2' where id='$movil[id]' limit 1";
		$result = $mysqli->query($query);
		insert("log", array("id_emp"=>$data['id_emp'], "fecha"=>$HOY, "hora"=>$AHORA,  "id_movil"=>$data['id'], "mensaje"=>"CAMBIA A OCUPADO TELEFONO"), $mysqli);
		insert("notificaciones", array("id_emp"=>$data['id_emp'], "mensaje"=>"<b>Movil ".$movil['codigo']."</b> se encuentra ocupado.", "estado"=>"ACTIVA", "origen"=>"INICIO_CHOFER"), $mysqli);
		update("empresa",array("last_query"=>$NOW), array("id"=>$data['id_emp']), array("limit"=>"1"), $mysqli);
		echo 'true';
	}
	else{
		echo'La central no autoriza el uso del estado "OCUPADO"';
	}

}
if($accion=='termina'){
	$movil = select("movil", array("id, estado_turno, codigo"), array("id"=>$data['id'], "id_emp"=>$data['id_emp']), array("limit"=>"1"), $mysqli);	
	
		$estado_turno= 1;	
		$query = "update movil set estado_turno='1' where id='$movil[id]' limit 1";
		$result = $mysqli->query($query);
		insert("log", array("id_emp"=>$data['id_emp'], "fecha"=>$HOY, "hora"=>$AHORA,  "id_movil"=>$data['id'], "mensaje"=>"VUELVE DE ESTADO OCUPADO TELEFONO"), $mysqli);
		insert("notificaciones", array("id_emp"=>$data['id_emp'], "mensaje"=>"<b>Movil ".$movil['codigo']."</b> ha vuelto a disponible.", "estado"=>"ACTIVA", "origen"=>"INICIO_CHOFER"), $mysqli);
		update("empresa",array("last_query"=>$NOW), array("id"=>$data['id_emp']), array("limit"=>"1"), $mysqli);
		echo 'true';
	
}

