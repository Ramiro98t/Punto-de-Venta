<?php
    require_once('../conecta.php');     //Conecta a la Base de datos
    session_start();
    $id_worker = $_SESSION['id_user'];

    // Id del ultimo ajuste realizado - Ajuste actual
    $sql = "SELECT * FROM ajuste ORDER BY id DESC LIMIT 1";
    $res = mysqli_query($con,$sql);
    
    $ajuste = $res->fetch_object();
    $ajuste = $ajuste->id;
    
    $fecha = date('d-m-Y');
    
    // Crea el nuevo movimiento relacionado al id del ajuste
    $sql = "INSERT INTO movimiento VALUES(0, '$fecha', '1','$id_worker', '4', '$ajuste')";
    $res = mysqli_query($con,$sql);
    
    // Vistas de cantidad a actualizar de cada producto seleccionado del ajuste
    $sql = "SELECT detalle_ajuste.cantidad, detalle_ajuste.id_producto 
            FROM detalle_ajuste WHERE (id_ajuste='$ajuste')";
    $res = mysqli_query($con,$sql);     // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas
    
    while ($fila) {
        $f = $res->fetch_object();
        $sql = "UPDATE producto SET existencia=existencia-'$f->cantidad'
                WHERE id='$f->id_producto'";
        $resM = mysqli_query($con, $sql);
        
        $fila--;
    }
    
    header("Location: ../../front/operations.html");  // Redirecciona a pagina principal
?>