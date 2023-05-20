const nameRegex = /^[a-zA-Z\s+#&%$\d]*$/;
let invalidMsg = [];
let successMsg = [];

let cursoform = document.getElementById("curso-info");
cursoform.addEventListener("submit", function (e) {
  e.preventDefault();
  invalidMsg = "Hay campos llenados de forma incorrecta:\n";

  let nombreCurso = getElementById("nombreCurso");

  if (nameRegex.test(nombreCurso)) {
    var formData = new FormData(document.getElementById("form-cursoinfo"));

    var xhr = new XMLHttpRequest();

    xhr.open("POST", "scripts/categoriaAgregar.php", true);

    xhr.onload = function () {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);

        if (response.success) {
          actualizarTabla(response.data);
        } else {
          mostrarError(response.message);
        }
      }
    };
    xhr.send(formData);
  
  } else {
    let errorMsg = getElementID("error");
    errorMsg.innerHTML =
      '<div class="container bg-opacity-100 bg-danger rounded shadow mt-5 p-md-2">';
    errorMsg.innerHTML += '  <div class="col-12 text-md-center my-2">';
    errorMsg.innerHTML +=
      '      <h4 class="fw-bold" id="error-msg">El nombre del curso contiene caracteres no validos.</h4>';
    errorMsg.innerHTML += "  </div>";
    errorMsg.innerHTML += "</div>";
  }
});
