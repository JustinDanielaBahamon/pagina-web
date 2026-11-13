
<?php
session_start();
include("./include/conexion.php");

$seleccionados = $_SESSION['seleccionados'];
$productos_buscar = "";

foreach ($seleccionados as $key => $value) {
    $productos_buscar .= $key . ",";
}

$sql = "select * from productos where cod_producto in (" . trim($productos_buscar, ",") . ");";
$result = mysqli_query($conexion, $sql);

?>

<!doctype html>
<html lang="es">

<head>
    

    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <title>ARTESANIAS DE TEJIDOS ORTEGA</title>
</head>

<body>
<!-- Footer fijo en la parte superior -->
<div id="top-footer" class="text-center py-2 fixed-top">
    <span id="footer-text">Llámanos al 3000000000</span>
</div>

<script>
    // Array de mensajes
    const messages = [
        'Llámanos al 3000000000',
        'Compra ahora: Envíos nacionales e internacionales',
        'Descubre nuestra variedad de hamacas hechas a mano',
        'Calidad garantizada en cada producto',
        'Visita nuestro sitio para más ofertas'
    ];

    let currentIndex = 0;

    function changeMessage() {
        // Cambia el texto al siguiente mensaje
        document.getElementById('footer-text').textContent = messages[currentIndex];

        // Incrementa el índice y reinicia si llega al final del array
        currentIndex = (currentIndex + 1) % messages.length;
    }

    // Cambia el mensaje cada 3 segundos (3000 ms)
    setInterval(changeMessage, 3000);
