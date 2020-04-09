// Maneja las vistas a mostrar en la pagina actual
function evalView(thisView) {
  // Modifica el subtitulo conforme la vista solicitada
  $("#module").html("Modulo " + thisView);

  // Ventana ventas
  if (thisView == "Ventas") {
    $("#Devolucion").addClass("is-hidden");
    $("#" + thisView).removeClass("is-hidden");
    $(".cantidad-carrito").removeClass("is-hidden");
  }

  // Ventana devolucion
  if (thisView == "Devolucion") {
    $("#Ventas").addClass("is-hidden");
    $("#carrito").addClass("is-hidden");
    $(".cantidad-carrito").addClass("is-hidden");
    $("#" + thisView).removeClass("is-hidden");
  }
}

$(document).ready(function () {
  // Boton ver productos carrito
  $(".cantidad-carrito").on("click", function () {
    $("#carrito").load(" #carrito > *", function () {
      $.getScript("../scripts/dbOperations.js");
    });
    // $("#carrito").load(" #carrito > *");    // Actualiza la lista de productos
    $("#carrito").toggleClass("is-hidden"); // Activa la vista de la lista
  });

  // Valida si hay click en algun elemento del navbar
  $(".navbar-item").on("click", function () {
    // Selecciona el elemento como activo agregando 'is-active'
    $(".navbar-item").attr("class", "navbar-item");
    $(this).toggleClass("is-active");
    evalView($(this).text());
  });

  // Valida si hay click en menu hamburguesa
  $(".navbar-burger").click(function () {
    // Toggle a la clase 'is-active' en el menu del navbar y al menu hamburguesa
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  /* BUSQUEDA */
  function ajaxSearch(data, flag) {
    $.ajax({
      url: "../back/Productos/catalog.php",
      type: "POST",
      data: { search: data, flag: flag },
      dataType: "text",
      success: function (res) {
        if (res == 0) {
          $(".result").html(
            '<div class="column"><p class="subtitle is-1">Sin Resultados</p></div>'
          );

          // Recarga el contenedor y agrega el script
        } else {
          // Al contenedor se le coloca el resultado de la busqueda
          $(".result").html(res);
          $.getScript("../scripts/dbOperations.js");
        }
      },
    });
  }

  let data = ""; // Almacena los datos del input busqueda

  // Al inicio siempre muestra la lista de los productos
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

  $("#logout").on("click", function () {
    if (confirm("¿Seguro que desea salir?")) {
      location.href = "../back/desconecta.php";
    }
  });
});
