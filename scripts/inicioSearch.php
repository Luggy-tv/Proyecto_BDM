<?php
include("config.php");

$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

$sql="call sp_SelectBuscarCursoInicio('$searchTerm');";
$result = mysqli_query($conn, $sql);

$output = "";

if (mysqli_num_rows($result) == 0) {
    $output = "No se encuentan cursos disponibles con ese titulo";
} elseif (mysqli_num_rows($result) > 0) {
  while($row= mysqli_fetch_assoc($result)){
    $output ='
    <div>
        <a href="scripts/cursoRedir.php?id='.$row['id_Curso'].'">
            <h4>'.$row['titulo_curso'].'</h4>
        </a>
        <p id="busquedaText">'.$row['descripcion_curso'].'</p>
        <p id="busquedaText">Impartido por '. $row['Nombre_Docente'].'</p>
    </div> 
    ';
  }
}

echo $output;


?>