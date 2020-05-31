$(document).ready(function () {
  /**
   * Metodos para botones de redireccionamiento administrador
   */
  $("select").on("change", function () {
    // Modifica el titulo con la opcion seleccionada
    let title = $("select option:selected").text();
    $("#title").html("Metodos " + title);

    // Almacena la opcion seleccionada
    let op = $(this).val();
    
    // Formato a botones
    $("#regBtn").html("Registrar" + " " + title);
    $("#viewBtn").html("Lista de"  + " " + title);
    $(".button").removeClass("is-hidden");

    switch (op) {         // En funcion de la opcion accede a las distintas vistas
      case "1":           // Registro y Vista de Empleados
        $("#regBtn").attr("href", "./empleados.html");
        $("#viewBtn").attr("href", "./generalList.php?label=Empleados");
        break;

      case "2":           // Registro y Vista de Productos
        $("#regBtn").attr("href", "./productos.php");
        $("#viewBtn").attr("href", "./generalList.php?label=Productos");
        break;

      case "3":           // Registro y Vista de Clientes
        $("#regBtn").attr("href", "./clientes.html");
        $("#viewBtn").attr("href", "./generalList.php?label=Clientes");
        break;

      case "4":           // Registro y Vista de Proveedores
        $("#regBtn").attr("href", "./proveedores.html");
        $("#viewBtn").attr("href", "./generalList.php?label=Proveedores");
        break;

      case "5":           // Vista de Ventas y Devoluciones
        $("#regBtn").html("Lista de Ventas");  // Formatea ambos botones a "Lista de"
        $("#viewBtn").html("Lista de Devoluciones");  // Formatea ambos botones a "Lista de"
        $("#regBtn").attr("href", "./generalList.php?label=Ventas");
        $("#viewBtn").attr("href", "./generalList.php?label=Devoluciones");
        break;

      case "6":           // Registro y Vista de Ajustes
        $("#regBtn").attr("href", "./ajuste.php");
        $("#viewBtn").attr("href", "./generalList.php?label=Ajustes");
        break;

      case "7":           // Registro de Compras y Vista de Movimientos
        $("#regBtn").html("Registrar Compra/Devolucion");
        $("#regBtn").attr("href", "./movProveedor.php");
        $("#viewBtn").attr("href", "./generalList.php?label=Movimientos");
        break;

      default:
        break;
    }
  });

  // Reinicia Select al escoger una opcion
  $(".button").on("click", function () {
    $("select").prop("selectedIndex", 0); 
  });
});
