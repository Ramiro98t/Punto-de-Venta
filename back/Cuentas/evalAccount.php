<?php
    require_once("../conecta.php");     //Conecta a la Base de datos
    session_start();

    $correo = $_POST["correo"];         // Obtiene el correo a buscar
    $cargo = $_POST["cargo"];           // Obtiene el cargo a verificar
    $flag = $_POST["bandera"];          // Valida si es una sesion de empleado o cliente

    // Consulta MySql
    if ($flag) {        // Si es de un empleado
        $sql = "SELECT * FROM empleado WHERE LOWER(email) = LOWER('$correo') AND (LOWER(cargo) = LOWER('$cargo') AND status = 1)";
    }

    else {              // Si es de un cliente
        $sql = "SELECT * FROM cliente WHERE LOWER(email) = LOWER('$correo')";
    }

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta, con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas de la consulta

    // Si la consulta genera algun resultado y es Empleado
    if($fila != 0 && $flag) {               
        $row = mysqli_fetch_assoc($res);    // Almacena el registro encontrado
        $id_worker = $row['id'];            // Almacena el id del empleado
        $worker = $row['nombre'];           // Almacena el nombre del empleado
        $arr = explode(' ',trim($worker));  // Subdivide el nombre, posteriormente solo se necesita el primer nombre

        $_SESSION['id_user'] = $id_worker;  // Asigna a la sesion el id del empleado
        $_SESSION['user'] = $arr[0];        // Asigna a la sesion el primer nombre del empleado

        $_SESSION['id_client'] = "";        // Inicializa sesion del cliente en nulo
        $_SESSION['client'] = "";           

        switch ($cargo) {                   // Administra los roles de empleado
            case "administrador":
                echo 1;                     // Retorna 1 si Administrador
                break;
            case "vendedor":
                echo 2;                     // Retorna 2 si Vendedor
                break;      
            case "almacenista":
                echo 3;                     // Retorna 3 si Almacenista
                break; 
            default:
                echo $worker;               // Retorna Nombre del empleado
                break;
        }
    }

    // Si la consulta genera algun resultado y es Cliente
    else if ($fila != 0 && !$flag){         
        $row = mysqli_fetch_assoc($res);        // Almacena el registro encontrado
        $id_client = $row['id'];                // Almacena el id del cliente
        $client = $row['nombre'];               // Almacena el nombre del cliente

        $_SESSION['id_client'] = $id_client;    // Asigna a la sesion el id del cliente
        $_SESSION['client'] = $client;          // Asigna a la sesion el nombre del cliente
        echo $client;                           // Retorna Nombre del cliente
    }
    
    else {                                  // Si la consulta no genera ningun resultado
        echo 0; 
    }
