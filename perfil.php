<?php



if (!isset($_COOKIE['sessionToken']) || empty($_COOKIE['sessionToken'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");
} else {
    include_once("scripts/userClass.php");
    $usuario = SetUserFromToken();
    $usuario_nombreComp = $usuario->nombre . " " . $usuario->apellidoPat . " " . $usuario->apellidoMat;
    //$userImg = imagecreatefromstring($usuario->Imagen);
    include("scripts/cursoClass.php");

    include_once("scripts/categoriasClass.php");
    $listaCategorias = setCategoriasLista();

    $listaMasVendidos = checkUserCursosForKardex();

    // print_r($listaMasVendidos);
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

    <link rel="stylesheet" href="CSS/perfil.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Varela+Round">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>

<body>
    <section> <!--NAVBAR-->
        <nav class="navbar navbar-dark navbar-expand-md">
            <div class="container-fluid"><a class="navbar-brand link-light" href="inicio.php">Codebug</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
                    <span class="visually-hidden">Toggle navigation</span>
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div id="navcol-1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto" style="border-bottom-style: none;">

                        <div class="dropdown"> <!---->
                            <button class="dropbtn" onclick="myFunction()">Cursos por categoría
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-content" id="myDropdown">
                                <a href="#">Back end</a>
                                <a href="#">Front end</a>
                                <a href="#">Diseño</a>
                            </div>
                        </div>

                        <li class="nav-item"><a class="nav-link link-light" href="chat.php"
                                style="border-left-style: none;">Mensajes</a></li>
                        <li class="nav-item"><a class="nav-link link-light" href="scripts/perfilRedir.php"
                                style="border-left-style: none;">Perfil</a></li>

                    </ul>
                </div>

                <div class="cart nav-item">
                    <a class="nav-link link-light" href="buy/checkout.php">
                        <span>Carrito de compras</span>
                    </a>
                    <ul class="product-list pt-3 px-5">
                        <h3>Carrito de compras</h3>
                        <div id="carritoContainer">

                        </div>
                        <li><a href="buy/checkout.php" class="checkout-button">Haz click para ir al Checkout</a></li>
                    </ul>
                </div>

            </div>
        </nav>
    </section> <!--TERMINA NAVBAR-->

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


    <!--KARDEX-->
    <section>
        <div id="kardex" class="row pb-4 py-3">
            <h2 class="my-2 text-center fw-bold">Tu Kardex</h2>
            <div class="container-xl ">

                <div class="row">
                    <div class="col-1"></div>
                    <?php if (!empty($listaMasVendidos)): ?>
                        <div class="col-10 mb-3">

                            <div class="accordion" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseOne" aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            Filtros
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="fecha" class="form-label">Fecha de inscripcion</label>
                                                    <input id="fecha" type="date" class="form-control" name="fecha">
                                                    <button type="submit" id="fecha-btn"
                                                        class="btn btn-primary w-100 mt-2 mb-1 ">Filtrar por fecha</button>
                                                </div>
                                                <div class="col-4">
                                                    <label for="" class="form-label">Categoria</label>
                                                    <select name="categoria" id="categoria" class="form-control">
                                                        <?php foreach ($listaCategorias as $categoria): ?>
                                                            <?php echo "<option value='" . $categoria['ID'] . "'> " . $categoria['Categoria'] . "</option>"; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit" id="categoria-btn"
                                                        class="btn btn-primary w-100 mt-2 mb-1 ">Filtrar por
                                                        categoria</button>
                                                </div>

                                                <div class="col-4">
                                                    <label for="" class="form-label">Estatus</label>
                                                    <select name="estatus" id="estatus" class="form-control">
                                                        <option value="1">Terminado</option>
                                                        <option value="0">En Curso</option>
                                                    </select>
                                                    <button type="submit" id="estatus-btn"
                                                        class="btn btn-primary w-100 mt-2 mb-1">Filtrar por estatus
                                                    </button>
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" id="all-btn"
                                                        class="btn btn-info w-100 mt-2 mb-1">Usar todos los filtros
                                                    </button>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-1"></div>
                        <div class="col-1"></div>


                        <div class="col-10 bg-light rounded-3 p-0">
                            <table class="table table-striped bg-light rounded-3 p-3">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Cursos</th>
                                        <th scope="col">Fecha de Inscripcion</th>
                                        <th scope="col">Nivel Actual</th>
                                        <th scope="col">Ultimo Avance</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Fecha de Finalizacion</th>

                                    </tr>
                                </thead>
                                <tbody id="tablaDeDatos">

                                    <?php foreach ($listaMasVendidos as $curso): ?>
                                        <tr>
                                            <th scope="row">

                                                <?php echo $curso['ID_Curso'] ?>
                                            </th>
                                            <td>
                                                <a class="link-primary"
                                                    href="scripts/cursoRedir.php?id=<?php echo $curso['ID_Curso'] ?>">
                                                    <?php echo $curso['Titulo_Curso'] ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo $curso['FechaInscripcion'] ?>
                                            </td>
                                            <td>
                                                <?php echo $curso['Nivel'] ?>
                                            </td>
                                            <td>
                                                <?php echo $curso['FechaDeUltimoAvance'] ?>
                                            </td>
                                            <td>
                                                <?php echo $curso['NombreDeCategoria'] ?>
                                            </td>
                                            <td>
                                                <?php echo $curso['FechaFinalizacion'] ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>

                                </tbody>
                            </table>

                        </div>
                    <?php else: ?>
                        <h3 class="text-center mt-2">No te has inscrito a ningun curso!</h3>
                    <?php endif; ?>
                    <div class="col-1"></div>
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

    <script src="scripts/perfil.js"></script>

</body>

</html>