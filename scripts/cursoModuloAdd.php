<?php
if (isset($_FILES['videoModulo'])) {

    include("config.php");
    $nombreCurso = mysqli_real_escape_string($conn, $_POST['nombreCurso']);
    $nombreModulo = mysqli_real_escape_string($conn, $_POST["nombreModulo"]);
    $descripcionModulo = mysqli_real_escape_string($conn, $_POST["descModulo"]);
    $precioModulo = mysqli_real_escape_string($conn, $_POST["precioModulo"]);

    $adjuntoModuloDescipcion = mysqli_real_escape_string($conn, $_POST['adjModuloDesc']);

    $videoFile = $_FILES['videoModulo'];
    $videoFile_type = $_FILES['videoModulo']['type'];
    $videoFile_name = $_FILES['videoModulo']['name'];
    $videoFile_tmp_name = $_FILES['videoModulo']['tmp_name'];
    $videoFile_error = $_FILES['videoModulo']['error'];
    $videoFile_size = $_FILES['videoModulo']['size'];

    //Hubo un error en el video
    if ($videoFile_error !== 0) {
        $response = array(
            'success' => false,
            'message' => 'Ocurrió un error durante la carga del video, favor de volver a intentarlo.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    //Defincion de adjuntos
    if (isset($_FILES['adjuntoModulo'])) {
        $adjuntoModulo = $_FILES['adjuntoModulo'];
        $adjuntoModulo_type = $_FILES['adjuntoModulo']['type'];
        $adjuntoModulo_name = $_FILES['adjuntoModulo']['name'];
        $adjuntoModulo_tmp_name = $_FILES['adjuntoModulo']['tmp_name'];
        $adjuntoModulo_error = $_FILES['adjuntoModulo']['error'];
        $adjuntoModulo_size = $_FILES['adjuntoModulo']['size'];

    }



    if ($adjFlag == 1) {
        $response = array(
            'success' => false,
            'message' => 'Si se añade un adjunto se tiene que agregar, ambas cosas la descripcion y el archivo. Favor de agregarlo'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }


    $allowedExtensions = array('mp4', 'mov');

    $fileExtension = strtolower(pathinfo($videoFile_name, PATHINFO_EXTENSION));

    //Se checa si es mp4 o mov
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
    //Se mueve al nuevo directorio
    if (!move_uploaded_file($videoFile_tmp_name, $destination)) {
        $response = array(
            'success' => false,
            'message' => 'Hubo un error con el manejo del video favor de volverlo a subir'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    //Se sube a la base de datos y se guarda la direccion del modulo
    include("cursoClass.php");
    $row = getCursoFromTituloAndCurrUser($nombreCurso);
    $result = addModulo($row[0]['id_Curso'], $destination, $descripcionModulo, $precioModulo, $nombreModulo);
    if ($result) {

        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $nivelCursoID = $row[0]['ultimo_id'];

        $uploadDirectory = '../Adjuntos/';

        $newFileName = uniqid() . '_' . $adjuntoModulo_name;
        $destination = $uploadDirectory . $newFileName;

        move_uploaded_file($adjuntoModulo_tmp_name, $destination);

        addAdjunto($nivelCursoID, $adjuntoModuloDescipcion, $destination);


        $response = array(
            'success' => true,
            'message' => "Modulo subido, continua con el siguiente"
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;


    } else {
        $response = array(
            'success' => false,
            'message' => 'Hubo un error con la coneccion a la base de datos, favor de volver a intentarlo'
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