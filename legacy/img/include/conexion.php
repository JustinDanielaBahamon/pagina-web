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

?>