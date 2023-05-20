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

function addCurso( $titulo, $descripcion, $precio, $imagenEx, $imagen, $categoria){
    include("config.php");
    include("userClass.php");
    $id_usuario = getIDFromToken();
    $sql="CALL SP_CursoManage('a',0,$id_usuario,'$titulo','$descripcion','$precio','$imagen','$imagenEx',$categoria);";
    $result = mysqli_query($conn, $sql);
    return $result;
}

?>