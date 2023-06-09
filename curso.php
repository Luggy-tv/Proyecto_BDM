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

    <section> <!--COMENTARIOS-->
        <div class="container my-5">
            <h1 class="my-3">Comentarios</h1>
            <hr style="height: 2px;">

            <div id="comments">
                <!-- Comentarios existentes -->
                <div class="comment">
                    <img class="profile-pic" src="Recursos/Open Peeps - Avatar (1).png" alt="John's Profile Picture">
                    <h4 id="user">John Doe</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>

                <div class="comment">
                    <img class="profile-pic" src="Recursos/Open Peeps - Bust.png" alt="Jane's Profile Picture">
                    <h4 id="user">Jane Smith</h4>
                    <p>Nulla facilisi. Sed vitae dolor gravida, pulvinar leo id, molestie mauris.</p>
                </div>
            </div>

            <br>
            <h3>Agrega un comentario:</h3>

            <form id="comment-form">
                <!--Aqui tiene que tomar el nombre del usuario y su foto de perfil para publicar junto con el comentario-->

                <textarea id="comment" name="comment" required></textarea><br><br>
                <input class="btn" type="submit" value="Publicar comentario">
            </form>


            <script>
                // JavaScript code for submitting the comment form
                document.getElementById('comment-form').addEventListener('submit', function (event) {
                    event.preventDefault(); // Prevent form submission

                    // Get the values from the form inputs
                    var name = document.getElementById('name').value;
                    var comment = document.getElementById('comment').value;

                    // Create a new comment element
                    var newComment = document.createElement('div');
                    newComment.className = 'comment';
                    newComment.innerHTML = '<img class="profile-pic" src="default_profile.jpg" alt="Profile Picture"><h3>' + name + '</h3><p>' + comment + '</p>';

                    // Append the new comment to the comment section
                    document.getElementById('comments').appendChild(newComment);

                    // Clear the form inputs
                    document.getElementById('name').value = '';
                    document.getElementById('comment').value = '';
                });
            </script>

        </div>
    </section>


</body>

<script src="scripts/curso.js"></script>

<script>
    // JavaScript code for updating the cart count
    var cartCount = 3; // Replace with your actual cart count

    // Update the cart count display
    document.querySelector('.cart-count').textContent = cartCount;

</script>

</html>