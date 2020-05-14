<?php 
    require_once('../conecta.php'); //Conecta a la Base de datos

    $term = $_POST["codigo"];       // Termino a buscar

    // Si es busqueda
    $sql = "SELECT * FROM descuentos WHERE (id = '$term')";

    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    if (!$fila) echo 0;     // En caso de no encontrar coincidencias

    else {
        $descuento = $res->fetch_object();
        echo $descuento->porcentaje;
    }

?>