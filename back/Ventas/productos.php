<?php
    require_once('../conecta.php'); //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
     
    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    $sql = "SELECT venta_producto.id_producto, venta_producto.id_venta, producto.descripcion, venta_producto.cantidad FROM producto 
            INNER JOIN venta_producto ON producto.id = venta_producto.id_producto
            WHERE (venta_producto.id_venta LIKE '%$term%')";

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    
    if (!$fila) echo 0;     // En caso de no encontrar coincidencias

    else {                  // En caso de encontrar coincidencias, imprime todas
        for ($i = $fila; $f = $res->fetch_object(); $i--) {
        $output .= '
        <div id="'.$f->id_producto.'" class="field">
            <div class="control">
                <input type="checkbox"> '. $f->descripcion .'
                <input type="number" class="input is-small" min="1" max="'.$f->cantidad.'" step="1" value="'.$f->cantidad.'" title="Cantidad">
            </div>
        </div>
        ';
        }
        echo $output;
    }

?>