// Valida los campos del empleado
function evalFormWorker() {
  // Variables que almacenan el valor de los input
  var nombre = $('input[name="nombre"]').val();
  var direccion = $('input[name="direccion"]').val();
  var ciudad = $('input[name="ciudad"]').val();
  var telefono = $('input[name="telefono"]').val();
  var email = $('input[name="email"]').val();
  var cargo = $('input[name="cargo"]').val();
  var salario = $('input[name="salario"]').val();
  // Verifica que todos los datos del formulario hayan sido ingresados
  if (
    !nombre.length ||
    !direccion.length ||
    !ciudad.length ||
    !telefono.length ||
    !email.length ||
    !cargo.length ||
    !salario.length
  ) {
    $(".mensaje").html("Faltan campos por llenar"); // Modifica el contenedor, inserta al html.
    setTimeout("$('.mensaje').html('')", 2000);
    return false;
  } else {
    return true;
  }
}

// Valida los campos del producto
function evalFormProduct() {
  // Variables que almacenan el valor de los input
  var descripcion = $('input[name="descripcion"]').val();
  var proveedor = $('select[name="proveedor"]').val();
  var departamento = $('input[name="departamento"]').val();
  var precio = $('input[name="precio"]').val();
  var existencia = $('input[name="existencia"]').val();
  // Verifica que todos los datos del formulario hayan sido ingresados
  if (
    !descripcion.length ||
    !proveedor ||
    !departamento.length ||
    !precio.length ||
    !existencia.length
  ) {
    $(".mensaje").html("Faltan campos por llenar"); // Modifica el contenedor, inserta al html.
    setTimeout("$('.mensaje').html('')", 2000);
    return false;
  } else {
    return true;
  }
}

// Valida los campos del proveedor
function evalFormProvider() {
  // Variables que almacenan el valor de los input
  var nombre = $('input[name="nombre"]').val();
  var correo = $('input[name="correo"]').val();
  var telefono = $('input[name="telefono"]').val();
  // Verifica que todos los datos del formulario hayan sido ingresados
  if (!nombre.length || !correo.length || !telefono.length) {
    $(".mensaje").html("Faltan campos por llenar"); // Modifica el contenedor, inserta al html.
    setTimeout("$('.mensaje').html('')", 2600);
    return false;
  } else {
    return true;
  }
}

// Valida los campos del cliente
function evalFormClient() {
  // Variables que almacenan el valor de los input
  var nombre = $('input[name="nombre"]').val();
  var direccion = $('input[name="direccion"]').val();
  var telefono = $('input[name="telefono"]').val();
  var cp = $('input[name="cp"]').val();
  var email = $('input[name="email"]').val();
  // Verifica que todos los datos del formulario hayan sido ingresados
  if (
    !nombre.length ||
    !direccion.length ||
    !telefono.length ||
    !cp.length ||
    !email.length
  ) {
    $(".mensaje").html("Faltan campos por llenar"); // Modifica el contenedor, inserta al html.
    setTimeout("$('.mensaje').html('')", 2000);
    return false;
  } else {
    return true;
  }
}

$(document).ready(function () {
  // Boton Registrar
  $(".enviar").on("click", function () {
    let bandera = false;
    let route = $(".wForm").val(); // Almacena el tipo: Empleado, Producto, Proveedor
    switch (route) {
      case "Empleados":
        if (evalFormWorker()) {
          bandera = true;
        }
        break;
      case "Productos":
        if (evalFormProduct()) {
          bandera = true;
        }
        break;
      case "Proveedores":
        if (evalFormProvider()) {
          bandera = true;
        }
        break;
      case "Clientes":
        if (evalFormClient()) {
          bandera = true;
        }
        break;
    }
    if (bandera) {
      var form = $(".mainForm")[0];
      var data = new FormData(form);
      $.ajax({
        url: "../back/" + route + "/add" + route + ".php",
        type: "POST",
        data: data,
        enctype: "multipart/form-data",
        processData: false,
        contentType: false,
        cache: false,
        success: function (res) {
          if (res == 1) {
            
            $(".mensaje").html("Realizando registro...");
            setTimeout(function () {
              $(".mensaje").html("Completado");
              location.reload();
            }, 1500);

          } else {
            $(".mensaje").html("Datos incorrectos!"); // Mensaje de error
            setTimeout("$('.mensaje').html('')", 3000);
          }
        },
      });
    }
  });

  // Boton Cancelar
  $(".cancelar").on("click", function () {
    $(".input").val("");
    location.href = "operations.html";
  });
});
