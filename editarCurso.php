<?php
if (isset($_GET['id'])) {

    $cursoID = $_GET['id'];
    // print_r($_GET['id']);
    include("scripts/cursoClass.php");
    $cursoYModulos = getCursoForEditCurso($cursoID);
    // print_r($cursoYModulos);

    include_once("scripts/categoriasClass.php");
    $listaCategorias = setCategoriasLista();
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
    <title> Codebug | Editar curso</title>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
                <h1>Editar curso :
                    <?php echo $cursoYModulos[0]['titulo'] ?>
                </h1>
            </div>

        </div>
        <div class="infoCurso">
            <form id="form-editcursoinfo" action="" method="post" enctype="multipart/form-data">
                <div class="row gx-3 mx-5">

                    <!-- escondidos -->
                    <!-- ID categoria  -->
                    <!-- Cantidad de Modulos  -->
                    <!-- <input type="hidden" name="numModulos" id="numModulos" value="<?php echo "lol" ?>"> -->
                    <!-- id curso -->
                    <input type="hidden" name="idCurso" id="idCurso"
                        value="<?php echo $cursoYModulos[0]['ID_Curso'] ?>">

                    <!-- Nombre Curso -->
                    <div class="col-7 mb-4">
                        <label for="editNombreCurso" class="from-label">Nombre del curso</label>
                        <input minlength="1" maxlength="50" id="editNombreCurso" type="text" class="form-control"
                            name="editNombreCurso" placeholder="<?php echo $cursoYModulos[0]['titulo'] ?>" required>
                    </div>

                    <!-- Nombre Categoria  -->
                    <div class="col-5 form-group">
                        <label for="categoria" class="from-label ">Categoría</label>
                        <select name="categoria" id="categoria" class="form-control">
                            <?php foreach ($listaCategorias as $categoria): ?>
                                <?php $selected = ($categoria['ID'] == $cursoYModulos[0]['id_categoria']) ? 'selected' : ''; ?>
                                <?php echo "<option value='" . $categoria['ID'] . "' $selected > " . $categoria['Categoria'] . "</option>"; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Descripcionde curso -->
                    <div class="col-12 mb-4 ">
                        <label for="editDescCurso" class="form-label">Descripcion de Curso</label>
                        <textarea name="editDescCurso" id="editDescCurso" type="text" class="form-control"
                            minlength="10" maxlength="200"
                            placeholder="<?php echo $cursoYModulos[0]['Curso_Descripcion'] ?>" required></textarea>

                    </div>

                    <!-- Precio de curso  -->
                    <div class="col-6 mb-4 ">
                        <label for="editPrecioCurso" class="form-label">Precio de Curso</label>
                        <input id="editPrecioCurso" name="editPrecioCurso" type="text" class="form-control"
                            placeholder="<?php echo $cursoYModulos[0]['precio_Curso'] ?>" required>
                    </div>

                    <!-- Imagen de Curso  -->
                    <div class="col-6 mb-4 ">
                        <label for="editImagenDeCurso" class="form-label">Nueva imagen del curso</label>
                        <input type="file" class="form-control" name="editImagenDeCurso" id="editImagenDeCurso"
                            accept=".png, .jpg, .jpeg" required>
                    </div>

                    <div class="col-12 py-2">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">Editar datos principales del
                            curso</button>
                    </div>

                </div>
            </form>
        </div>

        <div class="modulos">
            <?php foreach ($cursoYModulos as $modulo): ?>
                <div class="modulo">

                    <hr class="mt-1 mb-1 px-5">
                    <form action="" method="POST" id="form-moduloinfo<?php echo $modulo['Modulo_ID'] ?>"
                        enctype="multipart/form-data">

                        <div id="error-<?php echo $modulo['Modulo_ID'] ?>">
                        </div>

                        <div id="success-<?php echo $modulo['Modulo_ID'] ?>">
                        </div>

                        <div class="row my-3 gx-3 mx-5">
                            <h4 class="mt-2 mb-3">Editar modulo </h4>

                            <div class="col-5 mb-4">
                                <label for="editNombreModulo<?php echo $modulo['Modulo_ID'] ?>" class="form-label">Nombre
                                    del módulo</label>
                                <input minlength="1" maxlength="50" id="editNombreModulo<?php echo $modulo['Modulo_ID'] ?>"
                                    type="text" class="form-control" name="editNombreModulo"
                                    placeholder="<?php echo $modulo['nombreNivel'] ?>" required>
                            </div>

                            <div class="col-7 mb-4">
                                <label for="editDescripcionModulo<?php echo $modulo['Modulo_ID'] ?>"
                                    class="form-label">Descripción del módulo</label>
                                <input minlength="1" maxlength="100"
                                    id="editDescripcionModulo<?php echo $modulo['Modulo_ID'] ?>" type="text"
                                    class="form-control" name="editDescripcionModulo"
                                    placeholder="<?php echo $modulo['Nivel_Descripcion'] ?>" required>
                            </div>

                            <div class="col-5 mb-4">
                                <label for="editVideoModulo<?php echo $modulo['Modulo_ID'] ?>"
                                    class="form-label">Video</label>
                                <input type="file" class="form-control" name="editVideoModulo"
                                    id="editVideoModulo<?php echo $modulo['Modulo_ID'] ?>" accept=".mp4,.mov" required>
                            </div>

                            <div class="col-7 mb-4">
                                <label for="editPrecioModulo<?php echo $modulo['Modulo_ID'] ?>" class="form-label">Precio
                                    Módulo</label>
                                <input id="editPrecioModulo<?php echo $modulo['Modulo_ID'] ?>" name="editPrecioModulo"
                                    type="text" class="form-control" placeholder="<?php echo $modulo['precio_Nivel'] ?>"
                                    required>
                            </div>

                            <div class="col-5 mb-4">
                                <label for="editAdjModulo<?php echo $modulo['Modulo_ID'] ?>" class="form-label">Archivo
                                    adjunto del módulo (Opcional)</label>
                                <input type="file" class="form-control" name="editAdjModulo"
                                    id="editAdjModulo<?php echo $modulo['Modulo_ID'] ?>" accept=".pdf, .docx">
                            </div>

                            <div class="col-7 mb-4">
                                <label for="editAdjModuloDescripcion<?php echo $modulo['Modulo_ID'] ?>"
                                    class="form-label mb-2">Descripción del archivo adjunto
                                    (Opcional)</label>
                                <input minlength="1" maxlength="100"
                                    id="editAdjModuloDescripcion<?php echo $modulo['Modulo_ID'] ?>" type="text"
                                    class="form-control" name="editAdjModuloDescripcion"
                                    placeholder="Descripcion de adjunto">
                            </div>

                            <div class="col">
                                <button type="button" name="submit" class="btn btn-primary btn-lg"
                                    id="submitMod-btn<?php echo $modulo['Modulo_ID'] ?>"
                                    onclick="enviarFormulario(event, <?php echo $modulo['Modulo_ID'] ?>)">Editar datos de
                                    modulo</button>
                            </div>

                        </div>

                    </form>
                </div>

            <?php endforeach; ?>

        </div>

        <div class="row" id="return-btn">
            <div class="col-16 py-2">
                <a id="btn-crearCurso" class="btn btn-primary btn-lg"
                    href="scripts/cursoRedir.php?id=<?php echo $cursoID ?>">
                    Regresar a pagina del curso</a>
            </div>
        </div>

        <!-- Button trigger modal -->
        <button type="button" id="delist-btn" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" <?php if(!$cursoYModulos[0]['disponible']) echo "disabled"?> >
            Deslistar Curso
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">¿Deslistar Curso?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       Esta seguro que quiere deslistar el curso? Al momento de deslistar el curso usted no podra volverlo a activar asimismo tampoco lo podran comprar nuevos estudiantes. Para los estudiantes que ya lo compraron les aparecera en el kardex y el desglose del curso le seguira apareciento a usted.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" onclick="deslistarCurso(event,<?php echo $cursoYModulos[0]['ID_Curso'] ?>)" class="btn btn-primary">Eliminar Curso</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="scripts/cursoEdit.js"></script>
</body>

</html>