let formLogin =document.getElementById("form-login");

var passRegex = new RegExp("^((?=.*[A-Z])(?=.*[0-9])(?=.*[-¡!¿?:;@#_$%^&,.{}=+*[])(?=.{8,}))");


formLogin.addEventListener("submit", (e)=>{

  
    //let inputEmail = document.getElementById("email").value;
    let inputContraseña =document.getElementById("password").value;
    
   // console.log(inputEmail);
   // console.log(inputContraseña);
   // console.log(validatePassword(inputContraseña));
   
    if(!validatePassword(inputContraseña)){
        alert("Contraseña invalida, favor de volverla a ingresar ");
       formLogin.reset();
       e.preventDefault();
       //alert("Contraseña y correo validos");
       //window.location = 'inicio.html';
   }
})

function validatePassword(password){
    if(passRegex.test(password)){
        return true;
    }
    else{
        return false;
    }
}