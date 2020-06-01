/**
 * Metodo para validar si existen datos de entrada
 * @param {*} type
 */

function evalInputs(motivo) {
  // Almacena los valores del movimiento
  var producto = $('select[name="producto"]').val();
  var cantidad = $('input[name="cantidad"]').val();
  var folio = $('input[name="folio"]').val();
  if (motivo == 2) {
    // Compra
    if (!producto || !cantidad || !folio) {
      $(".mensaje").html("Revise de nuevo la informacion");
      return false;
    }
  } else if (motivo == 4) {
    // Devolucion
    var motivo = $('input[name="motivo"]').val();
    if (!producto || !cantidad || !motivo || cantidad >= 0) {
      $(".mensaje").html("Revise de nuevo la informacion");
      return false;
    } else {
      if ((-cantidad > producto[2])) {
        $(".mensaje").html("La cantidad supera la existencia");
        return false;
      }
    }
  }
  return true;
}

$(document).ready(function () {
  /** Almacenista */
  //   Titulos y Forms
  let motivo;
  $("#motivo").on("change", function () {
    motivo = $(this).val();
    switch (motivo) {
      case "1": // Entrada - Compra
        $("#titulo").html("COMPLETAR EL FORMULARIO");
        $("#form, .folio").removeClass("is-hidden");
        $("#busqueda, .motivo, .help").addClass("is-hidden");
        break;
      case "2": // Entrada - Devolucion
        $("#titulo").html("INGRESE EL ID DE DEVOLUCION");
        $("#busqueda").removeClass("is-hidden");
        $("#form, .motivo, .help, .folio").addClass("is-hidden");
        break;
      case "3": // Salida - Venta
        $("#titulo").html("INGRESE EL ID DE VENTA");
        $("#busqueda").removeClass("is-hidden");
        $("#form, .motivo, .help, .folio").addClass("is-hidden");
        break;
      case "4": // Salida - Devolucion proveedor
        $("#titulo").html("COMPLETAR EL FORMULARIO");
        $("#busqueda, .folio").addClass("is-hidden");
        $("#form, .motivo, .help").removeClass("is-hidden");
        break;
      default:
        // $("#titulo").html("Seleccione una opcion");
        break;
    }
  });

  // Busqueda de Ventas / Devoluciones
  $("#enviar").on("click", function () {
    let search = $("#searchInput").val();
    let url;
    if (motivo == 2) {
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

  // Registro de Compras / Devoluciones
  /**
   * Metodo para agregar productos al movimiento
   */
  let flag = true; // Valida que sea el mismo movimiento
  $(".agregar").on("click", function () {
    if (evalInputs(motivo)) {
      // Datos recibidos correctamente
      var form = $("#mainForm")[0];
      var data = new FormData(form);
      data.append("flag", flag);
      $.ajax({
        url: "../back/Movimientos/proveedor.php",
        type: "POST",
        data: data,
        enctype: "multipart/form-data",
        processData: false, // Important!
        contentType: false,
        cache: false,
        success: function (res) {
          $(".ls").html(res);
          $(".table").removeClass("is-hidden");
          // Reinicia Select
          $('select[name="producto"]').prop("selectedIndex", 0);
          $('input[name="cantidad"]').val(" ");
          $('input[name="motivo"]').val(" ");
          $('input[name="folio"]').addClass("is-hidden");
        },
      });
      flag = false; // Movimiento en curso
    } else {
      // Faltan datos
      setTimeout("$('.mensaje').html('')", 2000);
    }
  });

  $(".terminar").on("click", function () {
    if (!$(".table").attr("class").includes("is-hidden")) {
      $(this).addClass("is-loading");
      setTimeout(() => {
        alert("Finalizado");
        location.href = "../back/Movimientos/crearMovimiento.php";
      }, 1000);
    } else {
      $(".mensaje").html("Primero debe iniciar un ajuste");
      setTimeout(() => {
        $(".mensaje").html("");
      }, 1500);
    }
  });
});
