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
print_nav("Editar Datos", $usuario);
?>

<div class="container ">
	<div class="row">
		<div class="header_form">
			<img src="/legaltaxi/assets/img/appicon.png" alt="" id="logo" class="" style="height: 100px; width: auto; margin-bottom: -18px; margin-top: 15px; ">
			<h2>Editar Datos</h2>
			<p>En el siguiente formulario podrás editar tus datos.</p>
		</div>
		<form action="/legaltaxi/Ajax/php/login/editaDatos.php" class="edita_datos" method="post" style="margin-top: 24px; ">
			<div class="input-field col s12">
				<label for="email">Tu Email</label>
				<input type="email" name="email" disabled value="<?=$usuario['email']?>">
			</div>
			<div class="input-field col s7">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" value="<?=$usuario['nombre']?>" required>
			</div>
			<div class="input-field col s5">
				<label for="fono">Fono</label>
				<input type="number" name="fono" id="fono" value="<?=$usuario['fono']?>">
			</div>
			<div class="input-field col s9">
				<label for="direccion">Direccion</label>
				<input type="text" name="direccion" id="direccion" value="<?=$usuario['direccion']?>" required>
			</div>
			<div class="input-field col s3">
				<label for="numero">N°</label>
				<input type="number" name="numero" id="numero" value="<?=$usuario['numero_casa']?>">
			</div>
			<div class="col s12">
				<p style="margin-bottom: 9px; text-align: left; font-size: 1em; color: #444; font-weight: bold; ">Selecciona tu Ciudad y la central que prefieras.</p>
			</div>
			<div class="input-field col s4">
				<label class="active">Ciudad</label>
				<select name="ciudad" id="ciudad" class="browser-default" onchange="update_central(this.value)" required>
					<?php
					while ($arr = $ciudades->fetch_assoc()) {
						?>
						<option value="<?=$arr['ciudad']?>" <?php if($usuario['ciudad']== $arr['ciudad']){ echo' selected'; } ?> ><?=$arr['ciudad']?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="input-field col s8">
				<label class="active">Central Pref.</label>
				<select name="central" id="central" class="browser-default" required>
					<?php
					while ($arr = $centrales->fetch_assoc()) {
						?>
						<option value="<?=$arr['id']?>"  <?php if($usuario['central']== $arr['id']){ echo' selected'; } ?> ><?=strtoupper($arr['razon_social'])?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="input-field col s12">
				<input type="hidden" name="datos_restantes" value="true">
				<input type="submit" value="Guardar Datos" class="btn right">
			</div>
		</form>
	</div>
</div>


<script>
	$(document).ready(function(){
		 $('select').material_select();
	});

	function repetir_pass(){
		$("#repetir").css("display", "inline");
		$("#repetir").html('<label for="pass2">Repetir Contraseña</label><input type="password" name="pass2" id="pass2" required>');
		$("#pass2").focus();
	}
	

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