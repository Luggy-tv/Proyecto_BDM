<?php
if (!isset($_GET['id'])) {
    header("HTTP/1.1 400 Bad Request");
    die("Se produjo un error de solicitud regrese a la pagina anterior y vuelvalo a intentar.");
} else {
    include_once("scripts/userClass.php");
    $id_Curso = $_GET['id'];
    $reporteDetalleCurso = getReporteDetalleDeCurso($id_Curso);
    $reporteDetalleCursoTotal = getReporteDetalleDeCursoTotal($id_Curso);
    // print_r($reporteDetalleCursoTotal);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Codebug | Compra</title>
    <link rel="icon" href="Recursos/Intellibug_placeholder.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/successCompra.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Varela+Round">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

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
                    <li class="nav-item">
                        <a class="nav-link link-light" href="chat.php">Mensajes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light" href="scripts/perfilRedir.php"
                            style="border-left-style: none;">Perfil</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <section>
        <div class="container bg-light my-5 py-3 px-3">
            <?php if (!empty($reporteDetalleCurso)): ?>
                <div class="container my-3 text-center">
                    <h1>Detalle de curso:
                        <?php echo $reporteDetalleCurso[0]['TituloCurso'] ?>
                    </h1>
                </div>
                <div class="col-12 bg-light rounded-3 p-2">

                    <table class="table table-striped bg-light rounded-3 p-3">
                        <thead>
                            <tr>
                                <th scope="col">Nombre usuario</th>
                                <th scope="col">Fecha de inscripcion</th>
                                <th scope="col">Nivel actual</th>
                                <th scope="col">Fecha de ultimo avance</th>
                                <th scope="col">Fecha de finalizacion</th>
                                <th scope="col">Monto pagado por el usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reporteDetalleCurso as $usuario): ?>
                                <tr>
                                    <td class="align-middle">
                                        <?php echo $usuario['NombreCompleto'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $usuario['FechaInscripcion'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $usuario['NivelActual'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $usuario['FechaDeUltimoAvance'] ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $usuario['fechaFinalizacion'] ?>
                                    </td>
                                    
                                    <td class="align-middle">
                                        <?php echo $usuario['TotalPagado'] ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="align-end">Ingresos totales de curso:</td>
                            <td>
                                <?php echo $reporteDetalleCursoTotal[0]['IngresoTotCurso']; ?>
                            </td>
                        </tfoot>
                    </table>

                </div>
            <?php else: ?>
                <h3 class="text-center mt-2">Nadie ha comprado tu curso aun</h3>
            <?php endif ?>
        </div>
    </section>

    <!--Footer-->
    <footer id="Footer" class="footer text center">
        <div class="text-center p-3">
            <p class="lead link-light">© 2023 Copyright: Codebug.com</p>
        </div>
    </footer>

</body>

</html>