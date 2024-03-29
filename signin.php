<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrate | Codebug</title>
    <link rel="icon" href="Recursos/Intellibug_placeholder.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="CSS/login.css">

</head>

<body>

    <?php if (isset($_GET['error'])): ?>
        <div class="container bg-opacity-100 bg-danger rounded shadow mt-5 p-md-2">
            <div class="col-12 text-md-center my-2">
                <h4 class="fw-bold">
                    <?php echo $_GET['error']; ?>
                </h4>
            </div>
        </div>
    <?php endif ?>

    <div class="container bg-opacity-100 bg-white my-5 rounded shadow p-md-2">
        <div class="row">

            <div class="col-12 text-md-center my-4">
                <h2 class="fw-bold">Registrate</h2>
            </div>

        </div>

        <form method="post" id="form-signin" enctype="multipart/form-data" action="upload.php">
            <div class="row gx-3 mx-5">

                <div class="col-6 mb-4">
                    <label for="email" class="from-label">Correo Electronico</label>
                    <input minlength="5" maxlength="50" id="email" type="email" class="form-control" name="email"
                        placeholder="ejemplo@mail.com" required>
                </div>

                <div class="col-3 mb-4">
                    <label for="Genero" class="form-label">Genero</label>
                    <br>
                    <input type="radio" class="form-check-input" name="Genero" id="generoMasculino" value="M">
                    <label for="Masculino" class="form-check-label px-2">Masculino</label>
                    <input type="radio" class="form-check-input" name="Genero" id="generoFemenino" value="F">
                    <label for="Femenino" class="form-check-label px-2">Femenino</label>
                </div>

                <div class="col-3 mb-4">
                    <label for="esMaestro" class="form-label"> Eres maestro?</label>
                    <br>
                    <input id="esMaestro" type="checkbox" class="form-check-input" name="esMaestro">
                    <label for="esMaestro" class="form-check-label px-2">Si</label>
                </div>

                <div class="col-4 mb-4">
                    <label for="nombre" class="from-label">Nombre(s)</label>
                    <input minlength="1" maxlength="30" id="nombre" type="text" class="form-control" name="nombre"
                        placeholder="Juan Armando" required>
                </div>

                <div class="col-4 mb-4">
                    <label for="ApellidoPat" class="from-label">Apellido Paterno</label>
                    <input minlength="3" maxlength="30" id="apellidoPat" type="text" class="form-control"
                        name="ApellidoPat" placeholder="Martinez" required>
                </div>

                <div class="col-4 mb-4">
                    <label for="ApellidoMat" class="from-label">Apellido Materno</label>
                    <input minlength="3" maxlength="30" id="apellidoMat" type="text" class="form-control"
                        name="ApellidoMat" placeholder="Perez" required>
                </div>

                <div class="col-7 mb-4">
                    <label for="FechaDeNacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input id="fechaDeNac" type="date" class="form-control" autocomplete="off" name="FechaDeNacimiento"
                        required>
                </div>

                <div class="col-5 mb-4 ">
                    <label for="imagen" class="form-label">Foto de perfil</label>
                    <input type="file" class="form-control" name="imagen" id="ImagenDePerfil"
                        accept=".png, .jpg, .jpeg">
                </div>

                <div class="col-6 mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input minlength="8" maxlength="16" id="password" type="password" class="form-control"
                        name="password" placeholder="••••••••••" required>
                </div>

                <div class="col-6 mb-4">
                    <label for="confirmPass" class="form-label">Confirmar Contraseña</label>
                    <input minlength="8" maxlength="16" id="confirmPass" type="password" class="form-control"
                        name="confirmPass" placeholder="••••••••••" required>
                </div>

            </div>

            <div class="d-grid py-2 px-5">
                <button type="submit" name="submit" class="btn btn-primary btn-lg ">Crear cuenta</button>
            </div>

            <div class="row">
                <div class="col-12 pt-2 py-2 text-center">
                    <span> Ya tienes cuenta?
                        <a href="login.php">
                            Inicia Sesion
                        </a>
                    </span>

                </div>



            </div>
        </form>
    </div>
</body>
<script src="scripts/signin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>

</html>