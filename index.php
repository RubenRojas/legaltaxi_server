<?php
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



if($usuario['direccion']!="" and $usuario['email']!=""){	
	header("Location: dash.php");
}
else if($usuario['direccion']=="" and $usuario['email']!=""){
	header("Location: completaDatos.php");	
}

include($baseDir."head.php");
?>


<div id="loader"> </div>
<div class="container my-page" id="index">
	<img src="/legaltaxi/assets/img/appicon.png" alt="" id="logo" class="animated slideInUp">
	<h2 class="center animated  slideInUp">Legaltaxi</h2>
	<div id="login_form">
		<p class="center">Ingresa usando un correo y una contraseña.</p>
		<form action="/legaltaxi/Ajax/php/login/login.php" method="post">
			<div class="input-field col m6 s12">
	          <input id="email" name="email" type="email" style="color: #fff; " required="true">
	          <label for="email" class="active">Correo</label>
	        </div>
	        <div class="input-field col m6 s12">
	          <input id="pass" name="pass" type="password" style="color: #fff; " required="true">
	          <label for="pass" class="active">Contraseña</label>
	        </div>
	        <div class="col s12">
	        	<input type="submit" value="Ingresar" class="btn full_w">
	        </div>
		</form>
		<hr style="
    margin-top: 28px;
">
		<a href="recuperar_pass.php" class="center" style="color: #fff; width:100%; display:block;">Recuperar Contraseña</a>
	</div>
	
</div>


<script>
	Pace.on("done", function(){
		$("#loader").hide();
	});
	$(document).ready(function(){
		
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
