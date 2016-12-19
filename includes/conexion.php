<?php
/*************************************************/
//	CONFIG BASE
/*************************************************/
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
ini_set('memory_limit', '-1');
error_reporting(E_ERROR | E_WARNING | E_PARSE); 	//reporta errores ultiles
//error_reporting(-1);									//reporta todos los errores
//error_reporting(0);									//no reporta errores
 date_default_timezone_set('Etc/GMT+3');
/*************************************************/
//	INTEGRACION FUNCIONES
/*************************************************/
if(strpos(getcwd(), "pruebas")){
	$baseDir = "/home4/alvarube/public_html/centraltaxi/pruebas/centraltaxi/funciones/";
}
else if(is_dir("/home4/alvarube/public_html/centraltaxi/centraltaxi/funciones/")){
	$baseDir = "/home4/alvarube/public_html/centraltaxi/centraltaxi/funciones/";
}
else{
	$baseDir = "c:/wamp/www/centraltaxi/funciones/";
}

include($baseDir."phpMailer/class.phpmailer.php");
include($baseDir."funciones/print.php");
include($baseDir."funciones/carreras.php");
include($baseDir."funciones/getter.php");
include($baseDir."funciones/usuario.php");
include($baseDir."funciones/general.php");

/*************************************************/
//	CONEXION PUSHPAD (NOTIFICACIONES)
/*************************************************/
require_once($baseDir.'init.php');
$auth_token = '8ca646b0f216815cab0f0d437e867a47';
Pushpad\Pushpad::$auth_token = $auth_token;
Pushpad\Pushpad::$project_id = 1240; # set it here or pass it as a param to methods later



/*************************************************/
//	CONEXION BASE DE DATOS
/*************************************************/
$host="localhost";
$user= "alvarube";
$pass="capuccino650A";
$database="alvarube_centraltaxi";

$mysqli = @new mysqli($host, $user, $pass, $database);
if ($mysqli->connect_errno) {
    $mysqli = @new mysqli($host, "root", "root", "centraltaxi");
}
/*************************************************/
//	VARIABLES PARA LA APP
/*************************************************/
$HOY 	= date("Y-m-d");
$AYER 	= date('Y-m-d',strtotime("-1 days"));
$MANANA = date('Y-m-d',strtotime("+1 days"));
$AHORA 	= date('H:i');
$hora = explode(" ", microtime());
$NOW = $hora[1].substr($hora[0], 1, 5);
$SEPARADOR_LOG=">>";
//$log = $SEPARADOR_LOG.$AHORA."--Carrera Creada para <b>".$central."</b>.";