$(document).ready(function () {
  /** Almacenista */
  $("#motivo").on("change", function () {
    let motivo = $(this).val();

    switch (motivo) {
      case "1": // Entrada - Devolucion
        $("#titulo").html("INGRESE EL ID DE DEVOLUCION");
        $("#busqueda").removeClass("is-hidden");
        break;
        case "2": // Entrada - Compra
        $("#titulo").html("COMPLETAR EL FORMULARIO");
        $("#compra").removeClass("is-hidden");
        break;
        case "3": // Salida - Venta
        $("#titulo").html("INGRESE EL ID DE VENTA");
        $("#busqueda").removeClass("is-hidden");
        break;
      default:
        break;
    }
  });
  // Busqueda de Devoluciones
  $("#enviar").on("click", function () {
    let search = $("#searchInput").val();
    let url;
    if(motivo == 1) {
      url = "../back/Devoluciones/movimientos.php"
    }
    else {
      url = "../back/Ventas/movimientos.php"
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

  /** Fin Devoluciones */

  // Registro Devolucion
  $("#regDev").on("click", function () {
    let flag = false; // Bandera para validar al menos un checbox seleccionado
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
      }
      $("#regDev").addClass("is-loading");
      setTimeout(() => {
        $("#regDev").removeClass("is-loading");
        alert("Realizado con exito");
        window.open("../back/ticket.php?type=1", "_blank");
        location.reload();
      }, 1200);
      // Terminar devolucion, generar ticket
    }
    if (!flag) {
      // No existen productos seleccionados
      alert("Por favor Revise los campos");
    }
  });
});
