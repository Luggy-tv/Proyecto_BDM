<?php

include("config.php");

include_once("userClass.php");
$usuario = getIDFromToken();

$sql = "call SP_SelectUsuarioActivosExceptCurrentUser($usuario);";
$result = mysqli_query($conn, $sql);
$output = "";

if (mysqli_num_rows($result) == 0) {
    $output = "No se encuentan usuarios disponibles";
} elseif (mysqli_num_rows($result) > 0) {
    include('chatUserlistData.php');
}

echo $output;
?>