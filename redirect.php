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

if($cancela=="true"){
	$_SESSION['mensaje']="Carrera Cancelada.";
	$email = $_COOKIE['email'];
	$usuario = getUsuario($email, $mysqli);

	$carrera = get_carrera($usuario, $mysqli);
	$log	 = $carrera['log'].$SEPARADOR_LOG.$AHORA."--Carrera Cancelada.";
	insert("notificaciones", array("id_emp"=>$carrera['id_emp'], "mensaje"=>"Carrera N° <b>".$carrera['id']."</b> ha quedado negativa","estado"=>"ACTIVA", "origen"=>"legaltaxi", "carrera"=>$carrera['id']), $mysqli);		
	update("empresa",array("last_query"=>$NOW), array("id"=>$carrera['id_emp']), array("limit"=>"1"), $mysqli);
	update("carrera" ,array("estado_carrera"=>"4", "log"=>$log), array("id"=>$carrera['id']), array("limit"=>"1"), $mysqli);
	header("Location: dash.php");

}
if($calif=="true"){
	$_SESSION['mensaje']="Gracias por calificarnos y usar nuestra App.";
}

if($tipo=='nueva_carrera'){
	echo'<hr>'.var_dump($_POST).'<hr>';
	$id = crear_carrera($_POST);
	//header("Location: enRuta.php?carrera=".$id);	
}
else{
	//header("Location: dash.php");
}


