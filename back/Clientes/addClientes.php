<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    // Recibe variables del formulario
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $cp = $_POST["cp"];
    $email = $_POST["email"];
    $status = $_POST["status"];
    
    if ($status == 'activo') {
        $status = 1;
    } else {
        $status = 0;
    }

    $sql = "INSERT INTO cliente VALUES (0,'$nombre','$direccion','$telefono','$cp','$email','$status')";
    $ejecutarInsertar = mysqli_query($con, $sql);

    if (!$ejecutarInsertar) {
        echo 0;     // Error en la linea de SQL
    }
    echo 1;         // Finalizado con exito
?>