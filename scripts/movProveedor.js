/**
 * Metodo para validar si existen datos de entrada
 * @param {*} type
 */

function evalInputs(type) {
  // Almacena los valores del movimiento
  var producto = $('select[name="producto"]').val();
  var cantidad = $('input[name="cantidad"]').val();
  var folio = $('input[name="folio"]').val();
  if (type == 1) {
    // Compra
    if (!producto || !cantidad || !folio) {
      $(".mensaje").html("Revise de nuevo la informacion");
      return false;
    }
  } else if (type == 2) {
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
  /**
   * Metodo que evalua el tipo de movimiento a realizar
   */
  let type;
  $("#tipo").on("change", function () {
    $(".cont-mobile").removeClass("is-hidden");
    if ($(this).val() == 1) {
      // Compra
      $(".motivo, .help").addClass("is-hidden");
      $(".folio").removeClass("is-hidden");
    } else {
      // Devolucion
      $(".folio").addClass("is-hidden");
      $(".motivo, .help").removeClass("is-hidden");
    }
    type = $(this).val();
  });

  /**
   * Metodo para agregar productos al movimiento
   */
  let flag = true; // Valida que sea el mismo movimiento
  $(".agregar").on("click", function () {
    if (evalInputs(type)) {
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

  $(".enviar").on("click", function () {
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
