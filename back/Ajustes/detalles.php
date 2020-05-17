<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar

    $output = '';                   // Almacena los resultados 

    // Consulta MySql general
    $sql = "SELECT producto.id, producto.descripcion, detalle_ajuste.cantidad, 
            detalle_ajuste.motivo FROM detalle_ajuste INNER JOIN producto 
            ON detalle_ajuste.id_producto = producto.id WHERE id_ajuste = $term";

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    if (!$fila) echo 0;     // En caso de no encontrar coincidencias

    else {                  // En caso de encontrar coincidencias, imprime todas
        $output .='
        <p class="title">
            ID Ajuste: '. $term .'
        </p>
        <div class="columns">
            <p class="column subtitle is-three-fifths has-text-info">
                ID - Descripcion
            </p>
            <p class="column subtitle is-one-fifths has-text-info">
                Motivo
            </p>
            <p class="column subtitle is-one-fifth has-text-info">
                Cantidad
            </p>
        </div>
        <div class="detalle-venta columns is-multiline">
        ';
        for ($i = $fila; $f = $res->fetch_object(); $i--) {
            $output .= '
            <p class="column is-three-fifths">
                '. $f->id .' - '. $f->descripcion .'
            </p>
            <p class="column is-one-fifths">
                '. $f->motivo .'
            </p>
            <p class="column is-one-fifth has-text-centered">
                '. $f->cantidad .'
            </p>
            ';
        }
        $output .='
            </div>
            <p class="help has-text-grey">SSPISW - Punto de Venta</p>
        ';
        echo $output;
    }

?>