<div class="detalle_carrera">
	<div class="row">
		<h2 class="center">Detalle</h2>
		<div class="col s9">
			<span>Fecha</span>
			04/05/2016
		</div>
		<div class="col s3">
			<span>Valor</span>
			$1,500.-
		</div>
		<div class="col s12">
			<span>Direccion</span>
			LOTEO SAN MANUEL 1 ENTRADA IZQ
		</div>
		<div class="col s9">
			<span>Chofer</span>
			LUIS ALBERTO PEREZ GONZALEZ
		</div>
		<div class="col s3">
			<span>Movil</span>
			CT-JJ-14
		</div>

		<div class="separador"></div>

		<h2 class="center">Calificaciones</h2>
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
			Tiempos de Respuesta
		</div>
		<div class="col s5">
			<div class="star" id="tiempos"></div>
		</div>
		<div class="col s7">
			General
		</div>
		<div class="col s5">
			<div class="star" id="general"></div>
		</div>

	</div>
</div>

<script>
	$('#chofer').raty({ score: 3 });
	$('#taxi').raty({ score: 5 });
	$('#tiempos').raty({ score: 4 });
	$('#general').raty({ score: 4 });

</script>