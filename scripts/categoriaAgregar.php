<?php

    include("config.php");

    $Nombre = mysqli_real_escape_string($conn, $_POST['NomCategoria']);
    $Desc = mysqli_real_escape_string($conn, $_POST['DescCategoria']);

    include("categoriasClass.php");
    addCategoria($Nombre, $Desc);
    
    $listaNuevasCat = setCategoriasLista();

    $response = array(
        'success' => true,
        'message' => 'Objeto agregado correctamente',
        'data' => $listaNuevasCat
    );


    header('Content-Type: application/json');
    echo json_encode($response);

?>