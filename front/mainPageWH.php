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
    <script src="../scripts/devScript.js"></script>
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
                            <a class="navbar-item is-active">Movimientos</a>
                            <a class="navbar-item">Ajustes</a>
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
    <div id="mov">
        <!-- Selects Motivos -->
        <section class="container has-text-centered">
            <div class="select is-large">
                <select id="tipo">
                    <option disabled selected>Tipo</option>
                    <option value="1">Entrada</option>
                    <option value="2">Salida</option>
                </select>
            </div>
            <hr>
            <div class="select is-large is-hidden motivo">
                <select id="motivo">
                    <option disabled selected>Motivo</option>
                    <option value="1">Devolucion</option>
                    <option value="2">Compra</option>
                    <option value="3">Devolucion Cliente</option>
                    <option value="4">Devolucion Proveedor</option>
                </select>
            </div>
        </section>
        <hr>
        <!-- End Selects Motivos -->
    </div>

    <!-- Busqueda Ventas -->
    <section id="busqueda" class="is-hidden">
        <div class="container has-text-centered">
            <h1 class="title" id="titulo">
                INGRESE EL CODIGO DE VENTA
            </h1>
            <!-- Search Bar -->
            <div id="search">
                <div class="control has-icons-left">
                    <input class="input is-rounded" type="text" id="searchInput" name="search" placeholder="ID o Correo del Cliente">
                    <span class="icon is-small is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <div class="msg has-text-danger is-title"></div>
                <button id="enviar" class="button is-success">
                    Buscar
                </button>
            </div> <!-- End Search Bar -->
        </div>

        <!-- Modal -->
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
                            Pedido
                        </p>
                        <p class="subtitle pedidos_venta">

                        </p>
                        <p class="help has-text-grey">Por Ramiro Mendez</p>
                    </section>
                    <footer class="modal-card-foot">
                        <!-- <button class="button is-success">Entendido</button> -->
                        <!-- <button class="button">Cerrar</button> -->
                    </footer>
                </div>
                <button class="modal-close is-large exit-modal" aria-label="close"></button>
            </div>
        </div>
        <!-- End Modal -->
    </section> <!-- Busqueda Ventas -->
    <div id="adjust" class="is-hidden">
    </div>
</body>

</html>