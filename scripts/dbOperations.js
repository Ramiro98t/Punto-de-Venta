function updateTable(producto, cantidad, bandera) {
  $.ajax({
    url: "../back/Productos/updateCart.php", // Query MySQL
    type: "POST", // Metodo de envio de datos
    data: {
      producto: producto,
      cantidad: cantidad,
      bandera: bandera,
    },
    dataType: "text",
    success: function (res) {
      // Exito
      if (res) {
        $("#carrito").load(" #carrito > *");
        $(".cantidad-carrito").load(" .cantidad-carrito > *");
      }
    },
    error: function () {
      alert("Error al conectar al servidor"); // Inconsistencia
    },
  });
}

$(document).ready(function () {
  // Vaciar carrito
  $(".icono-basura").on("click", function () {
    updateTable(0, 0, "true");
  });

  // Eliminar Producto
  $(".quitar-producto").on("click", function () {
    var producto = $(this).parent().attr("id"); // ID de producto a modificar
    $(this).parent().parent().toggleClass("is-hidden"); // Al modificar la cantidad a 0 se elimina la fila
    updateTable(producto, 0, "");
  });

  // Modificar Cantidad Producto
  $(".modificar-producto").on("change", function () {
    var producto = $(this).parent().attr("id"); // ID de producto a modificar
    var cantidad = parseInt($(this).val()); // Cantidad de producto a modificar
    if (cantidad == 0) {
      $(this).parent().parent().toggleClass("is-hidden"); // Al modificar la cantidad a 0 se elimina la fila
    }
    updateTable(producto, cantidad, "");
  });
});
