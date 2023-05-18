<?php

require_once("userClass.php");

$usuario = SetUserFromToken();

if ($usuario->isMaestro) {

    header("Location: ../perfilMaestro.php");
} else {
    if ($usuario->isAdmin) {

        header("Location: ../perfilAdmin.php");
    } else {

        header("Location: ../perfil.php");
    }
}

?>