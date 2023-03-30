<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        include("config.php");
        $Email =  $_POST['email'];
        $Pass =    $_POST['password'];

        
        
        if(ValidaEmail($Email)){
            
            if(ValidPass($Email,$Pass)){
                
                $sql ="call SP_UsuarioLoginUpdate('$Email');";
                $result =mysqli_query($conn,$sql);
                $token =mysqli_fetch_all($result, MYSQLI_ASSOC);
                $p_token =$token[0]['p_token'];
                setcookie("sessionToken",'',time() - 3600);
                CreaCookie("sessionToken", $p_token, 7);
                
                /*
                ?>
                    <script>
                        
                        function setCookie(cname, cvalue, exdays) {
                            const d = new Date();
                            d.setTime(d.getTime() + (exdays*24*60*60*1000));
                            let expires = "expires="+ d.toUTCString();
                            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                        }
                        
                        var token = '<?php echo $token[0]['p_token']; ?>';
                        
                        setCookie("sessionToken",token, 4);

                    </script>

                <?php
                */
                //print_r($p_token);
                
                mysqli_close($conn);
                header("Location: http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/inicio.html");
               

            }else{
                //$sql = "call "
                $em= "La contraseña no es correcta";
                header("Location: http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/login.php?error=$em");
                mysqli_close($conn);
            }


        }else{
            $em= "Ese correo electronico no existe o el usuario esta bloqueado";
            header("Location: http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/login.php?error=$em");
            mysqli_close($conn);
        }

       
    }

    function ValidaEmail($emailInput){
        include("config.php");
        $sql ="call SP_SelectTables(1);";
        $result =mysqli_query($conn,$sql);
        $emails =mysqli_fetch_all($result, MYSQLI_ASSOC);
        $emailFound = false;
        foreach ($emails as $email) {
            if ($email['email'] == $emailInput) {
               $emailFound = true;
               break;
            }
        }
       
        if ($emailFound) {
            //echo "Email found in the database!";
            return true;
        } else {
            //echo "Email not found in the database.";
            return false;
        }
   }

    function ValidPass($emailInput,$passImput){
        include("config.php");
        
        $sql = "call SP_SelectPassFromEmail('$emailInput'); ";
        
        $result =mysqli_query($conn,$sql);

        $passwords =mysqli_fetch_all($result, MYSQLI_ASSOC);
        $passMatch =false;

        foreach($passwords as $password){
            if($password['pass']==$passImput){
                $passMatch = true;
                break;
            }
        }
        

        if ($passMatch) {
            //echo "Pass is the same in db";
            return true;
        } else {
            //echo "Pass is not found in db";
            return false;
        }
    }

    function CreaCookie($name, $value, $expires) {
        $expiry_time = time() + ($expires * 24 * 60 * 60);
        $expiry_date = gmdate('D, d M Y H:i:s T', $expiry_time);
        setcookie($name, $value, $expiry_time, '/', '', false, true);
      }

?>