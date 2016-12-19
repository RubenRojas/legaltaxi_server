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

$query = "select 
anunciante.nombre,
 DATE_FORMAT(anunciante_oferta.fecha_inicio,'%d-%m-%Y') as fecha_inicio, 
 DATE_FORMAT(anunciante_oferta.fecha_termino,'%d-%m-%Y') as fecha_termino, 
 anunciante_oferta.contenido,
 anunciante_oferta.id,
 anunciante_categorias.nombre as categoria,
 anunciante.ciudad
 from anunciante_oferta 
 inner join anunciante on anunciante_oferta.id_anunciante = anunciante.id
 inner join anunciante_categorias on anunciante_oferta.categoria = anunciante_categorias.id 
 where
 anunciante_oferta.estado='1'
 and anunciante_oferta.fecha_termino > '$HOY'
  ORDER BY RAND()  ";

 $result = $mysqli->query($query);
 $ret  = array();
 $ret['result'] = "success";

 $ret['data'] = array();
 $ret['categorias'] = array();
 $ret['ciudades'] = array();

 while ($arr = $result->fetch_assoc()) {
 	$arr['contenido'] = substr($arr['contenido'], 0, 37)." ...";
 	array_push($ret['data'], $arr);
 }



$query = "select nombre from anunciante_categorias order by nombre";
$result = $mysqli->query($query);
while ($arr = $result->fetch_assoc()) {
	
	array_push($ret['categorias'], $arr);
}


$query = "select nombre from ciudad order by nombre";
$result = $mysqli->query($query);
while ($arr = $result->fetch_assoc()) {
	
	array_push($ret['ciudades'], $arr);
}

$query = "select datediff(carrera.fecha, '$HOY') as dias from carrera where user_app_mail='$email' and estado_carrera!='4' order by id desc limit 1";

$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

$query = "select (valor - abs($arr[dias])) as dias from legaltaxi_variables where nombre ='dias_usuario_frecuente'";

$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

if($arr['dias']> 0){
	$ret['estado_cliente'] = "USUARIO FRECUENTE";
	$ret['color'] ="#00796B";
}
else{
	$ret['estado_cliente'] = "USUARIO SIN BENEFICIO AUN";
	$ret['color'] ="#3d3e3f";
}



 echo json_encode($ret);