<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icono pestaña -->
    <link rel="icon" type="image/png" href="./img/icon.png">
    <!-- Relacion archivo(online) bulma-css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <!-- Relacion archivo main-css -->
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <!-- Relacion archivo(online) jquery-script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Funciones -->
    <script src="./scripts/index.js"></script>
</head>

<body>
    <section class="hero is-dark">
        <div class="hero-body">
            <div class="container">
                <h1 class="title is-1">
                    Punto de Venta
                </h1>
                <h2 class="subtitle">
                    Registros & Vistas
                </h2>
            </div>
        </div>
    </section>
    <br>
    <div class="container has-text-centered">
        <h1 class="title" id="title">
            Seleccione una opcion
        </h1>
        <hr>
        <div class="select">
            <select>
                <option disabled selected>Categoria</option>
                <option value="1">Empleado</option>
                <option value="2">Producto</option>
                <option value="3">Proveedor</option>
            </select>
        </div>
        <hr>
        <div class="columns">
            <div class="column is-half">
                <a id="regBtn" class="button is-large is-dark is-outlined" href="index.php"></a><br>
            </div>
            <div class="column is-half">
                <a id="viewBtn" class="button is-large is-dark is-outlined" href="index.php"></a><br>
            </div>
        </div>
    </div>
</body>

</html>