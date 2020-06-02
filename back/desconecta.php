<?php
    session_start();                // Gestor de sesiones

    $user = $_GET["no_user"];

    $_SESSION['id_client'] = "";
    $_SESSION['client'] = "";
    if ($user) {
        // Reinicia valores del cliente
        header("Location: ../front/mainPage.php");  // Redirecciona a pagina principal
    }
    else {
        $_SESSION['id_user'] = "";
        $_SESSION['user'] = ""; 
        header("Location: ../index.html");  // Redirecciona a pagina principal
    }
?>