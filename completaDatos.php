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

if($usuario['direccion']!=""){
	header("Location: explicacion.php");
}




$ciudades = get_ciudades($mysqli);
$centrales =get_centrales("", $mysqli);
include($baseDir."head.php");
?>

<div class="container " id="index">
	<div class="row">
		<div class="col s12 ">
			<div class="titulo">
				<img src="/legaltaxi/assets/img/appicon.png" alt="" id="logo" class="" style="height: 100px; width: auto; margin-bottom: -18px; margin-top: 0; ">
				<h2>Completar los datos</h2>
				<p>Por favor, ingresa los datos pedidos a continuación para configurar tu cuenta y darte un mejor servicio.</p>
			</div>
		</div>
		<form action="/legaltaxi/Ajax/php/login/guarda_usuario.php" class="completa_datos" method="post">
			<div class="input-field col s7">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" value="<?=$usuario['nombre']?>">
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
				<p style="margin-bottom: 9px; text-align: center; font-size: 1em; color: #fff; font-weight: bold; ">Selecciona una Ciudad y la central que prefieras.</p>
			</div>
			<div class="input-field col s4">
				<label class="active">Ciudad</label>
				<select name="ciudad" id="ciudad" class="browser-default" onchange="update_central(this.value)" required>
					<?php
					while ($arr = $ciudades->fetch_assoc()) {
						?>
						<option value="<?=$arr['ciudad']?>" ><?=$arr['ciudad']?></option>
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
						<option value="<?=$arr['id']?>"><?=strtoupper($arr['razon_social'])?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="input-field col s12">
				<input type="hidden" name="datos_restantes" value="true">
				<input type="submit" value="Siguiente" class="btn right">
			</div>
		</form>
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
