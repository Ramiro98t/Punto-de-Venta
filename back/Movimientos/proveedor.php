<?php 
    require_once('../conecta.php');  // Conecta a la Base de datos
    session_start();

    //Recibe Variables
    $id_worker = $_SESSION['id_user']; 
    $folio = $_POST["folio"];
    $producto = $_POST["producto"];
    $cantidad = $_POST["cantidad"];
    $motivo = $_POST["motivo"];
    // Bandera que indica si es el primer elemento
    $flag = $_POST["flag"];  

    $output = "";                   // Almacena los resultados 
    $movimiento = "";               // Almacena id del movimiento actual

    if($flag == "true") {     // Primer elemento del movimiento
        $fecha = date('d-m-Y');
        if (!$folio) {      // Devolucion
            $sql = "INSERT INTO movimiento VALUES(0, '$fecha', '$id_worker', '4', 0)";
        }
        else {              // Compra
            $sql = "INSERT INTO movimiento VALUES(0, '$fecha', '$id_worker', '1', '$folio')";
        }
        $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    }
    
    
    // Toma de referencia el ultimo movimiento 
    $sql = "SELECT * FROM movimiento ORDER BY id DESC LIMIT 1";
    $res = mysqli_query($con,$sql);
    
    // Obtiene el id del movimiento actual
    $movimiento = $res->fetch_object();
    $movimiento = $movimiento->id;

    // Compra
    if ($folio) $motivo = "compra";

    // Agrega al movimiento los productos mientras sea el mismo movimiento
    $sql = "INSERT INTO detalle_movimiento VALUES ('$movimiento', '$producto', '$cantidad', '$motivo')";
    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    
    // Muestra los productos del movimiento actual
    $sql = "SELECT * FROM detalle_movimiento INNER JOIN producto ON detalle_movimiento.id_producto = producto.id
            WHERE (id_movimiento = '$movimiento')";
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
