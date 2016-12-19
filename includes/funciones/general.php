<?php
/*
select("tabla", array("nombre", "id"), array("nombre"=>"juan", "id"=>"5"), array("limit"=>"1", "order by"=>"id asc"), $mysqli);
insert("chofer", $_POST, array(), $mysqli);
update("chofer", $_POST, array("id"=>$_POST['id']), array("limit"=>"1"), $mysqli);
deleteDB("chofer", $_POST, array("limit"=>"1"), $mysqli);
s*/
/*******************************/
//	GLOBALES
/*******************************/
function addOpciones($opciones){
	$query ="";
	foreach ($opciones as $clave => $valor) {
		$query.= " ".$clave." ".$valor."";
	}
	return $query;
}
function addCondiciones($condiciones){
	if(count($condiciones)>0){ $query =" where "; }
	else{ $query=""; }
	foreach ($condiciones as $campo => $valor) {
		$query.= $campo."='".$valor."' and ";
	}
	$query = substr($query, 0, -5);
	return $query;
}
/*******************************/
//	SELECT
/*******************************/
function addCampos_select($campos){
	$query = "select ";
	foreach($campos as $campo){
		$query .= $campo.", ";
	}
	$query = substr($query, 0, -2);	
	return $query;
}
function select($tabla, $campos, $condiciones, $opciones, $mysqli){
	//$chof = select("chofer", array("*"), array("id"=>$id), array("limit"=>"1"), $mysqli);
	$query = addCampos_select($campos);	
	$query.=" from ".$tabla." ";
	$query.=addCondiciones($condiciones);
	$query.=addOpciones($opciones);
	//echo'<hr>'.$query.'<hr>';
	$result = $mysqli->query($query); 
	if($opciones['limit']=="1"){
		$arr = $result->fetch_assoc();
		return $arr;
	}
	else{
		return $result;	
	}
}
function selectAll($tabla, $campos, $mysqli){
	$query = addCampos_select($campos);
	$query.=" from ".$tabla;
	$result = $mysqli->query($query);
	return $result;
}
/*******************************/
//	INSERT
/*******************************/
function addCampos_insert($campos){
	$query = "(";
	if(count($campos)>0){
		foreach ($campos as $campo => $valor) {
			$query .= $campo.", ";
		}
		$query = substr($query, 0, -2);
	}
	$query.=")";
	return $query;
}
function addValues_insert($campos){
	$query = " values(";
	if(count($campos)>0){
		foreach($campos as $campo){
			$query .= "'".strtoupper($campo)."', ";
		}
		$query = substr($query, 0, -2);
	}
	$query.=")";
	return $query;
}
function insert($tabla, $campos, $mysqli){
	$query ="insert into ".$tabla;
	$query.= addCampos_insert($campos);
	$query.= addValues_insert($campos);
	//echo'<hr>'.$query.'<hr>';
	$result = $mysqli->query($query);
	return $mysqli->insert_id ;
}
/*******************************/
//	UPDATE
/*******************************/
function addCampos_update($campos){
	foreach ($campos as $campo => $valor) {
		$query .= $campo." = '".strtoupper($valor)."', ";
	}
	$query = substr($query, 0, -2);
	return $query;
}
function update($tabla, $campos, $condiciones, $opciones, $mysqli){
	$query ="update ".$tabla." set ";
	$query.= addCampos_update($campos);
	$query.= addCondiciones($condiciones);
	$query.= addOpciones($opciones);
	$result = $mysqli->query($query);
	return $result ;
}
/*******************************/
//	DELETE
/*******************************/
function deleteDB($tabla, $condiciones, $opciones, $mysqli){
	$query ="delete from ".$tabla." ";
	$query.= addCondiciones($condiciones);
	$query.= addOpciones($opciones);
	$result = $mysqli->query($query);
	//return $result ;
}
/*******************************/
//	DEVELOP
/*******************************/
function select_dev($tabla, $campos, $condiciones, $opciones, $mysqli){
	//$chof = select("chofer", array("*"), array("id"=>$id), array("limit"=>"1"), $mysqli);
	$query = addCampos_select($campos);	
	$query.=" from ".$tabla." ";
	$query.=addCondiciones($condiciones);
	$query.=addOpciones($opciones);
	echo'<hr>'.$query.'<hr>';
	$result = $mysqli->query($query); 
	if($opciones['limit']=="1"){
		$arr = $result->fetch_assoc();
		return $arr;
	}
	else{
		return $result;	
	}
}
function insert_dev($tabla, $campos, $mysqli){
	$query ="insert into ".$tabla;
	$query.= addCampos_insert($campos);
	$query.= addValues_insert($campos);
	echo'<hr>'.$query.'<hr>';
	$result = $mysqli->query($query);
	return $mysqli->insert_id ;
}
function update_dev($tabla, $campos, $condiciones, $opciones, $mysqli){
	$query ="update ".$tabla." set ";
	$query.= addCampos_update($campos);
	$query.= addCondiciones($condiciones);
	$query.= addOpciones($opciones);
	echo'<hr>'.$query.'<hr>';
	$result = $mysqli->query($query);
	return $result ;
}
function deleteDB_dev($tabla, $condiciones, $opciones, $mysqli){
	$query ="delete from ".$tabla." ";
	$query.= addCondiciones($condiciones);
	$query.= addOpciones($opciones);
	echo'<hr>'.$query.'<hr>';
	$result = $mysqli->query($query);
	return $result ;
}
function get_campo_dev($tabla,$campo, $id, $mysqli){
	$arr = select_dev($tabla, array($campo), array("id"=>$id), array("limit"=>"1"), $mysqli);
	return $arr[$campo];
}
function show_option_campos_dev($tabla, $id_ant, $campos, $condiciones, $opciones, $mysqli){
	$result = select_dev($tabla, $campos, $condiciones, $opciones, $mysqli);
	while ($arr = $result->fetch_array()) {
		?>
		<option value="<?=$arr[0]?>" <?php if($arr[0]==$id_ant){ ?>selected<?php } ?>><?=$arr[1]?></option>
		<?php
	}
}
/*******************************/
//	OTROS
/*******************************/
function show_option($tabla, $id_ant ,$mysqli){
	if(in_array($tabla, array("op_auto_grupos", "op_tipo_contrato", "op_auto_estado", "movil_paradero", "op_monto_pactado", "socio"))){
		$result = select($tabla, array("id", "nombre"), array("id_emp"=>$_SESSION['id_emp']), array(), $mysqli);
	}
	else{
		$result = selectAll($tabla, array("id", "nombre"), $mysqli);	
	}
	?>
	<option value=""></option>
	<?php
	while ($arr = $result->fetch_assoc()) {
		?>
		<option value="<?=$arr['id']?>" <?php if($arr['id']==$id_ant){ ?>selected<?php } ?>><?=$arr['nombre']?></option>
		<?php
	}
}
function show_option_campos($tabla, $id_ant, $campos, $condiciones, $opciones, $mysqli){
	$result = select($tabla, $campos, $condiciones, $opciones, $mysqli);
	while ($arr = $result->fetch_array()) {
		?>
		<option value="<?=$arr[0]?>" <?php if($arr[0]==$id_ant){ ?>selected<?php } ?>><?=$arr[1]?></option>
		<?php
	}
}
function get_campo($tabla,$campo, $id, $mysqli){
	$arr = select($tabla, array($campo), array("id"=>$id), array("limit"=>"1"), $mysqli);
	return $arr[$campo];
}
?>