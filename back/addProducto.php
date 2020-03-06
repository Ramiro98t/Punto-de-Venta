<?php
    require_once('./conecta.php');  //Conecta a la Base de datos

    $descripcion = $_POST["descripcion"];
    $departamento = $_POST["departamento"];
    $precio = $_POST["precio"];
    $existencia = $_POST["existencia"];
    $stock_max = $_POST["stock_max"];
    $stock_min = $_POST["stock_min"];
    $status = $_POST["status"];

    if ($status == 'activo') {
        $status = 1;
    } else {
        $status = 0;
    }

    $descripcion = strtolower($descripcion);
    $departamento = strtolower($departamento);

    $sql = "INSERT INTO producto VALUES (0,'$descripcion','$departamento','$precio','$existencia','$stock_max','$stock_min','$status')";
    $ejecutarInsertar = mysqli_query($con, $sql);

    if (!$ejecutarInsertar) {
        echo 0;     // Error en la linea de SQL
    }
    echo 1;         // Finalizado con exito
?>