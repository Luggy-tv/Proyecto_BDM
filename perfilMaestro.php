<?php
if (!isset($_COOKIE['sessionToken']) || empty($_COOKIE['sessionToken'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud. La cookie no se encontró o está vacía. Para poder entrar a esta pagina inicie sesion.");
} else {
    include_once("scripts/userClass.php");
    $usuario = SetUserFromToken();
    $usuario_nombreComp = $usuario->nombre . " " . $usuario->apellidoPat . " " . $usuario->apellidoMat;

    $reporteDeCurso = getReporteDeCurso();
    $reporteTotalDeCursos = getReporteTotalDeCursos();

    include_once("scripts/categoriasClass.php");
    $listaCategorias = setCategoriasLista();

    // print_r($reporteDeCurso);
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | Codebug </title>

    <link rel="icon" href="Recursos/Intellibug_placeholder.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="CSS/perfil.css">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Varela+Round">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</head>

<body>
    <!--NAV BAR-->
    <nav class="navbar navbar-dark navbar-expand-md">
        <div class="container-fluid">

            <a class="navbar-brand link-light" href="inicio.php">Codebug</a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navcol-1" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto" style="border-bottom-style: none;">
                    <li class="nav-item"><a class="nav-link link-light" href="chat.php">Mensajes</a></li>
                </ul>
            </div>

        </div>
    </nav>

    <!--Imagen y nombre de perfil-->
    <section>
        <div class="container-fluid py-5 bg-light ">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-2">
                    <img class="img-fluid img-thumbnail h-auto" src="scripts/loaduserimg.php">
                </div>
                <div class="col-8 mt-3 ">
                    <h1 id="nombreCompleto" class="fw-bold">
                        <?php echo $usuario_nombreComp ?>
                    </h1>
                    <p id="correo">
                        <?php echo $usuario->Email ?>
                    </p>
                    <!--<a id="btn-loadNewPfp" class="btn btn-primary px-2 py-1" href="#">Actualizar foto de perfil</a>-->
                    <a id="btn-editProfile" class="btn btn-primary px-2 py-1" href="editperfil.php">Editar perfil</a>
                    <a id="btn-crearCurso" class="btn btn-primary px-2 py-1" href="crearCurso.php">Crear Curso</a>
                </div>
            </div>
        </div>
    </section>


    <!--KARDEX-->
    <section>
        <div id="kardex" class="row pb-4 py-3">
            <h2 class="my-2 text-center fw-bold pb-3">Reportes de Cursos</h2>
            <div class="container-xl ">
                <div class="row">

                    <div class="col-1"></div>
                    <?php if (!empty($reporteDeCurso)): ?>
                        <div class="col-10 mb-3">

                            <div class="accordion " id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapseOne" aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            Filtros
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="fecha" class="form-label">Fecha de creacion</label>
                                                    <input id="fecha" type="date" class="form-control" name="fecha">
                                                    <button type="submit" id="fecha-btn"
                                                        class="btn btn-primary w-100 mt-2 mb-1 ">Filtrar por fecha</button>
                                                </div>
                                                <div class="col-4">
                                                    <label for="" class="form-label">Categoria</label>
                                                    <select name="categoria" id="categoria" class="form-control">
                                                        <?php foreach ($listaCategorias as $categoria): ?>
                                                            <?php echo "<option value='" . $categoria['ID'] . "'> " . $categoria['Categoria'] . "</option>"; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit" id="categoria-btn"
                                                        class="btn btn-primary w-100 mt-2 mb-1 ">Filtrar por
                                                        categoria</button>
                                                </div>

                                                <div class="col-4">
                                                    <label for="" class="form-label">Estatus</label>
                                                    <select name="estatus" id="estatus" class="form-control">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Deslistado</option>
                                                    </select>
                                                    <button type="submit" id="estatus-btn"
                                                        class="btn btn-primary w-100 mt-2 mb-1">Filtrar por estatus
                                                    </button>
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" id="all-btn"
                                                        class="btn btn-info w-100 mt-2 mb-1">Usar todos los filtros
                                                    </button>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-1"></div>
                        <div class="col-1"></div>

                        <div class="col-10 bg-light rounded-3 p-0">
                            <table class="table table-striped bg-light rounded-3 p-3">
                                <thead>
                                    <tr class="align-middle">
                                        <th scope="col" class="text-center">Curso</th>
                                        <th scope="col" class="text-center">Estado curso</th>
                                        <th scope="col" class="text-center">Categoria</th>
                                        <th scope="col" class="text-center">Reporte de curso</th>
                                        <th scope="col" class="text-center">Fecha de creacion</th>
                                        <th scope="col" class="text-center">Cantidad de alumnos</th>
                                        <th scope="col" class="text-center">Nivel promedio de alumno</th>
                                        <th scope="col" class="text-center">Total de ingresos por curso</th>

                                    </tr>
                                </thead>
                                <tbody id="cuerpoDeTabla">
                                    <?php foreach ($reporteDeCurso as $curso): ?>
                                        <tr class="align-middle text-center">
                                            <td scope="row">
                                                <a class="link-primary"
                                                    href="scripts/cursoRedir.php?id=<?php echo $curso['IndiceCurso'] ?>">
                                                    <?php echo $curso["TituloCurso"]; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo $curso['Estatus'] ?>
                                            </td>
                                            <td>
                                                <?php echo $curso['NombreDeCategoria'] ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary w-auto"
                                                    href="./reporteCursoDetalle.php?id=<?php echo $curso['IndiceCurso'] ?>">
                                                    Ir a Detalle
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo $curso['FechaCreacion'] ?>
                                            </td>
                                            <td>
                                                <?php echo $curso["CantidadUsuarios"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $curso["PromedioNivel"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $curso["TotalVentas"]; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end">Ingresos totales: </td>
                                    <td class="text-center">
                                        <?php if (empty($reporteTotalDeCursos)) {
                                            echo "No han comprado tus cursos";
                                        } else {
                                            echo $reporteTotalDeCursos[0]['IngresosTotales'];
                                        } ?>
                                    </td>
                                </tfoot>


                            </table>
                        </div>

                    <?php else: ?>
                        <div class="col-10">
                            <h3 class="text-center mt-2">No haz creado ningun curso!</h3>
                        </div>
                    <?php endif; ?>

                    <div class="col-1"></div>
                </div>
            </div>
        </div>
    </section>

    <!--Footer-->
    <footer id="Footer" class="footer text center">
        <div class="text-center p-3">
            <p class="lead link-light">© 2023 Copyright: Codebug.com</p>
        </div>
    </footer>
    
    <script src="scripts/perfilMaestro.js"></script>
</body>

</html>