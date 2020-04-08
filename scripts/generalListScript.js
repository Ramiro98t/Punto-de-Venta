// ** FUNCIONES LISTA DE PRODUCTOS
$(document).ready(function () {
  // Almacena el tipo de vista: producto, empleado o proveedor
  let route = $("#type").val();
  let data = ""; // Almacena el valor del input
  switch (route) {
    case "Empleados":
      $("#search").attr("placeholder", "Nombre, Ciudad, Cargo");
      break;
    case "Productos":
      $("#search").attr("placeholder", "ID, Descripción, Departamento");
      break;
    case "Proveedores":
      $("#search").attr("placeholder", "Nombre, Correo, Telefono");
      break;
  }
  // Al presionar cualquier tecla dentro del input
  $("#search").on("keyup", function () {
    data = $(this).val(); // Almacena el texto
    if (data) {
      // Si contiene info realiza la busqueda
      $.ajax({
        url: "../back/" + route + "/search" + route + ".php",
        type: "POST",
        data: { search: data },
        dataType: "text",
        success: function (res) {
          if (res == 0) {
            $(".result").html(
              '<div class="column"><p class="subtitle is-1">Sin Resultados</p></div>'
            );
          } else {
            // Al contenedor se le coloca el resultado de la busqueda
            $(".result").html(res);
          }
        },
      });
    } else {
      // Si no contiene nada muestra todos los productos
      $.ajax({
        url: "../back/" + route + "/list" + route + ".php",
        type: "POST",
        dataType: "text",
        success: function (res) {
          // Al contenedor se le coloca el resultado de la busqueda
          $(".result").html(res);
        },
      });
    }
  });
  // Al inicio siempre muestra los productos
  if (!data) {
    $.ajax({
      url: "../back/" + route + "/list" + route + ".php",
      type: "POST",
      dataType: "text",
      success: function (res) {
        // Al contenedor se le coloca el resultado de la busqueda
        $(".result").html(res);
      },
    });
  }
});

// ** FIN FUNCIONES LISTA DE PRODUCTOS
