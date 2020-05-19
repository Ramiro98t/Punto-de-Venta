<?php
    require_once('./conecta.php'); // Conecta a la Base de datos
    // recibe metodo de pago
    $metodo = $_POST["pago"];
    $disc = $_POST["disc"];

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

    if ($disc != "0") {
        $sql = "UPDATE detalle_venta INNER JOIN venta 
        ON detalle_venta.id_venta = venta.id SET  
        precio=precio-precio*$disc WHERE venta.status = 0";
        $res = mysqli_query($con, $sql);
    }

    // Modificacion individual
    $sql = "UPDATE venta SET pago = '$metodo', disc = '$disc', status = 1 WHERE (status = 0)";
    $res = mysqli_query($con, $sql);
