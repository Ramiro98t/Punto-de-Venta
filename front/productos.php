<?php
require_once('../back/conecta.php');  //Conecta a la Base de datos
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/png" href="../img/icon.png" />
  <!-- Icono pestaña -->
  <title>Form. Registro Productos</title>
  <!-- Relacion archivo(online) bulma-css -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css" />
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <!-- Relacion archivo main-css -->
  <link rel="stylesheet" type="text/css" href="../css/style.css" />
  <!-- Relacion archivo(online) jquery-script -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Funciones -->
  <script src="../scripts/designScript.js"></script>
  <script src="../scripts/evalScript.js"></script>
</head>

<body>
  <section class="hero is-info">
    <div class="hero-body">
      <div class="container">
        <h1 class="title is-1">
          Producto
        </h1>
        <h2 class="subtitle">
          Registro
        </h2>
      </div>
    </div>
  </section>
  <br />
  <div class="container cont-mobile">
    <form class="mainForm" method="post">
      <div class="datos-entrada">
        <div class="field">
          <?php
          // Consulta MySql general
          $sql = "SELECT * FROM proveedor";
          $res = mysqli_query($con, $sql);    // Ejecuta la consulta en 'sql', con la conexion establecida
          $fila = mysqli_num_rows($res);      // Obtiene el numero de filas

          ?>
          <div class="control">
            <div class="select status">
              <select name="proveedor">
                <option disabled selected>Proveedor</option>
                <?php
                for ($i = $fila; $f = $res->fetch_object(); $i--) {
                  echo "<option value='$f->id'>$f->nombre</option>";
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="input" type="text" name="descripcion" placeholder="Descripcion" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="input" type="text" name="departamento" placeholder="Departamento" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="input" type="text" name="precio" placeholder="Precio" />
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="input" type="text" name="existencia" placeholder="Existencia" />
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
    <hr />
    <div class="field is-grouped">
      <div class="control">
        <input type="submit" class="button is-outlined is-medium is-success enviar" value="Registrar" />
      </div>
      <div class="control">
        <input type="button" class="button is-outlined is-medium is-danger cancelar" value="Cancelar" />
      </div>
    </div>
    <!-- Variable a considerar para reconocer el formulario -->
    <input class="wForm is-hidden" value="Productos" />
  </div>
</body>

</html>