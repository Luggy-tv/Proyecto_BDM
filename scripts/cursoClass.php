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

function getCursoForEditCurso($id)
{
    include("config.php");
    $sql = "call sp_selectDetalleCurso($id);";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function addModulo($ID_curso, $videoDireccion, $videoDescripcion, $precioModulo, $nombreModulo)
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

function getMasRecientes()
{

    include("config.php");
    $sql = "Call SP_SelectCursoForHome('C');";
    $result = mysqli_query($conn, $sql);
    $listaCursosmasVendidos = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $curso = new Curso(
            $row['id_Curso'],
            '',
            $row['titulo_curso'],
            $row['descripcion_curso'],
            '',
            $row['imagenEX'],
            $row['imagen'],
            ''
        );
        $listaCursosmasVendidos[] = $curso;
    }

    return $listaCursosmasVendidos;
}

function getMasVendidos()
{
    include("config.php");
    $sql = "Call SP_SelectCursoForHome('A');";
    $result = mysqli_query($conn, $sql);
    $listaCursosmasVendidos = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $curso = new Curso(
            $row['id_Curso'],
            '',
            $row['titulo_curso'],
            $row['descripcion_curso'],
            '',
            $row['imagenEX'],
            $row['imagen'],
            ''
        );
        $listaCursosmasVendidos[] = $curso;
    }

    return $listaCursosmasVendidos;
}

function getMejorCalificados()
{
    include("config.php");
    $sql = "Call SP_SelectCursoForHome('B');";
    $result = mysqli_query($conn, $sql);
    $listaCursosmasVendidos = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $curso = new Curso(
            $row['id_Curso'],
            '',
            $row['titulo_curso'],
            $row['descripcion_curso'],
            '',
            $row['imagenEX'],
            $row['imagen'],
            ''
        );
        $listaCursosmasVendidos[] = $curso;
    }

    return $listaCursosmasVendidos;
}

function editCurso($idCurso, $nuevoTitulo, $nuevoDescripcion, $nuevoPrecio, $nuevoImagen, $nuevoImagenEx, $nuevoCategoria)
{
    include("config.php");
    $sql = "Call SP_CursoManage('B',$idCurso,0,'$nuevoTitulo','$nuevoDescripcion',$nuevoPrecio,'$nuevoImagen','$nuevoImagenEx',$nuevoCategoria);";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function editModulo($id_Modulo, $nuevoTitulo, $nuevoDescripcion, $nuevoPrecio, $nuevoVideo)
{
    include("config.php");
    $sql = "call SP_nivelDeCursoManage('B', $id_Modulo, 0 ,'$nuevoVideo','$nuevoTitulo','$nuevoDescripcion',$nuevoPrecio);";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function editAdjunto($id_Adjunto, $nuevoDescripcion, $nuevoAdjunto)
{
    include("config.php");
    $sql = "Call SP_adjuntoDeCursoManage('B',$id_Adjunto,0,'$nuevoDescripcion','$nuevoAdjunto');";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getAdjuntoIdFromNivelId($id_Nivel)
{
    include("config.php");
    $sql = "call sp_SelectAdjuntoFromNivelID($id_Nivel);";
    $result = mysqli_query($conn, $sql);


    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $adjuntoId = $row['ID_AdjuntoDeCurso'];
        mysqli_free_result($result);
        mysqli_close($conn);
        return $adjuntoId;
    } else {
        mysqli_close($conn);
        return false;
    }
}

function deslistarCurso($id_Curso)
{
    include("config.php");
    $sql = "CALL SP_CursoManage('C',$id_Curso,0,0,0,0,0,0,0);";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}

function getModuloDetail($idModulo)
{
    include("config.php");
    $sql = "CALL sp_SelectModuloDetalle($idModulo)";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function inscibirACurso($idCurso)
{
    include("config.php");

    $idUser = getIDFromToken();

    $sql = "CALL sp_UsuarioEnCursoManage('A',$idUser,$idCurso);";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function crearDetalleOrden($idOrden, $idCurso, $precioCurso)
{
    include("config.php");
    $sql = "CALL sp_DetalleOrdenCreate($idOrden,$idCurso,$precioCurso);";
    $result = mysqli_query($conn, $sql);
}

function CrearOrden($montoTotal)
{
    include_once("userClass.php");
    $idUsuario = getIDFromToken();
    include("config.php");
    $sql = "CALL sp_OrdenCreate($idUsuario,$montoTotal);";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function checkUserInCursoStatus($idCurso)
{

    include("config.php");
    include_once("userClass.php");

    $idUser = getIDFromToken();

    $sql = "CALL sp_SelectIsUsuarioEnCurso($idUser,$idCurso);";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function getCursoComments($idCurso)
{
    include("config.php");

    $sql = "CALL sp_SelectComentariosCurso($idCurso);";

    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function checkIfUserHasCommentInCurso($idCurso)
{
    include("config.php");
    include_once("userClass.php");
    $idUser = getIDFromToken();
    $sql = "CALL sp_SelectIfUserHasComment($idUser,$idCurso);";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function addNivelToUsuarioEnCurso($idCurso)
{
    include("config.php");
    include_once("userClass.php");
    $idUser = getIDFromToken();
    $sql = "CALL sp_UsuarioEnCursoManage('B',$idUser,$idCurso);";
    $result = mysqli_query($conn, $sql);
}

function checkUserCursosForKardex()
{
    include("config.php");
    include_once("userClass.php");
    $idUser = getIDFromToken();
    $sql = "CALL sp_SelectUserInfoKardex($idUser);";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}

function calificacionInsert($idUser, $idCurso, $comment, $calif)
{
    include("config.php");

    $sql= "CALL sp_CalificacionInsert($calif,$idCurso,$idUser,'$comment');";
    $result = mysqli_query($conn,$sql);

    mysqli_close($conn);
    return $result;
}




?>