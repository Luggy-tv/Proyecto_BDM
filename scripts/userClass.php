<?php

class Usuario
{
    public $nombre;
    public $apellidoPat;
    public $apellidoMat;
    public $Email;
    public $Imagen;
    public $ImagenEx;
    public $isBlocked;
    public $isAdmin;
    public $isMaestro;

    public function __construct($nombre, $apellidoPat, $apellidoMat, $Email, $Imagen, $ImagenEx, $isBlocked, $isAdmin, $isMaestro)
    {
        $this->nombre = $nombre;
        $this->apellidoPat = $apellidoPat;
        $this->apellidoMat = $apellidoMat;
        $this->Email = $Email;
        $this->Imagen = $Imagen;
        $this->ImagenEx=$ImagenEx;
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

    // print_r($usuario_data);

    // if($usuario_data[0]){
    //     header("HTTP/1.1 400 Bad Request");
    //     die("Se produjo un error de solicitud. Para poder entrar a esta pagina inicie sesion nuevamente.");
    // }
    
    $usuario = new Usuario(
        $usuario_data[0]['Nombre'],
        $usuario_data[0]['ApPaterno'],
        $usuario_data[0]['ApMaterno'],
        $usuario_data[0]['Email'],
        $usuario_data[0]['Imagen'],
        $usuario_data[0]['ImagenEx'],
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