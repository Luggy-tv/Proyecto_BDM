var nameRegex = /^[a-zA-Z\s+#&%$]*$/;

let invalidMsg = [];

//Agregar Categoria
document.getElementById("form-addcat").addEventListener("submit", function (e) {
  e.preventDefault(); // Previene la recarga de la página

  invalidMsg =
    "Hay campos llenados de forma incorrecta, favor de ver el mensaje:\n";

  let inputNombre = document.getElementById("NomCategoria").value;
  let inputDesc = document.getElementById("DescCategoria").value;

  if (validateText(inputNombre, inputDesc)) {
    
    var formData = new FormData(document.getElementById("form-addcat"));

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
    alert(invalidMsg);
  }
});

function actualizarTabla(response) {

  $("#exampleModal").modal("hide");

  var form = document.getElementById("form-addcat");
  form.reset();

  //console.log(response);

  var tabla = document.getElementById("tabla-categorias");
  tabla.innerHTML = "";

  tabla.innerHTML = generarContenidoTabla(response);
}

function validateText(nombre, desc) {
  if (nameRegex.test(nombre) && nameRegex.test(desc)) {
    return true;
  } else {
    invalidMsg +=
      "- Existen caracteres especiales no admitidos en el texto favor de verificarlo.";
    return false;
  }
}

function generarContenidoTabla(data) {
  var contenidoTabla = "";
  contenidoTabla += "<tr>";
  contenidoTabla += "<th scope='col'>#</th>";
  contenidoTabla += "<th scope='col'>Categoría</th>";
  contenidoTabla += "<th scope='col'>Descripción</th>";
  contenidoTabla += "<th scope='col'>Fecha creada</th>";
  contenidoTabla += "<th scope='col'>Eliminar</th>";
  contenidoTabla += "</tr>";

  data.forEach(function (categoria) {
    contenidoTabla += "<tr>";
    contenidoTabla += "<td scope='row' id='"+categoria.ID+"'>" + categoria.ID + "</td>";
    contenidoTabla += "<td>" + categoria.Categoria + "</td>";
    contenidoTabla += "<td>" + categoria.Descripcion + "</td>";
    contenidoTabla += "<td>" + categoria.Creada + "</td>";
    contenidoTabla +=
      "<td class='text-center'><button class='btn p-0' onclick='eliminarFila(" +
      categoria.ID +
      ")'><i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
    contenidoTabla += "</tr>";
  });
  return contenidoTabla;
}

function eliminarFila(id) {
  var xhr = new XMLHttpRequest();

  xhr.open("POST", "scripts/categoriaeliminar.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  var data = "id=" + encodeURIComponent(id);

  xhr.onload = function () {
    if (xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);

      if (response.success) {
        actualizarTabla(response.data);
      } else {
        mostrarError(response.message);
      }
    } else {
    }
  };

  xhr.send(data);
}
