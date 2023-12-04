<?php
if (!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['pid'])) {

  $paymentID = $_GET['paymentID'];
  $payerID = $_GET['payerID'];
  $token = $_GET['token'];
  $pid = $_GET['pid'];

  $cookieData = $_COOKIE['carrito'];
  $dataArray = json_decode($cookieData, true);
  $precioTotal = 0;

  foreach ($dataArray as $curso) {
    $precioTotal += $curso['precio'];
  }
  include("../scripts/cursoClass.php");

  $result = CrearOrden($precioTotal);

  $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $idOrden = $row[0]['ultimo_id'];
  
  foreach ($dataArray as $curso) {
    crearDetalleOrden($idOrden, $curso['identificador'], $curso['precio']);
    inscibirACurso($curso['identificador']);
  }

  setcookie('carrito', '', time() - 3600, '/');
  
  header('Location:./SuccessCompra.html');

} else {
  header('Location:./checkout.php');
}
?>