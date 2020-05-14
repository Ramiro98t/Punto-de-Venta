$(document).ready(function () {
  // GENERALES
  /**
   * Metodos Menu hamburguesa
   */
  $(".navbar-burger").click(function () {
    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  /**
   * Metodos para modal
   */
  // Abrir Modal
  $(".modal-click").on("click", function () {
    $(".modal").addClass("is-active");
  });

  // Cerrar Modal
  $(".modal-background, .exit-modal").on("click", function () {
    $(".modal").removeClass("is-active");
  });

  // Cerrar Sesion
  $("#logout").on("click", function () {
    if (confirm("¿Seguro que desea salir?")) {
      location.href = "../back/desconecta.php";
    }
  });

  // Registro Devoluciones

  // Boton para seleccionar productos a devolucion
  $(".unit").on("click", function () {
    let id_v = $(this).parent().attr("id"); // Almacena Id venta
    $.ajax({
      type: "POST",
      url: "../back/Ventas/productos.php",
      data: { search: id_v },
      dataType: "text",
      success: function (response) {
        $(".pedidos_venta").html(response);
        $.getScript("../scripts/devScript.js");
      },
    });
    $(".modal").addClass("is-active");
  });

  // Registrar movimientos de devoluciones
  $(".regMovDev").on("click", function () {
    $(this).addClass("is-loading");
    setTimeout(() => {
      $(this).removeClass("is-loading");
      alert("Realizado con exito");
      location.href = `../back/Devoluciones/crearMovimiento.php?dev=${$(
        this
      ).attr("id")}`;
    }, 1200);
  });

  // Registrar movimientos de ventas
  $(".regMovVenta").on("click", function () {
    $(this).addClass("is-loading");
    setTimeout(() => {
      $(this).removeClass("is-loading");
      alert("Realizado con exito");
      location.href = `../back/Ventas/crearMovimiento.php?venta=${$(this).attr(
        "id"
      )}`;
    }, 1200);
  });
});
