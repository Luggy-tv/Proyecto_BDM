<?php
while ($row = mysqli_fetch_assoc($result)) {
    $imagen = $row['Imagen'];
    $imagen_base64 = base64_encode($imagen);

    $output .= '<a id="' . $row['ID_Usuario'] . '" class="list-group-item list-group-item-action list-group-item-light rounded-0" onclick="showConvo(' . $row['ID_Usuario'] . ')">
                        <div class="media">
                        <img src="data:image/' . $row['ImagenEx'] . ';base64,' . $imagen_base64 . '" alt="Foto de ' . $row['Nombre_Completo'] . ' " width="50" class="rounded-circle" />
                        <div class="media-body ml-4">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                            <h6 class="mb-0">' . $row['Nombre_Completo'] . '</h6>
                            </div>
                            <p class="font-italic mb-0 text-small">
                            Mensaje de prueba
                            </p>
                        </div>
                        </div>
                    </a> ';
}

?>