<?php
    include("scripts/config.php");
    if(isset($_POST['submit']) && isset($_FILES['imagen']) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $Nombre =   mysqli_real_escape_string($conn,$_POST['nombre'])    ;
        $ApPaterno =mysqli_real_escape_string($conn,$_POST['ApellidoPat']);
        $ApMaterno =mysqli_real_escape_string($conn,$_POST['ApellidoMat']);
        $Email =    mysqli_real_escape_string($conn,$_POST['email']);
        $Pass =     mysqli_real_escape_string($conn,$_POST['password']);
        $Genero =   mysqli_real_escape_string($conn,$_POST['Genero']);
        
        $date = $_POST['FechaDeNacimiento']; 
        $formatted_date = date('Ymd', strtotime($date));
        $FechaDeNac=mysqli_real_escape_string($conn, $formatted_date);

        $isMaestro =mysqli_real_escape_string($conn, isset($_POST['esMaestro']) ? 1 : 0);



        $Imagen =   $_FILES['imagen'];

        //print_r($isMaestro);

        $img_name       = $_FILES['imagen']['name'];
        $img_type       = $_FILES['imagen']['type'];
        $img_size       = $_FILES['imagen']['size'];
        $img_temp_name  = $_FILES['imagen']['tmp_name'];
        $img_error      = $_FILES['imagen']['error'];

        //Validate Imaagen
        if($img_error===0){
            if($img_size > 125000){
                $em= "Su archivo es demasiado grande, no puede ser mas de 1MB.";
                 echo "<script type='text/javascript'>alert('$em');</script>";
                header("Location: signin.php?error=$em");
            }else{
                $img_ex =pathinfo($img_name,PATHINFO_EXTENSION);
                $img_ex_lc= strtolower($img_ex);

                $allowed_exs = array("jpg","jpeg","png");
                if (in_array($img_ex_lc,$allowed_exs)) {
                    
                    $new_img_name= uniqid("IMG-", true).".".$img_ex_lc;

                    $sql ="call SP_UsuarioManage('A', 0, '$Nombre' ,  '$ApPaterno', '$ApMaterno', '$Email', '$Pass', '$Genero', $FechaDeNac, '$new_img_name', $isMaestro);";

                    if(mysqli_query($conn,$sql)){
                        
                        $img_upload_path = 'profilePictures/ImagenesSubidasPorUsuarios/'.$new_img_name;
                        move_uploaded_file($img_temp_name,$img_upload_path);
                        $message = 'Registro exitoso, redirigiendo al inicio de sesion...';
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        header('Location: Login.php');

                    }else{

                        $message = 'Error de Base de datos: ' . mysqli_error($conn);
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        header("Location: signin.php?error=$message");

                    }

                }else{
                    $em= "No puede subir ese tipo de archivo, necesita ser de imagen (png, jpg, jepg) Favor de Volverlo a intentar";
                    echo "<script type='text/javascript'>alert('$em');</script>";
                    header("Location: signin.php?error=$em");
                }
            }
        }
        else{
            $em= "Acaba de ocurrir un error desconocido con la imagen. Porfavor Vuelvalo a intentar";
            echo "<script type='text/javascript'>alert('$em');</script>";
            header("Location: signin.php?error=$em");
        }


        //echo "<pre>";
        //echo $Nombre . " , " . $ApPaterno." , ". $ApMaterno." , ". $Email." , ". $Pass." , ". $Genero." , ". $FechaDeNac." , ". $isMaestro;


        /*
        $sql ="call SP_UsuarioManage('$op', 0, '$Nombre' ,  '$ApPaterno', '$ApMaterno', '$Email', '$Pass', '$Genero', $FechaDeNac, '$Imagen', $isMaestro);";
        

        if(mysqli_query($conn,$sql)){
            $message = 'Registro exitoso, redirigiendo al inicio de sesion...';
            echo "<script type='text/javascript'>alert('$message');</script>";
            header('Location: Login.php');
        }else{
            $message = 'Query error: ' . mysqli_error($conn);
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        */
        
    }


?>