<?php

require_once("userClass.php");
    
$usuario = SetUserFromToken();
    
if($usuario->isMaestro){

    header("Location: http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/perfilMaestro.html");
}else{
    if($usuario->isAdmin){

        header("Location: http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/perfilAdmin.php");
    }
    else{

        header("Location: http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/perfil.html");
    }
}

?>
