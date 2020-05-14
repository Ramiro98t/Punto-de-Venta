<?php
require_once('./conecta.php');  //Conecta a la Base de datos
require('../fpdf/fpdf.php');
session_start();

$worker = $_SESSION['user'];
$date = date('d-m-Y');
$tipo = $_GET['type'];          // 0 -> Venta, 1 -> Devolucion

$concepto = $tipo == 0 ? "Venta" : "Devolucion";

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
$fpdf->Text(45, 29, "Concepto: $concepto");
$fpdf->Text(10, 34, "__________________________________________________");

// Info de movimiento
$fpdf->SetFont('Arial', '', 7);
$fpdf->Text(13, 34, "Caja: Ventas03");
$fpdf->Text(37, 34, "Fecha: $date");
$fpdf->Text(65, 34, "Empleado: $worker");


// Info del pedido
$fpdf->Text(11, 40, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");
$fpdf->Text(15, 40, "Piezas");
if ($tipo == 0) {
    // Venta
    $fpdf->Text(40, 40, "Descripcion");
} else {
    $fpdf->Text(30, 40, "Descripcion");
    $fpdf->Text(55, 40, "Motivo");
}
$fpdf->Text(75, 40, "Monto");
$fpdf->Text(11, 100, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");

// Venta
if ($tipo == 0) {
    $sql = "SELECT * FROM ventas ORDER BY id DESC LIMIT 1";
    $res  = mysqli_query($con, $sql);   // Hace consulta con la conexion establecida
    
    $venta = $res->fetch_object();
    $metodoPago = $venta->pago;
    $venta = $venta->id;
    
    $sql = "SELECT * FROM venta_producto INNER JOIN producto 
            ON producto.id = venta_producto.id_producto WHERE(id_venta = '$venta')";
    $res  = mysqli_query($con, $sql);   // Hace consulta con la conexion establecida
    $fpdf->Text(40, 97, "Folio movimiento: $venta");
    
}
// Devolucion
else {
    $sql = "SELECT id FROM devolucion ORDER BY id DESC LIMIT 1";
    $res  = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
    
    $devolucion = $res->fetch_object();
    $devolucion = $devolucion->id;
    
    $sql = "SELECT * FROM detalle_devolucion INNER JOIN producto 
            ON producto.id = detalle_devolucion.id_producto WHERE(id_devolucion = '$devolucion')";
    $res  = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
    $fpdf->Text(40, 97, "Folio movimiento: $devolucion");
}
$fila = mysqli_num_rows($res);      // Obtiene el numero de filas

$rPx = 44;
$subtotal = 0;
for ($i = $fila; $f = $res->fetch_object(); $i--) {
    $money = $f->cantidad * $f->precio;
    $subtotal += $money;
    if ($tipo == 0) {
        // Ventas
        $fpdf->Text(40, $rPx, "$f->descripcion");
    } else {
        // Devolucion
        $fpdf->Text(30, $rPx, "$f->descripcion");
        $fpdf->Text(55, $rPx, "$f->motivo");
    }
    $fpdf->Text(15, $rPx, "$f->cantidad pz");
    $fpdf->Text(75, $rPx, "$$money");
    $rPx += 3;
}

if ($tipo == 0) {
    // Ventas
    // Metodo de pago y Total
    $fpdf->Text(12, 104, "Metodo de pago: $metodoPago");
    $fpdf->Text(60, 104, "Subtotal: $$subtotal");
    $desc = $subtotal * 0.05;
    if ($desc) {
        $subtotal -= $desc;
    }
    $iva = $subtotal * 0.16;

    $total = $subtotal + $iva;
    $fpdf->Text(60, 107, "Descuento: 5%: $$desc");
    $fpdf->Text(60, 110, "IVA: 16%: $$iva");
    $fpdf->Text(60, 113, "Total: $$total");

    $moneyIn = 400.00;
    $moneyOut = $moneyIn - $total;
    $fpdf->Text(60, 119, "Recibido: $$moneyIn");
    $fpdf->Text(60, 122, "Cambio: -$$moneyOut");

    // Disclaimer: Para cualquier duda o aclaracion presentar su ticket de compra.
    $fpdf->Text(10, 110, "Favor de Conservar este ticket.");
    $fpdf->Text(10, 113, "Para cualquier duda o aclaracion");
    $fpdf->Text(10, 116, "sera necesario presentar su ticket");
    $fpdf->Text(10, 119, "de compra, no mayor a 30 dias");
    $fpdf->Text(10, 122, "desde su fecha de expedicion");

    // Usted ahorro y numero de Articulos
    $fpdf->Text(40, 130, "Usted ahorro: $$desc");
    $sql = "SELECT ventas.id, SUM(cantidad) AS total FROM venta_producto
            INNER JOIN ventas ON venta_producto.id_venta = ventas.id WHERE(id = '$venta')";    // Suma la cantidad total de articulos en el pedido
    $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
    $cant = $res->fetch_object();
    $cant = $cant->total;            // Se le asigna el campo de retorno del query
    $fpdf->Text(45, 133, "Articulos: $cant pz");
}
else {
    // Disclaimer: Para cualquier duda o aclaracion presentar su ticket de compra.
    $fpdf->Text(10, 110, "Favor de Conservar este ticket.");
    $fpdf->Text(10, 113, "Para cualquier duda o aclaracion");
    $fpdf->Text(10, 116, "sera necesario presentar su ticket");
    $fpdf->Text(10, 119, "de compra, no mayor a 30 dias");
    $fpdf->Text(10, 122, "desde su fecha de expedicion");

    $fpdf->Text(60, 107, "Monto Devuelto: $$subtotal");

    // Articulos 
    $sql = "SELECT devolucion.id, SUM(cantidad) AS total FROM detalle_devolucion
            INNER JOIN devolucion ON detalle_devolucion.id_devolucion = devolucion.id WHERE(id = '$devolucion')";    // Suma la cantidad total de articulos en el pedido
    $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
    $cant = $res->fetch_object();
    $cant = $cant->total;            // Se le asigna el campo de retorno del query
    $fpdf->Text(45, 133, "Articulos: $cant pz");
}

// $fpdf->Cell(0, 5, "Este es el ticket");
$fpdf->Output();
