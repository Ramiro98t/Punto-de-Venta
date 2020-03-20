<?php
require_once('../conecta.php'); //Conecta a la Base de datos

$output = '';                   // Almacena los resultados 

// Consulta MySql general
$sql = "SELECT * FROM proveedor ORDER BY id DESC";
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
                            <p class="title is-1 has-text-primary">' . $f->nombre . '</p>
                        </div>
                        <div class="media-content">
                            <p class="title is-4">' . $f->telefono . '</p>
                        </div>
                    </div>

                    <div class="content">
                        Email: ' . $f->correo . '
                    </div>
                </div>
            </div>
        </div>
        ';
    }
    echo $output;
}