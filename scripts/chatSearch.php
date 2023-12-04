<?php
include("config.php");
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

include_once("userClass.php");
$usuario = getIDFromToken();

$sql = "call SP_SelectBuscarUsuarioPChat($usuario,'$searchTerm');";
$result = mysqli_query($conn, $sql);
$output = "";

if (mysqli_num_rows($result) == 0) {
    $output = "No se encuentan usuarios disponibles";
} elseif (mysqli_num_rows($result) > 0) {
   include('chatUserlistData.php');
}

echo $output;

?>