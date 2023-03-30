<?php

    $conn = mysqli_connect('localhost','Luis','L12345678','Codebug');

    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }

    
    
?>