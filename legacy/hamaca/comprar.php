<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="slider1.css">
    <link rel="stylesheet" href="footer.css">   
    <link rel="stylesheet" href="style.css">
    <script src="comprar.js"></script>
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

<!-- NAV Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="../page/Inicio.php">
            <img src="img/LOGO HAMACAS.jpg" alt="Logo" style="width: 150px; height: auto;">
        </a>

        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" href="./Inicio.php"><b>INICIO</b></a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><b>PRODUCTOS</b></a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="./hamacas.php">HAMACAS</a></li>
                    <li><a class="dropdown-item" href="./sillas_colgantes.php">SILLAS COLGANTES</a></li>
                    <li><a class="dropdown-item" href="./columpio.php">COLUMPIO</a></li>
                    <li><a class="dropdown-item" href="./cuna.php">CUNA</a></li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link active" href="./nosotros.php"><b>NOSOTROS</b></a></li>
            <li class="nav-item"><a class="nav-link active" href="./contactos.php"><b>CONTACTOS</b></a></li>
            <li class="nav-item"><a class="nav-link" href="./login.php"><img src="img/logo inicio.png" alt="Login" style="width: 30px; height: auto;"></a></li>
            <li class="nav-item">
                <a class="nav-link" href="./comprar.php" title="Ver carrito">
                    <img src="img/carrito.jpeg" alt="comprar" style="width: 30px; height: auto;">
                    <span class="badge bg-danger" id="cart-count">0</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1>Carrito de Compras</h1>
    <table class="table" id="cartTable">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Productos añadidos al carrito se mostrarán aquí -->
        </tbody>
    </table>
    
    <button class="btn btn-danger" id="clearCart">Vaciar carrito</button>
    <a href="./pagar.php" class="btn btn-success" id="buyCart">Comprar</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartTable = document.querySelector('#cartTable tbody');
        const clearCartButton = document.getElementById('clearCart');

        // Mostrar productos en el carrito
        function displayCart() {
            cartTable.innerHTML = ''; // Limpiar tabla
            let total = 0;

            cart.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.name}</td>
                    <td>${product.quantity}</td>
                    <td>$${product.price.toLocaleString()}</td>
                    <td>$${(product.price * product.quantity).toLocaleString()}</td>
                    <td><button class="btn btn-sm btn-danger remove-item" data-name="${product.name}">Eliminar</button></td>
                `;
                cartTable.appendChild(row);

                total += product.price * product.quantity;
            });

            // Si el carrito está vacío
            if (cart.length === 0) {
                const emptyRow = document.createElement('tr');
                emptyRow.innerHTML = '<td colspan="5" class="text-center">No hay productos en el carrito</td>';
                cartTable.appendChild(emptyRow);
            }

            // Evento para eliminar un producto
            const removeButtons = document.querySelectorAll('.remove-item');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productName = this.getAttribute('data-name');
                    cart = cart.filter(product => product.name !== productName);
                    localStorage.setItem('cart', JSON.stringify(cart));
                    displayCart();
                });
            });

            // Actualizar conteo del carrito
            document.getElementById('cart-count').textContent = cart.length;
        }

        // Vaciar el carrito
        clearCartButton.addEventListener('click', function() {
            localStorage.removeItem('cart');
            cart = [];
            displayCart();
        });

        displayCart(); // Mostrar el carrito al cargar la página
    });

    // Añadir evento para añadir productos al carrito
    function addToCart(name, price) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingProduct = cart.find(product => product.name === name);

        if (existingProduct) {
            existingProduct.quantity += 1; // Si ya existe, aumenta la cantidad
        } else {
            cart.push({ name, price, quantity: 1 }); // Añade nuevo producto
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${name} añadido al carrito`);
        document.getElementById('cart-count').textContent = cart.length; // Actualizar conteo del carrito
    }
</script>

</body>
</html>

