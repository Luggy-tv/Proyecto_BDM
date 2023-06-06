function agregarAlCarrito(id, titulo, precio) {
  var objeto = {
    identificador: id,
    nombre: titulo,
    precio: precio,
  };

  var carrito = obtenerCarrito() || [];

  // Verificar si el objeto ya existe en el carrito
  var objetoExistente = carrito.find(function (item) {
    return item.identificador === id;
  });

  if (objetoExistente) {
    // Objeto ya existe en el carrito, mostrar mensaje de error o realizar alguna acción apropiada
    // console.log("El objeto ya está en el carrito.");
    let modalbody= document.getElementById("modal-body");
    modalbody.innerHTML="Este curso ya se habia agregado al carrito, no se puede volver a agregar.";
    // console.log(modalbody);
    return;
  }

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
  // vaciarCookie("carrito");
  cargarCarrito();

  // console.log("1029")
});

function vaciarCookie(nombre) {
  document.cookie =
    nombre + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
