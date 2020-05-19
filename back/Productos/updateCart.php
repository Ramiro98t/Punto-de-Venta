<?php
    require_once('../conecta.php'); // Conecta a la Base de datos

    $producto = $_POST["producto"]; // Recibe el id del producto
    $cantidad = $_POST["cantidad"]; // Recibe cantidad del producto

    $bandera = $_POST["bandera"];   // Valida si se vacia el carrito

    if ($bandera) { // Modificacion total (Vaciar carrito)
        $sql = "SELECT * FROM venta WHERE status = 0";
        $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
       
        $id_v = $res->fetch_object();
        $id_v = $id_v->id;

        // Cerrar venta
        $sql = "DELETE FROM venta WHERE status = 0";
        $res = mysqli_query($con, $sql);

        $sql = "UPDATE detalle_venta SET cantidad = '$cantidad' WHERE id_venta = '$id_v'";
    }
    
    else {          // Modificacion individual
        $sql = "UPDATE detalle_venta SET cantidad = '$cantidad'
                WHERE id_producto='$producto'";
    }

    $res = mysqli_query($con, $sql);

    // Eliminar donde sea cantidad llegue a 0
    $xSql = "DELETE FROM detalle_venta WHERE cantidad = 0";
    $xRes = mysqli_query($con, $xSql);

    if ($res) {
        echo 1;
    }
    else {
        echo 0;
    }

?>