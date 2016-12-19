<?php
function print_nav($titulo, $usuario){

	?>
<nav>
	<div class="nav-wrapper">
		<a href="#!" class="brand-logo"><?=$titulo?></a>
		<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="fa fa-bars" aria-hidden="true"></i></a>
		<ul class="side-nav" id="mobile-demo">
			<li id="perfil">
				<div class="avatar"><img src="<?=$usuario['img']?>" alt=""></div>
				<p><?=$usuario['nombre']?><br>
				<span class="email"><?=$usuario['email']?></span></p>
			</li>
			<li><a href="dash.php"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
			<li><a href="editar_datos.php"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Datos</a></li>
			<li><a href="actualizaPass.php"><i class="fa fa-key" aria-hidden="true"></i> Cambiar Contraseña</a></li>

			<li><a href="/legaltaxi/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar Sesion</a></li>
		</ul>
	</div>
</nav>

	<?php
}

