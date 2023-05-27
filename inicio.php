<?php

if (!isset($_COOKIE['sessionToken']) || empty($_COOKIE['sessionToken'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");
} else {
    include_once("scripts/userClass.php");
    $usuario = SetUserFromToken();
    $usuario_nombreComp = $usuario->nombre . " " . $usuario->apellidoPat . " " . $usuario->apellidoMat;
    $imgPath = "profilePictures/ImagenesSubidasPorUsuarios/" . $usuario->Imagen;

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

    <link rel="preload" as="image" href="Recursos/tinypngs/html.jpg">
    <link rel="preload" as="image" href="Recursos/tinypngs/bootstrap.jpg">
    <link rel="preload" as="image" href="Recursos/tinypngs/database.jpg">
    <link rel="preload" as="image" href="Recursos/tinypngs/mysql.jpg">
    <link rel="preload" as="image" href="Recursos/tinypngs/mysql2.jpg">
    <link rel="preload" as="image" href="Recursos/tinypngs/programador1.jpg">



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

                <div class="cart nav-item">
                    <a class="nav-link link-light" href="#">
                        <span>Carrito de compras</span>
                    </a>
                    <ul class="product-list pt-3 px-5">
                        <h3>Carrito de compras</h3>
                        <li>Product A - 000.00</li>
                        <li>Product B - $000.00</li>
                        <li>Product C - $000.00</li>
                        <li><a href="buy/formulario.php" class="checkout-button">Checkout</a></li>
                    </ul>
                </div>

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
                                                <div class="col-sm-4">
                                                    <div class="thumb-wrapper">
                                                        <div class="img-box">
                                                            <img src="Recursos/tinypngs/html.jpg" class="img-fluid"
                                                                alt="">
                                                        </div>
                                                        <div class="thumb-content">
                                                            <h4>Curso 1</h4>
                                                            <p>En este curso de nivel básico aprenderás todo lo que
                                                                necesitas para
                                                                comenzar a diseñar páginas web usando HTML 5</p>
                                                            <a href="#" class="btn btn-primary">Ver más <i
                                                                    class="fa fa-angle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="thumb-wrapper">
                                                        <div class="img-box">
                                                            <img src="Recursos/tinypngs/bootstrap.jpg" class="img-fluid"
                                                                alt="">
                                                        </div>
                                                        <div class="thumb-content">
                                                            <h4>Curso 2</h4>
                                                            <p>Aprende a utilizar este framework front-end empleado para
                                                                desarrollar aplicaciones web y sitios mobile first</p>
                                                            <a href="#" class="btn btn-primary">Ver más <i
                                                                    class="fa fa-angle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="thumb-wrapper">
                                                        <div class="img-box">
                                                            <img src="Recursos/tinypngs/database.jpg" class="img-fluid"
                                                                alt="">
                                                        </div>
                                                        <div class="thumb-content">
                                                            <h4>Curso 3</h4>
                                                            <p>Con este curso desarrollarás conceptos fundamentales para
                                                                el uso eficaz y eficiente de distintos softwares de
                                                                gestión de datos</p>
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
                                                    <div class="thumb-wrapper">
                                                        <div class="img-box">
                                                            <img src="Recursos/tinypngs/mysql.jpg" class="img-fluid"
                                                                alt="">
                                                        </div>
                                                        <div class="thumb-content">
                                                            <h4>Cruso 4</h4>
                                                            <p>Aprende a usar una de las bases de datos de código
                                                                abierto más utilizadas en el mundo</p>
                                                            <a href="#" class="btn btn-primary">Ver más <i
                                                                    class="fa fa-angle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="thumb-wrapper">
                                                        <div class="img-box">
                                                            <img src="Recursos/tinypngs/mysql2.jpg" class="img-fluid"
                                                                alt="">
                                                        </div>
                                                        <div class="thumb-content">
                                                            <h4>Curso 5</h4>
                                                            <p>Comienza a usar MySQL de forma profesional con esta
                                                                continuación de nuestra serie de cursos de MySQL, ahora
                                                                con enfoque avanzado</p>
                                                            <a href="#" class="btn btn-primary">Ver más <i
                                                                    class="fa fa-angle-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="thumb-wrapper">
                                                        <div class="img-box">
                                                            <img src="Recursos/tinypngs/programador1.jpg"
                                                                class="img-fluid" alt="">
                                                        </div>
                                                        <div class="thumb-content">
                                                            <h4>Curso 6</h4>
                                                            <p>Empieza a crear tus propias páginas web desde cero con
                                                                este curso introductorio donde aprenderás todo lo
                                                                necesario para comenzar</p>
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