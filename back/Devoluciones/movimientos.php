<?php
    require_once('../conecta.php'); //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    $sql = "SELECT producto.descripcion, detalle_devolucion.*, devolucion.* FROM producto 
            INNER JOIN detalle_devolucion ON producto.id = detalle_devolucion.id_producto
            INNER JOIN devolucion ON detalle_devolucion.id_devolucion = devolucion.id
            WHERE (devolucion.id = $term AND devolucion.status = 0)";

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    if (!$fila) echo 0;     // En caso de no encontrar coincidencias

    // PENDIENTE - Mostrar la informacion de la devolucion complet

    else {                  // En caso de encontrar coincidencias, imprime todas
        $output .= '
        <header class="modal-card-head">
            <p class="modal-card-title">Registro Movimiento Devolucion</p>
            <button class="delete exit-modal" aria-label="close"></button>
        </header>
        <section class="modal-card-body ">
            <p class="title">
                Devolucion
            </p>
            <p class="subtitle">
        ';
        $id_dev;
        for ($i = $fila; $f = $res->fetch_object(); $i--) {
            $id_dev = $f->id;
        $output .= '
        <div class="'. $f->id .'">
            <div id="'.$f->id_producto.'" class="row columns is-multiline">
                <div class="column">
                    <p class="subtitle">'. $f->descripcion .'</p>
                </div>
                <div class="column is-two-fifth">
                    <p class="subtitle">'. $f->motivo .'</p>
                </div>
                <div class="column is-one-fifth">
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
                <button id="'. $id_dev .'" class="regMovDev button">Registrar Movimiento</button>
            </footer>
        ';
        echo $output;
    }

?>