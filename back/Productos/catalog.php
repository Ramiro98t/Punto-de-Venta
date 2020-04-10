<?php
    require_once('../conecta.php'); //Conecta a la Base de datos

    $term = $_POST["search"];       // Termino a buscar
    
    // Bandera que indica si es busqueda o muestra la lista completa
    $flag = $_POST["flag"];         
    
    $output = '';                   // Almacena los resultados 

    // Si es busqueda
    if($flag){
        // Consulta MySql por busqueda
        $sql = "SELECT * FROM producto WHERE (id LIKE '%$term%' OR descripcion LIKE '%$term%' 
        OR departamento LIKE'%$term%') AND status = 1 AND existencia > 0 ORDER BY id DESC";
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
                    <div class="media">
                        <div class="media-left">
                            <p class="title has-text-primary">$' . $f->precio . '</p>
                        </div>
                    </div>
                            
                    <div class="content">
                        <p class="title">' . $f->departamento . '</p>
                        <p class="subtitle has-text-info">Existencia: ' . $f->existencia . '</p>
                        <p class="subtitle"> Detalles: ' . $f->descripcion . '</p>
                    </div>
                </div>
                <footer id="' .$f->id. '" class="card-footer">
                    <a class="addBtn button card-footer-item is-primary is-light">
                        <span>Añadir al carrito</span>
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