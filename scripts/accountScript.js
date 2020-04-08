$(document).ready(function () {
  /**
   * Metodos Menu hamburguesa
   */
  $(".navbar-burger").click(function () {
    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
  });

  /**
   * Metodos para modal
   */
  // Cerrar Modal
  $(".modal-background, .exit-modal").on("click", function () {
    $(".modal").removeClass("is-active");
  });

  // Abrir modal
  $(".about-us-btn").on("click", function () {
    $(".modal").addClass("is-active");
  });

  /**
   * Metodo para validar empleado
   */
  $("#btnLogin").on("click", function () {
    $(this).addClass("is-loading"); // Boton cargando
    // Recibe valores de inputs
    let email = $("#email").val();
    let position = $("#position").val();

    $.ajax({
      type: "post",
      url: "./back/Cuentas/evalWorker.php",
      data: { correo: email, cargo: position },
      success: function (response) {
        // Datos correctos
        if (response != 0) {
          $(".help").html("Bienvenido " + response);
          // Restablece campos
          setTimeout(() => {
            $("#email").val("");
            $("#position").val("");
            $(".help").html("");
            $("#btnLogin").removeClass("is-loading");
            location.href = "./front/operations.php";
          }, 1200);
        } else {
          $("#btnLogin").removeClass("is-loading");
          $(".help").html("Alguno de los datos es incorrecto");
          setTimeout(() => {
            $(".help").html("");
          }, 2000);
        }
        // Datos incorrectos
      },
    });
  });
});
