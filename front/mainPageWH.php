<?php
session_start();                        // Administrador de Sesiones
require_once('../back/conecta.php');    // Conecta a la Base de datos
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
    <script src="../scripts/designScript.js"></script>
    <script src="../scripts/almacenScript.js"></script>
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
                    Modulo Movimientos
                </h2>
            </div>
        </div>
    </section> <!-- Fin header -->
    <hr>
    <!-- Select Motivos -->
    <section class="container has-text-centered">
        <div class="select is-large motivo">
            <select id="motivo">
                <option disabled selected>Motivo</option>
                <option value="1">Entrada - Devolucion</option>
                <option value="2">Entrada - Compra</option>
                <option value="3">Salida - Venta</option>
            </select>
        </div>
    </section>
    <hr>
    <!-- End Select Motivos -->

    <!-- Busqueda Ventas -->
    <section id="busqueda" class="is-hidden">
        <div class="container has-text-centered">
            <h1 class="title" id="titulo">
            </h1>
            <!-- Search Bar -->
            <div id="search">
                <div class="control has-icons-left">
                    <input class="input is-rounded" id="searchInput" placeholder="ID">
                    <span class="icon is-small is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <div class="msg has-text-danger is-title"></div>
                <hr>
                <button id="enviar" class="button is-success">
                    Buscar
                </button>
            </div> <!-- End Search Bar -->
        </div>

        <!-- Modal -->
        <div class="modal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div id="info-modal" class="modal-card">
                    <!-- Content in DB -->
                </div>
                <button class="modal-close is-large exit-modal" aria-label="close"></button>
            </div>
        </div>
        <!-- End Modal -->
    </section> <!-- Busqueda Ventas -->

    <?php
    // Consulta MySql general
    $sql = "SELECT * FROM proveedor";
    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    ?>

    <!-- Entrada Compras -->
    <section id="compra" class="is-hidden container has-text-centered">
        <div class="container is-flex">
            <div class="select">
                <select id="proveedor">
                    <option disabled selected>Proveedor</option>
                    <?php
                    for ($i = $fila; $f = $res->fetch_object(); $i--) {
                        echo "<option value='$f->id'>$f->nombre</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="select">
                <select id="producto">
                    <option disabled selected>Producto</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="control">
                <input type="number" class="input" id="cantidad" step="1" title="Cantidad" placeholder="Cantidad">
            </div>
            <div class="control">
                <input type="submit" class="button is-outlined is-warning agregar" value="Agregar" />
            </div>
            <div class="control">
                <button type="submit" class="button is-outlined is-success enviar">Terminar</button>
            </div>
        </div>
        <div class="mensaje">
            <!-- Contiene mensaje del sistema -->
        </div>
    </section>
    <!-- End Entrada Compras -->
</body>

</html>