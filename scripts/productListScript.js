// ** FUNCIONES LISTA DE PRODUCTOS

$(document).ready(function () {
    let type = $('#type').val();

    let data = '';      // Almacena el valor del input
    // Al presionar cualquier tecla dentro del input
    $('#search').on('keyup', function () {
        alert(type);
        data = $(this).val();   // Almacena el texto
        if (data) {     // Si contiene info realiza la busqueda
            $.ajax({
                url: '../back/search.php',
                type: 'POST',
                data: { search: data },
                dataType: 'text',
                success: function (res) {
                    if (res == 0) {
                        $('.result').html(
                            '<div class="column"><p class="subtitle is-1">Sin Resultados</p></div>'
                        );
                    }
                    else {
                        // Al contenedor se le coloca el resultado de la busqueda
                        $('.result').html(res);
                    }
                }
            });
        }
        else {          // Si no contiene nada muestra todos los productos
            $.ajax({
                url: '../back/list.php',
                type: 'POST',
                dataType: 'text',
                success: function (res) {
                    // Al contenedor se le coloca el resultado de la busqueda
                    $('.result').html(res);
                }
            });
        }
    });
                        // Al inicio siempre muestra los productos
    if (!data) {
        $.ajax({
            url: '../back/list.php',
            type: 'POST',
            dataType: 'text',
            success: function (res) {
                // Al contenedor se le coloca el resultado de la busqueda
                $('.result').html(res);
            }
        });
    }
});

// ** FIN FUNCIONES LISTA DE PRODUCTOS
