const nameRegex = /^[a-zA-Z\s+#&%$\d]*$/;
const precioRegex = /^\d+(\.\d+)?$/;
const numModulosRegex = /^\d+$/;

let invalidMsg = [];
let successMsg = [];

let errorMsg = document.getElementById("error");
let hurrayMsg = document.getElementById("success");

let cursoform = document.getElementById("form-cursoinfo");




document.addEventListener("DOMContentLoaded", function () {
    console.log("Cargado");
    // disableform(cursoform);
    // actualizarModulos(2);
  });
  