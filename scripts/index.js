$(document).ready(function() {
    // Index 
    $("select").on("change", function() { // Metodo para cambios en el select
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
            case '1':
                $("#regBtn").attr("href", "./front/worker.php");
                $("#viewBtn").attr("href", "./front/workerList.php");
                $(".button").show();
                break;

            case '2':
                $("#regBtn").attr("href", "./front/product.php");
                $("#viewBtn").attr("href", "./front/productList.php?label=Productos");
                $(".button").show();
                break;

            case '3':
                $("#regBtn").attr("href", "./front/provider.php");
                $("#viewBtn").attr("href", "./front/providerList.php");
                $(".button").show();
                break;

            default:
                break;
        }
    });
    /*
     * Hide buttons at the beginning
     */
    $(".button").hide();
});