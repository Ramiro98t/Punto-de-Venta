<?php
    require_once('../conecta.php');  //Conecta a la Base de datos
    
    $term = $_POST["search"];       // Termino a buscar
    $output = '';                   // Almacena los resultados 
    
    $subtotal = 0;
    $total = 0;

    // Consulta MySql general
    $sql = "SELECT producto.*, detalle_venta.precio AS importe, 
            detalle_venta.cantidad, venta.disc FROM detalle_venta 
            INNER JOIN producto ON detalle_venta.id_producto = producto.id 
            INNER JOIN venta ON detalle_venta.id_venta = venta.id 
            WHERE id_venta = $term";

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    if (!$fila) echo 0;     // En caso de no encontrar coincidencias


    else {                  // En caso de encontrar coincidencias, imprime todas
        $output .='
        <p class="title">
            ID Venta: '. $term .'
        </p>
        <div class="columns">
            <p class="column subtitle is-three-fifths has-text-info">
                ID - Descripcion
            </p>
            <p class="column subtitle is-one-fifth has-text-info">
                Cantidad
            </p>
            <p class="column subtitle is-one-fifth has-text-info">
                Importe
            </p>
        </div>
        <div class="detalle-venta columns is-multiline">
        ';
        for ($i = $fila; $f = $res->fetch_object(); $i--) {
            $subtotal += $f->cantidad * $f->precio;
            $disc = $f->disc;
            $total += $f->cantidad * $f->importe;
            $output .= '
            <p class="column is-three-fifths">
                '. $f->id .' - '. $f->descripcion .'
            </p>
            <p class="column is-one-fifth has-text-centered">
                '. $f->cantidad .'
            </p>
            <p class="column is-one-fifth">
                $'. $f->importe .'
            </p>
            ';
        }
        $output .='
            </div>
            <p class="help has-text-grey">
                Subtotal: $'.$subtotal.', 
                IVA: 16%,
                Descuento: '.($disc*100).'%, 
                Total: $'.($total+=($total*0.16)).'

            </p>
        ';
        echo $output;
    }

?>