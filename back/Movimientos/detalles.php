<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar

    $output = '';                   // Almacena los resultados 

    // Consulta MySql general
    $sql = "SELECT * FROM movimiento WHERE id = $term";

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    if (!$fila) echo 0;     // En caso de no encontrar coincidencias

    else {                  // En caso de encontrar coincidencias, imprime todas
        $obj = $res->fetch_object();
        $tipo = $obj->tipo;
        $motivo = $obj->motivo;
        $id_mov = $obj->id_mov_asoc;

        switch ($motivo) {
            case "1":           // Entrada - Compra
                $sql = "";
                break;
                
            case "2":           // Entrada - Devolucion
                $sql = "SELECT producto.descripcion, detalle_devolucion.cantidad, 
                detalle_devolucion.motivo FROM detalle_devolucion INNER JOIN producto 
                ON detalle_devolucion.id_producto = producto.id WHERE id_devolucion = $id_mov";
                break;
                
            case "3":           // Salida - Venta
                $sql = "SELECT * FROM venta_producto INNER JOIN producto 
                ON venta_producto.id_producto = producto.id WHERE id_venta = $id_mov";
                break;
                
            case "4":           // Salida - Ajuste
                $sql = "SELECT detalle_ajuste.id_ajuste, producto.descripcion, detalle_ajuste.cantidad,
                detalle_ajuste.motivo  FROM detalle_ajuste INNER JOIN ajuste 
                ON detalle_ajuste.id_ajuste = ajuste.id INNER JOIN producto 
                ON detalle_ajuste.id_producto = producto.id WHERE id_ajuste = $id_mov";
                break;                
            
            default:
                # code...
                break;
        }

        $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida

        $output .='
        <p class="title">
            ID Movimiento: '. $term .'
        </p>
        <div class="columns">
            <p class="column subtitle is-three-fifths has-text-info">
                Descripcion
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
            $motivoAux = $motivo == "3" ? "Venta" : $f->motivo;
            // if ($motivo == "3") {
            //     $motivoAux = "Venta";

            // }
            $output .= '
            <p class="column is-three-fifths">
                '. $f->descripcion .'
            </p>
            <p class="column is-one-fifths">
                '. $motivoAux .'
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
