<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}

include("userClass.php");

$idUsuario = getIDFromToken();
$idCurso=$_POST['curso'];
$comentario=$_POST['comment'];
$calif=     $_POST['calif'];

print_r($idUsuario);
print_r($idCurso);
print_r($comentario);
print_r($calif);

include_once("cursoClass.php");

calificacionInsert($idUsuario,$idCurso,$comentario,$calif);

header("Location:../cursoinfo.php?id=".$idCurso);
?>