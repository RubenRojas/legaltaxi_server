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
extract($_POST);

if($tipo=="centrales"){
	$centrales = get_centrales($ciudad, $mysqli);
	?><option value=""></option><?php
	while ($arr = $centrales->fetch_assoc()) {
		?>
		<option value="<?=$arr['id']?>" <?php if($_SESSION['usuario']['central'] == $arr['id']){ echo "selected"; } ?> ><?=strtoupper($arr['razon_social'])?></option>
		<?php
	}
}
