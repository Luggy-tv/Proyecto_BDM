class user{
    constructor(user,password){
        this.password=password;
        this.user=user;
    }
}

let formLogin =document.getElementById("form-login");

var passRegex = new RegExp("^((?=.*[A-Z])(?=.*[0-9])(?=.*[-¡!¿?:;@#_$%^&,.{}=+*[])(?=.{8,}))");


formLogin.addEventListener("submit", (e)=>{

    e.preventDefault();
    //let inputEmail = document.getElementById("email").value;
    let inputContraseña =document.getElementById("password").value;
    
   // console.log(inputEmail);
   // console.log(inputContraseña);
   // console.log(validatePassword(inputContraseña));
   
    if(validatePassword(inputContraseña)){
       alert("Contraseña y correo validos");
       formLogin.reset();
   }
   else{
       alert("Contraseña invalida, favor de volverla a ingresar ");
       formLogin.reset();
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