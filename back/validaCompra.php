<?php
    require_once('./conecta.php'); // Conecta a la Base de datos

    // Modificacion individual
        $sql = "UPDATE ventas SET status = 1
                WHERE status = 0";
    $res = mysqli_query($con, $sql);
?>