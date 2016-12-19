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
if($email !='' and $nombre!='' and $pass!=''){
	$nombre = strtoupper(str_replace("_", " ", $nombre));

	//GUARDO EL USUARIO NUEVO, SI NO ESTÁ, NO SE GUARDA.
	//nombre, correo, imagen, origen: facebook, gmail
	$query ="insert into user_app(nombre, email, pass, origen) values('$nombre', '$email', '$pass', 'REGISTRO')";

	$result = $mysqli->query($query);
	if($result){
		echo "true";	
	}
	else{
		echo "Lo sentimos, pero el correo ya se encuentra en nuestros registros.";
	}
	
}
else if ($email==''){
	echo'Debes ingresar un Correo';
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  	echo 'Debes ingresar un correo válido';
}
else if ($nombre==''){
	echo'Debes ingresar un Nombre';
}
else if ($pass==''){
	echo'Debes ingresar una Contraseña';
}
else if(strlen($pass)<6){
	echo'La contraseña debe ser de almenos 6 caracteres';
}

