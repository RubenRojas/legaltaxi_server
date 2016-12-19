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

/*
pass
pass 2
fono
nombre
*/

$user = select("user_app", array("*"), array("email"=>$email), array("limit"=>"1"), $mysqli);

$nombre = strtoupper(str_replace("_", " ", $nombre));
$nombre = strtoupper($nombre);
$pass = strtoupper($pass);
$pass2 = strtoupper($pass2);


if($pass == $user['pass']){
	if($nombre != ''){
		
		
		if($fono !=''){
			if($pass2!=''){
				if(strlen($pass2)<6){
					echo'La contraseña debe ser de almenos 6 caracteres';
				}
				else{
					$query = "update user_app set nombre='$nombre', pass='$pass2', fono='$fono' where email='$email' limit 1";
					$result = $mysqli->query($query);
					echo 'true';	
				}
				
			}
			else{
				$query = "update user_app set nombre='$nombre', fono='$fono' where email='$email' limit 1";
				$result = $mysqli->query($query);
				echo 'true';
			}
		}
		else{
			echo 'Debes ingresar un fono';
		}
	}
	else{
		echo 'Debes ingresar un nombre';
	}
}
else if($pass==''){
	echo'Debes ingresar la contraseña actual';
}
else{
	echo'La contraseña ingresada no coincide con tu contraseña actual';
}