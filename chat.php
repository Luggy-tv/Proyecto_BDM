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
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Codebug | Mensajes</title>
  <link rel="icon" href="Recursos/Intellibug_placeholder.png">

  <link rel="stylesheet" href="CSS/chat.css?v=<?php echo time(); ?>">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

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

            <!-- <div class="dropdown"> 
                            <button class="dropbtn" onclick="myFunction()">Cursos por categoría
                              <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-content" id="myDropdown">
                              <a href="#">Back end</a>
                              <a href="#">Front end</a>
                              <a href="#">Diseño</a>
                            </div>
                        </div> -->

            <li class="nav-item"><a class="nav-link link-light" href="chat.php"
                style="border-left-style: none;">Mensajes</a></li>
            <li class="nav-item"><a class="nav-link link-light" href="scripts/perfilRedir.php"
                style="border-left-style: none;">Perfil</a></li>

          </ul>
        </div>

        <!-- <div class="cart nav-item">
          <a class="nav-link link-light" href="#">
            <span>Carrito de compras</span>
          </a>
          <ul class="product-list pt-3 px-5">
            <h3>Carrito de compras</h3>
            <li>Product A - 000.00</li>
            <li>Product B - $000.00</li>
            <li>Product C - $000.00</li>
            <li><a href="buy/checkout.php" class="checkout-button">Checkout</a></li>
          </ul>
        </div> -->

      </div>
    </nav>
  </section> <!--TERMINA NAVBAR-->

  <section>
    <div class="row d-flex mx-0 my-lg-0">
      <!-- Users box-->
      <div class="col-lg-4 py-0 px-0">
        <div class="bg-white">
          <div class="bg-gray px-4 py-2 bg-light">
            <p class="h5 mb-0 py-1">Mensajes para
              <?php echo $usuario->nombre ?>
            </p>
            <div class="my-2">
              <input name="searchBar" id="searchBar" class="h-25 w-100 form-control" type="text"
                placeholder="Escribe el nombre del usuario que buscas...">
            </div>

          </div>

          <div class="messages-box ">
            <div class="list-group" id="user-list">

            </div>
          </div>
        </div>
      </div>
      <!-- Chat Box-->
      <div class=" chatbox col-lg-8 px-0 h-100" id="chatlist">

      </div>
    </div>
  </section>
  <!-- <script src='scripts/chat-msg.js'></script> -->
  <script src="scripts/chat.js"></script>
</body>

</html>