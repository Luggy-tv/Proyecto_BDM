<?php



if (!isset($_COOKIE['sessionToken']) || empty($_COOKIE['sessionToken'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");
} else {
    include_once("scripts/userClass.php");
    $usuario = SetUserFromToken();
    $usuario_nombreComp = $usuario->nombre . " " . $usuario->apellidoPat . " " . $usuario->apellidoMat;
    //$userImg = imagecreatefromstring($usuario->Imagen);
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
                    <a class="nav-link link-light" href="buy/formulario.php">
                        <span>Carrito de compras</span>
                    </a>
                    <ul class="product-list pt-3 px-5">
                        <h3>Carrito de compras</h3>
                        <div id="carritoContainer">

                        </div>
                        <li><a href="buy/formulario.php" class="checkout-button">Haz click para ir al Checkout</a></li>
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

    <!--TUS CURSOS-->
    <section>
        <div id="cursos" class="row pb-4">
            <h2 class="my-3 text-center fw-bold">Tus cursos</h2>

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
                                                    <img src="Recursos/tinypngs/html.jpg" class="img-fluid rounded-3"
                                                        alt="">
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
                                                    <img src="Recursos/tinypngs/bootstrap.jpg"
                                                        class="img-fluid rounded-3" alt="">
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
                                                    <img src="Recursos/tinypngs/database.jpg"
                                                        class="img-fluid rounded-3" alt="">
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
                                                    <img src="Recursos/tinypngs/mysql.jpg" class="img-fluid rounded-3"
                                                        alt="">
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
                                                    <img src="Recursos/tinypngs/mysql2.jpg" class="img-fluid rounded-3"
                                                        alt="">
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
                                                    <img src="Recursos/tinypngs/programador1.jpg"
                                                        class="img-fluid rounded-3" alt="">
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

    <!--KARDEX-->
    <section>
        <div id="kardex" class="row pb-4 py-3">
            <h2 class="my-2 text-center fw-bold">Tu Kardex</h2>
            <div class="container-xl ">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10 bg-light rounded-3 p-0">
                        <table class="table table-striped bg-light rounded-3 p-3">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cursos</th>
                                    <th scope="col">Niveles</th>
                                    <th scope="col">Diploma</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Aprende HTML desde cero</td>
                                    <td>2/5</td>
                                    <td><button class="btn p-0"
                                            onclick="window.open('Recursos/tinypngs/CertificadoDeCurso.jpeg')" disabled>
                                            <i class="fa fa-download"></i> Descargar</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Bootstrap: Todo lo que debes saber</td>
                                    <td>1/8</td>
                                    <td><button class="btn p-0"
                                            onclick="window.open('Recursos/tinypngs/CertificadoDeCurso.jpeg')" disabled>
                                            <i class="fa fa-download"></i> Descargar</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Fundamentos de las bases de datos</td>
                                    <td>0/10</td>
                                    <td><button class="btn p-0"
                                            onclick="window.open('Recursos/tinypngs/CertificadoDeCurso.jpeg')" disabled>
                                            <i class="fa fa-download"></i> Descargar</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>MySQL para principiantes</td>
                                    <td>15/15</td>
                                    <td><button class="btn p-0"
                                            onclick="window.open('Recursos/tinypngs/CertificadoDeCurso.jpeg')"> <i
                                                class="fa fa-download"></i> Descargar</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>MySQL nivel avanzado</td>
                                    <td>5/20</td>
                                    <td><button class="btn p-0"
                                            onclick="window.open('Recursos/tinypngs/CertificadoDeCurso.jpeg')" disabled>
                                            <i class="fa fa-download"></i> Descargar</button></td>
                                </tr>

                                <tr>
                                    <th scope="row">6</th>
                                    <td>Introducción a la progrmación web</td>
                                    <td>10/10</td>
                                    <td><button class="btn p-0"
                                            onclick="window.open('Recursos/tinypngs/CertificadoDeCurso.jpeg')"> <i
                                                class="fa fa-download"></i> Descargar</button></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
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