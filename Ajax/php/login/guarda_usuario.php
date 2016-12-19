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
if($correo !=''){
	$nombre = strtoupper(str_replace("_", " ", $nombre));

	//GUARDO EL USUARIO NUEVO, SI NO ESTÁ, NO SE GUARDA.
	//nombre, correo, imagen, origen: facebook, gmail
	$correo = strtoupper($_POST['correo']);
	$query ="insert into user_app(nombre, email, img, origen) values('$nombre', '$correo', '$imagen', '$origen')";
	$result = $mysqli->query($query);
	$n_data = 1;

	$usuario = getUsuario($correo, $mysqli);
	if($usuario['direccion']!=""){
		$n_data = 0;
	}
	
	setcookie("email", strtoupper($correo), time()+259200,"/",""); //cookie que dura 3 días
	echo $n_data;	
}

if($datos_restantes == "true"){
	$email = $_COOKIE['email'];
	$nombre = strtoupper(str_replace("_", " ", $nombre));
	$direccion = strtoupper(str_replace("_", " ", $direccion));
	$query = "update user_app set nombre='$nombre', fono='$fono',direccion='$direccion',numero_casa='$numero',ciudad='$ciudad',central='$central' where email='$email' limit 1";
	
	$result = $mysqli->query($query);
	header("Location: /legaltaxi/dash.php");
}
