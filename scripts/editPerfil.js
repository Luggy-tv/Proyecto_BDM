var nameRegex = /^[a-zA-Z\s]+$/;
var passRegex = new RegExp(
  "^((?=.*[A-Z])(?=.*[0-9])(?=.*[-¡!¿?:;@#_$%^&,.{}=+*[])(?=.{8,}))"
);

let formeditPerfil = document.getElementById("form-editPerfil");

formeditPerfil.addEventListener("submit", (e) => {
  invalidMsg =
    "Hay campos llenados de forma incorrecta, favor de ver el mensaje:\n";
  let flag = true;

  let inputNombre = document.getElementById("NuevoNombre").value;
  let inputApellidoPat = document.getElementById("nuevoApellidoPat").value;
  let inputApellidoMat = document.getElementById("nuevoApellidoMat").value;
  let inputPassword = document.getElementById("password").value;
  let inputConfirmpass = document.getElementById("confirmPass").value;

  if (flag) {
    flag = validatePassword(inputPassword);
  }

  if (flag) {
    flag = validateConfirmPass(inputPassword, inputConfirmpass);
  }

  if (flag) {
    flag = ValidaNomApPatApMat(inputNombre, inputApellidoPat, inputApellidoMat);
  }

  if (!flag) {
    e.preventDefault();
    alert(invalidMsg);
  }
});

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
