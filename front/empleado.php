<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../img/icon.png"> <!-- Icono pestaña -->
    <title>Formulario registro Clientes</title>
    <!-- Relacion archivo(online) bulma-css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <!-- Relacion archivo main-css -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <!-- Relacion archivo(online) jquery-script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Funciones -->
    <script src="../scripts/script.js"></script>
</head>

<body>
    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title is-1">
                    Empleado
                </h1>
                <h2 class="subtitle">
                    Registro
                </h2>
            </div>
        </div>
    </section>
    <br>
    <div class="container cont-mobile">
        <form class="mainForm" method="post">
            <div class="datos-entrada">
                <div class="field">
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="nombre" placeholder="Nombre">
                        <span class="icon is-small is-left">
                            <i class="fas fa-portrait"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="direccion" placeholder="Domicilio">
                        <span class="icon is-small is-left">
                            <i class="fas fa-map-marked-alt"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="ciudad" placeholder="Ciudad">
                        <span class="icon is-small is-left">
                            <i class="fas fa-city"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="telefono" placeholder="Telefono">
                        <span class="icon is-small is-left">
                            <i class="fas fa-phone"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="email" placeholder="Correo Electronico">
                        <span class="icon is-small is-left">
                            <i class="fas fa-at"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fas fa-check"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="cargo" placeholder="Cargo">
                        <span class="icon is-small is-left">
                            <i class="fas fa-sitemap"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="salario" placeholder="Salario">
                        <span class="icon is-small is-left">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Status</label>
                    <div class="control">
                        <div class="select status">
                            <select name="status">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="mensaje">
            <!-- Contiene mensaje del sistema -->
        </div>
        <hr>
        <div class="field is-grouped">
            <div class="control">
                <input type="submit" class="button is-outlined is-medium is-success enviar" value="Registrar">
            </div>
            <div class="control">
                <input type="button" class="button is-outlined is-medium is-danger cancelar" value="Cancelar">
            </div>
        </div>
        <!-- Variable a considerar para reconocer el formulario -->
        <input class="wForm" value="Empleado">
    </div>
</body>

</html>