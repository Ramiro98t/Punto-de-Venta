<?php
session_start();
require_once('../back/conecta.php');  //Conecta a la Base de datos

$id_worker = $_SESSION['id_user'];
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
                            <a class="navbar-item" href="mainPage.php">Seguir comprando</a>
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
                <h2 class="subtitle is-3">
                    Modulo Caja
                </h2>
                <!-- Sesion en Cliente -->
                <h2 class="subtitle is-5">
                    Cliente: <?= $_SESSION['client'] ?>
                </h2>
            </div>
        </div>
    </section> <!-- Fin header -->

    <main class="container">
        <hr>
        <div class="is-mobile columns has-text-centered">
            <div class="column is-one-third">
                <h2 class="title">Articulo</h2>
            </div>
            <div class="column is-one-third">
                <h2 class="title">Precio($)</h2>
            </div>
            <div class="column is-one-third">
                <h2 class="title">Cantidad</h2>
            </div>
        </div>

        <?php
        // Hace consulta de los pedidos pendientes, status = 0 del usuario en linea
        $sql = "SELECT * FROM ventas WHERE id_empleado='$id_worker' AND status='0'";
        $res = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
        $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

        if ($fila) {
            $id_venta = $res->fetch_object();
            $id_venta = $id_venta->id;

            $sql = "SELECT producto.*, venta_producto.* FROM venta_producto INNER JOIN
                    producto ON venta_producto.id_producto = producto.id WHERE id_venta='$id_venta' AND cantidad != 0";
            $res  = mysqli_query($con, $sql);    // Hace consulta con la conexion establecida
            $fila = mysqli_num_rows($res);      // Obtiene el numero de filas
        }
        ?>

        <?php
        $subtotal = 0;
        for ($i = $fila; $f = $res->fetch_object(); $i--) {
            $money = $f->cantidad * $f->precio;
            $subtotal += $money;
        ?>
            <div class="is-mobile columns has-text-centered card">
                <!-- Fila de productos en pedido -->
                <div class="column subtitle is-one-third is-marginless">
                    <div><?= $f->descripcion ?></div>
                </div>
                <div class="column subtitle is-one-third is-marginless">
                    <p>$<?= $money ?></p>
                </div>
                <div class="column subtitle is-one-third is-marginless">
                    <p><?= $f->cantidad ?></p>
                </div>
            </div>
        <?php
        }
        ?>
        <hr>

        <div class=" has-text-centered">
            <div class="columns is-multiline">
                <h1 class="column title is-half">Subtotal:</h1>
                <h1 class="has-text-success column title is-half">$<?= $subtotal ?></h1>
                
                <div class="column is-half is-flex is-centered columns">
                    <input id="codesc" class="input column is-one-third" placeholder="Descuento">
                    <button id="desc" class="button is-success">Aplicar</button>
                </div>
                <h1 id="aplicaDesc" class="column subtitle is-half">Descuento: 0</h1>

                <div class="column is-half"></div>
                <?php
                    $sql = "SELECT * FROM iva ORDER BY fecha DESC LIMIT 1";
                    $res = mysqli_query($con,$sql);
                    
                    $iva = $res->fetch_object();
                    $ivaP = $iva->porcentaje;
                    $iva = $ivaP[2].$ivaP[3]
                ?>
                <input id="subtotal" class="is-hidden" value="<?= $subtotal ?>">
                <input id="descuento" class="is-hidden" value="1">
                <input id="iva" class="is-hidden" value="<?= $ivaP ?>">
                <input id="subTotalIva" class="is-hidden" value="<?= $total = $subtotal+round(($subtotal*$ivaP)) ?>">
                <input id="total" class="is-hidden" value="">
                
                <div class="column is-half">IVA: <?= $iva ?>%</div>

                <div class="column is-half"></div>
                <div id="cantidadTotal" class="title column is-half"></div>

            </div>
            <div class="columns">
                <div class="column">
                    <div class="select">
                        <select>
                            <option disabled selected>Metodo de pago</option>
                            <option value="1">Efectivo</option>
                            <option value="2">Tarjeta</option>
                            <option value="3">Ambas</option>
                        </select>
                    </div>
                </div>
                <div class="column">
                    <!-- Formulario Efectivo -->
                    <form id="cash" class="cashForm is-hidden">
                        <div class="datos-entrada">
                            <div class="field">
                                <div class="control">
                                    <input id="cashInput" class="input" type="text" name="recibo" placeholder="Recibido" />
                                </div>
                            </div>
                        </div>
                    </form> <!-- Fin Formulario Efectivo -->

                    <!-- Formulario Tarjeta -->
                    <form id="card" class="cardForm is-hidden">
                        <div class="datos-entrada">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" name="numCard" placeholder="Numero de Tarjeta" />
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" name="fecha" placeholder="Fecha vencimiento" />
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" name="code" placeholder="Codigo CCV" />
                                </div>
                            </div>
                            <!-- #cardInput almacena la cantidad a tomar de la tarjeta -->
                        </div>
                    </form> <!-- Fin Formulario Tarjeta -->

                    <!-- Formulario Ambos -->
                    <form id="both" class="bothForm is-hidden">
                        <hr>
                        <div class="datos-entrada">
                            <div class="field">
                                <div class="control">
                                    <input id="cardBoth" class="input" type="text" name="reciboCard" placeholder="Recibido Tarjeta" />
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input id="cashBoth" class="input" type="text" name="reciboCash" placeholder="Recibido Efectivo" />
                                </div>
                            </div>
                        </div>
                    </form> <!-- Fin Formulario Ambos -->


                    <div class="mensaje">
                        <!-- Contiene mensaje del sistema -->
                    </div>
                    <hr>
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit" class="button is-outlined is-medium is-success enviar is-hidden" value="Pagar" />
                        </div>
                        <div class="control">
                            <input type="button" class="button is-outlined is-medium is-danger cancelar is-hidden" value="Cancelar" />
                        </div>
                    </div>
                </div>
            </div>
            <div id="imprimir" class="is-hidden">
                <a class="button is-dark">Imprimir ticket</a>
            </div>
            <hr>
            
        </div>

    </main>
</body>

</html>