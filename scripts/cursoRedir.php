<?php

$cursoid= $_GET['id'];
require_once("userClass.php");
$usuario = SetUserFromToken();

if($usuario->isMaestro || $usuario->isAdmin){
    header("Location: ../cursoInfoMaestro.php?id=".$cursoid);

}
else{
    header("Location: ../cursoInfo.php?id=".$cursoid);
}
?>