</script>

    

    <!-- Start Hero Section -->
    <div class="hero p-5">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Pagar</h1>
                    </div>
                </div>
                <div class="col-lg-7">

                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="untree_co-section">
        <div class="container">
            <form method="post">
                <div class="row">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <h2 class="h3 mb-3 text-black">Detalles de facturación</h2>
                        <div class="p-3 p-lg-5 border bg-white">
                            <div class="form-group">
                                <label for="ciudad" class="text-black">Ciudad <span class="text-danger">*</span></label>
                                <select id="ciudad" name="ciudad" class="form-control">
                                    <option value="Neiva">Neiva</option>
                                    <option value="Algeciras">Algeciras</option>
                                    <option value="Bogota">Bogota</option>
                                    <option value="Medellin">Medellin</option>
                                    <option value="Hobo">Hobo</option>
                                    <option value="Rivera">Rivera</option>
                                    <option value="Campoalegre">Campoalegre</option>
                                    <option value="Cali">Cali</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="primer_nombre" class="text-black">Primer nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="primer_nombre" name="primer_nombre">
                                </div>
                                <div class="col-md-6">
                                    <label for="segundo_nombre" class="text-black">Segundo nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="documento" class="text-black">Documento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="documento" name="documento">
                                </div>
                                <div class="col-md-8">
                                    <label for="direccion" class="text-black">Dirección <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección del envio">
                                </div>
                            </div>

                            <div class="form-group row mb-5">
                                <div class="col-md-6">
                                    <label for="correo" class="text-black">Correo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="correo" name="correo">
                                </div>
                                <div class="col-md-6">
                                    <label for="celular" class="text-black">Celular <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="celular" name="celular" placeholder="Numero de celular">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="observacion" class="text-black">Observaciones</label>
                                <textarea name="observacion" id="observacion" cols="30" rows="5" class="form-control" placeholder="Escribe tus observaciones aqui..."></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
    <div class="row mb-5">
        <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">Su pedido</h2>
            <div class="p-3 p-lg-5 border bg-white">
                <table class="table site-block-order-table mb-5">
                    <thead>
                        <th>Producto</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        $totalCompra = 0;

                        // Asegúrate de que $result sea válido antes de usarlo
                        if ($result) {
                            while ($resul = mysqli_fetch_array($result)) {
                                $total = $resul[2] * $_SESSION['seleccionados'][$resul[0]];
                                $totalCompra += $total;
                        ?>
                                <tr>
                                    <td><?php echo $resul[1] ?> <strong class="mx-2">x</strong> <?php echo $_SESSION['seleccionados'][$resul[0]]; ?></td>
                                    <td>$<?php echo number_format(($total), 2) ?></td>
                                </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='2'>Error en la consulta: " . mysqli_error($conexion) . "</td></tr>";
                        }
                        ?>
                        <tr>
                            <td class="text-black font-weight-bold"><strong>Total compra</strong></td>
                            <td class="text-black font-weight-bold"><strong>$<?php echo number_format(($totalCompra), 2) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <button type="submit" class="btn btn-black btn-lg py-3 btn-block" name="btn_pagar" value="comprar">Realizar compra</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_REQUEST['btn_pagar'])) {
    if ($_REQUEST['btn_pagar'] == 'comprar') {
        $ciudad = $_REQUEST['ciudad'];
        $nombre = $_REQUEST['primer_nombre'];
        $apellido = $_REQUEST['segundo_nombre'];
        $documento = $_REQUEST['documento'];
        $direccion = $_REQUEST['direccion'];
        $correo = $_REQUEST['correo'];
        $telefono = $_REQUEST['celular'];
        $observacion = $_REQUEST['observacion'];

        // Insertar en la tabla clientes
        $sql = "INSERT INTO clientes VALUES (DEFAULT, '$nombre', '$apellido', '$documento', '$telefono', '$correo', '$ciudad');";
        if (!mysqli_query($conexion, $sql)) {
            die("Error al insertar cliente: " . mysqli_error($conexion));
        }

        // Obtener el último código de cliente
        $sql = "SELECT MAX(cod_cliente) FROM clientes";
        $cs = mysqli_query($conexion, $sql);
        if (!$cs) {
            die("Error al obtener el código de cliente: " . mysqli_error($conexion));
        }

        $cod_max = mysqli_fetch_array($cs)[0];

        // Insertar en la tabla factura
        $sql = "INSERT INTO factura VALUES (DEFAULT, $cod_max, NOW(), $totalCompra, '$observacion', '$direccion');";
        if (!mysqli_query($conexion, $sql)) {
            die("Error al insertar factura: " . mysqli_error($conexion));
        }

        // Obtener el último código de factura
        $sql = "SELECT MAX(cod_factura) FROM factura";
        $cs = mysqli_query($conexion, $sql);
        if (!$cs) {
            die("Error al obtener el código de factura: " . mysqli_error($conexion));
        }

        $cod_fac = mysqli_fetch_array($cs)[0];

        // Consultar productos seleccionados
        $sql = "SELECT * FROM productos WHERE cod_producto IN (" . trim($productos_buscar, ",") . ");";
        $result = mysqli_query($conexion, $sql);
        if (!$result) {
            die("Error en la consulta de productos: " . mysqli_error($conexion));
        }

        // Insertar en la tabla factura_detalle
        while ($resul = mysqli_fetch_array($result)) {
            $total = $resul[2] * $_SESSION['seleccionados'][$resul[0]];
            $sql = "INSERT INTO factura_detalle VALUES (DEFAULT, $cod_fac, " . $resul[0] . ", " . $_SESSION['seleccionados'][$resul[0]] . ", " . $resul[2] . ", " . $total . ");";
            if (!mysqli_query($conexion, $sql)) {
                die("Error al insertar detalle de factura: " . mysqli_error($conexion));
            }
        }

        unset($_SESSION['seleccionados']);
        echo "<script> alert('Compra realizada');</script>";
        echo "<script> location='gracias.php?modulo=tienda'; </script>";
    }
}

$productos_buscar = "";

// Verifica si hay productos seleccionados en la sesión
if (!empty($_SESSION['seleccionados'])) {
    foreach ($_SESSION['seleccionados'] as $key => $value) {
        $productos_buscar .= $key . ",";
    }
}

// Elimina la última coma y prepara la consulta si hay productos
if ($productos_buscar !== "") {
    $productos_buscar = trim($productos_buscar, ",");
    $sql = "SELECT * FROM productos WHERE cod_producto IN ($productos_buscar);";
    $result = mysqli_query($conexion, $sql);
} else {
    // Manejar el caso cuando no hay productos seleccionados
    echo "<script>alert('No hay productos seleccionados.');</script>";
    exit; // O redirigir a otra página
}

?>



<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tiny-slider.js"></script>
<script src="../js/custom.js"></script>
</body>
</html>
