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
var nameRegex = /^[a-zA-Z\s]+$/;
var passRegex = new RegExp("^((?=.*[A-Z])(?=.*[0-9])(?=.*[-¡!¿?:;@#_$%^&,.{}=+*[])(?=.{8,}))");

let formSignin = document.getElementById("form-signin");

formSignin.addEventListener("submit", (e)=>{

    e.preventDefault();

    let inputEmail= document.getElementById("email").value;
    
    let inputGenero= document.getElementsByName("Genero");
    
    let inputEsMaestro = document.getElementById("esMaestro").value;

    let inputFechaDeNac = document.getElementById("fechaDeNac").value;

    let inputNombre = document.getElementById("nombre").value;
    let inputApellidoPat= document.getElementById("apellidoPat").value;
    let inputApellidoMat= document.getElementById("apellidoMat").value;

    let inputPassword= document.getElementById("password").value;
    let inputConfirmpass = document.getElementById("confirmPass").value;
    
    validatePassword(inputPassword)
        
    validateConfirmPass(inputPassword,inputConfirmpass);

    validaCorreo(inputEmail);

    validaGenero(inputGenero);

    esMaestro(inputEsMaestro);
    
    ValidaNomApPatApMat(inputNombre,inputApellidoPat,inputApellidoMat);

    console.log(inputFechaDeNac);

});

function validateConfirmPass(inputPassword,inputConfirmpass){
    if(inputPassword===inputConfirmpass){
        console.log("confirmPass valid");
        console.log(inputPassword,inputConfirmpass);
        return true;
    }
    else{
        console.log("confirmPass not");
        console.log(inputPassword,inputConfirmpass);
        return false;
    }
}

function validatePassword(password){
    if(passRegex.test(password)){
        console.log("Pass valid");
        console.log(password);

        return true;
    }
    else{
        console.log("Pass not");
        console.log(password);

        return false;
    }
}

function validaCorreo(inputEmail){
    console.log("Email: ");
    console.log(inputEmail);
};

function validaGenero(inputGenero){
    for (var radio of inputGenero){
        if (radio.checked) {  
            console.log("Genero: ");  
            console.log(radio.value);
        }
    }
    // 
    // console.log(inputGenero);
};

function esMaestro(inputEsMaestro){
    console.log("Es maestro?: ")
    console.log(inputEsMaestro);
}

function ValidaNomApPatApMat(inputNombre,inputApellidoPat,inputApellidoMat){
    if(nameRegex.test(inputNombre) && nameRegex.test(inputApellidoPat)){
        if(apellidoMat!=null){

           if(nameRegex.test(inputApellidoMat)){
              console.log(inputNombre);
              console.log(inputApellidoPat);
              console.log(inputApellidoMat);
            return true;
           } 
        }
        else{

            console.log(inputNombre);
            console.log(inputApellidoPat);
            console.log(inputApellidoMat);
            return true;
        }
    }
    else{
        console.log("Nombre y apellido invalidos");
        return false;
    }
};