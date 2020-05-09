$(document).ready(function () {
  
  /**
   * Metodo para validar empleado
   */
  $("#btnLogin").on("click", function () {
    // Trigger Click
    $(this).addClass("is-loading"); // Boton cargando
    // Recibe valores de inputs
    let email = $("#email").val(); // Almacena correo empleado
    let position = $("#position").val(); // Almacena posicion empleado

    $.ajax({
      //
      type: "post",
      url: "./back/Cuentas/evalAccount.php",
      data: { correo: email, cargo: position, bandera: true },
      success: function (response) {
        if (response != 0) {          // Datos correctos
          $(".help").html("Bienvenido!");
          setTimeout(() => {          // Restablece campos
            $("#email").val("");
            $("#position").val("");
            $(".help").html("");
            $("#btnLogin").removeClass("is-loading");
            switch (response) {       // Administra rol de empleado
              case "1":               // Aministrador
                location.href = "./front/operations.html";
                break;
              case "2":               // Vendedor
                location.href = "./front/mainPage.php";
                break;
              case "3":               // Almacenista
                location.href = "./front/mainPageWH.php";
                break;
              default:                // Default
                location.href = "./front/mainPage.php";
                break;
            }
          }, 1200);
        } else {                      // Datos incorrectos
          $("#btnLogin").removeClass("is-loading");
          $(".help").html("Alguno de los datos es incorrecto");
          setTimeout(() => {
            $(".help").html("");
          }, 2000);
        }
      },
    });
  });
});
