<?php

   
    

if(isset($_POST['submit']) && isset($_FILES['imagen']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    
    include_once("userClass.php");
    include("config.php");

    $usuario_Actual = SetUserFromToken();

    $Nombre =   mysqli_real_escape_string($conn,$_POST['NuevoNombre'])    ;
    $ApPaterno =mysqli_real_escape_string($conn,$_POST['nuevoApellidoPat']);
    $ApMaterno =mysqli_real_escape_string($conn,$_POST['nuevoApellidoMat']);

    $Pass =     mysqli_real_escape_string($conn,$_POST['password']);

    $Imagen =   $_FILES['Imagen'];

    $img_name       = $_FILES['Imagen']['name'];
    $img_type       = $_FILES['Imagen']['type'];
    $img_size       = $_FILES['Imagen']['size'];
    $img_temp_name  = $_FILES['Imagen']['tmp_name'];
    $img_error      = $_FILES['Imagen']['error'];

    if(ValidPass($usuario_Actual->Email,$Pass)){
        if($img_size > 125000){
            $em= "Su archivo es demasiado grande, no puede ser mas de 1MB.";
            echo "<script type='text/javascript'>alert('$em');</script>";
            header("Location: http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/editperfil.php?error=$em");

        }else{


            $img_ex =pathinfo($img_name,PATHINFO_EXTENSION);
            $img_ex_lc= strtolower($img_ex);
            $allowed_exs = array("jpg","jpeg","png");
            if (in_array($img_ex_lc,$allowed_exs)) {

                $ID_Usuario = getIDFromToken();
                
                $sql ="call SP_UsuarioManage('B', $ID_Usuario , '$Nombre' , '$ApPaterno' , '$ApMaterno' ,'','','','','$new_img_name','');";
                
                if(mysqli_query($conn,$sql)){

                    $filename = 'profilePictures/ImagenesSubidasPorUsuarios/'. $usuario_Actual->Imagen;

                    if (file_exists($filename)) {
                        if (unlink($filename)) {
                            echo "File deleted successfully.";
                        }
                    }

                    
                    $img_upload_path = 'profilePictures/ImagenesSubidasPorUsuarios/'. $new_img_name;
                    move_uploaded_file($img_temp_name,$img_upload_path);
                    $em = 'Se han cambiado los datos de forma exitosa...';
                    // echo "<script type='text/javascript'>alert('$em');</script>";
                    header("Location:  http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/editperfil.php?success=$em");

                }else{

                    $em = 'Error de Base de datos: ' . mysqli_error($conn);
                    //echo "<script type='text/javascript'>alert('$em');</script>";
                    header("Location:  http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/editperfil.php?error=$em");

                }

            }else{
                $em= "No puede subir ese tipo de archivo, necesita ser de imagen (png, jpg, jepg) Favor de Volverlo a intentar";
                //echo "<script type='text/javascript'>alert('$em');</script>";
                header("Location: http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/editperfil.php?error=$em");

            }

        }
    }else{
        $em= "La contraseña no es correcta, porfavor introduzca la contraseña con la que inicio sesion.";
        header("Location: http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/editperfil.php?error=$em");
    }
            
}
function ValidPass($emailInput,$passImput){
    include("config.php");
    
    $sql = "call SP_SelectPassFromEmail('$emailInput'); ";
    
    $result =mysqli_query($conn,$sql);

    $passwords =mysqli_fetch_all($result, MYSQLI_ASSOC);
    $passMatch =false;

    foreach($passwords as $password){
        if($password['pass']==$passImput){
            $passMatch = true;
            break;
        }
    }
    
    if ($passMatch) {
        //echo "Pass is the same in db";
        return true;
    } else {
        //echo "Pass is not found in db";
        return false;
    }
}

?>