<?php

    /*class Database {
    
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "Codebug";

        public function InsertarUsuario($Nombre, $ApPaterno, $ApMaterno, $Email, $Pass, $Genero, $FechaDeNac, $Imagen, $isMaestro){
            
            try{
                $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $op = "A";
                $idUsuario = 0;
                
                $stmt = $conn->prepare("CALL SP_UsuarioManage(:OP, :p_ID_Usuario, :p_Nombre, :p_ApPaterno, :p_ApMaterno, :p_Email,:p_Pass, :p_Genero, :p_FechaDeNac, :p_Imagen, :p_isMaestro)");
                
                $stmt->bindParam(':OP', $op);
                $stmt->bindParam(':p_ID_Usuario', $idUsuario);
                $stmt->bindParam(':p_Nombre', $Nombre);
                $stmt->bindParam(':p_ApPaterno', $ApPaterno);
                $stmt->bindParam(':p_ApMaterno', $ApMaterno);
                $stmt->bindParam(':p_Email', $Email);
                $stmt->bindParam(':p_Pass', $Pass);
                $stmt->bindParam(':p_Genero', $Genero);
                $stmt->bindParam(':p_FechaDeNac', $FechaDeNac);
                $stmt->bindParam(':p_Imagen', $Imagen);
                $stmt->bindParam(':p_isMaestro', $isMaestro);

                

                $stmt->execute();

                echo "Registro Exitoso datos mandados: ".$Nombre, $ApPaterno, $ApMaterno, $Email, $Pass, $Genero, $FechaDeNac, $Imagen, $isMaestro;

            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            $conn = null;
        }

    }
    */

    $conn = mysqli_connect('localhost','Luis','L12345678','Codebug');

    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }

    //$sql = 'Select * from usuario;';

    //$result = mysqli_query( $conn, $sql );
    
    //$users = mysqli_fetch_all($result,MYSQLI_ASSOC);
    
    //mysqli_free_result($result);

    //mysqli_close($conn);

    //print_r($users);

    //print_r(explode(',',$users[0]['Nombre']));
    
?>