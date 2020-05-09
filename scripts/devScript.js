$(document).ready(function () {
  /** Devoluciones */
  $("#tipo").on("change", function () {
    $("#motivo").prop("selectedIndex", 0); // Reinicia Select
    $("#busqueda").addClass("is-hidden");

    let tipo = $(this).val();
    $(".motivo").removeClass("is-hidden");
    switch (tipo) {
      case "1": // Entrada
        $("#motivo  option[value='1']").attr("disabled", false);
        $("#motivo  option[value='2']").attr("disabled", false);
        $("#motivo  option[value='3']").attr("disabled", true);
        $("#motivo  option[value='4']").attr("disabled", true);
        break;

      case "2": // Salida
        $("#motivo  option[value='1']").attr("disabled", true);
        $("#motivo  option[value='2']").attr("disabled", true);
        $("#motivo  option[value='3']").attr("disabled", false);
        $("#motivo  option[value='4']").attr("disabled", false);
        break;

      default:
        break;
    }
  });

  $("#motivo").on("change", function () {
    let motivo = $(this).val();
    switch (motivo) {
      case "1": // Entrada - Devolucion
        $("#busqueda").removeClass("is-hidden");
        break;
      case "2": // Entrada - Compra
        $("#busqueda").addClass("is-hidden");
        break;
      case "3": // Salida - Devolucion Cliente
        $("#busqueda").addClass("is-hidden");
        break;
      case "4": // Salida - Devolucion Proveedor
        $("#busqueda").addClass("is-hidden");
        break;

      default:
        break;
    }
  });

  $("#enviar").on("click", function () {
    let search = $("#searchInput").val();
    $.ajax({
      type: "POST",
      url: "../back/Ventas/productos.php",
      data: { search: search },
      dataType: "text",
      success: function (response) {
        if (response == 0) {
          // No encontro coincidencias
          $(".msg").html("No hay Coincidencias");
          setTimeout(() => {
            $(".msg").html("");
          }, 1800);
        } else {
          $(".modal").addClass("is-active");
          $(".pedidos_venta").html(response);
        }
      },
    });
  });

  /** Fin Devoluciones */

  // Boton para agregar producto en carrito
  $(".unit").on("click", function () {
    $(".modal").addClass("is-active");

    let id_v = $(this).parent().attr("id"); // Almacena Id venta
    $.ajax({
      type: "POST",
      url: "../back/Ventas/productos.php",
      data: { search: id_v },
      dataType: "text",
      success: function (response) {
        $(".pedidos_venta").html(response);
      },
    });
  });

  $(".modal-background, .exit-modal").on("click", function () {
    $(".modal").removeClass("is-active");
  });
});
