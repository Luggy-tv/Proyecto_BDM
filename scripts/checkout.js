function eliminarDecarrito(identificador) {
  var carritoCookie = getCookie("carrito");

  if (carritoCookie) {
    var carritoArray = JSON.parse(carritoCookie);

    var index = carritoArray.findIndex(function (curso) {
      return curso.identificador == parseInt(identificador);
    });
    if (index !== -1) {
      carritoArray.splice(index, 1);
      document.cookie = "carrito=" + JSON.stringify(carritoArray) + "; path=/;";
      if (carritoArray.length === 0) {
        document.cookie =
          "carrito=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      }
      location.reload();
    }
  }
}

function getCookie(name) {
  var cookies = document.cookie.split(";");

  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i].trim();
    if (cookie.startsWith(name + "=")) {
      return cookie.substring(name.length + 1);
    }
  }

  return null;
}

// document.addEventListener("DOMContentLoaded", function () {
//   console.log("0724");
// });
