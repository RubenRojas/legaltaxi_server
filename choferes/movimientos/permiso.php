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
extract($_GET);


//login, pass, accion

$query ="select movil.id_emp, movil.id from chofer inner join movil on movil.id_chofer = chofer.id where chofer.login='$login' and chofer.pass='$pass' limit 1";
$result = $mysqli->query($query);
$data = $result->fetch_assoc();


if($accion=='inicia'){
	$estado_turno= 3;	
	$OP = get_opciones($data['id_emp'], $mysqli);
	$movil = select("movil", array("id, estado_turno, codigo"), array("id"=>$data['id'], "id_emp"=>$data['id_emp']), array("limit"=>"1"), $mysqli);	
	$query = "select fecha, hora_regreso from movil_permiso where id_emp='$data[id_emp]' and id_movil ='$movil[id]' order by id desc limit 1";
	$result = $mysqli->query($query);
	$ultimo_permiso = $result->fetch_assoc();

	if($OP['LEGAL_AUTORIZA_PERMISO']=='SI'){
		if($ultimo_permiso['hora_regreso']!="" or $result->num_rows==0){

			$hora_actual_unix = strtotime(date("Y-m-d H:i"));
			$hora_termino_permiso = strtotime(date($ultimo_permiso['fecha']." ".$ultimo_permiso['hora_regreso']));
			$hora_termino_permiso+=$OP['TIMEPO_ESPERA_ENTRE_PERMISO'] * 60;

			if(($hora_actual_unix <= $hora_termino_permiso) and $ultimo_permiso!=NULL){
				echo'No ha transcurrido el mínimo de tiempo desde el ultimo permiso solicitado.';
			}
			else{
				if($movil['estado_turno']!=2 && $movil['estado_turno']!=4 && $movil['estado_turno']!=3){
					$query ="insert into movil_permiso(id_movil, id_emp, fecha, hora_salida, minutos) values('$movil[id]', '$data[id_emp]', '$HOY', '$AHORA', $OP[TIEMPO_PERMISO])";
					$result = $mysqli->query($query);
					$query = "update movil set estado_turno='3',id_permiso='$mysqli->insert_id' where id='$movil[id]' limit 1";
					$result = $mysqli->query($query);
					insert("log", array("id_emp"=>$data['id_emp'], "fecha"=>$HOY, "hora"=>$AHORA,  "id_movil"=>$data['id'], "mensaje"=>"SALE PERMISO TELEFONO"), $mysqli);
					insert("notificaciones", array("id_emp"=>$data['id_emp'], "mensaje"=>"<b>Movil ".$movil['codigo']."</b> ha salido con permiso.", "estado"=>"ACTIVA", "origen"=>"INICIO_CHOFER"), $mysqli);
					update("empresa",array("last_query"=>$NOW), array("id"=>$data['id_emp']), array("limit"=>"1"), $mysqli);
					$_SESSION['LAST_QUERY'] = $NOW;		
					echo 'true';
				}	
			}
			
		}
		else{
			echo'Aun no ha regresado del ultimo permiso.';
			
		}
	}
	else{
		echo'La central no autoriza el inicio de PERMISO';
	}
}
if($accion=='termina'){
	$movil = select("movil", array("id, estado_turno, codigo"), array("id"=>$data['id'], "id_emp"=>$data['id_emp']), array("limit"=>"1"), $mysqli);	
	if($movil['estado_turno']!=2 && $movil['estado_turno']!=4){
		$estado_turno= 1;	
		$id_permiso = get_campo("movil", "id_permiso", $movil['id'], $mysqli);
		$query = "update movil_permiso set  hora_regreso='$AHORA' where id='$id_permiso' limit 1";
		$result = $mysqli->query($query);
		$query = "update movil set estado_turno='1', id_permiso='' where id='$movil[id]' limit 1";
		$result = $mysqli->query($query);
		insert("log", array("id_emp"=>$data['id_emp'], "fecha"=>$HOY, "hora"=>$AHORA,  "id_movil"=>$data['id'], "mensaje"=>"VUELVE PERMISO TELEFONO"), $mysqli);
		insert("notificaciones", array("id_emp"=>$data['id_emp'], "mensaje"=>"<b>Movil ".$movil['codigo']."</b> ha vuelto del permiso.", "estado"=>"ACTIVA", "origen"=>"INICIO_CHOFER"), $mysqli);
		update("empresa",array("last_query"=>$NOW), array("id"=>$data['id_emp']), array("limit"=>"1"), $mysqli);
		$_SESSION['LAST_QUERY'] = $NOW;
		echo 'true';
	}
	else{
		echo "false";
	}
}

