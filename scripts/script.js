// ** FUNCIONES EMPLEADO

function valFormEmp() {
    // Varibles que almacenan el valor de los input
    var nombre = $('input[name="nombre"]').val();
    var direccion = $('input[name="direccion"]').val();
    var ciudad = $('input[name="ciudad"]').val();
    var telefono = $('input[name="telefono"]').val();
    var email = $('input[name="email"]').val();
    var cargo = $('input[name="cargo"]').val();
    var salario = $('input[name="salario"]').val();
    // Verifica que todos los datos del formulario hayan sido ingresados
    if (
        !nombre.length ||
        !direccion.length ||
        !ciudad.length ||
        !telefono.length ||
        !email.length ||
        !cargo.length ||
        !salario.length
    ) {
        $(".mensaje").html("Faltan campos por llenar"); // Modifica el contenedor, inserta al html.
        setTimeout("$('.mensaje').html('')", 2000);
        return false;
    } else {
        return true;
    }
}

function valFormProd() {
    // Varibles que almacenan el valor de los input
    var descripcion = $('input[name="descripcion"]').val();
    var departamento = $('input[name="departamento"]').val();
    var precio = $('input[name="precio"]').val();
    var existencia = $('input[name="existencia"]').val();
    var stock_max = $('input[name="stock_max"]').val();
    var stock_min = $('input[name="stock_min"]').val();
    // Verifica que todos los datos del formulario hayan sido ingresados
    if (
        !descripcion.length ||
        !departamento.length ||
        !precio.length ||
        !existencia.length ||
        !stock_max.length ||
        !stock_min.length
    ) {
        $(".mensaje").html("Faltan campos por llenar"); // Modifica el contenedor, inserta al html.
        setTimeout("$('.mensaje').html('')", 2000);
        return false;
    } else {
        return true;
    }
}

function valFormProv() {
    // Varibles que almacenan el valor de los input
    var nombre = $('input[name="nombre"]').val();
    var correo = $('input[name="correo"]').val();
    var telefono = $('input[name="telefono"]').val();
    // Verifica que todos los datos del formulario hayan sido ingresados
    if (
        !nombre.length ||
        !correo.length ||
        !telefono.length
    ) {
        $(".mensaje").html("Faltan campos por llenar"); // Modifica el contenedor, inserta al html.
        setTimeout("$('.mensaje').html('')", 2600);
        return false;
    } else {
        return true;
    }
}

$(document).ready(function () {
    $('.input').on('keyup', function () {
        if ($(this).val() != '') {
            $target = $(event.target);   
            $target.addClass('is-success');
        }
        else {
            $target = $(event.target);   
            $target.removeClass('is-success');
        }
    });

    // Se cargan funciones al terminar de cargar la pagina completa
    $('.enviar').on('click', function () {
        let bandera = false;
        let ruta = $('.wForm').val();
        switch (ruta) {
            case "Empleado":
                if (valFormEmp()) { bandera = true; }
                break;
            case "Producto":
                if (valFormProd()) { bandera = true; }
                break;
            case "Proveedor":
                if (valFormProv()) { bandera = true; }
                break;
        }
        if (bandera) {
            var form = $('.mainForm')[0];
            var data = new FormData(form);
            $.ajax({
                url: '../back/add' + ruta + '.php',
                type: 'POST',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                success: function (res) {
                    if (res == 1) {
                        // Modifica el contenedor 'mensaje', inserta al html la imagen
                        $('.mensaje').html(
                            'Realizando registro!<img src="../img/loading.gif" width="25px" height = "25px"/>'
                        );
                        setTimeout("$('.mensaje').html('')", 1500);
                        // setTimeout("$('.mensaje').html('')", 1500);
                        setTimeout(function () {
                            window.location.href = ruta + ".php";
                        }, 1500);
                    } else {
                        $('.mensaje').html('Datos incorrectos!'); // Mensaje de error
                        setTimeout("$('.mensaje').html('')", 3000);
                    }
                }
            });
        }
    });
    $('.cancelar').on('click', function () {
        $('.input').val('');
    });
});


// ** FIN FUNCIONES EMPLEADO