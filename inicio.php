<?php

if (!isset($_COOKIE['sessionToken']) || empty($_COOKIE['sessionToken'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");
} else {
    include_once("scripts/userClass.php");
    $usuario = SetUserFromToken();
    $usuario_nombreComp = $usuario->nombre . " " . $usuario->apellidoPat . " " . $usuario->apellidoMat;
    $imgPath = "profilePictures/ImagenesSubidasPorUsuarios/" . $usuario->Imagen;

    // print_r($usuario);

    include("scripts/cursoClass.php");

    $listaMasVendidos = getMasVendidos();
    $listaMejorCalificados = getMejorCalificados();
    $listaMasRecientes = getMasRecientes();

}

?>

<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Codebug | Inicio</title>
    <link rel="icon" href="Recursos/Intellibug_placeholder.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/inicio.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Varela+Round">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


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

                        <div class="dropdown">
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

                <?php if (!$usuario->isMaestro && !$usuario->isAdmin): ?>

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

                <?php endif ?>

            </div>
        </nav>
    </section> <!--TERMINA NAVBAR-->
    <!-- Bienvenido -->
    <section>
        <div class="container">
            <div class="row my-5 text-align">
                <h1>¡Bienvenido a Codebug
                    <?php echo $usuario->nombre; ?>!
                </h1>
            </div>

        </div>
        <!-- Cursos Mas vendidos-->
        <div class="container bg-light my-5">
            <div class="row mx-5">
                <div class="col-lg-12 mt-5">
                    <h2>Cursos más vendidos</h2>
                    <hr id="hr">
                </div>
            </div>

            <section>
                <div id="cursos" class="row text-center ">

                    <div class="container-xl">
                        <div class="row">
                            <div class="col-md-10 mx-auto">
                                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">

                                    <!-- Wrapper for carousel items -->
                                    <div class="carousel-inner ">
                                        <div class="carousel-item active">
                                            <div class="row">

                                                <?php if (!empty($listaMejorCalificados)): ?>

                                                    <?php foreach ($listaMejorCalificados as $curso):
                                                        $imagen_base64 = base64_encode($curso->imagen);
                                                        ?>

                                                        <div class="col-sm-4">
                                                            <div class="thumb-wrapper">
                                                                <div class="img-box">
                                                                    <img src="data:image/<?php echo $curso->imagenEx ?>;base64,<?php echo $imagen_base64 ?>"
                                                                        class="img-fluid">
                                                                </div>
                                                                <div class="thumb-content">
                                                                    <h4>
                                                                        <?php echo $curso->titulo ?>
                                                                    </h4>
                                                                    <p>
                                                                        <?php echo $curso->descripcion ?>
                                                                    </p>
                                                                    <a href="scripts/cursoRedir.php?id=<?php echo $curso->ID_Curso ?>"
                                                                        class="btn btn-primary">Ver más <i
                                                                            class="fa fa-angle-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php endforeach; ?>

                                                <?php else: ?>
                                                    <p class="text-center mt-2">No se encontraron cursos.</p>
                                                <?php endif ?>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </section>

    <!-- Mejor Calificados -->
    <section>
        <div class="container">
            <h2 id="second" class="mx-5">Cursos mejor calificados</h2>
            <section>
                <div id="cursos" class="row">
                    <div class="container-xl">
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">


                                    <!-- Wrapper for carousel items -->
                                    <div class="carousel-inner ">
                                        <div class="carousel-item active">
                                            <div class="row">

                                                <?php if (!empty($listaMejorCalificados)): ?>

                                                    <?php foreach ($listaMejorCalificados as $curso):
                                                        $imagen_base64 = base64_encode($curso->imagen);
                                                        ?>

                                                        <div class="col-sm-4">
                                                            <div class="thumb-wrapper">
                                                                <div class="img-box">
                                                                    <img src="data:image/<?php echo $curso->imagenEx ?>;base64,<?php echo $imagen_base64 ?>"
                                                                        class="img-fluid">
                                                                </div>
                                                                <div class="thumb-content">
                                                                    <h4>
                                                                        <?php echo $curso->titulo ?>
                                                                    </h4>
                                                                    <p>
                                                                        <?php echo $curso->descripcion ?>
                                                                    </p>
                                                                    <a href="scripts/cursoRedir.php?id=<?php echo $curso->ID_Curso ?>"
                                                                        class="btn btn-primary">Ver más <i
                                                                            class="fa fa-angle-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php endforeach; ?>

                                                <?php else: ?>
                                                    <p class="text-center mt-2">No se encontraron cursos.</p>
                                                <?php endif ?>

                                            </div>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

        </div>
    </section>

    <!-- Mas recientes -->
    <section class="recientes bg-light">
        <div class="container py-3">
            <h2 class="pt-5 mx-5">Cursos más recientes</h2>
            <!-- Nuestros cursos-->
            <section class="my-3">
                <div id="cursos" class="row">

                    <div class="container-xl">
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">


                                    <!-- Wrapper for carousel items -->
                                    <div class="carousel-inner ">
                                        <div class="carousel-item active">
                                            <div class="row">

                                                <?php if (!empty($listaMejorCalificados)): ?>
                                                    <?php foreach ($listaMasRecientes as $curso):
                                                        $imagen_base64 = base64_encode($curso->imagen);
                                                        ?>

                                                        <div class="col-sm-4">
                                                            <div class="thumb-wrapper">
                                                                <div class="img-box">
                                                                    <img src="data:image/<?php echo $curso->imagenEx ?>;base64,<?php echo $imagen_base64 ?> "
                                                                        class="img-fluid">
                                                                </div>
                                                                <div class="thumb-content">
                                                                    <h4>
                                                                        <?php echo $curso->titulo ?>
                                                                    </h4>
                                                                    <p>
                                                                        <?php echo $curso->descripcion ?>
                                                                    </p>
                                                                    <a href="scripts/cursoRedir.php?id=<?php echo $curso->ID_Curso ?>"
                                                                        class="btn btn-primary">Ver más <i
                                                                            class="fa fa-angle-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <p class="text-center mt-2">No se encontraron cursos.</p>
                                                <?php endif ?>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

        </div>
    </section>

    <!--Busqueda-->
    <section id="busqueda">
        <div class="container py-5 px-3">
            <h3 class="mx-4">Búsqueda de cursos</h3>
            <hr>
            <div class="search">
                <input type="text" placeholder="Buscar curso" name="searchBar" id="searchBar">
            </div>
            <div id="cuadroBusqueda" class="container my-3 mx-3 px-5 py-3" style="display:none;">


            </div>
        </div>
    </section>

    <!--Footer-->
    <footer id="Footer" class="footer text center">
        <div class="text-center p-3">
            <p class="lead link-light">© 2023 Copyright: Codebug.com</p>
        </div>
    </footer>
    <script src="scripts/inicio.js"></script>
</body>

</html>

