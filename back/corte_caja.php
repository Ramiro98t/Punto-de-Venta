<?php
require_once('./conecta.php');  //Conecta a la Base de datos
require('../fpdf/fpdf.php');
session_start();

$date = new DateTime(null, new DateTimeZone(date_default_timezone_get()));
$date->setTimeZone(new DateTimeZone('America/Mexico_City'));

$fecha = $date->format("d-m-Y");
$hora = $date->format("H:i:s");

// Crea documento
$fpdf = new FPDF('P', 'mm', array(100, 150));

$fpdf->AddPage();
// Info principal
$fpdf->SetFont('Arial', '', 8);
$fpdf->Image('../img/icon.png', 10, 10, 18);
$fpdf->Text(36, 14, "Seminario de Solucion de Problemas");
$fpdf->Text(42, 17, "de Ingenieria de Software");
$fpdf->Text(32, 20, "Blvd. Gral. Marcelino Garcia Barragan 1421");
$fpdf->Text(38, 23, "Olimpica, 44430 Guadalajara, Jal.");
$fpdf->Text(45, 26, "Telefono: 3311223344");
$fpdf->Text(10, 28, "__________________________________________________");

// Info de movimiento
$fpdf->SetFont('Arial', '', 7);

// Ventas
$sql = "SELECT * FROM venta";
$res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
$fila = mysqli_num_rows($res);      // Obtiene el numero de filas

