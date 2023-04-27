<?php
include_once("./userClass.php");
    $usuario = SetUserFromToken();
    header("Content-type: image/jpeg");
    echo $usuario->Imagen;
?>