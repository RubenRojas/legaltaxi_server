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

$email = $_COOKIE['email'];
if($email==""){
	header("location: index.php");
}
$usuario = getUsuario($email, $mysqli);
$carrera = get_carrera($usuario, $mysqli);
$ciudades = get_ciudades($mysqli);
$centrales =get_centrales($usuario['ciudad'], $mysqli);

$log = explode($SEPARADOR_LOG, $carrera['log']);
if($carrera['id']==null){
	$_SESSION['mensaje'] = "No hay carreras activas";
	header("location: dash.php");
}
include($baseDir."head.php");
?>
<div id="loader"> </div>
<div id="overlay"></div>
<?=print_nav("Carrera en Curso", $usuario)?>
<div class="container">
	<div class="row">
		<div class="detalle_carrera">
			<div class="row card">
				<div class="col s4">
					<span>Carrera</span>
					<div id="id_carrera_data"><?=$carrera['id']?></div>
				</div>
				<div class="col s5">
					<span>Fecha</span>
					<div id="fecha_data"><?=$carrera['fecha']?></div>
				</div>
				<div class="col s3">
					<span>Hora</span>
					<div id="hora_activacion_data"><?=$carrera['hora_activacion']?></div>
				</div>
				<div class="col s12">
					<span>Direccion</span>
					<div id="direccion_data"><?=$carrera['dir_inicio']?> <?=$carrera['numero_direccion']?></div>
				</div>
				<div class="col s8">
					<span>Chofer</span>
					<div id="nombre_data"><?=$carrera['nombre']?></div>
				</div>
				<div class="col s4">
					<span>Central</span>
					<div id="razon_social_data"><?=$carrera['razon_social']?></div>
				</div>
				
				
				<div class="col s12" id="datos_movil" style="
    padding: 0px 6px 9px 6px;
    margin-bottom: -13px;
    background: aliceblue;
">
					<p style="margin-bottom: 8px;"><b>Datos Movil</b></p>

					<div class="col s2">
						<span>Movil</span>
						<div id="movil_data"><?=$carrera['patente']?></div>
					</div>
					<div class="col s3">
						<span>Patente</span>
						<div id="dato_movil_patente"></div>
					</div>
					<div class="col s3">
						<span>Modelo</span>
						<div id="dato_movil_modelo"></div>
					</div>
					<div class="col s4">
						<span>Color</span>
						<div id="dato_movil_color"></div>
					</div>
				</div>
				<div class="col s6 accion">
					<a href="#modal1" class="btn red left modal-trigger">Cancelar</a>
				</div>
				<div class="col s6 accion" id="accion_data">
				
				</div>
			</div>
		</div>
		<div class="log_carrera">
			<div class="row card" id="log_carrera_data">
			<?php
			foreach ($log as $entrada) {
				$data = explode("--", $entrada);
				?>
				<li><span><?=$data[0]?></span>: <?=$data[1]?></li>
				<?php
			}
			?>
			</div>
		</div>
	</div>
</div>


<!-- Cancela Carrera -->
<div id="modal1" class="modal">
	<div class="modal-content">
	  <h4>Cancelar Carrera</h4>
	  <p>¿Está seguro que desea cancelar la carrera?</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green  left btn-flat  boton_dialogo">Volver</a>
		<a href="redirect.php?cancela=true" onclick ="cierra_modal(2)" class="modal-action modal-close waves-effect waves-red  btn-flat right boton_dialogo">Cancelar Taxi</a>
	</div>
</div>


<!-- Tiempo de espera excedido -->
<div id="modal2" class="modal">
	<div class="modal-content">
	  <h4>Tiempo de espera excedido</h4>
	  <p>¿Qué accion desea tomar?</p>
	</div>
	<div class="modal-footer">
		
		<a href="#modal3" class="modal-action modal-close waves-effect waves-teal btn blue right boton_dialogo" onclick="continuar_espera();"  style="width:100%">Continuar Espera</a>
		<a href="#modal3" class="modal-action modal-close waves-effect waves-teal btn teal right boton_dialogo" onclick="modal_carrera();"  style="width:100%">Cambiar Central</a>

		
		<a href="#modal1" class="btn red left modal-trigger" style="width:100%">Cancelar Pedido</a>
	</div>
</div>


<!-- modal nueva carrera -->
<div id="nueva_carrera" class="dialogo card animated">
	<div class="row">
		<a href="#" class="close"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
		<div class="col s12"><h2 class="center">Actualizar Carrera</h2></div>

		<form class="" method="post" id="actualizar_carrera" onsubmit="return toSubmit();">
			<div class="input-field col s7">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" value="<?=$usuario['nombre']?>">
			</div>
			<div class="input-field col s5">
				<label for="fono">Fono</label>
				<input type="number" name="fono" id="fono" value="<?=$usuario['fono']?>">
			</div>
			<div class="input-field col s9">
				<label for="direccion" class="active">Direccion</label>
				<input type="text" name="direccion" id="direccion_carrera" value="">
			</div>
			<div class="input-field col s3">
				<label for="numero">N°</label>
				<input type="number" name="numero" id="numero_direccion_carrera" value="<?=$usuario['numero_casa']?>">
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
				<input type="hidden" name="id" id="id" value="<?=$carrera['id']?>">
				<input type="submit" value="Actualizar" class="btn right"  id="boton_pedir_carrera"  onclick="actualizar_carrera();">
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
<script>
var flag =0;
	$(document).ready(function(){
		get_log_carrera();
	});
	Pace.on("done", function(){
		$("#loader").hide();
	});
	setInterval(function(){
		get_log_carrera();
	}, 25000);
	function cierra_modal(id){
		$('#modal'+id).closeModal();
	}
	function modal_carrera(){
		nueva_carrera();
	}
	function get_log_carrera(){
		console.log("Consutando log carrera");
		var url= baseDir+"carrera/log_carrera.php?id="+<?=$carrera['id']?>;
		var datos= "";
		datos = crearXMLHttpRequest();
		datos.onreadystatechange = function(){
			if(datos.readyState==1){
			}
			else if(datos.readyState==4){
				if(datos.status==200){
					var data = $.parseJSON(datos.responseText);
					console.log(data);
					$("#id_carrera_data").html(data.id_carrera);
					$("#fecha_data").html(data.fecha);
					$("#hora_activacion_data").html(data.hora_activacion);
					$("#direccion_data").html(data.dir_inicio + " " + data.numero_direccion);					
					$("#nombre_data").html(data.chofer);
					if (data.movil != null) {
						$("#movil_data").html(data.movil.codigo);
					}
					
					$("#razon_social_data").html(data.razon_social);
					$("#log_carrera_data").html(data.log);
					$("#log_carrera_data").animate({ scrollTop: $('#log_carrera_data').prop("scrollHeight")}, 500);
					if(data.calificado == '-1' && flag==0){ //tiempo de expera excedido
						$('#modal2').openModal();
						flag = 1;
						$("#direccion_carrera").val(data.dir_inicio);
						$("#numero_direccion_carrera").val(data.numero_direccion);
					}
					if($.inArray(data.estado_carrera, ["1","2","3"] ) !== -1){
						//accion_data
						$("#accion_data").html('<a href="Javascript:a_bordo('+data.id+');" class="btn right">¡A bordo!</a>');
						
						if (data.movil != null) {
							$("#dato_movil_patente").html(data.movil.patente);
							$("#dato_movil_modelo").html(data.movil.modelo);
							$("#dato_movil_color").html(data.movil.color);
						}
					}
				}
			}  
		};
		datos.open("GET", url, true);
		datos.send(null);
	}
</script>



<?php
include($baseDir."footer.php");
?>