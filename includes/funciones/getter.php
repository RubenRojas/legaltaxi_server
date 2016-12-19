<?php
function get_ciudades($mysqli){
	$query = "select ciudad from empresa group by ciudad order by ciudad asc";
	$result = $mysqli->query($query);
	return $result;
}

function get_centrales($ciudad, $mysqli){
	$query = "select id, razon_social from empresa where ciudad='$ciudad' and legaltaxi='SI' order by RAND() asc";
	$result = $mysqli->query($query);
	return $result;
}