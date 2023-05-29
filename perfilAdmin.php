<?php
if (!isset($_COOKIE['sessionToken']) || empty($_COOKIE['sessionToken'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");
} else {
    
    include("scripts/userClass.php");
    $usuario = SetUserFromToken();
    $usuario_nombreComp = $usuario->nombre . " " . $usuario->apellidoPat . " " . $usuario->apellidoMat;

    include_once("scripts/categoriasClass.php");
    $listaCategorias = setCategoriasLista();

    $listaUsuarios = getUserList();

}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | Codebug </title>

    <link rel="icon" href="Recursos/Intellibug_placeholder.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/perfil.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Varela+Round">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>

</head>

<body>
    <!--NAV BAR-->
    <nav class="navbar navbar-dark navbar-expand-md">
        <div class="container-fluid">

            <a class="navbar-brand link-light" href="inicio.php">Codebug</a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navcol-1" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto" style="border-bottom-style: none;">
                    <li class="nav-item"><a class="nav-link link-light" href="chat.php">Mensajes</a></li>
                    <li class="nav-item"><a class="nav-link link-light" href="#">Mas Cursos</a></li>
                </ul>
            </div>

        </div>
    </nav>

    <!--Imagen y nombre de perfil-->
    <section>
        <div class="container-fluid bg-light py-5">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-2">
                    <img class="img-fluid img-thumbnail h-auto" src="scripts/loaduserimg.php">
                </div>
                <div class="col-8 mt-3 ">
                    <h1 id="nombreCompleto" class="fw-bold">
                        <?php echo $usuario_nombreComp ?>
                    </h1>
                    <p id="correo">
                        <?php echo $usuario->Email ?>
                    </p>
                    <a id="btn-editProfile" class="btn btn-primary px-2 py-1" href="editperfil.php">Editar perfil</a>
                </div>
            </div>
        </div>
    </section>

    <!--TUS CURSOS-->
    <section>
        <div id="cursos" class="row h-auto pb-4">
            <h2 class="my-2 text-center fw-bold">Tus cursos</h2>

            <div class="container-xl">
                <div class="row">
                    <div class="col-md-10 mx-auto bg-light rounded-1 my-auto">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">


                            <!-- Wrapper for carousel items -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="thumb-wrapper rounded-3">
                                                <div class="img-box">
                                                    <img src="" class="img-fluid rounded-3" alt="">
                                                </div>
                                                <div class="thumb-content">
                                                    <h4>Aprende HTML desde cero</h4>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                        Consectetur, dolor!</p>
                                                    <a href="#" class="btn btn-primary">Ver más <i
                                                            class="fa fa-angle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="thumb-wrapper rounded-3">
                                                <div class="img-box">
                                                    <img src="" class="img-fluid rounded-3" alt="">
                                                </div>
                                                <div class="thumb-content">
                                                    <h4>Bootstrap: Todo lo que debes saber</h4>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam,
                                                        provident.</p>
                                                    <a href="#" class="btn btn-primary">Ver más <i
                                                            class="fa fa-angle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="thumb-wrapper rounded-3">
                                                <div class="img-box">
                                                    <img src="" class="img-fluid rounded-3" alt="">
                                                </div>
                                                <div class="thumb-content">
                                                    <h4>Fundamentos de las bases de datos</h4>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error,
                                                        fugiat.</p>
                                                    <a href="#" class="btn btn-primary">Ver más <i
                                                            class="fa fa-angle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="thumb-wrapper rounded-3">
                                                <div class="img-box">
                                                    <img src="" class="img-fluid rounded-3" alt="">
                                                </div>
                                                <div class="thumb-content">
                                                    <h4>MySQL para principiantes</h4>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque,
                                                        dolorem!</p>
                                                    <a href="#" class="btn btn-primary">Ver más <i
                                                            class="fa fa-angle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="thumb-wrapper rounded-3">
                                                <div class="img-box">
                                                    <img src="" class="img-fluid rounded-3" alt="">
                                                </div>
                                                <div class="thumb-content">
                                                    <h4>MySQL nivel avanzado</h4>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem,
                                                        eveniet.</p>
                                                    <a href="#" class="btn btn-primary">Ver más <i
                                                            class="fa fa-angle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="thumb-wrapper rounded-3">
                                                <div class="img-box">
                                                    <img src="" class="img-fluid rounded-3" alt="">
                                                </div>
                                                <div class="thumb-content">
                                                    <h4>Introducción a la progrmación web</h4>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora,
                                                        impedit?</p>
                                                    <a href="#" class="btn btn-primary">Ver más <i
                                                            class="fa fa-angle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!-- Carousel controls -->
                            <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!--USUARIOS-->
    <section>
        <div id="kardex" class="row h-auto pb-4 px-5">
            <h2 class="my-2 text-center fw-bold">Usuarios</h2>
            <!-- tabla de usuarios -->
            <div class="container ">
                <div class="row">
                    <div class="col-1"></div>

                    <div class="col-10 bg-light rounded-3 p-0">
                        <table class="table table-striped bg-light rounded-3 p-3">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">ID</th>
                                    <th scope="col" class="text-center">Nombres</th>
                                    <th scope="col" class="text-center">Estado</th>
                                    <th scope="col" class="text-center">Intentos</th>
                                    <th scope="col" class="text-center">Rol</th>
                                    <th scope="col" class="text-center">Desbloquear</th>
                                    <th scope="col" class="text-center">Dar de baja</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($listaUsuarios as $usuario): ?>
                                    <tr>
                                        <td scope="row" id="fila-<?php echo $usuario['ID'] ?>"  class="text-center">
                                            <?php echo $usuario['ID'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $usuario['Nombre'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $usuario['Estado'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $usuario['Intentos'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $usuario['Rol'] ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn p-0" onclick="desbloquearUsuario( <?php echo $usuario['ID'] ?> )"> <i class="fa fa-unlock" aria-hidden="true"></i></button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn p-0" onclick="eliminarUsuario( <?php echo $usuario['ID'] ?> )"> <i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-1"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categorias -->
    <section id="Categorias">

        <div class="row h-auto pb-4">

            <div class="d-flex align-items-center  justify-content-center my-3">

                <h2 class="w-75 mx-2 my-2 fw-bold text-start ">Categorias</h2>
                <button type="button" class="flex-shrink-1 mx-4 w-auto btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Agregar Categorias
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Categoria</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <!-- categoriaAgregar -->
                            <form method="post" id="form-addcat" action="">
                                <div class="modal-body">
                                    <div id="error-msg">
                                    </div>
                                    <div class="mb-3">
                                        <label for="NomCategoria" class="form-label">Nombre De Categoria:</label>
                                        <input name="NomCategoria" id="NomCategoria" type="text" class="form-control"
                                            minlength="1" maxlength="30">
                                    </div>
                                    <div class="mb-3">
                                        <label for="DescCategoria" class="form-label">Descripcion de Categoria:</label>
                                        <textarea name="DescCategoria" id="DescCategoria" type="text"
                                            class="form-control" minlength="10" maxlength="140"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" name="submit" class="btn btn-primary">Agregar
                                        Categoria</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla De Categorias -->
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-10 text-center">
                        <?php if (!empty($listaCategorias)): ?>
                            <table class="table table-striped bg-light rounded-3 p-3" id="tabla-categorias">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Fecha creada</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                                <?php foreach ($listaCategorias as $categoria): ?>
                                    <tr>
                                        <td scope="row" id="fila-<?php echo $categoria['ID']; ?>">
                                            <?php echo $categoria["ID"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $categoria["Categoria"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $categoria["Descripcion"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $categoria["Creada"]; ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn p-0" onclick="eliminarFila(<?php echo $categoria['ID']; ?>)"> <i
                                                    class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php else: ?>
                            <p class="text-center mt-2">No se encontraron categorías.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!--Footer-->
    <footer id="Footer" class="footer text center">
        <div class="text-center p-3">
            <p class="lead link-light">© 2023 Copyright: Codebug.com</p>
        </div>
    </footer>



    <script src="scripts/perfilscript.js"></script>
</body>

</html>