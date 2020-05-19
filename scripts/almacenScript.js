$(document).ready(function () {
  /** Almacenista */
  //   Titulos y Forms
  $("#motivo").on("change", function () {
    let motivo = $(this).val();
    switch (motivo) {
      case "1": // Entrada - Devolucion
        $("#titulo").html("INGRESE EL ID DE DEVOLUCION");
        $("#busqueda").removeClass("is-hidden");
        $("#compra").addClass("is-hidden");
        break;
      case "2": // Entrada - Compra
        $("#titulo").html("COMPLETAR EL FORMULARIO");
        $("#busqueda").addClass("is-hidden");
        $("#compra").removeClass("is-hidden");
        break;
      case "3": // Salida - Venta
        $("#titulo").html("INGRESE EL ID DE VENTA");
        $("#busqueda").removeClass("is-hidden");
        $("#compra").addClass("is-hidden");
        break;
      default:
        break;
    }
  });

  // Busqueda de Devoluciones
  $("#enviar").on("click", function () {
    let search = $("#searchInput").val();
    let url;
    if (motivo == 1) {
      url = "../back/Devoluciones/movimientos.php";
    } else {
      url = "../back/Ventas/movimientos.php";
    }
    $.ajax({
      type: "POST",
      url: url,
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
          $("#info-modal").html(response);
          $.getScript("../scripts/designScript.js");
        }
      },
    });
  });
});
