<?php
require_once('./conecta.php');  //Conecta a la Base de datos
require('../fpdf/fpdf.php');
session_start();

$id_worker = $_SESSION['id_user'];
$worker = $_SESSION['user'];

$id_client = $_SESSION['id_client'];
$client = $_SESSION['client']; 

$date = date('d-m-Y');
$tipo = $_GET['type'];          
$arr = explode(',',trim($tipo));

$tipo = $arr[0];
if($tipo == 0){
    $efectivo = (float)$arr[1];
    $efectivoB = (float)$arr[2];
    $creditoB = (float)$arr[3];
    $tarjeta = (float)$arr[4];
    $subtotal = (float)$arr[5];
    $descuento = 0;
}
else {
    $subtotal = 0;
} 

// Concepto de ticket, Venta o Devolucion
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
$fpdf->Text(65, 34, "Empleado: $id_worker, $worker");
if($tipo == 0)
$fpdf->Text(65, 37, "Cliente: $id_client, $client");


// Info del pedido
$fpdf->Text(11, 44, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");
$fpdf->Text(15, 44, "Piezas");
if ($tipo == 0) {
    // Venta
    $fpdf->Text(30, 44, "Descripcion");
    $fpdf->Text(60, 44, "Precio");
} else {
    // Devolucion
    $fpdf->Text(30, 44, "Descripcion");
    $fpdf->Text(55, 44, "Motivo");
}
$fpdf->Text(75, 44, "Monto");
$fpdf->Text(11, 100, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");

// Venta
if ($tipo == 0) {
    $sql = "SELECT * FROM venta ORDER BY id DESC LIMIT 1";
    $res  = mysqli_query($con, $sql);   // Hace consulta con la conexion establecida
    
    $venta = $res->fetch_object();
    $metodoPago = $venta->pago;
    $descuento = $venta->disc;
    $venta = $venta->id;
    
    $sql = "SELECT *, detalle_venta.precio AS importe FROM detalle_venta INNER JOIN producto 
            ON producto.id = detalle_venta.id_producto WHERE(id_venta = '$venta')";
    $res  = mysqli_query($con, $sql);   // Hace consulta con la conexion establecida
    $fpdf->Text(40, 97, "Folio movimiento: $venta");
    
}
// Devolucion
else {
    $sql = "SELECT id FROM devolucion ORDER BY id DESC LIMIT 1";
    $res  = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
    
    $devolucion = $res->fetch_object();
    $devolucion = $devolucion->id;
    
    $sql = "SELECT detalle_devolucion.cantidad, producto.descripcion, 
            detalle_devolucion.motivo, detalle_venta.precio FROM detalle_devolucion 
            INNER JOIN devolucion ON detalle_devolucion.id_devolucion = devolucion.id
            INNER JOIN detalle_venta ON detalle_venta.id_producto = detalle_devolucion.id_producto 
            AND devolucion.id_venta = detalle_venta.id_venta
            INNER JOIN producto ON producto.id = detalle_devolucion.id_producto
            WHERE(id_devolucion = '$devolucion')";
    $res  = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida

    $fpdf->Text(40, 97, "Folio movimiento: $devolucion");
}
$fila = mysqli_num_rows($res);      // Obtiene el numero de filas

$yValue = 48;
for ($i = $fila; $f = $res->fetch_object(); $i--) {
    if ($tipo == 0) {       // Ventas
        $money = $f->cantidad * $f->importe;
        $fpdf->Text(30, $yValue, "$f->descripcion");
        $fpdf->Text(60, $yValue, "$f->precio");
    } else {                // Devolucion
        // PENDIENTE //
        $money = $f->cantidad * $f->precio;
        $subtotal += $money;
        $fpdf->Text(30, $yValue, "$f->descripcion");
        $fpdf->Text(55, $yValue, "$f->motivo");
    }
    $fpdf->Text(15, $yValue, "$f->cantidad pz");
    $fpdf->Text(75, $yValue, "$$money");
    $yValue += 3;
}

// Ventas
if ($tipo == 0) {
    $ahorro = $descuento*$subtotal;
    // Metodo de pago y Subtotal
    $fpdf->Text(12, 104, "Metodo de pago: $metodoPago");
    $fpdf->Text(60, 104, "Subtotal: $$subtotal");
    $iva = round(($subtotal-$ahorro) * 0.16);

    $total = ($subtotal-$ahorro) + $iva;
    $descuento *= 100;
    $fpdf->Text(60, 107, "Descuento: $descuento%");
    $fpdf->Text(60, 110, "IVA: 16%: - $$iva");
    $fpdf->Text(60, 113, "Total: $$total");

    if($efectivo != 0){
        $moneyOut = $efectivo - $total;
        $fpdf->Text(60, 119, "Efectivo Recibido: $$efectivo");
    }

    else if($tarjeta != 0) {
        $fpdf->Text(60, 116, "Credito Recibido: $$total");
        $moneyOut = 0;
    }
    
    else {
        $moneyOut = ($creditoB+$efectivoB) - $total;
        $fpdf->Text(60, 116, "Credito Recibido: $$creditoB");
        $fpdf->Text(60, 119, "Efectivo Recibido: $$efectivoB");
    }
    $fpdf->Text(60, 122, "Cambio: -$$moneyOut");

    // Disclaimer: Para cualquier duda o aclaracion presentar su ticket de compra.
    $fpdf->Text(10, 110, "Favor de Conservar este ticket.");
    $fpdf->Text(10, 113, "Para cualquier duda o aclaracion");
    $fpdf->Text(10, 116, "sera necesario presentar su ticket");
    $fpdf->Text(10, 119, "de compra, no mayor a 30 dias");
    $fpdf->Text(10, 122, "desde su fecha de expedicion");

    // Usted ahorro y numero de Articulos
    if(!$tarjeta){
        $fpdf->Text(40, 130, "Usted ahorro: $$ahorro");
    }
    $sql = "SELECT venta.id, SUM(cantidad) AS total FROM detalle_venta
            INNER JOIN venta ON detalle_venta.id_venta = venta.id WHERE(id = '$venta')";    // Suma la cantidad total de articulos en el pedido
    $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
    $cant = $res->fetch_object();
    $cant = $cant->total;            // Se le asigna el campo de retorno del query
    $fpdf->Text(45, 133, "Articulos: $cant pz");
}

// Devolucion
else {
    // Disclaimer: Para cualquier duda o aclaracion presentar su ticket de compra.
    $fpdf->Text(10, 110, "Favor de Conservar este ticket.");
    $fpdf->Text(10, 113, "Para cualquier duda o aclaracion");
    $fpdf->Text(10, 116, "sera necesario presentar su ticket");
    $fpdf->Text(10, 119, "de compra, no mayor a 30 dias");
    $fpdf->Text(10, 122, "desde su fecha de expedicion");

    $fpdf->Text(60, 107, "Monto a Devolver: $$subtotal");

    // Articulos 
    $sql = "SELECT devolucion.id, SUM(cantidad) AS total FROM detalle_devolucion
            INNER JOIN devolucion ON detalle_devolucion.id_devolucion = devolucion.id WHERE(id = '$devolucion')";    // Suma la cantidad total de articulos en el pedido
    $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
    $cant = $res->fetch_object();
    $cant = $cant->total;            // Se le asigna el campo de retorno del query
    $fpdf->Text(45, 133, "Articulos: $cant pz");
}

$fpdf->Output();
