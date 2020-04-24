// ** FUNCIONES LISTAS
$(document).ready(function () {
  // Almacena el tipo de vista: producto, empleado o proveedor
  let route = $("#type").val();
  switch (route) {
    case "Empleados":
      $("#search").attr("placeholder", "Nombre, Ciudad, Cargo");
      break;
    case "Productos":
      $("#search").attr("placeholder", "ID, Descripción, Departamento");
      break;
    case "Clientes":
    case "Proveedores":
      $("#search").attr("placeholder", "Nombre, Correo, Telefono");
      break;
  }

  /* BUSQUEDA */
  let data = ""; // Almacena el valor del input de busqueda
  function ajaxSearch(data, flag) {
    $.ajax({
      url: "../back/" + route + "/list" + route + ".php",
      type: "POST",
      data: { search: data, flag: flag },
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
  }

  // Al inicio siempre muestra los productos
  if (!data) {
    ajaxSearch(data, false);
  }

  // Al teclear en el input se ejecuta la busqueda
  $("#search").on("keyup", function () {
    data = $(this).val(); // Almacena el texto
    if (data) {
      // Si contiene info realiza la busqueda
      ajaxSearch(data, true);
    } else {
      // Si no contiene nada muestra todos los productos
      ajaxSearch(data, false);
    }
  });
});

// ** FIN FUNCIONES LISTA DE PRODUCTOS
