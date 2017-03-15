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

//login, pass, codigo


//obtener la empresa
$query = "select id, id_emp from chofer where login='$login' and pass='$pass' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$id_emp = $arr['id_emp'];
$id_chofer = $arr['id'];
//obtener id del movilo
$query = "select id, codigo from movil where id_emp='$id_emp' and codigo='$codigo' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
if($id_movil==""){
	$id_movil = $arr['id'];	
}
else{
	$query = "select id, codigo from movil where id='$id_movil' limit 1";
	$result = $mysqli->query($query);
	$arr = $result->fetch_assoc();
	$codigo = $arr['codigo'];

}




if($id_movil != ""){
	//actualizo el movil
	$id_chofer_actual = get_campo("movil","id_chofer", $id_movil, $mysqli);
	$estado_movil = get_campo("movil", "estado_turno", $id_movil, $mysqli);
/*	
	echo'<hr>estado_movil: '.$estado_movil.'<hr>';
	echo'<hr>id_chofer_actual: '.$id_chofer_actual.'<hr>';
	echo'<hr>id_chofer: '.$id_chofer.'<hr>';
*/	

	if($id_chofer_actual==0 or $id_chofer_actual==$id_chofer or $estado_movil==4){
		
		update("movil",array("id_chofer"=>$id_chofer), array("id"=> $id_movil), array("limit"=>"1"), $mysqli);
		
		update("empresa",array("last_query"=>$NOW), array("id"=>$id_emp), array("limit"=>"1"), $mysqli);

		
		$estado_turno= 1;
		//$comentario = strtoupper($comentario);
		$query ="insert into movil_turno(id_movil, id_emp, fecha_inicio, hora_inicio) values('$id_movil', '$id_emp', '$HOY', '$AHORA')";
		$result = $mysqli->query($query);
		$query = "select id from movil_turno where id_movil='$id_movil' order by id desc limit 1";
		$result = $mysqli->query($query);
		$arr = $result->fetch_assoc();
		if($id_chofer_actual==0 ){ //movil arriba pero sin chofer
			$query = "update movil set estado_turno='1', id_turno='$arr[id]' where id='$id_movil' limit 1";
		}
		else{
			$query = "update movil set estado_turno='1', t_cambio='$NOW', id_turno='$arr[id]' where id='$id_movil' limit 1";
		}
		$result = $mysqli->query($query);
		insert("log", array("id_emp"=>$id_emp, "fecha"=>$HOY, "hora"=>$AHORA,  "id_movil"=>$id_movil, "mensaje"=>"INICIA TURNO TELEFONO"), $mysqli);
		insert("notificaciones", array("id_emp"=>$id_emp, "mensaje"=>"<b>Movil ".$codigo."</b> ha iniciado turno", "estado"=>"ACTIVA", "origen"=>"INICIO_CHOFER"), $mysqli);
		update("empresa",array("last_query"=>$NOW), array("id"=>$id_emp), array("limit"=>"1"), $mysqli);

		$query = "select orden from empresa_posicion_fichero where id_emp='$id_emp' limit 1";
		
		$result = $mysqli->query($query);
		$arr = $result->fetch_assoc();
		$json = json_decode($arr['orden'], true);

		$res = array();
		$res['result'] = "success";
		$res['id'] = $id_movil;
		$res['codigoMovil'] = $codigo;
		$res['estado_turno'] = $estado_turno;
		$res['posFichero'] = $json[$id_movil];
		echo json_encode($res);
	}
	else{
		echo'{"result": "no-data", "error": "El movil al que intenta acceder se encuentra actualmente en uso." } ';	
	}
}
else{
	echo'{"result": "no-data", "error": "El codigo escaneado no corresponde a un movil. Intente con otro codigo." } ';
}
