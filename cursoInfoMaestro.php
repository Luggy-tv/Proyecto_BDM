<?php
if (isset($_GET['id'])) {

    $cursoID = $_GET['id'];
    // print_r($_GET['id']);

    include("scripts/cursoClass.php");
    $cursoYModulos = getCursoForCursoInfo($cursoID);

    include("scripts/userClass.php");
    $ID_Usuario = getIDFromToken();

    // print_r($cursoYModulos);
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

    <title>Información del curso</title>
    <link rel="icon" href="Recursos/Intellibug_placeholder.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="CSS/cursoInfo.css">

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
        </div>
    </nav>

    <section>
        <div class="container">
            <div class="row mt-5 mb-3 text-align">
                <h4>Información del curso</h4>
                <h1>
                    <?php echo $cursoYModulos[0]['titulo'] ?>
                </h1>
                <hr style="height: 2px;">

            </div>
        </div>
    </section>



    <section> <!-- DESCRIPCIÓN DEL CURSO E IMAGEN -->
        <div class="container">
            <div class="row">
                <div class="col-7 my-2 pe-5">
                    <p>
                        <?php echo $cursoYModulos[0]['Curso_Descripcion'] ?>
                    </p>
                    <p id="Info">Categoría:
                        <?php echo $cursoYModulos[0]['nombre_categoria'] ?>
                    </p>
                    <p id="Info">Puntuación por ususarios: x/5</p>
                    <p id="Info">Impartido por:
                        <?php echo $cursoYModulos[0]['Nombre_Completo'] ?>
                    </p>
                </div>

                <div class="comprar col-5">
                    <div class="my-3 py-3 mx-3 px-3">
                        <h5>Adquiere este curso por</h5>
                        <h1>
                            <?php echo $cursoYModulos[0]['precio_Curso'] ?>
                        </h1>

                        <a id="btn-comprarCurso" href="" class="btn mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <span>
                                <img class="addIcon" src="Recursos/icons8-add-shopping-cart-96.png"></img>
                            </span>
                            Agregar al carrito
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>



    <section class=" bg-light"> <!-- MODULOS E INFORMACIÓN DE COMPRA -->
        <div class="container bg-light pb-3">

            <div class="row mt-5 mx-3"> <!--Titulo de la sección-->
                <div class="mt-5">
                    <h3>Modulos del curso</h3>
                    <br>
                </div>
            </div>

            <?php foreach ($cursoYModulos as $curso): ?>

                <div class="row mx-3"> <!-- UNO -->
                    <div class="col-7 my-3">
                        <h4>
                            <?php echo $curso['nombreNivel'] ?>
                        </h4>
                        <h5>
                            <?php echo $curso['Nivel_Descripcion'] ?>
                        </h5>
                    </div>

                    <div class="col-5 my-3">
                        <!-- <a id="btn-comprarModulo" href="" class="btn mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal" >
                            Agregar este modulo al carrito
                        </a> -->
                    </div>
                </div>

            <?php endforeach ?>

        </div>
    </section>

    <section>
        <div class="container my-5">
            <h3 class="my-3">Opiniones de otros usuarios</h3>

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

    <section>
        <!-- <?php if ($cursoYModulos[0]['id_Docente'] === $ID_Usuario): ?> -->
            <div class="container my-5">
                <h3>Funciones como maestro</h3>
                <hr style="height: 2px;">
                <a id="btn-editarCurso" href="editarCurso.php?id=<?php echo $cursoID ?>" class="btn mx-2" >
                    Editar curso
                </a>

            </div>
        <?php endif ?>
    </section>


    <section>
        <footer id="Footer" class="footer text center">
            <div class="text-center p-3">
                <p class="lead link-light">© 2023 Copyright: Codebug.com</p>
            </div>
        </footer>
</body>
</section>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">¡Atencion!</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Lo siento pero como eres maestro no puedes comprar cursos
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

</body>

</html>