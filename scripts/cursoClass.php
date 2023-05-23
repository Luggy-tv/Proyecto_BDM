<?php
class Curso
{
    public $ID_Curso;
    public $docente;
    public $titulo;
    public $descripcion;
    public $precio;
    public $imagen;
    public $imagenEx;
    public $categoria;

    public function __construct($ID_Curso, $docente, $titulo, $descripcion, $precio, $imagenEx, $imagen, $categoria)
    {
        $this->ID_Curso = $ID_Curso;
        $this->docente = $docente;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagenEx = $imagenEx;
        $this->imagen = $imagen;
        $this->categoria = $categoria;
    }

}

function addCurso($titulo, $descripcion, $precio, $imagenEx, $imagen, $categoria)
{
    include("config.php");
    include("userClass.php");
    $id_usuario = getIDFromToken();
    $sql = "CALL SP_CursoManage('a',0,$id_usuario,'$titulo','$descripcion','$precio','$imagen','$imagenEx',$categoria);";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getCursoFromTituloAndCurrUser($titulo)
{
    include("config.php");
    include("userClass.php");
    $id_usuario = getIDFromToken();
    $sql = "CALL SP_SelectCursoFromTituloAndCurrentUser('$titulo',$id_usuario);";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function getCursoForCursoInfo($id)
{
    include("config.php");
    $sql = "call sp_selectDetalleCurso($id);";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function addModulo($ID_curso, $videoDireccion, $videoDescripcion, $precioModulo,$nombreModulo)
{
    include("config.php");
    $sql = "Call SP_nivelDeCursoManage('A',0,$ID_curso,'$videoDireccion','$nombreModulo','$videoDescripcion','$precioModulo')";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function addAdjunto($nivelCursoID, $descripcion, $adjunto)
{
    include("config.php");
    $sql = "call SP_adjuntoDeCursoManage('A',0,$nivelCursoID,'$descripcion','$adjunto');";
    $result = mysqli_query($conn, $sql);
}

// $row=getCursoFromTituloAndCurrUser("Gatos 3");
// print_r($row[0]['id_Curso']);

?>