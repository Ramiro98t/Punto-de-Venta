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
}

/** FUNCIONES DE CAJA **/
// return 0 = no hay cambio
// return < 0 = hay cambio
// return > 0 = no ajusta
function charge(efectivo, tarjeta, total){
  if (efectivo && tarjeta) {
    total -= tarjeta;
    total -= efectivo;
  }
  else if (efectivo) {
    total -= efectivo;
  } 
  else if (tarjeta) {
    total -= tarjeta;
  }
  return total 
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

  $("#logout").on("click", function () {
    if (confirm("¿Seguro que desea salir?")) {
      location.href = "../back/desconecta.php";
    }
  });

  /** CAJA */

  let op;
  $("select").on("change", function () {
    $(".enviar").removeClass("is-hidden");
    $(".cancelar").removeClass("is-hidden");
    // Activa botones pago
    $("#cash, #card, #both").addClass("is-hidden");
    op = $(this).val();

    switch (op) {
      case "1":
        $("#cash").removeClass("is-hidden");
        break;

      case "2":
        $("#card").removeClass("is-hidden");
        break;

      case "3":
        $("#both").removeClass("is-hidden");
        break;
    }
  });

  $(".enviar").on("click", function () {
    let total = $("#total").val();
    let cash = $("#cashInput").val();
    // let card = $("#cardInput").val();
    let card = 1; // Suponiendo que almacena algo
    // Validar info tarjetas
    let cashBoth = $("#cashBoth").val();
    let cardBoth = $("#cardBoth").val();
    let absMoney = 0;

    // inside if > || card
    if (cash || cashBoth || cardBoth) {
      switch (op) {
        case "1":
          absMoney = charge(cash, 0, total)
          break;
  
        case "2":
          // charge(cash, card, total)
          absMoney = charge(0, total, total)
          break;
  
        case "3":
          absMoney = charge(cashBoth, cardBoth, total)
          break;
      }
      absMoney = absMoney.toFixed(2);   // Muestra dos decimales
      // Hay cambio
      if (absMoney < 0) {
        alert(`Le sobran: $${absMoney}, Gracias por su compra!`)
      }
      // No hay cambio
      if (absMoney == 0) {
        alert("Gracias por su compra!");
      }
      // No se ajusta
      if (absMoney > 0) {
        alert("Es insuficiente");
      }
    }
    else {
      $(".mensaje").html("Favor de revisar bien la informacion");
      setTimeout(() => {
        $(".mensaje").html("");
      }, 2000);
    }

  });
  
  $(".cancelar").on("click", function () {
    alert("cancelaar");
  });

});
