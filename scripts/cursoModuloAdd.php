<?php 
    $response = array(
        'success' => true,
        'message' => 'Hola'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
?>