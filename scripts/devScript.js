$(document).ready(function () {
  // Registro Devolucion
  $("#regDev").on("click", function () {
    let flag = false; // Bandera para validar al menos un checkbox seleccionado
    var fDev = false; // Bandera para validar la devolucion en caso de ser mas de un producto
    $(".productoSel").each(function () {
      // Valida que haya algun producto seleccionado
      if ($(this).prop("checked")) flag = true;
    });
    if (flag) {
      // Hay seleccionados
      $(".row").each(function () {
        // Valida que los seleccionados tengan motivo
        if (
          ($(this).find(".motivo").val() &&
            !$(this).find(".productoSel").prop("checked")) ||
          (!$(this).find(".motivo").val() &&
            $(this).find(".productoSel").prop("checked"))
        ) {
          flag = false;
        }
      });
      if (flag) {
        // Existe al menos un producto seleccionado
        $(".row").each(function () {
          let venta = $(this).parent().attr("class");
          let id = $(this).attr("id");
          let cant = $(this).find(".productoDev").val();
          let motiv = $(this).find(".motivo").val();
          if ($(this).find(".productoSel").prop("checked") && motiv) {
            // Algun producto es seleccionado
            $.ajax({
              type: "post",
              url: "../back/Devoluciones/devolucion.php",
              data: {
                producto: id,
                cantidad: cant,
                id_venta: venta,
                motivo: motiv,
                flag: fDev,
              },
              dataType: "text",
              success: function (response) {},
            });
            fDev = true;
          }
        });

        // Terminar devolucion, generar ticket
        $("#regDev").addClass("is-loading");
        setTimeout(() => {
          $("#regDev").removeClass("is-loading");
          alert("Realizado con exito");
          window.open("../back/ticket.php?type=1", "_blank");
          location.reload();
        }, 1200);
      }
    }
    if (!flag) {
      // No existen productos seleccionados
      alert("Por favor Revise los campos");
    }
  });
});
