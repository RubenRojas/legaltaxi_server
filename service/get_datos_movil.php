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
//id_movil
//id_emp
//codigo

$query = "
select 
chofer.nombre as chofer,
chofer.fecha_lic as licencia,
movil.patente,
movil.marca,
movil.anio,
movil.color,
movil.modelo,
movil.fecha_rev as revision_tecnica,
empresa.razon_social as central
from movil
inner join chofer on chofer.id = movil.id_chofer
inner join empresa on empresa.id = movil.id_emp
where movil.id='$id_movil'
limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$res = array();
if($result->num_rows > 0){
	$res['result'] = "success";
	$arr['licencia']>$HOY ? $arr['lic_valida'] = "SI" :  $arr['lic_valida'] = "NO";	
	$arr['revision_tecnica']>$HOY ? $arr['rev_valida'] = "SI" :  $arr['rev_valida'] = "NO";	
	$arr['licencia'] = cambiarFormatoFecha($arr['licencia']);
	$arr['revision_tecnica'] = cambiarFormatoFecha($arr['revision_tecnica']);
	$res['data'] = $arr;
}
else{
	$res['result'] = "El Código no coincide con un movil LEGALTAXI";	
}

echo json_encode($res);
