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
if($correo=='' or $pass==''){
	echo'{"result": "no-data" } ';
}
else{
	$us = existe_mail($correo, $mysqli);
	if($us['email']!=''){
		$usuario = valida_login($correo, $pass, $mysqli);
		if($usuario['email']!=''){ //usuario correcto
			$res = array();
			$res['result'] = "success";
			$res['user'] = $usuario;
			echo json_encode($res);
		}
		else{ //existe un registro con el correo, pero la pass esta mal
			echo'{"result": "no-data" } ';
		}
	}
	else{ //no existe un registro para ese correo, se debe crear
		echo'{"result": "no-data" } ';
	}	
}

