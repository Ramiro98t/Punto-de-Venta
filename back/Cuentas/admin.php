<?php
    require_once("../conecta.php");     //Conecta a la Base de datos
    session_start();

    $correo = $_POST["correo"];         // Obtiene el correo a buscar
    $cargo = $_POST["cargo"];           // Obtiene el cargo a verificar

    if ($cargo == "administrador") {
        // Consulta MySql
        $sql = "SELECT * FROM empleado WHERE (email = LOWER('$correo') AND cargo = LOWER('$cargo') AND status = 1)";
     
        $res = mysqli_query($con, $sql);    // Ejecuta la consulta, con la conexion establecida
        $fila = mysqli_num_rows($res);      // Obtiene el numero de filas de la consulta
    
        // Si la consulta genera algun resultado y es Empleado
        if($fila != 0) {               
            echo 1;
        }
        else {
            echo 0;
        } 
    }

    else {                                  // Si la consulta no genera ningun resultado
        echo 0; 
    }
