<?php

class Usuario
{
    public $nombre;
    public $apellidoPat;
    public $apellidoMat;
    public $Email;
    public $Imagen;
    public $isBlocked;
    public $isAdmin;
    public $isMaestro;

    public function __construct($nombre, $apellidoPat, $apellidoMat, $Email, $Imagen, $isBlocked, $isAdmin, $isMaestro)
    {
        $this->nombre = $nombre;
        $this->apellidoPat = $apellidoPat;
        $this->apellidoMat = $apellidoMat;
        $this->Email = $Email;
        $this->Imagen = $Imagen;
        $this->isBlocked = $isBlocked;
        $this->isAdmin = $isAdmin;
        $this->isMaestro = $isMaestro;
    }

}
;


function SetUserFromToken()
{

    include("config.php");

    $sessionToken = $_COOKIE['sessionToken'];
    $sql = "call SP_SelectUserFromToken('$sessionToken');";
    $result = mysqli_query($conn, $sql);
    $usuario_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $usuario = new Usuario(
        $usuario_data[0]['Nombre'],
        $usuario_data[0]['ApPaterno'],
        $usuario_data[0]['ApMaterno'],
        $usuario_data[0]['Email'],
        $usuario_data[0]['Imagen'],
        $usuario_data[0]['isBlocked'],
        $usuario_data[0]['isAdmin'],
        $usuario_data[0]['isMaestro']
    );
    return $usuario;
}

function getIDFromToken()
{

    include("config.php");

    $sessionToken = $_COOKIE['sessionToken'];
    $sql = "call SP_SelectIDFromToken('$sessionToken');";
    $result = mysqli_query($conn, $sql);
    $usuario_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $ID_Usuario = $usuario_data[0]['ID_Usuario'];

    return $ID_Usuario;

}
?>