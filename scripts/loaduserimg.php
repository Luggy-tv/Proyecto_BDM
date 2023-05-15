<?php
include_once("./userClass.php");
    $usuario = SetUserFromToken();
    $userImageEx = $usuario->ImagenEx;
    header("Content-type: image/{$userImageEx}");
    echo $usuario->Imagen;
?>