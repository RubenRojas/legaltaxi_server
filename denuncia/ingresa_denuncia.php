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

//ingresa_denuncia.php?email=rubro1991@hotmail.com&patente=VV-VV-VV&lat=-35.4316523&lon=-71.6646835
//email
//patente
//lat
//lon
//id_movil
$ORIGEN = "";
$url = "http://nominatim.openstreetmap.org/reverse?format=json&lat=".$lat."&lon=".$lon."&zoom=18&addressdetails=1&email= ";
$json = file_get_contents($url);
$obj = json_decode($json);
$ciudad =  $obj->address->city;


if($id_movil==""){
    //usuario
    $ORIGEN = "CLIENTE/";
    $campos = array("email"=>$email, "patente"=>$patente, "ciudad"=>$ciudad "fecha"=>$HOY, "hora"=>$AHORA, "lat"=>$lat, "lon"=>$lon, "origen"=>"1");    

}
else{
    //taxista
    $ORIGEN="CHOFER/";
    $id_chofer = get_campo("movil", "id_chofer", $id_movil, $mysqli);
    $campos = array("id_movil"=>$id_movil, "patente"=>$patente, "ciudad"=>$ciudad "id_chofer"=>$id_chofer, "fecha"=>$HOY, "hora"=>$AHORA, "lat"=>$lat, "lon"=>$lon, "origen"=>"2");
}

$id_denuncia = insert("denuncia", $campos, $mysqli);




$target_path = "/home4/alvarube/public_html/legaltaxi/IMG_DENUNCIAS/".$ORIGEN.$id_denuncia;
if(!is_dir($target_path)){
    mkdir($target_path);
}



for($i=1;$i<=3;$i++){
    $file_tmp = $_FILES['image'.$i]["tmp_name"];
    $file_name=$_FILES["image".$i]["name"];
    $Final_file_path = $target_path."/".basename($file_name);
    $URL_ARCHIVO = "https://www.legaltaxi.cl/IMG_DENUNCIAS/".$ORIGEN.$id_denuncia."/".basename($file_name);

    if(move_uploaded_file($file_tmp, $Final_file_path)){
        echo $Final_file_path." SUBIDO\n";
        echo $URL_ARCHIVO." SUBIDO\n";
        $query = "insert into denuncia_imagen(id_denuncia, url) values('$id_denuncia', '$URL_ARCHIVO')";
        $result = $mysqli->query($query);
    }
    else{
        echo $Final_file_path.' PROBLEMA';
    }
}



?>