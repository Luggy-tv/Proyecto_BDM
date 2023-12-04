<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}
include_once('tbs_class.php');
include_once('plugins/tbs_plugin_opentbs.php');

$TBS = new clsTinyButStrong;
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

//Parametros
$usuario = $_POST['user'];
$fecha = $_POST['fecha'];
$curso = $_POST['curso'];
$docente = $_POST['docente'];


//Cargando template
$template = 'Plantilla_Colegiado.docx';
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

//Escribir Nuevos campos
$TBS->MergeField('pro.usuario', $usuario);
$TBS->MergeField('pro.curso', $curso);
$TBS->MergeField('pro.nomprofesor', $docente);
$TBS->MergeField('pro.fechaprofesor', $fecha);

$TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as']) !== '') && ($_SERVER['SERVER_NAME'] == 'localhost')) ? trim($_POST['save_as']) : '';
$output_file_name = "Diploma_Codebug_".$fecha. ".docx";
if ($save_as === '') {
    $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
    exit();
} else {
    $TBS->Show(OPENTBS_FILE, $output_file_name);
    exit("File [$output_file_name] has been created.");
}
?>