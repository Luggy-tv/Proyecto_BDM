<?php



if (!isset($_COOKIE['sessionToken']) || empty($_COOKIE['sessionToken'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");
  }else{
    include_once("scripts/userClass.php");
    $usuario = SetUserFromToken();
    $usuario_nombreComp = $usuario->nombre . " " . $usuario->apellidoPat . " " . $usuario->apellidoMat;
    $imgPath = "profilePictures/ImagenesSubidasPorUsuarios/". $usuario->Imagen;
  }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Editar Perfil | Codebug </title>

    <link rel="icon" href="Recursos/Intellibug_placeholder.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link rel="stylesheet" href="CSS/edit_perfil.css">


</head>
<body>

    <nav class="navbar navbar-dark navbar-expand-md">
        <div class="container-fluid">

            <a class="navbar-brand link-light" href="inicio.html">Codebug</a>
            
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div id="navcol-1" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto" style="border-bottom-style: none;">
                    <li class="nav-item"><a class="nav-link link-light" href="chat.html">Mensajes</a></li>
                    <li class="nav-item"><a class="nav-link link-light" href="inicio.html">Mas Cursos</a></li>
                    <li class="nav-item"><a class="nav-link link-light" href="scripts/perfilRedir.php">Perfil</a></li>
                </ul>
            </div>

        </div>
    </nav>

    <?php if(isset($_GET['success'])): ?>
        <div class="container bg-opacity-100 bg-info rounded shadow mt-5 p-md-2">
            <div class="col-12 text-md-center my-2">
                <h4 class="fw-bold"><?php echo $_GET['success']; ?> </h4>
            </div>
        </div>
    <?php endif ?>

    <?php if(isset($_GET['error'])): ?>
        <div class="container bg-opacity-100 bg-danger rounded shadow mt-5 p-md-2">
            <div class="col-12 text-md-center my-2">
                <h4 class="fw-bold"><?php echo $_GET['error']; ?> </h4>
            </div>
        </div>
    <?php endif ?>

    <div class="container bg-white my-3 rounded shadow p-md-2">

        <div class="row">
            <div class="col-1">
                <!--<a href="perfil.html" class="link-dark pt-3">
                    <i class="fa fa-arrow-left "></i>
                    Regresar
                </a>-->
            </div>
            <div class="col-10 text-md-center my-4">
                <h2 class="fw-bold">Editar Perfil</h2>
            </div>
            <div class="col-1"></div>
        </div>
        
        <div class="row">
            <div class="col-md-6 px-5 py-3">
                <div class="row">
                    <img class="img-thumbnail h-25 rounded  " src="<?php echo $imgPath ?>" alt="">
                </div>

            
            </div>

                <div class="col-md-6 px-4">
                <form  method="post" id="form-editPerfil" enctype="multipart/form-data" action="editPerfilLogic.php">
                    <div class="row me-4">

                            <div class="col-6 mb-4">
                                <label for="nombre" class="from-label">Nombre(s) a cambiar:</label>
                                <input type="text" class="form-control" placeholder="<?php echo $usuario->nombre ?>" readonly >
                            </div>

                            <div class="col-6 mb-4">
                                <label for="nombre" class="from-label"> Nombre nuevo:  </label>
                                <input minlength="1" maxlength="30" id="NuevoNombre" type="text" class="form-control" name="NuevoNombre" placeholder="<?php echo $usuario->nombre ?>" required >
                            </div>
                            
                            <div class="col-6 mb-4">
                                <label for="ApellidoPat" class="from-label">Apellido Paterno</label>
                                <input  type="text" class="form-control" placeholder="<?php echo $usuario->apellidoPat ?>" readonly>
                            </div>
                            
                            <div class="col-6 mb-4">
                                <label for="nuevoApellidoPat" class="from-label"> Apellido Nuevo: </label>
                                <input minlength="3" maxlength="30" id="nuevoApellidoPat" type="text" class="form-control" name="nuevoApellidoPat" placeholder="<?php echo $usuario->apellidoPat ?>" required>
                            </div>

                            <div class="col-6 mb-4">
                                <label for="nuevoApellidoMat" class="from-label">Apellido Materno</label>
                                <input   type="text" class="form-control" placeholder="<?php echo $usuario->apellidoMat ?>" readonly>
                            </div> 
            
                            <div class="col-6 mb-4">
                                <label for="nuevoApellidoMat" class="from-label"> Apellido Nuevo </label>
                                <input minlength="3" maxlength="30" id="nuevoApellidoMat" type="text" class="form-control" name="nuevoApellidoMat" placeholder="<?php echo $usuario->apellidoMat ?>" required>
                            </div> 
                            
                            <div class="col-12 mb-4">
                                <label for="Imagen" class="form-label">Foto de perfil</label>
                                <input type="file" class="form-control" name="Imagen" id="Imagen" accept=".png, .jpg, .jpeg" required >
                            </div>

                            <div class="col-6 mb-4">
                                <label  for="password" class="form-label">Contraseña</label>
                                <input minlength="8" maxlength="20" id="password" type="password" class="form-control" name="password" placeholder="••••••••••" required>
                            </div>
            
                            <div class="col-6 mb-4">
                                <label  for="confirmPass" class="form-label">Confirmar Contraseña</label>
                                <input minlength="8" maxlength="20" id="confirmPass" type="password" class="form-control" name="confirmPass" placeholder="••••••••••" required>
                            </div>

                            <div class="d-grid py-2 px-5">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg mt-2 mb-4">Guardar</button>
                                <a href="scripts/perfilRedir.php" class="btn btn-outline-primary btn-lg ">Cancelar</a>
                            </div>
                        
                    </div>
                </form>
                
            </div>
        </div>
    </div>

    <footer id="Footer" class="footer text center">
        <div class="text-center p-3">
            <p class="lead link-light">© 2023 Copyright: Codebug.com</p> 
        </div>
        </footer>
    
</body>

<script src="scripts/editPerfil.js"></script>
</html>