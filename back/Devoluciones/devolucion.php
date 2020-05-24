<?php
    require_once('../conecta.php'); //Conecta a la Base de datos
    session_start();
    
    // Variables a considerar
    $venta = $_POST["id_venta"];       
    $producto = $_POST["producto"];    
    $cantidad = $_POST["cantidad"];    
    $motivo = $_POST["motivo"];    
    $fecha = date('d-m-Y');
    
    // Bandera que indica si es en la misma devolucion
    $flag = $_POST["flag"];    
    $id_worker = $_SESSION['id_user']; 
    
    if($flag == "false"){                      // Insertar Devolucion
        $sql = "INSERT INTO devolucion VALUES (0, '$fecha', '$venta', '$id_worker', 0)";
        $res = mysqli_query($con, $sql);

        $sql = "UPDATE venta SET status = 3 WHERE id = '$venta'";
        $res = mysqli_query($con,$sql);
    }
    
    // Tomar ultima devolucion
    $sql = "SELECT id FROM devolucion ORDER BY id DESC LIMIT 1";
    $res = mysqli_query($con, $sql);
    
    $devolucion = $res->fetch_object();
    $devolucion = $devolucion->id;
    
    // Insertar detalles devolucion
    $sql = "INSERT INTO detalle_devolucion VALUES ('$devolucion', '$producto', '$cantidad', '$motivo')";
    $res = mysqli_query($con, $sql);

    echo 1;
?>