$fpdf->Text(11, 34, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");
$fpdf->Text(22, 37, "VENTAS");
$fpdf->Text(11, 38, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");
$fpdf->Text(11, 40, "________________________");
$fpdf->Text(11, 43, "|  Folio  |  Met. Pago  |  Total  |");
$fpdf->Text(11, 43, "________________________");

$y = 46;
$total = 0;
for ($i = $fila; $f = $res->fetch_object(); $i--) {
    $total_v = getTotalVenta($f->id);
    $total_v += ($total_v * 0.16);
    if ($f->pago == "efectivo") {
        $total += $total_v;
    }
    
    $fpdf->Text(11, $y, "  $f->id");
    $fpdf->Text(20, $y, "|  $f->pago");
    $fpdf->Text(34, $y, "|  $total_v");
    $fpdf->Text(11, $y, "________________________");
    $y += 3;
}

$vouchers = $_SESSION['vouchers'];
$fpdf->Text(11, $y, " Total Vauchers");
$fpdf->Text(34, $y, "|  $vouchers");
$fpdf->Text(11, $y, "________________________");
$y += 3;

$fpdf->Text(11, $y, " Total Efectivo");
$fpdf->Text(34, $y, "|  $total");
$fpdf->Text(11, $y, "________________________");
$y += 3;

// Devolucion
$sql = "SELECT devolucion.id, venta.pago 
        FROM devolucion INNER JOIN venta ON devolucion.id_venta = venta.id";
$res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
$fila = mysqli_num_rows($res);      // Obtiene el numero de filas

$fpdf->Text(11, $y+=3, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");
$fpdf->Text(17, $y+=3, "DEVOLUCIONES");
$fpdf->Text(11, $y+=2, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");
$fpdf->Text(11, $y+=2, "________________________");
$fpdf->Text(11, $y+=3, "|  Folio  |  Met. Pago  |  Total  |");
$fpdf->Text(11, $y, "________________________");

$y += 3;

$totalDev = 0;
for ($i = $fila; $f = $res->fetch_object(); $i--) {
    $total_d = getTotalDevolucion($f->id);
    $totalDev += $total_d;
    
    $fpdf->Text(11, $y, "  $f->id");
    $fpdf->Text(20, $y, "|  $f->pago");
    $fpdf->Text(34, $y, "|  $total_d");
    $fpdf->Text(11, $y, "________________________");
    $y += 3;
}
$fpdf->Text(11, $y, " Total Efectivo");
$fpdf->Text(34, $y, "|  $totalDev");
$fpdf->Text(11, $y, "________________________");

// FLujos de efectivo
$sql = "SELECT * FROM flujo_efectivo";
$res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
$fila = mysqli_num_rows($res);      // Obtiene el numero de filas

$y += 3;
$fpdf->Text(11, $y+=3, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");
$fpdf->Text(17, $y+=3, "FLUJO EFECTIVO");
$fpdf->Text(11, $y+=2, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");
$fpdf->Text(11, $y+=2, "________________________");
$fpdf->Text(11, $y+=3, "| Folio | Cantidad Entregada  |");
$fpdf->Text(11, $y, "________________________");

$y += 3;

$totalFlu = 0;
for ($i = $fila; $f = $res->fetch_object(); $i--) {
    $entregado = $f->monto;
    $totalFlu += $entregado;
    $fpdf->Text(11, $y, "  $f->id");
    $fpdf->Text(18, $y, "|           $entregado");
    $fpdf->Text(11, $y, "________________________");
    $y += 3;
}
$fpdf->Text(11, $y, " Total Entregado");
$fpdf->Text(34, $y, "|  $totalFlu");
$fpdf->Text(11, $y, "________________________");

// Extras
// Fecha
$fpdf->Text(52, 32, "__________________________");
$fpdf->Text(52, 35, "|  Fecha de corte: ");
$fpdf->Text(72, 35, "| $fecha ");

// Hora
$fpdf->Text(52, 35, "__________________________");
$fpdf->Text(52, 38, "|  Hora de corte:  ");
$fpdf->Text(72, 38, "| $hora ");
$fpdf->Text(52, 38, "__________________________");

// Efectivo y Vouchers
$fpdf->Text(50, 50, "___________________________");
$fpdf->Text(50, 53, "| Efectivo Corte ");
$fpdf->Text(68, 53, "| Vouchers Corte |");
$fpdf->Text(50, 53, "___________________________");

$fpdf->Text(50, 53, "___________________________");
$fpdf->Text(50, 56, " $total ");
$fpdf->Text(68, 56, "| $vouchers ");
$fpdf->Text(50, 56, "___________________________");


// Recibe 
$fpdf->Text(50, 70, "___________________________");
$fpdf->Text(63, 70, " Recibe ");
$fpdf->Text(50, 73, " Nombre ");
$fpdf->Text(68, 73, "| Firma ");
$fpdf->Text(50, 73, "___________________________");

$fpdf->Text(50, 73, "___________________________");

$y2 = 73;
for ($i=0; $i < 5; $i++) { 
    $y2 += 2;
    $fpdf->Text(68, $y2, "|");
}
$fpdf->Text(50, 84, "___________________________");

// Entrega 
$fpdf->Text(50, 95, "___________________________");
$fpdf->Text(63, 95, " Entrega ");
$fpdf->Text(50, 98, " Nombre ");
$fpdf->Text(68, 98, "| Firma ");
$fpdf->Text(50, 98, "___________________________");
$fpdf->Text(50, 98, "___________________________");

$y2 = 98;
for ($i=0; $i < 5; $i++) { 
    $y2 += 2;
    $fpdf->Text(68, $y2, "|");
}
$fpdf->Text(50, 109, "___________________________");


session_destroy();              // Destruye toda la información asociada con la sesión actual.
$fpdf->Output();

function getTotalVenta($id_v)
{
    require('./conecta.php');  //Conecta a la Base de datos
    $total = 0;

    $sql = "SELECT * FROM detalle_venta INNER JOIN venta 
    ON detalle_venta.id_venta = venta.id WHERE(id = '$id_v')";    // Suma la cantidad total de articulos en el pedido
    $res = mysqli_query($con, $sql);

    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    for ($i = $fila; $f = $res->fetch_object(); $i--) {
        $cant = $f->cantidad;
        $precio = $f->precio;
        
        $total += ($cant * $precio);
    }

    return $total;
}

function getTotalDevolucion($id_d)
{
    require('./conecta.php');  //Conecta a la Base de datos
    $total = 0;

    $sql = "SELECT detalle_devolucion.id_devolucion, detalle_devolucion.cantidad, detalle_venta.precio 
            FROM devolucion INNER JOIN venta ON devolucion.id_venta = venta.id
            INNER JOIN detalle_devolucion ON detalle_devolucion.id_devolucion = devolucion.id
            INNER JOIN detalle_venta ON detalle_venta.id_venta = venta.id
            WHERE(id_devolucion = '$id_d');";
    $res = mysqli_query($con, $sql);

    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    for ($i = $fila; $f = $res->fetch_object(); $i--) {
        $cant = $f->cantidad;
        $precio = $f->precio;
        
        $total += ($cant * $precio);
    }

    return $total;
}
