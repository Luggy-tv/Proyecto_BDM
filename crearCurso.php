<?php
if (!isset($_COOKIE['sessionToken']) || empty($_COOKIE['sessionToken'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");
} else {
    include_once("scripts/categoriasClass.php");
    $listaCategorias = setCategoriasLista();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codebug | Crear curso</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="icon" href="Recursos/Intellibug_placeholder.png">
    <link rel="stylesheet" href="CSS/crearCurso.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Varela+Round">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

    <div id="error">
        <!-- <div class="container bg-opacity-100 bg-danger rounded shadow mt-5 p-md-2">
            <div class="col-12 text-md-center my-2">
                <h4 class="fw-bold" id="error-msg">error</h4>
            </div>
        </div> -->
    </div>

    <div id="success">
        <!-- <div class="container bg-opacity-100 bg-info rounded shadow mt-5 p-md-2">
            <div class="col-12 text-md-center my-2">
                <h4 class="fw-bold" id="success-msg">success</h4>
            </div>
        </div> -->
    </div>

    <div class="container bg-opacity-100 bg-white my-5 rounded shadow p-md-2">
        <div class="row">

            <div class="col-12 text-md-center my-4">
                <h1>Crear curso</h1>
            </div>

        </div>
        <div class="infoCurso">
            <form id="form-cursoinfo" action="" method="post" enctype="multipart/form-data">
                <div class="row gx-3 mx-5">

                    <!-- Nombre Curso -->
                    <div class="col-7 mb-4">
                        <label for="nombreCurso" class="from-label">Nombre del curso</label>
                        <input minlength="1" maxlength="50" id="nombreCurso" type="text" class="form-control"
                            name="nombreCurso" placeholder="Curso" required>
                    </div>

                    <!-- Nombre Categoria  -->
                    <div class="col-5 form-group">
                        <label for="categoria" class="from-label ">Categoría</label>
                        <select name="categoria" id="categoria" class="form-control">
                            <?php foreach ($listaCategorias as $categoria): ?>
                                <?php echo "<option value='" . $categoria['ID'] . "'> " . $categoria['Categoria'] . "</option>"; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Descripcionde curso -->
                    <div class="col-12 mb-4 ">
                        <label for="descCurso" class="form-label">Descripcion de Curso</label>
                        <textarea name="descCurso" id="descCurso" type="text" class="form-control" minlength="10"
                            maxlength="200" required></textarea>

                    </div>

                    <!-- Precio de curso  -->
                    <div class="col-4 mb-4 ">
                        <label for="precioCurso" class="form-label">Precio de Curso</label>
                        <input id="precioCurso" name="precioCurso" type="text" class="form-control"
                            placeholder="$$$.$$$" required>
                    </div>

                    <!-- Cantidad de Modulos  -->
                    <div class="col-4 mb-4 ">
                        <label for="numModulos" class="form-label">Cantidad de Modulos</label>
                        <input id="numModulos" name="numModulos" type="number" class="form-control" placeholder="5"
                            required>
                    </div>

                    <!-- Imagen de Curso  -->
                    <div class="col-4 mb-4 ">
                        <label for="imagenDeCurso" class="form-label">Imagen del curso</label>
                        <input type="file" class="form-control" name="imagenDeCurso" id="imagenDeCurso"
                            accept=".png, .jpg, .jpeg" required>
                    </div>

                    <div class="col-12 py-2">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">Generar curso</button>
                    </div>

                </div>
            </form>
        </div>

        <hr class="mt-3 mb-1 px-5">

        <div class="modulos">

            <div class="modulo1">
                <div class="row my-3 gx-3 mx-5">

                    <h4 class="mb-3">Agregar modulo</h4>
                    <!-- nombre modulo  -->
                    <div class="col-5 mb-4">
                        <label for="modulo" class="from-label">Nombre del módulo</label>
                        <input minlength="1" maxlength="50" id="modulo" type="text" class="form-control" name="modulo"
                            placeholder="Módulo" required>
                    </div>
                    <!-- Descripcion modulo  -->
                    <div class="col-7 mb-4">
                        <label for="modulo" class="from-label">Descripción del módulo</label>
                        <input minlength="1" maxlength="100" id="modulo" type="text" class="form-control" name="modulo"
                            placeholder="Módulo" required>
                    </div>
                    <!-- video  -->
                    <div class="col-6 mb-4 ">
                        <label for="videoCurso" class="form-label">Video</label>
                        <input type="file" class="form-control" name="videoCurso" id="videoCurso" accept=".mp4">
                    </div>
                    <!-- Precio Modulo  -->
                    <div class="col-6 mb-4 ">
                        <label for="precioModulo" class="form-label">Precio Modulo</label>
                        <input id="precioModulo" name="precioModulo" type="number" class="form-control"
                            placeholder="$$$.$$$" required>
                    </div>
                    <!-- Adjunto de modulo  -->
                    <div class="col-5 mb-4 ">
                        <label for="adjModulo" class="form-label">Archivo adjunto del módulo (Opcional)</label>
                        <input type="file" class="form-control" name="adjModulo" id="adjModulo" accept=".pdf, .docx">
                    </div>
                    <!-- descripcion de archov adjunto -->
                    <div class="col-7 mb-4">
                        <label for="adjModuloDesc" class="from-label mb-2">Descripción del archivo adjunto
                            (Opcional)</label>
                        <input minlength="1" maxlength="100" id="adjModuloDesc" type="text" class="form-control"
                            name="adjModuloDesc" placeholder="Archivo adjunto">
                    </div>

                </div>

                <div class="row  my-3 gx-3 mx-5">
                    <!-- <div class="col-6">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg" id="genOtroMod">Generar otro
                            módulo</button>
                    </div> -->

                    <div class="col-6">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg" id="genMod">Guardar
                            Modulo</button>
                    </div>
                </div>



            </div>

        </div>

    </div>
    <script src="scripts/crearCurso.js"></script>
</body>

</html>