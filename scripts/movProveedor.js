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
      return false;
    }
  } else if (type == 2) {
    // Devolucion
    var motivo = $('input[name="motivo"]').val();
    if (!producto || !cantidad || !motivo) {
      return false;
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
      $(".motivo").addClass("is-hidden");
      $(".folio").removeClass("is-hidden");
    } else {
      // Devolucion
      $(".folio").addClass("is-hidden");
      $(".motivo").removeClass("is-hidden");
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
      $.ajax({
        url: "../back/Movimientos/proveedor.php",
        type: "POST",
        data: { data, flag },
        enctype: "multipart/form-data",
        processData: false, // Important!
        contentType: false,
        cache: false,
        success: function (res) {},
      });
    } else {
      // Faltan datos
      $(".mensaje").html("Revise de nuevo la informacion");
      setTimeout("$('.mensaje').html('')", 2000);
    }
  });

  $(".agre").on("click", function () {
    // Valida que esten llenos
    if (producto && cant && motivo) {
      producto = producto.split(","); // Separa producto de la existencia
      let existencia = producto[1];

      if (parseInt(cant) + parseInt(existencia) >= 0) {
        $.ajax({
          type: "post",
          url: "../back/Movimientos/proveedor.php",
          data: {
            producto: producto[0],
            cantidad: cant,
            motivo: motivo,
            flag: flag,
          },
          dataType: "text",
          success: function (response) {
            $(".ls").html(response);
            $(".table").removeClass("is-hidden");
            $("#producto").prop("selectedIndex", 0); // Reinicia Select
            $("#cantidad").val(""); // Reinicia Select
            $("#motivo").val("");
          },
        });

        flag = false; // Ajuste en curso
      } else {
        $(".mensaje").html("<hr> La cantidad supera la existencia");
        setTimeout(() => {
          $(".mensaje").html("");
        }, 2000);
      }
    } else {
      $(".mensaje").html("<hr> Revise todos los campos");
      setTimeout(() => {
        $(".mensaje").html("");
      }, 2000);
    }
  });

  $(".enviar").on("click", function () {
    if (!$(".table").attr("class").includes("is-hidden")) {
      $(this).addClass("is-loading");
      setTimeout(() => {
        alert("Finalizado");
        location.href = "../back/Ajustes/crearMovimiento.php";
      }, 1000);
    } else {
      $(".mensaje").html("Primero debe iniciar un ajuste");
      setTimeout(() => {
        $(".mensaje").html("");
      }, 1500);
    }
  });
});
