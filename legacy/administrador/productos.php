

<?php
session_start();
include("../include/conexion.php");

$sql = "select count(cod_producto),Max(cod_producto) from productos";
$cs = mysqli_query($conexion, $sql);
$cod_max = 0;
while ($resul = mysqli_fetch_array($cs)) {
    $cod_max = $resul[1];
}

$datos = array();
if (isset($_REQUEST['accion'])) {
    if ($_REQUEST['accion'] == 'actualizar') {
        $sql = "select * from productos where cod_producto = " . $_REQUEST['cod_producto'] . ";";
        $result = mysqli_query($conexion, $sql);
        $datos = mysqli_fetch_array($result);
    } else if ($_REQUEST['accion'] == 'estado') {
        $estado = $_REQUEST['estado'];
        $sql = "update productos SET estado = '$estado' where cod_producto=" . $_REQUEST['cod_producto'] . ";";
        $result = mysqli_query($conexion, $sql);
    }
}

$sql = "select * from productos;";
$result = mysqli_query($conexion, $sql);

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">

    <!-- Bootstrap CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../../css/tiny-slider.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <title>ARTESANIAS DE TEJIDOS ORTEGA</title>
</head>

<body>

    <?php require_once('encabezado.php'); ?>

    <div class="untree_co-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                    <h2 class="mb-4 section-title">Productos</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8 pb-4">
                    <form action="" method="POST" enctype="multipart/form-data">
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
                                    <label class="text-black" for="valor_unidad">Valor unidad</label>
                                    <input type="number" class="form-control" id="valor_unidad" name="valor_unidad" value="<?php echo ($datos) ? $datos[2] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="text-black" for="cantidad">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo ($datos) ? $datos[3] : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-5">
                                    <label class="text-black" for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" cols="30" rows="5"><?php echo ($datos) ? $datos[4] : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="text-black" for="img">Imagen</label><br> <small class="text-danger" 
                                   for="img"></small>
                                    <input type="file" class="form-control" name="imagen" id="imagen">
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <a href="<?php echo URL_BASE; ?>administrador/productos.php/" class="btn btn-primary-hover-outline">Nuevo</a>
                            <button type="submit" class="btn btn-primary-hover-outline" name="btn_form" value="agregar">Agregar</button>
                            <button type="submit" class="btn btn-info-hover-outline" name="btn_form" value="actualizar">Actualizar</button>
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
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Valor unidad</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Opcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $color = "";
                                    $activar = 0;
                                    while ($resul = mysqli_fetch_array($result)) {
                                        if ($resul[6] == 0) {
                                            $color = "background-color: #e4cdce;";
                                            $activar = 1;
                                        } else {
                                            $color = "";
                                            $activar = 0;
                                        }
                                    ?>
                                        <tr style="<?php echo $color; ?>">
                                            <th scope="row"><?php echo $resul[0]; ?></th>
                                            <td><?php echo $resul[1]; ?></td>
                                            <td><?php echo $resul[4]; ?></td>
                                            <td><?php echo $resul[2]; ?></td>
                                            <td><?php echo $resul[3]; ?></td>
                                            <td class="product-thumbnail">
                                                <img src="<?php echo URL_BASE; ?>archivos/<?php echo $resul[5]; ?>" alt="Img" class="img-fluid" style="width: 70px;">
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo URL_BASE; ?>administrador/productos.php?accion=actualizar&cod_producto=<?php echo $resul[0]; ?>" title="Seleccionar para editar"><i class="bi bi-pencil text-success"></i></a>
                                                <?php
                                                if ($resul[6] == 1) { // Validamos el estado 0 => inactivo 1=> Activo
                                                ?>
                                                    <a href="<?php echo URL_BASE; ?>administrador/productos.php?accion=estado&estado=<?php echo $activar; ?>&cod_producto=<?php echo $resul[0]; ?>" title="Inactivar el producto"><i class="bi bi-trash text-danger"></i></a>
                                                <?php } else { ?>
                                                    <a href="<?php echo URL_BASE; ?>administrador/productos.php?accion=estado&estado=<?php echo $activar; ?>&cod_producto=<?php echo $resul[0]; ?>" title="Activar el producto"><i class="bi bi-check text-success"></i></a>
                                                <?php } ?>
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
// Aquí van los cambios para manejar el formulario y la inserción/actualización de productos
if (isset($_REQUEST['btn_form'])) {

    $btn = $_REQUEST["btn_form"];
    $codigo = $_REQUEST['codigo'];
    $nombre = $_REQUEST['nombre'];
    $valor_unidad = $_REQUEST['valor_unidad'];
    $cantidad = $_REQUEST['cantidad'];
    $descripcion = $_REQUEST['descripcion'];

    if ($btn == "nuevo") {
        echo "<script> location='productos.php'; </script>";
    }

    if ($btn == "agregar") {
        $imagen = $_FILES["imagen"];
        $nombreImagen = $imagen["name"];
        $tipo = $imagen["type"];
        $tamaño = $imagen["size"];
        $temp = $imagen["tmp_name"];
        $error = $imagen["error"];

        // Validar si hubo error en la subida de la imagen
        if ($error === 0) {
            // Definir el directorio destino y mover la imagen
            $directorio_destino = "../archivos/" . $nombreImagen;
            if (move_uploaded_file($temp, $directorio_destino)) {
                // Ingresar los datos a la base de datos
                $sql = "INSERT INTO productos (cod_producto, nom_producto, valor_unidad, cant_producto, desc_producto, imagen_producto, estado) 
                        VALUES (
                            $codigo, 
                            '$nombre', 
                            $valor_unidad, 
                            $cantidad, 
                            '$descripcion', 
                            '$nombreImagen', 
                            DEFAULT
                        );";

                // Verificar si la consulta fue exitosa
                if (mysqli_query($conexion, $sql)) {
                    echo "<script> alert('Se insertó correctamente');</script>";
                    echo "<script> location='productos.php'; </script>";
                } else {
                    echo "<script> alert('Error al insertar datos: " . mysqli_error($conexion) . "');</script>";
                }
            } else {
                echo "<script> alert('Error al mover la imagen al directorio.');</script>";
            }
        } else {
            echo "<script> alert('Hubo un error al cargar la imagen.');</script>";
        }
    }

    if ($btn == "actualizar") {
        // Código para actualizar
        $imagen = $_FILES["imagen"];
        $nombreImagen = $imagen["name"];
        $tipo = $imagen["type"];
        $tamaño = $imagen["size"];
        $temp = $imagen["tmp_name"];
        $error = $imagen["error"];

        $sqlImagen = "";
        if ($error === 0) {
            $directorio_destino = "../archivos/" . $nombreImagen;
            move_uploaded_file($temp, $directorio_destino);
            $sqlImagen = ", imagen_producto = '$nombreImagen'";
        }

        $sql = "UPDATE productos 
                SET nom_producto = '$nombre',
                    valor_unidad = $valor_unidad,
                    cant_producto = $cantidad,
                    desc_producto = '$descripcion'
                    $sqlImagen
                WHERE cod_producto = $codigo;";
        
        if (mysqli_query($conexion, $sql)) {
            echo "<script> alert('Se actualizó correctamente');</script>";
            echo "<script> location='productos.php'; </script>";
        } else {
            echo "<script> alert('Error al actualizar datos: " . mysqli_error($conexion) . "');</script>";
        }
    }
}
?>
























<!doctype html>
<html lang="es">

<head>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>ARTESANÍAS DE TEJIDOS ORTEGA</title>
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #f7f7f7;
        }
        .btn-custom {
            background-color: #28a745;
            color: #fff;
            border-radius: 50px;
            transition: background-color 0.3s, transform 0.2s;
        }
        .btn-custom:hover {
            background-color: #218838;
            color: #fff;
            transform: translateY(-2px);
        }
        .table thead th {
            background-color: #e9f7e9;
            text-transform: uppercase;
            font-weight: bold;
            color: #155724;
        }
        .total-compra {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }
        .form-control,
        .form-select {
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 10px;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: #218838;
            box-shadow: none;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <a href="inicio.php" class="btn btn-light mb-4">
            <i class="fas fa-arrow-left"></i> Regresar a inicio
        </a>

        <div class="hero p-5 bg-success text-white rounded">
            <h1>COMPRAR</h1>
        </div>

        <div class="row my-5">
            <!-- Detalles de Facturación -->
            <div class="col-md-6">
                <h2 class="h4 mb-3">Detalles de Facturación</h2>
                <div class="p-4 border bg-white rounded">
                    <form id="cartForm" action="pagar.php" method="POST">
                        <div class="mb-3">
                            <label for="ciudad" class="form-label">Ciudad <span class="text-danger">*</span></label>
                            <select id="ciudad" name="ciudad" class="form-select">
                                <option value="Neiva">Neiva</option>
                                <option value="Bogota">Bogota</option>
                                <option value="Cali">Cali</option>
                                <option value="Medellin">Medellin</option>
                                <option value="Hobo">Hobo</option>
                                <option value="Rivera">Rivera</option>
                                <option value="Campoalegre">Campoalegre</option>
                                  <!-- Más opciones... -->
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="primer_nombre" class="form-label">Primer nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="documento" class="form-label">Documento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="documento" name="documento" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">Correo <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="celular" class="form-label">Celular <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="celular" name="celular" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="observacion" class="form-label">Observaciones</label>
                            <textarea name="observacion" id="observacion" class="form-control" rows="3"></textarea>
                        </div>
                        <input type="hidden" name="cart_data" id="cart_data">
                        <button type="button" class="btn btn-success" id="buyCart">Comprar</button>
                    </form>
                </div>
            </div>

            <!-- Resumen del Pedido -->
            <div class="col-md-6">
                <h2 class="h4 mb-3">Su Pedido</h2>
                <table class="table" id="cartTable">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Productos del carrito -->
                    </tbody>
                </table>
                <div class="text-right mb-3">
                    <h3>Total a pagar: $<span id="cartTotal">0</span></h3>
                </div>
                <button class="btn btn-danger" id="clearCart">Vaciar carrito</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartTable = document.querySelector('#cartTable tbody');
            const buyCartButton = document.getElementById('buyCart');
            const cartTotalElement = document.getElementById('cartTotal');
            const cartDataInput = document.getElementById('cart_data');

            function displayCart() {
                cartTable.innerHTML = '';
                let total = 0;
                cart.forEach(product => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${product.name}</td>
                        <td>${product.quantity}</td>
                        <td>$${product.price.toLocaleString()}</td>
                        <td>$${(product.price * product.quantity).toLocaleString()}</td>
                    `;
                    cartTable.appendChild(row);
                    total += product.price * product.quantity;
                });
                cartTotalElement.textContent = total.toLocaleString();
            }

            function prepareDataForCheckout() {
                const cartData = cart.map(product => ({
                    name: product.name,
                    quantity: product.quantity,
                    price: product.price,
                    total: product.price * product.quantity
                }));
                cartDataInput.value = JSON.stringify(cartData);
            }

            buyCartButton.addEventListener('click', () => {
                prepareDataForCheckout();
                document.getElementById('cartForm').submit();
            });

            document.getElementById('clearCart').addEventListener('click', () => {
                cart = [];
                localStorage.setItem('cart', JSON.stringify(cart));
                displayCart();
            });

            displayCart();
        });
    </script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>