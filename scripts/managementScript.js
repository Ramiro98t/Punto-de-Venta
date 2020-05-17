// Maneja las vistas a mostrar en la pagina actual
function evalView(thisView) {
  // Modifica el subtitulo conforme la vista solicitada
  $("#module").html("Modulo " + thisView);
  // Ventana ventas
  if (thisView == "Ventas") {
    $("#Devolucion").addClass("is-hidden");
    $("#" + thisView).removeClass("is-hidden");
    $(".cantidad-carrito").removeClass("is-hidden");
    $("#clientSession").removeClass("is-hidden");
    $(".clientField").removeClass("is-hidden");
  }
  // Ventana devolucion
  if (thisView == "Devolucion") {
    $(".clientField").addClass("is-hidden");
    $("#Ventas").addClass("is-hidden");
    $("#carrito").addClass("is-hidden");
    $(".cantidad-carrito").addClass("is-hidden");
    $("#" + thisView).removeClass("is-hidden");
    $("#clientSession").addClass("is-hidden");
  }
  /** ALMACEN */
  if (thisView == "Movimientos") {
    $("#titulo").html("INGRESE EL CODIGO DE VENTA");
    $("#adjust").addClass("is-hidden");
    $("#mov").removeClass("is-hidden");
    $("#busqueda").addClass("is-hidden");
  }
  if (thisView == "Ajustes") {
    $("#tipo").prop("selectedIndex", 0); // Reinicia Select
    $("#motivo").prop("selectedIndex", 0); // Reinicia Select
    $("#titulo").html("INGRESE EL CODIGO DE MOVIMIENTO");
    $("#adjust").removeClass("is-hidden");
    $("#mov").addClass("is-hidden");
    $("#busqueda").removeClass("is-hidden");
  }
}

/** FUNCIONES DE CAJA **/
// return 0 = no hay cambio
// return < 0 = hay cambio
// return > 0 = no ajusta
function charge(efectivo, tarjeta, total) {
  if (efectivo && tarjeta) {
    total -= tarjeta;
    total -= efectivo;
  } else if (efectivo) {
    total -= efectivo;
  } else if (tarjeta) {
    total -= tarjeta;
  }
  return total;
}
/** FIN FUNCIONES DE CAJA **/

