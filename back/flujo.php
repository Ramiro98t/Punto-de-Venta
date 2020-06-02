<?php
session_start();
require_once('../back/conecta.php');  //Conecta a la Base de datos

// Variables a considerar
$efectivo = $_POST['efectivo'];         // Efectivo
$tarjeta = $_POST['credito'];           // Ambos
$efectivoB = $_POST['efectivoB'];       // Ambos
$total = $_POST['total'];               // Total

$id_worker = $_SESSION['id_user'];
$caja = $_SESSION['caja'];
$vouchers = $_SESSION['vouchers'];

// Inicializa vouchers
if(!$vouchers) {
    $vouchers = 0;
    $_SESSION['vouchers'] = $vouchers;
}

// No hay dinero en caja, Inicializa
if(!$caja){
    $caja = 0;
    $_SESSION['caja'] = $caja;
}

// Validar que lo que haya en caja sea menor a 10,000
if($caja <= 10000){
    if ($efectivo) {                        // Efectivo
        $caja += $total;                    // Nuevo total en caja
        $_SESSION['caja'] = $caja;
    }
    
    // else if ($efectivoB && $tarjeta) {      // Ambos
    //     // Tarjeta
    //     $tarjeta;
    //     $vouchers += $tarjeta;              // Nuevo total de vouchers
    //     $_SESSION['vouchers'] = $vouchers;   
        
    //     // Efectivo
    //     $newEfectivo = ((float)$total) - ((float)$tarjeta);
    //     $caja += $newEfectivo;              // Nuevo total en caja
    //     $_SESSION['caja'] = $caja;
    // }

    else {                                  // Tarjeta
        $vouchers += $total;                // Nuevo total de vouchers
        $_SESSION['vouchers'] = $vouchers;   
    }
    // echo "Vauchers>$vouchers, Efectivo>$caja";
}

// Es necesario corte de caja
else {
    echo 1;
}

?>