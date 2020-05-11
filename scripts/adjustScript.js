$(document).ready(function () {
  // AJUSTE INVENTARIO
  $("#producto").on("change", function () {
    // Trigger Change - Select de Producto
    $("#cantidad").empty(); // Vacia las opciones de cantidad

    // Separa el id del stock, delimitados por la ","
    let result = $(this).val().split(",");

    for (let i = 1; i <= result[1]; i++) {
      // Rellena select de cantidad dependiendo el producto
      $("#cantidad").append(new Option(i, i, false, false));
    }
  });
  let flag = true; // Valida que sea el mismo juste
  $(".agregar").on("click", function () {
    // Almacena los valores del ajuste
    let id_prod = $("#producto").val();
    let cant = $("#cantidad").val();
    let motivo = $("#motivo").val();

    // Valida que esten llenos
    if (id_prod && cant && motivo) {
      $.ajax({
        type: "post",
        url: "../back/Movimientos/ajuste.php",
        data: {
          producto: id_prod,
          cantidad: cant,
          motivo: motivo,
          flag: flag,
        },
        dataType: "text",
        success: function (response) {
          $(".ls").html(response);
          $(".table").removeClass("is-hidden");
          $("#producto").prop("selectedIndex", 0); // Reinicia Select
          $("#cantidad").prop("selectedIndex", 0); // Reinicia Select
          $("#motivo").val("");
        },
      });

      flag = false; // Ajuste en curso
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
        location.href = "../back/Movimientos/movAjuste.php";
      }, 1000);
    } else {
      $(".mensaje").html("Primero debe iniciar un ajuste");
      setTimeout(() => {
        $(".mensaje").html("");
      }, 1500);
    }
  });
});
