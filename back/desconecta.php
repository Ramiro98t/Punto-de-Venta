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
        // session_destroy();              // Destruye toda la información asociada con la sesión actual.
        header("Location: ../index.html");  // Redirecciona a pagina principal
    }
?>