const nameRegex = /^[a-zA-Z\s+#&%$\d]*$/;
const precioRegex = /^\d+(\.\d+)?$/;
const numModulosRegex = /^\d+$/;

let invalidMsg = [];
let successMsg = [];

let returnflag = 0;
let returnflagLimit = 0;

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
          returnflagLimit = document.getElementById("numModulos").value;
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
  let errorMsg = document.getElementById("error" + indice);
  errorMsg.innerHTML = "";
  errorMsg.innerHTML =
    '<div class="container bg-opacity-100 bg-danger rounded shadow mt-5 p-md-2"> <div class="col-12 text-md-center my-2"> <h4 class="fw-bold" id="error-msg">' +
    message +
    "</h4> </div> </div>";
}

function showSuccesMesageModulo(message, indice) {
  let hurrayMsg = document.getElementById("success" + indice);
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

function actualizarModulos(cantModulos) {
  document.getElementById("formularioRepetido").innerHTML = "";
  for (var i = 0; i < cantModulos; i++) {
    var formularioRepetido = document.createElement("div");
    formularioRepetido.className = "modulo" + (i + 1);
    formularioRepetido.innerHTML = `   
    <hr class="mt-1 mb-1 px-5">
    <form action="" method="POST" id="form-moduloinfo${i}" enctype="multipart/form-data">
      <div id="error${i}">
      </div>
      <div id="success${i}">
      </div>
      <div class="row my-3 gx-3 mx-5">
        <h4 class="mt-2 mb-3">Agregar módulo ${i + 1}</h4>
        <div class="col-5 mb-4">
          <label for="nombreModulo${i}" class="form-label">Nombre del módulo</label>
          <input minlength="1" maxlength="50" id="nombreModulo${i}" type="text" class="form-control" name="nombreModulo" placeholder="Titulo" required>
        </div>
        <div class="col-7 mb-4">
          <label for="descModulo${i}" class="form-label">Descripción del módulo</label>
          <input minlength="1" maxlength="100" id="descModulo${i}" type="text" class="form-control" name="descModulo" placeholder="Descripcion de Modulo" required>
        </div>
        <div class="col-5 mb-4">
          <label for="videoModulo${i}" class="form-label">Video</label>
          <input type="file" class="form-control" name="videoModulo" id="videoModulo${i}" accept=".mp4,.mov">
        </div>
        <div class="col-7 mb-4">
          <label for="precioModulo${i}" class="form-label">Precio Módulo</label>
          <input id="precioModulo${i}" name="precioModulo" type="text" class="form-control" placeholder="$$$.$$$" required>
        </div>
        <div class="col-5 mb-4">
          <label for="adjModulo${i}" class="form-label">Archivo adjunto del módulo (Opcional)</label>
          <input type="file" class="form-control" name="adjModulo" id="adjModulo${i}" accept=".pdf, .docx">
        </div>
        <div class="col-7 mb-4">
          <label for="adjModuloDesc${i}" class="form-label mb-2">Descripción del archivo adjunto (Opcional)</label>
          <input minlength="1" maxlength="100" id="adjModuloDesc${i}" type="text" class="form-control" name="adjModuloDesc" placeholder="Archivo adjunto">
        </div>
          <div class="col">
            <button type="button" name="submit" class="btn btn-primary btn-lg" id="submitMod-btn${i}" onclick="enviarFormulario(event, ${i})">Guardar Módulo</button>
          </div>
        
      </div>
      </form>
    `;
    document
      .getElementById("formularioRepetido")
      .appendChild(formularioRepetido);

    // moduloform = document.getElementById("form-moduloinfo" + i);
  }
}

function enviarFormulario(event, indice) {

  let errorMsg = document.getElementById("error" + indice);
  errorMsg.innerHTML = "";

  let hurrayMsg = document.getElementById("success" + indice);
  hurrayMsg.innerHTML = "";

  successMsg = "";
  invalidMsg = "";
  invalidMsg += "Hay campos llenados de forma incorrecta:\n";

  event.preventDefault();

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
    //Compilamos los datos del form data para enviarlos a travez de ajax

    var formData = new FormData();

    formData.append("nombreModulo", nombreModulo);
    formData.append("descModulo", descripcionModulo);
    formData.append("precioModulo", precioModulo);

    formData.append("adjModuloDesc", adjModDescModulo);

    formData.append("nombreCurso", nombreCurso);

    var videoModulo = document.getElementById("videoModulo" + indice).files[0];

    var adjModulo = document.getElementById("adjModulo" + indice).files[0];

    formData.append("videoModulo", videoModulo);

    formData.append("adjuntoModulo", adjModulo);

    //AJAX

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "scripts/cursoModuloAdd.php", true);

  

    xhr.onload = function () {
      if (xhr.status === 200) {
        // console.log(xhr.responseText);


        console.log(xhr.responseText);

        var response = JSON.parse(xhr.responseText);

        if (response.success) {
          

          
          document.getElementById("submitMod-btn" + indice).disabled = true;
          document.getElementById("nombreModulo" + indice).disabled = true;
          document.getElementById("descModulo" + indice).disabled = true;
          document.getElementById("precioModulo" + indice).disabled = true;
          document.getElementById("adjModuloDesc" + indice).disabled = true;

          document.getElementById("adjModulo" + indice).disabled = true;
          document.getElementById("videoModulo" + indice).disabled = true;
          showSuccesMesageModulo(response.message, indice);
          actualizarReturnBtn();
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

  if (!nameRegex.test(nombreModulo)) {
    flag = false;
    invalidMsg +=
      "\n- El nombre del modulo contiene caracteres especiales no aplicables favor de volverlo a ingresar\n";
    // console.log(nombreModulo);
  }

  if (!nameRegex.test(descripcionModulo)) {
    flag = false;
    invalidMsg +=
      "\n- La descripcion del modulo contiene caracteres especiales no aplicables favor de volverlo a ingresar\n";
    // console.log(descripcionModulo);
  }

  if (!precioRegex.test(precioModulo)) {
    flag = false;
    invalidMsg +=
      "\n- Favor de poner el precio del modulo en formato decimal, ejemplo '300.20' \n";
    // console.log(precioModulo);
  }
  if (!adjModDescModulo == "") {
    if (!nameRegex.test(adjModDescModulo)) {
      flag = false;
      invalidMsg +=
        "\n- La descripcion del adjunto del modulo contiene caracteres especiales no aplicables favor de volverlo a ingresar \n";
      // console.log(adjModDescModulo);
    }
  }

  return flag;
}

function actualizarReturnBtn() {
  // console.log("Return flag: " + returnflag );
  // console.log("Limit flag: " +returnflagLimit );
  returnflag++;
  if (returnflag == returnflagLimit) {
    document.getElementById("return-btn").innerHTML = "";
    var returnBtnHTML = document.createElement("div");
    returnBtnHTML.className = "col-12 py-2";
    returnBtnHTML.innerHTML = `
    <div class="col-12 py-2">
      <a id="btn-crearCurso" class="btn btn-primary btn-lg" href="scripts/perfilRedir.php">Regresar a perfil</a>
    </div>
    `;
    document.getElementById("return-btn").appendChild(returnBtnHTML);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // console.log("El HTML  deadsas.");
  // disableform(cursoform);
  // actualizarModulos(2);
});
