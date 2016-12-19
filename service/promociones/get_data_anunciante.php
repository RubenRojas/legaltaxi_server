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

$id = $_GET['id']; // id_anuncio = 2;


$query = "select 
anunciante.nombre,
anunciante.fono,
anunciante.direccion,
anunciante.correo,
anunciante.web,
anunciante.horario,
anunciante.lat,
anunciante.lon,
DATE_FORMAT(anunciante_oferta.fecha_inicio,'%d-%m-%Y') as fecha_inicio, 
DATE_FORMAT(anunciante_oferta.fecha_termino,'%d-%m-%Y') as fecha_termino, 
anunciante_oferta.contenido,
anunciante_categorias.nombre as categoria,
anunciante.ciudad
from anunciante 
inner join anunciante_oferta on anunciante.id = anunciante_oferta.id_anunciante 
inner join anunciante_categorias on anunciante_oferta.categoria = anunciante_categorias.id 
where
anunciante_oferta.id='$id'";

 $result = $mysqli->query($query);
 $ret  = array();
 $ret['result'] = "success";
 $ret['data'] = array();
 while ($arr = $result->fetch_assoc()) {
 	array_push($ret['data'], $arr);
 }
 echo json_encode($ret);