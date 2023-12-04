<?php
//Check if Cookie is set and if is set then a bg info appears with a button if 

?>


<html>

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Inicia Sesion | Codebug</title>

  <link rel="icon" href="Recursos/Intellibug_placeholder.png">


  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="stylesheet" href="CSS/login.css">

</head>

<body>

  <?php if (isset($_GET['success'])): ?>
    <div class="container bg-opacity-100 bg-info rounded shadow mt-5 p-md-2">
      <div class="col-12 text-md-center my-2">
        <h4 class="fw-bold">
          <?php echo $_GET['success']; ?>
        </h4>
      </div>
    </div>
  <?php endif ?>

  <?php if (isset($_GET['error'])): ?>
    <div class="container bg-opacity-100 bg-danger rounded shadow mt-5 p-md-2">
      <div class="col-12 text-md-center my-2">
        <h4 class="fw-bold">
          <?php echo $_GET['error']; ?>
        </h4>
      </div>
    </div>
  <?php endif ?>

  <div class="container w-80 h-auto my-5 rounded shadow"> <!--Margin Top-->
    <div class="row align-items-stretch rounded">
      <div class="col bgImg rounded">
      </div>
      <div class="col opacity-100 bg-white rounded-end p-md-3 ">

        <!--Inicia columna con transparencia-->
        <div class="text-center mt-4">
          <a href="index.html">
            <img src="Recursos/Intellibug_placeholder.png" width="15%" alt="">
          </a>
        </div>

        <h2 class="fw-bold text-center py-4">Bienvenido a Codebug</h2>
        <!--LOGIN-->
        <form method="post" id="form-login" enctype="multipart/form-data" action="scripts/loginlogic.php">

          <div class="mb-4 mx-5"> <!--Margin Bottom-->
            <label for="email" class="from-label">Correo Electronico</label>
            <input type="email" id="email" class="form-control" name="email" placeholder="ejemplo@mail.com" required>
          </div>

          <div class="mb-4 mx-5">
            <label for="password" class="from-label">Contraseña</label>
            <input type="password" id="password" class="form-control" name="password" placeholder="••••••••••" required>
          </div>


          <div class="d-grid mx-5"> <!--Tipo de grid-->
            <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Iniciar Sesion</button>
          </div>

          <div class="my-3 mx-5 mb-4"> <!--Margin in Y-->
            <span>No tienes cuenta? <a href="signin.php">Registrate</a> </span>
          </div>

        </form>

        <!--Termina columna con transparencia-->

      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
  <script src="scripts/login.js"></script>

</html>