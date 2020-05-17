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
    <script src="../scripts/designScript.js"></script>
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
                    <div id="clientSession">
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
        $sql = "SELECT venta.*, SUM(cantidad) AS total FROM detalle_venta
                INNER JOIN venta ON detalle_venta.id_venta = venta.id WHERE status = 0";    // Suma la cantidad total de articulos en el pedido
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
            $sql = "SELECT * FROM venta WHERE status='0'";
            $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
            $fila = mysqli_num_rows($res);  // Obtiene el numero de filas

            if ($fila) {
                $id_venta = $res->fetch_object();
                $id_venta = $id_venta->id;

                $sql = "SELECT producto.descripcion, detalle_venta.* FROM detalle_venta INNER JOIN
                        producto ON detalle_venta.id_producto = producto.id WHERE id_venta='$id_venta' AND cantidad != 0";
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
        <div class="hero-body has-background-grey-lighter">
            <div class="container has-text-centered">
                <h1 class="title is-1">
                    INGRESE EL CODIGO DE VENTA
                </h1>
                <!-- Search Bar -->
                <div id="search-dev">
                    <div class="control has-icons-left">
                        <input class="input is-rounded" type="text" id="searchDev" name="search" placeholder="ID">
                        <span class="icon is-small is-left">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div> <!-- End Search Bar -->
                <hr>
                <!-- Sells List -->
                <div class="sells">
                    <div class="columns is-multiline resultDev">
                        <!-- Content in DB -->
                    </div>
                </div> <!-- End Sells List -->
            </div>
        </div>
    </section>

    <!-- Modal Devolucion Unitaria-->
    <div class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Devolucion unitaria</p>
                    <button class="delete exit-modal" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <p class="title">
                        Pedido:
                    </p>
                    <div class="columns">
                        <p class="column subtitle is-three-fifths has-text-info">
                            Descripcion
                        </p>
                        <p class="column subtitle is-one-fifths has-text-info">
                            Motivo
                        </p>
                        <p class="column subtitle is-one-fifth has-text-info">
                            Cantidad
                        </p>
                    </div>
                    <div class="pedidos_venta">
                        <!-- Content in DB -->
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button id="regDev" class="button">Generar devolucion</button>
                </footer>
            </div>
            <button class="modal-close is-large exit-modal" aria-label="close"></button>
        </div>
    </div>
    <!-- End Modal -->
    <!-- Fin seccion Devolucion -->
</body>

</html>