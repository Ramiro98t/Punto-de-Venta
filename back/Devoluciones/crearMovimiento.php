<?php
    require_once('../conecta.php'); //Conecta a la Base de datos
    session_start();

    $id_worker = $_SESSION['id_user']; 
    
    $fecha = date('d-m-Y');
    $devolucion = $_GET["dev"];       // Id Devolucion
    
    $sql = "UPDATE venta SET status = 3 WHERE id = '$dev'";
    $res = mysqli_query($con,$sql);

    $sql = "INSERT INTO movimiento VALUES(0, '$fecha', '0','$id_worker', '2', '$devolucion')";
    $res = mysqli_query($con,$sql);
    
    // Vistas de cantidad a actualizar de cada producto seleccionado del ajuste
    $sql = "SELECT detalle_devolucion.cantidad, detalle_devolucion.id_producto 
            FROM detalle_devolucion WHERE (id_devolucion='$devolucion')";

    $res = mysqli_query($con,$sql);     // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas
    
    while ($fila) {
        $f = $res->fetch_object();
        $sql = "UPDATE producto SET existencia=existencia+'$f->cantidad'
                WHERE id='$f->id_producto'";
        $resM = mysqli_query($con, $sql);
        
        $fila--;
    }

    header("Location: ../../front/mainPageWH.php");  // Redirecciona a pagina principal

?>