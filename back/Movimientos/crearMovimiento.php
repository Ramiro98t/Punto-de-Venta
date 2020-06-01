<?php
    require_once('../conecta.php');     //Conecta a la Base de datos
    session_start();

    // Id del ultimo movimiento realizado - Movimiento actual
    $sql = "SELECT * FROM movimiento ORDER BY id DESC LIMIT 1";
    $res = mysqli_query($con,$sql);
    
    $movimiento = $res->fetch_object();
    $movimiento = $movimiento->id;
    
    // Vistas de cantidad a actualizar de cada producto seleccionado del movimiento
    $sql = "SELECT detalle_movimiento.cantidad, detalle_movimiento.id_producto 
            FROM detalle_movimiento WHERE (id_movimiento='$movimiento')";
            
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