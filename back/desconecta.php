<?php
    session_start();                // Gestor de sesiones

    $user = $_GET["no_user"];

    if ($user) {
        // Reinicia valores del cliente
        $_SESSION['id_client'] = "";
        $_SESSION['client'] = "";
        header("Location: ../front/mainPage.php");  // Redirecciona a pagina principal
    }
    else {
        session_destroy();              // Destruye toda la información asociada con la sesión actual.
        header("Location: ../index.html");  // Redirecciona a pagina principal
    }
?>