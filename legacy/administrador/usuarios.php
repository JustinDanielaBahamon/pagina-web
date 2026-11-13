<?php
session_start();
include("../include/conexion.php");

$sql = "select count(id),Max(id) from usuarios";
$cs = mysqli_query($conexion, $sql);
$cod_max = 0;
while ($resul = mysqli_fetch_array($cs)) {
    $cod_max = $resul[1];
}

$datos = array();
if (isset($_REQUEST['accion'])) {
    if($_REQUEST['accion'] == 'actualizar'){
        $sql = "select * from usuarios where id = " . $_REQUEST['id'] . ";";
        $result = mysqli_query($conexion, $sql);
        $datos = mysqli_fetch_array($result);
    }else if($_REQUEST['accion'] == 'eliminar'){
        $sql="delete from usuarios where id=" . $_REQUEST['id'] . ";";
        $result = mysqli_query($conexion, $sql);
    }
    
}

$sql = "select * from usuarios;";
$result = mysqli_query($conexion, $sql);

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    

    <!-- Bootstrap CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../../css/tiny-slider.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <title>Artesanias de tejidos ortegas</title>
</head>

<body>

    <?php require_once('encabezado.php'); ?>

    <div class="untree_co-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                    <h2 class="mb-4 section-title">Usuarios</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8 pb-4">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="text-black" for="codigo">Codigo</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" value="<?php echo ($datos) ? $datos[0] : $cod_max + 1; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="text-black" for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo ($datos) ? $datos[1] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="text-black" for="apellido">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo ($datos) ? $datos[2] : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="text-black" for="usuario">Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo ($datos) ? $datos[3] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="text-black" for="pass">Contraseña</label>
                                    <input type="password" class="form-control" id="pass" name="pass" value="<?php echo ($datos) ? $datos[4] : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <a href="<?php echo URL_BASE; ?>administrador/usuarios.php" class="btn btn-primary-hover-outline">Nuevo</a>
                            <button type="submit" class="btn btn-primary-hover-outline" name="btn_usuarios" value="agregar">Agregar</button>
                            <button type="submit" class="btn btn-info-hover-outline" name="btn_usuarios" value="actualizar">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row justify-content-center pt-4">
                <div class="col-md-8 col-lg-8 pb-4">
                    <div class="row mb-5">
                        <div class="col-lg-12">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Contraseña</th>
                                        <th scope="col">Opcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($resul = mysqli_fetch_array($result)) {  ?>
                                        <tr>
                                            <th scope="row"><?php echo $resul[0]; ?></th>
                                            <td><?php echo $resul[1]; ?></td>
                                            <td><?php echo $resul[2]; ?></td>
                                            <td><?php echo $resul[3]; ?></td>
                                            <td>********</td>
                                            <td class="text-center">
                                                 <a href="<?php echo URL_BASE; ?>administrador/usuarios.php?accion=actualizar&id=<?php echo $resul[0]; ?>" title="Seleccionar para editar"><i class="bi bi-pencil text-success"></i></a>

                                                <a href="<?php echo URL_BASE; ?>administrador/usuarios.php?accion=eliminar&id=<?php echo $resul[0]; ?>" title="Eliminar el registro"><i class="bi bi-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('pie.php'); ?>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/tiny-slider.js"></script>
    <script src="../../js/custom.js"></script>
</body>

</html>

<?php
if (isset($_REQUEST['btn_usuarios'])) {

    // echo print_r($_REQUEST);
    $btn = $_REQUEST["btn_usuarios"];
    $codigo = $_REQUEST['codigo'];
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $usuario = $_REQUEST['usuario'];
    $pass = $_REQUEST['pass'];

    if ($btn == "nuevo") {
        echo "<script> location='usuarios.php'; </script>";
    }

    if ($btn == "agregar") {
        $sql = "insert into usuarios values ($codigo,'$nombre','$apellido','$usuario','$pass')";
        if (mysqli_query($conexion, $sql)) {
            echo "<script> alert('Se inserto correctamente');</script>";
            echo "<script> location='usuarios.php'; </script>";
        } else {
            echo "<script> alert('Error al insertar datos: " . mysqli_error($conn) . "');</script>";
        }
    }

    if ($btn == "actualizar") {
        $sql = "update 
                    usuarios 
                set 
                    nombre = '$nombre',
                    apellido = '$apellido',
                    usuario = '$usuario',
                    pass = '$pass'
                where
                    id = '$codigo';";
        if (mysqli_query($conexion, $sql)) {
            echo "<script> alert('Se actualizo correctamente');</script>";
            echo "<script> location='usuarios.php'; </script>";
        } else {
            echo "<script> alert('Error al actualziar datos: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>