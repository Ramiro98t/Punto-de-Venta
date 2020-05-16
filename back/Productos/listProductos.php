<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
    
    // Bandera que indica si es busqueda o muestra la lista completa
    $flag = $_POST["flag"];    

    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    if ($flag == "true") {
        // Consulta MySql por busqueda
        $sql = "SELECT * FROM producto WHERE (id LIKE LOWER('%$term%') 
        OR descripcion LIKE LOWER('%$term%') OR departamento LIKE LOWER('%$term%') 
        AND status = 1 AND existencia > 0) ORDER BY id DESC";
    }

    // Muestra la lista completa
    else {
        // Consulta MySql general
        $sql = "SELECT * FROM producto WHERE status = 1 AND existencia > 0 ORDER BY id DESC";
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
                        <div class="">
                            <p class="title has-text-primary">$' . $f->precio . '</p>
                        </div>

                        <div class="content">
                            <p class="title is-5">' . $f->departamento . '</p>
                            <p class="subtitle is-6">Existencia: ' . $f->existencia . '</p>
                            Detalles: ' . $f->descripcion . '
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        echo $output;
    }

?>