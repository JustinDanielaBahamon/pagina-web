<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$dbname = 'hamaca_mb';
$username = 'root';
$password = '';

$mensajeError = ''; // Inicializa la variable para evitar el aviso de "undefined"
$cart_data = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica que el carrito no esté vacío
    if (empty($cart_data)) {
        $mensajeError = "Tienes que elegir un producto.";
    } else {
        try {
            // Conectar a la base de datos
            $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Recoger datos del formulario
            $ciudad = $_POST['ciudad'];
            $primer_nombre = $_POST['primer_nombre'];
            $documento = $_POST['documento'];
            $direccion = $_POST['direccion'];
            $correo = $_POST['correo'];
            $celular = $_POST['celular'];
            $observacion = $_POST['observacion'];

            if (empty($ciudad) || empty($primer_nombre) || empty($documento) || empty($direccion) || empty($correo) || empty($celular)) {
                $mensajeError = "Por favor, completa todos los campos obligatorios.";
            } else {
                // Insertar datos en factura_detalle
                $stmt = $conn->prepare("INSERT INTO factura_detalle (cod_cliente, fecha_factura, observaciones, direccion)
                                        VALUES (:documento, NOW(), :observacion, :direccion)");
                $stmt->bindParam(':documento', $documento);
                $stmt->bindParam(':observacion', $observacion);
                $stmt->bindParam(':direccion', $direccion);
                $stmt->execute();

                // Obtener el último ID insertado
                $cod_factura = $conn->lastInsertId();

                // Insertar productos en la tabla facturas
                $stmt = $conn->prepare("INSERT INTO facturas (cod_factura, cod_producto, cantidad, valor_unitario, total)
                                        VALUES (:cod_factura, :cod_producto, :cantidad, :valor_unitario, :total)");

                foreach ($cart_data as $producto) {
                    $stmt->bindParam(':cod_factura', $cod_factura);
                    $stmt->bindParam(':cod_producto', $producto['name']);
                    $stmt->bindParam(':cantidad', $producto['quantity']);
                    $stmt->bindParam(':valor_unitario', $producto['price']);
                    $stmt->bindParam(':total', $producto['total']);
                    $stmt->execute();
                }

                // Redirige a gracias.php si todo es correcto
                header("Location: gracias.php");
                exit();
            }
        } catch (PDOException $e) {
            $mensajeError = "Error en la compra: " . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>ARTESANÍAS DE TEJIDOS ORTEGA - Comprar</title>
    <style>
        /* Estilos personalizados */
        body { font-family: 'Raleway', sans-serif; background-color: #f7f7f7; }
        .btn-custom { background-color: #28a745; color: #fff; border-radius: 50px; transition: background-color 0.3s, transform 0.2s; }
        .btn-custom:hover { background-color: #218838; color: #fff; transform: translateY(-2px); }
        .table thead th { background-color: #e9f7e9; text-transform: uppercase; font-weight: bold; color: #155724; }
        .total-compra { font-size: 1.5rem; font-weight: bold; color: #28a745; }
        .form-control, .form-select { border: 2px solid #28a745; border-radius: 8px; padding: 10px; }
        .form-control:focus, .form-select:focus { border-color: #218838; box-shadow: none; }
    </style>
</head>
<body>
    <div class="container my-5">
        <a href="inicio.php" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Regresar a inicio</a>
        <div class="hero p-5 bg-success text-white rounded">
            <h1>COMPRAR</h1>
        </div>

        <?php if ($mensajeError): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($mensajeError) ?></div>
        <?php endif; ?>

        <div class="alert alert-danger d-none" id="alertaCampos">Por favor, completa todos los campos obligatorios.</div>

        <div class="row my-5">
            <!-- Detalles de Facturación -->
            <div class="col-md-6">
                <h2 class="h4 mb-3">Detalles de Facturación</h2>
                <div class="p-4 border bg-white rounded">
                    <form id="cartForm" action="comprar.php" method="POST">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartTable = document.querySelector('#cartTable tbody');
        const buyCartButton = document.getElementById('buyCart');
        const cartTotalElement = document.getElementById('cartTotal');
        const cartDataInput = document.getElementById('cart_data');
        const alertaCampos = document.getElementById('alertaCampos');

        function displayCart() {
            cartTable.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan="4" class="text-center">No hay productos en el carrito.</td>`;
                cartTable.appendChild(row);
            } else {
                cart.forEach((product, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${product.name}</td>
                        <td>
                            <input type="number" value="${product.quantity}" min="1" class="form-control quantity-input" data-index="${index}">
                        </td>
                        <td>$${product.price.toLocaleString()}</td>
                        <td>$<span class="product-total">${(product.price * product.quantity).toLocaleString()}</span></td>
                    `;
                    cartTable.appendChild(row);
                    total += product.price * product.quantity;
                });
            }
            cartTotalElement.textContent = total.toLocaleString();
        }

        function updateCartTotal() {
            let total = 0;
            const quantityInputs = document.querySelectorAll('.quantity-input');

            quantityInputs.forEach(input => {
                const index = input.getAttribute('data-index');
                const quantity = parseInt(input.value);
                cart[index].quantity = quantity; // Actualiza la cantidad en el carrito
                const price = cart[index].price;
                const productTotal = quantity * price;
                total += productTotal;

                // Actualiza el total del producto en la tabla
                input.closest('tr').querySelector('.product-total').textContent = productTotal.toLocaleString();
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

        function validarCamposObligatorios() {
            const camposObligatorios = document.querySelectorAll('#cartForm [required]');
            for (let campo of camposObligatorios) {
                if (!campo.value.trim()) {
                    return false;
                }
            }
            return true;
        }

        buyCartButton.addEventListener('click', () => {
            if (validarCamposObligatorios()) {
                if (cart.length === 0) {
                    alertaCampos.textContent = "Tienes que elegir un producto.";
                    alertaCampos.classList.remove('d-none');
                } else {
                    alertaCampos.classList.add('d-none');
                    prepareDataForCheckout();
                    document.getElementById('cartForm').submit();
                }
            } else {
                alertaCampos.classList.remove('d-none');
            }
        });

        document.getElementById('clearCart').addEventListener('click', () => {
            cart = [];
            localStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
        });

        // Escuchar cambios en las cantidades
        cartTable.addEventListener('input', (event) => {
            if (event.target.classList.contains('quantity-input')) {
                updateCartTotal();
            }
        });

        displayCart();
    });
</script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
