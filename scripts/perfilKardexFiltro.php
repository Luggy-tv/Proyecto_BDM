<?php 
$fecha=NULL;
$idCategoria=NULL;
$estatus=NULL;

if(isset($_POST['fecha'])){
    $fecha = $_POST['fecha'];
}

if(isset($_POST['categoria'])){
    $idCategoria = $_POST['categoria'];
}

if(isset($_POST['estatus'])){
    $estatus = $_POST['estatus'];
}

include_once('userClass.php');
$response = getKardexFiltro($fecha,$idCategoria,$estatus);
echo json_encode($response);


?>