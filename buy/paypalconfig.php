<?php
define('ProPayPal', 0);
if(ProPayPal){
    define("PayPalClientId", "*********************");
    define("PayPalSecret", "*********************");
    define("PayPalBaseUrl", "https://api.paypal.com/v1/");
    define("PayPalENV", "production");
} else {
    define("PayPalClientId", "Ac2vNhwHKF52iA704X4HtG-HfYKpBQu-dzf_GU2DLupFwmNb8LU3FjXZsSKjaOj8HBPSTif1rnBUjUjp");
    define("PayPalSecret", "ECF1Laqe3jdsFQHMpOdisIlsRblLkAQODry72_2kydQYgzhdN3KvyqHYBcrBJmYIuuR0UkHBC0QJHwdl");
    define("PayPalBaseUrl", "http://localhost:8080/RepositorioParaProyectoDeBDM/BDM/buy/");
    define("PayPalENV", "sandbox");
}
?>
