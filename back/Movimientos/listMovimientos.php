<?php
    require_once('../conecta.php');     //Conecta a la Base de datos

    $term = $_POST["search"];           // Termino a buscar
    $motivo = $_POST["type"];           // Tipo de Movimiento a buscar
    
    // Bandera que indica si es busqueda o muestra la lista completa
    $flag = $_POST["flag"];    
    
    $output = '';                       // Almacena los resultados 

    // Si es busqueda
    if ($flag) {
        $sql = "SELECT movimiento.id, movimiento.fecha, empleado.nombre, empleado.id AS id_e,
        movimiento.id_mov_asoc FROM movimiento INNER JOIN empleado 
        ON movimiento.id_empleado = empleado.id WHERE (movimiento.motivo = $motivo AND movimiento.id LIKE '%$term%')";
    }

    // Muestra la lista completa
    else {
        $sql = "SELECT movimiento.id, movimiento.fecha, empleado.nombre, empleado.id AS id_e,
        movimiento.id_mov_asoc FROM movimiento INNER JOIN empleado 
        ON movimiento.id_empleado = empleado.id WHERE (movimiento.motivo = $motivo)";
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
                        <p class="title has-text-primary">ID Movimiento: ' . $f->id . '</p>
                    </div>
                            
                    <div class="content">
                        <p class="title">' . $f->fecha . '</p>
                        <p class="subtitle has-text-info">Empleado: '.$f->id_e.' - ' . $f->nombre . '</p>
                    </div>
                    <p class="help has-text-grey">Folio Generador: '.$f->id_mov_asoc.'</p>
                </div>
                <footer id="movimiento" class="card-footer">
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
