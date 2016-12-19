<?php
$pace="SI";
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
/*************************************
VARIABLES NECESARIAS
*************************************/
$email = $_COOKIE['email'];
if($email==""){
	header("location: index.php");
}
$usuario = getUsuario($email, $mysqli);
if($usuario['direccion']==""){
	header("Location: index.php");
}

$carrera_activa =  get_carrera($usuario, $mysqli);

if($carrera_activa['id']!=""){
	header("Location: enRuta.php");
}


$ciudades = get_ciudades($mysqli);
$centrales =get_centrales($usuario['ciudad'], $mysqli);
$carreras = get_carreras_dash($usuario, $mysqli);

include($baseDir."head.php");
$uid_signature = hash_hmac('sha1', $email, $auth_token);
?>
<script>
	pushpad('uid', '<?=$email?>', '<?=$uid_signature?>');
	pushpad('subscribe');
</script>

<div id="loader"> </div>
<div id="overlay"></div>
<?=print_nav("Carreras", $usuario)?>
<div id="fav">
	 
	<a class="waves-effect waves-light teal animated slideInRight" href="Javascript:nueva_carrera();" style="line-height: 68px; text-transform: uppercase; font-weight: bold;">Pedir</a>
</div>
<div class="container" id="dash">
	<div class="row">
	<?php
		if($carreras->num_rows>0){
			while ($arr = $carreras->fetch_assoc()) {
				if($arr['nombre']==null) { $arr['nombre'] = "NO ASIGNADO" ; }else{
					$nombre = explode(" ", $arr['nombre']);
					$nombre_chofer = $nombre[0]." ".substr($nombre[2], 0, 6);
					$arr['nombre'] = $nombre_chofer;
				}
				if($arr['patente']==null) { $arr['patente'] = "NO ASIGNADO" ; }
				$pedida = get_central_inicial_carrera($arr['id'], $mysqli);

				if($pedida == "" and $arr['estado_carrera']!="4"){
					$pedida = $arr['razon_social'];
				}
				?>
				<a href="#">
					<div class="carrera card">
						
						
						
						<div class="col s12 dato direccion"><span>Direccion</span><?=$arr['dir_inicio']?> <?=$arr['numero_direccion']?></div>
						<div class="info_movil">
							<div class="col s4 dato_movil"><span>Pedida A</span><?=$pedida?></div>
							<div class="col s5 dato_movil"><span>Atendido por</span><?=$arr['nombre']?></div>
							<div class="col s3 dato_movil"><span>Movil</span><?=$arr['codigo']?></div>
							<div class="col s4 dato_movil"><span>Fecha</span><?=$arr['fecha']?></div>
							<div class="col s4 dato_movil"><span>Hora Pedido</span><?=$arr['hora_activacion']?></div>
							<div class="col s4 dato_movil"><span>Hora de Envío</span><?=$arr['hora_envio']?></div>
							
						</div>
						<div class="col s4  dato_2"><span>N° Carr.</span><?=$arr['id']?></div>
						<div class="col s4 dato_2">
							<span>Calificacion</span>
							<?php
							if($arr['estado_carrera']=="4"){
								?> Cancelada <?php
							}
							else{
								?>
								<div class="">
									<?php
									for ($i=0; $i < round($arr['promedio']); $i++) { 
										?><i class="fa fa-star" aria-hidden="true"></i><?php
									}
									for ($i=round($arr['promedio']); $i < 5; $i++) { 
										?><i class="fa fa-star-o" aria-hidden="true"></i><?php
									}

									?>
								</div>
								<?php
							}
							?>
							
						</div>
						<div class="col s4 dato_2">
							<span>Valor</span>
							$<?=number_format($arr['valor_cobrado'])?>
						</div>
					</div>
				</a>
				<?php
			}
		}
		else{

			?>
			<p class="center">Aquí aparecerá el listado con los pedidos que has hecho mediante Legaltaxi. Cuando quieras solicitar un taxi, haz click en PEDIR </p>
			<?php
		}

	?>
		
	</div>
</div>

<!--<a href="<?= Pushpad\Pushpad::path_for($usuario['email']) ?>">Subscribe current user to push notifications</a>-->


