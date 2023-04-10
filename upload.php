<?php

if (isset($_POST['submit']) && isset($_FILES['imagen']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    include("scripts/config.php");
    $Nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $ApPaterno = mysqli_real_escape_string($conn, $_POST['ApellidoPat']);
    $ApMaterno = mysqli_real_escape_string($conn, $_POST['ApellidoMat']);
    $Email = mysqli_real_escape_string($conn, $_POST['email']);
    $Pass = mysqli_real_escape_string($conn, $_POST['password']);
    $Genero = mysqli_real_escape_string($conn, $_POST['Genero']);

    $date = $_POST['FechaDeNacimiento'];
    $formatted_date = date('Ymd', strtotime($date));
    $FechaDeNac = mysqli_real_escape_string($conn, $formatted_date);

    $isMaestro = mysqli_real_escape_string($conn, isset($_POST['esMaestro']) ? 1 : 0);

    $Imagen = $_FILES['imagen'];

    $img_name = $_FILES['imagen']['name'];
    $img_type = $_FILES['imagen']['type'];
    $img_size = $_FILES['imagen']['size'];
    $img_temp_name = $_FILES['imagen']['tmp_name'];
    $img_error = $_FILES['imagen']['error'];

    if (!ValidaEmail($Email)) {
        //Validate Imagen
        if ($img_error === 0) {
            if ($img_size > 125000) {
                $em = "Su archivo es demasiado grande, no puede ser mas de 1MB.";
                echo "<script type='text/javascript'>alert('$em');</script>";
                header("Location: signin.php?error=$em");
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");
                if (in_array($img_ex_lc, $allowed_exs)) {

                    $new_img_name = uniqid("IMG-", true) . "." . $img_ex_lc;

                    $sql = "call SP_UsuarioManage('A', 0, '$Nombre' ,  '$ApPaterno', '$ApMaterno', '$Email', '$Pass', '$Genero', $FechaDeNac, '$new_img_name', $isMaestro);";

                    if (mysqli_query($conn, $sql)) {

                        $img_upload_path = 'profilePictures/ImagenesSubidasPorUsuarios/' . $new_img_name;
                        move_uploaded_file($img_temp_name, $img_upload_path);
                        $em = 'Registro exitoso. Se ha redirigido al inicio de sesion...';
                        // echo "<script type='text/javascript'>alert('$em');</script>";
                        header("Location: login.php?success=$em");

                    } else {

                        $em = 'Error de Base de datos: ' . mysqli_error($conn);
                        //echo "<script type='text/javascript'>alert('$em');</script>";
                        header("Location: signin.php?error=$em");

                    }

                } else {
                    $em = "No puede subir ese tipo de archivo, necesita ser de imagen (png, jpg, jepg) Favor de Volverlo a intentar";
                    //echo "<script type='text/javascript'>alert('$em');</script>";
                    header("Location: signin.php?error=$em");
                }
            }
        } else {
            $em = "Acaba de ocurrir un error desconocido con la imagen. Porfavor Vuelvalo a intentar";
            echo "<script type='text/javascript'>alert('$em');</script>";
            header("Location: signin.php?error=$em");
            mysqli_close($conn);
        }
    } else {
        $em = "Ese correo electronico ya se encuentra en uso, utilice uno diferente";
        echo "<script type='text/javascript'>alert('$em');</script>";
        header("Location: signin.php?error=$em");
        mysqli_close($conn);
    }


}

function ValidaEmail($emailInput)
{
    include("scripts/config.php");
    $sql = "call SP_SelectTables(2);";
    $result = mysqli_query($conn, $sql);
    $emails = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $emailFound = false;
    foreach ($emails as $email) {
        if ($email['email'] == $emailInput) {
            $emailFound = true;
            break;
        }
    }

    if ($emailFound) {
        //echo "Email found in the database!";
        return true;
    } else {
        //echo "Email not found in the database.";
        return false;
    }
}



?>