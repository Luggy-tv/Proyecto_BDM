class user{
    constructor(mail,password,genero,esMaestro,nombre,apellidoPat,apellidoMat,fechaNac,fotoDePerfil){
        this.password=password;
        this.mail=mail;
        this.genero=genero;
        this.esMaestro=esMaestro;
        this.nombre=nombre;
        this.apellidoPat=apellidoPat;
        this.apellidoMat=apellidoMat;
        this.fechaNac= fechaNac;
        this.fotoDePerfil=fotoDePerfil;
    }
}

var nameRegex = new RegExp("^[A-Za-z]+$");
var passRegex = new RegExp("^((?=.*[A-Z])(?=.*[0-9])(?=.*[-¡!¿?:;@#_$%^&,.{}=+*[])(?=.{8,}))");

let formSignin = document.getElementById("form-signin");

formSignin.addEventListener("submit", (e)=>{

    let inputEmail= document.getElementById("email").value;
    
    let inputGenero= document.getElementsByName("Genero").value;
    
    let inputEsMaestro = document.getElementById("esMaestro").value;

    let inputNombre = document.getElementById("nombre").value;
    let inputApellidoPat= document.getElementById("apellidoPat").value;
    let inputApellidoMat= document.getElementById("apellidoMat").value;

    let inputPassword= document.getElementById("password").value;
    let inputConfirmpass = document.getElementById("confirmPass").value;
    
    if(nameRegex.test(inputNombre) && nameRegex.test(inputApellidoPat)){
        if(apellidoMat!=null){
           if(nameRegex.test(inputApellidoMat)){
              console.log(inputNombre);
              console.log(inputApellidoPat);
              console.log(inputApellidoMat);
                
           } 
        }
        else{
            
        }
    }

})