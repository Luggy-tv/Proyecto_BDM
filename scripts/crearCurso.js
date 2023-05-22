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

  if (validateInputsCurso()) {
    var formData = new FormData(document.getElementById("form-cursoinfo"));
    //AJAX
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "scripts/cursoAdd.php", true);

    xhr.onload = function () {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          disableform(cursoform);
          showSuccesMesage(response.message);
          actualizarModulos(document.getElementById("numModulos").value);
          //console.log(xhr.responseText);
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

function disableform(form) {
  const campos = form.elements;
  for (let i = 0; i < campos.length; i++) {
    campos[i].disabled = true;
  }
}

function actualizarModulos(cantModulos) {
  document.getElementById("formularioRepetido").innerHTML = "";
  for (var i = 0; i < cantModulos; i++) {
    var formularioRepetido = document.createElement("div");
    formularioRepetido.className = "row my-3 gx-3 mx-5";
    formularioRepetido.innerHTML = `

      <hr class="mt-3 mb-1 px-5">
      <h4 class="mb-3">Agregar módulo ${i}</h4>
      <form action="" method="post">
      <div class="col-5 mb-4">
        <label for="nombreModulo${i}" class="form-label">Nombre del módulo</label>
        <input minlength="1" maxlength="50" id="nombreModulo${i}" type="text" class="form-control" name="nombreModulo" placeholder="Titulo" required>
      </div>
      <div class="col-7 mb-4">
        <label for="descModulo${i}" class="form-label">Descripción del módulo</label>
        <input minlength="1" maxlength="100" id="descModulo${i}" type="text" class="form-control" name="descModulo" placeholder="Descripcion de Modulo" required>
      </div>
      <div class="col-6 mb-4">
        <label for="videoModulo${i}" class="form-label">Video</label>
        <input type="file" class="form-control" name="videoModulo" id="videoModulo${i}" accept=".mp4">
      </div>
      <div class="col-6 mb-4">
        <label for="precioModulo${i}" class="form-label">Precio Módulo</label>
        <input id="precioModulo${i}" name="precioModulo" type="number" class="form-control" placeholder="$$$.$$$" required>
      </div>
      <div class="col-5 mb-4">
        <label for="adjModulo${i}" class="form-label">Archivo adjunto del módulo (Opcional)</label>
        <input type="file" class="form-control" name="adjModulo" id="adjModulo${i}" accept=".pdf, .docx">
      </div>
      <div class="col-7 mb-4">
        <label for="adjModuloDesc${i}" class="form-label mb-2">Descripción del archivo adjunto (Opcional)</label>
        <input minlength="1" maxlength="100" id="adjModuloDesc${i}" type="text" class="form-control" name="adjModuloDesc" placeholder="Archivo adjunto">
      </div>
      <div class="row my-3 gx-3 mx-5">
        <div class="col-10">
          <button type="submit" name="submit" class="btn btn-primary btn-lg" onclick="addModulo(${i})" id="submitMod-btn${i}">Guardar Módulo</button>
        </div>
      </div>
    `;
    document
      .getElementById("formularioRepetido")
      .appendChild(formularioRepetido);
  }
}

function addModulo(indice) {
  successMsg = "";
  invalidMsg = "";
  invalidMsg += "Hay campos llenados de forma incorrecta:\n";

  var nombreModulo = document.getElementById("nombreModulo" + indice).value;
  var descripcionModulo = document.getElementById("descModulo" + indice).value;
  var precioModulo = document.getElementById("precioModulo" + indice).value;
  var adjModDescModulo = document.getElementById(
    "adjModuloDesc" + indice
  ).value;
  var nombreCurso = document.getElementById("nombreCurso").value;

  if (
    validateInputsModulo(
      nombreModulo,
      descripcionModulo,
      precioModulo,
      adjModDescModulo
    )
  ) {
    var formData = new FormData();
    formData.append("nombreModulo", nombreModulo);
    formData.append("descripcionModulo", descripcionModulo);
    formData.append("precioModulo", precioModulo);
    formData.append("adjModuloDesc", adjModDescModulo);
    formData.append("nombreCurso", nombreCurso);

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "scripts/cursoModuloAdd.php", true);

    xhr.onload = function () {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          
          document.getElementById("submitMod-btn" + indice).disabled= true;
          document.getElementById("nombreModulo" + indice).disabled= true;
          document.getElementById("descModulo" + indice).disabled= true;
          document.getElementById("precioModulo" + indice).disabled= true;
          document.getElementById("adjModuloDesc" + indice).disabled= true;

          showSuccesMesage(response.message);
          // disableform(formData);
          // actualizarModulos(document.getElementById("numModulos").value);
          //console.log(xhr.responseText);
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
}

function validateInputsModulo(
  nombreModulo,
  descripcionModulo,
  precioModulo,
  adjModDescModulo
) {
  let flag = true;

  if (!nameRegex.test(nombreModulo)) {
    flag = false;
    invalidMsg +=
      "\n- El nombre del modulo contiene caracteres especiales no aplicables favor de volverlo a ingresar\n";
    // console.log(nombreCurso);
  }

  if (!nameRegex.test(descripcionModulo)) {
    flag = false;
    invalidMsg +=
      "\n- La descripcion del modulo contiene caracteres especiales no aplicables favor de volverlo a ingresar\n";
    // console.log(nombreCurso);
  }

  if (!precioRegex.test(precioModulo)) {
    flag = false;
    invalidMsg +=
      "\n- Favor de poner el precio del modulo en formato decimal, ejemplo '300.20' \n";
    // console.log(nombreCurso);
  }

  if (!nameRegex.test(adjModDescModulo)) {
    flag = false;
    invalidMsg +=
      "\n- La descripcion del adjunto del modulo contiene caracteres especiales no aplicables favor de volverlo a ingresar \n";
    // console.log(nombreCurso);
  }

  return flag;
}

document.addEventListener("DOMContentLoaded", function () {
  // console.log('El HTML se ha cargado completamente.');
  // disableform(cursoform);
});
