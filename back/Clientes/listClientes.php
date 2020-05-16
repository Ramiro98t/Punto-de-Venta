<?php
    require_once('../conecta.php');  //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
    
    // Bandera que indica si es busqueda o muestra la lista completa
    $flag = $_POST["flag"];    

    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    if($flag) {
         // Consulta MySql por busqueda
        $sql = "SELECT * FROM cliente WHERE (nombre LIKE LOWER('%$term%') 
        OR telefono LIKE LOWER('%$term%') OR email LIKE LOWER('%$term%') 
        AND status = 1) ORDER BY id DESC";
    }

    // Muestra la lista completa
    else {
        // Consulta MySql general
        $sql = "SELECT * FROM cliente WHERE status = 1 ORDER BY id DESC";
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
                            <p class="title has-text-primary">' . ucwords($f->nombre) . '</p>
                        </div>

                        <div class="content">
                            <p class="title is-4">Tel: ' . $f->telefono . '</p>
                            <p class="subtitle is-5">Correo: ' . $f->email . '</p>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        echo $output;
    }

?>