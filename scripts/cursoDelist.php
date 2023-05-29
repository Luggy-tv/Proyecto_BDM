<?php

include("config.php");

$id_Curso = mysqli_real_escape_string($conn,$_POST["id_curso"]);
include("cursoClass.php");

if(deslistarCurso($id_Curso)){

    $response = array(
        'success' => true,
        'message' => "Se ha deslistado el curso."
    );
    header('Content-Type: application/json');
    echo json_encode($response);

}else{

    $response = array(
        'success' => false,
        'message' => "Hubo un error en la coneccion a la base de datos favor de volver a hacer click en el boton de delistar"
    );
    header('Content-Type: application/json');
    echo json_encode($response);


}
?>