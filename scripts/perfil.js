function agregarAlCarrito(id, titulo, precio) {
  var objeto = {
    identificador: id,
    nombre: titulo,
    precio: precio,
  };

  var carrito = obtenerCarrito() || [];

  carrito.push(objeto);

  var carritoJSON = JSON.stringify(carrito);

  document.cookie = "carrito=" + carritoJSON + "; path=/";

  document.getElementById("btn-comprarCurso").disabled = true;

  cargarCarrito();
}

function obtenerCarrito() {
  var carritoJSON = obtenerCookie("carrito");
  if (carritoJSON) {
    return JSON.parse(carritoJSON);
  }
  return null;
}

function cargarCarrito() {
  var datosCarrito = obtenerCarrito();

  if (datosCarrito == null) {
    var carritoHTML = "<li> El carrito está vacío! </li>";
  } else {
    var carritoHTML = generarHTMLCarrito(datosCarrito);
  }
  var carritoContainer = document.getElementById("carritoContainer");
  carritoContainer.innerHTML = carritoHTML;
}

function generarHTMLCarrito(datosCarrito) {
  var productosHTML = datosCarrito
    .map(function (producto) {
      return "<li>" + producto.nombre + " - $" + producto.precio + "</li>";
    })
    .join("");

  return `
          ${productosHTML}
    `;
}

function obtenerCookie(nombre) {
  var nombreEQ = nombre + "=";
  var cookies = document.cookie.split(";");
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i];
    while (cookie.charAt(0) === " ") {
      cookie = cookie.substring(1, cookie.length);
    }
    if (cookie.indexOf(nombreEQ) === 0) {
      return decodeURIComponent(
        cookie.substring(nombreEQ.length, cookie.length)
      );
    }
  }
  return null;
}

document.addEventListener("DOMContentLoaded", function () {
  cargarCarrito();
});

function vaciarCookie(nombre) {
  document.cookie =
    nombre + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

var buttonCat = document.getElementById("categoria-btn");
var buttonDat = document.getElementById("fecha-btn");
var buttonEst = document.getElementById("estatus-btn");
var buttonAll = document.getElementById("all-btn");


buttonDat.addEventListener("click", function () {
  let fecha = document.getElementById("fecha").value;
  if (fecha.trim() !== "") {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "scripts/perfilKardexFiltro.php", true);
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

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "scripts/perfilKardexFiltro.php", true);
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
  xhr.open("POST", "scripts/perfilKardexFiltro.php", true);
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
    xhr.open("POST", "scripts/perfilKardexFiltro.php", true);

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


function actualizar_tabla(respuesta){
  var tbody = document.getElementById("tablaDeDatos");
  tbody.innerHTML = "";
  if (respuesta.length === 0) {
   
    var tr = document.createElement("tr");
    var tdMensaje = document.createElement("td");
    tdMensaje.setAttribute("colspan", "7");
    tdMensaje.textContent = "No se encontraron resultados.";

    tr.appendChild(tdMensaje);
    tbody.appendChild(tr);
  } else {
        for (var i = 0; i < respuesta.length; i++) {
      var curso = respuesta[i];

      var tr = document.createElement("tr");

      var tdNumero = document.createElement("td");
      tdNumero.textContent = i + 1;

      var tdCurso = document.createElement("td");
      var linkCurso = document.createElement("a");
      linkCurso.classList.add("link-primary");
      linkCurso.href = "scripts/cursoRedir.php?id=" + curso.ID_Curso;
      linkCurso.textContent = curso.Titulo_Curso;
      tdCurso.appendChild(linkCurso);

      var tdFechaInscripcion = document.createElement("td");
      tdFechaInscripcion.textContent = curso.FechaInscripcion;

      var tdNivel = document.createElement("td");
      tdNivel.textContent = curso.Nivel;

      var tdUltimoAvance = document.createElement("td");
      tdUltimoAvance.textContent = curso.FechaDeUltimoAvance;

      var tdCategoria = document.createElement("td");
      tdCategoria.textContent = curso.NombreDeCategoria;

      var tdFechaFinalizacion = document.createElement("td");
      tdFechaFinalizacion.textContent = curso.FechaFinalizacion;

      tr.appendChild(tdNumero);
      tr.appendChild(tdCurso);
      tr.appendChild(tdFechaInscripcion);
      tr.appendChild(tdNivel);
      tr.appendChild(tdUltimoAvance);
      tr.appendChild(tdCategoria);
      tr.appendChild(tdFechaFinalizacion);
      tbody.appendChild(tr);
    }
  }
}