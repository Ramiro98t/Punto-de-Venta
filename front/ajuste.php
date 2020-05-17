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
    <script src="../scripts/adjustScript.js"></script>
</head>

<body>
    <section class="hero is-warning">
        <div class="hero-body">
            <div class="container">
                <h1 class="title is-1">
                    Ajuste Inventario
                </h1>
                <h2 class="subtitle">
                    Registro
                </h2>
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
    <div class="container cont-mobile">
        <form class="mainForm" method="post">
            <div class="datos-entrada">
                <div class="field is-flex">
                    <div class="select">
                        <select id="producto">
                            <option disabled selected>Producto</option>
                            <?php
                            for ($i = $fila; $f = $res->fetch_object(); $i--) {
                                echo "<option value='$f->id,$f->existencia'>$f->descripcion</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="">
                        <input type="number" class="input" id="cantidad" step="1" title="Cantidad" placeholder="Cantidad">
                    </div>
                    <div class="control">
                        <input class="input" id="motivo" placeholder="Motivo" />
                    </div>
                </div>
            </div>
        </form>
        <div class="mensaje">
            <!-- Contiene mensaje del sistema -->
        </div>
        <hr />
        <div class="field is-grouped">
            <div class="control">
                <input type="submit" class="button is-outlined is-medium is-warning agregar" value="Agregar" />
            </div>
            <div class="control">
                <button type="submit" class="button is-outlined is-medium is-success enviar">Terminar</button>
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