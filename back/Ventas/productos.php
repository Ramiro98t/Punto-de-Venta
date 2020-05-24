<?php
    require_once('../conecta.php'); //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
     
    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    $sql = "SELECT detalle_venta.precio AS importe, detalle_venta.id_producto,
            detalle_venta.id_venta, detalle_venta.cantidad, producto.descripcion 
            FROM producto 
            INNER JOIN detalle_venta ON producto.id = detalle_venta.id_producto
            INNER JOIN venta ON detalle_venta.id_venta = venta.id
            WHERE (detalle_venta.id_venta = $term)";

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    if (!$fila) echo 0;     // En caso de no encontrar coincidencias

    else {                  // En caso de encontrar coincidencias, imprime todas
        for ($i = $fila; $f = $res->fetch_object(); $i--) {
        $output .= '
        <div class="'. $f->id_venta .'">
            <div id="'.$f->id_producto.'" class="row columns is-multiline">
                <div class="column">
                    <input class="productoSel" type="checkbox"> '. $f->id_producto .' - '. $f->descripcion .'
                </div>
                <div class="column is-two-fifth">
                    <input class="motivo input is-small" placeholder="Motivo">
                </div>
                <div class="column is-one-fifth">
                    <input type="number" class="productoDev input is-small" min="1" max="'.$f->cantidad.'" step="1" value="'.$f->cantidad.'" title="Cantidad">
                </div>
            </div>
        </div>
        ';
        }
        echo $output;
    }

?>