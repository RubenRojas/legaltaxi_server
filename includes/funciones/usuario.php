<?php 
function getUsuario($email, $mysqli){
	if($email!=""){
		$result = select("user_app", array("*"), array("email"=>$email), array("limit"=>"1"), $mysqli);
		return $result;	
	}
	
}
function valida_login($email, $pass, $mysqli){
	$result = select("user_app", array("*"), array("email"=>$email, "pass"=>$pass), array("limit"=>"1"), $mysqli);
	return $result;
}
function existe_mail($email, $mysqli){
	$result = select("user_app", array("email"), array("email"=>$email), array("limit"=>"1"), $mysqli);
	return $result;
}