<?php
$pace="NO";
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

$email = $_COOKIE['email'];
$usuario = getUsuario($email, $mysqli);
//echo'<hr>'.var_dump($usuario).'<hr>';

$ciudades = get_ciudades($mysqli);
$centrales = get_centrales($usuario['ciudad'], $mysqli);
include($baseDir."head.php");

?>

<div class="container ">
	<div class="row">
		<div class="col s12 ">
			<div class="header_form">
				<img src="/legaltaxi/assets/img/appicon.png" alt="" id="logo" class="" style="height: 100px; width: auto; margin-bottom: -18px; margin-top: 0; ">
				<h2>Recuperar Contraseña</h2>
				<p>Ingresa tu email para enviarte las instrucciones para recuperar la contraseña.</p>
			</div>
		</div>
		<form action="/legaltaxi/Ajax/php/login/recuperar_pass.php" class="edita_datos" method="post" style="margin-top: 24px; ">
			<div class="input-field col s12">
				<label for="email">Tu Email</label>
				<input type="email" name="email" value="" required>
			</div>			
			<div class="input-field col s12">
				<input type="submit" value="Recuperar Contraseña" class="btn right">
			</div>
		</form>
	</div>
</div>


<script>
	$(document).ready(function(){
		 $('select').material_select();
	});


</script>

<?php
include($baseDir."footer.php");
?>