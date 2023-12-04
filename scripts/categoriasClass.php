<?php

class Categoria{
    public $ID;
    public $Categoria;
    public $Descripcion;
    public $FechaCreada;
    public function __construct($ID,$categoria,$descripcion,$FechaCreada){
        $this->ID=$ID;
        $this->Categoria=$categoria;
        $this->Descripcion=$descripcion;
        $this->FechaCreada=$FechaCreada;
    }
};

function setCategoriasLista(){
    include("config.php");

    $sql= "Call SP_SelectCategoriasExistentes;";
    $result = mysqli_query($conn, $sql);
    $listaCategorias = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Cerrar la conexión
    mysqli_close($conn);
    
    // Verificar si se encontraron resultados
    if (!empty($listaCategorias)) {
        return $listaCategorias;
    } else {
        $response = null;
        return $response;    
    }

}

function deleteCategoria($ID){
    include("config.php");
    $sql = "call sp_categoriamanage('C',$ID,'','');";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
}

function addCategoria($nombre,$descripcion){
    include("config.php");
    $sql = "call sp_categoriamanage('A',0,'$nombre','$descripcion');";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
}

function checkCategoria($nombre){
    include("config.php");
    $sql= "call sp_selectCategoriasfromnombre('$nombre');";
    $result = mysqli_query($conn, $sql);
    $existeCategoria = (mysqli_num_rows($result) > 0);
    mysqli_close($conn);
    return $existeCategoria;
}