// ** FUNCIONES LISTAS
$(document).ready(function () {
  // Almacena el tipo de vista: producto, empleado o proveedor
  let route = $("#type").val();

  // Vistas - Modifica PlaceHolder de Busqueda
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

    case "Ventas":
    case "Devoluciones":
      $("#search").attr("placeholder", "ID, Nombre Empleado, Fecha");
      break;

    case "Movimientos":
      $("#search").attr("placeholder", "ID de Movimiento");
      // Oculta la barra de busqueda si es Movimientos
      $(".search-bar").addClass("is-hidden");
      // Vistas de Movimientos
      $("select").on("change", function () {
        // Trigger change, modifica la busqueda
        type = $(this).val(); // Obtiene el tipo de movimiento
        // Muestra la barra de busqueda
        $(".search-bar").removeClass("is-hidden");
      });
      break;
  }

  /* BUSQUEDA */
  let type = ""; // Almacena el valor del tipo para movimientos
  let data = ""; // Almacena el valor del input de busqueda

  function ajaxSearch(data, flag, type) {
    $.ajax({
      url: "../back/" + route + "/list" + route + ".php",
      type: "POST",
      data: { search: data, flag: flag, type: type },
      dataType: "text",
      success: function (res) {
        // No encuentra datos
        if (res == 0) {
          $(".result").html(
            '<div class="column"><p class="subtitle is-1">Sin Resultados</p></div>'
          );
        } else {
          // Encuentra datos
          $.getScript("../scripts/buttonScripts.js");
          // Al contenedor se le coloca el resultado de la busqueda
          $(".result").html(res);
        }
      },
    });
  }

  // Al inicio siempre muestra los registros | Mientras no sean Movimientos
  if (!data && route != "Movimientos") {
    ajaxSearch(data, false, type);
  }

  // Al teclear en el input se ejecuta la busqueda
  $("#search").on("keyup", function () {
    data = $(this).val(); // Almacena el texto
    if (data) {
      // Si contiene info realiza la busqueda
      ajaxSearch(data, true, type);
    } else {
      // Si no contiene nada muestra todos los productos
      ajaxSearch(data, false, type);
    }
  });
});

// ** FIN FUNCIONES LISTA DE PRODUCTOS
