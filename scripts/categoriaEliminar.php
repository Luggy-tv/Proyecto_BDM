<?php

    include("config.php");
    
    // $Nombre = mysqli_real_escape_string($conn, $_POST['NomCategoria']);
    // $Desc = mysqli_real_escape_string($conn, $_POST['DescCategoria']);

    $id =mysqli_real_escape_string($conn,  $_POST['id']);

    // print_r($id);


    include("categoriasClass.php");
    deleteCategoria($id);
    $listaNuevasCat = setCategoriasLista();

    $response = array(
        'success' => true,
        'message' => 'Objeto Eiminado',
        'data' => $listaNuevasCat
    );


    header('Content-Type: application/json');
    echo json_encode($response);

?>