<div id="nueva_carrera" class="dialogo card animated">
	<div class="row">
		<a href="#" class="close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
		<div class="col s12"><h2 class="center">Nueva Carrera</h2></div>

		<form class="" method="post" id="nueva_carrera_form" onsubmit="return toSubmit();">
			<div class="input-field col s7">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre_referencia" id="nombre" value="<?=$usuario['nombre']?>">
			</div>
			<div class="input-field col s5">
				<label for="fono">Fono</label>
				<input type="number" name="fono" id="fono" value="<?=$usuario['fono']?>">
			</div>
			<div class="input-field col s9">
				<label for="direccion">Direccion</label>
				<input type="text" name="direccion" id="direccion" value="<?=$usuario['direccion']?>">
			</div>
			<div class="input-field col s3">
				<label for="numero">N°</label>
				<input type="number" name="numero" id="numero" value="<?=$usuario['numero_casa']?>">
			</div>
			<div class="input-field col s4">
				<label class="active">Ciudad</label>
				<select name="ciudad" id="ciudad" class="browser-default" onchange="update_central(this.value), set_tiempo_atencion_central('')">
					<?php
					while ($arr = $ciudades->fetch_assoc()) {
						?>
						<option value="<?=$arr['ciudad']?>" <?php if($usuario['ciudad'] == $arr['ciudad']){ echo "selected"; } ?> ><?=$arr['ciudad']?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="input-field col s8">
				<label class="active">Seleccione Central</label>
				<select name="central" id="central" class="browser-default" onchange="set_tiempo_atencion_central(this.value)">
					<?php
					while ($arr = $centrales->fetch_assoc()) {
						?>
						<option value="<?=$arr['id']?>" <?php if($usuario['central'] == $arr['id']){ echo "selected"; } ?> ><?=strtoupper($arr['razon_social'])?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="col s12 tiempo_atencion_central">
				<p>Tiempo atencion: <span id="tiempo_atencion_central"></span></p>
			</div>
			
			
			<div class="input-field col s12">
				<input type="hidden" name="reserva" id="reserva" value="false">
				<input type="submit" value="Pedir Movil" class="btn right" id="boton_pedir_carrera" onclick="crear_nueva_carrera();">
				<a href="#" id="cerrar" class="left btn red white-text">Cancelar</a>
			</div>
		</form>
	</div>
	<div id="loader_carrera">
		<div class="preloader-wrapper big active">
		    <div class="spinner-layer spinner-blue-only">
		      <div class="circle-clipper left">
		        <div class="circle"></div>
		      </div><div class="gap-patch">
		        <div class="circle"></div>
		      </div><div class="circle-clipper right">
		        <div class="circle"></div>
		      </div>
		    </div>
		  </div>
	</div>
</div>
<div id="detalle_carrera" class="dialogo card animated slideInRight">
	<a href="#" class="close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
	<div id="contenido_carrera"></div>
</div>
<script>
	
	Pace.on("done", function(){
		$("#loader").hide();
	});
	$(document).ready(function(){
		set_tiempo_atencion_central(<?=$usuario['central']?>);
		var listado = new Array();
		$("#central option").each(function(index, element){
	    	listado.push($(element).html());
		});
		console.log(listado);
		listado = listado.sort(function(){ return Math.random() -0.5});
		console.log(listado);
	});


	/*
	var lista = [1,2,3,4,5,6,7,8,9];
	lista = lista.sort(function() {return Math.random() - 0.5});
	document.write(lista); // imprime por ejemplo: 7,9,1,5,2,3,6,4,8
	*/
	
	

</script>

<?php
if($_SESSION['msg']!=''){
	?>
	<script>
	swal({
    title: "Aviso",
    text: "<?=$_SESSION['msg']?>",
    showCancelButton: false, confirmButtonColor: "#26a69a", confirmButtonText: "Aceptar", cancelButtonText: "Cancelar", cancelButtonColor: "#F44336",closeOnConfirm: true
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
	unset($_SESSION['msg']);
}
?>

<?php
include($baseDir."footer.php");
?>
