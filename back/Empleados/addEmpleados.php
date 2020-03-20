<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $ciudad = $_POST["ciudad"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $cargo = $_POST["cargo"];
    $salario = $_POST["salario"];
    $status = $_POST["status"];
    
    if ($status == 'activo') {
        $status = 1;
    } else {
        $status = 0;
    }

    $sql = "INSERT INTO empleado VALUES (0,'$nombre','$direccion','$ciudad','$telefono','$email','$cargo','$salario','$status')";
    $ejecutarInsertar = mysqli_query($con, $sql);

    if (!$ejecutarInsertar) {
        echo 0;     // Error en la linea de SQL
    }
    echo 1;         // Finalizado con exito
