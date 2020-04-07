<?php
    require_once("../conecta.php"); //Conecta a la Base de datos
    session_start();

    $correo = $_POST["correo"];     // Obtiene el correo a buscar
    $cargo = $_POST["cargo"];       // Obtiene el cargo a verificar

    // Consulta MySql
    $sql = "SELECT * FROM empleado WHERE LOWER(email) = LOWER('$correo') AND (LOWER(cargo) = LOWER('$cargo') AND status = 1)";
    $res = mysqli_query($con, $sql);    // Ejecuta la consulta, con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas de la consulta

    if($fila != 0) {
        $row = mysqli_fetch_assoc($res);
        $worker = $row['nombre'];
        $_SESSION['user'] = $worker;
        echo $worker; // Si la consulta si genera algun resultado
    }
    
    else {
        echo 0; // Si la consulta no genera ningun resultado
    }
?>