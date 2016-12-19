<?php
if(strpos(getcwd(),
	"pruebas")){
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
if($login=='' or $pass==''){
	echo'{"result": "no-data" } ';
}
else{
	$query = "select 
	chofer.login,
	chofer.pass,
	chofer.nombre,
	chofer.fono,
	chofer.id_emp,
	chofer.codigo as codigoChofer,
	empresa.razon_social as nombreEmp,
	chofer.id_emp,
	movil.estado_turno,
	movil.codigo as codigoMovil,
	movil.id as id_movil

	from chofer 
	inner join empresa on chofer.id_emp = empresa.id
	left join movil on movil.id_chofer = chofer.id

	where 
	chofer.login='$login' and
	chofer.pass='$pass' limit 1";
	
	$result = $mysqli->query($query);
	if($result->num_rows > 0){
		$usuario = $result->fetch_assoc();

		if($usuario['estado_turno']==''){ $usuario['estado_turno']="4";}
		if($usuario['codigoMovil']==''){ $usuario['codigoMovil']="-";}
		if($usuario['id_movil']==''){ $usuario['id_movil']="-";}

		$res = array();
		$res['result'] = "success";
		$res['user'] = $usuario;
		

		$query = "select orden from empresa_posicion_fichero where id_emp='$usuario[id_emp]' limit 1";
	
		$result = $mysqli->query($query);
		$arr = $result->fetch_assoc();
		$json = json_decode($arr['orden'], true);

		if($json[$id_movil]==''){
			$res['user']['posFichero']="--";
		}
		else {
			$res['user']['posFichero'] = $json[$id_movil];
		}
		

		echo json_encode($res);
	}
	else{
		echo'{"result": "no-data" } ';
	}
}