<?php
require_once('./conecta.php');  //Conecta a la Base de datos
require('../fpdf/fpdf.php');
session_start();

$worker = $_SESSION['user'];
$date = date('d-m-Y');
$id_venta = $_GET['id_v'];

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
$fpdf->Text(10, 34, "__________________________________________________");

// Info de venta
$fpdf->SetFont('Arial', '', 7);
$fpdf->Text(13, 34, "Caja: Ventas03");
$fpdf->Text(37, 34, "Fecha: $date");
$fpdf->Text(65, 34, "Empleado: $worker");

// Info del pedido
$fpdf->Text(11, 40, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");
$fpdf->Text(15, 40, "Piezas");
$fpdf->Text(40, 40, "Descripcion");
$fpdf->Text(75, 40, "Precio");
$fpdf->Text(11, 100, "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _");

// Productos
$sql = "SELECT producto.*, venta_producto.* FROM venta_producto INNER JOIN
        producto ON venta_producto.id_producto = producto.id WHERE id_venta='$id_venta' AND cantidad != 0";
$res  = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
$fila = mysqli_num_rows($res);      // Obtiene el numero de filas

$rPx = 44;
$subtotal = 0;
for ($i = $fila; $f = $res->fetch_object(); $i--) {
    $money = $f->cantidad * $f->precio;
    $subtotal += $money;
    $fpdf->Text(15, $rPx, "$f->cantidad pz");
    $fpdf->Text(40, $rPx, "$f->descripcion");
    $fpdf->Text(75, $rPx, "$$money");
    $rPx+=3;
}
// Metodo de pago y Total
$fpdf->Text(12, 104, "Metodo de pago: Efectivo");
$fpdf->Text(60, 104, "Subtotal: $$subtotal");
$desc = $subtotal * 0.05;
if($desc){
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
$sql = "SELECT ventas.*, SUM(cantidad) AS total FROM venta_producto
                INNER JOIN ventas ON venta_producto.id_venta = ventas.id WHERE status = 0";    // Suma la cantidad total de articulos en el pedido
        $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
        $cant = $res->fetch_object();
        $cant = $cant->total;            // Se le asigna el campo de retorno del query
$fpdf->Text(45, 133, "Articulos: $cant");


// $fpdf->Cell(0, 5, "Este es el ticket");
$fpdf->Output();
