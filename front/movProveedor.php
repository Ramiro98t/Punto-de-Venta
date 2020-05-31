<?php
session_start();
require_once('../back/conecta.php');  //Conecta a la Base de datos

$id_worker = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="../img/icon.png" />
    <!-- Icono pestaña -->
    <title>Formulario registro Ajuste Inventario</title>
    <!-- Relacion archivo(online) bulma-css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css" />
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <!-- Relacion archivo main-css -->
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <!-- Relacion archivo(online) jquery-script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Funciones -->
    <script src="../scripts/movProveedor.js"></script>
</head>

<body>
    <section class="hero is-warning">
        <div class="hero-body">
            <div class="container">
                <h1 class="title is-1">
                    Movimientos Proveedor
                </h1>
                <h2 class="subtitle">
                    Registro
                </h2>
                <div class="select">
                    <select id="tipo">
                        <option disabled selected>Compra/Devolucion</option>
                        <option value="1">Compra a Proveedor</option>
                        <option value="2">Devolucion a Proveedor</option>
                    </select>
                </div>
            </div>
        </div>
    </section>
    <br />

    <?php
    // Consulta MySql general
    $sql = "SELECT * FROM producto WHERE existencia != 0";
    $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
    $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

    ?>

    <div class="container cont-mobile is-hidden">
        <form id="mainForm" method="post">
            <div class="control folio">
                <input class="input" name="folio" placeholder="Folio de Compra"/>
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
                <button class="button is-outlined is-medium is-danger enviar">Terminar</button>
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
</body>

</html>