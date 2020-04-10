<?php
    require_once("../conecta.php"); //Conecta a la Base de datos
    session_start();

    $correo = $_POST["correo"];     // Obtiene el correo a buscar
    $cargo = $_POST["cargo"];       // Obtiene el cargo a verificar
    $flag = $_POST["bandera"];      // Valida si es una sesion de empleado o cliente

    // Consulta MySql
    if ($flag) {        // Si es de un empleado
        $sql = "SELECT * FROM empleado WHERE LOWER(email) = LOWER('$correo') AND (LOWER(cargo) = LOWER('$cargo') AND status = 1)";
    }

    else {              // Si es de un cliente
        $sql = "SELECT * FROM cliente WHERE LOWER(email) = LOWER('$correo')";
    }

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta, con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas de la consulta

    // Si la consulta si genera algun resultado
    if($fila != 0 && $flag) {           // Empleado
        $row = mysqli_fetch_assoc($res);
        $id_worker = $row['id'];
        $worker = $row['nombre'];

        $_SESSION['id_user'] = $id_worker;
        $_SESSION['user'] = $worker;

        $_SESSION['id_client'] = "";
        $_SESSION['client'] = "";
        echo $worker;                   
    }
    
    else if ($fila != 0 && !$flag){     // Cliente
        $row = mysqli_fetch_assoc($res);
        $id_client = $row['id'];
        $client = $row['nombre'];

        $_SESSION['id_client'] = $id_client;
        $_SESSION['client'] = $client;
        echo $client;   
    }
    
    // Si la consulta no genera ningun resultado
    else {
        echo 0; 
    }
?>