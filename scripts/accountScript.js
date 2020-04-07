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
    $(this).addClass("is-loading");
    let email = $("#email").val();
    let position = $("#position").val();
    alert(email + position);
    // Datos correctos
    $.ajax({
      type: "post",
      url: "../back/cuentas/evalWorker.php",
      data: { correo: email,
              cargo: position},
      success: function (response) {
        $(".help").html("Bienvenido " + response);
        // Reestblece campos 
        setTimeout(() => {
          $("#email").val("");
          $("#position").val("");
          $(".help").html("");
          $(this).removeClass("is-loading");
        }, 1000);
      },
    });

    // Datos incorrectos
  });
});
