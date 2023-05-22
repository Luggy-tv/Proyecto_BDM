<?php
include("config.php");
include("userClass.php");
$ID_Incoming = mysqli_real_escape_string($conn, $_POST['id']);

$sql = "call SP_SelectUSerFromIDForChat($ID_Incoming);";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$imagen = $row['Imagen'];
$imagen_base64 = base64_encode($imagen);

$ID_Outgoing=getIDFromToken();


$output = "<div id='chatbox' class='px-4 py-5 chat-box h-100'>
              <img src='data:image/ " . $row['ImagenEx'] . ";base64, " . $imagen_base64 . " ' alt='Foto de " . $row['Nombre_Completo'] . " ' width='50' class='rounded-circle' />
              <p id='' class='h5 mb-0 py-1'>Aqui inicia el chat con " . $row['Nombre_Completo'] . "</p>
            ";

$output .="
            <div id='getchat'>

            </div>
            ";  

$output.=   "
            </div>
            
            <!-- Typing area -->
            <form id='typing-Area' action='#' class='bg-light'>
              <div class='input-group'>
                <input type='hidden' name='id_usuario' value=".$ID_Incoming.">
                <input id='InputField'name='InputField' max='140' type='text' placeholder='Escribe el mensaje' aria-describedby='button-addon2'
                class='form-control rounded-0 border-0 py-4 bg-light' />
                <div class='input-group-append'>
                  <button id='button-addon2' type='submit' class='btn'>
                    Enviar
                  </button>
                </div>
                </form>
                <div class='input-group-append'>
                  <button id='button-addon3' class='btn'>
                    Refresh
                  </button>
                </div>
              </div>
 


            ";


print_r($output);

?>