var EditnameRegex = /^[A-Za-z0-9\s+#$]+$/;
var EditdescRegex = /^[\w\s+#&%$,.;]*$/;
var EditprecioRegex = /^\d+(\.\d+)?$/;

let invalidMsg = [];
let successMsg = [];

let errorMsg = document.getElementById("error");
let hurrayMsg = document.getElementById("success");

let cursoform = document.getElementById("form-editcursoinfo");

cursoform.addEventListener("submit", function (e) {

  successMsg = "";
  invalidMsg = "";
  invalidMsg += "Hay campos llenados de forma incorrecta:";

  e.preventDefault();

  if (validateInputsCurso()) {
    var formData = new FormData(document.getElementById("form-editcursoinfo"));
    //AJAX
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "scripts/cursoEdit.php", true);

    xhr.onload = function () {
      if (xhr.status === 200) {
        console.log(xhr.responseText);

        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          disableform(cursoform);
          showSuccesMesage(response.message);
        } else {
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

function validateInputsCurso() {
  let flag = true;

  let nombreCurso = document.getElementById("editNombreCurso").value;
  let descCurso = document.getElementById("editDescCurso").value;
  let precioCurso = document.getElementById("editPrecioCurso").value;

  if (!EditnameRegex.test(nombreCurso)) {
    flag = false;
    invalidMsg +=
      "- El nombre del curso contiene caracteres especiales no aplicables favor de volverlo a ingresar";
    // console.log(nombreCurso);
  }
  if (!EditdescRegex.test(descCurso)) {
    flag = false;
    invalidMsg +=
      "- La descripcion del curso contiene caracteres especiales no aplicables favor de volverlo a ingresar";
    // console.log(descCurso);
  }

  if (!EditprecioRegex.test(precioCurso)) {
    flag = false;
    invalidMsg +=
      "- Favor de poner el precio del curso en formato decimal, ejemplo '300.20'";
    // console.log(precioCurso);
  }

  return flag;
}

function showSuccesMesage(message) {
  errorMsg.innerHTML = "";
  hurrayMsg.innerHTML = "";
  hurrayMsg.innerHTML =
    '<div class="container bg-opacity-100 bg-info rounded shadow mt-5 p-md-2"> <div class="col-12 text-md-center my-2"> <h4 class="fw-bold" id="success-msg">' +
    message +
    "</h4> </div> </div>";
}

function showErrorMessage(message) {
  hurrayMsg.innerHTML = "";
  errorMsg.innerHTML = "";
  errorMsg.innerHTML =
    '<div class="container bg-opacity-100 bg-danger rounded shadow mt-5 p-md-2"> <div class="col-12 text-md-center my-2"> <h4 class="fw-bold" id="error-msg">' +
    message +
    "</h4> </div> </div>";
}

function showErrorMessageModulo(message, indice) {
  let errorMsg = document.getElementById("error-" + indice);
  errorMsg.innerHTML = "";
  errorMsg.innerHTML =
    '<div class="container bg-opacity-100 bg-danger rounded shadow mt-5 p-md-2"> <div class="col-12 text-md-center my-2"> <h4 class="fw-bold" id="error-msg">' +
    message +
    "</h4> </div> </div>";
}

function showSuccesMesageModulo(message, indice) {
  let hurrayMsg = document.getElementById("success-" + indice);
  hurrayMsg.innerHTML = "";
  hurrayMsg.innerHTML =
    '<div class="container bg-opacity-100 bg-info rounded shadow mt-5 p-md-2"> <div class="col-12 text-md-center my-2"> <h4 class="fw-bold" id="success-msg">' +
    message +
    "</h4> </div> </div>";
}

function disableform(form) {
  const campos = form.elements;
  for (let i = 0; i < campos.length; i++) {
    campos[i].disabled = true;
  }
}

function enviarFormulario(event, indice) {
  let errorMsg = document.getElementById("error-" + indice);
  errorMsg.innerHTML = "";

  let hurrayMsg = document.getElementById("success-" + indice);
  hurrayMsg.innerHTML = "";

  successMsg = "";
  invalidMsg = "";
  invalidMsg += "Hay campos llenados de forma incorrecta:\n";

  event.preventDefault();

  var nombreModulo = document.getElementById("editNombreModulo" + indice).value;
  var descripcionModulo = document.getElementById(
    "editDescripcionModulo" + indice
  ).value;
  var precioModulo = document.getElementById("editPrecioModulo" + indice).value;
  var descripcionAdjModulo = document.getElementById(
    "editAdjModuloDescripcion" + indice
  ).value;

  if (
    validateInputsModulo(
      nombreModulo,
      descripcionModulo,
      precioModulo,
      descripcionAdjModulo
    )
  ) {

    var formData = new FormData();

    formData.append("nombreModulo", nombreModulo);
    formData.append("descripcionModulo", descripcionModulo);
    formData.append("precioModulo", precioModulo);
    formData.append("id_Modulo",indice);

    var videoModulo = document.getElementById("editVideoModulo" + indice).files[0];
    
    var adjModulo = document.getElementById("editAdjModulo" + indice).files[0];

    formData.append("videoModulo", videoModulo);
    formData.append("adjuntoModulo", adjModulo);

    formData.append("descripcionAdjModulo", descripcionAdjModulo);

    //AJAX

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "scripts/cursoModuloEdit.php", true);
    xhr.onload = function () {
      if (xhr.status === 200) {

        // console.log(xhr.responseText);

        var response = JSON.parse(xhr.responseText);

        if (response.success) {

          document.getElementById("editNombreModulo" + indice).disabled = true;
          document.getElementById("editDescripcionModulo" + indice).disabled = true;
          document.getElementById("editPrecioModulo" + indice).disabled = true;
          document.getElementById("editAdjModuloDescripcion" + indice).disabled = true;
          document.getElementById("editVideoModulo" + indice).disabled = true;
          document.getElementById("editAdjModulo" + indice).disabled = true;

          showSuccesMesageModulo(response.message, indice);

        } else {
          invalidMsg = "";
          showErrorMessageModulo(response.message, indice);
        }
      }
      
    };

    xhr.send(formData);

    
  } else {
    showErrorMessageModulo(invalidMsg, indice);
  }
}

function validateInputsModulo(
  nombreModulo,
  descripcionModulo,
  precioModulo,
  adjModDescModulo
) {
  let flag = true;

  if (nombreModulo == "" || descripcionModulo == "" || precioModulo == "") {
    flag = false;
    invalidMsg +=
      "\nFavor de llenar los campos de nombre, descripcion y precio\n";
  } else {
    if (!EditnameRegex.test(nombreModulo)) {
      flag = false;
      invalidMsg +=
        "\n, El nombre del modulo contiene caracteres especiales no aplicables favor de volverlo a ingresar\n";
      // console.log(nombreModulo);
    }

    if (!EditdescRegex.test(descripcionModulo)) {
      flag = false;
      invalidMsg +=
        "\n, La descripcion del modulo contiene caracteres especiales no aplicables favor de volverlo a ingresar\n";
      // console.log(descripcionModulo);
    }

    if (!EditprecioRegex.test(precioModulo)) {
      flag = false;
      invalidMsg +=
        "\n, Favor de poner el precio del modulo en formato decimal, ejemplo '300.20' \n";
      // console.log(precioModulo);
    }
    if (!adjModDescModulo == "") {
      if (!EditdescRegex.test(adjModDescModulo)) {
        flag = false;
        invalidMsg +=
          "\n, La descripcion del adjunto del modulo contiene caracteres especiales no aplicables favor de volverlo a ingresar \n";
        // console.log(adjModDescModulo);
      }
    }
  }

  return flag;
}

function deslistarCurso(event,indice){

  console.log("Corre esto linea 253");

  event.preventDefault();


  var formData = new FormData();

  formData.append("id_curso", indice);

  var xhr = new XMLHttpRequest();
  
  xhr.open("POST", "scripts/cursoDelist.php", true);
  xhr.onload = function () {
    if (xhr.status === 200) {

      console.log(xhr.responseText);

      var response = JSON.parse(xhr.responseText);

      if (response.success) {
        showSuccesMesage(response.message);
        document.getElementById("delist-btn").disabled = true;
        
      } else {
        invalidMsg = "";
        showErrorMessage(response.message);
      }
    }
    
  };

  xhr.send(formData);




}

document.addEventListener("DOMContentLoaded", function () {
  console.log("Cargado 2:04");
  // disableform(cursoform);
  // actualizarModulos(2);
});
