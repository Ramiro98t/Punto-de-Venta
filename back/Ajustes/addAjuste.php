<?php
    require_once('../conecta.php'); //Conecta a la Base de datos
    session_start();

    // Almacena las variables a considerar
    $id_worker = $_SESSION['id_user']; 
    $producto = $_POST["producto"];       
    $cantidad = $_POST["cantidad"];       
    $motivo = $_POST["motivo"];       
    
    // Bandera que indica si es el primer elemento
    $flag = $_POST["flag"];    
    
    $output = "";                   // Almacena los resultados 
    $ajuste = "";                   // Almacena id del ajuste actual

    // Si es primer elemento del ajuste
    if ($flag == "true") {
        echo $id_worker, $producto, $cantidad;
        $fecha = date('d-m-Y');
        $sql = "INSERT INTO ajuste VALUES (0, '$fecha', '$id_worker')";
        $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    }

    // Toma de referencia el ultimo ajuste mientras sea el mismo ajuste
    $sql = "SELECT * FROM ajuste ORDER BY id DESC LIMIT 1";
    $res = mysqli_query($con,$sql);

    $ajuste = $res->fetch_object();
    $ajuste = $ajuste->id;
    
    // Agrega al ajuste los productos mientras sea el mismo ajuste
    $sql = "INSERT INTO detalle_ajuste VALUES ('$ajuste', '$producto', '$cantidad', '$motivo')";
    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    
    $sql = "SELECT * FROM detalle_ajuste INNER JOIN producto ON detalle_ajuste.id_producto = producto.id
            WHERE (id_ajuste = '$ajuste')";
    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas
    
    for ($i = $fila; $f = $res->fetch_object(); $i--) {
        $output .= '
            <tr>
                <th>'. $f->cantidad .'</th>
                <td>'. $f->descripcion .'</td>
                <td>'. $f->motivo .'</td>
            </tr>
        ';
    }

    echo $output;
