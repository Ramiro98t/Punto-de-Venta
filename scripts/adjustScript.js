$(document).ready(function () {
  // AJUSTE INVENTARIO
  let flag = true; // Valida que sea el mismo ajuste
  $(".agregar").on("click", function () {
    // Almacena los valores del ajuste
    let producto = $("#producto").val();
    let cant = $("#cantidad").val();
    let motivo = $("#motivo").val();

    // Valida que esten llenos
    if (producto && cant && motivo) {
      producto = producto.split(",");
      let existencia = producto[1];
      if (parseInt(cant) + parseInt(existencia) >= 0) {
        $.ajax({
          type: "post",
          url: "../back/Ajustes/addAjuste.php",
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
