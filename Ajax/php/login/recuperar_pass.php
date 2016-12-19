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
extract($_POST);
$email = strtoupper($email);
$user = select("user_app", array("*"), array("email"=>$email), array("limit"=>"1"), $mysqli);

//incluimos la clase PHPMailer
//Create a new PHPMailer instance
$mail = new PHPMailer;
// Set PHPMailer to use the sendmail transport
$mail->isSendmail();
//Set who the message is to be sent from
$mail->setFrom('no-responder@legaltaxi.cl', 'No Responder');
//Set an alternative reply-to address
$mail->addReplyTo('no-responder@legaltaxi.cl', 'No Responder');
//Set who the message is to be sent to
$mail->addAddress($user['email'], $user['nombre']);
//Set the subject line
$mail->Subject = 'Recuperacion de Password';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML('<img src="https://legaltaxi.cl/legaltaxi/assets/img/appicon_2.png" alt="" id="logo" class="" style="height: 120px;width: auto;margin-top: 0;display: block;margin: auto;"> <h3>Recuperacion de Password</h3> <p>Estimado '.$user['nombre'].', su password para acceder a Legaltaxi es: <b>'.$user['pass'].'</b></p> <p style=" ">Gracias por su preferencia! </p>');
//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors

if (!$mail->send()) {
    $_SESSION['error'] = "El correo ingresado no es válido.";
	header("location: /legaltaxi/index.php");
} else {
    $_SESSION['msg'] = "Se envió un correo a ".$user['email']." con su contraseña.";
	header("location: /legaltaxi/index.php");
}