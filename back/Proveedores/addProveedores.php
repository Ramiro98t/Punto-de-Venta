<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    
    $insertarDatos = "INSERT INTO proveedor VALUES (0,'$nombre','$correo','$telefono')";
    $ejecutarInsertar = mysqli_query($con, $insertarDatos);
    
    if (!$ejecutarInsertar) {
        echo 0;     // Error en la linea de SQL
    }
    echo 1;         // Finalizado con exito   
?>