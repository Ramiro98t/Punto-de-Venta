<?php
    require_once('./conecta.php');  //Conecta a la Base de datos
    session_start();

    $efectivo = $_SESSION['caja'];
    $empleado = $_SESSION['id_user'];

    $date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
    $date->setTimeZone(new DateTimeZone('America/Mexico_City'));

    $fecha = $date->format("d-m-Y");
    $hora = $date->format("H:i:s");

    $_SESSION['caja'] = 0;

    // Inserta el registro de flujo de efectivo
    $sql = "INSERT INTO flujo_efectivo VALUES
    (0, '$fecha', '$hora', '$empleado', '$efectivo')";
    $res = mysqli_query($con, $sql);

?>
