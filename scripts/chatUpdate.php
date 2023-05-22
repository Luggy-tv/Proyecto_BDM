<?php
include("config.php");
include("userClass.php");

$ID_Incoming = $_POST['id'];
$ID_Outgoing=getIDFromToken();
$output="";

$sql="call SP_SelectMensajesFromUsers($ID_Incoming,$ID_Outgoing);";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        if($row['Emisor'] == $ID_Outgoing ){
            $output.="              
            <div class='media w-auto ml-auto mb-3'>
            <div class='media-body'>
              <div class='bg rounded py-2 px-3 mb-2'>
                <p id='turesp' class='text-small mb-0 text-white'>
                  ".$row['Mensaje']."
                </p>
              </div>
              <p class='small text-muted'>".$row['hora_minuto']." | ".$row['Dia']."</p>
            </div>
          </div>";
        }
        if($row['Emisor']==$ID_Incoming){
            $output.="
            <div class='media w-auto mb-3'>
             <div class='media-body ml-3'>
              <div class='bg-light rounded py-2 px-3 mb-2'>
                <p class='text-small mb-0 text-muted'>
                  ".$row['Mensaje']."
                </p>
              </div>
              <p class='small text-muted'>".$row['hora_minuto']." | ".$row['Dia']."</p>
            </div>
          </div>";
        }
    }
}


echo $output;

?>