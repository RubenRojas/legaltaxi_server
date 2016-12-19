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
include($baseDir."head.php");
$email = $_COOKIE['email'];
$usuario = getUsuario($email, $mysqli);
$carrera = get_carrera_califica($usuario, $mysqli);
$central = select("empresa", array("*"), array("id"=>$carrera['id_emp']), array("limit"=>"1"), $mysqli);
?>
<div id="loader"> </div>

<?=print_nav("¡Califícanos!", $usuario)?>

<div class="container">
	<div class="row">
		<div class="detalle_carrera">
			<div class="row card">
				<div class="col s12 center">
					<h5 style="font-size: 1.5em; ">¡Gracias por preferir a <?=$central['razon_social']?>!</h5><p>Siga solicitándonos a través de Legaltaxi o llamándonos al fono <?=$central['fono']?></p>
				</div>
				<div class="col s6">
					<span>Fecha</span>
					<?=$carrera['fecha']?>
				</div>
				<div class="col s3">
					<span>Hora</span>
					<?=$carrera['hora_activacion']?>
				</div>
				<div class="col s3">
					<span>Valor</span>
					<?=$carrera['valor_cobrado']?>
				</div>
				<div class="col s12">
					<span>Direccion</span>
					<?=$carrera['dir_inicio']?> <?=$carrera['numero_direccion']?>
				</div>
				<div class="col s9">
					<span>Chofer</span>
					<?=$carrera['nombre']?>
				</div>
				<div class="col s3">
					<span>Movil</span>
					<?=$carrera['codigo']?>
				</div>
				<div class="col s9">
					<span>Central</span>
					<?=$carrera['razon_social']?>
				</div>
				<div class="col s3">
					<span>Cod. Carr</span>
					<?=$carrera['id']?>
				</div>
				
			</div>
		</div>

		<div class="califica detalle_carrera">
			<div class="row card">
				<div class="col s7">
					Chofer
				</div>
				<div class="col s5">
					<div class="star" id="chofer"></div>
				</div>
				<div class="col s7">
					Taxi
				</div>
				<div class="col s5">
					<div class="star" id="taxi"></div>
				</div>
				<div class="col s7">
					General
				</div>
				<div class="col s5">
					<div class="star" id="general"></div>
				</div>
			</div>
			<a href="Javascript:get_calificacion();" class="btn teal right">Finalizar</a>
		</div>


	</div>
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

<!-- Cancela Carrera -->
<div id="modal1" class="modal">
	<div class="modal-content">
	  <h4>Cancelar Carrera</h4>
	  <p>¿Está seguro que desea cancelar la carrera?</p>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green  left btn-flat  boton_dialogo">Volver</a>
		<a href="#!" class="modal-action modal-close waves-effect waves-red  btn-flat right boton_dialogo">Cancelar Taxi</a>
	</div>
</div>



<script>
	Pace.on("done", function(){
		$("#loader").hide();
	});
	function get_calificacion(){
		var chofer = $("#chofer").raty('score');
		var taxi = $("#taxi").raty('score');
		
		var general = $("#general").raty('score');

		var id_carrera = "<?=$carrera['id']?>";

		termina_carrera(chofer,taxi,"",general,id_carrera);

	}



	

	
</script>

<?php
include($baseDir."footer.php");
?>