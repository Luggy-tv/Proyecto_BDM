<?php
if (isset($_FILES["videoModulo"])) {
    include("config.php");

    $id_Modulo = $_POST["id_Modulo"];
    $nombreModulo = mysqli_real_escape_string($conn, $_POST["nombreModulo"]);
    $descripcionModulo = mysqli_real_escape_string($conn, $_POST["descripcionModulo"]);
    $precioModulo = mysqli_real_escape_string($conn, $_POST["precioModulo"]);

    $videoFile = $_FILES['videoModulo'];
    $videoFile_type = $_FILES['videoModulo']['type'];
    $videoFile_name = $_FILES['videoModulo']['name'];
    $videoFile_tmp_name = $_FILES['videoModulo']['tmp_name'];
    $videoFile_error = $_FILES['videoModulo']['error'];
    $videoFile_size = $_FILES['videoModulo']['size'];

    if ($videoFile_error !== 0) {
        $response = array(
            'success' => false,
            'message' => 'Ocurrió un error durante la carga del video, favor de volver a intentarlo.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    if (isset($_FILES['adjuntoModulo'])) {

        $descripcionAdjModulo = mysqli_real_escape_string($conn, $_POST['descripcionAdjModulo']);

        $adjuntoModulo = $_FILES['adjuntoModulo'];
        $adjuntoModulo_type = $_FILES['adjuntoModulo']['type'];
        $adjuntoModulo_name = $_FILES['adjuntoModulo']['name'];
        $adjuntoModulo_tmp_name = $_FILES['adjuntoModulo']['tmp_name'];
        $adjuntoModulo_error = $_FILES['adjuntoModulo']['error'];
        $adjuntoModulo_size = $_FILES['adjuntoModulo']['size'];

    } else {
        $adjuntoModulo = null;
        $descripcionAdjModulo = null;
    }


    $allowedExtensions = array('mp4', 'mov');

    $fileExtension = strtolower(pathinfo($videoFile_name, PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {

        $response = array(
            'success' => false,
            'message' => 'El archivo debe ser un video en formato MP4 o MOV.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;

    }

    $uploadDirectory = '../Videos_Modulos/';
    $newFileName = uniqid() . '_' . $videoFile_name;
    $destination = $uploadDirectory . $newFileName;


    if (!move_uploaded_file($videoFile_tmp_name, $destination)) {
        $response = array(
            'success' => false,
            'message' => 'Hubo un error con el manejo del video favor de volverlo a subir'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    include("cursoClass.php");

    $result = editModulo($id_Modulo, $nombreModulo, $descripcionModulo, $precioModulo, $destination);

    if ($result) {

        if (isset($_FILES['adjuntoModulo'])) {


            $ID_adjunto = getAdjuntoIdFromNivelId($id_Modulo);

            if ($ID_adjunto != 0) {

                $uploadDirectory = '../Adjuntos/';

                $newFileName = uniqid() . '_' . $adjuntoModulo_name;

                $destination = $uploadDirectory . $newFileName;

                move_uploaded_file($adjuntoModulo_tmp_name, $destination);

                if (editAdjunto($ID_adjunto, $descripcionAdjModulo, $destination)) {
                    $response = array(
                        'success' => true,
                        'message' => "Se ha actualizado correctamente el modulo y el adjunto se ha editado"
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                } else {
                    $response = array(
                        'success' => false,
                        'message' => "Error en la edicion del adjunto"
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                }



            } else {


                $uploadDirectory = '../Adjuntos/';

                $newFileName = uniqid() . '_' . $adjuntoModulo_name;

                $destination = $uploadDirectory . $newFileName;

                move_uploaded_file($adjuntoModulo_tmp_name, $destination);

                if (addAdjunto($id_Modulo, $adjuntoModuloDescipcion, $destination)) {
                    $response = array(
                        'success' => true,
                        'message' => "Se ha actualizado correctamente el modulo y el adjunto se ha creado"
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                } else {
                    $response = array(
                        'success' => false,
                        'message' => "Error en añadir el adjunto favor de volver lo a mandar"
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;

                }
            }


        }

        $response = array(
            'success' => true,
            'message' => "Se ha actualizado correctamente el modulo"
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;

    } else {

        $response = array(
            'success' => false,
            'message' => "Hubo un error en la coneccion a la base de datos favor de volver a mandar la informacion"
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;

    }


} else {
    $response = array(
        'success' => false,
        'message' => 'No se agrego un video para el modulo favor de agregarlo'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>