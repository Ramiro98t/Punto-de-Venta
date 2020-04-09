$(document).ready(function () {
  $(".card").hover(
    function () {
      // over
      $(this).find(".card-footer").removeClass("is-hidden");
    },
    function () {
      // out
      $(this).find(".card-footer").addClass("is-hidden");
    }
  );

  // Boton para agregar producto en carrito
  $(".addBtn").on("click", function () {
    id_producto = $(this).parent().attr("id"); // Almacena el texto
    $.ajax({
      url: "../back/cart.php",
      type: "POST",
      data: {
        id_producto: id_producto,
        id_empleado: "2",
        id_cliente: "1",
      },
      dataType: "text",
      success: function (res) {
          // Recarga la pagina
          $("#carrito").load(" #carrito > *", function () {
            $.getScript("../scripts/dbOperations.js");
          });
          $(".cantidad-carrito").load(" .cantidad-carrito > *");
      },
      error: function () {
        alert("Error al conectar al servidor"); // Inconsistencia al redireccionar
      },
    });
  });
});
