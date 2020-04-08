$(document).ready(function () {
  // Index
  $("select").on("change", function () {
    // Metodo para cambios en el select
    // Inicializa el text de Botones
    $("#regBtn").html("Registrar");
    $("#viewBtn").html("Lista de");
    // Modifica el titulo con la opcion seleccionada
    let title = $("select option:selected").text();
    let op = $(this).val();
    $("#title").html(title);
    // Agrega al boton un indicador de categoria
    $("#regBtn").html($("#regBtn").html() + " " + title);
    $("#viewBtn").html($("#viewBtn").html() + " " + title);

    switch (op) {
      case "1":
        $("#regBtn").attr("href", "./empleados.php");
        $("#viewBtn").attr("href", "./generalList.php?label=Empleados");
        break;

      case "2":
        $("#regBtn").attr("href", "./productos.php");
        $("#viewBtn").attr("href", "./generalList.php?label=Productos");
        break;

      case "3":
        $("#regBtn").attr("href", "./proveedores.php");
        $("#viewBtn").attr("href", "./generalList.php?label=Proveedores");
        break;

      default:
        break;
    }
    $(".button").show();
  });
  /*
   * Hide buttons at the beginning
   */
  $(".button").hide();
});
