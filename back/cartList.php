<?php
    require_once('./conecta.php');  //Conecta a la Base de datos

    $fecha = date('d-m-Y');
    $empleado = $_POST["id_empleado"];
    $cliente = $_POST["id_cliente"];
    $producto = $_POST["id_producto"];

    // Consulta MySql general
    $sql = "SELECT * FROM ventas WHERE status = 0";
    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    // Si existe una venta pendiente
    if ($fila) {
        $id_venta = $res->fetch_object();
        $id_venta = $id_venta->id;

        // Busca coincidencias del producto
        $sql = "SELECT * FROM venta_producto WHERE id_venta='$id_venta' AND id_producto='$producto'";
        $res = mysqli_query($con, $sql);
        $fila = mysqli_num_rows($res);

        // Si ya existe un pedido con ese producto se modifica la cantidad
        if ($fila) {
            $cant = $res->fetch_object();
            $cant = $cant->cantidad;
            $cant++;

            $sql = "UPDATE venta_producto SET cantidad='$cant'
            WHERE id_producto='$producto' AND id_venta='$id_venta'";
            $res = mysqli_query($con, $sql);
        }
        // Si no existe un pedido con ese producto se inserta el nuevo producto
        else {
            $sql = "INSERT INTO venta_producto VALUES
                    (0,'$id_venta','$producto',1)";
            $res = mysqli_query($con,$sql);
        }
        echo 1;
    }
    
    // Si no existe una venta pendiente
    else {
        // Crea una nueva venta para el cliente 
        $sql = "INSERT INTO ventas VALUES
                (0,'$fecha', '$empleado', '$cliente', 0)";
        $res = mysqli_query($con,$sql);
        
        if($res){
            // Obtiene el id de la venta actual para asignar los productos a la venta
            $sql = "SELECT * FROM ventas WHERE status = 0";
            $res = mysqli_query($con,$sql);
        
            $id_venta = $res->fetch_object();
            $id_venta = $id_venta->id;
        
            // Inserta a la misma venta el producto
            $sql = "INSERT INTO venta_producto VALUES
                    (0,'$id_venta','$producto',1)";
            $res = mysqli_query($con, $sql);
            echo 1;
        }
        else {
            echo 0;
        }
    }
?>