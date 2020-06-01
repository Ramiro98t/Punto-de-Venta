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
        <div class="select is-large">
            <select id="motivo">
                <option disabled selected>Motivo</option>
                <option value="1">Entrada - Compra</option>
                <option value="2">Entrada - Devolucion</option>
                <option value="3">Salida - Venta</option>
                <option value="4">Salida - Devolucion Proveedor</option>
            </select>
        </div>
    </section>
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

    <!-- Compras / Devoluciones a Proveedor -->
    <section id="form" class="is-hidden container has-text-centered">
        <?php
        // Consulta MySql general
        $sql = "SELECT * FROM producto WHERE existencia != 0";
        $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
        $fila = mysqli_num_rows($res);      // Obtiene el numero de filas
        ?>

        <div class="container">
            <form id="mainForm" method="post">
                <div class="control folio">
                    <input class="input" name="folio" placeholder="Folio de Compra" />
                </div>
                <p class="help is-info">La cantidad debe ser negativa</p>
                <div class="field is-flex">
                    <div class="control select">
                        <select name="producto">
                            <option disabled selected>Producto</option>
                            <?php
                            for ($i = $fila; $f = $res->fetch_object(); $i--) {
                                echo "<option value='$f->id,$f->existencia'>$f->descripcion</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="control">
                        <input type="number" class="input" name="cantidad" min="1" step="1" title="Cantidad" placeholder="Cantidad">
                    </div>
                    <div class="control motivo">
                        <input class="input" name="motivo" placeholder="Motivo" />
                    </div>
                </div>
            </form>
            <div class="mensaje">
                <!-- Contiene mensaje del sistema -->
            </div>
            <hr />
            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-outlined is-medium is-success agregar">Agregar</button>
                </div>
                <div class="control">
                    <button class="button is-outlined is-medium is-danger terminar">Terminar</button>
                </div>
            </div>
            <hr>
            <table class="table is-hidden">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Descripcion</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody class="ls">
                    <!-- Content in DB -->
                </tbody>
            </table>
        </div>
    </section>
    <!-- End Compras / Devoluciones a Proveedor -->
</body>

</html>