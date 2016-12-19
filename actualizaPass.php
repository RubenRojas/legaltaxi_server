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
print_nav("Actualizar Password", $usuario);
?>

<div class="container ">
	<div class="row">
		<div class="header_form">
			<img src="/legaltaxi/assets/img/appicon.png" alt="" id="logo" class="" style="height: 100px; width: auto; margin-bottom: -18px; margin-top: 15px; ">
			<h2>Actualizar Contraseña</h2>
			<p>En el siguiente formulario podrás actualizar tu contraseña.</p>
		</div>
		<form action="/legaltaxi/Ajax/php/login/actualiza_pass.php" class="edita_datos" method="post" style="margin-top: 24px; ">
			<div class="input-field col s12">
				<label for="email">Tu Email</label>
				<input type="email" name="email" disabled value="<?=$usuario['email']?>">
			</div>
			<div class="input-field col s12">
				<label for="pass">Tu Contraseña Actual</label>
				<input type="password" name="pass_actual" value="">
			</div>
			<div class="input-field col s12">
				<label for="pass">Nueva Contraseña</label>
				<input type="password" name="pass" value="">
			</div>
			<div class="input-field col s12" id="repetir">
				<label for="pass2">Repetir Contraseña</label>
				<input type="password" name="pass2" id="pass2" required>
			</div>
			
			<div class="input-field col s12">
				<input type="submit" value="Actualizar Contraseña" class="btn right">
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
if($_SESSION['error']!=''){
	?>
	<script>
	swal({
    title: "¡Error!",
    text: "<?=$_SESSION['error']?>",
    showCancelButton: false, confirmButtonColor: "#F44336", confirmButtonText: "Aceptar", cancelButtonText: "Cancelar", cancelButtonColor: "#F44336",closeOnConfirm: true
    }, 
    function(isConfirm){
      if(isConfirm){
        //llamadas a Ajaax y bla bla bla
        //se refrescan las tablas
        return;
      }
    });
    </script>
	<?php
	unset($_SESSION['error']);
}
include($baseDir."footer.php");
?>