<?php
session_start(); // Asegúrate de que la sesión esté iniciada
include("./include/conexion.php"); // Asegúrate de que el archivo de conexión está incluido

if (isset($_POST['btn_iniciar_sesion'])) {
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];

    // Escapar los valores para evitar inyección SQL
    $usuario = mysqli_real_escape_string($conexion, $usuario);
    $pass = mysqli_real_escape_string($conexion, $pass); 

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND pass='$pass'";
    $result = mysqli_query($conexion, $sql);

    if ($result) {
        $fila = mysqli_fetch_array($result);

        if ($fila) {
            $_SESSION['autenticado'] = 'SI';
            $_SESSION['usuario'] = $fila['usuario']; // Cambia '1' a 'usuario' para mayor claridad
            $_SESSION['cod_usuario'] = $fila['id']; // Cambia '0' a 'id' según tu base de datos

            echo "<script> location='administrador/index.php'; </script>";
            exit;
        } else {
            $mensaje = "Verifique el usuario o contraseña!";
            echo "<script>alert('$mensaje');</script>";
        }
    } else {
        echo "<script>alert('Error en la consulta a la base de datos.');</script>";
    }

    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - ARTESANIAS DE TEJIDOS ORTEGA</title>
    <style>
        /* Estilos existentes */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background-color: #d9dadb;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: #f5f5f5;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }

        .login-container img {
            width: 150px;
            margin-bottom: 20px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-container input[type="submit"]:hover {
            background-color: #555;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 24px;
            text-decoration: none;
            color: #333;
        }

        .register-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="img/logo inicio.png" alt="Logo de ARTESANIAS DE TEJIDOS ORTEGA">
        <form action="login.php" method="post">
            <input type="text" name="usuario" placeholder="Su usuario" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <input type="submit" name="btn_iniciar_sesion" value="Iniciar sesión">
        </form>
    
    </div>
</body>
</html>
