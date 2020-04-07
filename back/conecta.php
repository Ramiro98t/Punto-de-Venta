<?php
// Establecer palabras reservadas para su posterior uso simplificado
if (!defined('HOST')) define('HOST', 'localhost');    // Host
if (!defined('BD')) define('BD', 'puntoventa');        // Base de Datos
if (!defined('USER_BD')) define('USER_BD', 'root');   // Usuario
if (!defined('PASS_BD')) define('PASS_BD', '');       // Contraseña de usuario
// define("HOST",'localhost');         // Host
// define("BD",'cliente01');           // Base de Datos
// define("USER_BD",'root');           // Usuario
// define("PASS_BD",'');               // Contraseña de Usuario
// Establece la conexion con las variables requeridas del metodo para conectar
// En caso contrario muestra un error con la conexion
$con = mysqli_connect(HOST,USER_BD,PASS_BD,BD) or die ("Error".mysqli_error($con));
?>