$(document).ready(function () {
  // Boton ver productos carrito
  $(".cantidad-carrito").on("click", function () {
    $("#carrito").load(" #carrito > *", function () {
      $.getScript("../scripts/dbOperations.js");
    });
    // $("#carrito").load(" #carrito > *");    // Actualiza la lista de productos
    $("#carrito").toggleClass("is-hidden"); // Activa la vista de la lista
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
          $.getScript("../scripts/designOp.js");
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

  /** CAJA */
  $("#cantidadTotal").html("TOTAL $" + $("#subTotalIva").val());  // Inicializa el total
  $("#total").val($("#subTotalIva").val());

  // Descuento
  $("#desc").on("click", function () {
    if (!$("#codesc").val()) {
      $(".mensaje").html("No se ha ingresado Codigo");
      setTimeout(() => {
        $(".mensaje").html("");
      }, 1500);
    } else {
      let codigo = $("#codesc").val();
      $.ajax({
        type: "post",
        url: "../back/Ventas/descuento.php",
        data: { codigo: codigo },
        dataType: "text",
        success: function (r) {
          if (r == 0) {
            $(".mensaje").html("Lo sentimos, Su codigo no aplica");
            setTimeout(() => {
              $(".mensaje").html("");
            }, 2000);
          } else {
            // Modifica Descuento
            $("#aplicaDesc").html("Descuento: " + r[2] + r[3] + "%");
            $("#descuento").val(r);       // Porcentaje descuento

            let new_total = $("#subtotal").val(); // Subtotal
            new_total *= r;               // Total = Subtotal * Descuento
            new_total += new_total * $("#iva").val(); // Total += Total * IVA
            
            // Redondeo new total
            new_total = Math.round(new_total * 100) / 100

            // Asigna nuevo total
            $("#total").val(new_total);
            $("#cantidadTotal").html("TOTAL $" + new_total);
          }
        },
      });
    }
  });

  // Metodo de pago
  let op;
  $("select").on("change", function () {
    $(".enviar").removeClass("is-hidden");
    $(".cancelar").removeClass("is-hidden");
    // Activa botones pago
    $("#cash, #card, #both").addClass("is-hidden");
    op = $(this).val();

    switch (
      op // Valida metodo de pago
    ) {
      case "1": // Efectivo
        $("#cash").removeClass("is-hidden");
        break;

      case "2": // Tarjeta
        $("#card").removeClass("is-hidden");
        break;

      case "3": // Ambos
        $("#card").removeClass("is-hidden");
        $("#both").removeClass("is-hidden");
        break;
    }
  });

  function ejecutaPago(metodo) {
    $.ajax({
      type: "post",
      url: "../back/validaCompra.php",
      data: { pago: metodo },
      dataType: "text",
      success: function () {
        $("#imprimir").removeClass("is-hidden");
      },
    });
  }

  $(".enviar").on("click", function () {
    let total = $("#total").val();
    let cash = $("#cashInput").val();
    // let card = $("#cardInput").val();    // No se va a tomar una cantidad de la tarjeta
    let card = 1;
    // Validar info tarjetas
    let cashBoth = $("#cashBoth").val();
    let cardBoth = $("#cardBoth").val();
    let absMoney = 0;

    // Valida si algun input de pago ha sido recibido
    if (cash || card || cashBoth || cardBoth) {
      switch (
        op // Valida el metodo de pago seleccionado
      ) {
        case "1": // Efectivo
          absMoney = charge(cash, 0, total);
          break;

        case "2": // Tarjeta
          absMoney = charge(0, total, total);
          ejecutaPago(op);
          break;

        case "3": // Ambos
          absMoney = charge(cashBoth, cardBoth, total);
          break;
      }
      absMoney = absMoney.toFixed(2); // Muestra dos decimales
      if (absMoney < 0 || absMoney == 0) {
        // Valida si hay cambio o si se pago(sin cambio)
        // Hay cambio
        if (absMoney < 0) {
          alert(`Le sobran: $${absMoney}, Gracias por su compra!`);
        }
        // No hay cambio
        else {
          alert("Gracias por su compra!");
        }
        ejecutaPago(op);
      }
      // No se ajusta
      if (absMoney > 0) {
        alert("Es insuficiente");
      }
    } else {
      $(".mensaje").html("Favor de revisar bien la informacion");
      setTimeout(() => {
        $(".mensaje").html("");
      }, 2000);
    }
  });

  $(".cancelar").on("click", function () {
    alert("cancelaar");
  });

  $("#imprimir").on("click", function () {
    window.open("../back/ticket.php?type=0", "_blank");
    location.reload();
    // onClick="window.location.reload();" href="../back/ticket.php?type=0" target="_blank"
  });
  /** DEVOLUCION */

  function ajaxSearchDev(data) {
    $.ajax({
      url: "../back/Ventas/pedidos.php",
      type: "POST",
      data: { search: data },
      dataType: "text",
      success: function (res) {
        if (res == 0) {
          $(".resultDev").html(
            '<div class="column"><p class="subtitle is-1">Sin Resultados</p></div>'
          );

          // Recarga el contenedor y agrega el script
        } else {
          // Al contenedor se le coloca el resultado de la busqueda
          $(".resultDev").html(res);
          // script devoluciones
          $.getScript("../scripts/designScript.js");
        }
      },
    });
  }

  $("#searchDev").on("keyup", function () {
    data = $(this).val(); // Almacena el texto
    if (data) {
      // Si contiene info realiza la busqueda
      ajaxSearchDev(data);
    } else {
      $(".resultDev").html("");
    }
  });
});
