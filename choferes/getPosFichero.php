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


	$query = "select id, id_emp from chofer where login='$login' and pass='$pass' limit 1";
	$result = $mysqli->query($query);
	$arr = $result->fetch_assoc();
	$id_emp = $arr['id_emp'];

	//obtener id del movilo
	$query = "select id, codigo, estado_turno from movil where id_emp='$id_emp' and id_chofer = '$arr[id]' limit 1";
	$result = $mysqli->query($query);
	$arr = $result->fetch_assoc();
	$id_movil = $arr['id'];
	$estado_turno = $arr['estado_turno'];
	$codigo_movil = $arr['codigo'];


	if($id_movil != ""){	
		$res = array();
		$query = "select orden from empresa_posicion_fichero where id_emp='$id_emp' limit 1";
		
		$result = $mysqli->query($query);
		$arr = $result->fetch_assoc();
		$json = json_decode($arr['orden'], true);
		$res['posFichero'] = $json[$id_movil];
		if($res['posFichero']==""){
			$res['posFichero'] = "--";
		}
		$res['estado_turno'] = $estado_turno;
		$res['id_movil'] = $id_movil;
		$res['codigo_movil'] = $codigo_movil;

		echo json_encode($res);

		
	}
	else{
		echo'--';
	}