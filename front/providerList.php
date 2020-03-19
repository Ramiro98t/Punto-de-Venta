<?php require_once("../back/conecta.php"); ?>
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
    <script src="../scripts/productListScript.js"></script>
    <title>Catalogo</title>
</head>

<body>
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
                        <a href="productList.php">
                            <img src="../img/icon.png" class="logo" alt="Logo">
                        </a>
                    </div>
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
                    <input class="input" type="text" id="search" name="search" 
                            placeholder="ID, Descripción, Departamento">
                    <span class="icon is-small is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
            <!-- End Search Bar -->
            <!-- Products List -->
            <div class="products">
                <h1 class="title is-1 has-text-grey">
                    Productos
                </h1>
                <div class="columns is-multiline result">
                    <!-- Content in DB -->
                </div>
            </div>
            <!-- End Products List -->
        </div>
    </section>
    <!-- End Main -->
</body>

</html>