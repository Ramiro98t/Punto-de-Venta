<?php
require_once('./conecta.php');  // Conecta a la Base de datos

$term = $_POST["search"];       // Termino a buscar

$output = '';                   // Almacena los resultados 

// Consulta MySql por busqueda
$sql = "SELECT * FROM empleado WHERE nombre LIKE '%$term%' OR ciudad LIKE '%$term%' 
OR cargo LIKE'%$term%' AND status = 1 ORDER BY id DESC";
$res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
$fila = mysqli_num_rows($res);      // Obtiene el numero de filas

if (!$fila) echo 0;

else {
    for ($i = $fila; $f = $res->fetch_object(); $i--) {
        $output .= '
        <div class="column is-one-quarter">
            <div class="card">
                <div class="card-content">
                    <div class="media">
                        <div class="media-left">
                            <p class="title is-1 has-text-primary">' . $f->nombre . '</p>
                        </div>
                        <div class="media-content">
                            <p class="title is-4">' . $f->ciudad . '</p>
                            <p class="subtitle is-6">Tel: ' . $f->telefono . '</p>
                        </div>
                    </div>

                    <div class="content">
                        Cargo: ' . $f->cargo . '
                    </div>
                </div>
            </div>
        </div>
        ';
    }
    echo $output;
}
