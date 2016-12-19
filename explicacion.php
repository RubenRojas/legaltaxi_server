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
if($email==""){
	header("location: index.php");
}
$usuario = getUsuario($email, $mysqli);
if($usuario['suscrito']==1){
	header("Location: dash.php");
}

include($baseDir."head.php");
?>

<div class="container " id="index">
	<div class="row">
		<div class="col s12 ">
			<div class="titulo">
				<img src="/legaltaxi/assets/img/appicon.png" alt="" id="logo" class="" style="height: 100px; width: auto; margin-bottom: -18px; margin-top: 0; ">
				<h2>Antes de Finalizar</h2>
				<p style="line-height: 1.4 !important;">¡Muy bien <?=$usuario['nombre']?>, estás a un paso de tener todo listo para usar Legaltaxi!<br>
				En el siguiente sitio, deberás suscribirte a las notificaciones de Legaltaxi, para ello debes hacer click en "ok", como aparece en la imagen.</p>
			</div>
			
			<img class="tut" src="/legaltaxi/assets/img/tut.png" alt="">
			<a href="/legaltaxi/Ajax/php/login/suscrito.php" class="btn btn_notif">Siguiente</a>

		</div>
	</div>
</div>


<script>
	$(document).ready(function(){
		 $('select').material_select();
		 
		 update_central($("#ciudad").val());
	});
	

</script>
<?php
include($baseDir."footer.php");
?>
