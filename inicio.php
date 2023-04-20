<?php


if (!isset($_COOKIE['mi_cookie']) || empty($_COOKIE['mi_cookie'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");
  }else{
    include_once("scripts/userClass.php");
    $usuario = SetUserFromToken();
    $usuario_nombreComp = $usuario->nombre . " " . $usuario->apellidoPat . " " . $usuario->apellidoMat;
    $imgPath = "profilePictures/ImagenesSubidasPorUsuarios/" . $usuario->Imagen;
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
    <link rel="stylesheet" href="CSS/inicio.css">

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
    <nav class="navbar navbar-dark navbar-expand-md">
        <div class="container-fluid"><a class="navbar-brand link-light" href="inicio.html">Codebug</a>
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

                    <li class="nav-item"><a class="nav-link link-light" href="#">Carrito</a></li>
                    <li class="nav-item"><a class="nav-link link-light" href="chat.html"
                            style="border-left-style: none;">Mensajes</a></li>
                    <li class="nav-item"><a class="nav-link link-light" href="scripts/perfilRedir.php"
                            style="border-left-style: none;">Perfil</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <section>
        <div class="container">
            <div class="row my-5 text-align">
                <h1>¡Bienvenido a Codebug
                    <?php echo $usuario->nombre; ?>!
                </h1>
            </div>

        </div>

        <div class="container bg-light my-5">
            <div class="row mx-5">
                <div class="col-lg-12 mt-5">
                    <h2>Mis cursos</h2>
                    <hr id="hr">
                </div>
            </div>


            <!-- Nuestros cursos-->
            <section>
                <div id="cursos" class="row h-100 text-center ">

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
                                                            <h4>Aprende HTML desde cero</h4>
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
                                                            <h4>Bootstrap: Todo lo que debes saber</h4>
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
                                                            <h4>Fundamentos de las bases de datos</h4>
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
                                                            <h4>MySQL para principiantes</h4>
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
                                                            <h4>MySQL nivel avanzado</h4>
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
                                                            <h4>Introducción a la progrmación web</h4>
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

    <section>
        <div class="container">
            <h2 id="second">Cursos mejor calificados</h2>

            <!-- Nuestros cursos-->
            <section>
                <div id="cursos" class="row h-100">

                    <div class="container-xl">
                        <div class="row">
                            <div class="col-md-12 mx-auto">
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
                                                            <h4>Aprende HTML desde cero</h4>
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
                                                            <img src="Recursos/tinypngs/mysql.jpg" class="img-fluid"
                                                                alt="">
                                                        </div>
                                                        <div class="thumb-content">
                                                            <h4>MySQL para principiantes</h4>
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
                                                            <img src="Recursos/tinypngs/programador1.jpg"
                                                                class="img-fluid" alt="">
                                                        </div>
                                                        <div class="thumb-content">
                                                            <h4>Introducción a la progrmación web</h4>
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

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>


        </div>
    </section>

    <!--Footer-->
    <footer id="Footer" class="footer text center">
        <div class="text-center p-3">
            <p class="lead link-light">© 2023 Copyright: Codebug.com</p>
        </div>
    </footer>



</body>

</html>