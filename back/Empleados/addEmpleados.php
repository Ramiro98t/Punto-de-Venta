<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    // Recibe variables del formulario
    $nombre = strtolower($_POST["nombre"]);
    $direccion = strtolower($_POST["direccion"]);
    $ciudad = strtolower($_POST["ciudad"]);
    $telefono = $_POST["telefono"];
    $email = strtolower($_POST["email"]);
    $cargo = strtolower($_POST["cargo"]);
    $salario = $_POST["salario"];
    $status = $_POST["status"];
    
    $status = $status == "activo" ? "1" : "0";

    $sql = "INSERT INTO empleado VALUES (0,'$nombre','$direccion','$ciudad','$telefono','$email','$cargo','$salario','$status')";
    $ejecutarInsertar = mysqli_query($con, $sql);

    if (!$ejecutarInsertar) {
        echo 0;     // Error en la linea de SQL
    }
    echo 1;         // Finalizado con exito
?>