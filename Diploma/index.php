<?php
$usuarioNombre = "Luis Alfonso Martinez";
$nombreCurso = "Base De Datos Multimedia";
$fechaCompletado = "2023/06/09";
$docenteNombre = "Alejandro Villareal";



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>

<body>
    <form action="ejemplo.php" method="POST">

        <input type="text" id="user" name="user" value="<?php echo $usuarioNombre?>">
        <input type="text" id="curso" name="curso" value="<?php echo $nombreCurso?>">
        <input type="text" id="fecha" name="fecha" value="<?php echo $fechaCompletado?>">
        <input type="text" id="docente" name="docente" value="<?php echo $docenteNombre?>">

        <button type="submit" class="btn btn-primary m-4"> Generar PDF </button>
    </form>
</body>

</html>