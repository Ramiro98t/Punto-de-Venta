<?php
    require_once('../conecta.php'); //Conecta a la Base de datos
    session_start();

    $id_worker = $_SESSION['id_user']; 
    $fecha = date('d-m-Y');
    
    $venta = $_GET["venta"];       // Id Devolucion
    
    $sql = "UPDATE venta SET status = 2 WHERE id = '$venta'";
    $res = mysqli_query($con,$sql);

    $sql = "INSERT INTO movimiento VALUES(0, '$fecha', '$id_worker', '3', '$venta')";
    $res = mysqli_query($con,$sql);
    
    // Vistas de cantidad a actualizar de cada producto seleccionado del ajuste
    $sql = "SELECT detalle_venta.cantidad, detalle_venta.id_producto 
            FROM detalle_venta WHERE (id_venta='$venta')";

    $res = mysqli_query($con,$sql);     // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas
    
    while ($fila) {
        $f = $res->fetch_object();
        $sql = "UPDATE producto SET existencia=existencia-'$f->cantidad'
                WHERE id='$f->id_producto'";
        $resM = mysqli_query($con, $sql);
        
        $fila--;
    }

    header("Location: ../../front/mainPageWH.php");  // Redirecciona a pagina principal

?>