const minute = 1000 * 60;
const hour = minute * 60;
const day = hour * 24;
const year = day * 365;

const d = new Date();
let years = Math.round(d.getTime() / year);

let invalidMsg = [];

var nameRegex = /^[a-zA-Z\s]+$/;
var passRegex = new RegExp(
  "^((?=.*[A-Z])(?=.*[0-9])(?=.*[-¡!¿?:;@#_$%^&,.{}=+*[])(?=.{8,}))"
);

let formSignin = document.getElementById("form-signin");

formSignin.addEventListener("submit", (e) => {
  invalidMsg =
    "Hay campos llenados de forma incorrecta, favor de ver el mensaje:\n";

  let flag = true;

  let inputEmail = document.getElementById("email").value;

  let inputGenero = document.getElementsByName("Genero");

  //let inputEsMaestro = document.getElementById("esMaestro").checked;

  let inputFechaDeNac = new Date(
    Date.parse(document.getElementById("fechaDeNac").value)
  ); //) document.getElementById("fechaDeNac");

  //yyyy-mm-dd

  let inputNombre = document.getElementById("nombre").value;
  let inputApellidoPat = document.getElementById("apellidoPat").value;
  let inputApellidoMat = document.getElementById("apellidoMat").value;

  let inputPassword = document.getElementById("password").value;
  let inputConfirmpass = document.getElementById("confirmPass").value;

  if (flag) {
    flag = validatePassword(inputPassword);
  }

  if (flag) {
    flag = validateConfirmPass(inputPassword, inputConfirmpass);
  }

  if (flag) {
    flag = validaCorreo(inputEmail);
  }

  if (flag) {
    flag = validaGenero(inputGenero);
  }

  if (flag) {
    flag = ValidaNomApPatApMat(inputNombre, inputApellidoPat, inputApellidoMat);
  }

  if (flag) {
    flag = validateFechaNac(inputFechaDeNac);
  }

  if (!flag) {
    e.preventDefault();
    alert(invalidMsg);
  }
  //else alert("Registro exitoso, redirigiendo al inicio de sesion...");
});

function validateFechaNac(inputFechaDeNac) {
  let inputyears = Math.round(inputFechaDeNac.getTime() / year);

  if (inputyears < years) {
    //console.log("Fecha valida");
    return true;
  } else {
    //console.log("Fecha no valida, favor de seleccionar una fecha anterior al año actual.");

    invalidMsg +=
      "- Fecha no valida, favor de seleccionar una fecha anterior al año actual.\n";
    return false;
  }
}

function validateConfirmPass(inputPassword, inputConfirmpass) {
  if (inputPassword === inputConfirmpass) {
    //console.log("confirmPass valid");
    //console.log(inputPassword,inputConfirmpass);
    return true;
  } else {
    //console.log("La contraseña difiere, favor de escribir lo mismo en los dos campos.");
    invalidMsg +=
      "- La contraseña difiere, favor de escribir lo mismo en los dos campos.\n";
    //console.log(inputPassword,inputConfirmpass);
    return false;
  }
}

function validatePassword(password) {
  if (passRegex.test(password)) {
    //console.log("Pass valid");
    //console.log(password);

    return true;
  } else {
    // console.log("La contraseña no es valida, esta tiene que tener minimo 8 caracteres y contar con una mayuscula (A), minuscula (a), numero (8) y caracter especial ( -¡!¿?:;@#_$%^&,.{}=+*[ )");
    invalidMsg +=
      "- La contraseña no es valida, esta tiene que tener minimo 8 caracteres y contar con una mayuscula (A), minuscula (a), numero (8) y caracter especial ( -¡!¿?:;@#_$%^&,.{}=+*[ ) \n";
    //console.log(password);

    return false;
  }
}

function validaCorreo(inputEmail) {
  //console.log("Email: ");
  //console.log(inputEmail);
  return true;
}

function validaGenero(inputGenero) {
  let oneIsChecked = false;
  for (var radio of inputGenero) {
    if (radio.checked) {
      //console.log("Genero: ");
      //console.log(radio.value);
      oneIsChecked = true;
    }
  }

  if (oneIsChecked) {
    return true;
  } else {
    invalidMsg += "- Escoge un genero";
    return false;
  }
}

function ValidaNomApPatApMat(inputNombre, inputApellidoPat, inputApellidoMat) {
  if (
    nameRegex.test(inputNombre) &&
    nameRegex.test(inputApellidoPat) &&
    nameRegex.test(inputApellidoMat)
  ) {
    //console.log(inputNombre);
    //console.log(inputApellidoPat);
    //console.log(inputApellidoMat);
    return true;
  } else {
    //console.log("Nombre o apellidos deben contener solo letras");
    invalidMsg += "- Nombre o apellidos deben contener solo letras";
    return false;
  }
}
