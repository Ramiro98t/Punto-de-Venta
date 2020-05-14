<?php
    require_once('./conecta.php'); // Conecta a la Base de datos
    // recibe metodo de pago
    $metodo = $_POST["pago"];
    switch ($metodo) {
        case '1':
            $metodo = "efectivo";
            break;
        case '2':
            $metodo = "tarjeta";
            break;
        case '3':
            $metodo = "ambos";
            break;
    }


    // Modificacion individual
        $sql = "UPDATE ventas SET pago = '$metodo', status = 1
                WHERE status = 0";
    $res = mysqli_query($con, $sql);
