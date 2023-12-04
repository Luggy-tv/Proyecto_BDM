<?php

if (isset($_GET['idCur']) && isset($_GET['idMod'])) {

    $cursoID = $_GET['idCur'];
    $moduloID = $_GET['idMod'];
    include("scripts/cursoClass.php");
    $cursoYModulos = getCursoForCursoInfo($cursoID);
    // print_r($cursoYModulos);
    $modulo = getModuloDetail($moduloID);

    // print_r($modulo);

    addNivelToUsuarioEnCurso($cursoID);
    
    $videoPath = $modulo[0]['Video'];
    $videoPath = str_replace("..", "/RepositorioParaProyectoDeBDM/BDM", $videoPath);

    // print_r($videoPath);

} else {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error al conectar con el curso favor de regresar a la pantalla anterior.");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $cursoYModulos[0]["titulo"]; ?> |
        <?php echo $cursoYModulos[0]["nombreNivel"]; ?>
    </title>
    <link rel="icon" href="Recursos/Intellibug_placeholder.png">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/curso.css">

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
                    <a class="nav-link link-light" href="buy/checkout.php">
                        <span>Carrito de compras</span>
                    </a>

                    <ul class="product-list pt-3 px-5">
                        <h3>Carrito de compras</h3>
                        <div id="carritoContainer">

                        </div>
                        <li><a href="buy/checkout.php" class="checkout-button">Checkout</a></li>
                    </ul>
                </div>

            </div>
        </nav>
    </section> <!--TERMINA NAVBAR-->

    <!--  ................................................................................................................................-->

    <section class="vide">
        <main class="container" id="contVideo">
            <section class="main-video">
                <video  controls autoplay muted>
                    <source src="<?php echo $videoPath ?>" type="video/mp4">
                </video>
                <h3 class="title">
                    <?php echo $cursoYModulos[0]["nombreNivel"]; ?>
                </h3>
            </section>

            <section class="video-playlist">
                <h3 class="title">
                    <?php echo $modulo[0]["Descripcion"]; ?>
                </h3>
                <!-- <p>10 lessions &nbsp; . &nbsp; 50m 48s</p> -->
                <div class="videos">

                </div>
            </section>
        </main>
    </section>

    <!--  ................................................................................................................................-->


</body>

<script src="scripts/curso.js"></script>

<script>
    // JavaScript code for updating the cart count
    var cartCount = 3; // Replace with your actual cart count

    // Update the cart count display
    document.querySelector('.cart-count').textContent = cartCount;

</script>

</html>