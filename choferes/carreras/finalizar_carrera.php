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

//id_carrera, calificacion

$estado_carrera = get_campo("carrera", "estado_carrera", $id_carrera, $mysqli);
$arr = select("carrera", array("id, id_emp, id_chofer, id_movil"), array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);

if($arr['estado_carrera'] !=3 and $arr['estado_carrera']!=4){
	update("carrera",array("hora_termino"=>$AHORA, "fecha_termino"=>$HOY, "estado_carrera"=>"3", "valor_cobrado"=>$valor, "terminadaChofer"=>"2"), array("id"=>$id_carrera), array("limit"=>"1"), $mysqli);
	insert("carrera_calificacion_usuario", array("id_carrera"=>$arr['id'], "calif"=>$calificacion), $mysqli);
	update("movil",array("estado_turno"=>"1"), array("id"=>$arr['id_movil']), array("limit"=>"1"), $mysqli);
	update("carrera_estado_legaltaxi",array("estado"=>"6"), array("id_carrera"=>$arr['id']), array("limit"=>"1"), $mysqli);

	echo "true";
}
else{
	$query = "update carrera set ";
	if($valor > 0){
		$query.="valor_cobrado='$valor', ";
	}
	$query .= "terminadaChofer='2' where id='$id_carrera'";
	$result = $mysqli->query($query);

	echo "true";

}
update("empresa",array("last_query"=>$NOW), array("id"=>$arr['id_emp']), array("limit"=>"1"), $mysqli);
