<?php
include("config.php");

$ID = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "call SP_SelectUSerFromIDForChat($ID);";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$imagen = $row['Imagen'];
$imagen_base64 = base64_encode($imagen);

$output = " <img src='data:image/ " . $row['ImagenEx'] . ";base64, " . $imagen_base64 . " ' alt='Foto de " . $row['Nombre_Completo'] . " ' width='50' class='rounded-circle' />
            <p class='h5 mb-0 py-1'>Aqui inicia el chat con " . $row['Nombre_Completo'] . "</p>";

$output .= '<div class="media w-auto ml-auto mb-3">
            <div class="media-body">
              <div class="bg rounded py-2 px-3 mb-2">
                <p id="turesp" class="text-small mb-0 text-white">
                  Tu respuesta a ese mensaje
                </p>
              </div>
              <p class="small text-muted">12:00 PM | Aug 13</p>
            </div>
          </div>';

$output .= '<div class="media w-auto mb-3">
            <img src="data:image/'. $row['ImagenEx'] .';base64,'. $imagen_base64. ' " alt="Foto de '.$row['Nombre_Completo'].'" width="50" class="rounded-circle" />
            <div class="media-body ml-3">
              <div class="bg-light rounded py-2 px-3 mb-2">
                <p class="text-small mb-0 text-muted">
                  Mensaje de prueba con chatter
                </p>
              </div>
              <p class="small text-muted">12:00 PM | Aug 13</p>
            </div>
          </div>';


print_r($output);

?>