<?php

include("config.php");

include("userClass.php");

$ID_Incoming = mysqli_real_escape_string($conn, $_POST['id_usuario']);
$message = mysqli_real_escape_string($conn, $_POST['InputField']);

if(!empty($message)){
    $ID_Outgoing=getIDFromToken();

    $sql="call SP_MensajesAgregar($ID_Incoming,$ID_Outgoing,'$message');";
    $result = mysqli_query($conn, $sql);
}
    $response = array(
        'success' => true,
        'message' => 'Objeto agregado correctamente',
        'data' => ''
    );

    header('Content-Type: application/json');
    echo json_encode($response);
?>