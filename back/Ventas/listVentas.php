<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
    
    // Bandera que indica si es busqueda o muestra la lista completa
    $flag = $_POST["flag"];    
    
    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    if ($flag) {
        $sql = "SELECT venta.id, venta.fecha, empleado.nombre, empleado.id AS id_v,
                cliente.id AS id_c, cliente.nombre AS nombre_c 
                FROM venta JOIN empleado ON venta.id_empleado = empleado.id
                INNER JOIN cliente ON venta.id_cliente = cliente.id 
                WHERE (venta.id LIKE '%$term%' OR empleado.nombre LIKE '%$term%'
                OR venta.fecha LIKE '%$term%')";
    }

    // Muestra la lista completa
    else {
        $sql = "SELECT venta.id, venta.fecha, empleado.nombre, empleado.id AS id_v,
                cliente.id AS id_c, cliente.nombre AS nombre_c 
                FROM venta INNER JOIN empleado ON venta.id_empleado = empleado.id
                INNER JOIN cliente ON venta.id_cliente = cliente.id";
    }

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
                        <p class="title has-text-primary">ID Venta: ' . $f->id . '</p>
                    </div>
                            
                    <div class="content">
                        <p class="title">' . $f->fecha . '</p>
                        <p class="subtitle has-text-info">Empleado: ' . $f->id_v . ' - ' . $f->nombre . '</p>
                        <p class="subtitle has-text-info">Cliente: ' . $f->id_c . ' - ' . $f->nombre_c . '</p>
                    </div>
                </div>
                <footer id="venta" class="card-footer">
                    <a id="' .$f->id. '" class="details button card-footer-item is-primary is-light">
                        <span>Detalles</span>
                        <span class="icon">
                            </i><i class="fas fa-info-circle"></i>
                        </span>
                    </a>
                </footer>
            </div>
        </div>
        ';
        }
        echo $output;
    }
