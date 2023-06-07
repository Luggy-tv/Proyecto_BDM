<?php

$baseUrl = 'http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/buy/';

if (!isset($_COOKIE['sessionToken']) || empty($_COOKIE['sessionToken'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");

} else {
    include_once("../scripts/userClass.php");
    include("paypalconfig.php");
    $usuario = SetUserFromToken();
    $usuario_nombreComp = $usuario->nombre . " " . $usuario->apellidoPat . " " . $usuario->apellidoMat;
    $carritoHasItems = false;
    
    if (isset($_COOKIE['carrito'])) {
        $cookieData = $_COOKIE['carrito'];
        $dataArray = json_decode($cookieData, true);
        $carritoHasItems = true;
    }


    // print_r($dataArray);

}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codebug | Checkout</title>
    <link rel="icon" href="../Recursos/Intellibug_placeholder.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/inicio.css?v=<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body>
    <section> <!--NAVBAR-->
        <nav class="navbar navbar-dark navbar-expand-md">
            <div class="container-fluid"><a class="navbar-brand link-light" href="../inicio.php">Codebug</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
                    <span class="visually-hidden">Toggle navigation</span>
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div id="navcol-1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto" style="border-bottom-style: none;">

                        <li class="nav-item"><a class="nav-link link-light" href="../chat.php"
                                style="border-left-style: none;">Mensajes</a></li>
                        <li class="nav-item"><a class="nav-link link-light" href="../scripts/perfilRedir.php"
                                style="border-left-style: none;">Perfil</a></li>

                    </ul>
                </div>

            </div>
        </nav>
    </section> <!--TERMINA NAVBAR-->


    <section>
        <div class="container">
            <div class="row mt-5 mb-3 text-align">
                <h1>Este es tu carrito de compra </h1>
            </div>

        </div>

        <!-- Tabla de Orden -->
        <div class="container bg-light mt-2 mb-5 px-3 py-4">

            <?php if ($carritoHasItems) { ?>

                <div class="row mx-5 justify-content-center">
                    <table class="table bg-light rounded-3 mx-5">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Titulo Curso</th>
                            <th scope="col" class="text-center">Precio</th>
                            <th scope="col" class="text-center">Eliminar</th>
                        </tr>
                        <?php
                        $totalPrecio = 0;
                        foreach ($dataArray as $curso):
                            $id =$curso['identificador'];
                            $totalPrecio += $curso['precio']; ?>
                            <tr>
                                <td scope="row" class="text-center">
                                    <?php echo $curso['identificador']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $curso['nombre']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $curso['precio']; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary" onclick="eliminarDecarrito(<?php echo $id ?>)"> Quitar de Carrito</button>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td scope="row" class="table-active"></td>
                            <td class="text-end table-active">Total:</td>
                            <td class="text-center table-active">$
                                <?php echo $totalPrecio; ?>
                            </td>
                            <td scope="row" class="table-active"></td>
                        </tr>
                    </table>
                </div>

                <div class="row mx-5">
                    <div class="col-lg-12 ">
                        <hr id="hr">
                    </div>
                </div>
                <div class="row my-2 mx-auto">
                    <div class="col-12">
                        <?php include('paypalcheckout.php'); ?>
                    </div>
                </div>
            <?php } else { ?>
                <h1 class="text-center">Tu carrito esta vacio! </h1>
            <?php } ?>


        </div>

    </section>



    <!--Footer-->
    <footer id="Footer" class="footer text center">
        <div class="text-center p-3">
            <p class="lead link-light">© 2023 Copyright: Codebug.com</p>
        </div>
    </footer>

    <script src="../scripts/checkout.js" ></script>
</body>

</html>