<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    // Recibe variables del formulario
    $descripcion = strtolower($_POST["descripcion"]);
    $proveedor = $_POST["proveedor"];
    $departamento = strtolower($_POST["departamento"]);
    $precio = $_POST["precio"];
    $existencia = $_POST["existencia"];
    $status = $_POST["status"];

    $status = $status == "activo" ? "1" : "0";

    $sql = "INSERT INTO producto VALUES (0, '$proveedor', '$descripcion', 
    '$departamento','$precio', '$existencia', '$status')";

    $ejecutarInsertar = mysqli_query($con, $sql);

    if (!$ejecutarInsertar) {
        echo 0;     // Error en la linea de SQL
    }
    echo 1;         // Finalizado con exito
?>