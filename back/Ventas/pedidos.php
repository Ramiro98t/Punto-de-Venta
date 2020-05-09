<?php
    require_once('../conecta.php'); //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
     
    
    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    $sql = "SELECT ventas.id AS id_venta, ventas.fecha, ventas.id_empleado, cliente.email, cliente.nombre
            FROM cliente INNER JOIN ventas ON cliente.id = ventas.id_cliente
            WHERE (ventas.id LIKE '%$term%' OR email LIKE '%$term%')";

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
                        <p class="title">' . $f->email . '</p>
                        <p class="subtitle has-text-info">Fecha: ' . $f->fecha . '</p>
                        <p class="subtitle"> ID Empleado: ' . $f->id_empleado . '</p>
                    </div>
                </div>
                <footer id="' .$f->id_venta. '" class="card-footer">
                    <a class="todo button card-footer-item is-primary is-light">
                        <span>Todo</span>
                        <span class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </span>
                    </a>
                    <a class="unit button card-footer-item is-primary is-light">
                        <span>Unitario</span>
                        <span class="icon">
                            <i class="fas fa-shopping-cart"></i>
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