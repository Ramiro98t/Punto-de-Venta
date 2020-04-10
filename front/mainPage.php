<?php
session_start();
require_once('../back/conecta.php');  //Conecta a la Base de datos
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
                            <a class="navbar-item is-active">Ventas</a>
                            <a class="navbar-item">Devolucion</a>
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
                    Modulo Ventas
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


    <!-- Seccion Ventas  -->
    <section id="Ventas" class="has-background-grey-lighter">
        <div class="container cont-mobile">
            <!-- Search Bar -->
            <div class="field search-bar">
                <div class="control has-icons-left">
                    <input class="input is-rounded" type="text" id="search" name="search" placeholder="ID, Descripción o Departamento">
                    <span class="icon is-small is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div> <!-- End Search Bar -->

            <!-- Products List -->
            <div class="products">
                <div class="columns is-multiline result">
                    <!-- Content in DB -->
                </div>
            </div> <!-- End Products List -->

        </div>
    </section>

    <div class="cantidad-carrito">
        <!-- Carrito - Cantidad -->
        <!-- <span class="icon is-small icono-carrito icono">
            <i class="fas fa-shopping-cart" title="Productos venta"></i>
        </span> -->
        <img class="icono-carrito icono" src="../img/carrito.svg" alt="logo carrito" title="Productos venta"> <!-- SVG de icono carrito de compras -->
        <?php
        $sql = "SELECT ventas.*, SUM(cantidad) AS total FROM venta_producto
                INNER JOIN ventas ON venta_producto.id_venta = ventas.id WHERE status = 0";    // Suma la cantidad total de articulos en el pedido
        $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
        $cant = $res->fetch_object();
        $cant = $cant->total;            // Se le asigna el campo de retorno del query
        // $cant != 0 ? $cant = $cant : $cant = 0;
        ?>
        <!-- Contador de articulos -->
        <div class="cantidad has-background-white-ter has-text-centered" value="<?= $cant ?>">
            <?= $cant ?>
        </div>
    </div> <!-- Fin Carrito - Cantidad -->
    <section id="carrito" class="card has-background-white-ter is-hidden">
        <div class="vista-productos-carrito">
            <!--  Carrito - Vista venta -->
            <div class="vista-carrito is-flex">
                <!-- Encabezado ventana pedido -->
                <h2 class="title is-4">Carrito</h2>
                <span class="icon is-small icono-basura icono">
                    <i class="far fa-trash-alt" title="Vaciar carrito"></i>
                </span>
            </div> <!-- Fin encabezado ventana pedido -->

            <?php
            // Hace consulta de los pedidos pendientes, status = 0 del usuario en linea
            $sql = "SELECT * FROM ventas WHERE status='0'";
            $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
            $fila = mysqli_num_rows($res);  // Obtiene el numero de filas

            if ($fila) {
                $id_venta = $res->fetch_object();
                $id_venta = $id_venta->id;

                $sql = "SELECT producto.descripcion, venta_producto.* FROM venta_producto INNER JOIN
                        producto ON venta_producto.id_producto = producto.id WHERE id_venta='$id_venta' AND cantidad != 0";
                $res  = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
                $fila = mysqli_num_rows($res);       // Obtiene el numero de filas
            }

            for ($i = $fila; $f = $res->fetch_object(); $i--) {
            ?>
                <!-- Fila de productos en pedido -->
                <div class="is-flex vista-carrito">
                    <p class="is-size-6"><?= $f->descripcion ?></p>
                    <div id="<?= $f->id_producto ?>">
                        <input type="number" class="input is-small modificar-producto" min="0" step="1" value="<?= $f->cantidad ?>" title="Cantidad">
                        <span class="icon is-small quitar-producto icono">
                            <i class="far fa-times-circle" title="Quitar producto"></i>
                        </span>
                    </div>
                </div>
                <!-- <br> -->
            <?php
            }

            if ($cant != 0) {
                echo "<hr class='has-background-primary' ><a href='caja.php' class='button is-outlined is-success is-pulled-right'>Pasar a Caja</a>";
            }
            ?>
        </div> <!--  Fin ventana pedido -->
    </section>
    <!-- Fin seccion Ventas -->

    <!-- Seccion Devolucion  -->
    <section id="Devolucion" class="hero is-hidden">
        <!-- Hero content: will be in the middle -->
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-1">
                    PROXIMAMENTE
                </h1>
                <h1 class="title">
                    Seccion Devolucion
                </h1>
            </div>
        </div>
    </section>
    <!-- Fin seccion Devolucion -->
</body>

</html>