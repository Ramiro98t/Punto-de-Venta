<?php
    require_once('../conecta.php'); //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
     
    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    $sql = "SELECT producto.descripcion, detalle_venta.* FROM producto 
            INNER JOIN detalle_venta ON producto.id = detalle_venta.id_producto
            INNER JOIN venta ON venta.id = detalle_venta.id_venta
            WHERE (id_venta = $term AND venta.status = 1)";

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    if (!$fila) echo 0;     // En caso de no encontrar coincidencias

    else {                  // En caso de encontrar coincidencias, imprime todas
        $output .= '
        <header class="modal-card-head">
            <p class="modal-card-title">Registro Movimiento Venta</p>
            <button class="delete exit-modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body ">
            <p class="title">
                Venta
            </p>
            <div class="columns">
                <p class="column subtitle has-text-info">
                    ID - Descripcion
                </p>
                <p class="column subtitle has-text-info has-text-centered">
                    Cantidad
                </p>
            </div>
            <p class="subtitle">
        ';
        $id_venta;
        for ($i = $fila; $f = $res->fetch_object(); $i--) {
            $id_venta = $f->id_venta;
        $output .= '
        <div class="'. $f->id_venta .'">
            <div id="'.$f->id_producto.'" class="row columns is-multiline">
                <div class="column">
                    <p class="subtitle">'. $f->id_producto.' - '.$f->descripcion .'</p>
                </div>
                <div class="column has-text-centered">
                    <p class="subtitle">'. $f->cantidad .'</p>
                </div>
            </div>
        </div>
        ';
        }
        $output .= '
            </p>
            </section>
            <footer class="modal-card-foot">
                <button id="'. $id_venta .'" class="regMovVenta button">Registrar Movimiento</button>
            </footer>
        ';
        echo $output;
    }

?>