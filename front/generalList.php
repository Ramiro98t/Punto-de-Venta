<?php
$label = $_GET["label"]
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icono pestaña -->
    <link rel="icon" type="image/png" href="../img/icon.png">
    <!-- Relacion archivo(online) bulma-css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <!-- Relacion archivo main-css -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <!-- Relacion archivo(online) jquery-script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Funciones -->
    <script src="../scripts/designScript.js"></script>
    <script src="../scripts/generalListScript.js"></script>
    <title>Catalogo</title>
</head>

<body>
    <input id="type" class="is-hidden" value="<?= $label ?>"> <!-- Almacena la categoria par la lista -->
    <header class="hero has-background-grey-light">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-flex is-vcentered">
                    <div class="column">
                        <h1 class="title is-1 has-text-white">
                            Punto de Venta
                        </h1>
                        <h2 class="subtitle has-text-white-bis">
                            Catalogo
                        </h2>
                    </div>
                    <div class="column has-text-right">
                        <a href="#">
                            <img src="../img/logo.png" class="logo" alt="Logo">
                        </a>
                    </div>
                </div>
                <?php $hidden = $label == "Movimientos" ? "no" : "is-hidden" ?>
                <div class="select is-small <?= $hidden ?> ">
                    <select>
                        <option disabled selected>Tipo</option>
                        <option value="1">Entrada - Compra</option>
                        <option value="2">Entrada - Devolucion</option>
                        <option value="3">Salida - Venta</option>
                        <option value="4">Salida - Devolucion Proveedor</option>
                    </select>
                </div>
            </div>
        </div>
    </header>
    <!-- Main -->
    <section class="has-background-grey-lighter">
        <div class="container cont-mobile">
            <!-- Search Bar -->
            <div class="field search-bar">
                <div class="control has-icons-left">
                    <input class="input is-rounded" type="text" id="search" name="search">
                    <span class="icon is-small is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
            <!-- End Search Bar -->
            <!-- Products List -->
            <div class="products">
                <h1 class="title is-1 has-text-grey">
                    <?= $label ?>
                </h1>
                <div class="columns is-multiline result">
                    <!-- Content in DB -->
                </div>
            </div>
            <!-- End Products List -->
        </div>
    </section>
    <!-- End Main -->

    <!-- Modal Detalle -->
    <div class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Información General</p>
                    <button class="delete exit-modal" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <!-- Content in DB -->
                </section>
                <footer class="modal-card-foot">
                    <button class="button exit-modal">Cerrar</button>
                </footer>
            </div>
            <button class="modal-close is-large exit-modal" aria-label="close"></button>
        </div>
    </div>
    <!-- End Modal -->
</body>

</html>