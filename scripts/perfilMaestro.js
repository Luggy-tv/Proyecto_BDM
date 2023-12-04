var buttonCat = document.getElementById("categoria-btn");
var buttonDat = document.getElementById("fecha-btn");
var buttonEst = document.getElementById("estatus-btn");
var buttonAll = document.getElementById("all-btn");

buttonDat.addEventListener("click", function () {
  let fecha = document.getElementById("fecha").value;
  //   console.log(fecha);
  if (fecha.trim() !== "") {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "scripts/perfilMaestroReporteFiltro.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        console.log(response);
        actualizar_tabla(response);
      }
    };

    var params = "fecha=" + encodeURIComponent(fecha);
    xhr.send(params);
  } else {
    console.log("Fecha vacia");
  }
});

buttonCat.addEventListener("click", function () {
  let IDcategoria = document.getElementById("categoria").value;
  //   console.log(IDcategoria);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "scripts/perfilMaestroReporteFiltro.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      console.log(response);
      actualizar_tabla(response);
    }
  };

  var params = "categoria=" + encodeURIComponent(IDcategoria);
  xhr.send(params);
});

buttonEst.addEventListener("click", function () {
  let estatus = document.getElementById("estatus").value;
  //   console.log(estatus);

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "scripts/perfilMaestroReporteFiltro.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      console.log(response);
      actualizar_tabla(response);
    }
  };

  var params = "estatus=" + encodeURIComponent(estatus);
  xhr.send(params);
});

buttonAll.addEventListener("click", function () {
  let fecha = document.getElementById("fecha").value;
  let IDcategoria = document.getElementById("categoria").value;
  let estatus = document.getElementById("estatus").value;

  //   console.log(fecha);
  if (fecha.trim() !== "") {
    var formData = new FormData();

    formData.append("fecha", fecha);
    formData.append("categoria", IDcategoria);
    formData.append("estatus", estatus);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "scripts/perfilMaestroReporteFiltro.php", true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        console.log(response);
        actualizar_tabla(response);
      }
    };

    xhr.send(formData);
  } else {
    console.log("Fecha vacia");
  }
});

function actualizar_tabla(respuesta) {
  var tbody = document.getElementById("cuerpoDeTabla");
  tbody.innerHTML = ""; // Limpiar el contenido actual del tbody

  if (respuesta.length === 0) {
    // Si la respuesta está vacía, mostrar un mensaje en una fila especial
    var tr = document.createElement("tr");
    tr.classList.add("align-middle", "text-center");

    var tdMensaje = document.createElement("td");
    tdMensaje.setAttribute("colspan", "8");
    tdMensaje.textContent = "No se encontraron resultados.";

    tr.appendChild(tdMensaje);
    tbody.appendChild(tr);
  } else {
    for (var i = 0; i < respuesta.length; i++) {
      var curso = respuesta[i];

      var tr = document.createElement("tr");
      tr.classList.add("align-middle", "text-center");

      // Crear las celdas y asignarles el contenido
      var tdTitulo = document.createElement("td");
      tdTitulo.innerHTML =
        '<a class="link-primary" href="scripts/cursoRedir.php?id=' +
        curso.IndiceCurso +
        '">' +
        curso.TituloCurso +
        "</a>";

      var tdEstatus = document.createElement("td");
      tdEstatus.textContent = curso.Estatus;

      var tdCategoria = document.createElement("td");
      tdCategoria.textContent = curso.NombreDeCategoria;

      var tdReporte = document.createElement("td");
      tdReporte.innerHTML =
        '<a class="btn btn-primary w-auto" href="./reporteCursoDetalle.php?id=' +
        curso.IndiceCurso +
        '">Ir a Detalle</a>';

      var tdFechaCreacion = document.createElement("td");
      tdFechaCreacion.textContent = curso.FechaCreacion;

      var tdCantidadUsuarios = document.createElement("td");
      tdCantidadUsuarios.textContent = curso.CantidadUsuarios;

      var tdPromedioNivel = document.createElement("td");
      tdPromedioNivel.textContent = curso.PromedioNivel;

      var tdTotalVentas = document.createElement("td");
      tdTotalVentas.textContent = curso.TotalVentas;

      // Agregar las celdas a la fila
      tr.appendChild(tdTitulo);
      tr.appendChild(tdEstatus);
      tr.appendChild(tdCategoria);
      tr.appendChild(tdReporte);
      tr.appendChild(tdFechaCreacion);
      tr.appendChild(tdCantidadUsuarios);
      tr.appendChild(tdPromedioNivel);
      tr.appendChild(tdTotalVentas);

      // Agregar la fila al tbody
      tbody.appendChild(tr);
    }
  }
}
