<?php
$servername = "localhost";
$database = "hamaca_mb";
$username = "root";
$password = "";

$conexion = mysqli_connect($servername, $username, $password, $database);


if (!$conexion) {
    die("Fallo conexión a la BD " . mysqli_connect_error());
}
// mysqli_close($conn);
// Establecer el charset a UTF-8
$conexion->set_charset("utf8");

?>