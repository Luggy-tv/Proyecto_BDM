const nameRegex = /^[a-zA-Z\s+#&%$\d]*$/;
const precioRegex = /^\d+(\.\d+)?$/;
const numModulosRegex = /^\d+$/;

let invalidMsg = [];
let successMsg = [];

let errorMsg = document.getElementById("error");
let hurrayMsg = document.getElementById("success");

let cursoform = document.getElementById("form-cursoinfo");

cursoform.addEventListener("submit", function (e) {
  successMsg = "";
  invalidMsg = "";
  invalidMsg += "Hay campos llenados de forma incorrecta:\n";
  e.preventDefault();

  if (validateInputs()) {
    var formData = new FormData(document.getElementById("form-cursoinfo"));
    //AJAX
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "scripts/cursoAdd.php", true);

    xhr.onload = function () {
      if (xhr.status === 200) {
        
        console.log(xhr.responseText);

        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          showSuccesMesage(response.message);
          actualizarModulos(document.getElementById("numModulos").value);
        }else{
                invalidMsg = "";
                showErrorMessage(response.message);
              
        }
      }
    };
    xhr.send(formData);
  } else {
    showErrorMessage(invalidMsg);
  }
});

function validateInputs() {
  let flag = true;

  let nombreCurso = document.getElementById("nombreCurso").value;
  let precioCurso = document.getElementById("precioCurso").value;
  let numModulos = document.getElementById("numModulos").value;
  let descCurso = document.getElementById("descCurso").value;

  if (!nameRegex.test(nombreCurso)) {
    flag = false;
    invalidMsg +=
      "\n- El nombre del curso contiene caracteres especiales no aplicables favor de volverlo a ingresar\n";
    // console.log(nombreCurso);
  }
  if (!nameRegex.test(descCurso)) {
    flag = false;
    invalidMsg +=
      "\n- La descripcion del curso contiene caracteres especiales no aplicables favor de volverlo a ingresar\n";
    // console.log(nombreCurso);
  }
  if (!precioRegex.test(precioCurso)) {
    flag = false;
    invalidMsg +=
      "\n- Favor de poner el precio del curso en formato decimal, ejemplo '300.20'\n";
    // console.log(precioCurso);
  }
  if (!numModulosRegex.test(numModulos)) {
    flag = false;
    invalidMsg += "\n- La cantidad de modulos tiene que ser un numero entero\n";
    // console.log(numModulos);
  }

  return flag;
}

function showSuccesMesage(message) {
  hurrayMsg.innerHTML = "";
  hurrayMsg.innerHTML =
    '<div class="container bg-opacity-100 bg-info rounded shadow mt-5 p-md-2"> <div class="col-12 text-md-center my-2"> <h4 class="fw-bold" id="success-msg">' +
    message +
    "</h4> </div> </div>";
}

function showErrorMessage(message) {
  errorMsg.innerHTML = "";
  errorMsg.innerHTML =
    '<div class="container bg-opacity-100 bg-danger rounded shadow mt-5 p-md-2"> <div class="col-12 text-md-center my-2"> <h4 class="fw-bold" id="error-msg">' +
    message +
    "</h4> </div> </div>";
}

function actualizarModulos(cantModulos) {

    
}
