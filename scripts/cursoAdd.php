<?php

if (isset($_FILES['imagenDeCurso'])) {
    include("config.php");
    $nombreCurso = mysqli_real_escape_string($conn, $_POST["nombreCurso"]);
    $idCategoria = mysqli_real_escape_string($conn, $_POST["categoria"]);
    $descripcionCurso = mysqli_real_escape_string($conn, $_POST["descCurso"]);
    $precioCurso = mysqli_real_escape_string($conn, $_POST["precioCurso"]);
    $numModulos = mysqli_real_escape_string($conn, $_POST["numModulos"]);

    $imagen = $_FILES["imagenDeCurso"];
    $img_type = $_FILES['imagenDeCurso']['type'];
    $img_size = $_FILES['imagenDeCurso']['size'];
    $img_name = $_FILES['imagenDeCurso']['name'];
    $img_temp_name = $_FILES['imagenDeCurso']['tmp_name'];
    $img_temp_name_str = mysqli_real_escape_string($conn, file_get_contents($_FILES['imagenDeCurso']['tmp_name']));
    $img_error = $_FILES['imagenDeCurso']['error'];

    if ($img_error === 0) {
        if ($img_size > 1000000) {
            $response = array(
                'success' => false,
                'message' => 'Su archivo es demasiado grande, no puede ser mas de 1MB'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                include("cursoClass.php");
                
                if (addCurso($nombreCurso, $descripcionCurso, $precioCurso, $img_ex_lc, $img_temp_name_str, $idCategoria)) {
                    $response = array(
                        'success' => true,
                        'message' => 'Curso subido a la base de datos',
                        'data'    => ''
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }else{
                    $response = array(
                        'success' => false,
                        'message' => 'Hubo un error con la base de datos al subir el curso porfavor de volver a intentarlo'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'No puede subir ese tipo de archivo, necesita ser de imagen (png, jpg, jepg) Favor de Volverlo a intentar'
                );
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Acaba de ocurrir un error desconocido con la imagen. Porfavor Vuelvalo a intentar'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    $response = array(
        'success' => false,
        'message' => 'No se agrego imagen de forma correcta'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>