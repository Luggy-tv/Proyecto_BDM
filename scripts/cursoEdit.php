<?php
if (isset($_FILES['editImagenDeCurso'])) {

    include("config.php");
    $id_Curso = mysqli_real_escape_string($conn, $_POST["idCurso"]);
    $nombreCurso = mysqli_real_escape_string($conn, $_POST["editNombreCurso"]);
    $idCategoria = mysqli_real_escape_string($conn, $_POST["categoria"]);
    $descripcionCurso = mysqli_real_escape_string($conn, $_POST["editDescCurso"]);
    $precioCurso = mysqli_real_escape_string($conn, $_POST["editPrecioCurso"]);

    $imagen = $_FILES["editImagenDeCurso"];
    $img_type = $_FILES['editImagenDeCurso']['type'];
    $img_size = $_FILES['editImagenDeCurso']['size'];
    $img_name = $_FILES['editImagenDeCurso']['name'];
    $img_temp_name = $_FILES['editImagenDeCurso']['tmp_name'];
    $img_temp_name_str = mysqli_real_escape_string($conn, file_get_contents($_FILES['editImagenDeCurso']['tmp_name']));
    $img_error = $_FILES['editImagenDeCurso']['error'];

    if ($img_error === 0) {
        if ($img_size > 1000000) {
            $response = array(
                'success' => false,
                'message' => 'Su archivo es demasiado grande, no puede ser mas de 1MB'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;

        } else {

            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {

                include("cursoClass.php");
                if (editCurso($id_Curso, $nombreCurso, $descripcionCurso, $precioCurso, $img_temp_name_str, $img_ex_lc, $idCategoria)) {
                    $response = array(
                        'success' => true,
                        'message' => 'Curso editado, si quiere ver los datos editados favor de recargar la pagina'
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);

                } else {
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
        exit;
    }
} else {
    $response = array(
        'success' => false,
        'message' => 'No se agrego imagen de forma correcta'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}


?>