$(document).ready(function () {
  $("#manageClient").on("click", function () {
    // Si se va a ingresar un nuevo cliente
    if ($("#manageClient").find("#type").html() == "Ingresar") {
      let email = $("#clientEmail").val();
      $.ajax({
        type: "post",
        url: "../back/Cuentas/evalAccount.php",
        data: { correo: email, 
                cargo: "",
                bandera: "" },
        success: function (response) {
          // Datos correctos
          if (response != 0) {
            if (confirm("Cliente " + response + "?")) {
              location.reload();
            }
          }

          // Datos incorrectos
          else {
            alert("No hay Coincidencias");
          }
        },
      });
    } else {
      // Se va a cerrar sesion de cliente
      location.href = "../back/desconecta.php?no_user=true";
    }
  });

  // Boton para agregar producto en carrito
  $(".addBtn").on("click", function () {
    // Almacenan datos
    let empleado = $("#workerUser").attr("name");
    let cliente = $("#clientEmail").attr("name");
    let producto = $(this).parent().attr("id");

    // Si existe un cliente al registrar los productos
    if (cliente) {
      $.ajax({
        url: "../back/cartList.php",
        type: "POST",
        data: {
          id_producto: producto,
          id_empleado: empleado,
          id_cliente: cliente,
        },
        dataType: "text",
        success: function (res) {
          // Recarga la pagina
          $("#carrito").load(" #carrito > *", function () {
            $.getScript("../scripts/dbOperations.js");
          });
          $(".cantidad-carrito").load(" .cantidad-carrito > *");
        },
        error: function () {
          alert("Error al conectar al servidor"); // Inconsistencia al redireccionar
        },
      });
    }

    // Si no existe un cliente registrado
    else {
      alert("Debe haber un cliente en el sistema");
    }
  });
});
