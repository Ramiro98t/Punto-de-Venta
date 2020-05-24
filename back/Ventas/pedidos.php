<?php
    require_once('../conecta.php'); //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
     
    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    $sql = "SELECT empleado.id AS id_e, empleado.nombre AS nombre_e, 
            cliente.id AS id_c, cliente.nombre AS nombre_c, cliente.email,
            venta.fecha, venta.id AS id_venta FROM venta 
            INNER JOIN empleado ON empleado.id = venta.id_empleado 
            INNER JOIN cliente ON cliente.id = venta.id_cliente 
            WHERE (venta.status = 2 AND (venta.id LIKE '%$term%' OR cliente.email LIKE '%$term%'))";

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    if (!$fila) echo 0;     // En caso de no encontrar coincidencias

    else {                  // En caso de encontrar coincidencias, imprime todas
        for ($i = $fila; $f = $res->fetch_object(); $i--) {
        $output .= '
        <div class="column is-one-quarter">
            <div class="card">
                <div class="card-content">
                    <div class="media">
                        <div class="media-left">
                            <p class="title has-text-primary">ID Venta: ' . $f->id_venta . '</p>
                        </div>
                    </div>
                            
                    <div class="content">
                        <p class="fecha title">' . $f->fecha . '</p>
                        <p class="subtitle has-text-info">Cliente: ' . $f->id_c . ' - '.$f->nombre_c.'</p>
                        <p class="subtitle">Empleado: ' . $f->id_e . ' - ' . $f->nombre_e . '</p>
                        <p class="help has-text-grey">' . $f->email . '</p>
                    </div>
                </div>
                <footer id="' .$f->id_venta. '" class="card-footer">
                    <a class="unit button card-footer-item is-primary is-light">
                        <span>Productos</span>
                        <span class="icon">
                            <i class="fas fa-list"></i>
                        </span>
                    </a>
                </footer>
            </div>
        </div>
        ';
        }
        echo $output;
    }

?>