$(document).ready(function () {
  // VENTAS
  $(".details").on("click", function () {
    let url = "";
    let type = $(this).parent().attr("id");
    switch (type) {
      case "ajuste":
        url = "../back/Ajustes/detalles.php";
        break;
      case "venta":
        url = "../back/Ventas/detalles.php";
        break;
      case "devolucion":
        url = "../back/Devoluciones/detalles.php";
        break;
      case "movimiento":
        url = "../back/Movimientos/detalles.php";
        break;

      default:
        break;
    }
    let search = $(this).attr("id");
    $.ajax({
      type: "post",
      url: url,
      data: { search: search },
      dataType: "text",
      success: function (response) {
        $(".modal-card-body").html(response);
        $(".modal").toggleClass("is-active");
      },
    });
  });
});
