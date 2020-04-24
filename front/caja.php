<?php
session_start();
require_once('../back/conecta.php');  //Conecta a la Base de datos

$id_worker = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SSPISW</title>
    <!-- Icono pestaña -->
    <link rel="icon" type="image/png" href="../img/icon.png" />
    <!-- Relacion archivo(online) bulma-css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css" />
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <!-- Relacion archivo main-css -->
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <!-- Relacion archivo(online) jquery-script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Funciones -->
    <script src="../scripts/managementScript.js"></script>
</head>

<body>
    <!-- Header  -->
    <section class="hero is-primary">
        <!-- Hero head: will stick at the top -->
        <div class="hero-head">
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-brand">
                        <a class="navbar-item">
                            <img src="../img/logo.png" alt="Logo" />
                        </a>
                        <span class="navbar-burger burger" data-target="navbarMenuHeroA">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </div>
                    <div id="navbarMenuHeroA" class="navbar-menu">
                        <div class="navbar-end">
                            <a class="navbar-item" href="mainPage.php">Seguir comprando</a>
                            <span class="navbar-item">
                                <a id="logout" class="button is-primary is-inverted">
                                    <span class="icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <span>Log Out</span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Hero content: will be in the middle -->
        <div class="hero-body">
            <div class="cont-mobile container has-text-centered">
                <!-- Sesion en Empleado -->
                <h1 class="title is-1">
                    Bienvenido <?= $_SESSION['user'] ?>
                </h1>
                <input id="workerUser" name="<?= $_SESSION['id_user'] ?>" class="is-hidden">
                <h2 id="module" class="subtitle is-3">
                    Modulo Caja
                </h2>
                <div class="columns container is-centered is-3">
                    <?php
                    if ($_SESSION['client'] != "") {
                        $flagInput = "is-hidden";
                        $flagTitle = "";
                    } else {
                        $flagTitle = "is-hidden";
                        $flagInput = "";
                    }
                    ?>
                    <div class="field clientField <?= $flagInput ?>">
                        <p class="control has-icons-left has-icons-right">
                            <input id="clientEmail" name="<?= $_SESSION['id_client'] ?>" class="input is-small is-rounded" type="email" placeholder="Correo electronico cliente" />
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </p>
                    </div>
                    <!-- Sesion en Cliente -->
                    <div id="clientUser" class="<?= $flagTitle ?>">
                        <h2 class="subtitle is-5">
                            Cliente: <?= $_SESSION['client'] ?> -
                        </h2>
                    </div>
                    <a id="manageClient" class="is-small button is-primary is-inverted is-rounded">
                        <span class="icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <?php
                        if ($_SESSION['client'] != "") $btn = "Cambiar";
                        else $btn = "Ingresar"
                        ?>
                        <span id="type"><?= $btn ?></span>
                    </a>
                </div>
            </div>
        </div>
    </section> <!-- Fin header -->

    <main class="container">
        <hr>
        <div class="columns has-text-centered">
            <div class="column is-one-third">
                <h2 class="title">Articulo</h2>
            </div>
            <div class="column is-one-third">
                <h2 class="title">Precio($)</h2>
            </div>
            <div class="column is-one-third">
                <h2 class="title">Cantidad</h2>
            </div>
        </div>

        <?php
        // Hace consulta de los pedidos pendientes, status = 0 del usuario en linea
        $sql = "SELECT * FROM ventas WHERE id_empleado='$id_worker' AND status='0'";
        $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
        $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

        if ($fila) {
            $id_venta = $res->fetch_object();
            $id_venta = $id_venta->id;

            $sql = "SELECT producto.*, venta_producto.* FROM venta_producto INNER JOIN
                    producto ON venta_producto.id_producto = producto.id WHERE id_venta='$id_venta' AND cantidad != 0";
            $res  = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
            $fila = mysqli_num_rows($res);      // Obtiene el numero de filas
        }
        ?>

        <?php
        $total = 0;
        for ($i = $fila; $f = $res->fetch_object(); $i--) {
            $money = $f->cantidad * $f->precio;
            $total += $money;
        ?>
            <div class="columns has-text-centered card">
                <!-- Fila de productos en pedido -->
                <div class="column subtitle is-one-third is-marginless">
                    <div><?= $f->descripcion ?></div>
                </div>
                <div class="column subtitle is-one-third is-marginless">
                    <p>$<?= $money ?></p>
                </div>
                <div class="column subtitle is-one-third is-marginless">
                    <p><?= $f->cantidad ?></p>
                </div>
            </div>
        <?php
        }
        ?>

        <div class="columns has-text-centered is-multiline">
            <h1 class="column title is-half">Total:</h1>
            <h1 class="has-text-success column title is-half">$<?= $total ?></h1>
            <hr>
            <div class="column">
                <a class="button is-dark" href="../back/ticket.php?id_v=<?=$id_venta?>" target="_blank">Imprimir ticket</a>
            </div>
        </div>

    </main>
</body>

</html>